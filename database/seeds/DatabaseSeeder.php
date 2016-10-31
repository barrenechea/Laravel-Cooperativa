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
        DB::table('logics')->insert([
            'firstoverdue' => 30,
            'secondoverdue' => 60,
        ]);

    	DB::table('users')->insert([
            'name' => 'Sebastián Barrenechea',
            'username' => 'admin',
            'password' => bcrypt('admin'),
            'email' => 'sebastian@barrenechea.cl',
            'is_admin' => 1,
            'initialized' => 1,
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
            'description' => 'Agregar, modificar y deshabilitar cuentas de Socio',
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

        for ($i=1; $i < 10; $i++) { 
            DB::table('role_user')->insert([
            'role_id' => $i,
            'user_id' => 1,
            ]);
        }

        // Sectores
        //ID = 1
        DB::table('sectors')->insert([
            'name' => 'Alameda Maipú',
            'code' => 'AM',
        ]);
        //ID = 2
        DB::table('sectors')->insert([
            'name' => 'Alameda Santiago',
            'code' => 'AS',
        ]);
        //ID = 3
        DB::table('sectors')->insert([
            'name' => 'Sector B',
            'code' => 'SB',
        ]);
        //ID = 1
        DB::table('types')->insert([
            'name' => 'Local',
        ]);
        //ID = 2
        DB::table('types')->insert([
            'name' => 'Módulo',
        ]);

        //Locales
        //Alameda Maipu
        for ($i=1; $i < 85; $i++) { 
            DB::table('locations')->insert([
            'type_id' => 1,
            'sector_id' => 1,
            'partner_id' => null,
            'code' => 'LOC.'.$i
            ]);
        }

        //Alameda Santiago
        for ($i=1; $i < 204; $i++) { 
            DB::table('locations')->insert([
            'type_id' => 1,
            'sector_id' => 2,
            'partner_id' => null,
            'code' => 'LOC.'.$i
            ]);
        }

        //Sector B
        for ($i=1; $i < 33; $i++) { 
            DB::table('locations')->insert([
            'type_id' => 1,
            'sector_id' => 3,
            'partner_id' => null,
            'code' => 'LOC.'.$i
            ]);
        }
        DB::table('locations')->insert([
            'type_id' => 1,
            'sector_id' => 3,
            'partner_id' => null,
            'code' => 'LOC.32A'
        ]);
    }
}
