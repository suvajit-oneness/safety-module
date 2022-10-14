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
* - getRiskAssesmentId()
* - test()
* - getDropVal()
* Classes list:
* - RiskAssesmentController extends Controller
*/
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\department;
use App\Models\vessel;
use App\Models\Template;
use App\Models\template_hazard;
use App\Models\reviewRanks;
use App\Models\template_details;
use App\Models\hazard_list;
use App\Models\hazard_master_list;
use App\Models\risk_matrix;
use App\Models\risk_assesment;
use App\Models\risk_assesment_details;
use App\Models\risk_assesment_hazard;
use App\Models\TemplateDepartment;
use App\Models\Signature;
use App\Models\User;

use App\Http\Controllers\Vessel_detailsController;
use App\Http\Controllers\GenericController;
use App\Http\Controllers\JsonController;
use Log;
use Auth;
use Session;
use DB;
use PDF;

class RiskAssesmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        //
        // dd('Hey');
        // $unique_array = DB::table('drop')->first();
        // if(!empty($unique_array)){
        //     $my_array = explode(',',$unique_array->array);
        //     // dd($my_array,$unique_array->array);
        // }
        $user = User::find(session('id'));
        if($user->hasPermissionTo('view.riskassessment')){
            $templates = DB::table('templates');
            if (session('is_ship')) {
                $templates = $templates->where('creator_id', session('creator_id'));
            }  
            $templates = $templates->orderBy('updated_at','DESC')->get();
            return view('riskAssesment', ['templates' => $templates]);
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
    public function create($id)
    {
        //
        // dd('Create',$id);
        $user = User::find(session('id'));
        if($user->hasPermissionTo('create.riskassessment')){
            $department       = department::all();
            $vessel           = vessel::all();
            $formJson         = DB::table('templates')->where('template_id', $id)->pluck('form_json')
                ->first();

            $riskMatriceColor = risk_matrix::pluck('hex_code', 'code');
            $riskFactor       = risk_matrix::pluck('risk_factor', 'code');
            $filledHazards    = hazard_list::select('hazard_lists.id', 'hazard_lists.code', 'hazard_lists.name')->get();
            $template         = DB::table('templates')->where('templates.template_id', $id);
            $template         = $template->leftJoin('template_details', 'template_details.template_id', '=', 'templates.template_id')
                ->select('template_details.*', 'templates.id as idd', 'templates.name as name as name', 'templates.form_json as form_json', 'templates.key as key')
                ->get();
            // dd($template);
            // $vessel_name      = vessel::find($template[0]->vessel_id);
            $dept_name        = department::find($template[0]->dept_id);
            $templateData     = Template::leftJoin('template_hazard', 'template_hazard.template_id', 'templates.template_id')->leftJoin('template_departments', 'template_departments.code', 'templates.template_code')
                ->leftJoin('hazard_lists', 'hazard_lists.id', 'template_hazard.hazard_list_id')
                ->leftJoin('hazard_master_lists', 'hazard_master_lists.id', 'template_hazard.hazards')
                ->select('templates.name as template_name', 'templates.ref as template_ref', 'templates.template_code as template_code', 'templates.form_json as json', 'template_departments.name as template_department_name', 'template_hazard.vessel_info_id as vessel_info_id', 'template_hazard.hazard_list_id', 'template_hazard.hazards', 'template_hazard.consequences', 'template_hazard.remarks', 'template_hazard.hazardEvent', 'template_hazard.source', 'template_hazard.lkh1', 'template_hazard.svr1', 'template_hazard.rf1', 'template_hazard.control_measure', 'template_hazard.lkh2', 'template_hazard.svr2', 'template_hazard.rf2', 'template_hazard.add_control', 'template_hazard.acFlag', 'template_hazard.additional_control', 'template_hazard.additional_control_type',

            'hazard_master_lists.id as hazard_category_id', 'hazard_master_lists.hazard_no as hazard_master_list_name', 'hazard_lists.id as hazard_list_id', 'hazard_lists.code as hazard_lists_code', 'hazard_lists.name as hazard_lists_name')
                ->where('templates.template_id', 'like', $id)->get();
            // dd($templateData[0]);
            return view('riskAssesmentUse', ['template'                                => $template, 'department'                                => $department, 'vessels'                                => $vessel,  'dept_name'                                => $dept_name, 'formJson'                                => $formJson, 'riskMatriceColor'                                => $riskMatriceColor, 'riskFactor'                                => $riskFactor, 'filledHazards'                                => $filledHazards, 'templateData'                                => $templateData]);
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
        //
        // dd(json_encode($request->form_temp),'I am in store');
        // dd($request->key);
        // dd($request->last_assessment);
        Log::info('All request '.print_r($request->all(),true));
        $tempB18                        = null;
        $section_1_id                   = $request->input('section_1_id');
        $section_2_id                   = $request->input('section_2_id');
        $is_template                    = $request->input('is_template');
        $template_name                  = $request->input('template_name');

        $section_2_array                = json_decode($request->section_2_array);
        $additional_control             = json_decode($request->additional_control);
        $template_name                  = $request->input('template_name');

        //dd('Admin');
        if (!$template_name)
        {
            // dd('No template name');
            $prevTemplateName               = Template::select('id')->orderBy('id', 'desc')
                ->first();
            if ($prevTemplateName)
            {
                $template_name                  = 'Template_' . (($prevTemplateName->id) + 1);
            }
            else
            {
                $template_name                  = 'Template_1';
            }
        }
        // dd('Yes Template name');
        $temp_id                        = $this->getRiskAssesmentId();
        // dd($temp_id);
        $tempTemplate                   = new risk_assesment;
        $tempTemplate->name             = $template_name;
        $tempTemplate->template_code    = $request->template_dept;
        $tempTemplate->ref              = $request->template_dept_id;
        $tempTemplate->riskAssesment_id = $temp_id;
        $tempTemplate->form_json        = $request->form_temp;
        $tempTemplate->key              = $request->key;
        Log::info('Json ' . print_r($request->form_temp));
        $tempTemplate->creator_id = session('creator_id');
        $tempTemplate->creator_email = session('email');
        $tempTemplate->save();
        // dd('Done');
        $result                   = new risk_assesment_details();

        $ship                     = (new GenericController)->getCreatorId();
        if ($ship !== false)
        {
            $shipPrefix               = $ship->prefix;
            $creator                  = $ship->id;
        }
        else
        {
            $shipPrefix               = '';
            $creator                  = '';
        }

        
        $id = (new GenericController)->getUniqueId('risk_assesment_details',config('constants.UNIQUE_ID_TEXT.RISK_ASSESSMENT'));
        $result->id               = $id;
        $forb18                   = $id;
        
        $result->dept_id          = $request->input('dept-id');
        // $result->created_by = Auth::user()->id;
        // $result->created_by = 'mrysh_1';
        $result->creator_id       = session('creator_id');
        // $result->creator_id = 'mrysh__1';
        $result->status           = config('constants.status.Not_approved');

        $result->riskAssesment_id = $temp_id;

        // $result->vessel_name = $request->input('vessel_name');
        // $result->vessel_id        = $request->input('vessel_id');
        // if ($request->input('review-date')) $result->review_date = date('Y-m-d', strtotime($request->input('review-date')));
        // $result->weather = $request->input('weather');
        // $result->voyage = $request->input('voyage');
        // $result->location = $request->input('location');
        // $result->tide = $request->input('tide');
        // $result->work_activity = $request->input('work_activity');
        // $result->work_area = $request->input('work_area');
        // $result->visibility = $request->input('visibility');
        if ($request->input('jha_date')) $result->jha_date = date('Y-m-d', strtotime($request->input('jha_date')));
        $result->last_assessment = $request->last_assessment;

        
        // $result->master_name = $request->input('master_name');
        // if ($request->input('master_date')) $result->master_date = date('Y-m-d', strtotime($request->input('master_date')));
        // $result->ch_off_name = $request->input('ch_off_name');
        // if ($request->input('ch_off_date')) $result->ch_off_date = date('Y-m-d', strtotime($request->input('ch_off_date')));
        // $result->ch_eng_name = $request->input('ch_eng_name');

        // if ($request->input('ch_eng_date')) $result->ch_eng_date = date('Y-m-d', strtotime($request->input('ch_eng_date')));

        // $result->eng2_name = $request->input('eng2_name');

        // if ($request->input('eng2_date')) $result->eng2_date = date('Y-m-d', strtotime($request->input('eng2_date')));

        // $result->sm_name = $request->input('sm_name');

        // if ($request->input('sm_date')) $result->sm_date = date('Y-m-d', strtotime($request->input('sm_date')));

        // $result->dgm_activity_type = $request->input('dgm_activity_type');

        // $result->dgm_name = $request->input('dgm_name');

        // if ($request->input('dgm_date')) $result->dgm_date = date('Y-m-d', strtotime($request->input('dgm_date')));

        // $result->name_rank = $request->input('name_rank');

        // $result->gm_activity_type = $request->input('gm_activity_type');

        // $result->gm_name = $request->input('gm_name');

        // if ($request->input('gm_date')) $result->gm_date = date('Y-m-d', strtotime($request->input('gm_date')));

        // $result->alternate_method = $request->alternate_method;

        // $result->hazard_discussed = $request->hazard_discussed;

        // if ($request->input('jha_start')) $result->jha_start = date('Y-m-d', strtotime($request->input('jha_start')));

        // if ($request->input('jha_end')) $result->jha_end = date('Y-m-d', strtotime($request->input('jha_end')));

        // $result->unassessed_hazards = $request->unassessed_hazards;

        // $result->comments = $request->comments;

        // $result->port_authorities = $request->port_authorities;

        // $result->tools_available = $request->tools_available;

        // $result->lcd_notified = $request->lcd_notified;

        // $result->remarks = $request->remarks;

        $result->save();

        
        // if ($request->master_sign) {
        //     self::image_uploader($request->master_sign, config('constants.signatureFolders.MASTER'), $temp_id);
        // }
        // if ($request->ch_off_sign) {
        //     self::image_uploader($request->ch_off_sign, config('constants.signatureFolders.CHIEF_ENG'), $temp_id);
        // }
        // if ($request->ch_eng_sign) {
        //     self::image_uploader($request->ch_eng_sign, config('constants.signatureFolders.CHIEF_OFF'), $temp_id);
        // }
        // if ($request->eng2_sign) {
        //     self::image_uploader($request->eng2_sign, config('constants.signatureFolders.SECOND_ENGG'), $temp_id);
        // }
        // if ($request->sm_sign) {
        //     self::image_uploader($request->sm_sign, config('constants.signatureFolders.SM'), $temp_id);
        // }
        // if ($request->dgm_sign) {
        //     self::image_uploader($request->dgm_sign, config('constants.signatureFolders.DGM'), $temp_id);
        // }
        // if ($request->gm_sign) {
        //     self::image_uploader($request->gm_sign, config('constants.signatureFolders.GM'), $temp_id);
        // }

        Log::info('Section 2 id :' . print_r($result->id, true));
        if ($section_2_array)
        {
            foreach ($section_2_array as $section_2_value)
            {
                $tempB18                   = new risk_assesment_hazard;
                // $ship = $Vessel_detailsController->getVesselId();
                $ship                      = (new GenericController)->getCreatorId();
                if ($ship !== false)
                {
                    $shipPrefix                = $ship->prefix;
                    $creator                   = $ship->id;
                }
                else
                {
                    $shipPrefix                = '';
                    $creator                   = '';
                }
                $RiskAss                   = DB::table('risk_assesment_hazard')->where('vessel_info_id', $result->id)
                    ->orderBy('id', 'DESC')
                    ->first();
                // if ($RiskAss !== null)
                // {
                //     $lastID = explode("-", $RiskAss->id);
                //     // dd($lastID);
                //     $prevInc = (int)$lastID[3];
                //     $inc = $prevInc + 1;
                // }
                // else
                // {
                //     $inc = 1;
                // }
                // $id = $shipPrefix . '-riskassesment-B18template-' . (string)$inc;
                // $tempB18->id = $id;
                $tempB18->is_template      = $is_template;
                // $tempB18->template_id = $tempTemplate->id;
                $tempB18->riskAssesment_id = $temp_id;
                // Log::info('ID '.print_r($forb18,true));
                $tempB18->vessel_info_id   = $forb18;
                $tempB18->hazard_list_id   = $section_2_value->hazardTypeId;
                $tempB18->hazards          = $section_2_value->hazardSubTypeId;
                $tempB18->hazardEvent      = $section_2_value->hazardEvent;
                $tempB18->source           = $section_2_value->source;
                $tempB18->acFlag           = $section_2_value->acFlag;
                $tempB18->consequences     = $section_2_value->consequences;
                $tempB18->lkh1             = $section_2_value->lkh1;
                $tempB18->svr1             = $section_2_value->svr1;
                $tempB18->rf1              = $section_2_value->rf1;
                $tempB18->control_measure  = $section_2_value->control_measure;
                $tempB18->lkh2             = $section_2_value->lkh2;
                $tempB18->svr2             = $section_2_value->svr2;
                $tempB18->rf2              = $section_2_value->rf2;
                $tempB18->add_control      = $section_2_value->add_control;
                $tempB18->created_by       = Auth::user()->id;
                // if ($additional_control)
                // {
                //     foreach ($additional_control as $ac_value)
                //     {
                //         if ($section_2_value->section2RowCount == $ac_value->acRowCount)
                //         {
                //             $tempB18->additional_control = $ac_value->additional_control;
                //             $tempB18->additional_control_type = $ac_value->additional_control_type;
                //         }
                //     }
                // }
                $tempB18->save();
            }
        }
        return redirect('/userRiskAssesment');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        // dd('hey');
        $user = User::find(session('id'));
        if($user->hasPermissionTo('view.riskassessment')){
            $data = DB::table('risk_assesment');
            $data = $data->leftJoin('risk_assesment_details', 'risk_assesment_details.riskAssesment_id', '=', 'risk_assesment.riskAssesment_id')
                ->leftJoin('departments', 'risk_assesment_details.dept_id', '=', 'departments.id');
            if (session('is_ship')) {
                $data = $data->where('risk_assesment.creator_id', session('creator_id'));
            } 
            // $data = $data->select('risk_assesment_details.*', 'risk_assesment.name as NnameE', 'departments.name as dname')->orderBy('auto_inc')
            //     ->get();
            $data = $data->select('risk_assesment_details.*', 'risk_assesment.name as NnameE','risk_assesment.updated_at as Rupdated_at', 'departments.name as dname')->orderBy('Rupdated_at','DESC')
                ->get();
            // $drop = explode(',',DB::table('drop')->pluck('array')->first());
            $drop = $this->getDropVal();
            // dd($drop);
            // dd($data);
            return view('riskAssesmentView', ['datas'                  => $data, 'drops'                  => $drop]);
        }
        else{
            abort(404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // dd('edit',$id);
        $user = User::find(session('id'));
        if($user->hasPermissionTo('edit.riskassessment')){
            $department       = department::all();
            $vessel           = vessel::all();
            $template         = DB::table('risk_assesment')->where('risk_assesment.riskAssesment_id', $id);
            $template         = $template->leftJoin('risk_assesment_details', 'risk_assesment_details.riskAssesment_id', '=', 'risk_assesment.riskAssesment_id')
                ->select('risk_assesment_details.*', 'risk_assesment.id as idd', 'risk_assesment.name as name as name', 'risk_assesment.form_json as form_json','risk_assesment.creator_email as creator_email')
                ->get();

            
            $signature = Signature::where('form_id', $id)->pluck('url', 'signature');
            // Start to image collection

            $signedPhoto = [];
            if($signature && isset($signature['Master'])){
                $signedPhoto['Master'] = (new FileController)->getImageBase64($signature['Master']);
            }
            if($signature && isset($signature['ChiefEngg'])){
                $signedPhoto['ChiefEngg'] = (new FileController)->getImageBase64($signature['ChiefEngg']);
            }
            if($signature && isset($signature['ChiefOff'])){
                $signedPhoto['ChiefOff'] = (new FileController)->getImageBase64($signature['ChiefOff']);
            }
            if($signature && isset($signature['SecondEngg'])){
                $signedPhoto['SecondEngg'] = (new FileController)->getImageBase64($signature['SecondEngg']);
            }
            if($signature && isset($signature['SM'])){
                $signedPhoto['SM'] = (new FileController)->getImageBase64($signature['SM']);
            }
            if($signature && isset($signature['DGM'])){
                $signedPhoto['DGM'] = (new FileController)->getImageBase64($signature['DGM']);
            }
            if($signature && isset($signature['GM'])){
                $signedPhoto['GM'] = (new FileController)->getImageBase64($signature['GM']);
            }
            // end image collection

            // dd($signature);
            // $sign = DB::table('signature')->where('form_id',$id)->pluck('url','signature');
            // dd($template[0]);
            $vessel_name      = vessel::find($template[0]->vessel_id);
            $dept_name        = department::find($template[0]->dept_id);
            $riskMatriceColor = risk_matrix::pluck('hex_code', 'code');
            $riskFactor       = risk_matrix::pluck('risk_factor', 'code');
            $filledHazards    = hazard_list::select('hazard_lists.id', 'hazard_lists.code', 'hazard_lists.name')->get();

            // dd($template[0]);
            $templateData     = risk_assesment::leftJoin('risk_assesment_hazard', 'risk_assesment_hazard.riskAssesment_id', 'risk_assesment.riskAssesment_id')
            //->leftJoin('template_departments', 'template_departments.code', 'risk_assesment.template_code')
            ->leftJoin('hazard_lists', 'hazard_lists.id', 'risk_assesment_hazard.hazard_list_id')
                ->leftJoin('hazard_master_lists', 'hazard_master_lists.id', 'risk_assesment_hazard.hazards')
                ->select('risk_assesment.riskAssesment_id as id','risk_assesment.name as template_name', 'risk_assesment.ref as template_ref', 'risk_assesment.template_code as template_code', 'risk_assesment.form_json as json',
            //'template_departments.name as template_department_name',
            'risk_assesment_hazard.vessel_info_id as vessel_info_id', 'risk_assesment_hazard.hazard_list_id', 'risk_assesment_hazard.hazards', 'risk_assesment_hazard.consequences', 'risk_assesment_hazard.remarks', 'risk_assesment_hazard.hazardEvent', 'risk_assesment_hazard.source', 'risk_assesment_hazard.lkh1', 'risk_assesment_hazard.svr1', 'risk_assesment_hazard.rf1', 'risk_assesment_hazard.control_measure', 'risk_assesment_hazard.lkh2', 'risk_assesment_hazard.svr2', 'risk_assesment_hazard.rf2', 'risk_assesment_hazard.add_control', 'risk_assesment_hazard.acFlag', 'risk_assesment_hazard.additional_control', 'risk_assesment_hazard.additional_control_type',

            'hazard_master_lists.id as hazard_category_id', 'hazard_master_lists.hazard_no as hazard_master_list_name', 'hazard_lists.id as hazard_list_id', 'hazard_lists.code as hazard_lists_code', 'hazard_lists.name as hazard_lists_name')
                ->where('risk_assesment.riskAssesment_id', 'like', $id)->get();
            // dd($templateData);
            return view('riskAssesmentEdit', ['template' => $template, 'department' => $department, 'vessels' => $vessel, 'vessel_name' => $vessel_name, 'dept_name' => $dept_name, 'riskMatriceColor' => $riskMatriceColor, 'riskFactor' => $riskFactor, 'filledHazards' => $filledHazards, 'templateData' => $templateData, 'signature' => $signature,'Image' => $signedPhoto]);
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
        // dd('I am in update');
        // dd($request->form_temp);
        // dd('key', $request->key);
        $template                = risk_assesment::where('riskAssesment_id', $id)->first();
        // dd($template->name);
        $template->name          = $request->template_name;
        $template->template_code = $request->template_dept;
        $template->ref           = $request->template_dept_id;
        $template->form_json     = $request->form_temp;
        $template->updated_at     = now();
        $template->save();

        $template_details                  = risk_assesment_details::where('riskAssesment_id', $id)->first();
        // $template_details->vessel_id       = $request->input('vessel_id');
        $template_details->dept_id         = $request->input('dept-id');
        // if ($request->input('review-date')) $template_details->review_date = date('Y-m-d', strtotime($request->input('review-date')));
        // $template_details->weather = $request->input('weather');
        // $template_details->voyage = $request->input('voyage');
        // $template_details->location = $request->input('location');
        // $template_details->tide = $request->input('tide');
        // $template_details->work_activity = $request->input('work_activity');
        // $template_details->work_area = $request->input('work_area');
        // $template_details->visibility = $request->input('visibility');
            // dd($request->master_name);
            if($request->input('master_name')) $template_details->master_name        = $request->master_name;

            if ($request->input('master_date')) $template_details->master_date        = date('Y-m-d', strtotime($request->input('master_date')));

            $template_details->ch_off_name        = $request->input('ch_off_name');
            if ($request->input('ch_off_date')) $template_details->ch_off_date        = date('Y-m-d', strtotime($request->input('ch_off_date')));

            $template_details->ch_eng_name        = $request->input('ch_eng_name');

            if ($request->input('ch_eng_date')) $template_details->ch_eng_date        = date('Y-m-d', strtotime($request->input('ch_eng_date')));

            $template_details->eng2_name          = $request->input('eng2_name');

            if ($request->input('eng2_date')) $template_details->eng2_date          = date('Y-m-d', strtotime($request->input('eng2_date')));

            $template_details->sm_name            = $request->input('sm_name');

            if ($request->input('sm_date')) $template_details->sm_date            = date('Y-m-d', strtotime($request->input('sm_date')));

            $template_details->dgm_activity_type  = $request->input('dgm_activity_type');

            $template_details->dgm_name           = $request->input('dgm_name');

            if ($request->input('dgm_date')) $template_details->dgm_date           = date('Y-m-d', strtotime($request->input('dgm_date')));

            $template_details->name_rank          = $request->input('name_rank');

            $template_details->gm_activity_type   = $request->input('gm_activity_type');

            $template_details->gm_name            = $request->input('gm_name');

            if ($request->input('gm_date')) $template_details->gm_date            = date('Y-m-d', strtotime($request->input('gm_date')));

        if ($request->input('jha_date')) $template_details->jha_date        = date('Y-m-d', strtotime($request->input('jha_date')));
        $template_details->last_assessment = $request->last_assessment;

        $template_details->alternate_method   = $request->alternate_method;

            $template_details->hazard_discussed   = $request->hazard_discussed;
            if ($request->input('jha_start')) $template_details->jha_start          = date('Y-m-d', strtotime($request->input('jha_start')));
            if ($request->input('jha_end')) $template_details->jha_end            = date('Y-m-d', strtotime($request->input('jha_end')));
            $template_details->unassessed_hazards = $request->unassessed_hazards;
            $template_details->comments           = $request->comments;
            $template_details->port_authorities   = $request->port_authorities;
            $template_details->tools_available    = $request->tools_available;
            $template_details->lcd_notified       = $request->lcd_notified;
            $template_details->remarks            = $request->remarks;

        $template_details->save();

        if ($request->master_sign) {
            self::image_uploader($request->master_sign, config('constants.signatureFolders.MASTER'), $id);
        }

        if ($request->ch_off_sign) {
            self::image_uploader($request->ch_off_sign, config('constants.signatureFolders.CHIEF_OFF'), $id);
        }

        if ($request->ch_eng_sign) {
            self::image_uploader($request->ch_eng_sign, config('constants.signatureFolders.CHIEF_ENG'), $id);
        }

        if ($request->eng2_sign) {
            self::image_uploader($request->eng2_sign, config('constants.signatureFolders.SECOND_ENGG'), $id);
        }

        if ($request->sm_sign) {
            self::image_uploader($request->sm_sign, config('constants.signatureFolders.SM'), $id);
        }

        if ($request->dgm_sign) {
            self::image_uploader($request->dgm_sign, config('constants.signatureFolders.DGM'), $id);
        }

        if ($request->gm_sign) {
            self::image_uploader($request->gm_sign, config('constants.signatureFolders.GM'), $id);
        }

        $section_2_array      = json_decode($request->section_2_array);
        $additional_control   = json_decode($request->additional_control);
        if ($section_2_array)
        {
            // dd('absent');
            $deleteArray          = [];
            $b18TemplatesToDelete = [];
            //Log::info('b18 template id : '.print_r($tempTemplate->id,true));
            $section1Id           = '';
            $b18TemplatesToDelete = risk_assesment_hazard::where('riskAssesment_id', $id)->get();
            if (count($b18TemplatesToDelete))
            {
                $section1Id           = $b18TemplatesToDelete[0]->vessel_info_id;

            }
            // dd($b18TemplatesToDelete);
            foreach ($b18TemplatesToDelete as $temp)
            {
                array_push($deleteArray, $temp->id);
            }

            // $b18TemplatesToDelete=$b18TemplatesToDelete[0]->id;
            risk_assesment_hazard::destroy($deleteArray);
            //  dd('Deletion done');
            foreach ($section_2_array as $section_2_value)
            {
                $tempB18                   = new risk_assesment_hazard;

                // $tempB18->is_template = $is_template;
                $tempB18->riskAssesment_id = $id;
                $tempB18->vessel_info_id   = $section1Id;
                $tempB18->hazard_list_id   = $section_2_value->hazardTypeId;
                $tempB18->hazards          = $section_2_value->hazardSubTypeId;
                $tempB18->hazardEvent      = $section_2_value->hazardEvent;
                $tempB18->source           = $section_2_value->source;
                $tempB18->acFlag           = $section_2_value->acFlag;
                $tempB18->consequences     = $section_2_value->consequences;
                $tempB18->lkh1             = $section_2_value->lkh1;
                $tempB18->svr1             = $section_2_value->svr1;
                $tempB18->rf1              = $section_2_value->rf1;
                $tempB18->control_measure  = $section_2_value->control_measure;
                $tempB18->lkh2             = $section_2_value->lkh2;
                $tempB18->svr2             = $section_2_value->svr2;
                $tempB18->rf2              = $section_2_value->rf2;
                $tempB18->add_control      = $section_2_value->add_control;
                $tempB18->created_by       = Auth::user()->id;

                if (isset($additional_control) && $additional_control)
                {

                    foreach ($additional_control as $ac_value)
                    {
                        LOG::info('Test ' . print_r($ac_value, true));
                        if ($section_2_value->section2RowCount == $ac_value->acRowCount)
                        {
                            $tempB18->additional_control = $ac_value->additional_control;
                            $tempB18->additional_control_type = $ac_value->additional_control_type;

                        }
                    }
                }
                // LOG::info('Test '.print_r($ac_value,true));
                $tempB18->save();

            }

            //    dd('All done');



        }
        return redirect('/riskAssesmentView');
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
        // dd('destroy', $id);
        $user = User::find(session('id'));
        if($user->hasPermissionTo('delete.riskassessment')){
            risk_assesment::where('riskAssesment_id', $id)->delete();
            risk_assesment_details::where('riskAssesment_id', $id)->delete();
            risk_assesment_hazard::where('riskAssesment_id', $id)->delete();
            Signature::where('form_id',$id)->delete();
            return redirect('/riskAssesmentView');
        }
        else{
            abort(404);
        }
    }
    public function getRiskAssesmentId()
    {
        $p = DB::table('risk_assesment')->orderBy('created_at', 'DESC')
            ->pluck('riskAssesment_id')
            ->first();
        // dd($p);
        if ($p == null)
        {
            $riskAssesment_id = session('creator_id') . 'riskAssesment_1';
        }
        else
        {
            $arr              = explode('_', $p);
            $num              = (int)$arr[2];
            $next             = $num + 1;
            $riskAssesment_id = session('creator_id') . 'riskAssesment_' . $next;
        }
        // dd($riskAssesment_id);
        return $riskAssesment_id;
    }
    // api function for returning search data
    public function test(Request $r)
    {
        Log::info('enter');
        // if($r->data1 && $r->data2){
        //     // return $r->data1.$r->data2;
        //     return response()->json($r->data1.$r->data2);
        // }
        $jsonController = new JsonController;

        //search
        $searchWord     = $r->data2;
        $searchKey      = $r->data1;
        $tableName      = 'risk_assesment';
        $fieldName      = 'form_json';
        Log::info('searchKey : ' . print_r($r->data1, true));
        Log::info('searchWord : ' . print_r($r->data2, true));
        // $searchWord = 'Visible';
        // $searchKey = 'Visibility';
        // $tableName = 'templates';
        // $fieldName = 'form_json';
        $templates = $jsonController->search($searchWord, $searchKey, $tableName, $fieldName);

        return $templates;
    }
    // helper function for dropDown values
    public function getDropVal()
    {
        $keys     = DB::table('risk_assesment')->pluck('key');
        $drop_arr = [];
        foreach ($keys as $key)
        {
            $arr      = explode(',', $key);
            for ($i        = 0;$i < sizeof($arr);$i++)
            {
                if (!(in_array($arr[$i], $drop_arr)))
                {
                    array_push($drop_arr, $arr[$i]);
                }
            }
            Log::info('Key : ' . print_r($arr, true));
        }
        // dd($drop_arr,$keys);
        return $drop_arr;
    }
    // this will upload signature
    public function image_uploader($file, $uploadFolder, $formId)
    {
        //$uploadFolder = config('constants.signatureFolders.MASTER');
        //$formId = $result->id;\

        
        // this is deleting the previous signature that were uploaded on last update
        Signature::where('form_id', $formId)
        ->where('signature', $uploadFolder)
        ->delete();
        $uploads         = null;

        if ($file)
        {
            $jobFileLocation = env('UPLOAD_PATH') . DIRECTORY_SEPARATOR . $uploadFolder;
            if (!file_exists($jobFileLocation)) mkdir($jobFileLocation, 0777, true);

            $jobFileLocation = $jobFileLocation . DIRECTORY_SEPARATOR . $formId;
            if (!file_exists($jobFileLocation)) mkdir($jobFileLocation, 0777, true);

            $jobFileLocation      = $jobFileLocation . DIRECTORY_SEPARATOR;

            $target_file          = $jobFileLocation . $file->getClientOriginalName(); // original name that it was uploaded with
            if (move_uploaded_file($file, $target_file))
            {
                $uploads              = $uploadFolder . DIRECTORY_SEPARATOR . $formId . DIRECTORY_SEPARATOR . $file->getClientOriginalName();
            }
        }

        $signature            = new Signature;
        $signature->url       = $uploads;
        $signature->signature = $uploadFolder;
        $signature->form_id   = $formId;
        $signature->save();
    }
    // will upload signature on update also update signature table
    public function update_image_uploader($file, $uploadFolder, $formId)
    {
        //$uploadFolder = config('constants.signatureFolders.MASTER');
        //$formId = $result->id;
        $uploads         = null;

        if ($file)
        {
            $jobFileLocation = env('UPLOAD_PATH') . DIRECTORY_SEPARATOR . $uploadFolder;
            if (!file_exists($jobFileLocation)) mkdir($jobFileLocation, 0777, true);

            $jobFileLocation = $jobFileLocation . DIRECTORY_SEPARATOR . $formId;
            if (!file_exists($jobFileLocation)) mkdir($jobFileLocation, 0777, true);

            $jobFileLocation      = $jobFileLocation . DIRECTORY_SEPARATOR;

            $target_file          = $jobFileLocation . $file->getClientOriginalName(); // original name that it was uploaded with
            if (move_uploaded_file($file, $target_file))
            {
                $uploads              = $uploadFolder . DIRECTORY_SEPARATOR . $formId . DIRECTORY_SEPARATOR . $file->getClientOriginalName();
            }
        }

        Signature::where('form_id',$formId)
        ->where('signature',$uploadFolder)
        ->update(['url' => $uploads]);
        // $signature->url       = $uploads;
        // $signature->signature = $uploadFolder;
        // $signature->form_id   = $formId;
        // $signature->save();
    }
    public function riskAssesmenrPdf($id){
        // dd('I am in Pdf');
        $department       = department::all();
        $vessel           = vessel::all();
        $template         = DB::table('risk_assesment')->where('risk_assesment.riskAssesment_id', $id);
        $template         = $template->leftJoin('risk_assesment_details', 'risk_assesment_details.riskAssesment_id', '=', 'risk_assesment.riskAssesment_id')
            ->select('risk_assesment_details.*', 'risk_assesment.id as idd', 'risk_assesment.name as name as name', 'risk_assesment.form_json as form_json','risk_assesment.creator_email as creator_email')
            ->get();

        $signature = Signature::where('form_id', $id)->pluck('url', 'signature');
       
        // Start to image collection

        $signedPhoto = [];
        if($signature && isset($signature['Master'])){
            $signedPhoto['Master'] = (new FileController)->getImageBase64($signature['Master']);
        }
        if($signature && isset($signature['ChiefEngg'])){
            $signedPhoto['ChiefEngg'] = (new FileController)->getImageBase64($signature['ChiefEngg']);
        }
        if($signature && isset($signature['ChiefOff'])){
            $signedPhoto['ChiefOff'] = (new FileController)->getImageBase64($signature['ChiefOff']);
        }
        if($signature && isset($signature['SecondEngg'])){
            $signedPhoto['SecondEngg'] = (new FileController)->getImageBase64($signature['SecondEngg']);
        }
        if($signature && isset($signature['SM'])){
            $signedPhoto['SM'] = (new FileController)->getImageBase64($signature['SM']);
        }
        if($signature && isset($signature['DGM'])){
            $signedPhoto['DGM'] = (new FileController)->getImageBase64($signature['DGM']);
        }
        if($signature && isset($signature['GM'])){
            $signedPhoto['GM'] = (new FileController)->getImageBase64($signature['GM']);
        }
        // end image collection

        // dd($signature);
        // $sign = DB::table('signature')->where('form_id',$id)->pluck('url','signature');
        // dd($template[0]);
        $vessel_name      = vessel::find($template[0]->vessel_id);
        $dept_name        = department::find($template[0]->dept_id);
        $riskMatriceColor = risk_matrix::pluck('hex_code', 'code');
        $riskFactor       = risk_matrix::pluck('risk_factor', 'code');
        $filledHazards    = hazard_list::select('hazard_lists.id', 'hazard_lists.code', 'hazard_lists.name')->get();

        // dd($template[0]);
        $templateData     = risk_assesment::leftJoin('risk_assesment_hazard', 'risk_assesment_hazard.riskAssesment_id', 'risk_assesment.riskAssesment_id')
            //->leftJoin('template_departments', 'template_departments.code', 'risk_assesment.template_code')
            ->leftJoin('hazard_lists', 'hazard_lists.id', 'risk_assesment_hazard.hazard_list_id')
            ->leftJoin('hazard_master_lists', 'hazard_master_lists.id', 'risk_assesment_hazard.hazards')
            ->select(
                'risk_assesment.riskAssesment_id as id',
                'risk_assesment.name as template_name',
                'risk_assesment.ref as template_ref',
                'risk_assesment.template_code as template_code',
                'risk_assesment.form_json as json',
                //'template_departments.name as template_department_name',
                'risk_assesment_hazard.vessel_info_id as vessel_info_id',
                'risk_assesment_hazard.hazard_list_id',
                'risk_assesment_hazard.hazards',
                'risk_assesment_hazard.consequences',
                'risk_assesment_hazard.remarks',
                'risk_assesment_hazard.hazardEvent',
                'risk_assesment_hazard.source',
                'risk_assesment_hazard.lkh1',
                'risk_assesment_hazard.svr1',
                'risk_assesment_hazard.rf1',
                'risk_assesment_hazard.control_measure',
                'risk_assesment_hazard.lkh2',
                'risk_assesment_hazard.svr2',
                'risk_assesment_hazard.rf2',
                'risk_assesment_hazard.add_control',
                'risk_assesment_hazard.acFlag',
                'risk_assesment_hazard.additional_control',
                'risk_assesment_hazard.additional_control_type',

                'hazard_master_lists.id as hazard_category_id',
                'hazard_master_lists.hazard_no as hazard_master_list_name',
                'hazard_lists.id as hazard_list_id',
                'hazard_lists.code as hazard_lists_code',
                'hazard_lists.name as hazard_lists_name'
            )
            ->where('risk_assesment.riskAssesment_id', 'like', $id)->get();
        
            $dynamic = json_decode($templateData[0]->json);
            $test = [];
            for($i = 0 ; $i < count($dynamic); $i++){
               
                if(isset($dynamic[$i]->value)){
                    // Log::info("lable ".print_r($dynamic[$i]->label,true));
                    // Log::info("value ".print_r($dynamic[$i]->value,true));
                    $test[$dynamic[$i]->label] = $dynamic[$i]->value;
                   
                }
                else{
                    $test[$dynamic[$i]->label] = "";
                }
            }
            Log::info("value ".print_r($test,true));
            // dd('Stop');
        // return view('riskAssesmentPdf', ['template' => $template, 'department' => $department, 'vessels' => $vessel, 'vessel_name' => $vessel_name, 'dept_name' => $dept_name, 'riskMatriceColor' => $riskMatriceColor, 'riskFactor' => $riskFactor, 'filledHazards' => $filledHazards, 'templateData' => $templateData, 'signature' => $signature]);
        
        // $domPdf = PDF::setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => TRUE])->loadView('riskAssesmentPdf', ['template' => $template, 'department' => $department, 'vessels' => $vessel, 'vessel_name' => $vessel_name, 'dept_name' => $dept_name, 'riskMatriceColor' => $riskMatriceColor, 'riskFactor' => $riskFactor, 'filledHazards' => $filledHazards, 'templateData' => $templateData, 'signature' => $signature])
        // ->setPaper(array(0, 0, 1080, 1080))->setWarnings(false);
        // return $domPdf->stream('Risk Assesment' . $id . '.pdf');
        // share data to view
        //   view()->share('employee',$data);
      $pdf = PDF::loadView('riskAssesmentPdf', ['id' => $id, 'template' => $template, 'department' => $department, 'vessels' => $vessel, 'vessel_name' => $vessel_name, 'dept_name' => $dept_name, 'riskMatriceColor' => $riskMatriceColor, 'riskFactor' => $riskFactor, 'filledHazards' => $filledHazards, 'templateData' => $templateData, 'signature' => $signature,'Dynamic' => $test,'Image' => $signedPhoto]);
      // download PDF file with download method
      $pdf->setPaper('A4', 'landscape');
      return $pdf->download('Risk Assesment_' . $id . '.pdf');

    }
}


