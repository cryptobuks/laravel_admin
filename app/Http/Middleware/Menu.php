<?php

namespace App\Http\Middleware;

use Closure;

class Menu
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        //获取用户权限列表
        $user = $request->user();
        $perms = $user->getPerms();

        //检查用户是否具有访问权限
        $callback = $request->getRouteResolver();
        $router = $callback();//当前路由

        $auth = false;
        $current_perm = '';
        foreach ($perms as $perm) {
            if( in_array($perm->method, $router->methods()) && $perm->url == $router->uri()){
                $auth = true;
                $current_perm = $perm;
                break;
            }
        }
        if(!$auth){
            //return response()->json(['stauts'=>'403,对不起，您无权访问该页面！','message'=>''],403);
            abort(403,'对不起，您无权访问该页面！');
        }

        //获取菜单列表
        $top_menus = \App\Model\Admin\Menu::getTopMenus();
        $top_menus = $top_menus->toArray();
        $menus = array();
        foreach ($top_menus as $value) {
            $menus[$value['group']] = $value;
            foreach ($perms as $perm) {
                //子菜单的group属性为空
                if($perm->menu && $perm->menu->pid>0 && $perm->menu->pid == $value['id']){
                    $menus[$value['group']]['sub_menu'][] = ['name'=>$perm->menu['name'],'icon'=>$perm->menu['icon'],'link'=>'/'.$perm->url,'sort'=>$perm->menu['sort']];
                }
            }
        }

        foreach ($menus as $key => $value) {
            if(empty($menus[$key]['sub_menu'])){
                unset($menus[$key]);
            }else{
                $menus[$key]['sub_menu'] = multisort($menus[$key]['sub_menu'],'sort');
            }
        }

        //菜单列表，当前请求URL
        view()->share('menu_list', $menus);
        $path = $request->path();
        view()->share('request_path', '/'.$path);

        //当前组名,当前菜单名
        if($current_perm->menu){
            $menu_group = $current_perm->menu->parent_menu->group;
            $menu_group_name = admin_group_tag($menu_group);
            $menu_name = $current_perm->menu->name;

        }else{
            $menu_group = '';
            $menu_group_name = '';
            $menu_name = '';
        }

        $route = explode('/', $router->uri());
        if(count($route)>2){
            $current_route = $route[1];
        }else{
            $current_route = array_pop($route);
        }

        view()->share('current_route',$current_route);
        view()->share('menu_group', $menu_group);
        view()->share('menu_group_name', $menu_group_name);
        view()->share('menu_name', $menu_name);


        return $next($request);

    }
}
