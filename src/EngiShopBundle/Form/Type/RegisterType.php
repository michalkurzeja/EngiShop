<?php

namespace EngiShopBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Security\Core\Validator\Constraints\UserPassword;

class RegisterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        if (!$options['edit']) $builder->add('username', 'text', ['label' => 'Nazwa użytkownika']);
        if ($options['edit']) {
            $builder->add('oldPassword', 'password', [
                'label' => 'Obecne hasło',
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new UserPassword(['message' => 'Niepoprawne hasło.', 'groups' => ['change_password']])
                ]
            ]);
        }

        $builder
            ->add('email')
            ->add('newPassword', 'repeated', [
                'type' => 'password',
                'invalid_message' => 'Hasła muszą być jednakowe',
                'first_options' => ['label' => 'Hasło'],
                'second_options' => ['label' => 'Powtórz hasło'],
                'required' => !$options['edit'],
                'mapped' => false
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
            ]);
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver
            ->setDefaults([
                'data_class' => 'EngiShopBundle\Entity\User',
                'edit' => false,
                'validation_groups' => function(FormInterface $form) {
                    $newPassword = $form['newPassword']->getData();
                    if (!empty($newPassword)) {
                        return ['change_password'];
                    }

                    return ['Default'];
                }
            ])
            ->setOptional([
                'edit'
            ]);
    }

    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName()
    {
        return 'engishop_register';
    }
}