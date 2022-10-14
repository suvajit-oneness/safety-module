<?php

namespace App\Imports;

use App\Models\hazard_master_list;
use Maatwebsite\Excel\Concerns\ToModel;

use App\Traits\CaptureIpTrait;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\Importable;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Validators\Failure;
use App\Http\Controllers\GenericController;
use App\Http\Controllers\UsersManagementController;
use DB;
use Log;
use Throwable; 
use Illuminate\Validation\Rule;

class hazardImport implements 
    ToModel,
    WithHeadingRow 
    // SkipsOnError, 
    // withValidation,
    // SkipsOnFailure,
    // WithBatchInserts
{
    use Importable;
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        // dd($row);
        // return new hazard_master_list([
        //     //
        // ]);
        if($row['hazard_id'] == 1 || $row['hazard_id'] == 2 ){
            // dd('id = 1');
            $tempHazard = new hazard_master_list([  
            
            'hazard_id' => $row['hazard_id'],
            // $tempHazard->ref = $request->input('reference_hidden');
            'vessel_name' => $row['vessel_name'],
            'hazard_no' => $row['hazard_no'],
            'source' => $row['areasource'],
            'hazard_details' => $row['hazard_details'],
            // $tempHazard->causes = ;
            'impact' => $row['impact'],
            'applicable_permits' => $row['applicable_permits'],
            'review' => $row['review_comments'],
            'situation' => $row['situation_routine_r_non_routine_nr'],
            'ir_severity' => $row['ir_severity'],
            'ir_likelihood' => $row['ir_likelihood'],
            'ir_risk_rating' => $row['ir_risk_rating'],
            'control' => $row['control_measures'],
            'rr_severity' => $row['rr_severity'],
            'rr_likelihood' => $row['rr_likelihood'],
            'rr_risk_rating' => $row['rr_risk_rating'],
            ]);
            
            $tempHazard->save();
            return $tempHazard;
        }

        if($row['hazard_id'] == 3){
            // dd('id = 3');
            $tempHazard = new hazard_master_list([  
            
            'hazard_id' => $row['hazard_id'],
            // $tempHazard->ref = $request->input('reference_hidden');
            'vessel_name' => $row['vessel_name'],
            'hazard_no' => $row['hazard_no'],
            'source' => $row['applicable_key_process_area_source'],
            'hazard_details' => $row['hazard_details'],
            'causes' => $row['causes'],
            'impact' => $row['impact'],
            // 'applicable_permits' => $row['applicable_permits'],
            'review' => $row['review_comments'],
            'situation' => $row['situation_routine_r_non_routine_nr'],
            'ir_severity' => $row['ir_severity'],
            'ir_likelihood' => $row['ir_likelihood'],
            'ir_risk_rating' => $row['ir_risk_rating'],
            'control' => $row['control_measures'],
            'rr_severity' => $row['rr_severity'],
            'rr_likelihood' => $row['rr_likelihood'],
            'rr_risk_rating' => $row['rr_risk_rating'],
            ]);
            
            $tempHazard->save();
            return $tempHazard;
        }

        if($row['hazard_id'] == 4){
            // dd('id = 4');
            $tempHazard = new hazard_master_list([  
            
            'hazard_id' => $row['hazard_id'],
            // $tempHazard->ref = $request->input('reference_hidden');
            'vessel_name' => $row['vessel_name'],
            'hazard_no' => $row['hazard_no'],
            'source' => $row['areasource'],
            'life_cycle' => $row['life_cycle'],
            'hazard_details' => $row['hazard_details'],
            // 'causes' => $row['causes'],
            'impact' => $row['impact'],
            'applicable_permits' => $row['applicable_permits'],
            'review' => $row['review_comments'],
            'situation' => $row['situation_routine_r_non_routine_nr'],
            'ir_severity' => $row['ir_severity'],
            'ir_likelihood' => $row['ir_likelihood'],
            'ir_risk_rating' => $row['ir_risk_rating'],
            'control' => $row['control_measures'],
            'rr_severity' => $row['rr_severity'],
            'rr_likelihood' => $row['rr_likelihood'],
            'rr_risk_rating' => $row['rr_risk_rating'],
            ]);
            
            $tempHazard->save();
            return $tempHazard;
        }
        // $tempHazard = new hazard_master_list([  
        //     // dd('id = 2');
        //     // $tempHazard->hazard_id = '2',
        //     // $tempHazard->ref = $request->input('reference_hidden');
        //     $tempHazard->vessel_name = $row['vessel_name'],
        //     $tempHazard->hazard_no = $row['hazard_no'],
        //     $tempHazard->source = $row['areasource'],
        //     $tempHazard->hazard_details = $row['hazard_details'],
        //     // $tempHazard->causes = ;
        //     $tempHazard->impact = $row['impact'],
        //     $tempHazard->applicable_permits = $row['applicable_permits'],
        //     $tempHazard->review = $row['review_comments'],
        //     $tempHazard->situation = $row['situation_routine_r_non_routine_nr'],
        //     $tempHazard->ir_severity = $row['ir_severity'],
        //     $tempHazard->ir_likelihood = $row['ir_likelihood'],
        //     $tempHazard->ir_risk_rating = $row['ir_risk_rating'],
        //     $tempHazard->control = $row['control_measures'],
        //     $tempHazard->rr_severity = $row['rr_severity'],
        //     $tempHazard->rr_likelihood = $row['rr_likelihood'],
        //     $tempHazard->rr_risk_rating = $row['rr_risk_rating'],
        //     ]);
        //     // dd('done');
        //     // $tempHazard->life_cycle = $request->input('life_cycle');
        //     $tempHazard->save();
        //     // dd('done');
        // // if($row['hazard_id'] == 1){
        
        // // }
        // return $tempHazard;
        
    }
    public function batchSize(): int
    {
        return 1000;
    }
}
