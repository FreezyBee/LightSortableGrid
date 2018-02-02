<?php

namespace FreezyBee\LightSortableGrid;

use Nette\SmartObject;

/**
 * @property-read string $name
 * @property-read string $label
 * @property-read string $class
 * @property-read string $icon
 * @property-read Modal|null $modal
 */
class Action
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
     * @var
     */
    private $customLink;

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
     * @return Modal
     */
    public function getModal()
    {
        return $this->modal;
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
     * @param string $name
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
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
     * @return $this
     */
    public function setLabel($label)
    {
        $this->label = $label;
        return $this;
    }

    /**
     * @return string
     */
    public function getClass()
    {
        return $this->class;
    }

    /**
     * @param string $class
     * @return $this
     */
    public function setClass($class)
    {
        $this->class = $class;
        return $this;
    }

    /**
     * @return string
     */
    public function getIcon()
    {
        return $this->icon;
    }

    /**
     * @param string $icon
     * @return $this
     */
    public function setIcon($icon)
    {
        $this->icon = $icon;
        return $this;
    }

    /**
     * @return callback
     */
    public function getCustomLink()
    {
        return $this->customLink;
    }

    /**
     * @param callback $callback
     */
    public function setCustomLink($callback)
    {
        $this->customLink = $callback;
    }
}
