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
                <div class="swiper-wrapper heroSlider__wrapper"
                     style="height: 300px;">


                    @foreach($slider as $item)
                        <div class="swiper-slide slide_1 heroSlider__slide swiper-lazy firstSlide" data-url="{{$item->url}}" 
                             data-background="{{ asset('upload_images/' . $item->photo_desktop) }}"
                             style="height: 300px">
                            <div class="heroSlider__content _container">
                                <div class="heroSlider__txtBox" style="display: none">

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
                            </div>
                        </div>

                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <div class="swiper-button-next swiper-button-next_0" style="font-size: 36px"
         id="0">>
    </div>
    <div class="swiper-button-prev swiper-button-prev_0" style="font-size: 36px"
         id="0"><
    </div>
</div>
<script>
    $(".swiper-slide").click(function () {
        let currentUrl = ($(this).data('url'));
        window.location.href = currentUrl;
    });
</script>
<style>
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

    .swiper {
        height: 300px;
    }

    .wrp-heroSlider {
        width: 300px;
        min-width: 966px;
        margin-right: 210px;
    }

    .heroSliderPreview {
        position: relative;
        height: 100%;
        margin-left: -230px;
        width: 414px;
    }

    .heroSliderPreview__slide {
        width: 300px;
    }

    .heroSliderPreview__previewBox {
        cursor: pointer;
        position: relative;
        height: 100%;
        overflow: hidden;
    }

    @media screen and (max-width: 500px) {
        .wrp-heroSliderPreview {
            display: none;
        }

        .wrp-heroSlider {

            margin-right: 0px;
        }
    }

</style>
