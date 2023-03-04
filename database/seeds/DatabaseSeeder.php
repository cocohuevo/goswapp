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
        // $this->call(UsersTableSeeder::class);
        DB::table('users')->insert([
            'firstname' => 'admin',
            'surname' => 'admin',
            'email' => 'admin@admin.com',
            'password' => bcrypt('admin'),
            'type' => 'admin',
        ]);
        $cicles = factory(App\Cicle::class, 20)->create();
        $users = factory(App\User::class, 20)->create();
        $teachers = factory(App\Teacher::class, 20)->create();
        $students = factory(App\Student::class, 20)->create();
        $tasks = factory(App\Task::class, 20)->create();
        $taskAssignments = factory(App\TaskAssignment::class, 20)->create();
        $comments = factory(App\Comment::class, 20)->create();
    }
}
