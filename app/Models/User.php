<?php

namespace App\Models;

use DB;
use Log;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use jeremykenedy\LaravelRoles\Traits\HasRoleAndPermission;

class User extends Authenticatable
{
    use HasRoleAndPermission;
    use Notifiable;
    use SoftDeletes;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true;

    /**
     * The attributes that are not mass assignable.
     *
     * @var array
     */
    protected $guarded = [
        'id',
    ];

    /**
     * The attributes that are hidden.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'activated',
        'token',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'first_name',
        'last_name',
        'email',
        'password',
        'activated',
        'token',
        'signup_ip_address',
        'signup_confirmation_ip_address',
        'signup_sm_ip_address',
        'admin_ip_address',
        'updated_ip_address',
        'deleted_ip_address',
        'unique_id',
        'creator_id',
        'is_ship'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id'                                => 'integer',
        'first_name'                        => 'string',
        'last_name'                         => 'string',
        'email'                             => 'string',
        'password'                          => 'string',
        'activated'                         => 'boolean',
        'token'                             => 'string',
        'signup_ip_address'                 => 'string',
        'signup_confirmation_ip_address'    => 'string',
        'signup_sm_ip_address'              => 'string',
        'admin_ip_address'                  => 'string',
        'updated_ip_address'                => 'string',
        'deleted_ip_address'                => 'string',
        'unique_id'                         => 'string',
        'creator_id'                        => 'string',
        'is_ship'                           => 'boolean',
    ];

    /**
     * Get the socials for the user.
     */
    public function social()
    {
        return $this->hasMany(\App\Models\Social::class);
    }

    /**
     * Get the profile associated with the user.
     */
    public function profile()
    {
        return $this->hasOne(\App\Models\Profile::class);
    }

    /**
     * The profiles that belong to the user.
     */
    public function profiles()
    {
        return $this->belongsToMany(\App\Models\Profile::class)->withTimestamps();
    }

    /**
     * Check if a user has a profile.
     *
     * @param  string  $name
     *
     * @return bool
     */
    public function hasProfile($name)
    {
        foreach ($this->profiles as $profile) {
            if ($profile->name === $name) {
                return true;
            }
        }

        return false;
    }

    /**
     * Add/Attach a profile to a user.
     *
     * @param  Profile $profile
     */
    public function assignProfile(Profile $profile)
    {
        return $this->profiles()->attach($profile);
    }

    /**
     * Remove/Detach a profile to a user.
     *
     * @param  Profile $profile
     */
    public function removeProfile(Profile $profile)
    {
        return $this->profiles()->detach($profile);
    }

    public function getRole()
    {
        try{
            $role=null;

            $role=DB::table('role_user')
                   ->join('roles','roles.id','role_user.role_id')
                   ->where('role_user.user_id',$this->id)
                   ->select('roles.name')
                   ->first();

            if($role)
                return $role->name;
            else
                return $role;
        }
        catch(Exception $e){
            report($e);
        }        
    }

    public function isAdmin(){
        try{
            if($this->getRole()==config('constants.roles.ADMIN_ROLE')){
                return true;
            }
            else{
                return false;
            }
        }
        catch(Exception $e){
            report($e);
        }
        
    }
    public function getRoleId()
    {
        try{
            $role=null;

            $role=DB::table('role_user')
                   ->join('roles','roles.id','role_user.role_id')
                   ->where('role_user.user_id',$this->id)
                   ->select('roles.id')
                   ->first();

            if($role)
                return $role->id;
            else
                return $role;
        }
        catch(Exception $e){
            report($e);
        }        
    }

    public function hasPermissionTo($permissionSlug){
        try{
            $roleId = $this->getRoleId();
            Log::info("Role id  :: ".print_r($roleId,true));
            $permission = DB::table('permissions')
                            ->join('permission_role','permission_role.permission_id','permissions.id')
                            ->join('roles','roles.id','permission_role.role_id')
                            ->where('permissions.slug',$permissionSlug)
                            ->where('roles.id', $roleId)
                            ->select('permissions.id as permission_id')
                            ->get();
            Log::info("Permission :: ".print_r($permission,true));
            if($permission->count() > 0){
                return true;
            }
            else{
                return false;
            }
        }
        catch(Exception $e){
            report($e);
        }
        
    }
}
