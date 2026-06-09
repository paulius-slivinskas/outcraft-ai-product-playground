@php
    $aiAgentInlineWrapperClass = $aiAgentInlineWrapperClass ?? 'mx-auto max-w-3xl space-y-6';
    $aiAgentInlineBackAction = $aiAgentInlineBackAction ?? 'closeAiAgentPageInlineEditor()';
    $aiAgentInlineBackLabel = $aiAgentInlineBackLabel ?? 'Back to AI Agents';
    $aiAgentInlineSaveAction = $aiAgentInlineSaveAction ?? 'saveAiAgentPageInlineEditor()';
@endphp

<div class="{{ $aiAgentInlineWrapperClass }}">
    <button
        type="button"
        x-on:click="{{ $aiAgentInlineBackAction }}"
        class="inline-flex items-center gap-2 text-sm font-semibold leading-6 text-gray-700 transition hover:text-gray-950 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
    >
        <span class="outcraft-icon !text-[20px] text-gray-500">arrow_back</span>
        {{ $aiAgentInlineBackLabel }}
    </button>

    <section class="rounded-lg border border-gray-200 bg-white p-5 shadow-sm">
        <div class="flex items-start gap-3">
            <span class="inline-flex size-10 shrink-0 items-center justify-center">
                <img :src="aiAgentFlagUrl(aiAgentForm)" :alt="`${aiAgentFormTitle()} flag`" class="size-[34px] object-contain" loading="lazy">
            </span>
            <div class="min-w-0">
                <h2 class="text-base font-semibold leading-6 text-gray-950" x-text="aiAgentFormTitle()"></h2>
                <p class="mt-1 text-sm leading-6 text-gray-500">Language, voice, greeting, and calling behavior.</p>
            </div>
        </div>

        <div class="mt-6 grid gap-6">
            <div class="grid gap-6 lg:grid-cols-2">
                <label class="block">
                    <span class="block text-sm/6 font-semibold text-gray-900">Agent Name<span class="text-indigo-400">*</span></span>
                    <input x-model="aiAgentForm.name" type="text" class="mt-2 block w-full rounded-md bg-white px-3 py-1.5 text-sm/6 text-gray-900 shadow-sm outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600">
                    <span class="mt-2 block text-sm leading-6 text-gray-600">How the AI assistant will introduce itself to leads.</span>
                </label>

                <label class="block">
                    <span class="block text-sm/6 font-semibold text-gray-900">Voice<span class="text-indigo-400">*</span></span>
                    <span class="relative mt-2 block">
                        <select x-model="aiAgentForm.voice" class="block h-10 w-full appearance-none rounded-md bg-white py-1.5 pl-3 pr-10 text-sm/6 text-gray-900 shadow-sm outline outline-1 -outline-offset-1 outline-gray-300 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600">
                            <option>Bridget (Ultra-realistic)</option>
                            <option>Maya (Warm)</option>
                            <option>Alex (Calm)</option>
                        </select>
                        <span class="outcraft-icon pointer-events-none absolute right-3 top-1/2 -translate-y-1/2 !text-[18px] text-gray-400">keyboard_arrow_down</span>
                    </span>
                </label>

                <div class="lg:col-span-2">
                    <h4 class="text-sm/6 font-semibold text-gray-900">Hear How Your AI Agent Sounds</h4>
                    <div class="mt-2 flex items-center gap-3">
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

                <label class="block">
                    <span class="block text-sm/6 font-semibold text-gray-900">Call Background Sound</span>
                    <span class="relative mt-2 block">
                        <select x-model="aiAgentForm.backgroundNoise" class="block h-10 w-full appearance-none rounded-md bg-white py-1.5 pl-3 pr-10 text-sm/6 text-gray-900 shadow-sm outline outline-1 -outline-offset-1 outline-gray-300 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600">
                            <option>Office</option>
                            <option>None</option>
                            <option>Cafe</option>
                            <option>Street</option>
                        </select>
                        <span class="outcraft-icon pointer-events-none absolute right-3 top-1/2 -translate-y-1/2 !text-[18px] text-gray-400">keyboard_arrow_down</span>
                    </span>
                </label>

                <label class="block lg:col-span-2">
                    <span class="mb-2 flex items-center justify-between gap-3">
                        <span class="block text-sm/6 font-semibold text-gray-900">Call Greeting Phrase<span class="text-indigo-400">*</span></span>
                        <span class="relative" x-data="{ fieldActionsOpen: false }" x-on:click.outside="fieldActionsOpen = false">
                            <button type="button" x-on:click="fieldActionsOpen = ! fieldActionsOpen" class="inline-flex size-7 items-center justify-center rounded-md text-gray-400 transition hover:bg-gray-50 hover:text-gray-700" aria-label="Call greeting custom field actions">
                                <span class="outcraft-icon !text-[18px]">more_vert</span>
                            </button>
                            <span x-cloak x-show="fieldActionsOpen" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-3" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-2" class="absolute right-0 z-40 mt-2 w-52 rounded-md bg-white py-1 shadow-lg ring-1 ring-gray-900/10">
                                <button type="button" x-on:click="openCustomFieldTextInput('aiAgentInlineCallGreeting'); fieldActionsOpen = false" class="flex w-full items-center gap-2 px-3 py-2 text-left text-sm font-medium text-gray-700 transition hover:bg-gray-50 hover:text-gray-950">
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
                        <div class="relative grid min-w-0 overflow-hidden transition-[grid-template-columns] duration-200 ease-out" :class="customFieldTextInputState('aiAgentInlineCallGreeting').layoutOpen ? 'lg:grid-cols-[minmax(0,1fr)_18rem]' : 'lg:grid-cols-1'">
                            <textarea x-model="aiAgentForm.callGreeting" rows="2" class="block min-h-[64px] min-w-0 w-full resize-y border-0 bg-white px-5 py-4 text-sm/6 text-gray-700 outline-none placeholder:text-gray-400 focus:ring-0"></textarea>
                            <aside x-cloak x-show="customFieldTextInputState('aiAgentInlineCallGreeting').open" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="translate-x-full opacity-0" x-transition:enter-end="translate-x-0 opacity-100" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="translate-x-0 opacity-100" x-transition:leave-end="translate-x-full opacity-0" class="min-w-0 border-t border-gray-200 bg-white lg:border-t-0 lg:border-l lg:border-gray-200">
                                <div class="flex items-center gap-2 border-b border-gray-200 px-4 py-3">
                                    <label class="min-w-0 flex-1">
                                        <input :value="customFieldTextInputState('aiAgentInlineCallGreeting').search" x-on:input="customFieldTextInputState('aiAgentInlineCallGreeting').search = $event.target.value" type="search" placeholder="Search Custom Fields" class="block h-9 w-full rounded-md bg-white px-3 py-1.5 text-sm text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600">
                                    </label>
                                    <button type="button" x-on:click="closeCustomFieldTextInput('aiAgentInlineCallGreeting')" class="inline-flex size-7 items-center justify-center rounded-md text-gray-400 transition hover:bg-white hover:text-gray-700" aria-label="Close custom fields">
                                        <span class="outcraft-icon !text-[18px]">close</span>
                                    </button>
                                </div>
                                <div class="flex flex-wrap gap-2 px-4 py-4">
                                    <template x-for="tag in filteredCustomFieldTextInputTags('aiAgentInlineCallGreeting')" :key="`ai-agent-inline-greeting-${tag}`">
                                        <button type="button" class="inline-flex h-8 items-center rounded-md bg-white px-2.5 text-sm font-medium text-gray-600 shadow-sm ring-1 ring-inset ring-gray-200 transition hover:bg-gray-50 hover:text-gray-900" x-text="tag"></button>
                                    </template>
                                    <p x-show="filteredCustomFieldTextInputTags('aiAgentInlineCallGreeting').length === 0" class="text-sm text-gray-500">No Custom Fields Found.</p>
                                </div>
                            </aside>
                        </div>
                    </div>
                    <button type="button" x-on:click="aiAgentForm.callGreeting = 'Hey, is this @{{first_name}}?'" class="mt-2 text-sm font-semibold text-indigo-600 hover:text-indigo-500">Use Default</button>
                </label>
            </div>
        </div>
    </section>

    <section class="overflow-hidden rounded-lg border border-gray-200 bg-white shadow-sm">
        <button type="button" x-on:click="aiAgentCampaignAssignmentsOpen = ! aiAgentCampaignAssignmentsOpen" class="flex w-full items-center justify-between gap-4 px-5 py-4 text-left transition hover:bg-gray-50">
            <span>
                <span class="block text-base/7 font-semibold text-gray-900">Assigned Campaigns</span>
                <span class="mt-1 block text-sm leading-6 text-gray-600" x-text="aiAgentCampaignAssignmentsOpen ? 'Choose which campaigns use this AI agent.' : aiAgentCampaignAssignmentSummary()"></span>
            </span>
            <span class="outcraft-icon shrink-0 !text-[18px] text-gray-400 transition" :class="aiAgentCampaignAssignmentsOpen ? 'rotate-180' : ''">keyboard_arrow_down</span>
        </button>

        <div x-show="aiAgentCampaignAssignmentsOpen" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-3" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-2" class="border-t border-gray-200 p-5">
            <label class="relative block">
                <span class="sr-only">Search campaigns</span>
                <input
                    type="text"
                    x-model.debounce.150ms="aiAgentCampaignAssignmentSearch"
                    placeholder="Search campaigns"
                    class="block h-10 w-full rounded-md bg-white py-1.5 pl-3 pr-10 text-sm/6 text-gray-900 shadow-sm outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600"
                >
                <button
                    type="button"
                    x-cloak
                    x-show="aiAgentCampaignAssignmentSearch"
                    x-on:click="aiAgentCampaignAssignmentSearch = ''"
                    class="absolute right-2 top-1/2 inline-flex size-7 -translate-y-1/2 items-center justify-center rounded-md text-gray-400 transition hover:bg-gray-50 hover:text-gray-700"
                    aria-label="Clear campaign search"
                >
                    <span class="outcraft-icon !text-[16px]">close</span>
                </button>
            </label>

            <div x-show="campaignAssignmentRows().length === 0" class="mt-4 rounded-md bg-gray-50 p-4 text-sm text-gray-500 ring-1 ring-inset ring-gray-200">
                No campaigns yet.
            </div>

            <div x-show="campaignAssignmentRows().length > 0 && filteredCampaignAssignmentRows().length === 0" class="mt-4 rounded-md bg-gray-50 p-4 text-sm text-gray-500 ring-1 ring-inset ring-gray-200">
                No campaigns match your search.
            </div>

            <div class="mt-4 space-y-1">
                <template x-for="campaign in filteredCampaignAssignmentRows()" :key="`agent-inline-assignment-${campaign.name}`">
                    <label
                        class="flex items-center gap-3 rounded-md px-2 py-2 transition"
                        :class="aiAgentCampaignAssignmentLocked(campaign.name) ? 'cursor-not-allowed opacity-60' : 'cursor-pointer hover:bg-gray-50'"
                    >
                        <x-outcraft.checkbox
                            mark-when="aiAgentCampaignAssignmentSelected(campaign.name)"
                            x-bind:checked="aiAgentCampaignAssignmentSelected(campaign.name)"
                            x-bind:disabled="aiAgentCampaignAssignmentLocked(campaign.name)"
                            x-on:change="toggleAiAgentCampaignAssignment(campaign.name)"
                        />
                        <span class="min-w-0 flex-1 truncate text-sm font-medium leading-6 text-gray-950" x-text="campaign.name"></span>
                    </label>
                </template>
            </div>
        </div>
    </section>

    <section class="overflow-visible rounded-lg border border-gray-200 bg-white shadow-sm">
        <button type="button" x-on:click="aiAgentAdvancedOpen = ! aiAgentAdvancedOpen" class="flex w-full items-center justify-between gap-4 px-5 py-4 text-left transition hover:bg-gray-50">
            <span>
                <span class="block text-base/7 font-semibold text-gray-900">Advanced</span>
                <span class="mt-1 block text-sm leading-6 text-gray-600">Defaults are tuned for natural flow and stronger results.</span>
            </span>
            <span class="outcraft-icon shrink-0 !text-[18px] text-gray-400 transition" :class="aiAgentAdvancedOpen ? 'rotate-180' : ''">keyboard_arrow_down</span>
        </button>

        <div x-show="aiAgentAdvancedOpen" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-3" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-2" class="border-t border-gray-200 p-5">
            <div class="grid gap-6 lg:grid-cols-2">
                <label class="block lg:col-span-2">
                    <span class="mb-2 block text-sm/6 font-semibold text-gray-900">Agent Email Signature</span>
                    <textarea x-model="aiAgentForm.emailSignature" rows="4" placeholder="Best,&#10;Bridget from Example" class="mt-2 block min-h-[96px] w-full resize-y rounded-md bg-white px-3 py-2 text-sm/6 text-gray-700 shadow-sm outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600"></textarea>
                    <span class="mt-2 block text-sm leading-6 text-gray-600">This signature will be used at the end of all emails sent by the AI agent.</span>
                </label>

                <label class="block">
                    <span class="block text-sm/6 font-semibold text-gray-900">AI Model <span class="text-xs font-medium text-gray-400">Admin-Only</span></span>
                    <span class="relative mt-2 block">
                        <select x-model="aiAgentForm.aiModel" class="block h-10 w-full appearance-none rounded-md bg-white py-1.5 pl-3 pr-10 text-sm/6 text-gray-900 shadow-sm outline outline-1 -outline-offset-1 outline-gray-300 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600">
                            <option>GPT-4.1</option>
                        </select>
                        <span class="outcraft-icon pointer-events-none absolute right-3 top-1/2 -translate-y-1/2 !text-[18px] text-gray-400">keyboard_arrow_down</span>
                    </span>
                </label>

                <label class="block">
                    <span class="block text-sm/6 font-semibold text-gray-900">Transcriber Model <span class="text-xs font-medium text-gray-400">Admin-Only</span></span>
                    <span class="relative mt-2 block">
                        <select x-model="aiAgentForm.transcriberModel" class="block h-10 w-full appearance-none rounded-md bg-white py-1.5 pl-3 pr-10 text-sm/6 text-gray-900 shadow-sm outline outline-1 -outline-offset-1 outline-gray-300 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600">
                            <option>Flux General</option>
                        </select>
                        <span class="outcraft-icon pointer-events-none absolute right-3 top-1/2 -translate-y-1/2 !text-[18px] text-gray-400">keyboard_arrow_down</span>
                    </span>
                </label>

                <label class="block lg:col-span-2">
                    <span class="mb-2 block text-sm/6 font-semibold text-gray-900">AI Agent Personality<span class="text-indigo-400">*</span></span>
                    <textarea x-model="aiAgentForm.agentPersonality" rows="6" class="mt-2 block min-h-[140px] w-full resize-y rounded-md bg-white px-3 py-2 text-sm/6 text-gray-700 shadow-sm outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600"></textarea>
                </label>

                <label class="block lg:col-span-2">
                    <span class="mb-2 block text-sm/6 font-semibold text-gray-900">AI Agent Speech Style<span class="text-indigo-400">*</span></span>
                    <textarea x-model="aiAgentForm.agentSpeechStyle" rows="6" class="mt-2 block min-h-[140px] w-full resize-y rounded-md bg-white px-3 py-2 text-sm/6 text-gray-700 shadow-sm outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600"></textarea>
                </label>
            </div>
        </div>
    </section>

    <div class="flex justify-end">
        <button type="button" x-on:click="{{ $aiAgentInlineSaveAction }}" class="inline-flex h-10 items-center justify-center rounded-md bg-indigo-600 px-4 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
            Save Agent
        </button>
    </div>
</div>
