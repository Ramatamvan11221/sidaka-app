<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'SIDAKA - SMKN 5 Surakarta' }}</title>

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
          }
        }
      }
    </script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        :root {
            --canvas: #FAFAFA;
            --grid-line: rgba(0, 0, 0, 0.03);
        }

        [x-cloak] { display: none !important; }

        html { -webkit-font-smoothing: antialiased; -moz-osx-font-smoothing: grayscale; font-feature-settings: 'cv11', 'ss01'; }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--canvas);
            background-image:
                linear-gradient(var(--grid-line) 1px, transparent 1px),
                linear-gradient(90deg, var(--grid-line) 1px, transparent 1px);
            background-size: 32px 32px;
            background-attachment: fixed;
        }

        ::selection { background: rgba(10, 132, 255, 0.18); color: #0A0A0A; }

        ::-webkit-scrollbar { width: 8px; height: 8px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb {
            background: rgba(0,0,0,0.12); border-radius: 999px;
            border: 2px solid transparent; background-clip: content-box;
        }
        ::-webkit-scrollbar-thumb:hover { background: rgba(0,0,0,0.22); background-clip: content-box; }

        /* ─── Sidebar transform logic ─── */
        .sidebar-shell {
            transform: translateX(-100%);
            transition: transform 300ms cubic-bezier(0.16, 1, 0.3, 1);
            will-change: transform;
        }
        .sidebar-open .sidebar-shell { transform: translateX(0); }

        @media (min-width: 768px) {
            .sidebar-shell { transform: translateX(0); }
        }

        /* ─── Glass surface ─── */
        .glass {
            background: rgba(255,255,255,0.72);
            backdrop-filter: blur(20px) saturate(180%);
            -webkit-backdrop-filter: blur(20px) saturate(180%);
        }

        /* ─── Nav item active state ─── */
        .nav-item {
            position: relative;
            transition: background-color 200ms, color 200ms;
        }
        .nav-item::before {
            content: '';
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%) scaleY(0);
            width: 3px;
            height: 18px;
            background: #0A84FF;
            border-radius: 0 3px 3px 0;
            transition: transform 250ms cubic-bezier(0.16, 1, 0.3, 1);
        }
        .nav-item.is-active::before { transform: translateY(-50%) scaleY(1); }
        .nav-item.is-active {
            background: rgba(10, 132, 255, 0.06);
            color: #0055CC;
        }
        .nav-item.is-active .nav-icon { color: #0A84FF; }
        .nav-item.is-active .nav-dot { opacity: 1; }

        .nav-dot {
            width: 4px; height: 4px; border-radius: 999px;
            background: #0A84FF; opacity: 0;
            transition: opacity 200ms;
        }

        /* ─── SweetAlert overrides untuk konsistensi ─── */
        .swal2-toast {
            font-family: 'Inter', sans-serif !important;
            border-radius: 14px !important;
            box-shadow: 0 8px 24px rgba(0,0,0,0.08), 0 1px 2px rgba(0,0,0,0.04) !important;
            border: 1px solid rgba(0,0,0,0.06) !important;
        }
        .swal2-toast .swal2-title {
            font-size: 13px !important;
            font-weight: 500 !important;
            color: #1F1F1F !important;
        }

        @media (prefers-reduced-motion: reduce) {
            *, *::before, *::after {
                animation-duration: 0.01ms !important;
                transition-duration: 0.01ms !important;
            }
        }
    </style>
</head>

<body class="antialiased text-ink-700 min-h-screen"
      x-data="{ sidebarOpen: false }"
      :class="{ 'sidebar-open': sidebarOpen }">

    {{-- ═══════════════════════════════════════════════════════════
         MOBILE OVERLAY
         ═══════════════════════════════════════════════════════════ --}}
    <div x-show="sidebarOpen" x-cloak @click="sidebarOpen = false"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-40 bg-neutral-900/40 backdrop-blur-sm md:hidden"></div>

    {{-- ═══════════════════════════════════════════════════════════
         SIDEBAR
         ═══════════════════════════════════════════════════════════ --}}
    <aside class="sidebar-shell fixed inset-y-0 left-0 z-50 w-[264px] bg-white border-r border-black/[0.06] flex flex-col">

        {{-- ── Brand ── --}}
        <div class="shrink-0 px-5 py-5 border-b border-black/[0.06]">
            <a href="{{ url('/') }}" class="flex items-center gap-3 group">
                <div class="relative w-10 h-10 rounded-xl bg-ink-900 flex items-center justify-center overflow-hidden shrink-0">
                    <img src="{{ asset('images/landing/logo.png') }}"
                         alt="Logo SMKN 5 Surakarta"
                         class="absolute inset-0 w-full h-full object-contain p-1.5"
                         onerror="this.style.display='none'">
                    <span class="text-white font-semibold text-[16px] tracking-tight relative z-10">S</span>
                    <span class="absolute bottom-0 left-0 right-0 h-[2px] bg-accent"></span>
                </div>
                <div class="leading-none min-w-0 flex-1">
                    <div class="flex items-center gap-2">
                        <span class="font-semibold text-[14px] text-ink-900 tracking-tight">SIDAKA</span>
                        <span class="font-mono text-[9px] text-ink-400 tracking-widest uppercase">v2.0</span>
                    </div>
                    <span class="block text-[10px] text-ink-400 mt-1 truncate">SMK Negeri 5 Surakarta</span>
                </div>
            </a>

            {{-- Role chip --}}
            <div class="mt-4 flex items-center gap-2">
                <span class="w-1.5 h-1.5 rounded-full bg-accent"></span>
                <span class="font-mono text-[9px] tracking-[0.2em] uppercase text-ink-500">
                    {{ strtoupper(auth()->user()->role->value ?? auth()->user()->role) }}
                </span>
            </div>
        </div>

        {{-- ── Navigation ── --}}
        <nav class="flex-1 overflow-y-auto py-3 px-2.5 space-y-0.5">

            @if(auth()->user()->isAdmin())

                <p class="px-3 pt-2 pb-2 font-mono text-[9px] tracking-[0.2em] uppercase text-ink-300">01 — Utama</p>

                {{-- Dashboard --}}
                <a href="{{ route('admin.dashboard') }}"
                   class="nav-item {{ request()->routeIs('admin.dashboard') ? 'is-active' : '' }} flex items-center gap-3 h-10 px-3 rounded-xl text-[13px] font-medium text-ink-700 hover:bg-black/[0.03]">
                    <span class="nav-icon w-[18px] h-[18px] shrink-0 flex items-center justify-center text-ink-400">
                        <svg viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.6" class="w-full h-full">
                            <path d="M3 8.5l7-5 7 5V16a1 1 0 01-1 1h-3.5v-5h-5v5H4a1 1 0 01-1-1V8.5z" stroke-linejoin="round"/>
                        </svg>
                    </span>
                    <span class="flex-1">Dashboard</span>
                    <span class="nav-dot"></span>
                </a>

                {{-- Pengajuan Layanan --}}
                <a href="{{ route('admin.service-requests.index') }}"
                   class="nav-item {{ request()->routeIs('admin.service-requests.index') && request('status') !== 'ready' ? 'is-active' : '' }} flex items-center gap-3 h-10 px-3 rounded-xl text-[13px] font-medium text-ink-700 hover:bg-black/[0.03]">
                    <span class="nav-icon w-[18px] h-[18px] shrink-0 flex items-center justify-center text-ink-400">
                        <svg viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.6" class="w-full h-full">
                            <path d="M3 11V5a1 1 0 011-1h12a1 1 0 011 1v6" stroke-linejoin="round"/>
                            <path d="M3 11l2.5 5h9L17 11H3z" stroke-linejoin="round"/>
                            <path d="M7.5 11l.8 1.5h3.4l.8-1.5" stroke-linejoin="round"/>
                        </svg>
                    </span>
                    <span class="flex-1">Pengajuan Layanan</span>
                    <span class="nav-dot"></span>
                </a>

                <p class="px-3 pt-5 pb-2 font-mono text-[9px] tracking-[0.2em] uppercase text-ink-300">02 — Operasional</p>

                {{-- Kelola Dokumen (Tambahan Baru) --}}
                <a href="{{ route('admin.documents.index') }}"
                   class="nav-item {{ request()->routeIs('admin.documents.*') ? 'is-active' : '' }} flex items-center gap-3 h-10 px-3 rounded-xl text-[13px] font-medium text-ink-700 hover:bg-black/[0.03]">
                    <span class="nav-icon w-[18px] h-[18px] shrink-0 flex items-center justify-center text-ink-400">
                        <svg viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.6" class="w-full h-full">
                            <path d="M3 6a1 1 0 011-1h3l2 2h7a1 1 0 011 1v7a1 1 0 01-1 1H4a1 1 0 01-1-1V6z" stroke-linejoin="round"/>
                        </svg>
                    </span>
                    <span class="flex-1">Kelola Dokumen</span>
                    <span class="nav-dot"></span>
                </a>

                {{-- Laporan --}}
                <a href="{{ route('admin.reports.index') }}"
                   class="nav-item {{ request()->routeIs('admin.reports.*') ? 'is-active' : '' }} flex items-center gap-3 h-10 px-3 rounded-xl text-[13px] font-medium text-ink-700 hover:bg-black/[0.03]">
                    <span class="nav-icon w-[18px] h-[18px] shrink-0 flex items-center justify-center text-ink-400">
                        <svg viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.6" class="w-full h-full">
                            <path d="M4 16V9M8 16V5M12 16v-4M16 16V7" stroke-linecap="round"/>
                        </svg>
                    </span>
                    <span class="flex-1">Laporan &amp; Export</span>
                    <span class="nav-dot"></span>
                </a>

                <p class="px-3 pt-5 pb-2 font-mono text-[9px] tracking-[0.2em] uppercase text-ink-300">03 — Sistem</p>

                {{-- Import --}}
                <a href="{{ route('admin.imports.index') }}"
                   class="nav-item {{ request()->routeIs('admin.imports.*') ? 'is-active' : '' }} flex items-center gap-3 h-10 px-3 rounded-xl text-[13px] font-medium text-ink-700 hover:bg-black/[0.03]">
                    <span class="nav-icon w-[18px] h-[18px] shrink-0 flex items-center justify-center text-ink-400">
                        <svg viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.6" class="w-full h-full">
                            <path d="M10 3v9M6.5 8.5L10 12l3.5-3.5" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M4 16h12" stroke-linecap="round"/>
                        </svg>
                    </span>
                    <span class="flex-1">Import Akun</span>
                    <span class="nav-dot"></span>
                </a>

                {{-- Audit Log --}}
                <a href="{{ route('admin.activity-logs') }}"
                   class="nav-item {{ request()->routeIs('admin.activity-logs') ? 'is-active' : '' }} flex items-center gap-3 h-10 px-3 rounded-xl text-[13px] font-medium text-ink-700 hover:bg-black/[0.03]">
                    <span class="nav-icon w-[18px] h-[18px] shrink-0 flex items-center justify-center text-ink-400">
                        <svg viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.6" class="w-full h-full">
                            <rect x="4" y="3.5" width="12" height="13" rx="1.5"/>
                            <path d="M7 7.5h6M7 10.5h6M7 13.5h3" stroke-linecap="round"/>
                        </svg>
                    </span>
                    <span class="flex-1">Audit Log</span>
                    <span class="nav-dot"></span>
                </a>

            @elseif(auth()->user()->isTeacher())

                <p class="px-3 pt-2 pb-2 font-mono text-[9px] tracking-[0.2em] uppercase text-ink-300">01 — Menu</p>

                <a href="{{ route('teacher.dashboard') }}"
                   class="nav-item {{ request()->routeIs('teacher.dashboard') ? 'is-active' : '' }} flex items-center gap-3 h-10 px-3 rounded-xl text-[13px] font-medium text-ink-700 hover:bg-black/[0.03]">
                    <span class="nav-icon w-[18px] h-[18px] shrink-0 flex items-center justify-center text-ink-400">
                        <svg viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.6" class="w-full h-full">
                            <path d="M3 8.5l7-5 7 5V16a1 1 0 01-1 1h-3.5v-5h-5v5H4a1 1 0 01-1-1V8.5z" stroke-linejoin="round"/>
                        </svg>
                    </span>
                    <span class="flex-1">Dashboard</span>
                    <span class="nav-dot"></span>
                </a>

                <a href="{{ route('teacher.documents.index') }}"
                   class="nav-item {{ request()->routeIs('teacher.documents.*') ? 'is-active' : '' }} flex items-center gap-3 h-10 px-3 rounded-xl text-[13px] font-medium text-ink-700 hover:bg-black/[0.03]">
                    <span class="nav-icon w-[18px] h-[18px] shrink-0 flex items-center justify-center text-ink-400">
                        <svg viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.6" class="w-full h-full">
                            <path d="M3 6a1 1 0 011-1h3l2 2h7a1 1 0 011 1v7a1 1 0 01-1 1H4a1 1 0 01-1-1V6z" stroke-linejoin="round"/>
                        </svg>
                    </span>
                    <span class="flex-1">Kelola Dokumen</span>
                    <span class="nav-dot"></span>
                </a>

            @elseif(auth()->user()->isStudent())

                <p class="px-3 pt-2 pb-2 font-mono text-[9px] tracking-[0.2em] uppercase text-ink-300">01 — Menu</p>

                <a href="{{ route('student.dashboard') }}"
                   class="nav-item {{ request()->routeIs('student.dashboard') ? 'is-active' : '' }} flex items-center gap-3 h-10 px-3 rounded-xl text-[13px] font-medium text-ink-700 hover:bg-black/[0.03]">
                    <span class="nav-icon w-[18px] h-[18px] shrink-0 flex items-center justify-center text-ink-400">
                        <svg viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.6" class="w-full h-full">
                            <path d="M3 8.5l7-5 7 5V16a1 1 0 01-1 1h-3.5v-5h-5v5H4a1 1 0 01-1-1V8.5z" stroke-linejoin="round"/>
                        </svg>
                    </span>
                    <span class="flex-1">Dashboard</span>
                    <span class="nav-dot"></span>
                </a>

                <a href="{{ route('student.documents.index') }}"
                   class="nav-item {{ request()->routeIs('student.documents.*') ? 'is-active' : '' }} flex items-center gap-3 h-10 px-3 rounded-xl text-[13px] font-medium text-ink-700 hover:bg-black/[0.03]">
                    <span class="nav-icon w-[18px] h-[18px] shrink-0 flex items-center justify-center text-ink-400">
                        <svg viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.6" class="w-full h-full">
                            <path d="M3 6a1 1 0 011-1h3l2 2h7a1 1 0 011 1v7a1 1 0 01-1 1H4a1 1 0 01-1-1V6z" stroke-linejoin="round"/>
                        </svg>
                    </span>
                    <span class="flex-1">Dokumen Saya</span>
                    <span class="nav-dot"></span>
                </a>

                <a href="{{ route('student.service-requests.index') }}"
                   class="nav-item {{ request()->routeIs('student.service-requests.*') ? 'is-active' : '' }} flex items-center gap-3 h-10 px-3 rounded-xl text-[13px] font-medium text-ink-700 hover:bg-black/[0.03]">
                    <span class="nav-icon w-[18px] h-[18px] shrink-0 flex items-center justify-center text-ink-400">
                        <svg viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.6" class="w-full h-full">
                            <path d="M5 3h8l3 3v11a1 1 0 01-1 1H5a1 1 0 01-1-1V4a1 1 0 011-1z" stroke-linejoin="round"/>
                            <path d="M12.5 3v3.5H16" stroke-linejoin="round"/>
                            <path d="M7 11h6M7 14h4" stroke-linecap="round"/>
                        </svg>
                    </span>
                    <span class="flex-1">Pengajuan Saya</span>
                    <span class="nav-dot"></span>
                </a>

                <p class="px-3 pt-5 pb-2 font-mono text-[9px] tracking-[0.2em] uppercase text-ink-300">02 — Aksi</p>

                <a href="{{ route('student.qr-scan') }}"
                   class="nav-item {{ request()->routeIs('student.qr-scan') ? 'is-active' : '' }} flex items-center gap-3 h-10 px-3 rounded-xl text-[13px] font-medium text-ink-700 hover:bg-black/[0.03]">
                    <span class="nav-icon w-[18px] h-[18px] shrink-0 flex items-center justify-center text-ink-400">
                        <svg viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.6" class="w-full h-full">
                            <rect x="3" y="3" width="5" height="5" rx="1"/>
                            <rect x="12" y="3" width="5" height="5" rx="1"/>
                            <rect x="3" y="12" width="5" height="5" rx="1"/>
                            <path d="M12 12h2v2h-2zM16 12h1M12 16h1M14 14h1M17 17h1M17 14h1M14 17h1" stroke-linecap="round"/>
                        </svg>
                    </span>
                    <span class="flex-1">Scan QR Admin</span>
                    <span class="nav-dot"></span>
                </a>

            @endif
        </nav>

        {{-- ── Sidebar footer ── --}}
        <div class="shrink-0 px-4 py-3.5 border-t border-black/[0.06]">
            <div class="flex items-center justify-between gap-3">
                <div class="flex items-center gap-2.5 min-w-0">
                    <div class="w-7 h-7 rounded-full bg-neutral-100 border border-black/[0.06] flex items-center justify-center shrink-0">
                        <span class="text-[10px] font-semibold text-ink-700 uppercase">
                            {{ mb_substr(auth()->user()->name ?? 'U', 0, 1) }}
                        </span>
                    </div>
                    <div class="leading-tight min-w-0">
                        <p class="text-[11px] font-medium text-ink-900 truncate">{{ auth()->user()->name }}</p>
                        <p class="font-mono text-[9px] text-ink-400 tracking-wider uppercase mt-0.5">
                            {{ strtoupper(auth()->user()->role->value ?? auth()->user()->role) }}
                        </p>
                    </div>
                </div>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit"
                            class="w-7 h-7 rounded-lg flex items-center justify-center text-ink-400 hover:text-danger hover:bg-danger/5 transition"
                            aria-label="Keluar">
                        <svg class="w-3.5 h-3.5" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.6">
                            <path d="M12 4h3a1 1 0 011 1v10a1 1 0 01-1 1h-3" stroke-linecap="round"/>
                            <path d="M9 13l3-3-3-3M12 10H4" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </button>
                </form>
            </div>
        </div>
    </aside>

    {{-- ═══════════════════════════════════════════════════════════
         MAIN CONTENT
         ═══════════════════════════════════════════════════════════ --}}
    <div class="md:ml-[264px] min-h-screen flex flex-col">

        {{-- ── Header ── --}}
        <header class="sticky top-0 z-30 border-b border-black/[0.06] glass">
            <div class="flex items-center justify-between gap-3 px-4 sm:px-6 h-16">

                {{-- Left: hamburger + title --}}
                <div class="flex items-center gap-3 min-w-0 flex-1">
                    <button @click="sidebarOpen = true"
                            class="md:hidden shrink-0 w-9 h-9 rounded-xl flex items-center justify-center text-ink-700 hover:bg-black/[0.04] transition"
                            aria-label="Buka menu">
                        <svg class="w-4 h-4" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.75">
                            <path d="M3 6h14M3 10h14M3 14h14" stroke-linecap="round"/>
                        </svg>
                    </button>

                    <div class="min-w-0">
                        <div class="flex items-center gap-2">
                            <span class="w-1.5 h-1.5 rounded-full bg-accent shrink-0"></span>
                            <span class="font-mono text-[9px] tracking-[0.2em] uppercase text-ink-400 truncate">
                                SIDAKA · {{ strtoupper(auth()->user()->role->value ?? auth()->user()->role) }}
                            </span>
                        </div>
                        <h1 class="mt-0.5 text-[15px] sm:text-[16px] font-semibold text-ink-900 tracking-tight truncate">
                            {{ $header ?? 'Dashboard' }}
                        </h1>
                    </div>
                </div>

                {{-- Right: bell + user + logout --}}
                <div class="flex items-center gap-1.5 shrink-0">

                    {{-- Notification bell --}}
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open"
                                class="relative w-9 h-9 rounded-xl flex items-center justify-center text-ink-500 hover:text-ink-900 hover:bg-black/[0.04] transition"
                                aria-label="Notifikasi">
                            <svg class="w-4 h-4" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.6">
                                <path d="M6 8a4 4 0 118 0c0 3 1 4 2 5H4c1-1 2-2 2-5z" stroke-linejoin="round"/>
                                <path d="M8.5 15a1.5 1.5 0 003 0" stroke-linecap="round"/>
                            </svg>
                            @if(auth()->user()->unreadNotifications->count() > 0)
                                <span class="absolute top-1.5 right-1.5 w-2 h-2 bg-danger rounded-full ring-2 ring-white"></span>
                            @endif
                        </button>

                        {{-- Dropdown --}}
                        <div x-show="open" x-cloak @click.outside="open = false"
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 -translate-y-1"
                             x-transition:enter-end="opacity-100 translate-y-0"
                             x-transition:leave="transition ease-in duration-150"
                             x-transition:leave-start="opacity-100 translate-y-0"
                             x-transition:leave-end="opacity-0 -translate-y-1"
                             class="absolute right-0 top-full mt-2 w-[340px] max-w-[calc(100vw-2rem)] bg-white rounded-2xl border border-black/[0.06] shadow-[0_2px_4px_rgba(0,0,0,0.04),0_16px_40px_rgba(0,0,0,0.08)] overflow-hidden z-50">

                            {{-- Header --}}
                            <div class="px-4 py-3 border-b border-black/[0.06] flex items-center justify-between gap-3">
                                <div class="flex items-center gap-2">
                                    <span class="w-1.5 h-1.5 rounded-full bg-accent"></span>
                                    <span class="font-mono text-[10px] tracking-[0.2em] uppercase text-ink-400">Notifikasi</span>
                                </div>
                                @if(auth()->user()->unreadNotifications->count() > 0)
                                    <form action="{{ route('notifications.read-all') }}" method="POST">
                                        @csrf
                                        <button type="submit"
                                                class="font-mono text-[10px] tracking-wider uppercase text-accent hover:text-accent-ink transition">
                                            Tandai semua
                                        </button>
                                    </form>
                                @endif
                            </div>

                            {{-- List --}}
                            <div class="max-h-[340px] overflow-y-auto divide-y divide-black/[0.05]">
                                @forelse(auth()->user()->unreadNotifications as $notif)
                                    <a href="{{ route('notifications.read', $notif->id) }}"
                                       class="block px-4 py-3.5 hover:bg-black/[0.02] transition-colors">
                                        <div class="flex items-start gap-3">
                                            <span class="mt-1.5 w-1.5 h-1.5 rounded-full bg-accent shrink-0"></span>
                                            <div class="min-w-0 flex-1">
                                                <p class="text-[12.5px] font-medium text-ink-900 leading-snug">
                                                    {{ $notif->data['message'] ?? 'Notifikasi baru' }}
                                                </p>
                                                <p class="mt-1 font-mono text-[10px] text-ink-400 tracking-wider">
                                                    {{ $notif->created_at->diffForHumans() }}
                                                </p>
                                            </div>
                                        </div>
                                    </a>
                                @empty
                                    <div class="py-10 px-4 text-center">
                                        <div class="w-10 h-10 mx-auto rounded-2xl bg-neutral-50 border border-black/[0.06] flex items-center justify-center">
                                            <svg class="w-4 h-4 text-ink-300" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.6">
                                                <path d="M6 8a4 4 0 118 0c0 3 1 4 2 5H4c1-1 2-2 2-5z" stroke-linejoin="round"/>
                                                <path d="M8.5 15a1.5 1.5 0 003 0" stroke-linecap="round"/>
                                            </svg>
                                        </div>
                                        <p class="mt-3 text-[12px] text-ink-500">Tidak ada notifikasi baru.</p>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>

                    {{-- User chip (desktop) --}}
                    <div class="hidden lg:flex items-center gap-2.5 h-9 pl-1 pr-3.5 rounded-xl border border-black/[0.06] bg-white/60">
                        <div class="w-7 h-7 rounded-lg bg-ink-900 flex items-center justify-center">
                            <span class="text-[10px] font-semibold text-white uppercase">
                                {{ mb_substr(auth()->user()->name ?? 'U', 0, 1) }}
                            </span>
                        </div>
                        <span class="text-[12px] font-medium text-ink-900 max-w-[140px] truncate">
                            {{ auth()->user()->name }}
                        </span>
                    </div>

                    {{-- Logout (mobile only - desktop ada di sidebar) --}}
                    <form action="{{ route('logout') }}" method="POST" class="lg:hidden">
                        @csrf
                        <button type="submit"
                                class="w-9 h-9 rounded-xl flex items-center justify-center text-ink-500 hover:text-danger hover:bg-danger/5 transition"
                                aria-label="Keluar">
                            <svg class="w-4 h-4" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.6">
                                <path d="M12 4h3a1 1 0 011 1v10a1 1 0 01-1 1h-3" stroke-linecap="round"/>
                                <path d="M9 13l3-3-3-3M12 10H4" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </button>
                    </form>

                </div>
            </div>
        </header>

        {{-- ── Main slot ── --}}
        <main class="flex-1 p-4 sm:p-6 lg:p-8">
            {{ $slot }}
        </main>
    </div>

    {{-- ═══════════════════════════════════════════════════════════
         SWEETALERT2 TOASTS
         ═══════════════════════════════════════════════════════════ --}}
    <script>
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer);
                toast.addEventListener('mouseleave', Swal.resumeTimer);
            }
        });

        @if(session('success'))
            Toast.fire({
                icon: 'success',
                title: @json(session('success'))
            });
        @endif

        @if(session('error'))
            Toast.fire({
                icon: 'error',
                title: @json(session('error'))
            });
        @endif
    </script>
</body>
</html>