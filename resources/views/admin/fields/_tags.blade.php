@extends('admin.fields.container')
@section('field')
    <label for="{{ $fieldName }}" style="margin-bottom:20px;">{{ $fieldData['title'] }}</label>
    <div class="form-group">


        @foreach($rootTags as $index=>$itemTag)
            @foreach($itemTag->tags as $tag)
                <div>
                    @if(isset($item) && $item->{$fieldName}()->where('id', $tag->id)->exists())

                        <input id="{{ $fieldName }}-{{ $tag->id }}" type="checkbox"
                               name="{{ $fieldName }}[]" value="{{ $tag->id }}" checked >
                        <label for="{{ $fieldName }}-{{ $tag->id }}">{{ $tag->title }}</label>
                    @endif
                </div>


            @endforeach
        @endforeach
                <div id="multiselect1"
                     data-product="{{ isset($item) && $item->{$fieldName}()->exists() }}" data-entity="{{$entity}}">
                    <select style="display:none" name="{{ $fieldName }}[]" multiple placeholder="Select"></select>
                </div>
    </div>
@endsection
