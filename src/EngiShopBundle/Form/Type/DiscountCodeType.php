<?php

namespace EngiShopBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Validator\Constraints\NotBlank;

class DiscountCodeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('code', 'text', ['label' => 'Kod'])
            ->add('discount', 'percent', [
                'label' => 'Zniżka'
            ])
            ->add('active', 'checkbox', [
                'label' => 'Aktywna?',
                'required' => false
            ]);
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver
            ->setDefaults([
                'data_class' => 'EngiShopBundle\Entity\DiscountCode'
            ]);
    }

    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName()
    {
        return 'engishop_discount_code';
    }
} 