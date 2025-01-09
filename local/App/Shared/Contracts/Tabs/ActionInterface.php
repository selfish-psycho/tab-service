<?php

namespace App\Shared\Contracts\Tabs;

use Bitrix\Main\Event;
use Bitrix\Main\EventResult;

interface ActionInterface
{
    /**
     * Добавление хендлера инициализации табов
     * @return void
     */
    public function initTabs(): void;

    /**
     * Определение подключаемых табов
     * @param Event $event
     * @return EventResult
     */
    public static function requireTabs(Event $event): EventResult;
}