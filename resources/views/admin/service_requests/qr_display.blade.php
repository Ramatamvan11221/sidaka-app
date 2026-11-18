<x-layouts.app title="QR Penyerahan - Admin SIDAKA">
    <x-slot name="header">QR Code Penyerahan Dokumen</x-slot>

    {{-- Library Canvas Confetti --}}
    <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.6.0/dist/confetti.browser.min.js"></script>

    <style>
        @keyframes scanPulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.4; }
        }
        .scan-pulse { animation: scanPulse 2s ease-in-out infinite; }

        @keyframes subtleFloat {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-3px); }
        }
        .float-subtle { animation: subtleFloat 3s ease-in-out infinite; }

        /* QR SVG: pastikan tidak overflow */
        .qr-wrap svg {
            width: 100% !important;
            height: 100% !important;
            display: block;
        }
    </style>

    <div class="min-h-[calc(100vh-200px)] flex items-center justify-center px-4 sm:px-6 py-6 sm:py-10">
        <div class="w-full max-w-lg mx-auto" x-data="qrStatusChecker()">

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
                        <span class="font-mono text-[10px] tracking-[0.2em] uppercase text-ink-400">Verifikasi Penyerahan</span>
                    </div>
                    <span class="font-mono text-[9px] tracking-widest uppercase text-ink-300">SIDAKA</span>
                </div>

                {{-- ═══ Card body ═══ --}}
                <div class="p-6 sm:p-8">

                    {{-- Nomor pengajuan --}}
                    <div class="text-center mb-6">
                        <p class="font-mono text-[10px] tracking-[0.2em] uppercase text-ink-400">Nomor Pengajuan</p>
                        <h2 class="mt-2 font-mono text-[20px] sm:text-[22px] font-medium text-ink-900 tracking-tight tabular-nums">
                            {{ $serviceRequest->request_number }}
                        </h2>
                    </div>

                    {{-- Info pemohon --}}
                    <div class="rounded-xl border border-black/[0.06] bg-neutral-50/60 px-4 py-3.5 mb-6">
                        <div class="grid grid-cols-2 gap-3 sm:gap-4">
                            <div class="min-w-0">
                                <p class="font-mono text-[9px] tracking-[0.2em] uppercase text-ink-400 mb-1">Pemohon</p>
                                <p class="text-[13px] font-medium text-ink-900 truncate">
                                    {{ $serviceRequest->student->user->name ?? 'Siswa' }}
                                </p>
                            </div>
                            <div class="min-w-0">
                                <p class="font-mono text-[9px] tracking-[0.2em] uppercase text-ink-400 mb-1">Kelas</p>
                                <p class="text-[13px] font-medium text-ink-900 truncate">
                                    {{ $serviceRequest->student->classInfo->name ?? '-' }}
                                </p>
                            </div>
                        </div>
                    </div>

                    {{-- ═══════════════════════════════════════════════════════════
                         STATE 1: WAITING (QR shown)
                         ═══════════════════════════════════════════════════════════ --}}
                    <div x-show="!completed"
                         x-transition:leave="transition ease-in duration-200"
                         x-transition:leave-start="opacity-100 scale-100"
                         x-transition:leave-end="opacity-0 scale-95"
                         class="space-y-5">

                        {{-- QR Code container --}}
                        <div class="flex flex-col items-center">

                            {{-- QR frame dengan scan corners --}}
                            <div class="relative">

                                {{-- Ambient glow saat waiting --}}
                                <div class="absolute -inset-4 rounded-3xl bg-accent/[0.04] blur-2xl scan-pulse pointer-events-none"
                                     aria-hidden="true"></div>

                                {{-- QR box --}}
                                <div class="relative rounded-2xl bg-white border border-black/[0.08] p-4
                                            shadow-[0_2px_8px_rgba(0,0,0,0.04)]">

                                    {{-- Scan corners --}}
                                    <span class="absolute -top-[3px] -left-[3px] w-6 h-6 border-t-2 border-l-2 border-accent rounded-tl-lg"></span>
                                    <span class="absolute -top-[3px] -right-[3px] w-6 h-6 border-t-2 border-r-2 border-accent rounded-tr-lg"></span>
                                    <span class="absolute -bottom-[3px] -left-[3px] w-6 h-6 border-b-2 border-l-2 border-accent rounded-bl-lg"></span>
                                    <span class="absolute -bottom-[3px] -right-[3px] w-6 h-6 border-b-2 border-r-2 border-accent rounded-br-lg"></span>

                                    @if($qrSvg)
                                        <div class="qr-wrap w-[220px] h-[220px] sm:w-[240px] sm:h-[240px] mx-auto flex items-center justify-center">
                                            {!! $qrSvg !!}
                                        </div>
                                    @else
                                        <div class="w-[220px] h-[220px] sm:w-[240px] sm:h-[240px] flex flex-col items-center justify-center gap-2 text-center">
                                            <div class="w-10 h-10 rounded-xl bg-rose-500/[0.08] border border-rose-500/15 flex items-center justify-center">
                                                <svg class="w-5 h-5 text-rose-500" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.75">
                                                    <circle cx="10" cy="10" r="7.5"/>
                                                    <path d="M10 6.5v4.5M10 13.5h.01" stroke-linecap="round"/>
                                                </svg>
                                            </div>
                                            <p class="text-[12px] font-medium text-rose-500">Gagal merender QR Code</p>
                                            <p class="font-mono text-[10px] tracking-wider uppercase text-rose-400">Hubungi administrator</p>
                                        </div>
                                    @endif
                                </div>

                                {{-- Corner markers ala Nothing (label teknis) --}}
                                <span class="absolute -top-3 left-2 px-1.5 bg-white font-mono text-[8px] tracking-[0.2em] uppercase text-ink-400">
                                    QR · Handover
                                </span>
                                <span class="absolute -bottom-3 right-2 px-1.5 bg-white font-mono text-[8px] tracking-[0.2em] uppercase text-ink-400">
                                    v2.0
                                </span>
                            </div>
                        </div>

                        {{-- Instruction --}}
                        <div class="text-center">
                            <div class="inline-flex items-center gap-2 h-8 px-3.5 rounded-full
                                        bg-amber-500/[0.08] border border-amber-500/20">
                                <span class="relative flex w-1.5 h-1.5">
                                    <span class="absolute inline-flex w-full h-full rounded-full bg-amber-500 opacity-60 animate-ping"></span>
                                    <span class="relative inline-flex w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                                </span>
                                <span class="text-[11px] font-medium text-amber-700">
                                    Menunggu siswa memindai QR
                                </span>
                            </div>

                            <p class="mt-4 text-[12.5px] text-ink-500 leading-relaxed max-w-xs mx-auto">
                                Minta siswa membuka menu <span class="font-medium text-ink-700">Scan QR Admin</span> di aplikasi mereka, lalu arahkan kamera ke QR Code di atas.
                            </p>
                        </div>

                        {{-- Auto-refresh indicator --}}
                        <div class="pt-4 border-t border-black/[0.06]">
                            <div class="flex items-center justify-center gap-2">
                                <svg class="w-3 h-3 text-ink-400 animate-spin" viewBox="0 0 12 12" fill="none" stroke="currentColor" stroke-width="1.5" style="animation-duration: 2s;">
                                    <path d="M6 1.5a4.5 4.5 0 014.5 4.5" stroke-linecap="round"/>
                                    <path d="M6 10.5A4.5 4.5 0 011.5 6" stroke-linecap="round"/>
                                </svg>
                                <span class="font-mono text-[9px] tracking-[0.2em] uppercase text-ink-400">
                                    Auto-refresh tiap 2 detik
                                </span>
                            </div>
                        </div>
                    </div>

                    {{-- ═══════════════════════════════════════════════════════════
                         STATE 2: COMPLETED (success)
                         ═══════════════════════════════════════════════════════════ --}}
                    <div x-show="completed" x-cloak
                         x-transition:enter="transition ease-out duration-500"
                         x-transition:enter-start="opacity-0 scale-95"
                         x-transition:enter-end="opacity-100 scale-100"
                         class="space-y-5">

                        {{-- Success card --}}
                        <div class="rounded-2xl border border-emerald-500/20 bg-emerald-500/[0.04] p-6 sm:p-7 text-center">

                            {{-- Success icon --}}
                            <div class="relative inline-flex items-center justify-center">
                                {{-- Glow ring --}}
                                <div class="absolute inset-0 rounded-full bg-emerald-500/20 blur-xl" aria-hidden="true"></div>

                                <div class="relative w-16 h-16 sm:w-18 sm:h-18 rounded-full bg-emerald-500
                                            flex items-center justify-center
                                            shadow-[0_8px_24px_rgba(15,181,122,0.4)]">
                                    <svg class="w-8 h-8 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                        <path d="M6 12.5l4 4L18 8" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </div>
                            </div>

                            {{-- Text --}}
                            <h3 class="mt-5 text-[18px] sm:text-[20px] font-semibold text-ink-900 tracking-tight">
                                Transaksi Berhasil
                            </h3>
                            <p class="mt-2 text-[12.5px] text-ink-500 leading-relaxed max-w-xs mx-auto">
                                Dokumen telah dikonfirmasi dan diserahkan ke siswa. Status pengajuan otomatis ter-update.
                            </p>

                            {{-- Mono detail --}}
                            <div class="mt-5 pt-5 border-t border-emerald-500/15">
                                <div class="grid grid-cols-2 gap-px bg-emerald-500/10 rounded-lg overflow-hidden">
                                    <div class="bg-white/70 px-3 py-2.5">
                                        <p class="font-mono text-[9px] tracking-[0.15em] uppercase text-ink-400">Status</p>
                                        <p class="mt-0.5 font-mono text-[11px] font-semibold text-emerald-700 tracking-wider">COMPLETED</p>
                                    </div>
                                    <div class="bg-white/70 px-3 py-2.5">
                                        <p class="font-mono text-[9px] tracking-[0.15em] uppercase text-ink-400">Waktu</p>
                                        <p class="mt-0.5 font-mono text-[11px] font-semibold text-ink-700 tabular-nums">
                                            {{ now()->format('H:i:s') }}
                                        </p>
                                    </div>
                                </div>
                            </div>

                        </div>

                        {{-- Action button --}}
                        <a href="{{ route('admin.service-requests.show', $serviceRequest) }}"
                           class="w-full inline-flex items-center justify-center gap-2 h-12 rounded-xl
                                  bg-ink-900 hover:bg-ink-700 text-white text-[12px] font-medium
                                  transition-all duration-200 active:scale-[0.98]">
                            <span>Kembali ke Detail Pengajuan</span>
                            <svg class="w-3.5 h-3.5 opacity-70" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.75">
                                <path d="M3 8h10M9 4l4 4-4 4" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </a>
                    </div>

                </div>

                {{-- ═══ Card footer ═══ --}}
                <div class="px-6 py-3.5 border-t border-black/[0.06] bg-neutral-50/40
                            flex items-center justify-between gap-3">
                    <span class="font-mono text-[9px] tracking-[0.2em] uppercase text-ink-400">
                        SMK Negeri 5 Surakarta
                    </span>
                    <span class="font-mono text-[9px] tracking-[0.2em] uppercase text-ink-400 tabular-nums">
                        {{ date('d/m/Y') }}
                    </span>
                </div>

            </div>

        </div>
    </div>

    <script>
        function qrStatusChecker() {
            return {
                completed: false,

                playSuccessSound() {
                    let ctx = new (window.AudioContext || window.webkitAudioContext)();
                    let osc = ctx.createOscillator();
                    let gain = ctx.createGain();
                    osc.type = 'sine';
                    osc.frequency.setValueAtTime(880, ctx.currentTime); // Pitch tinggi (Beep)
                    gain.gain.setValueAtTime(0.1, ctx.currentTime);
                    osc.connect(gain);
                    gain.connect(ctx.destination);
                    osc.start();
                    osc.stop(ctx.currentTime + 0.2);
                },

                triggerConfetti() {
                    confetti({
                        particleCount: 100,
                        spread: 70,
                        origin: { y: 0.6 }
                    });
                },

                init() {
                    let interval = setInterval(() => {
                        fetch('{{ route("admin.service-requests.check-status", $serviceRequest) }}')
                            .then(res => res.json())
                            .then(data => {
                                if (data.is_completed) {
                                    this.completed = true;
                                    this.playSuccessSound();
                                    this.triggerConfetti();
                                    clearInterval(interval);
                                }
                            })
                            .catch(() => {});
                    }, 2000);
                }
            }
        }
    </script>
</x-layouts.app>