<?php

namespace App\Services;

use App\Models\OperationParteners;
use App\Models\OperationPhones;
use App\Models\Transactions;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Http;

class TransactionServices
{
    public function paginate(): LengthAwarePaginator
    {
      //  dd(request('sous_services_id'));
        $transactions = Transactions::query()->orderBy('id','DESC');

        if(getTypeOperation()){
            $transactions->where('type_operation',getTypeOperation());
        }
        if(getPartnerI()){
            $transactions->where('parteners_id',getPartnerI());
        }
        if(request('statut')){
            $transactions->where(STATUS_TRX_NAME,request('statut'));
        }
        if(request('date_start')){
            $transactions->where('created_at','>=',dateFilterStart(request('date_start')));
        }
        if(request('date_end')){
            $transactions->where('created_at','<=',dateFilterEnd(request('date_end')));
        }
        if(getSousServiceId()){
            $transactions->where('sous_services_id','=',getSousServiceId());
        }
        if(request('external_transaction_id')){
            $transactions->where('external_transaction_id','like',"%".request('external_transaction_id') . "%");
        }
        if(request('phone')){
            $transactions->where('phone','like',"%".request('phone')."%");
        }
        if(request('amount_max')){
            $transactions->where('amount','<=',request('amount_max'));
        }
        if(request('amount_min')){
            $transactions->where('amount','>=',request('amount_min'));
        }

        return $transactions->paginate(size());
    }


    public function status(): array
    {
        return array_keys(STATUS);
    }
    public function versementPaginate(): LengthAwarePaginator
    {
       $query =  OperationParteners::query()->where('operation',OPERATIONS_PARTNERS['APROVISIONNEMENT']);
        if(getPartnerI()){
            $query->where('parteners_id',getPartnerI());
        }
        if(request('amount_max')){
            $query->where('amount','<=',request('amount_max'));
        }
        if(request('amount_min')){
            $query->where('amount','>=',request('amount_min'));
        }
        if(request('date_start')){
            $query->where('created_at','>=',dateFilterStart(request('date_start')));
        }
        if(request('date_end')){
            $query->where('created_at','<=',dateFilterEnd(request('date_end')));
        }
       return  $query->orderBy('id','DESC')->paginate(size());
    }
    public function versementPaginatePhones(): LengthAwarePaginator
    {
       $query =  OperationPhones::query()->where('operation',OPERATIONS_PHONES['APPROVISIONNEMENT']);
        if(request('phones_id')){
            $query->where('phones_id',request('phones_id'));
        }
        if(request('amount_max')){
            $query->where('amount','<=',request('amount_max'));
        }
        if(request('amount_min')){
            $query->where('amount','>=',request('amount_min'));
        }
        if(request('date_start')){
            $query->where('created_at','>=',dateFilterStart(request('date_start')));
        }
        if(request('date_end')){
            $query->where('created_at','<=',dateFilterEnd(request('date_end')));
        }
       return  $query->orderBy('id','DESC')->paginate(size());
    }

    public function mouvements(): LengthAwarePaginator
    {
        $query =  OperationParteners::query();
        if(getPartnerI()){
            $query->where('parteners_id',getPartnerI());
        }
        if(request('amount_max')){
            $query->where('amount','<=',request('amount_max'));
        }
        if(request('amount_min')){
            $query->where('amount','>=',request('amount_min'));
        }
        if(request('date_start')){
            $query->where('created_at','>=',dateFilterStart(request('date_start')));
        }
        if(request('date_end')){
            $query->where('created_at','<=',dateFilterEnd(request('date_end')));
        }
        if(getOperation()){
            $query->where('operation',getOperation());
        }
        if(getTypeOperation()){
            $query->where('type_operation',getTypeOperation());
        }
        return  $query->orderBy('id','DESC')->paginate(size());
    }
    public function mouvementsPhones(): LengthAwarePaginator
    {
        $query =  OperationPhones::query();
        if(request('phones_id')){
            $query->where('phones_id',request('phones_id'));
        }
        if(request('amount_max')){
            $query->where('amount','<=',request('amount_max'));
        }
        if(request('amount_min')){
            $query->where('amount','>=',request('amount_min'));
        }
        if(request('date_start')){
            $query->where('created_at','>=',dateFilterStart(request('date_start')));
        }
        if(request('date_end')){
            $query->where('created_at','<=',dateFilterEnd(request('date_end')));
        }
        if(getOperation()){
            $query->where('operation',getOperation());
        }
        if(getTypeOperation()){
            $query->where('type_operation',getTypeOperation());
        }
        return  $query->orderBy('id','DESC')->paginate(size());
    }
    public function reFund(Transactions $transaction): \Illuminate\Http\RedirectResponse
    {
        $uri = "external/transaction/refund/". $transaction->id;
        $rest = Http::get(env('API_DIGITAL_URL'),[
            'headers' => ['keys'=>env('SECRETE_API_DIGITAL')]
        ]);
        if($rest->status() === 200){
            return redirect()->back()->with('success','Transaction rembourser avec success');
        }else{
            return redirect()->back()->with('error','Erreur lors du remboursement de la Transaction.');
        }
        //dump($rest->status());
       // dd($rest->body());
    }

}
