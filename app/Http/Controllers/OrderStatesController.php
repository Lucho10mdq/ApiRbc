<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\OrderState;
use Validator;

class OrderStatesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orderState = orderState::all();

        return Response()->json(['OrderState' => $orderState], 200);

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
        $orderState = [];
        $orderState = OrderState::where('description',$request->description)->first();
        if (isset( $orderState ) ) {
            return response()->json( [ 'message' => 'The description alredy exist' ], 422 );
        }   
        $orderState = new OrderState();
        $orderState->description = $request->description;
        $orderState->save();

        return response()->json(['OrderState' => $orderState], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $orderState = OrderState::find( $id );
        return response()->json( [ 'OrderStates' => $orderState ], 200 );
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

        $orderState = OrderState::find( $id );
        $orderState->description = $request->description;
        $orderState->save();

        return response()->json(['OrderState' => $orderState], 200);

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
