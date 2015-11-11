<?php

namespace FreezyBee\LightSortableGrid;

use Nette\Object;

/**
 * Class Modal
 * @package FreezyBee\LightSortableGrid
 */
class Modal extends Object
{
    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $text;

    /**
     * @var string
     */
    private $btnOk;

    /**
     * @var string
     */
    private $btnCancel;

    /**
     * @var boolean
     */
    private $ajax;

    /**
     * Modal constructor.
     * @param $title
     * @param $text
     * @param $btnOk
     * @param $btnCancel
     * @param $ajax
     */
    public function __construct(
        $title = 'Upozornění',
        $text = 'Opravdu chcete akci provést?',
        $btnOk = 'Potvrdit',
        $btnCancel = 'Zrušit',
        $ajax = false
    ) {
        $this->title = $title;
        $this->text = $text;
        $this->btnOk = $btnOk;
        $this->btnCancel = $btnCancel;
        $this->ajax = $ajax;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return $this
     */
    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * @param string $text
     * @return $this
     */
    public function setText($text)
    {
        $this->text = $text;
        return $this;
    }

    /**
     * @return string
     */
    public function getBtnOk()
    {
        return $this->btnOk;
    }

    /**
     * @param string $btnOk
     * @return $this
     */
    public function setBtnOk($btnOk)
    {
        $this->btnOk = $btnOk;
        return $this;
    }

    /**
     * @return string
     */
    public function getBtnCancel()
    {
        return $this->btnCancel;
    }

    /**
     * @param string $btnCancel
     * @return $this
     */
    public function setBtnCancel($btnCancel)
    {
        $this->btnCancel = $btnCancel;
        return $this;
    }

    /**
     * @return boolean
     */
    public function isAjax()
    {
        return $this->ajax;
    }

    /**
     * @param boolean $ajax
     * @return $this
     */
    public function setAjax($ajax)
    {
        $this->ajax = $ajax;
        return $this;
    }
}
