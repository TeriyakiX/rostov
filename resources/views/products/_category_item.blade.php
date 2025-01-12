<div class="productsTmp__itemWrp">
    <div class="card productsTmp__card" data-product="{{ $product->id }}">
        @if($product->is_novelty)
            <div class="card__new-label">New</div>
        @endif
        <div class="card__imgBox-wrapper">
            @if($product->is_promo)
                <div class="card__promo-label">{{$product->getFormattedEndPromoDate()}}</div>
            @endif
            <a class="card__imgBox"
               href="{{ route('index.products.show', ['product' => $product->slug, 'category' => $category->slug]) }}">
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
                   href="{{ route('index.products.show', ['product' => $product->slug, 'category' => $category->slug]) }}">
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
                            @if(intval($product->promo_price) == $product->promo_price)
                                {{ number_format($product->promo_price, 0, ',', ' ') }} ₽
                            @else
                                {{ number_format($product->promo_price, 2, ',', ' ') }} ₽
                            @endif
                            @if($product->show_calculator)
                                /м²
                            @endif
                        </div>
                        <div style="text-decoration: line-through; font-size: 12px">
                            @if(intval($product->price) == $product->price)
                                {{ number_format($product->price, 0, ',', ' ') }} ₽
                            @else
                                {{ number_format($product->price, 2, ',', ' ') }} ₽
                            @endif
                            @if($product->show_calculator)
                                /м²
                            @endif
                        </div>
                    @else
                        @if(intval($product->price) == $product->price)
                            {{ number_format($product->price, 0, ',', ' ') }} ₽
                        @else
                            {{ number_format($product->price, 2, ',', ' ') }} ₽
                        @endif
                        @if($product->show_calculator)
                            /м²
                        @endif
                    @endif
                </div>
                <div class="card__controllers card__controllers--desktop">
                    <a href="{{ route('index.products.show', ['product' => $product->slug, 'category' => $category->slug]) }}">
                        <div class="card__btn btn" role="button" tabindex="0">
                            Подробнее
                        </div>
                    </a>

                    <div class="card__icons">
                        <a href="{{ route('index.products.show', ['product' => $product->slug, 'category' => $category->slug]) }}" class="card__icon card__icon--basket" data-destination="Basket" role="button" tabindex="0">
                            <svg>
                                <use xlink:href="{{ asset('img/sprites/sprite-mono.svg#basket') }}"></use>
                            </svg>
                        </a>
                    </div>

                    {{--                <div class="card__icons">--}}
                    {{--                    <div class="card__icon card__icon--like addTo {{ product_id_in_list($product->id, 'favorites') ? 'active' : '' }}" data-destination="Favorites"  role="button" tabindex="0">--}}
                    {{--                        <svg>--}}
                    {{--                            <use xlink:href="{{ asset('img/sprites/sprite-mono.svg#heart') }}"></use>--}}
                    {{--                        </svg>--}}
                    {{--                    </div>--}}
                    {{--                    <div class="card__icon card__icon--stat addTo {{ product_id_in_list($product->id, 'compare') ? 'active' : '' }}" data-destination="Compare" role="button" tabindex="0">--}}
                    {{--                        <svg>--}}
                    {{--                            <use xlink:href="{{ asset('img/sprites/sprite-mono.svg#stat') }}"></use>--}}
                    {{--                        </svg>--}}
                    {{--                    </div>--}}
                    {{--                </div>--}}
                </div>
            </div>
        </div>

        <div class="card__controllers card__controllers--mobile">
            <a href="{{ route('index.products.show', ['product' => $product->slug, 'category' => $category->slug]) }}">
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
        </div>
    </div>
</div>
