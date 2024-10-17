<section class="newItems">
    <div class="newItems__container _container">
        <div class="newItems__content">
            <h2 class="newItems__title t">Новинки ассортимента</h2>
            <div class="newItems__body">
                <div class="newItems__controlPanel">
                    <div class="newItems__tabs">
                        <div class="newItems__tabsEl all_categories newItems__tabsEl--active" role="button" tabindex="0"
                             data-tab="all" data-active><div class="newItems__tabsEl--first">Все</div>
                        </div>
                        <div class="newItems__tabsEl sort_button" role="button" type="submit" tabindex="0"
                             data-tab="roof">
                            Кровля
                        </div>
                        <div class="newItems__tabsEl sort_button" role="button" tabindex="0" data-tab="facade">
                            Фасад
                        </div>
                        <div class="newItems__tabsEl sort_button" role="button" tabindex="0" data-tab="poly">
                            Поликарбонат
                        </div>
                        <div class="newItems__tabsEl sort_button" role="button" tabindex="0" data-tab="terrace">
                            Террасная доска
                        </div>
                    </div>
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
                <div class="newItems__tabBlocks">

                    <div class="newItems__tabBlock newItems__tabBlock--active" data-tabblock="all" data-active>
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
                    <div class="newItems__tabBlock" data-tabblock="roof">
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
                    <div class="newItems__tabBlock" data-tabblock="facade">
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
                    <div class="newItems__tabBlock" data-tabblock="poly">
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
                    <div class="newItems__tabBlock" data-tabblock="terrace">
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
        </div>
    </div>
</section>
