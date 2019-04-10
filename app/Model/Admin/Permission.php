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
    protected $fillable = ['description', 'method', 'name', 'uri'];

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
    protected $visible = ['id', 'description', 'method', 'name', 'uri', 'created_at'];

    public function menu(){
        return $this->belongsTo('\App\Model\Admin\Menu','id','permission_id');
    }

    public static function findByMethodAndUri($method, $uri){
        return self::query()->where('method',$method)->where('uri',$uri)->first();
    }


}
