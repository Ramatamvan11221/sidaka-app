<?php

namespace App\Services;

use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class QRService
{
    public function generateQrSvg(?string $token): string
    {
        $validToken = $token ?? Str::uuid()->toString();

        return QrCode::format('svg')
            ->size(220)
            ->margin(1)
            ->errorCorrection('H')
            ->generate($validToken);
    }
}