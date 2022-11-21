@extends('admin.layouts.master')

@section('title','Order List')

@section('content')
<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">

                <div class="table-responsive table-responsive-data2">
                    @if (count($detail) > 0)

                    <a href="{{ route('order.list') }}" class="text-dark"><i class="fa-solid fa-arrow-left mr-2"></i>Back</a>

                    <div class="row">
                        <div class="col-6">
                            <div class="card mt-3">
                                <div class="card-body" >
                                    <h3 ><i class="fa-solid fa-clipboard mr-2"></i>Order Info</h3>
                                    <small class="text-warning mt-4"><i class="fa-solid fa-triangle-exclamation mr-2"></i>Include Delivery Charges</small>
                                </div>
                                <div class="card-body">
                                    <div class="row mb-3">
                                        <div class="col"><i class="fa-solid fa-user mr-2"></i>Customer Name</div>
                                        <div class="col">{{ strtoupper($detail[0]->user_name) }}</div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col"><i class="fa-solid fa-bars mr-2"></i>Order Code</div>
                                        <div class="col">{{ $detail[0]->order_code }}</div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col"><i class="fa-solid fa-barcode mr-2"></i>Order Date</div>
                                        <div class="col">{{ $detail[0]->created_at->format('F-j-Y') }}</div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col"><i class="fa-solid fa-money-bill-1-wave mr-2"></i>Total Price </div>
                                        <div class="col">{{ $total_price->total_price }} Kyats</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <table class="table table-data2 text-center">
                        <thead>
                            <tr>
                                <th>Order ID</th>
                                <th>Product Image</th>
                                <th>Product Name</th>
                                <th>Quantity</th>
                                <th>Amount</th>
                            </tr>
                        </thead>
                        <tbody id="dataTable">
                            @foreach ($detail as $cat)
                            <tr class="tr-shadow ">
                                <td>{{ $cat->id }}</td>
                                <td class="col-2"><img src="{{ asset('storage/'.$cat->product_image) }}" class="img-thumbnail shadow-sm"></td>
                                <td>{{ $cat->product_name }}</td>
                                <td>{{ $cat->qty }}</td>
                                <td>{{ $cat->total}} Kyats</td>
                            </tr>
                            <tr class="spacer"></tr>
                            @endforeach
                        </tbody>
                    </table>
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


