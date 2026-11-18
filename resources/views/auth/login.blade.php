<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Portal masuk SIDAKA — Sistem Layanan Dokumen Akademik SMK Negeri 5 Surakarta.">
    <title>Portal Masuk — SIDAKA SMKN 5 Surakarta</title>

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
            from { opacity: 0; transform: translateY(10px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-up { animation: fadeUp 0.6s cubic-bezier(0.16,1,0.3,1) both; }

        @media (prefers-reduced-motion: reduce) {
            *, *::before, *::after {
                animation-duration: 0.01ms !important;
                transition-duration: 0.01ms !important;
            }
        }

        .press { transition: transform 200ms cubic-bezier(0.16,1,0.3,1), background-color 200ms, border-color 200ms, box-shadow 200ms; }
        .press:active { transform: scale(0.99); }
    </style>
</head>

<body class="antialiased text-ink-700"
      x-data="{ tab: '{{ old('login_type', 'user') }}' }">

    {{-- DESKTOP: kunci ke 100vh, no-scroll. MOBILE: flow normal. --}}
    <div class="min-h-screen lg:h-screen lg:overflow-hidden grid grid-cols-1 lg:grid-cols-12">

        {{-- KIRI — PANEL GAMBAR (desktop only) --}}
        <aside class="hidden lg:flex lg:col-span-6 xl:col-span-7 relative overflow-hidden bg-ink-900 lg:h-screen">

            <img src="{{ asset('images/login/cover.png') }}"
                 alt="Suasana akademik SMK Negeri 5 Surakarta"
                 loading="eager"
                 decoding="async"
                 class="absolute inset-0 w-full h-full object-cover opacity-90"
                 onerror="this.style.display='none';">

            <div class="absolute inset-0 bg-gradient-to-br from-ink-900/80 via-ink-900/55 to-accent/40"></div>
            <div class="absolute inset-0 opacity-[0.07]" style="background-image: radial-gradient(circle, white 1px, transparent 1px); background-size: 20px 20px;"></div>

            <div class="absolute top-8 right-8 font-mono text-[10px] tracking-[0.2em] uppercase text-white/50">v2.0</div>

            <div class="relative z-10 flex flex-col justify-between w-full p-10 xl:p-14">

                <div class="flex items-center gap-3">
                    <div class="relative w-11 h-11 rounded-xl bg-white flex items-center justify-center overflow-hidden shrink-0">
                        <img src="{{ asset('images/landing/logo.png') }}"
                             alt="Logo SMKN 5 Surakarta"
                             class="absolute inset-0 w-full h-full object-contain p-2"
                             onerror="this.style.display='none'">
                    </div>
                    <div class="leading-none">
                        <div class="flex items-center gap-2">
                            <span class="font-semibold text-[15px] text-white tracking-tight">SIDAKA</span>
                            <span class="font-mono text-[9px] text-white/50 tracking-widest uppercase">v2.0</span>
                        </div>
                        <span class="block text-[11px] text-white/60 mt-1">SMK Negeri 5 Surakarta</span>
                    </div>
                </div>

                <div class="max-w-md">
                    <div class="flex items-center gap-2 mb-5">
                        <span class="w-1.5 h-1.5 rounded-full bg-accent"></span>
                        <span class="font-mono text-[10px] tracking-[0.2em] uppercase text-white/70">Portal Masuk</span>
                    </div>

                    <h2 class="text-[36px] xl:text-[44px] leading-[1.05] tracking-[-0.03em] font-semibold text-white text-balance">
                        Selamat datang kembali di SIDAKA.
                    </h2>
                    <p class="mt-5 text-[13px] xl:text-[14px] leading-relaxed text-white/60 max-w-sm">
                        Akses layanan dokumen akademik SMK Negeri 5 Surakarta — cepat, transparan, dan bisa dilacak dari mana saja.
                    </p>

                    <div class="mt-8 grid grid-cols-3 gap-px bg-white/10 border border-white/10 rounded-2xl overflow-hidden backdrop-blur">
                        <div class="bg-white/[0.02] px-4 py-3.5">
                            <p class="text-[16px] font-semibold text-white tabular-nums">100%</p>
                            <p class="mt-1 font-mono text-[9px] tracking-wider uppercase text-white/50">Audit</p>
                        </div>
                        <div class="bg-white/[0.02] px-4 py-3.5">
                            <p class="text-[16px] font-semibold text-white tabular-nums">&lt;3m</p>
                            <p class="mt-1 font-mono text-[9px] tracking-wider uppercase text-white/50">Serah</p>
                        </div>
                        <div class="bg-white/[0.02] px-4 py-3.5">
                            <p class="text-[16px] font-semibold text-white tabular-nums">Zero</p>
                            <p class="mt-1 font-mono text-[9px] tracking-wider uppercase text-white/50">Risiko</p>
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-between">
                    <span class="font-mono text-[10px] tracking-[0.2em] uppercase text-white/40">© {{ date('Y') }} SMKN 5 SKA</span>
                    <span class="font-mono text-[10px] tracking-[0.2em] uppercase text-white/40">Surakarta · ID</span>
                </div>
            </div>
        </aside>

        {{-- KANAN — FORM LOGIN --}}
        <main class="lg:col-span-6 xl:col-span-5 relative flex flex-col min-h-screen lg:min-h-0 lg:h-screen lg:overflow-y-auto"
              style="overscroll-behavior: contain;">

            <header class="px-5 sm:px-8 pt-6 shrink-0">
                <div class="flex items-center justify-between">
                    <a href="{{ route('landing') }}"
                       class="press inline-flex items-center gap-2 h-9 pl-3 pr-3.5 rounded-xl text-[11px] font-medium text-ink-500 hover:text-ink-900 hover:bg-ink-900/5 transition">
                        <svg class="w-3.5 h-3.5" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.75">
                            <path d="M13 8H3M7 4L3 8l4 4" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        <span class="hidden sm:inline">Beranda</span>
                    </a>
                </div>
            </header>

            <div class="flex-1 flex items-center justify-center px-5 sm:px-8 py-10">
                <div class="w-full max-w-[420px] animate-fade-up">

                    <div class="mb-8">
                        <div class="flex items-center gap-2 mb-4">
                            <span class="w-1.5 h-1.5 rounded-full bg-accent"></span>
                            <span class="font-mono text-[10px] tracking-[0.2em] uppercase text-ink-400">Portal Masuk</span>
                        </div>
                        <h1 class="text-[26px] sm:text-[30px] leading-[1.15] tracking-[-0.02em] font-semibold text-ink-900 text-balance">
                            Masuk ke akun SIDAKA kamu.
                        </h1>
                        <p class="mt-3 text-[13px] leading-relaxed text-ink-500">
                            Pilih tipe akun, lalu masukkan kredensial yang sesuai.
                        </p>
                    </div>

                    {{-- Segmented control --}}
                    <div class="relative bg-white/70 backdrop-blur border border-line rounded-2xl p-1 mb-5 flex items-center">
                        <div class="absolute top-1 bottom-1 w-[calc(50%-4px)] rounded-xl bg-ink-900 shadow-[0_2px_8px_rgba(0,0,0,0.15)] transition-all duration-300 ease-[cubic-bezier(0.16,1,0.3,1)]"
                             :class="tab === 'user' ? 'left-1' : 'left-[calc(50%+1px)]'"></div>

                        <button type="button" @click="tab = 'user'"
                                class="relative z-10 flex-1 h-10 inline-flex items-center justify-center gap-2 text-[12px] font-medium transition-colors duration-200"
                                :class="tab === 'user' ? 'text-white' : 'text-ink-500 hover:text-ink-900'">
                            <svg class="w-3.5 h-3.5" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.6">
                                <path d="M10 11a4 4 0 100-8 4 4 0 000 8z"/>
                                <path d="M3 18a7 7 0 0114 0" stroke-linecap="round"/>
                            </svg>
                            <span>Siswa / Guru</span>
                        </button>
                        <button type="button" @click="tab = 'admin'"
                                class="relative z-10 flex-1 h-10 inline-flex items-center justify-center gap-2 text-[12px] font-medium transition-colors duration-200"
                                :class="tab === 'admin' ? 'text-white' : 'text-ink-500 hover:text-ink-900'">
                            <svg class="w-3.5 h-3.5" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.6">
                                <path d="M10 2l7 3v5c0 4-3 7-7 8-4-1-7-4-7-8V5l7-3z"/>
                                <path d="M7.5 10l2 2 3.5-4" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            <span>Admin / Petugas</span>
                        </button>
                    </div>

                    {{-- Card form --}}
                    <div class="glass rounded-3xl p-6 sm:p-8">

                        {{-- FORM 1: SISWA & GURU --}}
                        <div x-show="tab === 'user'"
                             x-transition:enter="transition ease-out duration-300"
                             x-transition:enter-start="opacity-0 translate-y-1"
                             x-transition:enter-end="opacity-100 translate-y-0">
                            <form action="{{ route('login') }}" method="POST" class="space-y-5">
                                @csrf
                                <input type="hidden" name="login_type" value="user">

                                <div>
                                    <label for="identity_user" class="block text-[11px] font-medium text-ink-700 uppercase tracking-wider mb-2">
                                        Nomor Identitas · NISN / NIP
                                    </label>
                                    <div class="relative">
                                        <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-ink-400">
                                            <svg class="w-4 h-4" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.6">
                                                <rect x="3" y="5" width="14" height="11" rx="2"/>
                                                <path d="M3 9h14"/>
                                                <circle cx="7" cy="12.5" r="1"/>
                                            </svg>
                                        </span>
                                        <input type="text" name="identity" id="identity_user"
                                               value="{{ old('login_type', 'user') === 'user' ? old('identity') : '' }}"
                                               required
                                               autocomplete="username"
                                               placeholder="NISN siswa atau NIP guru"
                                               class="focus-ring w-full h-12 pl-10 pr-4 rounded-xl bg-white/70 border border-line text-[13px] font-mono text-ink-900 placeholder:text-ink-300 placeholder:font-sans transition outline-none">
                                    </div>
                                    @if(old('login_type', 'user') === 'user')
                                        @error('identity')
                                            <p class="mt-2 text-[12px] text-danger font-medium flex items-start gap-1.5">
                                                <svg class="w-3.5 h-3.5 mt-0.5 shrink-0" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.75">
                                                    <circle cx="8" cy="8" r="6"/>
                                                    <path d="M8 5v3.5M8 11h.01" stroke-linecap="round"/>
                                                </svg>
                                                {{ $message }}
                                            </p>
                                        @enderror
                                    @endif
                                </div>

                                {{-- Input Kata Sandi Siswa/Guru --}}
                                <div x-data="{ show: false }">
                                    <label for="password_user" class="block text-[11px] font-medium text-ink-700 uppercase tracking-wider mb-2">
                                        Kata Sandi
                                    </label>
                                    <div class="relative">
                                        <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-ink-400">
                                            <svg class="w-4 h-4" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.6">
                                                <rect x="4" y="9" width="12" height="8" rx="2"/>
                                                <path d="M7 9V7a3 3 0 016 0v2"/>
                                            </svg>
                                        </span>
                                        <input :type="show ? 'text' : 'password'" name="password" id="password_user" required
                                               autocomplete="current-password"
                                               placeholder="••••••••"
                                               class="focus-ring w-full h-12 pl-10 pr-12 rounded-xl bg-white/70 border border-line text-[13px] text-ink-900 placeholder:text-ink-300 transition outline-none">
                                        <button type="button" @click="show = !show"
                                                class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-ink-400 hover:text-ink-700 transition"
                                                :aria-label="show ? 'Sembunyikan kata sandi' : 'Tampilkan kata sandi'">
                                            <svg x-show="!show" class="w-4 h-4" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.6">
                                                <path d="M2 10s3-6 8-6 8 6 8 6-3 6-8 6-8-6-8-6z"/>
                                                <circle cx="10" cy="10" r="2.5"/>
                                            </svg>
                                            <svg x-show="show" class="w-4 h-4" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.6" style="display: none;">
                                                <path d="M3 3l14 14M8.5 8.6A2.5 2.5 0 0012 12M6.5 6.5C4 8 2 10 2 10s3 6 8 6c1.5 0 2.9-.5 4-1.2M9 4.1C9.3 4 9.7 4 10 4c5 0 8 6 8 6s-.8 1.6-2.2 3"/>
                                            </svg>
                                        </button>
                                    </div>
                                    @if(old('login_type', 'user') === 'user')
                                        @error('password')
                                            <p class="mt-2 text-[12px] text-danger font-medium flex items-start gap-1.5">
                                                <svg class="w-3.5 h-3.5 mt-0.5 shrink-0" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.75">
                                                    <circle cx="8" cy="8" r="6"/>
                                                    <path d="M8 5v3.5M8 11h.01" stroke-linecap="round"/>
                                                </svg>
                                                {{ $message }}
                                            </p>
                                        @enderror
                                    @endif
                                </div>

                                <button type="submit"
                                        class="press w-full h-12 inline-flex items-center justify-center gap-2 rounded-xl bg-ink-900 hover:bg-ink-700 text-white text-[12px] font-medium">
                                    <span>Masuk ke Akun</span>
                                    <svg class="w-3.5 h-3.5 opacity-70" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.75">
                                        <path d="M3 8h10M9 4l4 4-4 4" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </button>
                            </form>

                            <div class="mt-6 pt-5 border-t border-line">
                                <div class="flex items-start gap-2.5">
                                    <div class="shrink-0 w-7 h-7 rounded-lg bg-accent/10 border border-accent/15 flex items-center justify-center">
                                        <svg class="w-3.5 h-3.5 text-accent" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.75">
                                            <circle cx="8" cy="8" r="6"/>
                                            <path d="M8 7.5v3.5M8 5h.01" stroke-linecap="round"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-[12px] font-medium text-ink-900">Keamanan Akun Terjaga</p>
                                        <p class="mt-1 text-[11px] text-ink-500 leading-relaxed">
                                            Gunakan NISN (Siswa) atau NIP (Guru) beserta kata sandi. Password bawaan akun baru: <code class="bg-black/5 text-ink-900 px-1.5 py-0.5 rounded font-mono text-[10px]">password123</code>.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- FORM 2: ADMIN / PETUGAS --}}
                        <div x-show="tab === 'admin'"
                             x-transition:enter="transition ease-out duration-300"
                             x-transition:enter-start="opacity-0 translate-y-1"
                             x-transition:enter-end="opacity-100 translate-y-0"
                             style="display: none;">
                            <form action="{{ route('login') }}" method="POST" class="space-y-5">
                                @csrf
                                <input type="hidden" name="login_type" value="admin">

                                <div>
                                    <label for="identity_admin" class="block text-[11px] font-medium text-ink-700 uppercase tracking-wider mb-2">
                                        Email Akun Admin
                                    </label>
                                    <div class="relative">
                                        <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-ink-400">
                                            <svg class="w-4 h-4" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.6">
                                                <rect x="2.5" y="5" width="15" height="10" rx="2"/>
                                                <path d="M3 6l7 5 7-5"/>
                                            </svg>
                                        </span>
                                        <input type="email" name="identity" id="identity_admin"
                                               value="{{ old('login_type') === 'admin' ? old('identity') : '' }}"
                                               required
                                               autocomplete="email"
                                               placeholder="admin@sekolah.sch.id"
                                               class="focus-ring w-full h-12 pl-10 pr-4 rounded-xl bg-white/70 border border-line text-[13px] text-ink-900 placeholder:text-ink-300 transition outline-none">
                                    </div>
                                    @if(old('login_type') === 'admin')
                                        @error('identity')
                                            <p class="mt-2 text-[12px] text-danger font-medium flex items-start gap-1.5">
                                                <svg class="w-3.5 h-3.5 mt-0.5 shrink-0" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.75">
                                                    <circle cx="8" cy="8" r="6"/>
                                                    <path d="M8 5v3.5M8 11h.01" stroke-linecap="round"/>
                                                </svg>
                                                {{ $message }}
                                            </p>
                                        @enderror
                                    @endif
                                </div>

                                <div x-data="{ show: false }">
                                    <label for="password_admin" class="block text-[11px] font-medium text-ink-700 uppercase tracking-wider mb-2">
                                        Kata Sandi
                                    </label>
                                    <div class="relative">
                                        <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-ink-400">
                                            <svg class="w-4 h-4" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.6">
                                                <rect x="4" y="9" width="12" height="8" rx="2"/>
                                                <path d="M7 9V7a3 3 0 016 0v2"/>
                                            </svg>
                                        </span>
                                        <input :type="show ? 'text' : 'password'" name="password" id="password_admin" required
                                               autocomplete="current-password"
                                               placeholder="••••••••"
                                               class="focus-ring w-full h-12 pl-10 pr-12 rounded-xl bg-white/70 border border-line text-[13px] text-ink-900 placeholder:text-ink-300 transition outline-none">
                                        <button type="button" @click="show = !show"
                                                class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-ink-400 hover:text-ink-700 transition"
                                                :aria-label="show ? 'Sembunyikan kata sandi' : 'Tampilkan kata sandi'">
                                            <svg x-show="!show" class="w-4 h-4" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.6">
                                                <path d="M2 10s3-6 8-6 8 6 8 6-3 6-8 6-8-6-8-6z"/>
                                                <circle cx="10" cy="10" r="2.5"/>
                                            </svg>
                                            <svg x-show="show" class="w-4 h-4" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.6" style="display: none;">
                                                <path d="M3 3l14 14M8.5 8.6A2.5 2.5 0 0012 12M6.5 6.5C4 8 2 10 2 10s3 6 8 6c1.5 0 2.9-.5 4-1.2M9 4.1C9.3 4 9.7 4 10 4c5 0 8 6 8 6s-.8 1.6-2.2 3"/>
                                            </svg>
                                        </button>
                                    </div>
                                    @if(old('login_type') === 'admin')
                                        @error('password')
                                            <p class="mt-2 text-[12px] text-danger font-medium flex items-start gap-1.5">
                                                <svg class="w-3.5 h-3.5 mt-0.5 shrink-0" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.75">
                                                    <circle cx="8" cy="8" r="6"/>
                                                    <path d="M8 5v3.5M8 11h.01" stroke-linecap="round"/>
                                                </svg>
                                                {{ $message }}
                                            </p>
                                        @enderror
                                    @endif
                                </div>

                                <button type="submit"
                                        class="press w-full h-12 inline-flex items-center justify-center gap-2 rounded-xl bg-ink-900 hover:bg-ink-700 text-white text-[12px] font-medium">
                                    <span>Otentikasi Admin</span>
                                    <svg class="w-3.5 h-3.5 opacity-70" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.75">
                                        <path d="M3 8h10M9 4l4 4-4 4" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </button>
                            </form>

                            <div class="mt-6 pt-5 border-t border-line">
                                <div class="flex items-start gap-2.5">
                                    <div class="shrink-0 w-7 h-7 rounded-lg bg-ink-900/[0.04] border border-line flex items-center justify-center">
                                        <svg class="w-3.5 h-3.5 text-ink-700" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.6">
                                            <rect x="3.5" y="7" width="9" height="6.5" rx="1.5"/>
                                            <path d="M5.5 7V5.5a2.5 2.5 0 015 0V7"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-[12px] font-medium text-ink-900">Akses terbatas</p>
                                        <p class="mt-1 text-[11px] text-ink-500 leading-relaxed">
                                            Portal ini khusus untuk Petugas Tata Usaha &amp; Administrator SIDAKA. Aktivitas login tercatat.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <p class="mt-6 text-center font-mono text-[10px] tracking-[0.2em] uppercase text-ink-400">
                        © {{ date('Y') }} · SMK Negeri 5 Surakarta
                    </p>

                </div>
            </div>

        </main>

    </div>

</body>
</html>