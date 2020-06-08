<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccReceivableTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('acc_receivable', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('id_transaction');
            $table->date('pay_date');
            $table->date('due_date');
            $table->string('debet');
            $table->string('credit');
            $table->string('remaining_debt');
            $table->timestamps();

            $table->foreign('id_transaction')->references('id')->on('general_ledgers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('acc_receivable');
    }
}
