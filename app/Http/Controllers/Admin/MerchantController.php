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

    public function resetKey(Request $request){
        if( $request->isMethod('post') ){
            $data = $request->all();
            try{
                if( !$merchant = Merchant::find($data['id']) ){
                    return response()->json(['status' => 10003, 'message' => "商户ID错误"]);
                }
                Merchant::query()->where('id',$data['id'])->update(['key'=>md5(time() . $merchant->salt)]);
                return response()->json(['status' => 0, 'message' => "重置密钥成功"]);
            } catch (\Exception $e){
                return response()->json(['status' => 20001, 'message' => $e->getMessage()]);
            }
        }
    }

    public function resetPassword(Request $request){
        $data = $request->all();
        if( $request->isMethod('post') ){
            $rules = [
                'id'                    => 'required|not_in:0',
                'password'              => 'required|string|min:8|confirmed',
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
                'password'              => '新密码',
                'password_confirmation' => '确认密码'
            ];
            $validator = Validator::make($data, $rules, $messages, $attributes);
            if( $validator->fails() ){
                return response()->json(['status' => 10002, 'message' => $validator->errors()->first()]);
            }
            try{
                if( !$merchant = Merchant::find($data['id']) ){
                    return response()->json(['status' => 10003, 'message' => "商户ID错误"]);
                }
                Merchant::where('id',$data['id'])->update(['password'=>md5($data['password'] . $merchant->salt)]);
                return response()->json(['status' => 0, 'message' => "重置登录密码成功"]);
            } catch (\Exception $e){
                return response()->json(['status' => 20001, 'message' => $e->getMessage()]);
            }
        }
        return view('admin.merchant.password')->with($data);
    }

    public function resetSecurity(Request $request){
        $data = $request->all();
        if( $request->isMethod('post') ){
            $rules = [
                'id'                            => 'required|not_in:0',
                'security_password'             => 'required|string|min:8|confirmed',
                'security_password_confirmation'=> 'required'
            ];
            $messages = [
                'required'  => ":attribute不能为空",
                'not_in'    => ":attribute错误",
                'min'       => ":attribute最少:min个字符",
                'confirmed' => "确认密码输入错误"
            ];
            $attributes = [
                'id'                            => '用户ID',
                'security_password'             => '新密码',
                'security_password_confirmation'=> '确认密码'
            ];
            $validator = Validator::make($data, $rules, $messages, $attributes);
            if( $validator->fails() ){
                return response()->json(['status' => 10002, 'message' => $validator->errors()->first()]);
            }
            try{
                if( !$merchant = Merchant::find($data['id']) ){
                    return response()->json(['status' => 10003, 'message' => "商户ID错误"]);
                }
                Merchant::where('id',$data['id'])->update(['security_password'=>md5($data['security_password'] . $merchant->salt)]);
                return response()->json(['status' => 0, 'message' => "重置资金密码成功"]);
            } catch (\Exception $e){
                return response()->json(['status' => 20001, 'message' => $e->getMessage()]);
            }
        }
        return view('admin.merchant.security')->with($data);
    }

    public function del(Request $request){
        $data = $request->all();
        try{
            Merchant::destroy($data['id']);
            return response()->json(['status' => 0, 'message' => '删除成功']);
        } catch (\Exception $e){
            return response()->json(['status' => 20001, 'message' => $e->getMessage()]);
        }
    }

}
