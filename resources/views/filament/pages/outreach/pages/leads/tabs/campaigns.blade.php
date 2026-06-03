        @include('filament.pages.outreach.pages.leads.filter-header', [
            'show' => "activeNav === 'Leads' && activeTab === 'Campaigns' && ! leadDetailOpen",
            'focusWhen' => "activeTab === 'Campaigns'",
            'inputRef' => 'campaignsOverlayInput',
            'title' => 'Campaign Runs',
            'description' => 'Browse and manage campaign runs for the selected campaign',
        ])

        <section data-card-surface x-cloak x-show="activeNav === 'Leads' && activeTab === 'Campaigns' && ! leadDetailOpen" class="mx-6 mb-6 mt-4 overflow-hidden rounded-lg bg-white shadow-sm ring-1 ring-gray-900/5">
            <div class="overflow-x-auto max-sm:overflow-visible">
                <table class="w-full border-collapse text-sm max-sm:block sm:min-w-[1080px] sm:table-fixed">
                    <thead class="max-sm:hidden">
                        <tr class="border-b border-gray-100 bg-gray-50 text-left text-sm font-semibold text-gray-950">
                            <th class="w-[150px] px-6 py-4">Campaign</th>
                            <th class="w-[300px] px-4 py-4">Lead</th>
                            <th class="w-[120px] px-4 py-4">Status</th>
                            <th class="w-[140px] px-4 py-4">First Interaction</th>
                            <th class="w-[130px] px-4 py-4">Follow Up</th>
                            <th class="w-[120px] px-4 py-4">Created</th>
                            <th class="w-[82px] px-4 py-4"></th>
                            <th class="w-[92px] py-4 pr-6 pl-4"></th>
                        </tr>
                    </thead>
                    <tbody class="max-sm:block">
                        <tr x-show="isLoading" x-transition.opacity>
                            <td colspan="8" class="h-[260px] bg-white px-8 py-12 text-center">
                                <div class="mx-auto flex size-[56px] items-center justify-center rounded-xl bg-white" x-html="tableLoaderSvg()"></div>
                            </td>
                        </tr>
                        <template x-for="(row, rowIndex) in loadingRows()" :key="'campaign-' + row.campaignName + row.name + row.phone + row.email + row.age">
                            <tr class="max-sm:grid max-sm:grid-cols-2 max-sm:items-start max-sm:gap-x-4 max-sm:gap-y-4 max-sm:px-4 max-sm:py-4" :class="rowIndex === loadingRows().length - 1 ? '' : 'border-b border-gray-100'">
                                <td class="px-6 py-4 align-top max-sm:order-2 max-sm:block max-sm:min-h-[56px] max-sm:p-0">
                                    <div class="flex h-[26px] items-center truncate text-sm font-medium text-gray-900" x-text="row.campaignName"></div>
                                    <div class="mt-1 hidden max-sm:block">
                                        <span class="outcraft-label inline-flex h-[26px] max-w-[104px] items-center rounded-full px-2 py-0 text-xs font-medium ring-1 ring-inset" :class="campaignBadgeClass(row.campaignStatus)">
                                            <span class="truncate" x-text="row.campaignStatus"></span>
                                        </span>
                                    </div>
                                </td>
                                <td class="px-4 py-4 align-top max-sm:order-1 max-sm:col-span-2 max-sm:block max-sm:min-h-[56px] max-sm:p-0">
                                    <div x-show="row.name" class="group relative inline-flex h-[26px] max-w-full items-center">
                                        <span class="truncate text-sm font-medium text-gray-900" x-text="row.name"></span>
                                        <span class="pointer-events-none absolute bottom-full left-1/2 z-50 mb-2 -translate-x-1/2 translate-y-1 whitespace-nowrap rounded-lg bg-gray-900 px-3 py-2 text-xs font-medium text-white opacity-0 shadow-sm transition group-hover:translate-y-0 group-hover:opacity-100">
                                            <span x-text="row.name"></span>
                                            <span class="absolute left-1/2 top-full size-2 -translate-x-1/2 -translate-y-1 rotate-45 bg-gray-900"></span>
                                        </span>
                                    </div>
                                    <div class="flex h-[26px] min-w-0 flex-nowrap items-center gap-x-2 text-xs text-gray-500" :class="row.name ? 'mt-1' : ''">
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
                                </td>
                                <td class="px-4 py-4 align-top max-sm:hidden">
                                    <span class="outcraft-label inline-flex h-[26px] max-w-[104px] items-center rounded-full px-2 py-0 text-xs font-medium ring-1 ring-inset" :class="campaignBadgeClass(row.campaignStatus)">
                                        <span class="truncate" x-text="row.campaignStatus"></span>
                                    </span>
                                </td>
                                <td class="px-4 py-4 align-top max-sm:order-4 max-sm:block max-sm:min-h-[56px] max-sm:p-0">
                                    <div class="mb-1 hidden h-[26px] items-center text-sm font-medium text-gray-900 max-sm:flex">First</div>
                                    <span class="outcraft-label inline-flex h-[26px] max-w-[116px] items-center rounded-full px-2 py-0 text-xs font-medium ring-1 ring-inset" :class="campaignBadgeClass(row.firstInteraction)">
                                        <span class="truncate" x-text="row.firstInteraction"></span>
                                    </span>
                                </td>
                                <td class="px-4 py-4 align-top max-sm:order-5 max-sm:block max-sm:min-h-[56px] max-sm:p-0">
                                    <div class="mb-1 hidden h-[26px] items-center text-sm font-medium text-gray-900 max-sm:flex">Follow-Up</div>
                                    <span class="outcraft-label inline-flex h-[26px] max-w-[110px] items-center rounded-full px-2 py-0 text-xs font-medium ring-1 ring-inset" :class="campaignBadgeClass(row.followUp)">
                                        <span class="truncate" x-text="row.followUp"></span>
                                    </span>
                                </td>
                                <td class="px-4 py-4 align-top text-right max-sm:order-3 max-sm:block max-sm:min-h-[56px] max-sm:p-0 max-sm:text-left">
                                    <span class="group relative inline-flex flex-col items-end max-sm:items-start">
                                        <span class="flex h-[26px] items-center text-sm font-medium text-gray-900">Created</span>
                                        <span class="mt-1 flex h-[26px] items-center text-xs text-gray-500" x-text="campaignAge(row)"></span>
                                        <span class="pointer-events-none absolute bottom-full left-1/2 z-50 mb-2 -translate-x-1/2 translate-y-1 whitespace-nowrap rounded-lg bg-gray-900 px-3 py-2 text-xs font-medium text-white opacity-0 shadow-sm transition group-hover:translate-y-0 group-hover:opacity-100">
                                            <span x-text="row.ageTooltip"></span>
                                            <span class="absolute left-1/2 top-full size-2 -translate-x-1/2 -translate-y-1 rotate-45 bg-gray-900"></span>
                                        </span>
                                    </span>
                                </td>
                                <td class="px-4 py-4 align-top text-right font-semibold text-gray-600 transition hover:text-gray-950 max-sm:hidden">Flow</td>
                                <td class="py-4 pr-6 pl-4 align-top text-right max-sm:hidden">
                                    <button type="button" x-on:click="openLeadDetails(row)" class="font-semibold text-gray-600 transition hover:text-gray-950">View</button>
                                </td>
                            </tr>
                        </template>
                        <tr x-show="! isLoading && filteredRows().length === 0">
                            <td colspan="8" class="px-8 py-16 text-center text-gray-500">No campaign run records match these filters.</td>
                        </tr>
                    </tbody>
                </table>
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
