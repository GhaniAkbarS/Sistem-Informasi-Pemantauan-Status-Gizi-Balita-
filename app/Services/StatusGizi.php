<?php

namespace App\Services;

final class StatusGizi
{
    public const NORMAL = 'Gizi Normal';
    public const KURANG = 'Gizi Kurang';
    public const LEBIH = 'Gizi Lebih';
    public const STUNTING = 'Stunting';
    public const NORMAL_DATABASE_VALUES = [self::NORMAL, 'Gizi Baik'];
    public const PERLU_TINJAU_DATABASE_VALUES = [self::KURANG, self::LEBIH, self::STUNTING];

    public static function label(?string $status): string
    {
        return match ($status) {
            'Gizi Baik' => self::NORMAL,
            default => $status ?? 'Belum tersedia',
        };
    }

    public static function perluTindakLanjut(?string $status): bool
    {
        return in_array(self::label($status), self::PERLU_TINJAU_DATABASE_VALUES, true);
    }
}
