@extends('layouts.index')

@section('content')
    <main class="page">
        <nav class="breadcrumbs">
            <div class="breadcrumbs__container _container">
                <ul class="breadcrumbs__list">
                    <li class="breadcrumbs__item"><a class="breadcrumbs__link" href="/"><span>Главная</span>
                            <svg>
                                <use xlink:href="{{ asset('img/sprites/sprite-mono.svg#slideArrow') }}"></use>
                            </svg>
                        </a></li>
                    <li class="breadcrumbs__item"><a class="breadcrumbs__link breadcrumbs__link--active" href="#"><span>Товары</span>
                            <svg>
                                <use xlink:href="{{ asset('img/icons/blue-play.svg#blue-play') }}"></use>
                            </svg></a>
                    </li>
                </ul>
            </div>
        </nav>
        <section class="brands">
            <div class="brands__container _container">
                <div class="brands__content">
                    <div class="brands__head">
                        <h2 class="brands__title t">@if(is_object($products)){{\App\Models\Brand::where('id', $products[0]['brand_id'])->get()[0]['title']}} @else {{$products}} @endif</h2>
                        <div class="brands__controls newItems__tabs"><a class="brands__tabsEl newItems__tabsEl" href="/posts/katalog" role="button" tabindex="0">Категории товаров</a><a
                                class="brands__tabsEl brands__tabsEl--active newItems__tabsEl" href="#" role="button"
                                tabindex="0">Бренды</a></div>
                    </div>
                    <div class="brands__body">
                        <div class="productsTmp__body" id="data-wrapper">
                            @if(is_object($products))
                                @forelse($products as $product)
                                    @include('products._category_item', ['category' => $product->categories[0]])
                                @empty
                                    <div>Empty</div>
                                @endforelse
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <style>
        .brands__container {
            margin-bottom: 80px;
        }
        .brands__body {
            margin: 0;
        }
        @media (max-width: 767.98px) {
            .brands__container {
                margin-bottom: 40px;
            }
            .brands__title {
                margin-bottom: 32px;
            }
        }
        @media (max-width: 991.98px) {
            .newItems__tabs:before {
                left: -18px;
            }
        }
    </style>
@endsection
