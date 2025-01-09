<?php

namespace App\Shared\Services\TabManager\BaseTab\Actions;

use App\Shared\Contracts\Tabs\ActionInterface;
use Bitrix\Main\Application;
use Bitrix\Main\Event;
use Bitrix\Main\EventManager;
use Bitrix\Main\EventResult;
use CComponentEngine;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use RegexIterator;

class BaseTabActions implements ActionInterface
{
    public function initTabs(): void
    {
        $eventManager = EventManager::getInstance();

        $eventManager->addEventHandler('crm', 'onEntityDetailsTabsInitialized', [
            __CLASS__,
            'requireTabs'
        ]);
    }

    /**
     * Загрузчик классов описания табов
     * @param $class
     * @return void
     */
    private static function tabsClassesLoader($class): void
    {
        if(is_file($class)) {
            include $class;
        }
    }

    public static function requireTabs(Event $event): EventResult
    {
        //region Проверяем, что можем подключить табы
        $entityId = $event->getParameter('entityID');
        $entityTypeId = $event->getParameter('entityTypeID');
        $baseTabs = $event->getParameter('tabs');

        //region Только для тех проектов, где уже реализовано добавление табов
        $eventResultTabs = current($event->getResults())->getParameters()['tabs'];

        //Если события уже были переопределены. Можно удалить выделенное, если есть уверенность, что нигде больше события не переопределяются
        if (count($eventResultTabs) != count($baseTabs)) {
            $baseTabs = $eventResultTabs;
        }
        //endregion Только для тех проектов, где уже реализовано добавление табов

        $engine = new CComponentEngine();

        //Для сделок, лидов, контактов и компаний
        $page = $engine->guessComponentPath(
            folder404: '/crm/',
            arUrlTemplates: ['detail' => '#entity_type#/details/#entity_id#/'],
            arVariables: $variables
        );

        if ($page !== 'detail') {
            //Для элементов СП
            $page = $engine->guessComponentPath(
                '/crm/type/',
                ['detail' => '#entity_type#/details/#entity_id#/'],
                $variables
            );

            if ($page !== 'detail') {
                return new EventResult(EventResult::SUCCESS,
                    [
                        'tabs' => $baseTabs,
                    ],
                );
            }
        }
        //endregion Проверяем, что можем подключить табы

        //region Подключаем классы описаний табов
        //Получаем все классы из хранилища объявленных табов
        $documentRoot = Application::getDocumentRoot();

        //Если папки с описанием табов нет, то и подключать нечего
        if (!is_dir($documentRoot . '/local/App/Domains/Tabs')) {
            return new EventResult(EventResult::SUCCESS,
                [
                    'tabs' => $baseTabs,
                ],
            );
        }

        $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($documentRoot . '/local/App/Domains/Tabs'));
        $regex = new RegexIterator($iterator, '/^.*\.php/i', RegexIterator::GET_MATCH);

        //Проходимся по всем выбранным классам и подключаем их, чтобы для нас они были видны из этого файла
        foreach ($regex as $file => $value) {
            static::tabsClassesLoader($file);
        }
        //endregion Подключаем классы описаний табов

        //region Инициализируем описанные табы
        $declaredTabs = [];
        $newTabs = [];
        foreach(get_declared_classes() as $class) {
            //Собираем массив классов, наследуемых от интерфейса хранилища кастомных типов данных
            if (is_subclass_of($class, '\App\Shared\Contracts\Tabs\RepositoryInterface')) {
                $declaredTabs[$class::getTypeId()] = $class;
            }
        }

        if (empty($declaredTabs)) {
            return new EventResult(EventResult::SUCCESS,
                [
                    'tabs' => $baseTabs,
                ],
            );
        }

        foreach ($declaredTabs as $typeId => $tabs) {
            if ($typeId === $entityTypeId) {
                foreach ($tabs::getTabs() as $tab) {
                    $tab->setComponentData(
                        array_merge(
                            $tab->getComponentData(),  // Данные компонента из репозитория табов
                            [ //Данные для компонента, определяемые объектом Event
                                'entity_id' => $entityId,
                                'entity_type_id' => $entityTypeId,
                            ]
                        )
                    );
                    $newTabs[] = $tab->toArray();
                }
            }
        }
        //endregion Инициализируем описанные табы

        return new EventResult(EventResult::SUCCESS,
            [
                'tabs' => array_merge($baseTabs, $newTabs)
            ],
        );
    }
}
