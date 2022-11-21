@extends('admin.layouts.master')

@section('title','Category List')

@section('content')
<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="col-md-12">
                <!-- DATA TABLE -->
                <div class="table-data__tool">
                    <div class="table-data__tool-left">
                        <div class="overview-wrap">
                            <h2 class="title-1">Category List</h2>

                        </div>
                    </div>
                    <div class="table-data__tool-right">
                        <a href="{{ route('category.create') }}">
                            <button class="au-btn au-btn-icon au-btn--green au-btn--small">
                                <i class="zmdi zmdi-plus"></i>add category
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
                        <h3 class="text-muted">Search Key : {{ request('search') }}</h3>
                    </div>
                    <form class="form-header col-5 offset-4" action="{{ route('category.list') }}" method="get">
                        <input class="au-input au-input--xl" type="text" name="search" placeholder="Search for datas ... " value={{ request('search') }} >
                        <button class="au-btn--submit" type="submit">
                            <i class="zmdi zmdi-search"></i>
                        </button>
                    </form>
                </div>

                <div class="row my-2">
                    <div class="col-5">
                        <h3 class="text-muted">Total - ({{ $category->total() }})</h3>
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
                @if (session('changePassword'))
                <div class="col-4 offset-8">
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fa-solid fa-cloud-arrow-up"></i> {{ session('changePassword') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                    </div>
                </div>
                @endif

                <div class="table-responsive table-responsive-data2">
                    @if (count($category) > 0)
                    <table class="table table-data2 text-center">
                        <thead>
                            <tr>
                                <th>id</th>
                                <th>name</th>
                                <th>date</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($category as $cat)
                            <tr class="tr-shadow ">
                                <td>{{ $cat->id }}</td>
                                <td class="col-5">
                                    <span class="block-email">{{ $cat->name }}</span>
                                </td>
                                <td>{{ $cat->created_at->format('j-F-Y') }}</td>
                                <td>
                                    <div class="table-data-feature">

                                        <a href="{{ route('category.edit',$cat->id) }}">
                                            <button class="item mr-2" data-toggle="tooltip" data-placement="top" title="Edit">
                                                <i class="zmdi zmdi-edit"></i>
                                            </button>
                                        </a>
                                        <a href="{{ route('category.delete',$cat->id) }}">
                                            <button class="item mr-2" data-toggle="tooltip" data-placement="top" title="Delete">
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
                        {{ $category->appends(request()->query())->links() }}
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
