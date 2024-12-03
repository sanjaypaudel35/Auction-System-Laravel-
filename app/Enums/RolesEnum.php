<?php

namespace App\Enums;

enum RolesEnum: string
{
    case SUPER_ADMIN = "super-admin";
    case CUSTOMER = "customer";
    case MASTER_ADMIN = "master-admin";

    public static function getAllValues(): array
    {
        return array_column(self::cases(), "value");
    }

    public function role(): string
    {
        return match ($this) {
            self::SUPER_ADMIN => "super-admin",
            self::CUSTOMER => "customer",
            self::MASTER_ADMIN => "master-admin",
        };
    }
}
