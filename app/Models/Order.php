<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use DB;

class Order extends Model
{
    use HasFactory;

    public static function getTodayOrders()
    {
        return DB::table('orders')
        ->join('users', 'orders.id', '=', 'users.order_id')
        ->join('products', 'orders.id', '=', 'products.order_id')
        ->leftjoin('additionals', 'products.id', '=', 'product_id')
        ->orderByRaw('orders.created_at')
        
        ->select(
        /*order*/
        'orders.id as order_id','orders.wayToPay as order_wayToPay', 'orders.change as order_change',
        'orders.address as order_address','orders.reference as order_reference',
        /*user*/
        'users.id as user_id','users.name as user_name', 'users.phone_number as user_phone',
        /*product*/
        'products.id as product_id','products.quantity as product_quantity', 
        'products.name as product_name', 'products.price as product_price',
        'products.size as product_size', 'products.observation as product_observation',
        /*additionals*/
        'additionals.id as additional_id','additionals.product_id as additional_product_id', 'additionals.name as additional_name',
        'additionals.price as additional_price',)
        ->get();


    }
}

