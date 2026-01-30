<x-filament-panels::layout.base :livewire="null">

    <div class="flex min-h-screen items-center justify-center bg-gray-50 p-4 dark:bg-gray-950">

        <div class="w-full max-w-sm">

            <x-filament::section>

                <div class="flex flex-col items-center text-center space-y-4">

                    {{-- Ícone --}}
                    <div class="rounded-full bg-danger-50 p-3 text-danger-600 dark:bg-danger-950/50 dark:text-danger-500">
                        <x-heroicon-o-lock-closed class="h-8 w-8" />
                    </div>

                    {{-- Textos --}}
                    <div>
                        <h2 class="text-lg font-bold text-gray-950 dark:text-white">
                            {{ __('no_access.heading') }}
                        </h2>
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                            {{ __('no_access.message') }}
                        </p>
                    </div>

                    {{-- Link Suporte --}}
                    <p class="text-xs text-gray-400">
                        {{ __('no_access.support_text') }}
                        <a href="#" class="text-primary-600 hover:underline dark:text-primary-400">
                            {{ __('no_access.support_link') }}
                        </a>.
                    </p>

                    {{-- BOTÃO DE LOGOUT CORRIGIDO (HTML Puro) --}}
                    <form action="{{ filament()->getLogoutUrl() }}" method="POST" class="w-full">
                        @csrf

                        <button
                            type="submit"
                            class="flex w-full items-center justify-center gap-2 rounded-lg border border-gray-200 bg-white px-4 py-2 text-sm font-semibold text-gray-950 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-950/10 dark:border-white/10 dark:bg-white/5 dark:text-white dark:hover:bg-white/10 dark:focus:ring-white/20 transition-colors">
                            {{-- Ícone de Sair --}}
                            <x-heroicon-m-arrow-right-start-on-rectangle class="h-5 w-5 text-gray-400 dark:text-gray-500" />

                            {{ __('no_access.logout_button') }}
                        </button>
                    </form>

                </div>

            </x-filament::section>

        </div>
    </div>

</x-filament-panels::layout.base>