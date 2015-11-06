<?php

namespace FreezyBee\LightSortableGrid;

use Nette\Object;

/**
 * Class Action
 * @package FreezyBee\LightSortableGrid
 */
class Action extends Object
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
    private $icon;

    /**
     * @var Modal
     */
    private $modal;

    /**
     * Action constructor.
     * @param $name
     * @param $label
     * @param $icon
     * @param $modal
     */
    public function __construct($name, $label = null, $icon = null, Modal $modal = null)
    {
        $this->name = $name;
        $this->label = $label;
        $this->icon = $icon;
        $this->modal = $modal;

        $this->setAutomaticIcon();
    }

    /**
     *
     */
    private function setAutomaticIcon()
    {
        if ($this->icon === null) {
            switch ($this->name) {
                case 'edit':
                    $this->icon = 'pencil-square-o';
                    break;
                case 'delete':
                    $this->icon = 'trash-o';
                    break;
            }
        }
    }

    /**
     * @param Modal $modal
     * @return Modal
     */
    public function setModal(Modal $modal)
    {
        $this->modal = $modal;
        return $this->modal;
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
    public function getIcon()
    {
        return $this->icon;
    }

    /**
     * @return Modal
     */
    public function getModal()
    {
        return $this->modal;
    }
}
