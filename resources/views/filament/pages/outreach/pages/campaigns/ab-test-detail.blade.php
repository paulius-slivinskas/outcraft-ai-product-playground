        <template x-if="abTestDetailOpen && selectedAbTest && activeNav === 'Campaigns'">
        <section data-ab-test-detail class="mx-3 mb-10 mt-4 sm:mx-6 lg:mt-6">
            <div class="max-w-7xl space-y-8">
                <div class="flex flex-wrap items-center justify-between gap-4">
                    <button type="button" x-on:click="closeAbTestDetail()" class="inline-flex h-9 w-fit items-center gap-2 rounded-md px-2 text-sm font-semibold text-gray-600 transition hover:bg-white hover:text-gray-950">
                        <span class="outcraft-icon !text-[18px]">arrow_back</span>
                        Back to A/B Tests
                    </button>

                    <div class="flex flex-wrap items-center gap-2">
                        <button type="button" x-on:click="showLoader(500)" class="inline-flex h-9 items-center gap-2 rounded-md bg-white px-3 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 transition hover:bg-gray-50">
                            <span class="outcraft-icon !text-[17px] text-gray-500">refresh_ccw</span>
                            Check If AB Test Completed
                        </button>
                        <button type="button" x-on:click="selectedAbTest.status = 'Running'" class="inline-flex h-9 items-center gap-2 rounded-md bg-indigo-600 px-3 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                            <span class="outcraft-icon !text-[17px] text-white">play_arrow</span>
                            Resume
                        </button>
                        <button type="button" x-on:click="selectedAbTest.status = 'Paused'" class="inline-flex h-9 items-center rounded-md bg-white px-3 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 transition hover:bg-gray-50">
                            Cancel
                        </button>
                    </div>
                </div>

                <div class="space-y-4">
                    <h1 class="text-xl font-bold leading-tight text-gray-950" x-text="selectedAbTest.name"></h1>

                    <section data-card-surface class="overflow-visible rounded-lg bg-white shadow-sm ring-1 ring-gray-900/5">
                        <div class="px-4 py-5 sm:px-6">
                            <h2 class="text-base/7 font-semibold text-gray-950">Details</h2>
                            <p class="mt-1 max-w-2xl text-sm/6 text-gray-500">Status, lead allocation, and completion progress for this A/B test.</p>
                        </div>
                        <dl class="grid grid-cols-1 sm:grid-cols-3">
                            <div class="border-t border-gray-100 px-4 py-6 sm:px-6">
                                <dt class="text-sm/6 font-medium text-gray-900">Status</dt>
                                <dd class="mt-1 sm:mt-2">
                                    <span class="outcraft-label inline-flex rounded-md px-2 py-1 text-xs font-medium ring-1 ring-inset" :class="abTestStatusClass(selectedAbTest)" x-text="selectedAbTest.status"></span>
                                </dd>
                            </div>
                            <div class="border-t border-gray-100 px-4 py-6 sm:px-6">
                                <dt class="text-sm/6 font-medium text-gray-900">Lead Count</dt>
                                <dd class="mt-1 text-sm/6 text-gray-700 sm:mt-2" x-text="selectedAbTest.leadCount"></dd>
                            </div>
                            <div class="border-t border-gray-100 px-4 py-6 sm:px-6">
                                <dt class="text-sm/6 font-medium text-gray-900">Completed Campaigns</dt>
                                <dd class="mt-1 text-sm/6 text-gray-700 sm:mt-2" x-text="selectedAbTest.completedCampaigns"></dd>
                            </div>
                        </dl>
                    </section>
                </div>

                <div class="space-y-6">
                    <div>
                        <h2 class="text-2xl font-bold leading-8 text-gray-950">Campaign Performances</h2>
                        <p class="mt-2 text-sm leading-6 text-gray-500">Performance metrics are refreshed every hour</p>
                    </div>

                    <template x-for="performance in selectedAbTest.performances" :key="performance.label">
                        <div data-card-surface class="overflow-hidden rounded-lg bg-white shadow-sm ring-1 ring-gray-900/5">
                            <div class="flex flex-col gap-4 px-5 py-5 sm:flex-row sm:items-start sm:justify-between lg:px-6">
                                <div class="min-w-0">
                                    <h3 class="text-lg font-bold text-gray-950" x-text="performance.label"></h3>
                                    <p class="mt-1 text-sm text-gray-500" x-text="performance.campaignName"></p>
                                </div>
                                <button type="button" x-on:click="openCampaignDetail({ name: performance.campaignName, status: 'Running', change: '', modified: selectedAbTest.modified || 'recently' })" class="inline-flex h-9 w-fit items-center justify-center rounded-md bg-white px-3 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 transition hover:bg-gray-50">
                                    View Campaign
                                </button>
                            </div>

                            <div class="border-t border-gray-200 px-5 py-5 lg:px-6">
                                <div class="grid grid-cols-1 items-stretch gap-0" :style="window.innerWidth >= 1024 ? 'grid-template-columns: minmax(0, 1fr) 48px minmax(0, 1fr) 48px minmax(0, 1fr)' : ''">
                                    <template x-for="(metric, metricIndex) in performance.metrics" :key="performance.label + metric.label">
                                        <div class="contents">
                                            <div class="min-w-0 p-4 lg:p-0 lg:px-4" :class="metricIndex === 0 ? 'lg:pl-0' : (metricIndex === performance.metrics.length - 1 ? 'lg:pr-0' : '')">
                                                <div class="space-y-3">
                                                    <span class="flex size-10 shrink-0 items-center justify-center rounded-md bg-indigo-50 text-indigo-600">
                                                        <span class="outcraft-icon !text-[21px]" x-text="metric.label === 'Engagement Rate' ? 'forum' : (metric.label === 'Conversion Potential' ? 'target' : 'payments')"></span>
                                                    </span>
                                                    <p class="min-w-0 text-sm font-medium text-gray-500" x-text="metric.label"></p>
                                                </div>

                                                <div>
                                                    <div class="mt-1.5 flex items-center gap-2">
                                                        <p class="text-3xl/10 font-semibold tracking-tight text-gray-950" x-text="metric.value"></p>
                                                    </div>
                                                    <div class="mt-1.5 flex items-start gap-2 text-sm">
                                                        <span class="outcraft-icon mt-0.5 !text-[18px] text-emerald-600">arrow_outward</span>
                                                        <span class="text-gray-500" x-text="metric.helper"></span>
                                                    </div>
                                                </div>
                                            </div>

                                            <span x-show="metricIndex < performance.metrics.length - 1" class="relative -mx-5 flex min-h-12 self-stretch items-center justify-center lg:mx-0 lg:-my-5">
                                                <span class="absolute inset-x-0 top-1/2 border-t border-gray-200 lg:inset-x-auto lg:inset-y-0 lg:left-1/2 lg:top-0 lg:border-l lg:border-t-0"></span>
                                                <span class="relative z-10 flex size-9 items-center justify-center rounded-md border border-gray-200 bg-white text-gray-400 shadow-sm">
                                                    <span class="outcraft-icon !text-[22px] rotate-90 lg:rotate-0">arrow_forward</span>
                                                </span>
                                            </span>
                                        </div>
                                    </template>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>
            </div>
        </section>
        </template>
