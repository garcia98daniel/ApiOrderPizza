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
        // $dt = Carbon::now();
        // dd($dt->copy()->startOfDay(), $dt->copy()->endOfDay());
        $startDay = Carbon::now()->startOfDay();
        $endDay   = $startDay->copy()->endOfDay();

        return $orders = Order::with(['user','products','products.additionals'])
        ->orderBy('orders.created_at')
        ->whereBetween('orders.created_at', [$startDay , $endDay])
        // ->where('orders.created_at','=', Carbon::now()->format('Y-m-d'))
        ->get();
    }

    public static function getOrdersByDate($date)
    {
        // $dt = Carbon::now();
        // dd($dt->copy()->startOfDay(), $dt->copy()->endOfDay());
        $startDay = Carbon::parse($date)->startOfDay();
        $endDay   = $startDay->copy()->endOfDay();

        return $orders = Order::with(['user','products','products.additionals'])
        ->orderBy('orders.created_at')
        ->whereBetween('orders.created_at', [$startDay , $endDay])
        // ->where('orders.created_at','=', )
        ->with(['products.additionals'])
        ->get();
    }

    public static function getTotalSales()
    {
        // $dt = Carbon::now();
        // dd($dt->copy()->startOfDay(), $dt->copy()->endOfDay());
        $startDay = Carbon::now()->startOfDay();
        $endDay   = $startDay->copy()->endOfDay();
        // return Order::where('orders.created_at','=', $date)
        return Order::whereBetween('orders.created_at', [$startDay , $endDay])
        ->sum('orders.price');
    }
//usar whereBetween()->endOfday
    public static function getTotalSalesByDate($date)
    {
        // $dt = Carbon::now();
        // dd($dt->copy()->startOfDay(), $dt->copy()->endOfDay());
        
        $startDay = Carbon::parse($date)->startOfDay();
        $endDay   = $startDay->copy()->endOfDay();
        // return Order::where('orders.created_at','=', $date)
        return Order::whereBetween('orders.created_at', [$date , $endDay])
        ->sum('orders.price');
    }

    // public static function getTotalOrderPrice($id)
    // {
    //     return Order::findOrFail($id)
    //     ->get('orders.price');

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
    // }
}

