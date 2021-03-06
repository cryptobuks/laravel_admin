<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class IndexController extends Controller
{
    public function index(){
        $viewData = [
            'page_title'        => '首页',
            'page_description'  => '今日数据统计',
        ];
        return view('admin.index.main')->with($viewData);
    }
}
