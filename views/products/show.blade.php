@extends('layouts.index')
<script
    src="https://code.jquery.com/jquery-3.6.0.min.js"
    integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
    crossorigin="anonymous"></script>
<script src="{{asset('js/owl.carousel.min.js')}}"></script>



@section('content')
    <div class="productContent">
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

                        @if($category)
                            <li class="breadcrumbs__item">
                                <a class="breadcrumbs__link"
                                   href="{{ route('index.products.category', ['category' => $category->slug]) }}">
                                    <span>{{ $category->title }}</span>
                                    <svg>
                                        <use xlink:href="{{ asset('img/sprites/sprite-mono.svg#slideArrow') }}"></use>
                                    </svg>
                                </a>
                            </li>
                        @endif
                        <li class="breadcrumbs__item">
                            <a class="breadcrumbs__link breadcrumbs__link--active" href="#">
                                <span>{{ $product->title }}</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>

            <section class="prodCard">
                <div class="prodCard__container _container">
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
                        <div class="prodCard__content">
                            <div class="prodCard__side">
                                <div class="prodCard__sideBody">
                                    <div class="prodCard__gallery" id="lightgallery">
                                        @if($firstPhoto)
                                            <div class="prodCard__galleryHero">
                                                <a class="prodCard__heroBox ibg"
                                                   href="{{ asset('upload_images/' . $firstPhoto->path) }}"
                                                   data-fslightbox>
                                                    <picture>
                                                        <source type="image/webp"
                                                                srcset="{{ asset('upload_images/' . $firstPhoto->path) }}">
                                                        <img src="{{ asset('upload_images/' . $firstPhoto->path) }}"
                                                             alt="img0">
                                                    </picture>
                                                </a>
                                            </div>
                                        @endif
                                        <div class="prodCard__galleryThumbs">
                                            @foreach($threePhotos as $photo)
                                                <div class="prodCard__thumbsWrp">
                                                    <a class="prodCard__thumbsBox ibg"
                                                       href="{{ asset('upload_images/' . $photo->path) }}"
                                                       data-fslightbox>
                                                        <picture>
                                                            <source type="image/webp"
                                                                    srcset="{{ asset('upload_images/' . $photo->path) }}">
                                                            <img src="{{ asset('upload_images/' . $photo->path) }}"
                                                                 alt="img1">
                                                        </picture>
                                                    </a>
                                                </div>
                                            @endforeach
                                            <div class="prodCard__hiddenImgs">
                                                @foreach($otherPhotos as $photo)
                                                    <a href="{{ asset('upload_images/' . $photo->path) }}"
                                                       data-fslightbox></a>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                    <div class="prodCard__anchors">
                                        <a class="prodCard__anchor _goto-block" href="#char">
                                            Характеристики
                                            <svg>
                                                <use xlink:href="{{ asset('img/sprites/sprite-mono.svg#v2') }}"></use>
                                            </svg>
                                        </a>
                                        @if($product->description)
                                            <a class="prodCard__anchor _goto-block" href="#desc">
                                                Описание
                                                <svg>
                                                    <use
                                                        xlink:href="{{ asset('img/sprites/sprite-mono.svg#v2') }}"></use>
                                                </svg>
                                            </a>
                                        @endif
                                        @if(count($product->files))
                                            <a class="prodCard__anchor _goto-block" href="#docs">
                                                Документация
                                                <svg>
                                                    <use
                                                        xlink:href="{{ asset('img/sprites/sprite-mono.svg#v2') }}"></use>
                                                </svg>
                                            </a>
                                        @endif
                                        @if(count($product->relatedProducts))
                                            <a class="prodCard__anchor _goto-block" href="#crossale">
                                                Сопутствующие товары
                                                <svg>
                                                    <use
                                                        xlink:href="{{ asset('img/sprites/sprite-mono.svg#v2') }}"></use>
                                                </svg>
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <form class="addToCartForm" action="{{ route('index.cart.add') }}" method="POST"
                                  data-product-id="{{ $product->id }}">
                                {{ csrf_field() }}
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <div class="prodCard__body">
                                    <h2 class="prodCard__title" data-da=".prodCard__content, 992, 0">
                                        {{ $product->title }}
                                    </h2>
                                    <div class="prodCard__art">Код товара: {{ $product->vendor_code }}</div>
                                    <div class="prodCard__selBox">

                                        @foreach($productAttributes as $attribute)
                                            @if(count($attribute['options']) > 1)
                                                <div class="prodCard__selRow">
                                            <span class="prodCard__selName">
                                                {{ $attribute['model']->title }}
                                            </span>
                                                    <div class="prodCard__selWrp">
                                                        <select class="prodCard__select"
                                                                name="attribute[{{ $attribute['model']->id }}]">
                                                            @foreach($attribute['options'] as $option)
                                                                <option class="prodCard__op"
                                                                        value="{{ $option['id'] }}">{{ $option->title }}</option>
                                                            @endforeach
                                                        </select>

                                                    </div>
                                                </div>
                                            @endif
                                        @endforeach
                                        <div class="prodCard__selRow">
                                            <span class="prodCard__selName">Тип профиля</span>
                                            <div class="prodCard__selWrp">
                                                <select class="prodCard__select" name="select">

                                                    @if($profile_type[0] != '')
                                                        @foreach($profile_type as $el)
                                                            <option class="prodCard__op" value="value2">{{$el}}</option>
                                                        @endforeach
                                                    @else
                                                        <option class="prodCard__op" value="value2">Пусто</option>
                                                    @endif
                                                </select>
                                                <span class="prodCard__tippy tippy" data-tippy="Просто описание">
                                                                        <svg class="description_popup"
                                                                             id="profile_type_popup">
                                                                            <use
                                                                                xlink:href="{{ asset('img/sprites/sprite-mono.svg#vpr') }}"></use>
                                                                        </svg>
                                                                    </span>
                                            </div>
                                        </div>
                                        <div class="prodCard__selRow"><span
                                                class="prodCard__selName">Производитель</span>
                                            <div class="prodCard__selWrp">
                                                <select class="prodCard__select" name="select">
                                                    @if($manufacturer[0] != '')
                                                        @foreach($manufacturer as $el)
                                                            <option class="prodCard__op" value="value2">{{$el}}</option>
                                                        @endforeach
                                                    @else
                                                        <option class="prodCard__op" value="value2">Пусто</option>
                                                    @endif
                                                </select>
                                                <span class="prodCard__tippy tippy" data-tippy="Просто описание">
                                                                        <svg class="description_popup"
                                                                             id="manufacturer_popup"><use
                                                                                xlink:href="{{ asset('img/sprites/sprite-mono.svg#vpr') }}"></use></svg>
                                                                    </span>
                                            </div>
                                        </div>

                                        <div class="prodCard__selRow">
                                            <span class="prodCard__selName">Толщина листа</span>
                                            <div class="prodCard__selWrp">
                                                <select class="prodCard__select" name="select">
                                                    @if($thickness[0] != '')
                                                        @foreach($thickness as $el)
                                                            <option class="prodCard__op" value="value2">{{$el}}</option>
                                                        @endforeach
                                                    @else
                                                        <option class="prodCard__op" value="value2">Пусто</option>
                                                    @endif
                                                </select>
                                                <span class="prodCard__tippy tippy" data-tippy="Просто описание">
                                                                        <svg class="description_popup"
                                                                             id="thickness_popup">
                                                                            <use
                                                                                xlink:href="{{ asset('img/sprites/sprite-mono.svg#vpr') }}"></use>
                                                                        </svg>
                                                </span>
                                            </div>

                                        </div>
                                        <div class="prodCard__selRow">
                                            <span class="prodCard__selName">Покрытие</span>
                                            <div class="prodCard__selWrp">
                                                <select class="prodCard__select" name="select">
                                                    @if(\App\Models\Coatings::find($product->coatings_id) != null)
                                                        <option class="prodCard__op"
                                                                value="value2">{{\App\Models\Coatings::find($product->coatings_id)['title']}}</option>
                                                    @else
                                                        <option class="prodCard__op" value="value2">Пусто</option>
                                                    @endif
                                                </select>
                                                <span class="prodCard__tippy tippy" data-tippy="Просто описание">
                                                                        <svg class="description_popup"
                                                                             id="coating_popup">
                                                                            <use
                                                                                xlink:href="{{ asset('img/sprites/sprite-mono.svg#vpr') }}"></use>
                                                                        </svg>
                                                                    </span>
                                            </div>
                                        </div>
                                        @if($colorsArray = $product->colorsArray())
                                            <div class="prodCard__colorBox">
                                                <div class="prodCard__name">Цвет</div>
                                                <div class="leftPointer" style="cursor: pointer;margin:auto">
                                                    <img src="{{ asset('img/icons/left-arrow.png') }}"/>
                                                </div>
                                                <div class="wrp-colorsSlider">
                                                    <div class="swiper-container colorsSlider _swiper" id="content">
                                                        <div class="swiper-wrapper colorsSlider__wrapper">
                                                            <input type="hidden" name="color"
                                                                   @if($colorsArray && $colorsArray[0]) value="{{ $colorsArray[0]['ral'] }}" @endif>
                                                            @foreach($colorsArray as $index => $item)
                                                                <div class="swiper-slide colorsSlider__slide">
                                                                    <div class="prodCard__colorWrp">
                                                                        <div
                                                                            class="prodCard__color @if($index ==0) selected @endif "
                                                                            data-color="{{$item['ral']}}"
                                                                            style="background-color: {{ $item['rgb'] }} ">
                                                                            <span>RAL {{ $item['ral'] }}</span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endforeach

                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="rightPointer" style="cursor: pointer;margin:auto">
                                                    <img src="{{ asset('img/icons/right-arrow.png') }}"/>
                                                </div>
                                            </div>
                                        @endif

                                        @if($product->list_width_useful)
                                            <div class="prodCard__stockParameter">
                                                <div class="prodCard__name">Ширина листа полезная</div>
                                                <div
                                                    class="prodCard__parameterData">{{ $product->millsToText('list_width_useful') }}</div>
                                            </div>
                                        @endif
                                        @if($product->list_width_full)
                                            <div class="prodCard__stockParameter">
                                                <div class="prodCard__name">Ширина листа полная</div>
                                                <div
                                                    class="prodCard__parameterData">{{ $product->millsToText('list_width_full') }}</div>
                                            </div>
                                        @endif

                                        @if($product->custom_length_from || $product->custom_length_to)
                                            <div class="prodCard__stockParameter">
                                                <div class="prodCard__name">Длины на заказ</div>
                                                <div class="prodCard__parameterData">
                                                    @if($product->custom_length_from)
                                                        от {{ $product->millsToText('custom_length_from') }}
                                                    @endif

                                                    @if($product->custom_length_to)
                                                        до {{ $product->millsToText('custom_length_to') }}
                                                    @endif
                                                </div>
                                            </div>
                                        @endif
                                        @if($product->min_square_meters)
                                            <div class="prodCard__stockParameter">
                                                <div class="prodCard__name">Минимальная площадь заказа</div>
                                                <div class="prodCard__parameterData">{{ $product->min_square_meters }}
                                                    м²
                                                </div>
                                            </div>
                                        @endif

                                        <div class="prodCard__controlsBox">
                                            <div class="prodCard__controls">

                                                <div class="card__icons" style="margin-right:30px;">
                                                    <div
                                                        class="card__icon card__icon--like addTo {{ product_id_in_list($product->id, 'favorites') ? 'active' : '' }}"
                                                        data-destination="Favorites" role="button" tabindex="0">
                                                        <svg>
                                                            <use
                                                                xlink:href="{{ asset('img/sprites/sprite-mono.svg#heart') }}"></use>
                                                        </svg>
                                                    </div>
                                                    <div
                                                        class="card__icon card__icon--stat addTo {{ product_id_in_list($product->id, 'compare') ? 'active' : '' }}"
                                                        data-destination="Compare" role="button" tabindex="0">
                                                        <svg>
                                                            <use
                                                                xlink:href="{{ asset('img/sprites/sprite-mono.svg#stat') }}"></use>
                                                        </svg>
                                                    </div>
                                                </div>

                                                <script src="https://yastatic.net/share2/share.js"></script>
                                                <div class="ya-share2" data-curtain data-limit="0"
                                                     data-more-button-type="short"
                                                     style="background:transparent"
                                                     data-services="vkontakte,facebook,odnoklassniki,telegram,twitter,viber,whatsapp"></div>

                                            </div>
                                            <div class="prodCard__price">

                                                @if($product->is_promo)
                                                    <span>
                                            <span
                                                style="text-decoration: line-through; color: #2d3033ab; font-size: 24px">
                                             {{ $product->price }} ₽/{{\App\Models\UnitsOfProducts::where('id',$product->unit_id)->first()->title??'шт.'}}
                                            </span>
                                                        </br>
                                            {{ $product->promo_price }} ₽/{{\App\Models\UnitsOfProducts::where('id',$product->unit_id)->first()->title??'шт.'}}
                                        </span>
                                                @else

                                                    <span>
                                             {{ $product->price }} ₽/{{\App\Models\UnitsOfProducts::where('id',$product->unit_id)->first()->title??'шт.'}}
                                            </span>
                                                @endif
                                            </div>
                                        </div>

                                        @if($product->is_promo)
                                            <div id="productCalc" class="productCalc"
                                                 data-width="{{ $product->list_width_useful }}"
                                                 data-price="{{$product->promo_price  }}">
                                                @else
                                                    <div id="productCalc" class="productCalc"
                                                         data-width="{{ $product->list_width_useful }}"
                                                         data-price="{{ $product->price }}">
                                                        @endif



                                                        @if($product->show_calculator)
                                                            <div class="productCalc__body">
                                                                @if($product->length_list)
                                                                    <div
                                                                        class="productCalc__col productCalc__col--long">
                                                                        <div class="productCalc__named">Выберите длину
                                                                        </div>
                                                                        <select class="productCalc__select lengthSelect"
                                                                                name="length"
                                                                                id="length">
                                                                            @foreach($product->getLengthList() as $length)
                                                                                <option class="productCalc__op"
                                                                                        value="{{ $length }}">{{ $length }}
                                                                                    мм
                                                                                </option>
                                                                            @endforeach

                                                                        </select>

                                                                    </div>
                                                                    <div >
                                                                        <div style="color: rgba(0, 107, 222, 1)">+</div>
                                                                        <div> Добавить лист другой длины</div>
                                                                    </div>
                                                                @endif
                                                                <div class="productCalc__col productCalc__col--count">
                                                                    <div class="productCalc__named">Количество</div>
                                                                    <div class="productCalc__counter">
                                                                        <div
                                                                            class="productCalc__counterBtn productCalc__counterBtn--minus">
                                                                            -
                                                                        </div>
                                                                        <input class="productCalc__inpCount"
                                                                               id="countToAdd"
                                                                               autocomplete="off" type="text"
                                                                               name="quantity"
                                                                               data-value="1">
                                                                        <div
                                                                            class="productCalc__counterBtn productCalc__counterBtn--plus">
                                                                            +
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="productCalc__col productCalc__col--total">
                                                                    <div class="productCalc__named">Итого:<span>за <b
                                                                                id="totalSquare">0</b> м²</span>
                                                                    </div>
                                                                    <input type="hidden" name="totalSquare"
                                                                           id="totalSquareInput" value="">
                                                                    <div class="productCalc__result">= <b
                                                                            id="totalPrice">0</b>
                                                                        ₽
                                                                    </div>
                                                                    <input type="hidden" name="totalPrice"
                                                                           id="totalPriceInput"
                                                                           value="">
                                                                </div>
                                                            </div>
                                                        @else

                                                            <div class="productCalc__body">
                                                                <div class="productCalc__col productCalc__col--count">
                                                                    <div class="productCalc__named">Количество</div>
                                                                    <div class="productCalc__counter">
                                                                        <div
                                                                            class="productCalc__counterBtn productCalc__counterBtn--minus">
                                                                            -
                                                                        </div>
                                                                        <input class="productCalc__inpCount"
                                                                               id="countToAdd"
                                                                               autocomplete="off" type="text"
                                                                               name="quantity"
                                                                               data-value="1">
                                                                        <div
                                                                            class="productCalc__counterBtn productCalc__counterBtn--plus">
                                                                            +
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="productCalc__col productCalc__col--total"
                                                                     style="margin-top:42px;">
                                                                    <div class="productCalc__result">= <b
                                                                            id="totalPrice">0</b>
                                                                        ₽
                                                                    </div>
                                                                    <input type="hidden" name="totalPrice"
                                                                           id="totalPriceInput"
                                                                           value="">
                                                                </div>
                                                            </div>

                                                        @endif


                                                        <div class="productCalc__info">
                                                            Этот расчёт предварительный. Для точного расчёта рекомендуем
                                                            проконсультироваться с нашим инженером. Консультация
                                                            бесплатна.
                                                            Также вы можете
                                                            сделать расчёт по листам
                                                        </div>

                                                        <div class="productCalc__btnGroup">

                                                            <div class="productCalc__btnWrp">
                                                                <a class="addToCartButton">
                                                                    <div
                                                                        class="productCalc__btn btn popup-link addToCartLink"
                                                                        role="button"
                                                                        tabindex="0" href="#cart">В корзину
                                                                    </div>
                                                                </a>
                                                            </div>

                                                            <input type="hidden" name="width"
                                                                   value="{{ $product->list_width_useful }}">
                                                            <input type="hidden" name="price"
                                                                   value="{{ $product->price }}">
                                                            <div class="productCalc__btnWrp">
                                                                <div class="productCalc__btn btn popup-link"
                                                                     role="button"
                                                                     href="#buy"
                                                                     tabindex="0">
                                                                    Купить в 1 клик
                                                                </div>
                                                            </div>
                                                            <div class="productCalc__btnWrp">
                                                                <div class="productCalc__btn btn popup-link"
                                                                     role="button"
                                                                     href="#consult"
                                                                     tabindex="0">
                                                                    Заказать консультацию
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="prodCard__chars">
                                                        <h3 class="prodCard__subtitle char">Характеристики</h3>
                                                        <div class="prodCard__charsBody">
                                                            @foreach($productAttributes as $productAttribute)
                                                                @if(count($productAttribute['options']) == 1)
                                                                    <div class="prodCard__charsRow">
                                                    <span class="prodCard__charsRowName">
                                                        {{ $productAttribute['model']->title }}
                                                    </span>
                                                                        <span class="prodCard__charsRowData">
                                                         {{ $productAttribute['options'][0]->title }}
                                                    </span>
                                                                    </div>
                                                                @endif
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                    <div class="prodCard__desc">
                                                        <h3 class="prodCard__subtitle desc">Описание</h3>
                                                        <div class="prodCard__descBody">
                                                            <div class="prodCard__descBenefits">

                                                                {!! $product->description !!}
                                                            </div>
                                                        </div>
                                                        @if(count($product->files))
                                                            <div class="prodCard__docs">
                                                                <h3 class="prodCard__subtitle docs">Документация</h3>
                                                                <div class="prodCard__docsBody">
                                                                    @foreach($product->files as $index=>$file)
                                                                        <div class="prodCard__docsItemWrp">
                                                                            <div class="prodCard__docsItem">
                                                                                <div class="prodCard__docsSvgBox">
                                                                                    <svg
                                                                                        @if($index==0) style="position:relative;right:3px;" @endif>
                                                                                        <use
                                                                                            xlink:href="{{ asset('img/sprites/sprite-mono.svg#doc1') }}"></use>
                                                                                    </svg>
                                                                                </div>
                                                                                <a class="prodCard__docsName link"
                                                                                   href="{{ asset('upload_files/' . $file->filepath) }}">{{ $file->title }}</a>
                                                                            </div>
                                                                        </div>
                                                                    @endforeach
                                                                </div>
                                                            </div>
                                                        @endif
                                                    </div>
                                            </div>
                                    </div>
                                </div>


                            </form>
                        </div>
                    </div>
                </div>
            </section>

            @if(count($viewedProducts) > 0)
                <section class="newItems lastview">
                    <div class="newItems__container _container">
                        <div class="newItems__content">
                            <div class="newItems__body">
                                <div class="newItems__controlPanel">
                                    <h2 class="newItems__title t">Недавно посмотренные </h2>
                                    <div class="newItems__sliderBtns">
                                        <div class="newItems__sliderBtn newItems__sliderBtn--prev" role="button"
                                             tabindex="0">
                                            <svg>
                                                <use
                                                    xlink:href="{{ asset('img/sprites/sprite-mono.svg#slideArrow') }}"></use>
                                            </svg>
                                        </div>
                                        <div class="newItems__sliderBtn newItems__sliderBtn--next" role="button"
                                             tabindex="0">
                                            <svg>
                                                <use
                                                    xlink:href="{{ asset('img/sprites/sprite-mono.svg#slideArrow') }}"></use>
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                                <div class="wrp-itemsSlider">
                                    <div class="swiper-container itemsSlider _swiper">
                                        <div class="swiper-wrapper itemsSlider__wrapper">
                                            @foreach($viewedProducts as $sliderProduct)
                                                @include('products._block_item')
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            @endif

            <section class="newItems analogs">
                <div class="newItems__container _container">
                    <div class="newItems__content">
                        <div class="newItems__body">
                            <div class="newItems__controlPanel">
                                <h2 class="newItems__title t">Аналогичные товары</h2>
                            </div>
                            <div class="wrp-itemsSlider">
                                <div class="swiper-container owl-carousel itemsSlider">
                                    <div class="swiper-wrapper itemsSlider__wrapper">

                                        @foreach($product->similarProducts as $sliderProduct)
                                            @include('products._block_item')
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            @if(count($product->relatedProducts))
                <section class="newItems crossale">
                    <div class="newItems__container _container">
                        <div class="newItems__content">
                            <div class="newItems__body">
                                <div class="newItems__controlPanel">
                                    <h2 class="newItems__title t">Сопутствующие товары</h2>
                                </div>
                                <div class="wrp-itemsSlider">
                                    <div class="swiper-container owl-carousel itemsSlider">
                                        <div class="swiper-wrapper itemsSlider__wrapper">
                                            @foreach($product->relatedProducts as $sliderProduct)
                                                @include('products._block_item')
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            @endif

            @include('general._add_to_cart')
            @include('general._benefits')

        </main>


        @include('products._docs_modal')
        @include('products._modal_consult')
        @include('products._modal_buy')
        @include('products._cart_modal')
        @include('products.product_description_modal')
    </div>
    <style>

        @media screen and (max-width: 900px) {
            .productContent {
                padding: 20px;
                max-width: 100% !important;
            }

            .addToCartForm {
                width: 100%;
            }

            .productCalc {

                max-width: 100% !important;
            }
            .analogs{
                max-width: 100%;
            }
            .crossale{
                max-width: 100%;
            }
            .benefits{
                max-width: 100%;
            }
            .lastview{
                max-width: 100%;
            }
    .footer__bottom::before{
        max-width: 100%;
    }

            .prodCard__descBenefits {
                max-width: 70%;
                padding: 20px;
            }
        }

    </style>
@endsection
<script>
    $(document).ready(function () {
        $(".owl-carousel").owlCarousel();
        $(document).on('click', '.description_popup', function () {
            if ($(this).attr('id') == 'profile_type_popup') $('.popup_profile_type_description').addClass('_active')
            if ($(this).attr('id') == 'manufacturer_popup') $('.popup_manufacturer_description').addClass('_active')
            if ($(this).attr('id') == 'thickness_popup') $('.popup_thickness_description').addClass('_active')
            if ($(this).attr('id') == 'coating_popup') $('.popup_coating_description').addClass('_active')
        })
    });

    //     $('select').on('change', function () {
    //
    //         if (this.value == 0) {
    //             console.log('im here 0')
    //             document.getElementById('customLength').classList.remove('hidden')
    //         } else {
    //             document.getElementById('customLength').classList.add('hidden')
    //         }
    //     });
    // });
    // changeOptionLength = function () {
    //     let x = document.getElementById("inputLength").value;
    //     $('#length').val(x)
    //     console.log(  $('#length').val())
    // };

</script>
{{--<style>--}}
{{--    .hidden {--}}
{{--        display: none;--}}
{{--    }--}}
{{--</style>--}}
