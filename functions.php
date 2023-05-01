<?php
function can_upload($file)
{
    // если имя пустое, значит файл не выбран
    if ($file['name'] == '')
        return 'Вы не выбрали файл.';

    /* если размер файла 0, значит его не пропустили настройки 
	сервера из-за того, что он слишком большой */
    if ($file['size'] == 0)
        return 'Файл слишком большой.';

    // разбиваем имя файла по точке и получаем массив
    $getMime = explode('.', $file['name']);
    // нас интересует последний элемент массива - расширение
    $mime = strtolower(end($getMime));
    // объявим массив допустимых расширений
    $types = array('jpg', 'png', 'gif', 'bmp', 'jpeg');

    // если расширение не входит в список допустимых - return
    if (!in_array($mime, $types))
        return 'Недопустимый тип файла.';

    return true;
}

function make_upload($file)
{
    $getMime = explode('.', $file['name']);
    $mime = strtolower(end($getMime));

    //проверяем существует ли такое имя
    do {
        $fname = uniqid();
        $file1 = 'images/' . $fname;
    } while (file_exists($file1));
    // формируем уникальное имя картинки: случайное число и name
    $name = $file1 . '.' . $mime;
    copy($file['tmp_name'],   $name);
    return ($file1 . '.' . $mime);
}
