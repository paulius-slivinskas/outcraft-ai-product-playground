        @include('filament.pages.outreach.pages.leads.filter-header', [
            'show' => "activeNav === 'Leads' && activeTab === 'Leads' && ! leadDetailOpen",
            'focusWhen' => "activeTab === 'Leads'",
            'inputRef' => 'leadsOverlayInput',
            'title' => 'Leads',
            'description' => 'Browse and manage all your leads',
        ])

        <section data-card-surface x-cloak x-show="activeNav === 'Leads' && activeTab === 'Leads' && ! leadDetailOpen" class="mx-6 mb-6 mt-4 overflow-hidden rounded-lg bg-white shadow-sm ring-1 ring-gray-900/5">
            <div class="flex min-h-[74px] items-center justify-between gap-3 bg-white px-6">
                <label class="inline-flex items-center gap-3 text-sm font-semibold text-gray-700">
                    <span class="grid size-4 shrink-0 grid-cols-1">
                        <input
                            type="checkbox"
                            :checked="allVisibleLeadsSelected()"
                            x-effect="$el.indeterminate = someVisibleLeadsSelected()"
                            x-on:change="toggleVisibleLeadSelection()"
                            class="col-start-1 row-start-1 appearance-none rounded border border-gray-300 bg-white checked:border-indigo-600 checked:bg-indigo-600 indeterminate:border-indigo-600 indeterminate:bg-indigo-600 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
                        >
                        <svg x-show="allVisibleLeadsSelected()" viewBox="0 0 14 14" fill="none" class="pointer-events-none col-start-1 row-start-1 size-3 self-center justify-self-center stroke-white">
                            <path d="M3 8L6 11L11 3.5" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        <svg x-show="someVisibleLeadsSelected()" viewBox="0 0 14 14" fill="none" class="pointer-events-none col-start-1 row-start-1 size-3 self-center justify-self-center stroke-white">
                            <path d="M3 7H11" stroke-width="2" stroke-linecap="round" />
                        </svg>
                    </span>
                    <span>Select All</span>
                </label>

                <div x-show="selectedLeadIds.length === 0" class="flex items-center justify-end gap-3">
                    <button type="button" x-on:click="addFilter('Review Required')" class="inline-flex h-9 items-center gap-2 rounded-lg border border-gray-200 bg-white px-3 text-sm font-semibold text-gray-800 shadow-sm transition hover:bg-gray-50">
                        <span class="outcraft-icon !text-[18px] text-gray-500">manage_search</span>
                        Review Required
                    </button>
                    <div class="relative inline-flex" x-on:click.outside="leadAddMenuOpen = false">
                        <div data-outcraft-field-control class="inline-flex h-10 overflow-hidden rounded-md bg-white shadow-sm outline outline-1 -outline-offset-1 outline-gray-300 transition focus-within:outline-2 focus-within:-outline-offset-2 focus-within:outline-indigo-600">
                            <button type="button" x-on:click="leadAddMenuOpen = false" class="inline-flex items-center gap-2 px-3 text-sm font-semibold text-gray-800 transition hover:bg-gray-50">
                                <span class="outcraft-icon !text-[18px] text-gray-500">add</span>
                                Add Lead
                            </button>
                            <button type="button" x-on:click="leadAddMenuOpen = ! leadAddMenuOpen" class="inline-flex w-10 items-center justify-center border-l border-gray-200 bg-white text-gray-500 transition hover:bg-gray-50 hover:text-gray-700" aria-label="More lead actions">
                                <span class="outcraft-icon !text-[18px]">keyboard_arrow_down</span>
                            </button>
                        </div>
                        <div x-cloak x-show="leadAddMenuOpen" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="opacity-0 translate-y-1" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-1" class="absolute right-0 top-11 z-40 w-44 rounded-md bg-white p-1 text-sm shadow-lg ring-1 ring-gray-900/10">
                            <button type="button" x-on:click="leadAddMenuOpen = false" class="flex w-full items-center gap-2 rounded-md px-3 py-2 text-left font-medium text-gray-700 transition hover:bg-gray-50 hover:text-gray-900">
                                <span class="outcraft-icon !text-[18px] text-gray-500">upload</span>
                                Import CSV
                            </button>
                        </div>
                    </div>
                </div>

                <div
                    x-cloak
                    x-show="selectedLeadIds.length > 0"
                    x-transition:enter="transition ease-out duration-150"
                    x-transition:enter-start="opacity-0 translate-y-1"
                    x-transition:enter-end="opacity-100 translate-y-0"
                    x-transition:leave="transition ease-in duration-100"
                    x-transition:leave-start="opacity-100 translate-y-0"
                    x-transition:leave-end="opacity-0 translate-y-1"
                    class="relative flex items-center justify-end gap-3"
                >
                    <span class="text-sm font-medium text-gray-500" x-text="`${selectedLeadIds.length} Selected`"></span>
                    <button type="button" x-on:click.stop="$wire.mountAction('deleteSelectedLeads', { ids: Array.from(selectedLeadIds) })" class="inline-flex h-9 items-center gap-2 rounded-md bg-white px-3 text-sm font-semibold text-red-600 shadow-sm ring-1 ring-inset ring-red-200 transition hover:bg-red-50 hover:text-red-700">
                        <span class="outcraft-icon !text-[18px]">delete</span>
                        Delete
                    </button>
                    <button type="button" x-on:click="openLeadAssignModal()" class="inline-flex h-9 items-center gap-2 rounded-md bg-white px-3 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 transition hover:bg-gray-50 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                        Assign Campaign
                        <span class="outcraft-icon !text-[18px] text-gray-500">arrow_forward</span>
                    </button>
                </div>
            </div>

            <div
                x-cloak
                x-show="leadAssignModalOpen"
                x-transition.opacity
                x-on:keydown.escape.window="closeLeadAssignModal()"
                class="fixed inset-0 z-50 flex items-center justify-center bg-gray-950/30 p-4"
            >
                <div x-on:click="closeLeadAssignModal()" class="absolute inset-0"></div>
                <div
                    x-show="leadAssignModalOpen"
                    x-transition:enter="transition ease-out duration-150"
                    x-transition:enter-start="opacity-0 translate-y-3 scale-95"
                    x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                    x-transition:leave="transition ease-in duration-100"
                    x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                    x-transition:leave-end="opacity-0 translate-y-2 scale-95"
                    class="relative flex max-h-[min(680px,calc(100vh-2rem))] w-full max-w-2xl flex-col overflow-hidden rounded-lg bg-white shadow-xl ring-1 ring-gray-900/10"
                    role="dialog"
                    aria-modal="true"
                    aria-labelledby="assign-campaign-title"
                >
                    <div class="border-b border-gray-100 px-6 py-5">
                        <h2 id="assign-campaign-title" class="text-base font-semibold text-gray-900">Assign Campaign</h2>
                        <p class="mt-1 text-sm leading-6 text-gray-500" x-text="`Choose a campaign for ${selectedLeadIds.length} selected lead${selectedLeadIds.length === 1 ? '' : 's'}.`"></p>
                    </div>

                    <div class="min-h-0 flex-1 overflow-y-auto px-6 py-4">
                        <div class="space-y-2">
                            <template x-for="campaign in campaignAssignmentOptions()" :key="campaign.name">
                                <button
                                    type="button"
                                    x-on:click="leadAssignCampaignName = campaign.name"
                                    class="flex w-full items-start gap-3 rounded-lg border p-4 text-left transition focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
                                    :class="leadAssignCampaignName === campaign.name ? 'border-indigo-600 bg-indigo-50/50' : 'border-gray-200 bg-white hover:bg-gray-50'"
                                >
                                    <span class="mt-0.5 grid size-4 shrink-0 grid-cols-1">
                                        <span class="col-start-1 row-start-1 rounded-full border" :class="leadAssignCampaignName === campaign.name ? 'border-indigo-600 bg-indigo-600' : 'border-gray-300 bg-white'"></span>
                                        <span x-show="leadAssignCampaignName === campaign.name" class="col-start-1 row-start-1 size-1.5 self-center justify-self-center rounded-full bg-white"></span>
                                    </span>
                                    <span class="min-w-0 flex-1">
                                        <span class="block truncate text-sm font-semibold text-gray-900" x-text="campaign.name"></span>
                                        <span class="mt-1 flex flex-wrap items-center gap-2 text-xs leading-5 text-gray-500">
                                            <span class="inline-flex rounded-md px-2 py-1 font-medium ring-1 ring-inset" :class="campaign.status === 'Running' ? 'bg-green-50 text-green-700 ring-green-600/20' : 'bg-gray-50 text-gray-600 ring-gray-500/10'" x-text="campaign.status"></span>
                                            <span x-show="campaign.change" class="inline-flex rounded-md bg-amber-50 px-2 py-1 font-medium text-amber-700 ring-1 ring-inset ring-amber-600/20" x-text="campaign.change"></span>
                                            <span x-text="campaign.modified"></span>
                                        </span>
                                    </span>
                                    <span x-show="leadAssignCampaignName === campaign.name" class="outcraft-icon !text-[20px] text-indigo-600">check</span>
                                </button>
                            </template>
                        </div>
                    </div>

                    <div class="flex items-center justify-end gap-3 border-t border-gray-100 bg-gray-50 px-6 py-4">
                        <button type="button" x-on:click="closeLeadAssignModal()" class="inline-flex h-10 items-center justify-center rounded-md bg-white px-4 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 transition hover:bg-gray-50">Cancel</button>
                        <button type="button" x-on:click="assignSelectedLeadsToCampaign()" :disabled="! leadAssignCampaignName" class="inline-flex h-10 items-center justify-center rounded-md bg-indigo-600 px-4 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-500 disabled:cursor-not-allowed disabled:opacity-40 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Assign And Dispatch</button>
                    </div>
                </div>
            </div>

            <div class="overflow-x-auto max-sm:overflow-visible">
                <ul role="list" class="divide-y divide-gray-100 sm:min-w-[1080px]">
                    <li x-show="isLoading" x-transition.opacity class="h-[260px] bg-white px-8 py-12 text-center">
                        <div class="mx-auto flex size-[56px] items-center justify-center rounded-xl bg-white" x-html="tableLoaderSvg()"></div>
                    </li>
                    <template x-for="row in loadingRows()" :key="'lead-' + row.name + row.phone + row.email + row.age">
                        <li x-on:click="openLeadDetails(row)" class="flex cursor-pointer items-start justify-between gap-x-4 px-6 py-4 transition-colors max-sm:px-4 max-sm:py-5" :class="isLeadSelected(row) ? 'hover:bg-gray-100' : 'hover:bg-gray-50'">
                            <div class="pt-1">
                                <label x-on:click.stop class="grid size-4 shrink-0 grid-cols-1">
                                    <input
                                        type="checkbox"
                                        :checked="isLeadSelected(row)"
                                        x-on:change="toggleLeadSelection(row)"
                                        :aria-label="`Select ${row.name || 'lead'}`"
                                        class="col-start-1 row-start-1 appearance-none rounded border border-gray-300 bg-white checked:border-indigo-600 checked:bg-indigo-600 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
                                    >
                                    <svg x-show="isLeadSelected(row)" viewBox="0 0 14 14" fill="none" class="pointer-events-none col-start-1 row-start-1 size-3 self-center justify-self-center stroke-white">
                                        <path d="M3 8L6 11L11 3.5" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </label>
                            </div>
                            <div class="grid min-w-0 flex-1 grid-cols-[minmax(0,1fr)_minmax(0,0.5fr)_minmax(0,0.5fr)] items-start gap-x-4 max-sm:grid-cols-2 max-sm:gap-y-5">
                            <div class="min-w-0 max-sm:col-span-2 max-sm:min-h-[56px]">
                                <div class="flex h-[26px] min-w-0 items-center gap-2">
                                    <p x-show="row.name" class="truncate text-sm font-medium text-gray-900" x-text="row.name"></p>
                                    <span class="outcraft-label inline-flex h-[26px] max-w-[150px] shrink-0 items-center rounded-full px-2 py-0 text-xs font-medium ring-1 ring-inset" :class="leadStateClass(row.state)">
                                        <span class="truncate" x-text="row.state"></span>
                                    </span>
                                </div>
                                <div class="mt-1 flex h-[26px] min-w-0 flex-nowrap items-center gap-x-2 text-xs text-gray-500">
                                    <button type="button" x-show="row.email" x-on:click.stop="copyContact(row.email)" class="group relative inline-flex min-w-0 max-w-full text-left transition hover:text-gray-900">
                                        <span class="truncate" x-text="row.email"></span>
                                        <span class="pointer-events-none absolute bottom-full left-1/2 z-50 mb-2 -translate-x-1/2 translate-y-1 whitespace-nowrap rounded-lg bg-gray-900 px-3 py-2 text-xs font-medium text-white opacity-0 shadow-sm transition group-hover:translate-y-0 group-hover:opacity-100">
                                            <span x-text="row.email"></span>
                                            <span class="ml-2 text-white/70">Click to Copy</span>
                                            <span class="absolute left-1/2 top-full size-2 -translate-x-1/2 -translate-y-1 rotate-45 bg-gray-900"></span>
                                        </span>
                                    </button>
                                    <span x-show="row.email && row.phone" class="shrink-0 text-gray-300">·</span>
                                    <button type="button" x-show="row.phone" x-on:click.stop="copyContact(row.phone)" class="group relative inline-flex min-w-0 shrink-0 text-left transition hover:text-gray-900">
                                        <span class="truncate" x-text="row.phone"></span>
                                        <span class="pointer-events-none absolute bottom-full left-1/2 z-50 mb-2 -translate-x-1/2 translate-y-1 whitespace-nowrap rounded-lg bg-gray-900 px-3 py-2 text-xs font-medium text-white opacity-0 shadow-sm transition group-hover:translate-y-0 group-hover:opacity-100">
                                            <span x-text="row.phone"></span>
                                            <span class="ml-2 text-white/70">Click to Copy</span>
                                            <span class="absolute left-1/2 top-full size-2 -translate-x-1/2 -translate-y-1 rotate-45 bg-gray-900"></span>
                                        </span>
                                    </button>
                                </div>
                            </div>

                            <div class="min-w-0 max-sm:min-h-[56px]">
                                <div class="flex h-[26px] items-center gap-x-2 text-sm font-medium text-gray-900">
                                    <span class="inline-flex size-4 shrink-0 overflow-hidden rounded-full ring-1 ring-gray-900/5">
                                        <img :src="countryFlagUrl(row.countryFlagCode || row.country)" :alt="`${row.country || 'US'} flag`" class="size-full object-cover" loading="lazy">
                                    </span>
                                    <span x-text="row.phoneCountry"></span>
                                </div>
                                <p class="mt-1 flex h-[26px] items-center truncate text-xs text-gray-500" x-text="row.timezone"></p>
                            </div>

                            <div class="min-w-0 text-right max-sm:min-h-[56px] max-sm:text-left">
                                <span class="group relative inline-flex flex-col items-end max-sm:items-start">
                                    <span class="flex h-[26px] items-center text-sm font-medium text-gray-900">Created</span>
                                    <span class="mt-1 flex h-[26px] items-center text-xs text-gray-500" x-text="leadAge(row)"></span>
                                    <span class="pointer-events-none absolute bottom-full right-0 z-50 mb-2 translate-y-1 whitespace-nowrap rounded-lg bg-gray-900 px-3 py-2 text-xs font-medium text-white opacity-0 shadow-sm transition group-hover:translate-y-0 group-hover:opacity-100">
                                        <span x-text="row.ageTooltip"></span>
                                        <span class="absolute right-6 top-full size-2 -translate-y-1 rotate-45 bg-gray-900"></span>
                                    </span>
                                </span>
                            </div>
                            </div>

                        </li>
                    </template>
                    <li x-show="! isLoading && filteredRows().length === 0" class="px-8 py-16 text-center text-gray-500">No leads match these filters.</li>
                </ul>
            </div>
            <div class="flex items-center justify-between border-t border-gray-100 bg-white px-4 py-3 sm:px-6">
                <div class="flex flex-1 items-center">
                    <label class="flex items-center gap-3 text-sm text-gray-700">
                        <span>Rows Per Page</span>
                        <span class="w-24">
                            <x-outcraft.select
                                model="perPage"
                                options="perPageOptions"
                                numeric
                                button-class="h-9"
                                on-change="page = 1"
                            />
                        </span>
                    </label>
                </div>
                <div class="flex flex-1 justify-center text-sm text-gray-700">
                    <span x-text="paginationSummary()"></span>
                </div>
                <div class="flex flex-1 justify-end">
                    <nav aria-label="Pagination" class="isolate inline-flex -space-x-px rounded-md shadow-sm">
                        <button type="button" x-on:click="page = Math.max(1, page - 1)" :disabled="page === 1" class="relative inline-flex size-9 items-center justify-center rounded-l-md text-gray-400 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0 disabled:cursor-not-allowed disabled:opacity-40">
                            <span class="sr-only">Previous</span>
                            <svg viewBox="0 0 20 20" fill="currentColor" data-slot="icon" aria-hidden="true" class="size-5">
                                <path d="M11.78 5.22a.75.75 0 0 1 0 1.06L8.06 10l3.72 3.72a.75.75 0 1 1-1.06 1.06l-4.25-4.25a.75.75 0 0 1 0-1.06l4.25-4.25a.75.75 0 0 1 1.06 0Z" clip-rule="evenodd" fill-rule="evenodd" />
                            </svg>
                        </button>
                        <template x-for="pageNumber in visiblePageNumbers()" :key="pageNumber">
                            <span>
                                <span x-show="pageNumber === '...'" class="relative inline-flex size-9 items-center justify-center text-sm font-semibold text-gray-700 ring-1 ring-inset ring-gray-300 focus:outline-offset-0">...</span>
                                <button x-show="pageNumber !== '...'" type="button" x-on:click="page = pageNumber" class="relative inline-flex size-9 items-center justify-center text-sm font-semibold focus:z-20 focus:outline-offset-0" :class="page === pageNumber ? 'z-10 bg-indigo-600 text-white focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600' : 'text-gray-900 ring-1 ring-inset ring-gray-300 hover:bg-gray-50'" x-text="pageNumber"></button>
                            </span>
                        </template>
                        <button type="button" x-on:click="page = Math.min(totalPages(), page + 1)" :disabled="page === totalPages()" class="relative inline-flex size-9 items-center justify-center rounded-r-md text-gray-400 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0 disabled:cursor-not-allowed disabled:opacity-40">
                            <span class="sr-only">Next</span>
                            <svg viewBox="0 0 20 20" fill="currentColor" data-slot="icon" aria-hidden="true" class="size-5">
                                <path d="M8.22 5.22a.75.75 0 0 1 1.06 0l4.25 4.25a.75.75 0 0 1 0 1.06l-4.25 4.25a.75.75 0 0 1-1.06-1.06L11.94 10 8.22 6.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" fill-rule="evenodd" />
                            </svg>
                        </button>
                    </nav>
                </div>
            </div>
        </section>
