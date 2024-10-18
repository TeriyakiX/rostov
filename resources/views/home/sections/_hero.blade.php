<section class="hero">
    <div class="hero__container _container">
        <div class="wrp-heroSlider">
            <div class="swiper-container heroSlider _swiper">
                <div class="swiper-wrapper heroSlider__wrapper">
                    @foreach($indexSliders as $indexSlider)
                        <div class="swiper-slide heroSlider__slide swiper-lazy" data-background="{{ asset('upload_images/' . $indexSlider->photo_desktop) }}">
                            <div class="heroSlider__content _container heroSlider__content--desktop">
                                <div class="heroSlider__txtBox">
                                    <h2 class="heroSlider__title">{{ $indexSlider->title }}</h2>
                                    <div class="heroSlider__count"></div>
                                    <p class="heroSlider__txt">
                                        {{ $indexSlider->description }}
                                    </p>
                                    <a class="heroSlider__btn btn" href="{{ $indexSlider->url }}">Узнать больше</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="wrp-heroSliderPreview">
            <div class="swiper-container heroSliderPreview _swiper">
                <div class="swiper-wrapper heroSliderPreview__wrapper">
                    @foreach($indexSliders as $indexSlider)
                        <div class="swiper-slide heroSliderPreview__slide">
                            <div class="heroSliderPreview__previewBox">
                                <div class="heroSliderPreview__previewImgBox swiper-lazy" data-background="{{ asset('upload_images/' . $indexSlider->photo_mobile) }}"></div>
                                <div class="heroSliderPreview__count"></div>
                                <div class="heroSliderPreview__previewTitle">{{ $indexSlider->title }}</div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>

{{--<div style="width: 100%;">--}}
{{--    <div class="wrp-heroSlider wrp-heroSlider--mobile" style="position: static;">--}}
{{--        <div class="swiper-container heroSlider _swiper">--}}
{{--            <div class="swiper-wrapper heroSlider__wrapper">--}}
{{--                @foreach($indexSliders as $indexSlider)--}}
{{--                    <div class="swiper-slide heroSlider__slide swiper-lazy">--}}
{{--                        <div class="heroSlider__content _container">--}}
{{--                            <div class="heroSlider__txtBox">--}}
{{--                                <h2 class="heroSlider__title">{{ $indexSlider->title }}</h2>--}}
{{--                                <div class="heroSlider__count"></div>--}}
{{--                                <p class="heroSlider__txt">--}}
{{--                                    {{ $indexSlider->description }}--}}
{{--                                </p>--}}
{{--                                <a class="heroSlider__btn btn" href="{{ $indexSlider->url }}">Узнать больше</a>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                @endforeach--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--</div>--}}

<style>
    .wrp-heroSlider--mobile {
        display: none;
    }

    @media (max-width: 991.98px) {
        .wrp-heroSlider--mobile {
            display: flex;
        }
        .heroSlider__content--desktop {
            display: none;
        }
        .heroSlider__btn {
            width: 100%;
        }
        .heroSlider__slide {
            padding-bottom: 0;
        }
        .hero {
            margin-top: 83px;
        }
        .wrp-heroSlider, .wrp-heroSliderPreview {
            right: 150px;
        }
    }
    @media (max-width: 479.98px) {
        .wrp-heroSlider, .wrp-heroSliderPreview {
            right: 110px;
        }
    }
    @media (max-width: 767.98px) {
        .hero {
            margin-top: 56px;
        }
    }
    @media (max-width: 479.98px) {
        .hero {
            margin-top: 0;
        }
    }
</style>
