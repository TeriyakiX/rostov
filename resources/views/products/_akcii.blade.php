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
                            <span>Акции</span>
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
                        Акции
                    </h1>
{{--                    <div class="cooperation__body sideDashContainer">--}}
                    <div class="sideDash sideDash--sticky" style="z-index: 1111">
                            <div class="sideDash__item sideDash__item--gap">
                                <svg class="sideDash__icon">
                                    <use xlink:href="{{ url('/img/sprites/3.png') }}#building">
                                        <img src="{{asset('img/sprites/3.png')}}" alt="">
                                    </use>
                                </svg>
                                <div class="sideDash__mark"><a
                                        href="{{route('index.posts.show',['slug'=>'vidy-pokrytiya'])}}">Виды
                                        покрытий</a></div>
                            </div>
                            <div class="sideDash__item sideDash__item--gap">
                                <svg class="sideDash__icon">
                                    <use xlink:href="{{ url('/img/sprites/4.png') }}#building">
                                        <img src="{{asset('img/sprites/4.png')}}" alt="">
                                    </use>
                                </svg>
                                <div class="sideDash__mark"><a
                                        href="{{route('index.posts.show',['slug'=>'gotovye-resheniya']) }}">Готовые
                                        решения</a></div>
                            </div>
                            <div class="sideDash__item sideDash__item--gap">
                                <svg class="sideDash__icon">
                                    <use xlink:href="{{ url('/img/sprites/2.png') }}#building">
                                        <img src="{{asset('img/sprites/2.png')}}" alt="">
                                    </use>
                                </svg>
                                <div class="sideDash__mark"><a href="/posts/oplata">on-line оплата</a></div>
                            </div>
                            <div class="sideDash__item sideDash__item--gap">
                                <svg class="sideDash__icon">
                                    <use xlink:href="{{ url('/img/sprites/1.png') }}#building">
                                        <img src="{{asset('img/sprites/1.png')}}" alt="">
                                    </use>
                                </svg>
                                <div class="sideDash__mark"><a href="/posts/zakazat-raschet">Заказать расчет</a></div>
                            </div>
                        </div>
                   @include('products.sections.slider')
                    @php
                        $promoProducts = \App\Models\Product::getActivePromoProducts();
                    @endphp
                    @if($promoProducts->count() > 0)
{{--                        <div class="newItems__controlPanel">--}}
{{--                            <div class="newItems__tabs">--}}
{{--                                <div class="newItems__tabsEl all_categories newItems__tabsEl--active" role="button" tabindex="0"--}}
{{--                                     data-tab="all" data-active><div class="newItems__tabsEl--first">Все</div>--}}
{{--                                </div>--}}
{{--                                <div class="newItems__tabsEl sort_button" role="button" type="submit" tabindex="0"--}}
{{--                                     data-tab="roof">--}}
{{--                                    Кровля--}}
{{--                                </div>--}}
{{--                                <div class="newItems__tabsEl sort_button" role="button" tabindex="0" data-tab="facade">--}}
{{--                                    Фасад--}}
{{--                                </div>--}}
{{--                                <div class="newItems__tabsEl sort_button" role="button" tabindex="0" data-tab="poly">--}}
{{--                                    Поликарбонат--}}
{{--                                </div>--}}
{{--                                <div class="newItems__tabsEl sort_button" role="button" tabindex="0" data-tab="terrace">--}}
{{--                                    Террасная доска--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}

                        <div class="productsTmp__body" id="data-wrapper">
                            @foreach($promoProducts as $product)
                                @include('products._product_item')
                            @endforeach
                        </div>
                    @else
                        <div class="empty__block">
                            <div class="empty__block-info">
                                <h1 class="empty__title">
                                    Акции отсутствуют
                                </h1>
                                <p class="empty__text">Здесь будут отображаться товары по акции</p>
                            </div>
                            <img src="/img/emptyProducts/package.png" alt="empty-products">
                        </div>
                    @endif
                </div>
            </div>
        </section>
    </main>
    <style>
        .empty__block {
            padding-top: 40px;
            justify-content: space-between;
        }
        .productsTmp__body {
            margin: 0 -8px;
        }
        .heroSliderPreview__previewBox:before {
            background-color: rgba(37, 161, 65, 0.7);
        }
        .hero__container {
            min-height: 517px;
        }
        .heroSlider__txt {
            padding-right: 340px !important;
        }
        .heroSlider__txtBox:after {
            background-color: rgba(37, 161, 65, 0.7);
        }
        .stockSlider__count,
        .stockSlider__count--mobile{
           color: rgba(37, 161, 65, 0.3);
        }
        .title {

            font-style: normal;
            font-weight: 700;
            font-size: 24px;
            line-height: 140.62%;
            /* or 34px */

            display: flex;
            align-items: center;

            color: #595959;
        }

        .text {
            font-style: normal;
            font-weight: 400;
            font-size: 16px;
            line-height: 26px;
            /* or 162% */

            display: flex;
            align-items: center;

            /* 3 */

            color: #505050;
        }
        .wrp-heroSlider {
            right: auto;
        }
        .wrp-heroSlider, .wrp-heroSliderPreview {
            right: 420px;
        }
        @media (max-width: 1220px) {
            .heroSlider__txtBox {
                 padding: 20px 70px 30px 30px;
                 margin-left: 25px;
            }
            .heroSlider__content {
                padding-left: 199px;
            }
            .heroSlider__txt {
                padding-right: 100px !important;
            }
            .wrp-heroSlider, .wrp-heroSliderPreview {
                right: 200px;
            }
        }

        @media (max-width: 991.98px) {
            .productsTmp .newItems__tabs {
                flex-wrap: wrap;
            }
            .newItems__tabsEl:not(:first-child) {
                margin-left: 30px !important;
            }
            .productsTmp .newItems__tabsEl:not(:last-child) {
                margin-right: 0 !important;
            }
            .swiper {
                z-index: -1;
            }
            .heroSliderPreview__count {
                font-size: 9.6rem;
            }
            .wrp-heroSlider--mobile .wrp-heroSlider {
                margin-right: 0 !important;
            }
            .wrp-heroSlider--mobile .heroSliderPreview {
                margin-left: 0 !important;
            }
            .wrp-heroSlider--mobile {
                display: flex;
            }
            .heroSlider__content--desktop {
                display: none;
            }
            .wrp-heroSlider--mobile .heroSlider__content {
                padding-left: 0;
                margin-left: 0;
            }
            .wrp-heroSlider--mobile .heroSlider__txtBox {
                padding-right: 0 !important;
            }
            .wrp-heroSlider--mobile .heroSlider__txt {
                padding-right: 0 !important;
                padding-left: 0 !important;
            }
            .wrp-heroSlider--mobile .heroSlider__count {
                top: 0;
            }
            .wrp-heroSlider--mobile {
                margin-bottom: 32px;
            }
            .heroSlider__txtBox {
                margin-left: 0;
            }
            .hero__container {
                min-height: 377px;
            }

        }

        @media (max-width: 767.98px) {
            .swiper {
                margin-left: -16px;
                overflow: inherit;
            }
            .productsTmp__body {
                margin: 0 -4px;
            }
            .heroSlider__txtBox {
                max-width: 60% !important;
            }
            .heroSliderPreview__count {
                font-size: 5.6rem;
                left: 10%;
            }
            .wrp-heroSlider--mobile {
                width: 100% !important;
            }
            .heroSlider__txtBox {
                padding-left: 19px;
            }
            .heroSlider__promo {
                width: 70%;
            }
            .wrp-heroSlider, .wrp-heroSliderPreview {
                right: 150px;
            }
        }

        @media (max-width: 600px) {
            .heroSlider__txtBox {
                max-width: 40% !important;
            }
            .heroSliderPreview {
                margin-left: -100px;
            }
            .wrp-heroSlider {
                margin-right: 0px;
            }
        }
        @media (max-width: 479.98px) {
            .swiper-container-initialized .swiper-slide {
                flex-shrink: 0;
            }
            .heroSlider__promo {
                width: 80%;
            }
            .heroSlider__title {
                font-size: 30px;
            }
            .heroSlider__txtBox {
                max-width: 35% !important;
            }
            .wrp-heroSlider, .wrp-heroSliderPreview {
                right: 100px;
            }
        }
    </style>
@endsection

