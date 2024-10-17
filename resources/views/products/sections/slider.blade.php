<link
    rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.css"
/>

<div class="swiper" style=" color: #0dcaf0;position: relative">

    <div class="hero__container _container">
        <div class="wrp-heroSlider">
            <div class="swiper-container heroSlider
                                     slider_0
                                _swiper" data-id="0">
                <div class="swiper-wrapper heroSlider__wrapper">


                    @foreach($slider as $item)
                        <div class="swiper-slide slide_1 heroSlider__slide swiper-lazy firstSlide" data-url="{{$item->url}}"
                             data-background="{{ asset('upload_images/' . $item->photo_desktop) }}">
                            <div class="heroSlider__content _container heroSlider__content--desktop">
                                <div class="heroSlider__txtBox">
                                    <h2 class="heroSlider__title">Акция выходного дня</h2>
                                    <div class="heroSlider__count"></div>
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
            <div class="swiper-container heroSliderPreview
                                      sliderPreview_0
                                      _swiper" data-id="0">
                <div class="swiper-wrapper heroSliderPreview__wrapper">
                    @foreach($slider as $item)
                        <div class="swiper-slide heroSliderPreview__slide" data-url="{{$item->url}}">
                            <div class="heroSliderPreview__previewBox">
                                <div class="heroSliderPreview__previewImgBox swiper-lazy"
                                     data-background="{{ asset('upload_images/' .$item->photo_desktop) }}">
                                </div>
                                <div class="heroSliderPreview__count"></div>
                                <div class="heroSliderPreview__previewTitle">Черная пятница</div>
                            </div>
                        </div>

                    @endforeach
                </div>
            </div>
        </div>
    </div>

{{--    <div class="swiper-button-next swiper-button-next_0" style="font-size: 36px"--}}
{{--         id="0">>--}}
{{--    </div>--}}
{{--    <div class="swiper-button-prev swiper-button-prev_0" style="font-size: 36px"--}}
{{--         id="0"><--}}
{{--    </div>--}}
</div>

<div style="width: 100%; margin-top: 32px">
    <div class="wrp-heroSlider wrp-heroSlider--mobile" style="position: static;">
        <div class="swiper-container heroSlider
                                     slider_0
                                _swiper" data-id="0">
            <div class="swiper-wrapper heroSlider__wrapper"
                 style="height: auto;">


                @foreach($slider as $item)
                    <div class="swiper-slide slide_1 heroSlider__slide swiper-lazy firstSlide" data-url="{{$item->url}}"
                         style="height: auto">
                        <div class="heroSlider__content _container">
                            <div class="heroSlider__txtBox">
                                <h2 class="heroSlider__title">Акция выходного дня</h2>
                                <div class="heroSlider__count"></div>
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
<script>
    $(".swiper-slide").click(function () {
        let currentUrl = ($(this).data('url'));
        window.location.href = currentUrl;
    });
</script>
<style>
    .heroSliderPreview__previewTitle {
        white-space: nowrap;
    }
    .wrp-heroSlider--mobile {
        display: none;
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
    .firstSlide{
        cursor: pointer;
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
        margin-right: 210px;
    }
    .heroSlider__content {
        padding-right: 0;
        padding-left: 172px;
    }
    .heroSlider__slide {
        display: flex;
        align-items: flex-end;
        padding: 0;
        background-repeat: no-repeat;
        background-position: center;
        background-size: cover;
    }

    .heroSliderPreview {
        position: relative;
        height: 100%;
        margin-left: -230px;
    }
    .heroSliderPreview__previewBox {
        cursor: pointer;
        position: relative;
        height: 100%;
        overflow: hidden;
    }
</style>
