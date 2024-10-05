<p>{{request()->get('typeOfRequest')}}
<p>Ссылка: {{request()->get('link') }} </p>
@if(request()->get('customer_comment') == null)
    <p>Имя пользователя: {{ request()->get('name') ?? Auth::user()->name ?? 'Нет имени' }} </p>

    <p>Номер телефона: {{request()->get('phone_number')}} </p>
@else
    <p>Имя пользователя: {{ request()->get('username') ?? Auth::user()->name ?? 'Нет имени' }} </p>

    @if(Auth::user())
        <p>E-mail пользователя: {{ Auth::user()->email }} </p>
    @endif

    @if(request()->has('address'))
        <p>Адрес доставки: {{request()->get('address') }} </p>
    @endif

    <p>Номер телефона: {{request()->get('phone_number')}} </p>

    <p>Комментарий к заказу: {{request()->get('customer_comment')}} </p>
@endif





