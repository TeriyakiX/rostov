@extends('layouts.index')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
@section('content')

    <main class="page">
        <nav class="breadcrumbs">
            <div class="breadcrumbs__container _container">
                <ul class="breadcrumbs__list">
                    <li class="breadcrumbs__item"><a class="breadcrumbs__link" href="#"><span>Главная</span>
                            <svg>
                                <use xlink:href="/img/sprites/sprite-mono.svg#slideArrow"></use>
                            </svg>
                        </a></li>
                    <li class="breadcrumbs__item"><a class="breadcrumbs__link breadcrumbs__link--active"
                                                     href="#"><span>{{ $postCategory->title }}</span>
                            <svg>
                                <use xlink:href="{{ asset('img/icons/blue-play.svg#blue-play') }}"></use>
                            </svg></a></li>
                </ul>
            </div>
        </nav>

{{--        <!-- Project Gallery-->--}}
        <section class="gallery">
            <div class="gallery__container _container sideDashContainer">
                <h1 class="gallery__title t">
                    Услуги
                </h1>
                <div class="sideDash sideDash--sticky" style="z-index: 1111">
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
                <div class="gallery__content">
                    <div class="cooperation__body">
                        <div class="gallery__body sideDashContainer">
                            @foreach($posts as $key=>$post)

                                                            <div class="gallery__itemWrp" style="padding: 0">
                                                                <div class="gallery__itemBox">
                                                                    <div class="gallery__itemTitle">
                                                                        <a class="link"
                                                                           href="{{ route('index.posts.show', ['slug' => $post->slug]) }}">
                                                                            {{ $post->seo_title }}
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                @include('posts.custom._'.$post->slug)


                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

        </section>
    </main>
    @include('posts.custom.modals.service_modals')
@endsection
<style>
    .gallery__content {
        margin-top: 5px;
    }
    .gallery__itemTitle {
        font-weight: 700;
    }
    @media (max-width: 767.98px) {
        .sideDash--sticky {
            padding-left: 0 !important;
        }
    }
</style>
<script>
    // $(document).on("click", ".open_help_popup", function () {
    //     $('.popup_help').addClass('_active')
    // });
    $(document).on("click", ".service_usluga_btn", function () {
        $('.popup_usluga_dostakva').addClass('_active')
    });
    $(document).on("click", ".service_raschet_btn", function () {
        $('.popup_zakazat_raschet').addClass('_active')
    });
    $(document).on("click", ".service_montazh_btn", function () {
        $('.popup_montazh_raschet').addClass('_active')
    });
</script>
