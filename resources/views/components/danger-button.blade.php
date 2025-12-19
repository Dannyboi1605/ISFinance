<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-8 py-3 bg-rose-500 border border-transparent rounded-2xl font-bold text-sm text-white uppercase tracking-widest hover:bg-rose-600 active:bg-rose-700 focus:outline-none focus:ring-4 focus:ring-rose-100 transition ease-in-out duration-300 shadow-lg shadow-rose-100']) }}>
    {{ $slot }}
</button>