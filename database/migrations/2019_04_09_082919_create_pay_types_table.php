<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreatePayTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pay_types', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->comment('通道名称');
            $table->string('pay_type')->comment('支付类型(下游提交代码)');
            $table->float('rate',8,4)->comment('上游商户交易费率');
            $table->decimal('min',8,2)->comment('单笔最小额度');
            $table->decimal('max',8,2)->comment('单笔最大额度');
            $table->decimal('limit',10,2)->comment('当日交易限额');
            $table->string('settle_type')->comment('结算方式');
            $table->smallInteger('sort')->default(100)->comment('排序(ASC)');
            $table->tinyInteger('status')->default(1)->comment('通道状态 0:未开通 1:已开通');
            $table->timestamps();
        });
        DB::statement("alter table `pay_types` comment '支付类型表'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pay_types');
    }
}
