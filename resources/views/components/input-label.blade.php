<label {{ $attributes->merge(['class' => 'block font-bold text-[10px] text-slate-400 uppercase tracking-widest mb-2']) }}>
    {{ $value ?? $slot }}
</label>