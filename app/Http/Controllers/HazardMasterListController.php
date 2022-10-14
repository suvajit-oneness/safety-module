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
* - fetchdata()
* - importExcel()
* Classes list:
* - HazardMasterListController extends Controller
*/
namespace App\Http\Controllers;
use DB;
use Log;
use Session;
use App\Models\hazard_list;
use App\Models\risk_matrix;
use App\Models\hazard_master_list;
use Illuminate\Http\Request;
use Carbon\Carbon;
// start new
use App\Imports\hazardImport;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Validators\ValidationException;
use Maatwebsite\Excel\HeadingRowImport;
// end new
class HazardMasterListController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // dd('');
        $hazardMaster = hazard_master_list::join('hazard_lists', 'hazard_master_lists.hazard_id', '=', 'hazard_lists.id')->where('deleted_at', NULL)
            ->select('hazard_master_lists.id as id', 'hazard_master_lists.hazard_id as hazard_id', 'hazard_master_lists.ref as ref', 'hazard_master_lists.vessel_name as vessel_name', 'hazard_master_lists.hazard_no as hazard_no', 'hazard_master_lists.source as source', 'hazard_master_lists.hazard_details as hazard_details', 'hazard_master_lists.causes as causes', 'hazard_master_lists.impact as impact', 'hazard_master_lists.applicable_permits as applicable_permits', 'hazard_master_lists.review as review', 'hazard_master_lists.situation as situation', 'hazard_master_lists.ir_severity as ir_severity', 'hazard_master_lists.ir_likelihood as ir_likelihood', 'hazard_master_lists.ir_risk_rating as ir_risk_rating', 'hazard_master_lists.control as control', 'hazard_master_lists.rr_severity as rr_severity', 'hazard_master_lists.rr_likelihood as rr_likelihood', 'hazard_master_lists.rr_risk_rating as rr_risk_rating', 'hazard_master_lists.life_cycle as life_cycle', 'hazard_lists.code as code', 'hazard_lists.name as name')
            ->get();
        $data         = DB::table('hazard_master_lists')->select()
            ->get();
        $riskMatrices = risk_matrix::pluck('hex_code', 'code');

        // dd($riskMatrices);
        return view('hazardMaster.view', ['hazardMasters'               => $hazardMaster, 'riskMatrices'               => $riskMatrices, 'data'               => $data]);
        //  return $hazardMaster;

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $risk_matrices = risk_matrix::all();
        $hazards_list  = hazard_list::all();

        return view('hazardMaster.create')->with(['risk_matrices'                                => $risk_matrices, 'hazards_list'                                => $hazards_list

        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $tempHazard                     = new hazard_master_list;
        $tempHazard->hazard_id          = $request->input('hazards-name');
        $tempHazard->ref                = $request->input('reference_hidden');
        $tempHazard->vessel_name        = $request->input('vessel_name');
        $tempHazard->hazard_no          = $request->input('hazard_no');
        $tempHazard->source             = $request->input('source');
        $tempHazard->hazard_details     = $request->input('hazard_details');
        $tempHazard->causes             = $request->input('causes');
        $tempHazard->impact             = $request->input('impact');
        $tempHazard->applicable_permits = $request->input('applicable_permits');
        $tempHazard->review             = $request->input('review');
        $tempHazard->situation          = $request->input('situation');
        $tempHazard->ir_severity        = $request->input('ir_severity');
        $tempHazard->ir_likelihood      = $request->input('ir_likelihood');
        $tempHazard->ir_risk_rating     = $request->input('ir_risk_rating');
        $tempHazard->control            = $request->input('control');
        $tempHazard->rr_severity        = $request->input('rr_severity');
        $tempHazard->rr_likelihood      = $request->input('rr_likelihood');
        $tempHazard->rr_risk_rating     = $request->input('rr_risk_rating');
        $tempHazard->life_cycle         = $request->input('life_cycle');

        $tempHazard->save();
        Session::flash('status', 1);
        return redirect('hazard-master');

        // return $request->input();

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\hazard_master_list  $hazard_master_list
     * @return \Illuminate\Http\Response
     */
    public function show(hazard_master_list $hazard_master_list)
    {
        //

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\hazard_master_list  $hazard_master_list
     * @return \Illuminate\Http\Response
     */
    public function edit(hazard_master_list $hazard_master_list, $id)
    {
        $risk_matrices_details = risk_matrix::all();
        $hazards_list_details  = hazard_list::all();
        $hazard_master_details = hazard_master_list::find($id);
        $var                   = DB::table('hazard_master_lists')->select('hazard_id')
            ->where('id', $id)->get();
        $h_name                = DB::table('hazard_lists')->select('name')
            ->where('id', $var[0]->hazard_id)
            ->get();
        // return $hazard_master_details;
        return view('hazardMaster.edit')
            ->with(['hazard_master_details'                                => $hazard_master_details, 'hazards_list_details'                                => $hazards_list_details, 'risk_matrices_details'                                => $risk_matrices_details, 'hazard_name'                                => $h_name[0]->name]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\hazard_master_list  $hazard_master_list
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, hazard_master_list $hazard_master_list, $id)
    {
        // return $request->input();
        /*   $result = hazard_master_list::find($request->id);
        $result->id = $request->id;
        // $result->hazard_id = $request->input('hazards-name');
        $result->ref = $request->input('reference_hidden');
        $result->hazards = $request->input('hazard');
        $result->hazard_title = $request->input('hazard_title');
        $result->threats = $request->input('threats');
        $result->top_event = $request->input('top_event');
        $result->consequences = $request->input('consequences');
        $result->control = $request->input('control_barrier');
        $result->recover_measure = $request->input('recovery_measure');
        $result->reduction_measure = $request->input('reduction_measure');
        $result->remarks = $request->input('remarks');
        $result->risk_p = $request->input('risk_p');
        $result->risk_e = $request->input('risk_e');
        $result->risk_a = $request->input('risk_a');
        $result->risk_r = $request->input('risk_r');
        $result->nett_risk_p = $request->input('nett_risk_p');
        $result->nett_risk_e = $request->input('nett_risk_e');
        $result->nett_risk_a = $request->input('nett_risk_a');
        $result->nett_risk_r = $request->input('nett_risk_r');*/

        $tempHazard                     = hazard_master_list::find($request->id);
        $tempHazard->id                 = $request->id;
        // $tempHazard->hazard_id = $request->input('hazards-name');
        $tempHazard->ref                = $request->input('reference_hidden');
        $tempHazard->vessel_name        = $request->input('vessel_name');
        $tempHazard->hazard_no          = $request->input('hazard_no');
        $tempHazard->source             = $request->input('source');
        $tempHazard->hazard_details     = $request->input('hazard_details');
        $tempHazard->causes             = $request->input('causes');
        $tempHazard->impact             = $request->input('impact');
        $tempHazard->applicable_permits = $request->input('applicable_permits');
        $tempHazard->review             = $request->input('review');
        $tempHazard->situation          = $request->input('situation');
        $tempHazard->ir_severity        = $request->input('ir_severity');
        $tempHazard->ir_likelihood      = $request->input('ir_likelihood');
        $tempHazard->ir_risk_rating     = $request->input('ir_risk_rating');
        $tempHazard->control            = $request->input('control');
        $tempHazard->rr_severity        = $request->input('rr_severity');
        $tempHazard->rr_likelihood      = $request->input('rr_likelihood');
        $tempHazard->rr_risk_rating     = $request->input('rr_risk_rating');
        $tempHazard->life_cycle         = $request->input('life_cycle');

        // $result->save();
        $tempHazard->save();
        //  dd($tempHazard);
        Session::flash('status', 2);
        return redirect('hazard-master');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\hazard_master_list  $hazard_master_list
     * @return \Illuminate\Http\Response
     */
    public function destroy(hazard_master_list $hazard_master_list, $id)
    {
        // hazard_master_list::destroy(array('id', $id));
        // Session::flash('status',3);
        $current_time = Carbon::now()->toDateTimeString();
        DB::table('hazard_master_lists')
            ->where('id', $id)->update(['deleted_at' => $current_time, ]);
        return redirect('hazard-master');
        // return $hazard_master_list->id;

    }

    public function fetchdata(Request $id)
    {
        // return $id->id;
        $records = DB::table('hazard_master_lists')->select('ref')
            ->where('hazard_id', $id->id)
            ->orderBy('ref', 'desc')
            ->get();

        log::info($records);
        if (sizeof($records) == 0)
        {
            return 1;
        }
        else
        {
            $arr = ($records[0]->ref) + 1;
            return $arr;
        }
        // return $arr;



    }
    public function importExcel(Request $r)
    {
        // dd('Excel here');
        $file     = $r->file('file');
        // dd($file);
        $e        = $r->file('file')
            ->getClientOriginalExtension();
        // dd($e);
        $headings = (new HeadingRowImport)->toArray($file);
        $heading  = $headings[0][0];
        $import   = new hazardImport;
        $import->import($file);
        return back();
    }
}

