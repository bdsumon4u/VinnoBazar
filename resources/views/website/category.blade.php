@extends('website.layout')
@section('content')
    <section class="section-name bg padding-y-sm">
        <div class="container">
            <header class="section-heading">
                <h4 class="section-title">{{ $category->categoryName }}</h4>
            </header>
            <div class="row no-gutters">
                @foreach ($categoryProducts as $product)
                    <div class="col-md-2 col-6">
                        <div href="#" class="card card-product-grid product-box-2">
                            <a href="{{ url('/product/' . $product->id) }}" class="img-wrap">
                                <img class="img-fit lazyload" src="{{ url('product/thumbnail/default.jpg') }}"
                                    data-src="{{ url('/product/thumbnail/' . $product->productImage) }}"
                                    alt="{{ $product->productName }}">
                            </a>
                            <figcaption class="info-wrap">
                                <a href="{{ url('/product/' . $product->id) }}"
                                    class="title text-truncate">{{ $product->productName }}</a>
                                <div class="price mt-1 text-center">
                                    {!! $product->htmlPrice() !!}
                                </div>
                            </figcaption>
                            <button class="btn btn-success btn-sm btn-block" onclick="addToCart({{ $product->id }})">
                                <i class="fa fa-shopping-cart" aria-hidden="true"></i> অর্ডার করুন
                            </button>
                        </div>
                    </div> <!-- col.// -->
                @endforeach
            </div>
            <div style=" display: flex; justify-content: center; margin-top: 39px; ">
                {{ $categoryProducts->links() }}
            </div>
        </div>
    </section>
@endsection
