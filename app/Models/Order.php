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

    public function users(){
        return $this->hasOne('App\Models\User');
    }

    public static function getTodayOrders()
    {
        return $orders = Order::orderBy('orders.created_at')
        ->where('orders.created_at','=', Carbon::now()->format('Y-m-d'))
        ->with(['products.additionals'])
        ->get();
    }

    public static function getOrdersByDate($date)
    {
        return $orders = Order::orderBy('orders.created_at')
        ->where('orders.created_at','=', $date)
        ->with(['products.additionals'])
        ->get();
    }
}

