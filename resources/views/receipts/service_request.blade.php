<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bukti Serah Terima — {{ $serviceRequest->request_number }}</title>

    <style>
        /* ═══════════════════════════════════════════════════════════
           PRINT SETUP — A4, margin resmi, page-break protection
           ═══════════════════════════════════════════════════════════ */
        @page {
            size: A4;
            margin: 18mm 16mm 20mm 16mm;
        }

        /* ═══════════════════════════════════════════════════════════
           BASE — Serif untuk dokumen resmi
           ═══════════════════════════════════════════════════════════ */
        * {
            box-sizing: border-box;
        }

        html, body {
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Times New Roman', Times, Georgia, serif;
            font-size: 12pt;
            line-height: 1.55;
            color: #000;
            background: #F5F5F7;
            padding: 24px 16px;
            -webkit-font-smoothing: antialiased;
        }

        /* ═══════════════════════════════════════════════════════════
           TOOLBAR (screen only) — pakai Inter biar match design system
           ═══════════════════════════════════════════════════════════ */
        .toolbar {
            font-family: -apple-system, BlinkMacSystemFont, 'Inter', 'Segoe UI', sans-serif;
            max-width: 210mm;
            margin: 0 auto 16px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            padding: 10px 14px;
            background: #FFFFFF;
            border: 1px solid rgba(0,0,0,0.06);
            border-radius: 14px;
            box-shadow: 0 1px 2px rgba(0,0,0,0.03), 0 8px 24px rgba(0,0,0,0.04);
        }

        .toolbar-left {
            display: flex;
            align-items: center;
            gap: 10px;
            min-width: 0;
        }

        .toolbar-dot {
            width: 6px;
            height: 6px;
            border-radius: 999px;
            background: #0A84FF;
            flex-shrink: 0;
        }

        .toolbar-label {
            font-size: 10px;
            letter-spacing: 0.2em;
            text-transform: uppercase;
            color: #8E8E93;
            font-weight: 500;
        }

        .toolbar-title {
            font-size: 12px;
            color: #1F1F1F;
            font-weight: 500;
            margin-top: 2px;
        }

        .btn-print {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            height: 40px;
            padding: 0 18px;
            border-radius: 10px;
            background: #0A0A0A;
            color: #FFFFFF;
            border: none;
            cursor: pointer;
            font-family: inherit;
            font-size: 12px;
            font-weight: 500;
            letter-spacing: 0.02em;
            transition: background-color 200ms, transform 200ms;
            white-space: nowrap;
        }

        .btn-print:hover {
            background: #1F1F1F;
        }

        .btn-print:active {
            transform: scale(0.98);
        }

        .btn-print svg {
            width: 14px;
            height: 14px;
            opacity: 0.7;
        }

        /* ═══════════════════════════════════════════════════════════
           PAPER — A4 sheet
           ═══════════════════════════════════════════════════════════ */
        .paper {
            max-width: 210mm;
            margin: 0 auto;
            background: #FFFFFF;
            padding: 20mm 18mm;
            border: 1px solid rgba(0,0,0,0.06);
            border-radius: 4px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.04), 0 16px 48px rgba(0,0,0,0.08);
        }

        /* ═══════════════════════════════════════════════════════════
           KOP SURAT — Letterhead klasik Indonesia
           ═══════════════════════════════════════════════════════════ */
        .kop {
            text-align: center;
            padding-bottom: 10px;
            margin-bottom: 22px;
            border-bottom: 3px double #000;
        }

        .kop-prov {
            font-size: 11pt;
            font-weight: 400;
            letter-spacing: 0.02em;
            margin: 0;
            text-transform: uppercase;
            color: #1a1a1a;
        }

        .kop-school {
            font-size: 16pt;
            font-weight: 700;
            letter-spacing: 0.04em;
            margin: 2px 0 0;
            text-transform: uppercase;
            color: #000;
        }

        .kop-address {
            font-size: 10pt;
            font-style: italic;
            margin: 4px 0 0;
            color: #333;
            line-height: 1.35;
        }

        /* ═══════════════════════════════════════════════════════════
           TITLE
           ═══════════════════════════════════════════════════════════ */
        .doc-title {
            text-align: center;
            font-size: 13pt;
            font-weight: 700;
            letter-spacing: 0.02em;
            text-decoration: underline;
            text-underline-offset: 4px;
            margin: 0 0 6px;
            text-transform: uppercase;
        }

        .doc-number {
            text-align: center;
            font-family: 'Courier New', monospace;
            font-size: 11pt;
            margin: 0 0 20px;
            color: #1a1a1a;
            letter-spacing: 0.05em;
        }

        .doc-intro {
            font-size: 12pt;
            margin: 0 0 12px;
            text-align: justify;
            line-height: 1.55;
        }

        /* ═══════════════════════════════════════════════════════════
           IDENTITY TABLE — key-value clean
           ═══════════════════════════════════════════════════════════ */
        .identity-table {
            width: 100%;
            border-collapse: collapse;
            margin: 0 0 18px;
            font-size: 12pt;
        }

        .identity-table td {
            padding: 3px 4px;
            vertical-align: top;
            line-height: 1.55;
        }

        .identity-table .label {
            width: 140px;
            color: #1a1a1a;
        }

        .identity-table .sep {
            width: 14px;
            color: #333;
        }

        .identity-table .value {
            font-weight: 400;
            color: #000;
        }

        .identity-table .value strong {
            font-weight: 700;
        }

        /* ═══════════════════════════════════════════════════════════
           DOCUMENT LIST TABLE
           ═══════════════════════════════════════════════════════════ */
        .section-label {
            font-size: 12pt;
            font-weight: 700;
            margin: 0 0 8px;
        }

        .doc-table {
            width: 100%;
            border-collapse: collapse;
            margin: 0 0 20px;
            font-size: 11pt;
        }

        .doc-table th,
        .doc-table td {
            border: 1px solid #000;
            padding: 7px 10px;
            text-align: left;
            vertical-align: top;
        }

        .doc-table th {
            background-color: #F0F0F0;
            font-weight: 700;
            text-align: center;
            text-transform: uppercase;
            font-size: 10pt;
            letter-spacing: 0.05em;
        }

        .doc-table th.col-no,
        .doc-table td.col-no {
            text-align: center;
            width: 40px;
        }

        /* ═══════════════════════════════════════════════════════════
           SIGNATURE BLOCK — pakai flex (bukan float!)
           ═══════════════════════════════════════════════════════════ */
        .signature-block {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 40px;
            margin-top: 30px;
            page-break-inside: avoid;
        }

        .signature-col {
            flex: 1;
            text-align: center;
            font-size: 12pt;
        }

        .signature-col .sig-date {
            margin: 0 0 2px;
            line-height: 1.5;
        }

        .signature-col .sig-role {
            margin: 0;
            line-height: 1.5;
        }

        .signature-col .sig-space {
            height: 70px;
        }

        .signature-col .sig-space-qr {
            height: 80px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 6px 0;
        }

        .signature-col .sig-name {
            font-weight: 700;
            margin: 0;
            padding-top: 4px;
            border-top: 1px solid #000;
            display: inline-block;
            min-width: 160px;
            line-height: 1.4;
            padding: 4px 12px 0;
        }

        /* ─── QR Code wrapper (fix broken Tailwind-in-style) ─── */
        .qr-wrap {
            width: 76px;
            height: 76px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .qr-wrap svg {
            width: 100% !important;
            height: 100% !important;
            display: block;
        }

        /* ═══════════════════════════════════════════════════════════
           FOOTER NOTE
           ═══════════════════════════════════════════════════════════ */
        .footer-note {
            margin-top: 26px;
            padding-top: 10px;
            border-top: 1px solid #ccc;
            font-size: 9pt;
            font-style: italic;
            color: #555;
            text-align: center;
            line-height: 1.5;
        }

        /* ═══════════════════════════════════════════════════════════
           PRINT — clean output
           ═══════════════════════════════════════════════════════════ */
        @media print {
            body {
                background: #FFFFFF !important;
                padding: 0 !important;
                margin: 0 !important;
                font-size: 12pt !important;
            }

            .no-print { display: none !important; }

            .paper {
                box-shadow: none !important;
                border: none !important;
                border-radius: 0 !important;
                padding: 0 !important;
                margin: 0 !important;
                max-width: none !important;
            }

            .signature-block { page-break-inside: avoid; }
            .doc-table { page-break-inside: auto; }
            .doc-table tr { page-break-inside: avoid; }

            * {
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }
        }

        @media (max-width: 640px) {
            .paper {
                padding: 20px 16px;
                border-radius: 0;
            }
            .toolbar {
                border-radius: 12px;
                flex-direction: column;
                align-items: stretch;
            }
            .btn-print {
                justify-content: center;
            }
            .identity-table .label {
                width: 100px;
            }
            .signature-block {
                gap: 20px;
            }
            .signature-col .sig-name {
                min-width: auto;
                padding: 4px 6px 0;
            }
        }
    </style>
</head>
<body>

    {{-- ═══════════════════════════════════════════════════════════
         TOOLBAR (no-print)
         ═══════════════════════════════════════════════════════════ --}}
    <div class="toolbar no-print">

        <div class="toolbar-left">
            <span class="toolbar-dot"></span>
            <div>
                <p class="toolbar-label">Dokumen Resmi</p>
                <p class="toolbar-title">Bukti Serah Terima SIDAKA</p>
            </div>
        </div>

        <button onclick="window.print()" class="btn-print" type="button">
            <svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.6">
                <path d="M4 6V3a1 1 0 011-1h6a1 1 0 011 1v3" stroke-linejoin="round"/>
                <path d="M2 6h12a1 1 0 011 1v4a1 1 0 01-1 1h-2v-2H4v2H3a1 1 0 01-1-1V7a1 1 0 011-1z" stroke-linejoin="round"/>
                <path d="M4 12h8v3a1 1 0 01-1 1H5a1 1 0 01-1-1v-3z"/>
            </svg>
            <span>Cetak / Download PDF</span>
        </button>
    </div>

    {{-- ═══════════════════════════════════════════════════════════
         PAPER
         ═══════════════════════════════════════════════════════════ --}}
    <div class="paper">

        {{-- ─── KOP SURAT ─── --}}
        <header class="kop">
            <p class="kop-prov">Pemerintah Provinsi Jawa Tengah</p>
            <h1 class="kop-school">SMK Negeri 5 Surakarta</h1>
            <p class="kop-address">
                Jl. Adisucipto No. 42, Kerten, Laweyan, Kota Surakarta, Jawa Tengah 57143
            </p>
        </header>

        {{-- ─── TITLE ─── --}}
        <h2 class="doc-title">Tanda Terima Penyerahan Dokumen Akademik</h2>
        <p class="doc-number">Nomor: {{ $serviceRequest->request_number }}</p>

        {{-- ─── INTRO ─── --}}
        <p class="doc-intro">
            Telah diserahkan dokumen akademik resmi dari pihak Tata Usaha SMK Negeri 5 Surakarta kepada siswa dengan rincian data sebagai berikut:
        </p>

        {{-- ─── IDENTITY TABLE ─── --}}
        <table class="identity-table">
            <tbody>
                <tr>
                    <td class="label">Nama Siswa</td>
                    <td class="sep">:</td>
                    <td class="value"><strong>{{ $serviceRequest->student->user->name }}</strong></td>
                </tr>
                <tr>
                    <td class="label">NIS / NISN</td>
                    <td class="sep">:</td>
                    <td class="value">{{ $serviceRequest->student->nis }} / {{ $serviceRequest->student->nisn }}</td>
                </tr>
                <tr>
                    <td class="label">Kelas / Jurusan</td>
                    <td class="sep">:</td>
                    <td class="value">{{ $serviceRequest->student->classInfo->name }} / {{ $serviceRequest->student->major->name }}</td>
                </tr>
                <tr>
                    <td class="label">Jenis Layanan</td>
                    <td class="sep">:</td>
                    <td class="value">{{ $serviceRequest->serviceType->name }}</td>
                </tr>
                <tr>
                    <td class="label">Waktu Transaksi</td>
                    <td class="sep">:</td>
                    <td class="value">{{ $serviceRequest->updated_at->format('d F Y - H:i:s') }} WIB</td>
                </tr>
            </tbody>
        </table>

        {{-- ─── DOCUMENT LIST ─── --}}
        <p class="section-label">Daftar Dokumen Fisik yang Diserahkan:</p>

        <table class="doc-table">
            <thead>
                <tr>
                    <th class="col-no">No</th>
                    <th>Nama Dokumen</th>
                    <th>Jenis Dokumen</th>
                </tr>
            </thead>
            <tbody>
                @foreach($serviceRequest->items as $index => $item)
                    <tr>
                        <td class="col-no">{{ $index + 1 }}</td>
                        <td>{{ $item->document->title }}</td>
                        <td>{{ $item->document->documentType->name }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{-- ─── SIGNATURE BLOCK ─── --}}
        <div class="signature-block">

            {{-- Penerima (Siswa) --}}
            <div class="signature-col">
                <p class="sig-role">Penerima (Siswa),</p>
                <div class="sig-space"></div>
                <p class="sig-name">{{ $serviceRequest->student->user->name }}</p>
            </div>

            {{-- Petugas TU --}}
            <div class="signature-col">
                <p class="sig-date">Surakarta, {{ $serviceRequest->updated_at->format('d F Y') }}</p>
                <p class="sig-role">Petugas Tata Usaha,</p>

                {{-- QR Code (verifikasi digital) --}}
                <div class="sig-space-qr">
                    <div class="qr-wrap">
                        {!! $qrSvg !!}
                    </div>
                </div>

                <p class="sig-name">Admin TU SIDAKA</p>
            </div>

        </div>

        {{-- ─── FOOTER NOTE ─── --}}
        <p class="footer-note">
            Dokumen ini diterbitkan secara otomatis oleh Sistem Informasi Dokumen Akademik Siswa (SIDAKA).
            Keaslian dapat diverifikasi dengan memindai QR Code di atas.
        </p>

    </div>

</body>
</html>