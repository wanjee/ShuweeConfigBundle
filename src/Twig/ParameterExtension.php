<?php

namespace Wanjee\Shuwee\ConfigBundle\Twig;

use Wanjee\Shuwee\ConfigBundle\Utils\ParameterManager;
/**
 * Class ParameterExtension
 * @package Wanjee\Shuwee\AdminBundle\Twig
 */
class ParameterExtension extends \Twig_Extension
{
    /**
     * @var \Wanjee\Shuwee\ConfigBundle\Utils\ParameterManager
     */
    var $parameterManager;

    /**
     * @param \Wanjee\Shuwee\AdminBundle\Manager\AdminManager $adminManager
     * @param \Wanjee\Shuwee\AdminBundle\Routing\Helper\AdminRoutingHelper $routingHelper
     * @param \Symfony\Component\Translation\TranslatorInterface $translator
     */
    public function __construct(ParameterManager $parameterManager)
    {
        $this->parameterManager = $parameterManager;
    }

    /**
     * @return array
     */
    public function getFunctions()
    {
        return array(
            'config_get_parameter' => new \Twig_Function_Method($this, 'getParameter'),
        );
    }

    /**
     * @param string $machineName
     * @return mixed The value associated to $machineName if any.  It will be of the type defined in parameter configuration.
     */
    public function getParameter($machineName)
    {
        return $this->parameterManager->get($machineName);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'shuwee_parameter_extension';
    }

}