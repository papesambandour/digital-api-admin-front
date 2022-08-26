<?php

namespace App\Services;

use App\Models\PartenerComptes;
use App\Models\Parteners;
use App\Models\Phones;
use App\Models\Services;
use App\Models\SousServices;
use App\Models\TypeServices;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class PhonesServices
{
    public function paginate(): LengthAwarePaginator{
        $query= Phones::query()->orderBy('id','DESC');
        if(request('date_start')){
            $query->where('created_at','>=',dateFilterStart(request('date_start')));
        }
        if(request('date_end')){
            $query->where('created_at','<=',dateFilterEnd(request('date_end')));
        }
        if(request('amount_max')){
            $query->where('solde','<=',request('amount_max'));
        }
        if(request('amount_min')){
            $query->where('solde','>=',request('amount_min'));
        }
        if(sousServiceId()){
            $query->whereHas('sousServicesPhones',fn($query)=> $query->where('sous_services_id',sousServiceId()));
        }
        return $query->paginate(size());
    }

}
