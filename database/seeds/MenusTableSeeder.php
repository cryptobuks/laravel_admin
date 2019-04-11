<?php

use Illuminate\Database\Seeder;
use App\Model\Admin\Menu;
use App\Model\Admin\Permission;
use Illuminate\Support\Facades\DB;

class MenusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('menus')->truncate();

        //系统管理菜单下:管理员列表/权限列表/菜单列表
        Menu::create(['pid'=>0, 'permission_id'=>0, 'group'=>'system', 'name'=>'系统管理', 'icon'=>'fa-gears', 'sort'=>10]);

        $system_pid = Menu::query()->where('pid',0)->where('group','system')->pluck('id')->first();
        $accountIndex = Permission::query()->where('name','account.index')->pluck('id')->first();
        $permissionIndex = Permission::query()->where('name','permission.index')->pluck('id')->first();
        $menuIndex = Permission::query()->where('name','menu.index')->pluck('id')->first();

        Menu::create(['pid'=>$system_pid, 'permission_id'=>$accountIndex, 'group'=>'system', 'name'=>'管理员列表', 'icon'=>'fa-circle-o text-yellow', 'sort'=>10]);
        Menu::create(['pid'=>$system_pid, 'permission_id'=>$permissionIndex, 'group'=>'system', 'name'=>'权限列表', 'icon'=>'fa-circle-o text-yellow', 'sort'=>20]);
        Menu::create(['pid'=>$system_pid, 'permission_id'=>$menuIndex, 'group'=>'system', 'name'=>'菜单列表', 'icon'=>'fa-circle-o text-yellow', 'sort'=>30]);

        //商户管理菜单下:商户列表
        Menu::create(['pid'=>0, 'permission_id'=>0, 'group'=>'merchant', 'name'=>'商户管理', 'icon'=>'fa-address-book-o', 'sort'=>20]);

        $merchant_pid = Menu::query()->where('pid',0)->where('group','merchant')->pluck('id')->first();
        $merchantIndex = Permission::query()->where('name','merchant.index')->pluck('id')->first();

        Menu::create(['pid'=>$merchant_pid, 'permission_id'=>$merchantIndex, 'group'=>'merchant', 'name'=>'商户列表', 'icon'=>'fa-circle-o text-yellow', 'sort'=>10]);

        //

    }
}
