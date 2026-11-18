<x-layouts.app title="Detail Pengajuan - Admin SIDAKA">
    <x-slot name="header">Detail Pengajuan #{{ $serviceRequest->request_number }}</x-slot>

    @php
        $statusValue = is_object($serviceRequest->status) ? $serviceRequest->status->value : $serviceRequest->status;
    @endphp

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Detail Utama & Dokumen (2 Kolom) -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Information Card -->
            <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm space-y-4">
                <div class="flex items-center justify-between border-b border-slate-200 pb-4">
                    <div>
                        <p class="text-xs font-semibold text-slate-400 uppercase">Nomor Pengajuan</p>
                        <h3 class="text-xl font-mono font-bold text-slate-900">{{ $serviceRequest->request_number }}</h3>
                    </div>
                    <x-status-badge :status="$serviceRequest->status" />
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
                    <div>
                        <p class="text-xs text-slate-500">Jenis Layanan</p>
                        <p class="font-semibold text-slate-800">{{ $serviceRequest->serviceType->name ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-slate-500">Tanggal Pengajuan</p>
                        <p class="font-semibold text-slate-800">{{ $serviceRequest->created_at->format('d F Y H:i') }}</p>
                    </div>
                </div>

                <div>
                    <p class="text-xs text-slate-500">Keperluan Pengajuan</p>
                    <p class="p-3 bg-slate-50 rounded-xl text-slate-700 text-sm mt-1 border border-slate-200">{{ $serviceRequest->purpose ?? '-' }}</p>
                </div>

                @if($serviceRequest->rejection_note || $serviceRequest->admin_notes)
                    <div>
                        <p class="text-xs text-slate-500">Catatan Verifikasi / Penolakan</p>
                        <p class="p-3 bg-amber-50 rounded-xl text-amber-800 text-sm mt-1 border border-amber-200">
                            {{ $serviceRequest->rejection_note ?? $serviceRequest->admin_notes }}
                        </p>
                    </div>
                @endif
            </div>

            <!-- Dokumen yang Diajukan -->
            <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
                <h4 class="font-bold text-slate-800 text-sm mb-4">Dokumen yang Diajukan</h4>
                <div class="space-y-3">
                    @forelse($serviceRequest->items as $item)
                        <div class="p-4 bg-slate-50 rounded-xl border border-slate-200 flex items-center justify-between">
                            <div>
                                <p class="font-semibold text-slate-800 text-sm">{{ $item->document->title ?? 'Dokumen' }}</p>
                                <p class="text-xs text-slate-400">{{ $item->document->documentType->name ?? '-' }}</p>
                            </div>
                            @if($item->document)
                                <a href="{{ route('documents.stream', $item->document) }}" target="_blank" class="px-3 py-1.5 bg-white border border-slate-300 text-slate-700 hover:bg-slate-100 font-semibold text-xs rounded-lg transition">
                                    Pratinjau File
                                </a>
                            @endif
                        </div>
                    @empty
                        <p class="text-xs text-slate-400 italic">Tidak ada rincian berkas terlampir.</p>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Sidebar Informasi Pemohon & Aksi Status (1 Kolom) -->
        <div class="space-y-6">
            <!-- Informasi Pemohon -->
            <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm space-y-3 text-sm">
                <h4 class="font-bold text-slate-800 text-sm border-b border-slate-100 pb-2">Informasi Pemohon</h4>
                <div>
                    <p class="text-xs text-slate-400">Nama Siswa</p>
                    <p class="font-semibold text-slate-800">{{ $serviceRequest->student->user->name ?? '-' }}</p>
                </div>
                <div class="grid grid-cols-2 gap-2">
                    <div>
                        <p class="text-xs text-slate-400">NIS / NISN</p>
                        <p class="font-semibold text-slate-800 text-xs">{{ $serviceRequest->student->nis ?? '-' }} / {{ $serviceRequest->student->nisn ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-slate-400">Kelas</p>
                        <p class="font-semibold text-slate-800 text-xs">{{ $serviceRequest->student->classInfo->name ?? '-' }}</p>
                    </div>
                </div>
            </div>

            <!-- Aksi Status Pengajuan Berjenjang -->
            <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm space-y-4">
                <h4 class="font-bold text-slate-800 text-sm border-b border-slate-100 pb-2">Aksi Status Pengajuan</h4>

                {{-- Tahap 1: Verifikasi Berkas Fisik ku Tata Usaha (TU) --}}
                @if(in_array($statusValue, ['pending_tu', 'pending']))
                    <div class="p-3 bg-amber-50 border border-amber-200 rounded-xl mb-3 text-xs text-amber-800">
                        <span class="font-semibold block">Tahap 1: Tata Usaha</span>
                        Periksa kelengkapan berkas fisik siswa sebelum meneruskan ke Kurikulum.
                    </div>
                    <form action="{{ route('admin.service-requests.verify-tu', $serviceRequest) }}" method="POST" class="space-y-3">
                        @csrf
                        <div>
                            <label class="block text-xs text-slate-500 mb-1">Catatan Penolakan (Wajib jika ditolak)</label>
                            <textarea name="rejection_note" rows="2" class="w-full p-2.5 rounded-xl border border-slate-300 text-xs outline-none focus:ring-2 focus:ring-amber-500" placeholder="Alasan penolakan berkas TU..."></textarea>
                        </div>
                        <div class="flex gap-2">
                            <button type="submit" name="action" value="approve" class="flex-1 py-2.5 bg-amber-600 hover:bg-amber-700 text-white font-semibold text-xs rounded-xl transition">
                                ✓ Teruskan ke Kurikulum
                            </button>
                        </div>
                    </form>

                {{-- Tahap 2: Validasi Akademik & Legalisir ku Kurikulum --}}
                @elseif($statusValue === 'pending_kurikulum')
                    <div class="p-3 bg-blue-50 border border-blue-200 rounded-xl mb-3 text-xs text-blue-800">
                        <span class="font-semibold block">Tahap 2: Kurikulum</span>
                        Lakukan crosscheck data keabsahan akademik siswa sebelum legalisir diterbitkan.
                    </div>
                    <form action="{{ route('admin.service-requests.verify-kurikulum', $serviceRequest) }}" method="POST" class="space-y-3">
                        @csrf
                        <div>
                            <label class="block text-xs text-slate-500 mb-1">Catatan Penolakan (Wajib jika ditolak)</label>
                            <textarea name="rejection_note" rows="2" class="w-full p-2.5 rounded-xl border border-slate-300 text-xs outline-none focus:ring-2 focus:ring-blue-500" placeholder="Alasan penolakan Kurikulum..."></textarea>
                        </div>
                        <div class="flex gap-2">
                            <button type="submit" name="action" value="approve" class="flex-1 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-semibold text-xs rounded-xl transition">
                                ✓ Validasi &amp; Legalisir (Sah)
                        </div>
                    </form>

                {{-- Tahap Operasional Lanjutan (Preparing / Ready / Borrowed / Completed) --}}
                @elseif(in_array($statusValue, ['verified', 'approved']))
                    <form action="{{ route('admin.service-requests.update-status', $serviceRequest) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="status" value="preparing">
                        <button type="submit" class="w-full py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold text-xs rounded-xl shadow transition">
                            📦 Siapkan Berkas Fisik (Preparing)
                        </button>
                    </form>

                @elseif($statusValue === 'preparing')
                    <form action="{{ route('admin.service-requests.update-status', $serviceRequest) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="status" value="ready">
                        <button type="submit" class="w-full py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold text-xs rounded-xl shadow transition">
                            ✅ Tandai Siap Diambil (Ready)
                        </button>
                    </form>

                @elseif($statusValue === 'ready')
                    <div class="space-y-3">
                        <p class="text-xs text-emerald-700 font-medium">Berkas fisik telah siap! Klik tombol di bawah untuk menampilkan QR Code penyerahan di monitor.</p>
                        <a href="{{ route('admin.service-requests.qr-display', $serviceRequest) }}" target="_blank" class="block w-full py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-xs text-center rounded-xl shadow-lg transition">
                            🖥️ Tampilkan QR Penyerahan di Monitor
                        </a>
                    </div>

                @elseif($statusValue === 'borrowed')
                    <form action="{{ route('admin.returns.store', $serviceRequest) }}" method="POST" class="space-y-3">
                        @csrf
                        <div>
                            <label class="block text-xs text-slate-500 mb-1">Catatan Pengembalian</label>
                            <input type="text" name="notes" placeholder="Kondisi fisik berkas saat dikembalikan..." class="w-full p-2.5 rounded-xl border border-slate-300 text-xs outline-none">
                        </div>
                        <button type="submit" class="w-full py-2.5 bg-teal-600 hover:bg-teal-700 text-white font-semibold text-xs rounded-xl shadow transition">
                            🔄 Konfirmasi Pengembalian Rapor
                        </button>
                    </form>

                @else
                    <p class="text-xs text-slate-500 italic">Tidak ada aksi status lanjutan untuk status saat ini ({{ strtoupper($statusValue) }}).</p>
                @endif

                @if(in_array($statusValue, ['completed', 'borrowed', 'verified', 'ready']))
                    <a href="{{ route('service-requests.receipt', $serviceRequest) }}" target="_blank" class="block w-full py-2.5 bg-slate-800 hover:bg-slate-900 text-white font-semibold text-xs text-center rounded-xl shadow transition">
                        📄 Cetak / Download Tanda Terima PDF
                    </a>
                @endif
            </div>

            <!-- Timeline Status / Riwayat -->
            <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm space-y-3">
                <h4 class="font-bold text-slate-800 text-sm border-b border-slate-100 pb-2">Riwayat Transaksi</h4>
                <div class="space-y-3 relative pl-4 border-l-2 border-slate-200 text-xs">
                    @forelse($serviceRequest->statusHistories as $history)
                        <div class="relative">
                            <div class="absolute -left-[21px] top-1 w-2.5 h-2.5 bg-indigo-600 rounded-full"></div>
                            <x-status-badge :status="$history->status" />
                            <p class="text-[10px] text-slate-400 mt-1">{{ $history->created_at->format('d/m/Y H:i') }}</p>
                            @if($history->notes)
                                <p class="text-slate-600 mt-0.5">{{ $history->notes }}</p>
                            @endif
                        </div>
                    @empty
                        <p class="text-xs text-slate-400 italic">Belum ada catatan riwayat status.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>