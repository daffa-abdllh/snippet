<div
    x-data="{
        toasts: [],
        addToast(message, type = 'success') {
            const id = Date.now() + Math.random().toString(36).substr(2, 9);
            this.toasts.push({ id, message, type });
            setTimeout(() => this.removeToast(id), 4000);
        },
        removeToast(id) {
            this.toasts = this.toasts.filter(toast => toast.id !== id);
        }
    }"
    x-on:toast.window="addToast($event.detail.message, $event.detail.type)"
    x-init="
        @if ($errors->any())
            addToast('Terjadi kesalahan validasi. Silakan periksa kembali input Anda.', 'error');
        @endif

        @if (session('status') === 'note-created')
            addToast('Catatan berhasil disimpan!', 'success');
        @elseif (session('status') === 'note-deleted')
            addToast('Catatan berhasil dihapus!', 'success');
        @elseif (session('status') === 'profile-updated')
            addToast('Profil berhasil diperbarui!', 'success');
        @elseif (session('status') === 'password-updated')
            addToast('Kata sandi berhasil diperbarui!', 'success');
        @elseif (session('status'))
            addToast('{{ session('status') }}', 'info');
        @endif
    "
    class="fixed bottom-6 right-6 z-50 flex flex-col gap-3 max-w-sm w-full pointer-events-none"
>
    <template x-for="toast in toasts" :key="toast.id">
        <div
            x-transition:enter="transition ease-out duration-300 transform"
            x-transition:enter-start="translate-y-4 opacity-0 sm:translate-y-0 sm:translate-x-4"
            x-transition:enter-end="translate-y-0 opacity-100 sm:translate-x-0"
            x-transition:leave="transition ease-in duration-200 transform"
            x-transition:leave-start="opacity-100 translate-x-0"
            x-transition:leave-end="opacity-0 translate-x-4"
            class="flex items-center gap-3 w-full p-4 bg-white/95 backdrop-blur-md border border-slate-100 rounded-2xl shadow-xl shadow-slate-200/50 pointer-events-auto transition-all"
            :class="{
                'border-l-4 border-l-teal-500': toast.type === 'success',
                'border-l-4 border-l-rose-500': toast.type === 'error',
                'border-l-4 border-l-cyan-500': toast.type === 'info',
            }"
        >
            <!-- Success Icon -->
            <template x-if="toast.type === 'success'">
                <span class="p-1.5 bg-teal-500/10 text-teal-600 rounded-xl shrink-0">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"></path>
                    </svg>
                </span>
            </template>

            <!-- Error Icon -->
            <template x-if="toast.type === 'error'">
                <span class="p-1.5 bg-rose-500/10 text-rose-600 rounded-xl shrink-0">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"></path>
                    </svg>
                </span>
            </template>

            <!-- Info Icon -->
            <template x-if="toast.type === 'info'">
                <span class="p-1.5 bg-cyan-500/10 text-cyan-600 rounded-xl shrink-0">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 11.718 1.318l-.041.02a.75.75 0 01-.718-1.318zm0-3l.041-.02a.75.75 0 11.718 1.318l-.041.02a.75.75 0 01-.718-1.318zM12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25z"></path>
                    </svg>
                </span>
            </template>

            <!-- Text Content -->
            <div class="flex-1 text-xs font-semibold text-slate-800 leading-snug" x-text="toast.message"></div>

            <!-- Dismiss Button -->
            <button x-on:click="removeToast(toast.id)" class="text-slate-400 hover:text-slate-600 transition-colors shrink-0">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
    </template>
</div>
