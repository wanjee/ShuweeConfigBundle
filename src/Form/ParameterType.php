<?php

namespace Wanjee\Shuwee\ConfigBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class ParameterType
 * @package Wanjee\Shuwee\ConfigBundle\Form
 */
class ParameterType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            // name should only be displayed on variable creation
            ->add('name')
            // type should only be displayed on variable creation
            ->add('type', 'textarea')
            // value should be only be displayed on variable edition
            ->add('value');
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            array(
                'data_class' => 'Wanjee\Shuwee\ConfigBundle\Entity\Parameter',
            )
        );
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'shuwee_config_parameter';
    }
}