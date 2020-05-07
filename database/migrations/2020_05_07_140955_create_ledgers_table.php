<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLedgersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ledgers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('id_coa');
            $table->unsignedBigInteger('id_desc');
            $table->string('debet_saldo');
            $table->string('cred_saldo');
            $table->timestamps();

            $table->foreign('id_coa')->references('id')->on('Coas');
            $table->foreign('id_desc')->references('id')->on('general_ledgers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ledgers');
    }
}
