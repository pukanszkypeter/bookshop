<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->truncate();

        for($i = 1; $i <= 5; $i++) {
            User::factory()->create([
                'name' => 'olvaso' . $i,
                'email' => 'olvaso' . $i . '@szerveroldali.hu',
                'password' => Hash::make('password'),
                'is_librarian' => false,
            ]);
        }

        for($i = 1; $i <= 5; $i++) {
            User::factory()->create([
                'name' => 'konyvtaros' . $i,
                'email' => 'konyvtaros' . $i . '@szerveroldali.hu',
                'password' => Hash::make('password'),
                'is_librarian' => true,
            ]);
        }
    }
}
