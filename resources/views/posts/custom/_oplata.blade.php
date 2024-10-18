@if(!Str::contains(url()->current(), '/category/servis'))
    <div class="pay__content">
        <h3 class="pay_title">Платежные системы</h3>
        <p class="pay_desc" style="line-height: 150%">
            Оплата происходит через авторизационный центр Процессингового центра Банка с использованием Банковских
            кредитных
            карт следующих
            платежных систем:
        </p>
        <div class="pay_icons_div">
            <img src="{{asset('/img/payment/Mir-01.png')}}" class="pay_icon" alt="pay icon">
            <img src="{{asset('/img/payment/Visa_Logo.png')}}" class="pay_icon" alt="pay icon">
            <img src="{{asset('/img/payment/maestro_png.png')}}"
                 alt="pay icon">
            <img src="{{asset('/img/payment/master.png')}}" class="pay_icon" alt="pay icon">
        </div>
        <div class="pay_card">
            <div class="pay_card_body">
                <h3 class="pay_card_title">Оплатить заказ картой online</h3>
                <p style="color: #bebebe">все поля обязательны для заполнения</p>
                <form action="{{route('index.cart.pay')}}" method="post" style="margin-top: 20px">
                    @csrf
                    <div class="ctaForm">
                        <div class="ctaForm__inputs">
                            <div class="formRow" style="width: 45%;">
                                <div class="inpBox inpBox__oplata" style="display: flex">
                                    <label for="certificate" style="margin:auto;">Номер счета-спецификации</label>
                                    <input class="input_pay" id="certificate" autocomplete="off" type="number"
                                           placeholder="XXXXXXX" name="certificate"
                                           required>
                                </div>
                            </div>
                            <div class="formRow" style="width: 45%;">
                                <div class="inpBox inpBox__oplata" style="display: flex">
                                    <label for="price" style="width: 40%;margin:auto;">Сумма к оплате</label>
                                    <input class="input_pay" id="price" autocomplete="off"
                                           type="number" style="-moz-appearance: textfield"
                                           placeholder="00,000" name="price" required>
                                </div>
                            </div>
                        </div>
                        <div class="formRow" style="width: 45%;">
                            <div class="inpBox inpBox__oplata" style="display: flex">
                                <label for="email" style="margin:auto;">E-mail для отправки чека</label>
                                <input class="input_pay" id="email" autocomplete="off" type="text"
                                       placeholder="Ваш E-mail" name="email" style="width: 90%"
                                       required>
                            </div>
                        </div>
                        <div class="oplata__info">
                            <button class="ordering__submit btn" type="submit"
                                    style="font-size: 14px;height: 36px;margin-right: 8px; margin-left: 0;padding: 5px 18px">
                                Оплатить заказ картой
                            </button>
                            <p style="line-height: 1.5;color: #A8A8A8;margin: 0;font-size: 16px">
                                Нажимая кнопку «Оплатить банковской картой, вы соглашаетесь с количеством,
                                ассортиментом,
                                его наименованием и стоимостью товара, входящего в состав счет-спецификации, а так же с
                                <span style="color: #006bde;"><a href="/posts/pravilami-oplaty-produkcii-s-ispolzovaniem-bankovskih-kart">Правилами оплаты продукции с использованием банковских карт.</a></span>
                            </p>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <p class="pay_info-title" style="margin-top: 3%">Информация об оплате банковской картой</p>
        <div class="pay_info-text">
            <ul class="b" style="line-height: 26px;">
                <li>
                    Для оплаты (ввода реквизитов Вашей карты) покупки Вы будете перенаправлены на платежный шлюз ПАО
                    «Сбербанк России» для ввода реквизитов Вашей карты. Пожалуйста, приготовьте Вашу пластиковую карту
                    заранее. Соединение с платежным шлюзом и передача информации осуществляется в защищенном режиме с
                    использованием протокола шифрования SSL
                </li>
                <li>
                    В случае если ваш банк поддерживает технологию безопасного проведения интернет-платежей Verified By
                    Visa
                    или MasterCard Secure Code для проведения платежа также может потребоваться ввод специального
                    пароля.
                    Способы и возможность получения паролей для совершения интернет-платежей Вы можете уточнить в банке,
                    выпустившем карту.
                </li>
                <li>
                    Настоящий сайт поддерживает 256-битное шифрование. Конфиденциальность сообщаемой персональной
                    информации
                    обеспечивается OAO
                    «Сбербанк России». Введенная информация не будет предоставлена третьим лицам за исключением случаев,
                    предусмотренных законодательством РФ. Проведение платежей по банковским картам осуществляется в
                    строгом
                    соответствии с требованиями платежных систем Visa Int. и MasterCard Europe Sprl.
                </li>
                <li>
                    Так как наша компания не осуществляет переводов денежных средств и не оказывает каких-либо
                    банковских
                    услуг, всю ответственность за правильность осуществления перевода несут исключительно Банк,
                    осуществивший эмиссию банковских карт и ведение счетов держателя Платежной карты, и держатель карты.
                    Все
                    претензии, связанные с переводом денежных средств, осуществленных в рамках настоящего сервиса,
                    разрешаются непосредственно между Банком и Держателем карты.
                </li>
            </ul>
        </div>
    </div>

@else
    <div class="contentContainer">
        <div class="contentContainer--text">
            {!! $post->body !!}
        </div>
        <div class="cooperation--cta">
            <div class="cooperation--cta_item" style="width: 65%;">
                <img class="" src="{{ asset('img/cooperation/cooperation.png') }}"
                     alt="img"
                     loading="lazy" decoding="async" referrerPolicy="no-referrer">
            </div>
            <div class="cooperation--cta_item cooperation--cta_item-bg">
                <img class="" src="{{ asset('img/cooperation/cooperation.png') }}"
                     alt="img"
                     loading="lazy" decoding="async" referrerPolicy="no-referrer"
                     style="transform: translate(0, 0) skewX(-20deg)">
            </div>
            <div class="cooperation--cta_item cooperation--cta_item-bg">
                <img class="" src="{{ asset('img/cooperation/cooperation.png') }}"
                     alt="img"
                     loading="lazy" decoding="async" referrerPolicy="no-referrer"
                     style="transform: translate(0, 0) skewX(-20deg)">
            </div>
            <div class="cooperation--cta_item cooperation--cta_item-bg">
                <img class="" src="{{ asset('img/cooperation/cooperation.png') }}"
                     alt="img"
                     loading="lazy" decoding="async" referrerPolicy="no-referrer"
                     style="transform: translate(0, 0) skewX(-20deg)">
            </div>
        </div>
        <div class="service__usluga-wrapper">
            <label class="formBox__fileLabel formBox__fileLabel-mobile" name="file" for="file" style="color: #595959; margin-bottom: 0;">
                <input class="formBox__input" autocomplete="off" type="file" name="file" id="file" style="display: none">

                <svg>
                    <use xlink:href="{{ asset('img/sprites/sprite-mono.svg#scr') }}"
                         style="fill: #595959;"></use>
                </svg>
                Прикрепить файл
            </label>
            <a href="{{url('posts/oplata')}}" class="btn service_oplata_btn" type="button">
                Перейти к оплате
            </a>
        </div>
    </div>


@endif

<style>
    @media (max-width: 767.98px) {
        .cooperation__container {
            padding: 0;
        }
        .cooperation__title, .pay_title, .pay_desc, .pay_info-title, .pay_info-text {
            padding: 0 16px;
        }
        .formRow {
            margin: 0;
        }
        .inpBox {
            padding: 0;
        }
    }
</style>
