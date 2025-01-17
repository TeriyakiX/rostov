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
                                                 href="#"><span>Карта проезда</span>
                        <svg>
                            <use xlink:href="{{ asset('img/icons/blue-play.svg#blue-play') }}"></use>
                        </svg></a></li>
            </ul>
        </div>
    </nav>
    <section class="travel-map">
        <div class="_container">
            <picture>
                <source srcset="{{ asset('/img/travel-map.png') }}">
                <img src="{{ asset('/img/travel-map.png') }}" alt="travel map">
            </picture>
        </div>
    </section>
</main>

@endsection
