@extends('layouts.index')

@section('content')

    <main class="page">
        <nav class="breadcrumbs">
            <div class="breadcrumbs__container _container">
                <ul class="breadcrumbs__list">
                    <li class="breadcrumbs__item"><a class="breadcrumbs__link"
                                                     href="{{ url('/') }}"><span>Главная</span>
                            <svg>
                                <use xlink:href="/img/sprites/sprite-mono.svg#slideArrow"></use>
                            </svg>
                        </a></li>
                    <li class="breadcrumbs__item"><a class="breadcrumbs__link"
                                                     href="{{ url('/posts/stati') }}"><span>Статьи</span>
                            <svg>
                                <use xlink:href="/img/sprites/sprite-mono.svg#slideArrow"></use>
                            </svg>
                        </a></li>
                    <li class="breadcrumbs__item"><a class="breadcrumbs__link breadcrumbs__link--active"
                                                     href="#"><span>{{$post->title}}</span> <svg>
                                <use xlink:href="{{ asset('img/icons/blue-play.svg#blue-play') }}"></use>
                            </svg></a></li>
                </ul>
            </div>
        </nav>
{{--        <section class="cooperation _container">--}}
{{--            <div class="cooperation__container">--}}
{{--                <div class="cooperation__content">--}}
{{--                    <h2 class="cooperation__title t">{{$post->title}}</h2>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--            <div class="postContainer">--}}
{{--                <picture class="postImage">--}}
{{--                    <source type="image/webp"--}}
{{--                            srcset="{{ $post->mainPhotoPath() }}">--}}
{{--                    <img src="{{ $post->mainPhotoPath() }}" alt="p1">--}}
{{--                </picture>--}}
{{--                <div class="postContent">--}}
{{--                    {!! $post->body !!}--}}
{{--                </div>--}}

{{--            </div>--}}
{{--        </section>--}}


        <section class="cooperation">
            <div class="cooperation__container _container">
                <div class="cooperation__content">
                    <h2 class="cooperation__title t">{{$post->title}}</h2>

                    <div class="sideDash sideDash--sticky" style="z-index: 9999">
                        <div class="sideDash__item sideDash__item--gap">
                            <svg class="sideDash__icon">
                                <use xlink:href="{{ url('/img/sprites/3.png') }}#building">
                                    <img src="{{asset('img/sprites/3.png')}}" alt="">
                                </use>
                            </svg>
                            <div class="sideDash__mark"><a
                                    href="{{route('index.posts.show',['slug'=>'vidy-pokrytiya'])}}">Виды
                                    покрытий</a></div>
                        </div>
                        <div class="sideDash__item sideDash__item--gap">
                            <svg class="sideDash__icon">
                                <use xlink:href="{{ url('/img/sprites/4.png') }}#building">
                                    <img src="{{asset('img/sprites/4.png')}}" alt="">
                                </use>
                            </svg>
                            <div class="sideDash__mark"><a
                                    href="{{route('index.posts.show',['slug'=>'gotovye-resheniya']) }}">Готовые
                                    решения</a></div>
                        </div>
                        <div class="sideDash__item sideDash__item--gap">
                            <svg class="sideDash__icon">
                                <use xlink:href="{{ url('/img/sprites/2.png') }}#building">
                                    <img src="{{asset('img/sprites/2.png')}}" alt="">
                                </use>
                            </svg>
                            <div class="sideDash__mark"><a href="/posts/oplata">on-line оплата</a></div>
                        </div>
                        <div class="sideDash__item sideDash__item--gap">
                            <svg class="sideDash__icon">
                                <use xlink:href="{{ url('/img/sprites/1.png') }}#building">
                                    <img src="{{asset('img/sprites/1.png')}}" alt="">
                                </use>
                            </svg>
                            <div class="sideDash__mark"><a href="/posts/zakazat-raschet">Заказать расчет</a></div>
                        </div>
                    </div>

                    <h3 class="cooperation__subTitle">Описание</h3>
                    <div class="video__first-block">
                        <div class="video__desc--left">
                            <p class="video__text">Металлочерепица – это составная часть кровельной
                                системы. Как долго и надежно будет служить крыша, зависит
                                не только от качества ее составляющих, но и откачества их
                                монтажа.
                            </p>
                            <p class="video__text">
                                Grand Line® производит металлочерепицу под заказ,
                                размером, оптимально подходящим для конкретной крыши.
                                Расчет и планирование укладки листов производится в
                                офисе продаж с помощью специальной программы или
                                самостоятельно, на нашем сайте, используя сервис online
                                расчета.
                            </p>
                        </div>

                        <div class="video__desc--line"></div>

                        <div class="video__desc--right">
                            <p class="video__text">
                                Металлочерепица пользуется всё большим спросом. Этот материал
                                соответствует практически всем запросам потребителей:
                            </p>

                            <div class="video__desc--advantages">
                                <div class="video__desc--advantages__item">
                                    <picture>
                                        <source type="image/webp"
                                                srcset="{{ asset('/img/icons/star.svg') }}">
                                        <img src="{{ asset('/img/icons/star.svg') }}" alt="star">
                                    </picture>

                                    <p class="video__text">Эстетична;</p>
                                </div>
                                <div class="video__desc--advantages__item">
                                    <picture>
                                        <source type="image/webp"
                                                srcset="{{ asset('/img/icons/star.svg') }}">
                                        <img src="{{ asset('/img/icons/star.svg') }}" alt="star">
                                    </picture>

                                    <p class="video__text">Долговечна;</p>
                                </div>
                                <div class="video__desc--advantages__item">
                                    <picture>
                                        <source type="image/webp"
                                                srcset="{{ asset('/img/icons/star.svg') }}">
                                        <img src="{{ asset('/img/icons/star.svg') }}" alt="star">
                                    </picture>

                                    <p class="video__text">С её помощью можно облицевать кровлю в любом стиле;</p>
                                </div>
                                <div class="video__desc--advantages__item">
                                    <picture>
                                        <source type="image/webp"
                                                srcset="{{ asset('/img/icons/star.svg') }}">
                                        <img src="{{ asset('/img/icons/star.svg') }}" alt="star">
                                    </picture>

                                    <p class="video__text">Многообразие профилей и оттенков позволяет реализовать любые дизайнерские решения.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <h3 class="cooperation__subTitle">Укладка листов</h3>

                    <div class="video__second-block">
                        <div class="video__info--left">
                            <div class="video__info--video">
                                <div class="process__videoWrp">

                                    <picture>
                                        <source type="image/webp"
                                                srcset="{{ $post->mainPhotoPath() }}">
                                        <img src="{{ $post->mainPhotoPath() }}">
                                    </picture>
                                </div>
                            </div>

                            <div class="video__info--warning video__info--warning--desktop">
                                <p class="video__text">
                                    <span style="color: #006BDE; font-weight: 700">Внимание! </span>
                                    Категорически запрещено использование
                                    углошлифовальной машины с абразивным кругом, «болгарки».
                                    Это одно из главных условий действия гарантии на внешний вид
                                    и технические характеристики металлочерепицы.
                                </p>
                            </div>
                        </div>
                        <div class="video__info--right">
                            <div class="video__info--text">
                                <p class="video__text">
                                    На продольном стыке листы имеют нахлест 60-80мм и одну или две
                                    капиллярных канавки на накрываемом листе. Канавки служат для отвода
                                    влаги, которая может попасть под стык листов вследствие эффекта
                                    капиллярного подъема.
                                </p>
                                <p class="video__text">
                                    На крупноразмерных кровлях укладка листов может производиться
                                    в несколько рядов. Поперечная стыковка листов производится через
                                    так называемое замковое соединение листов. Нижний лист обычно
                                    длиннее верхнего и обрезается от гребня ступени на расстоянии
                                    50-100мм. Такие листы обычно называют стандартными. Первый
                                    стандартный (одномодульный) лист – 500мм. Если к этому размеру
                                    прибавить шаг металлочерепицы 350мм – получится второй
                                    (двухмодульный) лист – 850мм, следующий – 1200мм и т.д.
                                </p>
                                <p class="video__text">
                                    При плотной стыковке верхнего листа со стандартным нижним
                                    и образуется замок. Такое соединение практически не заметно на кровле
                                    и не влияет на герметичность кровельного покрытия. Замковое
                                    соединение листов должно проходить единой линией вдоль всего ската.
                                    При аккуратном монтаже металлочерепицы поперечные и продольные
                                    стыки не выделяются на общей плоскости кровли и не уменьшают
                                    ее надежность.
                                </p>
                                <p class="video__text">
                                    Мы не рекомендуем работать с листами длиннее 4м. Длинные листы
                                    сложнее перевозить, разгружать и поднимать на кровлю. Чем длиннее
                                    лист, тем выше вероятность его деформации.
                                </p>
                            </div>

                            <div class="video__info--warning video__info--warning--mobile">
                                <p class="video__text">
                                    <span style="color: #006BDE; font-weight: 700">Внимание! </span>
                                    Категорически запрещено использование
                                    углошлифовальной машины с абразивным кругом, «болгарки».
                                    Это одно из главных условий действия гарантии на внешний вид
                                    и технические характеристики металлочерепицы.
                                </p>
                            </div>
                        </div>
                    </div>

                    <h3 class="cooperation__subTitle">Характеристики</h3>

                    <div class="video__third-block">
                        <div class="video__spec--card">
                            <picture>
                                <source type="image/webp"
                                        srcset="{{ asset('/img/card/video__image_1.png') }}">
                                <img src="{{ asset('/img/card/video__image_1.png') }}" alt="spec">
                            </picture>

                            <div class="video__spec--text">
                                <p class="video__text">Металлочерепица изготавливается из рулонной стали.</p>
                                <p class="video__text">Толщиной 0,5 мм</p>
                                <p class="video__text">Шириной 1250мм</p>
                                <p class="video__text">Сталь защищена от коррозии металлическим защитным покрытием и имеет полимерное декоративно-защитное лакокрасочное покрытие.</p>
                            </div>
                        </div>
                        <div class="video__spec--card">
                            <picture>
                                <source type="image/webp"
                                        srcset="{{ asset('/img/card/video__image_2.png') }}">
                                <img src="{{ asset('/img/card/video__image_2.png') }}" alt="spec">
                            </picture>

                            <div class="video__spec--text">
                                <p class="video__text">Лист металлочерепицы визуально состоит из волн и ступеней, которые имитируют поверхность черепичной крыши.</p>
                                <p class="video__text">Волны образуются при прохождении листа через профилирующие валы, после чего выштамповываются ступени. Ступени также имеют волнистую форму и повторяются через 350мм, визуально деля лист на ряды. Расстояние между рядами принято называть шагом металлочерепицы.</p>
                            </div>
                        </div>
                        <div class="video__spec--card">
                            <picture>
                                <source type="image/webp"
                                        srcset="{{ asset('/img/card/video__image_3.png') }}">
                                <img src="{{ asset('/img/card/video__image_3.png') }}" alt="spec">
                            </picture>

                            <div class="video__spec--text">
                                <p class="video__text">Нижний рез листа всегда производится в одном месте – около 50мм от гребня волны. Образующийся носик часто называют капельником металлочерепицы.</p>
                            </div>
                        </div>
                    </div>

                    <div class="video__fourth-block">
                        <h3 class="cooperation__subTitle">Скатная крыша с использованием металлочерепицы в качестве кровельного покрытия, включает в себя следующие компоненты:</h3>

                        <div class="video__comp--list">
                            <div class="video__comp--left">
                                <div class="video__comp--item"><svg><use xlink:href="{{ asset('img/icons/Ellipse__li.svg#circle') }}"></use></svg><p class="video__text">Стропильная система;</p></div>
                                <div class="video__comp--item"><svg><use xlink:href="{{ asset('img/icons/Ellipse__li.svg#circle') }}"></use></svg><p class="video__text">Подкровельная гидроизоляция;</p></div>
                                <div class="video__comp--item"><svg><use xlink:href="{{ asset('img/icons/Ellipse__li.svg#circle') }}"></use></svg><p class="video__text">Металлочерепица;</p></div>
                                <div class="video__comp--item"><svg><use xlink:href="{{ asset('img/icons/Ellipse__li.svg#circle') }}"></use></svg><p class="video__text">Доборные элементы, комплектующие;</p></div>
                                <div class="video__comp--item"><svg><use xlink:href="{{ asset('img/icons/Ellipse__li.svg#circle') }}"></use></svg><p class="video__text">Водосточная система;</p></div>
                                <div class="video__comp--item"><svg><use xlink:href="{{ asset('img/icons/Ellipse__li.svg#circle') }}"></use></svg><p class="video__text">Элементы подкровельной вентиляции;</p></div>
                            </div>
                            <div class="video__comp--right">
                                <div class="video__comp--item"><svg><use xlink:href="{{ asset('img/icons/Ellipse__li.svg#circle') }}"></use></svg><p class="video__text">Утепление и пароизоляция;</p></div>
                                <div class="video__comp--item"><svg><use xlink:href="{{ asset('img/icons/Ellipse__li.svg#circle') }}"></use></svg><p class="video__text">Мансардные окна;</p></div>
                                <div class="video__comp--item"><svg><use xlink:href="{{ asset('img/icons/Ellipse__li.svg#circle') }}"></use></svg><p class="video__text">Проходные элементы для выходов вентиляции и других систем;</p></div>
                                <div class="video__comp--item"><svg><use xlink:href="{{ asset('img/icons/Ellipse__li.svg#circle') }}"></use></svg><p class="video__text">Элементы безопасности кровли;</p></div>
                                <div class="video__comp--item"><svg><use xlink:href="{{ asset('img/icons/Ellipse__li.svg#circle') }}"></use></svg><p class="video__text">Отделка свесов кровли.</p></div>
                            </div>
                        </div>

                        <p class="video__text">Металлочерепица комплектуется стандартными планками, которые изготавливаются в пленке, из того же сырья, что и металлочерепица. Стандартные длины планок – 2 и 3м , у полукруглых коньков – 1,97 м. При необходимости заказ может комплектоваться нестандартными доборными элементами по эскизам заказчика и плоскими листами из того же материала, что и металлочерепица.</p>
                    </div>

                    <h3 class="cooperation__subTitle">Вентиляция и гидроизоляция</h3>

                    <div class="video__fifth-block">
                        <p class="video__text video__rec--title">
                            При монтаже кровельной системы особое внимание следует уделить организации подкровельной вентиляции и устройству гидроизоляции.
                        </p>

                        <div class="video__rec">
                            <div class="video__rec--card">
                                <picture>
                                    <source type="image/webp"
                                            srcset="{{ asset('/img/card/video__image_4.png') }}">
                                    <img src="{{ asset('/img/card/video__image_4.png') }}" alt="rec">
                                </picture>

                                <div class="video__rec--text">
                                    <p class="video__text">
                                        Для обеспечения подкровельной вентиляции на карнизе необходимо организовать вход в подкровельное пространство, на коньке/хребте - выход. Если кровля холодная потребуется организация входа и выхода для пространства чердака.
                                    </p>
                                </div>
                            </div>

                            <div class="video__rec--card">
                                <picture>
                                    <source type="image/webp"
                                            srcset="{{ asset('/img/card/video__image_5.png') }}">
                                    <img src="{{ asset('/img/card/video__image_5.png') }}" alt="rec">
                                </picture>

                                <div class="video__rec--text">
                                    <p class="video__text">
                                        Рекомендуем закрывать вентзазор на карнизе вентиляционной лентой, для защиты от проникновения птиц.
                                    </p>
                                </div>
                            </div>

                            <div class="video__rec--card">
                                <picture>
                                    <source type="image/webp"
                                            srcset="{{ asset('/img/card/video__image_6.png') }}">
                                    <img src="{{ asset('/img/card/video__image_6.png') }}" alt="rec">
                                </picture>

                                <div class="video__rec--text">
                                    <p class="video__text">
                                        На коньке – закрываем аэроэлементом конька, от задувания снега.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="video__rec--message">
                        <p class="video__text">Для утепленных крыш Grand Line рекомендует использовать современные супердиффузионные мембраны. В этом случае не нужен второй вентиляционный зазор, и следовательно схема монтажа упрощается, а надежность и долговечность кровельной системы повышается.</p>
                        <a href="{{ url('/posts/katalog') }}">
                            <input type="submit" class="btn" value="Перейти в каталог"/>
                        </a>
                    </div>
                </div>
            </div>
        </section>
    </main>
    <style>
        .postContent {
            line-height: 150%;
        }
        .postImage{
            max-width: 60%;
            float: left;
            padding-right: 10px;
            padding-bottom: 10px;
            text-align: justify;
        }
        .process__videoWrp {
            width: 100% !important;
        }
        .process__videoWrp img, .process__videoWrp picture {
            height: 100%;
            width: 100%;
        }
    </style>
@endsection
