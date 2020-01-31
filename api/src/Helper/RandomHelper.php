<?php

namespace App\Helper;

class RandomHelper
{
    /**
     * @param int $length
     *
     * @return string
     *
     * @throws \Exception
     */
    public static function generateRandomString($length = 10)
    {
        return bin2hex(random_bytes($length / 2));
    }
}
