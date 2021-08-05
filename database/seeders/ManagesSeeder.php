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
            'action' => json_encode([
                'read' => true,
                'add' => true,
                'update' => false,
                'delete' => true
            ]),
        ]);
        // Manage::create([
        //     'menu' => 'menu',
        // ]);
        // Manage::create([
        //     'menu' => 'pages',
        // ]);
    }
}
