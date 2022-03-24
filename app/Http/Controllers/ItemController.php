<?php

namespace App\Http\Controllers;

use App\Http\Requests\Item\StoreRequest;
use App\Http\Requests\Item\UpdateRequest;
use App\Http\Resources\ItemResource;
use App\Item;
use Illuminate\Support\Facades\DB;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Item::orderBy('id', 'desc')->get();
        return ItemResource::collection($data);
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
        $data = Item::firstOrCreate($data);
        
        if ($relations = $request->relations) {
            if ($relations['taxes']) {
                $data->taxes()->sync($relations['taxes']);
            }
        }

        $res = new ItemResource($data);
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
        $find = Item::find($id);
        if (!$find) return response()->json([
            'success' => false,
            'messages' => 'data not found'
        ], 400);

        return new ItemResource($find);
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
        $find = Item::find($id);
        if (!$find) return response()->json([
            'success' => false,
            'messages' => 'data not found'
        ], 400);

        $find->update($request->except('relations'));
        
        if ($relations = $request->relations) {
            if ($relations['taxes']) {
                $find->taxes()->sync($relations['taxes']);
            }
        }
        
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
        $find = Item::find($id);
        if (!$find) return response()->json([
            'success' => false,
            'messages' => 'data not found'
        ], 400);

        $find->taxes()->sync([]);
        $find->delete();

        return response()->json([
            'success' => true,
            'messages' => "data with $id deleted"
        ]);
    }

    public function list()
    {
        // with eloquent
        // $data = Item::orderBy('id', 'desc')->with('taxes')->get();

        // without eloquent
        $path = public_path('getitems.sql');
        $sql = file_get_contents($path);
        $data = DB::select($sql);
        foreach ($data as $key => $value) {
            $data[$key]->taxes = json_decode($value->taxes);
        }

        return response()->json([
            'data' => $data
        ]);
    }
}
