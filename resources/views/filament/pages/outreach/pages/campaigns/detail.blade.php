        <template x-if="! campaignBuilderOpen && campaignDetailOpen && activeNav === 'Campaigns'">
        <section data-campaign-detail-host class="mx-3 mb-24 mt-4 pb-24 sm:mx-6 lg:mb-10 lg:mt-6 lg:pb-0">
            <style>
                [data-campaign-detail-host] [data-campaign-step-actions],
                [data-campaign-detail-host] .fixed.inset-x-0.bottom-0:not([data-campaign-detail-mobile-action-bar]) {
                    display: none !important;
                }

                [data-campaign-detail-host] [data-campaign-builder-content-shell] {
                    padding-bottom: 0 !important;
                }

                [data-campaign-detail-host] [x-ref="companyDetailsFormStage"] > section,
                [data-campaign-detail-host] [data-campaign-setup-step],
                [data-campaign-detail-host] [data-company-details-step-layout] {
                    grid-template-columns: minmax(0, 1fr) !important;
                    gap: 0 !important;
                    padding: 0 !important;
                }

                [data-campaign-detail-host] [data-campaign-setup-step] > :first-child,
                [data-campaign-detail-host] [data-company-details-step-layout] > :first-child {
                    display: none !important;
                }

                [data-campaign-detail-host] [data-campaign-setup-step] > :not(:first-child),
                [data-campaign-detail-host] [data-company-details-step-layout] > :not(:first-child) {
                    grid-column: 1 / -1 !important;
                    min-width: 0 !important;
                }

                [data-campaign-detail-host] [data-sequence-timeline] {
                    margin-top: 0 !important;
                }

                [data-campaign-detail-host] [x-ref="campaignSetupPanel"],
                [data-campaign-detail-host] [x-ref="campaignSetupPanelScroller"] {
                    min-height: auto !important;
                    background: transparent !important;
                }
            </style>

            <div class="max-w-5xl">
                <button type="button" x-on:click="closeCampaignDetail()" class="hidden h-9 w-fit items-center gap-2 rounded-md px-2 text-sm font-semibold text-gray-600 transition hover:bg-white hover:text-gray-950 lg:inline-flex">
                    <span class="outcraft-icon !text-[18px]">arrow_back</span>
                    Back to campaigns
                </button>

                <div class="mt-2 flex flex-col gap-5 lg:mt-6 lg:flex-row lg:items-start lg:justify-between">
                    <div class="min-w-0">
                        <div class="flex flex-wrap items-center gap-2">
                            <h1 class="truncate text-xl font-bold leading-tight text-gray-950" x-text="selectedCampaign?.name || campaignSetup.name || 'Campaign'"></h1>
                            <span class="inline-flex rounded-full px-2 py-1 text-xs font-medium ring-1 ring-inset" :class="selectedCampaign?.status === 'Running' ? 'bg-green-50 text-green-700 ring-green-600/20' : 'bg-gray-50 text-gray-600 ring-gray-500/10'" x-text="selectedCampaign?.status || 'Running'"></span>
                            <span x-show="selectedCampaign?.change" class="inline-flex rounded-full bg-amber-50 px-2 py-1 text-xs font-medium text-amber-800 ring-1 ring-inset ring-amber-600/20" x-text="selectedCampaign?.change"></span>
                        </div>
                        <p class="mt-2 flex flex-wrap items-center gap-x-2 gap-y-1 text-sm/6 text-gray-500">
                            <span>
                                <span class="font-medium text-gray-700">Campaign Objective:</span>
                                <span x-text="campaignSetup.type || campaignTypeNameFromCampaign(selectedCampaign) || 'Objective'"></span>
                            </span>
                            <span aria-hidden="true" class="text-gray-300">&middot;</span>
                            <span>
                                <span class="font-medium text-gray-700">Lead Source:</span>
                                <span x-text="campaignSetup.source || selectedCampaign?.source || 'Source'"></span>
                            </span>
                            <span aria-hidden="true" class="text-gray-300">&middot;</span>
                            <span>Modified <span x-text="selectedCampaign?.modified || 'recently'"></span></span>
                        </p>
                    </div>

                    <div class="hidden flex-wrap gap-3 lg:flex">
                        <button type="button" class="inline-flex h-10 items-center justify-center gap-2 rounded-md bg-white px-3.5 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 transition hover:bg-gray-50">
                            <span class="outcraft-icon !text-[17px] text-gray-500">phone_in_talk</span>
                            Test
                        </button>
                        <button type="button" x-on:click="campaignDetailDirtyPanels = []" class="inline-flex h-10 items-center justify-center rounded-md bg-indigo-600 px-3.5 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-500">Save & Publish</button>
                    </div>
                </div>
            </div>

            <div class="mt-8 max-w-5xl lg:flex lg:gap-x-16">
                <div x-show="! campaignDetailMobilePanelOpen" x-transition.opacity class="space-y-6 lg:hidden">
                    <template x-for="group in campaignDetailPanelGroups()" :key="group.label">
                        <div>
                            <p class="mb-2 px-1 text-xs font-semibold uppercase tracking-wide text-gray-400" x-text="group.label"></p>
                            <ul role="list" class="overflow-hidden rounded-lg bg-white shadow-sm ring-1 ring-gray-900/5">
                                <template x-for="panel in group.panels" :key="panel.id">
                                    <li class="border-b border-gray-100 last:border-b-0">
                                        <button type="button" x-on:click="setCampaignDetailPanel(panel.id)" class="flex w-full items-center gap-3 px-4 py-4 text-left transition hover:bg-gray-50">
                                            <span class="flex size-10 shrink-0 items-center justify-center rounded-md bg-indigo-50 text-indigo-600">
                                                <span class="outcraft-icon !text-[21px]" x-text="panel.icon"></span>
                                            </span>
                                            <span class="min-w-0 flex-1">
                                                <span class="flex min-w-0 items-center gap-2">
                                                    <span class="truncate text-sm font-semibold leading-6 text-gray-950" x-text="panel.label"></span>
                                                    <span x-show="isCampaignDetailPanelChanged(panel.id)" class="rounded-full bg-amber-50 px-2 py-0.5 text-xs font-medium text-amber-700 ring-1 ring-inset ring-amber-600/20">Changed</span>
                                                </span>
                                                <span class="mt-0.5 block text-sm leading-5 text-gray-500" x-text="panel.description"></span>
                                            </span>
                                            <span class="outcraft-icon !text-[18px] text-gray-400">arrow_forward</span>
                                        </button>
                                    </li>
                                </template>
                            </ul>
                        </div>
                    </template>
                </div>

                <aside class="hidden lg:sticky lg:top-6 lg:mb-0 lg:block lg:h-max lg:w-72 lg:flex-none lg:overflow-visible lg:border-0 lg:pb-0">
                    <nav class="flex-none lg:w-full" aria-label="Campaign settings navigation">
                        <div class="flex gap-x-6 whitespace-nowrap lg:flex-col lg:gap-x-0 lg:gap-y-8">
                            <div>
                                <p class="mb-2 px-2 text-xs font-semibold uppercase tracking-wide text-gray-400">Company Details</p>
                                <ul role="list" class="flex gap-x-2 lg:flex-col lg:gap-x-0 lg:gap-y-1">
                                    <template x-for="panel in campaignDetailCompanyPanels()" :key="panel.id">
                                        <li>
                                            <button type="button" x-on:click="setCampaignDetailPanel(panel.id)" class="group flex h-10 w-full items-center gap-x-3 rounded-md py-2 pl-2 pr-3 text-left text-sm/6 font-semibold transition" :class="activeCampaignDetailPanel === panel.id ? 'bg-white text-indigo-600' : 'text-gray-700 hover:bg-white hover:text-indigo-600'">
                                                <span class="outcraft-icon flex size-6 shrink-0 items-center justify-center !text-[22px]" :class="activeCampaignDetailPanel === panel.id ? 'text-indigo-600' : 'text-gray-400 group-hover:text-indigo-600'" x-text="panel.icon"></span>
                                                <span class="min-w-0 flex-1 truncate" x-text="panel.label"></span>
                                                <span x-show="isCampaignDetailPanelChanged(panel.id)" class="rounded-full bg-amber-50 px-2 py-0.5 text-xs font-medium text-amber-700 ring-1 ring-inset ring-amber-600/20">Changed</span>
                                            </button>
                                        </li>
                                    </template>
                                </ul>

                            </div>

                            <div>
                                <p class="mb-2 px-2 text-xs font-semibold uppercase tracking-wide text-gray-400">Campaign Details</p>
                                <ul role="list" class="flex gap-x-2 lg:flex-col lg:gap-x-0 lg:gap-y-1">
                                    <template x-for="panel in campaignDetailCampaignPanels()" :key="panel.id">
                                        <li>
                                            <button type="button" x-on:click="setCampaignDetailPanel(panel.id)" class="group flex h-10 w-full items-center gap-x-3 rounded-md py-2 pl-2 pr-3 text-left text-sm/6 font-semibold transition" :class="activeCampaignDetailPanel === panel.id ? 'bg-white text-indigo-600' : 'text-gray-700 hover:bg-white hover:text-indigo-600'">
                                                <span class="outcraft-icon flex size-6 shrink-0 items-center justify-center !text-[22px]" :class="activeCampaignDetailPanel === panel.id ? 'text-indigo-600' : 'text-gray-400 group-hover:text-indigo-600'" x-text="panel.icon"></span>
                                                <span class="min-w-0 flex-1 truncate" x-text="panel.label"></span>
                                                <span x-show="isCampaignDetailPanelChanged(panel.id)" class="rounded-full bg-amber-50 px-2 py-0.5 text-xs font-medium text-amber-700 ring-1 ring-inset ring-amber-600/20">Changed</span>
                                            </button>
                                        </li>
                                    </template>
                                </ul>
                            </div>
                        </div>
                    </nav>
                </aside>

                <div class="min-w-0 flex-1" :class="campaignDetailMobilePanelOpen ? 'block' : 'hidden lg:block'">
                    <div class="mb-4 rounded-lg bg-white px-4 py-4 shadow-sm ring-1 ring-gray-900/5 lg:hidden">
                        <p class="text-xs font-semibold uppercase tracking-wide text-gray-400" x-text="activeCampaignDetailPanelGroupLabel()"></p>
                        <h2 class="mt-1 text-lg font-semibold leading-7 text-gray-950" x-text="activeCampaignDetailPanelMeta()?.label || 'Campaign Settings'"></h2>
                        <p class="mt-1 text-sm leading-6 text-gray-500" x-text="activeCampaignDetailPanelMeta()?.description || ''"></p>
                    </div>

                    <div
                        x-cloak
                        x-show="['company-basics', 'company-market', 'company-compliance'].includes(activeCampaignDetailPanel)"
                        x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 translate-y-3"
                        x-transition:enter-end="opacity-100 translate-y-0"
                        x-on:input="markCampaignDetailPanelChanged()"
                        x-on:change="markCampaignDetailPanelChanged()"
                        x-on:click="markCampaignDetailClickChanged($event)"
                        class="min-w-0"
                    >
                        @include('filament.pages.outreach.campaign-builder.company-details')
                    </div>

                    <div
                        x-cloak
                        x-show="activeCampaignDetailPanel.startsWith('campaign-')"
                        x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 translate-y-3"
                        x-transition:enter-end="opacity-100 translate-y-0"
                        x-on:input="markCampaignDetailPanelChanged()"
                        x-on:change="markCampaignDetailPanelChanged()"
                        x-on:click="markCampaignDetailClickChanged($event)"
                        class="min-w-0"
                    >
                        @include('filament.pages.outreach.campaign-builder.campaign-setup')
                    </div>
                </div>
            </div>

            <div data-campaign-detail-mobile-action-bar class="fixed inset-x-0 bottom-0 z-[60] border-t border-gray-200 bg-white/95 px-4 py-3 shadow-[0_-12px_30px_rgba(15,23,42,0.08)] backdrop-blur lg:hidden">
                <div class="flex items-center gap-3">
                    <button x-cloak x-show="campaignDetailMobilePanelOpen" type="button" x-on:click="handleCampaignDetailMobileBack()" class="inline-flex h-11 flex-1 items-center justify-start gap-2 px-1 text-sm font-semibold text-gray-700 transition hover:text-gray-950">
                        <span class="outcraft-icon !text-[18px] text-gray-500">arrow_back</span>
                        Back
                    </button>
                    <button x-cloak x-show="! campaignDetailMobilePanelOpen" type="button" class="inline-flex h-11 flex-1 items-center justify-center gap-2 rounded-md bg-white px-3 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 transition hover:bg-gray-50">
                        <span class="outcraft-icon !text-[18px] text-gray-500">phone_in_talk</span>
                        Test
                    </button>
                    <button type="button" x-on:click="saveCampaignDetail()" class="inline-flex h-11 flex-1 items-center justify-center rounded-md bg-indigo-600 px-3 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-500">
                        Save & Publish
                    </button>
                </div>
            </div>
        </section>
        </template>
