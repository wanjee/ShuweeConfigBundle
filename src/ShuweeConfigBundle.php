<?php

/**
 * @author Wanjee <wanjee.be@gmail.com>
 */

namespace Wanjee\Shuwee\ConfigBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Class ShuweeConfigBundle
 * @package Wanjee\Shuwee\ConfigBundle
 */
class ShuweeConfigBundle extends Bundle
{
    /**
     * @param \Symfony\Component\DependencyInjection\ContainerBuilder $container
     */
    public function build(ContainerBuilder $container)
    {
        parent::build($container);
    }
}
