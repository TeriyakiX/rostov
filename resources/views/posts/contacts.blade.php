@extends('layouts.index')

@section('seo_title', $post->seo_title)
@section('seo_description', $post->seo_description)
@section('seo_keywords', $post->seo_keywords)

@section('content')

{{--    <div class="container">--}}
{{--        <div class="socials">--}}
{{--            <a href="mailto:m1_mk@aaanet.ru" class="socials__item" title="E-mail">--}}
{{--                <img src="{{ asset('img/mail.jpg') }}">--}}
{{--            </a>--}}
{{--            <a href="https://vk.com/public97309835" class="socials__item" title="Vkontakte">--}}
{{--                <img src="{{ asset('img/vk.jpg') }}">--}}
{{--            </a>--}}
{{--            <a href="https://wa.me/+79885109783" class="socials__item" title="Whatsapp">--}}
{{--                <img src="{{ asset('img/viber.jpg') }}">--}}
{{--            </a>--}}
{{--            <a href="https://t.me/+79885109783" class="socials__item" title="Telegram">--}}
{{--                <img src="{{ asset('img/telegram.jpg') }}">--}}
{{--            </a>--}}
{{--            <a href="viber://chat?number=%2B79885109783" class="socials__item" title="Viber">--}}
{{--                <img src="{{ asset('img/messanger.jpg') }}">--}}
{{--            </a>--}}
{{--            <a href="tel:+79885109783" class="socials__item" title="Звонок">--}}
{{--                <img src="{{ asset('img/whatsapp.jpg') }}">--}}
{{--            </a>--}}
{{--        </div>--}}
{{--    </div>--}}
    <nav class="breadcrumbs">
        <div class="breadcrumbs__container _container">
            <ul class="breadcrumbs__list">
                <li class="breadcrumbs__item">
                    <a class="breadcrumbs__link" href="{{ route('index.home') }}">
                        <span>Главная</span>
                        <svg>
                            <use xlink:href="{{ asset('img/sprites/sprite-mono.svg#slideArrow') }}"></use>
                        </svg>
                    </a>
                </li>
                <li class="breadcrumbs__item">
                    <a class="breadcrumbs__link breadcrumbs__link--active" href="#">
                        <span>Контакты</span>
                        <svg>
                            <use xlink:href="{{ asset('img/icons/blue-play.svg#blue-play') }}"></use>
                        </svg>
                    </a>
                </li>
            </ul>
        </div>
    </nav>
    <div class="container contacts__container">
        <div class="contacts__title t">
            Как к нам добраться ?
        </div>
    </div>
    <div class="minfo">
        <div class="container">
            <div class="minfo__left">

                <ul class="minfo__left-breadcrumbs">
                    <li class="minfo__left-breadcrumbs-item">
                        <a href="#">
                            <span>Ул. Доватора, 144/13</span>
                        </a>
                    </li>
                    <li class="minfo__left-breadcrumbs-item">
                        <a href="tel:+79833114660">
                            <svg>
                                <use xlink:href="{{ asset('img/sprites/phone-contacts.svg#phone-contacts') }}"></use>
                            </svg>
                            <span>+ 7 (863) 311-46-60</span>
                        </a>
                    </li>
                </ul>

                <div class="minfo__left-socials">
                    <a href="mailto:m1_mk@aaanet.ru" title="E-mail" class="minfo__left-social">
                        <svg>
                            <use xlink:href="{{ asset('img/sprites/sprite-contacts.svg#c-mail') }}"></use>
                        </svg>
                    </a>

                    <a href="https://vk.com/public97309835" title="vkontakte" class="minfo__left-social">
                        <svg>
                            <use xlink:href="{{ asset('img/sprites/sprite-contacts.svg#c-vk') }}"></use>
                        </svg>
                    </a>

                    <a href="https://wa.me/+79885109783" title="whatsapp" class="minfo__left-social">
                        <svg>
                            <use xlink:href="{{ asset('img/sprites/sprite-contacts.svg#c-wapp') }}"></use>
                        </svg>
                    </a>

                    <a href="https://t.me/+79885109783" title="telegram" class="minfo__left-social">
                        <svg>
                            <use xlink:href="{{ asset('img/sprites/sprite-contacts.svg#c-tg') }}"></use>
                        </svg>
                    </a>

                    <a href="tel:+79885109783" title="Звонок" class="minfo__left-social">
                        <svg>
                            <use xlink:href="{{ asset('img/sprites/sprite-contacts.svg#c-phone') }}"></use>
                        </svg>
                    </a>
                </div>

                <div class="minfo__left-imageWrp">
                    <img src="{{ asset('img/map.png') }}" class="minfo__oa">
                </div>

                {{--            <div class="bts-box">--}}
                {{--                <script src="https://yastatic.net/share2/share.js"></script>--}}
                {{--                <div class="ya-share2" data-curtain data-limit="0"--}}
                {{--                     data-more-button-type="short"--}}
                {{--                     style="background:transparent"--}}
                {{--                     data-services="vkontakte,facebook,odnoklassniki,telegram,twitter,viber,whatsapp"></div>--}}
                {{--                <a href="http://mkrostov.ru/img/map.png" download="">--}}
                {{--                    <img src="{{ asset('img/down.jpg') }}">--}}
                {{--                </a>--}}
                {{--            </div>--}}
            </div>
            <div class="minfo__right">
                <div class="minfo__block">
                    <div class="minfo__block-inner">
                        <div class="minfo__block-imageWrp">
                            <div class="minfo__block-image">
                                <img
                                    src="{{ asset('img/contacts-car.png') }}"
                                    alt="car">
                            </div>
                        </div>
                        <div class="minfo__block-text">
                            <div class="minfo__block-title">На автомобиле:</div>
                            <div class="minfo__block-description">
                                Двигаясь со стороны кольца ул. Мадояна / ул. Доватора
                                к ул. Малиновского справа, до ул. Малиновского
                                не доезжать один светофор 500 метров.
                            </div>
                        </div>
                    </div>
                </div>
                <div class="minfo__block">
                    <div class="minfo__block-inner">
                        <div class="minfo__block-imageWrp">
                            <div class="minfo__block-image">
                                <img
                                    src="{{ asset('img/contacts-bus.png') }}"
                                    alt="car">
                            </div>
                        </div>
                        <div class="minfo__block-text">
                            <div class="minfo__block-title">На общественном транспорте:</div>
                            <div class="minfo__block-numbers">N96, 10, 94, 40, 113, 91</div>
                            <div class="minfo__block-description">
                                До остановки "Издательство Молот" и пройти 500-700 метров пешком. N56 До остановки "Маршальскаяулица" и пройти
                                300 метров пешком.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="show">
            <div class="show__caption">
                <div class="show__title">Наш адрес:</div>
                <div class="show__description">344041, г. Ростов-на-Дону, <br/>ул. Доватора, 144/13</div>

                <div class="show__title show__title-second">Связь с нами:</div>
                <div class="show__description show__description-second">
                    <div class="show__description-inner">
                        <div>
                            + 7 (863) 311 46 60
                        </div>
                        <div>
                            + 7 (988) 510 97 83
                        </div>
                    </div>

                    <div class="show__description-inner">
                        <div>
                            + 7 (863) 219 35 23
                        </div>
                        <div>
                            + 7 (903) 432 93 93
                        </div>
                    </div>

                    <div class="show__description-inner">
                        <div>
                            m1_mk@aaanet.ru
                        </div>
                        <div>
                            mk_rostov@mail.ru
                        </div>
                    </div>
                </div>
            </div>
            <div class="show__caption">
                <div style="position:relative;overflow:hidden;"><a
                        href="https://yandex.ru/maps/org/metallkrovlya_rostov/1617155339/?utm_medium=mapframe&utm_source=maps"
                        style="color:#eee;font-size:12px;position:absolute;top:0px;">МеталлКровля-Ростов</a><a
                        href="https://yandex.ru/maps/39/rostov-na-donu/category/facades_and_facade_systems/184107763/?utm_medium=mapframe&utm_source=maps"
                        style="color:#eee;font-size:12px;position:absolute;top:14px;">Фасады и фасадные системы в
                        Ростове‑на‑Дону</a><a
                        href="https://yandex.ru/maps/39/rostov-na-donu/category/plexiglass_polycarbonate/41694184644/?utm_medium=mapframe&utm_source=maps"
                        style="color:#eee;font-size:12px;position:absolute;top:28px;">Оргстекло, поликарбонат в
                        Ростове‑на‑Дону</a>
                    <iframe
                        src="https://yandex.ru/map-widget/v1/?ll=39.554230%2C47.237877&mode=search&oid=1617155339&ol=biz&panorama%5Bdirection%5D=326.887973%2C-20.042756&panorama%5Bfull%5D=true&panorama%5Bpoint%5D=39.620136%2C47.237955&panorama%5Bspan%5D=115.240878%2C60.000000&sctx=ZAAAAAgBEAAaKAoSCf58W7BUI0VAEXJuE%2B6VC0xAEhIJ6gYKvJNvB0ARNh0B3Cze7z8iBgABAgMEBSgKOABAolNIAWIhbWlkZGxlX3Bvc3RmaWx0ZXJfdGhyZXNoY2hhaW49MC42YhxtaWRkbGVfcG9zdGZpbHRlcl90aHJlc2g9MC42Yi5yZWxldl9yYW5raW5nX21zZV9mb3JtdWxhPTEuMDptc2VfZGMzNTM1MzZfZXhwYlByZWFycj1zY2hlbWVfTG9jYWwvR2VvL0J1c0dlb0Nob29zZS9UYWtlUnVicmljRmlyc3RTYW1lQnlSZXN1bHRzTXNlVGhyZXNob2xkPTAuNmoCcnWdAc3MTD2gAQCoAQC9AbRiIv%2FCAQWLqo%2BDBuoBAPIBAPgBAIICEdC80Log0KDQvtGB0YLQvtCyigIAkgIFMTA4MziaAgxkZXNrdG9wLW1hcHM%3D&sll=39.620148%2C47.237877&sspn=0.183093%2C0.075825&text=%D0%BC%D0%BA%20%D0%A0%D0%BE%D1%81%D1%82%D0%BE%D0%B2&utm_source=share&z=13"
                        frameborder="0" allowfullscreen="true"
                        style="position:relative;"></iframe>
                </div>
            </div>
        </div>
    </div>

    <div class="container" style="margin-bottom: 40px">
        <img src="{{ asset('img/travel-map.png') }}" alt="map">
    </div>

    <div class="minfo">
        <div class="container minfo__container">
            <div class="minfo__right minfo__right--is-revert">
                <div class="minfo__title minfo__title--is-big">СКЛАДЫ ОТГРУЗКИ МК РОСТОВ:</div>

                <div class="minfo__text">Малый склад штучного товара: г. Ростов-на-Дону ул. Доватора 144/13</div>
                <div class="minfo__text">Склад N 1: г. Ростов-на-Дону, ул. Доватора 146Б;</div>
                <div class="minfo__text">Склад N 2: г. Ростов-на-Дону, переулок Нефтяной, 1;</div>
                <div class="minfo__text">Склад N 3: г. Ростов-на-Дону, проспект Стачки, 257;</div>
                <div class="minfo__text">Склад N 4: Ростовская обл, Аксайский р-н, Ленинское с-п,</div>
                <div class="minfo__text">территория автодороги Ростов-на-Дону Волгодонск 1 км, 1;</div>

                <div class="minfo__text2" style="font-weight: bold; color:black;">Также возможна отгрузка в городах:<br>
                    Краснодар, Ставрополь, Симферополь.<br>
                    Отгрузка по предварительной записи!
                </div>
            </div>
        </div>
        <div class="minfo__left minfo__left--revert">
            <div style="position:relative;overflow:hidden;"><a
                    href="https://yandex.ru/maps/39/rostov-na-donu/?utm_medium=mapframe&utm_source=maps"
                    style="color:#eee;font-size:12px;position:absolute;top:0px;">Ростов‑на‑Дону</a><a
                    href="https://yandex.ru/maps/39/rostov-na-donu/?ll=39.620498%2C47.231526&mode=usermaps&source=constructorLink&um=constructor%3A77133d5c90fd390dd4be9be55db2aef2588c55f717b392d715ba91c3f31b8757&utm_medium=mapframe&utm_source=maps&z=13"
                    style="color:#eee;font-size:12px;position:absolute;top:14px;">Карта Ростова-на-Дону с улицами и
                    номерами домов — Яндекс Карты</a>
                <iframe
                    src="https://yandex.ru/map-widget/v1/?ll=39.620498%2C47.231526&mode=usermaps&source=constructorLink&um=constructor%3A77133d5c90fd390dd4be9be55db2aef2588c55f717b392d715ba91c3f31b8757&z=13"
                    width="100%" height="400" frameborder="0" allowfullscreen="true"
                    style="position:relative;"></iframe>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="contacter__wrapper">
            <div class="contacter">
                <div class="contacter__left">
                    СВЯЗАТЬСЯ С НАМИ:
                </div>
                <div class="contacter__right">
                    <div>
                        <a href="tel:+78633114660">+7 (863) 311 46 60</a>
                        <a href="tel:+78632193523">+7 (863) 219 35 23</a>
                        <a href="mailto:m1_mk@aaanet.ru">m1_mк@aaanet.ru</a>
                    </div>
                    <div>
                        <a href="tel:+79885109783">+7 (988) 510 97 83</a>
                        <a href="tel:+79034329393">+7 (903) 432 93 93</a>
                        <a href="mailto:mk-rostov@mail.ru">mк-rostov@mail.ru</a>
                    </div>
                </div>
            </div>
            <div class="contacter">
                <div class="contacter__left">
                    Финансово-бухгалтерская служба:
                </div>
                <div class="contacter__right">
                    <div>
                        <a href="tel:+79885109783">+ 7 (988) 510 97 83</a>
                        <a href="mailto:mk_rostov@mail.ru">mk_rostov@mail.ru</a>
                    </div>
                </div>
            </div>
            <div class="contacter">
                <div class="contacter__left">
                    Строительно-монтажный отдел:
                </div>
                <div class="contacter__right">
                    <div>
                        <a href="tel:+79885109783">+ 7 (988) 510 97 83</a>
                        <a href="mailto:mk_rostov@mail.ru">mk_rostov@mail.ru</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>

        .ya-share2__link.ya-share2__link_more.ya-share2__link_more-button-type_short {
            width: 45px !important;
            height: 45px !important;
            padding: 0;
        }

        body .ya-share2__container_size_m .ya-share2__badge .ya-share2__icon {
            width: 45px !important;
            height: 45px !important;
            background-size: 100% !important;
        }

        .ya-share2__container_size_m .ya-share2__item_copy .ya-share2__icon_copy,
        .ya-share2__container_size_m .ya-share2__item_more .ya-share2__icon_more {
            background-size: 24px 24px !important;
        }

        .ya-share2__popup .ya-share2__link {
            border-radius: initial !important;
        }

        .ya-share2__item_more.ya-share2__item_has-pretty-view .ya-share2__icon_more {
            background-image: url(../img/share.jpg);
        }

        .ya-share2__container_size_m .ya-share2__item_more.ya-share2__item_has-pretty-view .ya-share2__link_more.ya-share2__link_more-button-type_short {
            background: transparent !important;
            padding: 0;
        }


        .ya-share2__popup .ya-share2__list .ya-share2__item:hover, .ya-share2__popup .ya-share2__messenger-contacts-list_desktop .ya-share2__item:hover, .ya-share2__container_as-popup .ya-share2__list .ya-share2__item:hover, .ya-share2__container_as-popup .ya-share2__messenger-contacts-list_desktop .ya-share2__item:hover, .ya-share2__popup .ya-share2__list .ya-share2__item:focus, .ya-share2__popup .ya-share2__messenger-contacts-list_desktop .ya-share2__item:focus, .ya-share2__container_as-popup .ya-share2__list .ya-share2__item:focus, .ya-share2__container_as-popup .ya-share2__messenger-contacts-list_desktop .ya-share2__item:focus {
            background: transparent !important;
        }

        .ya-share2__container_size_m .ya-share2__title {
            line-height: 40px !important;
        }


        @font-face {
            font-family: "SansationRegular";
            src: url("/fonts/SansationRegular.ttf") format("truetype");
            font-style: normal;
            font-weight: normal;
        }

        @font-face {
            font-family: "SansationBold";
            src: url("/fonts/SansationBold.ttf") format("truetype");
            font-style: normal;
            font-weight: bold;
        }

        .page-contact * {
            box-sizing: border-box;
        }

        body, html {
            margin: 0;
            padding: 0;
            font-family: "SansationRegular";
            color: black !important;
        }
    </style>
@endsection
