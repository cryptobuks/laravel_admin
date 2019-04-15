<?php

use App\Model\Admin\Channel;
use App\Model\Admin\Merchant;
use App\Model\Admin\Order;
use App\Model\Admin\PayType;
use App\Model\Admin\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TestDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->truncate();
        Role::create(['name'=>'管理员']);
        Role::create(['name'=>'研发']);
        Role::create(['name'=>'财务']);
        Role::create(['name'=>'客服']);

        DB::table('merchants')->truncate();
        $salt = [Str::random(6), Str::random(6), Str::random(6)];
        Merchant::create(['merchant_no'=>'168820', 'name'=>'ctou', 'password'=>md5('123456' . $salt[0]), 'security_password'=>md5('123456' . $salt[0]), 'key'=>md5(time() . $salt[0]), 'salt'=>$salt[0]]);
        Merchant::create(['merchant_no'=>'168861', 'name'=>'lubar', 'password'=>md5('123456' . $salt[1]), 'security_password'=>md5('123456' . $salt[1]), 'key'=>md5(time() . $salt[1]), 'salt'=>$salt[1]]);
        Merchant::create(['merchant_no'=>'168888', 'name'=>'simida', 'password'=>md5('123456' . $salt[2]), 'security_password'=>md5('123456' . $salt[2]), 'key'=>md5(time() . $salt[2]), 'salt'=>$salt[2]]);

        DB::table('pay_types')->truncate();
        PayType::create(['name'=>'支付宝扫码', 'pay_type'=>'alipay_qr', 'rate'=>'2.5', 'min'=>'10', 'max'=>'5000', 'limit'=>'300000', 'settle_type'=>'D0', 'status'=>'0']);
        PayType::create(['name'=>'支付宝H5', 'pay_type'=>'alipay_h5', 'rate'=>'2.5', 'min'=>'10', 'max'=>'3000', 'limit'=>'300000', 'settle_type'=>'D0', 'status'=>'1']);
        PayType::create(['name'=>'微信扫码', 'pay_type'=>'wechat_qr', 'rate'=>'3.8', 'min'=>'1', 'max'=>'2000', 'limit'=>'500000', 'settle_type'=>'T1', 'status'=>'0']);
        PayType::create(['name'=>'微信H5', 'pay_type'=>'wechat_h5', 'rate'=>'3.8', 'min'=>'1', 'max'=>'5000', 'limit'=>'500000', 'settle_type'=>'T1', 'status'=>'1']);

        DB::table('channels')->truncate();
        Channel::create(['pid'=>'0', 'title'=>'汇丰支付', 'name'=>'HFpay', 'pay_type'=>'null', 'info'=>'null', 'sort'=>'10', 'status'=>'1']);
        Channel::create(['pid'=>'1', 'title'=>'汇丰支付宝扫码', 'name'=>'null', 'pay_type'=>'alipay_qr', 'info'=>'null', 'sort'=>'10', 'status'=>'1']);
        Channel::create(['pid'=>'1', 'title'=>'汇丰微信H5', 'name'=>'null', 'pay_type'=>'wechat_h5', 'info'=>'null', 'sort'=>'20', 'status'=>'1']);
        Channel::create(['pid'=>'0', 'title'=>'云易付', 'name'=>'YYpay', 'pay_type'=>'null', 'info'=>'null', 'sort'=>'20', 'status'=>'1']);
        Channel::create(['pid'=>'4', 'title'=>'云易付支付宝扫码', 'name'=>'null', 'pay_type'=>'alipay_qr', 'info'=>'null', 'sort'=>'10', 'status'=>'0']);
        Channel::create(['pid'=>'4', 'title'=>'云易付支付宝H5', 'name'=>'null', 'pay_type'=>'alipay_h5', 'info'=>'null', 'sort'=>'20', 'status'=>'1']);
        Channel::create(['pid'=>'4', 'title'=>'云易付微信扫码', 'name'=>'null', 'pay_type'=>'wechat_qr', 'info'=>'null', 'sort'=>'30', 'status'=>'1']);
        Channel::create(['pid'=>'4', 'title'=>'云易付微信H5', 'name'=>'null', 'pay_type'=>'wechat_h5', 'info'=>'null', 'sort'=>'40', 'status'=>'0']);

//        Order::create(['merchant_no'=>'', 'name'=>'', 'pay_no'=>'', 'order_id'=>'', 'order_time'=>'', 'pay_type'=>'', 'pay_channel'=>'', 'amount'=>'', 'notify_url'=>'', 'return_url'=>'', 'pay_ip'=>'', 'attach'=>'']);

    }
}
