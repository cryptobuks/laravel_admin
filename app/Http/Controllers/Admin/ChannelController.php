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
                $data['info'] = "gateway/merchant/key";
            } else {
                $data['name'] = "null";
                $data['info'] = "null";
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
                $info = ['gateway'=>'https://www.baidu.com:8888/api/order/build.html', 'merchant'=>'686888', 'key'=>'zlji4f58a68uzx5df5asdf2f22222fas'];
                $data['info'] = json_encode($info,320);
            } else {
                $data['name'] = "null";
                $data['info'] = "null";
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

}
