<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use DB;

class Order extends Model
{
    use HasFactory;

    public function products(){
        return $this->hasmany('App\Models\Product');
    }

    public function user(){
        return $this->hasOne('App\Models\User');
    }

    public static function getTodayOrders()
    {
        return $orders = Order::with(['user','products','products.additionals'])
        ->orderBy('orders.created_at')
        // ->where('orders.created_at','=', Carbon::now()->format('Y-m-d'))
        ->get();
    }

    public static function getOrdersByDate($date)
    {
        return $orders = Order::with(['user','products','products.additionals'])
        ->orderBy('orders.created_at')
        ->where('orders.created_at','=', $date)
        ->with(['products.additionals'])
        ->get();
    }

    public static function getTotalOrderPrice($id)
    {
        $TotalProduct = Order::where('orders.id',$id)
        ->get('orders.princes');

        // $TotalProduct = DB::table('products')
        // ->where('products.order_id',$id)
        // ->sum('products.price');

        // $TotalAdditionalProduct = DB::table('additionals')
        // ->join('products', 'products.id', '=', 'additionals.product_id')
        // ->where('products.order_id',$id)
        // ->where('additionals.product_id','products.id')
        // ->sum('additionals.price');

        // $TotalOrderPrice = $TotalProduct + $TotalAdditionalProduct;
        // return $TotalOrderPrice;
    }
}

