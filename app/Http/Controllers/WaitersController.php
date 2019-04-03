<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Waiter;
use App\People;
use App\LocationTable;
use Validator;

class WaitersController extends Controller
{
    public function store(Request $request){
     
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'doc' => 'required',
            'code' => 'required',
        ]);
    
        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()], 422);
        }

        $people = [];
        $people =People::where('doc',$request->doc)->first();
        if (isset( $people ) ) {
            return response()->json( [ 'message'=>'The doc number alredy exist' ], 422 );
        }
        $waiter =Waiter::where('code',$request->code)->first();
        if (isset( $waiter ) ) {
            return response()->json( [ 'message'=>'The waiter code alredy exist' ], 422 );
        }

        $people = new People();
        $people->name = $request->name;
        $people->doc = $request->doc;
        $people->address = $request->address;
        $people->phone = $request->phone;
        $people->email = $request->email;
        $people->save();
        $waiter = new Waiter();
        
        $waiter->people_id = $people->id ;
        $waiter->code = $request->code ;
        $waiter->save() ;

        //$locationTable = LocationTable::find($request->locations_tables->id);
   
      //saco el valor de cada elemento
         $waiter->locationsTables()->sync($request->locations_tables);
      
        

        // $waiters = Waiter::join('people', 'people.id', '=', 'waiters.people_id')
        //     ->select( 'waiters.id', 'waiters.code', 'waiters.people_id',
        //     'people.doc', 'people.name', 'people.email',
        //     'people.address', 'people.phone', 'people.email' )
        //     ->where('waiters.id', $waiter->id )
        //     ->with('LocationsTables')
        //     ->first() ;
        //         //->join('location_table_waiter','location_table_waiter.location_table_id','=','location_table.id')
        $waiters = Waiter::where( 'id', $waiter->id )
            ->with( 'People' )
            ->with( 'LocationsTables' )
            ->first();

        return response()->json( [ 'Waiter' => $waiters ], 200 );
    }

    public function index() {
       $waiters = Waiter::with( 'People' )
        ->with( 'LocationsTables' )
        ->get();

        return response()->json( [ 'Waiters' => $waiters ], 200 );
    }

    public function show( $id) {
        $waiters = Waiter::where( 'id', $id )
                ->with( 'People' )
                ->with( 'LocationsTables' )
                ->first();
        return response()->json( [ 'Waiter' => $waiters ], 200 );

        // $waiters = Waiter::join('people', 'people.id', '=', 'waiters.people_id')
        //     ->where('waiters.id', $id )
        //     ->get( ['waiters.id', 'waiters.code', 'waiters.people_id',
        //         'people.doc', 'people.name', 'people.email',
        //         'people.address', 'people.phone', 'people.email'] );

        // return response()->json( [ 'Waiters' => $waiters ], 200 );
    }

    public function destroy($id){
        $waiter=Waiter::find($id);
        if(isset($waiter)){
            $waiter->delete();
            return response()->json(['Message'=>'succefully delete']);
        }    
        else
            return response()->json(['Message'=>'No exist waiter']);
    }

    public function update(Request $request,$id){
        
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'doc' => 'required',
            'code' => 'required',
        ]);
    
        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()], 422);
        }

        $waiters = Waiter::find($id);
        $waiters->code = $request->code;
        $waiters->save();

        $people = People::find($waiters->people_id);
        $people->name = $request->name;
        $people->doc = $request->doc;
        $people->address = $request->address;
        $people->phone = $request->phone;
        $people->email = $request->email;
        $people->save();

        $waiters->locationsTables()->sync($request->locations_tables);

        $waiters = Waiter::where( 'id', $waiter->id )
            ->with( 'People' )
            ->with( 'LocationsTables' )
            ->first();

        return response()->json( [ 'Waiter' => $waiters ], 200 );
    }

    public function destroyLocationWaiter(Request $request, $id){
        $waiters = Waiter::find($id);
        // var_dump ( $id ); die() ;
        if(isset($waiters)){
            $waiters->locationsTables()->detach($request->locations_tables);
            return response()->json(['Message'=>'succefully delete']);
        }    
        else
            return response()->json(['Message'=>'No tiene asignado ninguna locacion']);//Eliminamos la relacion con la location.
    }
}
