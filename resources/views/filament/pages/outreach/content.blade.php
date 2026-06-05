<div
    x-data="outreachPage(@js($rows))"
    x-init="initializePrimaryTheme(); initializeRadiusTheme(); initializeIconStrokeTheme(); initializeTabsTheme(); initializeTypographyTheme(); initializeShadowTheme(); initializeProgressBarStyle(); initializeFromUrl()"
    x-on:keydown.window="handlePrimaryThemeShortcut($event); handleRadiusShortcut($event); handleIconStrokeShortcut($event); handleTabsShortcut($event); handleTypographyShortcut($event); handleShadowShortcut($event); handleDashboardOnboardingShortcut($event)"
    x-on:outreach-delete-selected-leads.window="deleteSelectedLeadsByIds($event.detail.ids)"
    x-on:outreach-reorder-find-out-questions.window="reorderFindOutQuestionsByIds($event.detail.ids)"
    class="outcraft-page fixed inset-0 z-50 overflow-hidden bg-white text-[#1f2024]"
    style="font-family: 'Inter Variable', Inter, ui-sans-serif, system-ui, sans-serif;"
>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="/js/lucide.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

    @include('filament.pages.outreach.shared.floating-tooltip')

    @include('filament.pages.outreach.shared.capture-toast')

    @include('filament.pages.outreach.shared.theme-panels')

    @include('filament.pages.outreach.shared.styles')


    @include('filament.pages.outreach.layout.sidebar')

    @include('filament.pages.outreach.layout.main')


    @include('filament.pages.outreach.scripts.outreach-page')
</div>
