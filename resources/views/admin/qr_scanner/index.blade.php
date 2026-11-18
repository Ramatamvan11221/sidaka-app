<x-layouts.app title="Scan / Input QR Code - SIDAKA">
    <x-slot name="header">Pemindaian & Verifikasi Transaksi</x-slot>

    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-5 sm:gap-6" x-data="qrScanner()">

        {{-- ═══════════════════════════════════════════════════════════
             PANEL KIRI — INPUT
             ═══════════════════════════════════════════════════════════ --}}
        <div class="lg:col-span-5 rounded-2xl border border-black/[0.06] bg-white/85 backdrop-blur-xl
                    shadow-[0_1px_2px_rgba(0,0,0,0.03),0_8px_24px_rgba(0,0,0,0.04)] overflow-hidden">

            {{-- Panel header --}}
            <div class="px-5 sm:px-6 py-4 border-b border-black/[0.06] flex items-center justify-between gap-4">
                <div class="flex items-center gap-2">
                    <span class="w-1.5 h-1.5 rounded-full bg-accent"></span>
                    <span class="font-mono text-[10px] tracking-[0.2em] uppercase text-ink-400">01 — Input</span>
                </div>
                <span class="font-mono text-[9px] tracking-widest uppercase text-ink-300">Scanner</span>
            </div>

            <div class="p-5 sm:p-6 space-y-5">

                {{-- ═══ Segmented control ═══ --}}
                <div class="relative bg-neutral-100 border border-black/[0.06] rounded-xl p-1 flex items-center">
                    <div class="absolute top-1 bottom-1 w-[calc(50%-4px)] rounded-lg bg-ink-900
                                shadow-[0_2px_8px_rgba(0,0,0,0.15)]
                                transition-all duration-300 ease-[cubic-bezier(0.16,1,0.3,1)]"
                         :class="mode === 'manual' ? 'left-1' : 'left-[calc(50%+1px)]'"></div>

                    <button type="button" @click="mode = 'manual'"
                            class="relative z-10 flex-1 h-9 inline-flex items-center justify-center gap-2
                                   text-[11px] font-medium rounded-lg transition-colors duration-200"
                            :class="mode === 'manual' ? 'text-white' : 'text-ink-500 hover:text-ink-900'">
                        <svg class="w-3.5 h-3.5" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.6">
                            <rect x="2" y="5" width="16" height="10" rx="1.5"/>
                            <path d="M6 10h.01M10 10h.01M14 10h.01" stroke-linecap="round"/>
                        </svg>
                        <span>Manual</span>
                    </button>

                    <button type="button" @click="mode = 'camera'"
                            class="relative z-10 flex-1 h-9 inline-flex items-center justify-center gap-2
                                   text-[11px] font-medium rounded-lg transition-colors duration-200"
                            :class="mode === 'camera' ? 'text-white' : 'text-ink-500 hover:text-ink-900'">
                        <svg class="w-3.5 h-3.5" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.6">
                            <path d="M3 7a1 1 0 011-1h1.5l1-1.5h7l1 1.5H16a1 1 0 011 1v9a1 1 0 01-1 1H4a1 1 0 01-1-1V7z" stroke-linejoin="round"/>
                            <circle cx="10" cy="11.5" r="3"/>
                        </svg>
                        <span>Kamera</span>
                    </button>
                </div>

                {{-- ═══ Mode: Manual ═══ --}}
                <div x-show="mode === 'manual'"
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 translate-y-1"
                     x-transition:enter-end="opacity-100 translate-y-0"
                     class="space-y-4">

                    <div>
                        <label for="manual_token" class="block text-[11px] font-medium text-ink-700 uppercase tracking-wider mb-2">
                            Token UUID / Nomor Pengajuan
                        </label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-ink-400">
                                <svg class="w-4 h-4" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.6">
                                    <rect x="2.5" y="5" width="15" height="10" rx="1.5"/>
                                    <path d="M6 10h.01M10 10h.01M14 10h.01" stroke-linecap="round"/>
                                </svg>
                            </span>
                            <input type="text" id="manual_token"
                                   x-model="manualInput"
                                   @keydown.enter.prevent="submitManual()"
                                   placeholder="Tempel token atau nomor pengajuan..."
                                   class="w-full h-12 pl-10 pr-4 rounded-xl bg-white border border-black/[0.08]
                                          text-[13px] font-mono text-ink-900
                                          placeholder:text-ink-300 placeholder:font-sans
                                          transition outline-none
                                          focus:border-accent/50 focus:ring-4 focus:ring-accent/10">
                        </div>
                        <p class="mt-2 font-mono text-[10px] tracking-wider uppercase text-ink-400">
                            Tekan Enter untuk verifikasi cepat
                        </p>
                    </div>

                    <button @click="submitManual()"
                            class="w-full inline-flex items-center justify-center gap-2 h-12 rounded-xl
                                   bg-ink-900 hover:bg-ink-700 text-white text-[12px] font-medium
                                   transition-all duration-200 active:scale-[0.98]">
                        <svg class="w-3.5 h-3.5" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.75">
                            <circle cx="9" cy="9" r="6"/>
                            <path d="M14 14l4 4" stroke-linecap="round"/>
                        </svg>
                        <span>Cari &amp; Verifikasi</span>
                    </button>
                </div>

                {{-- ═══ Mode: Camera ═══ --}}
                <div x-show="mode === 'camera'"
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 translate-y-1"
                     x-transition:enter-end="opacity-100 translate-y-0"
                     style="display: none;"
                     class="space-y-4">

                    {{-- Reader container --}}
                    <div class="relative rounded-xl overflow-hidden bg-ink-900 border border-black/[0.06] min-h-[260px]">
                        <div id="reader" class="w-full h-full absolute inset-0"></div>

                        {{-- Scan frame corners --}}
                        <div class="absolute inset-0 pointer-events-none flex items-center justify-center">
                            <div class="relative w-40 h-40">
                                <span class="absolute top-0 left-0 w-5 h-5 border-t-2 border-l-2 border-accent rounded-tl-md"></span>
                                <span class="absolute top-0 right-0 w-5 h-5 border-t-2 border-r-2 border-accent rounded-tr-md"></span>
                                <span class="absolute bottom-0 left-0 w-5 h-5 border-b-2 border-l-2 border-accent rounded-bl-md"></span>
                                <span class="absolute bottom-0 right-0 w-5 h-5 border-b-2 border-r-2 border-accent rounded-br-md"></span>
                            </div>
                        </div>

                        {{-- Standby hint --}}
                        <div class="absolute inset-0 flex items-center justify-center pointer-events-none">
                            <div class="text-center">
                                <p class="font-mono text-[10px] tracking-[0.2em] uppercase text-white/40">Kamera belum aktif</p>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <button @click="startScanner()"
                                class="inline-flex items-center justify-center gap-2 h-11 rounded-xl
                                       bg-ink-900 hover:bg-ink-700 text-white text-[12px] font-medium
                                       transition-all duration-200 active:scale-[0.98]">
                            <svg class="w-3.5 h-3.5" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.6">
                                <path d="M3 7a1 1 0 011-1h1.5l1-1.5h7l1 1.5H16a1 1 0 011 1v9a1 1 0 01-1 1H4a1 1 0 01-1-1V7z" stroke-linejoin="round"/>
                                <circle cx="10" cy="11.5" r="3"/>
                            </svg>
                            <span>Buka Kamera</span>
                        </button>

                        <button @click="stopScanner()"
                                class="inline-flex items-center justify-center gap-2 h-11 rounded-xl
                                       bg-white border border-black/[0.08] text-ink-700 hover:bg-neutral-50
                                       text-[12px] font-medium
                                       transition-all duration-200 active:scale-[0.98]">
                            <svg class="w-3.5 h-3.5" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.75">
                                <rect x="5" y="5" width="10" height="10" rx="1.5"/>
                            </svg>
                            <span>Tutup</span>
                        </button>
                    </div>
                </div>

            </div>
        </div>

        {{-- ═══════════════════════════════════════════════════════════
             PANEL KANAN — HASIL
             ═══════════════════════════════════════════════════════════ --}}
        <div class="lg:col-span-7 rounded-2xl border border-black/[0.06] bg-white/85 backdrop-blur-xl
                    shadow-[0_1px_2px_rgba(0,0,0,0.03),0_8px_24px_rgba(0,0,0,0.04)]
                    overflow-hidden flex flex-col">

            {{-- Panel header --}}
            <div class="px-5 sm:px-6 py-4 border-b border-black/[0.06] flex items-center justify-between gap-4">
                <div class="flex items-center gap-2">
                    <span class="w-1.5 h-1.5 rounded-full bg-accent"></span>
                    <span class="font-mono text-[10px] tracking-[0.2em] uppercase text-ink-400">02 — Hasil Verifikasi</span>
                </div>
                <span class="font-mono text-[9px] tracking-widest uppercase"
                      :class="result ? 'text-accent' : 'text-ink-300'"
                      x-text="result ? '● Verified' : '○ Standby'"></span>
            </div>

            <div class="flex-1 p-5 sm:p-6">

                {{-- ═══ Loading state ═══ --}}
                <template x-if="loading">
                    <div class="py-16 text-center">
                        <div class="w-12 h-12 mx-auto rounded-2xl bg-neutral-50 border border-black/[0.06]
                                    flex items-center justify-center">
                            <svg class="w-5 h-5 text-ink-400 animate-spin" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M12 3a9 9 0 019 9" stroke-linecap="round"/>
                            </svg>
                        </div>
                        <p class="mt-5 text-[13px] font-medium text-ink-900">Memproses verifikasi...</p>
                        <p class="mt-1 font-mono text-[10px] tracking-wider uppercase text-ink-400">Mohon tunggu sebentar</p>
                    </div>
                </template>

                {{-- ═══ Empty state ═══ --}}
                <template x-if="!loading && !result">
                    <div class="py-16 text-center">
                        <div class="w-14 h-14 mx-auto rounded-2xl bg-neutral-50 border border-black/[0.06]
                                    flex items-center justify-center">
                            <svg class="w-6 h-6 text-ink-300" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                <rect x="3" y="3" width="7" height="7" rx="1.5"/>
                                <rect x="14" y="3" width="7" height="7" rx="1.5"/>
                                <rect x="3" y="14" width="7" height="7" rx="1.5"/>
                                <path d="M14 14h3v3h-3zM20 14h1M14 20h1M20 20h1M20 17h1M17 20h1" stroke-linecap="round"/>
                            </svg>
                        </div>
                        <p class="mt-5 text-[14px] font-medium text-ink-900">Belum ada berkas terverifikasi</p>
                        <p class="mt-2 text-[12px] text-ink-500 max-w-xs mx-auto leading-relaxed">
                            Ketik nomor pengajuan atau arahkan kamera ke QR Code milik siswa untuk memulai verifikasi.
                        </p>
                    </div>
                </template>

                {{-- ═══ Result ═══ --}}
                <template x-if="result">
                    <div class="space-y-5">

                        {{-- Nomor + status badge --}}
                        <div class="rounded-xl border border-[#0A84FF]/15 bg-[#EAF3FF]/60 p-4
                                    flex items-center justify-between gap-4">
                            <div class="min-w-0">
                                <p class="font-mono text-[10px] tracking-[0.2em] uppercase text-[#0055CC]/70">
                                    Nomor Pengajuan
                                </p>
                                <p class="mt-1 font-mono text-[15px] sm:text-[17px] font-medium text-ink-900 truncate"
                                   x-text="result.request_number"></p>
                            </div>
                            <x-status-badge ::status="result.status" />
                        </div>

                        {{-- Info grid --}}
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-px bg-black/[0.06]
                                    border border-black/[0.06] rounded-xl overflow-hidden">
                            <div class="bg-white px-4 py-3.5">
                                <p class="font-mono text-[10px] tracking-wider uppercase text-ink-400">Nama Siswa</p>
                                <p class="mt-1 text-[13px] font-medium text-ink-900" x-text="result.student_name"></p>
                            </div>
                            <div class="bg-white px-4 py-3.5">
                                <p class="font-mono text-[10px] tracking-wider uppercase text-ink-400">Kelas</p>
                                <p class="mt-1 text-[13px] font-medium text-ink-900" x-text="result.class"></p>
                            </div>
                        </div>

                        {{-- Layanan --}}
                        <div class="rounded-xl border border-black/[0.06] bg-neutral-50/60 px-4 py-3.5">
                            <p class="font-mono text-[10px] tracking-wider uppercase text-ink-400">Layanan</p>
                            <p class="mt-1 text-[13px] font-medium text-ink-900" x-text="result.service_type"></p>
                        </div>

                        {{-- Dokumen fisik --}}
                        <div>
                            <div class="flex items-center gap-2 mb-3">
                                <span class="w-1.5 h-1.5 rounded-full bg-accent"></span>
                                <span class="font-mono text-[10px] tracking-[0.2em] uppercase text-ink-400">
                                    Dokumen Fisik Yang Harus Diserahkan
                                </span>
                            </div>
                            <ul class="rounded-xl border border-black/[0.06] bg-white divide-y divide-black/[0.05]">
                                <template x-for="doc in result.documents">
                                    <li class="flex items-center gap-3 px-4 py-3">
                                        <span class="shrink-0 w-6 h-6 rounded-lg bg-neutral-100 border border-black/[0.06]
                                                     flex items-center justify-center">
                                            <svg class="w-3 h-3 text-ink-500" viewBox="0 0 12 12" fill="none" stroke="currentColor" stroke-width="1.5">
                                                <path d="M3 1.5h4l2 2v7a.5.5 0 01-.5.5h-5a.5.5 0 01-.5-.5v-8a.5.5 0 01.5-.5z"/>
                                                <path d="M7 1.5V4h2" stroke-linejoin="round"/>
                                            </svg>
                                        </span>
                                        <span class="flex-1 text-[12.5px] font-medium text-ink-900" x-text="doc.title"></span>
                                        <span class="font-mono text-[10px] tracking-wider uppercase text-ink-400" x-text="doc.type"></span>
                                    </li>
                                </template>
                            </ul>
                        </div>
                    </div>
                </template>

            </div>

            {{-- ═══ Handover action (conditional) ═══ --}}
            <template x-if="result && result.status === 'ready'">
                <form :action="'/admin/service-requests/' + result.id + '/handover'" method="POST"
                      class="border-t border-black/[0.06] px-5 sm:px-6 py-4 bg-emerald-500/[0.04]">
                    @csrf
                    <input type="hidden" name="notes" value="Dokumen diserahkan via verifikasi sistem.">
                    <button type="submit"
                            class="w-full inline-flex items-center justify-center gap-2 h-12 rounded-xl
                                   bg-emerald-500 hover:bg-emerald-600 text-white text-[12px] font-medium
                                   transition-all duration-200 active:scale-[0.98]
                                   shadow-[0_2px_8px_rgba(15,181,122,0.25)]">
                        <svg class="w-4 h-4" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M5 10.5l3.5 3.5L15 7" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        <span>Konfirmasi Penyerahan Dokumen Ke Siswa</span>
                    </button>
                </form>
            </template>

        </div>
    </div>

    <script>
        function qrScanner() {
            return {
                mode: 'manual',
                manualInput: '',
                html5QrCode: null,
                loading: false,
                result: null,

                submitManual() {
                    if(!this.manualInput.trim()) return;
                    this.validateToken(this.manualInput.trim());
                },

                startScanner() {
                    this.html5QrCode = new Html5Qrcode("reader");
                    this.html5QrCode.start(
                        { facingMode: "environment" },
                        { fps: 10, qrbox: { width: 220, height: 220 } },
                        (decodedText) => {
                            this.stopScanner();
                            this.validateToken(decodedText);
                        }
                    ).catch(() => {
                        Swal.fire({
                            icon: 'error',
                            title: 'Kamera tidak bisa diakses',
                            text: 'Pastikan izin kamera sudah diberikan dan tidak ada aplikasi lain yang sedang menggunakannya.',
                            confirmButtonColor: '#0A0A0A'
                        });
                    });
                },

                stopScanner() {
                    if (this.html5QrCode) {
                        this.html5QrCode.stop();
                    }
                },

                validateToken(token) {
                    this.loading = true;
                    fetch('/admin/qr-scanner/validate', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({ token: token })
                    })
                    .then(res => res.json())
                    .then(data => {
                        this.loading = false;
                        if(data.success) {
                            this.result = data.data;
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Tidak ditemukan',
                                text: 'Data pengajuan tidak ditemukan atau token tidak valid.',
                                confirmButtonColor: '#0A0A0A'
                            });
                        }
                    })
                    .catch(() => {
                        this.loading = false;
                        Swal.fire({
                            icon: 'error',
                            title: 'Verifikasi gagal',
                            text: 'Gagal memverifikasi token. Periksa koneksi Anda dan coba lagi.',
                            confirmButtonColor: '#0A0A0A'
                        });
                    });
                }
            }
        }
    </script>
</x-layouts.app>