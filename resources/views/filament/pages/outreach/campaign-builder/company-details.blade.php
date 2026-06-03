                    <div x-show="campaignBuilderStep < companySetupStartStep()" x-ref="companyDetailsFormStage" x-effect="campaignBuilderStep; companyForm.pronunciationEnabled; updateCampaignBuilderStickyLayout(); updateCampaignBuilderBottomPadding()" data-campaign-builder-content-shell class="relative w-full [overflow-anchor:none] lg:flex lg:flex-col" :style="`padding-bottom: ${campaignBuilderBottomPadding}px;`">
                        <section
                            x-cloak
                            x-show="campaignBuilderStep === 0 || campaignBuilderScrollFromStep === 0"
                            x-ref="companyChooseSection"
                            :style="campaignBuilderCompanyStepStyle(0)"
                            class="space-y-7 pr-2 pb-14"
                        >
                            <div data-company-details-step-layout class="grid grid-cols-1 gap-x-8 gap-y-10 md:grid-cols-3">
                                <div>
                                    <span class="mb-4 flex size-10 items-center justify-center rounded-md bg-indigo-50 text-indigo-600">
                                        <span class="outcraft-icon !text-[21px]" x-text="companySetupStepIcon(0)"></span>
                                    </span>
                                    <h2 class="text-base/7 font-semibold text-gray-900">Create or Choose Company</h2>
                                    <p class="mt-1 text-sm/6 text-gray-500">Choose an existing company profile or create a new one before setting up campaigns.</p>
                                </div>

                                <div class="md:col-span-2">
                                    <div class="space-y-3">
                                        <template x-for="company in companySetupDemoCompanies" :key="company.id">
                                            <button
                                                type="button"
                                                x-on:click="chooseExistingCompanyForSetup(company.id)"
                                                class="flex w-full items-center gap-4 rounded-lg bg-white p-4 text-left shadow-sm outline outline-1 -outline-offset-1 outline-gray-300 transition hover:outline-2 hover:-outline-offset-2 hover:outline-indigo-600 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
                                            >
                                                <span data-icon-tile class="flex size-10 shrink-0 items-center justify-center rounded-md bg-indigo-50 text-sm font-bold text-indigo-600" x-text="company.name.slice(0, 1)"></span>
                                                <span class="min-w-0">
                                                    <span class="block text-sm font-semibold leading-6 text-gray-950" x-text="company.name"></span>
                                                    <span class="block text-sm leading-6 text-gray-500" x-text="company.website"></span>
                                                </span>
                                            </button>
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
                                                <span class="block text-sm font-semibold leading-6 text-gray-950">Create New Company</span>
                                                <span class="block text-sm leading-6 text-gray-500">Start a fresh company profile for this campaign setup.</span>
                                            </span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </section>

                        <section
                            x-cloak
                            x-show="campaignBuilderStep === 1 || campaignBuilderScrollFromStep === 1"
                            x-ref="companyIdentitySection"
                            :style="campaignBuilderCompanyStepStyle(1)"
                            class="space-y-7 pr-2 pb-14"
                        >
                            <div data-company-details-step-layout class="grid grid-cols-1 gap-x-8 gap-y-10 md:grid-cols-3">
                                <div>
                                    <span class="mb-4 flex size-10 items-center justify-center rounded-md bg-indigo-50 text-indigo-600">
                                        <span class="outcraft-icon !text-[21px]" x-text="companySetupStepIcon(1)"></span>
                                    </span>
                                    <h2 class="text-base/7 font-semibold text-gray-900">Add Basic Company Details</h2>
                                    <p class="mt-1 text-sm/6 text-gray-500">This helps the AI understand who the company is, what it offers, and how to talk about it accurately in conversations.</p>
                                </div>

                                <form x-on:submit.prevent="submitCampaignBuilderStep(1)" novalidate class="md:col-span-2">
                                    <fieldset :disabled="campaignBuilderStep !== 1" data-card-surface class="rounded-lg border border-gray-200 bg-white p-5 sm:p-6">
                                        <div class="grid w-full grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                                        <div class="sm:col-span-3">
                                            <label class="block text-sm/6 font-medium text-gray-900">Brand Name<span class="text-indigo-400">*</span></label>
                                            <input data-campaign-field="name" x-model="companyForm.name" x-on:input="clearCampaignBuilderError('name')" :aria-invalid="Boolean(campaignBuilderErrors.name)" required type="text" placeholder="Enter the name leads will recognise" class="mt-2 block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline outline-1 -outline-offset-1 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 disabled:bg-gray-50 disabled:text-gray-500 sm:text-sm/6" :class="campaignBuilderErrors.name ? 'outline-red-300 focus:outline-red-600' : 'outline-gray-300'">
                                            <p x-show="campaignBuilderErrors.name" x-text="campaignBuilderErrors.name" class="mt-2 text-sm/6 text-red-600"></p>
                                        </div>

                                        <div class="sm:col-span-3">
                                            <label class="block text-sm/6 font-medium text-gray-900">Brand Website<span class="text-indigo-400">*</span></label>
                                            <input data-campaign-field="website" x-model="companyForm.website" x-on:input="clearCampaignBuilderError('website')" :aria-invalid="Boolean(campaignBuilderErrors.website)" required type="text" placeholder="https://example.com" class="mt-2 block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline outline-1 -outline-offset-1 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 disabled:bg-gray-50 disabled:text-gray-500 sm:text-sm/6" :class="campaignBuilderErrors.website ? 'outline-red-300 focus:outline-red-600' : 'outline-gray-300'">
                                            <p x-show="campaignBuilderErrors.website" x-text="campaignBuilderErrors.website" class="mt-2 text-sm/6 text-red-600"></p>
                                        </div>

                                        <div class="col-span-full">
                                            <div class="flex items-center justify-between gap-4">
                                                <span class="flex grow flex-col">
                                                    <label id="brand-pronunciation-toggle-label" class="text-sm/6 font-medium text-gray-900">Add pronunciation guide</label>
                                                    <span id="brand-pronunciation-toggle-description" class="text-sm/6 text-gray-500">Useful for voice calls or names that are often mispronounced.</span>
                                                </span>
                                                <button
                                                    id="brand-pronunciation-toggle"
                                                    type="button"
                                                    role="switch"
                                                    x-on:click="companyForm.pronunciationEnabled = ! companyForm.pronunciationEnabled"
                                                    :aria-checked="companyForm.pronunciationEnabled.toString()"
                                                    aria-labelledby="brand-pronunciation-toggle-label"
                                                    aria-describedby="brand-pronunciation-toggle-description"
                                                    class="relative inline-flex h-6 w-11 shrink-0 cursor-pointer rounded-full p-0.5 outline-offset-2 transition-colors duration-200 ease-in-out focus-visible:outline-2 focus-visible:outline-indigo-600"
                                                    :class="companyForm.pronunciationEnabled ? 'bg-indigo-600' : 'bg-gray-200'"
                                                >
                                                    <span
                                                        aria-hidden="true"
                                                        class="size-5 rounded-full bg-white shadow-sm ring-1 ring-gray-900/5 transition-transform duration-200 ease-in-out"
                                                        :class="companyForm.pronunciationEnabled ? 'translate-x-5' : 'translate-x-0'"
                                                    ></span>
                                                </button>
                                            </div>

                                            <label x-show="companyForm.pronunciationEnabled" x-transition.opacity class="mt-5 block">
                                                <span class="block text-sm/6 font-medium text-gray-900">Pronunciation</span>
                                                <input x-model="companyForm.pronunciation" type="text" placeholder="e.g. Goo-guhl, Nigh-kee, Ah-dee-das" class="mt-2 block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 disabled:bg-gray-50 disabled:text-gray-500 sm:text-sm/6">
                                            </label>
                                        </div>
                                        </div>
                                    </fieldset>
                                    <div x-show="campaignBuilderStep === 1" data-campaign-step-actions class="hidden">
                                        <button type="submit" class="inline-flex items-center gap-2 rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Continue<span class="outcraft-icon !text-[18px]">arrow_downward</span></button>
                                    </div>
                                </form>
                            </div>
                        </section>

                        <section
                            x-cloak
                            x-show="campaignBuilderStep === 2 || campaignBuilderScrollFromStep === 2"
                            x-ref="industryMarketSection"
                            :style="campaignBuilderCompanyStepStyle(2)"
                            data-company-details-step-layout
                            class="grid grid-cols-1 gap-x-8 gap-y-10 pr-2 pb-14 md:grid-cols-3"
                        >
                            <div>
                                <div data-step-icon-row>
                                    <span class="flex size-10 items-center justify-center rounded-md bg-indigo-50 text-indigo-600">
                                        <span class="outcraft-icon !text-[21px]" x-text="companySetupStepIcon(2)"></span>
                                    </span>
                                </div>
                                <h2 class="text-base/7 font-semibold text-gray-900">Industry & Market</h2>
                                <p class="mt-1 text-sm/6 text-gray-500">Market context, customer profile, differentiators, and FAQs for campaign reasoning.</p>
                            </div>

                            <form x-on:submit.prevent="submitCampaignBuilderStep(2)" novalidate class="md:col-span-2">
                                <div class="mb-5 flex justify-start">
                                    <button type="button" :disabled="campaignBuilderStep !== 2" data-company-step-ai-action class="outcraft-ai-button inline-flex h-9 shrink-0 items-center justify-center gap-2 rounded-md border-2 border-transparent px-3 text-sm font-semibold text-gray-900 shadow-sm transition hover:text-gray-900 disabled:cursor-not-allowed disabled:text-gray-500 disabled:opacity-50">
                                        <svg class="outcraft-ai-sparkles" viewBox="0 0 105 103" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                            <path d="M31.6876 33.3482C33.0533 28.4835 39.9496 28.4835 41.3154 33.3482L44.4257 44.4273C46.3112 51.1432 51.5595 56.3915 58.2754 58.277L69.3545 61.3873C74.2192 62.7531 74.2192 69.6494 69.3545 71.0151L58.2754 74.1255C51.5595 76.0109 46.3112 81.2593 44.4257 87.9752L41.3154 99.0543C39.9496 103.919 33.0533 103.919 31.6876 99.0543L28.5772 87.9752C26.6918 81.2593 21.4434 76.0109 14.7275 74.1255L3.64844 71.0151C-1.21627 69.6494 -1.21627 62.7531 3.64844 61.3873L14.7275 58.277C21.4434 56.3915 26.6918 51.1432 28.5772 44.4273L31.6876 33.3482Z"/>
                                            <path d="M77.1504 2.91881C78.2429 -0.972965 83.76 -0.972956 84.8526 2.91881L87.046 10.7318C87.9887 14.0898 90.6129 16.714 93.9709 17.6567L101.784 19.8501C105.676 20.9427 105.676 26.4598 101.784 27.5523L93.9709 29.7458C90.6129 30.6885 87.9887 33.3127 87.046 36.6706L84.8526 44.4837C83.76 48.3754 78.2429 48.3754 77.1504 44.4837L74.9569 36.6706C74.0142 33.3127 71.39 30.6885 68.0321 29.7458L60.219 27.5523C56.3273 26.4598 56.3273 20.9427 60.219 19.8501L68.0321 17.6567C71.39 16.714 74.0142 14.0898 74.9569 10.7318L77.1504 2.91881Z"/>
                                        </svg>
                                        Fill with AI
                                    </button>
                                </div>
                                <fieldset :disabled="campaignBuilderStep !== 2" data-card-surface class="rounded-lg border border-gray-200 bg-white p-5 sm:p-6">
                                    <div class="grid w-full grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                                        <div class="sm:col-span-3" x-data="{ industryOpen: false, industries: ['SaaS', 'Ecommerce', 'Healthcare', 'Financial Services', 'Consumer Services'] }" x-on:keydown.escape.window="industryOpen = false" x-on:click.outside="industryOpen = false">
                                            <label class="block text-sm/6 font-medium text-gray-900">Industry Vertical<span class="text-indigo-400">*</span></label>
                                            <div class="relative mt-2">
                                                <button
                                                    type="button"
                                                    data-campaign-field="industry"
                                                    x-on:click="industryOpen = ! industryOpen"
                                                    :aria-expanded="industryOpen.toString()"
                                                    :aria-invalid="Boolean(campaignBuilderErrors.industry)"
                                                    class="relative block h-9 w-full rounded-md bg-white py-1.5 pr-8 pl-3 text-left text-sm/6 text-gray-900 outline outline-1 -outline-offset-1 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 disabled:bg-gray-50 disabled:text-gray-500"
                                                    :class="campaignBuilderErrors.industry ? 'outline-red-300 focus:outline-red-600' : 'outline-gray-300'"
                                                >
                                                    <span class="block truncate" :class="companyForm.industry ? 'text-gray-900' : 'text-gray-400'" x-text="companyForm.industry || 'Select Your Industry Vertical'"></span>
                                                    <span class="outcraft-icon pointer-events-none absolute right-2 top-1/2 -translate-y-1/2 !text-[16px] text-gray-400">keyboard_arrow_down</span>
                                                </button>
                                                <div
                                                    x-cloak
                                                    x-show="industryOpen"
                                                    x-transition:enter="transition ease-out duration-100"
                                                    x-transition:enter-start="opacity-0 translate-y-3"
                                                    x-transition:enter-end="opacity-100 translate-y-0"
                                                    x-transition:leave="transition ease-in duration-75"
                                                    x-transition:leave-start="opacity-100 translate-y-0"
                                                    x-transition:leave-end="opacity-0 translate-y-2"
                                                    class="absolute z-30 mt-2 max-h-60 w-full overflow-auto rounded-md bg-white py-1 text-sm shadow-lg ring-1 ring-gray-900/5 focus:outline-none"
                                                >
                                                    <template x-for="industry in industries" :key="industry">
                                                        <button
                                                            type="button"
                                                            x-on:click="companyForm.industry = industry; clearCampaignBuilderError('industry'); industryOpen = false"
                                                            class="flex w-full items-center justify-between px-3 py-2 text-left text-gray-900 transition hover:bg-indigo-50 hover:text-indigo-700"
                                                            :class="companyForm.industry === industry ? 'bg-indigo-50 text-indigo-700' : ''"
                                                        >
                                                            <span class="truncate" x-text="industry"></span>
                                                            <span x-show="companyForm.industry === industry" class="outcraft-icon !text-[16px]">check</span>
                                                        </button>
                                                    </template>
                                                </div>
                                            </div>
                                            <p x-show="campaignBuilderErrors.industry" x-text="campaignBuilderErrors.industry" class="mt-2 text-sm/6 text-red-600"></p>
                                        </div>

                                        <div class="col-span-full">
                                            <label class="block text-sm/6 font-medium text-gray-900">Company Description<span class="text-indigo-400">*</span></label>
                                            <textarea data-campaign-field="description" x-model="companyForm.description" x-on:input="clearCampaignBuilderError('description')" :aria-invalid="Boolean(campaignBuilderErrors.description)" required rows="4" class="mt-2 block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline outline-1 -outline-offset-1 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 disabled:bg-gray-50 disabled:text-gray-500 sm:text-sm/6" :class="campaignBuilderErrors.description ? 'outline-red-300 focus:outline-red-600' : 'outline-gray-300'" placeholder="Describe what your company does, who you serve, and the main value your product or service creates."></textarea>
                                            <p x-show="campaignBuilderErrors.description" x-text="campaignBuilderErrors.description" class="mt-2 text-sm/6 text-red-600"></p>
                                        </div>

                                        <div class="col-span-full">
                                            <label class="block text-sm/6 font-medium text-gray-900">Problem You Solve</label>
                                            <textarea x-model="companyForm.problem" rows="5" class="mt-2 block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 disabled:bg-gray-50 disabled:text-gray-500 sm:text-sm/6" placeholder="Describe the pain points, needs, or jobs your customers come to you for."></textarea>
                                        </div>

                                        <div class="col-span-full">
                                            <label class="block text-sm/6 font-medium text-gray-900">Benefits Over Competitors (Differentiators)</label>
                                            <textarea x-model="companyForm.differentiators" rows="6" class="mt-2 block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 disabled:bg-gray-50 disabled:text-gray-500 sm:text-sm/6" placeholder="List the main reasons customers choose you over alternatives."></textarea>
                                        </div>

                                        <div class="col-span-full">
                                            <label class="block text-sm/6 font-medium text-gray-900">Ideal Customer Profile</label>
                                            <textarea x-model="companyForm.icp" rows="5" class="mt-2 block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 disabled:bg-gray-50 disabled:text-gray-500 sm:text-sm/6" placeholder="Describe the buyer types, segments, company sizes, regions, and common needs."></textarea>
                                        </div>

                                        <div class="col-span-full">
                                            <label class="block text-sm/6 font-medium text-gray-900">Frequently Asked Questions (FAQs)</label>
                                            <textarea x-model="companyForm.faqs" rows="9" class="mt-2 block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 disabled:bg-gray-50 disabled:text-gray-500 sm:text-sm/6" placeholder="Q: What is your pricing model?&#10;A: ...&#10;&#10;Q: Do you offer a free trial?&#10;A: ..."></textarea>
                                        </div>
                                    </div>
                                </fieldset>
                                <div x-show="campaignBuilderStep === 2" data-campaign-step-actions class="hidden">
                                    <button type="button" x-on:click="previousCampaignBuilderStep()" class="inline-flex items-center gap-2 text-sm font-semibold leading-6 text-gray-900"><span class="outcraft-icon !text-[18px]">arrow_upward</span>Previous step</button>
                                    <button type="submit" class="inline-flex items-center gap-2 rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Continue<span class="outcraft-icon !text-[18px]">arrow_downward</span></button>
                                </div>
                            </form>
                        </section>

                        <section
                            x-cloak
                            x-show="campaignBuilderStep === 3 || campaignBuilderScrollFromStep === 3"
                            x-ref="complianceLegalSection"
                            :style="campaignBuilderCompanyStepStyle(3)"
                            data-company-details-step-layout
                            class="grid grid-cols-1 gap-x-8 gap-y-10 pr-2 pb-14 md:grid-cols-3"
                        >
                            <div>
                                <div data-step-icon-row>
                                    <span class="flex size-10 items-center justify-center rounded-md bg-indigo-50 text-indigo-600">
                                        <span class="outcraft-icon !text-[21px]" x-text="companySetupStepIcon(3)"></span>
                                    </span>
                                </div>
                                <h2 class="text-base/7 font-semibold text-gray-900">Compliance & Legal</h2>
                                <p class="mt-1 text-sm/6 text-gray-500">Support and policy details the agent can reference or route to.</p>
                            </div>

                            <form x-on:submit.prevent="submitCampaignBuilderStep(3)" novalidate class="md:col-span-2">
                                <div class="mb-5 flex justify-start">
                                    <button type="button" :disabled="campaignBuilderStep !== 3" data-company-step-ai-action class="outcraft-ai-button inline-flex h-9 shrink-0 items-center justify-center gap-2 rounded-md border-2 border-transparent px-3 text-sm font-semibold text-gray-900 shadow-sm transition hover:text-gray-900 disabled:cursor-not-allowed disabled:text-gray-500 disabled:opacity-50">
                                        <svg class="outcraft-ai-sparkles" viewBox="0 0 105 103" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                            <path d="M31.6876 33.3482C33.0533 28.4835 39.9496 28.4835 41.3154 33.3482L44.4257 44.4273C46.3112 51.1432 51.5595 56.3915 58.2754 58.277L69.3545 61.3873C74.2192 62.7531 74.2192 69.6494 69.3545 71.0151L58.2754 74.1255C51.5595 76.0109 46.3112 81.2593 44.4257 87.9752L41.3154 99.0543C39.9496 103.919 33.0533 103.919 31.6876 99.0543L28.5772 87.9752C26.6918 81.2593 21.4434 76.0109 14.7275 74.1255L3.64844 71.0151C-1.21627 69.6494 -1.21627 62.7531 3.64844 61.3873L14.7275 58.277C21.4434 56.3915 26.6918 51.1432 28.5772 44.4273L31.6876 33.3482Z"/>
                                            <path d="M77.1504 2.91881C78.2429 -0.972965 83.76 -0.972956 84.8526 2.91881L87.046 10.7318C87.9887 14.0898 90.6129 16.714 93.9709 17.6567L101.784 19.8501C105.676 20.9427 105.676 26.4598 101.784 27.5523L93.9709 29.7458C90.6129 30.6885 87.9887 33.3127 87.046 36.6706L84.8526 44.4837C83.76 48.3754 78.2429 48.3754 77.1504 44.4837L74.9569 36.6706C74.0142 33.3127 71.39 30.6885 68.0321 29.7458L60.219 27.5523C56.3273 26.4598 56.3273 20.9427 60.219 19.8501L68.0321 17.6567C71.39 16.714 74.0142 14.0898 74.9569 10.7318L77.1504 2.91881Z"/>
                                        </svg>
                                        Fill with AI
                                    </button>
                                </div>
                                <fieldset :disabled="campaignBuilderStep !== 3">
                                    <div class="grid w-full grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                                        <div class="col-span-full rounded-lg border border-gray-200 bg-white p-5 sm:p-6">
                                            <div class="grid grid-cols-1 gap-x-6 gap-y-6 sm:grid-cols-6">
                                                <div class="sm:col-span-4">
                                                    <label class="block text-sm/6 font-medium text-gray-900">Support Email</label>
                                                    <input x-model="companyForm.supportEmail" type="email" placeholder="support@example.com" class="mt-2 block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 disabled:bg-gray-50 disabled:text-gray-500 sm:text-sm/6">
                                                    <p class="mt-2 text-sm leading-6 text-gray-500">Human support email.</p>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-span-full rounded-lg border border-gray-200 bg-white p-5 sm:p-6">
                                            <div class="grid grid-cols-1 gap-x-6 gap-y-6 sm:grid-cols-6">
                                                <div class="col-span-full">
                                                    <label class="block text-sm/6 font-medium text-gray-900">Terms of Service Page</label>
                                                    <input x-model="companyForm.termsUrl" type="url" placeholder="https://example.com/terms-of-service" class="mt-2 block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 disabled:bg-gray-50 disabled:text-gray-500 sm:text-sm/6">
                                                    <p class="mt-2 text-sm leading-6 text-gray-500">Link to your terms of service or user agreement page.</p>
                                                </div>

                                                <div class="col-span-full">
                                                    <label class="block text-sm/6 font-medium text-gray-900">Privacy Policy Page</label>
                                                    <input x-model="companyForm.privacyUrl" type="url" placeholder="https://example.com/privacy-policy" class="mt-2 block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 disabled:bg-gray-50 disabled:text-gray-500 sm:text-sm/6">
                                                    <p class="mt-2 text-sm leading-6 text-gray-500">Link to your privacy policy or legal compliance page.</p>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-span-full rounded-lg border border-gray-200 bg-white p-5 sm:p-6">
                                            <div class="grid grid-cols-1 gap-x-6 gap-y-6 sm:grid-cols-6">
                                                <div class="col-span-full">
                                                    <label class="block text-sm/6 font-medium text-gray-900">Certifications</label>
                                                    <input x-model="companyForm.certifications" type="text" placeholder="SOC2, ISO 27001, HIPAA" class="mt-2 block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 disabled:bg-gray-50 disabled:text-gray-500 sm:text-sm/6">
                                                    <p class="mt-2 text-sm leading-6 text-gray-500">List any relevant certifications your company holds.</p>
                                                </div>

                                                <div class="col-span-full">
                                                    <label class="block text-sm/6 font-medium text-gray-900">Compliance</label>
                                                    <input x-model="companyForm.compliance" type="text" placeholder="GDPR, CCPA, HIPAA" class="mt-2 block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 disabled:bg-gray-50 disabled:text-gray-500 sm:text-sm/6">
                                                    <p class="mt-2 text-sm leading-6 text-gray-500">List any relevant compliance standards your company adheres to.</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </fieldset>
                                <div x-show="campaignBuilderStep === 3" data-campaign-step-actions class="hidden">
                                    <button type="button" x-on:click="previousCampaignBuilderStep()" class="inline-flex items-center gap-2 text-sm font-semibold leading-6 text-gray-900"><span class="outcraft-icon !text-[18px]">arrow_upward</span>Previous step</button>
                                    <button type="submit" class="inline-flex items-center gap-2 rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Continue<span class="outcraft-icon !text-[18px]">arrow_forward</span></button>
                                </div>
                            </form>
                        </section>

                        <div x-show="campaignBuilderStep > 0 && campaignBuilderStep < companySetupStartStep()" class="fixed inset-x-0 bottom-0 z-40 mt-auto hidden border-t border-gray-200 bg-white/95 py-4 backdrop-blur lg:flex" :style="campaignBuilderActionBarStyle">
                            <div class="flex w-full items-center justify-between gap-3" :style="campaignBuilderActionBarContentStyle">
                                <button
                                    type="button"
                                    x-on:click="campaignBuilderRailBack()"
                                    class="inline-flex h-9 items-center gap-2 rounded-md px-2 text-sm font-semibold text-gray-600 transition hover:bg-gray-50 hover:text-gray-950"
                                >
                                    <span class="outcraft-icon !text-[18px]">arrow_upward</span>
                                    Previous step
                                </button>
                                <div class="flex min-w-0 items-center gap-3">
                                    <span x-show="campaignBuilderNextLabel()" class="hidden text-sm font-medium text-gray-500 sm:inline" x-text="`Next: ${campaignBuilderNextLabel()}`"></span>
                                    <button
                                        type="button"
                                        x-on:click="submitCampaignBuilderStep(campaignBuilderStep)"
                                        class="inline-flex h-9 items-center gap-2 rounded-md bg-indigo-600 px-3 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
                                    >
                                        <span x-text="campaignBuilderContinueLabel()"></span>
                                        <span class="outcraft-icon !text-[18px]" x-text="campaignBuilderStep === companySetupFinalStepIndex() ? 'arrow_forward' : 'arrow_downward'"></span>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div x-show="campaignBuilderStep > 0 && campaignBuilderStep < companySetupStartStep()" class="fixed inset-x-0 bottom-0 z-40 flex items-center justify-between gap-3 border-t border-gray-200 bg-white/95 px-4 py-3 backdrop-blur lg:hidden">
                            <button
                                type="button"
                                x-on:click="campaignBuilderRailBack()"
                                class="inline-flex h-10 items-center gap-2 rounded-md px-2 text-sm font-semibold text-gray-600 transition hover:bg-gray-50 hover:text-gray-950"
                            >
                                <span class="outcraft-icon !text-[18px]">arrow_upward</span>
                                Previous step
                            </button>
                            <button
                                type="button"
                                x-on:click="submitCampaignBuilderStep(campaignBuilderStep)"
                                class="inline-flex h-10 min-w-0 items-center gap-2 rounded-md bg-indigo-600 px-3 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-500"
                            >
                                <span class="truncate" x-text="campaignBuilderMobileContinueLabel()"></span>
                                <span class="outcraft-icon !text-[18px]" x-text="campaignBuilderStep === companySetupFinalStepIndex() ? 'arrow_forward' : 'arrow_downward'"></span>
                            </button>
                        </div>
                    </div>
