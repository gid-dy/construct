<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCartsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('carts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBiginteger('Service_id')->index('RefTourPackages5');
            $table->string('ServiceName', 150)->index('RefTourPackages51');
            $table->string('ServiceType', 25);
            $table->decimal('ServicePrice',20,2);
            $table->string('email',100);
            $table->string('Session_id', 255);
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
        Schema::dropIfExists('carts');
    }
}
