<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class CreatePermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            'Product view',
            'Product create',
            'Product show',
            'Product edit',
            'Product delete',
        ];

        foreach ($permissions as $permission) {
            Permission::updateOrCreate(
                [
                    'name' => $permission,
                    'guard_name' => 'web',
                ],
                [
                    'name' => $permission,
                    'guard_name' => 'web',
                ]
            );
        }
    }
}
