<div class="popup popup_documentation">
    <div class="popup__content">
        <div class="popup__body popup__body_md">
            <div class="popup__close popup__cross">
                <svg>
                    <use xlink:href="/img/sprites/sprite-mono.svg#cancel"></use>
                </svg>
            </div>
            <div class="popup__box">
                <div class="popup__title t t--center">Запросить документацию</div>
                <form action="{{route('index.send_document_mail')}}" method="post">
                    @csrf
                    <div class="ctaForm">
                        <div class="ctaForm__header" style="text-align: center">
                        </div>
                        <div class="ctaForm__body">
                            <div class="formRow">
                                <input type="hidden" id="typeOfRequest" name="typeOfRequest"
                                       value="Запросить документацию">
                                <input type="hidden" value="{{url()->current()}}" id="link" name="link">
                                <div class="inpBox">
                                    <input class="input input_coop" id="name" autocomplete="off" type="text"
                                           placeholder="Ваше имя" name="username" required>
                                </div>
                            </div>
                            <div class="formRow">
                                <div class="inpBox">
                                    <input class="input input_coop" id="numb" autocomplete="off" type="text"
                                           placeholder="Номер телефона" name="phoneNumber" required>
                                </div>
                            </div>
                            <div class="formRow">
                                <div class="inpBox">
                                    <input class="input input_coop" id="numb" autocomplete="off" type="text"
                                           placeholder="E-mail" name="email" required>
                                </div>
                            </div>
                            <div class="formRow">
                                <div class="inpBox">
                                    <input class="input input_coop" id="numb" autocomplete="off" type="text"
                                           placeholder="Название документа" name="documentName" required>
                                </div>
                            </div>
                            <div class="ctaForm__info" style="margin-bottom: 12px;text-align: center">Нажав кнопку «Отправить», я даю согласие на обработку моих
                                персональных
                                данных
                            </div>
                            <button class="btn" type="submit" style="width: 100%;">Отправить</button>

                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
