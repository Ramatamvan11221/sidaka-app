<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Rekapitulasi Layanan Dokumen - SIDAKA</title>

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
              mono: ['"JetBrains Mono"', 'ui-monospace', 'monospace'],
            },
          }
        }
      }
    </script>

    <style>
        body {
            font-family: 'Inter', sans-serif;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        /* ─── PRINT SETUP ─── */
        @page {
            size: A4;
            margin: 15mm 14mm 18mm 14mm;
        }

        @media print {
            .no-print { display: none !important; }

            html, body {
                padding: 0 !important;
                margin: 0 !important;
                background: #FFFFFF !important;
            }

            .paper {
                box-shadow: none !important;
                border: none !important;
                padding: 0 !important;
                margin: 0 !important;
                max-width: none !important;
                border-radius: 0 !important;
            }

            /* Repeat table header across pages */
            thead { display: table-header-group; }
            tr { page-break-inside: avoid; }

            /* Print color accuracy */
            * {
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }

            /* Sharpen borders for print */
            .print-border { border-color: #000000 !important; }
            .print-border-light { border-color: #666666 !important; }

            /* Slightly larger text for print legibility */
            .print-text { font-size: 10.5pt !important; line-height: 1.5 !important; }

            /* Signature safe-zone */
            .signature-block { page-break-inside: avoid; }
        }

        /* Tabular nums for aligned numbers */
        .tabular { font-variant-numeric: tabular-nums; }

        /* Screen: soft paper shadow */
        .paper {
            box-shadow: 0 1px 3px rgba(0,0,0,0.04), 0 16px 48px rgba(0,0,0,0.08);
        }

        @media (max-width: 640px) {
            .paper { border-radius: 0; }
        }
    </style>
</head>
<body class="bg-neutral-100 min-h-screen py-6 sm:py-10 px-4 sm:px-6 text-neutral-900">

    {{-- ═══════════════════════════════════════════════════════════
         FLOATING TOOLBAR (screen only)
         ═══════════════════════════════════════════════════════════ --}}
    <div class="no-print max-w-[210mm] mx-auto mb-5 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">

        <a href="{{ route('admin.reports.index') }}"
           class="inline-flex items-center gap-2 h-10 px-4 rounded-xl
                  bg-white border border-black/[0.08] text-neutral-700
                  hover:bg-neutral-50 hover:border-black/[0.14] text-[12px] font-medium
                  transition-all duration-200 active:scale-[0.98]">
            <svg class="w-3.5 h-3.5" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.75">
                <path d="M13 8H3M7 4L3 8l4 4" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            <span>Kembali ke Dashboard</span>
        </a>

        <button onclick="window.print()"
                class="inline-flex items-center justify-center gap-2 h-10 px-5 rounded-xl
                       bg-neutral-900 hover:bg-neutral-700 text-white text-[12px] font-medium
                       transition-all duration-200 active:scale-[0.98]">
            <svg class="w-3.5 h-3.5" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.6">
                <path d="M4 6V3a1 1 0 011-1h6a1 1 0 011 1v3" stroke-linejoin="round"/>
                <path d="M2 6h12a1 1 0 011 1v4a1 1 0 01-1 1h-2v-2H4v2H3a1 1 0 01-1-1V7a1 1 0 011-1z" stroke-linejoin="round"/>
                <path d="M4 12h8v3a1 1 0 01-1 1H5a1 1 0 01-1-1v-3z"/>
            </svg>
            <span>Cetak Laporan</span>
        </button>
    </div>

    {{-- ═══════════════════════════════════════════════════════════
         PAPER — A4 layout
         ═══════════════════════════════════════════════════════════ --}}
    <div class="paper max-w-[210mm] mx-auto bg-white rounded-2xl border border-black/[0.06] p-8 sm:p-10 lg:p-12">

        {{-- ═══ KOP SURAT ═══ --}}
        <header class="pb-4 mb-6 border-b-[3px] border-double print-border" style="border-bottom-width: 3px; border-bottom-style: double;">

            <div class="flex items-center gap-4 sm:gap-5">

                {{-- Logo sekolah --}}
                <div class="shrink-0 w-16 h-16 sm:w-20 sm:h-20 rounded-xl bg-neutral-50 border border-black/[0.06]
                            flex items-center justify-center overflow-hidden">
                    <img src="{{ asset('images/landing/logo.png') }}"
                         alt="Logo SMK Negeri 5 Surakarta"
                         class="w-full h-full object-contain p-2"
                         onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                    <span class="hidden text-neutral-400 font-mono text-[9px] tracking-widest uppercase text-center leading-tight">
                        LOGO<br>SEKOLAH
                    </span>
                </div>

                {{-- School name & address --}}
                <div class="flex-1 min-w-0 text-center">
                    <p class="font-mono text-[9px] tracking-[0.25em] uppercase text-neutral-400 mb-1">Pemerintah Provinsi Jawa Tengah</p>
                    <h1 class="text-[17px] sm:text-[20px] font-bold uppercase tracking-wider text-neutral-900 leading-tight">
                        SMK Negeri 5 Surakarta
                    </h1>
                    <p class="mt-1.5 text-[10.5px] sm:text-[11px] text-neutral-600 leading-snug">
                        Jl. A. Yani No. 374, Kerten, Laweyan, Kota Surakarta, Jawa Tengah 57143
                    </p>
                    <p class="mt-1 text-[10px] sm:text-[10.5px] font-semibold text-neutral-700 tracking-wide">
                        Sistem Informasi Dokumen Akademik Siswa (SIDAKA)
                    </p>
                </div>

                {{-- Spacer biar seimbang dengan logo kiri --}}
                <div class="shrink-0 w-16 h-16 sm:w-20 sm:h-20 hidden sm:block"></div>
            </div>

        </header>

        {{-- ═══ TITLE ═══ --}}
        <div class="text-center mb-7">
            <h2 class="text-[14px] sm:text-[15px] font-bold uppercase tracking-wider text-neutral-900 print-text">
                Laporan Rekapitulasi Transaksi Dokumen
            </h2>
            <p class="mt-2 font-mono text-[10px] tracking-wider uppercase text-neutral-500">
                Dicetak pada {{ date('d F Y H:i') }} WIB
            </p>
        </div>

        {{-- ═══ SUMMARY STRIP ═══ --}}
        <div class="mb-6 grid grid-cols-1 sm:grid-cols-3 gap-px bg-neutral-200 border border-neutral-200 rounded-lg overflow-hidden">

            <div class="bg-white px-4 py-3">
                <p class="font-mono text-[9px] tracking-[0.2em] uppercase text-neutral-400 mb-1">Total Transaksi</p>
                <p class="text-[16px] font-semibold text-neutral-900 tabular">{{ $reports->count() }}</p>
            </div>

            <div class="bg-white px-4 py-3">
                <p class="font-mono text-[9px] tracking-[0.2em] uppercase text-neutral-400 mb-1">Periode</p>
                <p class="text-[12px] font-medium text-neutral-700 tabular">
                    @if(request('start_date') || request('end_date'))
                        {{ request('start_date') ? \Carbon\Carbon::parse(request('start_date'))->format('d/m/Y') : '—' }}
                        <span class="text-neutral-400 mx-1">→</span>
                        {{ request('end_date') ? \Carbon\Carbon::parse(request('end_date'))->format('d/m/Y') : '—' }}
                    @else
                        Semua periode
                    @endif
                </p>
            </div>

            <div class="bg-white px-4 py-3">
                <p class="font-mono text-[9px] tracking-[0.2em] uppercase text-neutral-400 mb-1">Kriteria Filter</p>
                <p class="text-[12px] font-medium text-neutral-700">
                    @if(request('status') || request('service_type_id'))
                        {{ request('status') ? ucfirst(request('status')) : '' }}
                        {{ request('status') && request('service_type_id') ? ' · ' : '' }}
                        {{ request('service_type_id') ? 'Layanan terpilih' : '' }}
                    @else
                        Semua data
                    @endif
                </p>
            </div>

        </div>

        {{-- ═══ TABLE ═══ --}}
        <div class="overflow-x-auto -mx-8 sm:-mx-10 lg:-mx-12 px-8 sm:px-10 lg:px-12">
            <table class="w-full text-left text-[11px] border-collapse">

                <thead>
                    <tr class="bg-neutral-100 border-y border-neutral-400 print-border-light">
                        <th class="py-2.5 px-2 font-mono text-[9px] font-bold uppercase tracking-wider text-neutral-700 text-center w-10">No</th>
                        <th class="py-2.5 px-3 font-mono text-[9px] font-bold uppercase tracking-wider text-neutral-700">No. Pengajuan</th>
                        <th class="py-2.5 px-3 font-mono text-[9px] font-bold uppercase tracking-wider text-neutral-700">Nama Siswa</th>
                        <th class="py-2.5 px-3 font-mono text-[9px] font-bold uppercase tracking-wider text-neutral-700">Kelas</th>
                        <th class="py-2.5 px-3 font-mono text-[9px] font-bold uppercase tracking-wider text-neutral-700">Jenis Layanan</th>
                        <th class="py-2.5 px-3 font-mono text-[9px] font-bold uppercase tracking-wider text-neutral-700">Status</th>
                        <th class="py-2.5 px-3 font-mono text-[9px] font-bold uppercase tracking-wider text-neutral-700">Tgl Pengajuan</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-neutral-200 print-border-light">

                    @forelse($reports as $index => $row)
                        <tr class="align-top">
                            <td class="py-2.5 px-2 text-center text-neutral-500 tabular print-text">
                                {{ $index + 1 }}
                            </td>
                            <td class="py-2.5 px-3 font-mono font-medium text-neutral-900 tabular print-text whitespace-nowrap">
                                {{ $row->request_number }}
                            </td>
                            <td class="py-2.5 px-3 font-medium text-neutral-900 print-text">
                                {{ $row->student->user->name }}
                            </td>
                            <td class="py-2.5 px-3 text-neutral-700 tabular print-text whitespace-nowrap">
                                {{ $row->student->classInfo->name }}
                            </td>
                            <td class="py-2.5 px-3 text-neutral-700 print-text">
                                {{ $row->serviceType->name }}
                            </td>
                            <td class="py-2.5 px-3 whitespace-nowrap">
                                <span class="inline-block font-mono text-[9px] font-bold uppercase tracking-wider
                                             text-neutral-800 print-text">
                                    {{ $row->status->label() }}
                                </span>
                            </td>
                            <td class="py-2.5 px-3 text-neutral-600 tabular print-text whitespace-nowrap">
                                {{ $row->created_at->format('d/m/Y H:i') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-12 text-center">
                                <p class="text-[12px] text-neutral-400 italic">
                                    Tidak ada data transaksi untuk kriteria filter yang dipilih.
                                </p>
                            </td>
                        </tr>
                    @endforelse

                </tbody>

                @if($reports->count() > 0)
                    <tfoot>
                        <tr class="border-t-2 border-neutral-800 print-border">
                            <td colspan="6" class="py-3 px-3 text-right font-mono text-[10px] font-bold uppercase tracking-wider text-neutral-700">
                                Total Transaksi
                            </td>
                            <td class="py-3 px-3 text-center font-mono text-[12px] font-bold text-neutral-900 tabular">
                                {{ $reports->count() }}
                            </td>
                        </tr>
                    </tfoot>
                @endif

            </table>
        </div>

        {{-- ═══ SIGNATURE ═══ --}}
        <div class="signature-block mt-12 flex justify-end">
            <div class="text-center w-56 text-[11px]">

                <p class="text-neutral-600">
                    Surakarta, {{ date('d F Y') }}
                </p>

                <p class="mt-1 font-medium text-neutral-800">
                    Petugas Administrasi,
                </p>

                {{-- Ruang tanda tangan --}}
                <div class="h-20"></div>

                {{-- Nama + garis --}}
                <div class="pt-2 border-t border-neutral-800 print-border">
                    <p class="font-bold text-neutral-900 text-[12px] tracking-tight">
                        {{ auth()->user()->name }}
                    </p>
                    <p class="mt-1 font-mono text-[9.5px] text-neutral-500 tracking-wider">
                        NIP. 198203152009021003
                    </p>
                </div>

            </div>
        </div>

        {{-- ═══ FOOTER ═══ --}}
        <div class="mt-10 pt-4 border-t border-neutral-200 print-border-light flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
            <p class="font-mono text-[9px] tracking-[0.2em] uppercase text-neutral-400">
                SIDAKA · Sistem Informasi Dokumen Akademik Siswa
            </p>
            <p class="font-mono text-[9px] tracking-[0.2em] uppercase text-neutral-400">
                Dokumen ini dihasilkan otomatis oleh sistem
            </p>
        </div>

    </div>

</body>
</html>