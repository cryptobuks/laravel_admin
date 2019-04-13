<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChannelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('channels', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('pid')->default(0);
            $table->string('title')->comment('支付渠道名称');
            $table->string('name')->comment('服务名称(开发填写)');
            $table->string('pay_type')->comment('支付类型(下游提交)');
            $table->string('info')->comment('商户信息(网关/商户号/秘钥等)');
            $table->smallInteger('sort')->default(100)->comment('排序(DESC)');
            $table->tinyInteger('status')->default(0)->comment('状态 0:关闭 1:开启');
            $table->timestamps();
        });
        DB::statement("alter table `channels` comment '上游支付渠道表'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('channels');
    }
}
