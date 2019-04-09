<?php

namespace App\Model\Admin;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['description', 'method', 'name', 'url'];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true;

    public function menu()
    {
        return $this->belongsTo('\App\Model\Admin\Menu','id','permission_id');
    }

    public static function findByMethodAndUrl($method, $url){
        return self::query()->where('method',$method)->where('url',$url)->first();
    }


}
