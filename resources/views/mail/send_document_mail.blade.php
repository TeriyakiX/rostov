<!DOCTYPE html>
<html>
<head>
    <title>mkrostov.ru</title>
</head>
<body>

@if($typeOfRequest!=='')
    <p>{{$typeOfRequest}}</p>
@endif
@if($link!=='')
    <p>Ссылка: {{$link}}</p>
@endif
@if($name!=='')

    <p>Имя пользователя: {{$name}}</p>
@endif
@if($phone!=='')
    <p>Телефон: {{ $phone }}</p>
@endif
@if($email!=='')
    <p>Электронная почта: {{ $email }}</p>
@endif
@if($documentName!=='')
    <p>Название документа: {{$documentName}}</p>
@endif
</body>
</html>
