@extends('layouts.index')

@section('content')
    <main class="page">
        <nav class="breadcrumbs">
            <div class="breadcrumbs__container _container">
                <ul class="breadcrumbs__list">
                    <li class="breadcrumbs__item"><a class="breadcrumbs__link"
                                                     href="{{ url('/') }}"><span>Главная</span>
                            <svg>
                                <use xlink:href="/img/sprites/sprite-mono.svg#slideArrow"></use>
                            </svg>
                        </a></li>
                    <li class="breadcrumbs__item"><a class="breadcrumbs__link breadcrumbs__link--active"
                                                     href="#"><span>Статьи</span></a></li>
                </ul>
            </div>
        </nav>
        <section class="cooperation">
            <div class="cooperation__container _container">
                <div class="cooperation__content">
                    <h2 class="cooperation__title t">Статьи</h2>
                    @include('posts.custom.stati_tags')
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
                        <div class="postContainer">
                            @foreach($posts as $post)

                                <div class="post_itemWrp">
                                    <div class="card post_card">
                                        <div class="card__title" style="z-index: 3;font-size: 20px; ">
                                            <a class="link"
                                               href="{{route('index.posts.by_id',['slug' => $post->slug])}}">
                                                {{ $post->title ?? ''}}
                                            </a>
                                        </div>

                                        <a href="{{route('index.posts.by_id',['slug' => $post->slug])}}"
                                           class="linkClass">
                                            <div class="card__imgWrp">
                                                <a class="card__imgBox"
                                                   href="{{route('index.posts.by_id',['slug' => $post->slug])}}">
                                                    <picture style="z-index: 2;">
                                                        <source type="image/webp"
                                                                srcset="{{ $post->mainPhotoPath() }}">
                                                        <img src="{{ $post->mainPhotoPath() }}" alt="p1">
                                                    </picture>
                                                </a>
                                            </div>

                                            <div class="card__body">
                                                <div class="card__title" style="z-index: 3; font-size: 16px; ">
                                                    <a class="link"
                                                       href="{{route('index.posts.by_id',['slug' => $post->slug])}}">
                                                        {{ $post->preview ?? ''}}
                                                    </a>
                                                </div>
                                            </div>
                                        </a>


                                    </div>

                                </div>

                            @endforeach
                        </div>
                    </div> {{ $posts->links('pagination::bootstrap-4') }}
                    @include('layouts.pagination')
                </div>
            </div>
        </section>
    </main>
    <style>
        .linkClass {
            position: absolute;
            height: 100%;
            width: 100%;
            z-index: 1;
            top: 0;
            left: 0;
        }
        @media screen and (max-width: 900px) {
         .post_itemWrp{
             width: 90% !important;
         }
        }
        .postContainer {
            flex-direction: row;
            justify-content: flex-start;
            display: flex;
            flex-wrap: wrap;
            padding: 20px;
        }

        .post_itemWrp {
            box-sizing: border-box;
            width: 28%;
            margin: 15px;
        }

        .post_card {
            position: relative;
            max-width: 400px;
            margin: 0 auto
        }

    </style>
@endsection
