<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServiceimagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('serviceimages', function (Blueprint $table) {
            $table->bigIncrements('id');
			$table->string('Image', 4000);
			$table->string('ServiceImageName', 50)->nullable();
			$table->unsignedBiginteger('Service_id')->index('RefTourPackages3');
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
        Schema::dropIfExists('serviceimages');
    }
}
