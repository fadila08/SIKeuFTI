<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCreditorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('creditors', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('cred_name');
            $table->string('cred_address');
            $table->string('cred_email')->nullable();
            $table->char('cred_phone',15);
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
        Schema::dropIfExists('creditors');
    }
}
