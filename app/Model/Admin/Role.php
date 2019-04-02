<?php

namespace App\Model\Admin;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name'];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true;

    /**
     * 关联权限表
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function permission()
    {
        return $this->belongsToMany('\App\Model\Admin\Permission');
    }

    /**
     * 关联用户
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function users()
    {
        return $this->hasMany('\App\User','role_id','id');
    }

    /**
     * 查询
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public static function getList(){
        return self::query()->orderBy('id','asc')->paginate(10);
    }

}
