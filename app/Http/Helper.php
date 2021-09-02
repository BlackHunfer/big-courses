<?php

namespace App\Http;

class Helper
{

    protected static $typeMaterialIds = [
        0 => 'Теоритический урок',
        1 => 'Видео',
        2 => 'Файл',
        3 => 'Тест',
        4 => 'Задание с ручной проверкой',
    ];
    public static function typeMaterialIdToStr($typeId)
    {
        return self::$typeMaterialIds[$typeId] ?? "id: $typeId";
    }

    protected static $opensMaterialIds = [
        0 => 'Доступ открыт всегда',
        1 => 'Доступ открывается в последовательном режиме',
        2 => 'Доступ открывается по расписанию',
    ];
    public static function opensMaterialIdToStr($opensId)
    {
        return self::$opensMaterialIds[$opensId] ?? "id: $opensId";
    }

}