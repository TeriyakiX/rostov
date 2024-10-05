<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
<style>
    table {
        font-family: arial, sans-serif;
        border-collapse: collapse;
        width: 100%;
    }

    .rus{
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
<div style="display: flex; justify-content: space-between">
    <img src="http://mkrostov.ru/img/logo.webp" alt="mkrostov.ru logo" style="width: 100px; height: 100px">
    <div style="margin-bottom: 0">
        Факт. Адр.: Россия 344041, г. Ростов-на-Дону,<br>
        ул. Доватора 144/13, оф.2;<br>
        телефон: 8(863) 219-35-23; 311-46-60;<br>
        ИНН: 6168056526;  ОГРН: 1116194006444,;<br>
        E-mail: mk-rostov@mail.ru<br>
        Сайт: http://металлкровля.рф
    </div>
</div>
<div style="border-top: 1px dashed black; border-bottom: 1px dashed black; margin: 10px 0">
    <p style="font-size: 17px; margin: 0; text-align: center">кровли, фасады, заборы, сэндвич-панели, террасная доска, поликарбонат, изоляция, уплотнители</p>
</div>
<h2 style="text-align: center">Коммерческое предложение</h2>
<table style="width: 100%;border:1px solid #ccc">
@foreach($orders as $order)
    <tr>
        <th>Имя</th>
        <th>Опции</th>
        <th>Цена</th>
    </tr>
    <tr>
        <td class="rus">{{$order->getProduct()->title}}</td>
        <td class="rus">{{$order->getOptionsText()}}</td>
        <td>{{$order->getTotalPrice()}}₽</td>
    </tr>

@endforeach
</table>
</body>
<script>
    window.print()
</script>
</html>
