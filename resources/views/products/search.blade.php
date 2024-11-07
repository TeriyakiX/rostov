@extends('layouts.index')

{{--@section('seo_title', $category->seo_title)--}}
{{--@section('seo_description', $category->seo_description)--}}
{{--@section('seo_keywords', $category->seo_keywords)--}}

@section('content')
    <main class="page">
        <nav class="breadcrumbs">
            <div class="breadcrumbs__container _container">
                <ul class="breadcrumbs__list">
                    <li class="breadcrumbs__item">
                        <a class="breadcrumbs__link" href="{{ route('index.home') }}">
                            <span>Главная</span>
                            <svg>
                                <use xlink:href="/img/sprites/sprite-mono.svg#slideArrow"></use>
                            </svg>
                        </a>
                    </li>
                    <li class="breadcrumbs__item">
                        <a class="breadcrumbs__link breadcrumbs__link--active">
                            <span>Поиск по запросу "{{ $query }}"</span>
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
                    <div
                        style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px">
                        <h1 class="productsTmp__title t">Поиск по запросу "{{ $query }}"
                        </h1>
                        <svg class="productsTmp__filters-icon-mobile">
                            <use xlink:href="{{ asset('img/sprites/sprite-mono.svg#fil') }}"></use>
                        </svg>
                    </div>
                    <div class="newItems__controlPanel">
                        <div class="newItems__tabs"><a class="newItems__tabsEl -active" href="#">Тэг по одному из
                                признаков товара</a><a class="newItems__tabsEl" href="#">Ламонтерра</a><a
                                class="newItems__tabsEl" href="#">Террамонт</a>
                        </div>
                    </div>
                    <div class="filters productsTmp__filters">
                        <svg class="productsTmp__filters-icon">
                            <use xlink:href="/img/sprites/sprite-mono.svg#fil"></use>
                        </svg>
                        <form class="filters__form" action="#" method="POST">
                            <div class="filters__filterGroup">
                                <div class="filters__select-wrp">
                                    <select class="filters__select" name="select">
                                        <option class="filters__op" value="">Цена</option>
                                        <option class="filters__op" value="value2">знач 1</option>
                                        <option class="filters__op" value="value3">знач 2</option>
                                    </select>
                                </div>
                                <div class="filters__select-wrp">
                                    <select class="filters__select" name="select">
                                        <option class="filters__op" value="">Тип профиля</option>
                                        <option class="filters__op" value="value2">знач 1</option>
                                        <option class="filters__op" value="value3">знач 2</option>
                                    </select>
                                </div>
                                <div class="filters__select-wrp">
                                    <select class="filters__select" name="select">
                                        <option class="filters__op" value="">Цвет</option>
                                        <option class="filters__op" value="value2">знач 1</option>
                                        <option class="filters__op" value="value3">знач 2</option>
                                    </select>
                                </div>
                                <div class="filters__select-wrp">
                                    <select class="filters__select" name="select">
                                        <option class="filters__op" value="">Покрытие</option>
                                        <option class="filters__op" value="value2">знач 1</option>
                                        <option class="filters__op" value="value3">знач 2</option>
                                    </select>
                                </div>
                                <div class="filters__select-wrp">
                                    <select class="filters__select" name="select">
                                        <option class="filters__op" value="">Толщина стали</option>
                                        <option class="filters__op" value="value2">знач 1</option>
                                        <option class="filters__op" value="value3">знач 2</option>
                                    </select>
                                </div>
                                <div class="filters__select-wrp">
                                    <select class="filters__select" name="select">
                                        <option class="filters__op" value="">Гарантия</option>
                                        <option class="filters__op" value="value2">знач 1</option>
                                        <option class="filters__op" value="value3">знач 2</option>
                                    </select>
                                </div>
                            </div>
                            <div class="filters__btnGroup">
                                <button class="filters__btn btn" type="submit">Показать</button>
                                <button class="filters__btn filters__btn--clear btn" type="button">Сбросить фильтры
                                    <svg>
                                        <use xlink:href="/img/sprites/sprite-mono.svg#cloze"></use>
                                    </svg>
                                </button>
                            </div>
                        </form>
                    </div>
                    <div class="productsTmp__sortPanel">
                        <div class="productsTmp__sortBox">
                            <form>
                                @foreach(request()->all() as $key=> $val)
                                    <input type="hidden" name="{{$key}}" value="{{$val}}">
                                @endforeach
                                <div class="productsTmp__sortItem productsTmp__sortItem--drop" role="button"
                                     tabindex="0">
                                    <div class="filters__select-wrp">
                                        <select class="filters__select" name="orderBy"
                                                onchange="$(this).closest('form').submit()">
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
                                <a href="">
                                        <span>Скидки и акции
                                            <svg>
                                                <use xlink:href="{{ asset('img/sprites/sprite-mono.svg#v') }}"></use>
                                            </svg>
                                        </span>
                                </a>
                            </div>

                            <div class="productsTmp__sortItem productsTmp__sortItem--btn" role="button" tabindex="0">
                                <a href="">
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
                    <div class="productsTmp__body">

                        @foreach($products as $product)
                            @include('products._product_item')
                        @endforeach

                        {{--                        <div class="addBox">--}}
                        {{--                            <div class="add productsTmp__add" role="button" tabindex="0">Показать ещё</div>--}}
                        {{--                        </div>--}}
                    </div>

                    {{--                    <p class="productsTmp__txt">--}}
                    {{--                        SEO текст. Дивергенция векторного поля позитивно трансформирует натуральный логарифм. Умножение двух векторов (скалярное) накладывает неопровержимый двойной интеграл, что несомненно приведет нас к истине. Математический анализ изящно ускоряет абстрактный Наибольший Общий Делитель (НОД).--}}
                    {{--                    </p>--}}
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
                            <div class="filter__menu-list">
                                <div class="filters__select-wrp">
                                    <select class="filters__select" name="select">
                                        <option class="filters__op" value="">Цена</option>
                                        <option class="filters__op" value="value2">знач 1</option>
                                        <option class="filters__op" value="value3">знач 2</option>
                                    </select>
                                </div>
                                <div class="filters__select-wrp">
                                    <select class="filters__select" name="select">
                                        <option class="filters__op" value="">Тип профиля</option>
                                        <option class="filters__op" value="value2">знач 1</option>
                                        <option class="filters__op" value="value3">знач 2</option>
                                    </select>
                                </div>
                                <div class="filters__select-wrp">
                                    <select class="filters__select" name="select">
                                        <option class="filters__op" value="">Цвет</option>
                                        <option class="filters__op" value="value2">знач 1</option>
                                        <option class="filters__op" value="value3">знач 2</option>
                                    </select>
                                </div>
                                <div class="filters__select-wrp">
                                    <select class="filters__select" name="select">
                                        <option class="filters__op" value="">Покрытие</option>
                                        <option class="filters__op" value="value2">знач 1</option>
                                        <option class="filters__op" value="value3">знач 2</option>
                                    </select>
                                </div>
                                <div class="filters__select-wrp">
                                    <select class="filters__select" name="select">
                                        <option class="filters__op" value="">Толщина стали</option>
                                        <option class="filters__op" value="value2">знач 1</option>
                                        <option class="filters__op" value="value3">знач 2</option>
                                    </select>
                                </div>
                                <div class="filters__select-wrp">
                                    <select class="filters__select" name="select">
                                        <option class="filters__op" value="">Гарантия</option>
                                        <option class="filters__op" value="value2">знач 1</option>
                                        <option class="filters__op" value="value3">знач 2</option>
                                    </select>
                                </div>
                            </div>

                            <div class="filter__menu-footer">
                                <button class="filters__btn btn" style="width: 100%" type="submit">Показать</button>
                                <a href="{{ \Illuminate\Support\Facades\URL::current() }}">
                                    <button class="filters__btn filters__btn--clear btn" style="width: 100%"
                                            type="button">Сбросить
                                        фильтры
                                        <svg>
                                            <use
                                                xlink:href="{{ asset('img/sprites/sprite-mono.svg#cloze') }}"></use>
                                        </svg>
                                    </button>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <script>
        document.querySelector('.productsTmp__filters-icon-mobile').addEventListener('click', function () {
            document.querySelector('.filter__menu').classList.add('filter__menu--active');
        });

        document.querySelector('.filter__menu-close-button').addEventListener('click', function () {
            document.querySelector('.filter__menu').classList.remove('filter__menu--active');
        });
    </script>
    <style>
        .newItems__tabsEl:first-child {
            padding-left: 20px;
        }
        .productsTmp__title {
            margin-bottom: 0 !important;
        }

        .filters__filterGroup {
            flex-wrap: wrap;
        }

        .productsTmp .filters__form {
            flex-wrap: wrap;
        }
        .card__controllers--mobile {
            display: none;
        }

        .newItems__tabs:before {
            height: 100%;
        }

        @media (max-width: 767.98px) {
            .productsTmp .filters__form {
                display: none;
            }

            .productsTmp__sortItem--drop .filters__select {
                border: none;
                padding-left: 0;
            }
            .productsTmp__body--line .card__controllers--desktop {
                display: none;
            }
            .productsTmp__body--line .card__controllers--mobile {
                margin-top: 8px;
                display: flex;
                flex: 1 0 100%;
            }
            .productsTmp__body--line .card {
                flex-wrap: wrap;
            }
        }
        @media (max-width: 479.98px) {
            .filters__btn {
                flex: 0 0 auto;
            }
        }
    </style>
@endsection
