<header class="header _lp">

    @php

if(!function_exists('getChildCategories')) {
function getChildCategories($parent_id,$parentCategories){
    $child_category_list = array();
    foreach ($parentCategories as $child_category){
        if($parent_id==$child_category->parent_id){
    $child_category_list[]  = $child_category;

        }


    }
     return $child_category_list;
    }
}

    /*print_r(getChildCategories(36,$parentCategories));*/
    /*print_r($parentCategories);*/
    @endphp
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
                        @elseif(auth()->user()->hasRole('manager'))
                            <li class="authorization__item">
                                <a class="authorization__link" href="{{ route('admin.dashboard.index') }}">Панель
                                    менеджера</a>
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
                                                @if($headerPostCategory->title==='Специалистам')
                                                    <a href="{{route('index.documents.documents',['id'=>1])}}"
                                                       style="display: block">
                                                        {{ $headerPostCategory->title }}
                                                    </a>
                                                @else
                                                    <a href="#">
                                                        {{ $headerPostCategory->title }}
                                                    </a>
                                                @endif
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
                                                        @if($headerPostCategory->title==='Специалистам')
                                                            <a href="{{route('index.documents.documents',['id'=>'all'])}}"
                                                               style="color: white">
                                                                {{ $headerPostCategory->title }}
                                                            </a>
                                                        @elseif ($headerPostCategory->title==='Полезное')
                                                            <a href="{{route('index.posts.show',['slug'=>$headerPostCategory->slug])}}"
                                                               style="color: white">
                                                                {{ $headerPostCategory->title}}
                                                            </a>
                                                        @else
                                                            <a href="#" style="color: white">
                                                                {{ $headerPostCategory->title }}
                                                            </a>
                                                        @endif
                                                    </li>
                                                    @endif
                                                    @foreach($headerPostCategory->posts as $headerPostCategoryPost)

                                                        @if($headerPostCategoryPost->title != 'Технические каталоги' && $headerPostCategoryPost->title != 'Нормы и ГОСТы' && $headerPostCategoryPost->title != 'Инструкции по монтажу')
                                                            <li class="header__dropItem">
                                                                <a href="{{ route('index.posts.show', ['slug' => $headerPostCategoryPost->slug]) }}">
                                                                    @if($headerPostCategoryPost->slug != 'oplata')
                                                                        {{ $headerPostCategoryPost->title }}
                                                                    @else
                                                                        Оплатить
                                                                    @endif
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
                                </li>
                    </ul>
                </nav>
<!--<pre>
@php
print_r($headerCategories);
@endphp
</pre>-->
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
                                            <li class="catalogControl__itemDrop catalogControl__item" data-id="{{ $headerSubcategory->id  }}">
                                                <a class="catalogControl__link catalogControl__link"
                                                   href="{{ route('index.products.categoryList', ['category' => $headerSubcategory->slug]) }}">
                                                    {{ $headerSubcategory->title }}
                                                </a>

                                                <ul class="catalogControl__listDrop 2">
                                                    @foreach(getChildCategories($headerSubcategory->id,$parentCategories) as $Subcategory)
                                                        <li class="catalogControl__itemDrop " data-id="{{ $Subcategory->id  }}">
                                                            <a class="catalogControl__link"
                                                               href="{{ route('index.products.category', ['category' => $Subcategory->slug]) }}">
                                                                {{ $Subcategory->title }}
                                                            </a>

                                                        </li>

                                                    @endforeach

                                                </ul>
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
                               placeholder="{{ request()->get('query') ?: 'Поиск по товарам' }}"
                               value="{{ request()->get('query') }}">
                        <button class="catalogControl__searchBtn" type="submit">
                            <svg>
                                <use xlink:href="{{ asset('img/sprites/sprite-mono.svg#search') }}"></use>
                            </svg>
                        </button>
                    </form>
                </div>
                <div class="social header__social" id="socialLink3">
                    <a class="social__link header__navLink" href="https://wa.me/+79885109783">
                        <svg class="social__link-whatsapp">
                            <use xlink:href="{{ asset('img/sprites/whatsapp.svg#whatsapp') }}"></use>
                        </svg>
                    </a>
                    <a class="social__link header__navLink header__navLink--tg" href="https://t.me/+79885109783">
                        <svg class="social__link-telegram">
                            <use xlink:href="{{ asset('img/sprites/telegram.svg#telegram') }}"></use>
                        </svg>
                    </a>
                    <a class="social__link header__navLink header__navLink--phone" href="tel:+78633114660">
                        <svg class="social__link-phone">
                            <use xlink:href="{{ asset('img/sprites/phone.svg#phone') }}"></use>
                        </svg>
                    </a>
                </div>
            </div>
            <div class="header__col header__col--center">
                <div class="header__logoBox">
                    <a class="header__logoLink" href="{{ route('index.home') }}">
                        <picture>
                            <source type="image/webp" srcset="{{ asset('/img/logo.webp') }}">
                            <img src="{{ asset('/img/logo.svg') }}" alt="logo" width="166" height="194">
                        </picture>
                    </a>
                </div>
            </div>
            <div class="header__col header__col--right">
                <div class="social social-right header__social" id="socialLink1">
                    <a class="social__link header__navLink" href="https://wa.me/+79885109783">
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
                <div class="social header__social" id="socialLink4">
{{--                    <a class="social__link header__navLink " href="tel:+78633114660" style="background: #016BDE">--}}
{{--                        <img src="{{asset('img/sprites/phone.svg')}}" alt="phone">--}}
{{--                    </a>--}}

                    <a class="social__link header__navLink--heart header__navLink {{ request()->routeIs('index.products.favorites') ? 'active' : '' }}"
                       href="{{ route('index.products.favorites') }}">
                        <svg class="infoPanel__svg infoPanel__svg--heart" style="fill: transparent;">
                            <use xlink:href="{{ asset('/img/sprites/sprite-mono.svg#heart') }}"></use>
                        </svg>
                    </a>
                    <a class="social__link header__navLink {{ request()->routeIs('index.cart.index') ? 'active' : '' }}"
                       href="{{ route('index.cart.index') }}">
                        <svg class="infoPanel__svg infoPanel__svg--basket">
                            <use xlink:href="{{ asset('/img/sprites/sprite-mono.svg#basket') }}"></use>
                        </svg>
                    </a>

                    <div class="header__iconMenu iconMenu" role="button" tabindex="0">
                        <span></span>
                    </div>
                </div>
                {{--                <div class="social header__social" id="socialLink4" style="display: none">--}}
                {{--                    <a class="header__navLink header__navLink--tel"--}}
                {{--                       href="tel:+78633114660">--}}
                {{--                        <b>+7 (863) 311-46-60</b>--}}
                {{--                    </a>--}}
                {{--                    <div class="header__iconMenu iconMenu" role="button" tabindex="0">--}}
                {{--                        <span></span>--}}
                {{--                    </div>--}}
                {{--                </div>--}}
                <nav class="header__nav header__nav--right" id="socialLink2">
                    <ul class="header__list">
                        <li class="header__item">
                            <a class="header__navLink" href="{{ route('index.gallery.index') }}">Фотогалерея</a>
                        </li>

                        <li class="header__item">
                            <a class="header__navLink" href="{{ route('index.posts.show', ['slug' => 'kontakty']) }}">Контакты</a>
                        </li>
                        <li class="header__item">
                            <a class="header__navLink header__navLink--tel"
                               href="tel:+78633114660">
                                <b>+7 (863) 311-46-60</b>
                            </a>
                        </li>
                    </ul>
                </nav>

                <div class="header__controllers">
                    <a class="calc header__calc"
                       href="{{ route('index.posts.show', ['slug' => 'kalkulyatory']) }}">
                        Калькуляторы
                        <div class="calc__icon">
                            <svg>
                                <use xlink:href="{{ asset('/img/sprites/sprite-multi.svg#calc') }}"></use>
                            </svg>
                        </div>
                    </a>
                    @php
                        $cart = app()->make('cart');
                        $productService=new \App\Services\ProductService();
                       $favoriteCount=  count($productService->getSession('favorites'));
                       $compareCount=count($productService->getSession('compare'));
                       $cartCount=$cart->getTotalQuantity();
                    @endphp
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
                            <div class="countOfCart {{$favoriteCount>0 ?'' :'inactive'}}">{{$favoriteCount}}</div>
                        </a>
                        <a class="infoPanel__btn {{ request()->routeIs('index.products.compare') ? 'active' : '' }} "
                           href="{{ route('index.products.compare') }}">
                            <svg class="infoPanel__svg infoPanel__svg--stat">
                                <use xlink:href="{{ asset('/img/sprites/sprite-mono.svg#stat') }}"></use>
                            </svg>
                            <div class="countOfCart {{$compareCount>0 ?'' :'inactive'}}">{{$compareCount}}</div>
                        </a>
                        <a class="infoPanel__btn {{ request()->routeIs('index.cart.index') ? 'active' : '' }} "
                           href="{{ route('index.cart.index') }}" data-da=".header__col--right, 992, last">
                            <svg class="infoPanel__svg infoPanel__svg--basket">

                                <use xlink:href="{{ asset('/img/sprites/sprite-mono.svg#basket') }}"></use>
                            </svg>
                            <div class="countOfCart {{$cartCount>0 ?'' :' inactive'}} ">{{$cartCount}}</div>
                        </a>

                    </div>
                </div>

            </div>
        </div>
        <div class="catalogControl__wrapper">
            <form class="catalogControl__searchform-mobile" style="margin-block-end: 0;"
                  action="{{ route('index.products.search') }}">
                <input class="catalogControl__searchInput-mobile" autocomplete="off" type="text" name="query"
                       placeholder="{{ request()->get('query') ?: 'Поиск по товарам' }}"
                       value="{{ request()->get('query') }}">
                <button class="catalogControl__searchBtn-mobile" type="submit">
                    <svg>
                        <use xlink:href="{{ asset('img/sprites/sprite-mono.svg#search') }}"></use>
                    </svg>
                </button>
            </form>
        </div>

        <div class="menu header__menu">
            <div class="menu__wrapper menu__wrapper--desktop">
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
                                    <img src="{{ asset('/img/logo.svg') }}" alt="logo" width="102" height="119">
                                </picture>
                            </a></div>
                        <nav class="menu__nav">
                            <ul class="menu__list">
                                <li class="menu__item"><a class="menu__link"
                                                          href="{{route('index.posts.show',['slug'=>'poleznoe'])}}">Полезное</a>
                                </li>
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

            <div class="menu__wrapper menu__wrapper--mobile">
                <div class="menu__body">
                    <div class="menu__logoBoxMobile">
                        <a class="menu__logoLinkMobile" href="{{ url('/') }}">
                            <picture>
                                <source type="image/webp" srcset="{{ asset('/img/logo.webp') }}">
                                <img src="{{ asset('/img/logo.svg') }}" alt="logo" width="102" height="119">
                            </picture>
                        </a>
                        <div class="close-button">
                            <svg class="close-icon">
                                <use xlink:href="{{ asset('/img/sprites/sprite-mono.svg#cancel') }}"></use>
                            </svg>
                        </div>
                    </div>
                    <div class="menu__contentWrp _container">
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
                        <nav class="menu__nav">
                            <ul class="menu__list">
                                <li class="menu__item">
                                    <a class="menu__link" href="{{route('index.posts.show',['slug'=>'poleznoe'])}}">Каталог</a>
                                </li>

                                <li class="menu__item">
                                    <a class="menu__link" href="{{route('index.posts.show',['slug'=>'poleznoe'])}}">Сервис</a>
                                </li>

                                <li class="menu__item">
                                    <a class="menu__link" href="/documents/all">Специалистам</a>
                                </li>

                                <li class="menu__item">
                                    <a class="menu__link" href="{{ route('index.gallery.index') }}">Фотогалерея</a>
                                </li>

                                <li class="menu__item">
                                    <a class="menu__link" href="{{route('index.posts.show',['slug'=>'poleznoe'])}}">Полезное</a>
                                </li>

                                <li class="menu__item"><a class="menu__link" href="{{ route('index.cart.index') }}">Корзина</a>
                                </li>

                                <li class="menu__item">
                                    <a class="menu__link" href="/posts/category/servis">Оплата и доставка</a>
                                </li>

                                <li class="menu__item">
                                    <a class="menu__link" href="{{ route('index.posts.show', ['slug' => 'kontakty']) }}">Контакты</a>
                                </li>
                            </ul>
                        </nav>

                        <div class="menu__calc-mobile">
                            <a class="calc-mobile"
                               href="{{ route('index.posts.show', ['slug' => 'kalkulyatory']) }}">
                                Калькуляторы
                                <div class="calc__icon">
                                    <svg>
                                        <use xlink:href="{{ asset('/img/sprites/sprite-multi.svg#calc') }}"></use>
                                    </svg>
                                </div>
                            </a>
                        </div>

                        <div class="authorization__item_mobile">
                            <a class="authorization__link" href="{{ route('auth.registerForm') }}">Вход / Регистрация </a>
                        </div>

                        <div class="infoPanel header__infoPanels">
                            <a class="infoPanel__btn {{ request()->routeIs('index.products.viewed') ? 'active' : '' }} infoPanel__btn--mobile"
                               href="{{ route('index.products.viewed') }}">
                                <svg class="infoPanel__svg infoPanel__svg--oko">
                                    <use xlink:href="{{ asset('/img/sprites/sprite-mono.svg#oko') }}"></use>
                                </svg>
                            </a>

                            <a class="infoPanel__btn {{ request()->routeIs('index.products.favorites') ? 'active' : '' }} infoPanel__btn--mobile"
                               href="{{ route('index.products.favorites') }}">
                                <svg class="infoPanel__svg infoPanel__svg--heart">
                                    <use xlink:href="{{ asset('/img/sprites/sprite-mono.svg#heart') }}"></use>
                                </svg>
                                <div class="countOfCart {{$favoriteCount>0 ?'' :'inactive'}}">{{$favoriteCount}}</div>
                            </a>
                            <a class="infoPanel__btn {{ request()->routeIs('index.products.compare') ? 'active' : '' }} infoPanel__btn--mobile"
                               href="{{ route('index.products.compare') }}">
                                <svg class="infoPanel__svg infoPanel__svg--stat">
                                    <use xlink:href="{{ asset('/img/sprites/sprite-mono.svg#stat') }}"></use>
                                </svg>
                                <div class="countOfCart {{$compareCount>0 ?'' :'inactive'}}">{{$compareCount}}</div>
                            </a>
                            <a class="infoPanel__btn {{ request()->routeIs('index.cart.index') ? 'active' : '' }} infoPanel__btn--mobile"
                               href="{{ route('index.cart.index') }}">
                                <svg class="infoPanel__svg infoPanel__svg--basket">

                                    <use xlink:href="{{ asset('/img/sprites/sprite-mono.svg#basket') }}"></use>
                                </svg>
                                <div class="countOfCart {{$cartCount>0 ?'' :' inactive'}} ">{{$cartCount}}</div>
                            </a>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
<style>
    .inactive {
        display: none;
    }
    .menu__close{
        top: -20px!important;
    }

    .countOfCart {
        margin-top: -10px;
        padding-top: 2px;
        text-align: center;
        border-radius: 50%;
        background: #006bde;
        color: #fff;
        width: 20px;
        min-width: 20px;
        height: 20px;
        white-space: nowrap;
    }
</style>
<script>
    console.log(window.innerWidth)
    if (window.innerWidth < 800) {
        $("#socialLink1").hide()
        $("#socialLink2").hide()
        $("#socialLink3").show()
        $('#socialLink4').show()
        // console.log($("#linkHighScreen").style.display='none') ;
        // console.log(links)
        // body.delete() = "mobile";
    }
    document.querySelector('.close-button').addEventListener('click', function() {
        const menu = document.querySelector('.menu.header__menu');
        if (menu) {
            menu.classList.remove('menu--active'); // Убираем класс для закрытия меню
        }
    });
</script>
@include('products._modal_help')
