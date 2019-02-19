<p align="center">
    <a href="https://github.com/yiisoft" target="_blank">
        <img src="https://avatars0.githubusercontent.com/u/993323" height="100px">
    </a>
    <h1 align="center">Yii 2 Project</h1>
    <br>
</p>

Установка
-------------------

1. Клонируем репозиторий
2. Вносим настройки подключения к БД в файл config/db.php. Поумолчанию используется MySQL.
3. В корне проекта запускаем deploy.sh
 - скрипт скачивает зависимости
 - устанавливает нужные права на папки
 - запускает миграции

-------------------

- Для запуска команды обновления используем команду "php yii service -c=update"
- Для доступа к методам API используем заголовок "Authorization: Bearer Dh9CZpUaayTO8pLEm2MDeMpBX4WPcNlJ"

Доступные методы:
GET /currencies (для пагинации используем ?page=номер_страницы)
GET /currency/:id