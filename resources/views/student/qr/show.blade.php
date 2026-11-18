<x-layouts.app title="QR Code Pengajuan - SIDAKA">
    <x-slot name="header">QR Code Bukti Pengajuan</x-slot>

    <div class="max-w-md mx-auto bg-white p-8 rounded-2xl border border-slate-200 shadow-sm text-center">
        <p class="text-xs font-semibold text-indigo-600 uppercase tracking-wider">Nomor Pengajuan</p>
        <h3 class="text-xl font-mono font-bold text-slate-900 mt-1 mb-6">{{ $serviceRequest->request_number }}</h3>

        <div class="p-4 bg-slate-50 rounded-2xl border border-slate-200 inline-block mb-6">
            {!! $qrSvg !!}
        </div>

        <div class="text-left bg-slate-50 p-4 rounded-xl text-xs space-y-2 mb-6">
            <div class="flex justify-between">
                <span class="text-slate-500">Layanan:</span>
                <span class="font-semibold text-slate-800">{{ $serviceRequest->serviceType->name }}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-slate-500">Status:</span>
                <x-status-badge :status="$serviceRequest->status" />
            </div>
        </div>

        <p class="text-xs text-slate-400">
            Tunjukkan QR Code ini kepada petugas sekolah saat melakukan pengambilan dokumen.
        </p>
    </div>
</x-layouts.app>