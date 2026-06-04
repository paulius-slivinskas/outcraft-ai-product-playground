        <template x-if="abTestDetailOpen && selectedAbTest && activeNav === 'Campaigns'">
        <section data-ab-test-detail class="mx-3 mb-10 mt-4 sm:mx-6 lg:mt-6">
            <div class="max-w-7xl space-y-8">
                <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
                    <button type="button" x-on:click="closeAbTestDetail()" class="inline-flex h-9 w-fit items-center gap-2 rounded-md px-2 text-sm font-semibold text-gray-600 transition hover:bg-white hover:text-gray-950">
                        <span class="outcraft-icon !text-[18px]">arrow_back</span>
                        Back to A/B Tests
                    </button>

                    <div class="flex flex-col gap-3 sm:flex-row sm:flex-wrap sm:items-center lg:justify-end">
                        <button type="button" x-on:click="showLoader(500)" class="inline-flex h-10 items-center justify-center gap-2 rounded-md bg-white px-3.5 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 transition hover:bg-gray-50">
                            <span class="outcraft-icon !text-[17px] text-gray-500">refresh_ccw</span>
                            Check If AB Test Completed
                        </button>
                        <button type="button" x-on:click="selectedAbTest.status = 'Running'" class="inline-flex h-10 items-center justify-center gap-2 rounded-md bg-indigo-600 px-3.5 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                            <span class="outcraft-icon !text-[17px] text-white">play_arrow</span>
                            Resume
                        </button>
                        <button type="button" x-on:click="selectedAbTest.status = 'Paused'" class="inline-flex h-10 items-center justify-center rounded-md bg-white px-3.5 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 transition hover:bg-gray-50">
                            Cancel
                        </button>
                    </div>
                </div>

                <div class="space-y-4">
                    <h1 class="text-xl font-bold leading-tight text-gray-950" x-text="selectedAbTest.name"></h1>

                    <div data-card-surface class="rounded-lg bg-white px-5 py-5 shadow-sm ring-1 ring-gray-900/5 lg:px-6">
                        <h2 class="text-base/7 font-semibold text-gray-950">Details</h2>
                        <div class="mt-5 grid gap-5 md:grid-cols-3">
                            <div>
                                <p class="text-xs font-medium leading-5 text-gray-500">Status</p>
                                <span class="outcraft-label mt-1 inline-flex rounded-full px-2 py-1 text-xs font-medium ring-1 ring-inset" :class="abTestStatusClass(selectedAbTest)">
                                    <span x-text="selectedAbTest.status"></span>
                                </span>
                            </div>
                            <div>
                                <p class="text-xs font-medium leading-5 text-gray-500">Lead Count</p>
                                <p class="mt-1 text-sm font-medium leading-6 text-gray-950" x-text="selectedAbTest.leadCount"></p>
                            </div>
                            <div>
                                <p class="text-xs font-medium leading-5 text-gray-500">Completed Campaigns</p>
                                <p class="mt-1 text-sm font-medium leading-6 text-gray-950" x-text="selectedAbTest.completedCampaigns"></p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="space-y-6">
                    <div>
                        <h2 class="text-2xl font-bold leading-8 text-gray-950">Campaign Performances</h2>
                        <p class="mt-2 text-sm leading-6 text-gray-500">Performance metrics are refreshed every hour</p>
                    </div>

                    <template x-for="performance in selectedAbTest.performances" :key="performance.label">
                        <div data-card-surface class="rounded-lg bg-white px-5 py-5 shadow-sm ring-1 ring-gray-900/5 lg:px-6">
                            <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
                                <div class="min-w-0">
                                    <h3 class="text-base/7 font-semibold text-gray-950" x-text="performance.label"></h3>
                                    <p class="mt-2 text-sm leading-6 text-gray-700" x-text="performance.campaignName"></p>
                                </div>
                                <button type="button" x-on:click="openCampaignDetail({ name: performance.campaignName, status: 'Running', change: '', modified: selectedAbTest.modified || 'recently' })" class="inline-flex h-9 w-fit items-center justify-center rounded-md bg-white px-3 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 transition hover:bg-gray-50">
                                    View Campaign
                                </button>
                            </div>

                            <div class="mt-6 grid gap-4 lg:grid-cols-3">
                                <template x-for="metric in performance.metrics" :key="performance.label + metric.label">
                                    <div data-card-surface class="rounded-lg bg-white px-5 py-6 shadow-sm ring-1 ring-gray-900/5">
                                        <p class="text-sm font-semibold leading-6 text-gray-500" x-text="metric.label"></p>
                                        <p class="mt-3 text-3xl font-bold leading-9 text-gray-950" x-text="metric.value"></p>
                                        <p class="mt-3 text-sm leading-6 text-green-700" x-text="metric.helper"></p>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </template>
                </div>
            </div>
        </section>
        </template>
