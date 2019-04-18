<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->string('merchant_no')->comment('商户号');
            $table->string('name')->comment('商户名');
            $table->string('pay_no')->unique()->comment('支付平台系统订单号,本系统随机生成');
            $table->string('order_id')->comment('商户订单号');
            $table->dateTime('order_time')->comment('下单时间');
            $table->dateTime('pay_time')->comment('支付成功时间');
            $table->string('pay_type')->comment('支付类型(下游提交)');
            $table->string('pay_channel')->comment('支付渠道(提交上游)');
            $table->decimal('amount',8,2)->comment('订单金额');
            $table->decimal('actual_amount',8,2)->comment('实际支付金额(成功金额)');
            $table->decimal('fee',8,2)->comment('手续费');
            $table->string('notify_url')->comment('异步回调地址');
            $table->string('return_url')->comment('同步跳转地址');
            $table->string('pay_ip')->comment('支付用户IP');
            $table->string('attach')->comment('备注信息');
            $table->tinyInteger('pay_status')->default(0)->comment('支付状态 0:未支付 1:成功 2:失败');
            $table->tinyInteger('notice_status')->default(0)->comment('通知状态 0:未通知 1:已通知');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
