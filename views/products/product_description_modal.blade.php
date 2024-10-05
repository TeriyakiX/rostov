<div class="popup popup_coating_description" id="popup_coating_description">
    <div class="popup__content">
        <div class="popup__body popup__body_lg">
            <div class="popup__close popup__cross">
                <svg>
                    <use xlink:href="/img/sprites/sprite-mono.svg#cancel"></use>
                </svg>
            </div>

            <div class="popup__box content__box">

                <div class="popup__title t">Покрытие</div>
                <div class="cart-list">
                    <div class="cart-list__body">
                        {{$product->coatings_description ?? 'Описание отсутствует'}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="popup popup_profile_type_description" id="profile_type_description">
    <div class="popup__content">
        <div class="popup__body popup__body_lg">
            <div class="popup__close popup__cross">
                <svg>
                    <use xlink:href="/img/sprites/sprite-mono.svg#cancel"></use>
                </svg>
            </div>

            <div class="popup__box content__box">

                <div class="popup__title t">Тип профиля</div>
                <div class="cart-list">
                    <div class="cart-list__body">
                        {{$product->profile_type_description ?? 'Описание отсутствует'}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="popup popup_manufacturer_description" id="manufacturer_description">
    <div class="popup__content">
        <div class="popup__body popup__body_lg">
            <div class="popup__close popup__cross">
                <svg>
                    <use xlink:href="/img/sprites/sprite-mono.svg#cancel"></use>
                </svg>
            </div>

            <div class="popup__box content__box">

                <div class="popup__title t">Производитель</div>
                <div class="cart-list">
                    <div class="cart-list__body">
                        {{$product->manufacturer_description ?? 'Описание отсутствует'}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="popup popup_thickness_description" id="thickness_description">
    <div class="popup__content">
        <div class="popup__body popup__body_lg">
            <div class="popup__close popup__cross">
                <svg>
                    <use xlink:href="/img/sprites/sprite-mono.svg#cancel"></use>
                </svg>
            </div>

            <div class="popup__box content__box">

                <div class="popup__title t">Толщина листа</div>
                <div class="cart-list">
                    <div class="cart-list__body">
                        {{$product->thickness_description ?? 'Описание отсутствует'}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
