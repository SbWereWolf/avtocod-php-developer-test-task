<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <link
        rel="stylesheet" type="text/css"
        href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
        integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u"
        crossorigin="anonymous"/>

    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <style type="text/css">
        .user-avatar {
            margin-top: 5px;
            width: 100%;
        }

        .wall-message {
            border: solid #eee;
            border-width: 0 0 1px 0;
            margin-bottom: 1em;
        }

        .wall-message:last-child {
            border-width: 0;
        }
    </style>

    <title>Стена сообщений | Главная страница</title>
</head>
<body>

<nav class="navbar navbar-default">
    <div class="container">
        @include('messages.partial.title')
        <?php use App\BusinessLogic\Css;$main = Css::ACTIVE; ?>
        @include('messages.partial.site-menu')
        @include('messages.partial.username')
    </div>
</nav>

<!-- Begin page content -->
<div class="container">
    <div class="page-header">
        <h1>Сообщения от всех пользователей</h1>
    </div>

    <form action="/message/store" method="post"
          class="form-horizontal {{$forUser}}">
        <h2 class="form-signin-heading">Написать сообщение</h2>

        @include('messages.partial.form-errors')

        <div class="controls">
            <div class="col-md-12">
                <div class="form-group">
                    <label for="message_text">Текст сообщения:</label>
                    <textarea id="message_text" name="content"
                              class="form-control"
                              placeholder="Ваше сообщение" rows="4"
                              required="required"></textarea>
                </div>
            </div>
            <div class="col-md-12 text-right">
                <input type="submit" class="btn btn-success btn-send"
                       value="Отправить сообщение"/>
            </div>

            {{ csrf_field() }}
        </div>
    </form>

    @include('messages.partial.message-wall')

</div>

<script
    type="text/javascript"
    src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js">

</script>
<script
    type="text/javascript"
    src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"
    integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa"
    crossorigin="anonymous"></script>

</body>
</html>
