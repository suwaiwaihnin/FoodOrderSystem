@extends('admin.layouts.master')

@section('title','Contact List')

@section('content')
<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
                {{-- Search data --}}

                <div class="row">
                    <div class="col-3">
                        <h4 class="text-muted">Search Key : <span class="text-danger">{{ request('search') }}</span></h4>
                    </div>
                    <form class="form-header col-5 offset-4" action="{{ route('order.list') }}" method="get">
                        <input class="au-input au-input--xl" type="text" name="search" placeholder="Search for datas ... " value={{ request('search') }} >
                        <button class="au-btn--submit" type="submit">
                            <i class="zmdi zmdi-search"></i>
                        </button>
                    </form>
                </div>

                <div class="row my-2">
                    <div class="col-5">
                        <h3 class="text-muted">Total - ({{ $data->total() }})</h3>
                    </div>
                </div>

                <div class="table-responsive table-responsive-data2">
                    @if (count($data) > 0)
                    <table class="table table-data2 text-center">
                        <thead>
                            <tr>
                                <th>User Name</th>
                                <th>Email</th>
                                <th>Message </th>
                                <th>Date </th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody id="dataTable">
                            @foreach ($data as $cat)
                            <tr class="tr-shadow ">
                                <td class="">{{ $cat->name }}</td>
                                <td class="">{{ $cat->email }}</td>
                                <td class="">{{ Str::limit($cat->message, 20, '...') }} </td>
                                <td class="">{{ $cat->created_at->format('F-j-Y') }}</td>
                                <td class="">
                                    <div class="table-data-feature">
                                        <a href="{{ route('user.contactDetail',$cat->id) }}">
                                            <button class="item me-1 mr-2" data-toggle="tooltip" data-placement="top" title="View">
                                                <i class="zmdi zmdi-mail-send "></i>
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
                        {{ $data->appends(request()->query())->links() }}
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
