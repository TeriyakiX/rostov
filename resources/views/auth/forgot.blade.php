<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>МК - Вход на сайт</title>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('admin/assets/css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/vendors/bootstrap-icons/bootstrap-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/css/pages/auth.css') }}">
</head>

<body>
<div id="auth">

    <div class="row h-100">
        <div class="col-lg-5 col-12">
            <div id="auth-left">
                <div class="auth-logo">
                    <a href="{{ route('index.home') }}">
                        <img src="{{ asset('img/logo.png') }}" alt="">
                    </a>
                </div>
                <h1 style="font-size: 3rem" class="auth-title">Восстановление пароля</h1>

                <form action="{{ route('auth.forgot') }}" method="POST">
                    {{ csrf_field() }}

                    @if($errors->any())
                        @foreach ($errors->all() as $error)
                            <div style="color: red">{{$error}}</div>
                        @endforeach
                    @endif

                    <div class="form-group position-relative has-icon-left mb-4">
                        <input required type="email" name="email" class="form-control form-control-xl" placeholder="Email" value="{{ old('email') ? old('email') : '' }}">
                        <div class="form-control-icon">
                            <i class="bi bi-envelope"></i>
                        </div>
                    </div>

                   <div>
                       <p>На указаную почту придет сообщение с дальнейшими указаниями по восстановлению пароля</p>
                   </div>

                    <button class="btn btn-primary btn-block btn-lg shadow-lg mt-5">Отправить</button>
                </form>

            </div>
        </div>
        <div class="col-lg-7 d-none d-lg-block">
            <div id="auth-right">

            </div>
        </div>
    </div>

</div>
</body>

</html>
