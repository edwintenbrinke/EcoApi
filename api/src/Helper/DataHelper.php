<?php


namespace App\Helper;


class DataHelper
{
    public static function getUsername(array $data)
    {
        if (isset($data['Username']))
        {
            return $data['Username'];
        }
        if (isset($data['ActorId']))
        {
            return $data['ActorId'];
        }
        return 'Not found';
    }
}
