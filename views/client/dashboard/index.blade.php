@extends('layouts.index')

@section('content')
    <main class="page">
        <nav class="breadcrumbs">
            <div class="breadcrumbs__container _container">
                <ul class="breadcrumbs__list">
                    <li class="breadcrumbs__item"><a class="breadcrumbs__link" href="#"><span>Главная</span>
                            <svg>
                                <use xlink:href="{{ asset('img/sprites/sprite-mono.svg#slideArrow') }}"></use>
                            </svg></a></li>
                    <li class="breadcrumbs__item"><a class="breadcrumbs__link breadcrumbs__link--active" href="#"><span>Личные данные</span></a></li>
                </ul>
            </div>
        </nav>

        <section class="personalData">
            <div class="personalData__container _container">
                <div class="personalData__content">

                    <h2 class="personalData__title t">Личные данные</h2>

                    <div class="personalData__body sideDashContainer">
                        @include('client._links')

                        <form class="personalData__form" action="{{ route('client.dashboard.update') }}" method="post">

                            @csrf

                            <!-- Checkboxes-->
                            <div class="radioBox personalData__checkboxes personalData__checkboxes--gap">
                                <div class="radioBox__item personalData__checkbox">
                                    <input class="radioBox__input" id="re1" autocomplete="off" type="radio" name="is_fiz" value="1" @if($user->is_fiz == 1) checked @endif>
                                    <label class="radioBox__label" for="re1"><span class="radioBox__icon"></span>Физ. лицо</label>
                                </div>
                                <div class="radioBox__item personalData__checkbox">
                                    <input class="radioBox__input" id="re2" autocomplete="off" type="radio" name="is_fiz" value="2" @if($user->is_fiz == 2) checked @endif>
                                    <label class="radioBox__label" for="re2"><span class="radioBox__icon"></span>Юр. лицо</label>
                                </div>
                            </div>
                            <div class="personalData__box">
                                <div class="formRow">
                                    <div class="inpBox inpBox33">
                                        <label class="req" for="name">Имя</label>
                                        <input class="input" id="name" autocomplete="off" type="text" name="name" value="{{ $user->name }}" required>
                                    </div>
                                    <div class="inpBox inpBox33">
                                        <label class="req" for="numb">Номер телефона</label>
                                        <input class="input" id="numb" autocomplete="off" type="text" name="phone_number" value="{{ $user->phone_number }}" required>
                                    </div>
                                    <div class="inpBox inpBox33">
                                        <label class="req" for="mail">E-mail</label>
                                        <input class="input" id="mail" autocomplete="off" type="email" name="email" value="{{ $user->email }}" required>
                                    </div>
                                </div>
                                <div class="formRow">
                                    <div class="inpBox inpBox33">
                                        <label class="req" for="city">Город</label>
                                        <input class="input" id="city" autocomplete="off" type="text" name="address" value="{{ $user->address }}" required>
                                    </div>
                                    <div class="inpBox inpBox66">
                                        <label class="req" for="numb">Мой статус</label>
                                        <select class="personalData__select" name="status">
                                            <option class="personalData__op" @if($user->status == 1) selected @endif value="1">Для личного пользования</option>
                                            <option class="personalData__op" @if($user->status == 2) selected @endif value="2">Строительная компания</option>
                                            <option class="personalData__op" @if($user->status == 3) selected @endif value="3">Мастер</option>
                                            <option class="personalData__op" @if($user->status == 4) selected @endif value="4">Дизайнер</option>
                                            <option class="personalData__op" @if($user->status == 5) selected @endif value="5">Архитектор</option>
                                            <option class="personalData__op" @if($user->status == 6) selected @endif value="6">Торговая организация</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="formRow">
                                <div class="inpBox">
                                    <h3 class="personalData__subtitle personalData__subtitle--gap">Я хочу получать рассылку:</h3>
                                    <div class="personalData__checkboxes">
                                        <div class="checkbox personalData__checkbox">
                                            <input class="checkbox__input" autocomplete="off" id="chbx_1" type="checkbox" name="form[]" checked>
                                            <label class="checkbox__label" for="chbx_1">Акции и скидки</label>
                                        </div>
                                        <div class="checkbox personalData__checkbox">
                                            <input class="checkbox__input" autocomplete="off" id="chbx_2" type="checkbox" name="form[]" checked>
                                            <label class="checkbox__label" for="chbx_2">Новинки ассортимента</label>
                                        </div>
                                    </div>
                                    <button class="personalData__btn personalData__btn--gap btn btn--md" type="submit">Подтвердить</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
