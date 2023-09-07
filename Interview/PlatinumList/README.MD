# Что это?
Задачки с собеседования на должность "Senior full-stack PHP developer" 
в компанию [PlatinumList](https://dubai.platinumlist.net/careers/vacancy?id_vacancy=40)

## Задача 4: парсер ini файла

Написать на php парсер ini-файла где есть сабсекции внутри секций, пример ниже:

```
/*

Пример ввода: файл config.ini

foo=aaa

[bar]
baz = bbb

[bar/quux]
frob = ccc

Пример вывода:

[
    ‘foo’ => ‘aaa’,
    ‘bar’ => [
        ‘baz’ => ‘bbb’,
        ‘quux’ => [
            ‘frob’ => ‘ccc’,
        ],
    ],
]

*/

function parse(string $filename): array
{
}
```

### Решение
см. файл ``task4.php``

### Запуск
```
php task4.php
```

### Примечание
в файле ``task4_neuro.php`` - решение, сгенерированное нейронкой,
не рабочее (нужно доводить до ума), но идея с создание сабсекций взята оттуда (хитро!):
```
        if (strpos($key, '/') !== false) {
            $path = explode('/', $key);
            $subsec = &$data;
            foreach ($path as $k) {
                $subsec = &$subsec[$k];
            }
            $subsec = $value;
        } else {
```