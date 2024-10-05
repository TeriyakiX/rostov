<section>
    <div class="_container">
        <div class="cartBox">
            @foreach($positions as $position)
                @include('general._cart_item')
            @endforeach
        </div>
    </div>

    <div class="_container cartBoxDescription">
        <div class="cartBoxInfo">
            <div class="cartBox__row">
                <div class="cartBox__left cartBox__col">
                    <ul>
                        <li> <p>В корзине {{ $quantity }} товар</p></li>
                        <li> <p>на сумму {{ $totalPrice }} ₽.</p></li>
                    </ul>
                </div>
                <div class="cartBox__left cartBox__col">
                    <a href="#" rel="modal:close">
                        <div class="card__btn btn" role="button">
                            Продолжить покупки
                        </div>
                    </a>
                </div>
                <div class="cartBox__right cartBox__col">
                    <a href="{{ route('index.cart.index') }}">
                        <div class="card__btn btn" role="button">
                            Перейти в корзину
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
