<x-layouts.app title="Dokumen Saya - SIDAKA">
    <x-slot name="header">Dokumen Akademik Saya</x-slot>

    {{-- ═══════════════════════════════════════════════════════════
         INTRO STRIP
         ═══════════════════════════════════════════════════════════ --}}
    <div class="mb-6 sm:mb-8 flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 mb-2.5">
                <span class="w-1.5 h-1.5 rounded-full bg-accent"></span>
                <span class="font-mono text-[10px] tracking-[0.2em] uppercase text-ink-400">Arsip · Pribadi</span>
            </div>
            <h2 class="text-[20px] sm:text-[24px] leading-tight tracking-[-0.02em] font-semibold text-ink-900 text-balance">
                Dokumen akademikmu tersimpan di sini.
            </h2>
        </div>
        <p class="max-w-sm text-[12px] text-ink-500 leading-relaxed">
            Semua dokumen resmi yang sudah diunggah dan diverifikasi oleh pihak sekolah dapat kamu pratinjau dan unduh kapan saja.
        </p>
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
                <span class="font-mono text-[10px] tracking-[0.2em] uppercase text-ink-400">Daftar Dokumen</span>
            </div>
            <span class="font-mono text-[10px] tracking-wider uppercase text-ink-400 tabular-nums">
                {{ $documents->total() }} dokumen
            </span>
        </div>

        {{-- Table --}}
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-neutral-50/50 border-b border-black/[0.06]">
                    <tr>
                        <th class="px-5 sm:px-6 py-3 font-mono text-[10px] font-medium text-ink-400 uppercase tracking-wider whitespace-nowrap">Judul Dokumen</th>
                        <th class="px-5 sm:px-6 py-3 font-mono text-[10px] font-medium text-ink-400 uppercase tracking-wider whitespace-nowrap">Jenis</th>
                        <th class="px-5 sm:px-6 py-3 font-mono text-[10px] font-medium text-ink-400 uppercase tracking-wider whitespace-nowrap">Status Verifikasi</th>
                        <th class="px-5 sm:px-6 py-3 font-mono text-[10px] font-medium text-ink-400 uppercase tracking-wider whitespace-nowrap">Tgl Unggah</th>
                        <th class="px-5 sm:px-6 py-3 font-mono text-[10px] font-medium text-ink-400 uppercase tracking-wider whitespace-nowrap text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-black/[0.05]">
                    @forelse($documents as $doc)
                        <tr class="group hover:bg-neutral-50/60 transition-colors duration-150">

                            {{-- Judul Dokumen --}}
                            <td class="px-5 sm:px-6 py-4">
                                <div class="flex items-center gap-3 min-w-0">
                                    {{-- Icon box --}}
                                    <div class="shrink-0 w-9 h-9 rounded-xl bg-neutral-100 border border-black/[0.06]
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
                                    <div class="min-w-0">
                                        <p class="text-[13px] font-medium text-ink-900 leading-snug truncate">
                                            {{ $doc->title }}
                                        </p>
                                    </div>
                                </div>
                            </td>

                            {{-- Jenis Dokumen --}}
                            <td class="px-5 sm:px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center h-6 px-2 rounded-md
                                             bg-[#EAF3FF] border border-[#0A84FF]/15
                                             font-mono text-[10px] text-[#0055CC] tracking-wider">
                                    {{ $doc->documentType->name }}
                                </span>
                            </td>

                            {{-- Status --}}
                            <td class="px-5 sm:px-6 py-4">
                                <x-status-badge :status="$doc->verification_status" />
                            </td>

                            {{-- Tgl Unggah --}}
                            <td class="px-5 sm:px-6 py-4 whitespace-nowrap">
                                <span class="font-mono text-[11px] text-ink-700 tabular-nums">
                                    {{ $doc->created_at->format('d/m/Y') }}
                                </span>
                            </td>

                            {{-- Aksi --}}
                            <td class="px-5 sm:px-6 py-4 text-right whitespace-nowrap">
                                <div class="inline-flex items-center gap-1.5">

                                    {{-- Pratinjau --}}
                                    <a href="{{ route('documents.stream', $doc) }}" target="_blank"
                                       class="group/btn inline-flex items-center gap-1.5 h-8 px-2.5 rounded-lg
                                              bg-white border border-black/[0.08] text-ink-700
                                              hover:bg-ink-900 hover:border-ink-900 hover:text-white
                                              text-[11px] font-medium
                                              transition-all duration-200">
                                        <svg class="w-3 h-3 opacity-70 group-hover/btn:opacity-100" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.75">
                                            <path d="M1.5 8s2.3-4.5 6.5-4.5S14.5 8 14.5 8s-2.3 4.5-6.5 4.5S1.5 8 1.5 8z" stroke-linejoin="round"/>
                                            <circle cx="8" cy="8" r="2"/>
                                        </svg>
                                        <span>Pratinjau</span>
                                    </a>

                                    {{-- Unduh (accent emphasis) --}}
                                    <a href="{{ route('documents.download', $doc) }}"
                                       class="group/dl inline-flex items-center gap-1.5 h-8 px-2.5 rounded-lg
                                              bg-[#0A84FF] border border-[#0A84FF] text-white
                                              hover:bg-[#0055CC] hover:border-[#0055CC]
                                              text-[11px] font-medium
                                              transition-all duration-200
                                              shadow-[0_1px_2px_rgba(10,132,255,0.2)]">
                                        <svg class="w-3 h-3 opacity-90" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.75">
                                            <path d="M8 2v8M5 7l3 3 3-3" stroke-linecap="round" stroke-linejoin="round"/>
                                            <path d="M3 13h10" stroke-linecap="round"/>
                                        </svg>
                                        <span>Unduh</span>
                                    </a>

                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-5 sm:px-6 py-16">
                                <div class="max-w-sm mx-auto text-center">

                                    {{-- Icon --}}
                                    <div class="w-16 h-16 mx-auto rounded-2xl bg-neutral-50 border border-black/[0.06]
                                                flex items-center justify-center">
                                        <svg class="w-7 h-7 text-ink-300" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                            <path d="M6 2.5h8.5L19 7v14a1 1 0 01-1 1H6a1 1 0 01-1-1V3.5a1 1 0 011-1z" stroke-linejoin="round"/>
                                            <path d="M14.5 2.5V7H19" stroke-linejoin="round"/>
                                            <path d="M9 13h6M9 16h4" stroke-linecap="round"/>
                                        </svg>
                                    </div>

                                    <p class="mt-5 text-[14px] font-medium text-ink-900">
                                        Belum ada dokumen
                                    </p>
                                    <p class="mt-2 text-[12px] text-ink-500 leading-relaxed">
                                        Dokumen akademik akan muncul di sini setelah pihak sekolah mengunggah dan memverifikasinya untuk akunmu.
                                    </p>

                                    {{-- Hint box --}}
                                    <div class="mt-5 inline-flex items-start gap-2.5 text-left rounded-xl
                                                border border-black/[0.06] bg-neutral-50/60 px-3.5 py-3 max-w-xs">
                                        <div class="shrink-0 w-6 h-6 rounded-lg bg-accent/10 border border-accent/15
                                                    flex items-center justify-center mt-0.5">
                                            <svg class="w-3 h-3 text-accent" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.75">
                                                <circle cx="8" cy="8" r="6"/>
                                                <path d="M8 7.5v3.5M8 5h.01" stroke-linecap="round"/>
                                            </svg>
                                        </div>
                                        <p class="text-[11px] text-ink-500 leading-relaxed">
                                            Butuh dokumen baru? Ajukan lewat menu
                                            <span class="font-medium text-ink-700">Pengajuan Saya</span>.
                                        </p>
                                    </div>

                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($documents->hasPages())
            <div class="px-5 sm:px-6 py-4 border-t border-black/[0.06] bg-neutral-50/30">
                {{ $documents->links() }}
            </div>
        @endif

    </div>

    {{-- Footer note --}}
    <div class="mt-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 px-1">
        <span class="font-mono text-[10px] tracking-[0.2em] uppercase text-ink-400">
            SIDAKA · Dokumen v2.0
        </span>
        <span class="font-mono text-[10px] tracking-[0.2em] uppercase text-ink-400">
            Semua dokumen terenkripsi &amp; terverifikasi
        </span>
    </div>

</x-layouts.app>