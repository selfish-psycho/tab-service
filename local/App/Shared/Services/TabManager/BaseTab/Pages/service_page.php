<?php

use Bitrix\Main\Application;

require_once($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");

$app = new CMain();

$app->ShowHead();

$requestParams = Application::getInstance()->getContext()->getRequest()->get('PARAMS');
$componentName = $requestParams['component_name'];
$componentTemplate = $requestParams['component_template'];

$app->IncludeComponent(
    componentName: $componentName,
    componentTemplate: $componentTemplate,
    arParams: [
        'ENTITY_ID' => $requestParams['entity_id'],
        'ENTITY_TYPE_ID' => $requestParams['entity_type_id']
    ]
);
