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

    public function store(Request $request)
    {
        try {
            $partners_id = $request->get('partners_id');
            $sous_services = $request->get('sous_services');
            SousServicesParteners::where('parteners_id',$partners_id)
                ->delete();
            DB::beginTransaction();
            foreach ($sous_services as $sous_service_id) {
                SousServicesParteners::firstOrCreate([
                    'parteners_id' => $partners_id,
                    'sous_services_id' => $sous_service_id
                ], [
                    'parteners_id' => $partners_id,
                    'sous_services_id' => $sous_service_id
                ]);
            }
            DB::commit();
           return Utils::respond('created',  []);
        } catch (\Exception $e) {
            DB::rollBack();
            return Utils::respond('not_valid', []) ;
        }
    }
}
