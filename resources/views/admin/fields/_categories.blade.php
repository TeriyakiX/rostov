@extends('admin.fields.container')

@section('field')

    @php

    function getChildCategories($parent_id,$parentCategories){
		$child_category_list = array();
		foreach ($parentCategories as $child_category){
			if($parent_id==$child_category->parent_id){
				$child_category_list[]  = $child_category;
			}
		}
		return $child_category_list;
    }
    /*print_r(getChildCategories(36,$parentCategories));*/
    /*print_r($parentCategories);*/
    @endphp
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
						<div class="form-group" style="margin-left:20px;">
							@foreach(getChildCategories($subcategory->id,$rootSubCategories) as $Subcategory)
							
							
								<input id="{{ $fieldName }}-{{ $Subcategory->id }}" type="checkbox"
									   name="{{ $fieldName }}[]" value="{{ $Subcategory->id }}"
									   @if(isset($item) && $item->{$fieldName}()->where('id', $Subcategory->id)->exists())
									   checked
									@endif >
								<label for="{{ $fieldName }}-{{ $subcategory->id }}">{{ $Subcategory->title }}</label>

							@endforeach

						</div>
                    </div>
                @endforeach
            </div>
        @endforeach
    </div>
@endsection
