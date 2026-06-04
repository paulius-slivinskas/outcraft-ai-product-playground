        <section
            x-cloak
            x-show="! campaignBuilderOpen && activeNav === 'Dashboard'"
            data-outcraft-dashboard-page
            x-data="{
                assistantQuery: '',
                assistantMessages: [],
                assistantTyping: false,
                assistantWriting: false,
                assistantDocked: false,
                assistantWasEngaged: false,
                assistantResponseTimer: null,
                assistantTypewriterTimer: null,
                assistantTypewriterToken: 0,
                assistantScript: [
                    {
                        user: 'Upload these leads and create a cart recovery campaign for them.',
                        reply: 'Got it. Attach your **CSV file** and I’ll check the **columns**, map the **lead fields**, and prepare a **cart recovery campaign draft**.',
                    },
                    {
                        user: 'Here’s the file. Use email, SMS and calls.',
                        attachment: { name: 'cart_recovery_leads.csv', meta: 'CSV · 126 leads' },
                        reply: 'File received. I found **126 leads** with email, **84 with phone numbers**, and **42 with both**.\nI can create a multi-channel campaign using:\n\n**Email** for first contact\n**SMS** as a light follow-up\n**Calls** for high-intent leads\n\n**Campaign draft** is ready to review.',
                    },
                    {
                        user: 'Make the agent friendly but not too salesy.',
                        reply: 'Done. I adjusted the tone to feel **helpful, calm, and human**.\nThe agent will focus on **recovering interest** rather than pushing for a sale.',
                    },
                    {
                        user: 'Show me positive calls from the last 4 days.',
                        reply: 'Opening **filtered call records** now.\nFilter applied: **Positive calls · Last 4 days**.',
                    },
                    {
                        user: 'Why are some calls scored low?',
                        reply: 'Most low scores came from calls that **ended too early** or had **no meaningful interaction**.\nI found **7 calls with 0-second duration**, which may be lowering your **agent performance score** unfairly.',
                    },
                    {
                        user: 'Take me to analytics and show channel performance.',
                        reply: 'Opening **Analytics**.\nHere’s the **channel performance view** showing which channel contributed most to your **campaign goal**.',
                    },
                    {
                        user: 'Create a follow-up sequence for undecided leads.',
                        reply: 'I created a **3-step follow-up sequence** for undecided leads:\n\n**Day 1:** helpful reminder\n**Day 3:** short value message\n**Day 5:** final check-in with soft CTA\n\nYou can review or edit it before launch.',
                    },
                    {
                        user: 'Use voice.',
                        reply: '**Voice mode ready.**\nTell me what you want to build, change, or inspect inside your campaign.',
                    },
                ],
                dashboardGreeting() {
                    const hour = new Date().getHours();

                    if (hour < 12) {
                        return 'Good morning';
                    }

                    if (hour < 18) {
                        return 'Good afternoon';
                    }

                    return 'Good evening';
                },
                assistantEngaged() {
                    return this.assistantDocked || this.assistantMessages.length > 0 || this.assistantTyping || this.assistantWriting;
                },
                assistantComposerFrameStyle(docked = false) {
                    if (! docked) {
                        return '';
                    }

                    const offset = window.innerWidth >= 1024
                        ? (this.sidebarOpen ? '9rem' : '2rem')
                        : '0px';

                    return `left: calc(50% + ${offset});`;
                },
                syncAssistantComposer() {
                    if (! this.assistantEngaged()) {
                        this.assistantWasEngaged = false;
                        return;
                    }

                    if (this.assistantWasEngaged) {
                        return;
                    }

                    this.assistantWasEngaged = true;
                    this.scrollAssistantComposerIntoView('smooth');
                },
                scrollAssistantComposerIntoView(behavior = 'auto') {
                    this.$nextTick(() => {
                        this.$refs.assistantConversationEnd?.scrollIntoView({ block: 'end', behavior });
                    });
                },
                clearAssistantTimers() {
                    if (this.assistantResponseTimer) {
                        window.clearTimeout(this.assistantResponseTimer);
                    }

                    if (this.assistantTypewriterTimer) {
                        window.clearTimeout(this.assistantTypewriterTimer);
                    }

                    this.assistantResponseTimer = null;
                    this.assistantTypewriterTimer = null;
                    this.assistantTypewriterToken += 1;
                },
                exitAssistantChat() {
                    this.clearAssistantTimers();
                    this.assistantQuery = '';
                    this.assistantMessages = [];
                    this.assistantTyping = false;
                    this.assistantWriting = false;
                    this.assistantDocked = false;
                    this.assistantWasEngaged = false;
                },
                escapeAssistantHtml(value = '') {
                    const element = document.createElement('span');
                    element.textContent = String(value);

                    return element.innerHTML;
                },
                assistantMessageHtml(value = '') {
                    return this.escapeAssistantHtml(value)
                        .split('**')
                        .map((part, index) => index % 2 === 1 ? `\u003cstrong\u003e${part}\u003c/strong\u003e` : part)
                        .join('');
                },
                typeAssistantReply(reply = '') {
                    const characters = Array.from(String(reply));
                    const token = this.assistantTypewriterToken + 1;
                    const messageIndex = this.assistantMessages.length;
                    let index = 0;

                    this.assistantTypewriterToken = token;
                    this.assistantMessages.push({ role: 'assistant', text: '' });
                    this.assistantWriting = true;
                    this.scrollAssistantComposerIntoView('smooth');

                    const tick = () => {
                        if (this.assistantTypewriterToken !== token) {
                            return;
                        }

                        index += 1;
                        this.assistantMessages[messageIndex] = {
                            ...this.assistantMessages[messageIndex],
                            text: characters.slice(0, index).join(''),
                        };
                        this.assistantMessages = [...this.assistantMessages];

                        if (index % 4 === 0 || characters[index - 1] === '\n') {
                            this.scrollAssistantComposerIntoView();
                        }

                        if (index < characters.length) {
                            const previous = characters[index - 1];
                            const delay = previous === '\n' ? 90 : (previous === ' ' ? 18 : 24);
                            this.assistantTypewriterTimer = window.setTimeout(tick, delay);
                            return;
                        }

                        this.assistantWriting = false;
                        this.assistantTypewriterTimer = null;
                        this.scrollAssistantComposerIntoView('smooth');
                    };

                    tick();
                },
                submitAssistantMessage() {
                    const typedText = this.assistantQuery.trim();

                    if (! typedText || this.assistantTyping || this.assistantWriting) {
                        return;
                    }

                    const turn = this.assistantMessages.filter((message) => message.role === 'user').length + 1;
                    const script = this.assistantScript[Math.min(turn - 1, this.assistantScript.length - 1)];

                    this.assistantDocked = true;
                    this.assistantMessages.push({
                        role: 'user',
                        text: script.user || typedText,
                        attachment: script.attachment || null,
                    });
                    this.assistantQuery = '';
                    this.assistantTyping = true;
                    this.scrollAssistantComposerIntoView();
                    this.$nextTick(() => this.$refs.assistantDockedInput?.focus({ preventScroll: true }));

                    this.clearAssistantTimers();

                    this.assistantResponseTimer = window.setTimeout(() => {
                        this.assistantTyping = false;
                        this.assistantResponseTimer = null;
                        this.typeAssistantReply(script.reply);
                    }, 760);
                },
            }"
            x-effect="syncAssistantComposer()"
            class="mb-0 mt-0"
            :class="assistantEngaged() ? 'min-h-[calc(100svh-4rem)]' : ''"
        >
            <div :class="assistantEngaged() ? 'min-h-[calc(100svh-4rem)]' : ''">
                <div class="border-b border-gray-200 bg-white">
                    <div class="mx-auto max-w-7xl px-4 sm:px-6">
                        <div :class="assistantEngaged() ? 'min-h-[calc(100svh-7rem)] pb-36 pt-2 sm:min-h-[calc(100svh-7.5rem)] sm:pb-40 sm:pt-4' : 'pb-14 sm:pb-16'">
                    <div x-cloak x-show="assistantEngaged()" x-transition.opacity class="pointer-events-none sticky top-[4.25rem] z-20 mb-2 w-max lg:top-0">
                        <button type="button" x-on:click="exitAssistantChat()" class="pointer-events-auto inline-flex h-9 min-w-0 items-center gap-2 rounded-md px-2 text-sm font-semibold text-gray-600 transition hover:bg-white hover:text-gray-950">
                            <span class="outcraft-icon !text-[18px]">arrow_back</span>
                            <span>Exit chat</span>
                        </button>
                    </div>

                    <div
                        x-cloak
                        x-show="! assistantEngaged()"
                        x-transition:leave="transition ease-out duration-300"
                        x-transition:leave-start="opacity-100 translate-y-0"
                        x-transition:leave-end="opacity-0 translate-y-6"
                        class="mx-auto max-w-4xl pt-20 text-center sm:pt-28"
                    >
                        <div class="mb-10 flex justify-center">
                            <div class="inline-flex max-w-full items-center rounded-full bg-indigo-50 px-4 py-2 text-xs text-indigo-700 ring-1 ring-indigo-100 sm:text-sm">
                                <span class="truncate"><span class="font-semibold">New:</span> AI assistant is live. Build, inspect, and update your campaigns faster.</span>
                            </div>
                        </div>
                        <h1 class="text-3xl font-bold leading-tight tracking-normal text-gray-950 sm:text-4xl">
                            <span x-text="dashboardGreeting()"></span>, Paulius
                        </h1>
                        <p class="mt-3 text-sm leading-6 text-gray-600 sm:text-base">
                            What would you like help with today?
                        </p>
                    </div>

                    <div
                        x-cloak
                        x-show="assistantMessages.length > 0"
                        class="mx-auto flex w-full max-w-3xl flex-col justify-end space-y-3 text-left"
                    >
                        <template x-for="(message, index) in assistantMessages" :key="`${message.role}-${index}`">
                            <div class="flex" :class="message.role === 'user' ? 'justify-end' : 'justify-start'">
                                <div
                                    class="max-w-[85%] rounded-lg px-4 py-3 text-sm leading-6"
                                    :class="message.role === 'user' ? 'bg-indigo-50 text-gray-950 shadow-sm' : 'bg-gray-100 text-gray-950 shadow-sm'"
                                >
                                    <p class="outcraft-dashboard-chat-message whitespace-pre-line" x-html="message.role === 'assistant' ? assistantMessageHtml(message.text) : escapeAssistantHtml(message.text)"></p>
                                    <div x-show="message.attachment" class="mt-3 flex items-center gap-3 rounded-md bg-white/45 p-3 ring-1 ring-indigo-200">
                                        <span class="flex size-9 shrink-0 items-center justify-center rounded-md bg-white text-indigo-600">
                                            <span class="outcraft-icon !text-[18px]">file-text</span>
                                        </span>
                                        <span class="min-w-0">
                                            <span class="block truncate text-sm font-semibold" x-text="message.attachment?.name"></span>
                                            <span class="block text-xs opacity-75" x-text="message.attachment?.meta"></span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </template>
                        <div x-show="assistantTyping" class="flex justify-start">
                            <div class="outcraft-crafting-indicator px-0 py-3 text-sm font-medium leading-6 text-gray-500" aria-label="Crafting response">
                                Crafting...
                            </div>
                        </div>
                        <div x-ref="assistantConversationEnd" class="h-36 sm:h-32"></div>
                    </div>

                    <div
                        x-cloak
                        x-show="! assistantEngaged()"
                        x-transition:leave="transition ease-out duration-300"
                        x-transition:leave-start="opacity-100 translate-y-0"
                        x-transition:leave-end="opacity-0 translate-y-6"
                        x-ref="assistantInlineComposer"
                        class="mx-auto mt-6 w-full max-w-3xl"
                        :style="assistantComposerFrameStyle(false)"
                    >
                        <div
                            class="flex min-h-12 items-center gap-2 bg-white px-2.5 text-left outline outline-1 -outline-offset-1 outline-gray-300 transition focus-within:outline-2 focus-within:-outline-offset-2 focus-within:outline-indigo-600 sm:min-h-11 sm:px-2"
                            style="border-radius: var(--oc-field-radius); box-shadow: var(--oc-field-shadow);"
                        >
                            <button type="button" class="group/attach relative inline-flex size-9 shrink-0 items-center justify-center text-gray-400 transition hover:text-gray-700 sm:size-8" aria-label="Attach file">
                                <span class="outcraft-icon !text-[18px]">plus</span>
                                <span class="pointer-events-none absolute bottom-full left-1/2 z-40 mb-2 hidden -translate-x-1/2 whitespace-nowrap rounded-md bg-gray-900 px-2.5 py-1.5 text-xs font-medium text-white shadow-sm group-hover/attach:block">
                                    Attach file
                                    <span class="ml-2 text-white/60">A</span>
                                </span>
                            </button>
                            <input
                                type="text"
                                :value="assistantQuery"
                                x-on:input="assistantQuery = $event.target.value"
                                x-on:keydown.enter.prevent="submitAssistantMessage()"
                                class="block min-w-0 flex-1 border-0 bg-transparent p-0 text-sm/6 font-medium text-gray-900 outline-none placeholder:text-gray-400 focus:ring-0"
                                placeholder="Ask anything"
                            >
                            <button type="button" class="group/voice relative inline-flex size-9 shrink-0 items-center justify-center text-gray-400 transition hover:text-gray-700 sm:size-8" aria-label="Use voice">
                                <span class="outcraft-icon !text-[18px]">audio-lines</span>
                                <span class="pointer-events-none absolute bottom-full left-1/2 z-40 mb-2 hidden -translate-x-1/2 whitespace-nowrap rounded-md bg-gray-900 px-2.5 py-1.5 text-xs font-medium text-white shadow-sm group-hover/voice:block">
                                    Use Voice
                                    <span class="ml-2 text-white/60">V</span>
                                </span>
                            </button>
                        </div>
                        <div class="outcraft-assistant-footer mt-3 flex px-1 text-xs font-medium leading-5 text-gray-400">
                            <span class="inline-flex items-center gap-1.5">
                                <span>Powered by</span>
                                <svg class="h-3.5 w-auto text-gray-400" viewBox="0 0 455 84" fill="none" xmlns="http://www.w3.org/2000/svg" aria-label="Outcraft">
                                    <path d="M174.744 40.692C174.744 61.8694 160.025 76.2198 138.304 76.2198C116.583 76.2198 101.864 61.8765 101.864 40.692C101.864 19.5075 116.583 5.16431 138.312 5.16431C160.04 5.16431 174.752 19.5146 174.752 40.692H174.744ZM113.479 40.692C113.479 56.8965 123.789 66.3592 138.304 66.3592C152.819 66.3592 163.232 56.8894 163.232 40.692C163.232 24.4946 152.921 14.9254 138.304 14.9254C123.687 14.9254 113.479 24.4875 113.479 40.692Z" fill="currentColor"/>
                                    <path d="M218.896 25.957H229.41V74.7553H218.896V68.802C215.194 73.2918 209.686 76.2187 202.078 76.2187C188.365 76.2187 179.854 66.5571 179.854 53.5779V25.957H190.369V53.7697C190.369 61.776 194.573 66.9478 202.982 66.9478C212.192 66.9478 218.903 60.8028 218.903 50.3597V25.957H218.896Z" fill="currentColor"/>
                                    <path d="M256.526 67.1408V76.4117C244.314 77.0937 236.408 71.73 236.408 58.9426V6.43604H246.923V25.9582H256.534V35.2291H246.923V59.3333C246.923 66.5582 251.324 67.1408 256.534 67.1408H256.526Z" fill="currentColor"/>
                                    <path d="M301.678 55.817H312.09C310.589 68.2137 299.98 76.213 286.063 76.213C270.243 76.213 259.532 65.7699 259.532 50.3468C259.532 34.9238 270.243 24.4807 286.063 24.4807C299.878 24.4807 310.487 32.3876 312.09 44.6848H301.576C299.776 37.7512 293.866 33.7516 286.063 33.7516C276.35 33.7516 269.544 39.9038 269.544 50.3468C269.544 60.7899 276.35 66.935 286.063 66.935C293.968 66.935 299.878 62.9353 301.678 55.8099V55.817Z" fill="currentColor"/>
                                    <path d="M318.093 74.7568V25.9586H328.607V29.5675C332.812 24.9782 338.918 23.2235 346.729 25.1771L344.929 33.9578C333.518 32.1036 328.615 38.5471 328.615 50.3541V74.7568H318.1H318.093Z" fill="currentColor"/>
                                    <path d="M387.766 69.2864C383.962 73.485 378.257 76.213 370.548 76.213C355.428 76.213 344.717 65.7699 344.717 50.3468C344.717 34.9238 355.428 24.4807 370.548 24.4807C378.257 24.4807 383.962 27.2158 387.766 31.4072V25.9442H398.28V74.7424H387.766V69.2793V69.2864ZM371.247 66.9492C381.055 66.9492 387.766 60.8041 387.766 50.361C387.766 39.918 381.062 33.7658 371.247 33.7658C361.432 33.7658 354.729 39.918 354.729 50.361C354.729 60.8041 361.534 66.9492 371.247 66.9492Z" fill="currentColor"/>
                                    <path d="M422.1 14.5346C419.2 14.5346 415.797 15.7068 415.797 21.2694V27.2226H425.408V36.4935H415.797V74.7492H405.282V21.3688C405.282 12.4887 410.689 5.16431 420.497 5.16431C422.5 5.16431 426.705 5.45558 430.406 7.2174L426.501 15.2166C424.898 14.7265 423.295 14.5346 422.1 14.5346Z" fill="currentColor"/>
                                    <path d="M454.037 67.1408V76.4117C441.825 77.0937 433.919 71.73 433.919 58.9426V6.43604H444.433V25.9582H454.044V35.2291H444.433V59.3333C444.433 66.5582 448.834 67.1408 454.044 67.1408H454.037Z" fill="currentColor"/>
                                    <path d="M82.9209 38.5541V44.4931V46.3757C66.7957 47.96 47.45 42.1985 39.923 26.953C37.8317 30.6117 35.9737 33.2047 33.6857 35.4141C31.303 37.7158 28.5414 39.5131 24.6285 41.5875C28.5195 43.6548 31.2811 45.4522 33.6565 47.7397C36.0538 50.0557 37.9775 52.7979 40.2144 56.762C42.517 52.5279 44.7758 49.0895 49.3736 45.5374C52.0114 47.1288 55.8149 49.0327 60.7479 50.5245L59.1157 51.441C54.4961 54.034 51.3191 57.9483 49.2133 62.4666C46.5537 68.1712 45.5773 74.842 45.519 81.1149L45.4972 83.1893H43.3768H37.1104H35.0337L34.9754 81.1433C34.6548 69.6062 32.1409 61.2518 26.8873 55.7319C21.6629 50.2262 13.5603 47.3845 2.04752 46.8162L0 46.7167V44.7347V44.7205V38.4759V38.4546V36.4726L2.04752 36.3731C13.9537 35.7906 22.0491 32.7997 27.1788 27.2372C32.3377 21.6392 34.6621 13.2918 34.9754 2.04599L35.0337 0H37.1104H43.3768H45.4972L45.519 2.0744C45.7303 25.5464 59.4145 38.9235 82.9209 36.2097V38.5612V38.5541Z" fill="currentColor"/>
                                </svg>
                            </span>
                        </div>
                    </div>

                    <div
                        x-cloak
                        x-show="assistantEngaged()"
                        x-transition:enter="transition ease-out delay-100 duration-200"
                        x-transition:enter-start="opacity-0 translate-y-4"
                        x-transition:enter-end="opacity-100 translate-y-0"
                        x-transition:leave="transition ease-in duration-100"
                        x-transition:leave-start="opacity-100 translate-y-0"
                        x-transition:leave-end="opacity-0 translate-y-2"
                        x-ref="assistantComposer"
                        class="fixed bottom-4 z-50 w-[calc(100vw-2rem)] max-w-3xl -translate-x-1/2 sm:bottom-6"
                        :style="assistantComposerFrameStyle(true)"
                    >
                        <div
                            class="flex min-h-12 items-center gap-2 bg-white px-2.5 text-left outline outline-2 -outline-offset-2 outline-indigo-600 transition focus-within:outline-2 focus-within:-outline-offset-2 focus-within:outline-indigo-600 sm:min-h-11 sm:px-2"
                            style="border-radius: var(--oc-field-radius); box-shadow: var(--oc-field-shadow);"
                        >
                            <button type="button" class="group/attach relative inline-flex size-9 shrink-0 items-center justify-center text-gray-400 transition hover:text-gray-700 sm:size-8" aria-label="Attach file">
                                <span class="outcraft-icon !text-[18px]">plus</span>
                                <span class="pointer-events-none absolute bottom-full left-1/2 z-40 mb-2 hidden -translate-x-1/2 whitespace-nowrap rounded-md bg-gray-900 px-2.5 py-1.5 text-xs font-medium text-white shadow-sm group-hover/attach:block">
                                    Attach file
                                    <span class="ml-2 text-white/60">A</span>
                                </span>
                            </button>
                            <input
                                x-ref="assistantDockedInput"
                                type="text"
                                :value="assistantQuery"
                                x-on:input="assistantQuery = $event.target.value"
                                x-on:keydown.enter.prevent="submitAssistantMessage()"
                                class="block min-w-0 flex-1 border-0 bg-transparent p-0 text-sm/6 font-medium text-gray-900 outline-none placeholder:text-gray-400 focus:ring-0"
                                placeholder="Ask anything"
                            >
                            <button type="button" class="group/voice relative inline-flex size-9 shrink-0 items-center justify-center text-gray-400 transition hover:text-gray-700 sm:size-8" aria-label="Use voice">
                                <span class="outcraft-icon !text-[18px]">audio-lines</span>
                                <span class="pointer-events-none absolute bottom-full left-1/2 z-40 mb-2 hidden -translate-x-1/2 whitespace-nowrap rounded-md bg-gray-900 px-2.5 py-1.5 text-xs font-medium text-white shadow-sm group-hover/voice:block">
                                    Use Voice
                                    <span class="ml-2 text-white/60">V</span>
                                </span>
                            </button>
                        </div>
                        <div class="outcraft-assistant-footer mt-3 flex px-1 text-xs font-medium leading-5 text-gray-400">
                            <span class="inline-flex items-center gap-1.5">
                                <span>Powered by</span>
                                <svg class="h-3.5 w-auto text-gray-400" viewBox="0 0 455 84" fill="none" xmlns="http://www.w3.org/2000/svg" aria-label="Outcraft">
                                    <path d="M174.744 40.692C174.744 61.8694 160.025 76.2198 138.304 76.2198C116.583 76.2198 101.864 61.8765 101.864 40.692C101.864 19.5075 116.583 5.16431 138.312 5.16431C160.04 5.16431 174.752 19.5146 174.752 40.692H174.744ZM113.479 40.692C113.479 56.8965 123.789 66.3592 138.304 66.3592C152.819 66.3592 163.232 56.8894 163.232 40.692C163.232 24.4946 152.921 14.9254 138.304 14.9254C123.687 14.9254 113.479 24.4875 113.479 40.692Z" fill="currentColor"/>
                                    <path d="M218.896 25.957H229.41V74.7553H218.896V68.802C215.194 73.2918 209.686 76.2187 202.078 76.2187C188.365 76.2187 179.854 66.5571 179.854 53.5779V25.957H190.369V53.7697C190.369 61.776 194.573 66.9478 202.982 66.9478C212.192 66.9478 218.903 60.8028 218.903 50.3597V25.957H218.896Z" fill="currentColor"/>
                                    <path d="M256.526 67.1408V76.4117C244.314 77.0937 236.408 71.73 236.408 58.9426V6.43604H246.923V25.9582H256.534V35.2291H246.923V59.3333C246.923 66.5582 251.324 67.1408 256.534 67.1408H256.526Z" fill="currentColor"/>
                                    <path d="M301.678 55.817H312.09C310.589 68.2137 299.98 76.213 286.063 76.213C270.243 76.213 259.532 65.7699 259.532 50.3468C259.532 34.9238 270.243 24.4807 286.063 24.4807C299.878 24.4807 310.487 32.3876 312.09 44.6848H301.576C299.776 37.7512 293.866 33.7516 286.063 33.7516C276.35 33.7516 269.544 39.9038 269.544 50.3468C269.544 60.7899 276.35 66.935 286.063 66.935C293.968 66.935 299.878 62.9353 301.678 55.8099V55.817Z" fill="currentColor"/>
                                    <path d="M318.093 74.7568V25.9586H328.607V29.5675C332.812 24.9782 338.918 23.2235 346.729 25.1771L344.929 33.9578C333.518 32.1036 328.615 38.5471 328.615 50.3541V74.7568H318.1H318.093Z" fill="currentColor"/>
                                    <path d="M387.766 69.2864C383.962 73.485 378.257 76.213 370.548 76.213C355.428 76.213 344.717 65.7699 344.717 50.3468C344.717 34.9238 355.428 24.4807 370.548 24.4807C378.257 24.4807 383.962 27.2158 387.766 31.4072V25.9442H398.28V74.7424H387.766V69.2793V69.2864ZM371.247 66.9492C381.055 66.9492 387.766 60.8041 387.766 50.361C387.766 39.918 381.062 33.7658 371.247 33.7658C361.432 33.7658 354.729 39.918 354.729 50.361C354.729 60.8041 361.534 66.9492 371.247 66.9492Z" fill="currentColor"/>
                                    <path d="M422.1 14.5346C419.2 14.5346 415.797 15.7068 415.797 21.2694V27.2226H425.408V36.4935H415.797V74.7492H405.282V21.3688C405.282 12.4887 410.689 5.16431 420.497 5.16431C422.5 5.16431 426.705 5.45558 430.406 7.2174L426.501 15.2166C424.898 14.7265 423.295 14.5346 422.1 14.5346Z" fill="currentColor"/>
                                    <path d="M454.037 67.1408V76.4117C441.825 77.0937 433.919 71.73 433.919 58.9426V6.43604H444.433V25.9582H454.044V35.2291H444.433V59.3333C444.433 66.5582 448.834 67.1408 454.044 67.1408H454.037Z" fill="currentColor"/>
                                    <path d="M82.9209 38.5541V44.4931V46.3757C66.7957 47.96 47.45 42.1985 39.923 26.953C37.8317 30.6117 35.9737 33.2047 33.6857 35.4141C31.303 37.7158 28.5414 39.5131 24.6285 41.5875C28.5195 43.6548 31.2811 45.4522 33.6565 47.7397C36.0538 50.0557 37.9775 52.7979 40.2144 56.762C42.517 52.5279 44.7758 49.0895 49.3736 45.5374C52.0114 47.1288 55.8149 49.0327 60.7479 50.5245L59.1157 51.441C54.4961 54.034 51.3191 57.9483 49.2133 62.4666C46.5537 68.1712 45.5773 74.842 45.519 81.1149L45.4972 83.1893H43.3768H37.1104H35.0337L34.9754 81.1433C34.6548 69.6062 32.1409 61.2518 26.8873 55.7319C21.6629 50.2262 13.5603 47.3845 2.04752 46.8162L0 46.7167V44.7347V44.7205V38.4759V38.4546V36.4726L2.04752 36.3731C13.9537 35.7906 22.0491 32.7997 27.1788 27.2372C32.3377 21.6392 34.6621 13.2918 34.9754 2.04599L35.0337 0H37.1104H43.3768H45.4972L45.519 2.0744C45.7303 25.5464 59.4145 38.9235 82.9209 36.2097V38.5612V38.5541Z" fill="currentColor"/>
                                </svg>
                            </span>
                        </div>
                    </div>

                    <div
                        x-show="! assistantEngaged()"
                        x-transition:leave="transition ease-out duration-300"
                        x-transition:leave-start="opacity-100 translate-y-0"
                        x-transition:leave-end="opacity-0 translate-y-6"
                        class="mx-auto mt-24 grid max-w-2xl grid-cols-3 gap-x-4 gap-y-9 sm:gap-x-6 lg:flex lg:max-w-5xl lg:items-start lg:justify-center lg:gap-16"
                    >
                        <button type="button" x-on:click="setActiveNav('Campaigns')" class="group flex flex-col items-center gap-3 rounded-lg bg-transparent p-2 text-center transition">
                            <span class="outcraft-dashboard-shortcut-tile flex size-16 items-center justify-center rounded-lg bg-indigo-50 text-indigo-600 transition group-hover:text-indigo-500" style="--shortcut-border-soft: rgb(99 102 241 / 0.12); --shortcut-border-mid: rgb(129 140 248 / 0.72); --shortcut-border-strong: rgb(99 102 241 / 0.98);">
                                <span class="outcraft-icon !text-[28px]">format_list_bulleted</span>
                            </span>
                            <span class="text-sm font-semibold text-gray-500 transition group-hover:text-gray-800">Campaigns</span>
                        </button>

                        <button type="button" x-on:click="setActiveNav('Leads')" class="group flex flex-col items-center gap-3 rounded-lg bg-transparent p-2 text-center transition">
                            <span class="outcraft-dashboard-shortcut-tile flex size-16 items-center justify-center rounded-lg bg-blue-50 text-blue-600 transition group-hover:text-blue-500" style="--shortcut-border-soft: rgb(var(--oc-info-600-rgb) / 0.12); --shortcut-border-mid: rgb(var(--oc-info-500-rgb) / 0.72); --shortcut-border-strong: rgb(var(--oc-info-600-rgb) / 0.98);">
                                <span class="outcraft-icon !text-[28px]">group</span>
                            </span>
                            <span class="text-sm font-semibold text-gray-500 transition group-hover:text-gray-800">Leads</span>
                        </button>

                        <button type="button" x-on:click="setActiveNav('Analytics')" class="group flex flex-col items-center gap-3 rounded-lg bg-transparent p-2 text-center transition">
                            <span class="outcraft-dashboard-shortcut-tile flex size-16 items-center justify-center rounded-lg bg-green-50 text-green-600 transition group-hover:text-green-500" style="--shortcut-border-soft: rgb(34 197 94 / 0.12); --shortcut-border-mid: rgb(74 222 128 / 0.72); --shortcut-border-strong: rgb(34 197 94 / 0.98);">
                                <span class="outcraft-icon !text-[28px]">monitoring</span>
                            </span>
                            <span class="text-sm font-semibold text-gray-500 transition group-hover:text-gray-800">Analytics</span>
                        </button>

                        <button type="button" class="group flex flex-col items-center gap-3 rounded-lg bg-transparent p-2 text-center transition">
                            <span class="outcraft-dashboard-shortcut-tile flex size-16 items-center justify-center rounded-lg bg-amber-50 text-amber-700 transition group-hover:text-amber-600" style="--shortcut-border-soft: rgb(245 158 11 / 0.12); --shortcut-border-mid: rgb(251 191 36 / 0.72); --shortcut-border-strong: rgb(245 158 11 / 0.98);">
                                <span class="outcraft-icon !text-[28px]">library_books</span>
                            </span>
                            <span class="text-sm font-semibold text-gray-500 transition group-hover:text-gray-800">Knowledge Base</span>
                        </button>

                        <button type="button" class="group flex flex-col items-center gap-3 rounded-lg bg-transparent p-2 text-center transition">
                            <span class="outcraft-dashboard-shortcut-tile flex size-16 items-center justify-center rounded-lg bg-gray-100 text-gray-700 transition group-hover:text-gray-800" style="--shortcut-border-soft: rgb(107 114 128 / 0.12); --shortcut-border-mid: rgb(156 163 175 / 0.72); --shortcut-border-strong: rgb(107 114 128 / 0.98);">
                                <span class="outcraft-icon !text-[28px]">extension</span>
                            </span>
                            <span class="text-sm font-semibold text-gray-500 transition group-hover:text-gray-800">Integrations</span>
                        </button>
                        </div>
                    </div>
                </div>
                </div>

                <div x-show="! assistantEngaged()" x-transition.opacity class="bg-gray-50">
                    <div class="mx-auto max-w-7xl space-y-5 px-4 py-8 sm:px-6 sm:py-10">
                    <div>
                        <div class="mb-3 flex items-end justify-between gap-4">
                            <div>
                                <h2 class="text-lg font-bold text-gray-950">Past 24 hours interactions</h2>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 gap-5 lg:grid-cols-3">
                            <div class="rounded-lg bg-white p-6 shadow-sm ring-1 ring-gray-900/5">
                                <div class="flex items-center gap-4">
                                    <span class="flex size-12 shrink-0 items-center justify-center rounded-md bg-indigo-50 text-indigo-600">
                                        <span class="outcraft-icon !text-[23px]">phone_callback</span>
                                    </span>
                                    <div class="min-w-0">
                                        <p class="text-sm font-medium text-gray-500">Calls</p>
                                        <p class="mt-1 text-3xl font-bold leading-none text-gray-950">39</p>
                                    </div>
                                </div>
                            </div>

                            <div class="rounded-lg bg-white p-6 shadow-sm ring-1 ring-gray-900/5">
                                <div class="flex items-center gap-4">
                                    <span class="flex size-12 shrink-0 items-center justify-center rounded-md bg-indigo-50 text-indigo-600">
                                        <span class="outcraft-icon !text-[23px]">sms</span>
                                    </span>
                                    <div class="min-w-0">
                                        <p class="text-sm font-medium text-gray-500">Messages</p>
                                        <p class="mt-1 text-3xl font-bold leading-none text-gray-950">186</p>
                                    </div>
                                </div>
                            </div>

                            <div class="rounded-lg bg-white p-6 shadow-sm ring-1 ring-gray-900/5">
                                <div class="flex items-center gap-4">
                                    <span class="flex size-12 shrink-0 items-center justify-center rounded-md bg-indigo-50 text-indigo-600">
                                        <span class="outcraft-icon !text-[23px]">mail</span>
                                    </span>
                                    <div class="min-w-0">
                                        <p class="text-sm font-medium text-gray-500">Emails</p>
                                        <p class="mt-1 text-3xl font-bold leading-none text-gray-950">428</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 gap-5 lg:grid-cols-2">
                        <div class="rounded-lg bg-white p-6 shadow-sm ring-1 ring-gray-900/5">
                            <div class="flex items-center justify-between gap-4">
                                <div>
                                    <h2 class="text-lg font-bold text-gray-950">Tips & Updates</h2>
                                    <p class="mt-1 text-sm text-gray-500">AI recommendations prepared from recent campaign signals.</p>
                                </div>
                                <span class="flex size-9 shrink-0 items-center justify-center rounded-md bg-indigo-50 text-indigo-600">
                                    <span class="outcraft-icon !text-[19px]">auto_awesome</span>
                                </span>
                            </div>

                            <div class="mt-5 space-y-3">
                                <div class="rounded-md bg-indigo-600 p-4 text-white">
                                    <p class="text-sm font-semibold">Tune Abandoned Cart follow-up timing</p>
                                    <p class="mt-1 text-sm leading-6 text-indigo-100">AI found reply spikes between 09:30 and 11:30. Move the second WhatsApp touch into that window.</p>
                                </div>
                                <div class="rounded-md bg-indigo-50 p-4 ring-1 ring-inset ring-indigo-100">
                                    <p class="text-sm font-semibold text-indigo-950">Recommended next A/B test</p>
                                    <p class="mt-1 text-sm leading-6 text-indigo-700">Test a shorter opening line for Web Support leads with no response after the first call.</p>
                                </div>
                            </div>
                        </div>

                        <div class="rounded-lg bg-white p-6 shadow-sm ring-1 ring-gray-900/5">
                            <div class="flex items-center justify-between gap-4">
                                <div>
                                    <h2 class="text-lg font-bold text-gray-950">Recent activity</h2>
                                    <p class="mt-1 text-sm text-gray-500">Team and system changes in this workspace.</p>
                                </div>
                                <span class="flex size-9 shrink-0 items-center justify-center rounded-md bg-indigo-50 text-indigo-600">
                                    <span class="outcraft-icon !text-[19px]">schedule</span>
                                </span>
                            </div>

                            <ul role="list" class="mt-5 space-y-4">
                                <li class="flex gap-3">
                                    <span class="mt-1 size-2 rounded-full bg-emerald-500"></span>
                                    <div class="min-w-0">
                                        <p class="text-sm font-semibold text-gray-950">Mantas updated Web Support campaign copy</p>
                                        <p class="mt-1 text-xs text-gray-500">4 minutes ago</p>
                                    </div>
                                </li>
                                <li class="flex gap-3">
                                    <span class="mt-1 size-2 rounded-full bg-indigo-500"></span>
                                    <div class="min-w-0">
                                        <p class="text-sm font-semibold text-gray-950">Diana connected the Shopify integration</p>
                                        <p class="mt-1 text-xs text-gray-500">18 minutes ago</p>
                                    </div>
                                </li>
                                <li class="flex gap-3">
                                    <span class="mt-1 size-2 rounded-full bg-amber-500"></span>
                                    <div class="min-w-0">
                                        <p class="text-sm font-semibold text-gray-950">Phone number rotation resolved automatically</p>
                                        <p class="mt-1 text-xs text-gray-500">41 minutes ago</p>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="rounded-lg bg-white p-6 shadow-sm ring-1 ring-gray-900/5">
                        <div class="flex items-center justify-between gap-4">
                            <div>
                                <h2 class="text-lg font-bold text-gray-950">Campaigns</h2>
                                <p class="mt-1 text-sm text-gray-500">Highlighted campaigns from the last 24 hours.</p>
                            </div>
                            <button type="button" x-on:click="setActiveNav('Campaigns')" class="rounded-md bg-white px-2.5 py-1.5 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 transition hover:bg-gray-50">View all</button>
                        </div>

                        <ul role="list" class="mt-4 divide-y divide-gray-100">
                            <template x-for="campaign in pinnedCampaigns.slice(0, 4)" :key="campaign.name">
                                <li class="flex items-center justify-between gap-x-6 py-4">
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
                                            </div>
                                            <div class="mt-1 flex flex-wrap items-center gap-x-2 gap-y-1 text-xs leading-5 text-gray-500">
                                                <p class="whitespace-nowrap">Modified <span x-text="campaign.modified"></span></p>
                                                <span class="size-0.5 rounded-full bg-gray-400"></span>
                                                <p class="truncate">by <span x-text="campaign.owner"></span></p>
                                            </div>
                                        </div>
                                    </div>
                                    <button type="button" x-on:click="setActiveNav('Campaigns')" class="hidden rounded-md bg-white px-2.5 py-1.5 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 transition hover:bg-gray-50 sm:block">Open</button>
                                </li>
                            </template>
                        </ul>
                    </div>
                </div>
            </div>
            </div>
        </section>
