<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('acc_code')->unique();
            $table->string('acc_name');
            $table->unsignedBigInteger('id_account_group');
            $table->unsignedBigInteger('id_normal_balance');
            $table->timestamps();

            $table->foreign('id_account_group')->references('id')->on('account_groups');
            $table->foreign('id_normal_balance')->references('id')->on('normal_balances');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('coas');
    }
}
