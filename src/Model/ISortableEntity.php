<?php

namespace FreezyBee\LightSortableGrid\Model;

/**
 * Interface ISortableEntity
 * @package FreezyBee\Entity
 */
interface ISortableEntity
{
    /**
     * @return integer
     */
    public function getId();

    /**
     * @return integer
     */
    public function getOrd();

    /**
     * @param $order
     */
    public function setOrd($order);
}