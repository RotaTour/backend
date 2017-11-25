<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()['cache']->forget('spatie.permission.cache');
        // create permissions
        Permission::create(['name' => 'all access']);
        Permission::create(['name' => 'create users']);
        Permission::create(['name' => 'edit users']);
        Permission::create(['name' => 'delete users']);
        Permission::create(['name' => 'view users']);

        // create roles and assign existing permissions
        $superuser = Role::create(['name' => 'superuser']);
        $superuser->givePermissionTo('all access');

        $cliente = Role::create(['name' => 'user']);

        $user1 = User::findOrFail(1);
        $user1->assignRole('superuser');

        $user2 = User::findOrFail(2);
        $user2->assignRole('user');
        
    }
}
