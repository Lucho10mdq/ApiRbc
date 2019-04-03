<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Menu;
use Validator;

class MenusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index( $inactive = 'false' )
    {
        if ( $inactive == 'false' ) {
            $menus = Menu::with('Location')
            ->with('Category')
            ->where('active', true)
            ->get();
        }else {
            $menus = Menu::with('Location')
            ->with('Category')
            ->get();
        }
        
        return response()->json( [ 'Menus' => $menus ], 200 );
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

        $validator = Validator::make($input, [
            'name' => 'required',
            'description' => 'required',
            'price' => 'required',
            'location_id' => 'required',
            'category_id' => 'required'
        ]);
    
        if ($validator->fails()) {
            return response()->json( [ 'error'=>$validator->errors() ], 422);
        }

        $menu = [];
        $menu = Menu::where( 'name', $input[ 'name' ] )->first();
        if (isset( $menu ) ) {
            return response()->json( [ 'message'=>'The menu name alredy exist' ], 422 );
        }
        $menu = Menu::create( $input ) ;

        return response()->json( [ 'Menu' => $menu ], 200 );
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $menus = Menu::where( 'id', $id )
            ->with('Location')
            ->with('Category')->get();
        
        return response()->json( [ 'Menus' => $menus ], 200 );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category = Category::find($id);
        if(isset($category)){
            $category->delete();
            return response()->json(['Message'=>'succefully delete']);
        }    
        else
            return response()->json(['Message'=>'No exist category']);
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
            'name' => 'required',
            'description' => 'required',
            'price' => 'required',
            'location_id' => 'required',
            'category_id' => 'required'
        ]);
    
        if ($validator->fails()) {
            return response()->json( [ 'error'=>$validator->errors() ], 422);
        }

        // $menus = [];
        // $menus = Menu::where( 
        //     'number', $input[ 'number' ] )
        //     ->where('id', '!==' , $id)
        //     ->first();
        // if (isset( $menus ) ) {
        //     return response()->json( [ 'message'=>'The menu number alredy exist' ], 422 );
        // }

        $menus = Menu::find( $id ) ;
        $menus->fill( $input );
        $menus->save();

        $menus = Menu::where( 'id', $id )
            ->with('Location')
            ->with('Category')
            ->get();
        
        return response()->json( [ 'Menus' => $menus ], 200 );
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

    public function inactive($id)
    {
        $menu = Menu::find($id);
        if(isset($menu)){
            $menu->active = false ;
            $menu->save() ;
            return response()->json(['Message'=>'succefully inactived']);
        }    
        else
            return response()->json(['Message'=>'No exist product']);
    }

    public function active($id)
    {
        $menu = Menu::find($id);
        if(isset($menu)){
            $menu->active = true ;
            $menu->save() ;
            return response()->json(['Message'=>'succefully actived']);
        }    
        else
            return response()->json(['Message'=>'No exist product']);
    }
}
