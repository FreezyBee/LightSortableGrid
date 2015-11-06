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
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * @return string
     */
    public function getBtnOk()
    {
        return $this->btnOk;
    }

    /**
     * @return string
     */
    public function getBtnCancel()
    {
        return $this->btnCancel;
    }

    /**
     * @return boolean
     */
    public function isAjax()
    {
        return $this->ajax;
    }
}
