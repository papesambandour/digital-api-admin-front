<?php

namespace Database\Seeders;
use App\Models\Profils;
use Illuminate\Database\Seeder;

class ProfilSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Profils::firstOrCreate(['code'=>PROFILS['ADMIN']],['name'=>'Administrateur','code'=>PROFILS['ADMIN'],]);
        Profils::firstOrCreate(['code'=>PROFILS['FINANCIER']],['name'=>'Financier','code'=>PROFILS['FINANCIER'],]);
        Profils::firstOrCreate(['code'=>PROFILS['SUPPORT']],['name'=>'Support','code'=>PROFILS['SUPPORT'],]);
    }
}
