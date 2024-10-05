@extends('admin.fields.container')

@section('field')
    <div class="form-group">
        <label for="{{ $fieldName }}">{{ $fieldData['title'] }}</label>

        @if($files)
            <div style="padding:10px;">
                @foreach($files as $file)
                    <div class="form-group" style="float:left;padding:10px;">
                        <a href="{{ asset('upload_files/' . $file->filepath) }}">Скачать файл "{{ $file->title }}"</a>
                        <br>
                        <a class="btn btn-danger delete-photo"
                           data-url="{{ route('admin.entity.fileDelete', ['id' => $file->id]) }}">
                            Удалить
                        </a>
                    </div>
                @endforeach
            </div>
        @endif

        <div id="file-upload-item" style="margin-top:-20px;">
            <input type="file" id="{{ $fieldName }}"
                   multiple
                   class="form-control"
                   placeholder="{{ $fieldData['title'] }}"
                   style="margin-top:20px;"
                   name="{{ $fieldName }}[]">
        </div>

        <div id="file-upload-container">
            <a class="btn btn-warning file-add-block" style="margin-top:20px;">
                + Добавить форму загрузки
            </a>
        </div>
    </div>
@endsection
