<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Order;
use App\Plate;
use App\OrderState;
use App\PlateState;
use App\Table;

class OrdersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders= Order::with('Plates.Menu')
        ->with('Plates.PlateState')
        ->with('Waiter.People')
        ->with('OrderState')
        ->with('Table')
        ->get();

        return response()->json([ 'Orders' => $orders ], 200);
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
        $order = new Order();
        $order->date_hour = $request->date_hour;
        $order->table_id = $request->table_id;
        $order->order_state_id = $request->order_state_id;
        $order->save();

        $order->Waiter()->sync($request->order_waiter);

        foreach($request->plates as $Plate){
            $plate = new Plate();
            $plate->price = $Plate['price'];
            $plate->menu_id = $Plate['menu_id'];
            $plate->order_id = $order->id;
            $plate->plate_state_id = $Plate['plate_state_id'];
            $plate->save();
        }
        $order = Order::where( 'id', $order->id )
        ->with('Plates')
        ->with('Waiter')
        ->with('OrderState')
        ->with('Table')
        ->first();

        return response()->json( [ 'Order' => $order ], 200 );
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {   //withTrashed()-> (muestra los eliminados)
        $order = Order::where( 'id', $id )
        ->with('Plates.Menu')
        ->with('Plates.PlateState')
        ->with('Waiter.People')
        ->with('OrderState')
        ->with('Table')
        ->first();

        return response()->json( [ 'Order' => $order ], 200 );
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
        $order = Order::find($id);
        $order->date_hour = $request->date_hour;
        $order->table_id = $request->table_id;
        $order->order_state_id = $request->order_state_id;
        $order->save();

        $order->Waiter()->sync($request->order_waiter);

        //eliminar todos los platos

        Plate::where( 'order_id', $id )->delete() ;

        foreach($request->plates as $Plate){
            $plate = new Plate();
            $plate->price = $Plate['price'];
            $plate->menu_id = $Plate['menu_id'];
            $plate->order_id = $order->id;
            $plate->plate_state_id = $Plate['plate_state_id'];
            $plate->save();
        }

        $order = Order::where( 'id', $order->id )
        ->with('Plates')
        ->with('Waiter')
        ->with('OrderState')
        ->with('Table')
        ->first();

        return response()->json( [ 'Order' => $order ], 200 );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $order = Order::find($id) ;
        $order->delete() ;

        return response()->json( [ 'Order' => $order ], 200 );
    }
}
