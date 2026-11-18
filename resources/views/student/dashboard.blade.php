<x-layouts.app title="Dashboard Siswa - SIDAKA">
    <x-slot name="header">Dashboard Siswa</x-slot>

    {{-- ═══════════════════════════════════════════════════════════
         INTRO STRIP
         ═══════════════════════════════════════════════════════════ --}}
    <div class="mb-6 sm:mb-8 flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 mb-2.5">
                <span class="w-1.5 h-1.5 rounded-full bg-accent"></span>
                <span class="font-mono text-[10px] tracking-[0.2em] uppercase text-ink-400">Ringkasan · Pribadi</span>
            </div>
            <h2 class="text-[20px] sm:text-[24px] leading-tight tracking-[-0.02em] font-semibold text-ink-900 text-balance">
                Halo, {{ auth()->user()->name }}.
            </h2>
        </div>
        <p class="max-w-sm text-[12px] text-ink-500 leading-relaxed">
            Pantau dokumen akademikmu, lacak pengajuan layanan, dan ambil dokumen yang sudah siap.
        </p>
    </div>

    {{-- ═══════════════════════════════════════════════════════════
         STAT CARDS
         ═══════════════════════════════════════════════════════════ --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-5 mb-6">

        {{-- Total Dokumen --}}
        <div class="group rounded-2xl border border-black/[0.06] bg-white/85 backdrop-blur-xl
                    shadow-[0_1px_2px_rgba(0,0,0,0.03),0_8px_24px_rgba(0,0,0,0.04)]
                    p-5 transition-all duration-300
                    hover:shadow-[0_2px_4px_rgba(0,0,0,0.04),0_16px_40px_rgba(0,0,0,0.07)]
                    hover:-translate-y-0.5">

            <div class="flex items-start justify-between gap-3 mb-5">
                <div class="w-10 h-10 rounded-xl bg-ink-900 flex items-center justify-center">
                    <svg class="w-4 h-4 text-white" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.6">
                        <path d="M5 2.5h7l3.5 3.5v11a1 1 0 01-1 1h-9.5a1 1 0 01-1-1V3.5a1 1 0 011-1z" stroke-linejoin="round"/>
                        <path d="M12 2.5v4h4" stroke-linejoin="round"/>
                        <path d="M7 11h6M7 14h4" stroke-linecap="round"/>
                    </svg>
                </div>
                <span class="font-mono text-[9px] tracking-widest uppercase text-ink-300">01</span>
            </div>

            <p class="font-mono text-[10px] tracking-[0.2em] uppercase text-ink-400">Dokumen Saya</p>
            <p class="mt-2 text-[28px] leading-none font-semibold text-ink-900 tracking-tight tabular-nums">
                {{ $stats['total_my_documents'] }}
            </p>
            <div class="mt-4 pt-4 border-t border-black/[0.05] flex items-center gap-1.5">
                <span class="w-1 h-1 rounded-full bg-accent"></span>
                <span class="text-[10px] text-ink-500 font-medium">Total arsipmu</span>
            </div>
        </div>

        {{-- Dokumen Terverifikasi --}}
        <div class="group rounded-2xl border border-emerald-500/20 bg-emerald-500/[0.03] backdrop-blur-xl
                    shadow-[0_1px_2px_rgba(0,0,0,0.03),0_8px_24px_rgba(0,0,0,0.04)]
                    p-5 transition-all duration-300
                    hover:shadow-[0_2px_4px_rgba(0,0,0,0.04),0_16px_40px_rgba(0,0,0,0.07)]
                    hover:-translate-y-0.5">

            <div class="flex items-start justify-between gap-3 mb-5">
                <div class="w-10 h-10 rounded-xl bg-emerald-500 flex items-center justify-center">
                    <svg class="w-4 h-4 text-white" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M5 10.5l3.5 3.5L15 7" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
                <span class="font-mono text-[9px] tracking-widest uppercase text-emerald-500/70">02</span>
            </div>

            <p class="font-mono text-[10px] tracking-[0.2em] uppercase text-emerald-600">Terverifikasi</p>
            <p class="mt-2 text-[28px] leading-none font-semibold text-emerald-600 tracking-tight tabular-nums">
                {{ $stats['verified_my_documents'] }}
            </p>
            <div class="mt-4 pt-4 border-t border-emerald-500/15 flex items-center gap-1.5">
                <span class="w-1 h-1 rounded-full bg-emerald-500"></span>
                <span class="text-[10px] text-emerald-700/70 font-medium">Siap digunakan</span>
            </div>
        </div>

        {{-- Pengajuan Diproses --}}
        <div class="group rounded-2xl border border-[#0A84FF]/20 bg-[#0A84FF]/[0.03] backdrop-blur-xl
                    shadow-[0_1px_2px_rgba(0,0,0,0.03),0_8px_24px_rgba(0,0,0,0.04)]
                    p-5 transition-all duration-300
                    hover:shadow-[0_2px_4px_rgba(0,0,0,0.04),0_16px_40px_rgba(0,0,0,0.07)]
                    hover:-translate-y-0.5">

            <div class="flex items-start justify-between gap-3 mb-5">
                <div class="w-10 h-10 rounded-xl bg-[#0A84FF] flex items-center justify-center">
                    <svg class="w-4 h-4 text-white" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.75">
                        <circle cx="10" cy="10" r="7.5"/>
                        <path d="M10 6v4l2.5 2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
                <span class="font-mono text-[9px] tracking-widest uppercase text-[#0A84FF]/70">03</span>
            </div>

            <p class="font-mono text-[10px] tracking-[0.2em] uppercase text-[#0055CC]">Diproses</p>
            <p class="mt-2 text-[28px] leading-none font-semibold text-[#0055CC] tracking-tight tabular-nums">
                {{ $stats['active_requests'] }}
            </p>
            <div class="mt-4 pt-4 border-t border-[#0A84FF]/15 flex items-center gap-1.5">
                <span class="w-1 h-1 rounded-full bg-[#0A84FF]"></span>
                <span class="text-[10px] text-[#0055CC]/70 font-medium">Sedang berjalan</span>
            </div>
        </div>

        {{-- Siap Diambil --}}
        <div class="group rounded-2xl border border-amber-500/20 bg-amber-500/[0.03] backdrop-blur-xl
                    shadow-[0_1px_2px_rgba(0,0,0,0.03),0_8px_24px_rgba(0,0,0,0.04)]
                    p-5 transition-all duration-300
                    hover:shadow-[0_2px_4px_rgba(0,0,0,0.04),0_16px_40px_rgba(0,0,0,0.07)]
                    hover:-translate-y-0.5">

            <div class="flex items-start justify-between gap-3 mb-5">
                <div class="w-10 h-10 rounded-xl bg-amber-500 flex items-center justify-center">
                    <svg class="w-4 h-4 text-white" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.75">
                        <path d="M10 2.5l6.5 2.8V10c0 3.7-2.8 6.4-6.5 7.5C6.3 16.4 3.5 13.7 3.5 10V5.3L10 2.5z" stroke-linejoin="round"/>
                        <path d="M7.5 10l2 2 3.5-4" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
                <span class="font-mono text-[9px] tracking-widest uppercase text-amber-500/70">04</span>
            </div>

            <p class="font-mono text-[10px] tracking-[0.2em] uppercase text-amber-600">Siap Diambil</p>
            <p class="mt-2 text-[28px] leading-none font-semibold text-amber-600 tracking-tight tabular-nums">
                {{ $stats['ready_requests'] }}
            </p>
            <div class="mt-4 pt-4 border-t border-amber-500/15 flex items-center gap-1.5">
                <span class="w-1 h-1 rounded-full bg-amber-500"></span>
                <span class="text-[10px] text-amber-700/70 font-medium">Ambil di TU</span>
            </div>
        </div>

    </div>

    {{-- ═══════════════════════════════════════════════════════════
         RECENT REQUESTS + CTA BANNER
         ═══════════════════════════════════════════════════════════ --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 sm:gap-5">

        {{-- ─── RECENT REQUESTS (2/3) ─── --}}
        <div class="lg:col-span-2 rounded-2xl border border-black/[0.06] bg-white overflow-hidden
                    shadow-[0_1px_2px_rgba(0,0,0,0.03),0_8px_24px_rgba(0,0,0,0.04)]">

            {{-- Panel header --}}
            <div class="px-5 sm:px-6 py-4 border-b border-black/[0.06] flex items-center justify-between gap-4">
                <div class="flex items-center gap-2.5">
                    <span class="w-1.5 h-1.5 rounded-full bg-accent"></span>
                    <span class="font-mono text-[10px] tracking-[0.2em] uppercase text-ink-400">Pengajuan Terbaru</span>
                </div>

                <a href="{{ route('student.service-requests.index') }}"
                   class="group inline-flex items-center gap-1.5 h-8 pl-3 pr-2.5 rounded-lg
                          text-[11px] font-medium text-ink-700
                          hover:bg-ink-900 hover:text-white
                          transition-all duration-200">
                    <span>Lihat Semua</span>
                    <svg class="w-3 h-3 opacity-60 group-hover:opacity-100 group-hover:translate-x-0.5 transition-transform duration-200"
                         viewBox="0 0 12 12" fill="none" stroke="currentColor" stroke-width="1.75">
                        <path d="M4 3l3 3-3 3" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </a>
            </div>

            {{-- Table --}}
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead class="bg-neutral-50/50 border-b border-black/[0.06]">
                        <tr>
                            <th class="px-5 sm:px-6 py-3 font-mono text-[10px] font-medium text-ink-400 uppercase tracking-wider whitespace-nowrap">No. Pengajuan</th>
                            <th class="px-5 sm:px-6 py-3 font-mono text-[10px] font-medium text-ink-400 uppercase tracking-wider whitespace-nowrap">Layanan</th>
                            <th class="px-5 sm:px-6 py-3 font-mono text-[10px] font-medium text-ink-400 uppercase tracking-wider whitespace-nowrap">Status</th>
                            <th class="px-5 sm:px-6 py-3 font-mono text-[10px] font-medium text-ink-400 uppercase tracking-wider whitespace-nowrap text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-black/[0.05]">
                        @forelse($recentMyRequests as $req)
                            <tr class="group hover:bg-neutral-50/60 transition-colors duration-150">

                                {{-- No. Pengajuan --}}
                                <td class="px-5 sm:px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center gap-2.5">
                                        <span class="w-1.5 h-1.5 rounded-full bg-neutral-300 group-hover:bg-accent transition-colors duration-300 shrink-0"></span>
                                        <span class="font-mono text-[12px] font-medium text-ink-900 tabular-nums">
                                            {{ $req->request_number }}
                                        </span>
                                    </div>
                                </td>

                                {{-- Jenis Layanan --}}
                                <td class="px-5 sm:px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center h-6 px-2 rounded-md
                                                 bg-[#EAF3FF] border border-[#0A84FF]/15
                                                 font-mono text-[10px] text-[#0055CC] tracking-wider">
                                        {{ $req->serviceType->name }}
                                    </span>
                                </td>

                                {{-- Status --}}
                                <td class="px-5 sm:px-6 py-4">
                                    <x-status-badge :status="$req->status" />
                                </td>

                                {{-- Aksi --}}
                                <td class="px-5 sm:px-6 py-4 text-right whitespace-nowrap">
                                    <div class="inline-flex items-center gap-1.5">

                                        {{-- Detail --}}
                                        <a href="{{ route('student.service-requests.show', $req) }}"
                                           class="group/btn inline-flex items-center gap-1.5 h-8 pl-3 pr-2.5 rounded-lg
                                                  bg-white border border-black/[0.08] text-ink-700
                                                  hover:bg-ink-900 hover:border-ink-900 hover:text-white
                                                  text-[11px] font-medium
                                                  transition-all duration-200">
                                            <span>Detail</span>
                                            <svg class="w-3 h-3 opacity-60 group-hover/btn:opacity-100 group-hover/btn:translate-x-0.5 transition-transform duration-200"
                                                 viewBox="0 0 12 12" fill="none" stroke="currentColor" stroke-width="1.75">
                                                <path d="M4 3l3 3-3 3" stroke-linecap="round" stroke-linejoin="round"/>
                                            </svg>
                                        </a>

                                        {{-- Scan QR (conditional) --}}
                                        @if($req->status->value === 'ready')
                                            <a href="{{ route('student.qr-scan') }}"
                                               class="inline-flex items-center gap-1.5 h-8 px-2.5 rounded-lg
                                                      bg-emerald-500 text-white border border-emerald-500
                                                      hover:bg-emerald-600 hover:border-emerald-600
                                                      text-[11px] font-medium
                                                      transition-all duration-200
                                                      shadow-[0_1px_2px_rgba(15,181,122,0.25)]">
                                                <span class="relative flex w-1.5 h-1.5">
                                                    <span class="absolute inline-flex w-full h-full rounded-full bg-white opacity-60 animate-ping"></span>
                                                    <span class="relative inline-flex w-1.5 h-1.5 rounded-full bg-white"></span>
                                                </span>
                                                <span>Scan QR</span>
                                            </a>
                                        @endif

                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-5 sm:px-6 py-14">
                                    <div class="max-w-sm mx-auto text-center">

                                        <div class="w-14 h-14 mx-auto rounded-2xl bg-neutral-50 border border-black/[0.06]
                                                    flex items-center justify-center">
                                            <svg class="w-6 h-6 text-ink-300" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                                <path d="M5 3h9l5 5v13a1 1 0 01-1 1H5a1 1 0 01-1-1V4a1 1 0 011-1z" stroke-linejoin="round"/>
                                                <path d="M14 3v5h5" stroke-linejoin="round"/>
                                                <path d="M8 13h8M8 17h5" stroke-linecap="round"/>
                                            </svg>
                                        </div>

                                        <p class="mt-5 text-[14px] font-medium text-ink-900">
                                            Belum ada pengajuan
                                        </p>
                                        <p class="mt-2 text-[12px] text-ink-500 leading-relaxed">
                                            Kamu belum pernah mengajukan layanan. Mulai dengan tombol di bawah.
                                        </p>

                                        <a href="{{ route('student.service-requests.create') }}"
                                           class="mt-5 inline-flex items-center gap-2 h-9 px-4 rounded-xl
                                                  bg-ink-900 hover:bg-ink-700 text-white
                                                  text-[11px] font-medium transition-all duration-200 active:scale-[0.98]">
                                            <svg class="w-3 h-3" viewBox="0 0 12 12" fill="none" stroke="currentColor" stroke-width="2">
                                                <path d="M6 2v8M2 6h8" stroke-linecap="round"/>
                                            </svg>
                                            <span>Buat Pengajuan Pertama</span>
                                        </a>

                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>

        {{-- ─── CTA BANNER (1/3) ─── --}}
        <div class="relative overflow-hidden rounded-2xl bg-ink-900 p-6 sm:p-7
                    shadow-[0_2px_4px_rgba(0,0,0,0.06),0_16px_40px_rgba(0,0,0,0.15)]
                    flex flex-col">

            {{-- Dot pattern --}}
            <div class="absolute inset-0 opacity-[0.08]"
                 style="background-image: radial-gradient(circle, white 1px, transparent 1px); background-size: 20px 20px;"
                 aria-hidden="true"></div>

            {{-- Accent glow --}}
            <div class="absolute -top-20 -right-20 w-56 h-56 rounded-full bg-accent/30 blur-[80px] pointer-events-none"
                 aria-hidden="true"></div>

            <div class="relative flex-1">

                {{-- Badge --}}
                <div class="inline-flex items-center gap-2 h-7 px-2.5 rounded-full
                            bg-white/[0.06] border border-white/[0.10]">
                    <span class="w-1.5 h-1.5 rounded-full bg-accent"></span>
                    <span class="font-mono text-[9px] tracking-[0.2em] uppercase text-white/70">
                        Layanan Administrasi
                    </span>
                </div>

                {{-- Headline --}}
                <h3 class="mt-5 text-[20px] sm:text-[22px] font-semibold text-white tracking-tight leading-tight text-balance">
                    Butuh dokumen akademik?
                </h3>
                <p class="mt-3 text-[12.5px] text-white/60 leading-relaxed">
                    Ajukan pengambilan Ijazah, Sertifikat, Legalisir, atau peminjaman Rapor dalam satu kali pengajuan digital.
                </p>

                {{-- Feature list --}}
                <ul class="mt-6 space-y-2.5">
                    <li class="flex items-center gap-2.5">
                        <span class="shrink-0 w-4 h-4 rounded-full border border-white/20 flex items-center justify-center">
                            <svg class="w-2.5 h-2.5 text-white" viewBox="0 0 12 12" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M2 6 L5 9 L10 3" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </span>
                        <span class="text-[11.5px] text-white/75">Tanpa antre &amp; tanpa formulir kertas</span>
                    </li>
                    <li class="flex items-center gap-2.5">
                        <span class="shrink-0 w-4 h-4 rounded-full border border-white/20 flex items-center justify-center">
                            <svg class="w-2.5 h-2.5 text-white" viewBox="0 0 12 12" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M2 6 L5 9 L10 3" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </span>
                        <span class="text-[11.5px] text-white/75">Lacak status secara real-time</span>
                    </li>
                    <li class="flex items-center gap-2.5">
                        <span class="shrink-0 w-4 h-4 rounded-full border border-white/20 flex items-center justify-center">
                            <svg class="w-2.5 h-2.5 text-white" viewBox="0 0 12 12" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M2 6 L5 9 L10 3" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </span>
                        <span class="text-[11.5px] text-white/75">Konfirmasi penyerahan via QR</span>
                    </li>
                </ul>

            </div>

            {{-- CTA button --}}
            <a href="{{ route('student.service-requests.create') }}"
               class="relative mt-7 inline-flex items-center justify-center gap-2 h-11 rounded-xl
                      bg-white text-ink-900 text-[12px] font-medium
                      hover:bg-white/90 transition-all duration-200 active:scale-[0.98]">
                <svg class="w-3.5 h-3.5" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M10 4v12M4 10h12" stroke-linecap="round"/>
                </svg>
                <span>Buat Pengajuan Baru</span>
            </a>

        </div>

    </div>

    {{-- Footer note --}}
    <div class="mt-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 px-1">
        <span class="font-mono text-[10px] tracking-[0.2em] uppercase text-ink-400">
            SIDAKA · Dashboard Siswa v2.0
        </span>
        <span class="font-mono text-[10px] tracking-[0.2em] uppercase text-ink-400 tabular-nums">
            {{ now()->format('d/m/Y H:i') }} WIB
        </span>
    </div>

</x-layouts.app>