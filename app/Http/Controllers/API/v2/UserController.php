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
        $admins = User::where('is_admin', true)->with('roles')->get();
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
        $user = User::where('is_admin', true)->where('id', intval($id))->with('roles')->firstOrFail();
        return $user->makeVisible('password')->makeHidden('is_admin')->makeHidden('initialized')->makeHidden('created_at')->makeHidden('updated_at');
    }
}