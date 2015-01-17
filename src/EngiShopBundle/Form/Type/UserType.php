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
            ->add('username', 'text', ['label' => 'Nazwa użytkownika'])
            ->add('email')
            ->add('password', 'repeated', [
                'type' => 'password',
                'invalid_message' => 'Hasła muszą być jednakowe',
                'first_options' => ['label' => 'Hasło'],
                'second_options' => ['label' => 'Powtórz hasło'],
                'required' => !$options['edit']
            ])
            ->add('firstName', 'text', ['label' => 'Imię'])
            ->add('lastName', 'text', ['label' => 'Nazwisko'])
            ->add('address', 'text', ['label' => 'Adres'])
            ->add('address2', 'text', ['label' => 'Adres c. d.'])
            ->add('zip', 'text', ['label' => 'Kod pocztowy'])
            ->add('city', 'text', ['label' => 'Miasto'])
            ->add('state', 'text', ['label' => 'Województwo'])
            ->add('country', 'country', [
                'label' => 'Kraj',
                'data' => $options['edit'] ? $builder->getForm()->getData()->getCountry() : 'PL'
            ])
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