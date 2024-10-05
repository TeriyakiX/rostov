@extends('admin.fields.container')

@section('field')
    <div class="form-group">
        <label for="{{ $fieldName }}">{{ $fieldData['title'] }}</label>

        @if($photos)
            <div style="padding:10px;">
                @foreach($photos as $photo)
                    <div class="form-group" style="float:left;padding:10px;">
                        <img style="max-width: 200px; max-height: 200px;"
                             src="{{ asset('upload_images/' . $photo->path) }}" alt="{{ $fieldData['title'] }}">
                        <br>
                        <a class="btn btn-danger delete-photo"
                           data-url="{{ route('admin.entity.photoDelete', ['id' => $photo->id]) }}">
                            Удалить
                        </a>
                    </div>
                @endforeach
            </div>
        @endif

        <div id="photo-upload-item" style="margin-top:-20px;">
            <input type="file" id="{{ $fieldName }}"
                   multiple
                   class="form-control"
                   placeholder="{{ $fieldData['title'] }}"
                   style="margin-top:20px;"
                   name="{{ $fieldName }}[]">
        </div>

        <div id="photo-upload-container">
            <a class="btn btn-warning photo-add-block" style="margin-top:20px;">
                + Добавить форму загрузки
            </a>
        </div>
    </div>
@endsection
