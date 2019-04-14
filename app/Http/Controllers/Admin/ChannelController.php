<?php

namespace App\Http\Controllers\Admin;

use App\Model\Admin\Channel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ChannelController extends Controller
{
    public function index(){
        $lists = Channel::all()->toArray();
        $viewData = [
            'lists'             => $lists,
            'page_title'        => '支付列表',
            'page_description'  => '第三方支付渠道'
        ];
        return view('admin.channel.index')->with($viewData);
    }

}
