        <section x-cloak x-show="campaignBuilderOpen" data-campaign-builder class="relative min-h-full w-full" :class="(campaignBuilderUsesSidebarLayout() || campaignBuilderUsesIntroLayout()) ? '!m-0 bg-gray-50' : 'mx-6 mb-6 mt-6 bg-white'">
            <div
                x-cloak
                x-show="campaignBuilderTransitioning"
                x-transition.opacity
                class="fixed inset-0 z-[70] flex items-center justify-center bg-white"
            >
                <div class="flex flex-col items-center gap-4">
                    <div data-card-ignore class="flex size-[56px] items-center justify-center" x-html="tableLoaderSvg()"></div>
                    <p class="text-sm font-medium text-gray-500" x-text="campaignBuilderTransitionLabel"></p>
                </div>
            </div>

            <div x-show="! campaignBuilderUsesIntroLayout() && (campaignBuilderStep < companySetupStartStep() || campaignSetupModeSelected)" class="border-b border-gray-200 bg-gray-50 px-4 py-3 lg:hidden">
                <div class="h-2 overflow-hidden rounded-full bg-gray-200" role="progressbar" aria-label="Campaign setup progress" :aria-valuenow="campaignBuilderMobileProgressPercent()" aria-valuemin="0" aria-valuemax="100">
                    <div class="h-full rounded-full oc-primary-bg transition-all duration-300 ease-out" :style="`width: ${campaignBuilderMobileProgressPercent()}%`"></div>
                </div>
            </div>

            <div x-ref="campaignBuilderScrollScene" :style="campaignBuilderScrollSceneStyle()" class="relative flex w-full items-start" :class="campaignBuilderUsesSidebarLayout() ? 'mx-0 min-h-full min-w-full max-w-none gap-0 bg-gray-50' : (campaignBuilderUsesIntroLayout() ? 'mx-0 min-h-full max-w-none bg-gray-50 px-4 py-6 sm:px-6 lg:px-8' : 'mx-auto max-w-7xl gap-12 xl:gap-16')">
                <aside x-ref="campaignBuilderProgressAside" x-show="! campaignBuilderUsesIntroLayout() && (campaignBuilderStep < companySetupStartStep() || campaignSetupModeSelected)" class="hidden shrink-0 lg:block" :class="[campaignBuilderUsesIntroLayout() ? '!hidden' : '', campaignBuilderUsesSidebarLayout() ? 'min-h-screen w-80 border-r border-gray-200 bg-white px-8 py-6' : 'w-72']" :style="campaignBuilderProgressStickyStyle()">
                    <div class="flex min-h-[calc(100vh-3rem)] flex-col">
                    <div x-ref="campaignBuilderProgressColumn" class="flex-1">
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

                    <div x-show="campaignBuilderStep >= companySetupStartStep() && campaignSetupModeSelected" class="mb-8 space-y-4 border-b border-gray-200 pb-6">
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-wide text-gray-400">Campaign Objective</p>
                            <p class="mt-1 truncate text-sm font-semibold leading-6 text-gray-950" x-text="campaignSetup.type || 'Not selected'"></p>
                        </div>
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-wide text-gray-400">Lead Source</p>
                            <p class="mt-1 truncate text-sm font-semibold leading-6 text-gray-950" x-text="campaignSetup.source || 'Not selected'"></p>
                        </div>
                    </div>

                    <nav x-show="campaignBuilderStep >= companySetupStartStep() && campaignSetupModeSelected && progressBarStyle === 'timeline'" aria-label="Campaign setup progress" class="space-y-5">
                        <ol role="list" class="space-y-4">
                            <template x-for="(step, index) in campaignSetupPrimaryTimelineSteps()" :key="step.id">
                                <li class="relative flex gap-4">
                                    <span x-show="index !== campaignSetupPrimaryTimelineSteps().length - 1" class="absolute left-[15px] top-0 -bottom-8 w-0.5" :class="campaignSetupStatus(step.id) === 'done' ? 'oc-primary-bg' : 'bg-gray-200'"></span>
                                    <div class="relative flex min-w-0 flex-1 items-start gap-2">
                                        <button type="button" x-on:click="setCampaignSetupStep(step.id)" class="group flex min-w-0 flex-1 items-start gap-4 text-left">
                                            <span class="flex h-9 items-center" x-html="campaignSetupStatusIcon(step.id, campaignSetupStepNumber(step.id))"></span>
                                            <span class="min-w-0 pt-1">
                                                <span class="block text-sm font-semibold leading-6" :class="campaignSetup.current === step.id ? 'oc-primary-text' : 'text-gray-950'" x-text="step.label"></span>
                                                <span class="block text-sm leading-5 text-gray-500" x-text="step.id === 'followups' ? followupLayoutOptionLabel() : step.description"></span>
                                            </span>
                                        </button>
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
                    <div x-show="campaignBuilderStep >= companySetupStartStep() && campaignSetupModeSelected && ! onboardingCampaignFlow" class="-mb-6 mt-auto flex h-[69px] items-center">
                        <button type="button" x-on:click="openCampaignCancelConfirm()" class="inline-flex h-9 items-center rounded-md px-2 text-sm font-semibold text-gray-600 transition hover:bg-gray-50 hover:text-gray-950 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                            Cancel Setup
                        </button>
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
