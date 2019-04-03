<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Table;
use Validator;

class TablesController extends Controller
{
    public function store(Request $request){
  
        $input = $request->all();

        $validator = Validator::make($input, [
            'number' => 'required',
            'capacity' => 'required',
            'location_table_id' => 'required'
        ]);
    
        if ($validator->fails()) {
            return response()->json( [ 'error'=>$validator->errors() ], 422);
        }

        $table = [];
        $table = Table::where( 'number', $input[ 'number' ] )->first();
        if (isset( $table ) ) {
            return response()->json( [ 'message'=>'The table number alredy exist' ], 422 );
        }
        $table = Table::create( $input ) ;

        return response()->json( [ 'Table' => $table ], 200 );
    }

    public function index() {
        // $tables = Table::join('locations_tables', 'locations_tables.id', '=', 'tables.location_table_id')
        // ->get( [ 'tables.id', 'tables.number', 'tables.capacity',
        // 'tables.location_table_id', 'locations_tables.description' ] );        
        $tables = Table::with('LocationTable')->get();
        
        return response()->json( [ 'Tables' => $tables ], 200 );
    }
    
    public function show( $id) {
        $tables = Table::where( 'id', $id )
            ->with('LocationTable')->get();
        
        return response()->json( [ 'Tables' => $tables ], 200 );
    }

    
    public function destroy($id){
        $table = Table::find($id);
        if(isset($table)){
            $table->delete();
            return response()->json(['Message'=>'succefully delete']);
        }    
        else
            return response()->json(['Message'=>'No exist table']);
    }

    public function update(Request $request, $id){
        
        $input = $request->all();

        $validator = Validator::make($input, [
            'number' => 'required',
            'capacity' => 'required',
            'location_table_id' => 'required'
        ]);
    
        if ($validator->fails()) {
            return response()->json( [ 'error'=>$validator->errors() ], 422);
        }

        $tables = [];
        $tables = Table::where( 
            'number', $input[ 'number' ] )
            ->where('id', '!==' , $id)
            ->first();
        if (isset( $tables ) ) {
            return response()->json( [ 'message'=>'The table number alredy exist' ], 422 );
        }

        $tables = Table::find( $id ) ;
        $tables->fill( $input );
        $tables->save();

        $tables = Table::where( 'id', $id )
            ->with('LocationTable')->get();
        
        return response()->json( [ 'Tables' => $tables ], 200 );
    }
}
