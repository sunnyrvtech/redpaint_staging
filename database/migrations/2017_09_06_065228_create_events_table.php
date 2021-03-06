<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('events', function ($table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->string('event_slug');
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('address');
            $table->string('phone_number')->nullable();
            $table->string('city');
            $table->string('state');
            $table->string('zip');
            $table->integer('country_id');
            $table->string('formatted_address');
            $table->text('daily_deal')->nullable();
            $table->string('happy_hour')->nullable();
            $table->text('happy_hour_note')->nullable();
            $table->string('brunch_hour')->nullable();
            $table->text('brunch_hour_note')->nullable();
            $table->text('operation_hour')->nullable();
            $table->string('vegan')->nullable();
            $table->string('vegetarian')->nullable();
            $table->string('gluten')->nullable();
            $table->string('parking')->nullable();
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->string('website_url')->nullable();
            $table->string('menu_address')->nullable();
            $table->decimal('price_to', 10, 2)->nullable();
            $table->decimal('price_from', 10, 2)->nullable();
            $table->integer('category_id');
            $table->integer('sub_category_id')->nullable();
            $table->timestamp('start_date')->nullable();
            $table->timestamp('end_date')->nullable();
            $table->integer('status')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('events');
    }

}
