<?php

/**
 * Class and Function List:
 * Function list:
 * - getmain()
 * - getsub()
 * - getter()
 * - RetVal()
 * - index()
 * - create()
 * - store()
 * - edit()
 * - update()
 * - destroy()
 * - printPDF_incident()
 * - printPDFAll_incident()
 * - crewFinder()
 * - Seacher()
 * - FilterStatus()
 * - col()
 * - getincidents()
 * - saveInvestigationMatrix()
 * - saveIncidentHeader()
 * - saveIncidentReportDetails()
 * - saveIncidentCrewInjury()
 * - saveIncidentBrief()
 * - saveEventInformation()
 * - saveEventLog()
 * - saveRootCauseFindings()
 * Classes list:
 * - IncidentReportingController extends Controller
 */

namespace App\Http\Controllers;


// Required Imorts .....
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\incident_report;
use App\Models\IncidentReportCrewInjury;
use App\Http\Controllers\Vessel_detailsController;
use App\Http\Controllers\GenericController;
use App\Http\Controllers\FileController as FileSaver;
use App\Models\User;

use Carbon\Carbon;
use Log;
use PDF;
use Auth;
use File;



class IncidentReportingController extends Controller
{

    public function __construct()
    {
        set_time_limit(8000000);
    }

    // helper function
    function getmain($id)
    {
        if ($id != 0) {
            $drop = DB::table('near_miss_dropdown_main_type')->where('id', $id)->get();
        } else {
            return 0;
        }
        // $dropsub = $req->id;
        if (!empty($drop)) {
            return $drop[0]->type_main_name;
        } else {
            return 0;
        }
    }

    function getsub($ids)
    {
        if ($ids != 0) {
            $drop = DB::table('near_miss_dropdown_sub_type')->where('id', $ids)->get();
        } else {
            return 0;
        }
        // $dropsub = $req->id;
        if (!empty($drop)) {
            return $drop[0]->type_sub_name;
        } else {
            return 0;
        }
    }

    function getter($idt)
    {
        if ($idt != 0) {
            $drop = DB::table('near_miss_dropdown_ter_type')->where('id', $idt)->get();
        } else {
            return 0;
        }
        // $dropsub = $req->id;
        if (!empty($drop)) {
            return $drop[0]->type_ter_name;
        } else {
            return 0;
        }
    }

    public function RetVal($one, $two, $three, $four, $five)
    {
        if ($one != null || $one != "") {
            return $one;
        }
        if ($two != null || $one != "") {
            return $two;
        }
        if ($three != null || $one != "") {
            return $three;
        }
        if ($four != null || $one != "") {
            return $four;
        }
        if ($five != null || $one != "") {
            return $five;
        }
    }

    public function index()
    {
        $user = User::find(session('id'));
        if($user->hasPermissionTo('view.incident')){
            $is_ship = session('is_ship');
            $creator_id = session('creator_id');

            $response = [
                'is_ship' => $is_ship,
                'creator_id' => $creator_id
            ];
            return view('incident_reporting.view', $response);
        }
        else{
            abort(404);
        }
    }

    public function create()
    {
        // dd($draft);
        // $draft = DB::table('incident_report')
        //         ->where('creator_id',session('creator_id'))
        //         ->where('creator_email',session('email'))
        //         ->where('status','Draft')
        //         ->first();
        //         // dd($draft);
        // if($draft == null){
        //     // $id = $this->createDraft();
        //     // $data   = NearMissModel::find($id);
        //     // dd($data);
        //     // return view('NearMissAccident.addnew', ['dropdown'=> $dropdown, 'dropdownmain' => $dropmain,'data' => $data]);
        //     // $this->createDraft();
        //     return redirect('/incidentNewDraft');
        // }
        // else{
        //     return View('incident_reporting.quearyView');
        // }
        $user = User::find(session('id'));
        if($user->hasPermissionTo('create.incident')){
            return redirect('/incidentNewDraft');
        }
        else{
            abort(404);
        }
    }

    public function store(Request $r)
    {
        // dd('I am in store');
        

        //  TYPE OF LOSS (5th Step)---all okay
        $pi_club_information                          = $r->pi_club_information; //filled
        $hm_informed                                  = $r->hm_informed; //filled
        $remarks_tol                                  = $r->remarks_tol; //filled
        //  TYPE OF LOSS (5th Step)---all okay End
        $Report_number                                = $r->Report_number;

        $id = $r->id;
      
        // Root causes
        if ($r->rootcauses_first) {
            if (count($r->rootcauses_first) < 1 || $r->rootcauses_first[0] == 0) {
                $rootcause_frst_drop                          = "-----";
            } else {
                $rootcause_frst_drop                          = null;
                for ($i                                            = 0; $i < count($r->rootcauses_first); $i++) {
                    $rootcause_frst_drop .= $this->getmain($r->rootcauses_first[$i]);
                    if ($i < count($r->rootcauses_first) - 1) {
                        $rootcause_frst_drop .= ',';
                    }
                }
            }
        } else {
            $rootcause_frst_drop   = "-----";
        }

        if ($r->rootcauses_second) {
            if (count($r->rootcauses_second) < 1 || $r->rootcauses_second[0] == 0) {
                $rootcause_second_drop = "-----";
            } else {
                $rootcause_second_drop = null;
                for ($i                     = 0; $i < count($r->rootcauses_second); $i++) {
                    $rootcause_second_drop .= $this->getsub($r->rootcauses_second[$i]);
                    if ($i < count($r->rootcauses_second) - 1) {
                        $rootcause_second_drop .= ',';
                    }
                }
            }
        } else {
            $rootcause_second_drop = "-----";
        }

        if ($r->rootcauses_third) {
            if (count($r->rootcauses_third) < 1 || $r->rootcauses_third[0] == 0) {
                $rootcause_third_drop  = "-----";
            } else {
                $rootcause_third_drop  = null;
                for ($i                     = 0; $i < count($r->rootcauses_third); $i++) {
                    $rootcause_third_drop .= $this->getter($r->rootcauses_third[$i]);
                    if ($i < count($r->rootcauses_third) - 1) {
                        $rootcause_third_drop .= ',';
                    }
                }
            }
        } else {
            $rootcause_third_drop         = "-----";
        }

        $rootcauses_first             = $rootcause_frst_drop; //filled
        $rootcauses_second            = $rootcause_second_drop; //filled
        $rootcauses_third             = $rootcause_third_drop; //filled
        // Root causes end


        // Preventive action
        if ($r->preventiveactions_first) {
            if (count($r->preventiveactions_first) < 1 || $r->preventiveactions_first[0] == 0) {
                $preventiveactions_first_drop = "-----";
            } else {
                $preventiveactions_first_drop = null;
                for ($i                            = 0; $i < count($r->preventiveactions_first); $i++) {
                    $preventiveactions_first_drop .= $this->getmain($r->preventiveactions_first[$i]);
                    if ($i < count($r->preventiveactions_first) - 1) {
                        $preventiveactions_first_drop .= ',';
                    }
                }
            }
        } else {
            $preventiveactions_first_drop  = "-----";
        }

        if ($r->preventiveactions_second) {
            if (count($r->preventiveactions_second) < 1 || $r->preventiveactions_second[0] == 0) {
                $preventiveactions_second_drop = "-----";
            } else {
                $preventiveactions_second_drop = null;
                for ($i                             = 0; $i < count($r->preventiveactions_second); $i++) {
                    $preventiveactions_second_drop .= $this->getsub($r->preventiveactions_second[$i]);
                    if ($i < count($r->preventiveactions_second) - 1) {
                        $preventiveactions_second_drop .= ',';
                    }
                }
            }
        } else {
            $preventiveactions_second_drop = "-----";
        }

        if ($r->preventiveactions_third) {
            if (count($r->preventiveactions_third) < 1 || $r->preventiveactions_third[0] == 0) {
                $preventiveactions_third_drop  = "-----";
            } else {
                $preventiveactions_third_drop  = null;
                for ($i                             = 0; $i < count($r->preventiveactions_third); $i++) {
                    $preventiveactions_third_drop .= $this->getter($r->preventiveactions_third[$i]);
                    if ($i < count($r->preventiveactions_third) - 1) {
                        $preventiveactions_third_drop .= ',';
                    }
                }
            }
        } else {
            $preventiveactions_third_drop               = "-----";
        }
        $preventiveactions_first                    = $preventiveactions_first_drop; //filled
        $preventiveactions_second                   = $preventiveactions_second_drop; //filled
        $preventiveactions_third                    = $preventiveactions_third_drop; //filled
        // Preventive action end


        $five_why_comments                          = $r->five_why_comments;

        $five_why_followup_total                    = $r->five_why_followup_total;

        $five_why_followup_action_describtion       = $r->five_why_followup_action_describtion;
        $five_why_followup_action_pic               = $r->five_why_followup_action_pic;
        $five_why_followup_action_department        = $r->five_why_followup_action_department;
        $five_why_followup_action_target_date       = $r->five_why_followup_action_target_date;
        $five_why_followup_action_completed_date    = $r->five_why_followup_action_completed_date;
        $five_why_followup_action_evidence_uploaded = $r->five_why_followup_action_evidence_uploaded;
        $five_why_followup_action_cost              = $r->five_why_followup_action_cost;
        $five_why_followup_action_comments          = $r->five_why_followup_action_comments;
        $five_why_Risk_assesment_evaluated          = $r->five_why_Risk_assesment_evaluated;

        // START STEP 8
        $incident_for_five_why                      = $r->incident_for_five_why;
        $first_why_for_five_why                     = $r->first_why_for_five_why;
        $second_why_for_five_why                    = $r->second_why_for_five_why;
        $third_why_for_five_why                     = $r->third_why_for_five_why;
        $fourth_why_for_five_why                    = $r->fourth_why_for_five_why;
        $fifth_why_for_five_why                     = $r->fifth_why_for_five_why;
        $rootcause_for_five_why                     = $r->rootcause_for_five_why;

        //null check
        if ($incident_for_five_why == null) {
            $incident_for_five_why                      = '';
        }
        if ($first_why_for_five_why == null) {
            $first_why_for_five_why                     = '';
        }
        if ($second_why_for_five_why == null) {
            $second_why_for_five_why                    = '';
        }
        if ($third_why_for_five_why == null) {
            $third_why_for_five_why                     = '';
        }
        if ($fourth_why_for_five_why == null) {
            $fourth_why_for_five_why                    = '';
        }
        if ($fifth_why_for_five_why == null) {
            $fifth_why_for_five_why                     = '';
        }
        if ($rootcause_for_five_why == null) {
            $rootcause_for_five_why                     = '';
        }


        $risk_evidence_file = $r->risk_evidence_file;


        // changes which are added on (10-May-2022) in code it is only shown to shore side .....
        $team_engagement_and_discussion_topic = $r->team_engagement_and_discussion_topic;
        $lessons_learned = $r->lessons_learned;
        $potential_outcome = $r->potential_outcome;
        $key_message = $r->key_message;

        // SEE 5 WHY (9th step) End


        
       
        

        $user_id                                    = Auth::user()->id;
        $saved_status                               = 'completed';
       
        Log::info('id :: '.print_r($id,true));
        //Incident Images
        $uploadUrlSegment = $id.DIRECTORY_SEPARATOR.config('constants.INCIDENT_REPORTING_IMAGE_FOLDERS.INCIDENT_IMAGES');
        $pathImage = (new FileSaver)->saveImageBase64($uploadUrlSegment, config('constants.MODULES.INCIDENT_REPORTING'), $r->imageEncodedInput);

      

        // Saving Risk Assessment Evaluated File
        if($risk_evidence_file != null){
            // Log::info("Evidence files : ".print_r($risk_evidence_file,true));
            $risk_evidence_file = (new FileSaver)->saveFile($id.DIRECTORY_SEPARATOR.config('constants.INCIDENT_REPORTING_IMAGE_FOLDERS.RISK_ASSESSMENT_EVALUATED'),config('constants.MODULES.INCIDENT_REPORTING'),$risk_evidence_file);
        }

        if ($five_why_Risk_assesment_evaluated == null) {
            $five_why_Risk_assesment_evaluated           = '';
        }

        // Saving main table .....
        $incidents_report                            =  incident_report::find($r->id); // creating incident obj
        $incidents_report->status                    = config('constants.status.Not_approved');
        $incidents_report->comments_five_why_section = $five_why_comments;
        $incidents_report->is_evalutated             = $five_why_Risk_assesment_evaluated;
        $incidents_report->five_why_risk_assesment_evaluated_file_upload    = $risk_evidence_file;
        // changes which are added on (10-May-2022) in code it is only shown to shore side .....
        $incidents_report->team_engagement_and_discussion_topic = $team_engagement_and_discussion_topic;
        $incidents_report->lessons_learned                      = $lessons_learned;
        $incidents_report->potential_outcome                    = $potential_outcome;
        $incidents_report->key_message                          = $key_message;
        $incidents_report->user_id                   = $user_id;
        $incidents_report->saved_status              = $saved_status;
        $incidents_report->save();

        if ($Report_number) {
            $Report_number_array = explode('-', $Report_number);
            // $Report_number);

            DB::table('incident_report_number')->insert([
                'id' => $this->Generating_child_ID('incident_report_number',  $r->id, $r->id . '__IRN'),
                'vessel_code' => $Report_number,
                'year' => $Report_number_array[1],
                'ref' => $Report_number_array[2],
                'incident_report_id' => $r->id
            ]);
        }

        // Deleting Previous and creating new Root Causes .....
        // DB::table('incident_reports_root_causes')->where('incident_report_id', $r->id)->delete();
        if ((empty($rootcauses_first) != true &&  $rootcauses_first != "-----") || $rootcauses_first != 0) {
            $is_exist_before = count(DB::table('incident_reports_root_causes')->where('incident_report_id', $r->id)->get());

            if ($is_exist_before != 0) {
                DB::table('incident_reports_root_causes')->where('incident_report_id', $r->id)->update([
                    'primary' => $rootcauses_first,
                    'secondary' => $rootcauses_second,
                    'tertiary' => $rootcauses_third
                ]);
            } else {
                DB::table('incident_reports_root_causes')->insert(['id' => $this->Generating_child_ID('incident_reports_root_causes',  $id, $id . '__IRRC'), 'incident_report_id' => $id, 'primary' => $rootcauses_first, 'secondary' => $rootcauses_second, 'tertiary' => $rootcauses_third,]);
            }
        }

        // Deleting Previous and creating new Preventive Actions .....
        // DB::table('incident_reports_preventive_actions')->where('incident_report_id', $id)->delete();
        if ((empty($preventiveactions_first) != true &&  $preventiveactions_first != "-----") || $preventiveactions_first != 0) {
            $is_exist_before = count(DB::table('incident_reports_preventive_actions')->where('incident_report_id', $id)->get());
            if ($is_exist_before != 0) {
                DB::table('incident_reports_preventive_actions')->where('incident_report_id', $id)->update([

                    'primary' => $preventiveactions_first,
                    'secondary' => $preventiveactions_second,
                    'tertiary' => $preventiveactions_third

                ]);
            } else {
                DB::table('incident_reports_preventive_actions')->insert(['id' => $this->Generating_child_ID('incident_reports_preventive_actions',  $id, $id . '__IRPA'), 'incident_report_id' => $id, 'primary' => $preventiveactions_first, 'secondary' => $preventiveactions_second, 'tertiary' => $preventiveactions_third,]);
            }
        }
        //delete previous record from incident_reports_five_why if exist
        // DB::table('incident_reports_five_why')->where('incident_report_id',$id)->delete();
        DB::table('incident_reports_five_why')->insert(['id'       => $this->Generating_child_ID('incident_reports_five_why',  $r->id, $r->id . '__IRFW'), 'incident_report_id'       => $r->id, 'incident'       => $incident_for_five_why, 'first_why'       => $first_why_for_five_why, 'second_why'       => $second_why_for_five_why, 'third_why'       => $third_why_for_five_why, 'fourth_why'       => $fourth_why_for_five_why, 'fifth_why'       => $fifth_why_for_five_why, 'root_cause'       => $rootcause_for_five_why]);


        // Saving Actions in five why .....
        $sl_no = 0;
        $fill  = $r->file('evidence_file');

        for ($p     = 0; $p < $five_why_followup_total; $p++) {
            if ($fill == null) {
                $filename = null;
            } else {
                if (array_key_exists($p, $fill) == false) {
                    $filename = null;
                }
                else
                {
                    $uploadUrlSegment = $id.DIRECTORY_SEPARATOR.config('constants.INCIDENT_REPORTING_IMAGE_FOLDERS.EVIDENCE_UPLOADED');
                    $filename = (new FileSaver)->saveFile($uploadUrlSegment,config('constants.MODULES.INCIDENT_REPORTING'),$fill[$p]);
                }
            }
            $fwfad  = null;
            if ($five_why_followup_action_describtion != null) {
                $fwfad  = $five_why_followup_action_describtion[$p];
            }

            $fwfap  = null;
            if ($five_why_followup_action_pic != null) {
                $fwfap  = $five_why_followup_action_pic[$p];
            }
            $fwfa_De  = null;
            if ($five_why_followup_action_department != null) {
                $fwfa_De  = $five_why_followup_action_department[$p];
            }
            $fwfatd = null;
            if ($five_why_followup_action_target_date != null) {
                $fwfatd = $five_why_followup_action_target_date[$p];
            }
            $fwfacd = null;
            if ($five_why_followup_action_completed_date != null) {
                $fwfacd = $five_why_followup_action_completed_date[$p];
            }
            $fwfaeu = null;
            if ($five_why_followup_action_evidence_uploaded != null && isset($five_why_followup_action_evidence_uploaded[$p])) {
                $fwfaeu = $five_why_followup_action_evidence_uploaded[$p];
            }
            $fwfac  = null;
            if ($five_why_followup_action_cost != null) {
                $fwfac  = $five_why_followup_action_cost[$p];
            }
            $fwfsC  = null;
            if ($five_why_followup_action_comments != null) {
                $fwfsC  = $five_why_followup_action_comments[$p];
            }


            // DB::table('incident_reports_follow_up_actions')->where('incident_report_id',$id)->delete();
            $sl_no++;
            DB::table('incident_reports_follow_up_actions')->insert([
                'id' => $this->Generating_child_ID('incident_reports_follow_up_actions',  $id, $id . '__IRFUA') . '_' . $sl_no,
                'incident_report_id' => $id,
                'sl_no' => $sl_no,
                'description' => $fwfad,
                'pic' => $fwfap,
                'department' => $fwfa_De,
                'target_date' => $fwfatd,
                'completed_date' => $fwfacd,
                'evidence_uploaded' => $fwfaeu,
                'cost' => $fwfac,
                'comments' => $fwfsC,
                'evidence_file' => $filename
            ]);
        }

        return redirect(url('/incident-reporting'));
    }

    public function edit($id)
    {
        $user = User::find(session('id'));
        if($user->hasPermissionTo('edit.incident')){
            // Getting Ship Name if its Ship .....
            if (session('is_ship')) {
                $ship_name = DB::table('vessels')->where('unique_id', session('creator_id'))->first()->name;
            } else {
                $ship_name = false;
            }


            //
            $dropdown                                 = DB::table('near_miss_dropdown')->get();
            $dropmain                                 = DB::table('near_miss_dropdown_main_type')->get();
            $country_list                             = DB::table('currency')->get();
            $crew_list                                = DB::table('crew_list')->get();
            $vessel_details                           = DB::table('vessel_details')->first();

            // $incident_report_number = DB::table('incident_report_number')->get()->last();
            //--------------------
            $incident_table                           = DB::table('incident_report')->find($id);
            $incident_reports_crew_injury             = DB::table('incident_reports_crew_injury')->where('incident_report_id', $id)->first();
            $incident_reports_supporting_team_members = DB::table('incident_reports_supporting_team_members')->where('IRI', $id)->get();
            $incident_reports_event_information       = DB::table('incident_reports_event_information')->where('incident_report_id', $id)->first();
            $incident_reports_weather                 = DB::table('incident_reports_weather')->where('incident_report_id', $id)->first();
            $incident_reports_event_logs              = DB::table('incident_reports_event_logs')->where('incident_report_id', $id)->get();
            $incident_reports_event_details           = DB::table('incident_reports_event_details')->where('incident_report_id', $id)->get();
            $incident_reports_risk_details            = DB::table('incident_reports_risk_details')->where('incident_report_id', $id)->first();
            $incident_reports_immediate_causes        = DB::table('incident_reports_immediate_causes')->where('incident_report_id', $id)->get()->first();
            $incident_reports_root_causes             = DB::table('incident_reports_root_causes')->where('incident_report_id', $id)->get()->first();
            $incident_reports_preventive_actions      = DB::table('incident_reports_preventive_actions')->where('incident_report_id', $id)->get()->first();
            $incident_reports_five_why                = DB::table('incident_reports_five_why')->where('incident_report_id', $id)->get()->first();
            $incident_reports_follow_up_actions       = DB::table('incident_reports_follow_up_actions')->where('incident_report_id', $id)->get();
            // $report = DB::table('near_miss_accident_report')->find($id);
            $Slight                                   = DB::table('incident_reports_classification_matrix')->where('id', '1')
                ->get();
            $Minor                                    = DB::table('incident_reports_classification_matrix')->where('id', '2')
                ->get();
            $Medium                                   = DB::table('incident_reports_classification_matrix')->where('id', '3')
                ->get();
            $Major                                    = DB::table('incident_reports_classification_matrix')->where('id', '4')
                ->get();
            $Extreme                                  = DB::table('incident_reports_classification_matrix')->where('id', '5')->get();


            $data                                     = DB::table('vessels')->leftJoin('vessel_details', 'vessels.unique_id', '=', 'vessel_details.id')
                ->get()
                ->first();
            $incident_report_number                   = DB::table('incident_report_number')->get()->last();
            // dd($incident_reports_risk_details);
            // data response to client .....
            $response = [
                'is_edit'                                       => 1,
                'data_id'                                       => $id,
                'country_list'                                  => $country_list,
                'incident_report'                               => $incident_table,
                'vessel_details'                                => $vessel_details,
                'crew_list'                                     => $crew_list,
                'dropdown'                                      => $dropdown,
                'dropdownmain'                                  => $dropmain,
                'incident_reports_crew_injury'                  => $incident_reports_crew_injury,
                'incident_reports_supporting_team_members'      => $incident_reports_supporting_team_members,
                'incident_reports_event_information'            => $incident_reports_event_information,
                'incident_reports_weather'                      => $incident_reports_weather,
                'incident_reports_event_logs'                   => $incident_reports_event_logs,
                'incident_reports_event_details'                => $incident_reports_event_details,
                'incident_reports_risk_details'                 => $incident_reports_risk_details,
                'incident_reports_immediate_causes'             => $incident_reports_immediate_causes,
                'incident_reports_root_causes'                  => $incident_reports_root_causes,
                'incident_reports_preventive_actions'           => $incident_reports_preventive_actions,
                'incident_reports_five_why'                     => $incident_reports_five_why,
                'incident_reports_follow_up_actions'            => $incident_reports_follow_up_actions,
                'slight'                                        => $Slight,
                'minor'                                         => $Minor,
                'major'                                         => $Major,
                'medium'                                        => $Medium,
                'extreme'                                       => $Extreme,
                'data'                                          => $data,
                'vs_code'                                       => $incident_report_number,
                'vessel_name'                                   => $incident_table->vessel_name,
                'ship_name'                                     => $ship_name,
                'incident_image'                                => ($incident_table->incident_image != null)?(new FileSaver)->getImageBase64($incident_table->incident_image):''
            ];
            return view('incident_reporting.create', $response);
        }
        else{
            abort(404);
        }
        
    }

    public function update(Request $r, $id)
    {
        // dd('I am in update');
        // Incident Header (1st step) ---all okay
        
        // SEE 5 WHY (9th step)
        // Root causes
        if ($r->rootcauses_first) {
            if (count($r->rootcauses_first) < 1 || $r->rootcauses_first[0] == 0) {
                $rootcause_frst_drop                          = "-----";
            } else {
                $rootcause_frst_drop                          = null;
                for ($i                                            = 0; $i < count($r->rootcauses_first); $i++) {
                    $rootcause_frst_drop .= $this->getmain($r->rootcauses_first[$i]);
                    if ($i < count($r->rootcauses_first) - 1) {
                        $rootcause_frst_drop .= ',';
                    }
                }
            }
        } else {
            $rootcause_frst_drop   = "-----";
        }

        if ($r->rootcauses_second) {
            if (count($r->rootcauses_second) < 1 || $r->rootcauses_second[0] == 0) {
                $rootcause_second_drop = "-----";
            } else {
                $rootcause_second_drop = null;
                for ($i                     = 0; $i < count($r->rootcauses_second); $i++) {
                    $rootcause_second_drop .= $this->getsub($r->rootcauses_second[$i]);
                    if ($i < count($r->rootcauses_second) - 1) {
                        $rootcause_second_drop .= ',';
                    }
                }
            }
        } else {
            $rootcause_second_drop = "-----";
        }

        if ($r->rootcauses_third) {
            if (count($r->rootcauses_third) < 1 || $r->rootcauses_third[0] == 0) {
                $rootcause_third_drop  = "-----";
            } else {
                $rootcause_third_drop  = null;
                for ($i                     = 0; $i < count($r->rootcauses_third); $i++) {
                    $rootcause_third_drop .= $this->getter($r->rootcauses_third[$i]);
                    if ($i < count($r->rootcauses_third) - 1) {
                        $rootcause_third_drop .= ',';
                    }
                }
            }
        } else {
            $rootcause_third_drop         = "-----";
        }

        $rootcauses_first             = $rootcause_frst_drop; //filled
        $rootcauses_second            = $rootcause_second_drop; //filled
        $rootcauses_third             = $rootcause_third_drop; //filled
        // Root causes end


        // Preventive action
        if ($r->preventiveactions_first) {
            if (count($r->preventiveactions_first) < 1 || $r->preventiveactions_first[0] == 0) {
                $preventiveactions_first_drop = "-----";
            } else {
                $preventiveactions_first_drop = null;
                for ($i                            = 0; $i < count($r->preventiveactions_first); $i++) {
                    $preventiveactions_first_drop .= $this->getmain($r->preventiveactions_first[$i]);
                    if ($i < count($r->preventiveactions_first) - 1) {
                        $preventiveactions_first_drop .= ',';
                    }
                }
            }
        } else {
            $preventiveactions_first_drop  = "-----";
        }

        if ($r->preventiveactions_second) {
            if (count($r->preventiveactions_second) < 1 || $r->preventiveactions_second[0] == 0) {
                $preventiveactions_second_drop = "-----";
            } else {
                $preventiveactions_second_drop = null;
                for ($i                             = 0; $i < count($r->preventiveactions_second); $i++) {
                    $preventiveactions_second_drop .= $this->getsub($r->preventiveactions_second[$i]);
                    if ($i < count($r->preventiveactions_second) - 1) {
                        $preventiveactions_second_drop .= ',';
                    }
                }
            }
        } else {
            $preventiveactions_second_drop = "-----";
        }

        if ($r->preventiveactions_third) {
            if (count($r->preventiveactions_third) < 1 || $r->preventiveactions_third[0] == 0) {
                $preventiveactions_third_drop  = "-----";
            } else {
                $preventiveactions_third_drop  = null;
                for ($i                             = 0; $i < count($r->preventiveactions_third); $i++) {
                    $preventiveactions_third_drop .= $this->getter($r->preventiveactions_third[$i]);
                    if ($i < count($r->preventiveactions_third) - 1) {
                        $preventiveactions_third_drop .= ',';
                    }
                }
            }
        } else {
            $preventiveactions_third_drop               = "-----";
        }
        $preventiveactions_first                    = $preventiveactions_first_drop; //filled
        $preventiveactions_second                   = $preventiveactions_second_drop; //filled
        $preventiveactions_third                    = $preventiveactions_third_drop; //filled
        // Preventive action end


        $five_why_comments                          = $r->five_why_comments;

        $five_why_followup_total                    = $r->five_why_followup_total;
        $five_why_followup_action_describtion       = $r->five_why_followup_action_describtion;
        $five_why_followup_action_pic               = $r->five_why_followup_action_pic;
        $five_why_followup_action_department        = $r->five_why_followup_action_department;
        $five_why_followup_action_target_date       = $r->five_why_followup_action_target_date;
        $five_why_followup_action_completed_date    = $r->five_why_followup_action_completed_date;
        $five_why_followup_action_evidence_uploaded = $r->five_why_followup_action_evidence_uploaded;
        $five_why_followup_action_cost              = $r->five_why_followup_action_cost;
        $five_why_followup_action_comments          = $r->five_why_followup_action_comments;

        $five_why_Risk_assesment_evaluated          = $r->five_why_Risk_assesment_evaluated;

        $risk_evidence_file                         = $r->risk_evidence_file;
        // Saving risk_evidence_file into folder .....

        if($risk_evidence_file != null){
            $risk_evidence_file = (new FileSaver)->saveFile($id.DIRECTORY_SEPARATOR.config('constants.INCIDENT_REPORTING_IMAGE_FOLDERS.RISK_ASSESSMENT_EVALUATED'),config('constants.MODULES.INCIDENT_REPORTING'),$risk_evidence_file);
        }


        $incident_for_five_why                      = $r->incident_for_five_why;
        $first_why_for_five_why                     = $r->first_why_for_five_why;
        $second_why_for_five_why                    = $r->second_why_for_five_why;
        $third_why_for_five_why                     = $r->third_why_for_five_why;
        $fourth_why_for_five_why                    = $r->fourth_why_for_five_why;
        $fifth_why_for_five_why                     = $r->fifth_why_for_five_why;
        $rootcause_for_five_why                     = $r->rootcause_for_five_why;

        // changes which are added on (10-May-2022) in code it is only shown to shore side .....
        $team_engagement_and_discussion_topic = $r->team_engagement_and_discussion_topic;
        $lessons_learned = $r->lessons_learned;
        $potential_outcome = $r->potential_outcome;
        $key_message = $r->key_message;

        // SEE 5 WHY (9th step) End
        if ($first_why_for_five_why == null) {
            $first_why_for_five_why                     = '';
        }
        if ($second_why_for_five_why == null) {
            $second_why_for_five_why                    = '';
        }
        if ($third_why_for_five_why == null) {
            $third_why_for_five_why                     = '';
        }
        if ($fourth_why_for_five_why == null) {
            $fourth_why_for_five_why                    = '';
        }
        if ($fifth_why_for_five_why == null) {
            $fifth_why_for_five_why                     = '';
        }



        $id = $r->id;
        // Updating Main 'incident_report' table data  .....
        $incidents_report                            =  incident_report::find($r->id); // creating incident obj
        $incidents_report->comments_five_why_section = $five_why_comments;
        $incidents_report->is_evalutated             = $five_why_Risk_assesment_evaluated;
        $incidents_report->five_why_risk_assesment_evaluated_file_upload    = $risk_evidence_file;
        // changes which are added on (10-May-2022) in code it is only shown to shore side .....
        $incidents_report->status                    = config('constants.status.Not_approved');
        $incidents_report->team_engagement_and_discussion_topic = $team_engagement_and_discussion_topic;
        $incidents_report->lessons_learned                      = $lessons_learned;
        $incidents_report->potential_outcome                    = $potential_outcome;
        $incidents_report->key_message                          = $key_message;
        $incidents_report->save();


        if ($risk_evidence_file != null) {
            DB::table('incident_report')->where('id', $id)->update([
                'five_why_risk_assesment_evaluated_file_upload' => $risk_evidence_file
            ]);
        }
        if ($five_why_Risk_assesment_evaluated == 'No') {
            DB::table('incident_report')->where('id', $id)->update([
                'five_why_risk_assesment_evaluated_file_upload' => null
            ]);
        }

        

        // Updating drawer.js image data .....
        // if (isset($r->imageEncodedInput) || $r->imageEncodedInput != null) {

        //     $image                                      = $r->imageEncodedInput; // image base64 encoded
        //     preg_match("/data:image\/(.*?);/", $image, $image_extension); // extract the image extension
        //     $image     = preg_replace('/data:image\/(.*?);base64,/', '', $image); // remove the type part
        //     $image     = str_replace(' ', '+', $image);
        //     $pathImage = null;
        //     if ($image_extension) {
        //         $imageName = 'image_' . time() . '.' . $image_extension[1]; //generating unique file name;
        //         //move_uploadedf_file($input, $target_file);

        //         // constructing folder path for image .....
        //         $folder_path = env('UPLOAD_PATH')  . DIRECTORY_SEPARATOR . Session('creator_id') . DIRECTORY_SEPARATOR . config('constants.MODULES.INCIDENT_REPORTING') . DIRECTORY_SEPARATOR . $id . DIRECTORY_SEPARATOR . 'drawing_image_incident_reporting' . DIRECTORY_SEPARATOR;

        //         //  Create that folder in public directory if not exist .....
        //         if (!file_exists($folder_path))
        //             mkdir($folder_path, 0777, true);

        //         // build image path for save  .....
        //         $pathImage = $folder_path . $imageName;
        //         // put that image inside the path .....
        //         file_put_contents($pathImage, base64_decode($image));

        //         // setting relative path to saving variable .....
        //         $pathImage =  DIRECTORY_SEPARATOR . Session('creator_id') . DIRECTORY_SEPARATOR . config('constants.MODULES.INCIDENT_REPORTING') . DIRECTORY_SEPARATOR . $id . DIRECTORY_SEPARATOR . 'drawing_image_incident_reporting' . DIRECTORY_SEPARATOR . $imageName;



        //         // Updating inside DB .....
        //         DB::table('incident_report')->where('id', $id)->update([
        //             'incident_image' => $pathImage
        //         ]);
        //     }
        // }

        

        // Deleting Previous and creating new Root Causes .....
        if ((empty($rootcauses_first) != true &&  $rootcauses_first != "-----") || $rootcauses_first != 0) {
            $is_exist_before = count(DB::table('incident_reports_root_causes')->where('incident_report_id', $id)->get());

            if ($is_exist_before != 0) {
                DB::table('incident_reports_root_causes')->where('incident_report_id', $id)->update([
                    'primary' => $rootcauses_first,
                    'secondary' => $rootcauses_second,
                    'tertiary' => $rootcauses_third
                ]);
            } else {
                DB::table('incident_reports_root_causes')->insert(['id' => $this->Generating_child_ID('incident_reports_root_causes',  $id, $id . '__IRRC'), 'incident_report_id' => $id, 'primary' => $rootcauses_first, 'secondary' => $rootcauses_second, 'tertiary' => $rootcauses_third,]);
            }
        }

        // Deleting Previous and creating new Preventive Actions .....
        if ((empty($preventiveactions_first) != true &&  $preventiveactions_first != "-----") || $preventiveactions_first != 0) {
            $is_exist_before = count(DB::table('incident_reports_preventive_actions')->where('incident_report_id', $id)->get());
            if ($is_exist_before != 0) {
                DB::table('incident_reports_preventive_actions')->where('incident_report_id', $id)->update([

                    'primary' => $preventiveactions_first,
                    'secondary' => $preventiveactions_second,
                    'tertiary' => $preventiveactions_third

                ]);
            } else {
                DB::table('incident_reports_preventive_actions')->insert(['id' => $this->Generating_child_ID('incident_reports_preventive_actions',  $id, $id . '__IRPA'), 'incident_report_id' => $id, 'primary' => $preventiveactions_first, 'secondary' => $preventiveactions_second, 'tertiary' => $preventiveactions_third,]);
            }
        }


        // Updating Five Why .....
        if ($r->first_why_for_five_why != '') {
            DB::table('incident_reports_five_why')->where('incident_report_id', $id)->update([
                'incident'       => $incident_for_five_why, 'first_why'       => $first_why_for_five_why, 'second_why'       => $second_why_for_five_why, 'third_why'       => $third_why_for_five_why, 'fourth_why'       => $fourth_why_for_five_why, 'fifth_why'       => $fifth_why_for_five_why, 'root_cause'       => $rootcause_for_five_why,
            ]);
        }

        // Updating incident_reports_follow_up_actions .....
        $del = DB::table('incident_reports_follow_up_actions')->where('incident_report_id', $id)->delete();
        $sl_no = 0;
        $fill  = $r->file('evidence_file');
        $prev_evidence_file = $r->f_u_a_editImage;
        for ($p     = 0; $p < $five_why_followup_total; $p++) {
            if ($fill == null) {
                $filename = null;
            } else {
                if (array_key_exists($p, $fill) == false) {
                    $filename = null;
                } else {
                    $filename = (new FileSaver)->saveFile($id . DIRECTORY_SEPARATOR . 'followup_action_evidence', config('constants.MODULES.INCIDENT_REPORTING'), $fill[$p]);
                }
            }
            $fwfad  = null;
            if ($five_why_followup_action_describtion != null) {
                $fwfad  = $five_why_followup_action_describtion[$p];
            }

            $fwfap  = null;
            if ($five_why_followup_action_pic != null) {
                $fwfap  = $five_why_followup_action_pic[$p];
            }
            $fwfa_De  = null;
            if ($five_why_followup_action_department != null) {
                $fwfa_De  = $five_why_followup_action_department[$p];
            }
            $fwfatd = null;
            if ($five_why_followup_action_target_date != null) {
                $fwfatd = $five_why_followup_action_target_date[$p];
            }
            $fwfacd = null;
            if ($five_why_followup_action_completed_date != null) {
                $fwfacd = $five_why_followup_action_completed_date[$p];
            }
            $fwfaeu = null;
            if ($five_why_followup_action_evidence_uploaded != null && isset($five_why_followup_action_evidence_uploaded[$p])) {
                $fwfaeu = $five_why_followup_action_evidence_uploaded[$p];
            }
            $fwfac  = null;
            if ($five_why_followup_action_cost != null) {
                $fwfac  = $five_why_followup_action_cost[$p];
            }
            $fwfsC  = null;
            if ($five_why_followup_action_comments != null) {
                $fwfsC  = $five_why_followup_action_comments[$p];
            }



            $sl_no++;

            if ($filename == null) {
                if (isset($prev_evidence_file[$p])) {
                    $filename =  $prev_evidence_file[$p];
                }
            }
            DB::table('incident_reports_follow_up_actions')->insert([
                'id' => $this->Generating_child_ID('incident_reports_follow_up_actions',  $id, $id . '__IRFUA') . '_' . $sl_no,
                'incident_report_id' => $id,
                'sl_no' => $sl_no,
                'description' => $fwfad,
                'pic' => $fwfap,
                'department' => $fwfa_De,
                'target_date' => $fwfatd,
                'completed_date' => $fwfacd,
                'evidence_uploaded' => $fwfaeu,
                'cost' => $fwfac,
                'comments' => $fwfsC,
                'evidence_file' => $filename
            ]);
        }

        return redirect(url('/incident-reporting'));
    }

    public function destroy($id)
    {
        // Hard Delete .....
        // DB::table('incident_reports_five_why')->where('incident_report_id', $id)->delete();
        // DB::table('incident_reports_crew_injury')->where('incident_report_id', $id)->delete();
        // DB::table('incident_reports_supporting_team_members')->where('IRI', $id)->delete();
        // DB::table('incident_reports_event_information')->where('incident_report_id', $id)->delete();
        // DB::table('incident_reports_weather')->where('incident_report_id', $id)->delete();
        // DB::table('incident_reports_event_details')->where('incident_report_id', $id)->delete();
        // DB::table('incident_reports_risk_details')->where('incident_report_id', $id)->delete();
        // DB::table('incident_reports_immediate_causes')->where('incident_report_id', $id)->delete();
        // DB::table('incident_reports_root_causes')->where('incident_report_id', $id)->delete();
        // DB::table('incident_reports_preventive_actions')->where('incident_report_id', $id)->delete();
        // DB::table('incident_reports_follow_up_actions')->where('incident_report_id', $id)->delete();
        // DB::table('incident_reports_event_logs')->where('incident_report_id', $id)->delete();
        // DB::table('incident_report')->where('id', $id)->delete();

        $user = User::find(session('id'));
        if($user->hasPermissionTo('delete.incident')){
            //  Soft Delete .....
                    
            $current_time = Carbon::now()->toDateTimeString();
            DB::table('incident_report')->where('id', $id)->update(['deleted_at' => $current_time,]);


            return redirect(url('/incident-reporting'));
        }
        else{
            abort(404);
        }
        
    }

    // `````````````````````````````````````````````` pdf ````````````````````````````````````````

    // printing all data on pdf .....
    function printPDF_incident($id)
    {

        // Getting ID of The Printed form .....
        $ID = $id;

        // Fetching Main/Mother 'incident_report' Table Data .....
        $incident_report = DB::table('incident_report')->find($id);

        // Fetching Child 'incident_reports_crew_injury' Table Data .....
        $incident_reports_crew_injury = DB::table('incident_reports_crew_injury')->where('incident_report_id', $id)->first();

        // Fetching Child 'incident_reports_event_details' Table Data .....
        $incident_reports_event_details = DB::table('incident_reports_event_details')->where('incident_report_id', $id)->get();

        // Fetching Child 'incident_reports_event_information' Table Data .....
        $incident_reports_event_information = DB::table('incident_reports_event_information')->where('incident_report_id', $id)->first();

        // Fetching Child 'incident_reports_event_logs' Table Data .....
        $incident_reports_event_logs = DB::table('incident_reports_event_logs')->where('incident_report_id', $id)->get();

        // Fetching Child 'incident_reports_five_why' Table Data .....
        $incident_reports_five_why = DB::table('incident_reports_five_why')->where('incident_report_id', $id)->first();

        // Fetching Child 'incident_reports_follow_up_actions' Table Data .....
        $incident_reports_follow_up_actions = DB::table('incident_reports_follow_up_actions')->where('incident_report_id', $id)->get();

        // Fetching Child 'incident_reports_immediate_causes' Table Data .....
        $incident_reports_immediate_causes = DB::table('incident_reports_immediate_causes')->where('incident_report_id', $id)->first();

        // Fetching Child 'incident_reports_preventive_actions' Table Data .....
        $incident_reports_preventive_actions = DB::table('incident_reports_preventive_actions')->where('incident_report_id', $id)->first();

        // Fetching Child 'incident_reports_risk_details' Table Data .....
        $incident_reports_risk_details = DB::table('incident_reports_risk_details')->where('incident_report_id', $id)->first();

        // Fetching Child 'incident_reports_event_details' Table Data .....
        $incident_reports_root_causes = DB::table('incident_reports_root_causes')->where('incident_report_id', $id)->first();

        // Fetching Child 'incident_reports_supporting_team_members' Table Data .....
        $incident_reports_supporting_team_members = DB::table('incident_reports_supporting_team_members')->where('IRI', $id)->get();

        // Fetching Child 'incident_reports_weather' Table Data .....
        $incident_reports_weather = DB::table('incident_reports_weather')->where('incident_report_id', $id)->first();





        // Others Required Table Data's .....
        $dropdown                                 = DB::table('near_miss_dropdown')->get();
        $dropmain                                 = DB::table('near_miss_dropdown_main_type')->get();
        $crew_list                                = DB::table('crew_list')->get();
        $vessel_details                           = DB::table('vessel_details')->first();
        $created_by                               = DB::table('crew_list')->where('id', $incident_report->created_by)->first();
        $master_name                              = DB::table('crew_list')->where('id', $incident_report->master)->first();
        $chief_engineer                           = DB::table('crew_list')->where('id', $incident_report->chief_engineer)->first();
        $chief_officer                            = DB::table('crew_list')->where('id', $incident_report->chief_officer)->first();






        // Converting Image's to 'base64' .....
        $incident_image = 'N/A';

        if($incident_report->incident_image != null){
            // $incident_image = $this->Convert_base64($incident_report->incident_image);
            // $incident_image = (new FileSaver)->getFile($incident_report->incident_image);
            // $incident_image = $incident_report->incident_image;
            $incident_image = (new FileSaver)->getImageBase64($incident_report->incident_image);
        }

        $risk_assesment_evaluated_file_upload = 'N/A';
        if($incident_report->five_why_risk_assesment_evaluated_file_upload != null){
            // $incident_image = $this->Convert_base64($incident_report->incident_image);
            // $incident_image = (new FileSaver)->getFile($incident_report->incident_image);
            // $incident_image = $incident_report->incident_image;
            $risk_assesment_evaluated_file_upload = (new FileSaver)->getImageBase64($incident_report->five_why_risk_assesment_evaluated_file_upload);
        }


        $followUp_image_array = array();
        foreach ($incident_reports_follow_up_actions as $follow_up_action) {

            if($follow_up_action->evidence_file != null){
                // $followUp_image_array[$follow_up_action->id] = $this->Convert_base64(DIRECTORY_SEPARATOR.'Incdent_Report_evidence_file'. DIRECTORY_SEPARATOR. $follow_up_action->evidence_file);
                // $followUp_image_array[$follow_up_action->id] = $follow_up_action->evidence_file;
                $followUp_image_array[$follow_up_action->id] = (new FileSaver)->getImageBase64($follow_up_action->evidence_file);

                Log::info("followUp_image_array : ". print_r($followUp_image_array[$follow_up_action->id], true));
            }
        }

        $logo = asset('images/TCCflagwithoutbackground.png');


        // Data Need To Printed On PDF .....
        $data = compact(
            'ID',
            'incident_report',
            'vessel_details',
            'crew_list',
            'dropdown',
            'dropmain',
            'incident_reports_crew_injury',
            'incident_reports_supporting_team_members',
            'master_name',
            'chief_engineer',
            'chief_officer',
            'created_by',
            'incident_reports_preventive_actions',
            'incident_reports_event_information',
            'incident_reports_five_why',
            'incident_reports_root_causes',
            'incident_reports_immediate_causes',
            'incident_reports_preventive_actions',
            'incident_reports_follow_up_actions',
            'incident_reports_event_details',
            'incident_reports_risk_details',
            'incident_reports_event_logs',
            'incident_reports_event_information',
            'incident_reports_weather',
            'followUp_image_array',
            'incident_image',
            'risk_assesment_evaluated_file_upload',
            'logo'
        );

        $domPdf = PDF::setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => TRUE])->loadView('incident_reporting.single_incident_pdf', $data)
            ->setPaper(array(0, 0, 1080, 1080))->setWarnings(false);
        return $domPdf->stream('Report-a-' . $id . '.pdf');
    }
    // start myPdf
    public function myPdf($id){
        // dd($id);
        $incident_report = DB::table('incident_report')->find($id);
        $incident_reports_preventive_actions = DB::table('incident_reports_preventive_actions')->where('incident_report_id',$id)->first();
        // Converting Image's to 'base64' .....
        $incident_image = 'N/A';
        if($incident_report->incident_image != null){
            $incident_image = (new FileSaver)->getImageBase64($incident_report->incident_image);
        }
        // dd($incident_reports_preventive_actions);
        $pdf = PDF::loadView('incident_reporting.incidentViewPdf',['incident_image'=>$incident_image,'incident_report' => $incident_report,'incident_reports_preventive_actions' => $incident_reports_preventive_actions]);
        // $pdf->setPaper('A4', 'landscape');
        return $pdf->download('Lesson learnt '.$id.'.pdf');
    }
    public function formPdf($id){
        $incident_report = DB::table('incident_report')->find($id);
        $incident_event = DB::table('incident_reports_event_information')->where('incident_report_id',$id)->first();
        $activity = DB::table('incident_reports_event_information')->where('incident_report_id',$id)->pluck('operation')->first();
        // dd($activity);
        // Converting Image's to 'base64' .....
        $incident_image = 'N/A';
        if($incident_report->incident_image != null){
            $incident_image = (new FileSaver)->getImageBase64($incident_report->incident_image);
        }
        // dd($incident_report);
        $categorisation = "";
        if($incident_report->vessel_damage == 'Yes'){
            $categorisation .= "Vessel damage, ";
        }
        if($incident_report->cargo_damage == 'Yes'){
            $categorisation .= "Cargo damage, ";
        }
        if($incident_report->third_party_liability == 'Yes'){
            $categorisation .= "Third party liability, ";
        }
        if($incident_report->environmental == 'Yes'){
            $categorisation .= "Environmental, ";
        }
        if($incident_report->commercial == 'Yes'){
            $categorisation .= "Commertial/service affected, ";
        }
        if($incident_report->crew_injury == 'Yes'){
            $categorisation .= "Crew injury, ";
        }
        if($incident_report->other_personnel_injury == 'Yes'){
            $categorisation .= "Third party personnel injury. ";
        }
        // dd($categorisation);
        $pdf = PDF::loadView('incident_reporting.incidentFromPdf',['incident_report' => $incident_report,'incident_image' =>$incident_image,'incident_event'=>$incident_event,'activity' => $activity,'categorisation' => $categorisation]);
        // $pdf->setPaper('A4', 'landscape');
        return $pdf->download('Immediate '.$id.'.pdf');
    }

    // end myPdf
    // printing 'immediate_incident_notification_and_interim_update' related data on pdf .....
    function immediate_incident_notification_and_interim_update($id){

        // Getting ID of The Printed form .....
        $ID = $id;

        // Fetching Main/Mother 'incident_report' Table Data .....
        $incident_report = DB::table('incident_report')->find($id);

        // Fetching Child 'incident_reports_crew_injury' Table Data .....
        $incident_reports_crew_injury = DB::table('incident_reports_crew_injury')->where('incident_report_id', $id)->first();

        // Fetching Child 'incident_reports_event_details' Table Data .....
        $incident_reports_event_details = DB::table('incident_reports_event_details')->where('incident_report_id', $id)->get();

        // Fetching Child 'incident_reports_event_information' Table Data .....
        $incident_reports_event_information = DB::table('incident_reports_event_information')->where('incident_report_id', $id)->first();

        // Fetching Child 'incident_reports_event_logs' Table Data .....
        $incident_reports_event_logs = DB::table('incident_reports_event_logs')->where('incident_report_id', $id)->get();

        // Fetching Child 'incident_reports_five_why' Table Data .....
        $incident_reports_five_why = DB::table('incident_reports_five_why')->where('incident_report_id', $id)->first();

        // Fetching Child 'incident_reports_follow_up_actions' Table Data .....
        $incident_reports_follow_up_actions = DB::table('incident_reports_follow_up_actions')->where('incident_report_id', $id)->get();

        // Fetching Child 'incident_reports_immediate_causes' Table Data .....
        $incident_reports_immediate_causes = DB::table('incident_reports_immediate_causes')->where('incident_report_id', $id)->first();

        // Fetching Child 'incident_reports_preventive_actions' Table Data .....
        $incident_reports_preventive_actions = DB::table('incident_reports_preventive_actions')->where('incident_report_id', $id)->first();

        // Fetching Child 'incident_reports_risk_details' Table Data .....
        $incident_reports_risk_details = DB::table('incident_reports_risk_details')->where('incident_report_id', $id)->first();

        // Fetching Child 'incident_reports_event_details' Table Data .....
        $incident_reports_root_causes = DB::table('incident_reports_root_causes')->where('incident_report_id', $id)->first();

        // Fetching Child 'incident_reports_supporting_team_members' Table Data .....
        $incident_reports_supporting_team_members = DB::table('incident_reports_supporting_team_members')->where('IRI', $id)->get();

        // Fetching Child 'incident_reports_weather' Table Data .....
        $incident_reports_weather = DB::table('incident_reports_weather')->where('incident_report_id', $id)->first();





        // Others Required Table Data's .....
        $dropdown                                 = DB::table('near_miss_dropdown')->get();
        $dropmain                                 = DB::table('near_miss_dropdown_main_type')->get();
        $crew_list                                = DB::table('crew_list')->get();
        $vessel_details                           = DB::table('vessel_details')->first();
        $created_by                               = DB::table('crew_list')->where('id', $incident_report->created_by)->first();
        $master_name                              = DB::table('crew_list')->where('id', $incident_report->master)->first();
        $chief_engineer                           = DB::table('crew_list')->where('id', $incident_report->chief_engineer)->first();
        $chief_officer                            = DB::table('crew_list')->where('id', $incident_report->chief_officer)->first();






        // Converting Image's to 'base64' .....
        $incident_image = 'N/A';

        if($incident_report->incident_image != null){
            $incident_image = (new FileSaver)->getImageBase64($incident_report->incident_image);
        }

        $risk_assesment_evaluated_file_upload = 'N/A';
        if($incident_report->five_why_risk_assesment_evaluated_file_upload != null){
            // $incident_image = $this->Convert_base64($incident_report->incident_image);
            // $incident_image = (new FileSaver)->getFile($incident_report->incident_image);
            // $incident_image = $incident_report->incident_image;
            $risk_assesment_evaluated_file_upload = (new FileSaver)->getImageBase64($incident_report->five_why_risk_assesment_evaluated_file_upload);
        }


        $followUp_image_array = array();
        foreach ($incident_reports_follow_up_actions as $follow_up_action) {

            if($follow_up_action->evidence_file != null){
                // $followUp_image_array[$follow_up_action->id] = $this->Convert_base64(DIRECTORY_SEPARATOR.'Incdent_Report_evidence_file'. DIRECTORY_SEPARATOR. $follow_up_action->evidence_file);
                // $followUp_image_array[$follow_up_action->id] = $follow_up_action->evidence_file;
                $followUp_image_array[$follow_up_action->id] = (new FileSaver)->getImageBase64($follow_up_action->evidence_file);

                Log::info("followUp_image_array : ". print_r($followUp_image_array[$follow_up_action->id], true));
            }
        }

        $logo = asset('images/TCCflagwithoutbackground.png');


        // Data Need To Printed On PDF .....
        $data = compact(
            'ID',
            'incident_report',
            'vessel_details',
            'crew_list',
            'dropdown',
            'dropmain',
            'incident_reports_crew_injury',
            'incident_reports_supporting_team_members',
            'master_name',
            'chief_engineer',
            'chief_officer',
            'created_by',
            'incident_reports_preventive_actions',
            'incident_reports_event_information',
            'incident_reports_five_why',
            'incident_reports_root_causes',
            'incident_reports_immediate_causes',
            'incident_reports_preventive_actions',
            'incident_reports_follow_up_actions',
            'incident_reports_event_details',
            'incident_reports_risk_details',
            'incident_reports_event_logs',
            'incident_reports_event_information',
            'incident_reports_weather',
            'followUp_image_array',
            'incident_image',
            'risk_assesment_evaluated_file_upload',
            'logo'
        );

        $domPdf = PDF::setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => TRUE])->loadView('incident_reporting.immediate_incident_notification_report_pdf', $data)
            ->setPaper(array(0, 0, 1080, 1080))->setWarnings(false);
        return $domPdf->stream('Report-a-' . $id . '.pdf');
    }




    function printPDFAll_incident($id)
    {

        $ID     = $id;
        $ir     = array();
        $id_arr = explode(',', $id);
        $data   = DB::table('incident_report');
        $data   = $data->leftJoin('incident_reports_crew_injury', 'incident_report.id', '=', 'incident_reports_crew_injury.incident_report_id')
            ->leftJoin('incident_reports_supporting_team_members', 'incident_report.id', '=', 'incident_reports_supporting_team_members.IRI')
            ->leftJoin('incident_reports_immediate_causes', 'incident_report.id', '=', 'incident_reports_immediate_causes.incident_report_id')
            ->leftJoin('incident_reports_preventive_actions', 'incident_report.id', '=', 'incident_reports_preventive_actions.incident_report_id')
            ->leftJoin('incident_reports_root_causes', 'incident_report.id', '=', 'incident_reports_root_causes.incident_report_id')
            ->select('incident_report.*', 'incident_reports_crew_injury.id as crew_id', 'incident_reports_crew_injury.fatality', 'incident_reports_crew_injury.lost_workday_case', 'incident_reports_crew_injury.restricted_work_case', 'incident_reports_crew_injury.medical_treatment_case', 'incident_reports_crew_injury.lost_time_injuries', 'incident_reports_crew_injury.first_aid_case', 'incident_reports_supporting_team_members.member_name', 'incident_reports_immediate_causes.primary as ic_primary', 'incident_reports_immediate_causes.secondary as ic_secondary', 'incident_reports_immediate_causes.tertiary as ic_tertiary', 'incident_reports_preventive_actions.primary as pa_primary', 'incident_reports_preventive_actions.secondary as pa_secondary', 'incident_reports_preventive_actions.tertiary as pa_tertiary', 'incident_reports_root_causes.primary as rc_primary', 'incident_reports_root_causes.secondary as rc_secondary', 'incident_reports_root_causes.tertiary as rc_tertiary')
            ->get();
        for ($i      = 0; $i < count($id_arr); $i++) {
            foreach ($data as $d) {
                if ($d->id == $id_arr[$i]) {
                    $ir[$id_arr[$i]]     = $d;
                }
            }
            //  $ir[$id_arr[$i]] = DB::table('incident_report')->find($id_arr[$i]);
            //  $ir[$id_arr[$i]] = DB::table('incident_reports_crew_injury')->find($id_arr[$i]);
            //  $ir[$id_arr[$i]] = DB::table('first_aid_case')->find($id_arr[$i]);

        }
        $pdf = PDF::loadView('incident_reporting.multiple_incident_pdf', compact('ir'));

        return $pdf->download('Report-All.pdf');
    }
    // `````````````````````````````````````````````` pdf end ````````````````````````````````````````


    // `````````````````````````````````````````````` helping function's ```````````````````````````````````````
    public function crewFinder($id)
    {
        $crew = DB::table('crew_list')->find((int)$id);
        return $crew;
    }


    public function Seacher($key)
    {
        $id_array         = array();

        // ``````````````````````` Incident report table `````````````````````````````
        $columnsForSearch = ['id', 'incident_header', 'vessel_name', 'report_no', 'created_by', 'date_of_incident', 'date_report_created', 'voy_no', 'master', 'chief_engineer', 'charterer', 'agent', 'chief_officer', 'first_engineer', 'confidential', 'media_involved', 'time_of_incident_lt', 'time_of_incident_gmt', 'crew_injury', 'other_personnel_injury', 'vessel_damage', 'cargo_damage', 'third_party_liability', 'environmental', 'commercial', 'lead_investigator', 'p_n_i_club_informed', 'h_n_m_informed', 'type_of_loss_remarks', 'incident_brief', 'comments_five_why_section', 'risk_category', 'is_evalutated',];
        $incident_report  = DB::table('incident_report');
        foreach ($columnsForSearch as $column) {
            $incident_report->select('id')
                ->orWhere("{$column}", 'LIKE', "%{$key}%");
        }
        foreach ($incident_report->get() as $ids) {
            array_push($id_array, $ids->id);
        }
        // ``````````````````````` Incident report table end `````````````````````````````
        // ``````````````````````` incident_reports_crew_injury table `````````````````````````````
        $columnsForSearch     = ['fatality', 'lost_workday_case', 'restricted_work_case', 'medical_treatment_case', 'lost_time_injuries', 'first_aid_case'];
        $incident_crew_injury = DB::table('incident_reports_crew_injury');
        foreach ($columnsForSearch as $column) {
            $incident_crew_injury->select('incident_report_id')
                ->orWhere("{$column}", 'LIKE', "%{$key}%");
        }
        foreach ($incident_crew_injury->get() as $ids) {
            array_push($id_array, $ids->incident_report_id);
        }
        // ``````````````````````` incident_reports_crew_injury table end `````````````````````````````
        // ``````````````````````` incident_reports_supporting_team_members table `````````````````````````````
        $columnsForSearch                         = ['member_name',];
        $incident_reports_supporting_team_members = DB::table('incident_reports_supporting_team_members');
        foreach ($columnsForSearch as $column) {
            $incident_reports_supporting_team_members->select('IRI')
                ->orWhere("{$column}", 'LIKE', "%{$key}%");
        }
        foreach ($incident_reports_supporting_team_members->get() as $ids) {
            array_push($id_array, $ids->IRI);
        }
        // ``````````````````````` incident_reports_supporting_team_members table end `````````````````````````````
        // ``````````````````````` incident_reports_event_information table `````````````````````````````
        $columnsForSearch                   = ['place_of_incident', 'place_of_incident_position', 'date_of_incident', 'time_of_incident_lt', 'time_of_incident_gmt', 'location_of_incident', 'operation', 'vessel_condition', 'cargo_type_and_quantity',];
        $incident_reports_event_information = DB::table('incident_reports_event_information');
        foreach ($columnsForSearch as $column) {
            $incident_reports_event_information->select('incident_report_id')
                ->orWhere("{$column}", 'LIKE', "%{$key}%");
        }
        foreach ($incident_reports_event_information->get() as $ids) {
            array_push($id_array, $ids->incident_report_id);
        }
        // ``````````````````````` incident_reports_event_information table end `````````````````````````````
        // ``````````````````````` incident_reports_weather table `````````````````````````````
        $columnsForSearch         = ['wind_force', 'wind_direction', 'sea_wave', 'sea_direction', 'swell_height', 'swell_length', 'swell_direction', 'sky', 'visibility', 'rolling', 'pitching', 'illumination',];
        $incident_reports_weather = DB::table('incident_reports_weather');
        foreach ($columnsForSearch as $column) {
            $incident_reports_weather->select('incident_report_id')
                ->orWhere("{$column}", 'LIKE', "%{$key}%");
        }
        foreach ($incident_reports_weather->get() as $ids) {
            array_push($id_array, $ids->incident_report_id);
        }
        // ``````````````````````` incident_reports_weather table end `````````````````````````````
        // ``````````````````````` incident_reports_weather table `````````````````````````````
        $columnsForSearch            = ['date', 'time', 'remarks',];
        $incident_reports_event_logs = DB::table('incident_reports_event_logs');
        foreach ($columnsForSearch as $column) {
            $incident_reports_event_logs->select('incident_report_id')
                ->orWhere("{$column}", 'LIKE', "%{$key}%");
        }
        foreach ($incident_reports_event_logs->get() as $ids) {
            array_push($id_array, $ids->incident_report_id);
        }
        // ``````````````````````` incident_reports_event_logs table end `````````````````````````````
        // ``````````````````````` incident_reports_event_details table `````````````````````````````
        $columnsForSearch               = ['details',];
        $incident_reports_event_details = DB::table('incident_reports_event_details');
        foreach ($columnsForSearch as $column) {
            $incident_reports_event_details->select('incident_report_id')
                ->orWhere("{$column}", 'LIKE', "%{$key}%");
        }
        foreach ($incident_reports_event_details->get() as $ids) {
            array_push($id_array, $ids->incident_report_id);
        }
        // ``````````````````````` incident_reports_event_details table end `````````````````````````````
        // ``````````````````````` incident_reports_risk_details table `````````````````````````````
        $columnsForSearch              = ['risk', 'severity', 'likelihood', 'result', 'name_of_person', 'type_of_injury', 'associated_cost_usd', 'associated_cost_loca', 'type_of_pollution', 'quantity_of_pollutant', 'contained_spill', 'total_spilled_quantity', 'spilled_in_water', 'spilled_ashore', 'vessel', 'cargo', 'third_party', 'damage_description', 'off_hire', 'description', 'type',];
        $incident_reports_risk_details = DB::table('incident_reports_risk_details');
        foreach ($columnsForSearch as $column) {
            $incident_reports_risk_details->select('incident_report_id')
                ->orWhere("{$column}", 'LIKE', "%{$key}%");
        }
        foreach ($incident_reports_risk_details->get() as $ids) {
            array_push($id_array, $ids->incident_report_id);
        }
        // ``````````````````````` incident_reports_risk_details table end `````````````````````````````
        // ``````````````````````` incident_reports_immediate_causes table `````````````````````````````
        $columnsForSearch                  = ['primary', 'secondary', 'tertiary',];
        $incident_reports_immediate_causes = DB::table('incident_reports_immediate_causes');
        foreach ($columnsForSearch as $column) {
            $incident_reports_immediate_causes->select('incident_report_id')
                ->orWhere("{$column}", 'LIKE', "%{$key}%");
        }
        foreach ($incident_reports_immediate_causes->get() as $ids) {
            array_push($id_array, $ids->incident_report_id);
        }
        // ``````````````````````` incident_reports_immediate_causes table end `````````````````````````````
        // ``````````````````````` incident_reports_root_causes table `````````````````````````````
        $columnsForSearch             = ['primary', 'secondary', 'tertiary',];
        $incident_reports_root_causes = DB::table('incident_reports_root_causes');
        foreach ($columnsForSearch as $column) {
            $incident_reports_root_causes->select('incident_report_id')
                ->orWhere("{$column}", 'LIKE', "%{$key}%");
        }
        foreach ($incident_reports_root_causes->get() as $ids) {
            array_push($id_array, $ids->incident_report_id);
        }
        // ``````````````````````` incident_reports_root_causes table end `````````````````````````````
        // ``````````````````````` incident_reports_preventive_actions table `````````````````````````````
        $columnsForSearch                    = ['primary', 'secondary', 'tertiary',];
        $incident_reports_preventive_actions = DB::table('incident_reports_preventive_actions');
        foreach ($columnsForSearch as $column) {
            $incident_reports_preventive_actions->select('incident_report_id')
                ->orWhere("{$column}", 'LIKE', "%{$key}%");
        }
        foreach ($incident_reports_preventive_actions->get() as $ids) {
            array_push($id_array, $ids->incident_report_id);
        }
        // ``````````````````````` incident_reports_preventive_actions table end `````````````````````````````
        // ``````````````````````` incident_reports_five_why table `````````````````````````````
        $columnsForSearch          = ['incident', 'first_why', 'second_why', 'third_why', 'fourth_why', 'fifth_why', 'root_cause',];
        $incident_reports_five_why = DB::table('incident_reports_five_why');
        foreach ($columnsForSearch as $column) {
            $incident_reports_five_why->select('incident_report_id')
                ->orWhere("{$column}", 'LIKE', "%{$key}%");
        }
        foreach ($incident_reports_five_why->get() as $ids) {
            array_push($id_array, $ids->incident_report_id);
        }
        // ``````````````````````` incident_reports_five_why table end `````````````````````````````
        // ``````````````````````` incident_reports_follow_up_actions table `````````````````````````````
        $columnsForSearch                   = ['sl_no', 'description', 'pic', 'department', 'target_date', 'completed_date', 'evidence_uploaded', 'cost', 'comments',];
        $incident_reports_follow_up_actions = DB::table('incident_reports_follow_up_actions');
        foreach ($columnsForSearch as $column) {
            $incident_reports_follow_up_actions->select('incident_report_id')
                ->orWhere("{$column}", 'LIKE', "%{$key}%");
        }
        foreach ($incident_reports_follow_up_actions->get() as $ids) {
            array_push($id_array, $ids->incident_report_id);
        }
        // ``````````````````````` incident_reports_follow_up_actions table end `````````````````````````````
        return array_unique($id_array);
    }
    public function FilterStatus($statuspick)
    {
        $id_array         = array();

        // ``````````````````````` Incident report table `````````````````````````````
        $columnsForSearch = ['id', 'incident_header', 'vessel_name', 'report_no', 'created_by', 'date_of_incident', 'date_report_created', 'voy_no', 'master', 'chief_engineer', 'charterer', 'agent', 'chief_officer', 'first_engineer', 'confidential', 'media_involved', 'time_of_incident_lt', 'time_of_incident_gmt', 'crew_injury', 'other_personnel_injury', 'vessel_damage', 'cargo_damage', 'third_party_liability', 'environmental', 'commercial', 'lead_investigator', 'p_n_i_club_informed', 'h_n_m_informed', 'type_of_loss_remarks', 'incident_brief', 'comments_five_why_section', 'risk_category', 'is_evalutated', 'status'];
        $incident_report  = DB::table('incident_report');
        foreach ($columnsForSearch as $column) {

            $incident_report->select('id')
                ->orWhere("{$column}", 'LIKE', "%{$statuspick}%");
        }
        foreach ($incident_report->get() as $ids) {
            array_push($id_array, $ids->id);
        }
        // ``````````````````````` Incident report table end `````````````````````````````
        return array_unique($id_array);
    }

    public function col($md, $col, $content, $heading)
    {
        $cont = "
                    <div class='col-$col col-md-$md'>
                        <h6 class='font-weight-bold'>$heading </h6> ";
        if (is_array($content)) {
            if (count($content) <= 0) {
                $cont .= config('constants.DATA_NOT_AVAILABLE');
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
    // `````````````````````````````````````````````` helping function's end ```````````````````````````````````````


    // ````````````````````````````````````````````` Data tables code start... ``````````````````````````````````````
    // ------------------------------------------------------------------------------------------------------------


    function getincidents(Request $req)
    {
        // $status = $req->input('status');


        // Geting main table data
        // $incident_report_data = DB::table('incident_report')->where('status', '!=', 'Draft')->orderBy('created_at', 'desc');
        $incident_report_data = DB::table('incident_report')->orderBy('updated_at', 'desc');
        $incident_report_data = $incident_report_data->where('deleted_at', '=', NULL);

        // render only perticular ship data .....
        if($req->is_ship){
            $incident_report_data = $incident_report_data->where('creator_id',$req->creator_id);
        }

        $vessel               = DB::table('vessel_details')->first();

        $totaldata            = $incident_report_data->count();
        $limit = $req->input('length');
        $start = $req->input('start');
        $totalFiltered        = $totaldata;



        // Searching Data .....
        if (empty($req->srch) == 1) {
            $incident_report      = $incident_report_data->orderBy('updated_at','DESC')->offset($start)->limit($limit)->get();
        } else {
            $search_id = $this->Seacher($req->srch);
            foreach ($search_id as $ids) {

                $incident_report_data->Where("id", 'LIKE', "%{$ids}%");
                if (session('is_ship')) {
                    $incident_report_data->where('creator_id', session('creator_id'));
                }
            }

            $incident_report = $incident_report_data->orderBy('updated_at','DESC')->offset($start)->limit($limit)->get();

            $totalFiltered   = $incident_report_data->count();
        }

        // Filtering data .....
        if (empty($req->statuspicker) == 1) {

            if (session('is_ship')) {
                $incident_report_data->where('creator_id', session('creator_id'));
            }
            $incident_report = $incident_report_data->orderBy('updated_at','DESC')->offset($start)->limit($limit)->get();
        } else {
            $search_id = $this->FilterStatus($req->statuspicker);
            foreach ($search_id as $ids) {

                $incident_report_data->orWhere("id", 'LIKE', "%{$ids}%");
            }
            if (session('is_ship')) {
                $incident_report_data->where('creator_id', session('creator_id'));
            }

            $incident_report = $incident_report_data->offset($start)->limit($limit)->get();

            $totalFiltered   = $incident_report_data->where('deleted_at', '=', NULL)
            ->count();
        }



        // Data string cooking for render on data-table in front-end .....
        $data = array();
        if (!empty($incident_report)) {
            foreach ($incident_report as $post) {
                //LOG::info('Deleted at:' . print_r($post->deleted_at, true));
                // If deleted_at is not null,then it will not show in the view
                if (!empty($post->deleted_at)) {
                    continue;
                }
                // crew injury
                $supporting_members = DB::table('incident_reports_supporting_team_members')->where('IRI', $post->id)
                ->get('member_name');
                $mem_name           = '';
                foreach ($supporting_members as $member) {
                    $mem_name .= $member->member_name . ',';
                }
                $crew_injury_data          = DB::table('incident_reports_crew_injury')->where('incident_report_id', $post->id)
                ->first();

                // 5 whys
                $root_causes               = DB::table('incident_reports_root_causes')->where('incident_report_id', $post->id)
                    ->first();
                $preventive_action         = DB::table('incident_reports_preventive_actions')->where('incident_report_id', $post->id)
                    ->first();
                $follow_up_action          = DB::table('incident_reports_follow_up_actions')->where('incident_report_id', $post->id)
                    ->get();
                $fivee_why                 = DB::table('incident_reports_five_why')->where('incident_report_id', $post->id)
                    ->first();

                // log::info($fivee_why->first_why);
                // $five_why = $fivee_why->first_why .','. $fivee_why->second_why .','. $fivee_why->third_why .','. $fivee_why->fourth_why .','. $fivee_why->fifth_why ;
                // $five_why =  explode(',', $five_why) ;
                $one                       = '';
                $two                       = '';
                $three                     = '';
                $four                      = '';
                $five                      = '';
                if ($fivee_why != null) {
                    $one                       = $fivee_why->first_why;
                    $two                       = $fivee_why->second_why;
                    $three                     = $fivee_why->third_why;
                    $four                      = $fivee_why->fourth_why;
                    $five                      = $fivee_why->fifth_why;
                }
                $five_why                  = $one . ',' . $two . ',' . $three . ',' . $four . ',' . $five;

                $five_why                  = explode(',', $five_why);

                // event log
                $event_logs                = DB::table('incident_reports_event_logs')->where('incident_report_id', $post->id)
                    ->get();

                // Event Information
                $event_report              = DB::table('incident_reports_event_information')->where('incident_report_id', $post->id)
                    ->first();
                $event_report_weather      = DB::table('incident_reports_weather')->where('incident_report_id', $post->id)
                    ->first();

                // incident investigation and root cause
                $event_details             = DB::table('incident_reports_event_details')->where('incident_report_id', $post->id)
                ->get();
                $risk_details              = DB::table('incident_reports_risk_details')->where('incident_report_id', $post->id)
                    ->first();
                $imediate_cause            = DB::table('incident_reports_immediate_causes')->where('incident_report_id', $post->id)->first();
                // Log::debug("immediate php causes ========> " . print_r($imediate_cause->primary, true));


                $ed                        = '';
                foreach ($event_details as $es) {
                    $ed .= $es->details . ',';
                }

                // ``````````````````````````````` incidnet ````````````````````
                $incident_details = "
                            <h5 class='font-weight-bold'>Incident  </h5>
                            <p> $post->incident_header </p>
                            <!-- Button trigger modal -->
                            <div class='d-flex'>
                                  <div class='containertooltip'>
                                         <button type='button' class='btn text-dark     p-1' data-toggle='modal'   data-target='#incident_details_$post->id'>
                                             <i class='fas fa-eye'>View</i>
                                         </button>
                                       <div class='container_content'>

                                                 <b class='garage-title pl-1 pr-1 pt-2' style='color: white';>INCIDENT DETAILS</b>
                                       </div>
                                       <div class='container__arrow' />

                                  </div>

                             </div>
                            <!-- Modal -->
                            <div class='modal fade' id='incident_details_$post->id' tabindex='-1' role='dialog' aria-labelledby='exampleModalLongTitle' aria-hidden='true'>
                                <div class='modal-dialog modal-lg' role='document'>
                                    <div class='modal-content'>
                                        <div class='modal-header'>
                                            <h2 class='modal-title font-weight-bold' id='exampleModalLongTitle'>Incident Details</h2> <h5>Report Id : $post->id </h5>
                                        </div>
                                        <div class='modal-body text-left'>

                                            <div class='row'>
                                                " . $this->col('3', '12', (isset($vessel->name) && $vessel->name) ? $vessel->name : config('constants.DATA_NOT_AVAILABLE'), 'Vassel Name') . "
                                                " . $this->col('3', '12', (isset($post->confidential) && $post->confidential) ? $post->confidential : 'N/A', 'Confidential') . "
                                                " . $this->col('3', '12', (isset($post->report_no) && $post->report_no) ? $post->report_no : 'N/A', 'Report Number') . "
                                                " . $this->col('3', '12', (isset($post->media_involved) && $post->media_involved) ? $post->media_involved : 'N/A', 'Media Involved') . "
                                                " . $this->col('3', '12', (isset($post->created_by_name) && $post->created_by_name) ? $post->created_by_name : 'N/A', 'Created By &#91; Name &#93') . "
                                                " . $this->col('3', '12', (isset($post->created_by_rank) && $post->created_by_rank) ? $post->created_by_rank : 'N/A',
                        'Created By &#91; Rank &#93'
                    ) . "
                                                " . $this->col('3', '12', (isset($post->date_of_incident) && $post->date_of_incident) ? $post->date_of_incident : 'N/A', 'Date of incident') . "
                                                " . $this->col('3', '12', (isset($post->time_of_incident_lt) && $post->time_of_incident_lt) ? $post->time_of_incident_lt : 'N/A', 'Time of incident') . "
                                                " . $this->col('3', '12', (isset($post->date_report_created) && $post->date_report_created) ? $post->date_report_created : 'N/A', 'Date report created') . "
                                                " . $this->col('3', '12', (isset($post->time_of_incident_gmt) && $post->time_of_incident_gmt) ? $post->time_of_incident_gmt : 'N/A', 'GMT') . "
                                                " . $this->col('3', '12', (isset($post->voy_no) && $post->voy_no) ? $post->voy_no : 'N/A', 'Voy No') . "
                                                " . $this->col('3', '12', (isset($this->crewFinder($post->master)
                    ->name) && $this->crewFinder($post->master)
                    ->name) ? $this->crewFinder($post->master)->name : 'N/A', 'Master') . "
                                                " . $this->col('3', '12', (isset($this->crewFinder($post->chief_officer)
                    ->name) && $this->crewFinder($post->chief_officer)
                        ->name) ? $this->crewFinder($post->chief_officer)->name : 'N/A', 'Chief officer') . "
                                                " . $this->col('3', '12', (isset($this->crewFinder($post->chief_engineer)
                    ->name) && $this->crewFinder($post->chief_engineer)
                    ->name) ? $this->crewFinder($post->chief_engineer)->name : 'N/A', 'Chief Engineer') . "
                                                " . $this->col('3', '12', (isset($this->crewFinder($post->first_engineer)
                    ->name) && $this->crewFinder($post->first_engineer)
                    ->name) ? $this->crewFinder($post->first_engineer)->name : 'N/A', '1st Eng.') . "
                                                " . $this->col('3',
                        '12',
                        (isset($post->charterer) && $post->charterer) ? $post->charterer : 'N/A',
                        'Charterer'
                    ) . "
                                                " . $this->col('3', '12', (isset($post->agent) && $post->agent) ? $post->agent : 'N/A', 'Agent (if any)') . "
                                                " . $this->col('3', '12', (isset($post->vessel_damage) && $post->vessel_damage) ? $post->vessel_damage : 'N/A', 'Vessel_Damage') . "
                                                " . $this->col('3', '12', (isset($post->cargo_damage) && $post->cargo_damage) ? $post->cargo_damage : 'N/A', 'Cargo damage') . "
                                                " . $this->col('3', '12', (isset($post->third_party_liability) && $post->third_party_liability) ? $post->third_party_liability : 'N/A', 'Third Party Liability') . "
                                                " . $this->col('3', '12', (isset($post->environmental) && $post->environmental) ? $post->environmental : 'N/A', 'Environmental') . "
                                                " . $this->col('12', '12', (isset($post->commercial) && $post->commercial) ? $post->commercial : 'N/A', 'Commercial/Service') . "
                                            </div>


                                            <div class='modal-footer'>
                                                <button type='button' class='btn btn-danger   -close' data-dismiss='modal'><i class='far fa-times-circle mr-1'></i>Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        ";
                // ``````````````````````````````` incidnet End ````````````````````

                // Incident drawerjs image convert into base64 .....
                if($post->incident_image != null){
                    $incident_image = (new FileSaver)->getImageBase64($post->incident_image);
                }else{$incident_image = null;}

                // Action
                // ============================
                $Action = "";
                if($event_report){
                    $Action .= "<div class='row mt-3'>
                                    <a href='' class='btn download ' title = 'Modal' data-toggle='modal' data-target='#alertModal_$post->id'>
                                        <i class='fas fa-eye'></i>
                                    </a>
                                    <a href='/myPdfFrom/$post->id' class='btn download ml-1' title = 'Download' >
                                        <i class='fas fa-arrow-down'></i>
                                    </a>
                                </div>
                                <!-- Immediate Accident Notification Report
                                ==================================================-->
                                <div class='modal fade' id='alertModal_$post->id' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'>
                                <div class='modal-dialog modal-dialog-centered modal-xl' role='document'>
                                    <div class='modal-content'>
                                    <div class='modal-header text-center'>
                                        <h1 class='modal-title text-center mx-auto' id='exampleModalLabel'> <img height='50' weight='50' src='".asset('images/TCCflagwithoutbackground.png')."'/> &nbsp;&nbsp; Immediate Accident Notification Report <br> <span style='color:red'>$post->incident_header </span> </h1>
                                        <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                                        <span aria-hidden='true'>&times;</span>
                                        </button>
                                    </div>
                                    <div class='modal-body'>

                                    <table class='text-center w-100' style='border: 1px solid black;'>
                                            <tr>
                                                <th style='border: 1px solid black;'>ID : $post->id</th>
                                                <th style='border: 1px solid black;'>Incident categorization :

                                                    <br><br>
                                                    Vessel Damage :
                                                    $post->vessel_damage
                                                    <br><br>
                                                    Cargo Damage :
                                                    $post->cargo_damage
                                                    <br><br>
                                                    Third Party Liability :
                                                    $post->third_party_liability
                                                    <br><br>
                                                    Environmental :
                                                    $post->environmental
                                                    <br><br>
                                                    Commercial/ Service Affected :
                                                    $post->commercial
                                                    <br><br>
                                                    Crew Injury :
                                                    $post->crew_injury
                                                    <br><br>
                                                    Third Party Personal Inujury :
                                                    $post->other_personnel_injury

                                                </th>
                                            </tr>
                                            <tr>
                                                <th style='border: 1px solid black; padding:30px;'>
                                                    <label for='message-text' class='col-form-label'>Date : <br>  $post->date_of_incident <br> Time :<br>  $post->time_of_incident_lt </label>
                                                </th>
                                                <th rowspan='3' style='border: 1px solid black; padding:30px;'>
                                                    <label for='message-text' class='col-form-label'>Incident Description :<br>  $post->incident_brief</label>
                                                </th>
                                            </tr>
                                            <tr>
                                                <th style='border: 1px solid black; padding:30px;'>
                                                    <label for='message-text' class='col-form-label'>Activity :<br>     $event_report->operation </label>
                                                </th>
                                            </tr>
                                            <tr>
                                                <th style='border: 1px solid black; padding:30px;'>
                                                    <label for='message-text' class='col-form-label'>Location :<br> 
                                                    $event_report->location_of_incident </label>
                                                </th>
                                            </tr>
                                            <tr>
                                                <th colspan='2' style='border: 1px solid black; padding:30px;'>
                                                    <div class='form-group'>
                                                        <label for='message-text' class='col-form-label'>Immediate actions to be taken:</label>
                                                        <textarea class='form-control' id='immediate_action_to_be_taken_$post->id'> $post->Immediate_action_to_be_taken</textarea>
                                                    </div>
                                                </th>
                                            </tr>
                                            <tr>
                                                <th colspan='2' style='border: 1px solid black; padding:30px;'>
                                                    <img src='$incident_image'   style='width:10rem; height:10rem'/>
                                                </th>
                                            </tr>
                                        </table>



                                        </form>
                                    </div>
                                    <div class='modal-footer'>
                                        <button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
                                        <button type='button' class='btn btn-primary' id='save_modal' onclick=updateModalData('$post->id')>Save</button>
                                    </div>
                                    </div>
                                </div>
                            </div>

                    ";
                }
                $Action           .= "
                        <!-- Report Preview
                        =========================-->
                       <div class='row mt-3'>
                        <div>



                        <!-- Modal -->
                        <div class='modal fade w-100' id='prev_$post->id' tabindex='-1' aria-labelledby='exampleModalLabel' aria-hidden='true'>
                            <div class='modal-dialog modal-lg w-100' role='document'>
                                <div class='modal-content w-100'>
                                <div class='modal-header'>
                                    <h2 class='modal-title font-weight-bold' id='exampleModalLabel'>Preview</h2> <h5>Report Id : $post->id </h5>
                                </div>
                                <div class='modal-body'>

                                    <h2 class='text-center my-5 font-weight-bold'> Incident </h2>
                                        <div class='row'>
                                            " . $this->col('3', '12', (isset($vessel->name) && $vessel->name) ? $vessel->name : 'N/A', 'Vassel Name') . "
                                            " . $this->col('3', '12', (isset($post->confidential) && $post->confidential) ? $post->confidential : 'N/A',
                        'Confidential'
                    ) . "
                                            " . $this->col('3', '12', (isset($post->report_no) && $post->report_no) ? $post->report_no : 'N/A', 'Report Number') . "
                                            " . $this->col('3', '12', (isset($post->media_involved) && $post->media_involved) ? $post->media_involved : 'N/A', 'Media Involved') . "
                                            " . $this->col('3', '12', (isset($post->created_by_name) && $post->created_by_name) ? $post->created_by_name : 'N/A', 'Created By &#91; Name &#93') . "
                                            " . $this->col('3', '12', (isset($post->created_by_rank) && $post->created_by_rank) ? $post->created_by_rank : 'N/A', 'Created By &#91; Rank &#93') . "
                                            " . $this->col('3', '12', (isset($post->date_of_incident) && $post->date_of_incident) ? $post->date_of_incident : 'N/A', 'Date of incident') . "
                                            " . $this->col('3', '12', (isset($post->time_of_incident_lt) && $post->time_of_incident_lt) ? $post->time_of_incident_lt : 'N/A', 'Time of incident') . "
                                            " . $this->col('3', '12', (isset($post->date_report_created) && $post->date_report_created) ? $post->date_report_created : 'N/A', 'Date report created') . "
                                            " . $this->col('3', '12', (isset($post->time_of_incident_gmt) && $post->time_of_incident_gmt) ? $post->time_of_incident_gmt : 'N/A', 'GMT') . "
                                            " . $this->col('3', '12', (isset($post->voy_no) && $post->voy_no) ? $post->voy_no : 'N/A', 'Voy No') . "
                                            " . $this->col('3', '12', (isset($this->crewFinder($post->master)
                    ->name) && $this->crewFinder($post->master)
                    ->name) ? $this->crewFinder($post->master)->name : 'N/A', 'Master') . "
                                            " . $this->col('3', '12', (isset($this->crewFinder($post->chief_officer)
                    ->name) && $this->crewFinder($post->chief_officer)
                        ->name) ? $this->crewFinder($post->chief_officer)->name : 'N/A',
                        'Chief officer'
                    ) . "
                                            " . $this->col('3', '12',
                        (isset($this->crewFinder($post->chief_engineer)
                        ->name) && $this->crewFinder($post->chief_engineer)
                        ->name) ? $this->crewFinder($post->chief_engineer)->name : 'N/A',
                        'Chief Engineer'
                    ) . "
                                            " . $this->col('3', '12', (isset($this->crewFinder($post->first_engineer)
                    ->name) && $this->crewFinder($post->first_engineer)
                    ->name) ? $this->crewFinder($post->first_engineer)->name : 'N/A', '1st Eng.') . "
                                            " . $this->col('3', '12', (isset($post->charterer) && $post->charterer) ? $post->charterer : 'N/A', 'Charterer') . "
                                            " . $this->col('3', '12', (isset($post->agent) && $post->agent) ? $post->agent : 'N/A', 'Agent (if any)') . "
                                            " . $this->col('3', '12', (isset($post->vessel_damage) && $post->vessel_damage) ? $post->vessel_damage : 'N/A', 'Vessel Damage') . "
                                            " . $this->col('3', '12', (isset($post->cargo_damage) && $post->cargo_damage) ? $post->cargo_damage : 'N/A', 'Cargo damage') . "
                                            " . $this->col('3', '12', (isset($post->third_party_liability) && $post->third_party_liability) ? $post->third_party_liability : 'N/A', 'Third Party Liability') . "
                                            " . $this->col('3', '12', (isset($post->environmental) && $post->environmental) ? $post->environmental : 'N/A', 'Environmental') . "
                                            " . $this->col('12', '12', (isset($post->commercial) && $post->commercial) ? $post->commercial : 'N/A', 'Commercial/Service') . "
                                        </div>
                                    <hr>

                                    <h2 class='text-center my-5 font-weight-bold'> Crew Injury </h2>
                                        <div class='row'>
                                        " . $this->col('3', '12', (isset($post->crew_injury) && $post->crew_injury) ? $post->crew_injury : '', 'Crew Injury') . "
                                        " . $this->col('3', '12', (isset($post->other_personnel_injury) && $post->other_personnel_injury) ? $post->other_personnel_injury : '', 'Other Personal Injury') . "

                                        " . $this->col('3', '12', (isset($crew_injury_data->fatality) && $crew_injury_data->fatality) ? $crew_injury_data->fatality : '', 'Fatality') . "
                                        " . $this->col('3', '12', (isset($crew_injury_data->lost_workday_case) && $crew_injury_data->lost_workday_case) ? $crew_injury_data->lost_workday_case : '', 'Lost Workday Case') . "
                                        " . $this->col('3', '12', (isset($crew_injury_data->restricted_work_case) && $crew_injury_data->restricted_work_case) ? $crew_injury_data->restricted_work_case : '', 'Restricted Work Case') . "
                                        " . $this->col('3', '12', (isset($crew_injury_data->medical_treatment_case) && $crew_injury_data->medical_treatment_case) ? $crew_injury_data->medical_treatment_case : '', 'Medical Treatment Case') . "
                                        " . $this->col('3', '12', (isset($crew_injury_data->lost_time_injuries) && $crew_injury_data->lost_time_injuries) ? $crew_injury_data->lost_time_injuries : '', 'Lost Time Injuries') . "
                                        " . $this->col('3', '12', (isset($crew_injury_data->first_aid_case) && $crew_injury_data->first_aid_case) ? $crew_injury_data->first_aid_case : '', 'First Aid Case') . "

                                        " . $this->col('3', '12', (isset($post->lead_investigator) && $post->lead_investigator) ? $post->lead_investigator : '', 'Lead Investigator') . "
                                        " . $this->col('3', '12', explode(',', $mem_name), 'Supporting Team Members') . "


                                        </div>
                                    <hr>

                                    <h2 class='text-center my-5 font-weight-bold'> Vessel Details </h2>
                                        <div class='row'>
                                            " . $this->col('3', '12', (isset($vessel->name) && $vessel->name) ? $vessel->name : '', 'Name') . "
                                            " . $this->col('3', '12', (isset($vessel->name) && $vessel->name) ? $vessel->vessel_code : '', 'Vessel Code') . "
                                            " . $this->col('3',
                        '12',
                        (isset($vessel->name) && $vessel->name) ? $vessel->class_society : '',
                        'Class Society'
                    ) . "
                                            " . $this->col('3', '12', (isset($vessel->name) && $vessel->name) ? $vessel->imo_no : '', 'IMO NO') . "
                                            " . $this->col('3', '12', (isset($vessel->name) && $vessel->name) ? $vessel->year_built : '', 'Year Built') . "
                                            " . $this->col('3', '12', (isset($vessel->name) && $vessel->name) ? $vessel->type : '', 'Type') . "
                                            " . $this->col('3', '12', (isset($vessel->name) && $vessel->name) ? $vessel->owner : '', 'Owner') . "
                                            " . $this->col('3', '12', (isset($vessel->name) && $vessel->name) ? $vessel->hull_no : '', 'Hull No') . "
                                            " . $this->col('3', '12',
                        (isset($vessel->name) && $vessel->name) ? $vessel->grt : '',
                        'GRT'
                    ) . "
                                            " . $this->col('3', '12', (isset($vessel->name) && $vessel->name) ? $vessel->call_sign : '', 'Call Sign') . "
                                            " . $this->col('3', '12',
                        (isset($vessel->name) && $vessel->name) ? $vessel->flag : '',
                        'Flag'
                    ) . "
                                            " . $this->col('3', '12', (isset($vessel->name) && $vessel->name) ? $vessel->nrt : '', 'NRT') . "
                                            " . $this->col('3', '12', (isset($vessel->name) && $vessel->name) ? $vessel->length : '', 'Length') . "
                                            " . $this->col('3', '12', (isset($vessel->name) && $vessel->name) ? $vessel->port_of_registry : '', 'Port Of Registry') . "
                                            " . $this->col('3', '12', (isset($vessel->name) && $vessel->name) ? $vessel->breadth : '', 'Breadth') . "
                                            " . $this->col('3', '12', (isset($vessel->name) && $vessel->name) ? $vessel->moulded_depth : '', 'Moduled Depth') . "
                                        </div>
                                    <hr>

                                    <h2 class='text-center my-5 font-weight-bold'> Event Information </h2>
                                        <div class='row'>
                                            " . $this->col('3', '12', (isset($event_report->place_of_incident) && $event_report->place_of_incident) ? $event_report->place_of_incident : '', 'Place of the incident') . "
                                            " . $this->col('3', '12', (isset($event_report->place_of_incident_position) && $event_report->place_of_incident_position) ? $event_report->place_of_incident_position : '', 'Position in Lat /Long') . "
                                            " . $this->col('3', '12', (isset($event_report->nadate_of_incidentme) && $event_report->date_of_incident) ? $event_report->date_of_incident : '', 'Date of incident') . "
                                            " . $this->col('3', '12', (isset($event_report->time_of_incident_lt) && $event_report->time_of_incident_lt) ? $event_report->time_of_incident_lt : '', 'Time of incident') . "
                                            " . $this->col('3', '12', (isset($event_report->time_of_incident_gmt) && $event_report->time_of_incident_gmt) ? $event_report->time_of_incident_gmt : '', 'GMT') . "
                                            " . $this->col('3', '12', (isset($event_report->location_of_incident) && $event_report->location_of_incident) ? $event_report->location_of_incident : '', 'Location of incident') . "
                                            " . $this->col('3', '12', (isset($event_report->operation) && $event_report->operation) ? $event_report->operation : '', 'Operation') . "
                                            " . $this->col('3', '12', (isset($event_report->vessel_condition) && $event_report->vessel_condition) ? $event_report->vessel_condition : '', 'Vessel Condition') . "
                                            " . $this->col('3', '12', (isset($event_report->cargo_type_and_quantity) && $event_report->cargo_type_and_quantity) ? $event_report->cargo_type_and_quantity : '', 'Cargo type and quantity') . "
                                            " . $this->col('3', '12', (isset($event_report_weather->wind_force) && $event_report_weather->wind_force) ? $event_report_weather->wind_force : '', 'Wind force') . "
                                            " . $this->col('3', '12', (isset($event_report_weather->wind_direction) && $event_report_weather->wind_direction) ? $event_report_weather->wind_direction : '', 'Wind Direction(Degree)') . "
                                            " . $this->col('3', '12', (isset($event_report_weather->sea_wave) && $event_report_weather->sea_wave) ? $event_report_weather->sea_wave : '', 'Sea') . "
                                            " . $this->col('3', '12', (isset($event_report_weather->sea_direction) && $event_report_weather->sea_direction) ? $event_report_weather->sea_direction : '', 'Sea Direction(Degree)') . "
                                            " . $this->col('3', '12', (isset($event_report_weather->swell_height) && $event_report_weather->swell_height) ? $event_report_weather->swell_height : '', 'Swell Height') . "
                                            " . $this->col('3', '12', (isset($event_report_weather->swell_length) && $event_report_weather->swell_length) ? $event_report_weather->swell_length : '', 'Swell Length') . "
                                            " . $this->col('3', '12', (isset($event_report_weather->swell_direction) && $event_report_weather->swell_direction) ? $event_report_weather->swell_direction : '', 'Swell Direction') . "
                                            " . $this->col('3', '12', (isset($event_report_weather->sky) && $event_report_weather->sky) ? $event_report_weather->sky : '', 'Sky') . "
                                            " . $this->col('3', '12', (isset($event_report_weather->visibility) && $event_report_weather->visibility) ? $event_report_weather->visibility : '', 'Visibility') . "
                                            " . $this->col('3', '12', (isset($event_report_weather->rolling) && $event_report_weather->rolling) ? $event_report_weather->rolling : '', 'Rolling') . "
                                            " . $this->col('3', '12', (isset($event_report_weather->pitching) && $event_report_weather->pitching) ? $event_report_weather->pitching : '', 'Pitching') . "
                                            " . $this->col('4', '12', (isset($event_report_weather->illumination) && $event_report_weather->illumination) ? $event_report_weather->illumination : '', 'Illumination') . "
                                            " . $this->col('4', '12', (isset($post->p_n_i_club_informed) && $post->p_n_i_club_informed) ? $post->p_n_i_club_informed : '', 'P&I Club informed') . "
                                            " . $this->col('4', '12', (isset($post->h_n_m_informed) && $post->h_n_m_informed) ? $post->h_n_m_informed : '', 'H&M Informed') . "
                                            " . $this->col('12', '12', (isset($post->type_of_loss_remarks) && $post->type_of_loss_remarks) ? $post->type_of_loss_remarks : '', 'Remarks') . "
                                        </div>
                                    <hr>

                                    <h2 class='text-center my-5 font-weight-bold'> Incident In Brief </h2>
                                        <div class='row'>
                                            " . $this->col('3', '12', (isset($post->incident_brief) && $post->incident_brief) ? $post->incident_brief : '',
                        ''
                    ) . "
                                        </div>
                                    <hr>

                                    <h2 class='text-center my-5 font-weight-bold'> Event Log </h2>
                                        <table class='table table-borderless '>
                                            <thead>
                                                <tr>
                                                    <th scope='col'>Date</th>
                                                    <th scope='col'>Time</th>
                                                    <th scope='col'>Remarks</th>
                                                </tr>
                                            </thead>
                                            <tbody>";
                foreach ($event_logs as $elog) {
                    $Action .= "
                                                    <tr>
                                                        <th>$elog->date</th>
                                                        <td>$elog->time</td>
                                                        <td>$elog->remarks</td>
                                                    </tr>";
                }

                $Action .= "
                                            </tbody>
                                        </table>
                                    <hr>

                                    <h2 class='text-center my-5 font-weight-bold'> Incident investigartion and root cause </h2>
                                        <div class='row'>
                                            " . $this->col('3', '12', $ed, 'Event Details') . "
                                            " . $this->col('3', '12', (isset($post->risk_category) && $post->risk_category) ? $post->risk_category : '', 'Risk Category') . "
                                            " . $this->col('3', '12', (isset($risk_details->risk) && $risk_details->risk) ? $risk_details->risk : '', 'Risk') . "
                                            " . $this->col('3', '12', (isset($risk_details->severity) && $risk_details->severity) ? $risk_details->severity : '', 'Severity') . "
                                            " . $this->col('3', '12', (isset($risk_details->likelihood) && $risk_details->likelihood) ? $risk_details->likelihood : '', 'Likelihood') . "
                                            " . $this->col('3', '12', (isset($risk_details->result) && $risk_details->result) ? $risk_details->result : '', 'Result') . "
                                            " . $this->col('3', '12', (isset($risk_details->name_of_person) && $risk_details->name_of_person) ? $risk_details->name_of_person : '', 'Name Of The Person') . "
                                            " . $this->col('3', '12', (isset($risk_details->type_of_injury) && $risk_details->type_of_injury) ? $risk_details->type_of_injury : '', 'Type Of Injury') . "
                                            " . $this->col('3', '12', (isset($risk_details->type_of_pollution) && $risk_details->type_of_pollution) ? $risk_details->type_of_pollution : '', 'Type Of Pollution') . "
                                            " . $this->col('3', '12', (isset($risk_details->quantity_of_pollutant) && $risk_details->quantity_of_pollutant) ? $risk_details->quantity_of_pollutant : '', 'Quantity Of Pollutant') . "
                                            " . $this->col('3', '12', (isset($risk_details->contained_spill) && $risk_details->contained_spill) ? $risk_details->contained_spill : '', 'Contained Spill') . "
                                            " . $this->col('3', '12', (isset($risk_details->total_spilled_quantity) && $risk_details->total_spilled_quantity) ? $risk_details->total_spilled_quantity : '', 'Total Spilled Quantity') . "
                                            " . $this->col('3', '12', (isset($risk_details->spilled_in_water) && $risk_details->spilled_in_water) ? $risk_details->spilled_in_water : '', 'Spilled In Water') . "
                                            " . $this->col('3', '12', (isset($risk_details->spilled_ashore) && $risk_details->spilled_ashore) ? $risk_details->spilled_ashore : '', 'Spilled In Ashore') . "
                                            " . $this->col('3', '12', (isset($risk_details->off_hire) && $risk_details->off_hire) ? $risk_details->off_hire : '',
                    'Off Hire'
                ) . "

                                " . $this->col('3', '12', (isset($risk_details->damage_description) && $risk_details->damage_description) ? $risk_details->damage_description : '', 'Damage Description') . "
                                " . $this->col('3', '12', (isset($risk_details->vessel) && $risk_details->vessel) ? $risk_details->vessel : '', 'Vessel') . "
                                " . $this->col('3', '12', (isset($risk_details->cargo) && $risk_details->cargo) ? $risk_details->cargo : '', 'Cargo') . "
                                " . $this->col('3', '12', (isset($risk_details->third_party) && $risk_details->third_party) ? $risk_details->third_party : '', 'Third Party') . "
                                " . $this->col('12', '12', (isset($risk_details->description) && $risk_details->description) ? $risk_details->description : '', 'Description') . "
                                " . $this->col('6', '12', (isset($risk_details->type) && $risk_details->type) ? $risk_details->type : '', 'Type') . "
                                " . $this->col('6', '12', (isset($risk_details->type_of_injury) && $risk_details->type_of_injury) ? $risk_details->type_of_injury : '', 'Type Of Injury') . "
                                " . $this->col('4', '12', (isset($risk_details->associated_cost_usd) && $risk_details->associated_cost_usd) ? $risk_details->associated_cost_usd : '', 'Associated cost(USD)') . "
                                " . $this->col('4', '12', (isset($risk_details->currency_code) && $risk_details->currency_code) ? $risk_details->currency_code : '', 'Currency') . "
                                " . $this->col('4', '12', (isset($risk_details->associated_cost_loca) && $risk_details->associated_cost_loca) ? $risk_details->associated_cost_loca : '', 'Associated cost(Local)') . "
                                " . $this->col('4', '12', (isset($imediate_cause->primary)) ? $imediate_cause->primary : '', 'Immediate Cause &#91; Primary &#93') . "
                                " . $this->col('4', '12', (isset($imediate_cause->secondary)) ? $imediate_cause->secondary : '', 'Immediate Cause &#91; Secondary &#93') . "
                                " . $this->col('4', '12', (isset($imediate_cause->tertiary)) ? $imediate_cause->tertiary : '', 'Immediate Cause &#91; Tertiary &#93') . "
                                </div>
                                <hr>
                                <h2 class='text-center my-5 font-weight-bold'> 5 Why's </h2>
                                <div class='row'>
                                " . $this->col('4', '12', (isset($fivee_why->incident) && $fivee_why->incident) ? $fivee_why->incident : '', 'Incident') . "
                                " . $this->col('4', '12', $five_why, 'Five Why') . "
                                " . $this->col('4', '12', (isset($fivee_why->root_cause) && $fivee_why->root_cause) ? $fivee_why->root_cause : '', 'Root Cause') . "
                                " . $this->col('3', '12', (isset($post->is_evalutated) && $post->is_evalutated) ? (($post->is_evalutated == 'Yes') ? $post->is_evalutated . '<br> <br> <img src="/getFile?path=' . $post->five_why_risk_assesment_evaluated_file_upload . '" height="100" width="100">' : $post->is_evalutated) : '', 'Risk assesment evaluated') . "
                                <div class='col-12'>
                                <table class='table'>
                                <thead>
                                <tr>
                                    <th scope='col'>Sr No</th>
                                    <th scope='col'>Description</th>
                                    <th scope='col'>PIC</th>
                                    <th scope='col'>Department</th>
                                    <th scope='col'>Target Date</th>
                                    <th scope='col'>Completed Date</th>
                                    <th scope='col'>Evidence Uploaded</th>
                                    <th scope='col'>Cost</th>
                                    <th scope='col'>Comments</th>
                                </tr>
                                </thead>
                                <tbody>


                                                    ";
                $followup_action_NO = 0;
                foreach ($follow_up_action as $follow) {
                    $followup_action_NO ++;
                    $Action .= "
                                                            <tr>
                                                                <th scope='row'> $followup_action_NO </th>
                                                                <td>$follow->description</td>
                                                                <td>$follow->pic</td>
                                                                <td>$follow->department</td>
                                                                <td>$follow->target_date</td>
                                                                <td>$follow->completed_date</td>
                                                                <td>$follow->evidence_uploaded <br> ";
                    if ($follow->evidence_file != '') {
                        $Action .= "<b>Image </b> <br> <img src='/getFile?path=$follow->evidence_file' height='100' width='100'> <br>
                                                                            <a download class='btn btn-primary   text-light' href='/downloadRaPdfQstring?path=$follow->evidence_file'>Download </a> <br>";
                    }

                                           $Action .= "    </td>    <td>$follow->cost</td>
                                                                <td>$follow->comments</td>
                                                            </tr>";
                }
                $Action .= "


                                </tbody>
                                </table>
                                </div>
                                " . $this->col('4', '12', (isset($root_causes->primary)) ? $root_causes->primary : 'N/A', 'Root Causes &#91; Primary  &#93;') . "
                                " . $this->col('4', '12', (isset($root_causes->secondary)) ? $root_causes->secondary : 'N/A', 'Root Causes &#91; Secondary  &#93;') . "
                                " . $this->col('4', '12', (isset($root_causes->tertiary)) ? $root_causes->tertiary : 'N/A', 'Root Causes &#91; Tertiary    &#93;') . "
                                " . $this->col('4', '12', (isset($preventive_action->primary)) ? $preventive_action->primary : 'N/A', 'Preventive Action  &#91; Primary &#93;') . "
                                " . $this->col('4', '12', (isset($preventive_action->secondary)) ? $preventive_action->secondary : 'N/A', 'Preventive Action  &#91; Secondary &#93;') . "
                                " . $this->col('4', '12', (isset($preventive_action->tertiary)) ? $preventive_action->tertiary : 'N/A', 'Preventive Action  &#91; Tertiary   &#93;') . "
                                <div class='my-3'>
                                " . $this->col('12', '12', (isset($post->comments_five_why_section) && $post->comments_five_why_section) ? $post->comments_five_why_section : '', 'Comments') . "
                                </div>
                                </div>
                                </div>
                                <div class='modal-footer'>
                                <button type='button' class='btn btn-danger  -close  ' data-dismiss='modal'><i class='far fa-times-circle mr-1'></i> Close</button>
                                </div>
                                </div>
                                </div>
                                </div>";


                                $Action .="
                                        <!-- Print Button
                                        =========================-->
                                            <a href='/myPdf/" . $post->id . "' title = 'Print' class='btn print  ml2'>
                                                <i class='fas fa-print'></i> 
                                            </a>
                                        </div>
                                        </div>
                                    ";

                               $Action .= " <div class = 'row mt-3'>
                                <!-- Edit Button
                                ========================= -->
                                <a href='/incident-reporting/edit/" . $post->id . "' class='btn    edit  ' title = 'Edit'>
                                    <i class='fas fa-edit'></i>
                                </a>
                                <!-- Delete Button
                                    =========================-->
                                <button type='button' class='btn    ml-2 delete' title = 'Delete' data-toggle='modal' data-target='#delete_" . $post->id . "'>
                                <i class='fas fa-trash-alt'></i>
                                </button>
                                <div class='modal fade' id='delete_" . $post->id . "' tabindex='-1' aria-labelledby='exampleModalLabel' aria-hidden='true'>
                                    <div class='modal-dialog modal-dialog-centered'>
                                        <div class='modal-content'>
                                            <div class='modal-body p-5'>
                                            <h1 class='text-center  '><i class='fas fa-trash-alt'></i></h1>
                                            <h3 class='text-center my-3'> Do you want to delete?</h3>
                                            <button style='border: 1px solid #00000093' type='button' class='btn btn-light shadow mx-3 w-25' data-dismiss='modal'>No</button>
                                            <a style='border: 1px solid #099b6393' href=/incident-reporting/delete/$post->id class='w-25 btn shadow  '>Yes</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                </div>


                ";

                // ```````````````````````````````` Vessel Details ``````````````````````````
                $vessel_details = "
                            <!-- Button trigger modal -->

                            <div class='d-flex'>
                                    <div class='containertooltip'>
                                         <button type='button' class='btn text-dark     p-1' data-toggle='modal'   data-target='#vessel_$post->id'>
                                            <i class='fas fa-eye'>View</i>
                                          </button>
                                         <div class='container__content'>

                                           <b class='garage-title pl-1 pr-1 pt-2' style='color: white';>VESSEL DETAILS</b>
                                           </div>
                                             <div class='container__arrow' />
                                     </div>

                            </div>













                            <!-- Modal -->
                            <div class='modal fade' id='vessel_$post->id' tabindex='-1' role='dialog' aria-labelledby='exampleModalLongTitle' aria-hidden='true'>
                                <div class='modal-dialog modal-lg' role='document'>
                                    <div class='modal-content'>
                                    <div class='modal-header'>
                                        <h2 class='modal-title font-weight-bold' id='exampleModalLongTitle'>Vessel Details</h2>
                                    </div>
                                    <div class='modal-body text-left'>


                                        <div class='row'>
                                            " . $this->col('3', '12', (isset($vessel->name) && $vessel->name) ? $vessel->name : '', 'Name') . "
                                            " . $this->col('3', '12', (isset($vessel->name) && $vessel->name) ? $vessel->vessel_code : '', 'Vessel Code') . "
                                            " . $this->col('3',
                    '12',
                    (isset($vessel->name) && $vessel->name) ? $vessel->class_society : '',
                    'Class Society'
                ) . "
                                            " . $this->col('3', '12', (isset($vessel->name) && $vessel->name) ? $vessel->imo_no : '', 'IMO NO') . "
                                            " . $this->col('3', '12', (isset($vessel->name) && $vessel->name) ? $vessel->year_built : '', 'Year Built') . "
                                            " . $this->col('3', '12', (isset($vessel->name) && $vessel->name) ? $vessel->type : '', 'Type') . "
                                            " . $this->col('3', '12', (isset($vessel->name) && $vessel->name) ? $vessel->owner : '', 'Owner') . "
                                            " . $this->col('3', '12', (isset($vessel->name) && $vessel->name) ? $vessel->hull_no : '', 'Hull No') . "
                                            " . $this->col('3', '12',
                        (isset($vessel->name) && $vessel->name) ? $vessel->grt : '',
                        'GRT'
                    ) . "
                                            " . $this->col('3', '12', (isset($vessel->name) && $vessel->name) ? $vessel->call_sign : '', 'Call Sign') . "
                                            " . $this->col('3', '12',
                        (isset($vessel->name) && $vessel->name) ? $vessel->flag : '',
                        'Flag'
                    ) . "
                                            " . $this->col('3', '12', (isset($vessel->name) && $vessel->name) ? $vessel->nrt : '', 'NRT') . "
                                            " . $this->col('3', '12', (isset($vessel->name) && $vessel->name) ? $vessel->length : '', 'Length') . "
                                            " . $this->col('3', '12', (isset($vessel->name) && $vessel->name) ? $vessel->port_of_registry : '', 'Port Of Registry') . "
                                            " . $this->col('3', '12', (isset($vessel->name) && $vessel->name) ? $vessel->breadth : '', 'Breadth') . "
                                            " . $this->col('3', '12', (isset($vessel->name) && $vessel->name) ? $vessel->moulded_depth : '', 'Moduled Depth') . "
                                        </div>

                                    </div>
                                    <div class='modal-footer'>
                                        <button type='button' class='btn btn-danger   -close' data-dismiss='modal'> <i class='far fa-times-circle mr-1'></i>Close</button>
                                    </div>
                                    </div>
                                </div>
                            </div>

                        ";
                // ```````````````````````````````` Vessel Details End ``````````````````````````

                // ```````````````````````````````` Crew   injury ``````````````````````````
                $Crew_injury    = "
                        <div>
                            <h6 class='font-weight-bold'>Crew Injury</h6>
                            $post->crew_injury
                            <h6 class='font-weight-bold mt-3'>Other Personal Injury</h5>
                            $post->other_personnel_injury
                        </div>
                        ";

                if ($post->crew_injury == 'Yes') {
                    $Crew_injury .= "
                                <!-- Button trigger modal -->
                                <div class='d-flex'>
                                    <button type='button' class='btn text-dark     p-1' data-toggle='modal' data-target='#crew_injury_$post->id'>
                                        <i class='fas fa-eye'></i>
                                    </button> <b class='garage-title pl-2 pt-2 text-disable'> View  Injury Details </b>
                                </div>

                                <!-- Modal -->
                                <div class='modal fade' id='crew_injury_$post->id' tabindex='-1' role='dialog' aria-labelledby='exampleModalLongTitle' aria-hidden='true'>
                                    <div class='modal-dialog modal-lg' role='document'>
                                        <div class='modal-content'>
                                        <div class='modal-header'>
                                            <h2 class='modal-title font-weight-bold' id='exampleModalLongTitle'>Crew Injury  </h2> <h5>Report Id : $post->id </h5>
                                        </div>
                                        <div class='modal-body text-left'>

                                            <div class='row'>
                                                " . $this->col('3', '12', (isset($post->crew_injury) && $post->crew_injury) ? $post->crew_injury : '', 'Crew Injury') . "
                                                " . $this->col('3', '12', (isset($post->other_personnel_injury) && $post->other_personnel_injury) ? $post->other_personnel_injury : '', 'Other Personal Injury') . "

                                                " . $this->col('3', '12', (isset($crew_injury_data->fatality) && $crew_injury_data->fatality) ? $crew_injury_data->fatality : '', 'Fatality') . "
                                                " . $this->col('3', '12', (isset($crew_injury_data->lost_workday_case) && $crew_injury_data->lost_workday_case) ? $crew_injury_data->lost_workday_case : '', 'Lost Workday Case') . "
                                                " . $this->col('3', '12', (isset($crew_injury_data->restricted_work_case) && $crew_injury_data->restricted_work_case) ? $crew_injury_data->restricted_work_case : '', 'Restricted Work Case') . "
                                                " . $this->col('3', '12', (isset($crew_injury_data->medical_treatment_case) && $crew_injury_data->medical_treatment_case) ? $crew_injury_data->medical_treatment_case : '', 'Medical Treatment Case') . "
                                                " . $this->col('3', '12', (isset($crew_injury_data->lost_time_injuries) && $crew_injury_data->lost_time_injuries) ? $crew_injury_data->lost_time_injuries : '', 'Lost Time Injuries') . "
                                                " . $this->col('3', '12', (isset($crew_injury_data->first_aid_case) && $crew_injury_data->first_aid_case) ? $crew_injury_data->first_aid_case : '', 'First Aid Case') . "

                                                " . $this->col('3', '12', (isset($post->lead_investigator) && $post->lead_investigator) ? $post->lead_investigator : '', 'Lead Investigator') . "
                                                " . $this->col('3', '12', explode(',', $mem_name), 'Supporting Team Members') . "


                                            </div>

                                        </div>
                                        <div class='modal-footer'>
                                            <button type='button' class='btn btn-danger   -close' data-dismiss='modal'><i class='far fa-times-circle mr-1'></i> Close</button>
                                        </div>
                                        </div>
                                    </div>
                                </div>
                            ";
                }
                // ```````````````````````````````` Crew   injury End ``````````````````````````

                // ```````````````````````````````` Event Information `````````````````````````


                //($event_report && isset($event_report->lat_1) && $event_report->lat_1 && $event_report->lat_1 !=null)?$event_report->lat_1:''
                $Event_information = "
                            <!-- Button trigger modal -->
                            <div class='d-flex'>
                                 <div class='containertooltip'>
                                        <button type='button' class='btn text-dark     p-1' data-toggle='modal'   data-target='#EI_$post->id'>
                                            <i class='fas fa-eye'>View</i>
                                        </button>
                                        <div class='container__content'>

                                                <b class='garage-title pl-1 pr-1 pt-2' style='color: white';>EVENT INFORMATION</b>
                                        </div>
                                 <div class='container__arrow' />
                                  </div>

                          </div>


                            <!-- Modal -->
                            <div class='modal fade' id='EI_$post->id' tabindex='-1' role='dialog' aria-labelledby='exampleModalLongTitle' aria-hidden='true'>
                                <div class='modal-dialog modal-lg' role='document'>
                                    <div class='modal-content'>
                                        <div class='modal-header'>
                                            <h2 class='modal-title font-weight-bold' id='exampleModalLongTitle'>Event Information</h2> <h5>Report Id : $post->id </h5>
                                        </div>
                                        <div class='modal-body text-left'>

                                                <div class='row'>
                                                    " . $this->col('3', '12', (isset($event_report->place_of_incident) && $event_report->place_of_incident) ? $event_report->place_of_incident : '', 'Place of the incident') . "
                                                    <div class= 'col-md-3' >
                                                      <h6 class='font-weight-bold'> Latitude of the incident<h6>
                                                        <div class= d-flex>
                                                            <p> ";

                if ($event_report && $event_report->lat_1) {
                    $Event_information .= $event_report->lat_1;
                } else {
                    $Event_information .= ' ';
                }

                $Event_information .= "</p>
                                                            <p> '";

                if ($event_report && $event_report->lat_2) {
                    $Event_information .= $event_report->lat_2;
                } else {
                    $Event_information .= ' ';
                }

                $Event_information .= "</p>
                                                            <p> '";

                if ($event_report && $event_report->lat_3) {
                    $Event_information .= $event_report->lat_3;
                } else {
                    $Event_information .= ' ';
                }

                $Event_information .= "</p>
                                                        </div>


                                                    </div>
                                                    <div class= 'col-md-3' >
                                                      <h6 class='font-weight-bold'> Longitude of the incident<h6>
                                                        <div class= d-flex>
                                                            <p> ";

                if ($event_report && $event_report->long_1) {
                    $Event_information .= $event_report->long_1;
                } else {
                    $Event_information .= ' ';
                }

                $Event_information .= "</p>
                                                            <p> '";

                if ($event_report && $event_report->long_2) {
                    $Event_information .= $event_report->long_2;
                } else {
                    $Event_information .= ' ';
                }

                $Event_information .= "</p>
                                                            <p> '";

                if ($event_report && $event_report->long_3) {
                    $Event_information .= $event_report->long_3;
                } else {
                    $Event_information .= ' ';
                }

                $Event_information .= "</p>
                                                        </div>


                                                    </div>
                                                    " . $this->col('3', '12', (isset($event_report->nadate_of_incidentme) && $event_report->date_of_incident) ? $event_report->date_of_incident : '', 'Date of incident') . "
                                                    " . $this->col('3', '12', (isset($event_report->time_of_incident_lt) && $event_report->time_of_incident_lt) ? $event_report->time_of_incident_lt : '', 'Time of incident') . "
                                                    " . $this->col('3', '12', (isset($event_report->time_of_incident_gmt) && $event_report->time_of_incident_gmt) ? $event_report->time_of_incident_gmt : '', 'GMT') . "
                                                    " . $this->col('3', '12', (isset($event_report->location_of_incident) && $event_report->location_of_incident) ? $event_report->location_of_incident : '', 'Location of incident') . "
                                                    " . $this->col('3', '12', (isset($event_report->operation) && $event_report->operation) ? $event_report->operation : '', 'Operation') . "
                                                    " . $this->col('3', '12', (isset($event_report->vessel_condition) && $event_report->vessel_condition) ? $event_report->vessel_condition : '', 'Vessel Condition') . "
                                                    " . $this->col('3', '12', (isset($event_report->cargo_type_and_quantity) && $event_report->cargo_type_and_quantity) ? $event_report->cargo_type_and_quantity : '', 'Cargo type and quantity') . "
                                                    " . $this->col('3', '12', (isset($event_report_weather->wind_force) && $event_report_weather->wind_force) ? $event_report_weather->wind_force : '', 'Wind force') . "
                                                    " . $this->col('3', '12', (isset($event_report_weather->wind_direction) && $event_report_weather->wind_direction) ? $event_report_weather->wind_direction : '', 'Wind Direction(Degree)') . "
                                                    " . $this->col('3', '12', (isset($event_report_weather->sea_wave) && $event_report_weather->sea_wave) ? $event_report_weather->sea_wave : '', 'Sea') . "
                                                    " . $this->col('3', '12', (isset($event_report_weather->sea_direction) && $event_report_weather->sea_direction) ? $event_report_weather->sea_direction : '', 'Sea Direction(Degree)') . "
                                                    " . $this->col('3', '12', (isset($event_report_weather->swell_height) && $event_report_weather->swell_height) ? $event_report_weather->swell_height : '', 'Swell Height') . "
                                                    " . $this->col('3', '12', (isset($event_report_weather->swell_length) && $event_report_weather->swell_length) ? $event_report_weather->swell_length : '', 'Swell Length') . "
                                                    " . $this->col('3', '12', (isset($event_report_weather->swell_direction) && $event_report_weather->swell_direction) ? $event_report_weather->swell_direction : '', 'Swell Direction') . "
                                                    " . $this->col('3', '12', (isset($event_report_weather->sky) && $event_report_weather->sky) ? $event_report_weather->sky : '', 'Sky') . "
                                                    " . $this->col('3', '12', (isset($event_report_weather->visibility) && $event_report_weather->visibility) ? $event_report_weather->visibility : '', 'Visibility') . "
                                                    " . $this->col('3', '12', (isset($event_report_weather->rolling) && $event_report_weather->rolling) ? $event_report_weather->rolling : '', 'Rolling') . "
                                                    " . $this->col('3', '12', (isset($event_report_weather->pitching) && $event_report_weather->pitching) ? $event_report_weather->pitching : '', 'Pitching') . "
                                                    " . $this->col('4', '12', (isset($event_report_weather->illumination) && $event_report_weather->illumination) ? $event_report_weather->illumination : '', 'Illumination') . "
                                                    " . $this->col('4', '12', (isset($post->p_n_i_club_informed) && $post->p_n_i_club_informed) ? $post->p_n_i_club_informed : '', 'P&I Club informed') . "
                                                    " . $this->col('4', '12', (isset($post->h_n_m_informed) && $post->h_n_m_informed) ? $post->h_n_m_informed : '', 'H&M Informed') . "
                                                    " . $this->col('12', '12', (isset($post->type_of_loss_remarks) && $post->type_of_loss_remarks) ? $post->type_of_loss_remarks : '',
                    'Remarks'
                ) . "
                                                </div>

                                        </div>
                                        <div class='modal-footer'>
                                            <button type='button' class='btn btn-danger   -close' data-dismiss='modal'><i class='far fa-times-circle mr-1'></i>Close</button>
                                        </div>
                                    </div>
                                </div>

                        ";
                // ```````````````````````````````` Event Information end `````````````````````````

                // ```````````````````````````````` 5 why ``````````````````````````````
                    $five_why = "
                                    <!-- Button trigger modal -->
                                    <div class='d-flex'>
                                    <div class='containertooltip'>
                                        <button type='button' class='btn text-dark     p-1' data-toggle='modal'   data-target='#why_five_$post->id'>
                                            <i class='fas fa-eye'>View</i>
                                        </button>
                                        <div class='container__content'>

                                                <b class='garage-title pl-1 pr-1 pt-2' style='color: white';>5 WHY</b>
                                        </div>
                                        <div class='container__arrow' />

                                    </div>

                            </div>

                                    <!-- Modal -->
                                    <div class='modal fade' id='why_five_$post->id' tabindex='-1' role='dialog' aria-labelledby='exampleModalLongTitle' aria-hidden='true'>
                                        <div class='modal-dialog modal-lg' role='document'>
                                            <div class='modal-content'>
                                            <div class='modal-header'>
                                                <h2 class='modal-title font-weight-bold' id='exampleModalLongTitle'>5 Why</h2> <h5>Report Id : $post->id </h5>
                                            </div>
                                            <div class='modal-body text-left'>



                                                <div class='row'>
                                                    " . $this->col('4', '12', (isset($fivee_why->incident) && $fivee_why->incident) ? $fivee_why->incident : '', 'Incident') . "
                                                    " . $this->col('4', '12', $five_why, 'Five Why') . "
                                                    " . $this->col('4', '12', (isset($fivee_why->root_cause) && $fivee_why->root_cause) ? $fivee_why->root_cause : '', 'Root Cause') . "
                                                    " . $this->col('3', '12', (isset($post->is_evalutated) && $post->is_evalutated) ? (($post->is_evalutated == 'Yes')? $post->is_evalutated.'<br> <br> <img src="/getFile?path='. $post->five_why_risk_assesment_evaluated_file_upload .'" height="100" width="100">' : $post->is_evalutated) : '', 'Risk assesment evaluated') . "


                                                    <div class='col-12 table-responsive'>
                                                        <table class='table'>
                                                            <thead>
                                                                <tr>
                                                                    <th scope='col'>Sr No</th>
                                                                    <th scope='col'>Description</th>
                                                                    <th scope='col'>PIC</th>
                                                                    <th scope='col'>Department</th>
                                                                    <th scope='col'>Target Date</th>
                                                                    <th scope='col'>Completed Date</th>
                                                                    <th scope='col'>Evidence Uploaded</th>
                                                                    <th scope='col'>Cost</th>
                                                                    <th scope='col'>Comments</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                            ";
                    $followup_action_NO = 0;
                    foreach ($follow_up_action as $follow) {
                        $followup_action_NO++;
                        $five_why .= "
                                                                    <tr>
                                                                        <th scope='row'> $followup_action_NO </th>
                                                                        <td>$follow->description</td>
                                                                        <td>$follow->pic</td>
                                                                        <td>$follow->department</td>
                                                                        <td>$follow->target_date</td>
                                                                        <td>$follow->completed_date</td>
                                                                        <td>
                                                                            $follow->evidence_uploaded
                                                                            <br>";
                        if ($follow->evidence_file != '') {
                            $five_why .= "<b>Image </b> <img src='/getFile?path=$follow->evidence_file' height='100' width='100'>
                                                                                <a download class='btn btn-primary   text-light' href='/downloadRaPdfQstring?path=$follow->evidence_file'>Download </a>";
                        }
                        $five_why .= "</td>
                                                                        <td>$follow->cost</td>
                                                                        <td>$follow->comments</td>
                                                                    </tr>";
                    }
                    $five_why .= "
                                                            </tbody>
                                                        </table>
                                                    </div>


                                                " . $this->col('4', '12', (isset($root_causes->primary)) ? $root_causes->primary : 'N/A', 'Root Causes &#91; Primary  &#93;') . "

                                                " . $this->col('4', '12',
                        (isset($root_causes->secondary)) ? $root_causes->secondary : 'N/A',
                        'Root Causes &#91; Secondary  &#93;'
                    ) . "
                                                " . $this->col('4', '12', (isset($root_causes->tertiary)) ? $root_causes->tertiary : 'N/A', 'Root Causes &#91; Tertiary    &#93;') . "
                                                " . $this->col('4', '12', (isset($preventive_action->primary)) ? $preventive_action->primary : 'N/A', 'Preventive Action  &#91; Primary &#93;') . "
                                                " . $this->col('4', '12', (isset($preventive_action->secondary)) ? $preventive_action->secondary : 'N/A', 'Preventive Action  &#91; Secondary &#93;') . "
                                                " . $this->col('4', '12', (isset($preventive_action->tertiary)) ? $preventive_action->tertiary : 'N/A', 'Preventive Action  &#91; Tertiary   &#93;') . "
                                                    <div class='my-3'>
                                                    " . $this->col('12', '12', (isset($post->comments_five_why_section) && $post->comments_five_why_section) ? $post->comments_five_why_section : '', 'Comments') . "
                                                    </div>
                                                </div>


                                            </div>
                                            <div class='modal-footer'>
                                                <button type='button' class='btn btn-danger   -close' data-dismiss='modal'><i class='far fa-times-circle mr-1'></i>Close</button>
                                            </div>
                                            </div>
                                        </div>
                                    </div>

                                ";
                // ```````````````````````````````` 5 why end ``````````````````````````````

                // ````````````````````````````````` incident investigartion and root cause ``````````````````
                    $incident_investigation_root_cause = "
                                    <!-- Button trigger modal -->
                                    <div class='d-flex'>
                                <div class='containertooltip'>
                                    <button type='button' class='btn text-dark     p-1' data-toggle='modal'   data-target='#Investigation_$post->id'>
                                        <i class='fas fa-eye'>View</i>
                                    </button>
                                    <div class='container__content'>

                                            <b class='garage-title pl-1 pr-1 pt-2' style='color: white';> INVESTIGATION</b>
                                    </div>
                                    <div class='container__arrow' />

                                </div>

                        </div>

                                    <!-- Modal -->
                                    <div class='modal fade' id='Investigation_$post->id' tabindex='-1' role='dialog' aria-labelledby='exampleModalLongTitle' aria-hidden='true'>
                                        <div class='modal-dialog modal-lg' role='document'>
                                            <div class='modal-content'>
                                                <div class='modal-header'>
                                                    <h2 class='modal-title font-weight-bold' id='exampleModalLongTitle'>Incident investigartion and root cause</h2> <h5>Report Id : $post->id </h5>
                                                </div>
                                                <div class='modal-body text-left'>

                                                    <div class='row'>
                                                        " . $this->col('3', '12', $ed, 'Event Details') . "
                                                        " . $this->col('3', '12', (isset($post->risk_category) && $post->risk_category) ? $post->risk_category : '', 'Risk Category') . "
                                                        " . $this->col('3', '12', (isset($risk_details->risk) && $risk_details->risk) ? $risk_details->risk : '', 'Risk') . "
                                                        " . $this->col('3', '12', (isset($risk_details->severity) && $risk_details->severity) ? $risk_details->severity : '', 'Severity') . "
                                                        " . $this->col('3', '12', (isset($risk_details->likelihood) && $risk_details->likelihood) ? $risk_details->likelihood : '', 'Likelihood') . "
                                                        " . $this->col('3', '12', (isset($risk_details->result) && $risk_details->result) ? $risk_details->result : '', 'Result') . "
                                                        " . $this->col('3', '12', (isset($risk_details->name_of_person) && $risk_details->name_of_person) ? $risk_details->name_of_person : '',
                        'Name Of The Person'
                    ) . "
                                                        " . $this->col('3', '12', (isset($risk_details->type_of_injury) && $risk_details->type_of_injury) ? $risk_details->type_of_injury : '', 'Type Of Injury') . "
                                                        " . $this->col('3', '12', (isset($risk_details->type_of_pollution) && $risk_details->type_of_pollution) ? $risk_details->type_of_pollution : '', 'Type Of Pollution') . "
                                                        " . $this->col('3', '12', (isset($risk_details->quantity_of_pollutant) && $risk_details->quantity_of_pollutant) ? $risk_details->quantity_of_pollutant : '', 'Quantity Of Pollutant') . "
                                                        " . $this->col('3', '12', (isset($risk_details->contained_spill) && $risk_details->contained_spill) ? $risk_details->contained_spill : '', 'Contained Spill') . "
                                                        " . $this->col('3', '12', (isset($risk_details->total_spilled_quantity) && $risk_details->total_spilled_quantity) ? $risk_details->total_spilled_quantity : '', 'Total Spilled Quantity') . "
                                                        " . $this->col('3', '12', (isset($risk_details->spilled_in_water) && $risk_details->spilled_in_water) ? $risk_details->spilled_in_water : '', 'Spilled In Water') . "
                                                        " . $this->col('3', '12', (isset($risk_details->spilled_ashore) && $risk_details->spilled_ashore) ? $risk_details->spilled_ashore : '', 'Spilled In Ashore') . "
                                                        " . $this->col('3', '12', (isset($risk_details->off_hire) && $risk_details->off_hire) ? $risk_details->off_hire : '', 'Off Hire') . "
                                                        " . $this->col('3', '12', (isset($risk_details->damage_description) && $risk_details->damage_description) ? $risk_details->damage_description : '', 'Damage Description') . "
                                                        " . $this->col('3', '12', (isset($risk_details->vessel) && $risk_details->vessel) ? $risk_details->vessel : '', 'Vessel') . "
                                                        " . $this->col('3', '12', (isset($risk_details->cargo) && $risk_details->cargo) ? $risk_details->cargo : '', 'Cargo') . "
                                                        " . $this->col('3', '12', (isset($risk_details->third_party) && $risk_details->third_party) ? $risk_details->third_party : '', 'Third Party') . "
                                                        " . $this->col('12', '12', (isset($risk_details->description) && $risk_details->description) ? $risk_details->description : '', 'Description') . "
                                                        " . $this->col('6', '12', (isset($risk_details->type) && $risk_details->type) ? $risk_details->type : '', 'Type') . "
                                                        " . $this->col('6', '12', (isset($risk_details->type_of_injury) && $risk_details->type_of_injury) ? $risk_details->type_of_injury : '', 'Type Of Injury') . "
                                                        " . $this->col('4', '12', (isset($risk_details->associated_cost_usd) && $risk_details->associated_cost_usd) ? $risk_details->associated_cost_usd : '', 'Associated cost(USD)') . "
                                                        " . $this->col('4', '12', (isset($risk_details->currency_code) && $risk_details->currency_code) ? $risk_details->currency_code : '', 'Currency') . "
                                                        " . $this->col('4', '12', (isset($risk_details->associated_cost_loca) && $risk_details->associated_cost_loca) ? $risk_details->associated_cost_loca : '', 'Associated cost(Local)') . "
                                                        " . $this->col('4', '12', (isset($imediate_cause->primary)) ? $imediate_cause->primary : '', 'Immediate Cause &#91; Primary &#93') . "
                                                        " . $this->col('4', '12', (isset($imediate_cause->secondary)) ? $imediate_cause->secondary : '', 'Immediate Cause &#91; Secondary &#93') . "
                                                        " . $this->col('4', '12', (isset($imediate_cause->tertiary)) ? $imediate_cause->tertiary : '', 'Immediate Cause &#91; Tertiary &#93') . "
                                                    </div>

                                                </div>
                                                <div class='modal-footer'>
                                                    <button type='button' class='btn btn-danger   -close' data-dismiss='modal'><i class='far fa-times-circle mr-1'></i> Close</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                        ";
                // ````````````````````````````````` incident investigartion and root cause end ``````````````````

                // ``````````````````````````` EVENT LOG ``````````````````````````````
                $Event_log = "
                                <!-- Button trigger modal -->
                                <div class='d-flex'>
                                <div class='containertooltip'>
                                       <button type='button' class='btn text-dark     p-1' data-toggle='modal'   data-target='#event_log_$post->id'>
                                           <i class='fas fa-eye'>View</i>
                                       </button>
                                     <div class='container__content'>

                                               <b class='garage-title pl-1 pr-1 pt-2' style='color: white';>EVENT LOG</b>
                                     </div>
                                     <div class='container__arrow' />

                                </div>

                                </div>
                                <!-- Modal -->
                                <div class='modal fade' id='event_log_$post->id' tabindex='-1' role='dialog' aria-labelledby='exampleModalLongTitle' aria-hidden='true'>
                                    <div class='modal-dialog modal-lg' role='document'>
                                        <div class='modal-content'>
                                        <div class='modal-header'>
                                            <h2 class='modal-title font-weight-bold' id='exampleModalLongTitle'>Event Log</h2> <h5>Report Id : $post->id </h5>
                                        </div>
                                        <div class='modal-body text-left'>

                                            <table class='table table-borderless '>
                                                <thead>
                                                <tr>
                                                    <th scope='col'>Date</th>
                                                    <th scope='col'>Time</th>
                                                    <th scope='col'>Remarks</th>
                                                </tr>
                                                </thead>
                                                <tbody>";
                foreach ($event_logs as $elog) {
                    $Event_log .= "
                                                    <tr>
                                                        <th>$elog->date</th>
                                                        <td>$elog->time</td>
                                                        <td>$elog->remarks</td>
                                                    </tr>";
                }
                $Event_log .= "
                                                </tbody>
                                            </table>

                                        </div>
                                        <div class='modal-footer'>
                                            <button type='button' class='btn btn-danger   -close' data-dismiss='modal'><i class='far fa-times-circle mr-1'></i> Close</button>
                                        </div>
                                        </div>
                                    </div>
                                </div>

                            ";
                // ``````````````````````````` EVENT LOG end ``````````````````````````````

                // ``````````````````````````` INCIDENT IN BRIEF ``````````````
                $incident_berief = "
                        <!-- Button trigger modal -->
                        <div class='d-flex'>
                           <div class='containertooltip'>
                               <button type='button' class='btn text-dark     p-1' data-toggle='modal'   data-target='#incident_brief$post->id'>
                                   <i class='fas fa-eye'>View</i>
                               </button>
                               <div class='container__content'>

                                       <b class='garage-title pl-1 pr-1 pt-2' style='color: white';>INCIDENT IN BRIEF</b>
                               </div>
                             <div class='container__arrow' />
                              </div>

                           </div>

                        <!-- Modal -->
                        <div class='modal fade' id='incident_brief$post->id' tabindex='-1' role='dialog' aria-labelledby='exampleModalLongTitle' aria-hidden='true'>
                            <div class='modal-dialog modal-lg' role='document'>
                                <div class='modal-content'>
                                <div class='modal-header'>
                                    <h2 class='modal-title font-weight-bold' id='exampleModalLongTitle'>Incident In Brief</h2> <h5>Report Id : $post->id </h5>
                                </div>
                                <div class='modal-body text-left'>

                                    " . $this->col('3', '12', (isset($post->incident_brief) && $post->incident_brief) ? $post->incident_brief : '', '') . "

                                </div>
                                <div class='modal-footer'>
                                    <button type='button' class='btn btn-danger   -close' data-dismiss='modal'><i class='far fa-times-circle mr-1'></i>Close</button>
                                </div>
                                </div>
                            </div>
                        </div>";
                // ``````````````````````````` INCIDENT IN BRIEF end ``````````````


                if ($post->status == 'Not Approved') {
                    $stat_color      = 'danger';
                }
                if ($post->status == 'Approved') {
                    $stat_color      = 'success';
                }
                if ($post->status == 'Draft') {
                    $stat_color      = 'warning';
                }
                if ($post->status == 'Submitted') {
                    $stat_color      = 'primary';
                }
                $nestedData['status']                 = "<div class='shadow btn btn-" . $stat_color . "' ' '>" . $post->status . "</div>";
                $nestedData['id']                 = "$post->id
                                                    <a href='' class='btn preview mt-5' title = 'Preview' data-toggle='modal' data-target='#prev_$post->id'>
                                                        <i class='fas fa-info-circle'></i>
                                                    </a>
                                                    ";
                $nestedData['Incident']                 = $incident_details;
                $nestedData['Crew_Injury']                 = $Crew_injury;
                $nestedData['Vessel_Details']                 = $vessel_details;
                $nestedData['Event_information']                 = $Event_information;
                $nestedData['incident_berief']                 = $incident_berief;
                $nestedData['Event_log']                 = $Event_log;
                $nestedData['incident_investigation_root_cause']                 = $incident_investigation_root_cause;
                $nestedData['five_why']                 = $five_why;
                $cb              = new Carbon;
                $nestedData['created_at']                 = $cb::parse($post->created_at)
                    ->format('d-M-Y');
                $nestedData['action']                 = $Action;
                $data[]                 = $nestedData;
            }
        }

        // returned data on front-end .....
        $json_data       = array(
            "draw" => intval($req->input('draw')),
            "recordsTotal" => intval($totaldata),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data
        );

        echo json_encode($json_data);
    }


    // created by sougata on (11-May-2022) .....
    public function modalData(Request $r){
        Log::info('I am here '.print_r($r->myData,true));
        DB::table('incident_report')->where('id',$r->id)->update(['Immediate_action_to_be_taken' => $r->myData]);
        return true;
    }

    // ````````````````````````````````````````````` Data tables code Ends. ``````````````````````````````````````
    // ------------------------------------------------------------------------------------------------------------
    function saveInvestigationMatrix(Request $request)
    {
        try {

            // to save the data
            $investigation_matrix_fst  = $request->First_Parameter;
            $investigation_matrix_scnd = $request->Second_Parameter;
            $user_id                   = Auth::user()->id;
            $saved_status              = $request->saved_status;
            if ($saved_status == null) {
                $saved_status              = 'temporary';
            }
            $report_id                 = $request->report_id;
            $report_details            = DB::table('incident_report')->where('id', $report_id)->where('saved_status', $saved_status)->where('user_id', $user_id)->first();
            if (($report_id != null || $report_id != '') && $report_details != null) {
                DB::table('incident_report')->where('id', $report_id)->where('saved_status', $saved_status)->where('user_id', $user_id)->update(['investigation_matrix_fst'                  => $investigation_matrix_fst, 'investigation_matrix_scnd'                  => $investigation_matrix_scnd]);
                $incidents_report = DB::table('incident_report')->where('id', $report_id)->where('saved_status', $saved_status)->where('user_id', $user_id)->first();
                return json_encode(['req'                                             => $request->all(), 'report_id'                                             => $report_details->id, 'msg'                                             => 'data updated', 'incidents_report'                                             => $incidents_report]);
            } else {
                $incidents_report                            = new incident_report;
                $incidents_report->investigation_matrix_fst  = $investigation_matrix_fst;
                $incidents_report->investigation_matrix_scnd = $investigation_matrix_scnd;
                $incidents_report->user_id                   = $user_id;
                $incidents_report->saved_status              = $saved_status;
                $incidents_report->save();

                return json_encode(['req' => $request->all(), 'report_id' => $incidents_report->id, 'msg' => 'data created', 'incidents_report' => $incidents_report]);
            }
        } catch (Exception $e) {
            report($e);
        }
    }

    function saveIncidentHeader(Request $request)
    {
        try {
            $Incident_header = $request->Incident_header;
            $user_id         = Auth::user()->id;
            $saved_status    = $request->saved_status;
            if ($saved_status == null) {
                $saved_status    = 'temporary';
            }
            $report_id       = $request->report_id;
            $report_details  = DB::table('incident_report')->where('id', $report_id)->where('saved_status', $saved_status)->where('user_id', $user_id)->first();
            if ($report_details != null) {
                DB::table('incident_report')->where('id', $report_id)->where('saved_status', $saved_status)->where('user_id', $user_id)->update(['incident_header'                => $Incident_header]);
                $report_details = DB::table('incident_report')->where('id', $report_id)->where('saved_status', $saved_status)->where('user_id', $user_id)->first();
                return json_encode(['req'                                   => $request->all(), 'report_id'                                   => $report_details->id, 'msg'                                   => 'data updated', 'report_details'                                   => $report_details]);
            } else {
                $incidents_report                  = new incident_report;
                $incidents_report->incident_header = $Incident_header;
                $incidents_report->user_id         = $user_id;
                $incidents_report->saved_status    = $saved_status;
                $incidents_report->save();

                return json_encode(['req' => $request->all(), 'report_id' => $incidents_report->id, 'msg' => 'data created', 'report_details' => $report_details]);
            }
        } catch (Exception $e) {
            report($e);
        }
    }

    function saveIncidentReportDetails(Request $request)
    {
        try {
            $user_id               = Auth::user()->id;
            $saved_status          = $request->saved_status;
            if ($saved_status == null) {
                $saved_status          = 'temporary';
            }
            $report_id             = $request->report_id;
            $Vessel_Name           = $request->Vessel_Name;
            $Confidential          = $request->Confidential;
            $Report_number         = $request->Report_number;
            $media_involved        = $request->media_involved;
            $Created_By_Name       = $request->Created_By_Name;
            $Created_By_Rank       = $request->Created_By_Rank;
            $Date_of_incident      = $request->Date_of_incident;
            $Time_of_incident      = $request->Time_of_incident;
            $Date_report_created   = $request->Date_report_created;
            $GMT                   = $request->GMT;
            $Voy_No                = $request->Voy_No;
            $Master                = $request->Master;
            $Chief_officer         = $request->Chief_officer;
            $Chief_Engineer        = $request->Chief_Engineer;
            $fstEng                = $request->fstEng;
            $Charterer             = $request->Charterer;
            $Agent                 = $request->Agent;
            $Vessel_Damage         = $request->Vessel_Damage;
            $Cargo_damage          = $request->Cargo_damage;
            $Third_Party_Liability = $request->Third_Party_Liability;
            $Environmental         = $request->Environmental;
            $Commercial_Service    = $request->Commercial_Service;

            $report_details        = DB::table('incident_report')->where('id', $report_id)->where('saved_status', $saved_status)->where('user_id', $user_id)->first();
            if ($report_details != null) {
                DB::table('incident_report')->where('id', $report_id)->update([

                    'vessel_name'                  => $Vessel_Name, 'report_no'                  => $Report_number, 'date_of_incident'                  => $Date_of_incident, 'date_report_created'                  => $Date_report_created, 'voy_no'                  => $Voy_No, 'master'                  => $Master, 'chief_engineer'                  => $Chief_Engineer, 'charterer'                  => $Charterer, 'agent'                  => $Agent, 'chief_officer'                  => $Chief_officer, 'first_engineer'                  => $fstEng, 'confidential'                  => $Confidential, 'media_involved'                  => $media_involved, 'time_of_incident_lt'                  => $Time_of_incident, 'time_of_incident_gmt'                  => $GMT, 'vessel_damage'                  => $Vessel_Damage, 'cargo_damage'                  => $Cargo_damage, 'third_party_liability'                  => $Third_Party_Liability, 'environmental'                  => $Environmental, 'commercial'                  => $Commercial_Service, 'created_by_name'                  => $Created_By_Name, 'created_by_rank'                  => $Created_By_Rank
                ]);
                $incidents_report = DB::table('incident_report')->where('id', $report_id)->where('saved_status', $saved_status)->where('user_id', $user_id)->first();
                return json_encode(['req' => $request->all(), 'report_id' => $report_details->id, 'msg' => 'data updated', 'incidents_report' => $incidents_report]);
            } else {
                DB::table('incident_report')->insert(['vessel_name'                => $Vessel_Name, 'report_no'                => $Report_number, 'date_of_incident'                => $Date_of_incident, 'date_report_created'                => $Date_report_created, 'voy_no'                => $Voy_No, 'master'                => $Master, 'chief_engineer'                => $Chief_Engineer, 'charterer'                => $Charterer, 'agent'                => $Agent, 'chief_officer'                => $Chief_officer, 'first_engineer'                => $fstEng, 'confidential'                => $Confidential, 'media_involved'                => $media_involved, 'time_of_incident_lt'                => $Time_of_incident, 'time_of_incident_gmt'                => $GMT, 'vessel_damage'                => $Vessel_Damage, 'cargo_damage'                => $Cargo_damage, 'third_party_liability'                => $Third_Party_Liability, 'environmental'                => $Environmental, 'commercial'                => $Commercial_Service, 'created_by_name'                => $Created_By_Name, 'created_by_rank'                => $Created_By_Rank]);
                $report_details = DB::table('incident_report')->orderBy('id', 'desc')
                    ->first();
                return json_encode(['req' => $request->all(), 'report_id' => $report_details->id, 'msg' => 'data created', 'report_details' => $report_details]);
            }
        } catch (Exception $e) {
            report($e);
        }
    }

    function saveIncidentCrewInjury(Request $request)
    {
        try {
            $Crew_Injury            = $request->Crew_Injury;
            $Fatality               = $request->Fatality;
            $Lead_Investigator      = $request->Lead_Investigator;
            $Lost_Time_Injuries     = $request->Lost_Time_Injuries;
            $Lost_Workday_Case      = $request->Lost_Workday_Case;
            $Medical_Treatment_Case = $request->Medical_Treatment_Case;
            $Other_Personnel_Injury = $request->Other_Personnel_Injury;
            $Restricted_Work_Case   = $request->Restricted_Work_Case;
            $First_Aid_Case         = $request->First_Aid_Case;
            $report_id              = $request->report_id;
            $saved_status           = $request->saved_status;
            $user_id                = $request->user_id;

            // array
            $supporting_members     = $request->supporting_members;
            // fill data in incident_report table
            $report_details         = DB::table('incident_report')->where('id', $report_id)->where('saved_status', $saved_status)->where('user_id', $user_id)->first();
            if ($report_details != null) {
                DB::table('incident_report')->where('id', $report_id)->update(['crew_injury'                                          => $Crew_Injury, 'other_personnel_injury'                                          => $Other_Personnel_Injury, 'lead_investigator'                                          => $Lead_Investigator]);
                $report_details                           = DB::table('incident_report')->where('id', $report_id)->where('saved_status', $saved_status)->where('user_id', $user_id)->first();
                // return json_encode(['req'=> $request->all(),'msg'=>'data created','report_details'=>$report_details]);

            } else {
                $incidents_report                         = new incident_report;
                $incidents_report->crew_injury            = $Crew_Injury;
                $incidents_report->other_personnel_injury = $Other_Personnel_Injury;
                $incidents_report->lead_investigator      = $Lead_Investigator;
                $incidents_report->user_id                = $user_id;
                $incidents_report->saved_status           = $saved_status;
                $incidents_report->save();

                $report_details = $incidents_report;
                // return json_encode(['req'=> $request->all(),'msg'=>'data created','report_details'=>$report_details]);

            }

            // fill data in incident_reports_crew_injury table
            $crew_details   = IncidentReportCrewInjury::where('incident_report_id', $report_id)->first();
            // log::info(print_r($report_id,true));
            if ($crew_details != null) {
                $crew_report    = IncidentReportCrewInjury::where('incident_report_id', $report_id)->update(['incident_report_id' => $report_id, 'fatality' => $Fatality, 'lost_workday_case' => $Lost_Workday_Case, 'restricted_work_case' => $Restricted_Work_Case, 'medical_treatment_case' => $Medical_Treatment_Case, 'lost_time_injuries' => $Lost_Time_Injuries, 'first_aid_case' => $First_Aid_Case]);
                // log::info(print_r($crew_report,true));



            } else {
                IncidentReportCrewInjury::insert([
                    'incident_report_id'                => $report_id, 'fatality'                => $Fatality, 'lost_workday_case'                => $Lost_Workday_Case, 'restricted_work_case'                => $Restricted_Work_Case, 'medical_treatment_case'                => $Medical_Treatment_Case, 'lost_time_injuries'                => $Lost_Time_Injuries, 'first_aid_case'                => $First_Aid_Case

                ]);
                $crew_report    = IncidentReportCrewInjury::orderBy('id', 'desc')->first();
            }

            // fill data in incident_reports_supporting_team_members table
            if ($supporting_members != null && count($supporting_members) > 0) {
                $member_details = DB::table('incident_reports_supporting_team_members')->where('IRI', $report_id)->delete();
                for ($j              = 0; $j < count($supporting_members); $j++) {

                    DB::table('incident_reports_supporting_team_members')->insert([

                        'IRI'                     => $report_id, 'member_name'                     => $supporting_members[$j]

                    ]);
                }
            }
            $supporting_member_d = DB::table('incident_reports_supporting_team_members')->where('IRI', $report_id)->get();
            return json_encode(['req' => $request->all(), 'report_details' => $report_details, 'crew_report' => $crew_report, 'supporting_member' => $supporting_member_d]);
        } catch (Exception $e) {
            report($e);
        }
    }

    function saveIncidentBrief(Request $request)
    {

        $user_id           = $request->user_id;
        $report_id         = $request->report_id;
        $saved_status      = $request->saved_status;
        $Incident_in_brief = $request->Incident_in_brief;

        $is_data_present   = DB::table('incident_report')->where('id', $report_id)->where('saved_status', $saved_status)->first();
        if ($is_data_present != null) {
            DB::table('incident_report')->where('id', $report_id)->update(['incident_brief'                => $Incident_in_brief]);
            $report_details = DB::table('incident_report')->where('id', $report_id)->first();
            return json_encode(['req' => $request->all(), 'msg' => 'data updated', 'report_details' => $report_details]);
        } else {
            DB::table('incident_report')->insert(['incident_brief'                => $Incident_in_brief]);
            $report_details = DB::table('incident_report')->orderBy('id', 'desc')
                ->first();
            return json_encode(['req'                                        => $request->all(), 'msg'                                        => 'data created', 'report_details'                                        => $report_details]);
        }
    }

    function saveEventInformation(Request $request)
    {
        $user_id                                = $request->user_id;
        $report_id                              = $request->report_id;
        $saved_status                           = $request->saved_status;
        $Place_of_the_incident_1st              = $request->Place_of_the_incident_1st;
        $Place_of_the_incident_2nd              = $request->Place_of_the_incident_2nd;
        $Date_of_incident_event_information     = $request->Date_of_incident_event_information;
        $Time_of_incident_event_information_LMT = $request->Time_of_incident_event_information_LMT;
        $Time_of_incident_event_information_GMT = $request->Time_of_incident_event_information_GMT;
        $Location_of_incident                   = $request->Location_of_incident;
        $Operation                              = $request->Operation;
        $Others_operation_EI                    = $request->Others_operation_EI;
        $Vessel_Condition                       = $request->Vessel_Condition;
        $cargo_type_and_quantity                = $request->cargo_type_and_quantity;
        $Wind_force                             = $request->Wind_force;
        $Direction                              = $request->Direction;
        $Swell_height                           = $request->Swell_height;
        $Swell_length                           = $request->Swell_length;
        $Swell_direction                        = $request->Swell_direction;
        $Sky                                    = $request->Sky;
        $Visibility                             = $request->Visibility;
        $Rolling                                = $request->Rolling;
        $Pitcing                                = $request->Pitcing;
        $Illumination                           = $request->Illumination;
        $pi_club_information                    = $request->pi_club_information;
        $hm_informed                            = $request->hm_informed;
        $remarks_tol                            = $request->remarks_tol;

        $data_incident_report                   = '';
        $data_event_information                 = '';
        $data_event_weather                     = '';

        $is_data_present                        = DB::table('incident_report')->where('id', $report_id)->where('saved_status', $saved_status)->first();
        if ($is_data_present != null) {
            DB::table('incident_report')->where('id', $report_id)->where('saved_status', $saved_status)->update(['p_n_i_club_informed'                      => $pi_club_information, 'h_n_m_informed'                      => $hm_informed, 'type_of_loss_remarks'                      => $remarks_tol,]);
            $data_incident_report = 'updated';
        } else {
            DB::table('incident_report')->insert(['p_n_i_club_informed'                      => $pi_club_information, 'h_n_m_informed'                      => $hm_informed, 'type_of_loss_remarks'                      => $type_of_loss_remarks,]);
            $data_incident_report = 'created';
        }

        // incident_reports_event_information
        $event_inform         = DB::table('incident_reports_event_information')->where('incident_report_id', $report_id)->first();
        if ($event_inform != null) {
            DB::table('incident_reports_event_information')->where('incident_report_id', $report_id)->update(['date_of_incident'                        => $Date_of_incident_event_information, 'place_of_incident'                        => $Place_of_the_incident_1st, 'place_of_incident_position'                        => $Place_of_the_incident_2nd, 'time_of_incident_lt'                        => $Time_of_incident_event_information_LMT, 'time_of_incident_gmt'                        => $Time_of_incident_event_information_GMT, 'location_of_incident'                        => $Location_of_incident, 'operation'                        => $Operation, 'vessel_condition'                        => $Vessel_Condition, 'cargo_type_and_quantity'                        => $cargo_type_and_quantity]);
            $data_event_information = 'updated';
        } else {
            DB::table('incident_reports_event_information')->insert(['incident_report_id'                        => $report_id, 'date_of_incident'                        => $Date_of_incident_event_information, 'place_of_incident'                        => $Place_of_the_incident_1st, 'place_of_incident_position'                        => $Place_of_the_incident_2nd, 'time_of_incident_lt'                        => $Time_of_incident_event_information_LMT, 'time_of_incident_gmt'                        => $Time_of_incident_event_information_GMT, 'location_of_incident'                        => $Location_of_incident, 'operation'                        => $Operation, 'vessel_condition'                        => $Vessel_Condition, 'cargo_type_and_quantity'                        => $cargo_type_and_quantity]);
            $data_event_information = 'created';
        }

        // incident_reports_weather
        $event_report_weather   = DB::table('incident_reports_weather')->where('incident_report_id', $report_id)->first();
        if ($event_report_weather != null) {
            DB::table('incident_reports_weather')->where('incident_report_id', $report_id)->update(['wind_force'                    => $Wind_force, 'wind_direction'                    => $Direction, 'swell_height'                    => $Swell_height, 'swell_length'                    => $Swell_length, 'swell_direction'                    => $Swell_direction, 'sky'                    => $Sky, 'visibility'                    => $Visibility, 'rolling'                    => $Rolling, 'pitching'                    => $Pitcing, 'illumination'                    => $Illumination]);
            $data_event_weather = 'updated';
        } else {
            DB::table('incident_reports_weather')->insert(['incident_report_id'                    => $report_id, 'wind_force'                    => $Wind_force, 'wind_direction'                    => $Direction, 'swell_height'                    => $Swell_height, 'swell_length'                    => $Swell_length, 'swell_direction'                    => $Swell_direction, 'sky'                    => $Sky, 'visibility'                    => $Visibility, 'rolling'                    => $Rolling, 'pitching'                    => $Pitcing, 'illumination'                    => $Illumination]);
            $data_event_weather = 'created';
        }

        return json_encode(['req'                 => $request->all(), 'msg_incident_report'                 => $data_incident_report, 'msg_event_info'                 => $data_event_information, 'msg_event_weather'                 => $data_event_weather]);
    }

    function saveEventLog(Request $request)
    {
        $user_id         = $request->user_id;
        $report_id       = $request->report_id;
        $saved_status    = $request->saved_status;
        $event_date      = $request->event_date;
        $event_time      = $request->event_time;
        $event_remarks   = $request->event_remarks;

        $is_data_present = DB::table('incident_reports_event_logs')->where('incident_report_id', $report_id)->get();

        if ($is_data_present != null && count($is_data_present) != 0) {
            $is_data_present = DB::table('incident_reports_event_logs')->where('incident_report_id', $report_id)->delete();
            for ($j               = 0; $j < count($event_date); $j++) {
                DB::table('incident_reports_event_logs')->insert(['incident_report_id'                 => $report_id, 'date'                 => $event_date[$j], 'time'                 => $event_time[$j], 'remarks'                 => $event_remarks[$j]]);
            }
            $is_data_present = DB::table('incident_reports_event_logs')->where('incident_report_id', $report_id)->get();
            return json_encode(['data_present'   => $is_data_present, 'msg'   => 'data updated']);
        } else {
            for ($j = 0; $j < count($event_date); $j++) {
                DB::table('incident_reports_event_logs')->insert(['incident_report_id'                 => $report_id, 'date'                 => $event_date[$j], 'time'                 => $event_time[$j], 'remarks'                 => $event_remarks[$j]]);
            }
            $is_data_present = DB::table('incident_reports_event_logs')->where('incident_report_id', $report_id)->get();
            return json_encode(['data_present'                                                                         => $is_data_present, 'msg'                                                                         => 'data created']);
        }
    }

    function saveRootCauseFindings(Request $request)
    {
        // incident-report table [risk_category]
        $Risk_category_IIARCF                                                    = $request->Risk_category_IIARCF;
        $user_id                                                                 = $request->user_id;
        $report_id                                                               = $request->report_id;
        $saved_status                                                            = $request->saved_status;

        $Event_Details_IIARCF                                                    = $request->Event_Details_IIARCF;

        if ($Risk_category_IIARCF == 'SAFETY') {
            $IIARCF_safety_first_dropdown                                            = $request->IIARCF_safety_first_dropdown;
            $IIARCF_safety_Severity                                                  = $request->IIARCF_safety_Severity;
            $IIARCF_safety_Likelihood                                                = $request->IIARCF_safety_Likelihood;
            $IIARCF_safety_Result                                                    = $request->IIARCF_safety_Result;
            $IIARCF_safety_NameOfThePerson                                           = $request->IIARCF_safety_NameOfThePerson;
            $IIARCF_safety_TypeOfInjury                                              = $request->IIARCF_safety_TypeOfInjury;
            $IIARCF_safety_AssociatedCost                                            = $request->IIARCF_safety_AssociatedCost;
            $selected_currency_safety                                                = $request->selected_currency_safety;
            $IIARCF_safety_localCurrency                                             = $request->IIARCF_safety_localCurrency;
        }

        if ($Risk_category_IIARCF == 'HEALTH') {
            $IIARCF_HEALTH_first_dropdown                                            = $request->IIARCF_HEALTH_first_dropdown;
            $IIARCF_HEALTH_Severity                                                  = $request->IIARCF_HEALTH_Severity;
            $IIARCF_HEALTH_Likelihood                                                = $request->IIARCF_HEALTH_Likelihood;
            $IIARCF_HEALTH_Result                                                    = $request->IIARCF_HEALTH_Result;
            $IIARCF_HEALTH_NameOfThePerson                                           = $request->IIARCF_HEALTH_NameOfThePerson;
            $IIARCF_HEALTH_TypeOfInjury                                              = $request->IIARCF_HEALTH_TypeOfInjury;
            $IIARCF_HEALTH_AssociatedCost                                            = $request->IIARCF_HEALTH_AssociatedCost;
            $selected_currency_health                                                = $request->selected_currency_health;
            $IIARCF_HEALTH_localCurrency                                             = $request->IIARCF_HEALTH_localCurrency;
        }

        if ($Risk_category_IIARCF == 'ENVIRONMENT') {
            $IIARCF_ENVIRONMENT_first_dropdown                                       = $request->IIARCF_ENVIRONMENT_first_dropdown;
            $IIARCF_ENVIRONMENT_Severity                                             = $request->IIARCF_ENVIRONMENT_Severity;
            $IIARCF_ENVIRONMENT_Likelihood                                           = $request->IIARCF_ENVIRONMENT_Likelihood;
            $IIARCF_ENVIRONMENT_Result                                               = $request->IIARCF_ENVIRONMENT_Result;
            $IIARCF_ENVIRONMENT_TypeOfPollution                                      = $request->IIARCF_ENVIRONMENT_TypeOfPollution;
            $IIARCF_ENVIRONMENT_QuantityOfPollutantIIARCF_ENVIRONMENT_SpilledInWater = $request->IIARCF_ENVIRONMENT_QuantityOfPollutantIIARCF_ENVIRONMENT_SpilledInWater;
            $IIARCF_ENVIRONMENT_AssociatedCost                                       = $request->IIARCF_ENVIRONMENT_AssociatedCost;
            $selected_currency_environment                                           = $request->selected_currency_environment;
            $IIARCF_ENVIRONMENT_localCurrency                                        = $request->IIARCF_ENVIRONMENT_localCurrency;
            $IIARCF_ENVIRONMENT_ContainedSpill                                       = $request->IIARCF_ENVIRONMENT_ContainedSpill;
            $IIARCF_ENVIRONMENT_TotalSpilledQuantity                                 = $request->IIARCF_ENVIRONMENT_TotalSpilledQuantity;
            $IIARCF_ENVIRONMENT_SpilledInWater                                       = $request->IIARCF_ENVIRONMENT_SpilledInWater;
            $IIARCF_ENVIRONMENT_SpilledAshore                                        = $request->IIARCF_ENVIRONMENT_SpilledAshore;
        }

        if ($Risk_category_IIARCF == 'OPERATIONAL IMPACT') {
            $IIARCF_OPERATIONAL_IMPACT_Vessel                                        = $request->IIARCF_OPERATIONAL_IMPACT_Vessel;
            $IIARCF_OPERATIONAL_IMPACT_Cargo                                         = $request->IIARCF_OPERATIONAL_IMPACT_Cargo;
            $IIARCF_OPERATIONAL_IMPACT_Third_Party                                   = $request->IIARCF_OPERATIONAL_IMPACT_Third_Party;
            $IIARCF_OPERATIONAL_IMPACT_first_dropdown                                = $request->IIARCF_OPERATIONAL_IMPACT_first_dropdown;
            $IIARCF_OPERATIONAL_IMPACT_Severity                                      = $request->IIARCF_OPERATIONAL_IMPACT_Severity;
            $IIARCF_OPERATIONAL_IMPACT_Likelihood                                    = $request->IIARCF_OPERATIONAL_IMPACT_Likelihood;
            $IIARCF_OPERATIONAL_IMPACT_Result                                        = $request->IIARCF_OPERATIONAL_IMPACT_Result;
            $IIARCF_OPERATIONAL_IMPACT_Damage_description                            = $request->IIARCF_OPERATIONAL_IMPACT_Damage_description;
            $IIARCF_OPERATIONAL_IMPACT_Off_hire_if_any                               = $request->IIARCF_OPERATIONAL_IMPACT_Off_hire_if_any;
            $IIARCF_OPERATIONAL_IMPACT_AssociatedCost                                = $request->IIARCF_OPERATIONAL_IMPACT_AssociatedCost;
            $selected_currency_operational_impact                                    = $request->selected_currency_operational_impact;
            $IIARCF_OPERATIONAL_IMPACT_localCurrency                                 = $request->IIARCF_OPERATIONAL_IMPACT_localCurrency;
        }

        if ($Risk_category_IIARCF == 'MEDIA') {
            $IIARCF_MEDIA_first_dropdown                                             = $request->IIARCF_MEDIA_first_dropdown;
            $IIARCF_MEDIA_Severity                                                   = $request->IIARCF_MEDIA_Severity;
            $IIARCF_MEDIA_Likelihood                                                 = $request->IIARCF_MEDIA_Likelihood;
            $IIARCF_MEDIA_Result                                                     = $request->IIARCF_MEDIA_Result;
            $IIARCF_MEDIA_describtion                                                = $request->IIARCF_MEDIA_describtion;
            $IIARCF_MEDIA_AssociatedCost                                             = $request->IIARCF_MEDIA_AssociatedCost;
            $selected_currency_media                                                 = $request->selected_currency_media;
            $IIARCF_MEDIA_localCurrency                                              = $request->IIARCF_MEDIA_localCurrency;
            $IIARCF_MEDIA_type                                                       = $request->IIARCF_MEDIA_type;
        }
        $immediatecause                                                          = $request->immediatecause;
        $immediatecause_second                                                   = $request->immediatecause_second;
        $immediatecause_third                                                    = $request->immediatecause_third;

        $data_1                                                                  = new stdClass();
        $data_2                                                                  = new stdClass();
        $data_3                                                                  = new stdClass();
        // store immediate-cause
        $is_cause_present                                                        = DB::table('incident_reports_immediate_causes')->where('incident_report_id', $report_id)->first();
        if ($is_cause_present != null) {
            $data_1                                                                  = DB::table('near_miss_dropdown_main_type')->where('id', $immediatecause)->first();

            $data_2                                                                  = DB::table('near_miss_dropdown_sub_type')->where('id', $immediatecause_second)->first();

            $data_3                                                                  = DB::table('near_miss_dropdown_ter_type')->where('id', $immediatecause_third)->first();

            DB::table('incident_reports_immediate_causes')
                ->where('incident_report_id', $report_id)->update(['primary'        => $immediatecause, 'secondary'        => $immediatecause_second, 'tertiary'        => $immediatecause_third]);
        } else {
            $data_1 = DB::table('near_miss_dropdown_main_type')->where('id', $immediatecause)->first();

            $data_2 = DB::table('near_miss_dropdown_sub_type')->where('id', $immediatecause_second)->first();

            $data_3 = DB::table('near_miss_dropdown_ter_type')->where('id', $immediatecause_third)->first();

            DB::table('incident_reports_immediate_causes')
                ->insert(['incident_report_id'                          => $report_id, 'primary'                          => $immediatecause, 'secondary'                          => $immediatecause_second, 'tertiary'                          => $immediatecause_third]);
        }

        // store event details
        $is_event_present         = DB::table('incident_reports_event_details')->where('incident_report_id', $report_id)->get();

        $is_event_details_updated = 'updated';
        if ($is_event_present != null && count($is_event_present) > 0) {
            // data is already present
            DB::table('incident_reports_event_details')->where('incident_report_id', $report_id)->delete();
            for ($i = 0; $i < count($Event_Details_IIARCF); $i++) {
                DB::table('incident_reports_event_details')->insert(['incident_report_id' => $report_id, 'details' => $Event_Details_IIARCF[$i]]);
            }
        } else {
            // data is not present
            DB::table('incident_reports_event_details')->where('incident_report_id', $report_id)->delete();
            for ($i = 0; $i < count($Event_Details_IIARCF); $i++) {
                DB::table('incident_reports_event_details')->insert(['incident_report_id'                          => $report_id, 'details'                          => $Event_Details_IIARCF[$i]]);
            }
            $is_event_details_updated = 'created';
        }

        // store risk category in incident report table
        $is_data_present          = DB::table('incident_report')->where('id', $report_id)->where('saved_status', $saved_status)->where('user_id', $user_id)->first();

        $is_data_updated          = 'updated';
        if ($is_data_present != null) {
            // data already present
            DB::table('incident_report')->where('id', $report_id)->where('saved_status', $saved_status)->where('user_id', $user_id)->update(['risk_category'                 => $Risk_category_IIARCF]);
            $is_data_updated = 'updated';
        } else {
            DB::table('incident_report')->insert(['saved_status'                 => $saved_status, 'user_id', $user_id, 'risk_category'                 => $Risk_category_IIARCF]);
            $is_data_updated = 'created';
        }

        // store risk details
        $is_risk_updated = 'updated';

        // SAFETY
        if ($Risk_category_IIARCF == 'SAFETY') {
            $is_present      = DB::table('incident_reports_risk_details')->where('incident_report_id', $report_id)->get();
            if ($is_present != null && count($is_present) > 0) {
                DB::table('incident_reports_risk_details')->where('incident_report_id', $report_id)->update(['risk'                 => $IIARCF_safety_first_dropdown, 'severity'                 => $IIARCF_safety_Severity, 'likelihood'                 => $IIARCF_safety_Likelihood, 'result'                 => $IIARCF_safety_Result, 'name_of_person'                 => $IIARCF_safety_NameOfThePerson, 'type_of_injury'                 => $IIARCF_safety_TypeOfInjury, 'associated_cost_usd'                 => $IIARCF_safety_AssociatedCost, 'associated_cost_loca'                 => $IIARCF_safety_localCurrency, 'currency_code'                 => $selected_currency_safety]);
                $is_risk_updated = 'safety updated';
            } else {
                DB::table('incident_reports_risk_details')->insert(['incident_report_id'                 => $report_id, 'risk'                 => $IIARCF_safety_first_dropdown, 'severity'                 => $IIARCF_safety_Severity, 'likelihood'                 => $IIARCF_safety_Likelihood, 'result'                 => $IIARCF_safety_Result, 'name_of_person'                 => $IIARCF_safety_NameOfThePerson, 'type_of_injury'                 => $IIARCF_safety_TypeOfInjury, 'associated_cost_usd'                 => $IIARCF_safety_AssociatedCost, 'associated_cost_loca'                 => $IIARCF_safety_localCurrency, 'currency_code'                 => $selected_currency_safety]);
                $is_risk_updated = 'safety created';
            }
        }

        // HEALTH
        if ($Risk_category_IIARCF == 'HEALTH') {
            $is_present      = DB::table('incident_reports_risk_details')->where('incident_report_id', $report_id)->get();
            if ($is_present != null && count($is_present) > 0) {
                DB::table('incident_reports_risk_details')->where('incident_report_id', $report_id)->update(['risk'                 => $IIARCF_HEALTH_first_dropdown, 'severity'                 => $IIARCF_HEALTH_Severity, 'likelihood'                 => $IIARCF_HEALTH_Likelihood, 'result'                 => $IIARCF_HEALTH_Result, 'name_of_person'                 => $IIARCF_HEALTH_NameOfThePerson, 'type_of_injury'                 => $IIARCF_HEALTH_TypeOfInjury, 'associated_cost_usd'                 => $IIARCF_HEALTH_AssociatedCost, 'associated_cost_loca'                 => $IIARCF_HEALTH_localCurrency, 'currency_code'                 => $selected_currency_health]);
                $is_risk_updated = 'health updated';
            } else {
                DB::table('incident_reports_risk_details')->insert(['incident_report_id'                 => $report_id, 'risk'                 => $IIARCF_HEALTH_first_dropdown, 'severity'                 => $IIARCF_HEALTH_Severity, 'likelihood'                 => $IIARCF_HEALTH_Likelihood, 'result'                 => $IIARCF_HEALTH_Result, 'name_of_person'                 => $IIARCF_HEALTH_NameOfThePerson, 'type_of_injury'                 => $IIARCF_HEALTH_TypeOfInjury, 'associated_cost_usd'                 => $IIARCF_HEALTH_AssociatedCost, 'associated_cost_loca'                 => $IIARCF_HEALTH_localCurrency, 'currency_code'                 => $selected_currency_health]);
                $is_risk_updated = 'health created';
            }
        }

        // ENVIRONMENT
        if ($Risk_category_IIARCF == 'ENVIRONMENT') {
            $is_present      = DB::table('incident_reports_risk_details')->where('incident_report_id', $report_id)->get();
            if ($is_present != null && count($is_present) > 0) {
                DB::table('incident_reports_risk_details')->where('incident_report_id', $report_id)->update(['risk'                 => $IIARCF_ENVIRONMENT_first_dropdown, 'severity'                 => $IIARCF_ENVIRONMENT_Severity, 'likelihood'                 => $IIARCF_ENVIRONMENT_Likelihood, 'result'                 => $IIARCF_ENVIRONMENT_Result, 'type_of_pollution'                 => $IIARCF_ENVIRONMENT_TypeOfPollution, 'quantity_of_pollutant'                 => $IIARCF_ENVIRONMENT_QuantityOfPollutantIIARCF_ENVIRONMENT_SpilledInWater, 'associated_cost_usd'                 => $IIARCF_ENVIRONMENT_AssociatedCost, 'associated_cost_loca'                 => $IIARCF_ENVIRONMENT_localCurrency, 'currency_code'                 => $selected_currency_environment, 'contained_spill'                 => $IIARCF_ENVIRONMENT_ContainedSpill, 'total_spilled_quantity'                 => $IIARCF_ENVIRONMENT_TotalSpilledQuantity, 'spilled_in_water'                 => $IIARCF_ENVIRONMENT_SpilledInWater, 'spilled_ashore'                 => $IIARCF_ENVIRONMENT_SpilledAshore]);
                $is_risk_updated = 'health updated';
            } else {
                DB::table('incident_reports_risk_details')->insert(['incident_report_id'                 => $report_id, 'risk'                 => $IIARCF_ENVIRONMENT_first_dropdown, 'severity'                 => $IIARCF_ENVIRONMENT_Severity, 'likelihood'                 => $IIARCF_ENVIRONMENT_Likelihood, 'result'                 => $IIARCF_ENVIRONMENT_Result, 'type_of_pollution'                 => $IIARCF_ENVIRONMENT_TypeOfPollution, 'quantity_of_pollutant'                 => $IIARCF_ENVIRONMENT_QuantityOfPollutantIIARCF_ENVIRONMENT_SpilledInWater, 'associated_cost_usd'                 => $IIARCF_ENVIRONMENT_AssociatedCost, 'associated_cost_loca'                 => $IIARCF_ENVIRONMENT_localCurrency, 'currency_code'                 => $selected_currency_environment, 'contained_spill'                 => $IIARCF_ENVIRONMENT_ContainedSpill, 'total_spilled_quantity'                 => $IIARCF_ENVIRONMENT_TotalSpilledQuantity, 'spilled_in_water'                 => $IIARCF_ENVIRONMENT_SpilledInWater, 'spilled_ashore'                 => $IIARCF_ENVIRONMENT_SpilledAshore]);
                $is_risk_updated = 'health created';
            }
        }

        // OPERATIONAL IMPACT
        if ($Risk_category_IIARCF == 'OPERATIONAL IMPACT') {
            $is_present      = DB::table('incident_reports_risk_details')->where('incident_report_id', $report_id)->get();
            if ($is_present != null && count($is_present) > 0) {
                DB::table('incident_reports_risk_details')->where('incident_report_id', $report_id)->update(['vessel'                 => $IIARCF_OPERATIONAL_IMPACT_Vessel, 'cargo'                 => $IIARCF_OPERATIONAL_IMPACT_Cargo, 'third_party'                 => $IIARCF_OPERATIONAL_IMPACT_Third_Party, 'risk'                 => $IIARCF_OPERATIONAL_IMPACT_first_dropdown, 'severity'                 => $IIARCF_OPERATIONAL_IMPACT_Severity, 'likelihood'                 => $IIARCF_OPERATIONAL_IMPACT_Likelihood, 'result'                 => $IIARCF_OPERATIONAL_IMPACT_Result, 'damage_description'                 => $IIARCF_OPERATIONAL_IMPACT_Damage_description, 'off_hire'                 => $IIARCF_OPERATIONAL_IMPACT_Off_hire_if_any, 'associated_cost_usd'                 => $IIARCF_OPERATIONAL_IMPACT_AssociatedCost, 'associated_cost_loca'                 => $IIARCF_OPERATIONAL_IMPACT_localCurrency, 'currency_code'                 => $selected_currency_operational_impact]);
                $is_risk_updated = 'operational impact updated';
            } else {
                DB::table('incident_reports_risk_details')->insert([
                    'incident_report_id'                 => $report_id, 'vessel'                 => $IIARCF_OPERATIONAL_IMPACT_Vessel, 'cargo'                 => $IIARCF_OPERATIONAL_IMPACT_Cargo, 'third_party'                 => $IIARCF_OPERATIONAL_IMPACT_Third_Party, 'risk'                 => $IIARCF_OPERATIONAL_IMPACT_first_dropdown, 'severity'                 => $IIARCF_OPERATIONAL_IMPACT_Severity, 'likelihood'                 => $IIARCF_OPERATIONAL_IMPACT_Likelihood, 'result'                 => $IIARCF_OPERATIONAL_IMPACT_Result, 'damage_description'                 => $IIARCF_OPERATIONAL_IMPACT_Damage_description, 'off_hire'                 => $IIARCF_OPERATIONAL_IMPACT_Off_hire_if_any, 'associated_cost_usd'                 => $IIARCF_OPERATIONAL_IMPACT_AssociatedCost, 'associated_cost_loca'                 => $IIARCF_OPERATIONAL_IMPACT_localCurrency, 'currency_code'                 => $selected_currency_operational_impact

                ]);
                $is_risk_updated = 'operational impact created';
            }
        }

        // MEDIA
        if ($Risk_category_IIARCF == 'MEDIA') {
            $is_present      = DB::table('incident_reports_risk_details')->where('incident_report_id', $report_id)->get();
            if ($is_present != null && count($is_present) > 0) {
                DB::table('incident_reports_risk_details')->where('incident_report_id', $report_id)->update(['risk'                 => $IIARCF_MEDIA_first_dropdown, 'severity'                 => $IIARCF_MEDIA_Severity, 'likelihood'                 => $IIARCF_MEDIA_Likelihood, 'result'                 => $IIARCF_MEDIA_Result, 'description'                 => $IIARCF_MEDIA_describtion, 'associated_cost_usd'                 => $IIARCF_MEDIA_AssociatedCost, 'associated_cost_loca'                 => $IIARCF_MEDIA_localCurrency, 'currency_code'                 => $selected_currency_media, 'type'                 => $IIARCF_MEDIA_type]);
                $is_risk_updated = 'operational impact updated';
            } else {
                DB::table('incident_reports_risk_details')->insert([
                    'incident_report_id'                 => $report_id, 'risk'                 => $IIARCF_MEDIA_first_dropdown, 'severity'                 => $IIARCF_MEDIA_Severity, 'likelihood'                 => $IIARCF_MEDIA_Likelihood, 'result'                 => $IIARCF_MEDIA_Result, 'description'                 => $IIARCF_MEDIA_describtion, 'associated_cost_usd'                 => $IIARCF_MEDIA_AssociatedCost, 'associated_cost_loca'                 => $IIARCF_MEDIA_localCurrency, 'currency_code'                 => $selected_currency_media, 'type'                 => $IIARCF_MEDIA_type

                ]);
                $is_risk_updated = 'operational impact created';
            }
        }
        return json_encode(['main_table' => $data_1, 'sub_table' => $data_2, 'ter_table' => $data_3, 'msg' => 'updated']);
    }



    // Generating ID .....
    function Generating_child_ID($table_name, $parent_id, $ID_format)
    {
        $new_id = $ID_format . '__' . '1';

        if ($table_name == 'incident_reports_supporting_team_members') {
            $last_data = DB::table("" . $table_name . "")->where('IRI', $parent_id)->orderBy('auto_inc', 'DESC')->first();
        } else {
            $last_data = DB::table("" . $table_name . "")->where('incident_report_id', $parent_id)->orderBy('auto_inc', 'DESC')->first();
        }
        if ($last_data != null) {
            $last_id =  $last_data->id;
            $new_id_count = (int)explode('__', $last_id)[2] + 1;
            $new_id = $ID_format . '__' . $new_id_count;
        }
        return $new_id;
    }

    // Converting images to base64 .....
    public function Convert_base64($img_path)
    {
        try {

            // Constructing image absolute path .....
            $imagePath = env('UPLOAD_PATH') . $img_path;

            $type = pathinfo($imagePath, PATHINFO_EXTENSION);

            $arrContextOptions = array(
                "ssl" => array(
                    "verify_peer" => false,
                    "verify_peer_name" => false,
                ),
            );

            $avatarData = file_get_contents($imagePath, false, stream_context_create($arrContextOptions));
            $avatarBase64Data = base64_encode($avatarData);
            $imageData = 'data:image/' . $type . ';base64,' . $avatarBase64Data;

            return $imageData;
        } catch (Exception $e) {
            report($e);
        }
    }
    // this function will create new draft
    public function createNewDraft(){
        // Getting Ship Name if its Ship .....
        if (session('is_ship')) {
            $ship_name = DB::table('vessels')->where('unique_id', session('creator_id'))->first()->name;
        } else {
            $ship_name = false;
        }


        // root caus etc
        $user_id                = Auth::user()->id;
        $report_id              = DB::table('incident_report')->where('user_id', $user_id)->where('saved_status', 'temporary')
            ->orderBy('id', 'desc')
            ->first();
        if ($report_id == null) {
            $report_id              = "";
        }

        $dropdown               = DB::table('near_miss_dropdown')->get();
        $dropmain               = DB::table('near_miss_dropdown_main_type')->get();
        $crew_list              = DB::table('crew_list')->get();
        $data                   = DB::table('vessels')->leftJoin('vessel_details', 'vessels.unique_id', '=', 'vessel_details.id')->get()->first();

        $Slight                 = DB::table('incident_reports_classification_matrix')->where('id', '1')
            ->get();
        $Minor                  = DB::table('incident_reports_classification_matrix')->where('id', '2')
            ->get();
        $Medium                 = DB::table('incident_reports_classification_matrix')->where('id', '3')
            ->get();
        $Major                  = DB::table('incident_reports_classification_matrix')->where('id', '4')
            ->get();
        $Extreme                = DB::table('incident_reports_classification_matrix')->where('id', '5')
            ->get();
        $incident_report_number = DB::table('incident_report_number')->get()
            ->last();
        $country_list           = DB::table('currency')->get();

        //generate a draft
        $id =  (new GenericController)->getUniqueId('incident_report', config('constants.UNIQUE_ID_TEXT.INCIDENT_REPORTING'));
        $incidents_report                            = new incident_report; // creating incident obj
        $incidents_report->id                        = $id;
        $incidents_report->creator_id                = session('creator_id');
        $incidents_report->status                    = 'Draft';        $incidents_report->creator_email             =  session('email');
        $incidents_report->save();

        $incident_table = incident_report::find($id);
        // response array .....
        $response_array = [
            'is_edit'           => 0,
            'country_list'      => $country_list,
            'vs_code'           => $incident_report_number,
            'data'              => $data,
            'crew_list'         => $crew_list,
            'dropdown'          => $dropdown,
            'dropdownmain'      => $dropmain,
            'report_details'    => $report_id,
            'slight'            => $Slight,
            'minor'             => $Minor,
            'major'             => $Major,
            'medium'            => $Medium,
            'extreme'           => $Extreme,
            'incident_report'   => $incident_table,
            'ship_name'         => $ship_name,
            'incident_image'    => null
        ];

        return view('incident_reporting.create', $response_array);
    }
    public function collectDraft(){
        // Getting Ship Name if its Ship .....
        if (session('is_ship')) {
            $ship_name = DB::table('vessels')->where('unique_id', session('creator_id'))->first()->name;
        } else {
            $ship_name = false;
        }
        // root caus etc
        $user_id                = Auth::user()->id;
        $report_id              = DB::table('incident_report')->where('user_id', $user_id)->where('saved_status', 'temporary')
            ->orderBy('id', 'desc')
            ->first();
        if ($report_id == null) {
            $report_id              = "";
        }
        $dropdown               = DB::table('near_miss_dropdown')->get();
        $dropmain               = DB::table('near_miss_dropdown_main_type')->get();
        $crew_list              = DB::table('crew_list')->get();
        $data                   = DB::table('vessels')->leftJoin('vessel_details', 'vessels.unique_id', '=', 'vessel_details.id')->get()->first();

        $Slight                 = DB::table('incident_reports_classification_matrix')->where('id', '1')
            ->get();
        $Minor                  = DB::table('incident_reports_classification_matrix')->where('id', '2')
            ->get();
        $Medium                 = DB::table('incident_reports_classification_matrix')->where('id', '3')
            ->get();
        $Major                  = DB::table('incident_reports_classification_matrix')->where('id', '4')
            ->get();
        $Extreme                = DB::table('incident_reports_classification_matrix')->where('id', '5')
            ->get();
        $incident_report_number = DB::table('incident_report_number')->get()
            ->last();
        $country_list           = DB::table('currency')->get();

        // collecting previous draft data
        $incident_table         = DB::table('incident_report')->where('creator_email',session('email'))
        ->where('status','Draft')
        ->orderBy('created_at','DESC')
        ->first();
        // dd($incident_table->id);
        $id = $incident_table->id;
        $incident_reports_crew_injury             = DB::table('incident_reports_crew_injury')->where('incident_report_id', $id)->first();
        $incident_reports_supporting_team_members = DB::table('incident_reports_supporting_team_members')->where('IRI', $id)->get();
        $incident_reports_event_information       = DB::table('incident_reports_event_information')->where('incident_report_id', $id)->first();
        $incident_reports_weather                 = DB::table('incident_reports_weather')->where('incident_report_id', $id)->first();
        $incident_reports_event_logs              = DB::table('incident_reports_event_logs')->where('incident_report_id', $id)->get();
        $incident_reports_event_details           = DB::table('incident_reports_event_details')->where('incident_report_id', $id)->get();
        $incident_reports_risk_details            = DB::table('incident_reports_risk_details')->where('incident_report_id', $id)->first();
        $incident_reports_immediate_causes        = DB::table('incident_reports_immediate_causes')->where('incident_report_id', $id)->get()->first();
        $incident_reports_root_causes             = DB::table('incident_reports_root_causes')->where('incident_report_id', $id)->get()->first();
        $incident_reports_preventive_actions      = DB::table('incident_reports_preventive_actions')->where('incident_report_id', $id)->get()->first();
        $incident_reports_five_why                = DB::table('incident_reports_five_why')->where('incident_report_id', $id)->get()->first();
        $incident_reports_follow_up_actions       = DB::table('incident_reports_follow_up_actions')->where('incident_report_id', $id)->get();
        if($incident_table->incident_image == null){
            $is_edit = 0;
        }
        else{
            $is_edit = 1;
        }
        $response_array = [

            'is_edit'                                       => $is_edit,
            'country_list'                                  => $country_list,
            'vs_code'                                       => $incident_report_number,
            'data'                                          => $data,
            'crew_list'                                     => $crew_list,
            'dropdown'                                      => $dropdown,
            'dropdownmain'                                  => $dropmain,
            'report_details'                                => $report_id,
            'slight'                                        => $Slight,
            'minor'                                         => $Minor,
            'major'                                         => $Major,
            'medium'                                        => $Medium,
            'extreme'                                       => $Extreme,
            'incident_report'                               => $incident_table,
            'ship_name'                                     => $ship_name,
            
            'incident_reports_crew_injury'                  => $incident_reports_crew_injury,
            'incident_reports_supporting_team_members'      => $incident_reports_supporting_team_members,
            'incident_reports_event_information'            => $incident_reports_event_information,
            'incident_reports_weather'                      => $incident_reports_weather,
            'incident_reports_event_logs'                   => $incident_reports_event_logs,
            'incident_reports_event_details'                => $incident_reports_event_details,
            'incident_reports_risk_details'                 => $incident_reports_risk_details,
            'incident_reports_immediate_causes'             => $incident_reports_immediate_causes,
            'incident_reports_root_causes'                  => $incident_reports_root_causes,
            'incident_reports_preventive_actions'           => $incident_reports_preventive_actions,
            'incident_reports_five_why'                     => $incident_reports_five_why,
            'incident_reports_follow_up_actions'            => $incident_reports_follow_up_actions,
            
            
            'vessel_name'                                   => $incident_table->vessel_name,
           
            'incident_image'                                => ($incident_table->incident_image != null)?(new FileSaver)->getImageBase64($incident_table->incident_image):''
        ];
        return view('incident_reporting.create', $response_array);
    }
    public function autosave(Request $r){
        if($r->step == 1){
            Log::info('i am in step 1 id :: '.print_r($r->all(),true));
            $incidents_report = incident_report::find($r->id);
            $incidents_report->investigation_matrix_fst  = $r->First_Parameter;
            $incidents_report->investigation_matrix_scnd = $r->Second_Parameter;
            $incidents_report->incident_header = $r->header;
            $incidents_report->save();

        }
        elseif($r->step == 2){
            Log::info('I am in step 2');
            $incidents_report = incident_report::find($r->id);  
            $incidents_report->vessel_name               = $r->Vessel_Name;
            $incidents_report->confidential              = $r->Confidential;
            $incidents_report->media_involved            = $r->media_involved;
            $incidents_report->created_by_name           = $r->Created_By;
            $incidents_report->created_by_rank           = $r->Created_By_Rank;
            $incidents_report->date_of_incident          = $r->Date_of_incident;
            $incidents_report->time_of_incident_lt       = $r->Time_of_incident;
            $incidents_report->date_report_created       = $r->Date_report_created;
            $incidents_report->time_of_incident_gmt      = $r->GMT;
            $incidents_report->voy_no                    = $r->Voy_No;
            $incidents_report->master                    = $r->Master;
            $incidents_report->chief_officer             = $r->Chief_officer;
            $incidents_report->chief_engineer            = $r->Chief_Engineer;
            $incidents_report->first_engineer            = $r->fstEng;
            $incidents_report->charterer                 = $r->Charterer;
            $incidents_report->agent                     = $r->Agent;
            $incidents_report->vessel_damage             = $r->Vessel_Damage;
            $incidents_report->cargo_damage              = $r->Cargo_damage;
            $incidents_report->third_party_liability     = $r->Third_Party_Liability;
            $incidents_report->environmental             = $r->Environmental;
            $incidents_report->commercial                = $r->Commercial_Service;
            $incidents_report->save();
            
            
            
            
        }
        elseif($r->step == 3){
            Log::info('I am in step 3 '.print_r($r->all(),true));
            $incidents_report = incident_report::find($r->id);
            $incidents_report->crew_injury               = $r->Crew_Injury;
            $incidents_report->other_personnel_injury    = $r->Other_Personnel_Injury;
            $incidents_report->lead_investigator         = $r->Lead_Investigator;

            // $incidents_report->p_n_i_club_informed       = $r->pi_club_information;
            // $incidents_report->h_n_m_informed            = $r->hm_informed;
            // $incidents_report->type_of_loss_remarks      = $r->remarks_tol;

            $incidents_report->save();
            DB::table('incident_reports_crew_injury')->where('incident_report_id',$r->id)->delete();
            DB::table('incident_reports_crew_injury')->insert([
                'id'                            => $this->Generating_child_ID('incident_reports_crew_injury',  $r->id, $r->id . '__IRCJ'),
                'incident_report_id'            => $r->id,
                'fatality'                      => $r->Fatality,
                'lost_workday_case'             => $r->Lost_Workday_Case,
                'restricted_work_case'          => $r->Restricted_Work_Case,
                'medical_treatment_case'        => $r->Medical_Treatment_Case,
                'lost_time_injuries'            => $r->Lost_Time_Injuries,
                'first_aid_case'                => $r->First_Aid_Case,
            ]);
            $STM = explode(",",$r->STM);
            Log::info("STM :: ".print_r($STM,true));
            if ($STM != null) {
                DB::table('incident_reports_supporting_team_members')->where('IRI', $r->id)->delete();
                $count_stm = 1;
                foreach ($STM as $stm) {
                    $count_stm = $count_stm + 2;
                    DB::table('incident_reports_supporting_team_members')->insert([
                        'id'            => $this->Generating_child_ID('incident_reports_supporting_team_members',  $r->id, $r->id . '__IRSTM') . '_' . $count_stm,
                        'IRI'           => $r->id,
                        'member_name'   => $stm
                    ]);
                }
            }
        }
        elseif($r->step == 4){
            $incidents_report = incident_report::find($r->id);
            $incidents_report->p_n_i_club_informed       = $r->pi_club_information;
            $incidents_report->h_n_m_informed            = $r->hm_informed;
            $incidents_report->type_of_loss_remarks      = $r->remarks_tol;
            $incidents_report->save();
            // deleting pre-existing data if exit
            DB::table('incident_reports_event_information')->where('incident_report_id',$r->id)->delete();
            DB::table('incident_reports_event_information')->insert([
                'id' => $this->Generating_child_ID(
                    'incident_reports_event_information',
                    $r->id,
                    $r->id . '__IREI'
                ),
                'incident_report_id' => $r->id,
                'place_of_incident' => $r->Place_of_the_incident_1st,
                'place_of_incident_position' => $r->Place_of_the_incident_2nd,
                'date_of_incident' => $r->Date_of_incident_event_information,
                'time_of_incident_lt' => $r->Time_of_incident_event_information_LMT,
                'time_of_incident_gmt' => $r->Time_of_incident_event_information_GMT,
                'location_of_incident' => $r->Location_of_incident,
                'operation' => $r->Operation,
                'vessel_condition' => $r->Vessel_Condition,
                'cargo_type_and_quantity' => $r->cargo_type_and_quantity,
                'lat_1' => $r->lat_1,
                'lat_2' => $r->lat_2,
                'lat_3' => $r->lat_3,
                'long_1' => $r->long_1,
                'long_2' => $r->long_2,
                'long_3' => $r->long_3
            ]);
            // deleting pre-existing data if exit
            DB::table('incident_reports_weather')->where('incident_report_id',$r->id)->delete();
            DB::table('incident_reports_weather')->insert([
                'id'   => $this->Generating_child_ID('incident_reports_weather',  $r->id, $r->id . '__IRW'), 
                'incident_report_id'   => $r->id, 
                'wind_force'   => $r->Wind_force, 
                'wind_direction'   => $r->Direction, 
                'sea_wave'   => $r->Sea, 
                'sea_direction'   => $r->sea_Direction, 
                'swell_height'   => $r->Swell_height, 
                'swell_length'   => $r->Swell_length, 
                'swell_direction'   => $r->Swell_direction, 
                'sky'   => $r->Sky, 
                'visibility'   => $r->Visibility, 
                'rolling'   => $r->Rolling, 
                'pitching'   => $r->Pitcing, 
                'illumination'   => $r->Illumination,
    
            ]);
        }
        elseif($r->step == 5){
            Log::info("i am in step 5 ".print_r($r->all(),true));

            $incidents_report = incident_report::find($r->id);
            $incidents_report->incident_brief = $r->Incident_in_brief;
            $incidents_report->save();
           
            $date = explode(',',$r->Date);
            $time = explode(',',$r->Time);
            $remarks = explode(',',$r->Remark);
            Log::info('Time : '.print_r($time[0],true));
            // deleting pre existing data if present
            DB::table('incident_reports_event_logs')->where('incident_report_id', $r->id)->delete();
            if (count($date)!=0) {
                $inc_event = 1;
                for ($i = 0; $i < count($date); $i++) {
                    $inc_event = $inc_event + 2;
                    DB::table('incident_reports_event_logs')
                    ->insert(['id'           => $this->Generating_child_ID('incident_reports_event_logs',  $r->id, $r->id . '__IREL') . '_' . $inc_event, 
                    'incident_report_id'           => $r->id, 
                    'date'           => $date[$i], 
                    'time'           => $time[$i], 
                    'remarks'           => $remarks[$i]]);
                }
            }
        }
        elseif($r->step == 6){
            Log::info('I am in step 6 :: '.print_r($r->all(),true));
            $uploadUrlSegment = $r->id.DIRECTORY_SEPARATOR.config('constants.INCIDENT_REPORTING_IMAGE_FOLDERS.INCIDENT_IMAGES');
            $pathImage = (new FileSaver)->saveImageBase64($uploadUrlSegment, config('constants.MODULES.INCIDENT_REPORTING'), $r->imageEncodedInput);

            // Updating inside DB .....
            DB::table('incident_report')->where('id', $r->id)->update([
                'incident_image' => $pathImage
            ]);

        }
        elseif($r->step == 7){

            Log::info("I am in step 7 :".print_r($r->all(),true));
            
            $incidents_report = incident_report::find($r->id);
            $incidents_report->risk_category = $r->Risk_category_IIARCF;
            $incidents_report->save();
            
            // delete previous data if present
            DB::table('incident_reports_event_details')->where('incident_report_id', $r->id)->delete();
            $Event_Details_IIARCF_array = explode(',',$r->eventDetails);
            $event_id = 1;
            foreach ($Event_Details_IIARCF_array as $Event_Details_IIARCF) {
                $event_id = $event_id + 2;
                DB::table('incident_reports_event_details')->insert([
                    'id' => $this->Generating_child_ID('incident_reports_event_details',  $r->id, $r->id . '__IRED') . '_' . $event_id, 'incident_report_id' => $r->id, 'details' => $Event_Details_IIARCF,

                ]);
            }

            // start
            // deleting previous data, if present
            DB::table('incident_reports_risk_details')->where('incident_report_id', $r->id)->delete();
            // saving SAFETY .....
            if ($r->Risk_category_IIARCF == 'SAFETY') {
                DB::table('incident_reports_risk_details')->insert([
                    'id' => $this->Generating_child_ID('incident_reports_risk_details',  $r->id, $r->id . '__IRRD'),
                    'incident_report_id' => $r->id,
                    'risk' => $r->IIARCF_safety_first_dropdown,
                    'severity' => $r->IIARCF_safety_Severity,
                    'likelihood' => $r->IIARCF_safety_Likelihood,
                    'result' => $r->IIARCF_safety_Result,
                    'name_of_person' => $r->IIARCF_safety_NameOfThePerson,
                    'type_of_injury' => $r->IIARCF_safety_TypeOfInjury,
                    'associated_cost_usd' => $r->IIARCF_safety_AssociatedCost,
                    'associated_cost_loca' => $r->IIARCF_safety_localCurrency,
                    'type_of_pollution' => 'N/A',
                    'quantity_of_pollutant' => 'N/A',
                    'contained_spill' => 'N/A',
                    'total_spilled_quantity' => 'N/A',
                    'spilled_in_water' => 'N/A',
                    'spilled_ashore' => 'N/A',
                    'vessel' => 'N/A',
                    'cargo' => 'N/A',
                    'third_party' => 'N/A',
                    'damage_description' => 'N/A',
                    'off_hire' => 'N/A',
                    'description' => 'N/A',
                    'type' => 'N/A',
                    'currency_code' => $r->selected_currency_safety
    
                ]);
            }
            // saving HEALTH .....
            if ($r->Risk_category_IIARCF == 'HEALTH') {
                DB::table('incident_reports_risk_details')->insert([
                    'id' => $this->Generating_child_ID('incident_reports_risk_details',  $r->id, $r->id . '__IRRD'),
                    'incident_report_id' => $r->id,
                    'risk' => $r->IIARCF_HEALTH_first_dropdown,
                    'severity' => $r->IIARCF_HEALTH_Severity,
                    'likelihood' => $r->IIARCF_HEALTH_Likelihood,
                    'result' => $r->IIARCF_HEALTH_Result,
                    'name_of_person' => $r->IIARCF_HEALTH_NameOfThePerson,
                    'type_of_injury' => $r->IIARCF_HEALTH_TypeOfInjury,
                    'associated_cost_usd' => $r->IIARCF_HEALTH_AssociatedCost,
                    'associated_cost_loca' => $r->IIARCF_HEALTH_localCurrency,
                    'type_of_pollution' => 'N/A',
                    'quantity_of_pollutant' => 'N/A',
                    'contained_spill' => 'N/A',
                    'total_spilled_quantity' => 'N/A',
                    'spilled_in_water' => 'N/A',
                    'spilled_ashore' => 'N/A',
                    'vessel' => 'N/A',
                    'cargo' => 'N/A',
                    'third_party' => 'N/A',
                    'damage_description' => 'N/A',
                    'off_hire' => 'N/A',
                    'description' => 'N/A',
                    'type' => 'N/A',
                    'currency_code' => $r->selected_currency_health
    
                ]);
            }
            // updating ENVIRONMENT .....
            if ($r->Risk_category_IIARCF == 'ENVIRONMENT') {
                DB::table('incident_reports_risk_details')->insert([
                    'id' => $this->Generating_child_ID('incident_reports_risk_details',  $r->id, $r->id . '__IRRD'),
                    'incident_report_id' => $r->id,
    
                    'risk' => $r->IIARCF_ENVIRONMENT_first_dropdown,
                    'severity' => $r->IIARCF_ENVIRONMENT_Severity,
                    'likelihood' => $r->IIARCF_ENVIRONMENT_Likelihood,
                    'result' => $r->IIARCF_ENVIRONMENT_Result,
                    'name_of_person' => $r->IIARCF_ENVIRONMENT_TypeOfPollution,
                    'type_of_injury' => 'N/A',
                    'associated_cost_usd' => $r->IIARCF_ENVIRONMENT_AssociatedCost,
                    'associated_cost_loca' => $r->IIARCF_ENVIRONMENT_localCurrency,

                    'type_of_pollution' => $r->IIARCF_ENVIRONMENT_TypeOfPollution,
                    'quantity_of_pollutant' => $r->IIARCF_ENVIRONMENT_QuantityOfPollutant,

                    'contained_spill' => $r->IIARCF_ENVIRONMENT_ContainedSpill,
                    'total_spilled_quantity' => $r->IIARCF_ENVIRONMENT_TotalSpilledQuantity,
                    'spilled_in_water' => $r->IIARCF_ENVIRONMENT_SpilledInWater,
                    'spilled_ashore' => $r->IIARCF_ENVIRONMENT_SpilledAshore,
                    'vessel' => 'N/A',
                    'cargo' => 'N/A',
                    'third_party' => 'N/A',
                    'damage_description' => 'N/A',
                    'off_hire' => 'N/A',
                    'description' => 'N/A',
                    'type' => 'N/A',
                    'currency_code' => $r->selected_currency_environment
    
                ]);
            }
            // saving OPERATIONAL IMPACT .....
            if ($r->Risk_category_IIARCF == 'OPERATIONAL IMPACT') {
                DB::table('incident_reports_risk_details')->insert([
                    'id' => $this->Generating_child_ID('incident_reports_risk_details',  $r->id, $r->id . '__IRRD'),
                    'incident_report_id' => $r->id,
                    'risk' => $r->IIARCF_OPERATIONAL_IMPACT_first_dropdown,
                    'severity' => $r->IIARCF_OPERATIONAL_IMPACT_Severity,
                    'likelihood' => $r->IIARCF_OPERATIONAL_IMPACT_Likelihood,
                    'result' => $r->IIARCF_OPERATIONAL_IMPACT_Result,
                    'name_of_person' => 'N/A',
                    'type_of_injury' => 'N/A',
                    'associated_cost_usd' => $r->IIARCF_OPERATIONAL_IMPACT_AssociatedCost,
                    'associated_cost_loca' => $r->IIARCF_OPERATIONAL_IMPACT_localCurrency,
                    'type_of_pollution' => 'N/A',
                    'quantity_of_pollutant' => 'N/A',
                    'contained_spill' => 'N/A',
                    'total_spilled_quantity' => 'N/A',
                    'spilled_in_water' =>  'N/A',
                    'spilled_ashore' =>  'N/A',
                    'vessel' => $r->IIARCF_OPERATIONAL_IMPACT_Vessel,
                    'cargo' => $r->IIARCF_OPERATIONAL_IMPACT_Cargo,
                    'third_party' =>  $r->IIARCF_OPERATIONAL_IMPACT_Third_Party,
                    'damage_description' => $r->IIARCF_OPERATIONAL_IMPACT_Damage_description,
                    'off_hire' => $r->IIARCF_OPERATIONAL_IMPACT_Off_hire_if_any,
                    'description' => 'N/A',
                    'type' => 'N/A',
                    'currency_code' => $r->selected_currency_operational_impact
    
                ]);
            }
            // saving MEDIA .....
            if ($r->Risk_category_IIARCF == 'MEDIA') {
                $IIARCF_MEDIA_type_text                       = $r->IIARCF_MEDIA_type_text;
                DB::table('incident_reports_risk_details')->insert([
                    'id' => $this->Generating_child_ID('incident_reports_risk_details',  $r->id, $r->id . '__IRRD'),
                    'incident_report_id' => $r->id,
    
                    'risk' => $r->IIARCF_MEDIA_first_dropdown,
                    'severity' => $r->IIARCF_MEDIA_Severity,
                    'likelihood' => $r->IIARCF_MEDIA_Likelihood,
                    'result' => $r->IIARCF_MEDIA_Result,
                    'name_of_person' => 'N/A',
                    'type_of_injury' => 'N/A',
                    'associated_cost_usd' => $r->IIARCF_MEDIA_AssociatedCost,
                    'associated_cost_loca' => $r->IIARCF_MEDIA_localCurrency,
                    'type_of_pollution' => 'N/A',
                    'quantity_of_pollutant' => 'N/A',
                    'contained_spill' => 'N/A',
                    'total_spilled_quantity' => 'N/A',
                    'spilled_in_water' => 'N/A',
                    'spilled_ashore' => 'N/A',
                    'vessel' => 'N/A',
                    'cargo' => 'N/A',
                    'third_party' => 'N/A',
                    'damage_description' => 'N/A',
                    'off_hire' => 'N/A',
                    'description' => $r->IIARCF_MEDIA_describtion,
                    'type' => $r->IIARCF_MEDIA_type,
                    'currency_code' => $r->selected_currency_media
    
                ]);
            }
            // end
            $immediatecause_first                         = $this->getmain($r->immediatecause_first); //filled
            $immediatecause_second                        = ($this->getsub($r->immediatecause_second)) ? $this->getsub($r->immediatecause_second) : config('constants.DATA_NOT_AVAILABLE'); //filled
            $immediatecause_third                         = ($this->getter($r->immediatecause_third)) ? $this->getter($r->immediatecause_third) : config('constants.DATA_NOT_AVAILABLE'); 

            if ((empty($immediatecause_first) != true &&  $immediatecause_first != "-----") || $immediatecause_first != 0) {
                // deleting previous data, if present
                DB::table('incident_reports_immediate_causes')->where('incident_report_id', $r->id)->delete();
                
                $is_exist_before = count(DB::table('incident_reports_immediate_causes')->where('incident_report_id', $r->id)->get());
                if ($is_exist_before != 0) {
                    DB::table('incident_reports_immediate_causes')->where('incident_report_id', $r->id)->update([
                        'primary' => $immediatecause_first,
                        'secondary' => $immediatecause_second,
                        'tertiary' => $immediatecause_third
                    ]);
                } else {
                    DB::table('incident_reports_immediate_causes')->insert(['id' => $this->Generating_child_ID('incident_reports_immediate_causes',  $r->id, $r->id . '__IRIC'), 'incident_report_id' => $r->id, 'primary' => $immediatecause_first, 'secondary' => $immediatecause_second, 'tertiary' => $immediatecause_third,]);
                }
            }
        }
    }
    // this function will download raPdf
    public function downloadFile($id)
    {
        // dd($id);
        Log::info('hit');
        $path = DB::table('incident_report')->where('id', $id)->pluck('five_why_risk_assesment_evaluated_file_upload');
        // dd($path[0]);
        $fileLocation = env('UPLOAD_PATH') . DIRECTORY_SEPARATOR . $path[0];
        if (file_exists($fileLocation))
            return  response()->download($fileLocation);
        else
            return null;
    }
    
}
