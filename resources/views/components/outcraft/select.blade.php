@props([
    'model' => null,
    'options' => [],
    'valueKey' => null,
    'labelKey' => null,
    'labelPrefix' => '',
    'placeholder' => 'Select an option',
    'onChange' => '',
    'numeric' => false,
    'value' => null,
    'buttonClass' => '',
    'menuClass' => '',
])

@php
    $optionsExpression = is_string($options) ? $options : \Illuminate\Support\Js::from($options);
    $selectedValueExpression = $model ?: 'value';
    $assignmentExpression = $model
        ? $model . ' = ' . ($numeric ? 'Number(option.value)' : 'option.value')
        : 'value = option.value';
@endphp

<div
    {{ $attributes->merge(['class' => 'relative']) }}
    x-data="{ open: false, value: @js($value) }"
    x-on:keydown.escape.window="open = false"
    x-on:click.outside="open = false"
>
    <button
        type="button"
        data-campaign-field
        class="flex w-full items-center justify-between gap-3 rounded-md bg-white py-1.5 pl-3 pr-2 text-left text-sm/6 text-gray-900 shadow-sm outline outline-1 -outline-offset-1 outline-gray-300 transition hover:bg-gray-50 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 {{ $buttonClass }}"
        :aria-expanded="open.toString()"
        x-on:click="open = ! open"
    >
        <span
            class="min-w-0 truncate"
            x-text="outcraftSelectLabel({{ $selectedValueExpression }}, {{ $optionsExpression }}, @js($valueKey), @js($labelKey), @js($labelPrefix), @js($placeholder))"
        ></span>
        <span class="outcraft-icon shrink-0 !text-[18px] text-gray-400 transition" :class="open ? 'rotate-180' : ''">keyboard_arrow_down</span>
    </button>

    <div
        x-cloak
        x-show="open"
        data-dropdown-surface
        data-panel-surface
        x-transition:enter="transition ease-out duration-100"
        x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-75"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95"
        class="absolute z-50 mt-2 max-h-64 w-full overflow-y-auto rounded-md bg-white py-1 text-sm shadow-lg ring-1 ring-gray-900/10 focus:outline-none {{ $menuClass }}"
    >
        <template x-for="option in outcraftNormalizeSelectOptions({{ $optionsExpression }}, @js($valueKey), @js($labelKey), @js($labelPrefix))" :key="option.value">
            <div>
                <div x-show="option.disabled" class="my-1 border-t border-gray-100"></div>
                <button
                    x-show="! option.disabled"
                    type="button"
                    class="flex w-full items-center justify-between gap-3 px-3 py-2 text-left text-gray-700 transition hover:bg-gray-50 hover:text-gray-950"
                    :class="String({{ $selectedValueExpression }}) === String(option.value) ? 'bg-indigo-50 text-indigo-700' : ''"
                    x-on:click="{{ $assignmentExpression }}; open = false; {{ $onChange }}"
                >
                    <span class="min-w-0 truncate" x-text="option.label"></span>
                    <span x-show="String({{ $selectedValueExpression }}) === String(option.value)" class="outcraft-icon shrink-0 !text-[16px] text-indigo-600">check</span>
                </button>
            </div>
        </template>
    </div>
</div>
