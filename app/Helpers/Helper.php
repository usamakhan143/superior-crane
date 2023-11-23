<?php

namespace App\Helpers;

class Helper
{
    public static function getRoles()
    {
        $roles = [
            'a' => 'admin',
            'sa' => 'super_admin',
            'm' => 'manager',
            'bu' => 'user',
        ];

        return $roles;
    }
}
