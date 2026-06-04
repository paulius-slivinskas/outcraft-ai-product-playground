        <section
            x-cloak
            x-show="activeNav === 'Profile'"
            x-data="{
                profileSettingsPanel: 'profile',
                newsletterEnabled: true,
                campaignAlertsEnabled: true,
                billingNotificationsEnabled: false,
                twoFactorEnabled: false,
                twoFactorMethod: 'authenticator',
            }"
            class="mx-3 mb-10 mt-6 sm:mx-6"
        >
            <h1 class="sr-only">Account settings</h1>

            <style>
                [data-profile-settings-content] > div {
                    grid-template-columns: minmax(0, 1fr) !important;
                    gap: 0 !important;
                }

                [data-profile-settings-content] > div > :first-child {
                    display: none !important;
                }

                [data-profile-settings-content] > div > :not(:first-child) {
                    grid-column: 1 / -1 !important;
                    min-width: 0 !important;
                }
            </style>

            <div class="max-w-5xl lg:flex lg:gap-x-16">
                <aside class="mb-8 flex overflow-x-auto border-b border-gray-200 pb-4 lg:sticky lg:top-6 lg:mb-0 lg:block lg:h-max lg:w-64 lg:flex-none lg:overflow-visible lg:border-0 lg:pb-0 lg:pt-[60px]">
                    <nav class="flex-none lg:w-full" aria-label="Settings navigation">
                        <div class="flex gap-x-6 whitespace-nowrap lg:flex-col lg:gap-x-0 lg:gap-y-8">
                            <div>
                                <p class="mb-2 px-2 text-xs font-semibold uppercase tracking-wide text-gray-400">Account settings</p>
                                <ul role="list" class="flex gap-x-2 lg:flex-col lg:gap-x-0 lg:gap-y-1">
                                    <li>
                                        <button type="button" x-on:click="profileSettingsPanel = 'profile'" class="group flex h-10 w-full items-center gap-x-3 rounded-md py-2 pl-2 pr-3 text-left text-sm/6 font-semibold transition" :class="profileSettingsPanel === 'profile' ? 'bg-white text-indigo-600' : 'text-gray-700 hover:bg-white hover:text-indigo-600'">
                                            <span class="outcraft-icon flex size-6 shrink-0 items-center justify-center !text-[22px]" :class="profileSettingsPanel === 'profile' ? 'text-indigo-600' : 'text-gray-400 group-hover:text-indigo-600'">account_circle</span>
                                            Profile
                                        </button>
                                    </li>
                                    <li>
                                        <button type="button" x-on:click="profileSettingsPanel = 'security'" class="group flex h-10 w-full items-center gap-x-3 rounded-md py-2 pl-2 pr-3 text-left text-sm/6 font-semibold transition" :class="profileSettingsPanel === 'security' ? 'bg-white text-indigo-600' : 'text-gray-700 hover:bg-white hover:text-indigo-600'">
                                            <span class="outcraft-icon flex size-6 shrink-0 items-center justify-center !text-[22px]" :class="profileSettingsPanel === 'security' ? 'text-indigo-600' : 'text-gray-400 group-hover:text-indigo-600'">fingerprint</span>
                                            Security
                                        </button>
                                    </li>
                                    <li>
                                        <button type="button" x-on:click="profileSettingsPanel = 'notifications'" class="group flex h-10 w-full items-center gap-x-3 rounded-md py-2 pl-2 pr-3 text-left text-sm/6 font-semibold transition" :class="profileSettingsPanel === 'notifications' ? 'bg-white text-indigo-600' : 'text-gray-700 hover:bg-white hover:text-indigo-600'">
                                            <span class="outcraft-icon flex size-6 shrink-0 items-center justify-center !text-[22px]" :class="profileSettingsPanel === 'notifications' ? 'text-indigo-600' : 'text-gray-400 group-hover:text-indigo-600'">notifications</span>
                                            Notifications
                                        </button>
                                    </li>
                                </ul>
                            </div>

                            <div>
                                <p class="mb-2 px-2 text-xs font-semibold uppercase tracking-wide text-gray-400">Organisation settings</p>
                                <ul role="list" class="flex gap-x-2 lg:flex-col lg:gap-x-0 lg:gap-y-1">
                                    <li>
                                        <button type="button" x-on:click="profileSettingsPanel = 'organisation'" class="group flex h-10 w-full items-center gap-x-3 rounded-md py-2 pl-2 pr-3 text-left text-sm/6 font-semibold transition" :class="profileSettingsPanel === 'organisation' ? 'bg-white text-indigo-600' : 'text-gray-700 hover:bg-white hover:text-indigo-600'">
                                            <span class="outcraft-icon flex size-6 shrink-0 items-center justify-center !text-[22px]" :class="profileSettingsPanel === 'organisation' ? 'text-indigo-600' : 'text-gray-400 group-hover:text-indigo-600'">business</span>
                                            Organisation
                                        </button>
                                    </li>
                                    <li>
                                        <button type="button" x-on:click="profileSettingsPanel = 'team'" class="group flex h-10 w-full items-center gap-x-3 rounded-md py-2 pl-2 pr-3 text-left text-sm/6 font-semibold transition" :class="profileSettingsPanel === 'team' ? 'bg-white text-indigo-600' : 'text-gray-700 hover:bg-white hover:text-indigo-600'">
                                            <span class="outcraft-icon flex size-6 shrink-0 items-center justify-center !text-[22px]" :class="profileSettingsPanel === 'team' ? 'text-indigo-600' : 'text-gray-400 group-hover:text-indigo-600'">users</span>
                                            Team members
                                        </button>
                                    </li>
                                    <li>
                                        <button type="button" x-on:click="profileSettingsPanel = 'billing'" class="group flex h-10 w-full items-center gap-x-3 rounded-md py-2 pl-2 pr-3 text-left text-sm/6 font-semibold transition" :class="profileSettingsPanel === 'billing' ? 'bg-white text-indigo-600' : 'text-gray-700 hover:bg-white hover:text-indigo-600'">
                                            <span class="outcraft-icon flex size-6 shrink-0 items-center justify-center !text-[22px]" :class="profileSettingsPanel === 'billing' ? 'text-indigo-600' : 'text-gray-400 group-hover:text-indigo-600'">credit_card</span>
                                            Billing
                                        </button>
                                    </li>
                                    <li>
                                        <button type="button" x-on:click="profileSettingsPanel = 'integrations'" class="group flex h-10 w-full items-center gap-x-3 rounded-md py-2 pl-2 pr-3 text-left text-sm/6 font-semibold transition" :class="profileSettingsPanel === 'integrations' ? 'bg-white text-indigo-600' : 'text-gray-700 hover:bg-white hover:text-indigo-600'">
                                            <span class="outcraft-icon flex size-6 shrink-0 items-center justify-center !text-[22px]" :class="profileSettingsPanel === 'integrations' ? 'text-indigo-600' : 'text-gray-400 group-hover:text-indigo-600'">extension</span>
                                            Integrations
                                        </button>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </nav>
                </aside>

                <div data-profile-settings-content class="min-w-0 flex-1 lg:pt-[60px]">
                    <div
                        x-cloak
                        x-show="profileSettingsPanel === 'profile'"
                        x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 translate-y-3"
                        x-transition:enter-end="opacity-100 translate-y-0"
                        x-transition:leave="transition ease-in duration-150"
                        x-transition:leave-start="opacity-100 translate-y-0"
                        x-transition:leave-end="opacity-0 translate-y-2"
                        class="grid grid-cols-1 gap-x-8 gap-y-6 md:grid-cols-3"
                    >
                        <div>
                            <h2 class="text-base/7 font-semibold text-gray-900">Personal information</h2>
                            <p class="mt-1 text-sm/6 text-gray-500">These details are shown inside your Outcraft workspace.</p>
                        </div>

                        <form class="rounded-lg bg-white p-6 shadow-sm ring-1 ring-gray-900/5 md:col-span-2">
                            <div class="grid grid-cols-1 gap-x-6 gap-y-6 sm:grid-cols-6">
                                <div class="col-span-full flex items-center gap-x-5">
                                    <span class="flex size-16 shrink-0 items-center justify-center rounded-md bg-indigo-600 text-xl font-semibold text-white shadow-sm ring-1 ring-inset ring-indigo-500/20">PS</span>
                                    <div>
                                        <p class="text-sm font-semibold text-gray-900">Paulius Slivinskas</p>
                                        <p class="mt-1 text-sm/6 text-gray-500">Profile avatar is generated from your first and last name.</p>
                                    </div>
                                </div>

                                <div class="sm:col-span-3">
                                    <label for="profile-first-name" class="block text-sm/6 font-medium text-gray-900">First name</label>
                                    <div class="mt-2">
                                        <input id="profile-first-name" type="text" name="first_name" autocomplete="given-name" value="Paulius" class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6" />
                                    </div>
                                </div>

                                <div class="sm:col-span-3">
                                    <label for="profile-last-name" class="block text-sm/6 font-medium text-gray-900">Last name</label>
                                    <div class="mt-2">
                                        <input id="profile-last-name" type="text" name="last_name" autocomplete="family-name" value="Slivinskas" class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6" />
                                    </div>
                                </div>

                                <div class="col-span-full">
                                    <label for="profile-email" class="block text-sm/6 font-medium text-gray-900">Email</label>
                                    <div class="mt-2">
                                        <input id="profile-email" type="email" name="email" autocomplete="email" value="slivinskas@example.com" class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6" />
                                    </div>
                                </div>

                                <div class="col-span-full">
                                    <label class="block text-sm/6 font-medium text-gray-900">Timezone</label>
                                    <x-outcraft.select
                                        class="mt-2"
                                        value="Europe / Vilnius"
                                        :options="['Europe / Vilnius', 'Europe / London', 'America / New York', 'America / Los Angeles']"
                                    />
                                </div>
                            </div>

                            <div class="mt-8 flex">
                                <button type="submit" class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Save</button>
                            </div>
                        </form>
                    </div>

                    <div
                        x-cloak
                        x-show="profileSettingsPanel === 'security'"
                        x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 translate-y-3"
                        x-transition:enter-end="opacity-100 translate-y-0"
                        x-transition:leave="transition ease-in duration-150"
                        x-transition:leave-start="opacity-100 translate-y-0"
                        x-transition:leave-end="opacity-0 translate-y-2"
                        class="grid grid-cols-1 gap-x-8 gap-y-6 md:grid-cols-3"
                    >
                        <div>
                            <h2 class="text-base/7 font-semibold text-gray-900">Security</h2>
                            <p class="mt-1 text-sm/6 text-gray-500">Protect access to your account and workspace.</p>
                        </div>

                        <div class="space-y-4 md:col-span-2">
                            <form class="rounded-lg bg-white p-6 shadow-sm ring-1 ring-gray-900/5">
                                <h3 class="text-sm font-semibold text-gray-950">Change password</h3>
                                <p class="mt-1 text-sm/6 text-gray-500">Update your password associated with your account.</p>

                                <div class="mt-5 grid grid-cols-1 gap-x-6 gap-y-6 sm:max-w-xl sm:grid-cols-6">
                                    <div class="col-span-full">
                                        <label for="profile-current-password" class="block text-sm/6 font-medium text-gray-900">Current password</label>
                                        <div class="mt-2">
                                            <input id="profile-current-password" type="password" name="current_password" autocomplete="current-password" class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6" />
                                        </div>
                                    </div>

                                    <div class="col-span-full">
                                        <label for="profile-new-password" class="block text-sm/6 font-medium text-gray-900">New password</label>
                                        <div class="mt-2">
                                            <input id="profile-new-password" type="password" name="new_password" autocomplete="new-password" class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6" />
                                        </div>
                                    </div>

                                    <div class="col-span-full">
                                        <label for="profile-confirm-password" class="block text-sm/6 font-medium text-gray-900">Confirm password</label>
                                        <div class="mt-2">
                                            <input id="profile-confirm-password" type="password" name="confirm_password" autocomplete="new-password" class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6" />
                                        </div>
                                    </div>
                                </div>

                                <div class="mt-8 flex">
                                    <button type="submit" class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Save</button>
                                </div>
                            </form>

                            <div class="rounded-lg bg-white p-6 shadow-sm ring-1 ring-gray-900/5">
                                <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                                    <div>
                                        <h3 class="text-sm font-semibold text-gray-950">Two-factor authentication</h3>
                                        <p class="mt-1 text-sm/6 text-gray-500" x-text="twoFactorEnabled ? 'Choose how you want to verify sign-ins.' : 'You do not have 2FA set up. Enable 2FA to secure your account.'"></p>
                                    </div>
                                    <button
                                        type="button"
                                        role="switch"
                                        x-on:click="twoFactorEnabled = ! twoFactorEnabled"
                                        :aria-checked="twoFactorEnabled.toString()"
                                        class="relative inline-flex h-6 w-11 shrink-0 rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
                                        :class="twoFactorEnabled ? 'bg-indigo-600' : 'bg-gray-200'"
                                        aria-label="Toggle two-factor authentication"
                                    >
                                        <span class="pointer-events-none inline-block size-5 rounded-full bg-white shadow transition duration-200 ease-in-out" :class="twoFactorEnabled ? 'translate-x-5' : 'translate-x-0'"></span>
                                    </button>
                                </div>

                                <div
                                    x-cloak
                                    x-show="twoFactorEnabled"
                                    x-transition:enter="transition ease-out duration-200"
                                    x-transition:enter-start="opacity-0 translate-y-2"
                                    x-transition:enter-end="opacity-100 translate-y-0"
                                    class="mt-6 border-t border-gray-200 pt-6"
                                >
                                    <p class="text-sm font-semibold text-gray-950">Verification method</p>
                                    <div class="mt-3 grid gap-3 sm:grid-cols-2">
                                        <button type="button" x-on:click="twoFactorMethod = 'authenticator'" class="rounded-md bg-white p-4 text-left shadow-sm ring-1 ring-inset transition" :class="twoFactorMethod === 'authenticator' ? 'ring-2 ring-indigo-600' : 'ring-gray-300 hover:bg-gray-50'">
                                            <span class="flex items-center gap-3">
                                                <span class="outcraft-icon !text-[20px]" :class="twoFactorMethod === 'authenticator' ? 'text-indigo-600' : 'text-gray-400'">qr_code_2</span>
                                                <span class="text-sm font-semibold text-gray-950">Authenticator app</span>
                                            </span>
                                            <span class="mt-1 block text-sm/6 text-gray-500">Use Google Authenticator, 1Password, or another TOTP app.</span>
                                        </button>
                                        <button type="button" x-on:click="twoFactorMethod = 'email'" class="rounded-md bg-white p-4 text-left shadow-sm ring-1 ring-inset transition" :class="twoFactorMethod === 'email' ? 'ring-2 ring-indigo-600' : 'ring-gray-300 hover:bg-gray-50'">
                                            <span class="flex items-center gap-3">
                                                <span class="outcraft-icon !text-[20px]" :class="twoFactorMethod === 'email' ? 'text-indigo-600' : 'text-gray-400'">mail</span>
                                                <span class="text-sm font-semibold text-gray-950">Email</span>
                                            </span>
                                            <span class="mt-1 block text-sm/6 text-gray-500">Receive verification codes by email.</span>
                                        </button>
                                    </div>

                                    <div x-show="twoFactorMethod === 'authenticator'" x-transition.opacity class="mt-5 grid gap-5 rounded-lg bg-gray-50 p-5 ring-1 ring-inset ring-gray-200 sm:grid-cols-[9rem_minmax(0,1fr)]">
                                        <div class="flex size-36 items-center justify-center rounded-md bg-white p-3 ring-1 ring-inset ring-gray-200">
                                            <svg viewBox="0 0 120 120" class="size-full text-gray-950" aria-label="Authenticator QR code placeholder">
                                                <rect width="120" height="120" fill="white"/>
                                                <rect x="8" y="8" width="28" height="28" fill="currentColor"/>
                                                <rect x="14" y="14" width="16" height="16" fill="white"/>
                                                <rect x="84" y="8" width="28" height="28" fill="currentColor"/>
                                                <rect x="90" y="14" width="16" height="16" fill="white"/>
                                                <rect x="8" y="84" width="28" height="28" fill="currentColor"/>
                                                <rect x="14" y="90" width="16" height="16" fill="white"/>
                                                <rect x="46" y="10" width="8" height="8" fill="currentColor"/>
                                                <rect x="62" y="10" width="8" height="8" fill="currentColor"/>
                                                <rect x="46" y="26" width="24" height="8" fill="currentColor"/>
                                                <rect x="78" y="46" width="8" height="8" fill="currentColor"/>
                                                <rect x="94" y="46" width="16" height="8" fill="currentColor"/>
                                                <rect x="46" y="46" width="8" height="24" fill="currentColor"/>
                                                <rect x="62" y="54" width="24" height="8" fill="currentColor"/>
                                                <rect x="30" y="62" width="24" height="8" fill="currentColor"/>
                                                <rect x="62" y="78" width="8" height="16" fill="currentColor"/>
                                                <rect x="78" y="78" width="32" height="8" fill="currentColor"/>
                                                <rect x="46" y="94" width="16" height="8" fill="currentColor"/>
                                                <rect x="78" y="94" width="8" height="16" fill="currentColor"/>
                                                <rect x="94" y="102" width="16" height="8" fill="currentColor"/>
                                                <rect x="54" y="110" width="8" height="8" fill="currentColor"/>
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-sm font-semibold text-gray-950">Scan this QR code</p>
                                            <p class="mt-1 text-sm/6 text-gray-500">Add Outcraft to your authenticator app, then enter the 6-digit code to finish setup.</p>
                                            <label class="mt-4 block max-w-xs">
                                                <span class="block text-sm/6 font-medium text-gray-900">Verification code</span>
                                                <input type="text" inputmode="numeric" placeholder="000000" class="mt-2 block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6" />
                                            </label>
                                        </div>
                                    </div>

                                    <div x-show="twoFactorMethod === 'email'" x-transition.opacity class="mt-5 rounded-lg bg-gray-50 p-5 ring-1 ring-inset ring-gray-200">
                                        <label class="block max-w-md">
                                            <span class="block text-sm/6 font-medium text-gray-900">Verification email</span>
                                            <input type="email" value="slivinskas@example.com" class="mt-2 block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6" />
                                        </label>
                                        <p class="mt-2 text-sm/6 text-gray-500">We will send a one-time code to this email when you sign in.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div
                        x-cloak
                        x-show="profileSettingsPanel === 'notifications'"
                        x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 translate-y-3"
                        x-transition:enter-end="opacity-100 translate-y-0"
                        x-transition:leave="transition ease-in duration-150"
                        x-transition:leave-start="opacity-100 translate-y-0"
                        x-transition:leave-end="opacity-0 translate-y-2"
                        class="grid grid-cols-1 gap-x-8 gap-y-6 md:grid-cols-3"
                    >
                        <div>
                            <h2 class="text-base/7 font-semibold text-gray-900">Notifications</h2>
                            <p class="mt-1 text-sm/6 text-gray-500">Choose the updates Outcraft sends to your inbox.</p>
                        </div>

                        <div class="divide-y divide-gray-200 rounded-lg bg-white shadow-sm ring-1 ring-gray-900/5 md:col-span-2">
                                <div class="flex items-center justify-between gap-6 px-6 py-5">
                                    <div>
                                        <p class="text-sm font-semibold text-gray-950">Newsletter</p>
                                        <p class="mt-1 text-sm/6 text-gray-500">A weekly digest highlighting key insights of how your agents are performing.</p>
                                    </div>
                                    <button type="button" role="switch" x-on:click="newsletterEnabled = ! newsletterEnabled" :aria-checked="newsletterEnabled.toString()" class="relative inline-flex h-6 w-11 shrink-0 rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600" :class="newsletterEnabled ? 'bg-indigo-600' : 'bg-gray-200'" aria-label="Toggle newsletter">
                                        <span class="pointer-events-none inline-block size-5 rounded-full bg-white shadow transition duration-200 ease-in-out" :class="newsletterEnabled ? 'translate-x-5' : 'translate-x-0'"></span>
                                    </button>
                                </div>

                                <div class="flex items-center justify-between gap-6 px-6 py-5">
                                    <div>
                                        <p class="text-sm font-semibold text-gray-950">Campaign alerts</p>
                                        <p class="mt-1 text-sm/6 text-gray-500">Notify me when a campaign needs review or an agent cannot continue.</p>
                                    </div>
                                    <button type="button" role="switch" x-on:click="campaignAlertsEnabled = ! campaignAlertsEnabled" :aria-checked="campaignAlertsEnabled.toString()" class="relative inline-flex h-6 w-11 shrink-0 rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600" :class="campaignAlertsEnabled ? 'bg-indigo-600' : 'bg-gray-200'" aria-label="Toggle campaign alerts">
                                        <span class="pointer-events-none inline-block size-5 rounded-full bg-white shadow transition duration-200 ease-in-out" :class="campaignAlertsEnabled ? 'translate-x-5' : 'translate-x-0'"></span>
                                    </button>
                                </div>

                                <div class="flex items-center justify-between gap-6 px-6 py-5">
                                    <div>
                                        <p class="text-sm font-semibold text-gray-950">Billing notifications</p>
                                        <p class="mt-1 text-sm/6 text-gray-500">Send invoices, usage warnings, and subscription changes.</p>
                                    </div>
                                    <button type="button" role="switch" x-on:click="billingNotificationsEnabled = ! billingNotificationsEnabled" :aria-checked="billingNotificationsEnabled.toString()" class="relative inline-flex h-6 w-11 shrink-0 rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600" :class="billingNotificationsEnabled ? 'bg-indigo-600' : 'bg-gray-200'" aria-label="Toggle billing notifications">
                                        <span class="pointer-events-none inline-block size-5 rounded-full bg-white shadow transition duration-200 ease-in-out" :class="billingNotificationsEnabled ? 'translate-x-5' : 'translate-x-0'"></span>
                                    </button>
                                </div>
                        </div>
                    </div>

                    <div x-cloak x-show="profileSettingsPanel === 'organisation'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-3" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-2" class="grid grid-cols-1 gap-x-8 gap-y-6 md:grid-cols-3">
                        <div>
                            <h2 class="text-base/7 font-semibold text-gray-900">Organisation</h2>
                            <p class="mt-1 text-sm/6 text-gray-500">Workspace identity and default operating settings.</p>
                        </div>

                        <form class="rounded-lg bg-white p-6 shadow-sm ring-1 ring-gray-900/5 md:col-span-2">
                                <div class="grid grid-cols-1 gap-x-6 gap-y-6 sm:grid-cols-6">
                                    <div class="col-span-full">
                                        <label for="profile-organisation-name" class="block text-sm/6 font-medium text-gray-900">Legal organisation name</label>
                                        <div class="mt-2">
                                            <input id="profile-organisation-name" type="text" value="Outcraft AI, UAB" class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6" />
                                        </div>
                                    </div>

                                    <div class="sm:col-span-3">
                                        <label for="profile-organisation-registration" class="block text-sm/6 font-medium text-gray-900">Company registration number</label>
                                        <div class="mt-2">
                                            <input id="profile-organisation-registration" type="text" value="306000000" class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6" />
                                        </div>
                                    </div>

                                    <div class="sm:col-span-3">
                                        <label for="profile-organisation-vat" class="block text-sm/6 font-medium text-gray-900">VAT number</label>
                                        <div class="mt-2">
                                            <input id="profile-organisation-vat" type="text" value="LT100000000000" class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6" />
                                        </div>
                                    </div>

                                    <div class="sm:col-span-3">
                                        <label for="profile-organisation-billing-email" class="block text-sm/6 font-medium text-gray-900">Billing email</label>
                                        <div class="mt-2">
                                            <input id="profile-organisation-billing-email" type="email" value="billing@outcraft.ai" class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6" />
                                        </div>
                                    </div>

                                    <div class="sm:col-span-3">
                                        <label for="profile-organisation-support" class="block text-sm/6 font-medium text-gray-900">Support email</label>
                                        <div class="mt-2">
                                            <input id="profile-organisation-support" type="email" value="support@outcraft.ai" class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6" />
                                        </div>
                                    </div>

                                    <div class="col-span-full">
                                        <label for="profile-organisation-address" class="block text-sm/6 font-medium text-gray-900">Registered business address</label>
                                        <div class="mt-2">
                                            <input id="profile-organisation-address" type="text" value="Gedimino pr. 9, Vilnius, Lithuania" class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6" />
                                        </div>
                                    </div>

                                    <div class="sm:col-span-3">
                                        <label for="profile-organisation-country" class="block text-sm/6 font-medium text-gray-900">Country</label>
                                        <x-outcraft.select
                                            class="mt-2"
                                            value="Lithuania"
                                            :options="['Lithuania', 'United States', 'United Kingdom', 'Germany', 'France']"
                                        />
                                    </div>

                                    <div class="sm:col-span-3">
                                        <label for="profile-organisation-currency" class="block text-sm/6 font-medium text-gray-900">Billing currency</label>
                                        <x-outcraft.select
                                            class="mt-2"
                                            value="EUR"
                                            :options="['EUR', 'USD', 'GBP']"
                                        />
                                    </div>
                                </div>

                                <div class="mt-8 flex">
                                    <button type="submit" class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Save</button>
                                </div>
                        </form>
                    </div>

                    <div x-cloak x-show="profileSettingsPanel === 'team'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-3" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-2" class="grid grid-cols-1 gap-x-8 gap-y-6 md:grid-cols-3">
                        <div>
                            <h2 class="text-base/7 font-semibold text-gray-900">Team members</h2>
                            <p class="mt-1 text-sm/6 text-gray-500">Manage who can build campaigns, review leads, and configure workspace settings.</p>
                        </div>

                        <div class="space-y-3 md:col-span-2">
                                <div class="flex justify-end">
                                    <button type="button" class="inline-flex h-10 items-center gap-2 rounded-md bg-white px-3.5 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 transition hover:bg-gray-50">
                                        <span class="outcraft-icon !text-[18px] text-gray-500">user-plus</span>
                                        Invite user
                                    </button>
                                </div>

                                <div class="overflow-hidden rounded-lg bg-white shadow-sm ring-1 ring-gray-900/5">
                                    <div class="grid grid-cols-[1fr_auto] gap-4 px-6 py-5">
                                        <div>
                                            <p class="text-sm font-semibold text-gray-950">Paulius Slivinskas</p>
                                            <p class="mt-1 text-sm/6 text-gray-500">slivinskas@example.com</p>
                                        </div>
                                        <span class="outcraft-label inline-flex h-[26px] self-start items-center rounded-full bg-indigo-50 px-2 py-0 text-xs font-medium text-indigo-700 ring-1 ring-inset ring-indigo-700/10">Owner</span>
                                    </div>
                                    <div class="grid grid-cols-[1fr_auto] gap-4 border-t border-gray-200 px-6 py-5">
                                        <div>
                                            <p class="text-sm font-semibold text-gray-950">Outreach Operations</p>
                                            <p class="mt-1 text-sm/6 text-gray-500">ops@outcraft.ai</p>
                                        </div>
                                        <span class="outcraft-label inline-flex h-[26px] self-start items-center rounded-full bg-gray-50 px-2 py-0 text-xs font-medium text-gray-600 ring-1 ring-inset ring-gray-500/10">Admin</span>
                                    </div>
                                    <div class="grid grid-cols-[1fr_auto] gap-4 border-t border-gray-200 px-6 py-5">
                                        <div>
                                            <p class="text-sm font-semibold text-gray-950">Sales Review</p>
                                            <p class="mt-1 text-sm/6 text-gray-500">review@outcraft.ai</p>
                                        </div>
                                        <span class="outcraft-label inline-flex h-[26px] self-start items-center rounded-full bg-gray-50 px-2 py-0 text-xs font-medium text-gray-600 ring-1 ring-inset ring-gray-500/10">Member</span>
                                    </div>
                                </div>
                        </div>
                    </div>

                    <div x-cloak x-show="profileSettingsPanel === 'billing'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-3" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-2" class="grid grid-cols-1 gap-x-8 gap-y-6 md:grid-cols-3">
                        <div>
                            <h2 class="text-base/7 font-semibold text-gray-900">Billing</h2>
                            <p class="mt-1 text-sm/6 text-gray-500">Subscription, usage, and invoice delivery settings.</p>
                        </div>

                        <div class="rounded-lg bg-white p-6 shadow-sm ring-1 ring-gray-900/5 md:col-span-2">
                            <p class="text-sm/6 text-gray-500">Lorem ipsum sit amet dolor.</p>
                        </div>
                    </div>

                    <div x-cloak x-show="profileSettingsPanel === 'integrations'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-3" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-2" class="grid grid-cols-1 gap-x-8 gap-y-6 md:grid-cols-3">
                        <div>
                            <h2 class="text-base/7 font-semibold text-gray-900">Integrations</h2>
                            <p class="mt-1 text-sm/6 text-gray-500">Connected providers used by agents and campaign workflows.</p>
                        </div>

                        <div class="space-y-3 rounded-lg bg-white p-6 shadow-sm ring-1 ring-gray-900/5 md:col-span-2">
                                <div class="flex items-center justify-between gap-6 rounded-lg bg-gray-50 p-5 ring-1 ring-gray-900/5">
                                    <div class="flex min-w-0 items-center gap-4">
                                        <span class="flex size-10 shrink-0 items-center justify-center rounded-md bg-indigo-50 text-indigo-600">
                                            <span class="outcraft-icon !text-[21px]">hub</span>
                                        </span>
                                        <div class="min-w-0">
                                            <p class="text-sm font-semibold text-gray-950">HubSpot</p>
                                            <p class="mt-1 truncate text-sm/6 text-gray-500">CRM contacts, lifecycle stages, and meeting links are synced.</p>
                                        </div>
                                    </div>
                                    <span class="outcraft-label inline-flex h-[26px] shrink-0 items-center rounded-full bg-green-50 px-2 py-0 text-xs font-medium text-green-700 ring-1 ring-inset ring-green-600/20">Connected</span>
                                </div>
                                <div class="flex items-center justify-between gap-6 rounded-lg bg-gray-50 p-5 ring-1 ring-gray-900/5">
                                    <div class="flex min-w-0 items-center gap-4">
                                        <span class="flex size-10 shrink-0 items-center justify-center rounded-md bg-indigo-50 text-indigo-600">
                                            <span class="outcraft-icon !text-[21px]">shopping_bag</span>
                                        </span>
                                        <div class="min-w-0">
                                            <p class="text-sm font-semibold text-gray-950">Shopify</p>
                                            <p class="mt-1 truncate text-sm/6 text-gray-500">Store customers, carts, orders, and purchase events are synced.</p>
                                        </div>
                                    </div>
                                    <span class="outcraft-label inline-flex h-[26px] shrink-0 items-center rounded-full bg-green-50 px-2 py-0 text-xs font-medium text-green-700 ring-1 ring-inset ring-green-600/20">Connected</span>
                                </div>
                                <div class="flex items-center justify-between gap-6 rounded-lg bg-gray-50 p-5 ring-1 ring-gray-900/5">
                                    <div class="flex min-w-0 items-center gap-4">
                                        <span class="flex size-10 shrink-0 items-center justify-center rounded-md bg-indigo-50 text-indigo-600">
                                            <span class="outcraft-icon !text-[21px]">forum</span>
                                        </span>
                                        <div class="min-w-0">
                                            <p class="text-sm font-semibold text-gray-950">WhatsApp</p>
                                            <p class="mt-1 truncate text-sm/6 text-gray-500">WhatsApp messaging is enabled for outreach and follow-ups.</p>
                                        </div>
                                    </div>
                                    <span class="outcraft-label inline-flex h-[26px] shrink-0 items-center rounded-full bg-green-50 px-2 py-0 text-xs font-medium text-green-700 ring-1 ring-inset ring-green-600/20">Connected</span>
                                </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
