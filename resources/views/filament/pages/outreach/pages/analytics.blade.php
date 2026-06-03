        <section x-cloak x-show="activeNav === 'Analytics'" x-on:wheel="handleTopNavWheel($event)" data-outcraft-tab-header class="sticky top-0 z-30 bg-white transition-transform duration-200 ease-out will-change-transform" :class="topNavHeaderClass()">
            <div :class="topNavTabShellClass()">
                <div class="mx-3 flex flex-col gap-3 sm:mx-6 xl:flex-row xl:items-center xl:justify-between">
                    <div class="outcraft-tab-header-row flex min-w-0 flex-1 items-stretch">
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
                            <nav aria-label="Analytics tabs" :class="topNavTabListClass()">
                                <template x-for="(tab, tabIndex) in insightsTabs" :key="tab.label">
                                    <button
                                        type="button"
                                        x-on:click="setInsightsTab(tab.label)"
                                        :class="topNavTabButtonClass(activeInsightsTab === tab.label, tabIndex, insightsTabs.length)"
                                    >
                                        <span x-show="topNavTabIconsEnabled" class="outcraft-icon !text-[20px]" :class="topNavTabIconClass(activeInsightsTab === tab.label)" x-text="tab.icon"></span>
                                        <span x-text="tab.label"></span>
                                    </button>
                                </template>
                            </nav>
                        </div>
                    </div>
                    <div
                        x-cloak
                        x-show="analyticsStickyControlsVisible"
                        x-transition
                        class="flex w-full flex-col gap-3 pb-3 sm:flex-row xl:w-auto xl:items-center xl:justify-end xl:pb-0"
                        :class="['pills', 'pills-gray', 'bar'].includes(topNavTabStyle) ? 'xl:py-0' : 'xl:py-2'"
                    >
                        <x-outcraft.select
                            class="w-full sm:flex-1 xl:w-44 xl:flex-none"
                            model="activeAnalyticsRange"
                            options="analyticsRanges()"
                            on-change="setAnalyticsRange(activeAnalyticsRange)"
                            button-class="h-10 font-semibold"
                            menu-class="right-0 w-full sm:w-56"
                        />
                        <div
                            x-cloak
                            x-show="activeAnalyticsRange === 'Custom range'"
                            x-transition
                            x-data="{ range: $wire.entangle('analyticsDateRange').live }"
                            x-effect="
                                analyticsCustomRangeStart = range?.start || analyticsCustomRangeStart;
                                analyticsCustomRangeEnd = range?.end || analyticsCustomRangeEnd;
                            "
                            data-outcraft-date-range-picker="true"
                            class="w-full sm:flex-1 xl:w-[18rem] xl:flex-none"
                        >
                            {!! $analyticsDateRangePicker->toHtml() !!}
                        </div>
                        <button type="button" class="hidden h-10 w-full items-center justify-center gap-2 rounded-lg border border-gray-200 bg-white px-4 text-sm font-semibold text-gray-800 shadow-sm transition hover:bg-gray-50 hover:text-gray-950 lg:inline-flex xl:w-auto">
                            <span class="outcraft-icon !text-[18px] text-gray-500">download</span>
                            Export
                        </button>
                    </div>
                </div>
            </div>
        </section>

        <section x-cloak x-show="activeNav === 'Analytics'" data-analytics-page class="mx-3 mb-6 mt-5 sm:mx-6">
            <div class="mb-4 flex min-h-[54px] items-start justify-between gap-4">
                <div class="min-w-0">
                    <h1 class="text-xl font-bold leading-tight text-gray-950" x-text="activeInsightsTab"></h1>
                    <p class="mt-1 text-sm text-gray-500" x-text="insightsSubtitle()"></p>
                </div>
                <div class="relative lg:hidden" x-on:click.outside="analyticsHeadingMenuOpen = false">
                    <button
                        type="button"
                        x-on:click.stop="analyticsHeadingMenuOpen = ! analyticsHeadingMenuOpen"
                        class="inline-flex size-10 items-center justify-center rounded-lg border border-gray-200 bg-white text-gray-500 shadow-sm transition hover:bg-gray-50 hover:text-gray-800"
                        aria-label="Analytics actions"
                        :aria-expanded="analyticsHeadingMenuOpen.toString()"
                    >
                        <span class="outcraft-icon !text-[21px]">more_vert</span>
                    </button>
                    <div
                        x-cloak
                        x-show="analyticsHeadingMenuOpen"
                        x-on:click.stop
                        x-transition:enter="transition ease-out duration-100"
                        x-transition:enter-start="opacity-0 translate-y-1"
                        x-transition:enter-end="opacity-100 translate-y-0"
                        x-transition:leave="transition ease-in duration-75"
                        x-transition:leave-start="opacity-100 translate-y-0"
                        x-transition:leave-end="opacity-0 translate-y-1"
                        data-dropdown-surface
                        data-panel-surface
                        class="absolute right-0 z-40 mt-2 w-44 rounded-md bg-white py-1 shadow-lg ring-1 ring-gray-900/10"
                    >
                        <button type="button" x-on:click="analyticsHeadingMenuOpen = false" class="flex w-full items-center gap-2 px-3 py-2 text-left text-sm font-semibold text-gray-700 transition hover:bg-gray-50 hover:text-gray-950">
                            <span class="outcraft-icon !text-[18px] text-gray-500">download</span>
                            <span>Export</span>
                        </button>
                    </div>
                </div>
            </div>

            <div class="mb-5 flex flex-col gap-3 lg:flex-row lg:items-center lg:justify-between">
                <div class="w-full lg:w-64">
                    <x-outcraft.select
                        class="w-full"
                        model="activeAnalyticsCampaign"
                        options="analyticsCampaignOptions()"
                        on-change="setAnalyticsCampaign(activeAnalyticsCampaign)"
                        button-class="h-10 font-semibold"
                        menu-class="left-0 w-full lg:w-72"
                    />
                </div>
                <div x-ref="analyticsInlineControls" class="flex w-full flex-col gap-3 sm:flex-row lg:w-auto lg:items-center lg:justify-end">
                    <x-outcraft.select
                        class="w-full sm:flex-1 lg:w-44 lg:flex-none"
                        model="activeAnalyticsRange"
                        options="analyticsRanges()"
                        on-change="setAnalyticsRange(activeAnalyticsRange)"
                        button-class="h-10 font-semibold"
                        menu-class="right-0 w-full sm:w-56"
                    />
                    <div
                        x-cloak
                        x-show="activeAnalyticsRange === 'Custom range'"
                        x-transition
                        x-data="{ range: $wire.entangle('analyticsDateRange').live }"
                        x-effect="
                            analyticsCustomRangeStart = range?.start || analyticsCustomRangeStart;
                            analyticsCustomRangeEnd = range?.end || analyticsCustomRangeEnd;
                        "
                        data-outcraft-date-range-picker="true"
                        class="w-full sm:flex-1 lg:w-[18rem] lg:flex-none"
                    >
                        {!! $analyticsDateRangePicker->toHtml() !!}
                    </div>
                    <button type="button" class="hidden h-10 w-full items-center justify-center gap-2 rounded-lg border border-gray-200 bg-white px-4 text-sm font-semibold text-gray-800 shadow-sm transition hover:bg-gray-50 hover:text-gray-950 lg:inline-flex">
                        <span class="outcraft-icon !text-[18px] text-gray-500">download</span>
                        Export
                    </button>
                </div>
            </div>

            <div x-show="! ['Overview', 'Engagement', 'Conversation Intelligence'].includes(activeInsightsTab)">
                <div class="grid grid-cols-4 gap-5">
                    <template x-for="metric in insightsMetrics()" :key="metric.label">
                        <div class="rounded-lg bg-white p-5 shadow-sm ring-1 ring-gray-900/5">
                            <div class="flex items-start justify-between gap-3">
                                <div>
                                    <p class="text-sm font-medium text-gray-500" x-text="metric.label"></p>
                                    <div class="mt-3 flex items-baseline gap-2">
                                        <p class="text-2xl font-bold leading-none text-gray-950" x-text="metric.value"></p>
                                        <span x-show="metric.engagementRate" class="text-xs font-medium text-gray-500" x-text="metric.engagementRate"></span>
                                    </div>
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

            <div x-show="activeInsightsTab === 'Conversation Intelligence'" class="space-y-5">
                <div x-show="activeAnalyticsCampaign === 'All Campaigns'" class="rounded-lg bg-white p-6 shadow-sm ring-1 ring-gray-900/5">
                    <div class="flex flex-col gap-4 sm:flex-row sm:items-start">
                        <span class="flex size-10 shrink-0 items-center justify-center rounded-md bg-indigo-50 text-indigo-600">
                            <span class="outcraft-icon !text-[20px]">psychology</span>
                        </span>
                        <div class="min-w-0">
                            <h2 class="text-lg font-bold text-gray-950">Select a campaign to view custom metrics</h2>
                            <p class="mt-1 max-w-2xl text-sm leading-6 text-gray-500">
                                Conversation Intelligence metrics are configured per campaign, so they appear after you choose a specific campaign instead of All Campaigns.
                            </p>
                        </div>
                    </div>
                </div>

                <div x-show="activeAnalyticsCampaign !== 'All Campaigns'" class="grid grid-cols-1 gap-5 lg:grid-cols-3">
                    <template x-for="summary in conversationMetricSummaryCards()" :key="summary.label">
                        <div class="rounded-lg bg-white p-5 shadow-sm ring-1 ring-gray-900/5">
                            <div class="flex items-start justify-between gap-4">
                                <div>
                                    <p class="text-sm font-medium text-gray-500" x-text="summary.label"></p>
                                    <p class="mt-2 text-3xl font-bold leading-none text-gray-950" x-text="summary.value"></p>
                                    <p class="mt-3 text-sm leading-6 text-gray-500" x-text="summary.description"></p>
                                </div>
                                <span class="flex size-10 shrink-0 items-center justify-center rounded-md bg-indigo-50 text-indigo-600">
                                    <span class="outcraft-icon !text-[20px]" x-text="summary.icon"></span>
                                </span>
                            </div>
                        </div>
                    </template>
                </div>

                <div x-show="activeAnalyticsCampaign !== 'All Campaigns'" class="grid grid-cols-1 gap-5">
                    <template x-for="metric in conversationCustomMetrics()" :key="metric.title">
                        <div class="rounded-lg bg-white p-5 shadow-sm ring-1 ring-gray-900/5">
                            <div class="flex items-start justify-between gap-4">
                                <div class="min-w-0">
                                    <div class="flex flex-wrap items-center gap-2">
                                        <h2 class="min-w-0 text-base font-bold leading-6 text-gray-950" x-text="metric.title"></h2>
                                        <span class="inline-flex h-6 items-center rounded-full px-2 text-xs font-semibold ring-1 ring-inset" :class="conversationMetricTypeClass(metric.type)" x-text="metric.type"></span>
                                    </div>
                                    <p class="mt-1 text-sm text-gray-500" x-text="metric.sampleLabel"></p>
                                </div>
                                <button
                                    type="button"
                                    x-data="{ hovering: false }"
                                    x-on:mouseenter="hovering = true"
                                    x-on:mouseleave="hovering = false"
                                    x-on:click="toggleConversationMetricHighlight(metric.title)"
                                    class="group inline-flex size-9 shrink-0 items-center justify-center rounded-md text-gray-400 transition hover:bg-gray-50 hover:text-gray-700"
                                    :class="isConversationMetricHighlighted(metric.title) ? 'bg-indigo-50 text-indigo-600 hover:bg-indigo-50 hover:text-indigo-700' : ''"
                                    :aria-label="isConversationMetricHighlighted(metric.title) ? `Unpin ${metric.title}` : `Pin ${metric.title}`"
                                >
                                    <span class="outcraft-icon !text-[20px]" x-text="isConversationMetricHighlighted(metric.title) && hovering ? 'keep_off' : 'keep'"></span>
                                </button>
                            </div>

                            <template x-if="metric.type === 'Score'">
                                <div class="mt-5 rounded-lg bg-gray-950 p-5 text-white">
                                    <div class="flex items-end justify-between gap-4">
                                        <div>
                                            <p class="text-sm font-medium text-gray-300" x-text="metric.scaleLabel"></p>
                                            <p class="mt-2 text-4xl font-bold leading-none" x-text="metric.primaryValue"></p>
                                        </div>
                                    </div>
                                    <div class="mt-5 h-2 rounded-full bg-white/15">
                                        <div class="h-2 rounded-full bg-indigo-400" :style="`width: ${metric.scoreProgress}%`"></div>
                                    </div>
                                </div>
                            </template>

                            <template x-if="metric.type === 'Yes / No'">
                                <div class="mt-5 space-y-4">
                                    <div class="overflow-hidden rounded-full bg-gray-100">
                                        <div class="h-3 rounded-full bg-indigo-600" :style="`width: ${metric.trueRate}%`"></div>
                                    </div>
                                    <div class="grid grid-cols-2 gap-3 text-sm">
                                        <div class="rounded-lg bg-indigo-50 p-3 text-indigo-700">
                                            <p class="font-semibold">Yes</p>
                                            <p class="mt-1 text-2xl font-bold leading-none" x-text="`${metric.trueRate}%`"></p>
                                            <p class="mt-2 text-xs" x-text="metric.trueLabel"></p>
                                        </div>
                                        <div class="rounded-lg bg-gray-50 p-3 text-gray-700">
                                            <p class="font-semibold">No</p>
                                            <p class="mt-1 text-2xl font-bold leading-none" x-text="`${metric.falseRate}%`"></p>
                                            <p class="mt-2 text-xs" x-text="metric.falseLabel"></p>
                                        </div>
                                    </div>
                                </div>
                            </template>

                            <template x-if="metric.type === 'Classified'">
                                <div class="mt-5 space-y-3">
                                    <template x-for="option in metric.options" :key="option.label">
                                        <div>
                                            <div class="flex items-center justify-between gap-3 text-sm">
                                                <span class="min-w-0 truncate font-semibold text-gray-800" x-text="option.label"></span>
                                                <span class="shrink-0 text-gray-500" x-text="`${option.value}%`"></span>
                                            </div>
                                            <div class="mt-1.5 h-2 rounded-full bg-gray-100">
                                                <div class="h-2 rounded-full" :class="option.color || 'bg-gray-900'" :style="`width: ${option.value}%`"></div>
                                            </div>
                                        </div>
                                    </template>
                                </div>
                            </template>
                        </div>
                    </template>
                </div>
            </div>

            <div x-show="activeInsightsTab === 'Engagement'" class="space-y-5">
                <div class="grid grid-cols-1 gap-5 lg:grid-cols-2">
                    <template x-for="metric in engagementOverviewMetrics()" :key="metric.label">
                        <div class="rounded-lg bg-white p-6 shadow-sm ring-1 ring-gray-900/5">
                            <div class="grid grid-cols-1 gap-5 md:grid-cols-[minmax(0,1fr)_minmax(180px,240px)] md:items-end">
                                <div>
                                    <span class="mb-4 flex size-10 shrink-0 items-center justify-center rounded-md bg-indigo-50 text-indigo-600">
                                        <span class="outcraft-icon !text-[21px]" x-text="metric.icon"></span>
                                    </span>
                                    <p class="text-sm font-medium text-gray-500" x-text="metric.label"></p>
                                    <p class="mt-2 text-4xl font-bold leading-none text-gray-950" x-text="metric.value"></p>
                                    <div x-show="metric.shouldShowTrend" class="mt-3 flex items-center gap-2 text-sm">
                                        <span class="inline-flex items-center gap-1 font-semibold" :class="metric.trendDirection === 'up' ? 'text-emerald-600' : 'text-rose-600'">
                                            <span class="outcraft-icon !text-[18px]" x-text="metric.trendDirection === 'up' ? 'arrow_outward' : 'south_east'"></span>
                                            <span x-text="metric.trend"></span>
                                        </span>
                                        <span class="text-gray-500" x-text="metric.comparisonLabel"></span>
                                    </div>
                                    <p class="mt-3 text-sm leading-6 text-gray-500" x-text="metric.subtext"></p>
                                </div>
                                <div class="min-w-0 space-y-3">
                                    <template x-for="bar in metric.bars" :key="bar.label">
                                        <div>
                                            <div class="flex items-center justify-between gap-3 text-xs">
                                                <span class="font-semibold text-gray-800" x-text="bar.label"></span>
                                                <span class="text-gray-500" x-text="`${bar.value} leads`"></span>
                                            </div>
                                            <div class="mt-1.5 h-2 rounded-full bg-gray-100">
                                                <div class="h-2 rounded-full" :class="bar.color" :style="`width: ${bar.progress}%`"></div>
                                            </div>
                                        </div>
                                    </template>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>

                <div x-cloak x-show="false" class="rounded-lg bg-white p-6 shadow-sm ring-1 ring-gray-900/5">
                    <div class="flex flex-col gap-4 lg:flex-row lg:items-start lg:justify-between">
                        <div class="min-w-0">
                            <h2 class="text-lg font-bold text-gray-950">Reply Schedule</h2>
                            <p class="mt-1 max-w-3xl text-sm leading-6 text-gray-500">A 24-hour spline view of when leads reply in each region, with spikes and quiet windows called out.</p>
                        </div>
                        <div class="flex flex-wrap gap-2">
                            <template x-for="region in replyTimingRegionOptions()" :key="region.key">
                                <button
                                    type="button"
                                    x-on:click="setReplyTimingRegion(region.key)"
                                    class="inline-flex items-center gap-1.5 rounded-md border px-2.5 py-1.5 text-xs font-semibold transition"
                                    :class="activeReplyTimingRegion === region.key ? 'border-indigo-200 bg-indigo-50 text-indigo-700' : 'border-gray-200 bg-white text-gray-600 hover:border-gray-300 hover:text-gray-950'"
                                >
                                    <span class="size-2 rounded-full" :style="`background: ${region.color}`"></span>
                                    <span x-text="region.label"></span>
                                </button>
                            </template>
                        </div>
                    </div>

                    <div class="mt-5 grid grid-cols-1 gap-5 xl:grid-cols-[minmax(0,2fr)_minmax(340px,1fr)]">
                        <div class="min-w-0 rounded-lg border border-gray-200 bg-gray-50 p-4">
                            <div class="flex items-center justify-between gap-3">
                                <div>
                                    <p class="text-sm font-semibold text-gray-950" x-text="`${replyTimingActiveRegion().label} replies by local lead time`"></p>
                                    <p class="mt-1 text-xs text-gray-500">Area shows reply rate; dotted line shows positive reply rate.</p>
                                </div>
                                <span class="inline-flex items-center gap-1.5 rounded-md bg-emerald-50 px-2.5 py-1.5 text-xs font-semibold text-emerald-700">
                                    <span class="outcraft-icon !text-[15px]">trending_up</span>
                                    <span x-text="replyTimingBestWindow().range"></span>
                                </span>
                            </div>
                            <div
                                x-effect="activeInsightsTab; activeAnalyticsRange; activeReplyTimingRegion; activeInsightsTab === 'Engagement' && $nextTick(() => scheduleEngagementApexChartRender('replyTiming'))"
                                class="-mx-2 mt-5 overflow-hidden px-2"
                            >
                                <div x-ref="engagementReplyTimingChart" class="min-h-[320px] w-full overflow-hidden [&_.apexcharts-canvas]:!max-w-full [&_.apexcharts-svg]:!max-w-full"></div>
                            </div>
                            <div class="mt-4 grid grid-cols-1 gap-3 sm:grid-cols-3">
                                <template x-for="item in replyTimingSelectedHour().stats" :key="item.label">
                                    <div class="rounded-md border border-gray-200 bg-white p-3">
                                        <p class="text-xs font-medium text-gray-500" x-text="item.label"></p>
                                        <p class="mt-1 text-base font-semibold text-gray-950" x-text="item.value"></p>
                                    </div>
                                </template>
                            </div>
                        </div>

                        <div class="min-w-0 rounded-lg border border-gray-200 bg-gray-50 p-5">
                            <div class="flex items-start justify-between gap-3">
                                <div>
                                    <h2 class="text-lg font-bold text-gray-950">Best Reply Windows</h2>
                                    <p class="mt-1 text-sm leading-6 text-gray-500">Use the spikes for send timing and avoid the low-response zones.</p>
                                </div>
                                <span class="flex size-10 shrink-0 items-center justify-center rounded-md bg-white text-gray-500 ring-1 ring-gray-200">
                                    <span class="outcraft-icon !text-[20px]">schedule</span>
                                </span>
                            </div>

                            <div class="mt-5 rounded-md border border-gray-200 bg-white p-4">
                                <p class="text-sm font-semibold text-gray-950" x-text="replyTimingActiveRegion().label"></p>
                                <p class="mt-2 text-2xl font-bold leading-tight text-gray-950" x-text="replyTimingBestWindow().range"></p>
                                <p class="mt-3 text-sm leading-6 text-gray-500" x-text="replyTimingBestWindow().insight"></p>
                            </div>

                            <div class="mt-5 space-y-4">
                                <div>
                                    <p class="text-xs font-semibold uppercase text-gray-400">Highest reply spikes</p>
                                    <div class="mt-2 space-y-2">
                                        <template x-for="window in replyTimingBestWindows()" :key="`best-${window.range}`">
                                            <button
                                                type="button"
                                                x-on:click="activeReplyTimingHour = window.focusHour"
                                                class="flex w-full items-center gap-3 rounded-md border border-transparent px-3 py-3 text-left transition hover:border-gray-200 hover:bg-white"
                                                :class="activeReplyTimingHour === window.focusHour ? 'border-gray-200 bg-white shadow-sm' : ''"
                                            >
                                                <span class="flex size-8 shrink-0 items-center justify-center rounded-md bg-emerald-100 text-emerald-700">
                                                    <span class="outcraft-icon !text-[16px]">arrow_outward</span>
                                                </span>
                                                <span class="min-w-0 flex-1">
                                                    <span class="block truncate text-sm font-semibold text-gray-950" x-text="window.range"></span>
                                                    <span class="mt-0.5 block truncate text-xs text-gray-500" x-text="window.copy"></span>
                                                </span>
                                                <span class="shrink-0 text-sm font-bold text-emerald-700" x-text="window.replyRate"></span>
                                            </button>
                                        </template>
                                    </div>
                                </div>

                                <div>
                                    <p class="text-xs font-semibold uppercase text-gray-400">Lowest response zones</p>
                                    <div class="mt-2 space-y-2">
                                        <template x-for="window in replyTimingQuietWindows()" :key="`quiet-${window.range}`">
                                            <button
                                                type="button"
                                                x-on:click="activeReplyTimingHour = window.focusHour"
                                                class="flex w-full items-center gap-3 rounded-md border border-transparent px-3 py-3 text-left transition hover:border-gray-200 hover:bg-white"
                                                :class="activeReplyTimingHour === window.focusHour ? 'border-gray-200 bg-white shadow-sm' : ''"
                                            >
                                                <span class="flex size-8 shrink-0 items-center justify-center rounded-md bg-gray-200 text-gray-500">
                                                    <span class="outcraft-icon !text-[16px]">south_east</span>
                                                </span>
                                                <span class="min-w-0 flex-1">
                                                    <span class="block truncate text-sm font-semibold text-gray-950" x-text="window.range"></span>
                                                    <span class="mt-0.5 block truncate text-xs text-gray-500" x-text="window.copy"></span>
                                                </span>
                                                <span class="shrink-0 text-sm font-bold text-gray-500" x-text="window.replyRate"></span>
                                            </button>
                                        </template>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div>
                    <div class="mb-3 flex items-end justify-between gap-4">
                        <div>
                            <h2 class="text-lg font-bold text-gray-950">Channel Activity</h2>
                            <p class="mt-1 text-sm text-gray-500">Outreach volume by channel for the selected date range.</p>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-5 xl:grid-cols-4">
                        <template x-for="card in engagementChannelActivityCards()" :key="card.label">
                            <div class="rounded-lg bg-white p-5 shadow-sm ring-1 ring-gray-900/5">
                                <div class="flex flex-col items-start gap-4 sm:flex-row sm:justify-between sm:gap-3">
                                    <span class="shrink-0 text-indigo-600 sm:order-2">
                                        <span class="outcraft-icon !text-[18px]" x-text="card.icon"></span>
                                    </span>
                                    <div>
                                        <p class="text-sm font-medium text-gray-500" x-text="card.label"></p>
                                        <p class="mt-2 text-3xl font-bold leading-none text-gray-950" x-text="card.value"></p>
                                        <div x-show="card.shouldShowTrend" class="mt-3 flex items-center gap-2 text-sm">
                                            <span class="inline-flex items-center gap-1 font-semibold" :class="card.trendDirection === 'up' ? 'text-emerald-600' : 'text-rose-600'">
                                                <span class="outcraft-icon !text-[18px]" x-text="card.trendDirection === 'up' ? 'arrow_outward' : 'south_east'"></span>
                                                <span x-text="card.trend"></span>
                                            </span>
                                            <span class="text-gray-500" x-text="card.comparisonLabel"></span>
                                        </div>
                                        <p class="mt-2 text-sm text-gray-500" x-text="card.shareLabel"></p>
                                    </div>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>

                <div class="relative rounded-lg bg-white p-6 shadow-sm ring-1 ring-gray-900/5">
                    <div class="pr-10">
                        <div class="max-w-3xl">
                            <h2 class="text-lg font-bold text-gray-950">Outreach Volume Over Time</h2>
                            <p class="mt-1 text-sm text-gray-500">Sent and made counts across selected channels.</p>
                        </div>
                    </div>
                    <div class="absolute right-5 top-5" x-on:click.outside="engagementChartMenuOpen = false">
                        <button type="button" x-on:click.stop="engagementChartMenuOpen = ! engagementChartMenuOpen" class="inline-flex size-8 items-center justify-center rounded-md text-gray-400 transition hover:bg-gray-50 hover:text-gray-700" aria-label="Engagement chart options">
                            <span class="outcraft-icon !text-[20px]">more_vert</span>
                        </button>
                        <div x-cloak x-show="engagementChartMenuOpen" x-on:click.stop data-dropdown-surface data-panel-surface x-transition:enter="transition ease-out duration-100" x-transition:enter-start="opacity-0 translate-y-1" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-1" class="absolute right-0 z-40 mt-2 w-64 rounded-md bg-white py-1 shadow-lg ring-1 ring-gray-900/10">
                            <p class="px-3 pb-1 pt-2 text-[11px] font-semibold uppercase tracking-wide text-gray-400">Chart view</p>
                            <template x-for="view in engagementTimelineViews()" :key="view.key">
                                <button type="button" x-on:click="setEngagementTimelineView(view.key)" class="flex w-full items-center justify-between gap-3 px-3 py-2 text-left text-sm font-medium transition hover:bg-gray-50" :class="engagementTimelineView === view.key ? 'text-indigo-600' : 'text-gray-700 hover:text-gray-950'">
                                    <span class="inline-flex items-center gap-2"><span class="outcraft-icon !text-[16px]" x-text="view.icon"></span><span x-text="view.label"></span></span>
                                    <span x-show="engagementTimelineView === view.key" class="outcraft-icon !text-[16px]">check</span>
                                </button>
                            </template>
                            <div class="my-1 border-t border-gray-200"></div>
                            <p class="px-3 pb-1 pt-2 text-[11px] font-semibold uppercase tracking-wide text-gray-400">Timeline channels</p>
                            <p class="px-3 pb-1 text-xs leading-5 text-gray-500">Choose which outreach channels appear in the timeline.</p>
                            <template x-for="channel in engagementChannelDefinitions()" :key="channel.label">
                                <button
                                    type="button"
                                    x-on:click="toggleEngagementChannel(channel.label)"
                                    class="flex w-full items-center justify-between gap-3 px-3 py-2 text-left text-sm font-medium text-gray-700 transition hover:bg-gray-50 hover:text-gray-950"
                                    :class="selectedEngagementChannels.includes(channel.label) ? 'bg-indigo-50 text-indigo-700' : ''"
                                >
                                    <span class="flex size-4 shrink-0 items-center justify-center rounded border" :class="selectedEngagementChannels.includes(channel.label) ? 'border-indigo-600 bg-indigo-600 text-white' : 'border-gray-300 bg-white text-transparent'">
                                        <span class="outcraft-icon !text-[13px]">check</span>
                                    </span>
                                    <span class="min-w-0 flex-1 truncate" x-text="channel.cardLabel"></span>
                                </button>
                            </template>
                        </div>
                    </div>
                    <div
                        x-effect="activeInsightsTab; activeAnalyticsRange; engagementTimelineView; selectedEngagementChannels.join('|'); activeInsightsTab === 'Engagement' && $nextTick(() => scheduleEngagementApexChartRender('volume'))"
                        class="-mx-2 mt-5 overflow-hidden px-2"
                    >
                        <div x-ref="engagementVolumeChart" class="min-h-[320px] w-full overflow-hidden [&_.apexcharts-canvas]:!max-w-full [&_.apexcharts-svg]:!max-w-full"></div>
                    </div>
                </div>

                <div>
                    <div class="mb-3">
                        <h2 class="text-lg font-bold text-gray-950">Channel Performance</h2>
                        <p class="mt-1 text-sm text-gray-500">Delivery, click, reply, and call quality by channel.</p>
                    </div>
                    <div class="space-y-4">
                        <template x-for="group in engagementPerformanceGroups()" :key="group.title">
                            <div class="overflow-hidden rounded-lg bg-white shadow-sm ring-1 ring-gray-900/5">
                                <div class="grid grid-cols-1" :style="window.innerWidth >= 1024 ? engagementPerformanceGridStyle(group) : ''">
                                    <div class="p-6" :class="group.panelClass">
                                        <span class="mb-4 flex size-10 shrink-0 items-center justify-center rounded-md" :class="group.iconShellClass">
                                            <span class="outcraft-icon !text-[21px]" x-text="group.icon"></span>
                                        </span>
                                        <div>
                                            <h3 class="text-base font-bold" :class="group.titleTextClass" x-text="group.title"></h3>
                                            <p class="mt-1 text-sm leading-6" :class="group.bodyTextClass" x-text="group.description"></p>
                                        </div>
                                    </div>
                                    <template x-for="(metric, metricIndex) in group.metrics" :key="metric.label">
                                        <div class="relative border-t p-6 lg:border-l lg:border-t-0" :class="[metric.panelClass, metric.borderClass]">
                                            <span
                                                x-show="group.showFlowArrows && metricIndex > 0"
                                                class="pointer-events-none absolute left-1/2 top-0 z-10 flex size-9 -translate-x-1/2 -translate-y-1/2 items-center justify-center rounded-md border border-gray-200 bg-white text-gray-400 shadow-sm lg:left-0 lg:top-1/2"
                                            >
                                                <span class="outcraft-icon !text-[22px] rotate-90 lg:rotate-0">arrow_forward</span>
                                            </span>
                                            <p class="text-sm font-medium" :class="metric.labelTextClass" x-text="metric.label"></p>
                                            <p class="mt-2 text-2xl font-bold leading-none" :class="metric.valueTextClass" x-text="metric.value"></p>
                                            <div x-show="metric.shouldShowTrend" class="mt-3 flex items-center gap-2 text-sm">
                                                <span class="inline-flex items-center gap-1 font-semibold" :class="metric.trendDirection === 'up' ? metric.trendUpTextClass : metric.trendDownTextClass">
                                                    <span class="outcraft-icon !text-[18px]" x-text="metric.trendDirection === 'up' ? 'arrow_outward' : 'south_east'"></span>
                                                    <span x-text="metric.trend"></span>
                                                </span>
                                                <span :class="metric.comparisonTextClass" x-text="metric.comparisonLabel"></span>
                                            </div>
                                            <p class="mt-2 text-sm leading-6" :class="metric.bodyTextClass" x-text="metric.subtext"></p>
                                        </div>
                                    </template>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>

                <div class="grid grid-cols-1 gap-5">
                    <div class="rounded-lg bg-white p-6 shadow-sm ring-1 ring-gray-900/5">
                        <h2 class="text-lg font-bold text-gray-950">Reply Step Distribution</h2>
                        <p class="mt-1 text-sm text-gray-500">Where replies happened in the outreach sequence.</p>
                        <div
                            x-effect="activeInsightsTab; activeAnalyticsRange; activeInsightsTab === 'Engagement' && $nextTick(() => renderEngagementApexChart('replySteps'))"
                            class="-mx-2 mt-5 overflow-hidden px-2"
                        >
                            <div x-ref="engagementReplyStepsChart" class="min-h-[280px] w-full overflow-hidden [&_.apexcharts-canvas]:!max-w-full [&_.apexcharts-svg]:!max-w-full"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div x-show="activeInsightsTab === 'Overview'" class="space-y-5">
                <div class="rounded-lg bg-white p-5 shadow-sm ring-1 ring-gray-900/5">
                    <div class="grid grid-cols-1 items-stretch gap-0 lg:min-w-[720px]" :style="window.innerWidth >= 1024 ? demoAnalyticsFunnelGridStyle() : ''">
                        <template x-for="(metric, metricIndex) in demoAnalyticsPrimaryMetrics()" :key="metric.label">
                            <div class="contents">
                                <div class="min-w-0 p-4 lg:p-0 lg:px-4" :class="metricIndex === 0 ? 'lg:pl-0' : (metricIndex === demoAnalyticsPrimaryMetrics().length - 1 ? 'lg:pr-0' : '')">
                                    <div class="space-y-3">
                                        <span class="flex size-10 shrink-0 items-center justify-center rounded-md bg-indigo-50 text-indigo-600">
                                            <span class="outcraft-icon !text-[21px]" x-text="metric.icon"></span>
                                        </span>
                                        <template x-if="metricIndex === 2 && analyticsOutcomeMetricOptions().length > 0">
                                            <span class="relative block min-w-0" x-on:click.outside="activeAnalyticsOutcomeMenuOpen = false">
                                                <button
                                                    type="button"
                                                    x-on:click="activeAnalyticsOutcomeMenuOpen = ! activeAnalyticsOutcomeMenuOpen"
                                                    class="group inline-flex max-w-full items-center gap-1.5 text-left text-sm font-medium text-gray-500 transition hover:text-gray-800"
                                                    :aria-expanded="activeAnalyticsOutcomeMenuOpen.toString()"
                                                >
                                                    <span class="min-w-0 truncate" x-text="metric.label"></span>
                                                    <span class="outcraft-icon shrink-0 !text-[17px] text-gray-400 transition group-hover:text-gray-600" :class="activeAnalyticsOutcomeMenuOpen ? 'rotate-180' : ''">keyboard_arrow_down</span>
                                                </button>
                                                <div
                                                    x-cloak
                                                    x-show="activeAnalyticsOutcomeMenuOpen"
                                                    data-dropdown-surface
                                                    data-panel-surface
                                                    x-transition:enter="transition ease-out duration-100"
                                                    x-transition:enter-start="opacity-0 translate-y-1"
                                                    x-transition:enter-end="opacity-100 translate-y-0"
                                                    x-transition:leave="transition ease-in duration-75"
                                                    x-transition:leave-start="opacity-100 translate-y-0"
                                                    x-transition:leave-end="opacity-0 translate-y-1"
                                                    class="absolute left-0 z-50 mt-2 w-56 overflow-hidden rounded-md bg-white py-1 text-sm shadow-lg ring-1 ring-gray-900/10"
                                                >
                                                    <template x-for="option in analyticsOutcomeMetricOptions()" :key="option">
                                                        <button
                                                            type="button"
                                                            x-on:click="setAnalyticsOutcomeMetric(option)"
                                                            class="flex w-full items-center justify-between gap-3 px-3 py-2 text-left font-medium transition hover:bg-gray-50"
                                                            :class="activeAnalyticsOutcomeMetric === option ? 'bg-indigo-50 text-indigo-700' : 'text-gray-700 hover:text-gray-950'"
                                                        >
                                                            <span class="min-w-0 truncate" x-text="option"></span>
                                                            <span x-show="activeAnalyticsOutcomeMetric === option" class="outcraft-icon shrink-0 !text-[16px] text-indigo-600">check</span>
                                                        </button>
                                                    </template>
                                                </div>
                                            </span>
                                        </template>
                                        <p x-show="metricIndex !== 2 || analyticsOutcomeMetricOptions().length === 0" class="min-w-0 text-sm font-medium text-gray-500" x-text="metric.titleLabel || metric.label"></p>
                                    </div>
                                    <div>
                                        <div class="mt-1.5 flex items-center gap-2">
                                            <p class="text-3xl/10 font-semibold tracking-tight text-gray-950" x-text="metric.value"></p>
                                        </div>
                                        <div x-show="metric.shouldShowTrend" class="mt-1.5 flex items-center gap-2 text-sm">
                                            <span class="inline-flex items-center gap-1 font-semibold" :class="metric.trendDirection === 'up' ? 'text-emerald-600' : 'text-rose-600'">
                                                <span class="outcraft-icon !text-[18px]" x-text="metric.trendDirection === 'up' ? 'arrow_outward' : 'south_east'"></span>
                                                <span x-text="metric.trend"></span>
                                            </span>
                                            <span class="text-gray-500" x-text="metric.comparisonLabel"></span>
                                        </div>
                                    </div>
                                </div>
                                <span x-show="metricIndex < demoAnalyticsPrimaryMetrics().length - 1" class="relative -mx-5 flex min-h-12 self-stretch items-center justify-center lg:mx-0 lg:-my-5">
                                    <span class="absolute inset-x-0 top-1/2 border-t border-gray-200 lg:inset-x-auto lg:inset-y-0 lg:left-1/2 lg:top-0 lg:border-l lg:border-t-0"></span>
                                    <span class="relative z-10 flex size-9 items-center justify-center rounded-md border border-gray-200 bg-white text-gray-400 shadow-sm">
                                        <span class="outcraft-icon !text-[22px] rotate-90 lg:rotate-0">arrow_forward</span>
                                    </span>
                                </span>
                            </div>
                        </template>
                    </div>
                </div>

                <div class="grid grid-cols-1 gap-5 xl:grid-cols-3">
                    <div class="relative min-w-0 overflow-visible rounded-lg bg-white p-6 shadow-sm ring-1 ring-gray-900/5 xl:col-span-2">
                        <div class="pr-10">
                            <div class="max-w-3xl">
                                <h2 class="text-lg font-bold text-gray-950" x-text="analyticsCampaignConfig().title"></h2>
                                <p class="mt-1 text-sm text-gray-500" x-text="demoAnalyticsRangeDescription()"></p>
                            </div>
                        </div>
                        <div class="absolute right-5 top-5" x-on:click.outside="demoAnalyticsChartMenuOpen = false">
                            <button type="button" x-on:click.stop="demoAnalyticsChartMenuOpen = ! demoAnalyticsChartMenuOpen" class="inline-flex size-8 items-center justify-center rounded-md text-gray-400 transition hover:bg-gray-50 hover:text-gray-700" aria-label="Timeline chart options">
                                <span class="outcraft-icon !text-[20px]">more_vert</span>
                            </button>
                            <div x-cloak x-show="demoAnalyticsChartMenuOpen" x-on:click.stop data-dropdown-surface data-panel-surface x-transition:enter="transition ease-out duration-100" x-transition:enter-start="opacity-0 translate-y-1" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-1" class="absolute right-0 z-40 mt-2 w-64 rounded-md bg-white py-1 shadow-lg ring-1 ring-gray-900/10">
                                <p class="px-3 pb-1 pt-2 text-[11px] font-semibold uppercase tracking-wide text-gray-400">Chart view</p>
                                <template x-for="view in demoAnalyticsTimelineViews()" :key="view.key">
                                    <button type="button" x-on:click="setDemoAnalyticsTimelineView(view.key)" class="flex w-full items-center justify-between gap-3 px-3 py-2 text-left text-sm font-medium transition hover:bg-gray-50" :class="demoAnalyticsTimelineView === view.key ? 'text-indigo-600' : 'text-gray-700 hover:text-gray-950'">
                                        <span class="inline-flex items-center gap-2"><span class="outcraft-icon !text-[16px]" x-text="view.icon"></span><span x-text="view.label"></span></span>
                                        <span x-show="demoAnalyticsTimelineView === view.key" class="outcraft-icon !text-[16px]">check</span>
                                    </button>
                                </template>
                                <div class="my-1 border-t border-gray-200"></div>
                                <p class="px-3 pb-1 pt-2 text-[11px] font-semibold uppercase tracking-wide text-gray-400">Comparison</p>
                                <button
                                    type="button"
                                    x-on:click="toggleDemoAnalyticsPreviousPeriod()"
                                    class="flex w-full items-center justify-between gap-3 px-3 py-2 text-left text-sm font-medium text-gray-700 transition hover:bg-gray-50 hover:text-gray-950"
                                    :class="showAnalyticsPreviousPeriod ? 'bg-indigo-50 text-indigo-700' : ''"
                                >
                                    <span class="min-w-0 flex-1">Previous period curves</span>
                                    <span class="flex size-4 shrink-0 items-center justify-center rounded border" :class="showAnalyticsPreviousPeriod ? 'border-indigo-600 bg-indigo-600 text-white' : 'border-gray-300 bg-white text-transparent'">
                                        <span class="outcraft-icon !text-[13px]">check</span>
                                    </span>
                                </button>
                                <div class="my-1 border-t border-gray-200"></div>
                                <p class="px-3 pb-1 pt-2 text-[11px] font-semibold uppercase tracking-wide text-gray-400">Timeline metrics</p>
                                <p class="px-3 pb-1 text-xs leading-5 text-gray-500">Choose which funnel steps appear in the timeline.</p>
                                <template x-for="option in demoAnalyticsTimelineMetricOptions()" :key="option">
                                    <button
                                        type="button"
                                        x-on:click="toggleDemoAnalyticsTimelineMetric(option)"
                                        class="flex w-full items-center justify-between gap-3 px-3 py-2 text-left text-sm font-medium text-gray-700 transition hover:bg-gray-50 hover:text-gray-950"
                                        :class="demoAnalyticsTimelineSelectedLabels().includes(option) ? 'bg-indigo-50 text-indigo-700' : ''"
                                    >
                                        <span class="flex size-4 shrink-0 items-center justify-center rounded border" :class="demoAnalyticsTimelineSelectedLabels().includes(option) ? 'border-indigo-600 bg-indigo-600 text-white' : 'border-gray-300 bg-white text-transparent'">
                                            <span class="outcraft-icon !text-[13px]">check</span>
                                        </span>
                                        <span class="min-w-0 flex-1 truncate" x-text="option"></span>
                                    </button>
                                </template>
                            </div>
                        </div>
                        <div
                            x-show="['column', 'area'].includes(demoAnalyticsTimelineView)"
                            x-effect="demoAnalyticsTimelineView; activeAnalyticsRange; activeAnalyticsCampaign; activeAnalyticsOutcomeMetric; activeAnalyticsTimelineMetrics.join('|'); showAnalyticsPreviousPeriod; ['column', 'area'].includes(demoAnalyticsTimelineView) && $nextTick(() => scheduleDemoAnalyticsApexChartRender())"
                            class="mt-6 overflow-hidden pt-2"
                        >
                            <div x-ref="demoAnalyticsApexChart" class="min-h-[280px] w-full overflow-hidden [&_.apexcharts-canvas]:!max-w-full [&_.apexcharts-svg]:!max-w-full"></div>
                        </div>
                        <div class="mt-4 flex flex-wrap items-center gap-4 text-xs font-medium text-gray-500">
                            <template x-for="series in demoAnalyticsTimelineSeriesMeta()" :key="`legend-${series.label}`">
                                <span class="inline-flex items-center gap-2"><span class="size-2 rounded-full" :class="series.dotClass"></span><span x-text="series.label"></span></span>
                            </template>
                        </div>
                    </div>

                    <div class="min-w-0 rounded-lg bg-white p-6 shadow-sm ring-1 ring-gray-900/5">
                        <h2 class="text-lg font-bold text-gray-950" x-text="demoAnalyticsRateSplit().label"></h2>
                        <p class="mt-1 text-sm text-gray-500" x-text="demoAnalyticsRateSplit().description"></p>
                        <div class="mt-6 rounded-lg bg-gray-950 p-5 text-white">
                            <p class="text-sm font-medium text-gray-300" x-text="`${demoAnalyticsRateSplit().shortLabel} from all runs`"></p>
                            <p class="mt-2 text-4xl font-bold leading-none" x-text="demoAnalyticsRateSplit().allRate"></p>
                            <p class="mt-4 text-sm text-gray-300" x-text="demoAnalyticsRateSplit().allCopy"></p>
                        </div>
                        <div class="mt-4 rounded-lg p-5 oc-primary-bg-soft">
                            <p class="text-sm font-medium text-gray-700" x-text="`${demoAnalyticsRateSplit().shortLabel} from engaged`"></p>
                            <p class="mt-2 text-4xl font-bold leading-none text-gray-950" x-text="demoAnalyticsRateSplit().engagedRate"></p>
                            <p class="mt-3 text-sm text-gray-700" x-text="demoAnalyticsRateSplit().engagedCopy"></p>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 gap-5 xl:grid-cols-3">
                    <div class="rounded-lg bg-white p-6 shadow-sm ring-1 ring-gray-900/5 xl:col-span-2">
                        <div class="grid grid-cols-1 gap-5 lg:grid-cols-2 lg:items-start">
                            <div class="min-w-0">
                                <h2 class="text-lg font-bold text-gray-950">Lead Intake Timeline</h2>
                                <p class="mt-1 max-w-3xl text-sm leading-6 text-gray-500">Shows how many leads entered your pipeline, helping you spot intake spikes or slowdowns.</p>
                            </div>
                            <div class="min-w-0 lg:justify-self-start">
                                <p class="text-sm font-medium text-gray-500">Total lead intake</p>
                                <p class="mt-1.5 text-3xl/10 font-semibold tracking-tight text-gray-950" x-text="overviewLeadIntakeSummary().total"></p>
                                <div x-show="overviewLeadIntakeSummary().shouldShowTrend" class="mt-1.5 flex flex-wrap items-center gap-2 text-sm">
                                    <span class="inline-flex items-center gap-1 font-semibold" :class="overviewLeadIntakeSummary().trendDirection === 'up' ? 'text-emerald-600' : 'text-rose-600'">
                                        <span class="outcraft-icon !text-[18px]" x-text="overviewLeadIntakeSummary().trendDirection === 'up' ? 'arrow_outward' : 'south_east'"></span>
                                        <span x-text="overviewLeadIntakeSummary().trend"></span>
                                    </span>
                                    <span class="text-gray-500" x-text="overviewLeadIntakeSummary().comparisonLabel"></span>
                                </div>
                            </div>
                        </div>
                        <div
                            x-effect="activeInsightsTab; activeAnalyticsRange; analyticsCustomRangeStart; analyticsCustomRangeEnd; activeInsightsTab === 'Overview' && $nextTick(() => renderEngagementApexChart('leadIntake'))"
                            class="-mx-2 mt-5 overflow-hidden px-2"
                        >
                            <div x-ref="overviewLeadIntakeChart" class="min-h-[360px] w-full overflow-hidden [&_.apexcharts-canvas]:!max-w-full [&_.apexcharts-svg]:!max-w-full"></div>
                        </div>
                    </div>

                    <div class="rounded-lg bg-gray-950 p-6 text-white">
                        <h2 class="text-lg font-bold text-white">Goals Achieved per Channel</h2>
                        <p class="mt-1 text-sm text-gray-300">Successful campaign outcomes grouped by outreach channel.</p>
                        <div
                            x-effect="activeInsightsTab; activeAnalyticsRange; activeInsightsTab === 'Overview' && $nextTick(() => renderEngagementApexChart('goalByChannel'))"
                            class="-mx-2 mt-5 overflow-hidden px-2"
                        >
                            <div x-ref="engagementGoalByChannelChart" class="min-h-[360px] w-full overflow-hidden [&_.apexcharts-canvas]:!max-w-full [&_.apexcharts-svg]:!max-w-full"></div>
                        </div>
                    </div>
                </div>

            </div>
        </section>
