<x-layouts.app title="Scan QR Admin - SIDAKA">
    <x-slot name="header">Pindai QR Monitor Admin</x-slot>

    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>

    <style>
        @keyframes scanPulse {
            0%, 100% { opacity: 0.9; }
            50% { opacity: 0.35; }
        }
        .scan-pulse { animation: scanPulse 2s ease-in-out infinite; }

        /* Fix: QR reader container relative + absolute canvas */
        #reader {
            position: relative;
        }
        #reader video {
            width: 100% !important;
            height: 100% !important;
            object-fit: cover !important;
            display: block !important;
        }
    </style>

    <div class="min-h-[calc(100vh-200px)] flex items-start sm:items-center justify-center px-4 sm:px-6 py-6 sm:py-10">
        <div class="w-full max-w-md mx-auto" x-data="studentQrScanner()">

            {{-- ═══════════════════════════════════════════════════════════
                 MAIN CARD
                 ═══════════════════════════════════════════════════════════ --}}
            <div class="rounded-3xl border border-black/[0.06] bg-white/85 backdrop-blur-xl
                        shadow-[0_1px_0_rgba(255,255,255,0.9)_inset,0_1px_2px_rgba(0,0,0,0.03),0_16px_40px_rgba(0,0,0,0.06)]
                        overflow-hidden">

                {{-- ═══ Card header ═══ --}}
                <div class="px-6 py-4 border-b border-black/[0.06] flex items-center justify-between gap-4">
                    <div class="flex items-center gap-2">
                        <span class="w-1.5 h-1.5 rounded-full bg-accent"></span>
                        <span class="font-mono text-[10px] tracking-[0.2em] uppercase text-ink-400">Konfirmasi Penyerahan</span>
                    </div>
                    <span class="font-mono text-[9px] tracking-widest uppercase text-ink-300">Siswa</span>
                </div>

                {{-- ═══ Card body ═══ --}}
                <div class="p-6 sm:p-8 space-y-6">

                    {{-- Intro --}}
                    <div class="text-center">
                        <div class="inline-flex items-center justify-center w-12 h-12 rounded-2xl bg-[#EAF3FF] border border-[#0A84FF]/15 mb-4">
                            <svg class="w-5 h-5 text-[#0A84FF]" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.6">
                                <rect x="3" y="3" width="5" height="5" rx="1"/>
                                <rect x="12" y="3" width="5" height="5" rx="1"/>
                                <rect x="3" y="12" width="5" height="5" rx="1"/>
                                <path d="M12 12h2v2h-2zM16 12h1M12 16h1M14 14h1M17 17h1M17 14h1M14 17h1" stroke-linecap="round"/>
                            </svg>
                        </div>

                        <h3 class="text-[16px] font-semibold text-ink-900 tracking-tight">
                            Arahkan kamera ke monitor admin
                        </h3>
                        <p class="mt-2 text-[12.5px] text-ink-500 leading-relaxed max-w-xs mx-auto">
                            Pindai QR Code di layar PC petugas TU untuk mengonfirmasi pengambilan dokumenmu.
                        </p>
                    </div>

                    {{-- ═══ Camera reader ═══ --}}
                    <div class="relative rounded-2xl overflow-hidden bg-ink-900 border border-black/[0.06] min-h-[260px] sm:min-h-[280px]">

                        {{-- Reader canvas --}}
                        <div id="reader" class="w-full h-full absolute inset-0"></div>

                        {{-- Scan frame corners --}}
                        <div class="absolute inset-0 pointer-events-none flex items-center justify-center">
                            <div class="relative w-44 h-44 sm:w-48 sm:h-48">

                                {{-- Corner brackets --}}
                                <span class="absolute top-0 left-0 w-6 h-6 border-t-2 border-l-2 border-[#0A84FF] rounded-tl-lg"></span>
                                <span class="absolute top-0 right-0 w-6 h-6 border-t-2 border-r-2 border-[#0A84FF] rounded-tr-lg"></span>
                                <span class="absolute bottom-0 left-0 w-6 h-6 border-b-2 border-l-2 border-[#0A84FF] rounded-bl-lg"></span>
                                <span class="absolute bottom-0 right-0 w-6 h-6 border-b-2 border-r-2 border-[#0A84FF] rounded-br-lg"></span>

                                {{-- Scanning line animation --}}
                                <span class="absolute left-2 right-2 top-1/2 h-px bg-gradient-to-r from-transparent via-[#0A84FF] to-transparent scan-pulse"></span>
                            </div>
                        </div>

                        {{-- Standby hint --}}
                        <div class="absolute bottom-3 left-3 right-3 pointer-events-none flex items-center justify-center">
                            <div class="inline-flex items-center gap-2 h-7 px-3 rounded-full bg-black/50 backdrop-blur-sm border border-white/10">
                                <span class="w-1.5 h-1.5 rounded-full bg-[#0A84FF] scan-pulse"></span>
                                <span class="font-mono text-[9px] tracking-[0.2em] uppercase text-white/70">
                                    Kamera siap dipindai
                                </span>
                            </div>
                        </div>

                        {{-- Technical marker (Nothing-style) --}}
                        <span class="absolute top-3 left-3 font-mono text-[9px] tracking-[0.2em] uppercase text-white/40 pointer-events-none">
                            Reader · 01
                        </span>
                        <span class="absolute top-3 right-3 font-mono text-[9px] tracking-[0.2em] uppercase text-white/40 pointer-events-none">
                            Auto
                        </span>
                    </div>

                    {{-- ═══ Action buttons ═══ --}}
                    <div class="grid grid-cols-2 gap-3">
                        <button type="button" @click="startScanner()"
                                class="inline-flex items-center justify-center gap-2 h-11 rounded-xl
                                       bg-ink-900 hover:bg-ink-700 text-white text-[12px] font-medium
                                       transition-all duration-200 active:scale-[0.98]">
                            <svg class="w-3.5 h-3.5" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.6">
                                <path d="M3 7a1 1 0 011-1h1.5l1-1.5h7l1 1.5H16a1 1 0 011 1v9a1 1 0 01-1 1H4a1 1 0 01-1-1V7z" stroke-linejoin="round"/>
                                <circle cx="10" cy="11.5" r="3"/>
                            </svg>
                            <span>Buka Kamera</span>
                        </button>

                        <button type="button" @click="stopScanner()"
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

                    {{-- ═══ Step guide ═══ --}}
                    <div class="pt-5 border-t border-black/[0.06]">
                        <div class="flex items-center gap-2 mb-3.5">
                            <span class="w-1.5 h-1.5 rounded-full bg-accent"></span>
                            <span class="font-mono text-[9px] tracking-[0.2em] uppercase text-ink-400">Cara Pakai</span>
                        </div>

                        <ol class="space-y-2.5">
                            <li class="flex items-start gap-3">
                                <span class="shrink-0 w-5 h-5 rounded-md bg-neutral-100 border border-black/[0.06]
                                             flex items-center justify-center
                                             font-mono text-[9px] font-medium text-ink-700">1</span>
                                <p class="text-[11.5px] text-ink-500 leading-relaxed pt-0.5">
                                    Tap <span class="font-medium text-ink-900">Buka Kamera</span> dan izinkan akses kamera.
                                </p>
                            </li>
                            <li class="flex items-start gap-3">
                                <span class="shrink-0 w-5 h-5 rounded-md bg-neutral-100 border border-black/[0.06]
                                             flex items-center justify-center
                                             font-mono text-[9px] font-medium text-ink-700">2</span>
                                <p class="text-[11.5px] text-ink-500 leading-relaxed pt-0.5">
                                    Arahkan ke QR Code di monitor petugas Tata Usaha.
                                </p>
                            </li>
                            <li class="flex items-start gap-3">
                                <span class="shrink-0 w-5 h-5 rounded-md bg-neutral-100 border border-black/[0.06]
                                             flex items-center justify-center
                                             font-mono text-[9px] font-medium text-ink-700">3</span>
                                <p class="text-[11.5px] text-ink-500 leading-relaxed pt-0.5">
                                    Sistem otomatis memverifikasi dan mengonfirmasi penyerahan.
                                </p>
                            </li>
                        </ol>
                    </div>

                </div>

                {{-- ═══ Card footer ═══ --}}
                <div class="px-6 py-3.5 border-t border-black/[0.06] bg-neutral-50/40
                            flex items-center justify-between gap-3">
                    <span class="font-mono text-[9px] tracking-[0.2em] uppercase text-ink-400">
                        SMK Negeri 5 Surakarta
                    </span>
                    <span class="font-mono text-[9px] tracking-[0.2em] uppercase text-ink-400">
                        Scan v2.0
                    </span>
                </div>

            </div>

        </div>
    </div>

    <script>
        function studentQrScanner() {
            return {
                html5QrCode: null,

                startScanner() {
                    this.html5QrCode = new Html5Qrcode("reader");
                    this.html5QrCode.start(
                        { facingMode: "environment" },
                        { fps: 10, qrbox: { width: 220, height: 220 } },
                        (decodedText) => {
                            this.stopScanner();
                            this.claim(decodedText);
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

                claim(token) {
                    fetch('/student/claim-via-qr', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({ qr_token: token })
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil!',
                                text: data.message,
                                confirmButtonColor: '#0A0A0A'
                            }).then(() => {
                                window.location.href = '{{ route("student.service-requests.index") }}';
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal!',
                                text: data.message,
                                confirmButtonColor: '#0A0A0A'
                            });
                        }
                    })
                    .catch(() => {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: 'Gagal memproses verifikasi.',
                            confirmButtonColor: '#0A0A0A'
                        });
                    });
                }
            }
        }
    </script>
</x-layouts.app>