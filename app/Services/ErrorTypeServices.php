<?php

namespace App\Services;

use App\Models\ErrorType;
use App\Models\Parteners;
use App\Models\Plateforme;
use App\Models\Profils;
use App\Models\SousServices;
use App\Models\Users;
use App\Services\Helpers\Mail\MailSenderService;
use App\Services\Helpers\Utils;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ErrorTypeServices
{

   public function indexPaginate(){
       $query =  ErrorType::query();
       if(request('date_start')){
           $query->where('created_at','>=',dateFilterStart(request('date_start')));
       }
       if(request('date_end')){
           $query->where('created_at','<=',dateFilterEnd(request('date_end')));
       }
       $query->orderBy('id','DESC');
       return  $query->paginate(size());
   }
   public function getErrorType(int $id){
      return ErrorType::find($id);
   }
   public function getSousServices(){
      return SousServices::all();
   }
   public function store(Request $request){
       $password = Utils::generateKey();
       $data = $request->validate(Utils::getRuleModel(new ErrorType()));
       $user = ErrorType::create($data);
       return redirect('/error_type')->with('success','Le type d\'erreur ajouter avec succès');
   }

   public function update(int $id ,Request $request){
       $errorType = ErrorType::find($id);
       $data = $request->validate(Utils::getRuleModel(new ErrorType(),$errorType->id,$request->all()));
       $errorType->update($data);
       return redirect('/error_type')->with('success','Le type d\'erreur mise a jour avec succès');
   }
}
