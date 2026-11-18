<?php

namespace App\Enums;

enum DocumentVerificationStatus: string
{
    case PENDING_TU        = 'pending_tu';         // Siswa submit, menunggu verifikasi berkas oleh TU
    case PENDING_KURIKULUM = 'pending_kurikulum';  // TU loloskan, menunggu crosscheck akhir oleh Kurikulum
    case VERIFIED          = 'verified';           // Sah & terverifikasi total oleh Kurikulum
    case REJECTED          = 'rejected';           // Ditolak (oleh TU atau Kurikulum)

    public function label(): string
    {
        return match ($this) {
            self::PENDING_TU        => 'Menunggu Verifikasi TU',
            self::PENDING_KURIKULUM => 'Menunggu Verifikasi Kurikulum',
            self::VERIFIED          => 'Terverifikasi (Sah)',
            self::REJECTED          => 'Ditolak',
        };
    }

    public function badgeClass(): string
    {
        return match ($this) {
            self::PENDING_TU        => 'bg-amber-50 text-amber-700 border-amber-200',
            self::PENDING_KURIKULUM => 'bg-blue-50 text-blue-700 border-blue-200',
            self::VERIFIED          => 'bg-emerald-50 text-emerald-700 border-emerald-200',
            self::REJECTED          => 'bg-rose-50 text-rose-700 border-rose-200',
        };
    }
}