@if(!Str::contains(url()->current(), '/category/servis'))
    <div class="cta cooperation__cta">
        <div class="cta__body">
            <img class="cta__img" src="{{ asset('img/cooperation/close-up-detail.png') }}" alt="img"
                 loading="lazy" decoding="async" referrerPolicy="no-referrer">
            <!-- Call to action-->
            <form class="cta__form" action="{{route('index.send_mail')}}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="ctaForm">
                    <div class="ctaForm__header">
                        <h3 class="ctaForm__title">По вопросам расчета обращайтесь по телефону <a class="ctaForm__link"
                                                                                                  href="tel:+79885109787"
                                                                                                  target="_blank">
                                +7(988)510-97-87</a> или пишите на почту <a class="ctaForm__link"
                                                                            style="font-family: Gadugi"
                                                                            href="mailto:m1_mk@aaanet.ru" target="_blank">m1_mk@aaanet.ru</a><br><span
                                class="ctaForm__subtitle">или оствьте свой номер и мы перезвоним вам</span></h3>
                    </div>
                    <input type="hidden" id="typeOfRequest" name="typeOfRequest" value="Запрос расчет 1">
                    <input type="hidden"  id="link"  name="link" value="{{url()->current()}}">
                    <div class="ctaForm__body">
                        <div class="formRow">
                            <div class="inpBox">
                                <input class="input input_coop" id="name" autocomplete="off" type="text"
                                       placeholder="Ваше имя" name="username" required>
                            </div>
                        </div>
                        <input type="hidden" name="typeOfRequest" id="typeOfRequest" value="Запрос расчет 1">
                        <div class="formRow">
                            <div class="inpBox">
                                <input class="input input_coop" id="numb" autocomplete="off" type="number"
                                       placeholder="Номер телефона" name="phone_number" required>
                            </div>
                        </div>
                        <div class="formRow">
                            <div class="inpBox">
                                <input class="input input_coop" id="numb" autocomplete="off" type="text"
                                       placeholder="Комментарий" name="customer_comment" required>
                            </div>
                        </div>
                        <label class="formBox__fileLabel" for="file" name="file" style="color: #595959">
                            <svg>
                                <use xlink:href="{{ asset('img/sprites/sprite-mono.svg#scr') }}"
                                     style="fill: #595959;"></use>
                            </svg>
                            Прикрепить файл
                        </label>
                        <div class="formRow">
                            <div class="inpBox">
                                <label for="consent" class="ctaForm__label">
                                    <input type="checkbox" id="consent" name="consent" required>
                                    Я даю согласие на обработку моих персональных данных в соответствии с
                                    <a href="/posts/politika-konfidencialnosti" target="_blank">Политикой конфиденциальности</a>.
                                </label>
                            </div>
                        </div>
                        <button class="ordering__submit btn" type="submit" style="font-size: 16px;margin-left: 2px">
                            Отправить
                        </button>
                        <div class="ctaForm__info">
                            Нажав кнопку «Отправить», я подтверждаю, что ознакомлен с
                            <a href="/posts/politika-konfidencialnosti" target="_blank">Политикой конфиденциальности</a> и соглашаюсь на обработку моих персональных данных.
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="post-content__body-container">
            {!! $post->body !!}
        </div>
    </div>
@else
    <div class="contentContainer">
        <div class="contentContainer--text">
            {!! $post->preview !!}
        </div>

        <div class="swiper">
            <div class="contentContainer--slider">
                <div class="wrp-heroSlider">
                    <div class="swiper-container calculationSlider _swiper">
                        <div class="swiper-wrapper heroSlider__wrapper">
                            <div class="swiper-slide-calculation swiper-slide heroSlider__slide swiper-lazy"
                                 style="background-image: url('{{ asset('img/cooperation/close-up-detail-professional-serious-accountant-sitting-light-office-checking-company-finance-profits-calculator 2.png') }}');">
                            </div>
                            <div class="swiper-slide-calculation swiper-slide heroSlider__slide swiper-lazy"
                                 style="background-image: url('{{ asset('img/cooperation/construction-worker-truss-installation 1.png') }}');">
                            </div>
                            <div class="swiper-slide-calculation swiper-slide heroSlider__slide swiper-lazy"
                                 style="background-image: url('{{ asset('img/cooperation/young-man-delivering-order 2.png') }}');">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="wrp-heroSliderPreview" style="z-index: 1">
                    <div class="swiper-container calculationSliderPreview _swiper">
                        <div class="swiper-wrapper heroSliderPreview__wrapper">
                            <div class="swiper-slide-calculation swiper-slide heroSliderPreview__slide">
                                <div class="heroSliderPreview__previewBox">
                                    <div class="heroSliderPreview__previewImgBox swiper-lazy"
                                         style="background-image: url('{{ asset('img/cooperation/close-up-detail-professional-serious-accountant-sitting-light-office-checking-company-finance-profits-calculator 2.png') }}');">
                                    </div>
                                </div>
                            </div>

                            <div class="swiper-slide-calculation swiper-slide heroSliderPreview__slide">
                                <div class="heroSliderPreview__previewBox">
                                    <div class="heroSliderPreview__previewImgBox swiper-lazy"
                                         style="background-image: url('{{ asset('img/cooperation/construction-worker-truss-installation 1.png') }}');">
                                    </div>
                                </div>
                            </div>

                            <div class="swiper-slide-calculation swiper-slide heroSliderPreview__slide">
                                <div class="heroSliderPreview__previewBox">
                                    <div class="heroSliderPreview__previewImgBox swiper-lazy"
                                         style="background-image: url('{{ asset('img/cooperation/young-man-delivering-order 2.png') }}');">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="swiper-calculation-button-next swiper-button-next swiper-button-next_0" id="0">
                <svg style="pointer-events: none">
                    <use xlink:href="{{ asset('img/icons/swiper-blue-arrow.svg#blue-arrow-right') }}"></use>
                </svg>
            </div>
        </div>

        <div class="service__usluga-wrapper">
{{--            <label class="formBox__fileLabel formBox__fileLabel-mobile" name="file" for="file" style="color: #595959; margin-bottom: 0;">--}}
{{--                <input class="formBox__input" autocomplete="off" type="file" name="file" id="file" style="display: none">--}}

{{--                <svg>--}}
{{--                    <use xlink:href="{{ asset('img/sprites/sprite-mono.svg#scr') }}"--}}
{{--                         style="fill: #595959;"></use>--}}
{{--                </svg>--}}
{{--                Прикрепить файл--}}
{{--            </label>--}}
            <button class="btn service_raschet_btn" type="button">
                Оставить заявку
            </button>
        </div>
    </div>
@endif
<style>
    .contentContainer{
        width: 100%;
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
        .sideDash--sticky {
            padding-left: 16px;
        }
        .cooperation__container {
            padding: 0;
        }
        .cooperation__title, .pay_title, .pay_desc, .pay_info-title, .pay_info-text {
            padding: 0 16px;
        }
    }
    @media screen and (max-width: 479.98px) {
        .wrp-heroSliderPreview {
            right: 90px;
        }
    }
</style>



