<?php
/**
* Class and Function List:
* Function list:
* - __construct()
* - index()
* - create()
* - store()
* - show()
* - edit()
* - generateId()
* - update()
* - destroy()
* - search()
* - uploadExcel()
* - extCheck()
* Classes list:
* - UsersManagementController extends Controller
*/
namespace App\Http\Controllers;

use App\Models\Profile;
use App\Models\User;
use App\Traits\CaptureIpTrait;
use Illuminate\Support\Facades\DB;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use jeremykenedy\LaravelRoles\Models\Role;
use Validator;
// start new
use App\Imports\UserImport;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Validators\ValidationException;
use Maatwebsite\Excel\HeadingRowImport;
// end new
use App\Http\Controllers\GenericController;

class UsersManagementController extends Controller
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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $creator = DB::table('vessels')->pluck('unique_id')->first();
        // dd($creator);
        // dd('Hey');
        $user = User::find(session('id'));
        if($user->hasPermissionTo('view.users')){
            $paginationEnabled = config('usersmanagement.enablePagination');
            if ($paginationEnabled)
            {
                if(session('is_ship')){
                    $users             = User::where('creator_id', session('creator_id'))->paginate(config('usersmanagement.paginateListSize'));
                }
                else{
                    $users             = User::paginate(config('usersmanagement.paginateListSize'));
                }
            }
            else
            {
                if(session('is_ship')){
                    $users             = User::where('creator_id', session('creator_id'))->all();
                }
                else{
                    $users  = User::all();
                }
            }
            $roles             = Role::all();

            return View('usersmanagement.show-users', compact('users', 'roles'));
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
    public function create()
    { 
        // dd("Hey");
        $user = User::find(session('id'));
        if($user->hasPermissionTo('create.users')){
            $roles = Role::all();

            // $id = $this->generateId();
            // dd($id);
            return view('usersmanagement.create-user', compact('roles'));
        }
        else{
            abort(404);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validator = Validator::make($request->all() , ['name' => 'required|max:255|unique:users|alpha_dash', 'first_name' => 'alpha_dash', 'last_name' => 'alpha_dash', 'email' => 'required|email|max:255|unique:users', 'password' => 'required|min:6|max:20|confirmed', 'password_confirmation' => 'required|same:password', 'role' => 'required', ], ['name.unique' => trans('auth.userNameTaken') , 'name.required' => trans('auth.userNameRequired') , 'first_name.required' => trans('auth.fNameRequired') , 'last_name.required' => trans('auth.lNameRequired') , 'email.required' => trans('auth.emailRequired') , 'email.email' => trans('auth.emailInvalid') , 'password.required' => trans('auth.passwordRequired') , 'password.min' => trans('auth.PasswordMin') , 'password.max' => trans('auth.PasswordMax') , 'role.required' => trans('auth.roleRequired') , ]);

        if ($validator->fails())
        {
            return back()
                ->withErrors($validator)->withInput();
        }

        $ipAddress = new CaptureIpTrait();
        $profile   = new Profile();
        $id        = $this->generateId();
        // if(session('is_ship')==1){
        // $creator = DB::table('vessels')->pluck('unique_id')->first();
        // }
        // else{
        //     $creator = DB::table('comppany')->pluck('unique_id')->first();
        // }
        $creator   = (new GenericController)->getCreatorId();

        // dd($creator->id);
        $user      = User::create([

        'name' => strip_tags($request->input('name')) , 'first_name' => strip_tags($request->input('first_name')) , 'last_name' => strip_tags($request->input('last_name')) , 'email' => $request->input('email') , 'password' => Hash::make($request->input('password')) , 'token' => str_random(64) , 'admin_ip_address' => $ipAddress->getClientIp() , 'activated' => 1, 'unique_id' => $id, 'creator_id' => $creator->id, 'is_ship' => session('is_ship') ,

        ]);

        $user->profile()
            ->save($profile);
        $user->attachRole($request->input('role'));
        $user->save();

        return redirect('users')
            ->with('success', trans('usersmanagement.createSuccess'));
    }

    /**
     * Display the specified resource.
     *
     * @param User $user
     *
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return view('usersmanagement.show-user', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param User $user
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        // dd('Hey edit');
        $roles       = Role::all();

        foreach ($user->roles as $userRole)
        {
            $currentRole = $userRole;
        }

        $data        = ['user' => $user, 'roles' => $roles, 'currentRole' => $currentRole, ];

        return view('usersmanagement.edit-user')->with($data);
    }
    // Function that create unique id
    public function generateId()
    {
        $prefix = DB::table('vessels')->pluck('prefix')
            ->first();
        $last   = DB::table('users')->pluck('unique_id')
            ->last();
        if (empty($last))
        {
            $unique = $prefix . '_user_1';
        }
        else
        {
            $arr    = explode('_', $last);
            $i      = $arr[2];
            $i      = (int)$i + 1;;

            $unique = $prefix . '_user_' . $i;
        }

        return $unique;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param User                     $user
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $emailCheck = ($request->input('email') !== '') && ($request->input('email') !== $user->email);
        $ipAddress  = new CaptureIpTrait();

        if ($emailCheck)
        {
            $validator  = Validator::make($request->all() , ['name'            => 'required|max:255|unique:users|alpha_dash', 'email'            => 'email|max:255|unique:users', 'first_name'            => 'alpha_dash', 'last_name'            => 'alpha_dash', 'password'            => 'present|confirmed|min:6', ]);
        }
        else
        {
            $validator  = Validator::make($request->all() , ['name' => 'required|max:255|alpha_dash|unique:users,name,' . $user->id, 'first_name' => 'alpha_dash', 'last_name' => 'alpha_dash', 'password' => 'nullable|confirmed|min:6', ]);
        }

        if ($validator->fails())
        {
            return back()
                ->withErrors($validator)->withInput();
        }

        $user->name       = strip_tags($request->input('name'));
        $user->first_name = strip_tags($request->input('first_name'));
        $user->last_name  = strip_tags($request->input('last_name'));

        if ($emailCheck)
        {
            $user->email      = $request->input('email');
        }

        if ($request->input('password') !== null)
        {
            $user->password   = Hash::make($request->input('password'));
        }

        $userRole         = $request->input('role');
        if ($userRole !== null)
        {
            $user->detachAllRoles();
            $user->attachRole($userRole);
        }

        $user->updated_ip_address = $ipAddress->getClientIp();

        switch ($userRole)
        {
            case 3:
                $user->activated          = 0;
            break;

            default:
                $user->activated = 1;
            break;
        }

        $user->save();

        return back()
            ->with('success', trans('usersmanagement.updateSuccess'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param User $user
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $currentUser              = Auth::user();
        $ipAddress                = new CaptureIpTrait();

        if ($user->id !== $currentUser->id)
        {
            $user->deleted_ip_address = $ipAddress->getClientIp();
            $user->save();
            $user->delete();

            return redirect('users')
                ->with('success', trans('usersmanagement.deleteSuccess'));
        }

        return back()
            ->with('error', trans('usersmanagement.deleteSelfError'));
    }

    /**
     * Method to search the users.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        $searchTerm     = $request->input('user_search_box');
        $searchRules    = ['user_search_box'                => 'required|string|max:255', ];
        $searchMessages = ['user_search_box.required'                => 'Search term is required', 'user_search_box.string'                => 'Search term has invalid characters', 'user_search_box.max'                => 'Search term has too many characters - 255 allowed', ];

        $validator      = Validator::make($request->all() , $searchRules, $searchMessages);

        if ($validator->fails())
        {
            return response()
                ->json([json_encode($validator) , ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $results = User::where('id', 'like', $searchTerm . '%')->orWhere('name', 'like', $searchTerm . '%')->orWhere('email', 'like', $searchTerm . '%')->get();

        // Attach roles to results
        foreach ($results as $result)
        {
            $roles   = ['roles' => $result->roles, ];
            $result->push($roles);
        }

        return response()->json([json_encode($results) , ], Response::HTTP_OK);
    }

    // upload Excel
    public function uploadExcel(Request $r)
    {
        $file     = $r->file('file');
        // dd($file);
        $e        = $r->file('file')
            ->getClientOriginalExtension();
        // dd($e);
        $headings = (new HeadingRowImport)->toArray($file);
        $heading  = $headings[0][0];
        // dd($heading);
        if ($this->extCheck($e))
        {

            if (in_array('name', $heading) && in_array('first_name', $heading) && in_array('last_name', $heading) && in_array('email', $heading) && in_array('password', $heading) && in_array('role', $heading) && in_array('nationality', $heading) && in_array('sex', $heading) && in_array('date_of_birth', $heading) && in_array('place_of_birth', $heading))
            {
                $import   = new UserImport;
                $import->import($file);
                if ($import->failures()
                    ->isNotEmpty())
                {
                    // dd($import->failures());
                    return back()
                        ->withFailures($import->failures());
                }

                // dd($import->failures());
                return back()
                    ->withStatus('Excel file imported successfully');
            }
            else
            {
                return back()
                    ->with('error', 'All the attributes required i.e. name,first_name,last_name,email,password,role,nationality,sex,date_of_birth,place_of_birth,seaman_passport_pp_no,seaman_book_cdc_no,seaman_passport_expiry,date_and_port_of_embarkation_date,date_and_port_of_embarkation_port');
            }
        }
        else
        {
            return back()
                ->withStatus('Given file is not an excel file');
        }
    }
    // Helper function for extention checking
    public function extCheck($ext)
    {

        if ($ext == 'xlsx' || $ext == 'csv' || $ext == 'xls')
        {
            return true;
        }
        else
        {
            false;
        }
    }
}

