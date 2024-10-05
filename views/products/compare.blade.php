@extends('layouts.index')

@section('content')
    <main class="page">
        <nav class="breadcrumbs">
            <div class="breadcrumbs__container _container">
                <ul class="breadcrumbs__list">
                    <li class="breadcrumbs__item"><a class="breadcrumbs__link" href="/"><span>Главная</span>
                            <svg>
                                <use xlink:href="/img/sprites/sprite-mono.svg#slideArrow"></use>
                            </svg>
                        </a></li>
                    <li class="breadcrumbs__item"><a class="breadcrumbs__link breadcrumbs__link--active" href="#"><span>Сравнение товаров</span></a>
                    </li>
                </ul>
            </div>
        </nav>
        <section class="comparison">
            <div class="comparison__container _container">
                <div class="comparison__content">
                    <h2 class="comparison__title t">Сравнение товаров</h2>
                    @if(count($categories) > 0 || count($compareCoatings) > 0)
                        <div class="comparison__tabsWrp">
                            <div class="comparison__tabs">
                                @foreach($categories as $index => $category)
                                    <div class="comparison__tab link" role="button" data-tab="{{ $category->title }}"
                                         @if($index == 0) data-active @endif >
                                        {{ $category->title }}
                                        <span class="comparison__tabCount">({{ $category->products_count }})</span>
                                    </div>
                                @endforeach
                                @if(count($compareCoatings) > 0)
                                    <div class="comparison__tab link" role="button" data-tab="Виды покрытия">
                                        Виды покрытия
                                        <span class="comparison__tabCount">({{count($compareCoatings)}})</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="comparison__tabBlocks">
                            @foreach($categories as $index => $category)
                                <div class="comparison__tabBlock" data-tabblock="{{ $category->title }}"
                                     @if($index == 0) data-active @endif>
                                    <div class="comparison__cards">
                                        <div class="comparisonGrid">
                                            <div class="comparisonGrid__col comparisonGrid__col--left">
                                                <div class="comparison__infoCompare">
                                                    <div class="comparison__categoryName">{{ $category->title }}</div>
                                                    <a href="{{ route('index.products.compareFlush') }}">
                                                        <div class="comparison__delAll btn" role="button" tabindex="0">
                                                            Удалить все
                                                        </div>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="comparisonGrid__col comparisonGrid__col--right">
                                                <div class="compareSlider__btn" role="button">
                                                    <svg>
                                                        <use xlink:href="/img/sprites/sprite-mono.svg#slideArrow"></use>
                                                    </svg>
                                                </div>
                                                <div class="wrp-compareSlider">
                                                    <div class="swiper-container compareSlider _swiper">
                                                        <div class="swiper-wrapper compareSlider__wrapper">
                                                            @foreach($category->products as $product)
                                                                <div class="swiper-slide undefined itemsSlider__slide"
                                                                     data-product="{{ $product->id }}">
                                                                    <div class="card comparison__card"
                                                                         data-product="{{ $product->id }}">
                                                                        <div class="card__imgWrp">
                                                                            <a class="card__imgBox ibg"
                                                                               href="{{ $product->showLink() }}">
                                                                                <picture>
                                                                                    <source type="image/webp"
                                                                                            srcset="{{ $product->mainPhotoPath() }}">
                                                                                    <img
                                                                                        src="{{ $product->mainPhotoPath() }}"
                                                                                        alt="p4">
                                                                                </picture>
                                                                            </a>
                                                                            <div class="card__delete addTo removeCard"
                                                                                 data-destination="Compare"
                                                                                 role="button">
                                                                                <svg>
                                                                                    <use
                                                                                        xlink:href="/img/sprites/sprite-mono.svg#cancel"></use>
                                                                                </svg>
                                                                            </div>
                                                                        </div>
                                                                        <div class="card__title">
                                                                            <a class="link"
                                                                               href="{{ $product->showLink() }}">
                                                                                {{ $product->title }}
                                                                            </a>
                                                                        </div>
                                                                        <ul class="card__chars">
                                                                            @foreach($product->attributesArray() as $productAttribute)
                                                                                @if(count($productAttribute['options']) == 1)
                                                                                    <li class="card__char">
                                                                                        {{ $productAttribute['model']['title'] }}
                                                                                        :
                                                                                        @if(count($productAttribute['options']) !== 0 )
                                                                                        @endif
                                                                                    </li>
                                                                                @endif
                                                                            @endforeach
                                                                        </ul>
                                                                        <div class="card__price">
                                                                            @if($product->is_promo)
                                                                                <div
                                                                                    style="text-decoration: line-through;">{{ $product->price }}
                                                                                    ₽@if($product->show_calculator)
                                                                                        /м²
                                                                                    @endif </div>
                                                                                <div>{{ $product->promo_price }}
                                                                                    ₽@if($product->show_calculator)
                                                                                        /м²
                                                                                    @endif</div>
                                                                            @else
                                                                                {{ $product->price }}
                                                                                ₽@if($product->show_calculator)
                                                                                    /м²
                                                                                @endif
                                                                            @endif
                                                                        </div>
                                                                        <div class="card__controllers">
                                                                            <a href="{{ $product->showLink() }}">
                                                                                <div class="card__btn btn" role="button"
                                                                                     tabindex="0">Подробнее
                                                                                </div>
                                                                            </a>
                                                                            <div class="card__icons">
                                                                                <div
                                                                                    class="card__icon card__icon--like addTo {{ product_id_in_list($product->id, 'favorites') ? 'active' : '' }}"
                                                                                    data-destination="Favorites"
                                                                                    role="button" tabindex="0">
                                                                                    <svg>
                                                                                        <use
                                                                                            xlink:href="/img/sprites/sprite-mono.svg#heart"></use>
                                                                                    </svg>
                                                                                </div>
                                                                                <div
                                                                                    class="card__icon card__icon--stat addTo removeCard {{ product_id_in_list($product->id, 'compare') ? 'active' : '' }}"
                                                                                    data-destination="Compare"
                                                                                    role="button" tabindex="0">
                                                                                    <svg>
                                                                                        <use
                                                                                            xlink:href="/img/sprites/sprite-mono.svg#stat"></use>
                                                                                    </svg>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="comparison__parameters">
                                        <div class="comparison__settings">
                                            <div class="checkbox">
                                                <input class="checkbox__input" id="chkbox" autocomplete="off"
                                                       type="checkbox" name="form[]">
                                                <label class="checkbox__label link" for="chkbox">Показывать только
                                                    различия</label>
                                            </div>
                                        </div>
                                        <div class="comparisonGrid">
                                            <div class="comparisonGrid__col comparisonGrid__col--left">
                                                {{--                                                @foreach($product->attributesArray() as $attribute)--}}
                                                {{--                                                @endforeach--}}
                                                {{--                                                    @foreach($product->attributesArray() as $attribute)--}}
                                                {{--                                                    @endforeach--}}
                                                @foreach($category->attributes as $attribute)
                                                    <div
                                                            class="comparison__parameterRow comparison__parameterRow--name bold">
                                                        {{$attribute}}
                                                    </div>
                                                @endforeach

                                                <div
                                                    class="comparison__parameterRow comparison__parameterRow--name bold">
                                                    Цена
                                                </div>

                                                <div
                                                    class="comparison__parameterRow comparison__parameterRow--name bold">
                                                    Категория
                                                </div>
                                                <div
                                                    class="comparison__parameterRow comparison__parameterRow--name bold">
                                                    Ширина полная
                                                </div>
                                                <div
                                                    class="comparison__parameterRow comparison__parameterRow--name bold">
                                                    Ширина полезная
                                                </div>
                                                <div
                                                    class="comparison__parameterRow comparison__parameterRow--name bold">
                                                    Длина на заказ
                                                </div>
                                            </div>

                                            <div class="comparisonGrid__col comparisonGrid__col--right">
                                                <div class="wrp-compareParametersSlider">
                                                    <div class="swiper-container compareParametersSlider _swiper">
                                                        <div class="swiper-wrapper compareParametersSlider__wrapper">
                                                            @foreach($category->products as $product)
                                                                <div
                                                                    class="swiper-slide undefined compareParametersSlider__slide">
                                                                    @foreach($product->attributesArray() as $attribute)
                                                                        <div class="comparison__parameterRow">
                                                                            @foreach($attribute['options'] as $option)
                                                                                @if( $option !== null)
                                                                                    {{$option['title']}}
                                                                                @else()
                                                                                    <p></p>
                                                                                @endif
                                                                            @endforeach
                                                                            <span class="comparison__parameterName">
                                                                                {{ $attribute['model']->title }}
                                                                            </span>
                                                                        </div>
                                                                    @endforeach
                                                                    @if($product->price !== null)
                                                                        <div class="comparison__parameterRow">
                                                                            {{ $product->price}}
                                                                        </div>
                                                                    @else
                                                                        <p></p>
                                                                    @endif
                                                                    @if($category->title !== null)
                                                                        <div class="comparison__parameterRow">

                                                                            {{$category->title}}
                                                                        </div>
                                                                    @else
                                                                        <p></p>
                                                                    @endif
                                                                    <div class="comparison__parameterRow">
                                                                        {{$product->list_width_full}}
                                                                    </div>
                                                                    <div class="comparison__parameterRow">
                                                                        {{$product->list_width_useful}}
                                                                    </div>
                                                                    <div class="comparison__parameterRow">
                                                                        {{$product->custom_length_to}}
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="comparison__back">
                                        <a class="comparison__backBtn btn"
                                           href="/posts/katalog">
                                            Назад к товарам
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                            @if(count($compareCoatings) > 0)
                                <div class="comparison__tabBlock" data-tabblock="Виды покрытия"
                                     @if(count($categories) < 1) data-active @endif>
                                    <div class="comparison__cards">
                                        <div class="comparisonGrid">
                                            <div class="comparisonGrid__col comparisonGrid__col--left">
                                                <div class="comparison__infoCompare">
                                                    <div class="comparison__categoryName">Виды покрытия</div>
                                                    {{--                                                        <a href="{{ route('index.products.compareFlush') }}">--}}
                                                    {{--                                                            <div class="comparison__delAll btn" role="button" tabindex="0">--}}
                                                    {{--                                                                Удалить все--}}
                                                    {{--                                                            </div>--}}
                                                    {{--                                                        </a>--}}
                                                </div>
                                            </div>
                                            <div class="comparisonGrid__col comparisonGrid__col--right">
                                                <div class="compareSlider__btn" role="button">
                                                    <svg>
                                                        <use xlink:href="/img/sprites/sprite-mono.svg#slideArrow"></use>
                                                    </svg>
                                                </div>
                                                <div class="wrp-compareSlider">
                                                    <div class="swiper-container compareSlider _swiper">
                                                        <div class="swiper-wrapper compareSlider__wrapper">
                                                            @foreach($compareCoatings as $product)
                                                                <div class="swiper-slide undefined itemsSlider__slide"
                                                                     data-product="{{ $product->id }}">
                                                                    <div class="card comparison__card"
                                                                         data-product="{{ $product->id }}">
                                                                        <div class="card__imgWrp">
                                                                            <a class="card__imgBox ibg"
                                                                               href="{{ '/coatings/'.$product->slug }}">
                                                                                <picture>
                                                                                    <source type="image/webp"
                                                                                            srcset="{{ $product->mainPhotoPath() }}">
                                                                                    <img
                                                                                        src="{{ $product->mainPhotoPath() }}"
                                                                                        alt="p4">
                                                                                </picture>
                                                                            </a>
                                                                            <div
                                                                                class="card__delete removeCoatingCompare"
                                                                                data-destination="Compare"
                                                                                role="button" id="{{ $product->id }}">
                                                                                <svg>
                                                                                    <use
                                                                                        xlink:href="/img/sprites/sprite-mono.svg#cancel"></use>
                                                                                </svg>
                                                                            </div>
                                                                        </div>
                                                                        <div class="card__title">
                                                                            <a class="link"
                                                                               href="{{ '/coatings/'.$product->slug }}">
                                                                                {{ $product->title }}
                                                                            </a>
                                                                        </div>
                                                                        {{--                                                                        <div class="card__price">--}}
                                                                        {{--                                                                            @if($product->is_promo)--}}
                                                                        {{--                                                                                <div--}}
                                                                        {{--                                                                                    style="text-decoration: line-through;">{{ $product->price }}--}}
                                                                        {{--                                                                                    ₽@if($product->show_calculator)--}}
                                                                        {{--                                                                                        /м²--}}
                                                                        {{--                                                                                    @endif </div>--}}
                                                                        {{--                                                                                <div>{{ $product->promo_price }}--}}
                                                                        {{--                                                                                    ₽@if($product->show_calculator)--}}
                                                                        {{--                                                                                        /м²--}}
                                                                        {{--                                                                                    @endif</div>--}}
                                                                        {{--                                                                            @else--}}
                                                                        {{--                                                                                {{ $product->price }}--}}
                                                                        {{--                                                                                ₽@if($product->show_calculator)--}}
                                                                        {{--                                                                                    /м²--}}
                                                                        {{--                                                                                @endif--}}
                                                                        {{--                                                                            @endif--}}
                                                                        {{--                                                                        </div>--}}
                                                                        <div class="card__controllers">
                                                                            <a href="{{ '/coatings/'.$product->slug }}">
                                                                                <div class="card__btn btn" role="button"
                                                                                     tabindex="0">Подробнее
                                                                                </div>
                                                                            </a>
                                                                            {{--                                                                            <div class="card__icons">--}}
                                                                            {{--                                                                                <div--}}
                                                                            {{--                                                                                    class="card__icon card__icon--like addTo {{ product_id_in_list($product->id, 'favorites') ? 'active' : '' }}"--}}
                                                                            {{--                                                                                    data-destination="Favorites"--}}
                                                                            {{--                                                                                    role="button" tabindex="0">--}}
                                                                            {{--                                                                                    <svg>--}}
                                                                            {{--                                                                                        <use--}}
                                                                            {{--                                                                                            xlink:href="/img/sprites/sprite-mono.svg#heart"></use>--}}
                                                                            {{--                                                                                    </svg>--}}
                                                                            {{--                                                                                </div>--}}
                                                                            {{--                                                                                <div--}}
                                                                            {{--                                                                                    class="card__icon card__icon--stat addTo removeCard {{ product_id_in_list($product->id, 'compare') ? 'active' : '' }}"--}}
                                                                            {{--                                                                                    data-destination="Compare"--}}
                                                                            {{--                                                                                    role="button" tabindex="0">--}}
                                                                            {{--                                                                                    <svg>--}}
                                                                            {{--                                                                                        <use--}}
                                                                            {{--                                                                                            xlink:href="/img/sprites/sprite-mono.svg#stat"></use>--}}
                                                                            {{--                                                                                    </svg>--}}
                                                                            {{--                                                                                </div>--}}
                                                                            {{--                                                                            </div>--}}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="comparison__parameters">
                                        {{--                                        <div class="comparison__settings">--}}
                                        {{--                                            <div class="checkbox">--}}
                                        {{--                                                <input class="checkbox__input" id="chkbox" autocomplete="off"--}}
                                        {{--                                                       type="checkbox" name="form[]">--}}
                                        {{--                                                <label class="checkbox__label link" for="chkbox">Показывать только--}}
                                        {{--                                                    различия</label>--}}
                                        {{--                                            </div>--}}
                                        {{--                                        </div>--}}
                                        <div class="comparisonGrid">
                                            <div class="comparisonGrid__col comparisonGrid__col--left">
                                                {{--                                                @foreach($product->attributesArray() as $attribute)--}}
                                                {{--                                                @endforeach--}}
                                                {{--                                                    @foreach($product->attributesArray() as $attribute)--}}
                                                {{--                                                    @endforeach--}}
                                                <div
                                                    class="comparison__parameterRow comparison__parameterRow--name bold">
                                                    Защитный слой Zn
                                                </div>
                                                <div
                                                    class="comparison__parameterRow comparison__parameterRow--name bold">
                                                    Толщина металла
                                                </div>

                                                <div
                                                    class="comparison__parameterRow comparison__parameterRow--name bold">
                                                    Толщина полимерного покрытия
                                                </div>
                                                <div
                                                    class="comparison__parameterRow comparison__parameterRow--name bold">
                                                    Гарантия
                                                </div>
                                                <div
                                                    class="comparison__parameterRow comparison__parameterRow--name bold">
                                                    Цветостойкость
                                                </div>
                                            </div>

                                            <div class="comparisonGrid__col comparisonGrid__col--right">
                                                <div class="wrp-compareParametersSlider">
                                                    <div class="swiper-container compareParametersSlider _swiper">
                                                        <div class="swiper-wrapper compareParametersSlider__wrapper">
                                                            @foreach($compareCoatings as $product)
                                                                <div
                                                                    class="swiper-slide undefined compareParametersSlider__slide">
                                                                    @if($product->protective_layer != null)
                                                                        <div class="comparison__parameterRow">
                                                                            {{ $product->protective_layer }}
                                                                        </div>
                                                                    @else
                                                                        <div class="comparison__parameterRow">
                                                                            -
                                                                        </div>
                                                                    @endif
                                                                    @if($product->metal_thickness != null)
                                                                        <div class="comparison__parameterRow">
                                                                            {{ $product->metal_thickness }}
                                                                        </div>
                                                                    @else
                                                                        <div class="comparison__parameterRow">
                                                                            -
                                                                        </div>
                                                                    @endif
                                                                    @if($product->polymer_coating_thickness != null)
                                                                        <div class="comparison__parameterRow">
                                                                            {{ $product->polymer_coating_thickness }}
                                                                        </div>
                                                                    @else
                                                                        <div class="comparison__parameterRow">
                                                                            -
                                                                        </div>
                                                                    @endif
                                                                    @if($product->guarantee != null)
                                                                        <div class="comparison__parameterRow">
                                                                            {{ $product->guarantee }}
                                                                        </div>
                                                                    @else
                                                                        <div class="comparison__parameterRow">
                                                                            -
                                                                        </div>
                                                                    @endif
                                                                    @if($product->light_fastness != null)
                                                                        <div class="comparison__parameterRow">
                                                                            {{ $product->light_fastness }}
                                                                        </div>
                                                                    @else
                                                                        <div class="comparison__parameterRow">
                                                                            -
                                                                        </div>
                                                                    @endif
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="comparison__back">
                                            <a class="comparison__backBtn btn"
                                               href="/posts/vidy-pokrytiya">
                                                Назад к покрытиям
                                            </a>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            @else
                                <div class="comparison__infoCompare">
                                    <div class="comparison__categoryName">
                                        Список сравнения пуст
                                    </div>
                                </div>
                            @endif
                        </div>
                </div>
        </section>
    </main>
@endsection
