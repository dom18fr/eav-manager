<?php

namespace CleverAge\EAVManager\AdminBundle\Controller;

use CleverAge\EAVManager\Component\Controller\AdminControllerTrait;
use CleverAge\EAVManager\Component\Controller\BaseControllerTrait;
use Elastica\Query;
use Sidus\AdminBundle\Controller\AdminInjectable;
use Sidus\DataGridBundle\Model\DataGrid;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

abstract class BaseAdminController extends Controller implements AdminInjectable
{
    use BaseControllerTrait;
    use AdminControllerTrait;

    /** @var string */
    protected $defaultTarget = 'tg_center';

    /**
     * @return string
     */
    protected function getDataGridConfigCode()
    {
        // Check if datagrid code is set in options
        $datagridCode = $this->admin->getOption('datagrid');
        if ($datagridCode) {
            return $datagridCode;
        }

        return $this->admin->getCode();
    }

    /**
     * @return DataGrid
     * @throws \UnexpectedValueException
     */
    protected function getDataGrid()
    {
        return $this->get('sidus_data_grid.datagrid_configuration.handler')
            ->getDataGrid($this->getDataGridConfigCode());
    }

    protected function getTarget(Request $request)
    {
        return $request->get('target', $this->defaultTarget);
    }

    protected function bindDataGridRequest(DataGrid $dataGrid, Request $request)
    {
        // Create form with filters
        $builder = $this->createFormBuilder(null, [
            'method' => $request->getMethod(),
            'csrf_protection' => false,
            'action' => $this->getCurrentUri($request),
            'attr' => [
                'data-target' => $this->getTarget($request),
            ],
        ]);
        $dataGrid->buildForm($builder);
        $dataGrid->handleRequest($request);
    }
}
