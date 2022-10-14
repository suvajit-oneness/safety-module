<?php
/**
* Class and Function List:
* Function list:
* - terms()
* Classes list:
* - TermsController extends Controller
*/
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TermsController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function terms()
    {
        return view('pages.public.terms');
    }
}

