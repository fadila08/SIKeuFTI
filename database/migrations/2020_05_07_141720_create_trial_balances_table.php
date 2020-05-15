<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrialBalancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trial_balances', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('period');
            $table->unsignedBigInteger('id_coa');
            $table->unsignedBigInteger('id_ledger');
            $table->timestamps();

            $table->foreign('id_ledger')->references('id')->on('ledgers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trial_balances');
    }
}
