        <div
            x-cloak
            x-show="abTestCreateModalOpen"
            x-transition.opacity
            x-on:keydown.escape.window="closeAbTestCreateModal()"
            class="fixed inset-0 z-50 flex items-center justify-center bg-gray-950/30 p-4"
        >
            <div x-on:click="closeAbTestCreateModal()" class="absolute inset-0"></div>
            <div
                x-show="abTestCreateModalOpen"
                x-transition:enter="transition ease-out duration-150"
                x-transition:enter-start="opacity-0 translate-y-3 scale-95"
                x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                x-transition:leave="transition ease-in duration-100"
                x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                x-transition:leave-end="opacity-0 translate-y-2 scale-95"
                class="relative flex max-h-[min(860px,calc(100vh-2rem))] w-full max-w-5xl flex-col overflow-hidden rounded-lg bg-white shadow-2xl ring-1 ring-gray-900/10"
                role="dialog"
                aria-modal="true"
                aria-labelledby="create-ab-test-title"
            >
                <div class="border-b border-gray-100 px-6 py-5">
                    <div class="flex items-start justify-between gap-4">
                        <div class="flex min-w-0 items-start gap-4">
                            <span class="flex size-10 shrink-0 items-center justify-center rounded-md bg-indigo-50 text-indigo-600">
                                <span class="outcraft-icon !text-[22px]">filter_alt</span>
                            </span>
                            <div class="min-w-0">
                                <h2 id="create-ab-test-title" class="text-base font-semibold text-gray-950">Create A/B Test</h2>
                                <p class="mt-1 text-sm leading-6 text-gray-500">Compare two campaign variations to see which performs better.</p>
                            </div>
                        </div>
                        <button type="button" x-on:click="closeAbTestCreateModal()" class="inline-flex size-8 shrink-0 items-center justify-center rounded-md text-gray-400 transition hover:bg-gray-50 hover:text-gray-700" aria-label="Close">
                            <span class="outcraft-icon !text-[20px]">close</span>
                        </button>
                    </div>
                </div>

                <div class="min-h-0 flex-1 overflow-y-auto px-6 py-5">
                    <div class="space-y-5">
                        <section>
                            <h3 class="text-sm font-semibold text-gray-950">Name Your A/B Test</h3>
                            <label class="mt-3 block">
                                <span class="sr-only">A/B test name</span>
                                <input x-model="abTestForm.name" type="text" placeholder="e.g. Discount vs Free Shipping" class="block h-10 w-full rounded-md border-0 bg-white px-3 text-sm/6 text-gray-900 shadow-sm outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600">
                                <span class="mt-2 block text-sm leading-6 text-gray-500">Used to identify this test in lists. It will help you remember what you are testing and make it easier to find later on.</span>
                            </label>
                        </section>

                        <div class="grid gap-5 lg:grid-cols-2">
                            <section data-card-surface class="rounded-lg bg-white p-5 shadow-sm ring-1 ring-gray-900/5">
                                <h3 class="text-sm font-semibold text-gray-950">Variant A</h3>
                                <div class="mt-5 space-y-5">
                                    <label class="block">
                                        <span class="text-sm font-medium text-gray-900">Base Campaign<span class="text-indigo-400">*</span></span>
                                        <x-outcraft.select class="mt-2" model="abTestForm.variantA.campaign" options="abTestBaseCampaignOptions()" />
                                        <span class="mt-2 block text-sm leading-6 text-gray-500">We'll duplicate this campaign to create the A/B test variant.</span>
                                    </label>

                                    <label class="block">
                                        <span class="text-sm font-medium text-gray-900">Variant name<span class="text-indigo-400">*</span></span>
                                        <input x-model="abTestForm.variantA.name" type="text" placeholder="e.g. Discount" class="mt-2 block h-10 w-full rounded-md border-0 bg-white px-3 text-sm/6 text-gray-900 shadow-sm outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600">
                                        <span class="mt-2 block text-sm leading-6 text-gray-500">This name will be shown inside the test results.</span>
                                    </label>
                                </div>
                            </section>

                            <section data-card-surface class="rounded-lg bg-white p-5 shadow-sm ring-1 ring-gray-900/5">
                                <h3 class="text-sm font-semibold text-gray-950">Variant B</h3>
                                <div class="mt-5 space-y-5">
                                    <label class="block">
                                        <span class="text-sm font-medium text-gray-900">Base Campaign</span>
                                        <x-outcraft.select class="mt-2" model="abTestForm.variantB.campaign" options="abTestBaseCampaignOptions()" />
                                        <span class="mt-2 block text-sm leading-6 text-gray-500">We'll duplicate this campaign to create the A/B test variant.</span>
                                    </label>

                                    <label class="block">
                                        <span class="text-sm font-medium text-gray-900">Variant name<span class="text-indigo-400">*</span></span>
                                        <input x-model="abTestForm.variantB.name" type="text" placeholder="e.g. Free Shipping" class="mt-2 block h-10 w-full rounded-md border-0 bg-white px-3 text-sm/6 text-gray-900 shadow-sm outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600">
                                        <span class="mt-2 block text-sm leading-6 text-gray-500">This name will be shown inside the test results.</span>
                                    </label>
                                </div>
                            </section>
                        </div>

                        <section data-card-surface class="rounded-lg bg-white p-5 shadow-sm ring-1 ring-gray-900/5">
                            <label class="block max-w-xs">
                                <span class="text-sm font-medium text-gray-900">Number of Leads<span class="text-indigo-400">*</span></span>
                                <input x-model="abTestForm.numberOfLeads" type="text" inputmode="numeric" pattern="[0-9]*" x-on:keydown="['e', 'E', '+', '-', '.'].includes($event.key) && $event.preventDefault()" class="mt-2 block h-10 w-full rounded-md border-0 bg-white px-3 text-sm/6 text-gray-900 shadow-sm outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600">
                            </label>
                        </section>
                    </div>
                </div>

                <div class="flex items-center justify-end gap-3 border-t border-gray-100 bg-gray-50 px-6 py-4">
                    <button type="button" x-on:click="closeAbTestCreateModal()" class="inline-flex h-10 items-center justify-center rounded-md bg-white px-4 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 transition hover:bg-gray-50">Cancel</button>
                    <button type="button" x-on:click="submitAbTestCreateModal()" class="inline-flex h-10 items-center justify-center rounded-md bg-indigo-600 px-4 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Submit</button>
                </div>
            </div>
        </div>
