@props(['status'])

@php
    $value = $status->value ?? $status;

    // Format label
    $label = is_object($status) && method_exists($status, 'label')
        ? $status->label()
        : ucfirst(str_replace('_', ' ', (string) $value));

    // Design token per status — semua super soft, dot warna jadi fokus utama
    $style = match($value) {
        'pending', 'pending_tu'         => ['bg' => 'bg-amber-500/[0.08]',    'text' => 'text-amber-700',    'border' => 'border-amber-500/20',    'dot' => 'bg-amber-500'],
        'pending_kurikulum', 'approved' => ['bg' => 'bg-[#0A84FF]/[0.08]',    'text' => 'text-[#0055CC]',    'border' => 'border-[#0A84FF]/20',    'dot' => 'bg-[#0A84FF]'],
        'preparing'                    => ['bg' => 'bg-indigo-500/[0.08]',   'text' => 'text-indigo-700',   'border' => 'border-indigo-500/20',   'dot' => 'bg-indigo-500'],
        'ready'                        => ['bg' => 'bg-emerald-500/[0.08]',  'text' => 'text-emerald-700',  'border' => 'border-emerald-500/20',  'dot' => 'bg-emerald-500'],
        'completed'                    => ['bg' => 'bg-neutral-500/[0.06]',  'text' => 'text-neutral-700',  'border' => 'border-neutral-500/15',  'dot' => 'bg-neutral-500'],
        'borrowed'                     => ['bg' => 'bg-violet-500/[0.08]',   'text' => 'text-violet-700',   'border' => 'border-violet-500/20',   'dot' => 'bg-violet-500'],
        'returned'                     => ['bg' => 'bg-teal-500/[0.08]',     'text' => 'text-teal-700',     'border' => 'border-teal-500/20',     'dot' => 'bg-teal-500'],
        'rejected'                     => ['bg' => 'bg-rose-500/[0.08]',     'text' => 'text-rose-700',     'border' => 'border-rose-500/20',     'dot' => 'bg-rose-500'],
        'verified'                     => ['bg' => 'bg-emerald-500/[0.08]',  'text' => 'text-emerald-700',  'border' => 'border-emerald-500/20',  'dot' => 'bg-emerald-500'],
        default                        => ['bg' => 'bg-neutral-500/[0.06]',  'text' => 'text-neutral-600',  'border' => 'border-neutral-500/15',  'dot' => 'bg-neutral-400'],
    };
@endphp

<span class="inline-flex items-center gap-1.5 h-6 pl-2 pr-2.5 rounded-md
             border {{ $style['bg'] }} {{ $style['text'] }} {{ $style['border'] }}
             whitespace-nowrap">

    {{-- Dot indicator --}}
    <span class="w-1.5 h-1.5 rounded-full shrink-0 {{ $style['dot'] }}"></span>

    {{-- Label mono uppercase --}}
    <span class="font-mono text-[10px] font-medium uppercase tracking-wider">
        {{ $label }}
    </span>

</span>