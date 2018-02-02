<?php

namespace FreezyBee\LightSortableGrid;

use Nette\SmartObject;

/**
 * Class Filter
 * @package FreezyBee\LightSortableGrid
 */
class Filter
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
    public function __construct($name, $label = null, $itemIdentifier = 'id', $itemLabel = 'name')
    {
        if (is_null($label)) {
            $label = $name;
        }
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
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * @param string $label
     */
    public function setLabel($label)
    {
        $this->label = $label;
    }

    /**
     * @return string
     */
    public function getItemIdentifier()
    {
        return $this->itemIdentifier;
    }

    /**
     * @param string $itemIdentifier
     */
    public function setItemIdentifier($itemIdentifier)
    {
        $this->itemIdentifier = $itemIdentifier;
    }

    /**
     * @return string
     */
    public function getItemLabel()
    {
        return $this->itemLabel;
    }

    /**
     * @param string $itemLabel
     */
    public function setItemLabel($itemLabel)
    {
        $this->itemLabel = $itemLabel;
    }
}
