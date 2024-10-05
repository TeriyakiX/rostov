<p>Имя пользователя: {{$name}} </p>
<p>Номер телефона: {{$phoneNumber}} </p>
<div>{!!  $vendorCode !!} </div>
<p>Способ доставки:{{$deliveryMethod}} </p>
@if($address!==null)
    <p>Адрес доставки:{{$address}}</p>
@endif
