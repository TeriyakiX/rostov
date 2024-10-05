@extends('layouts.index')

@section('seo_title', $category->seo_title)
@section('seo_description', $category->seo_description)
@section('seo_keywords', $category->seo_keywords)

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
                    @if($parent = $category->parent)
                        @if($parentParent = $parent->parent)
                            <li class="breadcrumbs__item">
                                <a class="breadcrumbs__link" href="{{ route('index.products.categoryList', ['category' => $parentParent->slug]) }}">
                                    <span>{{ $parentParent->title }}</span>
                                </a>
                            </li>
                        @endif
                        @if(is_null($parent->parent_id))
                            <li class="breadcrumbs__item">
                                <a class="breadcrumbs__link" href="{{ route('index.products.categoryList', ['category' => $parent->slug]) }}">
                                    <span>{{ $parent->title }}</span>
                                </a>
                            </li>
                        @else
                            <li class="breadcrumbs__item">
                                <a class="breadcrumbs__link" href="{{ route('index.products.category', ['category' => $parent->slug]) }}">
                                    <span>{{ $parent->title }}</span>
                                </a>
                            </li>
                        @endif
                    @endif
                    <li class="breadcrumbs__item">
                        <a class="breadcrumbs__link breadcrumbs__link--active" href="#">
                            <span>{{ $category->title }}</span>
                        </a>
                    </li>
                </ul>
            </div>
        </nav>
        <section class="productsTmp">
            <div class="productsTmp__container _container">
                <div class="productsTmp__content">
                    <h1 class="productsTmp__title t">
                        {{ $category->title }}
                    </h1>

{{--                    <div class="newItems__controlPanel">--}}
{{--                        <div class="newItems__tabs">--}}
{{--                            <a class="newItems__tabsEl -active" href="#">--}}
{{--                                Тэг по одному из признаков товара--}}
{{--                            </a>--}}
{{--                            <a class="newItems__tabsEl" href="#">--}}
{{--                                Ламонтерра--}}
{{--                            </a>--}}
{{--                            <a class="newItems__tabsEl" href="#">--}}
{{--                                Террамонт--}}
{{--                            </a>--}}
{{--                            <a class="newItems__tabsEl" href="#">--}}
{{--                                Популярный признак--}}
{{--                            </a>--}}
{{--                            <a class="newItems__tabsEl" href="#">--}}
{{--                                Тэг по одному из признаков товара--}}
{{--                            </a>--}}
{{--                            <a class="newItems__tabsEl" href="#">--}}
{{--                                Ламонтерра--}}
{{--                            </a>--}}
{{--                            <a class="newItems__tabsEl" href="#">--}}
{{--                                Террамонт--}}
{{--                            </a>--}}
{{--                            <a class="newItems__tabsEl" href="#">--}}
{{--                                Популярный признак--}}
{{--                            </a>--}}
{{--                            <a class="newItems__tabsEl" href="#">--}}
{{--                                Ламонтерра--}}
{{--                            </a>--}}
{{--                            <a class="newItems__tabsEl" href="#">--}}
{{--                                Террамонт--}}
{{--                            </a>--}}
{{--                        </div>--}}
{{--                    </div>--}}

                    @if(count($products) > 0)
                        <div class="filters productsTmp__filters">
                            <svg>
                                <use xlink:href="{{ asset('img/sprites/sprite-mono.svg#fil') }}"></use>
                            </svg>
                            <form class="filters__form" action="{{ \Illuminate\Support\Facades\URL::current() }}" method="GET">
                                @if(count($attributesArray) > 0)
                                    <div class="filters__filterGroup">
                                        @foreach($attributesArray as $attributeCode => $attributeData)
                                            <select class="filters__select" name="{{ $attributeCode }}" onchange="$(this).closest('form').submit()">
                                                <option class="filters__op" value="">{{ $attributeData['attribute']['attribute_title'] }}</option>
                                                @foreach($attributeData['options'] as $option)
                                                    <option class="filters__op" value="{{ $option['option_code'] }}"
                                                        @if(request()->get($attributeCode) == $option['option_code']) selected
                                                        @endif
                                                        >
                                                        {{ $option['option_title'] }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        @endforeach
                                    </div>
                                @endif
                                <div class="filters__btnGroup">
    {{--                                <button class="filters__btn btn" type="submit">Показать</button>--}}
                                    <a href="{{ \Illuminate\Support\Facades\URL::current() }}">
                                        <button class="filters__btn filters__btn--clear btn" type="button">Сбросить фильтры
                                            <svg>
                                                <use xlink:href="{{ asset('img/sprites/sprite-mono.svg#cloze') }}"></use>
                                            </svg>
                                        </button>
                                    </a>
                                </div>
                            </form>
                        </div>

                        <div class="productsTmp__sortPanel">
                            <div class="productsTmp__sortBox">
                                <form action="{{ route('index.products.category', array_merge(['category' => $category->slug], request()->all())) }}">
                                    <div class="productsTmp__sortItem productsTmp__sortItem--drop" role="button"
                                         tabindex="0">
                                        <select class="filters__select" name="orderBy" onchange="$(this).closest('form').submit()">
                                            <option class="filters__op" value="">Сначала популярные</option>

                                            <option class="filters__op" value="priceAsc"
                                                    @if(request()->get('orderBy') == 'priceAsc') selected @endif >
                                                Сначала дешевле
                                            </option>

                                            <option class="filters__op" value="priceDesc"
                                                    @if(request()->get('orderBy') == 'priceDesc') selected @endif >
                                                Сначала дороже
                                            </option>

                                            <option class="filters__op" value="title"
                                                    @if(request()->get('orderBy') == 'title') selected @endif >
                                                По названию (А-Я)
                                            </option>
                                        </select>
                                    </div>
                                </form>

                                <div class="productsTmp__sortItem" role="button" tabindex="0">
                                    <a href="{{ route('index.products.category', array_merge(['category' => $category->slug, 'isPromo' => true])) }}">
                                        <span>Скидки и акции
                                            <svg>
                                                <use xlink:href="{{ asset('img/sprites/sprite-mono.svg#v') }}"></use>
                                            </svg>
                                        </span>
                                    </a>
                                </div>

                                <div class="productsTmp__sortItem" role="button" tabindex="0">
                                    <a href="{{ route('index.products.category', array_merge(['category' => $category->slug, 'isNovelty' => true])) }}">
                                        <span>Новинки
                                            <svg>
                                              <use xlink:href="{{ asset('img/sprites/sprite-mono.svg#v') }}"></use>
                                            </svg>
                                        </span>
                                    </a>
                                </div>
                            </div>
                            <div class="productsTmp__layoutControl">
                                <div class="productsTmp__layoutBtn productsTmp__layoutBtn--col _active" role="button"
                                     tabindex="0">
                                    <svg>
                                        <use xlink:href="{{ asset('img/sprites/sprite-mono.svg#mcol') }}"></use>
                                    </svg>
                                </div>
                                <div class="productsTmp__layoutBtn productsTmp__layoutBtn--line" role="button" tabindex="0">
                                    <svg>
                                        <use xlink:href="{{ asset('img/sprites/sprite-mono.svg#mline') }}"></use>
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <div class="productsTmp__body" id="data-wrapper">
                            @foreach($products as $product)
                                @include('products._category_item')
                            @endforeach
                        </div>

                        @if($products->hasMorePages())
                            <div class="addBox">
                                <div class="add productsTmp__add"
                                     onclick="loadMore(this)"
                                     role="button"
                                     data-action="{{ route('index.products.category', ['category' => $category->slug]) }}"
                                     data-page="2"
                                     tabindex="0">
                                    Показать ещё
                                </div>
                            </div>
                        @endif

                        <p class="productsTmp__txt">
                            {!! $category->seo_text !!}
                        </p>
                    @endif
                </div>
            </div>
        </section>
    </main>
@endsection
