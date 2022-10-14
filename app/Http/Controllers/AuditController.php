<?php

/**
 * Class and Function List:
 * Function list:
 * - index()
 * - create()
 * - store()
 * - edit()
 * - update()
 * - destroy()
 * - NewDraft()
 * - getaudit()
 * - saveStapOne()
 * - getPSCFormDiv()
 * - getNCObservationFormActionDiv()
 * - getNcObservationFormDiv()
 * - AutoSaveAPI()
 * - Prefill()
 * - EditPrefill()
 * - sendRootCauses()
 * - sendpreventiveaction()
 * - sendpreventiveactionFiles()
 * - sendcorrectiveaction()
 * - sendcorrectiveactionFiles()
 * - sendEvidencePSC()
 * - deleteFormData()
 * - GetFormDataByID()
 * - ChangeStatus()
 * - GenerateID()
 * - DeleteAndCreateNewDraft()
 * - CreateNewDraft()
 * - DeleteLastDataDraft()
 * - DeleteById()
 * - FetchingLastDraftData_If_Drafted()
 * - col()
 * - SaveImg()
 * - FetchMasterDataById()
 * - FetchMasterFormDataById()
 * - getFormData()
 * - getData()
 * Classes list:
 * - AuditController extends Controller
 */

namespace App\Http\Controllers;

use Auth;
use Log;
// use Session;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\Vessel_detailsController;
use App\Http\Controllers\GenericController;
use App\Http\Controllers\NearMissAccidentReporting;
use App\Http\Controllers\FileController as FileSaver;


// MODELS/DB RELATED IMPORTS
use Illuminate\Support\Facades\DB;
use App\Models\AuditRef;
use App\Models\auditmodel;
use App\Models\inspection_and_audit_forms;
use App\Models\inspection_and_audit_form_upload_evidence;
use App\Models\inspection_and_audit_root_causes;
use App\Models\inspection_and_audit_root_causes_sub;
use App\Models\inspection_and_audit_root_causes_ter;
use App\Models\inspection_and_audit_corrective_actions;
use App\Models\inspection_and_audit_corrective_upload_evidence;
use App\Models\inspection_and_audit_preventive_actions;
use App\Models\inspection_and_audit_preventive_actions_sub;
use App\Models\inspection_and_audit_preventive_upload_evidence;
use App\Models\User;


class AuditController extends Controller
{
    /*
        REQUEST TYPE => GET
        DESCRIPTION =>  RENDERS VIEW PAGE
        URL =>  /inspection-audit
    */
    public function index(Request $r)
    {
        try {
            $user = User::find(session('id'));
            if($user->hasPermissionTo('view.audit')){
                $is_ship = session('is_ship');
                $creator_id = session('creator_id');

                $response = [
                    'is_ship' => $is_ship,
                    'creator_id' => $creator_id
                ];
                return view('inspection_audit.audit_view', $response);
            }
            else{
                abort(404);;
            }
        } catch (Exception $e) {
            report($e);
        }
    }

    /*
        REQUEST TYPE => GET
        DESCRIPTION =>  RENDERS CREATE FORM
        URL =>  /inspection-audit/create
    */
    public function create()
    {
        /*
            ==> previous code before auto save
        */
        // // GETTING LOGDED IN SHIP DETAILS
        // $ship     = (new GenericController)->getCreatorId();

        // // FETCH DROPDOWN
        // $dropdown = DB::table('near_miss_dropdown')->get();
        // $dropmain = DB::table('near_miss_dropdown_main_type')->get();

        // // FETCHING CODE AND REF
        // $code     = DB::table('deficiency_codes')->select('id', 'code', 'name')
        //     ->get();
        // $ref      = AuditRef::select('id', 'name')->get();

        // // IF LAST DATA IS DRAFTED IT RETURNS THAT
        // $this->DeleteAndCreateNewDraft();
        // $id                = null;
        // if ($ship) {
        //     $last_drafted_data = $this->FetchingLastDraftData_If_Drafted($ship->unique_id);
        //     if ($last_drafted_data["is_last_a_draft"]) {
        //         $id                = $last_drafted_data["data"]->id;
        //     }

        //     $last              = DB::table('inspection_and_audit_master')->where('inspection_and_audit_master.creator_id', $ship->unique_id)
        //         ->leftJoin('inspection_and_audit_forms', 'inspection_and_audit_forms.inspection_and_audit_form_id', '=', 'inspection_and_audit_master.id')
        //         ->selectRaw('group_concat(inspection_and_audit_forms.id) as forms, inspection_and_audit_master.id')
        //         ->groupBy('inspection_and_audit_master.id')
        //         ->orderBy('inspection_and_audit_master.created_at', 'desc')
        //         ->get();

        //     return view('inspection_audit.audit_create', ['code' => $code, 'ref' => $ref, 'id' => $id, 'name' => $ship->name, 'dropdown' => $dropdown, 'dropdownmain' => $dropmain, 'data' => $last]);
        // } else {
        //     return false;
        // }


        /*
            ==> after auto-save apply on (11-May-2022)
        */
        $user = User::find(session('id'));
        if($user->hasPermissionTo('create.audit')){
            // GETTING LOGDED IN SHIP/SHORE DETAILS
            $ship     = (new GenericController)->getCreatorId();

            // FETCH DROPDOWN
            $dropdown = DB::table('near_miss_dropdown')->get();
            $dropmain = DB::table('near_miss_dropdown_main_type')->get();

            // FETCHING CODE AND REF
            $code     = DB::table('deficiency_codes')->select('id', 'code', 'name')->get();
            $ref      = AuditRef::select('id', 'name')->get();

            // FETCH MASTER TABLE DATA FOR EDIT .....
            $master   = auditmodel::where('creator_id', session('creator_id'))->where('status' , config('constants.status.Draft'))->orderBy('auto_inc', 'desc')->first();
            if($master){
                $id       = $master->id;
            }
            else
            {
                // creating new Draft .....
                $id       = $this->CreateNewDraft();
                // for stopping crete new draft modal to apear .....
                session()->put('audit_new_draft_clicked', true);
            }

            $last     = DB::table('inspection_and_audit_master')->where('inspection_and_audit_master.creator_id', $ship->unique_id)
            ->leftJoin('inspection_and_audit_forms', 'inspection_and_audit_forms.inspection_and_audit_form_id', '=', 'inspection_and_audit_master.id')
            ->selectRaw('group_concat(inspection_and_audit_forms.id) as forms,inspection_and_audit_master.id')
            ->groupBy('inspection_and_audit_master.id')
            // ->orderBy('inspection_and_audit_master.created_at', 'desc')
            ->get();

            return view('inspection_audit.audit_edit', ['code' => $code, 'ref' => $ref, 'id' => $id, 'name' => $ship->name, 'dropdown' => $dropdown, 'dropdownmain' => $dropmain, 'data' => $last]);
        }
        else{
            abort(404);
        }
    }

    /*
        REQUEST TYPE => POST
        DESCRIPTION => CONTROLLER STORE DATA INTO DATABASE
        URL => /inspection-audit/store
    */
    public function store(Request $r)
    {
        $id = $r->id;
        Log::info("All request : ".print_r($r->all(),true));
        if($id){
            $report = auditmodel::find($id);
            if($report){
                if (session('is_ship') == 1){
                    $report->status = config('constants.status.Submitted');
                }
                else{
                    $report->status = config('constants.status.Approved');
                }
                $report->save();
            }
        }

        return redirect(route('inspection_audit'))->with('status', 'Data Added !!');
    }

    /*
        REQUEST TYPE => GET
        DESCRIPTION => CONTROLLER RENDER EDIT FORM
        URL =>  /inspection-audit/edit
    */
    public function edit($id)
    {
        $user = User::find(session('id'));
        if($user->hasPermissionTo('edit.audit')){
            // GETTING LOGDED IN SHIP/SHORE DETAILS
            $ship     = (new GenericController)->getCreatorId();

            // FETCH DROPDOWN
            $dropdown = DB::table('near_miss_dropdown')->get();
            $dropmain = DB::table('near_miss_dropdown_main_type')->get();

            // FETCHING CODE AND REF
            $code     = DB::table('deficiency_codes')->select('id', 'code', 'name')->get();
            $ref      = AuditRef::select('id', 'name')->get();

            // FETCH MASTER TABLE DATA FOR EDIT .....
            $master   = auditmodel::where('id', $id)->first();
            $id       = $master->id;

            $last     = DB::table('inspection_and_audit_master')->where('inspection_and_audit_master.creator_id', $ship->unique_id)
                ->leftJoin('inspection_and_audit_forms', 'inspection_and_audit_forms.inspection_and_audit_form_id', '=', 'inspection_and_audit_master.id')
                ->selectRaw('group_concat(inspection_and_audit_forms.id) as forms,inspection_and_audit_master.id')
                ->groupBy('inspection_and_audit_master.id')
                // ->orderBy('inspection_and_audit_master.created_at', 'desc')
                ->get();

            // for stopping crete new draft modal to apear .....
            session()->put('audit_new_draft_clicked', true);

            return view('inspection_audit.audit_edit', ['code' => $code, 'ref' => $ref, 'id' => $id, 'name' => $ship->name, 'dropdown' => $dropdown, 'dropdownmain' => $dropmain, 'data' => $last]);
        }
        else{
            abort(404);
        }
    }

    /*
        REQUEST TYPE => POST
        DESCRIPTION => CONTROLLER UPDATE DATA INTO DATABASE
        URL =>  /inspection-audit/update
    */
    public function update($id)
    {
        return redirect(route('inspection_audit'))->with('status', 'Data Added !!');
    }

    /*
        REQUEST TYPE => POST
        DESCRIPTION => CONTROLLER UPDATE DATA INTO DATABASE
        URL =>  /inspection-audit/destroy
    */
    public function destroy($id)
    {
        $user = User::find(session('id'));
        if($user->hasPermissionTo('delete.audit')){
            $this->DeleteById($id);
            return redirect(url('/inspection-audit'));
        }
        else{
            abort(404);
        }
    }

    /*
        REQUEST TYPE => GET
        DESCRIPTION => CONTROLLER THAT
        URL =>  /inspection-audit/destroy
    */
    public function NewDraft(Request $r)
    {

        // $is_created = $this->DeleteAndCreateNewDraft();
        $is_created = $this->CreateNewDraft();

        if($is_created){ session()->put('audit_new_draft_clicked', true); }

        return redirect()->back();
    }



    /*
            API FUNCTIONS
            ###############################
    */

    /* 🎈 API FUNCTION => RENDER DATA INTO VIEW PAGE DATA TABLE */
    public function getaudit(Request $req)
    {

        // Query for getting total count
        $IA_data       = DB::table('inspection_and_audit_master')/*->where('status', '!=', 'Draft')*/;

        // render only perticular ship data .....
        if ($req->is_ship) {
            $IA_data = $IA_data->where('creator_id', $req->creator_id);
        }


        // $data = session('email');
        $data = session()->all();




        // Query for all data
        $last          = DB::table('inspection_and_audit_master')
            ->leftJoin('inspection_and_audit_forms', 'inspection_and_audit_forms.inspection_and_audit_form_id', '=', 'inspection_and_audit_master.id')
            ->selectRaw('group_concat(inspection_and_audit_forms.id) as forms, inspection_and_audit_master.id')
            ->groupBy('inspection_and_audit_master.id')
            ->orderBy('inspection_and_audit_master.created_at', 'desc')
            ->get();
        Log::info('Data : '.print_r($last,true));
        $totaldata     = $IA_data->count();
        $limit         = $req->input('length');
        $start         = $req->input('start');
        $totalFiltered = $totaldata;

        // ```````````````````````````` Search start ````````````````````````

        if (empty($req->srch) == 1) {

            if ($req->is_admin) {
                $Inspect_Audit = $IA_data->orderBy('updated_at','DESC')->offset($start)->limit($limit)->get();
            } else {

                $Inspect_Audit = $IA_data->where('creator_email', $req->session_email)->orderBy('updated_at','DESC')->offset($start)->limit($limit)->get();
            }
        } else {
            $search_id     = $this->Seacher($req->srch);

            foreach ($search_id as $ids) {
                $IA_data->orWhere("id", 'LIKE', "%{$ids}%");
            }

            $Inspect_Audit = $IA_data->offset($start)->limit($limit)->get();

            $totalFiltered = $IA_data->count();
        }

        // ```````````````````````````` Search end ````````````````````````
        $data          = array();

        // checkking master inspect audit is empty or not .....
        if (!empty($Inspect_Audit)) {
            // iterate master table data .....
            foreach ($Inspect_Audit as $post) {

                // FETCHING FORM'S .....
                $IA_forms      = DB::table('inspection_and_audit_forms')->where('inspection_and_audit_form_id', $post->id)->get();

                $stat_color    = 'primary';

                // SET BUTTON COLOUR FOR STATUS .....
                if ($post->status == config('constants.status.Not_approved')) {
                    $stat_color    = 'danger';
                }
                if ($post->status == config('constants.status.Submitted')) {
                    $stat_color    = 'success';
                }
                if ($post->status == config('constants.status.Approved')) {
                    $stat_color    = 'warning';
                }
                if ($post->status == config('constants.status.Draft')) {
                    $stat_color    = 'warning';
                }
                if ($post->status == config('constants.status.Correction_required')) {
                    $stat_color    = 'warning';
                }
                if ($post->status == config('constants.status.active')) {
                    $stat_color    = 'warning';
                }
                if ($post->status == config('constants.status.not_active')) {
                    $stat_color    = 'warning';
                }

                // Get Type of Audit form .....
                $type_of_audit = DB::table('inspection_and_audit_master')->where('id', $post->id)->value('type_of_audit');

                $report        = "";
                $action        = null;

                // render if audit type == PSC
                if ($type_of_audit == 'PSC') {
                    // Iterate 'inspection_and_audit_master' left joined data
                    foreach ($last as $d) {
                        // compare 'id' of 'inspection_and_audit_master' with 'inspection_and_audit_forms'
                        if ($post->id == $d->id) {
                            $v             = explode(',', $d->forms);
                            for ($i             = 0; $i < count($v); $i++) {
                                $report .= $this->getPSCFormDiv($v[$i], $post);
                            }
                        }
                    }
                    $action    = $this->getNCObservationFormActionDiv($post, $d);
                } else {
                    foreach ($last as $d) {
                        if ($post->id == $d->id) {
                            $v = explode(',', $d->forms);
                            for ($i = 0; $i < count($v); $i++) {
                                $report    = $this->getNcObservationFormDiv($v[$i], $post);
                            }
                        }
                    }

                    $action    = $this->getNCObservationFormActionDiv($post, $d);
                }

                $nestedData['status']           = "<div class='shadow btn btn-" . $stat_color . "' >" . $post->status . "</div>";
                $nestedData['id']           = $post->id;

                if ($post->report_date == NULL) {
                    $nestedData['report_date']           = config('constants.DATA_NOT_AVAILABLE');
                } else {
                    $nestedData['report_date']           = $post->report_date;
                }

                if ($post->location == NULL) {
                    $nestedData['location']           = config('constants.DATA_NOT_AVAILABLE');
                } else {
                    $nestedData['location']           = $post->location;
                }

                if ($post->type_of_audit == NULL) {
                    $nestedData['type_of_audit']           = config('constants.DATA_NOT_AVAILABLE');
                } else {
                    $nestedData['type_of_audit']           = $post->type_of_audit;
                }
                if ($post->name_of_auditorr == NULL) {
                    $nestedData['name_of_auditor']           = config('constants.DATA_NOT_AVAILABLE');
                } else {
                    $nestedData['name_of_auditor']           = $post->name_of_auditorr;
                }

                $nestedData['report']           = $report;
                $nestedData['action']           = $action;

                $data[]           = $nestedData;
            }
        }

        $json_data = array(
            "draw" => intval($req->input('draw')),
            "recordsTotal" => intval($totaldata),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data
        );

        echo json_encode($json_data);
    }

    /* 🎈 API FUNCTION => ----- */
    public function saveStapOne(Request $req)
    {
        // dd($req->all());
        // AUTO-SAVE DATA(UPDATE-DATA)
        // dd($req['Vessel']);
        $data = $req->step_One_Data;
        // $vvv = $req['Vessel'];
        // $vvv = $req['Vessel;
        if ($data['Step'] == 1) {
        } else {
        }
    }

    /* 🎈 API FUNCTION => ----- */
    public function getNCObservationFormActionDiv($post, $d)
    {
        try {
            $div = "<!-- Report Preview
                            =========================-->
                            <a href='' class='btn btn-warning text-dark numo-btn  mt-3 d-none ' title = 'Preview~' data-toggle='modal' data-target='#prev_$post->id'>
                                <i class='fas fa-print'></i> Preview
                            </a>

                            <div class='modal fade' id='prev_$post->id' tabindex='-1' role='dialog'     aria-labelledby='exampleModalLongTitle' aria-hidden='true'>
                                    <div class='modal-dialog modal-lg' role='document'>
                                        <div class='modal-content'>
                                                <div class='modal-header'>
                                                    <h2 class='modal-title font-weight-bold' id='exampleModalLongTitle'>Preview</h2> <h5>Vessel Id : $post->vessel_id </h5>
                                                </div>
                                            <div class='modal-body text-left'>
                                                <h2 class='text-center my-5 font-weight-bold'> Audit Master </h2>
                                                <div class='row'>
                                                        " . $this->col('3', '12', (isset($post->report_date) ? $post->report_date : 'N/A'), 'report_date') . "
                                                        " . $this->col('3', '12', (isset($post->location) ? $post->location : 'N/A'), 'Location') . "
                                                        " . $this->col('3', '12', (isset($post->type_of_audit) ? $post->type_of_audit : 'N/A'), 'Type of audit') . "

                                                </div>
                                                <hr>
                                                <h2 class='text-center my-5 font-weight-bold'> Corrective action </h2>
                                                <div class='row'>
                                                        " . $this->col('3', '12', (isset($d->description) ? $d->description : 'N/A'), 'Descrition') . "
                                                        " . $this->col('3', '12', (isset($d->c_a_date_completed) ? $d->c_a_date_completed : 'N/A'), 'Date_completed') . "
                                                                                                                                                                </div>
                                                <hr>
                                                <h2 class='text-center my-5 font-weight-bold'> Corrective upload evidence </h2>
                                                <div class='row'>
                                                        " . $this->col('3', '12', 'N/A', 'URL') . "
                                                        " . $this->col('3', '12', 'N/A', 'Name') . "
                                                </div>
                                                <hr>
                                                <h2 class='text-center my-5 font-weight-bold'> Preventive Action </h2>
                                                <div class='row'>
                                                        " . $this->col('3', '12', (isset($d->description) ? $d->description : 'N/A'), 'Description') . "
                                                        " . $this->col('3', '12', (isset($d->p_a_date_completed) ? $d->p_a_date_completed : 'N/A'), 'Date_complete') . "
                                                </div>
                                                <hr>
                                                <h2 class='text-center my-5 font-weight-bold'> Preventive upload evidence </h2>
                                                <div class='row'>
                                                        " . $this->col('3', '12', 'N/A', 'URL') . "
                                                        " . $this->col('3', '12', 'N/A', 'Name') . "
                                                </div>
                                                <hr>

                                                    <div class='modal-footer'>
                                                        <button type='button' class='btn btn-danger text-white  -close' data-dismiss='modal'><i class='far fa-times-circle mr-1'></i>Close</button>
                                                    </div>
                                            </div>
                                        </div>
                                    </div>
                            </div>


                                <!-- Edit Button
                                =========================-->
                                    <a href='/inspection-audit/edit/" . $post->id . "' class='btn edit' title = 'Edit'>
                                        <i class='fas fa-edit'></i>
                                    </a>

                                    <!-- Delete Button
                                =========================-->
                                    <button type='button' class='btn delete' title = 'Delete' data-toggle='modal' data-target='#Delete_Modal_$post->id'>
                                        <i class='fas fa-trash-alt'></i>
                                    </button>
                            </div>
                            <!-- Modal
                                =========================-->
                                <div class='modal fade' id='Delete_Modal_$post->id' tabindex='-1' aria-labelledby='exampleModalLabel' aria-hidden='true'>
                                        <div class='modal-dialog modal-dialog-centered'>
                                            <div class='modal-content'>
                                            <div class='modal-body p-5'>
                                                <h1 class='text-center text-danger '><i class='fas fa-trash-alt'></i></h1>
                                                <h3 class='text-center my-3'> Do you want to delete?</h3>
                                                <button style='border: 1px solid #00000093' type='button' class='btn btn-light shadow mx-3 w-25' data-dismiss='modal'>No</button>
                                                <a style='border: 1px solid #099b6393' href='/inspection-audit/delete/" . $post->id . " ' class='w-25 btn shadow btn-success'>Yes</a>
                                            </div>
                                        </div>
                                </div>

                            ";
            return $div;
        } catch (Exception $e) {
            report($e);
        }
    }

    /* 🎈 API FUNCTION => Return Non-confirmity and observation data table html */
    public function getNcObservationFormDiv($id, $post)
    {
        try {

            $IA_forms = DB::table('inspection_and_audit_forms')->where('inspection_and_audit_form_id', $post->id)->get();
            $div = '';
            foreach ($IA_forms as $IA_form) {
                $id         = $IA_form->id;
                $type       = $IA_form->type_of_report;
                if ($type == config('constants.INSPECTION_AND_AUDIT_FORM_TYPES.NON_CONFIRMITY')) {
                    $div      .= "
                                    <div class='d-flex'>
                                        <div class='containertooltip '>
                                            " . $id . " -->  Non_confirmitry
                                        </div>
                                    </div>";
                } else {
                    $div      .= "
                                    <div class='d-flex'>
                                        <div class='containertooltip '>
                                            " . $id . " -->  Observation
                                        </div>
                                    </div>";
                }
            }



            return $div;
        } catch (Exception $e) {
            report($e);
        }
    }

    /* 🎈 API FUNCTION => PERFORM AUTO SAVE */
    public function AutoSaveAPI(Request $req)
    {
        $response = false;
        if ($req->Step == 1) {
            DB::table('inspection_and_audit_master')
                ->where('id', $req->ID)
                ->update([
                    'report_date' => $req->Date, 
                    'location'    => $req->Location, 
                    'name_of_auditorr'  => $req->Name_of_the_Auditor, 
                    'type_of_audit'    => $req->Type_of_Audit,
                    'creator_email' => $req->email,
                    'updated_at' => now()
            ]);

            $response                                     = '';
        }

        if ($req->Step == 2) {
            Log::info("Enters inside Step 2 ..... ||Line:536");

            if ($req->Type == config('constants.INSPECTION_AND_AUDIT_FORM_TYPES.NON_CONFIRMITY')) {
                Log::info("Enters inside Non-Confermity ..... ||Line:539");
                if ($req->edit == 'null' || $req->edit == null) {
                    Log::info("Enters inside Non-Confermity Create ..... ||Line:540");
                    // Saving in the 'inspection_and_audit_forms' table
                    $master                                       = inspection_and_audit_forms::orderBy('auto_inc', 'desc')->first();

                    // id incrementer .....
                    if ($master == null) {
                        $form_id_count                                = 1;
                    } else {
                        $form_id_count                                = explode("_", $master->id)[3] + 1;
                    }

                    if ($req->major_nc == 'true' || $req->nc == 'true') {
                        if ($req->major_nc == 'true') {
                            $type_of_nc                                   = 'Major N/C';
                        } else {
                            $type_of_nc                                   = 'N/C';
                        }
                    } else {
                        $type_of_nc                                   = 'N/A';
                    }

                    // custom ID .....
                    $master_primary_key = $req->master_id . '__IAAF_' . $form_id_count;

                    $New_Audit_Form                               = new inspection_and_audit_forms;
                    $New_Audit_Form->id                           = $master_primary_key;
                    $New_Audit_Form->inspection_and_audit_form_id = $req->master_id;
                    $New_Audit_Form->description                  = $req->description;
                    $New_Audit_Form->type_of_report               = $req->Type;
                    $New_Audit_Form->ism_clause                   = $req->ism;
                    $New_Audit_Form->type_of_nc                   = $type_of_nc;
                    $New_Audit_Form->due_date                     = $req->due_date;

                    $New_Audit_Form->signed_by_auditee_name       = $req->sign_master_text;
                    // SAVING NON-CONFIRMITY SIGNED_BY_MASTER/Auditee FILE
                    if ($req->sign_master != 'undefined') {
                        $sign_by_master_FILE_DB_PATH = (new FileSaver)->saveFile(
                            $req->master_id . DIRECTORY_SEPARATOR .
                                config('constants.INSPECTION_AUDIT_MODULE_SUB_FORMS.NON_CONFIRMITY') . DIRECTORY_SEPARATOR .
                                $master_primary_key . DIRECTORY_SEPARATOR .
                                config('constants.INSPECTION_AUDIT_IMAGE_FOLDERS.SIGNED_BY_MASTER'),
                            config('constants.MODULES.INSPECTION_AND_AUDIT'),
                            $req->file('sign_master')
                        );
                        $New_Audit_Form->signed_by_auditee_url_name = $sign_by_master_FILE_DB_PATH;
                    } else {
                        $New_Audit_Form->signed_by_auditee_url_name = null;
                    }

                    $New_Audit_Form->signed_by_auditor_name     = $req->sign_auditor_text;
                    // SAVING NON-CONFIRMITY SIGNED_BY_AUDITOR FILE
                    if ($req->sign_auditor != 'undefined') {

                        $sign_by_auditor_FILE_DB_PATH = (new FileSaver)->saveFile(
                            $req->master_id . DIRECTORY_SEPARATOR .
                                config('constants.INSPECTION_AUDIT_MODULE_SUB_FORMS.NON_CONFIRMITY') . DIRECTORY_SEPARATOR .
                                $master_primary_key . DIRECTORY_SEPARATOR  .
                                config('constants.INSPECTION_AUDIT_IMAGE_FOLDERS.SIGNED_BY_AUDITOR'),
                            config('constants.MODULES.INSPECTION_AND_AUDIT'),
                            $req->file('sign_auditor')
                        );
                        $New_Audit_Form->signed_by_auditor_url = $sign_by_auditor_FILE_DB_PATH;
                    } else {
                        $New_Audit_Form->signed_by_auditor_url = null;
                    }

                    $New_Audit_Form->accepted_by_name      = $req->accepted;
                    // SAVING NON-CONFIRMITY ACCEPTED_UPLOAD FILE
                    if ($req->upload_accepted != 'undefined') {

                        $accepted_upload_FILE_DB_PATH = (new FileSaver)->saveFile(
                            $req->master_id . DIRECTORY_SEPARATOR .
                                config('constants.INSPECTION_AUDIT_MODULE_SUB_FORMS.NON_CONFIRMITY') . DIRECTORY_SEPARATOR .
                                $master_primary_key . DIRECTORY_SEPARATOR .
                                config('constants.INSPECTION_AUDIT_IMAGE_FOLDERS.ACCEPTED'),
                            config('constants.MODULES.INSPECTION_AND_AUDIT'),
                            $req->file('upload_accepted')
                        );
                        $New_Audit_Form->accepted_by_url       = $accepted_upload_FILE_DB_PATH;
                    } else {
                        $New_Audit_Form->accepted_by_url       = null;
                    }

                    $New_Audit_Form->signed_by_master_name = $req->signed;
                    // SAVING NON-CONFIRMITY SIGN_UPLOAD FILE
                    if ($req->upload_accepted != 'undefined') {

                        $signed_upload_FILE_DB_PATH = (new FileSaver)->saveFile(
                            $req->master_id . DIRECTORY_SEPARATOR .
                                config('constants.INSPECTION_AUDIT_MODULE_SUB_FORMS.NON_CONFIRMITY') . DIRECTORY_SEPARATOR .
                                $master_primary_key . DIRECTORY_SEPARATOR .
                                config('constants.INSPECTION_AUDIT_IMAGE_FOLDERS.SIGNED'),
                            config('constants.MODULES.INSPECTION_AND_AUDIT'),
                            $req->file('upload_sign')
                        );

                        $New_Audit_Form->signed_by_master_url     = $signed_upload_FILE_DB_PATH;
                    } else {
                        $New_Audit_Form->signed_by_master_url     = null;
                    }


                    $New_Audit_Form->follow_up_comments       = $req->comments;
                    $New_Audit_Form->is_confirmed_by_dpa      = $req->comfirm_by_dpa;
                    $New_Audit_Form->form_date                = $req->date;
                    $New_Audit_Form->is_verification_required = $req->verification_required;
                    $New_Audit_Form->psc_ref                  = $req->psc_upload;
                    $New_Audit_Form->psc_code                 = $req->ref;
                    $New_Audit_Form->save();

                    // Saving in the 'inspection_and_audit_form_upload_evidence' table with the unique id of 'inspection_and_audit_forms'
                    if (isset($req->upload_document)) {
                        for ($i = 0; $i < count($req->upload_document); $i++) {
                            if ($req->upload_document[$i] != 'undefined') {

                                $UPLOAD_EVIDENCE_FILE_DB_PATH = (new FileSaver)->saveFile(
                                    $req->master_id . DIRECTORY_SEPARATOR .
                                        config('constants.INSPECTION_AUDIT_MODULE_SUB_FORMS.NON_CONFIRMITY') . DIRECTORY_SEPARATOR .
                                        $master_primary_key . DIRECTORY_SEPARATOR .
                                        config('constants.INSPECTION_AUDIT_IMAGE_FOLDERS.UPLOAD_EVIDENCE'),
                                    config('constants.MODULES.INSPECTION_AND_AUDIT'),
                                    $req->file('upload_document')[$i]
                                );

                                $sign_by_master_FILE_NAME    = $req->file('upload_document')[$i]->getClientOriginalName();

                                $cue                                        = inspection_and_audit_form_upload_evidence::orderBy('auto_inc', 'DESC')->first();
                                if ($cue == null) {
                                    $form_id_count                              = 1;
                                } else {
                                    $form_id_count                              = explode("_", $cue->id)[3] + 1;
                                }
                                $CUE                                        = new inspection_and_audit_form_upload_evidence;
                                $CUE->id                                    = $req->master_id . '__IAACA_' . $form_id_count;
                                $CUE->inspection_and_audit_form_id          = $New_Audit_Form->id;
                                $CUE->incidentAudit_master_id               = $req->master_id;
                                $CUE->url                                   = $UPLOAD_EVIDENCE_FILE_DB_PATH;
                                $CUE->name                                  = $sign_by_master_FILE_NAME;
                                $CUE->save();
                            } else {
                                $New_Audit_Form->signed_by_auditee_url_name = null;
                                $cue                                        = inspection_and_audit_form_upload_evidence::orderBy('auto_inc', 'DESC')->first();
                                if ($cue == null) {
                                    $form_id_count                              = 1;
                                } else {
                                    $form_id_count                              = explode("_", $cue->id)[3] + 1;
                                }
                                $CUE                                        = new inspection_and_audit_form_upload_evidence;
                                $CUE->id                                    = $req->master_id . '__IAACA_' . $form_id_count;
                                $CUE->inspection_and_audit_form_id          = $New_Audit_Form->id;
                                $CUE->incidentAudit_master_id               = $req->master_id;
                                $CUE->url                                   = null;
                                $CUE->name                                  = null;
                                $CUE->save();
                            }
                        }
                    }

                    // Saving in the 'inspection_and_audit_root_causes' table with the unique id of 'inspection_and_audit_forms'
                    $NMC                              = new NearMissAccidentReporting;
                    $root_causes                      = explode("|", $req->root_cause);
                    if ($root_causes[0] !== '') {
                        $root_causes_first                = explode(",", $root_causes[0]);
                        Log::debug($root_causes_first);

                        foreach ($root_causes_first as $root_id) {
                            $rc                               = inspection_and_audit_root_causes::orderBy('auto_inc', 'DESC')->first();
                            if ($rc == null) {
                                $form_id_count                    = 1;
                            } else {
                                $form_id_count                    = explode("_", $rc->id)[3] + 1;
                            }
                            $RC                               = new inspection_and_audit_root_causes;
                            $RC->id                           = $req->master_id . '__IAACA_' . $form_id_count;
                            $RC->inspection_and_audit_form_id = $New_Audit_Form->id;
                            $RC->incidentAudit_master_id      = $req->master_id;
                            $RC->description                  = $NMC->getmain($root_id);
                            $RC->refrence_id                  = $root_id;
                            $RC->save();
                        }
                    }

                    // Saving in the 'inspection_and_audit_root_causes_sub' table with the unique id of 'inspection_and_audit_forms'
                    $NMC                              = new NearMissAccidentReporting;
                    $root_causes                      = explode("|", $req->root_cause);
                    if ($root_causes[1] !== '') {
                        $root_causes_second               = explode(",", $root_causes[1]);

                        foreach ($root_causes_second as $root_id) {
                            $rc                               = inspection_and_audit_root_causes_sub::orderBy('auto_inc', 'DESC')->first();
                            if ($rc == null) {
                                $form_id_count                    = 1;
                            } else {
                                $form_id_count                    = explode("_", $rc->id)[3] + 1;
                            }
                            $RC                               = new inspection_and_audit_root_causes_sub;
                            $RC->id                           = $req->master_id . '__IAACA_' . $form_id_count;
                            $RC->inspection_and_audit_form_id = $New_Audit_Form->id;
                            $RC->incidentAudit_master_id      = $req->master_id;
                            $RC->description                  = $NMC->getsub($root_id);
                            $RC->refrence_id                  = $root_id;
                            $RC->save();
                        }
                    }

                    // Saving in the 'inspection_and_audit_root_causes_ter' table with the unique id of 'inspection_and_audit_forms'
                    $NMC                              = new NearMissAccidentReporting;
                    $root_causes                      = explode("|", $req->root_cause);
                    if ($root_causes[2] !== '') {
                        $root_causes_second               = explode(",", $root_causes[2]);

                        foreach ($root_causes_second as $root_id) {
                            $rc                               = inspection_and_audit_root_causes_ter::orderBy('auto_inc', 'DESC')->first();
                            if ($rc == null) {
                                $form_id_count                    = 1;
                            } else {
                                $form_id_count                    = explode("_", $rc->id)[3] + 1;
                            }
                            $RC                               = new inspection_and_audit_root_causes_ter;
                            $RC->id                           = $req->master_id . '__IAACA_' . $form_id_count;
                            $RC->inspection_and_audit_form_id = $New_Audit_Form->id;
                            $RC->incidentAudit_master_id      = $req->master_id;
                            $RC->description                  = $NMC->getter($root_id);
                            $RC->refrence_id                  = $root_id;
                            $RC->save();
                        }
                    }

                    // Saving in the 'inspection_and_audit_preventive_actions' table with the unique id of 'inspection_and_audit_forms'
                    $NMC                              = new NearMissAccidentReporting;
                    $preventive_aactions              = explode("|", $req->preventive_action);
                    if ($preventive_aactions[0] !== '') {
                        $preventive_aactions_first        = explode(",", $preventive_aactions[0]);

                        foreach ($preventive_aactions_first as $preven_id) {
                            $pa                               = inspection_and_audit_preventive_actions::orderBy('auto_inc', 'DESC')->first();
                            if ($pa == null) {
                                $form_id_count                    = 1;
                            } else {
                                $form_id_count                    = explode("_", $pa->id)[3] + 1;
                            }
                            $PA                               = new inspection_and_audit_preventive_actions;
                            $PA->id                           = $req->master_id . '__IAACA_' . $form_id_count;
                            $PA->inspection_and_audit_form_id = $New_Audit_Form->id;
                            $PA->incidentAudit_master_id      = $req->master_id;
                            $PA->description                  = $NMC->getmain($preven_id);
                            $PA->refrence_id                  = $preven_id;
                            $PA->date_completed               = $req->p_complete_date;
                            $PA->save();
                        }
                    }

                    // Saving in the 'inspection_and_audit_preventive_actions_sub' table with the unique id of 'inspection_and_audit_forms'
                    $NMC                              = new NearMissAccidentReporting;
                    $preventive_aactions              = explode("|", $req->preventive_action);
                    if ($preventive_aactions[0] !== '') {
                        $preventive_aactions_second       = explode(",", $preventive_aactions[0]);

                        foreach ($preventive_aactions_second as $preven_id) {
                            $pa                               = inspection_and_audit_preventive_actions_sub::orderBy('auto_inc', 'DESC')->first();
                            if ($pa == null) {
                                $form_id_count                    = 1;
                            } else {
                                $form_id_count                    = explode("_", $pa->id)[3] + 1;
                            }
                            $PA                               = new inspection_and_audit_preventive_actions_sub;
                            $PA->id                           = $req->master_id . '__IAACA_' . $form_id_count;
                            $PA->inspection_and_audit_form_id = $New_Audit_Form->id;
                            $PA->incidentAudit_master_id      = $req->master_id;
                            $PA->description                  = $NMC->getsub($preven_id);
                            $PA->refrence_id                  = $preven_id;
                            $PA->date_completed               = $req->p_complete_date;
                            $PA->save();
                        }
                    }

                    // Saving in the 'inspection_and_audit_preventive_upload_evidence' table with the unique id of 'inspection_and_audit_preventive_actions'
                    if (isset($req->p_upload_evidence)) {
                        for ($i = 0; $i < count($req->p_upload_evidence); $i++) {
                            if ($req->p_upload_evidence[$i] != 'undefined') {

                                $preventive_upload_evidence_FILE_DB_PATH = (new FileSaver)->saveFile(
                                    $req->master_id . DIRECTORY_SEPARATOR .
                                        config('constants.INSPECTION_AUDIT_MODULE_SUB_FORMS.NON_CONFIRMITY') . DIRECTORY_SEPARATOR .
                                        $master_primary_key . DIRECTORY_SEPARATOR .
                                        config('constants.INSPECTION_AUDIT_IMAGE_FOLDERS.PREVENTIVE_ACTIONS_UPLOAD_EVIDENCE'),
                                    config('constants.MODULES.INSPECTION_AND_AUDIT'),
                                    $req->file('p_upload_evidence')[$i]
                                );

                                $preventive_upload_evidence_FILE_NAME    = $req->file('p_upload_evidence')[$i]->getClientOriginalName();

                                $New_Audit_Form->signed_by_auditee_url_name = null;
                                $cue                                        = inspection_and_audit_preventive_upload_evidence::orderBy('auto_inc', 'DESC')->first();
                                if ($cue == null) {
                                    $form_id_count                              = 1;
                                } else {
                                    $form_id_count                              = explode("_", $cue->id)[3] + 1;
                                }
                                $CUE                                        = new inspection_and_audit_preventive_upload_evidence;
                                $CUE->id                                    = $req->master_id . '__IAACA_' . $form_id_count;
                                $CUE->inspection_and_audit_form_id          = $New_Audit_Form->id;
                                $CUE->incidentAudit_master_id               = $req->master_id;
                                $CUE->url                                   = $preventive_upload_evidence_FILE_DB_PATH;
                                $CUE->name                                  = $preventive_upload_evidence_FILE_NAME;
                                $CUE->save();
                            } else {
                                $New_Audit_Form->signed_by_auditee_url_name = null;
                                $cue                                        = inspection_and_audit_preventive_upload_evidence::orderBy('auto_inc', 'DESC')->first();
                                if ($cue == null) {
                                    $form_id_count                              = 1;
                                } else {
                                    $form_id_count                              = explode("_", $cue->id)[3] + 1;
                                }
                                $CUE                                        = new inspection_and_audit_preventive_upload_evidence;
                                $CUE->id                                    = $req->master_id . '__IAACA_' . $form_id_count;
                                $CUE->inspection_and_audit_form_id          = $New_Audit_Form->id;
                                $CUE->incidentAudit_master_id               = $req->master_id;
                                $CUE->url                                   = null;
                                $CUE->name                                  = null;
                                $CUE->save();
                            }
                        }
                    }

                    // Saving in the 'inspection_and_audit_corrective_actions' table with the unique id of 'inspection_and_audit_forms'
                    for ($i = 0; $i < count(json_decode($req->corrective_action, true)); $i++) {
                        $inspection_and_audit_corrective_actions = json_decode($req->corrective_action, true);
                        $ca                                      = inspection_and_audit_corrective_actions::orderBy('auto_inc', 'DESC')->first();
                        if ($ca == null) {
                            $form_id_count                           = 1;
                        } else {
                            $form_id_count                           = explode("_", $ca->id)[3] + 1;
                        }
                        if ($inspection_and_audit_corrective_actions[$i] != '') {
                            $CA                                      = new inspection_and_audit_corrective_actions;
                            $CA->id                                  = $req->master_id . '__IAACA_' . $form_id_count;
                            $CA->inspection_and_audit_form_id        = $New_Audit_Form->id;
                            $CA->incidentAudit_master_id             = $req->master_id;
                            $CA->description                         = $inspection_and_audit_corrective_actions[$i];
                            $CA->date_completed                      = $req->c_complete_date;
                            $CA->save();
                        }
                    }

                    // Saving in the 'inspection_and_audit_corrective_upload_evidence' table with the unique id of 'inspection_and_audit_corrective_actions'
                    if (isset($req->c_upload_evidence)) {
                        for ($i = 0; $i < count($req->c_upload_evidence); $i++) {
                            if ($req->c_upload_evidence[$i] != 'undefined') {

                                $sign_by_master_FILE_DB_PATH = (new FileSaver)->saveFile(
                                    $req->master_id . DIRECTORY_SEPARATOR .
                                        config('constants.INSPECTION_AUDIT_MODULE_SUB_FORMS.NON_CONFIRMITY') . DIRECTORY_SEPARATOR .
                                        $master_primary_key . DIRECTORY_SEPARATOR .
                                        config('constants.INSPECTION_AUDIT_IMAGE_FOLDERS.CORRCTIVE_ACTIONS_UPLOAD_EVIDENCE'),
                                    config('constants.MODULES.INSPECTION_AND_AUDIT'),
                                    $req->file('c_upload_evidence')[$i]
                                );



                                $sign_by_master_FILE_NAME    = $req->file('c_upload_evidence')[$i]->getClientOriginalName();

                                $New_Audit_Form->signed_by_auditee_url_name = null;
                                $cue                                        = inspection_and_audit_corrective_upload_evidence::orderBy('auto_inc', 'DESC')->first();
                                if ($cue == null) {
                                    $form_id_count                              = 1;
                                } else {
                                    $form_id_count                              = explode("_", $cue->id)[3] + 1;
                                }
                                $CUE                                        = new inspection_and_audit_corrective_upload_evidence;
                                $CUE->id                                    = $req->master_id . '__IAACA_' . $form_id_count;
                                $CUE->inspection_and_audit_form_id          = $New_Audit_Form->id;
                                $CUE->incidentAudit_master_id               = $req->master_id;
                                $CUE->url                                   = $sign_by_master_FILE_DB_PATH;
                                $CUE->name                                  = $sign_by_master_FILE_NAME;
                                $CUE->save();
                            } else {
                                $New_Audit_Form->signed_by_auditee_url_name = null;
                                $cue                                        = inspection_and_audit_corrective_upload_evidence::orderBy('auto_inc', 'DESC')->first();
                                if ($cue == null) {
                                    $form_id_count                              = 1;
                                } else {
                                    $form_id_count                              = explode("_", $cue->id)[3] + 1;
                                }
                                $CUE                                        = new inspection_and_audit_corrective_upload_evidence;
                                $CUE->id                                    = $req->master_id . '__IAACA_' . $form_id_count;
                                $CUE->inspection_and_audit_form_id          = $New_Audit_Form->id;
                                $CUE->incidentAudit_master_id               = $req->master_id;
                                $CUE->url                                   = null;
                                $CUE->name                                  = null;
                                $CUE->save();
                            }
                        }
                    }

                    $corrective_data                              = inspection_and_audit_corrective_actions::where('inspection_and_audit_form_id', $New_Audit_Form->id)
                        ->get();
                    $corrective_evidence_data                     = inspection_and_audit_corrective_upload_evidence::where('inspection_and_audit_form_id', $New_Audit_Form->id)
                        ->get();
                    $response                                     = [$New_Audit_Form, $corrective_data, $corrective_evidence_data];
                } else {
                    Log::info("Enters inside Non-Confermity Edit ..... ||Line:904");
                    if ($req->major_nc == 'true' || $req->nc == 'true') {
                        if ($req->major_nc == 'true') {
                            $type_of_nc                                   = 'Major N/C';
                        } else {
                            $type_of_nc                                   = 'N/C';
                        }
                    } else {
                        $type_of_nc                                   = 'N/A';
                    }
                    $old_audit_form                               = inspection_and_audit_forms::find($req->edit);
                    $old_audit_form->inspection_and_audit_form_id = $req->master_id;

                    $old_audit_form->description                  = $req->description;
                    $old_audit_form->type_of_report               = $req->Type;
                    $old_audit_form->ism_clause                   = $req->ism;
                    $old_audit_form->type_of_nc                   = $type_of_nc;
                    $old_audit_form->due_date                     = $req->due_date;

                    $old_audit_form->signed_by_auditee_name       = $req->sign_master_text;
                    // SAVING NON-CONFIRMITY SIGNED_BY_MASTER/Auditee FILE
                    if ($req->sign_master != 'undefined') {
                        $sign_by_master_FILE_DB_PATH = (new FileSaver)->saveFile(
                            $req->master_id . DIRECTORY_SEPARATOR .
                                config('constants.INSPECTION_AUDIT_MODULE_SUB_FORMS.NON_CONFIRMITY') . DIRECTORY_SEPARATOR .
                                $old_audit_form->id . DIRECTORY_SEPARATOR .
                                config('constants.INSPECTION_AUDIT_IMAGE_FOLDERS.SIGNED_BY_MASTER'),
                            config('constants.MODULES.INSPECTION_AND_AUDIT'),
                            $req->file('sign_master')
                        );

                        $old_audit_form->signed_by_auditee_url_name = $sign_by_master_FILE_DB_PATH;
                    }

                    $old_audit_form->signed_by_auditor_name     = $req->sign_auditor_text;
                    // SAVING NON-CONFIRMITY SIGNED_BY_AUDITOR FILE
                    if ($req->sign_auditor != 'undefined') {

                        $sign_by_auditor_FILE_DB_PATH = (new FileSaver)->saveFile(
                            $req->master_id . DIRECTORY_SEPARATOR .
                                config('constants.INSPECTION_AUDIT_MODULE_SUB_FORMS.NON_CONFIRMITY') . DIRECTORY_SEPARATOR .
                                $old_audit_form->id . DIRECTORY_SEPARATOR .
                                config('constants.INSPECTION_AUDIT_IMAGE_FOLDERS.SIGNED_BY_AUDITOR'),
                            config('constants.MODULES.INSPECTION_AND_AUDIT'),
                            $req->file('sign_auditor')
                        );

                        $old_audit_form->signed_by_auditor_url = $sign_by_auditor_FILE_DB_PATH;
                    }

                    $old_audit_form->accepted_by_name      = $req->accepted;
                    // SAVING NON-CONFIRMITY ACCEPTED_UPLOAD FILE
                    if ($req->upload_accepted != 'undefined') {

                        $accepted_upload_FILE_DB_PATH = (new FileSaver)->saveFile(
                            $req->master_id . DIRECTORY_SEPARATOR .
                                config('constants.INSPECTION_AUDIT_MODULE_SUB_FORMS.NON_CONFIRMITY') . DIRECTORY_SEPARATOR .
                                $old_audit_form->id . DIRECTORY_SEPARATOR .
                                config('constants.INSPECTION_AUDIT_IMAGE_FOLDERS.ACCEPTED'),
                            config('constants.MODULES.INSPECTION_AND_AUDIT'),
                            $req->file('upload_accepted')
                        );

                        $old_audit_form->accepted_by_url       = $accepted_upload_FILE_DB_PATH;
                    }
                    $old_audit_form->signed_by_master_name = $req->signed;
                    // SAVING NON-CONFIRMITY SIGN_UPLOAD FILE
                    if ($req->upload_accepted != 'undefined') {

                        $signed_upload_FILE_DB_PATH = (new FileSaver)->saveFile(
                            $req->master_id . DIRECTORY_SEPARATOR .
                                config('constants.INSPECTION_AUDIT_MODULE_SUB_FORMS.NON_CONFIRMITY') . DIRECTORY_SEPARATOR .
                                $old_audit_form->id . DIRECTORY_SEPARATOR .
                                config('constants.INSPECTION_AUDIT_IMAGE_FOLDERS.SIGNED'),
                            config('constants.MODULES.INSPECTION_AND_AUDIT'),
                            $req->file('upload_sign')
                        );

                        $old_audit_form->signed_by_master_url     = $signed_upload_FILE_DB_PATH;
                    }

                    $old_audit_form->follow_up_comments       = $req->comments;
                    $old_audit_form->is_confirmed_by_dpa      = $req->comfirm_by_dpa;
                    $old_audit_form->form_date                = $req->date;
                    $old_audit_form->is_verification_required = $req->verification_required;
                    $old_audit_form->psc_ref                  = $req->psc_upload;
                    $old_audit_form->psc_code                 = $req->ref;
                    $old_audit_form->save();

                    // Saving in the 'inspection_and_audit_form_upload_evidence' table with the unique id of 'inspection_and_audit_forms'
                    if (isset($req->upload_document)) {
                        $yo = inspection_and_audit_form_upload_evidence::where('inspection_and_audit_form_id', $req->edit)
                            ->delete();

                        for ($i  = 0; $i < count($req->upload_document); $i++) {
                            if ($req->upload_document[$i] != 'undefined') {

                                $UPLOAD_EVIDENCE_FILE_DB_PATH  = (new FileSaver)->saveFile(
                                    $req->master_id . DIRECTORY_SEPARATOR .
                                        config('constants.INSPECTION_AUDIT_MODULE_SUB_FORMS.NON_CONFIRMITY') . DIRECTORY_SEPARATOR .
                                        $old_audit_form->id . DIRECTORY_SEPARATOR .
                                        config('constants.INSPECTION_AUDIT_IMAGE_FOLDERS.UPLOAD_EVIDENCE'),
                                    config('constants.MODULES.INSPECTION_AND_AUDIT'),
                                    $req->file('upload_document')[$i]
                                );


                                $sign_by_master_FILE_NAME    =  $req->file('upload_document')[$i]->getClientOriginalName();

                                $cue                                        = inspection_and_audit_form_upload_evidence::orderBy('auto_inc', 'DESC')->first();
                                if ($cue == null) {
                                    $form_id_count                              = 1;
                                } else {
                                    $form_id_count                              = explode("_", $cue->id)[3] + 1;
                                }
                                $CUE                                        = new inspection_and_audit_form_upload_evidence;
                                $CUE->id                                    = $req->master_id . '__IAACA_' . $form_id_count;
                                $CUE->inspection_and_audit_form_id          = $old_audit_form->id;
                                $CUE->incidentAudit_master_id               = $req->master_id;
                                $CUE->url                                   = $UPLOAD_EVIDENCE_FILE_DB_PATH;
                                $CUE->name                                  = $sign_by_master_FILE_NAME;
                                $CUE->save();
                            } else {
                                $old_audit_form->signed_by_auditee_url_name = null;
                                $cue                                        = inspection_and_audit_form_upload_evidence::orderBy('auto_inc', 'DESC')->first();
                                if ($cue == null) {
                                    $form_id_count                              = 1;
                                } else {
                                    $form_id_count                              = explode("_", $cue->id)[3] + 1;
                                }
                                $CUE                                        = new inspection_and_audit_form_upload_evidence;
                                $CUE->id                                    = $req->master_id . '__IAACA_' . $form_id_count;
                                $CUE->inspection_and_audit_form_id          = $old_audit_form->id;
                                $CUE->incidentAudit_master_id               = $req->master_id;
                                $CUE->url                                   = null;
                                $CUE->name                                  = null;
                                $CUE->save();
                            }
                        }
                    }

                    // Saving in the 'inspection_and_audit_root_causes' table with the unique id of 'inspection_and_audit_forms'
                    $NMC                              = new NearMissAccidentReporting;
                    $root_causes                      = explode("|", $req->root_cause);
                    if ($root_causes[0] !== '') {
                        $root_causes_first                = explode(",", $root_causes[0]);
                        $del                              = inspection_and_audit_root_causes::where('inspection_and_audit_form_id', $req->edit)
                            ->delete();
                        foreach ($root_causes_first as $root_id) {
                            $rc                               = inspection_and_audit_root_causes::orderBy('auto_inc', 'DESC')->first();
                            if ($rc == null) {
                                $form_id_count                    = 1;
                            } else {
                                $form_id_count                    = explode("_", $rc->id)[3] + 1;
                            }
                            $RC                               = new inspection_and_audit_root_causes;
                            $RC->id                           = $req->master_id . '__IAACA_' . $form_id_count;
                            $RC->inspection_and_audit_form_id = $old_audit_form->id;
                            $RC->incidentAudit_master_id      = $req->master_id;
                            $RC->description                  = $NMC->getmain($root_id);
                            $RC->refrence_id                  = $root_id;
                            $RC->save();
                        }
                    }

                    // Saving in the 'inspection_and_audit_root_causes_sub' table with the unique id of 'inspection_and_audit_forms'
                    $NMC                              = new NearMissAccidentReporting;
                    $root_causes                      = explode("|", $req->root_cause);
                    if ($root_causes[1] !== '') {

                        $root_causes_second               = explode(",", $root_causes[1]);
                        $del                              = inspection_and_audit_root_causes_sub::where('inspection_and_audit_form_id', $req->edit)
                            ->delete();
                        foreach ($root_causes_second as $root_id) {
                            $rc                               = inspection_and_audit_root_causes_sub::orderBy('auto_inc', 'DESC')->first();
                            if ($rc == null) {
                                $form_id_count                    = 1;
                            } else {
                                $form_id_count                    = explode("_", $rc->id)[3] + 1;
                            }
                            $RC                               = new inspection_and_audit_root_causes_sub;
                            $RC->id                           = $req->master_id . '__IAACA_' . $form_id_count;
                            $RC->inspection_and_audit_form_id = $old_audit_form->id;
                            $RC->incidentAudit_master_id      = $req->master_id;
                            $RC->description                  = $NMC->getsub($root_id);
                            $RC->refrence_id                  = $root_id;
                            $RC->save();
                        }
                    }

                    // Saving in the 'inspection_and_audit_root_causes_ter' table with the unique id of 'inspection_and_audit_forms'
                    $NMC                              = new NearMissAccidentReporting;
                    $root_causes                      = explode("|", $req->root_cause);
                    if ($root_causes[2] !== '') {
                        $root_causes_second               = explode(",", $root_causes[2]);
                        $del                              = inspection_and_audit_root_causes_ter::where('inspection_and_audit_form_id', $req->edit)
                            ->delete();
                        foreach ($root_causes_second as $root_id) {
                            $rc                               = inspection_and_audit_root_causes_ter::orderBy('auto_inc', 'DESC')->first();
                            if ($rc == null) {
                                $form_id_count                    = 1;
                            } else {
                                $form_id_count                    = explode("_", $rc->id)[3] + 1;
                            }
                            $RC                               = new inspection_and_audit_root_causes_ter;
                            $RC->id                           = $req->master_id . '__IAACA_' . $form_id_count;
                            $RC->inspection_and_audit_form_id = $old_audit_form->id;
                            $RC->incidentAudit_master_id      = $req->master_id;
                            $RC->description                  = $NMC->getter($root_id);
                            $RC->refrence_id                  = $root_id;
                            $RC->save();
                        }
                    }

                    // Saving in the 'inspection_and_audit_preventive_actions' table with the unique id of 'inspection_and_audit_forms'
                    $NMC                              = new NearMissAccidentReporting;
                    $preventive_aactions              = explode("|", $req->preventive_action);
                    if ($preventive_aactions[0] !== '') {
                        $preventive_aactions_first        = explode(",", $preventive_aactions[0]);
                        $del                              = inspection_and_audit_preventive_actions::where('inspection_and_audit_form_id', $req->edit)
                            ->delete();
                        foreach ($preventive_aactions_first as $preven_id) {
                            $pa                               = inspection_and_audit_preventive_actions::orderBy('auto_inc', 'DESC')->first();
                            if ($pa == null) {
                                $form_id_count                    = 1;
                            } else {
                                $form_id_count                    = explode("_", $pa->id)[3] + 1;
                            }
                            $PA                               = new inspection_and_audit_preventive_actions;
                            $PA->id                           = $req->master_id . '__IAACA_' . $form_id_count;
                            $PA->inspection_and_audit_form_id = $old_audit_form->id;
                            $PA->incidentAudit_master_id      = $req->master_id;
                            $PA->description                  = $NMC->getmain($preven_id);
                            $PA->refrence_id                  = $preven_id;
                            $PA->date_completed               = $req->p_complete_date;
                            $PA->save();
                        }
                    }

                    // Saving in the 'inspection_and_audit_preventive_actions_sub' table with the unique id of 'inspection_and_audit_forms'
                    $NMC                              = new NearMissAccidentReporting;
                    $preventive_aactions              = explode("|", $req->preventive_action);
                    if ($preventive_aactions[0] !== '') {
                        $preventive_aactions_second       = explode(",", $preventive_aactions[0]);
                        $del                              = inspection_and_audit_preventive_actions_sub::where('inspection_and_audit_form_id', $req->edit)
                            ->delete();
                        foreach ($preventive_aactions_second as $preven_id) {
                            $pa                               = inspection_and_audit_preventive_actions_sub::orderBy('auto_inc', 'DESC')->first();
                            if ($pa == null) {
                                $form_id_count                    = 1;
                            } else {
                                $form_id_count                    = explode("_", $pa->id)[3] + 1;
                            }
                            $PA                               = new inspection_and_audit_preventive_actions_sub;
                            $PA->id                           = $req->master_id . '__IAACA_' . $form_id_count;
                            $PA->inspection_and_audit_form_id = $old_audit_form->id;
                            $PA->incidentAudit_master_id      = $req->master_id;
                            $PA->description                  = $NMC->getsub($preven_id);
                            $PA->refrence_id                  = $preven_id;
                            $PA->date_completed               = $req->p_complete_date;
                            $PA->save();
                        }
                    }

                    // Saving in the 'inspection_and_audit_preventive_upload_evidence' table with the unique id of 'inspection_and_audit_preventive_actions'
                    if (isset($req->p_upload_evidence)) {
                        $del = inspection_and_audit_preventive_upload_evidence::where('inspection_and_audit_form_id', $req->edit)
                            ->delete();

                        for ($i   = 0; $i < count($req->p_upload_evidence); $i++) {
                            if ($req->p_upload_evidence[$i] != 'undefined') {

                                $PREVENTIVE_ACTION_UPLOAD_EVIDENCE_FILE_DB_PATH = (new FileSaver)->saveFile(
                                    $req->master_id . DIRECTORY_SEPARATOR .
                                        config('constants.INSPECTION_AUDIT_MODULE_SUB_FORMS.NON_CONFIRMITY') . DIRECTORY_SEPARATOR .
                                        $old_audit_form->id . DIRECTORY_SEPARATOR .
                                        config('constants.INSPECTION_AUDIT_IMAGE_FOLDERS.PREVENTIVE_ACTIONS_UPLOAD_EVIDENCE'),
                                    config('constants.MODULES.INSPECTION_AND_AUDIT'),
                                    $req->file('p_upload_evidence')[$i]
                                );

                                $sign_by_master_FILE_NAME    = $req->p_upload_evidence[$i]->getClientOriginalName();

                                $cue                                        = inspection_and_audit_preventive_upload_evidence::orderBy('auto_inc', 'DESC')->first();
                                if ($cue == null) {
                                    $form_id_count                              = 1;
                                } else {
                                    $form_id_count                              = explode("_", $cue->id)[3] + 1;
                                }
                                $CUE                                        = new inspection_and_audit_preventive_upload_evidence;
                                $CUE->id                                    = $req->master_id . '__IAACA_' . $form_id_count;
                                $CUE->inspection_and_audit_form_id          = $old_audit_form->id;
                                $CUE->incidentAudit_master_id               = $req->master_id;
                                $CUE->url                                   = $PREVENTIVE_ACTION_UPLOAD_EVIDENCE_FILE_DB_PATH;
                                $CUE->name                                  = $sign_by_master_FILE_NAME;
                                $CUE->save();
                            } else {
                                $old_audit_form->signed_by_auditee_url_name = null;
                                $cue                                        = inspection_and_audit_preventive_upload_evidence::orderBy('auto_inc', 'DESC')->first();
                                if ($cue == null) {
                                    $form_id_count                              = 1;
                                } else {
                                    $form_id_count                              = explode("_", $cue->id)[3] + 1;
                                }
                                $CUE                                        = new inspection_and_audit_preventive_upload_evidence;
                                $CUE->id                                    = $req->master_id . '__IAACA_' . $form_id_count;
                                $CUE->inspection_and_audit_form_id          = $old_audit_form->id;
                                $CUE->incidentAudit_master_id               = $req->master_id;
                                $CUE->url                                   = null;
                                $CUE->name                                  = null;
                                $CUE->save();
                            }
                        }
                    }

                    // Saving in the 'inspection_and_audit_corrective_actions' table with the unique id of 'inspection_and_audit_forms'
                    $inspection_and_audit_corrective_actions = json_decode($req->corrective_action, true);
                    if ($inspection_and_audit_corrective_actions[0] != '') {
                        $del = inspection_and_audit_corrective_actions::where('inspection_and_audit_form_id', $req->edit)->delete();
                    }
                    for ($i = 0; $i < count(json_decode($req->corrective_action, true)); $i++) {
                        $inspection_and_audit_corrective_actions = json_decode($req->corrective_action, true);
                        $ca                                      = inspection_and_audit_corrective_actions::orderBy('auto_inc', 'DESC')->first();
                        if ($ca == null) {
                            $form_id_count                           = 1;
                        } else {
                            $form_id_count                           = explode("_", $ca->id)[3] + 1;
                        }
                        if ($inspection_and_audit_corrective_actions[$i] != '') {
                            $CA                                      = new inspection_and_audit_corrective_actions;
                            $CA->id                                  = $req->master_id . '__IAACA_' . $form_id_count;
                            $CA->inspection_and_audit_form_id        = $old_audit_form->id;
                            $CA->incidentAudit_master_id             = $req->master_id;
                            $CA->description                         = $inspection_and_audit_corrective_actions[$i];
                            $CA->date_completed                      = $req->c_complete_date;
                            $CA->save();
                        }
                    }

                    // Saving in the 'inspection_and_audit_corrective_upload_evidence' table with the unique id of 'inspection_and_audit_corrective_actions'
                    if (isset($req->c_upload_evidence)) {
                        $del = inspection_and_audit_corrective_upload_evidence::where('inspection_and_audit_form_id', $req->edit)
                            ->delete();
                        for ($i   = 0; $i < count($req->c_upload_evidence); $i++) {
                            if ($req->c_upload_evidence[$i] != 'undefined') {

                                $sign_by_master_FILE_DB_PATH = (new FileSaver)->saveFile(
                                    $req->master_id . DIRECTORY_SEPARATOR .
                                        config('constants.INSPECTION_AUDIT_MODULE_SUB_FORMS.NON_CONFIRMITY') . DIRECTORY_SEPARATOR .
                                        $old_audit_form->id . DIRECTORY_SEPARATOR .
                                        config('constants.INSPECTION_AUDIT_IMAGE_FOLDERS.CORRCTIVE_ACTIONS_UPLOAD_EVIDENCE'),
                                    config('constants.MODULES.INSPECTION_AND_AUDIT'),
                                    $req->file('c_upload_evidence')[$i]
                                );


                                $sign_by_master_FILE_NAME    = $req->file('c_upload_evidence')[$i]->getClientOriginalName();

                                $cue                                        = inspection_and_audit_corrective_upload_evidence::orderBy('auto_inc', 'DESC')->first();
                                if ($cue == null) {
                                    $form_id_count                              = 1;
                                } else {
                                    $form_id_count                              = explode("_", $cue->id)[3] + 1;
                                }
                                $CUE                                        = new inspection_and_audit_corrective_upload_evidence;
                                $CUE->id                                    = $req->master_id . '__IAACA_' . $form_id_count;
                                $CUE->inspection_and_audit_form_id          = $old_audit_form->id;
                                $CUE->incidentAudit_master_id               = $req->master_id;
                                $CUE->url                                   = $sign_by_master_FILE_DB_PATH;
                                $CUE->name                                  = $sign_by_master_FILE_NAME;
                                $CUE->save();
                            } else {
                                $old_audit_form->signed_by_auditee_url_name = null;
                                $cue                                        = inspection_and_audit_corrective_upload_evidence::orderBy('auto_inc', 'DESC')->first();
                                if ($cue == null) {
                                    $form_id_count                              = 1;
                                } else {
                                    $form_id_count                              = explode("_", $cue->id)[3] + 1;
                                }
                                $CUE                                        = new inspection_and_audit_corrective_upload_evidence;
                                $CUE->id                                    = $req->master_id . '__IAACA_' . $form_id_count;
                                $CUE->inspection_and_audit_form_id          = $old_audit_form->id;
                                $CUE->incidentAudit_master_id               = $req->master_id;
                                $CUE->url                                   = null;
                                $CUE->name                                  = null;
                                $CUE->save();
                            }
                        }
                    }

                    $corrective_data                              = inspection_and_audit_corrective_actions::where('inspection_and_audit_form_id', $old_audit_form->id)
                        ->get();
                    $corrective_evidence_data                     = inspection_and_audit_corrective_upload_evidence::where('inspection_and_audit_form_id', $old_audit_form->id)
                        ->get();
                    $response                                     = [$old_audit_form, $corrective_data, $corrective_evidence_data];
                }
            }

            if ($req->Type == config('constants.INSPECTION_AND_AUDIT_FORM_TYPES.OBSERVATION')) {
                Log::info("Enters inside Observation ..... ||Line:1277");
                if ($req->edit == 'null' || $req->edit == null) {
                    Log::info("Enters inside Observation Create ...... ||Line:1279");

                    // Saving in the 'inspection_and_audit_forms' table
                    $master                                       = inspection_and_audit_forms::latest()->first();
                    if ($master == null) {
                        $form_id_count                                = 1;
                    } else {
                        $form_id_count                                = (int)explode("_", $master->id)[3] + 1;
                    }

                    // PRIMARY KEY .....
                    $master_primary_key = $req->master_id . '__IAAF_' . (string)$form_id_count;

                    $New_Audit_Form                               = new inspection_and_audit_forms;
                    $New_Audit_Form->id                           = $master_primary_key;
                    $New_Audit_Form->inspection_and_audit_form_id = $req->master_id;
                    $New_Audit_Form->description                  = $req->description;
                    $New_Audit_Form->type_of_report               = $req->Type;
                    $New_Audit_Form->ism_clause                   = $req->ism;
                    $New_Audit_Form->type_of_nc                   = ($req->major_nc == false && $req->nc == false) ? (($req->major_nc == true) ? 'Major N/C' : 'N/C') : 'N/A';
                    $New_Audit_Form->due_date                     = $req->due_date;
                    $New_Audit_Form->signed_by_auditee_name       = $req->sign_master_text;
                    // SAVING NON-CONFIRMITY SIGNED_BY_MASTER/Auditee FILE
                    if ($req->sign_master != 'undefined') {


                        $sign_by_master_FILE_DB_PATH = (new FileSaver)->saveFile(
                            $req->master_id . DIRECTORY_SEPARATOR .
                                config('constants.INSPECTION_AUDIT_MODULE_SUB_FORMS.OBSERVATION') . DIRECTORY_SEPARATOR .
                                $master_primary_key . DIRECTORY_SEPARATOR .
                                config('constants.INSPECTION_AUDIT_IMAGE_FOLDERS.SIGNED_BY_MASTER'),
                            config('constants.MODULES.INSPECTION_AND_AUDIT'),
                            $req->file('sign_master')
                        );
                        $New_Audit_Form->signed_by_auditee_url_name = $sign_by_master_FILE_DB_PATH;
                    } else {
                        $New_Audit_Form->signed_by_auditee_url_name = null;
                    }

                    $New_Audit_Form->signed_by_auditor_name     = $req->sign_auditor_text;
                    // SAVING NON-CONFIRMITY SIGNED_BY_AUDITOR FILE
                    if ($req->sign_auditor != 'undefined') {


                        $sign_by_auditor_FILE_DB_PATH = (new FileSaver)->saveFile(
                            $req->master_id . DIRECTORY_SEPARATOR .
                                config('constants.INSPECTION_AUDIT_MODULE_SUB_FORMS.OBSERVATION') . DIRECTORY_SEPARATOR .
                                $master_primary_key . DIRECTORY_SEPARATOR  .
                                config('constants.INSPECTION_AUDIT_IMAGE_FOLDERS.SIGNED_BY_AUDITOR'),
                            config('constants.MODULES.INSPECTION_AND_AUDIT'),
                            $req->file('sign_auditor')
                        );


                        $New_Audit_Form->signed_by_auditor_url = $sign_by_auditor_FILE_DB_PATH;
                    } else {
                        $New_Audit_Form->signed_by_auditor_url = null;
                    }

                    $New_Audit_Form->accepted_by_name      = $req->accepted;
                    // SAVING NON-CONFIRMITY ACCEPTED_UPLOAD FILE
                    if ($req->upload_accepted != 'undefined') {


                        $accepted_upload_FILE_DB_PATH = (new FileSaver)->saveFile(
                            $req->master_id . DIRECTORY_SEPARATOR .
                                config('constants.INSPECTION_AUDIT_MODULE_SUB_FORMS.OBSERVATION') . DIRECTORY_SEPARATOR .
                                $master_primary_key . DIRECTORY_SEPARATOR .
                                config('constants.INSPECTION_AUDIT_IMAGE_FOLDERS.ACCEPTED'),
                            config('constants.MODULES.INSPECTION_AND_AUDIT'),
                            $req->file('upload_accepted')
                        );

                        $New_Audit_Form->accepted_by_url       = $accepted_upload_FILE_DB_PATH;
                    } else {
                        $New_Audit_Form->accepted_by_url       = null;
                    }

                    $New_Audit_Form->signed_by_master_name = $req->signed;
                    // SAVING NON-CONFIRMITY SIGN_UPLOAD FILE
                    if ($req->upload_accepted != 'undefined') {


                        $signed_upload_FILE_DB_PATH = (new FileSaver)->saveFile(
                            $req->master_id . DIRECTORY_SEPARATOR .
                                config('constants.INSPECTION_AUDIT_MODULE_SUB_FORMS.OBSERVATION') . DIRECTORY_SEPARATOR .
                                $master_primary_key . DIRECTORY_SEPARATOR .
                                config('constants.INSPECTION_AUDIT_IMAGE_FOLDERS.SIGNED'),
                            config('constants.MODULES.INSPECTION_AND_AUDIT'),
                            $req->file('upload_sign')
                        );


                        $New_Audit_Form->signed_by_master_url     = $signed_upload_FILE_DB_PATH;
                    } else {
                        $New_Audit_Form->signed_by_master_url     = null;
                    }

                    $New_Audit_Form->follow_up_comments       = $req->comments;
                    $New_Audit_Form->is_confirmed_by_dpa      = $req->comfirm_by_dpa;
                    $New_Audit_Form->form_date                = $req->date;
                    $New_Audit_Form->is_verification_required = $req->verification_required;

                    $New_Audit_Form->psc_ref                  = $req->psc_upload;
                    $New_Audit_Form->psc_code                 = $req->ref;
                    $New_Audit_Form->save();

                    // Saving in the 'inspection_and_audit_form_upload_evidence' table with the unique id of 'inspection_and_audit_forms'
                    if (isset($req->upload_document)) {
                        for ($i = 0; $i < count($req->upload_document); $i++) {
                            if ($req->upload_document[$i] != 'undefined') {


                                $UPLOAD_EVIDENCE_FILE_DB_PATH = (new FileSaver)->saveFile(
                                    $req->master_id . DIRECTORY_SEPARATOR .
                                        config('constants.INSPECTION_AUDIT_MODULE_SUB_FORMS.OBSERVATION') . DIRECTORY_SEPARATOR .
                                        $master_primary_key . DIRECTORY_SEPARATOR .
                                        config('constants.INSPECTION_AUDIT_IMAGE_FOLDERS.UPLOAD_EVIDENCE'),
                                    config('constants.MODULES.INSPECTION_AND_AUDIT'),
                                    $req->file('upload_document')[$i]
                                );

                                $sign_by_master_FILE_NAME    = $req->file('upload_document')[$i]->getClientOriginalName();

                                $cue                                        = inspection_and_audit_form_upload_evidence::orderBy('auto_inc', 'DESC')->first();
                                if ($cue == null) {
                                    $form_id_count                              = 1;
                                } else {
                                    $form_id_count                              = explode("_", $cue->id)[3] + 1;
                                }
                                $CUE                                        = new inspection_and_audit_form_upload_evidence;
                                $CUE->id                                    = $req->master_id . '__IAACA_' . $form_id_count;
                                $CUE->inspection_and_audit_form_id          = $New_Audit_Form->id;
                                $CUE->incidentAudit_master_id               = $req->master_id;
                                $CUE->url                                   = $UPLOAD_EVIDENCE_FILE_DB_PATH;
                                $CUE->name                                  = $sign_by_master_FILE_NAME;
                                $CUE->save();
                            } else {
                                $New_Audit_Form->signed_by_auditee_url_name = null;
                                $cue                                        = inspection_and_audit_form_upload_evidence::orderBy('auto_inc', 'DESC')->first();
                                if ($cue == null) {
                                    $form_id_count                              = 1;
                                } else {
                                    $form_id_count                              = explode("_", $cue->id)[3] + 1;
                                }
                                $CUE                                        = new inspection_and_audit_form_upload_evidence;
                                $CUE->id                                    = $req->master_id . '__IAACA_' . $form_id_count;
                                $CUE->inspection_and_audit_form_id          = $New_Audit_Form->id;
                                $CUE->incidentAudit_master_id               = $req->master_id;
                                $CUE->url                                   = null;
                                $CUE->name                                  = null;
                                $CUE->save();
                            }
                        }
                    }

                    // Saving in the 'inspection_and_audit_root_causes' table with the unique id of 'inspection_and_audit_forms'
                    $NMC                              = new NearMissAccidentReporting;
                    $root_causes                      = explode("|", $req->root_cause);
                    if ($root_causes[0] !== '') {
                        $root_causes_first                = explode(",", $root_causes[0]);

                        foreach ($root_causes_first as $root_id) {
                            $rc                               = inspection_and_audit_root_causes::orderBy('auto_inc', 'DESC')->first();
                            if ($rc == null) {
                                $form_id_count                    = 1;
                            } else {
                                $form_id_count                    = explode("_", $rc->id)[3] + 1;
                            }
                            $RC                               = new inspection_and_audit_root_causes;
                            $RC->id                           = $req->master_id . '__IAACA_' . $form_id_count;
                            $RC->inspection_and_audit_form_id = $New_Audit_Form->id;
                            $RC->incidentAudit_master_id      = $req->master_id;
                            $RC->description                  = $NMC->getmain($root_id);
                            $RC->refrence_id                  = $root_id;
                            $RC->save();
                        }
                    }

                    // Saving in the 'inspection_and_audit_root_causes_sub' table with the unique id of 'inspection_and_audit_forms'
                    $NMC                              = new NearMissAccidentReporting;
                    $root_causes                      = explode("|", $req->root_cause);
                    if ($root_causes[1] !== '') {
                        $root_causes_second               = explode(",", $root_causes[1]);

                        foreach ($root_causes_second as $root_id) {
                            $rc                               = inspection_and_audit_root_causes_sub::orderBy('auto_inc', 'DESC')->first();
                            if ($rc == null) {
                                $form_id_count                    = 1;
                            } else {
                                $form_id_count                    = explode("_", $rc->id)[3] + 1;
                            }
                            $RC                               = new inspection_and_audit_root_causes_sub;
                            $RC->id                           = $req->master_id . '__IAACA_' . $form_id_count;
                            $RC->inspection_and_audit_form_id = $New_Audit_Form->id;
                            $RC->incidentAudit_master_id      = $req->master_id;
                            $RC->description                  = $NMC->getsub($root_id);
                            $RC->refrence_id                  = $root_id;
                            $RC->save();
                        }
                    }

                    // Saving in the 'inspection_and_audit_root_causes_ter' table with the unique id of 'inspection_and_audit_forms'
                    $NMC                              = new NearMissAccidentReporting;
                    $root_causes                      = explode("|", $req->root_cause);
                    if ($root_causes[2] !== '') {
                        $root_causes_second               = explode(",", $root_causes[2]);

                        foreach ($root_causes_second as $root_id) {
                            $rc                               = inspection_and_audit_root_causes_ter::orderBy('auto_inc', 'DESC')->first();
                            if ($rc == null) {
                                $form_id_count                    = 1;
                            } else {
                                $form_id_count                    = explode("_", $rc->id)[3] + 1;
                            }
                            $RC                               = new inspection_and_audit_root_causes_ter;
                            $RC->id                           = $req->master_id . '__IAACA_' . $form_id_count;
                            $RC->inspection_and_audit_form_id = $New_Audit_Form->id;
                            $RC->incidentAudit_master_id      = $req->master_id;
                            $RC->description                  = $NMC->getter($root_id);
                            $RC->refrence_id                  = $root_id;
                            $RC->save();
                        }
                    }

                    // Saving in the 'inspection_and_audit_preventive_actions' table with the unique id of 'inspection_and_audit_forms'
                    $NMC                              = new NearMissAccidentReporting;
                    $preventive_aactions              = explode("|", $req->preventive_action);
                    if ($preventive_aactions[0] !== '') {
                        $preventive_aactions_first        = explode(",", $preventive_aactions[0]);

                        foreach ($preventive_aactions_first as $preven_id) {
                            $pa                               = inspection_and_audit_preventive_actions::orderBy('auto_inc', 'DESC')->first();
                            if ($pa == null) {
                                $form_id_count                    = 1;
                            } else {
                                $form_id_count                    = explode("_", $pa->id)[3] + 1;
                            }
                            $PA                               = new inspection_and_audit_preventive_actions;
                            $PA->id                           = $req->master_id . '__IAACA_' . $form_id_count;
                            $PA->inspection_and_audit_form_id = $New_Audit_Form->id;
                            $PA->incidentAudit_master_id      = $req->master_id;
                            $PA->description                  = $NMC->getmain($preven_id);
                            $PA->refrence_id                  = $preven_id;
                            $PA->date_completed               = $req->p_complete_date;
                            $PA->save();
                        }
                    }

                    // Saving in the 'inspection_and_audit_preventive_actions_sub' table with the unique id of 'inspection_and_audit_forms'
                    $NMC                              = new NearMissAccidentReporting;
                    $preventive_aactions              = explode("|", $req->preventive_action);
                    if ($preventive_aactions[0] !== '') {
                        $preventive_aactions_second       = explode(",", $preventive_aactions[0]);

                        foreach ($preventive_aactions_second as $preven_id) {
                            $pa                               = inspection_and_audit_preventive_actions_sub::orderBy('auto_inc', 'DESC')->first();
                            if ($pa == null) {
                                $form_id_count                    = 1;
                            } else {
                                $form_id_count                    = explode("_", $pa->id)[3] + 1;
                            }
                            $PA                               = new inspection_and_audit_preventive_actions_sub;
                            $PA->id                           = $req->master_id . '__IAACA_' . $form_id_count;
                            $PA->inspection_and_audit_form_id = $New_Audit_Form->id;
                            $PA->incidentAudit_master_id      = $req->master_id;
                            $PA->description                  = $NMC->getsub($preven_id);
                            $PA->refrence_id                  = $preven_id;
                            $PA->date_completed               = $req->p_complete_date;
                            $PA->save();
                        }
                    }

                    // Saving in the 'inspection_and_audit_preventive_upload_evidence' table with the unique id of 'inspection_and_audit_preventive_actions'
                    if (isset($req->p_upload_evidence)) {
                        for ($i = 0; $i < count($req->p_upload_evidence); $i++) {
                            if ($req->p_upload_evidence[$i] != 'undefined') {


                                $preventive_upload_evidence_FILE_DB_PATH = (new FileSaver)->saveFile(
                                    $req->master_id . DIRECTORY_SEPARATOR .
                                        config('constants.INSPECTION_AUDIT_MODULE_SUB_FORMS.OBSERVATION') . DIRECTORY_SEPARATOR .
                                        $master_primary_key . DIRECTORY_SEPARATOR .
                                        config('constants.INSPECTION_AUDIT_IMAGE_FOLDERS.PREVENTIVE_ACTIONS_UPLOAD_EVIDENCE'),
                                    config('constants.MODULES.INSPECTION_AND_AUDIT'),
                                    $req->file('p_upload_evidence')[$i]
                                );


                                $sign_by_master_FILE_NAME    = $req->file('p_upload_evidence')[$i]->getClientOriginalName();


                                $cue                                        = inspection_and_audit_preventive_upload_evidence::orderBy('auto_inc', 'DESC')->first();
                                if ($cue == null) {
                                    $form_id_count                              = 1;
                                } else {
                                    $form_id_count                              = explode("_", $cue->id)[3] + 1;
                                }
                                $CUE                                        = new inspection_and_audit_preventive_upload_evidence;
                                $CUE->id                                    = $req->master_id . '__IAACA_' . $form_id_count;
                                $CUE->inspection_and_audit_form_id          = $New_Audit_Form->id;
                                $CUE->incidentAudit_master_id               = $req->master_id;
                                $CUE->url                                   = $preventive_upload_evidence_FILE_DB_PATH;
                                $CUE->name                                  = $sign_by_master_FILE_NAME;
                                $CUE->save();
                            } else {
                                $New_Audit_Form->signed_by_auditee_url_name = null;
                                $cue                                        = inspection_and_audit_preventive_upload_evidence::orderBy('auto_inc', 'DESC')->first();
                                if ($cue == null) {
                                    $form_id_count                              = 1;
                                } else {
                                    $form_id_count                              = explode("_", $cue->id)[3] + 1;
                                }
                                $CUE                                        = new inspection_and_audit_preventive_upload_evidence;
                                $CUE->id                                    = $req->master_id . '__IAACA_' . $form_id_count;
                                $CUE->inspection_and_audit_form_id          = $New_Audit_Form->id;
                                $CUE->incidentAudit_master_id               = $req->master_id;
                                $CUE->url                                   = null;
                                $CUE->name                                  = null;
                                $CUE->save();
                            }
                        }
                    }

                    // Saving in the 'inspection_and_audit_corrective_actions' table with the unique id of 'inspection_and_audit_forms'
                    for ($i = 0; $i < count(json_decode($req->corrective_action, true)); $i++) {
                        $inspection_and_audit_corrective_actions = json_decode($req->corrective_action, true);
                        $ca                                      = inspection_and_audit_corrective_actions::orderBy('auto_inc', 'DESC')->first();
                        if ($ca == null) {
                            $form_id_count                           = 1;
                        } else {
                            $form_id_count                           = explode("_", $ca->id)[3] + 1;
                        }
                        if ($inspection_and_audit_corrective_actions[$i] != '') {
                            $CA                                      = new inspection_and_audit_corrective_actions;
                            $CA->id                                  = $req->master_id . '__IAACA_' . $form_id_count;
                            $CA->inspection_and_audit_form_id        = $New_Audit_Form->id;
                            $CA->incidentAudit_master_id             = $req->master_id;
                            $CA->description                         = $inspection_and_audit_corrective_actions[$i];
                            $CA->date_completed                      = $req->c_complete_date;
                            $CA->save();
                        }
                    }

                    // Saving in the 'inspection_and_audit_corrective_upload_evidence' table with the unique id of 'inspection_and_audit_corrective_actions'
                    if (isset($req->c_upload_evidence)) {
                        for ($i = 0; $i < count($req->c_upload_evidence); $i++) {
                            if ($req->c_upload_evidence[$i] != 'undefined') {



                                $sign_by_master_FILE_DB_PATH = (new FileSaver)->saveFile(
                                    $req->master_id . DIRECTORY_SEPARATOR .
                                        config('constants.INSPECTION_AUDIT_MODULE_SUB_FORMS.OBSERVATION') . DIRECTORY_SEPARATOR .
                                        $master_primary_key . DIRECTORY_SEPARATOR .
                                        config('constants.INSPECTION_AUDIT_IMAGE_FOLDERS.CORRCTIVE_ACTIONS_UPLOAD_EVIDENCE'),
                                    config('constants.MODULES.INSPECTION_AND_AUDIT'),
                                    $req->file('c_upload_evidence')[$i]
                                );

                                $sign_by_master_FILE_NAME    = $req->file('c_upload_evidence')[$i]->getClientOriginalName();

                                $cue                                        = inspection_and_audit_corrective_upload_evidence::orderBy('auto_inc', 'DESC')->first();
                                if ($cue == null) {
                                    $form_id_count                              = 1;
                                } else {
                                    $form_id_count                              = explode("_", $cue->id)[3] + 1;
                                }
                                $CUE                                        = new inspection_and_audit_corrective_upload_evidence;
                                $CUE->id                                    = $req->master_id . '__IAACA_' . $form_id_count;
                                $CUE->inspection_and_audit_form_id          = $New_Audit_Form->id;
                                $CUE->incidentAudit_master_id               = $req->master_id;
                                $CUE->url                                   = $sign_by_master_FILE_DB_PATH;
                                $CUE->name                                  = $sign_by_master_FILE_NAME;
                                $CUE->save();
                            } else {
                                $New_Audit_Form->signed_by_auditee_url_name = null;
                                $cue                                        = inspection_and_audit_corrective_upload_evidence::orderBy('auto_inc', 'DESC')->first();
                                if ($cue == null) {
                                    $form_id_count                              = 1;
                                } else {
                                    $form_id_count                              = explode("_", $cue->id)[3] + 1;
                                }
                                $CUE                                        = new inspection_and_audit_corrective_upload_evidence;
                                $CUE->id                                    = $req->master_id . '__IAACA_' . $form_id_count;
                                $CUE->inspection_and_audit_form_id          = $New_Audit_Form->id;
                                $CUE->incidentAudit_master_id               = $req->master_id;
                                $CUE->url                                   = null;
                                $CUE->name                                  = null;
                                $CUE->save();
                            }
                        }
                    }

                    $response                                     = [$New_Audit_Form];
                } else {
                    Log::info("Enters inside Observation Edit ..... ||Line:1628");

                    if ($req->major_nc == 'true' || $req->nc == 'true') {
                        if ($req->major_nc == 'true') {
                            $type_of_nc                                   = 'Major N/C';
                        } else {
                            $type_of_nc                                   = 'N/C';
                        }
                    } else {
                        $type_of_nc                                   = 'N/A';
                    }
                    $old_audit_form                               = inspection_and_audit_forms::find($req->edit);
                    $old_audit_form->inspection_and_audit_form_id = $req->master_id;

                    $old_audit_form->description                  = $req->description;
                    $old_audit_form->type_of_report               = $req->Type;
                    $old_audit_form->ism_clause                   = $req->ism;
                    $old_audit_form->type_of_nc                   = $type_of_nc;
                    $old_audit_form->due_date                     = $req->due_date;

                    $old_audit_form->signed_by_auditee_name       = $req->sign_master_text;
                    // SAVING NON-CONFIRMITY SIGNED_BY_MASTER/Auditee FILE
                    if ($req->sign_master != 'undefined') {

                        $sign_by_master_FILE_DB_PATH = (new FileSaver)->saveFile(
                            $req->master_id . DIRECTORY_SEPARATOR .
                                config('constants.INSPECTION_AUDIT_MODULE_SUB_FORMS.OBSERVATION') . DIRECTORY_SEPARATOR .
                                $old_audit_form->id . DIRECTORY_SEPARATOR .
                                config('constants.INSPECTION_AUDIT_IMAGE_FOLDERS.SIGNED_BY_MASTER'),
                            config('constants.MODULES.INSPECTION_AND_AUDIT'),
                            $req->file('sign_master')
                        );


                        $old_audit_form->signed_by_auditee_url_name = $sign_by_master_FILE_DB_PATH;
                    }

                    $old_audit_form->signed_by_auditor_name     = $req->sign_auditor_text;
                    // SAVING NON-CONFIRMITY SIGNED_BY_AUDITOR FILE
                    if ($req->sign_auditor != 'undefined') {

                        $sign_by_auditor_FILE_DB_PATH = (new FileSaver)->saveFile(
                            $req->master_id . DIRECTORY_SEPARATOR .
                                config('constants.INSPECTION_AUDIT_MODULE_SUB_FORMS.OBSERVATION') . DIRECTORY_SEPARATOR .
                                $old_audit_form->id . DIRECTORY_SEPARATOR .
                                config('constants.INSPECTION_AUDIT_IMAGE_FOLDERS.SIGNED_BY_AUDITOR'),
                            config('constants.MODULES.INSPECTION_AND_AUDIT'),
                            $req->file('sign_auditor')
                        );


                        $old_audit_form->signed_by_auditor_url = $sign_by_auditor_FILE_DB_PATH;
                    }

                    $old_audit_form->accepted_by_name      = $req->accepted;
                    // SAVING NON-CONFIRMITY ACCEPTED_UPLOAD FILE
                    if ($req->upload_accepted != 'undefined') {


                        $accepted_upload_FILE_DB_PATH = (new FileSaver)->saveFile(
                            $req->master_id . DIRECTORY_SEPARATOR .
                                config('constants.INSPECTION_AUDIT_MODULE_SUB_FORMS.OBSERVATION') . DIRECTORY_SEPARATOR .
                                $old_audit_form->id . DIRECTORY_SEPARATOR .
                                config('constants.INSPECTION_AUDIT_IMAGE_FOLDERS.ACCEPTED'),
                            config('constants.MODULES.INSPECTION_AND_AUDIT'),
                            $req->file('upload_accepted')
                        );


                        $old_audit_form->accepted_by_url       = $accepted_upload_FILE_DB_PATH;
                    }

                    $old_audit_form->signed_by_master_name = $req->signed;
                    // SAVING NON-CONFIRMITY SIGN_UPLOAD FILE
                    if ($req->upload_accepted != 'undefined') {


                        $signed_upload_FILE_DB_PATH = (new FileSaver)->saveFile(
                            $req->master_id . DIRECTORY_SEPARATOR .
                                config('constants.INSPECTION_AUDIT_MODULE_SUB_FORMS.OBSERVATION') . DIRECTORY_SEPARATOR .
                                $old_audit_form->id . DIRECTORY_SEPARATOR .
                                config('constants.INSPECTION_AUDIT_IMAGE_FOLDERS.SIGNED'),
                            config('constants.MODULES.INSPECTION_AND_AUDIT'),
                            $req->file('upload_sign')
                        );



                        $old_audit_form->signed_by_master_url     = $signed_upload_FILE_DB_PATH;
                    }

                    $old_audit_form->follow_up_comments       = $req->comments;
                    $old_audit_form->is_confirmed_by_dpa      = $req->comfirm_by_dpa;
                    $old_audit_form->form_date                = $req->date;
                    $old_audit_form->is_verification_required = $req->verification_required;

                    $old_audit_form->psc_ref                  = $req->psc_upload;
                    $old_audit_form->psc_code                 = $req->ref;
                    $old_audit_form->save();

                    // Saving in the 'inspection_and_audit_form_upload_evidence' table with the unique id of 'inspection_and_audit_forms'
                    if (isset($req->upload_document)) {
                        $yo = inspection_and_audit_form_upload_evidence::where('inspection_and_audit_form_id', $req->edit)
                            ->delete();

                        for ($i  = 0; $i < count($req->upload_document); $i++) {
                            if ($req->upload_document[$i] != 'undefined') {


                                $UPLOAD_EVIDENCE_FILE_DB_PATH  = (new FileSaver)->saveFile(
                                    $req->master_id . DIRECTORY_SEPARATOR .
                                        config('constants.INSPECTION_AUDIT_MODULE_SUB_FORMS.OBSERVATION') . DIRECTORY_SEPARATOR .
                                        $old_audit_form->id . DIRECTORY_SEPARATOR .
                                        config('constants.INSPECTION_AUDIT_IMAGE_FOLDERS.UPLOAD_EVIDENCE'),
                                    config('constants.MODULES.INSPECTION_AND_AUDIT'),
                                    $req->file('upload_document')[$i]
                                );



                                $sign_by_master_FILE_NAME    = $req->file('upload_document')[$i]->getClientOriginalName();

                                $cue                                        = inspection_and_audit_form_upload_evidence::orderBy('auto_inc', 'DESC')->first();
                                if ($cue == null) {
                                    $form_id_count                              = 1;
                                } else {
                                    $form_id_count                              = explode("_", $cue->id)[3] + 1;
                                }
                                $CUE                                        = new inspection_and_audit_form_upload_evidence;
                                $CUE->id                                    = $req->master_id . '__IAACA_' . $form_id_count;
                                $CUE->inspection_and_audit_form_id          = $old_audit_form->id;
                                $CUE->incidentAudit_master_id               = $req->master_id;
                                $CUE->url                                   = $UPLOAD_EVIDENCE_FILE_DB_PATH;
                                $CUE->name                                  = $sign_by_master_FILE_NAME;
                                $CUE->save();
                            } else {
                                $old_audit_form->signed_by_auditee_url_name = null;
                                $cue                                        = inspection_and_audit_form_upload_evidence::orderBy('auto_inc', 'DESC')->first();
                                if ($cue == null) {
                                    $form_id_count                              = 1;
                                } else {
                                    $form_id_count                              = explode("_", $cue->id)[3] + 1;
                                }
                                $CUE                                        = new inspection_and_audit_form_upload_evidence;
                                $CUE->id                                    = $req->master_id . '__IAACA_' . $form_id_count;
                                $CUE->inspection_and_audit_form_id          = $old_audit_form->id;
                                $CUE->incidentAudit_master_id               = $req->master_id;
                                $CUE->url                                   = null;
                                $CUE->name                                  = null;
                                $CUE->save();
                            }
                        }
                    }

                    // Saving in the 'inspection_and_audit_root_causes' table with the unique id of 'inspection_and_audit_forms'
                    $NMC                              = new NearMissAccidentReporting;
                    $root_causes                      = explode("|", $req->root_cause);
                    if ($root_causes[0] !== '') {
                        $root_causes_first                = explode(",", $root_causes[0]);
                        $del                              = inspection_and_audit_root_causes::where('inspection_and_audit_form_id', $req->edit)
                            ->delete();
                        foreach ($root_causes_first as $root_id) {
                            $rc                               = inspection_and_audit_root_causes::orderBy('auto_inc', 'DESC')->first();
                            if ($rc == null) {
                                $form_id_count                    = 1;
                            } else {
                                $form_id_count                    = explode("_", $rc->id)[3] + 1;
                            }
                            $RC                               = new inspection_and_audit_root_causes;
                            $RC->id                           = $req->master_id . '__IAACA_' . $form_id_count;
                            $RC->inspection_and_audit_form_id = $old_audit_form->id;
                            $RC->incidentAudit_master_id      = $req->master_id;
                            $RC->description                  = $NMC->getmain($root_id);
                            $RC->refrence_id                  = $root_id;
                            $RC->save();
                        }
                    }

                    // Saving in the 'inspection_and_audit_root_causes_sub' table with the unique id of 'inspection_and_audit_forms'
                    $NMC                              = new NearMissAccidentReporting;
                    $root_causes                      = explode("|", $req->root_cause);
                    if ($root_causes[1] !== '') {

                        $root_causes_second               = explode(",", $root_causes[1]);
                        $del                              = inspection_and_audit_root_causes_sub::where('inspection_and_audit_form_id', $req->edit)
                            ->delete();
                        foreach ($root_causes_second as $root_id) {
                            $rc                               = inspection_and_audit_root_causes_sub::orderBy('auto_inc', 'DESC')->first();
                            if ($rc == null) {
                                $form_id_count                    = 1;
                            } else {
                                $form_id_count                    = explode("_", $rc->id)[3] + 1;
                            }
                            $RC                               = new inspection_and_audit_root_causes_sub;
                            $RC->id                           = $req->master_id . '__IAACA_' . $form_id_count;
                            $RC->inspection_and_audit_form_id = $old_audit_form->id;
                            $RC->incidentAudit_master_id      = $req->master_id;
                            $RC->description                  = $NMC->getsub($root_id);
                            $RC->refrence_id                  = $root_id;
                            $RC->save();
                        }
                    }

                    // Saving in the 'inspection_and_audit_root_causes_ter' table with the unique id of 'inspection_and_audit_forms'
                    $NMC                              = new NearMissAccidentReporting;
                    $root_causes                      = explode("|", $req->root_cause);
                    if ($root_causes[2] !== '') {
                        $root_causes_second               = explode(",", $root_causes[2]);
                        $del                              = inspection_and_audit_root_causes_ter::where('inspection_and_audit_form_id', $req->edit)
                            ->delete();
                        foreach ($root_causes_second as $root_id) {
                            $rc                               = inspection_and_audit_root_causes_ter::orderBy('auto_inc', 'DESC')->first();
                            if ($rc == null) {
                                $form_id_count                    = 1;
                            } else {
                                $form_id_count                    = explode("_", $rc->id)[3] + 1;
                            }
                            $RC                               = new inspection_and_audit_root_causes_ter;
                            $RC->id                           = $req->master_id . '__IAACA_' . $form_id_count;
                            $RC->inspection_and_audit_form_id = $old_audit_form->id;
                            $RC->incidentAudit_master_id      = $req->master_id;
                            $RC->description                  = $NMC->getter($root_id);
                            $RC->refrence_id                  = $root_id;
                            $RC->save();
                        }
                    }

                    // Saving in the 'inspection_and_audit_preventive_actions' table with the unique id of 'inspection_and_audit_forms'
                    $NMC                              = new NearMissAccidentReporting;
                    $preventive_aactions              = explode("|", $req->preventive_action);
                    if ($preventive_aactions[0] !== '') {
                        $preventive_aactions_first        = explode(",", $preventive_aactions[0]);
                        $del                              = inspection_and_audit_preventive_actions::where('inspection_and_audit_form_id', $req->edit)
                            ->delete();
                        foreach ($preventive_aactions_first as $preven_id) {
                            $pa                               = inspection_and_audit_preventive_actions::orderBy('auto_inc', 'DESC')->first();
                            if ($pa == null) {
                                $form_id_count                    = 1;
                            } else {
                                $form_id_count                    = explode("_", $pa->id)[3] + 1;
                            }
                            $PA                               = new inspection_and_audit_preventive_actions;
                            $PA->id                           = $req->master_id . '__IAACA_' . $form_id_count;
                            $PA->inspection_and_audit_form_id = $old_audit_form->id;
                            $PA->incidentAudit_master_id      = $req->master_id;
                            $PA->description                  = $NMC->getmain($preven_id);
                            $PA->refrence_id                  = $preven_id;
                            $PA->date_completed               = $req->p_complete_date;
                            $PA->save();
                        }
                    }

                    // Saving in the 'inspection_and_audit_preventive_actions_sub' table with the unique id of 'inspection_and_audit_forms'
                    $NMC                              = new NearMissAccidentReporting;
                    $preventive_aactions              = explode("|", $req->preventive_action);
                    if ($preventive_aactions[0] !== '') {
                        $preventive_aactions_second       = explode(",", $preventive_aactions[0]);
                        $del                              = inspection_and_audit_preventive_actions_sub::where('inspection_and_audit_form_id', $req->edit)
                            ->delete();
                        foreach ($preventive_aactions_second as $preven_id) {
                            $pa                               = inspection_and_audit_preventive_actions_sub::orderBy('auto_inc', 'DESC')->first();
                            if ($pa == null) {
                                $form_id_count                    = 1;
                            } else {
                                $form_id_count                    = explode("_", $pa->id)[3] + 1;
                            }
                            $PA                               = new inspection_and_audit_preventive_actions_sub;
                            $PA->id                           = $req->master_id . '__IAACA_' . $form_id_count;
                            $PA->inspection_and_audit_form_id = $old_audit_form->id;
                            $PA->incidentAudit_master_id      = $req->master_id;
                            $PA->description                  = $NMC->getsub($preven_id);
                            $PA->refrence_id                  = $preven_id;
                            $PA->date_completed               = $req->p_complete_date;
                            $PA->save();
                        }
                    }

                    // Saving in the 'inspection_and_audit_preventive_upload_evidence' table with the unique id of 'inspection_and_audit_preventive_actions'
                    if (isset($req->p_upload_evidence)) {
                        $del = inspection_and_audit_preventive_upload_evidence::where('inspection_and_audit_form_id', $req->edit)
                            ->delete();
                        for ($i   = 0; $i < count($req->p_upload_evidence); $i++) {
                            if ($req->p_upload_evidence[$i] != 'undefined') {



                                $PREVENTIVE_ACTION_UPLOAD_EVIDENCE_FILE_DB_PATH = (new FileSaver)->saveFile(
                                    $req->master_id . DIRECTORY_SEPARATOR .
                                        config('constants.INSPECTION_AUDIT_MODULE_SUB_FORMS.OBSERVATION') . DIRECTORY_SEPARATOR .
                                        $old_audit_form->id . DIRECTORY_SEPARATOR .
                                        config('constants.INSPECTION_AUDIT_IMAGE_FOLDERS.PREVENTIVE_ACTIONS_UPLOAD_EVIDENCE'),
                                    config('constants.MODULES.INSPECTION_AND_AUDIT'),
                                    $req->file('p_upload_evidence')[$i]
                                );



                                $sign_by_master_FILE_NAME    = $req->file('p_upload_evidence')[$i]->getClientOriginalName();

                                $cue                                        = inspection_and_audit_preventive_upload_evidence::orderBy('auto_inc', 'DESC')->first();
                                if ($cue == null) {
                                    $form_id_count                              = 1;
                                } else {
                                    $form_id_count                              = explode("_", $cue->id)[3] + 1;
                                }
                                $CUE                                        = new inspection_and_audit_preventive_upload_evidence;
                                $CUE->id                                    = $req->master_id . '__IAACA_' . $form_id_count;
                                $CUE->inspection_and_audit_form_id          = $old_audit_form->id;
                                $CUE->incidentAudit_master_id               = $req->master_id;
                                $CUE->url                                   = $PREVENTIVE_ACTION_UPLOAD_EVIDENCE_FILE_DB_PATH;
                                $CUE->name                                  = $sign_by_master_FILE_NAME;
                                $CUE->save();
                            } else {
                                $old_audit_form->signed_by_auditee_url_name = null;
                                $cue                                        = inspection_and_audit_preventive_upload_evidence::orderBy('auto_inc', 'DESC')->first();
                                if ($cue == null) {
                                    $form_id_count                              = 1;
                                } else {
                                    $form_id_count                              = explode("_", $cue->id)[3] + 1;
                                }
                                $CUE                                        = new inspection_and_audit_preventive_upload_evidence;
                                $CUE->id                                    = $req->master_id . '__IAACA_' . $form_id_count;
                                $CUE->inspection_and_audit_form_id          = $old_audit_form->id;
                                $CUE->incidentAudit_master_id               = $req->master_id;
                                $CUE->url                                   = null;
                                $CUE->name                                  = null;
                                $CUE->save();
                            }
                        }
                    }

                    // Saving inside 'inspection_and_audit_corrective_actions' table with the unique id of 'inspection_and_audit_forms' For observation form
                    // Remove Blank Space From Corrective_actions input Array .....
                    $inspection_and_audit_corrective_actions = array_diff(json_decode($req->corrective_action, true), ['']);

                    if (!empty($inspection_and_audit_corrective_actions)) {
                        $del = inspection_and_audit_corrective_actions::where('inspection_and_audit_form_id', $req->edit)->delete();
                        foreach ($inspection_and_audit_corrective_actions as $key => $value) {
                            // Generating ID .....
                            $ca = inspection_and_audit_corrective_actions::orderBy('auto_inc', 'DESC')->first();
                            if ($ca == null) {
                                $form_id_count = 1;
                            } else {
                                $form_id_count = explode("_", $ca->id)[3] + 1;
                            }
                            // Saving .....
                            $CA                                      = new inspection_and_audit_corrective_actions;
                            $CA->id                                  = $req->master_id . '__IAACA_' . $form_id_count;
                            $CA->inspection_and_audit_form_id        = $old_audit_form->id;
                            $CA->incidentAudit_master_id             = $req->master_id;
                            $CA->description                         = $value;
                            $CA->date_completed                      = $req->c_complete_date;
                            $CA->save();
                        }
                    }

                    // Saving in the 'inspection_and_audit_corrective_upload_evidence' table with the unique id of 'inspection_and_audit_corrective_actions'
                    if (isset($req->c_upload_evidence)) {
                        $del = inspection_and_audit_corrective_upload_evidence::where('inspection_and_audit_form_id', $req->edit)
                            ->delete();
                        for ($i   = 0; $i < count($req->c_upload_evidence); $i++) {
                            if ($req->c_upload_evidence[$i] != 'undefined') {


                                $CORRECTIVE_ACTIONS_UPLOAD_EVIDENCE_FILE_DB_PATH = (new FileSaver)->saveFile(
                                    $req->master_id . DIRECTORY_SEPARATOR .
                                        config('constants.INSPECTION_AUDIT_MODULE_SUB_FORMS.NON_CONFIRMITY') . DIRECTORY_SEPARATOR .
                                        $old_audit_form->id . DIRECTORY_SEPARATOR .
                                        config('constants.INSPECTION_AUDIT_IMAGE_FOLDERS.CORRCTIVE_ACTIONS_UPLOAD_EVIDENCE'),
                                    config('constants.MODULES.INSPECTION_AND_AUDIT'),
                                    $req->file('c_upload_evidence')[$i]
                                );



                                $sign_by_master_FILE_NAME    = $req->file('c_upload_evidence')[$i]->getClientOriginalName();


                                $cue                                        = inspection_and_audit_corrective_upload_evidence::orderBy('auto_inc', 'DESC')->first();
                                if ($cue == null) {
                                    $form_id_count                              = 1;
                                } else {
                                    $form_id_count                              = explode("_", $cue->id)[3] + 1;
                                }
                                $CUE                                        = new inspection_and_audit_corrective_upload_evidence;
                                $CUE->id                                    = $req->master_id . '__IAACA_' . $form_id_count;
                                $CUE->inspection_and_audit_form_id          = $old_audit_form->id;
                                $CUE->incidentAudit_master_id               = $req->master_id;
                                $CUE->url                                   = $CORRECTIVE_ACTIONS_UPLOAD_EVIDENCE_FILE_DB_PATH;
                                $CUE->name                                  = $sign_by_master_FILE_NAME;
                                $CUE->save();
                            } else {
                                $old_audit_form->signed_by_auditee_url_name = null;
                                $cue                                        = inspection_and_audit_corrective_upload_evidence::orderBy('auto_inc', 'DESC')->first();
                                if ($cue == null) {
                                    $form_id_count                              = 1;
                                } else {
                                    $form_id_count                              = explode("_", $cue->id)[3] + 1;
                                }
                                $CUE                                        = new inspection_and_audit_corrective_upload_evidence;
                                $CUE->id                                    = $req->master_id . '__IAACA_' . $form_id_count;
                                $CUE->inspection_and_audit_form_id          = $old_audit_form->id;
                                $CUE->incidentAudit_master_id               = $req->master_id;
                                $CUE->url                                   = null;
                                $CUE->name                                  = null;
                                $CUE->save();
                            }
                        }
                    }

                    $response  = [$old_audit_form];
                }
            }

            if ($req->Type == config('constants.INSPECTION_AND_AUDIT_FORM_TYPES.PSC')) {
                Log::info("Enters inside PSC ..... ||Line:1997");
                if ($req->edit == 'null' || $req->edit == null) {
                    Log::info("Enters inside PSC Create ..... ||Line:1999");
                    // Saving in the 'inspection_and_audit_forms' table
                    $master                                       = DB::table('inspection_and_audit_forms')->latest()
                        ->first();
                    if ($master == null) {
                        $form_id_count                                = 1;
                    } else {
                        $form_id_count                                = explode("_", $master->id)[3] + 1;
                    }

                    // CUSTOM ID GENERATION .....
                    $master_primary_key = $req->master_id . '__IAAF_' . $form_id_count;

                    $New_Audit_Form                               = new inspection_and_audit_forms;
                    $New_Audit_Form->id                           =  $master_primary_key;
                    $New_Audit_Form->inspection_and_audit_form_id = $req->master_id;

                    $New_Audit_Form->description                  = $req->description;
                    $New_Audit_Form->type_of_report               = $req->Type;
                    // $New_Audit_Form->due_date  = $req->due_date;
                    $New_Audit_Form->psc_ref                      = $req->ref;
                    $New_Audit_Form->psc_code                     = $req->code;
                    $New_Audit_Form->save();

                    // Saving in the 'inspection_and_audit_form_upload_evidence' table with the unique id of 'inspection_and_audit_forms'
                    if (isset($req->upload_document)) {
                        for ($i = 0; $i < count($req->upload_document); $i++) {
                            if ($req->upload_document[$i] != 'undefined') {


                                $UPLOAD_EVIDENCE_FILE_DB_PATH = (new FileSaver)->saveFile(
                                    $req->master_id . DIRECTORY_SEPARATOR .
                                        config('constants.INSPECTION_AUDIT_MODULE_SUB_FORMS.PSC') . DIRECTORY_SEPARATOR .
                                        $master_primary_key . DIRECTORY_SEPARATOR .
                                        config('constants.INSPECTION_AUDIT_IMAGE_FOLDERS.UPLOAD_EVIDENCE'),
                                    config('constants.MODULES.INSPECTION_AND_AUDIT'),
                                    $req->file('upload_document')[$i]
                                );


                                $sign_by_master_FILE_NAME    = $req->file('upload_document')[$i]->getClientOriginalName();


                                $cue                                        = inspection_and_audit_form_upload_evidence::orderBy('auto_inc', 'DESC')->first();
                                if ($cue == null) {
                                    $form_id_count                              = 1;
                                } else {
                                    $form_id_count                              = explode("_", $cue->id)[3] + 1;
                                }
                                $CUE                                        = new inspection_and_audit_form_upload_evidence;
                                $CUE->id                                    = $req->master_id . '__IAACA_' . $form_id_count;
                                $CUE->inspection_and_audit_form_id          = $New_Audit_Form->id;
                                $CUE->incidentAudit_master_id               = $req->master_id;
                                $CUE->url                                   = $UPLOAD_EVIDENCE_FILE_DB_PATH;
                                $CUE->name                                  = $sign_by_master_FILE_NAME;
                                $CUE->save();
                            } else {
                                $New_Audit_Form->signed_by_auditee_url_name = null;
                                $cue                                        = inspection_and_audit_form_upload_evidence::orderBy('auto_inc', 'DESC')->first();
                                if ($cue == null) {
                                    $form_id_count                              = 1;
                                } else {
                                    $form_id_count                              = explode("_", $cue->id)[3] + 1;
                                }
                                $CUE                                        = new inspection_and_audit_form_upload_evidence;
                                $CUE->id                                    = $req->master_id . '__IAACA_' . $form_id_count;
                                $CUE->inspection_and_audit_form_id          = $New_Audit_Form->id;
                                $CUE->incidentAudit_master_id               = $req->master_id;
                                $CUE->url                                   = null;
                                $CUE->name                                  = null;
                                $CUE->save();
                            }
                        }
                    }

                    // Saving in the 'inspection_and_audit_root_causes' table with the unique id of 'inspection_and_audit_forms'
                    $NMC                              = new NearMissAccidentReporting;
                    $root_causes                      = explode("|", $req->root_cause);
                    if ($root_causes[0] !== '') {
                        $root_causes_first                = explode(",", $root_causes[0]);

                        foreach ($root_causes_first as $root_id) {
                            $rc                               = inspection_and_audit_root_causes::orderBy('auto_inc', 'DESC')->first();
                            if ($rc == null) {
                                $form_id_count                    = 1;
                            } else {
                                $form_id_count                    = explode("_", $rc->id)[3] + 1;
                            }
                            $RC                               = new inspection_and_audit_root_causes;
                            $RC->id                           = $req->master_id . '__IAACA_' . $form_id_count;
                            $RC->inspection_and_audit_form_id = $New_Audit_Form->id;
                            $RC->incidentAudit_master_id      = $req->master_id;
                            $RC->description                  = $NMC->getmain($root_id);
                            $RC->refrence_id                  = $root_id;
                            $RC->save();
                        }
                    }

                    // Saving in the 'inspection_and_audit_root_causes_sub' table with the unique id of 'inspection_and_audit_forms'
                    $NMC                              = new NearMissAccidentReporting;
                    $root_causes                      = explode("|", $req->root_cause);
                    if ($root_causes[1] !== '') {
                        $root_causes_second               = explode(",", $root_causes[1]);

                        foreach ($root_causes_second as $root_id) {
                            $rc                               = inspection_and_audit_root_causes_sub::orderBy('auto_inc', 'DESC')->first();
                            if ($rc == null) {
                                $form_id_count                    = 1;
                            } else {
                                $form_id_count                    = explode("_", $rc->id)[3] + 1;
                            }
                            $RC                               = new inspection_and_audit_root_causes_sub;
                            $RC->id                           = $req->master_id . '__IAACA_' . $form_id_count;
                            $RC->inspection_and_audit_form_id = $New_Audit_Form->id;
                            $RC->incidentAudit_master_id      = $req->master_id;
                            $RC->description                  = $NMC->getsub($root_id);
                            $RC->refrence_id                  = $root_id;
                            $RC->save();
                        }
                    }

                    // Saving in the 'inspection_and_audit_root_causes_ter' table with the unique id of 'inspection_and_audit_forms'
                    $NMC                              = new NearMissAccidentReporting;
                    $root_causes                      = explode("|", $req->root_cause);
                    if ($root_causes[2] !== '') {
                        $root_causes_second               = explode(",", $root_causes[2]);

                        foreach ($root_causes_second as $root_id) {
                            $rc                               = inspection_and_audit_root_causes_ter::orderBy('auto_inc', 'DESC')->first();
                            if ($rc == null) {
                                $form_id_count                    = 1;
                            } else {
                                $form_id_count                    = explode("_", $rc->id)[3] + 1;
                            }
                            $RC                               = new inspection_and_audit_root_causes_ter;
                            $RC->id                           = $req->master_id . '__IAACA_' . $form_id_count;
                            $RC->inspection_and_audit_form_id = $New_Audit_Form->id;
                            $RC->incidentAudit_master_id      = $req->master_id;
                            $RC->description                  = $NMC->getter($root_id);
                            $RC->refrence_id                  = $root_id;
                            $RC->save();
                        }
                    }

                    // Saving in the 'inspection_and_audit_preventive_actions' table with the unique id of 'inspection_and_audit_forms'
                    $NMC                              = new NearMissAccidentReporting;
                    $preventive_aactions              = explode("|", $req->preventive_action);
                    if ($preventive_aactions[0] !== '') {
                        $preventive_aactions_first        = explode(",", $preventive_aactions[0]);

                        foreach ($preventive_aactions_first as $preven_id) {
                            $pa                               = inspection_and_audit_preventive_actions::orderBy('auto_inc', 'DESC')->first();
                            if ($pa == null) {
                                $form_id_count                    = 1;
                            } else {
                                $form_id_count                    = explode("_", $pa->id)[3] + 1;
                            }
                            $PA                               = new inspection_and_audit_preventive_actions;
                            $PA->id                           = $req->master_id . '__IAACA_' . $form_id_count;
                            $PA->inspection_and_audit_form_id = $New_Audit_Form->id;
                            $PA->incidentAudit_master_id      = $req->master_id;
                            $PA->description                  = $NMC->getmain($preven_id);
                            $PA->refrence_id                  = $preven_id;
                            $PA->date_completed               = $req->p_complete_date;
                            $PA->save();
                        }
                    }

                    // Saving in the 'inspection_and_audit_preventive_actions_sub' table with the unique id of 'inspection_and_audit_forms'
                    $NMC                              = new NearMissAccidentReporting;
                    $preventive_aactions              = explode("|", $req->preventive_action);
                    if ($preventive_aactions[0] !== '') {
                        $preventive_aactions_second       = explode(",", $preventive_aactions[0]);

                        foreach ($preventive_aactions_second as $preven_id) {
                            $pa                               = inspection_and_audit_preventive_actions_sub::orderBy('auto_inc', 'DESC')->first();
                            if ($pa == null) {
                                $form_id_count                    = 1;
                            } else {
                                $form_id_count                    = explode("_", $pa->id)[3] + 1;
                            }
                            $PA                               = new inspection_and_audit_preventive_actions_sub;
                            $PA->id                           = $req->master_id . '__IAACA_' . $form_id_count;
                            $PA->inspection_and_audit_form_id = $New_Audit_Form->id;
                            $PA->incidentAudit_master_id      = $req->master_id;
                            $PA->description                  = $NMC->getsub($preven_id);
                            $PA->refrence_id                  = $preven_id;
                            $PA->date_completed               = $req->p_complete_date;
                            $PA->save();
                        }
                    }

                    // Saving in the 'inspection_and_audit_preventive_upload_evidence' table with the unique id of 'inspection_and_audit_preventive_actions'
                    if (isset($req->p_upload_evidence)) {
                        for ($i = 0; $i < count($req->p_upload_evidence); $i++) {
                            if ($req->p_upload_evidence[$i] != 'undefined') {


                                $PREVENTIVE_ACTIONS_UPLOAD_EVIDENCE_FILE_DB_PATH = (new FileSaver)->saveFile(
                                    $req->master_id . DIRECTORY_SEPARATOR .
                                        config('constants.INSPECTION_AUDIT_MODULE_SUB_FORMS.PSC') . DIRECTORY_SEPARATOR .
                                        $master_primary_key . DIRECTORY_SEPARATOR .
                                        config('constants.INSPECTION_AUDIT_IMAGE_FOLDERS.PREVENTIVE_ACTIONS_UPLOAD_EVIDENCE'),
                                    config('constants.MODULES.INSPECTION_AND_AUDIT'),
                                    $req->file('p_upload_evidence')[$i]
                                );


                                $sign_by_master_FILE_NAME    = $req->file('p_upload_evidence')[$i]->getClientOriginalName();

                                $cue                                        = inspection_and_audit_preventive_upload_evidence::orderBy('auto_inc', 'DESC')->first();
                                if ($cue == null) {
                                    $form_id_count                              = 1;
                                } else {
                                    $form_id_count                              = explode("_", $cue->id)[3] + 1;
                                }
                                $CUE                                        = new inspection_and_audit_preventive_upload_evidence;
                                $CUE->id                                    = $req->master_id . '__IAACA_' . $form_id_count;
                                $CUE->inspection_and_audit_form_id          = $New_Audit_Form->id;
                                $CUE->incidentAudit_master_id               = $req->master_id;
                                $CUE->url                                   = $PREVENTIVE_ACTIONS_UPLOAD_EVIDENCE_FILE_DB_PATH;
                                $CUE->name                                  = $sign_by_master_FILE_NAME;
                                $CUE->save();
                            } else {
                                $New_Audit_Form->signed_by_auditee_url_name = null;
                                $cue                                        = inspection_and_audit_preventive_upload_evidence::orderBy('auto_inc', 'DESC')->first();
                                if ($cue == null) {
                                    $form_id_count                              = 1;
                                } else {
                                    $form_id_count                              = explode("_", $cue->id)[3] + 1;
                                }
                                $CUE                                        = new inspection_and_audit_preventive_upload_evidence;
                                $CUE->id                                    = $req->master_id . '__IAACA_' . $form_id_count;
                                $CUE->inspection_and_audit_form_id          = $New_Audit_Form->id;
                                $CUE->incidentAudit_master_id               = $req->master_id;
                                $CUE->url                                   = null;
                                $CUE->name                                  = null;
                                $CUE->save();
                            }
                        }
                    }

                    // Saving in the 'inspection_and_audit_corrective_actions' table with the unique id of 'inspection_and_audit_forms'
                    for ($i = 0; $i < count(json_decode($req->corrective_action, true)); $i++) {
                        $inspection_and_audit_corrective_actions = json_decode($req->corrective_action, true);
                        $ca                                      = inspection_and_audit_corrective_actions::orderBy('auto_inc', 'DESC')->first();
                        if ($ca == null) {
                            $form_id_count                           = 1;
                        } else {
                            $form_id_count                           = explode("_", $ca->id)[3] + 1;
                        }
                        if ($inspection_and_audit_corrective_actions[$i] != '') {
                            $CA                                      = new inspection_and_audit_corrective_actions;
                            $CA->id                                  = $req->master_id . '__IAACA_' . $form_id_count;
                            $CA->inspection_and_audit_form_id        = $New_Audit_Form->id;
                            $CA->incidentAudit_master_id             = $req->master_id;
                            $CA->description                         = $inspection_and_audit_corrective_actions[$i];
                            $CA->date_completed                      = $req->c_complete_date;
                            $CA->save();
                        }
                    }

                    // Saving in the 'inspection_and_audit_corrective_upload_evidence' table with the unique id of 'inspection_and_audit_corrective_actions'
                    if (isset($req->c_upload_evidence)) {
                        for ($i = 0; $i < count($req->c_upload_evidence); $i++) {
                            if ($req->c_upload_evidence[$i] != 'undefined') {


                                $CORRECTIVE_ACTIONS_UPLOAD_EVIDENCE_FILE_DB_PATH = (new FileSaver)->saveFile(
                                    $req->master_id . DIRECTORY_SEPARATOR .
                                        config('constants.INSPECTION_AUDIT_MODULE_SUB_FORMS.PSC') . DIRECTORY_SEPARATOR .
                                        $master_primary_key . DIRECTORY_SEPARATOR .
                                        config('constants.INSPECTION_AUDIT_IMAGE_FOLDERS.CORRCTIVE_ACTIONS_UPLOAD_EVIDENCE'),
                                    config('constants.MODULES.INSPECTION_AND_AUDIT'),
                                    $req->file('c_upload_evidence')[$i]
                                );

                                $sign_by_master_FILE_NAME    = $req->file('c_upload_evidence')[$i]->getClientOriginalName();


                                $cue                                        = inspection_and_audit_corrective_upload_evidence::orderBy('auto_inc', 'DESC')->first();
                                if ($cue == null) {
                                    $form_id_count                              = 1;
                                } else {
                                    $form_id_count                              = explode("_", $cue->id)[3] + 1;
                                }
                                $CUE                                        = new inspection_and_audit_corrective_upload_evidence;
                                $CUE->id                                    = $req->master_id . '__IAACA_' . $form_id_count;
                                $CUE->inspection_and_audit_form_id          = $New_Audit_Form->id;
                                $CUE->incidentAudit_master_id               = $req->master_id;
                                $CUE->url                                   = $CORRECTIVE_ACTIONS_UPLOAD_EVIDENCE_FILE_DB_PATH;
                                $CUE->name                                  = $sign_by_master_FILE_NAME;
                                $CUE->save();
                            } else {
                                $New_Audit_Form->signed_by_auditee_url_name = null;
                                $cue                                        = inspection_and_audit_corrective_upload_evidence::orderBy('auto_inc', 'DESC')->first();
                                if ($cue == null) {
                                    $form_id_count                              = 1;
                                } else {
                                    $form_id_count                              = explode("_", $cue->id)[3] + 1;
                                }
                                $CUE                                        = new inspection_and_audit_corrective_upload_evidence;
                                $CUE->id                                    = $req->master_id . '__IAACA_' . $form_id_count;
                                $CUE->inspection_and_audit_form_id          = $New_Audit_Form->id;
                                $CUE->incidentAudit_master_id               = $req->master_id;
                                $CUE->url                                   = null;
                                $CUE->name                                  = null;
                                $CUE->save();
                            }
                        }
                    }

                    $response                                     = [$New_Audit_Form];
                } else {
                    Log::info("Enters inside PSC Edit ..... ||Line:2288");

                    if ($req->major_nc == 'true' || $req->nc == 'true') {
                        if ($req->major_nc == 'true') {
                            $type_of_nc                                   = 'Major N/C';
                        } else {
                            $type_of_nc                                   = 'N/C';
                        }
                    } else {
                        $type_of_nc                                   = 'N/A';
                    }
                    Log::debug($req->edit);
                    $old_audit_form                               = inspection_and_audit_forms::find($req->edit);
                    $old_audit_form->inspection_and_audit_form_id = $req->master_id;
                    $old_audit_form->description                  = $req->description;
                    $old_audit_form->type_of_report               = $req->Type;
                    $old_audit_form->ism_clause                   = $req->ism;
                    $old_audit_form->type_of_nc                   = $type_of_nc;
                    $old_audit_form->due_date                     = $req->due_date;

                    $old_audit_form->signed_by_auditee_name       = $req->sign_master_text;

                    // SAVING NON-CONFIRMITY SIGNED_BY_MASTER/Auditee FILE
                    $old_audit_form->signed_by_auditee_url_name = null;

                    $old_audit_form->signed_by_auditor_name     = $req->sign_auditor_text;
                    // SAVING NON-CONFIRMITY SIGNED_BY_AUDITOR FILE
                    $old_audit_form->signed_by_auditor_url = null;

                    $old_audit_form->accepted_by_name      = $req->accepted;
                    // SAVING NON-CONFIRMITY ACCEPTED_UPLOAD FILE
                    $old_audit_form->accepted_by_url       = null;

                    $old_audit_form->signed_by_master_name = $req->signed;
                    // SAVING NON-CONFIRMITY SIGN_UPLOAD FILE
                    $old_audit_form->signed_by_master_url     = null;

                    $old_audit_form->follow_up_comments       = $req->comments;
                    $old_audit_form->is_confirmed_by_dpa      = $req->comfirm_by_dpa;
                    $old_audit_form->form_date                = $req->date;
                    $old_audit_form->is_verification_required = $req->verification_required;

                    $old_audit_form->psc_ref                  = $req->ref;
                    $old_audit_form->psc_code                 = $req->code;
                    $old_audit_form->save();

                    // PSC => Saving in the 'inspection_and_audit_form_upload_evidence' table with the unique id of 'inspection_and_audit_forms'
                    if (isset($req->upload_document)) {
                        $yo = inspection_and_audit_form_upload_evidence::where('inspection_and_audit_form_id', $old_audit_form->id)
                            ->delete();

                        for ($i  = 0; $i < count($req->upload_document); $i++) {
                            if ($req->upload_document[$i] != 'undefined') {


                                $UPLOAD_EVIDENCE_FILE_DB_PATH = (new FileSaver)->saveFile(
                                    $req->master_id . DIRECTORY_SEPARATOR .
                                        config('constants.INSPECTION_AUDIT_MODULE_SUB_FORMS.PSC') . DIRECTORY_SEPARATOR .
                                        $old_audit_form->id . DIRECTORY_SEPARATOR .
                                        config('constants.INSPECTION_AUDIT_IMAGE_FOLDERS.UPLOAD_EVIDENCE'),
                                    config('constants.MODULES.INSPECTION_AND_AUDIT'),
                                    $req->file('upload_document')[$i]
                                );


                                $sign_by_master_FILE_NAME    = $req->file('upload_document')[$i]->getClientOriginalName();

                                $old_audit_form->signed_by_auditee_url_name = null;
                                $cue                                        = inspection_and_audit_form_upload_evidence::orderBy('auto_inc', 'DESC')->first();
                                if ($cue == null) {
                                    $form_id_count                              = 1;
                                } else {
                                    $form_id_count                              = explode("_", $cue->id)[3] + 1;
                                }
                                $CUE                                        = new inspection_and_audit_form_upload_evidence;
                                $CUE->id                                    = $req->master_id . '__IAACA_' . $form_id_count;
                                $CUE->inspection_and_audit_form_id          = $old_audit_form->id;
                                $CUE->incidentAudit_master_id               = $req->master_id;
                                $CUE->url                                   = $UPLOAD_EVIDENCE_FILE_DB_PATH;
                                $CUE->name                                  = $sign_by_master_FILE_NAME;
                                $CUE->save();
                            } else {
                                $old_audit_form->signed_by_auditee_url_name = null;
                                $cue                                        = inspection_and_audit_form_upload_evidence::orderBy('auto_inc', 'DESC')->first();
                                if ($cue == null) {
                                    $form_id_count                              = 1;
                                } else {
                                    $form_id_count                              = explode("_", $cue->id)[3] + 1;
                                }
                                $CUE                                        = new inspection_and_audit_form_upload_evidence;
                                $CUE->id                                    = $req->master_id . '__IAACA_' . $form_id_count;
                                $CUE->inspection_and_audit_form_id          = $old_audit_form->id;
                                $CUE->incidentAudit_master_id               = $req->master_id;
                                $CUE->url                                   = null;
                                $CUE->name                                  = null;
                                $CUE->save();
                            }
                        }
                    }

                    // PSC => Saving in the 'inspection_and_audit_root_causes' table with the unique id of 'inspection_and_audit_forms'
                    $NMC                              = new NearMissAccidentReporting;
                    $root_causes                      = explode("|", $req->root_cause);
                    if ($root_causes[0] !== '') {
                        $root_causes_first                = explode(",", $root_causes[0]);
                        $del                              = inspection_and_audit_root_causes::where('inspection_and_audit_form_id', $old_audit_form->id)->delete();
                        foreach ($root_causes_first as $root_id) {
                            $rc                               = inspection_and_audit_root_causes::orderBy('auto_inc', 'DESC')->first();
                            if ($rc == null) {
                                $form_id_count                    = 1;
                            } else {
                                $form_id_count                    = explode("_", $rc->id)[3] + 1;
                            }
                            $RC                               = new inspection_and_audit_root_causes;
                            $RC->id                           = $req->master_id . '__IAACA_' . $form_id_count;
                            $RC->inspection_and_audit_form_id = $old_audit_form->id;
                            $RC->incidentAudit_master_id      = $req->master_id;
                            $RC->description                  = $NMC->getmain($root_id);
                            $RC->refrence_id                  = $root_id;
                            $RC->save();
                        }
                    }

                    // PSC => Saving in the 'inspection_and_audit_root_causes_sub' table with the unique id of 'inspection_and_audit_forms'
                    $NMC                              = new NearMissAccidentReporting;
                    $root_causes                      = explode("|", $req->root_cause);
                    if ($root_causes[1] !== '') {

                        $root_causes_second               = explode(",", $root_causes[1]);
                        $del                              = inspection_and_audit_root_causes_sub::where('inspection_and_audit_form_id', $old_audit_form->id)->delete();
                        foreach ($root_causes_second as $root_id) {
                            $rc                               = inspection_and_audit_root_causes_sub::orderBy('auto_inc', 'DESC')->first();
                            if ($rc == null) {
                                $form_id_count                    = 1;
                            } else {
                                $form_id_count                    = explode("_", $rc->id)[3] + 1;
                            }
                            $RC                               = new inspection_and_audit_root_causes_sub;
                            $RC->id                           = $req->master_id . '__IAACA_' . $form_id_count;
                            $RC->inspection_and_audit_form_id = $old_audit_form->id;
                            $RC->incidentAudit_master_id      = $req->master_id;
                            $RC->description                  = $NMC->getsub($root_id);
                            $RC->refrence_id                  = $root_id;
                            $RC->save();
                        }
                    }

                    // PSC => Saving in the 'inspection_and_audit_root_causes_ter' table with the unique id of 'inspection_and_audit_forms'
                    $NMC                              = new NearMissAccidentReporting;
                    $root_causes                      = explode("|", $req->root_cause);
                    if ($root_causes[2] !== '') {
                        $root_causes_second               = explode(",", $root_causes[2]);
                        $del                              = inspection_and_audit_root_causes_ter::where('inspection_and_audit_form_id', $old_audit_form->id)->delete();
                        foreach ($root_causes_second as $root_id) {
                            $rc                               = inspection_and_audit_root_causes_ter::orderBy('auto_inc', 'DESC')->first();
                            if ($rc == null) {
                                $form_id_count                    = 1;
                            } else {
                                $form_id_count                    = explode("_", $rc->id)[3] + 1;
                            }
                            $RC                               = new inspection_and_audit_root_causes_ter;
                            $RC->id                           = $req->master_id . '__IAACA_' . $form_id_count;
                            $RC->inspection_and_audit_form_id = $old_audit_form->id;
                            $RC->incidentAudit_master_id      = $req->master_id;
                            $RC->description                  = $NMC->getter($root_id);
                            $RC->refrence_id                  = $root_id;
                            $RC->save();
                        }
                    }

                    // PSC => Saving in the 'inspection_and_audit_preventive_actions' table with the unique id of 'inspection_and_audit_forms'
                    $NMC                              = new NearMissAccidentReporting;
                    $preventive_aactions              = explode("|", $req->preventive_action);
                    if ($preventive_aactions[0] !== '' &&  $preventive_aactions[0] !== null) {
                        $preventive_aactions_first        = explode(",", $preventive_aactions[0]);
                        $del                              = inspection_and_audit_preventive_actions::where('inspection_and_audit_form_id', $old_audit_form->id)->delete();
                        foreach ($preventive_aactions_first as $preven_id) {
                            if ($preven_id !== 'null') {
                                $pa                               = inspection_and_audit_preventive_actions::orderBy('auto_inc', 'DESC')->first();
                                if ($pa == null) {
                                    $form_id_count                    = 1;
                                } else {
                                    $form_id_count                    = explode("_", $pa->id)[3] + 1;
                                }
                                $PA                               = new inspection_and_audit_preventive_actions;
                                $PA->id                           = $req->master_id . '__IAACA_' . $form_id_count;
                                $PA->inspection_and_audit_form_id = $old_audit_form->id;
                                $PA->incidentAudit_master_id      = $req->master_id;
                                $PA->description                  = $NMC->getmain($preven_id);
                                $PA->refrence_id                  = $preven_id;
                                $PA->date_completed               = $req->p_complete_date;
                                $PA->save();
                            }
                        }
                    }

                    // PSC => Saving in the 'inspection_and_audit_preventive_actions_sub' table with the unique id of 'inspection_and_audit_forms'
                    $NMC                              = new NearMissAccidentReporting;
                    $preventive_aactions              = explode("|", $req->preventive_action);
                    if ($preventive_aactions[0] !== '' && $preventive_aactions[0] !== null) {
                        $preventive_aactions_second       = explode(",", $preventive_aactions[0]);
                        $del                              = inspection_and_audit_preventive_actions_sub::where('inspection_and_audit_form_id', $old_audit_form->id)
                            ->delete();
                        foreach ($preventive_aactions_second as $preven_id) {
                            $pa                               = inspection_and_audit_preventive_actions_sub::orderBy('auto_inc', 'DESC')->first();
                            if ($pa == null) {
                                $form_id_count                    = 1;
                            } else {
                                $form_id_count                    = explode("_", $pa->id)[3] + 1;
                            }
                            $PA                               = new inspection_and_audit_preventive_actions_sub;
                            $PA->id                           = $req->master_id . '__IAACA_' . $form_id_count;
                            $PA->inspection_and_audit_form_id = $old_audit_form->id;
                            $PA->incidentAudit_master_id      = $req->master_id;
                            $PA->description                  = $NMC->getsub($preven_id);
                            $PA->refrence_id                  = $preven_id;
                            $PA->date_completed               = $req->p_complete_date;
                            $PA->save();
                        }
                    }

                    // PSC => Saving in the 'inspection_and_audit_preventive_upload_evidence' table with the unique id of 'inspection_and_audit_preventive_actions'
                    if (isset($req->p_upload_evidence)) {
                        $del = inspection_and_audit_preventive_upload_evidence::where('inspection_and_audit_form_id', $old_audit_form->id)
                            ->delete();
                        for ($i   = 0; $i < count($req->p_upload_evidence); $i++) {
                            if ($req->p_upload_evidence[$i] != 'undefined') {

                                $PREVENTIVE_ACTION_UPLOAD_EVIDENCE_FILE_DB_PATH = (new FileSaver)->saveFile(
                                    $req->master_id . DIRECTORY_SEPARATOR .
                                        config('constants.INSPECTION_AUDIT_MODULE_SUB_FORMS.PSC') . DIRECTORY_SEPARATOR .
                                        $old_audit_form->id . DIRECTORY_SEPARATOR .
                                        config('constants.INSPECTION_AUDIT_IMAGE_FOLDERS.PREVENTIVE_ACTIONS_UPLOAD_EVIDENCE'),
                                    config('constants.MODULES.INSPECTION_AND_AUDIT'),
                                    $req->file('p_upload_evidence')[$i]
                                );


                                $sign_by_master_FILE_NAME    = $req->file('p_upload_evidence')[$i]->getClientOriginalName();

                                $cue                                        = inspection_and_audit_preventive_upload_evidence::orderBy('auto_inc', 'DESC')->first();
                                if ($cue == null) {
                                    $form_id_count                              = 1;
                                } else {
                                    $form_id_count                              = explode("_", $cue->id)[3] + 1;
                                }
                                $CUE                                        = new inspection_and_audit_preventive_upload_evidence;
                                $CUE->id                                    = $req->master_id . '__IAACA_' . $form_id_count;
                                $CUE->inspection_and_audit_form_id          = $old_audit_form->id;
                                $CUE->incidentAudit_master_id               = $req->master_id;
                                $CUE->url                                   = $sign_by_master_FILE_DB_PATH;
                                $CUE->name                                  = $sign_by_master_FILE_NAME;
                                $CUE->save();
                            } else {
                                $old_audit_form->signed_by_auditee_url_name = null;
                                $cue                                        = inspection_and_audit_preventive_upload_evidence::orderBy('auto_inc', 'DESC')->first();
                                if ($cue == null) {
                                    $form_id_count                              = 1;
                                } else {
                                    $form_id_count                              = explode("_", $cue->id)[3] + 1;
                                }
                                $CUE                                        = new inspection_and_audit_preventive_upload_evidence;
                                $CUE->id                                    = $req->master_id . '__IAACA_' . $form_id_count;
                                $CUE->inspection_and_audit_form_id          = $old_audit_form->id;
                                $CUE->incidentAudit_master_id               = $req->master_id;
                                $CUE->url                                   = null;
                                $CUE->name                                  = null;
                                $CUE->save();
                            }
                        }
                    }

                    // PSC => Saving in the 'inspection_and_audit_corrective_actions' table with the unique id of 'inspection_and_audit_forms'
                    $inspection_and_audit_corrective_actions = json_decode($req->corrective_action, true);
                    foreach ($inspection_and_audit_corrective_actions as $key => $value) {
                        # code...
                        if ($value != '') {
                            inspection_and_audit_corrective_actions::where('inspection_and_audit_form_id', $old_audit_form->id)
                                ->delete();
                        }
                    }
                    for ($i   = 0; $i < count(json_decode($req->corrective_action, true)); $i++) {
                        $inspection_and_audit_corrective_actions = json_decode($req->corrective_action, true);
                        $ca                                      = inspection_and_audit_corrective_actions::orderBy('auto_inc', 'DESC')->first();
                        if ($ca == null) {
                            $form_id_count                           = 1;
                        } else {
                            $form_id_count                           = explode("_", $ca->id)[3] + 1;
                        }
                        if ($inspection_and_audit_corrective_actions[$i] != '') {
                            $CA                                      = new inspection_and_audit_corrective_actions;
                            $CA->id                                  = $req->master_id . '__IAACA_' . $form_id_count;
                            $CA->inspection_and_audit_form_id        = $old_audit_form->id;
                            $CA->incidentAudit_master_id             = $req->master_id;
                            $CA->description                         = $inspection_and_audit_corrective_actions[$i];
                            $CA->date_completed                      = $req->c_complete_date;
                            $CA->save();
                        }
                    }

                    // PSC => Saving in the 'inspection_and_audit_corrective_upload_evidence' table with the unique id of 'inspection_and_audit_corrective_actions'
                    if (isset($req->c_upload_evidence)) {
                        $del = inspection_and_audit_corrective_upload_evidence::where('inspection_and_audit_form_id', $old_audit_form->id)
                            ->delete();
                        for ($i   = 0; $i < count($req->c_upload_evidence); $i++) {
                            if ($req->c_upload_evidence[$i] != 'undefined') {


                                $sign_by_master_FILE_DB_PATH = (new FileSaver)->saveFile(
                                    $req->master_id . DIRECTORY_SEPARATOR .
                                        config('constants.INSPECTION_AUDIT_MODULE_SUB_FORMS.PSC') . DIRECTORY_SEPARATOR .
                                        $old_audit_form->id . DIRECTORY_SEPARATOR .
                                        config('constants.INSPECTION_AUDIT_IMAGE_FOLDERS.CORRCTIVE_ACTIONS_UPLOAD_EVIDENCE'),
                                    config('constants.MODULES.INSPECTION_AND_AUDIT'),
                                    $req->file('c_upload_evidence')[$i]
                                );


                                $sign_by_master_FILE_NAME    = $req->file('c_upload_evidence')[$i]->getClientOriginalName();

                                $cue                                        = inspection_and_audit_corrective_upload_evidence::orderBy('auto_inc', 'DESC')->first();
                                if ($cue == null) {
                                    $form_id_count                              = 1;
                                } else {
                                    $form_id_count                              = explode("_", $cue->id)[3] + 1;
                                }
                                $CUE                                        = new inspection_and_audit_corrective_upload_evidence;
                                $CUE->id                                    = $req->master_id . '__IAACA_' . $form_id_count;
                                $CUE->inspection_and_audit_form_id          = $old_audit_form->id;
                                $CUE->incidentAudit_master_id               = $req->master_id;
                                $CUE->url                                   = $sign_by_master_FILE_DB_PATH;
                                $CUE->name                                  = $sign_by_master_FILE_NAME;
                                $CUE->save();
                            } else {
                                $old_audit_form->signed_by_auditee_url_name = null;
                                $cue                                        = inspection_and_audit_corrective_upload_evidence::orderBy('auto_inc', 'DESC')->first();
                                if ($cue == null) {
                                    $form_id_count                              = 1;
                                } else {
                                    $form_id_count                              = explode("_", $cue->id)[3] + 1;
                                }
                                $CUE                                        = new inspection_and_audit_corrective_upload_evidence;
                                $CUE->id                                    = $req->master_id . '__IAACA_' . $form_id_count;
                                $CUE->inspection_and_audit_form_id          = $old_audit_form->id;
                                $CUE->incidentAudit_master_id               = $req->master_id;
                                $CUE->url                                   = null;
                                $CUE->name                                  = null;
                                $CUE->save();
                            }
                        }
                    }

                    $response = [$old_audit_form];
                }
            }
        }

        return $response;
    }

    /* 🎈 API FUNCTION => SEND PREFILL DATA FOR FORM  */
    public function Prefill(Request $request)
    {

        $data = array();
        if ($request->step == 1) {
            $data = $this->FetchMasterDataById($request->id);
        }
        if ($request->step == 2) {
            $data = $this->FetchMasterFormDataById($request->id);
        }
        if ($request->step == 3) {
        }
        return response()
            ->json($data, 201);
    }

    /* 🎈 API FUNCTION => SEND PREFILL DATA FOR FORM  */
    public function EditPrefill(Request $request)
    {

        $data = array();
        $data = inspection_and_audit_forms::where('inspection_and_audit_form_id', $request->id)
            ->get();

        return response()
            ->json($data, 201);
    }

    // 🎈 API FUNCTION => RETURN ROOT CAUSES DATA
    public function sendRootCauses(Request $req)
    {
        $id    = $req->id;
        $query = array();
        $query['first']       = DB::table('inspection_and_audit_root_causes')->where('inspection_and_audit_form_id', $id)->get();
        $query['second']       = DB::table('inspection_and_audit_root_causes_sub')->where('inspection_and_audit_form_id', $id)->get();
        $query['third']       = DB::table('inspection_and_audit_root_causes_ter')->where('inspection_and_audit_form_id', $id)->get();
        return response()
            ->json($query, 201);
    }

    // 🎈 API FUNCTION => RETURN PREVENTIVE ACTIONS DATA
    public function sendpreventiveaction(Request $req)
    {
        $id    = $req->id;
        $query = array();
        $query['first']       = DB::table('inspection_and_audit_preventive_actions')->where('inspection_and_audit_form_id', $id)->get();
        $query['second']       = DB::table('inspection_and_audit_preventive_actions_sub')->where('inspection_and_audit_form_id', $id)->get();
        return response()
            ->json($query, 201);
    }

    // 🎈 API FUNCTION => RETURN PREVENTIVE ACTIONS Files
    public function sendpreventiveactionFiles(Request $req)
    {
        $id    = $req->id;
        $query = DB::table('inspection_and_audit_preventive_upload_evidence')->where('inspection_and_audit_form_id', $id)->get();
        return response()
            ->json($query, 201);
    }

    // 🎈 API FUNCTION => RETURN ROOT CAUSES DATA
    public function sendcorrectiveaction(Request $req)
    {
        $id    = $req->id;
        $query = DB::table('inspection_and_audit_corrective_actions')->where('inspection_and_audit_form_id', $id)->get();
        return response()
            ->json($query, 201);
    }

    // 🎈 API FUNCTION => RETURN CORRECTIVE ACTIONS Files
    public function sendcorrectiveactionFiles(Request $req)
    {
        $id    = $req->id;
        $query = DB::table('inspection_and_audit_corrective_upload_evidence')->where('inspection_and_audit_form_id', $id)->get();
        return response()
            ->json($query, 201);
    }

    // 🎈 API FUNCTION => RETURN FORM UPLOAD EVIDENCE Files
    public function sendEvidencePSC(Request $req)
    {
        $id    = $req->id;
        $query = DB::table('inspection_and_audit_form_upload_evidence')->where('inspection_and_audit_form_id', $id)->get();
        return response()->json($query, 201);
    }

    // 🎈 API FUNCTION => DELETE FORM DATA Files
    public function deleteFormData(Request $req)
    {
        $id = $req->id;

        // delete form data 😎
        DB::table('inspection_and_audit_forms')
            ->where('id', $id)->delete();

        // form upload evodence delete 😣
        DB::table('inspection_and_audit_form_upload_evidence')->where('inspection_and_audit_form_id', $id)->delete();

        // corrective action data and upload evidence delete 😣
        DB::table('inspection_and_audit_corrective_actions')->where('inspection_and_audit_form_id', $id)->delete();
        DB::table('inspection_and_audit_corrective_upload_evidence')->where('inspection_and_audit_form_id', $id)->delete();

        // preventive actions data and uplod evidence  delete 😣
        DB::table('inspection_and_audit_preventive_actions')->where('inspection_and_audit_form_id', $id)->delete();
        DB::table('inspection_and_audit_preventive_actions_sub')->where('inspection_and_audit_form_id', $id)->delete();
        DB::table('inspection_and_audit_preventive_upload_evidence')->where('inspection_and_audit_form_id', $id)->delete();

        // Root Causes data  delete 😣
        DB::table('inspection_and_audit_root_causes')->where('inspection_and_audit_form_id', $id)->delete();
        DB::table('inspection_and_audit_root_causes_sub')->where('inspection_and_audit_form_id', $id)->delete();
        DB::table('inspection_and_audit_root_causes_ter')->where('inspection_and_audit_form_id', $id)->delete();

        return response()
            ->json(true, 201);
    }

    // 🎈 API FUNCTION => FETCH PERTICULAR FORM DATA
    public function GetFormDataByID(Request $r)
    {
        $id   = $r->id;
        $data = array();
        $FRM  = new inspection_and_audit_forms;
        $data['frm_data']      = $FRM::where('id', '=', $id)->get()
            ->first();
        $data['root_causes']      = inspection_and_audit_root_causes::where('inspection_and_audit_form_id', '=', $id)->get();

        return $data;
    }

    // 🎈 API FUNCTION => DELETE FORM DATA Files
    public function ChangeStatus(Request $req)
    {
        $id             = $req->id;
        //$status         = auditmodel::where('id', $id)->get()->first();
        $audit         = auditmodel::find($id);
        if ($audit) {
            $audit->status = config('constants.status.Submitted');
            $audit->save();
        }


        return true;
    }


    // 🎈 API FUNCTION => to Delete inspection-and-audit sub-forms on onchange of 'Type of Audit' .....
    function delete_sub_forms_on_input_change (Request $req){
        try {
            Log::debug($req->form_type);
            if($req->form_type == 'PSC'){
                Log::debug("PSC .....");
                $this->delete_sub_forms_by_form_type('Non Confirmity',$req->master_id);
                $this->delete_sub_forms_by_form_type('Observation',$req->master_id);
            }else{
                Log::debug("others.....");
                $this->delete_sub_forms_by_form_type('PSC',$req->master_id);
            }
        } catch (Exception $e) { Log::error("delete_sub_forms_on_input_change Function => ".$e);}
    }




    /*
        HELPER FUNCTIONS
        #############################
    */

    /* 🤝🏻 HELPER FUNCTION => GENERATE UNIQUE ID FOR AUDIT MASTER */
    function GenerateID($ship)
    {
        if ($ship !== false) {
            $shipPrefix = $ship->prefix;
            $creator    = $ship->unique_id;
        } else {
            $shipPrefix = '';
            $creator    = '';
        }

        $NMcount    = DB::table('inspection_and_audit_master')->where('creator_id', $ship->unique_id)
            ->orderBy('auto_inc', 'DESC')
            ->first();
        if ($NMcount !== null) {
            $lastID     = explode("-", $NMcount->id);
            $prevInc    = (int)$lastID[2];
            $inc        = $prevInc + 1;
        } else {
            $inc        = 1;
        }
        $id         = $shipPrefix . '-incidentaudit-' . (string)$inc;
        // $id = (new GenericController)->getUniqueId('inspection_and_audit_master',config('constants.UNIQUE_ID_TEXT.INSPECTION_AND_AUDIT'));
        return $id;
    }

    /* 🤝🏻 HELPER FUNCTION => DELETE LAST DEAFT DATA ON DATABASE AND CREATE A NEW DRAFT */
    function DeleteAndCreateNewDraft()
    {
        $ship = (new GenericController)->getCreatorId();
        if ($ship) {
            // DELETE LAST DRAFT DATA
            $is_last_draft_deleted = $this->DeleteLastDataDraft(session('creator_id'));
            // CREATE NEW DRAFT
            if($is_last_draft_deleted){$this->CreateNewDraft();}
            return true;
        } else {
            return false;
        }
    }

    /* 🤝🏻 HELPER FUNCTION => CREATING A DRAFT INTO DB */
    function CreateNewDraft()
    {

        // CREATE MASTER TABLE DRAFT
        $ship                     = (new GenericController)->getCreatorId();
        if ($ship) {
            // $ship                     = $Vessel_detailsController->getVesselId();
            $id                       = $this->GenerateID($ship);

            $Nweaudit                 = new auditmodel;
            $Nweaudit->id             = $id;
            $Nweaudit->vessel_id      = $ship->unique_id;
            $Nweaudit->status         = config('constants.status.Draft');
            $Nweaudit->creator_id     = session('creator_id');
            $Nweaudit->save();

            return $Nweaudit->id;
        }
    }

    /* 🤝🏻 HELPER FUNCTION => DELETE LAST INSERTED DRAFT DATA */
    function DeleteLastDataDraft($creator)
    {
        $master      = auditmodel::where('creator_id', $creator)->orderBy('auto_inc', 'DESC')->first();
        $masterCount = auditmodel::where('creator_id', $creator)->count();
        if ($masterCount != 0) {
            if ($master->status == config('constants.status.Draft')) {
                // STORE MASTER ID
                $master_id   = $master->id;
                // DELETE DATA
                $is_deleted  = $this->DeleteById($master_id);

                if ($is_deleted) {
                    return true;
                } else {
                    return false;
                };
            } else {
                return false;
            }
        }
    }

    /* 🤝🏻 HELPER FUNCTION => GETTING PSC DATA BY ID FOR DATA TABLES */
    public function getPSCFormDiv($id, $post)
    {
        try {
            $div  = "<!-- Button trigger modal -->
                        <div class='d-flex'>
                            <div class='containertooltip'>" . $id . " PSC
                            </div>

                        </div>

                        <!-- Modal -->
                        <div class='modal fade' id='inspect_audit_PSC_'.$id.'' tabindex='-1' role='dialog' aria-labelledby='exampleModalLongTitle' aria-hidden='true'>
                                <div class='modal-dialog modal-lg' role='document'>
                                    <div class='modal-content'>
                                        <div class='modal-header'>
                                            <h2 class='modal-title font-weight-bold' id='exampleModalLongTitle'>PCB Report</h2> <h5>Vessel Id : $post->vessel_id </h5>
                                        </div>
                                        <div class='modal-body text-left'>

                                            <div class='row'>
                                                " . $this->col('3', '12', $this->getData($id, 'PSC', 'Name of inspector'), 'Name of inspector') . "
                                                " . $this->col('3', '12', $this->getData($id, 'PSC', 'Description'), 'Description') . "
                                                " . $this->col('3', '12', $this->getData($id, 'PSC', 'Ref'), 'Ref') . "
                                                " . $this->col('3', '12', $this->getData($id, 'PSC', 'Code'), 'Code') . "
                                                " . $this->col('3', '12', $this->getData($id, 'PSC', 'Corrective Action'), 'Corrective Action') . "
                                                " . $this->col('3', '12', $this->getData($id, 'PSC', 'Date'), 'Date') . "
                                                " . $this->col('3', '12', $this->getData($id, 'PSC', 'Preventive Action'), 'Preventive Action') . "

                                            </div>
                                            <div class='modal-footer'>
                                                <button type='button' class='btn btn-danger text-white  -close' data-dismiss='modal'><i class='far fa-times-circle mr-1'></i>Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        </div>";
            return $div;
        } catch (Exception $e) {
            report($e);
        }
    }

    /* 🤝🏻 HELPER FUNCTION => DELETE DATA BY ID */
    function DeleteById($id)
    {

        // DELETE inspection_and_audit_form_upload_evidence
        DB::table('inspection_and_audit_form_upload_evidence')->where('incidentAudit_master_id', '' . $id . '')->delete();
        // DELETE inspection_and_audit_corrective_upload_evidence
        DB::table('inspection_and_audit_corrective_upload_evidence')
            ->where('incidentAudit_master_id', '' . $id . '')->delete();
        // DELETE inspection_and_audit_preventive_upload_evidence
        DB::table('inspection_and_audit_preventive_upload_evidence')
            ->where('incidentAudit_master_id', '' . $id . '')->delete();
        // DELETE inspection_and_audit_forms
        DB::table('inspection_and_audit_forms')
            ->where('inspection_and_audit_form_id', '' . $id . '')->delete();
        // DELETE inspection_and_audit_root_causes
        DB::table('inspection_and_audit_root_causes')
            ->where('incidentAudit_master_id', '' . $id . '')->delete();
        DB::table('inspection_and_audit_root_causes_sub')
            ->where('incidentAudit_master_id', '' . $id . '')->delete();
        DB::table('inspection_and_audit_root_causes_ter')
            ->where('incidentAudit_master_id', '' . $id . '')->delete();
        // DELETE inspection_and_audit_preventive_actions
        DB::table('inspection_and_audit_preventive_actions')
            ->where('incidentAudit_master_id', '' . $id . '')->delete();
        DB::table('inspection_and_audit_preventive_actions_sub')
            ->where('incidentAudit_master_id', '' . $id . '')->delete();
        // DELETE inspection_and_audit_preventive_actions
        DB::table('inspection_and_audit_corrective_actions')
            ->where('incidentAudit_master_id', '' . $id . '')->delete();
        // DELETE inspection_and_audit_master
        DB::table('inspection_and_audit_master')
            ->where('id', '' . $id . '')->delete();

        return true;
    }

    /* 🤝🏻 HELPER FUNCTION => FETCH LAST INSERTED DRAFT DATA IF THAT DATA IS DRAFTED */
    function FetchingLastDraftData_If_Drafted($creator)
    {
        $master = DB::table('inspection_and_audit_master')->where('creator_id', $creator)->latest()
            ->first();
        if (empty($master)) {
            return ['data'         => null, 'is_last_a_draft'         => false];
        } else {
            if ($master->status == config('constants.status.Draft')) {
                $IA_data = DB::table('inspection_and_audit_master')->where('creator_id', $creator);

                //  GATHER INSPECTION AND AUDIT FORMS DATA GATHER
                $IA_data = $IA_data->leftJoin('inspection_and_audit_forms', 'inspection_and_audit_master.id', '=', 'inspection_and_audit_forms.inspection_and_audit_form_id')
                    ->LeftJoin('inspection_and_audit_form_upload_evidence', 'inspection_and_audit_forms.id', '=', 'inspection_and_audit_form_upload_evidence.inspection_and_audit_form_id')
                    ->leftJoin('inspection_and_audit_root_causes', 'inspection_and_audit_forms.inspection_and_audit_form_id', '=', 'inspection_and_audit_root_causes.inspection_and_audit_form_id')
                    ->leftJoin('inspection_and_audit_corrective_actions', 'inspection_and_audit_forms.inspection_and_audit_form_id', '=', 'inspection_and_audit_corrective_actions.inspection_and_audit_form_id')

                    ->leftJoin('inspection_and_audit_preventive_actions', 'inspection_and_audit_forms.inspection_and_audit_form_id', '=', 'inspection_and_audit_preventive_actions.inspection_and_audit_form_id');

                $IA_data = $IA_data->leftJoin('inspection_and_audit_corrective_upload_evidence', 'inspection_and_audit_corrective_actions.id', '=', 'inspection_and_audit_corrective_upload_evidence.inspection_and_audit_form_id');
                // $IA_data = $IA_data->leftJoin(
                //     'inspection_and_audit_preventive_upload_evidence',
                //     'inspection_and_audit_preventive_actions.id',
                //     '=',
                //     'inspection_and_audit_preventive_upload_evidence.inspection_and_audit_preventive_id'
                // );
                $data    = $IA_data->select(
                    'inspection_and_audit_master.*',
                    'inspection_and_audit_forms.id as form_id',
                    'inspection_and_audit_forms.name_of_auditor',
                    'inspection_and_audit_forms.description',
                    'inspection_and_audit_forms.type_of_report',
                    'inspection_and_audit_forms.ism_clause',
                    'inspection_and_audit_forms.type_of_nc',
                    'inspection_and_audit_forms.due_date',
                    'inspection_and_audit_forms.accepted_by_name',
                    'inspection_and_audit_forms.accepted_by_url',
                    'inspection_and_audit_forms.follow_up_comments',
                    'inspection_and_audit_forms.is_confirmed_by_dpa',
                    'inspection_and_audit_forms.form_date',
                    'inspection_and_audit_forms.is_verification_required',
                    'inspection_and_audit_forms.psc_ref',
                    'inspection_and_audit_forms.psc_code',
                    'inspection_and_audit_form_upload_evidence.id as upload_evidence_id',
                    'inspection_and_audit_form_upload_evidence.url as upload_evidence_url',
                    'inspection_and_audit_form_upload_evidence.name as upload_evidence_name',
                    'inspection_and_audit_root_causes.id as root_cause_id',
                    'inspection_and_audit_root_causes.description as root_cause_description',
                    'inspection_and_audit_corrective_actions.id as corrective_actions_id',
                    'inspection_and_audit_corrective_actions.description as corrective_actions_description',
                    'inspection_and_audit_corrective_actions.date_completed as corrective_actions_date_completed ',
                    'inspection_and_audit_preventive_actions.id as preventive_actions_id',
                    'inspection_and_audit_preventive_actions.description as preventive_actions_description',
                    'inspection_and_audit_preventive_actions.date_completed as preventive_actions_date_completed',
                    'inspection_and_audit_corrective_upload_evidence.id as corrective_upload_evidence_id',
                    'inspection_and_audit_corrective_upload_evidence.url as corrective_upload_evidence_url',
                    'inspection_and_audit_corrective_upload_evidence.name as corrective_upload_evidence_name'
                    // 'inspection_and_audit_preventive_upload_evidence.id as preventive_upload_evidence_id',
                    // 'inspection_and_audit_preventive_upload_evidence.url as preventive_upload_evidence_url',
                    // 'inspection_and_audit_preventive_upload_evidence.name as preventive_upload_evidence_name '
                )
                    ->latest()
                    ->first();

                return ["data" => $data, "is_last_a_draft" => true];
            } else {
                return ['data'      => null, 'is_last_a_draft'      => false];
            }
        }
    }

    /* 🤝🏻 HELPER FUNCTION => ADD BOOTSTRAP GRID COLUMN */
    public function col($md, $col, $content, $heading)
    {
        $cont = "
                    <div class='col-$col col-md-$md'>
                        <h6 class='font-weight-bold'>$heading </h6> ";
        if (is_array($content)) {
            if (count($content) <= 0) {
                $cont .= "N/A";
            } else {
                $cont .= " <ol>";
                foreach ($content as $c) {
                    if ($c != '') {
                        $cont .= "<li class=''> $c </li>";
                    }
                }
                $cont .= "</ol>";
            }
        } else {
            if ($content != '') {

                $cont .= "<h6>" . $content . " </h6> ";
            } else {
                $cont .= "<h6> N/A </h6> ";
            }
        }
        $cont .= " </div>";

        return $cont;
    }

    /* 🤝🏻 HELPER FUNCTION => SAVE IMAGES FOR 2ND STEP */
    public function SaveImg($file, $path, $filename)
    {
        $file->move($path, $filename);
        return true;
    }

    /* 🤝🏻 HELPER FUNCTION => FETCH DATA BY ID FROM MAIN TABLE */
    public function FetchMasterDataById($id)
    {
        $query = DB::table('inspection_and_audit_master')->where('id', $id)->get()
            ->first();
        return $query;
    }

    /* 🤝🏻 HELPER FUNCTION => FETCH DATA BY ID FROM MAIN TABLE */
    public function FetchMasterFormDataById($id)
    {
        $forms = DB::table('inspection_and_audit_forms')->where('inspection_and_audit_form_id', $id)->get();
        return $forms;
    }

    /* 🤝🏻 HELPER FUNCTION => FETCH PERTICULAR FORM DATA */
    public function getFormData($id, $type)
    {
        try {
            if ($type == 'PSC') {
                $formData   = inspection_and_audit_forms::where('id', 'like', $id)->select('name_of_auditor', 'description', 'psc_ref', 'psc_code')
                    ->get();

                $corrective = inspection_and_audit_corrective_actions::where('id', 'like', $id)->select('description', 'date_completed')
                    ->get();

                $preventive = inspection_and_audit_corrective_actions::where('id', 'like', $id)->select('description')
                    ->get();

                $data       = [$formData, $corrective, $preventive];
                // if($forr == 'Name of inspector'){
                //     //$data = DB::table('inspection_and_audit_forms')->where('id',$id)->value('name_of_auditor');
                // }
                // elseif($forr == 'Description'){
                //     $data = DB::table('inspection_and_audit_forms')->value('description');
                // }
                // elseif($forr == 'Ref'){
                //     $data = DB::table('inspection_and_audit_forms')->where('id',$id)->value('psc_ref');
                // }
                // elseif($forr == 'Code'){
                //     $data = DB::table('inspection_and_audit_forms')->where('id',$id)->value('psc_code');
                // }
                // elseif($forr == 'Corrective Action'){
                //     $id = substr($id,0,21).'__IAACA';
                //     $data = DB::table('inspection_and_audit_corrective_actions')->where('id',$id)->value('description');
                // }
                // elseif($forr == 'Date'){
                //     $id = substr($id,0,21).'__IAACA';
                //     $data = DB::table('inspection_and_audit_corrective_actions')->where('id',$id)->value('date_completed');
                // }
                // elseif($forr == 'Preventive Action'){
                //     $id = substr($id,0,21).'__IAAPA';
                //     $data = DB::table('inspection_and_audit_preventive_actions')->where('id',$id)->value('description');
                // }

            } elseif ($type == 'Observation') {
                if ($forr == 'Name of inspector') {
                    $data       = DB::table('inspection_and_audit_forms')->where('id', $id)->value('name_of_auditor');
                } elseif ($forr == 'Description') {
                    $data       = DB::table('inspection_and_audit_forms')->where('id', $id)->value('description');
                } elseif ($forr == 'Ref') {
                    $data       = DB::table('inspection_and_audit_forms')->where('id', $id)->value('psc_ref');
                } elseif ($forr == 'Code') {
                    $data       = DB::table('inspection_and_audit_forms')->where('id', $id)->value('psc_code');
                } elseif ($forr == 'Corrective Action') {
                    $id         = substr($id, 0, 21) . '__IAACA';
                    $data       = DB::table('inspection_and_audit_corrective_actions')->where('id', $id)->value('description');
                } elseif ($forr == 'Date') {
                    $id         = substr($id, 0, 21) . '__IAACA';
                    $data       = DB::table('inspection_and_audit_corrective_actions')->where('id', $id)->value('date_completed');
                } elseif ($forr == 'Preventive Action') {
                    $id         = substr($id, 0, 21) . '__IAAPA';
                    $data       = DB::table('inspection_and_audit_preventive_actions')->where('id', $id)->value('description');
                }
            } elseif ($type == 'Non_confirmitry') {
                $formData   = inspection_and_audit_forms::where('id', 'like', $id)
                    // ->where('inspection_and_audit_form_id','like','mrysh-incidentaudit-2')
                    ->select('name_of_auditor', 'description', 'ism_clause', 'due_date')
                    ->get();

                $corrective = inspection_and_audit_corrective_actions::where('id', 'like', $id)->select('description', 'date_completed')->get();

                $data  = [$formData, $corrective];
            }
            if ($data == NULL) {
                $data       = config('constants.DATA_NOT_AVAILABLE');
            }
            return $data;
        } catch (Exception $e) {
            report($e);
        }
    }

    // 🤝🏻 HELPER FUNCTION FOR GETING PSC / OBSERVATION AND NON-CONFIRMITY
    public function getData($id, $type, $forr)
    {

        if ($type == 'PSC') {
            if ($forr == 'Name of inspector') {
                $data = DB::table('inspection_and_audit_forms')->where('id', $id)->value('name_of_auditor');
            } elseif ($forr == 'Description') {
                $data = DB::table('inspection_and_audit_forms')->value('description');
            } elseif ($forr == 'Ref') {
                $data = DB::table('inspection_and_audit_forms')->where('id', $id)->value('psc_ref');
            } elseif ($forr == 'Code') {
                $data = DB::table('inspection_and_audit_forms')->where('id', $id)->value('psc_code');
            } elseif ($forr == 'Corrective Action') {
                $id   = substr($id, 0, 21) . '__IAACA';
                $data = DB::table('inspection_and_audit_corrective_actions')->where('id', $id)->value('description');
            } elseif ($forr == 'Date') {
                $id   = substr($id, 0, 21) . '__IAACA';
                $data = DB::table('inspection_and_audit_corrective_actions')->where('id', $id)->value('date_completed');
            } elseif ($forr == 'Preventive Action') {
                $id   = substr($id, 0, 21) . '__IAAPA';
                $data = DB::table('inspection_and_audit_preventive_actions')->where('id', $id)->value('description');
            }
        } elseif ($type == 'Observation') {
            if ($forr == 'Name of inspector') {
                $data = DB::table('inspection_and_audit_forms')->where('id', $id)->value('name_of_auditor');
            } elseif ($forr == 'Description') {
                $data = DB::table('inspection_and_audit_forms')->where('id', $id)->value('description');
            } elseif ($forr == 'Ref') {
                $data = DB::table('inspection_and_audit_forms')->where('id', $id)->value('psc_ref');
            } elseif ($forr == 'Code') {
                $data = DB::table('inspection_and_audit_forms')->where('id', $id)->value('psc_code');
            } elseif ($forr == 'Corrective Action') {
                $id   = substr($id, 0, 21) . '__IAACA';
                $data = DB::table('inspection_and_audit_corrective_actions')->where('id', $id)->value('description');
            } elseif ($forr == 'Date') {
                $id   = substr($id, 0, 21) . '__IAACA';
                $data = DB::table('inspection_and_audit_corrective_actions')->where('id', $id)->value('date_completed');
            } elseif ($forr == 'Preventive Action') {
                $id   = substr($id, 0, 21) . '__IAAPA';
                $data = DB::table('inspection_and_audit_preventive_actions')->where('id', $id)->value('description');
            }
        } elseif ($type == 'Non_confirmitry') {
            if ($forr == 'Name of Auditor') {
                $data = DB::table('inspection_and_audit_forms')->where('id', $id)->value('name_of_auditor');
            } elseif ($forr == 'Description') {
                $data = DB::table('inspection_and_audit_forms')->where('id', 'like', $id)->where('inspection_and_audit_form_id', 'like', 'mrysh-incidentaudit-2')
                    ->value('description');
            } elseif ($forr == 'ISM clause or there Ref') {
                $data = DB::table('inspection_and_audit_forms')->where('id', $id)->value('ism_clause');
            } elseif ($forr == 'Due Date') {
                $data = DB::table('inspection_and_audit_forms')->where('id', $id)->value('due_date');
            } elseif ($forr == 'Corrective Action') {
                $id   = substr($id, 0, 21) . '__IAACA';
                $data = DB::table('inspection_and_audit_corrective_actions')->where('id', $id)->value('description');
            } elseif ($forr == 'Date Complete') {
                $id   = substr($id, 0, 21) . '__IAACA';
                $data = DB::table('inspection_and_audit_corrective_actions')->where('id', $id)->value('date_completed');
            }
        }
        if ($data == NULL) {
            $data = config('constants.DATA_NOT_AVAILABLE');
        }

        return $data;
    }
    // 🤝🏻 HELPER FUNCTION FOR DELETE SUB-FORMS BY CATEGORY (Non Confirmity , OBSERVATION , PSC) .....
    public function delete_sub_forms_by_form_type($form_type_to_delete,$master_id){

        Log::debug($form_type_to_delete);
        Log::debug($master_id);

        $forms_list = DB::table('inspection_and_audit_forms')->where('type_of_report',$form_type_to_delete)->where('inspection_and_audit_form_id', $master_id);

        Log::debug($forms_list->get());
        if(count($forms_list->get()) > 0 ){
            // 👬 Deleting all relational data inside other tables with sub-form .....
            foreach ($forms_list->get() as $form) {
                DB::table('inspection_and_audit_corrective_actions')->where('inspection_and_audit_form_id',$form->id)->delete();
                DB::table('inspection_and_audit_corrective_upload_evidence')->where('inspection_and_audit_form_id',$form->id)->delete();
                DB::table('inspection_and_audit_form_upload_evidence')->where('inspection_and_audit_form_id',$form->id)->delete();
                DB::table('inspection_and_audit_preventive_actions')->where('inspection_and_audit_form_id',$form->id)->delete();
                DB::table('inspection_and_audit_preventive_actions_sub')->where('inspection_and_audit_form_id',$form->id)->delete();
                DB::table('inspection_and_audit_preventive_upload_evidence')->where('inspection_and_audit_form_id',$form->id)->delete();
                DB::table('inspection_and_audit_root_causes')->where('inspection_and_audit_form_id',$form->id)->delete();
                DB::table('inspection_and_audit_root_causes_sub')->where('inspection_and_audit_form_id',$form->id)->delete();
                DB::table('inspection_and_audit_root_causes_ter')->where('inspection_and_audit_form_id',$form->id)->delete();
            }

            // deleting all sub-forms .....
            $forms_list->delete();
        }

    }
}
