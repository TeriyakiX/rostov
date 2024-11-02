@extends('layouts.index')

@section('seo_title', $category->seo_title)
@section('seo_description', $category->seo_description)
@section('seo_keywords', $category->seo_keywords)

@section('content')
    <main class="page" style="padding-bottom:77px">
        <nav class="breadcrumbs">
            <div class="breadcrumbs__container _container">
                <ul class="breadcrumbs__list">
                    <li class="breadcrumbs__item">
                        <a class="breadcrumbs__link" href="{{ url('/') }}"><span>Главная</span>
                            <svg>
                                <use xlink:href="/img/sprites/sprite-mono.svg#slideArrow"></use>
                            </svg>
                        </a>
                    </li>
                    <li class="breadcrumbs__item">
                        <a class="breadcrumbs__link" href="{{ url('/posts/katalog') }}"><span>Каталог</span>
                            <svg>
                                <use xlink:href="/img/sprites/sprite-mono.svg#slideArrow"></use>
                            </svg>
                        </a>
                    </li>
                    @if($parent = $category->parent)
                        @if($parentParent = $parent->parent)
                            <li class="breadcrumbs__item">
                                <a class="breadcrumbs__link"
                                   href="{{ route('index.products.categoryList', ['category' => $parentParent->slug]) }}">
                                    <span>{{ $parentParent->title }}</span>
                                    <svg>
                                        <use xlink:href="/img/sprites/sprite-mono.svg#slideArrow"></use>
                                    </svg>
                                </a>
                            </li>
                        @endif
                        @if(is_null($parent->parent_id))
                            <li class="breadcrumbs__item">
                                <a class="breadcrumbs__link"
                                   href="{{ route('index.products.categoryList', ['category' => $parent->slug]) }}">
                                    <span>{{ $parent->title }}</span>
                                    <svg>
                                        <use xlink:href="/img/sprites/sprite-mono.svg#slideArrow"></use>
                                    </svg>
                                </a>
                            </li>
                        @else
                            <li class="breadcrumbs__item">
                                <a class="breadcrumbs__link"
                                   href="{{ route('index.products.categoryList', ['category' => $parent->slug]) }}">
                                    <span>{{ $parent->title }}</span>
                                    <svg>
                                        <use xlink:href="/img/sprites/sprite-mono.svg#slideArrow"></use>
                                    </svg>
                                </a>
                            </li>
                        @endif
                    @endif

                    <li class="breadcrumbs__item">
                        <a class="breadcrumbs__link breadcrumbs__link--active">
                            <span>{{ $category->title }}</span>
                            <svg>
                                <use xlink:href="/img/sprites/sprite-mono.svg#slideArrow"></use>
                            </svg>
                        </a>
                    </li>
                </ul>
            </div>
        </nav>
        <section class="brands">
            <div class="brands__container _container">
                <div class="cooperation__body sideDashContainer">
                    {{--                    <div class="sideDash sideDash--sticky" style="z-index: 9999">--}}
                    {{--                        <div class="sideDash__item sideDash__item--gap">--}}
                    {{--                            <svg class="sideDash__icon">--}}
                    {{--                                <use xlink:href="{{ url('/img/sprites/3.png') }}#building">--}}
                    {{--                                    <img src="{{asset('img/sprites/3.png')}}" alt="">--}}
                    {{--                                </use>--}}
                    {{--                            </svg>--}}
                    {{--                            <div class="sideDash__mark"><a--}}
                    {{--                                    href="{{route('index.posts.show',['slug'=>'vidy-pokrytiya'])}}">Виды--}}
                    {{--                                    покрытий</a></div>--}}
                    {{--                        </div>--}}
                    {{--                        <div class="sideDash__item sideDash__item--gap">--}}
                    {{--                            <svg class="sideDash__icon">--}}
                    {{--                                <use xlink:href="{{ url('/img/sprites/4.png') }}#building">--}}
                    {{--                                    <img src="{{asset('img/sprites/4.png')}}" alt="">--}}
                    {{--                                </use>--}}
                    {{--                            </svg>--}}
                    {{--                            <div class="sideDash__mark"><a--}}
                    {{--                                    href="{{route('index.posts.show',['slug'=>'gotovye-resheniya']) }}">Готовые--}}
                    {{--                                    решения</a></div>--}}
                    {{--                        </div>--}}
                    {{--                        <div class="sideDash__item sideDash__item--gap">--}}
                    {{--                            <svg class="sideDash__icon">--}}
                    {{--                                <use xlink:href="{{ url('/img/sprites/2.png') }}#building">--}}
                    {{--                                    <img src="{{asset('img/sprites/2.png')}}" alt="">--}}
                    {{--                                </use>--}}
                    {{--                            </svg>--}}
                    {{--                            <div class="sideDash__mark"><a href="/posts/oplata">on-line оплата</a></div>--}}
                    {{--                        </div>--}}
                    {{--                        <div class="sideDash__item sideDash__item--gap">--}}
                    {{--                            <svg class="sideDash__icon">--}}
                    {{--                                <use xlink:href="{{ url('/img/sprites/1.png') }}#building">--}}
                    {{--                                    <img src="{{asset('img/sprites/1.png')}}" alt="">--}}
                    {{--                                </use>--}}
                    {{--                            </svg>--}}
                    {{--                            <div class="sideDash__mark"><a href="/posts/zakazat-raschet">Заказать расчет</a></div>--}}
                    {{--                        </div>--}}
                    {{--                    </div>--}}
                    <div class="brands__content">
                        <div class="brands__head">
                            <h2 class="brands__title t">{{ $category->title }}</h2>
                            <div class="brands__controls newItems__tabs">
                                <a class="brands__tabsEl brands__tabsEl--active newItems__tabsEl" role="button"
                                   tabindex="0" href="#"
                                   onclick="toggleTab('categories')">Категории товаров</a>
                                <a class="brands__tabsEl newItems__tabsEl" role="button" tabindex="0" href="#"
                                   onclick="toggleTab('brands')">Бренды</a>
                            </div>
                        </div>

                        <div class="brands__body">
                            @foreach($category->subcategories as $subcategory)
                                <div class="brands__cardWrp">
                                    <div class="brands__card">
                                        @php $subcategories = $subcategory->subcategories; @endphp
                                        <div class="brands__imgBox ibg">
                                            @if(count($subcategories) > 0)
                                                <a class="brands__imgLink"
                                                   href="{{ route('index.products.categoryList', ['category' => $subcategory->slug]) }}">
                                                    @if($subcategory->image)
                                                        )
                                                        <img src="{{ asset('upload_images/' . $subcategory->image) }}">
                                                    @else
                                                        <picture>
                                                            <source type="image/webp" srcset="/img/brands/bb1.webp">
                                                            <img src="/img/brands/bb1.webp" alt="bb1">
                                                        </picture>
                                                    @endif
                                                </a>
                                            @endif
                                            @if(count($subcategories) == 0)
                                                <a class="brands__imgLink"
                                                   href="{{ route('index.products.category', ['category' => $subcategory->slug]) }}">
                                                    @if($subcategory->image)
                                                        )
                                                        <img src="{{ asset('upload_images/' . $subcategory->image) }}">
                                                    @else
                                                        <picture>
                                                            <source type="image/webp" srcset="/img/brands/bb1.webp">
                                                            <img src="/img/brands/bb1.webp" alt="bb1">
                                                        </picture>
                                                    @endif
                                                </a>
                                            @endif

                                        </div>
                                        <div class="brands__cardBody spollers">

                                            @if(count($subcategories) > 0)
                                                <a class="brands__cardTitle link"
                                                   href="{{ route('index.products.categoryList', ['category' => $subcategory->slug]) }}">
                                                    {{ $subcategory->title }}
                                                </a>
                                            @endif
                                            @if(count($subcategories) == 0)
                                                <a class="brands__cardTitle link"
                                                   href="{{ route('index.products.category', ['category' => $subcategory->slug]) }}">
                                                    {{ $subcategory->title }}
                                                </a>
                                            @endif


                                            {{--                                        --}}{{--<div class="brands__cardCategories ac">--}}

                                            {{--                                            @foreach($subcategories as $index=>$subSubcategory)--}}
                                            {{--                                                @if($index < 5)--}}
                                            {{--                                                    <a class="brands__cardCategory"--}}
                                            {{--                                                       href="{{ route('index.products.category', ['category' => $subSubcategory->slug]) }}">--}}
                                            {{--                                                        {{ $subSubcategory->title }}--}}
                                            {{--                                                    </a>--}}
                                            {{--                                                @endif--}}
                                            {{--                                            @endforeach--}}
                                            {{--                                            @if(count($subcategories) >= 5)--}}
                                            {{--                                                <div class="ac-panel">--}}
                                            {{--                                                    @foreach($subcategories as $index=>$subSubcategory)--}}
                                            {{--                                                        @if($index >= 5)--}}
                                            {{--                                                            <a class="brands__cardCategory"--}}
                                            {{--                                                               href="{{ route('index.products.category', ['category' => $subSubcategory->slug]) }}">--}}
                                            {{--                                                                {{ $subSubcategory->title }}--}}
                                            {{--                                                            </a>--}}
                                            {{--                                                        @endif--}}
                                            {{--                                                    @endforeach--}}
                                            {{--                                                </div>--}}
                                            {{--                                                <div class="brands__cardMore ac-trigger off" data-more-open="Показать еще" data-more-close="Скрыть ">--}}
                                            {{--                                                    {{ count($subcategories) - 5 }} {{ show_categories_count_rus(count($subcategories) - 5) }}--}}
                                            {{--                                                    <svg class="brands__cardArrow">--}}
                                            {{--                                                        <use xlink:href="/img/sprites/sprite-mono.svg#sel3"></use>--}}
                                            {{--                                                    </svg>--}}
                                            {{--                                                </div>--}}
                                            {{--                                            @endif--}}
                                            {{--                                        </div>--}}


                                            <div class="categories__cardCategories"
                                                 id="categories-{{ $subcategory->id }}">
                                                @foreach($subcategories as $index => $subSubcategory)
                                                    <a class="brands__cardCategory {{ $index >= 7 ? 'hidden-category' : '' }}"
                                                       href="{{ route('index.products.category', ['category' => $subSubcategory->slug]) }}">
                                                        <p>{{ $subSubcategory->title }}</p>
                                                    </a>
                                                @endforeach
                                                @if(count($subcategories) > 7)
                                                    <a class="brands__cardCategory-more" href="javascript:void(0);"
                                                       data-category-id="{{ $subcategory->id }}"
                                                       onclick="toggleCategories(this)">
                                                        <p>Показать еще</p>
                                                    </a>
                                                @endif
                                            </div>

                                            <div class="brands__cardCategories" id="brands-{{ $subcategory->id }}">
                                                @foreach ($category->products as $index => $product)
                                                    <a class="brands__cardCategory {{ $index >= 7 ? 'hidden-brand' : '' }}" href="{{ $product->brand ? '/brands/' . $product->brand['id'] : '#' }}">
                                                        <p>{{ $product->brand ? $product->brand->title : 'Без бренда' }}</p>
                                                    </a>
                                                @endforeach
                                                @if(count($category->products) > 7)
                                                    <a class="brands__cardCategory-more" href="javascript:void(0);"
                                                       data-brand-id="{{ $subcategory->id }}"
                                                       onclick="toggleBrands(this)">
                                                        <p>Показать еще</p>
                                                    </a>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- SLIDERS --}}

        <section class="newItems analogs">
            <div class="newItems__container _container">
                <div class="newItems__content">
                    <div class="newItems__body">
                        <div class="newItems__controlPanel">
                            <h2 class="newItems__title t">Новинки ассортимента</h2>
                            <div class="newItems__sliderBtns">
                                <div class="newItems__sliderBtn newItems__sliderBtn--prev" role="button" tabindex="0">
                                    <svg>
                                        <use xlink:href="{{ asset('img/sprites/sprite-mono.svg#slideArrow') }}"></use>
                                    </svg>
                                </div>
                                <div class="newItems__sliderBtn newItems__sliderBtn--next" role="button" tabindex="0">
                                    <svg>
                                        <use xlink:href="{{ asset('img/sprites/sprite-mono.svg#slideArrow') }}"></use>
                                    </svg>
                                </div>
                            </div>
                        </div>
                        <div class="wrp-itemsSlider">
                            <div class="swiper-container itemsSlider _swiper">
                                <div class="swiper-wrapper itemsSlider__wrapper">
                                    @foreach($sliderProducts as $sliderProduct)
                                        @include('products._block_item')
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="newItems analogs">
            <div class="newItems__container _container">
                <div class="newItems__content">
                    <div class="newItems__body">
                        <div class="newItems__controlPanel">
                            <h2 class="newItems__title t">Скидки и акции</h2>
                            <div class="newItems__sliderBtns">
                                <div class="newItems__sliderBtn newItems__sliderBtn--prev" role="button" tabindex="0">
                                    <svg>
                                        <use xlink:href="{{ asset('img/sprites/sprite-mono.svg#slideArrow') }}"></use>
                                    </svg>
                                </div>
                                <div class="newItems__sliderBtn newItems__sliderBtn--next" role="button" tabindex="0">
                                    <svg>
                                        <use xlink:href="{{ asset('img/sprites/sprite-mono.svg#slideArrow') }}"></use>
                                    </svg>
                                </div>
                            </div>
                        </div>
                        <div class="wrp-itemsSlider">
                            <div class="swiper-container itemsSlider _swiper">
                                <div class="swiper-wrapper itemsSlider__wrapper">
                                    @foreach($sliderProducts as $sliderProduct)
                                        @include('products._block_item')
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        @if($category->seo_text)
            <div class="_container">
                <p style="line-height: 150%">{!! $category->seo_text !!}</p>
            </div>
        @endif

    </main>
@endsection

<style>
    @media (max-width: 767.98px) {
        .newItems__tabs {
            padding-right: 0 !important;
            overflow: hidden !important;
        }

        .newItems__tabsEl {
            padding: 10px 15px 10px !important;
        }
    }

    .categories__cardCategories,
    .brands__cardCategories {
        display: none;
    }

    /* По умолчанию скрываем дополнительные категории и бренды */
    .hidden-category,
    .hidden-brand {
        display: none;
    }
</style>
<script defer>
    document.addEventListener("DOMContentLoaded", function () {
        // Сначала отображаем только категории, скрывая бренды
        toggleTab('categories');

        // Скрываем все скрытые категории и бренды по умолчанию
        document.querySelectorAll('.hidden-category').forEach(category => {
            category.style.display = 'none';
        });
        document.querySelectorAll('.hidden-brand').forEach(brand => {
            brand.style.display = 'none';
        });
    });

    function toggleCategories(link) {
        const categoryId = link.getAttribute('data-category-id');
        const hiddenCategories = document.querySelectorAll(`#categories-${categoryId} .hidden-category`);

        hiddenCategories.forEach(category => {
            category.style.display = category.style.display === 'none' ? 'flex' : 'none';
        });

        const linkText = link.querySelector('p');
        if (linkText.textContent === 'Показать еще') {
            linkText.textContent = 'Скрыть...';
            linkText.style.fontWeight = '400';
            linkText.style.color = '#000';
        } else {
            linkText.textContent = 'Показать еще';
            linkText.style.fontWeight = '600';
            linkText.style.color = '#006BDE';
        }
    }

    function toggleBrands(link) {
        const brandId = link.getAttribute('data-brand-id');
        const hiddenBrands = document.querySelectorAll(`#brands-${brandId} .hidden-brand`);

        hiddenBrands.forEach(brand => {
            brand.style.display = brand.style.display === 'none' ? 'flex' : 'none';
        });

        const linkText = link.querySelector('p');
        if (linkText.textContent === 'Показать еще') {
            linkText.textContent = 'Скрыть...';
            linkText.style.fontWeight = '400';
            linkText.style.color = '#000';
        } else {
            linkText.textContent = 'Показать еще';
            linkText.style.fontWeight = '600';
            linkText.style.color = '#006BDE';
        }
    }

    function toggleTab(tab) {
        const tabs = document.querySelectorAll('.brands__tabsEl');

        tabs.forEach(tabEl => {
            if (tabEl.textContent === (tab === 'categories' ? 'Категории товаров' : 'Бренды')) {
                tabEl.classList.add('brands__tabsEl--active');
            } else {
                tabEl.classList.remove('brands__tabsEl--active');
            }
        });

        document.querySelectorAll('.brands__cardBody').forEach(card => {
            const subcategoryContainer = card.querySelector('.categories__cardCategories');
            const brandsContainer = card.querySelector('.brands__cardCategories');

            if (tab === 'categories') {
                subcategoryContainer.style.display = 'flex';
                brandsContainer.style.display = 'none';
            } else {
                subcategoryContainer.style.display = 'none';
                brandsContainer.style.display = 'flex';
            }
        });
    }
</script>
