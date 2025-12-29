<?php

namespace App\Service;

class FonctionsService
{
    public function formatTelFr(?string $phone): ?string
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
