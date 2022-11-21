@extends('admin.layouts.master')

@section('title','Order List')

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
                        <h3 class="text-muted">Total - ({{ $order->total() }})</h3>
                    </div>
                </div>

                <form action="{{ route('order.sort') }}" method="get">
                    @csrf
                    <div class="d-flex">
                        <h4 class="mt-2 mr-5 text-muted">Order Status</h4>
                        <select name="status" id='status' class="form-control col-2" >
                            <option value="" >All</option>
                            <option value="0" @if(request('status') == '0') selected @endif>Pending</option>
                            <option value="1" @if(request('status') == '1') selected @endif>Accept</option>
                            <option value="2" @if(request('status') == '2') selected @endif>Reject</option>
                        </select>
                        <button class="btn btn-sm bg-dark text-white">
                            <i class="fa-solid fa-magnifying-glass mr-2"></i>Search
                        </button>
                    </div>
                </form>

                <div class="table-responsive table-responsive-data2">
                    @if (count($order) > 0)
                    <table class="table table-data2 text-center">
                        <thead>
                            <tr>
                                <th>User ID</th>
                                <th>User Name</th>
                                <th>Order Code</th>
                                <th>Order Date</th>
                                <th>Amount</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody id="dataTable">
                            @foreach ($order as $cat)
                            <tr class="tr-shadow ">
                                <input type="hidden" class="order_id" value="{{ $cat->id }}">
                                <td>{{ $cat->user_id }}</td>
                                <td>{{ $cat->user_name }}</td>
                                <td>
                                    <a href="{{ route('order.detail',$cat->order_code) }}">
                                        {{ $cat->order_code }}
                                    </a>
                                </td>
                                <td>{{ $cat->created_at->format('F-j-Y') }}</td>
                                <td>{{ $cat->total_price }} kyats</td>
                                <td>
                                    <select name="status" class="form-control changeStatus">
                                        <option value="0" @if ($cat->status == 0) selected @endif>Pending</option>
                                        <option value="1" @if ($cat->status == 1) selected @endif>Accept</option>
                                        <option value="2" @if ($cat->status == 2) selected @endif>Reject</option>
                                    </select>
                                </td>
                            </tr>
                            <tr class="spacer"></tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="mt-3">
                        {{ $order->appends(request()->query())->links() }}
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
            // $('#status').change(function(){
            //     $status = $('#status').val();
            //     $.ajax({
            //     url : 'http://localhost:8000/order/sort',
            //     method : 'get',
            //     data : {'status' : $status},
            //     dataType : 'json',
            //     success : function(response){
            //         $list = '';
            //         for($i = 0; $i < response.length; $i++){

            //             //Change Date Format
            //             $months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
            //             $db_date = response[$i].created_at;
            //             $date = new Date($db_date);
            //             $new_date = $months[$date.getMonth()] +"-"+ $date.getDate() +"-"+ $date.getFullYear();

            //             //Check Status
            //             $status = '';
            //             if(response[$i].status == 0){
            //                 $status = `
            //                         <select name="status" class="form-control changeStatus">
            //                             <option value="0"  selected >Pending</option>
            //                             <option value="1"   >Accept</option>
            //                             <option value="2"  >Reject</option>
            //                         </select>
            //                 `;
            //             }else if(response[$i].status == 1){
            //                 $status = `
            //                         <select name="status" class="form-control changeStatus">
            //                             <option value="0"   >Pending</option>
            //                             <option value="1"  selected >Accept</option>
            //                             <option value="2"  >Reject</option>
            //                         </select>
            //                 `;
            //             }else if(response[$i].status == 2){
            //                 $status = `
            //                         <select name="status" class="form-control changeStatus">
            //                             <option value="0"   >Pending</option>
            //                             <option value="1"   >Accept</option>
            //                             <option value="2" selected >Reject</option>
            //                         </select>
            //                 `;
            //             }

            //             $list += `
            //             <tr class="tr-shadow ">
            //                     <input type="hidden" class="order_id" value="${response[$i].id}">
            //                     <td> ${response[$i].user_id} </td>
            //                     <td> ${response[$i].user_name} </td>
            //                     <td> ${response[$i].order_code}</td>
            //                     <td> ${$new_date} </td>
            //                     <td> ${response[$i].total_price}  kyats</td>
            //                     <td> ${$status} </td>
            //                 </tr>
            //             `;
            //         }
            //         $('#dataTable').html($list);
            //     }
            // })
            // });

            //change status
            $('.changeStatus').change(function(){
                $currentStatus = $(this).val();
                $parentNode = $(this).parents("tr");
                $orderId = $parentNode.find(".order_id").val();
                $.ajax({
                    url : '/order/change/status',
                    method : 'get',
                    data : {'order_id' : $orderId, 'status' : $currentStatus},
                    dataType : 'json',

                })
            });
        });
    </script>
@endsection
