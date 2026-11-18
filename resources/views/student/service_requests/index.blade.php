<x-layouts.app title="Pengajuan Saya - SIDAKA">
    <x-slot name="header">Riwayat Pengajuan Layanan Saya</x-slot>

    {{-- ═══════════════════════════════════════════════════════════
         INTRO + ACTION STRIP
         ═══════════════════════════════════════════════════════════ --}}
    <div class="mb-6 sm:mb-8 flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 mb-2.5">
                <span class="w-1.5 h-1.5 rounded-full bg-accent"></span>
                <span class="font-mono text-[10px] tracking-[0.2em] uppercase text-ink-400">Riwayat · Pribadi</span>
            </div>
            <h2 class="text-[20px] sm:text-[24px] leading-tight tracking-[-0.02em] font-semibold text-ink-900 text-balance">
                Semua pengajuan layananmu.
            </h2>
            <p class="mt-2 max-w-lg text-[12px] text-ink-500 leading-relaxed">
                Pantau proses verifikasi berjenjang (TU &amp; Kurikulum), cek riwayat, dan lakukan scan QR saat dokumen siap diambil.
            </p>
        </div>

        {{-- Create button --}}
        <a href="{{ route('student.service-requests.create') }}"
           class="shrink-0 inline-flex items-center justify-center gap-2 h-11 px-5 rounded-xl
                  bg-ink-900 hover:bg-ink-700 text-white text-[12px] font-medium
                  transition-all duration-200 active:scale-[0.98]">
            <svg class="w-3.5 h-3.5" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M10 4v12M4 10h12" stroke-linecap="round"/>
            </svg>
            <span>Buat Pengajuan Baru</span>
        </a>
    </div>

    {{-- ═══════════════════════════════════════════════════════════
         TABLE PANEL
         ═══════════════════════════════════════════════════════════ --}}
    <div class="rounded-2xl border border-black/[0.06] bg-white overflow-hidden
                shadow-[0_1px_2px_rgba(0,0,0,0.03),0_8px_24px_rgba(0,0,0,0.04)]">

        {{-- Panel header --}}
        <div class="px-5 sm:px-6 py-4 border-b border-black/[0.06] flex items-center justify-between gap-4">
            <div class="flex items-center gap-2.5">
                <span class="w-1.5 h-1.5 rounded-full bg-accent"></span>
                <span class="font-mono text-[10px] tracking-[0.2em] uppercase text-ink-400">Daftar Pengajuan</span>
            </div>
            <span class="font-mono text-[10px] tracking-wider uppercase text-ink-400 tabular-nums">
                {{ $serviceRequests->total() }} entri
            </span>
        </div>

        {{-- Table --}}
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-neutral-50/50 border-b border-black/[0.06]">
                    <tr>
                        <th class="px-5 sm:px-6 py-3 font-mono text-[10px] font-medium text-ink-400 uppercase tracking-wider whitespace-nowrap">No. Pengajuan</th>
                        <th class="px-5 sm:px-6 py-3 font-mono text-[10px] font-medium text-ink-400 uppercase tracking-wider whitespace-nowrap">Jenis Layanan</th>
                        <th class="px-5 sm:px-6 py-3 font-mono text-[10px] font-medium text-ink-400 uppercase tracking-wider whitespace-nowrap">Status Transaksi</th>
                        <th class="px-5 sm:px-6 py-3 font-mono text-[10px] font-medium text-ink-400 uppercase tracking-wider whitespace-nowrap">Tgl Pengajuan</th>
                        <th class="px-5 sm:px-6 py-3 font-mono text-[10px] font-medium text-ink-400 uppercase tracking-wider whitespace-nowrap text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-black/[0.05]">
                    @forelse($serviceRequests as $req)
                        @php
                            $statusEnum = is_string($req->status)
                                ? (\App\Enums\DocumentVerificationStatus::tryFrom($req->status) ?? \App\Enums\RequestStatus::tryFrom($req->status))
                                : $req->status;
                            $statusVal = $statusEnum?->value ?? (string)$req->status;
                        @endphp
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
                                    {{ $req->serviceType->name ?? '-' }}
                                </span>
                            </td>

                            {{-- Status Badge --}}
                            <td class="px-5 sm:px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[11px] font-medium border {{ method_exists($statusEnum, 'badgeClass') ? $statusEnum->badgeClass() : 'bg-neutral-100 text-neutral-600 border-neutral-200' }}">
                                    {{ method_exists($statusEnum, 'label') ? $statusEnum->label() : ucfirst($statusVal) }}
                                </span>
                            </td>

                            {{-- Tgl Pengajuan --}}
                            <td class="px-5 sm:px-6 py-4 whitespace-nowrap">
                                <div class="leading-tight">
                                    <p class="font-mono text-[11px] text-ink-700 tabular-nums">
                                        {{ $req->created_at->format('d/m/Y') }}
                                    </p>
                                    <p class="font-mono text-[10px] text-ink-400 tabular-nums mt-0.5">
                                        {{ $req->created_at->format('H:i') }}
                                    </p>
                                </div>
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

                                    {{-- Scan QR ( conditional: hanya jika status 'ready' ) --}}
                                    @if($statusVal === 'ready')
                                        <a href="{{ route('student.qr-scan') }}"
                                           class="group/scan inline-flex items-center gap-1.5 h-8 px-2.5 rounded-lg
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
                            <td colspan="5" class="px-5 sm:px-6 py-16">
                                <div class="max-w-sm mx-auto text-center">
                                    <div class="w-16 h-16 mx-auto rounded-2xl bg-neutral-50 border border-black/[0.06]
                                                flex items-center justify-center">
                                        <svg class="w-7 h-7 text-ink-300" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                            <path d="M6 2.5h8.5L19 7v14a1 1 0 01-1 1H6a1 1 0 01-1-1V3.5a1 1 0 011-1z" stroke-linejoin="round"/>
                                            <path d="M14.5 2.5V7H19" stroke-linejoin="round"/>
                                            <path d="M9 13h6M9 16h4" stroke-linecap="round"/>
                                        </svg>
                                    </div>

                                    <p class="mt-5 text-[14px] font-medium text-ink-900">
                                        Belum ada pengajuan
                                    </p>
                                    <p class="mt-2 text-[12px] text-ink-500 leading-relaxed">
                                        Kamu belum pernah membuat pengajuan layanan. Mulai dengan menekan tombol di bawah.
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
                    @endempty
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($serviceRequests->hasPages())
            <div class="px-5 sm:px-6 py-4 border-t border-black/[0.06] bg-neutral-50/30">
                {{ $serviceRequests->links() }}
            </div>
        @endif

    </div>

    {{-- Footer note --}}
    <div class="mt-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 px-1">
        <span class="font-mono text-[10px] tracking-[0.2em] uppercase text-ink-400">
            SIDAKA · Pengajuan v2.0
        </span>
        <span class="font-mono text-[10px] tracking-[0.2em] uppercase text-ink-400">
            Klik "Detail" untuk melihat riwayat lengkap
        </span>
    </div>
</x-layouts.app>