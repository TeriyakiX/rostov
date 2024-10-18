<div class="cta cooperation__cta">
    <div class="cta__body">
    <img class="cta__img" src="{{ asset('img/cooperation/cooperation.png') }}" alt="img"
         loading="lazy" decoding="async" referrerPolicy="no-referrer">
    <!-- Call to action-->
    <form class="cta__form" action="{{route('index.send_mail')}}" method="post">
        @csrf

        <div class="ctaForm">
            <div class="ctaForm__header">
                <h3 class="ctaForm__title">По всем вопросам обращайтесь по телефону <a class="ctaForm__link" href="tel:+79885109787" target="_blank"> +7(988)510-97-87</a> или пишите на почту <a class="ctaForm__link" style="font-family: Gadugi" href="mailto:m1_mk@aaanet.ru" target="_blank">m1_mk@aaanet.ru</a><br><span class="ctaForm__subtitle">или оствьте свой номер и мы перезвоним вам</span></h3>
            </div>

            <div class="ctaForm__body">
                <div class="formRow">
                    <div class="inpBox">
                        <input class="input input_coop" id="name" name="username" autocomplete="off" type="text" placeholder="Ваше имя" required>
                    </div>
                </div>
                <input type="hidden" id="typeOfRequest" name="typeOfRequest" value="Похвалить/Пожаловаться">
                <input type="hidden"  id="link"  name="link" value="{{url()->current()}}">
                <div class="formRow">
                    <div class="inpBox">
                        <input class="input input_coop" id="numb" autocomplete="off" type="text" placeholder="Номер телефона" name="phone_number" required>
                    </div>
                </div>
                <div class="formRow">
                    <div class="inpBox">
                        <input class="input input_coop" id="numb" autocomplete="off" type="text" placeholder="Отзыв" name="customer_comment" required>
                    </div>
                </div>
                <button class="ctaForm__btn ctaForm__btn--gap btn btn--md" type="submit">Отправить</button>
                <div class="ctaForm__info">Нажав кнопку «Отправить», я даю согласие на обработку моих персональных данных</div>
            </div>
        </div>
    </form>
</div>
    <div class="post-content__body-container">
        {!! $post->body !!}
    </div>
</div>

<style>
    @media screen and (max-width: 767.98px) {
        .cooperation__container {
            padding: 0;
        }
        .cooperation__title, .pay_title, .pay_desc, .pay_info-title, .pay_info-text {
            padding: 0 16px;
        }
    }
</style>

