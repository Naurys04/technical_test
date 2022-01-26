<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChargebacksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chargebacks', function (Blueprint $table) {
            $table->id();
            $table->string('name_chargeback', 255);
            $table->date('date_chargeback');
            $table->bigInteger('user_id');
            $table->dateTime('date_register');
            $table->string('ip_register', 255);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('chargebacks');
    }
}
