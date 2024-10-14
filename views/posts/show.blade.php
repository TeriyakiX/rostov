@extends('layouts.index')

@section('seo_title', $post->seo_title)
@section('seo_description', $post->seo_description)
@section('seo_keywords', $post->seo_keywords)
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
                    <li class="breadcrumbs__item"><a class="breadcrumbs__link breadcrumbs__link--active"
                                                     href="#"><span>{{ $post->title }}</span></a></li>
                </ul>
            </div>
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
                                <div class="sideDash__mark"><a href="/posts/usluga-montazh">Услуга монтаж</a></div>
                            </div>
                            <div class="sideDash__item sideDash__item--gap">
                                <svg class="sideDash__icon">
                                    <use xlink:href="{{ url('/img/sprites/4.png') }}#building">
                                        <img src="{{asset('img/sprites/4.png')}}" alt="">
                                    </use>
                                </svg>
                                <div class="sideDash__mark"><a href="/posts/usluga-dostavka">Услуга доставка</a></div>
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
                            @dd($brands)
                            @include('brand.index')
                        @elseif($post->slug == 'novinki')
                            @include('products._is_novelty')
                        @elseif($post->slug == 'akcii')
                            @include('products._akcii')
                        @elseif($post->slug == 'vidy-pokrytiya')
                            @include('coatings.index')
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
                        @elseif($post->slug == 'katalog')
                            @include('home.sections._products')
                        @elseif($post->slug == 'oplata')
                            @include('posts.custom._oplata')
                        @elseif($post->slug == 'stati')
                            @include('posts.custom._stati')
                        @else

                            {!! $post->body !!}
                        @endif
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
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

    .pay_icons_div{
        display: flex;
        margin: 15px 0;
    }

    .pay_icon{
        width: 60px;
        height: 22px;
    }

    .pay_card{
        width: 100%;
        height: 400px;
        background-color: #f6f6f6;
        border: 15px;
        border-top-style: solid;
        border-top-color: blue;
    }

    .pay_card_body{
       padding: 3%;
    }

    .pay_card_title{
        font-weight: 700;
        font-size: 30px;
        color: #006bde;
        margin-bottom: 1%;
    }

    .pay_title{
        font-size: 20px;
        margin-bottom: 15px
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
