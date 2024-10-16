@extends('layouts.index')
<script
    src="https://code.jquery.com/jquery-3.6.0.min.js"
    integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
    crossorigin="anonymous"></script>
<script src="{{asset('js/owl.carousel.min.js')}}"></script>



@section('content')
    <main class="page">
        <nav class="breadcrumbs">
            <div class="breadcrumbs__container _container">
                <ul class="breadcrumbs__list">
                    <li class="breadcrumbs__item">
                        <a class="breadcrumbs__link" href="{{ route('index.home') }}">
                            <span>Главная</span>
                            <svg>
                                <use xlink:href="{{ asset('img/sprites/sprite-mono.svg#slideArrow') }}"></use>
                            </svg>
                        </a>
                    </li>
                    <li class="breadcrumbs__item">
                        <a class="breadcrumbs__link" href="/posts/vidy-pokrytiya">
                            <span>Виды покрытия</span>
                            <svg>
                                <use xlink:href="{{ asset('img/sprites/sprite-mono.svg#slideArrow') }}"></use>
                            </svg>
                        </a>
                    </li>
                    <li class="breadcrumbs__item">
                        <a class="breadcrumbs__link breadcrumbs__link--active" href="#">
                            <span>{{ $coating->title }}</span>
                            <svg>
                                <use xlink:href="{{ asset('img/sprites/sprite-mono.svg#slideArrow') }}"></use>
                            </svg>
                        </a>
                    </li>
                </ul>
            </div>
        </nav>
        <section class="prodCard">
            <div class="prodCard__container _container">
                <div class="prodCard__content">
                    <div class="prodCard__side">
                        <h2 class="prodCard__title prodCard__title--mobile" data-da=".prodCard__content, 992, 0">
                            {{ $coating->title }}
                        </h2>
                        <div class="prodCard__sideBody">
                            <div class="prodCard__gallery" id="lightgallery">
                                @if($firstPhoto)
                                    <div class="prodCard__galleryHero">
                                        <a class="prodCard__heroBox ibg"
                                           href="{{ asset('upload_images/' . $firstPhoto->path) }}"
                                           data-fslightbox>
                                            <picture>
                                                <source type="image/webp"
                                                        srcset="{{ asset('upload_images/' . $firstPhoto->path) }}">
                                                <img src="{{ asset('upload_images/' . $firstPhoto->path) }}" alt="img0">
                                            </picture>
                                        </a>
                                    </div>
                                @endif
                                <div class="prodCard__galleryThumbs owl-carousel">
                                    @foreach($otherPhotos as $photo)
                                        <div class="prodCard__thumbsWrp" style="width: 80px; margin: 0">
                                            <a class="prodCard__thumbsBox ibg"
                                               href="{{ asset('upload_images/' . $photo->path) }}"
                                               data-fslightbox>
                                                <picture>
                                                    <source type="image/webp"
                                                            srcset="{{ asset('upload_images/' . $photo->path) }}">
                                                    <img src="{{ asset('upload_images/' . $photo->path) }}" alt="img1">
                                                </picture>
                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="addToCartForm">
                        <div class="prodCard__body">
                            <h2 class="prodCard__title prodCard__title--desktop" data-da=".prodCard__content, 992, 0">
                                {{ $coating->title }}
                            </h2>
                            <div style="display: flex">
                                <div class="prodCard__selBox">
                                    @if($coating->protective_layer)
                                        <div class="prodCard__stockParameter">
                                            <div class="prodCard__parameterData-wrapper">
                                                  <div class="prodCard__parameterData-title" style="flex: 1;">Защитный слой Zn</div>
                                                    <div style="display: flex; align-items: end; gap: 10px; width: 100%;flex: 0 1 63%;white-space: nowrap">
                                                        <div
                                                            class="prodCard__parameterData">{{ $coating->protective_layer }}
                                                        </div>
                                                        <div class="prodCard__line" style="border-bottom: 2px dashed #D6D6D6;flex: 1 1 100%;"></div>
                                                    </div>
                                              </div>
                                            <span class="prodCard__tippy tippy" data-tippy="Просто описание">
                                                                        <svg class="description_popup"
                                                                             id="protective_layer_description_popup">
                                                                            <use
                                                                                xlink:href="{{ asset('img/sprites/sprite-mono.svg#vpr') }}"></use>
                                                                        </svg>
                                                                    </span>
                                        </div>
                                    @endif
                                    @if($coating->metal_thickness)
                                        <div class="prodCard__stockParameter">
                                            <div class="prodCard__parameterData-wrapper">
                                                <div class="prodCard__parameterData-title" style="flex: 1;">Толщина металла</div>
                                                <div style="display: flex; align-items: end; gap: 10px; width: 100%;flex: 0 1 63%;white-space: nowrap">
                                                    <div
                                                        class="prodCard__parameterData">{{ $coating->metal_thickness }}
                                                    </div>
                                                    <div class="prodCard__line" style="border-bottom: 2px dashed #D6D6D6;flex: 1 1 100%;"></div>
                                                </div>
                                            </div>
                                            <span class="prodCard__tippy tippy" data-tippy="Просто описание">
                                                                        <svg class="description_popup"
                                                                             id="metal_thickness_description_popup">
                                                                            <use
                                                                                xlink:href="{{ asset('img/sprites/sprite-mono.svg#vpr') }}"></use>
                                                                        </svg>
                                                                    </span>
                                        </div>
                                    @endif
                                    @if($coating->polymer_coating_thickness)
                                        <div class="prodCard__stockParameter">
                                            <div class="prodCard__parameterData-wrapper">
                                                <div class="prodCard__parameterData-title" style="flex: 1;">Толщина полимерного покрытия</div>
                                                <div style="display: flex; align-items: end; gap: 10px; width: 100%;flex: 0 1 63%;white-space: nowrap">
                                                        <div
                                                            class="prodCard__parameterData">{{ $coating->polymer_coating_thickness }}
                                                        </div>
                                                    <div class="prodCard__line" style="border-bottom: 2px dashed #D6D6D6;flex: 1 1 100%;"></div>
                                                    </div>
                                              </div>
                                            <span class="prodCard__tippy tippy" data-tippy="Просто описание">
                                                                        <svg class="description_popup"
                                                                             id="polymer_coating_thickness_description_popup">
                                                                            <use
                                                                                xlink:href="{{ asset('img/sprites/sprite-mono.svg#vpr') }}"></use>
                                                                        </svg>
                                                                    </span>
                                        </div>
                                    @endif
                                    @if($coating->guarantee)
                                        <div class="prodCard__stockParameter">
                                               <div class="prodCard__parameterData-wrapper">
                                                   <div class="prodCard__parameterData-title" style="flex: 1;">Гарантия</div>
                                                   <div style="display: flex; align-items: end; gap: 10px; width: 100%;flex: 0 1 63%;white-space: nowrap">
                                                        <div
                                                            class="prodCard__parameterData">{{ $coating->guarantee }}
                                                        </div>
                                                       <div class="prodCard__line" style="border-bottom: 2px dashed #D6D6D6;flex: 1 1 100%;"></div>
                                                    </div>
                                               </div>
                                            <span class="prodCard__tippy tippy" data-tippy="Просто описание"
                                                  style="margin-top: 10px">
                                                                        <svg class="description_popup"
                                                                             id="guarantee_description_popup">
                                                                            <use
                                                                                xlink:href="{{ asset('img/sprites/sprite-mono.svg#vpr') }}"></use>
                                                                        </svg>
                                                                    </span>
                                        </div>
                                    @endif
                                    @if($coating->light_fastness)
                                        <div class="prodCard__stockParameter">
                                            <div class="prodCard__parameterData-wrapper">
                                                <div class="prodCard__parameterData-title" style="flex: 1;">Цветостойкость</div>
                                                <div style="display: flex; align-items: end; gap: 10px; width: 100%;flex: 0 1 63%;white-space: nowrap">
                                                    <div
                                                        class="prodCard__parameterData">{{ $coating->light_fastness }}
                                                    </div>
                                                    <div class="prodCard__line" style="border-bottom: 2px dashed #D6D6D6;flex: 1 1 100%;"></div>
                                                </div>
                                            </div>
                                            <span class="prodCard__tippy tippy" data-tippy="Просто описание">
                                                                        <svg class="description_popup"
                                                                             id="light_fastness_description_popup">
                                                                            <use
                                                                                xlink:href="{{ asset('img/sprites/sprite-mono.svg#vpr') }}"></use>
                                                                        </svg>
                                                                    </span>
                                        </div>
                                    @endif
                                    <div class="prodCard__desc">
                                        <h3 class="prodCard__subtitle desc" style="font-size: 18px">Описание покрытия</h3>
                                        <div class="prodCard__descBody">
                                            {{$coating->description}}
                                        </div>
                                    </div>
                                    <div class="card__icon--statWrp" style="display: flex; margin-top: 50px">
                                        <div class="card__icon coatings card__icon--stat addTo " data-destination="Compare"
                                             role="button" id="{{$coating->id}}"
                                             tabindex="0">
                                            <svg style="fill: #036cdf">
                                                <use
                                                    xlink:href="{{ asset('/img/sprites/sprite-mono.svg#stat') }}"></use>
                                            </svg>
                                        </div>
                                        <div
                                            style="margin-top: 1px; margin-left: 10px; color: #006BDE; cursor: pointer; font-weight: 700">
                                            добавить в список сравнения
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        </section>

        @if(count($products) > 0)
        <section class="productsTmp">
            <div class="productsTmp__container _container">
                <div class="productsTmp__content">
                    <h1 class="productsTmp__title t" style="margin-bottom: 32px;">
                        Товары, которые могут вам подойти
                    </h1>
{{--                    @if(count($products) == 0)--}}
{{--                        <h2>Пусто</h2>--}}
{{--                    @endif--}}
                    <div class="productsTmp__body" id="data-wrapper">
                        @foreach($products as $product)
                            @include('products._product_item')
                        @endforeach


                    </div>
                    <div style="margin: 20px">
                        {{ ($products->links('pagination::bootstrap-4')) }}
                        @include('layouts.pagination')
                    </div>

                </div>
            </div>
        </section>
        @endif
    </main>



    @include('coatings.coatings_description_modal')

@endsection
<script>
    $(document).ready(function () {
        $(".owl-carousel").owlCarousel({
            autoWidth: true,
        });

        $(document).on('click', '.description_popup', function () {
            if ($(this).attr('id') == 'protective_layer_description_popup') $('.popup_protective_layer_description').addClass('_active')
            if ($(this).attr('id') == 'metal_thickness_description_popup') $('.popup_metal_thickness_description').addClass('_active')
            if ($(this).attr('id') == 'polymer_coating_thickness_description_popup') $('.popup_polymer_coating_thickness_description').addClass('_active')
            if ($(this).attr('id') == 'guarantee_description_popup') $('.popup_guarantee_description').addClass('_active')
            if ($(this).attr('id') == 'light_fastness_description_popup') $('.popup_light_fastness_description').addClass('_active')
        })
    });
</script>

<style>
    .prodCard__descBody {
        line-height: 150%;
    }
    .prodCard__heroBox {
        padding-bottom: 70% !important;
    }

    .prodCard__title--mobile {
        display: none;
    }
    @media (max-width: 900px) {
        .owl-stage {
            display: flex;
            flex-direction: column;
            flex-wrap: wrap;
        }
        .prodCard__title--desktop {
            display: none;
        }
        .prodCard__title--mobile {
            display: flex;
        }
        .card__icon--statWrp {
            margin-top: 0 !important;
        }
        .prodCard__line {
            display: none !important;
        }
        .prodCard__stockParameter {
            border-bottom: 1px dashed #CFCFCF;
        }
        .prodCard__parameterData-title {
            flex: auto !important;
        }
        .prodCard__desc {
            padding-top: 32px !important;
        }
    }
</style>
