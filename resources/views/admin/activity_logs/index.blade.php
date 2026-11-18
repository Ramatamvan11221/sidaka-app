<x-layouts.app title="Audit Trail Log - Admin SIDAKA">
    <x-slot name="header">Audit Trail & Log Aktivitas Sistem</x-slot>

    {{-- ═══════════════════════════════════════════════════════════
         FILTER PANEL
         ═══════════════════════════════════════════════════════════ --}}
    <div class="rounded-2xl border border-black/[0.06] bg-white/70 backdrop-blur-xl shadow-[0_1px_0_rgba(255,255,255,0.9)_inset,0_1px_2px_rgba(0,0,0,0.03),0_8px_24px_rgba(0,0,0,0.04)] p-4 sm:p-5 mb-6">

        {{-- Panel header kecil --}}
        <div class="flex items-center gap-2 mb-4">
            <span class="w-1.5 h-1.5 rounded-full bg-[#0A84FF]"></span>
            <span class="font-mono text-[10px] tracking-[0.2em] uppercase text-neutral-400">Filter Log</span>
        </div>

        <form action="{{ route('admin.activity-logs') }}" method="GET"
              class="flex flex-col sm:flex-row gap-3">

            {{-- Search input --}}
            <div class="relative flex-1">
                <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-neutral-400">
                    <svg class="w-4 h-4" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.75">
                        <circle cx="9" cy="9" r="6"/>
                        <path d="M14 14l4 4" stroke-linecap="round"/>
                    </svg>
                </span>
                <input type="text" name="search" value="{{ request('search') }}"
                       placeholder="Cari aktivitas / nama user / kata kunci..."
                       aria-label="Cari log aktivitas"
                       class="w-full h-11 pl-10 pr-4 rounded-xl bg-white border border-black/[0.08]
                              text-[13px] text-neutral-900 placeholder:text-neutral-400
                              transition outline-none
                              focus:border-[#0A84FF]/50 focus:ring-4 focus:ring-[#0A84FF]/10">
            </div>

            {{-- Actions --}}
            <div class="flex items-center gap-2">
                <button type="submit"
                        class="inline-flex items-center justify-center gap-2 h-11 px-5 rounded-xl
                               bg-neutral-900 hover:bg-neutral-700 text-white text-[12px] font-medium
                               transition-all duration-200 active:scale-[0.98]">
                    <svg class="w-3.5 h-3.5" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.75">
                        <circle cx="9" cy="9" r="6"/>
                        <path d="M14 14l4 4" stroke-linecap="round"/>
                    </svg>
                    <span>Cari Log</span>
                </button>

                <a href="{{ route('admin.activity-logs') }}"
                   class="inline-flex items-center justify-center gap-2 h-11 px-5 rounded-xl
                          bg-white border border-black/[0.08] text-neutral-600
                          hover:bg-neutral-50 hover:border-black/[0.14] text-[12px] font-medium
                          transition-all duration-200 active:scale-[0.98]">
                    <svg class="w-3.5 h-3.5" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.75">
                        <path d="M3 10a7 7 0 1 0 2-4.9M3 5v3h3" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <span>Reset</span>
                </a>
            </div>
        </form>

        {{-- Active filter indicator --}}
        @if(request('search'))
            <div class="mt-4 pt-4 border-t border-black/[0.06] flex flex-wrap items-center gap-2">
                <span class="font-mono text-[10px] tracking-wider uppercase text-neutral-400">Filter aktif:</span>
                <span class="inline-flex items-center gap-1.5 h-6 pl-2.5 pr-1.5 rounded-md
                             bg-[#EAF3FF] border border-[#0A84FF]/15
                             text-[11px] text-[#0055CC] font-medium">
                    <span class="font-mono">"{{ request('search') }}"</span>
                    <a href="{{ route('admin.activity-logs') }}"
                       class="w-4 h-4 rounded inline-flex items-center justify-center
                              hover:bg-[#0A84FF]/10 transition"
                       aria-label="Hapus filter">
                        <svg class="w-2.5 h-2.5" viewBox="0 0 12 12" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M3 3l6 6M9 3l-6 6" stroke-linecap="round"/>
                        </svg>
                    </a>
                </span>
            </div>
        @endif
    </div>

    {{-- ═══════════════════════════════════════════════════════════
         TABLE PANEL
         ═══════════════════════════════════════════════════════════ --}}
    <div class="rounded-2xl border border-black/[0.06] bg-white overflow-hidden shadow-[0_1px_2px_rgba(0,0,0,0.03),0_8px_24px_rgba(0,0,0,0.04)]">

        {{-- Panel header --}}
        <div class="px-5 sm:px-6 py-4 border-b border-black/[0.06] flex items-center justify-between gap-4">
            <div class="flex items-center gap-2.5">
                <span class="w-1.5 h-1.5 rounded-full bg-[#0A84FF]"></span>
                <span class="font-mono text-[10px] tracking-[0.2em] uppercase text-neutral-400">Log Aktivitas</span>
            </div>
            <span class="font-mono text-[10px] tracking-wider uppercase text-neutral-400 tabular-nums">
                {{ $logs->total() }} entri
            </span>
        </div>

        {{-- Table --}}
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-neutral-50/50 border-b border-black/[0.06]">
                    <tr>
                        <th class="px-5 sm:px-6 py-3 font-mono text-[10px] font-medium text-neutral-400 uppercase tracking-wider whitespace-nowrap">Waktu</th>
                        <th class="px-5 sm:px-6 py-3 font-mono text-[10px] font-medium text-neutral-400 uppercase tracking-wider whitespace-nowrap">Pengguna</th>
                        <th class="px-5 sm:px-6 py-3 font-mono text-[10px] font-medium text-neutral-400 uppercase tracking-wider whitespace-nowrap">Action</th>
                        <th class="px-5 sm:px-6 py-3 font-mono text-[10px] font-medium text-neutral-400 uppercase tracking-wider">Deskripsi</th>
                        <th class="px-5 sm:px-6 py-3 font-mono text-[10px] font-medium text-neutral-400 uppercase tracking-wider whitespace-nowrap">IP Address</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-black/[0.05]">
                    @forelse($logs as $log)
                        <tr class="group hover:bg-neutral-50/60 transition-colors duration-150">

                            {{-- Waktu --}}
                            <td class="px-5 sm:px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center gap-2.5">
                                    {{-- Timeline dot --}}
                                    <span class="w-1.5 h-1.5 rounded-full bg-neutral-300 group-hover:bg-[#0A84FF] transition-colors duration-300 shrink-0"></span>
                                    <div class="leading-tight">
                                        <p class="font-mono text-[11px] text-neutral-700 tabular-nums">
                                            {{ $log->created_at->format('d/m/Y') }}
                                        </p>
                                        <p class="font-mono text-[10px] text-neutral-400 tabular-nums mt-0.5">
                                            {{ $log->created_at->format('H:i:s') }}
                                        </p>
                                    </div>
                                </div>
                            </td>

                            {{-- Pengguna --}}
                            <td class="px-5 sm:px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center gap-2.5">
                                    <div class="w-7 h-7 rounded-full bg-neutral-100 border border-black/[0.06] flex items-center justify-center shrink-0">
                                        <span class="text-[10px] font-semibold text-neutral-600 uppercase">
                                            {{ mb_substr($log->user->name ?? 'S', 0, 1) }}
                                        </span>
                                    </div>
                                    <span class="text-[13px] font-medium text-neutral-900">
                                        {{ $log->user->name ?? 'Sistem / Tamu' }}
                                    </span>
                                </div>
                            </td>

                            {{-- Action --}}
                            <td class="px-5 sm:px-6 py-4">
                                <span class="inline-flex items-center h-6 px-2.5 rounded-md
                                             bg-neutral-900 text-white
                                             font-mono text-[10px] font-medium uppercase tracking-wider
                                             whitespace-nowrap">
                                    {{ $log->action }}
                                </span>
                            </td>

                            {{-- Deskripsi --}}
                            <td class="px-5 sm:px-6 py-4 text-[12.5px] text-neutral-600 leading-relaxed min-w-[240px]">
                                {{ $log->description }}
                            </td>

                            {{-- IP --}}
                            <td class="px-5 sm:px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center gap-1.5 font-mono text-[11px] text-neutral-400 tabular-nums">
                                    <svg class="w-3 h-3 opacity-60" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.5">
                                        <circle cx="8" cy="8" r="6"/>
                                        <path d="M8 2c2 2 2 10 0 12M8 2c-2 2-2 10 0 12M2.5 8h11"/>
                                    </svg>
                                    {{ $log->ip_address ?? '127.0.0.1' }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-5 sm:px-6 py-16">
                                {{-- Empty state --}}
                                <div class="max-w-sm mx-auto text-center">

                                    {{-- Icon --}}
                                    <div class="w-14 h-14 mx-auto rounded-2xl bg-neutral-50 border border-black/[0.06]
                                                flex items-center justify-center">
                                        <svg class="w-6 h-6 text-neutral-300" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                            <path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2"/>
                                            <rect x="9" y="3" width="6" height="4" rx="1"/>
                                            <path d="M9 12h6M9 16h4" stroke-linecap="round"/>
                                        </svg>
                                    </div>

                                    {{-- Title --}}
                                    <p class="mt-5 text-[14px] font-medium text-neutral-900">
                                        @if(request('search'))
                                            Nggak ada log yang cocok
                                        @else
                                            Belum ada catatan aktivitas
                                        @endif
                                    </p>

                                    {{-- Description --}}
                                    <p class="mt-2 text-[12px] text-neutral-500 leading-relaxed">
                                        @if(request('search'))
                                            Coba kata kunci lain, atau hapus filter untuk melihat semua log.
                                        @else
                                            Setiap aksi pengguna di sistem SIDAKA akan tercatat di sini secara otomatis.
                                        @endif
                                    </p>

                                    {{-- Action --}}
                                    @if(request('search'))
                                        <a href="{{ route('admin.activity-logs') }}"
                                           class="mt-5 inline-flex items-center gap-2 h-9 px-4 rounded-xl
                                                  bg-neutral-900 hover:bg-neutral-700 text-white
                                                  text-[11px] font-medium transition-all duration-200 active:scale-[0.98]">
                                            <svg class="w-3 h-3" viewBox="0 0 12 12" fill="none" stroke="currentColor" stroke-width="2">
                                                <path d="M3 3l6 6M9 3l-6 6" stroke-linecap="round"/>
                                            </svg>
                                            <span>Hapus Filter</span>
                                        </a>
                                    @endif

                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($logs->hasPages())
            <div class="px-5 sm:px-6 py-4 border-t border-black/[0.06] bg-neutral-50/30">
                {{ $logs->links() }}
            </div>
        @endif
    </div>

    {{-- Footer note --}}
    <div class="mt-6 flex items-center justify-between gap-4 px-1">
        <span class="font-mono text-[10px] tracking-[0.2em] uppercase text-neutral-400">
            © {{ date('Y') }} · SMK Negeri 5 Surakarta
        </span>
        <span class="font-mono text-[10px] tracking-[0.2em] uppercase text-neutral-400">
            Audit Trail v2.0
        </span>
    </div>

</x-layouts.app>