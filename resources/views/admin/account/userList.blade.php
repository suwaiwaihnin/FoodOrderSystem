@extends('admin.layouts.master')

@section('title','User List')

@section('content')
<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="col-md-12">
                <!-- DATA TABLE -->
                <div class="table-data__tool">
                    <div class="table-data__tool-left">
                        <div class="overview-wrap">
                            <h2 class="title-1">User List</h2>

                        </div>
                    </div>
                </div>

                <div class="row my-2">
                    <div class="col-5">
                        <h3 class="text-muted">Total - ({{ $user->total() }})</h3>
                    </div>
                </div>

                <div class="table-responsive table-responsive-data2">
                    <table class="table table-data2 text-center">
                        <thead>
                            <tr>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Gender</th>
                                <th>Phone</th>
                                <th>Address</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($user as $cat)
                            <tr class="tr-shadow ">
                                <td class="col-5">
                                    <input type="hidden" id='user_id' value="{{ $cat->id }}">
                                    @if ($cat->image != null)
                                        <img src="{{ asset('storage/'.$cat->image) }}" class="img-thumbnail" >
                                    @elseif($cat->image == null)
                                        @if ($cat->gender == 'Male')
                                            <img src="{{ asset('images/default_user.png') }}" class="img-thumbnail " />
                                        @elseif ($cat->gender == 'Female')
                                            <img src="{{ asset('images/female_user.jpg') }}"  class="img-thumbnail"/>
                                        @endif
                                    @endif
                                </td>
                                <td class="col-1">{{ $cat->name }}</td>
                                <td  class="col-1">{{ $cat->email }}</td>
                                <td class="col-1">{{ $cat->gender }}</td>
                                <td class="col-1">{{ $cat->phone }}</td>
                                <td class="col-1">{{ $cat->address }}</td>

                                <td class="1">
                                    <div class="table-data-feature">

                                        <select name="role" class="mr-2 changeRole" >
                                            <option value="admin" @if($cat->role == 'admin') selected @endif>Admin</option>
                                            <option value="user" @if($cat->role == 'user') selected @endif>User</option>
                                        </select>

                                        <a href="{{ route('user.edit',$cat->id) }}">
                                            <button class="item mr-2" data-toggle="tooltip" data-placement="top" title="Edit">
                                                <i class="zmdi zmdi-edit"></i>
                                            </button>
                                        </a>

                                        <a href="{{ route('admin.delete',$cat->id) }}">
                                            <button class="item" data-toggle="tooltip" data-placement="top" title="Delete">
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
                        {{ $user->appends(request()->query())->links() }}
                    </div>
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
