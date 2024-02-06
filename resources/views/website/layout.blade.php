<!DOCTYPE HTML>
<html lang="en">

<head>
    @include('googletagmanager::head')
    <meta charset="utf-8">
    <meta http-equiv="pragma" content="no-cache" />
    <meta http-equiv="cache-control" content="max-age=604800" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('images/favicon.ico') }}">

    <title>{{ Settings::get('site_name') }}</title>

    <script src="{{ asset('assets/js/jquery-2.0.0.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
    <link href="{{ asset('assets/css/bootstrap.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/fonts/fontawesome/css/all.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/ui.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/responsive.css') }}" rel="stylesheet" type="text/css"
        media="only screen and (max-width: 1200px)" />
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet" type="text/css" />
    <link type="text/css" href="{{ asset('assets/css/sweetalert2.min.css') }}" rel="stylesheet">
    @stack('css')
    {!! Settings::get('facebook_pixels') !!}

</head>

<body>
    @include('googletagmanager::body')
    <div class="mobile-side-menu d-lg-none hide">
        <div class="side-menu-overlay " onclick="sideMenuClose()"></div>
        <div class="side-menu-wrap">
            <div class="side-menu closed">
                <div class="d-flex px-3 py-3 align-items-center bg-success" style=" justify-content: space-between; ">
                    <div class="widget-profile-box  d-flex align-items-center">

                        <img class="logo" src="{{ asset('/' . Settings::get('site_logo')) }}"
                            alt="{{ Settings::get('site_name') }}" style="    max-width: 100px;" class="w-50">
                    </div>
                    <div class="side-menu-close">
                        <i class="fa fa-times" aria-hidden="true"></i>
                    </div>
                </div>
                <div class="side-menu-list px-3">
                    <ul>
                        <?php $category = Menu::getByName('Category Menu'); ?>
                        @foreach ($category as $menu)
                            <li class="">
                                <a href="{{ $menu['link'] }}" title=""><i class="fa fa-dot-circle-o"></i>
                                    {{ $menu['label'] }}</a>
                            </li>
                        @endforeach
                        <li>
                            <a href="tel:{{ Settings::get('phone_number') }}" class="">
                                <i class="fa fa-phone"></i>
                                <span class="category-name"> {{ Settings::get('phone_number') }} </span>
                            </a>
                        </li>

                    </ul>
                </div>
            </div>
        </div>
    </div>

    <header class="section-header">
        <section class="header-main border-bottom">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-2 col-6 d-flex align-items-center">
                        <button class="navbar-toggler menu-toggle d-lg-none d-block mr-2" type="button">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <a href="{{ url('/') }}" class="brand-wrap">
                            <img class="logo" src="{{ asset('/' . Settings::get('site_logo')) }}"
                                alt="{{ Settings::get('site_name') }}">
                        </a> <!-- brand-wrap.// -->
                    </div>
                    <div class="col-lg-9 col-sm-12 search-box">
                        <form action="{{ url('/shop') }}" class="search">
                            <div class="input-group w-100">
                                <div class="d-lg-none search-box-back">
                                    <button class="" type="button"><i class="fa fa-arrow-left"></i></button>
                                </div>
                                <input type="text" name="q" class="form-control" placeholder="Search">
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="submit">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </form> <!-- search-wrap .end// -->
                    </div> <!-- col.// -->
                    <div class="col-lg-1 col-sm-6 col-6">
                        <div class="widgets-wrap float-right">
                            <div class="widget-header mr-4 nav-search-box d-lg-none">
                                <a href="#" class="icon icon-xs rounded-circle border"><i class="fa fa-search"
                                        aria-hidden="true"></i></a>
                            </div>
                            <div class="widget-header">

                                <div class="nav-cart-box dropdown" id="cart_items">
                                    <span class="badge badge-pill badge-danger notify">0</span>
                                    <a href="" class="icon icon-xs rounded-circle border" data-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="true">
                                        <i class="fa fa-shopping-cart d-inline-block nav-box-icon"></i>
                                        <span class="badge badge-pill badge-danger notify">0</span>
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-right px-0" x-placement="bottom-end"
                                        style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(-328px, 32px, 0px);">

                                        <li>
                                            <div class="dropdown-cart px-0">
                                                <div class="dc-header">
                                                    <h4 class="text-center py-2">Empty Cart</h4>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>


                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </section>
    </header>
    <?php $header = Menu::getByName('Header Menu'); ?>
    @if ($header)
        <nav class="navbar navbar-main navbar-expand-lg navbar-light border-bottom d-none d-lg-block">
            <div class="container">
                <div class="collapse navbar-collapse" id="main_nav">
                    <ul class="navbar-nav">
                        @foreach ($header as $menu)
                            <li class="nav-item dropdown">
                                <a class="nav-link" href="{{ $menu['link'] }}">{{ $menu['label'] }}</a>
                                @if ($menu['child'])
                                    <div class="dropdown-menu">
                                        @foreach ($menu['child'] as $child)
                                            <a class="dropdown-item"
                                                href="{{ $child['link'] }}">{{ $child['label'] }}</a>
                                        @endforeach
                                    </div>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </nav>
    @endif

    @yield('content')

    <footer class="section-footer border-top">
        <div class="container">
            <?php $footer = Menu::getByName('Footer Menu'); ?>
            @if ($footer)
                <section class="footer-top  padding-top-sm padding-bottom-sm">
                    <div class="row">
                        <div class="col-12">
                            <p class="mb-0 text-center">
                                @foreach ($footer as $menu)
                                    <a href="{{ $menu['link'] }}">{{ $menu['label'] }}</a>
                                @endforeach
                            </p>
                        </div>
                    </div>
                </section>
            @endif
            <section class="footer-bottom border-top row">
                <div class="col-md-2">
                    <p class="text-muted"> <?php echo date('Y'); ?> &copy {{ Settings::get('site_name') }} </p>
                </div>
                <div class="col-md-8 text-md-center">
                    {!! Settings::get('footer_copyright_text') !!}
                </div>
                <div class="col-md-2 text-md-right text-muted">
                    <img src="/assets/images/ssl.png" width="512px" height="25px" align="right">
                </div>
            </section>
        </div>
    </footer>
    <script src="{{ asset('assets/js/lazyload.js') }}"></script>
    <script src="{{ asset('assets/js/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('assets/js/script.js') }}"></script>
    <script>
        $(document).ready(function() {
            updateNavCart();
        });

        function showFrontendAlert(type, message) {
            if (type === 'danger') {
                type = 'error';
            }
            swal({
                position: 'top-end',
                type: type,
                title: message,
                showConfirmButton: false,
                timer: 3000
            });
        }

        function updateNavCart() {
            $.ajax({
                type: "get",
                url: "{{ url('/miniCart') }}",
                contentType: "application/json",
                success: function(response) {
                    $('#cart_items').empty().prepend(response);
                }
            });
        }

        function removeFromCart(key) {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                type: "DELETE",
                url: "{{ url('/checkout') }}/" + key,
                data: {
                    '_token': '{{ csrf_token() }}'
                },
                contentType: "application/json",
                success: function(response) {

                    showFrontendAlert('success', 'Successfully Product Removed from Cart');
                    updateNavCart();
                    updateQuantity(key, 0);
                    if (response['reload'] === 'true') {
                        location.reload();
                    }

                }
            });
        }

        function updateQuantity(key, element) {
            $.get("{{ url('/updateQuantity') }}", {
                _token: '30aK3OPPMnzZeq8BKYZGsidbBTm5VsnwPGhJdtPl',
                key: key,
                quantity: element.value
            }, function(data) {
                updateNavCart();
                $('.orderDetails').html(data);
            });
        }

        function addToCart(id) {
            $.post("{{ url('/checkout') }}", {
                _token: '{{ csrf_token() }}',
                id: id
            }, function(data) {
                showFrontendAlert('success', 'Successfully Product add to cart');
                updateNavCart();
                window.location.href = '{{ url('/checkout') }}';
            });
        }

        function buyNow(id) {
            $.post("{{ url('/checkout') }}", {
                _token: '{{ csrf_token() }}',
                id: id
            }, function(data) {
                showFrontendAlert('success', 'Successfully Product add to cart');
                updateNavCart();
                window.location.href = '{{ url('/checkout') }}';
            });
        }


        function cartQuantityInitialize() {
            $('.btn-number').click(function(e) {
                e.preventDefault();

                fieldName = $(this).attr('data-field');
                type = $(this).attr('data-type');
                var input = $("input[name='" + fieldName + "']");
                var currentVal = parseInt(input.val());

                if (!isNaN(currentVal)) {
                    if (type == 'minus') {

                        if (currentVal > input.attr('min')) {
                            input.val(currentVal - 1).change();
                        }
                        if (parseInt(input.val()) == input.attr('min')) {
                            $(this).attr('disabled', true);
                        }

                    } else if (type == 'plus') {

                        if (currentVal < input.attr('max')) {
                            input.val(currentVal + 1).change();
                        }
                        if (parseInt(input.val()) == input.attr('max')) {
                            $(this).attr('disabled', true);
                        }

                    }
                } else {
                    input.val(0);
                }
            });

            $('.input-number').focusin(function() {
                $(this).data('oldValue', $(this).val());
            });

            $('.input-number').change(function() {

                minValue = parseInt($(this).attr('min'));
                maxValue = parseInt($(this).attr('max'));
                valueCurrent = parseInt($(this).val());

                name = $(this).attr('name');
                if (valueCurrent >= minValue) {
                    $(".btn-number[data-type='minus'][data-field='" + name + "']").removeAttr('disabled')
                } else {
                    alert('Sorry, the minimum value was reached');
                    $(this).val($(this).data('oldValue'));
                }
                if (valueCurrent <= maxValue) {
                    $(".btn-number[data-type='plus'][data-field='" + name + "']").removeAttr('disabled')
                } else {
                    alert('Sorry, the maximum value was reached');
                    $(this).val($(this).data('oldValue'));
                }


            });
            $(".input-number").keydown(function(e) {
                // Allow: backspace, delete, tab, escape, enter and .
                if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 190]) !== -1 ||
                    // Allow: Ctrl+A
                    (e.keyCode == 65 && e.ctrlKey === true) ||
                    // Allow: home, end, left, right
                    (e.keyCode >= 35 && e.keyCode <= 39)) {
                    // let it happen, don't do anything
                    return;
                }
                // Ensure that it is a number and stop the keypress
                if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                    e.preventDefault();
                }
            });
        }
    </script>
    @stack('js')
</body>

</html>
