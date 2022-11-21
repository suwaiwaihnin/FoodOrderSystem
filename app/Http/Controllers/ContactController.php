<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ContactController extends Controller
{
    public function list(){
        $data = Contact::paginate(6);
        return view('admin.contact.list',['data' => $data]);
    }

    public function detail($id){
        $detail = Contact::where('id',$id)->first();
        return view('admin.contact.detail',['detail' => $detail]);
    }
}
