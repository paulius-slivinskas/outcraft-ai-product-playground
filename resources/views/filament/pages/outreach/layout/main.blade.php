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
            class="outcraft-mobile-main-nav sticky top-0 z-50 h-16 border-b border-gray-200 bg-white px-4 py-0 transition-transform duration-500 ease-out will-change-transform"
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
            <svg viewBox="0 0 455 84" fill="none" xmlns="http://www.w3.org/2000/svg" class="pointer-events-none absolute left-1/2 top-1/2 h-5 w-auto max-w-[8.75rem] -translate-x-1/2 -translate-y-1/2" aria-label="Outcraft" role="img">
                <path d="M174.744 40.692C174.744 61.8694 160.025 76.2198 138.304 76.2198C116.583 76.2198 101.864 61.8765 101.864 40.692C101.864 19.5075 116.583 5.16431 138.312 5.16431C160.04 5.16431 174.752 19.5146 174.752 40.692H174.744ZM113.479 40.692C113.479 56.8965 123.789 66.3592 138.304 66.3592C152.819 66.3592 163.232 56.8894 163.232 40.692C163.232 24.4946 152.921 14.9254 138.304 14.9254C123.687 14.9254 113.479 24.4875 113.479 40.692Z" fill="black"/>
                <path d="M218.896 25.957H229.41V74.7553H218.896V68.802C215.194 73.2918 209.686 76.2187 202.078 76.2187C188.365 76.2187 179.854 66.5571 179.854 53.5779V25.957H190.369V53.7697C190.369 61.776 194.573 66.9478 202.982 66.9478C212.192 66.9478 218.903 60.8028 218.903 50.3597V25.957H218.896Z" fill="black"/>
                <path d="M256.526 67.1408V76.4117C244.314 77.0937 236.408 71.73 236.408 58.9426V6.43604H246.923V25.9582H256.534V35.2291H246.923V59.3333C246.923 66.5582 251.324 67.1408 256.534 67.1408H256.526Z" fill="black"/>
                <path d="M301.678 55.817H312.09C310.589 68.2137 299.98 76.213 286.063 76.213C270.243 76.213 259.532 65.7699 259.532 50.3468C259.532 34.9238 270.243 24.4807 286.063 24.4807C299.878 24.4807 310.487 32.3876 312.09 44.6848H301.576C299.776 37.7512 293.866 33.7516 286.063 33.7516C276.35 33.7516 269.544 39.9038 269.544 50.3468C269.544 60.7899 276.35 66.935 286.063 66.935C293.968 66.935 299.878 62.9353 301.678 55.8099V55.817Z" fill="black"/>
                <path d="M318.093 74.7568V25.9586H328.607V29.5675C332.812 24.9782 338.918 23.2235 346.729 25.1771L344.929 33.9578C333.518 32.1036 328.615 38.5471 328.615 50.3541V74.7568H318.1H318.093Z" fill="black"/>
                <path d="M387.766 69.2864C383.962 73.485 378.257 76.213 370.548 76.213C355.428 76.213 344.717 65.7699 344.717 50.3468C344.717 34.9238 355.428 24.4807 370.548 24.4807C378.257 24.4807 383.962 27.2158 387.766 31.4072V25.9442H398.28V74.7424H387.766V69.2793V69.2864ZM371.247 66.9492C381.055 66.9492 387.766 60.8041 387.766 50.361C387.766 39.918 381.062 33.7658 371.247 33.7658C361.432 33.7658 354.729 39.918 354.729 50.361C354.729 60.8041 361.534 66.9492 371.247 66.9492Z" fill="black"/>
                <path d="M422.1 14.5346C419.2 14.5346 415.797 15.7068 415.797 21.2694V27.2226H425.408V36.4935H415.797V74.7492H405.282V21.3688C405.282 12.4887 410.689 5.16431 420.497 5.16431C422.5 5.16431 426.705 5.45558 430.406 7.2174L426.501 15.2166C424.898 14.7265 423.295 14.5346 422.1 14.5346Z" fill="black"/>
                <path d="M454.037 67.1408V76.4117C441.825 77.0937 433.919 71.73 433.919 58.9426V6.43604H444.433V25.9582H454.044V35.2291H444.433V59.3333C444.433 66.5582 448.834 67.1408 454.044 67.1408H454.037Z" fill="black"/>
                <path d="M82.9209 38.5541V44.4931V46.3757C66.7957 47.96 47.45 42.1985 39.923 26.953C37.8317 30.6117 35.9737 33.2047 33.6857 35.4141C31.303 37.7158 28.5414 39.5131 24.6285 41.5875C28.5195 43.6548 31.2811 45.4522 33.6565 47.7397C36.0538 50.0557 37.9775 52.7979 40.2144 56.762C42.517 52.5279 44.7758 49.0895 49.3736 45.5374C52.0114 47.1288 55.8149 49.0327 60.7479 50.5245L59.1157 51.441C54.4961 54.034 51.3191 57.9483 49.2133 62.4666C46.5537 68.1712 45.5773 74.842 45.519 81.1149L45.4972 83.1893H43.3768H37.1104H35.0337L34.9754 81.1433C34.6548 69.6062 32.1409 61.2518 26.8873 55.7319C21.6629 50.2262 13.5603 47.3845 2.04752 46.8162L0 46.7167V44.7347V44.7205V38.4759V38.4546V36.4726L2.04752 36.3731C13.9537 35.7906 22.0491 32.7997 27.1788 27.2372C32.3377 21.6392 34.6621 13.2918 34.9754 2.04599L35.0337 0H37.1104H43.3768H45.4972L45.519 2.0744C45.7303 25.5464 59.4145 38.9235 82.9209 36.2097V38.5612V38.5541Z" fill="black"/>
            </svg>
        </div>

        @include('filament.pages.outreach.campaign-builder.index')

        @include('filament.pages.outreach.pages.dashboard')

        @include('filament.pages.outreach.pages.brands')

        @include('filament.pages.outreach.pages.ai-agents')

        @include('filament.pages.outreach.pages.campaigns.index')

        @include('filament.pages.outreach.pages.analytics')

        @include('filament.pages.outreach.pages.leads.index')

        @include('filament.pages.outreach.pages.profile')
</main>
