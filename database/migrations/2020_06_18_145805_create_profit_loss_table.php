<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProfitLossTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profit_loss', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('period');
            $table->string('acc_revenue');
            $table->string('total_revenue');
            $table->string('acc_charge');
            $table->string('total_charge');
            $table->string('net_income');
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
        Schema::dropIfExists('profit_loss');
    }
}
