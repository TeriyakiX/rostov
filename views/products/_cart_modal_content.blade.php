@foreach($positions as $position)
    <div class="cart-list__item">
        <div class="card card--cart">
            <div class="card__imgWrp">
                <a class="card__imgBox" href="{{ $position->getProductUrl() }}">
                    <picture>
{{--                        <source type="image/webp" srcset="{{ $position->getPhotoPath() }}">--}}
                        <img src="{{ $position->getPhotoPath() }}" alt="b1">
                    </picture>
                </a>
            </div>
            <div class="card__title">
                {{ $position->getTitle() }} {{ $position->getOptionsText() }}
            </div>
            <div class="card__item">
                Кол-во: {{ $position->getQuantity() }} шт
            </div>
            <div class="card__item">
                {{ $position->getTotalPrice() }} ₽
            </div>
        </div>
    </div>
@endforeach
