@if(!Str::contains(url()->current(), '/category/servis'))
    <div class="container">
        <h3 class="pay_title">Платежные системи</h3>
        <p>
            Оплата происходит через авторизационный центр Процессингового центра Банка с использованием Банковских
            кредитных
            карт следующих
            платежных систем:
        </p>
        <div class="pay_icons_div">
            <img src="{{asset('/img/payment/Mir-01.png')}}" class="pay_icon" alt="pay icon">
            <img src="{{asset('/img/payment/Visa_Logo.png')}}" class="pay_icon" alt="pay icon">
            <img src="{{asset('/img/payment/maestro_png.png')}}" style="width: 50px; height: 26px; margin-right: 15px;"
                 alt="pay icon">
            <img src="{{asset('/img/payment/master.png')}}" style="width: 50px; height: 26px" alt="pay icon">
        </div>
        <div class="pay_card">
            <div class="pay_card_body">
                <h3 class="pay_card_title">Оплатить заказ картой online</h3>
                <p style="color: #bebebe">все поля обязательны для заполнения</p>
                <form action="{{route('index.cart.pay')}}" method="post" style="margin-top: 20px">
                    @csrf
                    <div class="ctaForm">
                        <div class="ctaForm__inputs">
                            <div class="formRow" style="width: 45%;margin-right: 2%;">
                                <div class="inpBox inpBox__oplata" style="display: flex">
                                    <label for="certificate" style="margin:auto;">Номер счета-спецификации</label>
                                    <input class="input input_coop" id="certificate" autocomplete="off" type="number"
                                           placeholder="XXXXXXX" name="certificate" style="border-radius: 10px;"
                                           required>
                                </div>
                            </div>
                            <div class="formRow" style="width: 45%;">
                                <div class="inpBox inpBox__oplata" style="display: flex">
                                    <label for="price" style="width: 40%;margin:auto;">Сумма к оплате</label>
                                    <input class="input input_coop" id="price" autocomplete="off"
                                           type="number" style="-moz-appearance: textfield;border-radius: 10px;"
                                           placeholder="00,000" name="price" required>
                                </div>
                            </div>
                        </div>
                        <div class="formRow" style="width: 45%;margin-right: 2%;">
                            <div class="inpBox inpBox__oplata" style="display: flex">
                                <label for="email" style="margin:auto;">E-mail для отправки чека</label>
                                <input class="input input_coop" id="email" autocomplete="off" type="text"
                                       placeholder="Ваш E-mail" name="email" style="border-radius: 10px;width: 90%"
                                       required>
                            </div>
                        </div>
                        <div class="oplata__info">
                            <button class="ordering__submit btn" type="submit"
                                    style="font-size: 16px;margin-left: 2px; margin-right: 10px; max-height: 43px;">
                                Оплатить заказ картой
                            </button>
                            <p style="line-height: 1.5;color: #bebebe;margin: 0">
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
        <p style="margin-top: 3%">Информация об оплате банковской картой</p>
        <div style="margin-top: 3%">
            <ul class="b" style="line-height: 1.5;">
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
        {!! $post->body !!}
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
        </div>
        <div>
            <a href="{{url('posts/oplata')}}" class="btn" type="button" style="margin-bottom: 20px;">
                Перейти к оплате
            </a>
        </div>
    </div>


@endif
<style>
    @media screen and (max-width: 900px) {
        .contentContainer {

        }
    }

</style>
