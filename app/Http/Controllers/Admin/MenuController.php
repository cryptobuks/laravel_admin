<?php

namespace App\Http\Controllers\Admin;

use App\Model\Admin\Menu;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

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
        $data = $request->all();
        if( $request->isMethod('post') ){
            $data['permission_id'] = $data['pid'] > 0 ? $data['permission_id'] : 0;
            if( $data['permission_id'] > 0 ){
                $data['group'] = Menu::query()->where('id',$data['pid'])->pluck('group')->first();
            }
            $rules = [
                'pid'       => 'required',
                'name'      => 'required|string|min:2|max:20|unique:menus',
                'group'     => 'required|string|min:2|max:20',
                'sort'      => 'required|integer|min:-100|max:2000'
            ];
            $messages = [
                'required'  => ":attribute不能为空",
                'unique'    => ":attribute已存在",
                'string'    => ":attribute需为字符串",
                'min'       => ":attribute最少:min个字符",
                'max'       => ":attribute最多:max个字符",
                'integer'   => ":attribute需为整数",
                'sort.max'  => ":attribute不能大于:max",
                'sort.min'  => ":attribute不能小于:min"
            ];
            $attributes = [
                'pid'   => '父菜单',
                'name'  => '菜单名称',
                'group' => '分组标志',
                'sort'  => '排序号'
            ];
            $validator = Validator::make($data, $rules, $messages, $attributes);
            if( $validator->fails() ){
                return response()->json(['status' => 10002, 'message' => $validator->errors()->first()]);
            }
            $data['icon'] = 'fa-circle-o';
            try{
                Menu::create($data);
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

    public function edit(Request $request){
        $data = $request->all();
        $menu = Menu::find($data['id']);
        if( $request->isMethod('post') ){
            $data['permission_id'] = $data['pid'] > 0 ? $data['permission_id'] : 0;
            if( $data['permission_id'] > 0 ){
                $data['group'] = Menu::query()->where('id',$data['pid'])->pluck('group')->first();
            }
            $rules = [
                'pid'       => 'required',
                'name'      => 'required|string|min:2|max:20|unique:menus,name,'.$data['id'],
                'group'     => 'required|string|min:2|max:20',
                'sort'      => 'required|integer|min:-100|max:2000'
            ];
            $messages = [
                'required'  => ":attribute不能为空",
                'unique'    => ":attribute已存在",
                'string'    => ":attribute需为字符串",
                'min'       => ":attribute最少:min个字符",
                'max'       => ":attribute最多:max个字符",
                'integer'   => ":attribute需为整数",
                'sort.max'  => ":attribute不能大于:max",
                'sort.min'  => ":attribute不能小于:min"
            ];
            $attributes = [
                'pid'   => '父菜单',
                'name'  => '菜单名称',
                'group' => '分组标志',
                'sort'  => '排序号'
            ];
            $validator = Validator::make($data, $rules, $messages, $attributes);
            if( $validator->fails() ){
                return response()->json(['status' => 10002, 'message' => $validator->errors()->first()]);
            }
            $data['icon'] = 'fa-circle-o';
            try{
                Menu::query()->where('id',$data['id'])->update($data);
                if( $data['pid'] == 0 && $data['group'] != $menu->group ){
                    Menu::query()->where('pid',$data['id'])->update(['group'=>$data['group']]);
                }
                return response()->json(['status' => 0, 'message' => "修改成功"]);
            } catch (\Exception $e){
                return response()->json(['status' => 20001, 'message' => $e->getMessage()]);
            }
        }
        $data = $menu->toArray();
        $user = $request->user();
        $data['permissions'] = $user->getMenuPerms();
        $data['top_menus'] = Menu::getTopMenus();
        return view('admin.menu.create')->with($data);
    }

}
