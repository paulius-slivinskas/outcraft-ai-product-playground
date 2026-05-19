<?php

namespace App\Filament\Pages;

use BackedEnum;
use Filament\Pages\Page;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Facades\Blade;

class OutreachPage extends Page
{
    protected static string | BackedEnum | null $navigationIcon = 'heroicon-o-phone';

    protected static ?string $navigationLabel = 'Outreach';

    protected static ?string $title = 'Outreach';

    protected static ?string $slug = 'outreach';

    protected string $view = 'filament.pages.outreach-page';

    public function pageContent(): HtmlString
    {
        return new HtmlString(Blade::render($this->template(), [
            'rows' => $this->rows(),
        ]));
    }

    private function rows(): array
    {
        $firstNames = ['Ava', 'Noah', 'Mia', 'Liam', 'Sophia', 'Ethan', 'Isabella', 'Mason', 'Amelia', 'Logan', 'Charlotte', 'Lucas', 'Harper', 'Jackson', 'Evelyn', 'Aiden', 'Abigail', 'Oliver', 'Emily', 'Carter'];
        $lastNames = ['Bennett', 'Carter', 'Mitchell', 'Reed', 'Morgan', 'Hayes', 'Cooper', 'Bailey', 'Parker', 'Brooks', 'Sullivan', 'Foster', 'Price', 'Coleman', 'Wright', 'Hughes', 'Turner', 'Bell', 'Rivera', 'Ward'];
        $domains = ['gmail.com', 'outlook.com', 'yahoo.com', 'icloud.com', 'proton.me', 'hotmail.com', 'companymail.com'];
        $areaCodes = [201, 212, 213, 214, 312, 415, 416, 438, 514, 604, 647, 702, 718, 778, 905];
        $canadianAreaCodes = [416, 438, 514, 604, 647, 778, 905];
        $timezones = ['America / New York', 'America / Chicago', 'America / Denver', 'America / Los Angeles', 'America / Toronto', 'America / Vancouver'];
        $leadStates = ['Idle', 'Idle', 'Idle', 'Review Required'];
        $campaignNames = ['Abandoned Cart', 'Web Support'];
        $campaignStatuses = ['Completed', 'Completed', 'Completed', 'Cancelled', 'Cancelled'];
        $interactionResults = ['No Response', 'Unreachable', 'No Decision'];
        $followUpResults = ['No Response', 'Positive', 'Positive', 'Ghosted'];
        $allChannels = ['Email', 'Call', 'SMS', 'WhatsApp'];
        $emailChannels = ['Email', 'WhatsApp'];
        $phoneChannels = ['Call', 'SMS', 'WhatsApp'];
        $contents = ['View', '0:19', '0:25', '0:35', '0:48', '1:06', '1:31', '2:14', ''];
        $directions = ['Outgoing', 'Incoming'];
        $outcomes = ['No Response', 'Engaged', 'Delivered', 'Failed'];
        $results = ['Positive', 'Negative', 'No Decision', 'No Response', 'Unreachable', 'Escalated', 'Closed Manually', 'Closed Automatically', 'Review Required', 'Failed'];
        $now = strtotime('2026-05-01 14:37:00');

        $rows = [];

        for ($index = 0; $index < 200; $index++) {
            $firstName = $firstNames[$index % count($firstNames)];
            $lastName = $lastNames[($index * 7) % count($lastNames)];
            $areaCode = $areaCodes[($index * 5) % count($areaCodes)];
            $prefix = 200 + (($index * 37) % 700);
            $line = 1000 + (($index * 143) % 9000);
            $contactMode = $index % 5;
            $hasPhone = $contactMode !== 1;
            $hasEmail = $contactMode !== 2;
            $availableChannels = match (true) {
                $hasPhone && $hasEmail => $allChannels,
                $hasEmail => $emailChannels,
                default => $phoneChannels,
            };
            $channel = $availableChannels[(($index * 5) + intdiv($index, 4)) % count($availableChannels)];
            $content = in_array($channel, ['Email', 'SMS', 'WhatsApp'], true)
                ? 'View'
                : ($channel === 'Call' ? $contents[1 + ($index % 7)] : (($index % 3) === 0 ? '' : 'View'));
            $age = $this->ageForIndex($index);
            $ageDate = $now - $age['seconds'];
            $name = ($index % 20) < 3 ? '' : "{$firstName} {$lastName}";
            $contentName = $name !== '' ? $name : 'Customer';
            $result = $results[(($index * 7) + intdiv($index, 4)) % count($results)];
            $phone = $hasPhone ? sprintf('(%d) %03d-%04d', $areaCode, $prefix, $line) : '';
            $email = $hasEmail ? sprintf('%s.%s%d@%s', strtolower($firstName), strtolower($lastName), $index + 1, $domains[($index * 2) % count($domains)]) : '';

            if ($channel === 'Call' && ($index % 5) === 0) {
                $result = 'Positive';
            }

            $rows[] = [
                'id' => $index + 1,
                'name' => $name,
                'phone' => $phone,
                'phoneCountry' => in_array($areaCode, $canadianAreaCodes, true) ? 'Canada' : 'United States',
                'phoneFlag' => in_array($areaCode, $canadianAreaCodes, true) ? '🇨🇦' : '🇺🇸',
                'country' => in_array($areaCode, $canadianAreaCodes, true) ? 'CA' : 'US',
                'countryFlag' => in_array($areaCode, $canadianAreaCodes, true) ? '🇨🇦' : '🇺🇸',
                'timezone' => $timezones[(($index * 3) + intdiv($index, 9)) % count($timezones)],
                'state' => $leadStates[(($index * 5) + intdiv($index, 11)) % count($leadStates)],
                'campaignName' => $campaignNames[(($index * 2) + intdiv($index, 12)) % count($campaignNames)],
                'campaignStatus' => $campaignStatuses[(($index * 3) + intdiv($index, 5)) % count($campaignStatuses)],
                'firstInteraction' => $interactionResults[(($index * 5) + intdiv($index, 4)) % count($interactionResults)],
                'followUp' => $followUpResults[(($index * 7) + intdiv($index, 3)) % count($followUpResults)],
                'email' => $email,
                'channel' => $channel,
                'content' => $content,
                'contentPreview' => sprintf(
                    'Hi I would like an update on my order. It has been over a month. %s Order number PUL2##%06d.',
                    $contentName,
                    270000 + (($index * 1739) % 900000),
                ),
                'direction' => $directions[(($index * 3) + intdiv($index, 5)) % count($directions)],
                'outcome' => $outcomes[(($index * 7) + intdiv($index, 3)) % count($outcomes)],
                'result' => $result,
                'age' => $age['label'],
                'ageTooltip' => date('j, F, Y H:i', $ageDate),
                'ageSeconds' => $age['seconds'],
            ];
        }

        return $rows;
    }

    private function ageForIndex(int $index): array
    {
        return match ($index % 6) {
            0 => [
                'label' => (($index * 7) % 58 + 2) . 's',
                'seconds' => (($index * 7) % 58 + 2),
            ],
            1 => [
                'label' => (($index * 5) % 58 + 1) . 'm',
                'seconds' => (($index * 5) % 58 + 1) * 60,
            ],
            2 => [
                'label' => (($index * 3) % 23 + 1) . 'h',
                'seconds' => (($index * 3) % 23 + 1) * 3600,
            ],
            3 => [
                'label' => (($index * 2) % 27 + 1) . 'd',
                'seconds' => (($index * 2) % 27 + 1) * 86400,
            ],
            4 => [
                'label' => (($index * 4) % 11 + 1) . 'mo',
                'seconds' => (($index * 4) % 11 + 1) * 2592000,
            ],
            default => [
                'label' => (($index * 3) % 4 + 1) . 'y',
                'seconds' => (($index * 3) % 4 + 1) * 31536000,
            ],
        };
    }

    private function template(): string
    {
        return <<<'BLADE'
<div
    x-data="outreachPage(@js($rows))"
    x-init="initializeFromUrl()"
    class="outcraft-page fixed inset-0 z-50 overflow-hidden bg-white text-[#1f2024]"
    style="font-family: 'Inter Variable', Inter, ui-sans-serif, system-ui, sans-serif;"
>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>

    <div
        x-cloak
        x-show="floatingTooltip.visible"
        x-transition.opacity.duration.100ms
        class="outcraft-floating-tooltip rounded-lg bg-gray-900 px-4 py-3 text-left text-xs font-medium leading-5 text-white shadow-sm"
        :style="`left: ${floatingTooltip.left}px; top: ${floatingTooltip.top}px; width: ${floatingTooltip.width}px;`"
    >
        <span x-text="floatingTooltip.text"></span>
        <span class="absolute left-1/2 top-full size-2 -translate-x-1/2 -translate-y-1 rotate-45 bg-gray-900"></span>
    </div>

    <style>
        @font-face {
            font-family: 'Inter Variable';
            src: url('/fonts/inter/InterVariable.woff2') format('woff2');
            font-weight: 100 900;
            font-style: normal;
            font-display: swap;
        }
        @font-face {
            font-family: 'Inter Variable';
            src: url('/fonts/inter/InterVariable-Italic.woff2') format('woff2');
            font-weight: 100 900;
            font-style: italic;
            font-display: swap;
        }
        [x-cloak] { display: none !important; }
        .outcraft-page ::selection {
            background: #d4d4d4;
            color: #171717;
        }
        .outcraft-page {
            scrollbar-color: #d4d4d4 transparent;
            scrollbar-width: thin;
            font-feature-settings: "cv02", "cv03", "cv04", "cv11";
        }
        .outcraft-page * {
            scrollbar-color: #d4d4d4 transparent;
            scrollbar-width: thin;
        }
        .outcraft-page::-webkit-scrollbar,
        .outcraft-page *::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }
        .outcraft-page::-webkit-scrollbar-track,
        .outcraft-page *::-webkit-scrollbar-track {
            background: transparent;
        }
        .outcraft-page::-webkit-scrollbar-thumb,
        .outcraft-page *::-webkit-scrollbar-thumb {
            background-color: #d4d4d4;
            border-radius: 9999px;
            border: 2px solid #ffffff;
        }
        .outcraft-page::-webkit-scrollbar-thumb:hover,
        .outcraft-page *::-webkit-scrollbar-thumb:hover {
            background-color: #a3a3a3;
        }
        .outcraft-icon {
            display: inline-flex;
            width: 1em;
            height: 1em;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            line-height: 1;
            vertical-align: -0.125em;
        }
        .outcraft-icon svg {
            width: 1em;
            height: 1em;
            stroke: currentColor;
        }
        .dashboard-hero {
            background:
                radial-gradient(circle at 92% 18%, rgba(141, 118, 255, 0.74), transparent 34%),
                radial-gradient(circle at 8% 20%, rgba(14, 47, 74, 0.98), transparent 42%),
                linear-gradient(110deg, #18324f 0%, #0e3146 42%, #354c82 72%, #9c92ff 100%);
        }
        .outcraft-label {
            align-items: center;
            min-width: 0;
            min-height: 26px;
            white-space: nowrap;
            overflow: hidden;
        }
        .outcraft-label > span:not(.outcraft-icon) {
            min-width: 0;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }
        .outcraft-page main > section {
            width: calc(100% - 3rem);
            max-width: 1520px;
            margin-left: auto !important;
            margin-right: auto !important;
        }
        .outcraft-table-loader {
            box-shadow: 0 12px 32px rgba(15, 23, 42, 0.10);
        }
        .outcraft-page tbody > tr:last-of-type {
            border-bottom-width: 0 !important;
        }
        .outcraft-floating-tooltip {
            position: fixed;
            z-index: 9999;
            pointer-events: none;
            transform: translate(-50%, -100%);
        }
        @keyframes outcraft-loader-draw {
            0% {
                stroke-dashoffset: -1;
            }
            70% {
                stroke-dashoffset: 0;
            }
            100% {
                stroke-dashoffset: 0;
            }
        }
        .outcraft-loader-draw {
            stroke-dasharray: 1;
            animation: outcraft-loader-draw 1s ease-in-out infinite;
        }
        .outcraft-page [data-campaign-setup-step] {
            display: grid;
            gap: 2.5rem;
            align-items: start;
        }
        .outcraft-page [data-campaign-setup-step] > :not([hidden]) ~ :not([hidden]) {
            margin-top: 0 !important;
        }
        .outcraft-page [data-campaign-setup-step] > :first-child {
            min-width: 0;
        }
        .outcraft-page [data-campaign-setup-step] > :first-child > p:first-child {
            display: none;
        }
        .outcraft-page [data-campaign-setup-step] > :first-child h2 {
            margin-top: 0;
            font-size: 1rem;
            line-height: 1.75rem;
            font-weight: 600;
            letter-spacing: 0;
            color: #111827;
        }
        .outcraft-page [data-campaign-setup-step] > :first-child > p:nth-of-type(2) {
            margin-top: 0.25rem;
            max-width: 18rem;
            font-size: 0.875rem;
            line-height: 1.5rem;
            color: #6b7280;
        }
        @media (min-width: 1024px) {
            .outcraft-page [data-campaign-setup-step] {
                grid-template-columns: 260px minmax(0, 1fr);
                column-gap: 4rem;
                row-gap: 1.5rem;
            }
            .outcraft-page [data-campaign-setup-step] > :not(:first-child) {
                grid-column: 2;
                min-width: 0;
            }
        }
        @media (max-width: 1024px) {
            .outcraft-page main > section {
                width: calc(100% - 2rem);
            }
            .outcraft-page main > section > .grid,
            .outcraft-page .mt-6.grid,
            .outcraft-page .mt-5.grid {
                grid-template-columns: 1fr !important;
            }
            .outcraft-page main > section > .grid {
                gap: 1rem !important;
                padding: 1rem !important;
            }
            .outcraft-page .dashboard-hero {
                padding: 2rem 1.25rem !important;
                border-radius: 12px !important;
            }
            .outcraft-page .dashboard-hero h1 {
                font-size: 28px !important;
            }
            .outcraft-page table {
                font-size: 14px !important;
            }
        }
        @media (max-width: 900px) {
            .outcraft-page {
                overflow: hidden;
            }
            .outcraft-page aside {
                position: fixed !important;
                left: 0.75rem !important;
                top: 64px !important;
                bottom: auto !important;
                z-index: 70 !important;
                width: min(280px, calc(100vw - 1.5rem)) !important;
                height: auto !important;
                max-height: calc(100vh - 88px) !important;
                flex-direction: column !important;
                border: 1px solid #e5e5e5 !important;
                border-radius: 14px !important;
                box-shadow: 0 18px 45px rgba(15, 23, 42, 0.16);
                transform: translateY(-8px) scale(0.98);
                opacity: 0;
                pointer-events: none;
                transition: opacity 160ms ease, transform 160ms ease !important;
            }
            .outcraft-page aside.mobile-nav-open {
                transform: translateY(0) scale(1);
                opacity: 1;
                pointer-events: auto;
            }
            .outcraft-page [data-component="custom-field-text-input"] aside {
                position: relative !important;
                inset: auto !important;
                left: auto !important;
                right: auto !important;
                top: auto !important;
                bottom: auto !important;
                z-index: auto !important;
                width: 100% !important;
                height: auto !important;
                max-height: none !important;
                flex-direction: column !important;
                border-radius: 0 !important;
                box-shadow: none !important;
                transform: none;
                opacity: 1;
                pointer-events: auto;
                overflow: auto !important;
            }
            .outcraft-page aside nav {
                display: grid !important;
                width: 100% !important;
                gap: 0.25rem !important;
                overflow: visible !important;
                margin: 0 !important;
                padding: 0.5rem !important;
                padding-top: 0.5rem !important;
                scrollbar-width: none !important;
                -ms-overflow-style: none !important;
            }
            .outcraft-page aside nav::-webkit-scrollbar {
                display: none !important;
            }
            .outcraft-page aside nav ul {
                display: grid !important;
                width: 100% !important;
                gap: 0.25rem !important;
            }
            .outcraft-page aside nav li {
                width: 100% !important;
            }
            .outcraft-page aside nav button {
                justify-content: flex-start !important;
                height: 44px !important;
                gap: 0.75rem !important;
                padding: 0 0.75rem !important;
                border-radius: 12px !important;
            }
            .outcraft-page aside nav button span:not(.outcraft-icon) {
                display: inline !important;
                max-width: 190px !important;
                opacity: 1 !important;
            }
            .outcraft-page main {
                margin-left: 0 !important;
                padding-bottom: 1rem !important;
            }
            .outcraft-page main > section {
                width: calc(100% - 1rem);
            }
            .outcraft-page main > section.rounded-lg,
            .outcraft-page main > section .rounded-lg {
                border-radius: 10px !important;
            }
            .outcraft-page main > section > div.flex:first-child,
            .outcraft-page main > section > div.flex.min-h-\[74px\] {
                align-items: stretch !important;
                flex-wrap: wrap !important;
                gap: 0.5rem !important;
                padding: 0.75rem !important;
            }
            .outcraft-page main > section > div.flex:first-child > div,
            .outcraft-page main > section > div.flex:first-child > button,
            .outcraft-page main > section > div.flex.min-h-\[74px\] > button {
                width: 100%;
                justify-content: center;
            }
            .outcraft-page main > section > div.overflow-hidden > div.flex,
            .outcraft-page section > div.overflow-hidden > div.flex {
                align-items: stretch !important;
                flex-direction: column !important;
                gap: 0.75rem !important;
                padding: 1rem !important;
            }
            .outcraft-page section > div.overflow-hidden > div.flex > div {
                flex-wrap: wrap !important;
            }
            .outcraft-page .overflow-x-auto {
                border-radius: inherit;
            }
            .outcraft-page table th,
            .outcraft-page table td {
                padding-top: 0.75rem !important;
                padding-bottom: 0.75rem !important;
            }
            .outcraft-page main > section > div.flex.h-11 {
                height: auto !important;
                display: grid !important;
                grid-template-columns: repeat(auto-fit, minmax(88px, 1fr)) !important;
                gap: 0.5rem !important;
            }
            .outcraft-page main > section > div.flex.h-11 button {
                width: 100% !important;
                height: 62px !important;
                flex-direction: column !important;
                justify-content: center !important;
                gap: 0.25rem !important;
                padding: 0.5rem !important;
                text-align: center !important;
            }
            .outcraft-page main > section > div.flex.h-11 button span:not(.outcraft-icon) {
                font-size: 12px !important;
                line-height: 1.1 !important;
                white-space: normal !important;
            }
        }
        @media (max-width: 720px) {
            .outcraft-page section[x-show="leadDetailOpen"] > div.overflow-hidden {
                overflow-x: auto !important;
            }
            .outcraft-page section[x-show="leadDetailOpen"] > div.overflow-hidden table {
                min-width: 900px;
            }
            .outcraft-page section[x-show="leadDetailOpen"] > h1 {
                margin-bottom: 1.25rem !important;
                font-size: 24px !important;
            }
            .outcraft-page section[x-show="leadDetailOpen"] > .relative.mx-auto {
                max-width: 100% !important;
                margin-top: 1rem !important;
            }
            .outcraft-page section[x-show="leadDetailOpen"] > .relative.mx-auto > div:first-child {
                display: none !important;
            }
            .outcraft-page section[x-show="leadDetailOpen"] > .relative.mx-auto > template + span {
                display: none !important;
            }
            .outcraft-page section[x-show="leadDetailOpen"] .relative.grid.grid-cols-\[170px_220px_1fr\] {
                display: block !important;
                padding: 0 0 2rem 2.25rem !important;
                border-left: 1px solid #e5e5e5;
            }
            .outcraft-page section[x-show="leadDetailOpen"] .relative.grid.grid-cols-\[170px_220px_1fr\] > div:first-child {
                margin-bottom: 0.75rem;
            }
            .outcraft-page section[x-show="leadDetailOpen"] .relative.grid.grid-cols-\[170px_220px_1fr\] > div:nth-child(2) {
                margin-bottom: 1rem;
            }
            .outcraft-page section[x-show="leadDetailOpen"] .relative.grid.grid-cols-\[170px_220px_1fr\] > div:nth-child(2) > span:first-child {
                left: -45px !important;
                top: 0 !important;
            }
            .outcraft-page section[x-show="leadDetailOpen"] .max-w-\[660px\] {
                max-width: 100% !important;
            }
            .outcraft-page section[x-show="leadDetailOpen"] .max-w-\[205px\] {
                max-width: 100% !important;
            }
        }
        @media (max-width: 560px) {
            .outcraft-page .outcraft-label {
                max-width: 100%;
            }
            .outcraft-page .flex.items-center.gap-4.border-t {
                align-items: stretch !important;
                flex-direction: column !important;
            }
            .outcraft-page .flex.items-center.gap-4.border-t > div {
                justify-content: space-between !important;
                width: 100%;
            }
            .outcraft-page aside nav button {
                flex-basis: 52px !important;
            }
        }
        .outcraft-page aside.outcraft-sidebar-collapsed {
            width: 4rem !important;
            padding-left: 0.75rem !important;
            padding-right: 0.75rem !important;
        }
        .outcraft-page aside.outcraft-sidebar-collapsed > div:first-child {
            justify-content: center !important;
        }
        .outcraft-page aside.outcraft-sidebar-collapsed nav button {
            width: 100% !important;
            height: 2.5rem !important;
            flex-basis: auto !important;
            justify-content: flex-start !important;
            gap: 0 !important;
            padding: 0 !important;
        }
        .outcraft-page aside.outcraft-sidebar-collapsed nav button .outcraft-icon {
            display: inline-flex !important;
            width: 1.5rem !important;
            height: 1.5rem !important;
            align-items: center !important;
            justify-content: center !important;
            text-align: center !important;
            line-height: 1 !important;
        }
    </style>

    <aside
        x-show="! campaignBuilderOpen"
        class="absolute inset-y-0 left-0 z-40 flex flex-col overflow-visible border-r border-gray-200 bg-white transition-[width,padding] duration-300 ease-in-out"
        :class="[
            sidebarOpen ? 'w-72 px-3' : 'w-16 px-3',
            ! sidebarOpen ? 'outcraft-sidebar-collapsed' : '',
            mobileNavOpen ? 'mobile-nav-open' : ''
        ]"
        x-on:click.outside="mobileNavOpen = false"
    >
        <div class="group/sidebar-header flex h-16 shrink-0 items-center justify-start">
            <button
                type="button"
                x-on:click="expandSidebar()"
                class="relative flex h-10 w-[158px] items-center justify-start overflow-visible rounded-md transition-colors duration-200 ease-in-out"
                :class="sidebarOpen ? 'cursor-default' : 'cursor-pointer hover:bg-gray-50'"
                :title="sidebarOpen ? 'Outcraft' : 'Expand'"
            >
                <svg width="142" height="26" viewBox="0 0 455 84" fill="none" xmlns="http://www.w3.org/2000/svg" class="absolute left-[7px] top-1/2 max-w-none -translate-y-1/2 opacity-100 transition-[clip-path] duration-300 ease-in-out" :class="sidebarOpen ? '[clip-path:inset(0_0_0_0)]' : '[clip-path:inset(0_116px_0_0)]'">
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
                <svg width="26" height="26" viewBox="0 0 83 84" fill="none" xmlns="http://www.w3.org/2000/svg" class="absolute left-[7px] top-1/2 z-0 max-w-none -translate-y-1/2 transition-opacity duration-150 ease-in-out" :class="(! sidebarOpen && sidebarSettled) ? 'opacity-100 group-hover/sidebar-header:opacity-0' : 'opacity-0'">
                    <path d="M82.9209 38.5541V44.4931V46.3757C66.7957 47.96 47.45 42.1985 39.923 26.953C37.8317 30.6117 35.9737 33.2047 33.6857 35.4141C31.303 37.7158 28.5414 39.5131 24.6285 41.5875C28.5195 43.6548 31.2811 45.4522 33.6565 47.7397C36.0538 50.0557 37.9775 52.7979 40.2144 56.762C42.517 52.5279 44.7758 49.0895 49.3736 45.5374C52.0114 47.1288 55.8149 49.0327 60.7479 50.5245L59.1157 51.441C54.4961 54.034 51.3191 57.9483 49.2133 62.4666C46.5537 68.1712 45.5773 74.842 45.519 81.1149L45.4972 83.1893H43.3768H37.1104H35.0337L34.9754 81.1433C34.6548 69.6062 32.1409 61.2518 26.8873 55.7319C21.6629 50.2262 13.5603 47.3845 2.04752 46.8162L0 46.7167V44.7347V44.7205V38.4759V38.4546V36.4726L2.04752 36.3731C13.9537 35.7906 22.0491 32.7997 27.1788 27.2372C32.3377 21.6392 34.6621 13.2918 34.9754 2.04599L35.0337 0H37.1104H43.3768H45.4972L45.519 2.0744C45.7303 25.5464 59.4145 38.9235 82.9209 36.2097V38.5612V38.5541Z" fill="black"/>
                </svg>
                <span
                    x-cloak
                    x-show="! sidebarOpen && sidebarSettled"
                    class="pointer-events-none absolute inset-0 z-10 flex size-10 items-center justify-center rounded-md bg-gray-50 opacity-0 transition-opacity duration-200 group-hover/sidebar-header:opacity-100 group-focus-visible/sidebar-header:opacity-100"
                >
                    <span class="outcraft-icon text-[22px] leading-none text-indigo-600">dock_to_right</span>
                </span>
                <span
                    x-show="! sidebarOpen && sidebarSettled"
                    class="pointer-events-none absolute left-full top-1/2 z-50 ml-3 -translate-y-1/2 translate-x-1 whitespace-nowrap rounded-md bg-gray-900 px-2.5 py-1.5 text-xs font-medium text-white opacity-0 shadow-lg ring-1 ring-gray-900/5 transition group-hover/sidebar-header:translate-x-0 group-hover/sidebar-header:opacity-100 group-focus-visible/sidebar-header:translate-x-0 group-focus-visible/sidebar-header:opacity-100"
                >Expand</span>
            </button>
            <button
                type="button"
                x-show="sidebarOpen"
                x-on:click="collapseSidebar()"
                class="ml-auto inline-flex size-9 items-center justify-center rounded-md text-gray-400 transition hover:bg-gray-50 hover:text-indigo-600"
                title="Collapse"
            >
                <span class="outcraft-icon text-[22px] leading-none">dock_to_left</span>
            </button>
        </div>

        <nav class="tailwind-sidebar-nav relative flex flex-1 flex-col pt-5">
            <ul role="list" class="flex flex-1 flex-col gap-y-7">
                <li>
                    <ul role="list" class="space-y-1">
                        <template x-for="item in nav" :key="item.label">
                            <li>
                                <button
                                    type="button"
                                    x-on:click="setActiveNav(item.label)"
                                    class="group relative flex h-10 w-full items-center overflow-visible rounded-md p-0 text-sm/6 font-semibold transition-colors duration-200 ease-in-out"
                                    :class="[
                                        activeNav === item.label ? 'bg-gray-50 text-indigo-600' : 'text-gray-700 hover:bg-gray-50 hover:text-indigo-600'
                                    ]"
                                    :title="sidebarOpen ? item.label : ''"
                                >
                                    <span class="flex size-10 shrink-0 items-center justify-center self-center">
                                        <span class="outcraft-icon flex size-6 shrink-0 items-center justify-center !text-[22px] !leading-none" :class="activeNav === item.label ? 'text-indigo-600' : 'text-gray-400 group-hover:text-indigo-600'" x-text="item.icon"></span>
                                    </span>
                                    <span class="min-w-0 flex-1 truncate text-left leading-10 transition-[max-width,opacity] duration-300 ease-in-out" :class="sidebarOpen ? 'max-w-44 opacity-100' : 'max-w-0 opacity-0'" x-text="item.label"></span>
                                    <span
                                        x-show="! sidebarOpen"
                                        x-text="item.label"
                                        class="pointer-events-none absolute left-full top-1/2 z-50 ml-3 -translate-y-1/2 translate-x-1 whitespace-nowrap rounded-md bg-gray-900 px-2.5 py-1.5 text-xs font-medium text-white opacity-0 shadow-lg ring-1 ring-gray-900/5 transition group-hover:translate-x-0 group-hover:opacity-100 group-focus-visible:translate-x-0 group-focus-visible:opacity-100"
                                    ></span>
                                    <span
                                        x-show="item.count && sidebarOpen && sidebarSettled"
                                        x-text="item.count"
                                        x-transition.opacity.duration.150ms
                                        class="mr-3 ml-3 min-w-9 rounded-full bg-white px-2.5 py-0.5 text-center text-xs/5 font-medium text-gray-600 outline outline-1 -outline-offset-1 outline-gray-200"
                                    ></span>
                                </button>
                            </li>
                        </template>
                    </ul>
                </li>
            </ul>
        </nav>

        <div class="-mx-3 mt-auto pt-4">
            <div
                class="group/profile-row flex transition-colors duration-200 ease-in-out"
                :class="sidebarOpen ? 'items-center gap-2 px-3 py-3 hover:bg-gray-50' : 'w-full flex-col items-center gap-3 py-3 hover:bg-gray-50'"
            >
                <button
                    type="button"
                    x-on:click="setActiveNav('Profile')"
                    class="group/profile relative min-w-0 shrink-0 rounded-md text-left"
                    :class="sidebarOpen ? 'order-1 block flex-1' : 'order-2 flex w-full justify-center'"
                >
                    <div class="flex items-center" :class="sidebarOpen ? '' : 'w-full justify-center'">
                        <span class="flex size-10 shrink-0 items-center justify-center">
                            <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="" class="inline-block size-8 rounded-md outline outline-1 -outline-offset-1 outline-black/5" />
                        </span>
                        <div class="min-w-0 transition-[margin,max-width,opacity] duration-300 ease-in-out" :class="sidebarOpen ? 'ml-3 max-w-40 opacity-100' : 'ml-0 max-w-0 overflow-hidden opacity-0'">
                            <p class="truncate text-sm font-medium text-gray-700 group-hover/profile-row:text-gray-900">Pulsetto</p>
                            <p class="truncate text-xs font-medium text-gray-500 group-hover/profile-row:text-gray-700">diana@pulsetto.tech</p>
                        </div>
                    </div>
                    <span
                        x-show="! sidebarOpen"
                        class="pointer-events-none absolute left-full top-1/2 z-50 ml-3 -translate-y-1/2 translate-x-1 whitespace-nowrap rounded-md bg-gray-900 px-2.5 py-1.5 text-xs font-medium text-white opacity-0 shadow-lg ring-1 ring-gray-900/5 transition group-hover/profile:translate-x-0 group-hover/profile:opacity-100 group-focus-visible/profile:translate-x-0 group-focus-visible/profile:opacity-100"
                    >Pulsetto</span>
                </button>
                <button
                    type="button"
                    class="group/notification relative inline-flex size-9 shrink-0 items-center justify-center rounded-md text-gray-400 transition-colors duration-200 ease-in-out group-hover/profile-row:text-indigo-600 hover:bg-gray-200 hover:text-indigo-600"
                    :class="sidebarOpen ? 'order-2' : 'order-1 mx-auto'"
                    title="Notifications"
                >
                    <span class="outcraft-icon text-[21px] leading-none">notifications</span>
                    <span class="absolute right-1 top-1 flex size-4 items-center justify-center rounded-full bg-indigo-600 text-[10px] font-semibold leading-none text-white ring-2 ring-white">3</span>
                    <span
                        x-show="! sidebarOpen"
                        class="pointer-events-none absolute left-full top-1/2 z-50 ml-3 -translate-y-1/2 translate-x-1 whitespace-nowrap rounded-md bg-gray-900 px-2.5 py-1.5 text-xs font-medium text-white opacity-0 shadow-lg ring-1 ring-gray-900/5 transition group-hover/notification:translate-x-0 group-hover/notification:opacity-100 group-focus-visible/notification:translate-x-0 group-focus-visible/notification:opacity-100"
                    >Notifications</span>
                </button>
            </div>
        </div>
    </aside>

    <main
        class="h-full transition-[margin-left] duration-300 ease-in-out [overflow-anchor:none]"
        :class="[
            campaignBuilderOpen ? 'ml-0 bg-white' : (sidebarOpen ? 'ml-72' : 'ml-16'),
            'overflow-auto',
            ! campaignBuilderOpen && activeNav === 'Campaigns' ? 'bg-white' : '',
            ! campaignBuilderOpen && activeNav !== 'Campaigns' ? 'bg-gray-50' : '',
        ]"
    >
        <section x-cloak x-show="campaignBuilderOpen" class="relative mx-6 mb-6 mt-6">
            <div
                x-cloak
                x-show="campaignBuilderTransitioning"
                x-transition.opacity
                class="fixed inset-0 z-50 flex items-center justify-center bg-white"
            >
                <div class="flex flex-col items-center gap-4">
                    <div class="flex size-[56px] items-center justify-center rounded-xl bg-white" x-html="tableLoaderSvg()"></div>
                    <p class="text-sm font-medium text-gray-500" x-text="campaignBuilderTransitionLabel"></p>
                </div>
            </div>

            <nav x-show="campaignBuilderStep < 3" aria-label="Progress" class="sticky top-0 z-30 -mx-6 mb-6 border-b border-gray-200 bg-white/95 px-4 py-4 backdrop-blur lg:hidden">
                <ol role="list" class="flex items-center justify-center">
                    <template x-for="(step, index) in companySetupSteps" :key="step.label">
                        <li class="relative" :class="index === companySetupSteps.length - 1 ? '' : 'flex-1'">
                            <div x-show="index !== companySetupSteps.length - 1" aria-hidden="true" class="absolute inset-0 flex items-center">
                                <div class="h-0.5 w-full" :class="campaignBuilderMaxStep > index ? 'bg-indigo-600' : 'bg-gray-200'"></div>
                            </div>
                            <button
                                type="button"
                                x-on:click="goToCampaignBuilderStep(index)"
                                :disabled="index > campaignBuilderMaxStep"
                                class="group relative flex flex-col items-center disabled:cursor-not-allowed"
                                :aria-current="campaignBuilderStep === index ? 'step' : null"
                            >
                                <span
                                    class="relative flex size-8 items-center justify-center rounded-full transition"
                                    :class="campaignBuilderStep === index ? 'border-2 border-indigo-600 bg-white' : (campaignBuilderMaxStep > index ? 'bg-indigo-600 text-white group-hover:bg-indigo-800' : 'border-2 border-gray-300 bg-white group-hover:border-gray-400')"
                                >
                                    <span x-show="campaignBuilderMaxStep > index && campaignBuilderStep !== index" class="outcraft-icon !text-[18px] text-white">check</span>
                                    <span x-show="campaignBuilderStep === index" class="size-2.5 rounded-full bg-indigo-600"></span>
                                    <span x-show="campaignBuilderStep !== index && campaignBuilderMaxStep <= index" class="size-2.5 rounded-full bg-transparent group-hover:bg-gray-300"></span>
                                </span>
                                <span class="mt-2 max-w-20 truncate text-center text-xs font-medium" :class="campaignBuilderStep === index ? 'text-indigo-600' : 'text-gray-500'" x-text="mobileCompanySetupLabel(index)"></span>
                            </button>
                        </li>
                    </template>
                </ol>
            </nav>

            <div x-ref="campaignBuilderScrollScene" :style="campaignBuilderScrollSceneStyle()" class="relative mx-auto flex max-w-7xl items-start gap-12 xl:gap-16">
                <button
                    x-show="campaignBuilderStep >= 3 && ! campaignSetupModeSelected"
                    type="button"
                    x-on:click="handleCampaignBuilderBack()"
                    class="absolute left-0 top-0 z-10 hidden h-9 w-fit items-center gap-2 rounded-md px-2 text-sm font-semibold text-gray-600 transition hover:bg-gray-50 hover:text-gray-950 lg:inline-flex"
                >
                    <span class="outcraft-icon !text-[18px]">arrow_back</span>
                    <span x-text="campaignBuilderBackLabel()"></span>
                </button>
                <div
                    x-show="campaignBuilderStep >= 3 && campaignSetupModeSelected"
                    class="absolute right-0 top-0 z-10 hidden items-center gap-2 lg:flex"
                >
                    <button type="button" class="inline-flex h-9 items-center gap-2 rounded-md bg-white px-3 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 transition hover:bg-gray-50">
                        <span class="outcraft-icon !text-[16px] text-gray-500">phone_in_talk</span>
                        Test Call
                    </button>
                    <div class="relative" x-data="{ setupModeMenuOpen: false }" x-on:click.outside="setupModeMenuOpen = false">
                        <button type="button" x-on:click="setupModeMenuOpen = ! setupModeMenuOpen" class="inline-flex size-9 items-center justify-center rounded-md text-gray-500 transition hover:bg-gray-100 hover:text-gray-900" aria-label="Setup Mode Options">
                            <span class="outcraft-icon !text-[18px]">more_vert</span>
                        </button>
                        <div x-cloak x-show="setupModeMenuOpen" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-1" class="absolute right-0 z-40 mt-2 w-52 rounded-md bg-white py-1 shadow-lg ring-1 ring-black/5" role="menu">
                            <p class="px-2 py-1 text-xs font-semibold uppercase tracking-wide text-gray-400">Setup Mode</p>
                            <button type="button" x-on:click="setCampaignSetupMode('fast'); setupModeMenuOpen = false" class="flex w-full items-center justify-between px-3 py-2 text-left text-sm font-medium transition" :class="campaignSetupMode === 'fast' ? 'text-gray-950' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-950'" role="menuitem">
                                <span>Fast</span>
                                <span x-show="campaignSetupMode === 'fast'" class="outcraft-icon !text-[16px] text-indigo-600">check</span>
                            </button>
                            <button type="button" x-on:click="setCampaignSetupMode('advanced'); setupModeMenuOpen = false" class="flex w-full items-center justify-between px-3 py-2 text-left text-sm font-medium transition" :class="campaignSetupMode === 'advanced' ? 'text-gray-950' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-950'" role="menuitem">
                                <span>Advanced</span>
                                <span x-show="campaignSetupMode === 'advanced'" class="outcraft-icon !text-[16px] text-indigo-600">check</span>
                            </button>
                        </div>
                    </div>
                </div>
                <aside x-show="campaignBuilderStep < 3 || campaignSetupModeSelected" class="hidden w-72 shrink-0 lg:block" :style="campaignBuilderProgressStickyStyle()">
                    <div>
                    <div x-ref="campaignBuilderProgressColumn">
                    <button
                        type="button"
                        x-on:click="handleCampaignBuilderBack()"
                        class="mb-8 inline-flex h-9 items-center gap-2 rounded-md px-2 text-sm font-semibold text-gray-600 transition hover:bg-gray-50 hover:text-gray-950"
                    >
                        <span class="outcraft-icon !text-[18px]">arrow_back</span>
                        <span x-text="campaignBuilderBackLabel()"></span>
                    </button>

                    <nav x-show="campaignBuilderStep < 3" x-ref="companySetupProgressNav" aria-label="Company setup progress">
                        <ol role="list" class="space-y-6">
                            <template x-for="(step, index) in companySetupSteps" :key="step.label">
                                <li class="relative flex gap-4">
                                    <span
                                        x-show="index !== companySetupSteps.length - 1"
                                        class="absolute left-4 top-8 -bottom-6 w-px"
                                        :class="campaignBuilderMaxStep > index ? 'bg-indigo-600' : 'bg-gray-200'"
                                    ></span>
                                    <button type="button" x-on:click="goToCampaignBuilderStep(index)" :disabled="index > campaignBuilderMaxStep" class="group flex min-w-0 items-start gap-4 text-left disabled:cursor-not-allowed">
                                        <span class="flex h-9 items-center">
                                            <span
                                                class="relative z-10 flex size-8 shrink-0 items-center justify-center rounded-full transition"
                                                :class="campaignBuilderStep === index ? 'border-2 border-indigo-600 bg-white' : (campaignBuilderMaxStep > index ? 'bg-indigo-600 text-white group-hover:bg-indigo-800' : 'border-2 border-gray-300 bg-white group-hover:border-gray-400')"
                                            >
                                                <span x-show="campaignBuilderMaxStep > index && campaignBuilderStep !== index" class="outcraft-icon !text-[18px] text-white">check</span>
                                                <span x-show="campaignBuilderStep === index" class="size-2.5 rounded-full bg-indigo-600"></span>
                                                <span x-show="campaignBuilderStep !== index && campaignBuilderMaxStep <= index" class="size-2.5 rounded-full bg-transparent group-hover:bg-gray-300"></span>
                                            </span>
                                        </span>
                                        <span class="min-w-0 pt-1">
                                            <span class="block text-sm font-semibold leading-6" :class="campaignBuilderStep === index ? 'text-indigo-600' : 'text-gray-950'" x-text="step.label"></span>
                                            <span class="block text-sm leading-5 text-gray-500" x-text="step.description"></span>
                                        </span>
                                    </button>
                                </li>
                            </template>
                        </ol>
                    </nav>

                    <nav x-show="campaignBuilderStep >= 3 && campaignSetupModeSelected" aria-label="Campaign setup progress" class="space-y-5">
                        <ol role="list" class="space-y-4">
                            <template x-for="(step, index) in campaignSetupPrimaryTimelineSteps()" :key="step.id">
                                <li class="relative flex gap-4">
                                    <span x-show="index !== campaignSetupPrimaryTimelineSteps().length - 1" class="absolute left-4 top-8 -bottom-4 w-px" :class="campaignSetupStatus(step.id) === 'done' ? 'bg-indigo-600' : 'bg-gray-200'"></span>
                                    <button type="button" x-on:click="setCampaignSetupStep(step.id)" class="group flex min-w-0 items-start gap-4 text-left">
                                        <span class="flex h-9 items-center" x-html="campaignSetupStatusIcon(step.id, campaignSetupStepNumber(step.id))"></span>
                                        <span class="min-w-0 pt-1">
                                            <span class="block text-sm font-semibold leading-6" :class="campaignSetup.current === step.id ? 'text-indigo-600' : 'text-gray-950'" x-text="step.label"></span>
                                            <span class="block text-sm leading-5 text-gray-500" x-text="step.description"></span>
                                        </span>
                                    </button>
                                </li>
                            </template>
                        </ol>

                        <ol x-show="campaignSetupSecondaryTimelineSteps().length > 0" role="list" class="mt-8 space-y-4 border-t border-gray-200 pt-6">
                            <template x-for="(step, index) in campaignSetupSecondaryTimelineSteps()" :key="step.id">
                                <li class="relative flex gap-4">
                                    <span x-show="index !== campaignSetupSecondaryTimelineSteps().length - 1" class="absolute left-4 top-8 -bottom-4 w-px" :class="campaignSetupStatus(step.id) === 'done' ? 'bg-indigo-600' : 'bg-gray-200'"></span>
                                    <button type="button" x-on:click="setCampaignSetupStep(step.id)" class="group flex min-w-0 items-start gap-4 text-left">
                                        <span class="flex h-9 items-center" x-html="campaignSetupStatusIcon(step.id, campaignSetupStepNumber(step.id))"></span>
                                        <span class="min-w-0 pt-1">
                                            <span class="block text-sm font-semibold leading-6" :class="campaignSetup.current === step.id ? 'text-indigo-600' : 'text-gray-950'" x-text="step.label"></span>
                                            <span class="block text-sm leading-5 text-gray-500" x-text="step.description"></span>
                                        </span>
                                    </button>
                                </li>
                            </template>
                        </ol>
                    </nav>
                    </div>
                    </div>
                </aside>

                <div class="min-w-0 flex-1" :class="campaignBuilderStep >= 3 && ! campaignSetupModeSelected ? 'w-full' : ''">
                <div x-ref="campaignBuilderContentScroll" class="lg:pt-[78px]">
                    <div x-show="campaignBuilderStep < 3" x-ref="companyDetailsFormStage" x-effect="campaignBuilderStep; companyForm.pronunciationEnabled; updateCampaignBuilderStickyLayout(); updateCampaignBuilderBottomPadding()" class="relative [overflow-anchor:none] lg:flex lg:flex-col" :style="`padding-bottom: ${campaignBuilderBottomPadding}px;`">
                        <section
                            x-cloak
                            x-show="campaignBuilderStep === 0 || campaignBuilderScrollFromStep === 0"
                            x-ref="companyIdentitySection"
                            :style="campaignBuilderCompanyStepStyle(0)"
                            class="space-y-7 pr-2 pb-14"
                        >
                            <div class="flex items-start justify-between gap-4">
                                <div>
                                    <h1 class="text-[24px] font-bold leading-8 text-gray-950">Company Details</h1>
                                    <p class="mt-3 max-w-3xl text-sm leading-6 text-gray-600">Before creating your first campaign, please complete your company details. This helps our AI understand your business, adapt to your context, and prepare for more accurate conversations with your leads.</p>
                                </div>
                                <button type="button" x-on:click="exitCampaignBuilder()" class="inline-flex size-9 items-center justify-center rounded-md text-gray-400 transition hover:bg-gray-50 hover:text-gray-950 lg:hidden" aria-label="Close builder">
                                    <span class="outcraft-icon !text-[22px]">close</span>
                                </button>
                            </div>

                            <div class="grid grid-cols-1 gap-x-8 gap-y-10 md:grid-cols-3">
                                <div>
                                    <h2 class="text-base/7 font-semibold text-gray-900">Company Identity</h2>
                                    <p class="mt-1 text-sm/6 text-gray-500">Basic brand details the agent will use when introducing the company.</p>
                                    <button type="button" :disabled="campaignBuilderStep !== 0" class="mt-4 inline-flex h-9 items-center gap-2 rounded-md bg-white px-3 text-sm font-semibold text-green-700 shadow-sm ring-1 ring-inset ring-green-600 transition hover:bg-green-50 disabled:cursor-not-allowed disabled:opacity-50">
                                        <span class="outcraft-icon !text-[18px]">astroid</span>
                                        Fill with AI
                                    </button>
                                </div>

                                <form x-on:submit.prevent="submitCampaignBuilderStep(0)" novalidate class="md:col-span-2">
                                    <fieldset :disabled="campaignBuilderStep !== 0">
                                        <div class="grid grid-cols-1 gap-x-6 gap-y-8 sm:max-w-xl sm:grid-cols-6">
                                        <div class="sm:col-span-3">
                                            <label class="block text-sm/6 font-medium text-gray-900">Company Name<span class="text-indigo-600">*</span></label>
                                            <input data-campaign-field="name" x-model="companyForm.name" x-on:input="clearCampaignBuilderError('name')" :aria-invalid="Boolean(campaignBuilderErrors.name)" required type="text" placeholder="Enter your company legal name" class="mt-2 block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline outline-1 -outline-offset-1 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 disabled:bg-gray-50 disabled:text-gray-500 sm:text-sm/6" :class="campaignBuilderErrors.name ? 'outline-red-300 focus:outline-red-600' : 'outline-gray-300'">
                                            <p x-show="campaignBuilderErrors.name" x-text="campaignBuilderErrors.name" class="mt-2 text-sm/6 text-red-600"></p>
                                        </div>

                                        <div class="sm:col-span-3">
                                            <label class="block text-sm/6 font-medium text-gray-900">Company Website<span class="text-indigo-600">*</span></label>
                                            <input data-campaign-field="website" x-model="companyForm.website" x-on:input="clearCampaignBuilderError('website')" :aria-invalid="Boolean(campaignBuilderErrors.website)" required type="text" placeholder="example.com" class="mt-2 block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline outline-1 -outline-offset-1 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 disabled:bg-gray-50 disabled:text-gray-500 sm:text-sm/6" :class="campaignBuilderErrors.website ? 'outline-red-300 focus:outline-red-600' : 'outline-gray-300'">
                                            <p x-show="campaignBuilderErrors.website" x-text="campaignBuilderErrors.website" class="mt-2 text-sm/6 text-red-600"></p>
                                        </div>

                                        <div class="col-span-full">
                                            <div class="flex items-center justify-between gap-4">
                                                <span class="flex grow flex-col">
                                                    <label id="brand-pronunciation-toggle-label" class="text-sm/6 font-medium text-gray-900">Difficult to Pronounce the Brand Name?</label>
                                                    <span id="brand-pronunciation-toggle-description" class="text-sm/6 text-gray-500">Add a pronunciation guide if the AI should say it carefully.</span>
                                                </span>
                                                <button
                                                    id="brand-pronunciation-toggle"
                                                    type="button"
                                                    role="switch"
                                                    x-on:click="companyForm.pronunciationEnabled = ! companyForm.pronunciationEnabled"
                                                    :aria-checked="companyForm.pronunciationEnabled.toString()"
                                                    aria-labelledby="brand-pronunciation-toggle-label"
                                                    aria-describedby="brand-pronunciation-toggle-description"
                                                    class="relative inline-flex h-6 w-11 shrink-0 cursor-pointer rounded-full p-0.5 outline-offset-2 transition-colors duration-200 ease-in-out focus-visible:outline-2 focus-visible:outline-indigo-600"
                                                    :class="companyForm.pronunciationEnabled ? 'bg-indigo-600' : 'bg-gray-200'"
                                                >
                                                    <span
                                                        aria-hidden="true"
                                                        class="size-5 rounded-full bg-white shadow-sm ring-1 ring-gray-900/5 transition-transform duration-200 ease-in-out"
                                                        :class="companyForm.pronunciationEnabled ? 'translate-x-5' : 'translate-x-0'"
                                                    ></span>
                                                </button>
                                            </div>

                                            <label x-show="companyForm.pronunciationEnabled" x-transition.opacity class="mt-5 block">
                                                <span class="block text-sm/6 font-medium text-gray-900">Brand Name Pronunciation</span>
                                                <input x-model="companyForm.pronunciation" type="text" placeholder="For example: Goo-gul, Ny-kee, A-dee-das" class="mt-2 block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 disabled:bg-gray-50 disabled:text-gray-500 sm:text-sm/6">
                                            </label>
                                        </div>
                                        </div>
                                    </fieldset>
                                    <div x-show="campaignBuilderStep === 0" data-campaign-step-actions class="hidden">
                                        <button type="button" class="inline-flex h-9 items-center gap-2 rounded-md bg-white px-3 text-sm font-semibold text-green-700 shadow-sm ring-1 ring-inset ring-green-600 transition hover:bg-green-50">
                                            <span class="outcraft-icon !text-[18px]">astroid</span>
                                            Fill with AI
                                        </button>
                                        <button type="submit" class="inline-flex items-center gap-2 rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Continue Manually<span class="outcraft-icon !text-[18px]">arrow_downward</span></button>
                                    </div>
                                </form>
                            </div>
                        </section>

                        <section
                            x-cloak
                            x-show="campaignBuilderStep === 1 || campaignBuilderScrollFromStep === 1"
                            x-ref="industryMarketSection"
                            :style="campaignBuilderCompanyStepStyle(1)"
                            class="grid grid-cols-1 gap-x-8 gap-y-10 pr-2 pb-14 md:grid-cols-3"
                        >
                            <div>
                                <h2 class="text-base/7 font-semibold text-gray-900">Industry & Market</h2>
                                <p class="mt-1 text-sm/6 text-gray-500">Market context, customer profile, differentiators, and FAQs for campaign reasoning.</p>
                                <button type="button" :disabled="campaignBuilderStep !== 1" class="mt-4 inline-flex h-9 items-center gap-2 rounded-md bg-white px-3 text-sm font-semibold text-green-700 shadow-sm ring-1 ring-inset ring-green-600 transition hover:bg-green-50 disabled:cursor-not-allowed disabled:opacity-50">
                                    <span class="outcraft-icon !text-[18px]">astroid</span>
                                    Fill Details with AI
                                </button>
                            </div>

                            <form x-on:submit.prevent="submitCampaignBuilderStep(1)" novalidate class="md:col-span-2">
                                <fieldset :disabled="campaignBuilderStep !== 1">
                                    <div class="grid grid-cols-1 gap-x-6 gap-y-8 sm:max-w-xl sm:grid-cols-6">
                                        <div class="sm:col-span-3" x-data="{ industryOpen: false, industries: ['SaaS', 'Ecommerce', 'Healthcare', 'Financial Services', 'Consumer Services'] }" x-on:keydown.escape.window="industryOpen = false" x-on:click.outside="industryOpen = false">
                                            <label class="block text-sm/6 font-medium text-gray-900">Industry Vertical<span class="text-indigo-600">*</span></label>
                                            <div class="relative mt-2">
                                                <button
                                                    type="button"
                                                    data-campaign-field="industry"
                                                    x-on:click="industryOpen = ! industryOpen"
                                                    :aria-expanded="industryOpen.toString()"
                                                    :aria-invalid="Boolean(campaignBuilderErrors.industry)"
                                                    class="relative block h-9 w-full rounded-md bg-white py-1.5 pr-8 pl-3 text-left text-sm/6 text-gray-900 outline outline-1 -outline-offset-1 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 disabled:bg-gray-50 disabled:text-gray-500"
                                                    :class="campaignBuilderErrors.industry ? 'outline-red-300 focus:outline-red-600' : 'outline-gray-300'"
                                                >
                                                    <span class="block truncate" :class="companyForm.industry ? 'text-gray-900' : 'text-gray-400'" x-text="companyForm.industry || 'Select Your Industry Vertical'"></span>
                                                    <span class="outcraft-icon pointer-events-none absolute right-2 top-1/2 -translate-y-1/2 !text-[16px] text-gray-400">keyboard_arrow_down</span>
                                                </button>
                                                <div
                                                    x-cloak
                                                    x-show="industryOpen"
                                                    x-transition:enter="transition ease-out duration-100"
                                                    x-transition:enter-start="opacity-0 translate-y-3"
                                                    x-transition:enter-end="opacity-100 translate-y-0"
                                                    x-transition:leave="transition ease-in duration-75"
                                                    x-transition:leave-start="opacity-100 translate-y-0"
                                                    x-transition:leave-end="opacity-0 translate-y-2"
                                                    class="absolute z-30 mt-2 max-h-60 w-full overflow-auto rounded-md bg-white py-1 text-sm shadow-lg ring-1 ring-gray-900/5 focus:outline-none"
                                                >
                                                    <template x-for="industry in industries" :key="industry">
                                                        <button
                                                            type="button"
                                                            x-on:click="companyForm.industry = industry; clearCampaignBuilderError('industry'); industryOpen = false"
                                                            class="flex w-full items-center justify-between px-3 py-2 text-left text-gray-900 transition hover:bg-indigo-50 hover:text-indigo-700"
                                                            :class="companyForm.industry === industry ? 'bg-indigo-50 text-indigo-700' : ''"
                                                        >
                                                            <span class="truncate" x-text="industry"></span>
                                                            <span x-show="companyForm.industry === industry" class="outcraft-icon !text-[16px]">check</span>
                                                        </button>
                                                    </template>
                                                </div>
                                            </div>
                                            <p x-show="campaignBuilderErrors.industry" x-text="campaignBuilderErrors.industry" class="mt-2 text-sm/6 text-red-600"></p>
                                        </div>

                                        <div class="col-span-full">
                                            <label class="block text-sm/6 font-medium text-gray-900">Company Description<span class="text-indigo-600">*</span></label>
                                            <textarea data-campaign-field="description" x-model="companyForm.description" x-on:input="clearCampaignBuilderError('description')" :aria-invalid="Boolean(campaignBuilderErrors.description)" required rows="4" class="mt-2 block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline outline-1 -outline-offset-1 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 disabled:bg-gray-50 disabled:text-gray-500 sm:text-sm/6" :class="campaignBuilderErrors.description ? 'outline-red-300 focus:outline-red-600' : 'outline-gray-300'" placeholder="Describe what your company does, who you serve, and the main value your product or service creates."></textarea>
                                            <p x-show="campaignBuilderErrors.description" x-text="campaignBuilderErrors.description" class="mt-2 text-sm/6 text-red-600"></p>
                                        </div>

                                        <div class="col-span-full">
                                            <label class="block text-sm/6 font-medium text-gray-900">Problem You Solve</label>
                                            <textarea x-model="companyForm.problem" rows="5" class="mt-2 block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 disabled:bg-gray-50 disabled:text-gray-500 sm:text-sm/6" placeholder="Describe the pain points, needs, or jobs your customers come to you for."></textarea>
                                        </div>

                                        <div class="col-span-full">
                                            <label class="block text-sm/6 font-medium text-gray-900">Benefits Over Competitors (Differentiators)</label>
                                            <textarea x-model="companyForm.differentiators" rows="6" class="mt-2 block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 disabled:bg-gray-50 disabled:text-gray-500 sm:text-sm/6" placeholder="List the main reasons customers choose you over alternatives."></textarea>
                                        </div>

                                        <div class="col-span-full">
                                            <label class="block text-sm/6 font-medium text-gray-900">Ideal Customer Profile</label>
                                            <textarea x-model="companyForm.icp" rows="5" class="mt-2 block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 disabled:bg-gray-50 disabled:text-gray-500 sm:text-sm/6" placeholder="Describe the buyer types, segments, company sizes, regions, and common needs."></textarea>
                                        </div>

                                        <div class="col-span-full">
                                            <label class="block text-sm/6 font-medium text-gray-900">Frequently Asked Questions (FAQs)</label>
                                            <textarea x-model="companyForm.faqs" rows="9" class="mt-2 block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 disabled:bg-gray-50 disabled:text-gray-500 sm:text-sm/6" placeholder="Q: What is your pricing model?&#10;A: ...&#10;&#10;Q: Do you offer a free trial?&#10;A: ..."></textarea>
                                        </div>
                                    </div>
                                </fieldset>
                                <div x-show="campaignBuilderStep === 1" data-campaign-step-actions class="hidden">
                                    <button type="button" x-on:click="previousCampaignBuilderStep()" class="inline-flex items-center gap-2 text-sm font-semibold leading-6 text-gray-900"><span class="outcraft-icon !text-[18px]">arrow_upward</span>Back</button>
                                    <button type="submit" class="inline-flex items-center gap-2 rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Continue<span class="outcraft-icon !text-[18px]">arrow_downward</span></button>
                                </div>
                            </form>
                        </section>

                        <section
                            x-cloak
                            x-show="campaignBuilderStep === 2 || campaignBuilderScrollFromStep === 2"
                            x-ref="complianceLegalSection"
                            :style="campaignBuilderCompanyStepStyle(2)"
                            class="grid grid-cols-1 gap-x-8 gap-y-10 pr-2 pb-14 md:grid-cols-3"
                        >
                            <div>
                                <h2 class="text-base/7 font-semibold text-gray-900">Compliance & Legal</h2>
                                <p class="mt-1 text-sm/6 text-gray-500">Support and policy details the agent can reference or route to.</p>
                                <button type="button" :disabled="campaignBuilderStep !== 2" class="mt-4 inline-flex h-9 items-center gap-2 rounded-md bg-white px-3 text-sm font-semibold text-green-700 shadow-sm ring-1 ring-inset ring-green-600 transition hover:bg-green-50 disabled:cursor-not-allowed disabled:opacity-50">
                                    <span class="outcraft-icon !text-[18px]">astroid</span>
                                    Fill Details with AI
                                </button>
                            </div>

                            <form x-on:submit.prevent="submitCampaignBuilderStep(2)" novalidate class="md:col-span-2">
                                <fieldset :disabled="campaignBuilderStep !== 2">
                                    <div class="grid grid-cols-1 gap-x-6 gap-y-8 sm:max-w-xl sm:grid-cols-6">
                                        <div class="sm:col-span-4">
                                            <label class="block text-sm/6 font-medium text-gray-900">Support Email</label>
                                            <input x-model="companyForm.supportEmail" type="email" placeholder="support@company.com" class="mt-2 block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 disabled:bg-gray-50 disabled:text-gray-500 sm:text-sm/6">
                                            <p class="mt-2 text-sm leading-6 text-gray-500">Human support email.</p>
                                        </div>

                                        <div class="col-span-full border-t border-gray-200 pt-6">
                                            <div class="grid grid-cols-1 gap-x-6 gap-y-6 sm:grid-cols-6">
                                                <div class="col-span-full">
                                                    <label class="block text-sm/6 font-medium text-gray-900">Terms of Service Page</label>
                                                    <input x-model="companyForm.termsUrl" type="url" placeholder="https://example.com/terms-of-service" class="mt-2 block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 disabled:bg-gray-50 disabled:text-gray-500 sm:text-sm/6">
                                                    <p class="mt-2 text-sm leading-6 text-gray-500">Link to your terms of service or user agreement page.</p>
                                                </div>

                                                <div class="col-span-full">
                                                    <label class="block text-sm/6 font-medium text-gray-900">Privacy Policy Page</label>
                                                    <input x-model="companyForm.privacyUrl" type="url" placeholder="https://example.com/privacy-policy" class="mt-2 block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 disabled:bg-gray-50 disabled:text-gray-500 sm:text-sm/6">
                                                    <p class="mt-2 text-sm leading-6 text-gray-500">Link to your privacy policy or legal compliance page.</p>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-span-full border-t border-gray-200 pt-6">
                                            <div class="grid grid-cols-1 gap-x-6 gap-y-6 sm:grid-cols-6">
                                                <div class="col-span-full">
                                                    <label class="block text-sm/6 font-medium text-gray-900">Certifications</label>
                                                    <input x-model="companyForm.certifications" type="text" placeholder="SOC2, ISO 27001, HIPAA" class="mt-2 block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 disabled:bg-gray-50 disabled:text-gray-500 sm:text-sm/6">
                                                    <p class="mt-2 text-sm leading-6 text-gray-500">List any relevant certifications your company holds.</p>
                                                </div>

                                                <div class="col-span-full">
                                                    <label class="block text-sm/6 font-medium text-gray-900">Compliance</label>
                                                    <input x-model="companyForm.compliance" type="text" placeholder="GDPR, CCPA, HIPAA" class="mt-2 block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 disabled:bg-gray-50 disabled:text-gray-500 sm:text-sm/6">
                                                    <p class="mt-2 text-sm leading-6 text-gray-500">List any relevant compliance standards your company adheres to.</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </fieldset>
                                <div x-show="campaignBuilderStep === 2" data-campaign-step-actions class="hidden">
                                    <button type="button" x-on:click="previousCampaignBuilderStep()" class="inline-flex items-center gap-2 text-sm font-semibold leading-6 text-gray-900"><span class="outcraft-icon !text-[18px]">arrow_upward</span>Back</button>
                                    <button type="submit" class="inline-flex items-center gap-2 rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Continue to Campaign<span class="outcraft-icon !text-[18px]">arrow_forward</span></button>
                                </div>
                            </form>
                        </section>

                        <div x-show="campaignBuilderStep < 3" class="fixed inset-x-0 bottom-0 z-40 mt-auto hidden border-t border-gray-200 bg-white/95 py-4 backdrop-blur lg:flex" :style="campaignBuilderActionBarStyle">
                            <div class="flex w-full items-center justify-between gap-3" :style="campaignBuilderActionBarContentStyle">
                                <button
                                    type="button"
                                    x-on:click="campaignBuilderRailBack()"
                                    class="inline-flex h-9 items-center gap-2 rounded-md px-2 text-sm font-semibold text-gray-600 transition hover:bg-gray-50 hover:text-gray-950"
                                >
                                    <span class="outcraft-icon !text-[18px]">arrow_upward</span>
                                    Back
                                </button>
                                <button
                                    type="button"
                                    x-on:click="submitCampaignBuilderStep(campaignBuilderStep)"
                                    class="inline-flex h-9 items-center gap-2 rounded-md bg-indigo-600 px-3 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
                                >
                                    <span x-text="campaignBuilderContinueLabel()"></span>
                                    <span class="outcraft-icon !text-[18px]" x-text="campaignBuilderStep === 2 ? 'arrow_forward' : 'arrow_downward'"></span>
                                </button>
                            </div>
                        </div>
                        <div x-show="campaignBuilderStep < 3" class="fixed inset-x-0 bottom-0 z-40 flex items-center justify-between gap-3 border-t border-gray-200 bg-white/95 px-4 py-3 backdrop-blur lg:hidden">
                            <button
                                type="button"
                                x-on:click="campaignBuilderRailBack()"
                                class="inline-flex h-10 items-center gap-2 rounded-md px-2 text-sm font-semibold text-gray-600 transition hover:bg-gray-50 hover:text-gray-950"
                            >
                                <span class="outcraft-icon !text-[18px]">arrow_upward</span>
                                Back
                            </button>
                            <button
                                type="button"
                                x-on:click="submitCampaignBuilderStep(campaignBuilderStep)"
                                class="inline-flex h-10 min-w-0 items-center gap-2 rounded-md bg-indigo-600 px-3 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-500"
                            >
                                <span class="truncate" x-text="campaignBuilderMobileContinueLabel()"></span>
                                <span class="outcraft-icon !text-[18px]" x-text="campaignBuilderStep === 2 ? 'arrow_forward' : 'arrow_downward'"></span>
                            </button>
                        </div>
                    </div>

		                    <div x-show="campaignBuilderStep >= 3" x-ref="campaignAgentSection" class="space-y-6" :style="`padding-bottom: ${campaignSetupBottomPadding}px;`">
		                        <div x-show="! campaignSetupModeSelected" class="relative mx-auto flex min-h-[calc(100vh-96px)] w-full max-w-7xl flex-col items-center justify-center px-4">
		                            <button type="button" x-on:click="handleCampaignBuilderBack()" class="absolute left-0 top-0 inline-flex h-9 w-fit items-center gap-2 rounded-md px-2 text-sm font-semibold text-gray-600 transition hover:bg-gray-50 hover:text-gray-950 lg:hidden">
		                                <span class="outcraft-icon !text-[18px]">arrow_back</span>
		                                <span x-text="campaignBuilderBackLabel()"></span>
		                            </button>
		                            <div x-show="campaignSetupIntroStep === 'type'" class="mx-auto w-full space-y-8 lg:max-w-[calc(80rem-18rem-3rem)] xl:max-w-[calc(80rem-18rem-4rem)]">
                                <div class="text-center">
                                    <h2 class="text-2xl font-bold leading-8 tracking-tight text-gray-950" x-text="campaignSetupHeading('type')"></h2>
                                    <p class="mx-auto mt-2 max-w-2xl text-sm leading-6 text-gray-600" x-text="campaignSetupDescription('type')"></p>
                                </div>
                                <template x-for="group in campaignTypeGroups" :key="group.label">
                                    <div>
                                        <h3 class="text-center text-sm font-semibold uppercase tracking-wide text-gray-400" x-text="group.label"></h3>
                                        <div class="mt-4 grid auto-rows-fr items-stretch gap-4 md:grid-cols-3">
                                            <template x-for="type in group.items" :key="type.name">
                                                <button type="button" x-on:click="selectCampaignType(type.name)" class="flex h-full flex-col items-start rounded-lg bg-white p-5 text-left shadow-sm outline outline-1 -outline-offset-1 transition hover:outline-2 hover:-outline-offset-2 hover:outline-indigo-600 hover:shadow-sm focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600" :class="campaignSetup.type === type.name ? 'outline-2 -outline-offset-2 outline-indigo-600' : 'outline-gray-300'">
                                                    <div class="flex items-start gap-4">
                                                        <span class="flex size-10 shrink-0 items-center justify-center rounded-md bg-indigo-50 text-indigo-600"><span class="outcraft-icon !text-[21px]" x-text="type.icon"></span></span>
                                                        <span>
                                                            <span class="block text-sm font-bold text-gray-950" x-text="type.name"></span>
                                                            <span class="mt-1 block text-sm leading-6 text-gray-500" x-text="type.description"></span>
                                                        </span>
                                                    </div>
                                                </button>
                                            </template>
                                        </div>
                                    </div>
                                </template>
                            </div>

	                            <div x-show="campaignSetupIntroStep === 'source'" class="mx-auto w-full space-y-8 lg:max-w-[calc(80rem-18rem-3rem)] xl:max-w-[calc(80rem-18rem-4rem)]">
                                <div class="text-center">
                                    <h2 class="text-2xl font-bold leading-8 tracking-tight text-gray-950" x-text="campaignSetupHeading('source')"></h2>
                                    <p class="mx-auto mt-2 max-w-2xl text-sm leading-6 text-gray-600" x-text="campaignSetupDescription('source')"></p>
                                </div>
                                <template x-for="group in leadSourceGroups" :key="group.label">
                                    <div>
                                        <h3 class="text-center text-sm font-semibold uppercase tracking-wide text-gray-400" x-text="group.label"></h3>
                                        <div class="mt-4 grid auto-rows-fr items-stretch gap-4 md:grid-cols-3">
                                            <template x-for="source in group.items" :key="source.name">
                                                <button type="button" x-on:click="selectLeadSource(source.name)" class="flex h-full flex-col items-start rounded-lg bg-white p-5 text-left shadow-sm outline outline-1 -outline-offset-1 transition hover:outline-2 hover:-outline-offset-2 hover:outline-indigo-600 hover:shadow-sm focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600" :class="campaignSetup.source === source.name ? 'outline-2 -outline-offset-2 outline-indigo-600' : 'outline-gray-300'">
                                                    <span class="block text-sm font-bold text-gray-950" x-text="source.name"></span>
                                                    <span class="mt-2 block text-sm leading-6 text-gray-500" x-text="source.description"></span>
                                                    <span x-show="source.requiresIntegration" class="mt-4 inline-flex rounded-md bg-blue-50 px-2 py-1 text-xs font-medium text-blue-700 ring-1 ring-inset ring-blue-700/10">Integration Needed for Launch</span>
                                                </button>
                                            </template>
                                        </div>
                                    </div>
                                </template>
                            </div>

	                            <div x-show="campaignSetupIntroStep === 'integration'" class="mx-auto w-full space-y-8 lg:max-w-[calc(80rem-18rem-3rem)] xl:max-w-[calc(80rem-18rem-4rem)]">
                                <div class="text-center">
                                    <h2 class="text-2xl font-bold leading-8 tracking-tight text-gray-950" x-text="campaignSetupHeading('integration')"></h2>
                                    <p class="mx-auto mt-2 max-w-2xl text-sm leading-6 text-gray-600" x-text="campaignSetupDescription('integration')"></p>
                                </div>
                                <div class="mx-auto max-w-2xl rounded-lg bg-white p-6 shadow-sm outline outline-1 -outline-offset-1 outline-gray-300">
                                    <div class="flex items-start gap-4">
                                        <span class="flex size-10 shrink-0 items-center justify-center rounded-md bg-indigo-50 text-indigo-600">
                                            <span class="outcraft-icon !text-[21px]">hub</span>
                                        </span>
                                        <div class="min-w-0">
                                            <h3 class="text-sm font-bold text-gray-950" x-text="campaignSetup.source || 'Lead Source'"></h3>
                                            <p class="mt-1 text-sm leading-6 text-gray-600">Connect your lead source now to use its customer fields, events, and merge tags while building this campaign.</p>
                                        </div>
                                    </div>
                                    <div class="mt-6 flex flex-wrap gap-3">
                                        <button type="button" x-on:click="connectCampaignSource()" class="inline-flex h-9 items-center rounded-md bg-indigo-600 px-3 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-500" x-text="`Connect ${campaignSetup.source || 'Lead Source'}`"></button>
                                        <button type="button" x-on:click="skipCampaignIntegration()" class="inline-flex h-9 items-center rounded-md bg-white px-3 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 transition hover:bg-gray-50">Setup Later</button>
                                    </div>
                                </div>
                                <p class="mx-auto max-w-2xl text-center text-sm leading-6 text-gray-500">If you choose Setup later, campaign setup will not have access to custom fields or merge tags coming from the lead source. Those fields help the AI agent personalize the conversation more effectively.</p>
                            </div>

	                            <div x-show="campaignSetupIntroStep === 'mode'" class="mx-auto w-full space-y-8 lg:max-w-[calc(80rem-18rem-3rem)] xl:max-w-[calc(80rem-18rem-4rem)]">
                                <div class="text-center">
                                    <h2 class="text-2xl font-bold leading-8 tracking-tight text-gray-950">Choose How You Want to Set Up Your Campaign</h2>
                                    <p class="mx-auto mt-2 max-w-2xl text-sm leading-6 text-gray-600">Pick a guided path. You can move faster with recommended defaults or configure every campaign setting manually.</p>
                                </div>
                                <div class="mx-auto grid w-full max-w-5xl auto-rows-fr items-stretch gap-4 md:grid-cols-3">
                                <button type="button" x-on:click="chooseCampaignSetupPath('fast')" class="flex h-full flex-col items-start rounded-lg bg-white p-5 text-left shadow-sm outline outline-1 -outline-offset-1 outline-gray-300 transition hover:outline-2 hover:-outline-offset-2 hover:outline-indigo-600 hover:shadow-sm focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                                    <div class="flex items-start gap-4">
                                        <span class="flex size-10 shrink-0 items-center justify-center rounded-md bg-indigo-50 text-indigo-600">
                                            <span class="outcraft-icon !text-[21px]">zap</span>
                                        </span>
                                        <span>
                                            <span class="block text-sm font-bold text-gray-950">Fast Track</span>
                                            <span class="mt-1 block text-sm leading-6 text-gray-600">Set up the essentials in about 4 minutes and start a test call with your AI agent.</span>
                                        </span>
                                    </div>
                                </button>

                                <button type="button" x-on:click="chooseCampaignSetupPath('advanced')" class="flex h-full flex-col items-start rounded-lg bg-white p-5 text-left shadow-sm outline outline-1 -outline-offset-1 outline-gray-300 transition hover:outline-2 hover:-outline-offset-2 hover:outline-indigo-600 hover:shadow-sm focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                                    <div class="flex items-start gap-4">
                                        <span class="flex size-10 shrink-0 items-center justify-center rounded-md bg-indigo-50 text-indigo-600">
                                            <span class="outcraft-icon !text-[21px]">tune</span>
                                        </span>
                                        <span>
                                            <span class="block text-sm font-bold text-gray-950">Full Setup</span>
                                            <span class="mt-1 block text-sm leading-6 text-gray-600">Configure every campaign step, channel, schedule, AI agent setting, and launch rule.</span>
                                        </span>
                                    </div>
                                </button>
                                </div>
                            </div>
                        </div>

	                        <div x-show="campaignSetupModeSelected && ! campaignSetupIntroStep" x-effect="campaignSetup.current; campaignSetupModeSelected; campaignSetupIntroStep; campaignSetup.channelOpen.calls; campaignSetup.channelOpen.email; campaignSetup.channelOpen.sms; campaignSetup.channelOpen.whatsapp; campaignSetup.scheduleMode; agentAdvancedOpen; scheduleCampaignBuilderLayoutUpdate()" class="relative">
                            <section x-cloak x-show="campaignSetup.current === 'start' || campaignSetupScrollFromStep === 'start'" x-ref="campaignSetupStep_start"
                                :style="campaignSetupStepStyle('start')"
                                data-campaign-setup-step
                                class="space-y-6 pr-2 pb-4">
                                <div class="mb-1">
                                    <p class="text-sm font-semibold text-indigo-600" x-text="`${campaignSetupMode === 'fast' ? 'Fast Setup' : 'Advanced Setup'} · Step ${campaignSetupStepIndex('start') + 1} of ${campaignSetupStepsForMode().length}`"></p>
                                    <h2 class="mt-2 text-2xl font-bold leading-8 tracking-tight text-gray-950" x-text="campaignSetupHeading('start')"></h2>
                                    <p class="mt-2 max-w-3xl text-sm leading-6 text-gray-600" x-text="campaignSetupDescription('start')"></p>
                                </div>
                                <div class="max-w-xl">
                                    <label class="block">
                                        <span class="block text-sm/6 font-medium text-gray-900">Campaign Name</span>
                                        <input x-model="campaignSetup.name" type="text" placeholder="Generated automatically from campaign type" class="mt-2 block w-full rounded-md bg-white px-3 py-1.5 text-sm/6 text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600">
                                        <span class="mt-2 block text-sm leading-6 text-gray-500">You can rename the campaign later.</span>
                                    </label>
                            </section>

                            <section x-cloak x-show="campaignSetup.current === 'type' || campaignSetupScrollFromStep === 'type'" x-ref="campaignSetupStep_type"
                                :style="campaignSetupStepStyle('type')"
                                data-campaign-setup-step
                                class="space-y-7 pr-2 pb-4">
                                <div class="mb-1">
                                    <p class="text-sm font-semibold text-indigo-600" x-text="`${campaignSetupMode === 'fast' ? 'Fast Setup' : 'Advanced Setup'} · Step ${campaignSetupStepIndex('type') + 1} of ${campaignSetupStepsForMode().length}`"></p>
                                    <h2 class="mt-2 text-2xl font-bold leading-8 tracking-tight text-gray-950" x-text="campaignSetupHeading('type')"></h2>
                                    <p class="mt-2 max-w-3xl text-sm leading-6 text-gray-600" x-text="campaignSetupDescription('type')"></p>
                                </div>
                                <template x-for="group in campaignTypeGroups" :key="group.label">
                                    <div>
                                        <h3 class="text-sm font-semibold uppercase tracking-wide text-gray-400" x-text="group.label"></h3>
                                        <div class="mt-4 grid gap-4 md:grid-cols-2">
                                            <template x-for="type in group.items" :key="type.name">
                                                <button type="button" x-on:click="selectCampaignType(type.name)" class="flex h-full flex-col items-start rounded-lg bg-white p-5 text-left shadow-sm outline outline-1 -outline-offset-1 transition hover:outline-2 hover:-outline-offset-2 hover:outline-indigo-600 hover:shadow-sm focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600" :class="campaignSetup.type === type.name ? 'outline-2 -outline-offset-2 outline-indigo-600' : 'outline-gray-300'">
                                                    <div class="flex items-start gap-4">
                                                        <span class="flex size-10 shrink-0 items-center justify-center rounded-md bg-indigo-50 text-indigo-600"><span class="outcraft-icon !text-[21px]" x-text="type.icon"></span></span>
                                                        <span>
                                                            <span class="block text-sm font-bold text-gray-950" x-text="type.name"></span>
                                                            <span class="mt-1 block text-sm leading-6 text-gray-500" x-text="type.description"></span>
                                                        </span>
                                                    </div>
                                                    <p class="mt-4 rounded-md bg-gray-50 p-3 text-xs leading-5 text-gray-500" x-text="type.example"></p>
                                                </button>
                                            </template>
                                        </div>
                                    </div>
                                </template>
                            </section>

                            <section x-cloak x-show="campaignSetup.current === 'source' || campaignSetupScrollFromStep === 'source'" x-ref="campaignSetupStep_source"
                                :style="campaignSetupStepStyle('source')"
                                data-campaign-setup-step
                                class="space-y-7 pr-2 pb-4">
                                <div class="mb-1">
                                    <p class="text-sm font-semibold text-indigo-600" x-text="`${campaignSetupMode === 'fast' ? 'Fast Setup' : 'Advanced Setup'} · Step ${campaignSetupStepIndex('source') + 1} of ${campaignSetupStepsForMode().length}`"></p>
                                    <h2 class="mt-2 text-2xl font-bold leading-8 tracking-tight text-gray-950" x-text="campaignSetupHeading('source')"></h2>
                                    <p class="mt-2 max-w-3xl text-sm leading-6 text-gray-600" x-text="campaignSetupDescription('source')"></p>
                                </div>
                                <template x-for="group in leadSourceGroups" :key="group.label">
                                    <div>
                                        <h3 class="text-sm font-semibold uppercase tracking-wide text-gray-400" x-text="group.label"></h3>
                                        <div class="mt-4 grid gap-4 md:grid-cols-2">
                                            <template x-for="source in group.items" :key="source.name">
                                                <button type="button" x-on:click="selectLeadSource(source.name)" class="flex h-full flex-col items-start rounded-lg bg-white p-5 text-left shadow-sm outline outline-1 -outline-offset-1 transition hover:outline-2 hover:-outline-offset-2 hover:outline-indigo-600 hover:shadow-sm focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600" :class="campaignSetup.source === source.name ? 'outline-2 -outline-offset-2 outline-indigo-600' : 'outline-gray-300'">
                                                    <span class="block text-sm font-bold text-gray-950" x-text="source.name"></span>
                                                    <span class="mt-2 block text-sm leading-6 text-gray-500" x-text="source.description"></span>
                                                    <span x-show="source.requiresIntegration" class="mt-4 inline-flex rounded-md bg-blue-50 px-2 py-1 text-xs font-medium text-blue-700 ring-1 ring-inset ring-blue-700/10">Integration Needed for Launch</span>
                                                </button>
                                            </template>
                                        </div>
                                    </div>
                                </template>
                            </section>

                            <section x-cloak x-show="campaignSetup.current === 'integration' || campaignSetupScrollFromStep === 'integration'" x-ref="campaignSetupStep_integration"
                                :style="campaignSetupStepStyle('integration')"
                                data-campaign-setup-step
                                class="space-y-6 pr-2 pb-4">
                                <div class="mb-1">
                                    <p class="text-sm font-semibold text-indigo-600" x-text="`${campaignSetupMode === 'fast' ? 'Fast Setup' : 'Advanced Setup'} · Step ${campaignSetupStepIndex('integration') + 1} of ${campaignSetupStepsForMode().length}`"></p>
                                    <h2 class="mt-2 text-2xl font-bold leading-8 tracking-tight text-gray-950" x-text="campaignSetupHeading('integration')"></h2>
                                    <p class="mt-2 max-w-3xl text-sm leading-6 text-gray-600" x-text="campaignSetupDescription('integration')"></p>
                                </div>
                                <template x-if="campaignSetup.source === 'CSV File / Manual'">
                                    <div class="rounded-lg border border-green-200 bg-green-50 p-5">
                                        <h3 class="text-sm font-bold text-green-900">No Integration Required</h3>
                                        <p class="mt-2 text-sm leading-6 text-green-700">Upload a CSV placeholder or create a test lead now. You can import real leads later.</p>
                                        <div class="mt-5 grid gap-4 sm:grid-cols-2">
                                            <input type="text" value="leads.csv" class="rounded-md border-0 px-3 py-2 text-sm ring-1 ring-inset ring-green-200">
                                            <button type="button" class="inline-flex h-9 items-center justify-center rounded-md bg-white px-3 text-sm font-semibold text-green-700 ring-1 ring-inset ring-green-600">Create Test Lead</button>
                                        </div>
                                    </div>
                                </template>
                                <template x-if="campaignSetup.source !== 'CSV File / Manual'">
                                    <div class="rounded-lg border border-gray-200 p-5">
                                        <div class="flex flex-wrap items-start justify-between gap-4">
                                            <div>
                                                <h3 class="text-base font-bold text-gray-950" x-text="`Connect ${campaignSetup.source || 'Lead Source'} Account`"></h3>
                                                <p class="mt-2 max-w-2xl text-sm leading-6 text-gray-500" x-text="`Connect ${campaignSetup.source || 'your source'} to use contacts, events, customer properties, and merge tags.`"></p>
                                            </div>
                                        <span class="inline-flex rounded-md px-2 py-1 text-xs font-medium ring-1 ring-inset" :class="campaignSetup.integrationStatus === 'Connected' ? 'bg-green-50 text-green-700 ring-green-600/20' : campaignSetup.integrationStatus === 'Skipped for Now' ? 'bg-amber-50 text-amber-700 ring-amber-600/20' : 'bg-gray-50 text-gray-700 ring-gray-600/20'" x-text="campaignSetup.integrationStatus"></span>
                                        </div>
                                        <div class="mt-6 flex flex-wrap gap-3">
                                            <button type="button" x-on:click="connectCampaignSource()" class="inline-flex h-9 items-center rounded-md bg-indigo-600 px-3 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-500" x-text="`Connect ${campaignSetup.source || 'Source'}`"></button>
                                            <button type="button" x-on:click="skipCampaignIntegration()" class="inline-flex h-9 items-center rounded-md bg-white px-3 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 transition hover:bg-gray-50">Setup Later</button>
                                        </div>
                                        <p class="mt-4 text-sm leading-6 text-gray-500">If you choose Setup later, campaign setup will not have access to custom fields or merge tags coming from the lead source. Those fields help the AI agent personalize the conversation more effectively.</p>
                                    </div>
                                </template>
                            </section>

                            <section x-cloak x-show="campaignSetup.current === 'brief' || campaignSetupScrollFromStep === 'brief'" x-ref="campaignSetupStep_brief"
                                :style="campaignSetupStepStyle('brief')"
                                data-campaign-setup-step
                                class="pr-2 pb-4">
                                <div class="mb-1">
                                    <p class="text-sm font-semibold text-indigo-600" x-text="`${campaignSetupMode === 'fast' ? 'Fast Setup' : 'Advanced Setup'} · Step ${campaignSetupStepIndex('brief') + 1} of ${campaignSetupStepsForMode().length}`"></p>
                                    <h2 class="mt-2 text-2xl font-bold leading-8 tracking-tight text-gray-950" x-text="campaignSetupHeading('brief')"></h2>
                                    <p class="mt-2 max-w-3xl text-sm leading-6 text-gray-600" x-text="campaignSetupDescription('brief')"></p>
                                </div>
                                <div class="mb-6 border-b border-gray-200">
                                    <nav class="-mb-px flex gap-6" aria-label="Campaign context tabs">
                                        <button type="button" x-on:click="campaignSetup.briefTab = 'context'; scheduleCampaignBuilderLayoutUpdate()" class="border-b-2 px-1 pb-3 text-sm font-semibold transition" :class="campaignSetup.briefTab === 'context' ? 'border-indigo-600 text-indigo-600' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700'">Original</button>
                                        <button type="button" x-on:click="campaignSetup.briefTab = 'discovery'; scheduleCampaignBuilderLayoutUpdate()" class="border-b-2 px-1 pb-3 text-sm font-semibold transition" :class="campaignSetup.briefTab === 'discovery' ? 'border-indigo-600 text-indigo-600' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700'">Option Two</button>
                                    </nav>
                                </div>
                                <div x-show="campaignSetup.briefTab === 'context'" class="space-y-7">
                                        <div>
                                            <div class="mb-2 flex items-center justify-between gap-3">
                                                <label class="block text-sm/6 font-semibold text-gray-900">Campaign Context & Instructions<span class="text-indigo-600">*</span></label>
                                                <div class="flex items-center gap-1">
                                                    <div class="relative" x-data="{ contextActionsOpen: false }" x-on:click.outside="contextActionsOpen = false">
                                                        <button type="button" x-on:click="contextActionsOpen = ! contextActionsOpen" class="inline-flex size-7 items-center justify-center rounded-md text-gray-400 transition hover:bg-gray-50 hover:text-gray-700" aria-label="Campaign context actions">
                                                            <span class="outcraft-icon !text-[18px]">more_vert</span>
                                                        </button>
                                                        <div x-cloak x-show="contextActionsOpen" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-3" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-2" class="absolute right-0 z-40 mt-2 w-48 rounded-md bg-white py-1 shadow-lg ring-1 ring-gray-900/10">
                                                            <button type="button" x-on:click="openCampaignCustomFields(); contextActionsOpen = false" class="flex w-full items-center gap-2 px-3 py-2 text-left text-sm font-medium text-gray-700 transition hover:bg-gray-50 hover:text-gray-950">
                                                                <span class="text-xs text-gray-400">{+}</span>
                                                                Open Custom Fields
                                                            </button>
	                                                            <button type="button" x-on:click="contextActionsOpen = false" class="flex w-full items-center gap-2 px-3 py-2 text-left text-sm font-medium text-gray-700 transition hover:bg-gray-50 hover:text-gray-950">
	                                                                <span class="outcraft-icon !text-[15px] text-gray-400">settings</span>
	                                                                Configure Custom Fields
	                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div data-component="custom-field-text-input" class="overflow-hidden rounded-lg border border-gray-300 bg-white shadow-sm transition focus-within:border-indigo-600 focus-within:ring-1 focus-within:ring-indigo-600">
                                                <div class="relative grid min-w-0 overflow-hidden transition-[grid-template-columns] duration-200 ease-out" :class="campaignSetup.customFieldsLayoutOpen ? 'lg:grid-cols-[minmax(0,1fr)_285px]' : 'lg:grid-cols-1'">
                                                    <textarea
                                                        x-model="campaignSetup.brief.context"
                                                        rows="4"
                                                        placeholder="Describe the campaign situation, goal, and how the agent should behave."
                                                        class="block min-h-[112px] min-w-0 w-full resize-y border-0 bg-white px-3 py-2 text-sm/6 text-gray-700 outline-none placeholder:text-gray-400 focus:ring-0"
                                                    ></textarea>
                                                    <aside
                                                        x-cloak
                                                        x-show="campaignSetup.customFieldsOpen"
                                                        x-transition:enter="transition ease-out duration-200"
                                                        x-transition:enter-start="translate-x-full opacity-0"
                                                        x-transition:enter-end="translate-x-0 opacity-100"
                                                        x-transition:leave="transition ease-in duration-150"
                                                        x-transition:leave-start="translate-x-0 opacity-100"
                                                        x-transition:leave-end="translate-x-full opacity-0"
                                                        class="border-t border-gray-200 bg-white lg:border-t-0 lg:border-l"
                                                    >
                                                        <div class="flex items-center gap-2 border-b border-gray-200 px-4 py-3">
                                                            <label class="min-w-0 flex-1">
                                                                <input x-model="campaignSetup.customFieldSearch" type="search" placeholder="Search Custom Fields" class="block h-9 w-full rounded-md bg-white px-3 py-1.5 text-sm text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600">
                                                            </label>
                                                            <button type="button" x-on:click="closeCampaignCustomFields()" class="inline-flex size-7 items-center justify-center rounded-md text-gray-400 transition hover:bg-white hover:text-gray-700" aria-label="Close custom fields">
                                                                <span class="outcraft-icon !text-[18px]">close</span>
                                                            </button>
                                                        </div>
                                                        <div class="flex flex-wrap gap-2 px-4 py-4">
                                                            <template x-for="tag in filteredCustomFields()" :key="tag">
                                                                <button type="button" class="inline-flex h-8 items-center rounded-md bg-white px-2.5 text-sm font-medium text-gray-600 shadow-sm ring-1 ring-inset ring-gray-200 transition hover:bg-gray-50 hover:text-gray-900" x-text="tag"></button>
                                                            </template>
                                                            <p x-show="filteredCustomFields().length === 0" class="text-sm text-gray-500">No Custom Fields Found.</p>
                                                        </div>
                                                    </aside>
                                                </div>
                                            </div>
                                            <p class="mt-2 text-sm leading-6 text-gray-500">Describe the situation, goal, and how the agent should behave (incl. edge cases).</p>
                                        </div>

                                        <div>
                                            <div class="mb-2 flex items-center justify-between gap-3">
                                                <label class="block text-sm/6 font-semibold text-gray-900">Qualification Questions<span class="text-indigo-600">*</span></label>
                                            </div>
                                            <textarea x-model="campaignSetup.brief.qualificationQuestions" rows="4" class="block w-full rounded-md bg-white px-3 py-2 text-sm/6 text-gray-700 shadow-sm outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600"></textarea>
                                            <p class="mt-2 text-sm leading-6 text-gray-500">List the key questions the AI should ask to determine whether the lead is a good fit for the offer.</p>
                                        </div>

                                        <div>
                                            <div class="mb-2 flex items-center justify-between gap-3">
                                                <label class="block text-sm/6 font-semibold text-gray-900">What Answers Confirm Qualification?<span class="text-indigo-600">*</span></label>
                                            </div>
                                            <textarea x-model="campaignSetup.brief.qualifiedAnswers" rows="4" class="block w-full rounded-md bg-white px-3 py-2 text-sm/6 text-gray-700 shadow-sm outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600"></textarea>
                                            <p class="mt-2 text-sm leading-6 text-gray-500">If the lead meets these answers, they are considered qualified.</p>
                                        </div>
                                </div>
                                <div x-show="campaignSetup.briefTab === 'discovery'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-3" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-2" class="space-y-7">
                                    <div>
                                        <div class="mb-2 flex items-center justify-between gap-3">
                                            <label class="block text-sm/6 font-semibold text-gray-900">Campaign Goal</label>
                                            <span class="relative" x-data="{ fieldActionsOpen: false }" x-on:click.outside="fieldActionsOpen = false">
                                                <button type="button" x-on:click="fieldActionsOpen = ! fieldActionsOpen" class="inline-flex size-7 items-center justify-center rounded-md text-gray-400 transition hover:bg-gray-50 hover:text-gray-700" aria-label="Campaign goal custom field actions">
                                                    <span class="outcraft-icon !text-[18px]">more_vert</span>
                                                </button>
                                                <span x-cloak x-show="fieldActionsOpen" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-3" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-2" class="absolute right-0 z-40 mt-2 w-52 rounded-md bg-white py-1 shadow-lg ring-1 ring-gray-900/10">
                                                    <button type="button" x-on:click="openCustomFieldTextInput('briefGoal'); fieldActionsOpen = false" class="flex w-full items-center gap-2 px-3 py-2 text-left text-sm font-medium text-gray-700 transition hover:bg-gray-50 hover:text-gray-950"><span class="text-xs text-gray-400">{+}</span>Open Custom Fields</button>
                                                    <button type="button" x-on:click="fieldActionsOpen = false" class="flex w-full items-center gap-2 px-3 py-2 text-left text-sm font-medium text-gray-700 transition hover:bg-gray-50 hover:text-gray-950"><span class="outcraft-icon !text-[15px] text-gray-400">settings</span>Configure Custom Fields</button>
                                                </span>
                                            </span>
                                        </div>
                                        <div data-component="custom-field-text-input" class="overflow-hidden rounded-lg border border-gray-300 bg-white shadow-sm transition focus-within:border-indigo-600 focus-within:ring-1 focus-within:ring-indigo-600">
                                            <div class="relative grid min-w-0 overflow-hidden transition-[grid-template-columns] duration-200 ease-out" :class="customFieldTextInputState('briefGoal').layoutOpen ? 'lg:grid-cols-[minmax(0,1fr)_18rem]' : 'lg:grid-cols-1'">
                                                <textarea x-model="campaignSetup.brief.goal" rows="4" class="block min-h-[112px] min-w-0 w-full resize-y border-0 bg-white px-3 py-2 text-sm/6 text-gray-700 outline-none placeholder:text-gray-400 focus:ring-0"></textarea>
                                                <aside x-cloak x-show="customFieldTextInputState('briefGoal').open" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="translate-x-full opacity-0" x-transition:enter-end="translate-x-0 opacity-100" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="translate-x-0 opacity-100" x-transition:leave-end="translate-x-full opacity-0" class="min-w-0 border-t border-gray-200 bg-white lg:border-t-0 lg:border-l lg:border-gray-200">
                                                    <div class="flex items-center gap-2 border-b border-gray-200 px-4 py-3"><label class="min-w-0 flex-1"><input :value="customFieldTextInputState('briefGoal').search" x-on:input="customFieldTextInputState('briefGoal').search = $event.target.value" type="search" placeholder="Search Custom Fields" class="block h-9 w-full rounded-md bg-white px-3 py-1.5 text-sm text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600"></label><button type="button" x-on:click="closeCustomFieldTextInput('briefGoal')" class="inline-flex size-7 items-center justify-center rounded-md text-gray-400 transition hover:bg-white hover:text-gray-700" aria-label="Close custom fields"><span class="outcraft-icon !text-[18px]">close</span></button></div>
                                                    <div class="flex flex-wrap gap-2 px-4 py-4"><template x-for="tag in filteredCustomFieldTextInputTags('briefGoal')" :key="`brief-goal-${tag}`"><button type="button" class="inline-flex h-8 items-center rounded-md bg-white px-2.5 text-sm font-medium text-gray-600 shadow-sm ring-1 ring-inset ring-gray-200 transition hover:bg-gray-50 hover:text-gray-900" x-text="tag"></button></template><p x-show="filteredCustomFieldTextInputTags('briefGoal').length === 0" class="text-sm text-gray-500">No Custom Fields Found.</p></div>
                                                </aside>
                                            </div>
                                        </div>
                                        <p class="mt-2 text-sm leading-6 text-gray-500">What should this campaign achieve?</p>
                                    </div>

                                    <div>
                                        <div class="mb-2 flex items-center justify-between gap-3">
                                            <label class="block text-sm/6 font-semibold text-gray-900">Lead Situation</label>
                                            <span class="relative" x-data="{ fieldActionsOpen: false }" x-on:click.outside="fieldActionsOpen = false">
                                                <button type="button" x-on:click="fieldActionsOpen = ! fieldActionsOpen" class="inline-flex size-7 items-center justify-center rounded-md text-gray-400 transition hover:bg-gray-50 hover:text-gray-700" aria-label="Lead situation custom field actions"><span class="outcraft-icon !text-[18px]">more_vert</span></button>
                                                <span x-cloak x-show="fieldActionsOpen" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-3" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-2" class="absolute right-0 z-40 mt-2 w-52 rounded-md bg-white py-1 shadow-lg ring-1 ring-gray-900/10">
                                                    <button type="button" x-on:click="openCustomFieldTextInput('leadSituation'); fieldActionsOpen = false" class="flex w-full items-center gap-2 px-3 py-2 text-left text-sm font-medium text-gray-700 transition hover:bg-gray-50 hover:text-gray-950"><span class="text-xs text-gray-400">{+}</span>Open Custom Fields</button>
                                                    <button type="button" x-on:click="fieldActionsOpen = false" class="flex w-full items-center gap-2 px-3 py-2 text-left text-sm font-medium text-gray-700 transition hover:bg-gray-50 hover:text-gray-950"><span class="outcraft-icon !text-[15px] text-gray-400">settings</span>Configure Custom Fields</button>
                                                </span>
                                            </span>
                                        </div>
                                        <div data-component="custom-field-text-input" class="overflow-hidden rounded-lg border border-gray-300 bg-white shadow-sm transition focus-within:border-indigo-600 focus-within:ring-1 focus-within:ring-indigo-600">
                                            <div class="relative grid min-w-0 overflow-hidden transition-[grid-template-columns] duration-200 ease-out" :class="customFieldTextInputState('leadSituation').layoutOpen ? 'lg:grid-cols-[minmax(0,1fr)_18rem]' : 'lg:grid-cols-1'">
                                                <textarea x-model="campaignSetup.brief.leadSituation" rows="4" class="block min-h-[112px] min-w-0 w-full resize-y border-0 bg-white px-3 py-2 text-sm/6 text-gray-700 outline-none placeholder:text-gray-400 focus:ring-0"></textarea>
                                                <aside x-cloak x-show="customFieldTextInputState('leadSituation').open" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="translate-x-full opacity-0" x-transition:enter-end="translate-x-0 opacity-100" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="translate-x-0 opacity-100" x-transition:leave-end="translate-x-full opacity-0" class="min-w-0 border-t border-gray-200 bg-white lg:border-t-0 lg:border-l lg:border-gray-200">
                                                    <div class="flex items-center gap-2 border-b border-gray-200 px-4 py-3"><label class="min-w-0 flex-1"><input :value="customFieldTextInputState('leadSituation').search" x-on:input="customFieldTextInputState('leadSituation').search = $event.target.value" type="search" placeholder="Search Custom Fields" class="block h-9 w-full rounded-md bg-white px-3 py-1.5 text-sm text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600"></label><button type="button" x-on:click="closeCustomFieldTextInput('leadSituation')" class="inline-flex size-7 items-center justify-center rounded-md text-gray-400 transition hover:bg-white hover:text-gray-700" aria-label="Close custom fields"><span class="outcraft-icon !text-[18px]">close</span></button></div>
                                                    <div class="flex flex-wrap gap-2 px-4 py-4"><template x-for="tag in filteredCustomFieldTextInputTags('leadSituation')" :key="`lead-situation-${tag}`"><button type="button" class="inline-flex h-8 items-center rounded-md bg-white px-2.5 text-sm font-medium text-gray-600 shadow-sm ring-1 ring-inset ring-gray-200 transition hover:bg-gray-50 hover:text-gray-900" x-text="tag"></button></template><p x-show="filteredCustomFieldTextInputTags('leadSituation').length === 0" class="text-sm text-gray-500">No Custom Fields Found.</p></div>
                                                </aside>
                                            </div>
                                        </div>
                                        <p class="mt-2 text-sm leading-6 text-gray-500">Who are these leads and why are we contacting them?</p>
                                    </div>

                                    <label class="block">
                                        <span class="block text-sm/6 font-semibold text-gray-900">What Should AI Find Out?</span>
                                        <textarea x-model="campaignSetup.brief.findOut" rows="4" class="mt-2 block w-full rounded-md bg-white px-3 py-2 text-sm/6 text-gray-700 shadow-sm outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600"></textarea>
                                        <span class="mt-2 block text-sm leading-6 text-gray-500">List the key questions or information AI should collect.</span>
                                    </label>
                                    <label class="block">
                                        <span class="block text-sm/6 font-semibold text-gray-900">What Should AI Offer or Do Next?</span>
                                        <textarea x-model="campaignSetup.brief.nextStep" rows="4" class="mt-2 block w-full rounded-md bg-white px-3 py-2 text-sm/6 text-gray-700 shadow-sm outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600"></textarea>
                                        <span class="mt-2 block text-sm leading-6 text-gray-500">Describe the desired next step, handoff, resource, or action.</span>
                                    </label>
                                    <label class="block">
                                        <span class="block text-sm/6 font-semibold text-gray-900">Important Rules</span>
                                        <textarea x-model="campaignSetup.brief.importantRules" rows="4" class="mt-2 block w-full rounded-md bg-white px-3 py-2 text-sm/6 text-gray-700 shadow-sm outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600"></textarea>
                                        <span class="mt-2 block text-sm leading-6 text-gray-500">Add anything AI must avoid, skip, disclose, or handle carefully.</span>
                                    </label>

                                    <div class="rounded-lg border border-gray-200 bg-white p-5">
                                        <button type="button" x-on:click="campaignSetup.needsQualification = ! campaignSetup.needsQualification; scheduleCampaignBuilderLayoutUpdate()" role="switch" :aria-checked="campaignSetup.needsQualification" class="flex w-full items-start gap-4 rounded-md text-left focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                                            <span class="relative mt-1 inline-flex h-6 w-11 shrink-0 rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out" :class="campaignSetup.needsQualification ? 'bg-indigo-600' : 'bg-gray-200'"><span class="pointer-events-none inline-block size-5 rounded-full bg-white shadow transition duration-200 ease-in-out" :class="campaignSetup.needsQualification ? 'translate-x-5' : 'translate-x-0'"></span></span>
                                            <span><span class="block text-sm font-semibold leading-6 text-gray-950">Enable Qualification</span><span class="mt-1 block text-sm leading-6 text-gray-600">Turn this on if the AI needs to qualify the lead before moving to the next step.</span></span>
                                        </button>
                                        <div x-show="campaignSetup.needsQualification" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-3" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-2" class="mt-6 space-y-6">
                                            <label class="block"><span class="block text-sm/6 font-semibold text-gray-900">Qualification Questions</span><textarea x-model="campaignSetup.brief.qualificationQuestions" rows="4" class="mt-2 block w-full rounded-md bg-white px-3 py-2 text-sm/6 text-gray-700 shadow-sm outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600"></textarea></label>
                                            <label class="block"><span class="block text-sm/6 font-semibold text-gray-900">Qualification Answers</span><textarea x-model="campaignSetup.brief.qualifiedAnswers" rows="4" class="mt-2 block w-full rounded-md bg-white px-3 py-2 text-sm/6 text-gray-700 shadow-sm outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600"></textarea></label>
                                        </div>
                                    </div>
                            </section>

	                            <section x-cloak x-show="campaignSetup.current === 'general' || campaignSetupScrollFromStep === 'general'" x-ref="campaignSetupStep_general"
                                :style="campaignSetupStepStyle('general')"
                                data-campaign-setup-step
                                class="pr-2 pb-4">
                                <div class="mb-1">
                                    <p class="text-sm font-semibold text-indigo-600" x-text="`${campaignSetupMode === 'fast' ? 'Fast Setup' : 'Advanced Setup'} · Step ${campaignSetupStepIndex('general') + 1} of ${campaignSetupStepsForMode().length}`"></p>
                                    <h2 class="mt-2 text-2xl font-bold leading-8 tracking-tight text-gray-950" x-text="campaignSetupHeading('general')"></h2>
                                    <p class="mt-2 max-w-3xl text-sm leading-6 text-gray-600" x-text="campaignSetupDescription('general')"></p>
                                </div>
	                                <div class="overflow-hidden rounded-lg bg-white shadow-sm ring-1 ring-gray-200">
	                                    <div class="border-b border-gray-200 px-6 py-5">
	                                        <h3 class="text-base font-semibold text-gray-950">General Settings</h3>
	                                    </div>
	                                    <div class="space-y-8 px-6 py-7">
	                                        <fieldset class="rounded-lg border border-gray-200 px-6 pb-6 pt-5">
	                                            <legend class="px-2 text-sm font-semibold text-gray-900">Sendable Resources</legend>
	                                            <div class="space-y-6">
		                                                <button type="button" x-on:click="campaignSetup.shortenLinks = ! campaignSetup.shortenLinks" role="switch" :aria-checked="campaignSetup.shortenLinks" class="flex w-full items-start gap-4 rounded-md text-left focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
		                                                    <span class="relative mt-1 inline-flex h-6 w-11 shrink-0 rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out" :class="campaignSetup.shortenLinks ? 'bg-indigo-600' : 'bg-gray-200'">
		                                                        <span class="pointer-events-none inline-block size-5 rounded-full bg-white shadow transition duration-200 ease-in-out" :class="campaignSetup.shortenLinks ? 'translate-x-5' : 'translate-x-0'"></span>
		                                                    </span>
	                                                    <span>
	                                                        <span class="block text-sm font-semibold leading-6 text-gray-950">Should Shorten Links in Messages?</span>
	                                                        <span class="mt-1 block text-sm leading-6 text-gray-600">If enabled, any links the AI includes in emails will be shortened using the built-in link shortener.</span>
	                                                    </span>
	                                                </button>
	                                                <label class="block">
	                                                    <span class="block text-sm/6 font-semibold text-gray-900">Brand to Include in Shortened Links (optional)</span>
	                                                    <input x-model="campaignSetup.shortLinkBrand" :disabled="! campaignSetup.shortenLinks" type="text" placeholder="warmy" class="mt-2 block w-full rounded-md bg-white px-3 py-1.5 text-sm/6 text-gray-900 shadow-sm outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 disabled:bg-gray-50 disabled:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600">
	                                                    <span class="mt-2 block text-sm leading-6 text-gray-600">Will resolve to https://outcraft.ai/l/@{{brand}}-a1b2c3d4, otherwise will default to random string</span>
	                                                </label>
	                                            </div>
	                                        </fieldset>

	                                    </div>
	                                </div>
	                            </section>

	                            <section x-cloak x-show="campaignSetup.current === 'resources' || campaignSetupScrollFromStep === 'resources'" x-ref="campaignSetupStep_resources"
                                :style="campaignSetupStepStyle('resources')"
                                data-campaign-setup-step
                                class="space-y-6 pr-2 pb-4">
                                <div class="mb-1">
                                    <p class="text-sm font-semibold text-indigo-600" x-text="`${campaignSetupMode === 'fast' ? 'Fast Setup' : 'Advanced Setup'} · Step ${campaignSetupStepIndex('resources') + 1} of ${campaignSetupStepsForMode().length}`"></p>
                                    <h2 class="mt-2 text-2xl font-bold leading-8 tracking-tight text-gray-950" x-text="campaignSetupHeading('resources')"></h2>
                                    <p class="mt-2 max-w-3xl text-sm leading-6 text-gray-600" x-text="campaignSetupDescription('resources')"></p>
                                </div>
                                <div class="grid gap-4 sm:grid-cols-2">
                                    <button type="button" x-on:click="campaignSetup.discountCode = ! campaignSetup.discountCode" class="flex items-start justify-between gap-4 rounded-lg border border-gray-200 p-4 text-left"><span><span class="block text-sm font-medium text-gray-900">Send a Discount Code After the Offer Is Accepted?</span><span class="mt-1 block text-sm leading-6 text-gray-500">If enabled, the AI will attach a discount code when messaging leads.</span></span><span class="relative inline-flex h-6 w-11 rounded-full p-0.5" :class="campaignSetup.discountCode ? 'bg-indigo-600' : 'bg-gray-200'"><span class="size-5 rounded-full bg-white shadow-sm transition" :class="campaignSetup.discountCode ? 'translate-x-5' : 'translate-x-0'"></span></span></button>
                                    <button type="button" x-on:click="campaignSetup.shortenLinks = ! campaignSetup.shortenLinks" class="flex items-start justify-between gap-4 rounded-lg border border-gray-200 p-4 text-left"><span><span class="block text-sm font-medium text-gray-900">Should Shorten Links in Messages?</span><span class="mt-1 block text-sm leading-6 text-gray-500">If enabled, links included in email or SMS will use the built-in link shortener.</span></span><span class="relative inline-flex h-6 w-11 rounded-full p-0.5" :class="campaignSetup.shortenLinks ? 'bg-indigo-600' : 'bg-gray-200'"><span class="size-5 rounded-full bg-white shadow-sm transition" :class="campaignSetup.shortenLinks ? 'translate-x-5' : 'translate-x-0'"></span></span></button>
                                </div>
                                <div class="grid gap-5 sm:grid-cols-2">
                                    <label class="block"><span class="block text-sm/6 font-medium text-gray-900">Brand to Include in Shortened Links</span><input x-model="campaignSetup.shortLinkBrand" :disabled="! campaignSetup.shortenLinks" type="text" placeholder="warmy" class="mt-2 block w-full rounded-md px-3 py-1.5 text-sm/6 outline outline-1 -outline-offset-1 outline-gray-300 disabled:bg-gray-50 disabled:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600"><span class="mt-2 block text-sm leading-6 text-gray-500">Will resolve to https://outcraft.ai/@{{brand}}-a1b2c3d4. Otherwise a random string will be used.</span></label>
                                    <label class="block"><span class="block text-sm/6 font-medium text-gray-900">Additional Info to Send After the Offer Is Accepted</span><textarea x-model="campaignSetup.offerInfo" rows="5" placeholder="Example: Mention the package usually arrives in 14 days." class="mt-2 block w-full rounded-md px-3 py-1.5 text-sm/6 outline outline-1 -outline-offset-1 outline-gray-300 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600"></textarea></label>
                                </div>
                            </section>

                            <section x-cloak x-show="campaignSetup.current === 'agent' || campaignSetupScrollFromStep === 'agent'" x-ref="campaignSetupStep_agent"
                                :style="campaignSetupStepStyle('agent')"
                                data-campaign-setup-step
                                class="space-y-6 pr-2 pb-4">
                                <div class="mb-1">
                                    <p class="text-sm font-semibold text-indigo-600" x-text="`${campaignSetupMode === 'fast' ? 'Fast Setup' : 'Advanced Setup'} · Step ${campaignSetupStepIndex('agent') + 1} of ${campaignSetupStepsForMode().length}`"></p>
                                    <h2 class="mt-2 text-2xl font-bold leading-8 tracking-tight text-gray-950" x-text="campaignSetupHeading('agent')"></h2>
                                    <p class="mt-2 max-w-3xl text-sm leading-6 text-gray-600" x-text="campaignSetupDescription('agent')"></p>

                                    <div class="mt-10 overflow-visible rounded-lg border border-gray-200 bg-white">
                                        <div>
                                            <template x-for="language in campaignSetup.languages" :key="language.code">
                                                <div
                                                    class="flex w-full items-center justify-between gap-4 px-4 py-3 transition hover:bg-gray-50"
                                                    :class="[
                                                        'bg-white',
                                                        campaignSetup.languages[0]?.code === language.code ? 'rounded-t-lg' : '',
                                                        campaignSetup.languages[0]?.code !== language.code ? 'border-t border-gray-200' : '',
                                                    ]"
                                                >
                                                    <button
                                                        type="button"
                                                        x-on:click="selectCampaignSetupLanguage(language.code)"
                                                        class="flex min-w-0 flex-1 items-center gap-3 text-left focus:outline-none"
                                                    >
                                                        <span class="inline-flex size-5 shrink-0 overflow-hidden rounded-full ring-1 ring-gray-200">
                                                            <img :src="campaignSetupFlagUrl(language)" :alt="`${language.name || language.label} flag`" class="size-full object-cover" loading="lazy">
                                                        </span>
                                                        <span class="min-w-0">
                                                            <span class="block truncate text-sm font-semibold leading-6 text-gray-950" x-text="language.name || language.label"></span>
                                                            <span class="block text-sm leading-5 text-gray-500" x-text="language.label"></span>
                                                        </span>
                                                    </button>
                                                    <span x-show="campaignSetup.defaultLanguage === language.code" class="shrink-0 rounded-md bg-indigo-50 px-2 py-1 text-xs font-medium text-indigo-700 ring-1 ring-inset ring-indigo-200">Default</span>
                                                </div>
                                            </template>

                                            <div class="relative border-t border-gray-200" x-on:click.outside="campaignSetup.languageMenuOpen = false">
                                                <button
                                                    type="button"
                                                    x-on:click="campaignSetup.languageMenuOpen = ! campaignSetup.languageMenuOpen; campaignSetup.languageSearch = ''; $nextTick(() => $refs.campaignLanguageSearch?.focus())"
                                                    :disabled="campaignSetup.languages.length >= campaignSetupLanguageOptions.length"
                                                    class="flex w-full items-center gap-3 rounded-b-lg px-4 py-3 text-left text-sm font-semibold text-gray-700 transition hover:bg-gray-50 focus:outline-none focus-visible:outline-2 focus-visible:-outline-offset-2 focus-visible:outline-indigo-600 disabled:cursor-not-allowed disabled:opacity-40"
                                                >
                                                    <span class="flex size-8 shrink-0 items-center justify-center rounded-md bg-indigo-50 text-indigo-600">
                                                        <span class="outcraft-icon !text-[16px]">add</span>
                                                    </span>
                                                    Add Language
                                                </button>

                                                <div
                                                    x-cloak
                                                    x-show="campaignSetup.languageMenuOpen"
                                                    x-transition:enter="transition ease-out duration-200"
                                                    x-transition:enter-start="opacity-0 translate-y-3"
                                                    x-transition:enter-end="opacity-100 translate-y-0"
                                                    x-transition:leave="transition ease-in duration-150"
                                                    x-transition:leave-start="opacity-100 translate-y-0"
                                                    x-transition:leave-end="opacity-0 translate-y-2"
                                                    class="absolute left-4 right-4 top-full z-40 mt-2 overflow-hidden rounded-lg bg-white shadow-lg ring-1 ring-gray-900/10"
                                                >
                                                    <div class="border-b border-gray-200 p-3">
                                                        <input x-ref="campaignLanguageSearch" x-model="campaignSetup.languageSearch" type="search" placeholder="Search Languages" class="block h-9 w-full rounded-md bg-white px-3 py-1.5 text-sm text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600">
                                                    </div>
                                                    <div class="max-h-60 overflow-y-auto py-1">
                                                        <template x-for="language in filteredCampaignSetupLanguageOptions()" :key="language.code">
                                                            <button type="button" x-on:click="addCampaignSetupLanguage(language.code)" class="flex w-full items-center gap-3 px-3 py-2 text-left transition hover:bg-indigo-50">
                                                                <span class="inline-flex size-5 shrink-0 overflow-hidden rounded-full ring-1 ring-gray-200">
                                                                    <img :src="campaignSetupFlagUrl(language)" :alt="`${language.name} flag`" class="size-full object-cover" loading="lazy">
                                                                </span>
                                                                <span class="min-w-0">
                                                                    <span class="block truncate text-sm font-semibold leading-6 text-gray-950" x-text="language.name"></span>
                                                                    <span class="block text-sm leading-5 text-gray-500" x-text="language.label"></span>
                                                                </span>
                                                            </button>
                                                        </template>
                                                        <p x-show="filteredCampaignSetupLanguageOptions().length === 0" class="px-3 py-3 text-sm text-gray-500">No Languages Found.</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="space-y-6">
                                <div class="flex items-center justify-between gap-4">
                                    <div class="flex min-w-0 items-center gap-3">
                                        <span class="inline-flex size-5 shrink-0 overflow-hidden rounded-full ring-1 ring-gray-200">
                                            <img :src="campaignSetupFlagUrl(campaignSetupActiveLanguage())" :alt="`${campaignSetupActiveLanguage().name || campaignSetupActiveLanguage().label} flag`" class="size-full object-cover" loading="lazy">
                                        </span>
                                        <span class="min-w-0 truncate text-base font-semibold leading-6 text-gray-950" x-text="`Editing ${campaignSetupActiveLanguage().name || campaignSetupActiveLanguage().label} Agent`"></span>
                                    </div>
                                    <span x-show="campaignSetup.defaultLanguage === campaignSetup.activeLanguage" class="shrink-0 rounded-md bg-indigo-50 px-2 py-1 text-xs font-medium text-indigo-700 ring-1 ring-inset ring-indigo-200">Default</span>
                                    <button x-show="campaignSetup.defaultLanguage !== campaignSetup.activeLanguage" type="button" x-on:click="setCampaignSetupDefaultLanguage(campaignSetup.activeLanguage)" class="shrink-0 text-sm font-semibold text-indigo-600 transition hover:text-indigo-500 focus:outline-none focus-visible:rounded focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Set as Default</button>
                                </div>
                                <div class="grid gap-6 lg:grid-cols-2">
                                    <label class="block">
                                        <span class="block text-sm/6 font-semibold text-gray-900">Agent Name<span class="text-indigo-600">*</span></span>
                                        <input x-model="campaignSetup.agentName" type="text" class="mt-2 block w-full rounded-md bg-white px-3 py-1.5 text-sm/6 text-gray-900 shadow-sm outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600">
                                        <span class="mt-2 block text-sm leading-6 text-gray-600">How the AI assistant will introduce itself to leads.</span>
                                    </label>

                                    <label class="block">
                                        <span class="block text-sm/6 font-semibold text-gray-900">Voice<span class="text-indigo-600">*</span></span>
                                        <div class="mt-2 grid grid-cols-1">
                                            <select x-model="campaignSetup.voice" class="col-start-1 row-start-1 block w-full appearance-none rounded-md bg-white py-1.5 pr-8 pl-3 text-sm/6 text-gray-900 shadow-sm outline outline-1 -outline-offset-1 outline-gray-300 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600">
                                                <option>Bridget (Ultra-realistic)</option>
                                                <option>Maya (Warm)</option>
                                                <option>Alex (Calm)</option>
                                            </select>
                                            <span class="outcraft-icon pointer-events-none col-start-1 row-start-1 mr-3 self-center justify-self-end text-gray-500">keyboard_arrow_down</span>
                                        </div>
                                    </label>
                                </div>

                                <div>
                                    <h3 class="text-sm/6 font-semibold text-gray-900">Hear How Your AI Agent Sounds</h3>
                                    <div class="mt-2 flex items-center gap-3 rounded-lg border border-gray-200 bg-gray-50 p-3">
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

                                <div class="rounded-lg border border-gray-200 bg-white p-6">
                                    <h3 class="text-base font-semibold leading-6 text-gray-950">Schedule</h3>
                                    <p class="mt-2 max-w-3xl text-sm leading-6 text-gray-600">Outreach is scheduled and sent based on the lead's local timezone. The timezone is inferred from the lead's phone number and country data.</p>

                                    <div class="mt-8">
                                        <label class="block max-w-xl">
                                            <span class="block text-sm/6 font-semibold text-gray-900">Outreach Schedule</span>
                                            <div class="mt-2 grid grid-cols-1">
                                                <select x-model="campaignSetup.scheduleMode" x-on:change="campaignSetup.allDay = campaignSetup.scheduleMode === 'all-day'; scheduleCampaignBuilderLayoutUpdate()" class="col-start-1 row-start-1 block w-full appearance-none rounded-md bg-white py-1.5 pr-8 pl-3 text-sm/6 text-gray-900 shadow-sm outline outline-1 -outline-offset-1 outline-gray-300 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600">
                                                    <option value="business">Working Hours</option>
                                                    <option value="all-day">Always On</option>
                                                    <option value="custom">Custom Schedule</option>
                                                </select>
                                                <span class="outcraft-icon pointer-events-none col-start-1 row-start-1 mr-3 self-center justify-self-end text-gray-500">keyboard_arrow_down</span>
                                            </div>
                                            <span class="mt-2 block text-sm leading-6 text-gray-600" x-text="campaignSetup.scheduleMode === 'all-day' ? 'AI can contact leads at any time, regardless of business hours.' : (campaignSetup.scheduleMode === 'custom' ? 'Choose the exact days and hours when AI can contact leads.' : 'AI contacts leads during standard working hours in their local timezone.')"></span>
                                        </label>

                                        <fieldset x-show="campaignSetup.scheduleMode === 'custom'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-3" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-2" class="mt-7">
                                            <div class="flex items-center justify-between gap-4">
                                                <h4 class="text-sm font-semibold leading-6 text-gray-950">Outreach Days</h4>
                                                <button type="button" x-on:click="selectAllOutreachDays()" class="text-sm font-semibold text-indigo-600 hover:text-indigo-500">Select All</button>
                                            </div>

                                            <div class="mt-4 flex flex-col gap-3 sm:flex-row sm:flex-wrap sm:items-center sm:gap-x-6 sm:gap-y-3">
                                                <template x-for="day in outreachWeekdays" :key="day">
                                                    <button type="button" x-on:click="toggleOutreachDay(day)" role="checkbox" :aria-checked="campaignSetup.outreachDays.includes(day)" class="inline-flex w-fit items-center gap-3 rounded-md text-sm font-semibold leading-6 text-gray-900 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                                                        <span class="inline-flex size-4 items-center justify-center rounded border transition" :class="campaignSetup.outreachDays.includes(day) ? 'border-indigo-600 bg-indigo-600 text-white' : 'border-gray-300 bg-white text-transparent shadow-sm'">
                                                            <span class="outcraft-icon !text-[12px]">check</span>
                                                        </span>
                                                        <span x-text="day"></span>
                                                    </button>
                                                </template>
                                            </div>

                                            <div class="mt-7 grid gap-6 lg:grid-cols-2">
                                                <label class="block">
                                                    <span class="block text-sm/6 font-semibold text-gray-900">Outreach Start Hour<span class="text-indigo-600">*</span></span>
                                                    <div class="mt-2 grid grid-cols-1">
                                                        <select x-model="campaignSetup.outreachStartHour" class="col-start-1 row-start-1 block w-full appearance-none rounded-md bg-white py-1.5 pl-3 pr-8 text-sm/6 text-gray-900 shadow-sm outline outline-1 -outline-offset-1 outline-gray-300 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600">
                                                            <template x-for="hour in outreachHourOptions" :key="`agent-start-${hour}`">
                                                                <option :value="hour" x-text="hour"></option>
                                                            </template>
                                                        </select>
                                                        <span class="outcraft-icon pointer-events-none col-start-1 row-start-1 mr-3 self-center justify-self-end text-gray-500">keyboard_arrow_down</span>
                                                    </div>
                                                    <span class="mt-2 block text-sm leading-6 text-gray-600">The earliest time AI can contact a lead in their local timezone.</span>
                                                </label>

                                                <label class="block">
                                                    <span class="block text-sm/6 font-semibold text-gray-900">Outreach End Hour<span class="text-indigo-600">*</span></span>
                                                    <div class="mt-2 grid grid-cols-1">
                                                        <select x-model="campaignSetup.outreachEndHour" class="col-start-1 row-start-1 block w-full appearance-none rounded-md bg-white py-1.5 pl-3 pr-8 text-sm/6 text-gray-900 shadow-sm outline outline-1 -outline-offset-1 outline-gray-300 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600">
                                                            <template x-for="hour in outreachHourOptions" :key="`agent-end-${hour}`">
                                                                <option :value="hour" x-text="hour"></option>
                                                            </template>
                                                        </select>
                                                        <span class="outcraft-icon pointer-events-none col-start-1 row-start-1 mr-3 self-center justify-self-end text-gray-500">keyboard_arrow_down</span>
                                                    </div>
                                                    <span class="mt-2 block text-sm leading-6 text-gray-600">The latest time AI can contact a lead in their local timezone.</span>
                                                </label>
                                            </div>
                                        </fieldset>
                                    </div>
                                </div>
                                <div class="overflow-hidden rounded-lg border border-gray-200 bg-white">
                                    <div class="border-b border-gray-200 px-6 py-5">
                                        <h3 class="text-base font-semibold leading-6 text-gray-950">Handoff</h3>
                                    </div>
                                    <div class="divide-y divide-gray-200">
                                        <div class="px-6 py-6">
                                            <button type="button" x-on:click="campaignSetup.handoffPositive = ! campaignSetup.handoffPositive; scheduleCampaignBuilderLayoutUpdate()" role="switch" :aria-checked="campaignSetup.handoffPositive" class="flex w-full items-start gap-4 rounded-md text-left focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                                                <span class="relative mt-1 inline-flex h-6 w-11 shrink-0 rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out" :class="campaignSetup.handoffPositive ? 'bg-indigo-600' : 'bg-gray-200'">
                                                    <span class="pointer-events-none inline-block size-5 rounded-full bg-white shadow transition duration-200 ease-in-out" :class="campaignSetup.handoffPositive ? 'translate-x-5' : 'translate-x-0'"></span>
                                                </span>
                                                <span class="min-w-0">
                                                    <span class="block text-sm font-semibold leading-6 text-gray-950">Hand Off After a Positive Reply</span>
                                                    <span class="mt-1 block text-sm leading-6 text-gray-600">AI passes the conversation to a human when the lead responds positively.</span>
                                                </span>
                                            </button>

                                            <div x-show="campaignSetup.handoffPositive" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-3" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-2" class="mt-6">
                                                <label class="block">
                                                    <span class="block text-sm/6 font-medium text-gray-900">Handoff Trigger Scenarios</span>
                                                    <div class="mt-2 grid grid-cols-1">
                                                        <select x-model="campaignSetup.handoffScenario" class="col-start-1 row-start-1 block w-full appearance-none rounded-md bg-white py-1.5 pl-3 pr-8 text-sm/6 text-gray-900 shadow-sm outline outline-1 -outline-offset-1 outline-gray-300 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600">
                                                            <option value="">Type Your Own or Select Common Scenario</option>
                                                            <option>Positive Reply</option>
                                                            <option>Pricing Request</option>
                                                            <option>Legal or Compliance Question</option>
                                                            <option>Lead Asks for Human Help</option>
                                                        </select>
                                                        <span class="outcraft-icon pointer-events-none col-start-1 row-start-1 mr-3 self-center justify-self-end text-gray-500">keyboard_arrow_down</span>
                                                    </div>
                                                    <span class="mt-2 block text-sm leading-6 text-gray-500">Situations where AI should pass to a human agent.</span>
                                                </label>
                                            </div>
                                        </div>

                                        <div class="px-6 py-6">
                                            <button type="button" x-on:click="campaignSetup.handoffRequested = ! campaignSetup.handoffRequested; scheduleCampaignBuilderLayoutUpdate()" role="switch" :aria-checked="campaignSetup.handoffRequested" class="flex w-full items-start gap-4 rounded-md text-left focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                                                <span class="relative mt-1 inline-flex h-6 w-11 shrink-0 rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out" :class="campaignSetup.handoffRequested ? 'bg-indigo-600' : 'bg-gray-200'">
                                                    <span class="pointer-events-none inline-block size-5 rounded-full bg-white shadow transition duration-200 ease-in-out" :class="campaignSetup.handoffRequested ? 'translate-x-5' : 'translate-x-0'"></span>
                                                </span>
                                                <span class="min-w-0">
                                                    <span class="block text-sm font-semibold leading-6 text-gray-950">Hand Off When the Lead Asks</span>
                                                    <span class="mt-1 block text-sm leading-6 text-gray-600">AI passes the conversation when the lead explicitly requests a human.</span>
                                                </span>
                                            </button>

                                            <div x-show="campaignSetup.handoffRequested" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-3" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-2" class="mt-6">
                                                <label class="block">
                                                    <span class="block text-sm/6 font-medium text-gray-900">Handoff Channel</span>
                                                    <div class="mt-2 grid grid-cols-1">
                                                        <select x-model="campaignSetup.handoffChannel" class="col-start-1 row-start-1 block w-full appearance-none rounded-md bg-white py-1.5 pl-3 pr-8 text-sm/6 text-gray-900 shadow-sm outline outline-1 -outline-offset-1 outline-gray-300 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600">
                                                            <option value="">Select a Channel</option>
                                                            <option>Email</option>
                                                            <option>Slack</option>
                                                            <option>CRM Task</option>
                                                            <option>Webhook</option>
                                                            <option>Internal Dashboard</option>
                                                        </select>
                                                        <span class="outcraft-icon pointer-events-none col-start-1 row-start-1 mr-3 self-center justify-self-end text-gray-500">keyboard_arrow_down</span>
                                                    </div>
                                                    <span class="mt-2 block text-sm leading-6 text-gray-500">How the human agent is notified.</span>
                                                </label>
                                            </div>
                                        </div>

                                        <div class="px-6 py-6">
                                            <label class="block">
                                                <span class="block text-sm/6 font-semibold text-gray-900">Handoff Notification Email</span>
                                                <input x-model="campaignSetup.handoffNotificationEmail" type="email" placeholder="support@pulsetto.com" class="mt-2 block w-full rounded-md bg-white px-3 py-1.5 text-sm/6 text-gray-900 shadow-sm outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600">
                                                <span class="mt-2 block text-sm leading-6 text-gray-600">Where to send a notification when the AI hands off a conversation to a human.</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div x-show="campaignSetupMode === 'advanced'" class="space-y-7">
                                    <div class="overflow-hidden rounded-lg border border-gray-200">
                                        <button type="button" x-on:click="agentAdvancedOpen = ! agentAdvancedOpen; scheduleCampaignBuilderLayoutUpdate()" class="flex w-full items-center justify-between gap-4 px-5 py-4 text-left transition hover:bg-gray-50">
                                            <span>
                                                <span class="block text-base/7 font-semibold text-gray-900">Advanced</span>
                                                <span class="mt-1 block text-sm leading-6 text-gray-600">We recommend keeping the default Advanced settings. They’re tuned for natural flow and stronger results.</span>
                                            </span>
                                            <span class="outcraft-icon text-gray-400 transition" :class="agentAdvancedOpen ? 'rotate-180' : ''">keyboard_arrow_down</span>
                                        </button>

                                        <div x-show="agentAdvancedOpen" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-3" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-2" class="border-t border-gray-200 p-5">
                                            <div class="grid gap-6 lg:grid-cols-2">
                                                <label class="order-4 block lg:col-span-2">
                                            <span class="mb-2 block text-sm/6 font-semibold text-gray-900">Agent Email Signature</span>
                                            <textarea x-model="campaignSetup.emailSignature" rows="4" placeholder="Best,&#10;Bridget from Outcraft AI" class="mt-2 block min-h-[96px] w-full resize-y rounded-md bg-white px-3 py-2 text-sm/6 text-gray-700 shadow-sm outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600"></textarea>
                                            <span class="mt-2 block text-sm leading-6 text-gray-600">This signature will be used at the end of all emails sent by the AI agent.</span>
                                        </label>
                                            <div class="order-5 -mx-5 border-t border-gray-200 lg:col-span-2"></div>
                                            <label class="order-1 block lg:col-span-2">
                                                <span class="mb-2 flex items-center justify-between gap-3">
                                                    <span class="block text-sm/6 font-semibold text-gray-900">Call Greeting Phrase<span class="text-indigo-600">*</span></span>
                                                    <span class="relative" x-data="{ fieldActionsOpen: false }" x-on:click.outside="fieldActionsOpen = false">
                                                        <button type="button" x-on:click="fieldActionsOpen = ! fieldActionsOpen" class="inline-flex size-7 items-center justify-center rounded-md text-gray-400 transition hover:bg-gray-50 hover:text-gray-700" aria-label="Call greeting custom field actions">
                                                            <span class="outcraft-icon !text-[18px]">more_vert</span>
                                                        </button>
                                                        <span x-cloak x-show="fieldActionsOpen" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-3" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-2" class="absolute right-0 z-40 mt-2 w-52 rounded-md bg-white py-1 shadow-lg ring-1 ring-gray-900/10">
                                                            <button type="button" x-on:click="openCustomFieldTextInput('agentCallGreeting'); fieldActionsOpen = false" class="flex w-full items-center gap-2 px-3 py-2 text-left text-sm font-medium text-gray-700 transition hover:bg-gray-50 hover:text-gray-950">
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
                                                    <div class="relative grid min-w-0 overflow-hidden transition-[grid-template-columns] duration-200 ease-out" :class="customFieldTextInputState('agentCallGreeting').layoutOpen ? 'lg:grid-cols-[minmax(0,1fr)_18rem]' : 'lg:grid-cols-1'">
                                                        <textarea x-model="campaignSetup.callGreeting" rows="2" class="block min-h-[64px] min-w-0 w-full resize-y border-0 bg-white px-5 py-4 text-sm/6 text-gray-700 outline-none placeholder:text-gray-400 focus:ring-0"></textarea>
                                                        <aside x-cloak x-show="customFieldTextInputState('agentCallGreeting').open" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="translate-x-full opacity-0" x-transition:enter-end="translate-x-0 opacity-100" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="translate-x-0 opacity-100" x-transition:leave-end="translate-x-full opacity-0" class="min-w-0 border-t border-gray-200 bg-white lg:border-t-0 lg:border-l lg:border-gray-200">
                                                            <div class="flex items-center gap-2 border-b border-gray-200 px-4 py-3"><label class="min-w-0 flex-1"><input :value="customFieldTextInputState('agentCallGreeting').search" x-on:input="customFieldTextInputState('agentCallGreeting').search = $event.target.value" type="search" placeholder="Search Custom Fields" class="block h-9 w-full rounded-md bg-white px-3 py-1.5 text-sm text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600"></label><button type="button" x-on:click="closeCustomFieldTextInput('agentCallGreeting')" class="inline-flex size-7 items-center justify-center rounded-md text-gray-400 transition hover:bg-white hover:text-gray-700" aria-label="Close custom fields"><span class="outcraft-icon !text-[18px]">close</span></button></div>
                                                            <div class="flex flex-wrap gap-2 px-4 py-4"><template x-for="tag in filteredCustomFieldTextInputTags('agentCallGreeting')" :key="`agent-greeting-${tag}`"><button type="button" class="inline-flex h-8 items-center rounded-md bg-white px-2.5 text-sm font-medium text-gray-600 shadow-sm ring-1 ring-inset ring-gray-200 transition hover:bg-gray-50 hover:text-gray-900" x-text="tag"></button></template><p x-show="filteredCustomFieldTextInputTags('agentCallGreeting').length === 0" class="text-sm text-gray-500">No Custom Fields Found.</p></div>
                                                        </aside>
                                                    </div>
                                                </div>
                                                <button type="button" x-on:click="campaignSetup.callGreeting = 'Hey, is this @{{first_name}}?'" class="mt-2 text-sm font-semibold text-indigo-600 hover:text-indigo-500">Use Default</button>
                                            </label>

                                            <label class="order-2 block lg:col-span-2">
                                                <span class="block text-sm/6 font-semibold text-gray-900">Call Background Sound</span>
                                                <div class="mt-2 grid grid-cols-1">
                                                    <select x-model="campaignSetup.backgroundNoise" class="col-start-1 row-start-1 block w-full appearance-none rounded-md bg-white py-1.5 pr-8 pl-3 text-sm/6 text-gray-900 shadow-sm outline outline-1 -outline-offset-1 outline-gray-300 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600">
                                                        <option>Office</option>
                                                        <option>None</option>
                                                        <option>Cafe</option>
                                                        <option>Street</option>
                                                    </select>
                                                    <span class="outcraft-icon pointer-events-none col-start-1 row-start-1 mr-3 self-center justify-self-end text-gray-500">keyboard_arrow_down</span>
                                                </div>
                                            </label>
                                            <div class="order-3 -mx-5 border-t border-gray-200 lg:col-span-2"></div>
                                            <label class="order-7 block">
                                                <span class="block text-sm/6 font-semibold text-gray-900">Transcriber Model <span class="text-xs font-medium text-gray-400">Admin-Only</span></span>
                                                <div class="mt-2 grid grid-cols-1"><select x-model="campaignSetup.transcriberModel" class="col-start-1 row-start-1 block w-full appearance-none rounded-md bg-white py-1.5 pr-8 pl-3 text-sm/6 text-gray-900 shadow-sm outline outline-1 -outline-offset-1 outline-gray-300 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600"><option>Flux General</option></select><span class="outcraft-icon pointer-events-none col-start-1 row-start-1 mr-3 self-center justify-self-end text-gray-500">keyboard_arrow_down</span></div>
                                            </label>
                                            <label class="order-6 block">
                                                <span class="block text-sm/6 font-semibold text-gray-900">AI Model <span class="text-xs font-medium text-gray-400">Admin-Only</span></span>
                                                <div class="mt-2 grid grid-cols-1"><select x-model="campaignSetup.aiModel" class="col-start-1 row-start-1 block w-full appearance-none rounded-md bg-white py-1.5 pr-8 pl-3 text-sm/6 text-gray-900 shadow-sm outline outline-1 -outline-offset-1 outline-gray-300 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600"><option>GPT-4.1</option></select><span class="outcraft-icon pointer-events-none col-start-1 row-start-1 mr-3 self-center justify-self-end text-gray-500">keyboard_arrow_down</span></div>
                                            </label>
                                            <div class="order-8 -mx-5 border-t border-gray-200 lg:col-span-2"></div>

                                            <label class="order-9 block lg:col-span-2">
                                                <span class="mb-2 block text-sm/6 font-semibold text-gray-900">AI Agent Personality<span class="text-indigo-600">*</span></span>
                                                <textarea x-model="campaignSetup.agentPersonality" rows="6" class="mt-2 block min-h-[140px] w-full resize-y rounded-md bg-white px-3 py-2 text-sm/6 text-gray-700 shadow-sm outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600"></textarea>
                                            </label>

                                            <label class="order-10 block lg:col-span-2">
                                                <span class="mb-2 block text-sm/6 font-semibold text-gray-900">AI Agent Speech Style<span class="text-indigo-600">*</span></span>
                                                <textarea x-model="campaignSetup.agentSpeechStyle" rows="6" class="mt-2 block min-h-[140px] w-full resize-y rounded-md bg-white px-3 py-2 text-sm/6 text-gray-700 shadow-sm outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600"></textarea>
                                            </label>
                                        </div>
                                    </div>
                                    </div>
                                </div>
                                </div>


                            </section>

	                            <section x-cloak x-show="campaignSetup.current === 'channels' || campaignSetupScrollFromStep === 'channels'" x-ref="campaignSetupStep_channels"
                                :style="campaignSetupStepStyle('channels')"
                                data-campaign-setup-step
                                class="space-y-6 pr-2 pb-4">
                                <div class="mb-1">
                                    <p class="text-sm font-semibold text-indigo-600" x-text="`${campaignSetupMode === 'fast' ? 'Fast Setup' : 'Advanced Setup'} · Step ${campaignSetupStepIndex('channels') + 1} of ${campaignSetupStepsForMode().length}`"></p>
                                    <h2 class="mt-2 text-2xl font-bold leading-8 tracking-tight text-gray-950" x-text="campaignSetupHeading('channels')"></h2>
                                    <p class="mt-2 max-w-3xl text-sm leading-6 text-gray-600" x-text="campaignSetupDescription('channels')"></p>
                                </div>
	                                <div class="bg-white">
	                                    <div>
	                                        <div class="flex items-center justify-between gap-4">
	                                            <button type="button" x-on:click="toggleChannel('calls')" role="switch" :aria-checked="campaignSetup.channels.calls" class="inline-flex items-center gap-4 rounded-md text-left focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
	                                                <span class="relative inline-flex h-6 w-11 shrink-0 rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out" :class="campaignSetup.channels.calls ? 'bg-indigo-600' : 'bg-gray-200'">
	                                                    <span class="pointer-events-none inline-block size-5 rounded-full bg-white shadow transition duration-200 ease-in-out" :class="campaignSetup.channels.calls ? 'translate-x-5' : 'translate-x-0'"></span>
	                                                </span>
	                                                <span class="text-sm font-semibold leading-6 text-gray-950">Enable AI Calls</span>
	                                            </button>
	                                            <button type="button" x-on:click="campaignSetup.channelOpen.calls = ! campaignSetup.channelOpen.calls; scheduleCampaignBuilderLayoutUpdate()" :disabled="! campaignSetup.channels.calls" class="inline-flex h-9 items-center gap-2 rounded-md bg-white px-3 text-sm font-semibold shadow-sm ring-1 ring-inset ring-gray-300 transition hover:bg-gray-50 disabled:cursor-not-allowed disabled:bg-gray-50 disabled:text-gray-400 disabled:ring-gray-200" :class="campaignSetup.channels.calls ? 'text-gray-900' : 'text-gray-400'">
	                                                Configure
	                                                <span class="outcraft-icon !text-[16px] text-gray-400" :class="campaignSetup.channels.calls && campaignSetup.channelOpen.calls ? 'rotate-180' : ''">keyboard_arrow_down</span>
	                                            </button>
	                                        </div>
	                                        <div x-show="campaignSetup.channels.calls && campaignSetup.channelOpen.calls" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-3" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-2" class="mt-6 rounded-lg border border-gray-200 p-5">
	                                            <label class="block">
	                                                <span class="mb-2 flex items-center justify-between gap-3">
	                                                    <span class="block text-sm/6 font-semibold text-gray-900">Call-Specific Guidelines (optional)</span>
	                                                    <span class="relative" x-data="{ fieldActionsOpen: false }" x-on:click.outside="fieldActionsOpen = false">
	                                                        <button type="button" x-on:click="fieldActionsOpen = ! fieldActionsOpen" class="inline-flex size-7 items-center justify-center rounded-md text-gray-400 transition hover:bg-gray-50 hover:text-gray-700" aria-label="Call custom field actions">
	                                                            <span class="outcraft-icon !text-[18px]">more_vert</span>
	                                                        </button>
	                                                        <span x-cloak x-show="fieldActionsOpen" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-3" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-2" class="absolute right-0 z-40 mt-2 w-52 rounded-md bg-white py-1 shadow-lg ring-1 ring-gray-900/10">
	                                                            <button type="button" x-on:click="openCustomFieldTextInput('callGuidelines'); fieldActionsOpen = false" class="flex w-full items-center gap-2 px-3 py-2 text-left text-sm font-medium text-gray-700 transition hover:bg-gray-50 hover:text-gray-950">
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
	                                                    <div class="relative grid min-w-0 overflow-hidden transition-[grid-template-columns] duration-200 ease-out" :class="customFieldTextInputState('callGuidelines').layoutOpen ? 'lg:grid-cols-[minmax(0,1fr)_18rem]' : 'lg:grid-cols-1'">
	                                                        <textarea x-model="campaignSetup.callGuidelines" rows="4" placeholder="Add call tone, pacing, objection handling, and compliance notes." class="block min-h-[110px] min-w-0 w-full resize-y border-0 bg-white px-5 py-4 text-sm/6 text-gray-700 outline-none placeholder:text-gray-400 focus:ring-0"></textarea>
	                                                        <aside x-cloak x-show="customFieldTextInputState('callGuidelines').open" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="translate-x-full opacity-0" x-transition:enter-end="translate-x-0 opacity-100" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="translate-x-0 opacity-100" x-transition:leave-end="translate-x-full opacity-0" class="min-w-0 border-t border-gray-200 bg-white lg:border-t-0 lg:border-l lg:border-gray-200">
	                                                            <div class="flex items-center gap-2 border-b border-gray-200 px-4 py-3"><label class="min-w-0 flex-1"><input :value="customFieldTextInputState('callGuidelines').search" x-on:input="customFieldTextInputState('callGuidelines').search = $event.target.value" type="search" placeholder="Search Custom Fields" class="block h-9 w-full rounded-md bg-white px-3 py-1.5 text-sm text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600"></label><button type="button" x-on:click="closeCustomFieldTextInput('callGuidelines')" class="inline-flex size-7 items-center justify-center rounded-md text-gray-400 transition hover:bg-white hover:text-gray-700" aria-label="Close custom fields"><span class="outcraft-icon !text-[18px]">close</span></button></div>
	                                                            <div class="flex flex-wrap gap-2 px-4 py-4">
	                                                                <template x-for="tag in filteredCustomFieldTextInputTags('callGuidelines')" :key="`call-${tag}`"><button type="button" class="inline-flex h-8 items-center rounded-md bg-white px-2.5 text-sm font-medium text-gray-600 shadow-sm ring-1 ring-inset ring-gray-200 transition hover:bg-gray-50 hover:text-gray-900" x-text="tag"></button></template>
	                                                                <p x-show="filteredCustomFieldTextInputTags('callGuidelines').length === 0" class="text-sm text-gray-500">No Custom Fields Found.</p>
	                                                            </div>
	                                                        </aside>
	                                                    </div>
	                                                </div>
	                                                <span class="mt-2 block text-sm leading-6 text-gray-600">A brief guideline for call structure, pacing, tone, and edge cases.</span>
	                                            </label>
	                                            <div class="mt-6" x-ref="callConversationFlow">
	                                                <div class="flex flex-wrap items-center justify-between gap-3">
	                                                    <h4 class="text-base font-semibold leading-6 text-gray-950">Call Conversation Flow</h4>
	                                                    <div class="flex flex-wrap items-center gap-3">
	                                                        <button type="button" class="inline-flex items-center gap-2 text-sm font-semibold text-gray-900 transition hover:text-indigo-600">
	                                                            <span class="outcraft-icon !text-[15px]">refresh</span>
	                                                            Reset Conversation Flow To Default
	                                                        </button>
	                                                    </div>
	                                                </div>
	                                                <div class="mt-3 rounded-md bg-amber-50 px-4 py-3 text-sm font-medium leading-5 text-amber-800">
	                                                    <span class="inline-flex items-start gap-2">
	                                                        <span class="outcraft-icon mt-0.5 shrink-0 text-amber-500">report</span>
	                                                        <span>These stages guide how the AI structures the conversation. Keep instructions short (1-2 Sentences per stage). Detailed rules belong in the Short Campaign Description.</span>
	                                                    </span>
	                                                </div>
	                                                <div class="mt-5 space-y-4">
	                                                    <template x-for="stage in conversationStages" :key="stage.title">
	                                                        <label class="block">
	                                                            <span class="mb-2 flex items-center justify-between gap-3">
	                                                                <span class="block text-sm/6 font-semibold text-gray-900"><span x-text="stage.title"></span><span class="text-indigo-600">*</span></span>
	                                                                <span class="relative" x-data="{ fieldActionsOpen: false }" x-on:click.outside="fieldActionsOpen = false">
	                                                                    <button type="button" x-on:click="fieldActionsOpen = ! fieldActionsOpen" class="inline-flex size-7 items-center justify-center rounded-md text-gray-400 transition hover:bg-gray-50 hover:text-gray-700" aria-label="Conversation stage custom field actions">
	                                                                        <span class="outcraft-icon !text-[18px]">more_vert</span>
	                                                                    </button>
	                                                                    <span x-cloak x-show="fieldActionsOpen" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-3" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-2" class="absolute right-0 z-40 mt-2 w-52 rounded-md bg-white py-1 shadow-lg ring-1 ring-gray-900/10">
	                                                                        <button type="button" x-on:click="openCustomFieldTextInput('callStage:' + stage.title); fieldActionsOpen = false" class="flex w-full items-center gap-2 px-3 py-2 text-left text-sm font-medium text-gray-700 transition hover:bg-gray-50 hover:text-gray-950">
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
	                                                                <div class="relative grid min-w-0 overflow-hidden transition-[grid-template-columns] duration-200 ease-out" :class="customFieldTextInputState('callStage:' + stage.title).layoutOpen ? 'lg:grid-cols-[minmax(0,1fr)_18rem]' : 'lg:grid-cols-1'">
	                                                                    <textarea x-model="stage.content" rows="2" maxlength="500" class="block min-h-[56px] min-w-0 w-full resize-y border-0 bg-white px-4 py-3 text-sm/6 text-gray-700 outline-none placeholder:text-gray-400 focus:ring-0"></textarea>
	                                                                    <aside x-cloak x-show="customFieldTextInputState('callStage:' + stage.title).open" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="translate-x-full opacity-0" x-transition:enter-end="translate-x-0 opacity-100" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="translate-x-0 opacity-100" x-transition:leave-end="translate-x-full opacity-0" class="min-w-0 border-t border-gray-200 bg-white lg:border-t-0 lg:border-l lg:border-gray-200">
	                                                                        <div class="flex items-center gap-2 border-b border-gray-200 px-4 py-3"><label class="min-w-0 flex-1"><input :value="customFieldTextInputState('callStage:' + stage.title).search" x-on:input="customFieldTextInputState('callStage:' + stage.title).search = $event.target.value" type="search" placeholder="Search Custom Fields" class="block h-9 w-full rounded-md bg-white px-3 py-1.5 text-sm text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600"></label><button type="button" x-on:click="closeCustomFieldTextInput('callStage:' + stage.title)" class="inline-flex size-7 items-center justify-center rounded-md text-gray-400 transition hover:bg-white hover:text-gray-700" aria-label="Close custom fields"><span class="outcraft-icon !text-[18px]">close</span></button></div>
	                                                                        <div class="flex flex-wrap gap-2 px-4 py-4">
	                                                                            <template x-for="tag in filteredCustomFieldTextInputTags('callStage:' + stage.title)" :key="`call-${stage.title}-${tag}`">
	                                                                                <button type="button" class="inline-flex h-8 items-center rounded-md bg-white px-2.5 text-sm font-medium text-gray-600 shadow-sm ring-1 ring-inset ring-gray-200 transition hover:bg-gray-50 hover:text-gray-900" x-text="tag"></button>
	                                                                            </template>
	                                                                            <p x-show="filteredCustomFieldTextInputTags('callStage:' + stage.title).length === 0" class="text-sm text-gray-500">No Custom Fields Found.</p>
	                                                                        </div>
	                                                                    </aside>
	                                                                </div>
	                                                            </div>
	                                                            <span class="mt-2 block text-sm leading-6 text-gray-600">Max: 500 Characters</span>
	                                                        </label>
	                                                    </template>
	                                                </div>
	                                            </div>
	                                        </div>
	                                    </div>
	                                </div>

	                                <div class="bg-white">
	                                    <div>
	                                        <div class="flex items-center justify-between gap-4">
	                                            <button type="button" x-on:click="toggleChannel('email')" role="switch" :aria-checked="campaignSetup.channels.email" class="inline-flex items-center gap-4 rounded-md text-left focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
	                                                <span class="relative inline-flex h-6 w-11 shrink-0 rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out" :class="campaignSetup.channels.email ? 'bg-indigo-600' : 'bg-gray-200'">
	                                                    <span class="pointer-events-none inline-block size-5 rounded-full bg-white shadow transition duration-200 ease-in-out" :class="campaignSetup.channels.email ? 'translate-x-5' : 'translate-x-0'"></span>
	                                                </span>
	                                                <span class="text-sm font-semibold leading-6 text-gray-950">Enable Email Sending</span>
	                                            </button>
	                                            <button type="button" x-on:click="campaignSetup.channelOpen.email = ! campaignSetup.channelOpen.email; scheduleCampaignBuilderLayoutUpdate()" :disabled="! campaignSetup.channels.email" class="inline-flex h-9 items-center gap-2 rounded-md bg-white px-3 text-sm font-semibold shadow-sm ring-1 ring-inset ring-gray-300 transition hover:bg-gray-50 disabled:cursor-not-allowed disabled:bg-gray-50 disabled:text-gray-400 disabled:ring-gray-200" :class="campaignSetup.channels.email ? 'text-gray-900' : 'text-gray-400'">
	                                                Configure
	                                                <span class="outcraft-icon !text-[16px] text-gray-400" :class="campaignSetup.channels.email && campaignSetup.channelOpen.email ? 'rotate-180' : ''">keyboard_arrow_down</span>
	                                            </button>
	                                        </div>
	                                        <div x-show="campaignSetup.channels.email && campaignSetup.channelOpen.email" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-3" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-2" class="mt-6 space-y-5 rounded-lg border border-gray-200 p-5">
	                                            <label class="block">
	                                                <span class="mb-2 flex items-center justify-between gap-3">
	                                                    <span class="block text-sm/6 font-semibold text-gray-900">Email-Specific Guidelines (optional)</span>
	                                                    <span class="relative" x-data="{ fieldActionsOpen: false }" x-on:click.outside="fieldActionsOpen = false">
	                                                        <button type="button" x-on:click="fieldActionsOpen = ! fieldActionsOpen" class="inline-flex size-7 items-center justify-center rounded-md text-gray-400 transition hover:bg-gray-50 hover:text-gray-700" aria-label="Email custom field actions">
	                                                            <span class="outcraft-icon !text-[18px]">more_vert</span>
	                                                        </button>
	                                                        <span x-cloak x-show="fieldActionsOpen" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-3" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-2" class="absolute right-0 z-40 mt-2 w-52 rounded-md bg-white py-1 shadow-lg ring-1 ring-gray-900/10">
	                                                            <button type="button" x-on:click="openCustomFieldTextInput('emailGuidelines'); fieldActionsOpen = false" class="flex w-full items-center gap-2 px-3 py-2 text-left text-sm font-medium text-gray-700 transition hover:bg-gray-50 hover:text-gray-950">
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
	                                                    <div class="relative grid min-w-0 overflow-hidden transition-[grid-template-columns] duration-200 ease-out" :class="customFieldTextInputState('emailGuidelines').layoutOpen ? 'lg:grid-cols-[minmax(0,1fr)_18rem]' : 'lg:grid-cols-1'">
	                                                        <textarea x-model="campaignSetup.emailGuidelines" rows="4" placeholder="Add email tone, formatting, and compliance notes." class="block min-h-[110px] min-w-0 w-full resize-y border-0 bg-white px-5 py-4 text-sm/6 text-gray-700 outline-none placeholder:text-gray-400 focus:ring-0"></textarea>
	                                                        <aside x-cloak x-show="customFieldTextInputState('emailGuidelines').open" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="translate-x-full opacity-0" x-transition:enter-end="translate-x-0 opacity-100" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="translate-x-0 opacity-100" x-transition:leave-end="translate-x-full opacity-0" class="min-w-0 border-t border-gray-200 bg-white lg:border-t-0 lg:border-l lg:border-gray-200">
	                                                            <div class="flex items-center gap-2 border-b border-gray-200 px-4 py-3"><label class="min-w-0 flex-1"><input :value="customFieldTextInputState('emailGuidelines').search" x-on:input="customFieldTextInputState('emailGuidelines').search = $event.target.value" type="search" placeholder="Search Custom Fields" class="block h-9 w-full rounded-md bg-white px-3 py-1.5 text-sm text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600"></label><button type="button" x-on:click="closeCustomFieldTextInput('emailGuidelines')" class="inline-flex size-7 items-center justify-center rounded-md text-gray-400 transition hover:bg-white hover:text-gray-700" aria-label="Close custom fields"><span class="outcraft-icon !text-[18px]">close</span></button></div>
	                                                            <div class="flex flex-wrap gap-2 px-4 py-4">
	                                                                <template x-for="tag in filteredCustomFieldTextInputTags('emailGuidelines')" :key="`email-${tag}`"><button type="button" class="inline-flex h-8 items-center rounded-md bg-white px-2.5 text-sm font-medium text-gray-600 shadow-sm ring-1 ring-inset ring-gray-200 transition hover:bg-gray-50 hover:text-gray-900" x-text="tag"></button></template>
	                                                                <p x-show="filteredCustomFieldTextInputTags('emailGuidelines').length === 0" class="text-sm text-gray-500">No Custom Fields Found.</p>
	                                                            </div>
	                                                        </aside>
	                                                    </div>
	                                                </div>
	                                                <span class="mt-2 block text-sm leading-6 text-gray-600">A brief guideline for email structure, tone, and content.</span>
	                                            </label>
	                                            <button type="button" x-on:click="campaignSetup.trackEmailLinkClicks = ! campaignSetup.trackEmailLinkClicks" role="switch" :aria-checked="campaignSetup.trackEmailLinkClicks" class="flex w-full items-start gap-4 rounded-md text-left focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
	                                                <span class="relative mt-0.5 inline-flex h-6 w-11 shrink-0 rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out" :class="campaignSetup.trackEmailLinkClicks ? 'bg-indigo-600' : 'bg-gray-200'">
	                                                    <span class="pointer-events-none inline-block size-5 rounded-full bg-white shadow transition duration-200 ease-in-out" :class="campaignSetup.trackEmailLinkClicks ? 'translate-x-5' : 'translate-x-0'"></span>
	                                                </span>
	                                                <span>
	                                                    <span class="block text-sm font-semibold leading-6 text-gray-950">Track Email Link Clicks</span>
	                                                    <span class="mt-1 block text-sm leading-6 text-gray-600">Measures link clicks for emails that contain links. This may slightly modify link URLs in outgoing emails.</span>
	                                                </span>
	                                            </button>
	                                        </div>
	                                    </div>
	                                </div>

	                                <div class="bg-white">
	                                    <div>
	                                        <div class="flex items-center justify-between gap-4">
	                                            <button type="button" x-on:click="toggleChannel('sms')" role="switch" :aria-checked="campaignSetup.channels.sms" class="inline-flex items-center gap-4 rounded-md text-left focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
	                                                <span class="relative inline-flex h-6 w-11 shrink-0 rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out" :class="campaignSetup.channels.sms ? 'bg-indigo-600' : 'bg-gray-200'">
	                                                    <span class="pointer-events-none inline-block size-5 rounded-full bg-white shadow transition duration-200 ease-in-out" :class="campaignSetup.channels.sms ? 'translate-x-5' : 'translate-x-0'"></span>
	                                                </span>
	                                                <span class="text-sm font-semibold leading-6 text-gray-950">Enable SMS Sending</span>
	                                            </button>
	                                            <button type="button" x-on:click="campaignSetup.channelOpen.sms = ! campaignSetup.channelOpen.sms; scheduleCampaignBuilderLayoutUpdate()" :disabled="! campaignSetup.channels.sms" class="inline-flex h-9 items-center gap-2 rounded-md bg-white px-3 text-sm font-semibold shadow-sm ring-1 ring-inset ring-gray-300 transition hover:bg-gray-50 disabled:cursor-not-allowed disabled:bg-gray-50 disabled:text-gray-400 disabled:ring-gray-200" :class="campaignSetup.channels.sms ? 'text-gray-900' : 'text-gray-400'">
	                                                Configure
	                                                <span class="outcraft-icon !text-[16px] text-gray-400" :class="campaignSetup.channels.sms && campaignSetup.channelOpen.sms ? 'rotate-180' : ''">keyboard_arrow_down</span>
	                                            </button>
	                                        </div>
	                                        <div x-show="campaignSetup.channels.sms && campaignSetup.channelOpen.sms" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-3" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-2" class="mt-6 space-y-6 rounded-lg border border-gray-200 p-5">
	                                            <div>
	                                                <div class="flex items-center justify-between gap-3">
	                                                    <h4 class="text-sm font-semibold leading-6 text-gray-950">When to Trigger SMS?</h4>
	                                                </div>
	                                                <div class="mt-2 grid grid-cols-1">
	                                                    <select x-model="campaignSetup.smsTrigger" class="col-start-1 row-start-1 block w-full appearance-none rounded-md bg-white py-1.5 pr-8 pl-3 text-sm/6 text-gray-900 shadow-sm outline outline-1 -outline-offset-1 outline-gray-300 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600">
	                                                        <option>Positive Response</option>
	                                                        <option>No Answer</option>
	                                                        <option>No Decision</option>
	                                                        <option>Negative Response</option>
	                                                        <option>After Call</option>
	                                                        <option>After Resource Accepted</option>
	                                                    </select>
	                                                    <span class="outcraft-icon pointer-events-none col-start-1 row-start-1 mr-3 self-center justify-self-end text-gray-500">keyboard_arrow_down</span>
	                                                </div>
	                                                <span class="mt-2 block text-sm leading-6 text-gray-600">Select the events after which the AI can send an SMS to the lead.</span>
	                                            </div>
	                                            <label class="block">
		                                                <span class="flex items-center justify-between gap-3">
		                                                    <span class="text-sm/6 font-semibold text-gray-900">SMS-Specific Guidelines (optional)</span>
		                                                    <span class="flex items-center gap-1">
		                                                        <span class="relative" x-data="{ fieldActionsOpen: false }" x-on:click.outside="fieldActionsOpen = false">
		                                                            <button type="button" x-on:click="fieldActionsOpen = ! fieldActionsOpen" class="inline-flex size-7 items-center justify-center rounded-md text-gray-400 transition hover:bg-gray-50 hover:text-gray-700" aria-label="SMS custom field actions">
		                                                                <span class="outcraft-icon !text-[18px]">more_vert</span>
		                                                            </button>
		                                                            <span x-cloak x-show="fieldActionsOpen" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-3" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-2" class="absolute right-0 z-40 mt-2 w-52 rounded-md bg-white py-1 shadow-lg ring-1 ring-gray-900/10">
		                                                                <button type="button" x-on:click="openCustomFieldTextInput('smsGuidelines'); fieldActionsOpen = false" class="flex w-full items-center gap-2 px-3 py-2 text-left text-sm font-medium text-gray-700 transition hover:bg-gray-50 hover:text-gray-950">
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
		                                                </span>
			                                                <div data-component="custom-field-text-input" class="mt-2 overflow-hidden rounded-md border border-gray-300 bg-white shadow-sm transition focus-within:border-indigo-600 focus-within:ring-1 focus-within:ring-indigo-600">
			                                                    <div class="relative grid min-w-0 overflow-hidden transition-[grid-template-columns] duration-200 ease-out" :class="customFieldTextInputState('smsGuidelines').layoutOpen ? 'lg:grid-cols-[minmax(0,1fr)_18rem]' : 'lg:grid-cols-1'">
			                                                        <textarea x-model="campaignSetup.smsGuidelines" rows="7" class="block min-h-[180px] min-w-0 w-full resize-y border-0 bg-white px-5 py-4 text-sm/6 text-gray-700 outline-none placeholder:text-gray-400 focus:ring-0"></textarea>
			                                                        <aside
			                                                            x-cloak
			                                                            x-show="customFieldTextInputState('smsGuidelines').open"
		                                                            x-transition:enter="transition ease-out duration-200"
		                                                            x-transition:enter-start="translate-x-full opacity-0"
		                                                            x-transition:enter-end="translate-x-0 opacity-100"
		                                                            x-transition:leave="transition ease-in duration-150"
		                                                            x-transition:leave-start="translate-x-0 opacity-100"
		                                                            x-transition:leave-end="translate-x-full opacity-0"
		                                                            class="min-w-0 border-t border-gray-200 bg-white lg:border-t-0 lg:border-l lg:border-gray-200"
			                                                        >
			                                                            <div class="flex items-center gap-2 border-b border-gray-200 px-4 py-3"><label class="min-w-0 flex-1"><input :value="customFieldTextInputState('smsGuidelines').search" x-on:input="customFieldTextInputState('smsGuidelines').search = $event.target.value" type="search" placeholder="Search Custom Fields" class="block h-9 w-full rounded-md bg-white px-3 py-1.5 text-sm text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600"></label><button type="button" x-on:click="closeCustomFieldTextInput('smsGuidelines')" class="inline-flex size-7 items-center justify-center rounded-md text-gray-400 transition hover:bg-white hover:text-gray-700" aria-label="Close custom fields"><span class="outcraft-icon !text-[18px]">close</span></button></div>
			                                                            <div class="flex flex-wrap gap-2 px-4 py-4">
			                                                                <template x-for="tag in filteredCustomFieldTextInputTags('smsGuidelines')" :key="`sms-${tag}`">
			                                                                    <button type="button" class="inline-flex h-8 items-center rounded-md bg-white px-2.5 text-sm font-medium text-gray-600 shadow-sm ring-1 ring-inset ring-gray-200 transition hover:bg-gray-50 hover:text-gray-900" x-text="tag"></button>
			                                                                </template>
			                                                                <p x-show="filteredCustomFieldTextInputTags('smsGuidelines').length === 0" class="text-sm text-gray-500">No Custom Fields Found.</p>
		                                                            </div>
		                                                        </aside>
		                                                    </div>
		                                                </div>
	                                                <span class="mt-2 block text-sm leading-6 text-gray-600">A brief guidelines for the SMS structure, content, length, etc..</span>
	                                            </label>
	                                        </div>
	                                    </div>
	                                </div>

	                                <div class="bg-white">
	                                    <div>
	                                        <div class="flex items-center justify-between gap-4">
	                                            <button type="button" x-on:click="toggleChannel('whatsapp')" role="switch" :aria-checked="campaignSetup.channels.whatsapp" class="inline-flex items-center gap-4 rounded-md text-left focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
	                                                <span class="relative inline-flex h-6 w-11 shrink-0 rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out" :class="campaignSetup.channels.whatsapp ? 'bg-indigo-600' : 'bg-gray-200'">
	                                                    <span class="pointer-events-none inline-block size-5 rounded-full bg-white shadow transition duration-200 ease-in-out" :class="campaignSetup.channels.whatsapp ? 'translate-x-5' : 'translate-x-0'"></span>
	                                                </span>
	                                                <span class="text-sm font-semibold leading-6 text-gray-950">Enable WhatsApp Sending</span>
	                                            </button>
	                                            <button type="button" x-on:click="campaignSetup.channelOpen.whatsapp = ! campaignSetup.channelOpen.whatsapp; scheduleCampaignBuilderLayoutUpdate()" :disabled="! campaignSetup.channels.whatsapp" class="inline-flex h-9 items-center gap-2 rounded-md bg-white px-3 text-sm font-semibold shadow-sm ring-1 ring-inset ring-gray-300 transition hover:bg-gray-50 disabled:cursor-not-allowed disabled:bg-gray-50 disabled:text-gray-400 disabled:ring-gray-200" :class="campaignSetup.channels.whatsapp ? 'text-gray-900' : 'text-gray-400'">
	                                                Configure
	                                                <span class="outcraft-icon !text-[16px] text-gray-400" :class="campaignSetup.channels.whatsapp && campaignSetup.channelOpen.whatsapp ? 'rotate-180' : ''">keyboard_arrow_down</span>
	                                            </button>
	                                        </div>
	                                        <div x-show="campaignSetup.channels.whatsapp && campaignSetup.channelOpen.whatsapp" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-3" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-2" class="mt-6 rounded-lg border border-gray-200 p-5">
	                                            <label class="block">
	                                                <span class="mb-2 flex items-center justify-between gap-3">
	                                                    <span class="block text-sm/6 font-semibold text-gray-900">WhatsApp-Specific Guidelines (optional)</span>
	                                                    <span class="relative" x-data="{ fieldActionsOpen: false }" x-on:click.outside="fieldActionsOpen = false">
	                                                        <button type="button" x-on:click="fieldActionsOpen = ! fieldActionsOpen" class="inline-flex size-7 items-center justify-center rounded-md text-gray-400 transition hover:bg-gray-50 hover:text-gray-700" aria-label="WhatsApp custom field actions">
	                                                            <span class="outcraft-icon !text-[18px]">more_vert</span>
	                                                        </button>
	                                                        <span x-cloak x-show="fieldActionsOpen" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-3" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-2" class="absolute right-0 z-40 mt-2 w-52 rounded-md bg-white py-1 shadow-lg ring-1 ring-gray-900/10">
	                                                            <button type="button" x-on:click="openCustomFieldTextInput('whatsappGuidelines'); fieldActionsOpen = false" class="flex w-full items-center gap-2 px-3 py-2 text-left text-sm font-medium text-gray-700 transition hover:bg-gray-50 hover:text-gray-950">
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
	                                                    <div class="relative grid min-w-0 overflow-hidden transition-[grid-template-columns] duration-200 ease-out" :class="customFieldTextInputState('whatsappGuidelines').layoutOpen ? 'lg:grid-cols-[minmax(0,1fr)_18rem]' : 'lg:grid-cols-1'">
	                                                        <textarea x-model="campaignSetup.whatsappGuidelines" rows="4" placeholder="Add WhatsApp-specific tone, length, and follow-up notes." class="block min-h-[110px] min-w-0 w-full resize-y border-0 bg-white px-5 py-4 text-sm/6 text-gray-700 outline-none placeholder:text-gray-400 focus:ring-0"></textarea>
	                                                        <aside x-cloak x-show="customFieldTextInputState('whatsappGuidelines').open" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="translate-x-full opacity-0" x-transition:enter-end="translate-x-0 opacity-100" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="translate-x-0 opacity-100" x-transition:leave-end="translate-x-full opacity-0" class="min-w-0 border-t border-gray-200 bg-white lg:border-t-0 lg:border-l lg:border-gray-200">
	                                                            <div class="flex items-center gap-2 border-b border-gray-200 px-4 py-3"><label class="min-w-0 flex-1"><input :value="customFieldTextInputState('whatsappGuidelines').search" x-on:input="customFieldTextInputState('whatsappGuidelines').search = $event.target.value" type="search" placeholder="Search Custom Fields" class="block h-9 w-full rounded-md bg-white px-3 py-1.5 text-sm text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600"></label><button type="button" x-on:click="closeCustomFieldTextInput('whatsappGuidelines')" class="inline-flex size-7 items-center justify-center rounded-md text-gray-400 transition hover:bg-white hover:text-gray-700" aria-label="Close custom fields"><span class="outcraft-icon !text-[18px]">close</span></button></div>
	                                                            <div class="flex flex-wrap gap-2 px-4 py-4">
	                                                                <template x-for="tag in filteredCustomFieldTextInputTags('whatsappGuidelines')" :key="`whatsapp-${tag}`"><button type="button" class="inline-flex h-8 items-center rounded-md bg-white px-2.5 text-sm font-medium text-gray-600 shadow-sm ring-1 ring-inset ring-gray-200 transition hover:bg-gray-50 hover:text-gray-900" x-text="tag"></button></template>
	                                                                <p x-show="filteredCustomFieldTextInputTags('whatsappGuidelines').length === 0" class="text-sm text-gray-500">No Custom Fields Found.</p>
	                                                            </div>
	                                                        </aside>
	                                                    </div>
	                                                </div>
	                                                <span class="mt-2 block text-sm leading-6 text-gray-600">A brief guideline for WhatsApp structure, tone, and content.</span>
	                                            </label>
	                                        </div>
	                                    </div>
	                                </div>

	                                <div x-show="campaignSetup.channels.email || campaignSetup.channels.sms || campaignSetup.channels.whatsapp" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-3" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-2" class="overflow-hidden rounded-lg border border-gray-200 bg-white">
	                                    <div class="border-b border-gray-200 px-6 py-5">
	                                        <h3 class="text-base font-semibold text-gray-950">Email &amp; Message Content</h3>
	                                    </div>
	                                    <div class="divide-y divide-gray-200">
	                                        <div class="px-6 py-6">
	                                            <button type="button" x-on:click="campaignSetup.discountCode = ! campaignSetup.discountCode; scheduleCampaignBuilderLayoutUpdate()" role="switch" :aria-checked="campaignSetup.discountCode" class="flex w-full items-start gap-4 rounded-md text-left focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
	                                                <span class="relative mt-1 inline-flex h-6 w-11 shrink-0 rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out" :class="campaignSetup.discountCode ? 'bg-indigo-600' : 'bg-gray-200'">
	                                                    <span class="pointer-events-none inline-block size-5 rounded-full bg-white shadow transition duration-200 ease-in-out" :class="campaignSetup.discountCode ? 'translate-x-5' : 'translate-x-0'"></span>
	                                                </span>
	                                                <span>
	                                                    <span class="block text-sm font-semibold leading-6 text-gray-950">Send a Discount Code</span>
	                                                    <span class="mt-1 block text-sm leading-6 text-gray-600">AI attaches a discount code to the message.</span>
	                                                </span>
	                                            </button>
	                                        </div>

	                                        <div class="px-6 py-6">
	                                            <button type="button" x-on:click="campaignSetup.abandonedCartLink = ! campaignSetup.abandonedCartLink; scheduleCampaignBuilderLayoutUpdate()" role="switch" :aria-checked="campaignSetup.abandonedCartLink" class="flex w-full items-start gap-4 rounded-md text-left focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
	                                                <span class="relative mt-1 inline-flex h-6 w-11 shrink-0 rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out" :class="campaignSetup.abandonedCartLink ? 'bg-indigo-600' : 'bg-gray-200'">
	                                                    <span class="pointer-events-none inline-block size-5 rounded-full bg-white shadow transition duration-200 ease-in-out" :class="campaignSetup.abandonedCartLink ? 'translate-x-5' : 'translate-x-0'"></span>
	                                                </span>
	                                                <span>
	                                                    <span class="block text-sm font-semibold leading-6 text-gray-950">Send an Abandoned Cart Link</span>
	                                                    <span class="mt-1 block text-sm leading-6 text-gray-600">AI attaches a cart recovery link to the message.</span>
	                                                </span>
	                                            </button>
	                                            <div x-show="campaignSetup.abandonedCartLink" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-3" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-2" class="mt-6 space-y-6">
	                                                <div class="rounded-lg bg-gray-50 p-4 ring-1 ring-inset ring-gray-200">
	                                                    <label class="block">
	                                                        <span class="block text-sm/6 font-medium text-gray-900">Link Source</span>
	                                                        <div class="mt-2 grid grid-cols-1">
	                                                            <select x-model="campaignSetup.cartLinkSource" class="col-start-1 row-start-1 block w-full appearance-none rounded-md bg-white py-1.5 pl-3 pr-8 text-sm/6 text-gray-900 shadow-sm outline outline-1 -outline-offset-1 outline-gray-300 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600">
	                                                                <option>Dynamic - Use URL from Lead Data</option>
	                                                                <option>Static - Use Configured URL</option>
	                                                                <option>Generated Checkout URL</option>
	                                                            </select>
	                                                            <span class="outcraft-icon pointer-events-none col-start-1 row-start-1 mr-3 self-center justify-self-end text-gray-500">keyboard_arrow_down</span>
	                                                        </div>
	                                                        <span class="mt-2 block text-sm leading-6 text-gray-500">Where the cart URL comes from.</span>
	                                                    </label>
	                                                </div>

	                                                <button type="button" x-on:click="campaignSetup.customizeCartLink = ! campaignSetup.customizeCartLink; scheduleCampaignBuilderLayoutUpdate()" role="switch" :aria-checked="campaignSetup.customizeCartLink" class="flex w-full items-start gap-4 rounded-md text-left focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
	                                                    <span class="relative mt-1 inline-flex h-6 w-11 shrink-0 rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out" :class="campaignSetup.customizeCartLink ? 'bg-indigo-600' : 'bg-gray-200'">
	                                                        <span class="pointer-events-none inline-block size-5 rounded-full bg-white shadow transition duration-200 ease-in-out" :class="campaignSetup.customizeCartLink ? 'translate-x-5' : 'translate-x-0'"></span>
	                                                    </span>
	                                                    <span>
	                                                        <span class="block text-sm font-semibold leading-6 text-gray-950">Customise Cart Link</span>
	                                                        <span class="mt-1 block text-sm leading-6 text-gray-600">Override the default cart URL structure by setting a custom path and adding tracking parameters.</span>
	                                                    </span>
	                                                </button>

	                                                <div x-show="campaignSetup.customizeCartLink" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-3" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-2" class="space-y-6">
	                                                    <div class="rounded-lg bg-gray-50 p-4 ring-1 ring-inset ring-gray-200">
	                                                        <label class="block">
	                                                            <span class="block text-sm/6 font-medium text-gray-900">Path</span>
	                                                            <input x-model="campaignSetup.cartPath" type="text" placeholder="/checkout" class="mt-2 block w-full rounded-md bg-white px-3 py-1.5 text-sm/6 text-gray-900 shadow-sm outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600">
	                                                            <span class="mt-2 block text-sm leading-6 text-gray-500">Appended to your domain - e.g. /checkout or /cart</span>
	                                                        </label>
	                                                    </div>

	                                                    <div class="rounded-lg bg-gray-50 p-4 ring-1 ring-inset ring-gray-200">
	                                                        <h4 class="text-sm font-medium text-gray-900">UTM Tags</h4>
	                                                        <div class="mt-4 grid gap-4 sm:grid-cols-3">
	                                                            <label class="block">
	                                                                <span class="block text-sm/6 font-medium text-gray-900">Source</span>
	                                                                <input x-model="campaignSetup.utmSource" type="text" placeholder="outcraft" class="mt-2 block w-full rounded-md bg-white px-3 py-1.5 text-sm/6 text-gray-900 shadow-sm outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600">
	                                                            </label>
	                                                            <label class="block">
	                                                                <span class="block text-sm/6 font-medium text-gray-900">Medium</span>
	                                                                <input x-model="campaignSetup.utmMedium" type="text" placeholder="email" class="mt-2 block w-full rounded-md bg-white px-3 py-1.5 text-sm/6 text-gray-900 shadow-sm outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600">
	                                                            </label>
	                                                            <label class="block">
	                                                                <span class="block text-sm/6 font-medium text-gray-900">Campaign</span>
	                                                                <input x-model="campaignSetup.utmCampaign" type="text" placeholder="cart-recovery" class="mt-2 block w-full rounded-md bg-white px-3 py-1.5 text-sm/6 text-gray-900 shadow-sm outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600">
	                                                            </label>
	                                                        </div>
	                                                        <span class="mt-2 block text-sm leading-6 text-gray-500">Builds: ?utm_source=outcraft&amp;utm_medium=email&amp;utm_campaign=cart-recovery</span>
	                                                    </div>

	                                                    <div class="rounded-lg bg-gray-50 p-4 ring-1 ring-inset ring-gray-200">
	                                                        <h4 class="text-sm font-medium text-gray-900">Dynamic Parameters</h4>
	                                                        <div class="mt-4 grid gap-4 sm:grid-cols-[minmax(0,1fr)_minmax(0,1fr)_auto]">
	                                                            <label class="block">
	                                                                <span class="block text-sm/6 font-medium text-gray-900">Parameter Name</span>
	                                                                <input x-model="campaignSetup.dynamicParameterName" type="text" placeholder="affid" class="mt-2 block w-full rounded-md bg-white px-3 py-1.5 text-sm/6 text-gray-900 shadow-sm outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600">
	                                                            </label>
	                                                            <label class="block">
	                                                                <span class="block text-sm/6 font-medium text-gray-900">Value</span>
	                                                                <input x-model="campaignSetup.dynamicParameterValue" type="text" placeholder="Enter Value" class="mt-2 block w-full rounded-md bg-white px-3 py-1.5 text-sm/6 text-gray-900 shadow-sm outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600">
	                                                            </label>
	                                                            <button type="button" class="mt-8 inline-flex size-8 items-center justify-center rounded-md text-gray-400 transition hover:bg-white hover:text-gray-700" aria-label="Remove parameter">
	                                                                <span class="outcraft-icon !text-[18px]">delete</span>
	                                                            </button>
	                                                            <label class="block sm:col-span-1">
	                                                                <span class="sr-only">Parameter Name</span>
	                                                                <input type="text" placeholder="Enter Parameter Name" class="block w-full rounded-md bg-white px-3 py-1.5 text-sm/6 text-gray-900 shadow-sm outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600">
	                                                            </label>
	                                                            <label class="block sm:col-span-1">
	                                                                <span class="sr-only">Value</span>
	                                                                <input type="text" placeholder="Enter Value" class="block w-full rounded-md bg-white px-3 py-1.5 text-sm/6 text-gray-900 shadow-sm outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600">
	                                                            </label>
	                                                            <button type="button" class="inline-flex size-8 items-center justify-center rounded-md text-gray-400 transition hover:bg-white hover:text-gray-700" aria-label="Remove parameter">
	                                                                <span class="outcraft-icon !text-[18px]">delete</span>
	                                                            </button>
	                                                        </div>
	                                                        <span class="mt-2 block text-sm leading-6 text-gray-500">Add any additional tracking keys your platform needs - like affid, sub_id, or click_id.</span>
	                                                        <button type="button" class="mt-4 inline-flex h-9 items-center gap-2 rounded-md bg-white px-3 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 transition hover:bg-gray-50">
	                                                            <span class="outcraft-icon !text-[16px] text-gray-400">add</span>
	                                                            Add Parameter
	                                                        </button>
	                                                    </div>
	                                                </div>
	                                            </div>
	                                        </div>

	                                        <div class="px-6 py-6">
	                                            <button type="button" x-on:click="campaignSetup.shortenLinks = ! campaignSetup.shortenLinks; scheduleCampaignBuilderLayoutUpdate()" role="switch" :aria-checked="campaignSetup.shortenLinks" class="flex w-full items-start gap-4 rounded-md text-left focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
	                                                <span class="relative mt-1 inline-flex h-6 w-11 shrink-0 rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out" :class="campaignSetup.shortenLinks ? 'bg-indigo-600' : 'bg-gray-200'">
	                                                    <span class="pointer-events-none inline-block size-5 rounded-full bg-white shadow transition duration-200 ease-in-out" :class="campaignSetup.shortenLinks ? 'translate-x-5' : 'translate-x-0'"></span>
	                                                </span>
	                                                <span>
	                                                    <span class="block text-sm font-semibold leading-6 text-gray-950">Shorten Links in Messages</span>
	                                                    <span class="mt-1 block text-sm leading-6 text-gray-600">Shorten and add a link identifier to your URL.</span>
	                                                </span>
	                                            </button>
	                                            <div x-show="campaignSetup.shortenLinks" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-3" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-2" class="mt-5 rounded-lg bg-gray-50 p-4 ring-1 ring-inset ring-gray-200">
	                                                <label class="block">
	                                                    <span class="block text-sm/6 font-medium text-gray-900">Link Identifier</span>
	                                                    <input x-model="campaignSetup.shortLinkBrand" type="text" placeholder="pulsetto" class="mt-2 block w-full rounded-md bg-white px-3 py-1.5 text-sm/6 text-gray-900 shadow-sm outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600">
	                                                    <span class="mt-2 block text-sm leading-6 text-gray-500">Resolves to: outcraft.ai/l/@{{brand}}-a1b2c3d4</span>
	                                                </label>
	                                            </div>
	                                        </div>

	                                        <div class="px-6 py-6">
	                                            <label class="block">
	                                                <span class="block text-sm/6 font-semibold text-gray-900">Additional Note <span class="font-normal text-gray-500">(optional)</span></span>
	                                                <span class="mt-1 block text-sm leading-6 text-gray-600">Extra text the AI includes after delivering the offer.</span>
	                                                <textarea x-model="campaignSetup.offerInfo" rows="4" placeholder="e.g. Package usually arrives in 3-5 days." class="mt-3 block w-full rounded-md bg-white px-3 py-2 text-sm/6 text-gray-900 shadow-sm outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600"></textarea>
	                                            </label>
	                                        </div>
	                                    </div>
	                                </div>
	                            </section>

                            <section x-cloak x-show="campaignSetup.current === 'discounts' || campaignSetupScrollFromStep === 'discounts'" x-ref="campaignSetupStep_discounts"
                                :style="campaignSetupStepStyle('discounts')"
                                data-campaign-setup-step
                                class="space-y-6 pr-2 pb-4">
                                <div class="mb-1">
                                    <p class="text-sm font-semibold text-indigo-600" x-text="`${campaignSetupMode === 'fast' ? 'Fast Setup' : 'Advanced Setup'} · Step ${campaignSetupStepIndex('discounts') + 1} of ${campaignSetupStepsForMode().length}`"></p>
                                    <h2 class="mt-2 text-2xl font-bold leading-8 tracking-tight text-gray-950" x-text="campaignSetupHeading('discounts')"></h2>
                                    <p class="mt-2 max-w-3xl text-sm leading-6 text-gray-600" x-text="campaignSetupDescription('discounts')"></p>
                                </div>

                                <form x-on:submit.prevent="addDiscountCode()" class="flex flex-col gap-3 sm:flex-row sm:items-end">
                                    <label class="block min-w-0 flex-1">
                                        <span class="block text-sm/6 font-semibold text-gray-900">Add New Code</span>
                                        <input x-model="campaignSetup.newDiscountCode" type="text" placeholder="e.g. WELCOME10 or SUMMER20" class="mt-2 block w-full rounded-md bg-white px-3 py-1.5 text-sm/6 text-gray-900 shadow-sm outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600">
                                    </label>
                                    <button type="submit" :disabled="! campaignSetup.newDiscountCode.trim()" class="inline-flex h-9 items-center justify-center rounded-md bg-indigo-600 px-3 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-500 disabled:cursor-not-allowed disabled:opacity-40">Add</button>
                                </form>

                                <div class="overflow-x-auto bg-white">
                                    <table class="min-w-full text-left text-sm">
                                        <thead class="border-b border-gray-200">
                                            <tr>
                                                <th class="px-4 py-3 font-semibold text-gray-600">Discount Code</th>
                                                <th class="px-4 py-3 font-semibold text-gray-600">Created</th>
                                                <th class="px-4 py-3 text-right font-semibold text-gray-600"></th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-gray-100">
                                            <template x-for="code in campaignSetup.discountCodes" :key="code.value">
                                                <tr>
                                                    <td class="px-4 py-3 font-semibold text-gray-950" x-text="code.value"></td>
                                                    <td class="px-4 py-3 text-gray-600" x-text="code.created"></td>
                                                    <td class="px-4 py-3 text-right">
                                                        <button type="button" x-on:click="campaignSetup.discountCodes = campaignSetup.discountCodes.filter((item) => item.value !== code.value)" class="text-sm font-semibold text-gray-500 transition hover:text-red-600">Remove</button>
                                                    </td>
                                                </tr>
                                            </template>
                                        </tbody>
                                    </table>
                                    <div x-show="campaignSetup.discountCodes.length === 0" class="border-t border-gray-100 px-6 py-10 text-center">
                                        <p class="text-sm font-medium text-gray-900">No Discount Codes Yet</p>
                                        <p class="mt-1 text-sm leading-6 text-gray-500">Add Codes the AI can include when discount content is enabled.</p>
                                    </div>
                                </div>
                            </section>

                            <section x-cloak x-show="campaignSetup.current === 'booking' || campaignSetupScrollFromStep === 'booking'" x-ref="campaignSetupStep_booking"
                                :style="campaignSetupStepStyle('booking')"
                                data-campaign-setup-step
                                class="space-y-6 pr-2 pb-4">
                                <div class="mb-1">
                                    <p class="text-sm font-semibold text-indigo-600" x-text="`${campaignSetupMode === 'fast' ? 'Fast Setup' : 'Advanced Setup'} · Step ${campaignSetupStepIndex('booking') + 1} of ${campaignSetupStepsForMode().length}`"></p>
                                    <h2 class="mt-2 text-2xl font-bold leading-8 tracking-tight text-gray-950" x-text="campaignSetupHeading('booking')"></h2>
                                    <p class="mt-2 max-w-3xl text-sm leading-6 text-gray-600" x-text="campaignSetupDescription('booking')"></p>
                                </div>

                                <div class="space-y-8">
                                    <label class="block">
                                        <span class="block text-sm/6 font-semibold text-gray-900">Which Calendar Service Do You Use?</span>
                                        <div class="mt-2 grid grid-cols-1">
                                            <select x-model="campaignSetup.calendarService" class="col-start-1 row-start-1 block w-full appearance-none rounded-md bg-white py-1.5 pr-8 pl-3 text-sm/6 text-gray-900 shadow-sm outline outline-1 -outline-offset-1 outline-gray-300 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600">
                                                <option value="">Select an Option</option>
                                                <option>Calendly</option>
                                                <option>HubSpot Meetings</option>
                                                <option>Google Calendar</option>
                                                <option>Cal.com</option>
                                                <option>Custom Booking Service</option>
                                            </select>
                                            <span class="outcraft-icon pointer-events-none col-start-1 row-start-1 mr-3 self-center justify-self-end text-gray-500">keyboard_arrow_down</span>
                                        </div>
                                        <span class="mt-2 block text-sm leading-6 text-gray-600">Select the calendar service you use for booking appointments.</span>
                                    </label>

                                    <div class="rounded-lg border border-gray-200 p-6">
                                        <h3 class="text-sm font-semibold text-gray-900">Links</h3>
                                        <div class="mt-6 space-y-6">
                                            <div class="rounded-md bg-amber-50 p-4 ring-1 ring-inset ring-amber-100">
                                                <div class="flex gap-3">
                                                    <span class="outcraft-icon mt-0.5 text-amber-500">report</span>
                                                    <p class="text-sm leading-6 text-amber-800">The Booking Link for Calls must use the default form settings. Do not add required fields, CAPTCHA, consent checkboxes, or any additional validation. Extra form requirements will prevent the AI agent from completing bookings during calls successfully!</p>
                                                </div>
                                            </div>

                                            <div class="grid gap-6 lg:grid-cols-2">
                                                <label class="block">
                                                    <span class="block text-sm/6 font-semibold text-gray-900">Booking Link for Calls<span class="text-indigo-600">*</span></span>
                                                    <input x-model="campaignSetup.bookingCallLink" type="url" placeholder="https://calendly.com/your-link" class="mt-2 block w-full rounded-md bg-white px-3 py-1.5 text-sm/6 text-gray-900 shadow-sm outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600">
                                                    <span class="mt-2 block text-sm leading-6 text-gray-600">Must contain service name of a calendar, https://hubspot.com/your-link.</span>
                                                </label>

                                                <label class="block">
                                                    <span class="block text-sm/6 font-semibold text-gray-900">Booking Link for Email</span>
                                                    <input x-model="campaignSetup.bookingEmailLink" type="url" placeholder="https://calendly.com/your-link" class="mt-2 block w-full rounded-md bg-white px-3 py-1.5 text-sm/6 text-gray-900 shadow-sm outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600">
                                                    <span class="mt-2 block text-sm leading-6 text-gray-600">Can be any link to a calendar, example https://company.com/calendar or similar.</span>
                                                </label>

                                                <label class="block">
                                                    <span class="block text-sm/6 font-semibold text-gray-900">Booking Link for SMS</span>
                                                    <input x-model="campaignSetup.bookingSmsLink" type="url" placeholder="https://hubspot.com/your-link" class="mt-2 block w-full rounded-md bg-white px-3 py-1.5 text-sm/6 text-gray-900 shadow-sm outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600">
                                                    <span class="mt-2 block text-sm leading-6 text-gray-600">Can be any link to a calendar, example https://company.com/calendar or similar.</span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>

	                            <section x-cloak x-show="campaignSetup.current === 'availability' || campaignSetupScrollFromStep === 'availability'" x-ref="campaignSetupStep_availability"
                                :style="campaignSetupStepStyle('availability')"
                                data-campaign-setup-step
                                class="pr-2 pb-4">
                                <div class="mb-1">
                                    <p class="text-sm font-semibold text-indigo-600" x-text="`${campaignSetupMode === 'fast' ? 'Fast Setup' : 'Advanced Setup'} · Step ${campaignSetupStepIndex('availability') + 1} of ${campaignSetupStepsForMode().length}`"></p>
                                    <h2 class="mt-2 text-2xl font-bold leading-8 tracking-tight text-gray-950" x-text="campaignSetupHeading('availability')"></h2>
                                    <p class="mt-2 mb-8 max-w-3xl text-sm leading-6 text-gray-600" x-text="campaignSetupDescription('availability')"></p>
                                </div>
	                                <div class="bg-white">
	                                    <div>
	                                        <button type="button" x-on:click="campaignSetup.allDay = ! campaignSetup.allDay; scheduleCampaignBuilderLayoutUpdate()" role="switch" :aria-checked="campaignSetup.allDay" class="flex w-full items-start gap-4 rounded-md text-left focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
	                                            <span class="relative mt-1 inline-flex h-6 w-11 shrink-0 rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out" :class="campaignSetup.allDay ? 'bg-indigo-600' : 'bg-gray-200'">
	                                                <span class="pointer-events-none inline-block size-5 rounded-full bg-white shadow transition duration-200 ease-in-out" :class="campaignSetup.allDay ? 'translate-x-5' : 'translate-x-0'"></span>
	                                            </span>
	                                            <span>
	                                                <span class="block text-sm font-semibold leading-6 text-gray-950">Enable 24/7 Outreach</span>
	                                                <span class="mt-1 block text-sm leading-6 text-gray-600">AI can contact leads at any time, regardless of your configured business hours.</span>
	                                            </span>
	                                        </button>

	                                        <fieldset x-show="! campaignSetup.allDay" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-3" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-2" class="mt-7">
	                                            <div class="flex items-center justify-between gap-4">
	                                                <h4 class="text-sm font-semibold leading-6 text-gray-950">Outreach Days</h4>
	                                                <button type="button" x-on:click="selectAllOutreachDays()" class="text-sm font-semibold text-indigo-600 hover:text-indigo-500">Select All</button>
	                                            </div>

	                                            <div class="mt-4 flex flex-col gap-3 sm:flex-row sm:flex-wrap sm:items-center sm:gap-x-6 sm:gap-y-3">
	                                                <template x-for="day in outreachWeekdays" :key="day">
	                                                    <button type="button" x-on:click="toggleOutreachDay(day)" role="checkbox" :aria-checked="campaignSetup.outreachDays.includes(day)" class="inline-flex w-fit items-center gap-3 rounded-md text-sm font-semibold leading-6 text-gray-900 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
	                                                        <span class="inline-flex size-4 items-center justify-center rounded border transition" :class="campaignSetup.outreachDays.includes(day) ? 'border-indigo-600 bg-indigo-600 text-white' : 'border-gray-300 bg-white text-transparent shadow-sm'">
	                                                            <span class="outcraft-icon !text-[12px]">check</span>
	                                                        </span>
	                                                        <span x-text="day"></span>
	                                                    </button>
	                                                </template>
	                                            </div>

	                                            <div class="mt-7 grid gap-6 lg:grid-cols-2">
	                                                <label class="block">
	                                                    <span class="block text-sm/6 font-semibold text-gray-900">Outreach Start Hour<span class="text-indigo-600">*</span></span>
		                                                    <div class="mt-2 grid grid-cols-1">
		                                                        <select x-model="campaignSetup.outreachStartHour" class="col-start-1 row-start-1 block w-full appearance-none rounded-md bg-white py-1.5 pl-3 pr-8 text-sm/6 text-gray-900 shadow-sm outline outline-1 -outline-offset-1 outline-gray-300 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600">
		                                                            <template x-for="hour in outreachHourOptions" :key="`availability-start-${hour}`">
		                                                                <option :value="hour" x-text="hour"></option>
		                                                            </template>
		                                                        </select>
		                                                        <span class="outcraft-icon pointer-events-none col-start-1 row-start-1 mr-3 self-center justify-self-end text-gray-500">keyboard_arrow_down</span>
		                                                    </div>
	                                                    <span class="mt-2 block text-sm leading-6 text-gray-600">The earliest time AI can contact a lead in their local timezone.</span>
	                                                </label>

	                                                <label class="block">
	                                                    <span class="block text-sm/6 font-semibold text-gray-900">Outreach End Hour<span class="text-indigo-600">*</span></span>
		                                                    <div class="mt-2 grid grid-cols-1">
		                                                        <select x-model="campaignSetup.outreachEndHour" class="col-start-1 row-start-1 block w-full appearance-none rounded-md bg-white py-1.5 pl-3 pr-8 text-sm/6 text-gray-900 shadow-sm outline outline-1 -outline-offset-1 outline-gray-300 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600">
		                                                            <template x-for="hour in outreachHourOptions" :key="`availability-end-${hour}`">
		                                                                <option :value="hour" x-text="hour"></option>
		                                                            </template>
		                                                        </select>
		                                                        <span class="outcraft-icon pointer-events-none col-start-1 row-start-1 mr-3 self-center justify-self-end text-gray-500">keyboard_arrow_down</span>
		                                                    </div>
	                                                    <span class="mt-2 block text-sm leading-6 text-gray-600">The latest time AI can contact a lead in their local timezone.</span>
	                                                </label>
	                                            </div>
	                                        </fieldset>

	                                    </div>
	                                </div>
	                            </section>

                            <section x-cloak x-show="campaignSetup.current === 'sequence' || campaignSetupScrollFromStep === 'sequence'" x-ref="campaignSetupStep_sequence"
                                :style="campaignSetupStepStyle('sequence')"
                                data-campaign-setup-step
                                class="space-y-6 pr-2 pb-4">
                                <div class="mb-1">
                                    <p class="text-sm font-semibold text-indigo-600" x-text="`${campaignSetupMode === 'fast' ? 'Fast Setup' : 'Advanced Setup'} · Step ${campaignSetupStepIndex('sequence') + 1} of ${campaignSetupStepsForMode().length}`"></p>
                                    <h2 class="mt-2 text-2xl font-bold leading-8 tracking-tight text-gray-950" x-text="campaignSetupHeading('sequence')"></h2>
                                    <p class="mt-2 max-w-3xl text-sm leading-6 text-gray-600" x-text="campaignSetupDescription('sequence')"></p>
                                </div>
                                <div class="flex flex-wrap items-center justify-between gap-3">
                                    <button type="button" class="inline-flex h-9 items-center rounded-md bg-white px-3 text-sm font-semibold text-gray-900 ring-1 ring-inset ring-gray-300 transition hover:bg-gray-50">Reorder Actions</button>
                                    <button type="button" x-on:click="campaignSetup.sequenceModalOpen = true" class="inline-flex h-9 items-center rounded-md bg-indigo-600 px-3 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-500">Add Step</button>
                                </div>
                                <div class="overflow-hidden rounded-lg border border-gray-200">
                                    <table class="min-w-full divide-y divide-gray-200 text-left text-sm">
                                        <thead class="bg-gray-50">
                                            <tr>
                                                <template x-for="head in ['Channel','Label','Relative Delay','Exact Flow Step','Actions']" :key="head">
                                                    <th class="px-4 py-3 font-semibold text-gray-600" x-text="head"></th>
                                                </template>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-gray-100">
                                            <template x-for="row in sequenceRows" :key="`${row.channel}-${row.delay}-${row.label}`">
                                                <tr>
                                                    <td class="px-4 py-3" x-text="row.channel"></td>
                                                    <td class="px-4 py-3 font-mono text-xs" x-text="row.label"></td>
                                                    <td class="px-4 py-3" x-text="row.delay"></td>
                                                    <td class="px-4 py-3 text-gray-600" x-text="row.step"></td>
                                                    <td class="px-4 py-3">
                                                        <div class="flex items-center gap-3 whitespace-nowrap">
                                                            <button type="button" class="font-semibold text-indigo-600 transition hover:text-indigo-500">Edit</button>
                                                            <button type="button" x-show="row.channel !== 'None'" class="font-semibold text-gray-600 transition hover:text-gray-900">View</button>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </template>
                                        </tbody>
                                    </table>
                                </div>
                            </section>

                            <section x-cloak x-show="campaignSetup.current === 'followups' || campaignSetupScrollFromStep === 'followups'" x-ref="campaignSetupStep_followups"
                                :style="campaignSetupStepStyle('followups')"
                                data-campaign-setup-step
                                class="space-y-6 pr-2 pb-4">
                                <div class="mb-1">
                                    <p class="text-sm font-semibold text-indigo-600" x-text="`${campaignSetupMode === 'fast' ? 'Fast Setup' : 'Advanced Setup'} · Step ${campaignSetupStepIndex('followups') + 1} of ${campaignSetupStepsForMode().length}`"></p>
                                    <h2 class="mt-2 text-2xl font-bold leading-8 tracking-tight text-gray-950" x-text="campaignSetupHeading('followups')"></h2>
                                    <p class="mt-2 max-w-3xl text-sm leading-6 text-gray-600" x-text="campaignSetupDescription('followups')"></p>
                                </div>
                                    <div class="space-y-5">
                                            <button type="button" x-on:click="campaignSetup.followupPositive = ! campaignSetup.followupPositive; scheduleCampaignBuilderLayoutUpdate()" role="switch" :aria-checked="campaignSetup.followupPositive" class="flex w-full items-start gap-4 rounded-md text-left focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                                                <span class="relative mt-1 inline-flex h-6 w-11 shrink-0 rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out" :class="campaignSetup.followupPositive ? 'bg-indigo-600' : 'bg-gray-200'">
                                                    <span class="pointer-events-none inline-block size-5 rounded-full bg-white shadow transition duration-200 ease-in-out" :class="campaignSetup.followupPositive ? 'translate-x-5' : 'translate-x-0'"></span>
                                                </span>
                                                <span class="min-w-0">
                                                    <span class="block text-sm font-semibold leading-6 text-gray-950">After a Positive Response</span>
                                                    <span class="mt-1 block text-sm leading-6 text-gray-600">Follow up to confirm the next step, share details, or check if the lead needs anything else.</span>
                                                </span>
                                            </button>

                                            <button type="button" x-on:click="campaignSetup.followupEngaged = ! campaignSetup.followupEngaged; scheduleCampaignBuilderLayoutUpdate()" role="switch" :aria-checked="campaignSetup.followupEngaged" class="flex w-full items-start gap-4 rounded-md text-left focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                                                <span class="relative mt-1 inline-flex h-6 w-11 shrink-0 rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out" :class="campaignSetup.followupEngaged ? 'bg-indigo-600' : 'bg-gray-200'">
                                                    <span class="pointer-events-none inline-block size-5 rounded-full bg-white shadow transition duration-200 ease-in-out" :class="campaignSetup.followupEngaged ? 'translate-x-5' : 'translate-x-0'"></span>
                                                </span>
                                                <span class="min-w-0">
                                                    <span class="block text-sm font-semibold leading-6 text-gray-950">When a Lead Is Engaged but Undecided</span>
                                                    <span class="mt-1 block text-sm leading-6 text-gray-600">Follow up to answer questions and help the lead move toward a clear yes or no.</span>
                                                </span>
                                            </button>

                                            <button type="button" x-on:click="campaignSetup.followupNegative = ! campaignSetup.followupNegative; scheduleCampaignBuilderLayoutUpdate()" role="switch" :aria-checked="campaignSetup.followupNegative" class="flex w-full items-start gap-4 rounded-md text-left focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                                                <span class="relative mt-1 inline-flex h-6 w-11 shrink-0 rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out" :class="campaignSetup.followupNegative ? 'bg-indigo-600' : 'bg-gray-200'">
                                                    <span class="pointer-events-none inline-block size-5 rounded-full bg-white shadow transition duration-200 ease-in-out" :class="campaignSetup.followupNegative ? 'translate-x-5' : 'translate-x-0'"></span>
                                                </span>
                                                <span class="min-w-0">
                                                    <span class="block text-sm font-semibold leading-6 text-gray-950">After a Negative Response</span>
                                                    <span class="mt-1 block text-sm leading-6 text-gray-600">Follow up only when there may still be an opportunity to address concerns or objections.</span>
                                                </span>
                                            </button>
                                    </div>

                                    <div x-show="campaignSetup.followupPositive || campaignSetup.followupEngaged || campaignSetup.followupNegative" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-3" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-2" class="space-y-5">
                                        <div>
                                            <h3 class="text-base font-semibold leading-6 text-gray-950">Follow-Up Sequence</h3>
                                            <p class="mt-2 text-sm leading-6 text-gray-600">Build a follow-up sequence that will be applied for this campaign</p>
                                        </div>
                                        <label class="block max-w-xs">
                                            <span class="block text-sm/6 font-semibold text-gray-900">Choose Follow-Up Sequence to Edit:</span>
                                            <div class="mt-2 grid grid-cols-1">
                                                <select class="col-start-1 row-start-1 block w-full appearance-none rounded-md bg-white py-1.5 pr-8 pl-3 text-sm/6 text-gray-900 shadow-sm outline outline-1 -outline-offset-1 outline-gray-300 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600">
                                                    <option>Positive</option>
                                                    <option>Engaged but No Decision</option>
                                                    <option>Negative Response</option>
                                                </select>
                                                <span class="outcraft-icon pointer-events-none col-start-1 row-start-1 mr-3 self-center justify-self-end text-gray-500">keyboard_arrow_down</span>
                                            </div>
                                        </label>

                                        <div class="flex flex-wrap items-center justify-between gap-3">
                                            <button type="button" class="inline-flex h-9 items-center rounded-md bg-white px-3 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 transition hover:bg-gray-50">Reorder Actions</button>
                                            <button type="button" x-on:click="campaignSetup.followupModalOpen = true" class="inline-flex h-9 items-center rounded-md bg-indigo-600 px-3 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-500">Add Step</button>
                                        </div>

                                        <div class="overflow-hidden rounded-lg border border-gray-200">
                                            <table class="min-w-full divide-y divide-gray-200 text-left text-sm">
                                                <thead class="bg-gray-50">
                                                    <tr>
                                                        <template x-for="head in ['Channel','Label','Relative Delay','Exact Flow Step']" :key="head">
                                                            <th class="px-4 py-3 font-semibold text-gray-600" x-text="head"></th>
                                                        </template>
                                                    </tr>
                                                </thead>
                                            </table>
                                            <div class="flex min-h-56 flex-col items-center justify-center border-t border-gray-100 px-6 py-10 text-center">
                                                <span class="flex size-12 items-center justify-center rounded-full bg-gray-100 text-gray-400">
                                                    <span class="outcraft-icon !text-[24px]">close</span>
                                                </span>
                                                <h4 class="mt-5 text-base font-bold text-gray-950">No Flow Template Steps</h4>
                                            </div>
                                        </div>
                                    </div>
                            </section>

                            <section x-cloak x-show="campaignSetup.current === 'handoff' || campaignSetupScrollFromStep === 'handoff'" x-ref="campaignSetupStep_handoff"
                                :style="campaignSetupStepStyle('handoff')"
                                data-campaign-setup-step
                                class="space-y-6 pr-2 pb-4">
                                <div class="mb-1">
                                    <p class="text-sm font-semibold text-indigo-600" x-text="`${campaignSetupMode === 'fast' ? 'Fast Setup' : 'Advanced Setup'} · Step ${campaignSetupStepIndex('handoff') + 1} of ${campaignSetupStepsForMode().length}`"></p>
                                    <h2 class="mt-2 text-2xl font-bold leading-8 tracking-tight text-gray-950" x-text="campaignSetupHeading('handoff')"></h2>
                                    <p class="mt-2 max-w-3xl text-sm leading-6 text-gray-600" x-text="campaignSetupDescription('handoff')"></p>
                                </div>
                                <div class="overflow-hidden rounded-lg border border-gray-200 bg-white">
                                    <div class="divide-y divide-gray-200">
                                        <div class="px-6 py-6">
                                            <button type="button" x-on:click="campaignSetup.handoffPositive = ! campaignSetup.handoffPositive; scheduleCampaignBuilderLayoutUpdate()" role="switch" :aria-checked="campaignSetup.handoffPositive" class="flex w-full items-start gap-4 rounded-md text-left focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                                                <span class="relative mt-1 inline-flex h-6 w-11 shrink-0 rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out" :class="campaignSetup.handoffPositive ? 'bg-indigo-600' : 'bg-gray-200'">
                                                    <span class="pointer-events-none inline-block size-5 rounded-full bg-white shadow transition duration-200 ease-in-out" :class="campaignSetup.handoffPositive ? 'translate-x-5' : 'translate-x-0'"></span>
                                                </span>
                                                <span class="min-w-0">
                                                    <span class="block text-sm font-semibold leading-6 text-gray-950">Hand Off After a Positive Reply</span>
                                                    <span class="mt-1 block text-sm leading-6 text-gray-600">AI passes the conversation to a human when the lead responds positively.</span>
                                                </span>
                                            </button>

                                            <div x-show="campaignSetup.handoffPositive" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-3" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-2" class="mt-6">
                                                <label class="block">
                                                    <span class="block text-sm/6 font-medium text-gray-900">Handoff Trigger Scenarios</span>
                                                    <div class="mt-2 grid grid-cols-1">
                                                        <select x-model="campaignSetup.handoffScenario" class="col-start-1 row-start-1 block w-full appearance-none rounded-md bg-white py-1.5 pl-3 pr-8 text-sm/6 text-gray-900 shadow-sm outline outline-1 -outline-offset-1 outline-gray-300 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600">
                                                            <option value="">Type Your Own or Select Common Scenario</option>
                                                            <option>Positive Reply</option>
                                                            <option>Pricing Request</option>
                                                            <option>Legal or Compliance Question</option>
                                                            <option>Lead Asks for Human Help</option>
                                                        </select>
                                                        <span class="outcraft-icon pointer-events-none col-start-1 row-start-1 mr-3 self-center justify-self-end text-gray-500">keyboard_arrow_down</span>
                                                    </div>
                                                    <span class="mt-2 block text-sm leading-6 text-gray-500">Situations where AI should pass to a human agent.</span>
                                                </label>
                                            </div>
                                        </div>

                                        <div class="px-6 py-6">
                                            <button type="button" x-on:click="campaignSetup.handoffRequested = ! campaignSetup.handoffRequested; scheduleCampaignBuilderLayoutUpdate()" role="switch" :aria-checked="campaignSetup.handoffRequested" class="flex w-full items-start gap-4 rounded-md text-left focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                                                <span class="relative mt-1 inline-flex h-6 w-11 shrink-0 rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out" :class="campaignSetup.handoffRequested ? 'bg-indigo-600' : 'bg-gray-200'">
                                                    <span class="pointer-events-none inline-block size-5 rounded-full bg-white shadow transition duration-200 ease-in-out" :class="campaignSetup.handoffRequested ? 'translate-x-5' : 'translate-x-0'"></span>
                                                </span>
                                                <span class="min-w-0">
                                                    <span class="block text-sm font-semibold leading-6 text-gray-950">Hand Off When the Lead Asks</span>
                                                    <span class="mt-1 block text-sm leading-6 text-gray-600">AI passes the conversation when the lead explicitly requests a human.</span>
                                                </span>
                                            </button>

                                            <div x-show="campaignSetup.handoffRequested" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-3" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-2" class="mt-6">
                                                <label class="block">
                                                    <span class="block text-sm/6 font-medium text-gray-900">Handoff Channel</span>
                                                    <div class="mt-2 grid grid-cols-1">
                                                        <select x-model="campaignSetup.handoffChannel" class="col-start-1 row-start-1 block w-full appearance-none rounded-md bg-white py-1.5 pl-3 pr-8 text-sm/6 text-gray-900 shadow-sm outline outline-1 -outline-offset-1 outline-gray-300 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600">
                                                            <option value="">Select a Channel</option>
                                                            <option>Email</option>
                                                            <option>Slack</option>
                                                            <option>CRM Task</option>
                                                            <option>Webhook</option>
                                                            <option>Internal Dashboard</option>
                                                        </select>
                                                        <span class="outcraft-icon pointer-events-none col-start-1 row-start-1 mr-3 self-center justify-self-end text-gray-500">keyboard_arrow_down</span>
                                                    </div>
                                                    <span class="mt-2 block text-sm leading-6 text-gray-500">How the human agent is notified.</span>
                                                </label>
                                            </div>
                                        </div>

                                        <div class="px-6 py-6">
                                            <label class="block">
                                                <span class="block text-sm/6 font-semibold text-gray-900">Handoff Notification Email</span>
                                                <input x-model="campaignSetup.handoffNotificationEmail" type="email" placeholder="support@pulsetto.com" class="mt-2 block w-full rounded-md bg-white px-3 py-1.5 text-sm/6 text-gray-900 shadow-sm outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600">
                                                <span class="mt-2 block text-sm leading-6 text-gray-600">Where to send a notification when the AI hands off a conversation to a human.</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </section>

                            <section x-cloak x-show="campaignSetup.current === 'intelligence' || campaignSetupScrollFromStep === 'intelligence'" x-ref="campaignSetupStep_intelligence"
                                :style="campaignSetupStepStyle('intelligence')"
                                data-campaign-setup-step
                                class="space-y-6 pr-2 pb-4">
                                <div class="mb-1">
                                    <p class="text-sm font-semibold text-indigo-600" x-text="`${campaignSetupMode === 'fast' ? 'Fast Setup' : 'Advanced Setup'} · Step ${campaignSetupStepIndex('intelligence') + 1} of ${campaignSetupStepsForMode().length}`"></p>
                                    <h2 class="mt-2 text-2xl font-bold leading-8 tracking-tight text-gray-950" x-text="campaignSetupHeading('intelligence')"></h2>
                                    <p class="mt-2 max-w-3xl text-sm leading-6 text-gray-600" x-text="campaignSetupDescription('intelligence')"></p>
                                </div>
                                <div class="flex justify-end">
                                    <button type="button" x-on:click="campaignSetup.evaluationDrawerOpen = true" class="inline-flex h-9 items-center rounded-md bg-indigo-600 px-3 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-500">Create New Evaluation</button>
                                </div>
                                <div class="overflow-hidden rounded-lg border border-gray-200"><table class="min-w-full divide-y divide-gray-200 text-left text-sm"><thead class="bg-gray-50"><tr><th class="px-4 py-3 font-semibold text-gray-600">Evaluation</th><th class="px-4 py-3 font-semibold text-gray-600">Response Format</th><th class="px-4 py-3 font-semibold text-gray-600">Actions</th></tr></thead><tbody><tr><td class="px-4 py-3"><p class="font-semibold text-gray-950">Summary of the interaction</p><p class="mt-1 text-gray-500">Summarize the interaction in 1–2 short sentences.</p></td><td class="px-4 py-3">Text Summary</td><td class="px-4 py-3"><button class="font-semibold text-indigo-600">Edit</button></td></tr></tbody></table></div>
                            </section>

                            <section x-cloak x-show="campaignSetup.current === 'geo' || campaignSetupScrollFromStep === 'geo'" x-ref="campaignSetupStep_geo"
                                :style="campaignSetupStepStyle('geo')"
                                data-campaign-setup-step
                                class="space-y-5 pr-2 pb-4">
                                <div class="mb-1">
                                    <p class="text-sm font-semibold text-indigo-600" x-text="`${campaignSetupMode === 'fast' ? 'Fast Setup' : 'Advanced Setup'} · Step ${campaignSetupStepIndex('geo') + 1} of ${campaignSetupStepsForMode().length}`"></p>
                                    <h2 class="mt-2 text-2xl font-bold leading-8 tracking-tight text-gray-950" x-text="campaignSetupHeading('geo')"></h2>
                                    <p class="mt-2 max-w-3xl text-sm leading-6 text-gray-600" x-text="campaignSetupDescription('geo')"></p>
                                </div>
                                <div class="flex flex-wrap gap-3"><input type="search" placeholder="Search Countries" class="h-9 rounded-md px-3 text-sm outline outline-1 -outline-offset-1 outline-gray-300"><template x-for="filter in ['All','Enabled','Disabled']" :key="filter"><button class="rounded-md bg-white px-3 text-sm font-semibold ring-1 ring-inset ring-gray-300" x-text="filter"></button></template></div>
                                <div class="flex flex-wrap gap-2"><template x-for="action in ['Select All','Disable All','Enable EU Only','Enable North America Only']" :key="action"><button class="rounded-md bg-white px-3 py-2 text-sm font-semibold ring-1 ring-inset ring-gray-300" x-text="action"></button></template></div>
                                <div class="overflow-hidden rounded-lg border border-gray-200"><table class="min-w-full divide-y divide-gray-200 text-left text-sm"><thead class="bg-gray-50"><tr><template x-for="head in ['Country','Code','Prefix','Region','Calls','SMS','Email']" :key="head"><th class="px-4 py-3 font-semibold text-gray-600" x-text="head"></th></template></tr></thead><tbody class="divide-y divide-gray-100"><template x-for="country in geoCountries" :key="country.code"><tr><td class="px-4 py-3" x-text="country.name"></td><td class="px-4 py-3" x-text="country.code"></td><td class="px-4 py-3" x-text="country.prefix"></td><td class="px-4 py-3" x-text="country.region"></td><td class="px-4 py-3" x-html="miniSwitch(true)"></td><td class="px-4 py-3" x-html="miniSwitch(true)"></td><td class="px-4 py-3" x-html="miniSwitch(true)"></td></tr></template></tbody></table></div>
                            </section>

                            <section x-cloak x-show="campaignSetup.current === 'dispatch' || campaignSetupScrollFromStep === 'dispatch'" x-ref="campaignSetupStep_dispatch"
                                :style="campaignSetupStepStyle('dispatch')"
                                data-campaign-setup-step
                                class="space-y-6 pr-2 pb-4">
                                <div class="mb-1">
                                    <p class="text-sm font-semibold text-indigo-600" x-text="`${campaignSetupMode === 'fast' ? 'Fast Setup' : 'Advanced Setup'} · Step ${campaignSetupStepIndex('dispatch') + 1} of ${campaignSetupStepsForMode().length}`"></p>
                                    <h2 class="mt-2 text-2xl font-bold leading-8 tracking-tight text-gray-950" x-text="campaignSetupHeading('dispatch')"></h2>
                                    <p class="mt-2 max-w-3xl text-sm leading-6 text-gray-600" x-text="campaignSetupDescription('dispatch')"></p>
                                </div>
                                <div class="rounded-lg border border-dashed border-gray-300 bg-gray-50 p-10 text-center">
                                <h3 class="text-sm font-bold text-gray-950">No Campaign Dispatch Conditions</h3>
                                <p class="mt-2 text-sm text-gray-500">Create a campaign dispatch condition set to control which leads qualify for this campaign.</p>
                                <button type="button" x-on:click="campaignSetup.dispatchDrawerOpen = true" class="mt-5 inline-flex h-9 items-center rounded-md bg-indigo-600 px-3 text-sm font-semibold text-white">Add Condition Set</button>
                            </div>
                            </section>

                            <section x-cloak x-show="campaignSetup.current === 'priority' || campaignSetupScrollFromStep === 'priority'" x-ref="campaignSetupStep_priority"
                                :style="campaignSetupStepStyle('priority')"
                                data-campaign-setup-step
                                class="space-y-6 pr-2 pb-4">
                                <div class="mb-1">
                                    <p class="text-sm font-semibold text-indigo-600" x-text="`${campaignSetupMode === 'fast' ? 'Fast Setup' : 'Advanced Setup'} · Step ${campaignSetupStepIndex('priority') + 1} of ${campaignSetupStepsForMode().length}`"></p>
                                    <h2 class="mt-2 text-2xl font-bold leading-8 tracking-tight text-gray-950" x-text="campaignSetupHeading('priority')"></h2>
                                    <p class="mt-2 max-w-3xl text-sm leading-6 text-gray-600" x-text="campaignSetupDescription('priority')"></p>
                                </div>
                                <div class="rounded-lg border border-dashed border-gray-300 bg-gray-50 p-10 text-center">
                                <h3 class="text-sm font-bold text-gray-950">No Campaign Overrides</h3>
                                <p class="mt-2 text-sm text-gray-500">Create a campaign override to decide which campaign should run when multiple campaigns qualify.</p>
                                <button type="button" x-on:click="campaignSetup.overrideModalOpen = true" class="mt-5 inline-flex h-9 items-center rounded-md bg-indigo-600 px-3 text-sm font-semibold text-white">Add Override Rule</button>
                            </div>
                            </section>

                            <section x-cloak x-show="campaignSetup.current === 'review' || campaignSetupScrollFromStep === 'review'" x-ref="campaignSetupStep_review"
                                :style="campaignSetupStepStyle('review')"
                                data-campaign-setup-step
                                class="space-y-6 pr-2 pb-4">
                                <div class="mb-1">
                                    <p class="text-sm font-semibold text-indigo-600" x-text="`${campaignSetupMode === 'fast' ? 'Fast Setup' : 'Advanced Setup'} · Step ${campaignSetupStepIndex('review') + 1} of ${campaignSetupStepsForMode().length}`"></p>
                                    <h2 class="mt-2 text-2xl font-bold leading-8 tracking-tight text-gray-950" x-text="campaignSetupHeading('review')"></h2>
                                    <p class="mt-2 max-w-3xl text-sm leading-6 text-gray-600" x-text="campaignSetupDescription('review')"></p>
                                </div>
                                <label class="block max-w-xl">
                                    <span class="block text-sm/6 font-semibold text-gray-900">Campaign Name</span>
                                    <input x-model="campaignSetup.name" type="text" placeholder="Generated automatically if left empty" class="mt-2 block w-full rounded-md bg-white px-3 py-1.5 text-sm/6 text-gray-900 shadow-sm outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600">
                                    <span class="mt-2 block text-sm leading-6 text-gray-500">Add a name now, or leave it empty and AI will assign one.</span>
                                </label>
                                <div class="rounded-lg border border-gray-200 bg-gray-50 p-5">
                                    <h3 class="text-base font-bold text-gray-950">Publish Knowledge Base Changes</h3>
                                    <p class="mt-2 text-sm leading-6 text-gray-600">Before you can start using your campaign, review and publish the changes made to the knowledgebase during setup. You can update your knowledgebase later if needed.</p>
                                    <div class="mt-5 flex flex-wrap gap-3">
                                        <button type="button" x-on:click="campaignSetup.knowledgePublished = true" class="inline-flex h-9 items-center rounded-md bg-white px-3 text-sm font-semibold text-gray-900 ring-1 ring-inset ring-gray-300">Review & Publish</button>
                                        <button type="button" class="inline-flex h-9 items-center rounded-md bg-indigo-600 px-3 text-sm font-semibold text-white" x-text="campaignSetupMode === 'fast' ? 'Test Campaign' : 'Test Campaign'"></button>
                                        <button type="button" x-show="campaignSetupMode === 'fast'" x-on:click="continueCampaignSetupAdvanced()" class="inline-flex h-9 items-center rounded-md bg-white px-3 text-sm font-semibold text-gray-900 ring-1 ring-inset ring-gray-300">Continue to Advanced Setup</button>
                                        <button type="button" x-show="campaignSetupMode === 'advanced'" :disabled="launchBlocked()" class="inline-flex h-9 items-center rounded-md bg-indigo-600 px-3 text-sm font-semibold text-white disabled:cursor-not-allowed disabled:opacity-40">Launch Campaign</button>
                                    </div>
                                </div>
                            </section>
                        </div>

	                        <div x-cloak x-show="campaignSetupModeSelected && ! campaignSetupIntroStep" class="fixed inset-x-0 bottom-0 z-40 flex border-t border-gray-200 bg-white/95 px-4 py-3 backdrop-blur lg:px-0 lg:py-4" :style="campaignSetupActionBarStyle">
                            <div class="flex w-full items-center justify-between gap-3" :style="campaignSetupActionBarContentStyle">
                                <button type="button" x-on:click="previousCampaignSetupStep()" :disabled="campaignSetupStepIndex() === 0" class="inline-flex h-9 items-center gap-2 rounded-md px-2 text-sm font-semibold text-gray-600 transition hover:bg-gray-50 hover:text-gray-950 disabled:cursor-not-allowed disabled:opacity-40">
                                    <span class="outcraft-icon !text-[18px]">arrow_upward</span>
                                    Back
                                </button>
                                <button type="button" x-on:click="nextCampaignSetupStep()" class="inline-flex h-9 min-w-0 items-center gap-2 rounded-md bg-indigo-600 px-3 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-500">
                                    <span class="truncate" x-text="campaignSetupContinueLabel()"></span>
                                    <span class="outcraft-icon !text-[18px]" x-text="campaignSetupContinueIcon()"></span>
                                </button>
                            </div>
                        </div>

                        <div x-cloak x-show="campaignSetup.sequenceModalOpen || campaignSetup.followupModalOpen || campaignSetup.discountCodeModalOpen || campaignSetup.overrideModalOpen" class="fixed inset-0 z-50 flex items-center justify-center bg-gray-950/30 p-4">
                            <div class="w-full max-w-lg rounded-lg bg-white p-6 shadow-2xl">
                                <h2 class="text-lg font-bold text-gray-950" x-text="campaignSetup.overrideModalOpen ? 'Create Campaign Override' : (campaignSetup.discountCodeModalOpen ? 'Add Discount Code' : (campaignSetup.followupModalOpen ? 'Create Flow Template Step' : 'Create Outreach Sequence Step'))"></h2>
                                <div class="mt-5 space-y-4">
                                    <template x-if="campaignSetup.sequenceModalOpen"><div class="grid gap-4"><label class="block"><span class="text-sm font-medium text-gray-900">Channel</span><select class="mt-2 block w-full rounded-md px-3 py-2 text-sm outline outline-1 -outline-offset-1 outline-gray-300"><option>Call</option><option>SMS</option><option>Email</option><option>WhatsApp</option><option>None</option></select></label><label class="block"><span class="text-sm font-medium text-gray-900">Label</span><input type="text" placeholder="initial_call" class="mt-2 block w-full rounded-md px-3 py-1.5 text-sm outline outline-1 -outline-offset-1 outline-gray-300"></label><label class="block"><span class="text-sm font-medium text-gray-900">Action / Flow Step</span><select class="mt-2 block w-full rounded-md px-3 py-2 text-sm outline outline-1 -outline-offset-1 outline-gray-300"><option>Select an Option</option></select></label><label class="block"><span class="text-sm font-medium text-gray-900">Wait Before Sending</span><input type="number" value="1" class="mt-2 block w-full rounded-md px-3 py-1.5 text-sm outline outline-1 -outline-offset-1 outline-gray-300"><span class="mt-2 block text-sm text-gray-500">This delay starts after the previous step is completed.</span></label></div></template>
                                    <template x-if="campaignSetup.followupModalOpen"><div class="grid gap-4"><label class="block"><span class="text-sm font-medium text-gray-900">Choose Step</span><select class="mt-2 block w-full rounded-md px-3 py-2 text-sm outline outline-1 -outline-offset-1 outline-gray-300"><option>Select an Option</option></select></label><label class="block"><span class="text-sm font-medium text-gray-900">Delay Dispatch By</span><input type="number" value="0" class="mt-2 block w-full rounded-md px-3 py-1.5 text-sm outline outline-1 -outline-offset-1 outline-gray-300"><span class="mt-2 block text-sm text-gray-500">Will delay this step after the previous step was dispatched.</span></label></div></template>
                                    <template x-if="campaignSetup.discountCodeModalOpen"><div class="grid gap-4"><label class="block"><span class="text-sm font-medium text-gray-900">Discount Code</span><input x-model="campaignSetup.newDiscountCode" type="text" placeholder="25OFF" class="mt-2 block w-full rounded-md px-3 py-1.5 text-sm outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600"><span class="mt-2 block text-sm text-gray-500">Code to include - e.g. SUMMER20, WELCOME10.</span></label></div></template>
                                    <template x-if="campaignSetup.overrideModalOpen"><div class="grid gap-4"><button type="button" class="flex items-start justify-between gap-4 rounded-lg border border-gray-200 p-4 text-left"><span><span class="block text-sm font-medium text-gray-900">Allow Override All Campaigns?</span><span class="mt-1 block text-sm text-gray-500">If enabled, this campaign will have priority over any already running campaign once triggered.</span></span><span class="relative inline-flex h-6 w-11 rounded-full bg-gray-200 p-0.5"><span class="size-5 rounded-full bg-white shadow-sm"></span></span></button><label class="block"><span class="text-sm font-medium text-gray-900">Which Campaign Should Current Campaign Override?</span><select class="mt-2 block w-full rounded-md px-3 py-2 text-sm outline outline-1 -outline-offset-1 outline-gray-300"><option>Select an Option</option><option>Abandoned Cart Recovery</option><option>Web Support</option></select></label></div></template>
                                </div>
                                <div class="mt-6 flex justify-end gap-3"><button type="button" x-on:click="closeCampaignSetupOverlays()" class="inline-flex h-9 items-center rounded-md bg-white px-3 text-sm font-semibold text-gray-900 ring-1 ring-inset ring-gray-300">Cancel</button><button type="button" x-on:click="campaignSetup.discountCodeModalOpen ? addDiscountCode() : closeCampaignSetupOverlays()" class="inline-flex h-9 items-center rounded-md bg-indigo-600 px-3 text-sm font-semibold text-white" x-text="campaignSetup.discountCodeModalOpen ? 'Add Code' : 'Create'"></button></div>
                            </div>
                        </div>

                        <div x-cloak x-show="campaignSetup.evaluationDrawerOpen || campaignSetup.dispatchDrawerOpen" class="fixed inset-0 z-50 flex justify-end bg-gray-950/30">
                            <div class="h-full w-full max-w-xl overflow-auto bg-white p-6 shadow-2xl">
                                <div class="flex items-start justify-between gap-4">
                                    <div><h2 class="text-xl font-bold text-gray-950" x-text="campaignSetup.dispatchDrawerOpen ? 'Create Campaign Dispatch Condition Set' : 'Create AI Evaluation'"></h2><p class="mt-2 text-sm leading-6 text-gray-500" x-text="campaignSetup.dispatchDrawerOpen ? 'Define lead metadata rules for this campaign.' : 'Choose what signals, behaviours, or insights the AI should detect from conversations.'"></p></div>
                                    <button type="button" x-on:click="closeCampaignSetupOverlays()" class="rounded-md p-2 text-gray-400 hover:bg-gray-50"><span class="outcraft-icon">close</span></button>
                                </div>
                                <div x-show="campaignSetup.evaluationDrawerOpen" class="mt-6 space-y-5">
                                    <label class="block"><span class="text-sm font-medium text-gray-900">Display Name</span><input type="text" placeholder="Purchase Intent" class="mt-2 block w-full rounded-md px-3 py-1.5 text-sm outline outline-1 -outline-offset-1 outline-gray-300"><span class="mt-2 block text-sm text-gray-500">A clear name used to identify this evaluation in conversation insights and analytics.</span></label>
                                    <div><p class="text-sm font-medium text-gray-900">Response Format</p><div class="mt-2 grid grid-cols-2 gap-3"><template x-for="format in ['Yes / No','Text Summary','Classified','Score']" :key="format"><button type="button" x-on:click="campaignSetup.evaluationFormat = format" class="rounded-lg border p-4 text-left" :class="campaignSetup.evaluationFormat === format ? 'border-indigo-600 ring-2 ring-indigo-100' : 'border-gray-200'"><span class="block text-sm font-bold text-gray-950" x-text="format"></span><span class="mt-1 block text-xs leading-5 text-gray-500" x-text="evaluationFormatDescription(format)"></span></button></template></div></div>
                                    <label class="block"><span class="text-sm font-medium text-gray-900">Evaluation Instruction</span><textarea rows="4" class="mt-2 block w-full rounded-md px-3 py-1.5 text-sm outline outline-1 -outline-offset-1 outline-gray-300"></textarea></label>
                                    <div x-show="campaignSetup.evaluationFormat === 'Yes / No'" class="grid gap-4"><textarea rows="3" placeholder="What should count as Yes?" class="rounded-md px-3 py-1.5 text-sm outline outline-1 -outline-offset-1 outline-gray-300"></textarea><textarea rows="3" placeholder="What should count as No?" class="rounded-md px-3 py-1.5 text-sm outline outline-1 -outline-offset-1 outline-gray-300"></textarea></div>
                                    <div x-show="campaignSetup.evaluationFormat === 'Text Summary'" class="grid gap-4"><textarea rows="3" placeholder="What Should Be Summarized?" class="rounded-md px-3 py-1.5 text-sm outline outline-1 -outline-offset-1 outline-gray-300"></textarea><select class="rounded-md px-3 py-2 text-sm outline outline-1 -outline-offset-1 outline-gray-300"><option>1 Sentence</option><option>2 Sentences</option><option>Paragraph</option></select></div>
                                    <div x-show="campaignSetup.evaluationFormat === 'Classified'"><input type="text" placeholder="Price objection, timing issue, competitor" class="block w-full rounded-md px-3 py-1.5 text-sm outline outline-1 -outline-offset-1 outline-gray-300"><p class="mt-2 text-sm text-gray-500">Add each possible label as a separate tag.</p></div>
                                    <div x-show="campaignSetup.evaluationFormat === 'Score'" class="grid gap-4"><div class="grid grid-cols-2 gap-4"><input type="number" value="1" class="rounded-md px-3 py-1.5 text-sm outline outline-1 -outline-offset-1 outline-gray-300"><input type="number" value="5" class="rounded-md px-3 py-1.5 text-sm outline outline-1 -outline-offset-1 outline-gray-300"></div><textarea rows="3" placeholder="Score meaning" class="rounded-md px-3 py-1.5 text-sm outline outline-1 -outline-offset-1 outline-gray-300"></textarea></div>
                                </div>
                                <div x-show="campaignSetup.dispatchDrawerOpen" class="mt-6 space-y-5">
                                    <label class="block"><span class="text-sm font-medium text-gray-900">Match By</span><select class="mt-2 block w-full rounded-md px-3 py-2 text-sm outline outline-1 -outline-offset-1 outline-gray-300"><option>All (AND)</option><option>Any (OR)</option></select><span class="mt-2 block text-sm text-gray-500">How many conditions should be met to dispatch this campaign?</span></label>
                                    <label class="block"><span class="text-sm font-medium text-gray-900">Label</span><input type="text" placeholder="e.g. Lead Country filters" class="mt-2 block w-full rounded-md px-3 py-1.5 text-sm outline outline-1 -outline-offset-1 outline-gray-300"></label>
                                    <div class="grid gap-3 sm:grid-cols-3"><select class="rounded-md px-3 py-2 text-sm outline outline-1 -outline-offset-1 outline-gray-300"><option>Lead Country</option><option>Lead Source</option><option>Lead Status</option><option>Customer Type</option><option>Purchase Count</option><option>Cart Value</option><option>Last Activity Date</option><option>Event Name</option></select><select class="rounded-md px-3 py-2 text-sm outline outline-1 -outline-offset-1 outline-gray-300"><option>Equals</option><option>Does Not Equal</option><option>Contains</option><option>Greater Than</option><option>Less Than</option><option>Is Empty</option><option>Is Not Empty</option></select><input type="text" placeholder="Value" class="rounded-md px-3 py-1.5 text-sm outline outline-1 -outline-offset-1 outline-gray-300"></div>
                                </div>
                                <div class="mt-6 flex justify-end gap-3"><button type="button" x-on:click="closeCampaignSetupOverlays()" class="inline-flex h-9 items-center rounded-md bg-white px-3 text-sm font-semibold text-gray-900 ring-1 ring-inset ring-gray-300">Cancel</button><button type="button" x-on:click="closeCampaignSetupOverlays()" class="inline-flex h-9 items-center rounded-md bg-indigo-600 px-3 text-sm font-semibold text-white">Create</button></div>
                            </div>
                        </div>
                    </div>
                </div>
                </div>
            </div>
        </section>

        <section x-cloak x-show="! campaignBuilderOpen && activeNav === 'Dashboard'" class="mx-6 mb-6 mt-6">
            <div class="dashboard-hero rounded-lg px-6 py-12 text-white shadow-sm">
                <h1 class="text-[36px] font-bold leading-tight tracking-normal">Welcome Back!</h1>
                <p class="mt-2 text-[15px] leading-6 text-white/90">Track your campaigns, review leads, or continue where you left off.</p>
            </div>

            <div class="mt-6 grid grid-cols-1 gap-px overflow-hidden rounded-lg bg-gray-900/5 shadow-sm ring-1 ring-gray-900/5 md:grid-cols-3">
                <div class="flex flex-wrap items-baseline justify-between gap-x-4 gap-y-2 bg-white px-6 py-8">
                    <p class="text-sm/6 font-medium text-gray-500">Overall Monthly Engagement</p>
                    <p class="w-full flex-none text-3xl/10 font-semibold tracking-tight text-gray-900">67.49%</p>
                    <div class="flex items-center gap-2 text-sm">
                        <span class="outcraft-icon !text-[20px] text-green-600">arrow_outward</span>
                        <span class="font-medium text-green-600">+4.23%</span>
                        <span class="text-gray-500">increase vs last month</span>
                    </div>
                </div>
                <div class="flex flex-wrap items-baseline justify-between gap-x-4 gap-y-2 bg-white px-6 py-8">
                    <p class="text-sm/6 font-medium text-gray-500">Conversion Potential</p>
                    <p class="w-full flex-none text-3xl/10 font-semibold tracking-tight text-gray-900">51.25%</p>
                    <div class="flex items-center gap-2 text-sm">
                        <span class="outcraft-icon !text-[20px] text-red-600">south_east</span>
                        <span class="font-medium text-red-600">-0.74%</span>
                        <span class="text-gray-500">decrease vs last month</span>
                    </div>
                </div>
                <div class="flex flex-wrap items-baseline justify-between gap-x-4 gap-y-2 bg-white px-6 py-8">
                    <p class="text-sm/6 font-medium text-gray-500">Monthly Revenue</p>
                    <p class="w-full flex-none text-3xl/10 font-semibold tracking-tight text-gray-900">$54,836.78</p>
                    <div class="flex items-center gap-2 text-sm">
                        <span class="outcraft-icon !text-[20px] text-green-600">arrow_outward</span>
                        <span class="font-medium text-green-600">+2.51%</span>
                        <span class="text-gray-500">increase vs last month</span>
                    </div>
                </div>
            </div>

            <div class="mt-6 grid grid-cols-1 gap-5 xl:grid-cols-2">
                <div class="rounded-lg bg-white p-6 shadow-sm ring-1 ring-gray-900/5">
                    <h2 class="text-[21px] font-bold leading-tight text-gray-950">Pinned Campaigns</h2>
                    <ul role="list" class="mt-4 divide-y divide-gray-100">
                        <template x-for="campaign in pinnedCampaigns" :key="campaign.name">
                            <li x-data="{ actionsOpen: false }" class="flex items-center justify-between gap-x-6 py-4">
                                <div class="min-w-0">
                                    <div class="flex flex-wrap items-start gap-x-3 gap-y-2">
                                        <p class="truncate text-[15px] font-semibold leading-6 text-gray-950" x-text="campaign.name"></p>
                                        <span
                                            class="outcraft-label mt-0.5 inline-flex rounded-md px-2 py-1 text-xs font-medium ring-1 ring-inset"
                                            :class="campaign.status === 'Running' ? 'bg-green-50 text-green-700 ring-green-600/20' : 'bg-gray-50 text-gray-600 ring-gray-500/10'"
                                        >
                                            <span x-text="campaign.status"></span>
                                        </span>
                                    </div>
                                    <div class="mt-1 flex flex-wrap items-center gap-x-2 gap-y-1 text-[13px] leading-5 text-gray-500">
                                        <p class="whitespace-nowrap">Modified <span x-text="campaign.modified"></span></p>
                                        <span class="size-0.5 rounded-full bg-gray-400"></span>
                                        <p class="truncate">by <span x-text="campaign.owner"></span></p>
                                    </div>
                                </div>
                                <div class="flex flex-none items-center gap-x-4">
                                    <button type="button" class="hidden rounded-md bg-white px-2.5 py-1.5 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 transition hover:bg-gray-50 sm:block">
                                        Open<span class="sr-only" x-text="`, ${campaign.name}`"></span>
                                    </button>
                                    <div class="relative flex-none" x-on:keydown.escape.window="actionsOpen = false" x-on:click.outside="actionsOpen = false">
                                        <button type="button" x-on:click="actionsOpen = !actionsOpen" class="relative block text-gray-500 transition hover:text-gray-900" aria-label="Open options">
                                            <span class="absolute -inset-2.5"></span>
                                            <span class="outcraft-icon !text-[20px]">more_vert</span>
                                        </button>
                                        <div
                                            x-cloak
                                            x-show="actionsOpen"
                                            x-transition:enter="transition ease-out duration-100"
                                            x-transition:enter-start="opacity-0 translate-y-3"
                                            x-transition:enter-end="opacity-100 translate-y-0"
                                            x-transition:leave="transition ease-in duration-75"
                                            x-transition:leave-start="opacity-100 translate-y-0"
                                            x-transition:leave-end="opacity-0 translate-y-2"
                                            class="absolute right-0 z-40 mt-2 w-32 origin-top-right rounded-md bg-white py-2 shadow-lg ring-1 ring-gray-900/5"
                                        >
                                            <button type="button" class="block w-full px-3 py-1 text-left text-sm leading-6 text-gray-900 transition hover:bg-gray-50">Edit</button>
                                            <button type="button" class="block w-full px-3 py-1 text-left text-sm leading-6 text-gray-900 transition hover:bg-gray-50">Duplicate</button>
                                            <button type="button" class="block w-full px-3 py-1 text-left text-sm leading-6 text-gray-900 transition hover:bg-gray-50">Archive</button>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        </template>
                    </ul>
                </div>

                <div class="grid gap-5">
                    <div class="flex flex-wrap items-baseline justify-between gap-x-4 gap-y-2 rounded-lg bg-white px-6 py-8 shadow-sm ring-1 ring-gray-900/5">
                        <p class="text-sm/6 font-medium text-gray-500">Monthly Revenue</p>
                        <p class="w-full flex-none text-3xl/10 font-semibold tracking-tight text-gray-900">$54,836.78</p>
                        <div class="flex items-center gap-2 text-sm">
                            <span class="outcraft-icon !text-[20px] text-green-600">arrow_outward</span>
                            <span class="font-medium text-green-600">+2.51%</span>
                            <span class="text-gray-500">increase vs last month</span>
                        </div>
                    </div>
                    <div class="flex flex-wrap items-baseline justify-between gap-x-4 gap-y-2 rounded-lg bg-white px-6 py-8 shadow-sm ring-1 ring-gray-900/5">
                        <p class="text-sm/6 font-medium text-gray-500">All Time Revenue</p>
                        <p class="w-full flex-none text-3xl/10 font-semibold tracking-tight text-gray-900">$754,836.78</p>
                        <div class="flex items-center gap-2 text-sm">
                            <span class="outcraft-icon !text-[20px] text-green-600">arrow_outward</span>
                            <span class="font-medium text-green-600">+2.51%</span>
                            <span class="text-gray-500">increase vs last month</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section x-cloak x-show="! campaignBuilderOpen && activeNav === 'Campaigns'" class="mx-6 border-b border-gray-200">
            <nav aria-label="Campaign tabs" class="-mb-px flex space-x-8">
                <template x-for="tab in campaignPageTabs" :key="tab.label">
                    <button
                        type="button"
                        x-on:click="setCampaignPageTab(tab.label)"
                        class="group inline-flex items-center border-b-2 px-1 py-4 text-sm font-medium transition"
                        :class="activeCampaignPageTab === tab.label ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700'"
                    >
                        <span class="outcraft-icon mr-2 -ml-0.5 !text-[20px]" :class="activeCampaignPageTab === tab.label ? 'text-indigo-500' : 'text-gray-400 group-hover:text-gray-500'" x-text="tab.icon"></span>
                        <span x-text="tab.label"></span>
                    </button>
                </template>
            </nav>
        </section>

        <section x-cloak x-show="! campaignBuilderOpen && activeNav === 'Campaigns'" class="mx-6 mb-6 mt-5 bg-white">
            <div class="mb-4 flex min-h-[54px] items-start justify-between gap-x-6">
                <div>
                    <h1 class="text-[21px] font-bold leading-tight text-gray-950" x-text="activeCampaignPageTab"></h1>
                    <p class="mt-1 max-w-2xl text-sm/6 text-gray-500" x-text="campaignPageDescription()"></p>
                </div>
                <button x-show="activeCampaignPageTab !== 'Archived'" type="button" x-on:click="startCampaignBuilder()" class="inline-flex h-10 shrink-0 items-center gap-2 rounded-md bg-indigo-600 px-3.5 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                    <span class="outcraft-icon !text-[18px] text-white">add</span>
                    Create New
                </button>
            </div>
            <ul role="list" class="divide-y divide-gray-100">
                <template x-for="campaign in campaignsPageRows()" :key="activeCampaignPageTab + campaign.name">
                    <li x-data="{ actionsOpen: false }" class="flex items-center justify-between gap-x-6 py-5">
                        <div class="flex min-w-0 items-center gap-x-4">
                            <span class="flex size-10 shrink-0 items-center justify-center rounded-md bg-indigo-50 text-indigo-600">
                                <span class="outcraft-icon !text-[22px]" x-text="campaignAvatarIcon(campaign)"></span>
                            </span>
                            <div class="min-w-0">
                                <div class="flex flex-wrap items-start gap-x-3 gap-y-2">
                                    <p class="truncate text-[15px] font-semibold leading-6 text-gray-950" x-text="campaign.name"></p>
                                    <span
                                        class="outcraft-label mt-0.5 inline-flex rounded-md px-2 py-1 text-xs font-medium ring-1 ring-inset"
                                        :class="campaign.status === 'Running' ? 'bg-green-50 text-green-700 ring-green-600/20' : 'bg-gray-50 text-gray-600 ring-gray-500/10'"
                                    >
                                        <span x-text="campaign.status"></span>
                                    </span>
                                    <span
                                        x-show="campaign.change"
                                        class="outcraft-label mt-0.5 inline-flex rounded-md bg-amber-50 px-2 py-1 text-xs font-medium text-amber-800 ring-1 ring-inset ring-amber-600/20"
                                    >
                                        <span x-text="campaign.change"></span>
                                    </span>
                                </div>
                                <div class="mt-1 flex flex-wrap items-center gap-x-2 gap-y-1 text-[13px] leading-5 text-gray-500">
                                    <p class="whitespace-nowrap">Modified <span x-text="campaign.modified"></span></p>
                                    <span class="size-0.5 rounded-full bg-gray-400"></span>
                                    <p class="truncate" x-text="activeCampaignPageTab === 'A/B Tests' ? 'Variant campaign' : (activeCampaignPageTab === 'Archived' ? 'Archived campaign' : 'Pinned campaign')"></p>
                                </div>
                            </div>
                        </div>
                        <div class="flex flex-none items-center gap-x-4 self-center">
                            <button type="button" class="hidden h-9 items-center rounded-md bg-white px-2.5 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 transition hover:bg-gray-50 sm:inline-flex">
                                Open<span class="sr-only" x-text="`, ${campaign.name}`"></span>
                            </button>
                            <div class="relative flex h-9 flex-none items-center" x-on:keydown.escape.window="actionsOpen = false" x-on:click.outside="actionsOpen = false">
                                <button type="button" x-on:click="actionsOpen = !actionsOpen" class="relative inline-flex items-center text-gray-500 transition hover:text-gray-900" aria-label="Open options">
                                    <span class="absolute -inset-2.5"></span>
                                    <span class="outcraft-icon !text-[20px]">more_vert</span>
                                </button>
                                <div
                                    x-cloak
                                    x-show="actionsOpen"
                                    x-transition:enter="transition ease-out duration-100"
                                    x-transition:enter-start="opacity-0 translate-y-3"
                                    x-transition:enter-end="opacity-100 translate-y-0"
                                    x-transition:leave="transition ease-in duration-75"
                                    x-transition:leave-start="opacity-100 translate-y-0"
                                    x-transition:leave-end="opacity-0 translate-y-2"
                                    class="absolute -right-2.5 top-full z-40 mt-2 w-32 origin-top-right rounded-md bg-white py-2 shadow-lg ring-1 ring-gray-900/5"
                                >
                                    <button type="button" class="block w-full px-3 py-1 text-left text-sm leading-6 text-gray-900 transition hover:bg-gray-50">Edit</button>
                                    <button type="button" class="block w-full px-3 py-1 text-left text-sm leading-6 text-gray-900 transition hover:bg-gray-50">Duplicate</button>
                                    <button type="button" class="block w-full px-3 py-1 text-left text-sm leading-6 text-gray-900 transition hover:bg-gray-50" x-text="activeCampaignPageTab === 'Archived' ? 'Restore' : 'Archive'"></button>
                                </div>
                            </div>
                        </div>
                    </li>
                </template>
            </ul>
        </section>

        <section x-cloak x-show="activeNav === 'Insights'" class="mx-6 border-b border-gray-200">
            <nav aria-label="Insights tabs" class="-mb-px flex space-x-8">
                <template x-for="tab in insightsTabs" :key="tab.label">
                    <button
                        type="button"
                        x-on:click="setInsightsTab(tab.label)"
                        class="group inline-flex items-center border-b-2 px-1 py-4 text-sm font-medium transition"
                        :class="activeInsightsTab === tab.label ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700'"
                    >
                        <span class="outcraft-icon mr-2 -ml-0.5 !text-[20px]" :class="activeInsightsTab === tab.label ? 'text-indigo-500' : 'text-gray-400 group-hover:text-gray-500'" x-text="tab.icon"></span>
                        <span x-text="tab.label"></span>
                    </button>
                </template>
            </nav>
        </section>

        <section x-cloak x-show="activeNav === 'Insights'" class="mx-6 mb-6 mt-5">
            <div class="mb-5 flex min-h-[54px] items-center justify-between">
                <div>
                    <h1 class="text-[21px] font-bold leading-tight text-gray-950" x-text="activeInsightsTab"></h1>
                    <p class="mt-1 text-[15px] text-gray-500" x-text="insightsSubtitle()"></p>
                </div>
                <div class="flex items-center gap-3 text-sm text-gray-700">
                    <div x-show="activeInsightsTab === 'Engagement'" class="flex items-center gap-2 rounded-lg bg-white p-1 shadow-sm ring-1 ring-gray-900/5">
                        <template x-for="channel in engagementChannels" :key="channel.label">
                            <button
                                type="button"
                                x-on:click="toggleEngagementChannel(channel.label)"
                                class="inline-flex h-8 items-center gap-2 rounded-lg px-3 text-[13px] font-semibold transition"
                                :class="selectedEngagementChannels.includes(channel.label) ? 'bg-indigo-100 text-indigo-700' : 'text-gray-600 hover:bg-gray-100 hover:text-gray-950'"
                            >
                                <span class="outcraft-icon !text-[16px]" x-text="channel.icon"></span>
                                <span x-text="channel.label"></span>
                            </button>
                        </template>
                    </div>
                    <button type="button" class="inline-flex h-10 items-center gap-2 rounded-lg border border-gray-200 bg-white px-4 text-[15px] font-semibold text-gray-800 shadow-sm transition hover:bg-gray-200 hover:text-gray-950">
                        <span class="outcraft-icon !text-[18px] text-gray-500">download</span>
                        Export
                    </button>
                </div>
            </div>

            <div>
                <div class="grid grid-cols-4 gap-5">
                    <template x-for="metric in insightsMetrics()" :key="metric.label">
                        <div class="rounded-lg bg-white p-5 shadow-sm ring-1 ring-gray-900/5">
                            <div class="flex items-start justify-between gap-3">
                                <div>
                                    <p class="text-[14px] font-medium text-gray-500" x-text="metric.label"></p>
                                    <p class="mt-3 text-[28px] font-bold leading-none text-gray-950" x-text="metric.value"></p>
                                </div>
                                <span class="outcraft-icon rounded-lg bg-gray-100 p-2 text-gray-700" x-text="metric.icon"></span>
                            </div>
                            <div class="mt-4 flex items-center gap-2 text-[14px]">
                                <span class="outcraft-icon !text-[18px]" :class="metric.trend.startsWith('+') ? 'text-green-600' : 'text-red-600'" x-text="metric.trend.startsWith('+') ? 'arrow_outward' : 'south_east'"></span>
                                <span class="font-semibold" :class="metric.trend.startsWith('+') ? 'text-green-600' : 'text-red-600'" x-text="metric.trend"></span>
                                <span class="text-gray-500">vs Previous Period</span>
                            </div>
                        </div>
                    </template>
                </div>

                <div class="mt-5 grid grid-cols-[1.4fr_1fr] gap-5">
                    <div class="rounded-lg bg-white p-6 shadow-sm ring-1 ring-gray-900/5">
                        <div class="flex items-center justify-between">
                            <h2 class="text-[18px] font-bold text-gray-950" x-text="insightsChartTitle()"></h2>
                            <span class="rounded-lg border border-gray-200 bg-gray-50 px-3 py-1 text-[13px] font-medium text-gray-600">Last 30 Days</span>
                        </div>
                        <div class="mt-6 flex h-[260px] items-end gap-3 border-b border-l border-gray-200 px-4 pb-4">
                            <template x-for="bar in insightsBars()" :key="bar.label">
                                <div class="flex min-w-0 flex-1 flex-col items-center gap-2">
                                    <div class="w-full rounded-t-lg bg-gray-900" :style="`height: ${bar.height}%`"></div>
                                    <span class="text-[12px] font-medium text-gray-500" x-text="bar.label"></span>
                                </div>
                            </template>
                        </div>
                    </div>

                    <div class="rounded-lg bg-white p-6 shadow-sm ring-1 ring-gray-900/5">
                        <h2 class="text-[18px] font-bold text-gray-950">Focus Areas</h2>
                        <div class="mt-5 space-y-4">
                            <template x-for="item in insightsFocusAreas()" :key="item.title">
                                <div>
                                    <div class="flex items-center justify-between gap-3 text-[14px]">
                                        <span class="font-semibold text-gray-800" x-text="item.title"></span>
                                        <span class="text-gray-500" x-text="item.value"></span>
                                    </div>
                                    <div class="mt-2 h-2 rounded-full bg-gray-100">
                                        <div class="h-2 rounded-full bg-gray-900" :style="`width: ${item.progress}%`"></div>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>

                <div class="mt-5 overflow-hidden rounded-lg bg-white shadow-sm ring-1 ring-gray-900/5">
                    <div class="flex min-h-[58px] items-center justify-between border-b border-gray-200 px-6">
                        <h2 class="text-[18px] font-bold text-gray-950">Recent Signals</h2>
                        <span class="text-[14px] font-medium text-gray-500" x-text="activeInsightsTab"></span>
                    </div>
                    <table class="w-full table-fixed border-collapse text-[15px]">
                        <thead>
                            <tr class="bg-gray-50 text-left text-sm font-semibold text-gray-900">
                                <th class="w-[32%] px-6 py-4">Signal</th>
                                <th class="w-[24%] px-4 py-4">Segment</th>
                                <th class="w-[18%] px-4 py-4">Impact</th>
                                <th class="w-[16%] px-4 py-4">Confidence</th>
                                <th class="w-[10%] px-4 py-4"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <template x-for="signal in insightsSignals()" :key="signal.name">
                                <tr class="border-b border-gray-200 last:border-b-0">
                                    <td class="px-6 py-4 font-medium text-gray-950" x-text="signal.name"></td>
                                    <td class="px-4 py-4 text-gray-700" x-text="signal.segment"></td>
                                    <td class="px-4 py-4">
                                        <span class="inline-flex rounded-md px-2 py-1 text-xs font-medium ring-1 ring-inset" :class="signal.impact === 'High' ? 'bg-green-50 text-green-700 ring-green-600/20' : 'bg-gray-50 text-gray-600 ring-gray-500/10'" x-text="signal.impact"></span>
                                    </td>
                                    <td class="px-4 py-4 text-gray-700" x-text="signal.confidence"></td>
                                    <td class="px-4 py-4 font-semibold text-gray-600">View</td>
                                </tr>
                            </template>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>

        <section x-cloak x-show="activeNav === 'Leads' && ! leadDetailOpen" class="mx-6 border-b border-gray-200">
            <nav aria-label="Leads tabs" class="-mb-px flex space-x-8">
                <template x-for="tab in tabs" :key="tab.label">
                    <button
                        type="button"
                        x-on:click="setActiveTab(tab.label)"
                        class="group inline-flex items-center border-b-2 px-1 py-4 text-sm font-medium transition"
                        :class="activeTab === tab.label ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700'"
                    >
                        <span class="outcraft-icon mr-2 -ml-0.5 !text-[20px]" :class="activeTab === tab.label ? 'text-indigo-500' : 'text-gray-400 group-hover:text-gray-500'" x-text="tab.icon"></span>
                        <span x-text="tab.displayLabel || tab.label"></span>
                    </button>
                </template>
            </nav>
        </section>

        <section x-cloak x-show="leadDetailOpen" class="mx-6 mb-10 mt-6">
            <div class="mb-8">
                <div class="flex flex-wrap items-center justify-between gap-4">
                    <button type="button" x-on:click="backFromLeadDetails()" class="inline-flex h-9 items-center gap-2 rounded-md px-2 text-sm font-semibold text-gray-600 transition hover:bg-white hover:text-gray-950">
                        <span class="outcraft-icon !text-[18px]">arrow_back</span>
                        <span x-text="`Back to ${leadDetailBackLabel()}`"></span>
                    </button>
                    <div class="flex flex-wrap items-center gap-2">
                        <button type="button" class="inline-flex h-9 items-center gap-2 rounded-md bg-green-50 px-3 text-sm font-semibold text-green-700 shadow-sm ring-1 ring-inset ring-green-600/20 transition hover:bg-green-100">
                            <span class="outcraft-icon !text-[17px]">message-circle</span>
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
                    <h1 class="text-[26px] font-bold leading-tight text-gray-950">Lead Profile</h1>
                    <p class="mt-1 text-sm leading-6 text-gray-500">Review contact context, campaign runs, and every interaction in one place.</p>
                </div>
            </div>

            <div class="grid gap-6 xl:grid-cols-2">
                <section class="overflow-visible rounded-lg bg-white shadow-sm ring-1 ring-gray-900/5">
                    <div class="flex items-start justify-between gap-4 px-6 py-5">
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
                        <div class="border-t border-gray-100 px-6 py-6">
                            <dt class="text-sm/6 font-medium text-gray-900">Name</dt>
                            <dd class="mt-1 truncate text-sm/6 text-gray-700 sm:mt-2" x-text="leadFirstName()"></dd>
                        </div>
                        <div class="border-t border-gray-100 px-6 py-6">
                            <dt class="text-sm/6 font-medium text-gray-900">Surname</dt>
                            <dd class="mt-1 truncate text-sm/6 text-gray-700 sm:mt-2" x-text="leadLastName()"></dd>
                        </div>
                        <div class="border-t border-gray-100 px-6 py-6">
                            <dt class="text-sm/6 font-medium text-gray-900">Email address</dt>
                            <dd class="mt-1 flex min-w-0 items-center gap-2 text-sm/6 text-gray-700 sm:mt-2">
                                <span class="truncate" x-text="selectedLead?.email || 'biruhl@msn.com'"></span>
                                <button type="button" x-on:click="copyContact(selectedLead?.email || 'biruhl@msn.com')" class="inline-flex size-6 shrink-0 items-center justify-center rounded-md text-gray-400 transition hover:bg-gray-50 hover:text-gray-900" aria-label="Copy email address">
                                    <span class="outcraft-icon !text-[15px]">copy</span>
                                </button>
                            </dd>
                        </div>
                        <div class="border-t border-gray-100 px-6 py-6">
                            <dt class="text-sm/6 font-medium text-gray-900">Phone Number</dt>
                            <dd class="mt-1 flex min-w-0 items-center gap-2 text-sm/6 text-gray-700 sm:mt-2">
                                <span class="truncate" x-text="selectedLead?.phone || '+12145059504'"></span>
                                <button type="button" x-on:click="copyContact(selectedLead?.phone || '+12145059504')" class="inline-flex size-6 shrink-0 items-center justify-center rounded-md text-gray-400 transition hover:bg-gray-50 hover:text-gray-900" aria-label="Copy phone number">
                                    <span class="outcraft-icon !text-[15px]">copy</span>
                                </button>
                            </dd>
                        </div>
                        <div class="border-t border-gray-100 px-6 py-6">
                            <dt class="text-sm/6 font-medium text-gray-900">Country</dt>
                            <dd class="mt-1 truncate text-sm/6 text-gray-700 sm:mt-2" x-text="`${selectedLead?.countryFlag || '🇺🇸'} ${selectedLead?.country || 'US'}`"></dd>
                        </div>
                        <div class="border-t border-gray-100 px-6 py-6">
                            <dt class="text-sm/6 font-medium text-gray-900">Timezone</dt>
                            <dd class="mt-1 truncate text-sm/6 text-gray-700 sm:mt-2" x-text="selectedLead?.timezone || 'America / New York'"></dd>
                        </div>
                        <div class="border-t border-gray-100 px-6 py-6">
                            <dt class="text-sm/6 font-medium text-gray-900">Created</dt>
                            <dd class="mt-1 text-sm/6 text-gray-700 sm:mt-2"><span x-text="leadAddedAge()"></span><span class="mx-1 text-gray-400">·</span><span x-text="leadCreatedDate()"></span></dd>
                        </div>
                        <div class="border-t border-gray-100 px-6 py-6">
                            <dt class="text-sm/6 font-medium text-gray-900">Status</dt>
                            <dd class="mt-1 sm:mt-2">
                                <span class="inline-flex rounded-md px-2 py-1 text-xs font-medium ring-1 ring-inset" :class="leadStateClass(selectedLead?.state || 'Idle')" x-text="selectedLead?.state || 'Idle'"></span>
                            </dd>
                        </div>
                    </dl>
                    <form x-cloak x-show="leadDetailsEditing" x-on:submit.prevent="saveLeadDetailsEdit()" class="border-t border-gray-100 px-6 py-6">
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
                                        <span class="truncate" x-text="leadCountryLabel(leadEditForm.country)"></span>
                                        <span class="outcraft-icon ml-3 shrink-0 text-gray-500">keyboard_arrow_down</span>
                                    </button>
                                    <div x-cloak x-show="leadSelectOpen === 'country'" class="absolute z-30 mt-2 max-h-64 w-full overflow-auto rounded-md bg-white py-1 shadow-lg ring-1 ring-gray-900/10">
                                        <template x-for="countryOption in leadCountryOptions" :key="countryOption.code">
                                            <button type="button" x-on:click="selectLeadCountry(countryOption.code)" class="flex w-full items-center justify-between gap-3 px-3 py-2 text-left text-sm text-gray-900 transition hover:bg-gray-50">
                                                <span x-text="`${countryOption.flag} ${countryOption.name} (${countryOption.code})`"></span>
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
                    <div class="flex items-start justify-between gap-4 px-6 py-5">
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
                            <li class="px-6 py-5">
                                <div class="flex items-start justify-between gap-4">
                                    <div class="min-w-0">
                                        <p class="truncate text-sm font-medium leading-6 text-gray-950" x-text="campaignRow.campaign"></p>
                                        <p class="mt-1 text-sm leading-6 text-gray-500">Created <span x-text="campaignRow.created"></span> · <span x-text="campaignRow.price"></span></p>
                                    </div>
                                    <span class="inline-flex shrink-0 rounded-md px-2 py-1 text-xs font-medium ring-1 ring-inset" :class="campaignBadgeClass(campaignRow.status)" x-text="campaignRow.status"></span>
                                </div>
                                <div class="mt-4 grid grid-cols-2 gap-3 text-sm">
                                    <div>
                                        <p class="text-sm/6 font-medium text-gray-900">First interaction</p>
                                        <div class="mt-2">
                                            <span class="inline-flex max-w-full rounded-md px-2 py-1 text-xs font-medium ring-1 ring-inset" :class="campaignBadgeClass(campaignRow.firstInteraction)">
                                                <span class="truncate" x-text="campaignRow.firstInteraction"></span>
                                            </span>
                                        </div>
                                    </div>
                                    <div>
                                        <p class="text-sm/6 font-medium text-gray-900">Follow up</p>
                                        <div class="mt-2">
                                            <span class="inline-flex max-w-full rounded-md px-2 py-1 text-xs font-medium ring-1 ring-inset" :class="campaignBadgeClass(campaignRow.followUp || 'Pending')">
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
                <div class="px-4 py-5 sm:px-6">
                    <h2 class="text-base/7 font-semibold text-gray-950">Interactions</h2>
                    <p class="mt-1 max-w-3xl text-sm/6 text-gray-500">Timeline of emails, calls, SMS, and WhatsApp touchpoints tied to this lead.</p>
                </div>
                <ul role="list" class="divide-y divide-gray-100">
                    <template x-for="interaction in resolvedLeadInteractions()" :key="interaction.id">
                        <li class="px-4 py-6 sm:px-6">
                            <div class="flex min-w-0 gap-4">
                                <div class="flex shrink-0 flex-col items-center">
                                    <span class="flex size-9 items-center justify-center rounded-full bg-gray-50 text-gray-600 ring-1 ring-inset ring-gray-200">
                                        <span class="outcraft-icon !text-[18px]" x-text="interaction.timelineIcon || (interaction.direction === 'Incoming' ? 'arrow_downward' : 'arrow_upward')"></span>
                                    </span>
                                    <span class="mt-3 h-full w-px bg-gray-200"></span>
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
                                            <span class="outcraft-icon !text-[14px]" x-text="interaction.icon"></span>
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
                </ul>
            </section>
        </section>

        <section x-cloak x-show="activeNav === 'Leads' && activeTab === 'Leads' && ! leadDetailOpen" class="mx-6 mb-6 mt-5 overflow-hidden rounded-lg bg-white shadow-sm ring-1 ring-gray-900/5">
            <div class="grid min-h-[92px] grid-cols-[250px_1fr_230px] items-start gap-6 p-6">
                <div>
                    <h1 class="text-[19px] font-bold leading-tight tracking-normal">Leads</h1>
                    <p class="mt-1 text-[15px] text-gray-500">Browse and manage all your leads</p>
                </div>

                <div class="relative" x-on:click.outside="searchOpen = false">
                    <div class="rounded-lg bg-white shadow-sm ring-1 ring-gray-900/5">
                        <div class="flex min-h-10 items-center px-4">
                            <input
                                x-model="query"
                                x-on:focus="searchOpen = true"
                                x-on:keydown.escape="searchOpen = false"
                                x-on:keydown.enter.prevent="addFirstSuggestion()"
                                class="w-full border-0 bg-transparent text-[15px] outline-none ring-0 placeholder:text-gray-400 focus:ring-0"
                                placeholder="Filter anything"
                            >
                        </div>
                        <div x-show="filters.length > 0" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-3" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-2" class="flex min-h-10 items-center gap-2 border-t border-gray-200 px-4">
                            <template x-for="tag in filters" :key="tag">
                                <button x-on:click="removeFilter(tag)" class="inline-flex items-center gap-1 rounded-lg border border-gray-200 bg-gray-50 px-2 py-1 text-[15px] leading-none text-gray-600">
                                    <span x-text="tag"></span>
                                    <span class="text-gray-500">×</span>
                                </button>
                            </template>
                            <div class="ml-auto flex items-center gap-4">
                                <button class="text-[14px] font-semibold text-gray-500 hover:text-gray-900" x-on:click="clearSearchTags()">Clear</button>
                                <button class="text-[14px] font-semibold text-gray-600 hover:text-gray-900" x-on:click="savePreset()">Save Preset</button>
                            </div>
                        </div>
                    </div>

                    <div x-cloak x-show="searchOpen" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-3" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-2" class="absolute left-0 right-0 top-0 z-30 rounded-md bg-white p-5 shadow-lg ring-1 ring-gray-900/5">
                        <input x-model="query" x-ref="leadsOverlayInput" x-init="$watch('searchOpen', value => value && activeTab === 'Leads' && $nextTick(() => $refs.leadsOverlayInput.focus()))" class="w-full border-0 bg-transparent text-[17px] outline-none ring-0 focus:ring-0" placeholder="Filter anything">
                        <div class="filter-scroll mt-4 max-h-[215px] space-y-1 overflow-y-auto pr-2">
                            <template x-for="group in groupedSuggestions()" :key="group.column">
                                <div>
                                    <div class="px-1 py-2 text-[15px] font-semibold" x-text="group.column"></div>
                                    <template x-for="value in group.values" :key="group.column + value">
                                        <button x-on:click="addFilter(value)" class="block w-full rounded-lg px-1 py-2 text-left text-[15px] hover:bg-gray-200" x-text="value"></button>
                                    </template>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>

                <div class="relative ml-auto" x-on:click.outside="presetOpen = false">
                    <button
                        type="button"
                        x-on:click="presetOpen = ! presetOpen"
                        class="flex h-10 min-w-[175px] items-center justify-between gap-3 rounded-md bg-white px-3 text-left text-sm font-medium text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 outline-none transition hover:bg-gray-50 focus:ring-2 focus:ring-inset focus:ring-indigo-600"
                    >
                        <span x-text="selectedPresetName"></span>
                        <span class="outcraft-icon text-gray-600">keyboard_arrow_down</span>
                    </button>
                    <div x-cloak x-show="presetOpen" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-3" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-2" class="absolute right-0 top-12 z-40 w-[230px] overflow-hidden rounded-md bg-white p-1 text-sm text-gray-900 shadow-lg ring-1 ring-gray-900/5">
                        <button type="button" x-on:click="clearFilters()" class="block w-full rounded-lg px-3 py-2 text-left font-semibold hover:bg-gray-200">Clear Filters</button>
                        <template x-for="preset in presets" :key="preset.name">
                            <div class="group flex items-center rounded-lg hover:bg-gray-200">
                                <button type="button" x-on:click="applyPreset(preset)" class="flex min-w-0 flex-1 items-center justify-between px-3 py-2 text-left">
                                    <span class="truncate" x-text="preset.name"></span>
                                    <span x-show="selectedPresetName === preset.name" class="outcraft-icon ml-3 shrink-0 text-blue-500">check</span>
                                </button>
                                <button type="button" x-on:click.stop="deletePreset(preset)" class="mr-2 flex size-8 shrink-0 items-center justify-center rounded-lg text-gray-400 opacity-0 transition hover:bg-red-50 hover:text-red-600 group-hover:opacity-100" :aria-label="`Delete ${preset.name}`">
                                    <span class="outcraft-icon !text-[18px]">delete</span>
                                </button>
                            </div>
                        </template>
                    </div>
                </div>
            </div>

            <div class="flex min-h-[74px] items-center justify-end gap-3 border-y border-gray-200 bg-white px-6">
                <button type="button" x-on:click="addFilter('Review Required')" class="inline-flex h-9 items-center gap-2 rounded-lg border border-gray-200 bg-white px-3 text-[14px] font-semibold text-gray-800 shadow-sm transition hover:bg-gray-200">
                    <span class="outcraft-icon !text-[18px] text-gray-500">manage_search</span>
                    Review Required
                </button>
                <button type="button" class="inline-flex h-9 items-center gap-2 rounded-lg border border-gray-200 bg-white px-3 text-[14px] font-semibold text-gray-800 shadow-sm transition hover:bg-gray-200">
                    <span class="outcraft-icon !text-[18px] text-gray-500">upload</span>
                    Import CSV
                </button>
                <button type="button" class="inline-flex h-9 items-center gap-2 rounded-lg border border-gray-200 bg-white px-3 text-[14px] font-semibold text-gray-800 shadow-sm transition hover:bg-gray-200">
                    <span class="outcraft-icon !text-[18px] text-gray-500">add</span>
                    Add Lead
                </button>
            </div>

            <div class="overflow-x-auto">
                <ul role="list" class="min-w-[960px] divide-y divide-gray-100">
                    <li x-show="isLoading" x-transition.opacity class="h-[260px] bg-white px-8 py-12 text-center">
                        <div class="mx-auto flex size-[56px] items-center justify-center rounded-xl bg-white" x-html="tableLoaderSvg()"></div>
                    </li>
                    <template x-for="row in loadingRows()" :key="'lead-' + row.name + row.phone + row.email + row.age">
                        <li class="flex items-center justify-between gap-x-6 px-6 py-5">
                            <div class="min-w-0 flex-auto">
                                <div class="flex min-w-0 items-center gap-x-3">
                                    <p class="truncate text-sm/6 font-medium text-gray-900" x-text="row.name || 'Unknown Lead'"></p>
                                    <span class="outcraft-label inline-flex shrink-0 rounded-md px-2 py-1 text-xs font-medium ring-1 ring-inset" :class="leadStateClass(row.state)">
                                        <span x-text="row.state"></span>
                                    </span>
                                </div>
                                <div class="mt-1 flex min-w-0 flex-wrap items-center gap-x-2 gap-y-1 text-xs/5 text-gray-500">
                                    <button type="button" x-show="row.email" x-on:click="copyContact(row.email)" class="group relative inline-flex min-w-0 max-w-[320px] text-left transition hover:text-gray-900">
                                        <span class="truncate" x-text="row.email"></span>
                                        <span class="pointer-events-none absolute bottom-full left-1/2 z-50 mb-2 -translate-x-1/2 translate-y-1 whitespace-nowrap rounded-lg bg-gray-900 px-3 py-2 text-xs font-medium text-white opacity-0 shadow-sm transition group-hover:translate-y-0 group-hover:opacity-100">
                                            <span x-text="row.email"></span>
                                            <span class="ml-2 text-white/70">Click to Copy</span>
                                            <span class="absolute left-1/2 top-full size-2 -translate-x-1/2 -translate-y-1 rotate-45 bg-gray-900"></span>
                                        </span>
                                    </button>
                                    <span x-show="row.email && row.phone" class="mx-2 size-0.5 rounded-full bg-gray-500"></span>
                                    <button type="button" x-show="row.phone" x-on:click="copyContact(row.phone)" class="group relative inline-flex text-left transition hover:text-gray-900">
                                        <span x-text="row.phone"></span>
                                        <span class="pointer-events-none absolute bottom-full left-1/2 z-50 mb-2 -translate-x-1/2 translate-y-1 whitespace-nowrap rounded-lg bg-gray-900 px-3 py-2 text-xs font-medium text-white opacity-0 shadow-sm transition group-hover:translate-y-0 group-hover:opacity-100">
                                            <span x-text="row.phone"></span>
                                            <span class="ml-2 text-white/70">Click to Copy</span>
                                            <span class="absolute left-1/2 top-full size-2 -translate-x-1/2 -translate-y-1 rotate-45 bg-gray-900"></span>
                                        </span>
                                    </button>
                                </div>
                            </div>

                            <div class="hidden min-w-[230px] sm:block">
                                <div class="flex items-center gap-x-2 text-sm/6 font-medium text-gray-900">
                                    <span x-text="row.countryFlag"></span>
                                    <span x-text="row.phoneCountry"></span>
                                </div>
                                <p class="mt-1 truncate text-xs/5 text-gray-500" x-text="row.timezone"></p>
                            </div>

                            <div class="min-w-[145px] text-right">
                                <span class="group relative inline-flex flex-col items-end">
                                    <span class="text-sm/6 font-medium text-gray-900">Created</span>
                                    <span class="text-xs/5 text-gray-500" x-text="leadAge(row)"></span>
                                    <span class="pointer-events-none absolute bottom-full right-0 z-50 mb-2 translate-y-1 whitespace-nowrap rounded-lg bg-gray-900 px-3 py-2 text-xs font-medium text-white opacity-0 shadow-sm transition group-hover:translate-y-0 group-hover:opacity-100">
                                        <span x-text="row.ageTooltip"></span>
                                        <span class="absolute right-6 top-full size-2 -translate-y-1 rotate-45 bg-gray-900"></span>
                                    </span>
                                </span>
                            </div>

                            <div class="w-[52px] shrink-0 text-right">
                                <button type="button" x-on:click="openLeadDetails(row)" class="text-sm/6 font-semibold text-gray-600 transition hover:text-gray-950">View</button>
                            </div>
                        </li>
                    </template>
                    <li x-show="! isLoading && filteredRows().length === 0" class="px-8 py-16 text-center text-gray-500">No leads match these filters.</li>
                </ul>
            </div>
            <div class="flex items-center justify-between border-t border-gray-200 bg-white px-4 py-3 sm:px-6">
                <div class="flex flex-1 items-center">
                    <label class="flex items-center gap-3 text-sm text-gray-700">
                        <span>Rows Per Page</span>
                        <span class="grid grid-cols-1">
                            <select x-model.number="perPage" x-on:change="page = 1" class="col-start-1 row-start-1 h-9 appearance-none rounded-md bg-white py-1.5 pr-8 pl-3 text-sm text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600">
                                <template x-for="option in perPageOptions" :key="option">
                                    <option :value="option" x-text="option"></option>
                                </template>
                            </select>
                            <svg viewBox="0 0 16 16" fill="currentColor" data-slot="icon" aria-hidden="true" class="pointer-events-none col-start-1 row-start-1 mr-2 size-4 self-center justify-self-end text-gray-400">
                                <path d="M4.22 6.22a.75.75 0 0 1 1.06 0L8 8.94l2.72-2.72a.75.75 0 1 1 1.06 1.06l-3.25 3.25a.75.75 0 0 1-1.06 0L4.22 7.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" fill-rule="evenodd" />
                            </svg>
                        </span>
                    </label>
                </div>
                <div class="flex flex-1 justify-center text-sm text-gray-700">
                    <span x-text="paginationSummary()"></span>
                </div>
                <div class="flex flex-1 justify-end">
                    <nav aria-label="Pagination" class="isolate inline-flex -space-x-px rounded-md shadow-sm">
                        <button type="button" x-on:click="page = Math.max(1, page - 1)" :disabled="page === 1" class="relative inline-flex size-9 items-center justify-center rounded-l-md text-gray-400 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0 disabled:cursor-not-allowed disabled:opacity-40">
                            <span class="sr-only">Previous</span>
                            <svg viewBox="0 0 20 20" fill="currentColor" data-slot="icon" aria-hidden="true" class="size-5">
                                <path d="M11.78 5.22a.75.75 0 0 1 0 1.06L8.06 10l3.72 3.72a.75.75 0 1 1-1.06 1.06l-4.25-4.25a.75.75 0 0 1 0-1.06l4.25-4.25a.75.75 0 0 1 1.06 0Z" clip-rule="evenodd" fill-rule="evenodd" />
                            </svg>
                        </button>
                        <template x-for="pageNumber in visiblePageNumbers()" :key="pageNumber">
                            <span>
                                <span x-show="pageNumber === '...'" class="relative inline-flex size-9 items-center justify-center text-sm font-semibold text-gray-700 ring-1 ring-inset ring-gray-300 focus:outline-offset-0">...</span>
                                <button x-show="pageNumber !== '...'" type="button" x-on:click="page = pageNumber" class="relative inline-flex size-9 items-center justify-center text-sm font-semibold focus:z-20 focus:outline-offset-0" :class="page === pageNumber ? 'z-10 bg-indigo-600 text-white focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600' : 'text-gray-900 ring-1 ring-inset ring-gray-300 hover:bg-gray-50'" x-text="pageNumber"></button>
                            </span>
                        </template>
                        <button type="button" x-on:click="page = Math.min(totalPages(), page + 1)" :disabled="page === totalPages()" class="relative inline-flex size-9 items-center justify-center rounded-r-md text-gray-400 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0 disabled:cursor-not-allowed disabled:opacity-40">
                            <span class="sr-only">Next</span>
                            <svg viewBox="0 0 20 20" fill="currentColor" data-slot="icon" aria-hidden="true" class="size-5">
                                <path d="M8.22 5.22a.75.75 0 0 1 1.06 0l4.25 4.25a.75.75 0 0 1 0 1.06l-4.25 4.25a.75.75 0 0 1-1.06-1.06L11.94 10 8.22 6.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" fill-rule="evenodd" />
                            </svg>
                        </button>
                    </nav>
                </div>
            </div>
        </section>

        <section x-cloak x-show="activeNav === 'Leads' && activeTab === 'Campaigns'" class="mx-6 mb-6 mt-5 overflow-hidden rounded-lg bg-white shadow-sm ring-1 ring-gray-900/5">
            <div class="grid min-h-[112px] grid-cols-[250px_1fr_230px] items-start gap-6 p-6">
                <div>
                    <h1 class="text-[19px] font-bold leading-tight tracking-normal">Campaign Runs</h1>
                    <p class="mt-1 max-w-[220px] text-[15px] leading-6 text-gray-500">Browse and manage campaign runs for the selected campaign</p>
                </div>

                <div class="relative" x-on:click.outside="searchOpen = false">
                    <div class="rounded-lg bg-white shadow-sm ring-1 ring-gray-900/5">
                        <div class="flex min-h-10 items-center px-4">
                            <input
                                x-model="query"
                                x-on:focus="searchOpen = true"
                                x-on:keydown.escape="searchOpen = false"
                                x-on:keydown.enter.prevent="addFirstSuggestion()"
                                class="w-full border-0 bg-transparent text-[15px] outline-none ring-0 placeholder:text-gray-400 focus:ring-0"
                                placeholder="Filter anything"
                            >
                        </div>
                        <div x-show="filters.length > 0" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-3" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-2" class="flex min-h-10 items-center gap-2 border-t border-gray-200 px-4">
                            <template x-for="tag in filters" :key="tag">
                                <button x-on:click="removeFilter(tag)" class="inline-flex items-center gap-1 rounded-lg border border-gray-200 bg-gray-50 px-2 py-1 text-[15px] leading-none text-gray-600">
                                    <span x-text="tag"></span>
                                    <span class="text-gray-500">×</span>
                                </button>
                            </template>
                            <div class="ml-auto flex items-center gap-4">
                                <button class="text-[14px] font-semibold text-gray-500 hover:text-gray-900" x-on:click="clearSearchTags()">Clear</button>
                                <button class="text-[14px] font-semibold text-gray-600 hover:text-gray-900" x-on:click="savePreset()">Save Preset</button>
                            </div>
                        </div>
                    </div>

                    <div x-cloak x-show="searchOpen" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-3" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-2" class="absolute left-0 right-0 top-0 z-30 rounded-md bg-white p-5 shadow-lg ring-1 ring-gray-900/5">
                        <input x-model="query" x-ref="campaignsOverlayInput" x-init="$watch('searchOpen', value => value && activeTab === 'Campaigns' && $nextTick(() => $refs.campaignsOverlayInput.focus()))" class="w-full border-0 bg-transparent text-[17px] outline-none ring-0 focus:ring-0" placeholder="Filter anything">
                        <div class="filter-scroll mt-4 max-h-[215px] space-y-1 overflow-y-auto pr-2">
                            <template x-for="group in groupedSuggestions()" :key="group.column">
                                <div>
                                    <div class="px-1 py-2 text-[15px] font-semibold" x-text="group.column"></div>
                                    <template x-for="value in group.values" :key="group.column + value">
                                        <button x-on:click="addFilter(value)" class="block w-full rounded-lg px-1 py-2 text-left text-[15px] hover:bg-gray-200" x-text="value"></button>
                                    </template>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>

                <div class="relative ml-auto" x-on:click.outside="presetOpen = false">
                    <button
                        type="button"
                        x-on:click="presetOpen = ! presetOpen"
                        class="flex h-10 min-w-[175px] items-center justify-between gap-3 rounded-md bg-white px-3 text-left text-sm font-medium text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 outline-none transition hover:bg-gray-50 focus:ring-2 focus:ring-inset focus:ring-indigo-600"
                    >
                        <span x-text="selectedPresetName"></span>
                        <span class="outcraft-icon text-gray-600">keyboard_arrow_down</span>
                    </button>
                    <div x-cloak x-show="presetOpen" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-3" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-2" class="absolute right-0 top-12 z-40 w-[230px] overflow-hidden rounded-md bg-white p-1 text-sm text-gray-900 shadow-lg ring-1 ring-gray-900/5">
                        <button type="button" x-on:click="clearFilters()" class="block w-full rounded-lg px-3 py-2 text-left font-semibold hover:bg-gray-200">Clear Filters</button>
                        <template x-for="preset in presets" :key="preset.name">
                            <div class="group flex items-center rounded-lg hover:bg-gray-200">
                                <button type="button" x-on:click="applyPreset(preset)" class="flex min-w-0 flex-1 items-center justify-between px-3 py-2 text-left">
                                    <span class="truncate" x-text="preset.name"></span>
                                    <span x-show="selectedPresetName === preset.name" class="outcraft-icon ml-3 shrink-0 text-blue-500">check</span>
                                </button>
                                <button type="button" x-on:click.stop="deletePreset(preset)" class="mr-2 flex size-8 shrink-0 items-center justify-center rounded-lg text-gray-400 opacity-0 transition hover:bg-red-50 hover:text-red-600 group-hover:opacity-100" :aria-label="`Delete ${preset.name}`">
                                    <span class="outcraft-icon !text-[18px]">delete</span>
                                </button>
                            </div>
                        </template>
                    </div>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full min-w-[1220px] table-fixed border-collapse text-[15px]">
                    <thead>
                        <tr class="border-y border-gray-200 bg-gray-50 text-left text-[14px] font-semibold text-gray-950">
                            <th class="w-[150px] px-6 py-4">Campaign</th>
                            <th class="w-[150px] px-4 py-4">Name</th>
                            <th class="w-[150px] px-4 py-4">Phone</th>
                            <th class="w-[150px] px-4 py-4">Email</th>
                            <th class="w-[120px] px-4 py-4">Status</th>
                            <th class="w-[140px] px-4 py-4">First Interaction</th>
                            <th class="w-[130px] px-4 py-4">Follow Up</th>
                            <th class="w-[120px] px-4 py-4">Created</th>
                            <th class="w-[82px] px-4 py-4"></th>
                            <th class="w-[92px] py-4 pr-6 pl-4"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr x-show="isLoading" x-transition.opacity>
                            <td colspan="10" class="h-[260px] bg-white px-8 py-12 text-center">
                                <div class="mx-auto flex size-[56px] items-center justify-center rounded-xl bg-white" x-html="tableLoaderSvg()"></div>
                            </td>
                        </tr>
                        <template x-for="(row, rowIndex) in loadingRows()" :key="'campaign-' + row.campaignName + row.name + row.phone + row.email + row.age">
                            <tr :class="rowIndex === loadingRows().length - 1 ? '' : 'border-b border-gray-200'">
                                <td class="px-6 py-4" x-text="row.campaignName"></td>
                                <td class="px-4 py-4">
                                    <span class="group relative inline-flex max-w-full">
                                        <span class="truncate" x-text="row.name"></span>
                                        <span class="pointer-events-none absolute bottom-full left-1/2 z-50 mb-2 -translate-x-1/2 translate-y-1 whitespace-nowrap rounded-lg bg-gray-900 px-3 py-2 text-xs font-medium text-white opacity-0 shadow-sm transition group-hover:translate-y-0 group-hover:opacity-100">
                                            <span x-text="row.name"></span>
                                            <span class="absolute left-1/2 top-full size-2 -translate-x-1/2 -translate-y-1 rotate-45 bg-gray-900"></span>
                                        </span>
                                    </span>
                                </td>
                                <td class="px-4 py-4" x-text="row.phone"></td>
                                <td class="px-4 py-4">
                                    <span x-show="! row.email" class="text-gray-300"></span>
                                    <span x-show="row.email" class="group relative inline-flex max-w-full">
                                        <span class="truncate" x-text="shortEmail(row.email)"></span>
                                        <span class="pointer-events-none absolute bottom-full left-1/2 z-50 mb-2 -translate-x-1/2 translate-y-1 whitespace-nowrap rounded-lg bg-gray-900 px-3 py-2 text-xs font-medium text-white opacity-0 shadow-sm transition group-hover:translate-y-0 group-hover:opacity-100">
                                            <span x-text="row.email"></span>
                                            <span class="absolute left-1/2 top-full size-2 -translate-x-1/2 -translate-y-1 rotate-45 bg-gray-900"></span>
                                        </span>
                                    </span>
                                </td>
                                <td class="px-4 py-4">
                                    <span class="outcraft-label inline-flex max-w-[104px] rounded-md px-2 py-1 text-xs font-medium ring-1 ring-inset" :class="campaignBadgeClass(row.campaignStatus)">
                                        <span class="truncate" x-text="row.campaignStatus"></span>
                                    </span>
                                </td>
                                <td class="px-4 py-4">
                                    <span class="outcraft-label inline-flex max-w-[116px] rounded-md px-2 py-1 text-xs font-medium ring-1 ring-inset" :class="campaignBadgeClass(row.firstInteraction)">
                                        <span class="truncate" x-text="row.firstInteraction"></span>
                                    </span>
                                </td>
                                <td class="px-4 py-4">
                                    <span class="outcraft-label inline-flex max-w-[110px] rounded-md px-2 py-1 text-xs font-medium ring-1 ring-inset" :class="campaignBadgeClass(row.followUp)">
                                        <span class="truncate" x-text="row.followUp"></span>
                                    </span>
                                </td>
                                <td class="px-4 py-4">
                                    <span class="group relative inline-flex">
                                        <span>Created </span><span x-text="campaignAge(row)"></span>
                                        <span class="pointer-events-none absolute bottom-full left-1/2 z-50 mb-2 -translate-x-1/2 translate-y-1 whitespace-nowrap rounded-lg bg-gray-900 px-3 py-2 text-xs font-medium text-white opacity-0 shadow-sm transition group-hover:translate-y-0 group-hover:opacity-100">
                                            <span x-text="row.ageTooltip"></span>
                                            <span class="absolute left-1/2 top-full size-2 -translate-x-1/2 -translate-y-1 rotate-45 bg-gray-900"></span>
                                        </span>
                                    </span>
                                </td>
                                <td class="px-4 py-4 text-right font-semibold text-gray-600 transition hover:text-gray-950">Flow</td>
                                <td class="py-4 pr-6 pl-4 text-right">
                                    <button type="button" x-on:click="openLeadDetails(row)" class="font-semibold text-gray-600 transition hover:text-gray-950">View</button>
                                </td>
                            </tr>
                        </template>
                        <tr x-show="! isLoading && filteredRows().length === 0">
                            <td colspan="10" class="px-8 py-16 text-center text-gray-500">No campaign run records match these filters.</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="flex items-center justify-between border-t border-gray-200 bg-white px-4 py-3 sm:px-6">
                <div class="flex flex-1 items-center">
                    <label class="flex items-center gap-3 text-sm text-gray-700">
                        <span>Rows Per Page</span>
                        <span class="grid grid-cols-1">
                            <select x-model.number="perPage" x-on:change="page = 1" class="col-start-1 row-start-1 h-9 appearance-none rounded-md bg-white py-1.5 pr-8 pl-3 text-sm text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600">
                                <template x-for="option in perPageOptions" :key="option">
                                    <option :value="option" x-text="option"></option>
                                </template>
                            </select>
                            <svg viewBox="0 0 16 16" fill="currentColor" data-slot="icon" aria-hidden="true" class="pointer-events-none col-start-1 row-start-1 mr-2 size-4 self-center justify-self-end text-gray-400">
                                <path d="M4.22 6.22a.75.75 0 0 1 1.06 0L8 8.94l2.72-2.72a.75.75 0 1 1 1.06 1.06l-3.25 3.25a.75.75 0 0 1-1.06 0L4.22 7.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" fill-rule="evenodd" />
                            </svg>
                        </span>
                    </label>
                </div>
                <div class="flex flex-1 justify-center text-sm text-gray-700">
                    <span x-text="paginationSummary()"></span>
                </div>
                <div class="flex flex-1 justify-end">
                    <nav aria-label="Pagination" class="isolate inline-flex -space-x-px rounded-md shadow-sm">
                        <button type="button" x-on:click="page = Math.max(1, page - 1)" :disabled="page === 1" class="relative inline-flex size-9 items-center justify-center rounded-l-md text-gray-400 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0 disabled:cursor-not-allowed disabled:opacity-40">
                            <span class="sr-only">Previous</span>
                            <svg viewBox="0 0 20 20" fill="currentColor" data-slot="icon" aria-hidden="true" class="size-5">
                                <path d="M11.78 5.22a.75.75 0 0 1 0 1.06L8.06 10l3.72 3.72a.75.75 0 1 1-1.06 1.06l-4.25-4.25a.75.75 0 0 1 0-1.06l4.25-4.25a.75.75 0 0 1 1.06 0Z" clip-rule="evenodd" fill-rule="evenodd" />
                            </svg>
                        </button>
                        <template x-for="pageNumber in visiblePageNumbers()" :key="pageNumber">
                            <span>
                                <span x-show="pageNumber === '...'" class="relative inline-flex size-9 items-center justify-center text-sm font-semibold text-gray-700 ring-1 ring-inset ring-gray-300 focus:outline-offset-0">...</span>
                                <button x-show="pageNumber !== '...'" type="button" x-on:click="page = pageNumber" class="relative inline-flex size-9 items-center justify-center text-sm font-semibold focus:z-20 focus:outline-offset-0" :class="page === pageNumber ? 'z-10 bg-indigo-600 text-white focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600' : 'text-gray-900 ring-1 ring-inset ring-gray-300 hover:bg-gray-50'" x-text="pageNumber"></button>
                            </span>
                        </template>
                        <button type="button" x-on:click="page = Math.min(totalPages(), page + 1)" :disabled="page === totalPages()" class="relative inline-flex size-9 items-center justify-center rounded-r-md text-gray-400 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0 disabled:cursor-not-allowed disabled:opacity-40">
                            <span class="sr-only">Next</span>
                            <svg viewBox="0 0 20 20" fill="currentColor" data-slot="icon" aria-hidden="true" class="size-5">
                                <path d="M8.22 5.22a.75.75 0 0 1 1.06 0l4.25 4.25a.75.75 0 0 1 0 1.06l-4.25 4.25a.75.75 0 0 1-1.06-1.06L11.94 10 8.22 6.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" fill-rule="evenodd" />
                            </svg>
                        </button>
                    </nav>
                </div>
            </div>
        </section>

        <section x-cloak x-show="activeNav === 'Leads' && activeTab === 'Lead Campaigns'" class="mx-6 mb-6 mt-5 overflow-hidden rounded-lg bg-white shadow-sm ring-1 ring-gray-900/5">
            <div class="grid min-h-[112px] grid-cols-[250px_1fr_230px] items-start gap-6 p-6">
                <div>
                    <h1 class="text-[19px] font-bold leading-tight tracking-normal">Campaign Runs</h1>
                    <p class="mt-1 max-w-[220px] text-[15px] leading-6 text-gray-500">Multi-line campaign run view for reviewing leads faster.</p>
                </div>

                <div class="relative" x-on:click.outside="searchOpen = false">
                    <div class="rounded-lg bg-white shadow-sm ring-1 ring-gray-900/5">
                        <div class="flex min-h-10 items-center px-4">
                            <input
                                x-model="query"
                                x-on:focus="searchOpen = true"
                                x-on:keydown.escape="searchOpen = false"
                                x-on:keydown.enter.prevent="addFirstSuggestion()"
                                class="w-full border-0 bg-transparent text-[15px] outline-none ring-0 placeholder:text-gray-400 focus:ring-0"
                                placeholder="Filter anything"
                            >
                        </div>
                        <div x-show="filters.length > 0" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-3" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-2" class="flex min-h-10 items-center gap-2 border-t border-gray-200 px-4">
                            <template x-for="tag in filters" :key="tag">
                                <button x-on:click="removeFilter(tag)" class="inline-flex items-center gap-1 rounded-lg border border-gray-200 bg-gray-50 px-2 py-1 text-[15px] leading-none text-gray-600">
                                    <span x-text="tag"></span>
                                    <span class="text-gray-500">×</span>
                                </button>
                            </template>
                            <div class="ml-auto flex items-center gap-4">
                                <button class="text-[14px] font-semibold text-gray-500 hover:text-gray-900" x-on:click="clearSearchTags()">Clear</button>
                                <button class="text-[14px] font-semibold text-gray-600 hover:text-gray-900" x-on:click="savePreset()">Save Preset</button>
                            </div>
                        </div>
                    </div>

                    <div x-cloak x-show="searchOpen" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-3" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-2" class="absolute left-0 right-0 top-0 z-30 rounded-md bg-white p-5 shadow-lg ring-1 ring-gray-900/5">
                        <input x-model="query" x-ref="leadCampaignsOverlayInput" x-init="$watch('searchOpen', value => value && activeTab === 'Lead Campaigns' && $nextTick(() => $refs.leadCampaignsOverlayInput.focus()))" class="w-full border-0 bg-transparent text-[17px] outline-none ring-0 focus:ring-0" placeholder="Filter anything">
                        <div class="filter-scroll mt-4 max-h-[215px] space-y-1 overflow-y-auto pr-2">
                            <template x-for="group in groupedSuggestions()" :key="group.column">
                                <div>
                                    <div class="px-1 py-2 text-[15px] font-semibold" x-text="group.column"></div>
                                    <template x-for="value in group.values" :key="group.column + value">
                                        <button x-on:click="addFilter(value)" class="block w-full rounded-lg px-1 py-2 text-left text-[15px] hover:bg-gray-200" x-text="value"></button>
                                    </template>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>

                <div class="relative ml-auto" x-on:click.outside="presetOpen = false">
                    <button
                        type="button"
                        x-on:click="presetOpen = ! presetOpen"
                        class="flex h-10 min-w-[175px] items-center justify-between gap-3 rounded-md bg-white px-3 text-left text-sm font-medium text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 outline-none transition hover:bg-gray-50 focus:ring-2 focus:ring-inset focus:ring-indigo-600"
                    >
                        <span x-text="selectedPresetName"></span>
                        <span class="outcraft-icon text-gray-600">keyboard_arrow_down</span>
                    </button>
                    <div x-cloak x-show="presetOpen" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-3" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-2" class="absolute right-0 top-12 z-40 w-[230px] overflow-hidden rounded-md bg-white p-1 text-sm text-gray-900 shadow-lg ring-1 ring-gray-900/5">
                        <button type="button" x-on:click="clearFilters()" class="block w-full rounded-lg px-3 py-2 text-left font-semibold hover:bg-gray-200">Clear Filters</button>
                        <template x-for="preset in presets" :key="preset.name">
                            <div class="group flex items-center rounded-lg hover:bg-gray-200">
                                <button type="button" x-on:click="applyPreset(preset)" class="flex min-w-0 flex-1 items-center justify-between px-3 py-2 text-left">
                                    <span class="truncate" x-text="preset.name"></span>
                                    <span x-show="selectedPresetName === preset.name" class="outcraft-icon ml-3 shrink-0 text-blue-500">check</span>
                                </button>
                                <button type="button" x-on:click.stop="deletePreset(preset)" class="mr-2 flex size-8 shrink-0 items-center justify-center rounded-lg text-gray-400 opacity-0 transition hover:bg-red-50 hover:text-red-600 group-hover:opacity-100" :aria-label="`Delete ${preset.name}`">
                                    <span class="outcraft-icon !text-[18px]">delete</span>
                                </button>
                            </div>
                        </template>
                    </div>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="relative w-full min-w-[1080px] table-fixed border-collapse text-[15px]">
                    <thead>
                        <tr class="border-y border-gray-200 bg-gray-50 text-left text-[14px] font-semibold text-gray-950">
                            <th class="w-[225px] px-6 py-4">Campaign</th>
                            <th class="w-[160px] px-4 py-4">Lead</th>
                            <th class="w-[245px] px-4 py-4">Contacts</th>
                            <th class="w-[310px] px-4 py-4">Interaction</th>
                            <th class="sticky right-0 z-10 w-[140px] bg-gray-50 py-4 pr-6 pl-4 text-right shadow-[-12px_0_18px_-18px_rgba(15,23,42,0.45)]"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr x-show="isLoading" x-transition.opacity>
                            <td colspan="5" class="h-[260px] bg-white px-8 py-12 text-center">
                                <div class="mx-auto flex size-[56px] items-center justify-center rounded-xl bg-white" x-html="tableLoaderSvg()"></div>
                            </td>
                        </tr>
                        <template x-for="(row, rowIndex) in loadingRows()" :key="'lead-campaign-multiline-' + row.campaignName + row.name + row.phone + row.email + row.age">
                            <tr :class="rowIndex === loadingRows().length - 1 ? '' : 'border-b border-gray-200'">
                                <td class="px-6 py-5">
                                    <div class="truncate font-medium text-gray-950" x-text="row.campaignName"></div>
                                    <div class="mt-2 flex min-w-0 items-center gap-2">
                                        <span class="inline-flex max-w-[112px] items-center rounded-md px-2 py-1 text-xs font-medium ring-1 ring-inset" :class="campaignPillClass(row.campaignStatus)">
                                            <span class="truncate" x-text="row.campaignStatus"></span>
                                        </span>
                                        <span class="truncate text-gray-500">Created <span x-text="campaignAge(row)"></span></span>
                                    </div>
                                </td>
                                <td class="px-4 py-5">
                                    <div class="truncate font-medium text-gray-950" x-text="campaignLeadFirstName(row)"></div>
                                    <div class="mt-1 truncate text-gray-500" x-text="campaignLeadLastName(row)"></div>
                                </td>
                                <td class="px-4 py-5">
                                    <button type="button" x-on:click="copyContact(row.email)" x-show="row.email" class="group relative block max-w-full cursor-pointer text-left text-gray-950 transition hover:text-indigo-600">
                                        <span class="block truncate" x-text="row.email"></span>
                                        <span class="pointer-events-none absolute bottom-full left-1/2 z-50 mb-2 -translate-x-1/2 translate-y-1 whitespace-nowrap rounded-lg bg-gray-900 px-3 py-2 text-xs font-medium text-white opacity-0 shadow-sm transition group-hover:translate-y-0 group-hover:opacity-100">
                                            <span x-text="row.email"></span>
                                            <span class="ml-2 text-white/70">Click to Copy</span>
                                            <span class="absolute left-1/2 top-full size-2 -translate-x-1/2 -translate-y-1 rotate-45 bg-gray-900"></span>
                                        </span>
                                    </button>
                                    <div x-show="! row.email" class="truncate text-gray-300">No email</div>
                                    <button type="button" x-on:click="copyContact(row.phone)" x-show="row.phone" class="group relative mt-1 block max-w-full cursor-pointer text-left text-gray-500 transition hover:text-indigo-600">
                                        <span class="block truncate" x-text="row.phone"></span>
                                        <span class="pointer-events-none absolute bottom-full left-1/2 z-50 mb-2 -translate-x-1/2 translate-y-1 whitespace-nowrap rounded-lg bg-gray-900 px-3 py-2 text-xs font-medium text-white opacity-0 shadow-sm transition group-hover:translate-y-0 group-hover:opacity-100">
                                            <span x-text="row.phone"></span>
                                            <span class="ml-2 text-white/70">Click to Copy</span>
                                            <span class="absolute left-1/2 top-full size-2 -translate-x-1/2 -translate-y-1 rotate-45 bg-gray-900"></span>
                                        </span>
                                    </button>
                                    <div x-show="! row.phone" class="mt-1 truncate text-gray-300">No phone</div>
                                </td>
                                <td class="px-4 py-5">
                                    <div class="flex min-w-0 items-center gap-2">
                                        <span class="w-[88px] shrink-0 whitespace-nowrap text-gray-500">First</span>
                                        <span class="inline-flex min-w-0 max-w-[200px] items-center rounded-md px-2 py-1 text-xs font-medium ring-1 ring-inset" :class="campaignPillClass(row.firstInteraction)">
                                            <span class="truncate" x-text="row.firstInteraction"></span>
                                        </span>
                                    </div>
                                    <div class="mt-2 flex min-w-0 items-center gap-2">
                                        <span class="w-[88px] shrink-0 whitespace-nowrap text-gray-500">Follow-Up</span>
                                        <span class="inline-flex min-w-0 max-w-[200px] items-center rounded-md px-2 py-1 text-xs font-medium ring-1 ring-inset" :class="campaignPillClass(row.followUp)">
                                            <span class="truncate" x-text="row.followUp || 'Pending'"></span>
                                        </span>
                                    </div>
                                </td>
                                <td class="sticky right-0 bg-white py-5 pr-6 pl-4 text-right font-medium whitespace-nowrap shadow-[-12px_0_18px_-18px_rgba(15,23,42,0.45)]">
                                    <button type="button" class="mr-3 text-indigo-600 transition hover:text-indigo-900">Flow</button>
                                    <button type="button" x-on:click="openLeadDetails(row)" class="text-indigo-600 transition hover:text-indigo-900">View</button>
                                </td>
                            </tr>
                        </template>
                        <tr x-show="! isLoading && filteredRows().length === 0">
                            <td colspan="5" class="px-8 py-16 text-center text-gray-500">No campaign run records match these filters.</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="flex items-center justify-between border-t border-gray-200 bg-white px-4 py-3 sm:px-6">
                <div class="flex flex-1 items-center">
                    <label class="flex items-center gap-3 text-sm text-gray-700">
                        <span>Rows Per Page</span>
                        <span class="grid grid-cols-1">
                            <select x-model.number="perPage" x-on:change="page = 1" class="col-start-1 row-start-1 h-9 appearance-none rounded-md bg-white py-1.5 pr-8 pl-3 text-sm text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600">
                                <template x-for="option in perPageOptions" :key="option">
                                    <option :value="option" x-text="option"></option>
                                </template>
                            </select>
                            <svg viewBox="0 0 16 16" fill="currentColor" data-slot="icon" aria-hidden="true" class="pointer-events-none col-start-1 row-start-1 mr-2 size-4 self-center justify-self-end text-gray-400">
                                <path d="M4.22 6.22a.75.75 0 0 1 1.06 0L8 8.94l2.72-2.72a.75.75 0 1 1 1.06 1.06l-3.25 3.25a.75.75 0 0 1-1.06 0L4.22 7.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" fill-rule="evenodd" />
                            </svg>
                        </span>
                    </label>
                </div>
                <div class="flex flex-1 justify-center text-sm text-gray-700">
                    <span x-text="paginationSummary()"></span>
                </div>
                <div class="flex flex-1 justify-end">
                    <nav aria-label="Pagination" class="isolate inline-flex -space-x-px rounded-md shadow-sm">
                        <button type="button" x-on:click="page = Math.max(1, page - 1)" :disabled="page === 1" class="relative inline-flex size-9 items-center justify-center rounded-l-md text-gray-400 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0 disabled:cursor-not-allowed disabled:opacity-40">
                            <span class="sr-only">Previous</span>
                            <svg viewBox="0 0 20 20" fill="currentColor" data-slot="icon" aria-hidden="true" class="size-5">
                                <path d="M11.78 5.22a.75.75 0 0 1 0 1.06L8.06 10l3.72 3.72a.75.75 0 1 1-1.06 1.06l-4.25-4.25a.75.75 0 0 1 0-1.06l4.25-4.25a.75.75 0 0 1 1.06 0Z" clip-rule="evenodd" fill-rule="evenodd" />
                            </svg>
                        </button>
                        <template x-for="pageNumber in visiblePageNumbers()" :key="pageNumber">
                            <span>
                                <span x-show="pageNumber === '...'" class="relative inline-flex size-9 items-center justify-center text-sm font-semibold text-gray-700 ring-1 ring-inset ring-gray-300 focus:outline-offset-0">...</span>
                                <button x-show="pageNumber !== '...'" type="button" x-on:click="page = pageNumber" class="relative inline-flex size-9 items-center justify-center text-sm font-semibold focus:z-20 focus:outline-offset-0" :class="page === pageNumber ? 'z-10 bg-indigo-600 text-white focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600' : 'text-gray-900 ring-1 ring-inset ring-gray-300 hover:bg-gray-50'" x-text="pageNumber"></button>
                            </span>
                        </template>
                        <button type="button" x-on:click="page = Math.min(totalPages(), page + 1)" :disabled="page === totalPages()" class="relative inline-flex size-9 items-center justify-center rounded-r-md text-gray-400 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0 disabled:cursor-not-allowed disabled:opacity-40">
                            <span class="sr-only">Next</span>
                            <svg viewBox="0 0 20 20" fill="currentColor" data-slot="icon" aria-hidden="true" class="size-5">
                                <path d="M8.22 5.22a.75.75 0 0 1 1.06 0l4.25 4.25a.75.75 0 0 1 0 1.06l-4.25 4.25a.75.75 0 0 1-1.06-1.06L11.94 10 8.22 6.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" fill-rule="evenodd" />
                            </svg>
                        </button>
                    </nav>
                </div>
            </div>
        </section>

        <section x-cloak x-show="activeNav === 'Leads' && activeTab === 'Handoffs'" class="mx-6 mb-6 mt-5 overflow-hidden rounded-lg bg-white shadow-sm ring-1 ring-gray-900/5">
            <div class="grid min-h-[112px] grid-cols-[250px_1fr_230px] items-start gap-6 p-6">
                <div>
                    <h1 class="text-[19px] font-bold leading-tight tracking-normal">Handoff Requests</h1>
                    <p class="mt-1 max-w-[230px] text-[15px] leading-6 text-gray-500">Leads that have requested a handoff from AI to a human support.</p>
                </div>

                <div class="relative" x-on:click.outside="searchOpen = false">
                    <div class="rounded-lg bg-white shadow-sm ring-1 ring-gray-900/5">
                        <div class="flex min-h-10 items-center px-4">
                            <input
                                x-model="query"
                                x-on:focus="searchOpen = true"
                                x-on:keydown.escape="searchOpen = false"
                                x-on:keydown.enter.prevent="addFirstSuggestion()"
                                class="w-full border-0 bg-transparent text-[15px] outline-none ring-0 placeholder:text-gray-400 focus:ring-0"
                                placeholder="Filter anything"
                            >
                        </div>
                        <div x-show="filters.length > 0" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-3" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-2" class="flex min-h-10 items-center gap-2 border-t border-gray-200 px-4">
                            <template x-for="tag in filters" :key="tag">
                                <button x-on:click="removeFilter(tag)" class="inline-flex items-center gap-1 rounded-lg border border-gray-200 bg-gray-50 px-2 py-1 text-[15px] leading-none text-gray-600">
                                    <span x-text="tag"></span>
                                    <span class="text-gray-500">×</span>
                                </button>
                            </template>
                            <div class="ml-auto flex items-center gap-4">
                                <button class="text-[14px] font-semibold text-gray-500 hover:text-gray-900" x-on:click="clearSearchTags()">Clear</button>
                                <button class="text-[14px] font-semibold text-gray-600 hover:text-gray-900" x-on:click="savePreset()">Save Preset</button>
                            </div>
                        </div>
                    </div>

                    <div x-cloak x-show="searchOpen" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-3" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-2" class="absolute left-0 right-0 top-0 z-30 rounded-md bg-white p-5 shadow-lg ring-1 ring-gray-900/5">
                        <input x-model="query" x-ref="handoffsOverlayInput" x-init="$watch('searchOpen', value => value && activeTab === 'Handoffs' && $nextTick(() => $refs.handoffsOverlayInput.focus()))" class="w-full border-0 bg-transparent text-[17px] outline-none ring-0 focus:ring-0" placeholder="Filter anything">
                        <div class="filter-scroll mt-4 max-h-[215px] space-y-1 overflow-y-auto pr-2">
                            <template x-for="group in groupedSuggestions()" :key="group.column">
                                <div>
                                    <div class="px-1 py-2 text-[15px] font-semibold" x-text="group.column"></div>
                                    <template x-for="value in group.values" :key="group.column + value">
                                        <button x-on:click="addFilter(value)" class="block w-full rounded-lg px-1 py-2 text-left text-[15px] hover:bg-gray-200" x-text="value"></button>
                                    </template>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>

                <div class="relative ml-auto" x-on:click.outside="presetOpen = false">
                    <button
                        type="button"
                        x-on:click="presetOpen = ! presetOpen"
                        class="flex h-10 min-w-[175px] items-center justify-between gap-3 rounded-md bg-white px-3 text-left text-sm font-medium text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 outline-none transition hover:bg-gray-50 focus:ring-2 focus:ring-inset focus:ring-indigo-600"
                    >
                        <span x-text="selectedPresetName"></span>
                        <span class="outcraft-icon text-gray-600">keyboard_arrow_down</span>
                    </button>
                    <div x-cloak x-show="presetOpen" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-3" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-2" class="absolute right-0 top-12 z-40 w-[230px] overflow-hidden rounded-md bg-white p-1 text-sm text-gray-900 shadow-lg ring-1 ring-gray-900/5">
                        <button type="button" x-on:click="clearFilters()" class="block w-full rounded-lg px-3 py-2 text-left font-semibold hover:bg-gray-200">Clear Filters</button>
                        <template x-for="preset in presets" :key="preset.name">
                            <div class="group flex items-center rounded-lg hover:bg-gray-200">
                                <button type="button" x-on:click="applyPreset(preset)" class="flex min-w-0 flex-1 items-center justify-between px-3 py-2 text-left">
                                    <span class="truncate" x-text="preset.name"></span>
                                    <span x-show="selectedPresetName === preset.name" class="outcraft-icon ml-3 shrink-0 text-blue-500">check</span>
                                </button>
                                <button type="button" x-on:click.stop="deletePreset(preset)" class="mr-2 flex size-8 shrink-0 items-center justify-center rounded-lg text-gray-400 opacity-0 transition hover:bg-red-50 hover:text-red-600 group-hover:opacity-100" :aria-label="`Delete ${preset.name}`">
                                    <span class="outcraft-icon !text-[18px]">delete</span>
                                </button>
                            </div>
                        </template>
                    </div>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full min-w-[1080px] table-fixed border-collapse text-[15px]">
                    <thead>
                        <tr class="border-y border-gray-200 bg-gray-50 text-left text-[14px] font-semibold text-gray-950">
                            <th class="w-[240px] px-6 py-4">Name</th>
                            <th class="w-[240px] px-4 py-4">Phone</th>
                            <th class="w-[240px] px-4 py-4">Email</th>
                            <th class="w-[90px] px-4 py-4">Country</th>
                            <th class="w-[170px] px-4 py-4">Timezone</th>
                            <th class="w-[120px] px-4 py-4">Created</th>
                            <th class="w-[92px] px-4 py-4"></th>
                            <th class="w-[112px] py-4 pr-6 pl-4"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr x-show="isLoading" x-transition.opacity>
                            <td colspan="8" class="h-[260px] bg-white px-8 py-12 text-center">
                                <div class="mx-auto flex size-[56px] items-center justify-center rounded-xl bg-white" x-html="tableLoaderSvg()"></div>
                            </td>
                        </tr>
                        <template x-for="(row, rowIndex) in loadingRows()" :key="'handoff-' + row.name + row.phone + row.email + row.age">
                            <tr :class="rowIndex === loadingRows().length - 1 ? '' : 'border-b border-gray-200'">
                                <td class="px-6 py-4">
                                    <span class="group relative inline-flex max-w-full">
                                        <span class="truncate" x-text="row.name"></span>
                                        <span class="pointer-events-none absolute bottom-full left-1/2 z-50 mb-2 -translate-x-1/2 translate-y-1 whitespace-nowrap rounded-lg bg-gray-900 px-3 py-2 text-xs font-medium text-white opacity-0 shadow-sm transition group-hover:translate-y-0 group-hover:opacity-100">
                                            <span x-text="row.name"></span>
                                            <span class="absolute left-1/2 top-full size-2 -translate-x-1/2 -translate-y-1 rotate-45 bg-gray-900"></span>
                                        </span>
                                    </span>
                                </td>
                                <td class="px-4 py-4">
                                    <span x-show="! row.phone" class="text-gray-300"></span>
                                    <span x-show="row.phone" class="group relative inline-flex">
                                        <span x-text="row.phone"></span>
                                        <span class="pointer-events-none absolute bottom-full left-1/2 z-50 mb-2 -translate-x-1/2 translate-y-1 whitespace-nowrap rounded-lg bg-gray-900 px-3 py-2 text-xs font-medium text-white opacity-0 shadow-sm transition group-hover:translate-y-0 group-hover:opacity-100">
                                            <span class="mr-1" x-text="row.phoneFlag"></span>
                                            <span x-text="row.phoneCountry"></span>
                                            <span class="absolute left-1/2 top-full size-2 -translate-x-1/2 -translate-y-1 rotate-45 bg-gray-900"></span>
                                        </span>
                                    </span>
                                </td>
                                <td class="px-4 py-4">
                                    <span x-show="! row.email" class="text-gray-300"></span>
                                    <span x-show="row.email" class="group relative inline-flex max-w-full">
                                        <span class="truncate" x-text="shortLeadEmail(row.email)"></span>
                                        <span class="pointer-events-none absolute bottom-full left-1/2 z-50 mb-2 -translate-x-1/2 translate-y-1 whitespace-nowrap rounded-lg bg-gray-900 px-3 py-2 text-xs font-medium text-white opacity-0 shadow-sm transition group-hover:translate-y-0 group-hover:opacity-100">
                                            <span x-text="row.email"></span>
                                            <span class="absolute left-1/2 top-full size-2 -translate-x-1/2 -translate-y-1 rotate-45 bg-gray-900"></span>
                                        </span>
                                    </span>
                                </td>
                                <td class="px-4 py-4"><span class="mr-1" x-text="row.countryFlag"></span><span x-text="row.country"></span></td>
                                <td class="px-4 py-4">
                                    <span class="group relative block max-w-full">
                                        <span class="block truncate" x-text="row.timezone"></span>
                                        <span class="pointer-events-none absolute bottom-full left-1/2 z-50 mb-2 -translate-x-1/2 translate-y-1 whitespace-nowrap rounded-lg bg-gray-900 px-3 py-2 text-xs font-medium text-white opacity-0 shadow-sm transition group-hover:translate-y-0 group-hover:opacity-100">
                                            <span x-text="row.timezone"></span>
                                            <span class="absolute left-1/2 top-full size-2 -translate-x-1/2 -translate-y-1 rotate-45 bg-gray-900"></span>
                                        </span>
                                    </span>
                                </td>
                                <td class="px-4 py-4">
                                    <span class="group relative inline-flex">
                                        <span>Created </span><span x-text="leadAge(row)"></span>
                                        <span class="pointer-events-none absolute bottom-full left-1/2 z-50 mb-2 -translate-x-1/2 translate-y-1 whitespace-nowrap rounded-lg bg-gray-900 px-3 py-2 text-xs font-medium text-white opacity-0 shadow-sm transition group-hover:translate-y-0 group-hover:opacity-100">
                                            <span x-text="row.ageTooltip"></span>
                                            <span class="absolute left-1/2 top-full size-2 -translate-x-1/2 -translate-y-1 rotate-45 bg-gray-900"></span>
                                        </span>
                                    </span>
                                </td>
                                <td class="px-4 py-4 text-right">
                                    <button type="button" x-on:click="openLeadDetails(row)" class="font-semibold text-gray-600 transition hover:text-gray-950">View</button>
                                </td>
                                <td class="py-4 pr-6 pl-4 text-right font-semibold text-gray-600 transition hover:text-gray-950">Resolve</td>
                            </tr>
                        </template>
                        <tr x-show="! isLoading && filteredRows().length === 0">
                            <td colspan="8" class="px-8 py-16 text-center text-gray-500">No handoff requests match these filters.</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="flex items-center justify-between border-t border-gray-200 bg-white px-4 py-3 sm:px-6">
                <div class="flex flex-1 items-center">
                    <label class="flex items-center gap-3 text-sm text-gray-700">
                        <span>Rows Per Page</span>
                        <span class="grid grid-cols-1">
                            <select x-model.number="perPage" x-on:change="page = 1" class="col-start-1 row-start-1 h-9 appearance-none rounded-md bg-white py-1.5 pr-8 pl-3 text-sm text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600">
                                <template x-for="option in perPageOptions" :key="option">
                                    <option :value="option" x-text="option"></option>
                                </template>
                            </select>
                            <svg viewBox="0 0 16 16" fill="currentColor" data-slot="icon" aria-hidden="true" class="pointer-events-none col-start-1 row-start-1 mr-2 size-4 self-center justify-self-end text-gray-400">
                                <path d="M4.22 6.22a.75.75 0 0 1 1.06 0L8 8.94l2.72-2.72a.75.75 0 1 1 1.06 1.06l-3.25 3.25a.75.75 0 0 1-1.06 0L4.22 7.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" fill-rule="evenodd" />
                            </svg>
                        </span>
                    </label>
                </div>
                <div class="flex flex-1 justify-center text-sm text-gray-700">
                    <span x-text="paginationSummary()"></span>
                </div>
                <div class="flex flex-1 justify-end">
                    <nav aria-label="Pagination" class="isolate inline-flex -space-x-px rounded-md shadow-sm">
                        <button type="button" x-on:click="page = Math.max(1, page - 1)" :disabled="page === 1" class="relative inline-flex size-9 items-center justify-center rounded-l-md text-gray-400 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0 disabled:cursor-not-allowed disabled:opacity-40">
                            <span class="sr-only">Previous</span>
                            <svg viewBox="0 0 20 20" fill="currentColor" data-slot="icon" aria-hidden="true" class="size-5">
                                <path d="M11.78 5.22a.75.75 0 0 1 0 1.06L8.06 10l3.72 3.72a.75.75 0 1 1-1.06 1.06l-4.25-4.25a.75.75 0 0 1 0-1.06l4.25-4.25a.75.75 0 0 1 1.06 0Z" clip-rule="evenodd" fill-rule="evenodd" />
                            </svg>
                        </button>
                        <template x-for="pageNumber in visiblePageNumbers()" :key="pageNumber">
                            <span>
                                <span x-show="pageNumber === '...'" class="relative inline-flex size-9 items-center justify-center text-sm font-semibold text-gray-700 ring-1 ring-inset ring-gray-300 focus:outline-offset-0">...</span>
                                <button x-show="pageNumber !== '...'" type="button" x-on:click="page = pageNumber" class="relative inline-flex size-9 items-center justify-center text-sm font-semibold focus:z-20 focus:outline-offset-0" :class="page === pageNumber ? 'z-10 bg-indigo-600 text-white focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600' : 'text-gray-900 ring-1 ring-inset ring-gray-300 hover:bg-gray-50'" x-text="pageNumber"></button>
                            </span>
                        </template>
                        <button type="button" x-on:click="page = Math.min(totalPages(), page + 1)" :disabled="page === totalPages()" class="relative inline-flex size-9 items-center justify-center rounded-r-md text-gray-400 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0 disabled:cursor-not-allowed disabled:opacity-40">
                            <span class="sr-only">Next</span>
                            <svg viewBox="0 0 20 20" fill="currentColor" data-slot="icon" aria-hidden="true" class="size-5">
                                <path d="M8.22 5.22a.75.75 0 0 1 1.06 0l4.25 4.25a.75.75 0 0 1 0 1.06l-4.25 4.25a.75.75 0 0 1-1.06-1.06L11.94 10 8.22 6.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" fill-rule="evenodd" />
                            </svg>
                        </button>
                    </nav>
                </div>
            </div>
        </section>

        <section x-cloak x-show="activeNav === 'Leads' && activeTab === 'Outreach'" class="mx-6 mb-6 mt-5 overflow-hidden rounded-lg bg-white shadow-sm ring-1 ring-gray-900/5">
            <div class="grid min-h-[114px] grid-cols-[220px_1fr_230px] items-start gap-6 p-6">
                <h1 class="pt-1 text-[19px] font-bold leading-tight tracking-normal">Interactions</h1>

                <div class="relative" x-on:click.outside="searchOpen = false">
                    <div class="rounded-lg bg-white shadow-sm ring-1 ring-gray-900/5">
                        <div class="flex min-h-10 items-center px-4">
                            <input
                                x-model="query"
                                x-on:focus="searchOpen = true"
                                x-on:keydown.escape="searchOpen = false"
                                x-on:keydown.enter.prevent="addFirstSuggestion()"
                                class="w-full border-0 bg-transparent text-[15px] outline-none ring-0 placeholder:text-gray-400 focus:ring-0"
                                placeholder="Filter anything"
                            >
                        </div>
                        <div x-show="filters.length > 0" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-3" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-2" class="flex min-h-10 items-center gap-2 border-t border-gray-200 px-4">
                            <template x-for="tag in filters" :key="tag">
                                <button x-on:click="removeFilter(tag)" class="inline-flex items-center gap-1 rounded-lg border border-gray-200 bg-gray-50 px-2 py-1 text-[15px] leading-none text-gray-600">
                                    <span x-text="tag"></span>
                                    <span class="text-gray-500">×</span>
                                </button>
                            </template>
                            <div class="ml-auto flex items-center gap-4">
                                <button class="text-[14px] font-semibold text-gray-500 hover:text-gray-900" x-on:click="clearSearchTags()">Clear</button>
                                <button class="text-[14px] font-semibold text-gray-600 hover:text-gray-900" x-on:click="savePreset()">Save Preset</button>
                            </div>
                        </div>
                    </div>

                    <div x-cloak x-show="searchOpen" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-3" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-2" class="absolute left-0 right-0 top-0 z-30 rounded-md bg-white p-5 shadow-lg ring-1 ring-gray-900/5">
                        <input x-model="query" x-ref="overlayInput" x-init="$watch('searchOpen', value => value && activeTab === 'Outreach' && $nextTick(() => $refs.overlayInput.focus()))" class="w-full border-0 bg-transparent text-[17px] outline-none ring-0 focus:ring-0" placeholder="Filter anything">
                        <div class="filter-scroll mt-4 max-h-[215px] space-y-1 overflow-y-auto pr-2">
                            <template x-for="group in groupedSuggestions()" :key="group.column">
                                <div>
                                    <div class="px-1 py-2 text-[15px] font-semibold" x-text="group.column"></div>
                                    <template x-for="value in group.values" :key="group.column + value">
                                        <button x-on:click="addFilter(value)" class="block w-full rounded-lg px-1 py-2 text-left text-[15px] hover:bg-gray-200" x-text="value"></button>
                                    </template>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>

                <div class="relative ml-auto" x-on:click.outside="presetOpen = false">
                    <button
                        type="button"
                        x-on:click="presetOpen = ! presetOpen"
                        class="flex h-10 min-w-[190px] items-center justify-between gap-3 rounded-md bg-white px-3 text-left text-sm font-medium text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 outline-none transition hover:bg-gray-50 focus:ring-2 focus:ring-inset focus:ring-indigo-600"
                    >
                        <span x-text="selectedPresetName"></span>
                        <span class="outcraft-icon text-gray-600">keyboard_arrow_down</span>
                    </button>
                    <div
                        x-cloak
                        x-show="presetOpen"
                        x-transition
                        class="absolute right-0 top-12 z-40 w-[230px] overflow-hidden rounded-md bg-white p-1 text-sm text-gray-900 shadow-lg ring-1 ring-gray-900/5"
                    >
                        <button
                            type="button"
                            x-on:click="clearFilters()"
                            class="block w-full rounded-lg px-3 py-2 text-left font-semibold hover:bg-gray-200"
                        >
                            Clear Filters
                        </button>
                        <template x-for="preset in presets" :key="preset.name">
                            <div class="group flex items-center rounded-lg hover:bg-gray-200">
                                <button
                                    type="button"
                                    x-on:click="applyPreset(preset)"
                                    class="flex min-w-0 flex-1 items-center justify-between px-3 py-2 text-left"
                                >
                                    <span class="truncate" x-text="preset.name"></span>
                                    <span x-show="selectedPresetName === preset.name" class="outcraft-icon ml-3 shrink-0 text-blue-500">check</span>
                                </button>
                                <button
                                    type="button"
                                    x-on:click.stop="deletePreset(preset)"
                                    class="mr-2 flex size-8 shrink-0 items-center justify-center rounded-lg text-gray-400 opacity-0 transition hover:bg-red-50 hover:text-red-600 group-hover:opacity-100"
                                    :aria-label="`Delete ${preset.name}`"
                                >
                                    <span class="outcraft-icon !text-[18px]">delete</span>
                                </button>
                            </div>
                        </template>
                    </div>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full min-w-[1180px] table-fixed border-collapse text-[15px]">
                    <thead>
                        <tr class="border-y border-gray-200 bg-gray-50 text-left text-[14px] font-semibold text-gray-950">
                            <th class="w-[160px] px-6 py-4">Name</th>
                            <th class="w-[155px] px-4 py-4">Phone</th>
                            <th class="w-[165px] px-4 py-4">Email</th>
                            <th class="w-[95px] px-4 py-4">Channel</th>
                            <th class="w-[100px] px-4 py-4">Content</th>
                            <th class="w-[135px] px-4 py-4">Direction</th>
                            <th class="w-[160px] px-4 py-4">Outcome</th>
                            <th class="w-[120px] px-4 py-4">Result</th>
                            <th class="w-[120px] px-4 py-4">
                                <button type="button" x-on:click="toggleAgeSort()" class="flex items-center gap-1 rounded-md font-semibold hover:text-gray-600">
                                    <span>Created</span>
                                    <span class="outcraft-icon !text-[16px]" x-text="ageSortDirection === 'asc' ? 'arrow_upward' : 'arrow_downward'"></span>
                                </button>
                            </th>
                            <th class="w-[96px] py-4 pr-6 pl-4"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr x-show="isLoading" x-transition.opacity>
                            <td colspan="10" class="h-[260px] bg-white px-8 py-12 text-center">
                                <div class="mx-auto flex size-[56px] items-center justify-center rounded-xl bg-white" x-html="tableLoaderSvg()"></div>
                            </td>
                        </tr>
                        <template x-for="(row, rowIndex) in loadingRows()" :key="row.name + row.email + row.age + row.result">
                            <tr :class="rowIndex === loadingRows().length - 1 ? '' : 'border-b border-gray-200'">
                                <td class="px-6 py-4">
                                    <span class="group relative inline-flex max-w-full">
                                        <span class="truncate" x-text="row.name"></span>
                                        <span class="pointer-events-none absolute bottom-full left-1/2 z-50 mb-2 -translate-x-1/2 translate-y-1 whitespace-nowrap rounded-lg bg-gray-900 px-3 py-2 text-xs font-medium text-white opacity-0 shadow-sm transition group-hover:translate-y-0 group-hover:opacity-100">
                                            <span x-text="row.name"></span>
                                            <span class="absolute left-1/2 top-full size-2 -translate-x-1/2 -translate-y-1 rotate-45 bg-gray-900"></span>
                                        </span>
                                    </span>
                                </td>
                                <td class="px-4 py-4">
                                    <span x-show="! row.phone" class="text-gray-300"></span>
                                    <span x-show="row.phone" class="group relative inline-flex">
                                        <span x-text="row.phone"></span>
                                        <span class="pointer-events-none absolute bottom-full left-1/2 z-50 mb-2 -translate-x-1/2 translate-y-1 whitespace-nowrap rounded-lg bg-gray-900 px-3 py-2 text-xs font-medium text-white opacity-0 shadow-sm transition group-hover:translate-y-0 group-hover:opacity-100">
                                            <span class="mr-1" x-text="row.phoneFlag"></span>
                                            <span x-text="row.phoneCountry"></span>
                                            <span class="absolute left-1/2 top-full size-2 -translate-x-1/2 -translate-y-1 rotate-45 bg-gray-900"></span>
                                        </span>
                                    </span>
                                </td>
                                <td class="px-4 py-4">
                                    <span x-show="! row.email" class="text-gray-300"></span>
                                    <span x-show="row.email" class="group relative inline-flex max-w-full">
                                        <span class="truncate" x-text="shortEmail(row.email)"></span>
                                        <span class="pointer-events-none absolute bottom-full left-1/2 z-50 mb-2 -translate-x-1/2 translate-y-1 whitespace-nowrap rounded-lg bg-gray-900 px-3 py-2 text-xs font-medium text-white opacity-0 shadow-sm transition group-hover:translate-y-0 group-hover:opacity-100">
                                            <span x-text="row.email"></span>
                                            <span class="absolute left-1/2 top-full size-2 -translate-x-1/2 -translate-y-1 rotate-45 bg-gray-900"></span>
                                        </span>
                                    </span>
                                </td>
                                <td class="px-4 py-4" x-text="row.channel"></td>
                                <td class="px-4 py-4">
                                    <button type="button" x-show="row.content === 'View'" x-on:click="openLeadDetails(row)" class="group relative inline-flex text-left">
                                        <span class="outcraft-label inline-flex max-w-[76px] cursor-pointer rounded-md bg-gray-50 px-2 py-1 text-xs font-medium text-gray-600 ring-1 ring-inset ring-gray-500/10 transition group-hover:text-gray-950">
                                            <span class="truncate">View</span>
                                        </span>
                                        <span class="pointer-events-none absolute bottom-full left-1/2 z-50 mb-2 w-[320px] -translate-x-1/2 translate-y-1 rounded-lg bg-gray-900 px-4 py-3 text-left text-xs font-medium leading-5 text-white opacity-0 shadow-sm transition group-hover:translate-y-0 group-hover:opacity-100">
                                            <span x-text="row.contentPreview"></span>
                                            <span class="absolute left-1/2 top-full size-2 -translate-x-1/2 -translate-y-1 rotate-45 bg-gray-900"></span>
                                        </span>
                                    </button>
                                    <span x-show="row.content && row.content !== 'View'" class="group relative inline-flex">
                                        <span class="outcraft-label inline-flex max-w-[76px] cursor-pointer items-center gap-1 rounded-md bg-gray-50 px-2 py-1 text-xs font-medium text-gray-600 ring-1 ring-inset ring-gray-500/10 transition group-hover:text-gray-950">
                                            <span class="outcraft-icon !text-[18px] !leading-[18px] ">play_circle</span>
                                            <span class="truncate leading-[18px]" x-text="row.content"></span>
                                        </span>
                                        <span class="pointer-events-none absolute bottom-full left-1/2 z-50 mb-2 -translate-x-1/2 translate-y-1 whitespace-nowrap rounded-lg bg-gray-900 px-3 py-2 text-xs font-medium text-white opacity-0 shadow-sm transition group-hover:translate-y-0 group-hover:opacity-100">
                                            Listen
                                            <span class="absolute left-1/2 top-full size-2 -translate-x-1/2 -translate-y-1 rotate-45 bg-gray-900"></span>
                                        </span>
                                    </span>
                                </td>
                                <td class="px-4 py-4">
                                    <span class="group relative inline-flex">
                                        <span class="outcraft-label inline-flex max-w-[112px] rounded-md bg-gray-50 px-2 py-1 text-xs font-medium text-gray-600 ring-1 ring-inset ring-gray-500/10">
                                            <span class="truncate" x-text="row.direction"></span>
                                        </span>
                                        <span class="pointer-events-none absolute bottom-full left-1/2 z-50 mb-2 -translate-x-1/2 translate-y-1 whitespace-nowrap rounded-lg bg-gray-900 px-3 py-2 text-xs font-medium text-white opacity-0 shadow-sm transition group-hover:translate-y-0 group-hover:opacity-100">
                                            <span x-text="row.direction"></span>
                                            <span class="absolute left-1/2 top-full size-2 -translate-x-1/2 -translate-y-1 rotate-45 bg-gray-900"></span>
                                        </span>
                                    </span>
                                </td>
                                <td class="px-4 py-4">
                                    <span class="group relative inline-flex">
                                        <span class="outcraft-label inline-flex max-w-[138px] rounded-md px-2 py-1 text-xs font-medium ring-1 ring-inset" :class="pillClass(row.outcome)">
                                            <span class="truncate" x-text="row.outcome"></span>
                                        </span>
                                        <span class="pointer-events-none absolute bottom-full left-1/2 z-50 mb-2 -translate-x-1/2 translate-y-1 whitespace-nowrap rounded-lg bg-gray-900 px-3 py-2 text-xs font-medium text-white opacity-0 shadow-sm transition group-hover:translate-y-0 group-hover:opacity-100">
                                            <span x-text="row.outcome"></span>
                                            <span class="absolute left-1/2 top-full size-2 -translate-x-1/2 -translate-y-1 rotate-45 bg-gray-900"></span>
                                        </span>
                                    </span>
                                </td>
                                <td class="px-4 py-4">
                                    <span class="group relative inline-flex">
                                        <span class="outcraft-label inline-flex max-w-[98px] rounded-md px-2 py-1 text-xs font-medium ring-1 ring-inset" :class="pillClass(row.result)">
                                            <span class="truncate" x-text="row.result"></span>
                                        </span>
                                        <span class="pointer-events-none absolute bottom-full left-1/2 z-50 mb-2 -translate-x-1/2 translate-y-1 whitespace-nowrap rounded-lg bg-gray-900 px-3 py-2 text-xs font-medium text-white opacity-0 shadow-sm transition group-hover:translate-y-0 group-hover:opacity-100">
                                            <span x-text="row.result"></span>
                                            <span class="absolute left-1/2 top-full size-2 -translate-x-1/2 -translate-y-1 rotate-45 bg-gray-900"></span>
                                        </span>
                                    </span>
                                </td>
                                <td class="px-4 py-4">
                                    <span class="group relative inline-flex">
                                        <span>Created </span><span x-text="leadAge(row)"></span>
                                        <span class="pointer-events-none absolute bottom-full left-1/2 z-50 mb-2 -translate-x-1/2 translate-y-1 whitespace-nowrap rounded-lg bg-gray-900 px-3 py-2 text-xs font-medium text-white opacity-0 shadow-sm transition group-hover:translate-y-0 group-hover:opacity-100">
                                            <span x-text="row.ageTooltip"></span>
                                            <span class="absolute left-1/2 top-full size-2 -translate-x-1/2 -translate-y-1 rotate-45 bg-gray-900"></span>
                                        </span>
                                    </span>
                                </td>
                                <td class="py-4 pr-6 pl-4 text-right">
                                    <button type="button" x-on:click="openLeadDetails(row)" class="font-semibold text-gray-600 transition hover:text-gray-950">View</button>
                                </td>
                            </tr>
                        </template>
                        <tr x-show="! isLoading && filteredRows().length === 0">
                            <td colspan="10" class="px-8 py-16 text-center text-gray-500">No outreach records match these filters.</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="flex items-center justify-between border-t border-gray-200 bg-white px-4 py-3 sm:px-6">
                <div class="flex flex-1 items-center">
                    <label class="flex items-center gap-3 text-sm text-gray-700">
                        <span>Rows Per Page</span>
                        <span class="grid grid-cols-1">
                            <select x-model.number="perPage" x-on:change="page = 1" class="col-start-1 row-start-1 h-9 appearance-none rounded-md bg-white py-1.5 pr-8 pl-3 text-sm text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600">
                                <template x-for="option in perPageOptions" :key="option">
                                    <option :value="option" x-text="option"></option>
                                </template>
                            </select>
                            <svg viewBox="0 0 16 16" fill="currentColor" data-slot="icon" aria-hidden="true" class="pointer-events-none col-start-1 row-start-1 mr-2 size-4 self-center justify-self-end text-gray-400">
                                <path d="M4.22 6.22a.75.75 0 0 1 1.06 0L8 8.94l2.72-2.72a.75.75 0 1 1 1.06 1.06l-3.25 3.25a.75.75 0 0 1-1.06 0L4.22 7.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" fill-rule="evenodd" />
                            </svg>
                        </span>
                    </label>
                </div>
                <div class="flex flex-1 justify-center text-sm text-gray-700">
                    <span x-text="paginationSummary()"></span>
                </div>
                <div class="flex flex-1 justify-end">
                    <nav aria-label="Pagination" class="isolate inline-flex -space-x-px rounded-md shadow-sm">
                        <button type="button" x-on:click="page = Math.max(1, page - 1)" :disabled="page === 1" class="relative inline-flex size-9 items-center justify-center rounded-l-md text-gray-400 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0 disabled:cursor-not-allowed disabled:opacity-40">
                            <span class="sr-only">Previous</span>
                            <svg viewBox="0 0 20 20" fill="currentColor" data-slot="icon" aria-hidden="true" class="size-5">
                                <path d="M11.78 5.22a.75.75 0 0 1 0 1.06L8.06 10l3.72 3.72a.75.75 0 1 1-1.06 1.06l-4.25-4.25a.75.75 0 0 1 0-1.06l4.25-4.25a.75.75 0 0 1 1.06 0Z" clip-rule="evenodd" fill-rule="evenodd" />
                            </svg>
                        </button>
                        <template x-for="pageNumber in visiblePageNumbers()" :key="pageNumber">
                            <span>
                                <span x-show="pageNumber === '...'" class="relative inline-flex size-9 items-center justify-center text-sm font-semibold text-gray-700 ring-1 ring-inset ring-gray-300 focus:outline-offset-0">...</span>
                                <button x-show="pageNumber !== '...'" type="button" x-on:click="page = pageNumber" class="relative inline-flex size-9 items-center justify-center text-sm font-semibold focus:z-20 focus:outline-offset-0" :class="page === pageNumber ? 'z-10 bg-indigo-600 text-white focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600' : 'text-gray-900 ring-1 ring-inset ring-gray-300 hover:bg-gray-50'" x-text="pageNumber"></button>
                            </span>
                        </template>
                        <button type="button" x-on:click="page = Math.min(totalPages(), page + 1)" :disabled="page === totalPages()" class="relative inline-flex size-9 items-center justify-center rounded-r-md text-gray-400 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0 disabled:cursor-not-allowed disabled:opacity-40">
                            <span class="sr-only">Next</span>
                            <svg viewBox="0 0 20 20" fill="currentColor" data-slot="icon" aria-hidden="true" class="size-5">
                                <path d="M8.22 5.22a.75.75 0 0 1 1.06 0l4.25 4.25a.75.75 0 0 1 0 1.06l-4.25 4.25a.75.75 0 0 1-1.06-1.06L11.94 10 8.22 6.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" fill-rule="evenodd" />
                            </svg>
                        </button>
                    </nav>
                </div>
            </div>
        </section>

        <section x-cloak x-show="activeNav === 'Leads' && activeTab === 'Outreach Review'" class="mx-6 mb-6 mt-5 overflow-hidden rounded-lg bg-white shadow-sm ring-1 ring-gray-900/5">
            <div class="grid min-h-[114px] grid-cols-[220px_1fr_230px] items-start gap-6 p-6">
                <h1 class="pt-1 text-[19px] font-bold leading-tight tracking-normal">Interaction</h1>

                <div class="relative" x-on:click.outside="searchOpen = false">
                    <div class="rounded-lg bg-white shadow-sm ring-1 ring-gray-900/5">
                        <div class="flex min-h-10 items-center px-4">
                            <input
                                x-model="query"
                                x-on:focus="searchOpen = true"
                                x-on:keydown.escape="searchOpen = false"
                                x-on:keydown.enter.prevent="addFirstSuggestion()"
                                class="w-full border-0 bg-transparent text-[15px] outline-none ring-0 placeholder:text-gray-400 focus:ring-0"
                                placeholder="Filter anything"
                            >
                        </div>
                        <div x-show="filters.length > 0" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-3" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-2" class="flex min-h-10 items-center gap-2 border-t border-gray-200 px-4">
                            <template x-for="tag in filters" :key="tag">
                                <button x-on:click="removeFilter(tag)" class="inline-flex items-center gap-1 rounded-lg border border-gray-200 bg-gray-50 px-2 py-1 text-[15px] leading-none text-gray-600">
                                    <span x-text="tag"></span>
                                    <span class="text-gray-500">×</span>
                                </button>
                            </template>
                            <div class="ml-auto flex items-center gap-4">
                                <button class="text-[14px] font-semibold text-gray-500 hover:text-gray-900" x-on:click="clearSearchTags()">Clear</button>
                                <button class="text-[14px] font-semibold text-gray-600 hover:text-gray-900" x-on:click="savePreset()">Save Preset</button>
                            </div>
                        </div>
                    </div>

                    <div x-cloak x-show="searchOpen" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-3" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-2" class="absolute left-0 right-0 top-0 z-30 rounded-md bg-white p-5 shadow-lg ring-1 ring-gray-900/5">
                        <input x-model="query" x-ref="outreachReviewOverlayInput" x-init="$watch('searchOpen', value => value && activeTab === 'Outreach Review' && $nextTick(() => $refs.outreachReviewOverlayInput.focus()))" class="w-full border-0 bg-transparent text-[17px] outline-none ring-0 focus:ring-0" placeholder="Filter anything">
                        <div class="filter-scroll mt-4 max-h-[215px] space-y-1 overflow-y-auto pr-2">
                            <template x-for="group in groupedSuggestions()" :key="group.column">
                                <div>
                                    <div class="px-1 py-2 text-[15px] font-semibold" x-text="group.column"></div>
                                    <template x-for="value in group.values" :key="group.column + value">
                                        <button x-on:click="addFilter(value)" class="block w-full rounded-lg px-1 py-2 text-left text-[15px] hover:bg-gray-200" x-text="value"></button>
                                    </template>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>

                <div class="relative ml-auto" x-on:click.outside="presetOpen = false">
                    <button
                        type="button"
                        x-on:click="presetOpen = ! presetOpen"
                        class="flex h-10 min-w-[190px] items-center justify-between gap-3 rounded-md bg-white px-3 text-left text-sm font-medium text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 outline-none transition hover:bg-gray-50 focus:ring-2 focus:ring-inset focus:ring-indigo-600"
                    >
                        <span x-text="selectedPresetName"></span>
                        <span class="outcraft-icon text-gray-600">keyboard_arrow_down</span>
                    </button>
                    <div x-cloak x-show="presetOpen" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-3" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-2" class="absolute right-0 top-12 z-40 w-[230px] overflow-hidden rounded-md bg-white p-1 text-sm text-gray-900 shadow-lg ring-1 ring-gray-900/5">
                        <button type="button" x-on:click="clearFilters()" class="block w-full rounded-lg px-3 py-2 text-left font-semibold hover:bg-gray-200">Clear Filters</button>
                        <template x-for="preset in presets" :key="preset.name">
                            <div class="group flex items-center rounded-lg hover:bg-gray-200">
                                <button type="button" x-on:click="applyPreset(preset)" class="flex min-w-0 flex-1 items-center justify-between px-3 py-2 text-left">
                                    <span class="truncate" x-text="preset.name"></span>
                                    <span x-show="selectedPresetName === preset.name" class="outcraft-icon ml-3 shrink-0 text-blue-500">check</span>
                                </button>
                                <button type="button" x-on:click.stop="deletePreset(preset)" class="mr-2 flex size-8 shrink-0 items-center justify-center rounded-lg text-gray-400 opacity-0 transition hover:bg-red-50 hover:text-red-600 group-hover:opacity-100" :aria-label="`Delete ${preset.name}`">
                                    <span class="outcraft-icon !text-[18px]">delete</span>
                                </button>
                            </div>
                        </template>
                    </div>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="relative w-full min-w-[1080px] table-fixed border-collapse text-[15px]">
                    <thead>
                        <tr class="border-y border-gray-200 bg-gray-50 text-left text-[14px] font-semibold text-gray-950">
                            <th class="w-[240px] px-6 py-4">Channel</th>
                            <th class="w-[170px] px-4 py-4">Name</th>
                            <th class="w-[290px] px-4 py-4">Contact</th>
                            <th class="w-[240px] px-4 py-4">Outcome</th>
                            <th class="w-[120px] px-4 py-4">
                                <button type="button" x-on:click="toggleAgeSort()" class="flex items-center gap-1 rounded-md font-semibold hover:text-gray-600">
                                    <span>Created</span>
                                    <span class="outcraft-icon !text-[16px]" x-text="ageSortDirection === 'asc' ? 'arrow_upward' : 'arrow_downward'"></span>
                                </button>
                            </th>
                            <th class="sticky right-0 z-10 w-[96px] bg-gray-50 py-4 pr-6 pl-4 text-right shadow-[-12px_0_18px_-18px_rgba(15,23,42,0.45)]"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr x-show="isLoading" x-transition.opacity>
                            <td colspan="6" class="h-[260px] bg-white px-8 py-12 text-center">
                                <div class="mx-auto flex size-[56px] items-center justify-center rounded-xl bg-white" x-html="tableLoaderSvg()"></div>
                            </td>
                        </tr>
                        <template x-for="(row, rowIndex) in loadingRows()" :key="'outreach-review-' + row.name + row.email + row.age + row.result">
                            <tr :class="rowIndex === loadingRows().length - 1 ? '' : 'border-b border-gray-200'">
                                <td class="px-6 py-5">
                                    <div class="flex min-w-0 items-center gap-2">
                                        <span class="truncate font-medium text-gray-950" x-text="row.channel"></span>
                                        <span class="outcraft-label inline-flex max-w-[112px] rounded-md bg-gray-50 px-2 py-1 text-xs font-medium text-gray-600 ring-1 ring-inset ring-gray-500/10">
                                            <span class="truncate" x-text="row.direction"></span>
                                        </span>
                                    </div>
                                    <div class="mt-2">
                                        <button
                                            type="button"
                                            x-show="row.channel !== 'Call'"
                                            x-on:mouseenter="showFloatingTooltip($event, row.contentPreview, 320)"
                                            x-on:mouseleave="hideFloatingTooltip()"
                                            x-on:focus="showFloatingTooltip($event, row.contentPreview, 320)"
                                            x-on:blur="hideFloatingTooltip()"
                                            x-on:click="openLeadDetails(row)"
                                            class="inline-flex text-left"
                                        >
                                            <span class="outcraft-label inline-flex max-w-[92px] cursor-pointer rounded-md bg-gray-50 px-2 py-1 text-xs font-medium text-gray-600 ring-1 ring-inset ring-gray-500/10 transition group-hover:text-gray-950">
                                                <span class="truncate">View</span>
                                            </span>
                                        </button>
                                        <span
                                            x-show="row.channel === 'Call'"
                                            x-on:mouseenter="showFloatingTooltip($event, 'Listen', 104)"
                                            x-on:mouseleave="hideFloatingTooltip()"
                                            class="inline-flex"
                                        >
                                            <span class="outcraft-label inline-flex max-w-[92px] cursor-pointer items-center gap-1 rounded-md bg-gray-50 px-2 py-1 text-xs font-medium text-gray-600 ring-1 ring-inset ring-gray-500/10 transition group-hover:text-gray-950">
                                                <span class="outcraft-icon !text-[18px] !leading-[18px] ">play_circle</span>
                                                <span class="truncate leading-[18px]" x-text="row.content || 'Play'"></span>
                                            </span>
                                        </span>
                                    </div>
                                </td>
                                <td class="px-4 py-5">
                                    <div class="truncate font-medium text-gray-950" x-text="campaignLeadFirstName(row)"></div>
                                    <div class="mt-1 truncate text-gray-500" x-text="campaignLeadLastName(row)"></div>
                                </td>
                                <td class="px-4 py-5">
                                    <button type="button" x-on:click="copyContact(row.email)" x-show="row.email" class="group relative block max-w-full cursor-pointer text-left text-gray-950 transition hover:text-indigo-600">
                                        <span class="block truncate" x-text="row.email"></span>
                                        <span class="pointer-events-none absolute bottom-full left-1/2 z-50 mb-2 -translate-x-1/2 translate-y-1 whitespace-nowrap rounded-lg bg-gray-900 px-3 py-2 text-xs font-medium text-white opacity-0 shadow-sm transition group-hover:translate-y-0 group-hover:opacity-100">
                                            <span x-text="row.email"></span>
                                            <span class="ml-2 text-white/70">Click to Copy</span>
                                            <span class="absolute left-1/2 top-full size-2 -translate-x-1/2 -translate-y-1 rotate-45 bg-gray-900"></span>
                                        </span>
                                    </button>
                                    <div x-show="! row.email" class="truncate text-gray-300">No email</div>
                                    <button type="button" x-on:click="copyContact(row.phone)" x-show="row.phone" class="group relative mt-1 block max-w-full cursor-pointer text-left text-gray-500 transition hover:text-indigo-600">
                                        <span class="block truncate" x-text="row.phone"></span>
                                        <span class="pointer-events-none absolute bottom-full left-1/2 z-50 mb-2 -translate-x-1/2 translate-y-1 whitespace-nowrap rounded-lg bg-gray-900 px-3 py-2 text-xs font-medium text-white opacity-0 shadow-sm transition group-hover:translate-y-0 group-hover:opacity-100">
                                            <span x-text="row.phone"></span>
                                            <span class="ml-2 text-white/70">Click to Copy</span>
                                            <span class="absolute left-1/2 top-full size-2 -translate-x-1/2 -translate-y-1 rotate-45 bg-gray-900"></span>
                                        </span>
                                    </button>
                                    <div x-show="! row.phone" class="mt-1 truncate text-gray-300">No phone</div>
                                </td>
                                <td class="px-4 py-5">
                                    <div class="flex min-w-0 items-center gap-2">
                                        <span class="w-[72px] shrink-0 whitespace-nowrap text-gray-500">Outcome</span>
                                        <span class="outcraft-label inline-flex min-w-0 max-w-[140px] rounded-md px-2 py-1 text-xs font-medium ring-1 ring-inset" :class="pillClass(row.outcome)">
                                            <span class="truncate" x-text="row.outcome"></span>
                                        </span>
                                    </div>
                                    <div class="mt-2 flex min-w-0 items-center gap-2">
                                        <span class="w-[72px] shrink-0 whitespace-nowrap text-gray-500">Result</span>
                                        <span class="outcraft-label inline-flex min-w-0 max-w-[140px] rounded-md px-2 py-1 text-xs font-medium ring-1 ring-inset" :class="pillClass(row.result)">
                                            <span class="truncate" x-text="row.result"></span>
                                        </span>
                                    </div>
                                </td>
                                <td class="px-4 py-5">
                                    <span class="group relative inline-flex">
                                        <span>Created </span><span x-text="leadAge(row)"></span>
                                        <span class="pointer-events-none absolute bottom-full left-1/2 z-50 mb-2 -translate-x-1/2 translate-y-1 whitespace-nowrap rounded-lg bg-gray-900 px-3 py-2 text-xs font-medium text-white opacity-0 shadow-sm transition group-hover:translate-y-0 group-hover:opacity-100">
                                            <span x-text="row.ageTooltip"></span>
                                            <span class="absolute left-1/2 top-full size-2 -translate-x-1/2 -translate-y-1 rotate-45 bg-gray-900"></span>
                                        </span>
                                    </span>
                                </td>
                                <td class="sticky right-0 bg-white py-5 pr-6 pl-4 text-right font-medium whitespace-nowrap shadow-[-12px_0_18px_-18px_rgba(15,23,42,0.45)]">
                                    <button type="button" x-on:click="openLeadDetails(row)" class="text-indigo-600 transition hover:text-indigo-900">View</button>
                                </td>
                            </tr>
                        </template>
                        <tr x-show="! isLoading && filteredRows().length === 0">
                            <td colspan="6" class="px-8 py-16 text-center text-gray-500">No outreach records match these filters.</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="flex items-center justify-between border-t border-gray-200 bg-white px-4 py-3 sm:px-6">
                <div class="flex flex-1 items-center">
                    <label class="flex items-center gap-3 text-sm text-gray-700">
                        <span>Rows Per Page</span>
                        <span class="grid grid-cols-1">
                            <select x-model.number="perPage" x-on:change="page = 1" class="col-start-1 row-start-1 h-9 appearance-none rounded-md bg-white py-1.5 pr-8 pl-3 text-sm text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600">
                                <template x-for="option in perPageOptions" :key="option">
                                    <option :value="option" x-text="option"></option>
                                </template>
                            </select>
                            <svg viewBox="0 0 16 16" fill="currentColor" data-slot="icon" aria-hidden="true" class="pointer-events-none col-start-1 row-start-1 mr-2 size-4 self-center justify-self-end text-gray-400">
                                <path d="M4.22 6.22a.75.75 0 0 1 1.06 0L8 8.94l2.72-2.72a.75.75 0 1 1 1.06 1.06l-3.25 3.25a.75.75 0 0 1-1.06 0L4.22 7.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" fill-rule="evenodd" />
                            </svg>
                        </span>
                    </label>
                </div>
                <div class="flex flex-1 justify-center text-sm text-gray-700">
                    <span x-text="paginationSummary()"></span>
                </div>
                <div class="flex flex-1 justify-end">
                    <nav aria-label="Pagination" class="isolate inline-flex -space-x-px rounded-md shadow-sm">
                        <button type="button" x-on:click="page = Math.max(1, page - 1)" :disabled="page === 1" class="relative inline-flex size-9 items-center justify-center rounded-l-md text-gray-400 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0 disabled:cursor-not-allowed disabled:opacity-40">
                            <span class="sr-only">Previous</span>
                            <svg viewBox="0 0 20 20" fill="currentColor" data-slot="icon" aria-hidden="true" class="size-5">
                                <path d="M11.78 5.22a.75.75 0 0 1 0 1.06L8.06 10l3.72 3.72a.75.75 0 1 1-1.06 1.06l-4.25-4.25a.75.75 0 0 1 0-1.06l4.25-4.25a.75.75 0 0 1 1.06 0Z" clip-rule="evenodd" fill-rule="evenodd" />
                            </svg>
                        </button>
                        <template x-for="pageNumber in visiblePageNumbers()" :key="pageNumber">
                            <span>
                                <span x-show="pageNumber === '...'" class="relative inline-flex size-9 items-center justify-center text-sm font-semibold text-gray-700 ring-1 ring-inset ring-gray-300 focus:outline-offset-0">...</span>
                                <button x-show="pageNumber !== '...'" type="button" x-on:click="page = pageNumber" class="relative inline-flex size-9 items-center justify-center text-sm font-semibold focus:z-20 focus:outline-offset-0" :class="page === pageNumber ? 'z-10 bg-indigo-600 text-white focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600' : 'text-gray-900 ring-1 ring-inset ring-gray-300 hover:bg-gray-50'" x-text="pageNumber"></button>
                            </span>
                        </template>
                        <button type="button" x-on:click="page = Math.min(totalPages(), page + 1)" :disabled="page === totalPages()" class="relative inline-flex size-9 items-center justify-center rounded-r-md text-gray-400 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0 disabled:cursor-not-allowed disabled:opacity-40">
                            <span class="sr-only">Next</span>
                            <svg viewBox="0 0 20 20" fill="currentColor" data-slot="icon" aria-hidden="true" class="size-5">
                                <path d="M8.22 5.22a.75.75 0 0 1 1.06 0l4.25 4.25a.75.75 0 0 1 0 1.06l-4.25 4.25a.75.75 0 0 1-1.06-1.06L11.94 10 8.22 6.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" fill-rule="evenodd" />
                            </svg>
                        </button>
                    </nav>
                </div>
            </div>
        </section>

        <section x-cloak x-show="activeNav === 'Profile'" class="mx-6 mb-10 mt-6">
            <h1 class="sr-only">Account Settings</h1>

            <div class="max-w-7xl lg:flex lg:gap-x-16">
                <aside class="flex overflow-x-auto border-b border-gray-900/5 py-4 lg:block lg:w-64 lg:flex-none lg:border-0 lg:pt-[60px] lg:pb-0">
                    <nav class="flex-none lg:w-full">
                    <ul role="list" class="flex gap-x-3 gap-y-1 whitespace-nowrap lg:flex-col">
                        <li>
                            <button type="button" class="group flex h-10 w-full items-center gap-x-3 rounded-md bg-white py-2 pr-3 pl-2 text-left text-sm/6 font-semibold text-indigo-600 transition-colors duration-200 ease-in-out">
                                <span class="outcraft-icon flex size-6 shrink-0 items-center justify-center !text-[22px] !leading-none text-indigo-600">account_circle</span>
                                Account
                            </button>
                        </li>
                        <li>
                            <button type="button" class="group flex h-10 w-full items-center gap-x-3 rounded-md py-2 pr-3 pl-2 text-left text-sm/6 font-semibold text-gray-700 transition-colors duration-200 ease-in-out hover:bg-white hover:text-indigo-600">
                                <span class="outcraft-icon flex size-6 shrink-0 items-center justify-center !text-[22px] !leading-none text-gray-400 group-hover:text-indigo-600">fingerprint</span>
                                Security
                            </button>
                        </li>
                        <li>
                            <button type="button" class="group flex h-10 w-full items-center gap-x-3 rounded-md py-2 pr-3 pl-2 text-left text-sm/6 font-semibold text-gray-700 transition-colors duration-200 ease-in-out hover:bg-white hover:text-indigo-600">
                                <span class="outcraft-icon flex size-6 shrink-0 items-center justify-center !text-[22px] !leading-none text-gray-400 group-hover:text-indigo-600">notifications</span>
                                Notifications
                            </button>
                        </li>
                        <li>
                            <button type="button" class="group flex h-10 w-full items-center gap-x-3 rounded-md py-2 pr-3 pl-2 text-left text-sm/6 font-semibold text-gray-700 transition-colors duration-200 ease-in-out hover:bg-white hover:text-indigo-600">
                                <span class="outcraft-icon flex size-6 shrink-0 items-center justify-center !text-[22px] !leading-none text-gray-400 group-hover:text-indigo-600">credit_card</span>
                                Billing
                            </button>
                        </li>
                        <li>
                            <button type="button" class="group flex h-10 w-full items-center gap-x-3 rounded-md py-2 pr-3 pl-2 text-left text-sm/6 font-semibold text-gray-700 transition-colors duration-200 ease-in-out hover:bg-white hover:text-indigo-600">
                                <span class="outcraft-icon flex size-6 shrink-0 items-center justify-center !text-[22px] !leading-none text-gray-400 group-hover:text-indigo-600">users</span>
                                Team members
                            </button>
                        </li>
                        <li>
                            <button type="button" class="group flex h-10 w-full items-center gap-x-3 rounded-md py-2 pr-3 pl-2 text-left text-sm/6 font-semibold text-gray-700 transition-colors duration-200 ease-in-out hover:bg-white hover:text-indigo-600">
                                <span class="outcraft-icon flex size-6 shrink-0 items-center justify-center !text-[22px] !leading-none text-gray-400 group-hover:text-indigo-600">extension</span>
                                Integrations
                            </button>
                        </li>
                    </ul>
                    </nav>
                </aside>

                <div class="divide-y divide-gray-200 lg:flex-auto lg:pt-[60px]">
                    <div class="grid grid-cols-1 gap-x-8 gap-y-10 pb-14 md:grid-cols-3">
                        <div>
                            <h2 class="text-base/7 font-semibold text-gray-900">Personal Information</h2>
                            <p class="mt-1 text-sm/6 text-gray-500">Use the account details attached to your workspace.</p>
                        </div>

                        <form class="md:col-span-2">
                        <div class="grid grid-cols-1 gap-x-6 gap-y-8 sm:max-w-xl sm:grid-cols-6">
                            <div class="col-span-full flex items-center gap-x-8">
                                <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="" class="size-24 flex-none rounded-lg bg-gray-100 object-cover outline outline-1 -outline-offset-1 outline-black/5" />
                                <div>
                                    <button type="button" class="rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 transition hover:bg-gray-100">Change Avatar</button>
                                    <p class="mt-2 text-xs/5 text-gray-500">JPG, GIF or PNG. 1MB max.</p>
                                </div>
                            </div>

                            <div class="sm:col-span-3">
                                <label for="profile-first-name" class="block text-sm/6 font-medium text-gray-900">First name</label>
                                <div class="mt-2">
                                    <input id="profile-first-name" type="text" name="first-name" autocomplete="given-name" value="Pulsetto" class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6" />
                                </div>
                            </div>

                            <div class="sm:col-span-3">
                                <label for="profile-last-name" class="block text-sm/6 font-medium text-gray-900">Last name</label>
                                <div class="mt-2">
                                    <input id="profile-last-name" type="text" name="last-name" autocomplete="family-name" value="Team" class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6" />
                                </div>
                            </div>

                            <div class="col-span-full">
                                <label for="profile-email" class="block text-sm/6 font-medium text-gray-900">Email address</label>
                                <div class="mt-2">
                                    <input id="profile-email" type="email" name="email" autocomplete="email" value="diana@pulsetto.tech" class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6" />
                                </div>
                            </div>

                            <div class="col-span-full">
                                <label for="profile-username" class="block text-sm/6 font-medium text-gray-900">Username</label>
                                <div class="mt-2">
                                    <div class="flex items-center rounded-md bg-white pl-3 outline outline-1 -outline-offset-1 outline-gray-300 focus-within:outline-2 focus-within:-outline-offset-2 focus-within:outline-indigo-600 sm:text-sm/6">
                                        <div class="shrink-0 text-base text-gray-500 select-none sm:text-sm/6">outcraft.ai/</div>
                                        <input id="profile-username" type="text" name="username" value="pulsetto" class="block min-w-0 grow bg-transparent py-1.5 pr-3 pl-1 text-base text-gray-900 placeholder:text-gray-400 focus:outline-none sm:text-sm/6" />
                                    </div>
                                </div>
                            </div>

                            <div class="col-span-full">
                                <label for="profile-timezone" class="block text-sm/6 font-medium text-gray-900">Timezone</label>
                                <div class="mt-2 grid grid-cols-1">
                                    <select id="profile-timezone" name="timezone" class="col-start-1 row-start-1 w-full appearance-none rounded-md bg-white py-1.5 pr-8 pl-3 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6">
                                        <option>Eastern Standard Time</option>
                                        <option>Pacific Standard Time</option>
                                        <option>Greenwich Mean Time</option>
                                    </select>
                                    <svg viewBox="0 0 16 16" fill="currentColor" data-slot="icon" aria-hidden="true" class="pointer-events-none col-start-1 row-start-1 mr-2 size-5 self-center justify-self-end text-gray-400 sm:size-4">
                                        <path d="M4.22 6.22a.75.75 0 0 1 1.06 0L8 8.94l2.72-2.72a.75.75 0 1 1 1.06 1.06l-3.25 3.25a.75.75 0 0 1-1.06 0L4.22 7.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" fill-rule="evenodd" />
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <div class="mt-8 flex">
                            <button type="submit" class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Save</button>
                        </div>
                        </form>
                    </div>

                    <div class="grid grid-cols-1 gap-x-8 gap-y-10 py-14 md:grid-cols-3">
                        <div>
                            <h2 class="text-base/7 font-semibold text-gray-900">Change Password</h2>
                            <p class="mt-1 text-sm/6 text-gray-500">Update your password associated with your account.</p>
                        </div>

                        <form class="md:col-span-2">
                        <div class="grid grid-cols-1 gap-x-6 gap-y-8 sm:max-w-xl sm:grid-cols-6">
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
                    </div>

                    <div class="grid grid-cols-1 gap-x-8 gap-y-10 py-14 md:grid-cols-3">
                        <div>
                            <h2 class="text-base/7 font-semibold text-gray-900">Log Out Other Sessions</h2>
                            <p class="mt-1 text-sm/6 text-gray-500">Enter your password to log out of other sessions across your devices.</p>
                        </div>

                        <form class="md:col-span-2">
                        <div class="grid grid-cols-1 gap-x-6 gap-y-8 sm:max-w-xl sm:grid-cols-6">
                            <div class="col-span-full">
                                <label for="profile-logout-password" class="block text-sm/6 font-medium text-gray-900">Your password</label>
                                <div class="mt-2">
                                    <input id="profile-logout-password" type="password" name="password" autocomplete="current-password" class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6" />
                                </div>
                            </div>
                        </div>

                        <div class="mt-8 flex">
                            <button type="submit" class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Log Out Other Sessions</button>
                        </div>
                        </form>
                    </div>

                    <div class="grid grid-cols-1 gap-x-8 gap-y-10 pt-14 md:grid-cols-3">
                        <div>
                            <h2 class="text-base/7 font-semibold text-gray-900">Delete Account</h2>
                            <p class="mt-1 text-sm/6 text-gray-500">No longer want to use this service? This action is not reversible.</p>
                        </div>

                        <form class="flex items-start md:col-span-2">
                            <button type="submit" class="rounded-md bg-red-600 px-3 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-red-500">Yes, Delete My Account</button>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <script>
        const outcraftLucideAliases = {
            account_circle: 'circle-user-round',
            account_tree: 'git-fork',
            add: 'plus',
            alternate_email: 'at-sign',
            analytics: 'chart-no-axes-column-increasing',
            apartment: 'building-2',
            archive: 'archive',
            arrow_back: 'arrow-left',
            arrow_downward: 'arrow-down',
            arrow_forward: 'arrow-right',
            arrow_outward: 'arrow-up-right',
            arrow_upward: 'arrow-up',
            astroid: 'astroid',
            auto_awesome: 'sparkles',
            block: 'ban',
            call: 'phone',
            calendar_check: 'calendar-check',
            cancel: 'circle-x',
            card_membership: 'badge-check',
            chat_bubble: 'message-circle',
            check: 'check',
            close: 'x',
            credit_card: 'credit-card',
            dashboard: 'layout-grid',
            delete: 'trash-2',
            deployed_code: 'box',
            description: 'file-text',
            dock_to_left: 'panel-left-close',
            dock_to_right: 'panel-left-open',
            download: 'download',
            drafts: 'mail-open',
            edit: 'pencil',
            emoji_events: 'trophy',
            extension: 'puzzle',
            fingerprint: 'fingerprint',
            flag: 'flag',
            filter_alt: 'funnel',
            format_list_bulleted: 'sparkles',
            forum: 'messages-square',
            gift: 'gift',
            gpp_good: 'shield-check',
            group: 'users',
            groups: 'users-round',
            headphones: 'headphones',
            help: 'circle-help',
            hourglass_empty: 'hourglass',
            keyboard_arrow_down: 'chevron-down',
            language: 'globe',
            library_books: 'book-open',
            mail: 'mail',
            manage_search: 'search-check',
            monitoring: 'chart-spline',
            more_vert: 'ellipsis-vertical',
            notifications: 'bell',
	            payments: 'hand-coins',
	            phone_in_talk: 'phone-call',
	            pause: 'pause',
	            play_arrow: 'play',
            play_circle: 'circle-play',
            package_check: 'package-check',
            psychology: 'brain',
            record_voice_over: 'speech',
            reply: 'reply',
	            report: 'triangle-alert',
	            receipt_text: 'receipt-text',
	            refresh: 'refresh-cw',
	            refresh_ccw: 'refresh-ccw',
            save: 'save',
            schedule: 'clock',
            science: 'flask-conical',
            search: 'search',
            sentiment_satisfied: 'smile',
            settings: 'settings',
            sms: 'message-square-text',
            south_east: 'arrow-down-right',
            shopping_cart: 'shopping-cart',
            support_agent: 'headset',
            task_alt: 'circle-check-big',
            timeline: 'route',
            tune: 'sliders-horizontal',
            trending_up: 'trending-up',
            travel_explore: 'search',
            fact_check: 'clipboard-check',
            unfold_less: 'chevrons-up',
            unfold_more: 'chevrons-down',
            upload: 'upload',
            verified: 'badge-check',
            verified_user: 'shield-check',
            view_agenda: 'rows-3',
            visibility: 'eye',
            volume_up: 'volume-2',
            waving_hand: 'hand',
        };

        function outcraftLucideKey(name) {
            const normalized = String(name || '').trim().replace(/_/g, '-');
            const lucideName = outcraftLucideAliases[String(name || '').trim()] || normalized || 'circle';

            return lucideName
                .split('-')
                .filter(Boolean)
                .map((part) => part.charAt(0).toUpperCase() + part.slice(1))
                .join('');
        }

        function renderOutcraftIconNode(node) {
            const visibleText = String(node.textContent || '').trim();
            const rawIcon = String(visibleText || node.dataset.iconSource || '').trim();
            const hasRenderedSvg = Boolean(node.querySelector('svg'));

            if (! rawIcon || (rawIcon === node.dataset.iconRendered && hasRenderedSvg && ! visibleText)) {
                return;
            }

            if (! window.lucide?.icons || ! window.lucide?.createElement) {
                node.dataset.iconSource = rawIcon;
                return;
            }

            const key = outcraftLucideKey(rawIcon);
            const icon = window.lucide.icons[key] || window.lucide.icons.Circle;

            if (! icon) {
                node.dataset.iconSource = rawIcon;
                return;
            }

            const svg = window.lucide.createElement(icon, {
                width: '1em',
                height: '1em',
                'stroke-width': '1.5',
                'aria-hidden': 'true',
            });

            node.dataset.iconSource = rawIcon;
            node.dataset.iconRendered = rawIcon;
            node.textContent = '';
            node.appendChild(svg);
        }

        function renderOutcraftIcons(root = document) {
            root.querySelectorAll?.('.outcraft-icon').forEach(renderOutcraftIconNode);
        }

        function initializeOutcraftIcons() {
            if (window.outcraftIconsInitialized) {
                renderOutcraftIcons();
                return;
            }

            window.outcraftIconsInitialized = true;
            renderOutcraftIcons();

            let renderQueued = false;
            const observer = new MutationObserver(() => {
                if (renderQueued) {
                    return;
                }

                renderQueued = true;
                requestAnimationFrame(() => {
                    renderQueued = false;
                    renderOutcraftIcons();
                });
            });

            observer.observe(document.body, {
                childList: true,
                characterData: true,
                subtree: true,
            });
        }

        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', initializeOutcraftIcons, { once: true });
        } else {
            initializeOutcraftIcons();
        }

        function outreachPage(rows) {
            return {
                rows,
                sidebarOpen: true,
                sidebarSettled: true,
                sidebarTimer: null,
                mobileNavOpen: false,
                isLoading: false,
                loaderTimer: null,
                activeNav: 'Dashboard',
                activeTab: 'Leads',
                leadDetailOpen: false,
                leadDetailsEditing: false,
                selectedLead: null,
                leadDetailReturnContext: {
                    activeNav: 'Leads',
                    activeTab: 'Leads',
                    activeCampaignPageTab: 'Campaigns',
                },
                leadEditForm: {
                    firstName: '',
                    lastName: '',
                    email: '',
                    phone: '',
                    country: '',
                    state: 'Idle',
                    timezone: '',
                    createdDate: '',
                    ignoreNightRestrictions: false,
                    testUser: false,
                },
                leadCreatedCalendarOpen: false,
                leadCreatedCalendarMonth: '',
                leadCalendarMenuOpen: '',
                leadSelectOpen: '',
                leadDetailsActionOpen: false,
                campaignRunsActionOpen: false,
                expandedInteractions: [],
                activeCampaignPageTab: 'Campaigns',
                campaignBuilderOpen: false,
                campaignBuilderTransitioning: false,
                campaignBuilderTransitionLabel: 'Preparing Campaign Setup...',
                campaignBuilderStep: 0,
                campaignBuilderMaxStep: 0,
                campaignBuilderScrollFromStep: null,
                campaignBuilderFadingStep: null,
                campaignBuilderEnteringStep: null,
                campaignBuilderProgressSticky: true,
                campaignBuilderProgressStickyTop: 24,
                campaignBuilderSceneHeight: 0,
                campaignBuilderColumnViewportHeight: 0,
                campaignBuilderProgressOffset: 0,
                campaignBuilderContentOffset: 0,
                campaignBuilderContentSticky: true,
                agentAdvancedOpen: false,
                campaignBuilderBottomPadding: 0,
                campaignBuilderActionBarStyle: '',
                campaignBuilderActionBarContentStyle: '',
                campaignBuilderActionBarFrame: null,
                campaignSetupBottomPadding: 0,
                campaignSetupActionBarStyle: '',
                campaignSetupActionBarContentStyle: '',
                campaignSetupActionBarFrame: null,
                campaignSetupModeTransitionTimer: null,
                campaignSetupScrollFromStep: null,
                campaignSetupFadingStep: null,
                campaignSetupEnteringStep: null,
                campaignSetupScrollTimer: null,
                campaignBuilderScrollTimer: null,
                campaignBuilderScrollFrame: null,
                campaignBuilderDirection: 'forward',
                campaignSetupDirection: 'forward',
                activeInsightsTab: 'Overview',
                selectedEngagementChannels: ['Calls', 'Emails', 'SMS'],
                campaignOpen: false,
                presetOpen: false,
                campaign: 'Abandoned Cart',
                campaigns: ['All Campaigns', 'Abandoned Cart', 'Web Support'],
                query: '',
                searchOpen: false,
                filters: [],
                floatingTooltip: {
                    visible: false,
                    text: '',
                    left: 0,
                    top: 0,
                    width: 320,
                },
                ageSortDirection: 'asc',
                page: 1,
                perPage: 10,
                perPageOptions: [10, 25, 50, 100],
                leadStateOptions: ['Idle', 'Review Required'],
                leadCalendarMonths: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
                leadCountryOptions: [
                    { code: 'US', name: 'United States', flag: '🇺🇸' },
                    { code: 'CA', name: 'Canada', flag: '🇨🇦' },
                    { code: 'GB', name: 'United Kingdom', flag: '🇬🇧' },
                    { code: 'DE', name: 'Germany', flag: '🇩🇪' },
                    { code: 'FR', name: 'France', flag: '🇫🇷' },
                    { code: 'ES', name: 'Spain', flag: '🇪🇸' },
                    { code: 'IT', name: 'Italy', flag: '🇮🇹' },
                    { code: 'NL', name: 'Netherlands', flag: '🇳🇱' },
                    { code: 'LT', name: 'Lithuania', flag: '🇱🇹' },
                    { code: 'PL', name: 'Poland', flag: '🇵🇱' },
                    { code: 'AU', name: 'Australia', flag: '🇦🇺' },
                ],
	                leadTimezoneOptions: [
	                    'America / New York',
	                    'America / Chicago',
	                    'America / Denver',
	                    'America / Los Angeles',
	                    'America / Toronto',
	                    'America / Vancouver',
	                ],
	                outreachWeekdays: ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'],
	                outreachHourOptions: ['00:00', '01:00', '02:00', '03:00', '04:00', '05:00', '06:00', '07:00', '08:00', '09:00', '10:00', '11:00', '12:00', '13:00', '14:00', '15:00', '16:00', '17:00', '18:00', '19:00', '20:00', '21:00', '22:00', '23:00'],
	                selectedPresetName: 'Filter Presets',
                nav: [
                    { label: 'Dashboard', icon: 'dashboard', count: '5' },
                    { label: 'Campaigns', icon: 'format_list_bulleted', count: '12' },
                    { label: 'Leads', icon: 'group' },
                    { label: 'Insights', icon: 'monitoring' },
                    { label: 'Knowledge Base', icon: 'library_books' },
                ],
                pinnedCampaigns: [
                    { name: 'Abandoned Cart', status: 'Running', change: 'Unpublished', modified: '2 hours ago', owner: 'Diana Ross' },
                    { name: 'Late Shipping Notification', status: 'Running', change: '', modified: '4 days ago', owner: 'Mantas G.' },
                    { name: 'Web Support', status: 'Running', change: '', modified: '4 days ago', owner: 'Support Ops' },
                    { name: 'Onboarding Test Calls Batch', status: 'Paused', change: '', modified: '4 days ago', owner: 'Casey AI' },
                    { name: 'Onboarding Calls Test Batch', status: 'Paused', change: '', modified: '4 days ago', owner: 'Casey AI' },
                ],
                abTestCampaigns: [
                    { name: 'Checkout Follow-Up Variant Test', status: 'Running', change: 'Draft', modified: '1 day ago' },
                    { name: 'Web Support Greeting Test', status: 'Running', change: 'Unpublished', modified: '3 days ago' },
                    { name: 'Shipping Delay Tone Test', status: 'Paused', change: '', modified: '5 days ago' },
                ],
                archivedCampaigns: [
                    { name: 'Holiday Winback 2025', status: 'Paused', change: '', modified: '2 months ago' },
                    { name: 'Spring Onboarding Batch', status: 'Paused', change: '', modified: '4 months ago' },
                    { name: 'Legacy Support Routing', status: 'Paused', change: '', modified: '7 months ago' },
                ],
                campaignPageTabs: [
                    { label: 'Campaigns', icon: 'format_list_bulleted' },
                    { label: 'A/B Tests', icon: 'science' },
                    { label: 'Archived', icon: 'archive' },
                ],
                companySetupSteps: [
                    { label: 'Company Identity', description: 'Name, website, and pronunciation.' },
                    { label: 'Industry & Market', description: 'Positioning, customers, and FAQs.' },
                    { label: 'Compliance & Legal', description: 'Support, policies, and standards.' },
                ],
	                campaignSetupMode: 'fast',
	                campaignSetupModeSelected: false,
	                campaignSetupIntroStep: 'type',
	                campaignSetupFastSteps: [
	                    { id: 'agent', label: 'AI Agent', description: 'Identity, voice, work time, handoff and other settings.' },
	                    { id: 'channels', label: 'Outreach Channels', description: 'Calls, SMS, email, WhatsApp.' },
	                    { id: 'brief', label: 'Campaign Context', description: 'Describe goal and context.' },
	                    { id: 'review', label: 'Review & Test', description: 'Test the draft campaign.' },
	                ],
                campaignSetupAdvancedSteps: [
			                    { id: 'agent', label: 'AI Agent', description: 'Identity, voice, work time, handoff and other settings.', group: 'Agent' },
			                    { id: 'channels', label: 'Outreach Channels', description: 'Transport settings.', group: 'Campaign' },
		                    { id: 'sequence', label: 'Outreach Sequence', description: 'Timeline and actions.', group: 'Outreach' },
		                    { id: 'followups', label: 'Follow-Ups', description: 'Response-based follow-up sequences.', group: 'Outreach' },
		                    { id: 'brief', label: 'Campaign Context', description: 'Essence, goal, and qualification.', group: 'Campaign' },
		                    { id: 'discounts', label: 'Discount Codes', description: 'Codes the AI can send.', group: 'Campaign' },
		                    { id: 'booking', label: 'Booking', description: 'Meeting and calendar rules.', group: 'Campaign' },
	                    { id: 'intelligence', label: 'Conversation Intelligence', description: 'Evaluation fields.', group: 'Intelligence' },
                    { id: 'review', label: 'Review & Launch', description: 'Validate and launch.', group: 'Finish' },
                ],
                campaignSetupLanguageOptions: [
                    { code: 'US', label: 'US', name: 'United States', flagCode: 'us' },
                    { code: 'GB', label: 'UK', name: 'United Kingdom', flagCode: 'gb' },
                    { code: 'ES', label: 'ES', name: 'Spanish', flagCode: 'es' },
                    { code: 'DE', label: 'DE', name: 'German', flagCode: 'de' },
                    { code: 'FR', label: 'FR', name: 'French', flagCode: 'fr' },
                    { code: 'NL', label: 'NL', name: 'Dutch', flagCode: 'nl' },
                    { code: 'IT', label: 'IT', name: 'Italian', flagCode: 'it' },
                    { code: 'PL', label: 'PL', name: 'Polish', flagCode: 'pl' },
                    { code: 'LT', label: 'LT', name: 'Lithuanian', flagCode: 'lt' },
                ],
                campaignSetup: {
                    current: 'type',
                    completed: [],
                    attention: [],
                    name: '',
                    type: '',
                    source: '',
                    connectLater: false,
	                    integrationStatus: 'Not Connected',
	                    activeLanguage: 'US',
	                    defaultLanguage: 'US',
	                    languageMenuOpen: false,
                    languageSearch: '',
                    languages: [{ code: 'US', label: 'US', name: 'United States', flagCode: 'us' }],
                    agentName: 'Bridget',
                    voice: 'Bridget (Ultra-realistic)',
                    emailSignature: "Best,\nBridget from Outcraft AI",
                    callGreeting: 'Hey, is this @{{first_name}}?',
                    backgroundNoise: 'Office',
                    transcriberModel: 'Flux General',
                    aiModel: 'GPT-4.1',
                    agentPersonality: "- Respectful\n- Confident\n- Solution-oriented, highlighting value\n- Slow speaking, calm, and not rushed\n- Bright, sociable, engaging",
                    agentSpeechStyle: "- Use natural long turns when explaining value.\n- Add micro-pacing before important questions.\n- Use natural hesitation only where it fits.\n- Keep delivery human-sounding.\n- Avoid reading from a script.",
                    discountCode: false,
                    offerDiscountCode: '25OFF',
                    discountCodes: [],
                    newDiscountCode: '',
                    abandonedCartLink: false,
                    cartLinkSource: 'Dynamic - Use URL from Lead Data',
                    customizeCartLink: false,
                    cartPath: '/checkout',
                    utmSource: 'outcraft',
                    utmMedium: 'email',
                    utmCampaign: 'cart-recovery',
                    dynamicParameterName: 'affid',
                    dynamicParameterValue: '',
                    shortenLinks: false,
	                    shortLinkBrand: 'warmy',
	                    offerInfo: 'Mention that the deliverability checklist takes Less Than 10 minutes to review.',
			                    scheduleMode: 'business',
			                    allDay: false,
	                    outreachDays: ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'],
	                    outreachStartHour: '09:00',
	                    outreachEndHour: '17:00',
	                    calendarService: '',
	                    bookingCallLink: 'https://calendly.com/outcraft/demo',
	                    bookingEmailLink: '',
	                    bookingSmsLink: '',
		                    smsTrigger: 'Positive Response',
		                    callGuidelines: '',
		                    smsGuidelines: 'Keep it under 1 sentence, add a full URL to the product: https://company.io/product, and attach a discount code.',
	                    emailGuidelines: '',
	                    whatsappGuidelines: '',
	                    handoff: false,
	                    followupsEnabled: false,
	                    followupPositive: false,
	                    followupEngaged: false,
	                    followupNegative: false,
	                    handoffPositive: false,
	                    handoffRequested: false,
	                    handoffScenario: '',
	                    handoffChannel: '',
	                    handoffNotificationEmail: 'support@pulsetto.com',
	                    knowledgePublished: false,
                    evaluationFormat: 'Text Summary',
                    sequenceModalOpen: false,
                    followupModalOpen: false,
                    discountCodeModalOpen: false,
                    overrideModalOpen: false,
                    evaluationDrawerOpen: false,
                    dispatchDrawerOpen: false,
                    customFieldsOpen: false,
                    customFieldsLayoutOpen: false,
                    customFieldSearch: '',
                    briefTab: 'context',
                    needsQualification: false,
                    trackEmailLinkClicks: true,
                    channels: { calls: true, email: true, sms: true, whatsapp: false },
                    channelOpen: { calls: false, email: false, sms: false, whatsapp: false },
	                    brief: {
	                        context: 'Send customers a helpful update after they interact with an Outcraft AI resource, confirm interest, and offer the next best step.',
                        about: 'Nurture leads who requested the deliverability guide.',
                        goal: 'Confirm whether the lead wants the resource and whether they want a quick consultation.',
                        leadSituation: 'Leads who requested a resource, engaged with the brand, or triggered a relevant customer event.',
                        findOut: '- What prompted their interest?\n- What problem are they trying to solve?\n- Are they ready for the next step?',
                        nextStep: 'Offer the most relevant next step, resource, handoff, or booking path based on the conversation.',
                        importantRules: '- Do not promise pricing, delivery, or legal terms unless available in source data.\n- Keep questions short and ask one thing at a time.',
                        role: 'Information and engagement specialist.',
                        reason: 'They requested a resource or triggered a Klaviyo event.',
                        offer: 'Share the guide, a product update, or a relevant discount code.',
                        avoid: 'Do not promise delivery dates, legal terms, or discounts unless available in source data.',
                        human: 'If the lead asks for pricing, legal terms, or a human teammate.',
                        qualificationQuestions: "- What made you create the account?\n- Do you currently face email deliverability issues?",
	                        qualifiedAnswers: "- Has deliverability issues\n- Wants to improve email performance\n- Wants to avoid delivery problems",
	                    },
	                },
	                customFieldTextInputs: {},
	                campaignTypeGroups: [
                    { label: 'Sales & Conversion', items: [
                        { name: 'Book Appointment', icon: 'calendar_check', description: 'Engages prospects to schedule a consultation.', example: 'Hey, saw you downloaded our guide. Do you have 10 minutes next week to discuss your goals?' },
                        { name: 'Qualify Lead', icon: 'filter_alt', description: 'Asks targeted questions to determine if a prospect is a good fit.', example: 'To make sure we are the right solution for you, what is your current monthly volume and biggest bottleneck?' },
                        { name: 'Recover Abandoned Checkout', icon: 'shopping_cart', description: 'Re-engages shoppers who left items behind.', example: 'Hi! You left some great items in your cart. Can I answer any questions or offer a discount to help you finish checkout?' },
                        { name: 'Client Reactivation', icon: 'refresh_ccw', description: 'Re-engages customers who cancelled, became inactive, or stopped responding.', example: 'We noticed it has been a while. Want help getting value from your account again?' },
                    ] },
                    { label: 'Commerce & Retention', items: [
                        { name: 'Upsell Post-Purchase', icon: 'gift', description: 'Follows up after a sale to offer related products and build loyalty.', example: 'Your order is on the way. Want a matching accessory with a loyalty discount?' },
                        { name: 'Post-Delivery Follow-Up', icon: 'package_check', description: 'Engages customers after delivery to confirm receipt, support usage, and introduce relevant offers.', example: 'Just checking your package arrived safely. Need setup help?' },
                        { name: 'Inbound Refund Request', icon: 'receipt_text', description: 'Manages return/refund requests while keeping trust.', example: 'I can help with your refund request and check if there is a faster solution.' },
                    ] },
                    { label: 'Support & Information', items: [
                        { name: 'Send Information', icon: 'send', description: 'Delivers targeted resources or updates to nurture leads.', example: 'I can send the guide and answer any quick questions.' },
                        { name: 'Provide Support', icon: 'headphones', description: 'Handles incoming customer service and troubleshooting queries.', example: 'I can help troubleshoot this and escalate if needed.' },
                    ] },
                ],
                leadSourceGroups: [
                    { label: 'Ecommerce', items: [
                        { name: 'Shopify', requiresIntegration: true, description: 'Use store events to trigger campaigns based on customer behaviour. Import leads, track purchases, and automate follow-ups.' },
                        { name: 'Klaviyo', requiresIntegration: true, description: 'Use Klaviyo events to create targeted campaigns based on customer interactions such as email opens, clicks, and purchases.' },
                    ] },
                    { label: 'CRM', items: [
                        { name: 'HubSpot', requiresIntegration: true, description: 'Use contact property changes, CRM events, scheduling links, and meetings.' },
                        { name: 'Attio', requiresIntegration: true, description: 'Connect Attio CRM to trigger campaigns based on customer data.' },
                        { name: 'Microsoft Dynamics', requiresIntegration: true, description: 'Connect Microsoft Dynamics 365 to trigger campaigns based on CRM events and customer data.' },
                        { name: 'Salesforce', requiresIntegration: true, description: 'Integrate Salesforce to trigger campaigns based on CRM events and customer data.' },
                    ] },
                    { label: 'Manual & Developer', items: [
                        { name: 'CSV File / Manual', requiresIntegration: false, description: 'Manually import leads via CSV or create them one by one.' },
                        { name: 'Custom API', requiresIntegration: false, description: 'Use this if you have your own backend or unsupported service.' },
                    ] },
                ],
                campaignBriefFields: [
                    { key: 'about', label: 'What Is This Campaign About?', placeholder: 'Example: Send customers a useful update about delayed shipments.' },
                    { key: 'goal', label: 'What Is the Main Goal?', placeholder: 'Example: Confirm if the lead wants the resource sent.' },
                    { key: 'role', label: 'What Role Should the AI Agent Play?', placeholder: 'Example: Information and engagement specialist.' },
                    { key: 'reason', label: 'Why Is the Agent Contacting This Lead?', placeholder: 'Example: They requested a resource or triggered a Klaviyo event.' },
                    { key: 'offer', label: 'What Should the Agent Offer or Explain?', placeholder: 'Example: Share a tracking link, discount code, guide, or product update.' },
                    { key: 'avoid', label: 'What Should the Agent Avoid Saying or Promising?', placeholder: 'Example: Do not promise delivery dates unless found in customer data.' },
                    { key: 'human', label: 'When Should the Agent Hand Off to a Human?', placeholder: 'Example: If the lead asks for pricing, legal terms, or wants a human.' },
                ],
                mergeTags: ['@{{agent_name}}', '@{{country_code}}', '@{{email}}', '@{{first_name}}', '@{{last_name}}', '@{{phone}}', '@{{timezone}}'],
                conversationStages: [
                    { title: 'Introduction', content: 'Greet warmly, say your name and the reason why you are calling. Be short.' },
                    { title: 'Engagement', content: 'Ask if it is a good time to talk. If yes: continue. If no: ensure it will be super quick and ask naturally just 30 seconds you will let them go. Wait for answer. If again no: ask if there is a good time to call back.' },
                    { title: 'Qualification', content: 'Identify needs, challenges, or context with qualification questions (ask questions one at a time).' },
                    { title: 'Solution Alignment', content: 'Share one relevant benefit per answer. Keep it short.' },
                    { title: 'Next Steps', content: 'Suggest @{{call_goal}} as the next step, confidently.' },
                    { title: 'Closing', content: 'Thank them warmly, wish them well. Wait for their closing phrase before saying goodbye.' },
                ],
                channelCards: [
                    { key: 'calls', title: 'Enable AI Calls', description: 'Configure call-specific rules only.' },
                    { key: 'email', title: 'Enable Email Sending', description: 'Configure email tone and sender identity.' },
                    { key: 'sms', title: 'Enable SMS Sending', description: 'Configure SMS triggers and short-message rules.' },
                    { key: 'whatsapp', title: 'Enable WhatsApp', description: 'Configure WhatsApp rules and triggers.' },
                ],
                sequenceRows: [
                    { channel: 'Call', label: 'initial_call', delay: '-', step: 'Initial outbound call to a lead introducing the company/product and the campaign offer' },
                    { channel: 'Call', label: 'initial_call', delay: '4 hours', step: 'Initial outbound call to a lead introducing the company/product and the campaign offer' },
                    { channel: 'SMS', label: 'initial_sms', delay: '1 day', step: 'Initial outbound sms to the lead regarding the campaign' },
                    { channel: 'Call', label: 'initial_call', delay: '1 day', step: 'Initial outbound call to a lead introducing the company/product and the campaign offer' },
                    { channel: 'Call', label: 'initial_call', delay: '2 days', step: 'Initial outbound call to a lead introducing the company/product and the campaign offer' },
                    { channel: 'Call', label: 'initial_call', delay: '4 days', step: 'Initial outbound call to a lead introducing the company/product and the campaign offer' },
                    { channel: 'None', label: 'campaign_end', delay: '2 days', step: 'Indicates the end of a campaign flow. No further actions will be taken for this lead in the current campaign.' },
                ],
                followupRules: [
                    { title: 'Should AI Continue With Follow-Ups After Positive Response?', helper: 'Continue with a follow-up sequence to confirm the resource was received and check whether any further assistance is needed.' },
                    { title: 'Should AI Continue With Follow-Ups if the Lead Engaged but Didn’t Make a Decision?', helper: 'Continue follow-ups for leads who engaged but did not accept or reject the offer.' },
                    { title: 'Should AI Continue With Follow-Ups After Negative Response?', helper: 'Continue with objection handling and determine whether the lead may still be open to moving forward.' },
                ],
                geoCountries: [
                    { name: 'United States', code: 'US', prefix: '+1', region: 'North America' },
                    { name: 'United Kingdom', code: 'GB', prefix: '+44', region: 'Europe' },
                    { name: 'Lithuania', code: 'LT', prefix: '+370', region: 'Europe/Vilnius' },
                    { name: 'Germany', code: 'DE', prefix: '+49', region: 'Europe' },
                    { name: 'France', code: 'FR', prefix: '+33', region: 'Europe' },
                    { name: 'Spain', code: 'ES', prefix: '+34', region: 'Europe' },
                    { name: 'Poland', code: 'PL', prefix: '+48', region: 'Europe' },
                    { name: 'Netherlands', code: 'NL', prefix: '+31', region: 'Europe' },
                    { name: 'Sweden', code: 'SE', prefix: '+46', region: 'Europe' },
                    { name: 'Norway', code: 'NO', prefix: '+47', region: 'Europe' },
                    { name: 'Canada', code: 'CA', prefix: '+1', region: 'North America' },
                    { name: 'Australia', code: 'AU', prefix: '+61', region: 'Australia' },
                    { name: 'Brazil', code: 'BR', prefix: '+55', region: 'South America' },
                    { name: 'Mexico', code: 'MX', prefix: '+52', region: 'North America' },
                    { name: 'Italy', code: 'IT', prefix: '+39', region: 'Europe' },
                ],
                companyForm: {
                    name: '',
                    website: '',
                    pronunciationEnabled: false,
                    pronunciation: '',
                    industry: '',
                    description: '',
                    problem: '',
                    differentiators: '',
                    icp: '',
                    faqs: '',
                    supportEmail: '',
                    termsUrl: '',
                    privacyUrl: '',
                    certifications: '',
                    compliance: '',
                },
                campaignBuilderErrors: {},
                insightsTabs: [
                    { label: 'Overview', icon: 'dashboard' },
                    { label: 'Engagement', icon: 'forum' },
                    { label: 'Deep Dive', icon: 'travel_explore' },
                    { label: 'Evaluations', icon: 'fact_check' },
                    { label: 'Conversation Intelligence', icon: 'psychology' },
                ],
                engagementChannels: [
                    { label: 'Calls', icon: 'call' },
                    { label: 'Emails', icon: 'mail' },
                    { label: 'SMS', icon: 'sms' },
                ],
                tabs: [
                    { label: 'Leads', icon: 'group' },
                    { label: 'Campaigns', displayLabel: 'Campaign Runs', icon: 'account_tree' },
                    { label: 'Lead Campaigns', displayLabel: 'Campaign Runs', icon: 'view_agenda' },
                    { label: 'Outreach', displayLabel: 'Interactions', icon: 'phone_in_talk' },
                    { label: 'Outreach Review', displayLabel: 'Interaction', icon: 'forum' },
                    { label: 'Handoffs', icon: 'waving_hand' },
                ],
                presets: [
                    { name: 'WhatsApp Positive', filters: ['WhatsApp', 'Positive'] },
                    { name: 'Negative', filters: ['Negative'] },
                    { name: 'Positive Incoming Calls', filters: ['Positive', 'Incoming', 'Call'] },
                ],
                leadInteractions: [
                    {
                        id: 'email-opened',
                        relative: '1 day ago',
                        date: 'Apr 25, 2026',
                        time: '18:56:11',
                        campaign: null,
                        channel: 'Email',
                        icon: 'mail',
                        direction: 'Outgoing',
                        timelineIcon: 'schedule',
                        status: 'Email Opened',
                        statusIcon: 'check',
                        statusClass: 'bg-green-50 text-green-700 ring-green-600/20',
                        title: 'Email Content',
                        audio: false,
                        messages: [
                            {
                                kind: 'user',
                                speaker: '',
                                text: 'Hello Billie, Just reaching out to welcome you and let you know your device should have arrived or will be arriving soon. If you would like a quick, personal walkthrough to get set up and make the most of your device, I am here to help. We can cover the essentials in just a few minutes - from finding the right placement to using the app and getting your first real results. Would you be open to a short call this week to make sure everything is working as it should? Thank you for choosing this approach to feeling calmer and sleeping better. Looking forward to helping you get started.',
                            },
                        ],
                        note: '',
                        summary: '',
                    },
                    {
                        id: 'call-engaged',
                        relative: '5 days ago',
                        date: 'Apr 21, 2026',
                        time: '18:56:11',
                        campaign: 'Abandoned Cart',
                        channel: 'Call',
                        icon: 'call',
                        direction: 'Outgoing',
                        status: 'Engaged',
                        statusIcon: 'chat_bubble',
                        statusClass: 'bg-green-50 text-green-700 ring-green-600/20',
                        title: 'Call Content',
                        audio: true,
                        messages: [
                            { kind: 'ai', speaker: 'AI', text: 'Hey, is this Billie?' },
                            { kind: 'user', speaker: 'User', text: 'Yes, I had a question about the offer and whether the discount still applies.' },
                            { kind: 'ai', speaker: 'AI', text: 'Absolutely. The PLUS10 code is still active and includes the 30-day money-back guarantee.' },
                            { kind: 'user', speaker: 'User', text: 'Okay, and which model should I pick if I want it mainly for sleep and stress?' },
                            { kind: 'ai', speaker: 'AI', text: 'For sleep and stress, the standard Pulsetto plan should be enough. If you want bulk pricing, I can help route that to the team.' },
                            { kind: 'user', speaker: 'User', text: 'Does the device need to be used every day, or only when I feel stressed?' },
                            { kind: 'ai', speaker: 'AI', text: 'Daily use is best for building a routine, but you can also use shorter sessions when stress spikes.' },
                            { kind: 'user', speaker: 'User', text: 'And how long does a normal session take?' },
                            { kind: 'ai', speaker: 'AI', text: 'Most people start with a 4 to 6 minute session and adjust based on comfort.' },
                            { kind: 'user', speaker: 'User', text: 'Shipping said it might arrive this week. Will setup be hard?' },
                            { kind: 'ai', speaker: 'AI', text: 'Setup is straightforward. Once it arrives, the app guides you through placement and session intensity.' },
                            { kind: 'user', speaker: 'User', text: 'Great. Send me the checkout link again and I will finish the order tonight.' },
                            { kind: 'ai', speaker: 'AI', text: 'Absolutely. I will send the link with the active PLUS10 code right after this call.' },
                        ],
                        note: '',
                        summary: 'User called to clarify a special deal for Pulsetto, confirmed understanding of the two device models, asked about shipping and bulk discounts, and indicated readiness to place an order.',
                    },
                    {
                        id: 'call-no-response',
                        relative: '5 days ago',
                        date: 'Apr 21, 2026',
                        time: '18:56:11',
                        campaign: 'Abandoned Cart',
                        channel: 'Call',
                        icon: 'call',
                        direction: 'Outgoing',
                        status: 'No Response (Voicemail/Busy)',
                        statusIcon: 'cancel',
                        statusClass: 'bg-red-50 text-red-700 ring-red-600/20',
                        title: 'Call Content',
                        audio: false,
                        messages: [
                            { kind: 'ai', speaker: 'AI', text: 'Hey Billie, this is Casey calling from Pulsetto. I wanted to check in and help you finish setting up your device.' },
                            { kind: 'ai', speaker: 'AI', text: 'Your cart is still open.' },
                            { kind: 'ai', speaker: 'AI', text: 'The PLUS10 offer is still available if you want to use it today.' },
                            { kind: 'ai', speaker: 'AI', text: 'I can help with setup, shipping, or picking the right plan.' },
                            { kind: 'ai', speaker: 'AI', text: 'There is a 30-day money-back guarantee, so you can try it without pressure.' },
                        ],
                        note: 'Call was not answered, voicemail or busy signal was detected, and the lead remains eligible for another follow-up attempt.',
                        summary: '',
                    },
                    {
                        id: 'sms-delivered',
                        relative: '5 days ago',
                        date: 'Apr 21, 2026',
                        time: '18:56:11',
                        campaign: 'Abandoned Cart',
                        channel: 'SMS',
                        icon: 'sms',
                        direction: 'Outgoing',
                        status: 'Delivered',
                        statusIcon: 'check',
                        statusClass: 'bg-green-50 text-green-700 ring-green-600/20',
                        title: 'SMS Content',
                        audio: false,
                        messages: [
                            {
                                kind: 'user',
                                speaker: '',
                                text: 'Billie, your Pulsetto cart is still open. Use code PLUS10 for an extra 10 off plus a 30-day money-back guarantee: https://pulsetto.tech/84906246464/checkout?... Pulsetto Team',
                            },
                        ],
                        note: '',
                        summary: '',
                    },
                    {
                        id: 'call-incoming',
                        relative: '5 days ago',
                        date: 'Apr 21, 2026',
                        time: '18:56:11',
                        campaign: 'Abandoned Cart',
                        channel: 'Call',
                        icon: 'call',
                        direction: 'Outgoing',
                        status: 'Engaged',
                        statusIcon: 'chat_bubble',
                        statusClass: 'bg-green-50 text-green-700 ring-green-600/20',
                        title: 'Call Content',
                        audio: false,
                        messages: [
                            {
                                kind: 'user',
                                speaker: '',
                                text: 'Hello Billie, Just reaching out to welcome you and let you know your device should have arrived or will be arriving soon. If you would like a quick, personal walkthrough to get set up and make the most of your device, I am here to help. We can cover the essentials in just a few minutes - from finding the right placement to using the app and getting your first real results. Would you be open to a short call this week to make sure everything is working as it should? Thank you for choosing this approach to feeling calmer and sleeping better. Looking forward to helping you get started.',
                            },
                        ],
                        note: '',
                        summary: '',
                    },
                ],
                searchableColumns: ['Channel', 'Direction', 'Outcome', 'Result', 'Name', 'Phone', 'Email'],
                leadSearchableColumns: ['State', 'Country', 'Timezone', 'Name', 'Phone', 'Email'],
                campaignSearchableColumns: ['Campaign', 'Status', 'First Interaction', 'Follow Up', 'Name', 'Phone', 'Email'],
                handoffSearchableColumns: ['Country', 'Timezone', 'Name', 'Phone', 'Email'],
                initializeFromUrl() {
                    this.applyUrlState();
                    this.showLoader(520);
                    window.addEventListener('resize', () => {
                        this.updateCampaignBuilderStickyLayout();
                        this.updateCampaignBuilderScrollScene();
                        this.updateCampaignBuilderBottomPadding();
                        this.updateCampaignSetupBottomPadding();
                        this.updateCampaignBuilderActionBarPosition();
                        this.updateCampaignSetupActionBarPosition();
                    });
                    this.$nextTick(() => {
                        const container = this.campaignBuilderScrollContainer();

                        container?.addEventListener('scroll', () => this.updateCampaignBuilderScrollScene(), { passive: true });
                    });
                    window.addEventListener('popstate', () => {
                        this.applyUrlState();
                        this.showLoader(360);
                    });
                },
                showLoader(duration = 420) {
                    this.isLoading = true;

                    if (this.loaderTimer) {
                        clearTimeout(this.loaderTimer);
                    }

                    this.loaderTimer = setTimeout(() => {
                        this.isLoading = false;
                        this.loaderTimer = null;
                    }, duration);
                },
                navFromParam(value) {
                    const normalized = String(value || '').toLowerCase();

                    if (normalized === 'profile') {
                        return 'Profile';
                    }

                    if (normalized === 'operations') {
                        return 'Leads';
                    }

                    return this.nav.find((item) => item.label.toLowerCase() === normalized)?.label || 'Dashboard';
                },
                tabFromParam(value) {
                    const normalized = String(value || '').toLowerCase();

                    return this.tabs.find((item) => item.label.toLowerCase() === normalized)?.label || 'Leads';
                },
	                applyUrlState() {
	                    const params = new URLSearchParams(window.location.search);
	                    const nav = this.navFromParam(params.get('nav'));
	                    const tab = this.tabFromParam(params.get('tab'));
	                    const leadId = Number(params.get('lead'));
	                    const builder = String(params.get('builder') || '');
	                    const builderStep = Number(params.get('builderStep'));
	                    const setupMode = String(params.get('setupMode') || '');
	                    const setupStep = String(params.get('setupStep') || '');

	                    this.activeNav = nav;
	                    this.activeTab = nav === 'Leads' ? tab : this.activeTab;
	                    this.leadDetailOpen = false;
                    this.leadDetailsEditing = false;
                    this.leadDetailsActionOpen = false;
                    this.campaignRunsActionOpen = false;
                    this.selectedLead = null;

                    if (nav === 'Leads' && leadId) {
                        this.selectedLead = this.rows.find((row) => Number(row.id) === leadId) || null;
                        this.leadDetailOpen = this.selectedLead !== null;
                        this.leadDetailReturnContext = {
                            activeNav: nav,
                            activeTab: tab,
                            activeCampaignPageTab: this.activeCampaignPageTab,
                        };
                    }

	                    this.searchOpen = false;
	                    this.presetOpen = false;
	                    this.campaignOpen = false;
	                    this.campaignBuilderOpen = false;

	                    if (nav === 'Campaigns' && builder === 'campaign') {
	                        const normalizedBuilderStep = Number.isFinite(builderStep) ? Math.max(0, Math.min(3, builderStep)) : (setupStep ? 3 : 0);

	                        this.activeCampaignPageTab = 'Campaigns';
	                        this.campaignBuilderOpen = true;
	                        this.campaignBuilderTransitioning = false;
	                        this.campaignBuilderStep = normalizedBuilderStep;
	                        this.campaignBuilderMaxStep = Math.max(this.campaignBuilderMaxStep, normalizedBuilderStep);
	                        this.campaignBuilderScrollFromStep = null;
	                        this.campaignBuilderFadingStep = null;

	                        if (['fast', 'advanced'].includes(setupMode)) {
	                            this.campaignSetupMode = setupMode;
	                        } else if (setupStep && this.campaignSetupAdvancedSteps.some((step) => step.id === setupStep)) {
	                            this.campaignSetupMode = 'advanced';
	                        }

                        if (setupStep && ['type', 'source', 'integration', 'mode'].includes(setupStep)) {
                            this.campaignSetupModeSelected = false;
                            this.campaignSetupIntroStep = setupStep;
                            this.campaignSetup.current = ['integration', 'mode'].includes(setupStep) ? (this.campaignSetupStepsForMode()[0]?.id || 'review') : setupStep;
                        } else if (setupStep && this.campaignSetupStepsForMode().some((step) => step.id === setupStep)) {
                            this.campaignSetupModeSelected = true;
                            this.campaignSetupIntroStep = '';
                            this.campaignSetup.current = setupStep;
                            this.campaignBuilderStep = 3;
                            this.campaignBuilderMaxStep = Math.max(this.campaignBuilderMaxStep, 3);
                        } else {
                            this.campaignSetupModeSelected = false;
	                            this.campaignSetupIntroStep = 'type';
                        }

	                        this.$nextTick(() => {
	                            this.updateCampaignBuilderStickyLayout();
	                            this.updateCampaignBuilderBottomPadding();
	                            this.updateCampaignSetupBottomPadding();
	                            this.updateCampaignBuilderActionBarPosition();
	                            this.scrollCampaignBuilderToStep(this.campaignBuilderStep, 'auto');
	                        });
	                    }
	                },
	                syncUrl(replace = false) {
	                    const url = new URL(window.location.href);
	                    url.search = '';

                    if (this.activeNav !== 'Dashboard') {
                        url.searchParams.set('nav', this.activeNav);
                    }

                    if (this.activeNav === 'Leads') {
                        url.searchParams.set('tab', this.activeTab);
                    }

	                    if (this.leadDetailOpen && this.selectedLead?.id) {
	                        url.searchParams.set('lead', this.selectedLead.id);
	                    }

	                    if (this.campaignBuilderOpen) {
	                        url.searchParams.set('nav', 'Campaigns');
	                        url.searchParams.set('builder', 'campaign');
	                        url.searchParams.set('builderStep', this.campaignBuilderStep);

	                        if (this.campaignBuilderStep >= 3 && this.campaignSetupModeSelected) {
	                            url.searchParams.set('setupMode', this.campaignSetupMode);
	                            url.searchParams.set('setupStep', this.campaignSetup.current);
	                        } else if (this.campaignBuilderStep >= 3) {
	                            url.searchParams.set('setupStep', this.campaignSetupIntroStep);
	                        }
	                    }

                    const nextUrl = url.pathname + url.search;

                    if (nextUrl === window.location.pathname + window.location.search) {
                        return;
                    }

                    window.history[replace ? 'replaceState' : 'pushState']({}, '', nextUrl);
                },
                resetTableState() {
                    this.page = 1;
                    this.query = '';
                    this.filters = [];
                    this.searchOpen = false;
                    this.presetOpen = false;
                    this.selectedPresetName = 'Filter Presets';
                },
                settleSidebarAfterTransition() {
                    clearTimeout(this.sidebarTimer);
                    this.sidebarSettled = false;
                    this.sidebarTimer = setTimeout(() => {
                        this.sidebarSettled = true;
                    }, 320);
                },
                expandSidebar() {
                    if (this.sidebarOpen) {
                        return;
                    }

                    this.sidebarOpen = true;
                    this.settleSidebarAfterTransition();
                },
                collapseSidebar() {
                    if (! this.sidebarOpen) {
                        return;
                    }

                    this.sidebarSettled = false;
                    clearTimeout(this.sidebarTimer);
                    this.sidebarOpen = false;
                    this.sidebarTimer = setTimeout(() => {
                        this.sidebarSettled = true;
                    }, 320);
                },
	                setActiveNav(section, updateUrl = true) {
	                    this.showLoader();
	                    this.activeNav = section;
	                    this.campaignBuilderOpen = false;
	                    this.leadDetailOpen = false;
                    this.leadDetailsEditing = false;
                    this.leadDetailsActionOpen = false;
                    this.campaignRunsActionOpen = false;
                    this.selectedLead = null;
                    this.mobileNavOpen = false;
                    if (section === 'Leads') {
                        this.activeTab = 'Leads';
                    }

                    if (section === 'Campaigns') {
                        this.activeCampaignPageTab = 'Campaigns';
                    }

                    if (section === 'Insights') {
                        this.activeInsightsTab = 'Overview';
                    }

                    this.resetTableState();

                    if (updateUrl) {
                        this.syncUrl();
                    }
                },
                setCampaignPageTab(tab) {
                    this.showLoader();
                    this.activeCampaignPageTab = tab;
                },
                startCampaignBuilder() {
                    this.showLoader(260);
                    if (this.campaignSetupModeTransitionTimer) {
                        window.clearTimeout(this.campaignSetupModeTransitionTimer);
                        this.campaignSetupModeTransitionTimer = null;
                    }
                    this.activeNav = 'Campaigns';
                    this.activeCampaignPageTab = 'Campaigns';
                    this.campaignBuilderOpen = true;
                    this.campaignBuilderTransitioning = false;
                    this.campaignBuilderTransitionLabel = 'Preparing Campaign Setup...';
                    this.campaignBuilderStep = 0;
                    this.campaignBuilderMaxStep = 0;
                    this.campaignBuilderScrollFromStep = null;
                    this.campaignBuilderFadingStep = null;
                    this.campaignBuilderBottomPadding = 0;
	                    this.campaignSetupBottomPadding = 0;
	                    this.campaignSetupModeSelected = false;
	                    this.campaignSetupIntroStep = 'type';
                    this.cancelCampaignBuilderScrollAnimation();
                    this.searchOpen = false;
                    this.presetOpen = false;
                    this.campaignOpen = false;
	                    this.mobileNavOpen = false;
	                    this.updateCampaignBuilderBottomPadding();
	                    this.updateCampaignBuilderStickyLayout();
	                    this.updateCampaignBuilderActionBarPosition();
	                    this.scrollCampaignBuilderToStep(0);
	                    this.syncUrl();
	                },
                exitCampaignBuilder() {
                    this.showLoader(260);
                    if (this.campaignSetupModeTransitionTimer) {
                        window.clearTimeout(this.campaignSetupModeTransitionTimer);
                        this.campaignSetupModeTransitionTimer = null;
                    }
                    this.campaignBuilderOpen = false;
                    this.campaignBuilderTransitioning = false;
                    this.campaignBuilderTransitionLabel = 'Preparing Campaign Setup...';
                    this.campaignBuilderStep = 0;
                    this.campaignBuilderMaxStep = 0;
                    this.campaignBuilderScrollFromStep = null;
                    this.campaignBuilderFadingStep = null;
                    this.campaignBuilderEnteringStep = null;
                    this.campaignSetupScrollFromStep = null;
                    this.campaignSetupFadingStep = null;
                    this.campaignSetupEnteringStep = null;
                    this.campaignBuilderBottomPadding = 0;
                    this.campaignSetupBottomPadding = 0;
                    this.campaignBuilderActionBarStyle = '';
	                    this.campaignSetupActionBarStyle = '';
	                    this.campaignSetupModeSelected = false;
	                    this.campaignSetupIntroStep = 'type';
                    this.cancelCampaignBuilderScrollAnimation();
	                    this.activeNav = 'Campaigns';
	                    this.activeCampaignPageTab = 'Campaigns';
	                    this.syncUrl(true);
	                },
	                campaignBuilderBackLabel() {
	                    if (this.campaignBuilderStep < 3) {
	                        return 'Back to Campaigns';
	                    }

	                    if (this.campaignSetupModeSelected) {
	                        return 'Back to Connection';
	                    }

	                    return {
	                        type: 'Back to Campaigns',
	                        source: 'Back to Campaign Type',
	                        integration: 'Back to Lead Source',
	                        mode: 'Back to Connection',
	                    }[this.campaignSetupIntroStep] || 'Back to Campaigns';
	                },
	                handleCampaignBuilderBack() {
	                    if (this.campaignBuilderStep >= 3) {
	                        if (this.campaignSetupModeSelected) {
	                            this.campaignSetupModeSelected = false;
	                            this.campaignSetupIntroStep = 'integration';
	                            this.campaignSetupActionBarStyle = '';
                            this.campaignSetupScrollFromStep = null;
                            this.campaignSetupFadingStep = null;
                            this.campaignSetupEnteringStep = null;
                            this.campaignBuilderScrollFromStep = null;
                            this.campaignBuilderFadingStep = null;
                            this.campaignBuilderEnteringStep = null;
                            this.syncUrl();

	                            return;
	                        }

	                        if (this.campaignSetupIntroStep === 'mode') {
	                            this.campaignSetupIntroStep = 'integration';
	                            this.syncUrl();

	                            return;
	                        }

	                        if (this.campaignSetupIntroStep === 'integration') {
	                            this.campaignSetupIntroStep = 'source';
	                            this.syncUrl();

	                            return;
	                        }

	                        if (this.campaignSetupIntroStep === 'source') {
	                            this.campaignSetupIntroStep = 'type';
	                            this.syncUrl();

	                            return;
	                        }

	                        this.goToCampaignBuilderStep(2);

                        return;
                    }

                    this.exitCampaignBuilder();
                },
                campaignBuilderRailBack() {
                    if (this.campaignBuilderStep > 0) {
                        this.previousCampaignBuilderStep();

                        return;
                    }

                    this.exitCampaignBuilder();
                },
                campaignBuilderContinueLabel() {
                    return [
                        'Continue to Industry & Market',
                        'Continue to Compliance & Legal',
                        'Continue to Campaign',
                    ][this.campaignBuilderStep] || 'Continue';
                },
                campaignBuilderMobileContinueLabel() {
                    return this.campaignBuilderStep === 2 ? 'Continue to Campaign' : 'Continue';
                },
                mobileCompanySetupLabel(index) {
                    return ['Company', 'Market', 'Legal'][index] || `Step ${index + 1}`;
                },
                nextCampaignBuilderStep() {
                    this.setCampaignBuilderStep(Math.min(this.campaignBuilderStep + 1, 3), 220);
                },
                previousCampaignBuilderStep() {
                    this.setCampaignBuilderStep(Math.max(this.campaignBuilderStep - 1, 0), 220);
                },
                goToCampaignBuilderStep(step) {
                    const nextStep = Math.max(0, Math.min(step, 3));

                    if (this.campaignBuilderStep < 3 && nextStep > this.campaignBuilderMaxStep) {
                        return;
                    }

                    this.setCampaignBuilderStep(nextStep, 180);
                },
                setCampaignBuilderStep(nextStep, loaderDuration = 180) {
                    const previousStep = this.campaignBuilderStep;
                    const isCompanyStepTransition = previousStep < 3 && nextStep < 3 && previousStep !== nextStep;
                    const preserveOutgoingStepPosition = previousStep < 3 && nextStep < previousStep && ! isCompanyStepTransition;
                    const outgoingStepTop = preserveOutgoingStepPosition ? this.campaignBuilderCompanyStepTop(previousStep) : null;

	                    if (previousStep < 3 && nextStep >= 3) {
	                        this.campaignSetupModeSelected = false;
	                        this.campaignSetupIntroStep = 'type';
	                        this.campaignSetupActionBarStyle = '';
                        this.campaignSetupScrollFromStep = null;
                        this.campaignSetupFadingStep = null;
                        this.campaignSetupEnteringStep = null;
                    }

                    this.campaignBuilderDirection = nextStep >= previousStep ? 'forward' : 'back';
                    this.campaignBuilderScrollFromStep = isCompanyStepTransition ? previousStep : null;
                    this.campaignBuilderFadingStep = null;
                    this.campaignBuilderEnteringStep = isCompanyStepTransition ? nextStep : null;
                    this.campaignBuilderStep = nextStep;
                    this.campaignBuilderMaxStep = Math.max(this.campaignBuilderMaxStep, nextStep);
                    this.campaignBuilderErrors = {};
                    this.updateCampaignBuilderBottomPadding();
                    this.updateCampaignSetupBottomPadding();
                    this.updateCampaignBuilderStickyLayout();
                    this.updateCampaignBuilderActionBarPosition();
                    this.updateCampaignSetupActionBarPosition();

                    if (isCompanyStepTransition) {
                        this.$nextTick(() => {
                            window.requestAnimationFrame(() => {
                                window.requestAnimationFrame(() => {
                                    this.campaignBuilderFadingStep = previousStep;
                                    this.campaignBuilderEnteringStep = null;
                                    this.updateCampaignBuilderStickyLayout();
                                    this.updateCampaignBuilderBottomPadding();
                                    this.updateCampaignSetupBottomPadding();
                                    this.updateCampaignBuilderActionBarPosition();
                                });
                            });
                        });
                    } else {
                        this.showLoader(loaderDuration);
                    }

                    if (preserveOutgoingStepPosition) {
                        this.$nextTick(() => {
                            window.requestAnimationFrame(() => {
                                this.preserveCampaignBuilderOutgoingStepPosition(previousStep, outgoingStepTop);
                                this.scrollCampaignBuilderToStep(this.campaignBuilderStep);
                            });
                        });
                    } else if (! isCompanyStepTransition) {
                        this.scrollCampaignBuilderToStep(this.campaignBuilderStep);
                    }

                    if (this.campaignBuilderScrollTimer) {
                        window.clearTimeout(this.campaignBuilderScrollTimer);
                    }

	                    if (this.campaignBuilderScrollFromStep !== null) {
                        this.campaignBuilderScrollTimer = window.setTimeout(() => {
                            this.campaignBuilderScrollFromStep = null;
                            this.campaignBuilderFadingStep = null;
                            this.campaignBuilderEnteringStep = null;
	                            this.updateCampaignBuilderBottomPadding();
	                            this.updateCampaignSetupBottomPadding();
	                            this.updateCampaignSetupActionBarPosition();
                        }, 620);
	                    }

	                    this.syncUrl();
	                },
                clearCampaignBuilderError(field) {
                    if (! this.campaignBuilderErrors[field]) {
                        return;
                    }

                    const nextErrors = { ...this.campaignBuilderErrors };
                    delete nextErrors[field];
                    this.campaignBuilderErrors = nextErrors;
                },
                submitCampaignBuilderStep(step) {
                    const requiredFields = {
                        0: [
                            ['name', 'Enter your company name.'],
                            ['website', 'Enter your company website.'],
                        ],
                        1: [
                            ['industry', 'Select your industry vertical.'],
                            ['description', 'Enter your company description.'],
                        ],
                        2: [],
                    };

                    const errors = {};

                    (requiredFields[step] || []).forEach(([field, message]) => {
                        if (! String(this.companyForm[field] || '').trim()) {
                            errors[field] = message;
                        }
                    });

                    this.campaignBuilderErrors = errors;

                    if (Object.keys(errors).length > 0) {
                        this.$nextTick(() => {
                            const firstField = Object.keys(errors)[0];
                            const field = this.$root.querySelector(`[data-campaign-field="${firstField}"]`);

                            field?.focus();
                        });

                        return;
                    }

                    if (step === 2) {
                        this.transitionToCampaignSetup();

                        return;
                    }

                    this.nextCampaignBuilderStep();
                },
                transitionToCampaignSetup() {
                    const container = this.campaignBuilderScrollContainer();

                    this.campaignBuilderTransitionLabel = 'Preparing Campaign Setup...';
                    this.campaignBuilderTransitioning = true;

                    window.setTimeout(() => {
                        this.campaignBuilderStep = 3;
                        this.campaignBuilderMaxStep = Math.max(this.campaignBuilderMaxStep, 3);
                        this.campaignBuilderErrors = {};
                        this.campaignBuilderScrollFromStep = null;
                        this.campaignBuilderFadingStep = null;
                        this.campaignBuilderEnteringStep = null;

                        this.$nextTick(() => {
                            container?.scrollTo({ top: 0, behavior: 'auto' });
                            this.campaignBuilderTransitioning = false;
                        });
                    }, 700);
                },
                isCampaignBuilderCompanyStepVisible(step) {
                    return this.campaignBuilderStep === step || this.campaignBuilderScrollFromStep === step;
                },
                campaignBuilderCompanyStepStyle(step) {
                    const base = 'transition: opacity 300ms ease, transform 300ms ease;';

                    if (this.campaignBuilderScrollFromStep === step) {
                        const offset = this.campaignBuilderDirection === 'forward' ? '-16px' : '16px';
                        const opacity = this.campaignBuilderFadingStep === step ? '0' : '1';
                        const transform = this.campaignBuilderFadingStep === step ? `translateY(${offset})` : 'translateY(0)';

                        return `${base} position: absolute; left: 0; right: 0; top: 0; width: 100%; opacity: ${opacity}; transform: ${transform}; pointer-events: none;`;
                    }

                    if (this.campaignBuilderStep === step) {
                        if (this.campaignBuilderEnteringStep === step) {
                            const offset = this.campaignBuilderDirection === 'forward' ? '32px' : '-32px';

                            return `${base} position: relative; opacity: 0; transform: translateY(${offset});`;
                        }

                        return `${base} position: relative; opacity: 1; transform: translateY(0);`;
                    }

                    return 'display: none;';
                },
                campaignBuilderCompanyStepRefName(step) {
                    return [
                        'companyIdentitySection',
                        'industryMarketSection',
                        'complianceLegalSection',
                    ][step] || null;
                },
                campaignBuilderCompanyStepTop(step) {
                    const refName = this.campaignBuilderCompanyStepRefName(step);
                    const stage = refName ? this.$refs[refName] : null;

                    return stage?.getBoundingClientRect?.().top ?? null;
                },
                preserveCampaignBuilderOutgoingStepPosition(step, previousTop) {
                    if (previousTop === null) {
                        return;
                    }

                    const container = this.campaignBuilderScrollContainer();
                    const refName = this.campaignBuilderCompanyStepRefName(step);
                    const stage = refName ? this.$refs[refName] : null;

                    if (! container || ! stage) {
                        return;
                    }

                    const nextTop = stage.getBoundingClientRect().top;
                    const delta = nextTop - previousTop;

                    if (Math.abs(delta) > 1) {
                        container.scrollTop += delta;
                    }
                },
                updateCampaignBuilderActionBarPosition() {
                    if (this.campaignBuilderActionBarFrame) {
                        cancelAnimationFrame(this.campaignBuilderActionBarFrame);
                    }

                    this.campaignBuilderActionBarFrame = requestAnimationFrame(() => {
                        const stage = this.$refs.companyDetailsFormStage;

                        if (! stage || this.campaignBuilderStep >= 3 || window.innerWidth < 1024) {
                            this.campaignBuilderActionBarContentStyle = '';
                            this.campaignBuilderActionBarStyle = '';
                            this.campaignBuilderActionBarFrame = null;

                            return;
                        }

                        const rect = stage.getBoundingClientRect();

                        this.campaignBuilderActionBarStyle = '';
                        this.campaignBuilderActionBarContentStyle = `margin-left: ${Math.max(0, rect.left)}px; width: ${rect.width}px;`;
                        this.campaignBuilderActionBarFrame = null;
                    });
                },
                updateCampaignSetupActionBarPosition() {
                    if (this.campaignSetupActionBarFrame) {
                        cancelAnimationFrame(this.campaignSetupActionBarFrame);
                    }

                    this.campaignSetupActionBarFrame = requestAnimationFrame(() => {
                        const stage = this.$refs.campaignAgentSection;

	                        if (! stage || ! this.campaignBuilderOpen || this.campaignBuilderStep < 3 || ! this.campaignSetupModeSelected || this.campaignSetupIntroStep || window.innerWidth < 1024) {
                            this.campaignSetupActionBarContentStyle = '';
                            this.campaignSetupActionBarStyle = '';
                            this.campaignSetupActionBarFrame = null;

                            return;
                        }

                        const rect = stage.getBoundingClientRect();
                        const viewportPadding = 24;
                        const minWidth = Math.min(640, window.innerWidth - (viewportPadding * 2));
                        const width = Math.max(rect.width, minWidth);
                        const maxLeft = window.innerWidth - viewportPadding - width;
                        const left = Math.max(viewportPadding, Math.min(rect.left, maxLeft));

                        this.campaignSetupActionBarStyle = '';
                        this.campaignSetupActionBarContentStyle = `margin-left: ${left}px; width: ${width}px;`;
                        this.campaignSetupActionBarFrame = null;
                    });
                },
                campaignBuilderScrollContainer() {
                    return this.$root.querySelector('main');
                },
                scheduleCampaignBuilderLayoutUpdate() {
                    const run = () => {
                        this.updateCampaignBuilderStickyLayout();
                        this.updateCampaignBuilderScrollScene();
                        this.updateCampaignBuilderBottomPadding();
                        this.updateCampaignSetupBottomPadding();
                        this.updateCampaignBuilderActionBarPosition();
                        this.updateCampaignSetupActionBarPosition();
                    };

                    this.$nextTick(() => {
                        requestAnimationFrame(run);
                        window.setTimeout(run, 240);
                        window.setTimeout(run, 420);
                    });
                },
                campaignBuilderScrollSceneStyle() {
                    return '';
                },
                campaignBuilderColumnViewportStyle() {
                    return '';
                },
                campaignBuilderProgressStickyStyle() {
                    if (! this.campaignBuilderProgressSticky || window.innerWidth < 1024) {
                        return '';
                    }

                    return `position: sticky; top: ${this.campaignBuilderProgressStickyTop}px;`;
                },
                updateCampaignBuilderScrollScene() {
                    if (! this.campaignBuilderOpen || window.innerWidth < 1024) {
                        this.campaignBuilderSceneHeight = 0;
                        this.campaignBuilderColumnViewportHeight = 0;
                        this.campaignBuilderProgressOffset = 0;
                        this.campaignBuilderContentOffset = 0;
                        this.campaignBuilderProgressSticky = false;

                        return;
                    }

                    const progress = this.$refs.campaignBuilderProgressColumn;

                    if (! progress) {
                        return;
                    }

	                    const viewportHeight = Math.max(320, window.innerHeight - 48);
	                    const progressHeight = progress.scrollHeight;
	                    const stickyTop = Math.min(24, viewportHeight - progressHeight - 24);

	                    this.campaignBuilderColumnViewportHeight = 0;
	                    this.campaignBuilderSceneHeight = 0;
	                    this.campaignBuilderProgressOffset = 0;
	                    this.campaignBuilderContentOffset = 0;
	                    this.campaignBuilderProgressSticky = true;
	                    this.campaignBuilderProgressStickyTop = stickyTop;
                },
                updateCampaignBuilderStickyLayout() {
                    if (! this.campaignBuilderOpen || window.innerWidth < 1024) {
                        this.campaignBuilderProgressSticky = false;
                        this.campaignBuilderContentSticky = false;
                        this.campaignBuilderProgressStickyTop = 24;

                        return;
                    }

                    this.$nextTick(() => {
                        requestAnimationFrame(() => {
                            const progress = this.$refs.campaignBuilderProgressColumn;
                            const content = this.$refs.campaignBuilderContentScroll;

                            if (! progress || ! content) {
                                return;
                            }

                            const viewportHeight = Math.max(320, window.innerHeight - 48);

                            this.campaignBuilderProgressSticky = true;
                            this.campaignBuilderProgressStickyTop = Math.min(24, viewportHeight - progress.scrollHeight - 24);
                            this.campaignBuilderContentSticky = false;
                            this.updateCampaignBuilderScrollScene();
                        });
                    });
                },
                updateCampaignBuilderBottomPadding() {
                    const companyStepRefs = [
                        'companyIdentitySection',
                        'industryMarketSection',
                        'complianceLegalSection',
                    ];

                    const stepRef = companyStepRefs[this.campaignBuilderStep];

                    if (! stepRef) {
                        this.campaignBuilderBottomPadding = 0;

                        return;
                    }

                    this.$nextTick(() => {
                        requestAnimationFrame(() => {
                            const container = this.campaignBuilderScrollContainer();
                            const stage = this.$refs[stepRef];

                            if (! container || ! stage) {
                                return;
                            }

                            if (window.innerWidth < 1024) {
                                this.campaignBuilderBottomPadding = 88;
                                this.updateCampaignBuilderActionBarPosition();

                                return;
                            }

                            const containerRect = container.getBoundingClientRect();
                            const stageRect = stage.getBoundingClientRect();
                            const availableHeight = Math.max(0, containerRect.bottom - stageRect.top);
                            const footerClearance = 72;
                            const existingBottomPadding = parseFloat(window.getComputedStyle(stage).paddingBottom || '0') || 0;
                            const needsFooterClearance = stage.offsetHeight > Math.max(0, availableHeight - footerClearance);

                            this.campaignBuilderBottomPadding = needsFooterClearance ? Math.max(0, footerClearance - existingBottomPadding) : 0;
                            this.updateCampaignBuilderActionBarPosition();
                        });
                    });
                },
                updateCampaignSetupBottomPadding() {
                    if (! this.campaignBuilderOpen || this.campaignBuilderStep < 3 || ! this.campaignSetupModeSelected) {
                        this.campaignSetupBottomPadding = 0;

                        return;
                    }

                    this.$nextTick(() => {
                        requestAnimationFrame(() => {
                            const container = this.campaignBuilderScrollContainer();
                            const stage = this.$refs[this.campaignSetupStepRefName()];

                            if (! container || ! stage) {
                                return;
                            }

                            if (window.innerWidth < 1024) {
                                this.campaignSetupBottomPadding = 88;

                                return;
                            }

                            const containerRect = container.getBoundingClientRect();
                            const stageRect = stage.getBoundingClientRect();
                            const availableHeight = Math.max(0, containerRect.bottom - stageRect.top);
                            const footerClearance = 72;
                            const existingBottomPadding = parseFloat(window.getComputedStyle(stage).paddingBottom || '0') || 0;
                            const needsFooterClearance = stage.offsetHeight > Math.max(0, availableHeight - footerClearance);

                            this.campaignSetupBottomPadding = needsFooterClearance ? Math.max(0, footerClearance - existingBottomPadding) : 0;
                        });
                    });
                },
                scrollCampaignBuilderToStep(step, behavior = 'smooth') {
                    const companyStepRefs = [
                        'companyIdentitySection',
                        'industryMarketSection',
                        'complianceLegalSection',
                    ];

                    this.$nextTick(() => this.scrollBuilderStageToTop(step >= 3 ? 'campaignAgentSection' : (companyStepRefs[step] || 'companyDetailsFormStage'), behavior));
                },
                isBookAppointmentCampaign() {
                    return this.campaignSetup.type === 'Book Appointment';
                },
                campaignSetupStepsForMode() {
                    const steps = this.campaignSetupMode === 'fast' ? this.campaignSetupFastSteps : this.campaignSetupAdvancedSteps;

                    return this.isBookAppointmentCampaign() ? steps : steps.filter((step) => step.id !== 'booking');
                },
                campaignSetupGroups() {
                    return [...new Set(this.campaignSetupStepsForMode().map((step) => step.group).filter(Boolean))];
                },
                campaignSetupSecondaryStepIds() {
                    return ['geo', 'dispatch', 'priority'];
                },
                campaignSetupPrimaryTimelineSteps() {
                    const secondary = this.campaignSetupSecondaryStepIds();

                    return this.campaignSetupStepsForMode().filter((step) => ! secondary.includes(step.id));
                },
                campaignSetupSecondaryTimelineSteps() {
                    if (this.campaignSetupMode !== 'advanced') {
                        return [];
                    }

                    const secondary = this.campaignSetupSecondaryStepIds();

                    return this.campaignSetupStepsForMode().filter((step) => secondary.includes(step.id));
                },
                campaignSetupStepNumber(stepId) {
                    return Math.max(0, this.campaignSetupStepsForMode().findIndex((step) => step.id === stepId));
                },
                campaignSetupStepIndex(stepId = this.campaignSetup.current) {
                    return Math.max(0, this.campaignSetupStepsForMode().findIndex((step) => step.id === stepId));
                },
                campaignSetupCurrentStep(stepId = this.campaignSetup.current) {
                    return this.campaignSetupStepsForMode()[this.campaignSetupStepIndex(stepId)] || this.campaignSetupStepsForMode()[0];
                },
                campaignSetupContinueLabel() {
                    const steps = this.campaignSetupStepsForMode();
                    const currentIndex = this.campaignSetupStepIndex();

                    if (currentIndex >= steps.length - 1) {
                        return this.campaignSetupMode === 'fast' ? 'Test Campaign' : 'Launch Campaign';
                    }

                    return `Continue to ${steps[currentIndex + 1]?.label || 'Next Step'}`;
                },
                campaignSetupContinueIcon() {
                    return this.campaignSetupStepIndex() >= this.campaignSetupStepsForMode().length - 1 ? 'arrow_forward' : 'arrow_downward';
                },
                isCampaignSetupStepVisible(stepId) {
                    return this.campaignSetup.current === stepId || this.campaignSetupScrollFromStep === stepId;
                },
                campaignSetupStepRefName(stepId = this.campaignSetup.current) {
                    return stepId ? `campaignSetupStep_${stepId}` : 'campaignAgentSection';
                },
                campaignSetupStepIdFromRef(element) {
                    return String(element?.getAttribute?.('x-ref') || '').replace('campaignSetupStep_', '');
                },
                campaignSetupStepClasses(stepId) {
                    if (this.campaignSetupScrollFromStep === stepId) {
                        const leaveDirection = this.campaignSetupDirection === 'forward' ? '-translate-y-4' : 'translate-y-4';
                        const opacity = this.campaignSetupFadingStep === stepId ? 'opacity-0' : 'opacity-100';

                        return `pointer-events-none absolute inset-x-0 top-0 w-full ${opacity} ${leaveDirection}`;
                    }

                    if (this.campaignSetup.current === stepId) {
                        if (this.campaignSetupEnteringStep === stepId) {
                            return this.campaignSetupDirection === 'forward'
                                ? 'relative opacity-0 translate-y-8'
                                : 'relative opacity-0 -translate-y-8';
                        }

                        return 'relative opacity-100 translate-y-0';
                    }

                    return 'relative opacity-100 translate-y-0';
                },
                campaignSetupStepStyle(stepId) {
                    const base = 'transition: opacity 300ms ease, transform 300ms ease;';

                    if (this.campaignSetupScrollFromStep === stepId) {
                        const offset = this.campaignSetupDirection === 'forward' ? '-16px' : '16px';
                        const opacity = this.campaignSetupFadingStep === stepId ? '0' : '1';
                        const transform = this.campaignSetupFadingStep === stepId ? `translateY(${offset})` : 'translateY(0)';

                        return `${base} position: absolute; left: 0; right: 0; top: 0; width: 100%; opacity: ${opacity}; transform: ${transform}; pointer-events: none;`;
                    }

                    if (this.campaignSetup.current === stepId) {
                        if (this.campaignSetupEnteringStep === stepId) {
                            const offset = this.campaignSetupDirection === 'forward' ? '32px' : '-32px';

                            return `${base} position: relative; opacity: 0; transform: translateY(${offset});`;
                        }

                        return `${base} position: relative; opacity: 1; transform: translateY(0);`;
                    }

                    return 'display: none;';
                },
                campaignSetupHeading(stepId = this.campaignSetup.current) {
                    const headings = {
                        start: 'Create Campaign',
                        type: 'Choose Campaign Type',
	                        source: 'Where Should This Campaign Get Leads From?',
	                        integration: 'Connect Lead Source',
	                        brief: 'Campaign Context',
                        general: 'General Settings',
	                        resources: 'Resources & Offers',
                        agent: 'AI Agent',
	                        channels: 'Outreach Channels',
                        discounts: 'Discount Codes',
                        booking: 'Booking',
		                        availability: 'Scheduling Settings',
                        sequence: 'Outreach Sequence',
                        followups: 'Follow-Ups',
                        handoff: 'Handoff',
                        intelligence: 'Conversation Intelligence',
                        geo: 'Geo Permissions',
                        dispatch: 'Dispatch Conditions',
                        priority: 'Campaign Priority',
                        review: this.campaignSetupMode === 'fast' ? 'Review & Test' : 'Review & Launch Your Campaign',
                    };

                    return headings[stepId] || this.campaignSetupCurrentStep(stepId)?.label || 'Campaign Setup';
                },
                campaignSetupDescription(stepId = this.campaignSetup.current) {
                    const descriptions = {
                        start: 'Start with a campaign objective. We’ll generate a campaign name and recommended defaults automatically. You can rename it later.',
                        type: 'Select the main objective of this campaign. Outcraft will use it to prepare recommended outreach defaults, sequence, and insights.',
	                        source: 'Choose the system that will provide contacts, customer events, or campaign triggers.',
	                        integration: 'Connect your selected source to use real customer data, merge tags, and campaign triggers.',
	                        brief: 'Define the essence and goal of the campaign.',
                        general: 'Configure general campaign settings, such as target audience, messaging preferences, and performance goals. This will help the AI tailor its interactions to better suit your campaign\'s objectives.',
	                        resources: 'Define what the AI can send or offer after the lead accepts.',
                        agent: 'Choose how your AI agent introduces itself, sounds, and represents your company.',
	                        channels: 'Set up the channels your AI uses to connect with customers - calls, SMS, WhatsApp and email. Configure how each one operates.',
                        discounts: 'Manage discount codes the AI can include in email and message content.',
                        booking: 'Configure how the AI books meetings and which scheduling link it should offer.',
		                        availability: 'Outreach is scheduled and sent based on the lead\'s local timezone. The timezone is inferred from the lead\'s phone number and country data.',
                        sequence: 'Build an outreach sequence that will be applied for this campaign',
                        followups: 'Configure when AI should continue the conversation after the first outreach.',
                        handoff: 'Configure when AI should pass the conversation to a human.',
                        intelligence: 'See and manage how AI evaluates interactions with leads, and set up custom evaluation fields to track the most important information for your business.',
                        geo: 'Choose which countries or regions this campaign is allowed to contact.',
                        dispatch: 'Define when this campaign should be dispatched based on lead metadata.',
                        priority: 'Control what happens when a lead qualifies for multiple campaigns at the same time.',
                        review: this.campaignSetupMode === 'fast' ? 'Your campaign draft is ready for a test. Connect your lead source before launching live outreach.' : 'Check the campaign setup, publish the latest knowledge updates, and test your AI agent before going live.',
                    };

                    return descriptions[stepId] || this.campaignSetupCurrentStep(stepId)?.description || '';
                },
                applyCampaignSetupMode(mode, forceFirstStep = false) {
                    const normalizedMode = mode === 'advanced' ? 'advanced' : 'fast';

	                    this.campaignSetupDirection = 'forward';
	                    this.campaignSetupMode = normalizedMode;
	                    this.campaignSetupModeSelected = true;
	                    this.campaignSetupIntroStep = '';
                    this.campaignSetupScrollFromStep = null;
                    this.campaignSetupFadingStep = null;
                    this.campaignSetupEnteringStep = null;

	                    if (forceFirstStep || ! this.campaignSetupStepsForMode().some((step) => step.id === this.campaignSetup.current)) {
	                        this.campaignSetup.current = this.campaignSetupStepsForMode()[0]?.id || 'review';
	                    }

                    this.$nextTick(() => {
                        this.scrollCampaignSetupToCurrent();
                        this.updateCampaignBuilderStickyLayout();
                        this.updateCampaignSetupBottomPadding();
                        this.updateCampaignSetupActionBarPosition();
                    });
                    this.syncUrl();
                },
                chooseCampaignSetupPath(mode) {
                    this.applyCampaignSetupMode(mode, true);
                },
                setCampaignSetupMode(mode) {
                    const normalizedMode = mode === 'advanced' ? 'advanced' : 'fast';

                    if (this.campaignSetupMode === normalizedMode && this.campaignSetupModeSelected) {
                        return;
                    }

                    if (! this.campaignSetupModeSelected) {
                        this.applyCampaignSetupMode(normalizedMode, true);

                        return;
                    }

                    if (this.campaignSetupModeTransitionTimer) {
                        window.clearTimeout(this.campaignSetupModeTransitionTimer);
                    }

                    this.campaignBuilderTransitionLabel = 'Updating Setup Mode...';
                    this.campaignBuilderTransitioning = true;

                    this.campaignSetupModeTransitionTimer = window.setTimeout(() => {
                        this.applyCampaignSetupMode(normalizedMode);

                        this.$nextTick(() => {
                            window.requestAnimationFrame(() => {
                                this.campaignBuilderTransitioning = false;
                                this.campaignBuilderTransitionLabel = 'Preparing Campaign Setup...';
                                this.campaignSetupModeTransitionTimer = null;
                            });
                        });
                    }, 700);
	                },
                continueCampaignSetupAdvanced() {
	                    this.campaignSetupDirection = 'forward';
	                    this.campaignSetupMode = 'advanced';
	                    this.campaignSetupModeSelected = true;
	                    this.campaignSetupIntroStep = '';
	                    this.campaignSetup.current = this.campaignSetupStepsForMode()[0]?.id || 'review';
                    this.campaignSetupScrollFromStep = null;
                    this.campaignSetupFadingStep = null;
                    this.campaignSetupEnteringStep = null;
	                    this.$nextTick(() => {
	                        this.scrollCampaignSetupToCurrent();
	                        this.updateCampaignBuilderStickyLayout();
	                        this.updateCampaignSetupBottomPadding();
	                        this.updateCampaignSetupActionBarPosition();
	                    });
	                    this.syncUrl();
	                },
                setCampaignSetupStep(step) {
                    if (step === this.campaignSetup.current) {
                        return;
                    }

                    const currentIndex = this.campaignSetupStepIndex();
                    const nextIndex = this.campaignSetupStepsForMode().findIndex((item) => item.id === step);
                    const previousStep = this.campaignSetup.current;

                    if (nextIndex === -1) {
                        return;
                    }

                    if (this.campaignSetupScrollTimer) {
                        window.clearTimeout(this.campaignSetupScrollTimer);
                    }

                    this.campaignSetupDirection = nextIndex >= currentIndex ? 'forward' : 'back';
                    this.campaignSetupScrollFromStep = previousStep;
                    this.campaignSetupFadingStep = null;
                    this.campaignSetupEnteringStep = step;
                    this.campaignSetup.current = step;
	                    this.$nextTick(() => {
                            window.requestAnimationFrame(() => {
                                window.requestAnimationFrame(() => {
                                    this.campaignSetupFadingStep = previousStep;
                                    this.campaignSetupEnteringStep = null;
	                                this.updateCampaignBuilderStickyLayout();
	                                this.updateCampaignSetupBottomPadding();
	                                this.updateCampaignSetupActionBarPosition();
                                });
                            });
	                    });

                    this.campaignSetupScrollTimer = window.setTimeout(() => {
                        this.campaignSetupScrollFromStep = null;
                        this.campaignSetupFadingStep = null;
                        this.campaignSetupEnteringStep = null;
                        this.updateCampaignBuilderStickyLayout();
                        this.updateCampaignSetupBottomPadding();
                        this.updateCampaignSetupActionBarPosition();
                    }, 620);

	                    this.syncUrl();
	                },
                scrollCampaignSetupToCurrent() {
                    this.scrollBuilderStageToTop(this.campaignSetupStepRefName());
                },
                scrollBuilderStageToTop(refName, behavior = 'smooth') {
                    const run = () => {
                        const container = this.campaignBuilderScrollContainer();
                        const stage = this.$refs[refName];

                        if (! container || ! stage) {
                            return;
                        }

                        const containerRect = container.getBoundingClientRect();
                        const stageRect = stage.getBoundingClientRect();
                        const companyStepRefs = ['companyIdentitySection', 'industryMarketSection', 'complianceLegalSection'];
                        const alignmentRef = companyStepRefs.includes(refName) ? this.$refs.companySetupProgressNav : null;
                        const alignmentRect = alignmentRef?.getBoundingClientRect?.();
                        const targetTop = alignmentRect
                            ? container.scrollTop + stageRect.top - alignmentRect.top
                            : container.scrollTop + stageRect.top - containerRect.top - 76;
                        const clampedTargetTop = Math.max(0, Math.min(targetTop, container.scrollHeight - container.clientHeight));

                        if (behavior === 'auto') {
                            this.cancelCampaignBuilderScrollAnimation();
                            container.scrollTop = clampedTargetTop;

                            return;
                        }

                        this.animateCampaignBuilderScroll(container, clampedTargetTop);
                    };

                    requestAnimationFrame(() => requestAnimationFrame(run));
                },
                cancelCampaignBuilderScrollAnimation() {
                    if (! this.campaignBuilderScrollFrame) {
                        return;
                    }

                    cancelAnimationFrame(this.campaignBuilderScrollFrame);
                    this.campaignBuilderScrollFrame = null;
                },
                animateCampaignBuilderScroll(container, targetTop) {
                    this.cancelCampaignBuilderScrollAnimation();

                    const startTop = container.scrollTop;
                    const distance = targetTop - startTop;

                    if (Math.abs(distance) < 1) {
                        container.scrollTop = targetTop;

                        return;
                    }

                    const duration = Math.min(520, Math.max(260, Math.abs(distance) * 0.45));
                    const startTime = performance.now();
                    const ease = (t) => t < 0.5 ? 4 * t * t * t : 1 - Math.pow(-2 * t + 2, 3) / 2;

                    const step = (now) => {
                        const progress = Math.min(1, (now - startTime) / duration);

                        container.scrollTop = startTop + distance * ease(progress);

                        if (progress < 1) {
                            this.campaignBuilderScrollFrame = requestAnimationFrame(step);

                            return;
                        }

                        container.scrollTop = targetTop;
                        this.campaignBuilderScrollFrame = null;
                    };

                    this.campaignBuilderScrollFrame = requestAnimationFrame(step);
                },
                campaignSetupStatus(step) {
                    if (this.campaignSetup.current === step) {
                        return 'active';
                    }

                    if (this.campaignSetup.attention.includes(step)) {
                        return 'attention';
                    }

                    if (this.campaignSetup.completed.includes(step)) {
                        return 'done';
                    }

                    return 'todo';
                },
                campaignSetupStatusIcon(step, index, compact = false) {
                    const size = compact ? 'size-6' : 'size-8';
                    const dot = compact ? 'size-1.5' : 'size-2.5';
                    const status = this.campaignSetupStatus(step);

                    if (status === 'done') {
                        return `<span class="relative z-10 flex ${size} shrink-0 items-center justify-center rounded-full bg-indigo-600 text-white"><span class="outcraft-icon !text-[16px]">check</span></span>`;
                    }

                    if (status === 'attention') {
                        return `<span class="relative z-10 flex ${size} shrink-0 items-center justify-center rounded-full border-2 border-amber-400 bg-amber-50 text-amber-600"><span class="outcraft-icon !text-[15px]">report</span></span>`;
                    }

                    if (status === 'active') {
                        return `<span class="relative z-10 flex ${size} shrink-0 items-center justify-center rounded-full border-2 border-indigo-600 bg-white"><span class="${dot} rounded-full bg-indigo-600"></span></span>`;
                    }

                    return `<span class="relative z-10 flex ${size} shrink-0 items-center justify-center rounded-full border-2 border-gray-300 bg-white text-xs font-semibold text-gray-500">${index + 1}</span>`;
                },
                completeCampaignSetupStep(step = this.campaignSetup.current) {
                    if (! this.campaignSetup.completed.includes(step)) {
                        this.campaignSetup.completed.push(step);
                    }
                },
                nextCampaignSetupStep() {
                    if (this.campaignSetup.current === 'integration' && this.requiresIntegration() && this.campaignSetup.integrationStatus !== 'Connected') {
                        this.markCampaignSetupAttention('integration');
                    } else {
                        this.completeCampaignSetupStep();
                    }

                    if (this.campaignSetupStepIndex() >= this.campaignSetupStepsForMode().length - 1) {
                        return;
                    }

                    this.setCampaignSetupStep(this.campaignSetupStepsForMode()[this.campaignSetupStepIndex() + 1].id);
                },
                previousCampaignSetupStep() {
	                    if (this.campaignSetupStepIndex() <= 0) {
	                        this.campaignSetupModeSelected = false;
	                        this.campaignSetupIntroStep = 'integration';
	                        this.campaignSetupActionBarStyle = '';
                        this.campaignSetupScrollFromStep = null;
                        this.campaignSetupFadingStep = null;
                        this.campaignSetupEnteringStep = null;
                        this.syncUrl();

                        return;
                    }

                    this.setCampaignSetupStep(this.campaignSetupStepsForMode()[this.campaignSetupStepIndex() - 1].id);
                },
                markCampaignSetupAttention(step) {
                    if (! this.campaignSetup.attention.includes(step)) {
                        this.campaignSetup.attention.push(step);
                    }
                },
                clearCampaignSetupAttention(step) {
                    this.campaignSetup.attention = this.campaignSetup.attention.filter((item) => item !== step);
                },
	                selectCampaignType(type) {
	                    this.campaignSetup.type = type;
	                    this.campaignSetup.name = `${type} Campaign`;
	                    this.completeCampaignSetupStep('type');
	                    if (! this.campaignSetupStepsForMode().some((step) => step.id === this.campaignSetup.current)) {
	                        this.campaignSetup.current = this.campaignSetupStepsForMode()[0]?.id || 'review';
	                    }
	                    if (this.campaignBuilderStep >= 3 && ! this.campaignSetupModeSelected) {
	                        this.campaignSetupActionBarStyle = '';
	                        this.campaignSetupIntroStep = 'source';
	                        this.syncUrl();
	                    }
	                },
	                selectLeadSource(source) {
	                    this.campaignSetup.source = source;
	                    this.campaignSetup.integrationStatus = source === 'CSV File / Manual' ? 'No Integration Required' : 'Not Connected';
	                    this.completeCampaignSetupStep('source');
	                    if (this.campaignBuilderStep >= 3 && ! this.campaignSetupModeSelected) {
	                        this.campaignSetupActionBarStyle = '';
	                        this.campaignSetupIntroStep = 'integration';
	                        this.syncUrl();
	                    }
	                },
                requiresIntegration() {
                    return Boolean(this.campaignSetup.source) && ! ['CSV File / Manual', 'Custom API'].includes(this.campaignSetup.source);
                },
                campaignIntegrationSummary() {
                    if (this.campaignSetup.source === 'CSV File / Manual') {
                        return 'No Integration Required';
                    }

                    return this.campaignSetup.integrationStatus;
                },
                connectCampaignSource() {
                    this.campaignSetup.integrationStatus = this.requiresIntegration() ? 'Connected' : 'No Integration Required';
                    this.completeCampaignSetupStep('integration');
                    this.clearCampaignSetupAttention('integration');
                    this.continueAfterLeadSourceIntegration();
                },
                skipCampaignIntegration() {
                    this.campaignSetup.integrationStatus = this.requiresIntegration() ? 'Skipped for Now' : 'No Integration Required';
                    if (this.requiresIntegration()) {
                        this.markCampaignSetupAttention('integration');
                    } else {
                        this.clearCampaignSetupAttention('integration');
                    }
                    this.continueAfterLeadSourceIntegration();
                },
                continueAfterLeadSourceIntegration() {
                    if (this.campaignBuilderStep >= 3 && ! this.campaignSetupModeSelected) {
                        this.campaignSetupIntroStep = 'mode';
                        this.campaignSetupActionBarStyle = '';
                        this.syncUrl();
                    }
                },
                toggleChannel(channel) {
                    this.campaignSetup.channels[channel] = ! this.campaignSetup.channels[channel];

                    if (! this.campaignSetup.channels[channel]) {
                        this.campaignSetup.channelOpen[channel] = false;
                    }

                    this.scheduleCampaignBuilderLayoutUpdate();
                },
                selectCampaignSetupLanguage(code) {
                    this.campaignSetup.activeLanguage = code;
                },
                setCampaignSetupDefaultLanguage(code) {
                    if (! this.campaignSetup.languages.some((language) => language.code === code)) {
                        return;
                    }

                    this.campaignSetup.defaultLanguage = code;
                },
                campaignSetupActiveLanguage() {
                    return this.campaignSetup.languages.find((language) => language.code === this.campaignSetup.activeLanguage)
                        || this.campaignSetup.languages[0]
                        || { code: '', label: '', name: '', flagCode: '' };
                },
                campaignSetupFlagUrl(language) {
                    const code = String(language?.flagCode || language?.code || '').toLowerCase();

                    return code ? `https://cdn.jsdelivr.net/npm/flag-icons/flags/1x1/${code}.svg` : '';
                },
                filteredCampaignSetupLanguageOptions() {
                    const selectedCodes = new Set(this.campaignSetup.languages.map((language) => language.code));
                    const query = String(this.campaignSetup.languageSearch || '').trim().toLowerCase();

                    return this.campaignSetupLanguageOptions.filter((language) => {
                        if (selectedCodes.has(language.code)) {
                            return false;
                        }

                        if (! query) {
                            return true;
                        }

                        return [language.code, language.label, language.name]
                            .some((value) => String(value || '').toLowerCase().includes(query));
                    });
                },
                addCampaignSetupLanguage(code = '') {
                    const nextLanguage = code
                        ? this.campaignSetupLanguageOptions.find((language) => language.code === code)
                        : this.filteredCampaignSetupLanguageOptions()[0];

                    if (! nextLanguage) {
                        return;
                    }

                    this.campaignSetup.languages.push({ ...nextLanguage });
                    this.campaignSetup.activeLanguage = nextLanguage.code;
                    this.campaignSetup.languageMenuOpen = false;
                    this.campaignSetup.languageSearch = '';
                    this.scheduleCampaignBuilderLayoutUpdate();
                },
                enabledCampaignChannels() {
                    const labels = { calls: 'Calls', email: 'Email', sms: 'SMS', whatsapp: 'WhatsApp' };

                    return Object.entries(this.campaignSetup.channels)
                        .filter(([, enabled]) => enabled)
                        .map(([key]) => labels[key]);
                },
                miniSwitch(enabled) {
                    return `<span class="relative inline-flex h-6 w-11 rounded-full p-0.5 ${enabled ? 'bg-indigo-600' : 'bg-gray-200'}"><span class="size-5 rounded-full bg-white shadow-sm ${enabled ? 'translate-x-5' : 'translate-x-0'}"></span></span>`;
                },
                recommendedInsights() {
                    if (this.campaignSetup.type === 'Book Appointment') {
                        return ['Meeting Booked · Yes / No', 'Preferred Time · Text Summary', 'Qualification Level · Score 1–5', 'Main Objection · Classified'];
                    }

                    if (this.campaignSetup.type === 'Provide Support') {
                        return ['Issue Resolved · Yes / No', 'Issue Category · Classified', 'Customer Sentiment · Score 1–5', 'Escalation Needed · Yes / No'];
                    }

                    return ['Purchase Intent · Score 1–5', 'Objection Type · Classified', 'Discount Sensitivity · Yes / No', 'Reason for Abandonment · Text Summary'];
                },
	                evaluationFormatDescription(format) {
	                    return {
	                        'Yes / No': 'Return a simple yes or no based on detected conversation signals.',
	                        'Text Summary': 'Extract important details and return them as structured short text.',
	                        Classified: 'Define your own labels and let AI assign the best matching outcome.',
	                        Score: 'Evaluate interaction quality using a numeric score.',
	                    }[format] || '';
	                },
	                customFieldTextInputState(key) {
	                    if (! this.customFieldTextInputs[key]) {
	                        this.customFieldTextInputs[key] = {
	                            open: false,
	                            layoutOpen: false,
	                            search: '',
	                        };
	                    }

	                    return this.customFieldTextInputs[key];
	                },
	                openCustomFieldTextInput(key) {
	                    const state = this.customFieldTextInputState(key);

	                    state.layoutOpen = true;

	                    window.setTimeout(() => {
	                        state.open = true;
	                    }, 0);
	                },
	                closeCustomFieldTextInput(key) {
	                    const state = this.customFieldTextInputState(key);

	                    state.open = false;

	                    window.setTimeout(() => {
	                        if (! state.open) {
	                            state.layoutOpen = false;
	                        }
	                    }, 180);
	                },
	                filteredCustomFieldTextInputTags(key) {
	                    const query = String(this.customFieldTextInputState(key).search || '').trim().toLowerCase();

	                    if (! query) {
	                        return this.mergeTags;
	                    }

	                    return this.mergeTags.filter((tag) => tag.toLowerCase().includes(query));
	                },
	                toggleOutreachDay(day) {
	                    if (this.campaignSetup.outreachDays.includes(day)) {
	                        this.campaignSetup.outreachDays = this.campaignSetup.outreachDays.filter((item) => item !== day);
	                        return;
	                    }

	                    this.campaignSetup.outreachDays = this.outreachWeekdays.filter((item) => [...this.campaignSetup.outreachDays, day].includes(item));
	                },
	                selectAllOutreachDays() {
	                    this.campaignSetup.outreachDays = [...this.outreachWeekdays];
	                },
	                filteredCustomFields() {
                    const query = String(this.campaignSetup.customFieldSearch || '').trim().toLowerCase();

                    if (! query) {
                        return this.mergeTags;
                    }

                    return this.mergeTags.filter((tag) => tag.toLowerCase().includes(query));
                },
                openCampaignCustomFields() {
                    this.campaignSetup.customFieldsLayoutOpen = true;

                    this.$nextTick(() => {
                        this.campaignSetup.customFieldsOpen = true;
                    });
                },
                closeCampaignCustomFields() {
                    this.campaignSetup.customFieldsOpen = false;

                    window.setTimeout(() => {
                        if (! this.campaignSetup.customFieldsOpen) {
                            this.campaignSetup.customFieldsLayoutOpen = false;
                        }
                    }, 180);
                },
                closeCampaignSetupOverlays() {
                    this.campaignSetup.sequenceModalOpen = false;
                    this.campaignSetup.followupModalOpen = false;
                    this.campaignSetup.discountCodeModalOpen = false;
                    this.campaignSetup.overrideModalOpen = false;
                    this.campaignSetup.evaluationDrawerOpen = false;
                    this.campaignSetup.dispatchDrawerOpen = false;
                    this.campaignSetup.newDiscountCode = '';
                },
                addDiscountCode() {
                    const code = this.campaignSetup.newDiscountCode.trim();
                    if (code && ! this.campaignSetup.discountCodes.some((item) => item.value === code)) {
                        this.campaignSetup.discountCodes.push({
                            value: code,
                            created: 'Just now',
                        });
                    }
                    this.closeCampaignSetupOverlays();
                    this.scheduleCampaignBuilderLayoutUpdate();
                },
                launchBlocked() {
                    return (this.requiresIntegration() && this.campaignSetup.integrationStatus !== 'Connected')
                        || ! this.campaignSetup.source
                        || this.enabledCampaignChannels().length === 0
                        || ! this.campaignSetup.knowledgePublished;
                },
                reviewBadge(status) {
                    const classes = {
                        Done: 'bg-green-50 text-green-700 ring-green-600/20',
                        Optional: 'bg-gray-50 text-gray-700 ring-gray-600/20',
                        'Needs Attention': 'bg-amber-50 text-amber-700 ring-amber-600/20',
                        'Required Before Launch': 'bg-red-50 text-red-700 ring-red-600/20',
                    };

                    return `<span class="inline-flex rounded-md px-2 py-1 text-xs font-medium ring-1 ring-inset ${classes[status] || classes.Optional}">${status}</span>`;
                },
                bookingSummary() {
                    const links = [
                        this.campaignSetup.bookingCallLink ? `Calls: ${this.campaignSetup.bookingCallLink}` : '',
                        this.campaignSetup.bookingEmailLink ? `Email: ${this.campaignSetup.bookingEmailLink}` : '',
                        this.campaignSetup.bookingSmsLink ? `SMS: ${this.campaignSetup.bookingSmsLink}` : '',
                    ].filter(Boolean);

                    return links.join(' · ') || 'No Booking Links Set';
                },
                campaignReviewRows() {
                    const integrationBlocked = this.requiresIntegration() && this.campaignSetup.integrationStatus !== 'Connected';
                    const hasBrief = String(this.campaignSetup.brief.context || '').trim().length > 20;
                    const channels = this.enabledCampaignChannels();

                    return [
                        { label: 'Campaign Name', summary: this.campaignSetup.name || 'Generated automatically', status: this.campaignSetup.type ? 'Done' : 'Optional' },
                        { label: 'Company', summary: this.companyForm.name || 'Outcraft AI', status: 'Done' },
                        { label: 'Campaign Type', summary: this.campaignSetup.type || 'Not selected', status: this.campaignSetup.type ? 'Done' : 'Required Before Launch' },
                        { label: 'Lead Source', summary: this.campaignSetup.source || 'Not selected', status: this.campaignSetup.source ? 'Done' : 'Required Before Launch' },
                        { label: 'Integration Status', summary: this.campaignIntegrationSummary(), status: integrationBlocked ? 'Required Before Launch' : 'Done' },
                        { label: 'Campaign Brief Status', summary: hasBrief ? 'Structured brief ready' : 'Needs more context', status: hasBrief ? 'Done' : 'Required Before Launch' },
                        { label: 'AI Agent', summary: `${this.campaignSetup.agentName}, ${this.campaignSetup.voice}`, status: this.campaignSetup.agentName && this.campaignSetup.voice ? 'Done' : 'Required Before Launch' },
                        { label: 'Channels', summary: channels.join(', ') || 'No enabled channel', status: channels.length ? 'Done' : 'Required Before Launch' },
                        { label: 'Agent Availability', summary: this.campaignSetupMode === 'fast' ? 'Working Hours' : (this.campaignSetup.scheduleMode === 'all-day' ? 'Always On' : (this.campaignSetup.scheduleMode === 'custom' ? `Custom Schedule: ${this.campaignSetup.outreachDays.join(', ')}, ${this.campaignSetup.outreachStartHour} to ${this.campaignSetup.outreachEndHour}` : 'Working Hours')), status: 'Done' },
                        ...(this.isBookAppointmentCampaign() ? [{ label: 'Booking', summary: this.bookingSummary(), status: this.campaignSetup.bookingCallLink ? 'Done' : 'Required Before Launch' }] : []),
                        { label: 'Outreach Sequence', summary: this.campaignSetupMode === 'fast' ? 'Recommended sequence based on campaign type and channels' : 'Advanced sequence configured', status: 'Done' },
                        { label: 'Follow-Up Rules', summary: this.campaignSetupMode === 'fast' ? 'Recommended follow-ups enabled' : 'Response-based rules reviewed', status: 'Done' },
                        { label: 'Human Handoff', summary: this.campaignSetupMode === 'fast' ? 'Configure later' : (this.campaignSetup.handoff ? 'Enabled' : 'Disabled'), status: this.campaignSetup.handoff ? 'Done' : 'Optional' },
                        { label: 'Conversation Intelligence', summary: 'Interaction summary enabled by default', status: 'Done' },
                        { label: 'Lead Source Configuration', summary: this.campaignSetupMode === 'fast' ? 'Uses test data until source is connected' : (integrationBlocked ? 'Connect source' : 'Source events available'), status: integrationBlocked ? 'Needs Attention' : 'Done' },
                        { label: 'Geo Permissions', summary: this.campaignSetupMode === 'fast' ? 'Company default allowed regions' : '15 regions reviewed', status: 'Done' },
                        { label: 'Dispatch Conditions', summary: this.campaignSetupMode === 'fast' ? 'All eligible leads from selected source' : 'No custom condition set', status: 'Optional' },
                        { label: 'Campaign Priority', summary: this.campaignSetupMode === 'fast' ? 'No campaign override rules' : 'No override rules', status: 'Optional' },
                        { label: 'Knowledge Base Changes', summary: this.campaignSetup.knowledgePublished ? 'Published' : 'Not published', status: this.campaignSetup.knowledgePublished ? 'Done' : 'Required Before Launch' },
                    ];
                },
                setInsightsTab(tab) {
                    this.showLoader();
                    this.activeInsightsTab = tab;
                },
                toggleEngagementChannel(channel) {
                    if (this.selectedEngagementChannels.includes(channel)) {
                        if (this.selectedEngagementChannels.length === 1) {
                            return;
                        }

                        this.selectedEngagementChannels = this.selectedEngagementChannels.filter((item) => item !== channel);
                        this.showLoader(700);

                        return;
                    }

                    this.selectedEngagementChannels.push(channel);
                    this.showLoader(700);
                },
                campaignsPageRows() {
                    if (this.activeCampaignPageTab === 'A/B Tests') {
                        return this.abTestCampaigns;
                    }

                    if (this.activeCampaignPageTab === 'Archived') {
                        return this.archivedCampaigns;
                    }

                    return this.pinnedCampaigns;
                },
                campaignPageDescription() {
                    return {
                        Campaigns: 'Active and pinned campaigns your team is monitoring, editing, and opening most often.',
                        'A/B Tests': 'Variant campaigns used to compare messaging, timing, and outreach performance.',
                        Archived: 'Paused legacy campaigns kept for review, reporting, and historical context.',
                    }[this.activeCampaignPageTab] || '';
                },
                campaignAvatarType(campaign) {
                    const name = String(campaign?.name || '').toLowerCase();

                    if (name.includes('cart') || name.includes('checkout')) {
                        return 'cart';
                    }

                    if (name.includes('support') || name.includes('routing')) {
                        return 'support';
                    }

                    if (name.includes('shipping') || name.includes('delay')) {
                        return 'shipping';
                    }

                    if (name.includes('onboarding') || name.includes('greeting')) {
                        return 'onboarding';
                    }

                    if (name.includes('winback') || name.includes('holiday')) {
                        return 'winback';
                    }

                    if (this.activeCampaignPageTab === 'A/B Tests') {
                        return 'experiment';
                    }

                    if (this.activeCampaignPageTab === 'Archived') {
                        return 'archived';
                    }

                    return 'default';
                },
                campaignAvatarIcon(campaign) {
                    return {
                        cart: 'shopping-cart',
                        support: 'headset',
                        shipping: 'truck',
                        onboarding: 'sparkles',
                        winback: 'reply',
                        experiment: 'flask-conical',
                        archived: 'archive',
                        default: 'megaphone',
                    }[this.campaignAvatarType(campaign)] || 'megaphone';
                },
                insightsSubtitle() {
                    return {
                        Overview: 'A high-level read on outreach performance and revenue motion.',
                        Engagement: 'Track replies, opens, conversations, and channel-level activity.',
                        'Deep Dive': 'Inspect campaign, segment, and audience behavior in detail.',
                        Evaluations: 'Review quality scores, compliance checks, and outcome scoring.',
                        'Conversation Intelligence': 'Understand what customers say, ask, and object to.',
                    }[this.activeInsightsTab] || '';
                },
                insightsMetrics() {
                    const data = {
                        Overview: [
                            { label: 'Qualified Leads', value: '1,284', trend: '+8.2%', icon: 'group' },
                            { label: 'Conversion Rate', value: '18.7%', trend: '+2.4%', icon: 'trending_up' },
                            { label: 'Revenue Influenced', value: '$54.8k', trend: '+5.1%', icon: 'payments' },
                            { label: 'Avg. Response Time', value: '3m 12s', trend: '-6.8%', icon: 'schedule' },
                        ],
                        Engagement: [
                            { label: 'Open Rate', value: '64.2%', trend: '+4.8%', icon: 'drafts' },
                            { label: 'Reply Rate', value: '22.9%', trend: '+3.1%', icon: 'reply' },
                            { label: 'Call Connects', value: '418', trend: '+7.5%', icon: 'call' },
                            { label: 'Opt-Outs', value: '1.8%', trend: '-0.4%', icon: 'block' },
                        ],
                        'Deep Dive': [
                            { label: 'Top Segment Lift', value: '+14.6%', trend: '+2.2%', icon: 'analytics' },
                            { label: 'Winning Campaigns', value: '7', trend: '+1.0%', icon: 'emoji_events' },
                            { label: 'Stalled Leads', value: '96', trend: '-5.5%', icon: 'hourglass_empty' },
                            { label: 'Follow-Up Gap', value: '11h', trend: '-8.0%', icon: 'timeline' },
                        ],
                        Evaluations: [
                            { label: 'Quality Score', value: '92%', trend: '+1.7%', icon: 'verified' },
                            { label: 'Policy Pass Rate', value: '98.6%', trend: '+0.8%', icon: 'gpp_good' },
                            { label: 'Review Required', value: '23', trend: '-3.2%', icon: 'manage_search' },
                            { label: 'Resolution Accuracy', value: '89%', trend: '+2.9%', icon: 'task_alt' },
                        ],
                        'Conversation Intelligence': [
                            { label: 'Intent Detected', value: '74%', trend: '+5.4%', icon: 'psychology' },
                            { label: 'Objection Rate', value: '16%', trend: '-2.1%', icon: 'report' },
                            { label: 'Positive Sentiment', value: '61%', trend: '+3.6%', icon: 'sentiment_satisfied' },
                            { label: 'Handoff Mentions', value: '42', trend: '-1.5%', icon: 'support_agent' },
                        ],
                    };

                    return data[this.activeInsightsTab] || data.Overview;
                },
                insightsChartTitle() {
                    return {
                        Overview: 'Performance Trend',
                        Engagement: 'Channel Engagement',
                        'Deep Dive': 'Segment Lift',
                        Evaluations: 'Evaluation Score Trend',
                        'Conversation Intelligence': 'Conversation Themes',
                    }[this.activeInsightsTab] || 'Performance Trend';
                },
                insightsBars() {
                    const sets = {
                        Overview: [42, 58, 49, 72, 64, 78, 86],
                        Engagement: [55, 62, 71, 66, 76, 82, 73],
                        'Deep Dive': [34, 48, 62, 57, 69, 75, 81],
                        Evaluations: [74, 78, 82, 80, 86, 89, 92],
                        'Conversation Intelligence': [46, 59, 53, 68, 72, 79, 84],
                    };

                    return (sets[this.activeInsightsTab] || sets.Overview).map((height, index) => ({
                        label: ['M', 'T', 'W', 'T', 'F', 'S', 'S'][index],
                        height,
                    }));
                },
                insightsFocusAreas() {
                    const common = {
                        Overview: [
                            { title: 'High-Intent Lead Coverage', value: '84%', progress: 84 },
                            { title: 'Abandoned Cart Recovery', value: '71%', progress: 71 },
                            { title: 'Web Support Deflection', value: '63%', progress: 63 },
                            { title: 'Revenue Attribution Clarity', value: '58%', progress: 58 },
                        ],
                        Engagement: [
                            { title: 'Email Opens', value: '78%', progress: 78 },
                            { title: 'SMS Replies', value: '46%', progress: 46 },
                            { title: 'Call Answer Rate', value: '39%', progress: 39 },
                            { title: 'WhatsApp Engagement', value: '67%', progress: 67 },
                        ],
                    };

                    return common[this.activeInsightsTab] || [
                        { title: 'Campaign Variance', value: '73%', progress: 73 },
                        { title: 'Lead Intent Quality', value: '68%', progress: 68 },
                        { title: 'Conversation Completeness', value: '81%', progress: 81 },
                        { title: 'Human Review Efficiency', value: '52%', progress: 52 },
                    ];
                },
                insightsSignals() {
                    return [
                        { name: 'Discount Questions Correlate With Faster Checkout', segment: 'Abandoned Cart', impact: 'High', confidence: '92%' },
                        { name: 'Setup Guidance Reduces Handoff Requests', segment: 'New Customers', impact: 'High', confidence: '88%' },
                        { name: 'Evening Follow-Ups Improve Reply Quality', segment: 'US East', impact: 'Medium', confidence: '76%' },
                        { name: 'Bulk Pricing Mentions Need Clearer Routing', segment: 'Web Support', impact: 'Medium', confidence: '71%' },
                    ];
                },
                setActiveTab(tab, updateUrl = true) {
                    this.showLoader();
                    this.activeTab = tab;
                    this.leadDetailOpen = false;
                    this.leadDetailsEditing = false;
                    this.leadDetailsActionOpen = false;
                    this.campaignRunsActionOpen = false;
                    this.selectedLead = null;
                    this.resetTableState();

                    if (updateUrl) {
                        this.syncUrl();
                    }
                },
                isInteractionExpanded(interactionId) {
                    return this.expandedInteractions.includes(interactionId);
                },
                toggleInteractionExpanded(interactionId) {
                    if (this.isInteractionExpanded(interactionId)) {
                        this.expandedInteractions = this.expandedInteractions.filter((id) => id !== interactionId);

                        return;
                    }

                    this.expandedInteractions.push(interactionId);
                },
                messageBubbleMaxWidth(message) {
                    const length = String(message.speaker || '').length + String(message.text || '').length;

                    if (length <= 38) {
                        return 'min(46%, 100%)';
                    }

                    if (length <= 72) {
                        return 'min(62%, 100%)';
                    }

                    if (length <= 120) {
                        return 'min(76%, 100%)';
                    }

                    return 'min(88%, 100%)';
                },
                escapeHtml(value) {
                    return String(value ?? '')
                        .replace(/&/g, '&amp;')
                        .replace(/</g, '&lt;')
                        .replace(/>/g, '&gt;')
                        .replace(/"/g, '&quot;')
                        .replace(/'/g, '&#039;');
                },
                valueWithTooltip(value) {
                    const escapedValue = this.escapeHtml(value);

                    return `
                        <span class="group relative inline-flex max-w-full">
                            <span class="truncate">${escapedValue}</span>
                            <span class="pointer-events-none absolute bottom-full left-1/2 z-50 mb-2 -translate-x-1/2 translate-y-1 whitespace-nowrap rounded-lg bg-gray-900 px-3 py-2 text-xs font-medium text-white opacity-0 shadow-sm transition group-hover:translate-y-0 group-hover:opacity-100">
                                ${escapedValue || '&nbsp;'}
                                <span class="absolute left-1/2 top-full size-2 -translate-x-1/2 -translate-y-1 rotate-45 bg-gray-900"></span>
                            </span>
                        </span>
                    `;
                },
                showFloatingTooltip(event, text, width = 320) {
                    const value = String(text || '').trim();

                    if (!value) {
                        return;
                    }

                    const rect = event.currentTarget.getBoundingClientRect();
                    const margin = 12;
                    const tooltipWidth = Math.min(width, window.innerWidth - (margin * 2));
                    const centeredLeft = rect.left + (rect.width / 2);
                    const left = Math.max(
                        margin + (tooltipWidth / 2),
                        Math.min(window.innerWidth - margin - (tooltipWidth / 2), centeredLeft),
                    );

                    this.floatingTooltip = {
                        visible: true,
                        text: value,
                        left,
                        top: Math.max(margin + 40, rect.top - 10),
                        width: tooltipWidth,
                    };
                },
                hideFloatingTooltip() {
                    this.floatingTooltip.visible = false;
                },
                copyContact(value) {
                    const text = String(value || '').trim();

                    if (!text) {
                        return;
                    }

                    if (navigator.clipboard?.writeText) {
                        navigator.clipboard.writeText(text);

                        return;
                    }

                    const input = document.createElement('textarea');
                    input.value = text;
                    input.setAttribute('readonly', '');
                    input.style.position = 'fixed';
                    input.style.opacity = '0';
                    document.body.appendChild(input);
                    input.select();
                    document.execCommand('copy');
                    document.body.removeChild(input);
                },
                leadCountryOption(code) {
                    const normalized = String(code || 'US').toUpperCase();

                    return this.leadCountryOptions.find((option) => option.code === normalized) || this.leadCountryOptions[0];
                },
                leadCountryLabel(code) {
                    const country = this.leadCountryOption(code);

                    return `${country.flag} ${country.name} (${country.code})`;
                },
                toggleLeadSelect(name) {
                    this.leadCreatedCalendarOpen = false;
                    this.leadCalendarMenuOpen = '';
                    this.leadSelectOpen = this.leadSelectOpen === name ? '' : name;
                },
                selectLeadCountry(code) {
                    this.leadEditForm.country = code;
                    this.leadSelectOpen = '';
                },
                selectLeadTimezone(value) {
                    this.leadEditForm.timezone = value;
                    this.leadSelectOpen = '';
                },
                selectLeadStatus(value) {
                    this.leadEditForm.state = value;
                    this.leadSelectOpen = '';
                },
                parseLeadCreatedDate(value) {
                    const source = String(value || '').trim();
                    const match = source.match(/^(\d{1,2}),\s+([A-Za-z]+),\s+(\d{4})/);

                    if (match) {
                        return new Date(`${match[2]} ${match[1]}, ${match[3]} 12:00:00`);
                    }

                    const fallback = new Date(source);

                    if (!Number.isNaN(fallback.getTime())) {
                        return fallback;
                    }

                    return new Date();
                },
                formatDateInput(date) {
                    const year = date.getFullYear();
                    const month = String(date.getMonth() + 1).padStart(2, '0');
                    const day = String(date.getDate()).padStart(2, '0');

                    return `${year}-${month}-${day}`;
                },
                formatLeadCreatedLabel(value) {
                    if (!value) {
                        return 'Select Date';
                    }

                    const date = new Date(`${value}T12:00:00`);

                    if (Number.isNaN(date.getTime())) {
                        return 'Select Date';
                    }

                    return date.toLocaleDateString('en-US', {
                        month: 'long',
                        day: 'numeric',
                        year: 'numeric',
                    });
                },
                formatLeadCreatedTooltip(value) {
                    const date = new Date(`${value}T12:00:00`);
                    const month = date.toLocaleDateString('en-US', { month: 'long' });

                    return `${date.getDate()}, ${month}, ${date.getFullYear()} 12:00`;
                },
                setLeadCreatedCalendarMonth(value) {
                    const date = new Date(`${value}T12:00:00`);
                    const safeDate = Number.isNaN(date.getTime()) ? new Date() : date;

                    this.leadCreatedCalendarMonth = this.formatDateInput(new Date(safeDate.getFullYear(), safeDate.getMonth(), 1));
                },
                toggleLeadCreatedCalendar() {
                    if (!this.leadCreatedCalendarMonth) {
                        this.setLeadCreatedCalendarMonth(this.leadEditForm.createdDate || this.formatDateInput(new Date()));
                    }

                    this.leadSelectOpen = '';
                    this.leadCreatedCalendarOpen = !this.leadCreatedCalendarOpen;
                    this.leadCalendarMenuOpen = '';
                },
                leadCreatedCalendarTitle() {
                    const date = new Date(`${this.leadCreatedCalendarMonth || this.formatDateInput(new Date())}T12:00:00`);

                    return date.toLocaleDateString('en-US', {
                        month: 'long',
                        year: 'numeric',
                    });
                },
                leadCreatedCalendarMonthIndex() {
                    const date = new Date(`${this.leadCreatedCalendarMonth || this.formatDateInput(new Date())}T12:00:00`);

                    return date.getMonth();
                },
                leadCreatedCalendarMonthName() {
                    return this.leadCalendarMonths[this.leadCreatedCalendarMonthIndex()];
                },
                leadCreatedCalendarYear() {
                    const date = new Date(`${this.leadCreatedCalendarMonth || this.formatDateInput(new Date())}T12:00:00`);

                    return date.getFullYear();
                },
                leadCreatedYearOptions() {
                    const currentYear = new Date().getFullYear();

                    return Array.from({ length: 12 }, (_, index) => currentYear + 1 - index);
                },
                toggleLeadCalendarMenu(name) {
                    this.leadCalendarMenuOpen = this.leadCalendarMenuOpen === name ? '' : name;
                },
                selectLeadCreatedMonth(monthIndex) {
                    const date = new Date(`${this.leadCreatedCalendarMonth || this.formatDateInput(new Date())}T12:00:00`);
                    date.setMonth(monthIndex);

                    this.setLeadCreatedCalendarMonth(this.formatDateInput(date));
                    this.leadCalendarMenuOpen = '';
                },
                selectLeadCreatedYear(year) {
                    const date = new Date(`${this.leadCreatedCalendarMonth || this.formatDateInput(new Date())}T12:00:00`);
                    date.setFullYear(year);

                    this.setLeadCreatedCalendarMonth(this.formatDateInput(date));
                    this.leadCalendarMenuOpen = '';
                },
                moveLeadCreatedCalendar(offset) {
                    const date = new Date(`${this.leadCreatedCalendarMonth || this.formatDateInput(new Date())}T12:00:00`);
                    date.setMonth(date.getMonth() + offset);

                    this.setLeadCreatedCalendarMonth(this.formatDateInput(date));
                    this.leadCalendarMenuOpen = '';
                },
                leadCreatedCalendarDays() {
                    const monthDate = new Date(`${this.leadCreatedCalendarMonth || this.formatDateInput(new Date())}T12:00:00`);
                    const firstDay = new Date(monthDate.getFullYear(), monthDate.getMonth(), 1);
                    const lastDay = new Date(monthDate.getFullYear(), monthDate.getMonth() + 1, 0);
                    const offset = (firstDay.getDay() + 6) % 7;
                    const days = Array.from({ length: offset }, (_, index) => ({
                        key: `blank-${index}`,
                        blank: true,
                    }));

                    for (let day = 1; day <= lastDay.getDate(); day++) {
                        const date = this.formatDateInput(new Date(monthDate.getFullYear(), monthDate.getMonth(), day));

                        days.push({
                            key: date,
                            blank: false,
                            date,
                            day,
                            selected: date === this.leadEditForm.createdDate,
                        });
                    }

                    return days;
                },
                selectLeadCreatedDate(value) {
                    this.leadEditForm.createdDate = value;
                    this.setLeadCreatedCalendarMonth(value);
                    this.leadCreatedCalendarOpen = false;
                    this.leadCalendarMenuOpen = '';
                },
                fillLeadEditForm() {
                    const [firstName, lastName] = this.selectedLeadNameParts();
                    const createdDate = this.formatDateInput(this.parseLeadCreatedDate(this.selectedLead?.ageTooltip || '25, April, 2026 18:56'));

                    this.leadEditForm = {
                        firstName,
                        lastName,
                        email: this.selectedLead?.email || 'biruhl@msn.com',
                        phone: this.selectedLead?.phone || '+12145059504',
                        country: this.selectedLead?.country || 'US',
                        state: this.selectedLead?.state || 'Idle',
                        timezone: this.selectedLead?.timezone || 'America / New York',
                        createdDate,
                        ignoreNightRestrictions: Boolean(this.selectedLead?.ignoreNightRestrictions),
                        testUser: Boolean(this.selectedLead?.testUser),
                    };
                    this.setLeadCreatedCalendarMonth(createdDate);
                    this.leadCreatedCalendarOpen = false;
                    this.leadCalendarMenuOpen = '';
                    this.leadSelectOpen = '';
                },
                applyLeadEditForm() {
                    if (!this.selectedLead) {
                        return false;
                    }

                    const country = String(this.leadEditForm.country || '').trim().toUpperCase();
                    const firstName = String(this.leadEditForm.firstName || '').trim();
                    const lastName = String(this.leadEditForm.lastName || '').trim();

                    this.selectedLead.name = [firstName, lastName].filter(Boolean).join(' ');
                    this.selectedLead.email = String(this.leadEditForm.email || '').trim();
                    this.selectedLead.phone = String(this.leadEditForm.phone || '').trim();
                    this.selectedLead.country = country || 'US';
                    this.selectedLead.countryFlag = this.leadCountryOption(this.selectedLead.country).flag;
                    this.selectedLead.state = this.leadEditForm.state || 'Idle';
                    this.selectedLead.timezone = this.leadEditForm.timezone || 'America / New York';
                    this.selectedLead.ageTooltip = this.formatLeadCreatedTooltip(this.leadEditForm.createdDate);
                    this.selectedLead.ageSeconds = Math.max(0, Math.floor((Date.now() - new Date(`${this.leadEditForm.createdDate}T12:00:00`).getTime()) / 1000));
                    this.selectedLead.ignoreNightRestrictions = Boolean(this.leadEditForm.ignoreNightRestrictions);
                    this.selectedLead.testUser = Boolean(this.leadEditForm.testUser);

                    return true;
                },
                openLeadDetailsEdit() {
                    this.fillLeadEditForm();
                    this.leadDetailsActionOpen = false;
                    this.leadDetailsEditing = true;

                    this.$nextTick(() => renderOutcraftIcons(this.$root));
                },
                cancelLeadDetailsEdit() {
                    this.leadDetailsEditing = false;
                    this.leadCreatedCalendarOpen = false;
                    this.leadCalendarMenuOpen = '';
                    this.leadSelectOpen = '';
                    this.leadDetailsActionOpen = false;
                },
                saveLeadDetailsEdit() {
                    this.applyLeadEditForm();
                    this.leadDetailsEditing = false;
                    this.leadCreatedCalendarOpen = false;
                    this.leadCalendarMenuOpen = '';
                    this.leadSelectOpen = '';
                    this.leadDetailsActionOpen = false;
                },
                tableLoaderSvg() {
                    return `
                        <svg width="36" height="36" viewBox="0 0 81 81" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                            <path
                                d="M80.3496 39.8037C68.0016 41.2293 57.4603 38.4865 49.9746 31.5244C43.143 25.1706 39.5255 15.9202 38.8936 5H38.5176C37.8984 15.0157 35.4644 23.4734 29.8252 29.5928L29.8232 29.5938C24.1043 35.7951 15.7265 38.8902 5 39.7998V40.2344C15.3642 41.1198 23.7009 44.0757 29.4883 50.1709C35.2541 56.229 37.868 64.7245 38.5156 75.0342H38.8896C39.1999 69.3958 40.2952 63.3893 42.8145 57.9854L43.042 57.5078C45.0487 53.3723 47.9462 49.563 52 46.6694"
                                stroke="#000000"
                                stroke-width="10"
                                fill="none"
                                pathLength="1"
                                class="outcraft-loader-draw"
                            />
                        </svg>
                    `;
                },
                openLeadDetails(row, updateUrl = true) {
                    this.showLoader(520);
                    this.leadDetailReturnContext = {
                        activeNav: this.activeNav,
                        activeTab: this.activeTab,
                        activeCampaignPageTab: this.activeCampaignPageTab,
                    };
                    this.selectedLead = row;
                    this.leadDetailOpen = true;
                    this.leadDetailsEditing = false;
                    this.leadDetailsActionOpen = false;
                    this.campaignRunsActionOpen = false;
                    this.searchOpen = false;
                    this.presetOpen = false;
                    this.campaignOpen = false;

                    if (updateUrl) {
                        this.syncUrl();
                    }

                    this.$nextTick(() => {
                        const container = this.$root.querySelector('main');

                        if (container) {
                            container.scrollTop = 0;
                        }
                    });
                },
                leadDetailBackLabel() {
                    if (this.leadDetailReturnContext.activeNav !== 'Leads') {
                        return this.leadDetailReturnContext.activeNav || 'Leads';
                    }

                    const tab = this.tabs.find((item) => item.label === this.leadDetailReturnContext.activeTab);

                    return tab?.displayLabel || tab?.label || 'Leads';
                },
                backFromLeadDetails(updateUrl = true) {
                    this.showLoader();
                    this.leadDetailOpen = false;
                    this.activeNav = this.leadDetailReturnContext.activeNav || 'Leads';
                    this.activeTab = this.leadDetailReturnContext.activeTab || 'Leads';
                    this.activeCampaignPageTab = this.leadDetailReturnContext.activeCampaignPageTab || 'Campaigns';
                    this.selectedLead = null;
                    this.leadDetailsEditing = false;
                    this.leadDetailsActionOpen = false;
                    this.campaignRunsActionOpen = false;

                    if (updateUrl) {
                        this.syncUrl();
                    }
                },
                selectedLeadNameParts() {
                    const name = String(this.selectedLead?.name || 'Billie Ruhl').trim();
                    const parts = name.split(/\s+/).filter(Boolean);

                    if (parts.length === 0) {
                        return ['Billie', 'Ruhl'];
                    }

                    if (parts.length === 1) {
                        return [parts[0], ''];
                    }

                    return [parts[0], parts.slice(1).join(' ')];
                },
                leadFirstName() {
                    return this.selectedLeadNameParts()[0];
                },
                leadLastName() {
                    return this.selectedLeadNameParts()[1];
                },
                leadAddedAge() {
                    return this.leadAge(this.selectedLead || { age: '4mo', ageSeconds: 10368000 });
                },
                leadCreatedDate() {
                    const value = String(this.selectedLead?.ageTooltip || '25, April, 2026 18:56').trim();
                    const match = value.match(/^(\d{1,2}),\s+([A-Za-z]+),\s+(\d{4})/);

                    if (!match) {
                        return value;
                    }

                    return `${match[2]} ${match[1]}, ${match[3]}`;
                },
                leadCampaignRows() {
                    return [
                        {
                            campaign: this.selectedLead?.campaignName || 'Abandoned Cart',
                            status: 'Completed',
                            firstInteraction: 'No Response',
                            followUp: '',
                            created: this.leadAddedAge(),
                            price: '$0.042',
                        },
                        {
                            campaign: 'Web Support',
                            status: 'Completed',
                            firstInteraction: 'No Response',
                            followUp: '',
                            created: this.leadAddedAge(),
                            price: '$0.042',
                        },
                    ];
                },
                resolvedLeadInteractions() {
                    const campaignName = this.selectedLead?.campaignName || this.campaign || 'Abandoned Cart';

                    return this.leadInteractions.map((interaction) => ({
                        ...interaction,
                        campaign: interaction.campaign || campaignName,
                    }));
                },
                currentSearchableColumns() {
                    if (this.activeTab === 'Leads') {
                        return this.leadSearchableColumns;
                    }

                    if (this.activeTab === 'Campaigns' || this.activeTab === 'Lead Campaigns') {
                        return this.campaignSearchableColumns;
                    }

                    if (this.activeTab === 'Handoffs') {
                        return this.handoffSearchableColumns;
                    }

                    return this.searchableColumns;
                },
                searchableValues(row, column) {
                    const key = {
                        Campaign: 'campaignName',
                        Status: 'campaignStatus',
                        'First Interaction': 'firstInteraction',
                        'Follow Up': 'followUp',
                    }[column] || column.toLowerCase();
                    const value = String(row[key] || '').trim();

                    if (!value) {
                        return [];
                    }

                    if (column === 'Name') {
                        return [...new Set([
                            value,
                            ...value.split(' ').filter((part) => part.length > 1),
                        ])];
                    }

                    return [value];
                },
                matchesSearch(value, term) {
                    const normalizedValue = String(value).toLowerCase();
                    const normalizedTerm = String(term).toLowerCase();

                    if (normalizedValue.includes(normalizedTerm)) {
                        return true;
                    }

                    const valueDigits = normalizedValue.replace(/\D/g, '');
                    const termDigits = normalizedTerm.replace(/\D/g, '');
                    const termLooksLikePhone = /^[\d\s()+.-]+$/.test(normalizedTerm);

                    return termLooksLikePhone && termDigits.length >= 3 && valueDigits.includes(termDigits);
                },
                groupedSuggestions() {
                    const term = this.query.toLowerCase().trim();
                    const groups = [];
                    const delayedColumns = ['Name', 'Phone', 'Lead', 'Email'];
                    const matchingDelayedColumns = delayedColumns.filter((column) => column.toLowerCase().includes(term));
                    const searchableColumns = this.currentSearchableColumns();
                    const columns = term
                        ? [
                            ...matchingDelayedColumns,
                            ...searchableColumns.filter((column) => !delayedColumns.includes(column)),
                            ...delayedColumns.filter((column) => searchableColumns.includes(column) && !matchingDelayedColumns.includes(column)),
                        ]
                        : searchableColumns;

                    columns.forEach((column) => {
                        if (!term && delayedColumns.includes(column)) {
                            return;
                        }

                        const values = [...new Set(this.rows.flatMap((row) => this.searchableValues(row, column)))]
                            .filter((value) => !this.filters.includes(value))
                            .filter((value) => !term || this.matchesSearch(value, term) || column.toLowerCase().includes(term))
                            .slice(0, 6);

                        if (values.length) {
                            groups.push({ column, values });
                        }
                    });

                    return groups;
                },
                addFirstSuggestion() {
                    const group = this.groupedSuggestions()[0];

                    if (group?.values?.[0]) {
                        this.addFilter(group.values[0]);
                    }
                },
                addFilter(value) {
                    this.showLoader(3000);

                    if (!this.filters.includes(value)) {
                        this.filters.push(value);
                    }

                    this.page = 1;
                    this.query = '';
                    this.searchOpen = false;
                },
                removeFilter(value) {
                    this.showLoader(3000);
                    this.filters = this.filters.filter((filter) => filter !== value);
                    this.selectedPresetName = 'Filter Presets';
                    this.page = 1;
                },
                applyPreset(preset) {
                    this.showLoader(3000);
                    this.filters = [...preset.filters];
                    this.selectedPresetName = preset.name;
                    this.searchOpen = false;
                    this.presetOpen = false;
                    this.page = 1;
                },
                deletePreset(preset) {
                    this.presets = this.presets.filter((item) => item.name !== preset.name);

                    if (this.selectedPresetName === preset.name) {
                        this.selectedPresetName = 'Filter Presets';
                    }
                },
                clearFilters() {
                    this.showLoader(3000);
                    this.filters = [];
                    this.selectedPresetName = 'Filter Presets';
                    this.searchOpen = false;
                    this.presetOpen = false;
                    this.page = 1;
                },
                clearSearchTags() {
                    this.showLoader(3000);
                    this.filters = [];
                    this.selectedPresetName = 'Filter Presets';
                    this.query = '';
                    this.searchOpen = false;
                    this.page = 1;
                },
                savePreset() {
                    if (this.filters.length === 0) {
                        return;
                    }

                    this.showLoader(3000);
                    const name = this.filters.join(' ');

                    this.presets.unshift({
                        name,
                        filters: [...this.filters],
                    });

                    this.selectedPresetName = name;
                },
                toggleAgeSort() {
                    this.showLoader(300);
                    this.ageSortDirection = this.ageSortDirection === 'asc' ? 'desc' : 'asc';
                    this.page = 1;
                },
                filteredRows() {
                    const rows = this.rows.filter((row) => {
                        if (this.campaign !== 'All Campaigns' && row.campaignName !== this.campaign) {
                            return false;
                        }

                        return this.filters.every((filter) => Object.values(row).some((value) => this.matchesSearch(value, filter)));
                    });

                    return rows.sort((first, second) => {
                        const direction = this.ageSortDirection === 'asc' ? 1 : -1;

                        return (Number(first.ageSeconds) - Number(second.ageSeconds)) * direction;
                    });
                },
                paginatedRows() {
                    const start = (this.page - 1) * this.perPage;

                    return this.filteredRows().slice(start, start + this.perPage);
                },
                loadingRows() {
                    return this.isLoading ? [] : this.paginatedRows();
                },
                totalPages() {
                    return Math.max(1, Math.ceil(this.filteredRows().length / this.perPage));
                },
                paginationSummary() {
                    const total = this.filteredRows().length;

                    if (total === 0) {
                        return 'Showing 0 results';
                    }

                    const start = (this.page - 1) * this.perPage + 1;
                    const end = Math.min(total, this.page * this.perPage);

                    return `Showing ${start} to ${end} of ${total} results`;
                },
                visiblePageNumbers() {
                    const total = this.totalPages();
                    const current = Number(this.page);

                    if (total <= 7) {
                        return Array.from({ length: total }, (_, index) => index + 1);
                    }

                    if (current <= 4) {
                        return [1, 2, 3, '...', total - 2, total - 1, total];
                    }

                    if (current >= total - 3) {
                        return [1, 2, 3, '...', total - 2, total - 1, total];
                    }

                    return [1, '...', current - 1, current, current + 1, '...', total];
                },
                shortEmail(email) {
                    return email.length > 18 ? email.slice(0, 18) + '...' : email;
                },
                shortLeadEmail(email) {
                    return email.length > 27 ? email.slice(0, 27) + '...' : email;
                },
                campaignLeadName(row) {
                    return row.name || 'Customer';
                },
                campaignLeadFirstName(row) {
                    return this.campaignLeadName(row).split(/\s+/).filter(Boolean)[0] || 'Customer';
                },
                campaignLeadLastName(row) {
                    const parts = this.campaignLeadName(row).split(/\s+/).filter(Boolean);

                    return parts.length > 1 ? parts.slice(1).join(' ') : 'Lead';
                },
                leadAge(row) {
                    return this.relativeAge(row);
                },
                campaignAge(row) {
                    return this.relativeAge(row);
                },
                relativeAge(row) {
                    const seconds = Math.max(0, Math.floor(Number(row?.ageSeconds || 0)));
                    const units = [
                        ['year', 31536000],
                        ['month', 2592000],
                        ['day', 86400],
                        ['hour', 3600],
                        ['minute', 60],
                        ['second', 1],
                    ];
                    const [unit, unitSeconds] = units.find(([, value]) => seconds >= value) || ['second', 1];
                    const count = Math.max(1, Math.floor(seconds / unitSeconds));

                    return `${count} ${unit}${count === 1 ? '' : 's'} ago`;
                },
                leadStateClass(value) {
                    if (value === 'Review Required') {
                        return 'bg-amber-50 text-amber-700 ring-amber-600/20';
                    }

                    return 'bg-gray-50 text-gray-600 ring-gray-500/10';
                },
                campaignBadgeClass(value) {
                    if (['Completed', 'Positive'].includes(value)) {
                        return 'bg-green-50 text-green-700 ring-green-600/20';
                    }

                    if (value === 'Unreachable') {
                        return 'bg-red-50 text-red-700 ring-red-600/20';
                    }

                    if (value === 'Ghosted') {
                        return 'bg-amber-50 text-amber-700 ring-amber-600/20';
                    }

                    return 'bg-gray-50 text-gray-600 ring-gray-500/10';
                },
                campaignPillClass(value) {
                    if (['Completed', 'Positive'].includes(value)) {
                        return 'bg-green-50 text-green-700 ring-green-600/20';
                    }

                    if (value === 'Unreachable') {
                        return 'bg-red-50 text-red-700 ring-red-600/20';
                    }

                    if (value === 'Ghosted') {
                        return 'bg-amber-50 text-amber-700 ring-amber-600/20';
                    }

                    return 'bg-gray-50 text-gray-600 ring-gray-500/10';
                },
                outcomeIcon(value) {
                    return {
                        'Engaged': 'call',
                        'Delivered': 'chat_bubble',
                        'Failed': 'assignment_late',
                        'No Response': 'schedule',
                    }[value] || '';
                },
                pillClass(value) {
                    if (['Positive', 'Engaged', 'Delivered'].includes(value)) {
                        return 'bg-green-50 text-green-700 ring-green-600/20';
                    }

                    if (value === 'Unreachable') {
                        return 'bg-green-50 text-green-700 ring-green-600/20';
                    }

                    if (['Escalated', 'Review Required'].includes(value)) {
                        return 'bg-amber-50 text-amber-700 ring-amber-600/20';
                    }

                    if (value === 'Failed') {
                        return 'bg-red-50 text-red-700 ring-red-600/20';
                    }

                    return 'bg-gray-50 text-gray-600 ring-gray-500/10';
                },
            };
        }
    </script>
</div>
BLADE;
    }
}
