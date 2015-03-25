<?php

class DatabaseSeeder extends Seeder {

	protected $tables = ['users'];

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Eloquent::unguard();

		$this->cleanDatabase();

		$this->call('UsersTableSeeder');
		$this->call('DevicesTableSeeder');
	}

	/**
	 * Clean the database
	 */
	protected function cleanDatabase()
	{
		DB::statement('SET FOREIGN_KEY_CHECKS = 0');

		foreach($this->tables as $table) {
			DB::table($table)->truncate();
		}
	}
}
