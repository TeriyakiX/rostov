<link
    rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.css"
/>

<div class="swiper" style=" color: #0dcaf0;position: relative">

    <div class="hero__container">
        <div class="wrp-heroSlider">
            <div class="swiper-container stockSlider _swiper">
                <div class="swiper-wrapper heroSlider__wrapper">
                    @foreach($slider as $item)
                        <div class="swiper-slide heroSlider__slide swiper-lazy swiper-slide-stock"
                             data-background="{{ asset('upload_images/' . $item->photo_desktop) }}">
                            <div class="heroSlider__content heroSlider__content--desktop">
                                <div class="heroSlider__txtBox">
                                    <h2 class="heroSlider__title">Акция выходного дня</h2>
                                    <div class="stockSlider__count"></div>
                                    <p class="heroSlider__txt">
                                        Ротор переворачивает период. Момент силы трения не зависит от скорости
                                        вращения внутреннего кольца подвеса, что не кажется странным, если
                                        вспомнить о том, что мы не исключили из рассмотрения гироскопический
                                        стабилизатоор.
                                    </p>
                                    <div class="heroSlider__promo">
                                        Акция действует до 19.06.21
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="wrp-heroSliderPreview" style="z-index: 1">
            <div class="swiper-container stockSliderPreview _swiper">
                <div class="swiper-wrapper heroSliderPreview__wrapper">
                    @foreach($slider as $item)
                        <div class="swiper-slide-stock swiper-slide heroSliderPreview__slide">
                            <div class="heroSliderPreview__previewBox">
                                <div class="heroSliderPreview__previewImgBox swiper-lazy"
                                     data-background="{{ asset('upload_images/' .$item->photo_desktop) }}">
                                </div>
                                <div class="stockSliderPreview__count"></div>
                                <div class="heroSliderPreview__previewTitle">Черная пятница</div>
                            </div>
                        </div>

                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

<div class="wrp-heroSlider--mobile--wrapper">
    <div class="wrp-heroSlider wrp-heroSlider--mobile" style="position: static;">
        <div class="swiper-container stockSlider--mobile _swiper">
            <div class="swiper-wrapper heroSlider__wrapper">
                @foreach($slider as $item)
                    <div class="swiper-slide swiper-slide--mobile heroSlider__slide swiper-lazy">
                        <div class="heroSlider__content _container">
                            <div class="heroSlider__txtBox">
                                <h2 class="heroSlider__title">Акция выходного дня</h2>
                                <div class="stockSlider__count stockSlider__count--mobile"></div>
                                <p class="heroSlider__txt">
                                    Ротор переворачивает период. Момент силы трения не зависит от скорости
                                    вращения внутреннего кольца подвеса, что не кажется странным, если
                                    вспомнить о том, что мы не исключили из рассмотрения гироскопический
                                    стабилизатоор.
                                </p>
                                <div class="heroSlider__promo">
                                    Акция действует до 19.06.21
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
<style>
    .heroSliderPreview__previewTitle {
        white-space: nowrap;
    }
    .wrp-heroSlider--mobile {
        display: none;
    }
    .wrp-heroSlider--mobile--wrapper {
        width: 100%;
        margin-top: 32px
    }
    .heroSlider__promo {
        position: absolute;
        bottom: 5%;
        left: 0;
        width: 50%;
        height: 30px;
        background-color: rgba(37, 161, 65, 0.7);
        color: #fff;
        font-size: 1.4rem;
        display: flex;
        align-items: center;
        justify-content: center;
        clip-path: polygon(0 0, 100% 0, calc(100% - 30px) 100%, 0 100%);
        z-index: 1;
        padding-right: 20px;
        padding-left: 4px;
    }
    .title {

        font-style: normal;
        font-weight: 700;
        font-size: 24px;
        line-height: 140.62%;
        /* or 34px */

        display: flex;
        align-items: center;

        color: #595959;
    }

    .text {
        font-style: normal;
        font-weight: 400;
        font-size: 16px;
        line-height: 26px;
        /* or 162% */

        display: flex;
        align-items: center;

        /* 3 */

        color: #505050;
    }
    .wrp-heroSlider {
        width: 300px;
        min-width: 966px;
    }
    .heroSlider__content {
        padding-right: 0;
        padding-left: 195px;
    }
    .heroSlider__slide {
        display: flex;
        align-items: flex-end;
        padding: 0;
    }
    .heroSliderPreview {
        position: relative;
        height: 100%;
        margin-left: -230px;
    }
    @media (max-width: 991.98px) {
        .heroSlider__slide {
            padding: 32px 0;
        }
    }
    @media (max-width: 767.98px) {
        .wrp-heroSlider--mobile--wrapper {
            margin-top: 0;
        }
    }
</style>
