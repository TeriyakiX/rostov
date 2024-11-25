<div class="popup popup_usluga_dostakva">
    <div class="popup__content">
        <div class="popup__body popup__body_md">
            <div class="popup__close popup__cross">
                <svg>
                    <use xlink:href="/img/sprites/sprite-mono.svg#cancel"></use>
                </svg>
            </div>
            <div class="popup__box">
                <div class="popup__title t t--center">Консультация</div>
                <form action="{{route('index.send_mail')}}" method="post" enctype="multipart/form-data">
                    @csrf

                    <input type="hidden" id="typeOfRequest" name="typeOfRequest" value="Запрос доставка 2">
                    <input type="hidden" id="link" name="link" value="{{url()->current()}}">
                    <div class="ctaForm">
                        <div class="ctaForm__header" style="text-align: center">
                            <h3 class="ctaForm__title">По вопросам доставки обращайтесь по телефону
                                <a class="ctaForm__link" href="tel:+79885109787" target="_blank"> +7(988)510-97-87</a> или пишите на почту
                                <a class="ctaForm__link" style="font-family: Gadugi" href="mailto:m1_mk@aaanet.ru" target="_blank">m1_mk@aaanet.ru</a><br>
                                <span class="ctaForm__subtitle">или оставьте свой номер и мы перезвоним вам</span>
                            </h3>
                        </div>
                        <div class="ctaForm__body">
                            <div class="formRow">
                                <div class="inpBox">
                                    <input class="input input_coop" id="address" name="address" autocomplete="off" type="text" placeholder="Адрес доставки" required>
                                </div>
                            </div>
                            <div class="formRow">
                                <div class="inpBox">
                                    <input class="input input_coop" id="numb" autocomplete="off" type="number" placeholder="Номер телефона" name="phone_number" required>
                                </div>
                            </div>
                            <div class="formRow">
                                <div class="inpBox">
                                    <input class="input input_coop" id="comment" autocomplete="off" type="text" placeholder="Комментарий к заказу" name="customer_comment" required>
                                </div>
                            </div>
                            <label class="formBox__fileLabel" for="file1" name="file" style="color: #595959">
                                <input type="file" id="file1" name="file" style="display: none">
                                <svg>
                                    <use xlink:href="{{ asset('img/sprites/sprite-mono.svg#scr') }}" style="fill: #595959;"></use>
                                </svg>
                                Прикрепить файл
                            </label>
                            <div class="formRow">
                                <div class="inpBox">
                                    <label for="consent1" class="ctaForm__label">
                                        <input type="checkbox" id="consent1" name="consent" required>
                                        Я даю согласие на обработку моих персональных данных в соответствии с
                                        <a href="/privacy-policy" target="_blank">Политикой конфиденциальности</a>.
                                    </label>
                                </div>
                            </div>

                            <div>
                                <button class="btn" type="submit" style="width: 100%;">Отправить</button>
                            </div>
                            <div class="ctaForm__info">
                                Нажав кнопку «Отправить», я подтверждаю, что ознакомлен с
                                <a href="/privacy-policy" target="_blank">Политикой конфиденциальности</a> и соглашаюсь на обработку моих персональных данных.
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="popup popup_zakazat_raschet">
    <div class="popup__content">
        <div class="popup__body popup__body_md">
            <div class="popup__close popup__cross">
                <svg>
                    <use xlink:href="/img/sprites/sprite-mono.svg#cancel"></use>
                </svg>
            </div>
            <div class="popup__box">
                <div class="popup__title t t--center">Консультация</div>
                <form action="{{route('index.send_mail')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="ctaForm">
                        <div class="ctaForm__header" style="text-align: center">
                            <h3 class="ctaForm__title">По вопросам расчета обращайтесь по телефону
                                <a class="ctaForm__link" href="tel:+79885109787" target="_blank"> +7(988)510-97-87</a> или пишите на почту
                                <a class="ctaForm__link" style="font-family: Gadugi" href="mailto:m1_mk@aaanet.ru" target="_blank">m1_mk@aaanet.ru</a><br>
                                <span class="ctaForm__subtitle">или оставьте свой номер и мы перезвоним вам</span>
                            </h3>
                        </div>
                        <div class="ctaForm__body">
                            <input type="hidden" id="typeOfRequest" name="typeOfRequest" value="Запрос расчет 2">
                            <input type="hidden" value="{{url()->current()}}" id="link" name="link">
                            <div class="formRow">
                                <div class="inpBox">
                                    <input class="input input_coop" id="name" autocomplete="off" type="text" placeholder="Ваше имя" name="username" required>
                                </div>
                            </div>
                            <div class="formRow">
                                <div class="inpBox">
                                    <input class="input input_coop" id="numb" autocomplete="off" type="number" placeholder="Номер телефона" name="phone_number" required>
                                </div>
                            </div>
                            <div class="formRow">
                                <div class="inpBox">
                                    <input class="input input_coop" id="numb" autocomplete="off" type="text" placeholder="Комментарий" name="customer_comment" required>
                                </div>
                            </div>
                            <label class="formBox__fileLabel" for="file2" name="file" style="color: #595959">
                                <input type="file" id="file2" name="file" style="display: none">
                                <svg>
                                    <use xlink:href="{{ asset('img/sprites/sprite-mono.svg#scr') }}" style="fill: #595959;"></use>
                                </svg>
                                Прикрепить файл
                            </label>
                            <div class="formRow">
                                <div class="inpBox">
                                    <label for="consent2" class="ctaForm__label">
                                        <input type="checkbox" id="consent2" name="consent" required>
                                        Я даю согласие на обработку моих персональных данных в соответствии с
                                        <a href="/privacy-policy" target="_blank">Политикой конфиденциальности</a>.
                                    </label>
                                </div>
                            </div>

                            <button class="btn" type="submit" style="width: 100%;">Отправить</button>
                            <div class="ctaForm__info">
                                Нажав кнопку «Отправить», я подтверждаю, что ознакомлен с
                                <a href="/privacy-policy" target="_blank">Политикой конфиденциальности</a> и соглашаюсь на обработку моих персональных данных.
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="popup popup_montazh_raschet">
    <div class="popup__content">
        <div class="popup__body popup__body_md">
            <div class="popup__close popup__cross">
                <svg>
                    <use xlink:href="/img/sprites/sprite-mono.svg#cancel"></use>
                </svg>
            </div>
            <div class="popup__box">
                <div class="popup__title t t--center">Консультация</div>
                <form action="{{route('index.send_mail')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" id="typeOfRequest" name="typeOfRequest" value="Запрос монтаж 2">
                    <input type="hidden" id="link" name="link" value="{{url()->current()}}">
                    <div class="ctaForm">
                        <div class="ctaForm__header" style="text-align: center">
                            <h3 class="ctaForm__title">По вопросам монтажа обращайтесь по телефону
                                <a class="ctaForm__link" href="tel:+79885109787" target="_blank"> +7(988)510-97-87</a> или пишите на почту
                                <a class="ctaForm__link" style="font-family: Gadugi" href="mailto:m1_mk@aaanet.ru" target="_blank">m1_mk@aaanet.ru</a><br>
                                <span class="ctaForm__subtitle">или оставьте свой номер и мы перезвоним вам</span>
                            </h3>
                        </div>
                        <div class="ctaForm__body">
                            <div class="formRow">
                                <div class="inpBox">
                                    <input class="input input_coop" id="name" autocomplete="off" type="text" placeholder="Ваше имя" name="username" required>
                                </div>
                            </div>
                            <div class="formRow">
                                <div class="inpBox">
                                    <input class="input input_coop" id="numb" autocomplete="off" type="number" placeholder="Номер телефона" name="phone_number" required>
                                </div>
                            </div>
                            <div class="formRow">
                                <div class="inpBox">
                                    <input class="input input_coop" id="comment" autocomplete="off" type="text" placeholder="Комментарий к заказу" name="customer_comment" required>
                                </div>
                            </div>
                            <label class="formBox__fileLabel" for="file3" name="file" style="color: #595959">
                                <input type="file" id="file3" name="file" style="display: none">
                                <svg>
                                    <use xlink:href="{{ asset('img/sprites/sprite-mono.svg#scr') }}" style="fill: #595959;"></use>
                                </svg>
                                Прикрепить файл
                            </label>

                            <div class="formRow">
                                <div class="inpBox">
                                    <label for="consent3" class="ctaForm__label">
                                        <input type="checkbox" id="consent3" name="consent" required>
                                        Я даю согласие на обработку моих персональных данных в соответствии с
                                        <a href="/privacy-policy" target="_blank">Политикой конфиденциальности</a>.
                                    </label>
                                </div>
                            </div>

                            <button class="btn" type="submit" style="width: 100%;">Отправить</button>
                            <div class="ctaForm__info">
                                Нажав кнопку «Отправить», я подтверждаю, что ознакомлен с
                                <a href="/privacy-policy" target="_blank">Политикой конфиденциальности</a> и соглашаюсь на обработку моих персональных данных.
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
