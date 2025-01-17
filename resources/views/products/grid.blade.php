@extends('layouts.index')

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
                            <span>{{ $title }}</span>
                            <svg>
                                <use xlink:href="{{ asset('img/icons/blue-play.svg#blue-play') }}"></use>
                            </svg>
                        </a>
                    </li>
                </ul>
            </div>
        </nav>
        <section class="productsTmp">
            <div class="productsTmp__container _container">
                <div class="productsTmp__content">
                    <h1 class="productsTmp__title t">
                        {{ $title }}
                    </h1>
                    <div class="cooperation__body sideDashContainer">
                        @if(count($products) > 0)
                            @if($pageType === 'favorites')
                                <!--------------- -->
                                <form class="basket__grid" action="#" method="post" onsubmit="return false">
                                    <div class="basket__body">
                                        @foreach($products as $index => $product)
                                            <div
                                                id="favorite_card_{{$product->id}}{{$product->length ? 'length_'.$product->length : ''}}"
                                                data-total="{{ $product->total_price }}"
                                                data-qtty="{{ $product->quantity }}"
                                                data-square="{{ $product->square }}"
                                                data-id="{{$product->id}}"
                                                data-price="{{ $product->is_promo ?  $product->promo_price :  $product->price }}"
                                                data-length="{{ $product->length }}"
                                                data-total-square="{{ $product->total_square }}"
                                                data-start-price-promo="{{ $product->is_promo ?  $product->promo_price : 0 }}"
                                                data-start-price="{{ $product->price }}"
                                                data-attribute-prices="{{$product->attribute_prices ? $product->attribute_prices : 0}}"
                                                data-color="{{ $product->color }}"
                                                data-width="{{ $product->list_width_useful }}"

                                                class="favorite__card "
                                                style="{{$index===0? 'margin-bottom: 25px ':' '}}"
                                            >
                                                <div class="basket__cardBody">
                                                    <div class="checkbox" style="margin-top: 1rem; margin-right: 1rem;">
                                                        <input
                                                            class="checkbox__input fav-checkbox"
                                                            id="favcheckbox_{{$product->id}}"
                                                            data-product-id="{{$product->id}}"
                                                            autocomplete="off"
                                                            type="checkbox"
                                                        >
                                                        <label class="checkbox__label link" for="favcheckbox_{{$product->id}}"></label>
                                                    </div>
                                                    <div class="basket__cardImgBox">
                                                        <a class="basket__cardImgWrp ibg"
                                                           href="#">
                                                            <picture>
                                                                {{--                                                                <source type="image/webp" srcset="./img/history/h.webp">--}}
                                                                <img
                                                                    src="{{ $product->mainPhotoPath() }}"
                                                                    alt="h">
                                                            </picture>
                                                        </a>
                                                    </div>
                                                    <div class="basket__combinedContainer">
                                                        <div class="basket__cardDesc">
                                                            <div class="basket__cardTitle link">
                                                                <a href="#"
                                                                   style="margin: auto;">
                                                                    {{ $product->title }}
                                                                </a>
                                                            </div>

                                                            <div class="productCalc__col--desc">
                                                                @if (!empty($product->color))
                                                                    Цвет: {{ $product->color }}
                                                                @endif
                                                                @if (!empty($product->color) && (!empty($product->length) || !empty($product->width) || !empty($product->square)))
                                                                    /
                                                                @endif

                                                                @if (!empty($product->length))
                                                                    Длина: {{ $product->length }}
                                                                @endif
                                                                @if (!empty($product->length) && (!empty($product->width) || !empty($product->square)))
                                                                    /
                                                                @endif

                                                                @if (!empty($product->width))
                                                                    Толщина: {{ $product->width }}
                                                                @endif
                                                                @if (!empty($product->width) && !empty($product->square))
                                                                    /
                                                                @endif

                                                                @if (!empty($product->square))
                                                                    Площадь: {{ $product->square }}
                                                                @endif
                                                            </div>
                                                        </div>
                                                        {{--                                                        <div id="total_square_{{$product->id}}"--}}
                                                        {{--                                                             class="total__square"--}}
                                                        {{--                                                             style="margin: auto;"></div>--}}
                                                        <div class="basket__cardPrice"
                                                             style="align-content: center">

                                                            {{ $product->is_promo ?  $product->promo_price :  $product->price }}
                                                            ₽ @if($product->show_calculator)
                                                                /м2
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="productCalc__col--wrp">
                                                    <div class="productCalc__col productCalc__col--count">
                                                        <div class="productCalc__named">Количество</div>
                                                        <div class="productCalc__counter">
                                                            <div
                                                                data-prod="{{$product->id}}{{$product->length ? 'length_'.$product->length : ''}}"
                                                                class="productCalc__counterBtn productCalc__counterBtn--minus">
                                                                -
                                                            </div>

                                                            <input
                                                                data-prod="{{$product->id}}{{$product->length ? 'length_'.$product->length : ''}}"
                                                                class="productCalc__inpCount"
                                                                autocomplete="off"
                                                                type="text"
                                                                name="form[]"
                                                                data-value="{{ $product->quantity }}"
                                                                value="{{ $product->quantity }}">
                                                            <div
                                                                data-prod="{{$product->id}}{{$product->length ? 'length_'.$product->length : ''}}"
                                                                class="productCalc__counterBtn productCalc__counterBtn--plus">
                                                                +
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="productCalc__col productCalc__col--total">
                                                        <div class="productCalc__named">
                                                            Итого: {{--<span>за 0.543 м2</span>--}} </div>
                                                        <div
                                                            id="prod_total_{{$product->id}}{{$product->length ? 'length_'.$product->length : ''}}"
                                                            class="productCalc__result">
                                                            = {{ number_format($product->total_price,2) }}₽
                                                        </div>
                                                    </div>
                                                    <div class="deleteBut deleteBut__moreOne"
                                                         id="deleteButtonId"
                                                         data-product-id="{{ $product->id }}" role="button"
                                                         tabindex="0">
                                                        <input type="hidden" name="sessionId"
                                                               value="{{$product->productSessionId}}">
                                                        <svg>
                                                            <use
                                                                xlink:href="{{ asset('/img/sprites/sprite-mono.svg#cloze') }}"></use>
                                                        </svg>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    <div class="basket__side">
                                        <div class="basket__sideBox">
                                            <div class="basket__sideName">Сумма заказа</div>
                                            <div class="basket__sideRow">
                                                <div class="basket__sideTitle">Всего товаров</div>
                                                <div class="basket__sideData basket__sideData--prod">
                                                    {{ $totalQuantity }}
                                                </div>
                                            </div>
                                            <div class="basket__sideRow">
                                                <div class="basket__sideTitle">Общая стоимость</div>
                                                <div class="basket__sideData basket__sideData--price">
                                                    {{ number_format($totalPrice, 2) }} ₽
                                                </div>
                                            </div>
                                            <div class="favorite__sideBtns">
                                                <a href="#">
                                                    <div id="moveToCart" class="basket__cart btn" role="button"
                                                         data-total="{{ $product->total_price }}"
                                                         data-qtty="{{ $product->quantity }}"
                                                         data-square="{{ $product->square }}"
                                                         data-id="{{$product->id}}"
                                                         data-price="{{ $product->is_promo ?  $product->promo_price :  $product->price }}"
                                                         data-length="{{ $product->length }}"
                                                         data-total-square="{{ $product->total_square }}"
                                                         data-start-price-promo="{{ $product->is_promo ?  $product->promo_price : 0 }}"
                                                         data-start-price="{{ $product->price }}"
                                                         data-attribute-prices="{{$product->attribute_prices ? $product->attribute_prices : 0}}"
                                                         data-color="{{ $product->color }}"
                                                         data-width="{{ $product->list_width_useful }}"
                                                         tabindex="0">
                                                        Переместить в корзину
                                                    </div>
                                                </a>

                                                <a href="#">
                                                    <div id="deleteSelected" class="basket__delete btn" role="button" tabindex="0">
                                                        Удалить выбранные товары (0)
                                                    </div>
                                                </a>

                                                <a href="#">
                                                    <div class="basket__deleteAll btn" role="button"
                                                         tabindex="0">
                                                        Удалить все товары
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                <!--------------- -->
                            @elseif($pageType === 'viewed')
                                <div class="productsTmp__body" id="data-wrapper">
                                    @foreach($products as $product)
                                        @include('products._product_item')
                                    @endforeach
                                </div>
                            @endif
                        @else
                            <div class="empty__block">
                                <div class="empty__block-info">
                                    <h1 class="empty__title">
                                        @if($pageType === 'favorites')
                                            Ваш список избранных товаров пока что пуст
                                        @elseif($pageType === 'viewed')
                                            Ваш список просмотренных товаров пока что пуст
                                        @endif
                                    </h1>
                                    <p class="empty__text">
                                        @if($pageType === 'favorites')
                                            Выберите в каталоге несколько интересующих товаров и нажмите кнопку
                                            «добавить в избранное»
                                        @elseif($pageType === 'viewed')
                                            Здесь будут появляться недавно просмотренные товары
                                        @endif
                                    </p>
                                    <a class="btn btn-primary" href="{{ url('/posts/katalog') }}">
                                        Перейти в каталог
                                    </a>
                                </div>
                                <img src="img/emptyProducts/package.png" alt="empty-products">
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </section>
    </main>

    <style>

        .deleteBut {
            top: 0;
            right: 20px;
            transform: translateY(-50%);
            -webkit-user-select: none;
            -moz-user-select: none;
            user-select: none;

            flex: 1;
            display: flex;
            justify-content: end;
        }

        .deleteBut svg {
            width: 20px;
            height: 20px;
            fill: none;
            stroke: #e0e0e0;
            stroke-width: 1px;
            transition: .2s ease
        }

        .productCalc__result {
            top: 0 !important;
        }

        .productCalc__col--count {
            text-align: start;
        }

        .productCalc__col--desc {
            flex: 0 1 40%;
        }

        @media screen and (max-width: 767.98px) {
            .productCalc__col--desc {
                flex: 0 1 90%;
                order: 1;
            }

            .deleteBut__moreOne {
                order: 2;
            }

            .deleteBut {
                transform: none;
                position: absolute;
                right: 10px;
                top: 10px;
            }

            .productCalc__col--count {
                order: 3;
                flex: 1;
            }

            .productCalc__col--total {
                order: 4;
                margin-left: 20px !important;
            }

            .total__square {
                margin: 0 !important;
            }
        }

        @media (max-width: 991.98px) {
            .checkbox {
                display: flex;
                align-items: center;
                order: 3;
                margin: 0 !important;
            }
        }
    </style>
    <script>
        function updateDeleteButtonText() {
            let selectedCount = $('.fav-checkbox:checked').length;
            $('#deleteSelected').text(`Удалить выбранные товары (${selectedCount})`);
        }

        $(document).on("change", ".productCalc__inpCount", function () {

            calculatePrice2($(this).data('prod'), $(this).val());
        });

        $(document).on("click", ".productCalc__counterBtn--plus, .productCalc__counterBtn--minus", function () {

            calculatePrice2($(this).data('prod'), $('.productCalc__inpCount[data-prod="' + $(this).data('prod') + '"]').val());
        });

        $(document).on('change', '.fav-checkbox', function () {
            updateDeleteButtonText();
        });

        function calculatePrice2(num, qtty) {

            qtty = qtty < 0 ? 1 : qtty;
            let price = $('#favorite_card_' + num).data('price');
            let length = $('#favorite_card_' + num).data('length') ? $('#favorite_card_' + num).data('length') / 1000 : 1;
            let width = $('#favorite_card_' + num).data('width') ? $('#favorite_card_' + num).data('width') / 1000 : 1;
            let calculatedPrice = price * qtty * length * width;


            $('#prod_total_' + num).text('= ' + calculatedPrice.toFixed(2) + '₽');
            $('#favorite_card_' + num).data('total', calculatedPrice.toFixed(2));
            $('#favorite_card_' + num).data('qtty', qtty);


            let total = 0;
            let qtty_ = 0;
            $('.favorite__card').each(function () {
                ;
                total += $(this).data('total') ? parseFloat($(this).data('total')) : 0;
                qtty_ += $(this).data('qtty') ? parseInt($(this).data('qtty')) : 0;
            });
            $('.basket__sideData--price').text(total.toFixed(2) + ' ₽');
            $('.basket__sideData--prod').text(qtty_);


            $.ajax({
                type: "GET",
                url: '/favorites/change',
                data: 'product_id=' + num + '&qtty=' + qtty,
                success: function (response) {

                },
            });

            calculateSquare();
        }

        calculateSquare();

        function calculateSquare() {
            let square = [];
            $('.favorite__card').each(function () {

                let plus = $(this).data('square') * $(this).data('qtty');
                square[$(this).data('id')] = square[$(this).data('id')] ? square[$(this).data('id')] + plus : plus;
            });
            if (square) {
                $.each(square, function (key, value) {
                    $('#total_square_' + key).text(parseFloat(value).toFixed(2) + '/м2');
                });
            }
        }

        window.onload = () => {
            $(".deleteBut").on('click', function () {
                const productId = $(this).data('product-id');

                let data = {
                    '_token': $('meta[name="csrf_token"]').attr('content'),
                    'product_id': productId,
                    'active': 1,
                }
                $.ajax({
                    url: '/addToFavorites',
                    data: data,
                    type: "POST",
                })
                    .done(function () {
                        location.reload()
                    })
            });

            $(".basket__deleteAll").on('click', function () {
                let data = {
                    '_token': $('meta[name="csrf_token"]').attr('content'),
                };

                $.ajax({
                    url: '/favorites/clear',
                    data: data,
                    type: "POST",
                })
                    .done(function (response) {
                        location.reload();
                    })
            });
        };

        $('#deleteSelected').on('click', function () {
            let selectedProducts = [];
            $('.fav-checkbox:checked').each(function () {
                selectedProducts.push($(this).data('product-id'));
            });

            if (selectedProducts.length === 0) {
                showNotification('error', 'Выберите товары для удаления.')
                return;
            }

            let data = {
                '_token': $('meta[name="csrf_token"]').attr('content'),
                'product_ids': selectedProducts
            };

            $.ajax({
                url: '/favorites/deleteSelected',
                data: data,
                type: 'POST',
            })
                .done(function (response) {
                    location.reload();
                })
                .fail(function (error) {
                    showNotification('error', 'Не удалось удалить выбранные товары. Попробуйте снова.')
                });
        });

        $('#moveToCart').on('click', function () {
            let productsData = [];

            $('.favorite__card').each(function () {
                let productId = $(this).data("id");
                let quantity = $(this).data("quantity") || 1;
                let startPrice = $(this).data("start-price") || 0;
                let startPricePromo = $(this).data("start-price-promo") || 0;
                let price = $(this).data("price") || 0;
                let totalSquare = $(this).data("total-square") || 0;
                let length = $(this).data("length") || null;
                let attributePrices = $(this).data("attribute-prices") || 0;
                let color = $(this).data("color") || null;
                let width = $(this).data("width") || null;

                let totalPrice = totalSquare > 0
                    ? ((price + attributePrices) * totalSquare).toFixed(2)
                    : ((price + attributePrices) * quantity).toFixed(2);

                productsData.push({
                    product_id: productId,
                    totalPrice: totalPrice,
                    price: price,
                    startprice: startPrice,
                    startpricepromo: startPricePromo,
                    attribute_prices: attributePrices,
                    color: color,
                    totalSquare: totalSquare,
                    length: length,
                    quantity: quantity,
                    width: width
                });
            });

            $.ajax({
                url: '/moveFavoritesToCart',
                method: 'POST',
                data: {
                    '_token': $('meta[name="csrf_token"]').attr('content'),
                    'products': productsData
                },
                success: function (response) {
                    if (response.status === 'success') {
                        location.reload();
                    } else {
                        showNotification('error', 'Не удалось переместить товары. Попробуйте снова.');
                    }
                },
                error: function (xhr) {
                    showNotification('error', 'Не удалось переместить товары. Попробуйте снова.');
                }
            });
        });

        updateDeleteButtonText();

        function countersInit() {
            const counters = document.querySelectorAll('.productCalc__counter');

            if (counters.length === 0) {
                return;
            }

            for (const counter of counters) {
                const minus = counter.querySelector('.productCalc__counterBtn--minus');
                const plus = counter.querySelector('.productCalc__counterBtn--plus');
                const input = counter.querySelector('.productCalc__inpCount');

                if (!minus || !plus || !input) {
                    continue;
                }

                plus.addEventListener('click', () => {
                    const currentValue = parseInt(input.value) || 0;
                    input.value = currentValue + 1;
                });

                minus.addEventListener('click', () => {
                    const currentValue = parseInt(input.value) || 0;
                    if (currentValue > 1) {
                        input.value = currentValue - 1;
                    }
                });

                input.addEventListener('blur', () => {
                    const currentValue = parseInt(input.value) || 0;
                    input.value = currentValue < 1 ? 1 : currentValue;
                });
            }
        }

        document.addEventListener('DOMContentLoaded', countersInit);
    </script>
@endsection
