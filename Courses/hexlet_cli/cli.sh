# Упражнения из модуля "Основы командной строки"
# https://ru.hexlet.io/courses/cli-basics/lessons/streams/exercise_unit

# Прочитайте в командной строке содержимое файла source и перенаправьте его в файл /tmp/result (которого не существует).
# Запишите получившуюся команду в файл solution.

cd /usr/src/app
cat source >/tmp/result
echo "cat source > /tmp/result" >solution

# Пайплайны
# Посредством конвейера отсортируйте содержимое файла languages в алфавитном порядке и выведите на экран только первые две строки.
# Запишите получившуюся команду в файл solution.
# Подсказки:
# - Взять первые две строки: head -n 2
# - Обратите внимание, что в файл solution надо записать саму команду, а не результат её выполнения
cat languages | sort | head -n 2
echo "cat languages | sort | head -n 2" > solution
# Решение учителя
sort languages | head -n 2


