<?php
use Phinx\Seed\AbstractSeed;
use Faker\Factory as Faker;

class StockSeeder extends AbstractSeed
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
				'stock_code' 			=> 'STK-001',
				'book_id'  		  		=> 1,
				'is_available' 			=> 1,
				'rack_no' 				=> 'R-001'
			],
			[
				'stock_code'			=> 'STK-002',
				'book_id'  		  		=> 2,
				'is_available' 			=> 1,
				'rack_no' 				=> 'R-002'
			],
			[
				'stock_code' 			=> 'STK-003',
				'book_id'  		  		=> 3,
				'is_available' 			=> 1,
				'rack_no' 				=> 'R-003'
			],
			[
				'stock_code' 			=> 'STK-004',
				'book_id'  		  		=> 3,
				'is_available' 			=> 0,
				'rack_no' 				=> 'R-003'
			],
		];

        $table = $this->table('stocks');
        $table->insert($data)->saveData();
    }
}
