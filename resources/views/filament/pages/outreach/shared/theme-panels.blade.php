    <div
        x-cloak
        x-show="primaryThemePanelOpen"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 -translate-x-4"
        x-transition:enter-end="opacity-100 translate-x-0"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 translate-x-0"
        x-transition:leave-end="opacity-0 -translate-x-4"
        class="fixed bottom-4 left-4 top-4 z-[120] flex w-[22rem] max-w-[calc(100vw-2rem)] flex-col overflow-hidden rounded-lg bg-white shadow-2xl ring-1 ring-gray-900/10"
    >
        <div class="border-b border-gray-200 px-4 py-4">
            <div class="flex items-start justify-between gap-3">
                <div>
                    <p class="text-sm font-semibold leading-6 text-gray-950">Interface Colors</p>
                    <p class="mt-1 text-xs leading-5 text-gray-500">Choose a role, then pick the Tailwind color it should use.</p>
                </div>
                <button type="button" x-on:click="primaryThemePanelOpen = false" class="inline-flex size-8 items-center justify-center rounded-md text-gray-400 transition hover:bg-gray-50 hover:text-gray-700">
                    <span class="outcraft-icon !text-[18px]">close</span>
                </button>
            </div>
        </div>
        <div class="min-h-0 flex-1 overflow-y-auto p-4">
            <label class="block">
                <span class="block text-sm font-semibold leading-6 text-gray-950">Color Role</span>
                <x-outcraft.select
                    class="mt-2"
                    model="activeColorRole"
                    options="colorRoleOptions"
                    value-key="key"
                    label-key="label"
                    button-class="h-9"
                />
                <span class="mt-2 block text-xs leading-5 text-gray-500" x-text="activeColorRoleDescription()"></span>
            </label>

            <label x-show="activeColorRole === 'primary'" class="mt-4 block">
                <span class="block text-sm font-semibold leading-6 text-gray-950">Primary Shade</span>
                <x-outcraft.select
                    class="mt-2"
                    model="primaryThemeValue"
                    options="primaryThemeValueOptions"
                    label-prefix="Primary "
                    button-class="h-9"
                    on-change="previewPrimaryThemeValue(primaryThemeValue); setPrimaryThemeValue(primaryThemeValue)"
                />
                <span class="mt-2 block text-xs leading-5 text-gray-500">Choose which Tailwind shade should act as the main primary color.</span>
            </label>

            <div class="mt-4 grid gap-2">
                <template x-for="color in primaryThemeColors" :key="color.key">
                    <button
                        type="button"
                        x-on:click="setColorRoleTheme(activeColorRole, color.key)"
                        class="rounded-lg border bg-white p-3 text-left shadow-sm transition hover:border-indigo-600 hover:bg-gray-50 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
                        :class="isColorRoleThemeSelected(activeColorRole, color.key) ? 'border-indigo-600 bg-indigo-50' : 'border-gray-200'"
                    >
                        <span class="flex items-center justify-between gap-3">
                            <span class="flex min-w-0 items-center gap-3">
                                <span class="size-6 shrink-0 rounded-full ring-1 ring-gray-950/10" :style="`background-color: ${color.shades[600]}`"></span>
                                <span class="truncate text-sm font-semibold leading-6 text-gray-950" x-text="color.label"></span>
                            </span>
                            <span x-show="isColorRoleThemeSelected(activeColorRole, color.key)" class="outcraft-icon !text-[16px] text-indigo-600">check</span>
                        </span>
                        <span class="mt-3 flex overflow-hidden rounded-md ring-1 ring-gray-200">
                            <template x-for="shade in primaryThemeShadeKeys" :key="`${color.key}-${shade}`">
                                <span class="h-5 flex-1" :style="`background-color: ${color.shades[shade]}`"></span>
                            </template>
                        </span>
                    </button>
                </template>
            </div>
        </div>
    </div>

    <div
        x-cloak
        x-show="radiusPanelOpen"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 -translate-x-4"
        x-transition:enter-end="opacity-100 translate-x-0"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 translate-x-0"
        x-transition:leave-end="opacity-0 -translate-x-4"
        class="fixed bottom-4 left-4 top-4 z-[120] flex w-[22rem] max-w-[calc(100vw-2rem)] flex-col overflow-hidden rounded-lg bg-white shadow-2xl ring-1 ring-gray-900/10"
    >
        <div class="border-b border-gray-200 px-4 py-4">
            <div class="flex items-start justify-between gap-3">
                <div>
                    <p class="text-sm font-semibold leading-6 text-gray-950">Corner Radius</p>
                    <p class="mt-1 text-xs leading-5 text-gray-500">Press R to open or close this Tailwind radius panel.</p>
                </div>
                <button type="button" x-on:click="radiusPanelOpen = false" class="inline-flex size-8 items-center justify-center rounded-md text-gray-400 transition hover:bg-gray-50 hover:text-gray-700">
                    <span class="outcraft-icon !text-[18px]">close</span>
                </button>
            </div>
        </div>
        <div class="min-h-0 flex-1 space-y-6 overflow-y-auto p-4">
            <section>
                <div class="flex items-center justify-between gap-3">
                    <div>
                        <p class="text-sm font-semibold leading-6 text-gray-950">Buttons</p>
                        <p class="text-xs leading-5 text-gray-500">Applies to button corners and button-like actions.</p>
                    </div>
                    <span class="rounded-md bg-gray-50 px-2 py-1 text-xs font-medium text-gray-600 ring-1 ring-inset ring-gray-200" x-text="selectedRadiusLabel(buttonRadius)"></span>
                </div>
                <div class="mt-3 grid grid-cols-2 gap-2">
                    <template x-for="radius in radiusOptions" :key="`button-${radius.key}`">
                        <button
                            type="button"
                            x-on:click="setRadiusTheme('button', radius.key)"
                            class="border bg-white p-3 text-left shadow-sm transition hover:border-indigo-600 hover:bg-gray-50 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
                            :class="buttonRadius === radius.key ? 'border-indigo-600 bg-indigo-50' : 'border-gray-200'"
                            :style="`border-radius: ${radius.value}`"
                        >
                            <span class="flex items-center justify-between gap-2">
                                <span class="text-sm font-semibold leading-6 text-gray-950" x-text="radius.className"></span>
                                <span x-show="buttonRadius === radius.key" class="outcraft-icon !text-[16px] text-indigo-600">check</span>
                            </span>
                            <span class="mt-2 block h-7 w-full bg-indigo-600" :style="`border-radius: ${radius.value}`"></span>
                        </button>
                    </template>
                </div>
            </section>

            <section>
                <div class="flex items-center justify-between gap-3">
                    <div>
                        <p class="text-sm font-semibold leading-6 text-gray-950">Fields</p>
                        <p class="text-xs leading-5 text-gray-500">Applies to text inputs, selects, textareas, and custom fields.</p>
                    </div>
                    <span class="rounded-md bg-gray-50 px-2 py-1 text-xs font-medium text-gray-600 ring-1 ring-inset ring-gray-200" x-text="selectedRadiusLabel(fieldRadius)"></span>
                </div>
                <div class="mt-3 grid grid-cols-2 gap-2">
                    <template x-for="radius in radiusOptions" :key="`field-${radius.key}`">
                        <button
                            type="button"
                            x-on:click="setRadiusTheme('field', radius.key)"
                            class="border bg-white p-3 text-left shadow-sm transition hover:border-indigo-600 hover:bg-gray-50 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
                            :class="fieldRadius === radius.key ? 'border-indigo-600 bg-indigo-50' : 'border-gray-200'"
                            :style="`border-radius: ${radius.value}`"
                        >
                            <span class="flex items-center justify-between gap-2">
                                <span class="text-sm font-semibold leading-6 text-gray-950" x-text="radius.className"></span>
                                <span x-show="fieldRadius === radius.key" class="outcraft-icon !text-[16px] text-indigo-600">check</span>
                            </span>
                            <span class="mt-2 block h-7 w-full border border-gray-300 bg-white" :style="`border-radius: ${radius.value}`"></span>
                        </button>
                    </template>
                </div>
            </section>

            <section>
                <div class="flex items-center justify-between gap-3">
                    <div>
                        <p class="text-sm font-semibold leading-6 text-gray-950">Cards</p>
                        <p class="text-xs leading-5 text-gray-500">Applies to selection cards, setup cards, and bordered content blocks.</p>
                    </div>
                    <span class="rounded-md bg-gray-50 px-2 py-1 text-xs font-medium text-gray-600 ring-1 ring-inset ring-gray-200" x-text="selectedRadiusLabel(cardRadius)"></span>
                </div>
                <div class="mt-3 grid grid-cols-2 gap-2">
                    <template x-for="radius in radiusOptions" :key="`card-${radius.key}`">
                        <button
                            type="button"
                            x-on:click="setRadiusTheme('card', radius.key)"
                            class="border bg-white p-3 text-left shadow-sm transition hover:border-indigo-600 hover:bg-gray-50 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
                            :class="cardRadius === radius.key ? 'border-indigo-600 bg-indigo-50' : 'border-gray-200'"
                            :style="`border-radius: ${radius.value}`"
                        >
                            <span class="flex items-center justify-between gap-2">
                                <span class="text-sm font-semibold leading-6 text-gray-950" x-text="radius.className"></span>
                                <span x-show="cardRadius === radius.key" class="outcraft-icon !text-[16px] text-indigo-600">check</span>
                            </span>
                            <span class="mt-2 block h-12 w-full border border-gray-200 bg-white shadow-sm" :style="`border-radius: ${radius.value}`"></span>
                        </button>
                    </template>
                </div>
            </section>

            <section>
                <div class="flex items-center justify-between gap-3">
                    <div>
                        <p class="text-sm font-semibold leading-6 text-gray-950">Icon Tiles</p>
                        <p class="text-xs leading-5 text-gray-500">Applies to square backgrounds behind icons and integration logos.</p>
                    </div>
                    <span class="rounded-md bg-gray-50 px-2 py-1 text-xs font-medium text-gray-600 ring-1 ring-inset ring-gray-200" x-text="selectedRadiusLabel(iconTileRadius)"></span>
                </div>
                <div class="mt-3 grid grid-cols-2 gap-2">
                    <template x-for="radius in radiusOptions" :key="`icon-tile-${radius.key}`">
                        <button
                            type="button"
                            x-on:click="setRadiusTheme('iconTile', radius.key)"
                            class="border bg-white p-3 text-left shadow-sm transition hover:border-indigo-600 hover:bg-gray-50 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
                            :class="iconTileRadius === radius.key ? 'border-indigo-600 bg-indigo-50' : 'border-gray-200'"
                            :style="`border-radius: ${radius.value}`"
                        >
                            <span class="flex items-center justify-between gap-2">
                                <span class="text-sm font-semibold leading-6 text-gray-950" x-text="radius.className"></span>
                                <span x-show="iconTileRadius === radius.key" class="outcraft-icon !text-[16px] text-indigo-600">check</span>
                            </span>
                            <span class="mt-2 flex size-10 items-center justify-center bg-indigo-50 text-indigo-600" :style="`border-radius: ${radius.value}`">
                                <span class="outcraft-icon !text-[20px]">sparkles</span>
                            </span>
                        </button>
                    </template>
                </div>
            </section>
        </div>
    </div>

    <div
        x-cloak
        x-show="shadowPanelOpen"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 -translate-x-4"
        x-transition:enter-end="opacity-100 translate-x-0"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 translate-x-0"
        x-transition:leave-end="opacity-0 -translate-x-4"
        class="fixed bottom-4 left-4 top-4 z-[120] flex w-[22rem] max-w-[calc(100vw-2rem)] flex-col overflow-hidden rounded-lg bg-white shadow-2xl ring-1 ring-gray-900/10"
    >
        <div class="border-b border-gray-200 px-4 py-4">
            <div class="flex items-start justify-between gap-3">
                <div>
                    <p class="text-sm font-semibold leading-6 text-gray-950">Shadows</p>
                    <p class="mt-1 text-xs leading-5 text-gray-500">Press S to open or close this Tailwind shadow panel.</p>
                </div>
                <button type="button" x-on:click="shadowPanelOpen = false" class="inline-flex size-8 items-center justify-center rounded-md text-gray-400 transition hover:bg-gray-50 hover:text-gray-700">
                    <span class="outcraft-icon !text-[18px]">close</span>
                </button>
            </div>
        </div>
        <div class="min-h-0 flex-1 space-y-6 overflow-y-auto p-4">
            <section>
                <div class="flex items-center justify-between gap-3">
                    <div>
                        <p class="text-sm font-semibold leading-6 text-gray-950">Cards</p>
                        <p class="text-xs leading-5 text-gray-500">Applies to bordered white cards and content blocks.</p>
                    </div>
                    <span class="rounded-md bg-gray-50 px-2 py-1 text-xs font-medium text-gray-600 ring-1 ring-inset ring-gray-200" x-text="selectedShadowLabel(cardShadow)"></span>
                </div>
                <button
                    type="button"
                    data-shadow-control
                    x-on:click="toggleCardBorder()"
                    role="switch"
                    :aria-checked="cardBorderEnabled.toString()"
                    class="mt-3 flex w-full items-center justify-between gap-4 rounded-lg border border-gray-200 bg-white p-3 text-left shadow-sm transition hover:border-indigo-600 hover:bg-gray-50 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
                >
                    <span>
                        <span class="block text-sm font-semibold leading-6 text-gray-950">Card Border</span>
                        <span class="block text-xs leading-5 text-gray-500">Keep a Tailwind 1px border around every card surface.</span>
                    </span>
                    <span
                        class="relative inline-flex h-6 w-11 shrink-0 rounded-full p-0.5 transition"
                        :class="cardBorderEnabled ? 'bg-indigo-600' : 'bg-gray-200'"
                    >
                        <span
                            class="size-5 rounded-full bg-white shadow-sm transition"
                            :class="cardBorderEnabled ? 'translate-x-5' : 'translate-x-0'"
                        ></span>
                    </span>
                </button>
                <div class="mt-3 grid grid-cols-2 gap-2">
                    <template x-for="shadow in shadowOptions" :key="`card-shadow-${shadow.key}`">
                        <button
                            type="button"
                            data-shadow-control
                            x-on:click="setShadowTheme('card', shadow.key)"
                            class="rounded-lg border bg-white p-3 text-left shadow-sm transition hover:border-indigo-600 hover:bg-gray-50 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
                            :class="cardShadow === shadow.key ? 'border-indigo-600 bg-indigo-50' : 'border-gray-200'"
                        >
                            <span class="flex items-center justify-between gap-2">
                                <span class="text-sm font-semibold leading-6 text-gray-950" x-text="shadow.className"></span>
                                <span x-show="cardShadow === shadow.key" class="outcraft-icon !text-[16px] text-indigo-600">check</span>
                            </span>
                            <span class="mt-2 block h-12 rounded-xl border border-gray-200 bg-white" :style="`box-shadow: ${shadow.value}`"></span>
                        </button>
                    </template>
                </div>
            </section>

            <section>
                <div class="flex items-center justify-between gap-3">
                    <div>
                        <p class="text-sm font-semibold leading-6 text-gray-950">Fields</p>
                        <p class="text-xs leading-5 text-gray-500">Applies to inputs, selects, textareas, and field wrappers.</p>
                    </div>
                    <span class="rounded-md bg-gray-50 px-2 py-1 text-xs font-medium text-gray-600 ring-1 ring-inset ring-gray-200" x-text="selectedShadowLabel(fieldShadow)"></span>
                </div>
                <div class="mt-3 grid grid-cols-2 gap-2">
                    <template x-for="shadow in shadowOptions" :key="`field-shadow-${shadow.key}`">
                        <button
                            type="button"
                            data-shadow-control
                            x-on:click="setShadowTheme('field', shadow.key)"
                            class="rounded-lg border bg-white p-3 text-left shadow-sm transition hover:border-indigo-600 hover:bg-gray-50 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
                            :class="fieldShadow === shadow.key ? 'border-indigo-600 bg-indigo-50' : 'border-gray-200'"
                        >
                            <span class="flex items-center justify-between gap-2">
                                <span class="text-sm font-semibold leading-6 text-gray-950" x-text="shadow.className"></span>
                                <span x-show="fieldShadow === shadow.key" class="outcraft-icon !text-[16px] text-indigo-600">check</span>
                            </span>
                            <span class="mt-2 block h-8 rounded-md border border-gray-300 bg-white" :style="`box-shadow: ${shadow.value}`"></span>
                        </button>
                    </template>
                </div>
            </section>

            <section>
                <div class="flex items-center justify-between gap-3">
                    <div>
                        <p class="text-sm font-semibold leading-6 text-gray-950">Buttons</p>
                        <p class="text-xs leading-5 text-gray-500">Applies to button shadows and button-like actions.</p>
                    </div>
                    <span class="rounded-md bg-gray-50 px-2 py-1 text-xs font-medium text-gray-600 ring-1 ring-inset ring-gray-200" x-text="selectedShadowLabel(buttonShadow)"></span>
                </div>
                <div class="mt-3 grid grid-cols-2 gap-2">
                    <template x-for="shadow in shadowOptions" :key="`button-shadow-${shadow.key}`">
                        <button
                            type="button"
                            data-shadow-control
                            x-on:click="setShadowTheme('button', shadow.key)"
                            class="rounded-lg border bg-white p-3 text-left shadow-sm transition hover:border-indigo-600 hover:bg-gray-50 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
                            :class="buttonShadow === shadow.key ? 'border-indigo-600 bg-indigo-50' : 'border-gray-200'"
                        >
                            <span class="flex items-center justify-between gap-2">
                                <span class="text-sm font-semibold leading-6 text-gray-950" x-text="shadow.className"></span>
                                <span x-show="buttonShadow === shadow.key" class="outcraft-icon !text-[16px] text-indigo-600">check</span>
                            </span>
                            <span class="mt-2 inline-flex h-8 w-full items-center justify-center rounded-3xl bg-indigo-600 text-xs font-medium text-white" :style="`box-shadow: ${shadow.value}`">Button</span>
                        </button>
                    </template>
                </div>
            </section>

            <section>
                <div class="flex items-center justify-between gap-3">
                    <div>
                        <p class="text-sm font-semibold leading-6 text-gray-950">Dropdowns</p>
                        <p class="text-xs leading-5 text-gray-500">Applies to absolute menus, popovers, and dropdown lists.</p>
                    </div>
                    <span class="rounded-md bg-gray-50 px-2 py-1 text-xs font-medium text-gray-600 ring-1 ring-inset ring-gray-200" x-text="selectedShadowLabel(dropdownShadow)"></span>
                </div>
                <div class="mt-3 grid grid-cols-2 gap-2">
                    <template x-for="shadow in shadowOptions" :key="`dropdown-shadow-${shadow.key}`">
                        <button
                            type="button"
                            data-shadow-control
                            x-on:click="setShadowTheme('dropdown', shadow.key)"
                            class="rounded-lg border bg-white p-3 text-left shadow-sm transition hover:border-indigo-600 hover:bg-gray-50 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
                            :class="dropdownShadow === shadow.key ? 'border-indigo-600 bg-indigo-50' : 'border-gray-200'"
                        >
                            <span class="flex items-center justify-between gap-2">
                                <span class="text-sm font-semibold leading-6 text-gray-950" x-text="shadow.className"></span>
                                <span x-show="dropdownShadow === shadow.key" class="outcraft-icon !text-[16px] text-indigo-600">check</span>
                            </span>
                            <span class="mt-2 block rounded-lg border border-gray-200 bg-white p-2" :style="`box-shadow: ${shadow.value}`">
                                <span class="block h-1.5 w-16 rounded bg-gray-200"></span>
                                <span class="mt-1.5 block h-1.5 w-10 rounded bg-gray-100"></span>
                            </span>
                        </button>
                    </template>
                </div>
            </section>

            <section>
                <div class="flex items-center justify-between gap-3">
                    <div>
                        <p class="text-sm font-semibold leading-6 text-gray-950">Panels</p>
                        <p class="text-xs leading-5 text-gray-500">Applies to left control sidebars and floating panels.</p>
                    </div>
                    <span class="rounded-md bg-gray-50 px-2 py-1 text-xs font-medium text-gray-600 ring-1 ring-inset ring-gray-200" x-text="selectedShadowLabel(panelShadow)"></span>
                </div>
                <div class="mt-3 grid grid-cols-2 gap-2">
                    <template x-for="shadow in shadowOptions" :key="`panel-shadow-${shadow.key}`">
                        <button
                            type="button"
                            data-shadow-control
                            x-on:click="setShadowTheme('panel', shadow.key)"
                            class="rounded-lg border bg-white p-3 text-left shadow-sm transition hover:border-indigo-600 hover:bg-gray-50 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
                            :class="panelShadow === shadow.key ? 'border-indigo-600 bg-indigo-50' : 'border-gray-200'"
                        >
                            <span class="flex items-center justify-between gap-2">
                                <span class="text-sm font-semibold leading-6 text-gray-950" x-text="shadow.className"></span>
                                <span x-show="panelShadow === shadow.key" class="outcraft-icon !text-[16px] text-indigo-600">check</span>
                            </span>
                            <span class="mt-2 block h-14 rounded-lg border border-gray-200 bg-white" :style="`box-shadow: ${shadow.value}`"></span>
                        </button>
                    </template>
                </div>
            </section>
        </div>
    </div>

    <div
        x-cloak
        x-show="iconStrokePanelOpen"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 -translate-x-4"
        x-transition:enter-end="opacity-100 translate-x-0"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 translate-x-0"
        x-transition:leave-end="opacity-0 -translate-x-4"
        class="fixed bottom-4 left-4 top-4 z-[120] flex w-[22rem] max-w-[calc(100vw-2rem)] flex-col overflow-hidden rounded-lg bg-white shadow-2xl ring-1 ring-gray-900/10"
    >
        <div class="border-b border-gray-200 px-4 py-4">
            <div class="flex items-start justify-between gap-3">
                <div>
                    <p class="text-sm font-semibold leading-6 text-gray-950">Icon Stroke</p>
                    <p class="mt-1 text-xs leading-5 text-gray-500">Press I to open or close this icon weight panel.</p>
                </div>
                <button type="button" x-on:click="iconStrokePanelOpen = false" class="inline-flex size-8 items-center justify-center rounded-md text-gray-400 transition hover:bg-gray-50 hover:text-gray-700">
                    <span class="outcraft-icon !text-[18px]">close</span>
                </button>
            </div>
        </div>
        <div class="min-h-0 flex-1 overflow-y-auto p-4">
            <div class="rounded-lg border border-gray-200 bg-white p-4 shadow-sm">
                <div class="flex items-center justify-between gap-4">
                    <div>
                        <p class="text-sm font-semibold leading-6 text-gray-950">Stroke Width</p>
                        <p class="text-xs leading-5 text-gray-500">Adjust Lucide icon stroke in pixels.</p>
                    </div>
                    <span class="rounded-md bg-gray-50 px-2 py-1 text-xs font-medium text-gray-600 ring-1 ring-inset ring-gray-200" x-text="`${Number(iconStrokeWidth).toFixed(2).replace(/\.00$/, '')} px`"></span>
                </div>
                <div class="mt-5 flex items-center justify-center rounded-lg bg-gray-50 py-8 ring-1 ring-inset ring-gray-200">
                    <span class="outcraft-icon text-[48px] text-indigo-600">sparkles</span>
                </div>
                <label class="mt-5 block">
                    <span class="sr-only">Icon Stroke Width</span>
                    <input
                        type="range"
                        min="1"
                        max="3"
                        step="0.25"
                        :value="iconStrokeWidth"
                        x-on:input="setIconStrokeWidth($event.target.value)"
                        class="block w-full accent-indigo-600"
                    >
                </label>
                <div class="mt-4 flex items-center gap-3">
                    <input
                        type="number"
                        min="1"
                        max="3"
                        step="0.25"
                        :value="iconStrokeWidth"
                        x-on:input="setIconStrokeWidth($event.target.value)"
                        class="block h-9 w-24 rounded-md bg-white px-3 py-1.5 text-sm text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600"
                    >
                    <span class="text-sm leading-6 text-gray-500">Pixels</span>
                </div>
            </div>

            <div class="mt-4 grid grid-cols-3 gap-2">
                <template x-for="width in iconStrokeWidthOptions" :key="`icon-stroke-${width}`">
                    <button
                        type="button"
                        x-on:click="setIconStrokeWidth(width)"
                        class="rounded-lg border bg-white p-3 text-left shadow-sm transition hover:border-indigo-600 hover:bg-gray-50 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
                        :class="Number(iconStrokeWidth) === Number(width) ? 'border-indigo-600 bg-indigo-50' : 'border-gray-200'"
                    >
                        <span class="flex items-center justify-between gap-2">
                            <span class="text-sm font-semibold leading-6 text-gray-950" x-text="`${width}px`"></span>
                            <span x-show="Number(iconStrokeWidth) === Number(width)" class="outcraft-icon !text-[16px] text-indigo-600">check</span>
                        </span>
                        <span class="mt-2 inline-flex size-8 items-center justify-center rounded-md bg-indigo-50 text-indigo-600">
                            <span class="outcraft-icon !text-[20px]" :style="`--oc-icon-stroke-width: ${width}px`">settings</span>
                        </span>
                    </button>
                </template>
            </div>

        </div>
    </div>

    <div
        x-cloak
        x-show="tabsPanelOpen"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 -translate-x-4"
        x-transition:enter-end="opacity-100 translate-x-0"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 translate-x-0"
        x-transition:leave-end="opacity-0 -translate-x-4"
        class="fixed bottom-4 left-4 top-4 z-[120] flex w-[22rem] max-w-[calc(100vw-2rem)] flex-col overflow-hidden rounded-lg bg-white shadow-2xl ring-1 ring-gray-900/10"
    >
        <div class="border-b border-gray-200 px-4 py-4">
            <div class="flex items-start justify-between gap-3">
                <div>
                    <p class="text-sm font-semibold leading-6 text-gray-950">Tabs</p>
                    <p class="mt-1 text-xs leading-5 text-gray-500">Press Y to open or close this tab style panel.</p>
                </div>
                <button type="button" x-on:click="tabsPanelOpen = false" class="inline-flex size-8 items-center justify-center rounded-md text-gray-400 transition hover:bg-gray-50 hover:text-gray-700">
                    <span class="outcraft-icon !text-[18px]">close</span>
                </button>
            </div>
        </div>
        <div class="min-h-0 flex-1 overflow-y-auto p-4">
            <button
                type="button"
                x-on:click="toggleTopNavTabIcons()"
                role="switch"
                :aria-checked="topNavTabIconsEnabled.toString()"
                class="flex w-full items-center justify-between gap-4 rounded-lg border border-gray-200 bg-white p-4 text-left shadow-sm transition hover:border-indigo-600 hover:bg-gray-50 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
            >
                <span>
                    <span class="block text-sm font-semibold leading-6 text-gray-950">Top Navigation Icons</span>
                    <span class="block text-xs leading-5 text-gray-500">Show icons in Campaigns, Leads, and Analytics tabs.</span>
                </span>
                <span
                    class="relative inline-flex h-6 w-11 shrink-0 rounded-full p-0.5 transition"
                    :class="topNavTabIconsEnabled ? 'bg-indigo-600' : 'bg-gray-200'"
                >
                    <span
                        class="size-5 rounded-full bg-white shadow-sm transition"
                        :class="topNavTabIconsEnabled ? 'translate-x-5' : 'translate-x-0'"
                    ></span>
                </span>
            </button>

            <div class="mt-5">
                <div class="flex items-center justify-between gap-3">
                    <div>
                        <p class="text-sm font-semibold leading-6 text-gray-950">Tailwind UI Variants</p>
                        <p class="text-xs leading-5 text-gray-500">Application UI v4 tab patterns.</p>
                    </div>
                    <span class="rounded-md bg-gray-50 px-2 py-1 text-xs font-medium text-gray-600 ring-1 ring-inset ring-gray-200" x-text="topNavTabStyleOption(topNavTabStyle).className"></span>
                </div>
                <div class="mt-3 grid gap-2">
                    <template x-for="option in topNavTabStyleOptions" :key="option.key">
                        <button
                            type="button"
                            x-on:click="setTopNavTabStyle(option.key)"
                            class="rounded-lg border bg-white p-3 text-left shadow-sm transition hover:border-indigo-600 hover:bg-gray-50 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
                            :class="topNavTabStyle === option.key ? 'border-indigo-600 bg-indigo-50' : 'border-gray-200'"
                        >
                            <span class="flex items-start justify-between gap-3">
                                <span>
                                    <span class="block text-sm font-semibold leading-6 text-gray-950" x-text="option.label"></span>
                                    <span class="block text-xs leading-5 text-gray-500" x-text="option.description"></span>
                                </span>
                                <span x-show="topNavTabStyle === option.key" class="outcraft-icon !text-[16px] text-indigo-600">check</span>
                            </span>
                            <span class="mt-3 flex min-w-0 items-center gap-2 overflow-hidden" :class="option.previewClass">
                                <span class="shrink-0" :class="option.previewItemClass">Leads</span>
                                <span class="shrink-0" :class="option.previewMutedClass">Campaigns</span>
                                <span class="shrink-0" :class="option.previewMutedClass">Analytics</span>
                            </span>
                        </button>
                    </template>
                </div>
            </div>
        </div>
    </div>

    <div
        x-cloak
        x-show="typographyPanelOpen"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 -translate-x-4"
        x-transition:enter-end="opacity-100 translate-x-0"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 translate-x-0"
        x-transition:leave-end="opacity-0 -translate-x-4"
        class="fixed bottom-4 left-4 top-4 z-[120] flex w-[22rem] max-w-[calc(100vw-2rem)] flex-col overflow-hidden rounded-lg bg-white shadow-2xl ring-1 ring-gray-900/10"
    >
        <div class="border-b border-gray-200 px-4 py-4">
            <div class="flex items-start justify-between gap-3">
                <div>
                    <p class="text-sm font-semibold leading-6 text-gray-950">Typography</p>
                    <p class="mt-1 text-xs leading-5 text-gray-500">Press T to open or close this Tailwind typography panel.</p>
                </div>
                <button type="button" x-on:click="typographyPanelOpen = false" class="inline-flex size-8 items-center justify-center rounded-md text-gray-400 transition hover:bg-gray-50 hover:text-gray-700">
                    <span class="outcraft-icon !text-[18px]">close</span>
                </button>
            </div>
        </div>
        <div class="min-h-0 flex-1 space-y-6 overflow-y-auto p-4">
            <section>
                <div class="flex items-center justify-between gap-3">
                    <div>
                        <p class="text-sm font-semibold leading-6 text-gray-950">Text Scale</p>
                        <p class="text-xs leading-5 text-gray-500">Remaps common Tailwind text sizes across the UI.</p>
                    </div>
                    <span class="rounded-md bg-gray-50 px-2 py-1 text-xs font-medium text-gray-600 ring-1 ring-inset ring-gray-200" x-text="typographyScale"></span>
                </div>
                <div class="mt-3 grid gap-2">
                    <template x-for="option in typographyScaleOptions" :key="option.key">
                        <button
                            type="button"
                            x-on:click="setTypographyTheme('scale', option.key)"
                            class="rounded-lg border bg-white p-3 text-left shadow-sm transition hover:border-indigo-600 hover:bg-gray-50 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
                            :class="typographyScale === option.key ? 'border-indigo-600 bg-indigo-50' : 'border-gray-200'"
                        >
                            <span class="flex items-center justify-between gap-3">
                                <span>
                                    <span class="block text-sm font-semibold leading-6 text-gray-950" x-text="option.className"></span>
                                    <span class="block text-xs leading-5 text-gray-500" x-text="option.description"></span>
                                </span>
                                <span x-show="typographyScale === option.key" class="outcraft-icon !text-[16px] text-indigo-600">check</span>
                            </span>
                            <span class="mt-3 block text-gray-700" :style="`font-size: ${option.sizes.sm}; line-height: ${typographyLineHeightOption(typographyLineHeight).leading.sm};`">Campaign Setup Preview</span>
                        </button>
                    </template>
                </div>
            </section>

            <section>
                <div class="flex items-center justify-between gap-3">
                    <div>
                        <p class="text-sm font-semibold leading-6 text-gray-950">Line Height</p>
                        <p class="text-xs leading-5 text-gray-500">Controls Tailwind-style vertical rhythm.</p>
                    </div>
                    <span class="rounded-md bg-gray-50 px-2 py-1 text-xs font-medium text-gray-600 ring-1 ring-inset ring-gray-200" x-text="typographyLineHeightOption(typographyLineHeight).className"></span>
                </div>
                <div class="mt-3 grid grid-cols-3 gap-2">
                    <template x-for="option in typographyLineHeightOptions" :key="option.key">
                        <button
                            type="button"
                            x-on:click="setTypographyTheme('lineHeight', option.key)"
                            class="rounded-lg border bg-white p-3 text-left shadow-sm transition hover:border-indigo-600 hover:bg-gray-50 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
                            :class="typographyLineHeight === option.key ? 'border-indigo-600 bg-indigo-50' : 'border-gray-200'"
                        >
                            <span class="flex items-center justify-between gap-2">
                                <span class="text-sm font-semibold leading-6 text-gray-950" x-text="option.className"></span>
                                <span x-show="typographyLineHeight === option.key" class="outcraft-icon !text-[16px] text-indigo-600">check</span>
                            </span>
                            <span class="mt-2 block text-xs text-gray-500" :style="`line-height: ${option.leading.sm}`">Line<br>Height</span>
                        </button>
                    </template>
                </div>
            </section>

            <section>
                <div class="flex items-center justify-between gap-3">
                    <div>
                        <p class="text-sm font-semibold leading-6 text-gray-950">Emphasis Weight</p>
                        <p class="text-xs leading-5 text-gray-500">Adjusts common Tailwind font weight classes.</p>
                    </div>
                    <span class="rounded-md bg-gray-50 px-2 py-1 text-xs font-medium text-gray-600 ring-1 ring-inset ring-gray-200" x-text="typographyWeightOption(typographyWeight).className"></span>
                </div>
                <div class="mt-3 grid grid-cols-3 gap-2">
                    <template x-for="option in typographyWeightOptions" :key="option.key">
                        <button
                            type="button"
                            x-on:click="setTypographyTheme('weight', option.key)"
                            class="rounded-lg border bg-white p-3 text-left shadow-sm transition hover:border-indigo-600 hover:bg-gray-50 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
                            :class="typographyWeight === option.key ? 'border-indigo-600 bg-indigo-50' : 'border-gray-200'"
                        >
                            <span class="flex items-center justify-between gap-2">
                                <span class="text-sm leading-6 text-gray-950" :style="`font-weight: ${option.weights.semibold}`" x-text="option.className"></span>
                                <span x-show="typographyWeight === option.key" class="outcraft-icon !text-[16px] text-indigo-600">check</span>
                            </span>
                            <span class="mt-2 block text-xs text-gray-500" :style="`font-weight: ${option.weights.medium}`">Aa 123</span>
                        </button>
                    </template>
                </div>
            </section>
        </div>
    </div>
