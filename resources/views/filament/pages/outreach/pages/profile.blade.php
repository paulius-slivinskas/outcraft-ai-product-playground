        <section
            x-cloak
            x-show="activeNav === 'Profile'"
            x-data="{
                profileSettingsPanel: 'profile',
                newsletterEnabled: true,
                campaignAlertsEnabled: true,
                billingNotificationsEnabled: false,
            }"
            class="mx-3 mb-10 mt-6 sm:mx-6"
        >
            <h1 class="sr-only">Account settings</h1>

            <div class="max-w-7xl lg:flex lg:gap-x-16">
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
                                            <span class="outcraft-icon flex size-6 shrink-0 items-center justify-center !text-[22px]" :class="profileSettingsPanel === 'team' ? 'text-indigo-600' : 'text-gray-400 group-hover:text-indigo-600'">groups</span>
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

                <div class="min-w-0 flex-1 lg:pt-[60px]">
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

                        <div class="space-y-8 rounded-lg bg-white p-6 shadow-sm ring-1 ring-gray-900/5 md:col-span-2">
                            <form>
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

                            <div class="rounded-lg bg-gray-50 p-5 ring-1 ring-gray-900/5">
                                <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                                    <div>
                                        <h3 class="text-sm font-semibold text-gray-950">Two-factor authentication</h3>
                                        <p class="mt-1 text-sm/6 text-gray-500">You do not have 2FA set up. Enable 2FA to secure your account.</p>
                                    </div>
                                    <button type="button" class="inline-flex h-10 shrink-0 items-center justify-center rounded-md bg-white px-3.5 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 transition hover:bg-gray-50">Enable 2FA</button>
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

                        <div class="space-y-4 rounded-lg bg-white p-6 shadow-sm ring-1 ring-gray-900/5 md:col-span-2">
                                <div class="flex items-center justify-between gap-6">
                                    <div>
                                        <p class="text-sm font-semibold text-gray-950">Newsletter</p>
                                        <p class="mt-1 text-sm/6 text-gray-500">A weekly digest highlighting key insights of how your agents are performing.</p>
                                    </div>
                                    <button type="button" role="switch" x-on:click="newsletterEnabled = ! newsletterEnabled" :aria-checked="newsletterEnabled.toString()" class="relative inline-flex h-6 w-11 shrink-0 rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600" :class="newsletterEnabled ? 'bg-indigo-600' : 'bg-gray-200'" aria-label="Toggle newsletter">
                                        <span class="pointer-events-none inline-block size-5 rounded-full bg-white shadow transition duration-200 ease-in-out" :class="newsletterEnabled ? 'translate-x-5' : 'translate-x-0'"></span>
                                    </button>
                                </div>

                                <div class="border-t border-gray-200 pt-4 flex items-center justify-between gap-6">
                                    <div>
                                        <p class="text-sm font-semibold text-gray-950">Campaign alerts</p>
                                        <p class="mt-1 text-sm/6 text-gray-500">Notify me when a campaign needs review or an agent cannot continue.</p>
                                    </div>
                                    <button type="button" role="switch" x-on:click="campaignAlertsEnabled = ! campaignAlertsEnabled" :aria-checked="campaignAlertsEnabled.toString()" class="relative inline-flex h-6 w-11 shrink-0 rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600" :class="campaignAlertsEnabled ? 'bg-indigo-600' : 'bg-gray-200'" aria-label="Toggle campaign alerts">
                                        <span class="pointer-events-none inline-block size-5 rounded-full bg-white shadow transition duration-200 ease-in-out" :class="campaignAlertsEnabled ? 'translate-x-5' : 'translate-x-0'"></span>
                                    </button>
                                </div>

                                <div class="border-t border-gray-200 pt-4 flex items-center justify-between gap-6">
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
                                <div class="grid grid-cols-1 gap-x-6 gap-y-6 sm:max-w-xl sm:grid-cols-6">
                                    <div class="col-span-full">
                                        <label for="profile-organisation-name" class="block text-sm/6 font-medium text-gray-900">Organisation name</label>
                                        <div class="mt-2">
                                            <input id="profile-organisation-name" type="text" value="Outcraft workspace" class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6" />
                                        </div>
                                    </div>
                                    <div class="col-span-full">
                                        <label for="profile-organisation-domain" class="block text-sm/6 font-medium text-gray-900">Workspace domain</label>
                                        <div class="mt-2">
                                            <input id="profile-organisation-domain" type="text" value="outcraft.ai" class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6" />
                                        </div>
                                    </div>
                                    <div class="col-span-full">
                                        <label for="profile-organisation-support" class="block text-sm/6 font-medium text-gray-900">Support email</label>
                                        <div class="mt-2">
                                            <input id="profile-organisation-support" type="email" value="support@outcraft.ai" class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6" />
                                        </div>
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

                        <div class="rounded-lg bg-white p-6 shadow-sm ring-1 ring-gray-900/5 md:col-span-2">
                                <div class="mb-4 flex justify-end">
                                    <button type="button" class="inline-flex h-10 items-center gap-2 rounded-md bg-indigo-600 px-3.5 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-500">
                                        <span class="outcraft-icon !text-[18px]">person_add</span>
                                        Invite member
                                    </button>
                                </div>
                                <div class="overflow-hidden rounded-lg border border-gray-200">
                                    <div class="grid grid-cols-[1fr_auto] gap-4 border-b border-gray-200 px-5 py-4">
                                        <div>
                                            <p class="text-sm font-semibold text-gray-950">Paulius Slivinskas</p>
                                            <p class="mt-1 text-sm/6 text-gray-500">slivinskas@example.com</p>
                                        </div>
                                        <span class="self-start rounded-md bg-indigo-50 px-2 py-1 text-xs font-semibold text-indigo-700">Owner</span>
                                    </div>
                                    <div class="grid grid-cols-[1fr_auto] gap-4 border-b border-gray-200 px-5 py-4">
                                        <div>
                                            <p class="text-sm font-semibold text-gray-950">Outreach Operations</p>
                                            <p class="mt-1 text-sm/6 text-gray-500">ops@outcraft.ai</p>
                                        </div>
                                        <span class="self-start rounded-md bg-gray-50 px-2 py-1 text-xs font-semibold text-gray-600">Admin</span>
                                    </div>
                                    <div class="grid grid-cols-[1fr_auto] gap-4 px-5 py-4">
                                        <div>
                                            <p class="text-sm font-semibold text-gray-950">Sales Review</p>
                                            <p class="mt-1 text-sm/6 text-gray-500">review@outcraft.ai</p>
                                        </div>
                                        <span class="self-start rounded-md bg-gray-50 px-2 py-1 text-xs font-semibold text-gray-600">Member</span>
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
                            <div class="grid grid-cols-1 gap-8 lg:grid-cols-[minmax(0,1fr)_18rem]">
                                <div>
                                    <h3 class="text-xl font-bold text-gray-950">Your plan</h3>
                                    <span class="mt-6 inline-flex rounded-md bg-sky-50 px-3 py-1.5 text-sm font-semibold text-sky-700 ring-1 ring-inset ring-sky-600/10">Trial</span>
                                    <p class="mt-5 text-2xl font-bold text-gray-950">
                                        Free <span class="text-base font-semibold text-gray-500">for 14 days or max 30 demo sessions</span>
                                    </p>
                                    <p class="mt-3 text-sm/6 font-medium text-gray-500">Auto-renews to Starter plan on Jun 17, 2026</p>
                                </div>

                                <div class="space-y-4">
                                    <div class="rounded-lg bg-gray-50 p-5 ring-1 ring-gray-900/5">
                                        <div class="h-1.5 rounded-full bg-gray-200">
                                            <div class="h-1.5 w-0 rounded-full bg-indigo-600"></div>
                                        </div>
                                        <p class="mt-5 text-lg font-bold text-gray-950">
                                            0/30 <span class="font-semibold text-gray-500">free demos done</span>
                                        </p>
                                    </div>

                                    <div class="rounded-lg bg-gray-50 p-5 ring-1 ring-gray-900/5">
                                        <div class="space-y-3 text-sm font-semibold text-gray-500">
                                            <div class="flex items-center justify-between gap-4">
                                                <span>Platform access</span>
                                                <span>&euro;299</span>
                                            </div>
                                            <div class="flex items-center justify-between gap-4">
                                                <span>30 free demos</span>
                                                <span>&euro;0</span>
                                            </div>
                                        </div>
                                        <div class="mt-5 border-t border-gray-200 pt-5 text-right">
                                            <p class="text-2xl font-bold text-gray-950">&euro;299</p>
                                            <p class="mt-1 text-sm font-medium text-gray-500">Next bill - running total</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-8 flex flex-wrap items-center gap-3 border-t border-gray-200 pt-6">
                                <button type="button" class="inline-flex h-10 items-center justify-center rounded-md bg-gray-950 px-4 text-sm font-semibold text-white shadow-sm transition hover:bg-gray-800">Change your plan</button>
                                <button type="button" class="inline-flex h-10 items-center justify-center rounded-md bg-white px-4 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 transition hover:bg-gray-50">Manage payments and invoices</button>
                                <button type="button" class="inline-flex h-10 items-center justify-center rounded-md px-2 text-sm font-semibold text-red-500 transition hover:bg-red-50 hover:text-red-600">Cancel subscription</button>
                            </div>
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
                                            <span class="outcraft-icon !text-[21px]">mail</span>
                                        </span>
                                        <div class="min-w-0">
                                            <p class="text-sm font-semibold text-gray-950">Google Workspace</p>
                                            <p class="mt-1 truncate text-sm/6 text-gray-500">Connected as slivinskas@example.com</p>
                                        </div>
                                    </div>
                                    <span class="shrink-0 rounded-md bg-teal-50 px-2 py-1 text-xs font-semibold text-teal-700">Connected</span>
                                </div>
                                <div class="flex items-center justify-between gap-6 rounded-lg bg-gray-50 p-5 ring-1 ring-gray-900/5">
                                    <div class="flex min-w-0 items-center gap-4">
                                        <span class="flex size-10 shrink-0 items-center justify-center rounded-md bg-indigo-50 text-indigo-600">
                                            <span class="outcraft-icon !text-[21px]">call</span>
                                        </span>
                                        <div class="min-w-0">
                                            <p class="text-sm font-semibold text-gray-950">Voice provider</p>
                                            <p class="mt-1 truncate text-sm/6 text-gray-500">Calls and SMS routing for active campaigns.</p>
                                        </div>
                                    </div>
                                    <span class="shrink-0 rounded-md bg-teal-50 px-2 py-1 text-xs font-semibold text-teal-700">Connected</span>
                                </div>
                                <div class="flex items-center justify-between gap-6 rounded-lg bg-gray-50 p-5 ring-1 ring-gray-900/5">
                                    <div class="flex min-w-0 items-center gap-4">
                                        <span class="flex size-10 shrink-0 items-center justify-center rounded-md bg-gray-100 text-gray-600">
                                            <span class="outcraft-icon !text-[21px]">shopping_bag</span>
                                        </span>
                                        <div class="min-w-0">
                                            <p class="text-sm font-semibold text-gray-950">Commerce platform</p>
                                            <p class="mt-1 truncate text-sm/6 text-gray-500">Sync carts, purchases, and customer events.</p>
                                        </div>
                                    </div>
                                    <button type="button" class="shrink-0 rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 transition hover:bg-gray-50">Connect</button>
                                </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
