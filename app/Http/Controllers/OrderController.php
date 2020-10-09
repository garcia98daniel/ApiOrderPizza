<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\User;
use App\Models\Product;
use App\Models\Additional;

use Illuminate\Http\Request;
use Carbon\Carbon;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = Order::getTodayOrders();
        return response()->json($orders, 200);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getOrdersByDate($date = 'empty')
    {
        if($date == 'empty'){
            $orders = Order::getTodayOrders();
            return response()->json($orders, 200);
            // return response()->json($orders->load('users')->load('products')->load('products.additionals'), 200);
        }else{
            $orders = Order::getOrdersByDate($date);
            return response()->json($orders, 200);
        }
        return 'Date Not found';
    }

    public function getTotalSalesInAday($date = 'empty'){
        if($date == 'empty'){
            $totalSales = Order::getTotalSales();
            return response()->json($totalSales, 200);
        }else{
            $totalSales = Order::getTotalSalesByDate($date);
            return response()->json($totalSales, 200);
        }
        return 'Date Not found';
    }

        /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function getTotalOrderPrice($id)
    // {
    //     $TotalOrderPrice = Order::getTotalOrderPrice($id);
    //     return response()->json($TotalOrderPrice, 200);
    // }

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

        try {
            $order = new Order();
            $order->wayToPay = $request->get('wayToPay');
            $order->change = $request->get('change');
            $order->address = $request->get('address');
            $order->reference =  $request->get('reference');
            $order->price =  $request->get('price');
            $order->save();

            $requestUser = $request->get('user');
            $user = new User();
            $user->order_id = $order->id;
            $user->name = $requestUser['name'];
            $user->phone_number = $requestUser['phone_number'];
            $user->save();

            $requestProducts = $request->get('products');
            for ($i=0; $i < count($requestProducts); $i++) { 
                $product = new Product();
                $product->order_id = $order->id;
                $product->quantity = $requestProducts[$i]['quantity'];
                $product->name = $requestProducts[$i]['name'];
                $product->size = $requestProducts[$i]['size'];
                $product->observation = $requestProducts[$i]['observation'];

                $product->save();

                $additionalsProduct = $requestProducts[$i]['additionals'];
                for ($i=0; $i < count($additionalsProduct); $i++) {
                    $additional = new Additional();
                    $additional->product_id = $product->id;
                    $additional->name = $additionalsProduct[$i]['name'];
                    $additional->save();
                }
            }

            return response()->json("Order created id:".$order->id, 201);
        } catch (ModelNotFoundException $exception) {
            return response()->json("Error creating order");
        }
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        //
    }
}
