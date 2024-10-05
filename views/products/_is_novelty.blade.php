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
                            <span>Новинки</span>
                        </a>
                    </li>
                </ul>
            </div>
        </nav>
        <section class="productsTmp">
            <div class="productsTmp__container _container">
                <div class="productsTmp__content">
                    <h1 class="productsTmp__title t">
                        Новинки
                    </h1>
                    @if(count(\App\Models\Product::where('is_novelty', '>', 0)->get()) > 0)
                        <div class="productsTmp__body" id="data-wrapper">
                            @foreach(\App\Models\Product::where('is_novelty', '>', 0)->get() as $product)
                                @include('products._product_item')
                            @endforeach
                        </div>
                    @else
                        <h1 class="productsTmp__title t">
                            Пусто
                        </h1>
                    @endif
                </div>
            </div>
        </section>
    </main>
@endsection
