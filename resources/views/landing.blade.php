<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="SIDAKA — Sistem Layanan Dokumen Akademik SMK Negeri 5 Surakarta. Ajukan, lacak, dan ambil dokumen akademik tanpa antre.">
    <title>SIDAKA — Sistem Layanan Dokumen Akademik SMKN 5 Surakarta</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
      tailwind.config = {
        theme: {
          extend: {
            fontFamily: {
              sans: ['Inter', 'ui-sans-serif', 'system-ui', 'sans-serif'],
              mono: ['"JetBrains Mono"', 'ui-monospace', 'SFMono-Regular', 'monospace'],
            },
            colors: {
              canvas: { DEFAULT: '#FAFAFA', soft: '#F5F5F7' },
              ink: {
                900: '#0A0A0A', 700: '#1F1F1F', 500: '#6B6B6B',
                400: '#8E8E93', 300: '#B8B8BD', 200: '#E5E5E7',
              },
              line: { DEFAULT: 'rgba(0,0,0,0.08)', soft: 'rgba(0,0,0,0.05)', strong: 'rgba(0,0,0,0.14)' },
              accent: { DEFAULT: '#0A84FF', ink: '#0055CC', soft: '#EAF3FF' },
              success: '#0FB57A', warning: '#F5A524', danger: '#E5484D',
            },
            borderRadius: { '2xl': '16px', '3xl': '20px' },
            boxShadow: {
              'soft': '0 1px 2px rgba(0,0,0,0.03), 0 8px 24px rgba(0,0,0,0.05)',
              'lift': '0 2px 4px rgba(0,0,0,0.04), 0 16px 40px rgba(0,0,0,0.08)',
            },
          }
        }
      }
    </script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        :root {
            --canvas: #FAFAFA;
            --grid-line: rgba(0, 0, 0, 0.035);
            --line: rgba(0, 0, 0, 0.08);
            --glass-bg: rgba(255, 255, 255, 0.72);
            --glass-border: rgba(255, 255, 255, 0.85);
        }

        html { -webkit-font-smoothing: antialiased; -moz-osx-font-smoothing: grayscale; font-feature-settings: 'cv11', 'ss01'; }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--canvas);
            color: #1F1F1F;
            background-image:
                linear-gradient(var(--grid-line) 1px, transparent 1px),
                linear-gradient(90deg, var(--grid-line) 1px, transparent 1px);
            background-size: 32px 32px;
            background-attachment: fixed;
        }

        ::selection { background: rgba(10, 132, 255, 0.18); color: #0A0A0A; }

        ::-webkit-scrollbar { width: 10px; height: 10px; }
        ::-webkit-scrollbar-thumb {
            background: rgba(0,0,0,0.15); border-radius: 999px;
            border: 2px solid transparent; background-clip: content-box;
        }
        ::-webkit-scrollbar-thumb:hover { background: rgba(0,0,0,0.25); background-clip: content-box; }

        .glass {
            background: var(--glass-bg);
            backdrop-filter: blur(20px) saturate(180%);
            -webkit-backdrop-filter: blur(20px) saturate(180%);
            border: 1px solid var(--glass-border);
            box-shadow:
                0 1px 0 rgba(255,255,255,0.9) inset,
                0 1px 2px rgba(0,0,0,0.03),
                0 8px 24px rgba(0,0,0,0.05);
        }

        .focus-ring:focus-visible {
            outline: none;
            box-shadow: 0 0 0 4px rgba(10,132,255,0.15);
            border-color: rgba(10,132,255,0.5);
        }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(12px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-up { animation: fadeUp 0.7s cubic-bezier(0.16,1,0.3,1) both; }
        .delay-1 { animation-delay: 0.05s; }
        .delay-2 { animation-delay: 0.12s; }
        .delay-3 { animation-delay: 0.20s; }
        .delay-4 { animation-delay: 0.30s; }
        .delay-5 { animation-delay: 0.40s; }

        @media (prefers-reduced-motion: reduce) {
            *, *::before, *::after {
                animation-duration: 0.01ms !important;
                transition-duration: 0.01ms !important;
            }
        }

        .press { transition: transform 200ms cubic-bezier(0.16,1,0.3,1), background-color 200ms, border-color 200ms, box-shadow 200ms; }
        .press:active { transform: scale(0.98); }

        /* === IMAGE FRAME — wrapper standar untuk semua gambar === */
        .img-frame {
            position: relative;
            overflow: hidden;
            background: linear-gradient(135deg, #F5F5F7 0%, #FAFAFA 100%);
            border: 1px solid rgba(0,0,0,0.06);
        }
        .img-frame img {
            display: block;
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        /* Fallback kalau gambar belum ada / gagal load */
        .img-frame.is-missing::after {
            content: attr(data-fallback);
            position: absolute;
            inset: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding: 1rem;
            font-family: 'JetBrains Mono', monospace;
            font-size: 10px;
            letter-spacing: 0.15em;
            text-transform: uppercase;
            color: #8E8E93;
            background-image:
                linear-gradient(rgba(0,0,0,0.03) 1px, transparent 1px),
                linear-gradient(90deg, rgba(0,0,0,0.03) 1px, transparent 1px);
            background-size: 16px 16px;
        }
    </style>
</head>

<body class="min-h-screen antialiased text-ink-700 overflow-x-hidden">

    {{-- ═══════════════════════════════════════════════════════════
         NAVBAR
         ═══════════════════════════════════════════════════════════ --}}
    <header class="sticky top-0 z-50 px-4 sm:px-6 pt-4">
        <nav class="max-w-6xl mx-auto glass rounded-2xl h-14 pl-4 pr-2 flex items-center justify-between">

            <a href="{{ route('landing') }}" class="flex items-center gap-3 group">
                {{-- LOGO SEKOLAH (opsional). Taruh file di: public/images/landing/logo.png --}}
                <div class="relative w-9 h-9 rounded-[10px] bg-ink-900 flex items-center justify-center overflow-hidden shrink-0">
                    <img src="{{ asset('images/landing/logo.png') }}"
                         alt="Logo SMKN 5 Surakarta"
                         class="absolute inset-0 w-full h-full object-contain p-1.5"
                         onerror="this.style.display='none'">
                </div>
                <div class="leading-none">
                    <div class="flex items-center gap-2">
                        <span class="font-semibold text-[13px] text-ink-900 tracking-tight">SIDAKA</span>
                        <span class="hidden sm:inline font-mono text-[9px] text-ink-400 tracking-widest uppercase">v2.0</span>
                    </div>
                    <span class="hidden sm:block text-[10px] text-ink-400 mt-0.5">SMK Negeri 5 Surakarta</span>
                </div>
            </a>

            <div class="flex items-center gap-2">
                @auth
                    @php
                        $userRole = is_object(auth()->user()->role) ? auth()->user()->role->value : auth()->user()->role;
                    @endphp
                    <a href="{{ route($userRole . '.dashboard') }}"
                       class="press inline-flex items-center gap-2 h-10 pl-4 pr-3.5 rounded-xl bg-ink-900 hover:bg-ink-700 text-white text-[12px] font-medium">
                        <span>Dashboard</span>
                        <svg class="w-3.5 h-3.5 opacity-70" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.75">
                            <path d="M3 8h10M9 4l4 4-4 4" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </a>
                @else
                    <a href="{{ route('login') }}"
                       class="press hidden sm:inline-flex items-center h-10 px-4 rounded-xl text-[12px] font-medium text-ink-700 hover:bg-ink-900/5">
                        
                    </a>
                    <a href="{{ route('login') }}"
                       class="press inline-flex items-center gap-2 h-10 pl-4 pr-3.5 rounded-xl bg-ink-900 hover:bg-ink-700 text-white text-[12px] font-medium">
                        <span>Masuk Sistem</span>
                        <svg class="w-3.5 h-3.5 opacity-70" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.75">
                            <path d="M3 8h10M9 4l4 4-4 4" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </a>
                @endauth
            </div>
        </nav>
    </header>

    {{-- ═══════════════════════════════════════════════════════════
         HERO — SPLIT (kiri: teks, kanan: GAMBAR)
         ═══════════════════════════════════════════════════════════ --}}
    <section class="relative z-10 px-6 pt-16 pb-20 sm:pt-24 sm:pb-28">

        <div class="hidden md:block absolute top-12 left-10 font-mono text-[10px] tracking-[0.2em] text-ink-300 uppercase">SIDAKA · 01</div>
        <div class="hidden md:block absolute top-12 right-10 font-mono text-[10px] tracking-[0.2em] text-ink-300 uppercase">2024 — 2025</div>

        <div class="max-w-7xl mx-auto grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-16 items-center">

            {{-- ── KIRI: Text ── --}}
            <div class="lg:col-span-6 text-center lg:text-left">

                <div class="animate-fade-up inline-flex items-center gap-2.5 h-8 px-3.5 rounded-full border border-line bg-white/70 backdrop-blur">
                    <span class="relative flex w-1.5 h-1.5">
                        <span class="absolute inline-flex w-full h-full rounded-full bg-accent opacity-60 animate-ping"></span>
                        <span class="relative inline-flex w-1.5 h-1.5 rounded-full bg-accent"></span>
                    </span>
                    <span class="text-[11px] font-medium tracking-wide text-ink-700">
                        Sistem aktif · Layanan terintegrasi
                    </span>
                </div>

                <h1 class="animate-fade-up delay-1 mt-7 text-[40px] sm:text-[56px] leading-[1.03] tracking-[-0.03em] font-semibold text-ink-900 text-balance">
                    Dokumen akademik,<br class="hidden sm:block">
                    <span class="relative inline-block">
                        tanpa antre.
                        <span class="absolute left-0 -bottom-1 sm:-bottom-2 h-[3px] w-full bg-accent/20 rounded-full"></span>
                    </span>
                </h1>

                <p class="animate-fade-up delay-2 mt-6 text-[14px] sm:text-[15px] leading-relaxed text-ink-500 max-w-lg mx-auto lg:mx-0 text-pretty">
                    Kelola pengambilan ijazah, sertifikat, legalisir, dan peminjaman rapor dalam satu sistem digital terpadu SMKN 5 Surakarta — dilengkapi verifikasi QR Code instan.
                </p>

                <div class="animate-fade-up delay-3 mt-8 max-w-xl mx-auto lg:mx-0">
                    <div class="glass rounded-2xl p-2">
                        <form action="{{ route('landing') }}" method="GET" class="flex flex-col sm:flex-row gap-2">
                            <div class="relative flex-1">
                                <span class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-ink-400">
                                    <svg class="w-4 h-4" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.75">
                                        <circle cx="9" cy="9" r="6"/>
                                        <path d="M14 14l4 4" stroke-linecap="round"/>
                                    </svg>
                                </span>
                                <input type="text" name="request_number"
                                       value="{{ request('request_number') }}" required
                                       placeholder="REQ-20260902-0001"
                                       aria-label="Nomor pengajuan"
                                       class="focus-ring w-full h-12 pl-11 pr-4 rounded-xl bg-white/60 border border-line text-[13px] font-mono text-ink-900 placeholder:text-ink-300 placeholder:font-mono transition outline-none">
                            </div>
                            <button type="submit"
                                    class="press inline-flex items-center justify-center gap-2 h-12 px-6 rounded-xl bg-ink-900 hover:bg-ink-700 text-white text-[12px] font-medium">
                                <span>Lacak</span>
                                <svg class="w-3.5 h-3.5 opacity-70" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.75">
                                    <path d="M3 8h10M9 4l4 4-4 4" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </button>
                        </form>
                    </div>
                    <p class="mt-3 font-mono text-[10px] text-ink-400 tracking-wider uppercase">
                        Masukkan nomor pengajuan yang kamu terima
                    </p>
                </div>

            </div>

            {{-- ── KANAN: GAMBAR HERO ──
                 📁 Simpan gambar di: public/images/landing/hero.png
                 📐 Rekomendasi: 1080×1080 (square) atau 1200×1000, PNG transparan
                 💡 Isi yang disarankan: screenshot dashboard SIDAKA, atau foto siswa
                    pegang dokumen, atau mockup HP + laptop sekaligus.
            --}}
            <div class="lg:col-span-6 animate-fade-up delay-2">
                <div class="relative max-w-[560px] mx-auto">

                    {{-- Frame utama --}}
                    <div class="img-frame rounded-3xl shadow-[0_20px_60px_rgba(0,0,0,0.08)] aspect-square"
                         data-fallback="Hero Image · 1080×1080 · public/images/landing/hero.png">
                        <img src="{{ asset('images/landing/hero.png') }}"
                             alt="Antarmuka sistem SIDAKA"
                             loading="eager"
                             decoding="async"
                             onerror="this.parentElement.classList.add('is-missing'); this.style.display='none';">
                    </div>

                    {{-- Caption ala Nothing --}}
                    <div class="mt-6 flex items-center justify-between px-2">
                        <span class="font-mono text-[10px] tracking-[0.2em] uppercase text-ink-300">Fig. 01 — Antarmuka SIDAKA</span>
                        <span class="font-mono text-[10px] tracking-[0.2em] uppercase text-ink-300">Interface</span>
                    </div>
                </div>
            </div>

        </div>

        {{-- Stats strip --}}
        <div class="animate-fade-up delay-5 mt-20 max-w-4xl mx-auto">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-px bg-line border-y border-line">
                <div class="bg-canvas px-4 py-6 text-center">
                    <p class="text-[22px] font-semibold text-ink-900 tracking-tight tabular-nums">100%</p>
                    <p class="mt-1.5 font-mono text-[10px] tracking-wider uppercase text-ink-400">Audit Digital</p>
                </div>
                <div class="bg-canvas px-4 py-6 text-center">
                    <p class="text-[22px] font-semibold text-ink-900 tracking-tight tabular-nums">&lt;3 min</p>
                    <p class="mt-1.5 font-mono text-[10px] tracking-wider uppercase text-ink-400">Serah Terima</p>
                </div>
                <div class="bg-canvas px-4 py-6 text-center">
                    <p class="text-[22px] font-semibold text-ink-900 tracking-tight tabular-nums">QR</p>
                    <p class="mt-1.5 font-mono text-[10px] tracking-wider uppercase text-ink-400">Verifikasi</p>
                </div>
                <div class="bg-canvas px-4 py-6 text-center">
                    <p class="text-[22px] font-semibold text-ink-900 tracking-tight tabular-nums">Zero</p>
                    <p class="mt-1.5 font-mono text-[10px] tracking-wider uppercase text-ink-400">Risiko Hilang</p>
                </div>
            </div>
        </div>

    </section>

    {{-- ═══════════════════════════════════════════════════════════
         TRACKING RESULT (conditional)
         ═══════════════════════════════════════════════════════════ --}}
    @if(request()->has('request_number'))
        <section id="tracking-result" class="relative z-10 px-6 pb-24 -mt-8">
            <div class="animate-fade-up max-w-3xl mx-auto glass rounded-3xl p-6 sm:p-8">

                <div class="flex flex-wrap items-start justify-between gap-4 pb-5 border-b border-line">
                    <div class="min-w-0">
                        <p class="font-mono text-[10px] tracking-[0.2em] uppercase text-ink-400">Hasil Pelacakan</p>
                        <p class="mt-2 font-mono text-[15px] sm:text-[17px] font-medium text-ink-900 truncate">
                            {{ request('request_number') }}
                        </p>
                    </div>
                    @if($searchResult)
                        <x-status-badge :status="$searchResult->status" />
                    @endif
                </div>

                @if($searchResult)
                    <div class="mt-5 grid grid-cols-1 sm:grid-cols-2 gap-px bg-line border border-line rounded-2xl overflow-hidden">
                        <div class="bg-white/70 px-5 py-4">
                            <p class="font-mono text-[10px] tracking-wider uppercase text-ink-400">Pemohon</p>
                            <p class="mt-1.5 text-[14px] font-medium text-ink-900">{{ $searchResult->student->user->name ?? '-' }}</p>
                        </div>
                        <div class="bg-white/70 px-5 py-4">
                            <p class="font-mono text-[10px] tracking-wider uppercase text-ink-400">Jenis Layanan</p>
                            <p class="mt-1.5 text-[14px] font-medium text-ink-900">{{ $searchResult->serviceType->name ?? '-' }}</p>
                        </div>
                    </div>

                    <div class="mt-7">
                        <div class="flex items-center justify-between mb-4">
                            <p class="font-mono text-[10px] tracking-[0.2em] uppercase text-ink-400">Riwayat Pemrosesan</p>
                            <span class="font-mono text-[10px] text-ink-300 tabular-nums">{{ $searchResult->statusHistories->count() }} entri</span>
                        </div>

                        <ol class="relative space-y-5 pl-5">
                            <span class="absolute left-[4px] top-2 bottom-2 w-px bg-line" aria-hidden="true"></span>

                            @foreach($searchResult->statusHistories as $history)
                                <li class="relative">
                                    <span class="absolute -left-5 top-[7px] w-[9px] h-[9px] rounded-full bg-white border-[1.5px] border-ink-900"></span>
                                    <div class="flex flex-wrap items-baseline gap-x-3 gap-y-1">
                                        <span class="text-[13px] font-medium text-ink-900">
                                            {{ is_object($history->status) && method_exists($history->status, 'label') ? $history->status->label() : strtoupper($history->status->value ?? $history->status) }}
                                        </span>
                                        <span class="font-mono text-[10px] text-ink-400 tabular-nums">{{ $history->created_at->format('d/m/Y H:i') }} WIB</span>
                                    </div>
                                    @if($history->notes)
                                        <p class="mt-1 text-[12px] text-ink-500 leading-relaxed">{{ $history->notes }}</p>
                                    @endif
                                </li>
                            @endforeach
                        </ol>
                    </div>
                @else
                    <div class="py-12 text-center">
                        <div class="w-12 h-12 mx-auto rounded-2xl bg-danger/5 border border-danger/15 flex items-center justify-center">
                            <svg class="w-5 h-5 text-danger" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.75">
                                <circle cx="10" cy="10" r="7.5"/>
                                <path d="M10 6.5v4.5M10 13.5h.01" stroke-linecap="round"/>
                            </svg>
                        </div>
                        <p class="mt-4 text-[13px] text-ink-500">
                            Nomor pengajuan
                            <span class="font-mono font-medium text-ink-900">{{ request('request_number') }}</span>
                            tidak ditemukan.
                        </p>
                        <p class="mt-1 text-[12px] text-ink-400">Periksa kembali format dan pastikan sudah benar.</p>
                    </div>
                @endif
            </div>
        </section>
    @endif

    {{-- ═══════════════════════════════════════════════════════════
         FEATURES
         ═══════════════════════════════════════════════════════════ --}}
    <section class="relative z-10 px-6 py-20 sm:py-28">
        <div class="max-w-6xl mx-auto">

            <div class="flex items-end justify-between gap-6 mb-12">
                <div>
                    <p class="font-mono text-[10px] tracking-[0.2em] uppercase text-ink-400 mb-3">01 — Keunggulan</p>
                    <h2 class="text-[28px] sm:text-[36px] leading-[1.1] tracking-[-0.02em] font-semibold text-ink-900 max-w-md text-balance">
                        Dirancang untuk menghapus antrean.
                    </h2>
                </div>
                <p class="hidden md:block max-w-xs text-[13px] text-ink-500 leading-relaxed">
                    Modernisasi alur kearsipan akademik SMKN 5 Surakarta dari berbasis kertas menjadi digital-first.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-px bg-line border-y border-line">

                {{-- Card 1 --}}
                {{-- 📁 Gambar opsional: public/images/landing/feature-1.png (rasio 3:2, misal 1200×800) --}}
                <div class="bg-canvas group hover:bg-white transition-colors duration-500">
                    <div class="img-frame aspect-[3/2] border-0 border-b border-line rounded-none"
                         data-fallback="Feature 01 · 1200×800">
                        <img src="{{ asset('images/landing/feature-1.png') }}"
                             alt="Ilustrasi layanan satu pintu"
                             loading="lazy"
                             decoding="async"
                             onerror="this.parentElement.classList.add('is-missing'); this.style.display='none';">
                    </div>
                    <div class="p-8 sm:p-10">
                        <div class="flex items-center justify-between mb-6">
                            <span class="font-mono text-[10px] text-ink-300 tracking-widest">01</span>
                            <div class="w-8 h-px bg-ink-900/20 group-hover:bg-accent group-hover:w-12 transition-all duration-500"></div>
                        </div>
                        <h3 class="text-[15px] font-semibold text-ink-900 tracking-tight">Satu Pintu Layanan</h3>
                        <p class="mt-2.5 text-[13px] text-ink-500 leading-relaxed">
                            Ijazah, sertifikat UKK, legalisir, hingga peminjaman rapor — diajukan terpadu tanpa formulir kertas fisik.
                        </p>
                    </div>
                </div>

                {{-- Card 2 --}}
                <div class="bg-canvas group hover:bg-white transition-colors duration-500">
                    <div class="img-frame aspect-[3/2] border-0 border-b border-line rounded-none"
                         data-fallback="Feature 02 · 1200×800">
                        <img src="{{ asset('images/landing/feature-2.png') }}"
                             alt="Ilustrasi scan QR"
                             loading="lazy"
                             decoding="async"
                             onerror="this.parentElement.classList.add('is-missing'); this.style.display='none';">
                    </div>
                    <div class="p-8 sm:p-10">
                        <div class="flex items-center justify-between mb-6">
                            <span class="font-mono text-[10px] text-ink-300 tracking-widest">02</span>
                            <div class="w-8 h-px bg-ink-900/20 group-hover:bg-accent group-hover:w-12 transition-all duration-500"></div>
                        </div>
                        <h3 class="text-[15px] font-semibold text-ink-900 tracking-tight">Scan QR Instan</h3>
                        <p class="mt-2.5 text-[13px] text-ink-500 leading-relaxed">
                            Verifikasi serah terima dokumen fisik cukup dengan memindai QR Code di monitor petugas TU.
                        </p>
                    </div>
                </div>

                {{-- Card 3 --}}
                <div class="bg-canvas group hover:bg-white transition-colors duration-500">
                    <div class="img-frame aspect-[3/2] border-0 border-b border-line rounded-none"
                         data-fallback="Feature 03 · 1200×800">
                        <img src="{{ asset('images/landing/feature-3.png') }}"
                             alt="Ilustrasi bukti serah terima digital"
                             loading="lazy"
                             decoding="async"
                             onerror="this.parentElement.classList.add('is-missing'); this.style.display='none';">
                    </div>
                    <div class="p-8 sm:p-10">
                        <div class="flex items-center justify-between mb-6">
                            <span class="font-mono text-[10px] text-ink-300 tracking-widest">03</span>
                            <div class="w-8 h-px bg-ink-900/20 group-hover:bg-accent group-hover:w-12 transition-all duration-500"></div>
                        </div>
                        <h3 class="text-[15px] font-semibold text-ink-900 tracking-tight">Bukti & Audit Digital</h3>
                        <p class="mt-2.5 text-[13px] text-ink-500 leading-relaxed">
                            Setiap transaksi menerbitkan Surat Bukti Serah Terima PDF ber-KOP resmi dan stempel digital.
                        </p>
                    </div>
                </div>

            </div>
        </div>
    </section>

    {{-- ═══════════════════════════════════════════════════════════
         SECTION "SISTEM DALAM AKSI" — SPLIT (kiri: gambar, kanan: teks)
         ═══════════════════════════════════════════════════════════ --}}
    <section class="relative z-10 px-6 py-20 sm:py-28 bg-canvas-soft/50">
        <div class="max-w-7xl mx-auto grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-16 items-center">

            {{-- KIRI: GAMBAR BESAR --
                 📁 Simpan di: public/images/landing/about.png
                 📐 Rekomendasi: 1000×1200 (portrait) atau 1200×1200
                 💡 Isi yang disarankan: foto gedung SMKN 5 Surakarta, atau
                    foto petugas TU sedang melayani siswa, atau foto arsip dokumen.
            --}}
            <div class="lg:col-span-5 order-2 lg:order-1">
                <div class="relative max-w-[520px] mx-auto">

                    <div class="img-frame rounded-3xl shadow-[0_20px_60px_rgba(0,0,0,0.06)] aspect-[4/5]"
                         data-fallback="About Image · 1000×1200 · public/images/landing/about.png">
                        <img src="{{ asset('images/landing/about.png') }}"
                             alt="SMK Negeri 5 Surakarta"
                             loading="lazy"
                             decoding="async"
                             onerror="this.parentElement.classList.add('is-missing'); this.style.display='none';">
                    </div>

                    {{-- Caption ala Nothing --}}
                    <div class="mt-6 flex items-center justify-between px-2">
                        <span class="font-mono text-[10px] tracking-[0.2em] uppercase text-ink-300">Fig. 02 — SMKN 5 Surakarta</span>
                        <span class="font-mono text-[10px] tracking-[0.2em] uppercase text-ink-300">Location</span>
                    </div>

                    {{-- Badge "Est. 1997" atau tahun berdirinya sekolah (sesuaikan) --}}
                    <div class="hidden sm:flex absolute -bottom-4 -right-4 items-center gap-2 h-11 px-4 rounded-2xl glass">
                        <span class="w-1.5 h-1.5 rounded-full bg-accent"></span>
                        <span class="font-mono text-[10px] tracking-widest uppercase text-ink-700">Est. 1965</span>
                    </div>

                </div>
            </div>

            {{-- KANAN: Teks --}}
            <div class="lg:col-span-7 order-1 lg:order-2">
                <p class="font-mono text-[10px] tracking-[0.2em] uppercase text-ink-400 mb-3">02 — Sistem dalam Aksi</p>
                <h2 class="text-[28px] sm:text-[40px] leading-[1.08] tracking-[-0.02em] font-semibold text-ink-900 text-balance">
                    Satu sistem untuk seluruh siklus dokumen akademik.
                </h2>
                <p class="mt-5 text-[14px] text-ink-500 leading-relaxed max-w-xl">
                    Dari pengajuan siswa, verifikasi petugas TU, penyiapan berkas fisik, hingga serah terima dengan QR Code — semuanya tercatat dan dapat dilacak secara real-time.
                </p>

                <ul class="mt-8 space-y-4">
                    <li class="flex items-start gap-3">
                        <span class="mt-1 shrink-0 w-4 h-4 rounded-full border border-ink-900 flex items-center justify-center">
                            <svg class="w-2.5 h-2.5 text-ink-900" viewBox="0 0 12 12" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M2 6 L5 9 L10 3" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </span>
                        <div>
                            <p class="text-[13px] font-medium text-ink-900">Pelacakan real-time</p>
                            <p class="text-[12px] text-ink-500 mt-0.5">Pantau status dokumen kapan saja hanya dengan nomor pengajuan.</p>
                        </div>
                    </li>
                    <li class="flex items-start gap-3">
                        <span class="mt-1 shrink-0 w-4 h-4 rounded-full border border-ink-900 flex items-center justify-center">
                            <svg class="w-2.5 h-2.5 text-ink-900" viewBox="0 0 12 12" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M2 6 L5 9 L10 3" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </span>
                        <div>
                            <p class="text-[13px] font-medium text-ink-900">Notifikasi otomatis</p>
                            <p class="text-[12px] text-ink-500 mt-0.5">Siswa diberi tahu ketika dokumen siap diambil.</p>
                        </div>
                    </li>
                    <li class="flex items-start gap-3">
                        <span class="mt-1 shrink-0 w-4 h-4 rounded-full border border-ink-900 flex items-center justify-center">
                            <svg class="w-2.5 h-2.5 text-ink-900" viewBox="0 0 12 12" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M2 6 L5 9 L10 3" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </span>
                        <div>
                            <p class="text-[13px] font-medium text-ink-900">Audit trail lengkap</p>
                            <p class="text-[12px] text-ink-500 mt-0.5">Semua perubahan status tercatat permanen untuk transparansi.</p>
                        </div>
                    </li>
                </ul>
            </div>

        </div>
    </section>

    {{-- ═══════════════════════════════════════════════════════════
         GALERI — 3 gambar side by side (opsional, hapus kalau nggak perlu)
         ═══════════════════════════════════════════════════════════ --}}
    <section class="relative z-10 px-6 py-20 sm:py-28">
        <div class="max-w-6xl mx-auto">

            <div class="flex items-end justify-between gap-6 mb-12">
                <div>
                    <p class="font-mono text-[10px] tracking-[0.2em] uppercase text-ink-400 mb-3">03 — Galeri</p>
                    <h2 class="text-[28px] sm:text-[36px] leading-[1.1] tracking-[-0.02em] font-semibold text-ink-900 max-w-md text-balance">
                        Momen di balik layanan.
                    </h2>
                </div>
                <p class="hidden md:block max-w-xs text-[13px] text-ink-500 leading-relaxed">
                    Beberapa dokumentasi kegiatan layanan dokumen akademik di SMKN 5 Surakarta.
                </p>
            </div>

            {{-- 📁 Gambar: public/images/landing/gallery-1.png, gallery-2.png, gallery-3.png
                 📐 Rekomendasi: 1000×1250 (portrait 4:5) supaya seragam --}}
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 sm:gap-5">

                <figure class="group">
                    <div class="img-frame rounded-2xl aspect-[4/5]"
                         data-fallback="Gallery 01 · 1000×1250">
                        <img src="{{ asset('images/landing/gallery-1.png') }}"
                             alt="Dokumentasi layanan akademik 1"
                             loading="lazy"
                             decoding="async"
                             class="transition-transform duration-700 group-hover:scale-[1.03]"
                             onerror="this.parentElement.classList.add('is-missing'); this.style.display='none';">
                    </div>
                    <figcaption class="mt-3 flex items-center justify-between">
                        <span class="font-mono text-[10px] tracking-widest uppercase text-ink-400">01 / Layanan</span>
                        <span class="font-mono text-[10px] tracking-widest uppercase text-ink-300">2025</span>
                    </figcaption>
                </figure>

                <figure class="group">
                    <div class="img-frame rounded-2xl aspect-[4/5]"
                         data-fallback="Gallery 02 · 1000×1250">
                        <img src="{{ asset('images/landing/gallery-2.png') }}"
                             alt="Dokumentasi layanan akademik 2"
                             loading="lazy"
                             decoding="async"
                             class="transition-transform duration-700 group-hover:scale-[1.03]"
                             onerror="this.parentElement.classList.add('is-missing'); this.style.display='none';">
                    </div>
                    <figcaption class="mt-3 flex items-center justify-between">
                        <span class="font-mono text-[10px] tracking-widest uppercase text-ink-400">02 / Petugas TU</span>
                        <span class="font-mono text-[10px] tracking-widest uppercase text-ink-300">2025</span>
                    </figcaption>
                </figure>

                <figure class="group">
                    <div class="img-frame rounded-2xl aspect-[4/5]"
                         data-fallback="Gallery 03 · 1000×1250">
                        <img src="{{ asset('images/landing/gallery-3.png') }}"
                             alt="Dokumentasi layanan akademik 3"
                             loading="lazy"
                             decoding="async"
                             class="transition-transform duration-700 group-hover:scale-[1.03]"
                             onerror="this.parentElement.classList.add('is-missing'); this.style.display='none';">
                    </div>
                    <figcaption class="mt-3 flex items-center justify-between">
                        <span class="font-mono text-[10px] tracking-widest uppercase text-ink-400">03 / Arsip</span>
                        <span class="font-mono text-[10px] tracking-widest uppercase text-ink-300">2025</span>
                    </figcaption>
                </figure>

            </div>
        </div>
    </section>

    {{-- ═══════════════════════════════════════════════════════════
         HOW IT WORKS
         ═══════════════════════════════════════════════════════════ --}}
    <section class="relative z-10 px-6 py-20 sm:py-28">
        <div class="max-w-6xl mx-auto">

            <div class="max-w-md mb-14">
                <p class="font-mono text-[10px] tracking-[0.2em] uppercase text-ink-400 mb-3">04 — Alur</p>
                <h2 class="text-[28px] sm:text-[36px] leading-[1.1] tracking-[-0.02em] font-semibold text-ink-900 text-balance">
                    Empat langkah. Tanpa drama.
                </h2>
            </div>

            <ol class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-px bg-line border-y border-line">
                <li class="bg-canvas p-8 sm:p-10">
                    <span class="font-mono text-[11px] text-ink-300 tracking-widest">01</span>
                    <div class="mt-6 h-px w-8 bg-ink-900"></div>
                    <h3 class="mt-5 text-[15px] font-semibold text-ink-900 tracking-tight">Ajukan Berkas</h3>
                    <p class="mt-2 text-[13px] text-ink-500 leading-relaxed">Siswa login dan memilih jenis layanan serta dokumen yang dibutuhkan.</p>
                </li>
                <li class="bg-canvas p-8 sm:p-10">
                    <span class="font-mono text-[11px] text-ink-300 tracking-widest">02</span>
                    <div class="mt-6 h-px w-8 bg-ink-900"></div>
                    <h3 class="mt-5 text-[15px] font-semibold text-ink-900 tracking-tight">Penyiapan TU</h3>
                    <p class="mt-2 text-[13px] text-ink-500 leading-relaxed">Petugas memverifikasi dan menyiapkan dokumen fisik di ruang arsip.</p>
                </li>
                <li class="bg-canvas p-8 sm:p-10">
                    <span class="font-mono text-[11px] text-ink-300 tracking-widest">03</span>
                    <div class="mt-6 h-px w-8 bg-ink-900"></div>
                    <h3 class="mt-5 text-[15px] font-semibold text-ink-900 tracking-tight">Ambil &amp; Scan QR</h3>
                    <p class="mt-2 text-[13px] text-ink-500 leading-relaxed">Siswa datang dan memindai QR Code penyerahan di monitor Admin.</p>
                </li>
                <li class="bg-canvas p-8 sm:p-10">
                    <span class="font-mono text-[11px] text-accent tracking-widest">04</span>
                    <div class="mt-6 h-px w-8 bg-accent"></div>
                    <h3 class="mt-5 text-[15px] font-semibold text-ink-900 tracking-tight">Cetak Resi</h3>
                    <p class="mt-2 text-[13px] text-ink-500 leading-relaxed">Sistem menerbitkan Bukti Serah Terima resmi ber-stempel digital.</p>
                </li>
            </ol>
        </div>
    </section>

    {{-- ═══════════════════════════════════════════════════════════
         CTA BANNER
         ═══════════════════════════════════════════════════════════ --}}
    <section class="relative z-10 px-6 pb-20">
        <div class="max-w-6xl mx-auto">
            <div class="relative overflow-hidden rounded-3xl bg-ink-900 px-8 sm:px-14 py-14 sm:py-16">

                <div class="absolute inset-0 opacity-[0.08]" style="background-image: radial-gradient(circle, white 1px, transparent 1px); background-size: 20px 20px;"></div>
                <div class="absolute -top-20 -right-20 w-80 h-80 rounded-full bg-accent/30 blur-[100px]"></div>

                {{-- 📁 Gambar opsional di kanan banner: public/images/landing/cta.png
                     📐 Rekomendasi: 600×600 PNG transparan --}}
                <div class="hidden lg:block absolute right-12 top-1/2 -translate-y-1/2 w-52 h-52">
                    <img src="{{ asset('images/landing/cta.png') }}"
                         alt=""
                         loading="lazy"
                         decoding="async"
                         class="w-full h-full object-contain"
                         onerror="this.style.display='none';">
                </div>

                <div class="relative max-w-xl">
                    <p class="font-mono text-[10px] tracking-[0.2em] uppercase text-accent/80 mb-3">Siap digunakan</p>
                    <h2 class="text-[26px] sm:text-[34px] leading-[1.12] tracking-[-0.02em] font-semibold text-white text-balance">
                        Mulai ajukan dokumen akademikmu hari ini.
                    </h2>
                    <p class="mt-4 text-[13px] text-white/60 leading-relaxed max-w-md">
                        Login dengan akun sekolahmu dan pilih jenis layanan yang dibutuhkan. Proses cepat, transparan, dan bisa dilacak.
                    </p>

                    <div class="mt-8 flex flex-wrap gap-3">
                        @auth
                            @php
                                $userRole = is_object(auth()->user()->role) ? auth()->user()->role->value : auth()->user()->role;
                            @endphp
                            <a href="{{ route($userRole . '.dashboard') }}"
                               class="press inline-flex items-center gap-2 h-11 pl-5 pr-4 rounded-xl bg-white text-ink-900 text-[12px] font-medium hover:bg-white/90">
                                <span>Buka Dashboard</span>
                                <svg class="w-3.5 h-3.5" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.75">
                                    <path d="M3 8h10M9 4l4 4-4 4" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </a>
                        @else
                            <a href="{{ route('login') }}"
                               class="press inline-flex items-center gap-2 h-11 pl-5 pr-4 rounded-xl bg-white text-ink-900 text-[12px] font-medium hover:bg-white/90">
                                <span>Masuk Sistem</span>
                                <svg class="w-3.5 h-3.5" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.75">
                                    <path d="M3 8h10M9 4l4 4-4 4" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </a>
                        @endauth
                        <a href="#tracking-result"
                           class="press inline-flex items-center gap-2 h-11 px-5 rounded-xl border border-white/15 text-white/90 text-[12px] font-medium hover:bg-white/5">
                            Lacak Pengajuan
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </section>

    {{-- ═══════════════════════════════════════════════════════════
         FOOTER
         ═══════════════════════════════════════════════════════════ --}}
    <footer class="relative z-10 px-6 py-10 border-t border-line">
        <div class="max-w-6xl mx-auto flex flex-col sm:flex-row items-center justify-between gap-4">

            <div class="flex items-center gap-3">
                <div class="relative w-7 h-7 rounded-lg bg-ink-900 flex items-center justify-center overflow-hidden">
                    <img src="{{ asset('images/landing/logo.png') }}"
                         alt=""
                         class="absolute inset-0 w-full h-full object-contain p-1"
                         onerror="this.style.display='none'">
                </div>
                <p class="text-[12px] font-medium text-ink-700">SIDAKA — SMK Negeri 5 Surakarta</p>
            </div>

            <p class="font-mono text-[10px] tracking-wider uppercase text-ink-400">
                © {{ date('Y') }} · Layanan Dokumen Akademik v2.0
            </p>

        </div>
    </footer>

</body>
</html>