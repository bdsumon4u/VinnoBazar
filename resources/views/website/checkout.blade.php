@extends('website.layout')
@section('content')
    @if(Cart::count() > 0)
    <section class="section-content padding-y bg slidetop">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <aside class="card mb-4">
                        <article class="card-body">
                            <header class="mb-4">
                                <p class="text-center" style="font-size: 20px;"> <span class="text-danger">শতভাগ নিশ্চিত হয়ে অর্ডার কনফার্ম করুন </span>                                </p>
                                <p class="text-center" style="font-size: 18px;"> <span class="text-danger">পণ্যের মূল্যের সাথে ডেলিভারি চার্জ যোগ হবে।</span>                               
                    </p>
                    <p class="text-center" style="font-size: 16px;"> <span class="text-danger">ঢাকা শহরে ৬০ টাকা। সারা বাংলাদেশে ১৫০ টাকা।</span> 
                            </header>
                            <div class="row">
                                <div class="form-group col-sm-12">
                                    <label>আপনার নাম </label>
                                    <input type="text" id="customerName" placeholder="আপনার নাম লিখুন" class="form-control">
                                </div>
                                <div class="form-group col-sm-12">
                                    <label>আপনার মোবাইল নম্বর </label>
                                    <input type="number" pattern="[0-9]*" id="customerPhone" placeholder=" আপনার  ১১ সংখ্যাক মোবাইল নম্বর লিখুন"
                                           class="form-control">
                                </div>
                                <div class="form-group col-sm-12">
                                    <label>আপনার সম্পূর্ণ ঠিকানা </label>
                                    <input type="text"  id="customerAddress" class="form-control"
                                           placeholder="আপনার ঠিকানা সম্পূর্ণ  লিখুন">
                                </div>
                                
                                
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <button type="button" id="orderConfirm"
                                            class="btn btn-lg btn-info btn-base-1 btn-block btn-icon-left strong-500 hov-bounce hov-shaddow buy-now"
                                            style="font-size:20px !important;"> অর্ডার কনফার্ম করুন </button>
                                </div>
                            </div>
                        </article> <!-- card-body.// -->
                    </aside>
                </div>
                <div class="col-md-6 orderDetails">
                    <aside class="card">
                        <article class="card-body">
                            <header class="mb-4">
                                <h4 class="card-title" style="font-size: 16px;">আপনার অর্ডার</h4>
                            </header>
                            <div class="row">
                                <div class="table-responsive bg-white">
                                    <table class="table border-bottom">
                                        <thead>
                                        <tr>
                                            <th class="product-image">Image</th>
                                            <th class="product-name">Product</th>
                                            <th class="product-price">Price</th>
                                            <th class="product-quanity">Quantity</th>
                                            <th class="product-total">Total</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach(Cart::content() as $item)
                                        <tr class="cart-item">
                                            <td class="product-image" style="display: flex; flex-direction: row-reverse;">
                                                <a href="#" >
                                                    <img class="lazyload" src="{{ url('/public/product/thumbnail/'.$item->model->productImage) }}" style="max-width: 50px">
                                                </a>
                                                <button href="#"  onclick="removeFromCart('{{ $item->rowId }}')" class="btn btn-danger btn-sm">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </td>

                                            <td class="product-name">
                                                <span class="d-block">{{ $item->model->productName }}</span>
                                            </td>

                                            <td class="product-price">
                                                <span class="d-block">TK {{ $item->model->price() }}</span>
                                            </td>

                                            <td class="product-quantity">
                                                <div class="input-group input-spinner">
                                                    <div class="input-group-prepend">
                                                        <button class="btn btn-light btn-number" type="button" data-type="plus" data-field="quantity[{{ $item->id }}]"> + </button>
                                                    </div>
                                                    <input type="text" name="quantity[{{ $item->id }}]" class="form-control input-number" placeholder="1" value="{{ $item->qty }}" min="1" max="10" onchange="updateQuantity('{{ $item->rowId }}', this)">
                                                    <div class="input-group-append">
                                                        <button class="btn btn-light btn-number" type="button" data-type="minus"  data-field="quantity[{{ $item->id }}]"> − </button>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="product-total">
                                                <span>TK {{Cart::subtotal('0','','')}}</span>
                                            </td>

                                        </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </article>
                        <article class="card-body border-top">
                            <dl class="row">
                                <dt class="col-sm-8">Subtotal: </dt>
                                <dd class="col-sm-4 text-right"><strong class="h5 text-dark">TK <?php echo Cart::total('0') ?></strong></dd>

                                

                                                          </dl>

                        </article>
                        
                        
                        <p class="text-center" style="font-size: 18px;"> <span class="text-danger">পণ্যের মূল্যের সাথে ডেলিভারি চার্জ যোগ হবে।</span>                               
                    </p>
                    <p class="text-center" style="font-size: 16px;"> <span class="text-danger">ঢাকা শহরে ৬০ টাকা। সারা বাংলাদেশে ১৫০ টাকা।</span> 
                        
                        
                        
                        
                        

                    </aside>
                </div>

            </div>
        </div>
    </section>
    @else
        <div class="container pb-5 mb-sm-4">
            <div class="pt-5">
                <div class="card py-3 mt-sm-3">
                    <div class="card-body text-center">
                        <h2 class="h4 pb-3">কোন প্রোডাক্ট নেই</h2>
                        <a class="btn btn-primary mt-3" href="{{url('/')}}">প্রোডাক্ট বাছাই করুন</a>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection

@push('js')
    <script>
        $(document).ready(function () {

            $('#selectCourier').on('change',function (e) {
                var selectCourier = +$('#selectCourier option:selected').val();
                $.ajax({
                    type: "get",
                    url: "{{url('/updateDeliveryCharge')}}",
                    data: {
                        'selectCourier':selectCourier,
                        '_token': '{{ csrf_token() }}'
                    },
                    success: function () {
                        updateQuantity(0,0);
                    }
                });
            });

            $(document).on("click", "#orderConfirm", function () {
                constantValue = 0;
                var customerName = $('#customerName');
                var customerAddress = $('#customerAddress');
                var customerPhone = $('#customerPhone');
                var selectCourier = $('#selectCourier option:selected');
                if (!customerName.val()) {
                    customerName.addClass("has-error");
                    constantValue = 1;
                }
                if (!customerAddress.val()) {
                    customerAddress.addClass("has-error");
                    constantValue = 1;
                }
                if (!customerPhone.val()) {
                    customerPhone.addClass("has-error");
                    constantValue = 1;
                }
                console.log(selectCourier.val())
                if (selectCourier.val() === '') {
                    selectCourier.addClass("has-error");
                    showFrontendAlert('error', 'Unsuccessful to Place order');
                    constantValue = 1;
                }
                if (constantValue === 1) {
                    $('html, body').animate(  {  scrollTop: $('body').position().top  },  500   );
                } else {
                    $.ajax({
                        type: "post",
                        url: "{{url('/placeOrder')}}",
                        data: {
                            'customerName': customerName.val(),
                            'customerAddress': customerAddress.val(),
                            'customerPhone': customerPhone.val(),
                            'selectCourier': selectCourier.val(),
                            '_token': '{{ csrf_token() }}'
                        },
                        success: function (data) {
                            if(data['status'] === 'success'){
                                showFrontendAlert('success', data['message']);
                                window.location.href = data['link'];
                            }else if(data['status'] === 'failed'){
                                showFrontendAlert('error', data['message']);
                            }else{
                                showFrontendAlert('error', 'Unsuccessful to Place order');
                            }
                        }
                    });
                }
            });
        });
    </script>

@endpush

