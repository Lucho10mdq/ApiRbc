<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use Validator;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::all();
        return response()->json( [ 'Categories' => $categories ], 200 );
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

        $category = [];
        $category = Category::where( 'description', $input[ 'description' ] )->first();
        if (isset( $category ) ) {
            return response()->json( [ 'message' => 'The description alredy exist' ], 422 );
        }        
        
        $category = Category::create( $input ) ;

        return response()->json( [ 'Category' => $category ], 200 );
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $categories = Category::find( $id ) ;
        return response()->json( [ 'Categories' => $categories ], 200 );
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

        $category = Category::find( $id ) ;
        $category->fill( $input );
        $category->save();

        return $category;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function destroy($id)
    // {
    //     $category = Category::find($id);
    //     if(isset($category)){
    //         $category->delete();
    //         return response()->json(['Message'=>'succefully delete']);
    //     }    
    //     else
    //         return response()->json(['Message'=>'No exist category']);
    // }
}
