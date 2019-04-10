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

    public function menu()
    {
        return $this->belongsTo('\App\Model\Admin\Menu','id','permission_id');
    }

    public static function findByMethodAndUri($method, $uri){
        return self::query()->where('method',$method)->where('uri',$uri)->first();
    }


}
