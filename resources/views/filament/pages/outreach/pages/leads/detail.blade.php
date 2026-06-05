        <section x-cloak x-show="leadDetailOpen" class="mx-6 mb-10 mt-6">
            <div class="mb-8">
                <div class="flex flex-wrap items-center justify-between gap-4">
                    <button type="button" x-on:click="backFromLeadDetails()" class="inline-flex h-9 items-center gap-2 rounded-md px-2 text-sm font-semibold text-gray-600 transition hover:bg-white hover:text-gray-950">
                        <span class="outcraft-icon !text-[18px]">arrow_back</span>
                        <span x-text="`Back to ${leadDetailBackLabel()}`"></span>
                    </button>
                    <div class="flex flex-wrap items-center gap-2">
                        <button type="button" class="inline-flex h-9 items-center gap-2 rounded-md bg-green-50 px-3 text-sm font-semibold text-green-700 shadow-sm ring-1 ring-inset ring-green-600/20 transition hover:bg-green-100">
                            <span class="size-[17px]" x-html="whatsappIconSvg()"></span>
                            WhatsApp
                        </button>
                        <button type="button" class="inline-flex h-9 items-center gap-2 rounded-md bg-white px-3 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 transition hover:bg-gray-50">
                            <span class="outcraft-icon !text-[17px]">eye</span>
                            Conversions
                        </button>
                        <button type="button" class="inline-flex h-9 items-center gap-2 rounded-md bg-white px-3 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 transition hover:bg-gray-50">
                            <span class="outcraft-icon !text-[17px]">file-text</span>
                            Metadata
                        </button>
                    </div>
                </div>
                <div class="mt-8">
                    <h1 class="text-2xl font-bold leading-tight text-gray-950">Lead Profile</h1>
                    <p class="mt-1 text-sm leading-6 text-gray-500">Review contact context, campaign runs, and every interaction in one place.</p>
                </div>
            </div>

            <div class="grid gap-6 xl:grid-cols-2">
                <section class="overflow-visible rounded-lg bg-white shadow-sm ring-1 ring-gray-900/5">
                    <div class="flex items-start justify-between gap-4 px-4 py-5 sm:px-6">
                        <div>
                            <h2 class="text-base/7 font-semibold text-gray-950">Lead Details</h2>
                            <p class="mt-1 max-w-2xl text-sm/6 text-gray-500">Personal details, contact information, and creation history for this lead.</p>
                        </div>
                        <div x-show="! leadDetailsEditing" class="relative shrink-0" x-on:click.outside="leadDetailsActionOpen = false">
                                                    <button type="button" x-on:click="leadDetailsActionOpen = ! leadDetailsActionOpen" class="-m-2.5 inline-flex p-2.5 text-gray-500 transition hover:text-gray-900" aria-label="Lead Details actions">
                                                        <span class="outcraft-icon !text-[20px]">more_vert</span>
                                                    </button>
                            <div x-cloak x-show="leadDetailsActionOpen" class="absolute right-0 z-30 mt-2 w-44 rounded-md bg-white py-1 shadow-lg ring-1 ring-gray-900/10">
                                <button type="button" x-on:click="leadDetailsActionOpen = false; openLeadDetailsEdit()" class="flex w-full items-center gap-3 px-3 py-2 text-left text-sm text-gray-700 transition hover:bg-gray-50 hover:text-gray-950">
                                    <span class="outcraft-icon !text-[16px] text-gray-400">pencil</span>
                                    Edit
                                </button>
                            </div>
                        </div>
                    </div>
                    <dl x-show="! leadDetailsEditing" class="grid grid-cols-1 sm:grid-cols-2">
                        <div class="border-t border-gray-100 px-4 py-6 sm:px-6">
                            <dt class="text-sm/6 font-medium text-gray-900">Name</dt>
                            <dd class="mt-1 truncate text-sm/6 text-gray-700 sm:mt-2" x-text="leadFirstName()"></dd>
                        </div>
                        <div class="border-t border-gray-100 px-4 py-6 sm:px-6">
                            <dt class="text-sm/6 font-medium text-gray-900">Surname</dt>
                            <dd class="mt-1 truncate text-sm/6 text-gray-700 sm:mt-2" x-text="leadLastName()"></dd>
                        </div>
                        <div class="border-t border-gray-100 px-4 py-6 sm:px-6">
                            <dt class="text-sm/6 font-medium text-gray-900">Email address</dt>
                            <dd class="mt-1 flex min-w-0 text-sm/6 text-gray-700 sm:mt-2">
                                <button type="button" x-on:click="copyContact(selectedLead?.email || 'biruhl@msn.com')" class="group relative inline-flex min-w-0 max-w-full text-left transition hover:text-gray-900">
                                    <span class="truncate" x-text="selectedLead?.email || 'biruhl@msn.com'"></span>
                                    <span class="pointer-events-none absolute bottom-full left-1/2 z-50 mb-2 -translate-x-1/2 translate-y-1 whitespace-nowrap rounded-lg bg-gray-900 px-3 py-2 text-xs font-medium text-white opacity-0 shadow-sm transition group-hover:translate-y-0 group-hover:opacity-100">
                                        <span x-text="selectedLead?.email || 'biruhl@msn.com'"></span>
                                        <span class="ml-2 text-white/70" x-text="copyTooltipLabel($el.previousElementSibling?.textContent)"></span>
                                        <span class="absolute left-1/2 top-full size-2 -translate-x-1/2 -translate-y-1 rotate-45 bg-gray-900"></span>
                                    </span>
                                </button>
                            </dd>
                        </div>
                        <div class="border-t border-gray-100 px-4 py-6 sm:px-6">
                            <dt class="text-sm/6 font-medium text-gray-900">Phone Number</dt>
                            <dd class="mt-1 flex min-w-0 text-sm/6 text-gray-700 sm:mt-2">
                                <button type="button" x-on:click="copyContact(selectedLead?.phone || '+12145059504')" class="group relative inline-flex min-w-0 max-w-full text-left transition hover:text-gray-900">
                                    <span class="truncate" x-text="selectedLead?.phone || '+12145059504'"></span>
                                    <span class="pointer-events-none absolute bottom-full left-1/2 z-50 mb-2 -translate-x-1/2 translate-y-1 whitespace-nowrap rounded-lg bg-gray-900 px-3 py-2 text-xs font-medium text-white opacity-0 shadow-sm transition group-hover:translate-y-0 group-hover:opacity-100">
                                        <span x-text="selectedLead?.phone || '+12145059504'"></span>
                                        <span class="ml-2 text-white/70" x-text="copyTooltipLabel($el.previousElementSibling?.textContent)"></span>
                                        <span class="absolute left-1/2 top-full size-2 -translate-x-1/2 -translate-y-1 rotate-45 bg-gray-900"></span>
                                    </span>
                                </button>
                            </dd>
                        </div>
                        <div class="border-t border-gray-100 px-4 py-6 sm:px-6">
                            <dt class="text-sm/6 font-medium text-gray-900">Country</dt>
                            <dd class="mt-1 flex items-center gap-2 text-sm/6 text-gray-700 sm:mt-2">
                                <span class="inline-flex size-5 shrink-0 overflow-hidden rounded-full ring-1 ring-gray-200">
                                    <img :src="countryFlagUrl(selectedLead?.countryFlagCode || selectedLead?.country || 'US')" :alt="`${leadCountryOption(selectedLead?.country || 'US').name} flag`" class="size-full object-cover" loading="lazy">
                                </span>
                                <span x-text="leadCountryOption(selectedLead?.country || 'US').name"></span>
                            </dd>
                        </div>
                        <div class="border-t border-gray-100 px-4 py-6 sm:px-6">
                            <dt class="text-sm/6 font-medium text-gray-900">Timezone</dt>
                            <dd class="mt-1 truncate text-sm/6 text-gray-700 sm:mt-2" x-text="selectedLead?.timezone || 'America / New York'"></dd>
                        </div>
                        <div class="border-t border-gray-100 px-4 py-6 sm:px-6">
                            <dt class="text-sm/6 font-medium text-gray-900">Created</dt>
                            <dd class="mt-1 text-sm/6 text-gray-700 sm:mt-2"><span x-text="leadAddedAge()"></span><span class="mx-1 text-gray-400">·</span><span x-text="leadCreatedDate()"></span></dd>
                        </div>
                        <div class="border-t border-gray-100 px-4 py-6 sm:px-6">
                            <dt class="text-sm/6 font-medium text-gray-900">Status</dt>
                            <dd class="mt-1 sm:mt-2">
                                <span class="inline-flex rounded-md px-2 py-1 text-xs font-medium ring-1 ring-inset" :class="leadStateClass(selectedLead?.state || 'Idle')" x-text="selectedLead?.state || 'Idle'"></span>
                            </dd>
                        </div>
                    </dl>
                    <form x-cloak x-show="leadDetailsEditing" x-on:submit.prevent="saveLeadDetailsEdit()" class="border-t border-gray-100 px-4 py-6 sm:px-6">
                        <div class="grid grid-cols-1 gap-x-6 gap-y-6 sm:grid-cols-2">
                            <div>
                                <label for="lead-edit-first-name" class="block text-sm/6 font-medium text-gray-900">First name</label>
                                <div class="mt-2">
                                    <input id="lead-edit-first-name" type="text" x-model="leadEditForm.firstName" class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6" />
                                </div>
                            </div>
                            <div>
                                <label for="lead-edit-last-name" class="block text-sm/6 font-medium text-gray-900">Last name</label>
                                <div class="mt-2">
                                    <input id="lead-edit-last-name" type="text" x-model="leadEditForm.lastName" class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6" />
                                </div>
                            </div>
                            <div>
                                <label for="lead-edit-email" class="block text-sm/6 font-medium text-gray-900">Email address</label>
                                <div class="mt-2">
                                    <input id="lead-edit-email" type="email" x-model="leadEditForm.email" class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6" />
                                </div>
                            </div>
                            <div>
                                <label for="lead-edit-phone" class="block text-sm/6 font-medium text-gray-900">Phone Number</label>
                                <div class="mt-2">
                                    <input id="lead-edit-phone" type="tel" x-model="leadEditForm.phone" class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6" />
                                </div>
                            </div>
                            <div>
                                <label for="lead-edit-country" class="block text-sm/6 font-medium text-gray-900">Country</label>
                                <div class="relative mt-2" x-on:click.outside="leadSelectOpen === 'country' && (leadSelectOpen = '')">
                                    <button id="lead-edit-country" type="button" x-on:click="toggleLeadSelect('country')" class="flex h-10 w-full items-center justify-between rounded-md bg-white px-3 text-left text-sm/6 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 transition hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-600">
                                        <span class="flex min-w-0 items-center gap-2">
                                            <span class="inline-flex size-5 shrink-0 overflow-hidden rounded-full ring-1 ring-gray-200">
                                                <img :src="countryFlagUrl(leadEditForm.country)" :alt="`${leadEditForm.country || 'US'} flag`" class="size-full object-cover" loading="lazy">
                                            </span>
                                            <span class="truncate" x-text="leadCountryLabel(leadEditForm.country)"></span>
                                        </span>
                                        <span class="outcraft-icon ml-3 shrink-0 text-gray-500">keyboard_arrow_down</span>
                                    </button>
                                    <div x-cloak x-show="leadSelectOpen === 'country'" class="absolute z-30 mt-2 max-h-64 w-full overflow-auto rounded-md bg-white py-1 shadow-lg ring-1 ring-gray-900/10">
                                        <template x-for="countryOption in leadCountryOptions" :key="countryOption.code">
                                            <button type="button" x-on:click="selectLeadCountry(countryOption.code)" class="flex w-full items-center justify-between gap-3 px-3 py-2 text-left text-sm text-gray-900 transition hover:bg-gray-50">
                                                <span class="flex min-w-0 items-center gap-2">
                                                    <span class="inline-flex size-5 shrink-0 overflow-hidden rounded-full ring-1 ring-gray-200">
                                                        <img :src="countryFlagUrl(countryOption)" :alt="`${countryOption.name} flag`" class="size-full object-cover" loading="lazy">
                                                    </span>
                                                    <span class="truncate" x-text="`${countryOption.name} (${countryOption.code})`"></span>
                                                </span>
                                                <span x-show="leadEditForm.country === countryOption.code" class="outcraft-icon text-indigo-600">check</span>
                                            </button>
                                        </template>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <label for="lead-edit-timezone" class="block text-sm/6 font-medium text-gray-900">Timezone</label>
                                <div class="relative mt-2" x-on:click.outside="leadSelectOpen === 'timezone' && (leadSelectOpen = '')">
                                    <button id="lead-edit-timezone" type="button" x-on:click="toggleLeadSelect('timezone')" class="flex h-10 w-full items-center justify-between rounded-md bg-white px-3 text-left text-sm/6 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 transition hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-600">
                                        <span class="truncate" x-text="leadEditForm.timezone || 'Select Timezone'"></span>
                                        <span class="outcraft-icon ml-3 shrink-0 text-gray-500">keyboard_arrow_down</span>
                                    </button>
                                    <div x-cloak x-show="leadSelectOpen === 'timezone'" class="absolute z-30 mt-2 max-h-64 w-full overflow-auto rounded-md bg-white py-1 shadow-lg ring-1 ring-gray-900/10">
                                        <template x-for="timezoneOption in leadTimezoneOptions" :key="timezoneOption">
                                            <button type="button" x-on:click="selectLeadTimezone(timezoneOption)" class="flex w-full items-center justify-between gap-3 px-3 py-2 text-left text-sm text-gray-900 transition hover:bg-gray-50">
                                                <span x-text="timezoneOption"></span>
                                                <span x-show="leadEditForm.timezone === timezoneOption" class="outcraft-icon text-indigo-600">check</span>
                                            </button>
                                        </template>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <label for="lead-edit-created" class="block text-sm/6 font-medium text-gray-900">Created</label>
                                <div class="relative mt-2" x-on:click.outside="leadCreatedCalendarOpen = false">
                                    <button id="lead-edit-created" type="button" x-on:click="toggleLeadCreatedCalendar()" class="flex h-10 w-full items-center justify-between rounded-md bg-white px-3 text-left text-sm/6 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 transition hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-600">
                                        <span class="truncate" x-text="formatLeadCreatedLabel(leadEditForm.createdDate)"></span>
                                        <span class="outcraft-icon ml-3 shrink-0 text-gray-500">calendar</span>
                                    </button>
                                    <div x-cloak x-show="leadCreatedCalendarOpen" class="absolute left-0 z-30 mt-2 w-80 rounded-lg bg-white p-3 shadow-lg ring-1 ring-gray-900/10">
                                        <div class="flex items-center gap-2">
                                            <button type="button" x-on:click="moveLeadCreatedCalendar(-1)" class="inline-flex size-8 items-center justify-center rounded-md text-gray-500 hover:bg-gray-50 hover:text-gray-900" aria-label="Previous month">
                                                <span class="outcraft-icon !text-[16px]">chevron-left</span>
                                            </button>
                                            <div class="relative flex-1" x-on:click.outside="leadCalendarMenuOpen === 'month' && (leadCalendarMenuOpen = '')">
                                                <button type="button" x-on:click="toggleLeadCalendarMenu('month')" class="flex h-8 w-full items-center justify-between rounded-md bg-white px-2 text-sm font-semibold text-gray-900 ring-1 ring-inset ring-gray-300 hover:bg-gray-50">
                                                    <span x-text="leadCreatedCalendarMonthName()"></span>
                                                    <span class="outcraft-icon ml-2 text-gray-500">keyboard_arrow_down</span>
                                                </button>
                                                <div x-cloak x-show="leadCalendarMenuOpen === 'month'" class="absolute z-40 mt-1 max-h-56 w-full overflow-auto rounded-md bg-white py-1 shadow-lg ring-1 ring-gray-900/10">
                                                    <template x-for="(monthName, monthIndex) in leadCalendarMonths" :key="monthName">
                                                        <button type="button" x-on:click="selectLeadCreatedMonth(monthIndex)" class="flex w-full items-center justify-between px-3 py-2 text-left text-sm text-gray-900 hover:bg-gray-50">
                                                            <span x-text="monthName"></span>
                                                            <span x-show="leadCreatedCalendarMonthIndex() === monthIndex" class="outcraft-icon text-indigo-600">check</span>
                                                        </button>
                                                    </template>
                                                </div>
                                            </div>
                                            <div class="relative w-28" x-on:click.outside="leadCalendarMenuOpen === 'year' && (leadCalendarMenuOpen = '')">
                                                <button type="button" x-on:click="toggleLeadCalendarMenu('year')" class="flex h-8 w-full items-center justify-between rounded-md bg-white px-2 text-sm font-semibold text-gray-900 ring-1 ring-inset ring-gray-300 hover:bg-gray-50">
                                                    <span x-text="leadCreatedCalendarYear()"></span>
                                                    <span class="outcraft-icon ml-2 text-gray-500">keyboard_arrow_down</span>
                                                </button>
                                                <div x-cloak x-show="leadCalendarMenuOpen === 'year'" class="absolute right-0 z-40 mt-1 max-h-56 w-full overflow-auto rounded-md bg-white py-1 shadow-lg ring-1 ring-gray-900/10">
                                                    <template x-for="yearOption in leadCreatedYearOptions()" :key="yearOption">
                                                        <button type="button" x-on:click="selectLeadCreatedYear(yearOption)" class="flex w-full items-center justify-between px-3 py-2 text-left text-sm text-gray-900 hover:bg-gray-50">
                                                            <span x-text="yearOption"></span>
                                                            <span x-show="leadCreatedCalendarYear() === yearOption" class="outcraft-icon text-indigo-600">check</span>
                                                        </button>
                                                    </template>
                                                </div>
                                            </div>
                                            <button type="button" x-on:click="moveLeadCreatedCalendar(1)" class="inline-flex size-8 items-center justify-center rounded-md text-gray-500 hover:bg-gray-50 hover:text-gray-900" aria-label="Next month">
                                                <span class="outcraft-icon !text-[16px]">chevron-right</span>
                                            </button>
                                        </div>
                                        <div class="mt-3 grid grid-cols-7 text-center text-xs/6 font-medium text-gray-500">
                                            <span>Mo</span>
                                            <span>Tu</span>
                                            <span>We</span>
                                            <span>Th</span>
                                            <span>Fr</span>
                                            <span>Sa</span>
                                            <span>Su</span>
                                        </div>
                                        <div class="mt-2 grid grid-cols-7 gap-1 text-sm">
                                            <template x-for="day in leadCreatedCalendarDays()" :key="day.key">
                                                <span class="block size-8">
                                                    <span x-show="day.blank" class="block size-8"></span>
                                                    <button x-show="! day.blank" type="button" x-on:click="selectLeadCreatedDate(day.date)" class="inline-flex size-8 items-center justify-center rounded-md text-sm transition" :class="day.selected ? 'bg-indigo-600 text-white hover:bg-indigo-500' : 'text-gray-700 hover:bg-gray-50'" x-text="day.day"></button>
                                                </span>
                                            </template>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <label for="lead-edit-status" class="block text-sm/6 font-medium text-gray-900">Status</label>
                                <div class="relative mt-2" x-on:click.outside="leadSelectOpen === 'status' && (leadSelectOpen = '')">
                                    <button id="lead-edit-status" type="button" x-on:click="toggleLeadSelect('status')" class="flex h-10 w-full items-center justify-between rounded-md bg-white px-3 text-left text-sm/6 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 transition hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-600">
                                        <span class="truncate" x-text="leadEditForm.state || 'Select Status'"></span>
                                        <span class="outcraft-icon ml-3 shrink-0 text-gray-500">keyboard_arrow_down</span>
                                    </button>
                                    <div x-cloak x-show="leadSelectOpen === 'status'" class="absolute z-30 mt-2 w-full rounded-md bg-white py-1 shadow-lg ring-1 ring-gray-900/10">
                                        <template x-for="stateOption in leadStateOptions" :key="stateOption">
                                            <button type="button" x-on:click="selectLeadStatus(stateOption)" class="flex w-full items-center justify-between gap-3 px-3 py-2 text-left text-sm text-gray-900 transition hover:bg-gray-50">
                                                <span x-text="stateOption"></span>
                                                <span x-show="leadEditForm.state === stateOption" class="outcraft-icon text-indigo-600">check</span>
                                            </button>
                                        </template>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mt-6 flex items-center gap-3">
                            <button type="button" x-on:click="cancelLeadDetailsEdit()" class="rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm outline outline-1 -outline-offset-1 outline-gray-300 transition hover:bg-gray-50">Cancel</button>
                            <button type="submit" class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Save</button>
                        </div>
                    </form>
                </section>

                <section class="overflow-hidden rounded-lg bg-white shadow-sm ring-1 ring-gray-900/5">
                    <div class="flex items-start justify-between gap-4 px-4 py-5 sm:px-6">
                        <div>
                            <h2 class="text-base/7 font-semibold text-gray-950">Campaign Runs</h2>
                            <p class="mt-1 text-sm/6 text-gray-500">Campaign assignments, delivery status, and response outcomes for this lead.</p>
                        </div>
                        <div class="relative shrink-0" x-on:click.outside="campaignRunsActionOpen = false">
                                                    <button type="button" x-on:click="campaignRunsActionOpen = ! campaignRunsActionOpen" class="-m-2.5 inline-flex p-2.5 text-gray-500 transition hover:text-gray-900" aria-label="Campaign run actions">
                                                        <span class="outcraft-icon !text-[20px]">more_vert</span>
                                                    </button>
                            <div x-cloak x-show="campaignRunsActionOpen" class="absolute right-0 z-30 mt-2 w-52 rounded-md bg-white py-1 shadow-lg ring-1 ring-gray-900/10">
                                <button type="button" x-on:click="campaignRunsActionOpen = false" class="flex w-full items-center gap-3 px-3 py-2 text-left text-sm text-gray-700 transition hover:bg-gray-50 hover:text-gray-950">
                                    <span class="outcraft-icon !text-[16px] text-gray-400">plus</span>
                                    Assign campaign
                                </button>
                                <button type="button" x-on:click="campaignRunsActionOpen = false" class="flex w-full items-center gap-3 px-3 py-2 text-left text-sm text-gray-700 transition hover:bg-gray-50 hover:text-gray-950">
                                    <span class="outcraft-icon !text-[16px] text-gray-400">refresh-cw</span>
                                    Recalculate price
                                </button>
                            </div>
                        </div>
                    </div>
                    <ul role="list" class="divide-y divide-gray-100">
                        <template x-for="campaignRow in leadCampaignRows()" :key="campaignRow.campaign">
                            <li class="px-4 py-5 sm:px-6">
                                <div class="flex items-start justify-between gap-4">
                                    <div class="min-w-0">
                                        <p class="truncate text-sm font-medium leading-6 text-gray-950" x-text="campaignRow.campaign"></p>
                                        <p class="mt-1 text-sm leading-6 text-gray-500">Created <span x-text="campaignRow.created"></span> · <span x-text="campaignRow.price"></span></p>
                                    </div>
                                    <span class="inline-flex shrink-0 rounded-full px-2 py-1 text-xs font-medium ring-1 ring-inset" :class="campaignBadgeClass(campaignRow.status)" x-text="campaignRow.status"></span>
                                </div>
                                <div class="mt-4 grid grid-cols-2 gap-3 text-sm">
                                    <div>
                                        <p class="text-sm/6 font-medium text-gray-900">First interaction</p>
                                        <div class="mt-2">
                                            <span class="inline-flex max-w-full rounded-full px-2 py-1 text-xs font-medium ring-1 ring-inset" :class="campaignBadgeClass(campaignRow.firstInteraction)">
                                                <span class="truncate" x-text="campaignRow.firstInteraction"></span>
                                            </span>
                                        </div>
                                    </div>
                                    <div>
                                        <p class="text-sm/6 font-medium text-gray-900">Follow up</p>
                                        <div class="mt-2">
                                            <span class="inline-flex max-w-full rounded-full px-2 py-1 text-xs font-medium ring-1 ring-inset" :class="campaignBadgeClass(campaignRow.followUp || 'Pending')">
                                                <span class="truncate" x-text="campaignRow.followUp || 'Pending'"></span>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        </template>
                    </ul>
                </section>
            </div>

            <section class="mt-6 min-w-0 overflow-hidden rounded-lg bg-white shadow-sm ring-1 ring-gray-900/5">
                <div class="flex flex-col gap-4 px-4 py-5 sm:px-6 lg:flex-row lg:items-start lg:justify-between">
                    <div class="min-w-0">
                        <h2 class="text-base/7 font-semibold text-gray-950">Interactions</h2>
                        <p class="mt-1 max-w-3xl text-sm/6 text-gray-500">Timeline of calls, emails, SMS, and WhatsApp touchpoints tied to this lead.</p>
                    </div>
                    <div class="relative w-full shrink-0 sm:w-64" x-on:click.outside="leadInteractionChannelMenuOpen = false">
                        <button
                            type="button"
                            x-on:click="leadInteractionChannelMenuOpen = ! leadInteractionChannelMenuOpen"
                            class="flex h-10 w-full items-center justify-between gap-3 rounded-md bg-white px-3 text-left text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 transition hover:bg-gray-50"
                            :aria-expanded="leadInteractionChannelMenuOpen.toString()"
                        >
                            <span class="min-w-0 truncate" x-text="leadInteractionChannelFilterLabel()"></span>
                            <span class="outcraft-icon !text-[18px] text-gray-400 transition" :class="leadInteractionChannelMenuOpen ? 'rotate-180' : ''">keyboard_arrow_down</span>
                        </button>
                        <div
                            x-cloak
                            x-show="leadInteractionChannelMenuOpen"
                            x-transition:enter="transition ease-out duration-100"
                            x-transition:enter-start="opacity-0 translate-y-1"
                            x-transition:enter-end="opacity-100 translate-y-0"
                            x-transition:leave="transition ease-in duration-75"
                            x-transition:leave-start="opacity-100 translate-y-0"
                            x-transition:leave-end="opacity-0 translate-y-1"
                            data-dropdown-surface
                            data-panel-surface
                            class="absolute right-0 z-40 mt-2 w-full overflow-hidden rounded-md bg-white py-1 shadow-lg ring-1 ring-gray-900/10"
                        >
                            <template x-for="channel in leadInteractionChannelOptions()" :key="channel.label">
                                <label class="flex w-full cursor-pointer items-center gap-3 px-3 py-2 text-sm text-gray-700 transition hover:bg-gray-50 hover:text-gray-950">
                                    <input
                                        type="checkbox"
                                        :checked="isLeadInteractionChannelSelected(channel.label)"
                                        x-on:change="toggleLeadInteractionChannel(channel.label)"
                                        class="size-4 rounded border-gray-300 text-[rgb(var(--oc-primary-600-rgb))] accent-[rgb(var(--oc-primary-600-rgb))] focus:ring-[rgb(var(--oc-primary-600-rgb))]"
                                    >
                                    <span class="min-w-0 flex-1 truncate font-medium" x-text="channel.label"></span>
                                    <span class="shrink-0 text-xs text-gray-500" x-text="channel.count"></span>
                                </label>
                            </template>
                        </div>
                    </div>
                </div>
                <div class="grid grid-cols-1 border-t border-gray-100 lg:grid-cols-[minmax(0,2fr)_minmax(280px,1fr)]">
                    <ul role="list" class="min-w-0">
                        <template x-for="(interaction, index) in filteredLeadInteractions()" :key="interaction.id">
                            <li class="group/interaction relative px-4 py-6 sm:px-6">
                                <span x-show="index < filteredLeadInteractions().length - 1" class="pointer-events-none absolute left-[34px] top-[42px] bottom-[-42px] w-px bg-gray-200 sm:left-[42px]"></span>
                                <div class="flex min-w-0 gap-4">
                                    <div class="relative z-10 flex shrink-0 flex-col items-center">
                                        <span class="flex size-9 items-center justify-center rounded-md ring-1" :class="interactionTimelineIconTileClass(interaction)">
                                            <span x-show="interaction.channel === 'WhatsApp'" class="size-[18px]" x-html="whatsappIconSvg()"></span>
                                            <span x-show="interaction.channel !== 'WhatsApp'" class="outcraft-icon !text-[18px]" x-text="interaction.timelineIcon || (interaction.direction === 'Incoming' ? 'arrow_downward' : 'arrow_upward')"></span>
                                        </span>
                                    </div>
                                    <div class="min-w-0 flex-1">
                                        <div class="flex flex-wrap items-start justify-between gap-x-6 gap-y-2">
                                            <div>
                                                <p class="text-sm font-semibold leading-6 text-gray-950" x-text="interaction.title"></p>
                                                <p class="text-sm leading-6 text-gray-500"><span x-text="interaction.relative"></span> · <span x-text="interaction.date"></span> · <span x-text="interaction.time"></span></p>
                                            </div>
                                            <span class="inline-flex rounded-md px-2 py-1 text-xs font-medium ring-1 ring-inset" :class="interaction.statusClass" x-text="interaction.status"></span>
                                        </div>

                                        <div class="mt-4 flex flex-wrap items-center gap-2">
                                            <span class="inline-flex items-center gap-1.5 rounded-md bg-gray-50 px-2 py-1 text-xs font-medium text-gray-600 ring-1 ring-inset ring-gray-500/10">
                                                <span x-show="interaction.channel === 'WhatsApp'" class="size-[14px]" x-html="whatsappIconSvg()"></span>
                                                <span x-show="interaction.channel !== 'WhatsApp'" class="outcraft-icon !text-[14px]" x-text="interaction.icon"></span>
                                                <span x-text="interaction.channel"></span>
                                            </span>
                                            <span class="inline-flex rounded-md bg-gray-50 px-2 py-1 text-xs font-medium text-gray-600 ring-1 ring-inset ring-gray-500/10" x-text="interaction.direction"></span>
                                            <span class="inline-flex rounded-md bg-indigo-50 px-2 py-1 text-xs font-medium text-indigo-700 ring-1 ring-inset ring-indigo-600/20" x-text="interaction.campaign"></span>
                                        </div>

                                        <p x-show="interaction.summary" class="mt-4 max-w-3xl text-sm leading-6 text-gray-700" x-text="interaction.summary"></p>

                                        <div class="mt-4 max-w-full space-y-2">
                                            <div x-show="interaction.audio" class="mb-3 flex h-9 w-full items-center gap-3 rounded-full bg-gray-50 px-3 text-gray-600 ring-1 ring-inset ring-gray-200">
                                                <span class="outcraft-icon !text-[18px]">play_arrow</span>
                                                <div class="h-1 flex-1 rounded-full bg-gray-300"></div>
                                                <span class="outcraft-icon !text-[17px]">volume_up</span>
                                                <span class="outcraft-icon !text-[17px]">more_vert</span>
                                            </div>
                                            <div class="space-y-2 pr-0 sm:pr-2" :class="interaction.messages.length > 6 && ! isInteractionExpanded(interaction.id) ? 'max-h-[500px] overflow-y-auto' : ''">
                                                <template x-for="(message, index) in interaction.messages" :key="interaction.id + '-' + index">
                                                    <div class="flex min-w-0">
                                                        <div
                                                            class="inline-block w-fit max-w-full rounded-lg px-4 py-3 text-sm leading-6"
                                                            :class="message.kind === 'ai' ? 'bg-indigo-50 text-indigo-950 ring-1 ring-inset ring-indigo-100' : 'bg-gray-50 text-gray-900 ring-1 ring-inset ring-gray-200'"
                                                            :style="{ maxWidth: messageBubbleMaxWidth(message) }"
                                                        >
                                                            <span x-show="message.speaker" class="font-semibold" x-text="message.speaker + ': '"></span><span x-text="message.text"></span>
                                                        </div>
                                                    </div>
                                                </template>
                                            </div>
                                            <button
                                                x-show="interaction.messages.length > 6"
                                                type="button"
                                                x-on:click="toggleInteractionExpanded(interaction.id)"
                                                class="mt-3 inline-flex h-9 items-center gap-2 rounded-md bg-white px-3 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 transition hover:bg-gray-50"
                                            >
                                                <span class="outcraft-icon !text-[17px]" x-text="isInteractionExpanded(interaction.id) ? 'unfold_less' : 'unfold_more'"></span>
                                                <span x-text="isInteractionExpanded(interaction.id) ? 'Collapse' : 'Expand'"></span>
                                            </button>
                                            <p x-show="interaction.note" class="pt-3 text-sm leading-6 text-gray-500" x-text="interaction.note"></p>
                                        </div>

                                    </div>
                                </div>
                            </li>
                        </template>
                        <li x-show="filteredLeadInteractions().length === 0" class="px-4 py-12 text-center sm:px-6">
                            <span class="mx-auto flex size-10 items-center justify-center rounded-md bg-gray-50 text-gray-400 ring-1 ring-inset ring-gray-200">
                                <span class="outcraft-icon !text-[20px]">filter_alt</span>
                            </span>
                            <p class="mt-3 text-sm font-semibold text-gray-950">No interactions match these filters</p>
                            <p class="mt-1 text-sm text-gray-500">Turn on another channel or reset to all channels.</p>
                        </li>
                    </ul>
                    <aside class="border-t border-gray-100 bg-white p-4 sm:p-6 lg:border-l lg:border-t-0">
                        <div class="lg:sticky lg:top-20">
                            <h3 class="text-sm font-semibold text-gray-950">Teach the AI</h3>
                            <p class="mt-1 text-sm leading-6 text-gray-500">Leave feedback that helps the agent improve future lead communication.</p>
                            <div class="mt-5 flex items-center gap-1">
                                <button type="button" x-on:click="leadInteractionFeedbackRating = 'up'" class="inline-flex size-9 items-center justify-center rounded-md transition" :class="leadInteractionFeedbackRating === 'up' ? 'bg-emerald-50 text-emerald-700' : 'text-gray-400 hover:bg-gray-50 hover:text-gray-700'" aria-label="Thumbs up">
                                    <span class="outcraft-icon !text-[20px]">thumbs-up</span>
                                </button>
                                <button type="button" x-on:click="leadInteractionFeedbackRating = 'down'" class="inline-flex size-9 items-center justify-center rounded-md transition" :class="leadInteractionFeedbackRating === 'down' ? 'bg-rose-50 text-rose-700' : 'text-gray-400 hover:bg-gray-50 hover:text-gray-700'" aria-label="Thumbs down">
                                    <span class="outcraft-icon !text-[20px]">thumbs-down</span>
                                </button>
                            </div>
                            <label class="mt-4 block">
                                <span class="text-sm font-medium text-gray-900">Feedback</span>
                                <textarea x-model="leadInteractionFeedbackText" rows="6" class="mt-2 block w-full resize-none rounded-md border-0 bg-white px-3 py-2 text-sm leading-6 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600" placeholder="What should the AI learn for next time?"></textarea>
                            </label>
                            <button type="button" class="mt-4 inline-flex h-10 items-center justify-center rounded-md bg-white px-4 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 transition hover:bg-gray-50">
                                <span>Teach AI</span>
                            </button>
                        </div>
                    </aside>
                </div>
            </section>
        </section>
