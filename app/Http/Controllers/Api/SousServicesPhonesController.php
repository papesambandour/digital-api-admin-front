<?php

namespace App\Http\Controllers\Api;

use App\Models\SousServicesPhones;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SousServicesPhonesController extends Controller
{
     const MODEL = SousServicesPhones::class;
     use RESTActions;
}
