        <section x-cloak x-show="! campaignBuilderOpen && activeNav === 'Brands' && ! brandPageInlineEditorOpen && ! brandPageWizardOpen" class="mx-6 mt-5">
            <div class="flex min-h-[54px] items-start justify-between gap-x-6">
                <div>
                    <h1 class="text-xl font-bold leading-tight text-gray-950">Brands</h1>
                    <p class="mt-1 max-w-2xl text-sm/6 text-gray-500">Reusable company profiles for campaigns, agent context, and legal references.</p>
                </div>
            </div>
        </section>

        <section x-cloak x-show="! campaignBuilderOpen && activeNav === 'Brands' && ! brandPageInlineEditorOpen && ! brandPageWizardOpen" class="mx-6 mb-6 mt-4 max-w-4xl space-y-4">
            <div class="space-y-3">
                <template x-for="company in campaignBuilderCompanyOptions()" :key="`brand-page-company-${company.id}`">
                    <div class="oc-selectable-card group flex w-full items-center gap-3 rounded-lg bg-white p-4 text-left shadow-sm outline outline-1 -outline-offset-1 outline-gray-300 transition hover:outline-2 hover:-outline-offset-2 hover:outline-indigo-600">
                        <button
                            type="button"
                            x-on:click="openBrandPageInlineEditor(company)"
                            class="flex min-w-0 flex-1 items-center gap-4 text-left focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
                        >
                            <span data-icon-tile class="flex size-10 shrink-0 items-center justify-center rounded-md bg-indigo-50 text-sm font-bold text-indigo-600" x-text="brandInitials(company.name)"></span>
                            <span class="min-w-0">
                                <span class="block truncate text-sm font-semibold leading-6 text-gray-950" x-text="company.name"></span>
                                <span class="block truncate text-sm leading-6 text-gray-500" x-text="company.website"></span>
                            </span>
                        </button>
                        <button
                            type="button"
                            x-on:click.stop="openBrandPageInlineEditor(company)"
                            class="relative z-10 inline-flex h-9 shrink-0 items-center justify-center rounded-md bg-white px-3 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 transition hover:bg-gray-50 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
                        >
                            Edit
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
	                                    x-on:click.stop="actionsOpen = false; openBrandPageInlineEditor(company)"
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

	                <div class="oc-selectable-card flex w-full items-center gap-4 rounded-lg bg-white p-4 text-left shadow-sm outline outline-1 -outline-offset-1 outline-gray-300 transition hover:outline-2 hover:-outline-offset-2 hover:outline-indigo-600">
	                    <button
	                        type="button"
	                        x-on:click="openBrandCreateModal()"
	                        class="flex min-w-0 flex-1 items-center gap-4 text-left focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
	                    >
	                        <span class="flex size-10 shrink-0 items-center justify-center rounded-md oc-primary-bg text-white">
	                            <span class="outcraft-icon !text-[20px] text-white">plus</span>
	                        </span>
	                        <span class="min-w-0">
	                            <span class="block text-sm font-semibold leading-6 text-gray-950">Create New Brand</span>
	                            <span class="block text-sm leading-6 text-gray-500">Start a fresh company profile for campaigns and AI agents.</span>
	                        </span>
	                    </button>
	                    <button
	                        type="button"
	                        x-on:click.stop="openBrandPageInlineEditor()"
	                        class="relative z-10 inline-flex h-9 shrink-0 items-center justify-center rounded-md bg-white px-3 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 transition hover:bg-gray-50 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
	                    >
	                        Create New #2
	                    </button>
	                    <button
	                        type="button"
	                        x-on:click.stop="openBrandPageWizard()"
	                        class="relative z-10 inline-flex h-9 shrink-0 items-center justify-center rounded-md bg-white px-3 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 transition hover:bg-gray-50 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
	                    >
	                        Create Brand #3
	                    </button>
	                </div>
	            </div>
	        </section>

	        <section
	            x-cloak
	            x-show="! campaignBuilderOpen && activeNav === 'Brands' && brandPageInlineEditorOpen"
	            x-transition.opacity
	            class="mx-6 mb-10 mt-5"
	        >
	            <div class="mx-auto max-w-3xl space-y-6">
	                <button
	                    type="button"
	                    x-on:click="closeBrandPageInlineEditor()"
	                    class="inline-flex items-center gap-2 text-sm font-semibold leading-6 text-gray-700 transition hover:text-gray-950 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
	                >
	                    <span class="outcraft-icon !text-[20px] text-gray-500">arrow_back</span>
	                    Back
	                </button>

	                <section class="rounded-lg border border-gray-200 bg-white p-5 shadow-sm">
	                    <div class="flex items-start gap-3">
	                        <span class="flex size-10 shrink-0 items-center justify-center rounded-md bg-indigo-50 text-indigo-600">
	                            <span class="outcraft-icon !text-[22px]">briefcase_business</span>
	                        </span>
	                        <div class="min-w-0">
	                            <h2 class="text-base font-semibold leading-6 text-gray-950">Brand Details</h2>
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
	                                <button type="button" role="switch" x-on:click.stop="campaignDetailBrandInlineForm.pronunciationEnabled = ! campaignDetailBrandInlineForm.pronunciationEnabled" :aria-checked="campaignDetailBrandInlineForm.pronunciationEnabled.toString()" class="relative inline-flex h-6 w-11 shrink-0 cursor-pointer rounded-full p-0.5 outline-offset-2 transition-colors duration-200 ease-in-out focus-visible:outline-2 focus-visible:outline-indigo-600" :class="campaignDetailBrandInlineForm.pronunciationEnabled ? 'bg-indigo-600' : 'bg-gray-200'">
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
	                            x-on:click.stop="saveBrandPageInlineSection('Brand Details', 'details')"
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
	                            <h2 class="text-base font-semibold leading-6 text-gray-950">Industry & Market</h2>
	                            <p class="mt-1 text-sm leading-6 text-gray-500">Positioning, customer profile, differentiators, and FAQs.</p>
	                        </div>
	                    </div>

	                    <div class="mt-6 flex justify-start">
	                        <button type="button" data-company-step-ai-action class="outcraft-ai-button inline-flex h-9 shrink-0 items-center justify-center gap-2 rounded-md border-2 border-transparent px-3 text-sm font-semibold text-gray-900 shadow-sm transition hover:text-gray-900">
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
	                            x-on:click.stop="saveBrandPageInlineSection('Industry & Market', 'industry')"
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
	                            <h2 class="text-base font-semibold leading-6 text-gray-950">Compliance & Legal</h2>
	                            <p class="mt-1 text-sm leading-6 text-gray-500">Support contacts, terms, privacy, and compliance notes.</p>
	                        </div>
	                    </div>

	                    <div class="mt-6 flex justify-start">
	                        <button type="button" data-company-step-ai-action class="outcraft-ai-button inline-flex h-9 shrink-0 items-center justify-center gap-2 rounded-md border-2 border-transparent px-3 text-sm font-semibold text-gray-900 shadow-sm transition hover:text-gray-900">
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
	                            x-on:click.stop="saveBrandPageInlineSection('Compliance & Legal', 'compliance')"
	                            class="inline-flex h-10 items-center justify-center rounded-md bg-indigo-600 px-4 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
	                        >
	                            Save
	                        </button>
	                    </div>
	                </section>
	            </div>
	        </section>

	        <section
	            x-cloak
	            x-show="! campaignBuilderOpen && activeNav === 'Brands' && brandPageWizardOpen"
	            x-transition.opacity
	            class="mx-6 mb-10 mt-5"
	        >
	            <div class="mx-auto max-w-3xl space-y-8">
	                <button
	                    type="button"
	                    x-on:click="closeBrandPageWizard()"
	                    class="inline-flex items-center gap-2 text-sm font-semibold leading-6 text-gray-700 transition hover:text-gray-950 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
	                >
	                    <span class="outcraft-icon !text-[20px] text-gray-500">arrow_back</span>
	                    Back
	                </button>

	                <div class="space-y-6">
	                    <div class="flex items-start gap-4">
	                        <span class="flex size-10 shrink-0 items-center justify-center rounded-md bg-indigo-50 text-indigo-600">
	                            <span class="outcraft-icon !text-[22px]">briefcase_business</span>
	                        </span>
	                        <div class="min-w-0">
	                            <h1 class="text-xl font-bold leading-tight text-gray-950">Create New Brand</h1>
	                            <p class="mt-1 max-w-2xl text-sm/6 text-gray-500">Build the reusable company profile campaigns and AI agents can reference.</p>
	                        </div>
	                    </div>

	                    <nav aria-label="Brand setup progress">
	                        <ol role="list" class="divide-y divide-gray-300 rounded-md border border-gray-300 bg-white md:flex md:divide-y-0">
	                            <template x-for="(step, index) in brandProgressSteps()" :key="`brand-page-wizard-progress-${step.step}`">
	                                <li class="relative md:flex md:flex-1">
	                                    <button
	                                        type="button"
	                                        x-on:click="setBrandModalStep(step.step)"
	                                        :disabled="! brandCanNavigateToStep(step.step)"
	                                        :aria-current="brandModalStep === step.step ? 'step' : null"
	                                        class="group flex w-full items-center text-left disabled:cursor-not-allowed disabled:opacity-60"
	                                        :class="brandModalStep === step.step ? 'px-6 py-4 text-sm font-medium' : ''"
	                                    >
	                                        <span x-show="brandModalStep > step.step" class="flex items-center px-6 py-4 text-sm font-medium">
	                                            <span class="flex size-10 shrink-0 items-center justify-center rounded-full bg-indigo-600 group-hover:bg-indigo-800">
	                                                <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true" class="size-6 text-white">
	                                                    <path d="M19.916 4.626a.75.75 0 0 1 .208 1.04l-9 13.5a.75.75 0 0 1-1.154.114l-6-6a.75.75 0 0 1 1.06-1.06l5.353 5.353 8.493-12.74a.75.75 0 0 1 1.04-.207Z" clip-rule="evenodd" fill-rule="evenodd" />
	                                                </svg>
	                                            </span>
	                                            <span class="ml-4 truncate text-sm font-medium text-gray-900" x-text="step.label"></span>
	                                        </span>

	                                        <span x-show="brandModalStep === step.step" class="flex items-center text-sm font-medium">
	                                            <span class="flex size-10 shrink-0 items-center justify-center rounded-full border-2 border-indigo-600">
	                                                <span class="text-indigo-600" x-text="String(step.step).padStart(2, '0')"></span>
	                                            </span>
	                                            <span class="ml-4 truncate text-sm font-medium text-indigo-600" x-text="step.label"></span>
	                                        </span>

	                                        <span x-show="brandModalStep < step.step" class="flex items-center px-6 py-4 text-sm font-medium">
	                                            <span class="flex size-10 shrink-0 items-center justify-center rounded-full border-2 border-gray-300 group-hover:border-gray-400">
	                                                <span class="text-gray-500 group-hover:text-gray-900" x-text="String(step.step).padStart(2, '0')"></span>
	                                            </span>
	                                            <span class="ml-4 truncate text-sm font-medium text-gray-500 group-hover:text-gray-900" x-text="step.label"></span>
	                                        </span>
	                                    </button>

	                                    <div x-show="index !== brandProgressSteps().length - 1" aria-hidden="true" class="absolute right-0 top-0 hidden h-full w-5 md:block">
	                                        <svg viewBox="0 0 22 80" fill="none" preserveAspectRatio="none" class="size-full text-gray-300">
	                                            <path d="M0 -2L20 40L0 82" stroke="currentcolor" vector-effect="non-scaling-stroke" stroke-linejoin="round" />
	                                        </svg>
	                                    </div>
	                                </li>
	                            </template>
	                        </ol>
	                    </nav>
	                </div>

	                <div class="space-y-8 rounded-lg border border-gray-200 bg-white p-6 shadow-sm sm:p-8">
	                    <section x-show="brandModalStep === 1" class="grid gap-6">
	                        <label class="block">
	                            <span class="block text-sm/6 font-medium text-gray-900">Brand Name<span class="text-indigo-400">*</span></span>
	                            <input x-model="brandForm.name" type="text" placeholder="Enter the name leads will recognise" class="mt-2 block w-full rounded-md bg-white px-3 py-1.5 text-sm/6 text-gray-900 shadow-sm outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600">
	                        </label>

	                        <label class="block">
	                            <span class="block text-sm/6 font-medium text-gray-900">Brand Website<span class="text-indigo-400">*</span></span>
	                            <input x-model="brandForm.website" type="text" placeholder="https://example.com" class="mt-2 block w-full rounded-md bg-white px-3 py-1.5 text-sm/6 text-gray-900 shadow-sm outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600">
	                        </label>

	                        <div>
	                            <div class="flex items-center justify-between gap-4">
	                                <span class="flex grow flex-col">
	                                    <span class="text-sm/6 font-medium text-gray-900">Add pronunciation guide</span>
	                                    <span class="text-sm/6 text-gray-500">Useful for voice calls or names that are often mispronounced.</span>
	                                </span>
	                                <button type="button" role="switch" x-on:click="brandForm.pronunciationEnabled = ! brandForm.pronunciationEnabled" :aria-checked="brandForm.pronunciationEnabled.toString()" class="relative inline-flex h-6 w-11 shrink-0 cursor-pointer rounded-full p-0.5 outline-offset-2 transition-colors duration-200 ease-in-out focus-visible:outline-2 focus-visible:outline-indigo-600" :class="brandForm.pronunciationEnabled ? 'bg-indigo-600' : 'bg-gray-200'">
	                                    <span aria-hidden="true" class="size-5 rounded-full bg-white shadow-sm ring-1 ring-gray-900/5 transition-transform duration-200 ease-in-out" :class="brandForm.pronunciationEnabled ? 'translate-x-5' : 'translate-x-0'"></span>
	                                </button>
	                            </div>

	                            <label x-show="brandForm.pronunciationEnabled" x-transition.opacity class="mt-5 block">
	                                <span class="block text-sm/6 font-medium text-gray-900">Pronunciation</span>
	                                <input x-model="brandForm.pronunciation" type="text" placeholder="e.g. Goo-guhl, Nigh-kee, Ah-dee-das" class="mt-2 block w-full rounded-md bg-white px-3 py-1.5 text-sm/6 text-gray-900 shadow-sm outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600">
	                            </label>
	                        </div>
	                    </section>

	                    <section x-show="brandModalStep === 2" class="grid gap-6">
	                        <div class="flex justify-start">
	                            <button type="button" data-company-step-ai-action class="outcraft-ai-button inline-flex h-9 shrink-0 items-center justify-center gap-2 rounded-md border-2 border-transparent px-3 text-sm font-semibold text-gray-900 shadow-sm transition hover:text-gray-900">
	                                <span class="outcraft-icon !text-[18px]">auto_awesome</span>
	                                Fill with AI
	                            </button>
	                        </div>

	                        <label class="block max-w-md">
	                            <span class="block text-sm/6 font-medium text-gray-900">Choose Industry<span class="text-indigo-400">*</span></span>
	                            <span class="relative mt-2 block">
	                                <select x-model="brandForm.industry" class="block h-10 w-full appearance-none rounded-md bg-white py-1.5 pl-3 pr-10 text-sm/6 text-gray-900 shadow-sm outline outline-1 -outline-offset-1 outline-gray-300 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600">
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
	                            <textarea x-model="brandForm.description" rows="4" class="mt-2 block w-full rounded-md bg-white px-3 py-2 text-sm/6 text-gray-900 shadow-sm outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600" placeholder="Describe what your company does, who you serve, and the main value your product or service creates."></textarea>
	                        </label>

	                        <label class="block">
	                            <span class="block text-sm/6 font-medium text-gray-900">Problem You Solve</span>
	                            <textarea x-model="brandForm.problem" rows="4" class="mt-2 block w-full rounded-md bg-white px-3 py-2 text-sm/6 text-gray-900 shadow-sm outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600" placeholder="Describe the pain points, needs, or jobs your customers come to you for."></textarea>
	                        </label>

	                        <label class="block">
	                            <span class="block text-sm/6 font-medium text-gray-900">Benefits Over Competitors (Differentiators)</span>
	                            <textarea x-model="brandForm.differentiators" rows="4" class="mt-2 block w-full rounded-md bg-white px-3 py-2 text-sm/6 text-gray-900 shadow-sm outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600" placeholder="List the main reasons customers choose you over alternatives."></textarea>
	                        </label>

	                        <label class="block">
	                            <span class="block text-sm/6 font-medium text-gray-900">Ideal Customer Profile</span>
	                            <textarea x-model="brandForm.icp" rows="4" class="mt-2 block w-full rounded-md bg-white px-3 py-2 text-sm/6 text-gray-900 shadow-sm outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600" placeholder="Describe the buyer types, segments, company sizes, regions, and common needs."></textarea>
	                        </label>

	                        <label class="block">
	                            <span class="block text-sm/6 font-medium text-gray-900">Frequently Asked Questions (FAQs)</span>
	                            <textarea x-model="brandForm.faqs" rows="6" class="mt-2 block w-full rounded-md bg-white px-3 py-2 text-sm/6 text-gray-900 shadow-sm outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600" placeholder="Q: What is your pricing model?&#10;A: ..."></textarea>
	                        </label>
	                    </section>

	                    <section x-show="brandModalStep === 3" class="grid gap-6">
	                        <div class="flex justify-start">
	                            <button type="button" data-company-step-ai-action class="outcraft-ai-button inline-flex h-9 shrink-0 items-center justify-center gap-2 rounded-md border-2 border-transparent px-3 text-sm font-semibold text-gray-900 shadow-sm transition hover:text-gray-900">
	                                <span class="outcraft-icon !text-[18px]">auto_awesome</span>
	                                Fill with AI
	                            </button>
	                        </div>

	                        <label class="block max-w-md">
	                            <span class="block text-sm/6 font-medium text-gray-900">Support Email</span>
	                            <input x-model="brandForm.supportEmail" type="email" placeholder="support@example.com" class="mt-2 block w-full rounded-md bg-white px-3 py-1.5 text-sm/6 text-gray-900 shadow-sm outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600">
	                            <span class="mt-2 block text-sm leading-6 text-gray-500">Human support email.</span>
	                        </label>

	                        <div class="grid gap-6">
	                            <label class="block">
	                                <span class="block text-sm/6 font-medium text-gray-900">Terms of Service Page</span>
	                                <input x-model="brandForm.termsUrl" type="url" placeholder="https://example.com/terms-of-service" class="mt-2 block w-full rounded-md bg-white px-3 py-1.5 text-sm/6 text-gray-900 shadow-sm outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600">
	                                <span class="mt-2 block text-sm leading-6 text-gray-500">Link to your terms of service or user agreement page.</span>
	                            </label>

	                            <label class="block">
	                                <span class="block text-sm/6 font-medium text-gray-900">Privacy Policy Page</span>
	                                <input x-model="brandForm.privacyUrl" type="url" placeholder="https://example.com/privacy-policy" class="mt-2 block w-full rounded-md bg-white px-3 py-1.5 text-sm/6 text-gray-900 shadow-sm outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600">
	                                <span class="mt-2 block text-sm leading-6 text-gray-500">Link to your privacy policy or legal compliance page.</span>
	                            </label>
	                        </div>

	                        <div class="grid gap-6">
	                            <label class="block">
	                                <span class="block text-sm/6 font-medium text-gray-900">Certifications</span>
	                                <input x-model="brandForm.certifications" type="text" placeholder="SOC2, ISO 27001, HIPAA" class="mt-2 block w-full rounded-md bg-white px-3 py-1.5 text-sm/6 text-gray-900 shadow-sm outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600">
	                                <span class="mt-2 block text-sm leading-6 text-gray-500">List any relevant certifications your company holds.</span>
	                            </label>

	                            <label class="block">
	                                <span class="block text-sm/6 font-medium text-gray-900">Compliance</span>
	                                <input x-model="brandForm.compliance" type="text" placeholder="GDPR, CCPA, HIPAA" class="mt-2 block w-full rounded-md bg-white px-3 py-1.5 text-sm/6 text-gray-900 shadow-sm outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600">
	                                <span class="mt-2 block text-sm leading-6 text-gray-500">List any relevant compliance standards your company adheres to.</span>
	                            </label>
	                        </div>
	                    </section>

	                    <div class="flex items-center justify-end gap-3">
	                        <button
	                            type="button"
	                            x-on:click="brandModalStep === 3 ? saveBrandPageWizard() : nextBrandModalStep()"
	                            :disabled="! brandCanContinue()"
	                            class="inline-flex h-10 items-center justify-center rounded-md px-4 text-sm font-semibold transition focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
	                            :class="brandCanContinue() ? 'bg-indigo-600 text-white shadow-sm hover:bg-indigo-500' : 'cursor-not-allowed bg-gray-200 text-gray-500 shadow-none'"
	                        >
	                            <span x-text="brandModalStep === 3 ? 'Create Brand' : 'Continue'"></span>
	                        </button>
	                    </div>
	                </div>
	            </div>
	        </section>

	        <div x-cloak x-show="brandModalOpen" x-transition.opacity x-on:keydown.escape.window="closeBrandCreateModal()" class="fixed inset-0 z-50 flex items-center justify-center bg-gray-950/30 p-4">
            <div x-on:click="closeBrandCreateModal()" class="absolute inset-0"></div>
            <div x-show="brandModalOpen" x-transition:enter="transition ease-out duration-150" x-transition:enter-start="opacity-0 translate-y-3 scale-95" x-transition:enter-end="opacity-100 translate-y-0 scale-100" x-transition:leave="transition ease-in duration-100" x-transition:leave-start="opacity-100 translate-y-0 scale-100" x-transition:leave-end="opacity-0 translate-y-2 scale-95" class="relative max-h-[min(920px,calc(100vh-2rem))] w-full max-w-6xl overflow-hidden rounded-lg bg-white shadow-2xl ring-1 ring-gray-900/10" role="dialog" aria-modal="true" aria-labelledby="brand-modal-title">
                <button type="button" x-on:click="closeBrandCreateModal()" class="absolute right-5 top-5 z-20 inline-flex size-8 shrink-0 items-center justify-center rounded-md text-gray-400 transition hover:bg-gray-50 hover:text-gray-700" aria-label="Close">
                    <span class="outcraft-icon !text-[20px]">close</span>
                </button>

                <div class="max-h-[min(920px,calc(100vh-2rem))] overflow-y-auto">
                <div class="px-6 pt-[100px] pb-6 pr-16 lg:px-24 xl:px-[260px]">
                    <div class="flex items-start gap-4">
                        <div class="flex min-w-0 items-start gap-4">
                            <span class="flex size-10 shrink-0 items-center justify-center rounded-md bg-indigo-50 text-indigo-600">
                                <span class="outcraft-icon !text-[22px]">briefcase_business</span>
                            </span>
                            <div class="min-w-0">
                                <h2 id="brand-modal-title" class="text-base font-semibold text-gray-950" x-text="brandEditingId ? 'Edit Brand' : (brandModalReturnToCampaignBuilder ? 'Create New Company' : 'Create New Brand')"></h2>
                                <p class="mt-1 text-sm leading-6 text-gray-500">Build the reusable company profile campaigns and AI agents can reference.</p>
                            </div>
                        </div>
                    </div>

                </div>

                    <div class="bg-white px-6 pt-6 pb-2 lg:px-24 xl:px-[260px]">
                        <nav aria-label="Brand setup progress">
                            <ol role="list" class="divide-y divide-gray-300 rounded-md border border-gray-300 md:flex md:divide-y-0">
                                <template x-for="(step, index) in brandProgressSteps()" :key="`brand-wizard-progress-${step.step}`">
                                    <li class="relative md:flex md:flex-1">
                                        <button
                                            type="button"
                                            x-on:click="setBrandModalStep(step.step)"
                                            :disabled="! brandCanNavigateToStep(step.step)"
                                            :aria-current="brandModalStep === step.step ? 'step' : null"
                                            class="group flex w-full items-center text-left disabled:cursor-not-allowed disabled:opacity-60"
                                            :class="brandModalStep === step.step ? 'px-6 py-4 text-sm font-medium' : ''"
                                        >
                                            <span x-show="brandModalStep > step.step" class="flex items-center px-6 py-4 text-sm font-medium">
                                                <span class="flex size-10 shrink-0 items-center justify-center rounded-full bg-indigo-600 group-hover:bg-indigo-800">
                                                    <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true" class="size-6 text-white">
                                                        <path d="M19.916 4.626a.75.75 0 0 1 .208 1.04l-9 13.5a.75.75 0 0 1-1.154.114l-6-6a.75.75 0 0 1 1.06-1.06l5.353 5.353 8.493-12.74a.75.75 0 0 1 1.04-.207Z" clip-rule="evenodd" fill-rule="evenodd" />
                                                    </svg>
                                                </span>
                                                <span class="ml-4 truncate text-sm font-medium text-gray-900" x-text="step.label"></span>
                                            </span>

                                            <span x-show="brandModalStep === step.step" class="flex items-center text-sm font-medium">
                                                <span class="flex size-10 shrink-0 items-center justify-center rounded-full border-2 border-indigo-600">
                                                    <span class="text-indigo-600" x-text="String(step.step).padStart(2, '0')"></span>
                                                </span>
                                                <span class="ml-4 truncate text-sm font-medium text-indigo-600" x-text="step.label"></span>
                                            </span>

                                            <span x-show="brandModalStep < step.step" class="flex items-center px-6 py-4 text-sm font-medium">
                                                <span class="flex size-10 shrink-0 items-center justify-center rounded-full border-2 border-gray-300 group-hover:border-gray-400">
                                                    <span class="text-gray-500 group-hover:text-gray-900" x-text="String(step.step).padStart(2, '0')"></span>
                                                </span>
                                                <span class="ml-4 truncate text-sm font-medium text-gray-500 group-hover:text-gray-900" x-text="step.label"></span>
                                            </span>
                                        </button>

                                        <div x-show="index !== brandProgressSteps().length - 1" aria-hidden="true" class="absolute top-0 right-0 hidden h-full w-5 md:block">
                                            <svg viewBox="0 0 22 80" fill="none" preserveAspectRatio="none" class="size-full text-gray-300">
                                                <path d="M0 -2L20 40L0 82" stroke="currentcolor" vector-effect="non-scaling-stroke" stroke-linejoin="round" />
                                            </svg>
                                        </div>
                                    </li>
                                </template>
                            </ol>
                        </nav>
                    </div>

                    <div class="px-6 py-8 lg:px-24 xl:px-[260px]">
                        <section x-show="brandModalStep === 1" class="grid gap-6">
                                <label class="block">
                                    <span class="block text-sm/6 font-medium text-gray-900">Brand Name<span class="text-indigo-400">*</span></span>
                                    <input x-model="brandForm.name" type="text" placeholder="Enter the name leads will recognise" class="mt-2 block w-full rounded-md bg-white px-3 py-1.5 text-sm/6 text-gray-900 shadow-sm outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600">
                                </label>

                                <label class="block">
                                    <span class="block text-sm/6 font-medium text-gray-900">Brand Website<span class="text-indigo-400">*</span></span>
                                    <input x-model="brandForm.website" type="text" placeholder="https://example.com" class="mt-2 block w-full rounded-md bg-white px-3 py-1.5 text-sm/6 text-gray-900 shadow-sm outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600">
                                </label>

                                <div>
                                    <div class="flex items-center justify-between gap-4">
                                        <span class="flex grow flex-col">
                                            <span class="text-sm/6 font-medium text-gray-900">Add pronunciation guide</span>
                                            <span class="text-sm/6 text-gray-500">Useful for voice calls or names that are often mispronounced.</span>
                                        </span>
                                        <button type="button" role="switch" x-on:click="brandForm.pronunciationEnabled = ! brandForm.pronunciationEnabled" :aria-checked="brandForm.pronunciationEnabled.toString()" class="relative inline-flex h-6 w-11 shrink-0 cursor-pointer rounded-full p-0.5 outline-offset-2 transition-colors duration-200 ease-in-out focus-visible:outline-2 focus-visible:outline-indigo-600" :class="brandForm.pronunciationEnabled ? 'bg-indigo-600' : 'bg-gray-200'">
                                            <span aria-hidden="true" class="size-5 rounded-full bg-white shadow-sm ring-1 ring-gray-900/5 transition-transform duration-200 ease-in-out" :class="brandForm.pronunciationEnabled ? 'translate-x-5' : 'translate-x-0'"></span>
                                        </button>
                                    </div>

                                    <label x-show="brandForm.pronunciationEnabled" x-transition.opacity class="mt-5 block">
                                        <span class="block text-sm/6 font-medium text-gray-900">Pronunciation</span>
                                        <input x-model="brandForm.pronunciation" type="text" placeholder="e.g. Goo-guhl, Nigh-kee, Ah-dee-das" class="mt-2 block w-full rounded-md bg-white px-3 py-1.5 text-sm/6 text-gray-900 shadow-sm outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600">
                                    </label>
                                </div>
                        </section>

                        <section x-show="brandModalStep === 2" class="grid gap-6">
                                <div class="flex justify-start">
                                    <button type="button" data-company-step-ai-action class="outcraft-ai-button inline-flex h-9 shrink-0 items-center justify-center gap-2 rounded-md border-2 border-transparent px-3 text-sm font-semibold text-gray-900 shadow-sm transition hover:text-gray-900">
                                        <svg class="outcraft-ai-sparkles" viewBox="0 0 105 103" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                            <path d="M31.6876 33.3482C33.0533 28.4835 39.9496 28.4835 41.3154 33.3482L44.4257 44.4273C46.3112 51.1432 51.5595 56.3915 58.2754 58.277L69.3545 61.3873C74.2192 62.7531 74.2192 69.6494 69.3545 71.0151L58.2754 74.1255C51.5595 76.0109 46.3112 81.2593 44.4257 87.9752L41.3154 99.0543C39.9496 103.919 33.0533 103.919 31.6876 99.0543L28.5772 87.9752C26.6918 81.2593 21.4434 76.0109 14.7275 74.1255L3.64844 71.0151C-1.21627 69.6494 -1.21627 62.7531 3.64844 61.3873L14.7275 58.277C21.4434 56.3915 26.6918 51.1432 28.5772 44.4273L31.6876 33.3482Z"/>
                                            <path d="M77.1504 2.91881C78.2429 -0.972965 83.76 -0.972956 84.8526 2.91881L87.046 10.7318C87.9887 14.0898 90.6129 16.714 93.9709 17.6567L101.784 19.8501C105.676 20.9427 105.676 26.4598 101.784 27.5523L93.9709 29.7458C90.6129 30.6885 87.9887 33.3127 87.046 36.6706L84.8526 44.4837C83.76 48.3754 78.2429 48.3754 77.1504 44.4837L74.9569 36.6706C74.0142 33.3127 71.39 30.6885 68.0321 29.7458L60.219 27.5523C56.3273 26.4598 56.3273 20.9427 60.219 19.8501L68.0321 17.6567C71.39 16.714 74.0142 14.0898 74.9569 10.7318L77.1504 2.91881Z"/>
                                        </svg>
                                        Fill with AI
                                    </button>
                                </div>

                                <label class="block max-w-md">
                                    <span class="block text-sm/6 font-medium text-gray-900">Choose Industry<span class="text-indigo-400">*</span></span>
                                    <span class="relative mt-2 block">
                                        <select x-model="brandForm.industry" class="block h-10 w-full appearance-none rounded-md bg-white py-1.5 pl-3 pr-10 text-sm/6 text-gray-900 shadow-sm outline outline-1 -outline-offset-1 outline-gray-300 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600">
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
                                    <textarea x-model="brandForm.description" rows="4" class="mt-2 block w-full rounded-md bg-white px-3 py-2 text-sm/6 text-gray-900 shadow-sm outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600" placeholder="Describe what your company does, who you serve, and the main value your product or service creates."></textarea>
                                </label>

                                <label class="block">
                                    <span class="block text-sm/6 font-medium text-gray-900">Problem You Solve</span>
                                    <textarea x-model="brandForm.problem" rows="4" class="mt-2 block w-full rounded-md bg-white px-3 py-2 text-sm/6 text-gray-900 shadow-sm outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600" placeholder="Describe the pain points, needs, or jobs your customers come to you for."></textarea>
                                </label>

                                <label class="block">
                                    <span class="block text-sm/6 font-medium text-gray-900">Benefits Over Competitors (Differentiators)</span>
                                    <textarea x-model="brandForm.differentiators" rows="4" class="mt-2 block w-full rounded-md bg-white px-3 py-2 text-sm/6 text-gray-900 shadow-sm outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600" placeholder="List the main reasons customers choose you over alternatives."></textarea>
                                </label>

                                <label class="block">
                                    <span class="block text-sm/6 font-medium text-gray-900">Ideal Customer Profile</span>
                                    <textarea x-model="brandForm.icp" rows="4" class="mt-2 block w-full rounded-md bg-white px-3 py-2 text-sm/6 text-gray-900 shadow-sm outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600" placeholder="Describe the buyer types, segments, company sizes, regions, and common needs."></textarea>
                                </label>

                                <label class="block">
                                    <span class="block text-sm/6 font-medium text-gray-900">Frequently Asked Questions (FAQs)</span>
                                    <textarea x-model="brandForm.faqs" rows="6" class="mt-2 block w-full rounded-md bg-white px-3 py-2 text-sm/6 text-gray-900 shadow-sm outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600" placeholder="Q: What is your pricing model?&#10;A: ..."></textarea>
                                </label>
                        </section>

                        <section x-show="brandModalStep === 3" class="grid gap-6">
                                <div class="flex justify-start">
                                    <button type="button" data-company-step-ai-action class="outcraft-ai-button inline-flex h-9 shrink-0 items-center justify-center gap-2 rounded-md border-2 border-transparent px-3 text-sm font-semibold text-gray-900 shadow-sm transition hover:text-gray-900">
                                        <svg class="outcraft-ai-sparkles" viewBox="0 0 105 103" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                            <path d="M31.6876 33.3482C33.0533 28.4835 39.9496 28.4835 41.3154 33.3482L44.4257 44.4273C46.3112 51.1432 51.5595 56.3915 58.2754 58.277L69.3545 61.3873C74.2192 62.7531 74.2192 69.6494 69.3545 71.0151L58.2754 74.1255C51.5595 76.0109 46.3112 81.2593 44.4257 87.9752L41.3154 99.0543C39.9496 103.919 33.0533 103.919 31.6876 99.0543L28.5772 87.9752C26.6918 81.2593 21.4434 76.0109 14.7275 74.1255L3.64844 71.0151C-1.21627 69.6494 -1.21627 62.7531 3.64844 61.3873L14.7275 58.277C21.4434 56.3915 26.6918 51.1432 28.5772 44.4273L31.6876 33.3482Z"/>
                                            <path d="M77.1504 2.91881C78.2429 -0.972965 83.76 -0.972956 84.8526 2.91881L87.046 10.7318C87.9887 14.0898 90.6129 16.714 93.9709 17.6567L101.784 19.8501C105.676 20.9427 105.676 26.4598 101.784 27.5523L93.9709 29.7458C90.6129 30.6885 87.9887 33.3127 87.046 36.6706L84.8526 44.4837C83.76 48.3754 78.2429 48.3754 77.1504 44.4837L74.9569 36.6706C74.0142 33.3127 71.39 30.6885 68.0321 29.7458L60.219 27.5523C56.3273 26.4598 56.3273 20.9427 60.219 19.8501L68.0321 17.6567C71.39 16.714 74.0142 14.0898 74.9569 10.7318L77.1504 2.91881Z"/>
                                        </svg>
                                        Fill with AI
                                    </button>
                                </div>

                                <label class="block max-w-md">
                                    <span class="block text-sm/6 font-medium text-gray-900">Support Email</span>
                                    <input x-model="brandForm.supportEmail" type="email" placeholder="support@example.com" class="mt-2 block w-full rounded-md bg-white px-3 py-1.5 text-sm/6 text-gray-900 shadow-sm outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600">
                                    <span class="mt-2 block text-sm leading-6 text-gray-500">Human support email.</span>
                                </label>

                                <div class="grid gap-6">
                                    <label class="block">
                                        <span class="block text-sm/6 font-medium text-gray-900">Terms of Service Page</span>
                                        <input x-model="brandForm.termsUrl" type="url" placeholder="https://example.com/terms-of-service" class="mt-2 block w-full rounded-md bg-white px-3 py-1.5 text-sm/6 text-gray-900 shadow-sm outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600">
                                        <span class="mt-2 block text-sm leading-6 text-gray-500">Link to your terms of service or user agreement page.</span>
                                    </label>

                                    <label class="block">
                                        <span class="block text-sm/6 font-medium text-gray-900">Privacy Policy Page</span>
                                        <input x-model="brandForm.privacyUrl" type="url" placeholder="https://example.com/privacy-policy" class="mt-2 block w-full rounded-md bg-white px-3 py-1.5 text-sm/6 text-gray-900 shadow-sm outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600">
                                        <span class="mt-2 block text-sm leading-6 text-gray-500">Link to your privacy policy or legal compliance page.</span>
                                    </label>
                                </div>

                                <div class="grid gap-6">
                                    <label class="block">
                                        <span class="block text-sm/6 font-medium text-gray-900">Certifications</span>
                                        <input x-model="brandForm.certifications" type="text" placeholder="SOC2, ISO 27001, HIPAA" class="mt-2 block w-full rounded-md bg-white px-3 py-1.5 text-sm/6 text-gray-900 shadow-sm outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600">
                                        <span class="mt-2 block text-sm leading-6 text-gray-500">List any relevant certifications your company holds.</span>
                                    </label>

                                    <label class="block">
                                        <span class="block text-sm/6 font-medium text-gray-900">Compliance</span>
                                        <input x-model="brandForm.compliance" type="text" placeholder="GDPR, CCPA, HIPAA" class="mt-2 block w-full rounded-md bg-white px-3 py-1.5 text-sm/6 text-gray-900 shadow-sm outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600">
                                        <span class="mt-2 block text-sm leading-6 text-gray-500">List any relevant compliance standards your company adheres to.</span>
                                    </label>
                                </div>
                        </section>
                    </div>

                    <div class="flex items-center justify-end gap-3 bg-white px-6 pt-2 pb-[100px] lg:px-24 xl:px-[260px]">
                    <button type="button" x-on:click="brandModalStep === 3 ? saveBrandModal() : nextBrandModalStep()" :disabled="! brandCanContinue()" class="inline-flex h-10 items-center justify-center rounded-md px-4 text-sm font-semibold transition focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600" :class="brandCanContinue() ? 'bg-indigo-600 text-white shadow-sm hover:bg-indigo-500' : 'cursor-not-allowed bg-gray-200 text-gray-500 shadow-none'">
                        <span x-text="brandModalStep === 3 ? (brandEditingId ? 'Save Brand' : (brandModalReturnToCampaignBuilder ? 'Create Company' : 'Create Brand')) : 'Continue'"></span>
                    </button>
                    </div>
                </div>
            </div>
        </div>
