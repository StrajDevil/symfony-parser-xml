# Парсер XML на Symfony
Получение, разбор и сохранение данных из XML-файла.
Для парсинга необходимо запустить команду с аргументом uri с указанием пути до XML-файла

## Запуск локального сервера:
При условии установленного SymfonyCLI: **symfony server:start**

## Команды для создание БД и таблиц
- БД: **php bin/console doctrine:database:create**
- Класс сущности: **php bin/console make:entity**
- Миграция: **php bin/console make:migration**
- Запуск миграции: **php bin/console doctrine:migrations:migrate**

## Команда для создания контроллера:
**php bin/console make:controller ProductController**

## Команда для консольных команд:
- Создание: **php bin/console make:command app:parser**
- Выполнение: **php bin/console app:parser http://127.0.0.1:8080/products.xml**

## Тестирование
- Создание тестовой БД: **php bin/console --env=test doctrine:database:create**
- Создание тестовых таблиц: **php bin/console --env=test doctrine:schema:create**
- Запуск тестов: **php bin/phpunit**
