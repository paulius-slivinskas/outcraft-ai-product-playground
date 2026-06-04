<main
        x-ref="workspaceMain"
        x-on:scroll.passive="handleWorkspaceScroll($event)"
        class="h-full min-w-0 transition-[margin-left,width] duration-300 ease-in-out [overflow-anchor:none]"
        :class="[
            campaignBuilderOpen ? ((campaignBuilderUsesSidebarLayout() || campaignBuilderUsesIntroLayout()) ? 'ml-0 w-full bg-gray-50' : 'ml-0 w-full bg-white') : (sidebarOpen ? 'ml-72 w-[calc(100%-18rem)]' : 'ml-16 w-[calc(100%-4rem)]'),
            'overflow-y-auto overflow-x-hidden',
            ! campaignBuilderOpen && activeNav === 'Campaigns' ? 'bg-gray-50' : '',
            ! campaignBuilderOpen && activeNav !== 'Campaigns' ? 'bg-gray-50' : '',
        ]"
    >
        <div
            x-cloak
            x-show="! campaignBuilderOpen && ! topNavSectionActive()"
            class="outcraft-mobile-main-nav sticky top-0 z-50 border-b border-gray-200 bg-white px-4 py-3 transition-transform duration-500 ease-out will-change-transform"
            :class="topNavHeaderClass()"
        >
            <button
                type="button"
                x-on:click.stop="mobileNavOpen = ! mobileNavOpen"
                class="inline-flex size-10 items-center justify-center rounded-md text-gray-500 transition hover:bg-gray-50 hover:text-indigo-600"
                aria-label="Open navigation"
                :aria-expanded="mobileNavOpen.toString()"
            >
                <span class="outcraft-icon !text-[22px]" x-text="mobileNavOpen ? 'close' : 'menu'"></span>
            </button>
        </div>

        @include('filament.pages.outreach.campaign-builder.index')

        @include('filament.pages.outreach.pages.dashboard')

        @include('filament.pages.outreach.pages.campaigns.index')

        @include('filament.pages.outreach.pages.analytics')

        @include('filament.pages.outreach.pages.leads.index')

        @include('filament.pages.outreach.pages.profile')
</main>
