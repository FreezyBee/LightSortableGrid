<?php

namespace FreezyBee\LightSortableGrid;

use Nette\SmartObject;

/**
 * @property-read string $name
 * @property-read string $label
 * @property-read int $type
 * @property-read callable $customRenderer
 */
class Column
{
    use SmartObject;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $label;

    /**
     * @var int
     */
    private $type;

    /**
     * @var
     */
    private $customRenderer;

    /**
     * Column constructor.
     * @param $name
     * @param null $label
     * @param null $type
     */
    public function __construct($name, $label = null, $type = null)
    {
        if (is_null($label)) {
            $label = $name;
        }
        $this->name = $name;
        $this->label = $label;
        $this->type = $type;
    }

    public function setCustomRenderer($callback)
    {
        $this->customRenderer = $callback;
    }

    public function getCustomRenderer()
    {
        return $this->customRenderer;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return explode('.', $this->name);
    }

    /**
     * @return string
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * @return int
     */
    public function getType()
    {
        return $this->type;
    }
}
