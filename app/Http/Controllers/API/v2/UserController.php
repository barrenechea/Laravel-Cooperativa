<?php

namespace App\Http\Controllers\API\v2;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\User;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $admins = User::where('is_admin', true)->whereHas('roles', function($query) {
            $query->whereIn('name', ['super_admin', 'view_list_billdetail_payment', 'add_payment', 'modify_payment', 'delete_payment', 'view_report_external_accounting', 'view_log']);
        })->with('roles')->get();
        return $admins->makeVisible('password')->makeHidden('is_admin')->makeHidden('initialized')->makeHidden('created_at')->makeHidden('updated_at');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {   
        $user = User::where('is_admin', true)->where('id', intval($id))->whereHas('roles', function($query) {
            $query->whereIn('name', ['super_admin', 'view_list_billdetail_payment', 'add_payment', 'modify_payment', 'delete_payment', 'view_report_external_accounting', 'view_log']);
        })->with('roles')->firstOrFail();
        return $user->makeVisible('password')->makeHidden('is_admin')->makeHidden('initialized')->makeHidden('created_at')->makeHidden('updated_at');
    }
}