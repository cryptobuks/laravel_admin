<?php

namespace App\Http\Controllers\Admin;

use App\Model\Admin\Channel;
use App\Model\Admin\PayType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class ChannelController extends Controller
{
    public function index(){
        $lists = Channel::getTopChannels();
        $viewData = [
            'lists'             => $lists,
            'page_title'        => '支付列表',
            'page_description'  => '第三方支付渠道'
        ];
        return view('admin.channel.index')->with($viewData);
    }

    public function create(Request $request){
        if( $request->isMethod('post') ){
            $data = $request->all();
            if( $data['pid'] == 0 ){
                $data['pay_type'] = "null";
            } else {
                $data['name'] = "null";
            }
            $rules = [
                'pid'       => 'required',
                'title'     => 'required|string|min:2|max:50|unique:channels',
                'name'      => 'required|string|min:2|max:50|unique:channels,name,NULL,id,pid,0',
                'pay_type'  => 'required|string|min:2|max:50',
                'sort'      => 'required|integer|min:-100|max:2000',
                'status'    => 'required'
            ];
            $messages = [
                'required'  => ":attribute不能为空",
                'unique'    => ":attribute已存在",
                'string'    => ":attribute需为字符串",
                'min'       => ":attribute最少:min个字符",
                'max'       => ":attribute最多:max个字符",
                'integer'   => ":attribute需为整数",
                'sort.max'  => ":attribute不能大于:max",
                'sort.min'  => ":attribute不能小于:min"
            ];
            $attributes = [
                'pid'      => '父级',
                'title'    => '渠道名称',
                'name'     => '服务名',
                'pay_type' => '支付类型',
                'sort'     => '排序号',
                'status'   => '状态'
            ];
            $validator = Validator::make($data, $rules, $messages, $attributes);
            if( $validator->fails() ){
                return response()->json(['status' => 10002, 'message' => $validator->errors()->first()]);
            }
            $data['info'] = "null";
            try{
                Channel::create($data);
                return response()->json(['status' => 0, 'message' => "添加成功"]);
            } catch (\Exception $e){
                return response()->json(['status' => 20001, 'message' => $e->getMessage()]);
            }
        }
        $data['topChannels'] = Channel::getTopChannels();
        $data['payTypes'] = PayType::query()->where('status',1)->get()->toArray();
        $data['maxSort'] = Channel::query()->where('pid',0)->max('sort') + 10;
        return view('admin.channel.create_and_edit')->with($data);
    }

    public function edit(Request $request){
        $data = $request->all();
        if( $request->isMethod('post') ){
            if( $data['pid'] == 0 ){
                $data['pay_type'] = "null";
            } else {
                $data['name'] = "null";
            }
            $rules = [
                'pid'       => 'required',
                'title'     => 'required|string|min:2|max:50|unique:channels,title,'.$data['id'],
                'name'      => 'required|string|min:2|max:50|unique:channels,name,'.$data['id'].',id,pid,0',
                'pay_type'  => 'required|string|min:2|max:50',
                'sort'      => 'required|integer|min:-100|max:2000',
                'status'    => 'required'
            ];
            $messages = [
                'required'  => ":attribute不能为空",
                'unique'    => ":attribute已存在",
                'string'    => ":attribute需为字符串",
                'min'       => ":attribute最少:min个字符",
                'max'       => ":attribute最多:max个字符",
                'integer'   => ":attribute需为整数",
                'sort.max'  => ":attribute不能大于:max",
                'sort.min'  => ":attribute不能小于:min"
            ];
            $attributes = [
                'pid'      => '父级',
                'title'    => '渠道名称',
                'name'     => '服务名',
                'pay_type' => '支付类型',
                'sort'     => '排序号',
                'status'   => '状态'
            ];
            $validator = Validator::make($data, $rules, $messages, $attributes);
            if( $validator->fails() ){
                return response()->json(['status' => 10002, 'message' => $validator->errors()->first()]);
            }
            try{
                Channel::query()->where('id',$data['id'])->update($data);
                return response()->json(['status' => 0, 'message' => "修改成功"]);
            } catch (\Exception $e){
                return response()->json(['status' => 20001, 'message' => $e->getMessage()]);
            }
        }
        $data = Channel::find($data['id'])->toArray();
        $data['topChannels'] = Channel::getTopChannels();
        $data['payTypes'] = PayType::query()->where('status',1)->get()->toArray();
        return view('admin.channel.create_and_edit')->with($data);
    }

    public function info(Request $request){
        $data = $request->all();
        if( $request->isMethod('post') ){
            $rules = [
                'id'        => 'required|not_in:0',
                'gateway'   => 'required|string|min:3|max:200',
                'merchant'  => 'required|string|min:2|max:100',
                'key'       => 'required|string|min:2|max:100'
            ];
            $messages = [
                'required'  => ":attribute不能为空",
                'not_in'    => ":attribute错误",
                'string'    => ":attribute需为字符串",
                'min'       => ":attribute最少:min个字符",
                'max'       => ":attribute最多:max个字符"
            ];
            $attributes = [
                'id'        => '支付类型ID',
                'gateway'   => '支付网关',
                'merchant'  => '商户号',
                'key'       => '商户秘钥'
            ];
            $validator = Validator::make($data, $rules, $messages, $attributes);
            if( $validator->fails() ){
                return response()->json(['status' => 10002, 'message' => $validator->errors()->first()]);
            }
            try{
                $channelInfo = $data;
                unset($channelInfo['id']);
                $channelInfo = json_encode($channelInfo,320);
                Channel::query()->where('id',$data['id'])->update(['info'=>$channelInfo]);
                return response()->json(['status' => 0, 'message' => "修改成功"]);
            } catch (\Exception $e){
                return response()->json(['status' => 20001, 'message' => $e->getMessage()]);
            }
        }
        $channelInfo = Channel::query()->where('id',$data['id'])->pluck('info')->first();
        if( $channelInfo != "null" ){
            $data = array_merge($data, json_decode($channelInfo,true));
        }
        return view('admin.channel.info')->with($data);
    }

    public function lock($id, $status){
        try{
            Channel::where('id',$id)->update(['status'=>$status]);
            $message = $status == 1 ? "支付渠道开启成功" : "支付渠道关闭成功";
            return response()->json(['status' => 0, 'message' => $message]);
        } catch (\Exception $e){
            return response()->json(['status' => 20001, 'message' => $e->getMessage()]);
        }
    }

    public function del(Request $request){
        $data = $request->all();
        try{
            $channel = Channel::find($data['id']);
            if($channel['pid'] == 0){
                Channel::query()->where('pid',$channel['id'])->delete();
            }
            Channel::destroy($data['id']);
            return response()->json(['status' => 0, 'message' => '删除成功']);
        } catch (\Exception $e){
            return response()->json(['status' => 20001, 'message' => $e->getMessage()]);
        }
    }

}
