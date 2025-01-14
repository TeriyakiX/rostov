@extends('layouts.index')
<style>
    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    /* Firefox */
    input[type=number] {
        -moz-appearance: textfield;
    }
</style>
@include('partials.modal')
@section('content')
    <nav class="breadcrumbs">
        <div class="breadcrumbs__container _container">
            <ul class="breadcrumbs__list">
                <li class="breadcrumbs__item"><a class="breadcrumbs__link" href="/"><span>Главная</span>
                        <svg>
                            <use
                                xlink:href="{{ asset('img/sprites/sprite-mono.svg#slideArrow') }}"></use>
                        </svg>
                    </a></li>
                <li class="breadcrumbs__item"><a class="breadcrumbs__link"
                                                 href="/posts/gotovye-resheniya"><span>Готовые решения</span>
                        <svg>
                            <use
                                xlink:href="{{ asset('img/sprites/sprite-mono.svg#slideArrow') }}"></use>
                        </svg>
                    </a>
                </li>
                <li class="breadcrumbs__item"><a class="breadcrumbs__link breadcrumbs__link--active"
                                                 href="#"><span>{{ $solution->title }}</span>
                        <svg>
                            <use xlink:href="{{ asset('img/icons/blue-play.svg#blue-play') }}"></use>
                        </svg>
                    </a>
                </li>
            </ul>
        </div>
    </nav>
    <section class="cooperation">
        <div class="cooperation__container _container">
            <div class="cooperation__content">
                <div class="cooperation__body sideDashContainer">

                    <div class="cta__body">
                        <img class="cta__img" src="{{ asset('upload_images/'. $solution->photos[0]['path']) }}"
                             alt="img" loading="lazy" decoding="async" referrerPolicy="no-referrer">
                        <!-- Call to action-->
                        <form class="cta__form" id="consultationForm" action="{{route('index.send_mail')}}" method="post" data-ajax="true">
                            @csrf
                            <div class="ctaForm">
                                <div class="ctaForm__header">
                                    <h3 class="ctaForm__title">По вопросам сотрудничества обращайтесь по телефону <a
                                            class="ctaForm__link" href="tel:+79885109787" target="_blank">
                                            +7(988)510-97-87</a> или пишите на почту <a class="ctaForm__link"
                                                                                        style="font-family: Gadugi"
                                                                                        href="mailto:m1_mk@aaanet.ru"
                                                                                        target="_blank">m1_mk@aaanet.ru</a><br><span
                                            class="ctaForm__subtitle">или оствьте свой номер и мы перезвоним вам</span>
                                    </h3>
                                </div>
                                <input type="hidden" id="link" name="link" value="{{url()->current()}}">
                                <div class="ctaForm__body">
                                    <div class="formRow">
                                        <div class="inpBox">
                                            <input class="input input_coop" id="name" autocomplete="off" type="text"
                                                   placeholder="Ваше имя" name="name" required>
                                        </div>
                                    </div>
                                    <input type="hidden" id="typeOfRequest" name="typeOfRequest" value="Сотрудничество">
                                    <div class="formRow">
                                        <div class="inpBox">
                                            <input class="input input_coop" id="numb" autocomplete="off" type="text"
                                                   placeholder="Номер телефона" name="phone_number" required>
                                        </div>
                                    </div>
                                    <div class="formRow">
                                        <div class="inpBox">
                                            <input class="input input_coop" id="numb" autocomplete="off" type="text"
                                                   placeholder="Комментарий" name="customer_comment" required>
                                        </div>
                                    </div>
                                    <label class="formBox__fileLabel" for="formBox_file" name="file">
                                        <input class="formBox__input" autocomplete="off" type="file" name="file" id="formBox_file">
                                        <svg>
                                            <use xlink:href="{{ asset('img/sprites/sprite-mono.svg#scr') }}"></use>
                                        </svg>
                                        Прикрепить файл
                                    </label>
                                    <br>
                                    <label class="message" for="formBox_file" style="color: red">

                                    </label>
                                    <div class="formRow formRowG">
                                        <div class="inpBox">
                                            <label for="consent_5" class="ctaForm__label" style="cursor: pointer">
                                                <input type="checkbox" id="consent_5" name="consent" required data-consent style="pointer-events: none">
                                                Я даю согласие на обработку моих персональных данных в соответствии с
                                                <a href="/posts/politika-konfidencialnosti" target="_blank">Политикой конфиденциальности</a>.
                                            </label>
                                        </div>
                                    </div>
                                    <button class="ctaForm__btn ctaForm__btn--gap btn btn--md disabled" data-submit disabled type="submit">Отправить
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>


                    {{--                    <div class="container__div_one" style="">--}}
                    {{--                        <div class="box first"><img--}}
                    {{--                                src="{{ asset('upload_images/'. $solution->photos[0]['path']) }}" alt="img">--}}
                    {{--                        </div>--}}
                    {{--                        <div class="box second" style="line-height: 150%">{!! $solution->system_composition !!}</div>--}}
                    {{--                        <div class="box third">--}}
                    {{--                            <form action="{{route('index.send_mail')}}" method="post">--}}
                    {{--                                @csrf--}}
                    {{--                                <input type="hidden" id="typeOfRequest" name="typeOfRequest"--}}
                    {{--                                       value="Готовые решения">--}}
                    {{--                                <div class="ctaForm">--}}
                    {{--                                    <div class="ctaForm__body"--}}
                    {{--                                         style="background-color: #e7e7e7; padding: 20px;">--}}
                    {{--                                        <div class="t--center"--}}
                    {{--                                             style="font-size: 3.6rem;font-weight: 700; margin-bottom: 10px">Оставить--}}
                    {{--                                            заявку--}}
                    {{--                                        </div>--}}
                    {{--                                        <div class="formRow">--}}
                    {{--                                            <div class="inpBox">--}}
                    {{--                                                <input class="input input_coop" id="name" autocomplete="off" type="text"--}}
                    {{--                                                       placeholder="Ваше имя" name="username" required>--}}
                    {{--                                            </div>--}}
                    {{--                                        </div>--}}
                    {{--                                        <div class="formRow">--}}
                    {{--                                            <div class="inpBox">--}}
                    {{--                                                <input class="input input_coop" id="numb" autocomplete="off"--}}
                    {{--                                                       type="number" style="-moz-appearance: textfield;"--}}
                    {{--                                                       placeholder="Номер телефона" name="phone_number" required>--}}
                    {{--                                            </div>--}}
                    {{--                                        </div>--}}
                    {{--                                        <div class="formRow">--}}
                    {{--                                            <div class="inpBox">--}}
                    {{--                                                <input class="input input_coop" id="numb" autocomplete="off" type="text"--}}
                    {{--                                                       placeholder="Комментарий" name="customer_comment" required>--}}
                    {{--                                            </div>--}}
                    {{--                                        </div>--}}
                    {{--                                        <label class="formBox__fileLabel" for="file" name="file" style="color: #595959">--}}
                    {{--                                            <svg>--}}
                    {{--                                                <use xlink:href="{{ asset('img/sprites/sprite-mono.svg#scr') }}"--}}
                    {{--                                                     style="fill: #595959;"></use>--}}
                    {{--                                            </svg>--}}
                    {{--                                            Прикрепить файл--}}
                    {{--                                        </label>--}}
                    {{--                                        <button class="ordering__submit btn" type="submit"--}}
                    {{--                                                style="font-size: 16px;margin-left: 2px">--}}
                    {{--                                            Отправить--}}
                    {{--                                        </button>--}}
                    {{--                                        <div class="" style="margin-top: 5px; margin-right: 5px;font-size: 15px;">Нажав--}}
                    {{--                                            кнопку--}}
                    {{--                                            «Перезвонить», я даю согласие на обработку моих персональных данных--}}
                    {{--                                        </div>--}}
                    {{--                                    </div>--}}
                    {{--                                </div>--}}
                    {{--                            </form>--}}
                    {{--                            <div style="margin-top: 20px; display: flex; justify-content: space-between">--}}
                    {{--                                <div class="btn"--}}
                    {{--                                     style="background-color: #e7e7e7;border: none;color: black; margin-bottom: 20px;">--}}
                    {{--                                    <a--}}
                    {{--                                        href="http://mkrostov.ru/documents/all"><span>Все документы</span></a>--}}
                    {{--                                </div>--}}
                    {{--                                <div class="find_error_btn open_help_popup">--}}
                    {{--                                    <div class="btn" style="background-color: #e7e7e7;border: none;color: black"><a--}}
                    {{--                                            href="#"><span>Нашли ошибку?</span></a>--}}
                    {{--                                    </div>--}}
                    {{--                                </div>--}}
                    {{--                            </div>--}}
                    {{--                        </div>--}}
                    {{--                    </div>--}}

                    <div class="cta__description cta__tutorial-block">
                        <div class="cta__description-left">{!! $solution->system_composition !!}</div>

                        <div class="cta__description-right">
                            <div>
                                <div class="btn">
                                    <a href="/documents/all"><span>Все документы</span></a>
                                </div>
                            </div>
                            <div>
                                <div class="btn">
                                    <a href="#"><span>Нашли ошибку?</span></a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="cta__description">
                        <h2 style="text-align: center; margin-bottom: 15px; font-size: 30px;">Описание</h2>
                        {!! $solution->description  !!}
                    </div>
                </div>
            </div>
        </div>
    </section>

    <style>
        .cta__form {
            margin-bottom: 0;
        }

        .cta__tutorial-block {
            display: flex;
            justify-content: space-between;
        }

        .cta__description-right {
            display: flex;
            flex-direction: column;
            gap: 20px;
            align-items: flex-end;
        }

        .cta__description-right, .cta__description-left {
            width: 50%;
        }

        .cta__description-right .btn {
            background-color: #e7e7e7;
            border: none;
            color: black;
            cursor: pointer;
        }

        .cta__description-right .btn:hover {
            color: #fff;
            background-color: #006bde;
        }

        .formBox__policy a {
            color: #9af3ef;
            text-decoration: underline;
        }

        .ctaForm__body .formBox__fileLabel {
            color: #505050;
        }

        .ctaForm__body .formBox__fileLabel svg {
            fill: #505050;
        }

        .formRowG .inpBox label {
            color: #aaa;
            font-weight: 400;
            font-size: 1.4rem;
        }
        .formRowG .inpBox label a {
            color: #9af3ef;
            text-decoration: underline;
        }
        @media (max-width: 767.98px) {
            .cooperation__container {
                padding: 0;
            }

            .cta__tutorial-block {
                flex-direction: column;
            }

            .cta__description-right, .cta__description-left {
                width: 100%;
            }

            .cooperation__title {
                padding: 0 16px;
            }

            .cta__tutorial-block {
                padding-bottom: 64px;
            }
        }
    </style>
@endsection
