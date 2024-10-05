<div class="container__div_one">
    <div class="box first"><img
            src="{{ asset('upload_images/'.\App\Models\TurnkeySolutions::find(1)->photos[0]['path']) }}" alt="img">
    </div>
    <div class="box second">{!! \App\Models\SystemComposition::find(2)->description !!}</div>
    <div class="box third">
        <form action="{{route('index.send_mail')}}" method="post">
            @csrf
			<input type="hidden" id="typeOfRequest" name="typeOfRequest"
                                       value="Готовые решения">
            <div class="ctaForm">
                <div class="ctaForm__body" style="background-color: #e7e7e7; padding: 20px; padding-top: 0">
                    <div class="t--center" style="font-size: 3.6rem;font-weight: 700; margin-bottom: 10px">Оставить заявку</div>
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
                        <svg>
                            <use xlink:href="{{ asset('img/sprites/sprite-mono.svg#scr') }}"
                                 style="fill: #595959;"></use>
                        </svg>
                        Прикрепить файл
                    </label>
                    <button class="ordering__submit btn" type="submit" style="font-size: 16px;margin-left: 2px">
                        Отправить
                    </button>
                    <div class="" style="margin-top: 5px; margin-right: 5px;font-size: 15px;">Нажав кнопку «Перезвонить», я даю согласие на обработку моих персональных данных</div>
                </div>
            </div>
        </form>
        <div class="btn" style="background-color: #e7e7e7;border: none;color: black"><a
                href="/posts/tehnicheskie-katalogi"><span>Все документы</span></a>
        </div>
    </div>
</div>
{!! \App\Models\TurnkeySolutions::find(1)->description !!}
