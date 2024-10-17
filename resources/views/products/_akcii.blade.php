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
                                <use xlink:href="{{ asset('img/sprites/sprite-mono.svg#slideArrow') }}"></use>
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
                        <div class="sideDash sideDash--sticky" style="z-index: 9999">
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

                @if(count(\App\Models\Product::where('is_promo', '>', 0)->get()) > 0)
                        <div class="productsTmp__body" id="data-wrapper">
                            @foreach(\App\Models\Product::where('is_promo', '>', 0)->get() as $product)
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
    <style>
        .wrp-heroSlider, .wrp-heroSliderPreview {
            right: 325px;
        }
        .productsTmp__body {
            margin: 0 -8px;
            margin-top: 32px;
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
        .heroSlider__count {
           color: rgba(37, 161, 65, 0.3);
        }
        .productsTmp__title {
            margin-bottom: 32px;
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

        .heroSliderPreview__previewBox {
            cursor: pointer;
            position: relative !important;
            height: 100%;
            overflow: hidden !important;
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

        }

        @media (max-width: 767.98px) {
            .productsTmp__body {
                margin: 0 -4px;
            }
            .heroSlider__txtBox {
                max-width: 50% !important;
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
            .hero__container {
                min-height: 377px;
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

