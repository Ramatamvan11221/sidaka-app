<x-layouts.app title="Kelola Dokumen - Admin SIDAKA">
    <x-slot name="header">Kelola Dokumen Akademik Siswa</x-slot>

    {{-- INTRO & TOMBOL TAMBAH --}}
    <div class="mb-6 flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 mb-2">
                <span class="w-1.5 h-1.5 rounded-full bg-accent"></span>
                <span class="font-mono text-[10px] tracking-[0.2em] uppercase text-ink-400">Master Data · Dokumen</span>
            </div>
            <h2 class="text-[20px] font-semibold text-ink-900">
                Arsip &amp; Dokumen Akademik Siswa.
            </h2>
            <p class="text-[12px] text-ink-500 mt-1">
                Admin &amp; Kurikulum dapat mengunggah semua jenis berkas (Ijazah, SKHUN, Transkrip, Raport, Sertifikat).
            </p>
        </div>

        <a href="{{ route('admin.documents.create') }}"
           class="inline-flex items-center justify-center gap-2 h-11 px-5 rounded-xl bg-ink-900 hover:bg-ink-700 text-white text-[12px] font-medium transition">
            <svg class="w-3.5 h-3.5" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M10 4v12M4 10h12" stroke-linecap="round"/>
            </svg>
            <span>Unggah Dokumen Baru</span>
        </a>
    </div>

    {{-- FILTER PANEL --}}
    <div class="p-4 bg-white rounded-2xl border border-black/[0.06] mb-5 shadow-sm">
        <form action="{{ route('admin.documents.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-12 gap-3">
            <div class="sm:col-span-6">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama siswa atau judul dokumen..."
                       class="w-full h-10 px-3.5 rounded-xl border border-black/[0.08] text-xs">
            </div>

            <div class="sm:col-span-4">
                <select name="document_type_id" class="w-full h-10 px-3 rounded-xl border border-black/[0.08] text-xs">
                    <option value="">Semua Tipe Dokumen</option>
                    @foreach($documentTypes as $type)
                        <option value="{{ $type->id }}" {{ request('document_type_id') == $type->id ? 'selected' : '' }}>
                            {{ $type->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="sm:col-span-2">
                <button type="submit" class="w-full h-10 bg-ink-900 text-white rounded-xl text-xs font-medium">
                    Filter
                </button>
            </div>
        </form>
    </div>

    {{-- TABEL DOKUMEN --}}
    <div class="rounded-2xl border border-black/[0.06] bg-white overflow-hidden shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-neutral-50 border-b border-black/[0.06]">
                    <tr>
                        <th class="px-5 py-3 font-mono text-[10px] uppercase text-ink-400">Judul Dokumen</th>
                        <th class="px-5 py-3 font-mono text-[10px] uppercase text-ink-400">Nama Siswa</th>
                        <th class="px-5 py-3 font-mono text-[10px] uppercase text-ink-400">Tipe</th>
                        <th class="px-5 py-3 font-mono text-[10px] uppercase text-ink-400">Status</th>
                        <th class="px-5 py-3 font-mono text-[10px] uppercase text-ink-400 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-black/[0.05]">
                    @forelse($documents as $doc)
                        <tr class="hover:bg-neutral-50/60">
                            <td class="px-5 py-4 font-medium text-ink-900 text-xs">{{ $doc->title }}</td>
                            <td class="px-5 py-4 text-xs">{{ $doc->student->user->name ?? '-' }} ({{ $doc->student->classInfo->name ?? '-' }})</td>
                            <td class="px-5 py-4 text-xs">
                                <span class="px-2 py-1 bg-blue-50 text-blue-700 rounded-md font-mono text-[10px]">
                                    {{ $doc->documentType->name ?? '-' }}
                                </span>
                            </td>
                            <td class="px-5 py-4 text-xs">
                                <span class="px-2.5 py-1 bg-emerald-50 text-emerald-700 rounded-full font-mono text-[10px]">
                                    Terverifikasi
                                </span>
                            </td>
                            <td class="px-5 py-4 text-right text-xs">
                                <a href="{{ route('documents.stream', $doc) }}" target="_blank" class="px-2.5 py-1 bg-neutral-100 hover:bg-neutral-200 rounded-lg text-ink-700 font-medium">
                                    Pratinjau
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-5 py-10 text-center text-xs text-ink-400">
                                Belum ada dokumen yang diunggah.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($documents->hasPages())
            <div class="p-4 border-t border-black/[0.06]">
                {{ $documents->links() }}
            </div>
        @endif
    </div>
</x-layouts.app>