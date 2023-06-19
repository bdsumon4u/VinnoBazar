@extends('website.layout')
@section('content')

    <section class="section-name bg padding-y-sm">
        <div class="container">
            <header class="section-heading">
                <h4 class="section-title">{{ $page->pageTitle }}</h4>
            </header>
            <div class="row no-gutters">
                {!! $page->pageContent !!}
            </div>
        </div>
    </section>
    {{-- <section class="section-name bg padding-y-sm">
        <div class="container">
            <header class="section-heading">
                <h4 class="section-title">Related Products</h4>
            </header>
            <div class="row no-gutters">
                @foreach($relatedProducts as $product)
                    <div class="col-md-2 col-6">
                        <div href="#" class="card card-product-grid product-box-2">
                            <a href="{{ url('/product/'.$product->productSlug)  }}" class="img-wrap">
                                <img class="img-fit lazyload"   src="{{ url('uploads/thumbnail/default.jpg') }}"  data-src="{{ url('/uploads/thumbnail/'.$product->productImage)  }}" alt="{{ $product->productName  }}">
                            </a>
                            <figcaption class="info-wrap">
                                <a href="{{ url('/product/'.$product->productSlug)  }}" class="title text-truncate">{{ $product->productName  }}</a>
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
    </section> --}}

@endsection
