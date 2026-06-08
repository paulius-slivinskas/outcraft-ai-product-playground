			                    <div x-show="campaignBuilderStep >= companySetupStartStep()" x-ref="campaignAgentSection" :class="campaignSetupModeSelected && ! campaignSetupIntroStep ? '' : 'space-y-6'" :style="`padding-bottom: ${campaignSetupBottomPadding}px;`">
			                        <div x-show="! campaignSetupModeSelected" class="relative mx-auto flex min-h-[calc(100vh-96px)] w-full max-w-7xl flex-col items-center justify-center px-0 lg:px-4">
                                    <button x-cloak x-show="! onboardingCampaignFlow" type="button" x-on:click="exitCampaignBuilder()" class="fixed right-[30px] top-[30px] z-40 inline-flex size-9 items-center justify-center rounded-md text-gray-400 transition hover:bg-gray-100 hover:text-gray-700 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600" aria-label="Close campaign setup">
                                        <span class="outcraft-icon !text-[20px]">close</span>
                                    </button>
		                            <div x-show="campaignSetupIntroStep === 'type'" class="mx-auto w-full space-y-8 lg:max-w-[calc(80rem-18rem-3rem)] xl:max-w-[calc(80rem-18rem-4rem)]">
                                <div class="text-center">
                                    <span class="mx-auto mb-4 flex size-10 items-center justify-center rounded-md bg-indigo-50 text-indigo-600">
                                        <span class="outcraft-icon !text-[21px]">goal</span>
                                    </span>
                                    <h2 class="text-2xl font-bold leading-8 tracking-tight text-gray-950" x-text="campaignSetupHeading('type')"></h2>
                                    <p class="mx-auto mt-2 max-w-2xl text-sm leading-6 text-gray-600" x-text="campaignSetupDescription('type')"></p>
                                </div>
                                <template x-for="group in campaignTypeGroups" :key="group.label">
                                    <div>
                                        <h3 class="text-center text-sm font-semibold uppercase tracking-wide text-gray-400" x-text="group.label"></h3>
                                        <div class="mt-4 grid auto-rows-fr items-stretch gap-4 md:grid-cols-3">
                                            <template x-for="type in group.items" :key="type.name">
                                                <button type="button" data-card-surface x-on:click="selectCampaignType(type.name)" class="flex h-full flex-col items-start rounded-lg bg-white p-5 text-left shadow-sm outline outline-1 -outline-offset-1 transition hover:outline-2 hover:-outline-offset-2 hover:outline-indigo-600 hover:shadow-sm focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600" :class="campaignSetup.type === type.name ? 'outline-2 -outline-offset-2 outline-indigo-600' : 'outline-gray-300'">
                                                    <span class="mb-4 flex size-10 shrink-0 items-center justify-center rounded-md bg-indigo-50 text-indigo-600">
                                                        <span class="outcraft-icon !text-[21px]" x-text="type.icon"></span>
                                                    </span>
                                                    <span class="block text-sm font-bold text-gray-950" x-text="type.name"></span>
                                                    <span class="mt-1 block text-sm leading-6 text-gray-500" x-text="type.description"></span>
                                                    <span class="mt-3 inline-flex rounded-md bg-gray-50 px-2 py-1 text-xs font-medium text-gray-700 ring-1 ring-inset ring-gray-600/10" x-text="campaignTypeDirection(type.name)"></span>
                                                </button>
                                            </template>
                                        </div>
                                    </div>
                                </template>
                            </div>

	                            <div x-show="campaignSetupIntroStep === 'source'" class="mx-auto w-full space-y-8 lg:max-w-[calc(80rem-18rem-3rem)] xl:max-w-[calc(80rem-18rem-4rem)]">
                                <div class="text-center">
                                    <span class="mx-auto mb-4 flex size-10 items-center justify-center rounded-md bg-indigo-50 text-indigo-600">
                                        <span class="outcraft-icon !text-[21px]">blocks</span>
                                    </span>
                                    <h2 class="text-2xl font-bold leading-8 tracking-tight text-gray-950" x-text="campaignSetupHeading('source')"></h2>
                                    <p class="mx-auto mt-2 max-w-2xl text-sm leading-6 text-gray-600" x-text="campaignSetupDescription('source')"></p>
                                </div>
                                <template x-for="group in leadSourceGroups" :key="group.label">
                                    <div>
                                        <h3 class="text-center text-sm font-semibold uppercase tracking-wide text-gray-400" x-text="group.label"></h3>
                                        <div class="mt-4 grid auto-rows-fr items-stretch gap-4 md:grid-cols-3">
                                            <template x-for="source in group.items" :key="source.name">
                                                <button type="button" x-on:click="selectLeadSource(source.name)" class="flex h-full flex-col items-start rounded-lg bg-white p-5 text-left shadow-sm outline outline-1 -outline-offset-1 transition hover:outline-2 hover:-outline-offset-2 hover:outline-indigo-600 hover:shadow-sm focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600" :class="campaignSetup.source === source.name ? 'outline-2 -outline-offset-2 outline-indigo-600' : 'outline-gray-300'">
                                                    <span class="mb-4 flex size-10 shrink-0 items-center justify-center rounded-md" :class="leadSourceLogos[source.name] ? 'bg-gray-100 text-gray-700' : 'bg-indigo-50 text-indigo-600'">
                                                        <span x-show="leadSourceLogos[source.name]" class="outcraft-source-logo" x-html="leadSourceLogos[source.name]"></span>
                                                        <span x-show="! leadSourceLogos[source.name]" class="outcraft-icon !text-[21px]" x-text="source.icon"></span>
                                                    </span>
                                                    <span class="block text-sm font-bold text-gray-950" x-text="source.name"></span>
                                                    <span class="mt-2 block text-sm leading-6 text-gray-500" x-text="source.description"></span>
                                                </button>
                                            </template>
                                        </div>
                                    </div>
                                </template>
                            </div>

	                            <div x-show="campaignSetupIntroStep === 'integration'" class="mx-auto w-full space-y-8 lg:max-w-[calc(80rem-18rem-3rem)] xl:max-w-[calc(80rem-18rem-4rem)]">
                                <div class="text-center">
                                    <span class="mx-auto mb-4 flex size-10 items-center justify-center rounded-md bg-indigo-50 text-indigo-600">
                                        <span class="outcraft-icon !text-[21px]">unplug</span>
                                    </span>
                                    <h2 class="text-2xl font-bold leading-8 tracking-tight text-gray-950" x-text="campaignSetupHeading('integration')"></h2>
                                    <p class="mx-auto mt-2 max-w-2xl text-sm leading-6 text-gray-600" x-text="campaignSetupDescription('integration')"></p>
                                </div>
                                <div class="mx-auto max-w-2xl rounded-lg bg-white p-6 shadow-sm outline outline-1 -outline-offset-1 outline-gray-300">
                                    <div class="flex items-start gap-4">
                                        <span class="flex size-[60px] shrink-0 items-center justify-center rounded-md" :class="leadSourceLogoContainerClass(campaignSetup.source)">
                                            <span x-show="leadSourceLogos[campaignSetup.source]" class="outcraft-source-logo outcraft-source-logo-lg" x-html="leadSourceLogos[campaignSetup.source]"></span>
                                            <span x-show="! leadSourceLogos[campaignSetup.source]" class="outcraft-icon !text-[32px]" x-text="leadSourceIcon(campaignSetup.source)"></span>
                                        </span>
                                        <div class="min-w-0">
                                            <p class="text-xs font-semibold uppercase tracking-wide text-gray-400">Selected Lead Source</p>
                                            <h3 class="text-sm font-bold text-gray-950" x-text="campaignSetup.source || 'Lead Source'"></h3>
                                            <p class="mt-2 text-sm leading-6 text-gray-600">Connect your source to use real customer data, merge tags, and event triggers. You can skip this step, but AI will have less context to personalize conversations.</p>
                                        </div>
                                    </div>
	                                    <div class="mt-6 flex flex-wrap gap-3">
	                                        <button type="button" x-on:click="connectCampaignSource()" class="inline-flex h-9 items-center rounded-md bg-indigo-600 px-3 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-500" x-text="`Connect ${campaignSetup.source || 'Lead Source'}`"></button>
	                                        <button type="button" x-on:click="requestSkipCampaignIntegration()" class="inline-flex h-9 items-center rounded-md bg-white px-3 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 transition hover:bg-gray-50">Setup Later</button>
	                                    </div>
	                                    <button
	                                        x-show="campaignSetup.source === 'Klaviyo'"
	                                        type="button"
	                                        x-on:click="openKlaviyoEventsGuide()"
	                                        class="mt-6 flex w-full items-center justify-between gap-4 rounded-lg bg-white p-5 text-left shadow-sm outline outline-1 -outline-offset-1 outline-gray-300 transition hover:outline-2 hover:-outline-offset-2 hover:outline-indigo-600 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
	                                    >
	                                        <span class="min-w-0">
	                                            <span class="block text-sm font-bold text-gray-950">How to connect Klaviyo events</span>
	                                            <span class="mt-1 block text-sm leading-6 text-gray-500">Create Checkout Started and Order Placed flows with webhook actions.</span>
	                                        </span>
	                                        <span class="outcraft-icon shrink-0 !text-[20px] text-gray-400">arrow_forward</span>
	                                    </button>
	                                </div>
	                            </div>

	                            <div x-show="campaignSetupIntroStep === 'mode'" class="mx-auto w-full space-y-8 lg:max-w-[calc(80rem-18rem-3rem)] xl:max-w-[calc(80rem-18rem-4rem)]">
                                <div class="text-center">
                                    <span class="mx-auto mb-4 flex size-10 items-center justify-center rounded-md bg-indigo-50 text-indigo-600">
                                        <span class="outcraft-icon !text-[21px]">rocket</span>
                                    </span>
                                    <h2 class="text-2xl font-bold leading-8 tracking-tight text-gray-950">Choose How You Want to Set Up Your Campaign</h2>
                                    <p class="mx-auto mt-2 max-w-2xl text-sm leading-6 text-gray-600">Pick a guided path. You can move faster with recommended defaults or configure every campaign setting manually.</p>
                                </div>
                                <div class="mx-auto grid w-full max-w-5xl auto-rows-fr items-stretch gap-4 md:grid-cols-2">
                                <button type="button" x-on:click="chooseCampaignSetupPath('fast')" class="flex h-full flex-col items-start rounded-lg bg-white p-5 text-left shadow-sm outline outline-1 -outline-offset-1 outline-gray-300 transition hover:outline-2 hover:-outline-offset-2 hover:outline-indigo-600 hover:shadow-sm focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                                    <div class="flex items-start gap-4">
                                        <span class="flex size-10 shrink-0 items-center justify-center rounded-md bg-indigo-50 text-indigo-600">
                                            <span class="outcraft-icon !text-[21px]">zap</span>
                                        </span>
                                        <span>
                                            <span class="block text-sm font-bold text-gray-950">Fast Track</span>
                                            <span class="mt-1 block text-sm leading-6 text-gray-600">Good for getting to know the platform and testing your campaigns. You can switch to Full Setup later to configure campaigns fully.</span>
                                            <span class="mt-3 inline-flex rounded-md bg-indigo-50 px-2 py-1 text-xs font-medium text-indigo-700 ring-1 ring-inset ring-indigo-700/10">4 min</span>
                                        </span>
                                    </div>
                                </button>

                                <button type="button" x-on:click="chooseCampaignSetupPath('advanced')" class="flex h-full flex-col items-start rounded-lg bg-white p-5 text-left shadow-sm outline outline-1 -outline-offset-1 outline-gray-300 transition hover:outline-2 hover:-outline-offset-2 hover:outline-indigo-600 hover:shadow-sm focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                                    <div class="flex items-start gap-4">
                                        <span class="flex size-10 shrink-0 items-center justify-center rounded-md bg-indigo-50 text-indigo-600">
                                            <span class="outcraft-icon !text-[21px]">tune</span>
                                        </span>
                                        <span>
                                            <span class="block text-sm font-bold text-gray-950">Full Setup</span>
                                            <span class="mt-1 block text-sm leading-6 text-gray-600">Configure every campaign step, channel, schedule, AI agent setting, and launch rule.</span>
                                            <span class="mt-3 inline-flex rounded-md bg-indigo-50 px-2 py-1 text-xs font-medium text-indigo-700 ring-1 ring-inset ring-indigo-700/10">20 min</span>
                                        </span>
                                    </div>
                                </button>
                                </div>
                            </div>
                        </div>

	                        <div x-show="campaignSetupModeSelected && ! campaignSetupIntroStep" x-ref="campaignSetupPanel" x-effect="campaignSetup.current; campaignSetupModeSelected; campaignSetupIntroStep; campaignSetup.channelOpen.calls; campaignSetup.channelOpen.email; campaignSetup.channelOpen.sms; campaignSetup.channelOpen.whatsapp; campaignSetup.scheduleMode; agentAdvancedOpen; channelsAdvancedOpen; scheduleCampaignBuilderLayoutUpdate()" class="relative z-10 bg-gray-50" :style="campaignSetupCanvasStyle">
                            <div x-ref="campaignSetupPanelScroller" data-campaign-builder-content-shell class="relative min-h-full w-full bg-gray-50 pb-24">
                            <section x-cloak x-show="campaignSetup.current === 'start' || campaignSetupScrollFromStep === 'start'" x-ref="campaignSetupStep_start"
                                :style="campaignSetupStepStyle('start')"
                                data-campaign-setup-step
                                class="space-y-6 pr-2 pb-4">
                                <div class="mb-1">
                                    <p class="text-sm font-semibold text-indigo-600" x-text="`${campaignSetupMode === 'fast' ? 'Fast Setup' : 'Advanced Setup'} · Step ${campaignSetupStepIndex('start') + 1} of ${campaignSetupStepsForMode().length}`"></p>
                                    <span class="mb-4 flex size-10 items-center justify-center rounded-md bg-indigo-50 text-indigo-600">
                                        <span class="outcraft-icon !text-[21px]" x-text="campaignSetupStepIcon('start')"></span>
                                    </span>
                                    <h2 class="mt-2 text-2xl font-bold leading-8 tracking-tight text-gray-950" x-text="campaignSetupHeading('start')"></h2>
                                    <p class="mt-2 max-w-3xl text-sm leading-6 text-gray-600" x-text="campaignSetupDescription('start')"></p>
                                </div>
                                <div class="max-w-xl">
                                    <label class="block">
                                        <span class="block text-sm/6 font-medium text-gray-900">Campaign Name</span>
                                        <input x-model="campaignSetup.name" type="text" placeholder="Generated automatically from campaign type" class="mt-2 block w-full rounded-md bg-white px-3 py-1.5 text-sm/6 text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600">
                                        <span class="mt-2 block text-sm leading-6 text-gray-500">You can rename the campaign later.</span>
                                    </label>
                            </section>

                            <section x-cloak x-show="campaignSetup.current === 'type' || campaignSetupScrollFromStep === 'type'" x-ref="campaignSetupStep_type"
                                :style="campaignSetupStepStyle('type')"
                                data-campaign-setup-step
                                class="space-y-7 pr-2 pb-4">
                                <div class="mb-1">
                                    <p class="text-sm font-semibold text-indigo-600" x-text="`${campaignSetupMode === 'fast' ? 'Fast Setup' : 'Advanced Setup'} · Step ${campaignSetupStepIndex('type') + 1} of ${campaignSetupStepsForMode().length}`"></p>
                                    <span class="mb-4 flex size-10 items-center justify-center rounded-md bg-indigo-50 text-indigo-600">
                                        <span class="outcraft-icon !text-[21px]" x-text="campaignSetupStepIcon('type')"></span>
                                    </span>
                                    <h2 class="mt-2 text-2xl font-bold leading-8 tracking-tight text-gray-950" x-text="campaignSetupHeading('type')"></h2>
                                    <p class="mt-2 max-w-3xl text-sm leading-6 text-gray-600" x-text="campaignSetupDescription('type')"></p>
                                </div>
                                <template x-for="group in campaignTypeGroups" :key="group.label">
                                    <div>
                                        <h3 class="text-sm font-semibold uppercase tracking-wide text-gray-400" x-text="group.label"></h3>
                                        <div class="mt-4 grid gap-4 md:grid-cols-2">
                                            <template x-for="type in group.items" :key="type.name">
                                                <button type="button" data-card-surface x-on:click="selectCampaignType(type.name)" class="flex h-full flex-col items-start rounded-lg bg-white p-5 text-left shadow-sm outline outline-1 -outline-offset-1 transition hover:outline-2 hover:-outline-offset-2 hover:outline-indigo-600 hover:shadow-sm focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600" :class="campaignSetup.type === type.name ? 'outline-2 -outline-offset-2 outline-indigo-600' : 'outline-gray-300'">
                                                    <span class="mb-4 flex size-10 shrink-0 items-center justify-center rounded-md bg-indigo-50 text-indigo-600">
                                                        <span class="outcraft-icon !text-[21px]" x-text="type.icon"></span>
                                                    </span>
                                                    <span class="block text-sm font-bold text-gray-950" x-text="type.name"></span>
                                                    <span class="mt-1 block text-sm leading-6 text-gray-500" x-text="type.description"></span>
                                                    <span class="mt-3 inline-flex rounded-md bg-gray-50 px-2 py-1 text-xs font-medium text-gray-700 ring-1 ring-inset ring-gray-600/10" x-text="campaignTypeDirection(type.name)"></span>
                                                    <p class="mt-4 rounded-md bg-gray-50 p-3 text-xs leading-5 text-gray-500" x-text="type.example"></p>
                                                </button>
                                            </template>
                                        </div>
                                    </div>
                                </template>
                            </section>

                            <section x-cloak x-show="campaignSetup.current === 'source' || campaignSetupScrollFromStep === 'source'" x-ref="campaignSetupStep_source"
                                :style="campaignSetupStepStyle('source')"
                                data-campaign-setup-step
                                class="space-y-7 pr-2 pb-4">
                                <div class="mb-1">
                                    <p class="text-sm font-semibold text-indigo-600" x-text="`${campaignSetupMode === 'fast' ? 'Fast Setup' : 'Advanced Setup'} · Step ${campaignSetupStepIndex('source') + 1} of ${campaignSetupStepsForMode().length}`"></p>
                                    <span class="mb-4 flex size-10 items-center justify-center rounded-md bg-indigo-50 text-indigo-600">
                                        <span class="outcraft-icon !text-[21px]" x-text="campaignSetupStepIcon('source')"></span>
                                    </span>
                                    <h2 class="mt-2 text-2xl font-bold leading-8 tracking-tight text-gray-950" x-text="campaignSetupHeading('source')"></h2>
                                    <p class="mt-2 max-w-3xl text-sm leading-6 text-gray-600" x-text="campaignSetupDescription('source')"></p>
                                </div>
                                <template x-for="group in leadSourceGroups" :key="group.label">
                                    <div>
                                        <h3 class="text-sm font-semibold uppercase tracking-wide text-gray-400" x-text="group.label"></h3>
                                        <div class="mt-4 grid gap-4 md:grid-cols-2">
                                            <template x-for="source in group.items" :key="source.name">
                                                <button type="button" x-on:click="selectLeadSource(source.name)" class="flex h-full flex-col items-start rounded-lg bg-white p-5 text-left shadow-sm outline outline-1 -outline-offset-1 transition hover:outline-2 hover:-outline-offset-2 hover:outline-indigo-600 hover:shadow-sm focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600" :class="campaignSetup.source === source.name ? 'outline-2 -outline-offset-2 outline-indigo-600' : 'outline-gray-300'">
                                                    <span class="mb-4 flex size-10 shrink-0 items-center justify-center rounded-md" :class="leadSourceLogos[source.name] ? 'bg-gray-100 text-gray-700' : 'bg-indigo-50 text-indigo-600'">
                                                        <span x-show="leadSourceLogos[source.name]" class="outcraft-source-logo" x-html="leadSourceLogos[source.name]"></span>
                                                        <span x-show="! leadSourceLogos[source.name]" class="outcraft-icon !text-[21px]" x-text="source.icon"></span>
                                                    </span>
                                                    <span class="block text-sm font-bold text-gray-950" x-text="source.name"></span>
                                                    <span class="mt-2 block text-sm leading-6 text-gray-500" x-text="source.description"></span>
                                                </button>
                                            </template>
                                        </div>
                                    </div>
                                </template>
                            </section>

                            <section x-cloak x-show="campaignSetup.current === 'integration' || campaignSetupScrollFromStep === 'integration'" x-ref="campaignSetupStep_integration"
                                :style="campaignSetupStepStyle('integration')"
                                data-campaign-setup-step
                                class="space-y-6 pr-2 pb-4">
                                <div class="mb-1">
                                    <p class="text-sm font-semibold text-indigo-600" x-text="`${campaignSetupMode === 'fast' ? 'Fast Setup' : 'Advanced Setup'} · Step ${campaignSetupStepIndex('integration') + 1} of ${campaignSetupStepsForMode().length}`"></p>
                                    <span class="mb-4 flex size-10 items-center justify-center rounded-md bg-indigo-50 text-indigo-600">
                                        <span class="outcraft-icon !text-[21px]" x-text="campaignSetupStepIcon('integration')"></span>
                                    </span>
                                    <h2 class="mt-2 text-2xl font-bold leading-8 tracking-tight text-gray-950" x-text="campaignSetupHeading('integration')"></h2>
                                    <p class="mt-2 max-w-3xl text-sm leading-6 text-gray-600" x-text="campaignSetupDescription('integration')"></p>
                                </div>
                                <template x-if="campaignSetup.source === 'CSV File / Manual'">
                                    <div class="rounded-lg border border-green-200 bg-green-50 p-5">
                                        <h3 class="text-sm font-bold text-green-900">No Integration Required</h3>
                                        <p class="mt-2 text-sm leading-6 text-green-700">Upload a CSV placeholder or create a test lead now. You can import real leads later.</p>
                                        <div class="mt-5 grid gap-4 sm:grid-cols-2">
                                            <input type="text" value="leads.csv" class="rounded-md border-0 px-3 py-2 text-sm ring-1 ring-inset ring-green-200">
                                            <button type="button" class="inline-flex h-9 items-center justify-center rounded-md bg-white px-3 text-sm font-semibold text-green-700 ring-1 ring-inset ring-green-600">Create Test Lead</button>
                                        </div>
                                    </div>
                                </template>
                                <template x-if="campaignSetup.source !== 'CSV File / Manual'">
                                    <div class="rounded-lg border border-gray-200 p-5">
                                        <div class="flex flex-wrap items-start justify-between gap-4">
                                            <div class="flex items-start gap-4">
                                                <span class="flex size-[60px] shrink-0 items-center justify-center rounded-md" :class="leadSourceLogoContainerClass(campaignSetup.source)">
                                                    <span x-show="leadSourceLogos[campaignSetup.source]" class="outcraft-source-logo outcraft-source-logo-lg" x-html="leadSourceLogos[campaignSetup.source]"></span>
                                                    <span x-show="! leadSourceLogos[campaignSetup.source]" class="outcraft-icon !text-[32px]" x-text="leadSourceIcon(campaignSetup.source)"></span>
                                                </span>
                                                <div class="min-w-0">
                                                    <p class="text-xs font-semibold uppercase tracking-wide text-gray-400">Selected Lead Source</p>
                                                    <h3 class="text-base font-bold text-gray-950" x-text="campaignSetup.source || 'Lead Source'"></h3>
                                                    <p class="mt-2 max-w-2xl text-sm leading-6 text-gray-600">Connect your source to use real customer data, merge tags, and event triggers. You can skip this step, but AI will have less context to personalize conversations.</p>
                                                </div>
                                            </div>
                                        <span class="inline-flex rounded-md px-2 py-1 text-xs font-medium ring-1 ring-inset" :class="campaignSetup.integrationStatus === 'Connected' ? 'bg-green-50 text-green-700 ring-green-600/20' : campaignSetup.integrationStatus === 'Skipped for Now' ? 'bg-amber-50 text-amber-700 ring-amber-600/20' : 'bg-gray-50 text-gray-700 ring-gray-600/20'" x-text="campaignSetup.integrationStatus"></span>
                                        </div>
                                        <div class="mt-6 flex flex-wrap gap-3">
                                            <button type="button" x-on:click="connectCampaignSource()" class="inline-flex h-9 items-center rounded-md bg-indigo-600 px-3 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-500" x-text="`Connect ${campaignSetup.source || 'Source'}`"></button>
                                            <button type="button" x-on:click="requestSkipCampaignIntegration()" class="inline-flex h-9 items-center rounded-md bg-white px-3 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 transition hover:bg-gray-50">Setup Later</button>
                                        </div>
                                        <button
                                            x-show="campaignSetup.source === 'Klaviyo'"
                                            type="button"
                                            x-on:click="openKlaviyoEventsGuide()"
                                            class="mt-6 flex w-full items-center justify-between gap-4 rounded-lg bg-white p-5 text-left shadow-sm outline outline-1 -outline-offset-1 outline-gray-300 transition hover:outline-2 hover:-outline-offset-2 hover:outline-indigo-600 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
                                        >
                                            <span class="min-w-0">
                                                <span class="block text-sm font-bold text-gray-950">How to connect Klaviyo events</span>
                                                <span class="mt-1 block text-sm leading-6 text-gray-500">Create Checkout Started and Order Placed flows with webhook actions.</span>
                                            </span>
                                            <span class="outcraft-icon shrink-0 !text-[20px] text-gray-400">arrow_forward</span>
                                        </button>
                                    </div>
                                </template>
                            </section>

                            <section x-cloak x-show="campaignSetup.current === 'brief' || campaignSetupScrollFromStep === 'brief'" x-ref="campaignSetupStep_brief"
                                :style="campaignSetupStepStyle('brief')"
                                data-campaign-setup-step
                                class="pr-2 pb-4">
                                <div class="mb-1">
                                    <p class="text-sm font-semibold text-indigo-600" x-text="`${campaignSetupMode === 'fast' ? 'Fast Setup' : 'Advanced Setup'} · Step ${campaignSetupStepIndex('brief') + 1} of ${campaignSetupStepsForMode().length}`"></p>
                                    <div data-step-icon-row>
                                        <span class="flex size-10 items-center justify-center rounded-md bg-indigo-50 text-indigo-600">
                                            <span class="outcraft-icon !text-[21px]" x-text="campaignSetupStepIcon('brief')"></span>
                                        </span>
                                    </div>
                                    <h2 class="mt-2 text-2xl font-bold leading-8 tracking-tight text-gray-950" x-text="campaignSetupHeading('brief')"></h2>
                                    <p class="mt-2 max-w-3xl text-sm leading-6 text-gray-600" x-text="campaignSetupDescription('brief')"></p>
                                </div>
                                <div x-show="campaignSetup.briefTab === 'context'" class="mt-6 space-y-7">
                                        <div>
                                            <div class="mb-2 flex items-center justify-between gap-3">
                                                <label class="block text-sm/6 font-semibold text-gray-900">Campaign Context & Instructions<span class="text-indigo-400">*</span></label>
                                                <div class="flex items-center gap-1">
                                                    <div class="relative" x-data="{ contextActionsOpen: false }" x-on:click.outside="contextActionsOpen = false">
                                                        <button type="button" x-on:click="contextActionsOpen = ! contextActionsOpen" class="inline-flex size-7 items-center justify-center rounded-md text-gray-400 transition hover:bg-gray-50 hover:text-gray-700" aria-label="Campaign context actions">
                                                            <span class="outcraft-icon !text-[18px]">more_vert</span>
                                                        </button>
                                                        <div x-cloak x-show="contextActionsOpen" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-3" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-2" class="absolute right-0 z-40 mt-2 w-48 rounded-md bg-white py-1 shadow-lg ring-1 ring-gray-900/10">
                                                            <button type="button" x-on:click="openCampaignCustomFields(); contextActionsOpen = false" class="flex w-full items-center gap-2 px-3 py-2 text-left text-sm font-medium text-gray-700 transition hover:bg-gray-50 hover:text-gray-950">
                                                                <span class="text-xs text-gray-400">{+}</span>
                                                                Open Custom Fields
                                                            </button>
	                                                            <button type="button" x-on:click="contextActionsOpen = false" class="flex w-full items-center gap-2 px-3 py-2 text-left text-sm font-medium text-gray-700 transition hover:bg-gray-50 hover:text-gray-950">
	                                                                <span class="outcraft-icon !text-[15px] text-gray-400">settings</span>
	                                                                Configure Custom Fields
	                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div data-component="custom-field-text-input" class="overflow-hidden rounded-lg border border-gray-300 bg-white shadow-sm transition focus-within:border-indigo-600 focus-within:ring-1 focus-within:ring-indigo-600">
                                                <div class="relative grid min-w-0 overflow-hidden transition-[grid-template-columns] duration-200 ease-out" :class="campaignSetup.customFieldsLayoutOpen ? 'lg:grid-cols-[minmax(0,1fr)_285px]' : 'lg:grid-cols-1'">
                                                    <textarea
                                                        x-model="campaignSetup.brief.context"
                                                        rows="4"
                                                        placeholder="Describe the campaign situation, goal, and how the agent should behave."
                                                        class="block min-h-[112px] min-w-0 w-full resize-y border-0 bg-white px-3 py-2 text-sm/6 text-gray-700 outline-none placeholder:text-gray-400 focus:ring-0"
                                                    ></textarea>
                                                    <aside
                                                        x-cloak
                                                        x-show="campaignSetup.customFieldsOpen"
                                                        x-transition:enter="transition ease-out duration-200"
                                                        x-transition:enter-start="translate-x-full opacity-0"
                                                        x-transition:enter-end="translate-x-0 opacity-100"
                                                        x-transition:leave="transition ease-in duration-150"
                                                        x-transition:leave-start="translate-x-0 opacity-100"
                                                        x-transition:leave-end="translate-x-full opacity-0"
                                                        class="border-t border-gray-200 bg-white lg:border-t-0 lg:border-l"
                                                    >
                                                        <div class="flex items-center gap-2 border-b border-gray-200 px-4 py-3">
                                                            <label class="min-w-0 flex-1">
                                                                <input x-model="campaignSetup.customFieldSearch" type="search" placeholder="Search Custom Fields" class="block h-9 w-full rounded-md bg-white px-3 py-1.5 text-sm text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600">
                                                            </label>
                                                            <button type="button" x-on:click="closeCampaignCustomFields()" class="inline-flex size-7 items-center justify-center rounded-md text-gray-400 transition hover:bg-white hover:text-gray-700" aria-label="Close custom fields">
                                                                <span class="outcraft-icon !text-[18px]">close</span>
                                                            </button>
                                                        </div>
                                                        <div class="flex flex-wrap gap-2 px-4 py-4">
                                                            <template x-for="tag in filteredCustomFields()" :key="tag">
                                                                <button type="button" class="inline-flex h-8 items-center rounded-md bg-white px-2.5 text-sm font-medium text-gray-600 shadow-sm ring-1 ring-inset ring-gray-200 transition hover:bg-gray-50 hover:text-gray-900" x-text="tag"></button>
                                                            </template>
                                                            <p x-show="filteredCustomFields().length === 0" class="text-sm text-gray-500">No Custom Fields Found.</p>
                                                        </div>
                                                    </aside>
                                                </div>
                                            </div>
                                            <p class="mt-2 text-sm leading-6 text-gray-500">Describe the situation, goal, and how the agent should behave (incl. edge cases).</p>
                                        </div>

                                        <div>
                                            <div class="mb-2 flex items-center justify-between gap-3">
                                                <label class="block text-sm/6 font-semibold text-gray-900">Qualification Questions<span class="text-indigo-400">*</span></label>
                                            </div>
                                            <textarea x-model="campaignSetup.brief.qualificationQuestions" rows="4" class="block w-full rounded-md bg-white px-3 py-2 text-sm/6 text-gray-700 shadow-sm outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600"></textarea>
                                            <p class="mt-2 text-sm leading-6 text-gray-500">List the key questions the AI should ask to determine whether the lead is a good fit for the offer.</p>
                                        </div>

                                        <div>
                                            <div class="mb-2 flex items-center justify-between gap-3">
                                                <label class="block text-sm/6 font-semibold text-gray-900">What Answers Confirm Qualification?<span class="text-indigo-400">*</span></label>
                                            </div>
                                            <textarea x-model="campaignSetup.brief.qualifiedAnswers" rows="4" class="block w-full rounded-md bg-white px-3 py-2 text-sm/6 text-gray-700 shadow-sm outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600"></textarea>
                                            <p class="mt-2 text-sm leading-6 text-gray-500">Enter one qualifying answer per line. If the lead meets these answers, they are considered qualified.</p>
                                        </div>
                                </div>
                                <div x-show="campaignSetup.briefTab === 'discovery'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-3" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-2" class="mt-6 space-y-7">
                                    <div>
                                        <div class="mb-2 flex items-center justify-between gap-3">
                                            <label class="block text-sm/6 font-semibold text-gray-900">Campaign Goal</label>
                                            <span class="relative" x-data="{ fieldActionsOpen: false }" x-on:click.outside="fieldActionsOpen = false">
                                                <button type="button" x-on:click="fieldActionsOpen = ! fieldActionsOpen" class="inline-flex size-7 items-center justify-center rounded-md text-gray-400 transition hover:bg-gray-50 hover:text-gray-700" aria-label="Campaign goal custom field actions">
                                                    <span class="outcraft-icon !text-[18px]">more_vert</span>
                                                </button>
                                                <span x-cloak x-show="fieldActionsOpen" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-3" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-2" class="absolute right-0 z-40 mt-2 w-52 rounded-md bg-white py-1 shadow-lg ring-1 ring-gray-900/10">
                                                    <button type="button" x-on:click="openCustomFieldTextInput('briefGoal'); fieldActionsOpen = false" class="flex w-full items-center gap-2 px-3 py-2 text-left text-sm font-medium text-gray-700 transition hover:bg-gray-50 hover:text-gray-950"><span class="text-xs text-gray-400">{+}</span>Open Custom Fields</button>
                                                    <button type="button" x-on:click="fieldActionsOpen = false" class="flex w-full items-center gap-2 px-3 py-2 text-left text-sm font-medium text-gray-700 transition hover:bg-gray-50 hover:text-gray-950"><span class="outcraft-icon !text-[15px] text-gray-400">settings</span>Configure Custom Fields</button>
                                                </span>
                                            </span>
                                        </div>
                                        <div data-component="custom-field-text-input" class="overflow-hidden rounded-lg border border-gray-300 bg-white shadow-sm transition focus-within:border-indigo-600 focus-within:ring-1 focus-within:ring-indigo-600">
                                            <div class="relative grid min-w-0 overflow-hidden transition-[grid-template-columns] duration-200 ease-out" :class="customFieldTextInputState('briefGoal').layoutOpen ? 'lg:grid-cols-[minmax(0,1fr)_18rem]' : 'lg:grid-cols-1'">
                                                <textarea x-model="campaignSetup.brief.goal" rows="4" class="block min-h-[112px] min-w-0 w-full resize-y border-0 bg-white px-3 py-2 text-sm/6 text-gray-700 outline-none placeholder:text-gray-400 focus:ring-0"></textarea>
                                                <aside x-cloak x-show="customFieldTextInputState('briefGoal').open" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="translate-x-full opacity-0" x-transition:enter-end="translate-x-0 opacity-100" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="translate-x-0 opacity-100" x-transition:leave-end="translate-x-full opacity-0" class="min-w-0 border-t border-gray-200 bg-white lg:border-t-0 lg:border-l lg:border-gray-200">
                                                    <div class="flex items-center gap-2 border-b border-gray-200 px-4 py-3"><label class="min-w-0 flex-1"><input :value="customFieldTextInputState('briefGoal').search" x-on:input="customFieldTextInputState('briefGoal').search = $event.target.value" type="search" placeholder="Search Custom Fields" class="block h-9 w-full rounded-md bg-white px-3 py-1.5 text-sm text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600"></label><button type="button" x-on:click="closeCustomFieldTextInput('briefGoal')" class="inline-flex size-7 items-center justify-center rounded-md text-gray-400 transition hover:bg-white hover:text-gray-700" aria-label="Close custom fields"><span class="outcraft-icon !text-[18px]">close</span></button></div>
                                                    <div class="flex flex-wrap gap-2 px-4 py-4"><template x-for="tag in filteredCustomFieldTextInputTags('briefGoal')" :key="`brief-goal-${tag}`"><button type="button" class="inline-flex h-8 items-center rounded-md bg-white px-2.5 text-sm font-medium text-gray-600 shadow-sm ring-1 ring-inset ring-gray-200 transition hover:bg-gray-50 hover:text-gray-900" x-text="tag"></button></template><p x-show="filteredCustomFieldTextInputTags('briefGoal').length === 0" class="text-sm text-gray-500">No Custom Fields Found.</p></div>
                                                </aside>
                                            </div>
                                        </div>
	                                        <p class="mt-2 text-sm leading-6 text-gray-500">Define what the AI should accomplish and when the conversation is considered successful.</p>
                                    </div>

                                    <div>
                                        <div class="mb-2 flex items-center justify-between gap-3">
                                            <label class="block text-sm/6 font-semibold text-gray-900">Lead Situation</label>
                                            <span class="relative" x-data="{ fieldActionsOpen: false }" x-on:click.outside="fieldActionsOpen = false">
                                                <button type="button" x-on:click="fieldActionsOpen = ! fieldActionsOpen" class="inline-flex size-7 items-center justify-center rounded-md text-gray-400 transition hover:bg-gray-50 hover:text-gray-700" aria-label="Lead situation custom field actions"><span class="outcraft-icon !text-[18px]">more_vert</span></button>
                                                <span x-cloak x-show="fieldActionsOpen" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-3" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-2" class="absolute right-0 z-40 mt-2 w-52 rounded-md bg-white py-1 shadow-lg ring-1 ring-gray-900/10">
                                                    <button type="button" x-on:click="openCustomFieldTextInput('leadSituation'); fieldActionsOpen = false" class="flex w-full items-center gap-2 px-3 py-2 text-left text-sm font-medium text-gray-700 transition hover:bg-gray-50 hover:text-gray-950"><span class="text-xs text-gray-400">{+}</span>Open Custom Fields</button>
                                                    <button type="button" x-on:click="fieldActionsOpen = false" class="flex w-full items-center gap-2 px-3 py-2 text-left text-sm font-medium text-gray-700 transition hover:bg-gray-50 hover:text-gray-950"><span class="outcraft-icon !text-[15px] text-gray-400">settings</span>Configure Custom Fields</button>
                                                </span>
                                            </span>
                                        </div>
                                        <div data-component="custom-field-text-input" class="overflow-hidden rounded-lg border border-gray-300 bg-white shadow-sm transition focus-within:border-indigo-600 focus-within:ring-1 focus-within:ring-indigo-600">
                                            <div class="relative grid min-w-0 overflow-hidden transition-[grid-template-columns] duration-200 ease-out" :class="customFieldTextInputState('leadSituation').layoutOpen ? 'lg:grid-cols-[minmax(0,1fr)_18rem]' : 'lg:grid-cols-1'">
                                                <textarea x-model="campaignSetup.brief.leadSituation" rows="4" class="block min-h-[112px] min-w-0 w-full resize-y border-0 bg-white px-3 py-2 text-sm/6 text-gray-700 outline-none placeholder:text-gray-400 focus:ring-0"></textarea>
                                                <aside x-cloak x-show="customFieldTextInputState('leadSituation').open" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="translate-x-full opacity-0" x-transition:enter-end="translate-x-0 opacity-100" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="translate-x-0 opacity-100" x-transition:leave-end="translate-x-full opacity-0" class="min-w-0 border-t border-gray-200 bg-white lg:border-t-0 lg:border-l lg:border-gray-200">
                                                    <div class="flex items-center gap-2 border-b border-gray-200 px-4 py-3"><label class="min-w-0 flex-1"><input :value="customFieldTextInputState('leadSituation').search" x-on:input="customFieldTextInputState('leadSituation').search = $event.target.value" type="search" placeholder="Search Custom Fields" class="block h-9 w-full rounded-md bg-white px-3 py-1.5 text-sm text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600"></label><button type="button" x-on:click="closeCustomFieldTextInput('leadSituation')" class="inline-flex size-7 items-center justify-center rounded-md text-gray-400 transition hover:bg-white hover:text-gray-700" aria-label="Close custom fields"><span class="outcraft-icon !text-[18px]">close</span></button></div>
                                                    <div class="flex flex-wrap gap-2 px-4 py-4"><template x-for="tag in filteredCustomFieldTextInputTags('leadSituation')" :key="`lead-situation-${tag}`"><button type="button" class="inline-flex h-8 items-center rounded-md bg-white px-2.5 text-sm font-medium text-gray-600 shadow-sm ring-1 ring-inset ring-gray-200 transition hover:bg-gray-50 hover:text-gray-900" x-text="tag"></button></template><p x-show="filteredCustomFieldTextInputTags('leadSituation').length === 0" class="text-sm text-gray-500">No Custom Fields Found.</p></div>
                                                </aside>
                                            </div>
                                        </div>
	                                        <p class="mt-2 text-sm leading-6 text-gray-500">Describe who the person is, why this conversation is happening, and what the AI must not assume.</p>
                                    </div>

                                    <div>
                                        <span class="block text-sm/6 font-semibold text-gray-900">Discovery Questions</span>
                                        <span class="mt-2 block text-sm leading-6 text-gray-500">List the key questions or information AI should collect.</span>

                                        <div class="mt-4 overflow-hidden rounded-lg border border-gray-200 bg-white">
                                            <div
                                                x-sortable
                                                data-sortable-animation-duration="150"
                                                x-on:end.stop="reorderFindOutQuestionsByIds($event.target.sortable.toArray())"
                                            >
                                                <template x-for="(question, index) in campaignSetup.brief.findOutQuestions" :key="question.id">
                                                    <div
                                                        x-bind:x-sortable-item="question.id"
                                                        class="flex items-center gap-3 border-b border-gray-200 px-4 py-3"
                                                    >
                                                        <button type="button" x-sortable-handle class="inline-flex size-8 cursor-grab items-center justify-center rounded-md text-gray-400 transition hover:bg-gray-50 hover:text-gray-700 active:cursor-grabbing" aria-label="Reorder Question">
                                                            <span class="outcraft-icon !text-[18px]">drag_indicator</span>
                                                        </button>
                                                        <span class="min-w-0 flex-1 text-sm leading-6 text-gray-900" x-text="question.text"></span>
                                                        <div class="relative shrink-0" x-on:click.outside="campaignSetup.brief.findOutAnswerFormatOpen === question.id && (campaignSetup.brief.findOutAnswerFormatOpen = null)">
                                                            <button type="button" x-on:click="campaignSetup.brief.findOutAnswerFormatOpen = campaignSetup.brief.findOutAnswerFormatOpen === question.id ? null : question.id" class="inline-flex items-center gap-1 rounded-md text-sm font-semibold transition focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600" :class="question.addToIntelligence ? 'text-indigo-600 hover:text-indigo-500' : 'text-gray-500 hover:text-gray-900'">
                                                                <span>Collect Answer</span>
                                                                <span class="outcraft-icon !text-[18px]">keyboard_arrow_down</span>
                                                            </button>
                                                            <div x-cloak x-show="campaignSetup.brief.findOutAnswerFormatOpen === question.id" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="opacity-0 translate-y-1" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-1" class="absolute right-0 z-30 mt-2 w-48 rounded-md bg-white py-1 shadow-lg ring-1 ring-gray-900/10">
                                                                <template x-for="format in campaignSetup.brief.findOutAnswerFormats" :key="format">
                                                                    <button type="button" x-on:click="selectFindOutQuestionAnswerFormat(index, format)" class="flex w-full items-center justify-between gap-3 px-3 py-2 text-left text-sm text-gray-700 transition hover:bg-gray-50 hover:text-gray-900">
                                                                        <span x-text="format"></span>
                                                                        <span x-show="question.answerFormat === format" class="outcraft-icon !text-[18px] text-indigo-600">check</span>
                                                                    </button>
                                                                </template>
                                                            </div>
                                                        </div>
                                                        <span x-show="question.addToIntelligence && question.answerFormat" class="inline-flex shrink-0 rounded-md bg-emerald-50 px-2 py-1 text-xs font-medium text-emerald-700 ring-1 ring-inset ring-emerald-600/20">Captured</span>
                                                        <button x-show="! (question.addToIntelligence && question.answerFormat)" type="button" x-on:click="captureFindOutQuestion(index); hideFloatingTooltip()" x-on:mouseenter="showFloatingTooltip($event, 'Capture for Conversation Intelligence', 240)" x-on:mouseleave="hideFloatingTooltip()" x-on:focus="showFloatingTooltip($event, 'Capture for Conversation Intelligence', 240)" x-on:blur="hideFloatingTooltip()" class="inline-flex size-8 shrink-0 items-center justify-center rounded-md text-gray-400 transition hover:bg-gray-50 hover:text-indigo-600 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600" aria-label="Capture for Conversation Intelligence">
                                                            <span class="outcraft-icon !text-[18px]">fact_check</span>
                                                        </button>
                                                        <button type="button" x-on:click="removeFindOutQuestion(index)" class="inline-flex size-8 shrink-0 items-center justify-center rounded-md text-gray-400 transition hover:bg-gray-50 hover:text-red-600 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-red-500" aria-label="Remove Question">
                                                            <span class="outcraft-icon !text-[18px]">delete</span>
                                                        </button>
                                                    </div>
                                                </template>
                                            </div>
                                            <div x-show="campaignSetup.brief.findOutQuestions.length === 0" class="border-b border-gray-200 px-4 py-4 text-sm text-gray-500">No Questions Added.</div>

                                            <form x-on:submit.prevent="addFindOutQuestion()" class="bg-white p-4 sm:flex sm:items-center sm:gap-3">
                                                <label class="block min-w-0 flex-1">
                                                    <span class="sr-only">Question</span>
                                                    <input x-model="campaignSetup.brief.newFindOutQuestion" type="text" placeholder="e.g. What problem are they trying to solve?" class="block w-full rounded-md bg-white px-3 py-1.5 text-sm/6 text-gray-900 shadow-sm outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600">
                                                </label>
                                                <button type="submit" :disabled="! String(campaignSetup.brief.newFindOutQuestion || '').trim()" class="mt-3 inline-flex h-9 items-center justify-center rounded-md bg-indigo-600 px-3 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-500 disabled:cursor-not-allowed disabled:opacity-40 sm:mt-0">Add Question</button>
                                            </form>
                                        </div>
                                    </div>
	                                    <label class="block">
	                                        <span class="block text-sm/6 font-semibold text-gray-900">What Should AI Offer or Do Next?</span>
	                                        <textarea x-model="campaignSetup.brief.nextStep" rows="4" class="mt-2 block w-full rounded-md bg-white px-3 py-2 text-sm/6 text-gray-700 shadow-sm outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600"></textarea>
	                                        <span class="mt-2 block text-sm leading-6 text-gray-500">Describe the desired next step, handoff, resource, or action.</span>
	                                    </label>

	                                    <label class="block">
	                                        <span class="block text-sm/6 font-semibold text-gray-900">Important Rules</span>
	                                        <textarea x-model="campaignSetup.brief.importantRules" rows="4" class="mt-2 block w-full rounded-md bg-white px-3 py-2 text-sm/6 text-gray-700 shadow-sm outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600"></textarea>
                                        <span class="mt-2 block text-sm leading-6 text-gray-500">Add anything AI must avoid, skip, disclose, or handle carefully.</span>
                                    </label>

                                    <div class="rounded-lg border border-gray-200 bg-white p-5">
                                        <button type="button" x-on:click="campaignSetup.needsQualification = ! campaignSetup.needsQualification; scheduleCampaignBuilderLayoutUpdate()" role="switch" :aria-checked="campaignSetup.needsQualification" class="flex w-full items-start gap-4 rounded-md text-left focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                                            <span class="relative mt-1 inline-flex h-6 w-11 shrink-0 rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out" :class="campaignSetup.needsQualification ? 'bg-indigo-600' : 'bg-gray-200'"><span class="pointer-events-none inline-block size-5 rounded-full bg-white shadow transition duration-200 ease-in-out" :class="campaignSetup.needsQualification ? 'translate-x-5' : 'translate-x-0'"></span></span>
                                            <span><span class="block text-sm font-semibold leading-6 text-gray-950">Enable Qualification</span><span class="mt-1 block text-sm leading-6 text-gray-600">Turn this on if the AI needs to qualify the lead before moving to the next step.</span></span>
                                        </button>
                                        <div x-show="campaignSetup.needsQualification" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-3" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-2" class="mt-6 space-y-6">
                                            <label class="block"><span class="block text-sm/6 font-semibold text-gray-900">Qualification Questions</span><textarea x-model="campaignSetup.brief.qualificationQuestions" rows="4" class="mt-2 block w-full rounded-md bg-white px-3 py-2 text-sm/6 text-gray-700 shadow-sm outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600"></textarea></label>
                                            <label class="block"><span class="block text-sm/6 font-semibold text-gray-900">Qualification Answers</span><textarea x-model="campaignSetup.brief.qualifiedAnswers" rows="4" class="mt-2 block w-full rounded-md bg-white px-3 py-2 text-sm/6 text-gray-700 shadow-sm outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600"></textarea><span class="mt-2 block text-sm leading-6 text-gray-500">Each line becomes one qualifying answer.</span></label>
                                        </div>
                                    </div>
                                </div>
                                <div x-show="campaignSetup.briefTab === 'builder'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-3" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-2" class="mt-6 space-y-5">
                                    <article class="rounded-lg border border-gray-200 bg-white p-5 shadow-sm">
                                        <div class="flex items-start justify-between gap-4">
                                            <div class="flex min-w-0 items-start gap-3">
                                                <span class="flex size-9 shrink-0 items-center justify-center rounded-md bg-indigo-50 text-indigo-600">
                                                    <span class="outcraft-icon !text-[19px]">target</span>
                                                </span>
                                                <div class="min-w-0">
                                                    <h3 class="text-base font-semibold leading-6 text-gray-950">Campaign Goal</h3>
                                                    <p class="mt-1 text-sm leading-6 text-gray-500">Define what the AI should accomplish and when the conversation is considered successful.</p>
                                                </div>
                                            </div>
                                            <span class="inline-flex rounded-md bg-indigo-50 px-2 py-1 text-xs font-medium text-indigo-700 ring-1 ring-inset ring-indigo-700/10">Required</span>
                                        </div>
                                        <textarea x-model="campaignSetup.brief.goal" rows="4" placeholder="What should this campaign achieve?" class="mt-4 block w-full rounded-md bg-white px-3 py-2 text-sm/6 text-gray-700 shadow-sm outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600"></textarea>
                                    </article>

                                    <article class="rounded-lg border border-gray-200 bg-white p-5 shadow-sm">
                                        <div class="flex items-start justify-between gap-4">
                                            <div class="flex min-w-0 items-start gap-3">
                                                <span class="flex size-9 shrink-0 items-center justify-center rounded-md bg-indigo-50 text-indigo-600">
                                                    <span class="outcraft-icon !text-[19px]">users</span>
                                                </span>
                                                <div class="min-w-0">
                                                    <h3 class="text-base font-semibold leading-6 text-gray-950">Lead Situation</h3>
                                                    <p class="mt-1 text-sm leading-6 text-gray-500">Describe who the person is, why this conversation is happening, and what the AI must not assume.</p>
                                                </div>
                                            </div>
                                            <span class="inline-flex rounded-md bg-indigo-50 px-2 py-1 text-xs font-medium text-indigo-700 ring-1 ring-inset ring-indigo-700/10">Required</span>
                                        </div>
                                        <textarea x-model="campaignSetup.brief.leadSituation" rows="4" placeholder="Who are these leads and why are we contacting them?" class="mt-4 block w-full rounded-md bg-white px-3 py-2 text-sm/6 text-gray-700 shadow-sm outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600"></textarea>
                                    </article>

                                    <template x-for="(item, index) in campaignSetup.brief.builderItems" :key="item.id">
                                        <article class="rounded-lg border border-gray-200 bg-white p-5 shadow-sm" :class="item.type === 'short_conversation_instructions' ? '!pb-0 overflow-hidden' : ''">
                                            <div class="flex items-start justify-between gap-4">
                                                <div class="flex min-w-0 items-start gap-3">
                                                    <span class="flex size-9 shrink-0 items-center justify-center rounded-md bg-indigo-50 text-indigo-600">
                                                        <span x-show="briefBuilderItemSvgIcon(item.type)" class="size-[21px]" x-html="briefBuilderItemSvgIcon(item.type)"></span>
                                                        <span x-show="! briefBuilderItemSvgIcon(item.type)" class="outcraft-icon !text-[19px]" x-text="briefBuilderItemIcon(item.type)"></span>
                                                    </span>
                                                    <div class="min-w-0">
                                                        <h3 class="text-base font-semibold leading-6 text-gray-950" x-text="briefBuilderItemTitle(item.type)"></h3>
                                                        <p class="mt-1 text-sm leading-6 text-gray-500" x-text="briefBuilderItemDescription(item.type)"></p>
                                                    </div>
                                                </div>
                                                <div class="relative shrink-0" x-on:click.outside="if (campaignSetup.briefBuilderItemActionOpen === item.id) campaignSetup.briefBuilderItemActionOpen = ''">
                                                    <button type="button" x-on:click="campaignSetup.briefBuilderItemActionOpen = campaignSetup.briefBuilderItemActionOpen === item.id ? '' : item.id" class="inline-flex size-8 items-center justify-center rounded-md text-gray-400 transition hover:bg-gray-50 hover:text-gray-700" aria-label="Item Actions">
                                                        <span class="outcraft-icon !text-[18px]">more_vert</span>
                                                    </button>
                                                    <div x-cloak x-show="campaignSetup.briefBuilderItemActionOpen === item.id" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="opacity-0 translate-y-1" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-1" class="absolute right-0 top-9 z-30 w-44 rounded-md bg-white p-1 text-sm shadow-lg ring-1 ring-gray-900/10">
                                                        <button type="button" x-on:click="moveBriefBuilderItem(index, -1)" :disabled="index === 0" class="flex w-full items-center gap-2 rounded-md px-3 py-2 text-left font-medium text-gray-700 transition hover:bg-gray-50 hover:text-gray-950 disabled:cursor-not-allowed disabled:opacity-40">
                                                            <span class="outcraft-icon !text-[16px] text-gray-400">arrow_upward</span>
                                                            Move Up
                                                        </button>
                                                        <button type="button" x-on:click="moveBriefBuilderItem(index, 1)" :disabled="index === campaignSetup.brief.builderItems.length - 1" class="flex w-full items-center gap-2 rounded-md px-3 py-2 text-left font-medium text-gray-700 transition hover:bg-gray-50 hover:text-gray-950 disabled:cursor-not-allowed disabled:opacity-40">
                                                            <span class="outcraft-icon !text-[16px] text-gray-400">arrow_downward</span>
                                                            Move Down
                                                        </button>
                                                        <button type="button" x-on:click="removeBriefBuilderItem(item.id)" class="flex w-full items-center gap-2 rounded-md px-3 py-2 text-left font-medium text-red-600 transition hover:bg-red-50 hover:text-red-700">
                                                            <span class="outcraft-icon !text-[16px]">delete</span>
                                                            Delete Block
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>

                                            <div x-show="item.type === 'find_out'" class="mt-5 space-y-4">
                                                <div
                                                    x-sortable
                                                    data-sortable-animation-duration="150"
                                                    x-on:end.stop="reorderBriefBuilderQuestions(item, $event.target.sortable.toArray())"
                                                    class="-mx-5 border-y border-gray-200 bg-white"
                                                >
                                                    <template x-for="(question, questionIndex) in item.questions" :key="question.id">
                                                        <div x-bind:x-sortable-item="question.id" class="flex items-start gap-3 px-5 py-3" :class="questionIndex === item.questions.length - 1 ? '' : 'border-b border-gray-200'">
                                                            <button type="button" x-sortable-handle class="inline-flex size-7 shrink-0 cursor-grab items-center justify-center rounded-md text-gray-300 transition hover:bg-gray-50 hover:text-gray-500 active:cursor-grabbing" aria-label="Reorder Question">
                                                                <span class="outcraft-icon !text-[18px]">drag_indicator</span>
                                                            </button>
                                                            <span class="min-w-0 flex-1 text-sm leading-6 text-gray-900" x-text="question.text"></span>
                                                            <span x-show="briefBuilderQuestionCaptured(item, question)" class="inline-flex shrink-0 rounded-md bg-emerald-50 px-2 py-1 text-xs font-medium text-emerald-700 ring-1 ring-inset ring-emerald-600/20">Captured</span>
                                                            <button x-show="! briefBuilderQuestionCaptured(item, question)" type="button" x-on:click="captureBriefBuilderQuestion(item, question, 'Discovery Questions'); hideFloatingTooltip()" x-on:mouseenter="showFloatingTooltip($event, 'Capture for Conversation Intelligence', 240)" x-on:mouseleave="hideFloatingTooltip()" x-on:focus="showFloatingTooltip($event, 'Capture for Conversation Intelligence', 240)" x-on:blur="hideFloatingTooltip()" class="inline-flex size-7 shrink-0 items-center justify-center rounded-md text-gray-400 transition hover:bg-gray-50 hover:text-indigo-600 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600" aria-label="Capture for Conversation Intelligence">
                                                                <span class="outcraft-icon !text-[17px]">fact_check</span>
                                                            </button>
                                                            <button type="button" x-on:click="removeBriefBuilderQuestion(item, questionIndex)" class="inline-flex size-7 shrink-0 items-center justify-center rounded-md text-gray-400 transition hover:bg-gray-50 hover:text-red-600" aria-label="Remove Question"><span class="outcraft-icon !text-[17px]">delete</span></button>
                                                        </div>
                                                    </template>
                                                    <p x-show="item.questions.length === 0" class="px-5 py-4 text-sm text-gray-500">No Questions Added.</p>
                                                </div>
                                                <form x-on:submit.prevent="addBriefBuilderQuestion(item)" class="grid gap-3 sm:grid-cols-[minmax(0,1fr)_auto]">
                                                    <input x-model="item.newQuestion" type="text" placeholder="e.g. What problem are they trying to solve?" class="block w-full rounded-md bg-white px-3 py-1.5 text-sm/6 text-gray-900 shadow-sm outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600">
                                                    <button type="submit" :disabled="! String(item.newQuestion || '').trim()" class="inline-flex h-9 items-center justify-center rounded-md bg-indigo-600 px-3 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-500 disabled:cursor-not-allowed disabled:opacity-40">Add Question</button>
                                                </form>
                                            </div>

                                            <div x-show="item.type === 'pricing'" class="mt-5 space-y-5">
                                                <label class="block">
                                                    <span class="block text-sm/6 font-semibold text-gray-900">Pricing</span>
                                                    <x-outcraft.select
                                                        class="mt-2"
                                                        model="campaignSetup.brief.pricingSource"
                                                        :options="['Use Knowledge Base Pricing', 'Use Manually Entered Pricing']"
                                                    />
                                                    <span class="mt-2 block text-sm leading-6 text-gray-500">Choose where the AI should get pricing details from.</span>
                                                </label>
                                                <label x-show="campaignSetup.brief.pricingSource === 'Use Manually Entered Pricing'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-3" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-2" class="block">
                                                    <span class="block text-sm/6 font-semibold text-gray-900">Manual Pricing Notes</span>
                                                    <textarea x-model="campaignSetup.brief.manualPricing" rows="4" placeholder="Example Plan - 251 EUR special offer. Example Lite - 233 EUR special offer." class="mt-2 block w-full rounded-md bg-white px-3 py-2 text-sm/6 text-gray-700 shadow-sm outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600"></textarea>
                                                </label>
                                                <button type="button" x-on:click="campaignSetup.brief.canNegotiatePrice = ! campaignSetup.brief.canNegotiatePrice; scheduleCampaignBuilderLayoutUpdate()" role="switch" :aria-checked="campaignSetup.brief.canNegotiatePrice" class="flex w-full items-start gap-4 rounded-md text-left focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                                                    <span class="relative mt-1 inline-flex h-6 w-11 shrink-0 rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out" :class="campaignSetup.brief.canNegotiatePrice ? 'bg-indigo-600' : 'bg-gray-200'"><span class="pointer-events-none inline-block size-5 rounded-full bg-white shadow transition duration-200 ease-in-out" :class="campaignSetup.brief.canNegotiatePrice ? 'translate-x-5' : 'translate-x-0'"></span></span>
                                                    <span><span class="block text-sm font-semibold leading-6 text-gray-950">Can Negotiate Price</span><span class="mt-1 block text-sm leading-6 text-gray-600">Allow AI to negotiate within a limited discount percentage.</span></span>
                                                </button>
                                                <label x-show="campaignSetup.brief.canNegotiatePrice" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-3" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-2" class="block max-w-xs">
                                                    <span class="block text-sm/6 font-semibold text-gray-900">Negotiation Limit (%)</span>
                                                    <input x-model="campaignSetup.brief.priceNegotiationPercent" type="number" min="0" max="100" placeholder="10" class="mt-2 block w-full rounded-md bg-white px-3 py-1.5 text-sm/6 text-gray-900 shadow-sm outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600">
                                                </label>
                                            </div>

                                            <div x-show="item.type === 'guardrails'" class="mt-5 space-y-5">
                                                <label class="block">
                                                    <span class="block text-sm/6 font-semibold text-gray-900">Never Ask For</span>
                                                    <textarea x-model="campaignSetup.brief.neverAskFor" rows="4" placeholder="Credit card information&#10;Banking details&#10;Passwords" class="mt-2 block w-full rounded-md bg-white px-3 py-2 text-sm/6 text-gray-700 shadow-sm outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600"></textarea>
                                                </label>
                                                <label class="block">
                                                    <span class="block text-sm/6 font-semibold text-gray-900">Never Promise</span>
                                                    <textarea x-model="campaignSetup.brief.neverPromise" rows="4" placeholder="Refunds&#10;Delivery dates&#10;Guaranteed results" class="mt-2 block w-full rounded-md bg-white px-3 py-2 text-sm/6 text-gray-700 shadow-sm outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600"></textarea>
                                                </label>
                                                <label class="block">
                                                    <span class="block text-sm/6 font-semibold text-gray-900">Never Discuss</span>
                                                    <textarea x-model="campaignSetup.brief.neverDiscuss" rows="4" placeholder="Unrelated topics&#10;Competitor breakdowns&#10;Refund approvals" class="mt-2 block w-full rounded-md bg-white px-3 py-2 text-sm/6 text-gray-700 shadow-sm outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600"></textarea>
                                                </label>
                                            </div>

                                            <div x-show="item.type === 'qualification'" class="mt-5 space-y-4">
                                                <div
                                                    x-sortable
                                                    data-sortable-animation-duration="150"
                                                    x-on:end.stop="reorderBriefBuilderQuestions(item, $event.target.sortable.toArray())"
                                                    class="-mx-5 border-y border-gray-200 bg-white"
                                                >
                                                    <template x-for="(question, questionIndex) in item.questions" :key="question.id">
                                                        <div x-bind:x-sortable-item="question.id" class="px-5 py-3" :class="questionIndex === item.questions.length - 1 ? '' : 'border-b border-gray-200'">
                                                            <div class="flex items-start gap-3">
                                                                <button type="button" x-sortable-handle class="inline-flex size-7 shrink-0 cursor-grab items-center justify-center rounded-md text-gray-300 transition hover:bg-gray-50 hover:text-gray-500 active:cursor-grabbing" aria-label="Reorder Qualification Question">
                                                                    <span class="outcraft-icon !text-[18px]">drag_indicator</span>
                                                                </button>
                                                                <div class="min-w-0 flex-1">
                                                                    <p class="text-sm font-medium leading-6 text-gray-900" x-text="question.text"></p>
                                                                    <div class="mt-1 space-y-1 text-sm leading-6 text-gray-500">
                                                                        <template x-for="(answer, answerIndex) in briefBuilderQualificationAnswerLines(question.answers)" :key="`${question.id}-answer-${answerIndex}`">
                                                                            <p x-text="`- ${answer}`"></p>
                                                                        </template>
                                                                    </div>
                                                                </div>
                                                                <span x-show="briefBuilderQuestionCaptured(item, question)" class="inline-flex shrink-0 rounded-md bg-emerald-50 px-2 py-1 text-xs font-medium text-emerald-700 ring-1 ring-inset ring-emerald-600/20">Captured</span>
                                                                <button x-show="! briefBuilderQuestionCaptured(item, question)" type="button" x-on:click="captureBriefBuilderQuestion(item, question, 'Qualification Questions'); hideFloatingTooltip()" x-on:mouseenter="showFloatingTooltip($event, 'Capture for Conversation Intelligence', 240)" x-on:mouseleave="hideFloatingTooltip()" x-on:focus="showFloatingTooltip($event, 'Capture for Conversation Intelligence', 240)" x-on:blur="hideFloatingTooltip()" class="inline-flex size-7 shrink-0 items-center justify-center rounded-md text-gray-400 transition hover:bg-gray-50 hover:text-indigo-600 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600" aria-label="Capture for Conversation Intelligence">
                                                                    <span class="outcraft-icon !text-[17px]">fact_check</span>
                                                                </button>
                                                                <button type="button" x-on:click="removeBriefBuilderQuestion(item, questionIndex)" class="inline-flex size-7 shrink-0 items-center justify-center rounded-md text-gray-400 transition hover:bg-gray-50 hover:text-red-600" aria-label="Remove Qualification Question"><span class="outcraft-icon !text-[17px]">delete</span></button>
                                                            </div>
                                                        </div>
                                                    </template>
                                                    <p x-show="item.questions.length === 0" class="px-5 py-4 text-sm text-gray-500">No Qualification Questions Added.</p>
                                                </div>
                                                <form x-on:submit.prevent="addBriefBuilderQualificationQuestion(item)" class="space-y-3">
                                                    <input x-model="item.newQuestion" type="text" placeholder="e.g. Are they ready for the next step?" class="block w-full rounded-md bg-white px-3 py-1.5 text-sm/6 text-gray-900 shadow-sm outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600">
                                                    <label class="block">
                                                        <span class="mb-2 block text-sm/6 font-semibold text-gray-900">Qualifying Answers</span>
                                                        <textarea x-model="item.newAnswers" rows="3" placeholder="Has a clear need&#10;Wants to move forward" class="block w-full rounded-md bg-white px-3 py-2 text-sm/6 text-gray-700 shadow-sm outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600"></textarea>
                                                        <span class="mt-2 block text-sm leading-6 text-gray-500">Each line becomes one qualifying answer.</span>
                                                    </label>
                                                    <button type="submit" :disabled="! String(item.newQuestion || '').trim() || briefBuilderQualificationAnswerLines(item.newAnswers).length === 0" class="inline-flex h-9 items-center justify-center rounded-md bg-indigo-600 px-3 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-500 disabled:cursor-not-allowed disabled:opacity-40">Add Qualification Question</button>
                                                </form>
                                            </div>

                                            <div x-show="item.type === 'short_conversation_instructions'" class="mt-5 mb-0 space-y-5 pb-0">
                                                <div class="rounded-lg border border-blue-200 bg-blue-50 px-4 py-3">
                                                    <div class="flex gap-3">
                                                        <p class="text-sm leading-6 text-blue-700">These stages guide how the AI structures the conversation. <span class="font-semibold">Keep instructions short</span> (1-2 sentences per stage), because very specific instructions here may be followed more strongly during the call. Put detailed rules in the other Campaign Context items.</p>
                                                    </div>
                                                </div>

                                                <div class="flex items-center justify-end gap-2">
                                                    <button type="button" x-on:click="expandShortConversationInstructions(item)" class="inline-flex h-8 items-center justify-center rounded-md bg-white px-2.5 text-sm font-semibold text-gray-700 shadow-sm ring-1 ring-inset ring-gray-300 transition hover:bg-gray-50 hover:text-gray-950 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Expand all</button>
                                                    <button type="button" x-on:click="collapseShortConversationInstructions(item)" class="inline-flex h-8 items-center justify-center rounded-md bg-white px-2.5 text-sm font-semibold text-gray-700 shadow-sm ring-1 ring-inset ring-gray-300 transition hover:bg-gray-50 hover:text-gray-950 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Collapse all</button>
                                                </div>

                                                <div class="-mx-5 -mb-5 overflow-hidden border-t border-gray-200 bg-white">
                                                    <template x-for="stage in shortConversationInstructionStages()" :key="`${item.id}-${stage.key}`">
                                                        <div class="group border-b border-gray-200 last:border-b-0">
                                                            <div
                                                                role="button"
                                                                tabindex="0"
                                                                x-on:click="toggleShortConversationInstructionStage(item, stage.key)"
                                                                x-on:keydown.enter.prevent="toggleShortConversationInstructionStage(item, stage.key)"
                                                                x-on:keydown.space.prevent="toggleShortConversationInstructionStage(item, stage.key)"
                                                                class="flex cursor-pointer items-center justify-between gap-4 px-5 py-4 text-left transition group-hover:bg-gray-50"
                                                                :aria-expanded="(Array.isArray(item.shortConversationOpen) && item.shortConversationOpen.includes(stage.key)).toString()"
                                                            >
                                                                <span class="min-w-0">
                                                                    <span class="block text-base/7 font-semibold text-gray-900" x-text="stage.title"></span>
                                                                    <span class="mt-1 block text-sm leading-6 text-gray-600" x-text="stage.description"></span>
                                                                </span>
                                                                <span class="outcraft-icon shrink-0 !text-[18px] text-gray-400 transition" :class="Array.isArray(item.shortConversationOpen) && item.shortConversationOpen.includes(stage.key) ? 'rotate-180' : ''">keyboard_arrow_down</span>
                                                            </div>
                                                            <div x-show="Array.isArray(item.shortConversationOpen) && item.shortConversationOpen.includes(stage.key)" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-3" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-2" class="p-5 pt-0 transition group-hover:bg-gray-50">
                                                                <div class="mb-2 flex items-center justify-between gap-3">
                                                                    <label class="block text-sm/6 font-semibold text-gray-900">Instructions</label>
                                                                    <span class="relative shrink-0" x-data="{ fieldActionsOpen: false }" x-on:click.outside="fieldActionsOpen = false">
                                                                        <button type="button" x-on:click="fieldActionsOpen = ! fieldActionsOpen" class="inline-flex size-7 items-center justify-center rounded-md text-gray-400 transition hover:bg-gray-50 hover:text-gray-700" :aria-label="`${stage.title} field actions`">
                                                                            <span class="outcraft-icon !text-[18px]">more_vert</span>
                                                                        </button>
                                                                        <span x-cloak x-show="fieldActionsOpen" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-3" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-2" class="absolute right-0 z-40 mt-2 w-52 rounded-md bg-white py-1 shadow-lg ring-1 ring-gray-900/10">
                                                                            <button type="button" x-on:click="openCustomFieldTextInput(stage.fieldKey); fieldActionsOpen = false" class="flex w-full items-center gap-2 px-3 py-2 text-left text-sm font-medium text-gray-700 transition hover:bg-gray-50 hover:text-gray-950"><span class="text-xs text-gray-400">{+}</span>Open Custom Fields</button>
                                                                            <button type="button" x-on:click="resetShortConversationInstruction(stage); fieldActionsOpen = false" class="flex w-full items-center gap-2 px-3 py-2 text-left text-sm font-medium text-gray-700 transition hover:bg-gray-50 hover:text-gray-950"><span class="outcraft-icon !text-[15px] text-gray-400">restart_alt</span>Reset to Default</button>
                                                                            <button type="button" x-on:click="fieldActionsOpen = false" class="flex w-full items-center gap-2 px-3 py-2 text-left text-sm font-medium text-gray-700 transition hover:bg-gray-50 hover:text-gray-950"><span class="outcraft-icon !text-[15px] text-gray-400">settings</span>Configure Custom Fields</button>
                                                                        </span>
                                                                    </span>
                                                                </div>
                                                                <div data-component="custom-field-text-input" class="overflow-hidden rounded-lg border border-gray-300 bg-white shadow-sm transition focus-within:border-indigo-600 focus-within:ring-1 focus-within:ring-indigo-600">
                                                                    <div class="relative grid min-w-0 overflow-hidden transition-[grid-template-columns] duration-200 ease-out" :class="customFieldTextInputState(stage.fieldKey).layoutOpen ? 'lg:grid-cols-[minmax(0,1fr)_18rem]' : 'lg:grid-cols-1'">
                                                                        <textarea x-model="campaignSetup.brief.shortConversationInstructions[stage.key]" rows="3" maxlength="500" :placeholder="stage.placeholder" class="block min-h-[94px] min-w-0 w-full resize-y border-0 bg-white px-3 py-2 text-sm/6 text-gray-700 outline-none placeholder:text-gray-400 focus:ring-0"></textarea>
                                                                        <aside x-cloak x-show="customFieldTextInputState(stage.fieldKey).open" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="translate-x-full opacity-0" x-transition:enter-end="translate-x-0 opacity-100" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="translate-x-0 opacity-100" x-transition:leave-end="translate-x-full opacity-0" class="min-w-0 border-t border-gray-200 bg-white lg:border-t-0 lg:border-l lg:border-gray-200">
                                                                            <div class="flex items-center gap-2 border-b border-gray-200 px-4 py-3"><label class="min-w-0 flex-1"><input :value="customFieldTextInputState(stage.fieldKey).search" x-on:input="customFieldTextInputState(stage.fieldKey).search = $event.target.value" type="search" placeholder="Search Custom Fields" class="block h-9 w-full rounded-md bg-white px-3 py-1.5 text-sm text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600"></label><button type="button" x-on:click="closeCustomFieldTextInput(stage.fieldKey)" class="inline-flex size-7 items-center justify-center rounded-md text-gray-400 transition hover:bg-white hover:text-gray-700" aria-label="Close custom fields"><span class="outcraft-icon !text-[18px]">close</span></button></div>
                                                                            <div class="flex flex-wrap gap-2 px-4 py-4"><template x-for="tag in filteredCustomFieldTextInputTags(stage.fieldKey)" :key="`${stage.fieldKey}-${tag}`"><button type="button" class="inline-flex h-8 items-center rounded-md bg-white px-2.5 text-sm font-medium text-gray-600 shadow-sm ring-1 ring-inset ring-gray-200 transition hover:bg-gray-50 hover:text-gray-900" x-text="tag"></button></template><p x-show="filteredCustomFieldTextInputTags(stage.fieldKey).length === 0" class="text-sm text-gray-500">No Custom Fields Found.</p></div>
                                                                        </aside>
                                                                    </div>
                                                                </div>
                                                                <p class="mt-2 text-sm leading-6 text-gray-500">Max 500 characters.</p>
                                                            </div>
                                                        </div>
                                                    </template>
                                                </div>
                                            </div>

                                            <label x-show="briefBuilderIsGuidelineItem(item.type)" class="mt-5 block">
                                                <span class="sr-only" x-text="briefBuilderItemTitle(item.type)"></span>
                                                <textarea x-model="item.content" rows="5" :placeholder="briefBuilderGuidelinePlaceholder(item.type)" class="block w-full rounded-md bg-white px-3 py-2 text-sm/6 text-gray-700 shadow-sm outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600"></textarea>
                                                <span class="mt-2 block text-sm leading-6 text-gray-500" x-text="briefBuilderGuidelineHelper(item.type)"></span>
                                            </label>

                                            <div x-show="item.type === 'discount_codes'" class="mt-5 space-y-4">
                                                <form x-on:submit.prevent="addDiscountCode()" class="grid gap-3 sm:grid-cols-[minmax(0,1fr)_auto]">
                                                    <input x-model="campaignSetup.newDiscountCode" type="text" placeholder="e.g. WELCOME20 or 25OFF" class="block w-full rounded-md bg-white px-3 py-1.5 text-sm/6 text-gray-900 shadow-sm outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600">
                                                    <button type="submit" :disabled="! String(campaignSetup.newDiscountCode || '').trim()" class="inline-flex h-9 items-center justify-center rounded-md bg-indigo-600 px-3 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-500 disabled:cursor-not-allowed disabled:opacity-40">Add</button>
                                                </form>
                                                <div class="divide-y divide-gray-200">
                                                    <template x-for="code in campaignSetup.discountCodes" :key="`builder-${code.value}`">
                                                        <div class="flex items-start justify-between gap-4 py-3">
                                                            <div>
                                                                <p class="text-sm font-semibold leading-6 text-gray-950" x-text="code.value"></p>
                                                                <p class="text-sm leading-6 text-gray-500" x-text="`Created ${code.created}`"></p>
                                                            </div>
                                                            <button type="button" x-on:click="campaignSetup.discountCodes = campaignSetup.discountCodes.filter((item) => item.value !== code.value)" class="inline-flex size-8 items-center justify-center rounded-md text-gray-400 transition hover:bg-gray-50 hover:text-red-600" aria-label="Remove Discount Code">
                                                                <span class="outcraft-icon !text-[17px]">delete</span>
                                                            </button>
                                                        </div>
                                                    </template>
                                                    <p x-show="campaignSetup.discountCodes.length === 0" class="py-4 text-sm text-gray-500">No Discount Codes Added.</p>
                                                </div>
                                            </div>

                                            <div x-show="item.type === 'handoff'" class="mt-5 space-y-6">
                                                <button type="button" x-on:click="campaignSetup.handoffPositive = ! campaignSetup.handoffPositive; scheduleCampaignBuilderLayoutUpdate()" role="switch" :aria-checked="campaignSetup.handoffPositive" class="flex w-full items-start gap-4 rounded-md text-left focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                                                    <span class="relative mt-1 inline-flex h-6 w-11 shrink-0 rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out" :class="campaignSetup.handoffPositive ? 'bg-indigo-600' : 'bg-gray-200'"><span class="pointer-events-none inline-block size-5 rounded-full bg-white shadow transition duration-200 ease-in-out" :class="campaignSetup.handoffPositive ? 'translate-x-5' : 'translate-x-0'"></span></span>
                                                    <span><span class="block text-sm font-semibold leading-6 text-gray-950">Hand Off After a Positive Reply</span><span class="mt-1 block text-sm leading-6 text-gray-600">AI passes the conversation to a human when the lead responds positively.</span></span>
                                                </button>
                                                <label x-show="campaignSetup.handoffPositive" class="block">
                                                    <span class="block text-sm/6 font-medium text-gray-900">Handoff Trigger Scenarios</span>
                                                    <x-outcraft.select
                                                        class="mt-2"
                                                        model="campaignSetup.handoffScenario"
                                                        :options="[
                                                            ['value' => '', 'label' => 'Type Your Own or Select Common Scenario'],
                                                            'Positive Reply',
                                                            'High Intent',
                                                            'Pricing Question',
                                                        ]"
                                                    />
                                                    <span class="mt-2 block text-sm leading-6 text-gray-500">Situations where AI should pass to a human agent.</span>
                                                </label>
                                                <button type="button" x-on:click="campaignSetup.handoffRequested = ! campaignSetup.handoffRequested; scheduleCampaignBuilderLayoutUpdate()" role="switch" :aria-checked="campaignSetup.handoffRequested" class="flex w-full items-start gap-4 rounded-md text-left focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                                                    <span class="relative mt-1 inline-flex h-6 w-11 shrink-0 rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out" :class="campaignSetup.handoffRequested ? 'bg-indigo-600' : 'bg-gray-200'"><span class="pointer-events-none inline-block size-5 rounded-full bg-white shadow transition duration-200 ease-in-out" :class="campaignSetup.handoffRequested ? 'translate-x-5' : 'translate-x-0'"></span></span>
                                                    <span><span class="block text-sm font-semibold leading-6 text-gray-950">Hand Off When the Lead Asks</span><span class="mt-1 block text-sm leading-6 text-gray-600">AI passes the conversation when the lead explicitly requests a human.</span></span>
                                                </button>
                                                <label x-show="campaignSetup.handoffRequested" class="block">
                                                    <span class="block text-sm/6 font-medium text-gray-900">Handoff Channel</span>
                                                    <x-outcraft.select
                                                        class="mt-2"
                                                        model="campaignSetup.handoffChannel"
                                                        :options="[
                                                            ['value' => '', 'label' => 'Select a Channel'],
                                                            'Email',
                                                            'Slack',
                                                            'Webhook',
                                                        ]"
                                                    />
                                                    <span class="mt-2 block text-sm leading-6 text-gray-500">How the human agent is notified.</span>
                                                </label>
                                                <label class="block">
                                                    <span class="block text-sm/6 font-semibold text-gray-900">Handoff Notification Email</span>
                                                    <input x-model="campaignSetup.handoffNotificationEmail" type="email" placeholder="support@example.com" class="mt-2 block w-full rounded-md bg-white px-3 py-1.5 text-sm/6 text-gray-900 shadow-sm outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600">
                                                    <span class="mt-2 block text-sm leading-6 text-gray-500">Where to send a notification when AI hands off a conversation.</span>
                                                </label>
                                            </div>

                                            <div x-show="item.type === 'followups'" class="mt-5 space-y-6">
                                                <button type="button" x-on:click="toggleFollowupSequence('followupPositive', 'positive')" role="switch" :aria-checked="campaignSetup.followupPositive" class="flex w-full items-center justify-between gap-4 rounded-md text-left focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                                                    <span class="min-w-0">
                                                        <span class="block text-sm font-semibold leading-6 text-gray-950">After a Positive Response</span>
                                                        <span class="mt-1 block text-sm leading-6 text-gray-600">Follow up to confirm the next step, share details, or check if the lead needs anything else.</span>
                                                    </span>
                                                    <span class="relative inline-flex h-6 w-11 shrink-0 self-center rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out" :class="campaignSetup.followupPositive ? 'bg-indigo-600' : 'bg-gray-200'">
                                                        <span class="pointer-events-none inline-block size-5 rounded-full bg-white shadow transition duration-200 ease-in-out" :class="campaignSetup.followupPositive ? 'translate-x-5' : 'translate-x-0'"></span>
                                                    </span>
                                                </button>

                                                <button type="button" x-on:click="toggleFollowupSequence('followupEngaged', 'engaged')" role="switch" :aria-checked="campaignSetup.followupEngaged" class="flex w-full items-center justify-between gap-4 rounded-md text-left focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                                                    <span class="min-w-0">
                                                        <span class="block text-sm font-semibold leading-6 text-gray-950">When a Lead Is Engaged but Undecided</span>
                                                        <span class="mt-1 block text-sm leading-6 text-gray-600">Follow up to answer questions and help the lead move toward a clear yes or no.</span>
                                                    </span>
                                                    <span class="relative inline-flex h-6 w-11 shrink-0 self-center rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out" :class="campaignSetup.followupEngaged ? 'bg-indigo-600' : 'bg-gray-200'">
                                                        <span class="pointer-events-none inline-block size-5 rounded-full bg-white shadow transition duration-200 ease-in-out" :class="campaignSetup.followupEngaged ? 'translate-x-5' : 'translate-x-0'"></span>
                                                    </span>
                                                </button>

                                                <button type="button" x-on:click="toggleFollowupSequence('followupNegative', 'negative')" role="switch" :aria-checked="campaignSetup.followupNegative" class="flex w-full items-center justify-between gap-4 rounded-md text-left focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                                                    <span class="min-w-0">
                                                        <span class="block text-sm font-semibold leading-6 text-gray-950">After a Negative Response</span>
                                                        <span class="mt-1 block text-sm leading-6 text-gray-600">Follow up only when there may still be an opportunity to address concerns or objections.</span>
                                                    </span>
                                                    <span class="relative inline-flex h-6 w-11 shrink-0 self-center rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out" :class="campaignSetup.followupNegative ? 'bg-indigo-600' : 'bg-gray-200'">
                                                        <span class="pointer-events-none inline-block size-5 rounded-full bg-white shadow transition duration-200 ease-in-out" :class="campaignSetup.followupNegative ? 'translate-x-5' : 'translate-x-0'"></span>
                                                    </span>
                                                </button>

                                                <div x-show="campaignSetup.followupPositive || campaignSetup.followupEngaged || campaignSetup.followupNegative" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-3" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-2" class="space-y-5">
                                                    <div>
                                                        <h4 class="text-base font-semibold leading-6 text-gray-950">Follow-Up Sequence</h4>
                                                        <p class="mt-2 text-sm leading-6 text-gray-600">Build a follow-up sequence that will be applied for this campaign.</p>
                                                    </div>
                                                    <div class="border-b border-gray-200">
                                                        <nav class="-mb-px flex flex-wrap gap-6" aria-label="Follow-up sequence tabs">
                                                            <template x-for="tab in followupSequenceTabs()" :key="`builder-${tab.id}`">
                                                                <button type="button" x-on:click="campaignSetup.activeFollowupSequence = tab.id" class="border-b-2 px-1 pb-3 text-sm font-semibold transition" :class="campaignSetup.activeFollowupSequence === tab.id ? 'border-indigo-600 text-indigo-600' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700'">
                                                                    <span x-text="tab.label"></span>
                                                                </button>
                                                            </template>
                                                        </nav>
                                                    </div>
                                                    <div class="flex flex-wrap items-center justify-between gap-3">
                                                        <button type="button" class="inline-flex h-9 w-fit shrink-0 self-start items-center rounded-md bg-white px-3 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 transition hover:bg-gray-50">Reorder Actions</button>
                                                        <button type="button" x-on:click="campaignSetup.followupModalOpen = true" class="inline-flex h-9 w-fit shrink-0 self-start items-center gap-2 rounded-md bg-white px-3 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 transition hover:bg-gray-50"><span class="outcraft-icon !text-[17px]">add</span><span>Add Step</span></button>
                                                    </div>
                                                    <div class="overflow-hidden rounded-lg border border-gray-200">
                                                        <table class="min-w-full divide-y divide-gray-200 text-left text-sm">
                                                            <thead class="bg-gray-50">
                                                                <tr>
                                                                    <template x-for="head in ['Channel','Label','Relative Delay','Exact Flow Step']" :key="`builder-followup-${head}`">
                                                                        <th class="px-4 py-3 font-semibold text-gray-600" x-text="head"></th>
                                                                    </template>
                                                                </tr>
                                                            </thead>
                                                        </table>
                                                        <div class="flex min-h-40 flex-col items-center justify-center border-t border-gray-100 px-6 py-10 text-center">
                                                            <span class="flex size-12 items-center justify-center rounded-full bg-gray-100 text-gray-400">
                                                                <span class="outcraft-icon !text-[24px]">close</span>
                                                            </span>
                                                            <h5 class="mt-5 text-base font-bold text-gray-950">No Flow Template Steps</h5>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </article>
                                    </template>

                                    <button type="button" x-on:click="openBriefBuilderItemModal()" class="group flex w-full items-start gap-4 rounded-lg border border-gray-300 bg-white p-5 text-left transition hover:border-2 hover:border-indigo-600 hover:p-[19px] focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                                        <span class="flex size-10 shrink-0 items-center justify-center rounded-md bg-indigo-600 text-white">
                                            <span class="outcraft-icon !text-[22px]">add</span>
                                        </span>
                                        <span class="min-w-0">
                                            <span class="block text-base font-semibold leading-6 text-gray-950">Add Item</span>
                                            <span class="mt-1 block text-sm leading-6 text-gray-500">Find and add extra campaign context blocks, rules, pricing, channel guidelines, or qualification logic.</span>
                                        </span>
                                    </button>

	                                </div>
	                            </section>

	                            <section x-cloak x-show="campaignSetup.current === 'general' || campaignSetupScrollFromStep === 'general'" x-ref="campaignSetupStep_general"
                                :style="campaignSetupStepStyle('general')"
                                data-campaign-setup-step
                                class="pr-2 pb-4">
                                <div class="mb-1">
                                    <p class="text-sm font-semibold text-indigo-600" x-text="`${campaignSetupMode === 'fast' ? 'Fast Setup' : 'Advanced Setup'} · Step ${campaignSetupStepIndex('general') + 1} of ${campaignSetupStepsForMode().length}`"></p>
                                    <span class="mb-4 flex size-10 items-center justify-center rounded-md bg-indigo-50 text-indigo-600">
                                        <span class="outcraft-icon !text-[21px]" x-text="campaignSetupStepIcon('general')"></span>
                                    </span>
                                    <h2 class="mt-2 text-2xl font-bold leading-8 tracking-tight text-gray-950" x-text="campaignSetupHeading('general')"></h2>
                                    <p class="mt-2 max-w-3xl text-sm leading-6 text-gray-600" x-text="campaignSetupDescription('general')"></p>
                                </div>
	                                <div class="overflow-hidden rounded-lg bg-white shadow-sm ring-1 ring-gray-200">
	                                    <div class="border-b border-gray-200 px-6 py-5">
	                                        <h3 class="text-base font-semibold text-gray-950">General Settings</h3>
	                                    </div>
	                                    <div class="space-y-8 px-6 py-7">
	                                        <fieldset class="rounded-lg border border-gray-200 px-6 pb-6 pt-5">
	                                            <legend class="px-2 text-sm font-semibold text-gray-900">Sendable Resources</legend>
	                                            <div class="space-y-6">
		                                                <button type="button" x-on:click="campaignSetup.shortenLinks = ! campaignSetup.shortenLinks" role="switch" :aria-checked="campaignSetup.shortenLinks" class="flex w-full items-start gap-4 rounded-md text-left focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
		                                                    <span class="relative mt-1 inline-flex h-6 w-11 shrink-0 rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out" :class="campaignSetup.shortenLinks ? 'bg-indigo-600' : 'bg-gray-200'">
		                                                        <span class="pointer-events-none inline-block size-5 rounded-full bg-white shadow transition duration-200 ease-in-out" :class="campaignSetup.shortenLinks ? 'translate-x-5' : 'translate-x-0'"></span>
		                                                    </span>
	                                                    <span>
	                                                        <span class="block text-sm font-semibold leading-6 text-gray-950">Should Shorten Links in Messages?</span>
	                                                        <span class="mt-1 block text-sm leading-6 text-gray-600">If enabled, any links the AI includes in emails will be shortened using the built-in link shortener.</span>
	                                                    </span>
	                                                </button>
	                                                <label class="block">
	                                                    <span class="block text-sm/6 font-semibold text-gray-900">Brand to Include in Shortened Links (optional)</span>
	                                                    <input x-model="campaignSetup.shortLinkBrand" :disabled="! campaignSetup.shortenLinks" type="text" placeholder="example" class="mt-2 block w-full rounded-md bg-white px-3 py-1.5 text-sm/6 text-gray-900 shadow-sm outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 disabled:bg-gray-50 disabled:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600">
	                                                    <span class="mt-2 block text-sm leading-6 text-gray-600">Will resolve to https://example.com/l/@{{brand}}-a1b2c3d4, otherwise will default to random string</span>
	                                                </label>
	                                            </div>
	                                        </fieldset>

	                                    </div>
	                                </div>
	                            </section>

	                            <section x-cloak x-show="campaignSetup.current === 'resources' || campaignSetupScrollFromStep === 'resources'" x-ref="campaignSetupStep_resources"
                                :style="campaignSetupStepStyle('resources')"
                                data-campaign-setup-step
                                class="space-y-6 pr-2 pb-4">
                                <div class="mb-1">
                                    <p class="text-sm font-semibold text-indigo-600" x-text="`${campaignSetupMode === 'fast' ? 'Fast Setup' : 'Advanced Setup'} · Step ${campaignSetupStepIndex('resources') + 1} of ${campaignSetupStepsForMode().length}`"></p>
                                    <span class="mb-4 flex size-10 items-center justify-center rounded-md bg-indigo-50 text-indigo-600">
                                        <span class="outcraft-icon !text-[21px]" x-text="campaignSetupStepIcon('resources')"></span>
                                    </span>
                                    <h2 class="mt-2 text-2xl font-bold leading-8 tracking-tight text-gray-950" x-text="campaignSetupHeading('resources')"></h2>
                                    <p class="mt-2 max-w-3xl text-sm leading-6 text-gray-600" x-text="campaignSetupDescription('resources')"></p>
                                </div>
                                <div class="grid gap-4 sm:grid-cols-2">
                                    <button type="button" x-on:click="campaignSetup.discountCode = ! campaignSetup.discountCode" class="flex items-start justify-between gap-4 rounded-lg border border-gray-200 p-4 text-left"><span><span class="block text-sm font-medium text-gray-900">Send a Discount Code After the Offer Is Accepted?</span><span class="mt-1 block text-sm leading-6 text-gray-500">If enabled, the AI will attach a discount code when messaging leads.</span></span><span class="relative inline-flex h-6 w-11 rounded-full p-0.5" :class="campaignSetup.discountCode ? 'bg-indigo-600' : 'bg-gray-200'"><span class="size-5 rounded-full bg-white shadow-sm transition" :class="campaignSetup.discountCode ? 'translate-x-5' : 'translate-x-0'"></span></span></button>
                                    <button type="button" x-on:click="campaignSetup.shortenLinks = ! campaignSetup.shortenLinks" class="flex items-start justify-between gap-4 rounded-lg border border-gray-200 p-4 text-left"><span><span class="block text-sm font-medium text-gray-900">Should Shorten Links in Messages?</span><span class="mt-1 block text-sm leading-6 text-gray-500">If enabled, links included in email or SMS will use the built-in link shortener.</span></span><span class="relative inline-flex h-6 w-11 rounded-full p-0.5" :class="campaignSetup.shortenLinks ? 'bg-indigo-600' : 'bg-gray-200'"><span class="size-5 rounded-full bg-white shadow-sm transition" :class="campaignSetup.shortenLinks ? 'translate-x-5' : 'translate-x-0'"></span></span></button>
                                </div>
                                <div class="grid gap-5 sm:grid-cols-2">
                                    <label class="block"><span class="block text-sm/6 font-medium text-gray-900">Brand to Include in Shortened Links</span><input x-model="campaignSetup.shortLinkBrand" :disabled="! campaignSetup.shortenLinks" type="text" placeholder="example" class="mt-2 block w-full rounded-md px-3 py-1.5 text-sm/6 outline outline-1 -outline-offset-1 outline-gray-300 disabled:bg-gray-50 disabled:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600"><span class="mt-2 block text-sm leading-6 text-gray-500">Will resolve to https://example.com/@{{brand}}-a1b2c3d4. Otherwise a random string will be used.</span></label>
                                    <label class="block"><span class="block text-sm/6 font-medium text-gray-900">Additional Info to Send After the Offer Is Accepted</span><textarea x-model="campaignSetup.offerInfo" rows="5" placeholder="Example: Mention the package usually arrives in 14 days." class="mt-2 block w-full rounded-md px-3 py-1.5 text-sm/6 outline outline-1 -outline-offset-1 outline-gray-300 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600"></textarea></label>
                                </div>
                            </section>

                            <section x-cloak x-show="campaignSetup.current === 'agent' || campaignSetupScrollFromStep === 'agent'" x-ref="campaignSetupStep_agent"
                                :style="campaignSetupStepStyle('agent')"
                                data-campaign-setup-step
                                class="space-y-6 pr-2 pb-4">
                                <div class="mb-1">
                                    <p class="text-sm font-semibold text-indigo-600" x-text="campaignSetupStepIndex('agent') >= 0 ? `${campaignSetupMode === 'fast' ? 'Fast Setup' : 'Advanced Setup'} · Step ${campaignSetupStepIndex('agent') + 1} of ${campaignSetupStepsForMode().length}` : 'Campaign Details'"></p>
                                    <div data-step-icon-row>
                                        <span class="flex size-10 items-center justify-center rounded-md bg-indigo-50 text-indigo-600">
                                            <span class="outcraft-icon !text-[21px]" x-text="campaignSetupStepIcon('agent')"></span>
                                        </span>
                                    </div>
                                    <h2 class="mt-2 text-2xl font-bold leading-8 tracking-tight text-gray-950" x-text="campaignSetupHeading('agent')"></h2>
                                    <p class="mt-2 max-w-3xl text-sm leading-6 text-gray-600" x-text="campaignSetupDescription('agent')"></p>
                                </div>

                                <div class="space-y-3">
                                            <div x-show="campaignBuilderAiAgentOptions().length === 0" class="rounded-lg bg-white p-6 text-center shadow-sm outline outline-1 -outline-offset-1 outline-gray-300">
                                                <span class="mx-auto flex size-10 items-center justify-center rounded-full bg-gray-50 text-gray-400 ring-1 ring-inset ring-gray-200">
                                                    <span class="outcraft-icon !text-[20px]">support_agent</span>
                                                </span>
                                                <p class="mt-3 text-sm font-semibold text-gray-950">No AI agents yet</p>
                                                <p class="mt-1 text-sm text-gray-500">Create an agent before continuing this campaign.</p>
                                            </div>

                                            <template x-for="agent in campaignBuilderAiAgentOptions()" :key="`campaign-agent-${agent.id}`">
                                                <button
	                                                type="button"
	                                                x-on:click="selectCampaignAiAgent(agent)"
	                                                data-card-ignore
	                                                class="oc-selectable-card flex w-full items-center gap-4 rounded-lg bg-white p-4 text-left shadow-sm outline outline-1 -outline-offset-1 transition hover:outline-2 hover:-outline-offset-2 hover:outline-indigo-600 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
	                                                :class="campaignSetup.selectedAiAgentId === agent.id ? 'outline-2 -outline-offset-2 outline-indigo-600' : 'outline-gray-300'"
	                                            >
                                                    <span class="inline-flex size-10 shrink-0 items-center justify-center">
                                                        <img :src="aiAgentFlagUrl(agent)" :alt="`${aiAgentTitle(agent)} flag`" class="size-[34px] object-contain" loading="lazy">
                                                    </span>
                                                    <span class="min-w-0">
                                                        <span class="block text-sm font-semibold leading-6 text-gray-950" x-text="aiAgentTitle(agent)"></span>
                                                        <span class="block text-sm leading-6 text-gray-500">
                                                            <span x-text="agent.name"></span>
                                                            <span aria-hidden="true"> &middot; </span>
                                                            <span x-text="aiAgentVoiceStyle(agent)"></span>
                                                        </span>
                                                    </span>
                                                </button>
                                            </template>

                                            <button
	                                                type="button"
	                                                x-on:click="openAiAgentCreateModalFromCampaignSetup()"
	                                                data-card-ignore
	                                                class="oc-selectable-card flex w-full items-center gap-4 rounded-lg bg-white p-4 text-left shadow-sm outline outline-1 -outline-offset-1 outline-gray-300 transition hover:outline-2 hover:-outline-offset-2 hover:outline-indigo-600 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
	                                            >
                                                <span class="flex size-10 shrink-0 items-center justify-center rounded-md oc-primary-bg text-white">
                                                    <span class="outcraft-icon !text-[20px] text-white">plus</span>
                                                </span>
                                                <span class="min-w-0">
                                                    <span class="block text-sm font-semibold leading-6 text-gray-950">Add New Agent</span>
                                                    <span class="block text-sm leading-6 text-gray-500">Start a fresh AI agent profile for this campaign setup.</span>
                                                </span>
                                            </button>
                                </div>

                                <div x-show="false" class="space-y-6">
                                <div data-card-surface class="overflow-hidden rounded-lg border border-gray-200 bg-white">
                                    <template x-for="(language, languageIndex) in campaignSetup.languages" :key="language.code">
                                        <div class="border-b border-gray-200 last:border-b-0">
                                            <div
                                                role="button"
                                                tabindex="0"
                                                x-on:click="toggleCampaignSetupLanguageAccordion(language.code)"
                                                x-on:keydown.enter.prevent="toggleCampaignSetupLanguageAccordion(language.code)"
                                                x-on:keydown.space.prevent="toggleCampaignSetupLanguageAccordion(language.code)"
                                                class="flex cursor-pointer items-center justify-between gap-4 px-5 py-4 text-left transition hover:bg-gray-50"
                                                :aria-expanded="(campaignSetup.languageAccordionOpen === language.code).toString()"
                                            >
                                                <span class="flex min-w-0 flex-1 items-center gap-3">
                                                    <span class="inline-flex size-7 shrink-0 overflow-hidden rounded-full ring-1 ring-gray-200">
                                                        <img :src="campaignSetupFlagUrl(language)" :alt="`${campaignSetupLanguageDisplay(language)} flag`" class="size-full object-cover" loading="lazy">
                                                    </span>
                                                    <span class="min-w-0">
                                                        <span class="block truncate text-base/7 font-semibold text-gray-900" x-text="campaignSetupAgentTitle(language)"></span>
                                                        <span class="mt-1 block text-sm leading-6 text-gray-600">Change settings for this language's agent.</span>
                                                    </span>
                                                </span>
                                                <span class="flex shrink-0 items-center gap-3">
                                                    <span x-show="campaignSetup.defaultLanguage === language.code" class="rounded-full bg-indigo-50 px-2.5 py-1 text-xs font-medium text-indigo-700 ring-1 ring-inset ring-indigo-200">Default</span>
                                                    <span class="outcraft-icon shrink-0 !text-[18px] text-gray-400 transition" :class="campaignSetup.languageAccordionOpen === language.code ? 'rotate-180' : ''">keyboard_arrow_down</span>
                                                </span>
                                            </div>
                                            <div x-show="campaignSetup.languageAccordionOpen === language.code" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-3" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-2" class="border-t border-gray-200 p-6">
                                    <div class="mb-6 flex flex-wrap items-center justify-between gap-4">
                                        <button x-show="campaignSetup.defaultLanguage !== language.code" type="button" x-on:click="setCampaignSetupDefaultLanguage(language.code)" class="inline-flex h-9 items-center rounded-md bg-white px-3 text-sm font-semibold text-indigo-600 shadow-sm ring-1 ring-inset ring-indigo-200 transition hover:bg-indigo-50 hover:text-indigo-500 focus:outline-none focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Set as Default</button>
                                        <span x-show="campaignSetup.defaultLanguage === language.code" class="hidden sm:block"></span>
                                        <button x-show="campaignSetup.languages.length > 1" type="button" x-on:click="removeCampaignSetupLanguage(language.code)" class="ml-auto text-sm font-semibold text-indigo-600 transition hover:text-indigo-500 focus:outline-none focus-visible:rounded focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Remove language</button>
                                    </div>
                                    <div class="grid gap-6 lg:grid-cols-2">
                                        <label class="block">
                                            <span class="block text-sm/6 font-semibold text-gray-900">Agent Name<span class="text-indigo-400">*</span></span>
                                            <input x-model="campaignSetup.agentName" type="text" class="mt-2 block w-full rounded-md bg-white px-3 py-1.5 text-sm/6 text-gray-900 shadow-sm outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600">
                                            <span class="mt-2 block text-sm leading-6 text-gray-600">How the AI assistant will introduce itself to leads.</span>
                                        </label>

                                        <label class="block">
                                            <span class="block text-sm/6 font-semibold text-gray-900">Voice<span class="text-indigo-400">*</span></span>
                                            <x-outcraft.select
                                                class="mt-2"
                                                model="campaignSetup.voice"
                                                :options="['Bridget (Ultra-realistic)', 'Maya (Warm)', 'Alex (Calm)']"
                                            />
                                        </label>
                                    </div>

                                    <div class="mt-6">
                                        <h3 class="text-sm/6 font-semibold text-gray-900">Hear How Your AI Agent Sounds</h3>
                                        <div class="mt-2 flex items-center gap-3 rounded-lg border border-gray-200 bg-gray-50 p-3">
                                            <button type="button" class="flex size-9 items-center justify-center rounded-full bg-indigo-600 text-white shadow-sm">
                                                <span class="outcraft-icon !text-[18px]">play_arrow</span>
                                            </button>
                                            <div class="h-2 flex-1 rounded-full bg-gray-200">
                                                <div class="h-2 w-1/3 rounded-full bg-indigo-600"></div>
                                            </div>
                                            <span class="text-xs font-medium text-gray-500">0:18</span>
                                            <span class="outcraft-icon text-gray-400">volume_up</span>
                                        </div>
                                    </div>

                                    <div class="mt-6 grid gap-6 lg:grid-cols-2">
                                        <label class="block lg:col-span-2">
                                            <span class="block text-sm/6 font-semibold text-gray-900">Call Background Sound</span>
                                            <x-outcraft.select
                                                class="mt-2"
                                                model="campaignSetup.backgroundNoise"
                                                :options="['Office', 'None', 'Cafe', 'Street']"
                                            />
                                        </label>

                                        <label class="block lg:col-span-2">
                                            <span class="mb-2 flex items-center justify-between gap-3">
                                                <span class="block text-sm/6 font-semibold text-gray-900">Call Greeting Phrase<span class="text-indigo-400">*</span></span>
                                                <span class="relative" x-data="{ fieldActionsOpen: false }" x-on:click.outside="fieldActionsOpen = false">
                                                    <button type="button" x-on:click="fieldActionsOpen = ! fieldActionsOpen" class="inline-flex size-7 items-center justify-center rounded-md text-gray-400 transition hover:bg-gray-50 hover:text-gray-700" aria-label="Call greeting custom field actions">
                                                        <span class="outcraft-icon !text-[18px]">more_vert</span>
                                                    </button>
                                                    <span x-cloak x-show="fieldActionsOpen" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-3" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-2" class="absolute right-0 z-40 mt-2 w-52 rounded-md bg-white py-1 shadow-lg ring-1 ring-gray-900/10">
                                                        <button type="button" x-on:click="openCustomFieldTextInput('agentCallGreeting'); fieldActionsOpen = false" class="flex w-full items-center gap-2 px-3 py-2 text-left text-sm font-medium text-gray-700 transition hover:bg-gray-50 hover:text-gray-950">
                                                            <span class="text-xs text-gray-400">{+}</span>
                                                            Open Custom Fields
                                                        </button>
                                                        <button type="button" x-on:click="fieldActionsOpen = false" class="flex w-full items-center gap-2 px-3 py-2 text-left text-sm font-medium text-gray-700 transition hover:bg-gray-50 hover:text-gray-950">
                                                            <span class="outcraft-icon !text-[15px] text-gray-400">settings</span>
                                                            Configure Custom Fields
                                                        </button>
                                                    </span>
                                                </span>
                                            </span>
                                            <div data-component="custom-field-text-input" class="mt-2 overflow-hidden rounded-md border border-gray-300 bg-white shadow-sm transition focus-within:border-indigo-600 focus-within:ring-1 focus-within:ring-indigo-600">
                                                <div class="relative grid min-w-0 overflow-hidden transition-[grid-template-columns] duration-200 ease-out" :class="customFieldTextInputState('agentCallGreeting').layoutOpen ? 'lg:grid-cols-[minmax(0,1fr)_18rem]' : 'lg:grid-cols-1'">
                                                    <textarea x-model="campaignSetup.callGreeting" rows="2" class="block min-h-[64px] min-w-0 w-full resize-y border-0 bg-white px-5 py-4 text-sm/6 text-gray-700 outline-none placeholder:text-gray-400 focus:ring-0"></textarea>
                                                    <aside x-cloak x-show="customFieldTextInputState('agentCallGreeting').open" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="translate-x-full opacity-0" x-transition:enter-end="translate-x-0 opacity-100" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="translate-x-0 opacity-100" x-transition:leave-end="translate-x-full opacity-0" class="min-w-0 border-t border-gray-200 bg-white lg:border-t-0 lg:border-l lg:border-gray-200">
                                                        <div class="flex items-center gap-2 border-b border-gray-200 px-4 py-3"><label class="min-w-0 flex-1"><input :value="customFieldTextInputState('agentCallGreeting').search" x-on:input="customFieldTextInputState('agentCallGreeting').search = $event.target.value" type="search" placeholder="Search Custom Fields" class="block h-9 w-full rounded-md bg-white px-3 py-1.5 text-sm text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600"></label><button type="button" x-on:click="closeCustomFieldTextInput('agentCallGreeting')" class="inline-flex size-7 items-center justify-center rounded-md text-gray-400 transition hover:bg-white hover:text-gray-700" aria-label="Close custom fields"><span class="outcraft-icon !text-[18px]">close</span></button></div>
                                                        <div class="flex flex-wrap gap-2 px-4 py-4"><template x-for="tag in filteredCustomFieldTextInputTags('agentCallGreeting')" :key="`agent-greeting-${tag}`"><button type="button" class="inline-flex h-8 items-center rounded-md bg-white px-2.5 text-sm font-medium text-gray-600 shadow-sm ring-1 ring-inset ring-gray-200 transition hover:bg-gray-50 hover:text-gray-900" x-text="tag"></button></template><p x-show="filteredCustomFieldTextInputTags('agentCallGreeting').length === 0" class="text-sm text-gray-500">No Custom Fields Found.</p></div>
                                                    </aside>
                                                </div>
                                            </div>
                                            <button type="button" x-on:click="campaignSetup.callGreeting = 'Hey, is this @{{first_name}}?'" class="mt-2 text-sm font-semibold text-indigo-600 hover:text-indigo-500">Use Default</button>
                                        </label>
                                    </div>
                                            </div>
                                        </div>
                                    </template>
                                </div>
                                <button type="button" x-on:click="openCampaignSetupLanguageBatchModal()" class="inline-flex h-9 items-center gap-2 rounded-md bg-white px-3 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 transition hover:bg-gray-50">
                                    <span class="outcraft-icon !text-[18px] text-gray-500">add</span>
                                    Add Language
                                </button>

                                <div x-show="campaignSetupMode === 'advanced'" class="rounded-lg border border-gray-200 bg-white p-6">
                                    <h3 class="text-base font-semibold leading-6 text-gray-950">Schedule</h3>
                                    <p class="mt-2 max-w-3xl text-sm leading-6 text-gray-600">Outreach is scheduled and sent based on the lead's local timezone. The timezone is inferred from the lead's phone number and country data.</p>

                                    <div class="mt-8">
                                        <label class="block max-w-xl">
                                            <span class="block text-sm/6 font-semibold text-gray-900">Outreach Schedule</span>
                                            <x-outcraft.select
                                                class="mt-2"
                                                model="campaignSetup.scheduleMode"
                                                :options="[
                                                    ['value' => 'business', 'label' => 'Local Business Hours'],
                                                    ['value' => 'extended', 'label' => 'Local Extended Hours'],
                                                    ['value' => 'all-day', 'label' => 'Always On'],
                                                    ['value' => 'custom', 'label' => 'Custom Schedule'],
                                                ]"
                                                on-change="campaignSetup.allDay = campaignSetup.scheduleMode === 'all-day'; scheduleCampaignBuilderLayoutUpdate()"
                                            />
                                            <span class="mt-2 block text-sm leading-6 text-gray-600" x-text="campaignScheduleDescription()"></span>
                                        </label>

                                        <fieldset x-show="campaignSetup.scheduleMode === 'custom'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-3" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-2" class="mt-7">
                                            <div class="flex items-center justify-between gap-4">
                                                <h4 class="text-sm font-semibold leading-6 text-gray-950">Outreach Days</h4>
                                                <button type="button" x-on:click="selectAllOutreachDays()" class="text-sm font-semibold text-indigo-600 hover:text-indigo-500">Select All</button>
                                            </div>

                                            <div class="mt-4 flex flex-col gap-3 sm:flex-row sm:flex-wrap sm:items-center sm:gap-x-6 sm:gap-y-3">
                                                <template x-for="day in outreachWeekdays" :key="day">
                                                    <label class="inline-flex w-fit cursor-pointer items-center gap-3 rounded-md text-sm font-semibold leading-6 text-gray-900">
                                                        <x-outcraft.checkbox
                                                            mark-when="campaignSetup.outreachDays.includes(day)"
                                                            x-bind:checked="campaignSetup.outreachDays.includes(day)"
                                                            x-on:change="toggleOutreachDay(day)"
                                                        />
                                                        <span x-text="day"></span>
                                                    </label>
                                                </template>
                                            </div>

                                            <div class="mt-7 grid gap-6 lg:grid-cols-2">
                                                <label class="block">
                                                    <span class="block text-sm/6 font-semibold text-gray-900">Outreach Start Hour<span class="text-indigo-400">*</span></span>
                                                    <x-outcraft.select
                                                        class="mt-2"
                                                        model="campaignSetup.outreachStartHour"
                                                        options="outreachHourOptions"
                                                    />
                                                    <span class="mt-2 block text-sm leading-6 text-gray-600">The earliest time AI can contact a lead in their local timezone.</span>
                                                </label>

                                                <label class="block">
                                                    <span class="block text-sm/6 font-semibold text-gray-900">Outreach End Hour<span class="text-indigo-400">*</span></span>
                                                    <x-outcraft.select
                                                        class="mt-2"
                                                        model="campaignSetup.outreachEndHour"
                                                        options="outreachHourOptions"
                                                    />
                                                    <span class="mt-2 block text-sm leading-6 text-gray-600">The latest time AI can contact a lead in their local timezone.</span>
                                                </label>
                                            </div>
                                        </fieldset>
                                    </div>
                                </div>
                                <div x-show="campaignSetupMode === 'advanced'" class="space-y-7">
                                    <div class="overflow-visible rounded-lg border border-gray-200 bg-white">
                                        <button type="button" x-on:click="agentAdvancedOpen = ! agentAdvancedOpen; scheduleCampaignBuilderLayoutUpdate()" class="flex w-full items-center justify-between gap-4 px-5 py-4 text-left transition hover:bg-gray-50">
                                            <span>
                                                <span class="block text-base/7 font-semibold text-gray-900">Advanced</span>
                                                <span class="mt-1 block text-sm leading-6 text-gray-600">We recommend keeping the default Advanced settings. They’re tuned for natural flow and stronger results.</span>
                                            </span>
                                            <span class="outcraft-icon shrink-0 !text-[18px] text-gray-400 transition" :class="agentAdvancedOpen ? 'rotate-180' : ''">keyboard_arrow_down</span>
                                        </button>

                                        <div x-show="agentAdvancedOpen" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-3" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-2" class="border-t border-gray-200 p-5">
                                            <div class="grid gap-6 lg:grid-cols-2">
                                                <label class="order-4 block lg:col-span-2">
                                            <span class="mb-2 block text-sm/6 font-semibold text-gray-900">Agent Email Signature</span>
                                            <textarea x-model="campaignSetup.emailSignature" rows="4" placeholder="Best,&#10;Bridget from Example" class="mt-2 block min-h-[96px] w-full resize-y rounded-md bg-white px-3 py-2 text-sm/6 text-gray-700 shadow-sm outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600"></textarea>
                                            <span class="mt-2 block text-sm leading-6 text-gray-600">This signature will be used at the end of all emails sent by the AI agent.</span>
                                        </label>
                                            <div class="order-5 -mx-5 border-t border-gray-200 lg:col-span-2"></div>
                                            <label class="order-7 block">
                                                <span class="block text-sm/6 font-semibold text-gray-900">Transcriber Model <span class="text-xs font-medium text-gray-400">Admin-Only</span></span>
                                                <x-outcraft.select class="mt-2" model="campaignSetup.transcriberModel" :options="['Flux General']" />
                                            </label>
                                            <label class="order-6 block">
                                                <span class="block text-sm/6 font-semibold text-gray-900">AI Model <span class="text-xs font-medium text-gray-400">Admin-Only</span></span>
                                                <x-outcraft.select class="mt-2" model="campaignSetup.aiModel" :options="['GPT-4.1']" />
                                            </label>
                                            <div class="order-8 -mx-5 border-t border-gray-200 lg:col-span-2"></div>

                                            <label class="order-9 block lg:col-span-2">
                                                <span class="mb-2 block text-sm/6 font-semibold text-gray-900">AI Agent Personality<span class="text-indigo-400">*</span></span>
                                                <textarea x-model="campaignSetup.agentPersonality" rows="6" class="mt-2 block min-h-[140px] w-full resize-y rounded-md bg-white px-3 py-2 text-sm/6 text-gray-700 shadow-sm outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600"></textarea>
                                            </label>

                                            <label class="order-10 block lg:col-span-2">
                                                <span class="mb-2 block text-sm/6 font-semibold text-gray-900">AI Agent Speech Style<span class="text-indigo-400">*</span></span>
                                                <textarea x-model="campaignSetup.agentSpeechStyle" rows="6" class="mt-2 block min-h-[140px] w-full resize-y rounded-md bg-white px-3 py-2 text-sm/6 text-gray-700 shadow-sm outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600"></textarea>
                                            </label>
                                        </div>
                                    </div>
                                    </div>
                                </div>
                                </div>


                            </section>

	                            <section x-cloak x-show="campaignSetup.current === 'channels' || campaignSetupScrollFromStep === 'channels'" x-ref="campaignSetupStep_channels"
                                :style="campaignSetupStepStyle('channels')"
                                data-campaign-setup-step
                                class="space-y-6 pr-2 pb-4">
                                <div class="mb-1">
                                    <p class="text-sm font-semibold text-indigo-600" x-text="`${campaignSetupMode === 'fast' ? 'Fast Setup' : 'Advanced Setup'} · Step ${campaignSetupStepIndex('channels') + 1} of ${campaignSetupStepsForMode().length}`"></p>
                                    <span class="mb-4 flex size-10 items-center justify-center rounded-md bg-indigo-50 text-indigo-600">
                                        <span class="outcraft-icon !text-[21px]" x-text="campaignSetupStepIcon('channels')"></span>
                                    </span>
                                    <h2 class="mt-2 text-2xl font-bold leading-8 tracking-tight text-gray-950" x-text="campaignSetupHeading('channels')"></h2>
                                    <p class="mt-2 max-w-3xl text-sm leading-6 text-gray-600" x-text="campaignSetupDescription('channels')"></p>
                                </div>
                                <div class="space-y-6">
                                    <div class="overflow-visible rounded-lg border border-gray-200 bg-white">
                                        <div class="divide-y divide-gray-200">
	                                <div class="px-6 py-6">
	                                    <div>
	                                        <div class="flex items-center justify-between gap-4">
	                                            <button type="button" x-on:click="toggleChannel('calls')" class="min-w-0 flex-1 rounded-md text-left focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
	                                                <span class="block text-sm font-semibold leading-6 text-gray-950">Voice &amp; Calls</span>
	                                                <span class="mt-1 block text-sm leading-6 text-gray-600">Enable communication with leads through AI voice calls.</span>
	                                            </button>
	                                            <button type="button" x-on:click="toggleChannel('calls')" role="switch" :aria-checked="campaignSetup.channels.calls" class="relative inline-flex h-6 w-11 shrink-0 self-center rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600" :class="campaignSetup.channels.calls ? 'bg-indigo-600' : 'bg-gray-200'">
	                                                <span class="pointer-events-none inline-block size-5 rounded-full bg-white shadow transition duration-200 ease-in-out" :class="campaignSetup.channels.calls ? 'translate-x-5' : 'translate-x-0'"></span>
	                                            </button>
	                                        </div>
	                                        <button type="button" x-on:click="campaignSetup.channelOpen.calls = ! campaignSetup.channelOpen.calls; scheduleCampaignBuilderLayoutUpdate()" :disabled="! campaignSetup.channels.calls" class="mt-3 inline-flex h-8 items-center gap-1.5 rounded-md bg-white px-2.5 text-sm font-semibold shadow-sm ring-1 ring-inset ring-gray-300 transition hover:bg-gray-50 disabled:cursor-not-allowed disabled:bg-gray-50 disabled:text-gray-400 disabled:ring-gray-200" :class="campaignSetup.channels.calls ? 'text-gray-900' : 'text-gray-400'">
	                                            Configure
	                                            <span class="outcraft-icon !text-[15px] text-gray-400" :class="campaignSetup.channels.calls && campaignSetup.channelOpen.calls ? 'rotate-180' : ''">keyboard_arrow_down</span>
	                                        </button>
	                                        <div x-show="campaignSetup.channels.calls && campaignSetup.channelOpen.calls" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-3" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-2" class="mt-6 space-y-5">
	                                            <div class="rounded-lg border border-blue-200 bg-blue-50 px-4 py-3 text-sm leading-6 text-blue-700">It is highly recommended to have at least one phone number for <span class="font-semibold">North America (United States)</span> and one for <span class="font-semibold">Europe (Netherlands is a good option)</span> to ensure best deliverability of your campaigns.</div>
	                                            <div class="overflow-visible rounded-lg border border-gray-200 bg-white">
	                                                <table class="min-w-full divide-y divide-gray-200 text-left text-sm">
	                                                    <thead class="bg-gray-50"><tr><th class="px-4 py-3 font-semibold text-gray-600">Phone Number</th><th class="px-4 py-3 font-semibold text-gray-600">Country</th><th class="px-4 py-3"><span class="sr-only">Actions</span></th></tr></thead>
	                                                    <tbody class="divide-y divide-gray-100">
	                                                        <template x-for="phone in campaignSetup.phoneNumbers" :key="phone.number"><tr><td class="min-w-0 px-4 py-3"><button type="button" x-on:click.stop="copyContact(phone.number)" class="group relative flex max-w-[220px] text-left text-sm font-semibold text-gray-950 transition hover:text-gray-700"><span class="truncate" x-text="phone.number"></span><span class="pointer-events-none absolute bottom-full left-1/2 z-50 mb-2 -translate-x-1/2 translate-y-1 whitespace-nowrap rounded-lg bg-gray-900 px-3 py-2 text-xs font-medium text-white opacity-0 shadow-sm transition group-hover:translate-y-0 group-hover:opacity-100"><span x-text="phone.number"></span><span class="ml-2 text-white/70" x-text="copyTooltipLabel($el.previousElementSibling?.textContent)"></span><span class="absolute left-1/2 top-full size-2 -translate-x-1/2 -translate-y-1 rotate-45 bg-gray-900"></span></span></button><span class="mt-1 inline-flex rounded-md bg-green-50 px-2 py-1 text-xs font-medium text-green-700 ring-1 ring-inset ring-green-600/20" x-text="phone.status"></span></td><td class="px-4 py-3"><p class="font-medium text-gray-900" x-text="phone.country"></p><p class="mt-1 text-xs leading-5 text-gray-500" x-text="phone.state"></p></td><td class="px-4 py-3 text-right"><button type="button" x-on:click="removePhoneNumber(phone.number)" class="inline-flex size-8 items-center justify-center rounded-md text-gray-400 transition hover:bg-gray-50 hover:text-red-600" aria-label="Remove Phone Number"><span class="outcraft-icon !text-[17px]">delete</span></button></td></tr></template>
	                                                        <tr x-show="campaignSetup.phoneNumbers.length === 0">
	                                                            <td colspan="3" class="px-4 py-10">
	                                                                <div class="flex flex-col items-center justify-center text-center">
	                                                                    <span class="flex size-10 items-center justify-center rounded-full bg-gray-50 text-gray-400 ring-1 ring-inset ring-gray-200"><span class="outcraft-icon !text-[20px]">call</span></span>
	                                                                    <p class="mt-3 text-sm font-semibold text-gray-950">No phone numbers</p>
	                                                                    <p class="mt-1 text-sm text-gray-500">Assign a phone number to use voice calls in this campaign.</p>
	                                                                </div>
	                                                            </td>
	                                                        </tr>
	                                                    </tbody>
	                                                </table>
	                                            </div>
	                                            <div class="flex flex-wrap gap-3">
	                                                <button type="button" x-on:click="campaignSetup.phoneNumberModalOpen = true" class="inline-flex h-9 w-full items-center justify-center gap-2 rounded-md bg-white px-3 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 transition hover:bg-gray-50 sm:w-fit"><span class="outcraft-icon !text-[17px]">add</span><span>Add Phone Number</span></button>
	                                                <button type="button" x-on:click="campaignSetup.physicalAddressModalOpen = true" class="inline-flex h-9 w-full items-center justify-center gap-2 rounded-md bg-white px-3 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 transition hover:bg-gray-50 sm:w-fit"><svg class="size-4 text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M20 10c0 4.993-5.539 10.193-7.399 11.799a1 1 0 0 1-1.202 0C9.539 20.193 4 14.993 4 10a8 8 0 0 1 16 0"></path><circle cx="12" cy="10" r="3"></circle></svg><span>Physical Addresses</span></button>
	                                            </div>
	                                        </div>
	                                    </div>
	                                </div>

	                                <div class="px-6 py-6">
	                                    <div>
	                                        <div>
	                                            <div class="flex items-center justify-between gap-4">
	                                                <button type="button" x-on:click="toggleChannel('email')" class="min-w-0 flex-1 rounded-md text-left focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
	                                                    <span class="block text-sm font-semibold leading-6 text-gray-950">Email</span>
	                                                    <span class="mt-1 block text-sm leading-6 text-gray-600">Enable communication with leads through email.</span>
	                                                </button>
	                                                <button type="button" x-on:click="toggleChannel('email')" role="switch" :aria-checked="campaignSetup.channels.email" class="relative inline-flex h-6 w-11 shrink-0 self-center rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600" :class="campaignSetup.channels.email ? 'bg-indigo-600' : 'bg-gray-200'">
	                                                    <span class="pointer-events-none inline-block size-5 rounded-full bg-white shadow transition duration-200 ease-in-out" :class="campaignSetup.channels.email ? 'translate-x-5' : 'translate-x-0'"></span>
	                                                </button>
	                                            </div>
	                                            <button type="button" x-on:click="campaignSetup.channelOpen.email = ! campaignSetup.channelOpen.email; scheduleCampaignBuilderLayoutUpdate()" :disabled="! campaignSetup.channels.email" class="mt-3 inline-flex h-8 items-center gap-1.5 rounded-md bg-white px-2.5 text-sm font-semibold shadow-sm ring-1 ring-inset ring-gray-300 transition hover:bg-gray-50 disabled:cursor-not-allowed disabled:bg-gray-50 disabled:text-gray-400 disabled:ring-gray-200" :class="campaignSetup.channels.email ? 'text-gray-900' : 'text-gray-400'">
	                                                Configure
	                                                <span class="outcraft-icon !text-[15px] text-gray-400" :class="campaignSetup.channels.email && campaignSetup.channelOpen.email ? 'rotate-180' : ''">keyboard_arrow_down</span>
	                                            </button>
	                                        </div>
	                                        <div x-show="campaignSetup.channels.email && campaignSetup.channelOpen.email" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-3" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-2" class="mt-6 space-y-5">
	                                            <div class="overflow-visible rounded-lg border border-gray-200 bg-white">
	                                                <table class="min-w-full divide-y divide-gray-200 text-left text-sm">
	                                                    <thead class="bg-gray-50">
	                                                        <tr>
	                                                            <th class="px-4 py-3 font-semibold text-gray-600">Mailbox</th>
	                                                            <th class="px-4 py-3 font-semibold text-gray-600">Provider</th>
	                                                            <th class="px-4 py-3"><span class="sr-only">Actions</span></th>
	                                                        </tr>
	                                                    </thead>
	                                                    <tbody class="divide-y divide-gray-100">
	                                                        <template x-for="mailbox in campaignSetup.mailboxes" :key="mailbox.email">
	                                                            <tr>
	                                                                <td class="min-w-0 px-4 py-3">
	                                                                    <button type="button" x-on:click.stop="copyContact(mailbox.email)" class="group relative flex max-w-[260px] text-left text-sm font-semibold text-gray-950 transition hover:text-gray-700">
	                                                                        <span class="truncate" x-text="mailbox.email"></span>
	                                                                        <span class="pointer-events-none absolute bottom-full left-1/2 z-50 mb-2 -translate-x-1/2 translate-y-1 whitespace-nowrap rounded-lg bg-gray-900 px-3 py-2 text-xs font-medium text-white opacity-0 shadow-sm transition group-hover:translate-y-0 group-hover:opacity-100">
	                                                                            <span x-text="mailbox.email"></span>
	                                                                            <span class="ml-2 text-white/70" x-text="copyTooltipLabel($el.previousElementSibling?.textContent)"></span>
	                                                                            <span class="absolute left-1/2 top-full size-2 -translate-x-1/2 -translate-y-1 rotate-45 bg-gray-900"></span>
	                                                                        </span>
	                                                                    </button>
	                                                                    <span class="mt-1 inline-flex rounded-md bg-green-50 px-2 py-1 text-xs font-medium text-green-700 ring-1 ring-inset ring-green-600/20" x-text="mailbox.status"></span>
	                                                                </td>
	                                                                <td class="px-4 py-3">
	                                                                    <p class="text-sm font-medium text-gray-900" x-text="mailbox.provider"></p>
	                                                                    <span class="group relative mt-1 inline-flex text-xs leading-5 text-gray-500">
	                                                                        <span x-text="mailbox.connectedAgo"></span>
	                                                                        <span class="pointer-events-none absolute bottom-full left-0 z-50 mb-2 translate-y-1 whitespace-nowrap rounded-lg bg-gray-900 px-3 py-2 text-xs font-medium text-white opacity-0 shadow-sm transition group-hover:translate-y-0 group-hover:opacity-100">
	                                                                            <span x-text="mailbox.connectedAt"></span>
	                                                                            <span class="absolute left-6 top-full size-2 -translate-y-1 rotate-45 bg-gray-900"></span>
	                                                                        </span>
	                                                                    </span>
	                                                                </td>
	                                                                <td class="px-4 py-3 text-right"><button type="button" x-on:click="removeMailbox(mailbox.email)" class="inline-flex size-8 items-center justify-center rounded-md text-gray-400 transition hover:bg-gray-50 hover:text-red-600" aria-label="Remove Mailbox"><span class="outcraft-icon !text-[17px]">delete</span></button></td>
	                                                            </tr>
	                                                        </template>
	                                                        <tr x-show="campaignSetup.mailboxes.length === 0">
	                                                            <td colspan="3" class="px-4 py-10">
	                                                                <div class="flex flex-col items-center justify-center text-center">
	                                                                    <span class="flex size-10 items-center justify-center rounded-full bg-gray-50 text-gray-400 ring-1 ring-inset ring-gray-200"><span class="outcraft-icon !text-[20px]">mail</span></span>
	                                                                    <p class="mt-3 text-sm font-semibold text-gray-950">No mailboxes connected</p>
	                                                                    <p class="mt-1 text-sm text-gray-500">Connect a mailbox to use email outreach in this campaign.</p>
	                                                                </div>
	                                                            </td>
	                                                        </tr>
	                                                    </tbody>
	                                                </table>
	                                            </div>
	                                            <button type="button" x-on:click="campaignSetup.mailboxModalOpen = true" class="inline-flex h-9 w-full items-center justify-center gap-2 rounded-md bg-white px-3 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 transition hover:bg-gray-50 sm:w-fit">
	                                                <span class="outcraft-icon !text-[17px]">add</span>
	                                                <span>Add Mailbox</span>
	                                            </button>
	                                        </div>
	                                    </div>
	                                </div>

	                                <div class="px-6 py-6">
	                                    <div>
	                                        <div>
	                                            <div class="flex items-center justify-between gap-4">
	                                                <button type="button" x-on:click="toggleChannel('sms')" class="min-w-0 flex-1 rounded-md text-left focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
	                                                    <span class="block text-sm font-semibold leading-6 text-gray-950">SMS</span>
	                                                    <span class="mt-1 block text-sm leading-6 text-gray-600">Enable communication with leads through SMS.</span>
	                                                </button>
	                                                <button type="button" x-on:click="toggleChannel('sms')" role="switch" :aria-checked="campaignSetup.channels.sms" class="relative inline-flex h-6 w-11 shrink-0 self-center rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600" :class="campaignSetup.channels.sms ? 'bg-indigo-600' : 'bg-gray-200'">
	                                                    <span class="pointer-events-none inline-block size-5 rounded-full bg-white shadow transition duration-200 ease-in-out" :class="campaignSetup.channels.sms ? 'translate-x-5' : 'translate-x-0'"></span>
	                                                </button>
	                                            </div>
	                                            <button type="button" x-on:click="campaignSetup.channelOpen.sms = ! campaignSetup.channelOpen.sms; scheduleCampaignBuilderLayoutUpdate()" :disabled="! campaignSetup.channels.sms" class="mt-3 inline-flex h-8 items-center gap-1.5 rounded-md bg-white px-2.5 text-sm font-semibold shadow-sm ring-1 ring-inset ring-gray-300 transition hover:bg-gray-50 disabled:cursor-not-allowed disabled:bg-gray-50 disabled:text-gray-400 disabled:ring-gray-200" :class="campaignSetup.channels.sms ? 'text-gray-900' : 'text-gray-400'">
	                                                Configure
	                                                <span class="outcraft-icon !text-[15px] text-gray-400" :class="campaignSetup.channels.sms && campaignSetup.channelOpen.sms ? 'rotate-180' : ''">keyboard_arrow_down</span>
	                                            </button>
	                                        </div>
	                                        <div x-show="campaignSetup.channels.sms && campaignSetup.channelOpen.sms" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-3" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-2" class="mt-6 space-y-6">
	                                            <div>
	                                                <div class="flex items-center justify-between gap-3">
	                                                    <h4 class="text-sm font-semibold leading-6 text-gray-950">When to Trigger SMS?</h4>
	                                                </div>
	                                                <div class="relative mt-2" x-data="{ smsTriggerMenuOpen: false }" x-on:click.outside="smsTriggerMenuOpen = false">
	                                                    <div class="flex min-h-9 w-full items-center gap-2 rounded-md bg-white px-2 py-1.5 text-sm/6 text-gray-900 shadow-sm outline outline-1 -outline-offset-1 outline-gray-300 transition focus-within:outline-2 focus-within:-outline-offset-2 focus-within:outline-indigo-600">
	                                                        <button type="button" x-on:click="smsTriggerMenuOpen = true" class="flex min-w-0 flex-1 flex-wrap items-center gap-1.5 text-left">
	                                                            <template x-for="trigger in campaignSetup.smsTriggers" :key="trigger">
	                                                                <span class="inline-flex items-center gap-1 rounded-md bg-indigo-50 px-2 py-1 text-xs font-medium text-indigo-700 ring-1 ring-inset ring-indigo-600/20">
	                                                                    <span x-text="trigger"></span>
	                                                                    <span x-on:click.stop="removeSmsTrigger(trigger)" class="outcraft-icon cursor-pointer !text-[14px] text-indigo-500 hover:text-indigo-700">close</span>
	                                                                </span>
	                                                            </template>
	                                                            <span x-show="campaignSetup.smsTriggers.length === 0" class="px-1 text-sm text-gray-400">Select triggers</span>
	                                                        </button>
	                                                        <button type="button" x-on:click="smsTriggerMenuOpen = ! smsTriggerMenuOpen" class="flex size-7 shrink-0 items-center justify-center rounded-md text-gray-500 transition hover:bg-gray-50 hover:text-gray-900">
	                                                            <span class="outcraft-icon !text-[18px]" :class="smsTriggerMenuOpen ? 'rotate-180' : ''">keyboard_arrow_down</span>
	                                                        </button>
	                                                    </div>
	                                                    <div x-cloak x-show="smsTriggerMenuOpen" x-transition:enter="transition ease-out duration-150" x-transition:enter-start="opacity-0 translate-y-1" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-100" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-1" class="absolute z-30 mt-2 w-full overflow-hidden rounded-md bg-white py-1 shadow-lg ring-1 ring-black/5">
	                                                        <template x-for="option in smsTriggerOptions" :key="option">
	                                                            <button type="button" x-on:click="toggleSmsTrigger(option)" class="flex w-full items-center justify-between gap-3 px-3 py-2 text-left text-sm font-medium transition hover:bg-gray-50" :class="campaignSetup.smsTriggers.includes(option) ? 'text-gray-950' : 'text-gray-600'">
	                                                                <span x-text="option"></span>
	                                                                <span x-show="campaignSetup.smsTriggers.includes(option)" class="outcraft-icon !text-[16px] text-indigo-600">check</span>
	                                                            </button>
	                                                        </template>
	                                                    </div>
	                                                </div>
	                                                <span class="mt-2 block text-sm leading-6 text-gray-600">Select the events after which the AI can send an SMS to the lead.</span>
	                                            </div>
	                                        </div>
	                                    </div>
	                                </div>

	                                <div class="px-6 py-6">
	                                    <div>
	                                        <div>
	                                        <div class="flex items-center justify-between gap-4">
	                                            <button type="button" x-on:click="toggleChannel('whatsapp')" class="min-w-0 flex-1 rounded-md text-left focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
	                                                <span class="block text-sm font-semibold leading-6 text-gray-950">WhatsApp</span>
	                                                <span class="mt-1 block text-sm leading-6 text-gray-600">Enable communication with leads through WhatsApp.</span>
	                                            </button>
	                                            <button type="button" x-on:click="toggleChannel('whatsapp')" role="switch" :aria-checked="campaignSetup.channels.whatsapp" class="relative inline-flex h-6 w-11 shrink-0 self-center rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600" :class="campaignSetup.channels.whatsapp ? 'bg-indigo-600' : 'bg-gray-200'">
	                                                <span class="pointer-events-none inline-block size-5 rounded-full bg-white shadow transition duration-200 ease-in-out" :class="campaignSetup.channels.whatsapp ? 'translate-x-5' : 'translate-x-0'"></span>
	                                            </button>
	                                        </div>
	                                            <button type="button" x-on:click="campaignSetup.channelOpen.whatsapp = ! campaignSetup.channelOpen.whatsapp; scheduleCampaignBuilderLayoutUpdate()" :disabled="! campaignSetup.channels.whatsapp" class="mt-3 inline-flex h-8 items-center gap-1.5 rounded-md bg-white px-2.5 text-sm font-semibold shadow-sm ring-1 ring-inset ring-gray-300 transition hover:bg-gray-50 disabled:cursor-not-allowed disabled:bg-gray-50 disabled:text-gray-400 disabled:ring-gray-200" :class="campaignSetup.channels.whatsapp ? 'text-gray-900' : 'text-gray-400'">
	                                                Configure
	                                                <span class="outcraft-icon !text-[15px] text-gray-400" :class="campaignSetup.channels.whatsapp && campaignSetup.channelOpen.whatsapp ? 'rotate-180' : ''">keyboard_arrow_down</span>
	                                            </button>
	                                        </div>
	                                        <div x-show="campaignSetup.channels.whatsapp && campaignSetup.channelOpen.whatsapp" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-3" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-2" class="mt-6">
	                                            <div class="rounded-lg border border-gray-200 bg-white p-6 shadow-sm">
	                                                <div class="flex flex-col gap-4 sm:flex-row sm:items-start">
	                                                    <span class="flex size-[60px] shrink-0 items-center justify-center rounded-md bg-gray-100 text-[#25D366]">
	                                                        <span class="size-11" x-html="whatsappIconSvg()"></span>
	                                                    </span>
	                                                    <div class="min-w-0 flex-1">
	                                                        <h3 class="text-sm font-semibold leading-6 text-gray-950">Complete WhatsApp Business Account Setup</h3>
	                                                        <p class="mt-2 text-sm leading-6 text-gray-600">During setup, you will need to log in with Facebook and authorize your WhatsApp Business connection.</p>
	                                                        <div class="mt-4">
	                                                            <p class="text-sm font-semibold leading-6 text-gray-950">Make sure you have:</p>
	                                                            <ul class="mt-2 space-y-2 text-sm leading-6 text-gray-600">
	                                                                <li class="flex gap-2"><span class="mt-2 size-1.5 shrink-0 rounded-full bg-gray-400"></span><span>Facebook login credentials</span></li>
	                                                                <li class="flex gap-2"><span class="mt-2 size-1.5 shrink-0 rounded-full bg-gray-400"></span><span>Admin access to your Meta Business account</span></li>
	                                                                <li class="flex gap-2"><span class="mt-2 size-1.5 shrink-0 rounded-full bg-gray-400"></span><span>Your Meta Business account is verified.</span></li>
	                                                            </ul>
	                                                        </div>
	                                                        <p class="mt-4 text-sm leading-6 text-gray-600">Unverified businesses are unable to register WhatsApp senders or send messages through WhatsApp Business.</p>
	                                                        <p class="mt-4 text-sm leading-6 text-gray-600">During the setup, choose <span class="font-semibold text-gray-900">Use a display name only</span> instead of a real number. Outcraft will configure numbers for you automatically.</p>
	                                                        <div class="mt-5 flex flex-wrap items-center gap-3">
	                                                            <button type="button" x-on:click="toggleWhatsAppConnection()" class="inline-flex h-9 items-center rounded-md px-3 text-sm font-semibold shadow-sm transition" :class="campaignSetup.whatsappConnectionStatus === 'Connected' ? 'bg-white text-gray-900 ring-1 ring-inset ring-gray-300 hover:bg-gray-50' : 'bg-indigo-600 text-white hover:bg-indigo-500'" x-text="campaignSetup.whatsappConnectionStatus === 'Connected' ? 'Disconnect' : 'Connect WhatsApp'"></button>
	                                                        </div>
	                                                    </div>
	                                                    <span x-show="campaignSetup.whatsappConnectionStatus === 'Connected'" class="inline-flex w-fit shrink-0 rounded-md bg-green-50 px-2 py-1 text-xs font-medium text-green-700 ring-1 ring-inset ring-green-600/20 sm:ml-auto">Connected</span>
	                                                </div>
	                                            </div>
	                                        </div>
	                                    </div>
	                                </div>

                                        </div>
                                    </div>

			                                <div x-show="campaignSetupMode === 'advanced'" class="overflow-hidden rounded-lg border border-gray-200 bg-white">
			                                    <button type="button" x-on:click="channelsAdvancedOpen = ! channelsAdvancedOpen; scheduleCampaignBuilderLayoutUpdate()" class="flex w-full items-center justify-between gap-4 px-5 py-4 text-left transition hover:bg-gray-50">
	                                            <span>
	                                                <span class="block text-base/7 font-semibold text-gray-900">Advanced</span>
	                                                <span class="mt-1 block text-sm leading-6 text-gray-600">Settings for how links are formatted when they are sent as text in messages.</span>
	                                            </span>
	                                            <span class="outcraft-icon shrink-0 !text-[18px] text-gray-400 transition" :class="channelsAdvancedOpen ? 'rotate-180' : ''">keyboard_arrow_down</span>
	                                        </button>
				                                    <div x-show="channelsAdvancedOpen" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-3" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-2" class="border-t border-gray-200">
				                                        <div class="px-6 py-6">
			                                            <button type="button" data-shadow-control data-card-ignore x-on:click="campaignSetup.shortenLinks = ! campaignSetup.shortenLinks; scheduleCampaignBuilderLayoutUpdate()" role="switch" :aria-checked="campaignSetup.shortenLinks" class="flex w-full items-center justify-between gap-4 text-left shadow-none focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
		                                                <span class="min-w-0">
		                                                    <span class="block text-sm font-semibold leading-6 text-gray-950">Shorten Links in Messages</span>
		                                                    <span class="mt-1 block text-sm leading-6 text-gray-600">Shortens message links for cleaner tracking and delivery-friendly formatting. Links will resolve through ocrft.co/...</span>
	                                                </span>
	                                                <span class="relative inline-flex h-6 w-11 shrink-0 self-center rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out" :class="campaignSetup.shortenLinks ? 'bg-indigo-600' : 'bg-gray-200'">
	                                                    <span class="pointer-events-none inline-block size-5 rounded-full bg-white shadow transition duration-200 ease-in-out" :class="campaignSetup.shortenLinks ? 'translate-x-5' : 'translate-x-0'"></span>
	                                                </span>
		                                            </button>
		                                        </div>

				                                        <div class="border-t border-gray-200 px-6 py-6">
			                                            <div>
			                                                <h4 class="text-sm font-semibold leading-6 text-gray-950">Link Tracking Structure</h4>
		                                                <p class="mt-1 text-sm leading-6 text-gray-600">Configure abandoned cart link tracking.</p>
		                                            </div>
		                                            <div class="mt-5 space-y-5">
		                                                <label class="block">
		                                                    <span class="block text-sm/6 font-medium text-gray-900">Link Source</span>
		                                                    <x-outcraft.select
		                                                        class="mt-2"
		                                                        model="campaignSetup.cartLinkSource"
		                                                        :options="['Static (Manually set URL below)', 'Dynamic (Use URL from lead data)']"
		                                                    />
		                                                    <span class="mt-2 block text-sm leading-6 text-gray-500">Choose whether the base URL is manually entered or pulled from lead data.</span>
		                                                </label>
		                                                <label class="block">
		                                                    <span class="block text-sm/6 font-medium text-gray-900">Link Structure</span>
		                                                    <input x-model="campaignSetup.cartLinkStructure" type="text" :placeholder="campaignSetup.cartLinkSource === 'Static (Manually set URL below)' ? 'https://example.com/cart?utm_source=example&utm_medium=email' : '@{{cart_url}}?utm_source=example&utm_medium=email'" class="mt-2 block w-full rounded-md bg-white px-3 py-1.5 text-sm/6 text-gray-900 shadow-sm outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600">
		                                                    <span class="mt-2 block text-sm leading-6 text-gray-500" x-text="cartLinkStructureExample()"></span>
		                                                </label>
		                                            </div>
		                                        </div>
	                                    </div>
	                                </div>
	                                </div>
		                            </section>

	                            <section x-cloak x-show="campaignSetup.current === 'availability' || campaignSetupScrollFromStep === 'availability'" x-ref="campaignSetupStep_availability"
	                                :style="campaignSetupStepStyle('availability')"
	                                data-campaign-setup-step
	                                class="space-y-6 pr-2 pb-4">
	                                <div class="mb-1">
	                                    <p class="text-sm font-semibold text-indigo-600" x-text="`${campaignSetupMode === 'fast' ? 'Fast Setup' : 'Advanced Setup'} · Step ${campaignSetupStepIndex('availability') + 1} of ${campaignSetupStepsForMode().length}`"></p>
	                                    <span class="mb-4 flex size-10 items-center justify-center rounded-md bg-indigo-50 text-indigo-600">
	                                        <span class="outcraft-icon !text-[21px]" x-text="campaignSetupStepIcon('availability')"></span>
	                                    </span>
	                                    <h2 class="mt-2 text-2xl font-bold leading-8 tracking-tight text-gray-950" x-text="campaignSetupHeading('availability')"></h2>
	                                    <p class="mt-2 max-w-3xl text-sm leading-6 text-gray-600" x-text="campaignSetupDescription('availability')"></p>
	                                </div>

	                                <div class="rounded-lg border border-gray-200 bg-white p-6">
	                                    <label class="block max-w-xl">
	                                        <span class="block text-sm/6 font-semibold text-gray-900">Outreach Schedule</span>
	                                        <x-outcraft.select
	                                            class="mt-2"
	                                            model="campaignSetup.scheduleMode"
	                                            :options="[
	                                                ['value' => 'business', 'label' => 'Local Business Hours'],
	                                                ['value' => 'extended', 'label' => 'Local Extended Hours'],
	                                                ['value' => 'all-day', 'label' => 'Always On'],
	                                                ['value' => 'custom', 'label' => 'Custom Schedule'],
	                                            ]"
	                                            on-change="campaignSetup.allDay = campaignSetup.scheduleMode === 'all-day'; scheduleCampaignBuilderLayoutUpdate()"
	                                        />
	                                        <span class="mt-2 block text-sm leading-6 text-gray-600" x-text="campaignScheduleDescription()"></span>
	                                    </label>

	                                    <fieldset x-show="campaignSetup.scheduleMode === 'custom'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-3" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-2" class="mt-7">
	                                        <div class="flex items-center justify-between gap-4">
	                                            <h3 class="text-sm font-semibold leading-6 text-gray-950">Outreach Days</h3>
	                                            <button type="button" x-on:click="selectAllOutreachDays()" class="text-sm font-semibold text-indigo-600 hover:text-indigo-500">Select All</button>
	                                        </div>

	                                        <div class="mt-4 flex flex-col gap-3 sm:flex-row sm:flex-wrap sm:items-center sm:gap-x-6 sm:gap-y-3">
	                                            <template x-for="day in outreachWeekdays" :key="day">
	                                                <label class="inline-flex w-fit cursor-pointer items-center gap-3 rounded-md text-sm font-semibold leading-6 text-gray-900">
	                                                    <x-outcraft.checkbox
	                                                        mark-when="campaignSetup.outreachDays.includes(day)"
	                                                        x-bind:checked="campaignSetup.outreachDays.includes(day)"
	                                                        x-on:change="toggleOutreachDay(day)"
	                                                    />
	                                                    <span x-text="day"></span>
	                                                </label>
	                                            </template>
	                                        </div>

	                                        <div class="mt-7 grid gap-6 lg:grid-cols-2">
	                                            <label class="block">
	                                                <span class="block text-sm/6 font-semibold text-gray-900">Outreach Start Hour<span class="text-indigo-400">*</span></span>
	                                                <x-outcraft.select
	                                                    class="mt-2"
	                                                    model="campaignSetup.outreachStartHour"
	                                                    options="outreachHourOptions"
	                                                />
	                                                <span class="mt-2 block text-sm leading-6 text-gray-600">The earliest time AI can contact a lead in their local timezone.</span>
	                                            </label>

	                                            <label class="block">
	                                                <span class="block text-sm/6 font-semibold text-gray-900">Outreach End Hour<span class="text-indigo-400">*</span></span>
	                                                <x-outcraft.select
	                                                    class="mt-2"
	                                                    model="campaignSetup.outreachEndHour"
	                                                    options="outreachHourOptions"
	                                                />
	                                                <span class="mt-2 block text-sm leading-6 text-gray-600">The latest time AI can contact a lead in their local timezone.</span>
	                                            </label>
	                                        </div>
	                                    </fieldset>
	                                </div>
	                            </section>

	                            <section x-cloak x-show="campaignSetup.current === 'discounts' || campaignSetupScrollFromStep === 'discounts'" x-ref="campaignSetupStep_discounts"
	                                :style="campaignSetupStepStyle('discounts')"
	                                data-campaign-setup-step
                                class="space-y-6 pr-2 pb-4">
                                <div class="mb-1">
                                    <p class="text-sm font-semibold text-indigo-600" x-text="`${campaignSetupMode === 'fast' ? 'Fast Setup' : 'Advanced Setup'} · Step ${campaignSetupStepIndex('discounts') + 1} of ${campaignSetupStepsForMode().length}`"></p>
                                    <span class="mb-4 flex size-10 items-center justify-center rounded-md bg-indigo-50 text-indigo-600">
                                        <span class="outcraft-icon !text-[21px]" x-text="campaignSetupStepIcon('discounts')"></span>
                                    </span>
                                    <h2 class="mt-2 text-2xl font-bold leading-8 tracking-tight text-gray-950" x-text="campaignSetupHeading('discounts')"></h2>
                                    <p class="mt-2 max-w-3xl text-sm leading-6 text-gray-600" x-text="campaignSetupDescription('discounts')"></p>
                                </div>

                                <form x-on:submit.prevent="addDiscountCode()" class="flex flex-col gap-3 sm:flex-row sm:items-end">
                                    <label class="block min-w-0 flex-1">
                                        <span class="block text-sm/6 font-semibold text-gray-900">Add New Code</span>
                                        <input x-model="campaignSetup.newDiscountCode" type="text" placeholder="e.g. WELCOME10 or SUMMER20" class="mt-2 block w-full rounded-md bg-white px-3 py-1.5 text-sm/6 text-gray-900 shadow-sm outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600">
                                    </label>
                                    <button type="submit" :disabled="! campaignSetup.newDiscountCode.trim()" class="inline-flex h-9 items-center justify-center rounded-md bg-indigo-600 px-3 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-500 disabled:cursor-not-allowed disabled:opacity-40">Add</button>
                                </form>

                                <div class="bg-white">
                                    <div x-show="campaignSetup.discountCodes.length === 0" class="py-10 text-center">
                                        <p class="text-sm font-medium text-gray-900">No Discount Codes</p>
                                        <p class="mt-1 text-sm leading-6 text-gray-500">Add Codes the AI can include when discount content is enabled.</p>
                                    </div>
                                    <div x-show="campaignSetup.discountCodes.length > 0" class="divide-y divide-gray-200">
                                        <template x-for="code in campaignSetup.discountCodes" :key="code.value">
                                            <div class="flex items-center justify-between gap-4 py-3">
                                                <div class="min-w-0">
                                                    <p class="truncate text-sm font-semibold leading-6 text-gray-950" x-text="code.value"></p>
                                                    <p class="text-sm leading-6 text-gray-500" x-text="`Created ${code.created}`"></p>
                                                </div>
                                                <button type="button" x-on:click="campaignSetup.discountCodes = campaignSetup.discountCodes.filter((item) => item.value !== code.value)" class="inline-flex size-8 shrink-0 items-center justify-center rounded-md text-gray-400 transition hover:bg-gray-50 hover:text-red-600" aria-label="Remove Discount Code">
                                                    <span class="outcraft-icon !text-[18px]">delete</span>
                                                </button>
                                            </div>
                                        </template>
                                    </div>
                                </div>
                            </section>

                            <section x-cloak x-show="campaignSetup.current === 'booking' || campaignSetupScrollFromStep === 'booking'" x-ref="campaignSetupStep_booking"
                                :style="campaignSetupStepStyle('booking')"
                                data-campaign-setup-step
                                class="space-y-6 pr-2 pb-4">
                                <div class="mb-1">
                                    <p class="text-sm font-semibold text-indigo-600" x-text="`${campaignSetupMode === 'fast' ? 'Fast Setup' : 'Advanced Setup'} · Step ${campaignSetupStepIndex('booking') + 1} of ${campaignSetupStepsForMode().length}`"></p>
                                    <span class="mb-4 flex size-10 items-center justify-center rounded-md bg-indigo-50 text-indigo-600">
                                        <span class="outcraft-icon !text-[21px]" x-text="campaignSetupStepIcon('booking')"></span>
                                    </span>
                                    <h2 class="mt-2 text-2xl font-bold leading-8 tracking-tight text-gray-950" x-text="campaignSetupHeading('booking')"></h2>
                                    <p class="mt-2 max-w-3xl text-sm leading-6 text-gray-600" x-text="campaignSetupDescription('booking')"></p>
                                </div>

                                <div class="overflow-hidden rounded-lg border border-gray-200 bg-white">
                                    <div class="space-y-8 px-6 py-6">
                                        <label class="block">
                                            <span class="block text-sm/6 font-semibold text-gray-900">Which Calendar Service Do You Use?</span>
                                            <x-outcraft.select
                                                class="mt-2"
                                                model="campaignSetup.calendarService"
                                                :options="[
                                                    ['value' => '', 'label' => 'Select an Option'],
                                                    'HubSpot',
                                                    'Calendly',
                                                ]"
                                                on-change="campaignSetup.calendarConnectionStatus = ''; scheduleCampaignBuilderLayoutUpdate()"
                                            />
                                            <span class="mt-2 block text-sm leading-6 text-gray-600">Select the calendar service you use for booking appointments.</span>
                                        </label>

                                        <div x-show="campaignSetup.calendarService" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-3" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-2" class="rounded-lg border border-gray-200 bg-white p-6 shadow-sm">
                                            <div class="flex flex-col gap-4 sm:flex-row sm:items-start">
                                                <span class="flex size-[60px] shrink-0 items-center justify-center rounded-md" :class="calendarServiceLogoContainerClass(campaignSetup.calendarService)">
                                                    <span x-show="calendarServiceLogoHtml(campaignSetup.calendarService)" class="outcraft-source-logo outcraft-source-logo-lg" x-html="calendarServiceLogoHtml(campaignSetup.calendarService)"></span>
                                                    <span x-show="! calendarServiceLogoHtml(campaignSetup.calendarService)" class="outcraft-icon !text-[32px]" x-text="'calendar_month'"></span>
                                                </span>
                                                <div class="min-w-0 flex-1">
                                                    <h3 class="text-sm font-semibold leading-6 text-gray-950" x-text="campaignSetup.calendarService"></h3>
                                                    <p class="mt-2 text-sm leading-6 text-gray-600">Connect your calendar service to sync booking links, availability, and meeting events for this campaign.</p>
                                                    <div class="mt-5 flex flex-wrap items-center gap-3">
                                                        <button type="button" x-on:click="connectCalendarService()" class="inline-flex h-9 items-center rounded-md bg-indigo-600 px-3 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-500" x-text="`Connect ${campaignSetup.calendarService}`"></button>
                                                    </div>
                                                </div>
                                                <span x-show="campaignSetup.calendarConnectionStatus === 'Connected'" class="inline-flex w-fit shrink-0 rounded-md bg-green-50 px-2 py-1 text-xs font-medium text-green-700 ring-1 ring-inset ring-green-600/20 sm:ml-auto">Connected</span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="border-t border-gray-200 px-6 py-6">
                                        <h3 class="text-sm font-semibold text-gray-900">Links</h3>
                                        <div class="mt-6 space-y-6">
                                            <div class="rounded-md bg-blue-50 p-4 ring-1 ring-inset ring-blue-100">
                                                <div>
                                                    <p class="text-sm leading-6 text-blue-800">The Booking Link for Calls must use the default form settings. Do not add required fields, CAPTCHA, consent checkboxes, or any additional validation. Extra form requirements will prevent the AI agent from completing bookings during calls successfully!</p>
                                                </div>
                                            </div>

                                            <div class="space-y-6">
                                                <label class="block">
                                                    <span class="block text-sm/6 font-semibold text-gray-900">Booking Link for Calls<span class="text-indigo-400">*</span></span>
                                                    <input x-model="campaignSetup.bookingCallLink" type="url" placeholder="https://example.com/your-link" class="mt-2 block w-full rounded-md bg-white px-3 py-1.5 text-sm/6 text-gray-900 shadow-sm outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600">
                                                    <span class="mt-2 block text-sm leading-6 text-gray-600">Must contain service name of a calendar, https://example.com/your-link.</span>
                                                </label>

                                                <label class="block">
                                                    <span class="block text-sm/6 font-semibold text-gray-900">Booking Link for Email</span>
                                                    <input x-model="campaignSetup.bookingEmailLink" type="url" placeholder="https://example.com/your-link" class="mt-2 block w-full rounded-md bg-white px-3 py-1.5 text-sm/6 text-gray-900 shadow-sm outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600">
                                                    <span class="mt-2 block text-sm leading-6 text-gray-600">Can be any link to a calendar, example https://company.com/calendar or similar.</span>
                                                </label>

                                                <label class="block">
                                                    <span class="block text-sm/6 font-semibold text-gray-900">Booking Link for SMS</span>
                                                    <input x-model="campaignSetup.bookingSmsLink" type="url" placeholder="https://example.com/your-link" class="mt-2 block w-full rounded-md bg-white px-3 py-1.5 text-sm/6 text-gray-900 shadow-sm outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600">
                                                    <span class="mt-2 block text-sm leading-6 text-gray-600">Can be any link to a calendar, example https://company.com/calendar or similar.</span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>

	                            <section x-cloak x-show="campaignSetup.current === 'sequence' || campaignSetupScrollFromStep === 'sequence'" x-ref="campaignSetupStep_sequence"
                                :style="campaignSetupStepStyle('sequence')"
                                data-campaign-setup-step
                                class="space-y-6 pr-2 pb-4">
                                <div class="mb-1">
                                    <p class="text-sm font-semibold text-indigo-600" x-text="`${campaignSetupMode === 'fast' ? 'Fast Setup' : 'Advanced Setup'} · Step ${campaignSetupStepIndex('sequence') + 1} of ${campaignSetupStepsForMode().length}`"></p>
                                    <div data-step-icon-row>
                                        <span class="flex size-10 items-center justify-center rounded-md bg-indigo-50 text-indigo-600">
                                            <span class="outcraft-icon !text-[21px]" x-text="campaignSetupStepIcon('sequence')"></span>
                                        </span>
                                    </div>
                                    <h2 class="mt-2 text-2xl font-bold leading-8 tracking-tight text-gray-950" x-text="campaignSetupHeading('sequence')"></h2>
                                    <p class="mt-2 max-w-3xl text-sm leading-6 text-gray-600" x-text="campaignSetupDescription('sequence')"></p>
                                </div>
                                <div data-sequence-timeline class="relative !mt-0">
                                    <div class="relative !mt-0">
                                        <span class="pointer-events-none absolute left-[18px] top-[2.25rem] bottom-[-4.5rem] w-px bg-gray-200"></span>
                                        <div class="grid grid-cols-[2.25rem_minmax(0,1fr)] items-stretch gap-4">
                                            <span class="relative z-10 flex h-full min-h-9 items-center justify-center">
                                                <span class="flex size-9 shrink-0 items-center justify-center rounded-md bg-white text-gray-400 ring-1 ring-gray-200">
                                                    <span class="outcraft-icon !text-[19px]">flag</span>
                                                </span>
                                            </span>
                                            <article class="rounded-lg border border-gray-200 bg-white p-4 shadow-sm">
                                                <span class="text-sm font-semibold leading-6 text-gray-950">Outreach Starts</span>
                                                <p class="mt-2 text-sm leading-6 text-gray-600">The campaign begins for this lead and the AI starts following the sequence below.</p>
                                            </article>
                                        </div>
                                    </div>
                                    <template x-for="(row, index) in sequenceTimelineRows()" :key="row.id">
                                        <div class="relative mt-12">
                                            <span class="pointer-events-none absolute left-[18px] top-[18px] h-[6.25rem] w-px bg-gray-200"></span>
                                            <span class="pointer-events-none absolute left-[18px] top-[6.25rem] bottom-[-4.5rem] w-px bg-gray-200"></span>
                                            <div class="grid grid-cols-[2.25rem_minmax(0,1fr)] items-center gap-4">
                                                <span class="relative z-10 flex size-9 items-center justify-center rounded-md bg-white text-gray-400 ring-1 ring-gray-200">
                                                    <span class="outcraft-icon !text-[18px]">schedule</span>
                                                </span>
                                                <div class="inline-flex w-fit items-center gap-3 rounded-lg border border-gray-200 bg-white p-4 text-sm font-medium text-gray-900 shadow-sm">
                                                    <span class="text-sm font-medium text-gray-900" x-text="sequenceDelayLabel(row.delay)"></span>
                                                    <button type="button" x-on:click="openSequenceDelayModal(index)" class="-my-2 -mr-2 inline-flex size-8 shrink-0 items-center justify-center rounded-md text-gray-400 transition hover:bg-gray-50 hover:text-gray-700" aria-label="Edit Delay">
                                                        <span class="outcraft-icon !text-[18px]">settings-2</span>
                                                    </button>
                                                </div>
                                            </div>

                                            <div class="mt-10 grid grid-cols-[2.25rem_minmax(0,1fr)] items-stretch gap-4">
                                                <span class="relative z-10 flex h-full min-h-9 items-center justify-center">
                                                    <span class="flex size-9 shrink-0 items-center justify-center rounded-md ring-1" :class="sequenceChannelIconTileClass(row.channel)">
                                                        <span x-show="row.channel === 'WhatsApp'" class="size-[19px]" x-html="whatsappIconSvg()"></span>
                                                        <span x-show="row.channel !== 'WhatsApp'" class="outcraft-icon !text-[19px]" x-text="sequenceChannelIcon(row.channel)"></span>
                                                    </span>
                                                </span>
                                                <article class="rounded-lg border border-gray-200 bg-white p-4 shadow-sm">
                                                    <div class="flex items-start justify-between gap-4">
                                                        <div class="min-w-0">
                                                            <span class="text-sm font-semibold leading-6 text-gray-950" x-text="sequenceStepTitle(row)"></span>
                                                            <p class="mt-2 text-sm leading-6 text-gray-600" x-text="row.step"></p>
                                                        </div>
                                                        <div class="relative shrink-0" x-on:click.outside="campaignSetup.sequenceActionOpen === row.id && (campaignSetup.sequenceActionOpen = '')">
                                                            <button type="button" x-on:click="campaignSetup.sequenceActionOpen = campaignSetup.sequenceActionOpen === row.id ? '' : row.id" class="inline-flex size-8 items-center justify-center rounded-md text-gray-400 transition hover:bg-gray-50 hover:text-gray-700" aria-label="Open Sequence Step Actions">
                                                                <span class="outcraft-icon !text-[20px]">more_vert</span>
                                                            </button>
                                                            <div
                                                                x-cloak
                                                                x-show="campaignSetup.sequenceActionOpen === row.id"
                                                                x-transition:enter="transition ease-out duration-100"
                                                                x-transition:enter-start="opacity-0"
                                                                x-transition:enter-end="opacity-100"
                                                                x-transition:leave="transition ease-in duration-75"
                                                                x-transition:leave-start="opacity-100"
                                                                x-transition:leave-end="opacity-0"
                                                                class="absolute right-0 z-30 w-44 rounded-md bg-white py-1 shadow-lg ring-1 ring-gray-900/10"
                                                                :class="index === sequenceTimelineRows().length - 1 ? 'bottom-full mb-2' : 'top-full mt-2'"
                                                            >
                                                                <button type="button" x-on:click="moveSequenceRow(index, -1)" :disabled="index === 0" class="flex w-full items-center gap-2 rounded-md px-3 py-2 text-left text-sm font-medium text-gray-700 transition hover:bg-gray-50 hover:text-gray-950 disabled:cursor-not-allowed disabled:opacity-40">
                                                                    <span class="outcraft-icon !text-[17px]">arrow_upward</span>
                                                                    <span>Move Up</span>
                                                                </button>
                                                                <button type="button" x-on:click="moveSequenceRow(index, 1)" :disabled="index === sequenceTimelineRows().length - 1" class="flex w-full items-center gap-2 rounded-md px-3 py-2 text-left text-sm font-medium text-gray-700 transition hover:bg-gray-50 hover:text-gray-950 disabled:cursor-not-allowed disabled:opacity-40">
                                                                    <span class="outcraft-icon !text-[17px]">arrow_downward</span>
                                                                    <span>Move Down</span>
                                                                </button>
                                                                <button type="button" x-on:click="editSequenceRow(index)" class="flex w-full items-center gap-2 rounded-md px-3 py-2 text-left text-sm font-medium text-gray-700 transition hover:bg-gray-50 hover:text-gray-950">
                                                                    <span class="outcraft-icon !text-[17px]">edit</span>
                                                                    <span>Edit</span>
                                                                </button>
                                                                <button type="button" x-on:click="deleteSequenceRow(index)" class="flex w-full items-center gap-2 rounded-md px-3 py-2 text-left text-sm font-medium text-red-600 transition hover:bg-red-50 hover:text-red-700">
                                                                    <span class="outcraft-icon !text-[17px]">delete</span>
                                                                    <span>Delete</span>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </article>
                                            </div>
                                        </div>
                                    </template>
                                    <div class="relative mt-12">
                                        <span class="pointer-events-none absolute left-[18px] top-[-4.5rem] bottom-1/2 w-px bg-gray-200"></span>
                                        <div class="grid grid-cols-[2.25rem_minmax(0,1fr)] items-stretch gap-4">
                                            <span class="relative z-10 flex h-full min-h-9 items-center justify-center">
                                                <span class="flex size-9 shrink-0 items-center justify-center rounded-md bg-white text-gray-400 ring-1 ring-gray-200">
                                                    <span class="outcraft-icon !text-[19px]">check</span>
                                                </span>
                                            </span>
                                            <article class="rounded-lg border border-gray-200 bg-white p-4 shadow-sm">
                                                <span class="text-sm font-semibold leading-6 text-gray-950">Outreach Sequence Ends</span>
                                                <p class="mt-2 text-sm leading-6 text-gray-600">No more outreach actions run for this lead unless they qualify for a follow-up sequence.</p>
                                            </article>
                                        </div>
                                    </div>
                                    <div class="mt-6 flex justify-start">
                                        <button type="button" x-on:click="openSequenceStepModal()" class="inline-flex h-9 w-full items-center justify-center gap-2 rounded-md bg-white px-3 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 transition hover:bg-gray-50 sm:w-fit">
                                            <span class="outcraft-icon !text-[17px]">add</span>
                                            <span>Add Step</span>
                                        </button>
                                    </div>
                                </div>
                            </section>

                            <section x-cloak x-show="campaignSetup.current === 'followups' || campaignSetupScrollFromStep === 'followups'" x-ref="campaignSetupStep_followups"
                                :style="campaignSetupStepStyle('followups')"
                                data-campaign-setup-step
                                class="space-y-6 pr-2 pb-4">
                                <div class="mb-1">
                                    <p class="text-sm font-semibold text-indigo-600" x-text="`${campaignSetupMode === 'fast' ? 'Fast Setup' : 'Advanced Setup'} · Step ${campaignSetupStepIndex('followups') + 1} of ${campaignSetupStepsForMode().length}`"></p>
                                    <span class="mb-4 flex size-10 items-center justify-center rounded-md bg-indigo-50 text-indigo-600">
                                        <span class="outcraft-icon !text-[21px]" x-text="campaignSetupStepIcon('followups')"></span>
                                    </span>
                                    <h2 class="mt-2 text-2xl font-bold leading-8 tracking-tight text-gray-950" x-text="campaignSetupHeading('followups')"></h2>
                                    <p class="mt-2 max-w-3xl text-sm leading-6 text-gray-600" x-text="campaignSetupDescription('followups')"></p>
                                </div>
                                <div x-show="campaignSetup.followupLayoutOption === 'option1'" class="space-y-6">
                                    <div class="space-y-5">
                                            <button type="button" x-on:click="toggleFollowupSequence('followupPositive', 'positive')" role="switch" :aria-checked="campaignSetup.followupPositive" class="flex w-full items-center justify-between gap-4 rounded-md text-left focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                                                <span class="min-w-0">
                                                    <span class="block text-sm font-semibold leading-6 text-gray-950">After a Positive Response</span>
                                                    <span class="mt-1 block text-sm leading-6 text-gray-600">Follow up to confirm the next step, share details, or check if the lead needs anything else.</span>
                                                </span>
                                                <span class="relative inline-flex h-6 w-11 shrink-0 self-center rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out" :class="campaignSetup.followupPositive ? 'bg-indigo-600' : 'bg-gray-200'">
                                                    <span class="pointer-events-none inline-block size-5 rounded-full bg-white shadow transition duration-200 ease-in-out" :class="campaignSetup.followupPositive ? 'translate-x-5' : 'translate-x-0'"></span>
                                                </span>
                                            </button>

                                            <button type="button" x-on:click="toggleFollowupSequence('followupEngaged', 'engaged')" role="switch" :aria-checked="campaignSetup.followupEngaged" class="flex w-full items-center justify-between gap-4 rounded-md text-left focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                                                <span class="min-w-0">
                                                    <span class="block text-sm font-semibold leading-6 text-gray-950">When a Lead Is Engaged but Undecided</span>
                                                    <span class="mt-1 block text-sm leading-6 text-gray-600">Follow up to answer questions and help the lead move toward a clear yes or no.</span>
                                                </span>
                                                <span class="relative inline-flex h-6 w-11 shrink-0 self-center rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out" :class="campaignSetup.followupEngaged ? 'bg-indigo-600' : 'bg-gray-200'">
                                                    <span class="pointer-events-none inline-block size-5 rounded-full bg-white shadow transition duration-200 ease-in-out" :class="campaignSetup.followupEngaged ? 'translate-x-5' : 'translate-x-0'"></span>
                                                </span>
                                            </button>

                                            <button type="button" x-on:click="toggleFollowupSequence('followupNegative', 'negative')" role="switch" :aria-checked="campaignSetup.followupNegative" class="flex w-full items-center justify-between gap-4 rounded-md text-left focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                                                <span class="min-w-0">
                                                    <span class="block text-sm font-semibold leading-6 text-gray-950">After a Negative Response</span>
                                                    <span class="mt-1 block text-sm leading-6 text-gray-600">Follow up with helpful objection handling before closing the loop.</span>
                                                </span>
                                                <span class="relative inline-flex h-6 w-11 shrink-0 self-center rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out" :class="campaignSetup.followupNegative ? 'bg-indigo-600' : 'bg-gray-200'">
                                                    <span class="pointer-events-none inline-block size-5 rounded-full bg-white shadow transition duration-200 ease-in-out" :class="campaignSetup.followupNegative ? 'translate-x-5' : 'translate-x-0'"></span>
                                                </span>
                                            </button>
                                        </div>
                                    <div x-show="campaignSetup.followupPositive || campaignSetup.followupEngaged || campaignSetup.followupNegative" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-3" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-2" class="overflow-hidden rounded-lg border border-gray-200 bg-white">
                                        <div class="border-b border-gray-200 px-6 py-5">
                                            <h3 class="text-base font-semibold text-gray-950">Follow-Up Sequence</h3>
                                            <p class="mt-2 text-sm leading-6 text-gray-600">Build a follow-up sequence that will be applied for this campaign</p>
                                        </div>
                                        <div class="border-b border-gray-200 px-6">
                                            <nav class="-mb-px flex flex-wrap gap-6" aria-label="Follow-up sequence tabs">
                                                <button type="button" x-show="campaignSetup.followupPositive" x-on:click="campaignSetup.activeFollowupTab = 'positive'" class="border-b-2 px-1 py-3 text-sm font-semibold transition" :class="campaignSetup.activeFollowupTab === 'positive' ? 'border-indigo-600 text-indigo-600' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700'">Positive Response</button>
                                                <button type="button" x-show="campaignSetup.followupEngaged" x-on:click="campaignSetup.activeFollowupTab = 'engaged'" class="border-b-2 px-1 py-3 text-sm font-semibold transition" :class="campaignSetup.activeFollowupTab === 'engaged' ? 'border-indigo-600 text-indigo-600' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700'">Engaged But Undecided</button>
                                                <button type="button" x-show="campaignSetup.followupNegative" x-on:click="campaignSetup.activeFollowupTab = 'negative'" class="border-b-2 px-1 py-3 text-sm font-semibold transition" :class="campaignSetup.activeFollowupTab === 'negative' ? 'border-indigo-600 text-indigo-600' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700'">Negative Response</button>
                                            </nav>
                                        </div>
                                        <div class="flex flex-wrap items-center justify-between gap-3 px-6 py-5">
                                            <button type="button" class="inline-flex h-9 w-fit shrink-0 self-start items-center rounded-md bg-white px-3 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 transition hover:bg-gray-50">Reorder Actions</button>
                                            <button type="button" x-on:click="campaignSetup.followupModalOpen = true" class="inline-flex h-9 w-fit shrink-0 self-start items-center gap-2 rounded-md bg-white px-3 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 transition hover:bg-gray-50"><span class="outcraft-icon !text-[17px]">add</span><span>Add Step</span></button>
                                        </div>
                                        <div class="border-t border-gray-200">
                                            <table class="min-w-full text-left text-sm">
                                                <thead>
                                                    <tr>
                                                        <template x-for="head in ['Channel','Label','Relative Delay','Exact Flow Step']" :key="head">
                                                            <th class="border-b border-gray-200 px-6 py-3 font-semibold text-gray-600" x-text="head"></th>
                                                        </template>
                                                    </tr>
                                                </thead>
                                            </table>
                                            <div class="flex min-h-56 flex-col items-center justify-center px-6 py-10 text-center">
                                                <span class="flex size-12 items-center justify-center rounded-full bg-gray-100 text-gray-400">
                                                    <span class="outcraft-icon !text-[24px]">close</span>
                                                </span>
                                                <h4 class="mt-5 text-base font-bold text-gray-950">No Flow Template Steps</h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div x-show="campaignSetup.followupLayoutOption === 'option2'" class="space-y-6">
                                    <div class="overflow-hidden rounded-lg border border-gray-200 bg-white shadow-sm">
                                        <div class="border-b border-gray-200 px-6">
                                            <nav aria-label="Follow-up sequence tabs" class="-mb-px flex flex-wrap gap-x-8 gap-y-2">
                                                <template x-for="tab in followupSequenceAllTabs()" :key="`followup-option2-${tab.id}`">
                                                    <button
                                                        type="button"
                                                        x-on:click="campaignSetup.activeFollowupSequence = tab.id; scheduleCampaignBuilderLayoutUpdate()"
                                                        class="group inline-flex items-center border-b-2 px-1 py-4 text-sm font-medium transition"
                                                        :class="campaignSetup.activeFollowupSequence === tab.id ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700'"
                                                    >
                                                        <span x-text="tab.label"></span>
                                                    </button>
                                                </template>
                                            </nav>
                                        </div>

                                        <button type="button" x-on:click="toggleActiveFollowupSequence()" role="switch" :aria-checked="followupSequenceEnabled()" class="flex w-full items-center justify-between gap-4 px-6 py-5 text-left focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                                            <span class="min-w-0">
                                                <span class="block text-sm font-semibold leading-6 text-gray-950" x-text="followupSequenceContent().title"></span>
                                                <span class="mt-1 block text-sm leading-6 text-gray-600" x-text="followupSequenceContent().description"></span>
                                            </span>
                                            <span class="relative inline-flex h-6 w-11 shrink-0 self-center rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out" :class="followupSequenceEnabled() ? 'bg-indigo-600' : 'bg-gray-200'">
                                                <span class="pointer-events-none inline-block size-5 rounded-full bg-white shadow transition duration-200 ease-in-out" :class="followupSequenceEnabled() ? 'translate-x-5' : 'translate-x-0'"></span>
                                            </span>
                                        </button>
                                    </div>

                                    <div
                                        x-show="followupSequenceEnabled()"
                                        x-transition:enter="transition ease-out duration-200"
                                        x-transition:enter-start="opacity-0 translate-y-3"
                                        x-transition:enter-end="opacity-100 translate-y-0"
                                        x-transition:leave="transition ease-in duration-150"
                                        x-transition:leave-start="opacity-100 translate-y-0"
                                        x-transition:leave-end="opacity-0 translate-y-2"
                                        class="space-y-6"
                                    >
                                        <div class="relative">
                                            <div class="relative !mt-0">
                                                <span class="pointer-events-none absolute left-[18px] top-[2.25rem] bottom-[-4.5rem] w-px bg-gray-200"></span>
                                                <div class="grid grid-cols-[2.25rem_minmax(0,1fr)] items-stretch gap-4">
                                                    <span class="relative z-10 flex h-full min-h-9 items-center justify-center">
                                                        <span class="flex size-9 shrink-0 items-center justify-center rounded-md bg-white text-gray-400 ring-1 ring-gray-200">
                                                            <span class="outcraft-icon !text-[19px]">flag</span>
                                                        </span>
                                                    </span>
                                                    <article class="rounded-lg border border-gray-200 bg-white p-4 shadow-sm">
                                                        <span class="text-sm font-semibold leading-6 text-gray-950">Follow-Up Sequence Starts</span>
                                                        <p class="mt-2 text-sm leading-6 text-gray-600" x-text="`This sequence starts after the lead matches the ${followupSequenceAllTabs().find((tab) => tab.id === campaignSetup.activeFollowupSequence)?.label || 'selected'} response path.`"></p>
                                                    </article>
                                                </div>
                                            </div>
                                            <template x-for="(row, index) in followupTimelineVisibleRows(campaignSetup.activeFollowupSequence)" :key="row.id">
                                                <div class="relative mt-12">
                                                    <span class="pointer-events-none absolute left-[18px] top-[18px] h-[6.25rem] w-px bg-gray-200"></span>
                                                    <span class="pointer-events-none absolute left-[18px] top-[6.25rem] bottom-[-4.5rem] w-px bg-gray-200"></span>
                                                    <div class="grid grid-cols-[2.25rem_minmax(0,1fr)] items-center gap-4">
                                                        <span class="relative z-10 flex size-9 items-center justify-center rounded-md bg-white text-gray-400 ring-1 ring-gray-200">
                                                            <span class="outcraft-icon !text-[18px]">schedule</span>
                                                        </span>
                                                        <div class="inline-flex w-fit items-center gap-3 rounded-lg border border-gray-200 bg-white p-4 text-sm font-medium text-gray-900 shadow-sm">
                                                            <span class="text-sm font-medium text-gray-900" x-text="sequenceDelayLabel(row.delay)"></span>
                                                            <button type="button" x-on:click="openFollowupDelayModal(campaignSetup.activeFollowupSequence, index)" class="-my-2 -mr-2 inline-flex size-8 shrink-0 items-center justify-center rounded-md text-gray-400 transition hover:bg-gray-50 hover:text-gray-700" aria-label="Edit Delay">
                                                                <span class="outcraft-icon !text-[18px]">settings-2</span>
                                                            </button>
                                                        </div>
                                                    </div>

                                                    <div class="mt-10 grid grid-cols-[2.25rem_minmax(0,1fr)] items-stretch gap-4">
                                                        <span class="relative z-10 flex h-full min-h-9 items-center justify-center">
                                                            <span class="flex size-9 shrink-0 items-center justify-center rounded-md ring-1" :class="sequenceChannelIconTileClass(row.channel)">
                                                                <span x-show="row.channel === 'WhatsApp'" class="size-[19px]" x-html="whatsappIconSvg()"></span>
                                                                <span x-show="row.channel !== 'WhatsApp'" class="outcraft-icon !text-[19px]" x-text="sequenceChannelIcon(row.channel)"></span>
                                                            </span>
                                                        </span>
                                                        <article class="rounded-lg border border-gray-200 bg-white p-4 shadow-sm">
                                                            <div class="flex items-start justify-between gap-4">
                                                                <div class="min-w-0">
                                                                    <span class="text-sm font-semibold leading-6 text-gray-950" x-text="followupStepTitle(row)"></span>
                                                                    <p class="mt-2 text-sm leading-6 text-gray-600" x-text="row.step"></p>
                                                                </div>
                                                                <div class="relative shrink-0" x-on:click.outside="campaignSetup.followupActionOpen === row.id && (campaignSetup.followupActionOpen = '')">
                                                                    <button type="button" x-on:click="campaignSetup.followupActionOpen = campaignSetup.followupActionOpen === row.id ? '' : row.id" class="inline-flex size-8 items-center justify-center rounded-md text-gray-400 transition hover:bg-gray-50 hover:text-gray-700" aria-label="Open Follow-Up Step Actions">
                                                                        <span class="outcraft-icon !text-[20px]">more_vert</span>
                                                                    </button>
                                                                    <div
                                                                        x-cloak
                                                                        x-show="campaignSetup.followupActionOpen === row.id"
                                                                        x-transition:enter="transition ease-out duration-100"
                                                                        x-transition:enter-start="opacity-0"
                                                                        x-transition:enter-end="opacity-100"
                                                                        x-transition:leave="transition ease-in duration-75"
                                                                        x-transition:leave-start="opacity-100"
                                                                        x-transition:leave-end="opacity-0"
                                                                        class="absolute right-0 z-30 w-44 rounded-md bg-white py-1 shadow-lg ring-1 ring-gray-900/10"
                                                                        :class="index === followupTimelineVisibleRows(campaignSetup.activeFollowupSequence).length - 1 ? 'bottom-full mb-2' : 'top-full mt-2'"
                                                                    >
                                                                        <button type="button" x-on:click="moveFollowupRow(campaignSetup.activeFollowupSequence, index, -1)" :disabled="index === 0" class="flex w-full items-center gap-2 rounded-md px-3 py-2 text-left text-sm font-medium text-gray-700 transition hover:bg-gray-50 hover:text-gray-950 disabled:cursor-not-allowed disabled:opacity-40">
                                                                            <span class="outcraft-icon !text-[17px]">arrow_upward</span>
                                                                            <span>Move Up</span>
                                                                        </button>
                                                                        <button type="button" x-on:click="moveFollowupRow(campaignSetup.activeFollowupSequence, index, 1)" :disabled="index === followupTimelineVisibleRows(campaignSetup.activeFollowupSequence).length - 1" class="flex w-full items-center gap-2 rounded-md px-3 py-2 text-left text-sm font-medium text-gray-700 transition hover:bg-gray-50 hover:text-gray-950 disabled:cursor-not-allowed disabled:opacity-40">
                                                                            <span class="outcraft-icon !text-[17px]">arrow_downward</span>
                                                                            <span>Move Down</span>
                                                                        </button>
                                                                        <button type="button" x-on:click="editFollowupRow(campaignSetup.activeFollowupSequence, index)" class="flex w-full items-center gap-2 rounded-md px-3 py-2 text-left text-sm font-medium text-gray-700 transition hover:bg-gray-50 hover:text-gray-950">
                                                                            <span class="outcraft-icon !text-[17px]">edit</span>
                                                                            <span>Edit</span>
                                                                        </button>
                                                                        <button type="button" x-on:click="deleteFollowupRow(campaignSetup.activeFollowupSequence, index)" class="flex w-full items-center gap-2 rounded-md px-3 py-2 text-left text-sm font-medium text-red-600 transition hover:bg-red-50 hover:text-red-700">
                                                                            <span class="outcraft-icon !text-[17px]">delete</span>
                                                                            <span>Delete</span>
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </article>
                                                    </div>
                                                </div>
                                            </template>
                                            <div class="relative mt-12">
                                                <span class="pointer-events-none absolute left-[18px] top-[-4.5rem] bottom-1/2 w-px bg-gray-200"></span>
                                                <div class="grid grid-cols-[2.25rem_minmax(0,1fr)] items-stretch gap-4">
                                                    <span class="relative z-10 flex h-full min-h-9 items-center justify-center">
                                                        <span class="flex size-9 shrink-0 items-center justify-center rounded-md bg-white text-gray-400 ring-1 ring-gray-200">
                                                            <span class="outcraft-icon !text-[19px]">check</span>
                                                        </span>
                                                    </span>
                                                    <article class="rounded-lg border border-gray-200 bg-white p-4 shadow-sm">
                                                        <span class="text-sm font-semibold leading-6 text-gray-950">Follow-Up Sequence Ends</span>
                                                        <p class="mt-2 text-sm leading-6 text-gray-600">The agent stops this follow-up path unless the lead qualifies for another campaign action.</p>
                                                    </article>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="flex justify-start">
                                            <button type="button" x-on:click="openFollowupStepModal(campaignSetup.activeFollowupSequence)" class="inline-flex h-9 w-full items-center justify-center gap-2 rounded-md bg-white px-3 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 transition hover:bg-gray-50 sm:w-fit"><span class="outcraft-icon !text-[17px]">add</span><span>Add Step</span></button>
                                        </div>
                                    </div>
                                </div>
                            </section>

                            <section x-cloak x-show="campaignSetup.current === 'handoff' || campaignSetupScrollFromStep === 'handoff'" x-ref="campaignSetupStep_handoff"
                                :style="campaignSetupStepStyle('handoff')"
                                data-campaign-setup-step
                                class="space-y-6 pr-2 pb-4">
                                <div class="mb-1">
                                    <p class="text-sm font-semibold text-indigo-600" x-text="`${campaignSetupMode === 'fast' ? 'Fast Setup' : 'Advanced Setup'} · Step ${campaignSetupStepIndex('handoff') + 1} of ${campaignSetupStepsForMode().length}`"></p>
                                    <span class="mb-4 flex size-10 items-center justify-center rounded-md bg-indigo-50 text-indigo-600">
                                        <span class="outcraft-icon !text-[21px]" x-text="campaignSetupStepIcon('handoff')"></span>
                                    </span>
                                    <h2 class="mt-2 text-2xl font-bold leading-8 tracking-tight text-gray-950" x-text="campaignSetupHeading('handoff')"></h2>
                                    <p class="mt-2 max-w-3xl text-sm leading-6 text-gray-600" x-text="campaignSetupDescription('handoff')"></p>
                                </div>
                                <div class="overflow-hidden rounded-lg border border-gray-200 bg-white">
                                    <div class="divide-y divide-gray-200">
                                        <div class="px-6 py-6">
                                            <button type="button" x-on:click="campaignSetup.handoffPositive = ! campaignSetup.handoffPositive; scheduleCampaignBuilderLayoutUpdate()" role="switch" :aria-checked="campaignSetup.handoffPositive" class="flex w-full items-start gap-4 rounded-md text-left focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                                                <span class="relative mt-1 inline-flex h-6 w-11 shrink-0 rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out" :class="campaignSetup.handoffPositive ? 'bg-indigo-600' : 'bg-gray-200'">
                                                    <span class="pointer-events-none inline-block size-5 rounded-full bg-white shadow transition duration-200 ease-in-out" :class="campaignSetup.handoffPositive ? 'translate-x-5' : 'translate-x-0'"></span>
                                                </span>
                                                <span class="min-w-0">
                                                    <span class="block text-sm font-semibold leading-6 text-gray-950">Hand Off After a Positive Reply</span>
                                                    <span class="mt-1 block text-sm leading-6 text-gray-600">AI passes the conversation to a human when the lead responds positively.</span>
                                                </span>
                                            </button>

                                            <div x-show="campaignSetup.handoffPositive" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-3" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-2" class="mt-6">
                                                <label class="block">
                                                    <span class="block text-sm/6 font-medium text-gray-900">Handoff Trigger Scenarios</span>
                                                    <x-outcraft.select
                                                        class="mt-2"
                                                        model="campaignSetup.handoffScenario"
                                                        :options="[
                                                            ['value' => '', 'label' => 'Type Your Own or Select Common Scenario'],
                                                            'Positive Reply',
                                                            'Pricing Request',
                                                            'Legal or Compliance Question',
                                                            'Lead Asks for Human Help',
                                                        ]"
                                                    />
                                                    <span class="mt-2 block text-sm leading-6 text-gray-500">Situations where AI should pass to a human agent.</span>
                                                </label>
                                            </div>
                                        </div>

                                        <div class="px-6 py-6">
                                            <button type="button" x-on:click="campaignSetup.handoffRequested = ! campaignSetup.handoffRequested; scheduleCampaignBuilderLayoutUpdate()" role="switch" :aria-checked="campaignSetup.handoffRequested" class="flex w-full items-start gap-4 rounded-md text-left focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                                                <span class="relative mt-1 inline-flex h-6 w-11 shrink-0 rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out" :class="campaignSetup.handoffRequested ? 'bg-indigo-600' : 'bg-gray-200'">
                                                    <span class="pointer-events-none inline-block size-5 rounded-full bg-white shadow transition duration-200 ease-in-out" :class="campaignSetup.handoffRequested ? 'translate-x-5' : 'translate-x-0'"></span>
                                                </span>
                                                <span class="min-w-0">
                                                    <span class="block text-sm font-semibold leading-6 text-gray-950">Hand Off When the Lead Asks</span>
                                                    <span class="mt-1 block text-sm leading-6 text-gray-600">AI passes the conversation when the lead explicitly requests a human.</span>
                                                </span>
                                            </button>

                                            <div x-show="campaignSetup.handoffRequested" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-3" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-2" class="mt-6">
                                                <label class="block">
                                                    <span class="block text-sm/6 font-medium text-gray-900">Handoff Channel</span>
                                                    <x-outcraft.select
                                                        class="mt-2"
                                                        model="campaignSetup.handoffChannel"
                                                        :options="[
                                                            ['value' => '', 'label' => 'Select a Channel'],
                                                            'Email',
                                                            'Slack',
                                                            'CRM Task',
                                                            'Webhook',
                                                            'Internal Dashboard',
                                                        ]"
                                                    />
                                                    <span class="mt-2 block text-sm leading-6 text-gray-500">How the human agent is notified.</span>
                                                </label>
                                            </div>
                                        </div>

                                        <div class="px-6 py-6">
                                            <label class="block">
                                                <span class="block text-sm/6 font-semibold text-gray-900">Handoff Notification Email</span>
                                                    <input x-model="campaignSetup.handoffNotificationEmail" type="email" placeholder="support@example.com" class="mt-2 block w-full rounded-md bg-white px-3 py-1.5 text-sm/6 text-gray-900 shadow-sm outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600">
                                                <span class="mt-2 block text-sm leading-6 text-gray-600">Where to send a notification when the AI hands off a conversation to a human.</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </section>

                            <section x-cloak x-show="campaignSetup.current === 'intelligence' || campaignSetupScrollFromStep === 'intelligence'" x-ref="campaignSetupStep_intelligence"
                                :style="campaignSetupStepStyle('intelligence')"
                                data-campaign-setup-step
                                class="space-y-6 pr-2 pb-4">
                                <div class="mb-1">
                                    <p class="text-sm font-semibold text-indigo-600" x-text="`${campaignSetupMode === 'fast' ? 'Fast Setup' : 'Advanced Setup'} · Step ${campaignSetupStepIndex('intelligence') + 1} of ${campaignSetupStepsForMode().length}`"></p>
                                    <div data-step-icon-row>
                                        <span class="flex size-10 items-center justify-center rounded-md bg-indigo-50 text-indigo-600">
                                            <span class="outcraft-icon !text-[21px]" x-text="campaignSetupStepIcon('intelligence')"></span>
                                        </span>
                                    </div>
                                    <h2 class="mt-2 text-2xl font-bold leading-8 tracking-tight text-gray-950" x-text="campaignSetupHeading('intelligence')"></h2>
                                    <p class="mt-2 max-w-3xl text-sm leading-6 text-gray-600" x-text="campaignSetupDescription('intelligence')"></p>
                                </div>
                                <div>
                                    <div class="overflow-hidden rounded-lg border border-gray-200 bg-white">
                                        <table class="min-w-full divide-y divide-gray-200 text-left text-sm">
                                            <thead class="bg-gray-50">
                                                <tr>
                                                    <th class="px-4 py-3 font-semibold text-gray-600">Evaluation</th>
                                                    <th class="px-4 py-3 font-semibold text-gray-600">Response Format</th>
                                                    <th class="px-4 py-3"><span class="sr-only">Actions</span></th>
                                                </tr>
                                            </thead>
                                            <tbody class="divide-y divide-gray-200">
                                                <template x-for="evaluation in conversationIntelligenceEvaluations()" :key="evaluation.id">
                                                    <tr>
                                                        <td class="px-4 py-3">
                                                            <div class="flex flex-wrap items-center gap-2">
                                                                <p class="font-semibold text-gray-950" x-text="evaluation.name"></p>
                                                                <span x-show="evaluation.review" class="inline-flex rounded-md bg-amber-50 px-2 py-1 text-xs font-medium text-amber-700 ring-1 ring-inset ring-amber-600/20">Review</span>
                                                            </div>
                                                            <p class="mt-1 text-gray-500" x-text="evaluation.description"></p>
                                                        </td>
                                                        <td class="px-4 py-3 text-gray-700" x-text="evaluation.format"></td>
                                                        <td class="px-4 py-3 text-right">
                                                            <div class="relative inline-flex" x-on:click.outside="campaignSetup.evaluationActionOpen === evaluation.id && (campaignSetup.evaluationActionOpen = '')">
                                                                <button type="button" x-on:click="campaignSetup.evaluationActionOpen = campaignSetup.evaluationActionOpen === evaluation.id ? '' : evaluation.id" class="inline-flex size-8 items-center justify-center rounded-md text-gray-400 transition hover:bg-gray-50 hover:text-gray-700" aria-label="Open Evaluation Actions">
                                                                    <span class="outcraft-icon !text-[20px]">more_vert</span>
                                                                </button>
                                                                <div x-cloak x-show="campaignSetup.evaluationActionOpen === evaluation.id" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="opacity-0 translate-y-1" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-1" class="absolute right-0 top-full z-30 mt-2 w-36 rounded-md bg-white py-1 text-left shadow-lg ring-1 ring-gray-900/10">
                                                                    <button type="button" x-on:click="editConversationEvaluation(evaluation)" class="flex w-full items-center gap-2 rounded-md px-3 py-2 text-sm font-medium text-gray-700 transition hover:bg-gray-50 hover:text-gray-950">
                                                                        <span class="outcraft-icon !text-[17px]">edit</span>
                                                                        <span>Edit</span>
                                                                    </button>
                                                                    <button type="button" x-on:click="removeConversationEvaluation(evaluation)" class="flex w-full items-center gap-2 rounded-md px-3 py-2 text-sm font-medium text-red-600 transition hover:bg-red-50 hover:text-red-700">
                                                                        <span class="outcraft-icon !text-[17px]">delete</span>
                                                                        <span>Remove</span>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </template>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="mt-6 flex justify-start">
                                        <button type="button" x-on:click="campaignSetup.evaluationDrawerOpen = true" class="inline-flex h-9 w-full items-center justify-center gap-2 rounded-md bg-white px-3 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 transition hover:bg-gray-50 sm:w-fit">
                                            <span class="outcraft-icon !text-[17px]">add</span>
                                            <span>Add Evaluation</span>
                                        </button>
                                    </div>
                                </div>
                            </section>

                            <section x-cloak x-show="campaignSetup.current === 'geo' || campaignSetupScrollFromStep === 'geo'" x-ref="campaignSetupStep_geo"
                                :style="campaignSetupStepStyle('geo')"
                                data-campaign-setup-step
                                class="space-y-5 pr-2 pb-4">
                                <div class="mb-1">
                                    <p class="text-sm font-semibold text-indigo-600" x-text="`${campaignSetupMode === 'fast' ? 'Fast Setup' : 'Advanced Setup'} · Step ${campaignSetupStepIndex('geo') + 1} of ${campaignSetupStepsForMode().length}`"></p>
                                    <span class="mb-4 flex size-10 items-center justify-center rounded-md bg-indigo-50 text-indigo-600">
                                        <span class="outcraft-icon !text-[21px]" x-text="campaignSetupStepIcon('geo')"></span>
                                    </span>
                                    <h2 class="mt-2 text-2xl font-bold leading-8 tracking-tight text-gray-950" x-text="campaignSetupHeading('geo')"></h2>
                                    <p class="mt-2 max-w-3xl text-sm leading-6 text-gray-600" x-text="campaignSetupDescription('geo')"></p>
                                </div>
                                <div class="flex flex-wrap gap-3"><input type="search" placeholder="Search Countries" class="h-9 rounded-md px-3 text-sm outline outline-1 -outline-offset-1 outline-gray-300"><template x-for="filter in ['All','Enabled','Disabled']" :key="filter"><button class="rounded-md bg-white px-3 text-sm font-semibold ring-1 ring-inset ring-gray-300" x-text="filter"></button></template></div>
                                <div class="flex flex-wrap gap-2"><template x-for="action in ['Select All','Disable All','Enable EU Only','Enable North America Only']" :key="action"><button class="rounded-md bg-white px-3 py-2 text-sm font-semibold ring-1 ring-inset ring-gray-300" x-text="action"></button></template></div>
                                <div class="overflow-hidden rounded-lg border border-gray-200"><table class="min-w-full divide-y divide-gray-200 text-left text-sm"><thead class="bg-gray-50"><tr><template x-for="head in ['Country','Code','Prefix','Region','Calls','SMS','Email']" :key="head"><th class="px-4 py-3 font-semibold text-gray-600" x-text="head"></th></template></tr></thead><tbody class="divide-y divide-gray-100"><template x-for="country in geoCountries" :key="country.code"><tr><td class="px-4 py-3" x-text="country.name"></td><td class="px-4 py-3" x-text="country.code"></td><td class="px-4 py-3" x-text="country.prefix"></td><td class="px-4 py-3" x-text="country.region"></td><td class="px-4 py-3" x-html="miniSwitch(true)"></td><td class="px-4 py-3" x-html="miniSwitch(true)"></td><td class="px-4 py-3" x-html="miniSwitch(true)"></td></tr></template></tbody></table></div>
                            </section>

                            <section x-cloak x-show="campaignSetup.current === 'dispatch' || campaignSetupScrollFromStep === 'dispatch'" x-ref="campaignSetupStep_dispatch"
                                :style="campaignSetupStepStyle('dispatch')"
                                data-campaign-setup-step
                                class="space-y-6 pr-2 pb-4">
                                <div class="mb-1">
                                    <p class="text-sm font-semibold text-indigo-600" x-text="`${campaignSetupMode === 'fast' ? 'Fast Setup' : 'Advanced Setup'} · Step ${campaignSetupStepIndex('dispatch') + 1} of ${campaignSetupStepsForMode().length}`"></p>
                                    <span class="mb-4 flex size-10 items-center justify-center rounded-md bg-indigo-50 text-indigo-600">
                                        <span class="outcraft-icon !text-[21px]" x-text="campaignSetupStepIcon('dispatch')"></span>
                                    </span>
                                    <h2 class="mt-2 text-2xl font-bold leading-8 tracking-tight text-gray-950" x-text="campaignSetupHeading('dispatch')"></h2>
                                    <p class="mt-2 max-w-3xl text-sm leading-6 text-gray-600" x-text="campaignSetupDescription('dispatch')"></p>
                                </div>
                                <div class="rounded-lg border border-dashed border-gray-300 bg-gray-50 p-10 text-center">
                                <h3 class="text-sm font-bold text-gray-950">No Campaign Dispatch Conditions</h3>
                                <p class="mt-2 text-sm text-gray-500">Create a campaign dispatch condition set to control which leads qualify for this campaign.</p>
                                <button type="button" x-on:click="campaignSetup.dispatchDrawerOpen = true" class="mt-5 inline-flex h-9 items-center rounded-md bg-indigo-600 px-3 text-sm font-semibold text-white">Add Condition Set</button>
                            </div>
                            </section>

	                            <section x-cloak x-show="campaignSetup.current === 'priority' || campaignSetupScrollFromStep === 'priority'" x-ref="campaignSetupStep_priority"
	                                :style="campaignSetupStepStyle('priority')"
	                                data-campaign-setup-step
	                                class="space-y-6 pr-2 pb-4">
                                <div class="mb-1">
                                    <p class="text-sm font-semibold text-indigo-600" x-text="`${campaignSetupMode === 'fast' ? 'Fast Setup' : 'Advanced Setup'} · Step ${campaignSetupStepIndex('priority') + 1} of ${campaignSetupStepsForMode().length}`"></p>
                                    <span class="mb-4 flex size-10 items-center justify-center rounded-md bg-indigo-50 text-indigo-600">
                                        <span class="outcraft-icon !text-[21px]" x-text="campaignSetupStepIcon('priority')"></span>
                                    </span>
                                    <h2 class="mt-2 text-2xl font-bold leading-8 tracking-tight text-gray-950" x-text="campaignSetupHeading('priority')"></h2>
                                    <p class="mt-2 max-w-3xl text-sm leading-6 text-gray-600" x-text="campaignSetupDescription('priority')"></p>
                                </div>
                                <div class="rounded-lg border border-dashed border-gray-300 bg-gray-50 p-10 text-center">
                                <h3 class="text-sm font-bold text-gray-950">No Campaign Overrides</h3>
                                <p class="mt-2 text-sm text-gray-500">Create a campaign override to decide which campaign should run when multiple campaigns qualify.</p>
                                <button type="button" x-on:click="campaignSetup.overrideModalOpen = true" class="mt-5 inline-flex h-9 items-center rounded-md bg-indigo-600 px-3 text-sm font-semibold text-white">Add Override Rule</button>
	                            </div>
	                            </section>

	                            <section x-cloak x-show="campaignSetup.current === 'events' || campaignSetupScrollFromStep === 'events'" x-ref="campaignSetupStep_events"
	                                :style="campaignSetupStepStyle('events')"
	                                data-campaign-setup-step
	                                class="space-y-6 pr-2 pb-4">
	                                <div class="mb-1">
	                                    <p class="text-sm font-semibold text-indigo-600" x-text="`${campaignSetupMode === 'fast' ? 'Fast Setup' : 'Advanced Setup'} · Step ${campaignSetupStepIndex('events') + 1} of ${campaignSetupStepsForMode().length}`"></p>
	                                    <span class="mb-4 flex size-10 items-center justify-center rounded-md bg-indigo-50 text-indigo-600">
	                                        <span class="outcraft-icon !text-[21px]" x-text="campaignSetupStepIcon('events')"></span>
	                                    </span>
	                                    <h2 class="mt-2 text-2xl font-bold leading-8 tracking-tight text-gray-950" x-text="campaignSetupHeading('events')"></h2>
	                                    <p class="mt-2 max-w-3xl text-sm leading-6 text-gray-600" x-text="campaignSetupDescription('events')"></p>
	                                </div>
	                                <div data-card-surface class="rounded-lg bg-white p-6 shadow-sm outline outline-1 -outline-offset-1 outline-gray-300">
		                                <div class="flex items-start justify-between gap-4">
		                                    <div class="flex min-w-0 items-start gap-4">
		                                        <span class="flex size-[60px] shrink-0 items-center justify-center rounded-md" :class="leadSourceLogoContainerClass(campaignSetup.source)">
		                                            <span x-show="leadSourceLogos[campaignSetup.source]" class="outcraft-source-logo outcraft-source-logo-lg" x-html="leadSourceLogos[campaignSetup.source]"></span>
		                                            <span x-show="! leadSourceLogos[campaignSetup.source]" class="outcraft-icon !text-[32px]" x-text="leadSourceIcon(campaignSetup.source)"></span>
		                                        </span>
		                                        <div class="min-w-0">
		                                            <p class="text-xs font-semibold uppercase tracking-wide text-gray-400">Selected Lead Source</p>
		                                            <h3 class="text-sm font-bold text-gray-950" x-text="campaignSetup.source || 'Lead Source'"></h3>
		                                            <p class="mt-2 text-sm leading-6 text-gray-600">Connect your source to use real customer data, merge tags, and event triggers. You can skip this step, but AI will have less context to personalize conversations.</p>
		                                        </div>
		                                    </div>
		                                    <span class="inline-flex shrink-0 rounded-md bg-green-50 px-2 py-1 text-xs font-medium text-green-700 ring-1 ring-inset ring-green-600/20">Connected</span>
		                                </div>

		                                <button
		                                    x-show="campaignSetup.source === 'Klaviyo'"
		                                    type="button"
		                                    x-on:click="openKlaviyoEventsGuide()"
		                                    class="mt-6 flex w-full items-center justify-between gap-4 rounded-lg bg-white p-5 text-left shadow-sm outline outline-1 -outline-offset-1 outline-gray-300 transition hover:outline-2 hover:-outline-offset-2 hover:outline-indigo-600 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
		                                >
		                                    <span class="min-w-0">
		                                        <span class="block text-sm font-bold text-gray-950">How to connect Klaviyo events</span>
		                                        <span class="mt-1 block text-sm leading-6 text-gray-500">Create Checkout Started and Order Placed flows with webhook actions.</span>
		                                    </span>
		                                    <span class="outcraft-icon shrink-0 !text-[20px] text-gray-400">arrow_forward</span>
		                                </button>

	                                    <div x-cloak x-show="campaignSetup.leadSourceEventsConfigured" x-transition.opacity class="mt-6 overflow-x-auto rounded-lg border border-gray-200">
	                                        <table class="min-w-full divide-y divide-gray-200 text-left text-sm">
	                                            <thead class="bg-gray-50">
	                                                <tr>
	                                                    <th class="px-6 py-4 font-semibold text-gray-950">Event</th>
	                                                    <th class="px-6 py-4 font-semibold text-gray-950">Dispatches</th>
	                                                    <th class="px-6 py-4 font-semibold text-gray-950">Is Enabled</th>
	                                                    <th class="px-6 py-4"><span class="sr-only">Actions</span></th>
	                                                </tr>
	                                            </thead>
	                                            <tbody class="divide-y divide-gray-100 bg-white">
	                                                <template x-for="event in campaignSetup.leadSourceEvents" :key="event.id">
	                                                    <tr>
		                                                    <td class="px-6 py-5 text-sm font-semibold text-gray-950" x-text="event.label"></td>
	                                                        <td class="px-6 py-5 text-sm leading-6 text-gray-900" x-text="leadSourceEventDispatchSummary(event)"></td>
	                                                        <td class="px-6 py-5">
	                                                            <button type="button" x-on:click="toggleLeadSourceEvent(event.id)" role="switch" :aria-checked="event.enabled" class="relative inline-flex h-6 w-11 shrink-0 self-center rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600" :class="event.enabled ? 'bg-indigo-600' : 'bg-gray-200'">
	                                                                <span class="pointer-events-none inline-block size-5 rounded-full bg-white shadow transition duration-200 ease-in-out" :class="event.enabled ? 'translate-x-5' : 'translate-x-0'"></span>
	                                                            </button>
	                                                        </td>
	                                                        <td class="px-6 py-5 text-right">
		                                                        <button type="button" x-on:click="openLeadSourceEventSettings(event)" class="inline-flex h-9 items-center rounded-md bg-white px-3 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 transition hover:bg-gray-50">
		                                                            Edit
		                                                        </button>
	                                                        </td>
	                                                    </tr>
	                                                </template>
	                                            </tbody>
	                                        </table>
	                                    </div>
	                                </div>
	                            </section>

	                            <section x-cloak x-show="campaignSetup.current === 'review' || campaignSetupScrollFromStep === 'review'" x-ref="campaignSetupStep_review"
	                                :style="campaignSetupStepStyle('review')"
	                                data-campaign-setup-step
                                class="grid grid-cols-1 gap-x-8 gap-y-10 pr-2 pb-4 md:grid-cols-3">
                                <div class="flex flex-col">
                                    <span class="order-1 mb-4 flex size-10 items-center justify-center rounded-md bg-indigo-50 text-indigo-600">
                                        <span class="outcraft-icon !text-[21px]" x-text="campaignSetupStepIcon('review')"></span>
                                    </span>
                                    <h2 class="order-2 text-2xl font-bold leading-8 tracking-tight text-gray-950" x-text="campaignSetupHeading('review')"></h2>
                                    <p class="order-3 mt-2 text-sm leading-6 text-gray-600" x-text="campaignSetupDescription('review')"></p>
                                </div>
                                <div data-card-surface class="rounded-lg border border-gray-200 bg-white p-5 shadow-sm md:col-span-2 sm:p-6">
                                    <div class="max-w-xl space-y-5">
                                    <label class="block">
                                        <span class="block text-sm/6 font-semibold text-gray-900">Campaign Name</span>
                                        <input x-model="campaignSetup.name" type="text" placeholder="Generated automatically if left empty" class="mt-2 block w-full rounded-md bg-white px-3 py-1.5 text-sm/6 text-gray-900 shadow-sm outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600">
                                        <span class="mt-2 block text-sm leading-6 text-gray-500">Add a name now, or leave it empty and AI will assign one.</span>
                                    </label>
                                    <div class="flex flex-wrap gap-3">
                                        <button type="button" class="inline-flex h-9 items-center gap-2 rounded-md bg-white px-3 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 transition hover:bg-gray-50">
                                            <span class="outcraft-icon !text-[16px] text-gray-500">phone_in_talk</span>
                                            Test Call
                                        </button>
                                        <button type="button" x-on:click="publishCampaignSetup()" :disabled="launchBlocked()" class="inline-flex h-9 items-center rounded-md bg-indigo-600 px-3 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-500 disabled:cursor-not-allowed disabled:opacity-40">Launch Campaign</button>
                                    </div>
                                    </div>
                                </div>
                            </section>
                            </div>
                        </div>
                        <div x-cloak x-show="campaignSetupModeSelected && ! campaignSetupIntroStep" class="hidden lg:block"></div>

		                        <div x-cloak x-show="campaignSetupModeSelected && ! campaignSetupIntroStep && campaignSetup.current !== 'review'" class="fixed inset-x-0 bottom-0 z-40 flex border-t border-gray-200 bg-white px-4 py-3 lg:px-0 lg:py-4" :style="campaignSetupActionBarStyle">
	                            <div class="flex w-full items-center justify-between gap-3" :style="campaignSetupActionBarContentStyle">
	                                <button type="button" x-on:click="previousCampaignSetupStep()" :disabled="campaignSetupStepIndex() === 0" class="inline-flex h-9 shrink-0 items-center gap-2 rounded-md px-2 text-sm font-semibold text-gray-600 transition hover:bg-gray-50 hover:text-gray-950 disabled:cursor-not-allowed disabled:opacity-40">
	                                    <span class="outcraft-icon !text-[18px]">arrow_upward</span>
	                                    Previous step
	                                </button>
	                                <div class="flex min-w-0 items-center gap-2 sm:gap-3">
                                        <span x-show="campaignSetupNextLabel()" class="hidden text-sm font-medium text-gray-500 sm:inline" x-text="`Next: ${campaignSetupNextLabel()}`"></span>
	                                    <button type="button" x-on:click="nextCampaignSetupStep()" :disabled="campaignSetupStepIndex() >= campaignSetupStepsForMode().length - 1 && launchBlocked()" class="inline-flex h-9 min-w-0 items-center gap-2 rounded-md bg-indigo-600 px-3 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-500 disabled:cursor-not-allowed disabled:opacity-40">
	                                        <span class="hidden truncate sm:inline" x-text="campaignSetupContinueLabel()"></span>
	                                        <span class="truncate sm:hidden" x-text="campaignSetupMobileContinueLabel()"></span>
	                                        <span class="outcraft-icon !text-[18px]" x-text="campaignSetupContinueIcon()"></span>
	                                    </button>
	                                </div>
	                            </div>
	                        </div>

                        <div
                            x-cloak
                            x-show="campaignCancelConfirmOpen"
                            x-transition.opacity
                            x-on:keydown.escape.window="closeCampaignCancelConfirm()"
                            class="fixed inset-0 z-50 flex items-center justify-center bg-gray-950/30 p-4"
                        >
                            <div x-on:click="closeCampaignCancelConfirm()" class="absolute inset-0"></div>
                            <div
                                x-show="campaignCancelConfirmOpen"
                                x-transition:enter="transition ease-out duration-150"
                                x-transition:enter-start="opacity-0 translate-y-3 scale-95"
                                x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                                x-transition:leave="transition ease-in duration-100"
                                x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                                x-transition:leave-end="opacity-0 translate-y-2 scale-95"
                                class="relative w-full max-w-md overflow-hidden rounded-lg bg-white shadow-xl ring-1 ring-gray-900/10"
                                role="dialog"
                                aria-modal="true"
                                aria-labelledby="campaign-cancel-confirm-title"
                            >
                                <div class="px-6 py-5">
                                    <div class="flex items-start justify-between gap-4">
                                        <div class="flex items-start gap-3">
                                            <span class="flex size-10 shrink-0 items-center justify-center rounded-md bg-amber-50 text-amber-600">
                                                <span class="outcraft-icon !text-[20px]">report</span>
                                            </span>
                                            <div>
                                                <h2 id="campaign-cancel-confirm-title" class="text-base font-semibold text-gray-950">Cancel Campaign Setup?</h2>
                                                <p class="mt-1 text-sm leading-6 text-gray-500">Save this campaign as a draft or discard the setup and return to Campaigns.</p>
                                            </div>
                                        </div>
                                        <button type="button" x-on:click="closeCampaignCancelConfirm()" class="inline-flex size-8 shrink-0 items-center justify-center rounded-md text-gray-400 transition hover:bg-gray-50 hover:text-gray-700" aria-label="Close">
                                            <span class="outcraft-icon !text-[20px]">close</span>
                                        </button>
                                    </div>
                                </div>
                                <div class="flex flex-col-reverse gap-3 border-t border-gray-100 bg-white px-6 py-4 sm:flex-row sm:justify-end">
                                    <button type="button" x-on:click="cancelCampaignSetupWithoutDraft()" class="inline-flex h-9 items-center justify-center rounded-md bg-white px-3 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 transition hover:bg-gray-50">
                                        Cancel Setup
                                    </button>
                                    <button type="button" x-on:click="saveCampaignSetupDraft()" class="inline-flex h-9 items-center justify-center rounded-md bg-indigo-600 px-3 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                                        Save as Draft
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div
                            x-cloak
                            x-show="campaignSetup.languageBatchModalOpen"
                            x-transition.opacity
                            x-on:keydown.escape.window="closeCampaignSetupOverlays()"
                            class="fixed inset-0 z-50 flex items-center justify-center bg-gray-950/30 p-4"
                        >
                            <div x-on:click="closeCampaignSetupOverlays()" class="absolute inset-0"></div>
                            <div
                                x-show="campaignSetup.languageBatchModalOpen"
                                x-transition:enter="transition ease-out duration-150"
                                x-transition:enter-start="opacity-0 translate-y-3 scale-95"
                                x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                                x-transition:leave="transition ease-in duration-100"
                                x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                                x-transition:leave-end="opacity-0 translate-y-2 scale-95"
                                class="relative flex max-h-[min(680px,calc(100vh-2rem))] w-full max-w-xl flex-col overflow-hidden rounded-lg bg-white shadow-xl ring-1 ring-gray-900/10"
                                role="dialog"
                                aria-modal="true"
                                aria-labelledby="add-ai-agent-languages-title"
                            >
                                <div class="border-b border-gray-200 px-6 py-5">
                                    <div class="flex items-start justify-between gap-4">
                                        <div>
                                            <h2 id="add-ai-agent-languages-title" class="text-base font-semibold text-gray-950">Add Languages</h2>
                                            <p class="mt-1 text-sm leading-6 text-gray-500">Select one or more languages to configure additional AI agents for this campaign.</p>
                                        </div>
                                        <button type="button" x-on:click="closeCampaignSetupOverlays()" class="inline-flex size-8 items-center justify-center rounded-md text-gray-400 transition hover:bg-gray-50 hover:text-gray-700" aria-label="Close">
                                            <span class="outcraft-icon !text-[20px]">close</span>
                                        </button>
                                    </div>
                                    <label class="mt-4 block">
                                        <span class="sr-only">Search Languages</span>
                                        <input x-ref="campaignLanguageSearch" x-model="campaignSetup.languageSearch" type="search" placeholder="Search Languages" class="block h-9 w-full rounded-md bg-white px-3 py-1.5 text-sm text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600">
                                    </label>
                                </div>
                                <div class="min-h-0 flex-1 overflow-y-auto px-6 py-4">
                                    <div class="space-y-2">
                                        <template x-for="language in filteredCampaignSetupLanguageOptions()" :key="language.code">
                                            <label class="flex w-full cursor-pointer items-center gap-3 rounded-lg border border-gray-200 bg-white p-4 text-left transition hover:bg-gray-50 focus-within:outline focus-within:outline-2 focus-within:outline-offset-2 focus-within:outline-indigo-600" :class="campaignSetupLanguageSelectedForBatch(language.code) ? 'border-indigo-600 ring-2 ring-indigo-100' : ''">
                                                <x-outcraft.checkbox
                                                    mark-when="campaignSetupLanguageSelectedForBatch(language.code)"
                                                    x-bind:checked="campaignSetupLanguageSelectedForBatch(language.code)"
                                                    x-on:change="toggleCampaignSetupLanguageSelection(language.code)"
                                                />
                                                <span class="inline-flex size-6 shrink-0 overflow-hidden rounded-full ring-1 ring-gray-200">
                                                    <img :src="campaignSetupFlagUrl(language)" :alt="`${campaignSetupLanguageDisplay(language)} flag`" class="size-full object-cover" loading="lazy">
                                                </span>
                                                <span class="min-w-0 flex-1">
                                                    <span class="block truncate text-sm font-semibold text-gray-950" x-text="campaignSetupLanguageDisplay(language)"></span>
                                                </span>
                                            </label>
                                        </template>
                                        <p x-show="filteredCampaignSetupLanguageOptions().length === 0" class="px-1 py-6 text-center text-sm text-gray-500">No Languages Found.</p>
                                    </div>
                                </div>
                                <div class="flex justify-end gap-3 border-t border-gray-200 px-6 py-4">
                                    <button type="button" x-on:click="closeCampaignSetupOverlays()" class="inline-flex h-9 items-center rounded-md bg-white px-3 text-sm font-semibold text-gray-900 ring-1 ring-inset ring-gray-300">Cancel</button>
                                    <button type="button" x-on:click="addSelectedCampaignSetupLanguages()" :disabled="campaignSetup.languageBatchSelection.length === 0" class="inline-flex h-9 items-center rounded-md bg-indigo-600 px-3 text-sm font-semibold text-white transition hover:bg-indigo-500 disabled:cursor-not-allowed disabled:opacity-40" x-text="campaignSetup.languageBatchSelection.length > 0 ? `Add ${campaignSetup.languageBatchSelection.length}` : 'Add'"></button>
                                </div>
                            </div>
                        </div>

                        <div x-cloak x-show="campaignSetup.sequenceModalOpen || campaignSetup.followupModalOpen || campaignSetup.delayModalOpen || campaignSetup.mailboxModalOpen || campaignSetup.phoneNumberModalOpen || campaignSetup.physicalAddressModalOpen || campaignSetup.discountCodeModalOpen || campaignSetup.overrideModalOpen" class="fixed inset-0 z-50 flex items-center justify-center bg-gray-950/30 p-4">
                            <div class="flex max-h-[min(760px,calc(100vh-2rem))] w-full flex-col overflow-visible rounded-lg bg-white shadow-2xl" :class="[campaignSetup.physicalAddressModalOpen ? 'max-w-2xl' : 'max-w-xl', campaignSetup.delayModalOpen ? 'min-h-[28rem]' : '']">
                                <div class="border-b border-gray-200 px-6 py-5">
                                    <div class="flex items-start justify-between gap-4">
                                        <div class="min-w-0">
                                            <h2 class="text-base font-semibold text-gray-950" x-text="campaignSetup.phoneNumberModalOpen ? 'Assign phone number' : (campaignSetup.physicalAddressModalOpen ? (campaignSetup.physicalAddressFormOpen ? 'Add address' : 'Physical Addresses') : (campaignSetup.mailboxModalOpen ? 'Add Mailbox' : (campaignSetup.delayModalOpen ? delayModalTitle() : (campaignSetup.followupModalOpen ? 'Select Follow-Up Sequence Step' : (campaignSetup.sequenceModalOpen ? 'Select Outreach Sequence Step' : (campaignSetup.overrideModalOpen ? 'Create Campaign Override' : (campaignSetup.discountCodeModalOpen ? 'Add Discount Code' : 'Create Flow Template Step')))))))"></h2>
                                            <p x-show="campaignSetup.sequenceModalOpen || campaignSetup.followupModalOpen || campaignSetup.delayModalOpen || campaignSetup.mailboxModalOpen || campaignSetup.phoneNumberModalOpen || (campaignSetup.physicalAddressModalOpen && ! campaignSetup.physicalAddressFormOpen)" class="mt-1 text-sm leading-6 text-gray-500" x-text="campaignSetup.phoneNumberModalOpen ? 'Choose the provider and region for the phone number used by call outreach in this campaign.' : (campaignSetup.physicalAddressModalOpen ? 'Manage business addresses used for phone number registration.' : (campaignSetup.mailboxModalOpen ? 'Choose the mailbox type and follow the connection instructions.' : (campaignSetup.delayModalOpen ? delayModalDescription() : (campaignSetup.followupModalOpen ? 'Choose the follow-up action the AI should run after this lead response.' : 'Choose the outreach action the AI should run at this point in the sequence.'))))"></p>
                                        </div>
                                        <button type="button" x-on:click="closeCampaignSetupOverlays()" class="inline-flex size-8 shrink-0 items-center justify-center rounded-md text-gray-400 transition hover:bg-gray-50 hover:text-gray-700" aria-label="Close">
                                            <span class="outcraft-icon !text-[20px]">close</span>
                                        </button>
                                    </div>
                                </div>
                                <div class="min-h-0 flex-1 overflow-y-auto px-6 py-5">
                                    <div class="space-y-4">
                                    <template x-if="campaignSetup.sequenceModalOpen"><div class="space-y-6"><template x-for="group in sequenceStepTypeGroups()" :key="group.group"><section><h3 class="text-xs font-semibold uppercase tracking-wide text-gray-400" x-text="group.group"></h3><div class="mt-2 space-y-2"><template x-for="option in group.options" :key="option.type"><button type="button" x-on:click="selectSequenceStepType(option.type)" class="flex w-full items-start gap-3 rounded-lg border border-gray-200 bg-white p-4 text-left transition hover:bg-gray-50 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600" :class="campaignSetup.sequenceForm.type === option.type ? 'border-indigo-600 ring-2 ring-indigo-100' : ''"><span class="min-w-0 flex-1"><span class="flex items-center gap-2"><span class="text-sm font-semibold text-gray-950" x-text="option.type"></span><span x-show="campaignSetup.sequenceForm.type === option.type" class="inline-flex rounded-md bg-gray-50 px-2 py-0.5 text-xs font-medium text-gray-600 ring-1 ring-inset ring-gray-500/10">Selected</span></span><span class="mt-1 block text-sm leading-6 text-gray-500" x-text="option.step"></span></span></button></template></div></section></template></div></template>
                                    <template x-if="campaignSetup.followupModalOpen"><div class="space-y-6"><template x-for="group in sequenceStepTypeGroups()" :key="`followup-${group.group}`"><section><h3 class="text-xs font-semibold uppercase tracking-wide text-gray-400" x-text="group.group"></h3><div class="mt-2 space-y-2"><template x-for="option in group.options" :key="`followup-${option.type}`"><button type="button" x-on:click="selectFollowupStepType(option.type)" class="flex w-full items-start gap-3 rounded-lg border border-gray-200 bg-white p-4 text-left transition hover:bg-gray-50 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600" :class="campaignSetup.followupForm.type === option.type ? 'border-indigo-600 ring-2 ring-indigo-100' : ''"><span class="min-w-0 flex-1"><span class="flex items-center gap-2"><span class="text-sm font-semibold text-gray-950" x-text="option.type"></span><span x-show="campaignSetup.followupForm.type === option.type" class="inline-flex rounded-md bg-gray-50 px-2 py-0.5 text-xs font-medium text-gray-600 ring-1 ring-inset ring-gray-500/10">Selected</span></span><span class="mt-1 block text-sm leading-6 text-gray-500" x-text="option.step"></span></span></button></template></div></section></template></div></template>
                                    <template x-if="campaignSetup.mailboxModalOpen"><div class="space-y-6"><label class="block"><span class="text-sm font-medium text-gray-900">Mailbox Type</span><x-outcraft.select class="mt-2" model="campaignSetup.mailboxProvider" :options="['Microsoft 365 or Outlook', 'Google Workspace', 'Any Email via IMAP', 'Yandex Mail']" /></label><div class="rounded-lg border border-gray-200 bg-white p-5"><h3 class="text-sm font-semibold text-gray-950" x-text="campaignSetup.mailboxProvider === 'Google Workspace' ? 'How To Connect Google Workspace' : (campaignSetup.mailboxProvider === 'Yandex Mail' ? 'How To Connect Yandex Mail' : (campaignSetup.mailboxProvider === 'Any Email via IMAP' ? 'Connect Any Email via IMAP' : 'Connect Microsoft 365 or Outlook'))"></h3><div class="mt-3 space-y-2 text-sm leading-6 text-gray-600"><template x-if="campaignSetup.mailboxProvider === 'Microsoft 365 or Outlook'"><p>Click Connect and sign in with your Microsoft account to authorize mailbox access.</p></template><template x-if="campaignSetup.mailboxProvider === 'Google Workspace'"><ol class="list-decimal space-y-2 pl-5"><li>Ask your Google Workspace Administrator to open App Access Control.</li><li>Click <span class="font-semibold text-gray-900">Configure new app</span>.</li><li>Search for Example App and approve it.</li><li>Choose data access type: <span class="font-semibold text-gray-900">Trusted</span>.</li></ol></template><template x-if="campaignSetup.mailboxProvider === 'Yandex Mail'"><ol class="list-decimal space-y-2 pl-5"><li>Enable IMAP in Yandex Mail settings.</li><li>Create an app password in Yandex Security Settings.</li><li>Use IMAP server <span class="font-semibold text-gray-900">imap.yandex.com</span> and SMTP server <span class="font-semibold text-gray-900">smtp.yandex.com</span>.</li></ol></template><template x-if="campaignSetup.mailboxProvider === 'Any Email via IMAP'"><p>Enter the mailbox email. The next step will ask for IMAP and SMTP server settings.</p></template></div><label class="mt-5 block"><span class="text-sm font-medium text-gray-900">Email Address</span><input x-model="campaignSetup.mailboxEmail" type="email" placeholder="jessica@example.com" class="mt-2 block w-full rounded-md bg-white px-3 py-1.5 text-sm/6 text-gray-900 shadow-sm outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600"></label></div></div></template>
                                    <template x-if="campaignSetup.phoneNumberModalOpen"><div class="space-y-6"><label class="block"><span class="text-sm font-medium text-gray-900">Provider</span><x-outcraft.select class="mt-2" model="campaignSetup.phoneNumberForm.provider" :options="['Twilio']" /></label><label class="block"><span class="text-sm font-medium text-gray-900">Country</span><x-outcraft.select class="mt-2" model="campaignSetup.phoneNumberForm.country" :options="['United States', 'Canada', 'United Kingdom', 'Netherlands', 'Germany']" /></label><label class="block"><span class="text-sm font-medium text-gray-900">State</span><x-outcraft.select class="mt-2" model="campaignSetup.phoneNumberForm.state" :options="['Select an option', 'California', 'Florida', 'New York', 'Texas', 'Washington']" /></label></div></template>
                                    <template x-if="campaignSetup.physicalAddressModalOpen"><div>
                                        <div x-show="! campaignSetup.physicalAddressFormOpen" class="space-y-4">
                                            <template x-for="address in campaignSetup.physicalAddresses" :key="address.id">
                                                <div class="rounded-lg border border-gray-200 bg-white p-4">
                                                    <div class="flex items-start justify-between gap-4">
                                                        <div class="min-w-0 flex-1 divide-y divide-gray-100">
                                                            <div class="space-y-2 pb-3">
                                                                <p class="truncate text-sm font-semibold text-gray-950" x-text="address.provider"></p>
                                                                <p class="truncate text-sm font-semibold text-gray-950" x-text="address.companyName"></p>
                                                            </div>
                                                            <div class="grid gap-x-6 gap-y-3 py-3 sm:grid-cols-2">
                                                                <p class="truncate text-sm text-gray-700" x-text="[address.representativeFirstName, address.representativeLastName].filter(Boolean).join(' ') || 'Not set'"></p>
                                                                <p class="truncate text-sm text-gray-700" x-text="address.businessPhone || 'Not set'"></p>
                                                            </div>
                                                            <div class="grid gap-x-6 gap-y-3 pt-3 sm:grid-cols-2">
                                                                <p class="truncate text-sm text-gray-700" x-text="address.companyLocation"></p>
                                                                <p class="truncate text-sm text-gray-700" x-text="[address.addressLine1, address.addressLine2, address.city, address.state, address.zipCode].filter(Boolean).join(', ') || 'Not set'"></p>
                                                            </div>
                                                        </div>
                                                        <button type="button" x-on:click="removePhysicalAddress(address.id)" class="inline-flex size-8 shrink-0 items-center justify-center rounded-md text-gray-400 transition hover:bg-gray-50 hover:text-red-600" aria-label="Remove Physical Address">
                                                            <span class="outcraft-icon !text-[17px]">delete</span>
                                                        </button>
                                                    </div>
                                                </div>
                                            </template>
                                            <div x-show="campaignSetup.physicalAddresses.length === 0" class="rounded-lg border border-gray-200 bg-white px-4 py-10">
                                                <div class="flex flex-col items-center justify-center text-center">
                                                    <span class="flex size-10 items-center justify-center rounded-full bg-gray-50 text-gray-400 ring-1 ring-inset ring-gray-200"><svg class="size-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M20 10c0 4.993-5.539 10.193-7.399 11.799a1 1 0 0 1-1.202 0C9.539 20.193 4 14.993 4 10a8 8 0 0 1 16 0"></path><circle cx="12" cy="10" r="3"></circle></svg></span>
                                                    <p class="mt-3 text-sm font-semibold text-gray-950">No physical addresses</p>
                                                    <p class="mt-1 text-sm text-gray-500">Add an address before registering phone numbers.</p>
                                                </div>
                                            </div>
                                            <button type="button" x-on:click="campaignSetup.physicalAddressFormOpen = true" class="inline-flex h-9 w-full items-center justify-center gap-2 rounded-md bg-white px-3 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 transition hover:bg-gray-50 sm:w-fit">
                                                <span class="outcraft-icon !text-[17px]">add</span>
                                                <span>Add Physical Address</span>
                                            </button>
                                        </div>

                                        <div x-show="campaignSetup.physicalAddressFormOpen" class="space-y-5">
                                            <label class="block">
                                                <span class="text-sm font-medium text-gray-900">Provider</span>
                                                <x-outcraft.select class="mt-2" model="campaignSetup.physicalAddressForm.provider" :options="['Twilio']" />
                                            </label>

                                            <div class="max-w-sm">
                                                <label class="block">
                                                    <span class="text-sm font-medium text-gray-900">Company Location<span class="text-indigo-400">*</span></span>
                                                    <x-outcraft.select class="mt-2" model="campaignSetup.physicalAddressForm.businessLocation" :options="['United States', 'Canada', 'United Kingdom', 'Netherlands', 'Germany']" />
                                                </label>
                                                <p class="mt-2 text-sm leading-6 text-gray-500">Country where your business is registered</p>
                                            </div>

                                            <div class="grid gap-5 sm:grid-cols-2">
                                                <label class="block">
                                                    <span class="text-sm font-medium text-gray-900">Representative Name<span class="text-indigo-400">*</span></span>
                                                    <input x-model="campaignSetup.physicalAddressForm.representativeFirstName" type="text" class="mt-2 block h-9 w-full rounded-md border-0 bg-white px-3 text-sm/6 text-gray-900 shadow-sm outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600">
                                                </label>
                                                <label class="block">
                                                    <span class="text-sm font-medium text-gray-900">Representative Surname<span class="text-indigo-400">*</span></span>
                                                    <input x-model="campaignSetup.physicalAddressForm.representativeLastName" type="text" class="mt-2 block h-9 w-full rounded-md border-0 bg-white px-3 text-sm/6 text-gray-900 shadow-sm outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600">
                                                </label>
                                            </div>

                                            <label class="block">
                                                <span class="text-sm font-medium text-gray-900">Business Phone<span class="text-indigo-400">*</span></span>
                                                <input x-model="campaignSetup.physicalAddressForm.businessPhone" type="tel" class="mt-2 block h-9 w-full rounded-md border-0 bg-white px-3 text-sm/6 text-gray-900 shadow-sm outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600">
                                            </label>

                                            <label class="block max-w-sm">
                                                <span class="text-sm font-medium text-gray-900">Company Name<span class="text-indigo-400">*</span></span>
                                                <input x-model="campaignSetup.physicalAddressForm.businessName" type="text" class="mt-2 block h-9 w-full rounded-md border-0 bg-white px-3 text-sm/6 text-gray-900 shadow-sm outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600">
                                            </label>

                                            <div class="grid gap-5 sm:grid-cols-2">
                                                <label class="block">
                                                    <span class="text-sm font-medium text-gray-900">Address line 1<span class="text-indigo-400">*</span></span>
                                                    <input x-model="campaignSetup.physicalAddressForm.addressLine1" type="text" class="mt-2 block h-9 w-full rounded-md border-0 bg-white px-3 text-sm/6 text-gray-900 shadow-sm outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600">
                                                </label>
                                                <label class="block">
                                                    <span class="text-sm font-medium text-gray-900">Address line 2</span>
                                                    <input x-model="campaignSetup.physicalAddressForm.addressLine2" type="text" placeholder="Optional" class="mt-2 block h-9 w-full rounded-md border-0 bg-white px-3 text-sm/6 text-gray-900 shadow-sm outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600">
                                                </label>
                                            </div>

                                            <div class="grid gap-5 sm:grid-cols-3">
                                                <label class="block">
                                                    <span class="text-sm font-medium text-gray-900">City<span class="text-indigo-400">*</span></span>
                                                    <input x-model="campaignSetup.physicalAddressForm.city" type="text" class="mt-2 block h-9 w-full rounded-md border-0 bg-white px-3 text-sm/6 text-gray-900 shadow-sm outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600">
                                                </label>
                                                <label class="block">
                                                    <span class="text-sm font-medium text-gray-900">State / Region<span class="text-indigo-400">*</span></span>
                                                    <input x-model="campaignSetup.physicalAddressForm.state" type="text" class="mt-2 block h-9 w-full rounded-md border-0 bg-white px-3 text-sm/6 text-gray-900 shadow-sm outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600">
                                                </label>
                                                <label class="block">
                                                    <span class="text-sm font-medium text-gray-900">Zip / Postal code<span class="text-indigo-400">*</span></span>
                                                    <input x-model="campaignSetup.physicalAddressForm.postalCode" type="text" class="mt-2 block h-9 w-full rounded-md border-0 bg-white px-3 text-sm/6 text-gray-900 shadow-sm outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600">
                                                </label>
                                            </div>
                                        </div>
                                    </div></template>
                                    <template x-if="campaignSetup.delayModalOpen"><div class="grid gap-5"><label class="block"><span class="text-sm font-medium text-gray-900">Time</span><x-outcraft.select class="mt-2" model="campaignSetup.delayForm.delayUnit" options="sequenceDelayUnitOptions()" /></label><div x-show="campaignSetup.delayForm.delayUnit !== 'Immediately'" class="block"><span class="text-sm font-medium text-gray-900">Amount</span><div data-campaign-field class="mt-2 flex h-9 w-full max-w-[9rem] items-center overflow-hidden rounded-md bg-white shadow-sm outline outline-1 -outline-offset-1 outline-gray-300 transition focus-within:outline-2 focus-within:-outline-offset-2 focus-within:outline-indigo-600"><button type="button" x-on:click="campaignSetup.delayForm.delayAmount = Math.max(0, (Number(campaignSetup.delayForm.delayAmount) || 0) - 1)" class="flex size-9 shrink-0 items-center justify-center text-gray-400 transition hover:bg-gray-50 hover:text-gray-700" aria-label="Decrease delay"><span class="outcraft-icon !text-[16px]">minus</span></button><input x-model.number="campaignSetup.delayForm.delayAmount" type="text" inputmode="numeric" pattern="[0-9]*" x-on:keydown="['e', 'E', '+', '-', '.'].includes($event.key) && $event.preventDefault()" class="min-w-0 flex-1 border-0 bg-white px-1 text-center text-sm/6 font-medium text-gray-900 outline-none focus:ring-0"><button type="button" x-on:click="campaignSetup.delayForm.delayAmount = (Number(campaignSetup.delayForm.delayAmount) || 0) + 1" class="flex size-9 shrink-0 items-center justify-center text-gray-400 transition hover:bg-gray-50 hover:text-gray-700" aria-label="Increase delay"><span class="outcraft-icon !text-[16px]">plus</span></button></div></div></div></template>
                                    <template x-if="campaignSetup.discountCodeModalOpen"><div class="grid gap-4"><label class="block"><span class="text-sm font-medium text-gray-900">Discount Code</span><input x-model="campaignSetup.newDiscountCode" type="text" placeholder="25OFF" class="mt-2 block w-full rounded-md px-3 py-1.5 text-sm outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600"><span class="mt-2 block text-sm text-gray-500">Code to include - e.g. SUMMER20, WELCOME10.</span></label></div></template>
                                    <template x-if="campaignSetup.overrideModalOpen"><div class="grid gap-4"><button type="button" class="flex items-start justify-between gap-4 rounded-lg border border-gray-200 p-4 text-left"><span><span class="block text-sm font-medium text-gray-900">Allow Override All Campaigns?</span><span class="mt-1 block text-sm text-gray-500">If enabled, this campaign will have priority over any already running campaign once triggered.</span></span><span class="relative inline-flex h-6 w-11 rounded-full bg-gray-200 p-0.5"><span class="size-5 rounded-full bg-white shadow-sm"></span></span></button><label class="block"><span class="text-sm font-medium text-gray-900">Which Campaign Should Current Campaign Override?</span><x-outcraft.select class="mt-2" value="Select an Option" :options="['Select an Option', 'Abandoned Cart Recovery', 'Web Support']" /></label></div></template>
                                    </div>
                                </div>
                                <div x-show="! campaignSetup.sequenceModalOpen && ! campaignSetup.followupModalOpen && (! campaignSetup.physicalAddressModalOpen || campaignSetup.physicalAddressFormOpen)" class="flex justify-end gap-3 border-t border-gray-200 px-6 py-4"><button type="button" x-on:click="closeCampaignSetupOverlays()" class="inline-flex h-9 items-center rounded-md bg-white px-3 text-sm font-semibold text-gray-900 ring-1 ring-inset ring-gray-300">Cancel</button><button type="button" x-on:click="campaignSetup.phoneNumberModalOpen ? addPhoneNumber() : (campaignSetup.physicalAddressFormOpen ? addPhysicalAddress() : (campaignSetup.mailboxModalOpen ? addMailboxConnection() : (campaignSetup.delayModalOpen ? saveDelayModal() : (campaignSetup.discountCodeModalOpen ? addDiscountCode() : closeCampaignSetupOverlays()))))" :disabled="campaignSetup.mailboxModalOpen && ! String(campaignSetup.mailboxEmail || '').trim()" class="inline-flex h-9 items-center rounded-md px-3 text-sm font-semibold" :class="campaignSetup.mailboxModalOpen && ! String(campaignSetup.mailboxEmail || '').trim() ? 'cursor-not-allowed bg-gray-200 text-gray-500' : 'bg-indigo-600 text-white'" x-text="campaignSetup.phoneNumberModalOpen ? 'Assign Number' : (campaignSetup.physicalAddressFormOpen ? 'Save Address' : (campaignSetup.mailboxModalOpen ? 'Connect' : (campaignSetup.delayModalOpen ? 'Save' : (campaignSetup.discountCodeModalOpen ? 'Add Code' : 'Create'))))"></button></div>
                            </div>
                        </div>

                        <div
                            x-cloak
                            x-show="campaignSetup.briefBuilderItemModalOpen"
                            x-transition.opacity
                            x-on:keydown.escape.window="closeCampaignSetupOverlays()"
                            class="fixed inset-0 z-50 flex items-center justify-center bg-gray-950/30 p-4"
                        >
                            <div x-on:click="closeCampaignSetupOverlays()" class="absolute inset-0"></div>
                            <div
                                x-show="campaignSetup.briefBuilderItemModalOpen"
                                x-transition:enter="transition ease-out duration-150"
                                x-transition:enter-start="opacity-0 translate-y-3 scale-95"
                                x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                                x-transition:leave="transition ease-in duration-100"
                                x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                                x-transition:leave-end="opacity-0 translate-y-2 scale-95"
                                class="relative flex max-h-[min(680px,calc(100vh-2rem))] w-full max-w-xl flex-col overflow-hidden rounded-lg bg-white shadow-xl ring-1 ring-gray-900/10"
                                role="dialog"
                                aria-modal="true"
                                aria-labelledby="add-campaign-context-item-title"
                            >
                                <div class="border-b border-gray-200 px-6 py-5">
                                    <div class="flex items-start justify-between gap-4">
                                        <div>
                                            <h2 id="add-campaign-context-item-title" class="text-base font-semibold text-gray-950">Add Campaign Context Item</h2>
                                            <p class="mt-1 text-sm leading-6 text-gray-500">Choose a block to add to your custom campaign context.</p>
                                        </div>
                                        <button type="button" x-on:click="closeCampaignSetupOverlays()" class="inline-flex size-8 items-center justify-center rounded-md text-gray-400 transition hover:bg-gray-50 hover:text-gray-700" aria-label="Close">
                                            <span class="outcraft-icon !text-[20px]">close</span>
                                        </button>
                                    </div>
                                    <label class="mt-4 block">
                                        <span class="sr-only">Search Items</span>
                                        <input x-model="campaignSetup.briefBuilderItemSearch" type="search" placeholder="Search Items" class="block h-9 w-full rounded-md bg-white px-3 py-1.5 text-sm text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600">
                                    </label>
                                </div>
                                <div class="min-h-0 flex-1 overflow-y-auto px-6 py-4">
                                    <div class="space-y-6">
                                        <template x-for="group in filteredBriefBuilderItemGroups()" :key="group.label">
                                            <section>
                                                <h3 class="text-xs font-semibold uppercase tracking-wide text-gray-400" x-text="group.label"></h3>
                                                <div class="mt-2 space-y-2">
                                                    <template x-for="option in group.options" :key="option.type">
                                                        <button type="button" x-on:click="addBriefBuilderItem(option.type)" class="flex w-full items-start gap-3 rounded-lg border border-gray-200 bg-white p-4 text-left transition hover:bg-gray-50 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600" :class="briefBuilderHasItem(option.type) ? 'opacity-60' : ''">
                                                            <span class="flex size-9 shrink-0 items-center justify-center rounded-md bg-indigo-50 text-indigo-600">
                                                                <span x-show="briefBuilderItemSvgIcon(option.type)" class="size-[21px]" x-html="briefBuilderItemSvgIcon(option.type)"></span>
                                                                <span x-show="! briefBuilderItemSvgIcon(option.type)" class="outcraft-icon !text-[19px]" x-text="option.icon"></span>
                                                            </span>
                                                            <span class="min-w-0 flex-1">
                                                                <span class="flex items-center gap-2">
                                                                    <span class="text-sm font-semibold text-gray-950" x-text="option.title"></span>
                                                                    <span x-show="briefBuilderHasItem(option.type)" class="inline-flex rounded-md bg-gray-50 px-2 py-0.5 text-xs font-medium text-gray-600 ring-1 ring-inset ring-gray-500/10">Added</span>
                                                                </span>
                                                                <span class="mt-1 block text-sm leading-6 text-gray-500" x-text="option.description"></span>
                                                            </span>
                                                        </button>
                                                    </template>
                                                </div>
                                            </section>
                                        </template>
                                        <p x-show="filteredBriefBuilderItemGroups().length === 0" class="px-1 py-6 text-center text-sm text-gray-500">No Items Found.</p>
                                    </div>
                                </div>
		                            </div>
	                        </div>

	                        <div
	                            x-cloak
	                            x-show="campaignSetup.leadSourceEventModalOpen"
	                            x-transition.opacity
	                            x-on:keydown.escape.window="closeCampaignSetupOverlays()"
	                            class="fixed inset-0 z-50 flex items-center justify-center bg-gray-950/30 p-4"
	                        >
	                            <div x-on:click="closeCampaignSetupOverlays()" class="absolute inset-0"></div>
	                            <div
	                                x-show="campaignSetup.leadSourceEventModalOpen"
	                                x-transition:enter="transition ease-out duration-150"
	                                x-transition:enter-start="opacity-0 translate-y-3 scale-95"
	                                x-transition:enter-end="opacity-100 translate-y-0 scale-100"
	                                x-transition:leave="transition ease-in duration-100"
	                                x-transition:leave-start="opacity-100 translate-y-0 scale-100"
	                                x-transition:leave-end="opacity-0 translate-y-2 scale-95"
	                                class="relative w-full max-w-xl overflow-hidden rounded-lg bg-white shadow-2xl ring-1 ring-gray-900/10"
	                                role="dialog"
	                                aria-modal="true"
	                                aria-labelledby="lead-source-event-settings-title"
	                            >
	                                <button type="button" x-on:click="closeCampaignSetupOverlays()" class="absolute right-5 top-5 z-20 inline-flex size-8 items-center justify-center rounded-md text-gray-400 transition hover:bg-gray-50 hover:text-gray-700" aria-label="Close">
	                                    <span class="outcraft-icon !text-[22px]">close</span>
	                                </button>

	                                <div class="px-6 py-7 sm:px-8">
	                                    <h2 id="lead-source-event-settings-title" class="text-xl font-bold leading-8 text-gray-950">Edit external event branch</h2>
	                                    <p class="mt-2 text-sm leading-6 text-gray-500">Configure dispatch limits for the selected lead source event.</p>

	                                    <div class="mt-8 grid gap-6">
	                                        <label class="block">
	                                            <span class="block text-sm/6 font-semibold text-gray-900">Dispatches limit</span>
	                                            <input x-model="campaignSetup.leadSourceEventForm.dispatchesLimit" type="number" inputmode="numeric" placeholder="999999991" class="mt-2 block w-full rounded-md bg-white px-3 py-1.5 text-sm/6 text-gray-900 shadow-sm outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600">
	                                            <span class="mt-2 block text-sm leading-6 text-gray-500">How many times this trigger can be fired. Leave empty for unlimited.</span>
	                                        </label>
	                                        <label class="block">
	                                            <span class="block text-sm/6 font-semibold text-gray-900">Cooldown (days)</span>
	                                            <input x-model="campaignSetup.leadSourceEventForm.cooldownDays" type="number" inputmode="numeric" min="0" class="mt-2 block w-full rounded-md bg-white px-3 py-1.5 text-sm/6 text-gray-900 shadow-sm outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600">
	                                            <span class="mt-2 block text-sm leading-6 text-gray-500">Number of days to wait before this trigger can be fired again for the same lead.</span>
	                                        </label>
	                                    </div>

	                                    <div class="mt-8 flex flex-wrap gap-3">
	                                        <button type="button" x-on:click="saveLeadSourceEventSettings()" class="inline-flex h-9 items-center rounded-md bg-indigo-600 px-3 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-500">Save changes</button>
	                                        <button type="button" x-on:click="closeCampaignSetupOverlays()" class="inline-flex h-9 items-center rounded-md bg-white px-3 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 transition hover:bg-gray-50">Cancel</button>
	                                    </div>
	                                </div>
	                            </div>
	                        </div>

		                        <div
		                            x-cloak
		                            x-show="campaignSetup.klaviyoEventsGuideOpen"
                            x-transition.opacity
                            x-on:keydown.escape.window="closeCampaignSetupOverlays()"
                            class="fixed inset-0 z-50 flex items-center justify-center bg-gray-950/30 p-4"
                        >
                            <div x-on:click="closeCampaignSetupOverlays()" class="absolute inset-0"></div>
                            <div
                                x-show="campaignSetup.klaviyoEventsGuideOpen"
                                x-transition:enter="transition ease-out duration-150"
                                x-transition:enter-start="opacity-0 translate-y-3 scale-95"
                                x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                                x-transition:leave="transition ease-in duration-100"
                                x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                                x-transition:leave-end="opacity-0 translate-y-2 scale-95"
                                class="relative max-h-[min(900px,calc(100vh-2rem))] w-full max-w-5xl overflow-hidden rounded-lg bg-white shadow-2xl ring-1 ring-gray-900/10"
                                role="dialog"
                                aria-modal="true"
                                aria-labelledby="klaviyo-events-guide-title"
                            >
                                <button type="button" x-on:click="closeCampaignSetupOverlays()" class="absolute right-5 top-5 z-20 inline-flex size-8 items-center justify-center rounded-md text-gray-400 transition hover:bg-gray-50 hover:text-gray-700" aria-label="Close">
                                    <span class="outcraft-icon !text-[22px]">close</span>
                                </button>

                                <div class="max-h-[min(900px,calc(100vh-2rem))] overflow-y-auto px-6 py-8 sm:px-10 lg:px-16">
                                    <div class="max-w-3xl">
                                        <span class="flex size-10 items-center justify-center rounded-md bg-indigo-50 text-indigo-600">
                                            <span class="outcraft-icon !text-[21px]">webhook</span>
                                        </span>
                                        <h2 id="klaviyo-events-guide-title" class="mt-5 text-xl font-bold text-gray-950">How To Run This Campaign?</h2>
                                        <p class="mt-2 text-sm leading-6 text-gray-600">To connect Klaviyo with Outcraft, create 2 simple flows in Klaviyo with Webhook actions.</p>
                                    </div>

	                                    <div class="mt-8 grid gap-6">
                                        <section class="rounded-lg bg-gray-50 p-5 ring-1 ring-inset ring-gray-200">
                                            <h3 class="text-base font-bold text-gray-950">Create The "Checkout Started" Flow</h3>
                                            <ol class="mt-4 list-decimal space-y-2 pl-5 text-sm leading-6 text-gray-600">
                                                <li>Go to Klaviyo -> Flows. Click Create Flow -> Build your own.</li>
                                                <li>Choose any name, for example: "Outcraft - Checkout Abandoned Trigger - Checkout Start".</li>
                                                <li>Select a Checkout Started trigger.</li>
                                                <li>Pick the metric that matches your ecommerce integration: Shopify, WooCommerce, Custom, etc.</li>
                                                <li>On Re-entry criteria, select Allow re-entry.</li>
                                                <li>Save -> Confirm and save.</li>
                                                <li>Drag and drop a Webhook action from the left sidebar and connect it directly to the trigger.</li>
                                            </ol>

                                            <div class="mt-5 space-y-4">
                                                <div>
                                                    <p class="text-sm font-semibold text-gray-900">Destination URL:</p>
	                                                    <pre class="mt-2 overflow-x-auto rounded-md bg-gray-100 p-3 text-xs leading-5 text-gray-700 ring-1 ring-inset ring-gray-200"><code>https://outcraft.ai/api/v1/trigger/bf1576f3-8de9-49a9-8e9b-80be6a19eafd</code></pre>
                                                </div>
                                                <div>
                                                    <p class="text-sm font-semibold text-gray-900">JSON Body:</p>
	                                                    <pre class="mt-2 overflow-x-auto rounded-md bg-gray-100 p-3 text-xs leading-5 text-gray-700 ring-1 ring-inset ring-gray-200"><code>{
  "outcraft_event": "klaviyo/checkout/started",
  "event_raw": "@{{ event|escapejs }}",
  "person_raw": "@{{ person|escapejs }}"
}</code></pre>
                                                </div>
                                            </div>

                                            <p class="mt-5 text-sm leading-6 text-gray-600">Click Save, then Review and turn on. Make sure Flow status is set to Live, then press Save.</p>
                                        </section>

                                        <section class="rounded-lg bg-gray-50 p-5 ring-1 ring-inset ring-gray-200">
                                            <h3 class="text-base font-bold text-gray-950">Create The "Order Placed" Flow</h3>
                                            <ol class="mt-4 list-decimal space-y-2 pl-5 text-sm leading-6 text-gray-600">
                                                <li>Go to Klaviyo -> Flows. Click Create Flow -> Build your own.</li>
                                                <li>Choose any name, for example: "Outcraft - Checkout Abandoned Trigger - Order Placed".</li>
                                                <li>Select a Placed Order trigger.</li>
                                                <li>Pick the metric that matches your ecommerce integration: Shopify, WooCommerce, Custom, etc.</li>
                                                <li>On Re-entry criteria, select Allow re-entry.</li>
                                                <li>Save -> Confirm and save.</li>
                                                <li>Drag and drop a Webhook action from the left sidebar and connect it directly to the trigger.</li>
                                            </ol>

                                            <div class="mt-5 space-y-4">
                                                <div>
                                                    <p class="text-sm font-semibold text-gray-900">Destination URL:</p>
	                                                    <pre class="mt-2 overflow-x-auto rounded-md bg-gray-100 p-3 text-xs leading-5 text-gray-700 ring-1 ring-inset ring-gray-200"><code>https://outcraft.ai/api/v1/trigger/bf1576f3-8de9-49a9-8e9b-80be6a19eafd</code></pre>
                                                </div>
                                                <div>
                                                    <p class="text-sm font-semibold text-gray-900">JSON Body:</p>
	                                                    <pre class="mt-2 overflow-x-auto rounded-md bg-gray-100 p-3 text-xs leading-5 text-gray-700 ring-1 ring-inset ring-gray-200"><code>{
  "outcraft_event": "klaviyo/order/placed",
  "event_raw": "@{{ event|escapejs }}",
  "person_raw": "@{{ person|escapejs }}"
}</code></pre>
                                                </div>
                                            </div>

                                            <p class="mt-5 text-sm leading-6 text-gray-600">Click Save, then Review and turn on. Make sure Flow status is set to Live, then press Save.</p>
                                        </section>
                                    </div>

                                    <section class="mt-8 rounded-lg bg-indigo-50 p-5 ring-1 ring-inset ring-indigo-100">
                                        <h3 class="text-base font-bold text-gray-950">TL;DR checklist</h3>
	                                        <ul class="mt-4 list-disc space-y-2 pl-5 text-sm leading-6 text-gray-700">
	                                            <li>Create 2 flows: Checkout Started + Order Placed.</li>
	                                            <li>Add a Webhook action to each flow.</li>
	                                            <li>Paste the JSON exactly as provided.</li>
	                                            <li>Set flow status to Live.</li>
	                                        </ul>
                                        <p class="mt-4 text-sm font-semibold text-indigo-700">That's it - Outcraft handles the rest.</p>
                                    </section>
                                </div>
                            </div>
                        </div>

	                        <div
	                            x-cloak
	                            x-show="campaignSetup.integrationSkipModalOpen"
                            x-transition.opacity
                            x-on:keydown.escape.window="closeCampaignSetupOverlays()"
                            class="fixed inset-0 z-50 flex items-center justify-center bg-gray-950/30 p-4"
                        >
                            <div x-on:click="closeCampaignSetupOverlays()" class="absolute inset-0"></div>
                            <div
                                x-show="campaignSetup.integrationSkipModalOpen"
                                x-transition:enter="transition ease-out duration-150"
                                x-transition:enter-start="opacity-0 translate-y-3 scale-95"
                                x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                                x-transition:leave="transition ease-in duration-100"
                                x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                                x-transition:leave-end="opacity-0 translate-y-2 scale-95"
                                class="relative w-full max-w-lg rounded-lg bg-white p-6 text-center shadow-xl ring-1 ring-gray-900/10"
                                role="dialog"
                                aria-modal="true"
                                aria-labelledby="skip-integration-title"
                            >
                                <button type="button" x-on:click="closeCampaignSetupOverlays()" class="absolute right-4 top-4 inline-flex size-8 items-center justify-center rounded-md text-gray-400 transition hover:bg-gray-50 hover:text-gray-700" aria-label="Close">
                                    <span class="outcraft-icon !text-[22px]">close</span>
                                </button>
                                <div class="mx-auto flex size-12 items-center justify-center rounded-full bg-indigo-50 text-indigo-600">
                                    <span class="outcraft-icon !text-[24px]">report</span>
                                </div>
                                <h2 id="skip-integration-title" class="mt-5 text-base font-bold text-gray-950">Set Up Lead Source Later?</h2>
                                <p class="mt-2 text-sm leading-6 text-gray-500">Without custom fields or merge tags, AI will have less context to personalize conversations.</p>
                                <div class="mt-6 flex justify-center gap-3">
                                    <button type="button" x-on:click="closeCampaignSetupOverlays()" class="inline-flex h-9 min-w-28 items-center justify-center rounded-md bg-white px-3 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 transition hover:bg-gray-50">Cancel</button>
                                    <button type="button" x-on:click="confirmSkipCampaignIntegration()" class="inline-flex h-9 min-w-28 items-center justify-center rounded-md bg-indigo-600 px-3 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-500">Setup Later</button>
                                </div>
                            </div>
                        </div>

                        <div x-cloak x-show="campaignSetup.evaluationDrawerOpen || campaignSetup.dispatchDrawerOpen" class="fixed inset-0 z-50 flex justify-end bg-gray-950/30">
                            <div class="h-full w-full max-w-xl overflow-auto bg-white p-6 shadow-2xl">
                                <div class="flex items-start justify-between gap-4">
                                    <div><h2 class="text-xl font-bold text-gray-950" x-text="campaignSetup.dispatchDrawerOpen ? 'Create Campaign Dispatch Condition Set' : 'Create AI Evaluation'"></h2><p class="mt-2 text-sm leading-6 text-gray-500" x-text="campaignSetup.dispatchDrawerOpen ? 'Define lead metadata rules for this campaign.' : 'Choose what signals, behaviours, or insights the AI should detect from conversations.'"></p></div>
                                    <button type="button" x-on:click="closeCampaignSetupOverlays()" class="rounded-md p-2 text-gray-400 hover:bg-gray-50"><span class="outcraft-icon">close</span></button>
                                </div>
                                <div x-show="campaignSetup.evaluationDrawerOpen" class="mt-6 space-y-5">
                                    <label class="block"><span class="text-sm font-medium text-gray-900">Display Name</span><input type="text" placeholder="Purchase Intent" class="mt-2 block w-full rounded-md px-3 py-1.5 text-sm outline outline-1 -outline-offset-1 outline-gray-300"><span class="mt-2 block text-sm text-gray-500">A clear name used to identify this evaluation in conversation insights and analytics.</span></label>
                                    <div><p class="text-sm font-medium text-gray-900">Response Format</p><div class="mt-2 grid grid-cols-2 gap-3"><template x-for="format in ['Yes / No','Text Summary','Classified','Score']" :key="format"><button type="button" x-on:click="campaignSetup.evaluationFormat = format" class="rounded-lg border p-4 text-left" :class="campaignSetup.evaluationFormat === format ? 'border-indigo-600 ring-2 ring-indigo-100' : 'border-gray-200'"><span class="block text-sm font-bold text-gray-950" x-text="format"></span><span class="mt-1 block text-xs leading-5 text-gray-500" x-text="evaluationFormatDescription(format)"></span></button></template></div></div>
                                    <label class="block"><span class="text-sm font-medium text-gray-900">Evaluation Instruction</span><textarea rows="4" class="mt-2 block w-full rounded-md px-3 py-1.5 text-sm outline outline-1 -outline-offset-1 outline-gray-300"></textarea></label>
                                    <div x-show="campaignSetup.evaluationFormat === 'Yes / No'" class="grid gap-4"><textarea rows="3" placeholder="What should count as Yes?" class="rounded-md px-3 py-1.5 text-sm outline outline-1 -outline-offset-1 outline-gray-300"></textarea><textarea rows="3" placeholder="What should count as No?" class="rounded-md px-3 py-1.5 text-sm outline outline-1 -outline-offset-1 outline-gray-300"></textarea></div>
                                    <div x-show="campaignSetup.evaluationFormat === 'Text Summary'" class="grid gap-4"><textarea rows="3" placeholder="What Should Be Summarized?" class="rounded-md px-3 py-1.5 text-sm outline outline-1 -outline-offset-1 outline-gray-300"></textarea><x-outcraft.select value="1 Sentence" :options="['1 Sentence', '2 Sentences', 'Paragraph']" /></div>
                                    <div x-show="campaignSetup.evaluationFormat === 'Classified'"><input type="text" placeholder="Price objection, timing issue, competitor" class="block w-full rounded-md px-3 py-1.5 text-sm outline outline-1 -outline-offset-1 outline-gray-300"><p class="mt-2 text-sm text-gray-500">Add each possible label as a separate tag.</p></div>
                                    <div x-show="campaignSetup.evaluationFormat === 'Score'" class="grid gap-4"><div class="grid grid-cols-2 gap-4"><input type="number" value="1" class="rounded-md px-3 py-1.5 text-sm outline outline-1 -outline-offset-1 outline-gray-300"><input type="number" value="5" class="rounded-md px-3 py-1.5 text-sm outline outline-1 -outline-offset-1 outline-gray-300"></div><textarea rows="3" placeholder="Score meaning" class="rounded-md px-3 py-1.5 text-sm outline outline-1 -outline-offset-1 outline-gray-300"></textarea></div>
                                </div>
                                <div x-show="campaignSetup.dispatchDrawerOpen" class="mt-6 space-y-5">
                                    <label class="block"><span class="text-sm font-medium text-gray-900">Match By</span><x-outcraft.select class="mt-2" value="All (AND)" :options="['All (AND)', 'Any (OR)']" /><span class="mt-2 block text-sm text-gray-500">How many conditions should be met to dispatch this campaign?</span></label>
                                    <label class="block"><span class="text-sm font-medium text-gray-900">Label</span><input type="text" placeholder="e.g. Lead Country filters" class="mt-2 block w-full rounded-md px-3 py-1.5 text-sm outline outline-1 -outline-offset-1 outline-gray-300"></label>
                                    <div class="grid gap-3 sm:grid-cols-3"><x-outcraft.select value="Lead Country" :options="['Lead Country', 'Lead Source', 'Lead Status', 'Customer Type', 'Purchase Count', 'Cart Value', 'Last Activity Date', 'Event Name']" /><x-outcraft.select value="Equals" :options="['Equals', 'Does Not Equal', 'Contains', 'Greater Than', 'Less Than', 'Is Empty', 'Is Not Empty']" /><input type="text" placeholder="Value" class="rounded-md px-3 py-1.5 text-sm outline outline-1 -outline-offset-1 outline-gray-300"></div>
                                </div>
                                <div class="mt-6 flex justify-end gap-3"><button type="button" x-on:click="closeCampaignSetupOverlays()" class="inline-flex h-9 items-center rounded-md bg-white px-3 text-sm font-semibold text-gray-900 ring-1 ring-inset ring-gray-300">Cancel</button><button type="button" x-on:click="closeCampaignSetupOverlays()" class="inline-flex h-9 items-center rounded-md bg-indigo-600 px-3 text-sm font-semibold text-white">Create</button></div>
                            </div>
                        </div>
                    </div>
