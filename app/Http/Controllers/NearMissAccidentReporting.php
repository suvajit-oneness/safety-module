<?php
/**
* Class and Function List:
* Function list:
* - getmain()
* - getsub()
* - getter()
* - index()
* - create()
* - store()
* - edit()
* - update()
* - destroy()
* - printPDF_Nearmiss()
* - printPDFAll_Nearmiss()
* - findSub()
* - col()
* - findTer()
* - getnearmiss()
* Classes list:
* - NearMissAccidentReporting extends Controller
*/
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Log;
// we import  DB for using query builder
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Auth\AuthenticationException;
use Mockery\Undefined;
use PDF;
use PHPUnit\TextUI\Help;
use App\Http\Controllers\Vessel_detailsController;
use Carbon\Carbon;
use App\Models\NearMissModel;
use App\Models\User;
use session;

class NearMissAccidentReporting extends Controller
{

    // helper function
    function getmain($id)
    {
        if ($id != 0)
        {
            $drop = DB::table('near_miss_dropdown_main_type')->where('id', $id)->get()
                ->first();
        }
        else
        {
            return 0;
        }
        // $dropsub = $req->id;
        if (!empty($drop))
        {
            return $drop->type_main_name;
        }
        else
        {
            return 0;
        }
    }

    function getsub($ids)
    {
        Log::info('ids : '.print_r($ids));
        if ($ids != 0)
        {
            $drop = DB::table('near_miss_dropdown_sub_type')->where('id', $ids)->get()
                ->first();
        }
        else
        {
            return 0;
        }
        // $dropsub = $req->id;
        if (!empty($drop))
        {
            return $drop->type_sub_name;
        }
        else
        {
            return 0;
        }
    }

    function getter($idt)
    {
        if ($idt != 0)
        {
            $drop = DB::table('near_miss_dropdown_ter_type')->where('id', $idt)->get();
        }
        else
        {
            return 0;
        }
        // $dropsub = $req->id;
        if (!empty($drop))
        {
            return $drop[0]->type_ter_name;
        }
        else
        {
            return 0;
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $r)
    {
        $user = User::find(session('id'));
        if($user->hasPermissionTo('view.nearmiss')){
            $is_ship = session('is_ship');
            $creator_id = session('creator_id');
            $response = [
                'is_ship' => $is_ship,
                'creator_id' => $creator_id
            ];
            return view('NearMissAccident.nearview', $response);
        }
        else{
            abort(404);
        }

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // $dropdown = DB::table('near_miss_dropdown')->get();
        // $dropmain = DB::table('near_miss_dropdown_main_type')->get();
        // dd($dropdown);
        // $draft = NearMissModel::where('creator_email',session('email'))->where('status','Draft')
                        // ->orderBy('created_at')
                        // ->first();
        // dd($draft);
        // if($draft == null){
        //     // $id = $this->createDraft();
        //     // $data   = NearMissModel::find($id);
        //     // dd($data);
        //     // return view('NearMissAccident.addnew', ['dropdown'=> $dropdown, 'dropdownmain' => $dropmain,'data' => $data]);
        //     // $this->createDraft();
        //     return redirect('generateNewDraft');
        // }
        // else{
        //     return View('NearMissAccident.quearyView');
        // }
        $user = User::find(session('id'));
        // dd($user);
        // dd($user->isUser());
        // dd($user->hasPermissionTo('create.nearmiss'));
        if($user->hasPermissionTo('create.nearmiss')){
            return redirect('generateNewDraft');
        }
        else{
            abort(404);
        }
        
        
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // $id = (new GenericController)->getUniqueId('near_miss_accident_report',config('constants.UNIQUE_ID_TEXT.NEAR_MISS'));
        Log::info('I am in Store');
        $close                    = $request->close;
        $ofc_comnt                = $request->ofc_comments;
        $lession_learn            = $request->lession_learn;

        $corrective_action        = $request->corrective_action;

        NearMissModel::where('id', $request->id)
        ->update([
            'close' => $close,
            'office_comments' => $ofc_comnt,
            'lession_learnt' => $lession_learn,
            'status'    =>  'Submitted'
        ]);

        return redirect(route('Near_Miss'))->with('status', 'Data Added !!');
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
        $user = User::find(session('id'));
        if($user->hasPermissionTo('edit.nearmiss')){
            $dropdown = DB::table('near_miss_dropdown')->get();
            $report   = NearMissModel::find($id);
            // dd($report);
            $dropmain = DB::table('near_miss_dropdown_main_type')->get();
            // dd($dropdown);
            return view('NearMissAccident.addnew', ['dropdown'                       => $dropdown, 'dropdownmain'                       => $dropmain, 'data'                       => $report]);
        }
        else{
            abort(404);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $current_date_time     = \Carbon\Carbon::now()->toDateTimeString();
        $report                = NearMissModel::find($id);
        $status_update         =  $request->close;
        $date                  = $request->date;
        $descr                 = $request->desc;
        $close                 = $request->close;
        $ofc_comnt             = $request->ofc_comments;
        $lession_learn         = $request->lession_learn;

        $corrective_action     = $request->corrective_action;

        $dd_first_first_drop   = $this->getmain($request->incidenttype_first);
        $dd_first_second_drop  = ($this->getsub($request->incidenttype_second)) ? $this->getsub($request->incidenttype_second) : $report->incident_type_two;
        $dd_first_third_drop   = ($this->getter($request->incidenttype_third)) ? $this->getter($request->incidenttype_third) : $report->incident_type_three;

        $dd_second_first_drop  = $this->getmain($request->immediatecause_first);
        $dd_second_second_drop = ($this->getsub($request->immediatecause_second)) ? $this->getsub($request->immediatecause_second) : $report->immediate_cause_two;
        $dd_second_third_drop  = ($this->getter($request->immediatecause_third)) ? $this->getter($request->immediatecause_third) : $report->immediate_cause_three;

        // Root causes
        if ($request->rootcauses_first)
        {
            if (count($request->rootcauses_first) < 1 || $request->rootcauses_first[0] == 0)
            {
                $rootcause_frst_drop   = $report->preventive_actions_one;
            }
            else
            {
                $rootcause_frst_drop   = null;
                for ($i                     = 0;$i < count($request->rootcauses_first);$i++)
                {
                    $rootcause_frst_drop .= $this->getmain($request->rootcauses_first[$i]);
                    if ($i < count($request->rootcauses_first) - 1)
                    {
                        $rootcause_frst_drop .= ',';
                    }
                }
            }
        }
        else
        {
            $rootcause_frst_drop   = $report->preventive_actions_one;
        }

        if ($request->rootcauses_second)
        {
            if (count($request->rootcauses_second) < 1 || $request->rootcauses_second[0] == 0)
            {
                $rootcause_second_drop = $report->preventive_actions_two;
            }
            else
            {
                $rootcause_second_drop = null;
                for ($i                     = 0;$i < count($request->rootcauses_second);$i++)
                {
                    $rootcause_second_drop .= $this->getsub($request->rootcauses_second[$i]);
                    if ($i < count($request->rootcauses_second) - 1)
                    {
                        $rootcause_second_drop .= ',';
                    }
                }
            }
        }
        else
        {
            $rootcause_second_drop = $report->preventive_actions_two;
        }

        if ($request->rootcauses_third)
        {
            if (count($request->rootcauses_third) < 1 || $request->rootcauses_third[0] == 0)
            {
                $rootcause_third_drop  = $report->preventive_actions_three;
            }
            else
            {
                $rootcause_third_drop  = null;
                for ($i                     = 0;$i < count($request->rootcauses_third);$i++)
                {
                    $rootcause_third_drop .= $this->getter($request->rootcauses_third[$i]);
                    if ($i < count($request->rootcauses_third) - 1)
                    {
                        $rootcause_third_drop .= ',';
                    }
                }
            }
        }
        else
        {
            $rootcause_third_drop         = $report->preventive_actions_three;
        }

        $dd_third_first_drop          = $rootcause_frst_drop;
        $dd_third_second_drop         = $rootcause_second_drop;
        $dd_third_third_drop          = $rootcause_third_drop;

        // Preventive action
        if ($request->preventiveactions_first)
        {
            if (count($request->preventiveactions_first) < 1 || $request->preventiveactions_first[0] == 0)
            {
                $preventiveactions_first_drop = $report->preventive_actions_one;
            }
            else
            {
                $preventiveactions_first_drop = null;
                for ($i                            = 0;$i < count($request->preventiveactions_first);$i++)
                {
                    $preventiveactions_first_drop .= $this->getmain($request->preventiveactions_first[$i]);
                    if ($i < count($request->preventiveactions_first) - 1)
                    {
                        $preventiveactions_first_drop .= ',';
                    }
                }
            }
        }
        else
        {
            $preventiveactions_first_drop  = $report->preventive_actions_one;
        }

        if ($request->preventiveactions_second)
        {
            if (count($request->preventiveactions_second) < 1 || $request->preventiveactions_second[0] == 0)
            {
                $preventiveactions_second_drop = $report->preventive_actions_two;
            }
            else
            {
                $preventiveactions_second_drop = null;
                for ($i                             = 0;$i < count($request->preventiveactions_second);$i++)
                {
                    $preventiveactions_second_drop .= $this->getsub($request->preventiveactions_second[$i]);
                    if ($i < count($request->preventiveactions_second) - 1)
                    {
                        $preventiveactions_second_drop .= ',';
                    }
                }
            }
        }
        else
        {
            $preventiveactions_second_drop = $report->preventive_actions_two;
        }

        if ($request->preventiveactions_third)
        {
            if (count($request->preventiveactions_third) < 1 || $request->preventiveactions_third[0] == 0)
            {
                $preventiveactions_third_drop  = $report->preventive_actions_three;
            }
            else
            {
                $preventiveactions_third_drop  = null;
                for ($i                             = 0;$i < count($request->preventiveactions_third);$i++)
                {
                    $preventiveactions_third_drop .= $this->getter($request->preventiveactions_third[$i]);
                    if ($i < count($request->preventiveactions_third) - 1)
                    {
                        $preventiveactions_third_drop .= ',';
                    }
                }
            }
        }
        else
        {
            $preventiveactions_third_drop = $report->preventive_actions_three;
        }

        $dd_fourth_first_drop         = $preventiveactions_first_drop;
        $dd_fourth_second_drop        = $preventiveactions_second_drop;
        $dd_fourth_third_drop         = $preventiveactions_third_drop;
        $preventive_action_note       = $request->preventive_note;
        // dd($date, $descr, $dd_first_second_drop);


        NearMissModel::where('id', $id)->update([
            'date' => $date,
            'describtion' => $descr,

            'incident_type_one' => $dd_first_first_drop,
            'incident_type_two' => $dd_first_second_drop,
            'incident_type_three' => $dd_first_third_drop,

            'immediate_cause_one' => $dd_second_first_drop,
            'immediate_cause_two' => $dd_second_second_drop,
            'immediate_cause_three' => $dd_second_third_drop,

            'corrective_action' => $corrective_action,

            'root_causes_one' => $dd_third_first_drop,
            'root_causes_two' => $dd_third_second_drop,
            'root_causes_three' => $dd_third_third_drop,

            'preventive_actions_one' => $dd_fourth_first_drop,
            'preventive_actions_two' => $dd_fourth_second_drop,
            'preventive_actions_three' => $dd_fourth_third_drop,
            'preventive_actions_note' => $preventive_action_note,

            'close' => $close,
            'office_comments' => $ofc_comnt,
            'lession_learnt' => $lession_learn,
            'updated_at' => $current_date_time,
            'status'  => $status_update

        ]);

        return redirect(url('/Near_Miss'))->with('status', 'Data Updated !!');
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

        // dd($id);
        // NearMissModel->where('id', $id)->delete();
        $user = User::find(session('id'));
        if($user->hasPermissionTo('delete.nearmiss')){
            $current_time = Carbon::now()->toDateTimeString();
            NearMissModel
                ::where('id', $id)->update(['deleted_at' => $current_time, ]);

            return redirect(route('Near_Miss'))->with('status', 'Data Deleted !!');
        }
        else{
            abort(404);
        }
    }

    function printPDF_Nearmiss($id)
    {
        $nmr = NearMissModel::where('id', $id)->get() [0];
        $pdf = PDF::loadView('NearMissAccident.pdf_vw', compact('nmr'));
        return $pdf->download('Report-' . $nmr->date . '.pdf');
    }

    function printPDFAll_Nearmiss($id)
    {
        $nmr_arr = array();
        $id_arr  = explode(',', $id);
        for ($i       = 0;$i < count($id_arr);$i++)
        {
            $nmr_arr[$id_arr[$i]]     = NearMissModel::find($id_arr[$i]);
        }

        $pdf = PDF::loadView('NearMissAccident.pdf_vw_all', compact('nmr_arr'));
        return $pdf->download('Report-All.pdf');
    }

    // ============================= AJAX API ==============================
    function findSub(Request $req)
    {
        if ($req->id == '-----')
        {
            return response()
                ->json(0, 201);
        }
        else
        {
            $dropsub = DB::table('near_miss_dropdown_sub_type')->where('main_type_id', $req->id)
                ->get();
        }
        // $dropsub = $req->id;
        if (!empty($dropsub))
        {
            return response()->json($dropsub, 201);
        }
        else
        {
            return response()->json(0, 201);
        }
    }
    public function col($md, $col, $content, $heading)
    {
        $cont = "
                    <div class='col-$col col-md-$md'>
                        <h6 class='font-weight-bold'>$heading </h6> ";
        if (is_array($content))
        {
            if (count($content) <= 0)
            {
                $cont .= "N/A";
            }
            else
            {
                $cont .= " <ol>";
                foreach ($content as $c)
                {
                    if ($c != '')
                    {
                        $cont .= "<li class=''> $c </li>";
                    }
                }
                $cont .= "</ol>";
            }
        }
        else
        {
            if ($content != '')
            {

                $cont .= "<h6>" . $content . " </h6> ";
            }
            else
            {
                $cont .= "<h6> N/A </h6> ";
            }
        }
        $cont .= " </div>";

        return $cont;
    }

    function findTer(Request $req)
    {
        $dropter = DB::table('near_miss_dropdown_ter_type')->where('sub_id', $req->id)
            ->get();
        // $dropsub = $req->id;
        if (!empty($dropter))
        {
            return response()->json($dropter, 201);
        }
        else
        {
            return response()->json(0, 201);
        }
    }


    // Return Data for data tables .....
    function getnearmiss(Request $req)
    {

        $nm_data          = NearMissModel::where('deleted_at','=',NULL);

        if($req->is_ship){
            $nm_data = $nm_data->where('creator_id',$req->creator_id);
        }



        $searchValue = $req->searchValue;

        if ($req->input('adm') != '1')
        {
            $nm_data          = $nm_data->where('created_by', $req->input('uid'));
        }

        $totaldata        = $nm_data->count();

        $limit            = $req->input('length');
        $start            = $req->input('start');

        $totalFiltered    = $totaldata;

        if (empty($searchValue) == 1)
        {
            $Near_miss        = $nm_data->orderBy('updated_at','DESC')->offset($start)->limit($limit)->get();
        }
        else
        {
            // $columnsForSearch = ['id', 'date', 'describtion', 'incident_type_one', 'incident_type_two', 'incident_type_three', 'immediate_cause_one', 'immediate_cause_two', 'immediate_cause_three', 'corrective_action', 'root_causes_one', 'root_causes_two', 'root_causes_three', 'preventive_actions_one', 'preventive_actions_two', 'preventive_actions_three', 'close', 'office_comments', 'lession_learnt', ];
            // foreach ($columnsForSearch as $column){}

            // $nm_data->Where('id','LIKE',"%mrysh-nearmiss-3%");

            $nm_data->where(function($query) use($searchValue){
                                $query ->where('date','LIKE',"%".$searchValue."%")
                                        ->orWhere('id', 'LIKE', "%".$searchValue."%")
                                        ->orWhere('describtion','LIKE',"%".$searchValue."%")
                                        ->orWhere('incident_type_one','LIKE',"%".$searchValue."%")
                                        ->orWhere('incident_type_two','LIKE',"%".$searchValue."%")
                                        ->orWhere('incident_type_three','LIKE',"%".$searchValue."%")
                                        ->orWhere('immediate_cause_one','LIKE',"%".$searchValue."%")
                                        ->orWhere('immediate_cause_two','LIKE',"%".$searchValue."%")
                                        ->orWhere('immediate_cause_three','LIKE',"%".$searchValue."%")
                                        ->orWhere('corrective_action','LIKE',"%".$searchValue."%")
                                        ->orWhere('root_causes_one','LIKE',"%".$searchValue."%")
                                        ->orWhere('root_causes_two','LIKE',"%".$searchValue."%")
                                        ->orWhere('root_causes_three','LIKE',"%".$searchValue."%")
                                        ->orWhere('preventive_actions_one','LIKE',"%".$searchValue."%")
                                        ->orWhere('preventive_actions_two','LIKE',"%".$searchValue."%")
                                        ->orWhere('preventive_actions_three','LIKE',"%".$searchValue."%")
                                        ->orWhere('office_comments','LIKE',"%".$searchValue."%")
                                        ->orWhere('lession_learnt','LIKE',"%".$searchValue."%")
                                        ->orWhere('status','LIKE',"%".$searchValue."%");
                            });

            $Near_miss     = $nm_data->orderBy('updated_at','DESC')->offset($start)->limit($limit)->get();


            $totalFiltered = $nm_data->count();


        }


        $data          = array();
        if (!empty($Near_miss))
        {
            foreach ($Near_miss as $post)
            {
                // Action
                // ============================
                $Action        = "
                            <!-- Print Button
                            =========================-->
                            <a href='/near-pdf/" . $post->id . "' class='btn print mt-3' title='Print'>
                                <i class='fas fa-print'></i>
                            </a>

                            <!-- Edit Button
                            =========================-->
                            <a href='/Near_Miss_edit/" . $post->id . "' class='btn edit mt-3' title='Edit'>
                                <i class='fas fa-edit'></i>
                            </a>


                            <!-- Delete Button
                            =========================-->
                            <button type='button' class='btn delete mt-3' data-toggle='modal' data-target='#exampleModal_".$post->id. "' title='Delete'>
                                <i class='fas fa-trash-alt'></i>
                            </button>

                            <div class='modal fade' id='exampleModal_" . $post->id . "' tabindex='-1' aria-labelledby='exampleModalLabel' aria-hidden='true'>
                                <div class='modal-dialog modal-dialog-centered'>
                                    <div class='modal-content'>
                                    <div class='modal-body p-5'>
                                        <h1 class='text-center text-danger '><i class='fas fa-trash-alt'></i></h1>
                                        <h3 class='text-center my-3 removeit '> Do you want to delete?</h3>
                                        <button style='border: 1px solid #00000093' type='button' class='btn btn-light shadow mx-3 w-25 removeit' data-dismiss='modal'>No</button>
                                        <a style='border: 1px solid #099b6393' href='/Near_Miss_delete/" . $post->id . "' class='w-25 btn shadow btn-success'>Yes</a>
                                    </div>
                                    </div>
                                </div>
                            </div>
                    ";

                // Describtion
                // ==========================
                if (strlen($post->describtion) > 9)
                {
                    $var_post = $post->incident_type_one;
                    $var1          = 'desc' . $post->id;
                    $var2          = 'desc_readmore' . $post->id;
                    $describ       = '
                            <p class="show_less" id="' . $var1 . '">
                        ' . $post->describtion . '
                            </p>
                            <a href="javascript:void(0)" id="' . $var2 . '" style="text-decoration:none;color:blue;" onclick=toggleReadMoreLess("' . $var1 . '","' . $var2 . '")>
                                Read More
                            </a>
                        ';
                }
                else
                {
                    $describ       = $post->describtion;
                    $var_post = $post->incident_type_one;

                }

                // incident_Type
                // =======================================
                $incident_Type = '
                            <table style="height: 100%; background-color:transparent;" border="0">
                                <tr style="background-color:transparent;">
                                    <th>Primary</th>
                        ';

                if ($post->incident_type_two != '-----')
                {
                    $incident_Type .= '<th>Secondary</th>';
                }

                if ($post->incident_type_three != '-----')
                {
                    $incident_Type .= '<th>Tertiary</th>';
                }

                $incident_Type .= '
                            </tr>
                            <tr style="background-color:transparent;">
                                <td>
                        ';

                // primary incident_type
                if (strlen($post->incident_type_one) > 6)
                {
                    $incident_Type .= '
                            <p class="show_less" id="incident_one' . $post->id . '"> ' . $post->incident_type_one . '</p>
                            <a href="javascript:void(0)" id="incident_one_readmore' . $post->id . '" style=" text-decoration:none; color:blue;" onclick=toggleReadMoreLess("incident_one' . $post->id . '","incident_one_readmore' . $post->id . '")>Read More</a>
                            ';
                }
                else
                {
                    $incident_Type .= $post->incident_type_one;
                }

                $incident_Type .= '</td>';

                // Secondary incident_type
                if ($post->incident_type_two != '-----')
                {
                    $incident_Type .= '<td>';

                    if (strlen($post->incident_type_two) > 6)
                    {
                        $incident_Type .= '
                                <p class="show_less" id="incident_two' . $post->id . '"> ' . $post->incident_type_two . ' </p>
                                <a href="javascript:void(0)" id="incident_two_readmore' . $post->id . '" style=" text-decoration:none; color:blue;" onclick=toggleReadMoreLess("incident_two' . $post->id . '","incident_two_readmore' . $post->id . '")> Read More </a>
                                ';
                    }
                    else
                    {
                        $incident_Type .= $post->incident_type_two;
                    }

                    $incident_Type .= '</td>';

                }

                // Tertiary incident_type
                if ($post->incident_type_three != '-----')
                {
                    $incident_Type .= '<td>';

                    if (strlen($post->incident_type_three) > 6)
                    {
                        $incident_Type .= ' <p class="show_less" id="incident_three' . $post->id . '"> ' . $post->incident_type_three . '  </p>
                                    <a href="javascript:void(0)" id="incident_three_readmore' . $post->id . '" style=" text-decoration:none; color:blue;" onclick=toggleReadMoreLess("incident_three' . $post->id . '","incident_three_readmore' . $post->id . '")> Read More </a>';
                    }
                    else
                    {
                        $incident_Type .= $post->incident_type_three;
                    }

                    $incident_Type .= '</td>';
                }
                $incident_Type .= '</tr> ';
                $incident_Type .= '</table>';

                // immediate_cause
                // =======================================
                $Immediate_cause = '
                        <table style="height: 100%; background-color:transparent;" border="0">
                            <tr style="background-color:transparent;">
                                <th>Primary</th>
                    ';

                if ($post->immediate_cause_two != '-----')
                {
                    $Immediate_cause .= '<th>Secondary</th>';
                }

                if ($post->immediate_cause_three != '-----')
                {
                    $Immediate_cause .= '<th>Tertiary</th>';
                }

                $Immediate_cause .= '
                        </tr>
                        <tr style="background-color:transparent;">
                            <td>
                    ';

                // primary Immediate_cause
                if (strlen($post->immediate_cause_one) > 6)
                {
                    $Immediate_cause .= '
                        <p class="show_less" id="immediate_cause_one' . $post->id . '"> ' . $post->immediate_cause_one . '</p>
                        <a href="javascript:void(0)" id="immediate_cause_one_readmore' . $post->id . '" style=" text-decoration:none; color:blue;" onclick=toggleReadMoreLess("immediate_cause_one' . $post->id . '","immediate_cause_one_readmore' . $post->id . '")>Read More</a>
                        ';
                }
                else
                {
                    $Immediate_cause .= $post->immediate_cause_one;
                }

                $Immediate_cause .= '</td>';

                // Secondary Immediate_cause
                if ($post->immediate_cause_two != '-----')
                {
                    $Immediate_cause .= '<td>';

                    if (strlen($post->immediate_cause_two) > 6)
                    {
                        $Immediate_cause .= '
                            <p class="show_less" id="immediate_cause_two' . $post->id . '"> ' . $post->immediate_cause_two . ' </p>
                            <a href="javascript:void(0)" id="immediate_cause_two_readmore' . $post->id . '" style=" text-decoration:none; color:blue;" onclick=toggleReadMoreLess("immediate_cause_two' . $post->id . '","immediate_cause_two_readmore' . $post->id . '")> Read More </a>
                            ';
                    }
                    else
                    {
                        $Immediate_cause .= $post->immediate_cause_two;
                    }

                    $Immediate_cause .= '</td>';

                }

                // Tertiary Immediate_cause
                if ($post->immediate_cause_three != '-----')
                {
                    $Immediate_cause .= '<td>';

                    if (strlen($post->immediate_cause_three) > 6)
                    {
                        $Immediate_cause .= ' <p class="show_less" id="immediate_cause_three' . $post->id . '"> ' . $post->immediate_cause_three . '  </p>
                                <a href="javascript:void(0)" id="immediate_cause_three_readmore' . $post->id . '" style=" text-decoration:none; color:blue;" onclick=toggleReadMoreLess("immediate_cause_three' . $post->id . '","immediate_cause_three_readmore' . $post->id . '")> Read More </a>';
                    }
                    else
                    {
                        $Immediate_cause .= $post->immediate_cause_three;
                    }

                    $Immediate_cause .= '</td>';
                }
                $Immediate_cause .= '</tr> ';
                $Immediate_cause .= '</table>';

                // Root_causes
                // =======================================
                $Rooot_causes = '
                            <table style="height: 100%; background-color:transparent;" border="0">
                                <tr style="background-color:transparent;">
                                    <th>Primary</th>
                        ';

                if ($post->root_causes_two != '-----')
                {
                    $Rooot_causes .= '<th>Secondary</th>';
                }

                if ($post->root_causes_three != '-----')
                {
                    $Rooot_causes .= '<th>Tertiary</th>';
                }

                $Rooot_causes .= '
                            </tr>
                            <tr style="background-color:transparent;">
                                <td>
                        ';

                // primary root_causes
                if (strlen($post->root_causes_one) > 6)
                {
                    $Rooot_causes .= '
                            <p class="show_less" id="root_causes_one' . $post->id . '"> ' . $post->root_causes_one . '</p>
                            <a href="javascript:void(0)" id="root_causes_one_readmore' . $post->id . '" style=" text-decoration:none; color:blue;" onclick=toggleReadMoreLess("root_causes_one' . $post->id . '","root_causes_one_readmore' . $post->id . '")>Read More</a>
                            ';
                }
                else
                {
                    $Rooot_causes .= $post->root_causes_one;
                }

                $Rooot_causes .= '</td>';

                // Secondary root_causes
                if ($post->root_causes_two != '-----')
                {
                    $Rooot_causes .= '<td>';

                    if (strlen($post->root_causes_two) > 6)
                    {
                        $Rooot_causes .= '
                                <p class="show_less" id="root_causes_two' . $post->id . '"> ' . $post->root_causes_two . ' </p>
                                <a href="javascript:void(0)" id="root_causes_two_readmore' . $post->id . '" style=" text-decoration:none; color:blue;" onclick=toggleReadMoreLess("root_causes_two' . $post->id . '","root_causes_readmore' . $post->id . '")> Read More </a>
                                ';
                    }
                    else
                    {
                        $Rooot_causes .= $post->root_causes_two;
                    }

                    $Rooot_causes .= '</td>';

                }

                // Tertiary root_causes
                if ($post->root_causes_three != '-----')
                {
                    $Rooot_causes .= '<td>';

                    if (strlen($post->root_causes_three) > 6)
                    {
                        $Rooot_causes .= ' <p class="show_less" id="root_causes_three' . $post->id . '"> ' . $post->root_causes_three . '  </p>
                                    <a href="javascript:void(0)" id="root_causes_three_readmore' . $post->id . '" style=" text-decoration:none; color:blue;" onclick=toggleReadMoreLess("root_causes_three' . $post->id . '","root_causes_three_readmore' . $post->id . '")> Read More </a>';
                    }
                    else
                    {
                        $Rooot_causes .= $post->root_causes_three;
                    }

                    $Rooot_causes .= '</td>';
                }
                $Rooot_causes .= '</tr> ';
                $Rooot_causes .= '</table>';

                // preventive_actions
                // =======================================
                $PreventivE_Actions = '
                            <table style="height: 100%; background-color:transparent;" border="0">
                                <tr style="background-color:transparent;">
                                    <th>Primary</th>
                        ';

                if ($post->preventive_actions_two != '-----')
                {
                    $PreventivE_Actions .= '<th>Secondary</th>';
                }

                if ($post->preventive_actions_three != '-----')
                {
                    $PreventivE_Actions .= '<th>Tertiary</th>';
                }

                $PreventivE_Actions .= '
                            </tr>
                            <tr style="background-color:transparent;">
                                <td>
                        ';

                // primary preventive_actions
                if (strlen($post->preventive_actions_one) > 6)
                {
                    $PreventivE_Actions .= '
                            <p class="show_less" id="preventive_actions_one' . $post->id . '"> ' . $post->preventive_actions_one . '</p>
                            <a href="javascript:void(0)" id="preventive_actions_one_readmore' . $post->id . '" style=" text-decoration:none; color:blue;" onclick=toggleReadMoreLess("preventive_actions_one' . $post->id . '","preventive_actions_one_readmore' . $post->id . '")>Read More</a>
                            ';
                }
                else
                {
                    $PreventivE_Actions .= $post->preventive_actions_one;
                }

                $PreventivE_Actions .= '</td>';

                // Secondary preventive_actions
                if ($post->preventive_actions_two != '-----')
                {
                    $PreventivE_Actions .= '<td>';

                    if (strlen($post->preventive_actions_two) > 6)
                    {
                        $PreventivE_Actions .= '
                                <p class="show_less" id="preventive_actions_two' . $post->id . '"> ' . $post->preventive_actions_two . ' </p>
                                <a href="javascript:void(0)" id="preventive_actions_two_readmore' . $post->id . '" style=" text-decoration:none; color:blue;" onclick=toggleReadMoreLess("preventive_actions_two' . $post->id . '","preventive_actions_two_readmore' . $post->id . '")> Read More </a>
                                ';
                    }
                    else
                    {
                        $PreventivE_Actions .= $post->preventive_actions_two;
                    }

                    $PreventivE_Actions .= '</td>';

                }

                // Tertiary preventive_actions
                if ($post->preventive_actions_three != '-----')
                {
                    $PreventivE_Actions .= '<td>';

                    if (strlen($post->preventive_actions_three) > 6)
                    {
                        $PreventivE_Actions .= ' <p class="show_less" id="preventive_actions_three' . $post->id . '"> ' . $post->preventive_actions_three . '  </p>
                                    <a href="javascript:void(0)" id="preventive_actions_three_readmore' . $post->id . '" style=" text-decoration:none; color:blue;" onclick=toggleReadMoreLess("preventive_actions_three' . $post->id . '","preventive_actions_three_readmore' . $post->id . '")> Read More </a>';
                    }
                    else
                    {
                        $PreventivE_Actions .= $post->preventive_actions_three;
                    }

                    $PreventivE_Actions .= '</td>';
                }
                $PreventivE_Actions .= '</tr> ';
                $PreventivE_Actions .= '</table>';


                // Corrective action
                // =======================================
                if (strlen($post->corrective_action) > 6)
                {

                    $ca   = '
                            <p class="show_less" id="corrective_action' . $post->id . '">
                            ' . $post->corrective_action . '
                            </p>
                            <a href="javascript:void(0)"  id="ccorrective_action_readmore' . $post->id . '" style="text-decoration:none; color:blue;" onclick=toggleReadMoreLess("corrective_action' . $post->id . '","ccorrective_action_readmore' . $post->id . '")> Read More </a>
                        ';
                }
                else
                {
                    $ca   = $post->corrective_action;
                }

                // ofice comments
                // ==================================
                if (strlen($post->office_comments) > 6)
                {
                    $oc   = ' <p class="show_less" id="office_comments' . $post->id . '">
                            ' . $post->office_comments . '
                        </p>
                        <a href="javascript:void(0)"  id="office_comments_readmore' . $post->id . '" style="text-decoration:none; color:blue;" onclick=toggleReadMoreLess("office_comments' . $post->id . '","office_comments_readmore' . $post->id . '")>
                            Read More
                        </a>';
                }
                else
                {
                    $oc   = $post->office_comments;
                }

                // lession learnet
                // ================================
                if (strlen($post->lession_learnt) > 6)
                {

                    $ll   = '<p class="show_less" id="les' . $post->id . '">
                            ' . $post->lession_learnt . '
                        </p>
                        <a href="javascript:void(0)"  id="ll_readmore' . $post->id . '" style="text-decoration:none; color:blue;" onclick=toggleReadMoreLess("les' . $post->id . '","ll_readmore' . $post->id . '")>
                            Read More
                        </a>';
                }
                else
                {
                    $ll   = $post->lession_learnt;
                }
                $itca = "<!-- Button trigger modal -->
                <button type='button' class='btn text-dark numo-btn      p-1'       data-toggle='modal'   data-target='#itca_$post->id'>
                        <i class='fas fa-eye'>View</i>
                        </button>
                <!-- The Modal -->
                        <div class='modal fade' id='itca_$post->id'>
                          <div class='modal-dialog'>
                            <div class='modal-content'>

                              <!-- Modal Header -->
                              <div class='modal-header'>
                              <h2 class='modal-title font-weight-bold' id='exampleModalLongTitle'>Description & Incident Type & Corrective action</h2>
                                <button type='button' class='close' data-dismiss='modal'>&times;</button>
                              </div>

                              <!-- Modal body -->
                              <div class='modal-body'>
                                <div class='row'>
                                     " . $this->col('4', '12', (isset($describ) ? $describ : 'N/A') , 'Description') . "
                                    " . $this->col('4', '12', (isset($var_post) ? $var_post : 'N/A') , 'Incident Type') . "

                                    " . $this->col('4', '12', (isset($post->corrective_action) ? $post->corrective_action : 'N/A') , 'Corrective action') . "

                                </div>
                              </div>

                              <!-- Modal footer -->
                              <div class='modal-footer'>

                                <button type='button' class='btn btn-danger' data-dismiss='modal'>Close</button>
                              </div>

                            </div>
                          </div>
                        </div>

                ";
                // start innediate cause
                $ic   = "<!-- Button trigger modal -->
                <button type='button' class='btn text-dark numo-btn      p-1'       data-toggle='modal'   data-target='#ic_$post->id'>
                        <i class='fas fa-eye'>View</i>
                        </button>
                        <!-- Modal -->
                        <div class='modal fade' id='ic_$post->id' tabindex='-1' role='dialog' aria-labelledby='exampleModalLongTitle' aria-hidden='true'>
                                <div class='modal-dialog modal-lg' role='document'>
                                    <div class='modal-content'>
                                        <div class='modal-header'>
                                            <h2 class='modal-title font-weight-bold' id='exampleModalLongTitle'>Immediate Causes</h2>
                                        </div>
                                        <div class='modal-body text-left'>

                                            <div class='row'>
                                            " . $this->col('4', '12', $post->root_causes_one, 'Primary') . "";

                if ($post->immediate_cause_two != '-----')
                {
                    $ic .= "" . $this->col('4', '12', $post->immediate_cause_two, 'Secondary') . "";
                }
                if ($post->immediate_cause_three != '-----')
                {
                    $ic .= "" . $this->col('4', '12', $post->immediate_cause_three, 'Tertiary') . "";
                }
                //  $rc.= ". $this->col('3' , '12' ,$post->root_causes_one, 'Primary') .";


                $ic .= " </div>
                                            <div class='modal-footer'>
                                                <button type='button' class='btn btn-danger text-white numo-btn-close' data-dismiss='modal'><i class='far fa-times-circle mr-1'></i>Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        </div>";
                // end innediate cause
                // Start root cause
                $rc = "<!-- Button trigger modal -->
                         <button type='button' class='btn text-dark numo-btn      p-1'       data-toggle='modal'   data-target='#rc_$post->id'>
                        <i class='fas fa-eye'>View</i>
                        </button>
                        <!-- Modal -->
                        <div class='modal fade' id='rc_$post->id' tabindex='-1' role='dialog' aria-labelledby='exampleModalLongTitle' aria-hidden='true'>
                                <div class='modal-dialog modal-lg' role='document'>
                                    <div class='modal-content'>
                                        <div class='modal-header'>
                                            <h2 class='modal-title font-weight-bold' id='exampleModalLongTitle'>Root Causes</h2>
                                        </div>
                                        <div class='modal-body text-left'>

                                            <div class='row'>
                                            " . $this->col('4', '12', $post->root_causes_one, 'Primary') . "";

                if ($post->root_causes_two != '-----')
                {
                    $rc .= "" . $this->col('4', '12', $post->root_causes_two, 'Secondary') . "";
                }
                if ($post->root_causes_three != '-----')
                {
                    $rc .= "" . $this->col('4', '12', $post->root_causes_two, 'Tertiary') . "";
                }
                //  $rc.= ". $this->col('3' , '12' ,$post->root_causes_one, 'Primary') .";


                $rc .= " </div>
                                            <div class='modal-footer'>
                                                <button type='button' class='btn btn-danger text-white numo-btn-close' data-dismiss='modal'><i class='far fa-times-circle mr-1'></i>Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        </div>";
                // end root cause
                // start preventive action
                $pa = "<!-- Button trigger modal -->
                    <button type='button' class='btn text-dark numo-btn      p-1'       data-toggle='modal'   data-target='#pa_$post->id'>
                            <i class='fas fa-eye'>View</i>
                            </button>
                            <!-- Modal -->
                            <div class='modal fade' id='pa_$post->id' tabindex='-1' role='dialog' aria-labelledby='exampleModalLongTitle' aria-hidden='true'>
                                    <div class='modal-dialog modal-lg' role='document'>
                                        <div class='modal-content'>
                                            <div class='modal-header'>
                                                <h2 class='modal-title font-weight-bold' id='exampleModalLongTitle'>Preventive Action</h2>
                                            </div>
                                            <div class='modal-body text-left'>

                                                <div class='row'>
                                                " . $this->col('4', '12', $post->preventive_actions_one, 'Primary') . "";
                                                if ($post->preventive_actions_two != '-----')
                                                {
                                                    $pa .= "" . $this->col('4', '12', $post->preventive_actions_two, 'Secondary') . "";
                                                }
                                                if ($post->preventive_actions_three != '-----')
                                                {
                                                    $pa .= "" . $this->col('4', '12', $post->preventive_actions_three, 'Tertiary') . "";
                                                }

                $pa .= "" . $this->col('12', '12', $post->preventive_actions_note, 'Preventive Action Note') . "";

                $pa .= " </div>
                                    <div class='modal-footer'>
                                    <button type='button' class='btn btn-danger text-white numo-btn-close' data-dismiss='modal'><i class='far fa-times-circle mr-1'></i>Close</button>
                                        </div>
                                    </div>
                                    </div>
                                    </div>
                                </div>";
                //end preventive action
                //start ocll
                $ocll       = "<button type='button' class='btn text-dark numo-btn      p-1'       data-toggle='modal'   data-target='#ocll_$post->id'>
                        <i class='fas fa-eye'>View</i>
                        </button>

                        <!-- The Modal -->
                        <div class='modal' id='ocll_$post->id'>
                          <div class='modal-dialog'>
                            <div class='modal-content'>

                              <!-- Modal Header -->
                              <div class='modal-header'>
                                Closed & Office Comments & Learn lession
                                <button type='button' class='close' data-dismiss='modal'>&times;</button>
                              </div>

                              <!-- Modal body -->
                              <div class='modal-body'>
                                <div class='row'>
                                    " . $this->col('4', '12', (isset($post->close) ? $post->close : 'N/A') , 'Closed') . "
                                    " . $this->col('4', '12', (isset($post->lession_learnt) ? $post->lession_learnt : 'N/A') , 'Learn lession') . "
                                    " . $this->col('4', '12', (isset($post->office_comments) ? $post->office_comments : 'N/A') , 'Office comments') . "
                                </div>
                              </div>

                              <!-- Modal footer -->
                              <div class='modal-footer'>

                                <button type='button' class='btn btn-danger' data-dismiss='modal'>Close</button>
                              </div>

                            </div>
                          </div>
                        </div>
                        ";
                // end ocll
                $stat_color = 'primary';
                if ($post->status == config('constants.status.Submitted'))
                {
                    $stat_color = 'primary';
                }
                if ($post->status == config('constants.status.Approved'))
                {
                    $stat_color = 'success';
                }
                if ($post->status == config('constants.status.Draft'))
                {
                    $stat_color = 'warning';
                }
                if ($post->status == 'Correction Required')
                {
                    $stat_color = 'warning';
                }
                $nestedData['status']            = "<div class='shadow btn btn-" . $stat_color . "'>" . $post->status . "</div>";
                $nestedData['id']            = $post->id;
                $nestedData['date']            = $post->date;
                // $nestedData['describtion'] = $describ;
                // $nestedData['incident_type'] = $incident_Type;
                // $nestedData['corrective_action'] = $ca;
                $nestedData['itca']            = $itca;
                $nestedData['immediate_cause']            = $ic;
                $nestedData['Root_causes']            = $rc;
                $nestedData['preventive_actions']            = $pa;

                // $nestedData['closed'] = $post->close;
                // $nestedData['office_comments'] = $oc;
                // $nestedData['lesson_earnt'] = $ll;
                $nestedData['ocll']            = $ocll;
                $nestedData['action']            = $Action;
                $data[]            = $nestedData;

            }
        }

        $json_data  = array(
            "draw" => intval($req->input('draw')) ,
            "recordsTotal" => intval($totaldata) ,
            "recordsFiltered" => intval($totalFiltered) ,
            "data" => $data
        );

        echo json_encode($json_data);
    }
    // function that will  cerate a new Draft
    public function createDraft(){
        // dd('I am in create draft');

        $id = (new GenericController)->getUniqueId('near_miss_accident_report',config('constants.UNIQUE_ID_TEXT.NEAR_MISS'));
        if (!Auth::user()->isAdmin())
        {
            $userid                   = Auth::id();
        }
        else
        {
            $userid                   = null;
        }
        // dd($id);
        NearMissModel::insert([
            'id'            =>      $id,
            "created_at"    =>      \Carbon\Carbon::now(), # new \Datetime()
            "updated_at"    =>      \Carbon\Carbon::now(),  # new \Datetime()
            'created_by' =>         $userid,
            'creator_id'    =>      session('creator_id'),
            'status'        =>      config('constants.status.Draft') ,
            'creator_email' =>      session('email')
        ]);
        $url = '/'."Near_Miss_edit/".$id;
        // dd($url);
        // return $id;

        $dropdown = DB::table('near_miss_dropdown')->get();
        $report   = NearMissModel::find($id);

        $dropmain = DB::table('near_miss_dropdown_main_type')->get();
        return view('NearMissAccident.addnew', ['dropdown'                       => $dropdown, 'dropdownmain'                       => $dropmain, 'data'                       => $report]);
    }
    // collect last draft and render edit blede
    public function collectDraft(){
        $draft = NearMissModel::where('creator_email',session('email'))
        ->where('status','Draft')
        ->orderBy('created_at','DESC')
        ->first();
        return redirect('/Near_Miss_edit/'.$draft->id);
    }
    // autoSave
    public function autosave(Request $r){
        // Log::info('hey :: '.print_r($r->id,true));
        // Log::info('step 0 : '.print_r($r->all(),true));
        if($r->step == 0){

            Log::info('step 0 : '.print_r($r->all(),true));
            NearMissModel::where('id',$r->id)
                        ->update([
                            'date'          => $r->date,
                            'describtion'   => $r->description,
                            'severity'      => $r->severity,
                            'likelihood'    => $r->likelihood,
                            'result'        => $r->result,
                        ]);
        }
        elseif($r->step == 1){

            Log::info('step 1 : '.print_r($r->all(),true));
            if($r->incident_1){
                // 1st incident type
                $incident_1      = $this->getmain($r->incident_1);
                // 2nd incident type
                $incident_2     = ($this->getsub($r->incident_2)) ? $this->getsub($r->incident_2) : "-----";
                // 3rd incident type
                $incident_3      = ($this->getter($r->incident_3)) ? $this->getter($r->incident_3) : "-----";
                $corrective_action = $r->corrective_action;

                NearMissModel::where('id',$r->id)
                            ->update([
                                'incident_type_one'     =>  $incident_1,
                                'incident_type_two'     =>  $incident_2,
                                'incident_type_three'   =>  $incident_3,
                                'corrective_action'     =>  $corrective_action
                            ]);
            }
        }
        elseif($r->step == 2){
            Log::info('step 2 : '.print_r($r->all(),true));
            $immediate_1     = $this->getmain($r->immediate_1);
            $immediate_2    = ($this->getsub($r->immediate_2)) ? $this->getsub($r->immediate_2) : "-----";
            $immediate_3     = ($this->getter($r->immediate_3)) ? $this->getter($r->immediate_3) : "-----";
            NearMissModel::where('id',$r->id)
            ->update([
                'immediate_cause_one' => $immediate_1,
                'immediate_cause_two' => $immediate_2,
                'immediate_cause_three' => $immediate_3,
            ]);
        }
        elseif($r->step ==3){
            // Log:info('step 3 : '.print_r($r->all(),true));
            $root1 = explode(',',$r->root1);
            // Log::info('root1 : '.print_r($root1,true));
            if (count($root1) < 1 || $root1[0] == 0)
            {
                $rootcause_frst_drop      = "-----";
            }
            else
            {
                $rootcause_frst_drop      = null;
                for ($i                        = 0;$i < count($root1);$i++)
                {
                    $rootcause_frst_drop .= $this->getmain($root1[$i]);
                    if ($i < count($root1) - 1)
                    {
                        $rootcause_frst_drop .= ',';
                    }
                }
            }
            // Log::info('root1 : '.print_r($rootcause_frst_drop,true));
            $root2 = explode(',',$r->root2);
            if ($root2 != null)
            {
                if (count($root2) < 1 || $root2[0] == 0)
                {
                    $rootcause_second_drop = "-----";
                }
                else
                {
                    $rootcause_second_drop = null;
                    for ($i                     = 0;$i < count($root2);$i++)
                    {
                        $rootcause_second_drop .= $this->getsub($root2[$i]);
                        if ($i < count($root2) - 1)
                        {
                            $rootcause_second_drop .= ',';
                        }
                    }
                }
            }
            else
            {
                $rootcause_second_drop = "-----";
            }
            // Log::info('Root2 : '.print_r($rootcause_second_drop,true));
            $root3 = explode(',',$r->root3);
            if ($root3)
            {
                if (count($root3) < 1 || $root3[0] == 0)
                {
                    $rootcause_third_drop  = "-----";
                }
                else
                {
                    $rootcause_third_drop  = null;
                    for ($i                     = 0;$i < count($root3);$i++)
                    {
                        $rootcause_third_drop .= $this->getter($root3[$i]);
                        if ($i < count($root3) - 1)
                        {
                            $rootcause_third_drop .= ',';
                        }
                    }
                }
            }
            else
            {
                $rootcause_third_drop         = "-----";
            }
            // Log::info('Root3 : '.print_r($rootcause_third_drop,true));
            // Log::info('main id : '.print_r($r->id,true));
            NearMissModel::where('id',$r->id)
                        ->update([
                            'root_causes_one' => $rootcause_frst_drop,
                            'root_causes_two' => $rootcause_second_drop,
                            'root_causes_three' => $rootcause_third_drop,
                        ]);

        }
        elseif($r->step == 4){
            Log::info("Preventive : ".print_r($r->all(),true));
            $prevent1 = explode(',',$r->prevent1);
            if ($prevent1)
            {
                if (count($prevent1) < 1 || $prevent1[0] == 0)
                {
                    $preventiveactions_first_drop = "-----";
                }
                else
                {
                    $preventiveactions_first_drop = null;
                    for ($i                            = 0;$i < count($prevent1);$i++)
                    {
                        $preventiveactions_first_drop .= $this->getmain($prevent1[$i]);
                        if ($i < count($prevent1) - 1)
                        {
                            $preventiveactions_first_drop .= ',';
                        }
                    }
                }
            }
            else
            {
                $preventiveactions_first_drop  = "-----";
            }
            $prevent2 = explode(',',$r->prevent2);
            if ($prevent2)
            {
                if (count($prevent2) < 1 || $prevent2[0] == 0)
                {
                    $preventiveactions_second_drop = "-----";
                }
                else
                {
                    $preventiveactions_second_drop = null;
                    for ($i                             = 0;$i < count($prevent2);$i++)
                    {
                        $preventiveactions_second_drop .= $this->getsub($prevent2[$i]);
                        if ($i < count($prevent2) - 1)
                        {
                            $preventiveactions_second_drop .= ',';
                        }
                    }
                }
            }
            else
            {
                $preventiveactions_second_drop = "-----";
            }
            $prevent3 = explode(',',$r->prevent3);
            if ($prevent3)
            {
                if (count($prevent3) < 1 || $prevent3[0] == 0)
                {
                    $preventiveactions_third_drop  = "-----";
                }
                else
                {
                    $preventiveactions_third_drop  = null;
                    for ($i                             = 0;$i < count($prevent3);$i++)
                    {
                        $preventiveactions_third_drop .= $this->getter($prevent3[$i]);
                        if ($i < count($prevent3) - 1)
                        {
                            $preventiveactions_third_drop .= ',';
                        }
                    }
                }
            }
            else
            {
                $preventiveactions_third_drop = "-----";
            }
            NearMissModel::where('id',$r->id)
                        ->update([
                            'preventive_actions_one' => $preventiveactions_first_drop,
                            'preventive_actions_two' => $preventiveactions_second_drop,
                            'preventive_actions_three' => $preventiveactions_third_drop,
                            'preventive_actions_note' => $r->Note,
                        ]);
        }

        return 1;

    }

}


