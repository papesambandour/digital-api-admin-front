<?php

namespace App\Services;

use App\Models\OperationParteners;
use App\Models\OperationPhones;
use App\Models\Transactions;
use App\Services\Helpers\Utils;
use Exception;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
        if(count(request('statut',[]))){
            $transactions->whereIn(STATUS_TRX_NAME,request('statut'));
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
        if(request('search_in_any_id_transaction')){
            $transactions->where(function ($query)  {
                $query
                    ->where('external_transaction_id','like',"%".request('search_in_any_id_transaction') . "%")
                    ->orWhere('id','like',"%".request('search_in_any_id_transaction') . "%")
                    ->orWhere('transaction_id','like',"%".request('search_in_any_id_transaction') . "%")
                    ->orWhere('sous_service_transaction_id','like',"%".request('search_in_any_id_transaction') . "%")
                ;
            });
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
        $transactions->orderBy('id','DESC');
        if(isExportExcel()){
            die (exportExcel(mappingExportTransaction($transactions->get())));
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
        $query->orderBy('id','DESC');
        if(isExportExcel()){
            die (exportExcel(mappingExportVersement($query->get())));
        }
       return  $query->paginate(size());
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
        $query->orderBy('id','DESC');
        if(isExportExcel()){
            die (exportExcel(mappingExportVersementPhones($query->get())));
        }
       return  $query->paginate(size());
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
        $query->orderBy('id','DESC');
        if(isExportExcel()){
            die (exportExcel(mappingExportVersement($query->get())));
        }
        return  $query->paginate(size());
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
        $query->orderBy('id','DESC');
        if(isExportExcel()){
            die (exportExcel(mappingExportVersementPhones($query->get())));
        }
        return  $query->paginate(size());
    }
    public function reFund(Transactions $transaction)
    {
       // return redirect()->back()->with('success','Transaction rembourser avec success');
        if(checkRefundable($transaction)   ){
            $rest = Http::withHeaders([
                'apikey'=>env('SECRETE_API_DIGITAL')
            ])->post(env('API_DIGITAL_URL') . '/api/v1.0/partner/transaction/refund',
                ['transactionId'=>$transaction->id]
            );
            $resBody = (array) $rest->object();
            if($rest->status() === 201 && $resBody['statutTreatment'] === STATUS_TRX['SUCCESS']){
                return redirect()->back()->with('success','Transaction rembourser avec success. Message : '. $resBody['message']);
            }else{
                return redirect()->back()->with('error','Erreur lors du remboursement de la Transaction. Message : '. $resBody['message']);
            }
        }
        return redirect()->back()->with('error','La transaction n\'est pas remboursable');

        //dump($rest->status());
       // dd($rest->body());
    }

    public function getBankImported()
    {
        DB::beginTransaction();
        $transationQueryery = Transactions::query()
            ->where('statut',STATUS_TRX['PROCESSING'])
            ->where('code_sous_service',CODE_VIREMENT_BANK)
            ->where('import_bank',0);
        $transactions = clone($transationQueryery) ->get();
        $transationQueryery->update([
            'import_bank'=>1,
            'import_bank_at'=> nowIso(),
            'export_batch_id'=>Utils::GUID(),
//            'user_export'=>_auth()->id,
//            'user_import'=>_auth()->id,
        ]);
        $transactions = $transactions->map(function($transaction){
            /**
             * @var Transactions $transaction
             */
            return [
                'RIB'=> (string)$transaction->rib ?: "",
                'Nom'=> "$transaction->customer_first_name $transaction->customer_last_name" ,
                'Adresse 1'=> '',
                'Adresse 2'=> '',
                'Adresse 3'=> '',
                'Motif'=> "Virement TR#$transaction->id pour $transaction->partener_name pour $transaction->customer_first_name $transaction->customer_last_name",
                'Montant'=> floor($transaction->amount),
                "Transaction ID" => "$transaction->id",
                "Statut" => "",
                "Reason"=> ""
            ];
         })->toArray();
        if(!count($transactions)){
           throw new Exception("Pas de transaction en cours");
        }
        //TODO UNCOMMENT DB::commit();
        DB::commit();
        return $transactions;

    }

    public function importTransaction(Request $request): JsonResponse|array
    {
        $rest = Http::withHeaders([
            'apikey'=>env('SECRETE_API_DIGITAL')
        ])->post(env('API_DIGITAL_URL') . '/api/v1.0/partner/transaction/import_bank_transfer',
         $request->get('trx')
        );
        if($rest->status() === 201){
            return Utils::respond('updated',$rest->object());
        }else{
            return Utils::respond('error',$rest->object());
        }
    }
    public function setSuccessTransaction( Transactions $transaction,string $message)
    {
       // return redirect()->back()->with('success','Transaction validé avec success');
        if(checkFailableOrSuccessable($transaction)  ){
            $rest = Http::withHeaders([
                'apikey'=>env('SECRETE_API_DIGITAL')
            ])->post(env('API_DIGITAL_URL') . '/api/v1.0/partner/transaction/set-success',
                ['id'=>$transaction->id, 'message'=>$message]
            );
            $resBody = (array) $rest->object();
            if($rest->status() === 201 && $resBody['id']){
                return redirect()->back()->with('success','Transaction validé avec success. Message : '. $resBody['messageTreatment']);
            }else{
                return redirect()->back()->with('error','Erreur lors de la validation de la Transaction.');
            }
        }
        return  redirect()->back()->with('error','La Transaction ne peut pas être validé.');
    }
    public function setFailTransaction( Transactions $transaction,string $message)
    {
        //return redirect()->back()->with('success','Transaction annuler avec success');

        if(checkFailableOrSuccessable($transaction)  ){
            $rest = Http::withHeaders([
                'apikey'=>env('SECRETE_API_DIGITAL')
            ])->post(env('API_DIGITAL_URL') . '/api/v1.0/partner/transaction/set-failed',
                ['id'=>$transaction->id, 'message'=>$message]
            );
            $resBody = (array) $rest->object();
            if($rest->status() === 201 && $resBody['id']){
                return redirect()->back()->with('success','Transaction annuler avec success. Message : '. $resBody['messageTreatment']);
            }else{
                return redirect()->back()->with('error','Erreur lors de l\'annulation de la Transaction. Message : '. $resBody['messageTreatment']);
            }
        }
        return  redirect()->back()->with('error','La Transaction ne peut pas être annulé.');

    }

    public static function getErrorMessage($responseData): string{
       // return (json_encode($responseData));
        $message = '';
        try {
            $response = @$responseData->apiResponse;
            $firstKey = @array_keys((array)$response->data)[0];
            $message = @$response->data->$firstKey[0] ?? "";
        } catch (Exception $e) {
        }

        return @$response['message'].' '. $message;
    }


    public function retroAdmin($transaction, string $codeService)
    {
        if(retroTransactionAdmin($transaction)  ){
            $rest = Http::timeout(timeouts())->withHeaders([
                'apikey'=>env('SECRETE_API_DIGITAL')
            ])->post(env('API_DIGITAL_URL') . '/api/v1.0/partner/transaction/retro-admin',
                [
                    'transactionId'=>$transaction->id, 'codeService'=>$codeService,
                    'amount' => floatval(request('amount')),
                    'motif' => request('motif') ?: "R.A.S",
                ]
            );
            $resBody = (array) $rest->object();
            if($rest->status() === 201 && $resBody['statutTreatment'] === STATUS_TRX['SUCCESS']){
                return redirect()->back()->with('success','La retro transaction  est effectif avec success. Message : '. $resBody['message']);
            }else{
                return redirect()->back()->with('error','Erreur lors de La retro transaction  est effectif. Message : '. TransactionServices::getErrorMessage($resBody));
            }
        }
        return  redirect()->back()->with('error','La retro Transaction ne peut pas être effectué.');
    }

    public function sousServices(Transactions $transaction): Collection|array
    {
        return getSousServiceCashOut($transaction->sousService);
    }

}
