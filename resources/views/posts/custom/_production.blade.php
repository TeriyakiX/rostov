<link
    rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.css"
/>

@foreach($productions as $index =>$item)
    <div class="production__slider title"> {{$item->title}}</div>
    <div class="production__slider text"> {{$item->text??''}}</div>
    {{--                        <section class="hero swiper">--}}

    <div class="swiper" style="color: #0dcaf0;position: relative; margin-top: 20px; margin-bottom: 20px;">
        <div class="contentContainer--slider">
                <div class="wrp-heroSlider">
                    <div class="swiper-container productionSlider
                                     {{'slider_'.$index}}
                                _swiper" data-id="{{$index}}">
                        <div class="swiper-wrapper heroSlider__wrapper">
                            @foreach($item->photos as $indexSlider)
                                <div class="swiper-slide-production swiper-slide slide_1 heroSlider__slide swiper-lazy"
                                     data-background="{{ asset('upload_images/' . $indexSlider->path) }}">
                                    <div class="heroSlider__content _container">
                                        <div class="heroSlider__txtBox" style="display: none">
                                            {{--                                                                                                                    <h2 class="heroSlider__title">{{ $indexSlider->ph }}</h2>--}}
                                            {{--                                                            <div class="heroSlider__count"></div>--}}
                                            {{--                                                                                                                            {{ $indexSlider->description }}--}}
                                            {{--                                                            </p>--}}
                                            {{--                                                                                                                    <a class="heroSlider__btn btn" href="{{ $indexSlider->url }}">Узнать больше</a>--}}
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="wrp-heroSliderPreview" style="z-index: 1">
                    <div class="swiper-container productionSliderPreview
                                      {{'sliderPreview_'.$index}}
                                      _swiper" data-id="{{$index}}">
                        <div class="swiper-wrapper heroSliderPreview__wrapper">
                            @foreach($item->photos as $indexSlider)
                                <div class="swiper-slide-production swiper-slide heroSliderPreview__slide">
                                    <div class="heroSliderPreview__previewBox">
                                        <div class="heroSliderPreview__previewImgBox swiper-lazy"
                                             data-background="{{ asset('upload_images/' . $indexSlider->path) }}"></div>
                                        {{--                                                        <div class="heroSliderPreview__count"></div>--}}
                                    </div>
                                </div>

                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

        <div class="swiper-production-button-next swiper-button-next {{'swiper-button-next_'.$index}}" style="font-size: 36px"
             id="{{$index}}">>
        </div>
{{--        <div class="swiper-button-prev {{'swiper-button-prev_'.$index}}" style="font-size: 36px"--}}
{{--             id="{{$index}}"><--}}
{{--        </div>--}}
    </div>


    @endforeach



    <style>
        .cooperation__content {
            overflow: inherit;
        }
        .title {
            margin-bottom: 8px;
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
            min-width: 766px;
            right: auto;
        }
        .wrp-heroSliderPreview {
            width: 500px;
            right: 500px;
        }
        .swiper-button-next,
        .swiper-button-prev {
            display: none;
        }
        .cooperation {
            padding-bottom: 0;
        }

        @media (max-width: 991.98px) {
            .wrp-heroSlider {
                min-width: 520px;
            }
            .wrp-heroSliderPreview {
                width: 300px;
                right: 350px;
            }
        }
        @media screen and (max-width: 767.98px) {
            .swiper-button-next,
            .swiper-button-prev {
                display: block;
            }
            .swiper {
                overflow: inherit;
                margin-left: -16px;
            }
            .wrp-heroSlider {
                min-width: 620px;
            }
            .wrp-heroSliderPreview {
                right: 140px;
            }
        }
        @media screen and (max-width: 500px) {
            .wrp-heroSlider {

                margin-right: 0px;
            }
        }
        @media screen and (max-width: 479.98px) {
            .wrp-heroSliderPreview {
                right: 90px;
            }
        }
    </style>



