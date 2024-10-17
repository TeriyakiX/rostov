<link
    rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.css"
/>

@foreach($productions as $index =>$item)
    <div class="production__slider title"> {{$item->title}}</div>
    <div class="production__slider text"> {{$item->text??''}}</div>
    {{--                        <section class="hero swiper">--}}

    <div class="swiper" style=" color: #0dcaf0;position: relative; margin-top: 20px; margin-bottom: 20px;">

        <div class="hero__container _container">
            <div class="wrp-heroSlider">
                <div class="swiper-container heroSlider
                                     {{'slider_'.$index}}
                                _swiper" data-id="{{$index}}">
                    <div class="swiper-wrapper heroSlider__wrapper"
                         style="height: 300px;">


                        @foreach($item->photos as $indexSlider)
                            <div class="swiper-slide slide_1 heroSlider__slide swiper-lazy"
                                 data-background="{{ asset('upload_images/' . $indexSlider->path) }}"
                                 style="height: 300px">
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
                <div class="swiper-container heroSliderPreview
                                      {{'sliderPreview_'.$index}}
                                      _swiper" data-id="{{$index}}">
                    <div class="swiper-wrapper heroSliderPreview__wrapper">
                        @foreach($item->photos as $indexSlider)
                            <div class="swiper-slide heroSliderPreview__slide">
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

        <div class="swiper-button-next {{'swiper-button-next_'.$index}}" style="font-size: 36px"
             id="{{$index}}">>
        </div>
        <div class="swiper-button-prev {{'swiper-button-prev_'.$index}}" style="font-size: 36px"
             id="{{$index}}"><
        </div>
    </div>


    @endforeach



    <style>
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



