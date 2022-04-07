<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVisitedRestaurantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('visited_restaurants', function (Blueprint $table) {
            $table->id();  
            $table->foreignId('employee_id')->constrained()->cascadeOnDelete(); 
            $table->foreignId('restaurant_id')->constrained()->cascadeOnDelete();
            $table->string('visit_date_time')->nullable();
            $table->string('feedback')->nullable();
            $table->string('meeting_date_time')->nullable();  
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('visited_restaurants');
    }
}
