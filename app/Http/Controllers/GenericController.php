<?php
/**
* Class and Function List:
* Function list:
* - getCreatorId()
* Classes list:
* - GenericController extends Controller
*/
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\GenericController;
use Log;
use Auth;
use Session;
use DB;

class GenericController extends Controller
{
    public function getCreatorId()
    {
        if (session('is_ship') == 1)
        {
            // dd(True);
            $creator_id = (new Vessel_detailsController)->getVesselId();
            // dd($creator_id);
            return $creator_id;

        }
        else
        {
            $creator_id = (new CompanyController)->getCurrentCompanyId();
            // dd($creator_id);
            return $creator_id;
        }
        // return session('creator_id');

    }

    public function getUniqueId($tablename,$stringname){
        try{
            // add a field auto_inc in the table
            // get the highest auto_inc bit according to creator_id
            // 1, 2, 3
            // abc_moc_1 ... abc_moc_10 = 
            // abc_1+1
            // abc_1 : 1 , def_1 : 1, abc_1 : 2
            // abc_moc_1 , def_moc_1, abc_moc_2
            $data = DB::table("".$tablename."")->where('creator_id',session('creator_id'))->orderBy('auto_inc','DESC')->first();
            // dd($data->id);
            if($data == null){
                $creator = $this->getCreatorId();
                $id = $creator->prefix.'-'.$stringname.'-'.(string)1;
                // dd($id);
            }else{
                $creator = $this->getCreatorId();
                // $next = (int)$data->auto_inc;
                // $next = $next + 1;
                $lastID                        = explode("-", $data->id);
                $prevInc                       = (int)$lastID[2];
                $inc                           = $prevInc + 1;
                $id = $creator->prefix.'-'.$stringname.'-'.(string)$inc;
            }
            // dd($id);
            return $id;
        }
        catch(Exception $e){
            report($e);
        }
    }
}

