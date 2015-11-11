<?php

namespace FreezyBee\LightSortableGrid;

use Kdyby\Doctrine\EntityManager;
use Kdyby\Doctrine\EntityRepository;
use Nette\Application\UI\Control;
use Nette\Application\UI\Form;
use Nette\Reflection\Annotation;
use Nette\Utils\ArrayHash;
use Nette\Utils\Json;
use Nette\Utils\JsonException;

/**
 * Class Grid
 * @package FreezyBee\LightSortableGrid
 */
class Grid extends Control
{
    /**
     * @var array
     */
    public $onError = [];

    /**
     * @var array
     */
    public $onValid = [];

    /**
     * @var boolean
     */
    private $disableSort;

    /**
     * @var boolean
     */
    private $disableAdd;

    /**
     * @var array
     */
    private $conditions = [];

    /**
     * @var Column[]
     */
    private $columns = [];

    /**
     * @var Action[]
     */
    private $actions = [];

    /**
     * @var Filter[]
     */
    private $filters = [];

    /**
     * @var ArrayHash
     */
    private $activeFilters = [];

    /**
     * @var EntityRepository
     */
    private $entityRepository;

    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * @param EntityRepository $entityRepository
     */
    public function __construct(EntityRepository $entityRepository)
    {
        $this->entityRepository = $entityRepository;
        $this->entityManager = $entityRepository->getEntityManager();
    }

    /**
     * @return Form
     */
    protected function createComponentForm()
    {
        $form = new Form;

        $form->setMethod('GET');

        $filters = $form->addContainer('filters');
        foreach ($this->filters as $filter) {
            $values = array_merge(['_default' => $filter->getLabel() . ' (vše)'], $this->loadFilterData($filter));
            $filters->addSelect($filter->getName(), $filter->getLabel(), $values);
        }

        $form->addSubmit('applyFilter')
            ->onClick[] = [$this, 'handleFilter'];
        $form->addSubmit('applyReset')
            ->onClick[] = [$this, 'handleReset'];

        return $form;
    }

    /**
     * @param $name
     * @param $title
     * @param $type
     * @return Column
     */
    public function addColumn($name, $title = null, $type = null)
    {
        $this->columns[] = $column = new Column($name, $title, $type);
        return $column;
    }

    /**
     * @param $name
     * @param $title
     * @param string $class
     * @param null $icon
     * @param Modal $modal
     * @return Action
     */
    public function addAction($name, $title = null, $class = '', $icon = null, Modal $modal = null)
    {
        $this->actions[] = $action = new Action($name, $title, $class, $icon, $modal);
        return $action;
    }

    /**
     * @param $name
     * @param $label
     * @param $itemIdentifier
     * @param $itemLabel
     * @return Filter
     */
    public function addFilter($name, $label = null, $itemIdentifier = 'id', $itemLabel = 'name')
    {
        $this->filters[] = $filter = new Filter($name, $label, $itemIdentifier, $itemLabel);
        return $filter;
    }

    /**
     * @param bool|true $value
     * @return $this
     */
    public function disableSort($value = true)
    {
        $this->disableSort = $value;
        return $this;
    }

    /**
     * @param bool|true $value
     * @return $this
     */
    public function disableAdd($value = true)
    {
        $this->disableAdd = $value;
        return $this;
    }

    /**
     * @return array
     */
    public function getFilteredData()
    {
        $where = $this->conditions;
        foreach ($this->filters as $filter) {
            if (array_key_exists($filter->getName(), (array)$this->activeFilters) &&
                $this->activeFilters[$filter->getName()] != '_default'
            ) {
                $where[$filter->getName() . '.' . $filter->getItemIdentifier()] =
                    $this->activeFilters[$filter->getName()];
            }
        }

        return $this->entityRepository->findBy($where, ($this->disableSort ? [] : ['ord' => 'ASC']));
    }

    /**
     * @param array $conditions
     * @return $this
     */
    public function setConditions(array $conditions)
    {
        $this->conditions = $conditions;
        return $this;
    }

    /**
     *
     */
    public function render()
    {
        $template = $this->template;
        $data = $this->getFilteredData();

        if (!($this->columns && is_array($data))) {
            throw new \Exception('missing data or column');
        }

        $template->columns = $this->columns;
        $template->actions = $this->actions;
        $template->filters = $this->filters;
        $template->activeFilters = $this->activeFilters;
        $template->data = $data;
        $template->disableSort = $this->disableSort;
        $template->disableAdd = $this->disableAdd;

        $template->setFile(__DIR__ . '/Grid.latte');
        $template->render();
    }

    /**
     * @param $order
     */
    public function handleSort($order)
    {
        if ($order && $data = self::prepareSortData($order)) {
            $this->onValid($data);
        } else {
            $this->onError();
        }
    }

    /**
     * @param \Nette\Forms\Controls\SubmitButton $button
     */
    public function handleFilter(\Nette\Forms\Controls\SubmitButton $button)
    {
        $this->activeFilters = $button->form->values->filters;

        if ($this->presenter->isAjax()) {
            $this->redrawControl('lightSortableGrid');
        }
    }

    /**
     * @param \Nette\Forms\Controls\SubmitButton $button
     */
    public function handleReset(\Nette\Forms\Controls\SubmitButton $button)
    {
        $this->activeFilters = [];
        $this->redirect('this', ['filters' => null]);
    }

    /**
     * @param $order
     * @return array
     */
    private function prepareSortData($order)
    {
        try {
            $order = Json::decode($order);
        } catch (JsonException $e) {
            return false;
        }

        $data = [];
        $counter = 0;
        foreach ($order as $item) {
            $data[$item] = $counter++;
        }

        return $data;
    }

    /**
     * @param Filter $filter
     * @return array
     * @throws \Exception
     */
    private function loadFilterData(Filter $filter)
    {
        $meta = $this->entityRepository->getClassMetadata();

        $entityClassReflection = new \Nette\Reflection\ClassType($meta->name);
        /** @var Annotation $entityClass */
        $entityClass = $entityClassReflection->getProperty($filter->getName())->getAnnotation('var');
        $class = $entityClassReflection->getNamespaceName() . '\\' . $entityClass;
        $repository = $this->entityManager->getRepository($class);

        if ($repository instanceof \Kdyby\Doctrine\EntityDao) {
            return $repository->findPairs([], $filter->getItemLabel(), [], $filter->getItemIdentifier());
        }
    }
}