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
                    <li class="breadcrumbs__item">
                        <a class="breadcrumbs__link breadcrumbs__link--active" href="{{ \Illuminate\Support\Facades\URL::current() }}">
                            <span>{{ $ourService->title }}</span>
                        </a>
                    </li>
                </ul>
            </div>
        </nav>
        <!-- Project Photo-->
        <section class="project">
            <div class="project__container _container sideDashContainer">
                <div class="project__content">
                    <h2 class="project__title t">{{ $ourService->title }}</h2>
                    <div class="project__body">
                        <div class="info project__info">
                            <div class="info__txt">
                                {!! $ourService->body !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
