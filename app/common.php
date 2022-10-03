<?php

use App\Models\Country;
use App\Models\OperationParteners;
use App\Models\Parteners;
use App\Models\Phones;
use App\Models\Services;
use App\Models\SousServices;
use App\Models\Transactions;
use App\Models\Users;
use App\Services\Helpers\Utils;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use JetBrains\PhpStorm\ArrayShape;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Exception;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
function  tox64($path): string
{
    if(!$path){
        $path ='img/pro-medical.png';
    }
    if(substr($path,0,4) === 'http'){
        $path = base_path() . '/public/storage' . explode('storage',$path)[1] ;
    }else{
        $path = base_path() . '/public/' . $path ;
    }
    $type = pathinfo($path, PATHINFO_EXTENSION);
    $data = file_get_contents($path);

    return 'data:file/' . $type . ';base64,' . base64_encode($data);

}
$isSeed = false;

function str_without_accents($str, $charset='utf-8'): array|string|null
{
    $str = htmlentities($str, ENT_NOQUOTES, $charset);

    $str = preg_replace('#&([A-za-z])(?:acute|cedil|caron|circ|grave|orn|ring|slash|th|tilde|uml);#', '\1', $str);
    $str = preg_replace('#&([A-za-z]{2})(?:lig);#', '\1', $str); // pour les ligatures e.g. '&oelig;'
    // supprime les autres caractères

    return preg_replace('#&[^;]+;#', '', $str);   // or add this : mb_strtoupper($str); for uppercase :)
}
 function _auth():?Users
{
    /**
     * @var Users $partner
    */
    return Users::find(getUser()['id']);

}
function checkProfil(array $profils): bool
{
    return in_array(_auth()->profil->code,$profils);
}

function title(string $title): string
{
    return "INTECH API " . $title;
}

function dateFilterStart($date): DateTime
{
    return DateTime::createFromFormat('Y-m-d H:i:s', $date .' 00:00:00');
}
function dateFilterEnd($date): DateTime
{
    return DateTime::createFromFormat('Y-m-d H:i:s', $date .' 23:59:59');
}
function  page(): int{
    return (int)request('page',1);
}
function  size(): int
{
    return (int)request('size',30);
}

function  timeouts(): int
{
    return 60;
}
//'SUCCESS','PENDING','PROCESSING','FAILLED','CANCELED'
const STATUS = [
  'SUCCESS' => 'statut-success',
  'CANCELED' => 'table-warning',
  'FAILLED' => 'statut-danger',
  'PROCESSING' => 'statut-infos',
  'PENDING' => 'statut-infos',
];
const STATUS_TRX=[
    'SUCCESS'=>'SUCCESS','PENDING'=>'PENDING','PROCESSING'=>'PROCESSING','FAILLED'=>'FAILLED','CANCELED'=>'CANCELED'
];
const STATE = [
    'ACTIVED' => 'ACTIVED',
    'INACTIVED' => 'INACTIVED',
    'DELETED' => 'DELETED',
];
const OPERATIONS_PARTNERS=[
    'TRANSACTION'=>'TRANSACTION',
    'ANNULATION_TRANSACTION'=> 'ANNULATION_TRANSACTION',
    'APROVISIONNEMENT'=>'APROVISIONNEMENT',
    'ANNULATION_APROVISIONNEMENT'=> 'ANNULATION_APROVISIONNEMENT',
    'APPEL_DE_FOND'=>'APPEL_DE_FOND',
    'ANNULATION_APPEL_DE_FOND'=> 'ANNULATION_APPEL_DE_FOND',
];
const OPERATIONS_PHONES=[
    'APPEL_DE_FONS'=>'APPEL_DE_FONS',
    'APPROVISIONNEMENT'=> 'APPROVISIONNEMENT',
    'TRANSACTION'=>'TRANSACTION',
    'ANNULATION_APPELS_FONDS'=> 'ANNULATION_APPELS_FONDS',
    'ANNULATION_APPROVISIONNEMENT'=>'ANNULATION_APPROVISIONNEMENT',
    'ANNULATION_TRANSACTION'=> 'ANNULATION_TRANSACTION',
];
const SIM_PROVIDER =[
    'FALL_DISTRIBUTION',
    'COPRESS_TELECOM',
    'NONE',
];
function status($status): string{
    return  @STATUS[$status] ?? '';
}

const TYPE_PARTNER_COMPTE =[
    'API'=>'API',
    'CAISSE'=>'CAISSE'
];
const TYPE_OPERATION =[
    'DEBIT'=>'DEBIT',
    'CREDIT'=>'CREDIT'
];

function logoFromName($name): string{
    $tabNames = explode(' ',$name);
    $name  ='';
    foreach($tabNames as $tabName){
        $name .= ucfirst($tabName[0]);
    }
    return $name;
}
 function amountSuccess(int $sousServicesId){
    return amountStatusSubService('SUCCESS',$sousServicesId);
}
 function amountFailled(int $sousServicesId){
    return amountStatusSubService('FAILLED',$sousServicesId);
}
 function amountPending(int $sousServicesId){
    return amountStatusSubService('PENDING',$sousServicesId) +  amountStatusSubService('PROCESSING',$sousServicesId) ;
}
 function percentageAmount($amountRef, $amount1, $amount2): float|int
 {
    return  ($amountRef / (($amountRef + $amount1 + $amount2  ) ?: 1)) * 100;
}
function amountStatusSubService(string $statut, int $sousServicesId){
    $queryAmount = Transactions::where('sous_services_id',$sousServicesId)->whereBetween('created_at',[
        dateFilterStart(request('date_start',gmdate('Y-m-d'))),
        dateFilterEnd(request('date_end',gmdate('Y-m-d')))
    ])->where(STATUS_TRX_NAME,$statut);

    if(getPartnerI()){
        $queryAmount->where('parteners_id',getPartnerI());
    }
    return $queryAmount->sum('amount') ;
}
function getPartnerI(){
    return request('_partener_',null);
}


 function amountState($status): float|int
 {
    $query =  Transactions::whereBetween('created_at',[
        dateFilterStart(request('date_start',gmdate('Y-m-d'))),
        dateFilterEnd(request('date_end',gmdate('Y-m-d')))
    ]);
    if(getPartnerI()){
        $query->where('parteners_id',getPartnerI());
    }
    return $query->where(STATUS_TRX_NAME,$status)->sum('amount') ;
}
function loginUser(Users $user):void{
    session([keyAuth() => $user]);
}

/**
 * @throws ContainerExceptionInterface
 * @throws NotFoundExceptionInterface
 */
function getUser(){
  return  session()->get(keyAuth());
}
function keyAuth(): string
{
    return "__AUTH_USER__";
}
function logOut(): void{
    session()->forget([keyAuth()]);
    session()->flush();
}

function checkAuth(): bool
{
    return session()->has(keyAuth());
}

function GUID(): string
{
    if (function_exists('com_create_guid') === true) {
        return trim(com_create_guid(), '{}');
    }

    return sprintf('%04X%04X-%04X-%04X-%04X-%04X%04X%04X', mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(16384, 20479), mt_rand(32768, 49151), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535));
}
function nowIso(): string
{
    return gmdate("Y-m-d H:i:s");
}

function dateIso(DateTime $date,$format='Y-m-d' ): string
{
    return $date->format($format);
}
function money($number): string{
  return  number_format($number,'2','.',' ');
}
function percent($number): string{
  return  number_format($number,'2','.',' ');
}

function period(): string
{
    $start= request('date_start', gmdate('Y-m-d')  );
    $end= request('date_end', gmdate('Y-m-d'));
    if($start === $end && $end === gmdate('Y-m-d')){
        return  "Journée en cours" . partnerName();
    }
    return 'Du ' . dateFr($start). ' au ' . dateFr($end) . partnerName();
}
function period2(): string
{
    $start= request('date_start', gmdate('Y-m-d')  );
    $end= request('date_end', gmdate('Y-m-d'));
    if($start === $end && $end === gmdate('Y-m-d')){
        return  partnerName2() . "<br>Journée en cours" ;
    }
    return  partnerName2() .'<br> Du '.  dateFr($start). ' au ' . dateFr($end) ;
}
function dateFr(string $date): string
{
    return implode('-',array_reverse(explode('-',$date)));
}
const STATUS_TRX_NAME = 'pre_statut';
//UPDATE transactions set pre_statut = statut;


function soldeIntechSystem(){
   return  fMoney(Phones::query()->sum('solde'));
}

function soldeIntechStock(){
   return  fMoney(Phones::query()->sum('solde_api'));
}

function balancePartners(){
   return  fMoney(Parteners::query()->sum('solde'));
}

function gainIntech(){
    $start= request('date_start', gmdate('Y-m-d')  );
    $end= request('date_end', gmdate('Y-m-d'));
   return  fMoney(Transactions::query()->whereBetween('created_at', [$start, $end])->sum('win'));
}

function gainIntechByService($codeService){
    $start= request('date_start', gmdate('Y-m-d')  );
    $end= request('date_end', gmdate('Y-m-d'));
   return  fMoney(Transactions::query()->where('code_sous_service', $codeService)->whereBetween('created_at', [$start, $end])->sum('win'));
}

function soldeServiceSystem(int $serviceId){
  return  fMoney(Phones::query()->where('services_id',$serviceId)->sum('solde'));
}

function fMoney($v){
    return number_format($v, 1, ',', ' ');
}

function soldeServiceStock(int $serviceId){
  return  fMoney(Phones::query()->where('services_id',$serviceId)->sum('solde_api'));
}

function partnerDetail(): bool
{
    return (int)request('partner_details') === 1;
}
function partner(): ?Parteners{
 $partner =  Parteners::find(getPartnerI());
 if(!$partner){
     //dd("Le partner n'exist pas");
 }
 return $partner;
}
function partnerName(): string{
 $partner = partner();
 return $partner ? ' Avec ' . $partner->name  : '';
}
function partnerName2(): string{
 $partner = partner();
 return $partner ? 'Gagnés Avec ' . $partner->name  : 'Gagnés Avec les partenaires';
}
function updateSolde($model,$amount,$filed='solde'){
    $tables= $model->getTable();
    $query = "UPDATE  $tables  set $filed = $filed + '$amount' where id =  $model->id";
    $rest = DB::update($query);
}
function sousServiceName(): string
{
    return '_sous_services_id';
}
function getSousServiceId(): int
{
    return (int) request(sousServiceName());
}

function getSousServicesByServiceId($serviceId){
    return SousServices::where('services_id', $serviceId)->get();
}

function getOperationRequestName(): string
{
    return '_operation_';
}
function getOperation(){
    return request(getOperationRequestName(),null);
}

function getTypeOperationRequestName(): string
{
    return '_type_operation_';
}
function getTypeOperation(){
    return request(getTypeOperationRequestName(),null);
}

function number($number,$decimal = 2,$decimal_separator = '. ',$separator_thousand=' ') : string
{
    return number_format((float)$number,$decimal,$decimal_separator,$separator_thousand);
}

const EXECUTE_TYPE_USSD  =[
'SEND_USSD_CODE_SMS' => 'SEND_USSD_CODE_SMS',
'EXECUTE_REQUEST_CODE' => 'EXECUTE_REQUEST_CODE',
];

const CODE_VIREMENT_BANK= 'BANK_TRANSFER_SN_API_CASH_IN';


const STATUS_CLAIM=[
    'CREATED'=>'CREATED',
    'OPENED'=>'OPENED',
    'CLOSED'=>'CLOSED'
];
const STATUS_CLAIM_LABEL=[
    'CREATED'=>'<label style="color: #324960;border: 2px dashed #324960;font-weight: bold;padding: 4px;border-radius: 10px;text-transform: uppercase">Crée </label>',
    'OPENED'=> '<label style="color: #236320;border: 2px dashed #236320;font-weight: bold;padding: 4px;border-radius: 10px;text-transform: uppercase">Ouvert</label>',
    'CLOSED'=> '<label style="color: #ba6a35;border: 2px dashed #ba6a35;font-weight: bold;padding: 4px;border-radius: 10px;text-transform: uppercase">Fermer</label>'
];
const STATUS_CLAIM_LABEL_TEXT=[
    'CREATED'=>'Crée',
    'OPENED'=> 'Ouvert',
    'CLOSED'=> 'Ferme'
];
function claimStatut($status){
    return @STATUS_CLAIM_LABEL[$status] ?: $status;
}
function claimStatutText($status){
    return @STATUS_CLAIM_LABEL_TEXT[$status] ?: $status;
}
function claimsNb(): int
{
    return \App\Models\Claim::query()->where('statut',STATUS_CLAIM['CREATED'])->count();
}

const TYPE_SERVICES = [
    'CASHOUT'=>'CASHOUT',
    'CASHIN'=>'CASHIN',
];
function checkRefundable(Transactions $transaction): bool
{
    return $transaction->statut == STATUS_TRX['SUCCESS']
/*        && $transaction->type_operation === TYPE_OPERATION['CREDIT']
        && $transaction->sousService->typeService->code === TYPE_SERVICES['CASHOUT']*/
        ;
}

function checkFailableOrSuccessable(Transactions $transaction): bool
{
    return $transaction->statut == STATUS_TRX['PROCESSING'] || $transaction->statut == STATUS_TRX['PENDING'] ||  $transaction->pre_statut == STATUS_TRX['PROCESSING'] || $transaction->pre_statut == STATUS_TRX['PENDING'] ;
}
function retroTransactionAdmin(Transactions $transaction): bool
{
    return
        ($transaction->statut == STATUS_TRX['SUCCESS'] || $transaction->statut === STATUS_TRX['FAILLED'])
        && (
            $transaction->sousService->typeService->code === TYPE_SERVICES['CASHOUT'] ||
            $transaction->sousService->typeService->code === TYPE_SERVICES['CASHIN'] // moussa
        );
}

const PROFILS=[
    'ADMIN'=>'ADMIN',
    'FINANCIER'=>'FINANCIER',
    'SUPPORT'=>'SUPPORT',
];
function saveFile(UploadedFile $file, $rootPath){
    $date = (new \DateTime())->format('Y-m-d');
    $path = $rootPath. '/' . $date . "-" . uniqid() . '.' . $file->extension();
    Storage::put($path, $file->getContent());
    return base64_encode($path);
}
 function readFileHelper(string $path)
{
    $path = storage_path('app')  .'/'. base64_decode($path);
    $file = \Illuminate\Support\Facades\File::get($path);
    $type = File::mimeType($path);
    $response = Response::make($file, 200);
    $response->header("Content-Type", $type);
    return $response;
}
function getSousServiceCashOut(SousServices $sousServices): Collection|array
{
    return SousServices::query()
        ->whereHas('typeService',function ($query) use ($sousServices){
            $query->where('code', TYPE_SERVICES['CASHIN']);
    })->whereHas('service',function ($query) use ($sousServices){
           $query->whereHas('operator',function ($query2) use ($sousServices){
               $query2->where('countries_id',$sousServices->service->operator->countries_id);
           });
        })->get();
}
function isPhone(Phones $phones): bool
{
    return $phones->sim_provider  !== 'NONE' && $phones->socket == SOCKET['CONNECTED'] ;
}
const SOCKET = [
    'CONNECTED' =>'CONNECTED',
    'DISCONNECTED' =>'DISCONNECTED',
];
function countries(): Collection
{
    return Country::all();
}

function exportExcel(array $data ){
    try {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        /*SET CONTENT*/
        $y=1;
        $alfa = range('A','Z');
        foreach ($data as $value){
            $x = 0 ;
            foreach ($value as $key =>$va){
                $sheet->setCellValue(@$alfa[$x] . $y, ucfirst($key));
                $sheet->getColumnDimension(@$alfa[$x])->setAutoSize(true);
                $x++;
            }

            $y++ ;
            break;
        }
        foreach ($data as $value){
            $x = 0 ;
            foreach ($value as $key =>$va){
                $sheet->setCellValue(@$alfa[$x] . $y,$va);
                $sheet->getColumnDimension(@$alfa[$x])->setAutoSize(true);
                $x++;
            }
            $y++ ;
        }
        $sheet->getStyle('A:Z')->getAlignment()->setHorizontal('left');

        //  $sheet->setCellValue('A1', 'Hello World !');
        /*SET CONTENT*/
        $path = tempnam(sys_get_temp_dir(), '_intech_api_');
        $writer = new Xlsx($spreadsheet);
        $writer->save($path);
        $res = file_get_contents($path);
        $b64Doc = base64_encode(($res ?: ''));// file
        unlink($path);
        return json_encode(['data'=>"data:application/xlsx;base64," . $b64Doc,'msg'=>'exportation ok','error'=>false,'code'=>200]) ;
    } catch (Exception $e) {
        die($e->getMessage());
    }
}
function isExportExcel(): bool
{
    return !!request('_exported_excel_',false);
}

/**
 * @param Collection $partners
 * @return array
 */
function mappingExportPartner(Collection $partners): array
{
    return $partners->map(function(Parteners $partner){
        return [
            'Libelle'=> $partner->name,
            'Email'=> $partner->email,
            'Téléphone'=> $partner->phone,
            'Solde'=> $partner->solde,
            'Solde Commission'=> $partner->solde_commission,
            'Pays'=> @$partner->country->name ?: "N\A",
            'État'=> $partner->state,
            'Date de creation'=> $partner->created_at->format('Y-m-d'),
        ];
    })->toArray();
}

/**
 * @param Collection $versements
 * @return array
 */
function mappingExportVersement(Collection $versements): array
{
    return $versements->map(function(OperationParteners $versement){
        return [
            'Montant'=> $versement->amount,
            'Partenaire'=> $versement->partener->name,
            'Type Opération'=> $versement->type_operation,
            'Provenance'=> $versement->operation,
            'Utilisateur'=> @$versement->user->f_name . ' ' . @$versement->user->l_name  ,
            'Date de creation'=> $versement->created_at->format('Y-m-d'),
        ];
    })->toArray();
}

/**
 * @param Collection $transactions
 * @return array
 */
function mappingExportTransaction(Collection $transactions): array
{
    return $transactions->map(function(Transactions $transaction){
        return [
            'ID'=> $transaction->id,
            'Transaction Id'=> $transaction->transaction_id,
            'Numéro'=> $transaction->phone,
            'Montant'=> $transaction->amount  ,
            'Type Operation'=> $transaction->type_operation  ,
            'Partenaire'=> $transaction->partener_name  ,
            'Commission'=> $transaction->commission_amount ,
            'Frais'=> $transaction->fee_amount  ,
            'Services'=> $transaction->sous_service_name  ,
            'Sous Services'=> $transaction->service_name  ,
            'Statut'=>  $transaction->{STATUS_TRX_NAME},
            'Date de creation'=> $transaction->created_at->format('Y-m-d'),
        ];
    })->toArray();
}

/**
 * @param Collection $services
 * @return array
 */
function mappingExportService(Collection $services): array
{
    return $services->map(function(Services $service){
        return [
            'Code'=> $service->code,
            'Libelle'=> $service->name,
            'Opérateur'=> $service->operator->name,
            'Catégorie Service'=> $service->categoriesService->name  ,
            'Solde Système'=>soldeServiceSystem($service->id)   ,
            'Solde Stock'=>soldeServiceStock($service->id)   ,
            'Date de creation'=> $service->created_at->format('Y-m-d'),
        ];
    })->toArray();
}

/**
 * @param Collection $sousServices
 * @return array
 */
function mappingExportSousService(Collection $sousServices): array
{
    return $sousServices->map(function(SousServices $sousService){
        return [
            'Code'=> $sousService->code,
            'Libelle'=> $sousService->name,
            'Type Service'=> $sousService->typeService->name,
            'Service'=> $sousService->service->name  ,
            'Type Opération'=> $sousService->type_operation  ,
            'Statut'=> $sousService->state,
            'Date de creation'=> $sousService->created_at->format('Y-m-d'),
        ];
    })->toArray();
}


/**
 * @param Collection $versements
 * @return array
 */
function mappingExportVersementPhones(Collection $versements): array
{
    return $versements->map(function(\App\Models\OperationPhones $versement){
        $name ="(";
        $name .= $versement->phone->id;
        $name .=") ";
        $name .= $versement->phone->number ." ";
        $name .= @$versement->phone->sousServicesPhones[0]->sousService->name ? : 'Pas encore souscrit a un sous service';
        return [
            'Montant'=> $versement->amount,
            'Services Providers'=> $name,
            'Type Opération'=> $versement->type_operation,
            'Provenance'=> $versement->operation,
            'Utilisateur'=> @$versement->user->f_name . ' ' . @$versement->user->l_name  ,
            'Date de creation'=> $versement->created_at->format('Y-m-d'),
        ];
    })->toArray();
}
function yesNonSelect(): array
{
    return [
        'Oui'=>1,
       'Non'=>0,
    ];
}
