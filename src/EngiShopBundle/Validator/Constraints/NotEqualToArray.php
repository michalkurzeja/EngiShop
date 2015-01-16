<?php

namespace EngiShopBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraints\AbstractComparison;

class NotEqualToArray extends AbstractComparison
{
    public $message = '{{ value }} jest zastrzeżonym adresem. Wybierz inny.';
}