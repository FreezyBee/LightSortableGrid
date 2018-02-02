<?php

namespace FreezyBee\LightSortableGrid;

use Kdyby\Doctrine\EntityManager;
use Nette\SmartObject;

/**
 * Class Factory
 * @package FreezyBee\LightSortableGrid
 */
class Factory
{
    use SmartObject;

    /**
     * @var EntityManager
     */
    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function create($entityName)
    {
        $entityRepository = $this->entityManager->getRepository($entityName);
        return new Grid($entityRepository);
    }
}