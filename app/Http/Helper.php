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
        0 => [
            'title' => 'Доступен всегда',
            'icon' => 'bi-clock',
        ],
        1 => [
            'title' => 'Открывается в последовательном режиме',
            'icon' => 'bi-list-nested',
        ],
        2 => [
            'title' => 'Открывается по расписанию',
            'icon' => 'bi-clock-history',
        ],
    ];

    public static function opensMaterialIds()
    {
        return self::$opensMaterialIds;
    }
    public static function opensMaterialIdToStr($opensId)
    {
        return self::$opensMaterialIds[$opensId] ?? "id: $opensId";
    }

}