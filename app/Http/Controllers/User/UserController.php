<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Category;
use App\Models\Contact;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function home(){
        $pizza = Product::latest()->get();
        $category = Category::get();
        $cart = Cart::where('user_id',Auth::user()->id)->get();
        $order = Order::where('user_id',Auth::user()->id)->get();
        return view('user.main.home',['pizza' => $pizza,'category' => $category, 'cart' => $cart, 'order' => $order]);
    }

    public function changePassword(){
        return view('user.account.changePassword');
    }

    public function editProfile(){
        return view('user.account.edit');
    }

    public function update(Request $request,$id){
        $this->validationUserData($request);
        $data = $this->requestData($request);
        //image store
        if($request->hasFile('image')){
            $image = User::where('id',$id)->first();
            $db_image = $image->image;
            if($db_image != null){
                Storage::delete('public/'.$db_image);
            }
            $filename = uniqid().'_'.$request->file('image')->getClientOriginalName();
            $request->file('image')->storeAs('public',$filename);
            $data['image'] = $filename;
        }
        User::where('id',$id)->update($data);
        return redirect()->route('user.home')->with(['updateSuccess' => 'Profile Updated...']);
    }

    public function savePassword(Request $request){
        $this->validationPasswordCheck($request);
        $user = User::select('password')->where('id',Auth::user()->id)->first();
        $db_password = $user->password;
        if(Hash::check($request->oldPassword,$db_password)){
            User::where('id',Auth::user()->id)->update([
                'password' => Hash::make($request->newPassword)
            ]);
            return redirect()->route('user.home')->with(['changePassword' => 'Updated Password...']);
        }
        return back()->with(['passwordError' => 'Password does not match!']);

    }

    public function filter($id){
        $pizza = Product::where('id',$id)->latest()->get();
        $category = Category::get();
        $cart = Cart::where('user_id',Auth::user()->id)->get();
        $order = Order::where('user_id',Auth::user()->id)->get();
        return view('user.main.home',['pizza' => $pizza,'category' => $category, 'cart' => $cart, 'order' => $order]);
    }

    public function detail($id){
        $pizza = Product::where('id',$id)->first();
        $product = Product::get();
        return view('user.main.detail',['pizza' => $pizza, 'product' => $product]);
    }

    public function cartList(){
        $cart = Cart::select('products.name as pizza_name','carts.*','products.price as price','products.image as image')
                    ->join('products','carts.product_id','products.id')
                    ->where('user_id',Auth::user()->id)
                    ->get();
        $total = 0;
        foreach($cart as $c){
            $total += $c->price*$c->qty;
        }
        return view('user.cart.list',['cart' => $cart, 'total' => $total]);
    }

    //Order history
    public function history(){
        $order = Order::where('user_id',Auth::user()->id)->paginate(4);
        return view('user.main.orderHistory',['order' => $order]);
    }

    public function contact(){
        return view('user.contact.contact');
    }

    //save user feedback
    public function saveContact(Request $request){
        Validator::make($request->all(),[
            'email' => 'required|email',
            'name' => 'required',
            'message' => 'required'
        ])->validate();
        Contact::create([
            'name' => $request->name,
            'email' =>$request->email,
            'message' => $request->message
        ]);
        return redirect()->route('user.home');
    }

    private function validationPasswordCheck($request){
        Validator::make($request->all(),[
            'oldPassword' => 'required|min:6',
            'newPassword' => 'required|min:6',
            'confirmPassword' => 'required|min:6|same:newPassword'
        ])->validate();
    }

    private function requestData($request){
        return[
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'gender' => $request->gender,
            'updated_at' => Carbon::now()
        ];
    }

    private function validationUserData($request){
        validator::make($request->all(),[
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'address' => 'required',
            'gender' => 'required',
            'image' => 'mimes:jpg,jpg,png,webp|file'
        ])->validate();
    }
}
