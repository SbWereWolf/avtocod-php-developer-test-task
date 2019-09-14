<ul class="nav navbar-nav">
    @if(!isset($main)) <?php $main = '';?> @endif
    @if(!isset($login)) <?php $login = '';?> @endif
    @if(!isset($reg)) <?php $reg = '';?> @endif
    <li class="{{$main}}"><a href="/">Главная</a></li>
    <li class="{{$login}} {{$forGuest}}"><a href="login">Авторизация</a>
    </li>
    <li class="{{$reg}} {{$forGuest}}"><a href="reg">Регистрация</a>
    </li>
</ul>
