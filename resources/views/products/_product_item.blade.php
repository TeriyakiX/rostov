 <div class="productsTmp__itemWrp">
    <div class="card productsTmp__card" data-product="{{ $product->id }}">
        {{--            @if($product->is_promo)--}}
        {{--                <div class="productsTmp__header" style="background-color: #006BDE;z-index: 3;font-size: 16px;  color: white;height: 33px;padding-top: 4%;padding-left: 1%;"--}}
        {{--                >{{$product->getFormattedEndPromoDate()}}</div>--}}
        {{--            @endif--}}
        @if($product->is_novelty)
            <div class="card__new-label">New</div>
        @endif
        <div class="card__imgBox-wrapper">
            @if($product->is_promo)
                <div class="card__promo-label">{{$product->getFormattedEndPromoDate()}}</div>
            @endif
            <a class="card__imgBox"
               href="{{ route('index.products.show', ['product' => $product->slug??'empty', 'category' => $product->categories->first() ? $product->categories->first()->slug : 'empty']) }}">
                <picture>
                    <source type="image/webp"
                            srcset="{{ $product->mainPhotoPath() }}">
                    <img src="{{ $product->mainPhotoPath() }}" alt="p1" class="cropped-img">
                </picture>
            </a>

            <div class="card__mini-icons">
                <div
                    class="card__mini-icon card__icon--like addTo {{ product_id_in_list($product->id, 'favorites') ? 'active' : '' }}"
                    data-destination="Favorites" role="button" tabindex="0">
                    <svg>
                        <use xlink:href="{{ asset('img/sprites/sprite-mono.svg#heart') }}"></use>
                    </svg>
                </div>
                <div
                    class="card__mini-icon card__icon--stat addTo {{ product_id_in_list($product->id, 'compare') ? 'active' : '' }}"
                    data-destination="Compare" role="button" tabindex="0">
                    <svg>
                        <use xlink:href="{{ asset('img/sprites/sprite-mono.svg#stat') }}"></use>
                    </svg>
                </div>
            </div>
        </div>
        <div class="card__desc-wrapper">
            <div class="card__title">
                <a class="link"
                   href="{{ route('index.products.show', ['product' => $product->slug, 'category' => $product->categories->first() ? $product->categories->first()->slug : 'empty']) }}">
                    {{ $product->title }}
                </a>
            </div>
            <ul class="card__chars">
                @foreach($product->attributesArray() as $productAttribute)
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
                    @if($product->is_promo)
                        <div>
                            {{ floor($product->promo_price) == $product->promo_price ? number_format($product->promo_price, 0, '', '') : number_format($product->promo_price, 2, '.', '') }}
                            ₽/{{ \App\Models\UnitsOfProducts::where('id', $product->unit_id)->first()->title ?? 'шт.' }}
                        </div>
                        <div style="text-decoration: line-through; font-size: 12px">
                            {{ floor($product->price) == $product->price ? number_format($product->price, 0, '', '') : number_format($product->price, 2, '.', '') }}
                            ₽/{{ \App\Models\UnitsOfProducts::where('id', $product->unit_id)->first()->title ?? 'шт.' }}
                        </div>
                    @else
                        {{ floor($product->price) == $product->price ? number_format($product->price, 0, '', '') : number_format($product->price, 2, '.', '') }}
                        ₽/{{ \App\Models\UnitsOfProducts::where('id', $product->unit_id)->first()->title ?? 'шт.' }}
                    @endif
                </div>
                <div class="card__controllers card__controllers--desktop">
                    <a href="{{ route('index.products.show', ['product' => $product->slug??'empty', 'category' => $product->categories->first() ? $product->categories->first()->slug : 'empty']) }}">
                        <div class="card__btn btn" role="button" tabindex="0">
                            Подробнее
                        </div>
                    </a>

                    <div class="card__icons">
                        <div class="card__icon card__icon--basket"
                             data-action="{{ route('index.cart.add') }}"

                             data-product-id="{{ $product->id }}"
                             data-total-price="{{ $product->total_price }}"
                             data-price="{{ $product->is_promo ?  $product->promo_price :  $product->price }}"
                             data-length="{{ $product->length }}"
                             data-total-square="{{ $product->total_square }}"
                             data-start-price-promo="{{ $product->is_promo ?  $product->promo_price : 0 }}"
                             data-start-price="{{ $product->price }}"
                             data-attribute-prices="{{$product->attribute_prices ? $product->attribute_prices : 0}}"
                             data-color="{{ $product->color }}"
                             data-quantity="1"
                             data-width="{{ $product->list_width_useful }}"
                             data-destination="Basket"
                             role="button"
                             tabindex="0">
                            <svg>
                                <use xlink:href="{{ asset('img/sprites/sprite-mono.svg#basket') }}"></use>
                            </svg>
                        </div>
                    </div>

                    {{--                <div class="card__icons">--}}
                    {{--                    <div--}}
                    {{--                        class="card__icon card__icon--like addTo {{ product_id_in_list($product->id, 'favorites') ? 'active' : '' }}"--}}
                    {{--                        data-destination="Favorites" role="button" tabindex="0">--}}
                    {{--                        <svg>--}}
                    {{--                            <use xlink:href="{{ asset('img/sprites/sprite-mono.svg#heart') }}"></use>--}}
                    {{--                        </svg>--}}
                    {{--                    </div>--}}
                    {{--                    <div--}}
                    {{--                        class="card__icon card__icon--stat addTo {{ product_id_in_list($product->id, 'compare') ? 'active' : '' }}"--}}
                    {{--                        data-destination="Compare" role="button" tabindex="0">--}}
                    {{--                        <svg>--}}
                    {{--                            <use xlink:href="{{ asset('img/sprites/sprite-mono.svg#stat') }}"></use>--}}
                    {{--                        </svg>--}}
                    {{--                    </div>--}}
                    {{--                </div>--}}
                </div>
            </div>
        </div>
        <div class="card__controllers card__controllers--mobile">
            <a href="{{ route('index.products.show', ['product' => $product->slug??'empty', 'category' => $product->categories->first() ? $product->categories->first()->slug : 'empty']) }}">
                <div class="card__btn btn" role="button" tabindex="0">
                    Подробнее
                </div>
            </a>

            <div class="card__icons">
                <div class="card__icon card__icon--basket"
                     data-action="{{ route('index.cart.add') }}"

                     data-product-id="{{ $product->id }}"
                     data-total-price="{{ $product->total_price }}"
                     data-price="{{ $product->is_promo ?  $product->promo_price :  $product->price }}"
                     data-length="{{ $product->length }}"
                     data-total-square="{{ $product->total_square }}"
                     data-start-price-promo="{{ $product->is_promo ?  $product->promo_price : 0 }}"
                     data-start-price="{{ $product->price }}"
                     data-attribute-prices="{{$product->attribute_prices ? $product->attribute_prices : 0}}"
                     data-color="{{ $product->color }}"
                     data-quantity="1"
                     data-width="{{ $product->list_width_useful }}"
                     data-destination="Basket"
                     role="button"
                     tabindex="0">
                    <svg>
                        <use xlink:href="{{ asset('img/sprites/sprite-mono.svg#basket') }}"></use>
                    </svg>
                </div>
            </div>
        </div>
    </div>
</div>
