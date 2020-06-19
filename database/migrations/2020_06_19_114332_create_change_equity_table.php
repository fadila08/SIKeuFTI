<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChangeEquityTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('change_equity', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('period');
            $table->string('initial_balance');
            $table->unsignedBigInteger('id_net_income');
            $table->string('prive');
            $table->string('ending_balance');
            $table->timestamps();

            $table->foreign('id_net_income')->references('id')->on('profit_loss');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('change_equity');
    }
}
