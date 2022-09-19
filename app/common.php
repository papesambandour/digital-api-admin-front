<?php

use App\Models\Parteners;
use App\Models\Phones;
use App\Models\Transactions;
use App\Models\Users;
use Illuminate\Support\Facades\DB;
use JetBrains\PhpStorm\ArrayShape;
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
    return (int)request('size',15);
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


function soldeIntech(){
   return  Phones::query()->sum('solde');
}

function balancePartners(){
   return  Parteners::query()->sum('solde');
}
function gainIntech(){
   return  '---';
}
function soldeService(int $serviceId){
  return  Phones::query()->where('services_id',$serviceId)->sum('solde');
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
    return \App\Models\SousServices::where('services_id', $serviceId)->get();
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
];
function checkRefundable(Transactions $transaction): bool
{
    return $transaction->statut == STATUS_TRX['SUCCESS']
        && $transaction->type_operation === TYPE_OPERATION['DEBIT']
        && $transaction->sousService->typeService->code === TYPE_SERVICES['CASHOUT'];
}

function checkFailableOrSuccessable(Transactions $transaction): bool
{
    return $transaction->statut == STATUS_TRX['PROCESSING'] || $transaction->statut == STATUS_TRX['PENDING'] ||  $transaction->pre_statut == STATUS_TRX['PROCESSING'] || $transaction->pre_statut == STATUS_TRX['PENDING'] ;
}

const PROFILS=[
    'ADMIN'=>'ADMIN',
    'FINANCIER'=>'FINANCIER',
    'SUPPORT'=>'SUPPORT',
];
