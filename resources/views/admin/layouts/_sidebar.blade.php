<div id="sidebar" class="active">
    <div class="sidebar-wrapper active">
        <div class="sidebar-header">
            <div class="d-flex justify-content-between">
                <div class="logo">
                    <a href="{{ route('admin.dashboard.index') }}">
                        <img src="{{ asset('img/logo.png') }}" alt="Logo" srcset="">
                    </a>
                </div>
                <div class="toggler">
                    <a href="#" class="sidebar-hide d-xl-none d-block"><i class="bi bi-x bi-middle"></i></a>
                </div>
            </div>
        </div>
        <div class="sidebar-menu">
            <ul class="menu">
                <li class="sidebar-title">Меню</li>

                @foreach($entities as $entity => $entityData)
                    <li class="sidebar-item {{ request()->is('admin/' . $entity . '*') ? 'active' : null }}">
                        <a href="{{ route('admin.entity.index', ['entity' => $entity]) }}" class='sidebar-link'>
                            <i class="bi bi-collection-fill"></i>
                            <span>{{ $entityData['title'] }}</span>
                        </a>
                    </li>
                @endforeach



                {{--                <li class="sidebar-item">--}}
                {{--                    <a href="{{ route('admin.dashboard.index') }}" class='sidebar-link'>--}}
                {{--                        <i class="bi bi-collection-fill"></i>--}}
                {{--                        <span>Заказы</span>--}}
                {{--                    </a>--}}
                {{--                </li>--}}

                {{--                <li class="sidebar-item"> <!--.has-sub-->--}}
                {{--                    <a href="#" class='sidebar-link'>--}}
                {{--                        <i class="bi bi-collection-fill"></i>--}}
                {{--                        <span>Категории</span>--}}
                {{--                    </a>--}}
                {{--                    <ul class="submenu ">--}}
                {{--                        <li class="submenu-item ">--}}
                {{--                            <a href="extra-component-avatar.html">Просмотреть категории</a>--}}
                {{--                        </li>--}}
                {{--                        <li class="submenu-item ">--}}
                {{--                            <a href="extra-component-sweetalert.html">Добавить категорию</a>--}}
                {{--                        </li>--}}
                {{--                    </ul>--}}
                {{--                </li>--}}
                @if(Auth::user()->hasRole('admin'))
                    <li class="sidebar-item">
                        <a href="{{ route('admin.dashboard.excel') }}" class='sidebar-link'>
                            <i class="bi bi-grid-fill"></i>
                            <span>Импорт excel</span>
                        </a>
                    </li>
                @endif

                <li class="sidebar-item">
                    <a href="{{ route('index.home') }}" class='sidebar-link'>
                        <i class="bi bi-grid-fill"></i>
                        <span>Сайт</span>
                    </a>
                </li>

                <li class="sidebar-item">
                    <a href="{{ route('auth.logout') }}" class='sidebar-link'>
                        <i class="bi bi-door-open-fill"></i>
                        <span>Выйти</span>
                    </a>
                </li>

            </ul>
        </div>
        <button class="sidebar-toggler btn x"><i data-feather="x"></i></button>
    </div>
</div>
