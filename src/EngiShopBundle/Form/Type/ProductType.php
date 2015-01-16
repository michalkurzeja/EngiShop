<?php

namespace EngiShopBundle\Form\Type;

use Doctrine\ORM\EntityRepository;
use EngiShopBundle\Form\Type\FileImageType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Validator\Constraints\NotBlank;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text', [
                'label' => 'Nazwa'
            ])
            ->add('description', 'textarea', [
                'label' => 'Opis',
                'attr' => [
                    'rows' => 10
                ]
            ])
            ->add('descriptionExtended', 'textarea', [
                'label' => 'Rozszerzony opis',
                'attr' => [
                    'rows' => 10
                ]
            ])
            ->add('price', 'number', [
                'label' => 'Cena'
            ])
            ->add('category', 'entity', [
                'label' => 'Kategoria',
                'required' => 'false',
                'class' => 'EngiShopBundle:Category',
                'empty_value' => '-- Brak --',
                'query_builder' => function(EntityRepository $er) {
                    return $er->createQueryBuilder('c')
                        ->orderBy('c.name');
                }
            ])
            ->add('slug', 'text', [
                'label' => 'Adres'
            ])
            ->add('featured', 'checkbox', [
                'label' => 'Na główną?',
                'required' => false
            ])
            ->add('active', 'checkbox', [
                'label' => 'Aktywny?',
                'required' => false
            ])
            ->add('image', new FileImageType(), [
                'cascade_validation' => true,
                'required' => false,
                'data_class' => 'EngiShopBundle\Entity\File'
            ]);

    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver
            ->setDefaults([
                'data_class' => 'EngiShopBundle\Entity\Product'
            ]);
    }

    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName()
    {
        return 'engishop_product';
    }
} 