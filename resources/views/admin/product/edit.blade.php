@extends('admin.layouts.master')

@section('title','Edit Product')

@section('content')

<div class="main-content">
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
                            <h3 class="text-center title-2">Update Product</h3>
                        </div>
                        <hr>
                        <form action="{{ route('product.update',$product->id) }}" method="post"  enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-4 offset-1">
                                    <img src="{{ asset('storage/'.$product->image) }}"  class="img-thumbnail" alt="John Doe" />
                                    <div class="mt-3">
                                        <input type="file" name="image" id="" class="form-control @error('image') is-invalid @enderror">
                                        @error('image')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="mt-3">
                                        <button class="btn bg-dark text-white col-12" type="submit">
                                            <i class="fa-solid fa-pen-to-square me-3"></i> Update
                                        </button>
                                    </div>
                                </div>

                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="cc-payment" class="control-label mb-1">Name</label>
                                        <input id="cc-pament" name="name" type="text" class="form-control @error('name') is-invalid
                                        @enderror" aria-required="true" aria-invalid="false" placeholder="Enter Name" value="{{ old('name',$product->name) }}">
                                        @error('name')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="cc-payment" class="control-label mb-1">Description</label>
                                        <textarea name="description" class="form-control @error('description') is-invalid @enderror" cols="30" rows="10" placeholder="Enter Description...">{{ old('description',$product->description) }}</textarea>
                                        @error('description')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="cc-payment" class="control-label mb-1">Category</label>
                                        <select name="category" class="form-control @error('category') is-invalid @enderror">
                                            <option value="">Choose Category..</option>
                                            @foreach ($category  as $cat)
                                                <option value="{{ $cat->id }}" @if ($cat->id == $product->id) selected  @endif>{{ $cat->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('category')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="cc-payment" class="control-label mb-1">Price</label>
                                        <input id="cc-pament" name="price" type="number" class="form-control @error('price') is-invalid @enderror" aria-required="true" aria-invalid="false" placeholder="Enter Price" value="{{ old('price',$product->price) }}">
                                        @error('price')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="cc-payment" class="control-label mb-1">Waiting Time</label>
                                        <input id="cc-pament" name="waiting_time" type="number" value="{{ old('waiting_time',$product->waiting_time) }}" class="form-control @error('waiting_time') is-invalid @enderror" aria-required="true" aria-invalid="false" placeholder="Enter Waiting Time">
                                        @error('waiting_time')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="cc-payment" class="control-label mb-1">View Count</label>
                                        <input id="cc-pament" name="view_count" type="number" value="{{ old('view_count',$product->view_count) }}" class="form-control @error('view_count') is-invalid @enderror" aria-required="true" aria-invalid="false" placeholder="Enter View Count">
                                        </textarea>
                                        @error('view_count')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>


                                    <div class="form-group">
                                        <label for="cc-payment" class="control-label mb-1">Created Date</label>
                                        <input id="cc-pament" name="created_at" type="text" value="{{ old('created_date',$product->created_at) }}" class="form-control" aria-required="true" aria-invalid="false" >
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
