@extends('layouts.index')

@section('content')

    <main class="page">
        <nav class="breadcrumbs">
            <div class="breadcrumbs__container _container">
                <ul class="breadcrumbs__list">
                    <li class="breadcrumbs__item"><a class="breadcrumbs__link" href="#"><span>Главная</span>
                            <svg>
                                <use xlink:href="{{ asset('img/sprites/sprite-mono.svg#slideArrow') }}"></use>
                            </svg>
                        </a></li>
                    <li class="breadcrumbs__item"><a class="breadcrumbs__link breadcrumbs__link--active" href="#"><span>Бренды</span></a>
                    </li>
                </ul>
            </div>
        </nav>

        <section class="brands">

            <div class="brands__container _container">
                <div class="brands__content">
                    <div class="brands__head">
                        <h2 class="brands__title t">Бренды</h2>
                        <div class="brands__controls newItems__tabs"><a class="brands__tabsEl newItems__tabsEl" href="{{route('index.posts.show',['slug'=>'katalog'])}}"
                                                                        role="button" tabindex="0">Категории товаров</a><a
                                class="brands__tabsEl brands__tabsEl--active newItems__tabsEl" href="#" role="button"
                                tabindex="0">Бренды</a></div>
                    </div>
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
                    @include('posts.custom._tags')
                    <div class="brands__body">
                        @forelse($brands as $brand)
                            <div class="brands__cardWrp">
                                <div class="brands__card">
                                    <div class="brands__imgBox ibg"><a class="brands__imgLink"
                                                                       href="{{route('index.brands.index', $brand['id'])}}">
                                                                       @if(isset($brand->files[0]))
                                            <picture>
                                                <source type="image/webp"
                                                        srcset="{{ asset('upload_files/' . $brand->files[0]->filepath) }}">
                                                <img
                                                    src="{{ asset('upload_files/' . $brand->files[0]->filepath) }}"
                                                    alt="#image">
                                            </picture>
                                            @endif
                                        </a></div>
                                    <div class="brands__cardBody"><a class="brands__cardTitle link"
                                                                     href="{{route('index.brands.index', $brand['id'])}}">{{$brand['title']}}</a>
                                        <div class="brands__cardBrands" style="margin-top: 5px">
                                            <div>{{$brand['description']}}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div>Empty</div>
                        @endforelse
                    </div>
                </div>
                {{ $brands->links('pagination::bootstrap-4') }}
                @include('layouts.pagination')
            </div>
        </div>

        </section>


        <div class="_container" style="margin-top: 30px">
            <p class="_txt">SEO текст. Дивергенция векторного поля позитивно трансформирует натуральный логарифм.
                Умножение двух векторов (скалярное) накладывает неопровержимый двойной интеграл, что несомненно приведет
                нас к истине. Математический анализ изящно ускоряет абстрактный Наибольший Общий Делитель (НОД).</p>
        </div>
    </main>
@endsection
