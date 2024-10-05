@extends('admin.fields.container')

@section('field')

    <div class="row" id="product_type">

        <div class="col-md-6">
            <p>{{ $fieldData['title'] }}</p>
            @foreach(\App\Models\Product::TYPE_NAMES as $index => $name)
                <div class="form-group">
                    <input name="product_type" type="radio"
                           class="product_type_radio"
                           id="product_type_{{ $index }}"
                           @if(isset($item) && $item->product_type == $index)
                           checked
                           @endif
                           value="{{ $index }}">
                    <label for="product_type_{{ $index }}">{{ $name }}</label>
                </div>
            @endforeach
        </div>

        <div class="col-md-6">
            <div class="type_block"
                 id="type_block_{{ \App\Models\Product::TYPE_LIST }}"
                @if(isset($item) && $item->product_type == \App\Models\Product::TYPE_LIST)
                    style="display: block;"
                @else
                    style="display: none;"
                @endif >

                <div class="form-group">
                    <label for="list_width_useful">Ширина в миллиметрах</label>
                    <input name="list_width_useful" type="number"
                           class="form-control"
                           id="widths"
                           @if(isset($item) && $item->list_width_useful)
                           value="{{ $item->list_width_useful }}"
                        @endif >
                </div>

                <div class="form-group">
                    <label for="length_list">Варианты длин через точку с запятой в миллиметрах</label>
                    <input name="length_list" type="text"
                           class="form-control"
                           id="length_list"
                           @if(isset($item) && $item->length_list)
                            value="{{ $item->length_list }}"
                           @endif >
                </div>

                <div class="form-group">
                    <label for="price">Цена за квадратный метр в рублях</label>
                </div>
            </div>

            <div class="type_block"
                 id="type_block_{{ \App\Models\Product::TYPE_LONG }}"
                 @if(isset($item) && $item->product_type == \App\Models\Product::TYPE_LONG)
                    style="display: block;"
                 @else
                    style="display: none;"
                 @endif >

                <div class="form-group">
                    <label for="price">Цена за погонный метр в рублях</label>
                </div>

            </div>

            <div class="type_block"
                 id="type_block_{{ \App\Models\Product::TYPE_PIECE }}"
                 @if(isset($item) && $item->product_type == \App\Models\Product::TYPE_PIECE)
                    style="display: block;"
                 @else
                    style="display: none;"
                @endif >

                <div class="form-group">
                    <label for="price">Цена за штуку в рублях</label>
                </div>

            </div>

            <div class="type_block"
                 id="type_block_{{ \App\Models\Product::TYPE_PACK }}"
                 @if(isset($item) && $item->product_type == \App\Models\Product::TYPE_PACK)
                    style="display: block;"
                 @else
                    style="display: none;"
                @endif >

                <div class="form-group">
                    <label for="price">Цена за пачку в рублях</label>
                </div>
            </div>

            <input name="price" type="number"
                   class="form-control"
                   id="price"
                   @if(isset($item) && $item->price)
                   value="{{ $item->price }}"
                @endif >
        </div>

    </div>

@endsection
