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
                        </a>
                    </li>
                </ul>
            </div>
        </nav>
        <section class="productsTmp">
            <div class="productsTmp__container _container">
                <div class="productsTmp__content">
                    <h1 class="productsTmp__title t">Поиск по запросу "{{ $query }}"
                    </h1>
                    <div class="newItems__controlPanel">
                        <div class="newItems__tabs"><a class="newItems__tabsEl -active" href="#">Тэг по одному из признаков товара</a><a class="newItems__tabsEl" href="#">Ламонтерра</a><a class="newItems__tabsEl" href="#">Террамонт</a><a class="newItems__tabsEl" href="#">Популярный признак</a><a class="newItems__tabsEl" href="#">Тэг по одному из признаков товара</a><a class="newItems__tabsEl" href="#">Ламонтерра</a><a class="newItems__tabsEl" href="#">Террамонт</a><a class="newItems__tabsEl" href="#">Популярный признак</a><a class="newItems__tabsEl" href="#">Ламонтерра</a><a class="newItems__tabsEl" href="#">Террамонт</a>
                        </div>
                    </div>
                    <div class="filters productsTmp__filters">
                        <svg>
                            <use xlink:href="/img/sprites/sprite-mono.svg#fil"></use>
                        </svg>
                        <form class="filters__form" action="#" method="POST">
                            <div class="filters__filterGroup">
                                <select class="filters__select" name="select">
                                    <option class="filters__op" value="">Цена</option>
                                    <option class="filters__op" value="value2">знач 1</option>
                                    <option class="filters__op" value="value3">знач 2</option>
                                </select>
                                <select class="filters__select" name="select">
                                    <option class="filters__op" value=""> Тип профиля</option>
                                    <option class="filters__op" value="value2">знач 1</option>
                                    <option class="filters__op" value="value3">знач 2</option>
                                </select>
                                <select class="filters__select" name="select">
                                    <option class="filters__op" value="">Цвет</option>
                                    <option class="filters__op" value="value2">знач 1</option>
                                    <option class="filters__op" value="value3">знач 2</option>
                                </select>
                                <select class="filters__select" name="select">
                                    <option class="filters__op" value="">Покрытие</option>
                                    <option class="filters__op" value="value2">знач 1</option>
                                    <option class="filters__op" value="value3">знач 2</option>
                                </select>
                                <select class="filters__select" name="select">
                                    <option class="filters__op" value="">Толщина стали</option>
                                    <option class="filters__op" value="value2">знач 1</option>
                                    <option class="filters__op" value="value3">знач 2</option>
                                </select>
                                <select class="filters__select" name="select">
                                    <option class="filters__op" value="">Гарантия</option>
                                    <option class="filters__op" value="value2">знач 1</option>
                                    <option class="filters__op" value="value3">знач 2</option>
                                </select>
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
                            <div class="productsTmp__sortItem productsTmp__sortItem--drop" role="button" tabindex="0"><span>Сначала популярные
                        <svg>
                          <use xlink:href="/img/sprites/sprite-mono.svg#v"></use>
                        </svg></span>
                                <div class="productsTmp__sortDropBox">
                                    <div class="productsTmp__sortItem"><span>Сначала дешевле</span></div>
                                    <div class="productsTmp__sortItem"><span>Сначала дороже</span></div>
                                    <div class="productsTmp__sortItem"><span>По названию (А-Я)</span></div>
                                </div>
                            </div>
                            <div class="productsTmp__sortItem" role="button" tabindex="0"><span>Скидки и акции
                        <svg>
                          <use xlink:href="/img/sprites/sprite-mono.svg#v"></use>
                        </svg></span></div>
                            <div class="productsTmp__sortItem" role="button" tabindex="0"><span>Новинки
                        <svg>
                          <use xlink:href="/img/sprites/sprite-mono.svg#v"></use>
                        </svg></span></div>
                        </div>
                        <div class="productsTmp__layoutControl">
                            <div class="productsTmp__layoutBtn productsTmp__layoutBtn--col _active" role="button" tabindex="0">
                                <svg>
                                    <use xlink:href="/img/sprites/sprite-mono.svg#mcol"></use>
                                </svg>
                            </div>
                            <div class="productsTmp__layoutBtn productsTmp__layoutBtn--line" role="button" tabindex="0">
                                <svg>
                                    <use xlink:href="/img/sprites/sprite-mono.svg#mline"></use>
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
            </div>
        </section>
    </main>
@endsection
