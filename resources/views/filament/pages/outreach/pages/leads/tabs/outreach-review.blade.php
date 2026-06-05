        @include('filament.pages.outreach.pages.leads.filter-header', [
            'show' => "activeNav === 'Leads' && activeTab === 'Outreach Review' && ! leadDetailOpen",
            'focusWhen' => "activeTab === 'Outreach Review'",
            'inputRef' => 'outreachReviewOverlayInput',
            'title' => 'Interactions',
            'description' => 'Review all conversations and engagement across channels per lead.',
        ])

        <section data-card-surface x-cloak x-show="activeNav === 'Leads' && activeTab === 'Outreach Review' && ! leadDetailOpen" class="mx-6 mb-6 mt-4 overflow-hidden rounded-lg bg-white shadow-sm ring-1 ring-gray-900/5">
            <div class="overflow-x-auto max-sm:overflow-visible">
                <table class="relative w-full border-collapse text-sm max-sm:block sm:min-w-[1040px] sm:table-fixed">
                    <colgroup>
                        <col class="w-1/3">
                        <col>
                        <col>
                        <col>
                        <col>
                    </colgroup>
                    <tbody class="max-sm:block">
                        <tr x-show="isLoading" x-transition.opacity>
                            <td colspan="5" class="h-[260px] bg-white px-8 py-12 text-center">
                                <div data-card-ignore class="mx-auto flex size-[56px] items-center justify-center" x-html="tableLoaderSvg()"></div>
                            </td>
                        </tr>
                        <template x-for="(row, rowIndex) in loadingRows()" :key="'outreach-review-' + row.name + row.email + row.age + row.result">
                            <tr x-on:click="openLeadDetails(row)" class="cursor-pointer transition-colors hover:bg-gray-50 max-sm:grid max-sm:grid-cols-2 max-sm:items-start max-sm:gap-x-4 max-sm:gap-y-4 max-sm:px-4 max-sm:py-4" :class="rowIndex === loadingRows().length - 1 ? '' : 'border-b border-gray-100'">
                                <td class="px-6 py-4 align-top max-sm:order-1 max-sm:col-span-2 max-sm:block max-sm:p-0">
                                    <div x-show="row.name" class="flex h-[26px] items-center truncate text-sm font-medium text-gray-900" x-text="row.name"></div>
                                    <div class="flex h-[26px] min-w-0 flex-nowrap items-center gap-x-2 text-xs text-gray-500" :class="row.name ? 'mt-1' : ''">
                                        <button type="button" x-on:click.stop="copyContact(row.email)" x-show="row.email" class="group relative inline-flex min-w-0 max-w-full cursor-pointer text-left transition hover:text-gray-900">
                                            <span class="truncate" x-text="row.email"></span>
                                            <span class="pointer-events-none absolute bottom-full left-1/2 z-50 mb-2 -translate-x-1/2 translate-y-1 whitespace-nowrap rounded-lg bg-gray-900 px-3 py-2 text-xs font-medium text-white opacity-0 shadow-sm transition group-hover:translate-y-0 group-hover:opacity-100">
                                                <span x-text="row.email"></span>
                                                <span class="ml-2 text-white/70" x-text="copyTooltipLabel($el.previousElementSibling?.textContent)"></span>
                                                <span class="absolute left-1/2 top-full size-2 -translate-x-1/2 -translate-y-1 rotate-45 bg-gray-900"></span>
                                            </span>
                                        </button>
                                        <span x-show="row.email && row.phone" class="shrink-0 text-gray-300">·</span>
                                        <button type="button" x-on:click.stop="copyContact(row.phone)" x-show="row.phone" class="group relative inline-flex min-w-0 shrink-0 cursor-pointer text-left transition hover:text-gray-900">
                                            <span class="truncate" x-text="row.phone"></span>
                                            <span class="pointer-events-none absolute bottom-full left-1/2 z-50 mb-2 -translate-x-1/2 translate-y-1 whitespace-nowrap rounded-lg bg-gray-900 px-3 py-2 text-xs font-medium text-white opacity-0 shadow-sm transition group-hover:translate-y-0 group-hover:opacity-100">
                                                <span x-text="row.phone"></span>
                                                <span class="ml-2 text-white/70" x-text="copyTooltipLabel($el.previousElementSibling?.textContent)"></span>
                                                <span class="absolute left-1/2 top-full size-2 -translate-x-1/2 -translate-y-1 rotate-45 bg-gray-900"></span>
                                            </span>
                                        </button>
                                    </div>
                                </td>
                                <td class="px-4 py-4 align-top max-sm:order-2 max-sm:block max-sm:min-h-[56px] max-sm:p-0">
                                    <div class="flex h-[26px] items-center truncate text-sm font-medium text-gray-900" x-text="row.channel"></div>
                                    <div class="mt-1 flex min-w-0 flex-wrap items-center gap-2">
                                        <span class="outcraft-label inline-flex h-[26px] max-w-[112px] items-center rounded-full bg-gray-50 px-2 py-0 text-xs font-medium text-gray-600 ring-1 ring-inset ring-gray-500/10">
                                            <span class="truncate" x-text="row.direction"></span>
                                        </span>
                                        <button
                                            type="button"
                                            x-show="row.channel !== 'Call'"
                                            x-on:mouseenter="showFloatingTooltip($event, row.contentPreview, 320)"
                                            x-on:mouseleave="hideFloatingTooltip()"
                                            x-on:focus="showFloatingTooltip($event, row.contentPreview, 320)"
                                            x-on:blur="hideFloatingTooltip()"
                                            x-on:click.stop="openLeadDetails(row)"
                                            class="inline-flex text-left"
                                        >
                                            <span class="outcraft-label inline-flex h-[26px] max-w-[92px] cursor-pointer items-center rounded-full bg-gray-50 px-2 py-0 text-xs font-medium text-gray-600 ring-1 ring-inset ring-gray-500/10 transition group-hover:text-gray-950">
                                                <span class="truncate">View</span>
                                            </span>
                                        </button>
                                        <span
                                            x-show="row.channel === 'Call'"
                                            x-on:mouseenter="showFloatingTooltip($event, 'Listen', 104)"
                                            x-on:mouseleave="hideFloatingTooltip()"
                                            x-on:click.stop
                                            class="inline-flex"
                                        >
                                            <span class="outcraft-label inline-flex h-[26px] max-w-[92px] cursor-pointer items-center gap-1 rounded-full bg-gray-50 px-2 py-0 text-xs font-medium text-gray-600 ring-1 ring-inset ring-gray-500/10 transition group-hover:text-gray-950">
                                                <span class="outcraft-icon !text-[18px] !leading-[18px] ">play_circle</span>
                                                <span class="truncate leading-[18px]" x-text="row.content || 'Play'"></span>
                                            </span>
                                        </span>
                                    </div>
                                </td>
                                <td class="px-4 py-4 align-top max-sm:order-4 max-sm:block max-sm:min-h-[56px] max-sm:p-0">
                                    <div class="flex h-[26px] items-center text-sm font-medium text-gray-900">Outcome</div>
                                    <div class="mt-1">
                                        <span class="outcraft-label inline-flex h-[26px] w-fit max-w-full min-w-0 items-center rounded-full px-2 py-0 text-xs font-medium ring-1 ring-inset" :class="pillClass(row.outcome)">
                                            <span class="truncate" x-text="row.outcome"></span>
                                        </span>
                                    </div>
                                </td>
                                <td class="px-4 py-4 align-top max-sm:order-5 max-sm:block max-sm:min-h-[56px] max-sm:p-0">
                                    <div class="flex h-[26px] items-center text-sm font-medium text-gray-900">Result</div>
                                    <div class="mt-1">
                                        <span class="outcraft-label inline-flex h-[26px] w-fit max-w-full min-w-0 items-center rounded-full px-2 py-0 text-xs font-medium ring-1 ring-inset" :class="pillClass(row.result)">
                                            <span class="truncate" x-text="row.result"></span>
                                        </span>
                                    </div>
                                </td>
                                <td class="px-4 py-4 align-top text-right max-sm:order-3 max-sm:block max-sm:min-h-[56px] max-sm:p-0 max-sm:text-left">
                                    <span class="group relative inline-flex flex-col items-end max-sm:items-start">
                                        <span class="flex h-[26px] items-center text-sm font-medium text-gray-900">Created</span>
                                        <span class="mt-1 flex h-[26px] items-center text-xs text-gray-500" x-text="leadAge(row)"></span>
                                        <span class="pointer-events-none absolute bottom-full right-0 z-50 mb-2 translate-y-1 whitespace-nowrap rounded-lg bg-gray-900 px-3 py-2 text-xs font-medium text-white opacity-0 shadow-sm transition group-hover:translate-y-0 group-hover:opacity-100">
                                            <span x-text="row.ageTooltip"></span>
                                            <span class="absolute right-6 top-full size-2 -translate-y-1 rotate-45 bg-gray-900"></span>
                                        </span>
                                    </span>
                                </td>
                            </tr>
                        </template>
                        <tr x-show="! isLoading && filteredRows().length === 0">
                            <td colspan="5" class="px-8 py-16 text-center text-gray-500">No outreach records match these filters.</td>
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
