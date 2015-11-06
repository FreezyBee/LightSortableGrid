<?php

namespace FreezyBee\LightSortableGrid\Model;

/**
 * Interface ISortableRepository
 * @package FreezyBee\LightSortableGrid\Model
 */
interface ISortableRepository
{
    /**
     * @param array $data [id => order]
     * @return bool
     */
    public function updateOrder(array $data);
}
