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
                'text',
                array(
                    'help' => 'Administrative name.  Only to help editor to complete variables.',
                )
            );

            $form->add(
                'machineName',
                'text',
                array(
                    'help' => 'Name to be used to retrieve the value using the REST API or the service.  Use a descriptive string like "site.title", "site.subtitle".  Should be as short as possible and must be unique.',
                )
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
                    ),
                    'help' => 'This cannot be changed afterwards.  If you need to change type you will have to delete and recreate the variable.'
                )
            );
        }
        else {

            // get type and display according field element
            $form->add(
                'clean_value',
                $parameter->getType(),
                array(
                    // display name as a label
                    'label' => $parameter->getName(),
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