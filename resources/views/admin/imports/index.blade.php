<x-layouts.app title="Batch Import Akun - Admin SIDAKA">
    <x-slot name="header">Import Batch Akun Dapodik</x-slot>

    {{-- ═══════════════════════════════════════════════════════════
         INTRO STRIP
         ═══════════════════════════════════════════════════════════ --}}
    <div class="mb-6 sm:mb-8 flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 mb-2.5">
                <span class="w-1.5 h-1.5 rounded-full bg-accent"></span>
                <span class="font-mono text-[10px] tracking-[0.2em] uppercase text-ink-400">Dapodik · Batch Import</span>
            </div>
            <h2 class="text-[20px] sm:text-[24px] leading-tight tracking-[-0.02em] font-semibold text-ink-900 text-balance">
                Unggah rekap akun dalam format CSV.
            </h2>
        </div>
        <p class="max-w-sm text-[12px] text-ink-500 leading-relaxed">
            Sistem akan memproses file CSV dari Dapodik dan membuat akun secara otomatis sesuai role yang sesuai.
        </p>
    </div>

    {{-- ═══════════════════════════════════════════════════════════
         TWO CARDS — Siswa & Guru
         ═══════════════════════════════════════════════════════════ --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-5 sm:gap-6">

        {{-- ═══════════════════════════════════════════════════════════
             CARD 1 — IMPORT SISWA
             ═══════════════════════════════════════════════════════════ --}}
        <div class="rounded-2xl border border-black/[0.06] bg-white/85 backdrop-blur-xl
                    shadow-[0_1px_2px_rgba(0,0,0,0.03),0_8px_24px_rgba(0,0,0,0.04)]
                    overflow-hidden">

            {{-- Card header --}}
            <div class="px-5 sm:px-6 py-4 border-b border-black/[0.06] flex items-center justify-between gap-4">
                <div class="flex items-center gap-3 min-w-0">
                    <div class="shrink-0 w-10 h-10 rounded-xl bg-ink-900 flex items-center justify-center">
                        <svg class="w-4 h-4 text-white" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.6">
                            <path d="M10 3L2 7l8 4 8-4-8-4z" stroke-linejoin="round"/>
                            <path d="M5 9v4c0 1.5 2.2 3 5 3s5-1.5 5-3V9" stroke-linejoin="round"/>
                            <path d="M18 7v6" stroke-linecap="round"/>
                        </svg>
                    </div>
                    <div class="min-w-0">
                        <p class="font-mono text-[9px] tracking-[0.2em] uppercase text-ink-400">01 — Siswa</p>
                        <h3 class="mt-0.5 text-[14px] font-semibold text-ink-900 tracking-tight truncate">
                            Import Akun Siswa
                        </h3>
                    </div>
                </div>
                <span class="font-mono text-[9px] tracking-widest uppercase text-ink-300">CSV</span>
            </div>

            {{-- Card body --}}
            <div class="p-5 sm:p-6">
                <form action="{{ route('admin.imports.students') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
                    @csrf

                    {{-- File input --}}
                    <div>
                        <label for="file_students" class="block text-[11px] font-medium text-ink-700 uppercase tracking-wider mb-2">
                            File CSV Siswa
                        </label>
                        <div class="relative group">
                            <input type="file" name="file" id="file_students"
                                   accept=".csv,.txt" required
                                   class="block w-full text-[12px] text-ink-500
                                          file:mr-3 file:py-2.5 file:px-4 file:rounded-xl file:border-0
                                          file:text-[11px] file:font-medium file:uppercase file:tracking-wider
                                          file:bg-ink-900 file:text-white
                                          file:cursor-pointer file:transition
                                          hover:file:bg-ink-700
                                          border border-black/[0.06] rounded-xl py-2.5 px-3
                                          bg-white
                                          focus:outline-none focus:ring-4 focus:ring-accent/10 focus:border-accent/50
                                          transition
                                          file:focus:outline-none">
                        </div>
                        <p class="mt-2 font-mono text-[10px] tracking-wider uppercase text-ink-400">
                            Format: .csv atau .txt · Maks 2 MB
                        </p>
                    </div>

                    {{-- Format info panel --}}
                    <div class="rounded-xl border border-black/[0.06] bg-neutral-50/70 p-4">
                        <div class="flex items-center gap-2 mb-3">
                            <span class="w-1.5 h-1.5 rounded-full bg-accent"></span>
                            <span class="font-mono text-[9px] tracking-[0.2em] uppercase text-ink-400">Format Kolom</span>
                        </div>
                        <div class="flex flex-wrap gap-1.5">
                            <code class="inline-flex items-center h-6 px-2 rounded-md
                                         bg-white border border-black/[0.06]
                                         font-mono text-[10px] text-ink-700">NIS</code>
                            <code class="inline-flex items-center h-6 px-2 rounded-md
                                         bg-white border border-black/[0.06]
                                         font-mono text-[10px] text-ink-700">NISN</code>
                            <code class="inline-flex items-center h-6 px-2 rounded-md
                                         bg-white border border-black/[0.06]
                                         font-mono text-[10px] text-ink-700">Nama</code>
                            <code class="inline-flex items-center h-6 px-2 rounded-md
                                         bg-white border border-black/[0.06]
                                         font-mono text-[10px] text-ink-700">Email</code>
                            <code class="inline-flex items-center h-6 px-2 rounded-md
                                         bg-white border border-black/[0.06]
                                         font-mono text-[10px] text-ink-700">Kelas</code>
                            <code class="inline-flex items-center h-6 px-2 rounded-md
                                         bg-white border border-black/[0.06]
                                         font-mono text-[10px] text-ink-700">Jurusan</code>
                        </div>
                        <div class="mt-3 pt-3 border-t border-black/[0.05] flex items-center justify-between gap-3">
                            <span class="font-mono text-[10px] tracking-wider uppercase text-ink-400">Default Password</span>
                            <code class="inline-flex items-center h-6 px-2 rounded-md
                                         bg-[#EAF3FF] border border-[#0A84FF]/15
                                         font-mono text-[10px] text-[#0055CC] font-medium">password123</code>
                        </div>
                    </div>

                    {{-- Submit --}}
                    <button type="submit"
                            class="w-full inline-flex items-center justify-center gap-2 h-11 rounded-xl
                                   bg-ink-900 hover:bg-ink-700 text-white text-[12px] font-medium
                                   transition-all duration-200 active:scale-[0.98]">
                        <svg class="w-3.5 h-3.5" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.75">
                            <path d="M10 3v9M6.5 8.5L10 12l3.5-3.5" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M4 16h12" stroke-linecap="round"/>
                        </svg>
                        <span>Proses Import Siswa</span>
                    </button>
                </form>
            </div>
        </div>

        {{-- ═══════════════════════════════════════════════════════════
             CARD 2 — IMPORT GURU
             ═══════════════════════════════════════════════════════════ --}}
        <div class="rounded-2xl border border-black/[0.06] bg-white/85 backdrop-blur-xl
                    shadow-[0_1px_2px_rgba(0,0,0,0.03),0_8px_24px_rgba(0,0,0,0.04)]
                    overflow-hidden">

            {{-- Card header --}}
            <div class="px-5 sm:px-6 py-4 border-b border-black/[0.06] flex items-center justify-between gap-4">
                <div class="flex items-center gap-3 min-w-0">
                    <div class="shrink-0 w-10 h-10 rounded-xl bg-ink-900 flex items-center justify-center">
                        <svg class="w-4 h-4 text-white" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.6">
                            <circle cx="10" cy="6.5" r="3"/>
                            <path d="M3.5 17c.5-3.3 3.3-5.5 6.5-5.5s6 2.2 6.5 5.5" stroke-linecap="round"/>
                        </svg>
                    </div>
                    <div class="min-w-0">
                        <p class="font-mono text-[9px] tracking-[0.2em] uppercase text-ink-400">02 — Guru</p>
                        <h3 class="mt-0.5 text-[14px] font-semibold text-ink-900 tracking-tight truncate">
                            Import Akun Guru
                        </h3>
                    </div>
                </div>
                <span class="font-mono text-[9px] tracking-widest uppercase text-ink-300">CSV</span>
            </div>

            {{-- Card body --}}
            <div class="p-5 sm:p-6">
                <form action="{{ route('admin.imports.teachers') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
                    @csrf

                    {{-- File input --}}
                    <div>
                        <label for="file_teachers" class="block text-[11px] font-medium text-ink-700 uppercase tracking-wider mb-2">
                            File CSV Guru
                        </label>
                        <div class="relative group">
                            <input type="file" name="file" id="file_teachers"
                                   accept=".csv,.txt" required
                                   class="block w-full text-[12px] text-ink-500
                                          file:mr-3 file:py-2.5 file:px-4 file:rounded-xl file:border-0
                                          file:text-[11px] file:font-medium file:uppercase file:tracking-wider
                                          file:bg-ink-900 file:text-white
                                          file:cursor-pointer file:transition
                                          hover:file:bg-ink-700
                                          border border-black/[0.06] rounded-xl py-2.5 px-3
                                          bg-white
                                          focus:outline-none focus:ring-4 focus:ring-accent/10 focus:border-accent/50
                                          transition
                                          file:focus:outline-none">
                        </div>
                        <p class="mt-2 font-mono text-[10px] tracking-wider uppercase text-ink-400">
                            Format: .csv atau .txt · Maks 2 MB
                        </p>
                    </div>

                    {{-- Format info panel --}}
                    <div class="rounded-xl border border-black/[0.06] bg-neutral-50/70 p-4">
                        <div class="flex items-center gap-2 mb-3">
                            <span class="w-1.5 h-1.5 rounded-full bg-accent"></span>
                            <span class="font-mono text-[9px] tracking-[0.2em] uppercase text-ink-400">Format Kolom</span>
                        </div>
                        <div class="flex flex-wrap gap-1.5">
                            <code class="inline-flex items-center h-6 px-2 rounded-md
                                         bg-white border border-black/[0.06]
                                         font-mono text-[10px] text-ink-700">NIP</code>
                            <code class="inline-flex items-center h-6 px-2 rounded-md
                                         bg-white border border-black/[0.06]
                                         font-mono text-[10px] text-ink-700">Nama</code>
                            <code class="inline-flex items-center h-6 px-2 rounded-md
                                         bg-white border border-black/[0.06]
                                         font-mono text-[10px] text-ink-700">Email</code>
                            <code class="inline-flex items-center h-6 px-2 rounded-md
                                         bg-white border border-black/[0.06]
                                         font-mono text-[10px] text-ink-700">Kelas</code>
                            <code class="inline-flex items-center h-6 px-2 rounded-md
                                         bg-white border border-black/[0.06]
                                         font-mono text-[10px] text-ink-700">Jurusan</code>
                        </div>
                        <div class="mt-3 pt-3 border-t border-black/[0.05] flex items-center justify-between gap-3">
                            <span class="font-mono text-[10px] tracking-wider uppercase text-ink-400">Default Password</span>
                            <code class="inline-flex items-center h-6 px-2 rounded-md
                                         bg-[#EAF3FF] border border-[#0A84FF]/15
                                         font-mono text-[10px] text-[#0055CC] font-medium">password123</code>
                        </div>
                    </div>

                    {{-- Submit --}}
                    <button type="submit"
                            class="w-full inline-flex items-center justify-center gap-2 h-11 rounded-xl
                                   bg-ink-900 hover:bg-ink-700 text-white text-[12px] font-medium
                                   transition-all duration-200 active:scale-[0.98]">
                        <svg class="w-3.5 h-3.5" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.75">
                            <path d="M10 3v9M6.5 8.5L10 12l3.5-3.5" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M4 16h12" stroke-linecap="round"/>
                        </svg>
                        <span>Proses Import Guru</span>
                    </button>
                </form>
            </div>
        </div>

    </div>

    {{-- ═══════════════════════════════════════════════════════════
         FOOTER NOTE
         ═══════════════════════════════════════════════════════════ --}}
    <div class="mt-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 px-1">
        <span class="font-mono text-[10px] tracking-[0.2em] uppercase text-ink-400">
            SIDAKA · Batch Import v2.0
        </span>
        <span class="font-mono text-[10px] tracking-[0.2em] uppercase text-ink-400">
            Semua akun otomatis aktif setelah import
        </span>
    </div>

</x-layouts.app>