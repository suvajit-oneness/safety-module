<?php

/**
 * Class and Function List:
 * Function list:
 * - index()
 * - savedata()
 * - create()
 * - store()
 * - edit()
 * - update()
 * - destroy()
 * - getmoc()
 * - col()
 * Classes list:
 * - ManagementofchangeController extends Controller
 */

namespace App\Http\Controllers;

use App\Models\managementofchange;
use App\Models\moc_master;
use App\Models\managementvalues;
use App\Models\moc_review;
use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use App\Http\Controllers\FileController;
use App\Http\Controllers\GenericController;


use Auth;
use Log;
use Carbon\Carbon;

class ManagementofchangeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        // $risk_assesment_id = DB::table('risk_assessment_vessel_infos')->select('id')
        //     ->get();
        $risk_assesment_id = DB::table('template_details')->select('id')
            ->get();
        // $risk_assesment_id = DB::table('template_details')->where('creator_id',session('creator_id'))->select('id')
        //     ->get();
        // dd(session('creator_id'));
        // dd($risk_assesment_id);
        return view('management_of_change.managementview', ['risk_assesment_id'                 => $risk_assesment_id]);
    }
    public function savedata($r, $id)
    {
        // dd($r['RA']);
        // dd($r->input()->all());
        //  foreach($r as $tkey => $t){
        //     Log::info('Check :: '.print_r($t,true));
        //     Log::info('Check key :: '.print_r($tkey,true));
        // }
        // dd($r);
        // common values
        $Vessel_ofc_dept = $r['vessel_ofc_dept'];
        $Date_management = $r['date_management'];
        $Name_rank_pos   = $r['name_rank_pos'];
        $Toc_req         = $r['toc_req'];
        $Control_no      = $r['control_no'];
        $name_requester  = $r['name_requester'];

        $filepath        = '';
        // Log::console.log("message".print_r($r->all()));


        // if id is present, things are being edited
        if ($id) {
            $moc_change_checklist_id = DB::table('moc_change_checklist')->where('moc_id', $id)->distinct()
                ->pluck('change_checklist_id');
            // dd($moc_change_checklist_id);
            foreach ($moc_change_checklist_id as $i) {
                DB::table('moc_change_checklist')->where('change_checklist_id', $i)->update(['value'                               => $r]);
            }

            // $change_checklist_id = DB::table('change_checklist')->where('id',$moc_change_checklist_id[0])->get();
            // dd($change_checklist_id);
            // managementvalues::where('moc_id',$id)->delete();
            // moc_master::where('id',$id)->delete();
            $moc_master                    = moc_master::find($id);
            $moc_master->status            = "review 1 pending";

            // Log::critical("form is being edited");

        }

        // else,  new data is being saved
        // Log::critical("form is being created");
        // custom id generator code
        // $Vessel_detailsController      = new Vessel_detailsController;
        // $ship                          = $Vessel_detailsController->getVesselId();
        $ship     = (new GenericController)->getCreatorId();
        if ($ship !== false) {
            $shipPrefix                    = $ship->prefix;
            $creator                       = $ship->id;
        } else {
            $shipPrefix                    = '';
            $creator                       = '';
        }

        // $RiskAss = DB::table('moc_master')->where('creator_id', session('creator_id'))
        //     ->orderBy('id', 'DESC')
        //     ->first();
        // if ($RiskAss !== null)
        // {
        //     $lastID                        = explode("-", $RiskAss->id);
        //     $prevInc                       = (int)$lastID[2];
        //     $inc                           = $prevInc + 1;
        // }
        // else
        // {
        //     $inc                           = 1;
        // }
        // $id                            = $shipPrefix . '-management_of_change-' . (string)$inc;
        // custom id generator code End.
        // master table data

        $id = (new GenericController)->getUniqueId('moc_master', config('constants.UNIQUE_ID_TEXT.MOC'));
        if (isset($r['sign_requester'])) {

            $uploadUrlSegment = $id . DIRECTORY_SEPARATOR . 'sign_requester';
            $filepath = (new FileController)->saveFile($uploadUrlSegment, config('constants.MODULES.MOC'), $r['sign_requester']);
            // $file            = $r['sign_requester'];
            // $extension       = $file->getClientOriginalExtension();
            // // dd($extension);
            // $filename        = 'image_' . time() . '.' . $extension;
            // Log::info('Id = ' . print_r($id, true));
            // $fileDir        = env('UPLOAD_PATH') . DIRECTORY_SEPARATOR . config('constants.UPLOAD_FOLDER.MOC') . DIRECTORY_SEPARATOR . $id . DIRECTORY_SEPARATOR;
            // if (!file_exists($fileDir)) {
            //     mkdir($fileDir, 0777, true);
            // }
            // $filepath = $fileDir . $filename;
            // $file->move($fileDir, $filename);
        }
        $RA_path = "";
        if (isset($r['RA_pdf']) && $r['RA_pdf']) {
            $uploadUrlSegment = $id . DIRECTORY_SEPARATOR . 'RA_pdf';
            $RA_path = (new FileController)->saveFile($uploadUrlSegment, config('constants.MODULES.MOC'), $r['RA_pdf']);
        }
        $moc_master                    = new moc_master;
        $moc_master->id                = $id;
        $moc_master->creator_id        = session('creator_id');
        $moc_master->status            = "review 1 pending";

        // common values
        $moc_master->vessel_name       = $Vessel_ofc_dept;
        $moc_master->date              = $Date_management;
        $moc_master->name_rank         = $Name_rank_pos;
        $moc_master->type_of_change    = $Toc_req;
        $moc_master->control_number    = $Control_no;
        $moc_master->name_of_requester = $name_requester;
        $moc_master->sign_of_requester = $filepath;
        $moc_master->creator_email = session('email');
        $moc_master->ra_path = $RA_path;
        $moc_master->save();

        //  2nd Step
        foreach ($r as $key                             => $value) {
            // Log::info("key outif :: ".print_r($key,true));
            // Log::info("value outif :: ".print_r($value,true));
            if (str_contains($key, 'checklist_')) {
                // if($value){
                //Log::info("key inif :: ".print_r($key,true));
                // Log::info("value inif :: ".print_r($value,true));
                $change_checklist_id             = mb_substr($key, 10);
                // Log::info("value changechecklist id :: ".print_r($change_checklist_id,true));
                $moc_values                      = new managementvalues;
                $moc_values->moc_id              = $id;
                $moc_values->value               = $value;
                $moc_values->change_checklist_id = $change_checklist_id;

                $moc_values->save();
                // }

            }
        }

        return 1;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $changeReqData = DB::table('change_checklist')->where('type', 'Change Requested')
            ->get();
        $checkReqData  = managementofchange::where('type', 'Check List')->whereNull('parent_id')
            ->with(['children'])
            ->get();
        // dd($checkReqData);
        // DB::table('change_checklist')
        // dd($checkReqData[3]->children[0]->name);
        // dd(count($checkReqData[8]->children));
        // $child_count = count($checkReqData[8]->children);
        // $changeString = $changeReqData->implode('name', ', ');
        // dd($changeString);
        $riskAssesment_id = DB::table('risk_assesment')->where('creator_id', session('creator_id'))->select('riskAssesment_id')
            ->get();
        // dd($risk_assesment_id);
        return view('management_of_change.managementcreate', ['changeReqData' => $changeReqData, 'checklist' => $checkReqData, 'riskAssesment' => $riskAssesment_id]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $r)
    {
        self::savedata($r->all(), null);

        return redirect(url('/moc'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\managementofchange  $managementofchange
     * @return \Illuminate\Http\Response
     */

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\managementofchange  $managementofchange
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // master table
        $master_moc           = DB::table('moc_master')->where('id', $id)->first();
        // dd($master_moc);
        $moc_review_fleet     = DB::table('moc_review')->where('moc_id', $id)->where('reviewer_type', 'fleet manager')
            ->first();
        // dd($moc_review_fleet);

        $moc_review_gm        = DB::table('moc_review')->where('moc_id', $id)->where('reviewer_type', 'General Manager')
            ->first();
        // dd($moc_review_gm);
        // for change requested
        $qna_change           = managementofchange::leftJoin('moc_change_checklist', 'change_checklist.id', '=', 'moc_change_checklist.change_checklist_id')->where('type', '=', 'Change Requested')
            ->where('moc_id', $id)
            ->select('change_checklist.*','moc_change_checklist.id as mid','moc_change_checklist.moc_id as moc_id','moc_change_checklist.value as value')
            ->get();

        // dd($qna_change);
        // checklist
        $qna_check            = managementofchange::leftJoin('moc_change_checklist', 'change_checklist.id', '=', 'moc_change_checklist.change_checklist_id')->where('type', '=', 'Check List')
            ->where('moc_id', $id)->get();

        // dd($qna_change->children);
        // dd($qna_check);
        // evaluation checklist
        $moc_id               = managementofchange::leftJoin('moc_change_checklist', 'change_checklist.id', '=', 'moc_change_checklist.change_checklist_id')->where('type', '=', 'Evaluation Checklist')
            ->where('moc_id', $id)->select('moc_id')
            ->first();
        //  dd($moc_id);
        if ($id == isset($moc_id->moc_id)) {
            # code...
            $qna_evaluation_check = managementofchange::leftJoin('moc_change_checklist', 'change_checklist.id', '=', 'moc_change_checklist.change_checklist_id')->where('type', '=', 'Evaluation Checklist')
                ->where('moc_id', $id)->get();
            // dd($qna_evaluation_check);

        } else {
            # code...
            $qna_evaluation_check = managementofchange::where('type', 'Evaluation Checklist')->whereNull('parent_id')
                ->with(['children'])
                ->get();
        }
        $signedPhoto = [];

        if ($master_moc && $master_moc->sign_of_requester) {
            $signedPhoto['sign_of_requester'] = (new FileController)->getImageBase64($master_moc->sign_of_requester);
        }
        if ($moc_review_fleet && $moc_review_fleet->document_1) {
            // dd($moc_review_fleet->document_1);
            $signedPhoto['document_1'] = (new FileController)->getImageBase64($moc_review_fleet->document_1);
            // dd($signedPhoto);
        }
        if ($moc_review_gm && $moc_review_gm->document_2) {
            $signedPhoto['document_2'] = (new FileController)->getImageBase64($moc_review_gm->document_2);
        }
        // dd($signedPhoto);
        // dd($moc_review_gm);
        // dd($signedPhoto['document_2']);
        // dd($moc_review_fleet);
        //    dd($qna_evaluation_check);
        return view('management_of_change.managementedit', [
            'master_moc'              => $master_moc, 'changeReqData'              => $qna_change, 'checklist'              => $qna_check, 'qna_evaluation_check'              => $qna_evaluation_check, 'id'              => $id, 'moc_review'              => $moc_review_fleet, 'moc_review_gm'              => $moc_review_gm, 'Image' => $signedPhoto

        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\managementofchange  $managementofchange
     * @return \Illuminate\Http\Response
     */
    public function update(Request $r, $id)
    {
        $ansid        = array();
        $anschecklist = array();
        foreach ($r->all() as $tkey         => $t ) {
            if (substr($tkey, 0, 10) == 'checklist_' && $tkey != 'checklist_reason') {
                Log::info('Check list : '.print_r($tkey,true));
                $anschecklist[]              = $tkey;
                $idd          = explode('_', $tkey);
                $ansid[]              = $idd[1];
            }
        }

        for ($x            = 0; $x < sizeof($ansid); $x++) {
            Log::info('ID : '.print_r($ansid[$x],true));
            Log::info('Value : '.print_r($r->input($anschecklist[$x]),true));

            DB::table('moc_change_checklist')->where('id', $ansid[$x])->update(['value'                   => $r->input($anschecklist[$x])]);
        }
        // dd($r->all());
        $moc_master        = moc_master::find($id);
        // self::savedata($r->all(), $id);
        // step 1
        // $moc_values = managementvalues::where('moc_id',$id)->get();
        //    Log::critical("message".print_r($id,true));
        //     // dd($moc_values);
        $Vessel_ofc_dept   = $r->vessel_ofc_dept;
        //    Log::critical("message".print_r( $Vessel_ofc_dept,true));
        $Date_management   = $r->date_management;
        $Name_rank_pos     = $r->name_rank_pos;
        $Toc_req           = $r->toc_req;
        $Control_no        = $r->control_no;
        $name_of_requester = $r->name_requester;

        $filepath          = '';

        if ($r->hasFile('sign_requester')) {

            $path              = $moc_master->sign_of_requester;
            // dd($path);
            if (File::exists($path)) {
                File::delete($path);
            }
            $file      = $r->file('sign_requester');
            $extension = $file->getClientOriginalExtension();
            $filename  = time() . '.' . $extension;
            $fileDir  = env('UPLOAD_PATH') . DIRECTORY_SEPARATOR . config('constants.UPLOAD_FOLDER.MOC') . DIRECTORY_SEPARATOR . $id . DIRECTORY_SEPARATOR;
            if (!file_exists($fileDir)) {
                mkdir($fileDir, 0777, true);
            }
            $filepath = $fileDir . $filename;
            $file->move($fileDir, $filename);
            // dd($filepath);
            $moc_master->sign_of_requester = $filepath;
        }

        $moc_master->vessel_name       = $Vessel_ofc_dept;
        // $moc_master->id                                    = $id;
        $moc_master->date              = $Date_management;
        $moc_master->name_rank         = $Name_rank_pos;
        $moc_master->type_of_change    = $Toc_req;
        $moc_master->control_number    = $Control_no;
        $moc_master->name_of_requester = $name_of_requester;
        $moc_master->status            = "review 2 pending";

        $moc_master->update();

        // EVALUATION
        $moc_id  = managementofchange::leftJoin('moc_change_checklist', 'change_checklist.id', '=', 'moc_change_checklist.change_checklist_id')->where('type', '=', 'Evaluation Checklist')
            ->where('moc_id', $id)->select('moc_id')
            ->first();
        // dd($moc_id->moc_id);
        $creator = (new GenericController)->getCreatorId();

        // updating part
        if ($id == isset($moc_id->moc_id)) {
            Log::critical("If " . print_r($r->all(), true));
            // $moc_review = moc_review::find($id);
            // dd($moc_id->moc_id);
            $comp_team_member = $r->comp_team_member;
            // dd($comp_team_member);
            $remarks_moc      = $r->remarks_moc;
            $date_fleet_dgm   = $r->date_fleet_dgm;
            $filepath         = '';
            if ($r['review_fleet_manager']) {

                $uploadUrlSegment = $id . DIRECTORY_SEPARATOR . 'review_fleet_manager';
                $filepath = (new FileController)->saveFile($uploadUrlSegment, config('constants.MODULES.MOC'), $r['review_fleet_manager']);

                // $path             = moc_review::where('moc_id', $id)->select('document_1')
                //     ->get();

                // if (File::exists($path))
                // {
                //     File::delete($path);
                // }

                // $file      = $r['review_fleet_manager'];
                // $extension = $file->getClientOriginalExtension();
                // // dd($extension);
                // $filename  = 'image_' . time() . '.' . $extension;
                // $fileDir  = env('UPLOAD_PATH') . DIRECTORY_SEPARATOR . config('constants.UPLOAD_FOLDER.MOC') . DIRECTORY_SEPARATOR . $id . DIRECTORY_SEPARATOR;
                // if (!file_exists($fileDir)) {
                //     mkdir($fileDir, 0777, true);
                // }
                // // dd($filepath);
                // $filepath = $fileDir . $filename;
                // $file->move($fileDir, $filename);
            }

            // gma
            if ($r->checklist_reason) {
                # code...
                $name_gm     = $r->gma_name;
                // dd($name_gm);
                $obs1        = $r->gma_req_apr_ts;
                $obs2        = $r->gma_req_apr_tqi;
                $obs3        = $r->gma_req_apr_gm;
                $date        = $r->appr_and_sign_date;
                $verdict     = $r->checklist_reason;
                if ($r->gma_req_deff_reason) {
                    # code...
                    $comments    = $r->gma_req_deff_reason;
                } else {
                    # code...
                    $comments    = $r->gma_req_den_reason;
                }
                // dd($verdict);
                $filepath_gm = '';
                if ($r['appr_and_sign_gm']) {
                    $path        = moc_review::where('moc_id', $id)->select('document_2')
                        ->where('reviewer_type', '=', 'fleet manager')
                        ->get();

                    if (File::exists($path)) {
                        File::delete($path);
                    }

                    // $file        = $r['appr_and_sign_gm'];
                    // $extension   = $file->getClientOriginalExtension();
                    // // dd($extension);
                    // $filename    = 'image_' . time() . '.' . $extension;
                    // $fileDir = env('UPLOAD_PATH') . DIRECTORY_SEPARATOR . config('constants.UPLOAD_FOLDER.MOC') . DIRECTORY_SEPARATOR . $id . DIRECTORY_SEPARATOR;
                    // // dd($filepath);
                    // if (!file_exists($fileDir)) {
                    //     mkdir($fileDir, 0777, true);
                    // }
                    // $filepath_gm = $fileDir . $filename;
                    // $file->move($fileDir, $filename);
                    $uploadUrlSegment = $id . DIRECTORY_SEPARATOR . 'appr_and_sign_gm';
                    $filepath_gm = (new FileController)->saveFile($uploadUrlSegment, config('constants.MODULES.MOC'), $r['appr_and_sign_gm']);
                }
                //    dd($name_gm);
                $datat = array(
                    'moc_id' => $id,
                    'creator_id' => session('creator_id'),
                    'name' => $name_gm,
                    'obs_1' => $obs1,
                    'obs_2' => $obs2,
                    'obs_3' => $obs3,
                    'date' => $date,
                    'document_2' => $filepath_gm,
                    'status' => $verdict,
                    'comments' => $comments,
                    'remarks' => '',
                    'reviewer_type' => 'General Manager'
                );
                DB::table('moc_review')->insert($datat);
                $moc_master = moc_master::find($id);
                $moc_master->status = $verdict;
                $moc_master->save();
            }

            // moc_review::where('moc_id', '=', $id)->where('reviewer_type', '=', 'fleet manager')
            //     ->update(['name' => $comp_team_member, 'remarks' => $remarks_moc, 'date' => $date_fleet_dgm, 'document_1' => $filepath, ]);

            // Log::info("verdict:".print_r($verdict,true));
            moc_review::where('moc_id', '=', $id)->where('reviewer_type', '=', 'General Manager')
                ->update(['name'                 => $name_gm, 'obs_1'                 => $obs1, 'obs_2'                 => $obs2, 'obs_3'                 => $obs3, 'date'                 => $date, 'document_2'                 => $filepath_gm, 'status'                 => $verdict, 'comments'                 => $comments, 'remarks'                 => '',]);

            $ansid_ev        = array();
            $anschecklist_ev = array();
            foreach ($r->all() as $tkey => $t) {

                // Log::console . log(" message inside foreach");
                if (substr($tkey, 0, 12) == 'checklistev_') {
                    // Log::console . log(" message inside foreach and if");
                    $anschecklist_ev[]     = $tkey;
                    $idd = explode('_', $tkey);
                    $ansid_ev[]     = $idd[1];
                }
            }

            for ($x   = 0; $x < sizeof($ansid_ev); $x++) {

                DB::table('moc_change_checklist')->where('id', $ansid_ev[$x])->update(['value'                  => $r->input($anschecklist_ev[$x])]);
            }
        }

        // saving part
        else {

            $moc_review       = new moc_review;

            $comp_team_member = $r->comp_team_member;
            $remarks_moc      = $r->remarks_moc;
            $date_fleet_dgm   = $r->date_fleet_dgm;
            $filepath         = '';
            if ($r['review_fleet_manager']) {
                $uploadUrlSegment = $id . DIRECTORY_SEPARATOR . 'review_fleet_manager';
                $filepath = (new FileController)->saveFile($uploadUrlSegment, config('constants.MODULES.MOC'), $r['review_fleet_manager']);

                // $file             = $r['review_fleet_manager'];
                // $extension        = $file->getClientOriginalExtension();
                // // dd($extension);
                // $filename         = 'image_' . time() . '.' . $extension;
                // $fileDir         = env('UPLOAD_PATH') . DIRECTORY_SEPARATOR . config('constants.UPLOAD_FOLDER.MOC') . DIRECTORY_SEPARATOR . $id . DIRECTORY_SEPARATOR;
                // // dd($filepath);
                // if (!file_exists($fileDir)) {
                //     mkdir($fileDir, 0777, true);
                // }
                // $filepath = $fileDir . $filename;
                // $file->move($fileDir, $filename);
            }
            // gma approval
            // GENERAL manager
            $name                      = $r->gma_req_apr_gm;
            // dd($name);
            $comments                  = $r->gma_req_den_reason;
            // dd($comments);
            // $comments = $r->gma_req_deff_reasonn;
            // $comments = 'abs';
            // dd($comments);
            $verdict                   = $r['checklist_reason'];
            // dd($verdict);


            // $moc_review->name = $name;


            $moc_review->moc_id        = $id;
            $moc_review->creator_id    = session('creator_id');
            $moc_review->name          = $comp_team_member;
            $moc_review->remarks       = $remarks_moc;
            $moc_review->date          = $date_fleet_dgm;
            $moc_review->document_1    = $filepath;
            $moc_review->reviewer_type = 'fleet manager';
            // gm evaluation
            // $moc_review->name = $name ;
            // $moc_review->obs_1 = $obs1 ;
            // $moc_review->obs_2 = $obs2 ;
            // $moc_review->obs_3 = $obs3 ;
            // $moc_review->date = $date ;
            // $moc_review->document_2 = $filepath_gm ;
            // $moc_review->comments = $comments ;
            // $moc_review->status = $verdict ;
            $moc_review->save();
            // $gm_moc_master = moc_master::find($id);
            // $gm_moc_master->status
            foreach ($r->all() as $key => $value) {
                Log::info("Testing1 :: " . print_r($key, true));
                Log::info("value outif ev :: " . print_r($value, true));
                if (str_contains($key, 'checklistev_')) {
                    // if($value){
                    Log::info("key inif  ev :: " . print_r($key, true));
                    Log::info("value inif ev  :: " . print_r($value, true));
                    $change_checklist_id             = mb_substr($key, 12);
                    // Log::info("value changechecklist id :: ".print_r($change_checklist_id,true));
                    $moc_values                      = new managementvalues;
                    $moc_values->moc_id              = $id;
                    $moc_values->value               = $value;
                    $moc_values->change_checklist_id = $change_checklist_id;

                    $moc_values->save();
                    // }

                }
            }
        }

        return redirect(url('/moc'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\managementofchange  $managementofchange
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $current_time = Carbon::now()->toDateTimeString();
        DB::table('moc_change_checklist')->where('moc_id', $id)->update(['deleted_at' => $current_time]);

        DB::table('moc_master')
            ->where('id', $id)->update(['deleted_at' => $current_time]);

        DB::table('moc_review')
            ->where('moc_id', $id)->update(['deleted_at' => $current_time]);

        return redirect(url('/moc'));
    }
    public function getmoc(Request $req)
    {

        // Log::info('hey');
        // $is_ship = $this->is_ship();

        if (empty($req->srch) == 1) {
            $joinedtables = DB::table('moc_master');

            if ($req->is_ship) {
                Log::info('I am in is_ship');
                $joinedtables->where('creator_id', $req->creator_id);
            }
            // $joinedtables = $joinedtables->orderBy('auto_inc')->get();
            $joinedtables = $joinedtables->orderBy('updated_at','DESC')->get();
            $moc_data     = DB::table('moc_master')
                // ->where('creator_id','mrysh__1')
                ->leftjoin('moc_change_checklist', 'moc_master.id', '=', 'moc_change_checklist.moc_id')
                ->leftjoin('change_checklist', 'moc_change_checklist.change_checklist_id', '=', 'change_checklist.id')
                ->where('type', 'Change Requested')
                ->select('moc_master.*', 'moc_master.id as id', 'moc_change_checklist.value as value', 'change_checklist.name as name')
                ->get();
            Log::info("All :" . print_r($joinedtables, true));
        } else {
            $search           = $req->srch;
            Log::info('ss ' . print_r($search, true));

            $joinedtables = DB::table('moc_master')->Where('id', 'LIKE', "%" . $search . "%")->orWhere('status', 'LIKE', "%" . $search . "%")->orWhere('date', 'LIKE', "%" . $search . "%")->orWhere('vessel_name', 'LIKE', "%" . $search . "%")->orWhere('name_rank', 'LIKE', "%" . $search . "%")->orWhere('type_of_change', 'LIKE', "%" . $search . "%")->orWhere('control_number', 'LIKE', "%" . $search . "%");


            if ($req->is_ship) {
                Log::info('I am in is_ship search');
                $joinedtables->orwhere('creator_id', $req->creator_id);
            }
            // Log::info('query is: ' . print_r($moc_data,true));
            // $joinedtables     = $joinedtables->orderBy('auto_inc')->get();
            $joinedtables     = $joinedtables->orderBy('updated_at','DESC')->get();

            Log::info('data is: ' . print_r($joinedtables, true));

            $totalFiltered = $joinedtables->count();
        }
        // search end
        $totalData = $joinedtables->count();
        $totalFiltered = $totalData;
        $data         = array();
        if (!empty($joinedtables)) {
            foreach ($joinedtables as $key          => $post) {
                // log::info('Test '.print_r($post,true));
                // Log::info('joined tables-> change only :'.print_r($joinedtables,true));
                if (!empty($post->deleted_at)) {
                    continue;
                }
                $action       = "   <div>
                                        <!-- Edit Button
                                        =========================-->
                                        <a href='/moc/edit/" . $post->id . "' class='btn edit btn-info my-3'>
                                            <i class='fas fa-edit'></i>
                                        </a>


                                        <!-- Delete Button
                                        =========================-->
                                        <a href='/moc/delete/" . $post->id . "' class='btn delete btn-info my-3'>
                                        <i class='fas fa-trash-alt'></i>
                                         </a>
                                    </div>";


                if ($post->status == 'accepted') {
                    $test['status']              = "<div class='shadow btn btn-success style='padding-right: 34px !important; writing-mode:vertical-lr;text-orientation:upright; width:33px;height:300px;padding:10px;'>Accepted</div>";
                } elseif ($post->status == 'denied') {
                    $test['status']              = "<div class='shadow btn btn-danger style='padding-right: 34px !important; writing-mode:vertical-lr;text-orientation:upright; width:33px;height:300px;padding:10px;'>Denied</div>";
                } elseif ($post->status == 'deffered') {
                    $test['status']              = "<div class='shadow btn btn-warning style='padding-right: 34px !important; writing-mode:vertical-lr;text-orientation:upright; width:33px;height:300px;padding:10px;'>Deferred</div>";
                } elseif ($post->status == 'review 1 pending') {
                    $test['status']              = "<div class='shadow btn btn-primary style='padding-right: 34px !important; writing-mode:vertical-lr;text-orientation:upright; width:33px;height:300px;padding:10px;'>Review 1 pending</div>";
                } elseif ($post->status == 'review 2 pending') {
                    $test['status']              = "<div class='shadow btn btn-primary style='padding-right: 34px !important; writing-mode:vertical-lr;text-orientation:upright; width:33px;height:300px;padding:10px;'>Review 2 pending</div>";
                }

                $test['id']              = $post->id;
                $test['date']              = $post->date;
                $test['Vessel Name']              = $post->vessel_name;
                $test['Name & Rank/Position']              = $post->name_rank;
                $test['Type of change Requested']              = $post->type_of_change;
                $test['Control Number']              = $post->control_number;
                $test['action']              = $action;

                $data[]              = $test;
            }
        }

        $json_data    = array(
            "recordsTotal" => intval($totalData) ,
            "recordsFiltered" => intval($totalData),
            "data" => $data
        );

        echo json_encode($json_data);
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
    public function downloadFile($id)
    {
        // dd($id);
        Log::info('hit');
        $path = DB::table('moc_master')->where('id', $id)->pluck('ra_path');
        // dd($path[0]);
        if($path[0]){
            $fileLocation = env('UPLOAD_PATH') . DIRECTORY_SEPARATOR . $path[0];
            if (file_exists($fileLocation))
                return  response()->download($fileLocation);
            else
                return null;
        }
        else{
            return 'File not uploaded';
        }
    }
}
