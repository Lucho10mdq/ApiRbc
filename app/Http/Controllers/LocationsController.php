<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Location;
use Validator;

class LocationsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $locations = Location::all();
        return response()->json( [ 'Locations' => $locations ], 200 );
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
        $input = $request->all();
        // var_dump($request); die();
        $validator = Validator::make($input, [
            'description' => 'required',
        ]);
    
        if ($validator->fails()) {
            return response()->json( [ 'message' => $validator->errors() ], 422);
        }

        $location = [];
        $location = Location::where( 'description', $input[ 'description' ] )->first();
        if (isset( $location ) ) {
            return response()->json( [ 'message' => 'The description alredy exist' ], 422 );
        }        
        
        $location = Location::create( $input ) ;

        return response()->json( [ 'Location' => $location ], 200 );
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $locations = Location::find( $id ) ;
        return response()->json( [ 'Locations' => $locations ], 200 );
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
        $input = $request->all();
        $validator = Validator::make( $input, [
            'description' => 'required',
        ] );
    
        if ($validator->fails()) {
            return response()->json( [ 'message' => $validator->errors() ], 422);
        }

        $locations = Location::find( $id ) ;
        $locations->fill( $input );
        $locations->save();

        return $locations;
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
