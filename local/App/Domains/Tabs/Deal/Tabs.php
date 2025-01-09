<?php

namespace App\Domains\Tabs\Deal;

use App\Shared\Contracts\Tabs\RepositoryInterface;
use App\Shared\DTO\TabManager\TabDTO;
use CCrmOwnerType;

/**
 * Класс-пример для определения табов
 */
class Tabs implements RepositoryInterface
{
    /**
     * Метод возвращает идентификатор типа сущности, в которую добавляется таб
     * @return int
     */
    public static function getTypeId(): int
    {
        return CCrmOwnerType::Deal;
    }

    /**
     * Метод возвращает массив объектов табов сущности
     * @return TabDTO[]
     */
    public static function getTabs(): array
    {
        return [
            new TabDTO(
                'test_tab',
                'Тестовый таб',
                'test:deal.test_tab'
            ),
        ];
    }
}