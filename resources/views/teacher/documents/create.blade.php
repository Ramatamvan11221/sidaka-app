<x-layouts.app title="Unggah Dokumen Baru - Guru SIDAKA">
    <x-slot name="header">Unggah Dokumen Akademik Siswa</x-slot>

    {{-- INTRO STRIP --}}
    <div class="mb-6 sm:mb-8 max-w-3xl">
        <div class="flex items-center gap-2 mb-2.5">
            <span class="w-1.5 h-1.5 rounded-full bg-accent"></span>
            <span class="font-mono text-[10px] tracking-[0.2em] uppercase text-ink-400">Unggah · Dokumen Raport</span>
        </div>
        <h2 class="text-[20px] sm:text-[24px] leading-tight tracking-[-0.02em] font-semibold text-ink-900 text-balance">
            Unggah dokumen raport siswa.
        </h2>
        <p class="mt-3 max-w-xl text-[12.5px] text-ink-500 leading-relaxed">
            Pilih siswa binaan kelas Anda, lalu unggah file Raport Akademik. Dokumen akan langsung terverifikasi secara sah.
        </p>
    </div>

    {{-- ERROR VALIDATION ALERT --}}
    @if ($errors->any())
        <div class="mb-6 max-w-3xl p-4 rounded-2xl bg-danger/5 border border-danger/20 text-danger">
            <p class="font-mono text-[10px] tracking-wider uppercase font-semibold mb-1.5">Gagal Mengunggah Dokumen:</p>
            <ul class="list-disc list-inside text-[12px] space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- FORM PANEL --}}
    <div class="max-w-3xl rounded-2xl border border-black/[0.06] bg-white/85 backdrop-blur-xl
                shadow-[0_1px_0_rgba(255,255,255,0.9)_inset,0_1px_2px_rgba(0,0,0,0.03),0_8px_24px_rgba(0,0,0,0.04)]
                overflow-hidden">

        <div class="px-5 sm:px-6 py-4 border-b border-black/[0.06] flex items-center justify-between gap-4">
            <div class="flex items-center gap-2.5">
                <span class="w-1.5 h-1.5 rounded-full bg-accent"></span>
                <span class="font-mono text-[10px] tracking-[0.2em] uppercase text-ink-400">Formulir Wali Kelas</span>
            </div>
            <span class="font-mono text-[9px] tracking-widest uppercase text-ink-300">Wali Kelas</span>
        </div>

        <form action="{{ route('teacher.documents.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="p-5 sm:p-8 space-y-8">

                {{-- SECTION 01 — SISWA --}}
                <section>
                    <div class="flex items-center gap-2 mb-4">
                        <span class="font-mono text-[10px] font-medium tracking-[0.2em] uppercase text-ink-300">01</span>
                        <span class="w-6 h-px bg-ink-900"></span>
                        <span class="font-mono text-[10px] tracking-[0.2em] uppercase text-ink-700">Pemilik Dokumen</span>
                    </div>

                    <label for="student_id" class="block text-[11px] font-medium text-ink-700 uppercase tracking-wider mb-2">
                        Pilih Siswa <span class="text-danger">*</span>
                    </label>

                    <select name="student_id" id="student_id" required
                            class="w-full h-11 px-3.5 rounded-xl bg-white border border-black/[0.08]
                                   text-[13px] text-ink-900
                                   transition outline-none
                                   focus:border-accent/50 focus:ring-4 focus:ring-accent/10">
                        <option value="">— Pilih Siswa Kelas —</option>
                        @foreach($students as $student)
                            <option value="{{ $student->id }}" {{ request('student_id') == $student->id ? 'selected' : '' }}>
                                {{ $student->user->name ?? 'Siswa' }} (NIS: {{ $student->nis ?? '-' }} | {{ $student->classInfo->name ?? '' }})
                            </option>
                        @endforeach
                    </select>

                    <p class="mt-2 font-mono text-[10px] tracking-wider uppercase text-ink-400">
                        Menampilkan daftar siswa di kelas binaan Anda
                    </p>
                </section>

                {{-- SECTION 02 — JENIS DOKUMEN (RESTRIKSI TERKUNCI KHUSUS RAPORT) --}}
                <section>
                    <div class="flex items-center gap-2 mb-4">
                        <span class="font-mono text-[10px] font-medium tracking-[0.2em] uppercase text-ink-300">02</span>
                        <span class="w-6 h-px bg-ink-900"></span>
                        <span class="font-mono text-[10px] tracking-[0.2em] uppercase text-ink-700">Klasifikasi Dokumen</span>
                    </div>

                    <label class="block text-[11px] font-medium text-ink-700 uppercase tracking-wider mb-2">
                        Jenis Dokumen
                    </label>

                    @php
                        $raportType = $documentTypes->first();
                    @endphp

                    <input type="hidden" name="document_type_id" value="{{ $raportType->id ?? '' }}">
                    <input type="hidden" name="category" value="raport">

                    <div class="flex items-center gap-3 p-3.5 bg-neutral-50 border border-black/[0.08] rounded-xl text-ink-900 text-[13px] font-medium">
                        <div class="w-7 h-7 rounded-lg bg-[#EAF3FF] border border-[#0A84FF]/20 flex items-center justify-center shrink-0">
                            <svg class="w-4 h-4 text-[#0055CC]" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.75">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <span class="font-semibold text-ink-900">Raport Akademik Siswa</span>
                            <span class="block text-[11px] text-ink-500 font-normal mt-0.5">Wali kelas secara otomatis terkunci hanya untuk mengunggah Raport. Dokumen lain dikelola Kurikulum.</span>
                        </div>
                        <span class="inline-flex items-center px-2.5 py-1 rounded-md bg-emerald-50 text-emerald-700 border border-emerald-200 text-[10px] font-mono uppercase">
                            Terkunci
                        </span>
                    </div>
                </section>

                {{-- SECTION 03 — JUDUL DOKUMEN --}}
                <section>
                    <div class="flex items-center gap-2 mb-4">
                        <span class="font-mono text-[10px] font-medium tracking-[0.2em] uppercase text-ink-300">03</span>
                        <span class="w-6 h-px bg-ink-900"></span>
                        <span class="font-mono text-[10px] tracking-[0.2em] uppercase text-ink-700">Identitas Dokumen</span>
                    </div>

                    <label for="title" class="block text-[11px] font-medium text-ink-700 uppercase tracking-wider mb-2">
                        Judul Dokumen <span class="text-danger">*</span>
                    </label>

                    <input type="text" name="title" id="title" value="{{ old('title', 'Raport Semester Ganjil / Genap') }}" required
                           placeholder="Contoh: Raport Semester 1 TA 2025/2026"
                           class="w-full h-11 px-3.5 rounded-xl bg-white border border-black/[0.08]
                                  text-[13px] text-ink-900 placeholder:text-ink-300
                                  transition outline-none
                                  focus:border-accent/50 focus:ring-4 focus:ring-accent/10">

                    <p class="mt-2 font-mono text-[10px] tracking-wider uppercase text-ink-400">
                        Gunakan judul yang memuat semester &amp; tahun ajaran
                    </p>
                </section>

                {{-- SECTION 04 — FILE --}}
                <section>
                    <div class="flex items-center gap-2 mb-4">
                        <span class="font-mono text-[10px] font-medium tracking-[0.2em] uppercase text-ink-300">04</span>
                        <span class="w-6 h-px bg-ink-900"></span>
                        <span class="font-mono text-[10px] tracking-[0.2em] uppercase text-ink-700">Berkas</span>
                    </div>

                    <label for="file" class="block text-[11px] font-medium text-ink-700 uppercase tracking-wider mb-2">
                        File Dokumen (PDF) <span class="text-danger">*</span>
                    </label>

                    <div class="relative">
                        <input type="file" name="file" id="file" accept=".pdf" required
                               class="block w-full text-[12px] text-ink-500
                                      file:mr-3 file:py-2.5 file:px-4 file:rounded-xl file:border-0
                                      file:text-[11px] file:font-medium file:uppercase file:tracking-wider
                                      file:bg-ink-900 file:text-white
                                      file:cursor-pointer file:transition
                                      hover:file:bg-ink-700
                                      border border-black/[0.06] rounded-xl py-2.5 px-3
                                      bg-white
                                      focus:outline-none focus:ring-4 focus:ring-accent/10 focus:border-accent/50
                                      transition">
                    </div>

                    <div class="mt-4 rounded-xl border border-black/[0.06] bg-neutral-50/60 p-4">
                        <div class="flex items-center gap-2 mb-3">
                            <span class="w-1.5 h-1.5 rounded-full bg-accent"></span>
                            <span class="font-mono text-[9px] tracking-[0.2em] uppercase text-ink-400">Ketentuan File</span>
                        </div>

                        <div class="flex flex-wrap gap-1.5">
                            <span class="inline-flex items-center h-6 px-2 rounded-md bg-white border border-black/[0.06] font-mono text-[10px] text-ink-700">PDF ONLY</span>
                            <span class="text-ink-300 text-[10px] py-1">·</span>
                            <span class="inline-flex items-center h-6 px-2 rounded-md bg-[#EAF3FF] border border-[#0A84FF]/15 font-mono text-[10px] text-[#0055CC] font-medium">Maks 5MB</span>
                        </div>
                    </div>
                </section>

            </div>

            <div class="px-5 sm:px-8 py-5 border-t border-black/[0.06] bg-neutral-50/40
                        flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">

                <p class="font-mono text-[10px] tracking-wider uppercase text-ink-400 order-2 sm:order-1">
                    Cek kembali data siswa sebelum mengunggah
                </p>

                <button type="submit"
                        class="order-1 sm:order-2 inline-flex items-center justify-center gap-2 h-11 px-6 rounded-xl
                               bg-ink-900 hover:bg-ink-700 text-white text-[12px] font-medium
                               transition-all duration-200 active:scale-[0.98]">
                    <svg class="w-3.5 h-3.5 opacity-80" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.75">
                        <path d="M10 3v9M6.5 8.5L10 12l3.5-3.5" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M4 16h12" stroke-linecap="round"/>
                    </svg>
                    <span>Simpan &amp; Unggah Raport</span>
                </button>
            </div>

        </form>

    </div>

    <div class="mt-6 max-w-3xl flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 px-1">
        <span class="font-mono text-[10px] tracking-[0.2em] uppercase text-ink-400">
            SIDAKA · Unggah v2.0
        </span>
        <span class="font-mono text-[10px] tracking-[0.2em] uppercase text-ink-400">
            Dokumen otomatis terhubung ke akun siswa
        </span>
    </div>

</x-layouts.app>