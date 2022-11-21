<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function list(){
        $product = Product::when(request('search'),function($query){
                    $query->where('products.name','like','%'.request('search').'%');
                    })
                    ->leftJoin('categories','categories.id','products.category_id')
                    ->select('products.*','categories.name as category_name')
                   ->latest()->paginate(5);
        return view('admin.product.list',['product' => $product]);
    }

    public function create(){
        $category = Category::all();
        return view('admin.product.create',['category' => $category]);
    }

    public function save(Request $request){
        $this->validationProduct($request,'create');
        $data = $this->requestProduct($request);
        if($request->hasFile('image')){
           $filename = uniqid().'_'.$request->file('image')->getClientOriginalName();
            $request->file('image')->storeAs('public',$filename);
            $data['image'] = $filename;
        }
        Product::create($data);
        return redirect()->route('product.list')->with(['createSuccess' => 'Pizza Created...']);
    }

    public function delete($id){
        Product::where('id',$id)->delete();
        return redirect()->route('product.list')->with(['deleteSuccess' => 'Product Deleted....']);
    }

    public function detail($id){
        $product = Product::where('products.id',$id)
                ->leftJoin('categories','categories.id','products.category_id')
                ->select('products.*','categories.name as category_name')
                ->first();
        return view('admin.product.detail',['product' => $product]);
    }

    public function edit($id){
        $product = Product::where('id',$id)->first();
        $category = Category::all();
        return view('admin.product.edit',['product' => $product,'category' => $category]);
    }

    public function update(Request $request,$id){
        $this->validationProduct($request,'update');
        $data = $this->requestProduct($request);
        if($request->hasFile('image')){
            $db = Product::where('id',$id)->select('image')->first();
            $db_image = $db->image;
            if($db_image !== null){
                Storage::delete('public/'.$db_image);
            }
            $filename = uniqid().'_'.$request->file('image')->getClientOriginalName();
            $request->file('image')->storeAs('public',$filename);
            $data['image'] = $filename;
        }
        Product::where('id',$id)->update($data);
        return redirect()->route('product.list')->with(['updateSuccess' => 'Product Updated...']);
    }

    private function requestProduct($request){
        return[
            'name' => $request->name,
            'category_id' => $request->category,
            'description' => $request->description,
            'price' => $request->price,
            'waiting_time' => $request->waiting_time,
        ];
    }

    private function validationProduct($request,$status){
        $validation = [
            'name' => 'required|min:5|unique:products,name,'.$request->id,
            'category' => 'required',
            'description' => 'required|min:10',
            'price' => 'required',
            'waiting_time' => 'required',
        ];
        $validation['image'] = $status == 'create' ? 'required|mimes:jpg,jpeg,png|file' : 'mimes:jpg,jpeg,png|file';
        Validator::make($request->all(),$validation)->validate();
    }
}
