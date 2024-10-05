@foreach($subcategories as $subcategory)
    <ul>
        <li>{{$subcategory->name}}</li>
        @if(count($subcategory->subcategory))
            @include('product.subCategoryList',['subcategories' => $subcategory->subcategory])
        @endif
    </ul>
@endforeach