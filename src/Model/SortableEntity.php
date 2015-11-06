<?php
namespace FreezyBee\LightSortableGrid\Model;

use Doctrine\ORM\Mapping as ORM;

/**
 * Interface ISortableEntity
 * @package FreezyBee\Entity
 */
trait SortableEntity
{
    /**
     * @var int
     * @ORM\Column(type="integer")
     */
    private $ord;

    /**
     * @return integer
     */
    public function getOrd()
    {
        return $this->ord;
    }

    /**
     * @param $order
     */
    public function setOrd($order)
    {
        $this->ord = $order;
    }
}