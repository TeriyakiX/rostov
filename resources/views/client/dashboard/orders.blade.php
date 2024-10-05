@extends('layouts.index')

@section('content')
    <main class="page">
        <nav class="breadcrumbs">
            <div class="breadcrumbs__container _container">
                <ul class="breadcrumbs__list">
                    <li class="breadcrumbs__item"><a class="breadcrumbs__link" href="#"><span>Главная</span>
                            <svg>
                                <use xlink:href="{{ asset('img/sprites/sprite-mono.svg#slideArrow') }}"></use>
                            </svg>
                        </a></li>
                    <li class="breadcrumbs__item"><a class="breadcrumbs__link breadcrumbs__link--active" href="#"><span>История заказов</span></a>
                    </li>
                </ul>
            </div>
        </nav>

        <section class="history">
            <div class="history__container _container">
                <div class="history__content">

                    <div class="history__head">
                        <h2 class="history__title t">История заказов</h2>
                        <div class=" btn history__getDocs" role="button" tabindex="0">Запросить документацию</div>
                    </div>

                    @if(count($orders) > 0)
                        <div class="history__body accordHistory">
                            <div class="history__titlesBox">
                                <div class="history__row">
                                    <div class="history__col">Номер заказа</div>
                                    <div class="history__col">Дата заказа</div>
                                    <div class="history__col">Сумма</div>
                                    <div class="history__col">Статус</div>
                                </div>
                            </div>

                            @foreach($orders as $order)

                                <div class="history__spollerBox ac">
                                    <div class="history__spoller">
                                        <div class="history__row">
                                            <div class="history__col">№ {{ $order->id }}</div>
                                            <div
                                                class="history__col">{{ $order->created_at->format('Y-m-d H:i:s') }}</div>
                                            <div class="history__col">{{ $order->total_price }} р</div>
                                            <div class="history__col">
                                                <div class="history__statusBox">
                                                    <div class="history__status">
                                                        @if (\App\Models\OrderStatus::where('id', $order->status)->get()[0]['title'] != null){{\App\Models\OrderStatus::where('id', $order->status)->get()[0]['title']}}@endif</div>
                                                </div>
                                                <div class="history__icons">
                                                    <div class="history__icon" style="align-items: inherit;">

                                                        <svg>
                                                            <use xlink:href="/img/sprites/sprite-mono.svg#chat"></use>
                                                        </svg>
                                                        @if($order->manager_comment != null)
                                                            {{\App\Models\Comment::where('order_id', $order->id)->get()->count()+1 ?? 1}}
                                                        @else
                                                            0
                                                        @endif
                                                    </div>
                                                    @if (count($order->files) > 0)
                                                        <div class="history__icon" style="align-items: inherit;">
                                                            <a style="display: inline-flex;"
                                                               href="{{ asset('upload_files/' . $order->files[0]->filepath) }}">
                                                                <svg style="margin-right: 0px;">
                                                                    <use
                                                                        xlink:href="/img/sprites/sprite-mono.svg#file"></use>
                                                                </svg>
                                                                &nbsp;Счёт
                                                            </a>

                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="history__spollerTrigger ac-trigger on">
                                            <svg>
                                                <use xlink:href="/img/sprites/sprite-mono.svg#sel3"></use>
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="history__spollerPanel ac-panel">
                                        <div class="history__panelGrid">
                                            <div class="history__panelBody">

                                                @foreach($order->products as $product)
                                                    <div class="history__panelCardWrp">
                                                        <div class="history__panelCard">
                                                            <div class="history__imgBox">
                                                                <a class="history__imgWrp ibg"
                                                                   href="{{ $product->showLink() }}">
                                                                    <picture>
                                                                        <source type="image/webp"
                                                                                srcset="{{ $product->mainPhotoPath() }}">
                                                                        <img src="{{ $product->mainPhotoPath() }}"
                                                                             alt="h">
                                                                    </picture>
                                                                </a>
                                                            </div>
                                                            <div class="history__panelCardInfo">
                                                                <div class="history__panelCardCol">
                                                                    <a class="link" href="{{ $product->showLink() }}">
                                                                        {{ $product->title }}
                                                                    </a>
                                                                </div>
                                                                @foreach(json_decode($product->pivot->options) as $optionCode => $optionValue)
                                                                    @if($optionCode == 'select' || $optionCode == 'totalSquare'|| !$optionValue)
                                                                        @continue
                                                                    @endif
                                                                    <div
                                                                        class="history__panelCardCol">
                                                                        {{ option_key($optionCode) . ':' . (is_object($optionValue) ? json_encode($optionValue) : $optionValue) }}</div>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach

                                                <div class="history__commentsContainer">
                                                    <div class="history__commentsBox ac">
                                                        <div class="history__commentsSpoller">
                                                            <svg class="history__commentsChat">
                                                                <use
                                                                    xlink:href="./img/sprites/sprite-mono.svg#chat"></use>
                                                            </svg>
                                                            <div class="comment_count_{{$order->id}}">
                                                                @if($order->manager_comment == null)
                                                                    0 комментария к заказу
                                                                @else
                                                                    <span>{{\App\Models\Comment::where('order_id', $order->id)->get()->count() + 1}}</span>
                                                                    комментария к заказу
                                                                @endif
                                                            </div>
                                                            <div class="history__commentsPlug ac-trigger">
                                                                <svg class="history__commentsSel">
                                                                    <use
                                                                        xlink:href="./img/sprites/sprite-mono.svg#sel3"></use>
                                                                </svg>
                                                            </div>
                                                        </div>
                                                        <div class="history__commentsPanel ac-panel">
                                                            @if($order->manager_comment != null)
                                                                <div class="history__comment manager__comment">
                                                                    <div class="history__commentHead">
                                                                        <div class="history__commentName">Менеджер</div>
                                                                        <div class="history__commentTime">
                                                                            {{$order->updated_at->diffForHumans()}}
                                                                        </div>
                                                                    </div>
                                                                    <div class="history__commentBody">
                                                                        {{$order->manager_comment}}
                                                                    </div>
                                                                    {{--                                                                    <div class="history__commentAnswer link"--}}
                                                                    {{--                                                                         role="button" tabindex="0">Ответить--}}
                                                                    {{--                                                                    </div>--}}
                                                                </div>
                                                                <div class="all__messages">
                                                                    @foreach(\App\Models\Comment::where('order_id', $order->id)->get() as $comment)
                                                                        <div class="history__comment"
                                                                             style="margin-bottom: 10px">
                                                                            <div class="history__commentHead">
                                                                                <div
                                                                                    class="history__commentName">{{\App\Models\User::where('id', $comment->user_id)->get()[0]['name']}}</div>
                                                                                <div class="history__commentTime">
                                                                                    {{$comment->created_at->diffForHumans()}}
                                                                                </div>
                                                                            </div>
                                                                            <div class="history__commentBody">
                                                                                {{$comment->body}}
                                                                            </div>
                                                                        </div>
                                                                    @endforeach
                                                                </div>
                                                                <form class="history__form comment__form"
                                                                      action="/comment/store"
                                                                      method="post">
                                                                    @csrf
                                                                    <input type="hidden" name="user_id" class="user_id"
                                                                           value="{{\Illuminate\Support\Facades\Auth::id()}}">
                                                                    <input type="hidden" name="order_id"
                                                                           class="order_id"
                                                                           value="{{$order->id}}">
                                                                    <textarea class="history__textarea textarea_body"
                                                                              name="body"
                                                                              value="" required></textarea>
                                                                    <div class="history__commentControls">
                                                                        <div class="history__smileBox"
                                                                             id="emoji-trigger">
                                                                            <svg>
                                                                                <use
                                                                                    xlink:href="./img/sprites/sprite-mono.svg#smile"></use>
                                                                            </svg>
                                                                        </div>
                                                                        <button
                                                                            class="history__submit send__comment__btn"
                                                                            type="button">
                                                                            Отправить
                                                                        </button>
                                                                    </div>
                                                                </form>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="history__panelSide">
                                                <ul class="history__panelSideList">
                                                    <li class="history__panelSideItem">Общая стоимость:<span>{{ $order->total_price }} ₽</span>
                                                    </li>
                                                </ul>
                                                {{--                                            <div class="history__pay btn" role="button" tabindex="0">Оплатить online</div>--}}
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            @endforeach

                            {!! $orders->links() !!}


                        </div>
                    @else
                        <div class="history__spollerBox ac">
                            <div class="history__spoller">
                                <div class="history__row">
                                    История заказов пуста
                                </div>
                            </div>
                        </div>

                    @endif
                </div>
            </div>
        </section>
    </main>
    <script>
        $(document).on("click", ".history__getDocs", function () {
            console.log('im here');
            $('.popup_documentation').addClass('_active')
        });
    </script>
    @include('client.dashboard._documentations_model')
@endsection
