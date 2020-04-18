<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaction', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('id_project');
            $table->date('date');
            $table->string('description');
            $table->string('proof_num');
            $table->string('nominal');
            $table->unsignedBigInteger('id_debet_acc');
            $table->unsignedBigInteger('id_cred_acc');
            $table->timestamps();

            $table->foreign('id_project')->references('id')->on('projects');
            $table->foreign('id_debet_acc')->references('id')->on('Coas');
            $table->foreign('id_cred_acc')->references('id')->on('Coas');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transaction');
    }
}
