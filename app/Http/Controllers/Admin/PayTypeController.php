<?php

namespace App\Http\Controllers\Admin;

use App\Model\Admin\PayType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class PayTypeController extends Controller
{
    public function index(){
        $lists = PayType::all()->toArray();
        $viewData = [
            'lists'     => $lists,
            'page_title'=> '支付通道列表',
        ];
        return view('admin.payType.index')->with($viewData);
    }

    public function create(Request $request){
        if( $request->isMethod('post') ){
            $data = $request->all();
            $rules = [
                'name'        => 'required|string|min:2|max:100|unique:pay_types',
                'pay_type'    => 'required|string|min:2|max:100|unique:pay_types',
                'rate'        => 'required',
                'min'         => 'required',
                'max'         => 'required',
                'limit'       => 'required',
                'settle_type' => 'required|string',
                'status'      => 'required|in:0,1',
            ];
            $messages = [
                'required'  => ":attribute不能为空",
                'string'    => ":attribute需为字符串",
                'min'       => ":attribute最少:min个字符",
                'max'       => ":attribute最多:max个字符",
                'unique'    => ":attribute已存在",
                'in'        => ":attribute错误"
            ];
            $attributes = [
                'name'        => '通道名称',
                'pay_type'    => '支付类型',
                'rate'        => '交易费率',
                'min'         => '最小额度',
                'max'         => '最大额度',
                'limit'       => '当日限制额度',
                'settle_type' => '结算方式',
                'status'      => '通道状态',
            ];
            $validator = Validator::make($data, $rules, $messages, $attributes);
            if( $validator->fails() ){
                return response()->json(['status' => 10002, 'message' => $validator->errors()->first()]);
            }
            try{
                PayType::create($data);
                return response()->json(['status' => 0, 'message' => "添加成功"]);
            } catch (\Exception $e){
                return response()->json(['status' => 20001, 'message' => $e->getMessage()]);
            }
        }
        return view('admin.payType.create');
    }

    public function edit(Request $request){
        $data = $request->all();
        if( $request->isMethod('post') ){
            $rules = [
                'name'        => 'required|string|min:2|max:100|unique:pay_types,name,'.$data['id'],
                'pay_type'    => 'required|string|min:2|max:100|unique:pay_types,pay_type,'.$data['id'],
                'rate'        => 'required',
                'min'         => 'required',
                'max'         => 'required',
                'limit'       => 'required',
                'settle_type' => 'required|string',
                'status'      => 'required|in:0,1',
            ];
            $messages = [
                'required'  => ":attribute不能为空",
                'string'    => ":attribute需为字符串",
                'min'       => ":attribute最少:min个字符",
                'max'       => ":attribute最多:max个字符",
                'unique'    => ":attribute已存在",
                'in'        => ":attribute错误"
            ];
            $attributes = [
                'name'        => '通道名称',
                'pay_type'    => '支付类型',
                'rate'        => '交易费率',
                'min'         => '最小额度',
                'max'         => '最大额度',
                'limit'       => '当日限制额度',
                'settle_type' => '结算方式',
                'status'      => '通道状态',
            ];
            $validator = Validator::make($data, $rules, $messages, $attributes);
            if( $validator->fails() ){
                return response()->json(['status' => 10002, 'message' => $validator->errors()->first()]);
            }
            try{
                PayType::where('id',$data['id'])->update($data);
                return response()->json(['status' => 0, 'message' => "修改成功"]);
            } catch (\Exception $e){
                return response()->json(['status' => 20001, 'message' => $e->getMessage()]);
            }
        }
        if($data['id'] > 0){
            $data = PayType::find($data['id'])->toArray();
        }
        return view('admin.payType.edit')->with($data);
    }

    public function lock($id, $status){
        try{
            PayType::where('id',$id)->update(['status'=>$status]);
            $message = $status == 1 ? "通道开启成功" : "通道关闭成功";
            return response()->json(['status' => 0, 'message' => $message]);
        } catch (\Exception $e){
            return response()->json(['status' => 20001, 'message' => $e->getMessage()]);
        }
    }

    public function del(Request $request){
        $data = $request->all();
        try{
            PayType::destroy($data['id']);
            return response()->json(['status' => 0, 'message' => '删除成功']);
        } catch (\Exception $e){
            return response()->json(['status' => 20001, 'message' => $e->getMessage()]);
        }
    }

}
