<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCashFlowsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cash_flows', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('period');
            $table->string('cash_previous_period');
            $table->unsignedBigInteger('total_revenue_and_charge');
            $table->string('netto_op_activity');
            $table->unsignedBigInteger('book_value_fixed_asset');
            $table->string('netto_invest_activity');
            $table->unsignedBigInteger('equity_balance_and_prive');
            $table->string('netto_fund_activity');
            $table->string('net_cash_flow');      
            $table->timestamps();

            $table->foreign('total_revenue_and_charge')->references('id')->on('profit_loss');
            $table->foreign('book_value_fixed_asset')->references('id')->on('balance_sheets');
            $table->foreign('equity_balance_and_prive')->references('id')->on('change_equity');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cash_flows');
    }
}
