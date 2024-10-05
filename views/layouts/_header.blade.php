<header class="header _lp">
    <div class="header__container _container">
        <div class="header__content">
            <div class="header__col header__col--left">
                <div class="authorization header__authorization" data-da=".menu__body, 768, first">
                    <div class="authorization__icon">
                        <svg>
                            <use xlink:href="{{ asset('img/sprites/sprite-mono.svg#user') }}"></use>
                        </svg>
                    </div>
                    <ul class="authorization__list">
                        @if(auth()->guest())
                            <li class="authorization__item">
                                <a class="authorization__link" href="{{ route('auth.loginForm') }}">Вход</a>
                            </li>
                            <li class="authorization__item">
                                <a class="authorization__link" href="{{ route('auth.registerForm') }}">Регистрация</a>
                            </li>
                        @elseif(auth()->user()->hasRole('admin'))
                            <li class="authorization__item">
                                <a class="authorization__link" href="{{ route('admin.dashboard.index') }}">Админ
                                    панель</a>
                            </li>
                            <li class="authorization__item">
                                <a class="authorization__link" href="{{ route('auth.logout') }}">Выход</a>
                            </li>
                        @elseif(auth()->user()->hasRole('client'))
                            <li class="authorization__item">
                                <a class="authorization__link" href="{{ route('client.dashboard.index') }}">Кабинет</a>
                            </li>
                            <li class="authorization__item">
                                <a class="authorization__link" href="{{ route('auth.logout') }}">Выход</a>
                            </li>
                        @endif
                    </ul>
                </div>
                <nav class="header__nav header__nav--left">
                    <ul class="header__list">
                        @foreach($headerPostCategories as $headerPostCategory)
                            @if($headerPostCategory->title != 'Полезное' && $headerPostCategory->title != 'Специалистам' && $headerPostCategory->title != 'Технические каталоги' && $headerPostCategory->title != 'Нормы и ГОСТы' && $headerPostCategory->title != 'Инструкции по монтажу')
                                <li class="header__item header__item--drop">
                                    <a href="{{ route('index.posts.category', ['slug' => $headerPostCategory->slug]) }}">
                                        {{ $headerPostCategory->title }}

                                    </a>
                                    <svg>
                                        <use xlink:href="{{ asset('img/sprites/sprite-mono.svg#sel') }}"></use>
                                    </svg>
                                    <ul class="header__dropList">
                                        <li class="header__dropItem">
                                            <svg>
                                                <use xlink:href="{{ asset('img/sprites/sprite-mono.svg#sel') }}"></use>
                                            </svg>
                                            <a href="{{ route('index.posts.category', ['slug' => $headerPostCategory->slug]) }}"
                                               style="color: white">
                                                {{ $headerPostCategory->title }}
                                            </a>
                                        </li>
                                        {{--                                    @elseif($headerPostCategory->title != 'Полезное')--}}
                                        @else
                                            <li class="header__item header__item--drop">
                                                <a href="#">
                                                    {{ $headerPostCategory->title }}

                                                </a>
                                                <svg>
                                                    <use
                                                        xlink:href="{{ asset('img/sprites/sprite-mono.svg#sel') }}"></use>
                                                </svg>
                                                <ul class="header__dropList">
                                                    <li class="header__dropItem">
                                                        <svg>
                                                            <use
                                                                xlink:href="{{ asset('img/sprites/sprite-mono.svg#sel') }}"></use>
                                                        </svg>
                                                        <a href="#" style="color: white">
                                                            {{ $headerPostCategory->title }}
                                                        </a>
                                                    </li>
                                                    @endif
                                                    @foreach($headerPostCategory->posts as $headerPostCategoryPost)
                                                        @if($headerPostCategoryPost->title != 'Технические каталоги' && $headerPostCategoryPost->title != 'Нормы и ГОСТы' && $headerPostCategoryPost->title != 'Инструкции по монтажу')
                                                            <li class="header__dropItem">
                                                                <a href="{{ route('index.posts.show', ['slug' => $headerPostCategoryPost->slug]) }}">
                                                                    {{ $headerPostCategoryPost->title }}
                                                                </a>
                                                            </li>
                                                        @else
                                                            <li class="header__dropItem">
                                                                <a href="{{route('index.documents.documents', $headerPostCategoryPost->title)}}">
                                                                    {{ $headerPostCategoryPost->title }}
                                                                </a>
                                                            </li>
                                                        @endif
                                                    @endforeach
                                                </ul>
                                            </li>
                                            @endforeach
                                    </ul>
                </nav>
                <div class="catalogControl header__catalogControl">
                    <div class="catalogControl__btn" role="button" tabindex="0">
                        <svg>
                            <use xlink:href="{{ asset('img/sprites/sprite-mono.svg#catalog') }}"></use>
                        </svg>
                        <a href="/posts/katalog">Каталог</a>

                    </div>
                    <ul class="catalogControl__list">
                        @foreach($headerCategories as $index=>$headerCategory)
                            <li class="catalogControl__item
                                @if(count($headerCategory->subcategories) > 0) catalogControl__item--drop @endif
                            @if($index == 0) fc @endif ">
                                <a class="catalogControl__link"
                                   href="{{ route('index.products.categoryList', ['category' => $headerCategory->slug]) }}">
                                    {{ $headerCategory->title }}
                                </a>
                                @if(count($headerCategory->subcategories) > 0)
                                    <ul class="catalogControl__listDrop">
                                        @foreach($headerCategory->subcategories as $headerSubcategory)
                                            <li class="catalogControl__itemDrop">
                                                <a class="catalogControl__link"
                                                   href="{{ route('index.products.category', ['category' => $headerSubcategory->slug]) }}">
                                                    {{ $headerSubcategory->title }}
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                    <form class="catalogControl__searchform" style="margin-block-end: 0;"
                          action="{{ route('index.products.search') }}">
                        <input class="catalogControl__searchInput" autocomplete="off" type="text" name="query"
                               data-value="{{ request()->get('query') ?: 'Поиск по товарам' }}"
                               value="{{ request()->get('query') }}">
                        <button class="catalogControl__searchBtn" type="submit">
                            <svg>
                                <use xlink:href="{{ asset('img/sprites/sprite-mono.svg#search') }}"></use>
                            </svg>
                        </button>
                    </form>
                </div>
            </div>
            <div class="header__col header__col--center">
                <div class="header__logoBox">
                    <a class="header__logoLink" href="{{ route('index.home') }}">
                        <picture>
                            <source type="image/webp" srcset="{{ asset('/img/logo.webp') }}">
                            <img src="{{ asset('/img/logo.png') }}" alt="logo" width="166" height="194">
                        </picture>
                    </a>
                </div>
            </div>
            <div class="header__col header__col--right">
                <div class="social header__social">
                    <a class="social__link" href="https://wa.me/+79885109783">
                        <svg>
                            <use xlink:href="{{ asset('img/sprites/sprite-mono.svg#wapp') }}"></use>
                        </svg>
                    </a>
                    <a class="social__link open_help_popup" href="#">
                        <svg>
                            <use xlink:href="{{ asset('img/sprites/sprite-mono.svg#faq') }}"></use>
                        </svg>
                    </a>
                    <a class="social__link" href="mailto:m1_mk@aaanet.ru">
                        <svg>
                            <use xlink:href="{{ asset('img/sprites/sprite-mono.svg#mail') }}"></use>
                        </svg>
                    </a>
                </div>
                <nav class="header__nav header__nav--right">
                    <ul class="header__list">
                        <li class="header__item">
                            <a class="header__navLink" href="{{ route('index.gallery.index') }}">Фотогалерея</a>
                        </li>
                        <li class="header__item">
                            <a class="header__navLink" href="{{ route('index.posts.show', ['slug' => 'kontakty']) }}">Контакты</a>
                        </li>
                        <li class="header__item">
                            <a class="header__navLink header__navLink--tel"
                               href="tel:+78633114660" data-da=".header__col--left, 992, last">
                                <b>+7 (863) 311-46-60</b>
                            </a>
                        </li>
                    </ul>
                </nav>
                <div class="header__controllers"><a class="calc header__calc"
                                                    href="{{ route('index.posts.show', ['slug' => 'kalkulyatory']) }}">
                        Калькуляторы
                        <div class="calc__icon">
                            <svg>
                                <use xlink:href="{{ asset('/img/sprites/sprite-multi.svg#calc') }}"></use>
                            </svg>
                        </div>
                    </a>
                    <div class="infoPanel header__infoPanel">
                        <a class="infoPanel__btn {{ request()->routeIs('index.products.viewed') ? 'active' : '' }} "
                           href="{{ route('index.products.viewed') }}">
                            <svg class="infoPanel__svg infoPanel__svg--oko">
                                <use xlink:href="{{ asset('/img/sprites/sprite-mono.svg#oko') }}"></use>
                            </svg>
                        </a>
                        <a class="infoPanel__btn {{ request()->routeIs('index.products.favorites') ? 'active' : '' }} "
                           href="{{ route('index.products.favorites') }}">
                            <svg class="infoPanel__svg infoPanel__svg--heart">
                                <use xlink:href="{{ asset('/img/sprites/sprite-mono.svg#heart') }}"></use>
                            </svg>
                        </a>
                        <a class="infoPanel__btn {{ request()->routeIs('index.products.compare') ? 'active' : '' }} "
                           href="{{ route('index.products.compare') }}">
                            <svg class="infoPanel__svg infoPanel__svg--stat">
                                <use xlink:href="{{ asset('/img/sprites/sprite-mono.svg#stat') }}"></use>
                            </svg>
                        </a>
                        <a class="infoPanel__btn {{ request()->routeIs('index.cart.index') ? 'active' : '' }} "
                           href="{{ route('index.cart.index') }}" data-da=".header__col--right, 992, last">
                            <svg class="infoPanel__svg infoPanel__svg--basket">
                                <use xlink:href="{{ asset('/img/sprites/sprite-mono.svg#basket') }}"></use>
                            </svg>
                        </a>
                    </div>
                </div>
                <div class="header__iconMenu iconMenu" role="button" tabindex="0"><span></span></div>
            </div>
        </div>
        <div class="menu header__menu">
            <div class="menu__wrapper">
                <div class="menu__body">
                    <div class="menu__contentWrp _container">
                        <div class="menu__close" role="button">
                            <svg>
                                <use xlink:href="{{ asset('/img/sprites/sprite-mono.svg#cancel') }}"></use>
                            </svg>
                        </div>
                        <nav class="menu__nav">
                            <ul class="menu__list">
                                @foreach($headerCategories as $index=>$headerCategory)
                                    @if($index <= 3)
                                        <li class="menu__item">
                                            <a class="menu__link"
                                               href="{{ route('index.products.categoryList', ['category' => $headerCategory->slug]) }}">
                                                {{ $headerCategory->title }}
                                            </a>
                                        </li>
                                    @endif
                                @endforeach
                            </ul>
                        </nav>
                        <div class="menu__logoBox"><a class="menu__logoLink" href="{{ url('/') }}">
                                <picture>
                                    <source type="image/webp" srcset="{{ asset('/img/logo.webp') }}">
                                    <img src="{{ asset('img/logo.png') }}" alt="logo" width="102" height="119">
                                </picture>
                            </a></div>
                        <nav class="menu__nav">
                            <ul class="menu__list">
                                {{--                                <li class="menu__item"><a class="menu__link" href="#">Полезное</a></li>--}}
                                <li class="menu__item"><a class="menu__link" href="{{ route('index.cart.index') }}">Корзина</a>
                                </li>
                                <li class="menu__item"><a class="menu__link"
                                                          href="/posts/category/servis">Оплата
                                        и доставка</a></li>
                                <li class="menu__item"><a class="menu__link"
                                                          href="{{ route('index.posts.show', ['slug' => 'kontakty']) }}">Контакты</a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
@include('products._modal_help')
