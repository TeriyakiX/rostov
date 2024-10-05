<!DOCTYPE html>
<html lang="ru">
<head>
    <title>@yield('seo_title', 'МК Ростов')</title>
    <meta charset="UTF-8">
    <meta name="format-detection" content="telephone=no">
    <link rel="stylesheet" href="{{ asset('css/style.min.css') }}?v=5">
    <link rel="stylesheet" href="{{ asset('css/modal.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/custom.css?v=1') }}" />
    <link rel="stylesheet" href="{{ asset('css/sweetalert.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/owl.theme.default.min.css') }}">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">
    <meta name="description" content="@yield('seo_description', 'МК Ростов')">
    <meta name="keywords" content="@yield('seo_keywords', 'МК Ростов')">
    <!-- <meta name="robots" content="noindex, nofollow">-->
    <!-- <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf_token" content="{{ csrf_token() }}">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>
<body class="wrap">
<div class="wrapper">
    @include('layouts._header')
    <main class="page">
        @yield('content')
    </main>
    @include('layouts._footer')
</div>
<script
    src="https://code.jquery.com/jquery-3.6.0.min.js"
    integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
    crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.js"></script>
<script src="https://unpkg.com/@popperjs/core@2"></script>
<script src="https://unpkg.com/tippy.js@6"></script>
<script src="{{ asset('js/sweetalert.min.js') }}"></script>
<script src="{{ asset('js/vendors.min.js') }}"> </script>
<script src="{{ asset('js/main.min.js') }}"></script>
<script src="{{ asset('js/custom.js?v=7') }}"></script>
<script src="{{asset('jquery.min.js')}}"></script>
<script src="{{asset('js/owl.carousel.min.js')}}"></script>
{{--<script src="https://3dsec.sberbank.ru/payment/docsite/assets/js/ipay.js"></script>--}}
{{--<script>--}}
{{--    var ipay = new IPAY({api_token: 'YRF3C5RFICWISEWFR6GJ'});--}}
{{--</script>--}}
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
</script>
<script src="https://unpkg.com/imask"></script>
</body>
</html>
