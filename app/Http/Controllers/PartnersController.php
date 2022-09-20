<?php

namespace App\Http\Controllers;

use App\Models\OperationParteners;
use App\Models\Parteners;
use App\Services\Helpers\Mail\MailSenderService;
use App\Services\Helpers\Utils;
use App\Services\PartnersServices;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PartnersController
{
    private  MailSenderService $mailSenderService;


    public PartnersServices $partnersServices;

    public function __construct(PartnersServices $partnersServices,MailSenderService $mailSenderService)
    {
        $this->partnersServices = $partnersServices;
        $this->mailSenderService = $mailSenderService;
    }
    public function index(): Factory|View|Application
    {
        $partners = $this->partnersServices->partnersPaginate();
        $date_start= request('date_start');
        $date_end= request('date_end');
        return view('pages.partners.partners',compact('partners','date_end','date_start',));
    }
    public function create(): Factory|View|Application
    {
        return view('pages.partners.partners-add');
    }
    public function edit( $id): Factory|View|Application
    {
        $partners = Parteners::find($id);
        return view('pages.partners.partners-edit',compact('partners'));
    }


    public function store(Request $request): Redirector|Application|\Illuminate\Http\RedirectResponse
    {
        $request->validate(Utils::getRuleModel(new Parteners()));
        $password = Utils::generateKey();
        $data= $request->only(['name','phone','email','adress']);
        $data['password'] = $password['hash'];
        $partner =  Parteners::create($data);
        $partner->password = $password['password'];
        $this->mailSenderService->sendPartnerCreated($partner->toArray());
        return redirect('/partners')->with('success','Partenaire ajouter avec succès');
    }
    public function versement( $id): Factory|View|Application
    {
        $partners = Parteners::find($id);
        return view('pages.partners.partners-verser',compact('partners'));
    }
    public function versementSave($id,Request $request): Redirector|Application|\Illuminate\Http\RedirectResponse
    {
        DB::beginTransaction();
        $partners = Parteners::find($id);
        $request->validate([
            'amount' =>"required|integer|min:1000|required_with:amount_confirm|same:amount_confirm",
            'amount_confirm' => 'required|integer|min:1000',
            'attachment_path' => 'required|mimes:pdf,docx,doc|max:20048',
        ]);
        $amount =(float) $request->get('amount');
        updateSolde($partners,$amount,'solde');
        $partners = Parteners::find($id);
        $data = [
         'amount'=>(float)$amount,
            'type_operation'=>TYPE_OPERATION['CREDIT'],
            'statut'=>STATUS_TRX['SUCCESS'],
            'date_creation'=>nowIso(),
            'date_success'=>nowIso(),
            'date_processing'=>nowIso(),
            'operation'=>OPERATIONS_PARTNERS['APROVISIONNEMENT'],
            'solde_befor'=>$partners->solde,
            'solde_after'=>$partners->solde + $amount,
            'fee'=>0,
            'commission'=>0,
            'fee_owner'=>0,
            'commission_owner'=>0,
            'parteners_id'=>$partners->id,
            'users_id'=>_auth()->id,

        ];
        $operationPartner =OperationParteners::create($data);
        $operationPartner->attachment_path =  saveFile($request->file('attachment_path'),"versement/$partners->id");
        $operationPartner->save();
        DB::commit();
        $this->mailSenderService->versementPartenaire($partners->toArray(),$amount);
        return redirect('/partners')->with('success','Versement Partenaire effectué avec succès');
    }
    public function update($id,Request $request): Redirector|Application|\Illuminate\Http\RedirectResponse
    {
        $partners = Parteners::find($id);
        $request->validate(Utils::getRuleModel(new Parteners(),$partners->id,$request->all()));
        $data= $request->only(['name','phone','email','adress']);
        $partners->update($data);
        return redirect('/partners')->with('success','Partenaire mise a jour avec succès');
    }
    public function callFund( $id): Factory|View|Application
    {
        $partners = Parteners::find($id);
        return view('pages.partners.partners-callfund',compact('partners'));
    }
    public function callFundSave($id,Request $request)
    {
        //return (readFileHelper( saveFile($request->file('attachment_path'),"callfund/1")));
        DB::beginTransaction();
        $partners = Parteners::find($id);
        $request->validate([
            'amount' =>"required|integer|min:1000|required_with:amount_confirm|same:amount_confirm",
            'amount_confirm' => 'required|integer|min:1000',
            'attachment_path' => 'required|mimes:pdf,docx,doc|max:20048',
        ]);
        $amount =(float) $request->get('amount');
        if($amount > floatval($partners->solde)){
            return redirect()->back(302)->with('error','Le solde du partenaire est insuffisant');
        }
        updateSolde($partners,-$amount,'solde');
        $partners = Parteners::find($id);
        $data = [
            'amount'=> -(float)$amount,
            'type_operation'=>TYPE_OPERATION['DEBIT'],
            'statut'=>STATUS_TRX['SUCCESS'],
            'date_creation'=>nowIso(),
            'date_success'=>nowIso(),
            'date_processing'=>nowIso(),
            'operation'=>OPERATIONS_PARTNERS['APPEL_DE_FOND'],
            'solde_befor'=>$partners->solde,
            'solde_after'=>$partners->solde - $amount,
            'fee'=>0,
            'commission'=>0,
            'fee_owner'=>0,
            'commission_owner'=>0,
            'parteners_id'=>$partners->id,
            'users_id'=>_auth()->id,

        ];
        $operationPartner = OperationParteners::create($data);
        $operationPartner->attachment_path =  saveFile($request->file('attachment_path'),"callfund/$partners->id");
        $operationPartner->save();
        DB::commit();
        $this->mailSenderService->appelFondPartenaire($partners->toArray(),$amount);
        return redirect('/partners')->with('success','Appel de fonds Partenaire effectué avec succès');
    }
}
