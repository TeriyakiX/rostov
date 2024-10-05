@if(!Str::contains(url()->current(), '/category/servis'))
    <div class="cta cooperation__cta">
        <img class="cta__img" src="{{ asset('img/cooperation/young-man-delivering-order 2.png') }}" alt="img"
             loading="lazy" decoding="async" referrerPolicy="no-referrer" style="max-height: 502px">
        <!-- Call to action-->

        <form class="cta__form" action="{{route('index.send_mail')}}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="ctaForm">

                <div class="ctaForm__header">
                    <h3 class="ctaForm__title">По вопросам доставки обращайтесь по телефону <a class="ctaForm__link"
                                                                                               href="tel:+79885109787"
                                                                                               target="_blank">
                            +7(988)510-97-87</a> или пишите на почту <a class="ctaForm__link"
                                                                        style="font-family: Gadugi"
                                                                        href="mailto:m1_mk@aaanet.ru" target="_blank">m1_mk@aaanet.ru</a><br><span
                            class="ctaForm__subtitle">или оствьте свой номер и мы перезвоним вам</span></h3>
                </div>
                <div class="ctaForm__body">
                    <div class="formRow">
                        <div class="inpBox">
                            <input class="input input_coop" id="address" name="address" autocomplete="off" type="text"
                                   placeholder="Адрес доставки" required>
                        </div>
                    </div>
                    <input type="hidden" value="{{url()->current()}}" id="link">
                    <div class="formRow">
                        <div class="inpBox">
                            <input class="input input_coop" id="numb" autocomplete="off" type="number"
                                   placeholder="Номер телефона" name="phone_number" required>
                        </div>
                    </div>
                    <input type="hidden" id="typeOfRequest" name="typeOfRequest" value="Запрос доставка 1">
                    <input type="hidden"  id="link"  name="link" value="{{url()->current()}}">
                    <div class="formRow">
                        <div class="inpBox">
                            <input class="input input_coop" id="comment" autocomplete="off" type="text"
                                   placeholder="Комментарий к заказу" name="customer_comment" required>
                        </div>
                    </div>
                    <label class="formBox__fileLabel" name="file" for="file" style="color: #595959">
                        <input class="formBox__input" autocomplete="off" type="file" name="file" id="file" style="display: none">

                        <svg>
                            <use xlink:href="{{ asset('img/sprites/sprite-mono.svg#scr') }}"
                                 style="fill: #595959;"></use>
                        </svg>
                        Прикрепить файл
                    </label>
                    <div>
                        <button class="ordering__submit btn" type="submit" style="margin-left: 2px;">Отправить</button>
                    </div>
                    <div class="ctaForm__info">Нажав кнопку «Отправить», я даю согласие на обработку моих персональных
                        данных
                    </div>
                </div>
            </div>
        </form>
        <div class="post-content__body-container">
            {!! $post->body !!}
        </div>
    </div>
@else
    <div class="contentContainer">
        {!! $post->preview !!}
        <div class="cooperation--cta">
            <div class="cooperation--cta_item">
                <img class="" src="{{ asset('img/cooperation/young-man-delivering-order 2.png') }}" alt="img"
                     loading="lazy" decoding="async" referrerPolicy="no-referrer">
            </div>
            <div class="cooperation--cta_item cooperation--cta_item-bg">
                <img class="" src="{{ asset('img/cooperation/young-man-delivering-order 2.png') }}" alt="img"
                     loading="lazy" decoding="async" referrerPolicy="no-referrer"
                     style="transform: translate(0, 0) skewX(-20deg)">
            </div>
            <div class="cooperation--cta_item cooperation--cta_item-bg">
                <img class="" src="{{ asset('img/cooperation/young-man-delivering-order 2.png') }}" alt="img"
                     loading="lazy" decoding="async" referrerPolicy="no-referrer"
                     style="transform: translate(0, 0) skewX(-20deg)">
            </div>
        </div>
        <div>
            <button class="btn service_usluga_btn" type="button" style="margin-bottom: 20px;">
                Оставить заявку
            </button>
        </div>
    </div>
    <style>
        @media screen and (max-width: 900px) {

        }

    </style>
@endif





