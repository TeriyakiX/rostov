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
                    <li class="breadcrumbs__item"><a class="breadcrumbs__link breadcrumbs__link--active" href="#"><span>Бренды</span>
                            <svg>
                                <use xlink:href="{{ asset('img/icons/blue-play.svg#blue-play') }}"></use>
                            </svg>
                        </a>
                    </li>
                </ul>
            </div>
        </nav>

        <section class="brands">

            <div class="brands__container _container">
                <div class="brands__content">
                    <div class="brands__head">
                        <h2 class="brands__title t">Бренды</h2>
                        <div class="brands__controls newItems__tabs">
                            <a class="brands__tabsEl newItems__tabsEl" href="{{route('index.posts.show',['slug'=>'katalog'])}}"
                                                                        role="button" tabindex="0">Каталог товаров</a><a
                                class="brands__tabsEl brands__tabsEl--active newItems__tabsEl" href="#" role="button"
                                tabindex="0">Бренды</a></div>
                    </div>
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
                        <div class="brands__content__tags">@include('posts.custom._tags')</div>
                    <div class="catalogContainer">
                        @forelse($brands as $index => $brand)
                            <div class="catalogItemBoxWrp">
                                <a href="{{route('index.brands.index', $brand['id'])}}"
                                   class="catalogItemBox {{ $index % 2 == 0 ? 'catalogItemBox--left' : 'catalogItemBox--right' }}">

                                    <div class="catalogItemContent">
                                        <div class="catalogTitle">{{$brand['title']}}</div>
                                    </div>

                                    <div class="catalogItemImgBox block-{{$loop->index}}">

                                        @if(isset($brand->files[0]))
                                          <div class="catalogItemImg">
                                              <img
                                                  src="{{ asset('upload_files/' . $brand->files[0]->filepath) }}"
                                                  alt="#image">
                                          </div>
                                        @endif
                                    </div>
                                </a>
                            </div>
                        @empty
                            <div>Empty</div>
                        @endforelse
                    </div>
                </div>
                 <div style="margin-top: 20px;">
                     {{ $brands->links('pagination::bootstrap-4') }}
                     @include('layouts.pagination')
                 </div>
            </div>
        </div>

        </section>
    </main>

    <style>
        .brands {
            padding-bottom: 74px;
        }
        .catalogItemImg img {
            height: 100%;
            width: 100%;
        }

        @media (max-width: 767.98px) {
            .brands {
                padding-bottom: 40px;
            }
        }
    </style>
@endsection
