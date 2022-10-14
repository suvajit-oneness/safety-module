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
* - Crew_listController extends Controller
*/
namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

class Crew_listController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $data = DB::table('crew_list')->orderBy('updated_at','DESC')->get();
        // dd($data);
        return view('crew_list.index', ['data'          => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $dropdown = DB::table('crew_ranks')->get();
        return view('crew_list.add', ['dropdown' => $dropdown]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $r)
    {
        //


        DB::table('crew_list')->insert(['name' => $r->Name, 'rank' => $r->Rank, 'nationality' => $r->Nationality, 'sex' => $r->Sex, 'dob' => $r->Date_of_birth, 'pob' => $r->Place_of_birth, 'seaman_passpoert_pp_no' => $r->Seaman_Passport_PP_No, 'seaman_passpoert_exp' => $r->Seaman_Passport_EXPIRY, 'seaman_book_cdc_no' => $r->Seaman_Book_CDC_No, 'seaman_book_exp' => $r->Seaman_Book_EXPIRY, 'date_and_port_of_embarkation_date' => $r->Date_Of_Embarkation, 'date_and_port_of_embarkation_port' => $r->Port_Of_Embarkation, ]);

        return redirect(url('/crew_list'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        dd('show');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $data     = DB::table('crew_list')->find($id);
        $dropdown = DB::table('crew_ranks')->get();

        return view('crew_list.update', ['data' => $data, 'dropdown' => $dropdown]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $r, $id)
    {
        //
        DB::table('crew_list')->where('id', $id)->update(['name' => $r->Name, 'rank' => $r->Rank, 'nationality' => $r->Nationality, 'sex' => $r->Sex, 'dob' => $r->Date_of_birth, 'pob' => $r->Place_of_birth, 'seaman_passpoert_pp_no' => $r->Seaman_Passport_PP_No, 'seaman_passpoert_exp' => $r->Seaman_Passport_EXPIRY, 'seaman_book_cdc_no' => $r->Seaman_Book_CDC_No, 'seaman_book_exp' => $r->Seaman_Book_EXPIRY, 'date_and_port_of_embarkation_date' => $r->Date_Of_Embarkation, 'date_and_port_of_embarkation_port' => $r->Port_Of_Embarkation, ]);
        return redirect(url('/crew_list'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        DB::table('crew_list')->where('id', $id)->delete();
        return redirect(url('/crew_list'));
    }
}

