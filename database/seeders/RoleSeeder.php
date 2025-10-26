<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
// Create Permissions (if needed, but for this case, roles are enough)
// Example: Permission::create(['name' => 'create carreras']);
// Create Roles
$Roladmin = Role::firstOrCreate(['name' => 'admin']);
$Rolprofesor = Role::firstOrCreate(['name' => 'profesor']);
$Rolestudiante = Role::firstOrCreate(['name' => 'estudiante']);
// Create Admin User
$admin = User::firstOrCreate(
['usMail' => 'admin@example.com'],
[   
'usPassword' => Hash::make('password'), // Cambia 'password' por una contraseña segura
    'usDocumento'=> '12345678',
    'usApellido'=>'admin',
    'usNombre'=>'admin',
    'usTelefono'=>'0303456',
    'usDomicilio'=>'calle falsa 123',
    'usLocalidad'=>'Galarza',
]
);
$admin->assignRole($Roladmin);
// Create an example Profesor user
$profesor = User::firstOrCreate(
['usMail' => 'profesor@example.com'],
[
    'usPassword' => Hash::make('password'), // Cambia 'password' por una contraseña segura
    'usDocumento'=> '12345678',
    'usApellido'=>'profesor',
    'usNombre'=>'profesor',
    'usTelefono'=>'0303456',
    'usDomicilio'=>'calle falsa 123',
    'usLocalidad'=>'Galarza',
]
);
$profesor->assignRole($Rolprofesor);

// Create an example Estudiante user
$estudiante = User::firstOrCreate(
['usMail' => 'estudiante@example.com'],
[
'usPassword' => Hash::make('password'), // Cambia 'password' por una contraseña segura
    'usDocumento'=> '12345678',
    'usApellido'=>'estudiante',
    'usNombre'=>'estudiante',
    'usTelefono'=>'0303456',
    'usDomicilio'=>'calle falsa 123',
    'usLocalidad'=>'Galarza',
]
);
$estudiante->assignRole($Rolestudiante);
$this->command->info('Roles and initial users created successfully!');
}
}



