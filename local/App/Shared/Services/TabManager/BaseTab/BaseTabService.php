<?php

namespace App\Shared\Services\TabManager\BaseTab;

use App\Shared\Contracts\Tabs\ActionInterface;
use App\Shared\Contracts\Tabs\ServiceInterface;
use App\Shared\Services\TabManager\BaseTab\Actions\BaseTabActions;

readonly class BaseTabService implements ServiceInterface
{
    public function __construct(
        private BaseTabActions $actions
    )
    {
    }

    /**
     * @return ActionInterface
     */
    public function actions(): ActionInterface
    {
        return $this->actions;
    }


}
