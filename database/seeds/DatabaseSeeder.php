<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	DB::table('users')->insert([
            'name' => 'Sebastián Barrenechea',
            'username' => 'admin',
            'password' => bcrypt('admin'),
            'email' => 'sebastian@barrenechea.cl',
            'is_admin' = 1,
            'initialized' = 0,
        ]);

        DB::table('roles')->insert([
            'name' => 'can_handle_admins',
            'description' => 'Agregar, modificar y deshabilitar cuentas de Administrador',
        ]);

        DB::table('roles')->insert([
            'name' => 'can_manage_sector_type_location',
            'description' => 'Administrar sectores, tipos y lugares',
        ]);

        DB::table('roles')->insert([
            'name' => 'can_manage_groups',
            'description' => 'Administrar grupos de socios',
        ]);

        DB::table('roles')->insert([
            'name' => 'can_sync_users',
            'description' => 'Sincronizar socios y asociarlos a locales',
        ]);

        DB::table('roles')->insert([
            'name' => 'can_view_data',
            'description' => 'Ver datos de locales y socios',
        ]);

        DB::table('roles')->insert([
            'name' => 'can_view_overdue',
            'description' => 'Ver reportes de socios morosos',
        ]);

        DB::table('roles')->insert([
            'name' => 'can_send_messages',
            'description' => 'Enviar mensajes globales',
        ]);

        DB::table('roles')->insert([
            'name' => 'can_upload',
            'description' => 'Subir documentos',
        ]);

        DB::table('roles')->insert([
            'name' => 'can_external_accounting',
            'description' => 'Contabilidad externa',
        ]);

        DB::table('role_user')->insert([
            'role_id' => 1,
            'user_id' => 1,
        ]);

        DB::table('role_user')->insert([
            'role_id' => 2,
            'user_id' => 1,
        ]);

        DB::table('role_user')->insert([
            'role_id' => 3,
            'user_id' => 1,
        ]);

        DB::table('role_user')->insert([
            'role_id' => 4,
            'user_id' => 1,
        ]);

        DB::table('role_user')->insert([
            'role_id' => 5,
            'user_id' => 1,
        ]);

        DB::table('role_user')->insert([
            'role_id' => 6,
            'user_id' => 1,
        ]);

        DB::table('role_user')->insert([
            'role_id' => 7,
            'user_id' => 1,
        ]);

        DB::table('role_user')->insert([
            'role_id' => 8,
            'user_id' => 1,
        ]);

        DB::table('role_user')->insert([
            'role_id' => 9,
            'user_id' => 1,
        ]);
    }
}
