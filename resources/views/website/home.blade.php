@extends('website.layout')
@push('css')
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css" />
@endpush
@section('content')


    <section class="section-main bg padding-y-sm">
        <div class="container">

            <div class="row">
                <?php use App\Category;
                $category = Menu::getByName('Category Menu'); ?>
                <div class="{{ $category ? 'col-lg-9' : 'col-lg-12' }} order-lg-2">
                    <div id="carousel1_indicator" class="slider-home-banner carousel slide" data-ride="carousel">
                        <ol class="carousel-indicators">
                            @foreach ($slides as $key => $slide)
                                <li data-target="#carousel1_indicator" data-slide-to="{{ $key }}"
                                    class="@if ($key == 0) active @endif"></li>
                            @endforeach
                        </ol>
                        <div class="carousel-inner rounded">
                            @foreach ($slides as $key => $slide)
                                <div class="carousel-item @if ($key == 0) active @endif">
                                    <a href="{{ $slide->link }}">
                                        <img class="d-block w-100 h-100" src="{{ asset('/' . $slide->image) }}"
                                            alt="{{ $slide->name }}">
                                    </a>
                                </div>
                            @endforeach
                        </div>
                        <a class="carousel-control-prev" href="#carousel1_indicator" role="button" data-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                        </a>
                        <a class="carousel-control-next" href="#carousel1_indicator" role="button" data-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="sr-only">Next</span>
                        </a>
                    </div>
                </div> <!-- col.// -->
                @if ($category)
                    <div class="col-md-3 order-lg-1">
                        <div class="all-category">
                            <span>Categories</span>
                        </div>
                        <nav class="card">
                            <ul class="menu-category">

                                @foreach ($category as $menu)
                                    <li>
                                        <a href="{{ $menu['link'] }}">
                                            <?php
                                        $category = Category::where('categoryName','like',"%{$menu['label']}%")->first();
                                        if(!empty($category->categoryImage)){ ?>
                                            <img class="cat-image d-lg-none lazyload"
                                                src="{{ asset('product/thumbnail/default.jpg') }}"
                                                data-src="{{ asset('product/thumbnail/' . $category->categoryImage) }}"
                                                width="30" alt="Special Offer">
                                            <?php } ?>
                                            <span class="cat-name">{{ $menu['label'] }}</span>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </nav>
                    </div>
                @endif

            </div> <!-- row.// -->
        </div> <!-- container //  -->
    </section>
    <section class="section-name bg padding-y-sm pt-0">
        <div class="container">
            <header class="section-heading mt-0">
                <a href="{{ url('/category/' . $slug) }}" class="btn btn-info btn-sm float-right rounded">View More</a>
                <h4 class="section-title ">Special Offer</h4>
            </header><!-- sect-heading -->
            <div class="row no-gutters popular-product-slider">

                @foreach ($topProducts as $product)
                    <div>
                        <div href="#" class="card card-product-grid product-box-2">
                            <a href="{{ url('/product/' . $product->id) }}" class="img-wrap">
                                <img class="img-fit" src="{{ asset('/product/thumbnail/' . $product->productImage) }}"
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
                    </div>
                @endforeach

            </div>
        </div><!-- container // -->
    </section>

    <section class="section-name bg padding-y-sm pt-0">
        <div class="container">
            <header class="section-heading mt-0">
                <a href="{{ url('/shop') }}" class="btn btn-info btn-sm float-right rounded">View More</a>
                <h4 class="section-title">All Products</h4>
            </header>
            <div class="row no-gutters" id="loadProducts">
                {{--                @foreach ($otherProducts as $product) --}}
                {{--                    <div class="col-md-2 col-6"> --}}
                {{--                        <div href="#" class="card card-product-grid product-box-2"> --}}
                {{--                            <a href="{{ url('/product/'.$product->id)  }}" class="img-wrap"> --}}
                {{--                                <img class="img-fit lazyload"   src="{{ asset('product/thumbnail/default.jpg') }}"  data-src="{{ asset('/product/thumbnail/'.$product->productImage)  }}" alt="{{ $product->productName  }}"> --}}
                {{--                            </a> --}}
                {{--                            <figcaption class="info-wrap"> --}}
                {{--                                <a href="{{ url('/product/'.$product->id)  }}" class="title text-truncate">{{ $product->productName  }}</a> --}}
                {{--                                <div class="price mt-1 text-center"> --}}
                {{--                                    {!! $product->htmlPrice() !!} --}}
                {{--                                </div> --}}
                {{--                            </figcaption> --}}
                {{--                            <button class="btn btn-success btn-sm btn-block" onclick="addToCart({{ $product->id }})"> --}}
                {{--                                <i class="fa fa-shopping-cart"  aria-hidden="true"></i> অর্ডার করুন --}}
                {{--                            </button> --}}
                {{--                        </div> --}}
                {{--                    </div> --}}
                {{--                @endforeach --}}
            </div>
            <div class="loading" style=" display: flex; justify-content: center; align-items: center; ">
                <svg xmlns:svg="http://www.w3.org/2000/svg" xmlns="http://www.w3.org/2000/svg"
                    xmlns:xlink="http://www.w3.org/1999/xlink" version="1.0" width="64px" height="64px"
                    viewBox="0 0 128 128" xml:space="preserve">
                    <rect x="0" y="0" width="100%" height="100%" fill="#FFFFFF" />
                    <g>
                        <path d="M59.6 0h8v40h-8V0z" fill="#000000" fill-opacity="1" />
                        <path d="M59.6 0h8v40h-8V0z" fill="#cccccc" fill-opacity="0.2" transform="rotate(30 64 64)" />
                        <path d="M59.6 0h8v40h-8V0z" fill="#cccccc" fill-opacity="0.2" transform="rotate(60 64 64)" />
                        <path d="M59.6 0h8v40h-8V0z" fill="#cccccc" fill-opacity="0.2" transform="rotate(90 64 64)" />
                        <path d="M59.6 0h8v40h-8V0z" fill="#cccccc" fill-opacity="0.2" transform="rotate(120 64 64)" />
                        <path d="M59.6 0h8v40h-8V0z" fill="#b2b2b2" fill-opacity="0.3" transform="rotate(150 64 64)" />
                        <path d="M59.6 0h8v40h-8V0z" fill="#999999" fill-opacity="0.4" transform="rotate(180 64 64)" />
                        <path d="M59.6 0h8v40h-8V0z" fill="#7f7f7f" fill-opacity="0.5" transform="rotate(210 64 64)" />
                        <path d="M59.6 0h8v40h-8V0z" fill="#666666" fill-opacity="0.6" transform="rotate(240 64 64)" />
                        <path d="M59.6 0h8v40h-8V0z" fill="#4c4c4c" fill-opacity="0.7" transform="rotate(270 64 64)" />
                        <path d="M59.6 0h8v40h-8V0z" fill="#333333" fill-opacity="0.8" transform="rotate(300 64 64)" />
                        <path d="M59.6 0h8v40h-8V0z" fill="#191919" fill-opacity="0.9" transform="rotate(330 64 64)" />
                        <animateTransform attributeName="transform" type="rotate"
                            values="0 64 64;30 64 64;60 64 64;90 64 64;120 64 64;150 64 64;180 64 64;210 64 64;240 64 64;270 64 64;300 64 64;330 64 64"
                            calcMode="discrete" dur="1080ms" repeatCount="indefinite"></animateTransform>
                    </g>
                </svg>
            </div>
            {{--            <div style=" display: flex; justify-content: center; margin-top: 39px; "> --}}
            {{--                {{ $otherProducts->links() }} --}}
            {{--            </div> --}}
        </div>
    </section>

@endsection

@push('js')
    <script type="text/javascript" src="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
    <script>
        var page = 1;
        load_more(page);
        $(window).scroll(function() {
            if ($(window).scrollTop() + $(window).height() >= $(document).height() - 50) {
                page++;
                load_more(page);
            }
        });

        function load_more(page) {

            $.ajax({
                type: "get",
                datatype: "html",
                url: '<?php echo url('/getProducts'); ?>?page=' + page,
                success: function(data) {
                    $("#loadProducts").append(data); //append data into #results element
                    lazyload();
                }
            });
        }

        $(document).ready(function() {




            $('.popular-product-slider').slick({
                slidesToShow: 5,
                rows: 2,
                prevArrow: '<button class="slide-arrow prev-arrow"><i class="fa fa-arrow-left"></i></button>',
                nextArrow: '<button class="slide-arrow next-arrow"><i class="fa fa-arrow-right"></i></button>',
                responsive: [{
                    breakpoint: 480,
                    settings: {
                        rows: 2,
                        slidesToShow: 2
                    }
                }]
            });
        });
    </script>
@endpush
