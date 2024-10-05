@extends('layouts.index')

@section('seo_title', $category->seo_title)
@section('seo_description', $category->seo_description)
@section('seo_keywords', $category->seo_keywords)

@section('content')
    <main class="page" style="padding-bottom:77px">
        <nav class="breadcrumbs breadcrumbs--light">
            <div class="breadcrumbs__container _container">
                <ul class="breadcrumbs__list">
                    <li class="breadcrumbs__item">
                        <a class="breadcrumbs__link" href="{{ url('/') }}"><span>Главная</span>
                            <svg>
                                <use xlink:href="/img/sprites/sprite-mono.svg#slideArrow"></use>
                            </svg>
                        </a>
                    </li>
                    <li class="breadcrumbs__item">
                        <a class="breadcrumbs__link breadcrumbs__link--active">
                            <span>{{ $category->title }}</span>
                        </a>
                    </li>
                </ul>
            </div>
        </nav>
        <section class="brands">
            <div class="brands__container _container">
                <div class="brands__content">
                    <div class="brands__head">
                        <h2 class="brands__title t">{{ $category->title }}</h2>
{{--                        <div class="brands__controls newItems__tabs">--}}
{{--                            <a class="brands__tabsEl newItems__tabsEl" role="button" tabindex="0" href="#">Категории товаров</a>--}}
{{--                            <a class="brands__tabsEl brands__tabsEl--active newItems__tabsEl" role="button" tabindex="0" href="#">Бренды</a>--}}
{{--                        </div>--}}
                    </div>

                    <div class="brands__body">
                        @foreach($category->subcategories as $subcategory)
                            <div class="brands__cardWrp">
                                <div class="brands__card">
                                    <div class="brands__imgBox ibg">
                                        <a class="brands__imgLink" href="{{ route('index.products.category', ['category' => $subcategory->slug]) }}">
                                            <picture>
                                                <source type="image/webp" srcset="/img/brands//bb1.webp">
                                                <img src="/img/brands//bb1.jpg" alt="bb1">
                                            </picture>
                                        </a>
                                    </div>
                                    <div class="brands__cardBody spollers">
                                        <a class="brands__cardTitle link"
                                           href="{{ route('index.products.category', ['category' => $subcategory->slug]) }}">
                                            {{ $subcategory->title }}
                                        </a>
                                        <div class="brands__cardCategories ac">
                                            @php $subcategories = $subcategory->subcategories; @endphp
                                            @foreach($subcategories as $index=>$subSubcategory)
                                                @if($index < 5)
                                                    <a class="brands__cardCategory"
                                                       href="{{ route('index.products.category', ['category' => $subSubcategory->slug]) }}">
                                                        {{ $subSubcategory->title }}
                                                    </a>
                                                @endif
                                            @endforeach
                                            @if(count($subcategories) >= 5)
                                                <div class="ac-panel">
                                                    @foreach($subcategories as $index=>$subSubcategory)
                                                        @if($index >= 5)
                                                            <a class="brands__cardCategory"
                                                               href="{{ route('index.products.category', ['category' => $subSubcategory->slug]) }}">
                                                                {{ $subSubcategory->title }}
                                                            </a>
                                                        @endif
                                                    @endforeach
                                                </div>
                                                <div class="brands__cardMore ac-trigger off" data-more-open="Показать еще" data-more-close="Скрыть ">
                                                    {{ count($subcategories) - 5 }} {{ show_categories_count_rus(count($subcategories) - 5) }}
                                                    <svg class="brands__cardArrow">
                                                        <use xlink:href="/img/sprites/sprite-mono.svg#sel3"></use>
                                                    </svg>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>

        {{-- SLIDERS --}}

        <section class="newItems analogs">
            <div class="newItems__container _container">
                <div class="newItems__content">
                    <div class="newItems__body">
                        <div class="newItems__controlPanel">
                            <h2 class="newItems__title t">Новинки ассортимента</h2>
                            <div class="newItems__sliderBtns">
                                <div class="newItems__sliderBtn newItems__sliderBtn--prev" role="button" tabindex="0">
                                    <svg>
                                        <use xlink:href="{{ asset('img/sprites/sprite-mono.svg#slideArrow') }}"></use>
                                    </svg>
                                </div>
                                <div class="newItems__sliderBtn newItems__sliderBtn--next" role="button" tabindex="0">
                                    <svg>
                                        <use xlink:href="{{ asset('img/sprites/sprite-mono.svg#slideArrow') }}"></use>
                                    </svg>
                                </div>
                            </div>
                        </div>
                        <div class="wrp-itemsSlider">
                            <div class="swiper-container itemsSlider _swiper">
                                <div class="swiper-wrapper itemsSlider__wrapper">
                                    @foreach($sliderProducts as $sliderProduct)
                                        @include('products._block_item')
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="newItems analogs">
            <div class="newItems__container _container">
                <div class="newItems__content">
                    <div class="newItems__body">
                        <div class="newItems__controlPanel">
                            <h2 class="newItems__title t">Скидки и акции</h2>
                            <div class="newItems__sliderBtns">
                                <div class="newItems__sliderBtn newItems__sliderBtn--prev" role="button" tabindex="0">
                                    <svg>
                                        <use xlink:href="{{ asset('img/sprites/sprite-mono.svg#slideArrow') }}"></use>
                                    </svg>
                                </div>
                                <div class="newItems__sliderBtn newItems__sliderBtn--next" role="button" tabindex="0">
                                    <svg>
                                        <use xlink:href="{{ asset('img/sprites/sprite-mono.svg#slideArrow') }}"></use>
                                    </svg>
                                </div>
                            </div>
                        </div>
                        <div class="wrp-itemsSlider">
                            <div class="swiper-container itemsSlider _swiper">
                                <div class="swiper-wrapper itemsSlider__wrapper">
                                    @foreach($sliderProducts as $sliderProduct)
                                        @include('products._block_item')
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        @if($category->seo_text)
            <div class="_container">
                {!! $category->seo_text !!}
            </div>
        @endif
    </main>
@endsection
