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
        //ID = 4
        DB::table('sectors')->insert([
            'name' => 'Estacionamientos',
            'code' => 'EST',
        ]);
        // Tipos
        //ID = 1
        DB::table('types')->insert([
            'name' => 'Local',
        ]);
        //ID = 2
        DB::table('types')->insert([
            'name' => 'Módulo',
        ]);
        //ID = 3
        DB::table('types')->insert([
            'name' => 'Estacionamiento',
        ]);
        //ID = 4
        DB::table('types')->insert([
            'name' => 'Bodega',
        ]);
        //ID = 5
        DB::table('types')->insert([
            'name' => 'Vitrina',
        ]);
        //ID = 6
        DB::table('types')->insert([
            'name' => 'Espacio Común',
        ]);
        //ID = 7
        DB::table('types')->insert([
            'name' => 'Baño Público',
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

        DB::table('locations')->insert([
            'type_id' => 1,
            'sector_id' => 1,
            'partner_id' => null,
            'code' => 'LOC.EXT1'
            ]);
        
        for ($i=1; $i < 4; $i++) { 
            DB::table('locations')->insert([
            'type_id' => 1,
            'sector_id' => 1,
            'partner_id' => null,
            'code' => 'LOC.B'.$i
            ]);
        }

        for ($i=1; $i < 5; $i++) { 
            DB::table('locations')->insert([
            'type_id' => 1,
            'sector_id' => 1,
            'partner_id' => null,
            'code' => 'LOC.BA'.$i
            ]);
        }

        for ($i=1; $i < 4; $i++) { 
            DB::table('locations')->insert([
            'type_id' => 2,
            'sector_id' => 1,
            'partner_id' => null,
            'code' => 'MOD.'.($i === 1 ? 'C' : ($i === 2 ? 'D' : 'E'))
            ]);
        }

        DB::table('locations')->insert([
            'type_id' => 1,
            'sector_id' => 1,
            'partner_id' => null,
            'code' => 'CASINO.1'
            ]);

        for ($i=1; $i < 9; $i++) { 
            if($i === 7) continue;
            DB::table('locations')->insert([
            'type_id' => 4,
            'sector_id' => 1,
            'partner_id' => null,
            'code' => 'BOD.'.$i
            ]);
        }

        DB::table('locations')->insert([
            'type_id' => 4,
            'sector_id' => 1,
            'partner_id' => null,
            'code' => 'BOD.LOC.BA5'
            ]);
        DB::table('locations')->insert([
            'type_id' => 4,
            'sector_id' => 1,
            'partner_id' => null,
            'code' => 'BOD.LOC.BA6'
            ]);
        DB::table('locations')->insert([
            'type_id' => 5,
            'sector_id' => 1,
            'partner_id' => null,
            'code' => 'VIT.LOC.50'
            ]);
        DB::table('locations')->insert([
            'type_id' => 5,
            'sector_id' => 1,
            'partner_id' => null,
            'code' => 'VIT.LOC.51'
            ]);
        DB::table('locations')->insert([
            'type_id' => 5,
            'sector_id' => 1,
            'partner_id' => null,
            'code' => 'VIT.LOC.69'
            ]);
        DB::table('locations')->insert([
            'type_id' => 5,
            'sector_id' => 1,
            'partner_id' => null,
            'code' => 'VIT.1'
            ]);
        DB::table('locations')->insert([
            'type_id' => 6,
            'sector_id' => 1,
            'partner_id' => null,
            'code' => 'EC.KIO1'
            ]);
        DB::table('locations')->insert([
            'type_id' => 6,
            'sector_id' => 1,
            'partner_id' => null,
            'code' => 'EC.BN1'
            ]);
        DB::table('locations')->insert([
            'type_id' => 6,
            'sector_id' => 1,
            'partner_id' => null,
            'code' => 'EC.BN2'
            ]);
        DB::table('locations')->insert([
            'type_id' => 6,
            'sector_id' => 1,
            'partner_id' => null,
            'code' => 'EC.EST1'
            ]);

        //Alameda Santiago
        for ($i=1; $i < 204; $i++) { 
            DB::table('locations')->insert([
            'type_id' => 1,
            'sector_id' => 2,
            'partner_id' => null,
            'code' => 'LOC.'.$i
            ]);
        }
        for ($i=1; $i < 3; $i++) { 
            DB::table('locations')->insert([
            'type_id' => 2,
            'sector_id' => 2,
            'partner_id' => null,
            'code' => 'MOD.EC'.$i
            ]);
        }
        for ($i=2; $i < 4; $i++) { 
            DB::table('locations')->insert([
            'type_id' => 2,
            'sector_id' => 2,
            'partner_id' => null,
            'code' => 'MOD.A'.$i
            ]);
        }
        DB::table('locations')->insert([
            'type_id' => 2,
            'sector_id' => 2,
            'partner_id' => null,
            'code' => 'MOD.C2'
            ]);
        for ($i=4; $i < 8; $i++) {
            if($i === 6) continue;
            DB::table('locations')->insert([
            'type_id' => 2,
            'sector_id' => 2,
            'partner_id' => null,
            'code' => 'MOD.Z'.$i
            ]);
        }
        DB::table('locations')->insert([
            'type_id' => 6,
            'sector_id' => 2,
            'partner_id' => null,
            'code' => 'EC.1'
            ]);
        for ($i=1; $i < 3; $i++) {
            DB::table('locations')->insert([
            'type_id' => 7,
            'sector_id' => 2,
            'partner_id' => null,
            'code' => 'BANO.'.$i
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
        for ($i=1; $i < 7; $i++) {
            if($i === 4 || $i === 5) continue;
            DB::table('locations')->insert([
            'type_id' => 2,
            'sector_id' => 3,
            'partner_id' => null,
            'code' => 'MOD.Z'.$i
            ]);
        }
        DB::table('locations')->insert([
            'type_id' => 7,
            'sector_id' => 3,
            'partner_id' => null,
            'code' => 'BANO.1'
        ]);
    }
}
