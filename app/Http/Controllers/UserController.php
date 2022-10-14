<?php
/**
* Class and Function List:
* Function list:
* - __construct()
* - index()
* - type()
* - Data_sync()
* - StatusReport()
* Classes list:
* - UserController extends Controller
*/
namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Log;

// import models
use App\Models\NearMissModel;
use App\Models\incident_report;
use App\Models\Insepection_And_Audit_Master;
use App\Models\moc_master;
use App\Models\risk_assesment_details;
use App\Models\auditmodel;
use App\Models\inspection_and_audit_forms;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // CALLING DATA-SYNC FUNCTION
        $this->Data_sync();

        $user  = Auth::user();
        $v     = DB::table('vessels')->leftJoin('vessel_details', 'vessels.unique_id', '=', 'vessel_details.id')
            ->get();
        if ($user->isAdmin())
        {

            // Fetch Status Of Master Forms
            $chart = $this->StatusReport();
            return view('pages.admin.home', ['vessels'       => $v, 'chart'       => $chart]);
        }

        // Fetch Status Of Master Forms
        $chart = $this->StatusReport();

        return view('pages.user.home', ['vessels'   => $v, 'chart'   => $chart]);
    }
    public function type(Request $request, $id)
    {
        $v = DB::table('vessels')->find($id);

        $request->session()
            ->put('selected', $v);
        //dd(session()->all());
        //dd(session('type')->type);
        return redirect()->back();
    }

    /*
        DATA-SYNC
    */
    function Data_sync()
    {
        // Log:
        //     info('Sync');
    }

        /*
        fetch status Report
        */
        function StatusReport()
        {
            $data = array();

            // Risk Assesment
            $data['ra_total']      = risk_assesment_details::get()->count();
            $data['ra_not_approved']      = risk_assesment_details::where('status', config('constants.status.Not_approved'))->get()->count();
            $data['ra_submitted']      = risk_assesment_details::where('status', config('constants.status.Submitted'))->get()->count();
            $data['ra_approved']      = risk_assesment_details::where('status', config('constants.status.Approved'))->get()->count();
            $data['ra_draft']      = risk_assesment_details::where('status', config('constants.status.Draft'))->get()->count();
            $data['ra_correction_required']      = risk_assesment_details::where('status', config('constants.status.Correction_required'))->get()->count();

            // Near Miss
            $data['nearmiss_total']      = NearMissModel::get()->count();
            $data['nearmiss_not_approved']      = NearMissModel::where('status', config('constants.status.Not_approved'))->get()->count();
            $data['nearmiss_submitted']      = NearMissModel::where('status', config('constants.status.Submitted'))->get()->count();
            $data['nearmiss_approved']      = NearMissModel::where('status', config('constants.status.Approved'))->get()->count();
            $data['nearmiss_draft']      = NearMissModel::where('status', config('constants.status.Draft'))->get()->count();
            $data['nearmiss_correction_required']      = NearMissModel::where('status', config('constants.status.Correction_required'))->get()->count();

            // Incident
            $data['incident_total']      = incident_report::get()->count();
            $data['incident_not_approved']      = incident_report::where('status', config('constants.status.Not_approved'))->get()->count();
            $data['incident_submitted']      = incident_report::where('status', config('constants.status.Submitted'))->get()->count();
            $data['incident_approved']      = incident_report::where('status', config('constants.status.Approved'))->get()->count();
            $data['incident_draft']      = incident_report::where('status', config('constants.status.Draft'))->get()->count();
            $data['incident_correction_required']      = incident_report::where('status', config('constants.status.Correction_required'))->get()->count();

            // Insoection And Audit
            $data['inspection_and_audit_total']      = Insepection_And_Audit_Master::get()->count();
            $data['inspection_and_audit_not_approved']      = Insepection_And_Audit_Master::where('status', config('constants.status.Not_approved'))->get()->count();
            $data['inspection_and_audit_submitted']      = Insepection_And_Audit_Master::where('status', config('constants.status.Submitted'))->get()->count();
            $data['inspection_and_audit_approved']      = Insepection_And_Audit_Master::where('status', config('constants.status.Approved'))->get()->count();
            $data['inspection_and_audit_draft']      = Insepection_And_Audit_Master::where('status', config('constants.status.Draft'))->get()->count();
            $data['inspection_and_audit_correction_required']      = Insepection_And_Audit_Master::where('status', config('constants.status.Correction_required'))->get()->count();

            // Management Of Change
            $data['moc_total']      = moc_master::get()->count();
            $data['moc_not_approved']      = moc_master::where('status', config('constants.status.Not_approved'))->get()->count();
            $data['moc_submitted']      = moc_master::where('status', config('constants.status.Submitted'))->get()->count();
            $data['moc_approved']      = moc_master::where('status', config('constants.status.Approved'))->get()
                ->count();
            $data['moc_draft']      = moc_master::where('status', config('constants.status.Draft'))->get()->count();
            $data['moc_correction_required']      = moc_master::where('status', config('constants.status.Correction_required'))->get()->count();

            // ISO Files
            $data['iso_total']      = 0;
            $data['iso_not_approved']      = 0;
            $data['iso_submitted']      = 0;
            $data['iso_approved']      = 0;
            $data['iso_draft']      = 0;
            $data['iso_correction_required']      = 0;

            // Right Ship
            $data['rs_total']      = 0;
            $data['rs_not_approved']      = 0;
            $data['rs_submitted']      = 0;
            $data['rs_approved']      = 0;
            $data['rs_draft']      = 0;
            $data['rs_correction_required']      = 0;

            // Audit 30 days Calculation .....
            DB::statement(DB::raw("SET @current_val = DATE_FORMAT(NOW(), '%Y/%m/%d')"));

            $data['audit_last_thirty_day'] = inspection_and_audit_forms::selectRaw('COUNT(*) AS audit_last_thirty_day')->whereRaw('(datediff(inspection_and_audit_forms.due_date, @current_val) >= 0')
                ->whereRaw('datediff(inspection_and_audit_forms.due_date, @current_val) <= 30)')
                ->get()
                ->first()->audit_last_thirty_day;

            $data['audit_after_thirty_day'] = inspection_and_audit_forms::selectRaw('COUNT(*) AS audit_after_thirty_day')->whereRaw('datediff(inspection_and_audit_forms.due_date, @current_val) > 30')
                ->get()
                ->first()->audit_after_thirty_day;

            return $data;
        }

}

