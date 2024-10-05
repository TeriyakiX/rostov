<div id="addToCartModal" class="_container modal">

    <section>
        <div class="_container">
            <h2 class="brands__title t">
                Товар добавлен в корзину
            </h2>
        </div>
    </section>

    <section class="cartModalContent">
    </section>

    <section class="newItems lastview">
        <div class="newItems__container _container">
            <div class="newItems__content">
                <div class="newItems__body">
                    <div class="newItems__controlPanel">
                        <h2 class="newItems__title t">С этим товаром покупают: </h2>
                        <div class="newItems__sliderBtns">
                            <div class="newItems__sliderBtn newItems__sliderBtn--prev" role="button" tabindex="0">
                                <svg>
                                    <use xlink:href="{{ asset('img/sprites/sprite-mono.svg#slideArrow') }}"></use>
                                </svg>
                            </div>
                            <div class="newItems__sliderBtn newItems__sliderBtn--next" role="button" tabindex="0">
                                <svg>
                                    <use xlink:href="{{ asset('img/sprites/sprite-mono.svg#slideArrow') }}"></use>
                                </svg>
                            </div>
                        </div>
                    </div>
                    <div class="wrp-itemsSlider">
                        <div class="swiper-container itemsSlider _swiper">
                            <div class="swiper-wrapper itemsSlider__wrapper">
                                @foreach($sliderProducts as $sliderProduct)
                                    @include('products._block_item')
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
