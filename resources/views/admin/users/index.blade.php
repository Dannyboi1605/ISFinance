<x-admin-layout>
    <x-slot name="header">
        User Management
    </x-slot>

    <div class="max-w-7xl mx-auto space-y-8 animate-fadeIn" x-data="{ 
        showAddModal: false, 
        showEditModal: false,
        showConfirmModal: false,
        confirmAction: '',
        confirmTitle: '',
        confirmMessage: '',
        confirmButtonText: '',
        confirmButtonClass: '',
        confirmUrl: '',
        
        selectedUser: {
            id: '',
            name: '',
            email: '',
            role: ''
        },

        openEditModal(user) {
            this.selectedUser = { ...user };
            this.showEditModal = true;
        },

        triggerConfirm(title, message, btnText, btnClass, url) {
            this.confirmTitle = title;
            this.confirmMessage = message;
            this.confirmButtonText = btnText;
            this.confirmButtonClass = btnClass;
            this.confirmUrl = url;
            this.showConfirmModal = true;
        }
    }">

        {{-- Header Section --}}
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
            <div>
                <h1 class="text-3xl font-display font-bold text-slate-900 tracking-tight">System Users</h1>
                <p class="text-slate-500 mt-1">Manage administrative and borrower access controls.</p>
            </div>
            <button @click="showAddModal = true"
                class="px-6 py-3 bg-pink-500 text-white rounded-2xl font-bold shadow-lg shadow-pink-100 hover:bg-pink-600 transition-all transform hover:-translate-y-1 flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
                Add New User
            </button>
        </div>

        {{-- Filter & Search Bar --}}
        <div class="bg-white p-6 rounded-[2rem] shadow-xl shadow-slate-100/50 border border-slate-50">
            <form action="{{ route('admin.users.index') }}" method="GET" class="flex flex-col md:flex-row gap-4">
                <div class="relative flex-1">
                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </span>
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Search by name or email..."
                        class="w-full pl-12 pr-4 py-3 bg-slate-50 border-none rounded-2xl focus:ring-2 focus:ring-pink-100 transition-all text-sm">
                </div>
                <div class="flex gap-4">
                    <select name="role"
                        class="bg-slate-50 border-none rounded-2xl focus:ring-2 focus:ring-pink-100 transition-all text-sm px-6 py-3 min-w-[140px]">
                        <option value="">All Roles</option>
                        <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                        <option value="borrower" {{ request('role') == 'borrower' ? 'selected' : '' }}>Borrower</option>
                    </select>
                    <button type="submit"
                        class="px-8 py-3 bg-slate-900 text-white rounded-2xl font-bold text-sm hover:bg-slate-800 transition-all">
                        Filter
                    </button>
                    @if(request()->anyFilled(['search', 'role']))
                        <a href="{{ route('admin.users.index') }}"
                            class="px-6 py-3 text-slate-500 font-bold text-sm hover:text-slate-800 flex items-center">
                            Reset
                        </a>
                    @endif
                </div>
            </form>
        </div>

        {{-- Users Table --}}
        <div class="bg-white rounded-[2.5rem] shadow-xl shadow-slate-100/50 border border-slate-50 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm border-collapse">
                    <thead>
                        <tr class="bg-slate-50/50 border-b border-slate-50">
                            <th class="px-8 py-5 text-[10px] font-bold text-slate-400 uppercase tracking-[0.2em]">User
                                Details</th>
                            <th class="px-8 py-5 text-[10px] font-bold text-slate-400 uppercase tracking-[0.2em]">Role
                            </th>
                            <th class="px-8 py-5 text-[10px] font-bold text-slate-400 uppercase tracking-[0.2em]">Status
                            </th>
                            <th class="px-8 py-5 text-[10px] font-bold text-slate-400 uppercase tracking-[0.2em]">Joined
                                Date</th>
                            <th
                                class="px-8 py-5 text-[10px] font-bold text-slate-400 uppercase tracking-[0.2em] text-right">
                                Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @foreach($users as $user)
                            <tr class="hover:bg-slate-50/50 transition-colors group">
                                <td class="px-8 py-6">
                                    <div class="flex items-center gap-4">
                                        <div
                                            class="w-10 h-10 rounded-xl bg-slate-100 flex items-center justify-center text-slate-400 font-bold">
                                            {{ strtoupper(substr($user->name, 0, 1)) }}
                                        </div>
                                        <div>
                                            <div class="font-bold text-slate-900">{{ $user->name }}</div>
                                            <div class="text-slate-400 text-xs mt-0.5">{{ $user->email }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-8 py-6">
                                    @if($user->role === 'admin')
                                        <span
                                            class="px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-widest bg-purple-50 text-purple-600 border border-purple-100">
                                            Admin
                                        </span>
                                    @else
                                        <span
                                            class="px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-widest bg-pink-50 text-pink-600 border border-pink-100">
                                            Borrower
                                        </span>
                                    @endif
                                </td>
                                <td class="px-8 py-6">
                                    @if($user->is_active)
                                        <span
                                            class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-widest bg-emerald-50 text-emerald-600 border border-emerald-100">
                                            <span class="w-1 h-1 rounded-full bg-emerald-500 animate-pulse"></span>
                                            Active
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-widest bg-rose-50 text-rose-600 border border-rose-100">
                                            Banned
                                        </span>
                                    @endif
                                </td>
                                <td class="px-8 py-6 text-slate-500 font-medium">
                                    {{ $user->created_at->format('d M, Y') }}
                                </td>
                                <td class="px-8 py-6 text-right">
                                    <div
                                        class="flex justify-end gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                        <button @click="openEditModal({{ json_encode($user) }})"
                                            class="p-2 text-slate-400 hover:text-slate-900 transition-colors">
                                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </button>

                                        @if($user->id !== auth()->id())
                                            <button @click="triggerConfirm(
                                                '{{ $user->is_active ? 'Ban User' : 'Unban User' }}', 
                                                'Are you sure you want to {{ $user->is_active ? 'suspend' : 'reinstate' }} access for {{ $user->name }}?', 
                                                '{{ $user->is_active ? 'Confirm Ban' : 'Confirm Unban' }}', 
                                                '{{ $user->is_active ? 'bg-rose-600' : 'bg-emerald-600' }}', 
                                                '{{ route('admin.users.toggle-status', $user) }}'
                                            )" class="p-2 text-slate-400 hover:text-rose-600 transition-colors">
                                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
                                                </svg>
                                            </button>
                                            <button @click="triggerConfirm(
                                                'Delete User', 
                                                'This action is irreversible. All data associated with {{ $user->name }} will be permanently removed.', 
                                                'Permanently Delete', 
                                                'bg-slate-900', 
                                                '{{ route('admin.users.destroy', $user) }}',
                                                true
                                            )" class="p-2 text-slate-400 hover:text-slate-900 transition-colors">
                                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-4v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @if($users->hasPages())
                <div class="px-8 py-5 border-t border-slate-50">
                    {{ $users->links() }}
                </div>
            @endif
        </div>

        {{-- Add User Modal --}}
        <div x-show="showAddModal" x-cloak
            class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm">
            <div
                class="bg-white rounded-[2.5rem] p-10 max-w-lg w-full shadow-2xl animate-scaleIn border border-white/20">
                <div class="flex justify-between items-start mb-8">
                    <div>
                        <h3 class="text-3xl font-display font-bold text-slate-900">New User</h3>
                        <p class="text-slate-500 mt-1">Create a system access account.</p>
                    </div>
                    <button @click="showAddModal = false" class="text-slate-400 hover:text-slate-900">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <form method="POST" action="{{ route('admin.users.store') }}" class="space-y-6">
                    @csrf
                    <div class="space-y-2">
                        <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest pl-1">Full
                            Name</label>
                        <input type="text" name="name" required
                            class="w-full px-6 py-4 bg-slate-50 border-none rounded-2xl focus:ring-4 focus:ring-pink-100 transition-all font-medium">
                    </div>
                    <div class="space-y-2">
                        <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest pl-1">Email
                            Address</label>
                        <input type="email" name="email" required
                            class="w-full px-6 py-4 bg-slate-50 border-none rounded-2xl focus:ring-4 focus:ring-pink-100 transition-all font-medium text-slate-600">
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="space-y-2">
                            <label
                                class="text-[10px] font-bold text-slate-400 uppercase tracking-widest pl-1">Password</label>
                            <input type="password" name="password" required
                                class="w-full px-6 py-4 bg-slate-50 border-none rounded-2xl focus:ring-4 focus:ring-pink-100 transition-all">
                        </div>
                        <div class="space-y-2">
                            <label
                                class="text-[10px] font-bold text-slate-400 uppercase tracking-widest pl-1">Confirm</label>
                            <input type="password" name="password_confirmation" required
                                class="w-full px-6 py-4 bg-slate-50 border-none rounded-2xl focus:ring-4 focus:ring-pink-100 transition-all">
                        </div>
                    </div>
                    <div class="space-y-2">
                        <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest pl-1">Role
                            Assignment</label>
                        <select name="role" required
                            class="w-full px-6 py-4 bg-slate-50 border-none rounded-2xl focus:ring-4 focus:ring-pink-100 transition-all font-bold">
                            <option value="borrower">Borrower (Standard)</option>
                            <option value="admin">System Administrator</option>
                        </select>
                    </div>
                    <div class="pt-4">
                        <button type="submit"
                            class="w-full py-5 bg-pink-500 text-white rounded-[2rem] font-bold text-lg shadow-xl shadow-pink-100 hover:bg-pink-600 transition-all transform hover:-translate-y-1">
                            Create Account
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Edit User Modal --}}
        <div x-show="showEditModal" x-cloak
            class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm">
            <div
                class="bg-white rounded-[2.5rem] p-10 max-w-lg w-full shadow-2xl animate-scaleIn border border-white/20">
                <div class="flex justify-between items-start mb-8">
                    <div>
                        <h3 class="text-3xl font-display font-bold text-slate-900">Edit Member</h3>
                        <p class="text-slate-500 mt-1">Update profile and permissions.</p>
                    </div>
                    <button @click="showEditModal = false" class="text-slate-400 hover:text-slate-900">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <form method="POST" :action="'/admin/users/' + selectedUser.id" class="space-y-6">
                    @csrf
                    @method('PATCH')
                    <div class="space-y-2">
                        <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest pl-1">Full
                            Name</label>
                        <input type="text" name="name" x-model="selectedUser.name" required
                            class="w-full px-6 py-4 bg-slate-50 border-none rounded-2xl focus:ring-4 focus:ring-pink-100 transition-all font-medium">
                    </div>
                    <div class="space-y-2">
                        <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest pl-1">Email
                            Address</label>
                        <input type="email" name="email" x-model="selectedUser.email" required
                            class="w-full px-6 py-4 bg-slate-50 border-none rounded-2xl focus:ring-4 focus:ring-pink-100 transition-all font-medium text-slate-600">
                    </div>
                    <div class="bg-indigo-50/50 p-6 rounded-3xl border border-indigo-100/50 mb-6">
                        <p class="text-[10px] font-bold text-indigo-400 uppercase tracking-widest mb-4">Security Update
                            (Optional)</p>
                        <div class="grid grid-cols-2 gap-4">
                            <input type="password" name="password" placeholder="New password"
                                class="w-full px-4 py-3 bg-white border-none rounded-xl focus:ring-2 focus:ring-indigo-100 transition-all text-sm">
                            <input type="password" name="password_confirmation" placeholder="Confirm"
                                class="w-full px-4 py-3 bg-white border-none rounded-xl focus:ring-2 focus:ring-indigo-100 transition-all text-sm">
                        </div>
                        <p class="text-[10px] text-indigo-400 font-medium mt-3 italic">Leave blank to maintain current
                            credentials.</p>
                    </div>
                    <div class="space-y-2">
                        <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest pl-1">Role
                            Assignment</label>
                        <select name="role" x-model="selectedUser.role" required
                            class="w-full px-6 py-4 bg-slate-50 border-none rounded-2xl focus:ring-4 focus:ring-pink-100 transition-all font-bold">
                            <option value="borrower">Borrower (Standard)</option>
                            <option value="admin">System Administrator</option>
                        </select>
                    </div>
                    <div class="pt-4">
                        <button type="submit"
                            class="w-full py-5 bg-slate-900 text-white rounded-[2rem] font-bold text-lg shadow-xl shadow-slate-200 hover:bg-slate-800 transition-all transform hover:-translate-y-1">
                            Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Confirmation Modal --}}
        <div x-show="showConfirmModal" x-cloak
            class="fixed inset-0 z-[60] flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-md">
            <div
                class="bg-white rounded-[2.5rem] p-10 max-w-sm w-full shadow-2xl animate-scaleIn border border-white/20 text-center">
                <div
                    class="w-20 h-20 mx-auto bg-slate-50 rounded-3xl flex items-center justify-center text-slate-900 mb-8 shadow-inner">
                    <svg class="w-10 h-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </div>
                <h3 class="text-2xl font-display font-bold text-slate-900 mb-3" x-text="confirmTitle">Confirm Action
                </h3>
                <p class="text-slate-500 text-sm font-medium leading-relaxed mb-10" x-text="confirmMessage"></p>

                <div class="flex flex-col gap-3">
                    <form :action="confirmUrl" method="POST" x-ref="confirmForm">
                        @csrf
                        <template x-if="confirmButtonText.includes('Delete')">
                            <input type="hidden" name="_method" value="DELETE">
                        </template>
                        <button type="submit" :class="confirmButtonClass"
                            class="w-full py-4 text-white rounded-2xl font-bold transition-all shadow-lg hover:brightness-110">
                            <span x-text="confirmButtonText"></span>
                        </button>
                    </form>
                    <button @click="showConfirmModal = false"
                        class="w-full py-4 text-slate-500 font-bold hover:text-slate-900 transition-all">Cancel</button>
                </div>
            </div>
        </div>

    </div>
</x-admin-layout>