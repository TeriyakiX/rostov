@extends('admin.fields.container')

@section('field')

<!--<pre>
@php
var_dump($optionsItems);
@endphp
</pre>-->
    <div class="form-group">
        <label for="{{ $fieldName }}">{{ $fieldData['title'] }}</label>
        <select id="{{ $fieldName }}"
               class="form-control"
               name="{{ $fieldName }}">

            <option value="">
                Не выбрано
            </option>

            @foreach($optionsItems as $option)
                <option
                    @if(isset($item) && $item->{$fieldName} == $option->id)
                        selected
                    @endif
                    value="{{ $option->id }}">
                    {{ ($option->parent_id ? ' > ' : '') }} {{ $option->title }}
                </option>
            @endforeach

        </select>
    </div>
@endsection
