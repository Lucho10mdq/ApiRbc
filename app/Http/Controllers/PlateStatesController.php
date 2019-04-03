<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PlateState;
use Validator;

class PlateStatesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        $plateState = PlateState::all();

        return Response()->json(['PlateState' => $plateState], 200);

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
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'description' => 'required',
        ]);
    
        if ($validator->fails()) {
            return response()->json( [ 'message' => $validator->errors() ], 422);
        }

        $plateState = [];
        $plateState = PlateState::where('description',$request->description)->first();
        if (isset( $plateState ) ) {
            return response()->json( [ 'message' => 'The description alredy exist' ], 422 );
        }   

        $plateState = new PlateState();
        $plateState->description = $request->description;
        $plateState->save();

        return response()->json(['plateState' => $plateState], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $plateState = PlateState::find( $id );
        return response()->json( [ 'PlateStates' => $plateState ], 200 );
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
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'description' => 'required',
        ]);
    
        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()], 422);
        }

        $plateState = PlateState::find( $id );
        $plateState->description = $request->description;
        $plateState->save();

        return response()->json(['PlateState' => $plateState], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
