<?php

use Bitrix\Main\Application;
use Bitrix\Main\Loader;
use Bitrix\Main\LoaderException;
use App\Shared\Enums\TabManager\ServicesEnums as TabServicesEnums;
use App\Shared\Services\TabManager\TabManagerService;

require(Application::getDocumentRoot() . "/bitrix/vendor/autoload.php");

/*****
 * Подключение кастомных классов.
 *****/
try {
    Loader::registerNamespace(
        "App",
        Loader::getDocumentRoot() . "/local/App"
    );
} catch (LoaderException $e) {
    //log error
}

/*****
 * Tabs
 * Зарегистрировать классы кастомных табов
 *****/
$tabContainer = TabManagerService::create(TabServicesEnums::BASE->value);
$tabContainer->actions()->initTabs();
