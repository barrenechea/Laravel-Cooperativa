<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Sesion;

class SesionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->input('vfptable') == null) return Sesion::all();
        return Sesion::where('vfptable', $request->input('vfptable'))->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $sesion = Sesion::create($request->input());

        return response()->json(['status' => true, 'id' => $sesion->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $sesion = Sesion::find($id);

        if (!$sesion)
            return response()->json(['status' => false, 'message' => 'Record not found'], 404);

        return $sesion;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $sesion = Sesion::find($id);

        if (!$sesion)
            return response()->json(['status' => false, 'message' => 'Record not found'], 404);
        
        $sesion->fill($request->input())->save();

        return response()->json(['status' => true, 'id' => $id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $sesion = Sesion::find($id);

        if (!$sesion)
            return response()->json(['status' => false, 'message' => 'Record not found'], 404);

        $sesion->delete();
        return response()->json(['status' => true, 'id' => $id]);
    }
}
