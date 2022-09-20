<?php

namespace App\Services;

use App\Models\Parteners;
use App\Models\Plateforme;
use App\Models\Profils;
use App\Models\Users;
use App\Services\Helpers\Mail\MailSenderService;
use App\Services\Helpers\Utils;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserServices
{
    private  MailSenderService $mailSenderService;



    public function __construct(MailSenderService $mailSenderService)
    {
        $this->mailSenderService = $mailSenderService;
    }
   public function indexPaginate(){
       $query =  Users::query();
       if(request('date_start')){
           $query->where('created_at','>=',dateFilterStart(request('date_start')));
       }
       if(request('date_end')){
           $query->where('created_at','<=',dateFilterEnd(request('date_end')));
       }
       return  $query->orderBy('id','DESC')->paginate(size());
   }
   public function getUser(int $id){
      return Users::find($id);
   }
   public function getProfils(){
      return Profils::all();
   }
   public function store(Request $request){
       $password = Utils::generateKey();
       $data = $request->validate(Utils::getRuleModel(new Users()));
       $data['password']= $password['hash'];
       $data['code']= uniqid();
       $data['plateforme_id']= Plateforme::where('code','ADMIN')->first()->id;
       $user = Users::create($data);
       $user->password= $password['password'];
       $this->mailSenderService->sendUserBackofficeCreated($user->toArray());
       return redirect('/users')->with('success','Utilisateur ajouter avec succès');
   }

   public function update(int $id ,Request $request){
       $user = Users::find($id);
       $request->validate(Utils::getRuleModel(new Users(),$user->id,$request->all()));
       $data= $request->only(['phone','profils_id','f_name','l_name','address','email']);
       $user->update($data);
       return redirect('/users')->with('success','Utilisateur mise a jour avec succès');
   }

    public function account(Request $request)
    {
        $user = _auth();
        $request->validate(Utils::getRuleModel(new Users(),$user->id,$request->all()));
        $data= $request->only(['phone','profils_id','f_name','l_name','address']);
        $user->update($data);
        return redirect('/profil')->with('success','Infos utilisateur changer avec succès');
    }
    public function password(Request $request)
    {
        $user = _auth();
        if(!Hash::check($request->get('password_old'),$user->password)){
            return  redirect()->back(302)->with('error',"L'ancien mot de passe n'est est incorrect");
        }
        $validated  =$request->validate([
            'password' =>'required|min:8|same:confirm_password',
            'confirm_password' =>'required|min:8',
            'password_old' =>'required',
        ],$request->all());

        $user->update(['password' => Hash::make($validated['password'])]);
        return redirect('/profil')->with('success','Mot de passe utilisateur a changé avec succès');
    }
}
