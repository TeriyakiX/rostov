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
                                                     href="#"><span>Статьи</span>
                            <svg>
                                <use xlink:href="{{ asset('img/icons/blue-play.svg#blue-play') }}"></use>
                            </svg></a></li>
                </ul>
            </div>
        </nav>
        <section class="cooperation">
            <div class="cooperation__container _container">
                <div class="cooperation__content">
                    <h2 class="cooperation__title t">Статьи</h2>
                    <div class="cooperation__body sideDashContainer">
                        <div class="stati__content__tags">@include('posts.custom.stati_tags')</div>
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
                        <div class="catalogContainer">
                            @foreach($posts as $index => $post)
                                <div class="catalogItemBoxWrp">
                                    <a href="{{route('index.posts.by_id',['slug' => $post->slug])}}"
                                       class="catalogItemBox {{ $index % 2 == 0 ? 'catalogItemBox--left' : 'catalogItemBox--right' }}">
                                        <div class="catalogItemContent">
                                            <div class="catalogTitle">
                                                {{ $post->title ?? ''}}
                                            </div>
                                            <div class="catalogDesc">
                                                {{ $post->preview ?? ''}}
                                            </div>
                                        </div>

                                        <div class="catalogItemImgBox block-{{$loop->index}}">
                                            <div class="catalogItemImg"
                                                 style="background-image: url({{ $post->mainPhotoPath() }})">
                                            </div>
                                        </div>
                                    </a>
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

        @media (max-width: 767.98px) {
            .stati__content__tags {
                display: none;
            }
        }
    </style>
@endsection
