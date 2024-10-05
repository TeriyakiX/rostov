<section class="products">
    <div class="products__container _container">
        <div class="products__content" @if(isset($post)) style="padding: 0" @endif>
            @if(!isset($post))
                <h2 class="products__title t"><a href="/posts/katalog">Товары</a></h2>
            @endif
            <div class="products__body">
                @foreach(\App\Models\ProductCategory::query()->whereNull('parent_id')->limit(6)->get() as $index => $productCategory)
                    <div class="products__itemWrp">
                        <div
                            class="products__itemBox {{ ($index % 2 == 0 ? 'products__itemBox--left' : 'products__itemBox--right') }}">
                            <div class="products__itemContent">
                                <h3 class="products__name">
                                    <a class="link"
                                       href="{{ route('index.products.categoryList', ['category' => $productCategory->slug]) }}">
                                        {{ $productCategory->title }}
                                    </a>
                                </h3>
                                @if(isset($post))
                                    <ul class="products__list">
                                        @foreach($productCategory->subcategories()->get() as $subcategory)
                                            <li class="products__listItem">
                                                <a class="products__link"
                                                   href="{{ route('index.products.category', ['category' => $subcategory->slug]) }}">
                                                    {{ $subcategory->title }}
                                                </a>
                                            </li>
                                        @endforeach
                                        @else
                                            <ul class="products__list">
                                                @foreach($productCategory->subcategories()->limit(3)->get() as $subcategory)
                                                    <li class="products__listItem">
                                                        <a class="products__link"
                                                           href="{{ route('index.products.category', ['category' => $subcategory->slug]) }}">
                                                            {{ $subcategory->title }}
                                                        </a>
                                                    </li>
                                                @endforeach
                                                <li class="products__listItem">
                                                    <a class="products__link"
                                                       href="{{ route('index.products.categoryList', ['category' => $productCategory->slug]) }}">
                                                        Ещё...
                                                    </a>
                                                </li>
                                            </ul>
                                @endif
                            </div>
                            <a class="products__itemImgBox block-{{$loop->index}}" @if(isset($post)) style="height: 60%;{{ ($index % 2 == 0 ? 'margin-right: 9%;' : 'margin-left: 9%;') }};@if($loop->index == 4 || $loop->index == 5) height: 40%; @endif" @endif
                            href="{{ route('index.products.categoryList', ['category' => $productCategory->slug]) }}">
                                <div class="products__img"
                                     style="@if(isset($post)) height: 70%; @endif background-image: url({{ asset('img/index/catalog/c' . ($index+1) . '.jpg') }})"></div>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
