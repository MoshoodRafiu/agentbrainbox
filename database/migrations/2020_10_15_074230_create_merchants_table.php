<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMerchantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('merchants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->string('business_name');
            $table->string('business_email');
            $table->string('business_phone');
            $table->boolean('contact_verification')->default(0);
            $table->string('business_image')->nullable();
            $table->string('country');
            $table->string('state');
            $table->string('city');
            $table->text('business_address');
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
        Schema::dropIfExists('merchants');
    }
}
