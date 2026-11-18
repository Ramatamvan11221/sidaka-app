<x-layouts.app title="Pengajuan Layanan Baru - SIDAKA">
    <x-slot name="header">Buat Pengajuan Layanan Baru</x-slot>

    {{-- ═══════════════════════════════════════════════════════════
         INTRO STRIP
         ═══════════════════════════════════════════════════════════ --}}
    <div class="mb-6 sm:mb-8 max-w-3xl">
        <div class="flex items-center gap-2 mb-2.5">
            <span class="w-1.5 h-1.5 rounded-full bg-accent"></span>
            <span class="font-mono text-[10px] tracking-[0.2em] uppercase text-ink-400">Formulir · Baru</span>
        </div>
        <h2 class="text-[20px] sm:text-[24px] leading-tight tracking-[-0.02em] font-semibold text-ink-900 text-balance">
            Ajukan pengambilan dokumen akademik.
        </h2>
        <p class="mt-3 max-w-xl text-[12.5px] text-ink-500 leading-relaxed">
            Isi jenis layanan, pilih dokumen yang ingin diambil, lalu jelaskan keperluannya. Petugas TU akan memproses pengajuanmu.
        </p>
    </div>

    {{-- Error Validation Alert --}}
    @if ($errors->any())
        <div class="mb-6 max-w-3xl p-4 rounded-2xl bg-danger/5 border border-danger/20 text-danger">
            <p class="font-mono text-[10px] tracking-wider uppercase font-semibold mb-1.5">Periksa Kembali Inputanmu:</p>
            <ul class="list-disc list-inside text-[12px] space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- ═══════════════════════════════════════════════════════════
         FORM PANEL
         ═══════════════════════════════════════════════════════════ --}}
    <div class="max-w-3xl rounded-2xl border border-black/[0.06] bg-white/85 backdrop-blur-xl
                shadow-[0_1px_0_rgba(255,255,255,0.9)_inset,0_1px_2px_rgba(0,0,0,0.03),0_8px_24px_rgba(0,0,0,0.04)]
                overflow-hidden"
         x-data="{
             selectedServiceId: '{{ old('service_type_id') }}',
             services: @js($serviceTypes->mapWithKeys(fn($s) => [$s->id => strtolower($s->name)])),

             get serviceMode() {
                 let name = this.services[this.selectedServiceId] || '';
                 if (name.includes('ijazah')) return 'ijazah';
                 if (name.includes('rapor')) return 'raport';
                 if (name.includes('sertifikat')) return 'sertifikat';
                 return 'all';
             },

             get isSingleSelect() {
                 return this.serviceMode === 'ijazah' || this.serviceMode === 'raport';
             },

             resetSelections() {
                 this.$el.querySelectorAll('input[name=\'document_ids[]\']').forEach(el => el.checked = false);
             }
         }">

        {{-- Panel header --}}
        <div class="px-5 sm:px-6 py-4 border-b border-black/[0.06] flex items-center justify-between gap-4">
            <div class="flex items-center gap-2.5">
                <span class="w-1.5 h-1.5 rounded-full bg-accent"></span>
                <span class="font-mono text-[10px] tracking-[0.2em] uppercase text-ink-400">Pengajuan Layanan</span>
            </div>
            <span class="font-mono text-[9px] tracking-widest uppercase text-ink-300">Siswa</span>
        </div>

        {{-- Form --}}
        <form action="{{ route('student.service-requests.store') }}" method="POST">
            @csrf

            <div class="p-5 sm:p-8 space-y-8">

                {{-- ═══════════════════════════════════════════════════════
                     SECTION 01 — JENIS LAYANAN
                     ═══════════════════════════════════════════════════════ --}}
                <section>
                    <div class="flex items-center gap-2 mb-4">
                        <span class="font-mono text-[10px] font-medium tracking-[0.2em] uppercase text-ink-300">01</span>
                        <span class="w-6 h-px bg-ink-900"></span>
                        <span class="font-mono text-[10px] tracking-[0.2em] uppercase text-ink-700">Jenis Layanan</span>
                    </div>

                    <label for="service_type_id" class="block text-[11px] font-medium text-ink-700 uppercase tracking-wider mb-2">
                        Pilih Jenis Layanan <span class="text-danger">*</span>
                    </label>

                    <select name="service_type_id" id="service_type_id"
                            x-model="selectedServiceId"
                            @change="resetSelections()"
                            required
                            class="w-full h-11 px-3.5 rounded-xl bg-white border border-black/[0.08]
                                   text-[13px] text-ink-900
                                   transition outline-none
                                   focus:border-accent/50 focus:ring-4 focus:ring-accent/10">
                        <option value="">— Pilih Layanan —</option>
                        @foreach($serviceTypes as $type)
                            <option value="{{ $type->id }}" {{ old('service_type_id') == $type->id ? 'selected' : '' }}>
                                {{ $type->name }}
                            </option>
                        @endforeach
                    </select>

                    <p class="mt-2 font-mono text-[10px] tracking-wider uppercase text-ink-400">
                        Tentukan layanan sesuai kebutuhanmu
                    </p>
                </section>

                {{-- ═══════════════════════════════════════════════════════
                     SECTION 02 — PILIH DOKUMEN
                     ═══════════════════════════════════════════════════════ --}}
                <section>
                    <div class="flex items-center gap-2 mb-4">
                        <span class="font-mono text-[10px] font-medium tracking-[0.2em] uppercase text-ink-300">02</span>
                        <span class="w-6 h-px bg-ink-900"></span>
                        <span class="font-mono text-[10px] tracking-[0.2em] uppercase text-ink-700">Dokumen</span>
                    </div>

                    <div class="flex items-baseline justify-between gap-3 mb-2">
                        <label class="block text-[11px] font-medium text-ink-700 uppercase tracking-wider">
                            Pilih Dokumen <span class="text-danger">*</span>
                        </label>
                        <span class="font-mono text-[10px] tracking-wider uppercase text-ink-400">
                            {{ $verifiedDocuments->count() ?? 0 }} tersedia
                        </span>
                    </div>

                    <div class="rounded-xl border border-black/[0.06] bg-neutral-50/50 overflow-hidden">

                        {{-- State jika belum memilih jenis layanan --}}
                        <div x-show="selectedServiceId === ''" class="py-10 px-4 text-center">
                            <p class="text-[12.5px] font-medium text-ink-700">Pilih jenis layanan terlebih dahulu</p>
                            <p class="mt-1 font-mono text-[10px] tracking-wider uppercase text-ink-400">
                                Daftar dokumen akan menyesuaikan layanan yang dipilih
                            </p>
                        </div>

                        {{-- Daftar dokumen terfilter --}}
                        <div x-show="selectedServiceId !== ''" x-cloak class="max-h-64 overflow-y-auto p-2.5 space-y-1.5">
                            @forelse($verifiedDocuments as $doc)
                                @php
                                    // Fallback otomatis ke nama documentType jika kolom category belum diisi
                                    $docCategory = strtolower($doc->category ?? '');
                                    if ($docCategory === '') {
                                        $typeName = strtolower($doc->documentType->name ?? '');
                                        if (str_contains($typeName, 'ijazah') || str_contains($typeName, 'skl')) {
                                            $docCategory = 'ijazah';
                                        } elseif (str_contains($typeName, 'rapor')) {
                                            $docCategory = 'raport';
                                        } elseif (str_contains($typeName, 'sertifikat')) {
                                            $docCategory = 'sertifikat';
                                        } else {
                                            $docCategory = 'all';
                                        }
                                    }
                                @endphp

                                <label x-show="serviceMode === 'all' || serviceMode === '{{ $docCategory }}'"
                                       class="group flex items-start gap-3 p-3 rounded-lg
                                              bg-white border border-black/[0.06]
                                              cursor-pointer
                                              hover:border-accent/40 hover:bg-[#EAF3FF]/40
                                              transition-colors duration-200">

                                    {{-- Custom Radio / Checkbox Dinamis --}}
                                    <span class="relative shrink-0 mt-0.5">
                                        <input :type="isSingleSelect ? 'radio' : 'checkbox'"
                                               name="document_ids[]"
                                               value="{{ $doc->id }}"
                                               class="peer sr-only">

                                        {{-- Box / Circle Visual --}}
                                        <span :class="isSingleSelect ? 'rounded-full' : 'rounded'"
                                              class="block w-4 h-4 border-[1.5px] border-black/20
                                                     bg-white transition-all duration-200
                                                     peer-checked:bg-accent peer-checked:border-accent
                                                     peer-focus-visible:ring-2 peer-focus-visible:ring-accent/30 peer-focus-visible:ring-offset-1"></span>

                                        {{-- Check icon (untuk Checkbox) --}}
                                        <svg x-show="!isSingleSelect"
                                             class="absolute inset-0 w-4 h-4 text-white opacity-0
                                                    peer-checked:opacity-100 transition-opacity duration-200 pointer-events-none"
                                             viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="2.5">
                                            <path d="M4 8l2.5 2.5L12 5.5" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>

                                        {{-- Dot icon (untuk Radio Button) --}}
                                        <span x-show="isSingleSelect"
                                              class="absolute inset-0 m-auto w-1.5 h-1.5 rounded-full bg-white opacity-0
                                                     peer-checked:opacity-100 transition-opacity duration-200 pointer-events-none"></span>
                                    </span>

                                    {{-- Text --}}
                                    <div class="min-w-0 flex-1">
                                        <p class="text-[13px] font-medium text-ink-900 leading-snug">
                                            {{ $doc->title }}
                                        </p>
                                        <p class="mt-0.5 font-mono text-[10px] tracking-wider uppercase text-ink-400">
                                            {{ $doc->documentType->name }} · {{ strtoupper($docCategory) }}
                                        </p>
                                    </div>

                                    {{-- Status icon --}}
                                    <svg class="w-3.5 h-3.5 text-ink-300 group-hover:text-ink-500 transition-colors shrink-0 mt-1"
                                         viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.5">
                                        <path d="M5 3h6l3 3v7a1 1 0 01-1 1H5a1 1 0 01-1-1V4a1 1 0 011-1z" stroke-linejoin="round"/>
                                        <path d="M11 3v3h3" stroke-linejoin="round"/>
                                    </svg>

                                </label>
                            @empty
                                <div class="py-10 text-center">
                                    <div class="w-12 h-12 mx-auto rounded-2xl bg-neutral-100 border border-black/[0.06]
                                                flex items-center justify-center">
                                        <svg class="w-5 h-5 text-ink-300" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                            <path d="M6 2.5h8.5L19 7v14a1 1 0 01-1 1H6a1 1 0 01-1-1V3.5a1 1 0 011-1z" stroke-linejoin="round"/>
                                            <path d="M14.5 2.5V7H19" stroke-linejoin="round"/>
                                            <path d="M9 13h6M9 16h4" stroke-linecap="round"/>
                                        </svg>
                                    </div>
                                    <p class="mt-4 text-[13px] font-medium text-ink-900">Belum ada dokumen terverifikasi</p>
                                    <p class="mt-1 text-[11.5px] text-ink-500 leading-relaxed max-w-xs mx-auto">
                                        Dokumen akan muncul di sini setelah guru memverifikasi unggahanmu.
                                    </p>
                                </div>
                            @endforelse
                        </div>

                    </div>

                    <p class="mt-2 font-mono text-[10px] tracking-wider uppercase text-ink-400"
                       x-text="selectedServiceId === '' ? 'Menunggu pilihan layanan' : (isSingleSelect ? 'Hanya dapat memilih 1 dokumen untuk layanan ini' : 'Bisa pilih lebih dari satu dokumen')">
                    </p>
                </section>

                {{-- ═══════════════════════════════════════════════════════
                     SECTION 03 — KEPERLUAN
                     ═══════════════════════════════════════════════════════ --}}
                <section>
                    <div class="flex items-center gap-2 mb-4">
                        <span class="font-mono text-[10px] font-medium tracking-[0.2em] uppercase text-ink-300">03</span>
                        <span class="w-6 h-px bg-ink-900"></span>
                        <span class="font-mono text-[10px] tracking-[0.2em] uppercase text-ink-700">Keperluan</span>
                    </div>

                    <label for="purpose" class="block text-[11px] font-medium text-ink-700 uppercase tracking-wider mb-2">
                        Keperluan Pengajuan <span class="text-danger">*</span>
                    </label>

                    <textarea name="purpose" id="purpose" rows="4" required
                              placeholder="Contoh: Untuk keperluan mendaftar kuliah di PTN..."
                              class="w-full px-3.5 py-3 rounded-xl bg-white border border-black/[0.08]
                                     text-[13px] text-ink-900 leading-relaxed
                                     placeholder:text-ink-300
                                     transition outline-none resize-none
                                     focus:border-accent/50 focus:ring-4 focus:ring-accent/10">{{ old('purpose') }}</textarea>

                    <p class="mt-2 font-mono text-[10px] tracking-wider uppercase text-ink-400">
                        Jelaskan secara singkat alasan pengajuan
                    </p>
                </section>

            </div>

            {{-- ═══════════════════════════════════════════════════════════
                 FORM FOOTER — Submit
                 ═══════════════════════════════════════════════════════════ --}}
            <div class="px-5 sm:px-8 py-5 border-t border-black/[0.06] bg-neutral-50/40
                        flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">

                <p class="font-mono text-[10px] tracking-wider uppercase text-ink-400 order-2 sm:order-1">
                    Pastikan semua data sudah benar
                </p>

                <button type="submit"
                        class="order-1 sm:order-2 inline-flex items-center justify-center gap-2 h-11 px-6 rounded-xl
                               bg-ink-900 hover:bg-ink-700 text-white text-[12px] font-medium
                               transition-all duration-200 active:scale-[0.98]">
                    <span>Kirim Pengajuan</span>
                    <svg class="w-3.5 h-3.5 opacity-70" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.75">
                        <path d="M3 8h10M9 4l4 4-4 4" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </button>
            </div>

        </form>

    </div>

    {{-- Footer note --}}
    <div class="mt-6 max-w-3xl flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 px-1">
        <span class="font-mono text-[10px] tracking-[0.2em] uppercase text-ink-400">
            SIDAKA · Formulir v2.0
        </span>
        <span class="font-mono text-[10px] tracking-[0.2em] uppercase text-ink-400">
            Petugas TU akan memproses dalam 1×24 jam
        </span>
    </div>

</x-layouts.app>