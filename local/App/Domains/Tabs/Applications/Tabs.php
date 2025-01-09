<?php

namespace App\Domains\Tabs\Applications;

use App\Shared\Contracts\Tabs\RepositoryInterface;
use App\Shared\DTO\TabManager\TabDTO;
use Bitrix\Crm\Model\Dynamic\TypeTable;

class Tabs implements RepositoryInterface
{

    public static function getTypeId(): int
    {
        //Получаем ENTITY_TYPE_ID смарт-процесса "Заявки"
        return (int)TypeTable::getList([
            'filter' => [
                'CODE' => 'APPLICATIONS'
            ]
        ])->fetchRaw()['ENTITY_TYPE_ID'];
    }

    public static function getTabs(): array
    {
        return [
            new TabDTO(
                'dynamic_test_tab',
                'Тестовый таб заявок',
                'test:dynamic.test_tab'
            ),
        ];
    }
}