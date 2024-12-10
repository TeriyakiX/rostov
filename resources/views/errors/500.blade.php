<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ошибка {{ $status ?? 500 }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            padding: 50px;
            background-color: #f8f9fa;
        }
        h1 {
            color: #dc3545;
            font-size: 48px;
        }
        p {
            font-size: 18px;
            color: #6c757d;
        }
        a {
            text-decoration: none;
            color: #007bff;
            font-weight: bold;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
<h1>Ошибка {{ $status ?? 500 }}</h1>
<p>Что-то пошло не так. Мы работаем над решением проблемы.</p>
<p><a href="{{ url('/categoryList/krovlya') }}">Перейти в каталог товаров</a></p>
</body>
</html>
