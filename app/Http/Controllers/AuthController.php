<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    //login
    public function login(){
        return view('login');
    }

    //register
    public function register(){
        return view('register');
    }

    //dashboard
    public function dashboard(){
        if(Auth::user()->role == 'admin'){
            return redirect()->route('category.list');
        }else{
            return redirect()->route('user.home');
        }
    }

    //change password
    public function changePassword(){
        return view('admin.account.changePassword');
    }

    public function savePassword(Request $request){
        $this->validationPasswordCheck($request);
        $user = User::select('password')->where('id',Auth::user()->id)->first();
        $db_password = $user->password;
        if(Hash::check($request->oldPassword,$db_password)){
            User::where('id',Auth::user()->id)->update([
                'password' => Hash::make($request->newPassword)
            ]);
            return redirect()->route('category.list')->with(['changePassword' => 'Updated Password...']);
        }
        return back()->with(['passwordError' => 'Password does not match!']);

    }

    public function accountDetail(){
        return view('admin.account.accountDetail');
    }

    public function editProfile(){
        return view('admin.account.editProfile');
    }

    public function updateProfile(Request $request,$id){
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
        return redirect()->route('admin.accountDetail')->with(['updateSuccess' => 'Profile Updated...']);
    }

    public function adminList(){
        $admin = User::when(request('search'),function($query){
                $query->orWhere('name','like','%'.request('search').'%')
                ->orWhere('email','like','%'.request('search').'%')
                ->orWhere('phone','like','%'.request('search').'%')
                ->orWhere('address','like','%'.request('search').'%')
                ->orWhere('gender','like','%'.request('search').'%');
                })
            ->where('role','admin')->paginate(3);
        return view('admin.account.list',['admin' => $admin]);
    }

    public function delete($id){
        User::where('id',$id)->delete();
        return redirect()->back()->with(['deleteSuccess' => 'Account Deleted...']);
    }

    public function changeRole(Request $request){
        User::where('id',$request->user_id)->update([
            'role' => $request->role
        ]);

    }

    //User List
    public function userList(){
        $user = User::where('role','user')->paginate(6);
        return view('admin.account.userList',['user' => $user]);
    }

    //edit user profile
    public function editUserProfile($id){
        $user = User::where('id',$id)->first();
        return view('admin.account.editUserProfile',['user' => $user]);
    }

    //save user profile
    public function save(Request $request,$id){
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
        return redirect()->route('user.list');
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
        Validator::make($request->all(),[
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'address' => 'required',
            'gender' => 'required',
            'image' => 'mimes:jpg,jpg,png'
        ])->validate();
    }

    private function validationPasswordCheck($request){
        Validator::make($request->all(),[
            'oldPassword' => 'required|min:6',
            'newPassword' => 'required|min:6',
            'confirmPassword' => 'required|min:6|same:newPassword'
        ])->validate();
    }
}
