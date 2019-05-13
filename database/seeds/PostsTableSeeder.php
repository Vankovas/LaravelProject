<?php

use Illuminate\Database\Seeder;

class PostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();


        DB::table('posts')->insert([
            'title' => $faker->text,
            'body' => $faker->text,
            'created_at' => date("Y-m-d H:i:s"),
            'user_id'=> 1
        ]);
    }
}
