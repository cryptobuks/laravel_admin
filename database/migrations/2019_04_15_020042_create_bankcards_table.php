<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBankcardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bankcards', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('merchant_id')->nullable()->comment('商户ID');
            $table->integer('bank_id')->nullable()->comment('银行ID');
            $table->string('card_number')->comment('银行卡号');
            $table->string('name')->comment('姓名');
            $table->string('province')->comment('省份');
            $table->string('city')->comment('城市');
            $table->string('branch')->comment('支行地址');
            $table->tinyInteger('status')->default(1)->comment('绑定状态 0:已解绑 1:绑定');
            $table->timestamps();
        });
        DB::statement("alter table `bankcards` comment '银行卡列表'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bankcards');
    }
}
