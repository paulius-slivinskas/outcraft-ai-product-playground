        <section x-cloak x-show="campaignBuilderOpen" data-campaign-builder class="relative min-h-full w-full" :class="(campaignBuilderUsesSidebarLayout() || campaignBuilderUsesIntroLayout()) ? '!m-0 bg-gray-50' : 'mx-6 mb-6 mt-6 bg-white'">
            <div
                x-cloak
                x-show="campaignBuilderTransitioning"
                x-transition.opacity
                class="fixed inset-0 z-50 flex items-center justify-center bg-white"
            >
                <div class="flex flex-col items-center gap-4">
                    <div data-card-ignore class="flex size-[56px] items-center justify-center rounded-xl bg-white" x-html="tableLoaderSvg()"></div>
                    <p class="text-sm font-medium text-gray-500" x-text="campaignBuilderTransitionLabel"></p>
                </div>
            </div>

            <div x-show="! campaignBuilderUsesIntroLayout() && (campaignBuilderStep < companySetupStartStep() || campaignSetupModeSelected)" class="sticky top-0 z-30 border-b border-gray-200 bg-gray-50 px-4 py-3 lg:hidden">
                <div class="flex items-center justify-between gap-3">
                    <span class="min-w-0 truncate text-sm font-semibold text-gray-900" x-text="campaignBuilderMobileProgressLabel()"></span>
                    <span class="shrink-0 text-xs font-medium text-gray-500" x-text="campaignBuilderMobileProgressStepLabel()"></span>
                </div>
                <div class="mt-3 h-2 overflow-hidden rounded-full bg-gray-200">
                    <div class="h-full rounded-full oc-primary-bg transition-all duration-300 ease-out" :style="`width: ${campaignBuilderMobileProgressPercent()}%`"></div>
                </div>
            </div>

            <div x-ref="campaignBuilderScrollScene" :style="campaignBuilderScrollSceneStyle()" class="relative flex w-full items-start" :class="campaignBuilderUsesSidebarLayout() ? 'mx-0 min-h-full min-w-full max-w-none gap-0 bg-gray-50' : (campaignBuilderUsesIntroLayout() ? 'mx-0 min-h-full max-w-none bg-gray-50 px-4 py-6 sm:px-6 lg:px-8' : 'mx-auto max-w-7xl gap-12 xl:gap-16')">
                <aside x-ref="campaignBuilderProgressAside" x-show="! campaignBuilderUsesIntroLayout() && (campaignBuilderStep < companySetupStartStep() || campaignSetupModeSelected)" class="hidden shrink-0 lg:block" :class="[campaignBuilderUsesIntroLayout() ? '!hidden' : '', campaignBuilderUsesSidebarLayout() ? 'min-h-screen w-80 border-r border-gray-200 bg-white px-8 py-6' : 'w-72']" :style="campaignBuilderProgressStickyStyle()">
                    <div>
                    <div x-ref="campaignBuilderProgressColumn">
                    <div class="mb-8 flex items-center justify-between gap-3">
                        <button
                            type="button"
                            x-on:click="handleCampaignBuilderBack()"
                            class="inline-flex h-9 min-w-0 items-center gap-2 rounded-md px-2 text-sm font-semibold text-gray-600 transition hover:bg-gray-50 hover:text-gray-950"
                        >
                            <span class="outcraft-icon !text-[18px]">arrow_back</span>
                            <span class="truncate" x-text="campaignBuilderBackLabel()"></span>
                        </button>
                        <div
                            class="relative shrink-0"
                            x-data="{ setupModeMenuOpen: false }"
                            x-on:click.outside="setupModeMenuOpen = false"
                        >
                            <button type="button" x-on:click="setupModeMenuOpen = ! setupModeMenuOpen" class="inline-flex size-9 items-center justify-center rounded-md text-gray-500 transition hover:bg-gray-100 hover:text-gray-900" aria-label="Progress and setup options">
                                <span class="outcraft-icon !text-[18px]">more_vert</span>
                            </button>
                            <div x-cloak x-show="setupModeMenuOpen" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-1" class="absolute right-2 z-40 mt-2 w-52 rounded-md border border-gray-200 bg-white py-1 shadow-lg" role="menu">
                                <div x-show="campaignBuilderStep >= companySetupStartStep() && campaignSetupModeSelected" class="pt-1">
                                <p class="px-2 py-1 text-xs font-semibold uppercase tracking-wide text-gray-400">Setup Mode</p>
                                <button type="button" x-on:click="setCampaignSetupMode('fast'); setupModeMenuOpen = false" class="flex w-full items-center justify-between px-3 py-2 text-left text-sm font-medium transition" :class="campaignSetupMode === 'fast' ? 'text-gray-950' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-950'" role="menuitem">
                                    <span>Fast</span>
                                    <span x-show="campaignSetupMode === 'fast'" class="outcraft-icon !text-[16px] text-indigo-600">check</span>
                                </button>
                                <button type="button" x-on:click="setCampaignSetupMode('advanced'); setupModeMenuOpen = false" class="flex w-full items-center justify-between px-3 py-2 text-left text-sm font-medium transition" :class="campaignSetupMode === 'advanced' ? 'text-gray-950' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-950'" role="menuitem">
                                    <span>Advanced</span>
                                    <span x-show="campaignSetupMode === 'advanced'" class="outcraft-icon !text-[16px] text-indigo-600">check</span>
                                </button>
                                </div>
                                <div x-show="campaignBuilderStep >= companySetupStartStep() && campaignSetupModeSelected && campaignSetup.current === 'brief'" class="mt-1 border-t border-gray-100 pt-1">
                                    <p class="px-2 py-1 text-xs font-semibold uppercase tracking-wide text-gray-400">Campaign Context</p>
                                    <button type="button" x-on:click="campaignSetup.briefTab = 'builder'; setupModeMenuOpen = false; scheduleCampaignBuilderLayoutUpdate()" class="flex w-full items-center justify-between px-3 py-2 text-left text-sm font-medium transition" :class="campaignSetup.briefTab === 'builder' ? 'text-gray-950' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-950'" role="menuitem">
                                        <span>Option Three</span>
                                        <span x-show="campaignSetup.briefTab === 'builder'" class="outcraft-icon !text-[16px] text-indigo-600">check</span>
                                    </button>
                                    <button type="button" x-on:click="campaignSetup.briefTab = 'context'; setupModeMenuOpen = false; scheduleCampaignBuilderLayoutUpdate()" class="flex w-full items-center justify-between px-3 py-2 text-left text-sm font-medium transition" :class="campaignSetup.briefTab === 'context' ? 'text-gray-950' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-950'" role="menuitem">
                                        <span>Original</span>
                                        <span x-show="campaignSetup.briefTab === 'context'" class="outcraft-icon !text-[16px] text-indigo-600">check</span>
                                    </button>
                                    <button type="button" x-on:click="campaignSetup.briefTab = 'discovery'; setupModeMenuOpen = false; scheduleCampaignBuilderLayoutUpdate()" class="flex w-full items-center justify-between px-3 py-2 text-left text-sm font-medium transition" :class="campaignSetup.briefTab === 'discovery' ? 'text-gray-950' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-950'" role="menuitem">
                                        <span>Option Two</span>
                                        <span x-show="campaignSetup.briefTab === 'discovery'" class="outcraft-icon !text-[16px] text-indigo-600">check</span>
                                    </button>
                                </div>
                                <div x-show="campaignBuilderStep >= companySetupStartStep() && campaignSetupModeSelected && campaignSetup.current === 'followups'" class="mt-1 border-t border-gray-100 pt-1">
                                    <p class="px-2 py-1 text-xs font-semibold uppercase tracking-wide text-gray-400">Follow-Up Sequence</p>
                                    <button type="button" x-on:click="setFollowupLayoutOption('option2'); setupModeMenuOpen = false" class="flex w-full items-center justify-between px-3 py-2 text-left text-sm font-medium transition" :class="campaignSetup.followupLayoutOption === 'option2' ? 'text-gray-950' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-950'" role="menuitem">
                                        <span>Option 2</span>
                                        <span x-show="campaignSetup.followupLayoutOption === 'option2'" class="outcraft-icon !text-[16px] text-indigo-600">check</span>
                                    </button>
                                    <button type="button" x-on:click="setFollowupLayoutOption('option1'); setupModeMenuOpen = false" class="flex w-full items-center justify-between px-3 py-2 text-left text-sm font-medium transition" :class="campaignSetup.followupLayoutOption === 'option1' ? 'text-gray-950' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-950'" role="menuitem">
                                        <span>Option 1 · Historical</span>
                                        <span x-show="campaignSetup.followupLayoutOption === 'option1'" class="outcraft-icon !text-[16px] text-indigo-600">check</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <nav x-show="campaignBuilderStep < companySetupStartStep() && progressBarStyle === 'timeline'" x-ref="companySetupProgressNav" aria-label="Company setup progress">
                        <ol role="list" class="space-y-6">
                            <template x-for="(step, index) in companySetupSteps" :key="step.label">
                                <li class="relative flex gap-4">
                                    <span
                                        x-show="index !== companySetupSteps.length - 1"
                                        class="absolute left-[15px] top-0 -bottom-10 w-0.5"
                                        :class="campaignBuilderMaxStep > index ? 'oc-primary-bg' : 'bg-gray-200'"
                                    ></span>
                                    <button type="button" x-on:click="goToCampaignBuilderStep(index)" :disabled="index > campaignBuilderMaxStep" class="group flex min-w-0 items-start gap-4 text-left disabled:cursor-not-allowed">
                                        <span class="flex h-9 items-center">
                                            <span
                                                class="relative z-10 flex size-8 shrink-0 items-center justify-center rounded-full transition"
                                                :class="campaignBuilderStep === index ? 'border-2 oc-primary-border bg-white' : (campaignBuilderMaxStep > index ? 'border-2 oc-primary-border oc-primary-bg text-white' : 'border-2 border-gray-300 bg-white group-hover:border-gray-400')"
                                            >
                                                <span x-show="campaignBuilderMaxStep > index && campaignBuilderStep !== index" class="outcraft-icon !text-[18px] text-white">check</span>
                                                <span x-show="campaignBuilderStep === index" class="size-2.5 rounded-full oc-primary-bg"></span>
                                                <span x-show="campaignBuilderStep !== index && campaignBuilderMaxStep <= index" class="size-2.5 rounded-full bg-transparent group-hover:bg-gray-300"></span>
                                            </span>
                                        </span>
                                        <span class="min-w-0 pt-1">
                                            <span class="block text-sm font-semibold leading-6" :class="campaignBuilderStep === index ? 'oc-primary-text' : 'text-gray-950'" x-text="step.label"></span>
                                            <span class="block text-sm leading-5 text-gray-500" x-text="step.description"></span>
                                        </span>
                                    </button>
                                </li>
                            </template>
                        </ol>
                    </nav>

                    <nav x-show="campaignBuilderStep < companySetupStartStep() && progressBarStyle === 'bulletlist'" x-ref="companySetupProgressBulletNav" aria-label="Company setup progress">
                        <ol role="list" class="space-y-6">
                            <template x-for="(step, index) in companySetupSteps" :key="step.label">
                                <li>
                                    <button
                                        type="button"
                                        x-on:click="goToCampaignBuilderStep(index)"
                                        :disabled="index > campaignBuilderMaxStep"
                                        :aria-current="campaignBuilderStep === index ? 'step' : null"
                                        class="group flex w-full min-w-0 items-start text-left disabled:cursor-not-allowed"
                                    >
                                        <span class="relative flex size-5 shrink-0 items-center justify-center">
                                            <svg x-show="campaignBuilderMaxStep > index && campaignBuilderStep !== index" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" class="size-full oc-primary-text transition">
                                                <path d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16Zm3.857-9.809a.75.75 0 0 0-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 1 0-1.06 1.061l2.5 2.5a.75.75 0 0 0 1.137-.089l4-5.5Z" clip-rule="evenodd" fill-rule="evenodd" />
                                            </svg>
                                            <span x-show="campaignBuilderStep === index" aria-hidden="true" class="relative flex size-5 shrink-0 items-center justify-center">
                                                <span class="absolute size-4 rounded-full oc-primary-bg-soft"></span>
                                                <span class="relative block size-2 rounded-full oc-primary-bg"></span>
                                            </span>
                                            <span x-show="campaignBuilderStep !== index && campaignBuilderMaxStep <= index" aria-hidden="true" class="relative flex size-5 shrink-0 items-center justify-center">
                                                <span class="size-2 rounded-full bg-gray-300 transition group-hover:bg-gray-400"></span>
                                            </span>
                                        </span>
                                        <span class="ml-3 min-w-0 text-sm font-medium leading-5 transition" :class="campaignBuilderStep === index ? 'oc-primary-text' : 'text-gray-500 group-hover:text-gray-900'" x-text="step.label"></span>
                                        <span class="sr-only" x-text="step.description"></span>
                                    </button>
                                </li>
                            </template>
                        </ol>
                    </nav>

                    <nav x-show="campaignBuilderStep >= companySetupStartStep() && campaignSetupModeSelected && progressBarStyle === 'timeline'" aria-label="Campaign setup progress" class="space-y-5">
                        <ol role="list" class="space-y-4">
                            <template x-for="(step, index) in campaignSetupPrimaryTimelineSteps()" :key="step.id">
                                <li class="relative flex gap-4">
                                    <span x-show="index !== campaignSetupPrimaryTimelineSteps().length - 1" class="absolute left-[15px] top-0 -bottom-8 w-0.5" :class="campaignSetupStatus(step.id) === 'done' ? 'oc-primary-bg' : 'bg-gray-200'"></span>
                                    <div class="relative flex min-w-0 flex-1 items-start gap-2" x-on:click.outside="step.id === 'followups' && (campaignSetup.followupOptionMenuOpen = false)">
                                        <button type="button" x-on:click="setCampaignSetupStep(step.id)" class="group flex min-w-0 flex-1 items-start gap-4 text-left">
                                            <span class="flex h-9 items-center" x-html="campaignSetupStatusIcon(step.id, campaignSetupStepNumber(step.id))"></span>
                                            <span class="min-w-0 pt-1">
                                                <span class="block text-sm font-semibold leading-6" :class="campaignSetup.current === step.id ? 'oc-primary-text' : 'text-gray-950'" x-text="step.label"></span>
                                                <span class="block text-sm leading-5 text-gray-500" x-text="step.id === 'followups' ? followupLayoutOptionLabel() : step.description"></span>
                                            </span>
                                        </button>
                                        <button x-show="step.id === 'followups'" type="button" x-on:click="campaignSetup.followupOptionMenuOpen = ! campaignSetup.followupOptionMenuOpen" class="mt-1 inline-flex size-8 shrink-0 items-center justify-center rounded-md text-gray-400 transition hover:bg-gray-50 hover:text-gray-700" aria-label="Follow-Up Options">
                                            <span class="outcraft-icon !text-[18px]">more_vert</span>
                                        </button>
                                        <div x-cloak x-show="step.id === 'followups' && campaignSetup.followupOptionMenuOpen" x-transition class="absolute right-0 top-10 z-30 w-48 rounded-md bg-white py-1 shadow-lg ring-1 ring-gray-900/10">
                                            <button type="button" x-on:click="setFollowupLayoutOption('option2')" class="flex w-full items-center justify-between px-3 py-2 text-left text-sm font-medium text-gray-700 transition hover:bg-gray-50 hover:text-gray-950"><span>Option 2</span><span x-show="campaignSetup.followupLayoutOption === 'option2'" class="outcraft-icon !text-[16px] oc-primary-text">check</span></button>
                                            <button type="button" x-on:click="setFollowupLayoutOption('option1')" class="flex w-full items-center justify-between px-3 py-2 text-left text-sm font-medium text-gray-700 transition hover:bg-gray-50 hover:text-gray-950"><span>Option 1 · Historical</span><span x-show="campaignSetup.followupLayoutOption === 'option1'" class="outcraft-icon !text-[16px] oc-primary-text">check</span></button>
                                        </div>
                                    </div>
                                </li>
                            </template>
                        </ol>

                        <ol x-show="campaignSetupSecondaryTimelineSteps().length > 0" role="list" class="mt-8 space-y-4 border-t border-gray-200 pt-6">
                            <template x-for="(step, index) in campaignSetupSecondaryTimelineSteps()" :key="step.id">
                                <li class="relative flex gap-4">
                                    <span x-show="index !== campaignSetupSecondaryTimelineSteps().length - 1" class="absolute left-[15px] top-0 -bottom-8 w-0.5" :class="campaignSetupStatus(step.id) === 'done' ? 'oc-primary-bg' : 'bg-gray-200'"></span>
                                    <button type="button" x-on:click="setCampaignSetupStep(step.id)" class="group flex min-w-0 items-start gap-4 text-left">
                                        <span class="flex h-9 items-center" x-html="campaignSetupStatusIcon(step.id, campaignSetupStepNumber(step.id))"></span>
                                        <span class="min-w-0 pt-1">
                                            <span class="block text-sm font-semibold leading-6" :class="campaignSetup.current === step.id ? 'oc-primary-text' : 'text-gray-950'" x-text="step.label"></span>
                                            <span class="block text-sm leading-5 text-gray-500" x-text="step.description"></span>
                                        </span>
                                    </button>
                                </li>
                            </template>
                        </ol>
                    </nav>

                    <nav x-show="campaignBuilderStep >= companySetupStartStep() && campaignSetupModeSelected && progressBarStyle === 'bulletlist'" aria-label="Campaign setup progress" class="space-y-6">
                        <ol role="list" class="space-y-6">
                            <template x-for="(step, index) in campaignSetupPrimaryTimelineSteps()" :key="step.id">
                                <li>
                                    <button
                                        type="button"
                                        x-on:click="setCampaignSetupStep(step.id)"
                                        :aria-current="campaignSetup.current === step.id ? 'step' : null"
                                        class="group flex w-full min-w-0 items-start text-left"
                                    >
                                        <span class="relative flex size-5 shrink-0 items-center justify-center">
                                            <svg x-show="campaignSetupStatus(step.id) === 'done'" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" class="size-full oc-primary-text transition">
                                                <path d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16Zm3.857-9.809a.75.75 0 0 0-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 1 0-1.06 1.061l2.5 2.5a.75.75 0 0 0 1.137-.089l4-5.5Z" clip-rule="evenodd" fill-rule="evenodd" />
                                            </svg>
                                            <span x-show="campaignSetup.current === step.id" aria-hidden="true" class="relative flex size-5 shrink-0 items-center justify-center">
                                                <span class="absolute size-4 rounded-full oc-primary-bg-soft"></span>
                                                <span class="relative block size-2 rounded-full oc-primary-bg"></span>
                                            </span>
                                            <span x-show="campaignSetup.current !== step.id && campaignSetupStatus(step.id) !== 'done'" aria-hidden="true" class="relative flex size-5 shrink-0 items-center justify-center">
                                                <span class="size-2 rounded-full bg-gray-300 transition group-hover:bg-gray-400"></span>
                                            </span>
                                        </span>
                                        <span class="ml-3 min-w-0 text-sm font-medium leading-5 transition" :class="campaignSetup.current === step.id ? 'oc-primary-text' : 'text-gray-500 group-hover:text-gray-900'" x-text="step.label"></span>
                                        <span class="sr-only" x-text="step.description"></span>
                                    </button>
                                </li>
                            </template>
                        </ol>

                        <ol x-show="campaignSetupSecondaryTimelineSteps().length > 0" role="list" class="space-y-6 border-t border-gray-200 pt-6">
                            <template x-for="(step, index) in campaignSetupSecondaryTimelineSteps()" :key="step.id">
                                <li>
                                    <button
                                        type="button"
                                        x-on:click="setCampaignSetupStep(step.id)"
                                        :aria-current="campaignSetup.current === step.id ? 'step' : null"
                                        class="group flex w-full min-w-0 items-start text-left"
                                    >
                                        <span class="relative flex size-5 shrink-0 items-center justify-center">
                                            <svg x-show="campaignSetupStatus(step.id) === 'done'" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" class="size-full oc-primary-text transition">
                                                <path d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16Zm3.857-9.809a.75.75 0 0 0-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 1 0-1.06 1.061l2.5 2.5a.75.75 0 0 0 1.137-.089l4-5.5Z" clip-rule="evenodd" fill-rule="evenodd" />
                                            </svg>
                                            <span x-show="campaignSetup.current === step.id" aria-hidden="true" class="relative flex size-5 shrink-0 items-center justify-center">
                                                <span class="absolute size-4 rounded-full oc-primary-bg-soft"></span>
                                                <span class="relative block size-2 rounded-full oc-primary-bg"></span>
                                            </span>
                                            <span x-show="campaignSetup.current !== step.id && campaignSetupStatus(step.id) !== 'done'" aria-hidden="true" class="relative flex size-5 shrink-0 items-center justify-center">
                                                <span class="size-2 rounded-full bg-gray-300 transition group-hover:bg-gray-400"></span>
                                            </span>
                                        </span>
                                        <span class="ml-3 min-w-0 text-sm font-medium leading-5 transition" :class="campaignSetup.current === step.id ? 'oc-primary-text' : 'text-gray-500 group-hover:text-gray-900'" x-text="step.label"></span>
                                        <span class="sr-only" x-text="step.description"></span>
                                    </button>
                                </li>
                            </template>
                        </ol>
                    </nav>
                    </div>
                    </div>
                </aside>

                <div class="min-w-0" :class="[(campaignBuilderUsesSidebarLayout() || campaignBuilderUsesIntroLayout()) ? 'min-h-full w-full flex-1 self-stretch bg-gray-50' : 'flex-1', campaignBuilderStep >= companySetupStartStep() && ! campaignSetupModeSelected ? 'w-full' : '']">
                <div x-ref="campaignBuilderContentScroll" class="min-w-0" :class="(campaignBuilderUsesSidebarLayout() || campaignBuilderUsesIntroLayout()) ? 'min-h-full w-full min-w-0 bg-gray-50' : 'flex-1 lg:pt-[78px]'">
                    @include('filament.pages.outreach.campaign-builder.company-details')


                    @include('filament.pages.outreach.campaign-builder.campaign-setup')
                </div>
                </div>
            </div>
        </section>
