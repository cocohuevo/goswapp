<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert(['firstname'=>'admin','surname'=>'admin','type'=>'admin','email' => 'admin@gmail.com','password'  => bcrypt('123456'),]);
        // $this->call(UsersTableSeeder::class);
        $cicles = factory(App\Cicle::class, 20)->create();
        $users = factory(App\User::class, 20)->create();
        $profiles = factory(App\Profile::class, 20)->create();
        $tasks = factory(App\Task::class, 20)->create();
    }
}
