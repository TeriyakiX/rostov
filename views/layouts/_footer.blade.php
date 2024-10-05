<footer class="footer">
    <div class="footer__bg" style=background-image:url("{{ asset('img/footer.jpg') }}")></div>
    <div class="footer__container _container">
        <div class="footer__top">
            <div class="formBox footer__formBox">
                <h3 class="formBox__formTitle">Получите бесплатную консультацию нашего инженера</h3>
                <form class="formBox__form getConsult" method="post" enctype="multipart/form-data">

                    {{ csrf_field() }}
                    <input type="hidden" name="source" value="Футер">

                    <input class="formBox__input" autocomplete="off" type="text" name="name" value="" placeholder="Ваше имя">
                    <input class="formBox__input" autocomplete="off" type="text" name="phone_number" value="" placeholder="Номер телефона">
                    <input class="formBox__input" autocomplete="off" type="file" name="file" id="file">
                    <label class="formBox__fileLabel" for="file" name="file">
                        <svg>
                            <use xlink:href="{{ asset('img/sprites/sprite-mono.svg#scr') }}"></use>
                        </svg>Прикрепить файл
                    </label>
                    <br>
                    <label class="message" for="file" style="color: red">

                    </label>
                    <button class="formBox__submit" type="submit">Получить консультацию</button>
                </form>
                <div class="formBox__policy">
                    Нажав кнопку «Название кнопки», я даю согласие на
                    <a href="{{ route('index.posts.show', ['slug' => 'obrabotka-personalnyh-dannyh']) }}">обработку моих персональных данных</a>
                </div>
            </div>
            <nav class="footer__menu accordion-container">

                @foreach($footerPostCategories as $footerPostCategory)
                    <div class="footer__spollerBox ac">
                        <a class="footer__spoller" href="#">
                            {{ $footerPostCategory->title }}
                            <div class="footer__spollerTrigger ac-trigger on"></div>
                        </a>
                        <div class="footer__spollerPanel ac-panel">
                            <ul class="footer__menuList">
                                <li class="footer__menuItem">
                                    <a class="footer__menuLink" href="#">
                                        {{ $footerPostCategory->title }}
                                    </a>
                                </li>
                                @foreach($footerPostCategory->posts as $footerPostCategoryPost)
                                    <li class="footer__menuItem">
                                        <a class="footer__menuLink" href="{{ route('index.posts.show', ['slug' => $footerPostCategoryPost->slug]) }}">
                                            {{ $footerPostCategoryPost->title }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endforeach

                <div class="footer__spollerBox ac"><a class="footer__spoller" href="#">Товары
                        <div class="footer__spollerTrigger ac-trigger on"></div></a>
                    <div class="footer__spollerPanel ac-panel">
                        <ul class="footer__menuList">
                            @foreach(\App\Models\ProductCategory::whereNull('parent_id')->get() as $productCategory)
                            <li class="footer__menuItem">
                                <a class="footer__menuLink"
                                    href="{{ route('index.products.category', ['category' => $productCategory->slug]) }}">
                                    {{ $productCategory->title }}
                                </a>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>

                <div class="footer__spollerBox ac"><a class="footer__spoller" href="{{ route('index.gallery.index') }}">Фотогалерея
                        <div class="footer__spollerTrigger ac-trigger off"></div></a>
                    <div class="footer__spollerPanel ac-panel">
                        <ul class="footer__menuList">
                            <li class="footer__menuItem"><a class="footer__menuLink" href="{{ route('index.gallery.index') }}">Фотогалерея</a></li>
                        </ul>
                    </div>
                </div>

                <div class="footer__spollerBox ac"><a class="footer__spoller" href="{{ route('index.posts.show', ['slug' => 'kontakty']) }}">Контакты
                        <div class="footer__spollerTrigger ac-trigger off"></div></a>
                    <div class="footer__spollerPanel ac-panel">
                        <ul class="footer__menuList">
                            <li class="footer__menuItem"><a class="footer__menuLink" href="{{ route('index.posts.show', ['slug' => 'kontakty']) }}">Контакты</a></li>
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
                    <li class="footer__contactsBoxItem">пн-пт 8:30-17:30</li>
                </ul>
                <ul class="footer__contactsBoxList">
                    <li class="footer__contactsBoxItem"> <a href="tel:+78633114660">+7 (863) 311-46-60</a></li>
                    <li class="footer__contactsBoxItem"><a href="tel:+78632193523">+7 (863) 219-35-23</a></li>
                </ul>
                <ul class="footer__contactsBoxList">
                    <li class="footer__contactsBoxItem"> <a href="mailto:m1_mk@aaanet.ru" class="serif">m1_mk@aaanet.ru</a></li>
                    <li class="footer__contactsBoxItem"><a href="mailto:mk-rostov@mail.ru" class="serif">mk-rostov@mail.ru</a></li>
                </ul>
            </div>
        </div>
    </div>
</footer>
