<?php

namespace EngiShopBundle\Validator\Constraints;

use InvalidArgumentException;
use Symfony\Component\Validator\Constraints\AbstractComparisonValidator;

class NotEqualToArrayValidator extends AbstractComparisonValidator
{
    /**
     * {@inheritdoc}
     */
    protected function compareValues($value1, $value2)
    {
        if (!is_array($value2)) throw new InvalidArgumentException;

        foreach ($value2 as $val) {
            if ($value1 == $val) return false;
        }

        return true;
    }
}