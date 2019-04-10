<?php

namespace App\Http\Controllers\Admin;

use App\Model\Admin\Menu;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MenuController extends Controller
{
    public function index(){
        $lists = Menu::getTopMenus();
        $viewData = [
            'lists'     => $lists,
            'page_title'=> '菜单列表'
        ];
        return view('admin.menu.index')->with($viewData);
    }

    public function create(Request $request){
        if( $request->isMethod('post') ){
            $data = $request->all();
            $rules = [
                'name'                  => 'required|string|min:3|max:255|unique:admin_users',
                'email'                 => 'required|string|email|max:255',
                'password'              => 'required|string|min:6|confirmed',
                'password_confirmation' => 'required'
            ];
            $messages = [
                'required'  => ":attribute不能为空",
                'unique'    => ":attribute已存在",
                'min'       => ":attribute最少:min个字符",
                'max'       => ":attribute最多:max个字符",
                'email'     => ":attribute格式错误",
                'confirmed' => "确认密码输入错误"
            ];
            $attributes = [
                'name'                  => '用户名',
                'email'                 => '邮箱',
                'password'              => '密码',
                'password_confirmation' => '确认密码'
            ];
            $validator = Validator::make($data, $rules, $messages, $attributes);
            if( $validator->fails() ){
                return response()->json(['status' => 10002, 'message' => $validator->errors()->first()]);
            }
            $data['password'] = bcrypt($data['password']);
            try{
                User::create($data);
                return response()->json(['status' => 0, 'message' => "添加成功"]);
            } catch (\Exception $e){
                return response()->json(['status' => 20001, 'message' => $e->getMessage()]);
            }
        }
        $user = $request->user();
        $data['permissions'] = $user->getMenuPerms();
        $data['top_menus'] = Menu::getTopMenus();
        return view('admin.menu.create')->with($data);
    }

}
