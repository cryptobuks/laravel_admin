<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWithdrawsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('withdraws', function (Blueprint $table) {
            $table->increments('id');
            $table->string('merchant_no')->comment('商户号');
            $table->string('name')->comment('商户名');
            $table->string('trade_no')->comment('流水号');
            $table->decimal('amount',8,2)->comment('提现金额');
            $table->tinyInteger('status')->default(0)->comment('提现状态 0:待处理 1:已完成 2:已拒绝');
            $table->integer('admin_id')->nullable()->comment('管理员ID');
            $table->string('remark')->comment('备注');
            $table->timestamps();
        });
        DB::statement("alter table `withdraws` comment '提现记录'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('withdraws');
    }
}
