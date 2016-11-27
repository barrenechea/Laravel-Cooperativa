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
			'name' => 'modify_billdetail',
			'description' => 'Modificar cobros ya realizados a ubicaciones',
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
			'name' => 'nofify_bill',
			'description' => 'Configurar notificaciones para el término de cobros',
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
			'description' => 'Contabilidad',
			]);

		DB::table('roles')->insert([
			'name' => 'view_systeminfo',
			'description' => 'Ver información del sistema',
			]);

		DB::table('roles')->insert([
			'name' => 'mail_ssd_warning',
			'description' => 'Configurar alertas de tope del servidor',
			]);

		DB::table('roles')->insert([
			'name' => 'view_log',
			'description' => 'Ver registro de actividad (para auditorías)',
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
		//ID = 8
		DB::table('types')->insert([
			'name' => 'Sala',
			]);

			//Locales
			//Alameda Maipu
		for ($i=1; $i < 85; $i++) { 
			DB::table('locations')->insert([
				'type_id' => 1,
				'sector_id' => 1,
				'partner_id' => null,
				'code' => 'L.'.$i
				]);
		}

		DB::table('locations')->insert([
			'type_id' => 1,
			'sector_id' => 1,
			'partner_id' => null,
			'code' => 'L.EX1'
			]);

		for ($i=1; $i < 4; $i++) { 
			DB::table('locations')->insert([
				'type_id' => 1,
				'sector_id' => 1,
				'partner_id' => null,
				'code' => 'L.B'.$i
				]);
		}

		for ($i=1; $i < 7; $i++) { 
			DB::table('locations')->insert([
				'type_id' => 1,
				'sector_id' => 1,
				'partner_id' => null,
				'code' => 'L.BA'.$i
				]);
		}

		DB::table('locations')->insert([
			'type_id' => 1,
			'sector_id' => 1,
			'partner_id' => null,
			'code' => 'L.CAS'
			]);

		for ($i=1; $i < 4; $i++) { 
			DB::table('locations')->insert([
				'type_id' => 2,
				'sector_id' => 1,
				'partner_id' => null,
				'code' => 'M.'.($i === 1 ? 'C' : ($i === 2 ? 'D' : 'E'))
				]);
		}

		for ($i=1; $i < 9; $i++) { 
			if($i === 7) continue;
			DB::table('locations')->insert([
				'type_id' => 4,
				'sector_id' => 1,
				'partner_id' => null,
				'code' => 'B.'.$i
				]);
		}

		DB::table('locations')->insert([
			'type_id' => 4,
			'sector_id' => 1,
			'partner_id' => null,
			'code' => 'B.BA5'
			]);
		DB::table('locations')->insert([
			'type_id' => 4,
			'sector_id' => 1,
			'partner_id' => null,
			'code' => 'B.BA6'
			]);
		DB::table('locations')->insert([
			'type_id' => 5,
			'sector_id' => 1,
			'partner_id' => null,
			'code' => 'V.50'
			]);
		DB::table('locations')->insert([
			'type_id' => 5,
			'sector_id' => 1,
			'partner_id' => null,
			'code' => 'V.51'
			]);
		DB::table('locations')->insert([
			'type_id' => 5,
			'sector_id' => 1,
			'partner_id' => null,
			'code' => 'V.52'
			]);
		DB::table('locations')->insert([
			'type_id' => 5,
			'sector_id' => 1,
			'partner_id' => null,
			'code' => 'V.74'
			]);
		DB::table('locations')->insert([
			'type_id' => 6,
			'sector_id' => 1,
			'partner_id' => null,
			'code' => 'E.KIO'
			]);
		DB::table('locations')->insert([
			'type_id' => 6,
			'sector_id' => 1,
			'partner_id' => null,
			'code' => 'E.BN1'
			]);
		DB::table('locations')->insert([
			'type_id' => 6,
			'sector_id' => 1,
			'partner_id' => null,
			'code' => 'E.BN2'
			]);
		DB::table('locations')->insert([
			'type_id' => 6,
			'sector_id' => 1,
			'partner_id' => null,
			'code' => 'E.BN3'
			]);
		DB::table('locations')->insert([
			'type_id' => 6,
			'sector_id' => 1,
			'partner_id' => null,
			'code' => 'E.ET1'
			]);

		DB::table('locations')->insert([
			'type_id' => 7,
			'sector_id' => 1,
			'partner_id' => null,
			'code' => 'BO.1P'
			]);

			//Alameda Santiago
		for ($i=1; $i < 204; $i++) { 
			DB::table('locations')->insert([
				'type_id' => 1,
				'sector_id' => 2,
				'partner_id' => null,
				'code' => 'L.'.$i
				]);
		}
		for ($i=1; $i < 3; $i++) { 
			DB::table('locations')->insert([
				'type_id' => 2,
				'sector_id' => 2,
				'partner_id' => null,
				'code' => 'M.EC'.$i
				]);
		}
		for ($i=2; $i < 4; $i++) { 
			DB::table('locations')->insert([
				'type_id' => 2,
				'sector_id' => 2,
				'partner_id' => null,
				'code' => 'M.A'.$i
				]);
		}
		DB::table('locations')->insert([
			'type_id' => 2,
			'sector_id' => 2,
			'partner_id' => null,
			'code' => 'M.C2'
			]);
		for ($i=4; $i < 8; $i++) {
			if($i === 6) continue;
			DB::table('locations')->insert([
				'type_id' => 2,
				'sector_id' => 2,
				'partner_id' => null,
				'code' => 'M.Z'.$i
				]);
		}

		DB::table('locations')->insert([
			'type_id' => 7,
			'sector_id' => 2,
			'partner_id' => null,
			'code' => 'BO.1P'
			]);

		DB::table('locations')->insert([
			'type_id' => 7,
			'sector_id' => 2,
			'partner_id' => null,
			'code' => 'BO.2P'
			]);

		DB::table('locations')->insert([
			'type_id' => 8,
			'sector_id' => 2,
			'partner_id' => null,
			'code' => 'SALA'
			]);

			//Sector B
		for ($i=1; $i < 33; $i++) { 
			DB::table('locations')->insert([
				'type_id' => 1,
				'sector_id' => 3,
				'partner_id' => null,
				'code' => 'L.'.$i
				]);
		}
		DB::table('locations')->insert([
			'type_id' => 1,
			'sector_id' => 3,
			'partner_id' => null,
			'code' => 'L.32A'
			]);
		for ($i=1; $i < 7; $i++) {
			if($i === 4 || $i === 5) continue;
			DB::table('locations')->insert([
				'type_id' => 2,
				'sector_id' => 3,
				'partner_id' => null,
				'code' => 'M.Z'.$i
				]);
		}

		DB::table('locations')->insert([
			'type_id' => 7,
			'sector_id' => 3,
			'partner_id' => null,
			'code' => 'BO.1P'
			]);

		//Estacionamientos
		for ($i=1; $i < 59; $i++) { 
			DB::table('locations')->insert([
				'type_id' => 3,
				'sector_id' => 4,
				'partner_id' => null,
				'code' => $i
				]);
		}

		//Bills
		// ID = 1
		DB::table('bills')->insert([
			'payment_day' => 21,
			'amount' => 7.05,
			'is_uf' => 1,
			'description' => 'Crédito Hipotecario BancoEstado',
			'vfpcode' => '51-01-006',
			'vfpcode_destination' => '11-02-006',
			'overdue_day' => 20,
			'overdue_amount' => 25500,
			'overdue_is_uf' => 0,
			'overdue_is_daily' => 0,
			'overdue_vfpcode' => '52-01-005',
			'active' => 1,
			'end_bill' => null,
			'end_bill_notified' => 0,
			'created_at' => \Carbon\Carbon::now(),
			'updated_at' => \Carbon\Carbon::now(),
			'deleted_at' => null
			]);

		// ID = 2
		DB::table('bills')->insert([
			'payment_day' => 21,
			'amount' => 115400,
			'is_uf' => 0,
			'description' => 'Crédito Hipotecario Banco Scotiabank',
			'vfpcode' => '51-01-004',
			'vfpcode_destination' => '11-02-002',
			'overdue_day' => 20,
			'overdue_amount' => 9000,
			'overdue_is_uf' => 0,
			'overdue_is_daily' => 0,
			'overdue_vfpcode' => '52-01-005',
			'active' => 1,
			'end_bill' => '2016-12-20',
			'end_bill_notified' => 0,
			'created_at' => \Carbon\Carbon::now(),
			'updated_at' => \Carbon\Carbon::now(),
			'deleted_at' => null
			]);

		// ID = 3
		DB::table('bills')->insert([
			'payment_day' => 26,
			'amount' => 35000,
			'is_uf' => 0,
			'description' => 'Cuota Social',
			'vfpcode' => '51-01-003',
			'vfpcode_destination' => '11-02-008',
			'overdue_day' => 25,
			'overdue_amount' => 5000,
			'overdue_is_uf' => 0,
			'overdue_is_daily' => 0,
			'overdue_vfpcode' => '52-01-005',
			'active' => 1,
			'end_bill' => null,
			'end_bill_notified' => 0,
			'created_at' => \Carbon\Carbon::now(),
			'updated_at' => \Carbon\Carbon::now(),
			'deleted_at' => null
			]);

		// ID = 4
		DB::table('bills')->insert([
			'payment_day' => 26,
			'amount' => 50000,
			'is_uf' => 0,
			'description' => 'Gasto Común A. Santiago',
			'vfpcode' => '51-01-103',
			'vfpcode_destination' => '11-02-007',
			'overdue_day' => 25,
			'overdue_amount' => 5000,
			'overdue_is_uf' => 0,
			'overdue_is_daily' => 0,
			'overdue_vfpcode' => '52-01-003',
			'active' => 1,
			'end_bill' => null,
			'end_bill_notified' => 0,
			'created_at' => \Carbon\Carbon::now(),
			'updated_at' => \Carbon\Carbon::now(),
			'deleted_at' => null
			]);

		// ID = 5
		DB::table('bills')->insert([
			'payment_day' => 11,
			'amount' => 50000,
			'is_uf' => 0,
			'description' => 'Gasto Común A. Maipú',
			'vfpcode' => '51-01-103',
			'vfpcode_destination' => '11-02-001',
			'overdue_day' => 10,
			'overdue_amount' => 4500,
			'overdue_is_uf' => 0,
			'overdue_is_daily' => 0,
			'overdue_vfpcode' => '52-01-003',
			'active' => 1,
			'end_bill' => null,
			'end_bill_notified' => 0,
			'created_at' => \Carbon\Carbon::now(),
			'updated_at' => \Carbon\Carbon::now(),
			'deleted_at' => null
			]);

		// ID = 6
		DB::table('bills')->insert([
			'payment_day' => 10,
			'amount' => 40000,
			'is_uf' => 0,
			'description' => 'Estacionamiento',
			'vfpcode' => '52-01-004',
			'vfpcode_destination' => '11-02-004',
			'overdue_day' => null,
			'overdue_amount' => null,
			'overdue_is_uf' => null,
			'overdue_is_daily' => null,
			'overdue_vfpcode' => null,
			'active' => 1,
			'end_bill' => null,
			'end_bill_notified' => 0,
			'created_at' => \Carbon\Carbon::now(),
			'updated_at' => \Carbon\Carbon::now(),
			'deleted_at' => null
			]);

		DB::table('bill_sector')->insert([
			'bill_id' => 1,
			'sector_id' => 2
			]);

		DB::table('bill_sector')->insert([
			'bill_id' => 2,
			'sector_id' => 1
			]);

		DB::table('bill_sector')->insert([
			'bill_id' => 3,
			'sector_id' => 1
			]);

		DB::table('bill_sector')->insert([
			'bill_id' => 3,
			'sector_id' => 2
			]);

		DB::table('bill_sector')->insert([
			'bill_id' => 4,
			'sector_id' => 2
			]);

		DB::table('bill_sector')->insert([
			'bill_id' => 5,
			'sector_id' => 1
			]);

		DB::table('bill_sector')->insert([
			'bill_id' => 6,
			'sector_id' => 4
			]);

		DB::table('bill_type')->insert([
			'bill_id' => 1,
			'type_id' => 1
			]);

		DB::table('bill_type')->insert([
			'bill_id' => 2,
			'type_id' => 1
			]);

		DB::table('bill_type')->insert([
			'bill_id' => 2,
			'type_id' => 2
			]);

		DB::table('bill_type')->insert([
			'bill_id' => 3,
			'type_id' => 1
			]);

		DB::table('bill_type')->insert([
			'bill_id' => 4,
			'type_id' => 1
			]);

		DB::table('bill_type')->insert([
			'bill_id' => 4,
			'type_id' => 2
			]);

		DB::table('bill_type')->insert([
			'bill_id' => 5,
			'type_id' => 1
			]);

		DB::table('bill_type')->insert([
			'bill_id' => 5,
			'type_id' => 2
			]);

		DB::table('bill_type')->insert([
			'bill_id' => 6,
			'type_id' => 3
			]);
	}
}