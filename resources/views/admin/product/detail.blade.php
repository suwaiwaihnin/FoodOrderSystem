@extends('admin.layouts.master')

@section('title','Category Edit')

@section('content')

<div class="main-content">
    <div class="row">
        {{-- Alert for update password success --}}
        <div class="col-4 offset-6" >
            @if (session('updateSuccess'))
            <div class="">
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fa-solid fa-cloud-arrow-up"></i> {{ session('updateSuccess') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
            </div>
            @endif
        </div>
    </div>
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="col-lg-10 offset-1">
                <div class="card">
                    <div class="card-body">
                        <div class="ms-5">
                            {{-- <a href="{{ route('product.list') }}" class="text-decoration-none"> --}}
                                <i class="fa-solid fa-arrow-left text-dark" onclick="history.back()"></i>
                            {{-- </a> --}}
                        </div>
                        <div class="card-title">
                            <h3 class="text-center title-2">Product Details</h3>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-3 offset-2">
                                <img src="{{ asset('storage/'.$product->image) }}"  class="img-thumbnail" alt="John Doe" />
                            </div>
                            <div class="col-7 ">
                                <div class="my-3  btn bg-danger text-white d-block w-75 text-center">  {{ $product->name }}</div>
                                <span class="my-3 btn bg-dark text-white"> <i class="fa-solid fa-money-bill-1-wave me-2"></i> {{ $product->price }} kyats</span>
                                <span class="my-3 btn bg-dark text-white"> <i class="fa-solid fa-clock me-2"></i> {{ $product->waiting_time }} mins</span>
                                <span class="my-3 btn bg-dark text-white"> <i class="fa-solid fa-eye me-2"></i> {{ $product->view_count }}</span>
                                <span class="my-3 btn bg-dark text-white"> <i class="fa-solid fa-clone"></i> {{ $product->category_name }}</span>
                                <span class="my-3  btn bg-dark text-white"> <i class="fa-solid fa-user-clock me-2"></i> {{ $product->created_at->format('j-F-Y') }}</span>
                                <div class="my-3 "> <i class="fa-solid fa-file-lines me-2 "></i> Details</h4>
                                    <div class="">{{ $product->description }}</div>
                                </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

