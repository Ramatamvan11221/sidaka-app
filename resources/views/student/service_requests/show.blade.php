<x-layouts.app title="Detail Pengajuan Saya - SIDAKA">
    <x-slot name="header">Detail Pengajuan #{{ $serviceRequest->request_number }}</x-slot>

    {{-- ═══════════════════════════════════════════════════════════
         BACK LINK + INTRO
         ═══════════════════════════════════════════════════════════ --}}
    <div class="mb-6 sm:mb-8">
        <a href="{{ route('student.service-requests.index') }}"
           class="group inline-flex items-center gap-2 h-8 pr-3 pl-2.5 -ml-2 rounded-lg
                  text-[11px] font-medium text-ink-500 hover:text-ink-900 hover:bg-black/[0.04]
                  transition-all duration-200">
            <svg class="w-3.5 h-3.5 opacity-70 group-hover:-translate-x-0.5 transition-transform duration-200"
                 viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.75">
                <path d="M13 8H3M7 4L3 8l4 4" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            <span>Kembali ke Riwayat</span>
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-5 sm:gap-6">

        {{-- ═══════════════════════════════════════════════════════════
             KOLOM KIRI (2/3) — Detail Utama
             ═══════════════════════════════════════════════════════════ --}}
        <div class="lg:col-span-2 space-y-5">

            {{-- ─── CARD: IDENTITAS PENGAJUAN ─── --}}
            <div class="rounded-2xl border border-black/[0.06] bg-white/85 backdrop-blur-xl
                        shadow-[0_1px_2px_rgba(0,0,0,0.03),0_8px_24px_rgba(0,0,0,0.04)]
                        overflow-hidden">

                {{-- Panel header --}}
                <div class="px-5 sm:px-6 py-4 border-b border-black/[0.06] flex items-center justify-between gap-4">
                    <div class="flex items-center gap-2.5">
                        <span class="w-1.5 h-1.5 rounded-full bg-accent"></span>
                        <span class="font-mono text-[10px] tracking-[0.2em] uppercase text-ink-400">Informasi Pengajuan</span>
                    </div>
                    <span class="font-mono text-[9px] tracking-widest uppercase text-ink-300">01</span>
                </div>

                {{-- Nomor + status --}}
                <div class="px-5 sm:px-6 py-5 border-b border-black/[0.06] flex flex-wrap items-center justify-between gap-4">
                    <div class="min-w-0">
                        <p class="font-mono text-[10px] tracking-[0.2em] uppercase text-ink-400">Nomor Pengajuan</p>
                        <h3 class="mt-1.5 font-mono text-[18px] sm:text-[20px] font-medium text-ink-900 tabular-nums tracking-tight">
                            {{ $serviceRequest->request_number }}
                        </h3>
                    </div>
                    <x-status-badge :status="$serviceRequest->status" />
                </div>

                {{-- Info grid --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-px bg-black/[0.06]">
                    <div class="bg-white px-5 sm:px-6 py-4">
                        <p class="font-mono text-[10px] tracking-wider uppercase text-ink-400">Jenis Layanan</p>
                        <p class="mt-1.5 text-[13px] font-medium text-[#0055CC]">
                            {{ $serviceRequest->serviceType->name }}
                        </p>
                    </div>
                    <div class="bg-white px-5 sm:px-6 py-4">
                        <p class="font-mono text-[10px] tracking-wider uppercase text-ink-400">Tanggal Pengajuan</p>
                        <p class="mt-1.5 text-[13px] font-medium text-ink-900">
                            {{ $serviceRequest->created_at->format('d F Y H:i') }}
                        </p>
                    </div>
                </div>

                {{-- Keperluan --}}
                <div class="px-5 sm:px-6 py-5 border-t border-black/[0.06]">
                    <div class="flex items-center gap-2 mb-3">
                        <span class="w-1.5 h-1.5 rounded-full bg-accent"></span>
                        <span class="font-mono text-[10px] tracking-[0.2em] uppercase text-ink-400">Keperluan</span>
                    </div>
                    <div class="rounded-xl border border-black/[0.06] bg-neutral-50/60 px-4 py-3.5">
                        <p class="text-[13px] text-ink-700 leading-relaxed">
                            {{ $serviceRequest->purpose }}
                        </p>
                    </div>
                </div>

                {{-- Admin Notes (conditional) --}}
                @if($serviceRequest->admin_notes)
                    <div class="px-5 sm:px-6 py-5 border-t border-black/[0.06]">
                        <div class="flex items-center gap-2 mb-3">
                            <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                            <span class="font-mono text-[10px] tracking-[0.2em] uppercase text-amber-600">Catatan Petugas</span>
                        </div>
                        <div class="rounded-xl border border-amber-500/20 bg-amber-500/[0.05] px-4 py-3.5">
                            <div class="flex items-start gap-3">
                                <div class="shrink-0 w-6 h-6 rounded-lg bg-amber-500/10 border border-amber-500/15
                                            flex items-center justify-center mt-0.5">
                                    <svg class="w-3 h-3 text-amber-600" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.75">
                                        <path d="M8 4v5M8 11h.01" stroke-linecap="round"/>
                                        <circle cx="8" cy="8" r="6.5"/>
                                    </svg>
                                </div>
                                <p class="text-[13px] text-amber-800 leading-relaxed">
                                    {{ $serviceRequest->admin_notes }}
                                </p>
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            {{-- ─── CARD: DOKUMEN TERKAIT ─── --}}
            <div class="rounded-2xl border border-black/[0.06] bg-white/85 backdrop-blur-xl
                        shadow-[0_1px_2px_rgba(0,0,0,0.03),0_8px_24px_rgba(0,0,0,0.04)]
                        overflow-hidden">

                {{-- Panel header --}}
                <div class="px-5 sm:px-6 py-4 border-b border-black/[0.06] flex items-center justify-between gap-4">
                    <div class="flex items-center gap-2.5">
                        <span class="w-1.5 h-1.5 rounded-full bg-accent"></span>
                        <span class="font-mono text-[10px] tracking-[0.2em] uppercase text-ink-400">Dokumen Terkait</span>
                    </div>
                    <span class="font-mono text-[9px] tracking-widest uppercase text-ink-400 tabular-nums">
                        {{ $serviceRequest->items->count() }} dokumen
                    </span>
                </div>

                {{-- List dokumen --}}
                <div class="divide-y divide-black/[0.05]">
                    @foreach($serviceRequest->items as $item)
                        <div class="group px-5 sm:px-6 py-4
                                    hover:bg-neutral-50/50 transition-colors duration-150">
                            <div class="flex items-center gap-4">

                                {{-- Icon box --}}
                                <div class="shrink-0 w-10 h-10 rounded-xl bg-neutral-100 border border-black/[0.06]
                                            flex items-center justify-center
                                            group-hover:bg-ink-900 group-hover:border-ink-900
                                            transition-colors duration-300">
                                    <svg class="w-4 h-4 text-ink-500 group-hover:text-white transition-colors duration-300"
                                         viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.6">
                                        <path d="M5 2.5h7l3.5 3.5v11a1 1 0 01-1 1h-9.5a1 1 0 01-1-1V3.5a1 1 0 011-1z" stroke-linejoin="round"/>
                                        <path d="M12 2.5v4h4" stroke-linejoin="round"/>
                                        <path d="M7 11h6M7 14h4" stroke-linecap="round"/>
                                    </svg>
                                </div>

                                {{-- Text --}}
                                <div class="min-w-0 flex-1">
                                    <p class="text-[13px] font-medium text-ink-900 leading-snug truncate">
                                        {{ $item->document->title }}
                                    </p>
                                    <p class="mt-0.5 font-mono text-[10px] tracking-wider uppercase text-ink-400">
                                        {{ $item->document->documentType->name }}
                                    </p>
                                </div>

                                {{-- Action --}}
                                <a href="{{ route('documents.stream', $item->document) }}" target="_blank"
                                   class="shrink-0 group/btn inline-flex items-center gap-1.5 h-8 pl-3 pr-2.5 rounded-lg
                                          bg-white border border-black/[0.08] text-ink-700
                                          hover:bg-ink-900 hover:border-ink-900 hover:text-white
                                          text-[11px] font-medium
                                          transition-all duration-200">
                                    <span class="hidden sm:inline">Lihat</span>
                                    <svg class="w-3 h-3 opacity-60 group-hover/btn:opacity-100 group-hover/btn:translate-x-0.5 transition-transform duration-200"
                                         viewBox="0 0 12 12" fill="none" stroke="currentColor" stroke-width="1.75">
                                        <path d="M4 3l3 3-3 3" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </a>

                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

        </div>

        {{-- ═══════════════════════════════════════════════════════════
             KOLOM KANAN (1/3) — Sidebar Action + Timeline
             ═══════════════════════════════════════════════════════════ --}}
        <div class="space-y-5">

            {{-- ─── ACTION CARD (conditional: status === 'ready') ─── --}}
            @if($serviceRequest->status->value === 'ready')
                <div class="relative overflow-hidden rounded-2xl
                            bg-emerald-500
                            shadow-[0_2px_4px_rgba(15,181,122,0.15),0_16px_40px_rgba(15,181,122,0.25)]">

                    {{-- Dot pattern --}}
                    <div class="absolute inset-0 opacity-[0.08]"
                         style="background-image: radial-gradient(circle, white 1px, transparent 1px); background-size: 18px 18px;"
                         aria-hidden="true"></div>

                    {{-- Ambient glow --}}
                    <div class="absolute -top-16 -right-16 w-40 h-40 rounded-full bg-white/20 blur-3xl pointer-events-none"
                         aria-hidden="true"></div>

                    <div class="relative p-6">
                        <div class="flex items-center gap-2 mb-4">
                            <span class="relative flex w-2 h-2">
                                <span class="absolute inline-flex w-full h-full rounded-full bg-white opacity-60 animate-ping"></span>
                                <span class="relative inline-flex w-2 h-2 rounded-full bg-white"></span>
                            </span>
                            <span class="font-mono text-[10px] tracking-[0.2em] uppercase text-white/80">Aksi Diperlukan</span>
                        </div>

                        <h4 class="text-[17px] sm:text-[18px] font-semibold text-white tracking-tight leading-tight">
                            Dokumen siap diambil
                        </h4>
                        <p class="mt-2 text-[12px] text-white/80 leading-relaxed">
                            Pindai QR Code di monitor petugas TU untuk mengonfirmasi penyerahan dokumen fisik.
                        </p>

                        <a href="{{ route('student.qr-scan') }}"
                           class="mt-5 w-full inline-flex items-center justify-center gap-2 h-11 rounded-xl
                                  bg-white text-emerald-700 text-[12px] font-medium
                                  hover:bg-white/95 transition-all duration-200 active:scale-[0.98]">
                            <svg class="w-3.5 h-3.5" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.75">
                                <rect x="3" y="3" width="5" height="5" rx="1"/>
                                <rect x="12" y="3" width="5" height="5" rx="1"/>
                                <rect x="3" y="12" width="5" height="5" rx="1"/>
                                <path d="M12 12h2v2h-2zM16 12h1M12 16h1M14 14h1M17 17h1M17 14h1M14 17h1" stroke-linecap="round"/>
                            </svg>
                            <span>Buka Scanner HP</span>
                        </a>

                        {{-- Technical marker --}}
                        <p class="mt-3 font-mono text-[9px] tracking-[0.2em] uppercase text-white/50 text-center">
                            Konfirmasi penyerahan · 1 langkah
                        </p>
                    </div>
                </div>
            @endif

            {{-- ─── TIMELINE CARD ─── --}}
            <div class="rounded-2xl border border-black/[0.06] bg-white/85 backdrop-blur-xl
                        shadow-[0_1px_2px_rgba(0,0,0,0.03),0_8px_24px_rgba(0,0,0,0.04)]
                        overflow-hidden">

                {{-- Panel header --}}
                <div class="px-5 sm:px-6 py-4 border-b border-black/[0.06] flex items-center justify-between gap-4">
                    <div class="flex items-center gap-2.5">
                        <span class="w-1.5 h-1.5 rounded-full bg-accent"></span>
                        <span class="font-mono text-[10px] tracking-[0.2em] uppercase text-ink-400">Riwayat Status</span>
                    </div>
                    <span class="font-mono text-[9px] tracking-widest uppercase text-ink-400 tabular-nums">
                        {{ $serviceRequest->statusHistories->count() }} entri
                    </span>
                </div>

                {{-- Timeline --}}
                <div class="p-5 sm:p-6">
                    <ol class="relative space-y-5 pl-5">

                        {{-- Vertical line --}}
                        <span class="absolute left-[4px] top-2 bottom-2 w-px bg-black/[0.08]" aria-hidden="true"></span>

                        @foreach($serviceRequest->statusHistories as $history)
                            <li class="relative">
                                {{-- Dot --}}
                                <span class="absolute -left-5 top-[6px] w-[9px] h-[9px] rounded-full
                                             bg-white border-[1.5px] border-ink-900"></span>

                                {{-- Status badge --}}
                                <div class="flex flex-wrap items-center gap-2 mb-1">
                                    <x-status-badge :status="$history->status" />
                                </div>

                                {{-- Waktu --}}
                                <p class="font-mono text-[10px] text-ink-400 tabular-nums tracking-wider">
                                    {{ $history->created_at->format('d/m/Y H:i') }} WIB
                                </p>

                                {{-- Notes --}}
                                @if($history->notes)
                                    <p class="mt-2 text-[11.5px] text-ink-600 leading-relaxed pl-2 border-l border-black/[0.06]">
                                        {{ $history->notes }}
                                    </p>
                                @endif
                            </li>
                        @endforeach

                    </ol>
                </div>
            </div>

        </div>

    </div>

    {{-- Footer note --}}
    <div class="mt-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 px-1">
        <span class="font-mono text-[10px] tracking-[0.2em] uppercase text-ink-400">
            SIDAKA · Detail v2.0
        </span>
        <span class="font-mono text-[10px] tracking-[0.2em] uppercase text-ink-400">
            Diperbarui {{ $serviceRequest->updated_at->format('d/m/Y H:i') }}
        </span>
    </div>

</x-layouts.app>