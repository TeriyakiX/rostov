<div class="swiper-slide itemsSlider__slide slider_item" id="{{ $sliderProduct->categories->first()->title??'' }}">
    <div class="card newItems__card" data-product="{{ $sliderProduct->id }}">

        @if($sliderProduct->is_novelty)
            <div class="card__new-label">New</div>
        @endif

        <div class="card__imgBox-wrapper">
            @if($sliderProduct->is_promo)
                <div class="card__promo-label">{{$sliderProduct->getFormattedEndPromoDate()}}</div>
            @endif
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
                    <div>
                        @if(intval($sliderProduct->promo_price) == $sliderProduct->promo_price)
                            {{ number_format($sliderProduct->promo_price, 0, ',', ' ') }} ₽
                        @else
                            {{ number_format($sliderProduct->promo_price, 2, ',', ' ') }} ₽
                        @endif
                        @if($sliderProduct->show_calculator)/м²@endif
                    </div>
                    <div style="text-decoration: line-through; font-size: 12px">
                        @if(intval($sliderProduct->price) == $sliderProduct->price)
                            {{ number_format($sliderProduct->price, 0, ',', ' ') }} ₽
                        @else
                            {{ number_format($sliderProduct->price, 2, ',', ' ') }} ₽
                        @endif
                        @if($sliderProduct->show_calculator)/м²@endif
                    </div>
                @else
                    @if(intval($sliderProduct->price) == $sliderProduct->price)
                        {{ number_format($sliderProduct->price, 0, ',', ' ') }} ₽
                    @else
                        {{ number_format($sliderProduct->price, 2, ',', ' ') }} ₽
                    @endif
                    @if($sliderProduct->show_calculator)/м²@endif
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
                    <div class="card__icon card__icon--basket"
                         data-action="{{ route('index.cart.add') }}"

                         data-product-id="{{ $sliderProduct->id }}"
                         data-total-price="{{ $sliderProduct->total_price }}"
                         data-price="{{ $sliderProduct->is_promo ?  $sliderProduct->promo_price :  $sliderProduct->price }}"
                         data-length="{{ $sliderProduct->length }}"
                         data-total-square="{{ $sliderProduct->total_square }}"
                         data-start-price-promo="{{ $sliderProduct->is_promo ?  $sliderProduct->promo_price : 0 }}"
                         data-start-price="{{ $sliderProduct->price }}"
                         data-attribute-prices="{{$sliderProduct->attribute_prices ? $product->attribute_prices : 0}}"
                         data-color="{{ $sliderProduct->color }}"
                         data-quantity="1"
                         data-width="{{ $sliderProduct->list_width_useful }}"
                         data-destination="Basket"
                         role="button"
                         tabindex="0">
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
