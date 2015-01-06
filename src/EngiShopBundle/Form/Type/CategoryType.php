<?php

namespace EngiShopBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Validator\Constraints\NotBlank;

class CategoryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text', [
                'label' => 'Nazwa',
                'constraints' => [
                    new NotBlank(['message' => 'Ta wartość nie powinna być pusta.'])
                ]
            ])
            ->add('description', 'textarea', [
                'label' => 'Opis',
                'attr' => [
                    'rows' => 10
                ],
                'constraints' => [
                    new NotBlank(['message' => 'Ta wartość nie powinna być pusta.'])
                ]
            ])
            ->add('slug', 'text', [
                'label' => 'Adres'
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
                'data_class' => 'EngiShopBundle\Entity\Category'
            ]);
    }

    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName()
    {
        return 'engishop_category';
    }
} 