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
    private $class;

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
     * @param string $class
     * @param $icon
     * @param Modal $modal
     */
    public function __construct($name, $label = null, $class = '', $icon = null, Modal $modal = null)
    {
        $this->name = $name;
        $this->label = $label;
        $this->class = $class;
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
                    if (empty($this->class)) {
                        $this->class = 'btn-primary-outline';
                    }
                    break;
                case 'delete':
                    $this->icon = 'trash-o';
                    if (empty($this->class)) {
                        $this->class = 'btn-danger-outline';
                    }
                    break;
            }
        }

        if (empty($this->class)) {
            $this->class = 'btn-primary-outline';
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
    public function getClass()
    {
        return $this->class;
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
