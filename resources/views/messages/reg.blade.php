<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
          integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u"
          crossorigin="anonymous" />

    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <style type="text/css">
        .form-signup {
            max-width: 330px;
            padding: 15px;
            margin: 0 auto;
        }
        .form-signup .form-signup-heading {
            margin-bottom: 10px;
        }
        .form-signup .form-control {
            position: relative;
            height: auto;
            -webkit-box-sizing: border-box;
            -moz-box-sizing: border-box;
            box-sizing: border-box;
            padding: 10px;
            font-size: 16px;
        }
        .form-signup .form-control:focus {
            z-index: 2;
        }
        .form-signup input#user_login {
            margin-bottom: -1px;
            border-bottom-right-radius: 0;
            border-bottom-left-radius: 0;
        }
        .form-signup input#user_password {
            margin-bottom: -1px;
            border-radius: 0;
        }
        .form-signup input#user_password_repeat {
            margin-bottom: 10px;
            border-top-left-radius: 0;
            border-top-right-radius: 0;
        }
    </style>

    <title>Стена сообщений | Регистрация</title>
</head>
<body>

<nav class="navbar navbar-default">
    <div class="container">
        @include('messages.partial.title')
        <?php use App\BusinessLogic\Css;$reg = Css::ACTIVE; ?>
        @include('messages.partial.site-menu')
        @include('messages.partial.username')
    </div>
</nav>

<div class="container">

    <form class="form-signup" action="reg" method="POST">
        <h2 class="form-signup-heading">Регистрация</h2>

        @include('messages.partial.form-errors')

        <label for="user_login" class="sr-only">Логин</label>
        <input type="text" id="user_login" name ="name" class="form-control" placeholder="Логин" required autofocus>

        <label for="user_password" class="sr-only">Пароль</label>
        <input type="password" id="user_password" name="password" class="form-control" placeholder="Пароль" required>

        <label for="user_password_repeat" class="sr-only">Повторите пароль</label>
        <input type="password" id="user_password_repeat" name ="password_confirmation" class="form-control" placeholder="Пароль (ещё раз)" required>

        <button class="btn btn-lg btn-primary btn-block" type="submit">Зарегистрироваться</button>

        {{ csrf_field() }}
    </form>

</div>

<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"
        integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa"
        crossorigin="anonymous"></script>

</body>
</html>