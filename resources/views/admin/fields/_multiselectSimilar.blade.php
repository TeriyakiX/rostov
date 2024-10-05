@extends('admin.fields.container')
@section('field')
    <div class="form-group">

        <label for="{{ $fieldName }}" style="margin-bottom:20px;">{{ $fieldData['title'] }}</label>
        <div id="multiselectSimilar" data-product="{{ isset($item) ? $item->id : 0 }}">
            <select style="display:none" name="{{ $fieldName }}[]" multiple placeholder="Select">
            </select>
        </div>
    </div>
    @php

    if(empty($item)){
    $id_item = 0;
}else{
    $id_item = $item->id;
}


    @endphp
    <div class="form-group" id="sortSimilar">
        @foreach(App\Models\SimilarProducts::where('product_id',$id_item)->join('products','similar_product_id','id')->get()  as $val)

            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text" style="white-space: nowrap;overflow:hidden;text-overflow: ellipsis;max-width: 450px;min-width: 450px;">{{$val->title}}</span>
                </div>

                <input type="number" class="form-control " name="similarSort[{{$val->similar_product_id}}][]" value="{{$val->simSort}}"
                       placeholder="номер сортировки">


            </div>

        @endforeach
    </div>

@endsection

