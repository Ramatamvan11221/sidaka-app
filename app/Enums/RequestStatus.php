<?php

namespace App\Enums;

enum RequestStatus: string
{
    case PENDING           = 'pending';
    case PENDING_TU        = 'pending_tu';
    case PENDING_KURIKULUM = 'pending_kurikulum';
    case VERIFIED          = 'verified';
    case APPROVED          = 'approved';
    case REJECTED          = 'rejected';
    case PREPARING         = 'preparing';
    case READY             = 'ready';
    case COMPLETED         = 'completed';
    case BORROWED          = 'borrowed';
    case RETURNED          = 'returned';

    public function label(): string
    {
        return match($this) {
            self::PENDING           => 'Menunggu',
            self::PENDING_TU        => 'Verifikasi TU',
            self::PENDING_KURIKULUM => 'Validasi Kurikulum',
            self::VERIFIED          => 'Terverifikasi (Sah)',
            self::APPROVED          => 'Disetujui',
            self::REJECTED          => 'Ditolak',
            self::PREPARING         => 'Sedang Diproses',
            self::READY             => 'Siap Diambil',
            self::COMPLETED         => 'Selesai',
            self::BORROWED          => 'Dipinjam',
            self::RETURNED          => 'Dikembalikan',
        };
    }

    public function badgeClass(): string
    {
        return match($this) {
            self::PENDING, self::PENDING_TU => 'bg-amber-50 text-amber-700 border-amber-200',
            self::PENDING_KURIKULUM        => 'bg-blue-50 text-blue-700 border-blue-200',
            self::VERIFIED, self::APPROVED  => 'bg-emerald-50 text-emerald-700 border-emerald-200',
            self::REJECTED                 => 'bg-rose-50 text-rose-700 border-rose-200',
            self::PREPARING                => 'bg-indigo-50 text-indigo-700 border-indigo-200',
            self::READY                    => 'bg-emerald-50 text-emerald-700 border-emerald-200',
            self::COMPLETED                => 'bg-neutral-50 text-neutral-700 border-neutral-200',
            self::BORROWED                 => 'bg-violet-50 text-violet-700 border-violet-200',
            self::RETURNED                 => 'bg-teal-50 text-teal-700 border-teal-200',
        };
    }
}