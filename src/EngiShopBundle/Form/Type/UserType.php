<?php

namespace EngiShopBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', 'text', [
                'label' => 'Nazwa użytkownika'
            ])
            ->add('email')
            ->add('password', 'repeated', [
                'type' => 'password',
                'invalid_message' => 'Hasła muszą być jednakowe',
                'first_options' => ['label' => 'Hasło'],
                'second_options' => ['label' => 'Powtórz hasło'],
                'required' => !$options['edit']
            ])
            ->add('address')
            ->add('address2')
            ->add('zip')
            ->add('city')
            ->add('state')
            ->add('country', 'country')
            ->add('isActive', 'checkbox', [
                'required' => false,
                'label' => 'Aktywny?'
            ])
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver
            ->setDefaults([
                'data_class' => 'EngiShopBundle\Entity\User',
                'edit' => false
            ])
            ->setOptional([
                'edit'
            ])
        ;
    }

    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName()
    {
        return 'engishop_user';
    }
} 