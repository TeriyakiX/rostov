<div class="cta cooperation__cta">
    <div class="cta__body">
        <img class="cta__img"  src="{{ asset('img/cooperation/cooperation.png') }}" alt="img" loading="lazy" decoding="async" referrerPolicy="no-referrer">
        <!-- Call to action-->
        <form class="cta__form" action="{{route('index.send_mail')}}" method="post">
            @csrf
            <div class="ctaForm" >
                <div class="ctaForm__header">
                    <h3 class="ctaForm__title">По вопросам сотрудничества обращайтесь по телефону <a class="ctaForm__link" href="tel:+79885109787" target="_blank"> +7(988)510-97-87</a> или пишите на почту <a class="ctaForm__link" style="font-family: Gadugi" href="mailto:m1_mk@aaanet.ru" target="_blank">m1_mk@aaanet.ru</a><br><span class="ctaForm__subtitle">или оствьте свой номер и мы перезвоним вам</span></h3>
                </div>
                <input type="hidden"  id="link"  name="link" value="{{url()->current()}}">
                <div class="ctaForm__body">
                    <div class="formRow">
                        <div class="inpBox">
                            <input class="input input_coop" id="name" autocomplete="off" type="text" placeholder="Ваше имя" name="name" required>
                        </div>
                    </div>
                    <input type="hidden" id="typeOfRequest" name="typeOfRequest" value="Сотрудничество">
                    <div class="formRow">
                        <div class="inpBox">
                            <input class="input input_coop" id="numb" autocomplete="off" type="text" placeholder="Номер телефона" name="phone_number" required>
                        </div>
                    </div>
                    <div class="formRow">
                        <div class="inpBox">
                            <label for="consent" class="ctaForm__label">
                                <input type="checkbox" id="consent" name="consent" required>
                                Я даю согласие на обработку моих персональных данных в соответствии с
                                <a href="/privacy-policy" target="_blank">Политикой конфиденциальности</a>.
                            </label>
                        </div>
                    </div>

                    <div>
                        <button class="ordering__submit btn" type="submit" style="margin-left: 2px;">Отправить</button>
                    </div>
                    <div class="ctaForm__info">
                        Нажав кнопку «Отправить», я подтверждаю, что ознакомлен с
                        <a href="/privacy-policy" target="_blank">Политикой конфиденциальности</a> и соглашаюсь на обработку моих персональных данных.
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div class="cta__description">
        {!! $post->body !!}
    </div>
</div>

<style>
@media (max-width: 767.98px) {
    .cooperation__container {
        padding: 0;
    }
    .cooperation__title {
        padding: 0 16px;
    }
    .sideDash--sticky {
        padding-left: 16px;
    }
}
</style>


