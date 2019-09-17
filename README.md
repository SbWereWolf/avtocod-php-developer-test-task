<p align="center">
  <img alt="avtocod" src="https://avatars1.githubusercontent.com/u/32733112?s=70&v=4" width="70" height="70" />
</p>

# Тестовое задание для PHP-разработчика
Необходимо с использованием фреймворка `Laravel` реализовать сервис "Стена сообщений".
## Описание необходимого функционала
### Главная страница
Содержит список всех сообщений. Сортировка - снизу-вверх _(последнее добавленное сообщение - сверху)_. У каждого сообщения, помимо текста, указано имя (username) автора и опционально - аватар (используя API сервиса `gravatar`, например).

Если пользователь авторизован, ему становится доступна форма отправки сообщения.

Сообщение не может быть пустым (или состоять только из пробелов). При попытке отправки такого сообщения - пользователю выдается предупреждение "Сообщение не может быть пустым".

После успешной отправки, сообщение пользователя сразу появляется на "стене".

Авторизованный пользователь может также удалять свои сообщения.
### Авторизация
В случае неуспешной авторизации, пользователю выводится сообщение "Вход в систему с указанными данными невозможен".
### Регистрация
Требования к логину и паролю пользователя могут быть следующие:

- Логин - только альфа-символы (`a-z`) (в любом регистре) + возможно цифры (`0-9`), минимальная длинна - 8 символов;
- Пароль - обязательно символы в верхнем и нижнем регистрах + цифры, минимальная длинна - 6 символов.

В случае не успешной регистрации, каждое некорректно заполненное поле должно быть снабжено сообщением об ошибке.
### Главное меню (сверху)
- Пункт “Главная” - ведет на главную страницу, показывается всегда;
- Пункты “Авторизация” и “Регистрация” показываются только не авторизованным пользователям.

Блок справа показывается только авторизованному пользователю. Содержит Имя пользователя и ссылку "Выход", нажав на которую, пользователь выходит из - под своей учетной записи.
> Плюсом будет реализация возможности указания для определенных учётных записей прав "администратора" (`is_admin`), дающие возможность удалять чужие сообщения.
### Вёрстка
HTML-верстка находится в директории `./storage/markup` (bootstrap) - именно её необходимо использовать. Опционально можете сверстать свои представления.
## Требования к используемым технологиям
Задание должно быть:

- Выполнено с использованием PHP фреймворка `Laravel` версии не ниже `5.5`;
- БД - `sqlite3`, `PostgreSQL`;
- Redis, Memcached - опционально, по желанию;
## Требования к реализации
- Разрешено использовать любые сторонние composer-пакеты;
- Все реализуемые методы должны иметь корректный phpdoc-комментарий (описание на русском языке, `@params`, `@return`);
- Для проверки передаваемых приложению по HTTP данных использовать валидацию входящих запросов (`artisan make:request ...`);
- База данных должна создаваться с помощью миграций (никаких sql-файлов);
- База данных должна наполняться фейковыми записями с помощью механизма сидов;
- Для всего реализованного функционала должны быть написаны Unit-тесты (`phpunit`);
- После завершения работы в **данном** readme-файле описать все действия, необходимые для запуска приложения _(текущее содержание можно удалить)_ с опциональными комментариями по решению задания.
## Плюсами будут являться
- Интуитивно-понятное разбитие коммитов - одной конкретной задаче - один коммит (её правки - отдельный коммит);
- Текст коммитов - на английском языке;
- Написание `docker-compose.yml`, который запускает написанное приложение.
## Результат выполнения
Ссылку на репозиторий с вашей реализацией необходимо отправить нашему HR или TeamLead, от которого вы получили ссылку на данный репозиторий.
# Отчёт о работе
##Что было сделано:
- реализованы миграции базы данных
- реализован функционал для создания набора данных
- реализована бизнес логика просмотра, добавления и удаления сообщений
- реализован требуемый функционал сообщений об ошибках
- реализован функционал роли Администратора
 (расширенные права при удалении сообщений)
- написаны минимальные тесты на бизнес логику
- классы и методы снабжены минимальным описанием в комментариях
## Что не сделано:
- сообщения об ошибках выводят в отдельной области, 
но не указывают на поле в котором произошла ошибка,
- разработана фабрика для валидаторов, 
но валидация не вынесена в отдельные классы 
команда ``artisan make:request`` не была использована 
(я сделал основную часть функционала и стал смотреть дополнительные 
опции по заданию и увидел это требование, для его выполнения необходимо 
переделать роутинг и не много контроллеры, но мотивации уже нет, 
**а ВДРУГ всё не так просто и вместо 30 минут уйдёт 60 ? страшно страшно**)
#Особое мнение
Задание во много на знание фреймворка Laravel, чем на программирование, 
собственно программирования на пару часов, 
а дальше читаешь доку по Ларавелю и копипастишь СтекОверФлоу, скучно.
## Что было занятного
Относительно интересно было с шаблонами и CSS, 
во первых, разбить на стандартные области, 
во вторых, **показать** то что надо и **не показать** то что не надо.

Заморочка с миграциями : с тем что из таблицы надо удалить всё записи
( колонка ``email`` в ``users`` лишняя и я её удалил, 
но видимо в продакшене пришлось бы её оставить,
 просто выпилить использование в коде).
 
 Заморочка с Композером : его скрипты заточены под *nix 
 и на win не работают, хорошо что там нет ни чего критичного, 
 кроме того команда ``composer test`` зашита в пакет 
 и в принципе не имеет смысл переделывать её под win,
 потому что сохранить в репозитории я её не смогу.

Конфиг тестов ``phpunit.xml`` я переделал, это максимум возможного.
## Итог
Laravel удобная штука ! Пользуйтесь Laravel.
