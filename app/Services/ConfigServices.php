<?php

namespace App\Services;

use App\Models\PartenerComptes;
use App\Models\Services;
use App\Models\SousServices;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class ConfigServices
{
    public function sousServices(): Collection|array
    {
        $query = SousServices::query();
        if(getPartnerI()){
            $query->whereHas('sousServicesParteners',fn($query)=> $query->where('parteners_id',getPartnerI()));
        }
        return $query->get();
    }
    public function services(): Collection|array
    {
        $query = Services::query();
        return $query->get();
    }

    public function servicesPaginate(): LengthAwarePaginator
    {
        $query = SousServices::query();
        if(getPartnerI()){
            $query->whereHas('sousServicesParteners',fn($query)=> $query->where('parteners_id',getPartnerI()));
        }
        if(request('date_start')){
            $query->where('created_at','>=',dateFilterStart(request('date_start')));
        }
        if(request('date_end')){
            $query->where('created_at','<=',dateFilterEnd(request('date_end')));
        }
        return $query->orderBy('id','DESC')->paginate(size());
    }
    public function apikeyPaginate(): LengthAwarePaginator
    {
        $query = PartenerComptes::query();
        if(getPartnerI()){
            $query->where('parteners_id',getPartnerI());
        }
        if(request('date_start')){
            $query->where('created_at','>=',dateFilterStart(request('date_start')));
        }
        if(request('date_end')){
            $query->where('created_at','<=',dateFilterEnd(request('date_end')));
        }
        return $query->orderBy('id','DESC')->paginate(size());
    }
    public function addKey(){
        $key  = PartenerComptes::query()->where('parteners_id',getPartnerI())->count();
       return PartenerComptes::create([
            'type_partener_compte' => TYPE_PARTNER_COMPTE['API'],
            'parteners_id' => _auth()['parteners_id'],
            'created_at' => nowIso(),
            'state' => STATE['ACTIVED'],
            'name' => _auth()['first_name'] . ' API KEY ' . (++$key) ,
            'app_key' => GUID(),
        ]);
    }
    public function regenerateKey($idKey): PartenerComptes
    {
        /**
         * @var PartenerComptes $partnerComptes
        */
        $partnerComptes  = PartenerComptes::query()->where('parteners_id',getPartnerI())->where('id',$idKey)->first();
        $partnerComptes->app_key = GUID();
        $partnerComptes->save();
        return $partnerComptes;
    }

}
