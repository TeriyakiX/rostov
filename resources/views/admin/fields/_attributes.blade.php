@extends('admin.fields.container')

@section('field')
    <div class="form-group">
        <label for="{{ $fieldName }}">{{ $fieldData['title'] }}</label>

        <div id="attribute-item" style="display: none">
            <div class="attribute-block" style="border: 1px solid #e6e6e6; padding: 10px;margin-top:10px;position: relative">
                <input type="button" class="btn btn-danger delete-option"
                       value="Удалить атрибут"
                       style="position: absolute;top:10px;right:10px;">
                <select name="attributes[]" id="{{ $fieldName }}"
                        class="form-control select-attribute" style="margin-bottom:20px;">
                    <option value="">Выберите атрибут...</option>
                    @foreach($attributeItems as $attributeItem)
                        <option value="{{ $attributeItem->id }}">{{ $attributeItem->title }}</option>
                    @endforeach
                </select>

                <div class="options" style="display: none;">
                    {{--show attribute options here--}}
                </div>
            </div>
        </div>

        <div class="attribute-block" style="border: 1px solid #e6e6e6; padding: 10px;margin-top:10px;position: relative">
            @if(count($attributesArray) == 0)
                <select name="attributes[]" id="{{ $fieldName }}"
                        class="form-control select-attribute" style="margin-bottom:20px;">
                    <option value="">Выберите атрибут...</option>
                    @foreach($attributeItems as $attributeItem)
                        <option value="{{ $attributeItem->id }}">{{ $attributeItem->title }}</option>
                    @endforeach
                </select>

                <div class="options" style="display: none;">
                    {{--show attribute options here--}}
                </div>
            @else
                @foreach($attributesArray as $arrayItem)
                    <?php $attr = $arrayItem['attribute']; ?>
                    <?php $options = $arrayItem['options']; ?>
                    <?php $prices = $arrayItem['prices']; ?>
                    <?php $allOptions = $arrayItem['allOptions']; ?>
                    <select name="attributes[]" id="{{ $fieldName }}"
                            class="form-control select-attribute" style="margin-bottom:20px;">
                        <option value="">Выберите атрибут...</option>
                        @foreach($attributeItems as $attributeItem)
                            <option value="{{ $attributeItem->id }}"
                                @if($attr->id == $attributeItem->id) selected @endif>
                                {{ $attributeItem->title }}
                            </option>
                        @endforeach
                    </select>

                    <div class="options">
                        @include('admin.fields._attribute_option', [
                                'options' => $allOptions,
                                'selectedOptions' => $options,
                                'attributeItem' => $attr,
                                'prices' => $prices
                            ])
                    </div>
                @endforeach
            @endif
        </div>

        <div id="attribute-item-container">
        </div>

        <a class="btn btn-warning attribute-add-block" style="margin-top:20px;">
            + Добавить атрибут
        </a>

    </div>
@endsection
