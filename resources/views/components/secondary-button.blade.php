<button {{ $attributes->merge(['type' => 'button', 'class' => 'inline-flex items-center px-8 py-3 bg-white border-2 border-slate-100 rounded-2xl font-bold text-sm text-slate-600 uppercase tracking-widest shadow-sm hover:bg-slate-50 focus:outline-none focus:ring-4 focus:ring-slate-100 disabled:opacity-25 transition ease-in-out duration-300']) }}>
    {{ $slot }}
</button>