@extends('layouts.index')

@section('content')
    <main class="page">
        <nav class="breadcrumbs">
            <div class="breadcrumbs__container _container">
                <ul class="breadcrumbs__list">
                    <li class="breadcrumbs__item">
                        <a class="breadcrumbs__link" href="{{ route('index.home') }}">
                            <span>Главная</span>
                            <svg>
                                <use xlink:href="{{ asset('img/sprites/sprite-mono.svg#slideArrow') }}"></use>
                            </svg>
                        </a>
                    </li>
                    <li class="breadcrumbs__item">
                        <a class="breadcrumbs__link breadcrumbs__link--active" href="#">
                            <span>{{ $title }}</span>
                            <svg>
                                <use xlink:href="{{ asset('img/icons/blue-play.svg#blue-play') }}"></use>
                            </svg>
                        </a>
                    </li>
                </ul>
            </div>
        </nav>
        <section class="productsTmp">
            <div class="productsTmp__container _container">
                <div class="productsTmp__content">
                    <h1 class="productsTmp__title t">
                        {{ $title }}
                    </h1>
                    <div class="cooperation__body sideDashContainer">

                    @if(count($products) > 0)
                        <div class="productsTmp__body" id="data-wrapper">
                            @foreach($products as $product)
                                @include('products._product_item')
                            @endforeach
                        </div>
                        @else
                            <div class="comparison__infoCompare">
                                <div class="comparison__categoryName" style="margin-top: 32px;">
                                    Список пуст
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
