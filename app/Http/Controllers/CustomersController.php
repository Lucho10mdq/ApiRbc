<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\People;
use App\Customer;
use Validator;

class CustomersController extends Controller
{
    public function store(Request $request){

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'doc' => 'required',
        ]);
    
        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()], 422);
        }

        $people = [];
        $people =People::where('doc',$request->doc)->first();
        if (isset( $people ) ) {
            return response()->json( [ 'message'=>'The doc number alredy exist' ], 422 );
        }

        $people = new People() ;
        $people->name = $request->name ;
        $people->doc = $request->doc ;
        $people->address = $request->address ;
        $people->phone = $request->phone ;
        $people->email = $request->email ;
        $people->save() ;

        $customer = new Customer() ;
        
        $customer->contact = $request->contact ;
        $customer->contact_phone = $request->contact_phone ;
        $customer->people_id = $people->id ;
        $customer->save() ;

        $customers = Customer::join('people','people.id','=','customers.people_id')
        ->where('people.id', $people->id )
        ->get(['customers.id', 'customers.contact','customers.contact_phone', 
        'people.doc', 'people.name', 'people.email',
        'people.address', 'people.phone'
        ]) ;

       return response()->json( [ 'Customer' => $customers ], 200 ) ;
    }

    public function index(){
        $customers = Customer::with( 'People' )
        ->get();

        return response()->json( [ 'Customers' => $customers ], 200 );
    }

    public function show( $id) {
        $customer = Customer::join('people', 'people.id', '=', 'customers.id')
            ->where('customers.id', $id )
            ->get(['customers.id', 'customers.contact','customers.contact_phone', 
            'people.doc', 'people.name', 'people.email',
            'people.address', 'people.phone'
            ]) ;

        return response()->json( [ 'Customer' => $customer ], 200 ) ;
    }

    public function update(Request $request,$id){
        
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'doc' => 'required',
            'code' => 'required',
        ]) ;
    
        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()], 422) ;
        }

        $customer = Customer::find($id) ;
        $customer->contact = $request->contact ;
        $customer->contact_phone = $request->contact_phone ;

        $people = People::find($customer->id) ;
        $people->name = $request->name ;
        $people->doc = $request->doc ;
        $people->address = $request->address ;
        $people->phone = $request->phone ;
        $people->email = $request->email ;
        $people->save() ;

       
        $customer = Customer::join('people', 'people.id', '=', 'customers.id')
        ->where('customers.id', $id )
        ->get(['customers.id', 'customers.contact','customers.contact_phone', 
        'people.doc', 'people.name', 'people.email',
        'people.address', 'people.phone', 'people.email'
        ]) ;

        return response()->json( [ 'Customer' => $customer ], 200 ) ;
    }

}
