@extends('admin.layouts.master')

@section('title','Admin List')

@section('content')
<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="col-md-12">
                <!-- DATA TABLE -->
                <div class="table-data__tool">
                    <div class="table-data__tool-left">
                        <div class="overview-wrap">
                            <h2 class="title-1">Admin List</h2>
                        </div>
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
                        <h3 class="text-muted">Total - ({{ $admin->total() }})</h3>
                    </div>
                </div>

                <div class="table-responsive table-responsive-data2">
                    @if (count($admin) > 0)
                    <table class="table table-data2 text-center">
                        <thead>
                            <tr>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Gender</th>
                                <th>Phone</th>
                                <th>Address</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($admin as $cat)
                            <tr class="tr-shadow ">
                                <input type="hidden" id='user_id' value="{{ $cat->id }}">
                                <td class="3">
                                    @if ($cat->image != null)
                                        <img src="{{ asset('storage/'.$cat->image) }}"  class="img-thumbnail" >
                                    @elseif($cat->image == null)
                                        @if ($cat->gender == 'Male')
                                            <img src="{{ asset('images/default_user.png') }}" class="img-thumbnail" />
                                        @elseif ($cat->gender == 'Female')
                                            <img src="{{ asset('images/female_user.jpg') }}" class="img-thumbnail" />
                                        @endif
                                    @endif
                                </td>
                                <td class="">{{ $cat->name }}</td>
                                <td class="">{{ $cat->email }}</td>
                                <td class="">{{ $cat->gender }}</td>
                                <td class=""> {{ $cat->phone }}</td>
                                <td class=""> {{ $cat->address }}</td>

                                <td class="">
                                    <div class="table-data-feature">
                                        @if (Auth::user()->id == $cat->id)

                                        @else

                                        <select name="role" class=" mr-2 changeRole " >
                                            <option value="admin" @if($cat->role == 'admin') selected @endif>Admin</option>
                                            <option value="user" @if($cat->role == 'user') selected @endif>User</option>
                                        </select>

                                        <a href="{{ route('admin.delete',$cat->id) }}">
                                            <button class="item" data-toggle="tooltip" data-placement="top" title="Delete">
                                                <i class="zmdi zmdi-delete"></i>
                                            </button>
                                        </a>

                                        @endif
                                    </div>
                                </td>
                            </tr>
                            <tr class="spacer"></tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="mt-3">
                        {{ $admin->appends(request()->query())->links() }}
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

@section('script')
<script>
    $(document).ready(function(){
        $('.changeRole').change(function(){
            $currentRole = $(this).val();
            $parentNode = $(this).parents('tr');
            $user_id = $parentNode.find('#user_id').val();
            $.ajax({
                url : '/admin/change/role',
                method : 'get',
                data : {'role' : $currentRole, 'user_id' : $user_id},
                dataType : 'json',
            });
            location.reload();
        });
    });
</script>
@endsection
