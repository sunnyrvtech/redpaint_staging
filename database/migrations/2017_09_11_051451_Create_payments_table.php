<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function ($table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->string('stripe_id');
            $table->string('subscription_plan');
            $table->decimal('amount', 5, 2)->nullable();
            $table->timestamp('subscription_start')->nullable();
            $table->timestamp('subscription_end')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payments');
    }
}
