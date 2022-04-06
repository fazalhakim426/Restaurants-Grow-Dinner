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


            $table->foreignId('employee_id')->constrained()->cascadeOnDelete();
            $table->string('photo');
            $table->string('name');
            $table->string('date_time');
            $table->string('feedback');
            //visited restaurants


            $table->foreignId('category_id')->constrained()->cascadeOnDelete();
            $table->string('closing_time');
            $table->string('opening_time');
            $table->string('contact_number'); 
            $table->string('google_map_location');
            $table->string('description');
            $table->string('photo');
            $table->string('menu');//photo
            $table->string('instagram_link');
            $table->string('facebook_link');
            $table->string('twiter_link');
            $table->string('website_link');
            $table->string('informational_tags');
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
