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
            <div class="basket__container _container">
                <div class="basket__content">
                    <h2 class="basket__title t">Корзина</h2>
                    <form class="basket__grid" action="#" method="post">
                        <div class="basket__body">
                            @foreach($cart->getPositions() as $position)
                                {{--                                @dd($cart->getPositions())--}}
                                <div class="basket__card">
                                    <div class="basket__cardBody">
                                        <div class="basket__cardImgBox">
                                            <a class="basket__cardImgWrp ibg"
                                               href="{{ $position->getProductUrl() }}">
                                                <picture>
                                                    {{--                                                    <source type="image/webp" srcset="./img/history/h.webp">--}}
                                                    <img src="{{ $position->getPhotoPath() }}" alt="h">
                                                </picture>
                                            </a>
                                        </div>
                                        <div class="basket__cardDesc">
                                            <div class="basket__cardTitle link">
                                                <a href="{{ $position->getProductUrl() }}">
                                                    {{ $position->getProduct()->title }}
                                                </a>
                                            </div>
                                            <div class="basket__cardChars">{{ $position->getOptionsText() }}</div>
                                        </div>
                                        <div class="basket__cardPrice">
                                            @if($position->getProduct()->promo_price)
                                                {{ $position->getProduct()->promo_price }}
                                                ₽ @if($position->getProduct()->show_calculator)
                                                    /м2
                                                @endif
                                            @else
                                                {{ $position->getProduct()->price }}
                                                ₽ @if($position->getProduct()->show_calculator)
                                                    /м2
                                                @endif
                                            @endif
                                        </div>
                                    </div>

                                    <div class="productCalc">
                                        <div class="productCalc__body">
                                            {{--                                            <div class="productCalc__col productCalc__col--long">--}}
                                            {{--                                                <div class="productCalc__named">Выберите длину листа</div>--}}
                                            {{--                                                <select class="productCalc__select" name="select">--}}
                                            {{--                                                    <option class="productCalc__op" value="value1">460 мм</option>--}}
                                            {{--                                                    <option class="productCalc__op" value="value2">920 мм</option>--}}
                                            {{--                                                    <option class="productCalc__op" value="value2">920 мм</option>--}}
                                            {{--                                                    <option class="productCalc__op" value="value3">1380 мм</option>--}}
                                            {{--                                                </select>--}}
                                            {{--                                            </div>--}}
                                            <div class="productCalc__col productCalc__col--count">
                                                <div class="productCalc__named">Количество</div>
                                                <div class="productCalc__counter">
                                                    <div class="productCalc__counterBtn productCalc__counterBtn--minus">
                                                        -
                                                    </div>
                                                    <input class="productCalc__inpCount" autocomplete="off" type="text"
                                                           name="form[]" data-value="{{ $position->getQuantity() }}">
                                                    <div class="productCalc__counterBtn productCalc__counterBtn--plus">
                                                        +
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="productCalc__col productCalc__col--total">
                                                <div class="productCalc__named">
                                                    Итого: {{--<span>за 0.543 м2</span>--}} </div>
                                                <div class="productCalc__result">= {{ $position->getTotalPrice() }}₽
                                                </div>
                                            </div>
                                        </div>
                                        {{--                                        <div class="productCalc__footer">--}}
                                        {{--                                            <div class="productCalc__add link" role="button" tabindex="0">Добавить лист другой длины</div>--}}
                                        {{--                                            <div class="productCalc__minInfo">--}}
                                        {{--                                                <svg>--}}
                                        {{--                                                    <use xlink:href="{{ asset('/img/sprites/sprite-mono.svg#note') }}"></use>--}}
                                        {{--                                                </svg>Минимальная партия 5 кв. м--}}
                                        {{--                                            </div>--}}
                                        {{--                                        </div>--}}
                                        <div class="productCalc__del product-cart-remove"
                                             data-product-id="{{ $position->getProduct()->id }}" role="button"
                                             tabindex="0">
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
                                    <div
                                        class="basket__sideData basket__sideData--prod">{{ $cart->getTotalQuantity() }}</div>
                                </div>
                                <div class="basket__sideRow">
                                    <div class="basket__sideTitle">Общая стоимость</div>
                                    <div class="basket__sideData basket__sideData--price">{{ $cart->getTotalPrice() }}
                                        ₽
                                    </div>
                                </div>
                                <div class="basket__sideBtns">
                                    <a href="{{ route('index.cart.checkout') }}">
                                        <div class="basket__checkout btn" role="button" tabindex="0">Оформить заказ
                                        </div>
                                    </a>
                                    <div class="basket__btnsGroup">
                                        <a href="{{ route('index.cart.print_order') }}">
                                            <div class="basket__btn basket__btn--print btn" role="button" tabindex="0">
                                                Распечатать заказ
                                            </div>
                                        </a>
                                        <a href="{{ route('index.cart.send_toMail') }}" class="send_to_mail_btn">
                                            <div class="basket__btn basket__btn--mailto btn" role="button" tabindex="0">
                                                Отправить заказ на E-mail
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </main>
@endsection
<script>
    window.onload = () => {
        if ($('#myModal').length) {
            $('#myModal').modal('show');
        }
        $('.send_to_mail_btn').on('click', function () {
            $('.popup_email_info').addClass('_active')
        })
    };

</script>

