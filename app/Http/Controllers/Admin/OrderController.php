<?php

namespace App\Http\Controllers\Admin;

use App\Model\Admin\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{
    public function index(){
        $lists = Order::all()->toArray();
        $viewData = [
            'lists'     => $lists,
            'page_title'=> '订单列表'
        ];
        return view('admin.order.index')->with($viewData);
    }
}
