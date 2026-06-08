        <section x-cloak x-show="! campaignBuilderOpen && ! campaignDetailOpen && ! campaignCreationV2Open && ! abTestDetailOpen && activeNav === 'Campaigns'" x-on:wheel="handleTopNavWheel($event)" data-outcraft-tab-header class="sticky top-0 z-30 bg-white transition-transform duration-200 ease-out will-change-transform" :class="topNavHeaderClass()">
            <div :class="topNavTabShellClass()">
                <div class="outcraft-tab-header-row flex items-stretch">
                    <button
                        type="button"
                        x-on:click.stop="openSidebarMenu()"
                        :class="topNavMenuButtonClass()"
                        aria-label="Open navigation"
                        :aria-expanded="mobileNavOpen.toString()"
                    >
                        <span class="outcraft-icon !text-[22px]">menu</span>
                    </button>
                    <div class="outcraft-tab-scroll min-h-0 min-w-0 flex-1 overflow-x-auto overflow-y-hidden">
                        <nav aria-label="Campaign tabs" :class="topNavTabListClass()">
                            <template x-for="(tab, tabIndex) in campaignPageTabs" :key="tab.label">
                                <button
                                    type="button"
                                    x-on:click="setCampaignPageTab(tab.label)"
                                    :class="topNavTabButtonClass(activeCampaignPageTab === tab.label, tabIndex, campaignPageTabs.length)"
                                >
                                    <span x-show="topNavTabIconsEnabled" class="outcraft-icon !text-[20px]" :class="topNavTabIconClass(activeCampaignPageTab === tab.label)" x-text="tab.icon"></span>
                                    <span x-text="tab.label"></span>
                                </button>
                            </template>
                        </nav>
                    </div>
                </div>
            </div>
        </section>

        <section x-cloak x-show="! campaignBuilderOpen && ! campaignDetailOpen && ! campaignCreationV2Open && ! abTestDetailOpen && activeNav === 'Campaigns'" class="mx-6 mt-5">
            <div class="flex min-h-[54px] items-start justify-between gap-x-6">
                <div>
                    <h1 class="text-xl font-bold leading-tight text-gray-950" x-text="activeCampaignPageTab"></h1>
                    <p class="mt-1 max-w-2xl text-sm/6 text-gray-500" x-text="campaignPageDescription()"></p>
                </div>
                <div x-show="activeCampaignPageTab !== 'Archived'" class="flex shrink-0 flex-wrap items-center justify-end gap-3">
                    <button type="button" x-on:click="activeCampaignPageTab === 'A/B Tests' ? openAbTestCreateModal() : startCampaignBuilder()" class="inline-flex h-10 shrink-0 items-center gap-2 rounded-md bg-indigo-600 px-3.5 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                        <span class="outcraft-icon !text-[18px] text-white">add</span>
                        <span x-text="activeCampaignPageTab === 'A/B Tests' ? 'Create New Test' : 'Create New'"></span>
                    </button>
                </div>
            </div>
        </section>

        <section data-card-surface x-cloak x-show="! campaignBuilderOpen && ! campaignDetailOpen && ! campaignCreationV2Open && ! abTestDetailOpen && activeNav === 'Campaigns' && activeCampaignPageTab !== 'A/B Tests'" class="mx-6 mb-6 mt-4 overflow-hidden rounded-lg border border-gray-200 bg-white shadow-sm">
            <ul role="list" class="divide-y divide-gray-100">
                <template x-for="campaign in campaignsPageRows()" :key="activeCampaignPageTab + campaign.name">
                    <li
                        x-data="{ actionsOpen: false }"
                        x-on:click="activeCampaignPageTab !== 'Archived' && openCampaignDetail(campaign)"
                        :class="activeCampaignPageTab === 'Archived' ? 'cursor-default' : 'cursor-pointer hover:bg-gray-50'"
                        class="flex items-center justify-between gap-x-6 px-6 py-5 transition"
                    >
                        <div class="flex min-w-0 items-center gap-x-4">
                            <span class="flex size-10 shrink-0 items-center justify-center rounded-md bg-indigo-50 text-indigo-600">
                                <span class="outcraft-icon !text-[22px]" x-text="campaignAvatarIcon(campaign)"></span>
                            </span>
                            <div class="min-w-0">
                                    <div class="flex flex-wrap items-center gap-x-3 gap-y-2">
                                        <p class="truncate text-sm font-semibold leading-6 text-gray-950" x-text="campaign.name"></p>
                                        <span
                                            class="outcraft-label inline-flex rounded-full px-2 py-1 text-xs font-medium ring-1 ring-inset"
                                            :class="campaign.status === 'Running' ? 'bg-green-50 text-green-700 ring-green-600/20' : 'bg-gray-50 text-gray-600 ring-gray-500/10'"
                                        >
                                            <span x-text="campaign.status"></span>
                                        </span>
                                        <span
                                            x-show="campaign.change"
                                            class="outcraft-label inline-flex rounded-full bg-amber-50 px-2 py-1 text-xs font-medium text-amber-800 ring-1 ring-inset ring-amber-600/20"
                                        >
                                            <span x-text="campaign.change"></span>
                                        </span>
                                </div>
                                <div class="mt-1 flex flex-wrap items-center gap-x-2 gap-y-1 text-xs leading-5 text-gray-500">
                                    <p class="whitespace-nowrap">Modified <span x-text="campaign.modified"></span></p>
                                </div>
                            </div>
                        </div>
                        <div class="flex flex-none items-center gap-x-4 self-center">
                            <div class="relative flex h-9 flex-none items-center" x-on:click.stop="null" x-on:keydown.escape.window="actionsOpen = false" x-on:click.outside="actionsOpen = false">
                                <button type="button" x-on:click="actionsOpen = !actionsOpen" class="relative inline-flex items-center text-gray-500 transition hover:text-gray-900" aria-label="Open options">
                                    <span class="absolute -inset-2.5"></span>
                                    <span class="outcraft-icon !text-[20px]">more_vert</span>
                                </button>
                                <div
                                    x-cloak
                                    x-show="actionsOpen"
                                    x-transition:enter="transition ease-out duration-100"
                                    x-transition:enter-start="opacity-0 translate-y-3"
                                    x-transition:enter-end="opacity-100 translate-y-0"
                                    x-transition:leave="transition ease-in duration-75"
                                    x-transition:leave-start="opacity-100 translate-y-0"
                                    x-transition:leave-end="opacity-0 translate-y-2"
                                    class="absolute -right-2.5 top-full z-40 mt-2 w-32 origin-top-right rounded-md bg-white py-2 shadow-lg ring-1 ring-gray-900/5"
                                >
                                    <button x-show="activeCampaignPageTab !== 'Archived'" type="button" x-on:click="actionsOpen = false; openCampaignDetail(campaign)" class="block w-full px-3 py-1 text-left text-sm leading-6 text-gray-900 transition hover:bg-gray-50">Edit</button>
                                    <button x-show="activeCampaignPageTab !== 'Archived'" type="button" class="block w-full px-3 py-1 text-left text-sm leading-6 text-gray-900 transition hover:bg-gray-50">Duplicate</button>
                                    <button type="button" x-on:click="actionsOpen = false; activeCampaignPageTab === 'Archived' ? restoreCampaign(campaign) : archiveCampaign(campaign)" class="block w-full px-3 py-1 text-left text-sm leading-6 text-gray-900 transition hover:bg-gray-50" x-text="activeCampaignPageTab === 'Archived' ? 'Restore' : 'Archive'"></button>
                                </div>
                            </div>
                        </div>
                    </li>
                </template>
            </ul>
        </section>

        <section data-card-surface x-cloak x-show="! campaignBuilderOpen && ! campaignDetailOpen && ! campaignCreationV2Open && ! abTestDetailOpen && activeNav === 'Campaigns' && activeCampaignPageTab === 'A/B Tests'" class="mx-6 mb-6 mt-4 overflow-hidden rounded-lg border border-gray-200 bg-white shadow-sm">
            <ul role="list" class="divide-y divide-gray-100">
                <template x-for="test in abTestCampaigns" :key="test.name">
                    <li x-on:click="openAbTestDetail(test)" class="flex cursor-pointer flex-col gap-4 px-4 py-5 transition hover:bg-gray-50 sm:px-6 lg:flex-row lg:items-start lg:gap-6">
                        <div class="flex min-w-0 items-start gap-x-4 lg:flex-1">
                            <span class="flex size-10 shrink-0 items-center justify-center rounded-md bg-indigo-50 text-indigo-600">
                                <span class="outcraft-icon !text-[22px]">science</span>
                            </span>
                            <div class="min-w-0">
                                <div class="flex flex-wrap items-center gap-x-3 gap-y-2">
                                    <p class="truncate text-sm font-semibold leading-6 text-gray-950" x-text="test.name"></p>
                                    <span class="outcraft-label inline-flex rounded-full px-2 py-1 text-xs font-medium ring-1 ring-inset" :class="abTestStatusClass(test)">
                                        <span x-text="test.status"></span>
                                    </span>
                                </div>
                                <p class="mt-1 whitespace-nowrap text-xs leading-5 text-gray-500">Modified <span x-text="test.modified"></span></p>
                            </div>
                        </div>

                        <div class="lg:w-40 lg:flex-none">
                            <p class="text-sm font-semibold leading-6 text-gray-950">Lead Count</p>
                            <p class="mt-1 text-xs leading-5 text-gray-500" x-text="test.leadCount"></p>
                        </div>

                        <div class="min-w-0 lg:w-80 lg:flex-none">
                            <p class="text-sm font-semibold leading-6 text-gray-950">Campaigns</p>
                            <div class="mt-1 space-y-1">
                                <template x-for="variant in test.variants" :key="test.name + variant">
                                    <p class="truncate text-xs leading-5 text-gray-500" x-text="variant"></p>
                                </template>
                            </div>
                        </div>
                    </li>
                </template>
            </ul>
        </section>

        @include('filament.pages.outreach.pages.campaigns.ab-test-create-modal')

        @include('filament.pages.outreach.pages.campaigns.ab-test-detail')

        @include('filament.pages.outreach.pages.campaigns.detail')
