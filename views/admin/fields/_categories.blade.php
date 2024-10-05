@extends('admin.fields.container')

@section('field')
    <div class="form-group">
        <label for="{{ $fieldName }}" style="margin-bottom:20px;">{{ $fieldData['title'] }}</label>

        @foreach($rootCategories as $index=>$category)
            <div class="form-group">
                <input id="{{ $fieldName }}-{{ $category->id }}" type="checkbox"
                       name="{{ $fieldName }}[]" value="{{ $category->id }}"
                       @if(isset($item) && $item->{$fieldName}()->where('id', $category->id)->exists())
                           checked
                        @endif >
                <label for="{{ $fieldName }}-{{ $category->id }}">{{ $category->title }}</label>

                @foreach($category->subcategories as $subcategory)
                    <div class="form-group" style="margin-left:20px;">
                        <input id="{{ $fieldName }}-{{ $subcategory->id }}" type="checkbox"
                               name="{{ $fieldName }}[]" value="{{ $subcategory->id }}"
                               @if(isset($item) && $item->{$fieldName}()->where('id', $subcategory->id)->exists())
                               checked
                            @endif >
                        <label for="{{ $fieldName }}-{{ $subcategory->id }}">{{ $subcategory->title }}</label>
                    </div>
                @endforeach
            </div>
        @endforeach
    </div>
@endsection
