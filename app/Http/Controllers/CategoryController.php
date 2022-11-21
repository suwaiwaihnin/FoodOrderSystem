<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    public function list(){
        $category = Category::when(request('search'),function($query){
                    $query->where('name','like','%'.request('search').'%');
                    })
                    ->latest()->paginate(5);
        return view('admin.category.list',['category' => $category]);
    }

    public function create(){
        return view('admin.category.create');
    }

    public function save(Request $request){
        $this->validationCheck($request);
        Category::create([
            'name' => $request->name
        ]);
        return redirect()->route('category.list')->with(['createSuccess' => 'Category Created...']);
    }

    public function delete($id){
        Category::where('id',$id)->delete();
        return back()->with(['deleteSuccess' => 'Category Deleted...']);
    }

    public function edit($id){
        $category = Category::where('id',$id)->first();
        return view('admin.category.edit',['category' => $category]);
    }

    public function update($id,Request $request){
        $this->validationCheck($request);
        Category::where('id',$id)->update([
            'name' => $request->name
        ]);
        return redirect()->route('category.list');
    }

    //Validation
    private function validationCheck($request){
        Validator::make($request->all(),[
            'name' => 'required|min:5|unique:categories,name,'.$request->id
        ])->validate();
    }
}
