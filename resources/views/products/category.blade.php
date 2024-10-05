@extends('layouts.index')

@section('seo_title', $category->seo_title)
@section('seo_description', $category->seo_description)
@section('seo_keywords', $category->seo_keywords)

@section('content')

    <main class="page" style="min-height: 500px">
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
                        <a class="breadcrumbs__link" href="{{ url('/posts/katalog') }}"><span>Каталог</span>
                            <svg>
                                <use xlink:href="/img/sprites/sprite-mono.svg#slideArrow"></use>
                            </svg>
                        </a>
                    </li>
                    @if($parent = $category->parent)
                        @if($parentParent = $parent->parent)
                            <li class="breadcrumbs__item">
                                <a class="breadcrumbs__link"
                                   href="{{ route('index.products.categoryList', ['category' => $parentParent->slug]) }}">
                                    <span>{{ $parentParent->title }}</span>
                                </a>
                            </li>
                        @endif
                        @if(is_null($parent->parent_id))
                            <li class="breadcrumbs__item">
                                <a class="breadcrumbs__link"
                                   href="{{ route('index.products.categoryList', ['category' => $parent->slug]) }}">
                                    <span>{{ $parent->title }}</span>
                                </a>
                            </li>
                        @else
                            <li class="breadcrumbs__item">
                                <a class="breadcrumbs__link"
                                   href="{{ route('index.products.categoryList', ['category' => $parent->slug]) }}">
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
                    <div class="cooperation__body sideDashContainer">
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
                        <form id="form_filters" action="{{ \Illuminate\Support\Facades\URL::current() }}"
                              method="GET">
                        @if(count($tags) > 0)
                            <div class="newItems__controlPanel">
                                <div class="newItems__tabs">
                                    <input type="hidden" name="tags" value="">
                                    @foreach($tags as $tag)
                                    <a data-tag="{{$tag->id}}" onclick="selectTag(this);return false;" class="newItems__tabsEl @if(in_array($tag->id,$selected_tags)) -active @endif">
                                        {{$tag->title}}
                                    </a>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <div class="filters productsTmp__filters">
                            <svg>
                                <use xlink:href="{{ asset('img/sprites/sprite-mono.svg#fil') }}"></use>
                            </svg>
                            <div class="filters__form"
                                >
                                @if(count($attributesArray) > 0)
                                    <div class="filters__filterGroup">
                                        @foreach($attributesArray as $attributeCode => $attributeData)
                                            <select class="filters__select" name="{{ $attributeCode }}">
                                                <option class="filters__op"
                                                        value="">{{ $attributeData['attribute']['attribute_title'] }}</option>
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
                                    <button class="filters__btn btn" type="submit">Показать</button>
                                    <a href="{{ \Illuminate\Support\Facades\URL::current() }}">
                                        <button class="filters__btn filters__btn--clear btn" type="button">Сбросить
                                            фильтры
                                            <svg>
                                                <use xlink:href="{{ asset('img/sprites/sprite-mono.svg#cloze') }}"></use>
                                            </svg>
                                        </button>
                                    </a>
                                </div>
                            </div>
                        </div>
                        </form>
                        <div class="productsTmp__sortPanel">
                            <div class="productsTmp__sortBox">
                                <form  action="{{ route('index.products.category', array_merge(['category' => $category->slug], request()->all())) }}">
                                    @foreach(request()->all() as $key=> $val)
                                        <input type="hidden" name="{{$key}}" value="{{$val}}">
                                    @endforeach
                                    <div class="productsTmp__sortItem productsTmp__sortItem--drop" role="button"
                                         tabindex="0">
                                        <select class="filters__select" name="orderBy"
                                                onchange="$(this).closest('form').submit()">
                                            <option class="filters__op" value="">По популярности прибывания</option>

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
                                    <a href="{{ route('index.products.category', array_merge(['category' => $category->slug, 'isPromo' => true], request()->all())) }}">
                                        <span>Скидки и акции
                                            <svg>
                                                <use xlink:href="{{ asset('img/sprites/sprite-mono.svg#v') }}"></use>
                                            </svg>
                                        </span>
                                    </a>
                                </div>

                                <div class="productsTmp__sortItem" role="button" tabindex="0">
                                    <a href="{{ route('index.products.category', array_merge(['category' => $category->slug, 'isNovelty' => true], request()->all())) }}">
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
                                <div class="productsTmp__layoutBtn productsTmp__layoutBtn--line" role="button"
                                     tabindex="0">
                                    <svg>
                                        <use xlink:href="{{ asset('img/sprites/sprite-mono.svg#mline') }}"></use>
                                    </svg>
                                </div>
                            </div>
                        </div>
                        @if(count($products) > 0)
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


                        @endif
                        <p class="productsTmp__txt">
                            {!! $category->seo_text !!}
                        </p>
                    </div>
                </div>
        </section>
    </main>
    <style>

        body:not(._touch) .newItems__tabsEl.-active:after {
            border-left: none;
        }

        body:not(._touch) .productsTmp .newItems__tabsEl.-active {
            background-color: #006BDE;
            color: #fff;
        }

        body:not(._touch) .productsTmp .newItems__tabsEl.-active:before,
        body:not(._touch) .productsTmp .newItems__tabsEl.-active:after {
            background-color: #006BDE;
            border: 2px solid #006BDE;
        }

        body:not(._touch) .productsTmp .newItems__tabsEl.-active:after {
            border-left: none;
        }

    </style>
    <script>
        checkTags();
        function selectTag(elem) {
            $(elem).toggleClass('-active');
            checkTags();
            $('#form_filters').submit();
        }
        function checkTags() {
            let tags = '';
            let tags_elems = $('.newItems__tabs .newItems__tabsEl');
            $.each(tags_elems,function () {
                if($(this).hasClass('-active')){
                    tags += $(this).data('tag')+',';
                }
            });
            tags = tags.replace(/,\s*$/, "");
            $('.newItems__tabs input').val(tags);
        }
    </script>
@endsection
