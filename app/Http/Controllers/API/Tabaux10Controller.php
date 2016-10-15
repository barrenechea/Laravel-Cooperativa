<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Tabaux10;

class Tabaux10Controller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->input('vfptable') == null) return Tabaux10::all();
        return Tabaux10::where('vfptable', $request->input('vfptable'))->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $filtered = $request->input();
        $filtered['concredito'] = filter_var($filtered['concredito'], FILTER_VALIDATE_BOOLEAN);

        $tabaux10 = Tabaux10::create($filtered);

        return response()->json(['status' => true, 'id' => $tabaux10->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $tabaux10 = Tabaux10::find($id);

        if (!$tabaux10)
            return response()->json(['status' => false, 'message' => 'Record not found'], 404);

        return $tabaux10;
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
        $tabaux10 = Tabaux10::find($id);

        if (!$tabaux10)
            return response()->json(['status' => false, 'message' => 'Record not found'], 404);
        
        $filtered = $request->input();
        $filtered['concredito'] = filter_var($filtered['concredito'], FILTER_VALIDATE_BOOLEAN);

        $tabaux10->fill($filtered)->save();

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
        $tabaux10 = Tabaux10::find($id);

        if (!$tabaux10)
            return response()->json(['status' => false, 'message' => 'Record not found'], 404);

        $tabaux10->delete();
        return response()->json(['status' => true, 'id' => $id]);
    }
}
