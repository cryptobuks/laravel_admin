<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMerchantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('merchants', function (Blueprint $table) {
            $table->increments('id');
            $table->string('merchant_no')->comment('商户号');
            $table->string('name')->comment('商户名');
            $table->decimal('balance',8,2)->default(0)->comment('待结算余额');
            $table->decimal('available_balance',8,2)->default(0)->comment('可提现金额');
            $table->string('password')->comment('登录密码');
            $table->string('security_password')->comment('资金密码');
            $table->string('key')->comment('秘钥');
            $table->string('salt')->comment('随机盐值');
            $table->tinyInteger('status')->default(1);
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
        Schema::dropIfExists('merchants');
    }
}
