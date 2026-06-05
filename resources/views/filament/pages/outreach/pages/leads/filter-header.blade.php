        <section x-cloak x-show="{!! $show !!}" class="mx-6 mt-5">
            <div>
                <h1 class="text-xl font-bold leading-tight tracking-normal">{{ $title }}</h1>
                @if (! empty($description))
                    <p class="mt-1 max-w-2xl text-sm leading-6 text-gray-500">{{ $description }}</p>
                @endif
            </div>

            <div class="mt-4 flex flex-col gap-3 xl:flex-row xl:items-start xl:justify-between">
                <div class="order-1 w-full xl:w-64 xl:flex-none">
                    <x-outcraft.select
                        class="w-full"
                        model="campaign"
                        options="leadCampaignOptions()"
                        on-change="setLeadCampaign(campaign)"
                        button-class="h-10 font-semibold"
                        menu-class="left-0 w-full"
                        searchable="true"
                        search-placeholder="Start typing to search..."
                    />
                </div>

                <div class="relative order-3 min-w-0 flex-1 xl:order-2" x-on:click.outside="searchOpen = false">
                    <div data-outcraft-field-control class="rounded-md bg-white text-sm/6 text-gray-900 shadow-sm outline outline-1 -outline-offset-1 outline-gray-300 transition hover:bg-gray-50 focus-within:outline-2 focus-within:-outline-offset-2 focus-within:outline-indigo-600">
                        <div class="flex min-h-10 items-center px-3">
                            <input
                                x-model="query"
                                x-ref="{{ $inputRef }}"
                                x-init="$watch('searchOpen', value => value && {!! $focusWhen !!} && $nextTick(() => $refs.{{ $inputRef }}.focus()))"
                                x-on:focus="searchOpen = true"
                                x-on:keydown.escape="searchOpen = false"
                                x-on:keydown.enter.prevent="addFirstSuggestion()"
                                class="h-full w-full border-0 bg-transparent p-0 text-sm/6 text-gray-900 outline-none ring-0 placeholder:text-gray-400 focus:border-0 focus:outline-none focus:ring-0"
                                placeholder="Filter By Tags"
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
                            </div>
                        </div>
                    </div>

                    <div x-cloak x-show="searchOpen" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95" class="absolute left-0 right-0 top-11 z-30 rounded-lg bg-white p-2 text-sm shadow-lg ring-1 ring-gray-950/5">
                        <div class="filter-scroll max-h-[215px] space-y-1 overflow-y-auto pr-1">
                            <template x-for="group in groupedSuggestions()" :key="group.column">
                                <div>
                                    <div class="px-1 py-2 text-sm font-semibold" x-text="group.column"></div>
                                    <template x-for="value in group.values" :key="group.column + value">
                                        <button type="button" x-on:click="addFilter(value)" class="block w-full rounded-md px-3 py-2 text-left text-sm/6 text-gray-700 transition hover:bg-gray-50 hover:text-gray-950" x-text="value"></button>
                                    </template>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>

                <div class="order-2 flex w-full flex-col gap-3 sm:flex-row sm:items-start sm:justify-end xl:order-3 xl:w-auto xl:flex-none">
                    <x-outcraft.select
                        class="w-full sm:w-44 xl:w-44"
                        model="activeLeadRange"
                        options="leadRanges()"
                        on-change="setLeadRange(activeLeadRange)"
                        button-class="h-10 font-semibold"
                        menu-class="right-0 w-full sm:w-56"
                    />
                    <div
                        x-cloak
                        x-show="activeLeadRange === 'Custom range'"
                        x-transition
                        x-data="{ range: $wire.entangle('leadsDateRange').live }"
                        x-effect="
                            leadsCustomRangeStart = range?.start || leadsCustomRangeStart;
                            leadsCustomRangeEnd = range?.end || leadsCustomRangeEnd;
                        "
                        data-outcraft-date-range-picker="true"
                        class="w-full sm:w-[18rem]"
                    >
                        {!! $leadsDateRangePicker->toHtml() !!}
                    </div>
                </div>
            </div>
        </section>
