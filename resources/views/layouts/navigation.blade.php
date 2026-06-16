<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-12 items-center h-16 relative">
            <!-- Logo & Search -->
            <div class="col-span-4 flex items-center gap-4">
                <a href="{{ route('dashboard') }}" class="shrink-0 flex items-center">
                    <x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
                </a>
                @auth
                    <div class="hidden md:block w-full max-w-[240px]">
                        <div class="relative w-full">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </div>
                            <input 
                                type="text" 
                                x-model="$store.search.query"
                                placeholder="Cari catatan..." 
                                class="w-full bg-slate-100/70 border-0 focus:bg-white focus:ring-1 focus:ring-teal-500 rounded-xl pl-8 pr-3 py-1.5 text-xs transition-all duration-200 text-slate-900 placeholder-slate-400" 
                            />
                        </div>
                    </div>
                @endauth
            </div>

            <!-- Summary / Reporting Header Section -->
            <div class="col-span-5 flex justify-center">
                @auth
                    @php
                        $userNotes = auth()->user()->notes;
                        $totalNotes = $userNotes->count();
                        $notesToday = $userNotes->filter(fn($note) => \Carbon\Carbon::parse($note->created_at)->isToday())->count();
                        $latestNote = $userNotes->sortByDesc('created_at')->first();
                    @endphp
                    <div class="hidden sm:flex items-center space-x-3">
                        <div class="flex items-center gap-1.5 bg-slate-50 border border-slate-200/60 rounded-xl px-2.5 py-1 shadow-sm text-[11px] text-slate-500 font-medium select-none">
                            <span class="w-1.5 h-1.5 rounded-full bg-teal-500"></span>
                            <span>Total: <strong class="text-slate-800 font-semibold">{{ $totalNotes }}</strong></span>
                        </div>
                        <div class="flex items-center gap-1.5 bg-slate-50 border border-slate-200/60 rounded-xl px-2.5 py-1 shadow-sm text-[11px] text-slate-500 font-medium select-none">
                            <span class="w-1.5 h-1.5 rounded-full bg-cyan-500"></span>
                            <span>Hari Ini: <strong class="text-slate-800 font-semibold">{{ $notesToday }}</strong></span>
                        </div>
                        @if ($latestNote)
                            <div class="flex items-center gap-1.5 bg-slate-50 border border-slate-200/60 rounded-xl px-2.5 py-1 shadow-sm text-[11px] text-slate-500 font-medium select-none max-w-[150px] truncate">
                                <span class="w-1.5 h-1.5 rounded-full bg-amber-500 shrink-0"></span>
                                <span class="truncate">Terbaru: <strong class="text-slate-800 font-semibold">{{ $latestNote->title ?: 'Tanpa Judul' }}</strong></span>
                            </div>
                        @endif
                    </div>
                @endauth
            </div>

            <!-- Right: Settings Dropdown & Hamburger -->
            <div class="col-span-3 flex justify-end items-center gap-4">
                <!-- Settings Dropdown -->
                <div class="hidden sm:flex sm:items-center">
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                                <div>{{ Auth::user()->name }}</div>

                                <div class="ms-1">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <x-dropdown-link href="#" x-on:click.prevent="$dispatch('open-modal', 'edit-profile')">
                                {{ __('Profile') }}
                            </x-dropdown-link>

                            <!-- Authentication -->
                            <x-dropdown-link href="#" x-on:click.prevent="$dispatch('open-modal', 'confirm-logout')">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </x-slot>
                    </x-dropdown>
                </div>

                <!-- Hamburger -->
                <div class="flex items-center sm:hidden">
                    <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                        <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                            <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-slate-50/50 border-b border-slate-100">
        @auth
            @php
                $userNotes = auth()->user()->notes;
                $totalNotes = $userNotes->count();
                $notesToday = $userNotes->filter(fn($note) => \Carbon\Carbon::parse($note->created_at)->isToday())->count();
                $latestNote = $userNotes->sortByDesc('created_at')->first();
            @endphp
            <div class="px-4 py-3 space-y-3 text-xs text-slate-500 font-medium">
                <!-- Mobile Search Bar -->
                <div class="relative w-full">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                    <input 
                        type="text" 
                        x-model="$store.search.query"
                        placeholder="Cari catatan..." 
                        class="w-full bg-white border border-slate-200/80 focus:border-teal-500 focus:ring-teal-500 rounded-xl pl-9 pr-3 py-2 text-xs text-slate-900 placeholder-slate-400" 
                    />
                </div>

                <div class="flex items-center gap-2 bg-white border border-slate-200/60 rounded-xl px-3 py-2 shadow-sm">
                    <span class="w-2 h-2 rounded-full bg-teal-500"></span>
                    <span>Total Catatan: <strong class="text-slate-800 font-bold">{{ $totalNotes }}</strong></span>
                </div>
                <div class="flex items-center gap-2 bg-white border border-slate-200/60 rounded-xl px-3 py-2 shadow-sm">
                    <span class="w-2 h-2 rounded-full bg-cyan-500"></span>
                    <span>Hari Ini: <strong class="text-slate-800 font-bold">{{ $notesToday }}</strong></span>
                </div>
                @if ($latestNote)
                    <div class="flex items-center gap-2 bg-white border border-slate-200/60 rounded-xl px-3 py-2 shadow-sm truncate">
                        <span class="w-2 h-2 rounded-full bg-amber-500"></span>
                        <span class="truncate">Terbaru: <strong class="text-slate-800 font-bold">{{ $latestNote->title ?: 'Tanpa Judul' }}</strong></span>
                    </div>
                @endif
            </div>
        @endauth

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link href="#" x-on:click.prevent="$dispatch('open-modal', 'edit-profile')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <x-responsive-nav-link href="#" x-on:click.prevent="$dispatch('open-modal', 'confirm-logout')">
                    {{ __('Log Out') }}
                </x-responsive-nav-link>
            </div>
        </div>
    </div>

    <!-- Modal Konfirmasi Logout -->
    <x-modal name="confirm-logout" focusable>
        <form method="POST" action="{{ route('logout') }}" class="p-6 space-y-4" x-data="{ loading: false }" @submit="loading = true">
            @csrf
            <div class="mb-4">
                <h2 class="text-xl font-bold text-slate-900 tracking-tight leading-tight text-teal-600">Konfirmasi Keluar</h2>
                <p class="text-sm text-slate-600 mt-3">
                    Apakah Anda yakin ingin keluar dari akun Anda? Anda harus masuk kembali untuk mengakses dan mengelola catatan Anda.
                </p>
            </div>

            <div class="flex justify-end items-center gap-3 pt-4 border-t border-slate-100">
                <x-secondary-button x-on:click="$dispatch('close')" ::disabled="loading">
                    Batal
                </x-secondary-button>

                <button type="submit" :disabled="loading" class="flex justify-center items-center gap-2 px-4 py-2.5 border border-transparent rounded-lg text-sm font-semibold text-white bg-gradient-to-r from-teal-600 to-cyan-600 hover:from-teal-500 hover:to-cyan-500 shadow-md hover:shadow-teal-500/10 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500 transition-all duration-150 transform active:scale-[0.98] disabled:opacity-50 disabled:cursor-not-allowed">
                    <svg x-show="loading" class="animate-spin h-3.5 w-3.5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" style="display: none;">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <span x-show="!loading">Ya, Keluar</span>
                    <span x-show="loading">Keluar...</span>
                </button>
            </div>
        </form>
    </x-modal>
</nav>
