<?php
namespace Wanjee\Shuwee\ConfigBundle\Admin;

use Wanjee\Shuwee\AdminBundle\Admin\Admin;
use Wanjee\Shuwee\AdminBundle\Datagrid\Datagrid;

/**
 * Class ParameterAdmin
 *
 * @package Wanjee\Shuwee\ConfigBundle\Admin
 */
class ParameterAdmin extends Admin
{
    /**
     * Return the main admin form for this content.
     *
     * @return \Symfony\Component\Form\Form
     */
    public function getForm()
    {
        // Return either a fully qualified class name
        // or the service id of your form if it is defined as a service
        return 'Wanjee\Shuwee\ConfigBundle\Form\ParameterType';
    }

    /**
     * @return Datagrid
     */
    public function getDatagrid()
    {
        $datagrid = new Datagrid($this);

        $datagrid
            ->addField(
                'id',
                'text',
                array(
                    'label' => '#',
                )
            )
            ->addField(
                'name',
                'text',
                array(
                    'label' => 'Name',
                )
            )
            ->addField(
                'value',
                'text',
                array(
                    'label' => 'Value',
                    'truncate' => 80,
                )
            );

        return $datagrid;
    }

    /**
     * @return string
     */
    public function getEntityName()
    {
        return 'ShuweeConfigBundle:Parameter';
    }

    /**
     * @return string
     */
    public function getEntityClass()
    {
        return 'Wanjee\Shuwee\ConfigBundle\Entity\Parameter';
    }

    /**
     * @return string
     */
    public function getLabel()
    {
        return '{0} Parameters|{1} Parameter|]1,Inf] Parameters';
    }
}