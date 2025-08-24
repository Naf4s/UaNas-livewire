<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-white dark:bg-zinc-800">
        <flux:sidebar sticky stashable class="border-e border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
            <flux:sidebar.toggle class="lg:hidden" icon="x-mark" />

            <a href="{{ route('dashboard') }}" class="me-5 flex items-center space-x-2 rtl:space-x-reverse" wire:navigate>
                <x-app-logo />
            </a>

            <!-- DASHBOARD & UTAMA -->
            <flux:navlist variant="outline">
                <flux:navlist.group :heading="__('Dashboard & Utama')" class="grid">
                    <flux:navlist.item icon="home" :href="route('dashboard')" :current="request()->routeIs('dashboard')" wire:navigate>{{ __('Dashboard') }}</flux:navlist.item>
                </flux:navlist.group>
            

            <!-- MANAJEMEN AKADEMIK -->
            
                <flux:navlist.group :heading="'Manajemen Akademik'" class="grid">
                    <flux:navlist.item icon="book-open-text" :href="route('mata-pelajaran.index')" :current="request()->routeIs('mata-pelajaran.*')" wire:navigate>Mata Pelajaran</flux:navlist.item>
                    <flux:navlist.item icon="folder-git-2" :href="route('kurikulum.index')" :current="request()->routeIs('kurikulum.*')" wire:navigate>Kurikulum</flux:navlist.item>
                    <flux:navlist.item icon="layout-grid" :href="route('penilaian.input')" :current="request()->routeIs('penilaian.*')" wire:navigate>Input Penilaian</flux:navlist.item>
                </flux:navlist.group>
            

            <!-- MANAJEMEN KELAS & SISWA -->
            
                <flux:navlist.group :heading="'Manajemen Kelas & Siswa'" class="grid">
                    <flux:navlist.item icon="layout-grid" :href="route('kelas.index')" :current="request()->routeIs('kelas.*')" wire:navigate>Kelas</flux:navlist.item>
                    <flux:navlist.item icon="folder-git-2" :href="route('rombel.index')" :current="request()->routeIs('rombel.*')" wire:navigate>Rombel</flux:navlist.item>
                    <flux:navlist.item icon="user" :href="route('siswa.index')" :current="request()->routeIs('siswa.*')" wire:navigate>Siswa</flux:navlist.item>
                </flux:navlist.group>
           

            <!-- KEHADIRAN & MONITORING -->
            
                <flux:navlist.group :heading="'Kehadiran & Monitoring'" class="grid">
                    <flux:navlist.item icon="calendar" :href="route('absensi.input')" :current="request()->routeIs('absensi.*')" wire:navigate>Input Absensi</flux:navlist.item>
                    <flux:navlist.item icon="chevrons-up-down" :href="route('wali-kelas.catatan')" :current="request()->routeIs('wali-kelas.catatan')" wire:navigate>Catatan Wali Kelas</flux:navlist.item>
                </flux:navlist.group>
           

            <!-- PENILAIAN & LAPORAN -->
            
                <flux:navlist.group :heading="'Penilaian & Laporan'" class="grid">
                    <flux:navlist.item icon="book-open-text" :href="route('cetak-rapor')" :current="request()->routeIs('cetak-rapor')" wire:navigate>Cetak Rapor</flux:navlist.item>
                    <flux:navlist.item icon="layout-grid" :href="route('rekap-nilai')" :current="request()->routeIs('rekap-nilai')" wire:navigate>Rekap Nilai</flux:navlist.item>
                </flux:navlist.group>
            

            <!-- KENAIKAN KELAS -->
            
                <flux:navlist.group :heading="'Kenaikan Kelas'" class="grid">
                    <flux:navlist.item icon="chevrons-up-down" :href="route('wali-kelas.usulan-kenaikan')" :current="request()->routeIs('wali-kelas.usulan-kenaikan')" wire:navigate>Usulan Kenaikan</flux:navlist.item>
                    <flux:navlist.item icon="chevrons-up-down" :href="route('validasi-kenaikan')" :current="request()->routeIs('validasi-kenaikan')" wire:navigate>Validasi Kenaikan</flux:navlist.item>
                </flux:navlist.group>
            

            <!-- ADMINISTRASI -->
            
                <flux:navlist.group :heading="'Administrasi'" class="grid">
                    <flux:navlist.item icon="user" :href="route('user-management.index')" :current="request()->routeIs('user-management.*')" wire:navigate>Manajemen User</flux:navlist.item>
                </flux:navlist.group>
            </flux:navlist>

            <flux:spacer />

            <!-- RESOURCES -->
            <flux:navlist variant="outline">
                <flux:navlist.group :heading="'Resources'" class="grid">
                    <flux:navlist.item icon="folder-git-2" href="https://github.com/laravel/livewire-starter-kit" target="_blank">
                    {{ __('Repository') }}
                    </flux:navlist.item>

                    <flux:navlist.item icon="book-open-text" href="https://laravel.com/docs/starter-kits#livewire" target="_blank">
                    {{ __('Documentation') }}
                    </flux:navlist.item>
                </flux:navlist.group>
            </flux:navlist>

            <!-- Desktop User Menu -->
            <flux:dropdown class="hidden lg:block" position="bottom" align="start">
                <flux:profile
                    :name="auth()->user()->name"
                    :initials="auth()->user()->initials()"
                    icon:trailing="chevrons-up-down"
                />

                <flux:menu class="w-[220px]">
                    <flux:menu.radio.group>
                        <div class="p-0 text-sm font-normal">
                            <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                                <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-lg">
                                    <span
                                        class="flex h-full w-full items-center justify-center rounded-lg bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white"
                                    >
                                        {{ auth()->user()->initials() }}
                                    </span>
                                </span>

                                <div class="grid flex-1 text-start text-sm leading-tight">
                                    <span class="truncate font-semibold">{{ auth()->user()->name }}</span>
                                    <span class="truncate text-xs">{{ auth()->user()->email }}</span>
                                </div>
                            </div>
                        </div>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <flux:menu.radio.group>
                        <flux:menu.item :href="route('settings.profile')" icon="cog" wire:navigate>{{ __('Settings') }}</flux:menu.item>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full">
                            {{ __('Log Out') }}
                        </flux:menu.item>
                    </form>
                </flux:menu>
            </flux:dropdown>
        </flux:sidebar>

        <!-- Mobile User Menu -->
        <flux:header class="lg:hidden">
            <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />

            <flux:spacer />

            <flux:dropdown position="top" align="end">
                <flux:profile
                    :initials="auth()->user()->initials()"
                    icon-trailing="chevron-down"
                />

                <flux:menu>
                    <flux:menu.radio.group>
                        <div class="p-0 text-sm font-normal">
                            <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                                <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-lg">
                                    <span
                                        class="flex h-full w-full items-center justify-center rounded-lg bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white"
                                    >
                                        {{ auth()->user()->initials() }}
                                    </span>
                                </span>

                                <div class="grid flex-1 text-start text-sm leading-tight">
                                    <span class="truncate font-semibold">{{ auth()->user()->name }}</span>
                                    <span class="truncate text-xs">{{ auth()->user()->email }}</span>
                                </div>
                            </div>
                        </div>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <flux:menu.radio.group>
                        <flux:menu.item :href="route('settings.profile')" icon="cog" wire:navigate>{{ __('Settings') }}</flux:menu.item>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full">
                            {{ __('Log Out') }}
                        </flux:menu.item>
                    </form>
                </flux:menu>
            </flux:dropdown>
        </flux:header>

        {{ $slot }}

        @fluxScripts
    </body>
</html>
