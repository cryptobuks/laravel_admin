<?php

namespace App\Model\Admin;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['pid', 'permission_id', 'group', 'name', 'icon', 'sort'];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true;

    public static function getTopMenus(){
        return self::with('parent_menu')->with('sub_menus')->with('permission')->where('pid',0)->orderBy('sort','asc')->get();
    }

    public function parent_menu(){
        //return $this->hasOne('\App\Model\Menu','id','pid');//ok
        return $this->belongsTo('\App\Model\Admin\Menu','pid','id');
    }

    public function sub_menus(){
        //Relationship method must return an object of type Illuminate\Database\Eloquent\Relations\Relation
        //return $this->belongsTo('\App\Model\Menu','id','pid');//都OK;
        //return $this->hasMany('\App\Model\Menu','pid','id');
        $relation = $this->hasMany('\App\Model\Admin\Menu','pid','id');
        $relation->orderBy('group','asc')->orderBy('sort','asc');//Relation的魔术方法调内置的query对象的相应方法;
        return $relation;
    }

    public function permission(){
        return $this->belongsTo('\App\Model\Admin\Permission','permission_id','id');
    }

    public function isTop(){
        return $this->pid == 0;
    }

}
