<?php

/**
 * Class and Function List:
 * Function list:
 * - index()
 * - create()
 * - show()
 * - edit()
 * - update()
 * - destroy()
 * - getVesselId()
 * Classes list:
 * - Vessel_detailsController extends Controller
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// we import  DB for using query builder
use Illuminate\Support\Facades\DB;
// start from shore
use App\Models\vessel as Vessel;
use App\Models\VesselDetail;
use App\Models\Company;
use App\Models\fleet as Fleet;
use Session;
// end  from shore

class Vessel_detailsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        try {
            if (session('is_ship')) {
                $data = DB::table('vessels')->leftJoin('vessel_details', 'vessels.unique_id', '=', 'vessel_details.id')
                    ->where('unique_id', session('creator_id'))
                    ->first();

                return view('vessel_details.show_vessel_details', ['vessel_data'        => $data]);
                // i am in ship


            } else {
                // dd('i am in shore');
                $data =  DB::table('vessels')
                    ->leftJoin('vessel_details', 'vessels.unique_id', '=', 'vessel_details.id')
                    ->select('vessels.*')
                    ->get();


                $request->session()->put('vessels', $data);
                //dd(session('vessels')[0]->type);
                if (!empty(session('vessel'))) {
                    $v = session('vessels')[0];
                    // dd($v);
                    $request->session()->put('selected', $v);
                }


                $vessels = DB::table('vessels')->leftJoin('vessel_details', 'vessels.unique_id', '=', 'vessel_details.id')
                    ->get(); // Join VesselDetail table here and send across data to the view
                // dd($vessels);
                return view('vessel_details.all_vessels', ['vessel_data' => $vessels]);
            }
        } catch (Exception $e) {
            Log::console . log($e);
        }
    }

    public function create()
    {
        try {
            if (session('is_ship')) {
                // Showing vessel Details
                // vessel details
                $vessel = DB::table('vessels')->get();
                return view('vessel_details.create_vessel_details', ['ves'                  => $vessel]);
            } else {
                $vessels = Vessel::all();
                $companies = Company::all();
                $fleets = Fleet::all();
                return view('vessel_details.create_vessel_details', ['ves' => $vessels, 'companies' => $companies, 'fleets' => $fleets]);
            }
        } catch (Exception $e) {
            Log::console . log($e);
        }
    }

    public function show(Request $req)
    {
        try {
            if (session('is_ship')) {
                // Save The Vessel Data
                $Name             = $req->Name;
                $Vessel_code      = $req->vessel_code;
                $Class_Society    = $req->Class_Society;
                $IMO_No           = $req->IMO_No;
                $Year_Built       = $req->Year_Built;
                $Type             = $req->Type;
                $Owner            = $req->Owner;
                $Hull_No          = $req->Hull_No;
                $GRT              = $req->GRT;
                $Call_Sign        = $req->Call_Sign;
                $Flag             = $req->Flag;
                $NRT              = $req->NRT;
                $Length           = $req->Length;
                $Port_of_Registry = $req->Port_of_Registry;
                $Breadth          = $req->Breadth;
                $Moulded_Depth    = $req->Moulded_Depth;

                DB::table('vessel_details')
                    ->insert(['name' => $Name, 'vessel_code' => $Vessel_code, 'class_society' => $Class_Society, 'imo_no' => $IMO_No, 'year_built' => $Year_Built, 'type' => $Type, 'owner' => $Owner, 'hull_no' => $Hull_No, 'grt' => $GRT, 'call_sign' => $Call_Sign, 'flag' => $Flag, 'nrt' => $NRT, 'length' => $Length, 'port_of_registry' => $Port_of_Registry, 'breadth' => $Breadth, 'moulded_depth' => $Moulded_Depth,]);

                return redirect(url('/vessel_details'));
            } else {
                // Save The Vessel Data
                $Name = $req->Name;
                $company_id = $req->company_id;
                $Vessel_code = $req->vessel_code;
                $Class_Society = $req->Class_Society;
                $IMO_No = $req->IMO_No;
                $Year_Built = $req->Year_Built;
                $Type = $req->Type;
                $Owner = $req->Owner;
                $Hull_No = $req->Hull_No;
                $GRT = $req->GRT;
                $Call_Sign = $req->Call_Sign;
                $Flag = $req->Flag;
                $NRT = $req->NRT;
                $Length = $req->Length;
                $Port_of_Registry = $req->Port_of_Registry;
                $Breadth = $req->Breadth;
                $Moulded_Depth = $req->Moulded_Depth;
                $fleet = $req->fleet;

                $vasid = Vessel::orderBy('id', 'DESC')->first();

                if ($vasid == null) {
                    $incrementNum = '1';
                } else {
                    // dd($vasid->unique_id);
                    if ($vasid->unique_id == "") {
                        $incrementNum = '1';
                    } else {
                        $incrementNum = (int)explode('_', $vasid->unique_id)[1] + 1;
                    }
                }

                $unique_id = strtolower(mb_substr(str_replace(' ', '', $Name), 0, 5)) . '_' . (string)$incrementNum;
                $prefix = strtolower(mb_substr(str_replace(' ', '', $Name), 0, 5));
                // dd($unique_id);
                Vessel::insert(['name' => $Name, 'company_id' => $company_id, 'unique_id' => $unique_id, 'prefix' => $prefix, 'type' => $Type, 'fleet_id' => $fleet, 'code' => 1]);

                VesselDetail::insert(['id' => $unique_id, 'vessel_code' => $Vessel_code, 'class_society' => $Class_Society, 'imo_no' => $IMO_No, 'year_built' => $Year_Built, 'owner' => $Owner, 'hull_no' => $Hull_No, 'grt' => $GRT, 'call_sign' => $Call_Sign, 'flag' => $Flag, 'nrt' => $NRT, 'length' => $Length, 'port_of_registry' => $Port_of_Registry, 'breadth' => $Breadth, 'moulded_depth' => $Moulded_Depth,]);

                return redirect(url('/vessel_details'));
            }
        } catch (Exception $e) {
            Log::console . log($e);
        }
    }

    public function edit($id)
    {
        // dd('I am in edit');
        try {
            if (session('is_ship')) {
                // dd('ship');
                // edit view
                $data   = DB::table('vessel_details')->find($id);

                $vessel = DB::table('vessels')->get();
                return view('vessel_details.update_vessel_details', ['data'                  => $data, 'ves'                  => $vessel]);
            } else {
                // dd('shore');
                // edit view
                $vessels = Vessel::all();
                $companies = Company::all();
                $fleets = Fleet::all();

                $vessel = Vessel::where('unique_id', $id)->get();
                $vessel_details = VesselDetail::find($id);
                return view('vessel_details.update_vessel_details', ['ves' => $vessels, 'companies' => $companies, 'fleets' => $fleets, 'vessel' => $vessel[0], 'vessel_details' => $vessel_details]);
            }
        } catch (Exception $e) {
            Log::console . log($e);
        }
    }

    public function update(Request $req, $id)
    {
        try {
            if (session('is_ship')) {
                // Update The Vessel Data
                $Name             = $req->Name;
                $Vessel_code      = $req->vessel_code;
                $Class_Society    = $req->Class_Society;
                $IMO_No           = $req->IMO_No;
                $Year_Built       = $req->Year_Built;
                $Type             = $req->Type;
                $Owner            = $req->Owner;
                $Hull_No          = $req->Hull_No;
                $GRT              = $req->GRT;
                $Call_Sign        = $req->Call_Sign;
                $Flag             = $req->Flag;
                $NRT              = $req->NRT;
                $Length           = $req->Length;
                $Port_of_Registry = $req->Port_of_Registry;
                $Breadth          = $req->Breadth;
                $Moulded_Depth    = $req->Moulded_Depth;

                DB::table('vessel_details')
                    ->where('id', $id)->update(['name' => $Name, 'vessel_code' => $Vessel_code, 'class_society' => $Class_Society, 'imo_no' => $IMO_No, 'year_built' => $Year_Built, 'type' => $Type, 'owner' => $Owner, 'hull_no' => $Hull_No, 'grt' => $GRT, 'call_sign' => $Call_Sign, 'flag' => $Flag, 'nrt' => $NRT, 'length' => $Length, 'port_of_registry' => $Port_of_Registry, 'breadth' => $Breadth, 'moulded_depth' => $Moulded_Depth,]);

                return redirect(url('/vessel_details'));
            } else {
                // Update The Vessel Data
                $vid = Vessel::where('unique_id', $id)->get();
                $currentPrefix = explode("_", $vid[0]->unique_id);

                $Name = $req->Name;

                if (mb_substr(str_replace(' ', '', $Name), 0, 5) !== $currentPrefix[0]) {
                    $unique_id = strtolower(mb_substr(str_replace(' ', '', $Name), 0, 5)) . '_' . $currentPrefix[1];
                    $prefix = strtolower(mb_substr(str_replace(' ', '', $Name), 0, 5));
                } else {
                    $unique_id = $id;
                    $prefix = $currentPrefix[0];
                }

                $company_id = $req->company_id;
                $Vessel_code = $req->vessel_code;
                $Class_Society = $req->Class_Society;
                $IMO_No = $req->IMO_No;
                $Year_Built = $req->Year_Built;
                $Type = $req->Type;
                $Owner = $req->Owner;
                $Hull_No = $req->Hull_No;
                $GRT = $req->GRT;
                $Call_Sign = $req->Call_Sign;
                $Flag = $req->Flag;
                $NRT = $req->NRT;
                $Length = $req->Length;
                $Port_of_Registry = $req->Port_of_Registry;
                $Breadth = $req->Breadth;
                $Moulded_Depth = $req->Moulded_Depth;
                $fleet = $req->fleet;

                Vessel::where('unique_id', $id)->update(['name' => $Name, 'company_id' => $company_id, 'unique_id' => $unique_id, 'prefix' => $prefix, 'type' => $Type, 'fleet_id' => $fleet,]);

                VesselDetail::where('id', $id)->update(['id' => $unique_id, 'vessel_code' => $Vessel_code, 'class_society' => $Class_Society, 'imo_no' => $IMO_No, 'year_built' => $Year_Built, 'owner' => $Owner, 'hull_no' => $Hull_No, 'grt' => $GRT, 'call_sign' => $Call_Sign, 'flag' => $Flag, 'nrt' => $NRT, 'length' => $Length, 'port_of_registry' => $Port_of_Registry, 'breadth' => $Breadth, 'moulded_depth' => $Moulded_Depth,]);

                return redirect(url('/vessel_details'));
            }
        } catch (Exception $e) {
            Log::console . log($e);
        }
    }

    public function destroy($id)
    {
        try {
            if (session('is_ship')) {
                //  delete
                DB::table('vessel_details')->where('id', $id)->delete();

                return redirect(url('/vessel_details'));
            } else {
                DB::table('vessels')->where('unique_id', $id)->delete();
                DB::table('vessel_details')->where('id', $id)->delete();

                // $v = vessel::find($id);
                // dd($id);

                return redirect(url('/vessel_details'));
            }
        } catch (Exception $e) {
            Log::console . log($e);
        }
    }

    // helper function
    public function getVesselId()
    {
        try {
            if (session('is_ship')) {
                $vessel = DB::table('vessels')->leftJoin('vessel_details', 'vessels.unique_id', '=', 'vessel_details.id')
                    ->where('unique_id', session('creator_id'))
                    ->get();
                // Join VesselDetail table here and send across data
                // dd($vessel);
                if ($vessel[0] !== null) {
                    // dd($vessel[0]);
                    return $vessel[0];
                } else {
                    return false;
                }
            } else {
                $vessel = DB::table('vessels')->leftJoin('vessel_details', 'vessels.unique_id', '=', 'vessel_details.id')->get();
                // Join VesselDetail table here and send across data
                if ($vessel !== null) {
                    return $vessel[0];
                } else {
                    return false;
                }
            }
        } catch (Exception $e) {
            report($e);
        }
    }
}
