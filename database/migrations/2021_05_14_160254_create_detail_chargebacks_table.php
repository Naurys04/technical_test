<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailChargebacksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_chargebacks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('chargeback_id');
            $table->string('PAN'  ,255);
            $table->string('ADV'  ,255);
            $table->string('SWCH' ,255);
            $table->string('TRACE',255);
            $table->string('RESP' ,255);
            $table->string('REF'  ,255);
            $table->string('CURR' ,255);
            $table->string('ACQ'  ,255);
            $table->string('ORG'  ,255);
            $table->string('REV'  ,255);
            $table->string('STLMT',255);
            $table->unsignedBigInteger('status_id');

            $table->foreign('chargeback_id')->references('id')->on('chargebacks');
            $table->foreign('status_id')->references('id')->on('status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('detail_chargebacks');
    }
}
