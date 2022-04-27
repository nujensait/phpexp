<?php
/**
 * Клиентский код может быть частью реального веб-сайта, который отображает
 * создаваемый пользователями контент. Поскольку он работает с модулями
 * форматирования через интерфейс компонента, ему всё равно, получает ли он
 * простой объект компонента или обёрнутый.
 */
function displayCommentAsAWebsite(InputFormat $format, string $text)
{
    // ..

    echo $format->formatText($text);

    // ..
}

/**
 * Декоратор позволяет складывать несколько входных форматов для получения
 * точного контроля над отображаемым содержимым.
 */
$dangerousForumPost = <<<HERE
# Welcome

This is my first post on this **gorgeous** forum.

<script src="http://www.iwillhackyou.com/script.js">
  performXSSAttack();
</script>
HERE;

/**
 * Наивное отображение сообщений (небезопасное, без форматирования).
 */
$naiveInput = new TextInput;
echo "Website renders a forum post without filtering and formatting (unsafe, ugly):\n";
displayCommentAsAWebsite($naiveInput, $dangerousForumPost);
echo "\n\n\n";

/**
 * Форматтер Markdown + фильтрация опасных тегов (безопасно, красиво).
 */
$text = new TextInput();
$markdown = new MarkdownFormat($text);
$filteredInput = new DangerousHTMLTagsFilter($markdown);
echo "Website renders a forum post after translating markdown markup" .
    "and filtering some dangerous HTML tags and attributes (safe, pretty):\n";
displayCommentAsAWebsite($filteredInput, $dangerousForumPost);
echo "\n\n\n";