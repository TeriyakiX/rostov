<section class="products">


    @if(!isset($post))
        @php
            $category=\App\Models\ProductCategory::query()->whereNull('parent_id')->limit(6)->get()
        @endphp
            <div class="products__container _container">
                <div class="products__content"
                >
                    <div class="products__title--wrapper">
                        <h2 class="products__title t"><a href="/posts/katalog">Товары</a></h2>
                        <div class="newItems__sliderBtns--mobile">
                            <div class="newItems__sliderBtn newItems__sliderBtn--mobile newItems__sliderBtn--prev--mobile" role="button" tabindex="0">
                                <svg>
                                    <use xlink:href="{{ asset('img/sprites/sprite-mono.svg#slideArrow') }}"></use>
                                </svg>
                            </div>
                            <div class="newItems__sliderBtn newItems__sliderBtn--mobile newItems__sliderBtn--next--mobile" role="button" tabindex="0">
                                <svg>
                                    <use xlink:href="{{ asset('img/sprites/sprite-mono.svg#slideArrow') }}"></use>
                                </svg>
                            </div>
                        </div>
                    </div>
                    <div class="products__body products__body--desktop">
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
                                                    <ul class="products__list">
                                                        @foreach($productCategory->subcategories()->limit(3)->get() as $subcategory)
                                                            <li class="products__listItem">
                                                                <a class="products__link"
                                                                   href="{{ route('index.products.categoryList', ['category' => $subcategory->slug]) }}">
																	   {{--href="{{ route('index.products.category', ['category' => $subcategory->slug]) }}">--}}
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
                                    </div>
                                    <a class="products__itemImgBox block-{{$loop->index}}"
                                    href="{{ route('index.products.categoryList', ['category' => $productCategory->slug]) }}">
                                        <div class="products__img"
                                             style="background-image: url({{asset($productCategory->mainPhotoPath())}})"></div>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>


                    <div class="products__body products__body--mobile swiper-container itemsGoodsSlider _swiper">
                        <div class="swiper-wrapper itemsSlider__wrapper">
                            @php
                                $categories = \App\Models\ProductCategory::query()->whereNull('parent_id')->limit(6)->get();
                            @endphp

                            @for ($i = 0; $i < $categories->count(); $i += 2)
                                <div class="products__row swiper-slide itemsSlider__slide slider_item">
                                    @for ($j = $i; $j < $i + 2 && $j < $categories->count(); $j++)
                                        @php
                                            $productCategory = $categories[$j];
                                        @endphp
                                        <div class="products__itemWrp">
                                            <div class="products__itemBox {{ ($j % 2 == 0 ? 'products__itemBox--left' : 'products__itemBox--right') }}">
                                                <div class="products__itemContent">
                                                    <h3 class="products__name">
                                                        <a class="link"
                                                           href="{{ route('index.products.categoryList', ['category' => $productCategory->slug]) }}">
                                                            {{ $productCategory->title }}
                                                        </a>
                                                    </h3>
                                                    <ul class="products__list">
                                                        @foreach($productCategory->subcategories()->limit(3)->get() as $subcategory)
                                                            <li class="products__listItem">
                                                                <a class="products__link"
                                                                   href="{{ route('index.products.categoryList', ['category' => $subcategory->slug]) }}">
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
                                                </div>
                                                <a class="products__itemImgBox block-{{$j}}"
                                                   href="{{ route('index.products.categoryList', ['category' => $productCategory->slug]) }}">
                                                    <div class="products__img"
                                                         style="background-image: url({{asset($productCategory->mainPhotoPath())}})"></div>
                                                </a>
                                            </div>
                                        </div>
                                    @endfor
                                </div>
                            @endfor
                        </div>
                    </div>


                </div>
            </div>
    @else
        @php
            $category=   \App\Models\ProductCategory::query()->whereNull('parent_id')->limit(8)->paginate(8)
        @endphp
        <div class="catalogContainer">

            @foreach($category as $index => $productCategory )

                <div class="catalogItemBoxWrp">
                    <div class="catalogItemBox {{ $index % 2 == 0 ? 'catalogItemBox--left' : 'catalogItemBox--right' }}">

                        <div class="catalogItemContent">
                            <div class="catalogTitle">
                                <a class="link"
                                   href="{{ route('index.products.categoryList', ['category' => $productCategory->slug]) }}">
                                    {{$productCategory->title }}</a>

                            </div>

                            <div class="catalogList">

                                @foreach($productCategory->subcategories()->limit(5)->get() as $index=> $subcategory)
                                    {{--                        <li class="product_list" >  white-space: nowrap;overflow: hidden;   text-overflow: ellipsis; --}}
                                    <a class="products__link title"
                                       style=""
                                       href="{{ route('index.products.categoryList', ['category' => $subcategory->slug]) }}">
                                        {{ $subcategory->title }}
                                    </a>
                                @endforeach

                                    @if($productCategory->subcategories()->count() > 4)
                                        <a class="products__link" href="{{ route('index.products.categoryList', ['category' => $productCategory->slug]) }}">
                                            Ещё...
                                        </a>
                                    @endif

                            </div>
                        </div>
                        <div class="catalogItemImgBox block-{{$loop->index}}">
                            <div class="catalogItemImg"
                                 style="background-image: url({{asset($productCategory->mainPhotoPath())}})">
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

    @endif
    {{--            @dd(\App\Models\ProductCategory::query()->whereNull('parent_id')->get() )--}}
    {{--                <div class="container"--}}
    {{--                     style="background-color: #1c6ca1;"--}}
    {{--                >--}}
    {{--                @foreach(\App\Models\ProductCategory::query()->whereNull('parent_id')->get() as $index => $productCategory)--}}
    {{--                        <div class="product_content" style="width: 46%; background-color: #00bc40;">--}}
    {{--                            <div class="product_background" style="background-image: url({{asset($productCategory->mainPhotoPath())}}); width: 30px;" >--}}
    {{--                        {{$index}}--}}
    {{--                        </div>--}}
    {{--                @endforeach--}}
    {{--                </div>--}}
    {{--    <div class="products__container _container">--}}
    {{--        <div class="products__content" style="display: flex" @if(isset($post)) style="padding: 0" @endif>--}}
    {{--            @if(!isset($post))--}}
    {{--                <h2 class="products__title t"><a href="/posts/katalog">Товары</a></h2>--}}
    {{--            @endif--}}
    {{--            <div class="products_container" >--}}
    {{--                @foreach(\App\Models\ProductCategory::query()->whereNull('parent_id')->get() as $index => $productCategory)--}}

    {{--                    <div class="products__itemWrp" >--}}
    {{--                        <div--}}
    {{--                            class="products__itemBox {{ ($index % 2 == 0 ? 'products__itemBox--left' : 'products__itemBox--right') }}">--}}
    {{--                            <div class="products__itemContent">--}}
    {{--                                <h3 class="products__name">--}}
    {{--                                    <a class="link"--}}
    {{--                                       href="{{ route('index.products.categoryList', ['category' => $productCategory->slug]) }}">--}}
    {{--                                        {{ $productCategory->title }}--}}
    {{--                                    </a>--}}
    {{--                                </h3>--}}
    {{--                                @if(isset($post))--}}
    {{--                                    <ul class="products__list">--}}
    {{--                                        @foreach($productCategory->subcategories()->get() as $subcategory)--}}
    {{--                                            <li class="products__listItem">--}}
    {{--                                                <a class="products__link"--}}
    {{--                                                   href="{{ route('index.products.category', ['category' => $subcategory->slug]) }}">--}}
    {{--                                                    {{ $subcategory->title }}--}}
    {{--                                                </a>--}}
    {{--                                            </li>--}}
    {{--                                        @endforeach--}}
    {{--                                        @else--}}
    {{--                                            <ul class="products__list">--}}
    {{--                                                @foreach($productCategory->subcategories()->limit(3)->get() as $subcategory)--}}
    {{--                                                    <li class="products__listItem">--}}
    {{--                                                        <a class="products__link"--}}
    {{--                                                           href="{{ route('index.products.category', ['category' => $subcategory->slug]) }}">--}}
    {{--                                                            {{ $subcategory->title }}--}}
    {{--                                                        </a>--}}
    {{--                                                    </li>--}}
    {{--                                                @endforeach--}}
    {{--                                                <li class="products__listItem">--}}
    {{--                                                    <a class="products__link"--}}
    {{--                                                       href="{{ route('index.products.categoryList', ['category' => $productCategory->slug]) }}">--}}
    {{--                                                        Ещё...--}}
    {{--                                                    </a>--}}
    {{--                                                </li>--}}
    {{--                                            </ul>--}}
    {{--                                @endif--}}
    {{--                            </div>--}}
    {{--                            <a class="products__itemImgBox block-{{$loop->index}}" @if(isset($post)) style="height: 60%;{{ ($index % 2 == 0 ? 'margin-right: 9%;' : 'margin-left: 9%;') }};@if($loop->index == 4 || $loop->index == 5) height: 40%; @endif" @endif--}}
    {{--                            href="{{ route('index.products.categoryList', ['category' => $productCategory->slug]) }}">--}}
    {{--                                    <div class="products__img"--}}
    {{--                                     style="@if(isset($post)) height: 70%; @endif background-image: url({{ asset($productCategory->mainPhotoPath()) }})"></div>--}}
    {{--                            </a>--}}
    {{--                        </div>--}}

    {{--                    </div>--}}
    {{--                @endforeach--}}
    {{--            </div>--}}
    {{--        </div>--}}
    {{--    </div>--}}
    @if(isset($post) )
        {{ $category->links('pagination::bootstrap-4') }}
        @include('layouts.pagination')
    @endif
</section>
<style>
    .container {
        display: flex;
        justify-content: center;
        flex-wrap: wrap;

    }

    .container_item {
        position: relative;
        /*transform: skew(-5deg);*/
        width: 45%;
        height: 350px;
        margin: 1%;
        background-size: cover;
        background-repeat: no-repeat;
        background-position: center;
        clip-path: polygon(5% 0%, 100% 0%, 95% 100%, 0% 100%);

    }

    .products_title {
        font-size: 36px;
        padding-left: 40px;
        color: white;
    }

    .product_list {
		width: 45%;
		list-style-type: none;
		color: white;
		padding-top: 15px;
		padding-left: 40px;
		font-size: 16px;
	}

    .groupContainer {
        display: flex;
        flex-wrap: wrap;
    }

    @media screen and (max-width: 500px) {
        .container_item {
            width: 100%;
            height: 300px;
        }

        .products_title {
            font-size: 24px;

        }

        .title {
            font-size: 15px;
        }

        .cooperation__body ol li, .cooperation__body ul li {
            margin: 0;
        }

        .product_list {
            padding-top: 3px;
            width: 45% !important;
            padding-left: 25px !important;
        }
    }

    .catalogList {
        display: flex;
        flex-direction: column;
        margin: 0 !important;
        padding: 0 !important;
        padding-top: 10px !important;
        gap: 8px;
    }

</style>
