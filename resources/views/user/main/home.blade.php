
@extends('user.layouts.master')

@section('content')
<div class="container-fluid">
    <div class="row px-xl-5">
        <!-- Shop Sidebar Start -->
        <div class="col-lg-3 col-md-4">
            <!-- Price Start -->
            <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">Filter by price</span></h5>
            <div class="bg-light p-4 mb-30">
                <form>
                    <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3 bg-dark text-white px-3 py-1 ">
                        <input type="checkbox" class="custom-control-input" checked id="price-all">
                        <label class="mt-2" for="price-all">Category</label>
                        <span class="badge border font-weight-normal">{{ count($category) }}</span>
                    </div>
                    <div class=" d-flex align-items-center justify-content-between">
                        <a class="text-dark text-decoration-none" href="{{ route('user.home')}}" for="price-5">All</a>
                    </div>
                    @foreach ($category as $c)
                        <div class=" d-flex align-items-center justify-content-between my-3">
                            <a class="text-dark text-decoration-none" href="{{ route('user.filter',$c->id) }}" for="price-5">{{ $c->name }}</a>
                        </div>
                    @endforeach
                </form>
            </div>
            <!-- Price End -->

            <div class="">
                <button class="btn btn btn-warning w-100">Order</button>
            </div>
            <!-- Size End -->
        </div>
        <!-- Shop Sidebar End -->


        <!-- Shop Product Start -->
        <div class="col-lg-9 col-md-8">
            <div class="row pb-3">
                <div class="col-12 pb-1">
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <div>
                            <a href="{{ route('user.cartList') }}">
                                <button class="btn bg-dark rounded text-white position-relative" type="button">
                                    <i class="fa-solid fa-cart-plus"></i>
                                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                        {{ count($cart) }}
                                    </span>
                                </button>
                            </a>

                            <a href="{{ route('user.history') }}">
                                <button class="btn bg-dark rounded text-white position-relative ms-3" type="button">
                                    <i class="fa-solid fa-clock-rotate-left"></i> History
                                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                        {{ count($order) }}
                                    </span>
                                </button>
                            </a>
                        </div>

                        <div class="ml-2">
                            <div class="btn-group">
                                <select name="sorting" class="form-control rounded" id="sorting" onchange="sortingOperation()">
                                    <option value="">Choose Option...</option>
                                    <option value="asc">Ascending</option>
                                    <option value="desc">Descending</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

            {{-- Alert for update password success --}}
            @if (session('changePassword'))
            <div class="col-8 offset-2">
                <div class="alert alert-info alert-dismissible fade show" role="alert">
                    <i class="fa-solid fa-cloud-arrow-up"></i> {{ session('changePassword') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
            @endif

            {{-- Alert for update profile success --}}
            @if (session('updateSuccess'))
            <div class="col-8 offset-2">
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fa-solid fa-person-arrow-up-from-line"></i> {{ session('updateSuccess') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
            @endif

            {{-- Alert for add to cart success --}}
            @if (session('createSuccess'))
            <div class="col-8 offset-2">
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fa-solid fa-person-arrow-up-from-line"></i> {{ session('createSuccess') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
            @endif

            <span class="row" id="sortingList">
                @if (count($pizza) > 0)
                @foreach ($pizza as $p)
                <div class="col-lg-4 col-md-6 col-sm-6 pb-1">
                    <div class="product-item bg-light mb-4">
                        <div class="product-img position-relative overflow-hidden" style="height: 300px">
                            <img class="img-fluid w-100" src="{{ asset('storage/'.$p->image) }}" alt="">
                             <div class="product-action">
                                <a class="btn btn-outline-dark btn-square" href=""><i class="fa fa-shopping-cart"></i></a>
                                <a class="btn btn-outline-dark btn-square" href="{{ route('user.pizzaDetail',$p->id) }}"><i class="fa-solid fa-circle-info"></i></a>
                            </div>
                        </div>
                        <div class="text-center py-4">
                            <a class="h6 text-decoration-none text-truncate" href="">{{ $p->name }}</a>
                            <div class="d-flex align-items-center justify-content-center mt-2">
                                <h5>{{ $p->price }} kyats</h5>
                            </div>
                            <div class="d-flex align-items-center justify-content-center mb-1">
                                <small class="fa fa-star text-primary mr-1"></small>
                                <small class="fa fa-star text-primary mr-1"></small>
                                <small class="fa fa-star text-primary mr-1"></small>
                                <small class="fa fa-star text-primary mr-1"></small>
                                <small class="fa fa-star text-primary mr-1"></small>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
                @else
                    <h2 class="shadow-sm text-center my-5 col-6 offset-3">There is no pizza <i class="fa-solid fa-pizza-slice"></i></h2>
                @endif
            </span>
            </div>
        </div>
        <!-- Shop Product End -->
    </div>
</div>
@endsection

@section('script')
<script>
    function sortingOperation(){
        let sortingValue = document.getElementById('sorting').value;
        if(sortingValue == 'asc'){
         $.ajax({
            url: '/user/ajax/pizza/list',
            type: 'get',
            data: {'status' : 'asc'},
            dataType: 'json',
            success: function(response){
                let $list = '';
                for($i=0; $i<response.length; $i++){
                    $list += `
                <div class="col-lg-4 col-md-6 col-sm-6 pb-1">
                    <div class="product-item bg-light mb-4">
                        <div class="product-img position-relative overflow-hidden" style="height: 300px">
                            <img class="img-fluid w-100" src="{{ asset('storage/${response[$i].image}') }}" alt="">
                             <div class="product-action">
                                <a class="btn btn-outline-dark btn-square" href=""><i class="fa fa-shopping-cart"></i></a>
                                <a class="btn btn-outline-dark btn-square" href=""><i class="fa-solid fa-circle-info"></i></a>
                            </div>
                        </div>
                        <div class="text-center py-4">
                            <a class="h6 text-decoration-none text-truncate" href="">${response[$i].name}</a>
                            <div class="d-flex align-items-center justify-content-center mt-2">
                                <h5>20000 kyats</h5><h6 class="text-muted ml-2"><del>${response[$i].price}</del></h6>
                            </div>
                            <div class="d-flex align-items-center justify-content-center mb-1">
                                <small class="fa fa-star text-primary mr-1"></small>
                                <small class="fa fa-star text-primary mr-1"></small>
                                <small class="fa fa-star text-primary mr-1"></small>
                                <small class="fa fa-star text-primary mr-1"></small>
                                <small class="fa fa-star text-primary mr-1"></small>
                            </div>
                        </div>
                    </div>
                </div>
                    `;
                }
                document.getElementById('sortingList').innerHTML = $list ;
            }
        });
    }else if(sortingValue == 'desc'){
        $.ajax({
            url: '/user/ajax/pizza/list',
            type: 'get',
            data: {'status' : 'desc'},
            dataType: 'json',
            success: function(response){
                let $list = '';
                for($i=0; $i<response.length; $i++){
                    $list += `
                <div class="col-lg-4 col-md-6 col-sm-6 pb-1">
                    <div class="product-item bg-light mb-4">
                        <div class="product-img position-relative overflow-hidden" style="height: 300px">
                            <img class="img-fluid w-100" src="{{ asset('storage/${response[$i].image}') }}" alt="">
                             <div class="product-action">
                                <a class="btn btn-outline-dark btn-square" href=""><i class="fa fa-shopping-cart"></i></a>
                                <a class="btn btn-outline-dark btn-square" href=""><i class="fa-solid fa-circle-info"></i></a>
                            </div>
                        </div>
                        <div class="text-center py-4">
                            <a class="h6 text-decoration-none text-truncate" href="">${response[$i].name}</a>
                            <div class="d-flex align-items-center justify-content-center mt-2">
                                <h5>20000 kyats</h5><h6 class="text-muted ml-2"><del>${response[$i].price}</del></h6>
                            </div>
                            <div class="d-flex align-items-center justify-content-center mb-1">
                                <small class="fa fa-star text-primary mr-1"></small>
                                <small class="fa fa-star text-primary mr-1"></small>
                                <small class="fa fa-star text-primary mr-1"></small>
                                <small class="fa fa-star text-primary mr-1"></small>
                                <small class="fa fa-star text-primary mr-1"></small>
                            </div>
                        </div>
                    </div>
                </div>
                    `;
                }
                document.getElementById('sortingList').innerHTML = $list ;
            }
        });
    }
}

</script>

@endsection
