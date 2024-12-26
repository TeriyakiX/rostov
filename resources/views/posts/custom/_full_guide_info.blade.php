@extends('layouts.index')
@section('content')
    <main class="page">
        <nav class="breadcrumbs">


            <div class="breadcrumbs__container _container">
                <div style="display: flex;align-items:center">
                    <ul class="breadcrumbs__list" style="overflow: hidden;">
                        <li class="breadcrumbs__item"><a class="breadcrumbs__link"
                                                         href="{{ url('/') }}"><span>Главная</span>
                                <svg>
                                    <use xlink:href="/img/sprites/sprite-mono.svg#slideArrow"></use>
                                </svg>
                            </a></li>
                        <li class="breadcrumbs__item"><a class="breadcrumbs__link"
                                                         href="{{ url('/posts/spravochnik-stroitelya') }}"><span>Справочник строителя</span>
                                <svg>
                                    <use xlink:href="/img/sprites/sprite-mono.svg#slideArrow"></use>
                                </svg>
                            </a></li>
                        <li class="breadcrumbs__item"><a class="breadcrumbs__link breadcrumbs__link--active"
                                                         href="#"><span>{{ $post->title }}</span>
                                <svg>
                                    <use xlink:href="{{ asset('img/icons/blue-play.svg#blue-play') }}"></use>
                                </svg></a></li>
                    </ul>
                </div>
            </div>
        </nav>
        <!-- Cooperation section-->
        <section class="cooperation">
            <div class="cooperation__container _container">
                <div class="cooperation__content">
                    <h2 class="cooperation__title t">{{ $post->title .' - это:' }}</h2>
                    <div class="cooperation__body sideDashContainer">
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
                        {{--content--}}
                        <div style="min-height: 200px">
                            <div class="wordContent">{!! $post->description !!} </div>

                        </div>
                        <a class="link wordLink" href="{{ url('/posts/spravochnik-stroitelya') }}" > Обратно к списку</a>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
<style>
    .breadcrumbs__link--active:first-letter{
        text-transform: uppercase;
    }
    .t:first-letter{
        text-transform: uppercase;

    }
    .wordContent{
        min-width: 300px;
        font-size: 16px;
        padding: 20px;
    }
    .wordLink{
        color: #006bde;


        font-size: 16px;
        text-align: center;
    }
</style>
