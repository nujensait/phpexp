### ЧТО ЭТО?

Тестовое задание от компании Leads, рамках собеседования на позицию "php разработчик".

**Дата:** 2023-05-23

### Задача

Провести код-ревью разработанного микросервиса.

(*) Код лежит в папке ``./src``, описание - в файле ``Тестовое задание - ревью кода.docx``

### Решение

_Ниже - мои замечания по представленному коду._

(*) В начале указан ``файл`` и через пробел - номер строки, где есть замечание.

---

**Общее**
- не хатает указания типов аттрибутов, аргументов методов и т.п. - если код написан на версии php 7.4+
- можно также использовать ``strict_types``, для большей надежности (меньше будет ошибок)
- можно использовать Doctrine
- vиграции лучше делать через механизмы фреймворка или библиотеку для миграции (на php, методы up/down)
 
**init.sql**

``/src/migrations/init.sql 2``
- поле ``id`` можно сделать целочисленым авто-инкрементным (вместо вычисляемого в php)

``/src/migrations/init.sql 3``
- поле ``sum`` лучше сделать float и null по умолчанию

``/src/migrations/init.sql 4``
- тип smallint лучше поправить на bigint (т.к. контрагентов может быть много, в будущем)

``/src/migrations/init.sql 11``
- внеший ключ должен быть целочисленным, в нашем случае - INT (но лучше BIGINT), если поправим тип ``orders.id``

``/src/migrations/init.sql 12``
- тип лучше также BIGINT, т.к. продуктов может быть много

``/src/migrations/init.sql 13``
- для цены лучше использовать тип - ``float``, ``default NULL`` (т.к. есть разница между не заданной и нулевой ценой)

``/src/migrations/init.sql 14``
- quantity - лучше ``default 0`` 

``/src/migrations/init.sql 15``
- если жесткое удаление, то нужно вместо ``ON DELETE SET NULL`` - использовать ``ON DELETE CASCADE``
- если мягкое удаление, то в ``Orders`` и в ``Items`` запись помечается ``id_deleted=1`` (создается доп. поле - is_deleted)

**OrderConroller.php**

``/src/Controller/OrderController.php 42``
- здесь можно избавиться от if, воспользовавшись принципом полиморфизма:
```php 
$order->save();
$resp = new RedirectResponse($order->getUrl());
return $resp;
```
- где внутри метода ``save``
также не будет if, если заведем доп. класс: ``OrderLegal exatend Order``,
где уже пропишем свой обработчик для метода save, getUrl и др.
- т.е. метод ``save`` правильнее сделать абстрактным и наследуемым

``/src/Controller/OrderController.php 63``
- см. пред пункт: здесь также можем в класс ``Order, OrderLogal``
добавить метод ``finishActions()``, куда перенести доп. действия по работе с заказом
(если таковые есть), избавляемся т.о. от ``if``

**Item.php**

``/src/Entity/Item.php 8``
- видимость можно сделать ``private``, вместо ``protected``
(т.к. сейчас нет нследников, если будут - видимость расширить до protected)

``/src/Entity/Item.php 7-20``
- указаны неверные типы данных в комментариях, типы можно указать в коде явно, примерно так:
```php
    /** @var int */
    protected int $id;

    /** @var int */
    protected int $orderId;

    /** @var int */
    protected int $productId;

    /** @var float */
    protected float $price;

    /** @var int */
    protected int $quantity;
``` 
(*) да, для цены лучше использовать тип float, а не int

``/src/Entity/Item.php 80``
- возвращается self, это не нужно, т.е.строчка return лишняя, достаточно так: 
```php
    public function setProductId(int $productId): void
    {
        $this->productId = $productId;
    }
``` 

**Order.php**

``/src/Entity/Order.php 44``
- адрес API лучше вынести в конфиг (а не статикой в коде)

``/src/Entity/Order.php 52``
- нарушение принципа "Single reponsibility": вызов генератора надо вынести в отдельный класс

``/src/Entity/Order.php 62`` 
- следует убрать логику (if) в методе, заменить на вызов полиморфного метода

**OrderFactory.php**

``/src/Factory/OrderFactory.php 22``
- для генерации ИД заказа достаточно использовать PrimaryKey , генерируемый автоинкрементно (~в MySQL) или через sequence (~в Postgres)

``/src/Factory/OrderFactory.php 24``
- ошибка в назваии таблиы: ``FROM order1s`` , д.б. ``orders`` и лучше кранировать сущности, т.е.:
  SELECT `id` FROM `orders` ORDER BY `createdAt` DESC LIMIT 1
- общее: вместо native sql здесь и везде лучше использовать Doctrine
- есть риск генерации неуникального ключа (дублирующегося), при одновременном создании двух заказов
- (можно добавить рандомную составляющую в ключ, либо метку/хеш от тек времени в ms и т.п.)

``/src/Factory/OrderFactory.php 34``
- Лучше абстрагироваться от структуры json-reposnse , т.е. не использовать конструкция вида:
```php
        foreach ($data as $key => $value)
        {
            if ($key == 'items')
```
- а использовать новый метод (создать его):
```
$items = $orderData->getItems();
```
- добавление продуктов в заказ тоже лучше вынести в отдельный метод:
```php
$order->setItems($items);
```
- проверять наличие продуктов в заказе можно иначе:
```
if(isset($data['items'])) { ...
``` 

``/src/Factory/OrderFactory.php 41``
- надо использовать методы-сеттеры вместо обращений ``$order->{$key} = $value;`` (будет ошиба, они же не ``public``)

**OrderRepository.php**

``/src/Repository/OrderRepository.php 20``
- вместо SQL, использовать ORM для сохранения сущностей (здесь и везде)
- но если уж га SQL, то нужно проверять успешность вставки данных в БД

``/src/Repository/OrderRepository.php 26``
- нужно добавить транзакции, чтобы добавленные в заказ товары случайно не потерялись при создаии заказа
- предполагается, что safe-подстановка аргументов в запрос будет в ``prepare``, но здесь аргументы подставляются в сам запрос
  (что не безопасно, возможны sql-инъекции) 

``/src/Repository/OrderRepository.php 36``
- через Doctrine было бы короче (вместо строк 38-45):
```php
$order = $doctrine->getRepository(Order::class)->find($id);
```

``/src/Repository/OrderRepository.php 52``
- короче будет с Doctrine:
```php
$repo = $this->getDoctrine()->getRepository(Order::class);
$orders = $repo->findBy(array(), array('createdAt' => 'DESC'), $limit);
```

``/src/Repository/OrderRepository.php 61``
- нужно использование сеттеров вместо присвоения значений аттрибутам

``/src/Repository/OrderRepository.php 64``
- данные подгружаются в цикле, что порождает N подзапросов, вместо этого лучше использовать один запрос к БД, 
с подгрузкой всех зависимых данных

``/src/Repository/OrderRepository.php 70``
- см. пункт выше - выборка удобне через Doctrine
 