<section class="hero">
    <div class="hero__container _container">
        <div class="wrp-heroSlider">
            <div class="swiper-container heroSlider _swiper">
                <div class="swiper-wrapper heroSlider__wrapper">
                    @foreach($indexSliders as $indexSlider)
                        <div class="swiper-slide heroSlider__slide swiper-lazy" data-background="{{ asset('upload_images/' . $indexSlider->photo_desktop) }}">
                            <div class="heroSlider__content _container">
                                <div class="heroSlider__txtBox">
                                    <h2 class="heroSlider__title">{{ $indexSlider->title }}</h2>
                                    <div class="heroSlider__count"></div>
                                    <p class="heroSlider__txt">
                                        {{ $indexSlider->description }}
                                    </p>
                                    <a class="heroSlider__btn btn" href="{{ $indexSlider->url }}">Узнфывфывать больше</a>
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
