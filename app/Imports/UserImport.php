<?php

namespace App\Imports;

use App\Models\User;
use App\Traits\CaptureIpTrait;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToModel;

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
// use App\Imports\Failure;

class UserImport implements 
    ToModel, 
    WithHeadingRow, 
    SkipsOnError, 
    withValidation,
    SkipsOnFailure,
    WithBatchInserts
    // ToCollection
{
    use Importable, SkipsErrors, SkipsFailures;
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        // dd($row);

        $role=DB::table('roles')->where('name',$row['role'])->get();
        if($row['password'] == ''){
            $password = Hash::make($row['email']);
        }
        else{
            $password = Hash::make($row['password']);
        }
        // dd($test);
        if($role[0] != NULL){        
            $creator = (new GenericController)->getCreatorId();
            // dd(session('is_ship'));
            $ipAddress = new CaptureIpTrait();
            $user =  new User([
                'name' => $row['name'],
                'first_name' => $row['first_name'],
                'last_name' => $row['last_name'],
                'email' => $row['email'],
                'password' =>$password,
                'token' => str_random(64) ,
                'admin_ip_address' => $ipAddress->getClientIp(),
                'activated' => 1,
                'unique_id' => (new UsersManagementController)->generateId(),
                'creator_id' => $creator->id,
                'is_ship' => session('is_ship'),

            ]);
            $user->save();
            // $role_id = DB::table('roles')->where('name',$row['r'])
            $user_id = $user->id;
            // dd($user_id);
            // map user and role
            $role_id = $role[0]->id;
            DB::table('role_user')->insert([
                'role_id' => $role_id,
                'user_id' => $user_id 
            ]);
            // $roleId = //check for the role, and if role is present, get the role id, else return flsse

            
            $crew_data[] = array(
                'name' => $row['name'],
                'rank' => $row['role'],
                'nationality' => $row['nationality'],
                'sex'         => $row['sex'],
                'dob'         => $row['date_of_birth'],
                'pob'         => $row['place_of_birth'],
                'seaman_passpoert_pp_no'    => $row['seaman_passport_pp_no'],
                'seaman_book_cdc_no'        => $row['seaman_book_cdc_no'],
                'seaman_book_exp'           => $row['seaman_passport_expiry'],
                'date_and_port_of_embarkation_date' => $row['date_and_port_of_embarkation_date'],
                'date_and_port_of_embarkation_port' => $row['date_and_port_of_embarkation_port'],
                'email' => $row['email']
            );
            DB::table('crew_list')->insert($crew_data);
                // $data[]= array(
                //     'name' => $row[0],
                //     'email' => $row[1],
                //     'password' => Hash::make('password')
                // );
            
            // dd($data);
            // DB::table('user')->insert($data);
            return $user;
        }
    }

    // public function collection(Collection $rows){
    //     dd($rows['name']);
    // }
    public function onError(Throwable $error){
    }
    
    public function rules():array{

        // $role = DB::table('roles')->pluck('name');
        // $data = [];
        // foreach ($role as $key => $r) {
        //     $data[]= $r;
        // }
        // dd($data);
        return[
            '*.email' => ['email','unique:users,email'],
            '*.role' => function($attribute, $value, $onFailure) {
                $role = DB::table('roles')->pluck('name');
                $data = [];
                foreach ($role as $key => $r) {
                    $data[]= $r;
                }
                if (!(in_array($value,$data))) {
                     $onFailure('role not matching');
                    }
                }
        ];
    }

    // public function onFailure(Failure ...$failure){

    // }
    // function that mention number of row will inserted at a time
    public function batchSize(): int
    {
        return 1000;
    }
}
