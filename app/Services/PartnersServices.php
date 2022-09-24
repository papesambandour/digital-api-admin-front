<?php

namespace App\Services;

use App\Models\OperationParteners;
use App\Models\Parteners;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class PartnersServices
{
    public function  partners(): Collection
    {
        return Parteners::all();
    }
    public function partnersPaginate()
    {
        $query =  Parteners::query();
        if(getPartnerI()){
            $query->where('id',getPartnerI());
        }
        if(request('date_start')){
            $query->where('created_at','>=',dateFilterStart(request('date_start')));
        }
        if(request('date_end')){
            $query->where('created_at','<=',dateFilterEnd(request('date_end')));
        }
        $query->orderBy('id','DESC') ;
        if(isExportExcel()){
           die (exportExcel(mappingExportPartner($query->get())));
        }
        return  $query->paginate(size());
    }
}
