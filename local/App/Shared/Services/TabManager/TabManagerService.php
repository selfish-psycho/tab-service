<?php

namespace App\Shared\Services\TabManager;

use App\Shared\Contracts\BaseServiceInterface;
use App\Shared\Contracts\Tabs\ServiceInterface;
use App\Shared\DI\Container;
use App\Shared\Enums\TabManager\ServicesEnums;
use App\Shared\Services\TabManager\BaseTab\BaseTabService;

class TabManagerService implements BaseServiceInterface
{
    /**
     * @inheritDoc
     */
    public static function create(int $typeId): ServiceInterface
    {
        return match($typeId) {
            ServicesEnums::BASE->value => (new Container())->get(BaseTabService::class),
        };
    }
}
