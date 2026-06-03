        <section x-cloak x-show="activeNav === 'Leads' && ! leadDetailOpen" x-on:wheel="handleTopNavWheel($event)" data-outcraft-tab-header class="sticky top-0 z-30 bg-white transition-transform duration-200 ease-out will-change-transform" :class="topNavHeaderClass()">
            <div :class="topNavTabShellClass()">
                <div class="outcraft-tab-header-row flex items-stretch">
                    <button
                        type="button"
                        x-on:click.stop="openSidebarMenu()"
                        :class="topNavMenuButtonClass()"
                        aria-label="Open navigation"
                        :aria-expanded="mobileNavOpen.toString()"
                    >
                        <span class="outcraft-icon !text-[22px]">menu</span>
                    </button>
                    <div class="outcraft-tab-scroll min-h-0 min-w-0 flex-1 overflow-x-auto overflow-y-hidden">
                        <nav aria-label="Leads tabs" :class="topNavTabListClass()">
                            <template x-for="(tab, tabIndex) in tabs" :key="tab.label">
                                <button
                                    type="button"
                                    x-on:click="setActiveTab(tab.label)"
                                    :class="topNavTabButtonClass(activeTab === tab.label, tabIndex, tabs.length)"
                                >
                                    <span x-show="topNavTabIconsEnabled" class="outcraft-icon !text-[20px]" :class="topNavTabIconClass(activeTab === tab.label)" x-text="tab.icon"></span>
                                    <span x-text="tab.displayLabel || tab.label"></span>
                                </button>
                            </template>
                        </nav>
                    </div>
                </div>
            </div>
        </section>
