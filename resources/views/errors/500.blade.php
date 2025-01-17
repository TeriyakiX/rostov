@extends('layouts.index')

@section('title', 'Ошибка {{ $status ?? 500 }}')

@section('content')
    <main class="page">
        <div class="error-page _container">
            <div class="error-info-wrapper">
                <div class="error-info">
                    <h1 class="error-title">Техническая ошибка</h1>
{{--                    <p class="error-subtitle">{{ $message ?? 'Что-то пошло не так' }}</p>--}}
                    <p class="error-text">Извините, на сервере произошла ошибка. Мы уже знаем об этой проблеме и работаем над её устранением. Пожалуйста, попробуйте позже.</p>
                    <a class="error-link btn" href="{{ url('/posts/katalog') }}">Перейти в каталог</a>
                </div>
            </div>
            <div class="error-status">
                <p>
                    @foreach(str_split((string)($status ?? 500)) as $char)
                        <span class="{{ $char === '0' ? 'digit-zero' : 'digit-other' }}">{{ $char }}</span>
                    @endforeach
                </p>
            </div>
        </div>
    </main>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Train+One&display=swap');
        .error-page {
            display: flex;
            justify-content: space-between;
            align-items: stretch;
            margin-bottom: 128px;
        }
        .error-info-wrapper {
            display: flex;
            align-items: center;
            background-image: url('img/error-status.png');
            background-repeat: no-repeat;
            background-position: calc(100% - 10%) 150%;
            background-size: 50%;
            width: 100%;
        }
        .error-info {
            display: flex;
            flex-direction: column;
        }
        .error-title {
            margin-bottom: 28px;
            font-size: 6.4rem;
            font-weight: 700;
            color: rgba(0, 0, 0, 1);
        }
        .error-subtitle {
            margin-bottom: 38px;
            font-size: 4rem;
            font-weight: 400;
            color: rgba(0, 0, 0, 0.8);
        }
        .error-text {
            margin-bottom: 85px;
            font-size: 1.8rem;
            font-weight: 400;
            color: rgba(89, 89, 89, 1);
            width: 40%;
            line-height: 20.14px;
        }
        .error-link {
            font-size: 2.4rem;
            font-weight: 600;
            width: fit-content;
        }
        .digit-zero {
            color: rgba(0, 107, 222, 1);
        }

        .digit-other {
            color: rgba(0, 0, 0, 1);
        }

        .error-status p {
            display: flex;
            flex-direction: column;
            font-family: "Train One", serif;
            font-weight: 400;
            font-size: 20rem;
            font-style: normal;
            user-select: none;
        }
        @media (max-width: 1220px) {
            .error-info-wrapper {
                background-position: calc(100% - 10%) 120%;
            }
        }
        @media (max-width: 991.98px){
            .error-page {
                flex-direction: column-reverse;
                padding-top: 94px;
            }
            .error-info-wrapper {
                background-image: none;
            }
            .error-status {
                margin-bottom: 24px;
            }
            .error-status p {
                flex-direction: row;
                font-size: 14rem;
            }
            .error-title {
                font-size: 4.8rem;
            }
            .error-text {
                width: 100%;
                margin-bottom: 24px;
            }
        }
    </style>
@endsection


{{--<!DOCTYPE html>--}}
{{--<html lang="en">--}}
{{--<head>--}}
{{--    <meta charset="UTF-8">--}}
{{--    <meta name="viewport" content="width=device-width, initial-scale=1.0">--}}
{{--    <title>Ошибка {{ $status ?? 500 }}</title>--}}
{{--    <style>--}}
{{--        body {--}}
{{--            font-family: Arial, sans-serif;--}}
{{--            text-align: center;--}}
{{--            padding: 50px;--}}
{{--            background-color: #f8f9fa;--}}
{{--        }--}}
{{--        h1 {--}}
{{--            color: #dc3545;--}}
{{--            font-size: 48px;--}}
{{--        }--}}
{{--        p {--}}
{{--            font-size: 18px;--}}
{{--            color: #6c757d;--}}
{{--        }--}}
{{--        a {--}}
{{--            text-decoration: none;--}}
{{--            color: #007bff;--}}
{{--            font-weight: bold;--}}
{{--        }--}}
{{--        a:hover {--}}
{{--            text-decoration: underline;--}}
{{--        }--}}
{{--    </style>--}}
{{--</head>--}}
{{--<body>--}}
{{--<h1>Ошибка {{ $status ?? 500 }}</h1>--}}
{{--<p>Что-то пошло не так. Мы работаем над решением проблемы.</p>--}}
{{--<p><a href="{{ url('/categoryList/krovlya') }}">Перейти в каталог товаров</a></p>--}}
{{--</body>--}}
{{--</html>--}}
