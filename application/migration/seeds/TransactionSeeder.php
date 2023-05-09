<?php
use Faker\Factory as Faker;
use Phinx\Seed\AbstractSeed;

class TransactionSeeder extends AbstractSeed
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeders is available here:
     * https://book.cakephp.org/phinx/0/en/seeding.html
     *  trans_code character varying(225) DEFAULT '6a7198f5dfbcc389'::character varying,
        trans_timestamp timestamp without time zone DEFAULT now(),
        member_id integer,
        book_id integer,
        start_time timestamp without time zone,
        end_time timestamp without time zone,
        actual_return timestamp without time zone,
        config_idle character varying(160),
        config_borrow_limit character varying(160),
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');
        $data = [];

        for($i=0;$i<100;$i++)
        {
            $date_start = $faker->dateTimeBetween('-3 hours', 'now')->format('Y-m-d H:i:s');

            $data[] = [
                'trans_code' => bin2hex(random_bytes(6)),
                'member_id'     => $faker->numberBetween(1, 50),
                'book_id'       => $faker->numberBetween(1, 13),
                'trans_timestamp' => $date_start,
                'start_time' => $date_start,
                'end_time' => $faker->dateTimeBetween('now', '+ 3 hours')->format('Y-m-d H:i:s'),
                'config_idle' => '15 minutes',
                'config_borrow_limit' => 2
            ];

        }

        $this->table('transactions')->insert($data)->saveData();
    }
}
