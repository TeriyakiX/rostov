@extends('admin.fields.container')

@section('field')
    <div class="form-group">
        <label for="{{ $fieldName }}">{{ $fieldData['title'] }}</label>
        @if($photoPath)
            <div>
                <a href="{{ asset('upload_images/' . $photoPath) }}">
                    <img style="max-width: 100px; max-height: 100px;"
                         src="{{ asset('upload_images/' . $photoPath) }}" alt="{{ $fieldData['title'] }}">
                </a>
            </div>
        @endif
        <input type="file" id="{{ $fieldName }}"
               class="form-control"
               placeholder="{{ $fieldData['title'] }}"
               name="{{ $fieldName }}">
    </div>
@endsection
