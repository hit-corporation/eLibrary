<?php
use Phinx\Seed\AbstractSeed;
use Faker\Factory as Faker;

class MemberSeeder extends AbstractSeed
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
        $data = [];

        $faker = Faker::create('id_ID');

        for($i=0;$i<=100;$i++)
        {
            $email = $faker->unique()->email();

            $data[] = [
                'member_name' 	=> $faker->name(),
				'jenis_kelamin' => $faker->randomElement(['l', 'p']),
                'card_number' 	=> bin2hex(random_bytes(10)),
                'no_induk'    	=> $faker->unique()->nik(),
                'username'    	=> $email,
                'password'    	=> password_hash('123456', PASSWORD_DEFAULT),
                'kelas'       	=> rand(1, 12),
                'status'      	=> 'active',
                'email'       	=> $email,
                'address'     	=> $faker->unique()->address(),
                'phone'       	=> $faker->unique()->phoneNumber()
            ];
        }

        $table = $this->table('members');
        $table->insert($data)->saveData();
    }
}
