<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AccountController extends Controller
{
    public function resetPassword(Request $request){
        if( $request->isMethod('post') ){

        }
        $viewData = [
            'page_title'        => '账户安全',
            'page_description'  => '修改登录密码',
        ];
        return view('admin.account.resetPassword')->with($viewData);
    }
}
