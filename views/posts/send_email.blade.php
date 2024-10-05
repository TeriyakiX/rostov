<p>Имя пользователя: {{ request()->get('username') ?? Auth::user()->name ?? 'Нет имени' }} </p>

@if(Auth::user())
<p>E-mail пользователя: {{ Auth::user()->email }} </p>
@endif

@if(request()->has('address'))
    <p>Адрес доставки: {{request()->get('address') }} </p>
@endif

<p>Номер телефона: {{request()->get('phone_number')}} </p>

<p>Комментарий к заказу: {{request()->get('customer_comment')}} </p>






