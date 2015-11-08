<?php

namespace FreezyBee\LightSortableGrid;

use Kdyby\Doctrine\EntityManager;
use Kdyby\Doctrine\EntityRepository;
use Nette\Application\UI\Control;
use Nette\Application\UI\Form;
use Nette\Object;
use Nette\Reflection\Annotation;
use Nette\Utils\ArrayHash;
use Nette\Utils\Json;
use Nette\Utils\JsonException;

/**
 * Class Factory
 * @package FreezyBee\LightSortableGrid
 */
class Factory extends Object
{
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