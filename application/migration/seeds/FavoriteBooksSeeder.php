<?php


use Phinx\Seed\AbstractSeed;

class FavoriteBooksSeeder extends AbstractSeed
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
				'member_id' => 1,
				'book_id' => 1,
			],
			[
				'member_id' => 1,
				'book_id' => 2,
			],
			[
				'member_id' => 1,
				'book_id' => 3,
			],
			[
				'member_id' => 1,
				'book_id' => 4,
			],
			[
				'member_id' => 1,
				'book_id' => 5,
			],
			[
				'member_id' => 2,
				'book_id' => 1,
			],
			[
				'member_id' => 2,
				'book_id' => 2,
			],
			[
				'member_id' => 2,
				'book_id' => 3,
			],
			[
				'member_id' => 2,
				'book_id' => 4,
			]
		];

		$table = $this->table('favorite_books');
		$table->insert($data)->save();
    }
}
