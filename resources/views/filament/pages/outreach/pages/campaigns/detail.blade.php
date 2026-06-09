        <template x-if="! campaignBuilderOpen && (campaignDetailOpen || campaignCreationV2Open) && activeNav === 'Campaigns'">
        <section data-campaign-detail-host class="mx-3 mb-24 mt-4 pb-24 sm:mx-6 lg:m-0 lg:min-h-screen lg:pb-0">
            <style>
                @media (min-width: 1024px) {
                    .outcraft-page main > section[data-campaign-detail-host] {
                        width: 100% !important;
                        max-width: none !important;
                        margin: 0 !important;
                        padding-bottom: 0 !important;
                    }
                }

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

            <div class="-mx-3 -mt-4 border-b border-gray-200 bg-white px-3 py-4 sm:-mx-6 sm:px-6 lg:hidden">
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

            <div class="mt-8 max-w-5xl lg:m-0 lg:flex lg:min-h-screen lg:max-w-none lg:items-stretch lg:gap-x-0">
                <div x-show="! campaignDetailMobilePanelOpen" x-transition.opacity class="space-y-6 lg:hidden">
                    <div class="space-y-6 px-1">
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-wide text-gray-400">Campaign Objective:</p>
                            <p class="mt-1 text-sm font-semibold leading-6 text-gray-900" x-text="campaignDetailSidebarObjectiveLabel()"></p>
                        </div>
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-wide text-gray-400">Lead Source:</p>
                            <p class="mt-1 text-sm font-semibold leading-6 text-gray-900" x-text="campaignDetailSidebarLeadSourceLabel()"></p>
                        </div>
                    </div>

                    <template x-for="group in campaignDetailMobilePanelGroups()" :key="group.label">
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

                <aside class="hidden lg:sticky lg:top-0 lg:mb-0 lg:flex lg:h-screen lg:min-h-screen lg:w-80 lg:flex-none lg:flex-col lg:self-start lg:overflow-hidden lg:border-r lg:border-gray-200 lg:bg-white lg:px-8 lg:py-8 lg:pb-10">
                    <nav class="min-h-0 flex-1 overflow-y-auto lg:w-full" aria-label="Campaign settings navigation">
                        <div class="space-y-8 whitespace-nowrap">
                            <div class="space-y-1 px-1">
                                <h2 class="truncate text-lg font-semibold leading-7 text-gray-950" x-text="campaignCreationV2Open ? (campaignSetup.name || 'New Campaign') : (selectedCampaign?.name || campaignSetup.name || 'Campaign')"></h2>
                                <p class="text-xs leading-5 text-gray-500">Modified <span x-text="campaignCreationV2Open ? 'just now' : (selectedCampaign?.modified || 'recently')"></span></p>
                            </div>

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
                                                    <span x-show="activeCampaignDetailPanel === panel.id" aria-hidden="true" class="relative flex size-5 shrink-0 items-center justify-center">
                                                        <span class="absolute size-4 rounded-full oc-primary-bg-soft"></span>
                                                        <span class="relative block size-2 rounded-full oc-primary-bg"></span>
                                                    </span>
                                                    <span x-show="activeCampaignDetailPanel !== panel.id" aria-hidden="true" class="relative flex size-5 shrink-0 items-center justify-center">
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

                    <div x-show="! campaignCreationV2Open" class="mt-auto flex shrink-0 items-center gap-3 px-1 pt-8">
                        <button type="button" class="inline-flex h-10 items-center justify-center gap-2 rounded-md bg-white px-3.5 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 transition hover:bg-gray-50">
                            <span class="outcraft-icon !text-[17px] text-gray-500">phone_in_talk</span>
                            Test
                        </button>
                        <button type="button" x-on:click="campaignDetailDirtyPanels = []" class="inline-flex h-10 min-w-0 flex-1 items-center justify-center rounded-md bg-indigo-600 px-3.5 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-500">Save & Publish</button>
                    </div>
                </aside>

                <div class="min-w-0 flex-1 lg:px-12 lg:py-8" :class="campaignDetailMobilePanelOpen ? 'block' : 'hidden lg:block'">
                    <div class="w-full lg:mx-auto lg:max-w-2xl">
                        <div class="mb-6 px-1 lg:hidden">
                            <h2 class="text-lg font-semibold leading-7 text-gray-950" x-text="activeCampaignDetailPanelMeta()?.label || 'Campaign Settings'"></h2>
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
                        <div x-show="! campaignDetailBrandInlineEditorOpen" class="hidden lg:block">
                            <h2 class="text-base font-semibold leading-7 text-gray-950">Brand</h2>
                            <p class="mt-1 text-sm leading-6 text-gray-500">Select the brand profile this campaign should use for website, positioning, and legal context.</p>
                        </div>

                        <div x-show="! campaignCreationV2Open && ! campaignDetailBrandInlineEditorOpen" class="space-y-4">
                            <div class="flex w-full items-center gap-4 rounded-lg border border-gray-200 bg-white p-4 shadow-sm">
                                <span data-icon-tile class="flex size-10 shrink-0 items-center justify-center rounded-md bg-indigo-50 text-sm font-bold text-indigo-600" x-text="brandInitials(selectedCampaignDetailBrand()?.name || 'Brand')"></span>
                                <span class="min-w-0 flex-1">
                                    <span class="block truncate text-sm font-semibold leading-6 text-gray-950" x-text="selectedCampaignDetailBrand()?.name || 'No brand selected'"></span>
                                    <span class="block truncate text-sm leading-6 text-gray-500" x-text="selectedCampaignDetailBrand()?.website || 'Choose a brand to assign to this campaign.'"></span>
                                </span>
                                <button
                                    type="button"
                                    data-campaign-detail-ignore-change
                                    x-on:click.stop="openCampaignDetailBrandInlineEditor()"
                                    class="inline-flex h-9 shrink-0 items-center justify-center rounded-md bg-white px-3 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 transition hover:bg-gray-50 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
                                >
                                    Edit
                                </button>
                            </div>

                            <div class="flex flex-wrap items-center gap-3">
                                <button
                                    type="button"
                                    data-campaign-detail-ignore-change
                                    x-on:click.stop="openCampaignDetailBrandPicker()"
                                    class="inline-flex h-10 items-center justify-center rounded-md bg-white px-3.5 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 transition hover:bg-gray-50 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
                                >
                                    Change Brand
                                </button>
                            </div>
                        </div>

                        <div
                            x-cloak
                            x-show="! campaignCreationV2Open && campaignDetailBrandInlineEditorOpen"
                            x-transition.opacity
                            class="space-y-6"
                        >
                            <button
                                type="button"
                                data-campaign-detail-ignore-change
                                x-on:click.stop="closeCampaignDetailBrandInlineEditor()"
                                class="inline-flex items-center gap-2 text-sm font-semibold leading-6 text-gray-700 transition hover:text-gray-950 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
                            >
                                <span class="outcraft-icon !text-[20px] text-gray-500">arrow_back</span>
                                Back to Brand
                            </button>

                            <section class="rounded-lg border border-gray-200 bg-white p-5 shadow-sm">
                                <div class="flex items-start gap-3">
                                    <span class="flex size-10 shrink-0 items-center justify-center rounded-md bg-indigo-50 text-indigo-600">
                                        <span class="outcraft-icon !text-[22px]">briefcase_business</span>
                                    </span>
                                    <div class="min-w-0">
                                        <h3 class="text-base font-semibold leading-6 text-gray-950">Brand Details</h3>
                                        <p class="mt-1 text-sm leading-6 text-gray-500">Name, website, and pronunciation.</p>
                                    </div>
                                </div>

                                <div class="mt-6 grid gap-6">
                                    <label class="block">
                                        <span class="block text-sm/6 font-medium text-gray-900">Brand Name<span class="text-indigo-400">*</span></span>
                                        <input x-model="campaignDetailBrandInlineForm.name" type="text" placeholder="Enter the name leads will recognise" class="mt-2 block w-full rounded-md bg-white px-3 py-1.5 text-sm/6 text-gray-900 shadow-sm outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600">
                                    </label>

                                    <label class="block">
                                        <span class="block text-sm/6 font-medium text-gray-900">Brand Website<span class="text-indigo-400">*</span></span>
                                        <input x-model="campaignDetailBrandInlineForm.website" type="text" placeholder="https://example.com" class="mt-2 block w-full rounded-md bg-white px-3 py-1.5 text-sm/6 text-gray-900 shadow-sm outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600">
                                    </label>

                                    <div>
                                        <div class="flex items-center justify-between gap-4">
                                            <span class="flex grow flex-col">
                                                <span class="text-sm/6 font-medium text-gray-900">Add pronunciation guide</span>
                                                <span class="text-sm/6 text-gray-500">Useful for voice calls or names that are often mispronounced.</span>
                                            </span>
                                            <button type="button" data-campaign-detail-ignore-change role="switch" x-on:click.stop="campaignDetailBrandInlineForm.pronunciationEnabled = ! campaignDetailBrandInlineForm.pronunciationEnabled" :aria-checked="campaignDetailBrandInlineForm.pronunciationEnabled.toString()" class="relative inline-flex h-6 w-11 shrink-0 cursor-pointer rounded-full p-0.5 outline-offset-2 transition-colors duration-200 ease-in-out focus-visible:outline-2 focus-visible:outline-indigo-600" :class="campaignDetailBrandInlineForm.pronunciationEnabled ? 'bg-indigo-600' : 'bg-gray-200'">
                                                <span aria-hidden="true" class="size-5 rounded-full bg-white shadow-sm ring-1 ring-gray-900/5 transition-transform duration-200 ease-in-out" :class="campaignDetailBrandInlineForm.pronunciationEnabled ? 'translate-x-5' : 'translate-x-0'"></span>
                                            </button>
                                        </div>

                                        <label x-show="campaignDetailBrandInlineForm.pronunciationEnabled" x-transition.opacity class="mt-5 block">
                                            <span class="block text-sm/6 font-medium text-gray-900">Pronunciation</span>
                                            <input x-model="campaignDetailBrandInlineForm.pronunciation" type="text" placeholder="e.g. Goo-guhl, Nigh-kee, Ah-dee-das" class="mt-2 block w-full rounded-md bg-white px-3 py-1.5 text-sm/6 text-gray-900 shadow-sm outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600">
                                        </label>
                                    </div>
                                </div>

                                <div class="mt-6 flex justify-end">
                                    <button
                                        type="button"
                                        data-campaign-detail-ignore-change
                                        x-on:click.stop="saveCampaignDetailBrandInlineSection('Brand Details', 'details')"
                                        :disabled="! campaignDetailInlineBrandSectionValid('details')"
                                        class="inline-flex h-10 items-center justify-center rounded-md px-4 text-sm font-semibold transition focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
                                        :class="campaignDetailInlineBrandSectionValid('details') ? 'bg-indigo-600 text-white shadow-sm hover:bg-indigo-500' : 'cursor-not-allowed bg-gray-200 text-gray-500 shadow-none'"
                                    >
                                        Save
                                    </button>
                                </div>
                            </section>

                            <section class="rounded-lg border border-gray-200 bg-white p-5 shadow-sm">
                                <div class="flex items-start gap-3">
                                    <span class="flex size-10 shrink-0 items-center justify-center rounded-md bg-indigo-50 text-indigo-600">
                                        <span class="outcraft-icon !text-[22px]">monitoring</span>
                                    </span>
                                    <div class="min-w-0">
                                        <h3 class="text-base font-semibold leading-6 text-gray-950">Industry & Market</h3>
                                        <p class="mt-1 text-sm leading-6 text-gray-500">Positioning, customer profile, differentiators, and FAQs.</p>
                                    </div>
                                </div>

                                <div class="mt-6 flex justify-start">
                                    <button type="button" data-campaign-detail-ignore-change data-company-step-ai-action class="outcraft-ai-button inline-flex h-9 shrink-0 items-center justify-center gap-2 rounded-md border-2 border-transparent px-3 text-sm font-semibold text-gray-900 shadow-sm transition hover:text-gray-900">
                                        <svg class="outcraft-ai-sparkles" viewBox="0 0 105 103" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                            <path d="M31.6876 33.3482C33.0533 28.4835 39.9496 28.4835 41.3154 33.3482L44.4257 44.4273C46.3112 51.1432 51.5595 56.3915 58.2754 58.277L69.3545 61.3873C74.2192 62.7531 74.2192 69.6494 69.3545 71.0151L58.2754 74.1255C51.5595 76.0109 46.3112 81.2593 44.4257 87.9752L41.3154 99.0543C39.9496 103.919 33.0533 103.919 31.6876 99.0543L28.5772 87.9752C26.6918 81.2593 21.4434 76.0109 14.7275 74.1255L3.64844 71.0151C-1.21627 69.6494 -1.21627 62.7531 3.64844 61.3873L14.7275 58.277C21.4434 56.3915 26.6918 51.1432 28.5772 44.4273L31.6876 33.3482Z"/>
                                            <path d="M77.1504 2.91881C78.2429 -0.972965 83.76 -0.972956 84.8526 2.91881L87.046 10.7318C87.9887 14.0898 90.6129 16.714 93.9709 17.6567L101.784 19.8501C105.676 20.9427 105.676 26.4598 101.784 27.5523L93.9709 29.7458C90.6129 30.6885 87.9887 33.3127 87.046 36.6706L84.8526 44.4837C83.76 48.3754 78.2429 48.3754 77.1504 44.4837L74.9569 36.6706C74.0142 33.3127 71.39 30.6885 68.0321 29.7458L60.219 27.5523C56.3273 26.4598 56.3273 20.9427 60.219 19.8501L68.0321 17.6567C71.39 16.714 74.0142 14.0898 74.9569 10.7318L77.1504 2.91881Z"/>
                                        </svg>
                                        Fill with AI
                                    </button>
                                </div>

                                <div class="mt-6 grid gap-6">
                                    <label class="block">
                                        <span class="block text-sm/6 font-medium text-gray-900">Choose Industry<span class="text-indigo-400">*</span></span>
                                        <span class="relative mt-2 block">
                                            <select x-model="campaignDetailBrandInlineForm.industry" class="block h-10 w-full appearance-none rounded-md bg-white py-1.5 pl-3 pr-10 text-sm/6 text-gray-900 shadow-sm outline outline-1 -outline-offset-1 outline-gray-300 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600">
                                                <option value="">Choose Industry</option>
                                                <option>SaaS</option>
                                                <option>Ecommerce</option>
                                                <option>Healthcare</option>
                                                <option>Financial Services</option>
                                                <option>Consumer Services</option>
                                            </select>
                                            <span class="outcraft-icon pointer-events-none absolute right-3 top-1/2 -translate-y-1/2 !text-[18px] text-gray-400">keyboard_arrow_down</span>
                                        </span>
                                    </label>

                                    <label class="block">
                                        <span class="block text-sm/6 font-medium text-gray-900">Company Description<span class="text-indigo-400">*</span></span>
                                        <textarea x-model="campaignDetailBrandInlineForm.description" rows="10" class="mt-2 block w-full resize-none overflow-auto rounded-md bg-white px-3 py-2 text-sm/6 text-gray-900 shadow-sm outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600" placeholder="Describe what your company does, who you serve, and the main value your product or service creates."></textarea>
                                    </label>

                                    <label class="block">
                                        <span class="block text-sm/6 font-medium text-gray-900">Problem You Solve</span>
                                        <textarea x-model="campaignDetailBrandInlineForm.problem" rows="10" class="mt-2 block w-full resize-none overflow-auto rounded-md bg-white px-3 py-2 text-sm/6 text-gray-900 shadow-sm outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600" placeholder="Describe the pain points, needs, or jobs your customers come to you for."></textarea>
                                    </label>

                                    <label class="block">
                                        <span class="block text-sm/6 font-medium text-gray-900">Benefits Over Competitors (Differentiators)</span>
                                        <textarea x-model="campaignDetailBrandInlineForm.differentiators" rows="10" class="mt-2 block w-full resize-none overflow-auto rounded-md bg-white px-3 py-2 text-sm/6 text-gray-900 shadow-sm outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600" placeholder="List the main reasons customers choose you over alternatives."></textarea>
                                    </label>

                                    <label class="block">
                                        <span class="block text-sm/6 font-medium text-gray-900">Ideal Customer Profile</span>
                                        <textarea x-model="campaignDetailBrandInlineForm.icp" rows="10" class="mt-2 block w-full resize-none overflow-auto rounded-md bg-white px-3 py-2 text-sm/6 text-gray-900 shadow-sm outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600" placeholder="Describe the buyer types, segments, company sizes, regions, and common needs."></textarea>
                                    </label>

                                    <label class="block">
                                        <span class="block text-sm/6 font-medium text-gray-900">Frequently Asked Questions (FAQs)</span>
                                        <textarea x-model="campaignDetailBrandInlineForm.faqs" rows="10" class="mt-2 block w-full resize-none overflow-auto rounded-md bg-white px-3 py-2 text-sm/6 text-gray-900 shadow-sm outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600" placeholder="Q: What is your pricing model?&#10;A: ..."></textarea>
                                    </label>
                                </div>

                                <div class="mt-6 flex justify-end">
                                    <button
                                        type="button"
                                        data-campaign-detail-ignore-change
                                        x-on:click.stop="saveCampaignDetailBrandInlineSection('Industry & Market', 'industry')"
                                        :disabled="! campaignDetailInlineBrandSectionValid('industry')"
                                        class="inline-flex h-10 items-center justify-center rounded-md px-4 text-sm font-semibold transition focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
                                        :class="campaignDetailInlineBrandSectionValid('industry') ? 'bg-indigo-600 text-white shadow-sm hover:bg-indigo-500' : 'cursor-not-allowed bg-gray-200 text-gray-500 shadow-none'"
                                    >
                                        Save
                                    </button>
                                </div>
                            </section>

                            <section class="rounded-lg border border-gray-200 bg-white p-5 shadow-sm">
                                <div class="flex items-start gap-3">
                                    <span class="flex size-10 shrink-0 items-center justify-center rounded-md bg-indigo-50 text-indigo-600">
                                        <span class="outcraft-icon !text-[22px]">verified_user</span>
                                    </span>
                                    <div class="min-w-0">
                                        <h3 class="text-base font-semibold leading-6 text-gray-950">Compliance & Legal</h3>
                                        <p class="mt-1 text-sm leading-6 text-gray-500">Support contacts, terms, privacy, and compliance notes.</p>
                                    </div>
                                </div>

                                <div class="mt-6 flex justify-start">
                                    <button type="button" data-campaign-detail-ignore-change data-company-step-ai-action class="outcraft-ai-button inline-flex h-9 shrink-0 items-center justify-center gap-2 rounded-md border-2 border-transparent px-3 text-sm font-semibold text-gray-900 shadow-sm transition hover:text-gray-900">
                                        <svg class="outcraft-ai-sparkles" viewBox="0 0 105 103" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                            <path d="M31.6876 33.3482C33.0533 28.4835 39.9496 28.4835 41.3154 33.3482L44.4257 44.4273C46.3112 51.1432 51.5595 56.3915 58.2754 58.277L69.3545 61.3873C74.2192 62.7531 74.2192 69.6494 69.3545 71.0151L58.2754 74.1255C51.5595 76.0109 46.3112 81.2593 44.4257 87.9752L41.3154 99.0543C39.9496 103.919 33.0533 103.919 31.6876 99.0543L28.5772 87.9752C26.6918 81.2593 21.4434 76.0109 14.7275 74.1255L3.64844 71.0151C-1.21627 69.6494 -1.21627 62.7531 3.64844 61.3873L14.7275 58.277C21.4434 56.3915 26.6918 51.1432 28.5772 44.4273L31.6876 33.3482Z"/>
                                            <path d="M77.1504 2.91881C78.2429 -0.972965 83.76 -0.972956 84.8526 2.91881L87.046 10.7318C87.9887 14.0898 90.6129 16.714 93.9709 17.6567L101.784 19.8501C105.676 20.9427 105.676 26.4598 101.784 27.5523L93.9709 29.7458C90.6129 30.6885 87.9887 33.3127 87.046 36.6706L84.8526 44.4837C83.76 48.3754 78.2429 48.3754 77.1504 44.4837L74.9569 36.6706C74.0142 33.3127 71.39 30.6885 68.0321 29.7458L60.219 27.5523C56.3273 26.4598 56.3273 20.9427 60.219 19.8501L68.0321 17.6567C71.39 16.714 74.0142 14.0898 74.9569 10.7318L77.1504 2.91881Z"/>
                                        </svg>
                                        Fill with AI
                                    </button>
                                </div>

                                <div class="mt-6 grid gap-6">
                                    <label class="block">
                                        <span class="block text-sm/6 font-medium text-gray-900">Support Email</span>
                                        <input x-model="campaignDetailBrandInlineForm.supportEmail" type="email" placeholder="support@example.com" class="mt-2 block w-full rounded-md bg-white px-3 py-1.5 text-sm/6 text-gray-900 shadow-sm outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600">
                                        <span class="mt-2 block text-sm leading-6 text-gray-500">Human support email.</span>
                                    </label>

                                    <label class="block">
                                        <span class="block text-sm/6 font-medium text-gray-900">Terms of Service Page</span>
                                        <input x-model="campaignDetailBrandInlineForm.termsUrl" type="url" placeholder="https://example.com/terms-of-service" class="mt-2 block w-full rounded-md bg-white px-3 py-1.5 text-sm/6 text-gray-900 shadow-sm outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600">
                                        <span class="mt-2 block text-sm leading-6 text-gray-500">Link to your terms of service or user agreement page.</span>
                                    </label>

                                    <label class="block">
                                        <span class="block text-sm/6 font-medium text-gray-900">Privacy Policy Page</span>
                                        <input x-model="campaignDetailBrandInlineForm.privacyUrl" type="url" placeholder="https://example.com/privacy-policy" class="mt-2 block w-full rounded-md bg-white px-3 py-1.5 text-sm/6 text-gray-900 shadow-sm outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600">
                                        <span class="mt-2 block text-sm leading-6 text-gray-500">Link to your privacy policy or legal compliance page.</span>
                                    </label>

                                    <label class="block">
                                        <span class="block text-sm/6 font-medium text-gray-900">Certifications</span>
                                        <input x-model="campaignDetailBrandInlineForm.certifications" type="text" placeholder="SOC2, ISO 27001, HIPAA" class="mt-2 block w-full rounded-md bg-white px-3 py-1.5 text-sm/6 text-gray-900 shadow-sm outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600">
                                        <span class="mt-2 block text-sm leading-6 text-gray-500">List any relevant certifications your company holds.</span>
                                    </label>

                                    <label class="block">
                                        <span class="block text-sm/6 font-medium text-gray-900">Compliance</span>
                                        <input x-model="campaignDetailBrandInlineForm.compliance" type="text" placeholder="GDPR, CCPA, HIPAA" class="mt-2 block w-full rounded-md bg-white px-3 py-1.5 text-sm/6 text-gray-900 shadow-sm outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600">
                                        <span class="mt-2 block text-sm leading-6 text-gray-500">List any relevant compliance standards your company adheres to.</span>
                                    </label>
                                </div>

                                <div class="mt-6 flex justify-end">
                                    <button
                                        type="button"
                                        data-campaign-detail-ignore-change
                                        x-on:click.stop="saveCampaignDetailBrandInlineSection('Compliance & Legal', 'compliance')"
                                        class="inline-flex h-10 items-center justify-center rounded-md bg-indigo-600 px-4 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
                                    >
                                        Save
                                    </button>
                                </div>
                            </section>
                        </div>

                        <div x-show="campaignCreationV2Open" class="space-y-3">
                            <template x-for="company in campaignBuilderCompanyOptions()" :key="`campaign-detail-brand-${company.id}`">
                                <div
                                    class="oc-selectable-card group flex w-full items-center gap-3 rounded-lg bg-white p-4 text-left shadow-sm outline transition hover:outline-2 hover:-outline-offset-2 hover:outline-indigo-600"
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
                                    <span class="relative flex shrink-0 items-center" x-data="{ actionsOpen: false }" x-on:click.stop="null" x-on:click.outside="actionsOpen = false" x-on:keydown.escape.window="actionsOpen = false" data-campaign-detail-ignore-change>
                                        <button
                                            type="button"
                                            data-campaign-detail-ignore-change
                                            x-on:click.stop="actionsOpen = ! actionsOpen"
                                            class="inline-flex size-9 items-center justify-center rounded-md text-gray-400 transition hover:bg-gray-50 hover:text-gray-700 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
                                            :aria-label="`More actions for ${company.name}`"
                                            aria-haspopup="menu"
                                            :aria-expanded="actionsOpen.toString()"
                                        >
                                            <span class="outcraft-icon !text-[20px]">more_vert</span>
                                        </button>
                                        <div x-cloak x-show="actionsOpen" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="opacity-0 translate-y-1" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-1" data-dropdown-surface class="absolute right-0 top-10 z-40 w-36 rounded-md bg-white p-1 text-sm shadow-lg ring-1 ring-gray-900/10" role="menu">
                                            <button
                                                type="button"
                                                data-campaign-detail-ignore-change
                                                x-on:click.stop="actionsOpen = false; openCampaignBuilderBrandEditModal(company)"
                                                class="flex w-full items-center gap-2 rounded px-3 py-2 text-left text-gray-700 transition hover:bg-gray-50"
                                                role="menuitem"
                                            >
                                                <span class="outcraft-icon !text-[17px] text-gray-400">edit</span>
                                                Edit
                                            </button>
                                            <button
                                                type="button"
                                                data-campaign-detail-ignore-change
                                                x-on:click.stop="actionsOpen = false; deleteCampaignBuilderBrand(company)"
                                                class="flex w-full items-center gap-2 rounded px-3 py-2 text-left text-red-600 transition hover:bg-red-50"
                                                role="menuitem"
                                            >
                                                <span class="outcraft-icon !text-[17px]">delete</span>
                                                Remove
                                            </button>
                                        </div>
                                    </span>
                                </div>
                            </template>

                            <button
                                type="button"
                                data-campaign-detail-ignore-change
                                x-on:click.stop="openBrandCreateModal(null, { returnToCampaignDetail: true })"
                                class="oc-selectable-card flex w-full items-center gap-4 rounded-lg bg-white p-4 text-left shadow-sm outline outline-1 -outline-offset-1 outline-gray-300 transition hover:outline-2 hover:-outline-offset-2 hover:outline-indigo-600 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
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
                            x-show="activeCampaignDetailPanel === 'campaign-agent' && ! campaignDetailAiAgentInlineEditorOpen"
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
                                <div class="oc-selectable-card group flex w-full items-center gap-3 rounded-lg bg-white p-4 shadow-sm outline outline-1 -outline-offset-1 outline-gray-300 transition hover:outline-2 hover:-outline-offset-2 hover:outline-indigo-600">
                                    <div class="flex min-w-0 flex-1 items-center gap-4 text-left">
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
                                    </div>
                                    <button
                                        type="button"
                                        data-campaign-detail-ignore-change
                                        x-on:click.stop="openCampaignDetailAiAgentInlineEditor(agent)"
                                        class="relative z-10 inline-flex h-9 shrink-0 items-center justify-center rounded-md bg-white px-3 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 transition hover:bg-gray-50 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
                                    >
                                        Edit
                                    </button>
                                    <span class="relative flex shrink-0 items-center" x-data="{ actionsOpen: false }" x-on:click.stop="null" x-on:click.outside="actionsOpen = false" x-on:keydown.escape.window="actionsOpen = false" data-campaign-detail-ignore-change>
                                        <button
                                            type="button"
                                            data-campaign-detail-ignore-change
                                            x-on:click.stop="actionsOpen = ! actionsOpen"
                                            class="inline-flex size-9 items-center justify-center rounded-md text-gray-400 transition hover:bg-gray-50 hover:text-gray-700 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
                                            :aria-label="`More actions for ${aiAgentTitle(agent)}`"
                                            aria-haspopup="menu"
                                            :aria-expanded="actionsOpen.toString()"
                                        >
                                            <span class="outcraft-icon !text-[20px]">more_vert</span>
                                        </button>
                                        <div x-cloak x-show="actionsOpen" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="opacity-0 translate-y-1" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-1" data-dropdown-surface class="absolute right-0 top-10 z-40 w-36 rounded-md bg-white p-1 text-sm shadow-lg ring-1 ring-gray-900/10" role="menu">
                                            <button
                                                type="button"
                                                data-campaign-detail-ignore-change
                                                x-on:click.stop="actionsOpen = false; openAiAgentCreateModal(agent)"
                                                class="flex w-full items-center gap-2 rounded px-3 py-2 text-left text-gray-700 transition hover:bg-gray-50"
                                                role="menuitem"
                                            >
                                                <span class="outcraft-icon !text-[17px] text-gray-400">edit</span>
                                                Edit
                                            </button>
                                            <button
                                                type="button"
                                                data-campaign-detail-ignore-change
                                                x-on:click.stop="actionsOpen = false; deleteAiAgent(agent)"
                                                :disabled="! canDeleteAiAgent(agent.id)"
                                                class="flex w-full items-center gap-2 rounded px-3 py-2 text-left transition"
                                                :class="canDeleteAiAgent(agent.id) ? 'text-red-600 hover:bg-red-50' : 'cursor-not-allowed text-gray-300'"
                                                role="menuitem"
                                            >
                                                <span class="outcraft-icon !text-[17px]">delete</span>
                                                Remove
                                            </button>
                                        </div>
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
                            x-show="activeCampaignDetailPanel === 'campaign-agent' && campaignDetailAiAgentInlineEditorOpen"
                            x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 translate-y-3"
                            x-transition:enter-end="opacity-100 translate-y-0"
                            x-on:input="markCampaignDetailPanelChanged('campaign-agent')"
                            x-on:change="markCampaignDetailPanelChanged('campaign-agent')"
                            class="min-w-0"
                        >
                            @include('filament.pages.outreach.pages.ai-agents-inline-editor', [
                                'aiAgentInlineWrapperClass' => 'space-y-6',
                                'aiAgentInlineBackAction' => 'closeCampaignDetailAiAgentInlineEditor()',
                                'aiAgentInlineBackLabel' => 'Back to AI Agents',
                                'aiAgentInlineSaveAction' => 'saveCampaignDetailAiAgentInlineEditor()',
                            ])
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
                        <div class="space-y-3">
                            <template x-for="brand in brands" :key="`campaign-brand-picker-${brand.id}`">
                                <div
                                    class="oc-selectable-card group flex w-full items-center gap-3 rounded-lg bg-white p-4 text-left shadow-sm outline transition hover:outline-2 hover:-outline-offset-2 hover:outline-indigo-600"
                                    :class="campaignDetailSelectedBrandId === brand.id ? 'outline-2 -outline-offset-2 outline-indigo-600' : 'outline-1 -outline-offset-1 outline-gray-300'"
                                >
                                    <button
                                        type="button"
                                        x-on:click.stop="selectCampaignDetailBrand(brand.id)"
                                        class="flex min-w-0 flex-1 items-center gap-4 text-left focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
                                    >
                                        <span data-icon-tile class="flex size-10 shrink-0 items-center justify-center rounded-md bg-indigo-50 text-sm font-bold text-indigo-600" x-text="brandInitials(brand.name)"></span>
                                        <span class="min-w-0">
                                            <span class="block truncate text-sm font-semibold leading-6 text-gray-950" x-text="brand.name"></span>
                                            <span class="block truncate text-sm leading-6 text-gray-500" x-text="brand.website"></span>
                                        </span>
                                    </button>
                                    <span class="relative flex shrink-0 items-center" x-data="{ actionsOpen: false }" x-on:click.stop="null" x-on:click.outside="actionsOpen = false" x-on:keydown.escape.window="actionsOpen = false">
                                        <button
                                            type="button"
                                            x-on:click.stop="actionsOpen = ! actionsOpen"
                                            class="inline-flex size-9 items-center justify-center rounded-md text-gray-400 transition hover:bg-gray-50 hover:text-gray-700 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
                                            :aria-label="`More actions for ${brand.name}`"
                                            aria-haspopup="menu"
                                            :aria-expanded="actionsOpen.toString()"
                                        >
                                            <span class="outcraft-icon !text-[20px]">more_vert</span>
                                        </button>
                                        <div x-cloak x-show="actionsOpen" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="opacity-0 translate-y-1" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-1" data-dropdown-surface class="absolute right-0 top-10 z-40 w-36 rounded-md bg-white p-1 text-sm shadow-lg ring-1 ring-gray-900/10" role="menu">
                                            <button
                                                type="button"
                                                x-on:click.stop="actionsOpen = false; openCampaignBuilderBrandEditModal(brand)"
                                                class="flex w-full items-center gap-2 rounded px-3 py-2 text-left text-gray-700 transition hover:bg-gray-50"
                                                role="menuitem"
                                            >
                                                <span class="outcraft-icon !text-[17px] text-gray-400">edit</span>
                                                Edit
                                            </button>
                                            <button
                                                type="button"
                                                x-on:click.stop="actionsOpen = false; deleteCampaignBuilderBrand(brand)"
                                                class="flex w-full items-center gap-2 rounded px-3 py-2 text-left text-red-600 transition hover:bg-red-50"
                                                role="menuitem"
                                            >
                                                <span class="outcraft-icon !text-[17px]">delete</span>
                                                Remove
                                            </button>
                                        </div>
                                    </span>
                                </div>
                            </template>

                            <button
                                type="button"
                                x-on:click.stop="closeCampaignDetailBrandPicker(); openBrandCreateModal(null, { returnToCampaignDetail: true })"
                                class="oc-selectable-card flex w-full items-center gap-4 rounded-lg bg-white p-4 text-left shadow-sm outline outline-1 -outline-offset-1 outline-gray-300 transition hover:outline-2 hover:-outline-offset-2 hover:outline-indigo-600 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
                            >
                                <span class="flex size-10 shrink-0 items-center justify-center rounded-md oc-primary-bg text-white">
                                    <span class="outcraft-icon !text-[20px] text-white">plus</span>
                                </span>
                                <span class="min-w-0">
                                    <span class="block text-sm font-semibold leading-6 text-gray-950">Create New Brand</span>
                                    <span class="block text-sm leading-6 text-gray-500">Start a fresh company profile for this campaign.</span>
                                </span>
                            </button>
                        </div>
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
                                    <x-outcraft.checkbox
                                        mark-when="campaignDetailAgentPickerSelected(agent.id)"
                                        x-bind:checked="campaignDetailAgentPickerSelected(agent.id)"
                                        x-bind:disabled="campaignDetailAgentPickerLocked(agent.id)"
                                        x-on:change="toggleCampaignDetailAgentPicker(agent.id)"
                                    />
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
