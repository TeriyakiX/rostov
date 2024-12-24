@include('partials.modal')

<footer class="footer">
    <div class="footer__bg" style=background-image:url("{{ asset('img/footer.jpg') }}")></div>
    <div class="footer__container _container">
        <div class="footer__top">
            <div class="formBox footer__formBox">
                <h3 class="formBox__formTitle">Получите бесплатную консультацию нашего инженера</h3>
                <form id="consultationForm" class="formBox__form" action="{{route('index.send_mail')}}" method="post"
                      enctype="multipart/form-data" data-ajax="true">

                    {{ csrf_field() }}
                    <input type="hidden" value="{{url()->current()}}" id="link" name="link">
                    <input type="hidden" name="source" value="Футер">
                    <input type="hidden" name="typeOfRequest" value="Консультация подвал">
                    <input class="formBox__input" autocomplete="off" type="text" name="name" value=""
                           placeholder="Ваше имя">
                    <input class="formBox__input" autocomplete="off" type="text" name="phone_number" value=""
                           placeholder="Номер телефона">
                    <label class="formBox__fileLabel" name="file" for="footer_file">
                        <input class="formBox__input" autocomplete="off" type="file" name="file" id="footer_file">
                        <svg>
                            <use xlink:href="{{ asset('img/sprites/sprite-mono.svg#scr') }}"></use>
                        </svg>
                        Прикрепить файл
                    </label>
                    <br>
                    <label class="message" for="file" style="color: red">

                    </label>
                    <div class="formRow">
                        <div class="inpBox">
                            <label for="consent" class="ctaForm__label">
                                <input type="checkbox" id="consent_1" name="consent" required data-consent>
                                Я даю своё согласие на
                                <a href="/posts/politika-konfidencialnosti" target="_blank">обработку и распространение персональных данных</a>.
                            </label>
                        </div>
                    </div>
                    <button class="formBox__submit disabled" id="submit_1" type="submit" disabled data-submit>Получить консультацию</button>
                </form>
            </div>
            <nav class="footer__menu accordion-container">

                @foreach($footerPostCategories as $footerPostCategory)
                    <div class="footer__spollerBox ac">
                        @switch($footerPostCategory->title)
                            @case('Специалистам')
                                <a class="footer__spoller"
                                   href="{{route('index.documents.documents',['id'=>'all'])}}">
                                    {{ $footerPostCategory->title }}
                                    <div class="footer__spollerTrigger ac-trigger on"></div>
                                </a>
                                @break
                            @case('Сервис')
                            <a class="footer__spoller"
                               href="/posts/category/servis">
                                {{ $footerPostCategory->title }}
                                <div class="footer__spollerTrigger ac-trigger on"></div>
                            </a>
                                @break
                                @default()
                                <a class="footer__spoller"
                                   href=" {{ route('index.posts.show', ['slug' =>$footerPostCategory->slug])}}">
                                    {{ $footerPostCategory->title }}
                                    <div class="footer__spollerTrigger ac-trigger on"></div>
                                </a>
                                @break

                        @endswitch

                        <div class="footer__spollerPanel ac-panel">
                            <ul class="footer__menuList">
                                <li class="footer__menuItem">
                                    @switch($footerPostCategory->title)
                                        @case('Специалистам')
                                            <a class="footer__menuLink"
                                               href="{{route('index.documents.documents',['id'=>'all'])}}">
                                                {{ $footerPostCategory->title }}
                                            </a>
                                            @break
                                        @case('Полезное')
                                            <a class="footer__menuLink"
                                               href="{{ route('index.posts.show', ['slug' =>'poleznoe'])}}">
                                                {{ $footerPostCategory->title }}
                                            </a>
                                            @break
                                        @case('Сервис')
                                            <a class="footer__menuLink"
                                               href="/posts/category/servis">
                                                {{ $footerPostCategory->title}}
                                            </a>
                                            @break
                                        @default
                                            <a class="footer__menuLink" href="#">
                                                {{ $footerPostCategory->title }}
                                            </a>
                                            @break
                                    @endswitch

                                </li>
                                @php
                                    // Маппинг slug на URL и текст элементов
                                    $slugMappings = [
                                        'instrukcii-po-montazhu' => ['url' => 'http://mkrostov.ru/documents/%D0%98%D0%BD%D1%81%D1%82%D1%80%D1%83%D0%BA%D1%86%D0%B8%D0%B8%20%D0%BF%D0%BE%20%D0%BC%D0%BE%D0%BD%D1%82%D0%B0%D0%B6%D1%83', 'text' => 'Инструкции по монтажу'],
                                        'sotrudnichestvo' => ['url' => 'http://mkrostov.ru/posts/sotrudnichestvo', 'text' => 'Сотрудничество'],
                                        'normy-i-gosty' => ['url' => 'http://mkrostov.ru/documents/%D0%9D%D0%BE%D1%80%D0%BC%D1%8B%20%D0%B8%20%D0%93%D0%9E%D0%A1%D0%A2%D1%8B', 'text' => 'Нормы и ГОСТы'],
                                        'tehnicheskie-katalogi' => ['url' => 'http://mkrostov.ru/documents/%D0%A2%D0%B5%D1%85%D0%BD%D0%B8%D1%87%D0%B5%D1%81%D0%BA%D0%B8%D0%B5%20%D0%BA%D0%B0%D1%82%D0%B0%D0%BB%D0%BE%D0%B3%D0%B8', 'text' => 'Технические каталоги'],
                                    ];
                                @endphp

                                @foreach($footerPostCategory->posts as $footerPostCategoryPost)
                                    @if(array_key_exists($footerPostCategoryPost->slug, $slugMappings))
                                        {{-- Заменяем элемент согласно маппингу --}}
                                        <li class="footer__menuItem">
                                            <a class="footer__menuLink" href="{{ $slugMappings[$footerPostCategoryPost->slug]['url'] }}">
                                                {{ $slugMappings[$footerPostCategoryPost->slug]['text'] }}
                                            </a>
                                        </li>
                                    @else

                                        {{-- Элементы, которые не нужно заменять --}}
                                        <li class="footer__menuItem">
                                            <a class="footer__menuLink"
                                               href="{{ route('index.posts.show', ['slug' => $footerPostCategoryPost->slug]) }}">
                                                {{ $footerPostCategoryPost->title }}
                                            </a>

                                        </li>
                                    @endif
                                @endforeach

                            </ul>
                        </div>
                    </div>
                @endforeach

{{--                <div class="footer__spollerBox ac"><a class="footer__spoller" href="#">Товары--}}
{{--                        <div class="footer__spollerTrigger ac-trigger on"></div>--}}
{{--                    </a>--}}
{{--                    <div class="footer__spollerPanel ac-panel">--}}
{{--                        <ul class="footer__menuList">--}}
{{--                            @foreach(\App\Models\ProductCategory::whereNull('parent_id')->get() as $productCategory)--}}
{{--                                <li class="footer__menuItem">--}}
{{--                                    <a class="footer__menuLink"--}}
{{--                                       href="{{ route('index.products.category', ['category' => $productCategory->slug]) }}">--}}
{{--                                        {{ $productCategory->title }}--}}
{{--                                    </a>--}}
{{--                                </li>--}}
{{--                            @endforeach--}}
{{--                        </ul>--}}
{{--                    </div>--}}
{{--                </div>--}}

                <div class="footer__spollerBox ac"><a class="footer__spoller" href="/posts/katalog">Каталог
                        <div class="footer__spollerTrigger ac-trigger off"></div>
                    </a>
                    <div class="footer__spollerPanel ac-panel">
                        <ul class="footer__menuList">
                            <li class="footer__menuItem"><a class="footer__menuLink"
                                                            href="/posts/katalog">Каталог</a>
                            </li>
                        </ul>
                    </div>
                </div>


                <div class="footer__spollerBox ac"><a class="footer__spoller" href="{{ route('index.gallery.index') }}">Фотогалерея
                        <div class="footer__spollerTrigger ac-trigger off"></div>
                    </a>
                    <div class="footer__spollerPanel ac-panel">
                        <ul class="footer__menuList">
                            <li class="footer__menuItem"><a class="footer__menuLink"
                                                            href="{{ route('index.gallery.index') }}">Фотогалерея</a>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="footer__spollerBox ac"><a class="footer__spoller"
                                                      href="{{ route('index.posts.show', ['slug' => 'kontakty']) }}">Контакты
                        <div class="footer__spollerTrigger ac-trigger off"></div>
                    </a>
                    <div class="footer__spollerPanel ac-panel">
                        <ul class="footer__menuList">
                            <li class="footer__menuItem"><a class="footer__menuLink"
                                                            href="{{ route('index.posts.show', ['slug' => 'kontakty']) }}">Контакты</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
        </div>

        <div class="footer__bottom">
            <ul class="footer__copyBox">
                <li class="footer__copyBoxItem">&copy; МК-Ростов, 2015—{{ date('Y') }} </li>
                <li class="footer__copyBoxItem">
                    <a href="{{ route('index.posts.show', ['slug' => 'politika-konfidencialnosti']) }}">
                        Политика конфиденциальности
                    </a>
                </li>
            </ul>
            <div class="footer__contactsBox">
                <ul class="footer__contactsBoxList">
                    <li class="footer__contactsBoxItem">г. Ростов-на-Дону, ул. Доватора, 144/13</li>

                    @if($officeHours->isNotEmpty())
                        @foreach($officeHours as $officeHour)
                            <li class="footer__contactsBoxItem">
                                {{ $officeHour->days }}: {{ $officeHour->hours }}
                            </li>
                        @endforeach
                    @else
                        <li class="footer__contactsBoxItem">Режим работы не задан</li>
                    @endif
                </ul>

                <ul class="footer__contactsBoxList">
                    <li class="footer__contactsBoxItem"><a href="tel:+78633114660">+7 (863) 311-46-60</a></li>
                    <li class="footer__contactsBoxItem"><a href="tel:+78632193523">+7 (863) 219-35-23</a></li>
                </ul>
                <ul class="footer__contactsBoxList">
                    <li class="footer__contactsBoxItem"><a href="mailto:m1_mk@aaanet.ru"
                                                           class="serif">m1_mk@aaanet.ru</a></li>
                    <li class="footer__contactsBoxItem"><a href="mailto:mk-rostov@mail.ru" class="serif">mk-rostov@mail.ru</a>
                    </li>
                </ul>
            </div>
        </div>

    </div>
</footer>

<style>
    .formBox__form {
        display: flex;
        flex-direction: column;
    }
    .footer__formBox .ctaForm__label {
        color: rgba(224, 224, 224, 1);
        font-weight: 400;
        font-size: 1.4rem;
    }
    .footer__formBox .ctaForm__label a {
        color: #9af3ef;
        text-decoration: underline;
    }
    .footer__spollerPanel {
        height: auto !important;
    }
</style>
