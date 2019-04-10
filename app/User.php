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
        $user = $this->toArray();
        if($user['id'] == 1){
            //超级管理员全部权限
            $permissions = Permission::with('menu')->get();
        } else {
            $permissions = RolePermission::with(['permission'=>function($query){
                $query->with('menu');
            }])->where('role_id', $user['role_id'])->get();
            $newPerms = [];
            foreach ($permissions as $key => $value) {
                $newPerms[] = $value->permission;
            }
            $permissions = $newPerms;
        }
        return $permissions;
    }

}
