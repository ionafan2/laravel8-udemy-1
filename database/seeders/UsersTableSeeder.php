<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $count = max((int)$this->command->ask('How many users?', 20), 1);

        User::factory()->count($count)->create()
            ->concat([User::factory()->johnDoe()->create()]);
    }
}
