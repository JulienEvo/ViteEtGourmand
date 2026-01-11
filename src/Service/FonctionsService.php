<?php

namespace App\Service;

class FonctionsService
{
    public static function p($tableau)
    {
        echo "<pre>";
        print_r($tableau);
        echo "</pre>";
    }

    public static function formatTelFr(?string $phone): ?string
    {
        if (!$phone) {
            return null;
        }

        $phone = preg_replace('/\D+/', '', $phone);

        if (strlen($phone) === 10 && str_starts_with($phone, '0')) {
            return trim(chunk_split($phone, 2, ' '));
        }

        if (strlen($phone) === 11 && str_starts_with($phone, '33')) {
            return trim(chunk_split('0' . substr($phone, 2), 2, ' '));
        }

        return null;
    }
}
