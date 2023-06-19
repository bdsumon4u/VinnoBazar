@extends('website.layout')
@section('content')

	<section class="section-name bg mt-2">
		<div class="container">
			<div class="card">
				<div class="row no-gutters single-product">
					<div class="col-md-5">
						<div id="single-product-galary" class="slider-home-banner carousel slide" data-ride="carousel">
							<div class="carousel-inner rounded">

								<div class="carousel-item active">
									<a href="javascript:void(0)" data-toggle="modal" data-target="#lightbox">
										<img src="{{ url('/public/product/'.$product->productImage)  }}" alt="First slide" class="img-responsive img-thumbnail">
									</a>
								</div>

							</div>
							<ol class="carousel-indicators">
								<li data-target="#single-product-galary" data-slide-to="0" class="active">
									<img class="img-thumbnail" alt="" src="{{ url('/public/product/thumbnail/'.$product->productImage)  }}">
								</li>
							</ol>
						</div>
					</div>
					<div class="col-md-7 border-left">
						<div class="content-body">
							<h4 class="title">{{ $product->productName  }}</h4>
							<div class="mb-3" style="font-size: 20px;">
                                {!! $product->htmlPrice() !!}
							</div>
							<div class="row">
								<div class=" col-md flex-grow-1">
									<div class="input-group mb-3 input-spinner">
										<div class="input-group-prepend">
											<button class="btn btn-light btn-number" type="button" data-type="plus" data-field="quantity"> + </button>
										</div>
										<input type="text" class="form-control input-number" value="1" name="quantity" min="1" max="10">
										<div class="input-group-append">
											<button class="btn btn-light btn-number" type="button" data-type="minus" data-field="quantity" > − </button>
										</div>
									</div>
								</div> <!-- col.// -->
							</div> <!-- row.// -->
							<div class="single-product-buttons">
								<button class="btn  btn-info"  onclick="buyNow({{ $product->id }})">  অর্ডার করুন </button>
								<button class="btn  btn-danger"   onclick="addToCart({{ $product->id }})"> <span class="text">কার্টে রাখুন</span>
                                    <i class="fas fa-shopping-cart"></i> </button>
							</div>
							<div class="call-now-button mt-3">
                                <a href="tel:{{ Settings::get('phone_number') }}" class="btn btn-block btn-primary">
                                    কল করতে ক্লিক করুন  (সকাল ১০টা থেকে রাত ১০টা)<br>
                                    <i class="fa fa-phone" aria-hidden="true"></i> {{ Settings::get('phone_number') }}
                                </a>
							</div>
                            <div class="col-sm-12 col-md-12  col-xs-12" style="padding: 0">
                                {!!  Settings::get('product_bottom_text')  !!}
                            </div>
							<table class="table">
								<tbody>
								   <tr>
									  <td>
										 ঢাকায় ডেলিভারি খরচ
									  </td>
									  <td>
										 <b>৳  60.00</b>
									  </td>
								   </tr>
								   <tr>
									  <td>
										 ঢাকার বাইরে কুরিয়ারে ডেলিভারি খরচ
									  </td>
									  <td>
										 <b>৳ 120.00</b>
									  </td>
								   </tr>
								   <tr>
									  <td>
										 ঢাকার বাইরে হোম ডেলিভারি খরচ
									  </td>
									  <td>
										 <b>৳ 150.00</b>
									  </td>
								   </tr>

								</tbody>
							 </table>
                        </div>
                    </div>
				</div>
            </div>
			<div class="card mt-2">
				<div class="card-body">
					<div class="tabs tabs--style-2">
						<ul class="bor-rtop-lr  nav nav-tabs sticky-top bg-white">
							<li class="nav-item">
								<a href="#tab_default_1" data-toggle="tab" class="nav-link text-uppercase strong-600 active show">Description</a>
							</li>
						</ul>
						<div class="tab-content pt-0">
							<div class="tab-pane active show p-2" id="tab_default_1">
                                {!! $product->productDetails !!}
							</div>
						  </div>
					</div>
				</div>
			</div>
		</div>
	</section>
    <section class="section-name bg padding-y-sm">
        <div class="container">
            <header class="section-heading">
                <h4 class="section-title">Related products</h4>
            </header>
            <div class="row no-gutters">
                @foreach($relatedProducts as $product)
                    <div class="col-md-2 col-6">
                        <div href="#" class="card card-product-grid product-box-2">
                            <a href="{{ url('/product/'.$product->id)  }}" class="img-wrap">
                                <img class="img-fit lazyload"   src="{{ url('public/product/thumbnail/default.jpg') }}"  data-src="{{ url('/public/product/thumbnail/'.$product->productImage)  }}" alt="{{ $product->productName  }}">
                            </a>
                            <figcaption class="info-wrap">
                                <a href="{{ url('/product/'.$product->id)  }}" class="title text-truncate">{{ $product->productName  }}</a>
                                <div class="price mt-1 text-center">
                                    {!! $product->htmlPrice() !!}
                                </div>
                            </figcaption>
                            <button class="btn btn-success btn-sm btn-block" onclick="addToCart({{ $product->id }})">
                                <i class="fa fa-shopping-cart"  aria-hidden="true"></i> অর্ডার করুন
                            </button>
                        </div>
                    </div> <!-- col.// -->
                @endforeach
            </div>
        </div>
    </section>

    <div id="lightbox" class="modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-middle">
            <div class="modal-content">
                <button type="button" class="close" data-dismiss="modal">×</button>
                <div class="modal-body">
                    <img class="img-responsive img-thumbnail" src="" alt="" />
                </div>
            </div>
        </div>
    </div>

@endsection
