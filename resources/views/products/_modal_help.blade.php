<div class="popup popup_help">
    <div class="popup__content">
        <div class="popup__body popup__body_md">
            <div class="popup__close popup__cross">
                <svg>
                    <use xlink:href="/img/sprites/sprite-mono.svg#cancel"></use>
                </svg>
            </div>
            <div class="popup__box">
                <div class="popup__title t t--center">Консультация</div>
                <form action="" class="_form getConsult">

                    {{ csrf_field() }}
                    <input type="hidden" name="to_mail">
                    <input type="hidden" name="typeOfRequest" value="Консультация оформление заказа">
                    <input type="hidden" name="link" value="{{url()->current()}}">
                    <div class="formRow">
                        <div class="inpBox">
                            <input class="input" id="name" autocomplete="off" placeholder="Ваше имя" type="text" name="name" required>
                        </div>
                    </div>
                    <div class="formRow">
                        <div class="inpBox">
                            <input class="input" id="numb" autocomplete="off" placeholder="Номер телефона" type="tel" name="phone_number" required>
                        </div>
                    </div>
                    <div class="popup__info popup__info--center popup__info--gap">Нажав кнопку «Отправить», я подтверждаю, что ознакомлен с <a style="color: #9af3ef;text-decoration: underline;" href="/privacy-policy" target="_blank">Политикой конфиденциальности</a> и соглашаюсь на обработку моих персональных данных.</div>
                    <button class="btn btn--cl help_popup_submit_btn" type="submit">Перезвонить</button>
                </form>
            </div>
        </div>
    </div>
</div>
