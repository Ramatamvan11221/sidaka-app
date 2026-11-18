<x-layouts.app title="Edit Dokumen - Guru SIDAKA">
    <x-slot name="header">Edit Dokumen Akademik</x-slot>

    {{-- ═══════════════════════════════════════════════════════════
         BACK LINK + INTRO
         ═══════════════════════════════════════════════════════════ --}}
    <div class="mb-6 sm:mb-8 max-w-3xl">
        <a href="{{ route('teacher.documents.index') }}"
           class="group inline-flex items-center gap-2 h-8 pr-3 pl-2.5 -ml-2 rounded-lg
                  text-[11px] font-medium text-ink-500 hover:text-ink-900 hover:bg-black/[0.04]
                  transition-all duration-200 mb-5">
            <svg class="w-3.5 h-3.5 opacity-70 group-hover:-translate-x-0.5 transition-transform duration-200"
                 viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.75">
                <path d="M13 8H3M7 4L3 8l4 4" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            <span>Kembali ke Daftar Dokumen</span>
        </a>

        <div class="flex items-center gap-2 mb-2.5">
            <span class="w-1.5 h-1.5 rounded-full bg-accent"></span>
            <span class="font-mono text-[10px] tracking-[0.2em] uppercase text-ink-400">Edit · Dokumen</span>
        </div>
        <h2 class="text-[20px] sm:text-[24px] leading-tight tracking-[-0.02em] font-semibold text-ink-900 text-balance">
            Perbarui detail dokumen.
        </h2>
        <p class="mt-3 max-w-xl text-[12.5px] text-ink-500 leading-relaxed">
            Ubah jenis, judul, atau ganti file dokumen yang sudah diunggah. Perubahan langsung tersimpan setelah disimpan.
        </p>
    </div>

    {{-- ═══════════════════════════════════════════════════════════
         FORM PANEL
         ═══════════════════════════════════════════════════════════ --}}
    <div class="max-w-3xl rounded-2xl border border-black/[0.06] bg-white/85 backdrop-blur-xl
                shadow-[0_1px_0_rgba(255,255,255,0.9)_inset,0_1px_2px_rgba(0,0,0,0.03),0_8px_24px_rgba(0,0,0,0.04)]
                overflow-hidden">

        {{-- Panel header --}}
        <div class="px-5 sm:px-6 py-4 border-b border-black/[0.06] flex items-center justify-between gap-4">
            <div class="flex items-center gap-2.5">
                <span class="w-1.5 h-1.5 rounded-full bg-accent"></span>
                <span class="font-mono text-[10px] tracking-[0.2em] uppercase text-ink-400">Formulir Edit</span>
            </div>
            <span class="font-mono text-[9px] tracking-widest uppercase text-ink-300">Guru</span>
        </div>

        {{-- Form --}}
        <form action="{{ route('teacher.documents.update', $document) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="p-5 sm:p-8 space-y-8">

                {{-- ═══════════════════════════════════════════════════════
                     SECTION 01 — JENIS DOKUMEN
                     ═══════════════════════════════════════════════════════ --}}
                <section>
                    <div class="flex items-center gap-2 mb-4">
                        <span class="font-mono text-[10px] font-medium tracking-[0.2em] uppercase text-ink-300">01</span>
                        <span class="w-6 h-px bg-ink-900"></span>
                        <span class="font-mono text-[10px] tracking-[0.2em] uppercase text-ink-700">Klasifikasi</span>
                    </div>

                    <label for="document_type_id" class="block text-[11px] font-medium text-ink-700 uppercase tracking-wider mb-2">
                        Jenis Dokumen <span class="text-danger">*</span>
                    </label>

                    <select name="document_type_id" id="document_type_id" required
                            class="w-full h-11 px-3.5 rounded-xl bg-white border border-black/[0.08]
                                   text-[13px] text-ink-900
                                   transition outline-none
                                   focus:border-accent/50 focus:ring-4 focus:ring-accent/10">
                        @foreach($documentTypes as $type)
                            <option value="{{ $type->id }}" {{ (old('document_type_id', $document->document_type_id) == $type->id) ? 'selected' : '' }}>
                                {{ $type->name }}
                            </option>
                        @endforeach
                    </select>

                    <p class="mt-2 font-mono text-[10px] tracking-wider uppercase text-ink-400">
                        Ubah kategori jika dokumen berpindah klasifikasi
                    </p>
                </section>

                {{-- ═══════════════════════════════════════════════════════
                     SECTION 02 — JUDUL DOKUMEN
                     ═══════════════════════════════════════════════════════ --}}
                <section>
                    <div class="flex items-center gap-2 mb-4">
                        <span class="font-mono text-[10px] font-medium tracking-[0.2em] uppercase text-ink-300">02</span>
                        <span class="w-6 h-px bg-ink-900"></span>
                        <span class="font-mono text-[10px] tracking-[0.2em] uppercase text-ink-700">Identitas Dokumen</span>
                    </div>

                    <label for="title" class="block text-[11px] font-medium text-ink-700 uppercase tracking-wider mb-2">
                        Judul Dokumen <span class="text-danger">*</span>
                    </label>

                    <input type="text" name="title" id="title" value="{{ old('title', $document->title) }}" required
                           placeholder="Contoh: Ijazah Asli SMK Ramaditya"
                           class="w-full h-11 px-3.5 rounded-xl bg-white border border-black/[0.08]
                                  text-[13px] text-ink-900
                                  placeholder:text-ink-300
                                  transition outline-none
                                  focus:border-accent/50 focus:ring-4 focus:ring-accent/10">

                    <p class="mt-2 font-mono text-[10px] tracking-wider uppercase text-ink-400">
                        Gunakan judul yang jelas &amp; mudah dikenali
                    </p>
                </section>

                {{-- ═══════════════════════════════════════════════════════
                     SECTION 03 — GANTI FILE (OPSIONAL)
                     ═══════════════════════════════════════════════════════ --}}
                <section>
                    <div class="flex items-center gap-2 mb-4">
                        <span class="font-mono text-[10px] font-medium tracking-[0.2em] uppercase text-ink-300">03</span>
                        <span class="w-6 h-px bg-ink-900"></span>
                        <span class="font-mono text-[10px] tracking-[0.2em] uppercase text-ink-700">Ganti Berkas</span>
                        <span class="inline-flex items-center h-5 px-2 rounded-md
                                     bg-neutral-100 border border-black/[0.06]
                                     font-mono text-[9px] tracking-wider uppercase text-ink-400">Opsional</span>
                    </div>

                    <label for="file" class="block text-[11px] font-medium text-ink-700 uppercase tracking-wider mb-2">
                        File Pengganti
                    </label>

                    <input type="file" name="file" id="file"
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

                    {{-- Info file lama --}}
                    <div class="mt-4 rounded-xl border border-black/[0.06] bg-neutral-50/60 px-4 py-3.5">
                        <div class="flex items-start gap-3">

                            {{-- Icon --}}
                            <div class="shrink-0 w-9 h-9 rounded-xl bg-white border border-black/[0.06]
                                        flex items-center justify-center mt-0.5">
                                <svg class="w-4 h-4 text-ink-500" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.6">
                                    <path d="M5 2.5h7l3.5 3.5v11a1 1 0 01-1 1h-9.5a1 1 0 01-1-1V3.5a1 1 0 011-1z" stroke-linejoin="round"/>
                                    <path d="M12 2.5v4h4" stroke-linejoin="round"/>
                                    <path d="M7 11h6M7 14h4" stroke-linecap="round"/>
                                </svg>
                            </div>

                            {{-- Info --}}
                            <div class="min-w-0 flex-1">
                                <p class="font-mono text-[9px] tracking-[0.2em] uppercase text-ink-400 mb-1">
                                    File Saat Ini
                                </p>
                                <p class="text-[12.5px] font-medium text-ink-900 truncate">
                                    {{ $document->original_name }}
                                </p>
                                <p class="mt-1.5 text-[11px] text-ink-500 leading-relaxed">
                                    Kosongkan field di atas jika tidak ingin mengganti file yang sudah ada.
                                </p>
                            </div>

                        </div>
                    </div>
                </section>

            </div>

            {{-- ═══════════════════════════════════════════════════════════
                 FORM FOOTER — Actions
                 ═══════════════════════════════════════════════════════════ --}}
            <div class="px-5 sm:px-8 py-5 border-t border-black/[0.06] bg-neutral-50/40
                        flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">

                {{-- Cancel link --}}
                <a href="{{ route('teacher.documents.index') }}"
                   class="order-2 sm:order-1 inline-flex items-center justify-center gap-2 h-11 px-5 rounded-xl
                          bg-white border border-black/[0.08] text-ink-700
                          hover:bg-neutral-50 hover:border-black/[0.14]
                          text-[12px] font-medium
                          transition-all duration-200 active:scale-[0.98]">
                    <svg class="w-3.5 h-3.5 opacity-70" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.75">
                        <path d="M4 4l8 8M12 4l-8 8" stroke-linecap="round"/>
                    </svg>
                    <span>Batal</span>
                </a>

                {{-- Submit --}}
                <button type="submit"
                        class="order-1 sm:order-2 inline-flex items-center justify-center gap-2 h-11 px-6 rounded-xl
                               bg-ink-900 hover:bg-ink-700 text-white text-[12px] font-medium
                               transition-all duration-200 active:scale-[0.98]">
                    <svg class="w-3.5 h-3.5 opacity-80" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.75">
                        <path d="M5 10.5l3.5 3.5L15 7" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <span>Perbarui Dokumen</span>
                </button>
            </div>

        </form>

    </div>

    {{-- Footer note --}}
    <div class="mt-6 max-w-3xl flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 px-1">
        <span class="font-mono text-[10px] tracking-[0.2em] uppercase text-ink-400">
            SIDAKA · Edit v2.0
        </span>
        <span class="font-mono text-[10px] tracking-[0.2em] uppercase text-ink-400">
            Perubahan berlaku langsung setelah disimpan
        </span>
    </div>

</x-layouts.app>