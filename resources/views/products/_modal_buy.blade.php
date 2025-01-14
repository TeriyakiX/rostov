<div class="popup popup_buy">
    <div class="popup__content">
        <div class="popup__body popup__body_md">
            <div class="popup__close popup__cross">
                <svg>
                    <use xlink:href="/img/sprites/sprite-mono.svg#cancel"></use>
                </svg>
            </div>
            <div class="popup__box">
                <div class="popup__title t t--center">Купить в один клик</div>
                <form action="{{route('index.send_one_click_mail')}}" method="post" class="_form getModalBuy">

                    {{ csrf_field() }}

                    <div class="formRow">
                        <div class="inpBox">
                            <input class="input" id="name" autocomplete="off" placeholder="Ваше имя" type="text"
                                   name="name" required>
                        </div>
                    </div>
                    <div class="formRow">
                        <div class="inpBox">
                            <input class="input" id="numb" autocomplete="off" placeholder="Номер телефона" type="tel"
                                   name="phone_number" required>
                        </div>
                    </div>

                    <div class="formRow">
                        <div class="inpBox">
                            <select class="input" id="numb" autocomplete="off" name="delivery_method"
                                    onchange="if($(this).val() == 2){$('#buy-popup-address').show();}else{$('#buy-popup-address').hide()}">
                                <option>Выберите способ доставки</option>
                                <option value="1">Самовывоз</option>
                                <option value="2">Доставка</option>
                            </select>
                        </div>
                    </div>
                    <input type="hidden" name="vendor_code" value="{{$product->vendor_code}}">
                    <input type="hidden" name="title" value="{{$product->title}}">
                    <div class="formRow" id="buy-popup-address" style="display: none">
                        <div class="inpBox">
                            <input class="input" id="numb" autocomplete="off" placeholder="Адрес" name="address">
                        </div>
                    </div>
                    <div class="formRow">
                        <div class="inpBox">
                            <label for="consent_8" class="ctaForm__label" style="cursor: pointer">
                                <input type="checkbox" id="consent_8" name="consent" required data-consent style="pointer-events: none">
                                Я даю согласие на обработку моих персональных данных в соответствии с
                                <a href="/posts/politika-konfidencialnosti" target="_blank">Политикой конфиденциальности</a>.
                            </label>
                        </div>
                    </div>
                    <button class="btn btn--cl disabled" data-submit disabled type="submit">Перезвонить</button>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    .getModalBuy .inpBox label {
        color: #aaa;
        font-weight: 400;
        font-size: 1.4rem;
    }
    .getModalBuy .inpBox label a {
        color: #9af3ef;
        text-decoration: underline;
    }
</style>
