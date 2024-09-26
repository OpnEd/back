<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    protected static ?string $password;
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $role1 = Role::create(['name' => 'admin']);
        $role2 = Role::create(['name' => 'medico']);
        $role3 = Role::create(['name' => 'cliente']);

        $permission1 = Permission::create(['name' => 'create users']);
        $permission2 = Permission::create(['name' => 'create patients']);
        $permission3 = Permission::create(['name' => 'create history']);

        $role1->givePermissionTo($permission1);
        $role2->givePermissionTo($permission2);
        $role3->givePermissionTo($permission3);

        $user = User::create([
            'name' => 'Paola Suárez',
            'card_id' => '1032397897',
            'card_id_type' => 'Cédula de Ciudadanía',
            'email' => 'paola@gmail.com',
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
            'team_id' => 1
        ]);

        $user2 = User::create([
            'name' => 'Ricardo Avarez',
            'card_id' => '98637806',
            'card_id_type' => 'Cédula de Ciudadanía',
            'email' => 'rialmon@gmail.com',
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
            'team_id' => 1
        ]);

        $user3 = User::create([
            'name' => 'Veso Alsua',
            'card_id' => '1021636003',
            'card_id_type' => 'Cédula de Ciudadanía',
            'email' => 'veso@gmail.com',
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
            'team_id' => 1
        ]);

        $user4 = User::create([
            'name' => 'Maria Antonieta',
            'card_id' => '1021636006',
            'card_id_type' => 'Cédula de Ciudadanía',
            'email' => 'veso1@gmail.com',
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
            'team_id' => 2
        ]);

        $user5 = User::create([
            'name' => 'Chompiras Alfonso',
            'card_id' => '1021636008',
            'card_id_type' => 'Cédula de Ciudadanía',
            'email' => 'veso2@gmail.com',
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
            'team_id' => 2
        ]);

        $user6 = User::create([
            'name' => 'Mac Guiver',
            'card_id' => '1021636009',
            'card_id_type' => 'Cédula de Ciudadanía',
            'email' => 'veso3@gmail.com',
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
            'team_id' => 2
        ]);

        $user->assignRole('admin');
        $user2->assignRole('medico');
        $user3->assignRole('cliente');

        $user4->assignRole('admin');
        $user5->assignRole('medico');
        $user6->assignRole('cliente');
    }
}
