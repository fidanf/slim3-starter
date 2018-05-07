<?php


use Faker\Factory;
use Phinx\Seed\AbstractSeed;

class ArticlesSeeder extends AbstractSeed
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeders is available here:
     * http://docs.phinx.org/en/latest/seeding.html
     */
    public function run()
    {
        $faker = Faker\Factory::create();
        $data = [];
        for ($i = 0; $i < 100; $i++) {
            $data[] = [
                'title'         => $faker->sentence,
                'body'          => $faker->realText,
                'created_at'    => (new \DateTime)->format('Y-m-d H:i:s'),
                'updated_at'    => (new \DateTime)->format('Y-m-d H:i:s')
            ];
        }

        $this->insert('articles', $data);
    }
}
