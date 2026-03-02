@php
$currentLocale = session('locale', app()->getLocale());
$isAuthRoute = request()->routeIs('filament.*.auth.*');
@endphp

@if ($isAuthRoute)
<div
    class="fixed z-[100]"
    style="top: 1rem; right: 1rem; left: auto;">
    <details class="group relative">
        <summary class="flex h-11 w-11 cursor-pointer items-center justify-center rounded-full border border-gray-200 bg-white text-gray-700 shadow-sm outline-none transition hover:bg-gray-50 focus-visible:ring-2 focus-visible:ring-primary-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-200 dark:hover:bg-gray-800">
            <span class="text-sm font-semibold">{{ str_starts_with($currentLocale, 'pt') ? __('locales.pt_short') : __('locales.en_short') }}</span>
        </summary>

        <div
            class="absolute rounded-xl border border-gray-200 bg-white p-2 shadow-lg dark:border-gray-700 dark:bg-gray-900"
            style="top: 3.5rem; right: 0; left: auto; min-width: 11rem; width: max-content; max-width: calc(100vw - 2rem);">
            <p class="px-2 pb-0 text-xs font-medium text-gray-500 dark:text-gray-400" style="margin-bottom: 3px;">{{ __('locales.switch_language') }}</p>

            <a
                href="{{ route('switch-language', ['locale' => 'pt_BR']) }}"
                class="mb-1 flex items-center justify-between rounded-lg px-2 py-2 text-sm text-gray-700 transition hover:bg-gray-50 dark:text-gray-200 dark:hover:bg-gray-800">
                <span style="white-space: nowrap;">{{ __('locales.pt_BR') }}</span>
                @if (str_starts_with($currentLocale, 'pt'))
                <span>✓</span>
                @endif
            </a>

            <a
                href="{{ route('switch-language', ['locale' => 'en']) }}"
                class="flex items-center justify-between rounded-lg px-2 py-2 text-sm text-gray-700 transition hover:bg-gray-50 dark:text-gray-200 dark:hover:bg-gray-800">
                <span style="white-space: nowrap;">{{ __('locales.en') }}</span>
                @if ($currentLocale === 'en')
                <span>✓</span>
                @endif
            </a>
        </div>
    </details>
</div>
@endif