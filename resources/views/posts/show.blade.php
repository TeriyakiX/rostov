@extends('layouts.index')

@section('seo_title', $post->seo_title)
@section('seo_description', $post->seo_description)
@section('seo_keywords', $post->seo_keywords)

@section('content')

    <main class="page">
        <nav class="breadcrumbs">

            @if($post->slug === 'dokumenty')

                <div class="breadcrumbs__container _container">
                    <ul class="breadcrumbs__list" style="overflow: hidden;">
                        <li class="breadcrumbs__item"><a class="breadcrumbs__link"
                                                         href="{{ url('/') }}"><span>Главная</span>
                                <svg>
                                    <use xlink:href="/img/sprites/sprite-mono.svg#slideArrow"></use>
                                </svg>
                            </a></li>
                        <li class="breadcrumbs__item"><a class="breadcrumbs__link breadcrumbs__link--active"
                                                         href="#"><span>{{ $post->title }}</span>
                                <svg>
                                    <use xlink:href="/img/sprites/sprite-mono.svg#slideArrow"></use>
                                </svg></a></li>
                    </ul>
                 <div class="docs__title-wrp">
                     <h2 class="docs__title t">{{$post->title}}</h2>

                     <a class="btn show__getDocs" style="margin-top: 20px">
                         Запросить документацию
                     </a>
                 </div>
                </div>
                <script>
                    $(document).on("click", ".show__getDocs", function () {
                        console.log('im here');
                        $('.popup_documentation').addClass('_active')
                    });
                </script>
                @include('client.dashboard._documentations_model')

            @else
                <div class="breadcrumbs__container _container">
                    <ul class="breadcrumbs__list">
                        <li class="breadcrumbs__item"><a class="breadcrumbs__link"
                                                         href="{{ url('/') }}"><span>Главная</span>
                                <svg>
                                    <use xlink:href="/img/sprites/sprite-mono.svg#slideArrow"></use>
                                </svg>
                            </a></li>
                        <li class="breadcrumbs__item"><a class="breadcrumbs__link breadcrumbs__link--active"
                                                         href="#"><span>{{ $post->title }}</span>       <svg>
                                    <use xlink:href="/img/sprites/sprite-mono.svg#slideArrow"></use>
                                </svg></a></li>
                    </ul>
                </div>
            @endif
        </nav>
        <!-- Cooperation section-->
        <section class="cooperation">
            <div class="cooperation__container _container">
                <div class="cooperation__content">
                    @if($post->slug != 'dokumenty')
                        <h2 class="cooperation__title t">{{ $post->title }}</h2>
                    @endif

                    <div class="cooperation__body sideDashContainer">
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

                        @if($post->slug == 'sotrudnichestvo')
                            @include('posts.custom._sotrudnichestvo')
                        @elseif($post->slug == 'usluga-dostavka')

                            @include('posts.custom._usluga-dostavka')
                        @elseif($post->slug == 'brendy')
                            @include('brand.index')
                        @elseif($post->slug == 'novinki')
                            @include('products._is_novelty')
                        @elseif($post->slug == 'akcii')
                            @include('products._akcii')
                        @elseif($post->slug == 'vidy-pokrytiya')
                            @include('coatings.index')
                        @elseif($post->slug == 'poleznoe')
                            @include('posts.custom._poleznoe')
                        @elseif($post->slug == 'usluga-montazh')
                            @include('posts.custom._usluga-montazh')
                        @elseif($post->slug == 'zakazat-raschet')
                            @include('posts.custom._zakazat-raschet')
                        @elseif($post->slug == 'pohvalit-pozhalovatsya')
                            @include('posts.custom._pohvalit-pozhalovatsya')
                        @elseif($post->slug == 'kontakty')
                            @include('posts.custom.kontakty')
                        @elseif($post->slug == 'dokumenty')

                            @include('posts.custom._tehnicheskie-katalogi')
                        @elseif($post->slug == 'gotovye-resheniya')
                            @include('turnkey_solutions.all_solutions')
						@elseif($post->slug == 'video')
                            @include('video.all_video')
                        @elseif($post->slug == 'katalog')
                            @include('home.sections._products')
                        @elseif($post->slug == 'oplata')
                            @include('posts.custom._oplata')
                        @elseif($post->slug == 'stati')
                            @include('posts.custom._stati')
                        @elseif($post->slug == 'proizvodstvo')
                            @include('posts.custom._production')
                        @elseif($post->slug==='spravochnik-stroitelya')
                            @include('posts.custom._spravochnik')
                        @else

                            <div class="post-content__body-container" style="padding: 0;">
                                {!! $post->body !!}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
<style>
    .docs__title-wrp {
        display: flex;
        justify-content: space-between;
        margin-top: 30px;
    }
    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    /* Firefox */
    input[type=number] {
        -moz-appearance: textfield;
    }

    ul.b {
        list-style-type: disc;
    }

    .form_delevery {
        margin-top: 15px;
    }

    .textareaBox {
        padding: 20px 10px;
    }

    .container__div_one {
        display: flex;
        flex-flow: row wrap;
        justify-content: space-between;
    }

    .container__div_one > div {
        max-width: 30%;
    }

    .pay_icons_div {
        display: flex;
        margin-top: 20px;
        margin-bottom: 30px;
        gap: 15px;
    }

    .pay_icon {
        width: 80px;
        height: 22px;
    }

    .pay_card {
        width: 100%;
        background-color: #f6f6f6;
        border: 15px;
        border-top-style: solid;
        border-top-color: #006BDE;
    }

    .pay_card_body {
        padding: 30px;
    }
    .input_pay {
        border-radius: 5px;
        border: none;
        background: #ECECEC;
        height: 35px;
        width: 100%;
        padding: 0 20px;
    }

    .pay_card_title {
        font-weight: 700;
        font-size: 24px;
        color: #006bde;
        margin-bottom: 1%;
    }

    .pay_title {
        font-size: 16px;
        font-weight: bold;
        margin-bottom: 15px
    }

    @media screen and (max-width: 767.98px) {
        .pay_icons_div {
            padding: 0 16px;
        }
        .pay_card_title {
            font-size: 18px;
            margin-bottom: 10px;
        }
        .pay_card_body {
            padding-left: 16px;
            padding-right: 16px;
            padding-bottom: 20px;
        }
        .docs__title {
            display: none !important;
        }
        .docs__title-wrp {
            flex-direction: column;
        }
        .show__getDocs {
            margin-top: 0 !important;
        }
        .doc_type-wrp {
            justify-content: space-between;
            text-align: center;
        }
        .doc_type {
            width: 33% !important;
        }
        .first__type__color, .second__type__color, .threid__type__color {
            width: 33% !important;
        }
        .fifth__type__color, .fourth__type__color{
            display: none !important;
        }
        .catalogControl__searchform {
            width: 100% !important;
            padding: 0 16px;
        }
        .prodCard__docsItemWrp {
            flex: 1 0 45% !important;
        }
        .prodCard__docsItem {
            margin: 0 !important;
            flex: 1 0 50% !important;
        }
        .catalogControl__searchBtn {
            right: 16px !important;
        }
        .prodCard__docsName {
            text-align: center;
        }
        .catalogControl__searchInput {
            padding: 10px !important;
        }
    }
    @media screen and (max-width: 600px) {
        .container__div_one {
            flex-direction: column
        }

        .container__div_one > div {
            max-width: 100%;
        }

        .second {
            order: 3;
        }

        .third {
            order: 2
        }

        .find_error_btn {
            margin-top: 5px;
        }
    }
</style>
