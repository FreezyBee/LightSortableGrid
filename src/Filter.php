<?php

namespace FreezyBee\LightSortableGrid;

use Nette\Object;

/**
 * Class Filter
 * @package FreezyBee\LightSortableGrid
 */
class Filter extends Object
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $label;

    /**
     * @var string
     */
    private $itemIdentifier;

    /**
     * @var string
     */
    private $itemLabel;

    /**
     * Action constructor.
     * @param $name
     * @param $label
     * @param $itemIdentifier
     * @param $itemLabel
     */
    public function __construct($name, $label, $itemIdentifier = 'id', $itemLabel = 'name')
    {
        $this->name = $name;
        $this->label = $label;
        $this->itemIdentifier = $itemIdentifier;
        $this->itemLabel = $itemLabel;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }


    /**
     * @return string
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * @return string
     */
    public function getItemIdentifier()
    {
        return $this->itemIdentifier;
    }

    /**
     * @return string
     */
    public function getItemLabel()
    {
        return $this->itemLabel;
    }
}
