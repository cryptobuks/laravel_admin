<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBanksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('banks', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->comment('银行名称');
            $table->string('code')->comment('银行简称(编码)');
            $table->tinyInteger('status')->default(1)->comment('启用状态 0:未启用 1:已启用');
            $table->smallInteger('sort')->default(100)->comment('排序(ASC)');
            $table->timestamps();
        });
        DB::statement("alter table `banks` comment '银行类别'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('banks');
    }
}
