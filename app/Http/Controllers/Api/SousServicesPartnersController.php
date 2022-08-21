<?php

namespace App\Http\Controllers\Api;

use App\Models\SousServicesParteners;
use App\Services\Helpers\Utils;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class SousServicesPartnersController extends Controller
{
     const MODEL = SousServicesParteners::class;
     use RESTActions;
    public function destroy($id,Request $request)
    {
        return  $this->realDelete($id,$request);
    }
}
