<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@ppdb.test'],
            [
                'name' => 'Administrator PPDB',
                'role' => 'admin',
                'password' => 'password',
            ],
        );

        foreach (['MTs' => 'admin.mts@ppdb.test', 'MA' => 'admin.ma@ppdb.test', 'SMK' => 'admin.smk@ppdb.test'] as $jenjang => $email) {
            User::updateOrCreate(
                ['email' => $email],
                [
                    'name' => 'Admin '.$jenjang.' PPDB',
                    'role' => 'admin',
                    'jenjang' => $jenjang,
                    'password' => 'password',
                ],
            );
        }
    }
}
