@extends('admin.fields.container')

@section('field')
    <div class="form-group">
        <label for="summernote">{{ $fieldData['title'] }}</label>
        <textarea id="summernote" name="{{ $fieldName }}">@if(isset($item) && $item){{ $item->{$fieldName} }}@endif</textarea>
    </div>

    @if(strpos(url()->current(), 'admin/entity/turnkey_solutions/'))
        <div class="form-group">
            <label for="myTiny">Описание</label>
            <textarea id="myTiny" name="description">{{ $item['description'] ?? '' }}</textarea>
        </div>
    @endif
@endsection
