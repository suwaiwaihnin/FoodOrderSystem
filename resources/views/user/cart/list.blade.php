@extends('user.layouts.master')

@section('content')
<div class="container-fluid">
<div class="row px-xl-5">
    <div class="col-lg-8 table-responsive mb-5">
        <table class="table table-light table-borderless table-hover text-center mb-0" id='dataTable'>
            <thead class="thead-dark">
                <tr>
                    <th></th>
                    <th>Products</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Total</th>
                    <th>Remove</th>
                </tr>
            </thead>
            <tbody class="align-middle">
                @foreach ($cart as $c)
                <tr>
                    <input type="hidden" name="pizzaPrice" value="{{ $c->price }}" id='pizzaPrice'>
                    <input type="hidden"  value="{{ Auth::user()->id }}" id='userId'>
                    <input type="hidden"  value="{{ $c->product_id }}" id='productId'>
                    <input type="hidden"  value="{{ $c->id }}" id='cartId'>

                    <td class="align-middle"><img src="{{ asset('storage/'.$c->image) }}" class="img-thumbnail" style="width: 50px;"></td>
                    <td class="align-middle" >{{ $c->pizza_name }}</td>
                    <td class="align-middle" >{{ $c->price }} kyats</td>
                    <td class="align-middle">
                        <div class="input-group quantity mx-auto" style="width: 100px;">
                            <div class="input-group-btn">
                                <button class="btn btn-sm btn-primary btn-minus" >
                                <i class="fa fa-minus" ></i>
                                </button>
                            </div>
                            <input type="text" class="form-control form-control-sm bg-secondary border-0 text-center" id='qty' value="{{ $c->qty }}">
                            <div class="input-group-btn">
                                <button class="btn btn-sm btn-primary btn-plus">
                                    <i class="fa fa-plus" ></i>
                                </button>
                            </div>
                        </div>
                    </td>
                    <td class="align-middle" id='total'>{{ $c->qty * $c->price }} kyats</td>
                    <td class="align-middle"><button class="btn btn-sm btn-danger" ><i class="fa fa-times"></i></button></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="col-lg-4">
        <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">Cart Summary</span></h5>
        <div class="bg-light p-30 mb-5">
            <div class="border-bottom pb-2">
                <div class="d-flex justify-content-between mb-3">
                    <h6>Subtotal</h6>
                    <h6 id='subTotal'>{{ $total }} kyats</h6>
                </div>
                <div class="d-flex justify-content-between">
                    <h6 class="font-weight-medium">Delivery</h6>
                    <h6 class="font-weight-medium">2000 kyats</h6>
                </div>
            </div>
            <div class="pt-2">
                <div class="d-flex justify-content-between mt-2">
                    <h5>Total</h5>
                    <h5 id='allTotal'>{{ $total+2000 }} kyats</h5>
                </div>
                <button class="btn btn-block btn-primary font-weight-bold my-3 py-3" id='btnToCheckout'>Proceed To Checkout</button>
                <button class="btn btn-block btn-danger font-weight-bold my-3 py-3" id='deleteCart'>Delete Cart</button>
            </div>
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
        $productId = $parentNode.find('#productId').val();
        $cartId = $parentNode.find('#cartId').val();
        $.ajax({
            url : '/user/ajax/clear/cart/item',
            type : 'get',
            data : {'product_id' : $productId, 'cart_id' : $cartId},
            dataType : 'json'
        });

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
            $random = Math.floor(Math.random() * 100000001);
            $('#dataTable tbody tr').each(function(index,row){
                $orderList.push({
                    'user_id' : $(row).find('#userId').val(),
                    'product_id' : $(row).find('#productId').val(),
                    'qty' : $(row).find('#qty').val(),
                    'total' : $(row).find('#total').text().replace('kyats' , '')*1,
                    'order_code' : 'POS000' + $random
                });
            })
            $.ajax({
                url : '/user/ajax/order',
                method : 'get',
                data : Object.assign({}, $orderList),
                dataType : 'json',
                success : function(response){
                    if(response.status == 'success'){
                        location.href = '/user/home'
                    }
                }
            })
       });

       //delete cart
       $('#deleteCart').click(function(){
            $('#dataTable tbody tr').remove();
            $('#subTotal').html('0 kyats');
            $('#allTotal').html('2000 kyats');

            $.ajax({
                url : '/user/ajax/clear/cart',
                method : 'get',
                dataType : 'json'
            });
       });
    </script>
@endsection
