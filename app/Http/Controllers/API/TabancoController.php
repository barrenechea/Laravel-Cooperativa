<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Tabanco;

class TabancoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->input('vfptable') == null) return Tabanco::all();
        return Tabanco::where('vfptable', $request->input('vfptable'))->get();
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
        $filtered['estado'] = filter_var($filtered['estado'], FILTER_VALIDATE_BOOLEAN);
        $filtered['flg_ing'] = filter_var($filtered['flg_ing'], FILTER_VALIDATE_BOOLEAN);

        $tabanco = Tabanco::create($filtered);

        return response()->json(['status' => true, 'id' => $tabanco->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $tabanco = Tabanco::find($id);

        if (!$tabanco)
            return response()->json(['status' => false, 'message' => 'Record not found'], 404);

        return $tabanco;
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
        $tabanco = Tabanco::find($id);

        if (!$tabanco)
            return response()->json(['status' => false, 'message' => 'Record not found'], 404);
        
        $filtered = $request->input();
        $filtered['estado'] = filter_var($filtered['estado'], FILTER_VALIDATE_BOOLEAN);
        $filtered['flg_ing'] = filter_var($filtered['flg_ing'], FILTER_VALIDATE_BOOLEAN);

        $tabanco->fill($filtered)->save();

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
        $tabanco = Tabanco::find($id);

        if (!$tabanco)
            return response()->json(['status' => false, 'message' => 'Record not found'], 404);

        $tabanco->delete();
        return response()->json(['status' => true, 'id' => $id]);
    }
}
