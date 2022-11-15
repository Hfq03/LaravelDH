<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $adminRole = Role::create(['name' => 'admin']);
        $editorRole = Role::create(['name' => 'editor']);
        $authorRole = Role::create(['name' => 'author']);

        Permission::create(['name' => 'files.*']);
        Permission::create(['name' => 'files.list']);
        Permission::create(['name' => 'files.create']);
        Permission::create(['name' => 'files.update']);
        Permission::create(['name' => 'files.read']);
        Permission::create(['name' => 'files.delete']);

        Permission::create(['name' => 'places.*']);
        Permission::create(['name' => 'places.list']);
        Permission::create(['name' => 'places.create']);
        Permission::create(['name' => 'places.update']);
        Permission::create(['name' => 'places.read']);
        Permission::create(['name' => 'places.delete']);

        Permission::create(['name' => 'post.*']);
        Permission::create(['name' => 'post.list']);
        Permission::create(['name' => 'post.create']);
        Permission::create(['name' => 'post.update']);
        Permission::create(['name' => 'post.read']);
        Permission::create(['name' => 'post.delete']);

        $adminRole->givePermissionTo(['files.*','places.*','post.*']);
        $editorRole->givePermissionTo(['files.list','files.read','places.list','places.read','post.list','post.read']);
        $authorRole->givePermissionTo(['places.*','post.*']);

        $name  = config('admin.name');
        $admin = User::where('name', $name)->first();
        $admin->assignRole('admin');


    }
}