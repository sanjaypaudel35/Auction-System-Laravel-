<?php

namespace App\Enums;

enum ImageTypeEnums: string
{
    case PRODUCT = "product";
    case IMAGE_FOLDER = "images";

    public static function getAllValues(): array
    {
        return array_column(self::cases(), "value");
    }
}
