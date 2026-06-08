        <section x-cloak x-show="! campaignBuilderOpen && activeNav === 'AI Agents'" class="mx-6 mt-5">
            <div class="min-h-[54px]">
                <div>
                    <h1 class="text-xl font-bold leading-tight text-gray-950">AI Agents</h1>
                    <p class="mt-1 max-w-2xl text-sm/6 text-gray-500">Reusable agent profiles for campaign language, voice, schedule, and behavior settings.</p>
                </div>
            </div>
        </section>

        <section x-cloak x-show="! campaignBuilderOpen && activeNav === 'AI Agents'" class="mx-6 mb-6 mt-4 max-w-4xl space-y-4">
            <div class="space-y-3">
                <template x-for="agent in aiAgents" :key="agent.id">
                    <div class="oc-selectable-card group flex w-full items-center gap-3 rounded-lg bg-white p-4 text-left shadow-sm outline outline-1 -outline-offset-1 outline-gray-300 transition hover:outline-2 hover:-outline-offset-2 hover:outline-indigo-600">
                        <button
                            type="button"
                            x-on:click="openAiAgentCreateModal(agent)"
                            class="flex min-w-0 flex-1 items-center gap-4 text-left focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
                        >
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
                        </button>
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

            <button type="button" x-on:click="openAiAgentLanguageBatchModal()" class="inline-flex h-10 items-center justify-center gap-2 rounded-md bg-white px-3.5 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 transition hover:bg-gray-50 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                <span class="outcraft-icon !text-[18px] text-gray-500">add</span>
                Add AI Agent
            </button>
        </section>

        <div x-cloak x-show="aiAgentLanguageBatchModalOpen" x-transition.opacity x-on:keydown.escape.window="closeAiAgentLanguageBatchModal()" class="fixed inset-0 z-[70] flex items-center justify-center bg-gray-950/30 p-4">
            <div x-on:click="closeAiAgentLanguageBatchModal()" class="absolute inset-0"></div>
            <div
                x-show="aiAgentLanguageBatchModalOpen"
                x-transition:enter="transition ease-out duration-150"
                x-transition:enter-start="opacity-0 translate-y-3 scale-95"
                x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                x-transition:leave="transition ease-in duration-100"
                x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                x-transition:leave-end="opacity-0 translate-y-2 scale-95"
                class="relative flex max-h-[min(720px,calc(100vh-2rem))] w-full max-w-xl flex-col overflow-hidden rounded-lg bg-white shadow-xl ring-1 ring-gray-900/10"
                role="dialog"
                aria-modal="true"
                aria-labelledby="add-ai-agent-languages-title"
            >
                <div class="border-b border-gray-200 px-6 py-5 sm:px-8">
                    <div class="flex items-start justify-between gap-4">
                        <div class="min-w-0">
                            <h2 id="add-ai-agent-languages-title" class="text-xl font-bold leading-8 text-gray-950">Add Languages</h2>
                            <p class="mt-2 max-w-2xl text-sm leading-6 text-gray-500" x-text="['campaign-creation', 'campaign-detail'].includes(aiAgentLanguageBatchContext) ? 'Select one or more languages to configure additional AI agents for this campaign.' : 'Select one or more languages to configure additional AI agents.'"></p>
                        </div>
                        <button type="button" x-on:click="closeAiAgentLanguageBatchModal()" class="inline-flex size-8 shrink-0 items-center justify-center rounded-md text-gray-400 transition hover:bg-gray-50 hover:text-gray-700" aria-label="Close">
                            <span class="outcraft-icon !text-[20px]">close</span>
                        </button>
                    </div>
                    <label class="relative mt-5 block">
                        <span class="sr-only">Search Languages</span>
                        <input x-ref="aiAgentLanguageSearch" x-model="aiAgentLanguageSearch" type="text" placeholder="Search Languages" class="block h-10 w-full rounded-md bg-white py-1.5 pl-3 pr-10 text-sm text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600">
                        <button
                            type="button"
                            x-cloak
                            x-show="aiAgentLanguageSearch"
                            x-on:click="aiAgentLanguageSearch = ''; $nextTick(() => $refs.aiAgentLanguageSearch?.focus())"
                            class="absolute right-2 top-1/2 inline-flex size-7 -translate-y-1/2 items-center justify-center rounded-md text-gray-400 transition hover:bg-gray-50 hover:text-gray-700"
                            aria-label="Clear language search"
                        >
                            <span class="outcraft-icon !text-[16px]">x</span>
                        </button>
                    </label>
                </div>

                <div class="min-h-0 flex-1 overflow-y-auto px-6 py-5 sm:px-8">
                    <div class="space-y-3">
                        <template x-for="language in filteredAiAgentLanguageBatchOptions()" :key="`ai-agent-language-${language.code}`">
                            <label
                                data-card-surface
                                class="oc-selectable-card flex w-full cursor-pointer items-center gap-4 rounded-lg bg-white p-4 text-left shadow-sm outline outline-1 -outline-offset-1 outline-gray-300 transition hover:outline-2 hover:-outline-offset-2 hover:outline-indigo-600 focus-within:outline focus-within:outline-2 focus-within:-outline-offset-2 focus-within:outline-indigo-600"
                                :class="aiAgentLanguageSelectedForBatch(language.code) ? 'outline-2 -outline-offset-2 outline-indigo-600' : 'outline-gray-300'"
                            >
                                <x-outcraft.checkbox
                                    mark-when="aiAgentLanguageSelectedForBatch(language.code)"
                                    x-bind:checked="aiAgentLanguageSelectedForBatch(language.code)"
                                    x-on:change="toggleAiAgentLanguageSelection(language.code)"
                                />
                                <span class="inline-flex size-7 shrink-0 overflow-hidden rounded-full ring-1 ring-gray-200">
                                    <img :src="campaignSetupFlagUrl(language)" :alt="`${campaignSetupLanguageDisplay(language)} flag`" class="size-full object-cover" loading="lazy">
                                </span>
                                <span class="min-w-0 flex-1">
                                    <span class="block truncate text-sm font-semibold text-gray-950" x-text="campaignSetupLanguageDisplay(language)"></span>
                                </span>
                            </label>
                        </template>
                        <p x-show="filteredAiAgentLanguageBatchOptions().length === 0" class="px-1 py-6 text-center text-sm text-gray-500">No Languages Found.</p>
                    </div>
                </div>

                <div class="flex justify-end gap-3 border-t border-gray-200 bg-white px-6 py-4 sm:px-8">
                    <button type="button" x-on:click="closeAiAgentLanguageBatchModal()" class="inline-flex h-10 items-center rounded-md bg-white px-4 text-sm font-semibold text-gray-900 ring-1 ring-inset ring-gray-300 transition hover:bg-gray-50">Cancel</button>
                    <button type="button" x-on:click="addSelectedAiAgentLanguages()" :disabled="aiAgentLanguageBatchSelection.length === 0" class="inline-flex h-10 items-center rounded-md bg-indigo-600 px-4 text-sm font-semibold text-white transition hover:bg-indigo-500 disabled:cursor-not-allowed disabled:opacity-40">Add</button>
                </div>
            </div>
        </div>

        <div x-cloak x-show="aiAgentModalOpen" x-transition.opacity x-on:keydown.escape.window="closeAiAgentCreateModal()" class="fixed inset-0 z-50 flex items-center justify-center bg-gray-950/30 p-4">
            <div x-on:click="closeAiAgentCreateModal()" class="absolute inset-0"></div>
            <div x-show="aiAgentModalOpen" x-transition:enter="transition ease-out duration-150" x-transition:enter-start="opacity-0 translate-y-3 scale-95" x-transition:enter-end="opacity-100 translate-y-0 scale-100" x-transition:leave="transition ease-in duration-100" x-transition:leave-start="opacity-100 translate-y-0 scale-100" x-transition:leave-end="opacity-0 translate-y-2 scale-95" class="relative max-h-[min(900px,calc(100vh-2rem))] w-full max-w-6xl overflow-hidden rounded-lg bg-white shadow-2xl ring-1 ring-gray-900/10" role="dialog" aria-modal="true" aria-labelledby="ai-agent-modal-title">
                <button type="button" x-on:click="closeAiAgentCreateModal()" class="absolute right-5 top-5 z-20 inline-flex size-8 shrink-0 items-center justify-center rounded-md text-gray-400 transition hover:bg-gray-50 hover:text-gray-700" aria-label="Close">
                    <span class="outcraft-icon !text-[20px]">close</span>
                </button>

                <div class="max-h-[min(900px,calc(100vh-2rem))] overflow-y-auto">
                <div class="px-6 pt-[100px] pb-6 lg:px-24 xl:px-[200px]">
                    <div class="flex items-start gap-4">
                        <div class="flex min-w-0 items-start gap-4">
                            <span class="flex size-10 shrink-0 items-center justify-center rounded-md bg-indigo-50 text-indigo-600">
                                <span class="outcraft-icon !text-[22px]">support_agent</span>
                            </span>
                            <div class="min-w-0">
                                <h2 id="ai-agent-modal-title" class="text-base font-semibold text-gray-950" x-text="aiAgentEditingId ? 'Edit AI Agent' : 'Create New Agent'"></h2>
                                <p class="mt-1 text-sm leading-6 text-gray-500">Choose a language first, then configure how this agent sounds and behaves.</p>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="px-6 py-5 lg:px-24 xl:px-[200px]">
                    <section class="space-y-6">
                        <label class="block max-w-md">
                            <span class="block text-sm/6 font-semibold text-gray-900">Language<span class="text-indigo-400">*</span></span>
                            <span class="relative mt-2 block">
                                <select x-model="aiAgentForm.languageCode" class="block h-10 w-full appearance-none rounded-md bg-white py-1.5 pl-3 pr-10 text-sm/6 text-gray-900 shadow-sm outline outline-1 -outline-offset-1 outline-gray-300 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600">
                                    <template x-for="language in campaignSetupLanguageOptions" :key="language.code">
                                        <option :value="language.code" x-text="campaignSetupLanguageDisplay(language)"></option>
                                    </template>
                                </select>
                                <span class="outcraft-icon pointer-events-none absolute right-3 top-1/2 -translate-y-1/2 !text-[18px] text-gray-400">keyboard_arrow_down</span>
                            </span>
                        </label>

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
                                                <button type="button" x-on:click="openCustomFieldTextInput('aiAgentCallGreeting'); fieldActionsOpen = false" class="flex w-full items-center gap-2 px-3 py-2 text-left text-sm font-medium text-gray-700 transition hover:bg-gray-50 hover:text-gray-950">
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
                                        <div class="relative grid min-w-0 overflow-hidden transition-[grid-template-columns] duration-200 ease-out" :class="customFieldTextInputState('aiAgentCallGreeting').layoutOpen ? 'lg:grid-cols-[minmax(0,1fr)_18rem]' : 'lg:grid-cols-1'">
                                            <textarea x-model="aiAgentForm.callGreeting" rows="2" class="block min-h-[64px] min-w-0 w-full resize-y border-0 bg-white px-5 py-4 text-sm/6 text-gray-700 outline-none placeholder:text-gray-400 focus:ring-0"></textarea>
                                            <aside x-cloak x-show="customFieldTextInputState('aiAgentCallGreeting').open" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="translate-x-full opacity-0" x-transition:enter-end="translate-x-0 opacity-100" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="translate-x-0 opacity-100" x-transition:leave-end="translate-x-full opacity-0" class="min-w-0 border-t border-gray-200 bg-white lg:border-t-0 lg:border-l lg:border-gray-200">
                                                <div class="flex items-center gap-2 border-b border-gray-200 px-4 py-3">
                                                    <label class="min-w-0 flex-1">
                                                        <input :value="customFieldTextInputState('aiAgentCallGreeting').search" x-on:input="customFieldTextInputState('aiAgentCallGreeting').search = $event.target.value" type="search" placeholder="Search Custom Fields" class="block h-9 w-full rounded-md bg-white px-3 py-1.5 text-sm text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600">
                                                    </label>
                                                    <button type="button" x-on:click="closeCustomFieldTextInput('aiAgentCallGreeting')" class="inline-flex size-7 items-center justify-center rounded-md text-gray-400 transition hover:bg-white hover:text-gray-700" aria-label="Close custom fields">
                                                        <span class="outcraft-icon !text-[18px]">close</span>
                                                    </button>
                                                </div>
                                                <div class="flex flex-wrap gap-2 px-4 py-4">
                                                    <template x-for="tag in filteredCustomFieldTextInputTags('aiAgentCallGreeting')" :key="`ai-agent-greeting-${tag}`">
                                                        <button type="button" class="inline-flex h-8 items-center rounded-md bg-white px-2.5 text-sm font-medium text-gray-600 shadow-sm ring-1 ring-inset ring-gray-200 transition hover:bg-gray-50 hover:text-gray-900" x-text="tag"></button>
                                                    </template>
                                                    <p x-show="filteredCustomFieldTextInputTags('aiAgentCallGreeting').length === 0" class="text-sm text-gray-500">No Custom Fields Found.</p>
                                                </div>
                                            </aside>
                                        </div>
                                    </div>
                                    <button type="button" x-on:click="aiAgentForm.callGreeting = 'Hey, is this @{{first_name}}?'" class="mt-2 text-sm font-semibold text-indigo-600 hover:text-indigo-500">Use Default</button>
                                </label>
                        </div>

	                        <div class="overflow-hidden rounded-lg border border-gray-200 bg-white">
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
	                                        <span class="outcraft-icon !text-[16px]">x</span>
	                                    </button>
	                                </label>

	                                <div x-show="campaignAssignmentRows().length === 0" class="mt-4 rounded-md bg-gray-50 p-4 text-sm text-gray-500 ring-1 ring-inset ring-gray-200">
	                                    No campaigns yet.
	                                </div>

	                                <div x-show="campaignAssignmentRows().length > 0 && filteredCampaignAssignmentRows().length === 0" class="mt-4 rounded-md bg-gray-50 p-4 text-sm text-gray-500 ring-1 ring-inset ring-gray-200">
	                                    No campaigns match your search.
	                                </div>

	                                <div class="mt-4 space-y-1">
	                                    <template x-for="campaign in filteredCampaignAssignmentRows()" :key="`agent-assignment-${campaign.name}`">
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
	                        </div>

                        <div class="overflow-visible rounded-lg border border-gray-200 bg-white">
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
                        </div>
                    </section>
                </div>

                <div class="flex items-center justify-end gap-3 bg-white px-6 pt-2 pb-[100px] lg:px-24 xl:px-[200px]">
                    <button type="button" x-on:click="saveAiAgentModal()" class="inline-flex h-10 items-center justify-center rounded-md bg-indigo-600 px-4 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                        <span x-text="aiAgentEditingId ? 'Save Agent' : 'Create Agent'"></span>
                    </button>
                </div>
                </div>
            </div>
        </div>
