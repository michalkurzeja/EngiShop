<?php

namespace EngiShopBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PostType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', 'text', ['label' => 'Tytuł'])
            ->add('summary', 'textarea', [
                'label' => 'Streszczenie',
                'attr' => [
                    'rows' => 10
                ]
            ])
            ->add('content', 'textarea', [
                'label' => 'Treść',
                'required' => true,
                'attr' => [
                    'class' => 'summernote'
                ]
            ])
            ->add('featured', 'checkbox', [
                'label' => 'Na główną?',
                'required' => false
            ])
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver
            ->setDefaults([
                'data_class' => 'EngiShopBundle\Entity\Post'
            ]);
    }
    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName()
    {
        return 'engishop_post';
    }
}