<?php
/**
* Class and Function List:
* Function list:
* - welcome()
* Classes list:
* - WelcomeController extends Controller
*/
namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;

use Log;
use PDF;
use Auth;
use Session;
use App\Models\vessel;

class WelcomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function welcome()
    {
        $vessel_details = vessel::where('unique_id', session('creator_id'))->first();
        return view('welcome', ['vessel_details' => $vessel_details]);
    }
}

