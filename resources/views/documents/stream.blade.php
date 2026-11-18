<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pratinjau Resmi — {{ $document->title }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
      tailwind.config = {
        theme: {
          extend: {
            fontFamily: {
              sans: ['Inter', 'ui-sans-serif', 'system-ui', 'sans-serif'],
              mono: ['"JetBrains Mono"', 'ui-monospace', 'SFMono-Regular', 'monospace'],
            },
          }
        }
      }
    </script>

    <style>
        html { -webkit-font-smoothing: antialiased; -moz-osx-font-smoothing: grayscale; font-feature-settings: 'cv11', 'ss01'; }

        body {
            font-family: 'Inter', sans-serif;
            background-color: #0A0A0A;
            /* Grid halus ala Nothing */
            background-image:
                linear-gradient(rgba(255,255,255,0.02) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255,255,255,0.02) 1px, transparent 1px);
            background-size: 32px 32px;
        }

        ::selection { background: rgba(10, 132, 255, 0.35); color: #FFFFFF; }

        ::-webkit-scrollbar { width: 10px; height: 10px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb {
            background: rgba(255,255,255,0.15); border-radius: 999px;
            border: 2px solid transparent; background-clip: content-box;
        }
        ::-webkit-scrollbar-thumb:hover { background: rgba(255,255,255,0.25); background-clip: content-box; }

        /* Glass surface untuk header */
        .glass-dark {
            background: rgba(10, 10, 10, 0.72);
            backdrop-filter: blur(20px) saturate(180%);
            -webkit-backdrop-filter: blur(20px) saturate(180%);
        }

        /* ─── WATERMARK ─── */
        .watermark-overlay {
            position: fixed;
            inset: 0;
            pointer-events: none;
            z-index: 9999;
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around;
            align-content: space-around;
            overflow: hidden;
            opacity: 0.10;
            user-select: none;
            mix-blend-mode: multiply;
        }

        .watermark-text {
            transform: rotate(-30deg);
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 0.15em;
            color: #0A0A0A;
            text-transform: uppercase;
            white-space: nowrap;
            padding: 36px 28px;
            font-family: 'JetBrains Mono', monospace;
        }

        /* ─── Document frame shadow ─── */
        .paper-shadow {
            box-shadow:
                0 1px 0 rgba(255,255,255,0.06) inset,
                0 4px 12px rgba(0,0,0,0.4),
                0 24px 64px rgba(0,0,0,0.5),
                0 0 0 1px rgba(255,255,255,0.04);
        }

        /* Subtle float animation untuk badge */
        @keyframes subtlePulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.55; }
        }
        .pulse-dot { animation: subtlePulse 2s ease-in-out infinite; }

        @media print {
            .no-print { display: none !important; }
            .watermark-overlay { opacity: 0.08 !important; }
        }
    </style>
</head>
<body class="min-h-screen flex flex-col text-neutral-100">

    {{-- ═══════════════════════════════════════════════════════════
         HEADER (glass over dark)
         ═══════════════════════════════════════════════════════════ --}}
    <header class="no-print sticky top-0 z-40 glass-dark border-b border-white/[0.06]">
        <div class="max-w-[1400px] mx-auto px-4 sm:px-6 py-3.5 flex items-center justify-between gap-4">

            {{-- Left: brand + document title --}}
            <div class="flex items-center gap-3 sm:gap-4 min-w-0 flex-1">

                {{-- Brand mark --}}
                <div class="hidden sm:flex shrink-0 w-9 h-9 rounded-xl bg-white items-center justify-center overflow-hidden relative">
                    <img src="{{ asset('images/landing/logo.png') }}"
                         alt=""
                         class="absolute inset-0 w-full h-full object-contain p-1.5"
                         onerror="this.style.display='none'">
                    <span class="text-[#0A0A0A] font-semibold text-[14px] tracking-tight relative z-10">S</span>
                    <span class="absolute bottom-0 left-0 right-0 h-[2px] bg-[#0A84FF]"></span>
                </div>

                {{-- Title & type --}}
                <div class="min-w-0 flex-1">
                    <div class="flex items-center gap-2 mb-0.5">
                        <span class="w-1.5 h-1.5 rounded-full bg-[#0A84FF] shrink-0"></span>
                        <span class="font-mono text-[9px] tracking-[0.2em] uppercase text-white/40">
                            Pratinjau Dokumen
                        </span>
                    </div>
                    <h1 class="text-[13px] sm:text-[14px] font-medium text-white tracking-tight truncate">
                        {{ $document->title }}
                    </h1>
                    <p class="mt-0.5 font-mono text-[10px] tracking-wider uppercase text-white/40 truncate">
                        {{ $document->documentType->name ?? 'Dokumen' }}
                    </p>
                </div>
            </div>

            {{-- Right: badge + close --}}
            <div class="flex items-center gap-2 shrink-0">

                {{-- Protected badge --}}
                <div class="hidden sm:flex items-center gap-2 h-9 pl-2.5 pr-3 rounded-xl
                            bg-[#0A84FF]/[0.10] border border-[#0A84FF]/[0.22]">
                    <svg class="w-3.5 h-3.5 text-[#0A84FF]" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.75">
                        <rect x="4" y="9" width="12" height="8" rx="1.5"/>
                        <path d="M7 9V6.5a3 3 0 016 0V9"/>
                    </svg>
                    <span class="font-mono text-[10px] tracking-[0.15em] uppercase text-[#6FB8FF]">
                        Terproteksi
                    </span>
                </div>

                {{-- Mobile: lock icon only --}}
                <div class="sm:hidden flex items-center justify-center w-9 h-9 rounded-xl
                            bg-[#0A84FF]/[0.10] border border-[#0A84FF]/[0.22]">
                    <svg class="w-3.5 h-3.5 text-[#0A84FF]" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.75">
                        <rect x="4" y="9" width="12" height="8" rx="1.5"/>
                        <path d="M7 9V6.5a3 3 0 016 0V9"/>
                    </svg>
                </div>

                {{-- Close button --}}
                <button onclick="window.close()"
                        class="inline-flex items-center gap-1.5 h-9 pl-2.5 pr-3.5 rounded-xl
                               bg-white/[0.06] border border-white/[0.10] text-white/80
                               hover:bg-white/[0.10] hover:text-white hover:border-white/[0.16]
                               text-[11px] font-medium
                               transition-all duration-200 active:scale-[0.98]">
                    <svg class="w-3.5 h-3.5" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.75">
                        <path d="M4 4l8 8M12 4l-8 8" stroke-linecap="round"/>
                    </svg>
                    <span class="hidden sm:inline">Tutup</span>
                </button>
            </div>
        </div>
    </header>

    {{-- ═══════════════════════════════════════════════════════════
         WATERMARK OVERLAY (dynamic)
         ═══════════════════════════════════════════════════════════ --}}
    <div class="watermark-overlay" aria-hidden="true">
        @for($i = 0; $i < 12; $i++)
            <div class="watermark-text">
                DOKUMEN RESMI SIDAKA · {{ auth()->user()->name }} · {{ date('d/m/Y H:i') }} WIB
            </div>
        @endfor
    </div>

    {{-- ═══════════════════════════════════════════════════════════
         DOCUMENT VIEWER
         ═══════════════════════════════════════════════════════════ --}}
    <main class="flex-1 relative flex items-center justify-center p-4 sm:p-6 lg:p-8">

        {{-- Ambient glow behind document --}}
        <div class="absolute inset-0 flex items-center justify-center pointer-events-none overflow-hidden" aria-hidden="true">
            <div class="w-[600px] h-[600px] rounded-full bg-[#0A84FF]/[0.06] blur-[120px]"></div>
        </div>

        {{-- Document container --}}
        <div class="relative w-full max-w-5xl">

            {{-- Top-right technical markers (Nothing-style) --}}
            <div class="hidden sm:flex absolute -top-5 right-2 items-center gap-2 font-mono text-[9px] tracking-[0.2em] uppercase text-white/30">
                <span>Preview · 01</span>
                <span class="w-1 h-1 rounded-full bg-white/20"></span>
                <span class="tabular-nums">{{ date('H:i') }} WIB</span>
            </div>

            {{-- Top-left file type marker --}}
            <div class="hidden sm:flex absolute -top-5 left-2 items-center gap-2 font-mono text-[9px] tracking-[0.2em] uppercase text-white/30">
                <span class="w-1.5 h-1.5 rounded-full bg-[#0A84FF] pulse-dot"></span>
                <span>
                    @if(str_contains($document->mime_type ?? '', 'pdf') || str_contains($document->file_path ?? '', '.pdf'))
                        PDF Viewer
                    @else
                        Image Viewer
                    @endif
                </span>
            </div>

            {{-- Corner brackets ala scanner --}}
            <span class="hidden sm:block absolute -top-2 -left-2 w-5 h-5 border-t-2 border-l-2 border-[#0A84FF]/40 rounded-tl-lg pointer-events-none"></span>
            <span class="hidden sm:block absolute -top-2 -right-2 w-5 h-5 border-t-2 border-r-2 border-[#0A84FF]/40 rounded-tr-lg pointer-events-none"></span>
            <span class="hidden sm:block absolute -bottom-2 -left-2 w-5 h-5 border-b-2 border-l-2 border-[#0A84FF]/40 rounded-bl-lg pointer-events-none"></span>
            <span class="hidden sm:block absolute -bottom-2 -right-2 w-5 h-5 border-b-2 border-r-2 border-[#0A84FF]/40 rounded-br-lg pointer-events-none"></span>

            {{-- Document frame --}}
            <div class="paper-shadow rounded-2xl overflow-hidden bg-white">

                @if(str_contains($document->mime_type ?? '', 'pdf') || str_contains($document->file_path ?? '', '.pdf'))

                    {{-- PDF Viewer --}}
                    <iframe src="{{ asset('storage/' . $document->file_path) }}"
                            class="w-full h-[75vh] sm:h-[80vh] block bg-white"
                            title="{{ $document->title }}"></iframe>

                @else

                    {{-- Image Viewer --}}
                    <div class="p-4 sm:p-6 bg-white flex items-center justify-center min-h-[300px]">
                        <img src="{{ asset('storage/' . $document->file_path) }}"
                             alt="{{ $document->title }}"
                             class="max-h-[80vh] w-auto object-contain block">
                    </div>

                @endif

            </div>

            {{-- Bottom info strip --}}
            <div class="mt-5 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 px-1">
                <div class="flex items-center gap-3">
                    <div class="flex items-center gap-1.5">
                        <span class="w-1 h-1 rounded-full bg-[#0FB57A]"></span>
                        <span class="font-mono text-[9px] tracking-[0.2em] uppercase text-white/40">
                            Watermark Aktif
                        </span>
                    </div>
                    <span class="text-white/20">·</span>
                    <span class="font-mono text-[9px] tracking-[0.2em] uppercase text-white/40">
                        Session {{ auth()->id() }}
                    </span>
                </div>
                <span class="font-mono text-[9px] tracking-[0.2em] uppercase text-white/30">
                    SMK Negeri 5 Surakarta · SIDAKA
                </span>
            </div>

        </div>
    </main>

</body>
</html>