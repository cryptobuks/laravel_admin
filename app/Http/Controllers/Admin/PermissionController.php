<?php

namespace App\Http\Controllers\Admin;

use App\Model\Admin\Permission;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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
}
