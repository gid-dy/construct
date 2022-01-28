<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateServicetypesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('servicetypes', function(Blueprint $table)
		{
			$table->bigIncrements('id');
			$table->string('ServiceType', 25);
			$table->biginteger('ServiceSize');
			$table->string('SKU', 25)->nullable();
			$table->decimal('ServicePrice', 20, 2);
			$table->unsignedBiginteger('Service_id')->index('RefTourPackages28');
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
		Schema::drop('servicetypes');
	}

}
