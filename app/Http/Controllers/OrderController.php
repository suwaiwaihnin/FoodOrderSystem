<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class OrderController extends Controller
{
    public function list(){
        $order = Order::when(request('search'),function($query){
                $query->orwhere('order_code','like','%'.request('search').'%')
                      ->orwhere('total_price','like','%'.request('search').'%');
                })
                ->select('users.name as user_name', 'orders.*')
                ->leftjoin('users','users.id','orders.user_id')
                ->latest()
                ->paginate(5);
        return view('admin.order.list',['order' => $order]);
    }

    //sort order list by status
    public function sort(Request $request){
        $order = Order::select('users.name as user_name', 'orders.*')
                ->leftjoin('users','users.id','orders.user_id')
                ->latest();

        if($request->status == null){
            $order = $order->paginate(5);
        }else{
            $order = $order->where('status',$request->status)->paginate(5);
        }
        return view('admin.order.list',['order' => $order]);
    }

    public function changeStatus(Request $request){
        Order::where('id',$request->order_id)
            ->update([
                'status'=>$request->status
            ]);

    }

    //Order Detail
    public function orderDetail($orderCode){
        $detail = OrderList::select('order_lists.*','products.name as product_name', 'products.image as product_image', 'users.name as user_name')
                ->leftJoin('users','users.id','order_lists.user_id')
                ->leftJoin('products','order_lists.product_id','products.id')
                ->where('order_code',$orderCode)
                ->get();

        $total_price = Order::where('order_code',$orderCode)->first();
        return view('admin.order.detail',['detail' => $detail, 'total_price'=> $total_price]);
    }
}
