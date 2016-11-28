<?php

namespace App\Console\Commands;

use Illuminate\Support\Facades\Mail;
use Illuminate\Console\Command;

use App\User;
use App\Role;

use App\Mail\Password;

class InitAdmins extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'init:admins';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Initializes admins on the system';

    /**
     * The roles to avoid injecting onto the initial admin account.
     *
     * Super Administrador
     * Agregar pagos a ubicaciones
     * Modificar pagos a ubicaciones
     * Eliminar pagos a ubicaciones
     * Modificar cobros ya realizados a ubicaciones
     * Eliminar cobros ya realizados a ubicaciones
     *
     * @var array
     */
    private $rolesToAvoid = ['super_admin', 'add_payment', 'modify_payment', 'delete_payment', 'modify_billdetail', 'delete_billdetail'];

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        if(!User::where('username', 'egomez')->count())
        {
            $password = str_random(8);
            $user = new User;
            $user->name = 'Elías Gomez';
            $user->username = 'egomez';
            $user->password = bcrypt($password);
            $user->email = 'egomez@alamedamaipu.cl';
            $user->is_admin = true;

            $user->save();

            $roles = Role::whereNotIn('name', $this->rolesToAvoid)->pluck('id')->toArray();
            $user->roles()->sync($roles);

            Mail::to($user)->queue(new Password($user, $password, true));
            echo 'Account successfully initialized!';
        }
        else
            echo 'Account already initialized';
    }
}
