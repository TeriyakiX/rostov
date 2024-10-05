<div class="sideDash sideDash--sticky">
    <a href="{{ route('client.dashboard.index') }}">
        <div class="sideDash__item sideDash__item--gap sideDash__item--active">
            <svg class="sideDash__icon">
                <use xlink:href="/img/sprites/sprite-mono.svg#person"></use>
            </svg>
            <div class="sideDash__mark">Кабинет</div>
        </div>
    </a>
    <a href="{{ route('client.dashboard.orders') }}">
        <div class="sideDash__item sideDash__item--gap">
            <svg class="sideDash__icon">
                <use xlink:href="/img/sprites/sprite-mono.svg#history"></use>
            </svg>
            <div class="sideDash__mark">История заказов</div>
        </div>
    </a>
    <a href="{{ route('auth.logout') }}">
        <div class="sideDash__item sideDash__item--gap">
            <svg class="sideDash__icon">
                <use xlink:href="/img/sprites/sprite-mono.svg#enter"></use>
            </svg>
            <div class="sideDash__mark">Выход</div>
        </div>
    </a>
</div>
