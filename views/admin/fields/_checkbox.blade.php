@extends('admin.fields.container')

@section('field')
    <div class="form-group">
        <input type="hidden" value="0" name="{{ $fieldName }}">
        <input type="checkbox" id="{{ $fieldName }}"
               value="1"
               @if(isset($item) && $item->$fieldName)
               checked
               @endif
               placeholder="{{ $fieldData['title'] }}"
               name="{{ $fieldName }}">
        <label for="{{ $fieldName }}">{{ $fieldData['title'] }}</label>
    </div>
@endsection
