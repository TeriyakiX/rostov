@extends('layouts.index')

@section('content')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.0.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.css" />
    <main class="page">
        <nav class="breadcrumbs">
            <div class="breadcrumbs__container _container">
                <ul class="breadcrumbs__list">
                    <li class="breadcrumbs__item">
                        <a class="breadcrumbs__link" href="{{ route('index.home') }}">
                            <span>Главная</span>
                            <svg>
                                <use xlink:href="{{ asset('/img/sprites/sprite-mono.svg#slideArrow') }}"></use>
                            </svg>
                        </a>
                    </li>
                    <li class="breadcrumbs__item">
                        <a class="breadcrumbs__link" href="{{ route('index.cart.index') }}">
                            <span>Корзина</span>
                            <svg>
                                <use xlink:href="{{ asset('/img/sprites/sprite-mono.svg#slideArrow') }}"></use>
                            </svg>
                        </a>
                    </li>
                    <li class="breadcrumbs__item">
                        <a class="breadcrumbs__link breadcrumbs__link--active" href="#">
                            <span>Оформление заказа</span>
                            <svg>
                                <use xlink:href="{{ asset('img/icons/blue-play.svg#blue-play') }}"></use>
                            </svg>
                        </a>
                    </li>
                </ul>
            </div>
        </nav>
        <section class="ordering">
            <div class="ordering__container _container">
                <div class="ordering__content">
                    <h2 class="ordering__title t">Оформление заказа</h2>

                    @include('errors._validation')

                    <div class="ordering__grid">
                        <div class="ordering__body">
                            <form class="ordering__form" action="{{ route('index.cart.checkout.do') }}" method="POST" enctype="multipart/form-data">
                                {{ csrf_field() }}
                                <div class="ordering__personData">
                                    <div class="ordering__personDataHead">
                                        <h3 class="ordering__subTitle">Личные данные</h3>
                                    </div>
                                    <div class="ordering__personDataBody">
                                        <div class="formRow">
                                            <div class="radioBox ordering__radioBox" id="usertype">
                                                <div class="radioBox__item">
                                                    <input class="radioBox__input" id="r1" autocomplete="off" type="radio" name="is_fiz" value="1" checked>
                                                    <label class="radioBox__label" for="r1"><span class="radioBox__icon"></span>Физ. лицо</label>
                                                </div>
                                                <div class="radioBox__item" style="margin-top:10px;">
                                                    <input class="radioBox__input" id="entity" autocomplete="off" type="radio" name="is_fiz" value="0">
                                                    <label class="radioBox__label" for="entity"><span class="radioBox__icon"></span>Юр. лицо</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="formRow">
                                            <div class="inpBox inpBox33">
                                                <label class="req" for="name">Имя</label>
                                                <input class="input" id="name" autocomplete="off" type="text" name="name" value="{{ old('name') ?: ($userData ? $userData->name : null) }}" required>
                                            </div>
                                            <div class="inpBox inpBox33">
                                                <label class="req" for="numb">Номер телефона</label>
                                                <input class="input" id="numb" autocomplete="off" type="text" name="phone_number" value="{{ old('phone_number') ?: ($userData ? $userData->phone_number : null) }}" required>
                                            </div>
                                            <div class="inpBox inpBox33">
                                                <label class="req" for="mail">E-mail</label>
                                                <input class="input" id="mail" autocomplete="off" type="email" name="email" value="{{ old('email') ?: ($userData ? $userData->email : null) }}" required>
                                            </div>
                                        </div>
                                        <div class="formRow filesRow">
                                            <div class="fileBox">
                                                <label class="link" for="file1">
                                                    <svg class="fileIconSvg">
                                                        <use xlink:href="{{ asset('/img/sprites/sprite-mono.svg#fileForm') }}"></use>
                                                    </svg>Прикрепить файл
                                                </label>
                                                <input id="file1" type="file" name="file">
                                            </div>
                                            <div class="fileBox entityReq">
                                                <label class="link" for="file2">
                                                    <svg class="fileIconSvg">
                                                        <use xlink:href="{{ asset('/img/sprites/sprite-mono.svg#fileForm') }}"></use>
                                                    </svg>Прикрепить реквизиты
                                                </label>
                                                <input id="file2" type="file" name="file2" >
                                            </div>
                                        </div>
                                        @if(!auth()->check())
                                            <div class="formRow reg">
                                                <div class="checkbox">
                                                    <input class="checkbox__input" id="reg" autocomplete="off" type="checkbox" value="1" name="register_me" checked>
                                                    <label class="checkbox__label link" for="reg">Зарегистрировать личный кабинет</label>
                                                </div>
                                                <div class="signinBox">
                                                    <div class="ordering__login"><a class="link" href="{{ route('auth.loginForm') }}">Войти&nbsp;в&nbsp;личный&nbsp;кабинет</a></div>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="ordering__deliveryData">
                                    <div class="ordering__deliveryDataHead">
                                        <h3 class="ordering__subTitle">Доставка</h3>
                                    </div>
                                    <div class="ordering__deliveryDataBody">
                                        <div class="formRow formRow--radioPanel">
                                            <div class="inpBox inpBox50">
                                                <div class="radioPanel">
                                                    <input class="radioPanel__input" id="panel1" autocomplete="off" name="delivery_type_id" type="radio" value="1" checked onclick="$('#address-box').show()">
                                                    <label class="radioPanel__label" for="panel1">
                                                        <span class="radioPanel__name">
                                                            Требуется доставка
                                                            <span class="radioPanel__icon"></span>
                                                        </span>
                                                        <span class="radioPanel__txt">
                                                            Мы предложим вам лучший способ доставки
                                                        </span>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="inpBox inpBox50">
                                                <div class="radioPanel">
                                                    <input class="radioPanel__input" id="panel2" autocomplete="off" name="delivery_type_id" type="radio" value="2" onclick="$('#address-box').hide()">
                                                    <label class="radioPanel__label" for="panel2">
                                                        <span class="radioPanel__name">
                                                            Самовывоз
                                                            <span class="radioPanel__icon"></span>
                                                        </span>
                                                        <span class="radioPanel__txt">
                                                            Вы можете забрать ваш заказ со склада в Ростове-на-Дону
                                                        </span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="formRow" id="address-box">
                                            <div class="inpBox">
                                                <label for="address">Адрес доставки*</label>
                                                <input class="input" id="address" autocomplete="off" type="text" value="{{ old('address') }}" name="address">
                                            </div>
                                        </div>
                                        <div class="formRow">
                                            <div class="textareaBox">
                                                <label for="comment">Комментарий к заказу</label>
                                                <div class="textareaWrp">
                                                    <textarea class="textarea" id="comment" name="customer_comment">{{ old('customer_comment') }}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <!--._map#map-->
                                    </div>
                                </div>
                                <div class="ordering__payData">
                                    <div class="ordering__payDataHead">
                                        <h3 class="ordering__subTitle">Оплата</h3>
                                    </div>
                                    <div class="ordering__deliveryDataBody">
                                        <div class="formRow formRow--radioPanel">
                                            <div class="inpBox inpBox33">
                                                <div class="radioPanel">
                                                    <input class="radioPanel__input" id="panel3" autocomplete="off" type="radio" name="payment_type_id" value="1" checked>
                                                    <label class="radioPanel__label" for="panel3"><span class="radioPanel__name">Наличными
                                                            <span class="radioPanel__icon"></span></span><span class="radioPanel__txt">Оплата наличными</span>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="inpBox inpBox33">
                                                <div class="radioPanel">
                                                    <input class="radioPanel__input" id="panel4" autocomplete="off" type="radio" name="payment_type_id" value="2">
                                                    <label class="radioPanel__label" for="panel4"><span class="radioPanel__name">Сбербанк <span class="radioPanel__icon"></span></span>
                                                        <span class="radioPanel__txt">Оплата через Сбербанк</span>
                                                    </label>
                                                </div>
                                            </div>
{{--                                            <div class="inpBox inpBox33">--}}
{{--                                                <div class="radioPanel">--}}
{{--                                                    <input class="radioPanel__input" id="panel5" autocomplete="off" type="radio" name="payment_type_id" value="3">--}}
{{--                                                    <label class="radioPanel__label" for="panel5"><span class="radioPanel__name">Способ оплаты 3<span class="radioPanel__icon"></span></span><span class="radioPanel__txt">Краткое описание способа оплаты</span></label>--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
                                        </div>
                                    </div>
                                </div>
                                <div class="ordering__confirmBox">
                                    <div class="ordering__confirmBoxWrp">
                                        <p class="ordering__confirmTxt">Мы обработаем ваш заказ и наши специалисты свяжутся с вами в ближайшее время</p>
                                        <button class="ordering__submit btn" type="submit">Подтвердить заказ</button>
                                    </div>
                                </div>
                                <div class="ordering__policy">
                                    <div class="checkbox">
                                        <input class="checkbox__input" id="policy" autocomplete="off" type="checkbox" name="confirm" checked>
                                        <label class="checkbox__label" for="policy">
                                            Согласен с
                                            <a class="ordering__policyLink link" href="/privacy-policy">политикой конфеденциальности</a>
                                        </label>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="ordering__side">
                            <div class="ordering__basketInfo">
                                <div class="ordering__basketInfoHead">
                                    <div class="ordering__basketInfoTitle">В заказе {{ $cart->getTotalQuantity() }} товара на сумму:</div>
                                    <div class="ordering__basketInfoSum">{{ $cart->getTotalPrice() }} ₽</div>
                                </div>
                                <div class="ordering__basketInfoBody">
                                    @foreach($cart->getPositions() as $position)
                                        <div class="ordering__basketInfoCard">
                                            <div class="ordering__basketInfoCardTitle">{{ $position->getProduct()->title }}</div>
                                            <div class="ordering__basketInfoCardSum">{{ $position->getItemPrice() }} ₽ @if($position->getProduct()->show_calculator) /м2 @endif X {{ $position->getQuantity() }} = {{ $position->getTotalPrice() }} ₽</div>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="ordering__basketInfoFooter">
                                    <div class="ordering__finalyPrice"><span>Общая стоимость:</span><span class="ordering__finalySum">{{ $cart->getTotalPrice() }} ₽</span></div>
                                </div>
                            </div>
                            <div>
                                <button class="btn ordering__help" type="submit" style="margin-left: 2px;">Помощь менеджера</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
    <script>
        $(document).on("click", ".ordering__help", function () {
            $('.popup_help').addClass('_active')
        });
    </script>
@endsection
