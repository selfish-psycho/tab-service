<?php

use OpenApi\Attributes\Parameter;
use OpenApi\Attributes\Schema;

#[\Attribute(\Attribute::TARGET_CLASS)]
#[Schema(description: 'Дата объект добавляемого таба')]
class TabDTO
{
    public function __construct(
        #[Parameter( name: 'id', description: 'Идентификатор добавляемого таба')]
        private readonly string $id,
        #[Parameter( name: 'name', description: 'Название таба')]
        private readonly string $name,
        #[Parameter( name: 'componentName', description: 'Название компонент обработчика таба')]
        private readonly string $componentName,
        #[Parameter( name: 'componentTemplate', description: 'Подключаемый шаблон компонента таба')]
        private string          $componentTemplate = '',
        #[Parameter( name: 'componentData', description: 'Параметры подключаемого компонента таба')]
        private array           $componentData = [],
    )
    {
    }

    /**
     *
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getComponentName(): string
    {
        return $this->componentName;
    }

    public function setComponentData(array $componentData): self
    {
        $this->componentData = $componentData;
        return $this;
    }

    /**
     * @return array
     */
    public function getComponentData(): array
    {
        return $this->componentData;
    }

    public function setComponentTemplate(string $template): self
    {
        $this->componentTemplate = $template;
        return $this;
    }

    /**
     * @return string
     */
    public function getComponentTemplate(): string
    {
        return $this->componentTemplate;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->getId(),
            'name' => $this->getName(),
            'loader' => [
                'serviceUrl' => '/local/App/Shared/Services/TabManager/BaseTab/Pages/service_page.php',
                'componentData' => array_merge(
                    $this->getComponentData(),
                    [
                        'component_name' => $this->getComponentName(),
                        'component_template' => $this->getComponentTemplate(),
                    ]
                ),
            ]
        ];
    }
}
