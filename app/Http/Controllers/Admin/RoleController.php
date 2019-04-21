<?php

namespace App\Http\Controllers\Admin;

use App\Model\Admin\Permission;
use App\Model\Admin\Role;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class RoleController extends Controller
{
    public function index(){
        $lists = Role::all()->toArray();
        $viewData = [
            'lists'     => $lists,
            'page_title'=> '角色列表',
        ];
        return view('admin.role.index')->with($viewData);
    }

    public function create(Request $request){
        if( $request->isMethod('post') ){
            $data = $request->all();
            $rules = [
                'name' => 'required|string|min:2|max:100|unique:roles'
            ];
            $messages = [
                'required'  => ":attribute不能为空",
                'string'    => ":attribute需为字符串",
                'min'       => ":attribute最少:min个字符",
                'max'       => ":attribute最多:max个字符",
                'unique'    => ":attribute已存在"
            ];
            $attributes = [
                'name' => '角色名称'
            ];
            $validator = Validator::make($data, $rules, $messages, $attributes);
            if( $validator->fails() ){
                return response()->json(['status' => 10002, 'message' => $validator->errors()->first()]);
            }
            try{
                Role::create($data);
                return response()->json(['status' => 0, 'message' => "添加成功"]);
            } catch (\Exception $e){
                return response()->json(['status' => 20001, 'message' => $e->getMessage()]);
            }
        }
        return view('admin.role.create');
    }

    public function edit(Request $request){
        $data = $request->all();
        if( $request->isMethod('post') ){
            $rules = [
                'id'    => 'required|not_in:0',
                'name'  => 'required|string|min:2|max:100|unique:roles,name,'.$data['id'],
            ];
            $messages = [
                'required'  => ":attribute不能为空",
                'not_in'    => ":attribute错误",
                'string'    => ":attribute需为字符串",
                'min'       => ":attribute最少:min个字符",
                'max'       => ":attribute最多:max个字符",
                'unique'    => ":attribute已存在"
            ];
            $attributes = [
                'id'    => '角色ID',
                'name'  => '角色名称'
            ];
            $validator = Validator::make($data, $rules, $messages, $attributes);
            if( $validator->fails() ){
                return response()->json(['status' => 10002, 'message' => $validator->errors()->first()]);
            }
            try{
                Role::where('id',$data['id'])->update($data);
                return response()->json(['status' => 0, 'message' => "修改成功"]);
            } catch (\Exception $e){
                return response()->json(['status' => 20001, 'message' => $e->getMessage()]);
            }
        }
        if($data['id'] > 0){
            $data = Role::find($data['id'])->toArray();
        }
        return view('admin.role.edit')->with($data);
    }

    public function set(Request $request){
        $id = $request->input('id');
        $role = Role::find($id);

        $index_perm = Permission::findByMethodAndUri('GET','admin/index');
        if($role->permission->contains($index_perm)){
            $index_perm->value = 1;
        }else{
            $index_perm->value = 0;
        }

        $perms = Permission::getTree();
        $group_values = [];
        foreach ($perms as $group => $sub_perms) {
            $group_value = 1;
            foreach ($sub_perms as &$perm) {
                if($role->permission->contains($perm)){
                    $perm['value'] = 1;
                }else{
                    $perm['value'] = 0;
                    $group_value = 0;
                }
            }
            $group_values[$group] = $group_value;
        }

        $groups = array_keys($perms);
        $groups = json_encode($groups,320);

        $viewData = [
            'page_title'    => '角色"'.$role->name.'"分配权限',
            'perms'         => $perms,
            'role'          => $role,
            'groups'        => $groups,
            'group_values'  => $group_values,
            'index_perm'    => $index_perm
        ];
        return view('admin.role.set', $viewData);

    }

    public function del(Request $request){
        $data = $request->all();
        try{
            Role::destroy($data['id']);
            return response()->json(['status' => 0, 'message' => '删除成功']);
        } catch (\Exception $e){
            return response()->json(['status' => 20001, 'message' => $e->getMessage()]);
        }
    }

}
