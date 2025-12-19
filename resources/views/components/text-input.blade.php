@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'bg-slate-50 border-slate-200 focus:border-pink-500 focus:ring-4 focus:ring-pink-100 rounded-2xl shadow-sm transition-all py-3 px-4']) }}>