<?php

namespace App\Shared\Contracts\Tabs;

use \App\Shared\Contracts\Tabs\ActionInterface;

interface ServiceInterface
{
    public function actions(): ActionInterface;
}