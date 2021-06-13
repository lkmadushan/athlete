<?php

class DatabaseSeeder extends Seeder
{

    protected $tables = [
        'users', 'devices', 'sports', 'teams', 'players', 'skills', 'videos'
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Eloquent::unguard();

        $this->cleanDatabase();

        $this->seed();
    }

    /**
     * Clean the database
     */
    protected function cleanDatabase()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');

        foreach ($this->tables as $table) {
            DB::table($table)->truncate();
        }
    }

    protected function seed()
    {
        foreach ($this->tables as $table) {

            $seeder = $this->tableToSeeder($table);

            $this->call($seeder);
        }
    }

    protected function tableToSeeder($table)
    {
        return ucfirst($table) . 'TableSeeder';
    }
}
