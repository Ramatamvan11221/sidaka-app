<x-layouts.app title="Unggah Dokumen Admin - SIDAKA">
    <x-slot name="header">Unggah Dokumen Siswa (Admin / Kurikulum / TU)</x-slot>

    <div class="max-w-3xl mx-auto rounded-2xl border border-black/[0.06] bg-white p-6 shadow-sm">
        <h2 class="text-lg font-semibold text-ink-900 mb-6">Unggah Berkas Baru</h2>

        {{-- Tampilkan alasan gagal validasi --}}
        @if ($errors->any())
            <div class="mb-6 p-4 rounded-2xl bg-danger/5 border border-danger/20 text-danger">
                <p class="font-mono text-[10px] tracking-wider uppercase font-semibold mb-1.5">Gagal Mengunggah Dokumen:</p>
                <ul class="list-disc list-inside text-[12px] space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif


        <form action="{{ route('admin.documents.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
            @csrf

            {{-- Pilih Siswa --}}
            <div>
                <label for="student_id" class="block text-xs font-medium text-ink-700 uppercase mb-1">Siswa</label>
                <select name="student_id" id="student_id" required class="w-full h-11 px-3 rounded-xl border border-black/[0.1] text-sm">
                    <option value="">— Pilih Siswa —</option>
                    @foreach($students as $student)
                        <option value="{{ $student->id }}">
                            {{ $student->user->name ?? 'Siswa' }} (NIS: {{ $student->nis ?? '-' }} | {{ $student->classInfo->name ?? '-' }})
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Pilih Jenis Dokumen (Bisa Ijazah, Transkrip, Raport, Sertifikat) --}}
            <div>
                <label for="document_type_id" class="block text-xs font-medium text-ink-700 uppercase mb-1">Jenis Dokumen</label>
                <select name="document_type_id" id="document_type_id" required class="w-full h-11 px-3 rounded-xl border border-black/[0.1] text-sm">
                    <option value="">— Pilih Jenis Dokumen —</option>
                    @foreach($documentTypes as $type)
                        <option value="{{ $type->id }}">{{ $type->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-xs font-medium text-ink-700 mb-1.5">Kategori Berkas</label>
                <select name="category" required class="w-full rounded-xl border border-black/10 px-3.5 py-2.5 text-sm">
                    <option value="">-- Pilih Kategori --</option>
                    <option value="ijazah" {{ old('category') === 'ijazah' ? 'selected' : '' }}>Ijazah / SKL</option>
                    <option value="raport" {{ old('category') === 'raport' ? 'selected' : '' }}>Raport</option>
                    <option value="sertifikat" {{ old('category') === 'sertifikat' ? 'selected' : '' }}>Sertifikat</option>
                </select>
            </div>

            {{-- Judul Dokumen --}}
            <div>
                <label for="title" class="block text-xs font-medium text-ink-700 uppercase mb-1">Judul Dokumen</label>
                <input type="text" name="title" id="title" placeholder="Contoh: Ijazah SMK / SKHUN / Sertifikat PKL" required class="w-full h-11 px-3 rounded-xl border border-black/[0.1] text-sm">
            </div>

            {{-- File --}}
            <div>
                <label for="file" class="block text-xs font-medium text-ink-700 uppercase mb-1">Berkas Dokumen (PDF/JPG/PNG)</label>
                <input type="file" name="file" id="file" required class="w-full p-2 border border-black/[0.1] rounded-xl text-sm">
            </div>

            <div class="pt-4 flex justify-end">
                <button type="submit" class="px-5 py-2.5 bg-ink-900 hover:bg-ink-700 text-white font-medium text-xs rounded-xl transition">
                    Unggah &amp; Verifikasi Dokumen
                </button>
            </div>
        </form>
    </div>
</x-layouts.app>