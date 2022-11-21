@extends('admin.layouts.master')

@section('title','Product List')

@section('content')
<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="col-md-12">
                <!-- DATA TABLE -->
                <div class="table-data__tool">
                    <div class="table-data__tool-left">
                        <div class="overview-wrap">
                            <h2 class="title-1">Product List</h2>

                        </div>
                    </div>
                    <div class="table-data__tool-right">
                        <a href="{{ route('product.create') }}">
                            <button class="au-btn au-btn-icon au-btn--green au-btn--small">
                                <i class="zmdi zmdi-plus"></i>add prduct
                            </button>
                        </a>
                        <button class="au-btn au-btn-icon au-btn--green au-btn--small">
                            CSV download
                        </button>
                    </div>
                </div>

                {{-- Search data --}}

                <div class="row">
                    <div class="col-3">
                        <h4 class="text-muted">Search Key : <span class="text-danger">{{ request('search') }}</span></h4>
                    </div>
                    <form class="form-header col-5 offset-4" action="{{ route('product.list') }}" method="get">
                        <input class="au-input au-input--xl" type="text" name="search" placeholder="Search for datas ... " value={{ request('search') }} >
                        <button class="au-btn--submit" type="submit">
                            <i class="zmdi zmdi-search"></i>
                        </button>
                    </form>
                </div>

                <div class="row my-2">
                    <div class="col-5">
                        <h3 class="text-muted">Total - ({{ $product->total() }})</h3>
                    </div>
                </div>

                {{-- Alert for create --}}
                @if (session('createSuccess'))
                <div class="col-4 offset-8">
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <i class="fa-solid fa-check"></i> {{ session('createSuccess') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                </div>
                @endif

                {{-- Alert for delete --}}
                @if (session('deleteSuccess'))
                <div class="col-4 offset-8">
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <i class="fa-solid fa-xmark"></i> {{ session('deleteSuccess') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                    </div>
                </div>
                @endif

                {{-- Alert for update password success --}}
                @if (session('updateSuccess'))
                <div class="col-4 offset-8">
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fa-solid fa-cloud-arrow-up"></i> {{ session('updateSuccess') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                    </div>
                </div>
                @endif

                <div class="table-responsive table-responsive-data2">
                    @if (count($product) > 0)
                    <table class="table table-data2 text-center">
                        <thead>
                            <tr>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Price</th>
                                <th>Category</th>
                                <th>View Count</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($product as $cat)
                            <tr class="tr-shadow ">
                                <td class="col-2"><img src="{{ asset('storage/'.$cat->image) }}" class="img-thumbnail shadow-sm"></td>
                                <td class="col-2">{{ $cat->name }}</td>
                                <td class="col-3">{{ $cat->price }}</td>
                                <td class="col-2">{{ $cat->category_name }}</td>
                                <td class="col-2"><i class="fa-solid fa-eye me-5" ></i> {{ $cat->view_count }}</td>

                                <td>
                                    <div class="table-data-feature">
                                        <a href="{{ route('product.detail',$cat->id) }}">
                                            <button class="item me-1 mr-2" data-toggle="tooltip" data-placement="top" title="View">
                                                <i class="zmdi zmdi-mail-send "></i>
                                            </button>
                                        </a>
                                        <a href="{{ route('product.edit',$cat->id) }}">
                                            <button class="item me-1 mr-2" data-toggle="tooltip" data-placement="top" title="Edit">
                                                <i class="zmdi zmdi-edit "></i>
                                            </button>
                                        </a>
                                        <a href="{{ route('product.delete',$cat->id) }}">
                                            <button class="item me-1 mr-2" data-toggle="tooltip" data-placement="top" title="Delete">
                                                <i class="zmdi zmdi-delete"></i>
                                            </button>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            <tr class="spacer"></tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="mt-3">
                        {{ $product->appends(request()->query())->links() }}
                    </div>
                    @else
                        <h2 class="text-secondary text-center my-5">There is no data!</h2>
                    @endif
                </div>
                <!-- END DATA TABLE -->
            </div>
        </div>
    </div>
</div>
@endsection
