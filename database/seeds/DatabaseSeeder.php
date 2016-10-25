<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$user = new User();
    	$user->name = 'Sebastián Barrenechea';
    	$user->username = 'admin';
    	$user->password = bcrypt('admin');
    	$user->email = 'sebastian@barrenechea.cl';
    	$user->is_admin = true;
    	$user->initialized = false;
    	$user->save();

    	$role = new Role();
    	$role->name = 'can_handle_admins';
    	$role->description = 'Agregar, modificar y deshabilitar cuentas de Administrador';
    	$role->save();

    	$role = new Role();
    	$role->name = 'can_manage_sector_type_location';
    	$role->description = 'Administrar sectores, tipos y lugares';
    	$role->save();

    	$role = new Role();
    	$role->name = 'can_manage_groups';
    	$role->description = 'Administrar grupos de socios';
    	$role->save();

    	$role = new Role();
    	$role->name = 'can_sync_users';
    	$role->description = 'Sincronizar socios y asociarlos a locales';
    	$role->save();

    	$role = new Role();
    	$role->name = 'can_view_data';
    	$role->description = 'Ver datos de locales y socios';
    	$role->save();

    	$role = new Role();
    	$role->name = 'can_view_overdue';
    	$role->description = 'Ver reportes de socios morosos';
    	$role->save();

    	$role = new Role();
    	$role->name = 'can_send_messages';
    	$role->description = 'Enviar mensajes globales';
    	$role->save();

    	$role = new Role();
    	$role->name = 'can_upload';
    	$role->description = 'Subir documentos';
    	$role->save();

    	$role = new Role();
    	$role->name = 'can_external_accounting';
    	$role->description = 'Contabilidad externa';
    	$role->save();

    	$user->roles()->sync([1,2,3,4,5,6,7,8,9]);
    }
}
