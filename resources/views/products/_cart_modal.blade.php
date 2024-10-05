<div class="popup popup_cart" id="cart_modal">
    <div class="popup__content">
        <div class="popup__body popup__body_lg">
            <div class="popup__close popup__cross">
                <svg>
                    <use xlink:href="/img/sprites/sprite-mono.svg#cancel"></use>
                </svg>
            </div>

            <div class="popup__box content__box">

                <div class="popup__title t">Товар добавлен в корзину</div>
                <div class="cart-list">
                    <div class="cart-list__body"></div>

                    <div class="cart-list__controls">
                        <div class="cart-list__info popup__info cart-list__info">

                        </div>
                        <a class="popup__close" style="cursor: pointer;margin-right:10px;">
                            <div class="btn btn--md cart-list__control">Продолжить покупки</div>
                        </a>
                        <a href="{{ route('index.cart.index') }}">
                            <div class="btn btn--md cart-list__control">Перейти к корзине</div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
