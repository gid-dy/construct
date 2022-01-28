<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookingsServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bookings_services', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('Booking_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('Service_id');
            $table->string('ServiceName', 150);
            $table->string('ServiceType', 25);
			$table->decimal('ServicePrice', 20, 2);
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
        Schema::dropIfExists('bookings_services');
    }
}
