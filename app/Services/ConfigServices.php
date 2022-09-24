<?php

namespace App\Services;

use App\Models\PartenerComptes;
use App\Models\Parteners;
use App\Models\Services;
use App\Models\SousServices;
use App\Models\TypeServices;
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
    public function servicesPlate(): Collection|array
    {
        $query = Services::query()->where('state',STATE['ACTIVED']);
        return $query->get();
    }
    public function typeServicesPlate(): Collection|array
    {
        $query = TypeServices::query()->where('state',STATE['ACTIVED']);
        return $query->get();
    }

    public function sousServicesPaginate(): LengthAwarePaginator
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
        $query->orderBy('id','DESC');
        if(isExportExcel()){
            die (exportExcel(mappingExportSousService($query->get())));
        }
        return $query->with('service')->with('typeService')->with('commissions')->paginate(size());
    }
    public function servicesPaginate()
    {
        $query = Services::query();
        if(getPartnerI()){
            $query->whereHas('sousServices',fn($query)=> $query->whereHas('sousServicesParteners',fn($query_)=> $query_->where('parteners_id',getPartnerI())));
        }
        if(request('date_start')){
            $query->where('created_at','>=',dateFilterStart(request('date_start')));
        }
        if(request('date_end')){
            $query->where('created_at','<=',dateFilterEnd(request('date_end')));
        }
        $query->orderBy('id','DESC');
        if(isExportExcel()){
            die (exportExcel(mappingExportService($query->get())));
        }
        return $query->paginate(size());
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
        $partner = Parteners::find(getPartnerI());
       return PartenerComptes::create([
            'type_partener_compte' => TYPE_PARTNER_COMPTE['API'],
            'parteners_id' => getPartnerI(),
            'created_at' => nowIso(),
            'state' => STATE['ACTIVED'],
            'name' => $partner->name . ' API KEY ' . (++$key) ,
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
