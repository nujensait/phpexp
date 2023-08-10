<?php
/**
 * Клиентский код получает удобный интерфейс для построения сложных древовидных
 * структур.
 */
function getProductForm(): FormElement
{
    $form = new Form('product', "Add product", "/product/add");
    $form->add(new Input('name', "Name", 'text'));
    $form->add(new Input('description', "Description", 'text'));

    $picture = new Fieldset('photo', "Product photo");
    $picture->add(new Input('caption', "Caption", 'text'));
    $picture->add(new Input('image', "Image", 'file'));
    $form->add($picture);

    return $form;
}

/**
 * Структура формы может быть заполнена данными из разных источников. Клиент не
 * должен проходить через все поля формы, чтобы назначить данные различным
 * полям, так как форма сама может справиться с этим.
 */
function loadProductData(FormElement $form)
{
    $data = [
        'name' => 'Apple MacBook',
        'description' => 'A decent laptop.',
        'photo' => [
            'caption' => 'Front photo.',
            'image' => 'photo1.png',
        ],
    ];

    $form->setData($data);
}

/**
 * Клиентский код может работать с элементами формы, используя абстрактный
 * интерфейс. Таким образом, не имеет значения, работает ли клиент с простым
 * компонентом или сложным составным деревом.
 */
function renderProduct(FormElement $form)
{
    // ..

    echo $form->render();

    // ..
}

$form = getProductForm();
loadProductData($form);
renderProduct($form);

/* вывод
<form action="/product/add">
<h3>Add product</h3>
<label for="name">Name</label>
<input name="name" type="text" value="Apple MacBook">
<label for="description">Description</label>
<input name="description" type="text" value="A decent laptop.">
<fieldset><legend>Product photo</legend>
<label for="caption">Caption</label>
<input name="caption" type="text" value="Front photo.">
<label for="image">Image</label>
<input name="image" type="file" value="photo1.png">
</fieldset>
</form>
*/