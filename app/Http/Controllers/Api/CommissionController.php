<?php

namespace App\Http\Controllers\Api;

use App\Models\Commission;
use App\Services\Helpers\Utils;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CommissionController extends Controller
{
     const MODEL = Commission::class;
     use RESTActions;
    public function destroy($id,Request $request)
    {
       return  $this->realDelete($id,$request);
    }
}
