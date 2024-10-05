@extends('admin.fields.container')

@section('field')
@php   if( isset($item) && isset($item->$fieldName) ) {
   $time=date_format(date_create($item->$fieldName), 'Y-m-d');
}else{
    $time='';
}

@endphp
    <div class="form-group">
        <input type="hidden" value="0" name="{{ $fieldName }}">
        <input type="date" id="{{ $fieldName }}"
               name="{{ $fieldName }}" value="{{$time}}">
        <label for="{{ $fieldName }}">{{ $fieldData['title'] }}</label>
    </div>
@endsection
