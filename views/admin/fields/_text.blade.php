@extends('admin.fields.container')

@section('field')
    <div class="form-group">
        <label for="{{ $fieldName }}">{{ $fieldData['title'] }}</label>
        <input type="text" id="{{ $fieldName }}"
               class="form-control"
               @if(isset($item))
                   value="{{ $item->$fieldName }}"
               @endif
               placeholder="{{ $fieldData['title'] }}"
               name="{{ $fieldName }}">
    </div>
@endsection
