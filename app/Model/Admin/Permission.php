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

    public static function getPagePermission(){
        return self::query()->where('uri','like','%index')->orWhere('description','like','%页面')->get();
    }

    //获取admin路由组的路由表
    public static function getTree(){
        $perms = self::query()->get();
        $tree = [];
        foreach($perms as $perm){
            $uri = $perm->uri;
            $uris = explode("/",$uri);
            if($uris[0] == 'admin' ){
                $group = $uris[1]; //routes.php的路由不能随便加,admin路由组后面一段uri是权限组;
                $tree[$group][] = $perm;
            }
        }
        return $tree;
    }

}
