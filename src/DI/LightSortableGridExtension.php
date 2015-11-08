<?php

namespace FreezyBee\LightSortableGrid\DI;

use FreezyBee\MojeId\Attributes;
use FreezyBee\MojeId\Policy;
use Nette\DI\CompilerExtension;
use Nette\Utils\AssertionException;
use Nette\Utils\Json;
use Nette\Utils\JsonException;
use Nette\Utils\Validators;

/**
 * Class LightSortableGridExtension
 * @package FreezyBee\LightSortableGrid\DI
 */
class LightSortableGridExtension extends CompilerExtension
{
    public function loadConfiguration()
    {
        $builder = $this->getContainerBuilder();
        $builder->addDefinition($this->prefix('factory'))
            ->setClass('FreezyBee\LightSortableGrid\Factory');
    }
}
