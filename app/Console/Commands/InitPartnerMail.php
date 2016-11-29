<?php

namespace App\Console\Commands;

use Illuminate\Support\Facades\Mail;
use Illuminate\Console\Command;

use App\User;
use App\Role;

use App\Mail\Password;

class InitPartnerMail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'init:partnersmail';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send passwords to Partners';


    private $defaultMail = 'secretaria@alamedamaipu.cl';

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
        $users = User::where('is_admin', false)->where('email', 'NOT LIKE', $this->defaultMail)->get();
        foreach($users as $user)
        {
            $password = str_random(6);
            $user->password = bcrypt($password);
            $user->save();

            Mail::to($user)->queue(new Password($user, $password, true));
        }
        $coopUser = User::where('username', '73923900-1')->first();

        $password = str_random(6);
        $coopUser->password = bcrypt($password);
        $coopUser->save();

        Mail::to($coopUser)->queue(new Password($coopUser, $password, true));

        echo 'Mails successfully queued!';
    }
}
