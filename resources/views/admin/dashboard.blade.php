<x-layouts.app title="Dashboard Admin - SIDAKA">
    <x-slot name="header">Dashboard Monitoring System</x-slot>

    {{-- ═══════════════════════════════════════════════════════════
         INTRO STRIP
         ═══════════════════════════════════════════════════════════ --}}
    <div class="mb-6 sm:mb-8 flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 mb-2.5">
                <span class="w-1.5 h-1.5 rounded-full bg-accent"></span>
                <span class="font-mono text-[10px] tracking-[0.2em] uppercase text-ink-400">Ringkasan · Real-time</span>
            </div>
            <h2 class="text-[20px] sm:text-[24px] leading-tight tracking-[-0.02em] font-semibold text-ink-900 text-balance">
                Selamat datang kembali, {{ auth()->user()->name }}.
            </h2>
        </div>
        <p class="max-w-sm text-[12px] text-ink-500 leading-relaxed">
            Pantau statistik, tren pengajuan, dan aktivitas terbaru sistem SIDAKA.
        </p>
    </div>

    {{-- ═══════════════════════════════════════════════════════════
         STAT CARDS
         ═══════════════════════════════════════════════════════════ --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-5 mb-6">

        {{-- Total Siswa --}}
        <div class="group rounded-2xl border border-black/[0.06] bg-white/85 backdrop-blur-xl
                    shadow-[0_1px_2px_rgba(0,0,0,0.03),0_8px_24px_rgba(0,0,0,0.04)]
                    p-5 transition-all duration-300
                    hover:shadow-[0_2px_4px_rgba(0,0,0,0.04),0_16px_40px_rgba(0,0,0,0.07)]
                    hover:-translate-y-0.5">

            <div class="flex items-start justify-between gap-3 mb-5">
                <div class="w-10 h-10 rounded-xl bg-ink-900 flex items-center justify-center">
                    <svg class="w-4 h-4 text-white" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.6">
                        <circle cx="7" cy="7" r="2.5"/>
                        <circle cx="14" cy="8" r="2"/>
                        <path d="M2.5 15.5c.5-2.7 2.4-4.5 4.5-4.5s4 1.8 4.5 4.5" stroke-linecap="round"/>
                        <path d="M12 12.5c.3-.3.9-.5 1.5-.5 1.8 0 3.2 1.5 3.5 3.5" stroke-linecap="round"/>
                    </svg>
                </div>
                <span class="font-mono text-[9px] tracking-widest uppercase text-ink-300">01</span>
            </div>

            <p class="font-mono text-[10px] tracking-[0.2em] uppercase text-ink-400">Total Siswa</p>
            <p class="mt-2 text-[28px] leading-none font-semibold text-ink-900 tracking-tight tabular-nums">
                {{ $stats['total_students'] ?? 0 }}
            </p>
            <div class="mt-4 pt-4 border-t border-black/[0.05] flex items-center gap-1.5">
                <span class="w-1 h-1 rounded-full bg-accent"></span>
                <span class="text-[10px] text-ink-500 font-medium">Akun aktif</span>
            </div>
        </div>

        {{-- Total Dokumen --}}
        <div class="group rounded-2xl border border-black/[0.06] bg-white/85 backdrop-blur-xl
                    shadow-[0_1px_2px_rgba(0,0,0,0.03),0_8px_24px_rgba(0,0,0,0.04)]
                    p-5 transition-all duration-300
                    hover:shadow-[0_2px_4px_rgba(0,0,0,0.04),0_16px_40px_rgba(0,0,0,0.07)]
                    hover:-translate-y-0.5">

            <div class="flex items-start justify-between gap-3 mb-5">
                <div class="w-10 h-10 rounded-xl bg-ink-900 flex items-center justify-center">
                    <svg class="w-4 h-4 text-white" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.6">
                        <path d="M3 6a1 1 0 011-1h3.5l1.5 1.5H16a1 1 0 011 1V15a1 1 0 01-1 1H4a1 1 0 01-1-1V6z" stroke-linejoin="round"/>
                    </svg>
                </div>
                <span class="font-mono text-[9px] tracking-widest uppercase text-ink-300">02</span>
            </div>

            <p class="font-mono text-[10px] tracking-[0.2em] uppercase text-ink-400">Total Dokumen</p>
            <p class="mt-2 text-[28px] leading-none font-semibold text-ink-900 tracking-tight tabular-nums">
                {{ $stats['total_documents'] ?? 0 }}
            </p>
            <div class="mt-4 pt-4 border-t border-black/[0.05] flex items-center gap-1.5">
                <span class="w-1 h-1 rounded-full bg-accent"></span>
                <span class="text-[10px] text-ink-500 font-medium">Terarsip di sistem</span>
            </div>
        </div>

        {{-- Pending --}}
        <div class="group rounded-2xl border border-amber-500/20 bg-amber-500/[0.03] backdrop-blur-xl
                    shadow-[0_1px_2px_rgba(0,0,0,0.03),0_8px_24px_rgba(0,0,0,0.04)]
                    p-5 transition-all duration-300
                    hover:shadow-[0_2px_4px_rgba(0,0,0,0.04),0_16px_40px_rgba(0,0,0,0.07)]
                    hover:-translate-y-0.5">

            <div class="flex items-start justify-between gap-3 mb-5">
                <div class="w-10 h-10 rounded-xl bg-amber-500 flex items-center justify-center">
                    <svg class="w-4 h-4 text-white" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.75">
                        <circle cx="10" cy="10" r="7.5"/>
                        <path d="M10 6v4.5l2.5 2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
                <span class="font-mono text-[9px] tracking-widest uppercase text-amber-500/70">03</span>
            </div>

            <p class="font-mono text-[10px] tracking-[0.2em] uppercase text-amber-600">Pengajuan Pending</p>
            <p class="mt-2 text-[28px] leading-none font-semibold text-amber-600 tracking-tight tabular-nums">
                {{ $stats['pending_requests'] ?? 0 }}
            </p>
            <div class="mt-4 pt-4 border-t border-amber-500/15 flex items-center gap-1.5">
                <span class="w-1 h-1 rounded-full bg-amber-500"></span>
                <span class="text-[10px] text-amber-700/70 font-medium">Butuh diproses</span>
            </div>
        </div>

        {{-- Ready --}}
        <div class="group rounded-2xl border border-emerald-500/20 bg-emerald-500/[0.03] backdrop-blur-xl
                    shadow-[0_1px_2px_rgba(0,0,0,0.03),0_8px_24px_rgba(0,0,0,0.04)]
                    p-5 transition-all duration-300
                    hover:shadow-[0_2px_4px_rgba(0,0,0,0.04),0_16px_40px_rgba(0,0,0,0.07)]
                    hover:-translate-y-0.5">

            <div class="flex items-start justify-between gap-3 mb-5">
                <div class="w-10 h-10 rounded-xl bg-emerald-500 flex items-center justify-center">
                    <svg class="w-4 h-4 text-white" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M5 10.5l3.5 3.5L15 7" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
                <span class="font-mono text-[9px] tracking-widest uppercase text-emerald-500/70">04</span>
            </div>

            <p class="font-mono text-[10px] tracking-[0.2em] uppercase text-emerald-600">Siap Diambil</p>
            <p class="mt-2 text-[28px] leading-none font-semibold text-emerald-600 tracking-tight tabular-nums">
                {{ $stats['ready_requests'] ?? 0 }}
            </p>
            <div class="mt-4 pt-4 border-t border-emerald-500/15 flex items-center gap-1.5">
                <span class="w-1 h-1 rounded-full bg-emerald-500"></span>
                <span class="text-[10px] text-emerald-700/70 font-medium">Siap serah terima</span>
            </div>
        </div>

    </div>

    {{-- ═══════════════════════════════════════════════════════════
         CHARTS
         ═══════════════════════════════════════════════════════════ --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 sm:gap-5 mb-6">

        {{-- Trend chart --}}
        <div class="lg:col-span-2 rounded-2xl border border-black/[0.06] bg-white/85 backdrop-blur-xl
                    shadow-[0_1px_2px_rgba(0,0,0,0.03),0_8px_24px_rgba(0,0,0,0.04)] overflow-hidden">

            <div class="px-5 sm:px-6 py-4 border-b border-black/[0.06] flex items-center justify-between gap-4">
                <div class="flex items-center gap-2.5">
                    <span class="w-1.5 h-1.5 rounded-full bg-accent"></span>
                    <span class="font-mono text-[10px] tracking-[0.2em] uppercase text-ink-400">Tren · 7 Hari Terakhir</span>
                </div>
                <span class="font-mono text-[9px] tracking-widest uppercase text-ink-300">Area</span>
            </div>

            <div class="p-5 sm:p-6 pt-2 sm:pt-3">
                <h3 class="text-[14px] font-semibold text-ink-900 tracking-tight mb-4">
                    Tren Pengajuan Layanan
                </h3>
                <div id="trendChart" class="w-full h-[260px]"></div>
            </div>
        </div>

        {{-- Donut chart --}}
        <div class="rounded-2xl border border-black/[0.06] bg-white/85 backdrop-blur-xl
                    shadow-[0_1px_2px_rgba(0,0,0,0.03),0_8px_24px_rgba(0,0,0,0.04)] overflow-hidden">

            <div class="px-5 sm:px-6 py-4 border-b border-black/[0.06] flex items-center justify-between gap-4">
                <div class="flex items-center gap-2.5">
                    <span class="w-1.5 h-1.5 rounded-full bg-accent"></span>
                    <span class="font-mono text-[10px] tracking-[0.2em] uppercase text-ink-400">Distribusi</span>
                </div>
                <span class="font-mono text-[9px] tracking-widest uppercase text-ink-300">Donut</span>
            </div>

            <div class="p-5 sm:p-6 pt-2 sm:pt-3">
                <h3 class="text-[14px] font-semibold text-ink-900 tracking-tight mb-4">
                    Distribusi Status
                </h3>
                <div id="statusDonutChart" class="w-full"></div>
            </div>
        </div>

    </div>

    {{-- ═══════════════════════════════════════════════════════════
         RECENT REQUESTS TABLE
         ═══════════════════════════════════════════════════════════ --}}
    <div class="rounded-2xl border border-black/[0.06] bg-white overflow-hidden
                shadow-[0_1px_2px_rgba(0,0,0,0.03),0_8px_24px_rgba(0,0,0,0.04)]">

        {{-- Panel header --}}
        <div class="px-5 sm:px-6 py-4 border-b border-black/[0.06] flex items-center justify-between gap-4">
            <div class="flex items-center gap-2.5">
                <span class="w-1.5 h-1.5 rounded-full bg-accent"></span>
                <span class="font-mono text-[10px] tracking-[0.2em] uppercase text-ink-400">Pengajuan Terbaru</span>
            </div>

            <a href="{{ route('admin.service-requests.index') }}"
               class="group inline-flex items-center gap-1.5 h-8 pl-3 pr-2.5 rounded-lg
                      text-[11px] font-medium text-ink-700
                      hover:bg-ink-900 hover:text-white
                      transition-all duration-200">
                <span>Lihat Semua</span>
                <svg class="w-3 h-3 opacity-60 group-hover:opacity-100 group-hover:translate-x-0.5 transition-transform duration-200"
                     viewBox="0 0 12 12" fill="none" stroke="currentColor" stroke-width="1.75">
                    <path d="M4 3l3 3-3 3" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </a>
        </div>

        {{-- Table --}}
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-neutral-50/50 border-b border-black/[0.06]">
                    <tr>
                        <th class="px-5 sm:px-6 py-3 font-mono text-[10px] font-medium text-ink-400 uppercase tracking-wider whitespace-nowrap">No. Pengajuan</th>
                        <th class="px-5 sm:px-6 py-3 font-mono text-[10px] font-medium text-ink-400 uppercase tracking-wider whitespace-nowrap">Siswa</th>
                        <th class="px-5 sm:px-6 py-3 font-mono text-[10px] font-medium text-ink-400 uppercase tracking-wider whitespace-nowrap">Layanan</th>
                        <th class="px-5 sm:px-6 py-3 font-mono text-[10px] font-medium text-ink-400 uppercase tracking-wider whitespace-nowrap">Status</th>
                        <th class="px-5 sm:px-6 py-3 font-mono text-[10px] font-medium text-ink-400 uppercase tracking-wider whitespace-nowrap">Tanggal</th>
                        <th class="px-5 sm:px-6 py-3 font-mono text-[10px] font-medium text-ink-400 uppercase tracking-wider whitespace-nowrap text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-black/[0.05]">
                    @forelse($recentRequests as $requestItem)
                        <tr class="group hover:bg-neutral-50/60 transition-colors duration-150">

                            {{-- No. Pengajuan --}}
                            <td class="px-5 sm:px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center gap-2.5">
                                    <span class="w-1.5 h-1.5 rounded-full bg-neutral-300 group-hover:bg-accent transition-colors duration-300 shrink-0"></span>
                                    <span class="font-mono text-[12px] font-medium text-ink-900 tabular-nums">
                                        {{ $requestItem->request_number }}
                                    </span>
                                </div>
                            </td>

                            {{-- Siswa --}}
                            <td class="px-5 sm:px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center gap-2.5">
                                    <div class="w-7 h-7 rounded-full bg-neutral-100 border border-black/[0.06]
                                                flex items-center justify-center shrink-0">
                                        <span class="text-[10px] font-semibold text-ink-600 uppercase">
                                            {{ mb_substr($requestItem->student->user->name ?? 'S', 0, 1) }}
                                        </span>
                                    </div>
                                    <span class="text-[13px] font-medium text-ink-900">
                                        {{ $requestItem->student->user->name ?? '-' }}
                                    </span>
                                </div>
                            </td>

                            {{-- Layanan --}}
                            <td class="px-5 sm:px-6 py-4 whitespace-nowrap">
                                <span class="text-[12.5px] font-medium text-[#0055CC]">
                                    {{ $requestItem->serviceType->name ?? '-' }}
                                </span>
                            </td>

                            {{-- Status --}}
                            <td class="px-5 sm:px-6 py-4">
                                <x-status-badge :status="$requestItem->status" />
                            </td>

                            {{-- Tanggal --}}
                            <td class="px-5 sm:px-6 py-4 whitespace-nowrap">
                                <div class="leading-tight">
                                    <p class="font-mono text-[11px] text-ink-700 tabular-nums">
                                        {{ $requestItem->created_at->format('d/m/Y') }}
                                    </p>
                                    <p class="font-mono text-[10px] text-ink-400 tabular-nums mt-0.5">
                                        {{ $requestItem->created_at->format('H:i') }}
                                    </p>
                                </div>
                            </td>

                            {{-- Aksi --}}
                            <td class="px-5 sm:px-6 py-4 text-right whitespace-nowrap">
                                <a href="{{ route('admin.service-requests.show', $requestItem) }}"
                                   class="group/btn inline-flex items-center gap-1.5 h-8 pl-3 pr-2.5 rounded-lg
                                          bg-white border border-black/[0.08] text-ink-700
                                          hover:bg-ink-900 hover:border-ink-900 hover:text-white
                                          text-[11px] font-medium
                                          transition-all duration-200">
                                    <span>Detail</span>
                                    <svg class="w-3 h-3 opacity-60 group-hover/btn:opacity-100 group-hover/btn:translate-x-0.5 transition-transform duration-200"
                                         viewBox="0 0 12 12" fill="none" stroke="currentColor" stroke-width="1.75">
                                        <path d="M4 3l3 3-3 3" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-5 sm:px-6 py-16">
                                <div class="max-w-sm mx-auto text-center">

                                    <div class="w-14 h-14 mx-auto rounded-2xl bg-neutral-50 border border-black/[0.06]
                                                flex items-center justify-center">
                                        <svg class="w-6 h-6 text-ink-300" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                            <path d="M5 3h9l5 5v13a1 1 0 01-1 1H5a1 1 0 01-1-1V4a1 1 0 011-1z" stroke-linejoin="round"/>
                                            <path d="M14 3v5h5" stroke-linejoin="round"/>
                                            <path d="M8 13h8M8 17h5" stroke-linecap="round"/>
                                        </svg>
                                    </div>

                                    <p class="mt-5 text-[14px] font-medium text-ink-900">
                                        Belum ada pengajuan
                                    </p>
                                    <p class="mt-2 text-[12px] text-ink-500 leading-relaxed">
                                        Pengajuan dari siswa akan muncul otomatis di sini setelah mereka submit formulir.
                                    </p>

                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>

    {{-- ═══════════════════════════════════════════════════════════
         FOOTER NOTE
         ═══════════════════════════════════════════════════════════ --}}
    <div class="mt-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 px-1">
        <span class="font-mono text-[10px] tracking-[0.2em] uppercase text-ink-400">
            SIDAKA · Dashboard v2.0
        </span>
        <span class="font-mono text-[10px] tracking-[0.2em] uppercase text-ink-400 tabular-nums">
            {{ now()->format('d/m/Y H:i') }} WIB
        </span>
    </div>

    {{-- ═══════════════════════════════════════════════════════════
         APEXCHARTS INIT
         ═══════════════════════════════════════════════════════════ --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {

            const fontFamily = 'Inter, ui-sans-serif, system-ui, sans-serif';
            const inkColor = '#0A0A0A';
            const mutedColor = '#8E8E93';
            const gridColor = 'rgba(0,0,0,0.06)';

            // ─── Trend Area Chart ───
            const trendOptions = {
                chart: {
                    type: 'area',
                    height: 260,
                    toolbar: { show: false },
                    fontFamily: fontFamily,
                    sparkline: { enabled: false },
                    animations: {
                        enabled: true,
                        easing: 'easeinout',
                        speed: 800
                    }
                },
                series: [{
                    name: 'Pengajuan',
                    data: @json($trendData ?? [])
                }],
                xaxis: {
                    categories: @json($trendLabels ?? []),
                    labels: {
                        style: {
                            colors: mutedColor,
                            fontSize: '10px',
                            fontFamily: fontFamily,
                            fontWeight: 500
                        }
                    },
                    axisBorder: { show: false },
                    axisTicks: { show: false }
                },
                yaxis: {
                    labels: {
                        style: {
                            colors: mutedColor,
                            fontSize: '10px',
                            fontFamily: fontFamily,
                            fontWeight: 500
                        }
                    }
                },
                colors: ['#0A84FF'],
                fill: {
                    type: 'gradient',
                    gradient: {
                        shadeIntensity: 1,
                        opacityFrom: 0.25,
                        opacityTo: 0.0,
                        stops: [0, 90, 100]
                    }
                },
                dataLabels: { enabled: false },
                stroke: {
                    curve: 'smooth',
                    width: 2.5,
                    colors: ['#0A84FF']
                },
                grid: {
                    borderColor: gridColor,
                    strokeDashArray: 3,
                    xaxis: { lines: { show: false } },
                    yaxis: { lines: { show: true } },
                    padding: { top: 0, right: 8, bottom: 0, left: 8 }
                },
                markers: {
                    size: 0,
                    hover: { size: 5, sizeOffset: 2 }
                },
                tooltip: {
                    theme: 'light',
                    style: { fontFamily: fontFamily, fontSize: '12px' },
                    x: { show: true },
                    marker: { show: false }
                }
            };
            new ApexCharts(document.querySelector("#trendChart"), trendOptions).render();

            // ─── Status Donut Chart ───
            const donutOptions = {
                chart: {
                    type: 'donut',
                    height: 260,
                    fontFamily: fontFamily,
                    animations: {
                        enabled: true,
                        easing: 'easeinout',
                        speed: 800
                    }
                },
                series: @json($statusChartData['series'] ?? []),
                labels: @json($statusChartData['labels'] ?? []),
                colors: ['#F5A524', '#0A84FF', '#6366F1', '#0FB57A', '#94A3B8', '#A855F7', '#14B8A6', '#E5484D'],
                legend: {
                    position: 'bottom',
                    fontSize: '11px',
                    fontFamily: fontFamily,
                    fontWeight: 500,
                    markers: {
                        width: 8,
                        height: 8,
                        radius: 4
                    },
                    itemMargin: {
                        horizontal: 8,
                        vertical: 4
                    }
                },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    width: 2,
                    colors: ['#FFFFFF']
                },
                plotOptions: {
                    pie: {
                        donut: {
                            size: '68%',
                            labels: {
                                show: true,
                                name: {
                                    fontFamily: fontFamily,
                                    fontSize: '11px',
                                    color: mutedColor,
                                    offsetY: 4
                                },
                                value: {
                                    fontFamily: fontFamily,
                                    fontSize: '20px',
                                    fontWeight: 600,
                                    color: inkColor,
                                    offsetY: -4
                                },
                                total: {
                                    show: true,
                                    label: '',
                                    fontFamily: fontFamily,
                                    fontSize: '11px',
                                    color: mutedColor,
                                    formatter: function (w) {
                                        return w.globals.seriesTotals.reduce((a, b) => a + b, 0);
                                    }
                                }
                            }
                        }
                    }
                },
                tooltip: {
                    theme: 'light',
                    style: { fontFamily: fontFamily, fontSize: '12px' }
                }
            };
            new ApexCharts(document.querySelector("#statusDonutChart"), donutOptions).render();
        });
    </script>

</x-layouts.app>