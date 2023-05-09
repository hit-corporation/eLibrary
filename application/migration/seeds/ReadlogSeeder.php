<?php
use Phinx\Seed\AbstractSeed;
use Faker\Factory as Faker;

class ReadlogSeeder extends AbstractSeed
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
        $faker = Faker::create('id_ID');
        $data = [];

        for($i=0;$i<100;$i++) 
        {
            $data[] = [
                'trans_code'    => strtoupper(bin2hex(random_bytes(10))),
                'member_id'     => $faker->numberBetween(1, 50),
                'book_id'       => $faker->numberBetween(1, 13),
                'start_time'    => $faker->dateTimeBetween('-3 months', 'now')->format('Y-m-d H:i:s'),
                'end_time'      => $faker->dateTimeBetween('now', '+3 hours')->format('Y-m-d H:i:s'),
                'last_page'     => $faker->numberBetween(1, 30)
            ];
        }

        $this->table('read_log')->insert($data)->saveData();
    }
}
