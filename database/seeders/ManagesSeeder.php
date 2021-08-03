<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Manage;

class ManagesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Manage::create([
            'menu' => 'image',
        ]);
        Manage::create([
            'menu' => 'menu',
        ]);
        Manage::create([
            'menu' => 'pages',
        ]);
    }
}
