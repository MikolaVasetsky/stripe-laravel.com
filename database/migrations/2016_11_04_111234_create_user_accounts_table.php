<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserAccountsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users_accounts', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('user_id');
			$table->string('country', 100);
			$table->string('currency', 100);
			$table->string('routing_number', 255);
			$table->string('account_number', 255);
			$table->string('account_holder_type', 100);
			$table->string('verification_status', 100);
			$table->text('token');
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
		Schema::drop('users_accounts');
	}

}
