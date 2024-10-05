<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <style>
        table {
            font-family: arial, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        .rus {
            font-family: "DejaVu Sans", sans-serif;
        }

        td, th {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }

        tr:nth-child(even) {
            background-color: #dddddd;
        }
    </style>
</head>
<body>
<table style="border: 0px">
<tr>
     <td style="border: 0px"><img src="http://mkrostov.ru/img/logo.webp" alt="mkrostov.ru logo" style="width: 100px; height: 100px"> </td>
     <td style="border: 0px"><div style="margin-bottom: 0; text-align:center">
        Адрес: 344041, г. Ростов-на-Дону,<br>
        ул. Доватора 144/13;<br>
        телефон: 8(863) 219-35-23; 311-46-60;<br>
        ИНН: 6168056526; ОГРН: 1116194006444,;<br>
        E-mail: mk-rostov@mail.ru<br>
        Сайт: https://mkrostov.ru
    </div></td>
	 <td style="border: 0px"><div><a href="http://mkrostov.ru/posts/oplata"> <img src="http://mkrostov.ru/img/qrcode.jpg" alt="" style="width: 100px; height: 100px"></a></div> </td>
</tr>
</table>
<div style="border-top: 1px solid blue; border-bottom: 1px solid blue; margin: 20px 0">
    <p style="font-size: 17px;margin: 0;text-align: center;text-transform: uppercase;padding: 15px 0;font-style: italic;color: blue;">кровли, фасады, заборы, террасная доска, поликарбонат, уплотнители</p>
</div>
<br /><br />
<h2 style="text-align:left">Благодарим за обращение</h2>
<p>
Заказ № {{$orders->id}} {{$orders->status}}
</p>
<p>
Вы можете отслеживать исполнение в личном кабинете
</p>
<p>
<a href="http://mkrostov.ru/auth/login" style="text-decoration:none;display:inline-block; padding:15px 20px; color: white; background-color:#026CE0; border-radius:3px;">Отследить заказ</a>
</p>
<br /><br />
<table style="width: 100%;border:1px solid #ccc">
    @foreach($orders->products()->get() as $order)

        @php $options=json_decode($order->pivot->options)
        @endphp

        <tr>
            <th>Имя</th>
            @if(isset($options->color))
            <th>Цвет</th>
            @endif
            @if (isset($options->length))
                <th>Длина</th>
            @endif
            @if(isset($options->quantity))
                <th>Количество</th>
            @endif
            @if(isset($options->totalSquare))
                <th>Общая площадь</th>
            @endif
            @if(isset($options->width))
            <th>Ширина</th>
            @endif
            <th>Цена</th>
            <th></th>
        </tr>
        <tr>
            <td class="rus">{{$order->title}}</td>
            @if(isset($options->color))
            <td class="rus">{{$options->color}}</td>
            @endif
            @if (isset($options->length))
            <td class="rus">{{$options->length}}мм</td>
            @endif
            @if(isset($options->quantity))
            <td class="rus">{{$options->quantity}}</td>
            @endif
            @if(isset($options->totalSquare))
            <td class="rus">{{$options->totalSquare}}м²</td>
            @endif
            @if(isset($options->width))
            <td class="rus">{{$options->width}}м</td>
            @endif
            <td>{{$options->totalPrice}}₽</td>
        </tr>
    @endforeach
</table>
<br /><br />
<h2>Обращаем Ваше внимание!</h2>
<ol>
<li>Обработка заказа может занять некоторое время; окончательная стоимость, количе-ство и состав товаров по заказу будут подтверждены после обработки заказа Постав-щиком по согласованию с Вами!</li>
<li>Оплата подтвержденного заказа (счета-спецификации) производится через сайт в раз-деле: «on-line оплата» или по реквизитам организации!</li>
<li>Оплата заказа означает согласие с условиями поставки товара, указанным ассорти-ментом, цветом, количеством и размерами. Товар отпускается по факту 100% прихода денежных средств на р/счет Поставщика!</li>
<li>Самовывоз Товара осуществляется по предварительному согласованию даты и вре-мени с указанного склада Поставщика!</li>
<li>Отгрузка Товара осуществляется механизированным способом в кузова автотранс-портных средств с открытым верхом и открывающимися бортами, кроме штучного товара небольшого количества. Автомашины, не соответствующие вышеуказанным требованиям, не обслуживаются по технике безопасности!</li>
<li>Доставка Товара с разгрузкой осуществляется автомашиной – манипулятор по пред-варительному согласованию, в остальных случаях без услуги разгрузки!</li>
<li>Срок действия цены 1 (один) рабочий день, срок поставки Товара может быть увели-чен соразмерно сроку внесения оплаты по заказу.</li>
</ol>
<br /><br />
<p style="text-align:center; font-size:17px;">Если возникли вопросы, будем рады вам помочь!</p>
<p style="text-align:center">
<a href="http://mkrostov.ru/posts/kontakty" style="text-decoration:none;display:inline-block; padding:15px 20px; color: white; background-color:#026CE0; border-radius:3px;">Связаться с нами</a>
</p>
</body>
<script>
    window.print()
</script>
</html>
