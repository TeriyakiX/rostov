@extends('layouts.index')

@section('seo_title', $post->seo_title)
@section('seo_description', $post->seo_description)
@section('seo_keywords', $post->seo_keywords)

@section('content')

    <div class="container">
        <div class="socials">
            <a href="mailto:m1_mk@aaanet.ru" class="socials__item" title="E-mail">
                <img src="{{ asset('img/mail.jpg') }}">
            </a>
            <a href="https://vk.com/public97309835" class="socials__item" title="Vkontakte">
                <img src="{{ asset('img/vk.jpg') }}">
            </a>
            <a href="https://wa.me/+79885109783" class="socials__item" title="Whatsapp">
                <img src="{{ asset('img/viber.jpg') }}">
            </a>
            <a href="https://t.me/+79885109783" class="socials__item" title="Telegram">
                <img src="{{ asset('img/telegram.jpg') }}">
            </a>
            <a href="viber://chat?number=%2B79885109783" class="socials__item" title="Viber">
                <img src="{{ asset('img/messanger.jpg') }}">
            </a>
            <a href="tel:+79885109783" class="socials__item" title="Звонок">
                <img src="{{ asset('img/whatsapp.jpg') }}">
            </a>
        </div>
    </div>

    <div class="minfo">
        <div class="minfo__left">
            <img src="{{ asset('img/map.png') }}" class="minfo__oa">

            <div class="bts-box">
                <script src="https://yastatic.net/share2/share.js"></script>
                <div class="ya-share2" data-curtain data-limit="0"
                     data-more-button-type="short"
                     style="background:transparent"
                     data-services="vkontakte,facebook,odnoklassniki,telegram,twitter,viber,whatsapp"></div>
                <a href="http://mkrostov.ru/img/map.png" download="">
                    <img src="{{ asset('img/down.jpg') }}">
                </a>
            </div>
        </div>
        <div class="container minfo__container">
            <div class="minfo__right">
                <div class="minfo__title">КАК К НАМ  ДОБРАТЬСЯ</div>
                <div class="minfo__subtitle" style="padding-top: 13px;">НА ОБЩЕСТВЕННОМ ТРАНСПОРТЕ:</div>

                <div class="minfo__text"><strong>N 96, 10, 94, 40, 113, 91</strong><br>
                    До остановки "Издательство Молот"<br>
                    и пройти 500-700 метров пешком.</div>

                <div class="minfo__text">N 56 До остановки "Маршальская улица"<br>
                    и пройти 300 метров пешком.</div>

                <div class="minfo__subtitle">НА АВТОМОБИЛЕ:</div>

                <div class="minfo__text"> Двигаясь со стороны кольца<br>
                    ул. Мадояна / ул. Доватора<br>
                    к ул. Малиновского справа, до ул. Малиновского<br>
                    не доезжать один светофор 500 метров.</div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="show">
            <div class="show__caption">
                <div class="show__title">ЮРИДИЧЕСКИЙ <br>И ПОЧТОВЫЙ <br>АДРЕС <br>КОМПАНИИ:</div>
                <div class="show__description">344041,<br>г. Ростов-на-Дону, <br>ул. Буквенная 25,<br>комната 6<br>ИНН: 6168056526<br>ОГРН: 1116194006444</div>
            </div>
            <div class="show__center">
                <div class="show__main">ШОУ-РУМ</div>
                <div class="show__de">ЖДЕМ В ГОСТИ:</div>
                <div class="show__de2">г. Ростов-на-Дону, ул. Доватора 144/13</div>
                <div class="show__btn"><span>3D-ТУР</span></div>
            </div>
            <div class="show__caption">
                <div class="show__title">ФИНАНСОВО- <br>БУХГАЛТЕРСКАЯ <br>СЛУЖБА:</div>
                <div class="show__description"><a href="mailto:eкonom_mк@aaanet.ru">eкonom_mк@aaanet.ru</a><br><a href="tel:+79094150711">+ 7 909 415-07-11</a></div>
                <div class="show__title">СТРОИТЕЛЬНО - <br>МОНТАЖНЫЙ <br>ОТДЕЛ:</div>
                <div class="show__description"><a href="mailto:direкtor_mк@aaanet.ru">direкtor_mк@aaanet.ru</a><br><a href="tel:+79885109786">+ 7 988 510-97-86</a></div>
            </div>
        </div>
    </div>

    <div class="minfo">
        <div class="container minfo__container">
            <div class="minfo__right minfo__right--is-revert">
                <div class="minfo__title minfo__title--is-big">СКЛАДЫ ОТГРУЗКИ МК РОСТОВ:</div>

                <div class="minfo__text">Малый склад штучного товара: г. Ростов-на-Дону ул. Доватора 144/13</div>
                <div class="minfo__text">Склад  N 1: г. Ростов-на-Дону, ул. Доватора 146Б;</div>
                <div class="minfo__text">Склад  N 2: г. Ростов-на-Дону, переулок Нефтяной, 1;</div>
                <div class="minfo__text">Склад  N 3: г. Ростов-на-Дону, проспект Стачки, 257;</div>
                <div class="minfo__text">Склад  N 4: Ростовская обл, Аксайский р-н, Ленинское с-п,</div>
                <div class="minfo__text">территория автодороги Ростов-на-Дону Волгодонск 1 км, 1;</div>

                <div class="minfo__text2" style="font-weight: bold; color:black;">Также возможна отгрузка в городах:<br>
                    Краснодар, Ставрополь, Симферополь.<br>
                    Отгрузка по предварительной записи!</div>
            </div>
        </div>
        <div class="minfo__left minfo__left--revert">
            <iframe src="https://yandex.ru/map-widget/v1/?um=constructor%3Aa6847723c0568beeac424e5da66e715f2ad978ee619b69be00eb851a25d3b8bf&amp;source=constructor" width="100%" height="400" frameborder="0"></iframe>
        </div>
    </div>

    <div class="container">
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
    </div>

    <style>

        .ya-share2__link.ya-share2__link_more.ya-share2__link_more-button-type_short {
            width:45px !important;
            height:45px !important;
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
            padding:0;
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
            color:black !important;
        }
    </style>
@endsection
