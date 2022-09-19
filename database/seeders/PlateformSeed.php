<?php

namespace Database\Seeders;
use App\Models\Plateforme;
use App\Models\Profils;
use Illuminate\Database\Seeder;

class PlateformSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Plateforme::firstOrCreate(['code'=>PROFILS['ADMIN']],['name'=>'Administrateur','code'=>PROFILS['ADMIN'],]);
    }
}
