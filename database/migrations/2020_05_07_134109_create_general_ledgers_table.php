<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGeneralLedgersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('general_ledgers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('date');
            $table->unsignedBigInteger('id_project');
            $table->string('description');
            $table->string('proof_num');
            $table->string('upload_proof')->nullable()->default(null);
            $table->unsignedBigInteger('id_debet_acc');
            $table->unsignedBigInteger('id_cred_acc');
            $table->string('nominal');
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
        Schema::dropIfExists('general_ledgers');
    }
}
