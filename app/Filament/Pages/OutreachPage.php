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
        $interactionResults = ['No Response', 'Unreachable', 'No Decission'];
        $followUpResults = ['No Response', 'Positive', 'Positive', 'Ghosted'];
        $allChannels = ['Email', 'Call', 'SMS', 'WhatsApp'];
        $emailChannels = ['Email', 'WhatsApp'];
        $phoneChannels = ['Call', 'SMS', 'WhatsApp'];
        $contents = ['View', '0:19', '0:25', '0:35', '0:48', '1:06', '1:31', '2:14', ''];
        $directions = ['Outbound', 'Inbound'];
        $outcomes = ['No Response', 'Engaged', 'Delivered', 'Failed'];
        $results = ['Positive', 'Negative', 'No decision', 'No response', 'Unreachable', 'Escalated', 'Closed manually', 'Closed automatically', 'Review required', 'Failed'];
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
    class="outcraft-page fixed inset-0 z-50 overflow-hidden bg-white text-[#1f2024]"
    style="font-family: 'Inter Variable', Inter, ui-sans-serif, system-ui, sans-serif;"
>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@20,400,0,0&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        [x-cloak] { display: none !important; }
        .material-symbols-rounded {
            font-family: 'Material Symbols Rounded';
            font-weight: normal;
            font-style: normal;
            font-size: 20px;
            line-height: 1;
            letter-spacing: normal;
            text-transform: none;
            display: inline-flex;
            white-space: nowrap;
            direction: ltr;
            font-feature-settings: 'liga';
            -webkit-font-feature-settings: 'liga';
            -webkit-font-smoothing: antialiased;
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 20;
        }
        .filter-scroll {
            scrollbar-color: #d1d5db transparent;
            scrollbar-width: thin;
        }
        .filter-scroll::-webkit-scrollbar {
            width: 8px;
        }
        .filter-scroll::-webkit-scrollbar-track {
            background: transparent;
        }
        .filter-scroll::-webkit-scrollbar-thumb {
            background-color: #d1d5db;
            border-radius: 9999px;
            border: 2px solid #ffffff;
        }
        .filter-scroll::-webkit-scrollbar-thumb:hover {
            background-color: #9ca3af;
        }
    </style>

    <aside
        class="absolute inset-y-0 left-0 flex flex-col border-r border-gray-200 bg-white transition-all duration-300"
        :class="sidebarOpen ? 'w-[218px]' : 'w-16'"
    >
        <div class="flex h-[70px] items-center px-5">
            <div class="overflow-hidden transition-all duration-300" :class="sidebarOpen ? 'w-[123px]' : 'w-8'">
                <svg width="123" height="25" viewBox="0 0 123 25" fill="none" xmlns="http://www.w3.org/2000/svg" class="max-w-none">
                    <path d="M23.9939 11.156V12.8745V13.4192C19.3279 13.8776 13.7301 12.2105 11.5521 7.79911C10.947 8.85776 10.4093 9.60807 9.74726 10.2474C9.0578 10.9134 8.25871 11.4335 7.12648 12.0337C8.25238 12.6319 9.05147 13.152 9.73882 13.8139C10.4325 14.4841 10.9891 15.2775 11.6364 16.4246C12.3027 15.1994 12.9563 14.2045 14.2867 13.1767C15.0499 13.6371 16.1505 14.188 17.578 14.6197L17.1057 14.8849C15.7689 15.6352 14.8496 16.7679 14.2403 18.0753C13.4707 19.7259 13.1882 21.6562 13.1713 23.4713L13.165 24.0716H12.5515H10.7382H10.1373L10.1204 23.4795C10.0277 20.1412 9.30027 17.7237 7.78009 16.1265C6.26835 14.5334 3.92378 13.7111 0.592468 13.5467L0 13.5179V12.9444V12.9403V11.1334V11.1272V10.5537L0.592468 10.5249C4.03764 10.3563 6.3801 9.4909 7.86443 7.88133C9.3572 6.26149 10.0298 3.84611 10.1204 0.592025L10.1373 0H10.7382H12.5515H13.165L13.1713 0.600248C13.2325 7.39209 17.1921 11.2629 23.9939 10.4776V11.158V11.156Z" fill="black"/>
                    <path d="M47.8118 11.9997C47.8118 17.7007 43.8495 21.5638 38.0021 21.5638C32.1547 21.5638 28.1924 17.7026 28.1924 11.9997C28.1924 6.29677 32.1547 2.43555 38.0041 2.43555C43.8534 2.43555 47.8138 6.29868 47.8138 11.9997H47.8118ZM31.3191 11.9997C31.3191 16.3619 34.0947 18.9093 38.0021 18.9093C41.9095 18.9093 44.7126 16.36 44.7126 11.9997C44.7126 7.6393 41.937 5.06324 38.0021 5.06324C34.0672 5.06324 31.3191 7.63739 31.3191 11.9997Z" fill="black"/>
                    <path d="M59.6975 8.0332H62.528V21.1698H59.6975V19.5671C58.701 20.7758 57.2181 21.5637 55.1702 21.5637C51.4786 21.5637 49.1875 18.9628 49.1875 15.4688V8.0332H52.018V15.5204C52.018 17.6757 53.1498 19.068 55.4135 19.068C57.8929 19.068 59.6994 17.4137 59.6994 14.6024V8.0332H59.6975Z" fill="black"/>
                    <path d="M69.828 19.1192V21.6149C66.5404 21.7985 64.4121 20.3546 64.4121 16.9122V2.77734H67.2426V8.03274H69.8299V10.5285H67.2426V17.0174C67.2426 18.9623 68.4274 19.1192 69.8299 19.1192H69.828Z" fill="black"/>
                    <path d="M81.9833 16.0715H84.7864C84.3823 19.4087 81.5263 21.5621 77.7797 21.5621C73.5212 21.5621 70.6377 18.7509 70.6377 14.5989C70.6377 10.447 73.5212 7.63574 77.7797 7.63574C81.4988 7.63574 84.3548 9.76429 84.7864 13.0747H81.9558C81.4713 11.2082 79.8805 10.1315 77.7797 10.1315C75.165 10.1315 73.3329 11.7877 73.3329 14.5989C73.3329 17.4102 75.165 19.0645 77.7797 19.0645C79.908 19.0645 81.4988 17.9878 81.9833 16.0696V16.0715Z" fill="black"/>
                    <path d="M86.4023 21.1696V8.03303H89.2329V9.00455C90.3647 7.76912 92.0084 7.29674 94.1112 7.82266L93.6267 10.1864C90.5549 9.68729 89.2348 11.4219 89.2348 14.6004V21.1696H86.4043H86.4023Z" fill="black"/>
                    <path d="M105.158 19.6975C104.134 20.8278 102.598 21.5621 100.523 21.5621C96.4528 21.5621 93.5693 18.7509 93.5693 14.5989C93.5693 10.447 96.4528 7.63574 100.523 7.63574C102.598 7.63574 104.134 8.37203 105.158 9.50037V8.02971H107.989V21.1663H105.158V19.6956V19.6975ZM100.711 19.0683C103.352 19.0683 105.158 17.4141 105.158 14.6028C105.158 11.7915 103.354 10.1353 100.711 10.1353C98.0691 10.1353 96.2645 11.7915 96.2645 14.6028C96.2645 17.4141 98.0966 19.0683 100.711 19.0683Z" fill="black"/>
                    <path d="M114.401 4.95806C113.621 4.95806 112.705 5.27361 112.705 6.77105V8.37368H115.292V10.8694H112.705V21.1679H109.874V6.79783C109.874 4.40727 111.329 2.43555 113.97 2.43555C114.509 2.43555 115.641 2.51396 116.637 2.98824L115.586 5.14165C115.155 5.00969 114.723 4.95806 114.401 4.95806Z" fill="black"/>
                    <path d="M122.998 19.1192V21.6149C119.71 21.7985 117.582 20.3546 117.582 16.9122V2.77734H120.413V8.03274H123V10.5285H120.413V17.0174C120.413 18.9623 121.597 19.1192 123 19.1192H122.998Z" fill="black"/>
                </svg>
            </div>
        </div>

        <nav class="space-y-3 pt-4 text-[15px] font-medium text-gray-600" :class="sidebarOpen ? 'px-5' : 'px-3'">
            <template x-for="item in nav" :key="item.label">
                <button class="flex h-10 w-full items-center whitespace-nowrap rounded-xl text-left transition hover:bg-gray-50 hover:text-gray-950" :class="sidebarOpen ? 'gap-4 px-3' : 'justify-center px-0'" :title="item.label">
                    <span class="material-symbols-rounded shrink-0 text-gray-950" x-text="item.icon"></span>
                    <span x-show="sidebarOpen" x-transition.opacity x-text="item.label"></span>
                </button>
            </template>
        </nav>

        <div class="mt-auto space-y-3 pb-6 text-[15px] font-medium text-gray-600" :class="sidebarOpen ? 'px-5' : 'px-3'">
            <button type="button" x-on:click="sidebarOpen = ! sidebarOpen" class="flex h-10 w-full items-center whitespace-nowrap rounded-xl text-left transition hover:bg-gray-50 hover:text-gray-950" :class="sidebarOpen ? 'gap-4 px-3' : 'justify-center px-0'" title="Expand">
                <span class="material-symbols-rounded shrink-0 text-gray-950" x-text="sidebarOpen ? 'dock_to_left' : 'dock_to_right'"></span>
                <span x-show="sidebarOpen" x-transition.opacity>Expand</span>
            </button>
        </div>
    </aside>

    <main class="h-full overflow-auto transition-all duration-300" :class="sidebarOpen ? 'ml-[218px]' : 'ml-16'">
        <header class="relative flex h-[86px] items-center px-6">
            <div class="flex items-center gap-5 text-[15px] font-medium">
                <span class="text-gray-500">Operations</span>
                <span class="material-symbols-rounded text-gray-400">chevron_right</span>
                <span class="text-gray-950" x-text="activeTab"></span>
            </div>

            <div class="absolute left-1/2 top-6 w-[600px] -translate-x-1/2">
                <div class="relative" x-on:click.outside="campaignOpen = false">
                    <button
                        type="button"
                        x-on:click="campaignOpen = ! campaignOpen"
                        class="flex h-10 w-full items-center justify-between rounded-xl border border-gray-200 bg-white px-4 text-left text-[15px] text-gray-900 shadow-sm outline-none transition hover:bg-gray-50 focus:border-blue-400 focus:ring-2 focus:ring-blue-200"
                    >
                        <span x-text="campaign"></span>
                        <span class="material-symbols-rounded text-gray-600">keyboard_arrow_down</span>
                    </button>
                    <div
                        x-cloak
                        x-show="campaignOpen"
                        x-transition
                        class="absolute left-0 right-0 top-12 z-40 overflow-hidden rounded-xl border border-gray-200 bg-white p-1 text-[15px] text-gray-900 shadow-lg"
                    >
                        <template x-for="option in campaigns" :key="option">
                            <button
                                type="button"
                                x-on:click="campaign = option; campaignOpen = false; page = 1"
                                class="flex w-full items-center justify-between rounded-lg px-3 py-2 text-left hover:bg-gray-50"
                            >
                                <span x-text="option"></span>
                                <span x-show="campaign === option" class="material-symbols-rounded text-blue-500">check</span>
                            </button>
                        </template>
                    </div>
                </div>
            </div>

            <div class="ml-auto flex items-center gap-3">
                <button class="relative flex h-10 items-center justify-center rounded-xl px-3 text-gray-700 transition hover:bg-gray-50" title="Notifications">
                    <span class="material-symbols-rounded">notifications</span>
                    <span class="absolute right-0.5 top-0.5 flex min-w-4 items-center justify-center rounded-full bg-gray-900 px-1 text-[10px] font-semibold leading-4 text-white">23</span>
                </button>
                <button class="flex h-10 items-center gap-2 rounded-xl px-3 text-[14px] font-medium text-gray-700 transition hover:bg-gray-50" title="Pulsetto.tech">
                    <span class="material-symbols-rounded">account_circle</span>
                    <span>Pulsetto.tech</span>
                    <span class="material-symbols-rounded text-gray-500">keyboard_arrow_down</span>
                </button>
            </div>
        </header>

        <section class="mx-6 rounded-2xl border border-gray-200 bg-white p-2 shadow-sm">
            <div class="flex h-11 items-center gap-2 text-[15px] font-medium text-gray-600">
                <template x-for="tab in tabs" :key="tab.label">
                    <button
                        type="button"
                        x-on:click="setActiveTab(tab.label)"
                        class="flex h-9 items-center gap-2 rounded-xl px-4 transition"
                        :class="activeTab === tab.label ? 'bg-[#26262b] text-white shadow' : 'hover:bg-gray-50'"
                    >
                        <span class="material-symbols-rounded" x-text="tab.icon"></span>
                        <span x-text="tab.label"></span>
                    </button>
                </template>
            </div>
        </section>

        <section x-cloak x-show="activeTab === 'Leads'" class="mx-6 mb-6 mt-5 overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">
            <div class="grid min-h-[92px] grid-cols-[250px_1fr_230px] items-start gap-6 p-6">
                <div>
                    <h1 class="text-[19px] font-semibold tracking-normal">Leads</h1>
                    <p class="mt-1 text-[15px] text-gray-500">Browse and manage all your leads</p>
                </div>

                <div class="relative" x-on:click.outside="searchOpen = false">
                    <div class="rounded-xl border border-gray-200 bg-white shadow-sm">
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
                        <div x-show="filters.length > 0" x-transition class="flex min-h-10 items-center gap-2 border-t border-gray-200 px-4">
                            <template x-for="tag in filters" :key="tag">
                                <button x-on:click="removeFilter(tag)" class="inline-flex items-center gap-1 rounded-lg border border-gray-200 bg-gray-50 px-2 py-1 text-[15px] leading-none text-gray-600">
                                    <span x-text="tag"></span>
                                    <span class="text-gray-500">×</span>
                                </button>
                            </template>
                            <div class="ml-auto flex items-center gap-4">
                                <button class="text-[14px] font-semibold text-gray-500 hover:text-gray-900" x-on:click="clearSearchTags()">Clear</button>
                                <button class="text-[14px] font-semibold text-gray-600 hover:text-gray-900" x-on:click="savePreset()">Save preset</button>
                            </div>
                        </div>
                    </div>

                    <div x-cloak x-show="searchOpen" x-transition class="absolute left-0 right-0 top-0 z-30 rounded-xl border border-gray-200 bg-white p-5 shadow-lg">
                        <input x-model="query" x-ref="leadsOverlayInput" x-init="$watch('searchOpen', value => value && activeTab === 'Leads' && $nextTick(() => $refs.leadsOverlayInput.focus()))" class="w-full border-0 bg-transparent text-[17px] outline-none ring-0 focus:ring-0" placeholder="Filter anything">
                        <div class="filter-scroll mt-4 max-h-[215px] space-y-1 overflow-y-auto pr-2">
                            <template x-for="group in groupedSuggestions()" :key="group.column">
                                <div>
                                    <div class="px-1 py-2 text-[15px] font-semibold" x-text="group.column"></div>
                                    <template x-for="value in group.values" :key="group.column + value">
                                        <button x-on:click="addFilter(value)" class="block w-full rounded-lg px-1 py-2 text-left text-[15px] hover:bg-gray-50" x-text="value"></button>
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
                        class="flex h-10 min-w-[175px] items-center justify-between gap-3 rounded-xl border border-gray-200 bg-white px-4 text-left text-[15px] text-gray-900 shadow-sm outline-none transition hover:bg-gray-50 focus:border-blue-400 focus:ring-2 focus:ring-blue-200"
                    >
                        <span x-text="selectedPresetName"></span>
                        <span class="material-symbols-rounded text-gray-600">keyboard_arrow_down</span>
                    </button>
                    <div x-cloak x-show="presetOpen" x-transition class="absolute right-0 top-12 z-40 w-[230px] overflow-hidden rounded-xl border border-gray-200 bg-white p-1 text-[15px] text-gray-900 shadow-lg">
                        <button type="button" x-on:click="clearFilters()" class="block w-full rounded-lg px-3 py-2 text-left font-semibold hover:bg-gray-50">Clear filters</button>
                        <template x-for="preset in presets" :key="preset.name">
                            <div class="group flex items-center rounded-lg hover:bg-gray-50">
                                <button type="button" x-on:click="applyPreset(preset)" class="flex min-w-0 flex-1 items-center justify-between px-3 py-2 text-left">
                                    <span class="truncate" x-text="preset.name"></span>
                                    <span x-show="selectedPresetName === preset.name" class="material-symbols-rounded ml-3 shrink-0 text-blue-500">check</span>
                                </button>
                                <button type="button" x-on:click.stop="deletePreset(preset)" class="mr-2 flex size-8 shrink-0 items-center justify-center rounded-lg text-gray-400 opacity-0 transition hover:bg-red-50 hover:text-red-600 group-hover:opacity-100" :aria-label="`Delete ${preset.name}`">
                                    <span class="material-symbols-rounded !text-[18px]">delete</span>
                                </button>
                            </div>
                        </template>
                    </div>
                </div>
            </div>

            <div class="flex min-h-[74px] items-center justify-end gap-3 border-y border-gray-200 bg-white px-6">
                <button type="button" x-on:click="addFilter('Review Required')" class="inline-flex h-9 items-center gap-2 rounded-lg border border-gray-200 bg-white px-3 text-[14px] font-semibold text-gray-800 shadow-sm transition hover:bg-gray-50">
                    <span class="material-symbols-rounded !text-[18px] text-gray-500">manage_search</span>
                    Review Required
                </button>
                <button type="button" class="inline-flex h-9 items-center gap-2 rounded-lg border border-gray-200 bg-white px-3 text-[14px] font-semibold text-gray-800 shadow-sm transition hover:bg-gray-50">
                    <span class="material-symbols-rounded !text-[18px] text-gray-500">upload</span>
                    Import CSV
                </button>
                <button type="button" class="inline-flex h-9 items-center gap-2 rounded-lg border border-gray-200 bg-white px-3 text-[14px] font-semibold text-gray-800 shadow-sm transition hover:bg-gray-50">
                    <span class="material-symbols-rounded !text-[18px] text-gray-500">add</span>
                    Add Lead
                </button>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full min-w-[1080px] table-fixed border-collapse text-[15px]">
                    <thead>
                        <tr class="border-b border-gray-200 bg-gray-50 text-left text-[14px] font-semibold text-gray-950">
                            <th class="w-[240px] px-6 py-4">Name</th>
                            <th class="w-[240px] px-4 py-4">Phone</th>
                            <th class="w-[240px] px-4 py-4">Email</th>
                            <th class="w-[90px] px-4 py-4">Country</th>
                            <th class="w-[160px] px-4 py-4">Timezone</th>
                            <th class="w-[90px] px-4 py-4">State</th>
                            <th class="w-[65px] px-4 py-4">Age</th>
                            <th class="w-[70px] px-4 py-4"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <template x-for="row in paginatedRows()" :key="'lead-' + row.name + row.phone + row.email + row.age">
                            <tr class="border-b border-gray-200">
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
                                <td class="px-4 py-4" x-text="row.timezone"></td>
                                <td class="px-4 py-4">
                                    <span class="inline-flex rounded-lg border border-gray-200 bg-gray-50 px-2 py-1 text-[13px] leading-none text-gray-600" x-text="row.state"></span>
                                </td>
                                <td class="px-4 py-4">
                                    <span class="group relative inline-flex">
                                        <span x-text="leadAge(row)"></span>
                                        <span class="pointer-events-none absolute bottom-full left-1/2 z-50 mb-2 -translate-x-1/2 translate-y-1 whitespace-nowrap rounded-lg bg-gray-900 px-3 py-2 text-xs font-medium text-white opacity-0 shadow-sm transition group-hover:translate-y-0 group-hover:opacity-100">
                                            <span x-text="row.ageTooltip"></span>
                                            <span class="absolute left-1/2 top-full size-2 -translate-x-1/2 -translate-y-1 rotate-45 bg-gray-900"></span>
                                        </span>
                                    </span>
                                </td>
                                <td class="cursor-pointer px-4 py-4 font-semibold text-gray-600">View</td>
                            </tr>
                        </template>
                        <tr x-show="filteredRows().length === 0">
                            <td colspan="8" class="px-8 py-16 text-center text-gray-500">No leads match these filters.</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="flex items-center justify-between gap-4 border-t border-gray-200 px-6 py-4 text-[14px] text-gray-600">
                <div class="flex items-center gap-3">
                    <span>Rows per page</span>
                    <select x-model.number="perPage" x-on:change="page = 1" class="h-9 rounded-lg border border-gray-200 bg-white px-3 text-[14px] text-gray-900 outline-none focus:border-blue-400 focus:ring-2 focus:ring-blue-200">
                        <template x-for="option in perPageOptions" :key="option">
                            <option :value="option" x-text="option"></option>
                        </template>
                    </select>
                </div>
                <div class="flex items-center gap-4">
                    <span x-text="paginationSummary()"></span>
                    <div class="flex items-center gap-1">
                        <button type="button" x-on:click="page = Math.max(1, page - 1)" :disabled="page === 1" class="flex size-9 items-center justify-center rounded-lg text-gray-700 transition hover:bg-gray-50 disabled:cursor-not-allowed disabled:opacity-40">
                            <span class="material-symbols-rounded">chevron_left</span>
                        </button>
                        <template x-for="pageNumber in visiblePageNumbers()" :key="pageNumber">
                            <button type="button" x-on:click="page = pageNumber" class="flex size-9 items-center justify-center rounded-lg text-gray-700 transition hover:bg-gray-50" :class="page === pageNumber ? 'bg-gray-100 font-semibold text-gray-950' : ''" x-text="pageNumber"></button>
                        </template>
                        <button type="button" x-on:click="page = Math.min(totalPages(), page + 1)" :disabled="page === totalPages()" class="flex size-9 items-center justify-center rounded-lg text-gray-700 transition hover:bg-gray-50 disabled:cursor-not-allowed disabled:opacity-40">
                            <span class="material-symbols-rounded">chevron_right</span>
                        </button>
                    </div>
                </div>
            </div>
        </section>

        <section x-cloak x-show="activeTab === 'Campaigns'" class="mx-6 mb-6 mt-5 overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">
            <div class="grid min-h-[112px] grid-cols-[250px_1fr_230px] items-start gap-6 p-6">
                <div>
                    <h1 class="text-[19px] font-semibold tracking-normal">Lead Campaigns</h1>
                    <p class="mt-1 max-w-[220px] text-[15px] leading-6 text-gray-500">Browse and manage lead campaigns for the selected campaign</p>
                </div>

                <div class="relative" x-on:click.outside="searchOpen = false">
                    <div class="rounded-xl border border-gray-200 bg-white shadow-sm">
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
                        <div x-show="filters.length > 0" x-transition class="flex min-h-10 items-center gap-2 border-t border-gray-200 px-4">
                            <template x-for="tag in filters" :key="tag">
                                <button x-on:click="removeFilter(tag)" class="inline-flex items-center gap-1 rounded-lg border border-gray-200 bg-gray-50 px-2 py-1 text-[15px] leading-none text-gray-600">
                                    <span x-text="tag"></span>
                                    <span class="text-gray-500">×</span>
                                </button>
                            </template>
                            <div class="ml-auto flex items-center gap-4">
                                <button class="text-[14px] font-semibold text-gray-500 hover:text-gray-900" x-on:click="clearSearchTags()">Clear</button>
                                <button class="text-[14px] font-semibold text-gray-600 hover:text-gray-900" x-on:click="savePreset()">Save preset</button>
                            </div>
                        </div>
                    </div>

                    <div x-cloak x-show="searchOpen" x-transition class="absolute left-0 right-0 top-0 z-30 rounded-xl border border-gray-200 bg-white p-5 shadow-lg">
                        <input x-model="query" x-ref="campaignsOverlayInput" x-init="$watch('searchOpen', value => value && activeTab === 'Campaigns' && $nextTick(() => $refs.campaignsOverlayInput.focus()))" class="w-full border-0 bg-transparent text-[17px] outline-none ring-0 focus:ring-0" placeholder="Filter anything">
                        <div class="filter-scroll mt-4 max-h-[215px] space-y-1 overflow-y-auto pr-2">
                            <template x-for="group in groupedSuggestions()" :key="group.column">
                                <div>
                                    <div class="px-1 py-2 text-[15px] font-semibold" x-text="group.column"></div>
                                    <template x-for="value in group.values" :key="group.column + value">
                                        <button x-on:click="addFilter(value)" class="block w-full rounded-lg px-1 py-2 text-left text-[15px] hover:bg-gray-50" x-text="value"></button>
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
                        class="flex h-10 min-w-[175px] items-center justify-between gap-3 rounded-xl border border-gray-200 bg-white px-4 text-left text-[15px] text-gray-900 shadow-sm outline-none transition hover:bg-gray-50 focus:border-blue-400 focus:ring-2 focus:ring-blue-200"
                    >
                        <span x-text="selectedPresetName"></span>
                        <span class="material-symbols-rounded text-gray-600">keyboard_arrow_down</span>
                    </button>
                    <div x-cloak x-show="presetOpen" x-transition class="absolute right-0 top-12 z-40 w-[230px] overflow-hidden rounded-xl border border-gray-200 bg-white p-1 text-[15px] text-gray-900 shadow-lg">
                        <button type="button" x-on:click="clearFilters()" class="block w-full rounded-lg px-3 py-2 text-left font-semibold hover:bg-gray-50">Clear filters</button>
                        <template x-for="preset in presets" :key="preset.name">
                            <div class="group flex items-center rounded-lg hover:bg-gray-50">
                                <button type="button" x-on:click="applyPreset(preset)" class="flex min-w-0 flex-1 items-center justify-between px-3 py-2 text-left">
                                    <span class="truncate" x-text="preset.name"></span>
                                    <span x-show="selectedPresetName === preset.name" class="material-symbols-rounded ml-3 shrink-0 text-blue-500">check</span>
                                </button>
                                <button type="button" x-on:click.stop="deletePreset(preset)" class="mr-2 flex size-8 shrink-0 items-center justify-center rounded-lg text-gray-400 opacity-0 transition hover:bg-red-50 hover:text-red-600 group-hover:opacity-100" :aria-label="`Delete ${preset.name}`">
                                    <span class="material-symbols-rounded !text-[18px]">delete</span>
                                </button>
                            </div>
                        </template>
                    </div>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full min-w-[1110px] table-fixed border-collapse text-[15px]">
                    <thead>
                        <tr class="border-y border-gray-200 bg-gray-50 text-left text-[14px] font-semibold text-gray-950">
                            <th class="w-[150px] px-6 py-4">Campaign</th>
                            <th class="w-[150px] px-4 py-4">Name</th>
                            <th class="w-[150px] px-4 py-4">Phone</th>
                            <th class="w-[150px] px-4 py-4">Email</th>
                            <th class="w-[120px] px-4 py-4">Status</th>
                            <th class="w-[140px] px-4 py-4">First Interaction</th>
                            <th class="w-[130px] px-4 py-4">Follow Up</th>
                            <th class="w-[65px] px-4 py-4">Age</th>
                            <th class="w-[55px] px-4 py-4"></th>
                            <th class="w-[55px] px-4 py-4"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <template x-for="row in paginatedRows()" :key="'campaign-' + row.campaignName + row.name + row.phone + row.email + row.age">
                            <tr class="border-b border-gray-200">
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
                                    <span class="inline-flex max-w-[104px] rounded-lg border px-2 py-1 text-[13px] leading-none" :class="campaignBadgeClass(row.campaignStatus)">
                                        <span class="truncate" x-text="row.campaignStatus"></span>
                                    </span>
                                </td>
                                <td class="px-4 py-4">
                                    <span class="inline-flex max-w-[116px] rounded-lg border px-2 py-1 text-[13px] leading-none" :class="campaignBadgeClass(row.firstInteraction)">
                                        <span class="truncate" x-text="row.firstInteraction"></span>
                                    </span>
                                </td>
                                <td class="px-4 py-4">
                                    <span class="inline-flex max-w-[110px] rounded-lg border px-2 py-1 text-[13px] leading-none" :class="campaignBadgeClass(row.followUp)">
                                        <span class="truncate" x-text="row.followUp"></span>
                                    </span>
                                </td>
                                <td class="px-4 py-4">
                                    <span class="group relative inline-flex">
                                        <span x-text="campaignAge(row)"></span>
                                        <span class="pointer-events-none absolute bottom-full left-1/2 z-50 mb-2 -translate-x-1/2 translate-y-1 whitespace-nowrap rounded-lg bg-gray-900 px-3 py-2 text-xs font-medium text-white opacity-0 shadow-sm transition group-hover:translate-y-0 group-hover:opacity-100">
                                            <span x-text="row.ageTooltip"></span>
                                            <span class="absolute left-1/2 top-full size-2 -translate-x-1/2 -translate-y-1 rotate-45 bg-gray-900"></span>
                                        </span>
                                    </span>
                                </td>
                                <td class="cursor-pointer px-4 py-4 font-semibold text-gray-600">Flow</td>
                                <td class="cursor-pointer px-4 py-4 font-semibold text-gray-600">View</td>
                            </tr>
                        </template>
                        <tr x-show="filteredRows().length === 0">
                            <td colspan="10" class="px-8 py-16 text-center text-gray-500">No lead campaign records match these filters.</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="flex items-center justify-between gap-4 border-t border-gray-200 px-6 py-4 text-[14px] text-gray-600">
                <div class="flex items-center gap-3">
                    <span>Rows per page</span>
                    <select x-model.number="perPage" x-on:change="page = 1" class="h-9 rounded-lg border border-gray-200 bg-white px-3 text-[14px] text-gray-900 outline-none focus:border-blue-400 focus:ring-2 focus:ring-blue-200">
                        <template x-for="option in perPageOptions" :key="option">
                            <option :value="option" x-text="option"></option>
                        </template>
                    </select>
                </div>
                <div class="flex items-center gap-4">
                    <span x-text="paginationSummary()"></span>
                    <div class="flex items-center gap-1">
                        <button type="button" x-on:click="page = Math.max(1, page - 1)" :disabled="page === 1" class="flex size-9 items-center justify-center rounded-lg text-gray-700 transition hover:bg-gray-50 disabled:cursor-not-allowed disabled:opacity-40">
                            <span class="material-symbols-rounded">chevron_left</span>
                        </button>
                        <template x-for="pageNumber in visiblePageNumbers()" :key="pageNumber">
                            <button type="button" x-on:click="page = pageNumber" class="flex size-9 items-center justify-center rounded-lg text-gray-700 transition hover:bg-gray-50" :class="page === pageNumber ? 'bg-gray-100 font-semibold text-gray-950' : ''" x-text="pageNumber"></button>
                        </template>
                        <button type="button" x-on:click="page = Math.min(totalPages(), page + 1)" :disabled="page === totalPages()" class="flex size-9 items-center justify-center rounded-lg text-gray-700 transition hover:bg-gray-50 disabled:cursor-not-allowed disabled:opacity-40">
                            <span class="material-symbols-rounded">chevron_right</span>
                        </button>
                    </div>
                </div>
            </div>
        </section>

        <section x-cloak x-show="activeTab === 'Handoffs'" class="mx-6 mb-6 mt-5 overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">
            <div class="grid min-h-[112px] grid-cols-[250px_1fr_230px] items-start gap-6 p-6">
                <div>
                    <h1 class="text-[19px] font-semibold tracking-normal">Handoff requests</h1>
                    <p class="mt-1 max-w-[230px] text-[15px] leading-6 text-gray-500">Leads that have requested a handoff from AI to a human support.</p>
                </div>

                <div class="relative" x-on:click.outside="searchOpen = false">
                    <div class="rounded-xl border border-gray-200 bg-white shadow-sm">
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
                        <div x-show="filters.length > 0" x-transition class="flex min-h-10 items-center gap-2 border-t border-gray-200 px-4">
                            <template x-for="tag in filters" :key="tag">
                                <button x-on:click="removeFilter(tag)" class="inline-flex items-center gap-1 rounded-lg border border-gray-200 bg-gray-50 px-2 py-1 text-[15px] leading-none text-gray-600">
                                    <span x-text="tag"></span>
                                    <span class="text-gray-500">×</span>
                                </button>
                            </template>
                            <div class="ml-auto flex items-center gap-4">
                                <button class="text-[14px] font-semibold text-gray-500 hover:text-gray-900" x-on:click="clearSearchTags()">Clear</button>
                                <button class="text-[14px] font-semibold text-gray-600 hover:text-gray-900" x-on:click="savePreset()">Save preset</button>
                            </div>
                        </div>
                    </div>

                    <div x-cloak x-show="searchOpen" x-transition class="absolute left-0 right-0 top-0 z-30 rounded-xl border border-gray-200 bg-white p-5 shadow-lg">
                        <input x-model="query" x-ref="handoffsOverlayInput" x-init="$watch('searchOpen', value => value && activeTab === 'Handoffs' && $nextTick(() => $refs.handoffsOverlayInput.focus()))" class="w-full border-0 bg-transparent text-[17px] outline-none ring-0 focus:ring-0" placeholder="Filter anything">
                        <div class="filter-scroll mt-4 max-h-[215px] space-y-1 overflow-y-auto pr-2">
                            <template x-for="group in groupedSuggestions()" :key="group.column">
                                <div>
                                    <div class="px-1 py-2 text-[15px] font-semibold" x-text="group.column"></div>
                                    <template x-for="value in group.values" :key="group.column + value">
                                        <button x-on:click="addFilter(value)" class="block w-full rounded-lg px-1 py-2 text-left text-[15px] hover:bg-gray-50" x-text="value"></button>
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
                        class="flex h-10 min-w-[175px] items-center justify-between gap-3 rounded-xl border border-gray-200 bg-white px-4 text-left text-[15px] text-gray-900 shadow-sm outline-none transition hover:bg-gray-50 focus:border-blue-400 focus:ring-2 focus:ring-blue-200"
                    >
                        <span x-text="selectedPresetName"></span>
                        <span class="material-symbols-rounded text-gray-600">keyboard_arrow_down</span>
                    </button>
                    <div x-cloak x-show="presetOpen" x-transition class="absolute right-0 top-12 z-40 w-[230px] overflow-hidden rounded-xl border border-gray-200 bg-white p-1 text-[15px] text-gray-900 shadow-lg">
                        <button type="button" x-on:click="clearFilters()" class="block w-full rounded-lg px-3 py-2 text-left font-semibold hover:bg-gray-50">Clear filters</button>
                        <template x-for="preset in presets" :key="preset.name">
                            <div class="group flex items-center rounded-lg hover:bg-gray-50">
                                <button type="button" x-on:click="applyPreset(preset)" class="flex min-w-0 flex-1 items-center justify-between px-3 py-2 text-left">
                                    <span class="truncate" x-text="preset.name"></span>
                                    <span x-show="selectedPresetName === preset.name" class="material-symbols-rounded ml-3 shrink-0 text-blue-500">check</span>
                                </button>
                                <button type="button" x-on:click.stop="deletePreset(preset)" class="mr-2 flex size-8 shrink-0 items-center justify-center rounded-lg text-gray-400 opacity-0 transition hover:bg-red-50 hover:text-red-600 group-hover:opacity-100" :aria-label="`Delete ${preset.name}`">
                                    <span class="material-symbols-rounded !text-[18px]">delete</span>
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
                            <th class="w-[70px] px-4 py-4">Age</th>
                            <th class="w-[70px] px-4 py-4"></th>
                            <th class="w-[80px] px-4 py-4"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <template x-for="row in paginatedRows()" :key="'handoff-' + row.name + row.phone + row.email + row.age">
                            <tr class="border-b border-gray-200">
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
                                <td class="px-4 py-4" x-text="row.timezone"></td>
                                <td class="px-4 py-4">
                                    <span class="group relative inline-flex">
                                        <span x-text="leadAge(row)"></span>
                                        <span class="pointer-events-none absolute bottom-full left-1/2 z-50 mb-2 -translate-x-1/2 translate-y-1 whitespace-nowrap rounded-lg bg-gray-900 px-3 py-2 text-xs font-medium text-white opacity-0 shadow-sm transition group-hover:translate-y-0 group-hover:opacity-100">
                                            <span x-text="row.ageTooltip"></span>
                                            <span class="absolute left-1/2 top-full size-2 -translate-x-1/2 -translate-y-1 rotate-45 bg-gray-900"></span>
                                        </span>
                                    </span>
                                </td>
                                <td class="cursor-pointer px-4 py-4 font-semibold text-gray-600">View</td>
                                <td class="cursor-pointer px-4 py-4 font-semibold text-gray-600">Resolve</td>
                            </tr>
                        </template>
                        <tr x-show="filteredRows().length === 0">
                            <td colspan="8" class="px-8 py-16 text-center text-gray-500">No handoff requests match these filters.</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="flex items-center justify-between gap-4 border-t border-gray-200 px-6 py-4 text-[14px] text-gray-600">
                <div class="flex items-center gap-3">
                    <span>Rows per page</span>
                    <select x-model.number="perPage" x-on:change="page = 1" class="h-9 rounded-lg border border-gray-200 bg-white px-3 text-[14px] text-gray-900 outline-none focus:border-blue-400 focus:ring-2 focus:ring-blue-200">
                        <template x-for="option in perPageOptions" :key="option">
                            <option :value="option" x-text="option"></option>
                        </template>
                    </select>
                </div>
                <div class="flex items-center gap-4">
                    <span x-text="paginationSummary()"></span>
                    <div class="flex items-center gap-1">
                        <button type="button" x-on:click="page = Math.max(1, page - 1)" :disabled="page === 1" class="flex size-9 items-center justify-center rounded-lg text-gray-700 transition hover:bg-gray-50 disabled:cursor-not-allowed disabled:opacity-40">
                            <span class="material-symbols-rounded">chevron_left</span>
                        </button>
                        <template x-for="pageNumber in visiblePageNumbers()" :key="pageNumber">
                            <button type="button" x-on:click="page = pageNumber" class="flex size-9 items-center justify-center rounded-lg text-gray-700 transition hover:bg-gray-50" :class="page === pageNumber ? 'bg-gray-100 font-semibold text-gray-950' : ''" x-text="pageNumber"></button>
                        </template>
                        <button type="button" x-on:click="page = Math.min(totalPages(), page + 1)" :disabled="page === totalPages()" class="flex size-9 items-center justify-center rounded-lg text-gray-700 transition hover:bg-gray-50 disabled:cursor-not-allowed disabled:opacity-40">
                            <span class="material-symbols-rounded">chevron_right</span>
                        </button>
                    </div>
                </div>
            </div>
        </section>

        <section x-cloak x-show="activeTab === 'Outreach'" class="mx-6 mb-6 mt-5 overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">
            <div class="grid min-h-[114px] grid-cols-[220px_1fr_230px] items-start gap-6 p-6">
                <h1 class="pt-1 text-[19px] font-semibold tracking-normal">Outreach</h1>

                <div class="relative" x-on:click.outside="searchOpen = false">
                    <div class="rounded-xl border border-gray-200 bg-white shadow-sm">
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
                        <div x-show="filters.length > 0" x-transition class="flex min-h-10 items-center gap-2 border-t border-gray-200 px-4">
                            <template x-for="tag in filters" :key="tag">
                                <button x-on:click="removeFilter(tag)" class="inline-flex items-center gap-1 rounded-lg border border-gray-200 bg-gray-50 px-2 py-1 text-[15px] leading-none text-gray-600">
                                    <span x-text="tag"></span>
                                    <span class="text-gray-500">×</span>
                                </button>
                            </template>
                            <div class="ml-auto flex items-center gap-4">
                                <button class="text-[14px] font-semibold text-gray-500 hover:text-gray-900" x-on:click="clearSearchTags()">Clear</button>
                                <button class="text-[14px] font-semibold text-gray-600 hover:text-gray-900" x-on:click="savePreset()">Save preset</button>
                            </div>
                        </div>
                    </div>

                    <div x-cloak x-show="searchOpen" x-transition class="absolute left-0 right-0 top-0 z-30 rounded-xl border border-gray-200 bg-white p-5 shadow-lg">
                        <input x-model="query" x-ref="overlayInput" x-init="$watch('searchOpen', value => value && activeTab === 'Outreach' && $nextTick(() => $refs.overlayInput.focus()))" class="w-full border-0 bg-transparent text-[17px] outline-none ring-0 focus:ring-0" placeholder="Filter anything">
                        <div class="filter-scroll mt-4 max-h-[215px] space-y-1 overflow-y-auto pr-2">
                            <template x-for="group in groupedSuggestions()" :key="group.column">
                                <div>
                                    <div class="px-1 py-2 text-[15px] font-semibold" x-text="group.column"></div>
                                    <template x-for="value in group.values" :key="group.column + value">
                                        <button x-on:click="addFilter(value)" class="block w-full rounded-lg px-1 py-2 text-left text-[15px] hover:bg-gray-50" x-text="value"></button>
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
                        class="flex h-10 min-w-[190px] items-center justify-between gap-3 rounded-xl border border-gray-200 bg-white px-4 text-left text-[15px] text-gray-900 shadow-sm outline-none transition hover:bg-gray-50 focus:border-blue-400 focus:ring-2 focus:ring-blue-200"
                    >
                        <span x-text="selectedPresetName"></span>
                        <span class="material-symbols-rounded text-gray-600">keyboard_arrow_down</span>
                    </button>
                    <div
                        x-cloak
                        x-show="presetOpen"
                        x-transition
                        class="absolute right-0 top-12 z-40 w-[230px] overflow-hidden rounded-xl border border-gray-200 bg-white p-1 text-[15px] text-gray-900 shadow-lg"
                    >
                        <button
                            type="button"
                            x-on:click="clearFilters()"
                            class="block w-full rounded-lg px-3 py-2 text-left font-semibold hover:bg-gray-50"
                        >
                            Clear filters
                        </button>
                        <template x-for="preset in presets" :key="preset.name">
                            <div class="group flex items-center rounded-lg hover:bg-gray-50">
                                <button
                                    type="button"
                                    x-on:click="applyPreset(preset)"
                                    class="flex min-w-0 flex-1 items-center justify-between px-3 py-2 text-left"
                                >
                                    <span class="truncate" x-text="preset.name"></span>
                                    <span x-show="selectedPresetName === preset.name" class="material-symbols-rounded ml-3 shrink-0 text-blue-500">check</span>
                                </button>
                                <button
                                    type="button"
                                    x-on:click.stop="deletePreset(preset)"
                                    class="mr-2 flex size-8 shrink-0 items-center justify-center rounded-lg text-gray-400 opacity-0 transition hover:bg-red-50 hover:text-red-600 group-hover:opacity-100"
                                    :aria-label="`Delete ${preset.name}`"
                                >
                                    <span class="material-symbols-rounded !text-[18px]">delete</span>
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
                            <th class="w-[70px] px-4 py-4">
                                <button type="button" x-on:click="toggleAgeSort()" class="flex items-center gap-1 rounded-md font-semibold hover:text-gray-600">
                                    <span>Age</span>
                                    <span class="material-symbols-rounded !text-[16px]" x-text="ageSortDirection === 'asc' ? 'arrow_upward' : 'arrow_downward'"></span>
                                </button>
                            </th>
                            <th class="w-[70px] px-4 py-4"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <template x-for="row in paginatedRows()" :key="row.name + row.email + row.age + row.result">
                            <tr class="border-b border-gray-200">
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
                                    <span x-show="row.content === 'View'" class="group relative inline-flex">
                                        <span class="inline-flex max-w-[76px] cursor-pointer rounded-lg border border-gray-200 bg-gray-50 px-2 py-1 text-[13px] leading-none">
                                            <span class="truncate">View</span>
                                        </span>
                                        <span class="pointer-events-none absolute bottom-full left-1/2 z-50 mb-2 w-[320px] -translate-x-1/2 translate-y-1 rounded-lg bg-gray-900 px-4 py-3 text-left text-xs font-medium leading-5 text-white opacity-0 shadow-sm transition group-hover:translate-y-0 group-hover:opacity-100">
                                            <span x-text="row.contentPreview"></span>
                                            <span class="absolute left-1/2 top-full size-2 -translate-x-1/2 -translate-y-1 rotate-45 bg-gray-900"></span>
                                        </span>
                                    </span>
                                    <span x-show="row.content && row.content !== 'View'" class="group relative inline-flex">
                                        <span class="inline-flex max-w-[76px] items-center gap-1 rounded-lg border border-gray-200 bg-gray-50 px-2 py-1 text-[13px] leading-none text-gray-600">
                                            <span class="material-symbols-rounded !text-[14px]">play_circle</span>
                                            <span class="truncate" x-text="row.content"></span>
                                        </span>
                                        <span class="pointer-events-none absolute bottom-full left-1/2 z-50 mb-2 -translate-x-1/2 translate-y-1 whitespace-nowrap rounded-lg bg-gray-900 px-3 py-2 text-xs font-medium text-white opacity-0 shadow-sm transition group-hover:translate-y-0 group-hover:opacity-100">
                                            Listen
                                            <span class="absolute left-1/2 top-full size-2 -translate-x-1/2 -translate-y-1 rotate-45 bg-gray-900"></span>
                                        </span>
                                    </span>
                                </td>
                                <td class="px-4 py-4">
                                    <span class="group relative inline-flex">
                                        <span class="inline-flex max-w-[112px] items-center gap-1 rounded-lg border border-gray-200 bg-gray-50 px-2 py-1 text-[13px] leading-none text-gray-600">
                                            <span class="material-symbols-rounded !text-[14px]" x-text="row.direction === 'Inbound' ? 'arrow_downward' : 'arrow_upward'"></span>
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
                                        <span class="inline-flex max-w-[138px] items-center gap-1 rounded-lg border px-2 py-1 text-[13px] leading-none" :class="pillClass(row.outcome)">
                                            <span class="material-symbols-rounded !text-[14px]" x-text="outcomeIcon(row.outcome)"></span>
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
                                        <span class="inline-flex max-w-[98px] rounded-lg border px-2 py-1 text-[13px] leading-none" :class="pillClass(row.result)">
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
                                        <span x-text="row.age"></span>
                                        <span class="pointer-events-none absolute bottom-full left-1/2 z-50 mb-2 -translate-x-1/2 translate-y-1 whitespace-nowrap rounded-lg bg-gray-900 px-3 py-2 text-xs font-medium text-white opacity-0 shadow-sm transition group-hover:translate-y-0 group-hover:opacity-100">
                                            <span x-text="row.ageTooltip"></span>
                                            <span class="absolute left-1/2 top-full size-2 -translate-x-1/2 -translate-y-1 rotate-45 bg-gray-900"></span>
                                        </span>
                                    </span>
                                </td>
                                <td class="cursor-pointer px-4 py-4 font-semibold text-gray-600">View</td>
                            </tr>
                        </template>
                        <tr x-show="filteredRows().length === 0">
                            <td colspan="10" class="px-8 py-16 text-center text-gray-500">No outreach records match these filters.</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="flex items-center justify-between gap-4 border-t border-gray-200 px-6 py-4 text-[14px] text-gray-600">
                <div class="flex items-center gap-3">
                    <span>Rows per page</span>
                    <select x-model.number="perPage" x-on:change="page = 1" class="h-9 rounded-lg border border-gray-200 bg-white px-3 text-[14px] text-gray-900 outline-none focus:border-blue-400 focus:ring-2 focus:ring-blue-200">
                        <template x-for="option in perPageOptions" :key="option">
                            <option :value="option" x-text="option"></option>
                        </template>
                    </select>
                </div>
                <div class="flex items-center gap-4">
                    <span x-text="paginationSummary()"></span>
                    <div class="flex items-center gap-1">
                        <button type="button" x-on:click="page = Math.max(1, page - 1)" :disabled="page === 1" class="flex size-9 items-center justify-center rounded-lg text-gray-700 transition hover:bg-gray-50 disabled:cursor-not-allowed disabled:opacity-40">
                            <span class="material-symbols-rounded">chevron_left</span>
                        </button>
                        <template x-for="pageNumber in visiblePageNumbers()" :key="pageNumber">
                            <button type="button" x-on:click="page = pageNumber" class="flex size-9 items-center justify-center rounded-lg text-gray-700 transition hover:bg-gray-50" :class="page === pageNumber ? 'bg-gray-100 font-semibold text-gray-950' : ''" x-text="pageNumber"></button>
                        </template>
                        <button type="button" x-on:click="page = Math.min(totalPages(), page + 1)" :disabled="page === totalPages()" class="flex size-9 items-center justify-center rounded-lg text-gray-700 transition hover:bg-gray-50 disabled:cursor-not-allowed disabled:opacity-40">
                            <span class="material-symbols-rounded">chevron_right</span>
                        </button>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <script>
        function outreachPage(rows) {
            return {
                rows,
                sidebarOpen: true,
                activeTab: 'Handoffs',
                campaignOpen: false,
                presetOpen: false,
                campaign: 'Abandoned Cart',
                campaigns: ['All campaigns', 'Abandoned Cart', 'Web Support'],
                query: '',
                searchOpen: false,
                filters: [],
                ageSortDirection: 'asc',
                page: 1,
                perPage: 25,
                perPageOptions: [10, 25, 50, 100],
                selectedPresetName: 'Filter presets',
                nav: [
                    { label: 'Dashboard', icon: 'dashboard' },
                    { label: 'Campaigns', icon: 'format_list_bulleted' },
                    { label: 'Operations', icon: 'group' },
                    { label: 'Insights', icon: 'monitoring' },
                    { label: 'Knowledge Base', icon: 'library_books' },
                ],
                tabs: [
                    { label: 'Leads', icon: 'group' },
                    { label: 'Campaigns', icon: 'account_tree' },
                    { label: 'Outreach', icon: 'phone_in_talk' },
                    { label: 'Handoffs', icon: 'waving_hand' },
                ],
                presets: [
                    { name: 'WhatsApp Positive', filters: ['WhatsApp', 'Positive'] },
                    { name: 'Negative', filters: ['Negative'] },
                    { name: 'Positive Inbound Calls', filters: ['Positive', 'Inbound', 'Call'] },
                ],
                searchableColumns: ['Channel', 'Direction', 'Outcome', 'Result', 'Name', 'Phone', 'Email'],
                leadSearchableColumns: ['State', 'Country', 'Timezone', 'Name', 'Phone', 'Email'],
                campaignSearchableColumns: ['Campaign', 'Status', 'First Interaction', 'Follow Up', 'Name', 'Phone', 'Email'],
                handoffSearchableColumns: ['Country', 'Timezone', 'Name', 'Phone', 'Email'],
                setActiveTab(tab) {
                    this.activeTab = tab;
                    this.campaign = tab === 'Campaigns' ? 'Abandoned Cart' : 'All campaigns';
                    this.page = 1;
                    this.query = '';
                    this.filters = [];
                    this.searchOpen = false;
                    this.presetOpen = false;
                    this.selectedPresetName = 'Filter presets';
                },
                currentSearchableColumns() {
                    if (this.activeTab === 'Leads') {
                        return this.leadSearchableColumns;
                    }

                    if (this.activeTab === 'Campaigns') {
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
                    if (!this.filters.includes(value)) {
                        this.filters.push(value);
                    }

                    this.page = 1;
                    this.query = '';
                    this.searchOpen = false;
                },
                removeFilter(value) {
                    this.filters = this.filters.filter((filter) => filter !== value);
                    this.selectedPresetName = 'Filter presets';
                    this.page = 1;
                },
                applyPreset(preset) {
                    this.filters = [...preset.filters];
                    this.selectedPresetName = preset.name;
                    this.searchOpen = false;
                    this.presetOpen = false;
                    this.page = 1;
                },
                deletePreset(preset) {
                    this.presets = this.presets.filter((item) => item.name !== preset.name);

                    if (this.selectedPresetName === preset.name) {
                        this.selectedPresetName = 'Filter presets';
                    }
                },
                clearFilters() {
                    this.filters = [];
                    this.selectedPresetName = 'Filter presets';
                    this.searchOpen = false;
                    this.presetOpen = false;
                    this.page = 1;
                },
                clearSearchTags() {
                    this.filters = [];
                    this.selectedPresetName = 'Filter presets';
                    this.query = '';
                    this.searchOpen = false;
                    this.page = 1;
                },
                savePreset() {
                    if (this.filters.length === 0) {
                        return;
                    }

                    const name = this.filters.join(' ');

                    this.presets.unshift({
                        name,
                        filters: [...this.filters],
                    });

                    this.selectedPresetName = name;
                },
                toggleAgeSort() {
                    this.ageSortDirection = this.ageSortDirection === 'asc' ? 'desc' : 'asc';
                    this.page = 1;
                },
                filteredRows() {
                    const rows = this.rows.filter((row) => {
                        if (this.activeTab === 'Campaigns' && this.campaign !== 'All campaigns' && row.campaignName !== this.campaign) {
                            return false;
                        }

                        if (this.activeTab === 'Outreach') {
                            if (this.campaign === 'Abandoned Cart' && !['Email', 'SMS'].includes(row.channel)) {
                                return false;
                            }

                            if (this.campaign === 'Web Support' && !['Call', 'WhatsApp'].includes(row.channel)) {
                                return false;
                            }
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
                totalPages() {
                    return Math.max(1, Math.ceil(this.filteredRows().length / this.perPage));
                },
                paginationSummary() {
                    const total = this.filteredRows().length;

                    if (total === 0) {
                        return '0 results';
                    }

                    const start = (this.page - 1) * this.perPage + 1;
                    const end = Math.min(total, this.page * this.perPage);

                    return `${start}-${end} of ${total}`;
                },
                visiblePageNumbers() {
                    const total = this.totalPages();
                    const start = Math.max(1, Math.min(this.page - 2, total - 4));
                    const end = Math.min(total, start + 4);
                    const pages = [];

                    for (let pageNumber = start; pageNumber <= end; pageNumber++) {
                        pages.push(pageNumber);
                    }

                    return pages;
                },
                shortEmail(email) {
                    return email.length > 18 ? email.slice(0, 18) + '...' : email;
                },
                shortLeadEmail(email) {
                    return email.length > 27 ? email.slice(0, 27) + '...' : email;
                },
                leadAge(row) {
                    if (row.age.endsWith('mo') || row.age.endsWith('y')) {
                        return row.age;
                    }

                    return ((Math.floor(Number(row.ageSeconds) / 2592000) % 8) + 1) + 'mo';
                },
                campaignAge(row) {
                    return ((Math.floor(Number(row.ageSeconds) / 2592000) % 6) + 1) + 'mo';
                },
                campaignBadgeClass(value) {
                    if (['Completed', 'Positive'].includes(value)) {
                        return 'border-green-200 bg-green-50 text-green-600';
                    }

                    if (value === 'Unreachable') {
                        return 'border-red-200 bg-red-50 text-red-600';
                    }

                    if (value === 'Ghosted') {
                        return 'border-amber-200 bg-amber-50 text-amber-700';
                    }

                    return 'border-gray-200 bg-gray-50 text-gray-600';
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
                        return 'border-green-200 bg-green-50 text-green-600';
                    }

                    if (value === 'Unreachable') {
                        return 'border-green-200 bg-green-50 text-green-600';
                    }

                    if (['Escalated', 'Review required'].includes(value)) {
                        return 'border-amber-200 bg-amber-50 text-amber-700';
                    }

                    if (value === 'Failed') {
                        return 'border-red-200 bg-red-50 text-red-600';
                    }

                    return 'border-gray-200 bg-gray-50 text-gray-600';
                },
            };
        }
    </script>
</div>
BLADE;
    }
}
