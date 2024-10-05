@extends('layouts.index')

@section('content')

    <main class="page">
        <nav class="breadcrumbs">
            <div class="breadcrumbs__container _container">
                <ul class="breadcrumbs__list">
                    <li class="breadcrumbs__item"><a class="breadcrumbs__link" href="#"><span>Главная</span>
                            <svg>
                                <use xlink:href="/img/sprites/sprite-mono.svg#slideArrow"></use>
                            </svg></a></li>
                    <li class="breadcrumbs__item"><a class="breadcrumbs__link breadcrumbs__link--active" href="#"><span>Фото галерея</span></a></li>
                </ul>
            </div>
        </nav>
        <!-- Project Gallery-->
        <section class="gallery">
            <div class="gallery__container _container">
                <div class="gallery__content">
                    <h2 class="gallery__title t">Название проекта</h2>
                    <div class="productsTmp">
                        <div class="newItems__controlPanel">
                            <div class="newItems__tabs">
                                <a class="newItems__tabsEl -active" href="#">Тэг по одному из признаков товара</a>
                                <a class="newItems__tabsEl" href="#">Ламонтерра</a>
                                <a class="newItems__tabsEl" href="#">Террамонт</a>
                                <a class="newItems__tabsEl" href="#">Популярный признак</a>
                                <a class="newItems__tabsEl" href="#">Тэг по одному из признаков товара</a>
                                <a class="newItems__tabsEl" href="#">Ламонтерра</a>
                                <a class="newItems__tabsEl" href="#">Террамонт</a>
                                <a class="newItems__tabsEl" href="#">Популярный признак</a>
                                <a class="newItems__tabsEl" href="#">Ламонтерра</a>
                                <a class="newItems__tabsEl" href="#">Террамонт</a>
                            </div>
                        </div>
                    </div>
                    <div class="gallery__body sideDashContainer">
                        <div class="gallery__itemWrp">
                            <div class="gallery__itemBox">
                                <a class="gallery__imgBox ibg" href="#">
                                    <picture>
                                        <source type="image/webp" srcset="./img/gallery//g1.webp"><img src="./img/gallery//g1.jpg" alt="g1">
                                    </picture>
                                </a>
                                <div class="gallery__itemTitle"><a class="link" href="#">Название проекта</a></div>
                                <ul class="gallery__params">
                                    <li class="gallery__params">Ростов-на-Дону</li>
                                </ul>
                            </div>
                        </div>
                        <div class="gallery__itemWrp">
                            <div class="gallery__itemBox"><a class="gallery__imgBox ibg" href="#">
                                    <picture>
                                        <source type="image/webp" srcset="./img/gallery//g2.webp"><img src="./img/gallery//g2.jpg" alt="g2">
                                    </picture></a>
                                <div class="gallery__itemTitle"><a class="link" href="#">Название проекта</a></div>
                                <ul class="gallery__params">
                                    <li class="gallery__params">Ростов-на-Дону</li>
                                </ul>
                            </div>
                        </div>
                        <div class="gallery__itemWrp">
                            <div class="gallery__itemBox"><a class="gallery__imgBox ibg" href="#">
                                    <picture>
                                        <source type="image/webp" srcset="./img/gallery//g3.webp"><img src="./img/gallery//g3.jpg" alt="g3">
                                    </picture></a>
                                <div class="gallery__itemTitle"><a class="link" href="#">Название проекта</a></div>
                                <ul class="gallery__params">
                                    <li class="gallery__params">Ростов-на-Дону</li>
                                </ul>
                            </div>
                        </div>
                        <div class="gallery__itemWrp">
                            <div class="gallery__itemBox"><a class="gallery__imgBox ibg" href="#">
                                    <picture>
                                        <source type="image/webp" srcset="./img/gallery//g1.webp"><img src="./img/gallery//g1.jpg" alt="g1">
                                    </picture></a>
                                <div class="gallery__itemTitle"><a class="link" href="#">Название проекта</a></div>
                                <ul class="gallery__params">
                                    <li class="gallery__params">Ростов-на-Дону</li>
                                </ul>
                            </div>
                        </div>
                        <div class="gallery__itemWrp">
                            <div class="gallery__itemBox"><a class="gallery__imgBox ibg" href="#">
                                    <picture>
                                        <source type="image/webp" srcset="./img/gallery//g2.webp"><img src="./img/gallery//g2.jpg" alt="g2">
                                    </picture></a>
                                <div class="gallery__itemTitle"><a class="link" href="#">Название проекта</a></div>
                                <ul class="gallery__params">
                                    <li class="gallery__params">Ростов-на-Дону</li>
                                </ul>
                            </div>
                        </div>
                        <div class="gallery__itemWrp">
                            <div class="gallery__itemBox"><a class="gallery__imgBox ibg" href="#">
                                    <picture>
                                        <source type="image/webp" srcset="./img/gallery//g3.webp"><img src="./img/gallery//g3.jpg" alt="g3">
                                    </picture></a>
                                <div class="gallery__itemTitle"><a class="link" href="#">Название проекта</a></div>
                                <ul class="gallery__params">
                                    <li class="gallery__params">Ростов-на-Дону</li>
                                </ul>
                            </div>
                        </div>
                        <div class="gallery__itemWrp">
                            <div class="gallery__itemBox"><a class="gallery__imgBox ibg" href="#">
                                    <picture>
                                        <source type="image/webp" srcset="./img/gallery//g1.webp"><img src="./img/gallery//g1.jpg" alt="g1">
                                    </picture></a>
                                <div class="gallery__itemTitle"><a class="link" href="#">Название проекта</a></div>
                                <ul class="gallery__params">
                                    <li class="gallery__params">Ростов-на-Дону</li>
                                </ul>
                            </div>
                        </div>
                        <div class="gallery__itemWrp">
                            <div class="gallery__itemBox"><a class="gallery__imgBox ibg" href="#">
                                    <picture>
                                        <source type="image/webp" srcset="./img/gallery//g2.webp"><img src="./img/gallery//g2.jpg" alt="g2">
                                    </picture></a>
                                <div class="gallery__itemTitle"><a class="link" href="#">Название проекта</a></div>
                                <ul class="gallery__params">
                                    <li class="gallery__params">Ростов-на-Дону</li>
                                </ul>
                            </div>
                        </div>
                        <div class="gallery__itemWrp">
                            <div class="gallery__itemBox"><a class="gallery__imgBox ibg" href="#">
                                    <picture>
                                        <source type="image/webp" srcset="./img/gallery//g3.webp"><img src="./img/gallery//g3.jpg" alt="g3">
                                    </picture></a>
                                <div class="gallery__itemTitle"><a class="link" href="#">Название проекта</a></div>
                                <ul class="gallery__params">
                                    <li class="gallery__params">Ростов-на-Дону</li>
                                </ul>
                            </div>
                        </div>
                        <div class="sideDash sideDash--sticky">
                            <div class="sideDash__item sideDash__item--gap sideDash__item--active">
                                <svg class="sideDash__icon">
                                    <use xlink:href="./img/sprites/sprite-mono.svg#building"></use>
                                </svg>
                                <div class="sideDash__mark">Услуги</div>
                            </div>
                            <div class="sideDash__item sideDash__item--gap">
                                <svg class="sideDash__icon">
                                    <use xlink:href="./img/sprites/sprite-mono.svg#manufacturing"></use>
                                </svg>
                                <div class="sideDash__mark">Услуги</div>
                            </div>
                            <div class="sideDash__item sideDash__item--gap">
                                <svg class="sideDash__icon">
                                    <use xlink:href="./img/sprites/sprite-mono.svg#settings"></use>
                                </svg>
                                <div class="sideDash__mark">Услуги</div>
                            </div>
                            <div class="sideDash__item sideDash__item--gap">
                                <svg class="sideDash__icon">
                                    <use xlink:href="./img/sprites/sprite-mono.svg#management"></use>
                                </svg>
                                <div class="sideDash__mark">Услуги</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

@endsection
