<?php

namespace App\Shared\Contracts\Tabs;

use App\Shared\DTO\TabManager\TabDTO;

interface RepositoryInterface
{
    /**
     * Определение type id сущности, в которой добавляется таб
     * @return int
     */
    public static function getTypeId(): int;

    /**
     * Определение массива табов для добавления
     * @return TabDTO[]
     */
    public static function getTabs(): array;
}