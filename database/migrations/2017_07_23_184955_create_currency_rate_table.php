<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCurrencyRateTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('currency_rate', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('currency_id');
            $table->decimal('rate');
            $table->date('date');
            $table->timestamps();

            $table->unique(['currency_id', 'date']);
            $table->foreign('currency_id')->references('id')->on('currency');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('currency_rate');
    }
}
