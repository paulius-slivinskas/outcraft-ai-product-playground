        <section x-cloak x-show="{!! $show !!}" class="mx-6 mt-5">
            <div class="grid min-h-[92px] grid-cols-[250px_minmax(0,1fr)_230px] items-start gap-6">
                <div>
                    <h1 class="text-xl font-bold leading-tight tracking-normal">{{ $title }}</h1>
                    @if (! empty($description))
                        <p class="mt-1 max-w-[240px] text-sm leading-6 text-gray-500">{{ $description }}</p>
                    @endif
                </div>

                <div class="relative" x-on:click.outside="searchOpen = false">
                    <div class="rounded-lg bg-white shadow-sm ring-1 ring-gray-900/5">
                        <div class="flex min-h-10 items-center px-4">
                            <input
                                x-model="query"
                                x-on:focus="searchOpen = true"
                                x-on:keydown.escape="searchOpen = false"
                                x-on:keydown.enter.prevent="addFirstSuggestion()"
                                class="w-full border-0 bg-transparent text-sm outline-none ring-0 placeholder:text-gray-400 focus:ring-0"
                                placeholder="Filter anything"
                            >
                        </div>
                        <div x-show="filters.length > 0" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-3" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-2" class="flex min-h-10 items-center gap-2 border-t border-gray-200 px-4">
                            <template x-for="tag in filters" :key="tag">
                                <button type="button" x-on:click="removeFilter(tag)" class="inline-flex items-center gap-1 rounded-lg border border-gray-200 bg-gray-50 px-2 py-1 text-sm leading-none text-gray-600">
                                    <span x-text="tag"></span>
                                    <span class="outcraft-icon !text-[14px] text-gray-400">close</span>
                                </button>
                            </template>
                            <div class="ml-auto flex items-center gap-4">
                                <button type="button" class="text-sm font-semibold text-gray-500 hover:text-gray-900" x-on:click="clearSearchTags()">Clear</button>
                                <button type="button" class="text-sm font-semibold text-gray-600 hover:text-gray-900" x-on:click="savePreset()">Save Preset</button>
                            </div>
                        </div>
                    </div>

                    <div x-cloak x-show="searchOpen" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-3" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-2" class="absolute left-0 right-0 top-0 z-30 rounded-md bg-white p-5 shadow-lg ring-1 ring-gray-900/5">
                        <input x-model="query" x-ref="{{ $inputRef }}" x-init="$watch('searchOpen', value => value && {!! $focusWhen !!} && $nextTick(() => $refs.{{ $inputRef }}.focus()))" class="w-full border-0 bg-transparent text-base outline-none ring-0 focus:ring-0" placeholder="Filter anything">
                        <div class="filter-scroll mt-4 max-h-[215px] space-y-1 overflow-y-auto pr-2">
                            <template x-for="group in groupedSuggestions()" :key="group.column">
                                <div>
                                    <div class="px-1 py-2 text-sm font-semibold" x-text="group.column"></div>
                                    <template x-for="value in group.values" :key="group.column + value">
                                        <button type="button" x-on:click="addFilter(value)" class="block w-full rounded-lg px-1 py-2 text-left text-sm hover:bg-gray-50" x-text="value"></button>
                                    </template>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>

                <div class="relative ml-auto" x-on:click.outside="presetOpen = false">
                    <button
                        type="button"
                        data-outcraft-field-control
                        data-campaign-field
                        x-on:click="presetOpen = ! presetOpen"
                        class="flex h-10 min-w-[175px] items-center justify-between gap-3 rounded-md bg-white py-1.5 pl-3 pr-2 text-left text-sm/6 font-semibold text-gray-900 shadow-sm outline outline-1 -outline-offset-1 outline-gray-300 transition hover:bg-gray-50 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600"
                    >
                        <span x-text="selectedPresetName"></span>
                        <span class="outcraft-icon text-gray-600">keyboard_arrow_down</span>
                    </button>
                    <div x-cloak x-show="presetOpen" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-3" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-2" class="absolute right-0 top-12 z-40 w-[230px] overflow-hidden rounded-md bg-white p-1 text-sm text-gray-900 shadow-lg ring-1 ring-gray-900/5">
                        <button type="button" x-on:click="clearFilters()" class="block w-full rounded-lg px-3 py-2 text-left font-semibold hover:bg-gray-50">Clear Filters</button>
                        <template x-for="preset in presets" :key="preset.name">
                            <div class="group flex items-center rounded-lg hover:bg-gray-50">
                                <button type="button" x-on:click="applyPreset(preset)" class="flex min-w-0 flex-1 items-center justify-between px-3 py-2 text-left">
                                    <span class="truncate" x-text="preset.name"></span>
                                    <span x-show="selectedPresetName === preset.name" class="outcraft-icon ml-3 shrink-0 text-blue-500">check</span>
                                </button>
                                <button type="button" x-on:click.stop="deletePreset(preset)" class="mr-2 flex size-8 shrink-0 items-center justify-center rounded-lg text-gray-400 opacity-0 transition hover:bg-red-50 hover:text-red-600 group-hover:opacity-100" :aria-label="`Delete ${preset.name}`">
                                    <span class="outcraft-icon !text-[18px]">delete</span>
                                </button>
                            </div>
                        </template>
                    </div>
                </div>
            </div>
        </section>
