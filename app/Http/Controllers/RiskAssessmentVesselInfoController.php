<?php
/**
* Class and Function List:
* Function list:
* - index()
* - extractValues()
* - create()
* - getEmptyRiskAssessmentData()
* - getSignatureImage()
* - image_uploader()
* - store()
* - show()
* - edit()
* - update()
* - destroy()
* - fetchdata()
* - fetchvesselref()
* - fetchHazardDataForSection2()
* - fetchAllDataForSection2()
* - templateEdit()
* - templateDelete()
* - templateUse()
* - getNewFormId()
* - getForm()
* - getTempId()
* - getTemplate()
* - editTemplate()
* - getUserData()
* Classes list:
* - RiskAssessmentVesselInfoController extends Controller
*/
namespace App\Http\Controllers;
use DB;
use Log;
use Auth;
use Session;
use App\Models\fleet;
use App\Models\department;
use App\Models\Signature;
use App\Models\location;
use App\Models\vessel;
use App\Models\rank;
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
use App\Http\Controllers\Vessel_detailsController;
use App\Http\Controllers\GenericController;

use Illuminate\Http\Request;

class RiskAssessmentVesselInfoController extends Controller
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

    public function extractValues($object, $field)
    {
        try
        {
            $arr = [null];
            foreach ($object as $value)
            {
                if (!in_array($value[$field], $arr))
                {
                    if ($value[$field])
                    {
                        array_push($arr, $value[$field]);
                    }
                }
            }
            return $arr;
        }
        catch(Exception $e)
        {
            report($e);
        }
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // dd('Create');
        $tempDepartments  = null;
        $tempHeaders      = null;
        if (Auth::user()->isAdmin())
        {
            $form_title       = trans('titles.b18CreateTemplate');
            $tempDepartments  = TemplateDepartment::all();
            //$tempHeaders = [null,'Operation','Maintainence'];
            $tempHeaders      = self::extractValues($tempDepartments, 'header');
        }
        else
        {
            $form_title       = trans('titles.b18');
        }

        $risk_matrices    = risk_matrix::all();
        $department       = department::all();
        $location         = location::all();
        $ranks            = rank::all();
        $verifiedRanks    = $ranks;
        $reviewRanks      = reviewRanks::all();
        $fleet            = fleet::all();
        $vessel           = vessel::all();
        $templateData     = null;
        $filledHazards    = hazard_list::select('hazard_lists.id', 'hazard_lists.code', 'hazard_lists.name')->get();

        $vessel_fleet     = vessel::join('fleets', 'vessels.fleet_id', '=', 'fleets.id')->select('vessels.id as id', 'vessels.fleet_id as fleet_id', 'vessels.code as code', 'vessels.name as name', 'fleets.name as fltname')
            ->get();

        $var              = self::getEmptyRiskAssessmentData();
        // dd($var);
        $riskMatriceColor = risk_matrix::pluck('hex_code', 'code');
        $riskFactor       = risk_matrix::pluck('risk_factor', 'code');
        return view('risk_assessment_create')->with(['tempHeaders'     => null, 'tempHeaders'     => $tempHeaders, 'tempDepartments'     => $tempDepartments, 'form_title'     => $form_title, 'templateId'     => null, 'VesselInfoId'     => null, 'department'     => $department, 'location'     => $location, 'ranks'     => $ranks, 'fleet'     => $fleet, 'vessels'     => $vessel, 'verifiedRanks'     => $verifiedRanks, 'reviewRanks'     => $reviewRanks, 'vessel_fleet'     => $vessel_fleet, 'risk_matrices'     => $risk_matrices, 'filledHazards'     => $filledHazards, 'templateData'     => $templateData, 'risk_assessment_data'     => $var, 'templateName'     => null, 'riskMatriceColor'     => $riskMatriceColor, 'riskFactor'     => $riskFactor, 'type'     => 'create']);
    }

    public function getEmptyRiskAssessmentData()
    {
        try
        {
            $var = $var = (object)array(
                "id" => "",
                "ref" => "",
                "vessel_id" => "",
                "fleet_id" => "",
                "dept_id" => "",
                "loc_id" => "",
                "assess_date" => "",
                "activity_name" => "",
                "activity_type" => "",
                "activity_group" => "",
                "linkages" => "",
                "assessed_by" => "",
                "assess_rank" => "",
                "verified_by" => "",
                "verify_rank" => "",
                "review_date" => "",
                "reviewed_by" => "",
                "review_rank" => "",
                "comments" => "",
                "created_at" => "",
                "updated_at" => "",
                "created_by" => "",
                "vessel_code" => "",
                "vessel_name" => "",
                "vessel_fleet_id" => "",
                "fleet_name" => "",
                "recommendations" => "",
                "ref" => "",
                "template_code" => ""
            );

            return $var;
        }
        catch(Exception $e)
        {
            report($e);
        }
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getSignatureImage($formId, $signature)
    {
        try
        {
            //$url = 'MemberTemporary/257/dessert.jpg';
            //dd(env('IMAGE_PATH'));
            $imagepath = (Signature::where('form_id', $formId)->where('signature', $signature)->select('url')
                ->first());

            if ($imagepath)
            {
                //  dd($imagepath);
                $imagepath = $imagepath->url;
                $imgPath   = env('UPLOAD_PATH') . '/' . $imagepath;
                return response()->file($imgPath);
            }
        }
        catch(Exception $e)
        {
            report($e);
        }
    }

    public function image_uploader($file, $uploadFolder, $formId)
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

        $signature            = new Signature;
        $signature->url       = $uploads;
        $signature->signature = $uploadFolder;
        $signature->form_id   = $formId;
        $signature->save();
    }

    public function store(Request $request)
    {
        // dd('S');
        $tempB18                    = null;
        $section_1_id               = $request->input('section_1_id');
        $section_2_id               = $request->input('section_2_id');
        $is_template                = $request->input('is_template');
        $template_name              = $request->input('template_name');

        $section_2_array            = json_decode($request->section_2_array);
        $additional_control         = json_decode($request->additional_control);

        //$stored_section_1_id = null;
        if ($section_1_id)
        { // if section 1 id is there, we're editing a user form
            // dd('user');
            $result                     = template_details::find($section_1_id);
            // $result->id = $request->input('id');
            $result->created_by         = Auth::user()->id;

            //$result->vessel_name = $request->input('vessel_name');
            $result->vessel_id          = $request->input('vessel_id');
            if ($request->input('review-date')) $result->review_date        = date('Y-m-d', strtotime($request->input('review-date')));
            $result->weather            = $request->input('weather');
            $result->voyage             = $request->input('voyage');
            $result->location           = $request->input('location');
            $result->tide               = $request->input('tide');
            $result->work_activity      = $request->input('work_activity');
            $result->work_area          = $request->input('work_area');
            $result->visibility         = $request->input('visibility');

            if($request->input('master_name')) $result->master_name        = $request->input('master_name');
            if ($request->input('master_date')) $result->master_date        = date('Y-m-d', strtotime($request->input('master_date')));
            $result->ch_off_name        = $request->input('ch_off_name');
            if ($request->input('ch_off_date')) $result->ch_off_date        = date('Y-m-d', strtotime($request->input('ch_off_date')));
            $result->ch_eng_name        = $request->input('ch_eng_name');
            if ($request->input('ch_eng_date')) $result->ch_eng_date        = date('Y-m-d', strtotime($request->input('ch_eng_date')));
            $result->eng2_name          = $request->input('eng2_name');
            if ($request->input('eng2_date')) $result->eng2_date          = date('Y-m-d', strtotime($request->input('eng2_date')));
            $result->sm_name            = $request->input('sm_name');
            if ($request->input('sm_date')) $result->sm_date            = date('Y-m-d', strtotime($request->input('sm_date')));
            $result->dgm_activity_type  = $request->input('dgm_activity_type');
            $result->dgm_name           = $request->input('dgm_name');
            if ($request->input('dgm_date')) $result->dgm_date           = date('Y-m-d', strtotime($request->input('dgm_date')));
            $result->name_rank          = $request->input('name_rank');
            $result->gm_activity_type   = $request->input('gm_activity_type');
            $result->gm_name            = $request->input('gm_name');
            if ($request->input('gm_date')) $result->gm_date            = date('Y-m-d', strtotime($request->input('gm_date')));

            if ($request->input('jha_date')) $result->jha_date           = date('Y-m-d', strtotime($request->input('jha_date')));
            $result->last_assessment    = $request->last_assessment;

            $result->alternate_method   = $request->alternate_method;
            $result->hazard_discussed   = $request->hazard_discussed;
            if ($request->input('jha_start')) $result->jha_start          = date('Y-m-d', strtotime($request->input('jha_start')));
            if ($request->input('jha_end')) $result->jha_end            = date('Y-m-d', strtotime($request->input('jha_end')));
            $result->unassessed_hazards = $request->unassessed_hazards;
            $result->comments           = $request->comments;
            $result->port_authorities   = $request->port_authorities;
            $result->tools_available    = $request->tools_available;
            $result->lcd_notified       = $request->lcd_notified;
            $result->remarks            = $request->remarks;

            $result->save();

            if ($request->master_sign)
            {
                self::image_uploader($request->master_sign, config('constants.signatureFolders.MASTER') , $result->id);
            }

            if ($request->ch_off_sign)
            {
                self::image_uploader($request->ch_off_sign, config('constants.signatureFolders.CHIEF_ENG') , $result->id);
            }

            if ($request->ch_eng_sign)
            {
                self::image_uploader($request->ch_eng_sign, config('constants.signatureFolders.CHIEF_OFF') , $result->id);
            }

            if ($request->eng2_sign)
            {
                self::image_uploader($request->eng2_sign, config('constants.signatureFolders.SECOND_ENGG') , $result->id);
            }

            if ($request->sm_sign)
            {
                self::image_uploader($request->sm_sign, config('constants.signatureFolders.SM') , $result->id);
            }

            if ($request->dgm_sign)
            {
                self::image_uploader($request->dgm_sign, config('constants.signatureFolders.DGM') , $result->id);
            }

            if ($request->gm_sign)
            {
                self::image_uploader($request->gm_sign, config('constants.signatureFolders.GM') , $result->id);
            }

            if ($section_2_array)
            {

                $b18TemplatesToDelete = template_hazard::where('vessel_info_id', $section_1_id)->pluck('id');
                template_hazard::destroy($b18TemplatesToDelete);

                foreach ($section_2_array as $section_2_value)
                {
                    $tempB18                          = new template_hazard;

                    $tempB18->is_template             = $is_template;
                    //  $tempB18->template_id = $tempTemplate->id;
                    $tempB18->vessel_info_id          = $result->id;
                    $tempB18->hazard_list_id          = $section_2_value->hazardTypeId;
                    $tempB18->hazards                 = $section_2_value->hazardSubTypeId;
                    $tempB18->hazardEvent             = $section_2_value->hazardEvent;
                    $tempB18->source                  = $section_2_value->source;
                    $tempB18->acFlag                  = $section_2_value->acFlag;
                    $tempB18->consequences            = $section_2_value->consequences;
                    $tempB18->lkh1                    = $section_2_value->lkh1;
                    $tempB18->svr1                    = $section_2_value->svr1;
                    $tempB18->rf1                     = $section_2_value->rf1;
                    $tempB18->control_measure         = $section_2_value->control_measure;
                    $tempB18->lkh2                    = $section_2_value->lkh2;
                    $tempB18->svr2                    = $section_2_value->svr2;
                    $tempB18->rf2                     = $section_2_value->rf2;
                    $tempB18->add_control             = $section_2_value->add_control;
                    if ($additional_control)
                    {
                        foreach ($additional_control as $ac_value)
                        {
                            if ($section_2_value->section2RowCount == $ac_value->acRowCount)
                            {
                                $tempB18->additional_control      = $ac_value->additional_control;
                                $tempB18->additional_control_type = $ac_value->additional_control_type;
                            }
                        }
                    }
                    $tempB18->created_by              = Auth::user()->id;

                    $tempB18->save();

                }
            }
        }
        else if ($section_2_id)
        { // if section 2 id is there, it is a template which we're editing
            $this->editTemplate($request);

        }
        else
        { // else it is a new template or form which is being stored
            // dd('I');
            if ($is_template)
            { // if it is a template being created
                $this->getTemplate($request);
            }
            else
            { // or a user form
                // dd('user');
                $this->getUserData($request);

            }
        }

        // return $tempB18;
        return redirect('/risk_assessment');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\template_details  $template_details
     * @return \Illuminate\Http\Response
     */
    public function show(template_details $template_details)
    {
        // dd('show');
        $user      = Auth::user();
        $templates = null;
        $saved     = null;

        $templates = Template::join('template_hazard', 'template_hazard.template_id', 'templates.template_id')->leftJoin('template_departments', 'template_departments.code', 'templates.template_code');
        // $temp = dB::table('templates')->jeftJoin()
        if ($user->isAdmin())
        {
            $templates = $templates->where('template_hazard.created_by', $user->id);
        }

        $templates = $templates->where('is_template', 1)
            ->select('templates.id', 'templates.name', 'templates.template_code', 'templates.ref', 'templates.form_json', DB::raw('MAX(template_departments.name) as department_name'))
            ->groupBy('templates.id', 'templates.name', 'templates.template_code', 'templates.ref', 'templates.form_json');
        if ($user->isAdmin())
        {
            $templates = $templates->orderBy('templates.created_at', 'desc');
        }
        else
        {
            $templates = $templates->orderBy('templates.name');
        }

        $templates = $templates->get();

        // if (!$user->isAdmin())
        // {
        //     $saved = template_details::
        //     // leftJoin('departments','template_details.dept_id','departments.id')
        //     leftJoin('vessels', 'vessels.id', 'template_details.vessel_id')->where('created_by', $user->id)
        //         ->select('template_details.id as id', 'template_details.weather as weather', 'template_details.voyage as voyage', 'template_details.location as location', 'template_details.tide as tide', 'template_details.work_activity as work_activity', 'template_details.work_area as work_area', 'template_details.visibility as visibility', 'template_details.review_date as review_date', 'template_details.master_name as master_name', 'template_details.master_date as master_date', 'template_details.ch_off_name as ch_off_name', 'template_details.ch_off_date as ch_off_date', 'template_details.ch_eng_name as ch_eng_name', 'template_details.ch_eng_date as ch_eng_date', 'template_details.eng2_name as eng2_name', 'template_details.eng2_date as eng2_date', 'template_details.sm_name as sm_name', 'template_details.sm_date as sm_date', 'template_details.dgm_name as dgm_name', 'template_details.gm_date as dgm_date', 'template_details.gm_name as gm_name', 'template_details.dgm_date as gm_date', 'template_details.remarks as remarks', 'template_details.status as status',
        //     // 'template_details.ref as ref',
        //     // 'template_details.recommendations as recommendations',
        //     // 'vessels.code as code',
        //     'vessels.name as v_name'
        //     // 'fleets.name as f_name',
        //     // 'departments.name as d_name',
        //     // 'locations.name as loc_name'
        //     )
        //     //->where('is_template','!=',1)
        //         ->orderBy('template_details.created_at', 'desc')
        //         ->get();
        // }
        // dd($saved,
        //     $templates
        // );
        return view('risk_assessment')
            ->with(['templates'                    => $templates, 'saved'                    => $saved]);
        // return $risk_table_data;

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\template_details  $template_details
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        // dd('Edit');
        try
        {
            if (Auth::user()->isAdmin())
            {
                $form_title         = trans('titles.b18Edit');
                $tempDepartments    = null;
                $tempHeaders        = null;
                $id                 = $request->id;
                // dd($id);
                $ranks              = rank::all();
                $fleet              = fleet::all();
                $vessel_details     = vessel::all();
                $department_details = department::all();
                $location_details   = location::all();
                $verifiedRanks      = $ranks;
                $reviewRanks        = reviewRanks::all();
                // $rank_details = rank::all();
                // $fleet_details = fleet::all();
                $var                = template_details::where('template_details.id', $id)->select('template_details.*'
                // 'v.code as vessel_code',
                // 'v.name as vessel_name',
                // 'v.fleet_id as vessel_fleet_id',
                // 'f.name as fleet_name'
                )
                    ->orderBy('template_details.created_at', 'desc')
                    ->first();
                //dd($var);
                $b_18_FOrm_data     = template_hazard::leftJoin('hazard_lists as hl', 'hl.id', 'template_hazard.hazard_list_id')->leftJoin('hazard_master_lists', 'hazard_master_lists.id', 'template_hazard.hazards')
                    ->where('vessel_info_id', $var['id'])->select('template_hazard.hazard_list_id', 'template_hazard.hazards', 'template_hazard.consequences', 'template_hazard.remarks', 'template_hazard.hazardEvent', 'template_hazard.source', 'template_hazard.lkh1', 'template_hazard.svr1', 'template_hazard.rf1', 'template_hazard.control_measure', 'template_hazard.lkh2', 'template_hazard.svr2', 'template_hazard.rf2', 'template_hazard.acFlag', 'template_hazard.add_control', 'template_hazard.additional_control', 'template_hazard.additional_control_type', 'hazard_master_lists.id as hazard_category_id', 'hazard_master_lists.hazard_no as hazard_master_list_name', 'hl.id as hazard_list_id', 'hl.code as hazard_lists_code', 'hl.name as hazard_lists_name')
                    ->get();
                //dd($b_18_FOrm_data);
                $signature          = signature::pluck('url', 'signature')->where('form_id', $var['id']);
                $risk_matrix        = risk_matrix::all();
                $filledHazards      = hazard_list::select('hazard_lists.id', 'hazard_lists.code', 'hazard_lists.name')->get();
                $riskMatriceColor   = risk_matrix::pluck('hex_code', 'code');
                $riskFactor         = risk_matrix::pluck('risk_factor', 'code');
                // dd($var);
                return view('risk_assessment_create')->with(['tempHeaders'                    => $tempHeaders, 'form_title'                    => $form_title, 'templateId'                    => null, 'tempDepartments'                    => $tempDepartments, 'VesselInfoId'                    => $id, 'department'                    => $department_details, 'location'                    => $location_details, 'ranks'                    => $ranks, 'fleet'                    => $fleet, 'verifiedRanks'                    => $verifiedRanks, 'reviewRanks'                    => $reviewRanks, 'vessels'                    => $vessel_details, 'risk_matrices'                    => $risk_matrix, 'filledHazards'                    => $filledHazards, 'templateData'                    => $b_18_FOrm_data, 'risk_assessment_data'                    => $var, 'templateName'                    => null, 'riskMatriceColor'                    => $riskMatriceColor, 'riskFactor'                    => $riskFactor, 'signature'                    => $signature]);
            }
            else
            {
                // dd($request->id);
                $form_title         = trans('titles.b18Edit');
                $tempDepartments    = null;
                $tempHeaders        = null;
                $id                 = $request->id;
                // dd($id);
                $ranks              = rank::all();
                $fleet              = fleet::all();
                $vessel_details     = vessel::all();
                $department_details = department::all();
                $location_details   = location::all();
                $verifiedRanks      = $ranks;
                $reviewRanks        = reviewRanks::all();
                // $rank_details = rank::all();
                // $fleet_details = fleet::all();
                $var                = risk_assesment_details::where('risk_assesment_details.id', $id)->select('risk_assesment_details.*'
                // 'v.code as vessel_code',
                // 'v.name as vessel_name',
                // 'v.fleet_id as vessel_fleet_id',
                // 'f.name as fleet_name'
                )
                    ->orderBy('risk_assesment_details.created_at', 'desc')
                    ->first();
                //dd($var);
                $b_18_FOrm_data     = template_hazard::leftJoin('hazard_lists as hl', 'hl.id', 'template_hazard.hazard_list_id')->leftJoin('hazard_master_lists', 'hazard_master_lists.id', 'template_hazard.hazards')
                    ->where('vessel_info_id', $var['id'])->select('template_hazard.hazard_list_id', 'template_hazard.hazards', 'template_hazard.consequences', 'template_hazard.remarks', 'template_hazard.hazardEvent', 'template_hazard.source', 'template_hazard.lkh1', 'template_hazard.svr1', 'template_hazard.rf1', 'template_hazard.control_measure', 'template_hazard.lkh2', 'template_hazard.svr2', 'template_hazard.rf2', 'template_hazard.acFlag', 'template_hazard.add_control', 'template_hazard.additional_control', 'template_hazard.additional_control_type', 'hazard_master_lists.id as hazard_category_id', 'hazard_master_lists.hazard_no as hazard_master_list_name', 'hl.id as hazard_list_id', 'hl.code as hazard_lists_code', 'hl.name as hazard_lists_name')
                    ->get();
                //dd($b_18_FOrm_data);
                $signature          = signature::pluck('url', 'signature')->where('form_id', $var['id']);
                $risk_matrix        = risk_matrix::all();
                $filledHazards      = hazard_list::select('hazard_lists.id', 'hazard_lists.code', 'hazard_lists.name')->get();
                $riskMatriceColor   = risk_matrix::pluck('hex_code', 'code');
                $riskFactor         = risk_matrix::pluck('risk_factor', 'code');
                return view('risk_assessment_create')->with(['tempHeaders' => $tempHeaders, 'form_title' => $form_title, 'templateId' => null, 'tempDepartments' => $tempDepartments, 'VesselInfoId' => $id, 'department' => $department_details, 'location' => $location_details, 'ranks' => $ranks, 'fleet' => $fleet, 'verifiedRanks' => $verifiedRanks, 'reviewRanks' => $reviewRanks, 'vessels' => $vessel_details, 'risk_matrices' => $risk_matrix, 'filledHazards' => $filledHazards, 'templateData' => $b_18_FOrm_data, 'risk_assessment_data' => $var, 'templateName' => null, 'riskMatriceColor' => $riskMatriceColor, 'riskFactor' => $riskFactor, 'signature' => $signature]);
            }

            /*return view('risk_assessment_update')->with([
                                                            'risk_assessment_data'=>$var[0],
                                                            'vessel_info'=>$vessel_details,
                                                            'department_info'=>$department_details,
                                                            'location_info'=>$location_details,
                                                            'hazardMasters'=>$b_18_FOrm_data,
                                                            'risk_matrix'=>$risk_matrix
                                                        ]);*/
        }
        catch(Exception $e)
        {
            report($e);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\template_details  $template_details
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, template_details $template_details, $id)
    {

        $result                    = template_details::find($id);
        // $result->id = $request->id;
        // $result->vessel_id = $request->input('vessel-id');
        // $result->fleet_id = $request->input('fleet-id');
        // $result->dept_id = $request->input('dept-id');
        // $result->loc_id = $request->input('location');
        // $result->vessel_name = $request->input('vessel_name');
        $result->vessel_id         = $request->input('vessel_id');
        $result->review_date       = date('Y-m-d', strtotime($request->input('review-date')));
        $result->weather           = $request->input('weather');
        $result->voyage            = $request->input('voyage');
        $result->location          = $request->input('location');
        $result->tide              = $request->input('tide');
        $result->work_activity     = $request->input('work_activity');
        $result->work_area         = $request->input('work_area');
        $result->visibility        = $request->input('visibility');
        $result->master_name       = $request->input('master_name');
        $result->master_date       = date('Y-m-d', strtotime($request->input('master_date')));
        $result->ch_off_name       = $request->input('ch_off_name');
        $result->ch_off_date       = date('Y-m-d', strtotime($request->input('ch_off_date')));
        $result->ch_eng_name       = $request->input('ch_eng_name');
        $result->ch_eng_date       = date('Y-m-d', strtotime($request->input('ch_eng_date')));
        $result->eng2_name         = $request->input('eng2_name');
        $result->eng2_date         = date('Y-m-d', strtotime($request->input('eng2_date')));
        $result->sm_name           = $request->input('sm_name');
        $result->sm_date           = date('Y-m-d', strtotime($request->input('sm_date')));
        $result->dgm_activity_type = $request->input('dgm_activity_type');
        $result->dgm_name          = $request->input('dgm_name');
        $result->dgm_date          = date('Y-m-d', strtotime($request->input('dgm_date')));
        $result->name_rank         = $request->input('name_rank');
        $result->gm_activity_type  = $request->input('gm_activity_type');
        $result->gm_name           = $request->input('gm_name');
        $result->gm_date           = date('Y-m-d', strtotime($request->input('gm_date')));
        $result->created_by        = Auth::user()->id;

        $result->save();

        Session::flash('status', 2);
        return redirect('risk_assessment');

        // $notification = array(
        //     'message'=>'Data updated successfully',
        //     'alert-type'=>'success'
        // )
        // return redirect('risk_assessment')->with(['notification'=>$notification]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\template_details  $template_details
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try
        {
            template_details::destroy(array(
                'id',
                $id
            ));
            Session::flash('status', 3);
            return redirect('risk_assessment');
        }
        catch(Exception $e)
        {
            report($e);
        }
    }

    public function fetchdata(Request $id)
    {
        try
        {
            $code_id      = $id->input('id');
            $vessel_fleet = DB::table('vessels')->join('fleets', 'vessels.fleet_id', '=', 'fleets.id')
                ->select('vessels.id as id', 'vessels.fleet_id as fleet_id', 'vessels.code as code', 'vessels.name as name', 'fleets.name as fltname')
                ->where('vessels.id', $code_id)->get();

            // $result = DB::table('vessels')->join('fleets', 'vessels.fleet_id','=', 'fleets.id')->where('vessels.id',$id)
            // ->get();
            return $vessel_fleet;
        }
        catch(Exception $e)
        {
            report($e);
        }
    }

    public function fetchvesselref(Request $id)
    {
        try
        {

            $code_id = $id->input('id');
            //$data = template_details::where('vessel_id',$code_id)->get();
            $data2   = template_details::where('vessel_id', $code_id)->orderBy('ref', 'desc')
                ->first();
            if (!$data2)
            {
                return 0;
            }
            else
            {
                $ref = $data2->ref;
                return $ref;
            }
            // $ref = $data->ref;
            return $data2 . length;
        }
        catch(Exception $e)
        {
            report($e);
        }
    }

    public function fetchHazardDataForSection2(Request $request)
    {
        try
        {
            $id   = $request->id;
            $data = hazard_master_list::join('hazard_lists', 'hazard_lists.id', 'hazard_master_lists.hazard_id')->where('hazard_master_lists.hazard_id', $id)->select('hazard_master_lists.id','hazard_master_lists.causes', 'hazard_master_lists.hazard_details' , 'ref', DB::raw('case when ref<10 then concat(hazard_lists.code,".0",ref) when ref>=10 then concat(hazard_lists.code,".",ref) end as reference') , DB::raw('concat(hazard_no," ",hazard_details," | Source: ",source," | Impact: ",impact) as hazards'))
                ->get();
            // dd($data->toArray());
            return $data;
        }
        catch(Exception $e)
        {
            report($e);
        }
    }

    public function fetchAllDataForSection2(Request $request)
    {
        try
        {
            $id   = $request->id;

            $data = hazard_master_list::find($id);

            return $data;
        }
        catch(Exception $e)
        {
            report($e);
        }
    }

    public function templateEdit(Request $request)
    {
        // dd('edit');
        try
        {
            $form_title      = trans('titles.b18EditTemplate');
            $id              = $request->id;
            $d               = DB::table('templates')->where('id', $request->id)
                ->first();
            // dd($d->template_id);
            $tempDepartments = null;
            // $templateData = Template::leftJoin('template_hazard', 'template_hazard.template_id', 'templates.id')->leftJoin('template_departments', 'template_departments.code', 'templates.template_code')
            //     ->leftJoin('hazard_lists', 'hazard_lists.id', 'template_hazard.hazard_list_id')
            //     ->leftJoin('hazard_master_lists', 'hazard_master_lists.id', 'template_hazard.hazards')
            //     ->select('templates.name as template_name', 'templates.ref as template_ref', 'templates.template_code as template_code', 'template_departments.name as template_department_name', 'template_hazard.vessel_info_id as vessel_info_id', 'template_hazard.hazard_list_id', 'template_hazard.hazards', 'template_hazard.consequences', 'template_hazard.remarks', 'template_hazard.hazardEvent', 'template_hazard.source', 'template_hazard.lkh1', 'template_hazard.svr1', 'template_hazard.rf1', 'template_hazard.control_measure', 'template_hazard.lkh2', 'template_hazard.svr2', 'template_hazard.rf2', 'template_hazard.add_control', 'template_hazard.acFlag', 'template_hazard.additional_control', 'template_hazard.additional_control_type',
            // 'hazard_master_lists.id as hazard_category_id', 'hazard_master_lists.hazard_no as hazard_master_list_name', 'hazard_lists.id as hazard_list_id', 'hazard_lists.code as hazard_lists_code', 'hazard_lists.name as hazard_lists_name')
            //     ->where('template_id', $id)->get();
            $templateData    = Template::leftJoin('template_hazard', 'template_hazard.template_id', 'templates.template_id')->leftJoin('template_departments', 'template_departments.code', 'templates.template_code')
                ->leftJoin('hazard_lists', 'hazard_lists.id', 'template_hazard.hazard_list_id')
                ->leftJoin('hazard_master_lists', 'hazard_master_lists.id', 'template_hazard.hazards')
                ->select('templates.name as template_name', 'templates.ref as template_ref', 'templates.template_code as template_code', 'templates.form_json as json', 'template_departments.name as template_department_name', 'template_hazard.vessel_info_id as vessel_info_id', 'template_hazard.hazard_list_id', 'template_hazard.hazards', 'template_hazard.consequences', 'template_hazard.remarks', 'template_hazard.hazardEvent', 'template_hazard.source', 'template_hazard.lkh1', 'template_hazard.svr1', 'template_hazard.rf1', 'template_hazard.control_measure', 'template_hazard.lkh2', 'template_hazard.svr2', 'template_hazard.rf2', 'template_hazard.add_control', 'template_hazard.acFlag', 'template_hazard.additional_control', 'template_hazard.additional_control_type',

            'hazard_master_lists.id as hazard_category_id', 'hazard_master_lists.hazard_no as hazard_master_list_name', 'hazard_lists.id as hazard_list_id', 'hazard_lists.code as hazard_lists_code', 'hazard_lists.name as hazard_lists_name')
                ->where('templates.template_id', 'like', $d->template_id)
                ->get();
            //'templates.template_id as idd',
            // ->where('idd', $d->template_id)
            // dd($templateData);
            $risk_matrices   = risk_matrix::all();
            $department      = department::all();
            $location        = location::all();
            $ranks           = rank::all();
            $verifiedRanks   = $ranks;
            $reviewRanks     = reviewRanks::all();
            $fleet           = fleet::all();
            $vessel          = vessel::all();
            $filledHazards   = hazard_list::select('hazard_lists.id', 'hazard_lists.code', 'hazard_lists.name')->get();

            $vessel_fleet    = vessel::join('fleets', 'vessels.fleet_id', '=', 'fleets.id')->select('vessels.id as id', 'vessels.fleet_id as fleet_id', 'vessels.code as code', 'vessels.name as name', 'fleets.name as fltname')
                ->get();

            $var             = null;
            $templateName    = null;
            // dd($templateData);
            if ($templateData->count() > 0)
            {
                $var             = template_details::where('template_details.id', $templateData[0]->vessel_info_id)
                    ->select('template_details.*'
                // 'v.code as vessel_code',
                // 'v.name as vessel_name',
                // 'v.fleet_id as vessel_fleet_id',
                // 'f.name as fleet_name'
                )
                    ->orderBy('template_details.created_at', 'desc')
                    ->first();
                // dd($templateData[0]->vessel_info_id,
                // 'Hey',
                // $var);
                $templateName    = $templateData[0]->template_name;
                //     dd($templateData[0]->vessel_info_id ,
                // $var);

            }
            else
            {
                Session::flash('status', 4);
                return redirect()
                    ->back();
            }
            // dd($var);
            $riskMatriceColor = risk_matrix::pluck('hex_code', 'code');
            $riskFactor       = risk_matrix::pluck('risk_factor', 'code');
            if ($var && isset($var['id']))
            {
                $signature        = signature::where('signature.form_id', $var['id'])->pluck(

                'signature.url', 'signature.signature');
            }
            else
            {
                $signature        = null;
            }
            // dd($riskMatriceColor);
            // dd($var);
            return view('risk_assessment_create')->with(['tempHeaders' => null, 'form_title' => $form_title, 'templateId' => $id, 'VesselInfoId' => null, 'tempDepartments' => $tempDepartments, 'department' => $department, 'location' => $location, 'ranks' => $ranks, 'fleet' => $fleet, 'vessels' => $vessel, 'verifiedRanks' => $verifiedRanks, 'reviewRanks' => $reviewRanks, 'vessel_fleet' => $vessel_fleet, 'risk_matrices' => $risk_matrices, 'filledHazards' => $filledHazards, 'templateData' => $templateData, 'risk_assessment_data' => $var, 'templateName' => $templateName, 'riskMatriceColor' => $riskMatriceColor, 'riskFactor' => $riskFactor, 'signature' => $signature, 'type' => 'edit']);
        }
        catch(Exception $e)
        {
            report($e);
        }
    }

    public function templateDelete(Request $request)
    {
        try
        {
            $id          = $request->id;

            $deletedRows = template_hazard::where('template_id', $id)->delete();
            Template::destroy($id);
            Session::flash('status', 3);
            return redirect()->back();
        }
        catch(Exception $e)
        {
            report($e);
        }
    }

    public function templateUse(Request $request)
    {
        // dd($request->id);
        try
        {
            $form_title       = trans('titles.b18');
            $id               = $request->id;

            $riskMatriceColor = risk_matrix::pluck('hex_code', 'code');
            $riskFactor       = risk_matrix::pluck('risk_factor', 'code');

            $d                = DB::table('templates')->where('id', $request->id)
                ->first();
            // dd($d);
            //dd($riskMatriceColor);
            $templateData     = Template::join('template_hazard', 'template_hazard.template_id', 'templates.template_id')->leftJoin('hazard_lists', 'hazard_lists.id', 'template_hazard.hazard_list_id')
                ->leftJoin('hazard_master_lists', 'hazard_master_lists.id', 'template_hazard.hazards')
                ->select('templates.name as template_name', 'templates.ref as template_ref', 'templates.template_code as template_code', 'templates.form_json as json',
            //'template_departments.name as template_department_name',
            'template_hazard.vessel_info_id as vessel_info_id', 'template_hazard.hazard_list_id', 'template_hazard.hazards', 'template_hazard.consequences', 'template_hazard.remarks', 'template_hazard.hazardEvent', 'template_hazard.source', 'template_hazard.lkh1', 'template_hazard.svr1', 'template_hazard.rf1', 'template_hazard.control_measure', 'template_hazard.lkh2', 'template_hazard.svr2', 'template_hazard.rf2', 'template_hazard.acFlag', 'template_hazard.add_control', 'template_hazard.additional_control', 'template_hazard.additional_control_type', 'hazard_master_lists.id as hazard_category_id', 'hazard_master_lists.hazard_no as hazard_master_list_name', 'hazard_lists.id as hazard_list_id', 'hazard_lists.code as hazard_lists_code', 'hazard_lists.name as hazard_lists_name')
                ->where('templates.template_id', $d->template_id)
                ->get();
            // dd($templateData);
            $risk_matrices    = risk_matrix::all();
            $department       = department::all();
            $location         = location::all();
            $ranks            = rank::all();
            $verifiedRanks    = $ranks;
            $reviewRanks      = reviewRanks::all();
            $fleet            = fleet::all();
            $vessel           = vessel::all();
            $filledHazards    = hazard_list::select('hazard_lists.id', 'hazard_lists.code', 'hazard_lists.name')->get();

            $vessel_fleet     = vessel::join('fleets', 'vessels.fleet_id', '=', 'fleets.id')->select('vessels.id as id', 'vessels.fleet_id as fleet_id', 'vessels.code as code', 'vessels.name as name', 'fleets.name as fltname')
                ->get();
            $var              = template_details::where('template_details.id', $templateData[0]->vessel_info_id)
                ->select('template_details.*')
                ->orderBy('template_details.created_at', 'desc')
                ->first();
            //dd($var);
            // Session::flash('status',1);
            $signature        = signature::where('signature.form_id', $var['id'])->pluck(

            'signature.url', 'signature.signature');
            return view('risk_assessment_create')
                ->with(['tempHeaders' => null, 'form_title' => $form_title, 'templateId' => null, 'VesselInfoId' => null, 'department' => $department, 'location' => $location, 'ranks' => $ranks, 'fleet' => $fleet, 'vessels' => $vessel, 'verifiedRanks' => $verifiedRanks, 'reviewRanks' => $reviewRanks, 'vessel_fleet' => $vessel_fleet, 'risk_matrices' => $risk_matrices, 'riskMatriceColor' => $riskMatriceColor, 'riskFactor' => $riskFactor, 'filledHazards' => $filledHazards, 'templateData' => $templateData, 'risk_assessment_data' => $var, 'templateName' => null, 'signature' => $signature, 'type' => 'temp_use']);
        }
        catch(Exception $e)
        {
            report($e);
        }
    }

    public function getNewFormId(Request $request)
    {
        try
        {
            $newId         = 1;

            $selectedCode  = $request->selectedCode;

            $formIdPresent = Template::where('template_code', $selectedCode)->orderBy('ref', 'desc')
                ->get();

            if ($formIdPresent->count())
            {
                $newId         = ($formIdPresent[0]->ref) + 1;
            }

            return $newId;
        }
        catch(Exception $e)
        {
            report($e);
        }
    }
    // function for dynamic form
    public function getForm(Request $r)
    {

    }
    public function getTempId($role)
    {
        if ($role == 'admin')
        {
            $p       = DB::table('templates')->orderBy('created_at', 'DESC')
                ->pluck('template_id')
                ->first();
        }
        else
        {
            $p       = DB::table('risk_assesment')->orderBy('created_at', 'DESC')
                ->pluck('template_id')
                ->first();
        }
        // dd($p);
        if ($p == null)
        {
            $temp_id = 'temp_1';
        }
        else
        {
            $arr     = explode('_', $p);
            $num     = (int)$arr[1];
            $next    = $num + 1;
            $temp_id = 'temp_' . $next;
        }
        return $temp_id;
    }
    public function getTemplate($request)
    {
        // dd($request->all());
        $tempB18                     = null;
        $section_1_id                = $request->input('section_1_id');
        $section_2_id                = $request->input('section_2_id');
        $is_template                 = $request->input('is_template');
        $template_name               = $request->input('template_name');

        $section_2_array             = json_decode($request->section_2_array);
        $additional_control          = json_decode($request->additional_control);
        $template_name               = $request->input('template_name');

        //dd('Admin');
        if (!$template_name)
        {
            // dd('No template name');
            $prevTemplateName            = Template::select('id')->orderBy('id', 'desc')
                ->first();
            if ($prevTemplateName)
            {
                $template_name               = 'Template_' . (($prevTemplateName->id) + 1);
            }
            else
            {
                $template_name               = 'Template_1';
            }
        }
        // dd('Yes Template name');
        $temp_id                     = $this->getTempId('admin');
        // dd($temp_id);
        $tempTemplate                = new Template;
        $tempTemplate->name          = $template_name;
        $tempTemplate->template_code = $request->template_dept;
        $tempTemplate->ref           = $request->template_dept_id;
        $tempTemplate->template_id   = $temp_id;
        $tempTemplate->form_json     = $request->form_temp;
        $tempTemplate->save();
        // dd('Done');
        $result                  = new template_details();
        // $Vessel_detailsController = new Vessel_detailsController;
        // $ship = $Vessel_detailsController->getVesselId();
        $ship                    = (new GenericController)->getCreatorId();
        if ($ship !== false)
        {
            $shipPrefix              = $ship->prefix;
            $creator                 = $ship->id;
        }
        else
        {
            $shipPrefix              = '';
            $creator                 = '';
        }
        $RiskAss                 = DB::table('template_details')->where('creator_id', $ship->id)
            ->orderBy('id', 'DESC')
            ->first();
        if ($RiskAss !== null)
        {
            $lastID                  = explode("-", $RiskAss->id);
            // dd($lastID);
            $prevInc                 = (int)$lastID[2];
            $inc                     = $prevInc + 1;
        }
        else
        {
            $inc                     = 1;
        }
        $id                      = $shipPrefix . '-riskassesment-' . (string)$inc;
        $result->id              = $id;
        $forb18                  = $id;
        // $result->id = $request->input('id');
        $result->dept_id         = $request->input('dept-id');
        $result->created_by      = Auth::user()->id;
        $result->creator_id      = $creator;
        $result->status          = 'Not Approved';

        $result->template_id     = $temp_id;

        // $result->vessel_name = $request->input('vessel_name');
        $result->vessel_id       = $request->input('vessel_id');
        if ($request->input('review-date'))

        $result->review_date     = date('Y-m-d', strtotime($request->input('review-date')));
        $result->weather         = $request->input('weather');
        $result->voyage          = $request->input('voyage');
        $result->location        = $request->input('location');
        $result->tide            = $request->input('tide');
        $result->work_activity   = $request->input('work_activity');
        $result->work_area       = $request->input('work_area');
        $result->visibility      = $request->input('visibility');
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
        if ($request->input('jha_date')) $result->jha_date        = date('Y-m-d', strtotime($request->input('jha_date')));
        $result->last_assessment = $request->last_assessment;
        // $result->alternate_method = $request->alternate_method;(not required)
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
        // dd('After');
        // if ($request->master_sign)
        // {
        //     self::image_uploader($request->master_sign, config('constants.signatureFolders.MASTER') , $result->id);
        // }
        // if ($request->ch_off_sign)
        // {
        //     self::image_uploader($request->ch_off_sign, config('constants.signatureFolders.CHIEF_ENG') , $result->id);
        // }
        // if ($request->ch_eng_sign)
        // {
        //     self::image_uploader($request->ch_eng_sign, config('constants.signatureFolders.CHIEF_OFF') , $result->id);
        // }
        // if ($request->eng2_sign)
        // {
        //     self::image_uploader($request->eng2_sign, config('constants.signatureFolders.SECOND_ENGG') , $result->id);
        // }
        // if ($request->sm_sign)
        // {
        //     self::image_uploader($request->sm_sign, config('constants.signatureFolders.SM') , $result->id);
        // }
        // if ($request->dgm_sign)
        // {
        //     self::image_uploader($request->dgm_sign, config('constants.signatureFolders.DGM') , $result->id);
        // }
        // if ($request->gm_sign)
        // {
        //     self::image_uploader($request->gm_sign, config('constants.signatureFolders.GM') , $result->id);
        // }
        if ($section_2_array)
        {
            foreach ($section_2_array as $section_2_value)
            {
                $tempB18                          = new template_hazard;
                // $ship = $Vessel_detailsController->getVesselId();
                $ship                             = (new GenericController)->getCreatorId();
                if ($ship !== false)
                {
                    $shipPrefix                       = $ship->prefix;
                    $creator                          = $ship->id;
                }
                else
                {
                    $shipPrefix                       = '';
                    $creator                          = '';
                }
                $RiskAss                          = DB::table('template_hazard')->where('vessel_info_id', $result->id)
                    ->orderBy('id', 'DESC')
                    ->first();
                if ($RiskAss !== null)
                {
                    $lastID                           = explode("-", $RiskAss->id);
                    // dd($lastID);
                    $prevInc                          = (int)$lastID[3];
                    $inc                              = $prevInc + 1;
                }
                else
                {
                    $inc                              = 1;
                }
                $id                               = $shipPrefix . '-riskassesment-B18template-' . (string)$inc;

                $tempB18->id                      = $id;
                $tempB18->is_template             = $is_template;
                // $tempB18->template_id = $tempTemplate->id;
                $tempB18->template_id             = $temp_id;
                $tempB18->vessel_info_id          = $forb18;
                $tempB18->hazard_list_id          = $section_2_value->hazardTypeId;
                $tempB18->hazards                 = $section_2_value->hazardSubTypeId;
                $tempB18->hazardEvent             = $section_2_value->hazardEvent;
                $tempB18->source                  = $section_2_value->source;
                $tempB18->acFlag                  = $section_2_value->acFlag;
                $tempB18->consequences            = $section_2_value->consequences;
                $tempB18->lkh1                    = $section_2_value->lkh1;
                $tempB18->svr1                    = $section_2_value->svr1;
                $tempB18->rf1                     = $section_2_value->rf1;
                $tempB18->control_measure         = $section_2_value->control_measure;
                $tempB18->lkh2                    = $section_2_value->lkh2;
                $tempB18->svr2                    = $section_2_value->svr2;
                $tempB18->rf2                     = $section_2_value->rf2;
                $tempB18->add_control             = $section_2_value->add_control;
                $tempB18->created_by              = Auth::user()->id;
                if ($additional_control)
                {
                    foreach ($additional_control as $ac_value)
                    {
                        if ($section_2_value->section2RowCount == $ac_value->acRowCount)
                        {
                            $tempB18->additional_control      = $ac_value->additional_control;
                            $tempB18->additional_control_type = $ac_value->additional_control_type;
                        }
                    }
                }
                $tempB18->save();
            }
        }
    }
    public function editTemplate($request)
    {
        $tempB18                 = null;
        $section_1_id            = $request->input('section_1_id');
        $section_2_id            = $request->input('section_2_id');
        $is_template             = $request->input('is_template');
        $template_name           = $request->input('template_name');

        $section_2_array         = json_decode($request->section_2_array);

        $additional_control      = json_decode($request->additional_control);
        $tempTemplate            = Template::find($section_2_id);
        if ($template_name)
        {
            // dd('template name present',
            //     $request->form_temp
            // );
            $tempTemplate->name      = $template_name;
            $tempTemplate->form_json = $request->form_temp;
        }
        $tempTemplate->save();

        if ($section_2_array)
        {
            // dd('absent');
            $deleteArray          = [];
            $b18TemplatesToDelete = [];
            $section1Id           = '';
            $b18TemplatesToDelete = template_hazard::where('template_id', $tempTemplate->template_id)
                ->get();
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
            template_hazard::destroy($deleteArray);

            foreach ($section_2_array as $section_2_value)
            {
                $tempB18                  = new template_hazard;

                $tempB18->is_template     = $is_template;
                $tempB18->template_id     = $tempTemplate->id;
                $tempB18->vessel_info_id  = $section1Id;
                $tempB18->hazard_list_id  = $section_2_value->hazardTypeId;
                $tempB18->hazards         = $section_2_value->hazardSubTypeId;
                $tempB18->hazardEvent     = $section_2_value->hazardEvent;
                $tempB18->source          = $section_2_value->source;
                $tempB18->acFlag          = $section_2_value->acFlag;
                $tempB18->consequences    = $section_2_value->consequences;
                $tempB18->lkh1            = $section_2_value->lkh1;
                $tempB18->svr1            = $section_2_value->svr1;
                $tempB18->rf1             = $section_2_value->rf1;
                $tempB18->control_measure = $section_2_value->control_measure;
                $tempB18->lkh2            = $section_2_value->lkh2;
                $tempB18->svr2            = $section_2_value->svr2;
                $tempB18->rf2             = $section_2_value->rf2;
                $tempB18->add_control     = $section_2_value->add_control;
                $tempB18->created_by      = Auth::user()->id;

                if (isset($additional_control) && $additional_control)
                {

                    foreach ($additional_control as $ac_value)
                    {
                        info('Test ' . print_r($ac_value, true));
                        if ($section_2_value->section2RowCount == $ac_value->acRowCount)
                        {
                            // $tempB18->additional_control = $ac_value->additional_control;
                            // $tempB18->additional_control_type = $ac_value->additional_control_type;

                        }
                    }
                }
                $tempB18->save();

            }

            $result                     = template_details::find($section1Id);

            $result->dept_id            = $request->input('dept-id');

            $result->created_by         = Auth::user()->id;
            // $result->vessel_name = $request->input('vessel_name');
            $result->vessel_id          = $request->input('vessel_id');
            if ($request->input('review-date')) $result->review_date        = date('Y-m-d', strtotime($request->input('review-date')));
            $result->weather            = $request->input('weather');
            $result->voyage             = $request->input('voyage');
            $result->location           = $request->input('location');
            $result->tide               = $request->input('tide');
            $result->work_activity      = $request->input('work_activity');
            $result->work_area          = $request->input('work_area');
            $result->visibility         = $request->input('visibility');
            $result->master_name        = $request->input('master_name');
            if ($request->input('master_date')) $result->master_date        = date('Y-m-d', strtotime($request->input('master_date')));
            $result->ch_off_name        = $request->input('ch_off_name');
            if ($request->input('ch_off_date')) $result->ch_off_date        = date('Y-m-d', strtotime($request->input('ch_off_date')));
            $result->ch_eng_name        = $request->input('ch_eng_name');
            if ($request->input('ch_eng_date')) $result->ch_eng_date        = date('Y-m-d', strtotime($request->input('ch_eng_date')));
            $result->eng2_name          = $request->input('eng2_name');
            if ($request->input('eng2_date')) $result->eng2_date          = date('Y-m-d', strtotime($request->input('eng2_date')));
            $result->sm_name            = $request->input('sm_name');
            if ($request->input('sm_date')) $result->sm_date            = date('Y-m-d', strtotime($request->input('sm_date')));
            $result->dgm_activity_type  = $request->input('dgm_activity_type');
            $result->dgm_name           = $request->input('dgm_name');
            if ($request->input('dgm_date')) $result->dgm_date           = date('Y-m-d', strtotime($request->input('dgm_date')));
            $result->name_rank          = $request->input('name_rank');
            $result->gm_activity_type   = $request->input('gm_activity_type');
            $result->gm_name            = $request->input('gm_name');
            if ($request->input('gm_date')) $result->gm_date            = date('Y-m-d', strtotime($request->input('gm_date')));
            if ($request->input('jha_date')) $result->jha_date           = date('Y-m-d', strtotime($request->input('jha_date')));
            $result->last_assessment    = $request->last_assessment;
            $result->alternate_method   = $request->alternate_method;
            $result->hazard_discussed   = $request->hazard_discussed;
            if ($request->input('jha_start')) $result->jha_start          = date('Y-m-d', strtotime($request->input('jha_start')));
            if ($request->input('jha_end')) $result->jha_end            = date('Y-m-d', strtotime($request->input('jha_end')));
            $result->unassessed_hazards = $request->unassessed_hazards;
            $result->comments           = $request->comments;
            $result->port_authorities   = $request->port_authorities;
            $result->tools_available    = $request->tools_available;
            $result->lcd_notified       = $request->lcd_notified;
            $result->remarks            = $request->remarks;

            $result->save();

            if ($request->master_sign)
            {
                self::image_uploader($request->master_sign, config('constants.signatureFolders.MASTER') , $result->id);
            }

            if ($request->ch_off_sign)
            {
                self::image_uploader($request->ch_off_sign, config('constants.signatureFolders.CHIEF_ENG') , $result->id);
            }

            if ($request->ch_eng_sign)
            {
                self::image_uploader($request->ch_eng_sign, config('constants.signatureFolders.CHIEF_OFF') , $result->id);
            }

            if ($request->eng2_sign)
            {
                self::image_uploader($request->eng2_sign, config('constants.signatureFolders.SECOND_ENGG') , $result->id);
            }

            if ($request->sm_sign)
            {
                self::image_uploader($request->sm_sign, config('constants.signatureFolders.SM') , $result->id);
            }

            if ($request->dgm_sign)
            {
                self::image_uploader($request->dgm_sign, config('constants.signatureFolders.DGM') , $result->id);
            }

            if ($request->gm_sign)
            {
                self::image_uploader($request->gm_sign, config('constants.signatureFolders.GM') , $result->id);
            }
        }

    }
    public function getUserData($request)
    {
        $tempB18                     = null;
        $section_1_id                = $request->input('section_1_id');
        $section_2_id                = $request->input('section_2_id');
        $is_template                 = $request->input('is_template');
        $template_name               = $request->input('template_name');
        $temp_id                     = $this->getTempId('user');
        // dd($temp_id);
        $tempTemplate                = new risk_assesment;
        $tempTemplate->name          = $template_name;
        $tempTemplate->template_code = $request->template_dept;
        $tempTemplate->ref           = $request->template_dept_id;
        $tempTemplate->template_id   = $temp_id;
        $tempTemplate->form_json     = $request->user_data;
        $tempTemplate->save();
        // dd('Done');
        $result                  = new risk_assesment_details;
        // $Vessel_detailsController = new Vessel_detailsController;
        // $ship = $Vessel_detailsController->getVesselId();
        $ship                    = (new GenericController)->getCreatorId();
        if ($ship !== false)
        {
            $shipPrefix              = $ship->prefix;
            $creator                 = $ship->id;
        }
        else
        {
            $shipPrefix              = '';
            $creator                 = '';
        }
        $RiskAss                 = DB::table('risk_assesment_details')->where('creator_id', $ship->id)
            ->orderBy('id', 'DESC')
            ->first();
        if ($RiskAss !== null)
        {
            $lastID                  = explode("-", $RiskAss->id);

            $prevInc                 = (int)$lastID[3];
            $inc                     = $prevInc + 1;
        }
        else
        {
            $inc                     = 1;
        }
        $id                      = $shipPrefix . '-riskassesment-template-' . (string)$inc;
        // $result->id = $id;
        $result->creator_id      = $creator;
        $result->status          = 'Not Approved';
        $result->id              = $request->input('id');
        $result->vessel_name     = $request->input('vessel_name');
        $result->vessel_id       = $request->input('vessel_id');
        if ($request->input('review-date')) $result->review_date     = date('Y-m-d', strtotime($request->input('review-date')));
        $result->weather         = $request->input('weather');
        $result->voyage          = $request->input('voyage');
        $result->location        = $request->input('location');
        $result->tide            = $request->input('tide');
        $result->work_activity   = $request->input('work_activity');
        $result->work_area       = $request->input('work_area');
        $result->visibility      = $request->input('visibility');
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
        if ($request->input('jha_date')) $result->jha_date        = date('Y-m-d', strtotime($request->input('jha_date')));
        $result->last_assessment = $request->last_assessment;
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

        $result->created_by      = Auth::user()->id;
        $result->template_id     = $temp_id;
        $result->save();
        // dd('done');
        // if ($request->master_sign)
        // {
        //     self::image_uploader($request->master_sign, config('constants.signatureFolders.MASTER') , $result->id);
        // }
        // if ($request->ch_off_sign)
        // {
        //     self::image_uploader($request->ch_off_sign, config('constants.signatureFolders.CHIEF_ENG') , $result->id);
        // }
        // if ($request->ch_eng_sign)
        // {
        //     self::image_uploader($request->ch_eng_sign, config('constants.signatureFolders.CHIEF_OFF') , $result->id);
        // }
        // if ($request->eng2_sign)
        // {
        //     self::image_uploader($request->eng2_sign, config('constants.signatureFolders.SECOND_ENGG') , $result->id);
        // }
        // if ($request->sm_sign)
        // {
        //     self::image_uploader($request->sm_sign, config('constants.signatureFolders.SM') , $result->id);
        // }
        // if ($request->dgm_sign)
        // {
        //     self::image_uploader($request->dgm_sign, config('constants.signatureFolders.DGM') , $result->id);
        // }
        // if ($request->gm_sign)
        // {
        //     self::image_uploader($request->gm_sign, config('constants.signatureFolders.GM') , $result->id);
        // }
        if ($section_2_array)
        {
            foreach ($section_2_array as $section_2_value)
            {
                $tempB18                          = new risk_assesment_hazard;

                $tempB18->is_template             = $is_template;
                $tempB18->template_id             = $tempTemplate->id;
                $tempB18->vessel_info_id          = $result->id;
                $tempB18->hazard_list_id          = $section_2_value->hazardTypeId;
                $tempB18->hazards                 = $section_2_value->hazardSubTypeId;
                $tempB18->hazardEvent             = $section_2_value->hazardEvent;
                $tempB18->source                  = $section_2_value->source;
                $tempB18->acFlag                  = $section_2_value->acFlag;
                $tempB18->consequences            = $section_2_value->consequences;
                $tempB18->lkh1                    = $section_2_value->lkh1;
                $tempB18->svr1                    = $section_2_value->svr1;
                $tempB18->rf1                     = $section_2_value->rf1;
                $tempB18->control_measure         = $section_2_value->control_measure;
                $tempB18->lkh2                    = $section_2_value->lkh2;
                $tempB18->svr2                    = $section_2_value->svr2;
                $tempB18->rf2                     = $section_2_value->rf2;
                $tempB18->add_control             = $section_2_value->add_control;
                $tempB18->created_by              = Auth::user()->id;
                $tempB18->template_id             = $temp_id;
                if ($additional_control)
                {
                    foreach ($additional_control as $ac_value)
                    {
                        if ($section_2_value->section2RowCount == $ac_value->acRowCount)
                        {
                            $tempB18->additional_control      = $ac_value->additional_control;
                            $tempB18->additional_control_type = $ac_value->additional_control_type;
                        }
                    }
                }
                $tempB18->save();
                // dd('Done');

            }
        }
    }

}

