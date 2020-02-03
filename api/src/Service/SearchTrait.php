<?php

namespace App\Service;

/**
 * Trait SearchTrait.
 */
trait SearchTrait
{
    /**
     * @param $array
     * @param $index
     * @param $value
     *
     * @return object|null
     */
    public function entityArraySearch($array, $index, $value)
    {
        if (0 === count($array))
        {
            return null;
        }

        foreach ($array as $array_inf)
        {
            if ($array_inf->$index() == $value)
            {
                return $array_inf;
            }
        }

        return null;
    }

    /**
     * @param $array
     * @param $index
     * @param $value
     *
     * @return object|null
     */
    public function objArraySearch($array, $index, $value)
    {
        if (0 === count($array))
        {
            return null;
        }

        foreach ($array as $array_inf)
        {
            if ($array_inf->{$index} == $value)
            {
                return $array_inf;
            }
        }

        return null;
    }
}
