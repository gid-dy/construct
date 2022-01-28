<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateServicesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('services', function(Blueprint $table)
		{
			$table->bigIncrements('id');
			$table->string('ServiceName', 150);
			$table->string('Description', 100)->nullable();
			$table->decimal('ServicePrice', 20, 2);
			$table->string('image', 4000)->nullable();
			$table->boolean('Status')->nullable();
			$table->unsignedBiginteger('Category_id')->nullable()->index('RefTourPackageCategories4');
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
		Schema::drop('services');
	}

}
