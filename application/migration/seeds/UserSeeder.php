<?php


use Phinx\Seed\AbstractSeed;

class UserSeeder extends AbstractSeed
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeders is available here:
     * https://book.cakephp.org/phinx/0/en/seeding.html
     */
    public function getDependencies(): array
    {
        return [
            'RoleSeeder'
        ];
    }

    public function run(): void
    {
        $data = [
            [
                'user_name' => 'admin',
                'full_name' => 'administrator',
                'email' => 'admin@gmail.com',
                'user_pass' => password_hash('admin', PASSWORD_DEFAULT),
                'role_id'   => 1,
				'status'	=> 'active'
            ]
        ];

        $table = $this->table('users');

        $table->insert($data)->saveData();
    }
}
