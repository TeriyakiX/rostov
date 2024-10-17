@if(!Str::contains(url()->current(), '/category/servis'))
    <div class="cta cooperation__cta">
       <div class="cta__body">
           <img class="cta__img" src="{{ asset('img/cooperation/construction-worker-truss-installation 1.png') }}"
                alt="img"
                loading="lazy" decoding="async" referrerPolicy="no-referrer">
           <!-- Call to action-->
           <form class="cta__form" action="{{route('index.send_mail')}}" method="post" enctype="multipart/form-data">
               @csrf
               <div class="ctaForm">
                   <div class="ctaForm__header">
                       <h3 class="ctaForm__title">По вопросам монтажа обращайтесь по телефону <a class="ctaForm__link"
                                                                                                 href="tel:+79885109787"
                                                                                                 target="_blank">
                               +7(988)510-97-87</a> или пишите на почту <a class="ctaForm__link"
                                                                           style="font-family: Gadugi"
                                                                           href="mailto:m1_mk@aaanet.ru" target="_blank">m1_mk@aaanet.ru</a><br><span
                               class="ctaForm__subtitle">или оствьте свой номер и мы перезвоним вам</span></h3>
                   </div>
                   <div class="ctaForm__body">
                       <input type="hidden" id="typeOfRequest" name="typeOfRequest" value="Запрос монтаж 1">
                       <input type="hidden"  id="link"  name="link" value="{{url()->current()}}">
                       <div class="formRow">
                           <div class="inpBox">
                               <input class="input input_coop" id="name" autocomplete="off" type="text"
                                      placeholder="Ваше имя" name="username" required>
                           </div>
                       </div>
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
                           <input class="formBox__input" autocomplete="off" type="file" name="file" id="file" style="display: none">
                           <svg>
                               <use xlink:href="{{ asset('img/sprites/sprite-mono.svg#scr') }}"
                                    style="fill: #595959;"></use>
                           </svg>
                           Прикрепить файл
                       </label>
                       <button class="ordering__submit btn" type="submit" style="font-size: 16px;margin-left: 2px">
                           Отправить
                       </button>
                       <div class="ctaForm__info">Нажав кнопку «Отправить», я даю согласие на обработку моих персональных
                           данных
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
    <div class="cooperation--cta">
        <div class="cooperation--cta_item" style="width: 65%;">
            <img class="" src="{{ asset('img/cooperation/construction-worker-truss-installation 1.png') }}"
                 alt="img"
                 loading="lazy" decoding="async" referrerPolicy="no-referrer">
        </div>
        <div class="cooperation--cta_item cooperation--cta_item-bg">
            <img class="" src="{{ asset('img/cooperation/construction-worker-truss-installation 1.png') }}"
                 alt="img"
                 loading="lazy" decoding="async" referrerPolicy="no-referrer"
                 style="transform: translate(0, 0) skewX(-20deg)">
        </div>
        <div class="cooperation--cta_item cooperation--cta_item-bg">
            <img class="" src="{{ asset('img/cooperation/construction-worker-truss-installation 1.png') }}"
                 alt="img"
                 loading="lazy" decoding="async" referrerPolicy="no-referrer"
                 style="transform: translate(0, 0) skewX(-20deg)">
        </div>
        <div class="cooperation--cta_item cooperation--cta_item-bg">
            <img class="" src="{{ asset('img/cooperation/construction-worker-truss-installation 1.png') }}"
                 alt="img"
                 loading="lazy" decoding="async" referrerPolicy="no-referrer"
                 style="transform: translate(0, 0) skewX(-20deg)">
        </div>
    </div>
        <div class="service__usluga-wrapper">
        <label class="formBox__fileLabel formBox__fileLabel-mobile" name="file" for="file" style="color: #595959; margin-bottom: 0;">
            <input class="formBox__input" autocomplete="off" type="file" name="file" id="file" style="display: none">

            <svg>
                <use xlink:href="{{ asset('img/sprites/sprite-mono.svg#scr') }}"
                     style="fill: #595959;"></use>
            </svg>
            Прикрепить файл
        </label>
        <button class="btn service_montazh_btn" type="button">
            Получить консультацию
        </button>
    </div>
</div>
@endif
<style>
    .gallery__body {
        margin-right: 0;
    }

    @media screen and (max-width: 767.98px) {
        .cooperation__container {
            padding: 0;
        }
        .cooperation__title, .pay_title, .pay_desc, .pay_info-title, .pay_info-text {
            padding: 0 16px;
        }
    }
</style>
