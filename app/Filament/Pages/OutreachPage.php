<?php

namespace App\Filament\Pages;

use BackedEnum;
use Filament\Actions\Action;
use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;
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

    public function deleteSelectedLeadsAction(): Action
    {
        return Action::make('deleteSelectedLeads')
            ->label('Delete')
            ->color('danger')
            ->modalIcon(Heroicon::OutlinedTrash)
            ->modalIconColor('danger')
            ->modalHeading(function (array $arguments): string {
                return $this->selectedLeadsActionCount($arguments) === 1
                    ? 'Delete Selected Lead'
                    : 'Delete Selected Leads';
            })
            ->modalDescription(function (array $arguments): string {
                $count = $this->selectedLeadsActionCount($arguments);
                $leadLabel = match (true) {
                    $count === 1 => 'this selected lead',
                    $count > 1 => "{$count} selected leads",
                    default => 'the selected leads',
                };

                return "You are about to delete {$leadLabel}. This action cannot be undone.";
            })
            ->modalSubmitActionLabel(function (array $arguments): string {
                return $this->selectedLeadsActionCount($arguments) === 1
                    ? 'Delete Lead'
                    : 'Delete Selected Leads';
            })
            ->modalCancelActionLabel('Cancel')
            ->requiresConfirmation()
            ->action(function (array $arguments): void {
                $this->dispatch(
                    'outreach-delete-selected-leads',
                    ids: array_values(array_map('intval', $arguments['ids'] ?? [])),
                );
            });
    }

    private function selectedLeadsActionCount(array $arguments): int
    {
        return count(array_filter($arguments['ids'] ?? [], static fn (mixed $id): bool => is_numeric($id)));
    }

    public function reorderFindOutQuestionsAction(): Action
    {
        return Action::make('reorderFindOutQuestions')
            ->action(function (array $arguments): void {
                $this->dispatch(
                    'outreach-reorder-find-out-questions',
                    ids: array_values(array_map('strval', $arguments['items'] ?? [])),
                );
            });
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
                'phoneFlagCode' => in_array($areaCode, $canadianAreaCodes, true) ? 'ca' : 'us',
                'country' => in_array($areaCode, $canadianAreaCodes, true) ? 'CA' : 'US',
                'countryFlagCode' => in_array($areaCode, $canadianAreaCodes, true) ? 'ca' : 'us',
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
    x-init="initializePrimaryTheme(); initializeRadiusTheme(); initializeIconStrokeTheme(); initializeTypographyTheme(); initializeProgressBarStyle(); initializeFromUrl()"
    x-on:keydown.window="handlePrimaryThemeShortcut($event); handleRadiusShortcut($event); handleIconStrokeShortcut($event); handleTypographyShortcut($event)"
    x-on:outreach-delete-selected-leads.window="deleteSelectedLeadsByIds($event.detail.ids)"
    x-on:outreach-reorder-find-out-questions.window="reorderFindOutQuestionsByIds($event.detail.ids)"
    class="outcraft-page fixed inset-0 z-50 overflow-hidden bg-white text-[#1f2024]"
    style="font-family: 'Inter Variable', Inter, ui-sans-serif, system-ui, sans-serif;"
>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="/js/lucide.js"></script>

    <div
        x-cloak
        x-show="floatingTooltip.visible"
        class="outcraft-floating-tooltip rounded-lg bg-gray-900 px-3 py-2 text-center text-xs font-medium leading-4 text-white shadow-sm"
        :style="`left: ${floatingTooltip.left}px; top: ${floatingTooltip.top}px; width: ${floatingTooltip.width}px; --outcraft-tooltip-arrow-left: ${floatingTooltip.arrowLeft}px;`"
    >
        <span x-text="floatingTooltip.text"></span>
        <span class="absolute top-full size-2 -translate-x-1/2 -translate-y-1 rotate-45 bg-gray-900" style="left: var(--outcraft-tooltip-arrow-left, 50%);"></span>
    </div>

    <div
        x-cloak
        x-show="captureToast.visible"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 translate-y-2"
        x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 translate-y-2"
        class="fixed right-4 top-4 z-[100] w-[22rem] max-w-[calc(100vw-2rem)] rounded-lg bg-white p-4 shadow-lg ring-1 ring-gray-900/10"
    >
        <div class="flex items-start gap-3">
            <span class="flex size-8 shrink-0 items-center justify-center rounded-full bg-emerald-50 text-emerald-600">
                <span class="outcraft-icon !text-[18px]">fact_check</span>
            </span>
            <div class="min-w-0">
                <p class="text-sm font-semibold leading-6 text-gray-950" x-text="captureToast.title"></p>
                <p class="text-sm leading-6 text-gray-600" x-text="captureToast.message"></p>
            </div>
        </div>
    </div>

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
                <span class="relative mt-2 block">
                    <select
                        x-model="activeColorRole"
                        class="block h-9 w-full appearance-none rounded-md bg-white py-1.5 pl-3 pr-9 text-sm text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 transition focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600"
                    >
                        <template x-for="role in colorRoleOptions" :key="role.key">
                            <option :value="role.key" x-text="role.label"></option>
                        </template>
                    </select>
                    <span class="pointer-events-none absolute inset-y-0 right-3 flex items-center text-gray-400">
                        <span class="outcraft-icon !text-[18px]">keyboard_arrow_down</span>
                    </span>
                </span>
                <span class="mt-2 block text-xs leading-5 text-gray-500" x-text="activeColorRoleDescription()"></span>
            </label>

            <label x-show="activeColorRole === 'primary'" class="mt-4 block">
                <span class="block text-sm font-semibold leading-6 text-gray-950">Primary Shade</span>
                <span class="relative mt-2 block">
                    <select
                        x-model="primaryThemeValue"
                        x-effect="previewPrimaryThemeValue(primaryThemeValue)"
                        x-on:change="setPrimaryThemeValue(primaryThemeValue)"
                        class="block h-9 w-full appearance-none rounded-md bg-white py-1.5 pl-3 pr-9 text-sm text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 transition focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600"
                    >
                        <template x-for="shade in primaryThemeValueOptions" :key="shade">
                            <option :value="shade" x-text="`Primary ${shade}`"></option>
                        </template>
                    </select>
                    <span class="pointer-events-none absolute inset-y-0 right-3 flex items-center text-gray-400">
                        <span class="outcraft-icon !text-[18px]">keyboard_arrow_down</span>
                    </span>
                </span>
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
            --oc-primary-50: #eef2ff;
            --oc-primary-100: #e0e7ff;
            --oc-primary-200: #c7d2fe;
            --oc-primary-300: #a5b4fc;
            --oc-primary-400: #818cf8;
            --oc-primary-500: #6366f1;
            --oc-primary-600: #4f46e5;
            --oc-primary-700: #4338ca;
            --oc-primary-800: #3730a3;
            --oc-primary-900: #312e81;
            --oc-primary-950: #1e1b4b;
            --oc-primary-50-rgb: 238 242 255;
            --oc-primary-100-rgb: 224 231 255;
            --oc-primary-200-rgb: 199 210 254;
            --oc-primary-300-rgb: 165 180 252;
            --oc-primary-400-rgb: 129 140 248;
            --oc-primary-500-rgb: 99 102 241;
            --oc-primary-600-rgb: 79 70 229;
            --oc-primary-700-rgb: 67 56 202;
            --oc-primary-800-rgb: 55 48 163;
            --oc-primary-900-rgb: 49 46 129;
            --oc-primary-950-rgb: 30 27 75;
            --oc-success-50-rgb: 240 253 250;
            --oc-success-100-rgb: 204 251 241;
            --oc-success-200-rgb: 153 246 228;
            --oc-success-300-rgb: 94 234 212;
            --oc-success-400-rgb: 45 212 191;
            --oc-success-500-rgb: 20 184 166;
            --oc-success-600-rgb: 13 148 136;
            --oc-success-700-rgb: 15 118 110;
            --oc-success-800-rgb: 17 94 89;
            --oc-success-900-rgb: 19 78 74;
            --oc-success-950-rgb: 4 47 46;
            --oc-warning-50-rgb: 255 251 235;
            --oc-warning-100-rgb: 254 243 199;
            --oc-warning-200-rgb: 253 230 138;
            --oc-warning-300-rgb: 252 211 77;
            --oc-warning-400-rgb: 251 191 36;
            --oc-warning-500-rgb: 245 158 11;
            --oc-warning-600-rgb: 217 119 6;
            --oc-warning-700-rgb: 180 83 9;
            --oc-warning-800-rgb: 146 64 14;
            --oc-warning-900-rgb: 120 53 15;
            --oc-warning-950-rgb: 69 26 3;
            --oc-danger-50-rgb: 254 242 242;
            --oc-danger-100-rgb: 254 226 226;
            --oc-danger-200-rgb: 254 202 202;
            --oc-danger-300-rgb: 252 165 165;
            --oc-danger-400-rgb: 248 113 113;
            --oc-danger-500-rgb: 239 68 68;
            --oc-danger-600-rgb: 220 38 38;
            --oc-danger-700-rgb: 185 28 28;
            --oc-danger-800-rgb: 153 27 27;
            --oc-danger-900-rgb: 127 29 29;
            --oc-danger-950-rgb: 69 10 10;
            --oc-button-radius: 0.375rem;
            --oc-field-radius: 0.375rem;
            --oc-card-radius: 0.5rem;
            --oc-icon-tile-radius: 0.375rem;
            --oc-icon-stroke-width: 1.5px;
            --oc-text-xs: 0.75rem;
            --oc-text-sm: 0.875rem;
            --oc-text-base: 1rem;
            --oc-text-lg: 1.125rem;
            --oc-text-xl: 1.25rem;
            --oc-text-2xl: 1.5rem;
            --oc-text-3xl: 1.875rem;
            --oc-text-4xl: 2.25rem;
            --oc-leading-xs: 1rem;
            --oc-leading-sm: 1.25rem;
            --oc-leading-base: 1.5rem;
            --oc-leading-lg: 1.75rem;
            --oc-leading-xl: 1.75rem;
            --oc-leading-2xl: 2rem;
            --oc-leading-3xl: 2.25rem;
            --oc-leading-4xl: 2.5rem;
            --oc-font-medium: 500;
            --oc-font-semibold: 600;
            --oc-font-bold: 700;
            scrollbar-color: #d4d4d4 transparent;
            scrollbar-width: thin;
            font-feature-settings: "cv02", "cv03", "cv04", "cv11";
            font-size: var(--oc-text-sm);
            line-height: var(--oc-leading-sm);
        }
        .outcraft-page .text-xs,
        .outcraft-page [class~="text-xs/4"],
        .outcraft-page [class~="text-xs/5"],
        .outcraft-page [class~="text-xs/6"] {
            font-size: var(--oc-text-xs);
            line-height: var(--oc-leading-xs);
        }
        .outcraft-page .text-sm,
        .outcraft-page [class~="text-sm/5"],
        .outcraft-page [class~="text-sm/6"],
        .outcraft-page [class~="text-sm/7"] {
            font-size: var(--oc-text-sm);
            line-height: var(--oc-leading-sm);
        }
        .outcraft-page .text-base,
        .outcraft-page [class~="text-base/6"],
        .outcraft-page [class~="text-base/7"] {
            font-size: var(--oc-text-base);
            line-height: var(--oc-leading-base);
        }
        .outcraft-page .text-lg,
        .outcraft-page [class~="text-lg/7"],
        .outcraft-page [class~="text-lg/8"] {
            font-size: var(--oc-text-lg);
            line-height: var(--oc-leading-lg);
        }
        .outcraft-page .text-xl,
        .outcraft-page [class~="text-xl/7"],
        .outcraft-page [class~="text-xl/8"] {
            font-size: var(--oc-text-xl);
            line-height: var(--oc-leading-xl);
        }
        .outcraft-page .text-2xl,
        .outcraft-page [class~="text-2xl/8"],
        .outcraft-page [class~="text-2xl/9"] {
            font-size: var(--oc-text-2xl);
            line-height: var(--oc-leading-2xl);
        }
        .outcraft-page .text-3xl,
        .outcraft-page [class~="text-3xl/9"],
        .outcraft-page [class~="text-3xl/10"] {
            font-size: var(--oc-text-3xl);
            line-height: var(--oc-leading-3xl);
        }
        .outcraft-page .text-4xl,
        .outcraft-page [class~="text-4xl/10"] {
            font-size: var(--oc-text-4xl);
            line-height: var(--oc-leading-4xl);
        }
        .outcraft-page .font-medium {
            font-weight: var(--oc-font-medium);
        }
        .outcraft-page .font-semibold {
            font-weight: var(--oc-font-semibold);
        }
        .outcraft-page .font-bold {
            font-weight: var(--oc-font-bold);
        }
        .outcraft-page button[class~="rounded"]:not([class~="rounded-full"]),
        .outcraft-page button[class*="rounded-"]:not([class~="rounded-full"]),
        .outcraft-page a[role="button"][class~="rounded"]:not([class~="rounded-full"]),
        .outcraft-page a[role="button"][class*="rounded-"]:not([class~="rounded-full"]),
        .outcraft-page [role="button"][class~="rounded"]:not([class~="rounded-full"]),
        .outcraft-page [role="button"][class*="rounded-"]:not([class~="rounded-full"]) {
            border-radius: var(--oc-button-radius) !important;
        }
        .outcraft-page input:not([type="checkbox"]):not([type="radio"]):not([type="range"]):not([type="file"])[class~="rounded"],
        .outcraft-page input:not([type="checkbox"]):not([type="radio"]):not([type="range"]):not([type="file"])[class*="rounded-"],
        .outcraft-page textarea[class~="rounded"],
        .outcraft-page textarea[class*="rounded-"],
        .outcraft-page select[class~="rounded"],
        .outcraft-page select[class*="rounded-"],
        .outcraft-page div[class~="rounded"]:has(> input:not([type="checkbox"]):not([type="radio"]):not([type="range"]):not([type="file"])),
        .outcraft-page div[class*="rounded-"]:has(> input:not([type="checkbox"]):not([type="radio"]):not([type="range"]):not([type="file"])),
        .outcraft-page div[class~="rounded"]:has(> select),
        .outcraft-page div[class*="rounded-"]:has(> select),
        .outcraft-page div[class~="rounded"]:has(> textarea),
        .outcraft-page div[class*="rounded-"]:has(> textarea),
        .outcraft-page [data-component="custom-field-text-input"] {
            border-radius: var(--oc-field-radius) !important;
        }
        .outcraft-page article[class*="rounded-"],
        .outcraft-page section[class*="rounded-"][class*="border"],
        .outcraft-page div[class*="rounded-"][class*="border"][class*="bg-white"]:not([data-component="custom-field-text-input"]):not(:has(> input)):not(:has(> select)):not(:has(> textarea)),
        .outcraft-page div[class*="rounded-"][class*="outline"][class*="bg-white"],
        .outcraft-page button[class*="rounded-"][class*="outline"][class*="p-4"],
        .outcraft-page button[class*="rounded-"][class*="outline"][class*="p-5"],
        .outcraft-page button[class*="rounded-"][class*="border"][class*="p-4"],
        .outcraft-page button[class*="rounded-"][class*="border"][class*="p-5"] {
            border-radius: var(--oc-card-radius) !important;
        }
        .outcraft-page :is(span, div)[class*="size-"][class*="rounded-"]:not([class~="rounded-full"]):has(> .outcraft-icon),
        .outcraft-page :is(span, div)[class*="size-"][class*="rounded-"]:not([class~="rounded-full"]):has(> .outcraft-source-logo),
        .outcraft-page :is(span, div)[class*="size-"][class*="rounded-"]:not([class~="rounded-full"]):has(> svg) {
            border-radius: var(--oc-icon-tile-radius) !important;
        }
        .outcraft-page [class~="rounded-full"] {
            border-radius: 9999px !important;
        }
        .outcraft-page button[role="switch"][class~="rounded-full"],
        .outcraft-page button[role="switch"][class~="rounded-full"] > [class~="rounded-full"],
        .outcraft-page [role="switch"] [class~="rounded-full"] {
            border-radius: 9999px !important;
        }
        .outcraft-page .bg-indigo-50,
        .outcraft-page .hover\:bg-indigo-50:hover,
        .outcraft-page .group:hover .group-hover\:bg-indigo-50 {
            background-color: rgb(var(--oc-primary-50-rgb)) !important;
        }
        .outcraft-page .bg-indigo-50\/50 {
            background-color: rgb(var(--oc-primary-50-rgb) / 0.5) !important;
        }
        .outcraft-page .bg-indigo-100,
        .outcraft-page .hover\:bg-indigo-100:hover {
            background-color: rgb(var(--oc-primary-100-rgb)) !important;
        }
        .outcraft-page .bg-indigo-200,
        .outcraft-page .hover\:bg-indigo-200:hover {
            background-color: rgb(var(--oc-primary-200-rgb)) !important;
        }
        .outcraft-page .bg-indigo-400 {
            background-color: rgb(var(--oc-primary-400-rgb)) !important;
        }
        .outcraft-page .bg-indigo-500,
        .outcraft-page .hover\:bg-indigo-500:hover,
        .outcraft-page .group:hover .group-hover\:bg-indigo-500 {
            background-color: rgb(var(--oc-primary-500-rgb)) !important;
        }
        .outcraft-page .bg-indigo-600,
        .outcraft-page .checked\:bg-indigo-600:checked,
        .outcraft-page .indeterminate\:bg-indigo-600:indeterminate {
            background-color: rgb(var(--oc-primary-600-rgb)) !important;
        }
        .outcraft-page .bg-indigo-700,
        .outcraft-page .hover\:bg-indigo-700:hover {
            background-color: rgb(var(--oc-primary-700-rgb)) !important;
        }
        .outcraft-page .bg-indigo-800,
        .outcraft-page .hover\:bg-indigo-800:hover,
        .outcraft-page .group:hover .group-hover\:bg-indigo-800 {
            background-color: rgb(var(--oc-primary-800-rgb)) !important;
        }
        .outcraft-page .text-indigo-400 {
            color: rgb(var(--oc-primary-400-rgb)) !important;
        }
        .outcraft-page .text-indigo-500,
        .outcraft-page .hover\:text-indigo-500:hover {
            color: rgb(var(--oc-primary-500-rgb)) !important;
        }
        .outcraft-page .text-indigo-600,
        .outcraft-page .hover\:text-indigo-600:hover,
        .outcraft-page .group:hover .group-hover\:text-indigo-600 {
            color: rgb(var(--oc-primary-600-rgb)) !important;
        }
        .outcraft-page .text-indigo-700,
        .outcraft-page .hover\:text-indigo-700:hover {
            color: rgb(var(--oc-primary-700-rgb)) !important;
        }
        .outcraft-page .text-indigo-800,
        .outcraft-page .hover\:text-indigo-800:hover {
            color: rgb(var(--oc-primary-800-rgb)) !important;
        }
        .outcraft-page .text-indigo-900 {
            color: rgb(var(--oc-primary-900-rgb)) !important;
        }
        .outcraft-page .text-indigo-950 {
            color: rgb(var(--oc-primary-950-rgb)) !important;
        }
        .outcraft-page .border-indigo-200 {
            border-color: rgb(var(--oc-primary-200-rgb)) !important;
        }
        .outcraft-page .border-indigo-300 {
            border-color: rgb(var(--oc-primary-300-rgb)) !important;
        }
        .outcraft-page .border-indigo-400 {
            border-color: rgb(var(--oc-primary-400-rgb)) !important;
        }
        .outcraft-page .border-indigo-600,
        .outcraft-page .hover\:border-indigo-600:hover,
        .outcraft-page .checked\:border-indigo-600:checked,
        .outcraft-page .indeterminate\:border-indigo-600:indeterminate {
            border-color: rgb(var(--oc-primary-600-rgb)) !important;
        }
        .outcraft-page .outline-indigo-600,
        .outcraft-page .hover\:outline-indigo-600:hover,
        .outcraft-page .focus\:outline-indigo-600:focus,
        .outcraft-page .focus-visible\:outline-indigo-600:focus-visible,
        .outcraft-page .focus-within\:outline-indigo-600:focus-within {
            outline-color: rgb(var(--oc-primary-600-rgb)) !important;
        }
        .outcraft-page .ring-indigo-100 {
            --tw-ring-color: rgb(var(--oc-primary-100-rgb)) !important;
        }
        .outcraft-page .ring-indigo-200 {
            --tw-ring-color: rgb(var(--oc-primary-200-rgb)) !important;
        }
        .outcraft-page .ring-indigo-600,
        .outcraft-page .focus\:ring-indigo-600:focus,
        .outcraft-page .focus-visible\:ring-indigo-600:focus-visible,
        .outcraft-page .focus-within\:ring-indigo-600:focus-within {
            --tw-ring-color: rgb(var(--oc-primary-600-rgb)) !important;
        }
        .outcraft-page .ring-indigo-600\/20 {
            --tw-ring-color: rgb(var(--oc-primary-600-rgb) / 0.2) !important;
        }
        .outcraft-page .ring-indigo-700\/10 {
            --tw-ring-color: rgb(var(--oc-primary-700-rgb) / 0.1) !important;
        }
        .outcraft-page .oc-primary-bg {
            background-color: rgb(var(--oc-primary-600-rgb)) !important;
        }
        .outcraft-page .oc-primary-bg-soft {
            background-color: rgb(var(--oc-primary-200-rgb)) !important;
        }
        .outcraft-page .oc-primary-border {
            border-color: rgb(var(--oc-primary-600-rgb)) !important;
        }
        .outcraft-page .oc-primary-text {
            color: rgb(var(--oc-primary-600-rgb)) !important;
        }
        .outcraft-page .bg-green-50,
        .outcraft-page .bg-emerald-50,
        .outcraft-page .hover\:bg-green-50:hover,
        .outcraft-page .hover\:bg-emerald-50:hover {
            background-color: rgb(var(--oc-success-50-rgb)) !important;
        }
        .outcraft-page .bg-green-100,
        .outcraft-page .bg-emerald-100,
        .outcraft-page .hover\:bg-green-100:hover,
        .outcraft-page .hover\:bg-emerald-100:hover {
            background-color: rgb(var(--oc-success-100-rgb)) !important;
        }
        .outcraft-page .bg-green-600,
        .outcraft-page .bg-emerald-600,
        .outcraft-page .hover\:bg-green-600:hover,
        .outcraft-page .hover\:bg-emerald-600:hover {
            background-color: rgb(var(--oc-success-600-rgb)) !important;
        }
        .outcraft-page .text-green-500,
        .outcraft-page .text-emerald-500 {
            color: rgb(var(--oc-success-500-rgb)) !important;
        }
        .outcraft-page .text-green-600,
        .outcraft-page .text-emerald-600,
        .outcraft-page .hover\:text-green-600:hover,
        .outcraft-page .hover\:text-emerald-600:hover {
            color: rgb(var(--oc-success-600-rgb)) !important;
        }
        .outcraft-page .text-green-700,
        .outcraft-page .text-emerald-700,
        .outcraft-page .hover\:text-green-700:hover,
        .outcraft-page .hover\:text-emerald-700:hover {
            color: rgb(var(--oc-success-700-rgb)) !important;
        }
        .outcraft-page .text-green-900,
        .outcraft-page .text-emerald-900 {
            color: rgb(var(--oc-success-900-rgb)) !important;
        }
        .outcraft-page .border-green-200,
        .outcraft-page .border-emerald-200 {
            border-color: rgb(var(--oc-success-200-rgb)) !important;
        }
        .outcraft-page .ring-green-200,
        .outcraft-page .ring-emerald-200 {
            --tw-ring-color: rgb(var(--oc-success-200-rgb)) !important;
        }
        .outcraft-page .ring-green-600,
        .outcraft-page .ring-emerald-600 {
            --tw-ring-color: rgb(var(--oc-success-600-rgb)) !important;
        }
        .outcraft-page .ring-green-600\/20,
        .outcraft-page .ring-emerald-600\/20 {
            --tw-ring-color: rgb(var(--oc-success-600-rgb) / 0.2) !important;
        }
        .outcraft-page .bg-amber-50,
        .outcraft-page .bg-yellow-50,
        .outcraft-page .bg-orange-50,
        .outcraft-page .hover\:bg-amber-50:hover,
        .outcraft-page .hover\:bg-yellow-50:hover,
        .outcraft-page .hover\:bg-orange-50:hover {
            background-color: rgb(var(--oc-warning-50-rgb)) !important;
        }
        .outcraft-page .text-amber-500,
        .outcraft-page .text-yellow-500,
        .outcraft-page .text-orange-500 {
            color: rgb(var(--oc-warning-500-rgb)) !important;
        }
        .outcraft-page .text-amber-600,
        .outcraft-page .text-yellow-600,
        .outcraft-page .text-orange-600 {
            color: rgb(var(--oc-warning-600-rgb)) !important;
        }
        .outcraft-page .text-amber-700,
        .outcraft-page .text-yellow-700,
        .outcraft-page .text-orange-700 {
            color: rgb(var(--oc-warning-700-rgb)) !important;
        }
        .outcraft-page .text-amber-800,
        .outcraft-page .text-yellow-800,
        .outcraft-page .text-orange-800 {
            color: rgb(var(--oc-warning-800-rgb)) !important;
        }
        .outcraft-page .border-amber-400,
        .outcraft-page .border-yellow-400,
        .outcraft-page .border-orange-400 {
            border-color: rgb(var(--oc-warning-400-rgb)) !important;
        }
        .outcraft-page .ring-amber-100,
        .outcraft-page .ring-yellow-100,
        .outcraft-page .ring-orange-100 {
            --tw-ring-color: rgb(var(--oc-warning-100-rgb)) !important;
        }
        .outcraft-page .ring-amber-600\/20,
        .outcraft-page .ring-yellow-600\/20,
        .outcraft-page .ring-orange-600\/20 {
            --tw-ring-color: rgb(var(--oc-warning-600-rgb) / 0.2) !important;
        }
        .outcraft-page .bg-red-50,
        .outcraft-page .hover\:bg-red-50:hover {
            background-color: rgb(var(--oc-danger-50-rgb)) !important;
        }
        .outcraft-page .bg-red-500,
        .outcraft-page .hover\:bg-red-500:hover {
            background-color: rgb(var(--oc-danger-500-rgb)) !important;
        }
        .outcraft-page .bg-red-600,
        .outcraft-page .hover\:bg-red-600:hover {
            background-color: rgb(var(--oc-danger-600-rgb)) !important;
        }
        .outcraft-page .text-red-500,
        .outcraft-page .hover\:text-red-500:hover {
            color: rgb(var(--oc-danger-500-rgb)) !important;
        }
        .outcraft-page .text-red-600,
        .outcraft-page .hover\:text-red-600:hover {
            color: rgb(var(--oc-danger-600-rgb)) !important;
        }
        .outcraft-page .text-red-700,
        .outcraft-page .hover\:text-red-700:hover {
            color: rgb(var(--oc-danger-700-rgb)) !important;
        }
        .outcraft-page .border-red-200 {
            border-color: rgb(var(--oc-danger-200-rgb)) !important;
        }
        .outcraft-page .outline-red-300 {
            outline-color: rgb(var(--oc-danger-300-rgb)) !important;
        }
        .outcraft-page .outline-red-500,
        .outcraft-page .focus-visible\:outline-red-500:focus-visible {
            outline-color: rgb(var(--oc-danger-500-rgb)) !important;
        }
        .outcraft-page .outline-red-600,
        .outcraft-page .focus\:outline-red-600:focus {
            outline-color: rgb(var(--oc-danger-600-rgb)) !important;
        }
        .outcraft-page .ring-red-200 {
            --tw-ring-color: rgb(var(--oc-danger-200-rgb)) !important;
        }
        .outcraft-page .ring-red-600\/20 {
            --tw-ring-color: rgb(var(--oc-danger-600-rgb) / 0.2) !important;
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
            stroke-width: var(--oc-icon-stroke-width) !important;
        }
        .outcraft-source-logo {
            display: inline-flex;
            width: 1.75rem;
            height: 1.75rem;
            align-items: center;
            justify-content: center;
        }
        .outcraft-source-logo svg {
            display: block;
            width: auto;
            height: auto;
            max-width: 100%;
            max-height: 100%;
        }
        .outcraft-source-logo-lg {
            width: 2.625rem;
            height: 2.625rem;
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
        .outcraft-label,
        .outcraft-badge,
        [data-outcraft-badge],
        .outcraft-page [class~="text-xs"][class~="font-medium"][class~="ring-inset"][class~="px-2"] {
            border-radius: 9999px !important;
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
        .outcraft-page main > section[data-campaign-builder] {
            width: 100% !important;
            max-width: none !important;
            margin-left: 0 !important;
            margin-right: 0 !important;
        }
        .outcraft-page [data-campaign-builder-content-shell] {
            box-sizing: border-box;
            width: 100%;
            max-width: 64rem;
            margin-left: auto;
            margin-right: auto;
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
        @property --outcraft-ai-border-angle {
            syntax: '<angle>';
            inherits: false;
            initial-value: 0deg;
        }
        @keyframes outcraft-ai-border-spin {
            to {
                --outcraft-ai-border-angle: 360deg;
            }
        }
        .outcraft-ai-button {
            position: relative;
            overflow: hidden;
            background:
                linear-gradient(#ffffff, #ffffff) padding-box,
                conic-gradient(
                    from var(--outcraft-ai-border-angle),
                    rgb(var(--oc-primary-600-rgb) / 0.2),
                    rgb(var(--oc-accent-500-rgb, 236 72 153) / 0.95),
                    rgb(var(--oc-primary-600-rgb) / 0.95),
                    rgb(var(--oc-accent-400-rgb, 244 114 182) / 0.95),
                    rgb(var(--oc-primary-600-rgb) / 0.2)
                ) border-box;
            animation: outcraft-ai-border-spin 2.6s linear infinite;
        }
        .outcraft-ai-button:hover:not(:disabled) {
            background:
                linear-gradient(#f9fafb, #f9fafb) padding-box,
                conic-gradient(
                    from var(--outcraft-ai-border-angle),
                    rgb(var(--oc-primary-600-rgb) / 0.28),
                    rgb(var(--oc-accent-500-rgb, 236 72 153) / 1),
                    rgb(var(--oc-primary-600-rgb) / 1),
                    rgb(var(--oc-accent-400-rgb, 244 114 182) / 1),
                    rgb(var(--oc-primary-600-rgb) / 0.28)
                ) border-box;
        }
        .outcraft-ai-button:disabled {
            animation: none;
            background:
                linear-gradient(#ffffff, #ffffff) padding-box,
                linear-gradient(#d1d5db, #d1d5db) border-box;
        }
        .outcraft-ai-sparkles {
            width: 1.125rem;
            height: 1.125rem;
            flex-shrink: 0;
        }
        .outcraft-ai-sparkles path {
            fill: currentColor;
            transition: fill 150ms ease;
        }
        .outcraft-ai-sparkles path:first-child {
            animation: outcraft-ai-sparkle-primary 4.8s ease-in-out infinite;
        }
        .outcraft-ai-sparkles path:last-child {
            animation: outcraft-ai-sparkle-secondary 4.8s ease-in-out infinite;
        }
        @keyframes outcraft-ai-sparkle-primary {
            0%, 100% {
                fill: #1f2937;
            }
            50% {
                fill: #9ca3af;
            }
        }
        @keyframes outcraft-ai-sparkle-secondary {
            0%, 100% {
                fill: #9ca3af;
            }
            50% {
                fill: #1f2937;
            }
        }
        .outcraft-ai-button:disabled .outcraft-ai-sparkles path {
            animation: none;
            fill: currentColor;
        }
        .outcraft-page {
            --oc-builder-progress-start: 5.75rem;
            --oc-builder-step-content-start: 9.25rem;
        }
        .outcraft-page [data-campaign-setup-step],
        .outcraft-page [data-company-details-step-layout] {
            display: grid;
            gap: 2.5rem;
            align-items: start;
        }
        .outcraft-page [data-campaign-setup-step] > :not([hidden]) ~ :not([hidden]),
        .outcraft-page [data-company-details-step-layout] > :not([hidden]) ~ :not([hidden]) {
            margin-top: 0 !important;
        }
        .outcraft-page [data-campaign-setup-step] > :first-child,
        .outcraft-page [data-company-details-step-layout] > :first-child {
            min-width: 0;
        }
        .outcraft-page [data-campaign-setup-step] > :first-child > [data-step-icon-row],
        .outcraft-page [data-company-details-step-layout] > :first-child > [data-step-icon-row] {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 1rem;
            margin-bottom: 1rem;
        }
        .outcraft-page [data-campaign-setup-step] > :first-child > p:first-child {
            display: none;
        }
        .outcraft-page [data-campaign-setup-step] > :first-child h2,
        .outcraft-page [data-company-details-step-layout] > :first-child h2 {
            margin-top: 0;
            font-size: var(--oc-text-lg);
            line-height: var(--oc-leading-lg);
            font-weight: 600;
            letter-spacing: 0;
            color: #111827;
        }
        .outcraft-page [data-campaign-setup-step] > :first-child > p:nth-of-type(2),
        .outcraft-page [data-company-details-step-layout] > :first-child > p {
            margin-top: 0.25rem;
            max-width: 18rem;
            font-size: 0.875rem;
            line-height: 1.5rem;
            color: #6b7280;
        }
        @media (min-width: 1024px) {
            .outcraft-page [data-campaign-setup-step],
            .outcraft-page [data-company-details-step-layout] {
                grid-template-columns: 260px minmax(0, 1fr);
                column-gap: 4rem;
                row-gap: 1.5rem;
                position: relative;
                z-index: 10;
                padding: var(--oc-builder-step-content-start) 2rem 2rem;
            }
            .outcraft-page [data-campaign-setup-step] > :first-child > span:first-of-type,
            .outcraft-page [data-company-details-step-layout] > :first-child > span:first-of-type {
                position: absolute;
                left: 2rem;
                top: var(--oc-builder-progress-start);
                margin: 0 !important;
            }
            .outcraft-page [data-campaign-setup-step] > :first-child > [data-step-icon-row],
            .outcraft-page [data-company-details-step-layout] > :first-child > [data-step-icon-row] {
                position: absolute;
                left: 2rem;
                right: 2rem;
                top: var(--oc-builder-progress-start);
                margin: 0 !important;
            }
            .outcraft-page [data-campaign-setup-step] > :first-child > [data-step-icon-row] > :not(:first-child),
            .outcraft-page [data-company-details-step-layout] > :first-child > [data-step-icon-row] > :not(:first-child) {
                margin-top: calc(var(--oc-builder-step-content-start) - var(--oc-builder-progress-start));
            }
            .outcraft-page [data-campaign-setup-step] > :first-child > [data-step-icon-row][data-step-actions-align-top] > :not(:first-child),
            .outcraft-page [data-company-details-step-layout] > :first-child > [data-step-icon-row][data-step-actions-align-top] > :not(:first-child) {
                margin-top: 0 !important;
            }
            .outcraft-page [data-campaign-setup-step] > :first-child > [data-step-icon-row][data-step-actions-content-row],
            .outcraft-page [data-company-details-step-layout] > :first-child > [data-step-icon-row][data-step-actions-content-row] {
                display: grid;
                grid-template-columns: 260px minmax(0, 1fr);
                column-gap: 4rem;
                align-items: start;
            }
            .outcraft-page [data-campaign-setup-step] > :first-child > [data-step-icon-row][data-step-actions-content-row] > :first-child,
            .outcraft-page [data-company-details-step-layout] > :first-child > [data-step-icon-row][data-step-actions-content-row] > :first-child {
                grid-column: 1;
            }
            .outcraft-page [data-campaign-setup-step] > :first-child > [data-step-icon-row][data-step-actions-content-row] > :not(:first-child),
            .outcraft-page [data-company-details-step-layout] > :first-child > [data-step-icon-row][data-step-actions-content-row] > :not(:first-child) {
                grid-column: 2;
            }
            .outcraft-page [data-campaign-setup-step] > :not(:first-child),
            .outcraft-page [data-company-details-step-layout] > :not(:first-child) {
                grid-column: 2;
                min-width: 0;
                min-height: 0;
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
            .outcraft-page [data-campaign-setup-step],
            .outcraft-page [data-company-details-step-layout] {
                grid-template-columns: minmax(0, 1fr) !important;
                gap: 1.5rem !important;
                padding: 1.25rem 1rem 5rem !important;
            }
            .outcraft-page [data-campaign-setup-step] > :first-child,
            .outcraft-page [data-campaign-setup-step] > :not(:first-child),
            .outcraft-page [data-company-details-step-layout] > :first-child,
            .outcraft-page [data-company-details-step-layout] > :not(:first-child) {
                grid-column: 1 / -1 !important;
                min-width: 0;
            }
            .outcraft-page [data-campaign-setup-step] > :first-child > p:nth-of-type(2),
            .outcraft-page [data-company-details-step-layout] > :first-child > p {
                max-width: none !important;
            }
            .outcraft-page [data-campaign-setup-step] > :first-child,
            .outcraft-page [data-company-details-step-layout] > :first-child {
                display: flex !important;
                flex-direction: column !important;
            }
            .outcraft-page [data-campaign-setup-step] > :first-child > [data-step-icon-row],
            .outcraft-page [data-company-details-step-layout] > :first-child > [data-step-icon-row] {
                display: contents !important;
            }
            .outcraft-page [data-campaign-setup-step] > :first-child > [data-step-icon-row] > :first-child,
            .outcraft-page [data-company-details-step-layout] > :first-child > [data-step-icon-row] > :first-child,
            .outcraft-page [data-campaign-setup-step] > :first-child > span:first-of-type,
            .outcraft-page [data-company-details-step-layout] > :first-child > span:first-of-type {
                order: 1;
                margin-bottom: 1rem !important;
            }
            .outcraft-page [data-campaign-setup-step] > :first-child h2,
            .outcraft-page [data-company-details-step-layout] > :first-child h2 {
                order: 2;
            }
            .outcraft-page [data-campaign-setup-step] > :first-child > p:nth-of-type(2),
            .outcraft-page [data-company-details-step-layout] > :first-child > p {
                order: 3;
            }
            .outcraft-page [data-campaign-setup-step] > :first-child > [data-step-icon-row] > :not(:first-child),
            .outcraft-page [data-company-details-step-layout] > :first-child > [data-step-icon-row] > :not(:first-child) {
                order: 4;
                align-self: stretch;
                margin-top: 1rem;
            }
            .outcraft-page [data-company-details-step-layout] form fieldset > .grid,
            .outcraft-page [data-campaign-setup-step] form fieldset > .grid {
                max-width: none !important;
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
                    class="group/notification relative inline-flex size-9 shrink-0 items-center justify-center rounded-md text-gray-400 transition-colors duration-200 ease-in-out group-hover/profile-row:text-indigo-600 hover:bg-gray-50 hover:text-indigo-600"
                    :class="sidebarOpen ? 'order-2' : 'order-1 mx-auto'"
                    title="Notifications"
                >
                    <span class="outcraft-icon text-[21px] leading-none">notifications</span>
                    <span class="absolute right-1 top-1 flex size-4 items-center justify-center rounded-full bg-indigo-600 text-xs font-semibold leading-none text-white ring-2 ring-white">3</span>
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
            campaignBuilderOpen ? ((campaignBuilderUsesSidebarLayout() || campaignBuilderUsesIntroLayout()) ? 'ml-0 bg-gray-50' : 'ml-0 bg-white') : (sidebarOpen ? 'ml-72' : 'ml-16'),
            'overflow-auto',
            ! campaignBuilderOpen && activeNav === 'Campaigns' ? 'bg-white' : '',
            ! campaignBuilderOpen && activeNav !== 'Campaigns' ? 'bg-gray-50' : '',
        ]"
    >
        <section x-cloak x-show="campaignBuilderOpen" data-campaign-builder class="relative min-h-full w-full" :class="(campaignBuilderUsesSidebarLayout() || campaignBuilderUsesIntroLayout()) ? '!m-0 bg-gray-50' : 'mx-6 mb-6 mt-6 bg-white'">
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

            <div x-show="! campaignBuilderUsesIntroLayout() && (campaignBuilderStep < companySetupStartStep() || campaignSetupModeSelected)" class="sticky top-0 z-30 flex items-center justify-between border-b border-gray-200 bg-gray-50 px-4 py-3 lg:hidden">
                <button type="button" x-on:click="campaignBuilderMobileProgressOpen = true" class="inline-flex size-9 items-center justify-center rounded-md bg-white text-gray-600 shadow-sm ring-1 ring-inset ring-gray-300 transition hover:bg-gray-50" aria-label="Open Progress Navigation">
                    <span class="outcraft-icon !text-[20px]">menu</span>
                </button>
                <span class="min-w-0 truncate text-sm font-semibold text-gray-700" x-text="campaignBuilderMobileProgressLabel()"></span>
            </div>

            <div
                x-cloak
                x-show="campaignBuilderMobileProgressOpen"
                x-transition.opacity
                x-on:keydown.escape.window="campaignBuilderMobileProgressOpen = false"
                class="fixed inset-0 z-[80] lg:hidden"
            >
                <button type="button" x-on:click="campaignBuilderMobileProgressOpen = false" class="absolute inset-0 bg-gray-950/30" aria-label="Close Progress Navigation"></button>
                <div
                    x-show="campaignBuilderMobileProgressOpen"
                    x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 -translate-x-full"
                    x-transition:enter-end="opacity-100 translate-x-0"
                    x-transition:leave="transition ease-in duration-150"
                    x-transition:leave-start="opacity-100 translate-x-0"
                    x-transition:leave-end="opacity-0 -translate-x-full"
                    class="absolute inset-y-0 left-0 flex w-80 max-w-[calc(100vw-3rem)] flex-col overflow-y-auto border-r border-gray-200 bg-white px-6 py-5 shadow-xl"
                    role="dialog"
                    aria-modal="true"
                    aria-label="Progress Navigation"
                >
                    <div class="flex items-center justify-between gap-3">
                        <button
                            type="button"
                            x-on:click="campaignBuilderMobileProgressOpen = false; handleCampaignBuilderBack()"
                            class="inline-flex h-9 min-w-0 items-center gap-2 rounded-md px-2 text-sm font-semibold text-gray-600 transition hover:bg-gray-50 hover:text-gray-950"
                        >
                            <span class="outcraft-icon !text-[18px]">arrow_back</span>
                            <span class="truncate" x-text="campaignBuilderBackLabel()"></span>
                        </button>
                        <button type="button" x-on:click="campaignBuilderMobileProgressOpen = false" class="inline-flex size-9 items-center justify-center rounded-md text-gray-400 transition hover:bg-gray-50 hover:text-gray-700" aria-label="Close Progress Navigation">
                            <span class="outcraft-icon !text-[20px]">close</span>
                        </button>
                    </div>

                    <nav x-show="campaignBuilderStep < companySetupStartStep()" class="mt-8" aria-label="Company setup progress">
                        <ol role="list" class="space-y-5">
                            <template x-for="(step, index) in companySetupSteps" :key="step.label">
                                <li>
                                    <button
                                        type="button"
                                        x-on:click="goToCampaignBuilderStep(index); campaignBuilderMobileProgressOpen = false"
                                        :disabled="index > campaignBuilderMaxStep"
                                        class="group flex w-full min-w-0 items-start gap-4 text-left disabled:cursor-not-allowed"
                                        :aria-current="campaignBuilderStep === index ? 'step' : null"
                                    >
                                        <span class="flex h-9 items-center">
                                            <span
                                                class="relative z-10 flex size-8 shrink-0 items-center justify-center rounded-full transition"
                                                :class="campaignBuilderStep === index ? 'border-2 oc-primary-border bg-white' : (campaignBuilderMaxStep > index ? 'border-2 oc-primary-border oc-primary-bg text-white' : 'border-2 border-gray-300 bg-white group-hover:border-gray-400')"
                                            >
                                                <span x-show="campaignBuilderMaxStep > index && campaignBuilderStep !== index" class="outcraft-icon !text-[18px] text-white">check</span>
                                                <span x-show="campaignBuilderStep === index" class="size-2.5 rounded-full oc-primary-bg"></span>
                                                <span x-show="campaignBuilderStep !== index && campaignBuilderMaxStep <= index" class="size-2.5 rounded-full bg-transparent group-hover:bg-gray-300"></span>
                                            </span>
                                        </span>
                                        <span class="min-w-0 pt-1">
                                            <span class="block text-sm font-semibold leading-6" :class="campaignBuilderStep === index ? 'oc-primary-text' : 'text-gray-950'" x-text="step.label"></span>
                                            <span class="block text-sm leading-5 text-gray-500" x-text="step.description"></span>
                                        </span>
                                    </button>
                                </li>
                            </template>
                        </ol>
                    </nav>

                    <nav x-show="campaignBuilderStep >= companySetupStartStep() && campaignSetupModeSelected" class="mt-8 space-y-6" aria-label="Campaign setup progress">
                        <ol role="list" class="space-y-5">
                            <template x-for="step in campaignSetupPrimaryTimelineSteps()" :key="step.id">
                                <li>
                                    <button
                                        type="button"
                                        x-on:click="setCampaignSetupStep(step.id); campaignBuilderMobileProgressOpen = false"
                                        class="group flex w-full min-w-0 items-start gap-4 text-left"
                                        :aria-current="campaignSetup.current === step.id ? 'step' : null"
                                    >
                                        <span class="flex h-9 items-center" x-html="campaignSetupStatusIcon(step.id, campaignSetupStepNumber(step.id))"></span>
                                        <span class="min-w-0 pt-1">
                                            <span class="block text-sm font-semibold leading-6" :class="campaignSetup.current === step.id ? 'oc-primary-text' : 'text-gray-950'" x-text="step.label"></span>
                                            <span class="block text-sm leading-5 text-gray-500" x-text="step.description"></span>
                                        </span>
                                    </button>
                                </li>
                            </template>
                        </ol>

                        <ol x-show="campaignSetupSecondaryTimelineSteps().length > 0" role="list" class="space-y-5 border-t border-gray-200 pt-6">
                            <template x-for="step in campaignSetupSecondaryTimelineSteps()" :key="step.id">
                                <li>
                                    <button
                                        type="button"
                                        x-on:click="setCampaignSetupStep(step.id); campaignBuilderMobileProgressOpen = false"
                                        class="group flex w-full min-w-0 items-start gap-4 text-left"
                                        :aria-current="campaignSetup.current === step.id ? 'step' : null"
                                    >
                                        <span class="flex h-9 items-center" x-html="campaignSetupStatusIcon(step.id, campaignSetupStepNumber(step.id))"></span>
                                        <span class="min-w-0 pt-1">
                                            <span class="block text-sm font-semibold leading-6" :class="campaignSetup.current === step.id ? 'oc-primary-text' : 'text-gray-950'" x-text="step.label"></span>
                                            <span class="block text-sm leading-5 text-gray-500" x-text="step.description"></span>
                                        </span>
                                    </button>
                                </li>
                            </template>
                        </ol>
                    </nav>
                </div>
            </div>

            <div x-ref="campaignBuilderScrollScene" :style="campaignBuilderScrollSceneStyle()" class="relative flex w-full items-start" :class="campaignBuilderUsesSidebarLayout() ? 'mx-0 min-h-full min-w-full max-w-none gap-0 bg-gray-50' : (campaignBuilderUsesIntroLayout() ? 'mx-0 min-h-full max-w-none bg-gray-50 px-4 py-6 sm:px-6 lg:px-8' : 'mx-auto max-w-7xl gap-12 xl:gap-16')">
                <aside x-ref="campaignBuilderProgressAside" x-show="! campaignBuilderUsesIntroLayout() && (campaignBuilderStep < companySetupStartStep() || campaignSetupModeSelected)" class="hidden shrink-0 lg:block" :class="[campaignBuilderUsesIntroLayout() ? '!hidden' : '', campaignBuilderUsesSidebarLayout() ? 'min-h-screen w-80 border-r border-gray-200 bg-white px-8 py-6' : 'w-72']" :style="campaignBuilderProgressStickyStyle()">
                    <div>
                    <div x-ref="campaignBuilderProgressColumn">
                    <div class="mb-8 flex items-center justify-between gap-3">
                        <button
                            type="button"
                            x-on:click="handleCampaignBuilderBack()"
                            class="inline-flex h-9 min-w-0 items-center gap-2 rounded-md px-2 text-sm font-semibold text-gray-600 transition hover:bg-gray-50 hover:text-gray-950"
                        >
                            <span class="outcraft-icon !text-[18px]">arrow_back</span>
                            <span class="truncate" x-text="campaignBuilderBackLabel()"></span>
                        </button>
                        <div
                            class="relative shrink-0"
                            x-data="{ setupModeMenuOpen: false }"
                            x-on:click.outside="setupModeMenuOpen = false"
                        >
                            <button type="button" x-on:click="setupModeMenuOpen = ! setupModeMenuOpen" class="inline-flex size-9 items-center justify-center rounded-md text-gray-500 transition hover:bg-gray-100 hover:text-gray-900" aria-label="Progress and setup options">
                                <span class="outcraft-icon !text-[18px]">more_vert</span>
                            </button>
                            <div x-cloak x-show="setupModeMenuOpen" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-1" class="absolute right-0 z-40 mt-2 w-60 rounded-md bg-white py-1 shadow-lg ring-1 ring-black/5" role="menu">
                                <div class="pb-1">
                                    <p class="px-2 py-1 text-xs font-semibold uppercase tracking-wide text-gray-400">Progress Bar</p>
                                    <button type="button" x-on:click="setProgressBarStyle('timeline'); setupModeMenuOpen = false" class="flex w-full items-center justify-between px-3 py-2 text-left text-sm font-medium transition" :class="progressBarStyle === 'timeline' ? 'text-gray-950' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-950'" role="menuitem">
                                        <span>Timeline</span>
                                        <span x-show="progressBarStyle === 'timeline'" class="outcraft-icon !text-[16px] text-indigo-600">check</span>
                                    </button>
                                    <button type="button" x-on:click="setProgressBarStyle('bulletlist'); setupModeMenuOpen = false" class="flex w-full items-center justify-between px-3 py-2 text-left text-sm font-medium transition" :class="progressBarStyle === 'bulletlist' ? 'text-gray-950' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-950'" role="menuitem">
                                        <span>Bulletlist</span>
                                        <span x-show="progressBarStyle === 'bulletlist'" class="outcraft-icon !text-[16px] text-indigo-600">check</span>
                                    </button>
                                </div>
                                <div x-show="campaignBuilderStep >= companySetupStartStep() && campaignSetupModeSelected" class="mt-1 border-t border-gray-100 pt-1">
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
                                <div x-show="campaignBuilderStep >= companySetupStartStep() && campaignSetupModeSelected && campaignSetup.current === 'brief'" class="mt-1 border-t border-gray-100 pt-1">
                                    <p class="px-2 py-1 text-xs font-semibold uppercase tracking-wide text-gray-400">Campaign Context</p>
                                    <button type="button" x-on:click="campaignSetup.briefTab = 'builder'; setupModeMenuOpen = false; scheduleCampaignBuilderLayoutUpdate()" class="flex w-full items-center justify-between px-3 py-2 text-left text-sm font-medium transition" :class="campaignSetup.briefTab === 'builder' ? 'text-gray-950' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-950'" role="menuitem">
                                        <span>Option Three</span>
                                        <span x-show="campaignSetup.briefTab === 'builder'" class="outcraft-icon !text-[16px] text-indigo-600">check</span>
                                    </button>
                                    <button type="button" x-on:click="campaignSetup.briefTab = 'context'; setupModeMenuOpen = false; scheduleCampaignBuilderLayoutUpdate()" class="flex w-full items-center justify-between px-3 py-2 text-left text-sm font-medium transition" :class="campaignSetup.briefTab === 'context' ? 'text-gray-950' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-950'" role="menuitem">
                                        <span>Original</span>
                                        <span x-show="campaignSetup.briefTab === 'context'" class="outcraft-icon !text-[16px] text-indigo-600">check</span>
                                    </button>
                                    <button type="button" x-on:click="campaignSetup.briefTab = 'discovery'; setupModeMenuOpen = false; scheduleCampaignBuilderLayoutUpdate()" class="flex w-full items-center justify-between px-3 py-2 text-left text-sm font-medium transition" :class="campaignSetup.briefTab === 'discovery' ? 'text-gray-950' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-950'" role="menuitem">
                                        <span>Option Two</span>
                                        <span x-show="campaignSetup.briefTab === 'discovery'" class="outcraft-icon !text-[16px] text-indigo-600">check</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <nav x-show="campaignBuilderStep < companySetupStartStep() && progressBarStyle === 'timeline'" x-ref="companySetupProgressNav" aria-label="Company setup progress">
                        <ol role="list" class="space-y-6">
                            <template x-for="(step, index) in companySetupSteps" :key="step.label">
                                <li class="relative flex gap-4">
                                    <span
                                        x-show="index !== companySetupSteps.length - 1"
                                        class="absolute left-[15px] top-0 -bottom-10 w-0.5"
                                        :class="campaignBuilderMaxStep > index ? 'oc-primary-bg' : 'bg-gray-200'"
                                    ></span>
                                    <button type="button" x-on:click="goToCampaignBuilderStep(index)" :disabled="index > campaignBuilderMaxStep" class="group flex min-w-0 items-start gap-4 text-left disabled:cursor-not-allowed">
                                        <span class="flex h-9 items-center">
                                            <span
                                                class="relative z-10 flex size-8 shrink-0 items-center justify-center rounded-full transition"
                                                :class="campaignBuilderStep === index ? 'border-2 oc-primary-border bg-white' : (campaignBuilderMaxStep > index ? 'border-2 oc-primary-border oc-primary-bg text-white' : 'border-2 border-gray-300 bg-white group-hover:border-gray-400')"
                                            >
                                                <span x-show="campaignBuilderMaxStep > index && campaignBuilderStep !== index" class="outcraft-icon !text-[18px] text-white">check</span>
                                                <span x-show="campaignBuilderStep === index" class="size-2.5 rounded-full oc-primary-bg"></span>
                                                <span x-show="campaignBuilderStep !== index && campaignBuilderMaxStep <= index" class="size-2.5 rounded-full bg-transparent group-hover:bg-gray-300"></span>
                                            </span>
                                        </span>
                                        <span class="min-w-0 pt-1">
                                            <span class="block text-sm font-semibold leading-6" :class="campaignBuilderStep === index ? 'oc-primary-text' : 'text-gray-950'" x-text="step.label"></span>
                                            <span class="block text-sm leading-5 text-gray-500" x-text="step.description"></span>
                                        </span>
                                    </button>
                                </li>
                            </template>
                        </ol>
                    </nav>

                    <nav x-show="campaignBuilderStep < companySetupStartStep() && progressBarStyle === 'bulletlist'" x-ref="companySetupProgressBulletNav" aria-label="Company setup progress">
                        <ol role="list" class="space-y-6">
                            <template x-for="(step, index) in companySetupSteps" :key="step.label">
                                <li>
                                    <button
                                        type="button"
                                        x-on:click="goToCampaignBuilderStep(index)"
                                        :disabled="index > campaignBuilderMaxStep"
                                        :aria-current="campaignBuilderStep === index ? 'step' : null"
                                        class="group flex w-full min-w-0 items-start text-left disabled:cursor-not-allowed"
                                    >
                                        <span class="relative flex size-5 shrink-0 items-center justify-center">
                                            <svg x-show="campaignBuilderMaxStep > index && campaignBuilderStep !== index" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" class="size-full oc-primary-text transition">
                                                <path d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16Zm3.857-9.809a.75.75 0 0 0-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 1 0-1.06 1.061l2.5 2.5a.75.75 0 0 0 1.137-.089l4-5.5Z" clip-rule="evenodd" fill-rule="evenodd" />
                                            </svg>
                                            <span x-show="campaignBuilderStep === index" aria-hidden="true" class="relative flex size-5 shrink-0 items-center justify-center">
                                                <span class="absolute size-4 rounded-full oc-primary-bg-soft"></span>
                                                <span class="relative block size-2 rounded-full oc-primary-bg"></span>
                                            </span>
                                            <span x-show="campaignBuilderStep !== index && campaignBuilderMaxStep <= index" aria-hidden="true" class="relative flex size-5 shrink-0 items-center justify-center">
                                                <span class="size-2 rounded-full bg-gray-300 transition group-hover:bg-gray-400"></span>
                                            </span>
                                        </span>
                                        <span class="ml-3 min-w-0 text-sm font-medium leading-5 transition" :class="campaignBuilderStep === index ? 'oc-primary-text' : 'text-gray-500 group-hover:text-gray-900'" x-text="step.label"></span>
                                        <span class="sr-only" x-text="step.description"></span>
                                    </button>
                                </li>
                            </template>
                        </ol>
                    </nav>

                    <nav x-show="campaignBuilderStep >= companySetupStartStep() && campaignSetupModeSelected && progressBarStyle === 'timeline'" aria-label="Campaign setup progress" class="space-y-5">
                        <ol role="list" class="space-y-4">
                            <template x-for="(step, index) in campaignSetupPrimaryTimelineSteps()" :key="step.id">
                                <li class="relative flex gap-4">
                                    <span x-show="index !== campaignSetupPrimaryTimelineSteps().length - 1" class="absolute left-[15px] top-0 -bottom-8 w-0.5" :class="campaignSetupStatus(step.id) === 'done' ? 'oc-primary-bg' : 'bg-gray-200'"></span>
                                    <button type="button" x-on:click="setCampaignSetupStep(step.id)" class="group flex min-w-0 items-start gap-4 text-left">
                                        <span class="flex h-9 items-center" x-html="campaignSetupStatusIcon(step.id, campaignSetupStepNumber(step.id))"></span>
                                        <span class="min-w-0 pt-1">
                                            <span class="block text-sm font-semibold leading-6" :class="campaignSetup.current === step.id ? 'oc-primary-text' : 'text-gray-950'" x-text="step.label"></span>
                                            <span class="block text-sm leading-5 text-gray-500" x-text="step.description"></span>
                                        </span>
                                    </button>
                                </li>
                            </template>
                        </ol>

                        <ol x-show="campaignSetupSecondaryTimelineSteps().length > 0" role="list" class="mt-8 space-y-4 border-t border-gray-200 pt-6">
                            <template x-for="(step, index) in campaignSetupSecondaryTimelineSteps()" :key="step.id">
                                <li class="relative flex gap-4">
                                    <span x-show="index !== campaignSetupSecondaryTimelineSteps().length - 1" class="absolute left-[15px] top-0 -bottom-8 w-0.5" :class="campaignSetupStatus(step.id) === 'done' ? 'oc-primary-bg' : 'bg-gray-200'"></span>
                                    <button type="button" x-on:click="setCampaignSetupStep(step.id)" class="group flex min-w-0 items-start gap-4 text-left">
                                        <span class="flex h-9 items-center" x-html="campaignSetupStatusIcon(step.id, campaignSetupStepNumber(step.id))"></span>
                                        <span class="min-w-0 pt-1">
                                            <span class="block text-sm font-semibold leading-6" :class="campaignSetup.current === step.id ? 'oc-primary-text' : 'text-gray-950'" x-text="step.label"></span>
                                            <span class="block text-sm leading-5 text-gray-500" x-text="step.description"></span>
                                        </span>
                                    </button>
                                </li>
                            </template>
                        </ol>
                    </nav>

                    <nav x-show="campaignBuilderStep >= companySetupStartStep() && campaignSetupModeSelected && progressBarStyle === 'bulletlist'" aria-label="Campaign setup progress" class="space-y-6">
                        <ol role="list" class="space-y-6">
                            <template x-for="(step, index) in campaignSetupPrimaryTimelineSteps()" :key="step.id">
                                <li>
                                    <button
                                        type="button"
                                        x-on:click="setCampaignSetupStep(step.id)"
                                        :aria-current="campaignSetup.current === step.id ? 'step' : null"
                                        class="group flex w-full min-w-0 items-start text-left"
                                    >
                                        <span class="relative flex size-5 shrink-0 items-center justify-center">
                                            <svg x-show="campaignSetupStatus(step.id) === 'done'" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" class="size-full oc-primary-text transition">
                                                <path d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16Zm3.857-9.809a.75.75 0 0 0-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 1 0-1.06 1.061l2.5 2.5a.75.75 0 0 0 1.137-.089l4-5.5Z" clip-rule="evenodd" fill-rule="evenodd" />
                                            </svg>
                                            <span x-show="campaignSetup.current === step.id" aria-hidden="true" class="relative flex size-5 shrink-0 items-center justify-center">
                                                <span class="absolute size-4 rounded-full oc-primary-bg-soft"></span>
                                                <span class="relative block size-2 rounded-full oc-primary-bg"></span>
                                            </span>
                                            <span x-show="campaignSetup.current !== step.id && campaignSetupStatus(step.id) !== 'done'" aria-hidden="true" class="relative flex size-5 shrink-0 items-center justify-center">
                                                <span class="size-2 rounded-full bg-gray-300 transition group-hover:bg-gray-400"></span>
                                            </span>
                                        </span>
                                        <span class="ml-3 min-w-0 text-sm font-medium leading-5 transition" :class="campaignSetup.current === step.id ? 'oc-primary-text' : 'text-gray-500 group-hover:text-gray-900'" x-text="step.label"></span>
                                        <span class="sr-only" x-text="step.description"></span>
                                    </button>
                                </li>
                            </template>
                        </ol>

                        <ol x-show="campaignSetupSecondaryTimelineSteps().length > 0" role="list" class="space-y-6 border-t border-gray-200 pt-6">
                            <template x-for="(step, index) in campaignSetupSecondaryTimelineSteps()" :key="step.id">
                                <li>
                                    <button
                                        type="button"
                                        x-on:click="setCampaignSetupStep(step.id)"
                                        :aria-current="campaignSetup.current === step.id ? 'step' : null"
                                        class="group flex w-full min-w-0 items-start text-left"
                                    >
                                        <span class="relative flex size-5 shrink-0 items-center justify-center">
                                            <svg x-show="campaignSetupStatus(step.id) === 'done'" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" class="size-full oc-primary-text transition">
                                                <path d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16Zm3.857-9.809a.75.75 0 0 0-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 1 0-1.06 1.061l2.5 2.5a.75.75 0 0 0 1.137-.089l4-5.5Z" clip-rule="evenodd" fill-rule="evenodd" />
                                            </svg>
                                            <span x-show="campaignSetup.current === step.id" aria-hidden="true" class="relative flex size-5 shrink-0 items-center justify-center">
                                                <span class="absolute size-4 rounded-full oc-primary-bg-soft"></span>
                                                <span class="relative block size-2 rounded-full oc-primary-bg"></span>
                                            </span>
                                            <span x-show="campaignSetup.current !== step.id && campaignSetupStatus(step.id) !== 'done'" aria-hidden="true" class="relative flex size-5 shrink-0 items-center justify-center">
                                                <span class="size-2 rounded-full bg-gray-300 transition group-hover:bg-gray-400"></span>
                                            </span>
                                        </span>
                                        <span class="ml-3 min-w-0 text-sm font-medium leading-5 transition" :class="campaignSetup.current === step.id ? 'oc-primary-text' : 'text-gray-500 group-hover:text-gray-900'" x-text="step.label"></span>
                                        <span class="sr-only" x-text="step.description"></span>
                                    </button>
                                </li>
                            </template>
                        </ol>
                    </nav>
                    </div>
                    </div>
                </aside>

                <div class="min-w-0" :class="[(campaignBuilderUsesSidebarLayout() || campaignBuilderUsesIntroLayout()) ? 'min-h-full w-full flex-1 self-stretch bg-gray-50' : 'flex-1', campaignBuilderStep >= companySetupStartStep() && ! campaignSetupModeSelected ? 'w-full' : '']">
                <div x-ref="campaignBuilderContentScroll" class="min-w-0" :class="(campaignBuilderUsesSidebarLayout() || campaignBuilderUsesIntroLayout()) ? 'min-h-full w-full min-w-0 bg-gray-50' : 'flex-1 lg:pt-[78px]'">
                    <div x-show="campaignBuilderStep < companySetupStartStep()" x-ref="companyDetailsFormStage" x-effect="campaignBuilderStep; companyForm.pronunciationEnabled; updateCampaignBuilderStickyLayout(); updateCampaignBuilderBottomPadding()" data-campaign-builder-content-shell class="relative w-full [overflow-anchor:none] lg:flex lg:flex-col" :style="`padding-bottom: ${campaignBuilderBottomPadding}px;`">
                        <section
                            x-cloak
                            x-show="campaignBuilderStep === 0 || campaignBuilderScrollFromStep === 0"
                            x-ref="companyChooseSection"
                            :style="campaignBuilderCompanyStepStyle(0)"
                            class="space-y-7 pr-2 pb-14"
                        >
                            <div data-company-details-step-layout class="grid grid-cols-1 gap-x-8 gap-y-10 md:grid-cols-3">
                                <div>
                                    <span class="mb-4 flex size-10 items-center justify-center rounded-md bg-indigo-50 text-indigo-600">
                                        <span class="outcraft-icon !text-[21px]" x-text="companySetupStepIcon(0)"></span>
                                    </span>
                                    <h2 class="text-base/7 font-semibold text-gray-900">Create or Choose Company</h2>
                                    <p class="mt-1 text-sm/6 text-gray-500">Choose an existing company profile or create a new one before setting up campaigns.</p>
                                </div>

                                <div class="md:col-span-2">
                                    <div class="space-y-3">
                                        <template x-for="company in companySetupDemoCompanies" :key="company.id">
                                            <button
                                                type="button"
                                                x-on:click="chooseExistingCompanyForSetup(company.id)"
                                                class="flex w-full items-center gap-4 rounded-lg bg-white p-4 text-left shadow-sm outline outline-1 -outline-offset-1 outline-gray-300 transition hover:outline-2 hover:-outline-offset-2 hover:outline-indigo-600 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
                                            >
                                                <span class="flex size-10 shrink-0 items-center justify-center rounded-md bg-indigo-50 text-sm font-bold text-indigo-600" x-text="company.name.slice(0, 1)"></span>
                                                <span class="min-w-0">
                                                    <span class="block text-sm font-semibold leading-6 text-gray-950" x-text="company.name"></span>
                                                    <span class="block text-sm leading-6 text-gray-500" x-text="company.website"></span>
                                                </span>
                                            </button>
                                        </template>

                                        <button
                                            type="button"
                                            x-on:click="chooseNewCompanyForSetup()"
                                            class="flex w-full items-center gap-4 rounded-lg bg-white p-4 text-left shadow-sm outline outline-1 -outline-offset-1 outline-gray-300 transition hover:outline-2 hover:-outline-offset-2 hover:outline-indigo-600 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
                                        >
                                            <span class="flex size-10 shrink-0 items-center justify-center rounded-md bg-indigo-50 text-indigo-600">
                                                <span class="outcraft-icon !text-[20px]">plus</span>
                                            </span>
                                            <span class="min-w-0">
                                                <span class="block text-sm font-semibold leading-6 text-gray-950">Create New Company</span>
                                                <span class="block text-sm leading-6 text-gray-500">Start a fresh company profile for this campaign setup.</span>
                                            </span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </section>

                        <section
                            x-cloak
                            x-show="campaignBuilderStep === 1 || campaignBuilderScrollFromStep === 1"
                            x-ref="companyIdentitySection"
                            :style="campaignBuilderCompanyStepStyle(1)"
                            class="space-y-7 pr-2 pb-14"
                        >
                            <div data-company-details-step-layout class="grid grid-cols-1 gap-x-8 gap-y-10 md:grid-cols-3">
                                <div>
                                    <span class="mb-4 flex size-10 items-center justify-center rounded-md bg-indigo-50 text-indigo-600">
                                        <span class="outcraft-icon !text-[21px]" x-text="companySetupStepIcon(1)"></span>
                                    </span>
                                    <h2 class="text-base/7 font-semibold text-gray-900">Company Identity</h2>
                                    <p class="mt-1 text-sm/6 text-gray-500">Please complete your company details. This helps our AI understand your business, adapt to your context, and prepare for more accurate conversations with your leads.</p>
                                </div>

                                <form x-on:submit.prevent="submitCampaignBuilderStep(1)" novalidate class="md:col-span-2">
                                    <fieldset :disabled="campaignBuilderStep !== 1">
                                        <div class="grid w-full grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                                        <div class="sm:col-span-3">
                                            <label class="block text-sm/6 font-medium text-gray-900">Company Name<span class="text-indigo-400">*</span></label>
                                            <input data-campaign-field="name" x-model="companyForm.name" x-on:input="clearCampaignBuilderError('name')" :aria-invalid="Boolean(campaignBuilderErrors.name)" required type="text" placeholder="Enter your company legal name" class="mt-2 block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline outline-1 -outline-offset-1 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 disabled:bg-gray-50 disabled:text-gray-500 sm:text-sm/6" :class="campaignBuilderErrors.name ? 'outline-red-300 focus:outline-red-600' : 'outline-gray-300'">
                                            <p x-show="campaignBuilderErrors.name" x-text="campaignBuilderErrors.name" class="mt-2 text-sm/6 text-red-600"></p>
                                        </div>

                                        <div class="sm:col-span-3">
                                            <label class="block text-sm/6 font-medium text-gray-900">Company Website<span class="text-indigo-400">*</span></label>
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
                                    <div x-show="campaignBuilderStep === 1" data-campaign-step-actions class="hidden">
                                        <button type="submit" class="inline-flex items-center gap-2 rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Continue Manually<span class="outcraft-icon !text-[18px]">arrow_downward</span></button>
                                    </div>
                                </form>
                            </div>
                        </section>

                        <section
                            x-cloak
                            x-show="campaignBuilderStep === 2 || campaignBuilderScrollFromStep === 2"
                            x-ref="industryMarketSection"
                            :style="campaignBuilderCompanyStepStyle(2)"
                            data-company-details-step-layout
                            class="grid grid-cols-1 gap-x-8 gap-y-10 pr-2 pb-14 md:grid-cols-3"
                        >
                            <div>
                                <div data-step-icon-row>
                                    <span class="flex size-10 items-center justify-center rounded-md bg-indigo-50 text-indigo-600">
                                        <span class="outcraft-icon !text-[21px]" x-text="companySetupStepIcon(2)"></span>
                                    </span>
                                    <button type="button" :disabled="campaignBuilderStep !== 2" data-company-step-ai-action class="outcraft-ai-button inline-flex h-9 shrink-0 items-center justify-center gap-2 rounded-md border-2 border-transparent px-3 text-sm font-semibold text-gray-900 shadow-sm transition hover:text-gray-900 disabled:cursor-not-allowed disabled:text-gray-500 disabled:opacity-50">
                                        <svg class="outcraft-ai-sparkles" viewBox="0 0 105 103" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                            <path d="M31.6876 33.3482C33.0533 28.4835 39.9496 28.4835 41.3154 33.3482L44.4257 44.4273C46.3112 51.1432 51.5595 56.3915 58.2754 58.277L69.3545 61.3873C74.2192 62.7531 74.2192 69.6494 69.3545 71.0151L58.2754 74.1255C51.5595 76.0109 46.3112 81.2593 44.4257 87.9752L41.3154 99.0543C39.9496 103.919 33.0533 103.919 31.6876 99.0543L28.5772 87.9752C26.6918 81.2593 21.4434 76.0109 14.7275 74.1255L3.64844 71.0151C-1.21627 69.6494 -1.21627 62.7531 3.64844 61.3873L14.7275 58.277C21.4434 56.3915 26.6918 51.1432 28.5772 44.4273L31.6876 33.3482Z"/>
                                            <path d="M77.1504 2.91881C78.2429 -0.972965 83.76 -0.972956 84.8526 2.91881L87.046 10.7318C87.9887 14.0898 90.6129 16.714 93.9709 17.6567L101.784 19.8501C105.676 20.9427 105.676 26.4598 101.784 27.5523L93.9709 29.7458C90.6129 30.6885 87.9887 33.3127 87.046 36.6706L84.8526 44.4837C83.76 48.3754 78.2429 48.3754 77.1504 44.4837L74.9569 36.6706C74.0142 33.3127 71.39 30.6885 68.0321 29.7458L60.219 27.5523C56.3273 26.4598 56.3273 20.9427 60.219 19.8501L68.0321 17.6567C71.39 16.714 74.0142 14.0898 74.9569 10.7318L77.1504 2.91881Z"/>
                                        </svg>
                                        Fill with AI
                                    </button>
                                </div>
                                <h2 class="text-base/7 font-semibold text-gray-900">Industry & Market</h2>
                                <p class="mt-1 text-sm/6 text-gray-500">Market context, customer profile, differentiators, and FAQs for campaign reasoning.</p>
                            </div>

                            <form x-on:submit.prevent="submitCampaignBuilderStep(2)" novalidate class="md:col-span-2">
                                <fieldset :disabled="campaignBuilderStep !== 2">
                                    <div class="grid w-full grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                                        <div class="sm:col-span-3" x-data="{ industryOpen: false, industries: ['SaaS', 'Ecommerce', 'Healthcare', 'Financial Services', 'Consumer Services'] }" x-on:keydown.escape.window="industryOpen = false" x-on:click.outside="industryOpen = false">
                                            <label class="block text-sm/6 font-medium text-gray-900">Industry Vertical<span class="text-indigo-400">*</span></label>
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
                                            <label class="block text-sm/6 font-medium text-gray-900">Company Description<span class="text-indigo-400">*</span></label>
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
                                <div x-show="campaignBuilderStep === 2" data-campaign-step-actions class="hidden">
                                    <button type="button" x-on:click="previousCampaignBuilderStep()" class="inline-flex items-center gap-2 text-sm font-semibold leading-6 text-gray-900"><span class="outcraft-icon !text-[18px]">arrow_upward</span>Back</button>
                                    <button type="submit" class="inline-flex items-center gap-2 rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Continue<span class="outcraft-icon !text-[18px]">arrow_downward</span></button>
                                </div>
                            </form>
                        </section>

                        <section
                            x-cloak
                            x-show="campaignBuilderStep === 3 || campaignBuilderScrollFromStep === 3"
                            x-ref="complianceLegalSection"
                            :style="campaignBuilderCompanyStepStyle(3)"
                            data-company-details-step-layout
                            class="grid grid-cols-1 gap-x-8 gap-y-10 pr-2 pb-14 md:grid-cols-3"
                        >
                            <div>
                                <div data-step-icon-row>
                                    <span class="flex size-10 items-center justify-center rounded-md bg-indigo-50 text-indigo-600">
                                        <span class="outcraft-icon !text-[21px]" x-text="companySetupStepIcon(3)"></span>
                                    </span>
                                    <button type="button" :disabled="campaignBuilderStep !== 3" data-company-step-ai-action class="outcraft-ai-button inline-flex h-9 shrink-0 items-center justify-center gap-2 rounded-md border-2 border-transparent px-3 text-sm font-semibold text-gray-900 shadow-sm transition hover:text-gray-900 disabled:cursor-not-allowed disabled:text-gray-500 disabled:opacity-50">
                                        <svg class="outcraft-ai-sparkles" viewBox="0 0 105 103" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                            <path d="M31.6876 33.3482C33.0533 28.4835 39.9496 28.4835 41.3154 33.3482L44.4257 44.4273C46.3112 51.1432 51.5595 56.3915 58.2754 58.277L69.3545 61.3873C74.2192 62.7531 74.2192 69.6494 69.3545 71.0151L58.2754 74.1255C51.5595 76.0109 46.3112 81.2593 44.4257 87.9752L41.3154 99.0543C39.9496 103.919 33.0533 103.919 31.6876 99.0543L28.5772 87.9752C26.6918 81.2593 21.4434 76.0109 14.7275 74.1255L3.64844 71.0151C-1.21627 69.6494 -1.21627 62.7531 3.64844 61.3873L14.7275 58.277C21.4434 56.3915 26.6918 51.1432 28.5772 44.4273L31.6876 33.3482Z"/>
                                            <path d="M77.1504 2.91881C78.2429 -0.972965 83.76 -0.972956 84.8526 2.91881L87.046 10.7318C87.9887 14.0898 90.6129 16.714 93.9709 17.6567L101.784 19.8501C105.676 20.9427 105.676 26.4598 101.784 27.5523L93.9709 29.7458C90.6129 30.6885 87.9887 33.3127 87.046 36.6706L84.8526 44.4837C83.76 48.3754 78.2429 48.3754 77.1504 44.4837L74.9569 36.6706C74.0142 33.3127 71.39 30.6885 68.0321 29.7458L60.219 27.5523C56.3273 26.4598 56.3273 20.9427 60.219 19.8501L68.0321 17.6567C71.39 16.714 74.0142 14.0898 74.9569 10.7318L77.1504 2.91881Z"/>
                                        </svg>
                                        Fill with AI
                                    </button>
                                </div>
                                <h2 class="text-base/7 font-semibold text-gray-900">Compliance & Legal</h2>
                                <p class="mt-1 text-sm/6 text-gray-500">Support and policy details the agent can reference or route to.</p>
                            </div>

                            <form x-on:submit.prevent="submitCampaignBuilderStep(3)" novalidate class="md:col-span-2">
                                <fieldset :disabled="campaignBuilderStep !== 3">
                                    <div class="grid w-full grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                                        <div class="col-span-full rounded-lg border border-gray-200 bg-white p-5 sm:p-6">
                                            <div class="grid grid-cols-1 gap-x-6 gap-y-6 sm:grid-cols-6">
                                                <div class="sm:col-span-4">
                                                    <label class="block text-sm/6 font-medium text-gray-900">Support Email</label>
                                                    <input x-model="companyForm.supportEmail" type="email" placeholder="support@company.com" class="mt-2 block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 disabled:bg-gray-50 disabled:text-gray-500 sm:text-sm/6">
                                                    <p class="mt-2 text-sm leading-6 text-gray-500">Human support email.</p>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-span-full rounded-lg border border-gray-200 bg-white p-5 sm:p-6">
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

                                        <div class="col-span-full rounded-lg border border-gray-200 bg-white p-5 sm:p-6">
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
                                <div x-show="campaignBuilderStep === 3" data-campaign-step-actions class="hidden">
                                    <button type="button" x-on:click="previousCampaignBuilderStep()" class="inline-flex items-center gap-2 text-sm font-semibold leading-6 text-gray-900"><span class="outcraft-icon !text-[18px]">arrow_upward</span>Back</button>
                                    <button type="submit" class="inline-flex items-center gap-2 rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Continue to Campaign<span class="outcraft-icon !text-[18px]">arrow_forward</span></button>
                                </div>
                            </form>
                        </section>

                        <div x-show="campaignBuilderStep > 0 && campaignBuilderStep < companySetupStartStep()" class="fixed inset-x-0 bottom-0 z-40 mt-auto hidden border-t border-gray-200 bg-white/95 py-4 backdrop-blur lg:flex" :style="campaignBuilderActionBarStyle">
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
                                    <span class="outcraft-icon !text-[18px]" x-text="campaignBuilderStep === companySetupFinalStepIndex() ? 'arrow_forward' : 'arrow_downward'"></span>
                                </button>
                            </div>
                        </div>
                        <div x-show="campaignBuilderStep > 0 && campaignBuilderStep < companySetupStartStep()" class="fixed inset-x-0 bottom-0 z-40 flex items-center justify-between gap-3 border-t border-gray-200 bg-white/95 px-4 py-3 backdrop-blur lg:hidden">
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
                                <span class="outcraft-icon !text-[18px]" x-text="campaignBuilderStep === companySetupFinalStepIndex() ? 'arrow_forward' : 'arrow_downward'"></span>
                            </button>
                        </div>
                    </div>

			                    <div x-show="campaignBuilderStep >= companySetupStartStep()" x-ref="campaignAgentSection" :class="campaignSetupModeSelected && ! campaignSetupIntroStep ? '' : 'space-y-6'" :style="`padding-bottom: ${campaignSetupBottomPadding}px;`">
			                        <div x-show="! campaignSetupModeSelected" class="relative mx-auto flex min-h-[calc(100vh-96px)] w-full max-w-7xl flex-col items-center justify-center px-0 lg:px-4">
		                            <div x-show="campaignSetupIntroStep === 'type'" class="mx-auto w-full space-y-8 lg:max-w-[calc(80rem-18rem-3rem)] xl:max-w-[calc(80rem-18rem-4rem)]">
                                <div class="flex justify-start">
                                    <button type="button" x-on:click="handleCampaignBuilderBack()" class="inline-flex h-9 w-fit items-center gap-2 rounded-md px-2 text-sm font-semibold text-gray-600 transition hover:bg-gray-50 hover:text-gray-950">
                                        <span class="outcraft-icon !text-[18px]">arrow_back</span>
                                        <span x-text="campaignBuilderBackLabel()"></span>
                                    </button>
                                </div>
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
                                                    <span class="mb-4 flex size-10 shrink-0 items-center justify-center rounded-md bg-indigo-50 text-indigo-600">
                                                        <span class="outcraft-icon !text-[21px]" x-text="type.icon"></span>
                                                    </span>
                                                    <span class="block text-sm font-bold text-gray-950" x-text="type.name"></span>
                                                    <span class="mt-1 block text-sm leading-6 text-gray-500" x-text="type.description"></span>
                                                    <span class="mt-3 inline-flex rounded-md bg-gray-50 px-2 py-1 text-xs font-medium text-gray-700 ring-1 ring-inset ring-gray-600/10" x-text="campaignTypeDirection(type.name)"></span>
                                                </button>
                                            </template>
                                        </div>
                                    </div>
                                </template>
                            </div>

	                            <div x-show="campaignSetupIntroStep === 'source'" class="mx-auto w-full space-y-8 lg:max-w-[calc(80rem-18rem-3rem)] xl:max-w-[calc(80rem-18rem-4rem)]">
                                <div class="flex justify-start">
                                    <button type="button" x-on:click="handleCampaignBuilderBack()" class="inline-flex h-9 w-fit items-center gap-2 rounded-md px-2 text-sm font-semibold text-gray-600 transition hover:bg-gray-50 hover:text-gray-950">
                                        <span class="outcraft-icon !text-[18px]">arrow_back</span>
                                        <span x-text="campaignBuilderBackLabel()"></span>
                                    </button>
                                </div>
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
                                                    <span class="mb-4 flex size-10 shrink-0 items-center justify-center rounded-md" :class="leadSourceLogos[source.name] ? 'bg-gray-100 text-gray-700' : 'bg-indigo-50 text-indigo-600'">
                                                        <span x-show="leadSourceLogos[source.name]" class="outcraft-source-logo" x-html="leadSourceLogos[source.name]"></span>
                                                        <span x-show="! leadSourceLogos[source.name]" class="outcraft-icon !text-[21px]" x-text="source.icon"></span>
                                                    </span>
                                                    <span class="block text-sm font-bold text-gray-950" x-text="source.name"></span>
                                                    <span class="mt-2 block text-sm leading-6 text-gray-500" x-text="source.description"></span>
                                                </button>
                                            </template>
                                        </div>
                                    </div>
                                </template>
                            </div>

	                            <div x-show="campaignSetupIntroStep === 'integration' || campaignSetupIntroStep === 'mode'" class="absolute inset-x-0 top-0 z-10 mx-auto w-full lg:max-w-[calc(80rem-18rem-3rem)] xl:max-w-[calc(80rem-18rem-4rem)]">
                                <div class="flex justify-start">
                                    <button type="button" x-on:click="handleCampaignBuilderBack()" class="inline-flex h-9 w-fit items-center gap-2 rounded-md px-2 text-sm font-semibold text-gray-600 transition hover:bg-gray-50 hover:text-gray-950">
                                        <span class="outcraft-icon !text-[18px]">arrow_back</span>
                                        <span x-text="campaignBuilderBackLabel()"></span>
                                    </button>
                                </div>
                            </div>

	                            <div x-show="campaignSetupIntroStep === 'integration'" class="mx-auto w-full space-y-8 lg:max-w-[calc(80rem-18rem-3rem)] xl:max-w-[calc(80rem-18rem-4rem)]">
                                <div class="text-center">
                                    <h2 class="text-2xl font-bold leading-8 tracking-tight text-gray-950" x-text="campaignSetupHeading('integration')"></h2>
                                    <p class="mx-auto mt-2 max-w-2xl text-sm leading-6 text-gray-600" x-text="campaignSetupDescription('integration')"></p>
                                </div>
                                <div class="mx-auto max-w-2xl rounded-lg bg-white p-6 shadow-sm outline outline-1 -outline-offset-1 outline-gray-300">
                                    <div class="flex items-start gap-4">
                                        <span class="flex size-[60px] shrink-0 items-center justify-center rounded-md" :class="leadSourceLogoContainerClass(campaignSetup.source)">
                                            <span x-show="leadSourceLogos[campaignSetup.source]" class="outcraft-source-logo outcraft-source-logo-lg" x-html="leadSourceLogos[campaignSetup.source]"></span>
                                            <span x-show="! leadSourceLogos[campaignSetup.source]" class="outcraft-icon !text-[32px]" x-text="leadSourceIcon(campaignSetup.source)"></span>
                                        </span>
                                        <div class="min-w-0">
                                            <p class="text-xs font-semibold uppercase tracking-wide text-gray-400">Selected Lead Source</p>
                                            <h3 class="text-sm font-bold text-gray-950" x-text="campaignSetup.source || 'Lead Source'"></h3>
                                            <p class="mt-2 text-sm leading-6 text-gray-600">Connect your source to use real customer data, merge tags, and event triggers. You can skip this step, but AI will have less context to personalize conversations.</p>
                                        </div>
                                    </div>
                                    <div class="mt-6 flex flex-wrap gap-3">
                                        <button type="button" x-on:click="connectCampaignSource()" class="inline-flex h-9 items-center rounded-md bg-indigo-600 px-3 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-500" x-text="`Connect ${campaignSetup.source || 'Lead Source'}`"></button>
                                        <button type="button" x-on:click="requestSkipCampaignIntegration()" class="inline-flex h-9 items-center rounded-md bg-white px-3 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 transition hover:bg-gray-50">Setup Later</button>
                                    </div>
                                </div>
                            </div>

	                            <div x-show="campaignSetupIntroStep === 'mode'" class="mx-auto w-full space-y-8 lg:max-w-[calc(80rem-18rem-3rem)] xl:max-w-[calc(80rem-18rem-4rem)]">
                                <div class="text-center">
                                    <h2 class="text-2xl font-bold leading-8 tracking-tight text-gray-950">Choose How You Want to Set Up Your Campaign</h2>
                                    <p class="mx-auto mt-2 max-w-2xl text-sm leading-6 text-gray-600">Pick a guided path. You can move faster with recommended defaults or configure every campaign setting manually.</p>
                                </div>
                                <div class="mx-auto grid w-full max-w-5xl auto-rows-fr items-stretch gap-4 md:grid-cols-2">
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

	                        <div x-show="campaignSetupModeSelected && ! campaignSetupIntroStep" x-ref="campaignSetupPanel" x-effect="campaignSetup.current; campaignSetupModeSelected; campaignSetupIntroStep; campaignSetup.channelOpen.calls; campaignSetup.channelOpen.email; campaignSetup.channelOpen.sms; campaignSetup.channelOpen.whatsapp; campaignSetup.scheduleMode; agentAdvancedOpen; scheduleCampaignBuilderLayoutUpdate()" class="relative z-10 bg-gray-50" :style="campaignSetupCanvasStyle">
                            <div x-ref="campaignSetupPanelScroller" data-campaign-builder-content-shell class="relative min-h-full w-full bg-gray-50 pb-24">
                            <section x-cloak x-show="campaignSetup.current === 'start' || campaignSetupScrollFromStep === 'start'" x-ref="campaignSetupStep_start"
                                :style="campaignSetupStepStyle('start')"
                                data-campaign-setup-step
                                class="space-y-6 pr-2 pb-4">
                                <div class="mb-1">
                                    <p class="text-sm font-semibold text-indigo-600" x-text="`${campaignSetupMode === 'fast' ? 'Fast Setup' : 'Advanced Setup'} · Step ${campaignSetupStepIndex('start') + 1} of ${campaignSetupStepsForMode().length}`"></p>
                                    <span class="mb-4 flex size-10 items-center justify-center rounded-md bg-indigo-50 text-indigo-600">
                                        <span class="outcraft-icon !text-[21px]" x-text="campaignSetupStepIcon('start')"></span>
                                    </span>
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
                                    <span class="mb-4 flex size-10 items-center justify-center rounded-md bg-indigo-50 text-indigo-600">
                                        <span class="outcraft-icon !text-[21px]" x-text="campaignSetupStepIcon('type')"></span>
                                    </span>
                                    <h2 class="mt-2 text-2xl font-bold leading-8 tracking-tight text-gray-950" x-text="campaignSetupHeading('type')"></h2>
                                    <p class="mt-2 max-w-3xl text-sm leading-6 text-gray-600" x-text="campaignSetupDescription('type')"></p>
                                </div>
                                <template x-for="group in campaignTypeGroups" :key="group.label">
                                    <div>
                                        <h3 class="text-sm font-semibold uppercase tracking-wide text-gray-400" x-text="group.label"></h3>
                                        <div class="mt-4 grid gap-4 md:grid-cols-2">
                                            <template x-for="type in group.items" :key="type.name">
                                                <button type="button" x-on:click="selectCampaignType(type.name)" class="flex h-full flex-col items-start rounded-lg bg-white p-5 text-left shadow-sm outline outline-1 -outline-offset-1 transition hover:outline-2 hover:-outline-offset-2 hover:outline-indigo-600 hover:shadow-sm focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600" :class="campaignSetup.type === type.name ? 'outline-2 -outline-offset-2 outline-indigo-600' : 'outline-gray-300'">
                                                    <span class="mb-4 flex size-10 shrink-0 items-center justify-center rounded-md bg-indigo-50 text-indigo-600">
                                                        <span class="outcraft-icon !text-[21px]" x-text="type.icon"></span>
                                                    </span>
                                                    <span class="block text-sm font-bold text-gray-950" x-text="type.name"></span>
                                                    <span class="mt-1 block text-sm leading-6 text-gray-500" x-text="type.description"></span>
                                                    <span class="mt-3 inline-flex rounded-md bg-gray-50 px-2 py-1 text-xs font-medium text-gray-700 ring-1 ring-inset ring-gray-600/10" x-text="campaignTypeDirection(type.name)"></span>
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
                                    <span class="mb-4 flex size-10 items-center justify-center rounded-md bg-indigo-50 text-indigo-600">
                                        <span class="outcraft-icon !text-[21px]" x-text="campaignSetupStepIcon('source')"></span>
                                    </span>
                                    <h2 class="mt-2 text-2xl font-bold leading-8 tracking-tight text-gray-950" x-text="campaignSetupHeading('source')"></h2>
                                    <p class="mt-2 max-w-3xl text-sm leading-6 text-gray-600" x-text="campaignSetupDescription('source')"></p>
                                </div>
                                <template x-for="group in leadSourceGroups" :key="group.label">
                                    <div>
                                        <h3 class="text-sm font-semibold uppercase tracking-wide text-gray-400" x-text="group.label"></h3>
                                        <div class="mt-4 grid gap-4 md:grid-cols-2">
                                            <template x-for="source in group.items" :key="source.name">
                                                <button type="button" x-on:click="selectLeadSource(source.name)" class="flex h-full flex-col items-start rounded-lg bg-white p-5 text-left shadow-sm outline outline-1 -outline-offset-1 transition hover:outline-2 hover:-outline-offset-2 hover:outline-indigo-600 hover:shadow-sm focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600" :class="campaignSetup.source === source.name ? 'outline-2 -outline-offset-2 outline-indigo-600' : 'outline-gray-300'">
                                                    <span class="mb-4 flex size-10 shrink-0 items-center justify-center rounded-md" :class="leadSourceLogos[source.name] ? 'bg-gray-100 text-gray-700' : 'bg-indigo-50 text-indigo-600'">
                                                        <span x-show="leadSourceLogos[source.name]" class="outcraft-source-logo" x-html="leadSourceLogos[source.name]"></span>
                                                        <span x-show="! leadSourceLogos[source.name]" class="outcraft-icon !text-[21px]" x-text="source.icon"></span>
                                                    </span>
                                                    <span class="block text-sm font-bold text-gray-950" x-text="source.name"></span>
                                                    <span class="mt-2 block text-sm leading-6 text-gray-500" x-text="source.description"></span>
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
                                    <span class="mb-4 flex size-10 items-center justify-center rounded-md bg-indigo-50 text-indigo-600">
                                        <span class="outcraft-icon !text-[21px]" x-text="campaignSetupStepIcon('integration')"></span>
                                    </span>
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
                                            <div class="flex items-start gap-4">
                                                <span class="flex size-[60px] shrink-0 items-center justify-center rounded-md" :class="leadSourceLogoContainerClass(campaignSetup.source)">
                                                    <span x-show="leadSourceLogos[campaignSetup.source]" class="outcraft-source-logo outcraft-source-logo-lg" x-html="leadSourceLogos[campaignSetup.source]"></span>
                                                    <span x-show="! leadSourceLogos[campaignSetup.source]" class="outcraft-icon !text-[32px]" x-text="leadSourceIcon(campaignSetup.source)"></span>
                                                </span>
                                                <div class="min-w-0">
                                                    <p class="text-xs font-semibold uppercase tracking-wide text-gray-400">Selected Lead Source</p>
                                                    <h3 class="text-base font-bold text-gray-950" x-text="campaignSetup.source || 'Lead Source'"></h3>
                                                    <p class="mt-2 max-w-2xl text-sm leading-6 text-gray-600">Connect your source to use real customer data, merge tags, and event triggers. You can skip this step, but AI will have less context to personalize conversations.</p>
                                                </div>
                                            </div>
                                        <span class="inline-flex rounded-md px-2 py-1 text-xs font-medium ring-1 ring-inset" :class="campaignSetup.integrationStatus === 'Connected' ? 'bg-green-50 text-green-700 ring-green-600/20' : campaignSetup.integrationStatus === 'Skipped for Now' ? 'bg-amber-50 text-amber-700 ring-amber-600/20' : 'bg-gray-50 text-gray-700 ring-gray-600/20'" x-text="campaignSetup.integrationStatus"></span>
                                        </div>
                                        <div class="mt-6 flex flex-wrap gap-3">
                                            <button type="button" x-on:click="connectCampaignSource()" class="inline-flex h-9 items-center rounded-md bg-indigo-600 px-3 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-500" x-text="`Connect ${campaignSetup.source || 'Source'}`"></button>
                                            <button type="button" x-on:click="requestSkipCampaignIntegration()" class="inline-flex h-9 items-center rounded-md bg-white px-3 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 transition hover:bg-gray-50">Setup Later</button>
                                        </div>
                                    </div>
                                </template>
                            </section>

                            <section x-cloak x-show="campaignSetup.current === 'brief' || campaignSetupScrollFromStep === 'brief'" x-ref="campaignSetupStep_brief"
                                :style="campaignSetupStepStyle('brief')"
                                data-campaign-setup-step
                                class="pr-2 pb-4">
                                <div class="mb-1">
                                    <p class="text-sm font-semibold text-indigo-600" x-text="`${campaignSetupMode === 'fast' ? 'Fast Setup' : 'Advanced Setup'} · Step ${campaignSetupStepIndex('brief') + 1} of ${campaignSetupStepsForMode().length}`"></p>
                                    <div data-step-icon-row data-step-actions-align-top>
                                        <span class="flex size-10 items-center justify-center rounded-md bg-indigo-50 text-indigo-600">
                                            <span class="outcraft-icon !text-[21px]" x-text="campaignSetupStepIcon('brief')"></span>
                                        </span>
                                        <button x-show="campaignSetup.briefTab === 'builder'" type="button" x-on:click="openBriefBuilderItemModal()" class="inline-flex h-9 w-full items-center justify-center rounded-md bg-indigo-600 px-3 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-500 sm:w-auto">Add Item</button>
                                    </div>
                                    <h2 class="mt-2 text-2xl font-bold leading-8 tracking-tight text-gray-950" x-text="campaignSetupHeading('brief')"></h2>
                                    <p class="mt-2 max-w-3xl text-sm leading-6 text-gray-600" x-text="campaignSetupDescription('brief')"></p>
                                </div>
                                <div x-show="campaignSetup.briefTab === 'context'" class="mt-6 space-y-7">
                                        <div>
                                            <div class="mb-2 flex items-center justify-between gap-3">
                                                <label class="block text-sm/6 font-semibold text-gray-900">Campaign Context & Instructions<span class="text-indigo-400">*</span></label>
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
                                                <label class="block text-sm/6 font-semibold text-gray-900">Qualification Questions<span class="text-indigo-400">*</span></label>
                                            </div>
                                            <textarea x-model="campaignSetup.brief.qualificationQuestions" rows="4" class="block w-full rounded-md bg-white px-3 py-2 text-sm/6 text-gray-700 shadow-sm outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600"></textarea>
                                            <p class="mt-2 text-sm leading-6 text-gray-500">List the key questions the AI should ask to determine whether the lead is a good fit for the offer.</p>
                                        </div>

                                        <div>
                                            <div class="mb-2 flex items-center justify-between gap-3">
                                                <label class="block text-sm/6 font-semibold text-gray-900">What Answers Confirm Qualification?<span class="text-indigo-400">*</span></label>
                                            </div>
                                            <textarea x-model="campaignSetup.brief.qualifiedAnswers" rows="4" class="block w-full rounded-md bg-white px-3 py-2 text-sm/6 text-gray-700 shadow-sm outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600"></textarea>
                                            <p class="mt-2 text-sm leading-6 text-gray-500">Enter one qualifying answer per line. If the lead meets these answers, they are considered qualified.</p>
                                        </div>
                                </div>
                                <div x-show="campaignSetup.briefTab === 'discovery'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-3" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-2" class="mt-6 space-y-7">
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
	                                        <p class="mt-2 text-sm leading-6 text-gray-500">Define what the AI should accomplish and when the conversation is considered successful.</p>
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
	                                        <p class="mt-2 text-sm leading-6 text-gray-500">Describe who the person is, why this conversation is happening, and what the AI must not assume.</p>
                                    </div>

                                    <div>
                                        <span class="block text-sm/6 font-semibold text-gray-900">Discovery Questions</span>
                                        <span class="mt-2 block text-sm leading-6 text-gray-500">List the key questions or information AI should collect.</span>

                                        <div class="mt-4 overflow-hidden rounded-lg border border-gray-200 bg-white">
                                            <div
                                                x-sortable
                                                data-sortable-animation-duration="150"
                                                x-on:end.stop="reorderFindOutQuestionsByIds($event.target.sortable.toArray())"
                                            >
                                                <template x-for="(question, index) in campaignSetup.brief.findOutQuestions" :key="question.id">
                                                    <div
                                                        x-bind:x-sortable-item="question.id"
                                                        class="flex items-center gap-3 border-b border-gray-200 px-4 py-3"
                                                    >
                                                        <button type="button" x-sortable-handle class="inline-flex size-8 cursor-grab items-center justify-center rounded-md text-gray-400 transition hover:bg-gray-50 hover:text-gray-700 active:cursor-grabbing" aria-label="Reorder Question">
                                                            <span class="outcraft-icon !text-[18px]">drag_indicator</span>
                                                        </button>
                                                        <span class="min-w-0 flex-1 text-sm leading-6 text-gray-900" x-text="question.text"></span>
                                                        <div class="relative shrink-0" x-on:click.outside="campaignSetup.brief.findOutAnswerFormatOpen === question.id && (campaignSetup.brief.findOutAnswerFormatOpen = null)">
                                                            <button type="button" x-on:click="campaignSetup.brief.findOutAnswerFormatOpen = campaignSetup.brief.findOutAnswerFormatOpen === question.id ? null : question.id" class="inline-flex items-center gap-1 rounded-md text-sm font-semibold transition focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600" :class="question.addToIntelligence ? 'text-indigo-600 hover:text-indigo-500' : 'text-gray-500 hover:text-gray-900'">
                                                                <span>Collect Answer</span>
                                                                <span class="outcraft-icon !text-[18px]">keyboard_arrow_down</span>
                                                            </button>
                                                            <div x-cloak x-show="campaignSetup.brief.findOutAnswerFormatOpen === question.id" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="opacity-0 translate-y-1" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-1" class="absolute right-0 z-30 mt-2 w-48 rounded-md bg-white py-1 shadow-lg ring-1 ring-gray-900/10">
                                                                <template x-for="format in campaignSetup.brief.findOutAnswerFormats" :key="format">
                                                                    <button type="button" x-on:click="selectFindOutQuestionAnswerFormat(index, format)" class="flex w-full items-center justify-between gap-3 px-3 py-2 text-left text-sm text-gray-700 transition hover:bg-gray-50 hover:text-gray-900">
                                                                        <span x-text="format"></span>
                                                                        <span x-show="question.answerFormat === format" class="outcraft-icon !text-[18px] text-indigo-600">check</span>
                                                                    </button>
                                                                </template>
                                                            </div>
                                                        </div>
                                                        <span x-show="question.addToIntelligence && question.answerFormat" class="inline-flex shrink-0 rounded-md bg-emerald-50 px-2 py-1 text-xs font-medium text-emerald-700 ring-1 ring-inset ring-emerald-600/20">Captured</span>
                                                        <button x-show="! (question.addToIntelligence && question.answerFormat)" type="button" x-on:click="captureFindOutQuestion(index); hideFloatingTooltip()" x-on:mouseenter="showFloatingTooltip($event, 'Capture for Conversation Intelligence', 240)" x-on:mouseleave="hideFloatingTooltip()" x-on:focus="showFloatingTooltip($event, 'Capture for Conversation Intelligence', 240)" x-on:blur="hideFloatingTooltip()" class="inline-flex size-8 shrink-0 items-center justify-center rounded-md text-gray-400 transition hover:bg-gray-50 hover:text-indigo-600 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600" aria-label="Capture for Conversation Intelligence">
                                                            <span class="outcraft-icon !text-[18px]">fact_check</span>
                                                        </button>
                                                        <button type="button" x-on:click="removeFindOutQuestion(index)" class="inline-flex size-8 shrink-0 items-center justify-center rounded-md text-gray-400 transition hover:bg-gray-50 hover:text-red-600 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-red-500" aria-label="Remove Question">
                                                            <span class="outcraft-icon !text-[18px]">delete</span>
                                                        </button>
                                                    </div>
                                                </template>
                                            </div>
                                            <div x-show="campaignSetup.brief.findOutQuestions.length === 0" class="border-b border-gray-200 px-4 py-4 text-sm text-gray-500">No Questions Added.</div>

                                            <form x-on:submit.prevent="addFindOutQuestion()" class="bg-white p-4 sm:flex sm:items-center sm:gap-3">
                                                <label class="block min-w-0 flex-1">
                                                    <span class="sr-only">Question</span>
                                                    <input x-model="campaignSetup.brief.newFindOutQuestion" type="text" placeholder="e.g. What problem are they trying to solve?" class="block w-full rounded-md bg-white px-3 py-1.5 text-sm/6 text-gray-900 shadow-sm outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600">
                                                </label>
                                                <button type="submit" :disabled="! String(campaignSetup.brief.newFindOutQuestion || '').trim()" class="mt-3 inline-flex h-9 items-center justify-center rounded-md bg-indigo-600 px-3 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-500 disabled:cursor-not-allowed disabled:opacity-40 sm:mt-0">Add Question</button>
                                            </form>
                                        </div>
                                    </div>
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
                                            <label class="block"><span class="block text-sm/6 font-semibold text-gray-900">Qualification Answers</span><textarea x-model="campaignSetup.brief.qualifiedAnswers" rows="4" class="mt-2 block w-full rounded-md bg-white px-3 py-2 text-sm/6 text-gray-700 shadow-sm outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600"></textarea><span class="mt-2 block text-sm leading-6 text-gray-500">Each line becomes one qualifying answer.</span></label>
                                        </div>
                                    </div>
                                </div>
                                <div x-show="campaignSetup.briefTab === 'builder'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-3" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-2" class="mt-6 space-y-5">
                                    <article class="rounded-lg border border-gray-200 bg-white p-5 shadow-sm">
                                        <div class="flex items-start justify-between gap-4">
                                            <div class="flex min-w-0 items-start gap-3">
                                                <span class="flex size-9 shrink-0 items-center justify-center rounded-md bg-indigo-50 text-indigo-600">
                                                    <span class="outcraft-icon !text-[19px]">target</span>
                                                </span>
                                                <div class="min-w-0">
                                                    <h3 class="text-base font-semibold leading-6 text-gray-950">Campaign Goal</h3>
                                                    <p class="mt-1 text-sm leading-6 text-gray-500">Define what the AI should accomplish and when the conversation is considered successful.</p>
                                                </div>
                                            </div>
                                            <span class="inline-flex rounded-md bg-indigo-50 px-2 py-1 text-xs font-medium text-indigo-700 ring-1 ring-inset ring-indigo-700/10">Required</span>
                                        </div>
                                        <textarea x-model="campaignSetup.brief.goal" rows="4" placeholder="What should this campaign achieve?" class="mt-4 block w-full rounded-md bg-white px-3 py-2 text-sm/6 text-gray-700 shadow-sm outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600"></textarea>
                                    </article>

                                    <article class="rounded-lg border border-gray-200 bg-white p-5 shadow-sm">
                                        <div class="flex items-start justify-between gap-4">
                                            <div class="flex min-w-0 items-start gap-3">
                                                <span class="flex size-9 shrink-0 items-center justify-center rounded-md bg-indigo-50 text-indigo-600">
                                                    <span class="outcraft-icon !text-[19px]">users</span>
                                                </span>
                                                <div class="min-w-0">
                                                    <h3 class="text-base font-semibold leading-6 text-gray-950">Lead Situation</h3>
                                                    <p class="mt-1 text-sm leading-6 text-gray-500">Describe who the person is, why this conversation is happening, and what the AI must not assume.</p>
                                                </div>
                                            </div>
                                            <span class="inline-flex rounded-md bg-indigo-50 px-2 py-1 text-xs font-medium text-indigo-700 ring-1 ring-inset ring-indigo-700/10">Required</span>
                                        </div>
                                        <textarea x-model="campaignSetup.brief.leadSituation" rows="4" placeholder="Who are these leads and why are we contacting them?" class="mt-4 block w-full rounded-md bg-white px-3 py-2 text-sm/6 text-gray-700 shadow-sm outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600"></textarea>
                                    </article>

                                    <template x-for="(item, index) in campaignSetup.brief.builderItems" :key="item.id">
                                        <article class="rounded-lg border border-gray-200 bg-white p-5 shadow-sm">
                                            <div class="flex items-start justify-between gap-4">
                                                <div class="flex min-w-0 items-start gap-3">
                                                    <span class="flex size-9 shrink-0 items-center justify-center rounded-md bg-indigo-50 text-indigo-600">
                                                        <span x-show="briefBuilderItemSvgIcon(item.type)" class="size-[21px]" x-html="briefBuilderItemSvgIcon(item.type)"></span>
                                                        <span x-show="! briefBuilderItemSvgIcon(item.type)" class="outcraft-icon !text-[19px]" x-text="briefBuilderItemIcon(item.type)"></span>
                                                    </span>
                                                    <div class="min-w-0">
                                                        <h3 class="text-base font-semibold leading-6 text-gray-950" x-text="briefBuilderItemTitle(item.type)"></h3>
                                                        <p class="mt-1 text-sm leading-6 text-gray-500" x-text="briefBuilderItemDescription(item.type)"></p>
                                                    </div>
                                                </div>
                                                <div class="relative shrink-0" x-on:click.outside="if (campaignSetup.briefBuilderItemActionOpen === item.id) campaignSetup.briefBuilderItemActionOpen = ''">
                                                    <button type="button" x-on:click="campaignSetup.briefBuilderItemActionOpen = campaignSetup.briefBuilderItemActionOpen === item.id ? '' : item.id" class="inline-flex size-8 items-center justify-center rounded-md text-gray-400 transition hover:bg-gray-50 hover:text-gray-700" aria-label="Item Actions">
                                                        <span class="outcraft-icon !text-[18px]">more_vert</span>
                                                    </button>
                                                    <div x-cloak x-show="campaignSetup.briefBuilderItemActionOpen === item.id" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="opacity-0 translate-y-1" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-1" class="absolute right-0 top-9 z-30 w-44 rounded-md bg-white p-1 text-sm shadow-lg ring-1 ring-gray-900/10">
                                                        <button type="button" x-on:click="moveBriefBuilderItem(index, -1)" :disabled="index === 0" class="flex w-full items-center gap-2 rounded-md px-3 py-2 text-left font-medium text-gray-700 transition hover:bg-gray-50 hover:text-gray-950 disabled:cursor-not-allowed disabled:opacity-40">
                                                            <span class="outcraft-icon !text-[16px] text-gray-400">arrow_upward</span>
                                                            Move Up
                                                        </button>
                                                        <button type="button" x-on:click="moveBriefBuilderItem(index, 1)" :disabled="index === campaignSetup.brief.builderItems.length - 1" class="flex w-full items-center gap-2 rounded-md px-3 py-2 text-left font-medium text-gray-700 transition hover:bg-gray-50 hover:text-gray-950 disabled:cursor-not-allowed disabled:opacity-40">
                                                            <span class="outcraft-icon !text-[16px] text-gray-400">arrow_downward</span>
                                                            Move Down
                                                        </button>
                                                        <button type="button" x-on:click="removeBriefBuilderItem(item.id)" class="flex w-full items-center gap-2 rounded-md px-3 py-2 text-left font-medium text-red-600 transition hover:bg-red-50 hover:text-red-700">
                                                            <span class="outcraft-icon !text-[16px]">delete</span>
                                                            Delete Block
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>

                                            <div x-show="item.type === 'find_out'" class="mt-5 space-y-4">
                                                <div
                                                    x-sortable
                                                    data-sortable-animation-duration="150"
                                                    x-on:end.stop="reorderBriefBuilderQuestions(item, $event.target.sortable.toArray())"
                                                    class="-mx-5 border-y border-gray-200 bg-white"
                                                >
                                                    <template x-for="(question, questionIndex) in item.questions" :key="question.id">
                                                        <div x-bind:x-sortable-item="question.id" class="flex items-start gap-3 px-5 py-3" :class="questionIndex === item.questions.length - 1 ? '' : 'border-b border-gray-200'">
                                                            <button type="button" x-sortable-handle class="inline-flex size-7 shrink-0 cursor-grab items-center justify-center rounded-md text-gray-300 transition hover:bg-gray-50 hover:text-gray-500 active:cursor-grabbing" aria-label="Reorder Question">
                                                                <span class="outcraft-icon !text-[18px]">drag_indicator</span>
                                                            </button>
                                                            <span class="min-w-0 flex-1 text-sm leading-6 text-gray-900" x-text="question.text"></span>
                                                            <span x-show="briefBuilderQuestionCaptured(item, question)" class="inline-flex shrink-0 rounded-md bg-emerald-50 px-2 py-1 text-xs font-medium text-emerald-700 ring-1 ring-inset ring-emerald-600/20">Captured</span>
                                                            <button x-show="! briefBuilderQuestionCaptured(item, question)" type="button" x-on:click="captureBriefBuilderQuestion(item, question, 'Discovery Questions'); hideFloatingTooltip()" x-on:mouseenter="showFloatingTooltip($event, 'Capture for Conversation Intelligence', 240)" x-on:mouseleave="hideFloatingTooltip()" x-on:focus="showFloatingTooltip($event, 'Capture for Conversation Intelligence', 240)" x-on:blur="hideFloatingTooltip()" class="inline-flex size-7 shrink-0 items-center justify-center rounded-md text-gray-400 transition hover:bg-gray-50 hover:text-indigo-600 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600" aria-label="Capture for Conversation Intelligence">
                                                                <span class="outcraft-icon !text-[17px]">fact_check</span>
                                                            </button>
                                                            <button type="button" x-on:click="removeBriefBuilderQuestion(item, questionIndex)" class="inline-flex size-7 shrink-0 items-center justify-center rounded-md text-gray-400 transition hover:bg-gray-50 hover:text-red-600" aria-label="Remove Question"><span class="outcraft-icon !text-[17px]">delete</span></button>
                                                        </div>
                                                    </template>
                                                    <p x-show="item.questions.length === 0" class="px-5 py-4 text-sm text-gray-500">No Questions Added.</p>
                                                </div>
                                                <form x-on:submit.prevent="addBriefBuilderQuestion(item)" class="grid gap-3 sm:grid-cols-[minmax(0,1fr)_auto]">
                                                    <input x-model="item.newQuestion" type="text" placeholder="e.g. What problem are they trying to solve?" class="block w-full rounded-md bg-white px-3 py-1.5 text-sm/6 text-gray-900 shadow-sm outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600">
                                                    <button type="submit" :disabled="! String(item.newQuestion || '').trim()" class="inline-flex h-9 items-center justify-center rounded-md bg-indigo-600 px-3 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-500 disabled:cursor-not-allowed disabled:opacity-40">Add Question</button>
                                                </form>
                                            </div>

                                            <div x-show="item.type === 'pricing'" class="mt-5 space-y-5">
                                                <label class="block">
                                                    <span class="block text-sm/6 font-semibold text-gray-900">Pricing</span>
                                                    <select x-model="campaignSetup.brief.pricingSource" class="mt-2 block w-full rounded-md bg-white py-1.5 pl-3 pr-8 text-sm/6 text-gray-900 shadow-sm outline outline-1 -outline-offset-1 outline-gray-300 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600">
                                                        <option>Use Knowledge Base Pricing</option>
                                                        <option>Use Manually Entered Pricing</option>
                                                    </select>
                                                    <span class="mt-2 block text-sm leading-6 text-gray-500">Choose where the AI should get pricing details from.</span>
                                                </label>
                                                <label x-show="campaignSetup.brief.pricingSource === 'Use Manually Entered Pricing'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-3" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-2" class="block">
                                                    <span class="block text-sm/6 font-semibold text-gray-900">Manual Pricing Notes</span>
                                                    <textarea x-model="campaignSetup.brief.manualPricing" rows="4" placeholder="Pulsetto Fit - 251 EUR special offer. Pulsetto Lite - 233 EUR special offer." class="mt-2 block w-full rounded-md bg-white px-3 py-2 text-sm/6 text-gray-700 shadow-sm outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600"></textarea>
                                                </label>
                                                <button type="button" x-on:click="campaignSetup.brief.canNegotiatePrice = ! campaignSetup.brief.canNegotiatePrice; scheduleCampaignBuilderLayoutUpdate()" role="switch" :aria-checked="campaignSetup.brief.canNegotiatePrice" class="flex w-full items-start gap-4 rounded-md text-left focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                                                    <span class="relative mt-1 inline-flex h-6 w-11 shrink-0 rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out" :class="campaignSetup.brief.canNegotiatePrice ? 'bg-indigo-600' : 'bg-gray-200'"><span class="pointer-events-none inline-block size-5 rounded-full bg-white shadow transition duration-200 ease-in-out" :class="campaignSetup.brief.canNegotiatePrice ? 'translate-x-5' : 'translate-x-0'"></span></span>
                                                    <span><span class="block text-sm font-semibold leading-6 text-gray-950">Can Negotiate Price</span><span class="mt-1 block text-sm leading-6 text-gray-600">Allow AI to negotiate within a limited discount percentage.</span></span>
                                                </button>
                                                <label x-show="campaignSetup.brief.canNegotiatePrice" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-3" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-2" class="block max-w-xs">
                                                    <span class="block text-sm/6 font-semibold text-gray-900">Negotiation Limit (%)</span>
                                                    <input x-model="campaignSetup.brief.priceNegotiationPercent" type="number" min="0" max="100" placeholder="10" class="mt-2 block w-full rounded-md bg-white px-3 py-1.5 text-sm/6 text-gray-900 shadow-sm outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600">
                                                </label>
                                            </div>

                                            <div x-show="item.type === 'guardrails'" class="mt-5 space-y-5">
                                                <label class="block">
                                                    <span class="block text-sm/6 font-semibold text-gray-900">Never Ask For</span>
                                                    <textarea x-model="campaignSetup.brief.neverAskFor" rows="4" placeholder="Credit card information&#10;Banking details&#10;Passwords" class="mt-2 block w-full rounded-md bg-white px-3 py-2 text-sm/6 text-gray-700 shadow-sm outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600"></textarea>
                                                </label>
                                                <label class="block">
                                                    <span class="block text-sm/6 font-semibold text-gray-900">Never Promise</span>
                                                    <textarea x-model="campaignSetup.brief.neverPromise" rows="4" placeholder="Refunds&#10;Delivery dates&#10;Guaranteed results" class="mt-2 block w-full rounded-md bg-white px-3 py-2 text-sm/6 text-gray-700 shadow-sm outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600"></textarea>
                                                </label>
                                                <label class="block">
                                                    <span class="block text-sm/6 font-semibold text-gray-900">Never Discuss</span>
                                                    <textarea x-model="campaignSetup.brief.neverDiscuss" rows="4" placeholder="Unrelated topics&#10;Competitor breakdowns&#10;Refund approvals" class="mt-2 block w-full rounded-md bg-white px-3 py-2 text-sm/6 text-gray-700 shadow-sm outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600"></textarea>
                                                </label>
                                            </div>

                                            <div x-show="item.type === 'qualification'" class="mt-5 space-y-4">
                                                <div
                                                    x-sortable
                                                    data-sortable-animation-duration="150"
                                                    x-on:end.stop="reorderBriefBuilderQuestions(item, $event.target.sortable.toArray())"
                                                    class="-mx-5 border-y border-gray-200 bg-white"
                                                >
                                                    <template x-for="(question, questionIndex) in item.questions" :key="question.id">
                                                        <div x-bind:x-sortable-item="question.id" class="px-5 py-3" :class="questionIndex === item.questions.length - 1 ? '' : 'border-b border-gray-200'">
                                                            <div class="flex items-start gap-3">
                                                                <button type="button" x-sortable-handle class="inline-flex size-7 shrink-0 cursor-grab items-center justify-center rounded-md text-gray-300 transition hover:bg-gray-50 hover:text-gray-500 active:cursor-grabbing" aria-label="Reorder Qualification Question">
                                                                    <span class="outcraft-icon !text-[18px]">drag_indicator</span>
                                                                </button>
                                                                <div class="min-w-0 flex-1">
                                                                    <p class="text-sm font-medium leading-6 text-gray-900" x-text="question.text"></p>
                                                                    <div class="mt-1 space-y-1 text-sm leading-6 text-gray-500">
                                                                        <template x-for="(answer, answerIndex) in briefBuilderQualificationAnswerLines(question.answers)" :key="`${question.id}-answer-${answerIndex}`">
                                                                            <p x-text="`- ${answer}`"></p>
                                                                        </template>
                                                                    </div>
                                                                </div>
                                                                <span x-show="briefBuilderQuestionCaptured(item, question)" class="inline-flex shrink-0 rounded-md bg-emerald-50 px-2 py-1 text-xs font-medium text-emerald-700 ring-1 ring-inset ring-emerald-600/20">Captured</span>
                                                                <button x-show="! briefBuilderQuestionCaptured(item, question)" type="button" x-on:click="captureBriefBuilderQuestion(item, question, 'Qualification Questions'); hideFloatingTooltip()" x-on:mouseenter="showFloatingTooltip($event, 'Capture for Conversation Intelligence', 240)" x-on:mouseleave="hideFloatingTooltip()" x-on:focus="showFloatingTooltip($event, 'Capture for Conversation Intelligence', 240)" x-on:blur="hideFloatingTooltip()" class="inline-flex size-7 shrink-0 items-center justify-center rounded-md text-gray-400 transition hover:bg-gray-50 hover:text-indigo-600 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600" aria-label="Capture for Conversation Intelligence">
                                                                    <span class="outcraft-icon !text-[17px]">fact_check</span>
                                                                </button>
                                                                <button type="button" x-on:click="removeBriefBuilderQuestion(item, questionIndex)" class="inline-flex size-7 shrink-0 items-center justify-center rounded-md text-gray-400 transition hover:bg-gray-50 hover:text-red-600" aria-label="Remove Qualification Question"><span class="outcraft-icon !text-[17px]">delete</span></button>
                                                            </div>
                                                        </div>
                                                    </template>
                                                    <p x-show="item.questions.length === 0" class="px-5 py-4 text-sm text-gray-500">No Qualification Questions Added.</p>
                                                </div>
                                                <form x-on:submit.prevent="addBriefBuilderQualificationQuestion(item)" class="space-y-3">
                                                    <input x-model="item.newQuestion" type="text" placeholder="e.g. Are they ready for the next step?" class="block w-full rounded-md bg-white px-3 py-1.5 text-sm/6 text-gray-900 shadow-sm outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600">
                                                    <label class="block">
                                                        <span class="mb-2 block text-sm/6 font-semibold text-gray-900">Qualifying Answers</span>
                                                        <textarea x-model="item.newAnswers" rows="3" placeholder="Has a clear need&#10;Wants to move forward" class="block w-full rounded-md bg-white px-3 py-2 text-sm/6 text-gray-700 shadow-sm outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600"></textarea>
                                                        <span class="mt-2 block text-sm leading-6 text-gray-500">Each line becomes one qualifying answer.</span>
                                                    </label>
                                                    <button type="submit" :disabled="! String(item.newQuestion || '').trim() || briefBuilderQualificationAnswerLines(item.newAnswers).length === 0" class="inline-flex h-9 items-center justify-center rounded-md bg-indigo-600 px-3 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-500 disabled:cursor-not-allowed disabled:opacity-40">Add Qualification Question</button>
                                                </form>
                                            </div>

                                            <label x-show="briefBuilderIsGuidelineItem(item.type)" class="mt-5 block">
                                                <span class="sr-only" x-text="briefBuilderItemTitle(item.type)"></span>
                                                <textarea x-model="item.content" rows="5" :placeholder="briefBuilderGuidelinePlaceholder(item.type)" class="block w-full rounded-md bg-white px-3 py-2 text-sm/6 text-gray-700 shadow-sm outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600"></textarea>
                                                <span class="mt-2 block text-sm leading-6 text-gray-500" x-text="briefBuilderGuidelineHelper(item.type)"></span>
                                            </label>

                                            <div x-show="item.type === 'discount_codes'" class="mt-5 space-y-4">
                                                <form x-on:submit.prevent="addDiscountCode()" class="grid gap-3 sm:grid-cols-[minmax(0,1fr)_auto]">
                                                    <input x-model="campaignSetup.newDiscountCode" type="text" placeholder="e.g. WELCOME20 or 25OFF" class="block w-full rounded-md bg-white px-3 py-1.5 text-sm/6 text-gray-900 shadow-sm outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600">
                                                    <button type="submit" :disabled="! String(campaignSetup.newDiscountCode || '').trim()" class="inline-flex h-9 items-center justify-center rounded-md bg-indigo-600 px-3 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-500 disabled:cursor-not-allowed disabled:opacity-40">Add</button>
                                                </form>
                                                <div class="divide-y divide-gray-200">
                                                    <template x-for="code in campaignSetup.discountCodes" :key="`builder-${code.value}`">
                                                        <div class="flex items-start justify-between gap-4 py-3">
                                                            <div>
                                                                <p class="text-sm font-semibold leading-6 text-gray-950" x-text="code.value"></p>
                                                                <p class="text-sm leading-6 text-gray-500" x-text="`Created ${code.created}`"></p>
                                                            </div>
                                                            <button type="button" x-on:click="campaignSetup.discountCodes = campaignSetup.discountCodes.filter((item) => item.value !== code.value)" class="inline-flex size-8 items-center justify-center rounded-md text-gray-400 transition hover:bg-gray-50 hover:text-red-600" aria-label="Remove Discount Code">
                                                                <span class="outcraft-icon !text-[17px]">delete</span>
                                                            </button>
                                                        </div>
                                                    </template>
                                                    <p x-show="campaignSetup.discountCodes.length === 0" class="py-4 text-sm text-gray-500">No Discount Codes Added.</p>
                                                </div>
                                            </div>

                                            <div x-show="item.type === 'handoff'" class="mt-5 space-y-6">
                                                <button type="button" x-on:click="campaignSetup.handoffPositive = ! campaignSetup.handoffPositive; scheduleCampaignBuilderLayoutUpdate()" role="switch" :aria-checked="campaignSetup.handoffPositive" class="flex w-full items-start gap-4 rounded-md text-left focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                                                    <span class="relative mt-1 inline-flex h-6 w-11 shrink-0 rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out" :class="campaignSetup.handoffPositive ? 'bg-indigo-600' : 'bg-gray-200'"><span class="pointer-events-none inline-block size-5 rounded-full bg-white shadow transition duration-200 ease-in-out" :class="campaignSetup.handoffPositive ? 'translate-x-5' : 'translate-x-0'"></span></span>
                                                    <span><span class="block text-sm font-semibold leading-6 text-gray-950">Hand Off After a Positive Reply</span><span class="mt-1 block text-sm leading-6 text-gray-600">AI passes the conversation to a human when the lead responds positively.</span></span>
                                                </button>
                                                <label x-show="campaignSetup.handoffPositive" class="block">
                                                    <span class="block text-sm/6 font-medium text-gray-900">Handoff Trigger Scenarios</span>
                                                    <select x-model="campaignSetup.handoffScenario" class="mt-2 block w-full rounded-md bg-white py-1.5 pl-3 pr-8 text-sm/6 text-gray-900 shadow-sm outline outline-1 -outline-offset-1 outline-gray-300 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600"><option value="">Type Your Own or Select Common Scenario</option><option>Positive Reply</option><option>High Intent</option><option>Pricing Question</option></select>
                                                    <span class="mt-2 block text-sm leading-6 text-gray-500">Situations where AI should pass to a human agent.</span>
                                                </label>
                                                <button type="button" x-on:click="campaignSetup.handoffRequested = ! campaignSetup.handoffRequested; scheduleCampaignBuilderLayoutUpdate()" role="switch" :aria-checked="campaignSetup.handoffRequested" class="flex w-full items-start gap-4 rounded-md text-left focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                                                    <span class="relative mt-1 inline-flex h-6 w-11 shrink-0 rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out" :class="campaignSetup.handoffRequested ? 'bg-indigo-600' : 'bg-gray-200'"><span class="pointer-events-none inline-block size-5 rounded-full bg-white shadow transition duration-200 ease-in-out" :class="campaignSetup.handoffRequested ? 'translate-x-5' : 'translate-x-0'"></span></span>
                                                    <span><span class="block text-sm font-semibold leading-6 text-gray-950">Hand Off When the Lead Asks</span><span class="mt-1 block text-sm leading-6 text-gray-600">AI passes the conversation when the lead explicitly requests a human.</span></span>
                                                </button>
                                                <label x-show="campaignSetup.handoffRequested" class="block">
                                                    <span class="block text-sm/6 font-medium text-gray-900">Handoff Channel</span>
                                                    <select x-model="campaignSetup.handoffChannel" class="mt-2 block w-full rounded-md bg-white py-1.5 pl-3 pr-8 text-sm/6 text-gray-900 shadow-sm outline outline-1 -outline-offset-1 outline-gray-300 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600"><option value="">Select a Channel</option><option>Email</option><option>Slack</option><option>Webhook</option></select>
                                                    <span class="mt-2 block text-sm leading-6 text-gray-500">How the human agent is notified.</span>
                                                </label>
                                                <label class="block">
                                                    <span class="block text-sm/6 font-semibold text-gray-900">Handoff Notification Email</span>
                                                    <input x-model="campaignSetup.handoffNotificationEmail" type="email" placeholder="support@pulsetto.com" class="mt-2 block w-full rounded-md bg-white px-3 py-1.5 text-sm/6 text-gray-900 shadow-sm outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600">
                                                    <span class="mt-2 block text-sm leading-6 text-gray-500">Where to send a notification when AI hands off a conversation.</span>
                                                </label>
                                            </div>

                                            <div x-show="item.type === 'followups'" class="mt-5 space-y-6">
                                                <button type="button" x-on:click="toggleFollowupSequence('followupPositive', 'positive')" role="switch" :aria-checked="campaignSetup.followupPositive" class="flex w-full items-center justify-between gap-4 rounded-md text-left focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                                                    <span class="min-w-0">
                                                        <span class="block text-sm font-semibold leading-6 text-gray-950">After a Positive Response</span>
                                                        <span class="mt-1 block text-sm leading-6 text-gray-600">Follow up to confirm the next step, share details, or check if the lead needs anything else.</span>
                                                    </span>
                                                    <span class="relative inline-flex h-6 w-11 shrink-0 self-center rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out" :class="campaignSetup.followupPositive ? 'bg-indigo-600' : 'bg-gray-200'">
                                                        <span class="pointer-events-none inline-block size-5 rounded-full bg-white shadow transition duration-200 ease-in-out" :class="campaignSetup.followupPositive ? 'translate-x-5' : 'translate-x-0'"></span>
                                                    </span>
                                                </button>

                                                <button type="button" x-on:click="toggleFollowupSequence('followupEngaged', 'engaged')" role="switch" :aria-checked="campaignSetup.followupEngaged" class="flex w-full items-center justify-between gap-4 rounded-md text-left focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                                                    <span class="min-w-0">
                                                        <span class="block text-sm font-semibold leading-6 text-gray-950">When a Lead Is Engaged but Undecided</span>
                                                        <span class="mt-1 block text-sm leading-6 text-gray-600">Follow up to answer questions and help the lead move toward a clear yes or no.</span>
                                                    </span>
                                                    <span class="relative inline-flex h-6 w-11 shrink-0 self-center rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out" :class="campaignSetup.followupEngaged ? 'bg-indigo-600' : 'bg-gray-200'">
                                                        <span class="pointer-events-none inline-block size-5 rounded-full bg-white shadow transition duration-200 ease-in-out" :class="campaignSetup.followupEngaged ? 'translate-x-5' : 'translate-x-0'"></span>
                                                    </span>
                                                </button>

                                                <button type="button" x-on:click="toggleFollowupSequence('followupNegative', 'negative')" role="switch" :aria-checked="campaignSetup.followupNegative" class="flex w-full items-center justify-between gap-4 rounded-md text-left focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                                                    <span class="min-w-0">
                                                        <span class="block text-sm font-semibold leading-6 text-gray-950">After a Negative Response</span>
                                                        <span class="mt-1 block text-sm leading-6 text-gray-600">Follow up only when there may still be an opportunity to address concerns or objections.</span>
                                                    </span>
                                                    <span class="relative inline-flex h-6 w-11 shrink-0 self-center rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out" :class="campaignSetup.followupNegative ? 'bg-indigo-600' : 'bg-gray-200'">
                                                        <span class="pointer-events-none inline-block size-5 rounded-full bg-white shadow transition duration-200 ease-in-out" :class="campaignSetup.followupNegative ? 'translate-x-5' : 'translate-x-0'"></span>
                                                    </span>
                                                </button>

                                                <div x-show="campaignSetup.followupPositive || campaignSetup.followupEngaged || campaignSetup.followupNegative" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-3" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-2" class="space-y-5">
                                                    <div>
                                                        <h4 class="text-base font-semibold leading-6 text-gray-950">Follow-Up Sequence</h4>
                                                        <p class="mt-2 text-sm leading-6 text-gray-600">Build a follow-up sequence that will be applied for this campaign.</p>
                                                    </div>
                                                    <div class="border-b border-gray-200">
                                                        <nav class="-mb-px flex flex-wrap gap-6" aria-label="Follow-up sequence tabs">
                                                            <template x-for="tab in followupSequenceTabs()" :key="`builder-${tab.id}`">
                                                                <button type="button" x-on:click="campaignSetup.activeFollowupSequence = tab.id" class="border-b-2 px-1 pb-3 text-sm font-semibold transition" :class="campaignSetup.activeFollowupSequence === tab.id ? 'border-indigo-600 text-indigo-600' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700'">
                                                                    <span x-text="tab.label"></span>
                                                                </button>
                                                            </template>
                                                        </nav>
                                                    </div>
                                                    <div class="flex flex-wrap items-center justify-between gap-3">
                                                        <button type="button" class="inline-flex h-9 w-fit shrink-0 self-start items-center rounded-md bg-white px-3 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 transition hover:bg-gray-50">Reorder Actions</button>
                                                        <button type="button" x-on:click="campaignSetup.followupModalOpen = true" class="inline-flex h-9 w-fit shrink-0 self-start items-center rounded-md bg-indigo-600 px-3 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-500">Add Step</button>
                                                    </div>
                                                    <div class="overflow-hidden rounded-lg border border-gray-200">
                                                        <table class="min-w-full divide-y divide-gray-200 text-left text-sm">
                                                            <thead class="bg-gray-50">
                                                                <tr>
                                                                    <template x-for="head in ['Channel','Label','Relative Delay','Exact Flow Step']" :key="`builder-followup-${head}`">
                                                                        <th class="px-4 py-3 font-semibold text-gray-600" x-text="head"></th>
                                                                    </template>
                                                                </tr>
                                                            </thead>
                                                        </table>
                                                        <div class="flex min-h-40 flex-col items-center justify-center border-t border-gray-100 px-6 py-10 text-center">
                                                            <span class="flex size-12 items-center justify-center rounded-full bg-gray-100 text-gray-400">
                                                                <span class="outcraft-icon !text-[24px]">close</span>
                                                            </span>
                                                            <h5 class="mt-5 text-base font-bold text-gray-950">No Flow Template Steps</h5>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </article>
                                    </template>

                                    <button type="button" x-on:click="openBriefBuilderItemModal()" class="group flex w-full items-start gap-4 rounded-lg border border-gray-300 bg-white p-5 text-left transition hover:border-2 hover:border-indigo-600 hover:p-[19px] focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                                        <span class="flex size-10 shrink-0 items-center justify-center rounded-md bg-indigo-600 text-white">
                                            <span class="outcraft-icon !text-[22px]">add</span>
                                        </span>
                                        <span class="min-w-0">
                                            <span class="block text-base font-semibold leading-6 text-gray-950">Add Item</span>
                                            <span class="mt-1 block text-sm leading-6 text-gray-500">Find and add extra campaign context blocks, rules, pricing, channel guidelines, or qualification logic.</span>
                                        </span>
                                    </button>

	                                </div>
	                            </section>

	                            <section x-cloak x-show="campaignSetup.current === 'general' || campaignSetupScrollFromStep === 'general'" x-ref="campaignSetupStep_general"
                                :style="campaignSetupStepStyle('general')"
                                data-campaign-setup-step
                                class="pr-2 pb-4">
                                <div class="mb-1">
                                    <p class="text-sm font-semibold text-indigo-600" x-text="`${campaignSetupMode === 'fast' ? 'Fast Setup' : 'Advanced Setup'} · Step ${campaignSetupStepIndex('general') + 1} of ${campaignSetupStepsForMode().length}`"></p>
                                    <span class="mb-4 flex size-10 items-center justify-center rounded-md bg-indigo-50 text-indigo-600">
                                        <span class="outcraft-icon !text-[21px]" x-text="campaignSetupStepIcon('general')"></span>
                                    </span>
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
                                    <span class="mb-4 flex size-10 items-center justify-center rounded-md bg-indigo-50 text-indigo-600">
                                        <span class="outcraft-icon !text-[21px]" x-text="campaignSetupStepIcon('resources')"></span>
                                    </span>
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
                                    <div data-step-icon-row data-step-actions-align-top data-step-actions-content-row>
                                        <span class="flex size-10 items-center justify-center rounded-md bg-indigo-50 text-indigo-600">
                                            <span class="outcraft-icon !text-[21px]" x-text="campaignSetupStepIcon('agent')"></span>
                                        </span>
                                        <div class="flex w-full flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
                                            <div class="relative w-full sm:w-72" x-on:click.outside="campaignSetup.languageMenuOpen = false">
                                                <button
                                                    type="button"
                                                    x-on:click="campaignSetup.languageMenuOpen = ! campaignSetup.languageMenuOpen; campaignSetup.languageSearch = ''; $nextTick(() => $refs.campaignLanguageSearch?.focus())"
                                                    class="inline-flex h-9 w-full items-center justify-between gap-3 rounded-md bg-white px-3 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 transition hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-600"
                                                >
                                                    <span class="flex min-w-0 items-center gap-2">
                                                        <span class="inline-flex size-5 shrink-0 overflow-hidden rounded-full ring-1 ring-gray-200">
                                                            <img :src="campaignSetupFlagUrl(campaignSetupActiveLanguage())" :alt="`${campaignSetupLanguageDisplay(campaignSetupActiveLanguage())} flag`" class="size-full object-cover" loading="lazy">
                                                        </span>
                                                        <span class="truncate" x-text="campaignSetupLanguageDisplay(campaignSetupActiveLanguage())"></span>
                                                    </span>
                                                    <span class="outcraft-icon !text-[18px] text-gray-400">keyboard_arrow_down</span>
                                                </button>

                                                <div
                                                    x-cloak
                                                    x-show="campaignSetup.languageMenuOpen"
                                                    x-transition:enter="transition ease-out duration-100"
                                                    x-transition:enter-start="opacity-0 translate-y-1"
                                                    x-transition:enter-end="opacity-100 translate-y-0"
                                                    x-transition:leave="transition ease-in duration-75"
                                                    x-transition:leave-start="opacity-100 translate-y-0"
                                                    x-transition:leave-end="opacity-0 translate-y-1"
                                                    class="absolute left-0 right-0 z-40 mt-2 w-full overflow-hidden rounded-md bg-white shadow-lg ring-1 ring-gray-900/10"
                                                >
                                                    <div class="py-1">
                                                        <p class="px-3 py-2 text-xs font-semibold uppercase tracking-wide text-gray-400">Languages</p>
                                                        <template x-for="language in campaignSetup.languages" :key="language.code">
                                                            <button type="button" x-on:click="selectCampaignSetupLanguage(language.code); campaignSetup.languageMenuOpen = false" class="flex w-full items-center justify-between gap-3 px-3 py-2 text-left text-sm transition hover:bg-gray-50">
                                                                <span class="flex min-w-0 items-center gap-3">
                                                                    <span class="inline-flex size-5 shrink-0 overflow-hidden rounded-full ring-1 ring-gray-200">
                                                                        <img :src="campaignSetupFlagUrl(language)" :alt="`${campaignSetupLanguageDisplay(language)} flag`" class="size-full object-cover" loading="lazy">
                                                                    </span>
                                                                    <span class="truncate font-medium text-gray-900" x-text="campaignSetupLanguageDisplay(language)"></span>
                                                                </span>
                                                                <span class="flex shrink-0 items-center gap-2">
                                                                    <span x-show="campaignSetup.defaultLanguage === language.code" class="rounded-full bg-indigo-50 px-2 py-0.5 text-xs font-medium text-indigo-700 ring-1 ring-inset ring-indigo-200">Default</span>
                                                                    <span x-show="campaignSetup.activeLanguage === language.code" class="outcraft-icon !text-[16px] text-indigo-600">check</span>
                                                                </span>
                                                            </button>
                                                        </template>
                                                    </div>
                                                    <div class="border-t border-gray-100 p-2">
                                                        <input x-ref="campaignLanguageSearch" x-model="campaignSetup.languageSearch" type="search" placeholder="Add Language" class="block h-9 w-full rounded-md bg-white px-3 py-1.5 text-sm text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600">
                                                        <div class="mt-2 max-h-48 overflow-y-auto">
                                                            <template x-for="language in filteredCampaignSetupLanguageOptions()" :key="language.code">
                                                                <button type="button" x-on:click="addCampaignSetupLanguage(language.code)" class="flex w-full items-center gap-3 rounded-md px-2 py-2 text-left text-sm transition hover:bg-gray-50">
                                                                    <span class="inline-flex size-5 shrink-0 overflow-hidden rounded-full ring-1 ring-gray-200">
                                                                        <img :src="campaignSetupFlagUrl(language)" :alt="`${campaignSetupLanguageDisplay(language)} flag`" class="size-full object-cover" loading="lazy">
                                                                    </span>
                                                                    <span class="truncate font-medium text-gray-900" x-text="campaignSetupLanguageDisplay(language)"></span>
                                                                </button>
                                                            </template>
                                                            <p x-show="filteredCampaignSetupLanguageOptions().length === 0" class="px-2 py-3 text-sm text-gray-500">No Languages Found.</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <span x-show="campaignSetup.defaultLanguage === campaignSetup.activeLanguage" class="shrink-0 self-start rounded-full bg-indigo-50 px-2.5 py-1 text-xs font-medium text-indigo-700 ring-1 ring-inset ring-indigo-200 sm:self-center">Default</span>
                                            <button x-show="campaignSetup.defaultLanguage !== campaignSetup.activeLanguage" type="button" x-on:click="setCampaignSetupDefaultLanguage(campaignSetup.activeLanguage)" class="shrink-0 self-start text-sm font-semibold text-indigo-600 transition hover:text-indigo-500 focus:outline-none focus-visible:rounded focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 sm:self-center">Set as Default</button>
                                        </div>
                                    </div>
                                    <h2 class="mt-2 text-2xl font-bold leading-8 tracking-tight text-gray-950" x-text="campaignSetupHeading('agent')"></h2>
                                    <p class="mt-2 max-w-3xl text-sm leading-6 text-gray-600" x-text="campaignSetupDescription('agent')"></p>
                                </div>

                                <div class="space-y-6">
                                <div class="rounded-lg border border-gray-200 bg-white p-6">
                                    <div class="grid gap-6 lg:grid-cols-2">
                                        <label class="block">
                                            <span class="block text-sm/6 font-semibold text-gray-900">Agent Name<span class="text-indigo-400">*</span></span>
                                            <input x-model="campaignSetup.agentName" type="text" class="mt-2 block w-full rounded-md bg-white px-3 py-1.5 text-sm/6 text-gray-900 shadow-sm outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600">
                                            <span class="mt-2 block text-sm leading-6 text-gray-600">How the AI assistant will introduce itself to leads.</span>
                                        </label>

                                        <label class="block">
                                            <span class="block text-sm/6 font-semibold text-gray-900">Voice<span class="text-indigo-400">*</span></span>
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

                                    <div class="mt-6">
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
                                </div>

                                <div class="rounded-lg border border-gray-200 bg-white p-6">
                                    <h3 class="text-base font-semibold leading-6 text-gray-950">Schedule</h3>
                                    <p class="mt-2 max-w-3xl text-sm leading-6 text-gray-600">Outreach is scheduled and sent based on the lead's local timezone. The timezone is inferred from the lead's phone number and country data.</p>

                                    <div class="mt-8">
                                        <label class="block max-w-xl">
                                            <span class="block text-sm/6 font-semibold text-gray-900">Outreach Schedule</span>
                                            <div class="mt-2 grid grid-cols-1">
                                                <select x-model="campaignSetup.scheduleMode" x-on:change="campaignSetup.allDay = campaignSetup.scheduleMode === 'all-day'; scheduleCampaignBuilderLayoutUpdate()" class="col-start-1 row-start-1 block w-full appearance-none rounded-md bg-white py-1.5 pr-8 pl-3 text-sm/6 text-gray-900 shadow-sm outline outline-1 -outline-offset-1 outline-gray-300 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600">
                                                    <option value="business">Local Business Hours</option>
                                                    <option value="extended">Local Extended Hours</option>
                                                    <option value="all-day">Always On</option>
                                                    <option value="custom">Custom Schedule</option>
                                                </select>
                                                <span class="outcraft-icon pointer-events-none col-start-1 row-start-1 mr-3 self-center justify-self-end text-gray-500">keyboard_arrow_down</span>
                                            </div>
                                            <span class="mt-2 block text-sm leading-6 text-gray-600" x-text="campaignScheduleDescription()"></span>
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
                                                    <span class="block text-sm/6 font-semibold text-gray-900">Outreach Start Hour<span class="text-indigo-400">*</span></span>
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
                                                    <span class="block text-sm/6 font-semibold text-gray-900">Outreach End Hour<span class="text-indigo-400">*</span></span>
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
                                <div x-show="campaignSetupMode === 'advanced'" class="space-y-7">
                                    <div class="overflow-hidden rounded-lg border border-gray-200 bg-white">
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
                                                    <span class="block text-sm/6 font-semibold text-gray-900">Call Greeting Phrase<span class="text-indigo-400">*</span></span>
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
                                                <span class="mb-2 block text-sm/6 font-semibold text-gray-900">AI Agent Personality<span class="text-indigo-400">*</span></span>
                                                <textarea x-model="campaignSetup.agentPersonality" rows="6" class="mt-2 block min-h-[140px] w-full resize-y rounded-md bg-white px-3 py-2 text-sm/6 text-gray-700 shadow-sm outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600"></textarea>
                                            </label>

                                            <label class="order-10 block lg:col-span-2">
                                                <span class="mb-2 block text-sm/6 font-semibold text-gray-900">AI Agent Speech Style<span class="text-indigo-400">*</span></span>
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
                                    <span class="mb-4 flex size-10 items-center justify-center rounded-md bg-indigo-50 text-indigo-600">
                                        <span class="outcraft-icon !text-[21px]" x-text="campaignSetupStepIcon('channels')"></span>
                                    </span>
                                    <h2 class="mt-2 text-2xl font-bold leading-8 tracking-tight text-gray-950" x-text="campaignSetupHeading('channels')"></h2>
                                    <p class="mt-2 max-w-3xl text-sm leading-6 text-gray-600" x-text="campaignSetupDescription('channels')"></p>
                                </div>
                                <div class="space-y-5">
	                                <div>
	                                    <div>
	                                        <div class="flex items-center justify-between gap-4">
	                                            <button type="button" x-on:click="toggleChannel('calls')" class="min-w-0 flex-1 rounded-md text-left focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
	                                                <span class="block text-sm font-semibold leading-6 text-gray-950">Voice &amp; Calls</span>
	                                                <span class="mt-1 block text-sm leading-6 text-gray-600">Enable communication with leads through AI voice calls.</span>
	                                            </button>
	                                            <button type="button" x-on:click="toggleChannel('calls')" role="switch" :aria-checked="campaignSetup.channels.calls" class="relative inline-flex h-6 w-11 shrink-0 self-center rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600" :class="campaignSetup.channels.calls ? 'bg-indigo-600' : 'bg-gray-200'">
	                                                <span class="pointer-events-none inline-block size-5 rounded-full bg-white shadow transition duration-200 ease-in-out" :class="campaignSetup.channels.calls ? 'translate-x-5' : 'translate-x-0'"></span>
	                                            </button>
	                                        </div>
	                                    </div>
	                                </div>

	                                <div>
	                                    <div>
	                                        <div>
	                                            <div class="flex items-center justify-between gap-4">
	                                                <button type="button" x-on:click="toggleChannel('email')" class="min-w-0 flex-1 rounded-md text-left focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
	                                                    <span class="block text-sm font-semibold leading-6 text-gray-950">Email</span>
	                                                    <span class="mt-1 block text-sm leading-6 text-gray-600">Enable communication with leads through email.</span>
	                                                </button>
	                                                <button type="button" x-on:click="toggleChannel('email')" role="switch" :aria-checked="campaignSetup.channels.email" class="relative inline-flex h-6 w-11 shrink-0 self-center rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600" :class="campaignSetup.channels.email ? 'bg-indigo-600' : 'bg-gray-200'">
	                                                    <span class="pointer-events-none inline-block size-5 rounded-full bg-white shadow transition duration-200 ease-in-out" :class="campaignSetup.channels.email ? 'translate-x-5' : 'translate-x-0'"></span>
	                                                </button>
	                                            </div>
	                                            <button type="button" x-on:click="campaignSetup.channelOpen.email = ! campaignSetup.channelOpen.email; scheduleCampaignBuilderLayoutUpdate()" :disabled="! campaignSetup.channels.email" class="mt-3 inline-flex h-8 items-center gap-1.5 rounded-md bg-white px-2.5 text-sm font-semibold shadow-sm ring-1 ring-inset ring-gray-300 transition hover:bg-gray-50 disabled:cursor-not-allowed disabled:bg-gray-50 disabled:text-gray-400 disabled:ring-gray-200" :class="campaignSetup.channels.email ? 'text-gray-900' : 'text-gray-400'">
	                                                Configure
	                                                <span class="outcraft-icon !text-[15px] text-gray-400" :class="campaignSetup.channels.email && campaignSetup.channelOpen.email ? 'rotate-180' : ''">keyboard_arrow_down</span>
	                                            </button>
	                                        </div>
	                                        <div x-show="campaignSetup.channels.email && campaignSetup.channelOpen.email" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-3" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-2" class="mt-6 space-y-5 rounded-lg border border-gray-200 bg-white p-5">
	                                            <button type="button" x-on:click="campaignSetup.trackEmailLinkClicks = ! campaignSetup.trackEmailLinkClicks" role="switch" :aria-checked="campaignSetup.trackEmailLinkClicks" class="flex w-full items-center justify-between gap-4 rounded-md text-left focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
	                                                <span class="min-w-0">
	                                                    <span class="block text-sm font-semibold leading-6 text-gray-950">Track Email Link Clicks</span>
	                                                    <span class="mt-1 block text-sm leading-6 text-gray-600">Measures link clicks for emails that contain links. This may slightly modify link URLs in outgoing emails.</span>
	                                                </span>
	                                                <span class="relative inline-flex h-6 w-11 shrink-0 self-center rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out" :class="campaignSetup.trackEmailLinkClicks ? 'bg-indigo-600' : 'bg-gray-200'">
	                                                    <span class="pointer-events-none inline-block size-5 rounded-full bg-white shadow transition duration-200 ease-in-out" :class="campaignSetup.trackEmailLinkClicks ? 'translate-x-5' : 'translate-x-0'"></span>
	                                                </span>
	                                            </button>
	                                        </div>
	                                    </div>
	                                </div>

	                                <div>
	                                    <div>
	                                        <div>
	                                            <div class="flex items-center justify-between gap-4">
	                                                <button type="button" x-on:click="toggleChannel('sms')" class="min-w-0 flex-1 rounded-md text-left focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
	                                                    <span class="block text-sm font-semibold leading-6 text-gray-950">SMS</span>
	                                                    <span class="mt-1 block text-sm leading-6 text-gray-600">Enable communication with leads through SMS.</span>
	                                                </button>
	                                                <button type="button" x-on:click="toggleChannel('sms')" role="switch" :aria-checked="campaignSetup.channels.sms" class="relative inline-flex h-6 w-11 shrink-0 self-center rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600" :class="campaignSetup.channels.sms ? 'bg-indigo-600' : 'bg-gray-200'">
	                                                    <span class="pointer-events-none inline-block size-5 rounded-full bg-white shadow transition duration-200 ease-in-out" :class="campaignSetup.channels.sms ? 'translate-x-5' : 'translate-x-0'"></span>
	                                                </button>
	                                            </div>
	                                            <button type="button" x-on:click="campaignSetup.channelOpen.sms = ! campaignSetup.channelOpen.sms; scheduleCampaignBuilderLayoutUpdate()" :disabled="! campaignSetup.channels.sms" class="mt-3 inline-flex h-8 items-center gap-1.5 rounded-md bg-white px-2.5 text-sm font-semibold shadow-sm ring-1 ring-inset ring-gray-300 transition hover:bg-gray-50 disabled:cursor-not-allowed disabled:bg-gray-50 disabled:text-gray-400 disabled:ring-gray-200" :class="campaignSetup.channels.sms ? 'text-gray-900' : 'text-gray-400'">
	                                                Configure
	                                                <span class="outcraft-icon !text-[15px] text-gray-400" :class="campaignSetup.channels.sms && campaignSetup.channelOpen.sms ? 'rotate-180' : ''">keyboard_arrow_down</span>
	                                            </button>
	                                        </div>
	                                        <div x-show="campaignSetup.channels.sms && campaignSetup.channelOpen.sms" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-3" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-2" class="mt-6 space-y-6 rounded-lg border border-gray-200 bg-white p-5">
	                                            <div>
	                                                <div class="flex items-center justify-between gap-3">
	                                                    <h4 class="text-sm font-semibold leading-6 text-gray-950">When to Trigger SMS?</h4>
	                                                </div>
	                                                <div class="relative mt-2" x-data="{ smsTriggerMenuOpen: false }" x-on:click.outside="smsTriggerMenuOpen = false">
	                                                    <div class="flex min-h-9 w-full items-center gap-2 rounded-md bg-white px-2 py-1.5 text-sm/6 text-gray-900 shadow-sm outline outline-1 -outline-offset-1 outline-gray-300 transition focus-within:outline-2 focus-within:-outline-offset-2 focus-within:outline-indigo-600">
	                                                        <button type="button" x-on:click="smsTriggerMenuOpen = true" class="flex min-w-0 flex-1 flex-wrap items-center gap-1.5 text-left">
	                                                            <template x-for="trigger in campaignSetup.smsTriggers" :key="trigger">
	                                                                <span class="inline-flex items-center gap-1 rounded-md bg-indigo-50 px-2 py-1 text-xs font-medium text-indigo-700 ring-1 ring-inset ring-indigo-600/20">
	                                                                    <span x-text="trigger"></span>
	                                                                    <span x-on:click.stop="removeSmsTrigger(trigger)" class="outcraft-icon cursor-pointer !text-[14px] text-indigo-500 hover:text-indigo-700">close</span>
	                                                                </span>
	                                                            </template>
	                                                            <span x-show="campaignSetup.smsTriggers.length === 0" class="px-1 text-sm text-gray-400">Select triggers</span>
	                                                        </button>
	                                                        <button type="button" x-on:click="smsTriggerMenuOpen = ! smsTriggerMenuOpen" class="flex size-7 shrink-0 items-center justify-center rounded-md text-gray-500 transition hover:bg-gray-50 hover:text-gray-900">
	                                                            <span class="outcraft-icon !text-[18px]" :class="smsTriggerMenuOpen ? 'rotate-180' : ''">keyboard_arrow_down</span>
	                                                        </button>
	                                                    </div>
	                                                    <div x-cloak x-show="smsTriggerMenuOpen" x-transition:enter="transition ease-out duration-150" x-transition:enter-start="opacity-0 translate-y-1" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-100" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-1" class="absolute z-30 mt-2 w-full overflow-hidden rounded-md bg-white py-1 shadow-lg ring-1 ring-black/5">
	                                                        <template x-for="option in smsTriggerOptions" :key="option">
	                                                            <button type="button" x-on:click="toggleSmsTrigger(option)" class="flex w-full items-center justify-between gap-3 px-3 py-2 text-left text-sm font-medium transition hover:bg-gray-50" :class="campaignSetup.smsTriggers.includes(option) ? 'text-gray-950' : 'text-gray-600'">
	                                                                <span x-text="option"></span>
	                                                                <span x-show="campaignSetup.smsTriggers.includes(option)" class="outcraft-icon !text-[16px] text-indigo-600">check</span>
	                                                            </button>
	                                                        </template>
	                                                    </div>
	                                                </div>
	                                                <span class="mt-2 block text-sm leading-6 text-gray-600">Select the events after which the AI can send an SMS to the lead.</span>
	                                            </div>
	                                        </div>
	                                    </div>
	                                </div>

	                                <div>
	                                    <div>
	                                        <div class="flex items-center justify-between gap-4">
	                                            <button type="button" x-on:click="toggleChannel('whatsapp')" class="min-w-0 flex-1 rounded-md text-left focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
	                                                <span class="block text-sm font-semibold leading-6 text-gray-950">WhatsApp</span>
	                                                <span class="mt-1 block text-sm leading-6 text-gray-600">Enable communication with leads through WhatsApp.</span>
	                                            </button>
	                                            <button type="button" x-on:click="toggleChannel('whatsapp')" role="switch" :aria-checked="campaignSetup.channels.whatsapp" class="relative inline-flex h-6 w-11 shrink-0 self-center rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600" :class="campaignSetup.channels.whatsapp ? 'bg-indigo-600' : 'bg-gray-200'">
	                                                <span class="pointer-events-none inline-block size-5 rounded-full bg-white shadow transition duration-200 ease-in-out" :class="campaignSetup.channels.whatsapp ? 'translate-x-5' : 'translate-x-0'"></span>
	                                            </button>
	                                        </div>
	                                    </div>
	                                </div>

	                                <div x-show="campaignSetup.channels.email || campaignSetup.channels.sms || campaignSetup.channels.whatsapp" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-3" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-2" class="overflow-hidden rounded-lg border border-gray-200 bg-white">
	                                    <div class="border-b border-gray-200 px-6 py-5">
	                                        <h3 class="text-base font-semibold text-gray-950">Email &amp; Message Content</h3>
	                                    </div>
		                                    <div class="divide-y divide-gray-200">
		                                        <div class="px-6 py-6">
		                                            <div>
		                                                <h4 class="text-sm font-semibold leading-6 text-gray-950">Link Tracking Structure</h4>
		                                                <p class="mt-1 text-sm leading-6 text-gray-600">Configure abandoned cart link tracking.</p>
		                                            </div>
		                                            <div class="mt-5 space-y-5">
		                                                <label class="block">
		                                                    <span class="block text-sm/6 font-medium text-gray-900">Link Source</span>
		                                                    <div class="mt-2 grid grid-cols-1">
		                                                        <select x-model="campaignSetup.cartLinkSource" class="col-start-1 row-start-1 block w-full appearance-none rounded-md bg-white py-1.5 pl-3 pr-8 text-sm/6 text-gray-900 shadow-sm outline outline-1 -outline-offset-1 outline-gray-300 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600">
		                                                            <option>Static (Manually set URL below)</option>
		                                                            <option>Dynamic (Use URL from lead data)</option>
		                                                        </select>
		                                                        <span class="outcraft-icon pointer-events-none col-start-1 row-start-1 mr-3 self-center justify-self-end text-gray-500">keyboard_arrow_down</span>
		                                                    </div>
		                                                    <span class="mt-2 block text-sm leading-6 text-gray-500">Choose whether the base URL is manually entered or pulled from lead data.</span>
		                                                </label>
		                                                <label class="block">
		                                                    <span class="block text-sm/6 font-medium text-gray-900">Link Structure</span>
		                                                    <input x-model="campaignSetup.cartLinkStructure" type="text" :placeholder="campaignSetup.cartLinkSource === 'Static (Manually set URL below)' ? 'https://outcraft.ai/cart?utm_source=outcraft&utm_medium=email' : '@{{cart_url}}?utm_source=outcraft&utm_medium=email'" class="mt-2 block w-full rounded-md bg-white px-3 py-1.5 text-sm/6 text-gray-900 shadow-sm outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600">
		                                                    <span class="mt-2 block text-sm leading-6 text-gray-500" x-text="cartLinkStructureExample()"></span>
		                                                </label>
		                                            </div>
		                                        </div>

		                                        <div class="px-6 py-6">
	                                            <button type="button" x-on:click="campaignSetup.shortenLinks = ! campaignSetup.shortenLinks; scheduleCampaignBuilderLayoutUpdate()" role="switch" :aria-checked="campaignSetup.shortenLinks" class="flex w-full items-center justify-between gap-4 rounded-md text-left focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
	                                                <span class="min-w-0">
	                                                    <span class="block text-sm font-semibold leading-6 text-gray-950">Shorten Links in Messages</span>
	                                                    <span class="mt-1 block text-sm leading-6 text-gray-600">Shortens message links for cleaner tracking and delivery-friendly formatting. Links will resolve through ocrft.co/...</span>
	                                                </span>
	                                                <span class="relative inline-flex h-6 w-11 shrink-0 self-center rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out" :class="campaignSetup.shortenLinks ? 'bg-indigo-600' : 'bg-gray-200'">
	                                                    <span class="pointer-events-none inline-block size-5 rounded-full bg-white shadow transition duration-200 ease-in-out" :class="campaignSetup.shortenLinks ? 'translate-x-5' : 'translate-x-0'"></span>
	                                                </span>
	                                            </button>
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
                                </div>
	                            </section>

                            <section x-cloak x-show="campaignSetup.current === 'discounts' || campaignSetupScrollFromStep === 'discounts'" x-ref="campaignSetupStep_discounts"
                                :style="campaignSetupStepStyle('discounts')"
                                data-campaign-setup-step
                                class="space-y-6 pr-2 pb-4">
                                <div class="mb-1">
                                    <p class="text-sm font-semibold text-indigo-600" x-text="`${campaignSetupMode === 'fast' ? 'Fast Setup' : 'Advanced Setup'} · Step ${campaignSetupStepIndex('discounts') + 1} of ${campaignSetupStepsForMode().length}`"></p>
                                    <span class="mb-4 flex size-10 items-center justify-center rounded-md bg-indigo-50 text-indigo-600">
                                        <span class="outcraft-icon !text-[21px]" x-text="campaignSetupStepIcon('discounts')"></span>
                                    </span>
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

                                <div class="bg-white">
                                    <div x-show="campaignSetup.discountCodes.length === 0" class="py-10 text-center">
                                        <p class="text-sm font-medium text-gray-900">No Discount Codes</p>
                                        <p class="mt-1 text-sm leading-6 text-gray-500">Add Codes the AI can include when discount content is enabled.</p>
                                    </div>
                                    <div x-show="campaignSetup.discountCodes.length > 0" class="divide-y divide-gray-200">
                                        <template x-for="code in campaignSetup.discountCodes" :key="code.value">
                                            <div class="flex items-center justify-between gap-4 py-3">
                                                <div class="min-w-0">
                                                    <p class="truncate text-sm font-semibold leading-6 text-gray-950" x-text="code.value"></p>
                                                    <p class="text-sm leading-6 text-gray-500" x-text="`Created ${code.created}`"></p>
                                                </div>
                                                <button type="button" x-on:click="campaignSetup.discountCodes = campaignSetup.discountCodes.filter((item) => item.value !== code.value)" class="inline-flex size-8 shrink-0 items-center justify-center rounded-md text-gray-400 transition hover:bg-gray-50 hover:text-red-600" aria-label="Remove Discount Code">
                                                    <span class="outcraft-icon !text-[18px]">delete</span>
                                                </button>
                                            </div>
                                        </template>
                                    </div>
                                </div>
                            </section>

                            <section x-cloak x-show="campaignSetup.current === 'booking' || campaignSetupScrollFromStep === 'booking'" x-ref="campaignSetupStep_booking"
                                :style="campaignSetupStepStyle('booking')"
                                data-campaign-setup-step
                                class="space-y-6 pr-2 pb-4">
                                <div class="mb-1">
                                    <p class="text-sm font-semibold text-indigo-600" x-text="`${campaignSetupMode === 'fast' ? 'Fast Setup' : 'Advanced Setup'} · Step ${campaignSetupStepIndex('booking') + 1} of ${campaignSetupStepsForMode().length}`"></p>
                                    <span class="mb-4 flex size-10 items-center justify-center rounded-md bg-indigo-50 text-indigo-600">
                                        <span class="outcraft-icon !text-[21px]" x-text="campaignSetupStepIcon('booking')"></span>
                                    </span>
                                    <h2 class="mt-2 text-2xl font-bold leading-8 tracking-tight text-gray-950" x-text="campaignSetupHeading('booking')"></h2>
                                    <p class="mt-2 max-w-3xl text-sm leading-6 text-gray-600" x-text="campaignSetupDescription('booking')"></p>
                                </div>

                                <div class="space-y-8">
                                    <label class="block">
                                        <span class="block text-sm/6 font-semibold text-gray-900">Which Calendar Service Do You Use?</span>
                                        <div class="mt-2 grid grid-cols-1">
                                            <select x-model="campaignSetup.calendarService" x-on:change="campaignSetup.calendarConnectionStatus = ''; scheduleCampaignBuilderLayoutUpdate()" class="col-start-1 row-start-1 block w-full appearance-none rounded-md bg-white py-1.5 pr-8 pl-3 text-sm/6 text-gray-900 shadow-sm outline outline-1 -outline-offset-1 outline-gray-300 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600">
                                                <option value="">Select an Option</option>
                                                <option>HubSpot</option>
                                                <option>Calendly</option>
                                            </select>
                                            <span class="outcraft-icon pointer-events-none col-start-1 row-start-1 mr-3 self-center justify-self-end text-gray-500">keyboard_arrow_down</span>
                                        </div>
                                        <span class="mt-2 block text-sm leading-6 text-gray-600">Select the calendar service you use for booking appointments.</span>
                                    </label>

                                    <div x-show="campaignSetup.calendarService" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-3" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-2" class="rounded-lg border border-gray-200 bg-white p-6 shadow-sm">
                                        <div class="flex flex-col gap-4 sm:flex-row sm:items-start">
                                            <span class="flex size-[60px] shrink-0 items-center justify-center rounded-md" :class="calendarServiceLogoContainerClass(campaignSetup.calendarService)">
                                                <span x-show="calendarServiceLogoHtml(campaignSetup.calendarService)" class="outcraft-source-logo outcraft-source-logo-lg" x-html="calendarServiceLogoHtml(campaignSetup.calendarService)"></span>
                                                <span x-show="! calendarServiceLogoHtml(campaignSetup.calendarService)" class="outcraft-icon !text-[32px]" x-text="'calendar_month'"></span>
                                            </span>
                                            <div class="min-w-0 flex-1">
                                                <h3 class="text-sm font-semibold leading-6 text-gray-950" x-text="campaignSetup.calendarService"></h3>
                                                <p class="mt-2 text-sm leading-6 text-gray-600">Connect your calendar service to sync booking links, availability, and meeting events for this campaign.</p>
                                                <div class="mt-5 flex flex-wrap items-center gap-3">
                                                    <button type="button" x-on:click="connectCalendarService()" class="inline-flex h-9 items-center rounded-md bg-indigo-600 px-3 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-500" x-text="`Connect ${campaignSetup.calendarService}`"></button>
                                                    <span x-show="campaignSetup.calendarConnectionStatus === 'Connected'" class="inline-flex rounded-md bg-green-50 px-2 py-1 text-xs font-medium text-green-700 ring-1 ring-inset ring-green-600/20">Connected</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="rounded-lg border border-gray-200 p-6">
                                        <h3 class="text-sm font-semibold text-gray-900">Links</h3>
                                        <div class="mt-6 space-y-6">
                                            <div class="rounded-md bg-amber-50 p-4 ring-1 ring-inset ring-amber-100">
                                                <div class="flex gap-3">
                                                    <span class="outcraft-icon mt-0.5 text-amber-500">report</span>
                                                    <p class="text-sm leading-6 text-amber-800">The Booking Link for Calls must use the default form settings. Do not add required fields, CAPTCHA, consent checkboxes, or any additional validation. Extra form requirements will prevent the AI agent from completing bookings during calls successfully!</p>
                                                </div>
                                            </div>

                                            <div class="space-y-6">
                                                <label class="block">
                                                    <span class="block text-sm/6 font-semibold text-gray-900">Booking Link for Calls<span class="text-indigo-400">*</span></span>
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
                                    <span class="mb-4 flex size-10 items-center justify-center rounded-md bg-indigo-50 text-indigo-600">
                                        <span class="outcraft-icon !text-[21px]" x-text="campaignSetupStepIcon('availability')"></span>
                                    </span>
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
	                                                    <span class="block text-sm/6 font-semibold text-gray-900">Outreach Start Hour<span class="text-indigo-400">*</span></span>
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
	                                                    <span class="block text-sm/6 font-semibold text-gray-900">Outreach End Hour<span class="text-indigo-400">*</span></span>
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
                                    <div data-step-icon-row data-step-actions-align-top>
                                        <span class="flex size-10 items-center justify-center rounded-md bg-indigo-50 text-indigo-600">
                                            <span class="outcraft-icon !text-[21px]" x-text="campaignSetupStepIcon('sequence')"></span>
                                        </span>
                                        <button type="button" x-on:click="campaignSetup.sequenceModalOpen = true; campaignSetup.sequenceEditingIndex = null" class="inline-flex h-9 w-full items-center justify-center rounded-md bg-indigo-600 px-3 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-500 sm:w-auto">Add Step</button>
                                    </div>
                                    <h2 class="mt-2 text-2xl font-bold leading-8 tracking-tight text-gray-950" x-text="campaignSetupHeading('sequence')"></h2>
                                    <p class="mt-2 max-w-3xl text-sm leading-6 text-gray-600" x-text="campaignSetupDescription('sequence')"></p>
                                </div>
                                <div class="space-y-0">
                                    <template x-for="(row, index) in sequenceRows" :key="row.id">
                                        <div class="relative" :class="index === sequenceRows.length - 1 ? 'pb-0' : 'pb-8'">
                                            <article class="relative rounded-lg border border-gray-200 bg-white p-4 shadow-sm transition hover:border-gray-300 hover:shadow">
                                                <div class="flex items-start justify-between gap-4">
                                                    <div class="flex min-w-0 items-start gap-4">
                                                        <span class="flex size-10 shrink-0 items-center justify-center rounded-md" :class="sequenceChannelIconTileClass(row.channel)">
                                                            <span class="outcraft-icon !text-[21px]" x-text="sequenceChannelIcon(row.channel)"></span>
                                                        </span>
                                                        <div class="min-w-0">
                                                            <div class="flex flex-col items-start gap-1">
                                                                <span class="text-sm font-semibold leading-6 text-gray-950" x-text="sequenceChannelLabel(row.channel)"></span>
                                                                <span class="inline-flex rounded-md bg-gray-50 px-2 py-1 text-xs font-medium text-gray-600 ring-1 ring-inset ring-gray-500/10" x-text="sequenceDelayLabel(row.delay)"></span>
                                                            </div>
                                                            <p class="mt-2 text-sm leading-6 text-gray-600" x-text="row.step"></p>
                                                        </div>
                                                    </div>
                                                    <div class="relative shrink-0" x-on:click.outside="campaignSetup.sequenceActionOpen === row.id && (campaignSetup.sequenceActionOpen = '')">
                                                        <button type="button" x-on:click="campaignSetup.sequenceActionOpen = campaignSetup.sequenceActionOpen === row.id ? '' : row.id" class="inline-flex size-8 items-center justify-center rounded-md text-gray-400 transition hover:bg-gray-50 hover:text-gray-700" aria-label="Open Sequence Step Actions">
                                                            <span class="outcraft-icon !text-[20px]">more_vert</span>
                                                        </button>
                                                        <div x-cloak x-show="campaignSetup.sequenceActionOpen === row.id" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="opacity-0 translate-y-1" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-1" class="absolute right-0 z-30 mt-2 w-44 rounded-md bg-white py-1 shadow-lg ring-1 ring-gray-900/10">
                                                            <button type="button" x-on:click="moveSequenceRow(index, -1)" :disabled="index === 0" class="flex w-full items-center gap-2 rounded-md px-3 py-2 text-left text-sm font-medium text-gray-700 transition hover:bg-gray-50 hover:text-gray-950 disabled:cursor-not-allowed disabled:opacity-40">
                                                                <span class="outcraft-icon !text-[17px]">arrow_upward</span>
                                                                <span>Move Up</span>
                                                            </button>
                                                            <button type="button" x-on:click="moveSequenceRow(index, 1)" :disabled="index === sequenceRows.length - 1" class="flex w-full items-center gap-2 rounded-md px-3 py-2 text-left text-sm font-medium text-gray-700 transition hover:bg-gray-50 hover:text-gray-950 disabled:cursor-not-allowed disabled:opacity-40">
                                                                <span class="outcraft-icon !text-[17px]">arrow_downward</span>
                                                                <span>Move Down</span>
                                                            </button>
                                                            <button type="button" x-on:click="editSequenceRow(index)" class="flex w-full items-center gap-2 rounded-md px-3 py-2 text-left text-sm font-medium text-gray-700 transition hover:bg-gray-50 hover:text-gray-950">
                                                                <span class="outcraft-icon !text-[17px]">edit</span>
                                                                <span>Edit</span>
                                                            </button>
                                                            <button type="button" x-on:click="deleteSequenceRow(index)" class="flex w-full items-center gap-2 rounded-md px-3 py-2 text-left text-sm font-medium text-red-600 transition hover:bg-red-50 hover:text-red-700">
                                                                <span class="outcraft-icon !text-[17px]">delete</span>
                                                                <span>Delete</span>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <span x-show="index < sequenceRows.length - 1" class="pointer-events-none absolute -bottom-[10px] left-1/2 z-10 -translate-x-1/2">
                                                    <span class="block size-0 border-l-[10px] border-r-[10px] border-t-[10px] border-l-transparent border-r-transparent border-t-gray-200"></span>
                                                    <span class="absolute -top-px left-1/2 block size-0 -translate-x-1/2 border-l-[9px] border-r-[9px] border-t-[9px] border-l-transparent border-r-transparent border-t-white"></span>
                                                </span>
                                            </article>
                                        </div>
                                    </template>
                                </div>
                            </section>

                            <section x-cloak x-show="campaignSetup.current === 'followups' || campaignSetupScrollFromStep === 'followups'" x-ref="campaignSetupStep_followups"
                                :style="campaignSetupStepStyle('followups')"
                                data-campaign-setup-step
                                class="space-y-6 pr-2 pb-4">
                                <div class="mb-1">
                                    <p class="text-sm font-semibold text-indigo-600" x-text="`${campaignSetupMode === 'fast' ? 'Fast Setup' : 'Advanced Setup'} · Step ${campaignSetupStepIndex('followups') + 1} of ${campaignSetupStepsForMode().length}`"></p>
                                    <span class="mb-4 flex size-10 items-center justify-center rounded-md bg-indigo-50 text-indigo-600">
                                        <span class="outcraft-icon !text-[21px]" x-text="campaignSetupStepIcon('followups')"></span>
                                    </span>
                                    <h2 class="mt-2 text-2xl font-bold leading-8 tracking-tight text-gray-950" x-text="campaignSetupHeading('followups')"></h2>
                                    <p class="mt-2 max-w-3xl text-sm leading-6 text-gray-600" x-text="campaignSetupDescription('followups')"></p>
                                </div>
                                    <div class="space-y-5">
                                            <button type="button" x-on:click="toggleFollowupSequence('followupPositive', 'positive')" role="switch" :aria-checked="campaignSetup.followupPositive" class="flex w-full items-center justify-between gap-4 rounded-md text-left focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                                                <span class="min-w-0">
                                                    <span class="block text-sm font-semibold leading-6 text-gray-950">After a Positive Response</span>
                                                    <span class="mt-1 block text-sm leading-6 text-gray-600">Follow up to confirm the next step, share details, or check if the lead needs anything else.</span>
                                                </span>
                                                <span class="relative inline-flex h-6 w-11 shrink-0 self-center rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out" :class="campaignSetup.followupPositive ? 'bg-indigo-600' : 'bg-gray-200'">
                                                    <span class="pointer-events-none inline-block size-5 rounded-full bg-white shadow transition duration-200 ease-in-out" :class="campaignSetup.followupPositive ? 'translate-x-5' : 'translate-x-0'"></span>
                                                </span>
                                            </button>

                                            <button type="button" x-on:click="toggleFollowupSequence('followupEngaged', 'engaged')" role="switch" :aria-checked="campaignSetup.followupEngaged" class="flex w-full items-center justify-between gap-4 rounded-md text-left focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                                                <span class="min-w-0">
                                                    <span class="block text-sm font-semibold leading-6 text-gray-950">When a Lead Is Engaged but Undecided</span>
                                                    <span class="mt-1 block text-sm leading-6 text-gray-600">Follow up to answer questions and help the lead move toward a clear yes or no.</span>
                                                </span>
                                                <span class="relative inline-flex h-6 w-11 shrink-0 self-center rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out" :class="campaignSetup.followupEngaged ? 'bg-indigo-600' : 'bg-gray-200'">
                                                    <span class="pointer-events-none inline-block size-5 rounded-full bg-white shadow transition duration-200 ease-in-out" :class="campaignSetup.followupEngaged ? 'translate-x-5' : 'translate-x-0'"></span>
                                                </span>
                                            </button>

                                            <button type="button" x-on:click="toggleFollowupSequence('followupNegative', 'negative')" role="switch" :aria-checked="campaignSetup.followupNegative" class="flex w-full items-center justify-between gap-4 rounded-md text-left focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                                                <span class="min-w-0">
                                                    <span class="block text-sm font-semibold leading-6 text-gray-950">After a Negative Response</span>
                                                    <span class="mt-1 block text-sm leading-6 text-gray-600">Follow up only when there may still be an opportunity to address concerns or objections.</span>
                                                </span>
                                                <span class="relative inline-flex h-6 w-11 shrink-0 self-center rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out" :class="campaignSetup.followupNegative ? 'bg-indigo-600' : 'bg-gray-200'">
                                                    <span class="pointer-events-none inline-block size-5 rounded-full bg-white shadow transition duration-200 ease-in-out" :class="campaignSetup.followupNegative ? 'translate-x-5' : 'translate-x-0'"></span>
                                                </span>
                                            </button>
                                    </div>

                                    <div x-show="campaignSetup.followupPositive || campaignSetup.followupEngaged || campaignSetup.followupNegative" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-3" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-2" class="overflow-hidden rounded-lg border border-gray-200 bg-white">
                                        <div class="px-6 py-5">
                                            <h3 class="text-base font-semibold leading-6 text-gray-950">Follow-Up Sequence</h3>
                                            <p class="mt-2 text-sm leading-6 text-gray-600">Build a follow-up sequence that will be applied for this campaign</p>
                                        </div>
                                        <div class="border-b border-gray-200 px-6">
                                            <nav class="-mb-px flex flex-wrap gap-6" aria-label="Follow-up sequence tabs">
                                                <template x-for="tab in followupSequenceTabs()" :key="tab.id">
                                                    <button type="button" x-on:click="campaignSetup.activeFollowupSequence = tab.id" class="border-b-2 px-1 pb-3 text-sm font-semibold transition" :class="campaignSetup.activeFollowupSequence === tab.id ? 'border-indigo-600 text-indigo-600' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700'">
                                                        <span x-text="tab.label"></span>
                                                    </button>
                                                </template>
                                            </nav>
                                        </div>

                                        <div class="flex flex-wrap items-center justify-between gap-3 px-6 py-5">
                                            <button type="button" class="inline-flex h-9 w-fit shrink-0 self-start items-center rounded-md bg-white px-3 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 transition hover:bg-gray-50">Reorder Actions</button>
                                            <button type="button" x-on:click="campaignSetup.followupModalOpen = true" class="inline-flex h-9 w-fit shrink-0 self-start items-center rounded-md bg-indigo-600 px-3 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-500">Add Step</button>
                                        </div>

                                        <div class="border-t border-gray-200">
                                            <table class="min-w-full text-left text-sm">
                                                <thead>
                                                    <tr>
                                                        <template x-for="head in ['Channel','Label','Relative Delay','Exact Flow Step']" :key="head">
                                                            <th class="border-b border-gray-200 px-6 py-3 font-semibold text-gray-600" x-text="head"></th>
                                                        </template>
                                                    </tr>
                                                </thead>
                                            </table>
                                            <div class="flex min-h-56 flex-col items-center justify-center px-6 py-10 text-center">
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
                                    <span class="mb-4 flex size-10 items-center justify-center rounded-md bg-indigo-50 text-indigo-600">
                                        <span class="outcraft-icon !text-[21px]" x-text="campaignSetupStepIcon('handoff')"></span>
                                    </span>
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
                                    <div data-step-icon-row data-step-actions-align-top>
                                        <span class="flex size-10 items-center justify-center rounded-md bg-indigo-50 text-indigo-600">
                                            <span class="outcraft-icon !text-[21px]" x-text="campaignSetupStepIcon('intelligence')"></span>
                                        </span>
                                        <button type="button" x-on:click="campaignSetup.evaluationDrawerOpen = true" class="inline-flex h-9 w-full items-center justify-center rounded-md bg-indigo-600 px-3 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-500 sm:w-auto">Create New Evaluation</button>
                                    </div>
                                    <h2 class="mt-2 text-2xl font-bold leading-8 tracking-tight text-gray-950" x-text="campaignSetupHeading('intelligence')"></h2>
                                    <p class="mt-2 max-w-3xl text-sm leading-6 text-gray-600" x-text="campaignSetupDescription('intelligence')"></p>
                                </div>
                                <div>
                                    <div class="overflow-hidden rounded-lg border border-gray-200 bg-white">
                                        <table class="min-w-full divide-y divide-gray-200 text-left text-sm">
                                            <thead class="bg-gray-50">
                                                <tr>
                                                    <th class="px-4 py-3 font-semibold text-gray-600">Evaluation</th>
                                                    <th class="px-4 py-3 font-semibold text-gray-600">Response Format</th>
                                                    <th class="px-4 py-3"><span class="sr-only">Actions</span></th>
                                                </tr>
                                            </thead>
                                            <tbody class="divide-y divide-gray-100">
                                                <template x-for="evaluation in conversationIntelligenceEvaluations()" :key="evaluation.id">
                                                    <tr>
                                                        <td class="px-4 py-3">
                                                            <div class="flex flex-wrap items-center gap-2">
                                                                <p class="font-semibold text-gray-950" x-text="evaluation.name"></p>
                                                                <span x-show="evaluation.review" class="inline-flex rounded-md bg-amber-50 px-2 py-1 text-xs font-medium text-amber-700 ring-1 ring-inset ring-amber-600/20">Review</span>
                                                            </div>
                                                            <p class="mt-1 text-gray-500" x-text="evaluation.description"></p>
                                                        </td>
                                                        <td class="px-4 py-3 text-gray-700" x-text="evaluation.format"></td>
                                                        <td class="px-4 py-3 text-right">
                                                            <div class="relative inline-flex" x-on:click.outside="campaignSetup.evaluationActionOpen === evaluation.id && (campaignSetup.evaluationActionOpen = '')">
                                                                <button type="button" x-on:click="campaignSetup.evaluationActionOpen = campaignSetup.evaluationActionOpen === evaluation.id ? '' : evaluation.id" class="inline-flex size-8 items-center justify-center rounded-md text-gray-400 transition hover:bg-gray-50 hover:text-gray-700" aria-label="Open Evaluation Actions">
                                                                    <span class="outcraft-icon !text-[20px]">more_vert</span>
                                                                </button>
                                                                <div x-cloak x-show="campaignSetup.evaluationActionOpen === evaluation.id" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="opacity-0 translate-y-1" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-1" class="absolute right-0 top-full z-30 mt-2 w-36 rounded-md bg-white py-1 text-left shadow-lg ring-1 ring-gray-900/10">
                                                                    <button type="button" x-on:click="editConversationEvaluation(evaluation)" class="flex w-full items-center gap-2 rounded-md px-3 py-2 text-sm font-medium text-gray-700 transition hover:bg-gray-50 hover:text-gray-950">
                                                                        <span class="outcraft-icon !text-[17px]">edit</span>
                                                                        <span>Edit</span>
                                                                    </button>
                                                                    <button type="button" x-on:click="removeConversationEvaluation(evaluation)" class="flex w-full items-center gap-2 rounded-md px-3 py-2 text-sm font-medium text-red-600 transition hover:bg-red-50 hover:text-red-700">
                                                                        <span class="outcraft-icon !text-[17px]">delete</span>
                                                                        <span>Remove</span>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </template>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </section>

                            <section x-cloak x-show="campaignSetup.current === 'geo' || campaignSetupScrollFromStep === 'geo'" x-ref="campaignSetupStep_geo"
                                :style="campaignSetupStepStyle('geo')"
                                data-campaign-setup-step
                                class="space-y-5 pr-2 pb-4">
                                <div class="mb-1">
                                    <p class="text-sm font-semibold text-indigo-600" x-text="`${campaignSetupMode === 'fast' ? 'Fast Setup' : 'Advanced Setup'} · Step ${campaignSetupStepIndex('geo') + 1} of ${campaignSetupStepsForMode().length}`"></p>
                                    <span class="mb-4 flex size-10 items-center justify-center rounded-md bg-indigo-50 text-indigo-600">
                                        <span class="outcraft-icon !text-[21px]" x-text="campaignSetupStepIcon('geo')"></span>
                                    </span>
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
                                    <span class="mb-4 flex size-10 items-center justify-center rounded-md bg-indigo-50 text-indigo-600">
                                        <span class="outcraft-icon !text-[21px]" x-text="campaignSetupStepIcon('dispatch')"></span>
                                    </span>
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
                                    <span class="mb-4 flex size-10 items-center justify-center rounded-md bg-indigo-50 text-indigo-600">
                                        <span class="outcraft-icon !text-[21px]" x-text="campaignSetupStepIcon('priority')"></span>
                                    </span>
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
                                class="pr-2 pb-4">
                                <div>
                                    <span class="mb-4 flex size-10 items-center justify-center rounded-md bg-indigo-50 text-indigo-600">
                                        <span class="outcraft-icon !text-[21px]" x-text="campaignSetupStepIcon('review')"></span>
                                    </span>
                                    <h2 class="text-2xl font-bold leading-8 tracking-tight text-gray-950" x-text="campaignSetupHeading('review')"></h2>
                                    <p class="mt-2 text-sm leading-6 text-gray-600" x-text="campaignSetupDescription('review')"></p>
                                </div>
                                <div class="max-w-xl space-y-5">
                                    <label class="block">
                                        <span class="block text-sm/6 font-semibold text-gray-900">Campaign Name</span>
                                        <input x-model="campaignSetup.name" type="text" placeholder="Generated automatically if left empty" class="mt-2 block w-full rounded-md bg-white px-3 py-1.5 text-sm/6 text-gray-900 shadow-sm outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600">
                                        <span class="mt-2 block text-sm leading-6 text-gray-500">Add a name now, or leave it empty and AI will assign one.</span>
                                    </label>
                                    <div class="flex flex-wrap gap-3">
                                        <button type="button" class="inline-flex h-9 items-center rounded-md bg-white px-3 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 transition hover:bg-gray-50">Test Campaign</button>
                                        <button type="button" x-on:click="publishCampaignSetup()" :disabled="launchBlocked()" class="inline-flex h-9 items-center rounded-md bg-indigo-600 px-3 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-500 disabled:cursor-not-allowed disabled:opacity-40">Launch Campaign</button>
                                    </div>
                                </div>
                            </section>
                            </div>
                        </div>
                        <div x-cloak x-show="campaignSetupModeSelected && ! campaignSetupIntroStep" class="hidden lg:block"></div>

		                        <div x-cloak x-show="campaignSetupModeSelected && ! campaignSetupIntroStep" class="fixed inset-x-0 bottom-0 z-40 flex border-t border-gray-200 bg-white px-4 py-3 lg:px-0 lg:py-4" :style="campaignSetupActionBarStyle">
	                            <div class="flex w-full items-center justify-between gap-3" :style="campaignSetupActionBarContentStyle">
	                                <button type="button" x-on:click="previousCampaignSetupStep()" :disabled="campaignSetupStepIndex() === 0" class="inline-flex h-9 shrink-0 items-center gap-2 rounded-md px-2 text-sm font-semibold text-gray-600 transition hover:bg-gray-50 hover:text-gray-950 disabled:cursor-not-allowed disabled:opacity-40">
	                                    <span class="outcraft-icon !text-[18px]">arrow_upward</span>
	                                    Back
	                                </button>
	                                <div class="flex min-w-0 items-center gap-2 sm:gap-3">
	                                    <button type="button" class="hidden h-9 items-center gap-2 rounded-md bg-white px-3 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 transition hover:bg-gray-50 sm:inline-flex">
	                                        <span class="outcraft-icon !text-[16px] text-gray-500">phone_in_talk</span>
	                                        Test Call
	                                    </button>
                                        <button type="button" class="inline-flex size-9 shrink-0 items-center justify-center rounded-md bg-white text-gray-700 shadow-sm ring-1 ring-inset ring-gray-300 transition hover:bg-gray-50 hover:text-gray-950 sm:hidden" aria-label="Test Call">
                                            <span class="outcraft-icon !text-[18px]">phone_in_talk</span>
                                        </button>
	                                    <button type="button" x-on:click="nextCampaignSetupStep()" :disabled="campaignSetupStepIndex() >= campaignSetupStepsForMode().length - 1 && launchBlocked()" class="inline-flex h-9 min-w-0 items-center gap-2 rounded-md bg-indigo-600 px-3 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-500 disabled:cursor-not-allowed disabled:opacity-40">
	                                        <span class="hidden truncate sm:inline" x-text="campaignSetupContinueLabel()"></span>
	                                        <span class="truncate sm:hidden" x-text="campaignSetupMobileContinueLabel()"></span>
	                                        <span class="outcraft-icon !text-[18px]" x-text="campaignSetupContinueIcon()"></span>
	                                    </button>
	                                </div>
	                            </div>
	                        </div>

                        <div x-cloak x-show="campaignSetup.sequenceModalOpen || campaignSetup.followupModalOpen || campaignSetup.discountCodeModalOpen || campaignSetup.overrideModalOpen" class="fixed inset-0 z-50 flex items-center justify-center bg-gray-950/30 p-4">
                            <div class="w-full max-w-lg rounded-lg bg-white p-6 shadow-2xl">
                                <h2 class="text-lg font-bold text-gray-950" x-text="campaignSetup.overrideModalOpen ? 'Create Campaign Override' : (campaignSetup.discountCodeModalOpen ? 'Add Discount Code' : (campaignSetup.followupModalOpen ? 'Create Flow Template Step' : (campaignSetup.sequenceEditingIndex === null ? 'Create Outreach Sequence Step' : 'Edit Outreach Sequence Step')))"></h2>
                                <div class="mt-5 space-y-4">
                                    <template x-if="campaignSetup.sequenceModalOpen"><div class="grid gap-4"><label class="block"><span class="text-sm font-medium text-gray-900">Channel</span><select class="mt-2 block w-full rounded-md px-3 py-2 text-sm outline outline-1 -outline-offset-1 outline-gray-300"><option>Call</option><option>SMS</option><option>Email</option><option>WhatsApp</option><option value="None">Close Campaign Run</option></select></label><label class="block"><span class="text-sm font-medium text-gray-900">Action / Flow Step</span><select class="mt-2 block w-full rounded-md px-3 py-2 text-sm outline outline-1 -outline-offset-1 outline-gray-300"><option>Select an Option</option></select></label><label class="block"><span class="text-sm font-medium text-gray-900">Wait Before Sending</span><input type="number" value="1" class="mt-2 block w-full rounded-md px-3 py-1.5 text-sm outline outline-1 -outline-offset-1 outline-gray-300"><span class="mt-2 block text-sm text-gray-500">This delay starts after the previous step is completed.</span></label></div></template>
                                    <template x-if="campaignSetup.followupModalOpen"><div class="grid gap-4"><label class="block"><span class="text-sm font-medium text-gray-900">Choose Step</span><select class="mt-2 block w-full rounded-md px-3 py-2 text-sm outline outline-1 -outline-offset-1 outline-gray-300"><option>Select an Option</option></select></label><label class="block"><span class="text-sm font-medium text-gray-900">Delay Dispatch By</span><input type="number" value="0" class="mt-2 block w-full rounded-md px-3 py-1.5 text-sm outline outline-1 -outline-offset-1 outline-gray-300"><span class="mt-2 block text-sm text-gray-500">Will delay this step after the previous step was dispatched.</span></label></div></template>
                                    <template x-if="campaignSetup.discountCodeModalOpen"><div class="grid gap-4"><label class="block"><span class="text-sm font-medium text-gray-900">Discount Code</span><input x-model="campaignSetup.newDiscountCode" type="text" placeholder="25OFF" class="mt-2 block w-full rounded-md px-3 py-1.5 text-sm outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600"><span class="mt-2 block text-sm text-gray-500">Code to include - e.g. SUMMER20, WELCOME10.</span></label></div></template>
                                    <template x-if="campaignSetup.overrideModalOpen"><div class="grid gap-4"><button type="button" class="flex items-start justify-between gap-4 rounded-lg border border-gray-200 p-4 text-left"><span><span class="block text-sm font-medium text-gray-900">Allow Override All Campaigns?</span><span class="mt-1 block text-sm text-gray-500">If enabled, this campaign will have priority over any already running campaign once triggered.</span></span><span class="relative inline-flex h-6 w-11 rounded-full bg-gray-200 p-0.5"><span class="size-5 rounded-full bg-white shadow-sm"></span></span></button><label class="block"><span class="text-sm font-medium text-gray-900">Which Campaign Should Current Campaign Override?</span><select class="mt-2 block w-full rounded-md px-3 py-2 text-sm outline outline-1 -outline-offset-1 outline-gray-300"><option>Select an Option</option><option>Abandoned Cart Recovery</option><option>Web Support</option></select></label></div></template>
                                </div>
                                <div class="mt-6 flex justify-end gap-3"><button type="button" x-on:click="closeCampaignSetupOverlays()" class="inline-flex h-9 items-center rounded-md bg-white px-3 text-sm font-semibold text-gray-900 ring-1 ring-inset ring-gray-300">Cancel</button><button type="button" x-on:click="campaignSetup.discountCodeModalOpen ? addDiscountCode() : closeCampaignSetupOverlays()" class="inline-flex h-9 items-center rounded-md bg-indigo-600 px-3 text-sm font-semibold text-white" x-text="campaignSetup.discountCodeModalOpen ? 'Add Code' : (campaignSetup.sequenceModalOpen && campaignSetup.sequenceEditingIndex !== null ? 'Save' : 'Create')"></button></div>
                            </div>
                        </div>

                        <div
                            x-cloak
                            x-show="campaignSetup.briefBuilderItemModalOpen"
                            x-transition.opacity
                            x-on:keydown.escape.window="closeCampaignSetupOverlays()"
                            class="fixed inset-0 z-50 flex items-center justify-center bg-gray-950/30 p-4"
                        >
                            <div x-on:click="closeCampaignSetupOverlays()" class="absolute inset-0"></div>
                            <div
                                x-show="campaignSetup.briefBuilderItemModalOpen"
                                x-transition:enter="transition ease-out duration-150"
                                x-transition:enter-start="opacity-0 translate-y-3 scale-95"
                                x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                                x-transition:leave="transition ease-in duration-100"
                                x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                                x-transition:leave-end="opacity-0 translate-y-2 scale-95"
                                class="relative flex max-h-[min(680px,calc(100vh-2rem))] w-full max-w-xl flex-col overflow-hidden rounded-lg bg-white shadow-xl ring-1 ring-gray-900/10"
                                role="dialog"
                                aria-modal="true"
                                aria-labelledby="add-campaign-context-item-title"
                            >
                                <div class="border-b border-gray-200 px-6 py-5">
                                    <div class="flex items-start justify-between gap-4">
                                        <div>
                                            <h2 id="add-campaign-context-item-title" class="text-base font-semibold text-gray-950">Add Campaign Context Item</h2>
                                            <p class="mt-1 text-sm leading-6 text-gray-500">Choose a block to add to your custom campaign context.</p>
                                        </div>
                                        <button type="button" x-on:click="closeCampaignSetupOverlays()" class="inline-flex size-8 items-center justify-center rounded-md text-gray-400 transition hover:bg-gray-50 hover:text-gray-700" aria-label="Close">
                                            <span class="outcraft-icon !text-[20px]">close</span>
                                        </button>
                                    </div>
                                    <label class="mt-4 block">
                                        <span class="sr-only">Search Items</span>
                                        <input x-model="campaignSetup.briefBuilderItemSearch" type="search" placeholder="Search Items" class="block h-9 w-full rounded-md bg-white px-3 py-1.5 text-sm text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600">
                                    </label>
                                </div>
                                <div class="min-h-0 flex-1 overflow-y-auto px-6 py-4">
                                    <div class="space-y-6">
                                        <template x-for="group in filteredBriefBuilderItemGroups()" :key="group.label">
                                            <section>
                                                <h3 class="text-xs font-semibold uppercase tracking-wide text-gray-400" x-text="group.label"></h3>
                                                <div class="mt-2 space-y-2">
                                                    <template x-for="option in group.options" :key="option.type">
                                                        <button type="button" x-on:click="addBriefBuilderItem(option.type)" class="flex w-full items-start gap-3 rounded-lg border border-gray-200 bg-white p-4 text-left transition hover:bg-gray-50 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600" :class="briefBuilderHasItem(option.type) ? 'opacity-60' : ''">
                                                            <span class="flex size-9 shrink-0 items-center justify-center rounded-md bg-indigo-50 text-indigo-600">
                                                                <span x-show="briefBuilderItemSvgIcon(option.type)" class="size-[21px]" x-html="briefBuilderItemSvgIcon(option.type)"></span>
                                                                <span x-show="! briefBuilderItemSvgIcon(option.type)" class="outcraft-icon !text-[19px]" x-text="option.icon"></span>
                                                            </span>
                                                            <span class="min-w-0 flex-1">
                                                                <span class="flex items-center gap-2">
                                                                    <span class="text-sm font-semibold text-gray-950" x-text="option.title"></span>
                                                                    <span x-show="briefBuilderHasItem(option.type)" class="inline-flex rounded-md bg-gray-50 px-2 py-0.5 text-xs font-medium text-gray-600 ring-1 ring-inset ring-gray-500/10">Added</span>
                                                                </span>
                                                                <span class="mt-1 block text-sm leading-6 text-gray-500" x-text="option.description"></span>
                                                            </span>
                                                        </button>
                                                    </template>
                                                </div>
                                            </section>
                                        </template>
                                        <p x-show="filteredBriefBuilderItemGroups().length === 0" class="px-1 py-6 text-center text-sm text-gray-500">No Items Found.</p>
                                    </div>
                                </div>
	                            </div>
	                        </div>

	                        <div
	                            x-cloak
	                            x-show="campaignSetup.integrationSkipModalOpen"
                            x-transition.opacity
                            x-on:keydown.escape.window="closeCampaignSetupOverlays()"
                            class="fixed inset-0 z-50 flex items-center justify-center bg-gray-950/30 p-4"
                        >
                            <div x-on:click="closeCampaignSetupOverlays()" class="absolute inset-0"></div>
                            <div
                                x-show="campaignSetup.integrationSkipModalOpen"
                                x-transition:enter="transition ease-out duration-150"
                                x-transition:enter-start="opacity-0 translate-y-3 scale-95"
                                x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                                x-transition:leave="transition ease-in duration-100"
                                x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                                x-transition:leave-end="opacity-0 translate-y-2 scale-95"
                                class="relative w-full max-w-lg rounded-lg bg-white p-6 text-center shadow-xl ring-1 ring-gray-900/10"
                                role="dialog"
                                aria-modal="true"
                                aria-labelledby="skip-integration-title"
                            >
                                <button type="button" x-on:click="closeCampaignSetupOverlays()" class="absolute right-4 top-4 inline-flex size-8 items-center justify-center rounded-md text-gray-400 transition hover:bg-gray-50 hover:text-gray-700" aria-label="Close">
                                    <span class="outcraft-icon !text-[22px]">close</span>
                                </button>
                                <div class="mx-auto flex size-12 items-center justify-center rounded-full bg-indigo-50 text-indigo-600">
                                    <span class="outcraft-icon !text-[24px]">report</span>
                                </div>
                                <h2 id="skip-integration-title" class="mt-5 text-base font-bold text-gray-950">Set Up Lead Source Later?</h2>
                                <p class="mt-2 text-sm leading-6 text-gray-500">Without custom fields or merge tags, AI will have less context to personalize conversations.</p>
                                <div class="mt-6 flex justify-center gap-3">
                                    <button type="button" x-on:click="closeCampaignSetupOverlays()" class="inline-flex h-9 min-w-28 items-center justify-center rounded-md bg-white px-3 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 transition hover:bg-gray-50">Cancel</button>
                                    <button type="button" x-on:click="confirmSkipCampaignIntegration()" class="inline-flex h-9 min-w-28 items-center justify-center rounded-md bg-indigo-600 px-3 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-500">Setup Later</button>
                                </div>
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
                <h1 class="text-3xl font-bold leading-tight tracking-normal">Welcome Back!</h1>
                <p class="mt-2 text-sm leading-6 text-white/90">Track your campaigns, review leads, or continue where you left off.</p>
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
                    <h2 class="text-xl font-bold leading-tight text-gray-950">Pinned Campaigns</h2>
                    <ul role="list" class="mt-4 divide-y divide-gray-100">
                        <template x-for="campaign in pinnedCampaigns" :key="campaign.name">
                            <li x-data="{ actionsOpen: false }" class="flex items-center justify-between gap-x-6 py-4">
                                <div class="flex min-w-0 items-center gap-x-4">
                                    <span class="flex size-10 shrink-0 items-center justify-center rounded-md bg-indigo-50 text-indigo-600">
                                        <span class="outcraft-icon !text-[22px]" x-text="campaignAvatarIcon(campaign)"></span>
                                    </span>
                                    <div class="min-w-0">
                                        <div class="flex flex-wrap items-center gap-x-3 gap-y-2">
                                            <p class="truncate text-sm font-semibold leading-6 text-gray-950" x-text="campaign.name"></p>
                                            <span
                                                class="outcraft-label inline-flex rounded-full px-2 py-1 text-xs font-medium ring-1 ring-inset"
                                                :class="campaign.status === 'Running' ? 'bg-green-50 text-green-700 ring-green-600/20' : 'bg-gray-50 text-gray-600 ring-gray-500/10'"
                                            >
                                                <span x-text="campaign.status"></span>
                                            </span>
                                        </div>
                                        <div class="mt-1 flex flex-wrap items-center gap-x-2 gap-y-1 text-xs leading-5 text-gray-500">
                                            <p class="whitespace-nowrap">Modified <span x-text="campaign.modified"></span></p>
                                            <span class="size-0.5 rounded-full bg-gray-400"></span>
                                            <p class="truncate">by <span x-text="campaign.owner"></span></p>
                                        </div>
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
                    <h1 class="text-xl font-bold leading-tight text-gray-950" x-text="activeCampaignPageTab"></h1>
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
                                    <div class="flex flex-wrap items-center gap-x-3 gap-y-2">
                                        <p class="truncate text-sm font-semibold leading-6 text-gray-950" x-text="campaign.name"></p>
                                        <span
                                            class="outcraft-label inline-flex rounded-full px-2 py-1 text-xs font-medium ring-1 ring-inset"
                                            :class="campaign.status === 'Running' ? 'bg-green-50 text-green-700 ring-green-600/20' : 'bg-gray-50 text-gray-600 ring-gray-500/10'"
                                        >
                                            <span x-text="campaign.status"></span>
                                        </span>
                                        <span
                                            x-show="campaign.change"
                                            class="outcraft-label inline-flex rounded-full bg-amber-50 px-2 py-1 text-xs font-medium text-amber-800 ring-1 ring-inset ring-amber-600/20"
                                        >
                                            <span x-text="campaign.change"></span>
                                        </span>
                                </div>
                                <div class="mt-1 flex flex-wrap items-center gap-x-2 gap-y-1 text-xs leading-5 text-gray-500">
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

        <section x-cloak x-show="activeNav === 'Analytics'" class="mx-6 border-b border-gray-200">
            <nav aria-label="Analytics tabs" class="-mb-px flex space-x-8">
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

        <section x-cloak x-show="activeNav === 'Analytics'" class="mx-6 mb-6 mt-5">
            <div class="mb-5 flex min-h-[54px] items-center justify-between">
                <div>
                    <h1 class="text-xl font-bold leading-tight text-gray-950" x-text="activeInsightsTab"></h1>
                    <p class="mt-1 text-sm text-gray-500" x-text="insightsSubtitle()"></p>
                </div>
                <div class="flex items-center gap-3 text-sm text-gray-700">
                    <div x-show="activeInsightsTab === 'Engagement'" class="flex items-center gap-2 rounded-lg bg-white p-1 shadow-sm ring-1 ring-gray-900/5">
                        <template x-for="channel in engagementChannels" :key="channel.label">
                            <button
                                type="button"
                                x-on:click="toggleEngagementChannel(channel.label)"
                                class="inline-flex h-8 items-center gap-2 rounded-lg px-3 text-xs font-semibold transition"
                                :class="selectedEngagementChannels.includes(channel.label) ? 'bg-indigo-100 text-indigo-700' : 'text-gray-600 hover:bg-gray-100 hover:text-gray-950'"
                            >
                                <span class="outcraft-icon !text-[16px]" x-text="channel.icon"></span>
                                <span x-text="channel.label"></span>
                            </button>
                        </template>
                    </div>
                    <button type="button" class="inline-flex h-10 items-center gap-2 rounded-lg border border-gray-200 bg-white px-4 text-sm font-semibold text-gray-800 shadow-sm transition hover:bg-gray-50 hover:text-gray-950">
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
                                    <p class="text-sm font-medium text-gray-500" x-text="metric.label"></p>
                                    <p class="mt-3 text-2xl font-bold leading-none text-gray-950" x-text="metric.value"></p>
                                </div>
                                <span class="outcraft-icon rounded-lg bg-gray-100 p-2 text-gray-700" x-text="metric.icon"></span>
                            </div>
                            <div class="mt-4 flex items-center gap-2 text-sm">
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
                            <h2 class="text-lg font-bold text-gray-950" x-text="insightsChartTitle()"></h2>
                            <span class="rounded-lg border border-gray-200 bg-gray-50 px-3 py-1 text-xs font-medium text-gray-600">Last 30 Days</span>
                        </div>
                        <div class="mt-6 flex h-[260px] items-end gap-3 border-b border-l border-gray-200 px-4 pb-4">
                            <template x-for="bar in insightsBars()" :key="bar.label">
                                <div class="flex min-w-0 flex-1 flex-col items-center gap-2">
                                    <div class="w-full rounded-t-lg bg-gray-900" :style="`height: ${bar.height}%`"></div>
                                    <span class="text-xs font-medium text-gray-500" x-text="bar.label"></span>
                                </div>
                            </template>
                        </div>
                    </div>

                    <div class="rounded-lg bg-white p-6 shadow-sm ring-1 ring-gray-900/5">
                        <h2 class="text-lg font-bold text-gray-950">Focus Areas</h2>
                        <div class="mt-5 space-y-4">
                            <template x-for="item in insightsFocusAreas()" :key="item.title">
                                <div>
                                    <div class="flex items-center justify-between gap-3 text-sm">
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
                        <h2 class="text-lg font-bold text-gray-950">Recent Signals</h2>
                        <span class="text-sm font-medium text-gray-500" x-text="activeInsightsTab"></span>
                    </div>
                    <table class="w-full table-fixed border-collapse text-sm">
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
                                    <td class="px-6 py-4 align-top font-medium text-gray-950" x-text="signal.name"></td>
                                    <td class="px-4 py-4 align-top text-gray-700" x-text="signal.segment"></td>
                                    <td class="px-4 py-4 align-top">
                                        <span class="inline-flex rounded-md px-2 py-1 text-xs font-medium ring-1 ring-inset" :class="signal.impact === 'High' ? 'bg-green-50 text-green-700 ring-green-600/20' : 'bg-gray-50 text-gray-600 ring-gray-500/10'" x-text="signal.impact"></span>
                                    </td>
                                    <td class="px-4 py-4 align-top text-gray-700" x-text="signal.confidence"></td>
                                    <td class="px-4 py-4 align-top font-semibold text-gray-600">View</td>
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
                    <h1 class="text-2xl font-bold leading-tight text-gray-950">Lead Profile</h1>
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
                            <dd class="mt-1 flex items-center gap-2 text-sm/6 text-gray-700 sm:mt-2">
                                <span class="inline-flex size-5 shrink-0 overflow-hidden rounded-full ring-1 ring-gray-200">
                                    <img :src="countryFlagUrl(selectedLead?.countryFlagCode || selectedLead?.country || 'US')" :alt="`${leadCountryOption(selectedLead?.country || 'US').name} flag`" class="size-full object-cover" loading="lazy">
                                </span>
                                <span x-text="leadCountryOption(selectedLead?.country || 'US').name"></span>
                            </dd>
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
                    <h1 class="text-xl font-bold leading-tight tracking-normal">Leads</h1>
                    <p class="mt-1 text-sm text-gray-500">Browse and manage all your leads</p>
                </div>

                <div class="relative" x-on:click.outside="searchOpen = false">
                    <div class="rounded-lg bg-white shadow-sm ring-1 ring-gray-900/5">
                        <div class="flex min-h-10 items-center px-4">
                            <input
                                x-model="query"
                                x-on:focus="searchOpen = true"
                                x-on:keydown.escape="searchOpen = false"
                                x-on:keydown.enter.prevent="addFirstSuggestion()"
                                class="w-full border-0 bg-transparent text-sm outline-none ring-0 placeholder:text-gray-400 focus:ring-0"
                                placeholder="Filter anything"
                            >
                        </div>
                        <div x-show="filters.length > 0" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-3" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-2" class="flex min-h-10 items-center gap-2 border-t border-gray-200 px-4">
                            <template x-for="tag in filters" :key="tag">
                                <button x-on:click="removeFilter(tag)" class="inline-flex items-center gap-1 rounded-lg border border-gray-200 bg-gray-50 px-2 py-1 text-sm leading-none text-gray-600">
                                    <span x-text="tag"></span>
                                    <span class="text-gray-500">×</span>
                                </button>
                            </template>
                            <div class="ml-auto flex items-center gap-4">
                                <button class="text-sm font-semibold text-gray-500 hover:text-gray-900" x-on:click="clearSearchTags()">Clear</button>
                                <button class="text-sm font-semibold text-gray-600 hover:text-gray-900" x-on:click="savePreset()">Save Preset</button>
                            </div>
                        </div>
                    </div>

                    <div x-cloak x-show="searchOpen" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-3" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-2" class="absolute left-0 right-0 top-0 z-30 rounded-md bg-white p-5 shadow-lg ring-1 ring-gray-900/5">
                        <input x-model="query" x-ref="leadsOverlayInput" x-init="$watch('searchOpen', value => value && activeTab === 'Leads' && $nextTick(() => $refs.leadsOverlayInput.focus()))" class="w-full border-0 bg-transparent text-base outline-none ring-0 focus:ring-0" placeholder="Filter anything">
                        <div class="filter-scroll mt-4 max-h-[215px] space-y-1 overflow-y-auto pr-2">
                            <template x-for="group in groupedSuggestions()" :key="group.column">
                                <div>
                                    <div class="px-1 py-2 text-sm font-semibold" x-text="group.column"></div>
                                    <template x-for="value in group.values" :key="group.column + value">
                                        <button x-on:click="addFilter(value)" class="block w-full rounded-lg px-1 py-2 text-left text-sm hover:bg-gray-50" x-text="value"></button>
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
                        <button type="button" x-on:click="clearFilters()" class="block w-full rounded-lg px-3 py-2 text-left font-semibold hover:bg-gray-50">Clear Filters</button>
                        <template x-for="preset in presets" :key="preset.name">
                            <div class="group flex items-center rounded-lg hover:bg-gray-50">
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

            <div class="flex min-h-[74px] items-center justify-between gap-3 border-y border-gray-200 bg-white px-6">
                <label class="inline-flex items-center gap-3 text-sm font-semibold text-gray-700">
                    <span class="grid size-4 shrink-0 grid-cols-1">
                        <input
                            type="checkbox"
                            :checked="allVisibleLeadsSelected()"
                            x-effect="$el.indeterminate = someVisibleLeadsSelected()"
                            x-on:change="toggleVisibleLeadSelection()"
                            class="col-start-1 row-start-1 appearance-none rounded border border-gray-300 bg-white checked:border-indigo-600 checked:bg-indigo-600 indeterminate:border-indigo-600 indeterminate:bg-indigo-600 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
                        >
                        <svg x-show="allVisibleLeadsSelected()" viewBox="0 0 14 14" fill="none" class="pointer-events-none col-start-1 row-start-1 size-3 self-center justify-self-center stroke-white">
                            <path d="M3 8L6 11L11 3.5" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        <svg x-show="someVisibleLeadsSelected()" viewBox="0 0 14 14" fill="none" class="pointer-events-none col-start-1 row-start-1 size-3 self-center justify-self-center stroke-white">
                            <path d="M3 7H11" stroke-width="2" stroke-linecap="round" />
                        </svg>
                    </span>
                    <span>Select All</span>
                </label>

                <div x-show="selectedLeadIds.length === 0" class="flex items-center justify-end gap-3">
                    <button type="button" x-on:click="addFilter('Review Required')" class="inline-flex h-9 items-center gap-2 rounded-lg border border-gray-200 bg-white px-3 text-sm font-semibold text-gray-800 shadow-sm transition hover:bg-gray-50">
                        <span class="outcraft-icon !text-[18px] text-gray-500">manage_search</span>
                        Review Required
                    </button>
                    <div class="relative inline-flex" x-on:click.outside="leadAddMenuOpen = false">
                        <div class="inline-flex h-9 overflow-hidden rounded-lg border border-gray-200 bg-white shadow-sm">
                            <button type="button" x-on:click="leadAddMenuOpen = false" class="inline-flex items-center gap-2 px-3 text-sm font-semibold text-gray-800 transition hover:bg-gray-50">
                                <span class="outcraft-icon !text-[18px] text-gray-500">add</span>
                                Add Lead
                            </button>
                            <button type="button" x-on:click="leadAddMenuOpen = ! leadAddMenuOpen" class="inline-flex w-9 items-center justify-center border-l border-gray-200 bg-white text-gray-500 transition hover:bg-gray-50 hover:text-gray-700" aria-label="More lead actions">
                                <span class="outcraft-icon !text-[18px]">keyboard_arrow_down</span>
                            </button>
                        </div>
                        <div x-cloak x-show="leadAddMenuOpen" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="opacity-0 translate-y-1" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-1" class="absolute right-0 top-11 z-40 w-44 rounded-md bg-white p-1 text-sm shadow-lg ring-1 ring-gray-900/10">
                            <button type="button" x-on:click="leadAddMenuOpen = false" class="flex w-full items-center gap-2 rounded-md px-3 py-2 text-left font-medium text-gray-700 transition hover:bg-gray-50 hover:text-gray-900">
                                <span class="outcraft-icon !text-[18px] text-gray-500">upload</span>
                                Import CSV
                            </button>
                        </div>
                    </div>
                </div>

                <div
                    x-cloak
                    x-show="selectedLeadIds.length > 0"
                    x-transition:enter="transition ease-out duration-150"
                    x-transition:enter-start="opacity-0 translate-y-1"
                    x-transition:enter-end="opacity-100 translate-y-0"
                    x-transition:leave="transition ease-in duration-100"
                    x-transition:leave-start="opacity-100 translate-y-0"
                    x-transition:leave-end="opacity-0 translate-y-1"
                    class="relative flex items-center justify-end gap-3"
                >
                    <span class="text-sm font-medium text-gray-500" x-text="`${selectedLeadIds.length} Selected`"></span>
                    <button type="button" x-on:click.stop="$wire.mountAction('deleteSelectedLeads', { ids: Array.from(selectedLeadIds) })" class="inline-flex h-9 items-center gap-2 rounded-md bg-white px-3 text-sm font-semibold text-red-600 shadow-sm ring-1 ring-inset ring-red-200 transition hover:bg-red-50 hover:text-red-700">
                        <span class="outcraft-icon !text-[18px]">delete</span>
                        Delete
                    </button>
                    <button type="button" x-on:click="openLeadAssignModal()" class="inline-flex h-9 items-center gap-2 rounded-md bg-white px-3 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 transition hover:bg-gray-50 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                        Assign Campaign
                        <span class="outcraft-icon !text-[18px] text-gray-500">arrow_forward</span>
                    </button>
                </div>
            </div>

            <div
                x-cloak
                x-show="leadAssignModalOpen"
                x-transition.opacity
                x-on:keydown.escape.window="closeLeadAssignModal()"
                class="fixed inset-0 z-50 flex items-center justify-center bg-gray-950/30 p-4"
            >
                <div x-on:click="closeLeadAssignModal()" class="absolute inset-0"></div>
                <div
                    x-show="leadAssignModalOpen"
                    x-transition:enter="transition ease-out duration-150"
                    x-transition:enter-start="opacity-0 translate-y-3 scale-95"
                    x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                    x-transition:leave="transition ease-in duration-100"
                    x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                    x-transition:leave-end="opacity-0 translate-y-2 scale-95"
                    class="relative flex max-h-[min(680px,calc(100vh-2rem))] w-full max-w-2xl flex-col overflow-hidden rounded-lg bg-white shadow-xl ring-1 ring-gray-900/10"
                    role="dialog"
                    aria-modal="true"
                    aria-labelledby="assign-campaign-title"
                >
                    <div class="border-b border-gray-200 px-6 py-5">
                        <h2 id="assign-campaign-title" class="text-base font-semibold text-gray-900">Assign Campaign</h2>
                        <p class="mt-1 text-sm leading-6 text-gray-500" x-text="`Choose a campaign for ${selectedLeadIds.length} selected lead${selectedLeadIds.length === 1 ? '' : 's'}.`"></p>
                    </div>

                    <div class="min-h-0 flex-1 overflow-y-auto px-6 py-4">
                        <div class="space-y-2">
                            <template x-for="campaign in campaignAssignmentOptions()" :key="campaign.name">
                                <button
                                    type="button"
                                    x-on:click="leadAssignCampaignName = campaign.name"
                                    class="flex w-full items-start gap-3 rounded-lg border p-4 text-left transition focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
                                    :class="leadAssignCampaignName === campaign.name ? 'border-indigo-600 bg-indigo-50/50' : 'border-gray-200 bg-white hover:bg-gray-50'"
                                >
                                    <span class="mt-0.5 grid size-4 shrink-0 grid-cols-1">
                                        <span class="col-start-1 row-start-1 rounded-full border" :class="leadAssignCampaignName === campaign.name ? 'border-indigo-600 bg-indigo-600' : 'border-gray-300 bg-white'"></span>
                                        <span x-show="leadAssignCampaignName === campaign.name" class="col-start-1 row-start-1 size-1.5 self-center justify-self-center rounded-full bg-white"></span>
                                    </span>
                                    <span class="min-w-0 flex-1">
                                        <span class="block truncate text-sm font-semibold text-gray-900" x-text="campaign.name"></span>
                                        <span class="mt-1 flex flex-wrap items-center gap-2 text-xs leading-5 text-gray-500">
                                            <span class="inline-flex rounded-md px-2 py-1 font-medium ring-1 ring-inset" :class="campaign.status === 'Running' ? 'bg-green-50 text-green-700 ring-green-600/20' : 'bg-gray-50 text-gray-600 ring-gray-500/10'" x-text="campaign.status"></span>
                                            <span x-show="campaign.change" class="inline-flex rounded-md bg-amber-50 px-2 py-1 font-medium text-amber-700 ring-1 ring-inset ring-amber-600/20" x-text="campaign.change"></span>
                                            <span x-text="campaign.modified"></span>
                                        </span>
                                    </span>
                                    <span x-show="leadAssignCampaignName === campaign.name" class="outcraft-icon !text-[20px] text-indigo-600">check</span>
                                </button>
                            </template>
                        </div>
                    </div>

                    <div class="flex items-center justify-end gap-3 border-t border-gray-200 bg-gray-50 px-6 py-4">
                        <button type="button" x-on:click="closeLeadAssignModal()" class="inline-flex h-10 items-center justify-center rounded-md bg-white px-4 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 transition hover:bg-gray-50">Cancel</button>
                        <button type="button" x-on:click="assignSelectedLeadsToCampaign()" :disabled="! leadAssignCampaignName" class="inline-flex h-10 items-center justify-center rounded-md bg-indigo-600 px-4 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-500 disabled:cursor-not-allowed disabled:opacity-40 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Assign And Dispatch</button>
                    </div>
                </div>
            </div>

            <div class="overflow-x-auto">
                <ul role="list" class="min-w-[1080px] divide-y divide-gray-100">
                    <li x-show="isLoading" x-transition.opacity class="h-[260px] bg-white px-8 py-12 text-center">
                        <div class="mx-auto flex size-[56px] items-center justify-center rounded-xl bg-white" x-html="tableLoaderSvg()"></div>
                    </li>
                    <template x-for="row in loadingRows()" :key="'lead-' + row.name + row.phone + row.email + row.age">
                        <li x-on:click="openLeadDetails(row)" class="flex cursor-pointer items-start justify-between gap-x-4 px-6 py-5 transition-colors" :class="isLeadSelected(row) ? 'hover:bg-gray-100' : 'hover:bg-gray-50'">
                            <div class="pt-1">
                                <label x-on:click.stop class="grid size-4 shrink-0 grid-cols-1">
                                    <input
                                        type="checkbox"
                                        :checked="isLeadSelected(row)"
                                        x-on:change="toggleLeadSelection(row)"
                                        :aria-label="`Select ${row.name || 'No Name'}`"
                                        class="col-start-1 row-start-1 appearance-none rounded border border-gray-300 bg-white checked:border-indigo-600 checked:bg-indigo-600 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
                                    >
                                    <svg x-show="isLeadSelected(row)" viewBox="0 0 14 14" fill="none" class="pointer-events-none col-start-1 row-start-1 size-3 self-center justify-self-center stroke-white">
                                        <path d="M3 8L6 11L11 3.5" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </label>
                            </div>
                            <div class="min-w-0 flex-[1_1_34%]">
                                <div class="flex min-w-0 items-center">
                                    <p class="truncate text-sm/6 font-medium" :class="row.name ? 'text-gray-900' : 'text-gray-400'" x-text="row.name || 'No Name'"></p>
                                </div>
                                <div class="mt-1 min-h-[52px] space-y-1 text-xs/6 text-gray-500">
                                    <button type="button" x-show="row.email" x-on:click.stop="copyContact(row.email)" class="group relative flex min-w-0 max-w-[320px] text-left transition hover:text-gray-900">
                                        <span class="truncate" x-text="row.email"></span>
                                        <span class="pointer-events-none absolute bottom-full left-1/2 z-50 mb-2 -translate-x-1/2 translate-y-1 whitespace-nowrap rounded-lg bg-gray-900 px-3 py-2 text-xs font-medium text-white opacity-0 shadow-sm transition group-hover:translate-y-0 group-hover:opacity-100">
                                            <span x-text="row.email"></span>
                                            <span class="ml-2 text-white/70">Click to Copy</span>
                                            <span class="absolute left-1/2 top-full size-2 -translate-x-1/2 -translate-y-1 rotate-45 bg-gray-900"></span>
                                        </span>
                                    </button>
                                    <button type="button" x-show="row.phone" x-on:click.stop="copyContact(row.phone)" class="group relative flex min-w-0 text-left transition hover:text-gray-900">
                                        <span class="truncate" x-text="row.phone"></span>
                                        <span class="pointer-events-none absolute bottom-full left-1/2 z-50 mb-2 -translate-x-1/2 translate-y-1 whitespace-nowrap rounded-lg bg-gray-900 px-3 py-2 text-xs font-medium text-white opacity-0 shadow-sm transition group-hover:translate-y-0 group-hover:opacity-100">
                                            <span x-text="row.phone"></span>
                                            <span class="ml-2 text-white/70">Click to Copy</span>
                                            <span class="absolute left-1/2 top-full size-2 -translate-x-1/2 -translate-y-1 rotate-45 bg-gray-900"></span>
                                        </span>
                                    </button>
                                </div>
                            </div>

                            <div class="w-[150px] shrink-0 pt-0.5">
                                <span class="outcraft-label inline-flex max-w-full items-center rounded-full px-2 py-1 text-xs font-medium ring-1 ring-inset" :class="leadStateClass(row.state)">
                                    <span class="truncate" x-text="row.state"></span>
                                </span>
                            </div>

                            <div class="hidden min-w-[230px] sm:block">
                                <div class="flex items-center gap-x-2 text-sm/6 font-medium text-gray-900">
                                    <span class="inline-flex size-4 shrink-0 overflow-hidden rounded-full ring-1 ring-gray-200">
                                        <img :src="countryFlagUrl(row.countryFlagCode || row.country)" :alt="`${row.country || 'US'} flag`" class="size-full object-cover" loading="lazy">
                                    </span>
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
                    <h1 class="text-xl font-bold leading-tight tracking-normal">Campaign Runs</h1>
                    <p class="mt-1 max-w-[220px] text-sm leading-6 text-gray-500">Browse and manage campaign runs for the selected campaign</p>
                </div>

                <div class="relative" x-on:click.outside="searchOpen = false">
                    <div class="rounded-lg bg-white shadow-sm ring-1 ring-gray-900/5">
                        <div class="flex min-h-10 items-center px-4">
                            <input
                                x-model="query"
                                x-on:focus="searchOpen = true"
                                x-on:keydown.escape="searchOpen = false"
                                x-on:keydown.enter.prevent="addFirstSuggestion()"
                                class="w-full border-0 bg-transparent text-sm outline-none ring-0 placeholder:text-gray-400 focus:ring-0"
                                placeholder="Filter anything"
                            >
                        </div>
                        <div x-show="filters.length > 0" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-3" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-2" class="flex min-h-10 items-center gap-2 border-t border-gray-200 px-4">
                            <template x-for="tag in filters" :key="tag">
                                <button x-on:click="removeFilter(tag)" class="inline-flex items-center gap-1 rounded-lg border border-gray-200 bg-gray-50 px-2 py-1 text-sm leading-none text-gray-600">
                                    <span x-text="tag"></span>
                                    <span class="text-gray-500">×</span>
                                </button>
                            </template>
                            <div class="ml-auto flex items-center gap-4">
                                <button class="text-sm font-semibold text-gray-500 hover:text-gray-900" x-on:click="clearSearchTags()">Clear</button>
                                <button class="text-sm font-semibold text-gray-600 hover:text-gray-900" x-on:click="savePreset()">Save Preset</button>
                            </div>
                        </div>
                    </div>

                    <div x-cloak x-show="searchOpen" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-3" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-2" class="absolute left-0 right-0 top-0 z-30 rounded-md bg-white p-5 shadow-lg ring-1 ring-gray-900/5">
                        <input x-model="query" x-ref="campaignsOverlayInput" x-init="$watch('searchOpen', value => value && activeTab === 'Campaigns' && $nextTick(() => $refs.campaignsOverlayInput.focus()))" class="w-full border-0 bg-transparent text-base outline-none ring-0 focus:ring-0" placeholder="Filter anything">
                        <div class="filter-scroll mt-4 max-h-[215px] space-y-1 overflow-y-auto pr-2">
                            <template x-for="group in groupedSuggestions()" :key="group.column">
                                <div>
                                    <div class="px-1 py-2 text-sm font-semibold" x-text="group.column"></div>
                                    <template x-for="value in group.values" :key="group.column + value">
                                        <button x-on:click="addFilter(value)" class="block w-full rounded-lg px-1 py-2 text-left text-sm hover:bg-gray-50" x-text="value"></button>
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
                        <button type="button" x-on:click="clearFilters()" class="block w-full rounded-lg px-3 py-2 text-left font-semibold hover:bg-gray-50">Clear Filters</button>
                        <template x-for="preset in presets" :key="preset.name">
                            <div class="group flex items-center rounded-lg hover:bg-gray-50">
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
                <table class="w-full min-w-[1220px] table-fixed border-collapse text-sm">
                    <thead>
                        <tr class="border-y border-gray-200 bg-gray-50 text-left text-sm font-semibold text-gray-950">
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
                                <td class="px-6 py-4 align-top" x-text="row.campaignName"></td>
                                <td class="px-4 py-4 align-top">
                                    <span class="group relative inline-flex max-w-full">
                                        <span class="truncate" :class="row.name ? 'text-gray-900' : 'text-gray-400'" x-text="row.name || 'No Name'"></span>
                                        <span class="pointer-events-none absolute bottom-full left-1/2 z-50 mb-2 -translate-x-1/2 translate-y-1 whitespace-nowrap rounded-lg bg-gray-900 px-3 py-2 text-xs font-medium text-white opacity-0 shadow-sm transition group-hover:translate-y-0 group-hover:opacity-100">
                                            <span x-text="row.name || 'No Name'"></span>
                                            <span class="absolute left-1/2 top-full size-2 -translate-x-1/2 -translate-y-1 rotate-45 bg-gray-900"></span>
                                        </span>
                                    </span>
                                </td>
                                <td class="px-4 py-4 align-top" x-text="row.phone"></td>
                                <td class="px-4 py-4 align-top">
                                    <span x-show="! row.email" class="text-gray-300"></span>
                                    <span x-show="row.email" class="group relative inline-flex max-w-full">
                                        <span class="truncate" x-text="shortEmail(row.email)"></span>
                                        <span class="pointer-events-none absolute bottom-full left-1/2 z-50 mb-2 -translate-x-1/2 translate-y-1 whitespace-nowrap rounded-lg bg-gray-900 px-3 py-2 text-xs font-medium text-white opacity-0 shadow-sm transition group-hover:translate-y-0 group-hover:opacity-100">
                                            <span x-text="row.email"></span>
                                            <span class="absolute left-1/2 top-full size-2 -translate-x-1/2 -translate-y-1 rotate-45 bg-gray-900"></span>
                                        </span>
                                    </span>
                                </td>
                                <td class="px-4 py-4 align-top">
                                    <span class="outcraft-label inline-flex max-w-[104px] rounded-full px-2 py-1 text-xs font-medium ring-1 ring-inset" :class="campaignBadgeClass(row.campaignStatus)">
                                        <span class="truncate" x-text="row.campaignStatus"></span>
                                    </span>
                                </td>
                                <td class="px-4 py-4 align-top">
                                    <span class="outcraft-label inline-flex max-w-[116px] rounded-full px-2 py-1 text-xs font-medium ring-1 ring-inset" :class="campaignBadgeClass(row.firstInteraction)">
                                        <span class="truncate" x-text="row.firstInteraction"></span>
                                    </span>
                                </td>
                                <td class="px-4 py-4 align-top">
                                    <span class="outcraft-label inline-flex max-w-[110px] rounded-full px-2 py-1 text-xs font-medium ring-1 ring-inset" :class="campaignBadgeClass(row.followUp)">
                                        <span class="truncate" x-text="row.followUp"></span>
                                    </span>
                                </td>
                                <td class="px-4 py-4 align-top">
                                    <span class="group relative inline-flex">
                                        <span>Created </span><span x-text="campaignAge(row)"></span>
                                        <span class="pointer-events-none absolute bottom-full left-1/2 z-50 mb-2 -translate-x-1/2 translate-y-1 whitespace-nowrap rounded-lg bg-gray-900 px-3 py-2 text-xs font-medium text-white opacity-0 shadow-sm transition group-hover:translate-y-0 group-hover:opacity-100">
                                            <span x-text="row.ageTooltip"></span>
                                            <span class="absolute left-1/2 top-full size-2 -translate-x-1/2 -translate-y-1 rotate-45 bg-gray-900"></span>
                                        </span>
                                    </span>
                                </td>
                                <td class="px-4 py-4 align-top text-right font-semibold text-gray-600 transition hover:text-gray-950">Flow</td>
                                <td class="py-4 pr-6 pl-4 align-top text-right">
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
                    <h1 class="text-xl font-bold leading-tight tracking-normal">Campaign Runs</h1>
                    <p class="mt-1 max-w-[220px] text-sm leading-6 text-gray-500">Multi-line campaign run view for reviewing leads faster.</p>
                </div>

                <div class="relative" x-on:click.outside="searchOpen = false">
                    <div class="rounded-md bg-white shadow-sm ring-1 ring-inset ring-gray-300 transition focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-600">
                        <div class="flex h-10 items-center px-3">
                            <input
                                x-model="query"
                                x-on:focus="searchOpen = true"
                                x-on:keydown.escape="searchOpen = false"
                                x-on:keydown.enter.prevent="addFirstSuggestion()"
                                class="block w-full border-0 bg-transparent p-0 text-sm/6 text-gray-900 outline-none placeholder:text-gray-400 focus:ring-0"
                                placeholder="Filter anything"
                            >
                        </div>
                        <div x-show="filters.length > 0" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-2" class="flex min-h-10 flex-wrap items-center gap-2 border-t border-gray-200 px-3 py-2">
                            <template x-for="tag in filters" :key="tag">
                                <button type="button" x-on:click="removeFilter(tag)" class="inline-flex items-center gap-1 rounded-full bg-gray-50 px-2.5 py-1 text-xs font-medium text-gray-600 ring-1 ring-inset ring-gray-500/10 transition hover:bg-gray-100 hover:text-gray-900">
                                    <span x-text="tag"></span>
                                    <span class="outcraft-icon !text-[14px] text-gray-400">close</span>
                                </button>
                            </template>
                            <div class="ml-auto flex items-center gap-4">
                                <button type="button" class="text-sm font-semibold text-gray-500 transition hover:text-gray-900" x-on:click="clearSearchTags()">Clear</button>
                                <button type="button" class="text-sm font-semibold text-gray-600 transition hover:text-gray-900" x-on:click="savePreset()">Save Preset</button>
                            </div>
                        </div>
                    </div>

                    <div x-cloak x-show="searchOpen" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="opacity-0 translate-y-1" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-1" class="absolute left-0 right-0 top-12 z-30 overflow-hidden rounded-md bg-white shadow-lg ring-1 ring-gray-900/10">
                        <div class="p-2">
                            <input x-model="query" x-ref="leadCampaignsOverlayInput" x-init="$watch('searchOpen', value => value && activeTab === 'Lead Campaigns' && $nextTick(() => $refs.leadCampaignsOverlayInput.focus()))" class="block h-10 w-full rounded-md border-0 bg-white px-3 text-sm/6 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 outline-none placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600" placeholder="Filter anything">
                        </div>
                        <div class="filter-scroll max-h-[240px] overflow-y-auto px-2 pb-2">
                            <template x-for="group in groupedSuggestions()" :key="group.column">
                                <div class="py-1">
                                    <div class="px-3 py-2 text-xs font-semibold uppercase tracking-wide text-gray-400" x-text="group.column"></div>
                                    <template x-for="value in group.values" :key="group.column + value">
                                        <button type="button" x-on:click="addFilter(value)" class="flex w-full items-center rounded-md px-3 py-2 text-left text-sm text-gray-700 transition hover:bg-gray-50 hover:text-gray-900">
                                            <span class="truncate" x-text="value"></span>
                                        </button>
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
                    <div x-cloak x-show="presetOpen" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="opacity-0 translate-y-1" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-1" class="absolute right-0 top-12 z-40 w-[230px] overflow-hidden rounded-md bg-white p-1 text-sm text-gray-900 shadow-lg ring-1 ring-gray-900/10">
                        <button type="button" x-on:click="clearFilters()" class="block w-full rounded-md px-3 py-2 text-left font-semibold transition hover:bg-gray-50">Clear Filters</button>
                        <template x-for="preset in presets" :key="preset.name">
                            <div class="group flex items-center rounded-md transition hover:bg-gray-50">
                                <button type="button" x-on:click="applyPreset(preset)" class="flex min-w-0 flex-1 items-center justify-between px-3 py-2 text-left">
                                    <span class="truncate" x-text="preset.name"></span>
                                    <span x-show="selectedPresetName === preset.name" class="outcraft-icon ml-3 shrink-0 text-blue-500">check</span>
                                </button>
                                <button type="button" x-on:click.stop="deletePreset(preset)" class="mr-2 flex size-8 shrink-0 items-center justify-center rounded-md text-gray-400 opacity-0 transition hover:bg-red-50 hover:text-red-600 group-hover:opacity-100" :aria-label="`Delete ${preset.name}`">
                                    <span class="outcraft-icon !text-[18px]">delete</span>
                                </button>
                            </div>
                        </template>
                    </div>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="relative w-full min-w-[1040px] table-fixed border-collapse text-sm">
                    <colgroup>
                        <col class="w-1/3">
                        <col>
                        <col>
                        <col>
                        <col>
                    </colgroup>
                    <tbody>
                        <tr x-show="isLoading" x-transition.opacity>
                            <td colspan="5" class="h-[260px] bg-white px-8 py-12 text-center">
                                <div class="mx-auto flex size-[56px] items-center justify-center rounded-xl bg-white" x-html="tableLoaderSvg()"></div>
                            </td>
                        </tr>
                        <template x-for="(row, rowIndex) in loadingRows()" :key="'lead-campaign-multiline-' + row.campaignName + row.name + row.phone + row.email + row.age">
                            <tr x-on:click="openLeadDetails(row)" class="cursor-pointer transition-colors hover:bg-gray-50" :class="rowIndex === loadingRows().length - 1 ? 'h-[96px]' : 'h-[96px] border-b border-gray-200'">
                                <td class="px-6 py-5 align-top">
                                    <div class="truncate text-sm/6 font-medium" :class="row.name ? 'text-gray-900' : 'text-gray-400'" x-text="row.name || 'No Name'"></div>
                                    <div class="mt-1 min-h-[52px] space-y-1 text-xs/6 text-gray-500">
                                        <button type="button" x-on:click.stop="copyContact(row.email)" x-show="row.email" class="group relative flex min-w-0 max-w-[240px] cursor-pointer text-left transition hover:text-gray-900">
                                            <span class="truncate" x-text="row.email"></span>
                                            <span class="pointer-events-none absolute bottom-full left-1/2 z-50 mb-2 -translate-x-1/2 translate-y-1 whitespace-nowrap rounded-lg bg-gray-900 px-3 py-2 text-xs font-medium text-white opacity-0 shadow-sm transition group-hover:translate-y-0 group-hover:opacity-100">
                                                <span x-text="row.email"></span>
                                                <span class="ml-2 text-white/70">Click to Copy</span>
                                                <span class="absolute left-1/2 top-full size-2 -translate-x-1/2 -translate-y-1 rotate-45 bg-gray-900"></span>
                                            </span>
                                        </button>
                                        <button type="button" x-on:click.stop="copyContact(row.phone)" x-show="row.phone" class="group relative flex min-w-0 cursor-pointer text-left transition hover:text-gray-900">
                                            <span class="truncate" x-text="row.phone"></span>
                                            <span class="pointer-events-none absolute bottom-full left-1/2 z-50 mb-2 -translate-x-1/2 translate-y-1 whitespace-nowrap rounded-lg bg-gray-900 px-3 py-2 text-xs font-medium text-white opacity-0 shadow-sm transition group-hover:translate-y-0 group-hover:opacity-100">
                                                <span x-text="row.phone"></span>
                                                <span class="ml-2 text-white/70">Click to Copy</span>
                                                <span class="absolute left-1/2 top-full size-2 -translate-x-1/2 -translate-y-1 rotate-45 bg-gray-900"></span>
                                            </span>
                                        </button>
                                        <span x-show="! row.email && ! row.phone" class="text-gray-300">No Contact</span>
                                    </div>
                                </td>
                                <td class="px-4 py-5 align-top">
                                    <div class="truncate text-sm/6 font-medium text-gray-900" x-text="row.campaignName"></div>
                                    <div class="mt-1">
                                        <span class="inline-flex max-w-[140px] items-center rounded-full px-2 py-1 text-xs font-medium ring-1 ring-inset" :class="campaignPillClass(row.campaignStatus)">
                                            <span class="truncate" x-text="row.campaignStatus"></span>
                                        </span>
                                    </div>
                                </td>
                                <td class="px-4 py-5 align-top">
                                    <div class="text-sm/6 font-medium text-gray-900">First</div>
                                    <div class="mt-1">
                                        <span class="inline-flex w-fit max-w-full min-w-0 items-center rounded-full px-2 py-1 text-xs font-medium ring-1 ring-inset" :class="campaignPillClass(row.firstInteraction)">
                                            <span class="truncate" x-text="row.firstInteraction"></span>
                                        </span>
                                    </div>
                                </td>
                                <td class="px-4 py-5 align-top">
                                    <div class="text-sm/6 font-medium text-gray-900">Follow-Up</div>
                                    <div class="mt-1">
                                        <span class="inline-flex w-fit max-w-full min-w-0 items-center rounded-full px-2 py-1 text-xs font-medium ring-1 ring-inset" :class="campaignPillClass(row.followUp)">
                                            <span class="truncate" x-text="row.followUp || 'Pending'"></span>
                                        </span>
                                    </div>
                                </td>
                                <td class="px-4 py-5 align-top text-right">
                                    <span class="group relative inline-flex flex-col items-end">
                                        <span class="text-sm/6 font-medium text-gray-900">Created</span>
                                        <span class="text-xs/5 text-gray-500" x-text="campaignAge(row)"></span>
                                        <span class="pointer-events-none absolute bottom-full right-0 z-50 mb-2 translate-y-1 whitespace-nowrap rounded-lg bg-gray-900 px-3 py-2 text-xs font-medium text-white opacity-0 shadow-sm transition group-hover:translate-y-0 group-hover:opacity-100">
                                            <span x-text="row.ageTooltip"></span>
                                            <span class="absolute right-6 top-full size-2 -translate-y-1 rotate-45 bg-gray-900"></span>
                                        </span>
                                    </span>
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
                    <h1 class="text-xl font-bold leading-tight tracking-normal">Handoff Requests</h1>
                    <p class="mt-1 max-w-[230px] text-sm leading-6 text-gray-500">Leads that have requested a handoff from AI to a human support.</p>
                </div>

                <div class="relative" x-on:click.outside="searchOpen = false">
                    <div class="rounded-lg bg-white shadow-sm ring-1 ring-gray-900/5">
                        <div class="flex min-h-10 items-center px-4">
                            <input
                                x-model="query"
                                x-on:focus="searchOpen = true"
                                x-on:keydown.escape="searchOpen = false"
                                x-on:keydown.enter.prevent="addFirstSuggestion()"
                                class="w-full border-0 bg-transparent text-sm outline-none ring-0 placeholder:text-gray-400 focus:ring-0"
                                placeholder="Filter anything"
                            >
                        </div>
                        <div x-show="filters.length > 0" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-3" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-2" class="flex min-h-10 items-center gap-2 border-t border-gray-200 px-4">
                            <template x-for="tag in filters" :key="tag">
                                <button x-on:click="removeFilter(tag)" class="inline-flex items-center gap-1 rounded-lg border border-gray-200 bg-gray-50 px-2 py-1 text-sm leading-none text-gray-600">
                                    <span x-text="tag"></span>
                                    <span class="text-gray-500">×</span>
                                </button>
                            </template>
                            <div class="ml-auto flex items-center gap-4">
                                <button class="text-sm font-semibold text-gray-500 hover:text-gray-900" x-on:click="clearSearchTags()">Clear</button>
                                <button class="text-sm font-semibold text-gray-600 hover:text-gray-900" x-on:click="savePreset()">Save Preset</button>
                            </div>
                        </div>
                    </div>

                    <div x-cloak x-show="searchOpen" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-3" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-2" class="absolute left-0 right-0 top-0 z-30 rounded-md bg-white p-5 shadow-lg ring-1 ring-gray-900/5">
                        <input x-model="query" x-ref="handoffsOverlayInput" x-init="$watch('searchOpen', value => value && activeTab === 'Handoffs' && $nextTick(() => $refs.handoffsOverlayInput.focus()))" class="w-full border-0 bg-transparent text-base outline-none ring-0 focus:ring-0" placeholder="Filter anything">
                        <div class="filter-scroll mt-4 max-h-[215px] space-y-1 overflow-y-auto pr-2">
                            <template x-for="group in groupedSuggestions()" :key="group.column">
                                <div>
                                    <div class="px-1 py-2 text-sm font-semibold" x-text="group.column"></div>
                                    <template x-for="value in group.values" :key="group.column + value">
                                        <button x-on:click="addFilter(value)" class="block w-full rounded-lg px-1 py-2 text-left text-sm hover:bg-gray-50" x-text="value"></button>
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
                        <button type="button" x-on:click="clearFilters()" class="block w-full rounded-lg px-3 py-2 text-left font-semibold hover:bg-gray-50">Clear Filters</button>
                        <template x-for="preset in presets" :key="preset.name">
                            <div class="group flex items-center rounded-lg hover:bg-gray-50">
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
                <table class="w-full min-w-[860px] table-fixed border-collapse text-sm">
                    <colgroup>
                        <col class="w-1/3">
                        <col>
                        <col>
                        <col>
                    </colgroup>
                    <tbody>
                        <tr x-show="isLoading" x-transition.opacity>
                            <td colspan="4" class="h-[260px] bg-white px-8 py-12 text-center">
                                <div class="mx-auto flex size-[56px] items-center justify-center rounded-xl bg-white" x-html="tableLoaderSvg()"></div>
                            </td>
                        </tr>
                        <template x-for="(row, rowIndex) in loadingRows()" :key="'handoff-' + row.name + row.phone + row.email + row.age">
                            <tr x-on:click="openLeadDetails(row)" class="cursor-pointer transition-colors hover:bg-gray-50" :class="rowIndex === loadingRows().length - 1 ? 'h-[96px]' : 'h-[96px] border-b border-gray-200'">
                                <td class="px-6 py-5 align-top">
                                    <span class="group relative inline-flex max-w-full">
                                        <span class="truncate text-sm/6 font-medium" :class="row.name ? 'text-gray-900' : 'text-gray-400'" x-text="row.name || 'No Name'"></span>
                                        <span class="pointer-events-none absolute bottom-full left-1/2 z-50 mb-2 -translate-x-1/2 translate-y-1 whitespace-nowrap rounded-lg bg-gray-900 px-3 py-2 text-xs font-medium text-white opacity-0 shadow-sm transition group-hover:translate-y-0 group-hover:opacity-100">
                                            <span x-text="row.name || 'No Name'"></span>
                                            <span class="absolute left-1/2 top-full size-2 -translate-x-1/2 -translate-y-1 rotate-45 bg-gray-900"></span>
                                        </span>
                                    </span>
                                    <div class="mt-1 min-h-[52px] space-y-1 text-xs/6 text-gray-500">
                                        <button type="button" x-show="row.email" x-on:click.stop="copyContact(row.email)" class="group relative flex min-w-0 max-w-[260px] text-left transition hover:text-gray-900">
                                            <span class="truncate" x-text="row.email"></span>
                                            <span class="pointer-events-none absolute bottom-full left-1/2 z-50 mb-2 -translate-x-1/2 translate-y-1 whitespace-nowrap rounded-lg bg-gray-900 px-3 py-2 text-xs font-medium text-white opacity-0 shadow-sm transition group-hover:translate-y-0 group-hover:opacity-100">
                                                <span x-text="row.email"></span>
                                                <span class="ml-2 text-white/70">Click to Copy</span>
                                                <span class="absolute left-1/2 top-full size-2 -translate-x-1/2 -translate-y-1 rotate-45 bg-gray-900"></span>
                                            </span>
                                        </button>
                                        <button type="button" x-show="row.phone" x-on:click.stop="copyContact(row.phone)" class="group relative flex min-w-0 text-left transition hover:text-gray-900">
                                            <span class="truncate" x-text="row.phone"></span>
                                            <span class="pointer-events-none absolute bottom-full left-1/2 z-50 mb-2 -translate-x-1/2 translate-y-1 whitespace-nowrap rounded-lg bg-gray-900 px-3 py-2 text-xs font-medium text-white opacity-0 shadow-sm transition group-hover:translate-y-0 group-hover:opacity-100">
                                                <span x-text="row.phone"></span>
                                                <span class="ml-2 text-white/70">Click to Copy</span>
                                                <span class="absolute left-1/2 top-full size-2 -translate-x-1/2 -translate-y-1 rotate-45 bg-gray-900"></span>
                                            </span>
                                        </button>
                                        <span x-show="! row.email && ! row.phone" class="text-gray-300">No Contact</span>
                                    </div>
                                </td>
                                <td class="px-4 py-5 align-top">
                                    <div class="flex items-center gap-x-2 text-sm/6 font-medium text-gray-900">
                                        <span class="inline-flex size-4 shrink-0 overflow-hidden rounded-full ring-1 ring-gray-200">
                                            <img :src="countryFlagUrl(row.countryFlagCode || row.country)" :alt="`${row.country || 'US'} flag`" class="size-full object-cover" loading="lazy">
                                        </span>
                                        <span x-text="row.phoneCountry"></span>
                                    </div>
                                    <span class="group relative mt-1 block max-w-full text-xs/5 text-gray-500">
                                        <span class="block truncate" x-text="row.timezone"></span>
                                        <span class="pointer-events-none absolute bottom-full left-1/2 z-50 mb-2 -translate-x-1/2 translate-y-1 whitespace-nowrap rounded-lg bg-gray-900 px-3 py-2 text-xs font-medium text-white opacity-0 shadow-sm transition group-hover:translate-y-0 group-hover:opacity-100">
                                            <span x-text="row.timezone"></span>
                                            <span class="absolute left-1/2 top-full size-2 -translate-x-1/2 -translate-y-1 rotate-45 bg-gray-900"></span>
                                        </span>
                                    </span>
                                </td>
                                <td class="px-4 py-5 align-top text-right">
                                    <span class="group relative inline-flex flex-col items-end">
                                        <span class="text-sm/6 font-medium text-gray-900">Created</span>
                                        <span class="text-xs/5 text-gray-500" x-text="leadAge(row)"></span>
                                        <span class="pointer-events-none absolute bottom-full right-0 z-50 mb-2 translate-y-1 whitespace-nowrap rounded-lg bg-gray-900 px-3 py-2 text-xs font-medium text-white opacity-0 shadow-sm transition group-hover:translate-y-0 group-hover:opacity-100">
                                            <span x-text="row.ageTooltip"></span>
                                            <span class="absolute right-6 top-full size-2 -translate-y-1 rotate-45 bg-gray-900"></span>
                                        </span>
                                    </span>
                                </td>
                                <td class="py-5 pr-6 pl-4 align-top text-right">
                                    <button type="button" x-on:click.stop class="inline-flex h-9 items-center justify-center rounded-md bg-indigo-50 px-3 text-sm font-semibold text-indigo-700 shadow-sm ring-1 ring-inset ring-indigo-200 transition hover:bg-indigo-100 hover:text-indigo-800">Resolve</button>
                                </td>
                            </tr>
                        </template>
                        <tr x-show="! isLoading && filteredRows().length === 0">
                            <td colspan="4" class="px-8 py-16 text-center text-gray-500">No handoff requests match these filters.</td>
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
                <h1 class="pt-1 text-xl font-bold leading-tight tracking-normal">Interactions</h1>

                <div class="relative" x-on:click.outside="searchOpen = false">
                    <div class="rounded-lg bg-white shadow-sm ring-1 ring-gray-900/5">
                        <div class="flex min-h-10 items-center px-4">
                            <input
                                x-model="query"
                                x-on:focus="searchOpen = true"
                                x-on:keydown.escape="searchOpen = false"
                                x-on:keydown.enter.prevent="addFirstSuggestion()"
                                class="w-full border-0 bg-transparent text-sm outline-none ring-0 placeholder:text-gray-400 focus:ring-0"
                                placeholder="Filter anything"
                            >
                        </div>
                        <div x-show="filters.length > 0" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-3" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-2" class="flex min-h-10 items-center gap-2 border-t border-gray-200 px-4">
                            <template x-for="tag in filters" :key="tag">
                                <button x-on:click="removeFilter(tag)" class="inline-flex items-center gap-1 rounded-lg border border-gray-200 bg-gray-50 px-2 py-1 text-sm leading-none text-gray-600">
                                    <span x-text="tag"></span>
                                    <span class="text-gray-500">×</span>
                                </button>
                            </template>
                            <div class="ml-auto flex items-center gap-4">
                                <button class="text-sm font-semibold text-gray-500 hover:text-gray-900" x-on:click="clearSearchTags()">Clear</button>
                                <button class="text-sm font-semibold text-gray-600 hover:text-gray-900" x-on:click="savePreset()">Save Preset</button>
                            </div>
                        </div>
                    </div>

                    <div x-cloak x-show="searchOpen" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-3" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-2" class="absolute left-0 right-0 top-0 z-30 rounded-md bg-white p-5 shadow-lg ring-1 ring-gray-900/5">
                        <input x-model="query" x-ref="overlayInput" x-init="$watch('searchOpen', value => value && activeTab === 'Outreach' && $nextTick(() => $refs.overlayInput.focus()))" class="w-full border-0 bg-transparent text-base outline-none ring-0 focus:ring-0" placeholder="Filter anything">
                        <div class="filter-scroll mt-4 max-h-[215px] space-y-1 overflow-y-auto pr-2">
                            <template x-for="group in groupedSuggestions()" :key="group.column">
                                <div>
                                    <div class="px-1 py-2 text-sm font-semibold" x-text="group.column"></div>
                                    <template x-for="value in group.values" :key="group.column + value">
                                        <button x-on:click="addFilter(value)" class="block w-full rounded-lg px-1 py-2 text-left text-sm hover:bg-gray-50" x-text="value"></button>
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
                            class="block w-full rounded-lg px-3 py-2 text-left font-semibold hover:bg-gray-50"
                        >
                            Clear Filters
                        </button>
                        <template x-for="preset in presets" :key="preset.name">
                            <div class="group flex items-center rounded-lg hover:bg-gray-50">
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
                <table class="w-full min-w-[1180px] table-fixed border-collapse text-sm">
                    <thead>
                        <tr class="border-y border-gray-200 bg-gray-50 text-left text-sm font-semibold text-gray-950">
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
                                <td class="px-6 py-4 align-top">
                                    <span class="group relative inline-flex max-w-full">
                                        <span class="truncate" :class="row.name ? 'text-gray-900' : 'text-gray-400'" x-text="row.name || 'No Name'"></span>
                                        <span class="pointer-events-none absolute bottom-full left-1/2 z-50 mb-2 -translate-x-1/2 translate-y-1 whitespace-nowrap rounded-lg bg-gray-900 px-3 py-2 text-xs font-medium text-white opacity-0 shadow-sm transition group-hover:translate-y-0 group-hover:opacity-100">
                                            <span x-text="row.name || 'No Name'"></span>
                                            <span class="absolute left-1/2 top-full size-2 -translate-x-1/2 -translate-y-1 rotate-45 bg-gray-900"></span>
                                        </span>
                                    </span>
                                </td>
                                <td class="px-4 py-4 align-top">
                                    <span x-show="! row.phone" class="text-gray-300"></span>
                                    <span x-show="row.phone" class="group relative inline-flex">
                                        <span x-text="row.phone"></span>
                                        <span class="pointer-events-none absolute bottom-full left-1/2 z-50 mb-2 -translate-x-1/2 translate-y-1 whitespace-nowrap rounded-lg bg-gray-900 px-3 py-2 text-xs font-medium text-white opacity-0 shadow-sm transition group-hover:translate-y-0 group-hover:opacity-100">
                                            <span class="mr-1 inline-flex size-4 shrink-0 overflow-hidden rounded-full ring-1 ring-white/20">
                                                <img :src="countryFlagUrl(row.phoneFlagCode || row.country)" :alt="`${row.phoneCountry || 'Country'} flag`" class="size-full object-cover" loading="lazy">
                                            </span>
                                            <span x-text="row.phoneCountry"></span>
                                            <span class="absolute left-1/2 top-full size-2 -translate-x-1/2 -translate-y-1 rotate-45 bg-gray-900"></span>
                                        </span>
                                    </span>
                                </td>
                                <td class="px-4 py-4 align-top">
                                    <span x-show="! row.email" class="text-gray-300"></span>
                                    <span x-show="row.email" class="group relative inline-flex max-w-full">
                                        <span class="truncate" x-text="shortEmail(row.email)"></span>
                                        <span class="pointer-events-none absolute bottom-full left-1/2 z-50 mb-2 -translate-x-1/2 translate-y-1 whitespace-nowrap rounded-lg bg-gray-900 px-3 py-2 text-xs font-medium text-white opacity-0 shadow-sm transition group-hover:translate-y-0 group-hover:opacity-100">
                                            <span x-text="row.email"></span>
                                            <span class="absolute left-1/2 top-full size-2 -translate-x-1/2 -translate-y-1 rotate-45 bg-gray-900"></span>
                                        </span>
                                    </span>
                                </td>
                                <td class="px-4 py-4 align-top" x-text="row.channel"></td>
                                <td class="px-4 py-4 align-top">
                                    <button type="button" x-show="row.content === 'View'" x-on:click="openLeadDetails(row)" class="group relative inline-flex text-left">
                                        <span class="outcraft-label inline-flex max-w-[76px] cursor-pointer rounded-full bg-gray-50 px-2 py-1 text-xs font-medium text-gray-600 ring-1 ring-inset ring-gray-500/10 transition group-hover:text-gray-950">
                                            <span class="truncate">View</span>
                                        </span>
                                        <span class="pointer-events-none absolute bottom-full left-1/2 z-50 mb-2 w-[320px] -translate-x-1/2 translate-y-1 rounded-lg bg-gray-900 px-4 py-3 text-left text-xs font-medium leading-5 text-white opacity-0 shadow-sm transition group-hover:translate-y-0 group-hover:opacity-100">
                                            <span x-text="row.contentPreview"></span>
                                            <span class="absolute left-1/2 top-full size-2 -translate-x-1/2 -translate-y-1 rotate-45 bg-gray-900"></span>
                                        </span>
                                    </button>
                                    <span x-show="row.content && row.content !== 'View'" class="group relative inline-flex">
                                        <span class="outcraft-label inline-flex max-w-[76px] cursor-pointer items-center gap-1 rounded-full bg-gray-50 px-2 py-1 text-xs font-medium text-gray-600 ring-1 ring-inset ring-gray-500/10 transition group-hover:text-gray-950">
                                            <span class="outcraft-icon !text-[18px] !leading-[18px] ">play_circle</span>
                                            <span class="truncate leading-[18px]" x-text="row.content"></span>
                                        </span>
                                        <span class="pointer-events-none absolute bottom-full left-1/2 z-50 mb-2 -translate-x-1/2 translate-y-1 whitespace-nowrap rounded-lg bg-gray-900 px-3 py-2 text-xs font-medium text-white opacity-0 shadow-sm transition group-hover:translate-y-0 group-hover:opacity-100">
                                            Listen
                                            <span class="absolute left-1/2 top-full size-2 -translate-x-1/2 -translate-y-1 rotate-45 bg-gray-900"></span>
                                        </span>
                                    </span>
                                </td>
                                <td class="px-4 py-4 align-top">
                                    <span class="group relative inline-flex">
                                        <span class="outcraft-label inline-flex max-w-[112px] rounded-full bg-gray-50 px-2 py-1 text-xs font-medium text-gray-600 ring-1 ring-inset ring-gray-500/10">
                                            <span class="truncate" x-text="row.direction"></span>
                                        </span>
                                        <span class="pointer-events-none absolute bottom-full left-1/2 z-50 mb-2 -translate-x-1/2 translate-y-1 whitespace-nowrap rounded-lg bg-gray-900 px-3 py-2 text-xs font-medium text-white opacity-0 shadow-sm transition group-hover:translate-y-0 group-hover:opacity-100">
                                            <span x-text="row.direction"></span>
                                            <span class="absolute left-1/2 top-full size-2 -translate-x-1/2 -translate-y-1 rotate-45 bg-gray-900"></span>
                                        </span>
                                    </span>
                                </td>
                                <td class="px-4 py-4 align-top">
                                    <span class="group relative inline-flex">
                                        <span class="outcraft-label inline-flex max-w-[138px] rounded-full px-2 py-1 text-xs font-medium ring-1 ring-inset" :class="pillClass(row.outcome)">
                                            <span class="truncate" x-text="row.outcome"></span>
                                        </span>
                                        <span class="pointer-events-none absolute bottom-full left-1/2 z-50 mb-2 -translate-x-1/2 translate-y-1 whitespace-nowrap rounded-lg bg-gray-900 px-3 py-2 text-xs font-medium text-white opacity-0 shadow-sm transition group-hover:translate-y-0 group-hover:opacity-100">
                                            <span x-text="row.outcome"></span>
                                            <span class="absolute left-1/2 top-full size-2 -translate-x-1/2 -translate-y-1 rotate-45 bg-gray-900"></span>
                                        </span>
                                    </span>
                                </td>
                                <td class="px-4 py-4 align-top">
                                    <span class="group relative inline-flex">
                                        <span class="outcraft-label inline-flex max-w-[98px] rounded-full px-2 py-1 text-xs font-medium ring-1 ring-inset" :class="pillClass(row.result)">
                                            <span class="truncate" x-text="row.result"></span>
                                        </span>
                                        <span class="pointer-events-none absolute bottom-full left-1/2 z-50 mb-2 -translate-x-1/2 translate-y-1 whitespace-nowrap rounded-lg bg-gray-900 px-3 py-2 text-xs font-medium text-white opacity-0 shadow-sm transition group-hover:translate-y-0 group-hover:opacity-100">
                                            <span x-text="row.result"></span>
                                            <span class="absolute left-1/2 top-full size-2 -translate-x-1/2 -translate-y-1 rotate-45 bg-gray-900"></span>
                                        </span>
                                    </span>
                                </td>
                                <td class="px-4 py-4 align-top">
                                    <span class="group relative inline-flex">
                                        <span>Created </span><span x-text="leadAge(row)"></span>
                                        <span class="pointer-events-none absolute bottom-full left-1/2 z-50 mb-2 -translate-x-1/2 translate-y-1 whitespace-nowrap rounded-lg bg-gray-900 px-3 py-2 text-xs font-medium text-white opacity-0 shadow-sm transition group-hover:translate-y-0 group-hover:opacity-100">
                                            <span x-text="row.ageTooltip"></span>
                                            <span class="absolute left-1/2 top-full size-2 -translate-x-1/2 -translate-y-1 rotate-45 bg-gray-900"></span>
                                        </span>
                                    </span>
                                </td>
                                <td class="py-4 pr-6 pl-4 align-top text-right">
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
                <h1 class="pt-1 text-xl font-bold leading-tight tracking-normal">Interaction</h1>

                <div class="relative" x-on:click.outside="searchOpen = false">
                    <div class="rounded-lg bg-white shadow-sm ring-1 ring-gray-900/5">
                        <div class="flex min-h-10 items-center px-4">
                            <input
                                x-model="query"
                                x-on:focus="searchOpen = true"
                                x-on:keydown.escape="searchOpen = false"
                                x-on:keydown.enter.prevent="addFirstSuggestion()"
                                class="w-full border-0 bg-transparent text-sm outline-none ring-0 placeholder:text-gray-400 focus:ring-0"
                                placeholder="Filter anything"
                            >
                        </div>
                        <div x-show="filters.length > 0" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-3" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-2" class="flex min-h-10 items-center gap-2 border-t border-gray-200 px-4">
                            <template x-for="tag in filters" :key="tag">
                                <button x-on:click="removeFilter(tag)" class="inline-flex items-center gap-1 rounded-lg border border-gray-200 bg-gray-50 px-2 py-1 text-sm leading-none text-gray-600">
                                    <span x-text="tag"></span>
                                    <span class="text-gray-500">×</span>
                                </button>
                            </template>
                            <div class="ml-auto flex items-center gap-4">
                                <button class="text-sm font-semibold text-gray-500 hover:text-gray-900" x-on:click="clearSearchTags()">Clear</button>
                                <button class="text-sm font-semibold text-gray-600 hover:text-gray-900" x-on:click="savePreset()">Save Preset</button>
                            </div>
                        </div>
                    </div>

                    <div x-cloak x-show="searchOpen" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-3" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-2" class="absolute left-0 right-0 top-0 z-30 rounded-md bg-white p-5 shadow-lg ring-1 ring-gray-900/5">
                        <input x-model="query" x-ref="outreachReviewOverlayInput" x-init="$watch('searchOpen', value => value && activeTab === 'Outreach Review' && $nextTick(() => $refs.outreachReviewOverlayInput.focus()))" class="w-full border-0 bg-transparent text-base outline-none ring-0 focus:ring-0" placeholder="Filter anything">
                        <div class="filter-scroll mt-4 max-h-[215px] space-y-1 overflow-y-auto pr-2">
                            <template x-for="group in groupedSuggestions()" :key="group.column">
                                <div>
                                    <div class="px-1 py-2 text-sm font-semibold" x-text="group.column"></div>
                                    <template x-for="value in group.values" :key="group.column + value">
                                        <button x-on:click="addFilter(value)" class="block w-full rounded-lg px-1 py-2 text-left text-sm hover:bg-gray-50" x-text="value"></button>
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
                        <button type="button" x-on:click="clearFilters()" class="block w-full rounded-lg px-3 py-2 text-left font-semibold hover:bg-gray-50">Clear Filters</button>
                        <template x-for="preset in presets" :key="preset.name">
                            <div class="group flex items-center rounded-lg hover:bg-gray-50">
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
                <table class="relative w-full min-w-[1040px] table-fixed border-collapse text-sm">
                    <colgroup>
                        <col class="w-1/3">
                        <col>
                        <col>
                        <col>
                        <col>
                    </colgroup>
                    <tbody>
                        <tr x-show="isLoading" x-transition.opacity>
                            <td colspan="5" class="h-[260px] bg-white px-8 py-12 text-center">
                                <div class="mx-auto flex size-[56px] items-center justify-center rounded-xl bg-white" x-html="tableLoaderSvg()"></div>
                            </td>
                        </tr>
                        <template x-for="(row, rowIndex) in loadingRows()" :key="'outreach-review-' + row.name + row.email + row.age + row.result">
                            <tr x-on:click="openLeadDetails(row)" class="cursor-pointer transition-colors hover:bg-gray-50" :class="rowIndex === loadingRows().length - 1 ? 'h-[96px]' : 'h-[96px] border-b border-gray-200'">
                                <td class="px-6 py-5 align-top">
                                    <div class="truncate text-sm/6 font-medium" :class="row.name ? 'text-gray-900' : 'text-gray-400'" x-text="row.name || 'No Name'"></div>
                                    <div class="mt-1 min-h-[52px] space-y-1 text-xs/6 text-gray-500">
                                        <button type="button" x-on:click.stop="copyContact(row.email)" x-show="row.email" class="group relative flex min-w-0 max-w-[260px] cursor-pointer text-left transition hover:text-gray-900">
                                            <span class="truncate" x-text="row.email"></span>
                                            <span class="pointer-events-none absolute bottom-full left-1/2 z-50 mb-2 -translate-x-1/2 translate-y-1 whitespace-nowrap rounded-lg bg-gray-900 px-3 py-2 text-xs font-medium text-white opacity-0 shadow-sm transition group-hover:translate-y-0 group-hover:opacity-100">
                                                <span x-text="row.email"></span>
                                                <span class="ml-2 text-white/70">Click to Copy</span>
                                                <span class="absolute left-1/2 top-full size-2 -translate-x-1/2 -translate-y-1 rotate-45 bg-gray-900"></span>
                                            </span>
                                        </button>
                                        <button type="button" x-on:click.stop="copyContact(row.phone)" x-show="row.phone" class="group relative flex min-w-0 cursor-pointer text-left transition hover:text-gray-900">
                                            <span class="truncate" x-text="row.phone"></span>
                                            <span class="pointer-events-none absolute bottom-full left-1/2 z-50 mb-2 -translate-x-1/2 translate-y-1 whitespace-nowrap rounded-lg bg-gray-900 px-3 py-2 text-xs font-medium text-white opacity-0 shadow-sm transition group-hover:translate-y-0 group-hover:opacity-100">
                                                <span x-text="row.phone"></span>
                                                <span class="ml-2 text-white/70">Click to Copy</span>
                                                <span class="absolute left-1/2 top-full size-2 -translate-x-1/2 -translate-y-1 rotate-45 bg-gray-900"></span>
                                            </span>
                                        </button>
                                        <span x-show="! row.email && ! row.phone" class="text-gray-300">No Contact</span>
                                    </div>
                                </td>
                                <td class="px-4 py-5 align-top">
                                    <div class="truncate text-sm/6 font-medium text-gray-900" x-text="row.channel"></div>
                                    <div class="mt-1 flex min-w-0 flex-wrap items-center gap-2">
                                        <span class="outcraft-label inline-flex max-w-[112px] rounded-full bg-gray-50 px-2 py-1 text-xs font-medium text-gray-600 ring-1 ring-inset ring-gray-500/10">
                                            <span class="truncate" x-text="row.direction"></span>
                                        </span>
                                        <button
                                            type="button"
                                            x-show="row.channel !== 'Call'"
                                            x-on:mouseenter="showFloatingTooltip($event, row.contentPreview, 320)"
                                            x-on:mouseleave="hideFloatingTooltip()"
                                            x-on:focus="showFloatingTooltip($event, row.contentPreview, 320)"
                                            x-on:blur="hideFloatingTooltip()"
                                            x-on:click.stop="openLeadDetails(row)"
                                            class="inline-flex text-left"
                                        >
                                            <span class="outcraft-label inline-flex max-w-[92px] cursor-pointer rounded-full bg-gray-50 px-2 py-1 text-xs font-medium text-gray-600 ring-1 ring-inset ring-gray-500/10 transition group-hover:text-gray-950">
                                                <span class="truncate">View</span>
                                            </span>
                                        </button>
                                        <span
                                            x-show="row.channel === 'Call'"
                                            x-on:mouseenter="showFloatingTooltip($event, 'Listen', 104)"
                                            x-on:mouseleave="hideFloatingTooltip()"
                                            x-on:click.stop
                                            class="inline-flex"
                                        >
                                            <span class="outcraft-label inline-flex max-w-[92px] cursor-pointer items-center gap-1 rounded-full bg-gray-50 px-2 py-1 text-xs font-medium text-gray-600 ring-1 ring-inset ring-gray-500/10 transition group-hover:text-gray-950">
                                                <span class="outcraft-icon !text-[18px] !leading-[18px] ">play_circle</span>
                                                <span class="truncate leading-[18px]" x-text="row.content || 'Play'"></span>
                                            </span>
                                        </span>
                                    </div>
                                </td>
                                <td class="px-4 py-5 align-top">
                                    <div class="text-sm/6 font-medium text-gray-900">Outcome</div>
                                    <div class="mt-1">
                                        <span class="outcraft-label inline-flex w-fit max-w-full min-w-0 rounded-full px-2 py-1 text-xs font-medium ring-1 ring-inset" :class="pillClass(row.outcome)">
                                            <span class="truncate" x-text="row.outcome"></span>
                                        </span>
                                    </div>
                                </td>
                                <td class="px-4 py-5 align-top">
                                    <div class="text-sm/6 font-medium text-gray-900">Result</div>
                                    <div class="mt-1">
                                        <span class="outcraft-label inline-flex w-fit max-w-full min-w-0 rounded-full px-2 py-1 text-xs font-medium ring-1 ring-inset" :class="pillClass(row.result)">
                                            <span class="truncate" x-text="row.result"></span>
                                        </span>
                                    </div>
                                </td>
                                <td class="px-4 py-5 align-top text-right">
                                    <span class="group relative inline-flex flex-col items-end">
                                        <span class="text-sm/6 font-medium text-gray-900">Created</span>
                                        <span class="text-xs/5 text-gray-500" x-text="leadAge(row)"></span>
                                        <span class="pointer-events-none absolute bottom-full right-0 z-50 mb-2 translate-y-1 whitespace-nowrap rounded-lg bg-gray-900 px-3 py-2 text-xs font-medium text-white opacity-0 shadow-sm transition group-hover:translate-y-0 group-hover:opacity-100">
                                            <span x-text="row.ageTooltip"></span>
                                            <span class="absolute right-6 top-full size-2 -translate-y-1 rotate-45 bg-gray-900"></span>
                                        </span>
                                    </span>
                                </td>
                            </tr>
                        </template>
                        <tr x-show="! isLoading && filteredRows().length === 0">
                            <td colspan="5" class="px-8 py-16 text-center text-gray-500">No outreach records match these filters.</td>
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
            badge: 'id-card',
            block: 'ban',
            business: 'building-2',
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
            drag_indicator: 'grip-vertical',
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
            query_stats: 'chart-no-axes-column-increasing',
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
        let outcraftIconGradientId = 0;

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

            if (node.closest?.('.outcraft-ai-button')) {
                const namespace = 'http://www.w3.org/2000/svg';
                const gradientId = `outcraft-ai-icon-gradient-${++outcraftIconGradientId}`;
                const defs = document.createElementNS(namespace, 'defs');
                const gradient = document.createElementNS(namespace, 'linearGradient');
                const animate = document.createElementNS(namespace, 'animateTransform');
                const stops = [
                    ['0%', 'var(--oc-primary-600)'],
                    ['25%', 'var(--oc-accent-500, #ec4899)'],
                    ['50%', 'var(--oc-primary-600)'],
                    ['75%', 'var(--oc-accent-400, #f472b6)'],
                    ['100%', 'var(--oc-primary-600)'],
                ];

                gradient.setAttribute('id', gradientId);
                gradient.setAttribute('x1', '0%');
                gradient.setAttribute('y1', '0%');
                gradient.setAttribute('x2', '200%');
                gradient.setAttribute('y2', '0%');
                animate.setAttribute('attributeName', 'gradientTransform');
                animate.setAttribute('type', 'translate');
                animate.setAttribute('from', '1 0');
                animate.setAttribute('to', '0 0');
                animate.setAttribute('dur', '5.5s');
                animate.setAttribute('repeatCount', 'indefinite');

                stops.forEach(([offset, color]) => {
                    const stop = document.createElementNS(namespace, 'stop');
                    stop.setAttribute('offset', offset);
                    stop.setAttribute('stop-color', color);
                    gradient.appendChild(stop);
                });

                gradient.appendChild(animate);
                defs.appendChild(gradient);
                svg.prepend(defs);
                svg.setAttribute('stroke', `url(#${gradientId})`);
                svg.setAttribute('stroke-width', '2');
            }

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
                primaryThemePanelOpen: false,
                activeColorRole: 'primary',
                primaryTheme: 'indigo',
                primaryThemeValue: '600',
                accentTheme: 'pink',
                infoTheme: 'sky',
                successTheme: 'teal',
                warningTheme: 'amber',
                dangerTheme: 'red',
                neutralTheme: 'slate',
                surfaceTheme: 'gray',
                mutedTheme: 'zinc',
                primaryThemeShadeKeys: ['50', '100', '200', '300', '400', '500', '600', '700', '800', '900', '950'],
                primaryThemeValueOptions: ['50', '100', '200', '300', '400', '500', '600', '700', '800', '900', '950'],
                colorRoleOptions: [
                    { key: 'primary', label: 'Primary', description: 'Main actions, focus states, and selected UI.' },
                    { key: 'accent', label: 'Accent', description: 'Secondary highlights, AI moments, upgrades, and expressive details.' },
                    { key: 'info', label: 'Info', description: 'Informational badges, helper states, integrations, and neutral notices.' },
                    { key: 'success', label: 'Success', description: 'Positive states, connected badges, captured answers, and growth trends.' },
                    { key: 'warning', label: 'Warning', description: 'Review states, warnings, and attention badges.' },
                    { key: 'danger', label: 'Danger', description: 'Errors, destructive actions, and negative states.' },
                    { key: 'neutral', label: 'Neutral', description: 'Text, dividers, passive borders, and quiet structural UI.' },
                    { key: 'surface', label: 'Surface', description: 'Panels, cards, sidebars, field backgrounds, and page surfaces.' },
                    { key: 'muted', label: 'Muted', description: 'Subtle labels, placeholders, disabled states, and low-emphasis UI.' },
                ],
                primaryThemeColors: [
                    { key: 'slate', label: 'Slate', shades: { 50: '#f8fafc', 100: '#f1f5f9', 200: '#e2e8f0', 300: '#cbd5e1', 400: '#94a3b8', 500: '#64748b', 600: '#475569', 700: '#334155', 800: '#1e293b', 900: '#0f172a', 950: '#020617' } },
                    { key: 'gray', label: 'Gray', shades: { 50: '#f9fafb', 100: '#f3f4f6', 200: '#e5e7eb', 300: '#d1d5db', 400: '#9ca3af', 500: '#6b7280', 600: '#4b5563', 700: '#374151', 800: '#1f2937', 900: '#111827', 950: '#030712' } },
                    { key: 'zinc', label: 'Zinc', shades: { 50: '#fafafa', 100: '#f4f4f5', 200: '#e4e4e7', 300: '#d4d4d8', 400: '#a1a1aa', 500: '#71717a', 600: '#52525b', 700: '#3f3f46', 800: '#27272a', 900: '#18181b', 950: '#09090b' } },
                    { key: 'neutral', label: 'Neutral', shades: { 50: '#fafafa', 100: '#f5f5f5', 200: '#e5e5e5', 300: '#d4d4d4', 400: '#a3a3a3', 500: '#737373', 600: '#525252', 700: '#404040', 800: '#262626', 900: '#171717', 950: '#0a0a0a' } },
                    { key: 'stone', label: 'Stone', shades: { 50: '#fafaf9', 100: '#f5f5f4', 200: '#e7e5e4', 300: '#d6d3d1', 400: '#a8a29e', 500: '#78716c', 600: '#57534e', 700: '#44403c', 800: '#292524', 900: '#1c1917', 950: '#0c0a09' } },
                    { key: 'red', label: 'Red', shades: { 50: '#fef2f2', 100: '#fee2e2', 200: '#fecaca', 300: '#fca5a5', 400: '#f87171', 500: '#ef4444', 600: '#dc2626', 700: '#b91c1c', 800: '#991b1b', 900: '#7f1d1d', 950: '#450a0a' } },
                    { key: 'orange', label: 'Orange', shades: { 50: '#fff7ed', 100: '#ffedd5', 200: '#fed7aa', 300: '#fdba74', 400: '#fb923c', 500: '#f97316', 600: '#ea580c', 700: '#c2410c', 800: '#9a3412', 900: '#7c2d12', 950: '#431407' } },
                    { key: 'amber', label: 'Amber', shades: { 50: '#fffbeb', 100: '#fef3c7', 200: '#fde68a', 300: '#fcd34d', 400: '#fbbf24', 500: '#f59e0b', 600: '#d97706', 700: '#b45309', 800: '#92400e', 900: '#78350f', 950: '#451a03' } },
                    { key: 'yellow', label: 'Yellow', shades: { 50: '#fefce8', 100: '#fef9c3', 200: '#fef08a', 300: '#fde047', 400: '#facc15', 500: '#eab308', 600: '#ca8a04', 700: '#a16207', 800: '#854d0e', 900: '#713f12', 950: '#422006' } },
                    { key: 'lime', label: 'Lime', shades: { 50: '#f7fee7', 100: '#ecfccb', 200: '#d9f99d', 300: '#bef264', 400: '#a3e635', 500: '#84cc16', 600: '#65a30d', 700: '#4d7c0f', 800: '#3f6212', 900: '#365314', 950: '#1a2e05' } },
                    { key: 'green', label: 'Green', shades: { 50: '#f0fdf4', 100: '#dcfce7', 200: '#bbf7d0', 300: '#86efac', 400: '#4ade80', 500: '#22c55e', 600: '#16a34a', 700: '#15803d', 800: '#166534', 900: '#14532d', 950: '#052e16' } },
                    { key: 'emerald', label: 'Emerald', shades: { 50: '#ecfdf5', 100: '#d1fae5', 200: '#a7f3d0', 300: '#6ee7b7', 400: '#34d399', 500: '#10b981', 600: '#059669', 700: '#047857', 800: '#065f46', 900: '#064e3b', 950: '#022c22' } },
                    { key: 'teal', label: 'Teal', shades: { 50: '#f0fdfa', 100: '#ccfbf1', 200: '#99f6e4', 300: '#5eead4', 400: '#2dd4bf', 500: '#14b8a6', 600: '#0d9488', 700: '#0f766e', 800: '#115e59', 900: '#134e4a', 950: '#042f2e' } },
                    { key: 'cyan', label: 'Cyan', shades: { 50: '#ecfeff', 100: '#cffafe', 200: '#a5f3fc', 300: '#67e8f9', 400: '#22d3ee', 500: '#06b6d4', 600: '#0891b2', 700: '#0e7490', 800: '#155e75', 900: '#164e63', 950: '#083344' } },
                    { key: 'sky', label: 'Sky', shades: { 50: '#f0f9ff', 100: '#e0f2fe', 200: '#bae6fd', 300: '#7dd3fc', 400: '#38bdf8', 500: '#0ea5e9', 600: '#0284c7', 700: '#0369a1', 800: '#075985', 900: '#0c4a6e', 950: '#082f49' } },
                    { key: 'blue', label: 'Blue', shades: { 50: '#eff6ff', 100: '#dbeafe', 200: '#bfdbfe', 300: '#93c5fd', 400: '#60a5fa', 500: '#3b82f6', 600: '#2563eb', 700: '#1d4ed8', 800: '#1e40af', 900: '#1e3a8a', 950: '#172554' } },
                    { key: 'indigo', label: 'Indigo', shades: { 50: '#eef2ff', 100: '#e0e7ff', 200: '#c7d2fe', 300: '#a5b4fc', 400: '#818cf8', 500: '#6366f1', 600: '#4f46e5', 700: '#4338ca', 800: '#3730a3', 900: '#312e81', 950: '#1e1b4b' } },
                    { key: 'violet', label: 'Violet', shades: { 50: '#f5f3ff', 100: '#ede9fe', 200: '#ddd6fe', 300: '#c4b5fd', 400: '#a78bfa', 500: '#8b5cf6', 600: '#7c3aed', 700: '#6d28d9', 800: '#5b21b6', 900: '#4c1d95', 950: '#2e1065' } },
                    { key: 'purple', label: 'Purple', shades: { 50: '#faf5ff', 100: '#f3e8ff', 200: '#e9d5ff', 300: '#d8b4fe', 400: '#c084fc', 500: '#a855f7', 600: '#9333ea', 700: '#7e22ce', 800: '#6b21a8', 900: '#581c87', 950: '#3b0764' } },
                    { key: 'fuchsia', label: 'Fuchsia', shades: { 50: '#fdf4ff', 100: '#fae8ff', 200: '#f5d0fe', 300: '#f0abfc', 400: '#e879f9', 500: '#d946ef', 600: '#c026d3', 700: '#a21caf', 800: '#86198f', 900: '#701a75', 950: '#4a044e' } },
                    { key: 'pink', label: 'Pink', shades: { 50: '#fdf2f8', 100: '#fce7f3', 200: '#fbcfe8', 300: '#f9a8d4', 400: '#f472b6', 500: '#ec4899', 600: '#db2777', 700: '#be185d', 800: '#9d174d', 900: '#831843', 950: '#500724' } },
                    { key: 'rose', label: 'Rose', shades: { 50: '#fff1f2', 100: '#ffe4e6', 200: '#fecdd3', 300: '#fda4af', 400: '#fb7185', 500: '#f43f5e', 600: '#e11d48', 700: '#be123c', 800: '#9f1239', 900: '#881337', 950: '#4c0519' } },
                ],
                radiusPanelOpen: false,
                buttonRadius: 'md',
                fieldRadius: 'md',
                cardRadius: 'lg',
                iconTileRadius: 'md',
                radiusOptions: [
                    { key: 'none', label: 'None', className: 'rounded-none', value: '0px' },
                    { key: 'sm', label: 'Small', className: 'rounded-sm', value: '0.125rem' },
                    { key: 'default', label: 'Default', className: 'rounded', value: '0.25rem' },
                    { key: 'md', label: 'Medium', className: 'rounded-md', value: '0.375rem' },
                    { key: 'lg', label: 'Large', className: 'rounded-lg', value: '0.5rem' },
                    { key: 'xl', label: 'Extra Large', className: 'rounded-xl', value: '0.75rem' },
                    { key: '2xl', label: '2XL', className: 'rounded-2xl', value: '1rem' },
                    { key: '3xl', label: '3XL', className: 'rounded-3xl', value: '1.5rem' },
                    { key: 'full', label: 'Full', className: 'rounded-full', value: '9999px' },
                ],
                iconStrokePanelOpen: false,
                iconStrokeWidth: 1.5,
                iconStrokeWidthOptions: [1, 1.25, 1.5, 1.75, 2, 2.5, 3],
                typographyPanelOpen: false,
                typographyScale: 'text-sm',
                typographyLineHeight: 'default',
                typographyWeight: 'medium',
                typographyScaleOptions: [
                    {
                        key: 'text-xs',
                        className: 'text-xs',
                        description: 'Compact 12px body scale.',
                        sizes: { xs: '0.6875rem', sm: '0.75rem', base: '0.875rem', lg: '1rem', xl: '1.125rem', '2xl': '1.25rem', '3xl': '1.5rem', '4xl': '1.875rem' },
                    },
                    {
                        key: 'text-sm',
                        className: 'text-sm',
                        description: 'Tailwind default scale.',
                        sizes: { xs: '0.75rem', sm: '0.875rem', base: '1rem', lg: '1.125rem', xl: '1.25rem', '2xl': '1.5rem', '3xl': '1.875rem', '4xl': '2.25rem' },
                    },
                    {
                        key: 'text-base',
                        className: 'text-base',
                        description: 'Larger, more readable UI text.',
                        sizes: { xs: '0.875rem', sm: '1rem', base: '1.125rem', lg: '1.25rem', xl: '1.5rem', '2xl': '1.875rem', '3xl': '2.25rem', '4xl': '3rem' },
                    },
                    {
                        key: 'text-lg',
                        className: 'text-lg',
                        description: 'Oversized exploration mode.',
                        sizes: { xs: '1rem', sm: '1.125rem', base: '1.25rem', lg: '1.5rem', xl: '1.875rem', '2xl': '2.25rem', '3xl': '3rem', '4xl': '3.75rem' },
                    },
                ],
                typographyLineHeightOptions: [
                    { key: 'tight', className: 'leading-tight', leading: { xs: '0.875rem', sm: '1.125rem', base: '1.25rem', lg: '1.5rem', xl: '1.5rem', '2xl': '1.75rem', '3xl': '2rem', '4xl': '2.25rem' } },
                    { key: 'default', className: 'leading-normal', leading: { xs: '1rem', sm: '1.25rem', base: '1.5rem', lg: '1.75rem', xl: '1.75rem', '2xl': '2rem', '3xl': '2.25rem', '4xl': '2.5rem' } },
                    { key: 'relaxed', className: 'leading-relaxed', leading: { xs: '1.125rem', sm: '1.5rem', base: '1.75rem', lg: '2rem', xl: '2.125rem', '2xl': '2.375rem', '3xl': '2.75rem', '4xl': '3rem' } },
                ],
                typographyWeightOptions: [
                    { key: 'medium', className: 'font-medium', weights: { medium: 500, semibold: 500, bold: 600 } },
                    { key: 'default', className: 'font-semibold', weights: { medium: 500, semibold: 600, bold: 700 } },
                    { key: 'bold', className: 'font-bold', weights: { medium: 600, semibold: 700, bold: 800 } },
                ],
                activeNav: 'Dashboard',
                activeTab: 'Leads',
                leadDetailOpen: false,
                leadDetailsEditing: false,
                selectedLead: null,
                selectedLeadIds: [],
                leadAssignModalOpen: false,
                leadAssignCampaignName: '',
                leadAddMenuOpen: false,
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
                campaignBuilderMobileProgressOpen: false,
                campaignBuilderTransitioning: false,
                campaignBuilderTransitionLabel: 'Preparing Campaign Setup...',
                campaignBuilderStep: 0,
                campaignBuilderMaxStep: 0,
                campaignBuilderScrollFromStep: null,
                campaignBuilderFadingStep: null,
                campaignBuilderEnteringStep: null,
                progressBarStyle: 'timeline',
                progressBarStyleOptions: [
                    { key: 'timeline', label: 'Timeline' },
                    { key: 'bulletlist', label: 'Bulletlist' },
                ],
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
                campaignSetupCanvasStyle: '',
                campaignSetupPanelContentStyle: '',
                campaignSetupFlowSpacerStyle: '',
                campaignSetupPanelMaxScroll: 0,
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
                    arrowLeft: 160,
                },
                captureToast: {
                    visible: false,
                    title: 'Question Captured',
                    message: 'Added to Conversation Intelligence for review.',
                    timer: null,
                },
                ageSortDirection: 'asc',
                page: 1,
                perPage: 10,
                perPageOptions: [10, 25, 50, 100],
                leadStateOptions: ['Idle', 'Review Required'],
                leadCalendarMonths: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
                leadCountryOptions: [
                    { code: 'US', name: 'United States', flagCode: 'us' },
                    { code: 'CA', name: 'Canada', flagCode: 'ca' },
                    { code: 'GB', name: 'United Kingdom', flagCode: 'gb' },
                    { code: 'DE', name: 'Germany', flagCode: 'de' },
                    { code: 'FR', name: 'France', flagCode: 'fr' },
                    { code: 'ES', name: 'Spain', flagCode: 'es' },
                    { code: 'IT', name: 'Italy', flagCode: 'it' },
                    { code: 'NL', name: 'Netherlands', flagCode: 'nl' },
                    { code: 'LT', name: 'Lithuania', flagCode: 'lt' },
                    { code: 'PL', name: 'Poland', flagCode: 'pl' },
                    { code: 'AU', name: 'Australia', flagCode: 'au' },
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
                    { label: 'Analytics', icon: 'monitoring' },
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
                companySetupSelectedCompany: 'new',
                companySetupDemoCompanies: [
                    {
                        id: 'outcraft',
                        name: 'Outcraft AI',
                        website: 'outcraft.ai',
                        industry: 'SaaS',
                        description: 'AI outreach platform for campaign setup, lead conversations, and automated follow-up.',
                        problem: 'Teams need faster outreach setup without losing context or personalization.',
                        differentiators: 'AI-guided setup, reusable company context, custom fields, and multi-channel campaign orchestration.',
                        icp: 'Growth teams, agencies, and sales-led SaaS companies running outbound or lifecycle campaigns.',
                        faqs: 'Q: Can AI book meetings?\nA: Yes, when booking is enabled and a calendar link is provided.\n\nQ: Can it use merge tags?\nA: Yes, connected lead sources can provide custom fields.',
                        supportEmail: 'support@outcraft.ai',
                        termsUrl: 'https://outcraft.ai/terms-of-service',
                        privacyUrl: 'https://outcraft.ai/privacy-policy',
                        certifications: 'SOC2',
                        compliance: 'GDPR, CCPA',
                    },
                    {
                        id: 'pulsetto',
                        name: 'Pulsetto',
                        website: 'pulsetto.com',
                        industry: 'Ecommerce',
                        description: 'Wellness device brand helping customers manage stress, sleep, and relaxation routines.',
                        problem: 'Customers need clear guidance before choosing a wellness device and may need help after checkout.',
                        differentiators: 'Portable device, approachable education, fast customer support, and practical wellness routines.',
                        icp: 'Health-conscious consumers, busy professionals, and customers researching stress or sleep support.',
                        faqs: 'Q: Is Pulsetto easy to use?\nA: Yes, setup is designed to be simple.\n\nQ: Can customers get support?\nA: Yes, support can help with product and delivery questions.',
                        supportEmail: 'support@pulsetto.com',
                        termsUrl: 'https://pulsetto.com/terms-of-service',
                        privacyUrl: 'https://pulsetto.com/privacy-policy',
                        certifications: '',
                        compliance: 'GDPR',
                    },
                    {
                        id: 'nova-commerce',
                        name: 'Nova Commerce',
                        website: 'novacommerce.example',
                        industry: 'Ecommerce',
                        description: 'Retail brand selling curated home, lifestyle, and seasonal product bundles.',
                        problem: 'Shoppers abandon carts when they need timing, delivery, or product-fit reassurance.',
                        differentiators: 'Curated bundles, fast delivery, seasonal offers, and practical post-purchase support.',
                        icp: 'Online shoppers who browse product bundles, abandon checkout, or respond to seasonal offers.',
                        faqs: 'Q: Do you offer discounts?\nA: Campaign-specific discounts may be available.\n\nQ: Can shoppers recover their cart?\nA: Yes, abandoned cart links can be sent when enabled.',
                        supportEmail: 'support@novacommerce.example',
                        termsUrl: 'https://novacommerce.example/terms-of-service',
                        privacyUrl: 'https://novacommerce.example/privacy-policy',
                        certifications: '',
                        compliance: 'GDPR, CCPA',
                    },
                ],
                companySetupSteps: [
                    { label: 'Create or Choose Company', description: 'Select an existing profile or start fresh.', icon: 'apartment' },
                    { label: 'Company Identity', description: 'Name, website, and pronunciation.', icon: 'fingerprint' },
                    { label: 'Industry & Market', description: 'Positioning, customers, and FAQs.', icon: 'analytics' },
                    { label: 'Compliance & Legal', description: 'Support, policies, and standards.', icon: 'gpp_good' },
                ],
	                campaignSetupMode: 'fast',
	                campaignSetupModeSelected: false,
	                campaignSetupIntroStep: 'type',
	                campaignSetupFastSteps: [
	                    { id: 'agent', label: 'AI Agent', description: 'Identity, voice, work time, and other settings.' },
	                    { id: 'channels', label: 'Outreach Channels', description: 'Calls, SMS, email, WhatsApp.' },
	                    { id: 'brief', label: 'Campaign Context', description: 'Describe goal and context.' },
	                    { id: 'review', label: 'Review & Launch', description: 'Validate and launch.' },
	                ],
                campaignSetupAdvancedSteps: [
		                    { id: 'agent', label: 'AI Agent', description: 'Identity, voice, work time, and other settings.', group: 'Agent' },
			                    { id: 'channels', label: 'Outreach Channels', description: 'Transport settings.', group: 'Campaign' },
		                    { id: 'sequence', label: 'Outreach Sequence', description: 'Timeline and actions.', group: 'Outreach' },
		                    { id: 'followups', label: 'Follow-Ups', description: 'Response-based follow-up sequences.', group: 'Outreach' },
		                    { id: 'brief', label: 'Campaign Context', description: 'Essence, goal, and qualification.', group: 'Campaign' },
		                    { id: 'booking', label: 'Booking', description: 'Meeting and calendar rules.', group: 'Campaign' },
	                    { id: 'intelligence', label: 'Conversation Intelligence', description: 'Evaluation fields.', group: 'Intelligence' },
                    { id: 'review', label: 'Review & Launch', description: 'Validate and launch.', group: 'Finish' },
                ],
                campaignSetupLanguageOptions: [
                    { code: 'US', label: 'US', name: 'English', flagCode: 'us' },
                    { code: 'GB', label: 'UK', name: 'English', flagCode: 'gb' },
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
                    languages: [{ code: 'US', label: 'US', name: 'English', flagCode: 'us' }],
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
	                    abandonedCartLink: true,
	                    cartLinkSource: 'Dynamic (Use URL from lead data)',
	                    cartLinkStructure: '@{{cart_url}}?utm_source=outcraft&utm_medium=email&utm_campaign=cart-recovery',
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
	                    calendarConnectionStatus: '',
	                    bookingCallLink: 'https://calendly.com/outcraft/demo',
	                    bookingEmailLink: '',
	                    bookingSmsLink: '',
		                    smsTriggers: ['Positive Response'],
		                    callGuidelines: '',
		                    smsGuidelines: 'Keep it under 1 sentence, add a full URL to the product: https://company.io/product, and attach a discount code.',
	                    emailGuidelines: '',
	                    whatsappGuidelines: '',
	                    handoff: false,
	                    followupsEnabled: false,
	                    followupPositive: false,
	                    followupEngaged: false,
	                    followupNegative: false,
	                    activeFollowupSequence: 'positive',
	                    handoffPositive: false,
	                    handoffRequested: false,
	                    handoffScenario: '',
	                    handoffChannel: '',
	                    handoffNotificationEmail: 'support@pulsetto.com',
	                    knowledgePublished: false,
                    evaluationFormat: 'Text Summary',
                    sequenceModalOpen: false,
                    sequenceActionOpen: '',
                    sequenceEditingIndex: null,
                    followupModalOpen: false,
                    discountCodeModalOpen: false,
                    integrationSkipModalOpen: false,
                    overrideModalOpen: false,
                    evaluationDrawerOpen: false,
                    evaluationActionOpen: '',
                    defaultSummaryEvaluationVisible: true,
                    capturedConversationQuestions: [],
                    dispatchDrawerOpen: false,
                    customFieldsOpen: false,
                    customFieldsLayoutOpen: false,
                    customFieldSearch: '',
                    briefTab: 'builder',
                    briefBuilderItemModalOpen: false,
                    briefBuilderItemSearch: '',
                    briefBuilderItemActionOpen: '',
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
                        newFindOutQuestion: '',
                        findOutAnswerFormatOpen: null,
                        findOutAnswerFormats: ['Yes Or No', 'Text Summary', 'Classified', 'Score Answers'],
	                        findOutQuestions: [
	                            { id: 'find-out-1', text: 'What prompted their interest?', addToIntelligence: true, answerFormat: 'Text Summary' },
	                            { id: 'find-out-2', text: 'What problem are they trying to solve?', addToIntelligence: true, answerFormat: 'Text Summary' },
	                            { id: 'find-out-3', text: 'Are they ready for the next step?', addToIntelligence: false, answerFormat: null },
	                        ],
	                        builderItems: [],
	                        nextStep: 'Offer the most relevant next step, resource, handoff, or booking path based on the conversation.',
	                        pricingSource: 'Use Knowledge Base Pricing',
	                        manualPricing: 'Pulsetto Fit - 251 EUR special offer.\nPulsetto Lite - 233 EUR special offer.',
	                        canNegotiatePrice: false,
	                        priceNegotiationPercent: '10',
	                        neverAskFor: 'Credit card information\nBanking details\nPasswords or account credentials',
	                        neverPromise: 'Specific discounts\nRefunds\nDelivery dates\nGuaranteed results',
	                        neverDiscuss: 'Unrelated topics\nDetailed competitor breakdowns\nRefund approvals',
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
                leadSourceLogos: {
                    Shopify: `<svg width="800" height="800" viewBox="0 0 800 800" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M662.395 157.096C661.844 153.096 658.34 150.882 655.444 150.638C652.553 150.397 591.381 145.863 591.381 145.863C591.381 145.863 548.896 103.685 544.233 99.0164C539.567 94.3507 530.455 95.7699 526.918 96.811C526.397 96.9644 517.636 99.6685 503.143 104.153C488.951 63.3151 463.904 25.7863 419.841 25.7863C418.625 25.7863 417.373 25.8356 416.121 25.9069C403.589 9.33425 388.066 2.13425 374.658 2.13425C272.014 2.13425 222.975 130.449 207.6 195.655C167.715 208.014 139.381 216.8 135.762 217.937C113.499 224.921 112.795 225.622 109.871 246.6C107.671 262.482 49.4192 712.973 49.4192 712.973L503.332 798.019L749.277 744.814C749.277 744.814 662.937 161.096 662.395 157.096ZM478.055 111.912L439.647 123.8C439.66 121.093 439.674 118.43 439.674 115.518C439.674 90.137 436.151 69.7014 430.499 53.5014C453.203 56.3507 468.323 82.1836 478.055 111.912ZM402.334 58.5342C408.647 74.3507 412.751 97.0493 412.751 127.679C412.751 129.247 412.737 130.679 412.723 132.129C387.745 139.866 360.603 148.266 333.4 156.693C348.674 97.7452 377.304 69.274 402.334 58.5342ZM371.838 29.6658C376.269 29.6658 380.732 31.1699 385.003 34.1096C352.107 49.589 316.847 88.5754 301.956 166.43L239.255 185.849C256.696 126.466 298.112 29.6658 371.838 29.6658Z" fill="#95BF46"/><path d="M655.444 150.638C652.554 150.397 591.381 145.863 591.381 145.863C591.381 145.863 548.896 103.685 544.233 99.0164C542.488 97.2795 540.134 96.3891 537.674 96.0055L503.354 798.014L749.277 744.814C749.277 744.814 662.937 161.096 662.395 157.096C661.844 153.096 658.34 150.882 655.444 150.638Z" fill="#5E8E3E"/><path d="M419.841 286.534L389.515 376.742C389.515 376.742 362.945 362.562 330.376 362.562C282.628 362.562 280.225 392.526 280.225 400.077C280.225 441.277 387.622 457.063 387.622 553.567C387.622 629.493 339.466 678.384 274.534 678.384C196.617 678.384 156.77 629.89 156.77 629.89L177.633 560.959C177.633 560.959 218.592 596.123 253.154 596.123C275.737 596.123 284.923 578.342 284.923 565.351C284.923 511.608 196.814 509.211 196.814 420.901C196.814 346.575 250.162 274.649 357.849 274.649C399.343 274.649 419.841 286.534 419.841 286.534Z" fill="white"/></svg>`,
                    Klaviyo: `<svg width="1541" height="1032" viewBox="0 0 1541 1032" fill="none" xmlns="http://www.w3.org/2000/svg"><g clip-path="url(#clip0_16109_537)"><path fill-rule="evenodd" clip-rule="evenodd" d="M1541 1031.8H0.200195V0H1541L1217.8 516.3L1541 1031.8Z" fill="#232426"/></g><defs><clipPath id="clip0_16109_537"><rect width="1541" height="1032" fill="white"/></clipPath></defs></svg>`,
                    HubSpot: `<svg xmlns="http://www.w3.org/2000/svg" shape-rendering="geometricPrecision" text-rendering="geometricPrecision" image-rendering="optimizeQuality" fill-rule="evenodd" clip-rule="evenodd" viewBox="0 0 489 511.8"><path fill="#FF7A59" fill-rule="nonzero" d="M375.25 168.45V107.5c16.43-7.68 26.97-24.15 27.08-42.29V63.8c0-25.95-21.05-46.99-47-46.99h-1.37c-25.95 0-46.99 21.04-46.99 46.99v1.41a46.985 46.985 0 0027.29 42.3v60.94c-23.13 3.53-44.98 13.18-63.19 27.84L103.88 66.16c1.19-4.29 1.83-8.73 1.89-13.17v-.11C105.77 23.68 82.09 0 52.88 0 23.68 0 0 23.68 0 52.88c0 29.18 23.64 52.85 52.81 52.89 9.17-.08 18.16-2.59 26.06-7.23l164.62 128.07a133.501 133.501 0 00-22.16 73.61c0 27.39 8.46 54.17 24.18 76.58l-50.06 50.06a43.926 43.926 0 00-12.43-1.81c-23.96 0-43.38 19.42-43.38 43.37 0 23.96 19.42 43.38 43.38 43.38 23.95 0 43.37-19.42 43.37-43.38v-.13a41.81 41.81 0 00-2.02-12.5l49.52-49.56a133.687 133.687 0 0081.54 27.78c73.76 0 133.57-59.81 133.57-133.57 0-66.05-48.3-122.2-113.61-132.06l-.14.07zm-20.39 200.4c-36.79-1.52-65.85-31.79-65.85-68.62 0-35.43 26.97-65.06 62.23-68.38h3.62c35.8 2.73 63.46 32.58 63.46 68.48 0 35.91-27.66 65.76-63.45 68.48l-.01.04zm0 0z"/></svg>`,
                    Attio: `<svg width="150" height="150" viewBox="0 0 150 150" fill="none" xmlns="http://www.w3.org/2000/svg"><g clip-path="url(#clip0_16109_542)"><path d="M141.71 96.93L130.37 78.78C130.37 78.78 130.33 78.7 130.3 78.67L129.41 77.24C127.74 74.54 124.79 72.9 121.62 72.91L103.35 72.85L102.08 74.9L80.2499 109.82L79.0399 111.75L88.1899 126.35C89.8799 129.07 92.7899 130.69 96.0099 130.69H121.61C124.77 130.69 127.75 129.03 129.42 126.36L130.32 124.92C130.32 124.92 130.36 124.88 130.37 124.87L141.72 106.7C143.58 103.71 143.58 99.92 141.72 96.93H141.71ZM138.25 104.53L126.89 122.7C126.84 122.79 126.78 122.85 126.73 122.93C126.16 123.56 125.19 123.62 124.56 123.05C124.45 122.95 124.35 122.83 124.27 122.7L112.92 104.52C112.66 104.11 112.47 103.67 112.33 103.21C111.93 101.82 112.14 100.33 112.9 99.11L124.24 80.96L124.27 80.91C124.54 80.5 124.88 80.32 125.17 80.26C125.29 80.22 125.39 80.21 125.47 80.2H125.6C125.86 80.2 126.51 80.28 126.92 80.94L138.26 99.09C139.3 100.74 139.3 102.87 138.26 104.52H138.25V104.53ZM108.16 53.02C110.02 50.03 110.02 46.24 108.16 43.25L96.8199 25.1L95.8699 23.57C94.1899 20.87 91.2299 19.23 88.0499 19.24H62.4499C59.2599 19.24 56.3399 20.87 54.6399 23.57L8.8099 96.95C6.9299 99.93 6.9299 103.73 8.8099 106.71L21.0999 126.39C22.7699 129.09 25.7299 130.73 28.9099 130.72H54.5099C57.7199 130.72 60.6399 129.09 62.3299 126.39L63.2699 124.9V124.85L72.4199 110.24L99.4999 66.9L108.15 53.04H108.17L108.16 53.02ZM105.48 48.13C105.48 49.06 105.22 50.01 104.69 50.84L59.7999 122.71C59.5199 123.16 59.0199 123.44 58.4899 123.43C57.9599 123.43 57.4599 123.16 57.1699 122.71L45.8299 104.53C44.7999 102.87 44.7999 100.77 45.8299 99.1L90.7099 27.27C90.9899 26.81 91.4899 26.53 92.0299 26.53C92.2899 26.53 92.9399 26.61 93.3499 27.27L104.69 45.42C105.22 46.26 105.48 47.2 105.48 48.14V48.13Z" fill="black"/></g><defs><clipPath id="clip0_16109_542"><rect width="150" height="150" fill="white"/></clipPath></defs></svg>`,
                    'Microsoft Dynamics': `<svg width="263" height="356" viewBox="0 0 263 356" fill="none" xmlns="http://www.w3.org/2000/svg"><mask id="mask0_16109_550" style="mask-type:luminance" maskUnits="userSpaceOnUse" x="0" y="0" width="263" height="356"><path d="M262.784 113.983C262.784 98.1046 252.83 83.9974 237.868 78.6232L20.0921 0.881107C10.3209 -2.59988 0 4.66745 0 15.0493V133.281C0 139.632 3.96958 145.312 9.95444 147.449L107.544 182.32C117.316 185.801 127.636 178.534 127.636 168.152V100.181C127.636 94.9289 132.888 91.3258 137.774 93.1579L163.362 102.807C178.019 108.303 187.668 122.288 187.668 137.922V167.48L77.4369 207.786C71.5131 209.924 67.6045 215.603 67.6045 221.893V340.064C67.6045 350.507 77.9865 357.774 87.7577 354.171L238.112 299.208C252.891 293.773 262.784 279.727 262.784 263.971V113.983Z" fill="white"/></mask><g mask="url(#mask0_16109_550)"><path d="M0 -6.3252L262.723 87.4783V216.336C262.723 226.718 252.464 233.985 242.692 230.504L187.668 210.84V137.922C187.668 122.288 177.958 108.303 163.362 102.807L137.774 93.2189C132.888 91.3868 127.636 94.9899 127.636 100.242V189.465L0 143.907V-6.3252Z" fill="url(#paint0_linear_16109_550)"/><path d="M262.723 115.326C262.723 131.082 252.891 145.189 238.051 150.625L67.5435 212.916V363.026L262.723 291.696V115.326Z" fill="black" fill-opacity="0.24"/><path d="M262.723 121.311C262.723 137.067 252.891 151.174 238.051 156.609L67.5435 218.901V369.011L262.723 297.681V121.311Z" fill="black" fill-opacity="0.32"/><path d="M262.723 113.799C262.723 129.555 252.891 143.663 238.051 149.098L67.5435 211.389V361.499L262.723 290.169V113.799Z" fill="url(#paint1_linear_16109_550)"/><path opacity="0.5" d="M262.723 113.799C262.723 129.555 252.891 143.663 238.051 149.098L67.5435 211.389V361.499L262.723 290.169V113.799Z" fill="url(#paint2_linear_16109_550)"/><path opacity="0.5" d="M187.668 167.541L127.575 189.526V277.589C127.575 282.841 132.827 286.444 137.713 284.612L163.362 274.963C178.019 269.467 187.668 255.482 187.668 239.848V167.541Z" fill="#B0ADFF"/></g><defs><linearGradient id="paint0_linear_16109_550" x1="86.4446" y1="-1.97457" x2="156.305" y2="180.897" gradientUnits="userSpaceOnUse"><stop stop-color="#0B53CE"/><stop offset="1" stop-color="#7252AA"/></linearGradient><linearGradient id="paint1_linear_16109_550" x1="165.169" y1="348.349" x2="165.169" y2="130.371" gradientUnits="userSpaceOnUse"><stop stop-color="#2266E3"/><stop offset="1" stop-color="#AE7FE2"/></linearGradient><linearGradient id="paint2_linear_16109_550" x1="262.753" y1="237.657" x2="187.975" y2="237.657" gradientUnits="userSpaceOnUse"><stop stop-color="#94B9FF"/><stop offset="0.2878" stop-color="#94B9FF" stop-opacity="0.5236"/><stop offset="1" stop-color="#538FFF" stop-opacity="0"/></linearGradient></defs></svg>`,
                    Salesforce: `<svg width="273" height="191" viewBox="0 0 273 191" fill="none" xmlns="http://www.w3.org/2000/svg"><mask id="mask0_16109_586" style="mask-type:luminance" maskUnits="userSpaceOnUse" x="0" y="0" width="273" height="191"><path d="M0.0600586 0.5H272.06V190.5H0.0600586V0.5Z" fill="white"/></mask><g mask="url(#mask0_16109_586)"><path fill-rule="evenodd" clip-rule="evenodd" d="M113 21.2998C121.78 12.1598 134 6.49976 147.5 6.49976C165.5 6.49976 181.1 16.4998 189.5 31.3998C196.957 28.0665 205.033 26.3456 213.2 26.3498C245.6 26.3498 271.9 52.8498 271.9 85.5498C271.9 118.25 245.6 144.75 213.2 144.75C209.24 144.75 205.38 144.352 201.6 143.6C194.25 156.7 180.2 165.6 164.2 165.6C157.686 165.613 151.255 164.135 145.4 161.28C137.95 178.78 120.6 191.08 100.4 191.08C79.3003 191.08 61.4003 177.78 54.5003 159.08C51.4292 159.728 48.2989 160.054 45.1603 160.052C20.0603 160.052 -0.239746 139.452 -0.239746 114.152C-0.239746 97.1518 8.90025 82.3518 22.4603 74.3518C19.5835 67.7248 18.1027 60.5762 18.1103 53.3518C18.1103 24.1518 41.8103 0.551758 71.0103 0.551758C88.1103 0.551758 103.41 8.70176 113.01 21.3518" fill="#00A1E0"/></g><path fill-rule="evenodd" clip-rule="evenodd" d="M39.4002 99.2999C39.2292 99.7459 39.4612 99.8389 39.5162 99.9179C40.0272 100.288 40.5462 100.556 41.0662 100.857C43.8462 102.327 46.4662 102.757 49.2062 102.757C54.7862 102.757 58.2562 99.7869 58.2562 95.0069V94.9129C58.2562 90.4929 54.3362 88.8829 50.6762 87.7329L50.1972 87.5779C47.4272 86.6799 45.0372 85.8979 45.0372 84.0779V83.9849C45.0372 82.4249 46.4372 81.2749 48.5972 81.2749C50.9972 81.2749 53.8572 82.0739 55.6872 83.0849C55.6872 83.0849 56.2292 83.4349 56.4262 82.9119C56.5332 82.6289 57.4662 80.1319 57.5662 79.8519C57.6722 79.5589 57.4862 79.3379 57.2952 79.2239C55.1952 77.9439 52.2952 77.0739 49.2952 77.0739L48.7382 77.0759C43.6282 77.0759 40.0582 80.1659 40.0582 84.5859V84.6809C40.0582 89.3409 43.9982 90.8609 47.6782 91.9109L48.2702 92.0949C50.9502 92.9189 53.2702 93.6349 53.2702 95.5149V95.6089C53.2702 97.3389 51.7602 98.6289 49.3402 98.6289C48.3992 98.6289 45.4002 98.6129 42.1502 96.5589C41.7572 96.3299 41.5332 96.1649 41.2302 95.9799C41.0702 95.8829 40.6702 95.7079 40.4962 96.2319L39.3962 99.2919M121.096 99.2919C120.925 99.7379 121.157 99.8309 121.214 99.9099C121.723 100.28 122.244 100.548 122.764 100.849C125.544 102.319 128.164 102.749 130.904 102.749C136.484 102.749 139.954 99.7789 139.954 94.9989V94.9049C139.954 90.4849 136.044 88.8749 132.374 87.7249L131.895 87.5699C129.125 86.6719 126.735 85.8899 126.735 84.0699V83.9769C126.735 82.4169 128.135 81.2669 130.295 81.2669C132.695 81.2669 135.545 82.0659 137.385 83.0769C137.385 83.0769 137.927 83.4269 138.125 82.9039C138.231 82.6209 139.165 80.1239 139.255 79.8439C139.362 79.5509 139.175 79.3299 138.985 79.2159C136.885 77.9359 133.985 77.0659 130.985 77.0659L130.427 77.0679C125.317 77.0679 121.747 80.1579 121.747 84.5779V84.6729C121.747 89.3329 125.687 90.8529 129.367 91.9029L129.958 92.0869C132.648 92.9109 134.958 93.6269 134.958 95.5069V95.6009C134.958 97.3309 133.448 98.6209 131.028 98.6209C130.085 98.6209 127.078 98.6049 123.838 96.5509C123.445 96.3219 123.215 96.1639 122.917 95.9719C122.816 95.9079 122.345 95.7239 122.184 96.2239L121.084 99.2839M176.884 89.9239C176.884 92.6239 176.38 94.7539 175.394 96.2639C174.41 97.7539 172.924 98.4839 170.854 98.4839C168.784 98.4839 167.304 97.7599 166.334 96.2739C165.357 94.7739 164.864 92.6339 164.864 89.9339C164.864 87.2339 165.36 85.1139 166.334 83.6239C167.302 82.1439 168.774 81.4339 170.854 81.4339C172.934 81.4339 174.414 82.1509 175.394 83.6239C176.386 85.1139 176.884 87.2339 176.884 89.9339M181.544 84.9239C181.085 83.3739 180.374 82.0139 179.424 80.8739C178.473 79.7339 177.274 78.8139 175.844 78.1539C174.424 77.4889 172.744 77.1539 170.844 77.1539C168.944 77.1539 167.274 77.4909 165.844 78.1539C164.424 78.8179 163.214 79.7339 162.264 80.8739C161.316 82.0139 160.604 83.3739 160.144 84.9239C159.689 86.4639 159.458 88.1439 159.458 89.9339C159.458 91.7239 159.689 93.4039 160.144 94.9439C160.601 96.4939 161.314 97.8539 162.264 98.9939C163.215 100.134 164.424 101.044 165.844 101.694C167.274 102.342 168.954 102.672 170.844 102.672C172.734 102.672 174.414 102.342 175.834 101.694C177.254 101.046 178.464 100.134 179.414 98.9939C180.363 97.8539 181.074 96.4939 181.534 94.9439C181.988 93.4039 182.219 91.7239 182.219 89.9339C182.219 88.1539 181.988 86.4639 181.534 84.9239M219.834 97.7239C219.681 97.2709 219.239 97.4419 219.239 97.4419C218.562 97.7009 217.839 97.9409 217.069 98.0609C216.293 98.1829 215.429 98.2439 214.519 98.2439C212.269 98.2439 210.469 97.5729 209.189 96.2439C207.899 94.9139 207.179 92.7739 207.189 89.8739C207.196 87.2339 207.834 85.2539 208.979 83.7339C210.109 82.2339 211.849 81.4539 214.149 81.4539C216.069 81.4539 217.539 81.6769 219.079 82.1589C219.079 82.1589 219.444 82.3179 219.619 81.8369C220.028 80.7069 220.33 79.8969 220.769 78.6569C220.893 78.3019 220.589 78.1519 220.478 78.1089C219.874 77.8729 218.448 77.4859 217.368 77.3229C216.358 77.1689 215.188 77.0889 213.868 77.0889C211.908 77.0889 210.168 77.4239 208.678 78.0879C207.188 78.7509 205.928 79.6679 204.928 80.8079C203.928 81.9479 203.168 83.3079 202.658 84.8579C202.153 86.3979 201.898 88.0879 201.898 89.8779C201.898 93.7379 202.938 96.8679 204.998 99.1579C207.058 101.458 210.158 102.618 214.198 102.618C216.588 102.618 219.038 102.135 220.798 101.438C220.798 101.438 221.134 101.276 220.988 100.884L219.838 97.7239M227.988 87.3239C228.211 85.8239 228.622 84.5739 229.268 83.6039C230.235 82.1239 231.708 81.3139 233.778 81.3139C235.848 81.3139 237.218 82.1279 238.198 83.6039C238.848 84.5789 239.132 85.8739 239.238 87.3239L227.938 87.3219L227.988 87.3239ZM243.688 84.0239C243.291 82.5339 242.308 81.0239 241.668 80.3339C240.648 79.2439 239.658 78.4739 238.668 78.0539C237.239 77.4462 235.701 77.1342 234.148 77.1369C232.178 77.1369 230.388 77.4699 228.938 78.1469C227.488 78.8289 226.268 79.7569 225.308 80.9169C224.349 82.0769 223.628 83.4469 223.168 85.0169C222.708 86.5669 222.476 88.2669 222.476 90.0469C222.476 91.8669 222.717 93.5569 223.191 95.0869C223.67 96.6269 224.441 97.9769 225.481 99.0969C226.521 100.227 227.851 101.107 229.451 101.727C231.041 102.342 232.971 102.661 235.181 102.654C239.741 102.639 242.141 101.624 243.121 101.074C243.296 100.976 243.461 100.807 243.255 100.32L242.225 97.4299C242.067 96.9989 241.631 97.1549 241.631 97.1549C240.501 97.5769 238.901 98.3349 235.151 98.3249C232.701 98.3209 230.891 97.5979 229.751 96.4649C228.591 95.3049 228.011 93.6149 227.921 91.2149L243.721 91.2269C243.721 91.2269 244.137 91.2229 244.18 90.8169C244.197 90.6489 244.721 87.5769 243.709 84.0269L243.688 84.0239ZM101.688 87.3239C101.911 85.8239 102.323 84.5739 102.968 83.6039C103.936 82.1239 105.408 81.3139 107.478 81.3139C109.548 81.3139 110.918 82.1279 111.898 83.6039C112.547 84.5789 112.831 85.8739 112.938 87.3239L101.638 87.3219L101.688 87.3239ZM117.388 84.0239C116.992 82.5339 116.008 81.0239 115.368 80.3339C114.348 79.2439 113.358 78.4739 112.368 78.0539C110.939 77.4462 109.401 77.1342 107.848 77.1369C105.878 77.1369 104.088 77.4699 102.638 78.1469C101.188 78.8289 99.9682 79.7569 99.0082 80.9169C98.0512 82.0769 97.3282 83.4469 96.8682 85.0169C96.4092 86.5669 96.1782 88.2669 96.1782 90.0469C96.1782 91.8669 96.4172 93.5569 96.8942 95.0869C97.3722 96.6269 98.1442 97.9769 99.1742 99.0969C100.214 100.227 101.544 101.107 103.144 101.727C104.734 102.342 106.654 102.661 108.874 102.654C113.434 102.639 115.834 101.624 116.814 101.074C116.988 100.976 117.154 100.807 116.947 100.32L115.917 97.4299C115.758 96.9989 115.322 97.1549 115.322 97.1549C114.192 97.5769 112.592 98.3349 108.842 98.3249C106.402 98.3209 104.582 97.5979 103.442 96.4649C102.282 95.3049 101.702 93.6149 101.612 91.2149L117.412 91.2269C117.412 91.2269 117.828 91.2229 117.871 90.8169C117.888 90.6489 118.412 87.5769 117.399 84.0269L117.388 84.0239ZM67.5882 97.6239C66.9692 97.1299 66.8832 97.0089 66.6782 96.6879C66.3652 96.2049 66.2052 95.5179 66.2052 94.6379C66.2052 93.2579 66.6652 92.2579 67.6152 91.5879C67.6052 91.5899 68.9752 90.4079 72.1952 90.4479C73.6285 90.4736 75.0583 90.5955 76.4752 90.8129V97.9829H76.4772C76.4772 97.9829 74.4772 98.4139 72.2172 98.5499C69.0072 98.7429 67.5872 97.6259 67.5972 97.6289L67.5882 97.6239ZM73.8682 86.5239C73.2282 86.4769 72.3982 86.4539 71.4082 86.4539C70.0582 86.4539 68.7482 86.6219 67.5282 86.9519C66.2982 87.2839 65.1882 87.7979 64.2382 88.4819C63.2856 89.1615 62.5021 90.0511 61.9482 91.0819C61.3892 92.1219 61.1042 93.3419 61.1042 94.7219C61.1042 96.1219 61.3472 97.3319 61.8272 98.3219C62.2976 99.3039 63.0057 100.153 63.8872 100.792C64.7642 101.43 65.8472 101.902 67.0972 102.182C68.3372 102.465 69.7372 102.608 71.2772 102.608C72.8972 102.608 74.5072 102.472 76.0672 102.209C77.3959 101.98 78.7195 101.722 80.0372 101.437C80.5632 101.316 81.1472 101.157 81.1472 101.157C81.5372 101.058 81.5072 100.641 81.5072 100.641L81.4982 86.2409C81.4982 83.0809 80.6542 80.7309 78.9882 79.2809C77.3282 77.8309 74.8982 77.1009 71.7482 77.1009C70.5682 77.1009 68.6582 77.2609 67.5182 77.4899C67.5182 77.4899 64.0782 78.1579 62.6582 79.2699C62.6582 79.2699 62.3462 79.4619 62.5162 79.8969L63.6362 82.8969C63.7752 83.2859 64.1542 83.1529 64.1542 83.1529C64.1542 83.1529 64.2732 83.1059 64.4132 83.0229C67.4432 81.3729 71.2832 81.4229 71.2832 81.4229C72.9832 81.4229 74.3032 81.7679 75.1832 82.4429C76.0442 83.1039 76.4832 84.1029 76.4832 86.2029V86.8699C75.1332 86.6739 73.8832 86.5609 73.8832 86.5609L73.8682 86.5239ZM200.868 78.3939C200.891 78.3412 200.903 78.2844 200.903 78.227C200.904 78.1696 200.892 78.1126 200.87 78.0596C200.848 78.0066 200.816 77.9586 200.774 77.9185C200.733 77.8783 200.685 77.8468 200.631 77.8259C200.362 77.7239 199.021 77.4409 197.991 77.3769C196.011 77.2529 194.911 77.5869 193.921 78.0309C192.943 78.4719 191.861 79.1809 191.261 80.0009L191.259 78.0809C191.259 77.8169 191.072 77.6039 190.806 77.6039H186.766C186.504 77.6039 186.314 77.8169 186.314 78.0809V101.581C186.314 101.708 186.365 101.83 186.455 101.919C186.545 102.009 186.666 102.06 186.793 102.06H190.933C191.06 102.06 191.182 102.009 191.271 101.919C191.361 101.829 191.411 101.708 191.411 101.581V89.7809C191.411 88.2009 191.585 86.6309 191.932 85.6409C192.274 84.6619 192.739 83.8809 193.312 83.3209C193.859 82.78 194.528 82.3787 195.262 82.1509C195.952 81.9531 196.665 81.8528 197.382 81.8529C198.207 81.8529 199.112 82.0649 199.112 82.0649C199.416 82.0989 199.585 81.9129 199.688 81.6389C199.959 80.9179 200.728 78.7589 200.878 78.3289" fill="#FFFFFE"/><path fill-rule="evenodd" clip-rule="evenodd" d="M162.201 67.5479C161.689 67.3933 161.169 67.2697 160.642 67.178C159.934 67.0597 159.216 67.0042 158.498 67.0119C155.645 67.0119 153.396 67.818 151.817 69.41C150.249 70.99 149.182 73.397 148.647 76.564L148.454 77.633H144.873C144.873 77.633 144.436 77.615 144.344 78.092L143.756 81.372C143.715 81.686 143.85 81.8819 144.27 81.8799H147.756L144.219 101.623C143.942 103.213 143.625 104.521 143.274 105.512C142.928 106.49 142.59 107.223 142.174 107.755C141.771 108.27 141.389 108.649 140.73 108.87C140.186 109.053 139.56 109.137 138.874 109.137C138.492 109.137 137.984 109.073 137.609 108.998C137.234 108.924 137.039 108.84 136.758 108.722C136.758 108.722 136.349 108.566 136.188 108.976C136.057 109.311 135.128 111.866 135.018 112.182C134.906 112.494 135.063 112.74 135.261 112.811C135.725 112.977 136.07 113.083 136.702 113.232C137.58 113.439 138.32 113.452 139.013 113.452C140.465 113.452 141.788 113.248 142.885 112.852C143.989 112.453 144.95 111.758 145.8 110.817C146.719 109.802 147.297 108.739 147.85 107.289C148.397 105.852 148.863 104.068 149.236 101.989L152.79 81.8799H157.986C157.986 81.8799 158.424 81.8959 158.515 81.4209L159.103 78.1409C159.144 77.8269 159.01 77.631 158.588 77.633H153.545C153.57 77.519 153.799 75.7449 154.378 74.0749C154.625 73.3619 155.09 72.7869 155.484 72.3919C155.852 72.0157 156.305 71.7338 156.805 71.5699C157.353 71.4005 157.925 71.3182 158.498 71.3259C158.973 71.3259 159.439 71.3829 159.794 71.4569C160.283 71.5609 160.473 71.6159 160.601 71.6539C161.115 71.8109 161.184 71.659 161.285 71.41L162.491 68.0979C162.615 67.7419 162.313 67.5919 162.201 67.5479ZM91.7272 101.665C91.7272 101.929 91.5392 102.144 91.2752 102.144H87.0922C86.8272 102.144 86.6392 101.929 86.6392 101.665V67.997C86.6392 67.734 86.8272 67.521 87.0922 67.521H91.2752C91.5392 67.521 91.7272 67.734 91.7272 67.997V101.665Z" fill="#FFFFFE"/></svg>`,
                },
                leadSourceGroups: [
                    { label: 'Ecommerce', items: [
                        { name: 'Shopify', icon: 'shopping_cart', requiresIntegration: true, description: 'Use store events to trigger campaigns based on customer behaviour. Import leads, track purchases, and automate follow-ups.' },
                        { name: 'Klaviyo', icon: 'mail', requiresIntegration: true, description: 'Use Klaviyo events to create targeted campaigns based on customer interactions such as email opens, clicks, and purchases.' },
                    ] },
                    { label: 'CRM', items: [
                        { name: 'HubSpot', icon: 'apartment', requiresIntegration: true, description: 'Use contact property changes, CRM events, scheduling links, and meetings.' },
                        { name: 'Attio', icon: 'fingerprint', requiresIntegration: true, description: 'Connect Attio CRM to trigger campaigns based on customer data.' },
                        { name: 'Microsoft Dynamics', icon: 'deployed_code', requiresIntegration: true, description: 'Connect Microsoft Dynamics 365 to trigger campaigns based on CRM events and customer data.' },
                        { name: 'Salesforce', icon: 'cloud', requiresIntegration: true, description: 'Integrate Salesforce to trigger campaigns based on CRM events and customer data.' },
                    ] },
                    { label: 'Manual & Developer', items: [
                        { name: 'CSV File / Manual', icon: 'upload', requiresIntegration: false, description: 'Manually import leads via CSV or create them one by one.' },
                        { name: 'Custom API', icon: 'extension', requiresIntegration: false, description: 'Use this if you have your own backend or unsupported service.' },
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
                    { key: 'calls', title: 'Voice & Calls', description: 'Enable communication with leads through AI voice calls.' },
                    { key: 'email', title: 'Email', description: 'Enable communication with leads through email.' },
                    { key: 'sms', title: 'SMS', description: 'Enable communication with leads through SMS.' },
                    { key: 'whatsapp', title: 'WhatsApp', description: 'Enable communication with leads through WhatsApp.' },
                ],
                smsTriggerOptions: ['Positive Response', 'No Decision'],
                sequenceRows: [
                    { id: 'sequence-step-1', channel: 'Call', label: 'initial_call', delay: '-', step: 'Initial outbound call to a lead introducing the company/product and the campaign offer' },
                    { id: 'sequence-step-2', channel: 'Call', label: 'initial_call', delay: '4 hours', step: 'Initial outbound call to a lead introducing the company/product and the campaign offer' },
                    { id: 'sequence-step-3', channel: 'SMS', label: 'initial_sms', delay: '1 day', step: 'Initial outbound SMS to the lead regarding the campaign' },
                    { id: 'sequence-step-4', channel: 'Call', label: 'initial_call', delay: '1 day', step: 'Initial outbound call to a lead introducing the company/product and the campaign offer' },
                    { id: 'sequence-step-5', channel: 'Call', label: 'initial_call', delay: '2 days', step: 'Initial outbound call to a lead introducing the company/product and the campaign offer' },
                    { id: 'sequence-step-6', channel: 'Call', label: 'initial_call', delay: '4 days', step: 'Initial outbound call to a lead introducing the company/product and the campaign offer' },
                    { id: 'sequence-step-7', channel: 'None', label: 'campaign_end', delay: '2 days', step: 'Indicates the end of a campaign flow. No further actions will be taken for this lead in the current campaign.' },
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
                    { label: 'Lead Campaigns', displayLabel: 'Campaign Runs', icon: 'view_agenda' },
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
                initializePrimaryTheme() {
                    const storedPrimaryValue = this.storedPrimaryThemeValue();

                    if (storedPrimaryValue && this.primaryThemeValueOptions.includes(storedPrimaryValue)) {
                        this.primaryThemeValue = storedPrimaryValue;
                    }

                    this.colorRoleOptions.forEach((role) => {
                        const storedTheme = role.key === 'primary'
                            ? (this.storedColorRoleTheme(role.key) || this.storedPrimaryTheme())
                            : this.storedColorRoleTheme(role.key);

                        if (storedTheme && !(role.key === 'success' && storedTheme === 'green') && this.primaryThemeColors.some((color) => color.key === storedTheme)) {
                            this.setColorRoleThemeValue(role.key, storedTheme);
                        }
                    });

                    this.applyColorThemes();
                },
                handlePrimaryThemeShortcut(event) {
                    const tagName = String(event.target?.tagName || '').toLowerCase();
                    const isTyping = event.target?.isContentEditable || ['input', 'textarea', 'select'].includes(tagName);

                    if (isTyping || event.metaKey || event.ctrlKey || event.altKey || event.shiftKey) {
                        return;
                    }

                    if (String(event.key || '').toLowerCase() !== 'c') {
                        return;
                    }

                    event.preventDefault();
                    this.primaryThemePanelOpen = ! this.primaryThemePanelOpen;

                    if (this.primaryThemePanelOpen) {
                        this.radiusPanelOpen = false;
                        this.iconStrokePanelOpen = false;
                        this.typographyPanelOpen = false;
                    }
                },
                initializeRadiusTheme() {
                    const storedButtonRadius = this.storedRadiusTheme('button');
                    const storedFieldRadius = this.storedRadiusTheme('field');
                    const storedCardRadius = this.storedRadiusTheme('card');
                    const storedIconTileRadius = this.storedRadiusTheme('iconTile');

                    if (storedButtonRadius && this.radiusOptions.some((radius) => radius.key === storedButtonRadius)) {
                        this.buttonRadius = storedButtonRadius;
                    }

                    if (storedFieldRadius && this.radiusOptions.some((radius) => radius.key === storedFieldRadius)) {
                        this.fieldRadius = storedFieldRadius;
                    }

                    if (storedCardRadius && this.radiusOptions.some((radius) => radius.key === storedCardRadius)) {
                        this.cardRadius = storedCardRadius;
                    }

                    if (storedIconTileRadius && this.radiusOptions.some((radius) => radius.key === storedIconTileRadius)) {
                        this.iconTileRadius = storedIconTileRadius;
                    }

                    this.applyRadiusTheme();
                },
                handleRadiusShortcut(event) {
                    const tagName = String(event.target?.tagName || '').toLowerCase();
                    const isTyping = event.target?.isContentEditable || ['input', 'textarea', 'select'].includes(tagName);

                    if (isTyping || event.metaKey || event.ctrlKey || event.altKey || event.shiftKey) {
                        return;
                    }

                    if (String(event.key || '').toLowerCase() !== 'r') {
                        return;
                    }

                    event.preventDefault();
                    this.radiusPanelOpen = ! this.radiusPanelOpen;

                    if (this.radiusPanelOpen) {
                        this.primaryThemePanelOpen = false;
                        this.iconStrokePanelOpen = false;
                        this.typographyPanelOpen = false;
                    }
                },
                initializeIconStrokeTheme() {
                    const storedWidth = this.storedIconStrokeWidth();

                    if (storedWidth !== null) {
                        this.iconStrokeWidth = this.normalizedIconStrokeWidth(storedWidth);
                    }

                    this.applyIconStrokeTheme();
                },
                handleIconStrokeShortcut(event) {
                    const tagName = String(event.target?.tagName || '').toLowerCase();
                    const isTyping = event.target?.isContentEditable || ['input', 'textarea', 'select'].includes(tagName);

                    if (isTyping || event.metaKey || event.ctrlKey || event.altKey || event.shiftKey) {
                        return;
                    }

                    if (String(event.key || '').toLowerCase() !== 'i') {
                        return;
                    }

                    event.preventDefault();
                    this.iconStrokePanelOpen = ! this.iconStrokePanelOpen;

                    if (this.iconStrokePanelOpen) {
                        this.primaryThemePanelOpen = false;
                        this.radiusPanelOpen = false;
                        this.typographyPanelOpen = false;
                    }
                },
                initializeProgressBarStyle() {
                    const storedStyle = this.storedProgressBarStyle();

                    if (storedStyle && this.progressBarStyleOptions.some((option) => option.key === storedStyle)) {
                        this.progressBarStyle = storedStyle;
                    }
                },
                storedProgressBarStyle() {
                    try {
                        return window.localStorage.getItem('outcraft-progress-bar-style');
                    } catch (error) {
                        return null;
                    }
                },
                persistProgressBarStyle() {
                    try {
                        window.localStorage.setItem('outcraft-progress-bar-style', this.progressBarStyle);
                    } catch (error) {
                        // Progress preview still works for the current session if storage is unavailable.
                    }
                },
                setProgressBarStyle(style) {
                    if (! this.progressBarStyleOptions.some((option) => option.key === style)) {
                        return;
                    }

                    this.progressBarStyle = style;
                    this.persistProgressBarStyle();
                    this.scheduleCampaignBuilderLayoutUpdate();
                },
                storedPrimaryTheme() {
                    try {
                        return window.localStorage.getItem('outcraft-primary-theme');
                    } catch (error) {
                        return null;
                    }
                },
                storedPrimaryThemeValue() {
                    try {
                        return window.localStorage.getItem('outcraft-primary-theme-value');
                    } catch (error) {
                        return null;
                    }
                },
                storedColorRoleTheme(role) {
                    try {
                        return window.localStorage.getItem(`outcraft-${role}-theme`);
                    } catch (error) {
                        return null;
                    }
                },
                persistPrimaryTheme() {
                    this.persistColorRoleTheme('primary', this.primaryTheme);
                },
                persistPrimaryThemeValue() {
                    try {
                        window.localStorage.setItem('outcraft-primary-theme-value', this.primaryThemeValue);
                    } catch (error) {
                        // Theme preview still works for the current session if storage is unavailable.
                    }
                },
                persistColorRoleTheme(role, key) {
                    try {
                        window.localStorage.setItem(`outcraft-${role}-theme`, key);
                    } catch (error) {
                        // Theme preview still works for the current session if storage is unavailable.
                    }
                },
                activeColorRoleDescription() {
                    return this.colorRoleOptions.find((role) => role.key === this.activeColorRole)?.description || '';
                },
                colorRoleTheme(role) {
                    return {
                        primary: this.primaryTheme,
                        accent: this.accentTheme,
                        info: this.infoTheme,
                        success: this.successTheme,
                        warning: this.warningTheme,
                        danger: this.dangerTheme,
                        neutral: this.neutralTheme,
                        surface: this.surfaceTheme,
                        muted: this.mutedTheme,
                    }[role] || this.primaryTheme;
                },
                isColorRoleThemeSelected(role, key) {
                    return this.colorRoleTheme(role) === key;
                },
                setColorRoleThemeValue(role, key) {
                    const roleThemeProperties = {
                        primary: 'primaryTheme',
                        accent: 'accentTheme',
                        info: 'infoTheme',
                        success: 'successTheme',
                        warning: 'warningTheme',
                        danger: 'dangerTheme',
                        neutral: 'neutralTheme',
                        surface: 'surfaceTheme',
                        muted: 'mutedTheme',
                    };
                    const property = roleThemeProperties[role];

                    if (property) {
                        this[property] = key;
                    }
                },
                setColorRoleTheme(role, key) {
                    if (! this.primaryThemeColors.some((color) => color.key === key)) {
                        return;
                    }

                    this.setColorRoleThemeValue(role, key);

                    this.persistColorRoleTheme(role, key);
                    this.applyColorThemes();
                },
                setPrimaryTheme(key) {
                    this.setColorRoleTheme('primary', key);
                },
                normalizedPrimaryThemeValue(value = this.primaryThemeValue) {
                    const normalized = String(value || '600');

                    return this.primaryThemeValueOptions.includes(normalized) ? normalized : '600';
                },
                previewPrimaryThemeValue(value) {
                    const normalized = this.normalizedPrimaryThemeValue(value);

                    if (this.primaryThemeValue !== normalized) {
                        this.primaryThemeValue = normalized;
                    }

                    this.applyColorThemes();
                },
                setPrimaryThemeValue(value) {
                    const normalized = this.normalizedPrimaryThemeValue(value);

                    if (this.primaryThemeValue !== normalized) {
                        this.primaryThemeValue = normalized;
                    }

                    this.persistPrimaryThemeValue();
                    this.applyColorThemes();
                },
                primaryThemeColor() {
                    return this.colorTheme(this.primaryTheme);
                },
                colorTheme(key) {
                    return this.primaryThemeColors.find((color) => color.key === key)
                        || this.primaryThemeColors.find((color) => color.key === 'indigo')
                        || this.primaryThemeColors[0];
                },
                hexToRgb(hex) {
                    const normalized = String(hex || '').replace('#', '');
                    const expanded = normalized.length === 3
                        ? normalized.split('').map((character) => character + character).join('')
                        : normalized;
                    const value = Number.parseInt(expanded, 16);

                    if (Number.isNaN(value)) {
                        return '79 70 229';
                    }

                    return `${(value >> 16) & 255} ${(value >> 8) & 255} ${value & 255}`;
                },
                applyPrimaryTheme() {
                    this.applyColorThemes();
                },
                applyColorThemes() {
                    this.colorRoleOptions.forEach((role) => {
                        this.applyColorRoleTheme(role.key, this.colorRoleTheme(role.key));
                    });
                },
                applyColorRoleTheme(role, key) {
                    const color = this.colorTheme(key);
                    const root = this.$root || document.querySelector('.outcraft-page');

                    if (! color || ! root) {
                        return;
                    }

                    const prefix = role === 'primary' ? 'primary' : role;

                    this.primaryThemeShadeKeys.forEach((shade) => {
                        const sourceShade = role === 'primary' ? this.primaryThemeTokenShade(shade) : shade;
                        const hex = color.shades[sourceShade] || color.shades[shade] || color.shades[600];

                        root.style.setProperty(`--oc-${prefix}-${shade}`, hex);
                        root.style.setProperty(`--oc-${prefix}-${shade}-rgb`, this.hexToRgb(hex));
                    });
                },
                primaryThemeTokenShade(shade) {
                    const order = this.primaryThemeShadeKeys;
                    const baseIndex = order.indexOf('600');
                    const selectedIndex = order.indexOf(this.normalizedPrimaryThemeValue());
                    const shadeIndex = order.indexOf(String(shade));

                    if (baseIndex === -1 || selectedIndex === -1 || shadeIndex === -1) {
                        return shade;
                    }

                    return order[Math.min(order.length - 1, Math.max(0, shadeIndex + selectedIndex - baseIndex))] || shade;
                },
                storedRadiusTheme(type) {
                    try {
                        return window.localStorage.getItem(`outcraft-${type}-radius`);
                    } catch (error) {
                        return null;
                    }
                },
                persistRadiusTheme(type, key) {
                    try {
                        window.localStorage.setItem(`outcraft-${type}-radius`, key);
                    } catch (error) {
                        // Radius preview still works for the current session if storage is unavailable.
                    }
                },
                setRadiusTheme(type, key) {
                    if (! this.radiusOptions.some((radius) => radius.key === key)) {
                        return;
                    }

                    if (type === 'button') {
                        this.buttonRadius = key;
                    }

                    if (type === 'field') {
                        this.fieldRadius = key;
                    }

                    if (type === 'card') {
                        this.cardRadius = key;
                    }

                    if (type === 'iconTile') {
                        this.iconTileRadius = key;
                    }

                    this.persistRadiusTheme(type, key);
                    this.applyRadiusTheme();
                },
                radiusOption(key) {
                    return this.radiusOptions.find((radius) => radius.key === key)
                        || this.radiusOptions.find((radius) => radius.key === 'md')
                        || this.radiusOptions[0];
                },
                selectedRadiusLabel(key) {
                    return this.radiusOption(key)?.className || 'rounded-md';
                },
                applyRadiusTheme() {
                    if (! this.$root) {
                        return;
                    }

                    this.$root.style.setProperty('--oc-button-radius', this.radiusOption(this.buttonRadius).value);
                    this.$root.style.setProperty('--oc-field-radius', this.radiusOption(this.fieldRadius).value);
                    this.$root.style.setProperty('--oc-card-radius', this.radiusOption(this.cardRadius).value);
                    this.$root.style.setProperty('--oc-icon-tile-radius', this.radiusOption(this.iconTileRadius).value);
                },
                storedIconStrokeWidth() {
                    try {
                        return window.localStorage.getItem('outcraft-icon-stroke-width');
                    } catch (error) {
                        return null;
                    }
                },
                persistIconStrokeWidth() {
                    try {
                        window.localStorage.setItem('outcraft-icon-stroke-width', String(this.iconStrokeWidth));
                    } catch (error) {
                        // Icon stroke preview still works for the current session if storage is unavailable.
                    }
                },
                normalizedIconStrokeWidth(value) {
                    const width = Number.parseFloat(value);

                    if (Number.isNaN(width)) {
                        return 1.5;
                    }

                    return Math.min(3, Math.max(1, Math.round(width * 4) / 4));
                },
                setIconStrokeWidth(value) {
                    this.iconStrokeWidth = this.normalizedIconStrokeWidth(value);
                    this.persistIconStrokeWidth();
                    this.applyIconStrokeTheme();
                },
                applyIconStrokeTheme() {
                    if (! this.$root) {
                        return;
                    }

                    this.$root.style.setProperty('--oc-icon-stroke-width', `${this.iconStrokeWidth}px`);
                },
                initializeTypographyTheme() {
                    const storedScale = this.storedTypographyTheme('scale');
                    const storedLineHeight = this.storedTypographyTheme('line-height');
                    const storedWeight = this.storedTypographyTheme('weight');

                    if (storedScale && this.typographyScaleOptions.some((option) => option.key === storedScale)) {
                        this.typographyScale = storedScale;
                    }

                    if (storedLineHeight && this.typographyLineHeightOptions.some((option) => option.key === storedLineHeight)) {
                        this.typographyLineHeight = storedLineHeight;
                    }

                    if (storedWeight && this.typographyWeightOptions.some((option) => option.key === storedWeight)) {
                        this.typographyWeight = storedWeight;
                    }

                    this.applyTypographyTheme();
                },
                handleTypographyShortcut(event) {
                    const tagName = String(event.target?.tagName || '').toLowerCase();
                    const isTyping = event.target?.isContentEditable || ['input', 'textarea', 'select'].includes(tagName);

                    if (isTyping || event.metaKey || event.ctrlKey || event.altKey || event.shiftKey) {
                        return;
                    }

                    if (String(event.key || '').toLowerCase() !== 't') {
                        return;
                    }

                    event.preventDefault();
                    this.typographyPanelOpen = ! this.typographyPanelOpen;

                    if (this.typographyPanelOpen) {
                        this.primaryThemePanelOpen = false;
                        this.radiusPanelOpen = false;
                        this.iconStrokePanelOpen = false;
                    }
                },
                storedTypographyTheme(type) {
                    try {
                        return window.localStorage.getItem(`outcraft-typography-v5-${type}`);
                    } catch (error) {
                        return null;
                    }
                },
                persistTypographyTheme(type, key) {
                    try {
                        window.localStorage.setItem(`outcraft-typography-v5-${type}`, key);
                    } catch (error) {
                        // Typography preview still works for the current session if storage is unavailable.
                    }
                },
                setTypographyTheme(type, key) {
                    if (type === 'scale' && this.typographyScaleOptions.some((option) => option.key === key)) {
                        this.typographyScale = key;
                        this.persistTypographyTheme(type, key);
                    }

                    if (type === 'lineHeight' && this.typographyLineHeightOptions.some((option) => option.key === key)) {
                        this.typographyLineHeight = key;
                        this.persistTypographyTheme('line-height', key);
                    }

                    if (type === 'weight' && this.typographyWeightOptions.some((option) => option.key === key)) {
                        this.typographyWeight = key;
                        this.persistTypographyTheme(type, key);
                    }

                    this.applyTypographyTheme();
                },
                typographyScaleOption(key) {
                    return this.typographyScaleOptions.find((option) => option.key === key)
                        || this.typographyScaleOptions.find((option) => option.key === 'text-sm')
                        || this.typographyScaleOptions[0];
                },
                typographyLineHeightOption(key) {
                    return this.typographyLineHeightOptions.find((option) => option.key === key)
                        || this.typographyLineHeightOptions.find((option) => option.key === 'default')
                        || this.typographyLineHeightOptions[0];
                },
                typographyWeightOption(key) {
                    return this.typographyWeightOptions.find((option) => option.key === key)
                        || this.typographyWeightOptions.find((option) => option.key === 'medium')
                        || this.typographyWeightOptions[0];
                },
                applyTypographyTheme() {
                    if (! this.$root) {
                        return;
                    }

                    const scale = this.typographyScaleOption(this.typographyScale);
                    const lineHeight = this.typographyLineHeightOption(this.typographyLineHeight);
                    const weight = this.typographyWeightOption(this.typographyWeight);

                    Object.entries(scale.sizes).forEach(([key, value]) => {
                        this.$root.style.setProperty(`--oc-text-${key}`, value);
                    });

                    Object.entries(lineHeight.leading).forEach(([key, value]) => {
                        this.$root.style.setProperty(`--oc-leading-${key}`, value);
                    });

                    this.$root.style.setProperty('--oc-font-medium', weight.weights.medium);
                    this.$root.style.setProperty('--oc-font-semibold', weight.weights.semibold);
                    this.$root.style.setProperty('--oc-font-bold', weight.weights.bold);
                },
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
                        this.updateCampaignSetupPanelMetrics();
                    });
                    this.$nextTick(() => {
                        const container = this.campaignBuilderScrollContainer();

                        container?.addEventListener('scroll', () => {
                            this.updateCampaignBuilderScrollScene();
                            this.updateCampaignSetupPanelScroll();
                        }, { passive: true });
                    });
                    window.addEventListener('scroll', () => {
                        this.updateCampaignBuilderScrollScene();
                        this.updateCampaignSetupPanelScroll();
                    }, { passive: true });
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

                    if (normalized === 'insights') {
                        return 'Analytics';
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
	                        const setupStartStep = this.companySetupStartStep();
	                        const normalizedBuilderStep = Number.isFinite(builderStep) ? Math.max(0, Math.min(setupStartStep, builderStep)) : (setupStep ? setupStartStep : 0);

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
                            this.campaignBuilderStep = setupStartStep;
                            this.campaignBuilderMaxStep = Math.max(this.campaignBuilderMaxStep, setupStartStep);
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

	                        if (this.campaignBuilderStep >= this.companySetupStartStep() && this.campaignSetupModeSelected) {
	                            url.searchParams.set('setupMode', this.campaignSetupMode);
	                            url.searchParams.set('setupStep', this.campaignSetup.current);
	                        } else if (this.campaignBuilderStep >= this.companySetupStartStep()) {
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
                    this.leadAddMenuOpen = false;
                    this.selectedPresetName = 'Filter Presets';
                    this.clearLeadSelection();
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

                    if (section === 'Analytics') {
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
		                    this.campaignSetupCanvasStyle = '';
		                    this.campaignSetupModeSelected = false;
	                    this.campaignSetupIntroStep = 'type';
                    this.cancelCampaignBuilderScrollAnimation();
	                    this.activeNav = 'Campaigns';
	                    this.activeCampaignPageTab = 'Campaigns';
	                    this.syncUrl(true);
	                },
                companySetupStartStep() {
                    return this.companySetupSteps.length;
                },
                companySetupFinalStepIndex() {
                    return Math.max(0, this.companySetupStartStep() - 1);
                },
                companySetupStepIcon(index = this.campaignBuilderStep) {
                    return this.companySetupSteps[index]?.icon || 'business';
                },
                resetCompanyForm() {
                    Object.assign(this.companyForm, {
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
                    });
                    this.campaignBuilderErrors = {};
                },
                selectCompanyForSetup(companyId) {
                    this.companySetupSelectedCompany = companyId;

                    if (companyId === 'new') {
                        this.resetCompanyForm();
                        this.scheduleCampaignBuilderLayoutUpdate();

                        return;
                    }

                    const company = this.companySetupDemoCompanies.find((item) => item.id === companyId);

                    if (! company) {
                        return;
                    }

                    Object.assign(this.companyForm, {
                        name: company.name,
                        website: company.website,
                        pronunciationEnabled: false,
                        pronunciation: '',
                        industry: company.industry,
                        description: company.description,
                        problem: company.problem,
                        differentiators: company.differentiators,
                        icp: company.icp,
                        faqs: company.faqs,
                        supportEmail: company.supportEmail,
                        termsUrl: company.termsUrl,
                        privacyUrl: company.privacyUrl,
                        certifications: company.certifications,
                        compliance: company.compliance,
                    });
                    this.campaignBuilderErrors = {};
                    this.scheduleCampaignBuilderLayoutUpdate();
                },
                chooseNewCompanyForSetup() {
                    this.selectCompanyForSetup('new');
                    this.setCampaignBuilderStep(1, 180);
                },
                chooseExistingCompanyForSetup(companyId) {
                    this.selectCompanyForSetup(companyId);
                    this.transitionToCampaignSetup();
                },
		                campaignBuilderBackLabel() {
	                    if (this.campaignBuilderStep < this.companySetupStartStep()) {
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
	                    if (this.campaignBuilderStep >= this.companySetupStartStep()) {
		                        if (this.campaignSetupModeSelected) {
		                            this.campaignSetupModeSelected = false;
		                            this.campaignSetupIntroStep = 'integration';
		                            this.campaignSetupActionBarStyle = '';
		                            this.campaignSetupCanvasStyle = '';
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

	                        this.goToCampaignBuilderStep(this.companySetupFinalStepIndex());

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
                        'Continue to Company Identity',
                        'Continue to Industry & Market',
                        'Continue to Compliance & Legal',
                        'Continue to Campaign',
                    ][this.campaignBuilderStep] || 'Continue';
                },
                campaignBuilderMobileContinueLabel() {
                    return 'Continue';
                },
                campaignBuilderMobileProgressLabel() {
                    if (this.campaignBuilderStep < this.companySetupStartStep()) {
                        return this.companySetupSteps[this.campaignBuilderStep]?.label || 'Company Details';
                    }

                    return this.campaignSetupCurrentStep()?.label || 'Campaign Setup';
                },
                mobileCompanySetupLabel(index) {
                    return ['Choose', 'Company', 'Market', 'Legal'][index] || `Step ${index + 1}`;
                },
                nextCampaignBuilderStep() {
                    this.setCampaignBuilderStep(Math.min(this.campaignBuilderStep + 1, this.companySetupStartStep()), 220);
                },
                previousCampaignBuilderStep() {
                    this.setCampaignBuilderStep(Math.max(this.campaignBuilderStep - 1, 0), 220);
                },
                goToCampaignBuilderStep(step) {
                    const nextStep = Math.max(0, Math.min(step, this.companySetupStartStep()));

                    if (this.campaignBuilderStep < this.companySetupStartStep() && nextStep > this.campaignBuilderMaxStep) {
                        return;
                    }

                    this.setCampaignBuilderStep(nextStep, 180);
                },
                setCampaignBuilderStep(nextStep, loaderDuration = 180) {
                    const previousStep = this.campaignBuilderStep;
                    const setupStartStep = this.companySetupStartStep();
                    const isCompanyStepTransition = previousStep < setupStartStep && nextStep < setupStartStep && previousStep !== nextStep;
                    const preserveOutgoingStepPosition = previousStep < setupStartStep && nextStep < previousStep && ! isCompanyStepTransition;
                    const outgoingStepTop = preserveOutgoingStepPosition ? this.campaignBuilderCompanyStepTop(previousStep) : null;

		                    if (previousStep < setupStartStep && nextStep >= setupStartStep) {
		                        this.campaignSetupModeSelected = false;
		                        this.campaignSetupIntroStep = 'type';
		                        this.campaignSetupActionBarStyle = '';
		                        this.campaignSetupCanvasStyle = '';
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
                        1: [
                            ['name', 'Enter your company name.'],
                            ['website', 'Enter your company website.'],
                        ],
                        2: [
                            ['industry', 'Select your industry vertical.'],
                            ['description', 'Enter your company description.'],
                        ],
                        3: [],
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

                    if (step === this.companySetupFinalStepIndex()) {
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
                        const setupStartStep = this.companySetupStartStep();

                        this.campaignBuilderStep = setupStartStep;
                        this.campaignBuilderMaxStep = Math.max(this.campaignBuilderMaxStep, setupStartStep);
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
                        'companyChooseSection',
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

                        if (! stage || this.campaignBuilderStep >= this.companySetupStartStep() || window.innerWidth < 1024) {
                            this.campaignBuilderActionBarContentStyle = '';
                            this.campaignBuilderActionBarStyle = '';
                            this.campaignBuilderActionBarFrame = null;

                            return;
                        }

                        const rect = stage.getBoundingClientRect();

                        this.campaignBuilderActionBarStyle = '';
                        this.campaignBuilderActionBarContentStyle = `box-sizing: border-box; margin-left: ${Math.max(0, rect.left)}px; width: ${rect.width}px; max-width: 64rem;`;
                        this.campaignBuilderActionBarFrame = null;
                    });
                },
                updateCampaignSetupActionBarPosition() {
                    if (this.campaignSetupActionBarFrame) {
                        cancelAnimationFrame(this.campaignSetupActionBarFrame);
                    }

                    this.campaignSetupActionBarFrame = requestAnimationFrame(() => {
                        const stage = this.$refs.campaignAgentSection;

		                        if (! stage || ! this.campaignBuilderOpen || this.campaignBuilderStep < this.companySetupStartStep() || ! this.campaignSetupModeSelected || this.campaignSetupIntroStep || window.innerWidth < 1024) {
                            this.campaignSetupActionBarContentStyle = '';
                            this.campaignSetupActionBarStyle = '';
                            this.campaignSetupCanvasStyle = '';
                            this.campaignSetupPanelContentStyle = '';
                            this.campaignSetupFlowSpacerStyle = '';
                            this.campaignSetupPanelMaxScroll = 0;
                            this.campaignSetupActionBarFrame = null;

                            return;
                        }

                        const progressAside = this.$refs.campaignBuilderProgressAside;
                        const viewportPadding = 24;
                        const progressAsideRect = progressAside?.getBoundingClientRect();
                        const stageRect = stage.getBoundingClientRect();
                        const contentLeft = progressAsideRect ? progressAsideRect.right : stageRect.left;
                        const left = Math.max(viewportPadding, contentLeft);

                        this.campaignSetupActionBarStyle = `left: ${left}px; right: 0; width: auto;`;
                        this.campaignSetupActionBarContentStyle = 'box-sizing: border-box; width: 100%; max-width: 64rem; margin-left: auto; margin-right: auto; padding-left: 2rem; padding-right: 2rem;';
                        this.campaignSetupCanvasStyle = '';
                        this.campaignSetupActionBarFrame = null;
                        this.updateCampaignSetupPanelMetrics();
                    });
                },
                campaignBuilderScrollContainer() {
                    return this.$root.querySelector('main');
                },
                campaignSetupPanelIsActive() {
                    return false;
                },
                updateCampaignSetupPanelMetrics() {
                    this.campaignSetupPanelContentStyle = '';
                    this.campaignSetupFlowSpacerStyle = '';
                    this.campaignSetupPanelMaxScroll = 0;
                },
                updateCampaignSetupPanelScroll() {
                    this.campaignSetupPanelContentStyle = '';
                },
                scheduleCampaignBuilderLayoutUpdate() {
                    const run = () => {
                        renderOutcraftIcons(this.$root);
                        this.updateCampaignBuilderStickyLayout();
                        this.updateCampaignBuilderScrollScene();
                        this.updateCampaignBuilderBottomPadding();
                        this.updateCampaignSetupBottomPadding();
                        this.updateCampaignBuilderActionBarPosition();
                        this.updateCampaignSetupActionBarPosition();
                        this.updateCampaignSetupPanelMetrics();
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
                campaignBuilderUsesSidebarLayout() {
                    return this.campaignBuilderStep < this.companySetupStartStep()
                        || (this.campaignBuilderStep >= this.companySetupStartStep()
                            && this.campaignSetupModeSelected
                            && ! this.campaignSetupIntroStep);
                },
                campaignBuilderUsesIntroLayout() {
                    return this.campaignBuilderStep >= this.companySetupStartStep()
                        && ! this.campaignSetupModeSelected
                        && Boolean(this.campaignSetupIntroStep);
                },
                campaignBuilderColumnViewportStyle() {
                    return '';
                },
                campaignBuilderProgressStickyStyle() {
                    if (this.campaignBuilderUsesIntroLayout() || ! this.campaignBuilderProgressSticky || window.innerWidth < 1024) {
                        return '';
                    }

                    return `position: sticky; top: ${this.campaignBuilderProgressStickyTop}px;`;
                },
                campaignSetupFrameTopOffset() {
                    return 0;
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
	                    const stickyTop = this.campaignBuilderUsesSidebarLayout()
                            ? this.campaignSetupFrameTopOffset()
                            : Math.min(24, viewportHeight - progressHeight - 24);

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
                            this.campaignBuilderProgressStickyTop = this.campaignBuilderUsesSidebarLayout()
                                ? this.campaignSetupFrameTopOffset()
                                : Math.min(24, viewportHeight - progress.scrollHeight - 24);
                            this.campaignBuilderContentSticky = false;
                            this.updateCampaignBuilderScrollScene();
                        });
                    });
                },
                updateCampaignBuilderBottomPadding() {
                    if (this.campaignBuilderStep === 0) {
                        this.campaignBuilderBottomPadding = 0;

                        return;
                    }

                    const companyStepRefs = [
                        'companyChooseSection',
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
                    if (! this.campaignBuilderOpen || this.campaignBuilderStep < this.companySetupStartStep() || ! this.campaignSetupModeSelected) {
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

                            this.campaignSetupBottomPadding = 0;

                            return;
                        });
                    });
                },
                scrollCampaignBuilderToStep(step, behavior = 'smooth') {
                    const companyStepRefs = [
                        'companyChooseSection',
                        'companyIdentitySection',
                        'industryMarketSection',
                        'complianceLegalSection',
                    ];

                    this.$nextTick(() => this.scrollBuilderStageToTop(step >= this.companySetupStartStep() ? 'campaignAgentSection' : (companyStepRefs[step] || 'companyDetailsFormStage'), behavior));
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
                        return 'Launch Campaign';
                    }

                    return `Continue to ${steps[currentIndex + 1]?.label || 'Next Step'}`;
                },
                campaignSetupMobileContinueLabel() {
                    return this.campaignSetupStepIndex() >= this.campaignSetupStepsForMode().length - 1 ? 'Launch Campaign' : 'Continue';
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
                campaignSetupStepIcon(stepId = this.campaignSetup.current) {
                    const icons = {
                        start: 'add',
                        type: 'target',
                        source: 'database',
                        integration: 'extension',
                        brief: 'description',
                        general: 'settings',
                        resources: 'package_check',
                        agent: 'support_agent',
                        channels: 'forum',
                        discounts: 'percent',
                        booking: 'calendar_check',
                        availability: 'schedule',
                        sequence: 'timeline',
                        followups: 'refresh_ccw',
                        handoff: 'headphones',
                        intelligence: 'fact_check',
                        geo: 'travel_explore',
                        dispatch: 'send',
                        priority: 'trending_up',
                        review: 'verified',
                    };

                    return icons[stepId] || 'settings';
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
                        review: 'Review & Launch Your Campaign',
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
                        review: 'Before your AI agent starts working on this campaign, review the setup, run a test, and publish it. You can update the campaign again later if needed.',
                    };

                    return descriptions[stepId] || this.campaignSetupCurrentStep(stepId)?.description || '';
                },
                campaignTypeDirection(typeName) {
                    return ['Send Information', 'Provide Support'].includes(typeName) ? 'Incoming' : 'Outgoing';
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
                            this.scrollCampaignSetupToCurrent('auto');
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
                scrollCampaignSetupToCurrent(behavior = 'smooth') {
                    if (this.campaignSetupPanelIsActive()) {
                        const panel = this.$refs.campaignSetupPanel;

                        if (panel) {
                            if (behavior === 'auto') {
                                panel.scrollTop = 0;
                            } else {
                                panel.scrollTo({ top: 0, behavior });
                            }
                        }

                        this.updateCampaignSetupPanelMetrics();

                        return;
                    }

                    this.scrollBuilderStageToTop(this.campaignSetupStepRefName(), behavior);
                },
                scrollBuilderStageToTop(refName, behavior = 'smooth') {
                    if ((refName === 'campaignAgentSection' || String(refName || '').startsWith('campaignSetupStep_')) && this.campaignSetupPanelIsActive()) {
                        this.scrollCampaignSetupToCurrent(behavior);

                        return;
                    }

                    const run = () => {
                        const container = this.campaignBuilderScrollContainer();
                        const stage = this.$refs[refName];

                        if (! container || ! stage) {
                            return;
                        }

                        const containerRect = container.getBoundingClientRect();
                        const stageRect = stage.getBoundingClientRect();
                        const companyStepRefs = ['companyChooseSection', 'companyIdentitySection', 'industryMarketSection', 'complianceLegalSection'];
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
                        return `<span class="relative z-10 flex ${size} shrink-0 items-center justify-center rounded-full border-2 oc-primary-border oc-primary-bg text-white"><span class="outcraft-icon !text-[16px]">check</span></span>`;
                    }

                    if (status === 'attention') {
                        return `<span class="relative z-10 flex ${size} shrink-0 items-center justify-center rounded-full border-2 border-amber-400 bg-amber-50 text-amber-600"><span class="outcraft-icon !text-[15px]">report</span></span>`;
                    }

                    if (status === 'active') {
                        return `<span class="relative z-10 flex ${size} shrink-0 items-center justify-center rounded-full border-2 oc-primary-border bg-white"><span class="${dot} rounded-full oc-primary-bg"></span></span>`;
                    }

                    return `<span class="relative z-10 flex ${size} shrink-0 items-center justify-center rounded-full border-2 border-gray-300 bg-white"><span class="${dot} rounded-full bg-transparent group-hover:bg-gray-300"></span></span>`;
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
                        this.publishCampaignSetup();
                        return;
                    }

                    this.setCampaignSetupStep(this.campaignSetupStepsForMode()[this.campaignSetupStepIndex() + 1].id);
                },
                previousCampaignSetupStep() {
		                    if (this.campaignSetupStepIndex() <= 0) {
		                        this.campaignSetupModeSelected = false;
		                        this.campaignSetupIntroStep = 'integration';
		                        this.campaignSetupActionBarStyle = '';
		                        this.campaignSetupCanvasStyle = '';
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
		                    if (this.campaignBuilderStep >= this.companySetupStartStep() && ! this.campaignSetupModeSelected) {
		                        this.campaignSetupActionBarStyle = '';
		                        this.campaignSetupCanvasStyle = '';
		                        this.campaignSetupIntroStep = 'source';
	                        this.syncUrl();
	                    }
	                },
	                selectLeadSource(source) {
	                    this.campaignSetup.source = source;
	                    this.campaignSetup.integrationStatus = source === 'CSV File / Manual' ? 'No Integration Required' : 'Not Connected';
	                    this.completeCampaignSetupStep('source');
		                    if (this.campaignBuilderStep >= this.companySetupStartStep() && ! this.campaignSetupModeSelected) {
		                        this.campaignSetupActionBarStyle = '';
		                        this.campaignSetupCanvasStyle = '';
		                        this.campaignSetupIntroStep = 'integration';
	                        this.syncUrl();
	                    }
	                },
                leadSourceIcon(sourceName) {
                    return this.leadSourceGroups
                        .flatMap((group) => group.items)
                        .find((source) => source.name === sourceName)?.icon || 'hub';
                },
                leadSourceLogoContainerClass(sourceName) {
                    return this.leadSourceLogos[sourceName] ? 'bg-gray-100 text-gray-700' : 'bg-indigo-50 text-indigo-600';
                },
                calendarServiceLogoHtml(serviceName) {
                    if (serviceName === 'Calendly') {
                        return `<svg width="526" height="536" viewBox="0 0 526 536" fill="none" xmlns="http://www.w3.org/2000/svg"><g clip-path="url(#clip0_16133_594)"><path d="M360.4 347.4C343.4 362.49 322.19 381.27 283.62 381.27H260.62C232.74 381.27 207.39 371.15 189.25 352.78C171.53 334.84 161.77 310.28 161.77 283.62V252.11C161.77 225.45 171.53 200.89 189.25 182.95C207.39 164.58 232.74 154.46 260.62 154.46H283.62C322.19 154.46 343.38 173.24 360.4 188.33C378.05 203.98 393.3 217.49 433.92 217.49C440.116 217.491 446.303 216.996 452.42 216.01C452.42 215.89 452.34 215.78 452.29 215.66C449.854 209.617 446.997 203.753 443.74 198.11L416.58 151.06C404.334 129.852 386.723 112.241 365.515 99.9954C344.307 87.7502 320.249 81.3024 295.76 81.3H241.43C216.941 81.3024 192.883 87.7502 171.675 99.9954C150.467 112.241 132.856 129.852 120.61 151.06L93.45 198.11C81.2064 219.319 74.7607 243.376 74.7607 267.865C74.7607 292.354 81.2064 316.411 93.45 337.62L120.61 384.67C132.856 405.877 150.468 423.487 171.676 435.73C192.884 447.974 216.941 454.42 241.43 454.42H295.76C320.249 454.42 344.306 447.974 365.514 435.73C386.722 423.487 404.334 405.877 416.58 384.67L443.74 337.62C446.997 331.977 449.854 326.113 452.29 320.07C452.29 319.95 452.38 319.84 452.42 319.72C446.303 318.734 440.116 318.239 433.92 318.24C393.3 318.24 378.05 331.75 360.4 347.4Z" fill="#006BFF"/><path d="M283.62 183H260.62C218.2 183 190.32 213.3 190.32 252.09V283.6C190.32 322.39 218.2 352.69 260.62 352.69H283.62C345.44 352.69 340.62 289.69 433.92 289.69C442.765 289.683 451.593 290.49 460.29 292.1C463.12 276.071 463.12 259.669 460.29 243.64C451.594 245.259 442.766 246.069 433.92 246.06C340.59 246.05 345.44 183 283.62 183Z" fill="#006BFF"/><path d="M513.91 315.13C498.006 303.506 479.673 295.642 460.29 292.13C460.29 292.29 460.24 292.45 460.21 292.6C458.546 301.895 455.936 310.996 452.42 319.76C468.434 322.238 483.629 328.49 496.75 338C496.75 338.14 496.67 338.28 496.62 338.43C489.184 362.579 477.946 385.388 463.33 406C448.881 426.421 431.337 444.464 411.33 459.48C362.897 495.915 302.443 512.616 242.175 506.209C181.907 499.803 126.315 470.767 86.6242 424.964C46.9333 379.161 26.1006 320.003 28.3327 259.437C30.5648 198.871 55.6953 141.407 98.65 98.65C127.831 69.4906 164.052 48.3656 203.799 37.3232C243.547 26.2807 285.474 25.6955 325.514 35.6241C365.555 45.5527 402.35 65.6584 432.334 93.9918C462.318 122.325 484.473 157.925 496.65 197.34C496.7 197.49 496.74 197.63 496.78 197.77C483.65 207.281 468.444 213.53 452.42 216C455.935 224.772 458.548 233.879 460.22 243.18C460.22 243.33 460.22 243.48 460.29 243.62C479.676 240.117 498.011 232.252 513.91 220.62C529.2 209.31 526.24 196.53 523.91 188.97C490.22 79.52 388.33 0 267.86 0C119.93 0 0 119.93 0 267.86C0 415.79 119.93 535.73 267.86 535.73C388.33 535.73 490.22 456.21 523.86 346.79C526.24 339.23 529.2 326.45 513.91 315.13Z" fill="#006BFF"/><path d="M452.42 216C446.303 216.986 440.116 217.481 433.92 217.48C393.3 217.48 378.05 203.97 360.4 188.32C343.4 173.23 322.19 154.45 283.62 154.45H260.62C232.74 154.45 207.39 164.57 189.25 182.94C171.53 200.88 161.77 225.44 161.77 252.1V283.61C161.77 310.27 171.53 334.83 189.25 352.77C207.39 371.14 232.74 381.26 260.62 381.26H283.62C322.19 381.26 343.38 362.48 360.4 347.39C378.05 331.74 393.3 318.23 433.92 318.23C440.116 318.229 446.303 318.724 452.42 319.71C455.936 310.946 458.546 301.845 460.21 292.55C460.21 292.4 460.27 292.24 460.29 292.08C451.593 290.47 442.765 289.663 433.92 289.67C340.59 289.67 345.44 352.67 283.62 352.67H260.62C218.2 352.67 190.32 322.37 190.32 283.58V252.11C190.32 213.32 218.2 183.02 260.62 183.02H283.62C345.44 183.02 340.62 246.02 433.92 246.02C442.766 246.029 451.594 245.219 460.29 243.6C460.29 243.46 460.29 243.31 460.22 243.16C458.547 233.866 455.934 224.766 452.42 216Z" fill="#0AE9EF"/><path d="M452.42 216C446.303 216.986 440.116 217.481 433.92 217.48C393.3 217.48 378.05 203.97 360.4 188.32C343.4 173.23 322.19 154.45 283.62 154.45H260.62C232.74 154.45 207.39 164.57 189.25 182.94C171.53 200.88 161.77 225.44 161.77 252.1V283.61C161.77 310.27 171.53 334.83 189.25 352.77C207.39 371.14 232.74 381.26 260.62 381.26H283.62C322.19 381.26 343.38 362.48 360.4 347.39C378.05 331.74 393.3 318.23 433.92 318.23C440.116 318.229 446.303 318.724 452.42 319.71C455.936 310.946 458.546 301.845 460.21 292.55C460.21 292.4 460.27 292.24 460.29 292.08C451.593 290.47 442.765 289.663 433.92 289.67C340.59 289.67 345.44 352.67 283.62 352.67H260.62C218.2 352.67 190.32 322.37 190.32 283.58V252.11C190.32 213.32 218.2 183.02 260.62 183.02H283.62C345.44 183.02 340.62 246.02 433.92 246.02C442.766 246.029 451.594 245.219 460.29 243.6C460.29 243.46 460.29 243.31 460.22 243.16C458.547 233.866 455.934 224.766 452.42 216Z" fill="#0AE9EF"/></g><defs><clipPath id="clip0_16133_594"><rect width="525.8" height="535.73" fill="white"/></clipPath></defs></svg>`;
                    }

                    return this.leadSourceLogos[serviceName] || '';
                },
                calendarServiceLogoContainerClass(serviceName) {
                    return this.calendarServiceLogoHtml(serviceName) ? 'bg-gray-100 text-gray-700' : 'bg-indigo-50 text-indigo-600';
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
                connectCalendarService() {
                    if (! this.campaignSetup.calendarService) {
                        return;
                    }

                    this.campaignSetup.calendarConnectionStatus = 'Connected';
                    this.scheduleCampaignBuilderLayoutUpdate();
                },
                requestSkipCampaignIntegration() {
                    if (! this.requiresIntegration()) {
                        this.skipCampaignIntegration();
                        return;
                    }

                    this.campaignSetup.integrationSkipModalOpen = true;
                },
                confirmSkipCampaignIntegration() {
                    this.campaignSetup.integrationSkipModalOpen = false;
                    this.skipCampaignIntegration();
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
	                    if (this.campaignBuilderStep >= this.companySetupStartStep() && ! this.campaignSetupModeSelected) {
	                        this.campaignSetupIntroStep = 'mode';
	                        this.campaignSetupActionBarStyle = '';
	                        this.campaignSetupCanvasStyle = '';
	                        this.syncUrl();
                    }
                },
                briefBuilderItemOptions() {
                    return [
                        { type: 'find_out', group: 'Discovery & Qualification', title: 'Discovery Questions', description: 'Add questions or information the AI should collect during the conversation.', icon: 'manage_search' },
                        { type: 'qualification', group: 'Discovery & Qualification', title: 'Qualification Questions', description: 'Ask questions in the exact order AI should ask them, and define which answers qualify the lead.', icon: 'filter_alt' },
                        { type: 'guardrails', group: 'Campaign Instructions', title: 'Guardrails', description: 'Add required rules, forbidden asks, promises, topics, and mentions.', icon: 'shield' },
                        { type: 'call_guidelines', group: 'Channel Specific Guidelines', title: 'Call Specific Guidelines', description: 'Define call tone, pacing, objection handling, and call-only edge cases.', icon: 'call' },
                        { type: 'email_guidelines', group: 'Channel Specific Guidelines', title: 'Email Specific Guidelines', description: 'Define email tone, formatting, length, and compliance notes.', icon: 'mail' },
                        { type: 'sms_guidelines', group: 'Channel Specific Guidelines', title: 'SMS Specific Guidelines', description: 'Define SMS triggers, structure, length, and short-message rules.', icon: 'sms' },
                        { type: 'whatsapp_guidelines', group: 'Channel Specific Guidelines', title: 'WhatsApp Specific Guidelines', description: 'Define WhatsApp tone, length, and channel-specific follow-up notes.', icon: 'chat' },
                        { type: 'pricing', group: 'Pricing and Discount Codes', title: 'Pricing', description: 'Choose the pricing source and whether AI may negotiate within a limit.', icon: 'payments' },
                        { type: 'discount_codes', group: 'Pricing and Discount Codes', title: 'Discount Codes', description: 'Add codes the AI can send when the conversation calls for an offer.', icon: 'percent' },
                        { type: 'handoff', group: 'Conversation Controls', title: 'Hand Offs', description: 'Configure when AI should pass the conversation to a human.', icon: 'support_agent' },
                    ];
                },
                filteredBriefBuilderItemOptions() {
                    const search = String(this.campaignSetup.briefBuilderItemSearch || '').trim().toLowerCase();

                    return this.briefBuilderItemOptions().filter((option) => {
                        if (! search) {
                            return true;
                        }

                        return `${option.title} ${option.description}`.toLowerCase().includes(search);
                    });
                },
                filteredBriefBuilderItemGroups() {
                    const groups = [];

                    this.filteredBriefBuilderItemOptions().forEach((option) => {
                        const label = option.group || 'Other';
                        let group = groups.find((item) => item.label === label);

                        if (! group) {
                            group = { label, options: [] };
                            groups.push(group);
                        }

                        group.options.push(option);
                    });

	                    return groups;
	                },
		                cartLinkStructureExample() {
		                    if (this.campaignSetup.cartLinkSource === 'Dynamic (Use URL from lead data)') {
		                        return 'Example: @{{cart_url}}?utm_source=outcraft&utm_medium=email&utm_campaign=cart-recovery';
		                    }

		                    return 'Example: https://outcraft.ai/cart?utm_source=outcraft&utm_medium=email&utm_campaign=cart-recovery';
		                },
		                briefBuilderHasItem(type) {
		                    return this.campaignSetup.brief.builderItems.some((item) => item.type === type);
		                },
                openBriefBuilderItemModal() {
                    this.campaignSetup.briefBuilderItemSearch = '';
                    this.campaignSetup.briefBuilderItemModalOpen = true;
                },
                addBriefBuilderItem(type) {
                    if (this.briefBuilderHasItem(type)) {
                        return;
                    }

                    this.campaignSetup.brief.builderItems.push(this.createBriefBuilderItem(type));
                    this.closeCampaignSetupOverlays();
                    this.scheduleCampaignBuilderLayoutUpdate();
                },
                createBriefBuilderItem(type) {
                    const id = `brief-builder-${type}-${Date.now()}-${this.campaignSetup.brief.builderItems.length}`;
                    const baseItem = { id, type, questions: [], newQuestion: '', newAnswers: '' };

                    if (type === 'rules') {
                        return { ...baseItem, rules: this.campaignSetup.brief.importantRules || '' };
                    }

                    if (type === 'qualification') {
                        return baseItem;
                    }

                    if (this.briefBuilderIsGuidelineItem(type)) {
                        return { ...baseItem, content: this.briefBuilderGuidelineInitialValue(type) };
                    }

                    if (['discount_codes', 'handoff', 'followups'].includes(type)) {
                        return baseItem;
                    }

                    return baseItem;
                },
                briefBuilderItemTitle(type) {
                    return this.briefBuilderItemOptions().find((option) => option.type === type)?.title || 'Campaign Context Item';
                },
                briefBuilderItemDescription(type) {
                    return this.briefBuilderItemOptions().find((option) => option.type === type)?.description || '';
                },
                briefBuilderItemIcon(type) {
                    return this.briefBuilderItemOptions().find((option) => option.type === type)?.icon || 'description';
                },
                briefBuilderItemSvgIcon(type) {
                    if (type !== 'whatsapp_guidelines') {
                        return '';
                    }

                    return '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640" fill="currentColor" aria-hidden="true"><path d="M476.9 161.1C435 119.1 379.2 96 319.9 96C197.5 96 97.9 195.6 97.9 318C97.9 357.1 108.1 395.3 127.5 429L96 544L213.7 513.1C246.1 530.8 282.6 540.1 319.8 540.1L319.9 540.1C442.2 540.1 544 440.5 544 318.1C544 258.8 518.8 203.1 476.9 161.1zM319.9 502.7C286.7 502.7 254.2 493.8 225.9 477L219.2 473L149.4 491.3L168 423.2L163.6 416.2C145.1 386.8 135.4 352.9 135.4 318C135.4 216.3 218.2 133.5 320 133.5C369.3 133.5 415.6 152.7 450.4 187.6C485.2 222.5 506.6 268.8 506.5 318.1C506.5 419.9 421.6 502.7 319.9 502.7zM421.1 364.5C415.6 361.7 388.3 348.3 383.2 346.5C378.1 344.6 374.4 343.7 370.7 349.3C367 354.9 356.4 367.3 353.1 371.1C349.9 374.8 346.6 375.3 341.1 372.5C308.5 356.2 287.1 343.4 265.6 306.5C259.9 296.7 271.3 297.4 281.9 276.2C283.7 272.5 282.8 269.3 281.4 266.5C280 263.7 268.9 236.4 264.3 225.3C259.8 214.5 255.2 216 251.8 215.8C248.6 215.6 244.9 215.6 241.2 215.6C237.5 215.6 231.5 217 226.4 222.5C221.3 228.1 207 241.5 207 268.8C207 296.1 226.9 322.5 229.6 326.2C232.4 329.9 268.7 385.9 324.4 410C359.6 425.2 373.4 426.5 391 423.9C401.7 422.3 423.8 410.5 428.4 397.5C433 384.5 433 373.4 431.6 371.1C430.3 368.6 426.6 367.2 421.1 364.5z"/></svg>';
                },
                briefBuilderGuidelineTypes() {
                    return ['call_guidelines', 'email_guidelines', 'sms_guidelines', 'whatsapp_guidelines'];
                },
                briefBuilderIsGuidelineItem(type) {
                    return this.briefBuilderGuidelineTypes().includes(type);
                },
                briefBuilderGuidelineInitialValue(type) {
                    return {
                        call_guidelines: this.campaignSetup.callGuidelines,
                        email_guidelines: this.campaignSetup.emailGuidelines,
                        sms_guidelines: this.campaignSetup.smsGuidelines,
                        whatsapp_guidelines: this.campaignSetup.whatsappGuidelines,
                    }[type] || '';
                },
                briefBuilderGuidelinePlaceholder(type) {
                    return {
                        call_guidelines: 'Add call tone, pacing, objection handling, and compliance notes.',
                        email_guidelines: 'Add email tone, formatting, length, and compliance notes.',
                        sms_guidelines: 'Keep it short, include required links, and define SMS-only constraints.',
                        whatsapp_guidelines: 'Add WhatsApp-specific tone, length, and follow-up notes.',
                    }[type] || 'Add channel-specific instructions.';
                },
                briefBuilderGuidelineHelper(type) {
                    return {
                        call_guidelines: 'These instructions apply only when AI is speaking on calls.',
                        email_guidelines: 'These instructions apply only to email messages.',
                        sms_guidelines: 'These instructions apply only to SMS messages.',
                        whatsapp_guidelines: 'These instructions apply only to WhatsApp messages.',
                    }[type] || 'These instructions apply only to this channel.';
                },
                removeBriefBuilderItem(id) {
                    this.campaignSetup.briefBuilderItemActionOpen = '';
                    this.campaignSetup.brief.builderItems = this.campaignSetup.brief.builderItems.filter((item) => item.id !== id);
                    this.scheduleCampaignBuilderLayoutUpdate();
                },
                moveBriefBuilderItem(index, direction) {
                    this.campaignSetup.briefBuilderItemActionOpen = '';
                    const nextIndex = index + direction;
                    const items = this.campaignSetup.brief.builderItems;

                    if (nextIndex < 0 || nextIndex >= items.length) {
                        return;
                    }

                    [items[index], items[nextIndex]] = [items[nextIndex], items[index]];
                    this.scheduleCampaignBuilderLayoutUpdate();
                },
                addBriefBuilderQuestion(item) {
                    const text = String(item.newQuestion || '').trim();

                    if (! text) {
                        return;
                    }

                    item.questions.push({
                        id: `${item.id}-question-${Date.now()}-${item.questions.length}`,
                        text,
                    });
                    item.newQuestion = '';
                    this.scheduleCampaignBuilderLayoutUpdate();
                },
                reorderBriefBuilderQuestions(item, ids) {
                    const order = (ids || []).map(String).filter(Boolean);

                    if (! item?.questions || order.length === 0) {
                        return;
                    }

                    const questionsById = new Map(
                        item.questions.map((question) => [String(question.id), question])
                    );
                    const orderedQuestions = order
                        .map((id) => questionsById.get(id))
                        .filter(Boolean);
                    const orderedIds = new Set(order);
                    const remainingQuestions = item.questions
                        .filter((question) => ! orderedIds.has(String(question.id)));

                    item.questions = [
                        ...orderedQuestions,
                        ...remainingQuestions,
                    ];
                    this.scheduleCampaignBuilderLayoutUpdate();
                },
                briefBuilderQualificationAnswerLines(value) {
                    if (Array.isArray(value)) {
                        return value
                            .map((answer) => String(answer || '').replace(/^[-\u2022]\s*/, '').trim())
                            .filter(Boolean);
                    }

                    return String(value || '')
                        .split(/\r?\n/)
                        .map((answer) => answer.replace(/^[-\u2022]\s*/, '').trim())
                        .filter(Boolean);
                },
                addBriefBuilderQualificationQuestion(item) {
                    const text = String(item.newQuestion || '').trim();
                    const answers = this.briefBuilderQualificationAnswerLines(item.newAnswers);

                    if (! text || answers.length === 0) {
                        return;
                    }

                    item.questions.push({
                        id: `${item.id}-question-${Date.now()}-${item.questions.length}`,
                        text,
                        answers,
                    });
                    item.newQuestion = '';
                    item.newAnswers = '';
                    this.scheduleCampaignBuilderLayoutUpdate();
                },
                briefBuilderCapturedQuestionId(item, question) {
                    return `builder-${item.id}-${question.id}`;
                },
                briefBuilderQuestionCaptured(item, question) {
                    const id = this.briefBuilderCapturedQuestionId(item, question);

                    return this.campaignSetup.capturedConversationQuestions.some((entry) => entry.id === id);
                },
                showCaptureToast(message = 'Added to Conversation Intelligence for review.') {
                    if (this.captureToast.timer) {
                        window.clearTimeout(this.captureToast.timer);
                    }

                    this.captureToast.title = 'Question Captured';
                    this.captureToast.message = message;
                    this.captureToast.visible = true;
                    this.captureToast.timer = window.setTimeout(() => {
                        this.captureToast.visible = false;
                    }, 2600);
                },
                captureBriefBuilderQuestion(item, question, source) {
                    const id = this.briefBuilderCapturedQuestionId(item, question);

                    if (! this.campaignSetup.capturedConversationQuestions.some((entry) => entry.id === id)) {
                        this.campaignSetup.capturedConversationQuestions.push({
                            id,
                            name: question.text,
                            description: `Captured from Campaign Context ${source}.`,
                            format: 'Text Summary',
                            review: true,
                        });
                    }

                    this.showCaptureToast('Added to Conversation Intelligence for review.');
                    this.scheduleCampaignBuilderLayoutUpdate();
                },
                removeBriefBuilderQuestion(item, index) {
                    const question = item.questions[index];

                    if (question) {
                        const capturedId = this.briefBuilderCapturedQuestionId(item, question);
                        this.campaignSetup.capturedConversationQuestions = this.campaignSetup.capturedConversationQuestions
                            .filter((entry) => entry.id !== capturedId);
                    }

                    item.questions.splice(index, 1);
                    this.scheduleCampaignBuilderLayoutUpdate();
                },
                toggleChannel(channel) {
                    this.campaignSetup.channels[channel] = ! this.campaignSetup.channels[channel];

                    if (! this.campaignSetup.channels[channel]) {
                        this.campaignSetup.channelOpen[channel] = false;
                    }

                    this.scheduleCampaignBuilderLayoutUpdate();
                },
                toggleSmsTrigger(trigger) {
                    const currentTriggers = this.campaignSetup.smsTriggers || [];

                    this.campaignSetup.smsTriggers = currentTriggers.includes(trigger)
                        ? currentTriggers.filter((item) => item !== trigger)
                        : [...currentTriggers, trigger];
                },
                removeSmsTrigger(trigger) {
                    this.campaignSetup.smsTriggers = (this.campaignSetup.smsTriggers || []).filter((item) => item !== trigger);
                },
                syncFindOutQuestionsText() {
                    this.campaignSetup.brief.findOut = this.campaignSetup.brief.findOutQuestions
                        .map((question) => `- ${question.text}`)
                        .join('\n');
                },
                addFindOutQuestion() {
                    const text = String(this.campaignSetup.brief.newFindOutQuestion || '').trim();

                    if (! text) {
                        return;
                    }

                    this.campaignSetup.brief.findOutQuestions.push({
                        id: `find-out-${Date.now()}-${this.campaignSetup.brief.findOutQuestions.length}`,
                        text,
                        addToIntelligence: false,
                        answerFormat: null,
                    });
                    this.campaignSetup.brief.newFindOutQuestion = '';
                    this.syncFindOutQuestionsText();
                    this.scheduleCampaignBuilderLayoutUpdate();
                },
                removeFindOutQuestion(index) {
                    const question = this.campaignSetup.brief.findOutQuestions[index];

                    if (question && this.campaignSetup.brief.findOutAnswerFormatOpen === question.id) {
                        this.campaignSetup.brief.findOutAnswerFormatOpen = null;
                    }

                    this.campaignSetup.brief.findOutQuestions.splice(index, 1);
                    this.syncFindOutQuestionsText();
                    this.scheduleCampaignBuilderLayoutUpdate();
                },
                selectFindOutQuestionAnswerFormat(index, format) {
                    const question = this.campaignSetup.brief.findOutQuestions[index];

                    if (! question) {
                        return;
                    }

                    question.addToIntelligence = true;
                    question.answerFormat = format;
                    this.campaignSetup.brief.findOutAnswerFormatOpen = null;
                    this.scheduleCampaignBuilderLayoutUpdate();
                },
                captureFindOutQuestion(index) {
                    const question = this.campaignSetup.brief.findOutQuestions[index];

                    if (! question) {
                        return;
                    }

                    question.addToIntelligence = true;
                    question.answerFormat = question.answerFormat || 'Text Summary';
                    this.campaignSetup.brief.findOutAnswerFormatOpen = null;
                    this.showCaptureToast('Added to Conversation Intelligence for review.');
                    this.scheduleCampaignBuilderLayoutUpdate();
                },
                toggleFindOutQuestionIntelligence(index) {
                    const question = this.campaignSetup.brief.findOutQuestions[index];

                    if (! question) {
                        return;
                    }

                    question.addToIntelligence = ! question.addToIntelligence;
                },
                reorderFindOutQuestionsByIds(ids) {
                    const order = (ids || []).map(String).filter(Boolean);

                    if (order.length === 0) {
                        return;
                    }

                    const questionsById = new Map(
                        this.campaignSetup.brief.findOutQuestions.map((question) => [String(question.id), question])
                    );
                    const orderedQuestions = order
                        .map((id) => questionsById.get(id))
                        .filter(Boolean);
                    const orderedIds = new Set(order);
                    const remainingQuestions = this.campaignSetup.brief.findOutQuestions
                        .filter((question) => ! orderedIds.has(String(question.id)));

                    this.campaignSetup.brief.findOutQuestions = [
                        ...orderedQuestions,
                        ...remainingQuestions,
                    ];
                    this.syncFindOutQuestionsText();
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
                campaignSetupLanguageDisplay(language) {
                    const name = String(language?.name || '').trim();
                    const label = String(language?.label || language?.code || '').trim();

                    if (name && label) {
                        return `${name} (${label})`;
                    }

                    return name || label || 'Language';
                },
                campaignSetupAgentTitle(language) {
                    const name = String(language?.name || '').trim();

                    return `${name || 'Language'} Agent`;
                },
                campaignSetupFlagUrl(language) {
                    const code = String(language?.flagCode || language?.code || '').toLowerCase();

                    return this.flagUrl(code);
                },
                countryFlagUrl(country) {
                    const code = typeof country === 'object'
                        ? (country?.flagCode || country?.code || '')
                        : country;

                    return this.flagUrl(code || 'US');
                },
                flagUrl(code) {
                    const normalized = String(code || '').toLowerCase();

                    return normalized ? `https://hatscripts.github.io/circle-flags/flags/${normalized}.svg` : '';
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
	                        'Yes Or No': 'Return a simple yes or no based on detected conversation signals.',
	                        'Text Summary': 'Extract important details and return them as structured short text.',
	                        Classified: 'Define your own labels and let AI assign the best matching outcome.',
	                        Score: 'Evaluate interaction quality using a numeric score.',
	                        'Score Answers': 'Evaluate answers using a numeric score.',
	                    }[format] || '';
	                },
	                conversationIntelligenceEvaluations() {
	                    return [
	                        ...(this.campaignSetup.defaultSummaryEvaluationVisible ? [{
	                            id: 'default-summary',
	                            name: 'Summary Of The Interaction',
	                            description: 'Summarize the interaction in 1-2 short sentences.',
	                            format: 'Text Summary',
	                        }] : []),
	                        ...this.campaignSetup.brief.findOutQuestions
	                            .filter((question) => question.addToIntelligence && question.answerFormat)
	                            .map((question) => ({
	                                id: `find-out-${question.id}`,
	                                name: question.text,
	                                description: 'Collected from Campaign Context question.',
	                                format: question.answerFormat,
	                                review: true,
	                            })),
	                        ...this.campaignSetup.capturedConversationQuestions.map((question) => ({
	                            id: `captured-${question.id}`,
	                            name: question.name,
	                            description: question.description,
	                            format: question.format,
	                            review: true,
	                        })),
	                    ];
	                },
	                editConversationEvaluation(evaluation) {
	                    this.campaignSetup.evaluationActionOpen = '';
	                    this.campaignSetup.evaluationDrawerOpen = true;
	                },
	                removeConversationEvaluation(evaluation) {
	                    this.campaignSetup.evaluationActionOpen = '';

	                    if (evaluation.id === 'default-summary') {
	                        this.campaignSetup.defaultSummaryEvaluationVisible = false;
	                        this.scheduleCampaignBuilderLayoutUpdate();
	                        return;
	                    }

	                    if (String(evaluation.id || '').startsWith('find-out-')) {
	                        const questionId = String(evaluation.id).replace('find-out-', '');
	                        const question = this.campaignSetup.brief.findOutQuestions.find((item) => String(item.id) === questionId);

	                        if (question) {
	                            question.addToIntelligence = false;
	                            question.answerFormat = null;
	                        }
	                    }

	                    if (String(evaluation.id || '').startsWith('captured-')) {
	                        const questionId = String(evaluation.id).replace('captured-', '');
	                        this.campaignSetup.capturedConversationQuestions = this.campaignSetup.capturedConversationQuestions
	                            .filter((question) => question.id !== questionId);
	                    }

	                    this.scheduleCampaignBuilderLayoutUpdate();
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
                    this.campaignSetup.sequenceActionOpen = '';
                    this.campaignSetup.sequenceEditingIndex = null;
                    this.campaignSetup.followupModalOpen = false;
                    this.campaignSetup.discountCodeModalOpen = false;
	                    this.campaignSetup.integrationSkipModalOpen = false;
	                    this.campaignSetup.briefBuilderItemModalOpen = false;
	                    this.campaignSetup.briefBuilderItemActionOpen = '';
	                    this.campaignSetup.overrideModalOpen = false;
	                    this.campaignSetup.evaluationDrawerOpen = false;
	                    this.campaignSetup.evaluationActionOpen = '';
	                    this.campaignSetup.dispatchDrawerOpen = false;
	                    this.campaignSetup.newDiscountCode = '';
	                    this.campaignSetup.briefBuilderItemSearch = '';
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
                sequenceChannelIcon(channel) {
                    return {
                        Call: 'call',
                        SMS: 'sms',
                        Email: 'mail',
                        WhatsApp: 'chat',
                        None: 'flag',
                        'Close Campaign Run': 'flag',
                    }[channel] || 'timeline';
                },
                sequenceChannelIconTileClass(channel) {
                    return {
                        Call: 'bg-teal-50 text-teal-600',
                        SMS: 'bg-amber-50 text-amber-600',
                        Email: 'bg-cyan-50 text-cyan-600',
                        WhatsApp: 'bg-lime-50 text-lime-600',
                        None: 'bg-gray-50 text-gray-500',
                        'Close Campaign Run': 'bg-gray-50 text-gray-500',
                    }[channel] || 'bg-indigo-50 text-indigo-600';
                },
                sequenceChannelLabel(channel) {
                    return channel === 'None' ? 'Close Campaign Run' : channel;
                },
                sequenceDelayLabel(delay) {
                    return delay === '-' ? 'Immediately' : `After ${delay}`;
                },
                moveSequenceRow(index, direction) {
                    const nextIndex = index + direction;

                    if (nextIndex < 0 || nextIndex >= this.sequenceRows.length) {
                        return;
                    }

                    [this.sequenceRows[index], this.sequenceRows[nextIndex]] = [this.sequenceRows[nextIndex], this.sequenceRows[index]];
                    this.campaignSetup.sequenceActionOpen = '';
                    this.scheduleCampaignBuilderLayoutUpdate();
                },
                editSequenceRow(index) {
                    this.campaignSetup.sequenceEditingIndex = index;
                    this.campaignSetup.sequenceActionOpen = '';
                    this.campaignSetup.sequenceModalOpen = true;
                },
                deleteSequenceRow(index) {
                    this.sequenceRows.splice(index, 1);
                    this.campaignSetup.sequenceActionOpen = '';
                    this.scheduleCampaignBuilderLayoutUpdate();
                },
                followupSequenceTabs() {
                    return [
                        { id: 'positive', label: 'Positive', enabled: this.campaignSetup.followupPositive },
                        { id: 'engaged', label: 'Engaged but Undecided', enabled: this.campaignSetup.followupEngaged },
                        { id: 'negative', label: 'Negative Response', enabled: this.campaignSetup.followupNegative },
                    ].filter((tab) => tab.enabled);
                },
                ensureActiveFollowupSequence(preferredId = null) {
                    const tabs = this.followupSequenceTabs();
                    const preferredTab = preferredId ? tabs.find((tab) => tab.id === preferredId) : null;

                    if (preferredTab) {
                        this.campaignSetup.activeFollowupSequence = preferredTab.id;
                        return;
                    }

                    if (! tabs.some((tab) => tab.id === this.campaignSetup.activeFollowupSequence)) {
                        this.campaignSetup.activeFollowupSequence = tabs[0]?.id || 'positive';
                    }
                },
                toggleFollowupSequence(field, tabId) {
                    this.campaignSetup[field] = ! this.campaignSetup[field];
                    this.ensureActiveFollowupSequence(this.campaignSetup[field] ? tabId : null);
                    this.scheduleCampaignBuilderLayoutUpdate();
                },
                launchBlocked() {
                    return (this.requiresIntegration() && this.campaignSetup.integrationStatus !== 'Connected')
                        || ! this.campaignSetup.source
                        || this.enabledCampaignChannels().length === 0;
                },
                publishCampaignSetup() {
                    if (this.launchBlocked()) {
                        return;
                    }

                    this.campaignSetup.knowledgePublished = true;
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
                campaignScheduleDescription() {
                    return {
                        business: 'Mon–Fri, 9:00–18:00 in contact’s local timezone',
                        extended: 'Mon–Sat, 9:00–20:00 in contact’s local timezone',
                        'all-day': '24/7. Best for inbound, email, or chat.',
                        custom: 'Set days, hours, timezone, and quiet hours.',
                    }[this.campaignSetup.scheduleMode] || 'Mon–Fri, 9:00–18:00 in contact’s local timezone';
                },
                campaignScheduleSummary() {
                    if (this.campaignSetupMode === 'fast') {
                        return 'Local Business Hours';
                    }

                    if (this.campaignSetup.scheduleMode === 'custom') {
                        return `Custom Schedule: ${this.campaignSetup.outreachDays.join(', ')}, ${this.campaignSetup.outreachStartHour} to ${this.campaignSetup.outreachEndHour}`;
                    }

                    return {
                        business: 'Local Business Hours',
                        extended: 'Local Extended Hours',
                        'all-day': 'Always On',
                    }[this.campaignSetup.scheduleMode] || 'Local Business Hours';
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
                        { label: 'Agent Availability', summary: this.campaignScheduleSummary(), status: 'Done' },
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
                leadId(row) {
                    return Number(row?.id || 0);
                },
                visibleLeadIds() {
                    return this.paginatedRows()
                        .map((row) => this.leadId(row))
                        .filter(Boolean);
                },
                selectedLeadRows() {
                    const selectedIds = new Set(this.selectedLeadIds.map(Number));

                    return this.rows.filter((row) => selectedIds.has(this.leadId(row)));
                },
                selectedLeadCampaignNames() {
                    return [...new Set(this.selectedLeadRows().map((row) => row.campaignName).filter(Boolean))];
                },
                campaignAssignmentOptions() {
                    return [...this.pinnedCampaigns, ...this.abTestCampaigns, ...this.archivedCampaigns];
                },
                isLeadSelected(row) {
                    return this.selectedLeadIds.includes(this.leadId(row));
                },
                allVisibleLeadsSelected() {
                    const ids = this.visibleLeadIds();

                    return ids.length > 0 && ids.every((id) => this.selectedLeadIds.includes(id));
                },
                someVisibleLeadsSelected() {
                    const ids = this.visibleLeadIds();
                    const selectedCount = ids.filter((id) => this.selectedLeadIds.includes(id)).length;

                    return selectedCount > 0 && selectedCount < ids.length;
                },
                toggleLeadSelection(row) {
                    const id = this.leadId(row);

                    if (!id) {
                        return;
                    }

                    if (this.selectedLeadIds.includes(id)) {
                        this.selectedLeadIds = this.selectedLeadIds.filter((selectedId) => selectedId !== id);
                    } else {
                        this.selectedLeadIds = [...this.selectedLeadIds, id];
                    }

                    if (this.selectedLeadIds.length === 0) {
                        this.closeLeadAssignModal();
                    }
                },
                toggleVisibleLeadSelection() {
                    const visibleIds = this.visibleLeadIds();

                    if (visibleIds.length === 0) {
                        return;
                    }

                    if (this.allVisibleLeadsSelected()) {
                        this.selectedLeadIds = this.selectedLeadIds.filter((id) => !visibleIds.includes(id));
                    } else {
                        this.selectedLeadIds = [...new Set([...this.selectedLeadIds, ...visibleIds])];
                    }

                    if (this.selectedLeadIds.length === 0) {
                        this.closeLeadAssignModal();
                    }
                },
                clearLeadSelection() {
                    this.selectedLeadIds = [];
                    this.closeLeadAssignModal();
                },
                deleteSelectedLeadsByIds(ids) {
                    const selectedIds = new Set((ids || []).map(Number));

                    if (selectedIds.size === 0) {
                        return;
                    }

                    this.rows = this.rows.filter((row) => !selectedIds.has(this.leadId(row)));
                    this.clearLeadSelection();
                    this.page = Math.min(this.page, this.totalPages());
                },
                openLeadAssignModal() {
                    if (this.selectedLeadIds.length === 0) {
                        return;
                    }

                    this.leadAssignCampaignName = this.selectedLeadCampaignNames()[0] || this.campaignAssignmentOptions()[0]?.name || '';
                    this.leadAssignModalOpen = true;
                },
                closeLeadAssignModal() {
                    this.leadAssignModalOpen = false;
                    this.leadAssignCampaignName = '';
                },
                assignSelectedLeadsToCampaign(campaignName = this.leadAssignCampaignName) {
                    if (this.selectedLeadIds.length === 0 || !campaignName) {
                        return;
                    }

                    const selectedIds = new Set(this.selectedLeadIds.map(Number));

                    this.rows.forEach((row) => {
                        if (selectedIds.has(this.leadId(row))) {
                            row.campaignName = campaignName;
                        }
                    });

                    this.clearLeadSelection();
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
                    const arrowLeft = Math.max(
                        16,
                        Math.min(tooltipWidth - 16, centeredLeft - (left - (tooltipWidth / 2))),
                    );

                    this.floatingTooltip = {
                        visible: true,
                        text: value,
                        left,
                        top: Math.max(margin + 40, rect.top - 10),
                        width: tooltipWidth,
                        arrowLeft,
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

                    return `${country.name} (${country.code})`;
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
                    this.selectedLead.countryFlagCode = this.leadCountryOption(this.selectedLead.country).flagCode;
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
                    this.clearLeadSelection();

                    if (!this.filters.includes(value)) {
                        this.filters.push(value);
                    }

                    this.page = 1;
                    this.query = '';
                    this.searchOpen = false;
                },
                removeFilter(value) {
                    this.showLoader(3000);
                    this.clearLeadSelection();
                    this.filters = this.filters.filter((filter) => filter !== value);
                    this.selectedPresetName = 'Filter Presets';
                    this.page = 1;
                },
                applyPreset(preset) {
                    this.showLoader(3000);
                    this.clearLeadSelection();
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
                    this.clearLeadSelection();
                    this.filters = [];
                    this.selectedPresetName = 'Filter Presets';
                    this.searchOpen = false;
                    this.presetOpen = false;
                    this.page = 1;
                },
                clearSearchTags() {
                    this.showLoader(3000);
                    this.clearLeadSelection();
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
