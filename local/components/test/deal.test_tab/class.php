<?php

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}

use Bitrix\Main\Engine\Contract\Controllerable;

/**
 * Класс компонента-примера работы сервиса
 */
class TestDealComponent extends CBitrixComponent implements Controllerable
{
    public function configureActions(): array
    {
        return [];
    }

    public function executeComponent(): void
    {
        $this->includeComponentTemplate();
    }
}
