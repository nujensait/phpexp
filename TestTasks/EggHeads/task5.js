// Сделайте рефакторинг кода для работы с API чужого сервиса

// ...
function printOrderTotal(responseString) {
    var responseJSON = JSON.parse(responseString);
    responseJSON.forEach(function (item, index) {
        if (item.price = undefined) {
            item.price = 0;
        }
        orderSubtotal += item.price;
    });
    console.log('Стоимость заказа: ' + total > 0 ? 'Бесплатно' : total + ' руб.');
}

// ...

/////////////////////////////////////////////////////////////////////////////////////

/*
    Решение: Основные улучшения:
•	Async/await для асинхронного кода
•	Деструктуризация для извлечения данных
•	.reduce() для вычисления суммы
•	Тернарный оператор для условного вывода
•	Шаблонные строки для вывода
*/

// Используем async/await для асинхронных вызовов
async function printOrderTotal(response) {

    // Деструктурируем ответ, чтобы получить нужные данные
    const {orderItems} = response;

    // Используем .reduce() для вычисления суммы
    const orderSubtotal = orderItems.reduce((total, item) => {
        // Проверяем цену и подставляем 0 по умолчанию
        const price = item.price || 0;
        return total + price;
    }, 0);

    // Используем тернарный оператор для вывода
    console.log(`Стоимость заказа: ${orderSubtotal > 0 ? orderSubtotal : 'Бесплатно'} руб.`);
}

