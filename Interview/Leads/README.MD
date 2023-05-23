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
- можно также использовать ``strict_types`` для надежности
 
**init.sql**

``/src/migrations/init.sql 1``
- Миграции лучше делать через механизмы фреймврока (на php, методы up/down)

**OrderConroller.php**

``/src/Controller/OrderController.php 42``
- здесь можно избавиться от if, воспользовавшись принципом полиморфизма:
``` 
$order->save();
$resp = new RedirectResponse($order->getUrl());
return $resp;
```
- где внутри метода ``save``
также не будет if, если заведем доп. класс: ``OrderLegal exatend Order``,
где уже пропишем свой обработчик для метода save, getUrl и др.

``/src/Controller/OrderController.php 63``
- см. пред пункт: здесь также можем в класс ``Order, OrderLogal``
добавить метод ``finishActions()``, куда перенести доп. действия по работе с заказом
(если таковые есть), избавляемся т.о. от ``if``

**Item.php**

``/src/Entity/Item.php 7-20``
- указаны неверные типы данных в комментариях, типы можно указать в коде явно, примерно так:
```
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

**OrderFactory.php**

``/src/Factory/OrderFactory.php 24``
- ошибка в назваии таблиы: ``FROM order1s`` , д.б. ``orders`` и лучше кранировать сущности, т.е.:
  SELECT `id` FROM `orders` ORDER BY `createdAt` DESC LIMIT 1
- Общее: вместо native sql здесь и везде лучше использовать Doctrine
- Есть риск генерации неуникального ключа (дублирующегося), при одновременном создании двух заказов
- (можно добавить рандомную составляющую в ключ, либо метку/хеш от тек времени в ms и т.п.)

``/src/Factory/OrderFactory.php 34``
- Лучше абстрагироваться от структуры json-reposnse , т.е. не использовать конструкция вида:
```
        foreach ($data as $key => $value)
        {
            if ($key == 'items')
```
- а использовать новый метод (создать его):
```
$items = $orderData->getItems();
```
- добавление продуктов в заказ тоже лучше выести в отдельный метод:
```
$order->setItems($items);
```

**OrderRepository.php**

``/src/Repository/OrderRepository.php 20``
- вместо SQL, использовать ORM для сохранения сущностей (здесь и везде)
- но если уж га SQL, то нужно проверять успешность вставки данных в БД

``/src/Repository/OrderRepository.php 26``
- Нужно добавить транзакции, чтобы добавленные в заказ товары случайно не потерялись при создаии заказа

``/src/Repository/OrderRepository.php 36``
- через Doctrine было бы короче (вместо строк 38-45):
``` 
$order = $doctrine->getRepository(Order::class)->find($id);
```

``/src/Repository/OrderRepository.php 52``
- Короче будет с Doctrine:
``` 
$repo = $this->getDoctrine()->getRepository(Order::class);
$orders = $repo->findBy(array(), array('createdAt' => 'DESC'), $limit);
```

``/src/Repository/OrderRepository.php 70``
- см. пункт выше - выборка удобне через Doctrine
 