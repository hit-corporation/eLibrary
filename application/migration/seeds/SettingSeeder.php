<?php


use Phinx\Seed\AbstractSeed;

class SettingSeeder extends AbstractSeed
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeders is available here:
     * https://book.cakephp.org/phinx/0/en/seeding.html
     */
    public function run(): void
    {
		$data = [
			[
				'max_allowed' 	    => 2,
				'due_date_value'    => 1,
				'due_date_unit'     => 'weeks',
        'limit_idle_value'  => 15,
        'limit_idle_unit'   => 'minutes',
			],
		];

		$this->table('settings')->insert($data)->saveData();
    }
}
