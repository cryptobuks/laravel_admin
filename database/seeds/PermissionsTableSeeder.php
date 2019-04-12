<?php

use App\Model\Admin\Permission;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('permissions')->truncate();

        //根据routes配置的路由重构权限表,从路由集中取出所有的route路由项
        $routes = app('routes')->getRoutes();
        $adminRoutes = [];
        foreach ($routes as $route) {
            $methods = $route->methods;
            if( in_array('GET', $methods) ){
                $method = 'GET';
            } elseif ( in_array('POST', $methods) ){
                $method = 'POST';
            } else {
                continue;
            }

            $name = isset($route->action['as']) ? $route->action['as'] : "null";

            $uri = $route->uri;
            $uriArray = explode('/',$uri);

            if( isset($uriArray[0]) && $uriArray[0]=='admin' && count($uriArray)>1 ){
                $adminRoutes[] = $method.'_'.$name.'_'.$uri;
            }
        }

        $constants = config('constants');

        //差集为新加入路由文件中的路由,新路由查询和入库
        foreach ($adminRoutes as $key => $value) {
            $permArray = explode('_', $value);
            $description = isset($constants[$permArray[2]]) ? $constants[$permArray[2]] : "null";
            Permission::create(['description'=>$description, 'method'=>$permArray[0], 'name'=>$permArray[1], 'uri'=>$permArray[2]]);
        }

    }
}
