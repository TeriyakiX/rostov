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
                    <li class="breadcrumbs__item"><a class="breadcrumbs__link breadcrumbs__link--active" href="#"><span>Сравнение товаров</span>
                            <svg>
                                <use xlink:href="{{ asset('img/icons/blue-play.svg#blue-play') }}"></use>
                            </svg>
                        </a>
                    </li>
                </ul>
            </div>
        </nav>
        <section class="comparison">
            <div class="comparison__container _container">
                <div class="comparison__content">
                    <h1 class="comparison__title t">
                        Сравнение товаров
                    </h1>
                    <div class="cooperation__body sideDashContainer">
                        @if(count($categories) > 0 || $compareCoatings > 0)
                            <div class="comparison__tabsWrp">
                                <div class="comparison__tabs">
                                    @foreach($categories as $index => $category)
                                        <div class="comparison__tab link" role="button"
                                             data-tab="{{ $category->title }}"
                                             @if($index == $tab) data-active @endif >
                                            {{ $category->title }}
                                            <span class="comparison__tabCount">({{ $category->products_count }})</span>
                                        </div>
                                    @endforeach
                                    @if($compareCoatings > 0)
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
                                         @if($index == $tab) data-active @endif>
                                        <div class="comparison__cards">
                                            <div class="comparisonGrid">
                                                <div
                                                    class="comparisonGrid__col comparisonGrid__col--left comparisonGrid__col--left--desktop">
                                                    <div class="comparison__infoCompare">
                                                        <div
                                                            class="comparison__categoryName">{{ $category->title }}</div>
                                                        <a href="{{ route('index.products.compareFlush') }}">
                                                            <div class="comparison__delAll btn" role="button"
                                                                 tabindex="0">
                                                                Удалить все
                                                            </div>
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="comparisonGrid__col comparisonGrid__col--right">
                                                    <div class="compareSlider__btn" role="button">
                                                        <svg>
                                                            <use
                                                                xlink:href="/img/sprites/sprite-mono.svg#slideArrow"></use>
                                                        </svg>
                                                    </div>
                                                    <div class="wrp-compareSlider">
                                                        <div class="swiper-container compareSlider _swiper">
                                                            <div class="swiper-wrapper compareSlider__wrapper">
                                                                <div
                                                                    class="comparison__infoCompare comparison__infoCompare--mobile swiper-slide itemsSlider__slide">
                                                                    <div
                                                                        class="comparison__categoryName">{{ $category->title }}</div>
                                                                    <a href="{{ route('index.products.compareFlush') }}">
                                                                        <div class="comparison__delAll btn"
                                                                             role="button"
                                                                             tabindex="0">
                                                                            Удалить все
                                                                        </div>
                                                                    </a>
                                                                </div>
                                                                @foreach($category->products as $product)
                                                                    <div
                                                                        class="swiper-slide undefined itemsSlider__slide"
                                                                        data-product="{{ $product->id }}">
                                                                        <div class="card comparison__card"
                                                                             data-product="{{ $product->id }}">
                                                                            @if($product->is_novelty)
                                                                                <div class="card__new-label">New</div>
                                                                            @endif
                                                                            <div class="card__imgBox-wrapper">
                                                                                @if($product->is_promo)
                                                                                    <div
                                                                                        class="card__promo-label">{{$product->getFormattedEndPromoDate()}}</div>
                                                                                @endif
                                                                                <a class="card__imgBox ibg"
                                                                                   href="{{ $product->showLink() }}">
                                                                                    <picture>
                                                                                        <source type="image/webp"
                                                                                                srcset="{{ $product->mainPhotoPath() }}">
                                                                                        <img
                                                                                            src="{{ $product->mainPhotoPath() }}"
                                                                                            alt="p4"
                                                                                            class="cropped-img">
                                                                                    </picture>
                                                                                </a>

                                                                                <div class="card__mini-icons">
                                                                                    <div
                                                                                        class="card__mini-icon card__icon--like addTo {{ product_id_in_list($product->id, 'favorites') ? 'active' : '' }}"
                                                                                        data-destination="Favorites"
                                                                                        role="button" tabindex="0">
                                                                                        <svg>
                                                                                            <use
                                                                                                xlink:href="{{ asset('img/sprites/sprite-mono.svg#heart') }}"></use>
                                                                                        </svg>
                                                                                    </div>
                                                                                    <div
                                                                                        class="card__mini-icon card__icon--stat addTo {{ product_id_in_list($product->id, 'compare') ? 'active' : '' }}"
                                                                                        data-destination="Compare"
                                                                                        role="button" tabindex="0">
                                                                                        <svg>
                                                                                            <use
                                                                                                xlink:href="{{ asset('img/sprites/sprite-mono.svg#stat') }}"></use>
                                                                                        </svg>
                                                                                    </div>
                                                                                </div>

                                                                                <div
                                                                                    class="card__delete addTo removeCard"
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
                                                                                            {{ $productAttribute['model']->title }}
                                                                                            :
                                                                                            {{ $productAttribute['options'][0]->title }}
                                                                                        </li>
                                                                                    @endif
                                                                                @endforeach
                                                                            </ul>
                                                                            <div class="card__price">
                                                                                @if($product->is_promo)
                                                                                    <div>
                                                                                        @if(intval($product->promo_price) == $product->promo_price)
                                                                                            {{ number_format($product->promo_price, 0, ',', ' ') }}
                                                                                            ₽
                                                                                        @else
                                                                                            {{ number_format($product->promo_price, 2, ',', ' ') }}
                                                                                            ₽
                                                                                        @endif
                                                                                        @if($product->show_calculator)
                                                                                            /м²
                                                                                        @endif
                                                                                    </div>
                                                                                    <div
                                                                                        style="text-decoration: line-through; font-size: 12px">
                                                                                        @if(intval($product->price) == $product->price)
                                                                                            {{ number_format($product->price, 0, ',', ' ') }}
                                                                                            ₽
                                                                                        @else
                                                                                            {{ number_format($product->price, 2, ',', ' ') }}
                                                                                            ₽
                                                                                        @endif
                                                                                        @if($product->show_calculator)
                                                                                            /м²
                                                                                        @endif
                                                                                    </div>
                                                                                @else
                                                                                    @if(intval($product->price) == $product->price)
                                                                                        {{ number_format($product->price, 0, ',', ' ') }}
                                                                                        ₽
                                                                                    @else
                                                                                        {{ number_format($product->price, 2, ',', ' ') }}
                                                                                        ₽
                                                                                    @endif
                                                                                    @if($product->show_calculator)
                                                                                        /м²
                                                                                    @endif
                                                                                @endif
                                                                            </div>
                                                                            <div class="card__controllers">
                                                                                <a href="{{ $product->showLink() }}">
                                                                                    <div class="card__btn btn"
                                                                                         role="button"
                                                                                         tabindex="0">Подробнее
                                                                                    </div>
                                                                                </a>

                                                                                <div class="card__icons">
                                                                                    <div
                                                                                        class="card__icon card__icon--basket"
                                                                                        data-destination="Basket"
                                                                                        role="button" tabindex="0">
                                                                                        <svg>
                                                                                            <use
                                                                                                xlink:href="{{ asset('img/sprites/sprite-mono.svg#basket') }}"></use>
                                                                                        </svg>
                                                                                    </div>
                                                                                </div>


                                                                                {{--                                                                                <div class="card__icons">--}}
                                                                                {{--                                                                                    <div--}}
                                                                                {{--                                                                                            class="card__icon card__icon--like addTo {{ product_id_in_list($product->id, 'favorites') ? 'active' : '' }}"--}}
                                                                                {{--                                                                                            data-destination="Favorites"--}}
                                                                                {{--                                                                                            role="button" tabindex="0">--}}
                                                                                {{--                                                                                        <svg>--}}
                                                                                {{--                                                                                            <use--}}
                                                                                {{--                                                                                                    xlink:href="/img/sprites/sprite-mono.svg#heart"></use>--}}
                                                                                {{--                                                                                        </svg>--}}
                                                                                {{--                                                                                    </div>--}}
                                                                                {{--                                                                                    <div--}}
                                                                                {{--                                                                                            class="card__icon card__icon--stat addTo removeCard {{ product_id_in_list($product->id, 'compare') ? 'active' : '' }}"--}}
                                                                                {{--                                                                                            data-destination="Compare"--}}
                                                                                {{--                                                                                            role="button" tabindex="0">--}}
                                                                                {{--                                                                                        <svg>--}}
                                                                                {{--                                                                                            <use--}}
                                                                                {{--                                                                                                    xlink:href="/img/sprites/sprite-mono.svg#stat"></use>--}}
                                                                                {{--                                                                                        </svg>--}}
                                                                                {{--                                                                                    </div>--}}
                                                                                {{--                                                                                </div>--}}
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
                                                    <input
                                                        {{Request::get('difference') == 'true' ? 'checked' : ''}} onchange="compareDifference()"
                                                        class="checkbox__input" id="chkbox" autocomplete="off"
                                                        type="checkbox">
                                                    <label class="checkbox__label link" for="chkbox">Показывать только
                                                        различия</label>
                                                </div>
                                            </div>
                                            <div class="comparisonGrid">
                                                <div
                                                    class="comparisonGrid__col comparisonGrid__col--left comparisonGrid__col--left--desktop">
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
                                                    @if(!$category->hidePrice)
                                                        <div
                                                            class="comparison__parameterRow comparison__parameterRow--name bold">
                                                            Цена
                                                        </div>
                                                    @endif
                                                    @if(!$category->hideCategory)
                                                        <div
                                                            class="comparison__parameterRow comparison__parameterRow--name bold">
                                                            Категория
                                                        </div>
                                                    @endif
                                                    @if($category->is_list)
                                                        @if(!$category->hideList1)
                                                            <div
                                                                class="comparison__parameterRow comparison__parameterRow--name bold">
                                                                Ширина полная
                                                            </div>
                                                        @endif    @if(!$category->hideList2)
                                                            <div
                                                                class="comparison__parameterRow comparison__parameterRow--name bold">
                                                                Ширина полезная
                                                            </div>
                                                        @endif       @if(!$category->hideList3)
                                                            <div
                                                                class="comparison__parameterRow comparison__parameterRow--name bold">
                                                                Длина на заказ
                                                            </div>
                                                        @endif
                                                    @endif
                                                </div>

                                                <div class="comparisonGrid__col comparisonGrid__col--right">
                                                    <div class="wrp-compareParametersSlider">
                                                        <div class="swiper-container compareParametersSlider _swiper">
                                                            <div
                                                                class="swiper-wrapper compareParametersSlider__wrapper">
                                                                <div
                                                                    class="comparison__infoCompare comparison__infoCompare--mobile swiper-slide itemsSlider__slide">
                                                                    @foreach($category->attributes as $attribute)
                                                                        <div
                                                                            class="comparison__parameterRow comparison__parameterRow--name bold">
                                                                            {{$attribute}}
                                                                        </div>
                                                                    @endforeach
                                                                    @if(!$category->hidePrice)
                                                                        <div
                                                                            class="comparison__parameterRow comparison__parameterRow--name bold">
                                                                            Цена
                                                                        </div>
                                                                    @endif
                                                                    @if(!$category->hideCategory)
                                                                        <div
                                                                            class="comparison__parameterRow comparison__parameterRow--name bold">
                                                                            Категория
                                                                        </div>
                                                                    @endif
                                                                    @if($category->is_list)
                                                                        @if(!$category->hideList1)
                                                                            <div
                                                                                class="comparison__parameterRow comparison__parameterRow--name bold">
                                                                                Ширина полная
                                                                            </div>
                                                                        @endif    @if(!$category->hideList2)
                                                                            <div
                                                                                class="comparison__parameterRow comparison__parameterRow--name bold">
                                                                                Ширина полезная
                                                                            </div>
                                                                        @endif       @if(!$category->hideList3)
                                                                            <div
                                                                                class="comparison__parameterRow comparison__parameterRow--name bold">
                                                                                Длина на заказ
                                                                            </div>
                                                                        @endif
                                                                    @endif
                                                                </div>
                                                                @foreach($category->products as $product)
                                                                    <div
                                                                        class="swiper-slide undefined compareParametersSlider__slide">
                                                                        @foreach($category->attributes as $attribute_id => $attribute)
                                                                            @if($product->attributes[$attribute_id])

                                                                                <div class="comparison__parameterRow">
                                                                                    @foreach($product->attributes[$attribute_id]['options'] as $option)
                                                                                        @if( $option !== null)
                                                                                            {{$option['title']}}
                                                                                        @else()
                                                                                            <p></p>
                                                                                        @endif
                                                                                    @endforeach
                                                                                    <span
                                                                                        class="comparison__parameterName">
                                                                                 {{ $product->attributes[$attribute_id]['model']->title }}
                                                                                 </span>
                                                                                </div>
                                                                            @else
                                                                                <div class="comparison__parameterRow">

                                                                                </div>
                                                                            @endif

                                                                        @endforeach
                                                                        @if($product->price !== null && !$category->hidePrice)
                                                                            <div class="comparison__parameterRow">
                                                                                {{ $product->price}}
                                                                            </div>

                                                                        @endif
                                                                        @if($category->title !== null  && !$category->hideCategory)
                                                                            <div class="comparison__parameterRow">

                                                                                {{$category->title}}
                                                                            </div>

                                                                        @endif
                                                                        @if($category->is_list)
                                                                            @if(!$category->hideList1)
                                                                                <div class="comparison__parameterRow">
                                                                                    {{$product->list_width_full}}
                                                                                </div>
                                                                            @endif    @if(!$category->hideList2)
                                                                                <div class="comparison__parameterRow">
                                                                                    {{$product->list_width_useful}}
                                                                                </div>
                                                                            @endif    @if(!$category->hideList3)
                                                                                <div class="comparison__parameterRow">
                                                                                    {{$product->custom_length_to}}
                                                                                </div>
                                                                            @endif
                                                                        @endif
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
                                @if($compareCoatings > 0)
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
                                                            <use
                                                                xlink:href="/img/sprites/sprite-mono.svg#slideArrow"></use>
                                                        </svg>
                                                    </div>
                                                    <div class="wrp-compareSlider">
                                                        <div class="swiper-container compareSlider _swiper">
                                                            <div class="swiper-wrapper compareSlider__wrapper">
                                                                @foreach(\App\Models\Coatings::whereIn('id', \Illuminate\Support\Facades\Session::get('coating_id'))->get() as $product)
                                                                    <div
                                                                        class="swiper-slide undefined itemsSlider__slide"
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
                                                                                    role="button"
                                                                                    id="{{ $product->id }}">
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
                                                                                    <div class="card__btn btn"
                                                                                         role="button"
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
                                                            <div
                                                                class="swiper-wrapper compareParametersSlider__wrapper">
                                                                @foreach(\App\Models\Coatings::whereIn('id', \Illuminate\Support\Facades\Session::get('coating_id'))->get() as $product)
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
                                    <div class="empty__block">
                                        <div class="empty__block-info">
                                            <h1 class="empty__title">
                                                Ваш лист сравнения пока что пуст
                                            </h1>
                                            <p class="empty__text">Выберите в каталоге несколько интересующих товаров и
                                                нажмите кнопку «добавить к сравнению»</p>
                                            <a class="btn btn-primary" href="{{ url('/posts/katalog') }}">
                                                Перейти в каталог
                                            </a>
                                        </div>
                                        <img src="img/emptyProducts/package.png" alt="empty-products">
                                    </div>
                                @endif
                            </div>
                    </div>
                </div>
        </section>
    </main>
    <script>
        function compareDifference() {
            let tab = '';
            $('.comparison__tabBlock').each(function (index) {
                if (typeof $(this).data('active') !== 'undefined')
                    tab = '&tab=' + (index);
            });
            location = '{{ route('index.products.compare',Request::get('difference') == 'true' ? 'difference=false' : 'difference=true') }}' + tab;
        }
    </script>
    <style>
        .comparison__title {
            margin-bottom: 0;
        }

        .comparison__parameters .swiper-slide {
            flex-shrink: 0 !important;
        }

        .comparison__cards .swiper-slide {
            flex-shrink: 0 !important;
        }

        .compareSlider .compareSlider__wrapper {
            gap: 0 !important;
        }

        .itemsSlider__slide {
            padding: 10px;
        }

        .empty__block {
            padding-top: 32px;
        }
    </style>
@endsection
