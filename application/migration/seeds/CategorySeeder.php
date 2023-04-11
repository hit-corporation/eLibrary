<?php


use Phinx\Seed\AbstractSeed;

class CategorySeeder extends AbstractSeed
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
        $data = 
        [
            [
                'category_name'     => 'All',
                'parent_category'   => NULL
            ],
            [
                'category_name'     => 'Kelas I',
                'parent_category'   => 1
            ],
            [
                'category_name'     => 'Kelas II',
                'parent_category'   => 1
            ],
            [
                'category_name'     => 'Kelas III',
                'parent_category'   => 1
            ],
            [
                'category_name'     => 'Kelas IV',
                'parent_category'   => 1
            ],
            [
                'category_name'     => 'Kelas V',
                'parent_category'   => 1
            ],
            [
                'category_name'     => 'Kelas VI',
                'parent_category'   => 1
            ],
        ];

        $table = $this->table('categories');
        $table->insert($data)->saveData();
    }
}
