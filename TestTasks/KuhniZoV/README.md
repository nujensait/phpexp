==============================================================================

# Тестовое задание "Кухни Зов" 

(*) Вакансия: https://hh.ru/vacancy/66991770

1) Поднять на своём пк yii2-advanced: Getting Started: Installation
   https://www.yiiframework.com/extension/yiisoft/yii2-app-advanced/doc/guide/2.0/en/start-installation

2) Запрограммировать модуль "Задачи", имеющий базовый CRUD функционал:
 
- а) Создание задачи
- б) Просмотр задачи
- в) Обновление задачи
- г) Удаление задачи

3) Задача должна иметь следующий список полей:

- а) Название задачи
- б) Описание задачи
- в) Статус задачи (создана, в работе, выполнена)
- г) Приоритет задачи (цифра от 1 до 5)
- д) Дата создания задачи

4) Весь список задач должен быть отображен в виде таблицы

5) Реализовать сортировку по приоритету и дате создания задачи

6) Над списком задач реализовать простой поиск по названию задачи

7) Внешний вид не важен

==============================================================================

# Инструкция по запуску:
* распаковать архив в пустую директорию веб-сервера (новый хост)
* создать БД zovdemo или прописать нужную в /common/config/mail-local.php
* перезапустить вебсервер
* запусть init.bat
* запусть yii.bat migrate
* открыть в браузере: http://zovdemo/backend/web/index.php?r=site%2Flogin
  login / password: admin / kbZvdHuUwF
* Открыть интерфейс со списком задач:
  http://zovdemo/backend/web/index.php?r=tasks%2Findex

==============================================================================
# Dev guide

Setup:
- download/setup sources:
```
composer create-project --prefer-dist yiisoft/yii2-app-advanced yii-application
```
- create mysql DB: 'zovdemo' (encoding: utf8_unicode)
- set proper DB setting in /common/config/mail-local.php:
``` 
  'db' => [
      'class' => 'yii\db\Connection',
      'dsn' => 'mysql:host=localhost;dbname=zovdemo',
      'username' => 'root',
      'password' => '',
      'charset' => 'utf8',
  ],
``` 
- init app:
``` 
init.bat
```
- run basic migrations:
``` 
yii.bat migrate
```

- login:
http://zovdemo/backend/web/index.php?r=site%2Flogin
* Demo login / password: admin / kbZvdHuUwF

- Test tasks CRUD:
http://zovdemo/backend/web/index.php?r=tasks%2Findex 

==============================================================================
# Resources

- Create tasks table
yii.bat migrate/create create_tasks_table

- create user:
yii.bat migrate/create create_user
@see https://stackoverflow.com/questions/57385784/yii2-how-to-add-users-manually

- generate CRUD via Gii:
http://zovdemo/yii-application/backend/web/index.php?r=gii

- Check:
http://zovdemo/yii-application/backend/web/index.php?r=tasks%2Findex

- Auto-update created_at/updated_at:
https://qna.habr.com/q/395557

- Sorting in list:
https://stackoverflow.com/questions/27463817/how-to-enable-and-disable-sort-in-yii2-gridview
