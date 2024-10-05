@extends('layouts.index')

@section('content')
    <main class="page">
        <nav class="breadcrumbs">
            <div class="breadcrumbs__container _container">
                <ul class="breadcrumbs__list">
                    <li class="breadcrumbs__item">
                        <a class="breadcrumbs__link" href="{{ url('/') }}">
                            <span>Главная</span>
                            <svg>
                                <use xlink:href="/img/sprites/sprite-mono.svg#slideArrow"></use>
                            </svg>
                        </a>
                    </li>
                    <li class="breadcrumbs__item">
                        <a class="breadcrumbs__link breadcrumbs__link--active" href="{{ route('index.projects.index') }}">
                            <span>Наши проекты</span>
                        </a>
                    </li>
                </ul>
            </div>
        </nav>

        <!-- Project Gallery-->
        <section class="gallery">
            <div class="gallery__container _container">
                <div class="gallery__content">
                    <h2 class="gallery__title t">Наши проекты</h2>
{{--                    <div class="productsTmp">--}}
{{--                        <div class="newItems__controlPanel">--}}
{{--                            <div class="newItems__tabs">--}}
{{--                                <a class="newItems__tabsEl -active" href="#">Тэг по одному из признаков товара</a>--}}
{{--                                <a class="newItems__tabsEl" href="#">Ламонтерра</a>--}}
{{--                                <a class="newItems__tabsEl" href="#">Террамонт</a>--}}
{{--                                <a class="newItems__tabsEl" href="#">Популярный признак</a>--}}
{{--                                <a class="newItems__tabsEl" href="#">Тэг по одному из признаков товара</a>--}}
{{--                                <a class="newItems__tabsEl" href="#">Ламонтерра</a>--}}
{{--                                <a class="newItems__tabsEl" href="#">Террамонт</a>--}}
{{--                                <a class="newItems__tabsEl" href="#">Популярный признак</a>--}}
{{--                                <a class="newItems__tabsEl" href="#">Ламонтерра</a>--}}
{{--                                <a class="newItems__tabsEl" href="#">Террамонт</a>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
                    <div class="gallery__body sideDashContainer">

                        @foreach($projects as $project)
                            @include('project._project_item')
                        @endforeach

{{--                        <div class="sideDash sideDash--sticky">--}}
{{--                            <div class="sideDash__item sideDash__item--gap sideDash__item--active">--}}
{{--                                <svg class="sideDash__icon">--}}
{{--                                    <use xlink:href="./img/sprites/sprite-mono.svg#building"></use>--}}
{{--                                </svg>--}}
{{--                                <div class="sideDash__mark">Услуги</div>--}}
{{--                            </div>--}}
{{--                            <div class="sideDash__item sideDash__item--gap">--}}
{{--                                <svg class="sideDash__icon">--}}
{{--                                    <use xlink:href="./img/sprites/sprite-mono.svg#manufacturing"></use>--}}
{{--                                </svg>--}}
{{--                                <div class="sideDash__mark">Услуги</div>--}}
{{--                            </div>--}}
{{--                            <div class="sideDash__item sideDash__item--gap">--}}
{{--                                <svg class="sideDash__icon">--}}
{{--                                    <use xlink:href="./img/sprites/sprite-mono.svg#settings"></use>--}}
{{--                                </svg>--}}
{{--                                <div class="sideDash__mark">Услуги</div>--}}
{{--                            </div>--}}
{{--                            <div class="sideDash__item sideDash__item--gap">--}}
{{--                                <svg class="sideDash__icon">--}}
{{--                                    <use xlink:href="./img/sprites/sprite-mono.svg#management"></use>--}}
{{--                                </svg>--}}
{{--                                <div class="sideDash__mark">Услуги</div>--}}
{{--                            </div>--}}
{{--                        </div>--}}

                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
