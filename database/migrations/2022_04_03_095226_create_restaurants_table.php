<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRestaurantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('restaurants', function (Blueprint $table) {
            $table->id(); 
            $table->foreignId('category_id')->nullable()->constrained()->cascadeOnDelete();
            $table->string('closing_time')->nullable();
            $table->string('opening_time')->nullable(); 
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->string('description')->nullable(); 
            $table->string('photo');
            $table->string('menu')->nullable();//photo
            $table->string('instagram_link')->nullable();
            $table->string('facebook_link')->nullable();
            $table->string('twiter_link')->nullable();
            $table->string('website_link')->nullable();
            $table->string('informational_tags')->nullable();
            $table->boolean('active')->default(false);
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
        Schema::dropIfExists('restaurants');
    }
}