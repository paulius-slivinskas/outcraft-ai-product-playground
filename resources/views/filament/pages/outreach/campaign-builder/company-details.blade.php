                    <div x-show="campaignBuilderStep < companySetupStartStep()" x-ref="companyDetailsFormStage" x-effect="campaignBuilderStep; updateCampaignBuilderStickyLayout(); updateCampaignBuilderBottomPadding()" data-campaign-builder-content-shell class="relative flex min-h-[calc(100vh-120px)] w-full items-center [overflow-anchor:none]" :style="`padding-bottom: ${campaignBuilderBottomPadding}px;`">
                        <button x-cloak x-show="! onboardingCampaignFlow" type="button" x-on:click="exitCampaignBuilder()" class="fixed right-[30px] top-[30px] z-40 inline-flex size-9 items-center justify-center rounded-md text-gray-400 transition hover:bg-gray-100 hover:text-gray-700 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600" aria-label="Close campaign setup">
                            <span class="outcraft-icon !text-[20px]">close</span>
                        </button>
                        <section
                            x-cloak
                            x-show="campaignBuilderStep === 0 || campaignBuilderScrollFromStep === 0"
                            x-ref="companyChooseSection"
                            :style="campaignBuilderCompanyStepStyle(0)"
                            class="mx-auto w-full max-w-2xl space-y-8 px-4 py-12 sm:px-6 lg:px-0"
                        >
                            <div class="text-center">
                                <span class="mx-auto mb-4 flex size-10 items-center justify-center rounded-md bg-indigo-50 text-indigo-600">
                                    <span class="outcraft-icon !text-[21px]">briefcase_business</span>
                                </span>
                                <h2 class="text-2xl font-bold leading-8 tracking-tight text-gray-950" x-text="campaignBuilderCompanyHeading()"></h2>
                                <p class="mx-auto mt-2 max-w-2xl text-sm leading-6 text-gray-600" x-text="campaignBuilderCompanyDescription()"></p>
                            </div>

                            <div class="space-y-3">
                                <template x-for="company in campaignBuilderCompanyOptions()" :key="company.id">
                                    <div
                                        x-show="! onboardingCampaignFlow"
                                        class="group flex w-full items-center gap-3 rounded-lg bg-white p-4 text-left shadow-sm outline outline-1 -outline-offset-1 outline-gray-300 transition hover:outline-2 hover:-outline-offset-2 hover:outline-indigo-600"
                                    >
                                        <button
                                            type="button"
                                            x-on:click="chooseExistingCompanyForSetup(company.id)"
                                            class="flex min-w-0 flex-1 items-center gap-4 text-left focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
                                        >
                                            <span data-icon-tile class="flex size-10 shrink-0 items-center justify-center rounded-md bg-indigo-50 text-sm font-bold text-indigo-600" x-text="company.name.slice(0, 1)"></span>
                                            <span class="min-w-0">
                                                <span class="block truncate text-sm font-semibold leading-6 text-gray-950" x-text="company.name"></span>
                                                <span class="block truncate text-sm leading-6 text-gray-500" x-text="company.website"></span>
                                            </span>
                                        </button>
                                        <span class="relative flex shrink-0 items-center" x-data="{ actionsOpen: false }" x-on:click.stop="null" x-on:click.outside="actionsOpen = false" x-on:keydown.escape.window="actionsOpen = false">
                                            <button
                                                type="button"
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
                                                    x-on:click.stop="actionsOpen = false; openCampaignBuilderBrandEditModal(company)"
                                                    class="flex w-full items-center gap-2 rounded px-3 py-2 text-left text-gray-700 transition hover:bg-gray-50"
                                                    role="menuitem"
                                                >
                                                    <span class="outcraft-icon !text-[17px] text-gray-400">edit</span>
                                                    Edit
                                                </button>
                                                <button
                                                    type="button"
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
                                    x-on:click="chooseNewCompanyForSetup()"
                                    class="flex w-full items-center gap-4 rounded-lg bg-white p-4 text-left shadow-sm outline outline-1 -outline-offset-1 outline-gray-300 transition hover:outline-2 hover:-outline-offset-2 hover:outline-indigo-600 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
                                >
                                    <span class="flex size-10 shrink-0 items-center justify-center rounded-md oc-primary-bg text-white">
                                        <span class="outcraft-icon !text-[20px] text-white">plus</span>
                                    </span>
                                    <span class="min-w-0">
                                        <span class="block text-sm font-semibold leading-6 text-gray-950" x-text="campaignBuilderCreateCompanyLabel()"></span>
                                        <span class="block text-sm leading-6 text-gray-500" x-text="campaignBuilderCreateCompanyDescription()"></span>
                                    </span>
                                </button>
                            </div>
                        </section>

                        <section
                            x-cloak
                            x-show="campaignBuilderStep === 1 || campaignBuilderScrollFromStep === 1"
                            x-ref="campaignAgentChooseSection"
                            :style="campaignBuilderCompanyStepStyle(1)"
                            class="mx-auto w-full max-w-2xl space-y-8 px-4 py-12 sm:px-6 lg:px-0"
                        >
                            <div class="text-center">
                                <span class="mx-auto mb-4 flex size-10 items-center justify-center rounded-md bg-indigo-50 text-indigo-600">
                                    <span class="outcraft-icon !text-[21px]">sparkle</span>
                                </span>
                                <h2 class="text-2xl font-bold leading-8 tracking-tight text-gray-950" x-text="campaignBuilderAgentHeading()"></h2>
                                <p class="mx-auto mt-2 max-w-2xl text-sm leading-6 text-gray-600" x-text="campaignBuilderAgentDescription()"></p>
                            </div>

                            <div class="space-y-3">
                                <template x-for="agent in campaignBuilderAiAgentOptions()" :key="`campaign-creation-agent-${agent.id}`">
                                    <div
                                        class="group flex w-full items-center gap-3 rounded-lg bg-white p-4 text-left shadow-sm outline transition hover:outline-2 hover:-outline-offset-2 hover:outline-indigo-600"
                                        :class="campaignCreationAiAgentSelected(agent.id) ? 'outline-2 -outline-offset-2 outline-indigo-600' : 'outline-1 -outline-offset-1 outline-gray-300'"
                                    >
                                        <label
                                            class="flex min-w-0 flex-1 cursor-pointer items-center gap-4 text-left"
                                        >
                                            <x-outcraft.checkbox
                                                mark-when="campaignCreationAiAgentSelected(agent.id)"
                                                x-bind:checked="campaignCreationAiAgentSelected(agent.id)"
                                                x-on:change="toggleCampaignCreationAiAgent(agent)"
                                            />
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
                                        </label>
                                        <span class="relative flex shrink-0 items-center" x-data="{ actionsOpen: false }" x-on:click.stop="null" x-on:click.outside="actionsOpen = false" x-on:keydown.escape.window="actionsOpen = false">
                                            <button
                                                type="button"
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
                                                    x-on:click.stop="actionsOpen = false; openAiAgentCreateModal(agent)"
                                                    class="flex w-full items-center gap-2 rounded px-3 py-2 text-left text-gray-700 transition hover:bg-gray-50"
                                                    role="menuitem"
                                                >
                                                    <span class="outcraft-icon !text-[17px] text-gray-400">edit</span>
                                                    Edit
                                                </button>
                                                <button
                                                    type="button"
                                                    x-on:click.stop="actionsOpen = false; deleteCampaignCreationAiAgent(agent)"
                                                    :disabled="! canDeleteCampaignCreationAiAgent(agent.id)"
                                                    class="flex w-full items-center gap-2 rounded px-3 py-2 text-left transition"
                                                    :class="canDeleteCampaignCreationAiAgent(agent.id) ? 'text-red-600 hover:bg-red-50' : 'cursor-not-allowed text-gray-300'"
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
                                    x-on:click="openCampaignCreationAiAgentModal()"
                                    class="flex w-full items-center gap-4 rounded-lg bg-white p-4 text-left shadow-sm outline outline-1 -outline-offset-1 outline-gray-300 transition hover:outline-2 hover:-outline-offset-2 hover:outline-indigo-600 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
                                >
                                    <span class="flex size-10 shrink-0 items-center justify-center rounded-md oc-primary-bg text-white">
                                        <span class="outcraft-icon !text-[20px] text-white">plus</span>
                                    </span>
                                    <span class="min-w-0">
                                        <span class="block text-sm font-semibold leading-6 text-gray-950" x-text="campaignBuilderCreateAgentLabel()"></span>
                                        <span class="block text-sm leading-6 text-gray-500" x-text="campaignBuilderCreateAgentDescription()"></span>
                                    </span>
                                </button>

                                <div class="flex justify-end pt-2">
                                    <button
                                        type="button"
                                        x-on:click="continueCampaignCreationAiAgents()"
                                        :disabled="! campaignCreationAiAgentCanContinue()"
                                        class="inline-flex h-10 items-center justify-center gap-2 rounded-md bg-indigo-600 px-4 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 disabled:cursor-not-allowed disabled:bg-indigo-300 disabled:text-white"
                                    >
                                        Continue
                                        <span class="outcraft-icon !text-[18px]">arrow_forward</span>
                                    </button>
                                </div>
                            </div>
                        </section>
                    </div>
