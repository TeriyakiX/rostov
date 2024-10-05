<div class="popup popup_protective_layer_description" id="popup_protective_layer_description">
    <div class="popup__content">
        <div class="popup__body popup__body_lg">
            <div class="popup__close popup__cross">
                <svg>
                    <use xlink:href="/img/sprites/sprite-mono.svg#cancel"></use>
                </svg>
            </div>

            <div class="popup__box content__box">

                <div class="popup__title t">Защитный слой Zn</div>
                <div class="cart-list">
                    <div class="cart-list__body">
                        {{$coating->protective_layer_description ?? 'Описание отсутствует'}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="popup popup_metal_thickness_description" id="popup_metal_thickness_description">
    <div class="popup__content">
        <div class="popup__body popup__body_lg">
            <div class="popup__close popup__cross">
                <svg>
                    <use xlink:href="/img/sprites/sprite-mono.svg#cancel"></use>
                </svg>
            </div>

            <div class="popup__box content__box">

                <div class="popup__title t">Толщина металла</div>
                <div class="cart-list">
                    <div class="cart-list__body">
                        {{$coating->metal_thickness_description ?? 'Описание отсутствует'}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="popup popup_polymer_coating_thickness_description" id="popup_polymer_coating_thickness_description">
    <div class="popup__content">
        <div class="popup__body popup__body_lg">
            <div class="popup__close popup__cross">
                <svg>
                    <use xlink:href="/img/sprites/sprite-mono.svg#cancel"></use>
                </svg>
            </div>

            <div class="popup__box content__box">

                <div class="popup__title t">Толщина полимерного покрытия</div>
                <div class="cart-list">
                    <div class="cart-list__body">
                        {{$coating->polymer_coating_thickness_description ?? 'Описание отсутствует'}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="popup popup_guarantee_description" id="popup_guarantee_description">
    <div class="popup__content">
        <div class="popup__body popup__body_lg">
            <div class="popup__close popup__cross">
                <svg>
                    <use xlink:href="/img/sprites/sprite-mono.svg#cancel"></use>
                </svg>
            </div>

            <div class="popup__box content__box">

                <div class="popup__title t">Гарантия</div>
                <div class="cart-list">
                    <div class="cart-list__body">
                        {{$coating->guarantee_description ?? 'Описание отсутствует'}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="popup popup_light_fastness_description" id="popup_light_fastness_description">
    <div class="popup__content">
        <div class="popup__body popup__body_lg">
            <div class="popup__close popup__cross">
                <svg>
                    <use xlink:href="/img/sprites/sprite-mono.svg#cancel"></use>
                </svg>
            </div>

            <div class="popup__box content__box">

                <div class="popup__title t">Цветостойкость</div>
                <div class="cart-list">
                    <div class="cart-list__body">
                        {{$coating->light_fastness_description ?? 'Описание отсутствует'}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
