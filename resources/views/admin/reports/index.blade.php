<x-layouts.app title="Laporan & Rekap - Admin SIDAKA">
    <x-slot name="header">Laporan Transaksi Dokumen Akademik</x-slot>

    {{-- ═══════════════════════════════════════════════════════════
         INTRO STRIP
         ═══════════════════════════════════════════════════════════ --}}
    <div class="mb-6 sm:mb-8 flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 mb-2.5">
                <span class="w-1.5 h-1.5 rounded-full bg-accent"></span>
                <span class="font-mono text-[10px] tracking-[0.2em] uppercase text-ink-400">Rekap · Periode</span>
            </div>
            <h2 class="text-[20px] sm:text-[24px] leading-tight tracking-[-0.02em] font-semibold text-ink-900 text-balance">
                Laporan transaksi dokumen akademik.
            </h2>
        </div>
        <p class="max-w-sm text-[12px] text-ink-500 leading-relaxed">
            Filter berdasarkan periode, status, dan jenis layanan. Cetak atau export sebagai PDF sesuai kebutuhan.
        </p>
    </div>

    {{-- ═══════════════════════════════════════════════════════════
         FILTER PANEL
         ═══════════════════════════════════════════════════════════ --}}
    <div class="rounded-2xl border border-black/[0.06] bg-white/70 backdrop-blur-xl
                shadow-[0_1px_0_rgba(255,255,255,0.9)_inset,0_1px_2px_rgba(0,0,0,0.03),0_8px_24px_rgba(0,0,0,0.04)]
                p-4 sm:p-5 mb-5">

        <div class="flex items-center gap-2 mb-4">
            <span class="w-1.5 h-1.5 rounded-full bg-accent"></span>
            <span class="font-mono text-[10px] tracking-[0.2em] uppercase text-ink-400">Filter Data</span>
        </div>

        <form action="{{ route('admin.reports.index') }}" method="GET"
              class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-12 gap-3">

            {{-- Dari Tanggal --}}
            <div class="lg:col-span-3">
                <label for="start_date" class="block text-[10px] font-medium text-ink-500 uppercase tracking-wider mb-1.5">
                    Dari Tanggal
                </label>
                <input type="date" name="start_date" id="start_date" value="{{ request('start_date') }}"
                       class="w-full h-11 px-3.5 rounded-xl bg-white border border-black/[0.08]
                              text-[13px] text-ink-900
                              transition outline-none
                              focus:border-accent/50 focus:ring-4 focus:ring-accent/10">
            </div>

            {{-- Sampai Tanggal --}}
            <div class="lg:col-span-3">
                <label for="end_date" class="block text-[10px] font-medium text-ink-500 uppercase tracking-wider mb-1.5">
                    Sampai Tanggal
                </label>
                <input type="date" name="end_date" id="end_date" value="{{ request('end_date') }}"
                       class="w-full h-11 px-3.5 rounded-xl bg-white border border-black/[0.08]
                              text-[13px] text-ink-900
                              transition outline-none
                              focus:border-accent/50 focus:ring-4 focus:ring-accent/10">
            </div>

            {{-- Status --}}
            <div class="lg:col-span-2">
                <label for="status" class="block text-[10px] font-medium text-ink-500 uppercase tracking-wider mb-1.5">
                    Status
                </label>
                <select name="status" id="status"
                        class="w-full h-11 px-3.5 rounded-xl bg-white border border-black/[0.08]
                               text-[13px] text-ink-900
                               transition outline-none
                               focus:border-accent/50 focus:ring-4 focus:ring-accent/10">
                    <option value="">Semua Status</option>
                    @foreach(\App\Enums\RequestStatus::cases() as $statusEnum)
                        <option value="{{ $statusEnum->value }}" {{ request('status') === $statusEnum->value ? 'selected' : '' }}>
                            {{ $statusEnum->label() }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Jenis Layanan --}}
            <div class="lg:col-span-2">
                <label for="service_type_id" class="block text-[10px] font-medium text-ink-500 uppercase tracking-wider mb-1.5">
                    Layanan
                </label>
                <select name="service_type_id" id="service_type_id"
                        class="w-full h-11 px-3.5 rounded-xl bg-white border border-black/[0.08]
                               text-[13px] text-ink-900
                               transition outline-none
                               focus:border-accent/50 focus:ring-4 focus:ring-accent/10">
                    <option value="">Semua Layanan</option>
                    @foreach($serviceTypes as $type)
                        <option value="{{ $type->id }}" {{ request('service_type_id') == $type->id ? 'selected' : '' }}>
                            {{ $type->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Actions --}}
            <div class="lg:col-span-2 flex items-end gap-2">
                <button type="submit"
                        class="flex-1 inline-flex items-center justify-center gap-2 h-11 px-4 rounded-xl
                               bg-ink-900 hover:bg-ink-700 text-white text-[12px] font-medium
                               transition-all duration-200 active:scale-[0.98]">
                    <svg class="w-3.5 h-3.5" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.75">
                        <path d="M3 5h14M6 10h8M9 15h2" stroke-linecap="round"/>
                    </svg>
                    <span>Filter</span>
                </button>
                <a href="{{ route('admin.reports.index') }}"
                   class="inline-flex items-center justify-center h-11 px-3.5 rounded-xl
                          bg-white border border-black/[0.08] text-ink-600
                          hover:bg-neutral-50 hover:border-black/[0.14] text-[12px] font-medium
                          transition-all duration-200 active:scale-[0.98]"
                   aria-label="Reset filter">
                    <svg class="w-3.5 h-3.5" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.75">
                        <path d="M3 10a7 7 0 1 0 2-4.9M3 5v3h3" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </a>
            </div>
        </form>

        {{-- Active filter chips --}}
        @php
            $activeFilters = collect([
                request('start_date') ? 'Dari: ' . request('start_date') : null,
                request('end_date') ? 'Sampai: ' . request('end_date') : null,
                request('status') ? 'Status: ' . request('status') : null,
                request('service_type_id') ? 'Layanan: ' . ($serviceTypes->firstWhere('id', request('service_type_id'))->name ?? '-') : null,
            ])->filter();
        @endphp

        @if($activeFilters->isNotEmpty())
            <div class="mt-4 pt-4 border-t border-black/[0.06] flex flex-wrap items-center gap-2">
                <span class="font-mono text-[10px] tracking-wider uppercase text-ink-400">Filter aktif:</span>
                @foreach($activeFilters as $filter)
                    <span class="inline-flex items-center h-6 px-2.5 rounded-md
                                 bg-[#EAF3FF] border border-[#0A84FF]/15
                                 font-mono text-[10px] text-[#0055CC]">
                        {{ $filter }}
                    </span>
                @endforeach
                <a href="{{ route('admin.reports.index') }}"
                   class="inline-flex items-center gap-1 h-6 px-2 rounded-md
                          text-[10px] font-medium text-ink-500 hover:text-ink-900
                          hover:bg-black/[0.04] transition">
                    <svg class="w-2.5 h-2.5" viewBox="0 0 12 12" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M3 3l6 6M9 3l-6 6" stroke-linecap="round"/>
                    </svg>
                    Hapus semua
                </a>
            </div>
        @endif
    </div>

    {{-- ═══════════════════════════════════════════════════════════
         ACTION BAR
         ═══════════════════════════════════════════════════════════ --}}
    <div class="mb-3 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 px-1">
        <div class="flex items-center gap-2">
            <span class="font-mono text-[10px] tracking-[0.2em] uppercase text-ink-400">Hasil</span>
            <span class="text-[12px] text-ink-500">
                Menampilkan <strong class="text-ink-900 font-semibold tabular-nums">{{ $reports->total() }}</strong> data transaksi
            </span>
        </div>

        <a href="{{ route('admin.reports.print', request()->query()) }}" target="_blank"
           class="inline-flex items-center justify-center gap-2 h-10 px-4 rounded-xl
                  bg-ink-900 hover:bg-ink-700 text-white text-[12px] font-medium
                  transition-all duration-200 active:scale-[0.98]">
            <svg class="w-3.5 h-3.5" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.6">
                <path d="M5 8V4a1 1 0 011-1h8a1 1 0 011 1v4" stroke-linejoin="round"/>
                <path d="M3 8h14a1 1 0 011 1v5a1 1 0 01-1 1h-2v-3H5v3H4a1 1 0 01-1-1V9a1 1 0 011-1z" stroke-linejoin="round"/>
                <path d="M5 15h10v3a1 1 0 01-1 1H6a1 1 0 01-1-1v-3z"/>
            </svg>
            <span>Cetak / Export PDF</span>
        </a>
    </div>

    {{-- ═══════════════════════════════════════════════════════════
         REPORT TABLE
         ═══════════════════════════════════════════════════════════ --}}
    <div class="rounded-2xl border border-black/[0.06] bg-white overflow-hidden
                shadow-[0_1px_2px_rgba(0,0,0,0.03),0_8px_24px_rgba(0,0,0,0.04)]">

        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-neutral-50/50 border-b border-black/[0.06]">
                    <tr>
                        <th class="px-5 sm:px-6 py-3 font-mono text-[10px] font-medium text-ink-400 uppercase tracking-wider whitespace-nowrap">No. Pengajuan</th>
                        <th class="px-5 sm:px-6 py-3 font-mono text-[10px] font-medium text-ink-400 uppercase tracking-wider whitespace-nowrap">Nama Siswa</th>
                        <th class="px-5 sm:px-6 py-3 font-mono text-[10px] font-medium text-ink-400 uppercase tracking-wider whitespace-nowrap">Kelas</th>
                        <th class="px-5 sm:px-6 py-3 font-mono text-[10px] font-medium text-ink-400 uppercase tracking-wider whitespace-nowrap">Layanan</th>
                        <th class="px-5 sm:px-6 py-3 font-mono text-[10px] font-medium text-ink-400 uppercase tracking-wider whitespace-nowrap">Status</th>
                        <th class="px-5 sm:px-6 py-3 font-mono text-[10px] font-medium text-ink-400 uppercase tracking-wider whitespace-nowrap">Tgl Pengajuan</th>
                        <th class="px-5 sm:px-6 py-3 font-mono text-[10px] font-medium text-ink-400 uppercase tracking-wider whitespace-nowrap">Petugas</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-black/[0.05]">
                    @forelse($reports as $report)
                        <tr class="group hover:bg-neutral-50/60 transition-colors duration-150">

                            {{-- No. Pengajuan --}}
                            <td class="px-5 sm:px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center gap-2.5">
                                    <span class="w-1.5 h-1.5 rounded-full bg-neutral-300 group-hover:bg-accent transition-colors duration-300 shrink-0"></span>
                                    <span class="font-mono text-[12px] font-medium text-ink-900 tabular-nums">
                                        {{ $report->request_number }}
                                    </span>
                                </div>
                            </td>

                            {{-- Nama Siswa --}}
                            <td class="px-5 sm:px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center gap-2.5">
                                    <div class="w-7 h-7 rounded-full bg-neutral-100 border border-black/[0.06]
                                                flex items-center justify-center shrink-0">
                                        <span class="text-[10px] font-semibold text-ink-600 uppercase">
                                            {{ mb_substr($report->student->user->name ?? 'S', 0, 1) }}
                                        </span>
                                    </div>
                                    <span class="text-[13px] font-medium text-ink-900">
                                        {{ $report->student->user->name }}
                                    </span>
                                </div>
                            </td>

                            {{-- Kelas --}}
                            <td class="px-5 sm:px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center h-6 px-2 rounded-md
                                             bg-neutral-100 border border-black/[0.05]
                                             font-mono text-[10px] text-ink-700 tracking-wider">
                                    {{ $report->student->classInfo->name }}
                                </span>
                            </td>

                            {{-- Layanan --}}
                            <td class="px-5 sm:px-6 py-4 whitespace-nowrap">
                                <span class="text-[12.5px] font-medium text-[#0055CC]">
                                    {{ $report->serviceType->name }}
                                </span>
                            </td>

                            {{-- Status --}}
                            <td class="px-5 sm:px-6 py-4">
                                <x-status-badge :status="$report->status" />
                            </td>

                            {{-- Tgl Pengajuan --}}
                            <td class="px-5 sm:px-6 py-4 whitespace-nowrap">
                                <div class="leading-tight">
                                    <p class="font-mono text-[11px] text-ink-700 tabular-nums">
                                        {{ $report->created_at->format('d/m/Y') }}
                                    </p>
                                    <p class="font-mono text-[10px] text-ink-400 tabular-nums mt-0.5">
                                        {{ $report->created_at->format('H:i') }}
                                    </p>
                                </div>
                            </td>

                            {{-- Petugas --}}
                            <td class="px-5 sm:px-6 py-4 whitespace-nowrap">
                                @if($report->handover->first()->processor->name ?? false)
                                    <span class="text-[12px] text-ink-700">
                                        {{ $report->handover->first()->processor->name }}
                                    </span>
                                @else
                                    <span class="font-mono text-[10px] tracking-wider uppercase text-ink-300">
                                        Belum diserahkan
                                    </span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-5 sm:px-6 py-16">
                                <div class="max-w-sm mx-auto text-center">

                                    {{-- Icon --}}
                                    <div class="w-14 h-14 mx-auto rounded-2xl bg-neutral-50 border border-black/[0.06]
                                                flex items-center justify-center">
                                        <svg class="w-6 h-6 text-ink-300" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                            <path d="M5 3h9l5 5v13a1 1 0 01-1 1H5a1 1 0 01-1-1V4a1 1 0 011-1z" stroke-linejoin="round"/>
                                            <path d="M14 3v5h5" stroke-linejoin="round"/>
                                            <path d="M8 13h8M8 17h5" stroke-linecap="round"/>
                                        </svg>
                                    </div>

                                    <p class="mt-5 text-[14px] font-medium text-ink-900">
                                        @if($activeFilters->isNotEmpty())
                                            Tidak ada data untuk filter ini
                                        @else
                                            Belum ada data rekap
                                        @endif
                                    </p>

                                    <p class="mt-2 text-[12px] text-ink-500 leading-relaxed">
                                        @if($activeFilters->isNotEmpty())
                                            Coba perluas rentang tanggal atau ubah kriteria filter yang dipilih.
                                        @else
                                            Data laporan akan muncul otomatis setelah ada transaksi pengajuan.
                                        @endif
                                    </p>

                                    @if($activeFilters->isNotEmpty())
                                        <a href="{{ route('admin.reports.index') }}"
                                           class="mt-5 inline-flex items-center gap-2 h-9 px-4 rounded-xl
                                                  bg-ink-900 hover:bg-ink-700 text-white
                                                  text-[11px] font-medium transition-all duration-200 active:scale-[0.98]">
                                            <svg class="w-3 h-3" viewBox="0 0 12 12" fill="none" stroke="currentColor" stroke-width="2">
                                                <path d="M3 3l6 6M9 3l-6 6" stroke-linecap="round"/>
                                            </svg>
                                            <span>Hapus Filter</span>
                                        </a>
                                    @endif

                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($reports->hasPages())
            <div class="px-5 sm:px-6 py-4 border-t border-black/[0.06] bg-neutral-50/30">
                {{ $reports->links() }}
            </div>
        @endif
    </div>

    {{-- Footer note --}}
    <div class="mt-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 px-1">
        <span class="font-mono text-[10px] tracking-[0.2em] uppercase text-ink-400">
            SIDAKA · Laporan v2.0
        </span>
        <span class="font-mono text-[10px] tracking-[0.2em] uppercase text-ink-400">
            Dicetak pada {{ now()->format('d/m/Y H:i') }}
        </span>
    </div>

</x-layouts.app>