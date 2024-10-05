<div class="productsTmp__itemWrp">
    <div class="card productsTmp__card" data-product="{{ $product->id }}">

        <div class="card__imgWrp">
            <a class="card__imgBox"
               href="{{ route('index.products.show', ['product' => $product->slug??'empty', 'category' => $product->categories->first() ? $product->categories->first()->slug : 'empty']) }}">
                <picture>
                    <source type="image/webp"
                            srcset="{{ $product->mainPhotoPath() }}">
                    <img src="{{ $product->mainPhotoPath() }}" alt="p1">
                </picture>
            </a>
            @if($product->is_promo)
                <div class="productsTmp__header" style="background-color: #006BDE;z-index: 3;font-size: 16px;  color: white;height: 33px;padding-top: 4%;padding-left: 1%;"
                >{{$product->getFormattedEndPromoDate()}}</div>
            @endif
        </div>
        <div class="card__body">
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
        </div>
        <div class="card__footer">
            <div class="card__price">
                @if($product->is_promo)
                    <div style="text-decoration: line-through; color: #2d3033ab; font-size: 16px">{{ $product->price }}
                        ₽/{{\App\Models\UnitsOfProducts::where('id',$product->unit_id)->first()->title??'шт.'}} </div>
                    <div style="color: #006BDE; font-size: 26px">{{ $product->promo_price }}
                        ₽/{{\App\Models\UnitsOfProducts::where('id',$product->unit_id)->first()->title??'шт.'}}</div>
                @else
                    {{ $product->price }} ₽/{{\App\Models\UnitsOfProducts::where('id',$product->unit_id)->first()->title??'шт.'}}
                @endif
            </div>
            <div class="card__controllers">
                <a href="{{ route('index.products.show', ['product' => $product->slug??'empty', 'category' => $product->categories->first() ? $product->categories->first()->slug : 'empty']) }}">
                    <div class="card__btn btn" role="button" tabindex="0">
                        Подробнее
                    </div>
                </a>
                <div class="card__icons">
                    <div
                        class="card__icon card__icon--like addTo {{ product_id_in_list($product->id, 'favorites') ? 'active' : '' }}"
                        data-destination="Favorites" role="button" tabindex="0">
                        <svg>
                            <use xlink:href="{{ asset('img/sprites/sprite-mono.svg#heart') }}"></use>
                        </svg>
                    </div>
                    <div
                        class="card__icon card__icon--stat addTo {{ product_id_in_list($product->id, 'compare') ? 'active' : '' }}"
                        data-destination="Compare" role="button" tabindex="0">
                        <svg>
                            <use xlink:href="{{ asset('img/sprites/sprite-mono.svg#stat') }}"></use>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
