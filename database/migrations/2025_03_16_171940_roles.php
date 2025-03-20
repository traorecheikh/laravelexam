<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Role::create(['name' => 'gestionnaire']);
        Role::create(['name' => 'client']);
        Permission::create(['name' => 'gerer burgers']);
        Permission::create(['name' => 'gerer commandes']);
        Permission::create(['name' => 'gerer ']);
        $role = Role::findByName('gestionnaire');
        $role->givePermissionTo('gerer burgers');
        $role->givePermissionTo('gerer commandes');
        $role = Role::findByName('client');

        $user = User::create([
            'name' => "admin",
            'email' => "admin@gmail.com",
            'password' => Hash::make("passer"),
        ]);
        $user->assignRole('gestionnaire');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Role::destroy('gestionnaire');
        Role::destroy('client');
        Permission::destroy('gerer burgers');
        Permission::destroy('gerer commandes');
        Permission::destroy('gerer ');
    }
};
