@include('partials.modal')
<div class="cta cooperation__cta">
    <div class="cta__body">
        <img class="cta__img" src="{{ asset('img/cooperation/cooperation.png') }}" alt="img"
             loading="lazy" decoding="async" referrerPolicy="no-referrer">
        <!-- Call to action-->
        <form class="cta__form" id="consultationForm" action="{{ route('index.send_mail') }}" method="post" data-ajax="true">
            @csrf

            <input type="hidden" name="link" value="{{ url()->current() }}">
            <div class="ctaForm">
                <div class="ctaForm__header">
                    <h3 class="ctaForm__title">По всем вопросам обращайтесь по телефону
                        <a class="ctaForm__link" href="tel:+79885109787" target="_blank"> +7(988)510-97-87</a>
                        или пишите на почту
                        <a class="ctaForm__link" style="font-family: Gadugi" href="mailto:m1_mk@aaanet.ru" target="_blank">m1_mk@aaanet.ru</a>
                        <br><span class="ctaForm__subtitle">или оставьте свой номер, и мы перезвоним вам</span>
                    </h3>
                </div>

                <div class="ctaForm__body">
                    <div class="formRow">
                        <div class="inpBox">
                            <input class="input input_coop" id="name" name="username" autocomplete="off" type="text" placeholder="Ваше имя" required>
                        </div>
                    </div>

                    <input type="hidden" id="typeOfRequest" name="typeOfRequest" value="Похвалить/Пожаловаться">
                    <input type="hidden" id="link" name="link" value="{{ url()->current() }}">

                    <div class="formRow">
                        <div class="inpBox">
                            <input class="input input_coop" id="numb" name="phone_number" autocomplete="off" type="text" placeholder="Номер телефона" required>
                        </div>
                    </div>

                    <div class="formRow">
                        <div class="inpBox">
                            <input class="input input_coop" id="numb" name="customer_comment" autocomplete="off" type="text" placeholder="Отзыв" required>
                        </div>
                    </div>
                    <div class="formRow">
                        <div class="inpBox">
                            <label for="consent" class="ctaForm__label">
                                <input type="checkbox" id="consent_2" name="consent" required>
                                Я даю своё согласие на
                                <a href="/posts/politika-konfidencialnosti" target="_blank">обработку и распространение персональных данных</a>.
                            </label>
                        </div>
                    </div>

                    <button class="ctaForm__btn ctaForm__btn--gap btn btn--md disabled" disabled type="submit">Отправить</button>
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

<style>
    .inpBox label {
        color: #aaa;
        font-weight: 400;
        font-size: 1.4rem;
    }
    .inpBox label a {
        color: #9af3ef;
        text-decoration: underline;
    }
    @media screen and (max-width: 767.98px) {
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
</style>

<script>
    const consentCheckboxPohvalitPozhalovatsya = $('#consent_2');
    const submitButtonPohvalitPozhalovatsya = $('.ctaForm__btn');

    function toggleSubmitButton() {
        if (consentCheckboxPohvalitPozhalovatsya.is(':checked')) {
            submitButtonPohvalitPozhalovatsya.removeClass('disabled').prop('disabled', false);
        } else {
            submitButtonPohvalitPozhalovatsya.addClass('disabled').prop('disabled', true);
        }
    }

    consentCheckboxPohvalitPozhalovatsya.on('change', toggleSubmitButton);

    toggleSubmitButton();
</script>
