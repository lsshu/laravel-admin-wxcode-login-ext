<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWechatUserInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wechat_user_infos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('path',20)->nullable()->comment('站点');
            $table->string('openid',30)->nullable()->comment('OPENID');
            $table->string('nickname',50)->nullable()->comment('昵称');
            $table->tinyInteger('sex')->nullable()->comment('性别');
            $table->string('language',10)->nullable()->comment('语言');
            $table->string('city',20)->nullable()->comment('城市');
            $table->string('province',20)->nullable()->comment('省份');
            $table->string('country',20)->nullable()->comment('国家');
            $table->string('headimgurl',190)->nullable()->comment('头像');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wechat_user_infos');
    }
}
