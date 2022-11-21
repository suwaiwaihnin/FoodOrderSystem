<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderList;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AjaxController extends Controller
{
    public function list(Request $request){
        if($request->status == 'desc'){
            $data = Product::latest()->get();
        }else{
            $data = Product::get();
        }
        return response()->json($data,200);
    }

    public function addToCart(Request $request){
        Cart::create([
            'user_id' => $request->userID,
            'product_id' => $request->pizzaID,
            'qty' => $request->orderCount
        ]);
        $response = [
            'message' => 'Add to cart',
            'status' => 'success'
        ];
        return response()->json($response,200);
    }

    public function order(Request $request){

        foreach($request->all() as $req){
            $data = OrderList::create([
                'user_id' => $req['user_id'],
                'product_id' => $req['product_id'],
                'qty' => $req['qty'],
                'total' => $req['total'],
                'order_code' => $req['order_code']
            ]);
        }
        Cart::where('user_id',Auth::user()->id)->delete();
        $total = 0;
        $total += $data->total;
        logger($total);
        Order::create([
            'user_id' => Auth::user()->id,
            'order_code' => $data->order_code,
            'total_price' => $total+2000,
        ]);
        return response()->json([
            'message' => 'order complete',
            'status' => 'success'
        ],200);
    }

    public function clearCart(){
        Cart::where('user_id',Auth::user()->id)->delete();
    }

    public function clearCartItem(Request $request){
        Cart::where('user_id',Auth::user()->id)
            ->where('id',$request->cart_id)
            ->where('product_id',$request->product_id)
            ->delete();
    }

    public function increaseViewCount(Request $request){
        $view_count = Product::where('id',$request->product_id)->first();
        Product::where('id',$request->product_id)
                ->update([
                    'view_count' => $view_count->view_count + 1
                ]);
    }
}
