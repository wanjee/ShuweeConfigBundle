<?php
namespace Wanjee\Shuwee\ConfigBundle\Admin;

use Symfony\Component\Security\Core\Authorization\Voter\VoterInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Wanjee\Shuwee\AdminBundle\Admin\Admin;
use Wanjee\Shuwee\AdminBundle\Datagrid\Datagrid;
use Wanjee\Shuwee\AdminBundle\Security\Voter\ContentVoter;

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
        $datagrid = new Datagrid($this, array(
                'limit_per_page' => 50,
                'default_sort_column' => 'machineName',
                'default_sort_order' => 'asc',
            )
        );

        $datagrid
            ->addField(
                'name',
                'text',
                array(
                    'label' => 'Name',
                    'sortable' => true,
                )
            )
            ->addField(
                'machineName',
                'text',
                array(
                    'label' => 'Machine name',
                    'sortable' => true,
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

    /**
     * {@inheritdoc}
     */
    public function getMenuSection()
    {
        return 'configuration';
    }

    /**
     * Content voter callback.
     * For a given user, a given attribute (action to take) and a given object
     * it returns user authorization
     *
     * @param UserInterface $user
     * @param string $attribute
     * @param mixed $object
     * @return integer either VoterInterface::ACCESS_GRANTED, VoterInterface::ACCESS_ABSTAIN, or VoterInterface::ACCESS_DENIED
     */
    public function hasAccess(UserInterface $user, $action, $object = null)
    {
        $grants = array(
            ContentVoter::LIST_CONTENT => array('ROLE_PARAMETER_ADMIN', 'ROLE_PARAMETER_EDITOR'),
            ContentVoter::VIEW_CONTENT => array('ROLE_PARAMETER_ADMIN', 'ROLE_PARAMETER_EDITOR'),
            ContentVoter::CREATE_CONTENT => array('ROLE_PARAMETER_ADMIN'),
            ContentVoter::UPDATE_CONTENT => array('ROLE_PARAMETER_ADMIN', 'ROLE_PARAMETER_EDITOR'),
            ContentVoter::DELETE_CONTENT => array('ROLE_PARAMETER_ADMIN'),
        );

        // get granted roles
        $granted_roles = array();
        if (array_key_exists($action, $grants)) {
            $granted_roles = $grants[$action];
        }

        // check if user has any of the give roles
        foreach ($granted_roles as $granted_role) {
            if ($this->getAuthorizationChecker()->isGranted($granted_role)) {
                return VoterInterface::ACCESS_GRANTED;
            }
        }

        return VoterInterface::ACCESS_DENIED;
    }
}