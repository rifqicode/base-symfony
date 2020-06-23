<?php

declare(strict_types=1);

namespace KejawenLab\Semart\Skeleton\Util;

/**
 * @author Agus Abrianto <agusabrianto@gmail.com>
 */
class StringUtil
{
    public static function uppercase(string $value): string
    {
        return strtoupper($value);
    }

    public static function lowercase(string $value): string
    {
        return strtolower($value);
    }
}
