<?php

namespace Wanjee\Shuwee\ConfigBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
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
        $builder->addEventListener(FormEvents::PRE_SET_DATA, array($this, 'onPreSetData'));
    }

    /**
     * Set appropriate field elements in form
     * @param FormEvent $event
     */
    function onPreSetData(FormEvent $event) {
        $parameter = $event->getData();
        $form = $event->getForm();

        // For a new parameter we ask name and type
        if (!$parameter || null === $parameter->getId()) {
            $form->add(
                'name',
                'text'
            );

            $form->add(
                'type',
                'choice',
                array(
                    'placeholder' => 'Choose a value type',
                    'choices' => array(
                        'text' => 'Text',
                        'textarea' => 'Textarea',
                        'integer' => 'Integer',
                        'number' => 'Number',
                        'date' => 'Date',
                        'datetime' => 'Datetime',
                        'email' => 'Email',
                        'url' => 'URL',
                    )
                )
            );
        }
        else {
            // display name as a label
            $form->add(
                'name',
                'text',
                array(
                    'disabled' => TRUE
                )
            );

            // get type and display according field element
            $form->add(
                'value_input',
                $parameter->getType(),
                array(
                    'required' => false,
                )
            );

        }
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