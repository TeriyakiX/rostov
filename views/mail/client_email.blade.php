@component('mail::message')
<h2>Заказ № {{$order}}</h2>
<h2>Почта пользователя: {{$address}}</h2>

Cообщение: {{$body}}

@endcomponent
