<?php

namespace App\Http\Controllers\Admin;

use App\Model\Admin\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redis;

class OrderController extends Controller
{
    public function index(){
        $lists = Order::query()->orderBy('id','DESC')->get()->toArray();
        $viewData = [
            'lists'     => $lists,
            'page_title'=> '订单列表'
        ];
        return view('admin.order.index')->with($viewData);
    }

    public function remedy($id){
        try{
            $order = Order::query()->where('id',$id)->first()->toArray();
            $order['pay_time'] = date('Y-m-d H:i:s');
            $order['actual_amount'] = $order['amount'];
            $order['fee'] = 0;
            $order['pay_status'] = 1;
            Order::query()->where('id',$order['id'])->update($order);
            self::sendNotice($order);
            return response()->json(['status' => 0, 'message' => "补单成功"]);
        } catch (\Exception $e){
            return response()->json(['status' => 20001, 'message' => $e->getMessage()]);
        }
    }

    public function notice($id){
        try{
            $order = Order::find($id);
            self::sendNotice($order);
            return response()->json(['status' => 0, 'message' => "通知成功"]);
        } catch (\Exception $e){
            return response()->json(['status' => 20001, 'message' => $e->getMessage()]);
        }
    }

    public static function sendNotice($data){
        $noticeData = [
            'merchant_no'   => $data['merchant_no'],
            'sys_order_id'  => $data['pay_no'],
            'order_id'      => $data['order_id'],
            'pay_time'      => $data['pay_time'],
            'pay_type'      => $data['pay_type'],
            'pay_status'    => $data['pay_status'] == 1 ? "00" : "02", //00支付成功 01未支付 02支付处理中
            'amount'        => $data['actual_amount'],
            'notify_url'    => $data['notify_url']
        ];
        Redis::select(8);
        $merchantInfo = Redis::hGet('merchant_info', $data['merchant_no']);
        $merchantInfo = json_decode($merchantInfo,true);
        $noticeData['sign'] = generateSign($noticeData, $merchantInfo['key']);
        $noticeData['attach'] = $data['attach'];
        //如果没收到success,则发五次
        $noticeResult = httpRequest($data['notify_url'], $noticeData, 'POST');
        if( $noticeResult == 'success' ){
            Order::query()->where('id',$data['id'])->update(['notice_status'=>'1']);
        }
    }

}
