<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('phones', function (Blueprint $table) {
            $table->id();
            $table->string('number', 20);
            $table->unsignedBigInteger('subscriber_id')->index();
            $table->foreign('subscriber_id')->on('subscribers')->references('id')->onDelete('cascade');
            $table->unsignedBigInteger('type_phone_id')->index();
            $table->foreign('type_phone_id')->on('type_phones')->references('id')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('phones');
    }
};
