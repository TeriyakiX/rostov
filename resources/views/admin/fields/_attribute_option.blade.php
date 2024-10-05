@foreach($options as $index=>$option)
    <div class="form-group">
        <div class="row">
            <div class="col-md-6">
                <input type="hidden"
                       name="options[{{ $attributeItem->id }}][{{ $option->id }}]" value="">
                <input type="checkbox"
                       @if(isset($selectedOptions) && in_array($option->id, $selectedOptions))
                           checked
                       @endif
                       id="options[{{ $attributeItem->id }}][{{ $option->id }}]"
                       name="options[{{ $attributeItem->id }}][{{ $option->id }}]" value="{{ $option->id }}">
                <label for="options[{{ $attributeItem->id }}][{{ $option->id }}]">
                    {{ $option->title }}
                </label>
            </div>
            <div class="col-md-6">
                <input id="prices[{{ $attributeItem->id }}][{{ $option->id }}]"
                       name="prices[{{ $attributeItem->id }}][{{ $option->id }}]"
                       type="number"
                       class="form-control"
                       @if(isset($prices[$option->id]) && $prices[$option->id])
                           value="{{ $prices[$option->id] }}"
                       @else
                           value=""
                       @endif
                       placeholder="+ Цена за выбор опции">
            </div>
        </div>
    </div>
@endforeach
