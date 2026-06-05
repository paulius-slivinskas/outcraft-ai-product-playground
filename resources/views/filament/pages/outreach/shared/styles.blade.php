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
            --oc-info-50-rgb: 239 246 255;
            --oc-info-100-rgb: 219 234 254;
            --oc-info-200-rgb: 191 219 254;
            --oc-info-300-rgb: 147 197 253;
            --oc-info-400-rgb: 96 165 250;
            --oc-info-500-rgb: 59 130 246;
            --oc-info-600-rgb: 37 99 235;
            --oc-info-700-rgb: 29 78 216;
            --oc-info-800-rgb: 30 64 175;
            --oc-info-900-rgb: 30 58 138;
            --oc-info-950-rgb: 23 37 84;
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
            --oc-border-color: rgb(229 231 235);
            --oc-card-shadow: 0 1px 3px 0 rgb(0 0 0 / 0.10), 0 1px 2px -1px rgb(0 0 0 / 0.10);
            --oc-field-shadow: 0 1px 3px 0 rgb(0 0 0 / 0.10), 0 1px 2px -1px rgb(0 0 0 / 0.10);
            --oc-button-shadow: 0 1px 3px 0 rgb(0 0 0 / 0.10), 0 1px 2px -1px rgb(0 0 0 / 0.10);
            --oc-dropdown-shadow: 0 10px 15px -3px rgb(0 0 0 / 0.10), 0 4px 6px -4px rgb(0 0 0 / 0.10);
            --oc-panel-shadow: 0 25px 50px -12px rgb(0 0 0 / 0.25);
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
        .outcraft-page [data-campaign-field][class~="rounded"],
        .outcraft-page [data-campaign-field][class*="rounded-"],
        .outcraft-page button[aria-expanded][class*="rounded-"][class*="bg-white"],
        .outcraft-page [data-component="custom-field-text-input"] {
            border-radius: var(--oc-field-radius) !important;
        }
        .outcraft-page [data-component="custom-field-text-input"]:focus-within {
            border-color: var(--oc-primary-600) !important;
            --tw-ring-color: var(--oc-primary-600) !important;
        }
        .outcraft-page .border-gray-100,
        .outcraft-page .border-gray-200 {
            border-color: var(--oc-border-color) !important;
        }
        .outcraft-page .divide-gray-100 > :not([hidden]) ~ :not([hidden]),
        .outcraft-page .divide-gray-200 > :not([hidden]) ~ :not([hidden]) {
            border-color: var(--oc-border-color) !important;
        }
        .outcraft-page .ring-gray-900\/5,
        .outcraft-page .ring-gray-200 {
            --tw-ring-color: var(--oc-border-color) !important;
        }
        .outcraft-page [data-outcraft-date-range-picker="true"] {
            --primary-50: rgb(var(--oc-primary-50-rgb));
            --primary-100: rgb(var(--oc-primary-100-rgb));
            --primary-200: rgb(var(--oc-primary-200-rgb));
            --primary-300: rgb(var(--oc-primary-300-rgb));
            --primary-400: rgb(var(--oc-primary-400-rgb));
            --primary-500: rgb(var(--oc-primary-500-rgb));
            --primary-600: rgb(var(--oc-primary-600-rgb));
            --primary-700: rgb(var(--oc-primary-700-rgb));
            --primary-800: rgb(var(--oc-primary-800-rgb));
            --primary-900: rgb(var(--oc-primary-900-rgb));
            --primary-950: rgb(var(--oc-primary-950-rgb));
        }
        .outcraft-page [data-outcraft-date-range-picker="true"] .fi-fo-date-range-picker-single-wrapper {
            min-height: 2.5rem !important;
            border-radius: var(--oc-field-radius) !important;
            background: #fff !important;
            outline: 1px solid rgb(209 213 219) !important;
            outline-offset: -1px !important;
            --tw-shadow: var(--oc-field-shadow) !important;
            box-shadow: var(--tw-ring-offset-shadow, 0 0 #0000), var(--tw-ring-shadow, 0 0 #0000), var(--tw-shadow) !important;
        }
        .outcraft-page [data-outcraft-date-range-picker="true"] .fi-fo-date-range-picker-single-wrapper:focus-within {
            outline: 2px solid var(--oc-primary-600) !important;
            outline-offset: -2px !important;
        }
        .outcraft-page [data-outcraft-date-range-picker="true"] .fi-input-wrp-prefix {
            color: rgb(107 114 128) !important;
            padding-left: 0.75rem !important;
        }
        .outcraft-page [data-outcraft-date-range-picker="true"] .fi-input-wrp-prefix-icon {
            width: 1.125rem !important;
            height: 1.125rem !important;
        }
        .outcraft-page [data-outcraft-date-range-picker="true"] .fi-date-range-picker-input {
            min-height: 2.5rem !important;
            padding-block: 0 !important;
            padding-left: 0.5rem !important;
            padding-right: 2.25rem !important;
            color: rgb(17 24 39) !important;
            font-size: 0.875rem !important;
            line-height: 1.5rem !important;
        }
        .outcraft-page [data-outcraft-date-range-picker="true"] .fi-date-range-picker-input::placeholder {
            color: rgb(156 163 175) !important;
        }
        .outcraft-page [data-outcraft-date-range-picker="true"] .fi-date-range-picker-panel {
            z-index: 60 !important;
            width: max-content !important;
            min-width: 0 !important;
            max-width: calc(100vw - 2rem) !important;
            border-radius: var(--oc-panel-radius, 0.75rem) !important;
            background: #fff !important;
            padding: 1rem !important;
            outline: 1px solid rgb(229 231 235) !important;
            --tw-shadow: var(--oc-panel-shadow) !important;
            box-shadow: var(--tw-ring-offset-shadow, 0 0 #0000), var(--tw-ring-shadow, 0 0 #0000), var(--tw-shadow) !important;
        }
        .outcraft-page [data-outcraft-date-range-picker="true"] .fi-date-range-picker-panel-body {
            gap: 1rem !important;
        }
        .outcraft-page [data-outcraft-date-range-picker="true"] .fi-date-range-picker-calendars {
            gap: 1rem !important;
        }
        .outcraft-page [data-outcraft-date-range-picker="true"] .fi-date-range-picker-calendar {
            min-width: 13rem !important;
        }
        .outcraft-page [data-outcraft-date-range-picker="true"] .fi-date-range-picker-calendar-header-day,
        .outcraft-page [data-outcraft-date-range-picker="true"] .fi-date-range-picker-calendar-day {
            font-size: 0.75rem !important;
            line-height: 1rem !important;
        }
        .outcraft-page [data-outcraft-date-range-picker="true"] .fi-date-range-picker-calendar-day.is-selected {
            background-color: var(--oc-primary-600) !important;
            color: #fff !important;
        }
        .outcraft-page [data-outcraft-date-range-picker="true"] .fi-date-range-picker-calendar-day.is-in-range {
            background-color: rgb(var(--oc-primary-100-rgb)) !important;
            color: var(--oc-primary-700) !important;
        }
        .outcraft-page [data-outcraft-date-range-picker="true"] .fi-date-range-picker-calendar-day.is-today:not(.is-in-range):not(.is-selected),
        .outcraft-page [data-outcraft-date-range-picker="true"] .fi-date-range-picker-apply-button {
            color: var(--oc-primary-600) !important;
        }
        .outcraft-page [data-outcraft-date-range-picker="true"] .fi-date-range-picker-preset.is-active {
            background-color: var(--oc-primary-600) !important;
            color: #fff !important;
        }
        @media (max-width: 640px) {
            .outcraft-page [data-outcraft-date-range-picker="true"] .fi-date-range-picker-panel {
                width: calc(100vw - 2rem) !important;
                min-width: calc(100vw - 2rem) !important;
            }
            .outcraft-page [data-outcraft-date-range-picker="true"] .fi-date-range-picker-panel-body,
            .outcraft-page [data-outcraft-date-range-picker="true"] .fi-date-range-picker-calendars {
                flex-direction: column !important;
            }
        }
        .outcraft-page input:not([type="checkbox"]):not([type="radio"]):not([type="range"]):not([type="file"]),
        .outcraft-page select,
        .outcraft-page button[data-campaign-field] {
            min-height: 2.25rem;
            line-height: 1.5rem;
        }
        .outcraft-page input:not([type="checkbox"]):not([type="radio"]):not([type="range"]):not([type="file"])[class*="shadow"],
        .outcraft-page textarea[class*="shadow"],
        .outcraft-page select[class*="shadow"],
        .outcraft-page div[class*="shadow"]:has(> input:not([type="checkbox"]):not([type="radio"]):not([type="range"]):not([type="file"])),
        .outcraft-page div[class*="shadow"]:has(> select),
        .outcraft-page div[class*="shadow"]:has(> textarea),
        .outcraft-page [data-campaign-field][class*="shadow"],
        .outcraft-page [data-component="custom-field-text-input"] {
            --tw-shadow: var(--oc-field-shadow) !important;
            box-shadow: var(--tw-ring-offset-shadow, 0 0 #0000), var(--tw-ring-shadow, 0 0 #0000), var(--tw-shadow) !important;
        }
        .outcraft-page button[class*="shadow"]:not([data-shadow-control]):not([role="switch"]) {
            --tw-shadow: var(--oc-button-shadow) !important;
            box-shadow: var(--tw-ring-offset-shadow, 0 0 #0000), var(--tw-ring-shadow, 0 0 #0000), var(--tw-shadow) !important;
        }
        .outcraft-page [data-outcraft-field-control] {
            border-radius: var(--oc-field-radius) !important;
        }
        .outcraft-page [data-card-surface],
        .outcraft-page article[class*="rounded-"],
        .outcraft-page section[class*="rounded-"][class*="border"],
        .outcraft-page section[class*="rounded-"][class*="ring"][class*="bg-white"]:not([data-shadow-control]),
        .outcraft-page div[class*="rounded-"][class*="border"][class*="bg-white"]:not([data-component="custom-field-text-input"]):not(:has(> input)):not(:has(> select)):not(:has(> textarea)),
        .outcraft-page div[class*="rounded-"][class*="ring"][class*="bg-white"]:not([data-component="custom-field-text-input"]):not(:has(> input)):not(:has(> select)):not(:has(> textarea)),
        .outcraft-page div[class*="rounded-"][class*="ring"][class*="bg-gray-950"]:not([data-shadow-control]),
        .outcraft-page div[class*="rounded-"][class*="oc-primary-bg-soft"]:not([data-shadow-control]),
        .outcraft-page div[class*="rounded-"][class*="outline"][class*="bg-white"],
        .outcraft-page button[class*="rounded-"][class*="outline"][class*="p-4"],
        .outcraft-page button[class*="rounded-"][class*="outline"][class*="p-5"],
        .outcraft-page button[class*="rounded-"][class*="border"][class*="p-4"],
        .outcraft-page button[class*="rounded-"][class*="border"][class*="p-5"] {
            border-radius: var(--oc-card-radius) !important;
        }
        .outcraft-page [data-campaign-builder] fieldset[class*="rounded-"],
        .outcraft-page [data-campaign-builder] article[class*="rounded-"],
        .outcraft-page [data-campaign-builder] div[class*="rounded-"][class*="bg-white"]:not([data-card-ignore]):not([data-component="custom-field-text-input"]):not(:has(> input)):not(:has(> select)):not(:has(> textarea)),
        .outcraft-page [data-campaign-builder] button[class*="rounded-"][class*="bg-white"][class*="p-4"]:not([data-shadow-control]),
        .outcraft-page [data-campaign-builder] button[class*="rounded-"][class*="bg-white"][class*="p-5"]:not([data-shadow-control]),
        .outcraft-page [data-campaign-builder] button[class*="rounded-"][class*="border"][class*="p-4"]:not([data-shadow-control]),
        .outcraft-page [data-campaign-builder] button[class*="rounded-"][class*="border"][class*="p-5"]:not([data-shadow-control]) {
            border-radius: var(--oc-card-radius) !important;
        }
        .outcraft-page [data-analytics-page] div[class*="rounded-"][class*="shadow-sm"][class*="ring-1"],
        .outcraft-page [data-analytics-page] div[class*="rounded-"][class*="border"][class*="bg-gray-50"],
        .outcraft-page [data-analytics-page] div[class*="rounded-"][class*="bg-gray-950"][class*="p-5"] {
            border-radius: var(--oc-card-radius) !important;
        }
        .outcraft-page[data-card-border="true"] [data-card-surface]:not([class*="border"]):not([class*="ring"]):not([class*="outline"]),
        .outcraft-page[data-card-border="true"] article[class*="rounded-"]:not([class*="border"]):not([class*="ring"]):not([class*="outline"]),
        .outcraft-page[data-card-border="true"] section[class*="rounded-"][class*="bg-white"]:not([class*="border"]):not([class*="ring"]):not([class*="outline"]):not([data-shadow-control]),
        .outcraft-page[data-card-border="true"] div[class*="rounded-"][class*="bg-white"]:not([class*="border"]):not([class*="ring"]):not([class*="outline"]):not([data-component="custom-field-text-input"]):not(:has(> input)):not(:has(> select)):not(:has(> textarea)):not([data-shadow-control]),
        .outcraft-page[data-card-border="true"] div[class*="rounded-"][class*="ring"][class*="bg-gray-950"]:not([data-shadow-control]),
        .outcraft-page[data-card-border="true"] button[class*="rounded-"][class*="p-4"]:not([class*="border"]):not([class*="ring"]):not([class*="outline"]):not([data-shadow-control]),
        .outcraft-page[data-card-border="true"] button[class*="rounded-"][class*="p-5"]:not([class*="border"]):not([class*="ring"]):not([class*="outline"]):not([data-shadow-control]) {
            border-width: 1px !important;
            border-style: solid !important;
            border-color: rgb(229 231 235) !important;
        }
        .outcraft-page[data-card-border="true"] [data-campaign-builder] fieldset[class*="rounded-"]:not([class*="border"]):not([class*="ring"]):not([class*="outline"]),
        .outcraft-page[data-card-border="true"] [data-campaign-builder] article[class*="rounded-"]:not([class*="border"]):not([class*="ring"]):not([class*="outline"]),
        .outcraft-page[data-card-border="true"] [data-campaign-builder] div[class*="rounded-"][class*="bg-white"]:not([data-card-ignore]):not([class*="border"]):not([class*="ring"]):not([class*="outline"]):not([data-component="custom-field-text-input"]):not(:has(> input)):not(:has(> select)):not(:has(> textarea)),
        .outcraft-page[data-card-border="true"] [data-campaign-builder] button[class*="rounded-"][class*="p-4"]:not([class*="border"]):not([class*="ring"]):not([class*="outline"]):not([data-shadow-control]),
        .outcraft-page[data-card-border="true"] [data-campaign-builder] button[class*="rounded-"][class*="p-5"]:not([class*="border"]):not([class*="ring"]):not([class*="outline"]):not([data-shadow-control]) {
            border-width: 1px !important;
            border-style: solid !important;
            border-color: rgb(229 231 235) !important;
        }
        .outcraft-page[data-card-border="false"] [data-card-surface],
        .outcraft-page[data-card-border="false"] article[class*="rounded-"][class*="bg-white"]:not([data-shadow-control]),
        .outcraft-page[data-card-border="false"] section[class*="rounded-"][class*="bg-white"]:not([data-shadow-control]),
        .outcraft-page[data-card-border="false"] div[class*="rounded-"][class*="bg-white"]:not([data-component="custom-field-text-input"]):not(:has(> input)):not(:has(> select)):not(:has(> textarea)):not([data-shadow-control]),
        .outcraft-page[data-card-border="false"] div[class*="rounded-"][class*="bg-gray-950"]:not([data-shadow-control]),
        .outcraft-page[data-card-border="false"] button[class*="rounded-"][class*="p-4"]:not([data-shadow-control]),
        .outcraft-page[data-card-border="false"] button[class*="rounded-"][class*="p-5"]:not([data-shadow-control]) {
            border-color: transparent !important;
            outline-color: transparent !important;
            --tw-ring-shadow: 0 0 #0000 !important;
        }
        .outcraft-page[data-card-border="false"] [data-campaign-builder] fieldset[class*="rounded-"],
        .outcraft-page[data-card-border="false"] [data-campaign-builder] article[class*="rounded-"],
        .outcraft-page[data-card-border="false"] [data-campaign-builder] div[class*="rounded-"][class*="bg-white"]:not([data-card-ignore]):not([data-component="custom-field-text-input"]):not(:has(> input)):not(:has(> select)):not(:has(> textarea)),
        .outcraft-page[data-card-border="false"] [data-campaign-builder] button[class*="rounded-"][class*="p-4"]:not([data-shadow-control]),
        .outcraft-page[data-card-border="false"] [data-campaign-builder] button[class*="rounded-"][class*="p-5"]:not([data-shadow-control]) {
            border-color: transparent !important;
            outline-color: transparent !important;
            --tw-ring-shadow: 0 0 #0000 !important;
        }
        .outcraft-page [data-card-surface],
        .outcraft-page article[class*="rounded-"][class*="bg-white"]:not([data-shadow-control]),
        .outcraft-page section[class*="rounded-"][class*="bg-white"][class*="border"]:not([data-shadow-control]),
        .outcraft-page section[class*="rounded-"][class*="bg-white"][class*="ring"]:not([data-shadow-control]),
        .outcraft-page section[class*="rounded-"][class*="bg-white"][class*="outline"]:not([data-shadow-control]),
        .outcraft-page div[class*="rounded-"][class*="border"][class*="bg-white"]:not([data-component="custom-field-text-input"]):not(:has(> input)):not(:has(> select)):not(:has(> textarea)):not([data-shadow-control]),
        .outcraft-page div[class*="rounded-"][class*="ring"][class*="bg-white"]:not([data-component="custom-field-text-input"]):not(:has(> input)):not(:has(> select)):not(:has(> textarea)):not([data-shadow-control]),
        .outcraft-page div[class*="rounded-"][class*="ring"][class*="bg-gray-950"]:not([data-shadow-control]),
        .outcraft-page div[class*="rounded-"][class*="outline"][class*="bg-white"]:not([data-shadow-control]),
        .outcraft-page button[class*="rounded-"][class*="outline"][class*="p-4"]:not([data-shadow-control]),
        .outcraft-page button[class*="rounded-"][class*="outline"][class*="p-5"]:not([data-shadow-control]),
        .outcraft-page button[class*="rounded-"][class*="border"][class*="p-4"]:not([data-shadow-control]),
        .outcraft-page button[class*="rounded-"][class*="border"][class*="p-5"]:not([data-shadow-control]) {
            --tw-shadow: var(--oc-card-shadow) !important;
            box-shadow: var(--tw-ring-offset-shadow, 0 0 #0000), var(--tw-ring-shadow, 0 0 #0000), var(--tw-shadow) !important;
        }
        .outcraft-page [data-campaign-builder] fieldset[class*="rounded-"],
        .outcraft-page [data-campaign-builder] article[class*="rounded-"],
        .outcraft-page [data-campaign-builder] div[class*="rounded-"][class*="bg-white"]:not([data-card-ignore]):not([data-component="custom-field-text-input"]):not(:has(> input)):not(:has(> select)):not(:has(> textarea)):not([data-shadow-control]),
        .outcraft-page [data-campaign-builder] button[class*="rounded-"][class*="bg-white"][class*="p-4"]:not([data-shadow-control]),
        .outcraft-page [data-campaign-builder] button[class*="rounded-"][class*="bg-white"][class*="p-5"]:not([data-shadow-control]),
        .outcraft-page [data-campaign-builder] button[class*="rounded-"][class*="border"][class*="p-4"]:not([data-shadow-control]),
        .outcraft-page [data-campaign-builder] button[class*="rounded-"][class*="border"][class*="p-5"]:not([data-shadow-control]) {
            --tw-shadow: var(--oc-card-shadow) !important;
            box-shadow: var(--tw-ring-offset-shadow, 0 0 #0000), var(--tw-ring-shadow, 0 0 #0000), var(--tw-shadow) !important;
        }
        .outcraft-page [data-campaign-builder] fieldset[class*="rounded-"][class*="bg-white"],
        .outcraft-page [data-campaign-builder] article[class*="rounded-"][class*="bg-white"],
        .outcraft-page [data-campaign-builder] div[class*="rounded-"][class*="bg-white"]:not([data-card-ignore]):not([data-component="custom-field-text-input"]):not(:has(> input)):not(:has(> select)):not(:has(> textarea)):not([data-shadow-control]) {
            border-color: var(--oc-border-color) !important;
            outline-color: var(--oc-border-color) !important;
            --tw-ring-color: var(--oc-border-color) !important;
        }
        .outcraft-page [data-campaign-builder] [class~="border-t"],
        .outcraft-page [data-campaign-builder] [class~="border-b"],
        .outcraft-page [data-campaign-builder] [class~="border-l"],
        .outcraft-page [data-campaign-builder] [class~="border-r"],
        .outcraft-page [data-campaign-builder] [class~="divide-y"] > :not([hidden]) ~ :not([hidden]),
        .outcraft-page [data-campaign-builder] [class~="divide-x"] > :not([hidden]) ~ :not([hidden]) {
            border-color: var(--oc-border-color) !important;
        }
        .outcraft-page [data-dropdown-surface],
        .outcraft-page [class*="absolute"][class*="shadow-lg"],
        .outcraft-page [class*="absolute"][class*="shadow-xl"],
        .outcraft-page [class*="absolute"][class*="shadow-2xl"] {
            --tw-shadow: var(--oc-dropdown-shadow) !important;
            box-shadow: var(--tw-ring-offset-shadow, 0 0 #0000), var(--tw-ring-shadow, 0 0 #0000), var(--tw-shadow) !important;
        }
        .outcraft-page > [class*="fixed"][class*="shadow-2xl"],
        .outcraft-page [data-panel-surface],
        .outcraft-page [class*="fixed"] [class*="rounded-"][class*="bg-white"][class*="shadow-xl"],
        .outcraft-page [class*="fixed"] [class*="rounded-"][class*="bg-white"][class*="shadow-2xl"] {
            --tw-shadow: var(--oc-panel-shadow) !important;
            box-shadow: var(--tw-ring-offset-shadow, 0 0 #0000), var(--tw-ring-shadow, 0 0 #0000), var(--tw-shadow) !important;
        }
        .outcraft-page [data-icon-tile],
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
        .outcraft-page [data-outcraft-field-control] {
            border-radius: var(--oc-field-radius) !important;
            --tw-shadow: var(--oc-field-shadow) !important;
            box-shadow: var(--tw-ring-offset-shadow, 0 0 #0000), var(--tw-ring-shadow, 0 0 #0000), var(--tw-shadow) !important;
        }
        .outcraft-page [data-outcraft-field-control] > button {
            border-radius: 0 !important;
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
        .outcraft-page .oc-primary-bg-dark {
            background-color: rgb(var(--oc-primary-800-rgb)) !important;
        }
        .outcraft-page .group:hover .group-hover\:oc-primary-bg-dark {
            background-color: rgb(var(--oc-primary-700-rgb)) !important;
        }
        .outcraft-page .group:hover .group-hover\:oc-primary-bg {
            background-color: rgb(var(--oc-primary-600-rgb)) !important;
        }
        .outcraft-page .oc-primary-bg-soft {
            background-color: rgb(var(--oc-primary-200-rgb)) !important;
        }
        .outcraft-page .oc-primary-bg-soft-strong {
            background-color: rgb(var(--oc-primary-300-rgb)) !important;
        }
        .outcraft-page .group:hover .group-hover\:oc-primary-bg-soft-strong {
            background-color: rgb(var(--oc-primary-300-rgb)) !important;
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
        .outcraft-page .bg-blue-50,
        .outcraft-page .hover\:bg-blue-50:hover {
            background-color: rgb(var(--oc-info-50-rgb)) !important;
        }
        .outcraft-page .bg-blue-100,
        .outcraft-page .hover\:bg-blue-100:hover {
            background-color: rgb(var(--oc-info-100-rgb)) !important;
        }
        .outcraft-page .text-blue-500 {
            color: rgb(var(--oc-info-500-rgb)) !important;
        }
        .outcraft-page .text-blue-600,
        .outcraft-page .hover\:text-blue-600:hover {
            color: rgb(var(--oc-info-600-rgb)) !important;
        }
        .outcraft-page .text-blue-700,
        .outcraft-page .hover\:text-blue-700:hover {
            color: rgb(var(--oc-info-700-rgb)) !important;
        }
        .outcraft-page .text-blue-800 {
            color: rgb(var(--oc-info-800-rgb)) !important;
        }
        .outcraft-page .border-blue-200 {
            border-color: rgb(var(--oc-info-200-rgb)) !important;
        }
        .outcraft-page .ring-blue-100 {
            --tw-ring-color: rgb(var(--oc-info-100-rgb)) !important;
        }
        .outcraft-page .ring-blue-200 {
            --tw-ring-color: rgb(var(--oc-info-200-rgb)) !important;
        }
        .outcraft-page .ring-blue-600\/20 {
            --tw-ring-color: rgb(var(--oc-info-600-rgb) / 0.2) !important;
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
            vector-effect: non-scaling-stroke;
        }
        .outcraft-icon svg * {
            vector-effect: non-scaling-stroke;
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
        .outcraft-page main > section[data-outcraft-tab-header] {
            position: sticky;
            width: 100% !important;
            max-width: none !important;
            margin-left: 0 !important;
            margin-right: 0 !important;
        }
        .outcraft-page main > section[data-outcraft-dashboard-page] {
            width: 100% !important;
            max-width: none !important;
            margin-left: 0 !important;
            margin-right: 0 !important;
        }
        .outcraft-page main > section[data-outcraft-tab-header]::after {
            display: none;
        }
        .outcraft-page main > section[data-campaign-builder] {
            width: 100% !important;
            max-width: none !important;
            margin-left: 0 !important;
            margin-right: 0 !important;
        }
        .outcraft-mobile-main-nav {
            display: none;
        }
        .outcraft-page main > section[data-outcraft-tab-header] .outcraft-tab-menu-button {
            display: none !important;
        }
        .outcraft-page main > section[data-outcraft-tab-header] .outcraft-tab-scroll {
            min-height: 0;
            overflow-x: auto !important;
            overflow-y: clip !important;
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
        .outcraft-page main > section[data-outcraft-tab-header] .outcraft-tab-scroll::-webkit-scrollbar {
            display: none;
            width: 0;
            height: 0;
        }
        .outcraft-mobile-nav-backdrop {
            display: none;
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
            color: rgb(var(--oc-primary-600-rgb)) !important;
            background:
                linear-gradient(rgb(var(--oc-primary-50-rgb)), rgb(var(--oc-primary-50-rgb))) padding-box,
                conic-gradient(
                    from var(--outcraft-ai-border-angle),
                    rgb(var(--oc-primary-400-rgb) / 0.22),
                    rgb(var(--oc-primary-600-rgb) / 0.95),
                    rgb(var(--oc-primary-500-rgb) / 0.72),
                    rgb(var(--oc-primary-600-rgb) / 0.95),
                    rgb(var(--oc-primary-400-rgb) / 0.22)
                ) border-box;
            animation: outcraft-ai-border-spin 2.6s linear infinite;
        }
        .outcraft-ai-button:hover:not(:disabled) {
            color: rgb(var(--oc-primary-700-rgb)) !important;
            background:
                linear-gradient(rgb(var(--oc-primary-100-rgb)), rgb(var(--oc-primary-50-rgb))) padding-box,
                conic-gradient(
                    from var(--outcraft-ai-border-angle),
                    rgb(var(--oc-primary-400-rgb) / 0.32),
                    rgb(var(--oc-primary-600-rgb) / 1),
                    rgb(var(--oc-primary-500-rgb) / 0.86),
                    rgb(var(--oc-primary-600-rgb) / 1),
                    rgb(var(--oc-primary-400-rgb) / 0.32)
                ) border-box;
        }
        .outcraft-ai-button:disabled {
            color: #6b7280 !important;
            animation: none;
            background:
                linear-gradient(#ffffff, #ffffff) padding-box,
                linear-gradient(#d1d5db, #d1d5db) border-box;
        }
        .outcraft-dashboard-shortcut-tile {
            position: relative;
            overflow: hidden;
            border: 0;
            isolation: isolate;
        }
        .outcraft-dashboard-shortcut-tile::before {
            content: "";
            position: absolute;
            inset: 0;
            z-index: 0;
            border-radius: inherit;
            padding: 2px;
            opacity: 0;
            background:
                conic-gradient(
                    from var(--outcraft-ai-border-angle),
                    var(--shortcut-border-soft),
                    var(--shortcut-border-strong),
                    var(--shortcut-border-mid),
                    var(--shortcut-border-strong),
                    var(--shortcut-border-soft)
                );
            mask:
                linear-gradient(#000 0 0) content-box,
                linear-gradient(#000 0 0);
            mask-composite: exclude;
            -webkit-mask:
                linear-gradient(#000 0 0) content-box,
                linear-gradient(#000 0 0);
            -webkit-mask-composite: xor;
            transition: opacity 160ms ease;
        }
        .outcraft-dashboard-shortcut-tile > * {
            position: relative;
            z-index: 1;
        }
        .group:hover .outcraft-dashboard-shortcut-tile::before {
            opacity: 1;
            animation: outcraft-ai-border-spin 2.6s linear infinite;
        }
        .outcraft-dashboard-chat-message strong {
            font-weight: 600;
            color: #111827;
        }
        .outcraft-crafting-indicator {
            animation: outcraft-crafting-pulse 1.2s ease-in-out infinite;
        }
        @keyframes outcraft-crafting-pulse {
            0%, 100% {
                opacity: 0.38;
            }
            50% {
                opacity: 1;
            }
        }
        @media (prefers-reduced-motion: reduce) {
            .outcraft-crafting-indicator {
                animation: none;
                opacity: 1;
            }
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
                fill: rgb(var(--oc-primary-700-rgb));
            }
            50% {
                fill: rgb(var(--oc-primary-400-rgb));
            }
        }
        @keyframes outcraft-ai-sparkle-secondary {
            0%, 100% {
                fill: rgb(var(--oc-primary-400-rgb));
            }
            50% {
                fill: rgb(var(--oc-primary-700-rgb));
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
            .outcraft-page [data-sequence-timeline] {
                margin-top: -2.75rem !important;
            }
            .outcraft-page [data-company-details-step-layout] > :first-child > [data-step-icon-row][data-step-actions-local] {
                position: static !important;
                display: flex;
                align-items: center;
                justify-content: space-between;
                gap: 1rem;
                margin-bottom: 1rem !important;
            }
            .outcraft-page [data-company-details-step-layout] > :first-child > [data-step-icon-row][data-step-actions-local] > :not(:first-child) {
                margin-top: 0 !important;
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
                inset: 0 auto 0 0 !important;
                z-index: 80 !important;
                width: 20rem !important;
                max-width: calc(100vw - 3rem) !important;
                height: 100vh !important;
                max-height: none !important;
                flex-direction: column !important;
                border: 0 !important;
                border-right: 1px solid #e5e7eb !important;
                border-radius: 0 !important;
                box-shadow: 0 25px 50px -12px rgba(15, 23, 42, 0.25);
                transform: translateX(-100%);
                opacity: 1;
                pointer-events: none;
                transition: transform 200ms ease !important;
                overflow-y: auto !important;
            }
            .outcraft-page aside.mobile-nav-open {
                transform: translateX(0);
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
                display: grid !important;
                grid-template-columns: 2.5rem minmax(0, 1fr) auto !important;
                align-items: center !important;
                justify-content: flex-start !important;
                height: 44px !important;
                gap: 0.75rem !important;
                padding: 0 0.75rem !important;
                border-radius: 12px !important;
            }
            .outcraft-page aside nav button .outcraft-nav-icon-wrap {
                display: flex !important;
                width: 2.5rem !important;
                height: 2.5rem !important;
                align-items: center !important;
                justify-content: center !important;
            }
            .outcraft-page aside nav button .outcraft-nav-label {
                display: block !important;
                max-width: 190px !important;
                opacity: 1 !important;
                line-height: 1.25 !important;
            }
            .outcraft-page aside .pointer-events-none.absolute.left-full,
            .outcraft-page aside nav button > .outcraft-nav-tooltip,
            .outcraft-page aside button[class*="group/"] > span.pointer-events-none {
                display: none !important;
            }
            .outcraft-page main {
                margin-left: 0 !important;
                width: 100% !important;
                min-width: 0 !important;
                padding-bottom: 1rem !important;
            }
            .outcraft-mobile-main-nav {
                display: flex;
                align-items: center;
                gap: 0.75rem;
                transition-duration: 500ms !important;
                transition-timing-function: cubic-bezier(0.22, 1, 0.36, 1) !important;
            }
            .outcraft-page main > section[data-outcraft-tab-header] {
                top: 0 !important;
                isolation: isolate;
                background: rgb(255 255 255 / 0.5) !important;
                background-color: rgb(255 255 255 / 0.5) !important;
                backdrop-filter: blur(24px) saturate(1.4);
                -webkit-backdrop-filter: blur(24px) saturate(1.4);
                transition-duration: 500ms !important;
                transition-timing-function: cubic-bezier(0.22, 1, 0.36, 1) !important;
            }
            .outcraft-page main > section[data-outcraft-tab-header] > div {
                overflow: visible !important;
                background: transparent !important;
            }
            .outcraft-page main > section[data-outcraft-tab-header] > div > .mx-3 {
                margin-left: 0 !important;
                margin-right: 0 !important;
            }
            .outcraft-page main > section[data-outcraft-tab-header] .outcraft-tab-header-row {
                width: 100% !important;
                min-width: 0 !important;
            }
            .outcraft-page main > section[data-outcraft-tab-header] .outcraft-tab-scroll {
                overflow-x: auto !important;
                overflow-y: hidden !important;
                -webkit-overflow-scrolling: touch;
                scrollbar-width: none;
            }
            .outcraft-page main > section[data-outcraft-tab-header] .outcraft-tab-scroll::-webkit-scrollbar {
                display: none;
            }
            .outcraft-page main > section[data-outcraft-tab-header] nav {
                display: flex !important;
                width: max-content !important;
                min-width: 100% !important;
                flex-wrap: nowrap !important;
                gap: 2rem !important;
                padding-left: 2rem !important;
                padding-right: 1rem !important;
                white-space: nowrap !important;
            }
            .outcraft-page main > section[data-outcraft-tab-header] nav button {
                width: auto !important;
                min-width: max-content !important;
                flex: 0 0 auto !important;
                white-space: nowrap !important;
            }
            .outcraft-page main > section[data-outcraft-tab-header] .outcraft-tab-header-row > .outcraft-tab-menu-button {
                display: inline-flex !important;
                position: relative !important;
                left: auto !important;
                z-index: 20 !important;
                width: 2.5rem !important;
                min-width: 2.5rem !important;
                flex: 0 0 2.5rem !important;
                margin-left: 1rem !important;
                background-color: transparent !important;
                backdrop-filter: none;
                -webkit-backdrop-filter: none;
            }
            .outcraft-page main > section[data-outcraft-tab-header] nav button span:not(.outcraft-icon) {
                white-space: nowrap !important;
            }
            .outcraft-page main > section {
                width: calc(100% - 1rem) !important;
                max-width: calc(100% - 1rem) !important;
            }
            .outcraft-page main > section.rounded-lg,
            .outcraft-page main > section .rounded-lg {
                border-radius: var(--oc-card-radius) !important;
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
            .outcraft-page main > section:not([data-outcraft-tab-header]) > div.flex.h-11 {
                height: auto !important;
                display: grid !important;
                grid-template-columns: repeat(auto-fit, minmax(88px, 1fr)) !important;
                gap: 0.5rem !important;
            }
            .outcraft-page main > section:not([data-outcraft-tab-header]) > div.flex.h-11 button {
                width: 100% !important;
                height: 62px !important;
                flex-direction: column !important;
                justify-content: center !important;
                gap: 0.25rem !important;
                padding: 0.5rem !important;
                text-align: center !important;
            }
            .outcraft-page main > section:not([data-outcraft-tab-header]) > div.flex.h-11 button span:not(.outcraft-icon) {
                font-size: 12px !important;
                line-height: 1.1 !important;
                white-space: normal !important;
            }
            .outcraft-page section[x-show="leadDetailOpen"] > .grid {
                padding: 0 !important;
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
        @media (max-width: 900px) {
            .outcraft-page aside.outcraft-sidebar-collapsed,
            .outcraft-page aside {
                width: 20rem !important;
                max-width: calc(100vw - 3rem) !important;
                padding-left: 1.5rem !important;
                padding-right: 1.5rem !important;
            }
            .outcraft-page aside.outcraft-sidebar-collapsed > div:first-child,
            .outcraft-page aside > div:first-child {
                justify-content: flex-end !important;
            }
            .outcraft-page aside.outcraft-sidebar-collapsed > div:first-child > button:first-child,
            .outcraft-page aside > div:first-child > button:first-child {
                display: none !important;
            }
            .outcraft-page aside nav.tailwind-sidebar-nav {
                padding-top: 0.5rem !important;
            }
            .outcraft-page aside .outcraft-mobile-sidebar-close {
                display: inline-flex !important;
            }
            .outcraft-page aside .outcraft-sidebar-collapse-button {
                display: none !important;
            }
            .outcraft-page aside.outcraft-sidebar-collapsed nav button,
            .outcraft-page aside nav button {
                display: grid !important;
                grid-template-columns: 2.5rem minmax(0, 1fr) auto !important;
                align-items: center !important;
                gap: 0.75rem !important;
                padding: 0 0.75rem !important;
            }
            .outcraft-page aside.outcraft-sidebar-collapsed nav button .outcraft-nav-icon-wrap,
            .outcraft-page aside nav button .outcraft-nav-icon-wrap {
                display: flex !important;
                width: 2.5rem !important;
                height: 2.5rem !important;
                align-items: center !important;
                justify-content: center !important;
            }
            .outcraft-page aside.outcraft-sidebar-collapsed nav button .outcraft-nav-label,
            .outcraft-page aside nav button .outcraft-nav-label {
                display: block !important;
                max-width: 190px !important;
                opacity: 1 !important;
                line-height: 1.25 !important;
            }
            .outcraft-page aside .pointer-events-none.absolute.left-full,
            .outcraft-page aside nav button > .outcraft-nav-tooltip,
            .outcraft-page aside button[class*="group/"] > span.pointer-events-none {
                display: none !important;
            }
        }
    </style>
