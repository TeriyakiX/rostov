@extends('layouts.index')
<style>
    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    /* Firefox */
    input[type=number] {
        -moz-appearance: textfield;
    }
</style>
@section('content')
    <section class="cooperation">
        <div class="cooperation__container _container">
            <div class="cooperation__content">
                <div class="cooperation__body sideDashContainer">
                    <nav class="breadcrumbs">
                        <div class="breadcrumbs__container _container">
                            <ul class="breadcrumbs__list">
                                <li class="breadcrumbs__item"><a class="breadcrumbs__link" href="/"><span>Главная</span>
                                        <svg>
                                            <use
                                                xlink:href="{{ asset('img/sprites/sprite-mono.svg#slideArrow') }}"></use>
                                        </svg>
                                    </a></li>
                                <li class="breadcrumbs__item"><a class="breadcrumbs__link"
                                                                 href="/posts/gotovye-resheniya"><span>Готовые решения</span>
                                        <svg>
                                            <use
                                                xlink:href="{{ asset('img/sprites/sprite-mono.svg#slideArrow') }}"></use>
                                        </svg>
                                    </a>
                                </li>
                                <li class="breadcrumbs__item"><a class="breadcrumbs__link breadcrumbs__link--active"
                                                                 href="#"><span>{{ $solution->title }}</span></a>
                                </li>
                            </ul>
                        </div>
                        <div class="find_error_btn open_help_popup" style="display:flex; justify-content: flex-end;">
                            <div class="btn" style="background-color: #e7e7e7;border: none;color: black"><a
                                    href="#"><span>Нашли ошибку?</span></a>
                            </div>
                        </div>
                    </nav>
                    <div class="container__div_one" style="">
                        <div class="box first"><img
                                src="{{ asset('upload_images/'. $solution->photos[0]['path']) }}" alt="img">
                        </div>
                        <div class="box second">{!! $solution->system_composition !!}</div>
                        <div class="box third">
                            <form action="{{route('index.send_mail')}}" method="post">
                                @csrf
								<input type="hidden" id="typeOfRequest" name="typeOfRequest"
                                       value="Готовые решения">
                                <div class="ctaForm">
                                    <div class="ctaForm__body"
                                         style="background-color: #e7e7e7; padding: 20px; padding-top: 0">
                                        <div class="t--center"
                                             style="font-size: 3.6rem;font-weight: 700; margin-bottom: 10px">Оставить
                                            заявку
                                        </div>
                                        <div class="formRow">
                                            <div class="inpBox">
                                                <input class="input input_coop" id="name" autocomplete="off" type="text"
                                                       placeholder="Ваше имя" name="username" required>
                                            </div>
                                        </div>
                                        <div class="formRow">
                                            <div class="inpBox">
                                                <input class="input input_coop" id="numb" autocomplete="off"
                                                       type="number" style="-moz-appearance: textfield;"
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
                                        <button class="ordering__submit btn" type="submit"
                                                style="font-size: 16px;margin-left: 2px">
                                            Отправить
                                        </button>
                                        <div class="" style="margin-top: 5px; margin-right: 5px;font-size: 15px;">Нажав
                                            кнопку
                                            «Перезвонить», я даю согласие на обработку моих персональных данных
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <div class="btn"
                                 style="background-color: #e7e7e7;border: none;color: black; margin-bottom: 20px; margin-top: 20px">
                                <a
                                    href="http://mkrostov.ru/documents/all"><span>Все документы</span></a>
                            </div>
                        </div>
                    </div>

                    <div style="margin-top: 20px">
                        <h2 style="text-align: center; margin-bottom: 15px; font-size: 30px;">Описание</h2>
                        {!! $solution->description  !!}
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
