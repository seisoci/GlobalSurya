<?php

use Illuminate\Database\Seeder;

class PostTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // factory(App\User::class, 50)->create()->each(function ($user) {
        // });
        factory(App\User::class, 50)->create();
        factory(App\Matapelajaran::class, 10)->create();
        factory(App\Kelas::class, 5)->create();

    }
}
