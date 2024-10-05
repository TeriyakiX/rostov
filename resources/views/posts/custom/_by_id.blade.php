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
                                                     href="{{ url('/posts/stati') }}"><span>Статьи</span>
                            <svg>
                                <use xlink:href="/img/sprites/sprite-mono.svg#slideArrow"></use>
                            </svg>
                        </a></li>
                    <li class="breadcrumbs__item"><a class="breadcrumbs__link breadcrumbs__link--active"
                                                     href="#"><span>{{$post->slug}}</span></a></li>
                </ul>
            </div>
        </nav>
        <section class="cooperation _container">
            <div class="cooperation__container">
                <div class="cooperation__content">
                    <h2 class="cooperation__title t">{{$post->title}}</h2>
                </div>
            </div>
            <div class="postContainer">
                <picture class="postImage">
                    <source type="image/webp"
                            srcset="{{ $post->mainPhotoPath() }}">
                    <img src="{{ $post->mainPhotoPath() }}" alt="p1">
                </picture>
                <div class="postContent">
                    {!! $post->body !!}
                </div>

            </div>
        </section>
    </main>
    <style>
        .postImage{
            max-width: 60%;
            float: left;
            padding-right: 10px;
            padding-bottom: 10px;
            text-align: justify;
        }
    </style>
@endsection
