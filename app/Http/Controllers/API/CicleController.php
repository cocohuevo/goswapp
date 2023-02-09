<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Cicle;

class CicleController extends Controller
{
    public $successStatus = 200;

    public function index()
    {
        $cicles = Cicle::all();
        return response()->json(['Ciclos' => $cicles->toArray()], $this->successStatus);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'name'=>'required',
            'description'=>'required',
        ]);
        if($validator->fails()){
            return response()->json(['error' => $validator->errors()], 401);       
        }
        $cicle = Cicle::create($input);
        return response()->json(['Cicle' => $cicle->toArray()], $this->successStatus);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $cicle = Cicle::find($cicle->id);
        if (is_null($cicle)) {
            return response()->json(['error' => $validator->errors()], 401);
        }
        return response()->json(['Ciclo' => $cicle->toArray()], $this->successStatus);
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
        $input = $request->all();
        $validator = Validator::make($input, [
            'name'=>'required',
            'description'=>'required',
        ]);
        if($validator->fails()){
            return response()->json(['error' => $validator->errors()], 401);       
        }
        $cicle->name= $input['name'];
        $cicle->description= $input['description'];
        $cicle->save();
        return response()->json(['Cicle' => $cicle->toArray()], $this->successStatus);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $cicle->delete();
        return response()->json(['Cicle' => $cicle->toArray()], $this->successStatus);
    }

}