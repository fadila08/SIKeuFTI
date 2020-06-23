<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBalanceSheetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('balance_sheets', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('period');
            $table->string('acc_current_asset');
            $table->string('total_current_asset');
            $table->string('acc_fixed_asset');
            $table->string('total_fixed_asset');
            $table->string('acc_acum_depreciation');
            $table->string('total_acum_depreciation');
            $table->string('book_value_fixed_asset');
            $table->string('total_asset');
            $table->string('acc_liability');
            $table->string('total_liability');
            $table->unsignedBigInteger('id_equity_balance');
            $table->string('total_liability_equity');
            $table->timestamps();

            $table->foreign('id_equity_balance')->references('id')->on('change_equity');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('balance_sheets');
    }
}
