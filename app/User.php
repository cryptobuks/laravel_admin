<?php

namespace App;

use App\Model\Admin\Permission;
use App\Model\Admin\RolePermission;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'admin_users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'role_id', 'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function getPerms(){
        if($this->id == 1){//超级管理员全部权限
            $perms = Permission::with('menu')->get();
        } else {
            $perms = RolePermission::with(['permission'=>function($query){
                $query->with('menu');
            }])->where('role_id', $this->role_id)->get();
            $newPerms = [];
            foreach ($perms as $key => $value) {
                $newPerms[] = $value->permission;
            }
            $perms = $newPerms;
        }
        return $perms;
    }

}
