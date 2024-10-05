<div class="cta cooperation__cta">
    <img class="cta__img"  src="{{ asset('img/cooperation/cooperation.png') }}" alt="img" loading="lazy" style="max-height: 404px" decoding="async" referrerPolicy="no-referrer">
    <!-- Call to action-->
    <form class="cta__form">
        <div class="ctaForm" action="#" method="post">
            <div class="ctaForm__header">
                <h3 class="ctaForm__title">По вопросам сотрудничества обращайтесь по телефону <a class="ctaForm__link" href="tel:+79885109787" target="_blank"> +7(988)510-97-87</a> или пишите на почту <a class="ctaForm__link" style="font-family: Gadugi" href="mailto:m1_mk@aaanet.ru" target="_blank">m1_mk@aaanet.ru</a><br><span class="ctaForm__subtitle">или оствьте свой номер и мы перезвоним вам</span></h3>
            </div>
            <div class="ctaForm__body">
                <div class="formRow">
                    <div class="inpBox">
                        <input class="input input_coop" id="name" autocomplete="off" type="text" placeholder="Ваше имя" name="form[]" required>
                    </div>
                </div>
                <div class="formRow">
                    <div class="inpBox">
                        <input class="input input_coop" id="numb" autocomplete="off" type="text" placeholder="Номер телефона" name="form[]" required>
                    </div>
                </div>
                <button class="ctaForm__btn ctaForm__btn--gap btn btn--md" type="submit">Отправить</button>
                <div class="ctaForm__info">Нажав кнопку «Отправить», я даю согласие на обработку моих персональных данных</div>
            </div>
        </div>
    </form>
    {!! $post->body !!}
</div>


