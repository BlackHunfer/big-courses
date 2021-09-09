<?php

namespace App\Http;

class Helper
{

    protected static $typeMaterialIds = [
        0 => [
            'title' => 'Теоритический урок',
            'color' => 'bg-primary'
        ],
        1 => [
            'title' => 'Видео',
            'color' => 'bg-success'
        ],
        2 => [
            'title' => 'Файл',
            'color' => 'bg-warning text-dark'
        ],
        3 => [
            'title' => 'Тест',
            'color' => 'bg-info text-dark'
        ],
        4 => [
            'title' => 'Задание с ручной проверкой',
            'color' => 'bg-secondary'
        ],
    ];
    public static function typeMaterialIdToStr($typeId)
    {
        return self::$typeMaterialIds[$typeId] ?? "id: $typeId";
    }

    protected static $opensMaterialIds = [
        0 => [
            'title' => 'Доступен изначально',
            'icon' => 'bi-calendar-check',
        ],
        1 => [
            'title' => 'Открывается в последовательном режиме',
            'icon' => 'bi-list-nested',
        ],
        2 => [
            'title' => 'Открывается по расписанию',
            'icon' => 'bi-calendar-event',
        ],
        3 => [
            'title' => 'Открывается в последовательном режиме по расписанию',
            'icon' => 'bi-calendar-week',
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