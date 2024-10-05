@extends('layouts.index')
@include('cart.success_modal')

@section('content')
    <main class="page">
        <nav class="breadcrumbs">
            <div class="breadcrumbs__container _container">
                <ul class="breadcrumbs__list">
                    <li class="breadcrumbs__item"><a class="breadcrumbs__link" href="{{ route('index.home') }}"><span>Главная</span>
                            <svg>
                                <use xlink:href="{{ asset('/img/sprites/sprite-mono.svg#slideArrow') }}"></use>
                            </svg>
                        </a></li>
                    <li class="breadcrumbs__item"><a class="breadcrumbs__link breadcrumbs__link--active" href="#"><span>Корзина</span></a>
                    </li>
                </ul>
            </div>
        </nav>
        <section class="basket">
            @if (session()->has('message'))
                <div id="myModal" class="modal fade" role="dialog"
                     style="width: 350px;height: 207px;border-radius: 5px">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <h3>Ваш заказ успешно оформлен!</h3>
                            <svg xmlns="http://www.w3.org/2000/svg" width="160" height="160" fill="currentColor"
                                 class="bi bi-check" viewBox="0 0 16 16" style="margin-left: 39px">
                                <path
                                        d="M10.97 4.97a.75.75 0 0 1 1.07 1.05l-3.99 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.267.267 0 0 1 .02-.022z"/>
                            </svg>
                        </div>
                    </div>
                </div>
            @endif
            @if(session()->has('error'))
                    <div id="myModal2" class="modal fade" role="dialog"
                         style="width: 350px;height: 207px;border-radius: 5px">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <h3>{{ session('error') }}</h3>
                            </div>
                        </div>
                    </div>
                @endif
            <div class="basket__container _container">
                <div class="basket__content">
                    <h2 class="basket__title t">Корзина</h2>
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
                        <form class="basket__grid" action="#" method="post" onsubmit="return false">
                            <div class="basket__body">

                                @foreach($cart->getFormattedCart() as $position)
                                    @if (count($position)>1)
                                        @foreach($position  as $index => $item)

                                            @php

                                                $category = $item->product->categories()->first();
                                              $link=  route('index.products.show', ['product' => $item->product->slug, 'category' => $category->slug]);
    //                                        @endphp
                                            <div id="backet_card_{{$item->product_id}}{{$item->options['length'] ? 'length_'.$item->options['length'] : ''}}"
                                                 data-price="{{$item->options['price']}}"data-total="{{ $item->total_price }}"
                                                 data-qtty="{{ $item->quantity }}"
                                                 data-length="{{ $item->options['length'] }}"
                                                 data-width="{{ $item->options['width'] }}"
                                                 data-square="{{ $item->options['square'] }}"
                                                 data-id="{{$item->product_id}}"
                                                 class="basket__card "
                                                 style="{{$index===0? 'background-color: #f6f6f6; padding: 15px;margin-bottom: 15px ':' '}}"
                                                    {{--                                                     style=" background-color: #f6f6f6; padding: 15px;margin-bottom: 15px"--}}
                                                    {{--                                                @endif--}}
                                            >
                                                <div class="basket__cardBody">
                                                    @if ($index===0)
                                                        <div class="basket__cardImgBox">
                                                            <a class="basket__cardImgWrp ibg"
                                                               href="{{ $link}}">

                                                                <picture>
                                                                    {{--                                                                <source type="image/webp" srcset="./img/history/h.webp">--}}
                                                                    <img src="{{ $item->product->mainPhotoPath() }}"
                                                                         alt="h">
                                                                </picture>
                                                            </a>
                                                        </div>
                                                        <div class="basket__cardDesc">
                                                            <div class="basket__cardTitle link">
                                                                <a href="{{ $link }}" style="margin: auto;">
                                                                    {{ $item->product->title }}
                                                                </a>
                                                            </div>
                                                            @endif

                                                            @php
                                                                $cartService=new \App\Services\Shop\CartFormattedService();
                                                                $totalInfo=  $cartService->getFormattedOptionsText($item->options,true,$position);
                                                                $attributes=  $cartService->getFormattedOptionsText($item->options,false,$position);
                                                            @endphp
                                                        </div>
                                                        @if($index===0)
                                                            <div id="total_square_{{$item->product_id}}"
                                                                 style="margin: auto;"></div>
                                                            <div class="basket__cardPrice"
                                                                 style="align-content: center">

                                                                {{ $item->options['price'] }}
                                                                ₽ @if($item->product->show_calculator)
                                                                    /м2
                                                                @endif
                                                            </div>
                                                        @endif
                                                </div>
                                                <div style="display:flex;align-items: center;text-align: center">

                                                    <div>{{ $attributes}}</div>
                                                    <div class="basket__cardPrice" style="padding: 4px">


                                                            {{ $item->options['price'] }}
                                                            ₽ @if($item->product->show_calculator)
                                                                /м2
                                                            @endif

                                                    </div>

                                                    <div class="productCalc__col productCalc__col--count">
                                                        <div class="productCalc__named">Количество</div>
                                                        <div class="productCalc__counter">
                                                            <div data-prod="{{$item->product_id}}{{$item->options['length'] ? 'length_'.$item->options['length'] : ''}}"
                                                                 class="productCalc__counterBtn productCalc__counterBtn--minus">
                                                                -
                                                            </div>

                                                            <input data-prod="{{$item->product_id}}{{$item->options['length'] ? 'length_'.$item->options['length'] : ''}}"
                                                                   class="productCalc__inpCount" autocomplete="off"
                                                                   type="text"
                                                                   name="form[]"
                                                                   data-value="{{ $item->quantity }}">
                                                            <div data-prod="{{$item->product_id}}{{$item->options['length'] ? 'length_'.$item->options['length'] : ''}}"
                                                                 class="productCalc__counterBtn productCalc__counterBtn--plus">
                                                                +
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="productCalc__col productCalc__col--total">
                                                        <div class="productCalc__named">
                                                            Итого: {{--<span>за 0.543 м2</span>--}} </div>
                                                        <div id="prod_total_{{$item->product_id}}{{$item->options['length'] ? 'length_'.$item->options['length'] : ''}}"
                                                             class="productCalc__result">
                                                            = {{ number_format($item->total_price,2) }}₽
                                                        </div>
                                                    </div>
                                                    <div class="deleteBut" id="deleteButtonId"
                                                         onclick="deleteFromCart()"
                                                         data-product-id="{{ $index}}" role="button"
                                                         tabindex="0">
                                                        <input type="hidden" name="sessionId"
                                                               value="{{$item->productSessionId}}">
                                                        <svg>
                                                            <use
                                                                    xlink:href="{{ asset('/img/sprites/sprite-mono.svg#cloze') }}"></use>
                                                        </svg>
                                                    </div>

                                                </div>

                                                @endforeach

                                                @else
                                                    @foreach($position  as $index => $item)
                                                        @php

                                                            $category = $item->product->categories()->first();
                                                          $link=  route('index.products.show', ['product' => $item->product->slug, 'category' => $category->slug]);
                                                        @endphp
                                                        <div id="backet_card_{{$item->product_id}}{{isset($item->options['length']) ? 'length_'.$item->options['length'] : ''}}"
                                                             data-price="{{$item->options['price']}}" data-total="{{ $item->total_price }}"
                                                             data-qtty="{{ $item->quantity }}"
                                                             data-length="{{ $item->options['length'] ?? 0 }}"
                                                             data-width="{{ $item->options['width'] ?? 0 }}"
                                                             data-square="{{ $item->options['square'] ?? 0 }}"
                                                             data-id="{{$item->product_id}}"
                                                             class="basket__card"
                                                             style=" padding: 15px;margin-bottom: 15px;margin-bottom: 15px"
                                                        >
                                                            <div class="basket__cardBody">

                                                                <div class="basket__cardImgBox">
                                                                    <a class="basket__cardImgWrp ibg"
                                                                       href="{{ $link}}">
                                                                        <picture>

                                                                            <img
                                                                                    src="{{ $item->product->mainPhotoPath() }}"
                                                                                    alt="h">
                                                                        </picture>
                                                                    </a>
                                                                </div>
                                                                <div class="basket__cardDesc">
                                                                    <div class="basket__cardTitle link">
                                                                        <a href="{{ $link }}" style="margin: auto;">
                                                                            {{ $item->product->title }}
                                                                        </a>
                                                                    </div>


                                                                    @php
                                                                        $cartService=new \App\Services\Shop\CartFormattedService();
                                                                        $attributes=  $cartService->getFormattedOptionsText($item->options,false,$position);
                                                                    @endphp
                                                                    <div style="margin: auto;">{{ $attributes}}</div>
                                                                </div>


                                                                <div class="basket__cardPrice"
                                                                     style="align-content: center">

                                                                    {{ $item->options['price'] }}
                                                                    ₽ @if($item->product->show_calculator)
                                                                        /м2
                                                                    @endif
                                                                </div>
                                                            </div>
                                                            <div
                                                                    style="display:flex;align-items: center;text-align: center;background-color: #f6f6f6;padding: 15px">


                                                                <div class="productCalc__col productCalc__col--count">
                                                                    <div class="productCalc__named">Количество</div>
                                                                    <div class="productCalc__counter">
                                                                        <div data-prod="{{$item->product_id}}{{isset($item->options['length']) ? 'length_'.$item->options['length'] : ''}}"
                                                                             class="productCalc__counterBtn productCalc__counterBtn--minus">
                                                                            -
                                                                        </div>

                                                                        <input data-prod="{{$item->product_id}}{{isset($item->options['length']) ? 'length_'.$item->options['length'] : ''}}"
                                                                               class="productCalc__inpCount"
                                                                               autocomplete="off"
                                                                               type="text"
                                                                               name="form[]"
                                                                               data-value="{{ $item->quantity }}">
                                                                        <div data-prod="{{$item->product_id}}{{isset($item->options['length']) ? 'length_'.$item->options['length'] : ''}}"
                                                                             class="productCalc__counterBtn productCalc__counterBtn--plus">
                                                                            +
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="productCalc__col productCalc__col--total">
                                                                    <div class="productCalc__named">
                                                                        Итого:
                                                                    </div>
                                                                    <div id="prod_total_{{$item->product_id}}{{isset($item->options['length']) ? 'length_'.$item->options['length'] : ''}}"
                                                                         class="productCalc__result">
                                                                        = {{ number_format($item->total_price,2) }}₽
                                                                    </div>
                                                                </div>
                                                                <div class="basket__cardPrice" style="padding: 4px">


                                                                </div>
                                                                <div class="deleteBut" id="deleteButtonId"
                                                                     data-product-id="{{ $index }}" role="button"
                                                                     tabindex="0">
                                                                    <input type="hidden" name="sessionId"
                                                                           value="{{$item->productSessionId}}">
                                                                    <svg>
                                                                        <use
                                                                                xlink:href="{{ asset('/img/sprites/sprite-mono.svg#cloze') }}"></use>
                                                                    </svg>
                                                                </div>
                                                            </div>

                                                            @endforeach

                                                            @endif</div>
                                                    @endforeach
                                            </div>
                                            <div class="basket__side">
                                                <div class="basket__sideBox">
                                                    <div class="basket__sideName">Сумма заказа</div>
                                                    <div class="basket__sideRow">
                                                        <div class="basket__sideTitle">Всего товаров</div>
                                                        <div
                                                                class="basket__sideData basket__sideData--prod">{{ $cart->getTotalQuantity() }}</div>
                                                    </div>
                                                    <div class="basket__sideRow">
                                                        <div class="basket__sideTitle">Общая стоимость</div>
                                                        <div
                                                                class="basket__sideData basket__sideData--price">{{ number_format($cart->getTotalPrice(),2) }}
                                                            ₽
                                                        </div>
                                                    </div>
                                                    <div class="basket__sideBtns">
                                                        <a href="{{ route('index.cart.checkout') }}">
                                                            <div class="basket__checkout btn" role="button"
                                                                 tabindex="0">
                                                                Оформить предзаказ
                                                            </div>
                                                        </a>
                                                        <div class="basket__btnsGroup">
                                                            @if(\Illuminate\Support\Facades\Auth::user() != null)
                                                                <a href="{{ route('index.cart.print_order') }}">
                                                                    <div class="basket__btn basket__btn--print btn"
                                                                         role="button" tabindex="0">
                                                                        Распечатать заказ
                                                                    </div>
                                                                </a>
                                                                <a href="{{ route('index.cart.send_toMail') }}"
                                                                   class="send_to_mail_btn">
                                                                    <div class="basket__btn basket__btn--mailto btn"
                                                                         role="button"
                                                                         tabindex="0">
                                                                        Отправить заказ на E-mail
                                                                    </div>
                                                                </a>
                                                            @else
                                                                <a href="#" class="no_auth_print_btn">
                                                                    <div class="basket__btn basket__btn--print btn"
                                                                         role="button" tabindex="0">
                                                                        Распечатать заказ
                                                                    </div>
                                                                </a>
                                                                <a href="#" class="no_auth_btn">
                                                                    <div class="basket__btn basket__btn--mailto btn"
                                                                         role="button"
                                                                         tabindex="0">
                                                                        Отправить заказ на E-mail
                                                                    </div>
                                                                </a>
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
    </main>
    <script>

        $(document).on("change", ".productCalc__inpCount", function () {

            calculatePrice2($(this).data('prod'), $(this).val());
        });

        $(document).on("click", ".productCalc__counterBtn--plus, .productCalc__counterBtn--minus", function () {

            calculatePrice2($(this).data('prod'), $('.productCalc__inpCount[data-prod="' + $(this).data('prod') + '"]').val());
        });


        function calculatePrice2(num, qtty) {

            qtty = qtty < 0 ? 1 : qtty;
            let price = $('#backet_card_' + num).data('price');
            let length = $('#backet_card_' + num).data('length') ? $('#backet_card_' + num).data('length') / 1000 : 1;
            let width = $('#backet_card_' + num).data('width') ? $('#backet_card_' + num).data('width') / 1000 : 1;
            let calculatedPrice = price * qtty * length * width;


            $('#prod_total_' + num).text('= ' + calculatedPrice.toFixed(2) + '₽');
            $('#backet_card_' + num).data('total', calculatedPrice.toFixed(2));
            $('#backet_card_' + num).data('qtty', qtty);


            let total = 0;
            let qtty_ = 0;
            $('.basket__card').each(function () {
                ;
                total += $(this).data('total') ? parseFloat($(this).data('total')) : 0;
                qtty_ += $(this).data('qtty') ? parseInt($(this).data('qtty')) : 0;
            });
            $('.basket__sideData--price').text(total.toFixed(2) + ' ₽');
            $('.basket__sideData--prod').text(qtty_);


            $.ajax({
                type: "GET",
                url: '/cart/change',
                data: 'product_id=' + num + '&qtty=' + qtty,
                success: function (data) {

                }
            });

            calculateSquare();
        }
        calculateSquare();
        function calculateSquare() {
            let square = [];
            $('.basket__card').each(function () {

                let plus = $(this).data('square') * $(this).data('qtty');
                square[$(this).data('id')] = square[$(this).data('id')] ? square[$(this).data('id')] +plus :  plus;
            });
            if(square){
                $.each( square, function( key, value ) {
                       $('#total_square_'+key).text(parseFloat(value).toFixed(2)+'/м2');
                });
            }
        }
    </script>
@endsection

<script>


    window.onload = () => {
        if ($('#myModal').length) {
            $('#myModal').modal('show');
        }
        if ($('#myModal2').length) {
            $('#myModal2').modal('show');
        }
        $('.send_to_mail_btn').on('click', function () {
            $('.popup_email_info').addClass('_active')
        })

        $('.no_auth_btn').on('click', function () {
            $('.popup_email_error_info').addClass('_active')
        })

        $('.no_auth_print_btn').on('click', function () {
            $('.popup_print_error_info').addClass('_active')
        })
        $(".deleteBut").on('click', function () {

            let sessionId = $(this).children('input').val();
            console.log(sessionId)
            let data = {
                '_token': $('meta[name="csrf_token"]').attr('content'),
                'product_id': sessionId,
            }
            $.ajax({
                url: '/cart/remove',
                data: data,
                type: "POST",
            })
                .done(function () {
                    location.reload()
                })
        });
    };

</script>
<style>

    .deleteBut {
        top: 0;
        right: 20px;
        width: 20px;
        height: 20px;
        transform: translateY(-50%);
        -webkit-user-select: none;
        -moz-user-select: none;
        user-select: none
    }

    .deleteBut svg {
        width: 100%;
        height: 100%;
        fill: none;
        stroke: #e0e0e0;
        stroke-width: 1px;
        transition: .2s ease
    }
</style>

