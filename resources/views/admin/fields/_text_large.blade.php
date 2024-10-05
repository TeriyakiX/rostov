@extends('admin.fields.container')

@section('field')
    <div class="form-group">
        <label for="{{ $fieldName }}">{{ $fieldData['title'] }}</label>
        <textarea id="{{ $fieldName }}"
                  style="min-height: 290px"
                  class="form-control"
                  placeholder="{{ $fieldData['title'] }}"
                  name="{{ $fieldName }}">
            @if(isset($item))
                {{$item->$fieldName}}
            @endif
        </textarea>
    </div>
@endsection
