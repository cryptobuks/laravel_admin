<?php

namespace App\Model\Admin;

use Illuminate\Database\Eloquent\Model;

class Channel extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['pid', 'title', 'name', 'pay_type', 'info', 'sort', 'status'];

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
    protected $visible = ['id', 'pid', 'title', 'name', 'pay_type', 'info', 'sort', 'status'];

    public static function getTopChannels(){
        return self::with('child_channel')->where('pid',0)->orderBy('sort','desc')->get();
    }

    public function child_channel(){
        $relation = $this->hasMany('\App\Model\Admin\Channel','pid','id');
        $relation->orderBy('sort','asc');
        return $relation;
    }

}
