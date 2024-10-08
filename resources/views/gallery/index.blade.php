@extends('layouts.index')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
@section('content')
    <main class="page">
        <nav class="breadcrumbs">
            <div class="breadcrumbs__container _container">
                <ul class="breadcrumbs__list">
                    <li class="breadcrumbs__item">
                        <a class="breadcrumbs__link" href="{{ route('index.home') }}">
                            <span>Главная</span>
                            <svg>
                                <use xlink:href="{{ asset('img/sprites/sprite-mono.svg#slideArrow') }}"></use>
                            </svg>
                        </a>
                    </li>
                    <li class="breadcrumbs__item">
                        <a class="breadcrumbs__link breadcrumbs__link--active" href="#">
                            <span>Фото галерея</span>
                        </a>
                    </li>
                </ul>
            </div>
        </nav>
        <section class="gallery">
            <div class="gallery__container _container">
                <div class="gallery__content">
                      <div style="display:flex; text-align: center; justify-content: space-between">
                          <h1 class="gallery__title t">Фото галерея</h1>
                          <svg class="gallery__filters-icon-mobile">
                              <use xlink:href="{{ asset('img/sprites/sprite-mono.svg#fil') }}"></use>
                          </svg>
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
                    <div class="filters gallery__filters">
                        <svg class="gallery__filters-icon">
                            <use xlink:href="{{ asset('img/sprites/sprite-mono.svg#fil') }}"></use>
                        </svg>
                        <form class="filters__form" action="#" method="GET">
                            <div class="filters__filterGroup">
                                @foreach($options as $attrName => $attr)
                                    <select class="filters__select" name="attribute_id_{{$count}}">
                                        <option value="">{{$attrName}}</option>
                                        @foreach($attr as $option)
                                            <option class="filters__op" value="{{$option['id']}}"
                                                    @if (in_array($option->id, explode(',', request()->input('attribute_'.$count)))) selected @endif>{{$option['title']}}
                                            </option>
                                        @endforeach
                                    </select>
                                    <p style="display: none">{{$count++}}</p>
                                @endforeach
                            </div>
                            <div class="filters__btnGroup">
                                <input class="filters__btn btn filter" id="filter" type="button"
                                       value="Применить фильтр">
                                {{--<button class="filters__btn btn" type="submit">Показать</button>--}}
                                <a href="{{ \Illuminate\Support\Facades\URL::current() }}">
                                    <button class="filters__btn filters__btn--clear btn" type="button">Сбросить фильтры
                                        <svg>
                                            <use xlink:href="{{ asset('img/sprites/sprite-mono.svg#cloze') }}"></use>
                                        </svg>
                                    </button>
                                </a>
                                <div class="filters__searchBox">
                                    <input class="filters__searchInput" id="searchInput" autocomplete="off" type="text"
                                           name="filter_search"
                                           data-value="Поиск проекта" value="">
                                    <button class="filters__searchBtn" type="submit">
                                        <svg>
                                            <use xlink:href="{{ asset('img/sprites/sprite-mono.svg#search') }}"></use>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                    @isset($search_result_text)
                        <p style="font-size: 3.6rem; margin-bottom: 17px; font-weight: 700;">{{$search_result_text}}</p>
                    @endisset
                    <div class="gallery__body" style="justify-content: flex-start;">
                        @foreach($projects as $project)
                            @include('project._project_item')
                        @endforeach
{{--                        <div class="addBox">--}}
{{--                            <div class="add gallery__add" role="button" tabindex="0">Показать ещё</div>--}}
{{--                        </div>--}}
                    </div>
                </div>
            </div>
        </section>
        <div style="margin: 20px">
@if(count($projects)>0)
                {{ $projects->links('pagination::bootstrap-4') ??''}}
                @include('layouts.pagination')

@endif

        </div>

    </main>
@endsection

<script>
    $(document).ready(function () {
        let href = 'gallery?';
        $(document).on('click', '#filter', function () {
            $('.filters__select').each(function (key, value) {
                let attribute_id = $(`.filters__select[name="attribute_id_${key}"]`).val();
                if (attribute_id.length) {
                    href += `&attribute_${key}=` + attribute_id;
                }
            });
            document.location.href = href;
        })
        $(document).on('click', '.filters__searchBtn', function () {
            if ($('#searchInput').val().length) {
                href += `&search=` + $('#searchInput').val();
            }
            document.location.href = href;
        })
    })
</script>
