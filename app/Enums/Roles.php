<?php

namespace App\Enums;

use Spatie\Enum\Laravel\Enum;
/**
 * @method static self ADMIN()
 * @method static self CLIENT()
 */
final class Roles extends Enum
{
    protected static function values(): array
    {
        return [
            'ADMIN'  => 'admin',
            'CLIENT'      => 'client',
        ];
    }
    
    protected static function labels(): array
    {
        return [
            'ADMIN' => 'Admin',
            'CLIENT'     => 'Client',
        ];
    }

    final public static function all()
    {
        return array_values(self::values());
    }
}
