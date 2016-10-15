<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\MaeCue;

class MaeCueController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->input('vfptable') == null) return MaeCue::all();
        return MaeCue::where('vfptable', $request->input('vfptable'))->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $maecue = MaeCue::create($request->input());

        return response()->json(['status' => true, 'id' => $maecue->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $maecue = MaeCue::find($id);

        if (!$maecue)
            return response()->json(['status' => false, 'message' => 'Record not found'], 404);

        return $maecue;
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
        $maecue = MaeCue::find($id);

        if (!$maecue)
            return response()->json(['status' => false, 'message' => 'Record not found'], 404);
        
        $maecue->fill($request->input())->save();

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
        $maecue = MaeCue::find($id);

        if (!$maecue)
            return response()->json(['status' => false, 'message' => 'Record not found'], 404);

        $maecue->delete();
        return response()->json(['status' => true, 'id' => $id]);
    }
}