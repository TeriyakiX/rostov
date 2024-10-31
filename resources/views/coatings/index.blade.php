@extends('layouts.index')

@section('content')
    <main class="page" style="margin-bottom: 50px">
        <nav class="breadcrumbs">
            <div class="breadcrumbs__container _container">
                <ul class="breadcrumbs__list">
                    <li class="breadcrumbs__item"><a class="breadcrumbs__link"
                                                     href="{{ url('/') }}"><span>Главная</span>
                            <svg>
                                <use xlink:href="{{ asset('img/sprites/sprite-mono.svg#slideArrow') }}"></use>
                            </svg>
                        </a></li>
                    <li class="breadcrumbs__item"><a class="breadcrumbs__link breadcrumbs__link--active" href="#"><span>Виды покрытия</span>
                            <svg>
                                <use xlink:href="{{ asset('img/sprites/sprite-mono.svg#slideArrow') }}"></use>
                            </svg></a>
                    </li>
                </ul>
            </div>
        </nav>
        <section class="brands">
            <div class="brands__container _container">
                <div class="cooperation__body sideDashContainer">
                <div class="brands__content">
                    <div class="brands__head">
                       <div class="brands__title-wrp">
                           <h2 class="brands__title t">Виды покрытия</h2>
                           <svg class="productsTmp__filters-icon-mobile">
                               <use xlink:href="{{ asset('img/sprites/sprite-mono.svg#fil') }}"></use>
                           </svg>
                       </div>
                        <div class="productsTmp__layoutControl-wrp">
                            <p style="margin-right: 30px;cursor: pointer; display: flex; align-items: center; gap: 4px;">Популярные <span style="font-size: 25px">&#11139;</span>
                            </p>
                            <div class="productsTmp__layoutControl">
                                <div class="productsTmp__layoutBtn productsTmp__layoutBtn--col" role="button"
                                     tabindex="0">
                                    <svg>
                                        <use xlink:href="/img/sprites/sprite-mono.svg#mcol"></use>
                                    </svg>
                                </div>
                                <div class="productsTmp__layoutBtn productsTmp__layoutBtn--line _active" role="button"
                                     tabindex="0">
                                    <svg>
                                        <use xlink:href="/img/sprites/sprite-mono.svg#mline"></use>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="brands__body" style="display: flex">
                        <div class="left__side left__side--desktop">
                            <div style="padding: 10px; background-color: #f6f6f6; width: 100%">
                                {{--                                <div class="productsTmp__sortItem productsTmp__sortItem--drop" role="button"--}}
                                {{--                                     style="display: block; margin-right: 0"--}}
                                {{--                                     tabindex="0">--}}
                                {{--                                    <select class="filters__select product_select" name="product_select" name="orderBy">--}}
                                {{--                                        <option class="filters__op" value="">Вид продукции</option>--}}
                                {{--                                        @foreach(\App\Models\ProductCategory::all() as $category)--}}
                                {{--                                            <option class="filters__op" value="{{$category['id']}}"--}}
                                {{--                                                    @if (in_array($category->id, explode(',', request()->input('product_id')))) selected @endif>--}}
                                {{--                                                {{$category['title']}}--}}
                                {{--                                            </option>--}}
                                {{--                                        @endforeach--}}
                                {{--                                    </select>--}}
                                {{--                                </div>--}}
                                <select class="filters__select coating_id" name="coating_id">
                                    <option class="filters__op" value="">Вид поверхности</option>
                                    @foreach(\App\Models\Coatings::all() as $coating)
                                        <option class="filters__op" value="{{$coating['id']}}"
                                                @if (in_array($coating->id, explode(',', request()->input('coating_id')))) selected @endif>
                                            {{$coating['title']}}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="coatings_attribute_filter" style="margin-top: 20px">
                                {{--                                @foreach($options as $attrName => $attr)--}}
                                {{--                                    <div class="row" style="margin-top: 20px">--}}
                                {{--                                        <div class="col-md-6">--}}
                                {{--                                            <h2 style="font-size: 2rem;font-weight: 700;color: #595959;">--}}
                                {{--                                                {{$attrName}}--}}
                                {{--                                            </h2>--}}
                                {{--                                        </div>--}}
                                {{--                                    </div>--}}
                                {{--                                    <div class="coatings_option_filter">--}}
                                {{--                                        @foreach($attr as $option)--}}
                                {{--                                            <div class="row" style="margin-top: 10px">--}}
                                {{--                                                <div class="col-md-6">--}}
                                {{--                                                    <input--}}
                                {{--                                                        name="attribute" type="checkbox" id="{{$option['id']}}"--}}
                                {{--                                                        value="{{$option['title']}}"--}}
                                {{--                                                        @if (in_array($option->id, explode(',', request()->input('filter.attribute'))))--}}
                                {{--                                                            checked--}}
                                {{--                                                        @endif--}}
                                {{--                                                    >--}}
                                {{--                                                    <label for="{{$option['id']}}" style="margin-top: 10px"--}}
                                {{--                                                           class="m-checkbox">--}}
                                {{--                                                        {{$option['title']}}--}}
                                {{--                                                    </label>--}}
                                {{--                                                </div>--}}
                                {{--                                            </div>--}}
                                {{--                                        @endforeach--}}
                                {{--                                    </div>--}}
                                {{--                                @endforeach--}}
                                <div class="row" style="margin-top: 20px">
                                    <div class="col-md-6">
                                        <h2 style="font-size: 16px;font-weight: 600;color: #595959; margin-bottom: 8px;">
                                            Толщина металла
                                        </h2>
                                    </div>
                                </div>
                                <div class="coatings_option_filter">
                                    <div class="row" style="margin-top: 10px">
                                        <div class="col-md-6">
                                            <input
                                                name="metal_thickness" type="checkbox" id="metal_thickness"
                                                value="0,35 мм"
                                                @if (strpos(request()->input('filter.metal_thickness'), '0,35 мм') === 0 || strpos(request()->input('filter.metal_thickness'), '0,35 мм'))
                                                    checked
                                                @endif
                                            >
                                            <label for="metal_thickness_1" style="margin-top: 10px"
                                                   class="m-checkbox">
                                                0,35 мм
                                            </label>
                                        </div>
                                    </div>

                                    <div class="row" style="margin-top: 10px">
                                        <div class="col-md-6">
                                            <input
                                                name="metal_thickness" type="checkbox" id="metal_thickness"
                                                value="0,40 мм"
                                                @if (strpos(request()->input('filter.metal_thickness'), '0,40 мм') === 0 || strpos(request()->input('filter.metal_thickness'), '0,40 мм'))
                                                    checked
                                                @endif
                                            >
                                            <label for="metal_thickness_1" style="margin-top: 10px"
                                                   class="m-checkbox">
                                                0,40 мм
                                            </label>
                                        </div>
                                    </div>

                                    <div class="row" style="margin-top: 10px">
                                        <div class="col-md-6">
                                            <input
                                                name="metal_thickness" type="checkbox" id="metal_thickness"
                                                value="0,45 мм"
                                                @if (strpos(request()->input('filter.metal_thickness'), '0,45 мм') === 0 || strpos(request()->input('filter.metal_thickness'), '0,45 мм'))
                                                    checked
                                                @endif
                                            >
                                            <label for="metal_thickness_1" style="margin-top: 10px"
                                                   class="m-checkbox">
                                                0,45 мм
                                            </label>
                                        </div>
                                    </div>

                                    <div class="row" style="margin-top: 10px">
                                        <div class="col-md-6">
                                            <input
                                                name="metal_thickness" type="checkbox" id="metal_thickness"
                                                value="0,50 мм"
                                                @if (strpos(request()->input('filter.metal_thickness'), '0,50 мм') === 0 || strpos(request()->input('filter.metal_thickness'), '0,50 мм'))
                                                    checked
                                                @endif
                                            >
                                            <label for="metal_thickness_1" style="margin-top: 10px"
                                                   class="m-checkbox">
                                                0,50 мм
                                            </label>
                                        </div>
                                    </div>

                                    <div class="row" style="margin-top: 10px">
                                        <div class="col-md-6">
                                            <input
                                                name="metal_thickness" type="checkbox" id="metal_thickness"
                                                value="0,55 мм"
                                                @if (strpos(request()->input('filter.metal_thickness'), '0,55 мм') === 0 || strpos(request()->input('filter.metal_thickness'), '0,55 мм'))
                                                    checked
                                                @endif
                                            >
                                            <label for="metal_thickness_1" style="margin-top: 10px"
                                                   class="m-checkbox">
                                                0,55 мм
                                            </label>
                                        </div>
                                    </div>

                                    <div class="row" style="margin-top: 10px">
                                        <div class="col-md-6">
                                            <input
                                                name="metal_thickness" type="checkbox" id="metal_thickness"
                                                value="0,65 мм"
                                                @if (strpos(request()->input('filter.metal_thickness'), '0,65 мм') === 0 || strpos(request()->input('filter.metal_thickness'), '0,65 мм'))
                                                    checked
                                                @endif
                                            >
                                            <label for="metal_thickness_1" style="margin-top: 10px"
                                                   class="m-checkbox">
                                                0,65 мм
                                            </label>
                                        </div>
                                    </div>

                                    <div class="row" style="margin-top: 10px">
                                        <div class="col-md-6">
                                            <input
                                                name="metal_thickness" type="checkbox" id="metal_thickness"
                                                value="0,70 мм"
                                                @if (strpos(request()->input('filter.metal_thickness'), '0,70 мм') === 0 || strpos(request()->input('filter.metal_thickness'), '0,70 мм'))
                                                    checked
                                                @endif
                                            >
                                            <label for="metal_thickness_1" style="margin-top: 10px"
                                                   class="m-checkbox">
                                                0,70 мм
                                            </label>
                                        </div>
                                    </div>

                                </div>
                                <div class="row" style="margin-top: 20px">
                                    <div class="col-md-6">
                                        <h2 style="font-size: 16px;font-weight: 600;color: #595959; margin-bottom: 8px;">
                                            Толщина полимерного покрытия
                                        </h2>
                                    </div>
                                </div>
                                    <div class="coatings_option_filter">
                                        <div class="row" style="margin-top: 10px">
                                            <div class="col-md-6">
                                                <input
                                                    name="polymer_coating_thickness" type="checkbox"
                                                    id="polymer_coating_thickness"
                                                    value="25 мкм"
                                                    @if (strpos(request()->input('filter.polymer_coating_thickness'), '25 мкм') === 0 || strpos(request()->input('filter.polymer_coating_thickness'), '25 мкм'))
                                                        checked
                                                    @endif
                                                >
                                                <label for="polymer_coating_thickness" style="margin-top: 10px"
                                                       class="m-checkbox">
                                                    25 мкм
                                                </label>
                                            </div>
                                        </div>

                                        <div class="row" style="margin-top: 10px">
                                            <div class="col-md-6">
                                                <input
                                                    name="polymer_coating_thickness" type="checkbox"
                                                    id="polymer_coating_thickness"
                                                    value="30 мкм"
                                                    @if (strpos(request()->input('filter.polymer_coating_thickness'), '30 мкм') === 0 || strpos(request()->input('filter.polymer_coating_thickness'), '30 мкм'))
                                                        checked
                                                    @endif
                                                >
                                                <label for="polymer_coating_thickness" style="margin-top: 10px"
                                                       class="m-checkbox">
                                                    30 мкм
                                                </label>
                                            </div>
                                        </div>

                                        <div class="row" style="margin-top: 10px">
                                            <div class="col-md-6">
                                                <input
                                                    name="polymer_coating_thickness" type="checkbox"
                                                    id="polymer_coating_thickness"
                                                    value="50 мкм"
                                                    @if (strpos(request()->input('filter.polymer_coating_thickness'), '50 мкм') === 0 || strpos(request()->input('filter.polymer_coating_thickness'), '50 мкм'))
                                                        checked
                                                    @endif
                                                >
                                                <label for="polymer_coating_thickness" style="margin-top: 10px"
                                                       class="m-checkbox">
                                                    50 мкм
                                                </label>
                                            </div>
                                        </div>

                                        <div class="row" style="margin-top: 10px">
                                            <div class="col-md-6">
                                                <input
                                                    name="polymer_coating_thickness" type="checkbox"
                                                    id="polymer_coating_thickness"
                                                    value="55 мкм"
                                                    @if (strpos(request()->input('filter.polymer_coating_thickness'), '55 мкм') === 0 || strpos(request()->input('filter.polymer_coating_thickness'), '55 мкм'))
                                                        checked
                                                    @endif
                                                >
                                                <label for="polymer_coating_thickness" style="margin-top: 10px"
                                                       class="m-checkbox">
                                                    55 мкм
                                                </label>
                                            </div>
                                        </div>

                                        <div class="row" style="margin-top: 10px">
                                            <div class="col-md-6">
                                                <input
                                                    name="polymer_coating_thickness" type="checkbox"
                                                    id="polymer_coating_thickness"
                                                    value="двухстороннее покрытие"
                                                    @if (strpos(request()->input('filter.polymer_coating_thickness'), 'двухстороннее покрытие') === 0 || strpos(request()->input('filter.polymer_coating_thickness'), 'двухстороннее покрытие'))
                                                        checked
                                                    @endif
                                                >
                                                <label for="polymer_coating_thickness" style="margin-top: 10px"
                                                       class="m-checkbox">
                                                    двухстороннее покрытие
                                                </label>
                                            </div>
                                        </div>

                                    </div>
                            </div>
                            <div class="row" style="margin-top: 20px">
                                <div class="col-md-6">
                                    <h2 style="font-size: 16px;font-weight: 600;color: #595959; margin-bottom: 8px;">
                                        Срок службы
                                    </h2>
                                </div>
                            </div>
                            <div class="coatings_option_filter">
                                <div class="row" style="margin-top: 10px">
                                    <div class="col-md-6">
                                        <input
                                            name="guarantee" type="checkbox" id="guarantee"
                                            value="менее 10 лет"
                                            @if (strpos(request()->input('filter.guarantee'), 'менее 10 лет') === 0 || strpos(request()->input('filter.guarantee'), 'менее 10 лет'))
                                                checked
                                            @endif
                                        >
                                        <label for="guarantee" style="margin-top: 10px"
                                               class="m-checkbox">
                                            менее 10 лет
                                        </label>
                                    </div>
                                </div>

                                <div class="row" style="margin-top: 10px">
                                    <div class="col-md-6">
                                        <input
                                            name="guarantee" type="checkbox" id="guarantee"
                                            value="10-20 лет"
                                            @if (strpos(request()->input('filter.guarantee'), '10-20 лет') === 0 || strpos(request()->input('filter.guarantee'), '10-20 лет'))
                                                checked
                                            @endif
                                        >
                                        <label for="guarantee" style="margin-top: 10px"
                                               class="m-checkbox">
                                            10-20 лет
                                        </label>
                                    </div>
                                </div>

                                <div class="row" style="margin-top: 10px">
                                    <div class="col-md-6">
                                        <input
                                            name="guarantee" type="checkbox" id="guarantee"
                                            value="20-30 лет"
                                            @if (strpos(request()->input('filter.guarantee'), '20-30 лет') === 0 || strpos(request()->input('filter.guarantee'), '20-30 лет'))
                                                checked
                                            @endif
                                        >
                                        <label for="guarantee" style="margin-top: 10px"
                                               class="m-checkbox">
                                            20-30 лет
                                        </label>
                                    </div>
                                </div>

                                <div class="row" style="margin-top: 10px">
                                    <div class="col-md-6">
                                        <input
                                            name="guarantee" type="checkbox" id="guarantee"
                                            value="30-40 лет"
                                            @if (strpos(request()->input('filter.guarantee'), '30-40 лет') === 0 || strpos(request()->input('filter.guarantee'), '30-40 лет'))
                                                checked
                                            @endif
                                        >
                                        <label for="guarantee" style="margin-top: 10px"
                                               class="m-checkbox">
                                            30-40 лет
                                        </label>
                                    </div>
                                </div>

                                <div class="row" style="margin-top: 10px">
                                    <div class="col-md-6">
                                        <input
                                            name="guarantee" type="checkbox" id="guarantee"
                                            value="40-50 лет"
                                            @if (strpos(request()->input('filter.guarantee'), '40-50 лет') === 0 || strpos(request()->input('filter.guarantee'), '40-50 лет'))
                                                checked
                                            @endif
                                        >
                                        <label for="guarantee" style="margin-top: 10px"
                                               class="m-checkbox">
                                            40-50 лет
                                        </label>
                                    </div>
                                </div>

                                <div class="row" style="margin-top: 10px">
                                    <div class="col-md-6">
                                        <input
                                            name="guarantee" type="checkbox" id="guarantee"
                                            value="более 50 лет"
                                            @if (strpos(request()->input('filter.guarantee'), 'более 50 лет') === 0 || strpos(request()->input('filter.guarantee'), 'более 50 лет'))
                                                checked
                                            @endif
                                        >
                                        <label for="guarantee" style="margin-top: 10px"
                                               class="m-checkbox">
                                            более 50 лет
                                        </label>
                                    </div>
                                </div>

                            </div>
                            <div class="row" style="margin-top: 20px">
                                <div class="col-md-6">
                                    <h2 style="font-size: 16px;font-weight: 600;color: #595959; margin-bottom: 8px;">
                                        Цветостойкость
                                    </h2>
                                </div>
                            </div>
                            <div class="coatings_option_filter">
                                <div class="row" style="margin-top: 10px">
                                    <div class="col-md-6">
                                        <input
                                            name="light_fastness" type="checkbox" id="light_fastness"
                                            value="5 баллов"
                                            @if (strpos(request()->input('filter.light_fastness'), '5 баллов') === 0 || strpos(request()->input('filter.light_fastness'), '5 баллов'))
                                                checked
                                            @endif
                                        >
                                        <label for="light_fastness" style="margin-top: 10px"
                                               class="m-checkbox">
                                            5 баллов
                                        </label>
                                    </div>
                                </div>

                                <div class="row" style="margin-top: 10px">
                                    <div class="col-md-6">
                                        <input
                                            name="light_fastness" type="checkbox" id="light_fastness"
                                            value="4 баллов"
                                            @if (strpos(request()->input('filter.light_fastness'), '4 баллов') === 0 || strpos(request()->input('filter.light_fastness'), '4 баллов'))
                                                checked
                                            @endif
                                        >
                                        <label for="light_fastness" style="margin-top: 10px"
                                               class="m-checkbox">
                                            4 баллов
                                        </label>
                                    </div>
                                </div>

                                <div class="row" style="margin-top: 10px">
                                    <div class="col-md-6">
                                        <input
                                            name="light_fastness" type="checkbox" id="light_fastness"
                                            value="3 баллов"
                                            @if (strpos(request()->input('filter.light_fastness'), '3 баллов') === 0 || strpos(request()->input('filter.light_fastness'), '3 баллов'))
                                                checked
                                            @endif
                                        >
                                        <label for="light_fastness" style="margin-top: 10px"
                                               class="m-checkbox">
                                            3 баллов
                                        </label>
                                    </div>
                                </div>

                                <div class="row" style="margin-top: 10px">
                                    <div class="col-md-6">
                                        <input
                                            name="light_fastness" type="checkbox" id="light_fastness"
                                            value="менее 2 баллов"
                                            @if (strpos(request()->input('filter.light_fastness'), 'менее 2 баллов') === 0 || strpos(request()->input('filter.light_fastness'), 'менее 2 баллов'))
                                                checked
                                            @endif
                                        >
                                        <label for="light_fastness" style="margin-top: 10px"
                                               class="m-checkbox">
                                            менее 2 баллов
                                        </label>
                                    </div>
                                </div>

                            </div>
                            <div class="row" style="margin-top: 20px">
                                <div class="col-md-6">
                                    <h2 style="font-size: 16px;font-weight: 600;color: #595959; margin-bottom: 8px;">
                                        Защитный слой Zn
                                    </h2>
                                </div>
                            </div>
                            <div class="coatings_option_filter">
                                <div class="row" style="margin-top: 10px">
                                    <div class="col-md-6">
                                        <input
                                            name="protective_layer" type="checkbox" id="protective_layer"
                                            value="80 гр/м2"
                                            @if (strpos(request()->input('filter.protective_layer'), '80 гр/м2') === 0 || strpos(request()->input('filter.protective_layer'), '80 гр/м2'))
                                                checked
                                            @endif
                                        >
                                        <label for="protective_layer" style="margin-top: 10px"
                                               class="m-checkbox">
                                            80 гр/м2
                                        </label>
                                    </div>
                                </div>

                                <div class="row" style="margin-top: 10px">
                                    <div class="col-md-6">
                                        <input
                                            name="protective_layer" type="checkbox" id="protective_layer"
                                            value="100 гр/м2"
                                            @if (strpos(request()->input('filter.protective_layer'), '100 гр/м2') === 0 || strpos(request()->input('filter.protective_layer'), '100 гр/м2'))
                                                checked
                                            @endif
                                        >
                                        <label for="protective_layer" style="margin-top: 10px"
                                               class="m-checkbox">
                                            100 гр/м2
                                        </label>
                                    </div>
                                </div>

                                <div class="row" style="margin-top: 10px">
                                    <div class="col-md-6">
                                        <input
                                            name="protective_layer" type="checkbox" id="protective_layer"
                                            value="120 гр/м2"
                                            @if (strpos(request()->input('filter.protective_layer'), '120 гр/м2') === 0 || strpos(request()->input('filter.protective_layer'), '120 гр/м2'))
                                                checked
                                            @endif
                                        >
                                        <label for="protective_layer" style="margin-top: 10px"
                                               class="m-checkbox">
                                            120 гр/м2
                                        </label>
                                    </div>
                                </div>

                                <div class="row" style="margin-top: 10px">
                                    <div class="col-md-6">
                                        <input
                                            name="protective_layer" type="checkbox" id="protective_layer"
                                            value="140 гр/м2"
                                            @if (strpos(request()->input('filter.protective_layer'), '140 гр/м2') === 0 || strpos(request()->input('filter.protective_layer'), '140 гр/м2'))
                                                checked
                                            @endif
                                        >
                                        <label for="protective_layer" style="margin-top: 10px"
                                               class="m-checkbox">
                                            140 гр/м2
                                        </label>
                                    </div>
                                </div>

                                <div class="row" style="margin-top: 10px">
                                    <div class="col-md-6">
                                        <input
                                            name="protective_layer" type="checkbox" id="protective_layer"
                                            value="180 гр/м2"
                                            @if (strpos(request()->input('filter.protective_layer'), '180 гр/м2') === 0 || strpos(request()->input('filter.protective_layer'), '180 гр/м2'))
                                                checked
                                            @endif
                                        >
                                        <label for="protective_layer" style="margin-top: 10px"
                                               class="m-checkbox">
                                            180 гр/м2
                                        </label>
                                    </div>
                                </div>

                                <div class="row" style="margin-top: 10px">
                                    <div class="col-md-6">
                                        <input
                                            name="protective_layer" type="checkbox" id="protective_layer"
                                            value="255 гр/м2"
                                            @if (strpos(request()->input('filter.protective_layer'), '255 гр/м2') === 0 || strpos(request()->input('filter.protective_layer'), '255 гр/м2'))
                                                checked
                                            @endif
                                        >
                                        <label for="protective_layer" style="margin-top: 10px"
                                               class="m-checkbox">
                                            255 гр/м2
                                        </label>
                                    </div>
                                </div>

                                <div class="row" style="margin-top: 10px">
                                    <div class="col-md-6">
                                        <input
                                            name="protective_layer" type="checkbox" id="protective_layer"
                                            value="265 гр/м2"
                                            @if (strpos(request()->input('filter.protective_layer'), '265 гр/м2') === 0 || strpos(request()->input('filter.protective_layer'), '265 гр/м2'))
                                                checked
                                            @endif
                                        >
                                        <label for="protective_layer" style="margin-top: 10px"
                                               class="m-checkbox">
                                            265 гр/м2
                                        </label>
                                    </div>
                                </div>

                                <div class="row" style="margin-top: 10px">
                                    <div class="col-md-6">
                                        <input
                                            name="protective_layer" type="checkbox" id="protective_layer"
                                            value="275 гр/м2"
                                            @if (strpos(request()->input('filter.protective_layer'), '275 гр/м2') === 0 || strpos(request()->input('filter.protective_layer'), '275 гр/м2'))
                                                checked
                                            @endif
                                        >
                                        <label for="protective_layer" style="margin-top: 10px"
                                               class="m-checkbox">
                                            275 гр/м2
                                        </label>
                                    </div>
                                </div>

                            </div>
                            <input type="button" id="filter" class="card__btn btn"
                                   style="width: 80%; margin-top: 20px; cursor: pointer"
                                   value="Применить">
                            <input type="button" class="btn cancel_coatings_btn"
                                   style="width: 80%; margin-top: 20px; background-color: #BDBDBD; border: none; cursor: pointer"
                                   value="✖ сбросить">
                        </div>


                        <div class="filter__menu">
                            <div class="filter__menu-header">
                                <div class="filter__menu-filter-icon">
                                    <svg>
                                        <use xlink:href="{{ asset('img/sprites/sprite-mono.svg#fil') }}"></use>
                                    </svg>
                                </div>
                                <div class="filter__menu-close-button">
                                    <svg class="filter__menu-close-icon">
                                        <use xlink:href="{{ asset('/img/sprites/sprite-mono.svg#cancel') }}"></use>
                                    </svg>
                                </div>
                            </div>

                            <div class="left__side left__side--mobile">
                                <div style="padding: 10px; background-color: #f6f6f6; width: 100%">
                                    {{--                                <div class="productsTmp__sortItem productsTmp__sortItem--drop" role="button"--}}
                                    {{--                                     style="display: block; margin-right: 0"--}}
                                    {{--                                     tabindex="0">--}}
                                    {{--                                    <select class="filters__select product_select" name="product_select" name="orderBy">--}}
                                    {{--                                        <option class="filters__op" value="">Вид продукции</option>--}}
                                    {{--                                        @foreach(\App\Models\ProductCategory::all() as $category)--}}
                                    {{--                                            <option class="filters__op" value="{{$category['id']}}"--}}
                                    {{--                                                    @if (in_array($category->id, explode(',', request()->input('product_id')))) selected @endif>--}}
                                    {{--                                                {{$category['title']}}--}}
                                    {{--                                            </option>--}}
                                    {{--                                        @endforeach--}}
                                    {{--                                    </select>--}}
                                    {{--                                </div>--}}
                                    <select class="filters__select coating_id" name="coating_id">
                                        <option class="filters__op" value="">Вид поверхности</option>
                                        @foreach(\App\Models\Coatings::all() as $coating)
                                            <option class="filters__op" value="{{$coating['id']}}"
                                                    @if (in_array($coating->id, explode(',', request()->input('coating_id')))) selected @endif>
                                                {{$coating['title']}}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="coatings_attribute_filter" style="margin-top: 32px">
                                    {{--                                @foreach($options as $attrName => $attr)--}}
                                    {{--                                    <div class="row" style="margin-top: 20px">--}}
                                    {{--                                        <div class="col-md-6">--}}
                                    {{--                                            <h2 style="font-size: 2rem;font-weight: 700;color: #595959;">--}}
                                    {{--                                                {{$attrName}}--}}
                                    {{--                                            </h2>--}}
                                    {{--                                        </div>--}}
                                    {{--                                    </div>--}}
                                    {{--                                    <div class="coatings_option_filter">--}}
                                    {{--                                        @foreach($attr as $option)--}}
                                    {{--                                            <div class="row" style="margin-top: 10px">--}}
                                    {{--                                                <div class="col-md-6">--}}
                                    {{--                                                    <input--}}
                                    {{--                                                        name="attribute" type="checkbox" id="{{$option['id']}}"--}}
                                    {{--                                                        value="{{$option['title']}}"--}}
                                    {{--                                                        @if (in_array($option->id, explode(',', request()->input('filter.attribute'))))--}}
                                    {{--                                                            checked--}}
                                    {{--                                                        @endif--}}
                                    {{--                                                    >--}}
                                    {{--                                                    <label for="{{$option['id']}}" style="margin-top: 10px"--}}
                                    {{--                                                           class="m-checkbox">--}}
                                    {{--                                                        {{$option['title']}}--}}
                                    {{--                                                    </label>--}}
                                    {{--                                                </div>--}}
                                    {{--                                            </div>--}}
                                    {{--                                        @endforeach--}}
                                    {{--                                    </div>--}}
                                    {{--                                @endforeach--}}
                                    <div class="row" style="margin-top: 20px">
                                        <div class="col-md-6">
                                            <h2 style="font-size: 16px;font-weight: 600;color: #595959; margin-bottom: 8px;">
                                                Толщина металла
                                            </h2>
                                        </div>
                                    </div>
                                    <div class="coatings_option_filter">
                                        <div class="row" style="margin-top: 10px">
                                            <div class="col-md-6">
                                                <input
                                                    name="metal_thickness" type="checkbox" id="metal_thickness"
                                                    value="0,35 мм"
                                                    @if (strpos(request()->input('filter.metal_thickness'), '0,35 мм') === 0 || strpos(request()->input('filter.metal_thickness'), '0,35 мм'))
                                                        checked
                                                    @endif
                                                >
                                                <label for="metal_thickness_1" style="margin-top: 10px"
                                                       class="m-checkbox">
                                                    0,35 мм
                                                </label>
                                            </div>
                                        </div>

                                        <div class="row" style="margin-top: 10px">
                                            <div class="col-md-6">
                                                <input
                                                    name="metal_thickness" type="checkbox" id="metal_thickness"
                                                    value="0,40 мм"
                                                    @if (strpos(request()->input('filter.metal_thickness'), '0,40 мм') === 0 || strpos(request()->input('filter.metal_thickness'), '0,40 мм'))
                                                        checked
                                                    @endif
                                                >
                                                <label for="metal_thickness_1" style="margin-top: 10px"
                                                       class="m-checkbox">
                                                    0,40 мм
                                                </label>
                                            </div>
                                        </div>

                                        <div class="row" style="margin-top: 10px">
                                            <div class="col-md-6">
                                                <input
                                                    name="metal_thickness" type="checkbox" id="metal_thickness"
                                                    value="0,45 мм"
                                                    @if (strpos(request()->input('filter.metal_thickness'), '0,45 мм') === 0 || strpos(request()->input('filter.metal_thickness'), '0,45 мм'))
                                                        checked
                                                    @endif
                                                >
                                                <label for="metal_thickness_1" style="margin-top: 10px"
                                                       class="m-checkbox">
                                                    0,45 мм
                                                </label>
                                            </div>
                                        </div>

                                        <div class="row" style="margin-top: 10px">
                                            <div class="col-md-6">
                                                <input
                                                    name="metal_thickness" type="checkbox" id="metal_thickness"
                                                    value="0,50 мм"
                                                    @if (strpos(request()->input('filter.metal_thickness'), '0,50 мм') === 0 || strpos(request()->input('filter.metal_thickness'), '0,50 мм'))
                                                        checked
                                                    @endif
                                                >
                                                <label for="metal_thickness_1" style="margin-top: 10px"
                                                       class="m-checkbox">
                                                    0,50 мм
                                                </label>
                                            </div>
                                        </div>

                                        <div class="row" style="margin-top: 10px">
                                            <div class="col-md-6">
                                                <input
                                                    name="metal_thickness" type="checkbox" id="metal_thickness"
                                                    value="0,55 мм"
                                                    @if (strpos(request()->input('filter.metal_thickness'), '0,55 мм') === 0 || strpos(request()->input('filter.metal_thickness'), '0,55 мм'))
                                                        checked
                                                    @endif
                                                >
                                                <label for="metal_thickness_1" style="margin-top: 10px"
                                                       class="m-checkbox">
                                                    0,55 мм
                                                </label>
                                            </div>
                                        </div>

                                        <div class="row" style="margin-top: 10px">
                                            <div class="col-md-6">
                                                <input
                                                    name="metal_thickness" type="checkbox" id="metal_thickness"
                                                    value="0,65 мм"
                                                    @if (strpos(request()->input('filter.metal_thickness'), '0,65 мм') === 0 || strpos(request()->input('filter.metal_thickness'), '0,65 мм'))
                                                        checked
                                                    @endif
                                                >
                                                <label for="metal_thickness_1" style="margin-top: 10px"
                                                       class="m-checkbox">
                                                    0,65 мм
                                                </label>
                                            </div>
                                        </div>

                                        <div class="row" style="margin-top: 10px">
                                            <div class="col-md-6">
                                                <input
                                                    name="metal_thickness" type="checkbox" id="metal_thickness"
                                                    value="0,70 мм"
                                                    @if (strpos(request()->input('filter.metal_thickness'), '0,70 мм') === 0 || strpos(request()->input('filter.metal_thickness'), '0,70 мм'))
                                                        checked
                                                    @endif
                                                >
                                                <label for="metal_thickness_1" style="margin-top: 10px"
                                                       class="m-checkbox">
                                                    0,70 мм
                                                </label>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="row" style="margin-top: 20px">
                                        <div class="col-md-6">
                                            <h2 style="font-size: 16px;font-weight: 600;color: #595959; margin-bottom: 8px;">
                                                Толщина полимерного покрытия
                                            </h2>
                                        </div>
                                    </div>
                                    <div class="coatings_option_filter">
                                        <div class="row" style="margin-top: 10px">
                                            <div class="col-md-6">
                                                <input
                                                    name="polymer_coating_thickness" type="checkbox"
                                                    id="polymer_coating_thickness"
                                                    value="25 мкм"
                                                    @if (strpos(request()->input('filter.polymer_coating_thickness'), '25 мкм') === 0 || strpos(request()->input('filter.polymer_coating_thickness'), '25 мкм'))
                                                        checked
                                                    @endif
                                                >
                                                <label for="polymer_coating_thickness" style="margin-top: 10px"
                                                       class="m-checkbox">
                                                    25 мкм
                                                </label>
                                            </div>
                                        </div>

                                        <div class="row" style="margin-top: 10px">
                                            <div class="col-md-6">
                                                <input
                                                    name="polymer_coating_thickness" type="checkbox"
                                                    id="polymer_coating_thickness"
                                                    value="30 мкм"
                                                    @if (strpos(request()->input('filter.polymer_coating_thickness'), '30 мкм') === 0 || strpos(request()->input('filter.polymer_coating_thickness'), '30 мкм'))
                                                        checked
                                                    @endif
                                                >
                                                <label for="polymer_coating_thickness" style="margin-top: 10px"
                                                       class="m-checkbox">
                                                    30 мкм
                                                </label>
                                            </div>
                                        </div>

                                        <div class="row" style="margin-top: 10px">
                                            <div class="col-md-6">
                                                <input
                                                    name="polymer_coating_thickness" type="checkbox"
                                                    id="polymer_coating_thickness"
                                                    value="50 мкм"
                                                    @if (strpos(request()->input('filter.polymer_coating_thickness'), '50 мкм') === 0 || strpos(request()->input('filter.polymer_coating_thickness'), '50 мкм'))
                                                        checked
                                                    @endif
                                                >
                                                <label for="polymer_coating_thickness" style="margin-top: 10px"
                                                       class="m-checkbox">
                                                    50 мкм
                                                </label>
                                            </div>
                                        </div>

                                        <div class="row" style="margin-top: 10px">
                                            <div class="col-md-6">
                                                <input
                                                    name="polymer_coating_thickness" type="checkbox"
                                                    id="polymer_coating_thickness"
                                                    value="55 мкм"
                                                    @if (strpos(request()->input('filter.polymer_coating_thickness'), '55 мкм') === 0 || strpos(request()->input('filter.polymer_coating_thickness'), '55 мкм'))
                                                        checked
                                                    @endif
                                                >
                                                <label for="polymer_coating_thickness" style="margin-top: 10px"
                                                       class="m-checkbox">
                                                    55 мкм
                                                </label>
                                            </div>
                                        </div>

                                        <div class="row" style="margin-top: 10px">
                                            <div class="col-md-6">
                                                <input
                                                    name="polymer_coating_thickness" type="checkbox"
                                                    id="polymer_coating_thickness"
                                                    value="двухстороннее покрытие"
                                                    @if (strpos(request()->input('filter.polymer_coating_thickness'), 'двухстороннее покрытие') === 0 || strpos(request()->input('filter.polymer_coating_thickness'), 'двухстороннее покрытие'))
                                                        checked
                                                    @endif
                                                >
                                                <label for="polymer_coating_thickness" style="margin-top: 10px"
                                                       class="m-checkbox">
                                                    двухстороннее покрытие
                                                </label>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <div class="row" style="margin-top: 20px">
                                    <div class="col-md-6">
                                        <h2 style="font-size: 16px;font-weight: 600;color: #595959; margin-bottom: 8px;">
                                            Срок службы
                                        </h2>
                                    </div>
                                </div>
                                <div class="coatings_option_filter">
                                    <div class="row" style="margin-top: 10px">
                                        <div class="col-md-6">
                                            <input
                                                name="guarantee" type="checkbox" id="guarantee"
                                                value="менее 10 лет"
                                                @if (strpos(request()->input('filter.guarantee'), 'менее 10 лет') === 0 || strpos(request()->input('filter.guarantee'), 'менее 10 лет'))
                                                    checked
                                                @endif
                                            >
                                            <label for="guarantee" style="margin-top: 10px"
                                                   class="m-checkbox">
                                                менее 10 лет
                                            </label>
                                        </div>
                                    </div>

                                    <div class="row" style="margin-top: 10px">
                                        <div class="col-md-6">
                                            <input
                                                name="guarantee" type="checkbox" id="guarantee"
                                                value="10-20 лет"
                                                @if (strpos(request()->input('filter.guarantee'), '10-20 лет') === 0 || strpos(request()->input('filter.guarantee'), '10-20 лет'))
                                                    checked
                                                @endif
                                            >
                                            <label for="guarantee" style="margin-top: 10px"
                                                   class="m-checkbox">
                                                10-20 лет
                                            </label>
                                        </div>
                                    </div>

                                    <div class="row" style="margin-top: 10px">
                                        <div class="col-md-6">
                                            <input
                                                name="guarantee" type="checkbox" id="guarantee"
                                                value="20-30 лет"
                                                @if (strpos(request()->input('filter.guarantee'), '20-30 лет') === 0 || strpos(request()->input('filter.guarantee'), '20-30 лет'))
                                                    checked
                                                @endif
                                            >
                                            <label for="guarantee" style="margin-top: 10px"
                                                   class="m-checkbox">
                                                20-30 лет
                                            </label>
                                        </div>
                                    </div>

                                    <div class="row" style="margin-top: 10px">
                                        <div class="col-md-6">
                                            <input
                                                name="guarantee" type="checkbox" id="guarantee"
                                                value="30-40 лет"
                                                @if (strpos(request()->input('filter.guarantee'), '30-40 лет') === 0 || strpos(request()->input('filter.guarantee'), '30-40 лет'))
                                                    checked
                                                @endif
                                            >
                                            <label for="guarantee" style="margin-top: 10px"
                                                   class="m-checkbox">
                                                30-40 лет
                                            </label>
                                        </div>
                                    </div>

                                    <div class="row" style="margin-top: 10px">
                                        <div class="col-md-6">
                                            <input
                                                name="guarantee" type="checkbox" id="guarantee"
                                                value="40-50 лет"
                                                @if (strpos(request()->input('filter.guarantee'), '40-50 лет') === 0 || strpos(request()->input('filter.guarantee'), '40-50 лет'))
                                                    checked
                                                @endif
                                            >
                                            <label for="guarantee" style="margin-top: 10px"
                                                   class="m-checkbox">
                                                40-50 лет
                                            </label>
                                        </div>
                                    </div>

                                    <div class="row" style="margin-top: 10px">
                                        <div class="col-md-6">
                                            <input
                                                name="guarantee" type="checkbox" id="guarantee"
                                                value="более 50 лет"
                                                @if (strpos(request()->input('filter.guarantee'), 'более 50 лет') === 0 || strpos(request()->input('filter.guarantee'), 'более 50 лет'))
                                                    checked
                                                @endif
                                            >
                                            <label for="guarantee" style="margin-top: 10px"
                                                   class="m-checkbox">
                                                более 50 лет
                                            </label>
                                        </div>
                                    </div>

                                </div>
                                <div class="row" style="margin-top: 20px">
                                    <div class="col-md-6">
                                        <h2 style="font-size: 16px;font-weight: 600;color: #595959; margin-bottom: 8px;">
                                            Цветостойкость
                                        </h2>
                                    </div>
                                </div>
                                <div class="coatings_option_filter">
                                    <div class="row" style="margin-top: 10px">
                                        <div class="col-md-6">
                                            <input
                                                name="light_fastness" type="checkbox" id="light_fastness"
                                                value="5 баллов"
                                                @if (strpos(request()->input('filter.light_fastness'), '5 баллов') === 0 || strpos(request()->input('filter.light_fastness'), '5 баллов'))
                                                    checked
                                                @endif
                                            >
                                            <label for="light_fastness" style="margin-top: 10px"
                                                   class="m-checkbox">
                                                5 баллов
                                            </label>
                                        </div>
                                    </div>

                                    <div class="row" style="margin-top: 10px">
                                        <div class="col-md-6">
                                            <input
                                                name="light_fastness" type="checkbox" id="light_fastness"
                                                value="4 баллов"
                                                @if (strpos(request()->input('filter.light_fastness'), '4 баллов') === 0 || strpos(request()->input('filter.light_fastness'), '4 баллов'))
                                                    checked
                                                @endif
                                            >
                                            <label for="light_fastness" style="margin-top: 10px"
                                                   class="m-checkbox">
                                                4 баллов
                                            </label>
                                        </div>
                                    </div>

                                    <div class="row" style="margin-top: 10px">
                                        <div class="col-md-6">
                                            <input
                                                name="light_fastness" type="checkbox" id="light_fastness"
                                                value="3 баллов"
                                                @if (strpos(request()->input('filter.light_fastness'), '3 баллов') === 0 || strpos(request()->input('filter.light_fastness'), '3 баллов'))
                                                    checked
                                                @endif
                                            >
                                            <label for="light_fastness" style="margin-top: 10px"
                                                   class="m-checkbox">
                                                3 баллов
                                            </label>
                                        </div>
                                    </div>

                                    <div class="row" style="margin-top: 10px">
                                        <div class="col-md-6">
                                            <input
                                                name="light_fastness" type="checkbox" id="light_fastness"
                                                value="менее 2 баллов"
                                                @if (strpos(request()->input('filter.light_fastness'), 'менее 2 баллов') === 0 || strpos(request()->input('filter.light_fastness'), 'менее 2 баллов'))
                                                    checked
                                                @endif
                                            >
                                            <label for="light_fastness" style="margin-top: 10px"
                                                   class="m-checkbox">
                                                менее 2 баллов
                                            </label>
                                        </div>
                                    </div>

                                </div>
                                <div class="row" style="margin-top: 20px">
                                    <div class="col-md-6">
                                        <h2 style="font-size: 16px;font-weight: 600;color: #595959; margin-bottom: 8px;">
                                            Защитный слой Zn
                                        </h2>
                                    </div>
                                </div>
                                <div class="coatings_option_filter">
                                    <div class="row" style="margin-top: 10px">
                                        <div class="col-md-6">
                                            <input
                                                name="protective_layer" type="checkbox" id="protective_layer"
                                                value="80 гр/м2"
                                                @if (strpos(request()->input('filter.protective_layer'), '80 гр/м2') === 0 || strpos(request()->input('filter.protective_layer'), '80 гр/м2'))
                                                    checked
                                                @endif
                                            >
                                            <label for="protective_layer" style="margin-top: 10px"
                                                   class="m-checkbox">
                                                80 гр/м2
                                            </label>
                                        </div>
                                    </div>

                                    <div class="row" style="margin-top: 10px">
                                        <div class="col-md-6">
                                            <input
                                                name="protective_layer" type="checkbox" id="protective_layer"
                                                value="100 гр/м2"
                                                @if (strpos(request()->input('filter.protective_layer'), '100 гр/м2') === 0 || strpos(request()->input('filter.protective_layer'), '100 гр/м2'))
                                                    checked
                                                @endif
                                            >
                                            <label for="protective_layer" style="margin-top: 10px"
                                                   class="m-checkbox">
                                                100 гр/м2
                                            </label>
                                        </div>
                                    </div>

                                    <div class="row" style="margin-top: 10px">
                                        <div class="col-md-6">
                                            <input
                                                name="protective_layer" type="checkbox" id="protective_layer"
                                                value="120 гр/м2"
                                                @if (strpos(request()->input('filter.protective_layer'), '120 гр/м2') === 0 || strpos(request()->input('filter.protective_layer'), '120 гр/м2'))
                                                    checked
                                                @endif
                                            >
                                            <label for="protective_layer" style="margin-top: 10px"
                                                   class="m-checkbox">
                                                120 гр/м2
                                            </label>
                                        </div>
                                    </div>

                                    <div class="row" style="margin-top: 10px">
                                        <div class="col-md-6">
                                            <input
                                                name="protective_layer" type="checkbox" id="protective_layer"
                                                value="140 гр/м2"
                                                @if (strpos(request()->input('filter.protective_layer'), '140 гр/м2') === 0 || strpos(request()->input('filter.protective_layer'), '140 гр/м2'))
                                                    checked
                                                @endif
                                            >
                                            <label for="protective_layer" style="margin-top: 10px"
                                                   class="m-checkbox">
                                                140 гр/м2
                                            </label>
                                        </div>
                                    </div>

                                    <div class="row" style="margin-top: 10px">
                                        <div class="col-md-6">
                                            <input
                                                name="protective_layer" type="checkbox" id="protective_layer"
                                                value="180 гр/м2"
                                                @if (strpos(request()->input('filter.protective_layer'), '180 гр/м2') === 0 || strpos(request()->input('filter.protective_layer'), '180 гр/м2'))
                                                    checked
                                                @endif
                                            >
                                            <label for="protective_layer" style="margin-top: 10px"
                                                   class="m-checkbox">
                                                180 гр/м2
                                            </label>
                                        </div>
                                    </div>

                                    <div class="row" style="margin-top: 10px">
                                        <div class="col-md-6">
                                            <input
                                                name="protective_layer" type="checkbox" id="protective_layer"
                                                value="255 гр/м2"
                                                @if (strpos(request()->input('filter.protective_layer'), '255 гр/м2') === 0 || strpos(request()->input('filter.protective_layer'), '255 гр/м2'))
                                                    checked
                                                @endif
                                            >
                                            <label for="protective_layer" style="margin-top: 10px"
                                                   class="m-checkbox">
                                                255 гр/м2
                                            </label>
                                        </div>
                                    </div>

                                    <div class="row" style="margin-top: 10px">
                                        <div class="col-md-6">
                                            <input
                                                name="protective_layer" type="checkbox" id="protective_layer"
                                                value="265 гр/м2"
                                                @if (strpos(request()->input('filter.protective_layer'), '265 гр/м2') === 0 || strpos(request()->input('filter.protective_layer'), '265 гр/м2'))
                                                    checked
                                                @endif
                                            >
                                            <label for="protective_layer" style="margin-top: 10px"
                                                   class="m-checkbox">
                                                265 гр/м2
                                            </label>
                                        </div>
                                    </div>

                                    <div class="row" style="margin-top: 10px">
                                        <div class="col-md-6">
                                            <input
                                                name="protective_layer" type="checkbox" id="protective_layer"
                                                value="275 гр/м2"
                                                @if (strpos(request()->input('filter.protective_layer'), '275 гр/м2') === 0 || strpos(request()->input('filter.protective_layer'), '275 гр/м2'))
                                                    checked
                                                @endif
                                            >
                                            <label for="protective_layer" style="margin-top: 10px"
                                                   class="m-checkbox">
                                                275 гр/м2
                                            </label>
                                        </div>
                                    </div>

                                </div>
                                <input type="button" id="filter" class="card__btn btn"
                                       style="width: 80%; margin-top: 20px; cursor: pointer"
                                       value="Применить">
                                <input type="button" class="btn cancel_coatings_btn"
                                       style="width: 80%; margin-top: 20px; background-color: #BDBDBD; border: none; cursor: pointer"
                                       value="✖ сбросить">
                            </div>
                        </div>


                        <div class="right__side" style="height: 100%;">
                            @foreach($coatings as $product)
                                <div class="productsTmp__body productsTmp__body--line">
                                    <div class="productsTmp__itemWrp">
                                        <div class="card productsTmp__card coatings" data-product="{{ $product->id }}">
                                            <div class="card__imgWrp">
                                                <a class="card__imgBox"
                                                   href="{{ route('index.products.coatingShow', ['coating' => $product->slug]) }}">
                                                    <picture>
                                                        <source type="image/webp"
                                                                srcset="{{ $product->mainPhotoPath() }}">
                                                        <img src="{{ $product->mainPhotoPath() }}" alt="p1">
                                                    </picture>
                                                </a>
                                            </div>
                                            <div class="card__body">
                                                <div class="card__title">
                                                    <a class="link"
                                                       href="{{ route('index.products.coatingShow', ['coating' => $product->slug]) }}">
                                                        {{ $product->title }}
                                                    </a>

                                                    <div
                                                        class="card__icon card__icon--stat card__icon--stat--mobile addTo"
                                                        data-destination="Compare" role="button" tabindex="0">
                                                        <svg>
                                                            <use
                                                                xlink:href="{{ asset('img/sprites/sprite-mono.svg#stat') }}"></use>
                                                        </svg>
                                                    </div>
                                                </div>
                                                <ul class="card__chars">
                                                    {{mb_substr($product->description, 0, 80, 'UTF-8')}}<b>. . .</b>
                                                </ul>
                                                <div class="card__controllers card__controllers--desktop">
                                                    <a href="{{ route('index.products.coatingShow', ['coating' => $product->slug]) }}">
                                                        <div class="card__btn btn card__detail" role="button" tabindex="0">
                                                            Подробнее
                                                        </div>
                                                    </a>
                                                    <div class="card__icon card__icon--basket" data-destination="Basket" role="button" tabindex="0">
                                                        <svg>
                                                            <use xlink:href="{{ asset('img/sprites/sprite-mono.svg#basket') }}"></use>
                                                        </svg>
                                                    </div>
                                                    <div
                                                        class="card__icon card__icon--stat card__icon--stat--desktop addTo"
                                                        data-destination="Compare" role="button" tabindex="0">
                                                        <svg>
                                                            <use
                                                                xlink:href="{{ asset('img/sprites/sprite-mono.svg#stat') }}"></use>
                                                        </svg>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card__controllers card__controllers--mobile">
                                                <a href="{{ route('index.products.coatingShow', ['coating' => $product->slug]) }}">
                                                    <div class="card__btn btn card__detail" role="button" tabindex="0">
                                                        Подробнее
                                                    </div>
                                                </a>
                                                <div class="card__icon card__icon--basket" data-destination="Basket" role="button" tabindex="0">
                                                    <svg>
                                                        <use xlink:href="{{ asset('img/sprites/sprite-mono.svg#basket') }}"></use>
                                                    </svg>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            </div>
        </section>
    </main>
    <style>
        .card__controllers--mobile {
            display: none;
        }
        .brands__title-wrp {
            display: flex;
            justify-content: space-between;
            align-items: center
        }
        .card__detail {
            width: auto !important;
            flex-grow: 0 !important;
        }
        .card__controllers a {
            flex: 0;
        }
        .card__controllers {
            margin-top: auto;
            justify-content: start !important;
        }
        .card__icon {
            margin-left: 0 !important;
        }
        .card__icon--stat {
            margin-left: 8px !important;
        }
        .card__title {
            margin-top: 0 !important;
        }
        .card__imgBox {
            padding-bottom: 100% !important;
        }
        .card {
            box-shadow: none !important;
        }
        .productsTmp__itemWrp {
            padding: 0 !important;
            padding-bottom: 16px !important;
        }
        .productsTmp__layoutControl-wrp {
            display: flex;
            align-items: center;
        }

        .brands__body {
            margin: 0 !important;
        }
        .left__side {
            width: 30%;
            margin-right: 20px;
        }

        .card__title {
            hyphens: auto !important;
        }

        /*.right__side {*/
        /*    display: flex;*/
        /*    width: 68%;*/
        /*    flex-wrap: wrap;*/
        /*}*/
        .newCol {
            width: 250px !important
        }

        .newBodyCol {
            width: 33.3333%;
        }

        .left__side--mobile {
            display: none;
        }
        .left__side--desktop {
            display: block;
        }
        .card__icon--stat--mobile {
            display: none;
        }

        @media (max-width: 1100px) {
            .left__side {
                width: 100%;
                margin-right: 0;
            }

            .card__btn {
                width: 100%;
            }

        }
        @media (max-width: 767.98px) {
            .card__imgWrp:after {
                border: 12px solid #fff;
                border-left: 12px solid transparent;
                border-top: 12px solid transparent;
            }
            .card__imgWrp:before {
                border: 12px solid #fff;
                border-right: 12px solid transparent;
                border-bottom: 12px solid transparent;
            }
            .cooperation__body ol, .cooperation__body ul {
                margin: 0;
            }
            .card__title {
                display: flex;
                align-items: center;
                justify-content: space-between;
            }
            .card__icon--stat--mobile {
                display: block;
            }
            .card {
                flex-wrap: wrap;
            }
            .card__controllers--mobile {
                display: flex;
                flex: 1 0 100%;
                margin-top: 8px;
            }
            .card__controllers a {
                flex: 1;
            }
            .card__detail {
                width: 100% !important;
            }
            .card__controllers--desktop {
                display: none;
            }
            .filter__menu {
                display: none;
            }
            .filter__menu-filter-icon {
                position: absolute;
                top: 16px;
                left: 16px;
                cursor: pointer;
                z-index: 101;
            }
            .filter__menu-header {
                margin-bottom: 80px;
            }
            .filter__menu--active {
                display: flex;
                width: 100%;
                flex-direction: column;
            }
            .brands__title-wrp {
                width: 100%;
            }
            .brands__head {
                gap: 16px;
            }
            .productsTmp__layoutControl-wrp {
                width: 100%;
                justify-content: space-between;
            }
            .left__side--mobile {
                display: block;
                padding: 0 16px;
                overflow: auto;
                padding-bottom: 32px;
            }
            .left__side--mobile::-webkit-scrollbar {
                width: .4em;
            }
            .left__side--mobile::-webkit-scrollbar,
            .left__side--mobile::-webkit-scrollbar-thumb {
                overflow:visible;
                border-radius: 4px;
            }
            .left__side--mobile::-webkit-scrollbar-thumb {
                background: rgba(0,0,0,.2);
            }
            .left__side--desktop {
                display: none;
            }
        }
    </style>
    <script>
        $(document).ready(function () {
            $(document).on('click', '.productsTmp__layoutBtn', function () {
                if ($(this).hasClass('productsTmp__layoutBtn--col')) {
                    $('.productsTmp__body').each(function () {

                        $(this).addClass('newBodyCol');
                        $('.coatings').addClass('newCol');
                        $(this).removeClass('productsTmp__body--line');
                        $('.right__side').css({"display": "flex", "width": "68%", "flex-wrap": "wrap"});
                        $('.card__chars').css({"display": "none"});

                    })
                } else {
                    $('.productsTmp__body').each(function () {
                        $(this).removeClass('newBodyCol');
                        $('.coatings').removeClass('newCol');
                        $(this).addClass('productsTmp__body--line')
                        $('.right__side').css({"display": "block"});
                        $('.card__chars').css({"display": "block"});
                        // $('.card__body').css({"display": "none"});
                    })
                }
            })

            $(document).on('click', '.cancel_coatings_btn', function () {
                let uri = window.location.toString();
                let clean_uri = uri.substring(0, uri.indexOf("?"));
                window.history.replaceState({}, document.title, clean_uri);
                location.reload()
            })

            function getIds(checkboxName) {
                let checkBoxes = document.getElementsByName(checkboxName);
                let ids = Array.prototype.slice.call(checkBoxes)
                    .filter(ch => ch.checked == true)
                    .map(ch => ch.value);
                return ids;
            }

            function filterResults() {
                let metal_thicknessIds = getIds("metal_thickness").join(';');
                let polymer_coating_thicknessIds = getIds("polymer_coating_thickness").join(';');
                let guaranteeIds = getIds("guarantee").join(';');
                let light_fastnessIds = getIds("light_fastness").join(';');
                let protective_layerIds = getIds("protective_layer").join(';');
                let coating_id = $('.coating_id').val();

                let href = 'vidy-pokrytiya?';

                if (metal_thicknessIds.length) {
                    href += '&filter[metal_thickness]=' + metal_thicknessIds;
                }
                if (polymer_coating_thicknessIds.length) {
                    href += '&filter[polymer_coating_thickness]=' + polymer_coating_thicknessIds;
                }
                if (guaranteeIds.length) {
                    href += '&filter[guarantee]=' + guaranteeIds;
                }
                if (light_fastnessIds.length) {
                    href += '&filter[light_fastness]=' + light_fastnessIds;
                }
                if (protective_layerIds.length) {
                    href += '&filter[protective_layer]=' + protective_layerIds;
                }
                if (coating_id.length) {
                    href += '&coating_id=' + coating_id;
                }

                document.location.href = href;
            }

            document.getElementById("filter").addEventListener("click", filterResults);
        })


        document.querySelector('.productsTmp__filters-icon-mobile').addEventListener('click', function () {
            document.querySelector('.filter__menu').classList.add('filter__menu--active');
        });

        document.querySelector('.filter__menu-close-button').addEventListener('click', function () {
            document.querySelector('.filter__menu').classList.remove('filter__menu--active');
        });
    </script>
@endsection
