<?php

namespace App\Http\Controllers\Admin;

use App\Model\Admin\Merchant;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class MerchantController extends Controller
{
    public function list(){
        $lists = Merchant::all()->toArray();
        $viewData = [
            'lists'     => $lists,
            'page_title'=> '商户列表',
        ];
        return view('admin.merchant.list')->with($viewData);
    }

    public function create(Request $request){
        if( $request->isMethod('post') ){
            $data = $request->all();
            $rules = [
                'merchant_no'       => 'required|string|min:6|max:255|unique:merchants',
                'name'              => 'required|string|min:3|max:255|unique:merchants',
                'password'          => 'required|string|min:8|max:255',
                'security_password' => 'required|string|min:8|max:255'
            ];
            $messages = [
                'required'  => ":attribute不能为空",
                'unique'    => ":attribute已存在",
                'min'       => ":attribute最少:min个字符",
                'max'       => ":attribute最多:max个字符"
            ];
            $attributes = [
                'merchant_no'       => '商户号',
                'name'              => '登录名',
                'password'          => '登录密码',
                'security_password' => '资金密码'
            ];
            $validator = Validator::make($data, $rules, $messages, $attributes);
            if( $validator->fails() ){
                return response()->json(['status' => 10002, 'message' => $validator->errors()->first()]);
            }
            $data['salt'] = Str::random(6);
            $data['password'] = md5($data['password'] . $data['salt']);
            $data['security_password'] = md5($data['security_password'] . $data['salt']);
            $data['key'] = md5(time() . $data['salt']);
            $data['status'] = 1; //默认开启
            try{
                Merchant::create($data);
                return response()->json(['status' => 0, 'message' => "添加成功"]);
            } catch (\Exception $e){
                return response()->json(['status' => 20001, 'message' => $e->getMessage()]);
            }
        }
        return view('admin.merchant.create');
    }

    public function changePassword(Request $request){
        if( $request->isMethod('post') ){
            $user = $request->user();
            $data = $request->all();
            if(!Hash::check($data['oldPassword'], $user->password)){
                return response()->json(['status' => 10001, 'message' => "旧密码错误"]);
            }
            $rules = [
                'oldPassword'               => 'required|string|min:6',
                'newPassword'               => 'required|different:oldPassword|between:6,20|confirmed',
                'newPassword_confirmation'  => 'required'
            ];
            $messages = [
                'required'  => ":attribute不能为空",
                'between'   => ":attribute只能6到20位",
                'different' => "新密码不能与旧密码相同",
                'confirmed' => "新密码与确认密码不匹配"
            ];
            $attributes = [
                'oldPassword'               => '旧密码',
                'newPassword'               => '新密码',
                'newPassword_confirmation'  => '确认密码'
            ];
            $validator = Validator::make($data, $rules, $messages, $attributes);
            if( $validator->fails() ){
                return response()->json(['status' => 10002, 'message' => $validator->errors()->first()]);
            }
            $user->password = bcrypt($data['newPassword']);
            $user->save();
            Auth::logout();
            return response()->json(['status' => 0, 'message' => "修改成功,请重新登录"]);
        }
        $viewData = [
            'page_title'        => '账户安全',
            'page_description'  => '修改当前账户登录密码',
        ];
        return view('admin.account.changePassword')->with($viewData);
    }

    public function edit(Request $request){
        $data = $request->all();
        if( $request->isMethod('post') ){
            $rules = [
                'id'    => 'required|not_in:0',
                'name'  => 'required|string|min:3|max:255|unique:admin_users,name,'.$data['id'],
                'email' => 'required|string|email|max:255',
            ];
            $messages = [
                'required'  => ":attribute不能为空",
                'not_in'    => ":attribute错误",
                'unique'    => ":attribute已存在",
                'min'       => ":attribute最少:min个字符",
                'max'       => ":attribute最多:max个字符",
                'email'     => ":attribute格式错误",
            ];
            $attributes = [
                'id'    => '用户ID',
                'name'  => '用户名',
                'email' => '邮箱',
            ];
            $validator = Validator::make($data, $rules, $messages, $attributes);
            if( $validator->fails() ){
                return response()->json(['status' => 10002, 'message' => $validator->errors()->first()]);
            }
            try{
                User::where('id',$data['id'])->update($data);
                return response()->json(['status' => 0, 'message' => "修改成功"]);
            } catch (\Exception $e){
                return response()->json(['status' => 20001, 'message' => $e->getMessage()]);
            }
        }
        if($data['id'] > 0){
            $account = User::find($data['id']);
            $data['name'] = $account->name;
            $data['email'] = $account->email;
        }
        return view('admin.account.edit')->with($data);
    }

    public function reset(Request $request){
        $data = $request->all();
        if( $request->isMethod('post') ){
            $rules = [
                'id'                    => 'required|not_in:0',
                'password'              => 'required|string|min:6|confirmed',
                'password_confirmation' => 'required'
            ];
            $messages = [
                'required'  => ":attribute不能为空",
                'not_in'    => ":attribute错误",
                'min'       => ":attribute最少:min个字符",
                'confirmed' => "确认密码输入错误"
            ];
            $attributes = [
                'id'                    => '用户ID',
                'password'              => '密码',
                'password_confirmation' => '确认密码'
            ];
            $validator = Validator::make($data, $rules, $messages, $attributes);
            if( $validator->fails() ){
                return response()->json(['status' => 10002, 'message' => $validator->errors()->first()]);
            }
            try{
                User::where('id',$data['id'])->update(['password'=>bcrypt($data['password'])]);
                return response()->json(['status' => 0, 'message' => "重置密码成功"]);
            } catch (\Exception $e){
                return response()->json(['status' => 20001, 'message' => $e->getMessage()]);
            }
        }
        return view('admin.account.reset')->with($data);
    }

    public function del(Request $request){
        $data = $request->all();
        try{
            User::destroy($data['id']);
            return response()->json(['status' => 0, 'message' => '删除成功']);
        } catch (\Exception $e){
            return response()->json(['status' => 20001, 'message' => $e->getMessage()]);
        }
    }
}
