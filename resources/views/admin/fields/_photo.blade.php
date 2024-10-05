@extends('admin.fields.container')

@section('field')
    <div class="form-group">
        <label for="{{ $fieldName }}">{{ $fieldData['title'] }}</label>
        @if($photoPath)
            <div>
                <a href="{{ asset('upload_images/' . $photoPath) }}">
                    <img class="main-page-image" style="max-width: 100px; max-height: 100px;"
                         src="{{ asset('upload_images/' . $photoPath) }}" alt="{{ $fieldData['title'] }}">
                </a>
            </div>
        @endif
        <input type="file" id="{{ $fieldName }}"
               class="form-control"
               placeholder="{{ $fieldData['title'] }}"
               name="{{ $fieldName }}">

        @if($photoPath)
        <input type="hidden" name="is_delete" value="0">
        <button type="button" class="btn btn-danger delete-photo">
            Удалить
        </button>
        @endif
    </div>
@endsection
