<?php

namespace App\Model\Admin;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
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
    protected $fillable = ['role_id', 'name', 'email', 'password'];

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true;

    /**
     * The attributes that should be visible in serialization.
     *
     * @var array
     */
    protected $visible = ['id', 'role_id', 'name', 'email', 'created_at'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    public static function getList(){
        return self::with('roles')->orderBy('id','desc')->paginate(10);
    }

    public function roles(){
        //hasOne和BelongsTo是两种关系对象,虽然在最终的sql相同,但是hasOne没有dissociate这个方法,BelongsTo有
        //return $this->hasOne('App\Model\Admin\Role','id','role_id');
        return $this->BelongsTo('App\Model\Admin\Role','role_id','id');
    }

}
