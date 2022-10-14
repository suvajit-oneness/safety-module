<?php
/**
* Class and Function List:
* Function list:
* - index()
* - create()
* - store()
* - show()
* - edit()
* - update()
* - destroy()
* Classes list:
* - HazardListController extends Controller
*/
namespace App\Http\Controllers;

use App\Models\hazard_list;
use Illuminate\Http\Request;

class HazardListController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\hazard_list  $hazard_list
     * @return \Illuminate\Http\Response
     */
    public function show(hazard_list $hazard_list)
    {
        //

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\hazard_list  $hazard_list
     * @return \Illuminate\Http\Response
     */
    public function edit(hazard_list $hazard_list)
    {
        //

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\hazard_list  $hazard_list
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, hazard_list $hazard_list)
    {
        //

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\hazard_list  $hazard_list
     * @return \Illuminate\Http\Response
     */
    public function destroy(hazard_list $hazard_list)
    {
        //

    }
}

