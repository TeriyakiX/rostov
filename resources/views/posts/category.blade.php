@extends('layouts.index')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
@section('content')

    <main class="page" style="padding: 20px">
        <nav class="breadcrumbs">
            <div class="breadcrumbs__container _container">
                <ul class="breadcrumbs__list">
                    <li class="breadcrumbs__item"><a class="breadcrumbs__link" href="#"><span>Главная</span>
                            <svg>
                                <use xlink:href="/img/sprites/sprite-mono.svg#slideArrow"></use>
                            </svg>
                        </a></li>
                    <li class="breadcrumbs__item"><a class="breadcrumbs__link breadcrumbs__link--active"
                                                     href="#"><span>{{ $postCategory->title }}</span></a></li>
                </ul>
            </div>
        </nav>


{{--        <!-- Project Gallery-->--}}
        <section class="gallery">
            <div class="gallery__container _container">
                <div class="gallery__content">
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
                    <div class="gallery__body sideDashContainer">
                        @foreach($posts as $key=>$post)

                                                            <div class="gallery__itemWrp" style="padding: 0">
                                                                <div class="gallery__itemBox">
                                                                    <div class="gallery__itemTitle">
                                                                        <a class="link"
                                                                           href="{{ route('index.posts.show', ['slug' => $post->slug]) }}">
                                                                            {{ $post->title }}
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

    .cooperation--cta {
        width: 100%;
        display: flex;
        justify-content: space-between;
    }

    .cooperation--cta_item {
        height: 293px;
        position: relative;
        margin-bottom: 30px;
        max-width: 190px;
        width: 100%;
        z-index: 1;
        left: -51px;
    }

    .cooperation--cta_item:nth-child(1) {
        max-width: 801px;
        width: 100%;
        overflow: hidden;
        left: 0;
    }

    .cooperation--cta_item:nth-child(1):before {
        content: "";
        display: block;
        position: absolute;
        top: 0;
        right: 0;
        width: 59px;
        height: 100%;
        background-color: white;
        background-size: 100% 100%;
        z-index: 1;
        transform: translate(10%, 0) skewX(-20deg)
    }

    .cooperation--cta_item > img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .cooperation--cta_item-bg:before {
        content: "";
        position: absolute;
        width: 100%;
        height: 100%;
        top: 0;
        left: 0;
        background: linear-gradient(0deg, rgba(154, 243, 239, 0.84), rgba(154, 243, 239, 0.84));
        z-index: 11;
        transform: translate(0, 0) skewX(-20deg)
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
