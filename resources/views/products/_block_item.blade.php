<div class="swiper-slide itemsSlider__slide slider_item" id="{{ $sliderProduct->categories->first()->title??'' }}">
    <div class="card newItems__card" data-product="{{ $sliderProduct->id }}">

        <div class="card__new-label">New</div>

        <div class="card__imgBox-wrapper">
            <a class="card__imgBox" href="{{ route('index.products.show',
                    ['product' => $sliderProduct->slug??'empty', 'category' => $sliderProduct->categories->first()->slug??'empty']) }}">
                <picture>
                    <source type="image/webp" srcset="{{ $sliderProduct->mainPhotoPath()??'' }}">
                    <img src="{{ $sliderProduct->mainPhotoPath()??'' }}" alt="ni1" class="cropped-img">
                </picture>
            </a>

            <div class="card__mini-icons">
                <div class="card__mini-icon card__icon--like addTo {{ product_id_in_list($sliderProduct->id, 'favorites') ? 'active' : '' }}" data-destination="Favorites" role="button" tabindex="0">
                    <svg>
                        <use xlink:href="{{ asset('img/sprites/sprite-mono.svg#heart') }}"></use>
                    </svg>
                </div>
                <div class="card__mini-icon card__icon--stat addTo {{ product_id_in_list($sliderProduct->id, 'compare') ? 'active' : '' }}" data-destination="Compare" role="button" tabindex="0">
                    <svg>
                        <use xlink:href="{{ asset('img/sprites/sprite-mono.svg#stat') }}"></use>
                    </svg>
                </div>
            </div>
        </div>
        <div class="card__title">
            <a class="link" href="{{ route('index.products.show',
                ['product' => $sliderProduct->slug??'', 'category' => $sliderProduct->categories->first()->slug??'empty']) }}">
                {{ $sliderProduct->title ??'empty'}}
            </a>
        </div>
        <ul class="card__chars">
            @foreach($sliderProduct->attributesArray() as $productAttribute)
                @if(count($productAttribute['options']) == 1)
                    <li class="card__char">
                        {{ $productAttribute['model']->title }}:
                        {{ $productAttribute['options'][0]->title }}
                    </li>
                @endif
            @endforeach
        </ul>
        <div class="card__footer">
            <div class="card__price">
                @if($sliderProduct->is_promo)
                    <div>{{ $sliderProduct->promo_price }} ₽@if($sliderProduct->show_calculator)/м²@endif</div>
                    <div style="text-decoration: line-through; font-size: 12px">{{ $sliderProduct->price }} ₽@if($sliderProduct->show_calculator)/м²@endif </div>
                @else
                    {{ $sliderProduct->price }} ₽@if($sliderProduct->show_calculator)
                        /м²
                    @endif
                @endif
            </div>
            <div class="card__controllers">
                <a href="{{ route('index.products.show',
                    ['product' => $sliderProduct->slug??'', 'category' => $sliderProduct->categories->first()->slug??'empty']) }}">
                    <div class="card__btn btn" role="button" tabindex="0">
                        Подробнее
                    </div>
                </a>

                <div class="card__icons">
                    <div class="card__icon card__icon--basket" data-destination="Basket" role="button" tabindex="0">
                        <svg>
                            <use xlink:href="{{ asset('img/sprites/sprite-mono.svg#basket') }}"></use>
                        </svg>
                    </div>
                </div>

    {{--            <div class="card__mini-icons-mobile">--}}
    {{--                <div class="card__mini-icon card__icon--like addTo {{ product_id_in_list($sliderProduct->id, 'favorites') ? 'active' : '' }}" data-destination="Favorites" role="button" tabindex="0">--}}
    {{--                    <svg>--}}
    {{--                        <use xlink:href="{{ asset('img/sprites/sprite-mono.svg#heart') }}"></use>--}}
    {{--                    </svg>--}}
    {{--                </div>--}}
    {{--                <div class="card__mini-icon card__icon--stat addTo {{ product_id_in_list($sliderProduct->id, 'compare') ? 'active' : '' }}" data-destination="Compare" role="button" tabindex="0">--}}
    {{--                    <svg>--}}
    {{--                        <use xlink:href="{{ asset('img/sprites/sprite-mono.svg#stat') }}"></use>--}}
    {{--                    </svg>--}}
    {{--                </div>--}}
    {{--            </div>--}}
            </div>
        </div>
    </div>
</div>
