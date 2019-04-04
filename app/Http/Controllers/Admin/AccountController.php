<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AccountController extends Controller
{
    public function getList(Request $request){

    }

    public function resetPassword(Request $request){
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
        return view('admin.account.resetPassword')->with($viewData);
    }
}
