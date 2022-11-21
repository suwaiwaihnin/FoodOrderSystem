@extends('admin.layouts.master')

@section('title','Contact Detail')

@section('content')

<div class="main-content">

    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="row">
                <div class="col-10 offset-1">
                    <div class="ms-5">
                            {{-- <a href="{{ route('product.list') }}" class="text-decoration-none"> --}}
                                <i class="fa-solid fa-arrow-left text-dark" onclick="history.back()"></i>
                            {{-- </a> --}}
                        </div>
                    <div class="card mt-3">
                        <div class="card-body" >
                            <h3 class="text-center">Contact Detail</h3>
                        </div>
                        <hr>
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col"><i class="fa-solid fa-user mr-2"></i>Name</div>
                                <div class="col-7">{{ strtoupper($detail->name) }}</div>
                            </div>
                            <div class="row mb-3">
                                <div class="col"><i class="fa-solid fa-envelope mr-2"></i>Email</div>
                                <div class="col-7">{{ $detail->email }}</div>
                            </div>
                            <div class="row mb-3">
                                <div class="col"><i class="fa-solid fa-comment mr-2"></i>Message </div>
                                <div class="col-7">{{ $detail->message }}</div>
                            </div>
                            <div class="row mb-3">
                                <div class="col"><i class="fa-solid fa-clock mr-2"></i> Date</div>
                                <div class="col-7">{{ $detail->created_at->format('F-j-Y') }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

@endsection
