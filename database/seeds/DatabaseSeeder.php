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
				'name' => 'Super Administrador',
				'username' => 'admin',
				'password' => bcrypt('admin'),
				'email' => 'admin@alamedamaipu.cl',
				'is_admin' => 1,
				'initialized' => 1,
				]);

				// id = 1
			DB::table('roles')->insert([
				'name' => 'super_admin',
				'description' => 'Laravel Super Administrator',
				]);

			DB::table('roles')->insert([
				'name' => 'view_list_admin',
				'description' => 'Ver listado de Administradores',
				]);

			DB::table('roles')->insert([
				'name' => 'create_admin_account',
				'description' => 'Agregar cuentas de Administrador',
				]);

			DB::table('roles')->insert([
				'name' => 'modify_admin_account',
				'description' => 'Modificar y deshabilitar cuentas de Administrador',
				]);

			DB::table('roles')->insert([
				'name' => 'restore_password_admin_account',
				'description' => 'Reestablecer contraseñas a cuentas de Administrador',
				]);

			DB::table('roles')->insert([
				'name' => 'view_list_partner',
				'description' => 'Ver listado de Socios',
				]);

			DB::table('roles')->insert([
				'name' => 'create_partner_account',
				'description' => 'Agregar cuentas de Socio',
				]);

			DB::table('roles')->insert([
				'name' => 'modify_partner_account',
				'description' => 'Modificar y deshabilitar cuentas de Socio',
				]);

			DB::table('roles')->insert([
				'name' => 'restore_password_partner_account',
				'description' => 'Reestablecer contraseñas a cuentas de Socio',
				]);

			DB::table('roles')->insert([
				'name' => 'view_list_sector_type_location',
				'description' => 'Ver sectores, tipos y ubicaciones',
				]);

			DB::table('roles')->insert([
				'name' => 'add_sector',
				'description' => 'Agregar sectores',
				]);

			DB::table('roles')->insert([
				'name' => 'add_type',
				'description' => 'Agregar tipos',
				]);

			DB::table('roles')->insert([
				'name' => 'add_location',
				'description' => 'Agregar ubicaciones',
				]);

			DB::table('roles')->insert([
				'name' => 'view_list_billdetail_payment',
				'description' => 'Ver cobros y pagos de ubicaciones',
				]);

			DB::table('roles')->insert([
				'name' => 'add_payment',
				'description' => 'Agregar pagos a ubicaciones',
				]);

			DB::table('roles')->insert([
				'name' => 'modify_payment',
				'description' => 'Modificar pagos a ubicaciones',
				]);

			DB::table('roles')->insert([
				'name' => 'delete_payment',
				'description' => 'Eliminar pagos a ubicaciones',
				]);

			DB::table('roles')->insert([
				'name' => 'delete_billdetail',
				'description' => 'Eliminar cobros ya realizados a ubicaciones',
				]);

			DB::table('roles')->insert([
				'name' => 'view_list_group',
				'description' => 'Ver grupos en sistema',
				]);

			DB::table('roles')->insert([
				'name' => 'add_group',
				'description' => 'Agregar nuevos grupos',
				]);

			DB::table('roles')->insert([
				'name' => 'modify_group',
				'description' => 'Modificar grupos',
				]);

			DB::table('roles')->insert([
				'name' => 'view_list_bill',
				'description' => 'Ver cobros en sistema',
				]);

			DB::table('roles')->insert([
				'name' => 'add_bill',
				'description' => 'Agregar nuevos cobros',
				]);

			DB::table('roles')->insert([
				'name' => 'modify_bill',
				'description' => 'Modificar cobros',
				]);

			DB::table('roles')->insert([
				'name' => 'new_message',
				'description' => 'Enviar mensajes',
				]);

			DB::table('roles')->insert([
				'name' => 'new_file',
				'description' => 'Subir archivos',
				]);

			DB::table('roles')->insert([
				'name' => 'delete_message_file',
				'description' => 'Eliminar mensajes y archivos',
				]);

			DB::table('roles')->insert([
				'name' => 'modify_overdue',
				'description' => 'Modificar fechas de reportes de morosidad',
				]);

			DB::table('roles')->insert([
				'name' => 'view_report_overdue',
				'description' => 'Ver reportes de morosidad',
				]);

			DB::table('roles')->insert([
				'name' => 'view_report_external_accounting',
				'description' => 'Contabilidad externa',
				]);

			DB::table('roles')->insert([
				'name' => 'view_log',
				'description' => 'Ver registro de actividad (para auditorías)',
				]);

			DB::table('roles')->insert([
				'name' => 'view_systeminfo',
				'description' => 'Ver información del sistema',
				]);

			DB::table('roles')->insert([
				'name' => 'mail_ssd_warning',
				'description' => 'Configurar alertas de tope del servidor',
				]);

				// Laravel Administrator is Super Admin
			DB::table('role_user')->insert([
				'role_id' => 1,
				'user_id' => 1,
				]);

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

			for ($i=1; $i < 7; $i++) { 
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

			//Estacionamientos
			for ($i=1; $i < 59; $i++) { 
				DB::table('locations')->insert([
					'type_id' => 3,
					'sector_id' => 4,
					'partner_id' => null,
					'code' => 'EST.'.$i
					]);
			}
		}
	}