<?php


use Phinx\Seed\AbstractSeed;

class RoleSeeder extends AbstractSeed
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
            ['rolename' => 'Admin'],
			['rolename' => 'User'],
        ];

        $table = $this->table('userrole');

        $table->insert($data)->saveData();
    }
}
