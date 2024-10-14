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
                    @if($project->is_photo_project)
                        <li class="breadcrumbs__item">
                            <a class="breadcrumbs__link" href="{{ route('index.gallery.index') }}">
                                <span>Фото галерея</span>
                                <svg>
                                    <use xlink:href="/img/sprites/sprite-mono.svg#slideArrow"></use>
                                </svg>
                            </a>
                        </li>
                    @else
                        <li class="breadcrumbs__item">
                            <a class="breadcrumbs__link" href="{{ route('index.projects.index') }}">
                                <span>Наши проекты</span>
                                <svg>
                                    <use xlink:href="/img/sprites/sprite-mono.svg#slideArrow"></use>
                                </svg>
                            </a>
                        </li>
                    @endif
                    <li class="breadcrumbs__item">
                        <a class="breadcrumbs__link breadcrumbs__link--active" href="{{ \Illuminate\Support\Facades\URL::current() }}">
                            <span>{{ $project->title }}</span>
                            <svg>
                                <use xlink:href="/img/sprites/sprite-mono.svg#slideArrow"></use>
                            </svg>
                        </a>
                    </li>
                </ul>
            </div>
        </nav>
        <!-- Project Photo-->
        <section class="project">
            <div class="project__container _container sideDashContainer">
{{--                <div class="sideDash sideDash--sticky">--}}
{{--                    <div class="sideDash__item sideDash__item--gap sideDash__item--active">--}}
{{--                        <svg class="sideDash__icon">--}}
{{--                            <use xlink:href="./img/sprites/sprite-mono.svg#building"></use>--}}
{{--                        </svg>--}}
{{--                        <div class="sideDash__mark">Услуги</div>--}}
{{--                    </div>--}}
{{--                    <div class="sideDash__item sideDash__item--gap">--}}
{{--                        <svg class="sideDash__icon">--}}
{{--                            <use xlink:href="./img/sprites/sprite-mono.svg#manufacturing"></use>--}}
{{--                        </svg>--}}
{{--                        <div class="sideDash__mark">Услуги</div>--}}
{{--                    </div>--}}
{{--                    <div class="sideDash__item sideDash__item--gap">--}}
{{--                        <svg class="sideDash__icon">--}}
{{--                            <use xlink:href="./img/sprites/sprite-mono.svg#settings"></use>--}}
{{--                        </svg>--}}
{{--                        <div class="sideDash__mark">Услуги</div>--}}
{{--                    </div>--}}
{{--                    <div class="sideDash__item sideDash__item--gap">--}}
{{--                        <svg class="sideDash__icon">--}}
{{--                            <use xlink:href="./img/sprites/sprite-mono.svg#management"></use>--}}
{{--                        </svg>--}}
{{--                        <div class="sideDash__mark">Услуги</div>--}}
{{--                    </div>--}}
{{--                </div>--}}

                <div class="project__content">
                    <h2 class="project__title t">{{ $project->title }}</h2>
                    <div class="project__body">
                        <div class="info project__info">
                            <div class="info__txt">
                                {!! $project->body !!}
                            </div>
                        </div>
                        <div class="presentation project__presentation">
                            <div class="presentation-slider swiper-container presentation__picture">
                                <div class="swiper-wrapper">

                                    @foreach($project->photos as $photo)
                                        <a class="presentation-slider__item swiper-slide" href="{{ url('upload_images/' . $photo->path) }}" data-fslightbox>
                                            <div class="ratio__box">
                                                <picture>
                                                    <source type="image/webp" srcset="{{ url('upload_images/' . $photo->path) }}">
                                                    <img class="presentation-slider__pic" src="{{ url('upload_images/' . $photo->path) }}" alt="presentation_1">
                                                </picture>
                                            </div>

                                        </a>
                                    @endforeach


                                </div>
                            </div>

                            <div class="presentation-thumbnails swiper-container presentation__thumbs">
                                <div class="swiper-wrapper">


                                    @foreach($project->photos as $photo)
                                        <div class="presentation-thumbnails__item swiper-slide">
                                            <div class="ratio__box">
                                                <picture>
                                                    <source type="image/webp" srcset="{{ url('upload_images/' . $photo->path) }}">
                                                    <img class="presentation-thumbnails__pic" src="{{ url('upload_images/' . $photo->path) }}" alt="presentation_1">
                                                </picture>
                                            </div>
                                        </div>
                                    @endforeach


                                </div>


                                <div class="presentation-slider__controls">
                                    <div class="presentation-slider__btn presentation-slider__btn_prev">
                                        <svg class="presentation-slider__arrow">
                                            <use xlink:href="./img/sprites/sprite-mono.svg#arrow_left"></use>
                                        </svg>
                                    </div>
                                    <div class="presentation-slider__btn presentation-slider__btn_next">
                                        <svg class="presentation-slider__arrow">
                                            <use xlink:href="./img/sprites/sprite-mono.svg#arrow_right"></use>
                                        </svg>
                                    </div>
                                </div>
                                @if(count($project->relatedProjects))
                                    <section class="newItems crossale">
                                        <div class="newItems__container _container">
                                            <div class="newItems__content">
                                                <div class="newItems__body">
                                                    <div class="newItems__controlPanel">
                                                        <h2 class="newItems__title t">Товары, которые могут вам подойти</h2>
                                                    </div>
                                                    <div class="wrp-itemsSlider">
                                                        <div class="swiper-container itemsSlider">
                                                            <div class="swiper-wrapper itemsSlider__wrapper">
                                                                @foreach($project->relatedProjects as $sliderProduct)
                                                                    @include('products._block_item')
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </section>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

{{--        <section class="newItems">--}}
{{--            <div class="newItems__container _container">--}}
{{--                <div class="newItems__content">--}}
{{--                    <div class="newItems__body">--}}
{{--                        <div class="newItems__controlPanel">--}}
{{--                            <h2 class="newItems__title t">Товары, которые могут вам подойти</h2>--}}
{{--                            <div class="newItems__sliderBtns">--}}
{{--                                <div class="newItems__sliderBtn newItems__sliderBtn--prev" role="button" tabindex="0">--}}
{{--                                    <svg>--}}
{{--                                        <use xlink:href="./img/sprites/sprite-mono.svg#slideArrow"></use>--}}
{{--                                    </svg>--}}
{{--                                </div>--}}
{{--                                <div class="newItems__sliderBtn newItems__sliderBtn--next" role="button" tabindex="0">--}}
{{--                                    <svg>--}}
{{--                                        <use xlink:href="./img/sprites/sprite-mono.svg#slideArrow"></use>--}}
{{--                                    </svg>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="wrp-itemsSlider">--}}
{{--                            <div class="swiper-container itemsSlider _swiper">--}}
{{--                                <div class="swiper-wrapper itemsSlider__wrapper">--}}
{{--                                    <div class="swiper-slide undefined itemsSlider__slide">--}}
{{--                                        <div class="card newItems__card">--}}
{{--                                            <div class="card__imgWrp"><a class="card__imgBox" href="#">--}}
{{--                                                    <picture>--}}
{{--                                                        <source type="image/webp" srcset="./img/brands//b1.webp"><img src="./img/brands//b1.jpg" alt="b1">--}}
{{--                                                    </picture></a></div>--}}
{{--                                            <div class="card__title"><a class="link" href="">Фальцевая кровля</a></div>--}}
{{--                                            <ul class="card__chars">--}}
{{--                                                <li class="card__char">Цвет: 1014 Слоновая кость</li>--}}
{{--                                                <li class="card__char">Покрытие: Полиэстер</li>--}}
{{--                                                <li class="card__char">Толщина, мм: 0.4</li>--}}
{{--                                            </ul>--}}
{{--                                            <div class="card__price">667 ₽/м2</div>--}}
{{--                                            <div class="card__controllers">--}}
{{--                                                <div class="card__btn btn" role="button" tabindex="0">Подробнее</div>--}}
{{--                                                <div class="card__icons">--}}
{{--                                                    <div class="card__icon card__icon--like" role="button" tabindex="0">--}}
{{--                                                        <svg>--}}
{{--                                                            <use xlink:href="./img/sprites/sprite-mono.svg#heart"></use>--}}
{{--                                                        </svg>--}}
{{--                                                    </div>--}}
{{--                                                    <div class="card__icon card__icon--stat" role="button" tabindex="0">--}}
{{--                                                        <svg>--}}
{{--                                                            <use xlink:href="./img/sprites/sprite-mono.svg#stat"></use>--}}
{{--                                                        </svg>--}}
{{--                                                    </div>--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                    <div class="swiper-slide undefined itemsSlider__slide">--}}
{{--                                        <div class="card newItems__card">--}}
{{--                                            <div class="card__imgWrp"><a class="card__imgBox" href="#">--}}
{{--                                                    <picture>--}}
{{--                                                        <source type="image/webp" srcset="./img/brands//b2.webp"><img src="./img/brands//b2.jpg" alt="b2">--}}
{{--                                                    </picture></a></div>--}}
{{--                                            <div class="card__title"><a class="link" href="">Ондулин</a></div>--}}
{{--                                            <ul class="card__chars">--}}
{{--                                                <li class="card__char">Цвет: 1014 Слоновая кость</li>--}}
{{--                                                <li class="card__char">Покрытие: Полиэстер</li>--}}
{{--                                                <li class="card__char">Толщина, мм: 0.4</li>--}}
{{--                                            </ul>--}}
{{--                                            <div class="card__price">667 ₽/м2</div>--}}
{{--                                            <div class="card__controllers">--}}
{{--                                                <div class="card__btn btn" role="button" tabindex="0">Подробнее</div>--}}
{{--                                                <div class="card__icons">--}}
{{--                                                    <div class="card__icon card__icon--like" role="button" tabindex="0">--}}
{{--                                                        <svg class="_checked">--}}
{{--                                                            <use xlink:href="./img/sprites/sprite-mono.svg#heart"></use>--}}
{{--                                                        </svg>--}}
{{--                                                    </div>--}}
{{--                                                    <div class="card__icon card__icon--stat" role="button" tabindex="0">--}}
{{--                                                        <svg class="_checked">--}}
{{--                                                            <use xlink:href="./img/sprites/sprite-mono.svg#stat"></use>--}}
{{--                                                        </svg>--}}
{{--                                                    </div>--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                    <div class="swiper-slide undefined itemsSlider__slide">--}}
{{--                                        <div class="card newItems__card">--}}
{{--                                            <div class="card__imgWrp"><a class="card__imgBox" href="#">--}}
{{--                                                    <picture>--}}
{{--                                                        <source type="image/webp" srcset="./img/brands//b3.webp"><img src="./img/brands//b3.jpg" alt="b3">--}}
{{--                                                    </picture></a></div>--}}
{{--                                            <div class="card__title"><a class="link" href="">Гибкая черепица</a></div>--}}
{{--                                            <ul class="card__chars">--}}
{{--                                                <li class="card__char">Цвет: 1014 Слоновая кость</li>--}}
{{--                                                <li class="card__char">Покрытие: Полиэстер</li>--}}
{{--                                                <li class="card__char">Толщина, мм: 0.4</li>--}}
{{--                                            </ul>--}}
{{--                                            <div class="card__price">667 ₽/м2</div>--}}
{{--                                            <div class="card__controllers">--}}
{{--                                                <div class="card__btn btn" role="button" tabindex="0">Подробнее</div>--}}
{{--                                                <div class="card__icons">--}}
{{--                                                    <div class="card__icon card__icon--like" role="button" tabindex="0">--}}
{{--                                                        <svg>--}}
{{--                                                            <use xlink:href="./img/sprites/sprite-mono.svg#heart"></use>--}}
{{--                                                        </svg>--}}
{{--                                                    </div>--}}
{{--                                                    <div class="card__icon card__icon--stat" role="button" tabindex="0">--}}
{{--                                                        <svg>--}}
{{--                                                            <use xlink:href="./img/sprites/sprite-mono.svg#stat"></use>--}}
{{--                                                        </svg>--}}
{{--                                                    </div>--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                    <div class="swiper-slide undefined itemsSlider__slide">--}}
{{--                                        <div class="card newItems__card">--}}
{{--                                            <div class="card__imgWrp"><a class="card__imgBox" href="#">--}}
{{--                                                    <picture>--}}
{{--                                                        <source type="image/webp" srcset="./img/brands//b4.webp"><img src="./img/brands//b4.jpg" alt="b4">--}}
{{--                                                    </picture></a></div>--}}
{{--                                            <div class="card__title"><a class="link" href="">Металлочерепица</a></div>--}}
{{--                                            <ul class="card__chars">--}}
{{--                                                <li class="card__char">Цвет: 1014 Слоновая кость</li>--}}
{{--                                                <li class="card__char">Покрытие: Полиэстер</li>--}}
{{--                                                <li class="card__char">Толщина, мм: 0.4</li>--}}
{{--                                            </ul>--}}
{{--                                            <div class="card__price">667 ₽/м2</div>--}}
{{--                                            <div class="card__controllers">--}}
{{--                                                <div class="card__btn btn" role="button" tabindex="0">Подробнее</div>--}}
{{--                                                <div class="card__icons">--}}
{{--                                                    <div class="card__icon card__icon--like" role="button" tabindex="0">--}}
{{--                                                        <svg>--}}
{{--                                                            <use xlink:href="./img/sprites/sprite-mono.svg#heart"></use>--}}
{{--                                                        </svg>--}}
{{--                                                    </div>--}}
{{--                                                    <div class="card__icon card__icon--stat" role="button" tabindex="0">--}}
{{--                                                        <svg>--}}
{{--                                                            <use xlink:href="./img/sprites/sprite-mono.svg#stat"></use>--}}
{{--                                                        </svg>--}}
{{--                                                    </div>--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                    <div class="swiper-slide undefined itemsSlider__slide">--}}
{{--                                        <div class="card newItems__card">--}}
{{--                                            <div class="card__imgWrp"><a class="card__imgBox" href="#">--}}
{{--                                                    <picture>--}}
{{--                                                        <source type="image/webp" srcset="./img/brands//b4.webp"><img src="./img/brands//b4.jpg" alt="b4">--}}
{{--                                                    </picture></a></div>--}}
{{--                                            <div class="card__title"><a class="link" href="">Металлочерепица</a></div>--}}
{{--                                            <ul class="card__chars">--}}
{{--                                                <li class="card__char">Цвет: 1014 Слоновая кость</li>--}}
{{--                                                <li class="card__char">Покрытие: Полиэстер</li>--}}
{{--                                                <li class="card__char">Толщина, мм: 0.4</li>--}}
{{--                                            </ul>--}}
{{--                                            <div class="card__price">667 ₽/м2</div>--}}
{{--                                            <div class="card__controllers">--}}
{{--                                                <div class="card__btn btn" role="button" tabindex="0">Подробнее</div>--}}
{{--                                                <div class="card__icons">--}}
{{--                                                    <div class="card__icon card__icon--like" role="button" tabindex="0">--}}
{{--                                                        <svg>--}}
{{--                                                            <use xlink:href="./img/sprites/sprite-mono.svg#heart"></use>--}}
{{--                                                        </svg>--}}
{{--                                                    </div>--}}
{{--                                                    <div class="card__icon card__icon--stat" role="button" tabindex="0">--}}
{{--                                                        <svg>--}}
{{--                                                            <use xlink:href="./img/sprites/sprite-mono.svg#stat"></use>--}}
{{--                                                        </svg>--}}
{{--                                                    </div>--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </section>--}}
{{--        <section class="newItems newItems--gap">--}}
{{--            <div class="newItems__container _container">--}}
{{--                <div class="newItems__content">--}}
{{--                    <div class="newItems__body">--}}
{{--                        <div class="newItems__controlPanel">--}}
{{--                            <h2 class="newItems__title t">Просмотренные объекты</h2>--}}
{{--                            <div class="newItems__sliderBtns">--}}
{{--                                <div class="newItems__sliderBtn newItems__sliderBtn--prev" role="button" tabindex="0">--}}
{{--                                    <svg>--}}
{{--                                        <use xlink:href="./img/sprites/sprite-mono.svg#slideArrow"></use>--}}
{{--                                    </svg>--}}
{{--                                </div>--}}
{{--                                <div class="newItems__sliderBtn newItems__sliderBtn--next" role="button" tabindex="0">--}}
{{--                                    <svg>--}}
{{--                                        <use xlink:href="./img/sprites/sprite-mono.svg#slideArrow"></use>--}}
{{--                                    </svg>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="wrp-itemsSlider">--}}
{{--                            <div class="swiper-container itemsSlider _swiper">--}}
{{--                                <div class="swiper-wrapper itemsSlider__wrapper">--}}
{{--                                    <div class="swiper-slide undefined itemsSlider__slide">--}}
{{--                                        <div class="card card--simple newItems__card">--}}
{{--                                            <div class="card__imgWrp"><a class="card__imgBox" href="#">--}}
{{--                                                    <picture>--}}
{{--                                                        <source type="image/webp" srcset="./img/project//object_1.webp"><img src="./img/project//object_1.png" alt="object_1">--}}
{{--                                                    </picture></a></div>--}}
{{--                                            <div class="card__title"><a class="link" href="">Название проекта</a></div>--}}
{{--                                            <ul class="card__chars">--}}
{{--                                                <li class="card__char">Ростов-на-Дону</li>--}}
{{--                                            </ul>--}}
{{--                                            <div class="card__controllers">--}}
{{--                                                <div class="card__btn btn" role="button" tabindex="0">Посмотреть</div>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                    <div class="swiper-slide undefined itemsSlider__slide">--}}
{{--                                        <div class="card card--simple newItems__card">--}}
{{--                                            <div class="card__imgWrp"><a class="card__imgBox" href="#">--}}
{{--                                                    <picture>--}}
{{--                                                        <source type="image/webp" srcset="./img/project//object_2.webp"><img src="./img/project//object_2.png" alt="object_2">--}}
{{--                                                    </picture></a></div>--}}
{{--                                            <div class="card__title"><a class="link" href="">Название проекта</a></div>--}}
{{--                                            <ul class="card__chars">--}}
{{--                                                <li class="card__char">Ростов-на-Дону</li>--}}
{{--                                            </ul>--}}
{{--                                            <div class="card__controllers">--}}
{{--                                                <div class="card__btn btn" role="button" tabindex="0">Посмотреть</div>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                    <div class="swiper-slide undefined itemsSlider__slide">--}}
{{--                                        <div class="card card--simple newItems__card">--}}
{{--                                            <div class="card__imgWrp"><a class="card__imgBox" href="#">--}}
{{--                                                    <picture>--}}
{{--                                                        <source type="image/webp" srcset="./img/project//object_3.webp"><img src="./img/project//object_3.png" alt="object_3">--}}
{{--                                                    </picture></a></div>--}}
{{--                                            <div class="card__title"><a class="link" href="">Название проекта</a></div>--}}
{{--                                            <ul class="card__chars">--}}
{{--                                                <li class="card__char">Ростов-на-Дону</li>--}}
{{--                                            </ul>--}}
{{--                                            <div class="card__controllers">--}}
{{--                                                <div class="card__btn btn" role="button" tabindex="0">Посмотреть</div>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                    <div class="swiper-slide undefined itemsSlider__slide">--}}
{{--                                        <div class="card card--simple newItems__card">--}}
{{--                                            <div class="card__imgWrp"><a class="card__imgBox" href="#">--}}
{{--                                                    <picture>--}}
{{--                                                        <source type="image/webp" srcset="./img/project//object_4.webp"><img src="./img/project//object_4.png" alt="object_4">--}}
{{--                                                    </picture></a></div>--}}
{{--                                            <div class="card__title"><a class="link" href="">Название проекта</a></div>--}}
{{--                                            <ul class="card__chars">--}}
{{--                                                <li class="card__char">Ростов-на-Дону</li>--}}
{{--                                            </ul>--}}
{{--                                            <div class="card__controllers">--}}
{{--                                                <div class="card__btn btn" role="button" tabindex="0">Посмотреть</div>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                    <div class="swiper-slide undefined itemsSlider__slide">--}}
{{--                                        <div class="card card--simple newItems__card">--}}
{{--                                            <div class="card__imgWrp"><a class="card__imgBox" href="#">--}}
{{--                                                    <picture>--}}
{{--                                                        <source type="image/webp" srcset="./img/project//object_4.webp"><img src="./img/project//object_4.png" alt="object_4">--}}
{{--                                                    </picture></a></div>--}}
{{--                                            <div class="card__title"><a class="link" href="">Название проекта</a></div>--}}
{{--                                            <ul class="card__chars">--}}
{{--                                                <li class="card__char">Ростов-на-Дону</li>--}}
{{--                                            </ul>--}}
{{--                                            <div class="card__controllers">--}}
{{--                                                <div class="card__btn btn" role="button" tabindex="0">Посмотреть</div>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </section>--}}
    </main>
@endsection

<style>
.newItems__container {
    padding-left: 0 !important;
    padding-right: 0 !important;
}
.newItems__content {
        padding-top: 64px !important;
    }
</style>
