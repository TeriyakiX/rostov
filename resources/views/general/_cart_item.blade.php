<div class="cartBox__row">
    <div class="cartBox__photo cartBox__left cartBox__col">
        <picture>
            <source type="image/webp" srcset="{{ asset('img/card/img1.webp') }}">
            <img src="{{ asset('img/card//img1.png') }}" alt="img1">
        </picture>
    </div>
    <div class="cartBox__left cartBox__col">
        <ul>
            <li>
                <p class="cartBox__titleCode">
                    <small>Код: 54113</small>
                </p>
            </li>
            <li>
                <p class="cartBox__titleText">
                    {{ $position->getQuantity() }} X {{ $position->getProduct()->title }}
                </p>
            </li>
        </ul>
    </div>
    <div class="cartBox__right cartBox__col">
        <p class="cartBox__price">
            {{ $position->getProduct()->price }} ₽.
        </p>
    </div>
</div>
