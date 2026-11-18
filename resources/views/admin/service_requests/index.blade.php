<x-layouts.app title="Pengajuan Layanan - Admin SIDAKA">
    <x-slot name="header">Kelola Pengajuan Layanan Siswa</x-slot>

    {{-- ═══════════════════════════════════════════════════════════
         INTRO STRIP
         ═══════════════════════════════════════════════════════════ --}}
    <div class="mb-6 sm:mb-8 flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 mb-2.5">
                <span class="w-1.5 h-1.5 rounded-full bg-accent"></span>
                <span class="font-mono text-[10px] tracking-[0.2em] uppercase text-ink-400">Antrean · Operasional TU & Kurikulum</span>
            </div>
            <h2 class="text-[20px] sm:text-[24px] leading-tight tracking-[-0.02em] font-semibold text-ink-900 text-balance">
                Kelola pengajuan layanan &amp; legalisir siswa.
            </h2>
        </div>
        <p class="max-w-sm text-[12px] text-ink-500 leading-relaxed">
            Verifikasi berjenjang (Pemeriksaan Berkas TU → Validasi Akademik Kurikulum) untuk menjaga integritas dokumen.
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

        <form action="{{ route('admin.service-requests.index') }}" method="GET"
              class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-12 gap-3">

            {{-- Search --}}
            <div class="sm:col-span-2 lg:col-span-5">
                <label for="search" class="block text-[10px] font-medium text-ink-500 uppercase tracking-wider mb-1.5">
                    Cari No. Pengajuan / Nama Siswa
                </label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-ink-400">
                        <svg class="w-4 h-4" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.75">
                            <circle cx="9" cy="9" r="6"/>
                            <path d="M14 14l4 4" stroke-linecap="round"/>
                        </svg>
                    </span>
                    <input type="text" name="search" id="search" value="{{ request('search') }}"
                           placeholder="Cari no. pengajuan, nama, NISN..."
                           class="w-full h-11 pl-10 pr-4 rounded-xl bg-white border border-black/[0.08]
                                  text-[13px] text-ink-900 placeholder:text-ink-400
                                  transition outline-none
                                  focus:border-accent/50 focus:ring-4 focus:ring-accent/10">
                </div>
            </div>

            {{-- Status Enum Filter --}}
            <div class="lg:col-span-3">
                <label for="status" class="block text-[10px] font-medium text-ink-500 uppercase tracking-wider mb-1.5">
                    Tahap Verifikasi
                </label>
                <select name="status" id="status"
                        class="w-full h-11 px-3.5 rounded-xl bg-white border border-black/[0.08]
                               text-[13px] text-ink-900
                               transition outline-none
                               focus:border-accent/50 focus:ring-4 focus:ring-accent/10">
                    <option value="">Semua Status Tahapan</option>
                    @foreach(\App\Enums\DocumentVerificationStatus::cases() as $statusEnum)
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
                    <option value="">Semua</option>
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
                <a href="{{ route('admin.service-requests.index') }}"
                   class="inline-flex items-center justify-center h-11 px-3.5 rounded-xl
                          bg-white border border-black/[0.08] text-ink-600
                          hover:bg-neutral-50 hover:border-black/[0.14]
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
                request('search') ? 'Cari: "' . request('search') . '"' : null,
                request('status') ? 'Status: ' . (\App\Enums\DocumentVerificationStatus::tryFrom(request('status'))?->label() ?? ucfirst(request('status'))) : null,
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
                <a href="{{ route('admin.service-requests.index') }}"
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
         TABLE ANTREAN PENGAJUAN
         ═══════════════════════════════════════════════════════════ --}}
    <div class="rounded-2xl border border-black/[0.06] bg-white overflow-hidden
                shadow-[0_1px_2px_rgba(0,0,0,0.03),0_8px_24px_rgba(0,0,0,0.04)]">

        {{-- Panel header --}}
        <div class="px-5 sm:px-6 py-4 border-b border-black/[0.06] flex items-center justify-between gap-4">
            <div class="flex items-center gap-2.5">
                <span class="w-1.5 h-1.5 rounded-full bg-accent"></span>
                <span class="font-mono text-[10px] tracking-[0.2em] uppercase text-ink-400">Daftar Berkas &amp; Permohonan Legalisir</span>
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
                        <th class="px-5 sm:px-6 py-3 font-mono text-[10px] font-medium text-ink-400 uppercase tracking-wider whitespace-nowrap">Nama Siswa</th>
                        <th class="px-5 sm:px-6 py-3 font-mono text-[10px] font-medium text-ink-400 uppercase tracking-wider whitespace-nowrap">Kelas</th>
                        <th class="px-5 sm:px-6 py-3 font-mono text-[10px] font-medium text-ink-400 uppercase tracking-wider whitespace-nowrap">Layanan</th>
                        <th class="px-5 sm:px-6 py-3 font-mono text-[10px] font-medium text-ink-400 uppercase tracking-wider whitespace-nowrap">Status Verifikasi</th>
                        <th class="px-5 sm:px-6 py-3 font-mono text-[10px] font-medium text-ink-400 uppercase tracking-wider whitespace-nowrap">Tanggal</th>
                        <th class="px-5 sm:px-6 py-3 font-mono text-[10px] font-medium text-ink-400 uppercase tracking-wider whitespace-nowrap text-right">Aksi &amp; Aksi Cepat</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-black/[0.05]">
                    @forelse($serviceRequests as $req)
                        @php
                            $statusEnum = is_string($req->status) 
                                ? \App\Enums\DocumentVerificationStatus::tryFrom($req->status) 
                                : $req->status;
                            $statusVal = $statusEnum?->value ?? $req->status;
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

                            {{-- Nama Siswa --}}
                            <td class="px-5 sm:px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center gap-2.5">
                                    <div class="w-7 h-7 rounded-full bg-neutral-100 border border-black/[0.06]
                                                flex items-center justify-center shrink-0">
                                        <span class="text-[10px] font-semibold text-ink-600 uppercase">
                                            {{ mb_substr($req->student->user->name ?? 'S', 0, 1) }}
                                        </span>
                                    </div>
                                    <span class="text-[13px] font-medium text-ink-900">
                                        {{ $req->student->user->name ?? '-' }}
                                    </span>
                                </div>
                            </td>

                            {{-- Kelas --}}
                            <td class="px-5 sm:px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center h-6 px-2 rounded-md
                                             bg-neutral-100 border border-black/[0.05]
                                             font-mono text-[10px] text-ink-700 tracking-wider">
                                    {{ $req->student->classInfo->name ?? '-' }}
                                </span>
                            </td>

                            {{-- Layanan --}}
                            <td class="px-5 sm:px-6 py-4 whitespace-nowrap">
                                <span class="text-[12.5px] font-medium text-[#0055CC]">
                                    {{ $req->serviceType->name ?? '-' }}
                                </span>
                            </td>

                            {{-- Status Badge --}}
                            <td class="px-5 sm:px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[11px] font-medium border {{ $statusEnum?->badgeClass() ?? 'bg-neutral-100 text-neutral-600 border-neutral-200' }}">
                                    {{ $statusEnum?->label() ?? ucfirst((string)$req->status) }}
                                </span>
                            </td>

                            {{-- Tanggal --}}
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
                                <div class="flex items-center justify-end gap-2">

                                    {{-- Fast Action Tahap 1: Verifikasi TU --}}
                                    @if($statusVal === 'pending_tu')
                                        <form action="{{ route('admin.service-requests.verify-tu', $req) }}" method="POST" class="inline">
                                            @csrf
                                            <input type="hidden" name="action" value="approve">
                                            <button type="submit" class="inline-flex items-center gap-1 h-7 px-2.5 rounded-lg bg-amber-500 hover:bg-amber-600 text-white text-[10px] font-medium transition">
                                                <span>ACC TU</span>
                                            </button>
                                        </form>
                                    @endif

                                    {{-- Fast Action Tahap 2: Validasi Kurikulum --}}
                                    @if($statusVal === 'pending_kurikulum')
                                        <form action="{{ route('admin.service-requests.verify-kurikulum', $req) }}" method="POST" class="inline">
                                            @csrf
                                            <input type="hidden" name="action" value="approve">
                                            <button type="submit" class="inline-flex items-center gap-1 h-7 px-2.5 rounded-lg bg-blue-600 hover:bg-blue-700 text-white text-[10px] font-medium transition">
                                                <span>Validasi Kurikulum</span>
                                            </button>
                                        </form>
                                    @endif

                                    {{-- Detail Link --}}
                                    <a href="{{ route('admin.service-requests.show', $req) }}"
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
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-5 sm:px-6 py-16">
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
                                        @if($activeFilters->isNotEmpty())
                                            Tidak ada pengajuan untuk filter ini
                                        @else
                                            Belum ada pengajuan masuk
                                        @endif
                                    </p>

                                    <p class="mt-2 text-[12px] text-ink-500 leading-relaxed">
                                        @if($activeFilters->isNotEmpty())
                                            Coba ubah kriteria filter, atau hapus filter untuk melihat semua pengajuan.
                                        @else
                                            Pengajuan dari siswa akan muncul otomatis di sini setelah mereka submit formulir.
                                        @endif
                                    </p>

                                    @if($activeFilters->isNotEmpty())
                                        <a href="{{ route('admin.service-requests.index') }}"
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
            SIDAKA · Verifikasi Legalisir Berjenjang v2.0
        </span>
        <span class="font-mono text-[10px] tracking-[0.2em] uppercase text-ink-400">
            Gunakan tombol aksi cepat atau klik "Detail" untuk verifikasi lengkap
        </span>
    </div>
</x-layouts.app>