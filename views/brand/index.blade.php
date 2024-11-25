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
        @dd($brands)
        <section class="brands">
            <div class="brands__container _container">
                <div class="brands__content">
                    <div class="brands__head">
                        <h2 class="brands__title t">Бренды</h2>
                        <div class="brands__controls newItems__tabs"><a class="brands__tabsEl newItems__tabsEl" href="#"
                                                                        role="button" tabindex="0">Каталог товаров</a><a
                                class="brands__tabsEl brands__tabsEl--active newItems__tabsEl" href="#" role="button"
                                tabindex="0">Бренды</a></div>
                    </div>
                    @include('posts.custom._tags')
                    <div class="brands__body">
                        @forelse($brands as $brand)
                            <div class="brands__cardWrp">
                                <div class="brands__card">
                                    <div class="brands__imgBox ibg"><a class="brands__imgLink"
                                                                       href="{{route('index.brands.index', $brand['id'])}}">
                                            <picture>
                                                <source type="image/webp"
                                                        srcset="{{ asset('upload_files/' . $brand->files[0]->filepath) }}">
                                                <img
                                                    src="{{ asset('upload_files/' . $brand->files[0]->filepath) }}"
                                                    alt="#image">
                                            </picture>
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
            </div>

        </section>

        {{ $brands->links('pagination::bootstrap-4') }}
        @include('layouts.pagination')
        <div class="_container">
            <p class="_txt">SEO текст. Дивергенция векторного поля позитивно трансформирует натуральный логарифм.
                Умножение двух векторов (скалярное) накладывает неопровержимый двойной интеграл, что несомненно приведет
                нас к истине. Математический анализ изящно ускоряет абстрактный Наибольший Общий Делитель (НОД).</p>
        </div>
    </main>
@endsection
