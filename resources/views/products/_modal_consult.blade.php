<div class="popup popup_consult">
    <div class="popup__content">
        <div class="popup__body popup__body_md">
            <div class="popup__close popup__cross">
                <svg>
                    <use xlink:href="/img/sprites/sprite-mono.svg#cancel"></use>
                </svg>
            </div>
            <div class="popup__box">
                <div class="popup__title t t--center">Заказать консультацию</div>
                <form class="_form getConsult" method="post" enctype="multipart/form-data">

                    {{ csrf_field() }}
                    <input type="hidden" id="typeOfRequest" name="typeOfRequest" value="Консультация товар ({{$product->title}})">
                    <input type="hidden"  id="link"  name="link" value="{{url()->current()}}">
                    <input type="hidden" name="source" value="Карточка товара '{{ $product->title }}'">

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
                    <div class="formRow">
                        <div class="inpBox">
                            <label for="consent_9" class="ctaForm__label" style="cursor: pointer">
                                <input type="checkbox" id="consent_9" name="consent" required data-consent style="pointer-events: none">
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
    .getConsult .inpBox label {
        color: #aaa;
        font-weight: 400;
        font-size: 1.4rem;
    }
    .getConsult .inpBox label a {
        color: #9af3ef;
        text-decoration: underline;
    }
</style>
