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
                    <li class="breadcrumbs__item"><a class="breadcrumbs__link"
                                                     href="{{ url('/posts/kalkulyatory') }}"><span>Калькуляторы</span>
                            <svg>
                                <use xlink:href="/img/sprites/sprite-mono.svg#slideArrow"></use>
                            </svg>
                        </a></li>
                    <li class="breadcrumbs__item"><a class="breadcrumbs__link breadcrumbs__link--active"
                                                     href="#"><span>{{$post->title}}</span></a></li>
                </ul>
            </div>
        </nav>

        <section class="cooperation">
            <div class="cooperation__container _container">
                <div class="cooperation__content" >
                    <h2 class="cooperation__title t">{{$post->title}}</h2>

                        {!!$post->body!!}


                </div>
            </div>
        </section>
    </main>
@endsection
