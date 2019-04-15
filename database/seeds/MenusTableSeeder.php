<?php

use Illuminate\Database\Seeder;
use App\Model\Admin\Menu;
use App\Model\Admin\Permission;
use Illuminate\Support\Facades\DB;

class MenusTableSeeder extends Seeder
{
    /**
     * php artisan db:seed --class=MenusTableSeeder
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('menus')->truncate();

        //系统管理菜单下:管理员列表/权限列表/菜单列表
        Menu::create(['pid'=>0, 'permission_id'=>0, 'name'=>'系统管理', 'icon'=>'fa-gears', 'group'=>'system', 'sort'=>10]);

        $system_pid = Menu::query()->where('pid',0)->where('group','system')->pluck('id')->first();
        $accountIndex = Permission::query()->where('name','account.index')->pluck('id')->first();
        $roleIndex = Permission::query()->where('name','role.index')->pluck('id')->first();
        $permissionIndex = Permission::query()->where('name','permission.index')->pluck('id')->first();
        $menuIndex = Permission::query()->where('name','menu.index')->pluck('id')->first();

        Menu::create(['pid'=>$system_pid, 'permission_id'=>$accountIndex, 'name'=>'管理员列表', 'icon'=>'fa-user', 'group'=>'system', 'sort'=>10]);
        Menu::create(['pid'=>$system_pid, 'permission_id'=>$roleIndex, 'name'=>'角色列表', 'icon'=>'fa-street-view', 'group'=>'system', 'sort'=>20]);
        Menu::create(['pid'=>$system_pid, 'permission_id'=>$permissionIndex, 'name'=>'权限列表', 'icon'=>'fa-lock', 'group'=>'system', 'sort'=>30]);
        Menu::create(['pid'=>$system_pid, 'permission_id'=>$menuIndex, 'name'=>'菜单列表', 'icon'=>'fa-list-ul', 'group'=>'system', 'sort'=>40]);


        //以下非必需
        //商户管理菜单下:商户列表
        Menu::create(['pid'=>0, 'permission_id'=>0, 'name'=>'商户管理', 'icon'=>'fa-address-book-o', 'group'=>'merchant', 'sort'=>20]);

        $merchant_pid = Menu::query()->where('pid',0)->where('group','merchant')->pluck('id')->first();
        $merchantIndex = Permission::query()->where('name','merchant.index')->pluck('id')->first();

        Menu::create(['pid'=>$merchant_pid, 'permission_id'=>$merchantIndex, 'name'=>'商户列表', 'icon'=>'fa-users', 'group'=>'merchant', 'sort'=>10]);


        //支付管理菜单下:通道列表/支付列表
        Menu::create(['pid'=>0, 'permission_id'=>0, 'name'=>'支付管理', 'icon'=>'fa-credit-card', 'group'=>'pay', 'sort'=>30]);

        $pay_pid = Menu::query()->where('pid',0)->where('group','pay')->pluck('id')->first();
        $payTypeIndex = Permission::query()->where('name','payType.index')->pluck('id')->first();
        $channelIndex = Permission::query()->where('name','channel.index')->pluck('id')->first();

        Menu::create(['pid'=>$pay_pid, 'permission_id'=>$payTypeIndex, 'name'=>'支付通道', 'icon'=>'fa-cc-visa', 'group'=>'pay', 'sort'=>10]);
        Menu::create(['pid'=>$pay_pid, 'permission_id'=>$channelIndex, 'name'=>'支付列表', 'icon'=>'fa-paypal', 'group'=>'pay', 'sort'=>20]);


        //交易管理菜单下:订单列表
        Menu::create(['pid'=>0, 'permission_id'=>0, 'name'=>'交易管理', 'icon'=>'fa-book', 'group'=>'transaction', 'sort'=>40]);

        $transaction_pid = Menu::query()->where('pid',0)->where('group','transaction')->pluck('id')->first();
        $orderIndex = Permission::query()->where('name','order.index')->pluck('id')->first();

        Menu::create(['pid'=>$transaction_pid, 'permission_id'=>$orderIndex, 'name'=>'订单列表', 'icon'=>'fa-inbox', 'group'=>'transaction', 'sort'=>10]);


        //资金管理菜单下:银行类别/银行卡列表/提现记录
        Menu::create(['pid'=>0, 'permission_id'=>0, 'name'=>'资金管理', 'icon'=>'fa-money', 'group'=>'fund', 'sort'=>50]);

        $fund_pid = Menu::query()->where('pid',0)->where('group','fund')->pluck('id')->first();
        $bankIndex = Permission::query()->where('name','bank.index')->pluck('id')->first();
        $bankcardIndex = Permission::query()->where('name','bankcard.index')->pluck('id')->first();
        $withdrawIndex = Permission::query()->where('name','withdraw.index')->pluck('id')->first();

        Menu::create(['pid'=>$fund_pid, 'permission_id'=>$bankIndex, 'name'=>'银行类别', 'icon'=>'fa-bank', 'group'=>'fund', 'sort'=>10]);
        Menu::create(['pid'=>$fund_pid, 'permission_id'=>$bankcardIndex, 'name'=>'银行卡列表', 'icon'=>'fa-cc-mastercard', 'group'=>'fund', 'sort'=>20]);
        Menu::create(['pid'=>$fund_pid, 'permission_id'=>$withdrawIndex, 'name'=>'提现记录', 'icon'=>'fa-won', 'group'=>'fund', 'sort'=>30]);

    }
}
