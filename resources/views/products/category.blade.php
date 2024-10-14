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
                                    <svg>
                                        <use xlink:href="/img/sprites/sprite-mono.svg#slideArrow"></use>
                                    </svg>
                                </a>
                            </li>
                        @endif
                        @if(is_null($parent->parent_id))
                            <li class="breadcrumbs__item">
                                <a class="breadcrumbs__link"
                                   href="{{ route('index.products.categoryList', ['category' => $parent->slug]) }}">
                                    <span>{{ $parent->title }}</span>
                                    <svg>
                                        <use xlink:href="/img/sprites/sprite-mono.svg#slideArrow"></use>
                                    </svg>
                                </a>
                            </li>
                        @else
                            <li class="breadcrumbs__item">
                                <a class="breadcrumbs__link"
                                   href="{{ route('index.products.categoryList', ['category' => $parent->slug]) }}">
                                    <span>{{ $parent->title }}</span>
                                    <svg>
                                        <use xlink:href="/img/sprites/sprite-mono.svg#slideArrow"></use>
                                    </svg>
                                </a>
                            </li>
                        @endif
                    @endif
                    <li class="breadcrumbs__item">
                        <a class="breadcrumbs__link breadcrumbs__link--active" href="#">
                            <span>{{ $category->title }}</span>
                            <svg>
                                <use xlink:href="/img/sprites/sprite-mono.svg#slideArrow"></use>
                            </svg>
                        </a>
                    </li>
                </ul>
            </div>
        </nav>
        <section class="productsTmp">
            <div class="productsTmp__container _container">
                <div class="productsTmp__content">
                      <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px">
                          <h1 class="productsTmp__title t">
                              {{ $category->title }}
                          </h1>
                          <svg class="productsTmp__filters-icon-mobile">
                              <use xlink:href="{{ asset('img/sprites/sprite-mono.svg#fil') }}"></use>
                          </svg>
                      </div>
                    <div class="cooperation__body sideDashContainer">
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
                            <svg class="productsTmp__filters-icon">
                                <use xlink:href="{{ asset('img/sprites/sprite-mono.svg#fil') }}"></use>
                            </svg>
                            <div class="filters__form"
                                >
                                @if(count($attributesArray) > 0)
                                    <div class="filters__filterGroup">
                                        @foreach($attributesArray as $attributeCode => $attributeData)
                                            <div class="filters__select-wrp">
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
                                            </div>
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
                                          <div class="filters__select-wrp">
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
                                    </div>
                                </form>

                                <div class="productsTmp__sortItem productsTmp__sortItem--btn" role="button" tabindex="0">
                                    <a href="{{ route('index.products.category', array_merge(['category' => $category->slug, 'isPromo' => true], request()->all())) }}">
                                        <span>Скидки и акции
                                            <svg>
                                                <use xlink:href="{{ asset('img/sprites/sprite-mono.svg#v') }}"></use>
                                            </svg>
                                        </span>
                                    </a>
                                </div>

                                <div class="productsTmp__sortItem productsTmp__sortItem--btn" role="button" tabindex="0">
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

                <div class="filter__menu">
                    <div class="filter__menu-wrapper">
                        <div class="filter__menu-header">
                            <div class="filter__menu-filter-icon">
                                <svg>
                                    <use xlink:href="{{ asset('img/sprites/sprite-mono.svg#fil') }}"></use>
                                </svg>
                            </div>
                            <div class="filter__menu-close-button">
                                <svg class="filter__menu-close-icon">
                                    <use xlink:href="{{ asset('/img/sprites/sprite-mono.svg#cancel') }}"></use>
                                </svg>
                            </div>
                        </div>
                        <div class="filter__menu-body">
                            <ul class="filter__menu-list">
                                <li>
                                    <div class="filter__menu-select-wrp">
                                        <select class="filter__menu-select">
                                            <option class="filters__op" value="">Цена</option>
                                        </select>
                                    </div>
                                </li>
                                <li>
                                    <div class="filter__menu-select-wrp">
                                         <select class="filter__menu-select">
                                             <option class="filters__op" value="">Тип профиля</option>
                                         </select>
                                    </div>
                                </li>
                                <li>
                                    <div class="filter__menu-select-wrp">
                                        <select class="filter__menu-select">
                                            <option class="filters__op" value="">Цвет</option>
                                        </select>
                                    </div>
                                </li>
                                <li>
                                    <div class="filter__menu-select-wrp">
                                         <select class="filter__menu-select">
                                             <option class="filters__op" value="">Покрытие</option>
                                         </select>
                                     </div>
                                </li>
                                <li>
                                    <div class="filter__menu-select-wrp">
                                        <select class="filter__menu-select">
                                            <option class="filters__op" value="">Толщина стали</option>
                                        </select>
                                    </div>
                                </li>
                                <li>
                                    <div class="filter__menu-select-wrp">
                                        <select class="filter__menu-select">
                                            <option class="filters__op" value="">Гарантия</option>
                                        </select>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <div class="filter__menu-footer">
                            <button class="filters__btn btn" style="width: 100%" type="submit">Показать</button>
                            <a href="{{ \Illuminate\Support\Facades\URL::current() }}">
                                <button class="filters__btn filters__btn--clear btn" style="width: 100%" type="button">Сбросить
                                    фильтры
                                    <svg>
                                        <use xlink:href="{{ asset('img/sprites/sprite-mono.svg#cloze') }}"></use>
                                    </svg>
                                </button>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
    <style>
        @media (max-width: 767.98px) {
           .productsTmp .filters__form {
                display: none;
           }
           .productsTmp__sortItem--drop .filters__select {
               border: none;
               padding-left: 0;
           }
       }

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

        @media screen and (max-width: 479.98px) {
            .filters__btn {
                flex: 0 0 auto !important;
            }
        }

    </style>
    <script>
        document.querySelector('.productsTmp__filters-icon-mobile').addEventListener('click', function () {
            document.querySelector('.filter__menu').classList.add('filter__menu--active');
        });

        document.querySelector('.filter__menu-close-button').addEventListener('click', function () {
            document.querySelector('.filter__menu').classList.remove('filter__menu--active');
        });


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
