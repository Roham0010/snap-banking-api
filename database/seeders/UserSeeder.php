<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user1 = User::factory()->create([
            'phone' => config('bankingapi.phone1'),
        ]);

        $user2 = User::factory()->create([
            'phone' => config('bankingapi.phone2'),
        ]);
    }
}
