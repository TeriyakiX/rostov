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
                    <li class="breadcrumbs__item"><a class="breadcrumbs__link breadcrumbs__link--active" href="#"><span>Документация</span>
                            <svg>
                                <use xlink:href="{{ asset('img/icons/blue-play.svg#blue-play') }}"></use>
                            </svg></a></li>
                </ul>
            </div>
        </nav>
        <section class="history">
            <div class="history__container _container">
                <div class="history__content">
                    <div class="history__head">
                        <h2 class="history__title t">История заказов</h2>
                        <div class="history__getDocs btn" role="button" tabindex="0">Запросить документацию</div>
                    </div>
                    <div class="history__body accordHistory">
                        <div class="history__titlesBox">
                            <div class="history__row">
                                <div class="history__col">Номер заказа </div>
                                <div class="history__col">Дата заказа</div>
                                <div class="history__col">Сумма</div>
                                <div class="history__col">Статус</div>
                            </div>
                        </div>
                        <div class="history__spollerBox ac">
                            <div class="history__spoller">
                                <div class="history__row">
                                    <div class="history__col">№ 12345</div>
                                    <div class="history__col">09.09.2021</div>
                                    <div class="history__col">369 000 р</div>
                                    <div class="history__col">
                                        <div class="history__statusBox">
                                            <div class="history__status">Ожидает оплаты</div>
                                        </div>
                                        <div class="history__icons">
                                            <div class="history__icon">
                                                <svg>
                                                    <use xlink:href="{{ asset('img/sprites/sprite-mono.svg#chat') }}"></use>
                                                </svg>1
                                            </div>
                                            <div class="history__icon">
                                                <svg>
                                                    <use xlink:href="{{ asset('img/sprites/sprite-mono.svg#file') }}"></use>
                                                </svg>1
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="history__spollerTrigger ac-trigger on">
                                    <svg>
                                        <use xlink:href="{{ asset('img/sprites/sprite-mono.svg#sel3') }}"></use>
                                    </svg>
                                </div>
                            </div>
                            <div class="history__spollerPanel ac-panel">
                                <div class="history__panelGrid">
                                    <div class="history__panelBody">
                                        <div class="history__panelCardWrp">
                                            <div class="history__panelCard">
                                                <div class="history__imgBox"><a class="history__imgWrp ibg" href="#">
                                                        <picture>
                                                            <source type="image/webp" srcset="./img/history//h.webp"><img src="./img/history//h.jpg" alt="h">
                                                        </picture></a></div>
                                                <div class="history__panelCardInfo">
                                                    <div class="history__panelCardCol"><a class="link" href="#">Металлочерепица класик 0,5 Satin RAL 3005 красное вино</a></div>
                                                    <div class="history__panelCardCol">Кол-во: 2 шт</div>
                                                    <div class="history__panelCardCol">123 000 ₽</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="history__panelCardWrp">
                                            <div class="history__panelCard">
                                                <div class="history__imgBox"><a class="history__imgWrp ibg" href="#">
                                                        <picture>
                                                            <source type="image/webp" srcset="./img/history//h.webp"><img src="./img/history//h.jpg" alt="h">
                                                        </picture></a></div>
                                                <div class="history__panelCardInfo">
                                                    <div class="history__panelCardCol"><a class="link" href="#">Металлочерепица класик 0,5 Satin RAL 3005 красное вино</a></div>
                                                    <div class="history__panelCardCol">Кол-во: 2 шт</div>
                                                    <div class="history__panelCardCol">123 000 ₽</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="history__panelCardWrp">
                                            <div class="history__panelCard">
                                                <div class="history__imgBox"><a class="history__imgWrp ibg" href="#">
                                                        <picture>
                                                            <source type="image/webp" srcset="./img/history//h.webp"><img src="./img/history//h.jpg" alt="h">
                                                        </picture></a></div>
                                                <div class="history__panelCardInfo">
                                                    <div class="history__panelCardCol"><a class="link" href="#">Металлочерепица класик 0,5 Satin RAL 3005 красное вино</a></div>
                                                    <div class="history__panelCardCol">Кол-во: 2 шт</div>
                                                    <div class="history__panelCardCol">123 000 ₽</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="history__panelCardWrp">
                                            <div class="history__panelCard">
                                                <div class="history__imgBox"><a class="history__imgWrp ibg" href="#">
                                                        <picture>
                                                            <source type="image/webp" srcset="./img/history//h.webp"><img src="./img/history//h.jpg" alt="h">
                                                        </picture></a></div>
                                                <div class="history__panelCardInfo">
                                                    <div class="history__panelCardCol"><a class="link" href="#">Металлочерепица класик 0,5 Satin RAL 3005 красное вино</a></div>
                                                    <div class="history__panelCardCol">Кол-во: 2 шт</div>
                                                    <div class="history__panelCardCol">123 000 ₽</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="history__commentsContainer">
                                            <div class="history__commentsBox ac">
                                                <div class="history__commentsSpoller">
                                                    <svg class="history__commentsChat">
                                                        <use xlink:href="{{ asset('img/sprites/sprite-mono.svg#chat') }}"></use>
                                                    </svg>2 комментария к заказу
                                                    <div class="history__commentsPlug ac-trigger">
                                                        <svg class="history__commentsSel">
                                                            <use xlink:href="{{ asset('img/sprites/sprite-mono.svg#sel3') }}"></use>
                                                        </svg>
                                                    </div>
                                                </div>
                                                <div class="history__commentsPanel ac-panel">
                                                    <div class="history__comment">
                                                        <div class="history__commentHead">
                                                            <div class="history__commentName">Менеджер Анна</div>
                                                            <div class="history__commentTime">10 дней назад</div>
                                                        </div>
                                                        <div class="history__commentBody">К сожалению, нам пришлось отменить заказ, поскольку истек срок оплаты заказа банку. Вы можете повторить заказ</div>
                                                        <div class="history__commentAnswer link" role="button" tabindex="0">Ответить</div>
                                                    </div>
                                                    <div class="history__comment">
                                                        <div class="history__commentHead">
                                                            <div class="history__commentName">Я</div>
                                                            <div class="history__commentTime">9 дней назад</div>
                                                        </div>
                                                        <div class="history__commentBody">Спасибо! Буду разбираться</div>
                                                    </div>
                                                    <form class="history__form" action="#" method="post">
                                                        <textarea class="history__textarea" name="message" data-value="Начните вводить сообщение" value=""></textarea>
                                                        <div class="history__commentControls">
                                                            <div class="history__smileBox" id="emoji-trigger">
                                                                <svg>
                                                                    <use xlink:href="{{ asset('img/sprites/sprite-mono.svg#smile') }}"></use>
                                                                </svg>
                                                            </div>
                                                            <button class="history__submit" type="button">Отправить</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="history__panelSide">
                                        <ul class="history__panelSideList">
                                            <li class="history__panelSideItem">Общая стоимость:<span>330 000 ₽</span></li>
                                            <li class="history__panelSideItem">Стоимость товаров:<span>326 000 ₽</span></li>
                                            <li class="history__panelSideItem">Общая стоимость:<span>1 200 ₽</span></li>
                                            <li class="history__panelSideItem">Общая стоимость:<span>1 200 ₽</span></li>
                                        </ul>
                                        <div class="history__pay btn" role="button" tabindex="0">Оплатить online</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="history__spollerBox ac">
                            <div class="history__spoller">
                                <div class="history__row">
                                    <div class="history__col">№ 12345</div>
                                    <div class="history__col">09.09.2021</div>
                                    <div class="history__col">369 000 р</div>
                                    <div class="history__col">
                                        <div class="history__statusBox">
                                            <div class="history__status">Ожидает оплаты</div>
                                        </div>
                                        <div class="history__icons">
                                            <div class="history__icon">
                                                <svg>
                                                    <use xlink:href="{{ asset('img/sprites/sprite-mono.svg#chat') }}"></use>
                                                </svg>1
                                            </div>
                                            <div class="history__icon">
                                                <svg>
                                                    <use xlink:href="{{ asset('img/sprites/sprite-mono.svg#file') }}"></use>
                                                </svg>1
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="history__spollerTrigger ac-trigger on">
                                    <svg>
                                        <use xlink:href="{{ asset('img/sprites/sprite-mono.svg#sel3') }}"></use>
                                    </svg>
                                </div>
                            </div>
                            <div class="history__spollerPanel ac-panel">
                                <div class="history__panelGrid">
                                    <div class="history__panelBody">
                                        <div class="history__panelCardWrp">
                                            <div class="history__panelCard">
                                                <div class="history__imgBox"><a class="history__imgWrp ibg" href="#">
                                                        <picture>
                                                            <source type="image/webp" srcset="./img/history//h.webp"><img src="./img/history//h.jpg" alt="h">
                                                        </picture></a></div>
                                                <div class="history__panelCardInfo">
                                                    <div class="history__panelCardCol"><a class="link" href="#">Металлочерепица класик 0,5 Satin RAL 3005 красное вино</a></div>
                                                    <div class="history__panelCardCol">Кол-во: 2 шт</div>
                                                    <div class="history__panelCardCol">123 000 ₽</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="history__panelCardWrp">
                                            <div class="history__panelCard">
                                                <div class="history__imgBox"><a class="history__imgWrp ibg" href="#">
                                                        <picture>
                                                            <source type="image/webp" srcset="./img/history//h.webp"><img src="./img/history//h.jpg" alt="h">
                                                        </picture></a></div>
                                                <div class="history__panelCardInfo">
                                                    <div class="history__panelCardCol"><a class="link" href="#">Металлочерепица класик 0,5 Satin RAL 3005 красное вино</a></div>
                                                    <div class="history__panelCardCol">Кол-во: 2 шт</div>
                                                    <div class="history__panelCardCol">123 000 ₽</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="history__panelCardWrp">
                                            <div class="history__panelCard">
                                                <div class="history__imgBox"><a class="history__imgWrp ibg" href="#">
                                                        <picture>
                                                            <source type="image/webp" srcset="./img/history//h.webp"><img src="./img/history//h.jpg" alt="h">
                                                        </picture></a></div>
                                                <div class="history__panelCardInfo">
                                                    <div class="history__panelCardCol"><a class="link" href="#">Металлочерепица класик 0,5 Satin RAL 3005 красное вино</a></div>
                                                    <div class="history__panelCardCol">Кол-во: 2 шт</div>
                                                    <div class="history__panelCardCol">123 000 ₽</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="history__panelCardWrp">
                                            <div class="history__panelCard">
                                                <div class="history__imgBox"><a class="history__imgWrp ibg" href="#">
                                                        <picture>
                                                            <source type="image/webp" srcset="./img/history//h.webp"><img src="./img/history//h.jpg" alt="h">
                                                        </picture></a></div>
                                                <div class="history__panelCardInfo">
                                                    <div class="history__panelCardCol"><a class="link" href="#">Металлочерепица класик 0,5 Satin RAL 3005 красное вино</a></div>
                                                    <div class="history__panelCardCol">Кол-во: 2 шт</div>
                                                    <div class="history__panelCardCol">123 000 ₽</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="history__commentsContainer">
                                            <div class="history__commentsBox ac">
                                                <div class="history__commentsSpoller">
                                                    <svg class="history__commentsChat">
                                                        <use xlink:href="{{ asset('img/sprites/sprite-mono.svg#chat') }}"></use>
                                                    </svg>2 комментария к заказу
                                                    <div class="history__commentsPlug ac-trigger">
                                                        <svg class="history__commentsSel">
                                                            <use xlink:href="{{ asset('img/sprites/sprite-mono.svg#sel3') }}"></use>
                                                        </svg>
                                                    </div>
                                                </div>
                                                <div class="history__commentsPanel ac-panel">
                                                    <div class="history__comment">
                                                        <div class="history__commentHead">
                                                            <div class="history__commentName">Менеджер Анна</div>
                                                            <div class="history__commentTime">10 дней назад</div>
                                                        </div>
                                                        <div class="history__commentBody">К сожалению, нам пришлось отменить заказ, поскольку истек срок оплаты заказа банку. Вы можете повторить заказ</div>
                                                        <div class="history__commentAnswer link" role="button" tabindex="0">Ответить</div>
                                                    </div>
                                                    <div class="history__comment">
                                                        <div class="history__commentHead">
                                                            <div class="history__commentName">Я</div>
                                                            <div class="history__commentTime">9 дней назад</div>
                                                        </div>
                                                        <div class="history__commentBody">Спасибо! Буду разбираться</div>
                                                    </div>
                                                    <form class="history__form" action="#" method="post">
                                                        <textarea class="history__textarea" name="message" data-value="Начните вводить сообщение" value=""></textarea>
                                                        <div class="history__commentControls">
                                                            <div class="history__smileBox" id="emoji-trigger">
                                                                <svg>
                                                                    <use xlink:href="{{ asset('img/sprites/sprite-mono.svg#smile') }}"></use>
                                                                </svg>
                                                            </div>
                                                            <button class="history__submit" type="button">Отправить</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="history__panelSide">
                                        <ul class="history__panelSideList">
                                            <li class="history__panelSideItem">Общая стоимость:<span>330 000 ₽</span></li>
                                            <li class="history__panelSideItem">Стоимость товаров:<span>326 000 ₽</span></li>
                                            <li class="history__panelSideItem">Общая стоимость:<span>1 200 ₽</span></li>
                                            <li class="history__panelSideItem">Общая стоимость:<span>1 200 ₽</span></li>
                                        </ul>
                                        <div class="history__pay btn" role="button" tabindex="0">Оплатить online</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="history__spollerBox ac">
                            <div class="history__spoller">
                                <div class="history__row">
                                    <div class="history__col">№ 12345</div>
                                    <div class="history__col">09.09.2021</div>
                                    <div class="history__col">369 000 р</div>
                                    <div class="history__col">
                                        <div class="history__statusBox">
                                            <div class="history__status paid">Оплачен</div>
                                        </div>
                                        <div class="history__icons">
                                            <div class="history__icon">
                                                <svg>
                                                    <use xlink:href="{{ asset('img/sprites/sprite-mono.svg#chat') }}"></use>
                                                </svg>1
                                            </div>
                                            <div class="history__icon">
                                                <svg>
                                                    <use xlink:href="{{ asset('img/sprites/sprite-mono.svg#file') }}"></use>
                                                </svg>1
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="history__spollerTrigger ac-trigger on">
                                    <svg>
                                        <use xlink:href="{{ asset('img/sprites/sprite-mono.svg#sel3') }}"></use>
                                    </svg>
                                </div>
                            </div>
                            <div class="history__spollerPanel ac-panel">
                                <div class="history__panelGrid">
                                    <div class="history__panelBody">
                                        <div class="history__panelCardWrp">
                                            <div class="history__panelCard">
                                                <div class="history__imgBox"><a class="history__imgWrp ibg" href="#">
                                                        <picture>
                                                            <source type="image/webp" srcset="./img/history//h.webp"><img src="./img/history//h.jpg" alt="h">
                                                        </picture></a></div>
                                                <div class="history__panelCardInfo">
                                                    <div class="history__panelCardCol"><a class="link" href="#">Металлочерепица класик 0,5 Satin RAL 3005 красное вино</a></div>
                                                    <div class="history__panelCardCol">Кол-во: 2 шт</div>
                                                    <div class="history__panelCardCol">123 000 ₽</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="history__panelCardWrp">
                                            <div class="history__panelCard">
                                                <div class="history__imgBox"><a class="history__imgWrp ibg" href="#">
                                                        <picture>
                                                            <source type="image/webp" srcset="./img/history//h.webp"><img src="./img/history//h.jpg" alt="h">
                                                        </picture></a></div>
                                                <div class="history__panelCardInfo">
                                                    <div class="history__panelCardCol"><a class="link" href="#">Металлочерепица класик 0,5 Satin RAL 3005 красное вино</a></div>
                                                    <div class="history__panelCardCol">Кол-во: 2 шт</div>
                                                    <div class="history__panelCardCol">123 000 ₽</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="history__panelCardWrp">
                                            <div class="history__panelCard">
                                                <div class="history__imgBox"><a class="history__imgWrp ibg" href="#">
                                                        <picture>
                                                            <source type="image/webp" srcset="./img/history//h.webp"><img src="./img/history//h.jpg" alt="h">
                                                        </picture></a></div>
                                                <div class="history__panelCardInfo">
                                                    <div class="history__panelCardCol"><a class="link" href="#">Металлочерепица класик 0,5 Satin RAL 3005 красное вино</a></div>
                                                    <div class="history__panelCardCol">Кол-во: 2 шт</div>
                                                    <div class="history__panelCardCol">123 000 ₽</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="history__panelCardWrp">
                                            <div class="history__panelCard">
                                                <div class="history__imgBox"><a class="history__imgWrp ibg" href="#">
                                                        <picture>
                                                            <source type="image/webp" srcset="./img/history//h.webp"><img src="./img/history//h.jpg" alt="h">
                                                        </picture></a></div>
                                                <div class="history__panelCardInfo">
                                                    <div class="history__panelCardCol"><a class="link" href="#">Металлочерепица класик 0,5 Satin RAL 3005 красное вино</a></div>
                                                    <div class="history__panelCardCol">Кол-во: 2 шт</div>
                                                    <div class="history__panelCardCol">123 000 ₽</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="history__commentsContainer">
                                            <div class="history__commentsBox ac">
                                                <div class="history__commentsSpoller">
                                                    <svg class="history__commentsChat">
                                                        <use xlink:href="{{ asset('img/sprites/sprite-mono.svg#chat') }}"></use>
                                                    </svg>2 комментария к заказу
                                                    <div class="history__commentsPlug ac-trigger">
                                                        <svg class="history__commentsSel">
                                                            <use xlink:href="{{ asset('img/sprites/sprite-mono.svg#sel3') }}"></use>
                                                        </svg>
                                                    </div>
                                                </div>
                                                <div class="history__commentsPanel ac-panel">
                                                    <div class="history__comment">
                                                        <div class="history__commentHead">
                                                            <div class="history__commentName">Менеджер Анна</div>
                                                            <div class="history__commentTime">10 дней назад</div>
                                                        </div>
                                                        <div class="history__commentBody">К сожалению, нам пришлось отменить заказ, поскольку истек срок оплаты заказа банку. Вы можете повторить заказ</div>
                                                        <div class="history__commentAnswer link" role="button" tabindex="0">Ответить</div>
                                                    </div>
                                                    <div class="history__comment">
                                                        <div class="history__commentHead">
                                                            <div class="history__commentName">Я</div>
                                                            <div class="history__commentTime">9 дней назад</div>
                                                        </div>
                                                        <div class="history__commentBody">Спасибо! Буду разбираться</div>
                                                    </div>
                                                    <form class="history__form" action="#" method="post">
                                                        <textarea class="history__textarea" name="message" data-value="Начните вводить сообщение" value=""></textarea>
                                                        <div class="history__commentControls">
                                                            <div class="history__smileBox" id="emoji-trigger">
                                                                <svg>
                                                                    <use xlink:href="{{ asset('img/sprites/sprite-mono.svg#smile') }}"></use>
                                                                </svg>
                                                            </div>
                                                            <button class="history__submit" type="button">Отправить</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="history__panelSide">
                                        <ul class="history__panelSideList">
                                            <li class="history__panelSideItem">Общая стоимость:<span>330 000 ₽</span></li>
                                            <li class="history__panelSideItem">Стоимость товаров:<span>326 000 ₽</span></li>
                                            <li class="history__panelSideItem">Общая стоимость:<span>1 200 ₽</span></li>
                                            <li class="history__panelSideItem">Общая стоимость:<span>1 200 ₽</span></li>
                                        </ul>
                                        <div class="history__pay btn" role="button" tabindex="0">Оплатить online</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="history__spollerBox ac">
                            <div class="history__spoller">
                                <div class="history__row">
                                    <div class="history__col">№ 12345</div>
                                    <div class="history__col">09.09.2021</div>
                                    <div class="history__col">369 000 р</div>
                                    <div class="history__col">
                                        <div class="history__statusBox">
                                            <div class="history__status cancell">Отменён</div>
                                            <div class="history__substatus">Истёк срок оплаты</div>
                                        </div>
                                        <div class="history__icons">
                                            <div class="history__icon">
                                                <svg>
                                                    <use xlink:href="{{ asset('img/sprites/sprite-mono.svg#chat') }}"></use>
                                                </svg>1
                                            </div>
                                            <div class="history__icon">
                                                <svg>
                                                    <use xlink:href="{{ asset('img/sprites/sprite-mono.svg#file') }}"></use>
                                                </svg>1
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="history__spollerTrigger ac-trigger on">
                                    <svg>
                                        <use xlink:href="{{ asset('img/sprites/sprite-mono.svg#sel3') }}"></use>
                                    </svg>
                                </div>
                            </div>
                            <div class="history__spollerPanel ac-panel">
                                <div class="history__panelGrid">
                                    <div class="history__panelBody">
                                        <div class="history__panelCardWrp">
                                            <div class="history__panelCard">
                                                <div class="history__imgBox"><a class="history__imgWrp ibg" href="#">
                                                        <picture>
                                                            <source type="image/webp" srcset="./img/history//h.webp"><img src="./img/history//h.jpg" alt="h">
                                                        </picture></a></div>
                                                <div class="history__panelCardInfo">
                                                    <div class="history__panelCardCol"><a class="link" href="#">Металлочерепица класик 0,5 Satin RAL 3005 красное вино</a></div>
                                                    <div class="history__panelCardCol">Кол-во: 2 шт</div>
                                                    <div class="history__panelCardCol">123 000 ₽</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="history__panelCardWrp">
                                            <div class="history__panelCard">
                                                <div class="history__imgBox"><a class="history__imgWrp ibg" href="#">
                                                        <picture>
                                                            <source type="image/webp" srcset="./img/history//h.webp"><img src="./img/history//h.jpg" alt="h">
                                                        </picture></a></div>
                                                <div class="history__panelCardInfo">
                                                    <div class="history__panelCardCol"><a class="link" href="#">Металлочерепица класик 0,5 Satin RAL 3005 красное вино</a></div>
                                                    <div class="history__panelCardCol">Кол-во: 2 шт</div>
                                                    <div class="history__panelCardCol">123 000 ₽</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="history__panelCardWrp">
                                            <div class="history__panelCard">
                                                <div class="history__imgBox"><a class="history__imgWrp ibg" href="#">
                                                        <picture>
                                                            <source type="image/webp" srcset="./img/history//h.webp"><img src="./img/history//h.jpg" alt="h">
                                                        </picture></a></div>
                                                <div class="history__panelCardInfo">
                                                    <div class="history__panelCardCol"><a class="link" href="#">Металлочерепица класик 0,5 Satin RAL 3005 красное вино</a></div>
                                                    <div class="history__panelCardCol">Кол-во: 2 шт</div>
                                                    <div class="history__panelCardCol">123 000 ₽</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="history__panelCardWrp">
                                            <div class="history__panelCard">
                                                <div class="history__imgBox"><a class="history__imgWrp ibg" href="#">
                                                        <picture>
                                                            <source type="image/webp" srcset="./img/history//h.webp"><img src="./img/history//h.jpg" alt="h">
                                                        </picture></a></div>
                                                <div class="history__panelCardInfo">
                                                    <div class="history__panelCardCol"><a class="link" href="#">Металлочерепица класик 0,5 Satin RAL 3005 красное вино</a></div>
                                                    <div class="history__panelCardCol">Кол-во: 2 шт</div>
                                                    <div class="history__panelCardCol">123 000 ₽</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="history__commentsContainer">
                                            <div class="history__commentsBox ac">
                                                <div class="history__commentsSpoller">
                                                    <svg class="history__commentsChat">
                                                        <use xlink:href="{{ asset('img/sprites/sprite-mono.svg#chat') }}"></use>
                                                    </svg>2 комментария к заказу
                                                    <div class="history__commentsPlug ac-trigger">
                                                        <svg class="history__commentsSel">
                                                            <use xlink:href="{{ asset('img/sprites/sprite-mono.svg#sel3') }}"></use>
                                                        </svg>
                                                    </div>
                                                </div>
                                                <div class="history__commentsPanel ac-panel">
                                                    <div class="history__comment">
                                                        <div class="history__commentHead">
                                                            <div class="history__commentName">Менеджер Анна</div>
                                                            <div class="history__commentTime">10 дней назад</div>
                                                        </div>
                                                        <div class="history__commentBody">К сожалению, нам пришлось отменить заказ, поскольку истек срок оплаты заказа банку. Вы можете повторить заказ</div>
                                                        <div class="history__commentAnswer link" role="button" tabindex="0">Ответить</div>
                                                    </div>
                                                    <div class="history__comment">
                                                        <div class="history__commentHead">
                                                            <div class="history__commentName">Я</div>
                                                            <div class="history__commentTime">9 дней назад</div>
                                                        </div>
                                                        <div class="history__commentBody">Спасибо! Буду разбираться</div>
                                                    </div>
                                                    <form class="history__form" action="#" method="post">
                                                        <textarea class="history__textarea" name="message" data-value="Начните вводить сообщение" value=""></textarea>
                                                        <div class="history__commentControls">
                                                            <div class="history__smileBox" id="emoji-trigger">
                                                                <svg>
                                                                    <use xlink:href="{{ asset('img/sprites/sprite-mono.svg#smile') }}"></use>
                                                                </svg>
                                                            </div>
                                                            <button class="history__submit" type="button">Отправить</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="history__panelSide">
                                        <ul class="history__panelSideList">
                                            <li class="history__panelSideItem">Общая стоимость:<span>330 000 ₽</span></li>
                                            <li class="history__panelSideItem">Стоимость товаров:<span>326 000 ₽</span></li>
                                            <li class="history__panelSideItem">Общая стоимость:<span>1 200 ₽</span></li>
                                            <li class="history__panelSideItem">Общая стоимость:<span>1 200 ₽</span></li>
                                        </ul>
                                        <div class="history__pay btn" role="button" tabindex="0">Оплатить online</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
