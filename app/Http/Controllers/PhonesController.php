<?php

namespace App\Http\Controllers;

use App\Models\OperationParteners;
use App\Models\OperationPhones;
use App\Models\Parteners;
use App\Models\Phones;
use App\Models\SousServices;
use App\Models\SousServicesPhones;
use App\Models\Transactions;
use App\Services\ConfigServices;
use App\Services\Helpers\Utils;
use App\Services\PhonesServices;
use App\Services\TransactionServices;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\DB;

class PhonesController extends Controller
{
    public string $title = 'Providers';
    public string $subTitle = 'Donne la listes des Providers ';
   private  PhonesServices $phonesServices;
   private  ConfigServices $configServices;

    /**
     * @param PhonesServices $phones Services
     */
    public function __construct(PhonesServices $phonesServices,ConfigServices $configServices)
    {
        $this->phonesServices = $phonesServices;
        $this->configServices = $configServices;
    }

    public function index(): Factory|View|Application
    {
        $phones = $this->phonesServices->paginate();
        $date_start= request('date_start');
        $date_end= request('date_end');
        $amount_min = request('amount_min');
        $amount_max = request('amount_max');
        $number = request('number');
        return view('pages/phones.index',compact('number','phones','amount_min','amount_max','date_end','date_start',));
    }
    public function create(): Factory|View|Application
    {
        $services= $this->configServices->servicesPlate();
        return view('pages.phones.phone-add',compact('services'));
    }
    public function edit( $id): Factory|View|Application
    {
        $phones = Phones::find($id);
        $services= $this->configServices->servicesPlate();
        return view('pages.phones.phone-edit',compact('phones','services'));
    }


    public function store(Request $request): Redirector|Application|\Illuminate\Http\RedirectResponse
    {
        DB::beginTransaction();
        $request->validate(Utils::getRuleModel(new Phones()));
        $data= $request->only(['number','codeSecret']);
        $sousServices = SousServices::query()->find(id:request('_sous_services_id'));
        $data['services_id'] = $sousServices->services_id;
        $phoneServices = Phones::query()->where('number',$data['number'])->get();
        $sousServicesPhones = SousServicesPhones::query()
            ->where('sous_services_id',$sousServices->id)
            ->whereIn('phones_id',$phoneServices->map(fn($ps)=> $ps->id))
            ->first();
        if(@$sousServicesPhones){
            return   redirect()->back()->with('error',"Le sous services $sousServices->name est deja configuré avec le numéro ". $data['number']);
        }
        $phones =  Phones::create($data);
        SousServicesPhones::create(['sous_services_id'=> $sousServices->id,'phones_id'=>$phones->id]);
        DB::commit();
        return redirect('/phones')->with('success','Services provider ajouter avec succès');
    }
    public function versement( $id)
    {
        $phones = Phones::find($id);
        if(!@$phones->sousServicesPhones[0]){
            return  redirect()->back()->with('error','Vous ne pouvez pas effectué de versement.  Pas de sous Services configuré!!!');
        }
        return view('pages.phones.phone-verser',compact('phones'));
    }
    public function versementSave($id,Request $request): Redirector|Application|\Illuminate\Http\RedirectResponse
    {
        DB::beginTransaction();
        $phones = Phones::find($id);
        $request->validate([
            'amount' =>"required|integer|min:1000|required_with:amount_confirm|same:amount_confirm",
            'amount_confirm' => 'required|integer|min:1000',
        ]);
        $amount =(float) $request->get('amount');
        updateSolde($phones,$amount,'solde');
        updateSolde($phones,$amount,'solde_api');
        $phones = Phones::find($id);
        $data = [
            'amount'=>(float)$amount,
            'type_operation'=>TYPE_OPERATION['CREDIT'],
            'statut'=>STATUS_TRX['SUCCESS'],
            'date_creation'=>nowIso(),
            'date_success'=>nowIso(),
            'date_processing'=>nowIso(),
            'operation'=>OPERATIONS_PHONES['APPROVISIONNEMENT'],
            'solde_before'=>$phones->solde,
            'solde_after'=>$phones->solde + $amount,
            'fee'=>0,
            'commission'=>0,
            'fee_owner'=>0,
            'commission_owner'=>0,
            'phones_id'=>$phones->id,
            'users_id'=>_auth()->id,

        ];
        OperationPhones::create($data);
        DB::commit();
        return redirect('/phones')->with('success','Versement vers le services est effectué avec succès');
    }
    public function update($id,Request $request): Redirector|Application|\Illuminate\Http\RedirectResponse
    {
        DB::beginTransaction();
        $phones = Phones::find($id);
        $request->validate(Utils::getRuleModel(new Phones(),$phones->id,$request->all()));
        $data= $request->only(['number','codeSecret']);

        //check
        $sousServices = SousServices::query()->find(id:request('_sous_services_id'));
        $data['services_id'] = $sousServices->services_id;
        $phoneServices = Phones::query()->where('number',$data['number'])->where('id','<>',$phones->id)->get();
        $sousServicesPhones = SousServicesPhones::query()
            ->where('sous_services_id',$sousServices->id)
            ->whereIn('phones_id',$phoneServices->map(fn($ps)=> $ps->id))
            ->first();
        if(@$sousServicesPhones){
            return   redirect()->back()->with('error',"Le sous services $sousServices->name est deja configuré avec le numéro ". $data['number']);
        }
        //check
        $phones->update($data);
        SousServicesPhones::query()->where('sous_services_id', $sousServices->id)->where('phones_id',$phones->id)->delete();
        SousServicesPhones::create(['sous_services_id'=> $sousServices->id,'phones_id'=>$phones->id]);
       // DB::commit();
        return redirect('/phones/?number='.$phones->number)->with('success','Le service provider est mise a jour avec succès');
    }

}
