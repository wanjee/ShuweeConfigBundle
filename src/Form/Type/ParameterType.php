<?php

namespace Wanjee\Shuwee\ConfigBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

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
                TextType::class,
                array(
                    'help' => 'Administrative name.  Only to help editor to complete variables.',
                )
            );

            $form->add(
                'machineName',
                TextType::class,
                array(
                    'help' => 'Name to be used to retrieve the value using the REST API or the service.  Use a descriptive string like "site.title", "site.subtitle".  Should be as short as possible and must be unique.',
                )
            );

            $form->add(
                'type',
                ChoiceType::class,
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
                    'help' => 'This cannot be changed afterwards.  If you need to change type you will have to delete and recreate the variable.',
                    // Must be set to true in > 2.7.  See http://symfony.com/doc/current/reference/forms/types/choice.html#choices-as-values
                    'choices_as_values' => true,
                )
            );
        }
        else {

            // get type and display according field element
            $form->add(
                'clean_value',
                $parameter->getTypeClass(),
                array(
                    // display name as a label
                    'label' => $parameter->getName(),
                    'required' => false,
                )
            );

        }
    }

    /**
     * @param \Symfony\Component\OptionsResolver\OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            array(
                'data_class' => 'Wanjee\Shuwee\ConfigBundle\Entity\Parameter',
            )
        );
    }
}
