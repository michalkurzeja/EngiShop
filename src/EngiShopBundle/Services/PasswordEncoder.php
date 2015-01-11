<?php

namespace EngiShopBundle\Services;

use EngiShopBundle\Entity\User;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;

class PasswordEncoder
{
    private $encoderFactory;

    public function __construct(EncoderFactoryInterface $encoderFactory)
    {
        $this->encoderFactory = $encoderFactory;
    }

    public function encodePassword(User $user, $plainPassword = null)
    {
        if (!$plainPassword) $plainPassword = $user->getPassword();

        return $this->encoderFactory->getEncoder($user)->encodePassword($plainPassword, $user->getSalt());
    }
}