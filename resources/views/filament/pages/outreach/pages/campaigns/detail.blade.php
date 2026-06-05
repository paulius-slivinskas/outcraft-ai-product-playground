        <template x-if="! campaignBuilderOpen && (campaignDetailOpen || campaignCreationV2Open) && activeNav === 'Campaigns'">
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

            <div class="-mx-3 -mt-4 border-b border-gray-200 bg-white px-3 py-4 sm:-mx-6 sm:px-6 lg:-mt-6 lg:py-5">
                <div class="flex max-w-5xl flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
                    <div class="min-w-0">
                        <h1 class="truncate text-xl font-bold leading-tight text-gray-950" x-text="campaignCreationV2Open ? (campaignSetup.name || 'New Campaign') : (selectedCampaign?.name || campaignSetup.name || 'Campaign')"></h1>
                        <p class="mt-1 text-sm/6 text-gray-500">Modified <span x-text="campaignCreationV2Open ? 'just now' : (selectedCampaign?.modified || 'recently')"></span></p>
                    </div>

                    <div x-show="! campaignCreationV2Open" class="hidden flex-wrap gap-3 lg:flex">
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
                                        <button type="button" x-on:click="setCampaignDetailPanel(panel.id)" :disabled="campaignDetailPanelDisabled(panel.id)" class="flex w-full items-center gap-3 px-4 py-4 text-left transition" :class="campaignDetailMobileButtonClass(panel.id)">
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
                        <div class="space-y-8 whitespace-nowrap">
                            <div class="space-y-4 px-1">
                                <div>
                                    <p class="text-xs font-semibold uppercase tracking-wide text-gray-400">Campaign Objective:</p>
                                    <p class="mt-1 truncate text-sm font-semibold leading-6 text-gray-900" x-text="campaignDetailSidebarObjectiveLabel()"></p>
                                </div>
                                <div>
                                    <p class="text-xs font-semibold uppercase tracking-wide text-gray-400">Lead Source:</p>
                                    <p class="mt-1 truncate text-sm font-semibold leading-6 text-gray-900" x-text="campaignDetailSidebarLeadSourceLabel()"></p>
                                </div>
                            </div>

                            <div>
                                <p class="mb-3 px-1 text-xs font-semibold uppercase tracking-wide text-gray-400">Campaign setup</p>
                                <ol role="list" class="space-y-6">
                                    <template x-for="panel in campaignDetailSidebarPanels()" :key="panel.id">
                                        <li>
                                            <button
                                                type="button"
                                                x-on:click="setCampaignDetailPanel(panel.id)"
                                                :disabled="campaignDetailPanelDisabled(panel.id)"
                                                :aria-current="activeCampaignDetailPanel === panel.id ? 'step' : null"
                                                class="group flex w-full min-w-0 items-start text-left disabled:cursor-not-allowed disabled:opacity-45"
                                            >
                                                <span class="relative flex size-5 shrink-0 items-center justify-center">
                                                    <svg x-show="activeCampaignDetailPanel !== panel.id && isCampaignDetailPanelChanged(panel.id)" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" class="size-full text-amber-500 transition">
                                                        <path d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16Zm3.857-9.809a.75.75 0 0 0-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 1 0-1.06 1.061l2.5 2.5a.75.75 0 0 0 1.137-.089l4-5.5Z" clip-rule="evenodd" fill-rule="evenodd" />
                                                    </svg>
                                                    <span x-show="activeCampaignDetailPanel === panel.id" aria-hidden="true" class="relative flex size-5 shrink-0 items-center justify-center">
                                                        <span class="absolute size-4 rounded-full oc-primary-bg-soft"></span>
                                                        <span class="relative block size-2 rounded-full oc-primary-bg"></span>
                                                    </span>
                                                    <span x-show="activeCampaignDetailPanel !== panel.id && ! isCampaignDetailPanelChanged(panel.id)" aria-hidden="true" class="relative flex size-5 shrink-0 items-center justify-center">
                                                        <span class="size-2 rounded-full bg-gray-300 transition group-hover:bg-gray-400"></span>
                                                    </span>
                                                </span>
                                                <span
                                                    class="ml-3 flex min-w-0 flex-1 items-center gap-2 text-sm font-medium leading-5 transition"
                                                    :class="activeCampaignDetailPanel === panel.id ? 'oc-primary-text' : (campaignDetailPanelDisabled(panel.id) ? 'text-gray-300' : 'text-gray-500 group-hover:text-gray-900')"
                                                >
                                                    <span class="truncate" x-text="panel.label"></span>
                                                    <span x-show="isCampaignDetailPanelChanged(panel.id)" class="shrink-0 rounded-full bg-amber-50 px-2 py-0.5 text-xs font-medium text-amber-700 ring-1 ring-inset ring-amber-600/20">Changed</span>
                                                </span>
                                                <span class="sr-only" x-text="panel.description"></span>
                                            </button>
                                        </li>
                                    </template>
                                </ol>
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
                        x-show="activeCampaignDetailPanel === 'company-brand'"
                        x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 translate-y-3"
                        x-transition:enter-end="opacity-100 translate-y-0"
                        x-on:click="markCampaignDetailClickChanged($event)"
                        class="min-w-0 space-y-6"
                    >
                        <div class="hidden lg:block">
                            <h2 class="text-base font-semibold leading-7 text-gray-950">Brand</h2>
                            <p class="mt-1 text-sm leading-6 text-gray-500">Select the brand profile this campaign should use for website, positioning, and legal context.</p>
                        </div>

                        <div class="space-y-3">
                            <template x-for="company in campaignBuilderCompanyOptions()" :key="`campaign-detail-brand-${company.id}`">
                                <div
                                    class="group flex w-full items-center gap-3 rounded-lg bg-white p-4 text-left shadow-sm outline transition hover:outline-2 hover:-outline-offset-2 hover:outline-indigo-600"
                                    :class="campaignDetailBrandOptionSelected(company) ? 'outline-2 -outline-offset-2 outline-indigo-600' : 'outline-1 -outline-offset-1 outline-gray-300'"
                                >
                                    <button
                                        type="button"
                                        data-campaign-detail-ignore-change
                                        x-on:click.stop="selectCampaignDetailCompanyBrand(company)"
                                        class="flex min-w-0 flex-1 items-center gap-4 text-left focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
                                    >
                                        <span data-icon-tile class="flex size-10 shrink-0 items-center justify-center rounded-md bg-indigo-50 text-sm font-bold text-indigo-600" x-text="brandInitials(company.name)"></span>
                                        <span class="min-w-0">
                                            <span class="block truncate text-sm font-semibold leading-6 text-gray-950" x-text="company.name"></span>
                                            <span class="block truncate text-sm leading-6 text-gray-500" x-text="company.website"></span>
                                        </span>
                                    </button>
                                    <span class="flex shrink-0 items-center gap-1">
                                        <button
                                            type="button"
                                            data-campaign-detail-ignore-change
                                            x-on:click.stop="openCampaignBuilderBrandEditModal(company)"
                                            class="inline-flex size-9 items-center justify-center rounded-md text-gray-400 transition hover:bg-gray-50 hover:text-gray-700 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
                                            :aria-label="`Edit ${company.name}`"
                                        >
                                            <span class="outcraft-icon !text-[19px]">edit</span>
                                        </button>
                                        <button
                                            type="button"
                                            data-campaign-detail-ignore-change
                                            x-on:click.stop="deleteCampaignBuilderBrand(company)"
                                            class="inline-flex size-9 items-center justify-center rounded-md text-gray-400 transition hover:bg-red-50 hover:text-red-600 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-red-600"
                                            :aria-label="`Delete ${company.name}`"
                                        >
                                            <span class="outcraft-icon !text-[19px]">delete</span>
                                        </button>
                                    </span>
                                </div>
                            </template>

                            <button
                                type="button"
                                data-campaign-detail-ignore-change
                                x-on:click.stop="openBrandCreateModal(null, { returnToCampaignDetail: true })"
                                class="flex w-full items-center gap-4 rounded-lg bg-white p-4 text-left shadow-sm outline outline-1 -outline-offset-1 outline-gray-300 transition hover:outline-2 hover:-outline-offset-2 hover:outline-indigo-600 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
                            >
                                <span class="flex size-10 shrink-0 items-center justify-center rounded-md oc-primary-bg text-white">
                                    <span class="outcraft-icon !text-[20px] text-white">plus</span>
                                </span>
                                <span class="min-w-0">
                                    <span class="block text-sm font-semibold leading-6 text-gray-950">Create New Brand</span>
                                    <span class="block text-sm leading-6 text-gray-500">Start a fresh company profile for this campaign setup.</span>
                                </span>
                            </button>
                        </div>
                    </div>

                    <div
                        x-cloak
                        x-show="activeCampaignDetailPanel === 'campaign-agent'"
                        x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 translate-y-3"
                        x-transition:enter-end="opacity-100 translate-y-0"
                        x-on:click="markCampaignDetailClickChanged($event)"
                        class="min-w-0 space-y-6"
                    >
                        <div class="hidden lg:block">
                            <h2 class="text-base font-semibold leading-7 text-gray-950">AI Agents</h2>
                            <p class="mt-1 text-sm leading-6 text-gray-500">Assign one or more reusable AI agent profiles to this campaign.</p>
                        </div>

                        <div x-show="campaignDetailSelectedAgents().length === 0" class="rounded-lg bg-white p-5 text-sm text-gray-500 shadow-sm outline outline-1 -outline-offset-1 outline-gray-300">
                            No AI agents assigned yet.
                        </div>

                        <div class="space-y-3">
                            <template x-for="agent in campaignDetailSelectedAgents()" :key="`campaign-detail-agent-${agent.id}`">
                                <div class="group flex w-full items-center gap-3 rounded-lg bg-white p-4 shadow-sm outline outline-1 -outline-offset-1 outline-gray-300 transition hover:outline-2 hover:-outline-offset-2 hover:outline-indigo-600">
                                    <button
                                        type="button"
                                        data-campaign-detail-ignore-change
                                        x-on:click.stop="openAiAgentCreateModal(agent)"
                                        class="flex min-w-0 flex-1 items-center gap-4 text-left focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
                                    >
                                        <span class="inline-flex size-10 shrink-0 items-center justify-center">
                                            <img :src="aiAgentFlagUrl(agent)" :alt="`${aiAgentTitle(agent)} flag`" class="size-[34px] object-contain" loading="lazy">
                                        </span>
                                        <span class="min-w-0">
                                            <span class="block truncate text-sm font-semibold leading-6 text-gray-950" x-text="aiAgentTitle(agent)"></span>
                                            <span class="block truncate text-sm leading-6 text-gray-500">
                                                <span x-text="agent.name"></span>
                                                <span aria-hidden="true"> &middot; </span>
                                                <span x-text="aiAgentVoiceStyle(agent)"></span>
                                            </span>
                                        </span>
                                    </button>
                                    <span class="flex shrink-0 items-center gap-1">
                                        <button
                                            type="button"
                                            data-campaign-detail-ignore-change
                                            x-on:click.stop="openAiAgentCreateModal(agent)"
                                            class="inline-flex size-9 items-center justify-center rounded-md text-gray-400 transition hover:bg-gray-50 hover:text-gray-700 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
                                            :aria-label="`Edit ${aiAgentTitle(agent)}`"
                                        >
                                            <span class="outcraft-icon !text-[19px]">edit</span>
                                        </button>
                                        <button
                                            type="button"
                                            data-campaign-detail-ignore-change
                                            x-on:click.stop="deleteAiAgent(agent)"
                                            :disabled="! canDeleteAiAgent(agent.id)"
                                            class="inline-flex size-9 items-center justify-center rounded-md transition focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-red-600"
                                            :class="canDeleteAiAgent(agent.id) ? 'text-gray-400 hover:bg-red-50 hover:text-red-600' : 'cursor-not-allowed text-gray-300'"
                                            :aria-label="`Delete ${aiAgentTitle(agent)}`"
                                        >
                                            <span class="outcraft-icon !text-[19px]">delete</span>
                                        </button>
                                    </span>
                                </div>
                            </template>

                        </div>

                        <div class="flex justify-start">
                            <button
                                type="button"
                                data-campaign-detail-ignore-change
                                x-on:click.stop="openCampaignDetailAgentPicker()"
                                class="inline-flex h-10 items-center justify-center gap-2 rounded-md bg-white px-3.5 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 transition hover:bg-gray-50 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
                            >
                                <span class="outcraft-icon !text-[18px] text-gray-500">add</span>
                                Add AI Agent
                            </button>
                        </div>
                    </div>

                    <div
                        x-cloak
                        x-show="activeCampaignDetailPanel.startsWith('campaign-') && activeCampaignDetailPanel !== 'campaign-agent'"
                        x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 translate-y-3"
                        x-transition:enter-end="opacity-100 translate-y-0"
                        x-on:input="markCampaignDetailPanelChanged()"
                        x-on:change="markCampaignDetailPanelChanged()"
                        x-on:click="markCampaignDetailClickChanged($event)"
                        class="min-w-0"
                    >
                        <div class="mb-6 hidden lg:block">
                            <h2 class="text-base font-semibold leading-7 text-gray-950" x-text="activeCampaignDetailPanelMeta()?.label || 'Campaign Setup'"></h2>
                            <p class="mt-1 text-sm leading-6 text-gray-500" x-text="activeCampaignDetailPanelMeta()?.description || ''"></p>
                        </div>
                        @include('filament.pages.outreach.campaign-builder.campaign-setup')
                    </div>
                </div>
            </div>

            <div x-cloak x-show="campaignDetailBrandPickerOpen" x-transition.opacity x-on:keydown.escape.window="closeCampaignDetailBrandPicker()" class="fixed inset-0 z-[70] flex items-center justify-center bg-gray-950/30 p-4">
                <div x-on:click="closeCampaignDetailBrandPicker()" class="absolute inset-0"></div>
                <div x-show="campaignDetailBrandPickerOpen" x-transition:enter="transition ease-out duration-150" x-transition:enter-start="opacity-0 translate-y-3 scale-95" x-transition:enter-end="opacity-100 translate-y-0 scale-100" x-transition:leave="transition ease-in duration-100" x-transition:leave-start="opacity-100 translate-y-0 scale-100" x-transition:leave-end="opacity-0 translate-y-2 scale-95" class="relative flex max-h-[min(720px,calc(100vh-2rem))] w-full max-w-xl flex-col overflow-hidden rounded-lg bg-white shadow-2xl ring-1 ring-gray-900/10" role="dialog" aria-modal="true" aria-labelledby="campaign-brand-picker-title">
                    <div class="border-b border-gray-100 px-6 py-5">
                        <div class="flex items-start justify-between gap-4">
                            <div class="min-w-0">
                                <h2 id="campaign-brand-picker-title" class="text-base font-semibold text-gray-950" x-text="selectedCampaignDetailBrand() ? 'Change Brand' : 'Choose Brand'"></h2>
                                <p class="mt-1 text-sm leading-6 text-gray-500">Select the brand profile assigned to this campaign.</p>
                            </div>
                            <button type="button" x-on:click="closeCampaignDetailBrandPicker()" class="inline-flex size-8 shrink-0 items-center justify-center rounded-md text-gray-400 transition hover:bg-gray-50 hover:text-gray-700" aria-label="Close">
                                <span class="outcraft-icon !text-[20px]">close</span>
                            </button>
                        </div>
                    </div>

                    <div class="min-h-0 flex-1 overflow-y-auto px-6 py-5">
                        <div class="space-y-2">
                            <template x-for="brand in brands" :key="`campaign-brand-picker-${brand.id}`">
                                <button
                                    type="button"
                                    x-on:click.stop="selectCampaignDetailBrand(brand.id)"
                                    class="flex w-full items-center gap-4 rounded-md px-2 py-2 text-left transition hover:bg-gray-50"
                                    :class="campaignDetailSelectedBrandId === brand.id ? 'bg-indigo-50 text-indigo-600' : 'text-gray-900'"
                                >
                                    <span data-icon-tile class="flex size-10 shrink-0 items-center justify-center rounded-md bg-indigo-50 text-sm font-bold text-indigo-600" x-text="brandInitials(brand.name)"></span>
                                    <span class="min-w-0 flex-1">
                                        <span class="block truncate text-sm font-semibold leading-6" :class="campaignDetailSelectedBrandId === brand.id ? 'text-indigo-600' : 'text-gray-950'" x-text="brand.name"></span>
                                        <span class="block truncate text-sm leading-5 text-gray-500">
                                            <span x-text="brand.website"></span>
                                            <span aria-hidden="true"> &middot; </span>
                                            <span x-text="brand.industry"></span>
                                        </span>
                                    </span>
                                    <span x-show="campaignDetailSelectedBrandId === brand.id" class="outcraft-icon shrink-0 !text-[22px] text-indigo-600">check_circle</span>
                                </button>
                            </template>
                        </div>
                    </div>

                    <div class="flex items-center justify-end border-t border-gray-100 bg-white px-6 py-4">
                        <button type="button" x-on:click="closeCampaignDetailBrandPicker()" class="inline-flex h-10 items-center justify-center rounded-md bg-white px-4 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 transition hover:bg-gray-50">
                            Cancel
                        </button>
                    </div>
                </div>
            </div>

            <div x-cloak x-show="campaignDetailAgentPickerOpen" x-transition.opacity x-on:keydown.escape.window="closeCampaignDetailAgentPicker()" class="fixed inset-0 z-[70] flex items-center justify-center bg-gray-950/30 p-4">
                <div x-on:click="closeCampaignDetailAgentPicker()" class="absolute inset-0"></div>
                <div x-show="campaignDetailAgentPickerOpen" x-transition:enter="transition ease-out duration-150" x-transition:enter-start="opacity-0 translate-y-3 scale-95" x-transition:enter-end="opacity-100 translate-y-0 scale-100" x-transition:leave="transition ease-in duration-100" x-transition:leave-start="opacity-100 translate-y-0 scale-100" x-transition:leave-end="opacity-0 translate-y-2 scale-95" class="relative flex max-h-[min(720px,calc(100vh-2rem))] w-full max-w-xl flex-col overflow-hidden rounded-lg bg-white shadow-2xl ring-1 ring-gray-900/10" role="dialog" aria-modal="true" aria-labelledby="campaign-agent-picker-title">
                    <div class="border-b border-gray-100 px-6 py-5">
                        <div class="flex items-start justify-between gap-4">
                            <div class="min-w-0">
                                <h2 id="campaign-agent-picker-title" class="text-base font-semibold text-gray-950">Add AI Agents</h2>
                                <p class="mt-1 text-sm leading-6 text-gray-500">Select the agents assigned to this campaign.</p>
                            </div>
                            <button type="button" x-on:click="closeCampaignDetailAgentPicker()" class="inline-flex size-8 shrink-0 items-center justify-center rounded-md text-gray-400 transition hover:bg-gray-50 hover:text-gray-700" aria-label="Close">
                                <span class="outcraft-icon !text-[20px]">close</span>
                            </button>
                        </div>
                    </div>

                    <div class="min-h-0 flex-1 overflow-y-auto px-6 py-5">
                        <div class="space-y-2">
                            <template x-for="agent in aiAgents" :key="`campaign-agent-picker-${agent.id}`">
                                <label
                                    class="flex items-center gap-4 rounded-md px-2 py-2 transition"
                                    :class="campaignDetailAgentPickerLocked(agent.id) ? 'cursor-not-allowed opacity-60' : 'cursor-pointer hover:bg-gray-50'"
                                >
                                    <span class="inline-flex size-10 shrink-0 items-center justify-center">
                                        <img :src="aiAgentFlagUrl(agent)" :alt="`${aiAgentTitle(agent)} flag`" class="size-9 object-contain" loading="lazy">
                                    </span>
                                    <span class="min-w-0 flex-1">
                                        <span class="block truncate text-sm font-semibold leading-6 text-gray-950" x-text="aiAgentTitle(agent)"></span>
                                        <span class="block truncate text-sm leading-5 text-gray-500">
                                            <span x-text="agent.name"></span>
                                            <span aria-hidden="true"> &middot; </span>
                                            <span x-text="aiAgentVoiceStyle(agent)"></span>
                                        </span>
                                    </span>
                                    <input
                                        type="checkbox"
                                        class="size-4 shrink-0 rounded border-gray-300 text-indigo-600 focus:ring-indigo-600"
                                        :checked="campaignDetailAgentPickerSelected(agent.id)"
                                        :disabled="campaignDetailAgentPickerLocked(agent.id)"
                                        x-on:change="toggleCampaignDetailAgentPicker(agent.id)"
                                    >
                                </label>
                            </template>
                        </div>
                    </div>

                    <div class="flex items-center justify-end gap-3 border-t border-gray-100 bg-white px-6 py-4">
                        <button type="button" x-on:click="closeCampaignDetailAgentPicker()" class="inline-flex h-10 items-center justify-center rounded-md bg-white px-4 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 transition hover:bg-gray-50">
                            Cancel
                        </button>
                        <button type="button" x-on:click="applyCampaignDetailAgentPicker()" class="inline-flex h-10 items-center justify-center rounded-md bg-indigo-600 px-4 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-500">
                            Add Selected
                        </button>
                    </div>
                </div>
            </div>

            <div x-cloak x-show="campaignCreationV2Open" data-campaign-detail-mobile-action-bar class="fixed inset-x-0 bottom-0 z-[60] border-t border-gray-200 bg-white/95 px-4 py-3 shadow-[0_-12px_30px_rgba(15,23,42,0.08)] backdrop-blur lg:px-0 lg:py-4">
                <div class="mx-auto flex w-full max-w-5xl items-center justify-between gap-3">
                    <button type="button" x-on:click="previousCampaignCreationV2Panel()" :disabled="! campaignCreationV2PreviousPanelId()" class="inline-flex h-9 shrink-0 items-center gap-2 rounded-md px-2 text-sm font-semibold text-gray-600 transition hover:bg-gray-50 hover:text-gray-950 disabled:cursor-not-allowed disabled:opacity-40">
                        <span class="outcraft-icon !text-[18px]">arrow_upward</span>
                        Previous step
                    </button>
                    <div class="flex min-w-0 items-center gap-2 sm:gap-3">
                        <span x-show="campaignCreationV2NextLabel()" class="hidden text-sm font-medium text-gray-500 sm:inline" x-text="`Next: ${campaignCreationV2NextLabel()}`"></span>
                        <button type="button" x-on:click="continueCampaignCreationV2()" :disabled="! campaignCreationV2CanContinue()" class="inline-flex h-9 min-w-0 items-center gap-2 rounded-md bg-indigo-600 px-3 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-500 disabled:cursor-not-allowed disabled:opacity-40">
                            <span class="hidden truncate sm:inline" x-text="campaignCreationV2ContinueLabel()"></span>
                            <span class="truncate sm:hidden" x-text="campaignCreationV2ContinueLabel()"></span>
                            <span class="outcraft-icon !text-[18px]" x-text="campaignCreationV2ContinueIcon()"></span>
                        </button>
                    </div>
                </div>
            </div>

            <div x-cloak x-show="! campaignCreationV2Open" data-campaign-detail-mobile-action-bar class="fixed inset-x-0 bottom-0 z-[60] border-t border-gray-200 bg-white/95 px-4 py-3 shadow-[0_-12px_30px_rgba(15,23,42,0.08)] backdrop-blur lg:hidden">
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
