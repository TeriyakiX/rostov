@extends('admin.fields.container')

@section('field')
    <div class="form-group">
        <label for="{{ $fieldName }}" style="margin-bottom:20px;">{{ $fieldData['title'] }}</label>

        @foreach($optionsItems as $index=>$option)
            <div class="form-group">
                <input id="{{ $fieldName }}-{{ $index }}" type="checkbox"
                       name="{{ $fieldName }}[]" value="{{ $option->id }}"
                       @if(isset($item) && $item->{$fieldName}()->where('id', $option->id)->exists())
                           checked
                        @endif >
                <label for="{{ $fieldName }}-{{ $index }}">{{ $option->title }}</label>
            </div>
        @endforeach
    </div>
@endsection
