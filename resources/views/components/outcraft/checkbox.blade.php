@props([
    'markWhen' => null,
    'dashWhen' => null,
    'wrapperClass' => '',
])

@php
    $wrapperClasses = trim('group grid size-4 shrink-0 grid-cols-1 ' . $wrapperClass);
    $inputClasses = 'col-start-1 row-start-1 size-4 appearance-none rounded-sm border border-gray-300 bg-white checked:border-indigo-600 checked:bg-indigo-600 indeterminate:border-indigo-600 indeterminate:bg-indigo-600 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 disabled:border-gray-300 disabled:bg-gray-100 disabled:checked:bg-gray-100 forced-colors:appearance-auto';
@endphp

<span class="{{ $wrapperClasses }}">
    <input
        type="checkbox"
        data-outcraft-checkbox
        {{ $attributes->merge(['class' => $inputClasses]) }}
    >
    <svg viewBox="0 0 14 14" fill="none" class="pointer-events-none col-start-1 row-start-1 size-3.5 self-center justify-self-center stroke-white group-has-disabled:stroke-gray-950/25">
        <path
            @if ($markWhen)
                x-cloak
                x-show="{{ $markWhen }}"
            @else
                class="opacity-0 group-has-checked:opacity-100"
            @endif
            d="M3 8L6 11L11 3.5"
            stroke-width="2"
            stroke-linecap="round"
            stroke-linejoin="round"
        />
        <path
            @if ($dashWhen)
                x-cloak
                x-show="{{ $dashWhen }}"
            @else
                class="opacity-0 group-has-indeterminate:opacity-100"
            @endif
            d="M3 7H11"
            stroke-width="2"
            stroke-linecap="round"
            stroke-linejoin="round"
        />
    </svg>
</span>
