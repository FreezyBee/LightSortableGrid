<?php

namespace FreezyBee\LightSortableGrid;

use Kdyby\Doctrine\EntityManager;
use Kdyby\Doctrine\EntityRepository;
use Nette\Application\UI\Control;
use Nette\Application\UI\Form;
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
    public function setDataSource(EntityRepository $entityRepository)
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
            $filters->addSelect($filter->getName(), $filter->getLabel(), $this->loadFilterData($filter));
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
     * @return array
     */
    public function getFilteredData()
    {
        $where = [];
        foreach ($this->filters as $filter) {
            if (array_key_exists($filter->getName(), (array)$this->activeFilters)) {
                $where[$filter->getName() . '.' . $filter->getItemIdentifier()] = $this->activeFilters[$filter->name];
            }
        }

        return $this->entityRepository->findBy($where, ['ord' => 'ASC']);
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

        $template->setFile(__DIR__ . '/Grid.latte');
        $template->render();
    }

    /**
     * @param $order
     */
    public function handleSort($order)
    {
        $data = self::prepareSortData($order);
        if ($data) {
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
    }

    /**
     * @param \Nette\Forms\Controls\SubmitButton $button
     */
    public function handleReset(\Nette\Forms\Controls\SubmitButton $button)
    {
        $this->activeFilters = [];
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
        // TODO neco inteligentnejsiho
        $entityPath = $this->entityRepository->getClassName();
        $pos = strrpos($entityPath, "\\");
        if ($pos === false) {
            throw new \Exception('error entity path');
        }
        $class = substr($entityPath, 0, $pos) . '\\' . ucfirst($filter->getName());

        $repository = $this->entityManager->getRepository($class);

        if ($repository instanceof \Kdyby\Doctrine\EntityDao) {
            return $repository->findPairs([], $filter->getItemLabel(), [], $filter->getItemIdentifier());
        }
    }
}