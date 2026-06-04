<?php

namespace App\Filament\Pages;

use BackedEnum;
use CodeWithKyrian\FilamentDateRange\Forms\Components\DateRangePicker;
use Filament\Actions\Action;
use Filament\Pages\Page;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\HtmlString;

class OutcraftWorkspacePage extends Page
{
    protected static string | BackedEnum | null $navigationIcon = 'heroicon-o-phone';

    protected static ?string $navigationLabel = 'Outreach';

    protected static ?string $title = 'Outreach';

    protected static ?string $slug = 'outreach';

    protected string $view = 'filament.pages.outcraft-workspace';

    public array $analyticsDateRange = [
        'start' => '2026-05-01',
        'end' => '2026-05-28',
    ];

    public array $leadsDateRange = [
        'start' => '2026-05-01',
        'end' => '2026-05-28',
    ];

    public function pageContent(): HtmlString
    {
        return new HtmlString(view('filament.pages.outreach.content', [
            'rows' => $this->rows(),
            'analyticsDateRangePicker' => $this->getSchema('analyticsDateRangeForm'),
            'leadsDateRangePicker' => $this->getSchema('leadsDateRangeForm'),
        ])->render());
    }

    public function analyticsDateRangeForm(Schema $schema): Schema
    {
        return $schema
            ->components([
                $this->dateRangePicker('analyticsDateRange'),
            ]);
    }

    public function leadsDateRangeForm(Schema $schema): Schema
    {
        return $schema
            ->components([
                $this->dateRangePicker('leadsDateRange'),
            ]);
    }

    private function dateRangePicker(string $statePath): DateRangePicker
    {
        return DateRangePicker::make($statePath)
            ->hiddenLabel()
            ->singleField()
            ->displayFormat('M j, Y')
            ->format('Y-m-d')
            ->startPlaceholder('Select Date Range')
            ->endPlaceholder('End date')
            ->startPrefixIcon('heroicon-o-calendar')
            ->startPrefixIconColor('gray')
            ->weekStartsOnMonday()
            ->autoApply()
            ->extraAttributes(['data-outcraft-date-range-picker' => 'true'])
            ->live();
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
        $campaignNames = [
            'Book Appointment',
            'Qualify Lead',
            'Recover Abandoned Checkout',
            'Client Reactivation',
            'Upsell Post-Purchase',
            'Post-Delivery Follow-Up',
            'Inbound Refund Request',
            'Send Information',
            'Provide Support',
        ];
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

}
