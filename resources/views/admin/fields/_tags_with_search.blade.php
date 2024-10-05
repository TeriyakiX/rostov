@extends('admin.fields.container')

@section('field')
    <div class="form-group">
        <label for="{{ $fieldName }}" style="margin-bottom:20px;">{{ $fieldData['title'] }}</label>
        @foreach($rootTags as $index=>$itemTag)

            <div class="form-group">


                @foreach($itemTag->tags as $tag)
                    <div class="form-group" style="margin-left:20px;">
                        @if(isset($item) && $item->{$fieldName}()->where('id', $tag->id)->exists())
                        <input id="{{ $fieldName }}-{{ $tag->id }}" type="checkbox"
                               name="{{ $fieldName }}[]" value="{{ $tag->id }}"
                                   checked
                          >
                        @endif
                        <label for="{{ $fieldName }}-{{ $tag->id }}">{{ $tag->title }}</label>
                    </div>
                @endforeach
            </div>
        @endforeach
    </div>
@endsection
