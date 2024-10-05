@extends('admin.fields.container')

@section('field')
    <div class="form-group">
        <label for="{{ $fieldName }}" style="margin-bottom:20px;">{{ $fieldData['title'] }}</label>
        <div id="multiselect" data-product="{{ isset($item) ? $item->id : 0 }}">
            <select style="display:none" name="{{ $fieldName }}[]" multiple placeholder="Select"></select>
        </div>
    </div>
    <div class="form-group" id="sortRelated">

        @foreach(App\Models\RelatedProducts::where('product_id',$item->id??0)->join('products','related_product_id','id')->get()  as $val)

            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text" style="white-space: nowrap;overflow:hidden;text-overflow: ellipsis;max-width: 450px;min-width: 450px">{{$val->title}}</span>
                </div>

                <input type="number" class="form-control " name="relSort[{{$val->related_product_id}}][]" value="{{$val->relSort}}"
                       placeholder="номер сортировки">


            </div>

        @endforeach
    </div>






{{--    @if(!strpos(url()->current(), 'admin/entity/products/'))--}}
{{--        <div class="form-group">--}}
{{--            <label for="{{ $fieldName }}" style="margin-bottom:20px;">{{ $fieldData['title'] }}</label>--}}
{{--            <div id="multiselect" data-product="{{ isset($item) ? $item->id : 0 }}">--}}
{{--                <select style="display:none" name="{{ $fieldName }}[]" multiple placeholder="Select"></select>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    @else--}}
{{--        <div class="form-group">--}}
{{--            <label for="{{ $fieldName }}" style="margin-bottom:20px;">{{ $fieldData['title'] }}</label>--}}
{{--            <select name="{{ $fieldName }}[]" id="" multiple multiselect-search="true" style="width: 100%">--}}
{{--                @foreach(\App\Models\ProductCategory::where('parent_id', null)->get() as $category)--}}
{{--                    <option data-group-id="{{$category['id']}}" value="{{$category['id']}}">{{$category['title']}}</option>--}}
{{--                    @foreach(\App\Models\ProductCategory::where('parent_id', $category['id'])->get() as $subCat)--}}
{{--                        <option data-select="{{$category['id']}}" data-value="{{$subCat['id']}}" value="{{$subCat['id']}}">{{$subCat['title']}}</option>--}}
{{--                    @endforeach--}}
{{--                @endforeach--}}
{{--            </select>--}}
{{--        </div>--}}
{{--    @endif--}}
@endsection
