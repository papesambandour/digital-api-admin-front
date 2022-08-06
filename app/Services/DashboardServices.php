<?php

namespace App\Services;

use App\Models\Parteners;
use Illuminate\Database\Eloquent\Collection;

class DashboardServices
{

public function  partners(): Collection
{
    return Parteners::all();
}
}
