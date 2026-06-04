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
    'searchable' => false,
    'searchPlaceholder' => 'Search options',
])

@php
    $optionsExpression = is_string($options) ? $options : \Illuminate\Support\Js::from($options);
    $selectedValueExpression = $model ?: 'value';
    $assignmentExpression = $model
        ? $model . ' = ' . ($numeric ? 'Number(option.value)' : 'option.value')
        : 'value = option.value';
    $isSearchable = filter_var($searchable, FILTER_VALIDATE_BOOLEAN);
@endphp

<div
    {{ $attributes->merge(['class' => 'relative']) }}
    x-data="{ open: false, value: @js($value), search: '' }"
    x-on:keydown.escape.window="open = false; search = ''"
    x-on:click.outside="open = false; search = ''"
>
    <button
        type="button"
        data-campaign-field
        class="flex w-full items-center justify-between gap-3 rounded-md bg-white py-1.5 pl-3 pr-2 text-left text-sm/6 text-gray-900 shadow-sm outline outline-1 -outline-offset-1 outline-gray-300 transition hover:bg-gray-50 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 {{ $buttonClass }}"
        :aria-expanded="open.toString()"
        x-on:click="open = ! open; search = ''; @if ($isSearchable) if (open) { $nextTick(() => $refs.selectSearch?.focus()); } @endif"
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
        class="absolute z-50 mt-1 w-full rounded-lg bg-white text-sm shadow-lg ring-1 ring-gray-950/5 focus:outline-none {{ $isSearchable ? 'overflow-hidden' : 'max-h-64 overflow-y-auto py-1' }} {{ $menuClass }}"
    >
        @if ($isSearchable)
            <div class="border-b border-gray-100 p-2">
                <input
                    x-ref="selectSearch"
                    x-model="search"
                    type="search"
                    placeholder="{{ $searchPlaceholder }}"
                    class="block h-9 w-full border-0 bg-transparent px-2 py-1.5 text-sm/6 text-gray-900 outline-none placeholder:text-gray-400 focus:border-0 focus:outline-none focus:ring-0"
                >
            </div>
            <div class="max-h-60 overflow-y-auto p-1">
        @endif

        <template
            x-for="option in outcraftFilterSelectOptions(outcraftNormalizeSelectOptions({{ $optionsExpression }}, @js($valueKey), @js($labelKey), @js($labelPrefix)), search)"
            :key="option.value"
        >
            <div>
                <div x-show="option.disabled" class="my-1 border-t border-gray-100"></div>
                <button
                    x-show="! option.disabled"
                    type="button"
                    class="flex w-full items-center justify-between gap-3 px-3 py-2 text-left text-gray-700 transition hover:bg-gray-50 hover:text-gray-950 {{ $isSearchable ? 'rounded-md' : '' }}"
                    :class="String({{ $selectedValueExpression }}) === String(option.value) ? @js($isSearchable ? 'bg-gray-50 text-gray-950' : 'bg-indigo-50 text-indigo-700') : ''"
                    x-on:click="{{ $assignmentExpression }}; open = false; search = ''; {{ $onChange }}"
                >
                    <span class="min-w-0 truncate" x-text="option.label"></span>
                    <span x-show="String({{ $selectedValueExpression }}) === String(option.value)" class="outcraft-icon shrink-0 !text-[16px] {{ $isSearchable ? 'text-gray-500' : 'text-indigo-600' }}">check</span>
                </button>
            </div>
        </template>

        <div
            x-show="outcraftFilterSelectOptions(outcraftNormalizeSelectOptions({{ $optionsExpression }}, @js($valueKey), @js($labelKey), @js($labelPrefix)), search).filter((option) => ! option.disabled).length === 0"
            class="px-3 py-2 text-sm text-gray-500"
        >
            No options found
        </div>

        @if ($isSearchable)
            </div>
        @endif
    </div>
</div>
