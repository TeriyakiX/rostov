@extends('layouts.index')

@section('content')

    <main class="page">
        <nav class="breadcrumbs">
            <div class="breadcrumbs__container _container">
                <ul class="breadcrumbs__list">
                    <li class="breadcrumbs__item"><a class="breadcrumbs__link" href="#"><span>Главная</span>
                            <svg>
                                <use xlink:href="{{ asset('img/sprites/sprite-mono.svg#slideArrow') }}"></use>
                            </svg></a></li>
                    <li class="breadcrumbs__item"><a class="breadcrumbs__link breadcrumbs__link--active" href="#"><span>Сравнение товаров</span></a></li>
                </ul>
            </div>
        </nav>
        <section class="comparison">
            <div class="comparison__container _container">
                <div class="comparison__content">
                    <h2 class="comparison__title t">Сравнение товаров</h2>
                    <div class="comparison__tabsWrp">
                        <div class="comparison__tabs">
                            <div class="comparison__tab link" role="button" data-tab="Категория товаров 1" data-active>Категория товаров 1
                                <span class="comparison__tabCount">(10)</span>
                            </div>
                            <div class="comparison__tab link" role="button" data-tab="Категория товаров 2">Категория товаров 2
                                <span class="comparison__tabCount">(6)</span>
                            </div>
                            <div class="comparison__tab link" role="button" data-tab="Категория товаров 3">Категория товаров 3
                                <span class="comparison__tabCount">(17)</span>
                            </div>
                            <div class="comparison__tab link" role="button" data-tab="Категория товаров 4">Категория товаров 4
                                <span class="comparison__tabCount">(3)</span>
                            </div>
                        </div>
                    </div>
                    <div class="comparison__tabBlocks"></div>
                    <div class="comparison__tabBlock" data-tabblock="Категория товаров 1" data-active>
                        <div class="comparison__cards">
                            <div class="comparisonGrid">
                                <div class="comparisonGrid__col comparisonGrid__col--left">
                                    <div class="comparison__infoCompare">
                                        <div class="comparison__categoryName">Категория товаров 1</div>
                                        <div class="comparison__delAll btn" role="button" tabindex="0">Удалить все</div>
                                    </div>
                                </div>
                                <div class="comparisonGrid__col comparisonGrid__col--right">
                                    <div class="compareSlider__btn" role="button">
                                        <svg>
                                            <use xlink:href="{{ asset('img/sprites/sprite-mono.svg#slideArrow') }}"></use>
                                        </svg>
                                    </div>
                                    <div class="wrp-compareSlider">
                                        <div class="swiper-container compareSlider _swiper">
                                            <div class="swiper-wrapper compareSlider__wrapper">
                                                <div class="swiper-slide itemsSlider__slide">
                                                    <div class="card comparison__card">
                                                        <div class="card__imgWrp"><a class="card__imgBox ibg" href="#">
                                                                <picture>
                                                                    <source type="image/webp" srcset="./img/productsLayout//p4.webp"><img src="./img/productsLayout//p4.jpg" alt="p4">
                                                                </picture></a>
                                                            <div class="card__delete" role="button">
                                                                <svg>
                                                                    <use xlink:href="{{ asset('img/sprites/sprite-mono.svg#cancel') }}"></use>
                                                                </svg>
                                                            </div>
                                                        </div>
                                                        <div class="card__title"><a class="link" href="">Металлочерепица</a></div>
                                                        <ul class="card__chars">
                                                            <li class="card__char">Цвет: 1014 Слоновая кость</li>
                                                            <li class="card__char">Покрытие: Полиэстер </li>
                                                            <li class="card__char">Толщина, мм: 0.4</li>
                                                        </ul>
                                                        <div class="card__price">
                                                            @if($product->is_promo)
                                                                <div style="text-decoration: line-through;">{{ $product->price }} ₽@if($product->show_calculator)/м²@endif </div>
                                                                <div>{{ $product->promo_price }} ₽@if($product->show_calculator)/м²@endif</div>
                                                            @else
                                                                {{ $product->price }} ₽@if($product->show_calculator)
                                                                    /м²
                                                                @endif
                                                            @endif
                                                        </div>
                                                        <div class="card__controllers">
                                                            <div class="card__btn btn" role="button" tabindex="0">Подробнее</div>
                                                            <div class="card__icons">
                                                                <div class="card__icon card__icon--like" role="button" tabindex="0">
                                                                    <svg>
                                                                        <use xlink:href="{{ asset('img/sprites/sprite-mono.svg#heart') }}"></use>
                                                                    </svg>
                                                                </div>
                                                                <div class="card__icon card__icon--stat" role="button" tabindex="0">
                                                                    <svg>
                                                                        <use xlink:href="{{ asset('img/sprites/sprite-mono.svg#stat') }}"></use>
                                                                    </svg>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="swiper-slide itemsSlider__slide">
                                                    <div class="card comparison__card">
                                                        <div class="card__imgWrp"><a class="card__imgBox ibg" href="#">
                                                                <picture>
                                                                    <source type="image/webp" srcset="./img/productsLayout//p4.webp"><img src="./img/productsLayout//p4.jpg" alt="p4">
                                                                </picture></a>
                                                            <div class="card__delete" role="button">
                                                                <svg>
                                                                    <use xlink:href="{{ asset('img/sprites/sprite-mono.svg#cancel') }}"></use>
                                                                </svg>
                                                            </div>
                                                        </div>
                                                        <div class="card__title"><a class="link" href="">Металлочерепица</a></div>
                                                        <ul class="card__chars">
                                                            <li class="card__char">Цвет: 1014 Слоновая кость</li>
                                                            <li class="card__char">Покрытие: Полиэстер </li>
                                                            <li class="card__char">Толщина, мм: 0.4</li>
                                                        </ul>
                                                        <div class="card__price">667 ₽/м2</div>
                                                        <div class="card__controllers">
                                                            <div class="card__btn btn" role="button" tabindex="0">Подробнее</div>
                                                            <div class="card__icons">
                                                                <div class="card__icon card__icon--like" role="button" tabindex="0">
                                                                    <svg class="_checked">
                                                                        <use xlink:href="{{ asset('img/sprites/sprite-mono.svg#heart') }}"></use>
                                                                    </svg>
                                                                </div>
                                                                <div class="card__icon card__icon--stat" role="button" tabindex="0">
                                                                    <svg class="_checked">
                                                                        <use xlink:href="{{ asset('img/sprites/sprite-mono.svg#stat') }}"></use>
                                                                    </svg>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="swiper-slide itemsSlider__slide">
                                                    <div class="card comparison__card">
                                                        <div class="card__imgWrp"><a class="card__imgBox ibg" href="#">
                                                                <picture>
                                                                    <source type="image/webp" srcset="./img/productsLayout//p4.webp"><img src="./img/productsLayout//p4.jpg" alt="p4">
                                                                </picture></a>
                                                            <div class="card__delete" role="button">
                                                                <svg>
                                                                    <use xlink:href="{{ asset('img/sprites/sprite-mono.svg#cancel') }}"></use>
                                                                </svg>
                                                            </div>
                                                        </div>
                                                        <div class="card__title"><a class="link" href="">Металлочерепица</a></div>
                                                        <ul class="card__chars">
                                                            <li class="card__char">Цвет: 1014 Слоновая кость</li>
                                                            <li class="card__char">Покрытие: Полиэстер </li>
                                                            <li class="card__char">Толщина, мм: 0.4</li>
                                                        </ul>
                                                        <div class="card__price">667 ₽/м2</div>
                                                        <div class="card__controllers">
                                                            <div class="card__btn btn" role="button" tabindex="0">Подробнее</div>
                                                            <div class="card__icons">
                                                                <div class="card__icon card__icon--like" role="button" tabindex="0">
                                                                    <svg>
                                                                        <use xlink:href="{{ asset('img/sprites/sprite-mono.svg#heart') }}"></use>
                                                                    </svg>
                                                                </div>
                                                                <div class="card__icon card__icon--stat" role="button" tabindex="0">
                                                                    <svg>
                                                                        <use xlink:href="{{ asset('img/sprites/sprite-mono.svg#stat') }}"></use>
                                                                    </svg>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="swiper-slide itemsSlider__slide">
                                                    <div class="card comparison__card">
                                                        <div class="card__imgWrp"><a class="card__imgBox ibg" href="#">
                                                                <picture>
                                                                    <source type="image/webp" srcset="./img/productsLayout//p4.webp"><img src="./img/productsLayout//p4.jpg" alt="p4">
                                                                </picture></a>
                                                            <div class="card__delete" role="button">
                                                                <svg>
                                                                    <use xlink:href="{{ asset('img/sprites/sprite-mono.svg#cancel') }}"></use>
                                                                </svg>
                                                            </div>
                                                        </div>
                                                        <div class="card__title"><a class="link" href="">Металлочерепица</a></div>
                                                        <ul class="card__chars">
                                                            <li class="card__char">Цвет: 1014 Слоновая кость</li>
                                                            <li class="card__char">Покрытие: Полиэстер </li>
                                                            <li class="card__char">Толщина, мм: 0.4</li>
                                                        </ul>
                                                        <div class="card__price">667 ₽/м2</div>
                                                        <div class="card__controllers">
                                                            <div class="card__btn btn" role="button" tabindex="0">Подробнее</div>
                                                            <div class="card__icons">
                                                                <div class="card__icon card__icon--like" role="button" tabindex="0">
                                                                    <svg>
                                                                        <use xlink:href="{{ asset('img/sprites/sprite-mono.svg#heart') }}"></use>
                                                                    </svg>
                                                                </div>
                                                                <div class="card__icon card__icon--stat" role="button" tabindex="0">
                                                                    <svg>
                                                                        <use xlink:href="{{ asset('img/sprites/sprite-mono.svg#stat') }}"></use>
                                                                    </svg>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="swiper-slide itemsSlider__slide">
                                                    <div class="card comparison__card">
                                                        <div class="card__imgWrp"><a class="card__imgBox ibg" href="#">
                                                                <picture>
                                                                    <source type="image/webp" srcset="./img/productsLayout//p4.webp') }}"><img src="./img/productsLayout//p4.jpg" alt="p4">
                                                                </picture></a>
                                                            <div class="card__delete" role="button">
                                                                <svg>
                                                                    <use xlink:href="{{ asset('img/sprites/sprite-mono.svg#cancel') }}"></use>
                                                                </svg>
                                                            </div>
                                                        </div>
                                                        <div class="card__title"><a class="link" href="">Металлочерепица</a></div>
                                                        <ul class="card__chars">
                                                            <li class="card__char">Цвет: 1014 Слоновая кость</li>
                                                            <li class="card__char">Покрытие: Полиэстер </li>
                                                            <li class="card__char">Толщина, мм: 0.4</li>
                                                        </ul>
                                                        <div class="card__price">667 ₽/м2</div>
                                                        <div class="card__controllers">
                                                            <div class="card__btn btn" role="button" tabindex="0">Подробнее</div>
                                                            <div class="card__icons">
                                                                <div class="card__icon card__icon--like" role="button" tabindex="0">
                                                                    <svg>
                                                                        <use xlink:href="{{ asset('img/sprites/sprite-mono.svg#heart') }}"></use>
                                                                    </svg>
                                                                </div>
                                                                <div class="card__icon card__icon--stat" role="button" tabindex="0">
                                                                    <svg>
                                                                        <use xlink:href="{{ asset('img/sprites/sprite-mono.svg#stat') }}"></use>
                                                                    </svg>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="comparison__parameters">
                            <div class="comparison__settings">
                                <div class="checkbox">
                                    <input class="checkbox__input" id="chkbox" autocomplete="off" type="checkbox" name="form[]">
                                    <label class="checkbox__label link" for="chkbox">Показывать только различия </label>
                                </div>
                            </div>
                            <div class="comparisonGrid">
                                <div class="comparisonGrid__col comparisonGrid__col--left">
                                    <div class="comparison__parameterRow comparison__parameterRow--name bold">Параметр</div>
                                    <div class="comparison__parameterRow comparison__parameterRow--name bold">Параметр</div>
                                    <div class="comparison__parameterRow comparison__parameterRow--name bold">Параметр</div>
                                    <div class="comparison__parameterRow comparison__parameterRow--name bold">Параметр</div>
                                    <div class="comparison__parameterRow comparison__parameterRow--name bold">Параметр</div>
                                    <div class="comparison__parameterRow comparison__parameterRow--name bold">Параметр</div>
                                    <div class="comparison__parameterRow comparison__parameterRow--name bold">Параметр</div>
                                    <div class="comparison__parameterRow comparison__parameterRow--name bold">Параметр</div>
                                    <div class="comparison__parameterRow comparison__parameterRow--name bold">Параметр</div>
                                </div>
                                <div class="comparisonGrid__col comparisonGrid__col--right">
                                    <div class="wrp-compareParametersSlider">
                                        <div class="swiper-container compareParametersSlider _swiper">
                                            <div class="swiper-wrapper compareParametersSlider__wrapper">
                                                <div class="swiper-slide compareParametersSlider__slide">
                                                    <div class="comparison__parameterRow">Значение параметра<span class="comparison__parameterName">Параметр</span></div>
                                                    <div class="comparison__parameterRow">Значение параметра<span class="comparison__parameterName">Параметр</span></div>
                                                    <div class="comparison__parameterRow">Значение параметра<span class="comparison__parameterName">Параметр</span></div>
                                                    <div class="comparison__parameterRow">Значение параметра<span class="comparison__parameterName">Параметр</span></div>
                                                    <div class="comparison__parameterRow">Значение параметра<span class="comparison__parameterName">Параметр</span></div>
                                                    <div class="comparison__parameterRow">Значение параметра<span class="comparison__parameterName">Параметр</span></div>
                                                    <div class="comparison__parameterRow">Значение параметра<span class="comparison__parameterName">Параметр</span></div>
                                                    <div class="comparison__parameterRow">Значение параметра<span class="comparison__parameterName">Параметр</span></div>
                                                    <div class="comparison__parameterRow">Значение параметра<span class="comparison__parameterName">Параметр</span></div>
                                                </div>
                                                <div class="swiper-slide compareParametersSlider__slide">
                                                    <div class="comparison__parameterRow">Значение параметра<span class="comparison__parameterName">Параметр</span></div>
                                                    <div class="comparison__parameterRow">Значение параметра<span class="comparison__parameterName">Параметр</span></div>
                                                    <div class="comparison__parameterRow">Значение параметра<span class="comparison__parameterName">Параметр</span></div>
                                                    <div class="comparison__parameterRow">Значение параметра<span class="comparison__parameterName">Параметр</span></div>
                                                    <div class="comparison__parameterRow">Значение параметра<span class="comparison__parameterName">Параметр</span></div>
                                                    <div class="comparison__parameterRow">Значение параметра<span class="comparison__parameterName">Параметр</span></div>
                                                    <div class="comparison__parameterRow">Значение параметра<span class="comparison__parameterName">Параметр</span></div>
                                                    <div class="comparison__parameterRow">Значение параметра<span class="comparison__parameterName">Параметр</span></div>
                                                    <div class="comparison__parameterRow">Значение параметра<span class="comparison__parameterName">Параметр</span></div>
                                                </div>
                                                <div class="swiper-slide compareParametersSlider__slide">
                                                    <div class="comparison__parameterRow">Значение параметра<span class="comparison__parameterName">Параметр</span></div>
                                                    <div class="comparison__parameterRow">Значение параметра<span class="comparison__parameterName">Параметр</span></div>
                                                    <div class="comparison__parameterRow">Значение параметра<span class="comparison__parameterName">Параметр</span></div>
                                                    <div class="comparison__parameterRow">Значение параметра<span class="comparison__parameterName">Параметр</span></div>
                                                    <div class="comparison__parameterRow">Значение параметра<span class="comparison__parameterName">Параметр</span></div>
                                                    <div class="comparison__parameterRow">Значение параметра<span class="comparison__parameterName">Параметр</span></div>
                                                    <div class="comparison__parameterRow">Значение параметра<span class="comparison__parameterName">Параметр</span></div>
                                                    <div class="comparison__parameterRow">Значение параметра<span class="comparison__parameterName">Параметр</span></div>
                                                    <div class="comparison__parameterRow">Значение параметра<span class="comparison__parameterName">Параметр</span></div>
                                                </div>
                                                <div class="swiper-slide compareParametersSlider__slide">
                                                    <div class="comparison__parameterRow">Значение параметра<span class="comparison__parameterName">Параметр</span></div>
                                                    <div class="comparison__parameterRow">Значение параметра<span class="comparison__parameterName">Параметр</span></div>
                                                    <div class="comparison__parameterRow">Значение параметра<span class="comparison__parameterName">Параметр</span></div>
                                                    <div class="comparison__parameterRow">Значение параметра<span class="comparison__parameterName">Параметр</span></div>
                                                    <div class="comparison__parameterRow">Значение параметра<span class="comparison__parameterName">Параметр</span></div>
                                                    <div class="comparison__parameterRow">Значение параметра<span class="comparison__parameterName">Параметр</span></div>
                                                    <div class="comparison__parameterRow">Значение параметра<span class="comparison__parameterName">Параметр</span></div>
                                                    <div class="comparison__parameterRow">Значение параметра<span class="comparison__parameterName">Параметр</span></div>
                                                    <div class="comparison__parameterRow">Значение параметра<span class="comparison__parameterName">Параметр</span></div>
                                                </div>
                                                <div class="swiper-slide compareParametersSlider__slide">
                                                    <div class="comparison__parameterRow">Значение параметра<span class="comparison__parameterName">Параметр</span></div>
                                                    <div class="comparison__parameterRow">Значение параметра<span class="comparison__parameterName">Параметр</span></div>
                                                    <div class="comparison__parameterRow">Значение параметра<span class="comparison__parameterName">Параметр</span></div>
                                                    <div class="comparison__parameterRow">Значение параметра<span class="comparison__parameterName">Параметр</span></div>
                                                    <div class="comparison__parameterRow">Значение параметра<span class="comparison__parameterName">Параметр</span></div>
                                                    <div class="comparison__parameterRow">Значение параметра<span class="comparison__parameterName">Параметр</span></div>
                                                    <div class="comparison__parameterRow">Значение параметра<span class="comparison__parameterName">Параметр</span></div>
                                                    <div class="comparison__parameterRow">Значение параметра<span class="comparison__parameterName">Параметр</span></div>
                                                    <div class="comparison__parameterRow">Значение параметра<span class="comparison__parameterName">Параметр</span></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="comparison__back"><a class="comparison__backBtn btn" href="#">Назад к товарам</a></div>
                    </div>
                    <div class="comparison__tabBlock" data-tabblock="Категория товаров 2">
                        <div class="comparison__cards">
                            <div class="comparisonGrid">
                                <div class="comparisonGrid__col comparisonGrid__col--left">
                                    <div class="comparison__infoCompare">
                                        <div class="comparison__categoryName">Категория товаров 2</div>
                                        <div class="comparison__delAll btn" role="button" tabindex="0">Удалить все</div>
                                    </div>
                                </div>
                                <div class="comparisonGrid__col comparisonGrid__col--right">
                                    <div class="compareSlider__btn" role="button">
                                        <svg>
                                            <use xlink:href="{{ asset('img/sprites/sprite-mono.svg#slideArrow') }}"></use>
                                        </svg>
                                    </div>
                                    <div class="wrp-compareSlider">
                                        <div class="swiper-container compareSlider _swiper">
                                            <div class="swiper-wrapper compareSlider__wrapper">
                                                <div class="swiper-slide itemsSlider__slide">
                                                    <div class="card comparison__card">
                                                        <div class="card__imgWrp"><a class="card__imgBox ibg" href="#">
                                                                <picture>
                                                                    <source type="image/webp" srcset="./img/productsLayout//p4.webp">
                                                                    <img src="./img/productsLayout//p4.jpg" alt="p4">
                                                                </picture></a>
                                                            <div class="card__delete" role="button">
                                                                <svg>
                                                                    <use xlink:href="{{ asset('img/sprites/sprite-mono.svg#cancel') }}"></use>
                                                                </svg>
                                                            </div>
                                                        </div>
                                                        <div class="card__title"><a class="link" href="">Металлочерепица</a></div>
                                                        <ul class="card__chars">
                                                            <li class="card__char">Цвет: 1014 Слоновая кость</li>
                                                            <li class="card__char">Покрытие: Полиэстер </li>
                                                            <li class="card__char">Толщина, мм: 0.4</li>
                                                        </ul>
                                                        <div class="card__price">667 ₽/м2</div>
                                                        <div class="card__controllers">
                                                            <div class="card__btn btn" role="button" tabindex="0">Подробнее</div>
                                                            <div class="card__icons">
                                                                <div class="card__icon card__icon--like" role="button" tabindex="0">
                                                                    <svg>
                                                                        <use xlink:href="{{ asset('img/sprites/sprite-mono.svg#heart') }}"></use>
                                                                    </svg>
                                                                </div>
                                                                <div class="card__icon card__icon--stat" role="button" tabindex="0">
                                                                    <svg>
                                                                        <use xlink:href="{{ asset('img/sprites/sprite-mono.svg#stat') }}"></use>
                                                                    </svg>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="swiper-slide itemsSlider__slide">
                                                    <div class="card comparison__card">
                                                        <div class="card__imgWrp"><a class="card__imgBox ibg" href="#">
                                                                <picture>
                                                                    <source type="image/webp" srcset="./img/productsLayout//p4.webp"><img src="./img/productsLayout//p4.jpg" alt="p4">
                                                                </picture></a>
                                                            <div class="card__delete" role="button">
                                                                <svg>
                                                                    <use xlink:href="{{ asset('img/sprites/sprite-mono.svg#cancel') }}"></use>
                                                                </svg>
                                                            </div>
                                                        </div>
                                                        <div class="card__title"><a class="link" href="">Металлочерепица</a></div>
                                                        <ul class="card__chars">
                                                            <li class="card__char">Цвет: 1014 Слоновая кость</li>
                                                            <li class="card__char">Покрытие: Полиэстер </li>
                                                            <li class="card__char">Толщина, мм: 0.4</li>
                                                        </ul>
                                                        <div class="card__price">667 ₽/м2</div>
                                                        <div class="card__controllers">
                                                            <div class="card__btn btn" role="button" tabindex="0">Подробнее</div>
                                                            <div class="card__icons">
                                                                <div class="card__icon card__icon--like" role="button" tabindex="0">
                                                                    <svg class="_checked">
                                                                        <use xlink:href="{{ asset('img/sprites/sprite-mono.svg#heart') }}"></use>
                                                                    </svg>
                                                                </div>
                                                                <div class="card__icon card__icon--stat" role="button" tabindex="0">
                                                                    <svg class="_checked">
                                                                        <use xlink:href="{{ asset('img/sprites/sprite-mono.svg#stat') }}"></use>
                                                                    </svg>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="swiper-slide itemsSlider__slide">
                                                    <div class="card comparison__card">
                                                        <div class="card__imgWrp"><a class="card__imgBox ibg" href="#">
                                                                <picture>
                                                                    <source type="image/webp" srcset="./img/productsLayout//p4.webp"><img src="./img/productsLayout//p4.jpg" alt="p4">
                                                                </picture></a>
                                                            <div class="card__delete" role="button">
                                                                <svg>
                                                                    <use xlink:href="{{ asset('img/sprites/sprite-mono.svg#cancel') }}"></use>
                                                                </svg>
                                                            </div>
                                                        </div>
                                                        <div class="card__title"><a class="link" href="">Металлочерепица</a></div>
                                                        <ul class="card__chars">
                                                            <li class="card__char">Цвет: 1014 Слоновая кость</li>
                                                            <li class="card__char">Покрытие: Полиэстер </li>
                                                            <li class="card__char">Толщина, мм: 0.4</li>
                                                        </ul>
                                                        <div class="card__price">667 ₽/м2</div>
                                                        <div class="card__controllers">
                                                            <div class="card__btn btn" role="button" tabindex="0">Подробнее</div>
                                                            <div class="card__icons">
                                                                <div class="card__icon card__icon--like" role="button" tabindex="0">
                                                                    <svg>
                                                                        <use xlink:href="{{ asset('img/sprites/sprite-mono.svg#heart') }}"></use>
                                                                    </svg>
                                                                </div>
                                                                <div class="card__icon card__icon--stat" role="button" tabindex="0">
                                                                    <svg>
                                                                        <use xlink:href="{{ asset('img/sprites/sprite-mono.svg#stat') }}"></use>
                                                                    </svg>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="swiper-slide itemsSlider__slide">
                                                    <div class="card comparison__card">
                                                        <div class="card__imgWrp"><a class="card__imgBox ibg" href="#">
                                                                <picture>
                                                                    <source type="image/webp" srcset="./img/productsLayout//p4.webp"><img src="./img/productsLayout//p4.jpg" alt="p4">
                                                                </picture></a>
                                                            <div class="card__delete" role="button">
                                                                <svg>
                                                                    <use xlink:href="{{ asset('img/sprites/sprite-mono.svg#cancel') }}"></use>
                                                                </svg>
                                                            </div>
                                                        </div>
                                                        <div class="card__title"><a class="link" href="">Металлочерепица</a></div>
                                                        <ul class="card__chars">
                                                            <li class="card__char">Цвет: 1014 Слоновая кость</li>
                                                            <li class="card__char">Покрытие: Полиэстер </li>
                                                            <li class="card__char">Толщина, мм: 0.4</li>
                                                        </ul>
                                                        <div class="card__price">667 ₽/м2</div>
                                                        <div class="card__controllers">
                                                            <div class="card__btn btn" role="button" tabindex="0">Подробнее</div>
                                                            <div class="card__icons">
                                                                <div class="card__icon card__icon--like" role="button" tabindex="0">
                                                                    <svg>
                                                                        <use xlink:href="{{ asset('img/sprites/sprite-mono.svg#heart') }}"></use>
                                                                    </svg>
                                                                </div>
                                                                <div class="card__icon card__icon--stat" role="button" tabindex="0">
                                                                    <svg>
                                                                        <use xlink:href="{{ asset('img/sprites/sprite-mono.svg#stat') }}"></use>
                                                                    </svg>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="swiper-slide itemsSlider__slide">
                                                    <div class="card comparison__card">
                                                        <div class="card__imgWrp"><a class="card__imgBox ibg" href="#">
                                                                <picture>
                                                                    <source type="image/webp" srcset="./img/productsLayout//p4.webp"><img src="./img/productsLayout//p4.jpg" alt="p4">
                                                                </picture></a>
                                                            <div class="card__delete" role="button">
                                                                <svg>
                                                                    <use xlink:href="{{ asset('img/sprites/sprite-mono.svg#cancel') }}"></use>
                                                                </svg>
                                                            </div>
                                                        </div>
                                                        <div class="card__title"><a class="link" href="">Металлочерепица</a></div>
                                                        <ul class="card__chars">
                                                            <li class="card__char">Цвет: 1014 Слоновая кость</li>
                                                            <li class="card__char">Покрытие: Полиэстер </li>
                                                            <li class="card__char">Толщина, мм: 0.4</li>
                                                        </ul>
                                                        <div class="card__price">667 ₽/м2</div>
                                                        <div class="card__controllers">
                                                            <div class="card__btn btn" role="button" tabindex="0">Подробнее</div>
                                                            <div class="card__icons">
                                                                <div class="card__icon card__icon--like" role="button" tabindex="0">
                                                                    <svg>
                                                                        <use xlink:href="{{ asset('img/sprites/sprite-mono.svg#heart') }}"></use>
                                                                    </svg>
                                                                </div>
                                                                <div class="card__icon card__icon--stat" role="button" tabindex="0">
                                                                    <svg>
                                                                        <use xlink:href="{{ asset('img/sprites/sprite-mono.svg#stat') }}"></use>
                                                                    </svg>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="comparison__parameters">
                            <div class="comparison__settings">
                                <div class="checkbox">
                                    <input class="checkbox__input" id="chkbox" autocomplete="off" type="checkbox" name="form[]">
                                    <label class="checkbox__label link" for="chkbox">Показывать только различия </label>
                                </div>
                            </div>
                            <div class="comparisonGrid">
                                <div class="comparisonGrid__col comparisonGrid__col--left">
                                    <div class="comparison__parameterRow comparison__parameterRow--name bold">Параметр</div>
                                    <div class="comparison__parameterRow comparison__parameterRow--name bold">Параметр</div>
                                    <div class="comparison__parameterRow comparison__parameterRow--name bold">Параметр</div>
                                    <div class="comparison__parameterRow comparison__parameterRow--name bold">Параметр</div>
                                    <div class="comparison__parameterRow comparison__parameterRow--name bold">Параметр</div>
                                    <div class="comparison__parameterRow comparison__parameterRow--name bold">Параметр</div>
                                    <div class="comparison__parameterRow comparison__parameterRow--name bold">Параметр</div>
                                    <div class="comparison__parameterRow comparison__parameterRow--name bold">Параметр</div>
                                    <div class="comparison__parameterRow comparison__parameterRow--name bold">Параметр</div>
                                </div>
                                <div class="comparisonGrid__col comparisonGrid__col--right">
                                    <div class="wrp-compareParametersSlider">
                                        <div class="swiper-container compareParametersSlider _swiper">
                                            <div class="swiper-wrapper compareParametersSlider__wrapper">
                                                <div class="swiper-slide compareParametersSlider__slide">
                                                    <div class="comparison__parameterRow">Значение параметра<span class="comparison__parameterName">Параметр</span></div>
                                                    <div class="comparison__parameterRow">Значение параметра<span class="comparison__parameterName">Параметр</span></div>
                                                    <div class="comparison__parameterRow">Значение параметра<span class="comparison__parameterName">Параметр</span></div>
                                                    <div class="comparison__parameterRow">Значение параметра<span class="comparison__parameterName">Параметр</span></div>
                                                    <div class="comparison__parameterRow">Значение параметра<span class="comparison__parameterName">Параметр</span></div>
                                                    <div class="comparison__parameterRow">Значение параметра<span class="comparison__parameterName">Параметр</span></div>
                                                    <div class="comparison__parameterRow">Значение параметра<span class="comparison__parameterName">Параметр</span></div>
                                                    <div class="comparison__parameterRow">Значение параметра<span class="comparison__parameterName">Параметр</span></div>
                                                    <div class="comparison__parameterRow">Значение параметра<span class="comparison__parameterName">Параметр</span></div>
                                                </div>
                                                <div class="swiper-slide compareParametersSlider__slide">
                                                    <div class="comparison__parameterRow">Значение параметра<span class="comparison__parameterName">Параметр</span></div>
                                                    <div class="comparison__parameterRow">Значение параметра<span class="comparison__parameterName">Параметр</span></div>
                                                    <div class="comparison__parameterRow">Значение параметра<span class="comparison__parameterName">Параметр</span></div>
                                                    <div class="comparison__parameterRow">Значение параметра<span class="comparison__parameterName">Параметр</span></div>
                                                    <div class="comparison__parameterRow">Значение параметра<span class="comparison__parameterName">Параметр</span></div>
                                                    <div class="comparison__parameterRow">Значение параметра<span class="comparison__parameterName">Параметр</span></div>
                                                    <div class="comparison__parameterRow">Значение параметра<span class="comparison__parameterName">Параметр</span></div>
                                                    <div class="comparison__parameterRow">Значение параметра<span class="comparison__parameterName">Параметр</span></div>
                                                    <div class="comparison__parameterRow">Значение параметра<span class="comparison__parameterName">Параметр</span></div>
                                                </div>
                                                <div class="swiper-slide compareParametersSlider__slide">
                                                    <div class="comparison__parameterRow">Значение параметра<span class="comparison__parameterName">Параметр</span></div>
                                                    <div class="comparison__parameterRow">Значение параметра<span class="comparison__parameterName">Параметр</span></div>
                                                    <div class="comparison__parameterRow">Значение параметра<span class="comparison__parameterName">Параметр</span></div>
                                                    <div class="comparison__parameterRow">Значение параметра<span class="comparison__parameterName">Параметр</span></div>
                                                    <div class="comparison__parameterRow">Значение параметра<span class="comparison__parameterName">Параметр</span></div>
                                                    <div class="comparison__parameterRow">Значение параметра<span class="comparison__parameterName">Параметр</span></div>
                                                    <div class="comparison__parameterRow">Значение параметра<span class="comparison__parameterName">Параметр</span></div>
                                                    <div class="comparison__parameterRow">Значение параметра<span class="comparison__parameterName">Параметр</span></div>
                                                    <div class="comparison__parameterRow">Значение параметра<span class="comparison__parameterName">Параметр</span></div>
                                                </div>
                                                <div class="swiper-slide compareParametersSlider__slide">
                                                    <div class="comparison__parameterRow">Значение параметра<span class="comparison__parameterName">Параметр</span></div>
                                                    <div class="comparison__parameterRow">Значение параметра<span class="comparison__parameterName">Параметр</span></div>
                                                    <div class="comparison__parameterRow">Значение параметра<span class="comparison__parameterName">Параметр</span></div>
                                                    <div class="comparison__parameterRow">Значение параметра<span class="comparison__parameterName">Параметр</span></div>
                                                    <div class="comparison__parameterRow">Значение параметра<span class="comparison__parameterName">Параметр</span></div>
                                                    <div class="comparison__parameterRow">Значение параметра<span class="comparison__parameterName">Параметр</span></div>
                                                    <div class="comparison__parameterRow">Значение параметра<span class="comparison__parameterName">Параметр</span></div>
                                                    <div class="comparison__parameterRow">Значение параметра<span class="comparison__parameterName">Параметр</span></div>
                                                    <div class="comparison__parameterRow">Значение параметра<span class="comparison__parameterName">Параметр</span></div>
                                                </div>
                                                <div class="swiper-slide compareParametersSlider__slide">
                                                    <div class="comparison__parameterRow">Значение параметра<span class="comparison__parameterName">Параметр</span></div>
                                                    <div class="comparison__parameterRow">Значение параметра<span class="comparison__parameterName">Параметр</span></div>
                                                    <div class="comparison__parameterRow">Значение параметра<span class="comparison__parameterName">Параметр</span></div>
                                                    <div class="comparison__parameterRow">Значение параметра<span class="comparison__parameterName">Параметр</span></div>
                                                    <div class="comparison__parameterRow">Значение параметра<span class="comparison__parameterName">Параметр</span></div>
                                                    <div class="comparison__parameterRow">Значение параметра<span class="comparison__parameterName">Параметр</span></div>
                                                    <div class="comparison__parameterRow">Значение параметра<span class="comparison__parameterName">Параметр</span></div>
                                                    <div class="comparison__parameterRow">Значение параметра<span class="comparison__parameterName">Параметр</span></div>
                                                    <div class="comparison__parameterRow">Значение параметра<span class="comparison__parameterName">Параметр</span></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="comparison__back"><a class="comparison__backBtn btn" href="#">Назад к товарам</a></div>
                    </div>
                    <div class="comparison__tabBlock" data-tabblock="Категория товаров 3">
                        <div class="comparison__cards">
                            <div class="comparisonGrid">
                                <div class="comparisonGrid__col comparisonGrid__col--left">
                                    <div class="comparison__infoCompare">
                                        <div class="comparison__categoryName">Категория товаров 3</div>
                                        <div class="comparison__delAll btn" role="button" tabindex="0">Удалить все</div>
                                    </div>
                                </div>
                                <div class="comparisonGrid__col comparisonGrid__col--right">
                                    <div class="compareSlider__btn" role="button">
                                        <svg>
                                            <use xlink:href="{{ asset('img/sprites/sprite-mono.svg#slideArrow') }}"></use>
                                        </svg>
                                    </div>
                                    <div class="wrp-compareSlider">
                                        <div class="swiper-container compareSlider _swiper">
                                            <div class="swiper-wrapper compareSlider__wrapper">
                                                <div class="swiper-slide itemsSlider__slide">
                                                    <div class="card comparison__card">
                                                        <div class="card__imgWrp"><a class="card__imgBox ibg" href="#">
                                                                <picture>
                                                                    <source type="image/webp" srcset="./img/productsLayout//p4.webp"><img src="./img/productsLayout//p4.jpg" alt="p4">
                                                                </picture></a>
                                                            <div class="card__delete" role="button">
                                                                <svg>
                                                                    <use xlink:href="{{ asset('img/sprites/sprite-mono.svg#cancel') }}"></use>
                                                                </svg>
                                                            </div>
                                                        </div>
                                                        <div class="card__title"><a class="link" href="">Металлочерепица</a></div>
                                                        <ul class="card__chars">
                                                            <li class="card__char">Цвет: 1014 Слоновая кость</li>
                                                            <li class="card__char">Покрытие: Полиэстер </li>
                                                            <li class="card__char">Толщина, мм: 0.4</li>
                                                        </ul>
                                                        <div class="card__price">667 ₽/м2</div>
                                                        <div class="card__controllers">
                                                            <div class="card__btn btn" role="button" tabindex="0">Подробнее</div>
                                                            <div class="card__icons">
                                                                <div class="card__icon card__icon--like" role="button" tabindex="0">
                                                                    <svg>
                                                                        <use xlink:href="{{ asset('img/sprites/sprite-mono.svg#heart') }}"></use>
                                                                    </svg>
                                                                </div>
                                                                <div class="card__icon card__icon--stat" role="button" tabindex="0">
                                                                    <svg>
                                                                        <use xlink:href="{{ asset('img/sprites/sprite-mono.svg#stat') }}"></use>
                                                                    </svg>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="swiper-slide itemsSlider__slide">
                                                    <div class="card comparison__card">
                                                        <div class="card__imgWrp"><a class="card__imgBox ibg" href="#">
                                                                <picture>
                                                                    <source type="image/webp" srcset="./img/productsLayout//p4.webp"><img src="./img/productsLayout//p4.jpg" alt="p4">
                                                                </picture></a>
                                                            <div class="card__delete" role="button">
                                                                <svg>
                                                                    <use xlink:href="{{ asset('img/sprites/sprite-mono.svg#cancel') }}"></use>
                                                                </svg>
                                                            </div>
                                                        </div>
                                                        <div class="card__title"><a class="link" href="">Металлочерепица</a></div>
                                                        <ul class="card__chars">
                                                            <li class="card__char">Цвет: 1014 Слоновая кость</li>
                                                            <li class="card__char">Покрытие: Полиэстер </li>
                                                            <li class="card__char">Толщина, мм: 0.4</li>
                                                        </ul>
                                                        <div class="card__price">667 ₽/м2</div>
                                                        <div class="card__controllers">
                                                            <div class="card__btn btn" role="button" tabindex="0">Подробнее</div>
                                                            <div class="card__icons">
                                                                <div class="card__icon card__icon--like" role="button" tabindex="0">
                                                                    <svg class="_checked">
                                                                        <use xlink:href="{{ asset('img/sprites/sprite-mono.svg#heart') }}"></use>
                                                                    </svg>
                                                                </div>
                                                                <div class="card__icon card__icon--stat" role="button" tabindex="0">
                                                                    <svg class="_checked">
                                                                        <use xlink:href="{{ asset('img/sprites/sprite-mono.svg#stat') }}"></use>
                                                                    </svg>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="swiper-slide itemsSlider__slide">
                                                    <div class="card comparison__card">
                                                        <div class="card__imgWrp"><a class="card__imgBox ibg" href="#">
                                                                <picture>
                                                                    <source type="image/webp" srcset="./img/productsLayout//p4.webp"><img src="./img/productsLayout//p4.jpg" alt="p4">
                                                                </picture></a>
                                                            <div class="card__delete" role="button">
                                                                <svg>
                                                                    <use xlink:href="{{ asset('img/sprites/sprite-mono.svg#cancel') }}"></use>
                                                                </svg>
                                                            </div>
                                                        </div>
                                                        <div class="card__title"><a class="link" href="">Металлочерепица</a></div>
                                                        <ul class="card__chars">
                                                            <li class="card__char">Цвет: 1014 Слоновая кость</li>
                                                            <li class="card__char">Покрытие: Полиэстер </li>
                                                            <li class="card__char">Толщина, мм: 0.4</li>
                                                        </ul>
                                                        <div class="card__price">667 ₽/м2</div>
                                                        <div class="card__controllers">
                                                            <div class="card__btn btn" role="button" tabindex="0">Подробнее</div>
                                                            <div class="card__icons">
                                                                <div class="card__icon card__icon--like" role="button" tabindex="0">
                                                                    <svg>
                                                                        <use xlink:href="{{ asset('img/sprites/sprite-mono.svg#heart') }}"></use>
                                                                    </svg>
                                                                </div>
                                                                <div class="card__icon card__icon--stat" role="button" tabindex="0">
                                                                    <svg>
                                                                        <use xlink:href="{{ asset('img/sprites/sprite-mono.svg#stat') }}"></use>
                                                                    </svg>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="swiper-slide itemsSlider__slide">
                                                    <div class="card comparison__card">
                                                        <div class="card__imgWrp"><a class="card__imgBox ibg" href="#">
                                                                <picture>
                                                                    <source type="image/webp" srcset="./img/productsLayout//p4.webp"><img src="./img/productsLayout//p4.jpg" alt="p4">
                                                                </picture></a>
                                                            <div class="card__delete" role="button">
                                                                <svg>
                                                                    <use xlink:href="{{ asset('img/sprites/sprite-mono.svg#cancel') }}"></use>
                                                                </svg>
                                                            </div>
                                                        </div>
                                                        <div class="card__title"><a class="link" href="">Металлочерепица</a></div>
                                                        <ul class="card__chars">
                                                            <li class="card__char">Цвет: 1014 Слоновая кость</li>
                                                            <li class="card__char">Покрытие: Полиэстер </li>
                                                            <li class="card__char">Толщина, мм: 0.4</li>
                                                        </ul>
                                                        <div class="card__price">667 ₽/м2</div>
                                                        <div class="card__controllers">
                                                            <div class="card__btn btn" role="button" tabindex="0">Подробнее</div>
                                                            <div class="card__icons">
                                                                <div class="card__icon card__icon--like" role="button" tabindex="0">
                                                                    <svg>
                                                                        <use xlink:href="{{ asset('img/sprites/sprite-mono.svg#heart') }}"></use>
                                                                    </svg>
                                                                </div>
                                                                <div class="card__icon card__icon--stat" role="button" tabindex="0">
                                                                    <svg>
                                                                        <use xlink:href="{{ asset('img/sprites/sprite-mono.svg#stat') }}"></use>
                                                                    </svg>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="swiper-slide itemsSlider__slide">
                                                    <div class="card comparison__card">
                                                        <div class="card__imgWrp"><a class="card__imgBox ibg" href="#">
                                                                <picture>
                                                                    <source type="image/webp" srcset="./img/productsLayout//p4.webp"><img src="./img/productsLayout//p4.jpg" alt="p4">
                                                                </picture></a>
                                                            <div class="card__delete" role="button">
                                                                <svg>
                                                                    <use xlink:href="{{ asset('img/sprites/sprite-mono.svg#cancel') }}"></use>
                                                                </svg>
                                                            </div>
                                                        </div>
                                                        <div class="card__title"><a class="link" href="">Металлочерепица</a></div>
                                                        <ul class="card__chars">
                                                            <li class="card__char">Цвет: 1014 Слоновая кость</li>
                                                            <li class="card__char">Покрытие: Полиэстер </li>
                                                            <li class="card__char">Толщина, мм: 0.4</li>
                                                        </ul>
                                                        <div class="card__price">667 ₽/м2</div>
                                                        <div class="card__controllers">
                                                            <div class="card__btn btn" role="button" tabindex="0">Подробнее</div>
                                                            <div class="card__icons">
                                                                <div class="card__icon card__icon--like" role="button" tabindex="0">
                                                                    <svg>
                                                                        <use xlink:href="{{ asset('img/sprites/sprite-mono.svg#heart') }}"></use>
                                                                    </svg>
                                                                </div>
                                                                <div class="card__icon card__icon--stat" role="button" tabindex="0">
                                                                    <svg>
                                                                        <use xlink:href="{{ asset('img/sprites/sprite-mono.svg#stat') }}"></use>
                                                                    </svg>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="comparison__parameters">
                            <div class="comparison__settings">
                                <div class="checkbox">
                                    <input class="checkbox__input" id="chkbox" autocomplete="off" type="checkbox" name="form[]">
                                    <label class="checkbox__label link" for="chkbox">Показывать только различия </label>
                                </div>
                            </div>
                            <div class="comparisonGrid">
                                <div class="comparisonGrid__col comparisonGrid__col--left">
                                    <div class="comparison__parameterRow comparison__parameterRow--name bold">Параметр</div>
                                    <div class="comparison__parameterRow comparison__parameterRow--name bold">Параметр</div>
                                    <div class="comparison__parameterRow comparison__parameterRow--name bold">Параметр</div>
                                    <div class="comparison__parameterRow comparison__parameterRow--name bold">Параметр</div>
                                    <div class="comparison__parameterRow comparison__parameterRow--name bold">Параметр</div>
                                    <div class="comparison__parameterRow comparison__parameterRow--name bold">Параметр</div>
                                    <div class="comparison__parameterRow comparison__parameterRow--name bold">Параметр</div>
                                    <div class="comparison__parameterRow comparison__parameterRow--name bold">Параметр</div>
                                    <div class="comparison__parameterRow comparison__parameterRow--name bold">Параметр</div>
                                </div>
                                <div class="comparisonGrid__col comparisonGrid__col--right">
                                    <div class="wrp-compareParametersSlider">
                                        <div class="swiper-container compareParametersSlider _swiper">
                                            <div class="swiper-wrapper compareParametersSlider__wrapper">
                                                <div class="swiper-slide compareParametersSlider__slide">
                                                    <div class="comparison__parameterRow">Значение параметра<span class="comparison__parameterName">Параметр</span></div>
                                                    <div class="comparison__parameterRow">Значение параметра<span class="comparison__parameterName">Параметр</span></div>
                                                    <div class="comparison__parameterRow">Значение параметра<span class="comparison__parameterName">Параметр</span></div>
                                                    <div class="comparison__parameterRow">Значение параметра<span class="comparison__parameterName">Параметр</span></div>
                                                    <div class="comparison__parameterRow">Значение параметра<span class="comparison__parameterName">Параметр</span></div>
                                                    <div class="comparison__parameterRow">Значение параметра<span class="comparison__parameterName">Параметр</span></div>
                                                    <div class="comparison__parameterRow">Значение параметра<span class="comparison__parameterName">Параметр</span></div>
                                                    <div class="comparison__parameterRow">Значение параметра<span class="comparison__parameterName">Параметр</span></div>
                                                    <div class="comparison__parameterRow">Значение параметра<span class="comparison__parameterName">Параметр</span></div>
                                                </div>
                                                <div class="swiper-slide compareParametersSlider__slide">
                                                    <div class="comparison__parameterRow">Значение параметра<span class="comparison__parameterName">Параметр</span></div>
                                                    <div class="comparison__parameterRow">Значение параметра<span class="comparison__parameterName">Параметр</span></div>
                                                    <div class="comparison__parameterRow">Значение параметра<span class="comparison__parameterName">Параметр</span></div>
                                                    <div class="comparison__parameterRow">Значение параметра<span class="comparison__parameterName">Параметр</span></div>
                                                    <div class="comparison__parameterRow">Значение параметра<span class="comparison__parameterName">Параметр</span></div>
                                                    <div class="comparison__parameterRow">Значение параметра<span class="comparison__parameterName">Параметр</span></div>
                                                    <div class="comparison__parameterRow">Значение параметра<span class="comparison__parameterName">Параметр</span></div>
                                                    <div class="comparison__parameterRow">Значение параметра<span class="comparison__parameterName">Параметр</span></div>
                                                    <div class="comparison__parameterRow">Значение параметра<span class="comparison__parameterName">Параметр</span></div>
                                                </div>
                                                <div class="swiper-slide compareParametersSlider__slide">
                                                    <div class="comparison__parameterRow">Значение параметра<span class="comparison__parameterName">Параметр</span></div>
                                                    <div class="comparison__parameterRow">Значение параметра<span class="comparison__parameterName">Параметр</span></div>
                                                    <div class="comparison__parameterRow">Значение параметра<span class="comparison__parameterName">Параметр</span></div>
                                                    <div class="comparison__parameterRow">Значение параметра<span class="comparison__parameterName">Параметр</span></div>
                                                    <div class="comparison__parameterRow">Значение параметра<span class="comparison__parameterName">Параметр</span></div>
                                                    <div class="comparison__parameterRow">Значение параметра<span class="comparison__parameterName">Параметр</span></div>
                                                    <div class="comparison__parameterRow">Значение параметра<span class="comparison__parameterName">Параметр</span></div>
                                                    <div class="comparison__parameterRow">Значение параметра<span class="comparison__parameterName">Параметр</span></div>
                                                    <div class="comparison__parameterRow">Значение параметра<span class="comparison__parameterName">Параметр</span></div>
                                                </div>
                                                <div class="swiper-slide compareParametersSlider__slide">
                                                    <div class="comparison__parameterRow">Значение параметра<span class="comparison__parameterName">Параметр</span></div>
                                                    <div class="comparison__parameterRow">Значение параметра<span class="comparison__parameterName">Параметр</span></div>
                                                    <div class="comparison__parameterRow">Значение параметра<span class="comparison__parameterName">Параметр</span></div>
                                                    <div class="comparison__parameterRow">Значение параметра<span class="comparison__parameterName">Параметр</span></div>
                                                    <div class="comparison__parameterRow">Значение параметра<span class="comparison__parameterName">Параметр</span></div>
                                                    <div class="comparison__parameterRow">Значение параметра<span class="comparison__parameterName">Параметр</span></div>
                                                    <div class="comparison__parameterRow">Значение параметра<span class="comparison__parameterName">Параметр</span></div>
                                                    <div class="comparison__parameterRow">Значение параметра<span class="comparison__parameterName">Параметр</span></div>
                                                    <div class="comparison__parameterRow">Значение параметра<span class="comparison__parameterName">Параметр</span></div>
                                                </div>
                                                <div class="swiper-slide compareParametersSlider__slide">
                                                    <div class="comparison__parameterRow">Значение параметра<span class="comparison__parameterName">Параметр</span></div>
                                                    <div class="comparison__parameterRow">Значение параметра<span class="comparison__parameterName">Параметр</span></div>
                                                    <div class="comparison__parameterRow">Значение параметра<span class="comparison__parameterName">Параметр</span></div>
                                                    <div class="comparison__parameterRow">Значение параметра<span class="comparison__parameterName">Параметр</span></div>
                                                    <div class="comparison__parameterRow">Значение параметра<span class="comparison__parameterName">Параметр</span></div>
                                                    <div class="comparison__parameterRow">Значение параметра<span class="comparison__parameterName">Параметр</span></div>
                                                    <div class="comparison__parameterRow">Значение параметра<span class="comparison__parameterName">Параметр</span></div>
                                                    <div class="comparison__parameterRow">Значение параметра<span class="comparison__parameterName">Параметр</span></div>
                                                    <div class="comparison__parameterRow">Значение параметра<span class="comparison__parameterName">Параметр</span></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="comparison__back"><a class="comparison__backBtn btn" href="#">Назад к товарам</a></div>
                    </div>
                    <div class="comparison__tabBlock" data-tabblock="Категория товаров 4">
                        <div class="comparison__cards">
                            <div class="comparisonGrid">
                                <div class="comparisonGrid__col comparisonGrid__col--left">
                                    <div class="comparison__infoCompare">
                                        <div class="comparison__categoryName">Категория товаров 4</div>
                                        <div class="comparison__delAll btn" role="button" tabindex="0">Удалить все</div>
                                    </div>
                                </div>
                                <div class="comparisonGrid__col comparisonGrid__col--right">
                                    <div class="compareSlider__btn" role="button">
                                        <svg>
                                            <use xlink:href="{{ asset('img/sprites/sprite-mono.svg#slideArrow') }}"></use>
                                        </svg>
                                    </div>
                                    <div class="wrp-compareSlider">
                                        <div class="swiper-container compareSlider _swiper">
                                            <div class="swiper-wrapper compareSlider__wrapper">
                                                <div class="swiper-slide itemsSlider__slide">
                                                    <div class="card comparison__card">
                                                        <div class="card__imgWrp"><a class="card__imgBox ibg" href="#">
                                                                <picture>
                                                                    <source type="image/webp" srcset="./img/productsLayout//p4.webp"><img src="./img/productsLayout//p4.jpg" alt="p4">
                                                                </picture></a>
                                                            <div class="card__delete" role="button">
                                                                <svg>
                                                                    <use xlink:href="{{ asset('img/sprites/sprite-mono.svg#cancel') }}"></use>
                                                                </svg>
                                                            </div>
                                                        </div>
                                                        <div class="card__title"><a class="link" href="">Металлочерепица</a></div>
                                                        <ul class="card__chars">
                                                            <li class="card__char">Цвет: 1014 Слоновая кость</li>
                                                            <li class="card__char">Покрытие: Полиэстер </li>
                                                            <li class="card__char">Толщина, мм: 0.4</li>
                                                        </ul>
                                                        <div class="card__price">667 ₽/м2</div>
                                                        <div class="card__controllers">
                                                            <div class="card__btn btn" role="button" tabindex="0">Подробнее</div>
                                                            <div class="card__icons">
                                                                <div class="card__icon card__icon--like" role="button" tabindex="0">
                                                                    <svg>
                                                                        <use xlink:href="{{ asset('img/sprites/sprite-mono.svg#heart') }}"></use>
                                                                    </svg>
                                                                </div>
                                                                <div class="card__icon card__icon--stat" role="button" tabindex="0">
                                                                    <svg>
                                                                        <use xlink:href="{{ asset('img/sprites/sprite-mono.svg#stat') }}"></use>
                                                                    </svg>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="swiper-slide itemsSlider__slide">
                                                    <div class="card comparison__card">
                                                        <div class="card__imgWrp"><a class="card__imgBox ibg" href="#">
                                                                <picture>
                                                                    <source type="image/webp" srcset="./img/productsLayout//p4.webp"><img src="./img/productsLayout//p4.jpg" alt="p4">
                                                                </picture></a>
                                                            <div class="card__delete" role="button">
                                                                <svg>
                                                                    <use xlink:href="{{ asset('img/sprites/sprite-mono.svg#cancel') }}"></use>
                                                                </svg>
                                                            </div>
                                                        </div>
                                                        <div class="card__title"><a class="link" href="">Металлочерепица</a></div>
                                                        <ul class="card__chars">
                                                            <li class="card__char">Цвет: 1014 Слоновая кость</li>
                                                            <li class="card__char">Покрытие: Полиэстер </li>
                                                            <li class="card__char">Толщина, мм: 0.4</li>
                                                        </ul>
                                                        <div class="card__price">667 ₽/м2</div>
                                                        <div class="card__controllers">
                                                            <div class="card__btn btn" role="button" tabindex="0">Подробнее</div>
                                                            <div class="card__icons">
                                                                <div class="card__icon card__icon--like" role="button" tabindex="0">
                                                                    <svg class="_checked">
                                                                        <use xlink:href="{{ asset('img/sprites/sprite-mono.svg#heart') }}"></use>
                                                                    </svg>
                                                                </div>
                                                                <div class="card__icon card__icon--stat" role="button" tabindex="0">
                                                                    <svg class="_checked">
                                                                        <use xlink:href="{{ asset('img/sprites/sprite-mono.svg#stat') }}"></use>
                                                                    </svg>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="swiper-slide itemsSlider__slide">
                                                    <div class="card comparison__card">
                                                        <div class="card__imgWrp"><a class="card__imgBox ibg" href="#">
                                                                <picture>
                                                                    <source type="image/webp" srcset="./img/productsLayout//p4.webp"><img src="./img/productsLayout//p4.jpg" alt="p4">
                                                                </picture></a>
                                                            <div class="card__delete" role="button">
                                                                <svg>
                                                                    <use xlink:href="{{ asset('img/sprites/sprite-mono.svg#cancel') }}"></use>
                                                                </svg>
                                                            </div>
                                                        </div>
                                                        <div class="card__title"><a class="link" href="">Металлочерепица</a></div>
                                                        <ul class="card__chars">
                                                            <li class="card__char">Цвет: 1014 Слоновая кость</li>
                                                            <li class="card__char">Покрытие: Полиэстер </li>
                                                            <li class="card__char">Толщина, мм: 0.4</li>
                                                        </ul>
                                                        <div class="card__price">667 ₽/м2</div>
                                                        <div class="card__controllers">
                                                            <div class="card__btn btn" role="button" tabindex="0">Подробнее</div>
                                                            <div class="card__icons">
                                                                <div class="card__icon card__icon--like" role="button" tabindex="0">
                                                                    <svg>
                                                                        <use xlink:href="{{ asset('img/sprites/sprite-mono.svg#heart') }}"></use>
                                                                    </svg>
                                                                </div>
                                                                <div class="card__icon card__icon--stat" role="button" tabindex="0">
                                                                    <svg>
                                                                        <use xlink:href="{{ asset('img/sprites/sprite-mono.svg#stat') }}"></use>
                                                                    </svg>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="swiper-slide itemsSlider__slide">
                                                    <div class="card comparison__card">
                                                        <div class="card__imgWrp"><a class="card__imgBox ibg" href="#">
                                                                <picture>
                                                                    <source type="image/webp" srcset="./img/productsLayout//p4.webp"><img src="./img/productsLayout//p4.jpg" alt="p4">
                                                                </picture></a>
                                                            <div class="card__delete" role="button">
                                                                <svg>
                                                                    <use xlink:href="{{ asset('img/sprites/sprite-mono.svg#cancel') }}"></use>
                                                                </svg>
                                                            </div>
                                                        </div>
                                                        <div class="card__title"><a class="link" href="">Металлочерепица</a></div>
                                                        <ul class="card__chars">
                                                            <li class="card__char">Цвет: 1014 Слоновая кость</li>
                                                            <li class="card__char">Покрытие: Полиэстер </li>
                                                            <li class="card__char">Толщина, мм: 0.4</li>
                                                        </ul>
                                                        <div class="card__price">667 ₽/м2</div>
                                                        <div class="card__controllers">
                                                            <div class="card__btn btn" role="button" tabindex="0">Подробнее</div>
                                                            <div class="card__icons">
                                                                <div class="card__icon card__icon--like" role="button" tabindex="0">
                                                                    <svg>
                                                                        <use xlink:href="{{ asset('img/sprites/sprite-mono.svg#heart') }}"></use>
                                                                    </svg>
                                                                </div>
                                                                <div class="card__icon card__icon--stat" role="button" tabindex="0">
                                                                    <svg>
                                                                        <use xlink:href="{{ asset('img/sprites/sprite-mono.svg#stat') }}"></use>
                                                                    </svg>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="swiper-slide itemsSlider__slide">
                                                    <div class="card comparison__card">
                                                        <div class="card__imgWrp"><a class="card__imgBox ibg" href="#">
                                                                <picture>
                                                                    <source type="image/webp" srcset="./img/productsLayout//p4.webp"><img src="./img/productsLayout//p4.jpg" alt="p4">
                                                                </picture></a>
                                                            <div class="card__delete" role="button">
                                                                <svg>
                                                                    <use xlink:href="{{ asset('img/sprites/sprite-mono.svg#cancel') }}"></use>
                                                                </svg>
                                                            </div>
                                                        </div>
                                                        <div class="card__title"><a class="link" href="">Металлочерепица</a></div>
                                                        <ul class="card__chars">
                                                            <li class="card__char">Цвет: 1014 Слоновая кость</li>
                                                            <li class="card__char">Покрытие: Полиэстер </li>
                                                            <li class="card__char">Толщина, мм: 0.4</li>
                                                        </ul>
                                                        <div class="card__price">667 ₽/м2</div>
                                                        <div class="card__controllers">
                                                            <div class="card__btn btn" role="button" tabindex="0">Подробнее</div>
                                                            <div class="card__icons">
                                                                <div class="card__icon card__icon--like" role="button" tabindex="0">
                                                                    <svg>
                                                                        <use xlink:href="{{ asset('img/sprites/sprite-mono.svg#heart') }}"></use>
                                                                    </svg>
                                                                </div>
                                                                <div class="card__icon card__icon--stat" role="button" tabindex="0">
                                                                    <svg>
                                                                        <use xlink:href="{{ asset('img/sprites/sprite-mono.svg#stat') }}"></use>
                                                                    </svg>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="comparison__parameters">
                            <div class="comparison__settings">
                                <div class="checkbox">
                                    <input class="checkbox__input" id="chkbox" autocomplete="off" type="checkbox" name="form[]">
                                    <label class="checkbox__label link" for="chkbox">Показывать только различия </label>
                                </div>
                            </div>
                            <div class="comparisonGrid">
                                <div class="comparisonGrid__col comparisonGrid__col--left">
                                    <div class="comparison__parameterRow comparison__parameterRow--name bold">Параметр</div>
                                    <div class="comparison__parameterRow comparison__parameterRow--name bold">Параметр</div>
                                    <div class="comparison__parameterRow comparison__parameterRow--name bold">Параметр</div>
                                    <div class="comparison__parameterRow comparison__parameterRow--name bold">Параметр</div>
                                    <div class="comparison__parameterRow comparison__parameterRow--name bold">Параметр</div>
                                    <div class="comparison__parameterRow comparison__parameterRow--name bold">Параметр</div>
                                    <div class="comparison__parameterRow comparison__parameterRow--name bold">Параметр</div>
                                    <div class="comparison__parameterRow comparison__parameterRow--name bold">Параметр</div>
                                    <div class="comparison__parameterRow comparison__parameterRow--name bold">Параметр</div>
                                </div>
                                <div class="comparisonGrid__col comparisonGrid__col--right">
                                    <div class="wrp-compareParametersSlider">
                                        <div class="swiper-container compareParametersSlider _swiper">
                                            <div class="swiper-wrapper compareParametersSlider__wrapper">
                                                <div class="swiper-slide compareParametersSlider__slide">
                                                    <div class="comparison__parameterRow">Значение параметра<span class="comparison__parameterName">Параметр</span></div>
                                                    <div class="comparison__parameterRow">Значение параметра<span class="comparison__parameterName">Параметр</span></div>
                                                    <div class="comparison__parameterRow">Значение параметра<span class="comparison__parameterName">Параметр</span></div>
                                                    <div class="comparison__parameterRow">Значение параметра<span class="comparison__parameterName">Параметр</span></div>
                                                    <div class="comparison__parameterRow">Значение параметра<span class="comparison__parameterName">Параметр</span></div>
                                                    <div class="comparison__parameterRow">Значение параметра<span class="comparison__parameterName">Параметр</span></div>
                                                    <div class="comparison__parameterRow">Значение параметра<span class="comparison__parameterName">Параметр</span></div>
                                                    <div class="comparison__parameterRow">Значение параметра<span class="comparison__parameterName">Параметр</span></div>
                                                    <div class="comparison__parameterRow">Значение параметра<span class="comparison__parameterName">Параметр</span></div>
                                                </div>
                                                <div class="swiper-slide compareParametersSlider__slide">
                                                    <div class="comparison__parameterRow">Значение параметра<span class="comparison__parameterName">Параметр</span></div>
                                                    <div class="comparison__parameterRow">Значение параметра<span class="comparison__parameterName">Параметр</span></div>
                                                    <div class="comparison__parameterRow">Значение параметра<span class="comparison__parameterName">Параметр</span></div>
                                                    <div class="comparison__parameterRow">Значение параметра<span class="comparison__parameterName">Параметр</span></div>
                                                    <div class="comparison__parameterRow">Значение параметра<span class="comparison__parameterName">Параметр</span></div>
                                                    <div class="comparison__parameterRow">Значение параметра<span class="comparison__parameterName">Параметр</span></div>
                                                    <div class="comparison__parameterRow">Значение параметра<span class="comparison__parameterName">Параметр</span></div>
                                                    <div class="comparison__parameterRow">Значение параметра<span class="comparison__parameterName">Параметр</span></div>
                                                    <div class="comparison__parameterRow">Значение параметра<span class="comparison__parameterName">Параметр</span></div>
                                                </div>
                                                <div class="swiper-slide compareParametersSlider__slide">
                                                    <div class="comparison__parameterRow">Значение параметра<span class="comparison__parameterName">Параметр</span></div>
                                                    <div class="comparison__parameterRow">Значение параметра<span class="comparison__parameterName">Параметр</span></div>
                                                    <div class="comparison__parameterRow">Значение параметра<span class="comparison__parameterName">Параметр</span></div>
                                                    <div class="comparison__parameterRow">Значение параметра<span class="comparison__parameterName">Параметр</span></div>
                                                    <div class="comparison__parameterRow">Значение параметра<span class="comparison__parameterName">Параметр</span></div>
                                                    <div class="comparison__parameterRow">Значение параметра<span class="comparison__parameterName">Параметр</span></div>
                                                    <div class="comparison__parameterRow">Значение параметра<span class="comparison__parameterName">Параметр</span></div>
                                                    <div class="comparison__parameterRow">Значение параметра<span class="comparison__parameterName">Параметр</span></div>
                                                    <div class="comparison__parameterRow">Значение параметра<span class="comparison__parameterName">Параметр</span></div>
                                                </div>
                                                <div class="swiper-slide compareParametersSlider__slide">
                                                    <div class="comparison__parameterRow">Значение параметра<span class="comparison__parameterName">Параметр</span></div>
                                                    <div class="comparison__parameterRow">Значение параметра<span class="comparison__parameterName">Параметр</span></div>
                                                    <div class="comparison__parameterRow">Значение параметра<span class="comparison__parameterName">Параметр</span></div>
                                                    <div class="comparison__parameterRow">Значение параметра<span class="comparison__parameterName">Параметр</span></div>
                                                    <div class="comparison__parameterRow">Значение параметра<span class="comparison__parameterName">Параметр</span></div>
                                                    <div class="comparison__parameterRow">Значение параметра<span class="comparison__parameterName">Параметр</span></div>
                                                    <div class="comparison__parameterRow">Значение параметра<span class="comparison__parameterName">Параметр</span></div>
                                                    <div class="comparison__parameterRow">Значение параметра<span class="comparison__parameterName">Параметр</span></div>
                                                    <div class="comparison__parameterRow">Значение параметра<span class="comparison__parameterName">Параметр</span></div>
                                                </div>
                                                <div class="swiper-slide compareParametersSlider__slide">
                                                    <div class="comparison__parameterRow">Значение параметра<span class="comparison__parameterName">Параметр</span></div>
                                                    <div class="comparison__parameterRow">Значение параметра<span class="comparison__parameterName">Параметр</span></div>
                                                    <div class="comparison__parameterRow">Значение параметра<span class="comparison__parameterName">Параметр</span></div>
                                                    <div class="comparison__parameterRow">Значение параметра<span class="comparison__parameterName">Параметр</span></div>
                                                    <div class="comparison__parameterRow">Значение параметра<span class="comparison__parameterName">Параметр</span></div>
                                                    <div class="comparison__parameterRow">Значение параметра<span class="comparison__parameterName">Параметр</span></div>
                                                    <div class="comparison__parameterRow">Значение параметра<span class="comparison__parameterName">Параметр</span></div>
                                                    <div class="comparison__parameterRow">Значение параметра<span class="comparison__parameterName">Параметр</span></div>
                                                    <div class="comparison__parameterRow">Значение параметра<span class="comparison__parameterName">Параметр</span></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="comparison__back"><a class="comparison__backBtn btn" href="#">Назад к товарам</a></div>
                    </div>
                </div>
            </div>
        </section>
    </main>

@endsection
