@extends('user.layouts.master')

@section('content')
<div class="container-fluid">
<div class="row px-xl-5">
    <div class="col-lg-8 offset-2 table-responsive mb-5">
        <table class="table table-light table-borderless table-hover text-center mb-0" id='dataTable'>
            <thead class="thead-dark">
                <tr>
                    <th>Order ID</th>
                    <th>Total Price</th>
                    <th>Date</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody class="align-middle">
                @foreach ($order as $c)
                <tr>
                    <td class="align-middle" >{{ $c->order_code }}</td>
                    <td class="align-middle" >{{ $c->total_price }} kyats</td>
                    <td class="align-middle" >{{ $c->created_at->format('j-F-Y') }} </td>
                    <td class="align-middle" >
                        @if ($c->status   == 0)
                            <button class="btn btn-sm bg-dark text-white rounded-lg">Pending</button>
                        @elseif ($c->status   == 1)
                            <button class="btn btn-sm btn-success rounded-lg">Success</button>
                        @elseif ($c->status   == 2)
                            <button class="btn btn-sm btn-warning rounded-lg ">Reject</button>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="mt-3">
            {{ $order->links() }}
        </div>
    </div>
</div>
</div>
@endsection

@section('script')
    <script>
       $(document).ready(function(){

        //event for plus button
        $('.btn-plus').click(function(){
            $parentNode = $(this).parents("tr");
            $price = $parentNode.find("#pizzaPrice").val();
            $qty = parseInt($parentNode.find("#qty").val());
            $total = $price * $qty;
            $parentNode.find('#total').html($total + ' kyats');
            summaryCalculation();

        });

        //event for minus button
        $('.btn-minus').click(function(){
            $parentNode = $(this).parents("tr");
            $price = $parentNode.find("#pizzaPrice").val();
            $qty = parseInt($parentNode.find("#qty").val());
            $total = $price * $qty;
            $parentNode.find('#total').html($total + ' kyats');
            summaryCalculation();
        })
       });

       //remove button
       $('.btn-danger').click(function(){
        $parentNode = $(this).parents("tr");
        $parentNode.remove();
        summaryCalculation();
       });

       function summaryCalculation(){
        $finalPrice = 0;
            $('#dataTable tbody tr').each(function(index,row){
                $finalPrice += Number($(row).find('#total').text().replace('kyats',''));
            })
            $('#subTotal').html(`${$finalPrice} kyats`);
            $('#allTotal').html(`${$finalPrice + 2000} kyats`);
       }

       //checkout
       $('#btnToCheckout').click(function(){
            $orderList = [];
            $random = Math.floor(Math.random() * 1000001);
            $('#dataTable tbody tr').each(function(index,row){
                $orderList.push({
                    'user_id' : $(row).find('#userId').val(),
                    'product_id' : $(row).find('#productId').val(),
                    'qty' : $(row).find('#qty').val(),
                    'total' : $(row).find('#total').text().replace('kyats' , '')*1,
                    'order_code' : '000' + $random
                });
            })
            $.ajax({
                url : 'user/ajax/order',
                method : 'get',
                data : Object.assign({}, $orderList),
                dataType : 'json',
                success : function(response){
                    if(response.status == 'success'){
                        location.href = 'user/home'
                    }
                }
            })
       });
    </script>
@endsection
