<?php

namespace App\Http\Controllers;

use App\Http\Requests\tax\StoreRequest;
use App\Http\Requests\tax\UpdateRequest;
use App\Http\Resources\TaxResource;
use App\Tax;

class taxController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Tax::orderBy('id', 'desc')->get();
        return TaxResource::collection($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequest $request)
    {
        $data = $request->except('relations');
        $data = Tax::firstOrCreate($data);

        $res = new TaxResource($data);
        return $res->response()->setStatusCode(201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $find = Tax::find($id);
        if (!$find) return response()->json([
            'success' => false,
            'messages' => 'data not found'
        ], 400);

        return new TaxResource($find);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, $id)
    {
        $find = Tax::find($id);
        if (!$find) return response()->json([
            'success' => false,
            'messages' => 'data not found'
        ], 400);

        $find->update($request->except('relations'));
        
        return $this->show($find->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $find = Tax::find($id);
        if (!$find) return response()->json([
            'success' => false,
            'messages' => 'data not found'
        ], 400);

        $find->items()->sync([]);
        $find->delete();

        return response()->json([
            'success' => true,
            'messages' => "data with $id deleted"
        ]);
    }
}
