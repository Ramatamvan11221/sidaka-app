<x-layouts.app title="Kelola Dokumen - Guru SIDAKA">
    <x-slot name="header">Kelola Dokumen Akademik Siswa</x-slot>

    {{-- Alpine wrapper — state sama persis --}}
    <div x-data="{ selected: [], allSelected: false, toggleAll() { this.selected = this.allSelected ? @json($documents->pluck('id')) : []; } }">

        {{-- ═══════════════════════════════════════════════════════════
             INTRO STRIP + ACTION BAR
             ═══════════════════════════════════════════════════════════ --}}
        <div class="mb-6 sm:mb-8 flex flex-col lg:flex-row lg:items-end lg:justify-between gap-4">
            <div>
                <div class="flex items-center gap-2 mb-2.5">
                    <span class="w-1.5 h-1.5 rounded-full bg-accent"></span>
                    <span class="font-mono text-[10px] tracking-[0.2em] uppercase text-ink-400">Kelola · Dokumen</span>
                </div>
                <h2 class="text-[20px] sm:text-[24px] leading-tight tracking-[-0.02em] font-semibold text-ink-900 text-balance">
                    Dokumen akademik siswa.
                </h2>
                <p class="mt-2 max-w-lg text-[12px] text-ink-500 leading-relaxed">
                    Cari, pratinjau, edit, dan verifikasi dokumen. Pilih beberapa dokumen sekaligus untuk verifikasi massal.
                </p>
            </div>

            <div class="flex flex-col sm:flex-row gap-2 shrink-0">
                {{-- Search --}}
                <form action="{{ route('teacher.documents.index') }}" method="GET"
                      class="flex items-center gap-2">
                    <div class="relative flex-1 sm:w-64">
                        <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-ink-400">
                            <svg class="w-4 h-4" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.75">
                                <circle cx="9" cy="9" r="6"/>
                                <path d="M14 14l4 4" stroke-linecap="round"/>
                            </svg>
                        </span>
                        <input type="text" name="search" value="{{ request('search') }}"
                               placeholder="Cari judul / nama siswa..."
                               class="w-full h-11 pl-10 pr-4 rounded-xl bg-white border border-black/[0.08]
                                      text-[13px] text-ink-900 placeholder:text-ink-400
                                      transition outline-none
                                      focus:border-accent/50 focus:ring-4 focus:ring-accent/10">
                    </div>
                    <button type="submit"
                            class="shrink-0 inline-flex items-center justify-center h-11 px-4 rounded-xl
                                   bg-white border border-black/[0.08] text-ink-700
                                   hover:bg-neutral-50 hover:border-black/[0.14]
                                   text-[12px] font-medium
                                   transition-all duration-200 active:scale-[0.98]">
                        <svg class="w-3.5 h-3.5" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.75">
                            <circle cx="9" cy="9" r="6"/>
                            <path d="M14 14l4 4" stroke-linecap="round"/>
                        </svg>
                    </button>
                </form>

                {{-- Upload button --}}
                <a href="{{ route('teacher.documents.create') }}"
                   class="inline-flex items-center justify-center gap-2 h-11 px-5 rounded-xl
                          bg-ink-900 hover:bg-ink-700 text-white text-[12px] font-medium
                          transition-all duration-200 active:scale-[0.98]">
                    <svg class="w-3.5 h-3.5" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M10 4v12M4 10h12" stroke-linecap="round"/>
                    </svg>
                    <span>Unggah Dokumen Baru</span>
                </a>
            </div>
        </div>

        {{-- ═══════════════════════════════════════════════════════════
             FLOATING BATCH ACTION BAR (conditional)
             ═══════════════════════════════════════════════════════════ --}}
        <div x-show="selected.length > 0" x-cloak
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 -translate-y-2"
             x-transition:enter-end="opacity-100 translate-y-0"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 translate-y-0"
             x-transition:leave-end="opacity-0 -translate-y-2"
             class="mb-4 relative overflow-hidden rounded-2xl
                    bg-ink-900
                    shadow-[0_4px_12px_rgba(0,0,0,0.15),0_16px_40px_rgba(0,0,0,0.2)]">

            {{-- Dot pattern --}}
            <div class="absolute inset-0 opacity-[0.06]"
                 style="background-image: radial-gradient(circle, white 1px, transparent 1px); background-size: 18px 18px;"
                 aria-hidden="true"></div>

            {{-- Accent glow --}}
            <div class="absolute -top-16 -right-16 w-40 h-40 rounded-full bg-accent/30 blur-3xl pointer-events-none"
                 aria-hidden="true"></div>

            <div class="relative flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 px-5 sm:px-6 py-4">

                {{-- Left: count --}}
                <div class="flex items-center gap-3">
                    <div class="shrink-0 w-9 h-9 rounded-xl bg-white/[0.08] border border-white/[0.10]
                                flex items-center justify-center">
                        <svg class="w-4 h-4 text-white" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.6">
                            <path d="M5 10.5l3.5 3.5L15 7" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>
                    <div>
                        <p class="font-mono text-[9px] tracking-[0.2em] uppercase text-white/50">Batch Action</p>
                        <p class="mt-0.5 text-[13px] text-white">
                            <strong class="font-semibold tabular-nums" x-text="selected.length"></strong>
                            <span class="text-white/60">dokumen terpilih</span>
                        </p>
                    </div>
                </div>

                {{-- Right: mass-verify form --}}
                <form action="{{ route('teacher.documents.mass-verify') }}" method="POST"
                      class="flex items-center gap-2">
                    @csrf
                    <template x-for="id in selected">
                        <input type="hidden" name="document_ids[]" :value="id">
                    </template>
                    <input type="hidden" name="status" value="verified">
                    <button type="submit"
                            class="inline-flex items-center justify-center gap-2 h-10 px-5 rounded-xl
                                   bg-emerald-500 hover:bg-emerald-600 text-white
                                   text-[12px] font-medium
                                   transition-all duration-200 active:scale-[0.98]
                                   shadow-[0_2px_8px_rgba(15,181,122,0.25)]">
                        <svg class="w-3.5 h-3.5" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M5 10.5l3.5 3.5L15 7" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        <span>Verifikasi Terpilih</span>
                    </button>
                </form>

            </div>
        </div>

        {{-- ═══════════════════════════════════════════════════════════
             TABLE PANEL
             ═══════════════════════════════════════════════════════════ --}}
        <div class="rounded-2xl border border-black/[0.06] bg-white overflow-hidden
                    shadow-[0_1px_2px_rgba(0,0,0,0.03),0_8px_24px_rgba(0,0,0,0.04)]">

            {{-- Panel header --}}
            <div class="px-5 sm:px-6 py-4 border-b border-black/[0.06] flex items-center justify-between gap-4">
                <div class="flex items-center gap-2.5">
                    <span class="w-1.5 h-1.5 rounded-full bg-accent"></span>
                    <span class="font-mono text-[10px] tracking-[0.2em] uppercase text-ink-400">Daftar Dokumen</span>
                </div>
                <span class="font-mono text-[10px] tracking-wider uppercase text-ink-400 tabular-nums">
                    {{ $documents->total() }} dokumen
                </span>
            </div>

            {{-- Table --}}
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead class="bg-neutral-50/50 border-b border-black/[0.06]">
                        <tr>
                            {{-- Select all --}}
                            <th class="pl-5 sm:pl-6 pr-3 py-3 w-10">
                                <input type="checkbox"
                                       x-model="allSelected" @change="toggleAll()"
                                       class="w-4 h-4 rounded border-black/20 cursor-pointer
                                              accent-[#0A0A0A]
                                              focus:ring-2 focus:ring-accent/30 focus:ring-offset-0">
                            </th>
                            <th class="px-3 py-3 font-mono text-[10px] font-medium text-ink-400 uppercase tracking-wider whitespace-nowrap">Judul Dokumen</th>
                            <th class="px-5 sm:px-6 py-3 font-mono text-[10px] font-medium text-ink-400 uppercase tracking-wider whitespace-nowrap">Siswa</th>
                            <th class="px-5 sm:px-6 py-3 font-mono text-[10px] font-medium text-ink-400 uppercase tracking-wider whitespace-nowrap">Kelas</th>
                            <th class="px-5 sm:px-6 py-3 font-mono text-[10px] font-medium text-ink-400 uppercase tracking-wider whitespace-nowrap">Jenis</th>
                            <th class="px-5 sm:px-6 py-3 font-mono text-[10px] font-medium text-ink-400 uppercase tracking-wider whitespace-nowrap">Status</th>
                            <th class="px-5 sm:px-6 py-3 font-mono text-[10px] font-medium text-ink-400 uppercase tracking-wider whitespace-nowrap text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-black/[0.05]">
                        @forelse($documents as $doc)
                            <tr class="group hover:bg-neutral-50/60 transition-colors duration-150">

                                {{-- Checkbox --}}
                                <td class="pl-5 sm:pl-6 pr-3 py-4 align-middle">
                                    <input type="checkbox" value="{{ $doc->id }}" x-model="selected"
                                           class="w-4 h-4 rounded border-black/20 cursor-pointer
                                                  accent-[#0A84FF]
                                                  focus:ring-2 focus:ring-accent/30 focus:ring-offset-0">
                                </td>

                                {{-- Judul Dokumen --}}
                                <td class="px-3 py-4">
                                    <div class="flex items-center gap-3 min-w-0">
                                        <div class="shrink-0 w-9 h-9 rounded-xl bg-neutral-100 border border-black/[0.06]
                                                    flex items-center justify-center
                                                    group-hover:bg-ink-900 group-hover:border-ink-900
                                                    transition-colors duration-300">
                                            <svg class="w-4 h-4 text-ink-500 group-hover:text-white transition-colors duration-300"
                                                 viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.6">
                                                <path d="M5 2.5h7l3.5 3.5v11a1 1 0 01-1 1h-9.5a1 1 0 01-1-1V3.5a1 1 0 011-1z" stroke-linejoin="round"/>
                                                <path d="M12 2.5v4h4" stroke-linejoin="round"/>
                                                <path d="M7 11h6M7 14h4" stroke-linecap="round"/>
                                            </svg>
                                        </div>
                                        <p class="text-[13px] font-medium text-ink-900 leading-snug max-w-[240px] truncate">
                                            {{ $doc->title }}
                                        </p>
                                    </div>
                                </td>

                                {{-- Siswa --}}
                                <td class="px-5 sm:px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center gap-2.5">
                                        <div class="w-7 h-7 rounded-full bg-neutral-100 border border-black/[0.06]
                                                    flex items-center justify-center shrink-0">
                                            <span class="text-[10px] font-semibold text-ink-600 uppercase">
                                                {{ mb_substr($doc->student->user->name ?? 'S', 0, 1) }}
                                            </span>
                                        </div>
                                        <span class="text-[13px] font-medium text-ink-900">
                                            {{ $doc->student->user->name }}
                                        </span>
                                    </div>
                                </td>

                                {{-- Kelas --}}
                                <td class="px-5 sm:px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center h-6 px-2 rounded-md
                                                 bg-neutral-100 border border-black/[0.05]
                                                 font-mono text-[10px] text-ink-700 tracking-wider">
                                        {{ $doc->student->classInfo->name }}
                                    </span>
                                </td>

                                {{-- Jenis --}}
                                <td class="px-5 sm:px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center h-6 px-2 rounded-md
                                                 bg-[#EAF3FF] border border-[#0A84FF]/15
                                                 font-mono text-[10px] text-[#0055CC] tracking-wider">
                                        {{ $doc->documentType->name }}
                                    </span>
                                </td>

                                {{-- Status --}}
                                <td class="px-5 sm:px-6 py-4">
                                    <x-status-badge :status="$doc->verification_status" />
                                </td>

                                {{-- Aksi --}}
                                <td class="px-5 sm:px-6 py-4 text-right whitespace-nowrap">
                                    <div class="inline-flex items-center gap-1">

                                        {{-- Pratinjau --}}
                                        <a href="{{ route('documents.stream', $doc) }}" target="_blank"
                                           class="inline-flex items-center justify-center w-8 h-8 rounded-lg
                                                  text-ink-500 hover:text-ink-900 hover:bg-black/[0.04]
                                                  transition-colors"
                                           title="Pratinjau">
                                            <svg class="w-3.5 h-3.5" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.75">
                                                <path d="M1.5 10s3-6 8.5-6 8.5 6 8.5 6-3 6-8.5 6-8.5-6-8.5-6z" stroke-linejoin="round"/>
                                                <circle cx="10" cy="10" r="2.5"/>
                                            </svg>
                                        </a>

                                        {{-- Edit --}}
                                        <a href="{{ route('teacher.documents.edit', $doc) }}"
                                           class="inline-flex items-center justify-center w-8 h-8 rounded-lg
                                                  text-ink-500 hover:text-amber-600 hover:bg-amber-500/[0.08]
                                                  transition-colors"
                                           title="Edit">
                                            <svg class="w-3.5 h-3.5" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.75">
                                                <path d="M13.5 3.5l3 3L7 16H4v-3l9.5-9.5z" stroke-linejoin="round"/>
                                            </svg>
                                        </a>

                                        {{-- Hapus --}}
                                        <form action="{{ route('teacher.documents.destroy', $doc) }}" method="POST" class="inline"
                                              onsubmit="return confirm('Yakin ingin menghapus dokumen ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="inline-flex items-center justify-center w-8 h-8 rounded-lg
                                                           text-ink-500 hover:text-rose-600 hover:bg-rose-500/[0.08]
                                                           transition-colors"
                                                    title="Hapus">
                                                <svg class="w-3.5 h-3.5" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.6">
                                                    <path d="M3 5h14M8 5V3.5a1 1 0 011-1h2a1 1 0 011 1V5M5 5l1 12a1 1 0 001 1h6a1 1 0 001-1l1-12" stroke-linecap="round" stroke-linejoin="round"/>
                                                </svg>
                                            </button>
                                        </form>

                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-5 sm:px-6 py-16">
                                    <div class="max-w-sm mx-auto text-center">

                                        <div class="w-16 h-16 mx-auto rounded-2xl bg-neutral-50 border border-black/[0.06]
                                                    flex items-center justify-center">
                                            <svg class="w-7 h-7 text-ink-300" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                                <path d="M5 3h9l5 5v13a1 1 0 01-1 1H5a1 1 0 01-1-1V4a1 1 0 011-1z" stroke-linejoin="round"/>
                                                <path d="M14 3v5h5" stroke-linejoin="round"/>
                                                <path d="M8 13h8M8 17h5" stroke-linecap="round"/>
                                            </svg>
                                        </div>

                                        <p class="mt-5 text-[14px] font-medium text-ink-900">
                                            @if(request('search'))
                                                Tidak ada dokumen yang cocok
                                            @else
                                                Belum ada dokumen
                                            @endif
                                        </p>
                                        <p class="mt-2 text-[12px] text-ink-500 leading-relaxed">
                                            @if(request('search'))
                                                Coba kata kunci lain, atau reset pencarian.
                                            @else
                                                Mulai dengan mengunggah dokumen akademik siswa pertama.
                                            @endif
                                        </p>

                                        @if(request('search'))
                                            <a href="{{ route('teacher.documents.index') }}"
                                               class="mt-5 inline-flex items-center gap-2 h-9 px-4 rounded-xl
                                                      bg-ink-900 hover:bg-ink-700 text-white
                                                      text-[11px] font-medium transition-all duration-200 active:scale-[0.98]">
                                                <svg class="w-3 h-3" viewBox="0 0 12 12" fill="none" stroke="currentColor" stroke-width="2">
                                                    <path d="M3 3l6 6M9 3l-6 6" stroke-linecap="round"/>
                                                </svg>
                                                <span>Reset Pencarian</span>
                                            </a>
                                        @else
                                            <a href="{{ route('teacher.documents.create') }}"
                                               class="mt-5 inline-flex items-center gap-2 h-9 px-4 rounded-xl
                                                      bg-ink-900 hover:bg-ink-700 text-white
                                                      text-[11px] font-medium transition-all duration-200 active:scale-[0.98]">
                                                <svg class="w-3 h-3" viewBox="0 0 12 12" fill="none" stroke="currentColor" stroke-width="2">
                                                    <path d="M6 2v8M2 6h8" stroke-linecap="round"/>
                                                </svg>
                                                <span>Unggah Dokumen Pertama</span>
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
            @if($documents->hasPages())
                <div class="px-5 sm:px-6 py-4 border-t border-black/[0.06] bg-neutral-50/30">
                    {{ $documents->links() }}
                </div>
            @endif

        </div>

        {{-- Footer note --}}
        <div class="mt-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 px-1">
            <span class="font-mono text-[10px] tracking-[0.2em] uppercase text-ink-400">
                SIDAKA · Kelola Dokumen v2.0
            </span>
            <span class="font-mono text-[10px] tracking-[0.2em] uppercase text-ink-400">
                Pilih beberapa dokumen untuk verifikasi massal
            </span>
        </div>

    </div>
</x-layouts.app>