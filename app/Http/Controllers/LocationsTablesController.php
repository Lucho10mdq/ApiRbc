<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\LocationTable;
use Validator;

class LocationsTablesController extends Controller
{
    public function store(Request $request){
        $input = $request->all();
        // var_dump($request); die();
        $validator = Validator::make($input, [
            'description' => 'required',
        ]);
    
        if ($validator->fails()) {
            return response()->json( [ 'message' => $validator->errors() ], 422);
        }

        $locationTable = [];
        $locationTable = LocationTable::where( 'description', $input[ 'description' ] )->first();
        if (isset( $locationTable ) ) {
            return response()->json( [ 'message' => 'The description alredy exist' ], 422 );
        }        
        
        $locationTable = LocationTable::create( $input ) ;

        return response()->json( [ 'Location_Table' => $locationTable ], 200 );
    }

    public function index() {
        $locationsTables = LocationTable::all();
        return response()->json( [ 'Locations_Tables' => $locationsTables ], 200 );
    }

    public function show( $id) {
        $locationsTables = LocationTable::find( $id ) ;
        return response()->json( [ 'Locations_Tables' => $locationsTables ], 200 );
    }

    public function update( Request $request, $id ) {
        $input = $request->all();
        $validator = Validator::make( $input, [
            'description' => 'required',
        ] );
    
        if ($validator->fails()) {
            return response()->json( [ 'message' => $validator->errors() ], 422);
        }

        $locationsTable = LocationTable::find( $id ) ;
        $locationsTable->fill( $input );
        $locationsTable->save();

        // otra forma
        // $locationsTable = LocationTable::updateOrCreate(
        //     [ 'id' => $id ],
        //     $input
        // );

        return $locationsTable;
    }
}
