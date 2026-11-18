<x-layouts.app title="Dashboard Guru - SIDAKA">
    <x-slot name="header">Dashboard Guru</x-slot>

    {{-- ═══════════════════════════════════════════════════════════
         INTRO STRIP
         ═══════════════════════════════════════════════════════════ --}}
    <div class="mb-6 sm:mb-8 flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 mb-2.5">
                <span class="w-1.5 h-1.5 rounded-full bg-accent"></span>
                <span class="font-mono text-[10px] tracking-[0.2em] uppercase text-ink-400">
                    Ringkasan · Wali Kelas {{ $className ?? '' }}
                </span>
            </div>
            <h2 class="text-[20px] sm:text-[24px] leading-tight tracking-[-0.02em] font-semibold text-ink-900 text-balance">
                Selamat datang, {{ auth()->user()->name }}.
            </h2>
        </div>
        <p class="max-w-sm text-[12px] text-ink-500 leading-relaxed">
            Pantau daftar siswa kelas binaan, kelengkapan berkas raport, dan unggah arsip akademik dari satu tempat.
        </p>
    </div>

    {{-- ═══════════════════════════════════════════════════════════
         STAT CARDS
         ═══════════════════════════════════════════════════════════ --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-5 mb-6">

        {{-- Total Siswa --}}
        <div class="group rounded-2xl border border-black/[0.06] bg-white/85 backdrop-blur-xl
                    shadow-[0_1px_2px_rgba(0,0,0,0.03),0_8px_24px_rgba(0,0,0,0.04)]
                    p-5 transition-all duration-300
                    hover:shadow-[0_2px_4px_rgba(0,0,0,0.04),0_16px_40px_rgba(0,0,0,0.07)]
                    hover:-translate-y-0.5">

            <div class="flex items-start justify-between gap-3 mb-5">
                <div class="w-10 h-10 rounded-xl bg-ink-900 flex items-center justify-center">
                    <svg class="w-4 h-4 text-white" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.6">
                        <circle cx="7" cy="7" r="2.5"/>
                        <circle cx="14" cy="8" r="2"/>
                        <path d="M2.5 15.5c.5-2.7 2.4-4.5 4.5-4.5s4 1.8 4.5 4.5" stroke-linecap="round"/>
                        <path d="M12 12.5c.3-.3.9-.5 1.5-.5 1.8 0 3.2 1.5 3.5 3.5" stroke-linecap="round"/>
                    </svg>
                </div>
                <span class="font-mono text-[9px] tracking-widest uppercase text-ink-300">01</span>
            </div>

            <p class="font-mono text-[10px] tracking-[0.2em] uppercase text-ink-400">Siswa Binaan</p>
            <p class="mt-2 text-[28px] leading-none font-semibold text-ink-900 tracking-tight tabular-nums">
                {{ $stats['total_students'] }}
            </p>
            <div class="mt-4 pt-4 border-t border-black/[0.05] flex items-center gap-1.5">
                <span class="w-1 h-1 rounded-full bg-accent"></span>
                <span class="text-[10px] text-ink-500 font-medium">Kelas {{ $className ?? '-' }}</span>
            </div>
        </div>

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
                <span class="font-mono text-[9px] tracking-widest uppercase text-ink-300">02</span>
            </div>

            <p class="font-mono text-[10px] tracking-[0.2em] uppercase text-ink-400">Total Dokumen</p>
            <p class="mt-2 text-[28px] leading-none font-semibold text-ink-900 tracking-tight tabular-nums">
                {{ $stats['total_documents'] }}
            </p>
            <div class="mt-4 pt-4 border-t border-black/[0.05] flex items-center gap-1.5">
                <span class="w-1 h-1 rounded-full bg-accent"></span>
                <span class="text-[10px] text-ink-500 font-medium">Terarsip di sistem</span>
            </div>
        </div>

        {{-- Belum Ada Raport --}}
        <div class="group rounded-2xl border border-amber-500/20 bg-amber-500/[0.03] backdrop-blur-xl
                    shadow-[0_1px_2px_rgba(0,0,0,0.03),0_8px_24px_rgba(0,0,0,0.04)]
                    p-5 transition-all duration-300
                    hover:shadow-[0_2px_4px_rgba(0,0,0,0.04),0_16px_40px_rgba(0,0,0,0.07)]
                    hover:-translate-y-0.5">

            <div class="flex items-start justify-between gap-3 mb-5">
                <div class="w-10 h-10 rounded-xl bg-amber-500 flex items-center justify-center">
                    <svg class="w-4 h-4 text-white" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.75">
                        <circle cx="10" cy="10" r="7.5"/>
                        <path d="M10 6v4l2.5 2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
                <span class="font-mono text-[9px] tracking-widest uppercase text-amber-500/70">03</span>
            </div>

            <p class="font-mono text-[10px] tracking-[0.2em] uppercase text-amber-600">Belum Ada Raport</p>
            <p class="mt-2 text-[28px] leading-none font-semibold text-amber-600 tracking-tight tabular-nums">
                {{ $stats['students_without_doc'] }}
            </p>
            <div class="mt-4 pt-4 border-t border-amber-500/15 flex items-center gap-1.5">
                <span class="w-1 h-1 rounded-full bg-amber-500"></span>
                <span class="text-[10px] text-amber-700/70 font-medium">Siswa belum diunggah</span>
            </div>
        </div>

        {{-- Terverifikasi --}}
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
                <span class="font-mono text-[9px] tracking-widest uppercase text-emerald-500/70">04</span>
            </div>

            <p class="font-mono text-[10px] tracking-[0.2em] uppercase text-emerald-600">Terverifikasi</p>
            <p class="mt-2 text-[28px] leading-none font-semibold text-emerald-600 tracking-tight tabular-nums">
                {{ $stats['verified_documents'] }}
            </p>
            <div class="mt-4 pt-4 border-t border-emerald-500/15 flex items-center gap-1.5">
                <span class="w-1 h-1 rounded-full bg-emerald-500"></span>
                <span class="text-[10px] text-emerald-700/70 font-medium">Siap digunakan siswa</span>
            </div>
        </div>

    </div>

    {{-- ═══════════════════════════════════════════════════════════
         DAFTAR SISWA KELAS BINAAN TABLE
         ═══════════════════════════════════════════════════════════ --}}
    <div class="rounded-2xl border border-black/[0.06] bg-white overflow-hidden
                shadow-[0_1px_2px_rgba(0,0,0,0.03),0_8px_24px_rgba(0,0,0,0.04)]">

        {{-- Panel header --}}
        <div class="px-5 sm:px-6 py-4 border-b border-black/[0.06] flex flex-wrap items-center justify-between gap-4">
            <div class="flex items-center gap-2.5">
                <span class="w-1.5 h-1.5 rounded-full bg-accent"></span>
                <span class="font-mono text-[10px] tracking-[0.2em] uppercase text-ink-400">
                    Daftar Siswa Kelas {{ $className ?? '' }}
                </span>
            </div>

            <div class="flex items-center gap-2">
                <a href="{{ route('teacher.documents.create') }}"
                   class="inline-flex items-center gap-1.5 h-8 px-3 rounded-lg
                          bg-ink-900 hover:bg-ink-700 text-white
                          text-[11px] font-medium transition-all duration-200">
                    <svg class="w-3 h-3" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M8 3v10M3 8h10" stroke-linecap="round"/>
                    </svg>
                    <span>Unggah Raport</span>
                </a>

                <a href="{{ route('teacher.documents.index') }}"
                   class="group inline-flex items-center gap-1.5 h-8 pl-3 pr-2.5 rounded-lg
                          border border-black/[0.08] text-[11px] font-medium text-ink-700
                          hover:bg-neutral-100 transition-all duration-200">
                    <span>Arsip Dokumen</span>
                    <svg class="w-3 h-3 opacity-60 group-hover:opacity-100 group-hover:translate-x-0.5 transition-transform duration-200"
                         viewBox="0 0 12 12" fill="none" stroke="currentColor" stroke-width="1.75">
                        <path d="M4 3l3 3-3 3" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </a>
            </div>
        </div>

        {{-- Table --}}
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-neutral-50/50 border-b border-black/[0.06]">
                    <tr>
                        <th class="px-5 sm:px-6 py-3 font-mono text-[10px] font-medium text-ink-400 uppercase tracking-wider whitespace-nowrap">Nama Siswa</th>
                        <th class="px-5 sm:px-6 py-3 font-mono text-[10px] font-medium text-ink-400 uppercase tracking-wider whitespace-nowrap">NIS / NISN</th>
                        <th class="px-5 sm:px-6 py-3 font-mono text-[10px] font-medium text-ink-400 uppercase tracking-wider whitespace-nowrap">Kelas</th>
                        <th class="px-5 sm:px-6 py-3 font-mono text-[10px] font-medium text-ink-400 uppercase tracking-wider whitespace-nowrap">Status Raport</th>
                        <th class="px-5 sm:px-6 py-3 font-mono text-[10px] font-medium text-ink-400 uppercase tracking-wider whitespace-nowrap text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-black/[0.05]">
                    @forelse($students as $student)
                        @php
                            $raportCount = $student->documents->count();
                            $latestRaport = $student->documents->first();
                        @endphp
                        <tr class="group hover:bg-neutral-50/60 transition-colors duration-150">

                            {{-- Nama Siswa --}}
                            <td class="px-5 sm:px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-neutral-100 border border-black/[0.06]
                                                flex items-center justify-center shrink-0
                                                group-hover:bg-ink-900 group-hover:text-white transition-colors">
                                        <span class="text-[11px] font-semibold uppercase">
                                            {{ mb_substr($student->user->name ?? 'S', 0, 1) }}
                                        </span>
                                    </div>
                                    <div>
                                        <p class="text-[13px] font-medium text-ink-900">
                                            {{ $student->user->name ?? '-' }}
                                        </p>
                                        <p class="text-[11px] text-ink-400">
                                            {{ $student->user->email ?? '-' }}
                                        </p>
                                    </div>
                                </div>
                            </td>

                            {{-- NIS / NISN --}}
                            <td class="px-5 sm:px-6 py-4 whitespace-nowrap">
                                <span class="font-mono text-[12px] text-ink-700">
                                    {{ $student->nis ?? '-' }}
                                </span>
                                <span class="block font-mono text-[10px] text-ink-400">
                                    NISN: {{ $student->nisn ?? '-' }}
                                </span>
                            </td>

                            {{-- Kelas --}}
                            <td class="px-5 sm:px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center h-6 px-2.5 rounded-md
                                             bg-[#EAF3FF] border border-[#0A84FF]/15
                                             font-mono text-[10px] text-[#0055CC] tracking-wider">
                                    {{ $student->classInfo->name ?? '-' }}
                                </span>
                            </td>

                            {{-- Status Raport --}}
                            <td class="px-5 sm:px-6 py-4 whitespace-nowrap">
                                @if($raportCount > 0)
                                    <span class="inline-flex items-center gap-1.5 h-6 px-2.5 rounded-full
                                                 bg-emerald-50 border border-emerald-200
                                                 font-mono text-[10px] text-emerald-700">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                        {{ $raportCount }} Raport Terunggah
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 h-6 px-2.5 rounded-full
                                                 bg-amber-50 border border-amber-200
                                                 font-mono text-[10px] text-amber-700">
                                        <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                                        Belum Diunggah
                                    </span>
                                @endif
                            </td>

                            {{-- Aksi --}}
                            <td class="px-5 sm:px-6 py-4 text-right whitespace-nowrap">
                                <div class="inline-flex items-center gap-1.5">
                                    @if($latestRaport)
                                        <a href="{{ route('documents.stream', $latestRaport) }}" target="_blank"
                                           class="inline-flex items-center gap-1.5 h-8 px-2.5 rounded-lg
                                                  bg-white border border-black/[0.08] text-ink-700
                                                  hover:bg-neutral-100 text-[11px] font-medium transition-all">
                                            <span>Lihat Raport</span>
                                        </a>
                                    @endif

                                    <a href="{{ route('teacher.documents.create', ['student_id' => $student->id]) }}"
                                       class="inline-flex items-center gap-1.5 h-8 px-3 rounded-lg
                                              bg-ink-900 text-white hover:bg-ink-700
                                              text-[11px] font-medium transition-all">
                                        <span>+ Unggah</span>
                                    </a>
                                </div>
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-5 sm:px-6 py-16 text-center">
                                <p class="text-[14px] font-medium text-ink-900">
                                    Belum ada data siswa di kelas ini
                                </p>
                                <p class="mt-1 text-[12px] text-ink-500">
                                    Pastikan akun Anda sudah terhubung dengan kelas binaan atau hubungi Admin TU.
                                </p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>

    {{-- Footer note --}}
    <div class="mt-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 px-1">
        <span class="font-mono text-[10px] tracking-[0.2em] uppercase text-ink-400">
            SIDAKA · Dashboard Guru v2.0
        </span>
        <span class="font-mono text-[10px] tracking-[0.2em] uppercase text-ink-400 tabular-nums">
            {{ now()->format('d/m/Y H:i') }} WIB
        </span>
    </div>

</x-layouts.app>