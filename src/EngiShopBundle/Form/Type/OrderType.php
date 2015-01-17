<?php

namespace EngiShopBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class OrderType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName', 'text', ['label' => 'Imię'])
            ->add('lastName', 'text', ['label' => 'Nazwisko'])
            ->add('address', 'text', ['label' => 'Adres'])
            ->add('address2', 'text', ['label' => 'Adres c. d.'])
            ->add('zip', 'text', ['label' => 'Kod pocztowy'])
            ->add('city', 'text', ['label' => 'Miasto'])
            ->add('state', 'text', ['label' => 'Województwo'])
            ->add('country', 'country', ['label' => 'Kraj'])
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver
            ->setDefaults([
                'data_class' => 'EngiShopBundle\Entity\OrderClass'
            ]);
    }

    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName()
    {
        return 'engishop_order';
    }
} 