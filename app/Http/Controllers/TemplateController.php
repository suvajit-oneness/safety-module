<?php
/**
* Class and Function List:
* Function list:
* - index()
* - tester()
* - create()
* - store()
* - show()
* - edit()
* - update()
* - destroy()
* - getTempId()
* Classes list:
* - TemplateController extends Controller
*/
namespace App\Http\Controllers;
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
use App\Models\User;

use App\Http\Controllers\Vessel_detailsController;
use App\Http\Controllers\GenericController;
use App\Http\Controllers\JsonController;
use Log;
use Auth;
use Session;
use DB;

use Illuminate\Http\Request;

class TemplateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        // dd('Get it');
        // $templates = Template::join('template_details', 'template_details.template_id', 'templates.template_id');
        // $templates = $templates->get();
        // $templates = $templates->where('is_template', 1)
        // ->select('templates.id', 'templates.name', 'templates.template_code', 'templates.ref','templates.form_json')
        // ->groupBy('templates.id', 'templates.name', 'templates.template_code', 'templates.ref','templates.form_json');
        // $templates = DB::table('templates')
        //             ->leftJoin('template_details',
        //             'template_details.template_id',
        //             '=',
        //             'templates.template_id');
        // $templates = $templates
        //             ->select('templates.*',
        //                      )->get();
        $user = User::find(session('id'));
        if($user->hasPermissionTo('view.template')){
            $templates = DB::table('templates');
            
            if (session('is_ship')) {
                $templates = $templates->where('creator_id', session('creator_id'));
            }
            $templates =  $templates->orderBy('updated_at','DESC')->get();
            // $templates = $templates->leftJoin('template_details',
            //                                     'templates.template_id',
            //                                     '=',
            //                                     'templates.template_id')->get();
            // dd($templates);
            // self::tester();
            return view('template', ['templates'                => $templates]);
        }
        else{
            abort(404);
        }
    }

    public function tester()
    {
        try
        {
            $jsonController = new JsonController;

            //search
            $searchWord     = 'Visible';
            $searchKey      = 'Visibility';
            $tableName      = 'templates';
            $fieldName      = 'form_json';

            // $templates = $jsonController->search($searchWord, $searchKey, $tableName, $fieldName);
            // Log::info('Search Results :: '.print_r($templates,true));
            // extract values to save
            $jsonString     = '[{"type":"text","required":false,"label":"<span style=\"color: rgb(33, 37, 41); font-size: 14.4px;\">Tide</span>","className":"form-control","name":"text-1647257789997-0","access":false,"value":"High","subtype":"text","maxlength":10},{"type":"text","required":false,"label":"Visibility","className":"form-control","name":"text-1647257648039-0","access":false,"value":"Invisible","subtype":"text","maxlength":10},{"type":"text","required":false,"label":"<span style=\"color: rgb(33, 37, 41); font-size: 14.4px;\">Port/Location</span>","className":"form-control","name":"text-1647257750401-0","access":false,"value":"Mumbai","subtype":"text","maxlength":10}]';
            $field          = 'label';

            $fields         = $jsonController->extractFields($field, $jsonString);
            // dd($fields);
            Log::info('Fields Extracted :: ' . print_r($fields, true));
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
        //
        $user = User::find(session('id'));
        if($user->hasPermissionTo('create.template')){
            $department       = department::all();
            $vessel           = vessel::all();

            $riskMatriceColor = risk_matrix::pluck('hex_code', 'code');
            $riskFactor       = risk_matrix::pluck('risk_factor', 'code');
            $filledHazards    = hazard_list::select('hazard_lists.id', 'hazard_lists.code', 'hazard_lists.name')->get();

            return view('templateCreate', ['department' => $department, 'vessels'                             => $vessel, 'riskMatriceColor'                             => $riskMatriceColor, 'riskFactor'                             => $riskFactor, 'filledHazards'                             => $filledHazards]);
            // dd('Get it');
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
        // dd($request->section_2_array);
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
        $jsonString                  = $request->form_temp;
        $field                       = 'label';
        $fields                      = (new jsonController)->extractFields($field, $jsonString);
        $temp_id                     = $this->getTempId();
        // dd($temp_id);
        $tempTemplate                = new Template;
        $tempTemplate->name          = $template_name;
        $tempTemplate->template_code = $request->template_dept;
        $tempTemplate->ref           = $request->template_dept_id;
        $tempTemplate->template_id   = $temp_id;
        $tempTemplate->form_json     = $request->form_temp;
        $tempTemplate->key           = $fields;
        $tempTemplate->creator_id = session('creator_id');
        $tempTemplate->creator_email = session('email');
        $tempTemplate->is_ship = session('is_ship');
        Log::info('Json ' . print_r($request->form_temp));
        // call json controleer extract funciton
        //$tempTemplate->key =
        $tempTemplate->save();
        // dd('Done');
        $result                  = new template_details();

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

       
        $id = (new GenericController)->getUniqueId('template_details',config('constants.UNIQUE_ID_TEXT.TEMPLATE'));
        $result->id              = $id;
        $forb18                  = $id;
        // $result->id = $request->input('id');
        // dd('id',
        // $id);
        $result->dept_id         = $request->input('dept-id');
        // $result->created_by = Auth::user()->id;
        // $result->created_by = 'mrysh_1';
        $result->creator_id      = session('creator_id');
        // $result->creator_id = 'mrysh__1';
        $result->status          = config('constants.status.Not_approved');

        $result->template_id     = $temp_id;

        // $result->vessel_name = $request->input('vessel_name');
        // $result->vessel_id       = $request->input('vessel_id');
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
        $result->save();
        Log::info('Section 2 id :' . print_r($result->id, true));
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
                $tempB18->is_template             = $is_template;
                // $tempB18->template_id = $tempTemplate->id;
                $tempB18->template_id             = $temp_id;
                // Log::info('ID '.print_r($forb18,true));
                $tempB18->vessel_info_id          = $forb18;
                $tempB18->hazard_list_id          = $section_2_value->hazardTypeId;
                $tempB18->hazards                 = $section_2_value->hazardSubTypeId;
                
                // ----------------------Added By Onenesstechs------------------------
                $tempB18->hazard_cause                 = $section_2_value->hazardCauseId;
                $tempB18->hazard_details                 = $section_2_value->hazardDetailsId;
                // -------------------------------------------------------------------

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
        return redirect('/template');

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

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // dd($id);
        $user = User::find(session('id'));
        if($user->hasPermissionTo('edit.template')){
            $department       = department::all();
            $vessel           = vessel::all();
            $template         = DB::table('templates')->where('templates.template_id', $id);
            $template         = $template->leftJoin('template_details', 'template_details.template_id', '=', 'templates.template_id')
                ->select('template_details.*', 'templates.id as idd', 'templates.name as name as name', 'templates.form_json as form_json')
                ->get();
            // $vessel_name      = vessel::find($template[0]->vessel_id);
            $dept_name        = department::find($template[0]->dept_id);
            $riskMatriceColor = risk_matrix::pluck('hex_code', 'code');
            $riskFactor       = risk_matrix::pluck('risk_factor', 'code');
            $filledHazards    = hazard_list::select('hazard_lists.id', 'hazard_lists.code', 'hazard_lists.name')->get();
            // dd($template[0]);
            $templateData = Template::leftJoin('template_hazard', 'template_hazard.template_id', 'templates.template_id')->leftJoin('template_departments', 'template_departments.code', 'templates.template_code')
                ->leftJoin('hazard_lists', 'hazard_lists.id', 'template_hazard.hazard_list_id')
                ->leftJoin('hazard_master_lists', 'hazard_master_lists.id', 'template_hazard.hazards')
                ->select('templates.name as template_name', 'templates.ref as template_ref', 'templates.template_code as template_code', 'templates.form_json as json', 'template_departments.name as template_department_name', 'template_hazard.vessel_info_id as vessel_info_id', 'template_hazard.hazard_list_id', 'template_hazard.hazards', 'template_hazard.hazard_cause', 'template_hazard.hazard_details', 'template_hazard.consequences', 'template_hazard.remarks', 'template_hazard.hazardEvent', 'template_hazard.source', 'template_hazard.lkh1', 'template_hazard.svr1', 'template_hazard.rf1', 'template_hazard.control_measure', 'template_hazard.lkh2', 'template_hazard.svr2', 'template_hazard.rf2', 'template_hazard.add_control', 'template_hazard.acFlag', 'template_hazard.additional_control', 'template_hazard.additional_control_type',

            'hazard_master_lists.id as hazard_category_id', 'hazard_master_lists.hazard_no as hazard_master_list_name', 'hazard_lists.id as hazard_list_id', 'hazard_lists.code as hazard_lists_code', 'hazard_lists.name as hazard_lists_name')
                ->where('templates.template_id', 'like', $id)->get();

            return view('templateEdit', ['template'                         => $template, 'department'                         => $department, 'vessels'                         => $vessel,  'dept_name'                         => $dept_name, 'riskMatriceColor'                         => $riskMatriceColor, 'riskFactor'                         => $riskFactor, 'filledHazards'                         => $filledHazards, 'templateData'                         => $templateData]);
            //
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
        // dd($request->form_temp);
        $template                = Template::where('template_id', $id)->first();
        // dd($template->name);
        $template->name          = $request->template_name;
        $template->template_code = $request->template_dept;
        $template->ref           = $request->template_dept_id;
        $template->form_json     = $request->form_temp;
        $template->save();

        $template_details                  = template_details::where('template_id', $id)->first();
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
        if ($request->input('jha_date')) $template_details->jha_date        = date('Y-m-d', strtotime($request->input('jha_date')));
        $template_details->last_assessment = $request->last_assessment;
        $template_details->save();

        $section_2_array      = json_decode($request->section_2_array);
        $additional_control   = json_decode($request->additional_control);
        if ($section_2_array)
        {
            // dd('absent');
            $deleteArray          = [];
            $b18TemplatesToDelete = [];
            //Log::info('b18 template id : '.print_r($tempTemplate->id,true));
            $section1Id           = '';
            $b18TemplatesToDelete = template_hazard::where('template_id', $id)->get();
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
            // dd('Deletion done');
            foreach ($section_2_array as $section_2_value)
            {
                $tempB18                  = new template_hazard;

                // $tempB18->is_template = $is_template;
                $tempB18->template_id     = $id;
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
                        LOG::info('Test ' . print_r($ac_value, true));
                        if ($section_2_value->section2RowCount == $ac_value->acRowCount)
                        {
                            // $tempB18->additional_control = $ac_value->additional_control;
                            // $tempB18->additional_control_type = $ac_value->additional_control_type;

                        }
                    }
                }
                // LOG::info('Test '.print_r($ac_value,true));
                $tempB18->save();

            }

            //    dd('All done');



        }
        return redirect('/template');
        //

    }

    //function for geting duplicate template data
    
    public function getDuplicate($id)
    {
        // dd('get duplicate');
        $user = User::find(session('id'));
        if($user->hasPermissionTo('create.template')){
            $department       = department::all();
            $vessel           = vessel::all();
            $template         = DB::table('templates')->where('templates.template_id', $id);
            $template         = $template->leftJoin('template_details', 'template_details.template_id', '=', 'templates.template_id')
                ->select('template_details.*', 'templates.id as idd', 'templates.name as name as name', 'templates.form_json as form_json')
                ->get();
            // $vessel_name      = vessel::find($template[0]->vessel_id);
            $dept_name        = department::find($template[0]->dept_id);
            $riskMatriceColor = risk_matrix::pluck('hex_code', 'code');
            $riskFactor       = risk_matrix::pluck('risk_factor', 'code');
            $filledHazards    = hazard_list::select('hazard_lists.id', 'hazard_lists.code', 'hazard_lists.name')->get();
            // dd($template[0]);
            $templateData     = Template::leftJoin('template_hazard', 'template_hazard.template_id', 'templates.template_id')->leftJoin('template_departments', 'template_departments.code', 'templates.template_code')
                ->leftJoin('hazard_lists', 'hazard_lists.id', 'template_hazard.hazard_list_id')
                ->leftJoin('hazard_master_lists', 'hazard_master_lists.id', 'template_hazard.hazards')
                ->select(
                    'templates.name as template_name',
                    'templates.ref as template_ref',
                    'templates.template_code as template_code',
                    'templates.form_json as json',
                    'template_departments.name as template_department_name',
                    'template_hazard.vessel_info_id as vessel_info_id',
                    'template_hazard.hazard_list_id',
                    'template_hazard.hazards',
                    'template_hazard.consequences',
                    'template_hazard.remarks',
                    'template_hazard.hazardEvent',
                    'template_hazard.source',
                    'template_hazard.lkh1',
                    'template_hazard.svr1',
                    'template_hazard.rf1',
                    'template_hazard.control_measure',
                    'template_hazard.lkh2',
                    'template_hazard.svr2',
                    'template_hazard.rf2',
                    'template_hazard.add_control',
                    'template_hazard.acFlag',
                    'template_hazard.additional_control',
                    'template_hazard.additional_control_type',

                    'hazard_master_lists.id as hazard_category_id',
                    'hazard_master_lists.hazard_no as hazard_master_list_name',
                    'hazard_lists.id as hazard_list_id',
                    'hazard_lists.code as hazard_lists_code',
                    'hazard_lists.name as hazard_lists_name'
                )
                ->where('templates.template_id', 'like', $id)->get();

            return view('templateDuplicate', ['template'                         => $template, 'department'                         => $department, 'vessels'                         => $vessel,  'dept_name'                         => $dept_name, 'riskMatriceColor'                         => $riskMatriceColor, 'riskFactor'                         => $riskFactor, 'filledHazards'                         => $filledHazards, 'templateData'                         => $templateData]);
        }
        else{
            abort(404);
        }
    }
    // function that insert the duplicate template
    
    public function putDuplicate(Request $request)
    {
        // dd('putting duplicate');
        $tempB18                     = null;
        $section_1_id                = $request->input('section_1_id');
        $section_2_id                = $request->input('section_2_id');
        $is_template                 = $request->input('is_template');
        $template_name               = $request->input('template_name');

        $section_2_array             = json_decode($request->section_2_array);
        $additional_control          = json_decode($request->additional_control);
        $template_name               = $request->input('template_name');

        //dd('Admin');
        if (!$template_name) {
            // dd('No template name');
            $prevTemplateName            = Template::select('id')->orderBy('id', 'desc')
                ->first();
            if ($prevTemplateName) {
                $template_name               = 'Template_' . (($prevTemplateName->id) + 1);
            } else {
                $template_name               = 'Template_1';
            }
        }
        // dd('Yes Template name');
        $jsonString                  = $request->form_temp;
        $field                       = 'label';
        $fields                      = (new jsonController)->extractFields($field, $jsonString);
        $temp_id                     = $this->getTempId();
        // dd($temp_id);
        $tempTemplate                = new Template;
        $tempTemplate->name          = $template_name;
        $tempTemplate->template_code = $request->template_dept;
        $tempTemplate->ref           = $request->template_dept_id;
        $tempTemplate->template_id   = $temp_id;
        $tempTemplate->form_json     = $request->form_temp;
        $tempTemplate->key           = $fields;
        $tempTemplate->creator_id = session('creator_id');
        $tempTemplate->creator_email = session('email');
        $tempTemplate->is_ship = session('is_ship');
        Log::info('Json ' . print_r($request->form_temp));
        // call json controleer extract funciton
        //$tempTemplate->key =
        $tempTemplate->save();
        // dd('Done');
        $result                  = new template_details();

        $ship                    = (new GenericController)->getCreatorId();
        if ($ship !== false) {
            $shipPrefix              = $ship->prefix;
            $creator                 = $ship->id;
        } else {
            $shipPrefix              = '';
            $creator                 = '';
        }


        $id = (new GenericController)->getUniqueId('template_details', config('constants.UNIQUE_ID_TEXT.TEMPLATE'));
        $result->id              = $id;
        $forb18                  = $id;

        $result->dept_id         = $request->input('dept-id');
        // $result->created_by = Auth::user()->id;
        // $result->created_by = 'mrysh_1';
        $result->creator_id      = session('creator_id');
        // $result->creator_id = 'mrysh__1';
        $result->status          = config('constants.status.Not_approved');

        $result->template_id     = $temp_id;


        if ($request->input('jha_date')) $result->jha_date = date('Y-m-d', strtotime($request->input('jha_date')));
        $result->last_assessment = $request->last_assessment;
        $result->save();
        Log::info('Section 2 id :' . print_r($result->id, true));
        if ($section_2_array) {
            foreach ($section_2_array as $section_2_value) {
                $tempB18                          = new template_hazard;
                // $ship = $Vessel_detailsController->getVesselId();
                $ship                             = (new GenericController)->getCreatorId();
                if ($ship !== false) {
                    $shipPrefix                       = $ship->prefix;
                    $creator                          = $ship->id;
                } else {
                    $shipPrefix                       = '';
                    $creator                          = '';
                }
                $RiskAss                          = DB::table('template_hazard')->where('vessel_info_id', $result->id)
                    ->orderBy('id', 'DESC')
                    ->first();

                $tempB18->is_template             = $is_template;
                // $tempB18->template_id = $tempTemplate->id;
                $tempB18->template_id             = $temp_id;
                // Log::info('ID '.print_r($forb18,true));
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
                // if ($additional_control)
                // {
                //     foreach ($additional_control as $ac_value)
                //     {
                //         if ($section_2_value->section2RowCount == $ac_value->acRowCount)
                //         {
                //             $tempB18->additional_control      = $ac_value->additional_control;
                //             $tempB18->additional_control_type = $ac_value->additional_control_type;
                //         }
                //     }
                // }
                $tempB18->save();
            }
        }
        return redirect('/template');
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
        // dd('hey',
        // $id);
        $user = User::find(session('id'));
        if($user->hasPermissionTo('delete.template')){
        Template::where('template_id', $id)->delete();
        template_details::where('template_id', $id)->delete();
        template_hazard::where('template_id', $id)->delete();
        return redirect('/template');
        }
        else{
            abort(404);
        }

    }
    public function getTempId()
    {
        Log::info('Testt ::' . print_r(session('creator_id', true)));
        $p       = DB::table('templates')->orderBy('created_at', 'DESC')
            ->pluck('template_id')
            ->first();
        // dd($p);
        if ($p == null)
        {
            $temp_id = session('creator_id') . 'template_1';
        }
        else
        {
            $arr     = explode('_', $p);
            $num     = (int)$arr[2];
            $next    = $num + 1;
            // dd($arr,$num,$next);
            $temp_id = session('creator_id') . 'template_' . $next;
        }
        // dd($temp_id);
        return $temp_id;
    }
}


