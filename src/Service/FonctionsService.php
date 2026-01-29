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

    public static function distanceKm($lat1, $lon1, $lat2, $lon2): float
    {
        $earthRadius = 6371;

        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);

        $a = sin($dLat/2) * sin($dLat/2) +
            cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
            sin($dLon/2) * sin($dLon/2);

        $c = 2 * atan2(sqrt($a), sqrt(1-$a));

        return round($earthRadius * $c, 2);
    }

}
