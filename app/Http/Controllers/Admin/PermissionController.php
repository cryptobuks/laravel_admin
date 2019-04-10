<?php

namespace App\Http\Controllers\Admin;

use App\Model\Admin\Permission;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Validator;

class PermissionController extends Controller
{
    public function index(){
        $lists = Permission::all()->toArray();
        $viewData = [
            'lists'     => $lists,
            'page_title'=> '权限列表'
        ];
        return view('admin.permission.index')->with($viewData);
    }

    public function clear(){
        try{
            Redis::del('routes'); //删除整个hash表
            return response()->json(['status' => 0, 'message' => "操作成功"]);
        } catch (\Exception $e){
            return response()->json(['status' => 20001, 'message' => $e->getMessage()]);
        }
    }

    public function restore(){
        try{
            Redis::del('routes'); //删表前清缓存否则无法重置
            DB::table('permissions')->truncate();
            return response()->json(['status' => 0, 'message' => "操作成功"]);
        } catch (\Exception $e){
            return response()->json(['status' => 20001, 'message' => $e->getMessage()]);
        }
    }

    public function edit(Request $request){
        $data = $request->all();
        if( $request->isMethod('post') ){
            $rules = [
                'id'          => 'required|not_in:0',
                'description' => 'required|string|min:2|max:150|unique:permissions,description,'.$data['id'],
                'name'        => 'required|string|min:3|max:150|unique:permissions,name,'.$data['id'],
                'uri'         => 'required|string|min:3|max:150|unique:permissions,uri,'.$data['id'],
            ];
            $messages = [
                'required'  => ":attribute不能为空",
                'not_in'    => ":attribute错误",
                'unique'    => ":attribute已存在",
                'min'       => ":attribute最少:min个字符",
                'max'       => ":attribute最多:max个字符"
            ];
            $attributes = [
                'id'          => '权限ID',
                'description' => '名称',
                'name'        => '命名',
                'uri'         => 'URI'
            ];
            $validator = Validator::make($data, $rules, $messages, $attributes);
            if( $validator->fails() ){
                return response()->json(['status' => 10002, 'message' => $validator->errors()->first()]);
            }
            try{
                Permission::where('id',$data['id'])->update($data);
                return response()->json(['status' => 0, 'message' => "修改成功"]);
            } catch (\Exception $e){
                return response()->json(['status' => 20001, 'message' => $e->getMessage()]);
            }
        }
        if($data['id'] > 0){
            $permission = Permission::find($data['id']);
            $data['description'] = $permission->description;
            $data['name'] = $permission->name;
            $data['uri'] = $permission->uri;
        }
        return view('admin.permission.edit')->with($data);
    }

    public function del(Request $request){
        $data = $request->all();
        try{
            Permission::destroy($data['id']);
            return response()->json(['status' => 0, 'message' => '删除成功']);
        } catch (\Exception $e){
            return response()->json(['status' => 20001, 'message' => $e->getMessage()]);
        }
    }

}
