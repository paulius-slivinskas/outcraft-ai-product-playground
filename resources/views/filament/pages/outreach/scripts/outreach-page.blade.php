    <script>
        const outcraftLucideAliases = {
            account_circle: 'circle-user-round',
            account_tree: 'git-fork',
            add: 'plus',
            ads_click: 'mouse-pointer-click',
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
            confirmation_number: 'ticket',
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
            keep: 'pin',
            keep_off: 'pin-off',
            language: 'globe',
            library_books: 'book-open',
            mail: 'mail',
            manage_search: 'search-check',
            monitoring: 'chart-spline',
            more_vert: 'ellipsis-vertical',
            notifications: 'bell',
	            payments: 'hand-coins',
            phone_callback: 'phone-call',
	            phone_in_talk: 'phone-call',
	            pause: 'pause',
	            play_arrow: 'play',
            play_circle: 'circle-play',
            package_check: 'package-check',
            psychology: 'brain',
            query_stats: 'chart-no-axes-column-increasing',
            radio_button_unchecked: 'circle',
            record_voice_over: 'speech',
            reply: 'reply',
	            report: 'triangle-alert',
	            receipt_text: 'receipt-text',
	            refresh: 'refresh-cw',
	            refresh_ccw: 'refresh-ccw',
            restart_alt: 'rotate-ccw',
            rocket_launch: 'rocket',
            save: 'save',
            schedule: 'clock',
            science: 'flask-conical',
            search: 'search',
            sell: 'tag',
            sentiment_satisfied: 'smile',
            settings: 'settings',
            sms: 'message-square-text',
            south_east: 'arrow-down-right',
            shopping_cart: 'shopping-cart',
            support_agent: 'headset',
            task_alt: 'circle-check-big',
            thumb_down: 'thumbs-down',
            thumb_up: 'thumbs-up',
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
                'stroke-width': 'var(--oc-icon-stroke-width, 1.5px)',
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

        function outcraftNormalizeSelectOptions(options, valueKey = null, labelKey = null, labelPrefix = '') {
            return (Array.isArray(options) ? options : []).map((option) => {
                if (option && typeof option === 'object') {
                    const value = valueKey ? option[valueKey] : (option.value ?? option.key ?? option.label);
                    const label = labelKey ? option[labelKey] : (option.label ?? option.name ?? value);

                    return {
                        value,
                        label: `${labelPrefix || ''}${label ?? ''}`,
                        disabled: Boolean(option.disabled),
                    };
                }

                return {
                    value: option,
                    label: `${labelPrefix || ''}${option ?? ''}`,
                    disabled: false,
                };
            });
        }

        function outcraftSelectLabel(value, options, valueKey = null, labelKey = null, labelPrefix = '', placeholder = 'Select an option') {
            const selected = outcraftNormalizeSelectOptions(options, valueKey, labelKey, labelPrefix)
                .find((option) => String(option.value) === String(value));

            return selected?.label || placeholder;
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
                radiusStorageVersion: 'v2',
                buttonRadius: '3xl',
                fieldRadius: 'md',
                cardRadius: 'xl',
                iconTileRadius: 'xl',
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
                shadowPanelOpen: false,
                shadowStorageVersion: 'v1',
                cardShadow: 'sm',
                cardBorderEnabled: true,
                fieldShadow: 'sm',
                buttonShadow: 'sm',
                dropdownShadow: 'lg',
                panelShadow: '2xl',
                shadowOptions: [
                    { key: 'none', label: 'None', className: 'shadow-none', value: '0 0 #0000', description: 'No drop shadow.' },
                    { key: '2xs', label: '2XS', className: 'shadow-2xs', value: '0 1px rgb(0 0 0 / 0.05)', description: 'Smallest Tailwind v4 shadow.' },
                    { key: 'xs', label: 'XS', className: 'shadow-xs', value: '0 1px 2px 0 rgb(0 0 0 / 0.05)', description: 'Very subtle field-level lift.' },
                    { key: 'sm', label: 'Small', className: 'shadow-sm', value: '0 1px 3px 0 rgb(0 0 0 / 0.10), 0 1px 2px -1px rgb(0 0 0 / 0.10)', description: 'Common Tailwind card/input shadow.' },
                    { key: 'default', label: 'Default', className: 'shadow', value: '0 1px 3px 0 rgb(0 0 0 / 0.10), 0 1px 2px -1px rgb(0 0 0 / 0.10)', description: 'Default Tailwind shadow utility.' },
                    { key: 'md', label: 'Medium', className: 'shadow-md', value: '0 4px 6px -1px rgb(0 0 0 / 0.10), 0 2px 4px -2px rgb(0 0 0 / 0.10)', description: 'Medium elevation for controls.' },
                    { key: 'lg', label: 'Large', className: 'shadow-lg', value: '0 10px 15px -3px rgb(0 0 0 / 0.10), 0 4px 6px -4px rgb(0 0 0 / 0.10)', description: 'Dropdown and popover elevation.' },
                    { key: 'xl', label: 'XL', className: 'shadow-xl', value: '0 20px 25px -5px rgb(0 0 0 / 0.10), 0 8px 10px -6px rgb(0 0 0 / 0.10)', description: 'Strong floating surface shadow.' },
                    { key: '2xl', label: '2XL', className: 'shadow-2xl', value: '0 25px 50px -12px rgb(0 0 0 / 0.25)', description: 'Tailwind modal/panel depth.' },
                    { key: 'inner', label: 'Inner', className: 'shadow-inner', value: 'inset 0 2px 4px 0 rgb(0 0 0 / 0.05)', description: 'Inset shadow for pressed surfaces.' },
                ],
                tabsPanelOpen: false,
                topNavTabIconsEnabled: true,
                topNavTabStyle: 'underline',
                topNavTabStyleOptions: [
                    {
                        key: 'underline',
                        label: 'Underline',
                        className: 'tabs with underline',
                        description: 'Tailwind UI baseline tabs with bottom border.',
                        previewClass: 'border-b border-gray-200',
                        previewItemClass: 'border-b-2 border-indigo-500 px-1 py-2 text-xs font-medium text-indigo-600',
                        previewMutedClass: 'border-b-2 border-transparent px-1 py-2 text-xs font-medium text-gray-500',
                    },
                    {
                        key: 'underline-icons',
                        label: 'Underline + Icons',
                        className: 'tabs with icons',
                        description: 'Same underline pattern, optimized for icon + text tabs.',
                        previewClass: 'border-b border-gray-200',
                        previewItemClass: 'border-b-2 border-indigo-500 px-1 py-2 text-xs font-medium text-indigo-600',
                        previewMutedClass: 'border-b-2 border-transparent px-1 py-2 text-xs font-medium text-gray-500',
                    },
                    {
                        key: 'full-width',
                        label: 'Full Width Underline',
                        className: 'full width tabs',
                        description: 'Equal-width tabs with centered labels.',
                        previewClass: 'grid grid-cols-3 border-b border-gray-200',
                        previewItemClass: 'border-b-2 border-indigo-500 px-1 py-2 text-center text-xs font-medium text-indigo-600',
                        previewMutedClass: 'border-b-2 border-transparent px-1 py-2 text-center text-xs font-medium text-gray-500',
                    },
                    {
                        key: 'pills',
                        label: 'Pills',
                        className: 'tabs in pills',
                        description: 'Rounded neutral active state without bottom rule.',
                        previewClass: '',
                        previewItemClass: 'rounded-md bg-gray-100 px-2.5 py-1.5 text-xs font-medium text-gray-700',
                        previewMutedClass: 'rounded-md px-2.5 py-1.5 text-xs font-medium text-gray-500',
                    },
                    {
                        key: 'pills-gray',
                        label: 'Pills On Gray',
                        className: 'pills on gray',
                        description: 'Subtle gray active pill from Tailwind UI.',
                        previewClass: 'rounded-lg bg-gray-100 p-1',
                        previewItemClass: 'rounded-md bg-white px-2.5 py-1.5 text-xs font-medium text-gray-800 shadow-sm',
                        previewMutedClass: 'rounded-md px-2.5 py-1.5 text-xs font-medium text-gray-600',
                    },
                    {
                        key: 'bar',
                        label: 'Bar With Underline',
                        className: 'bar underline',
                        description: 'Divided bar with active underline.',
                        previewClass: 'divide-x divide-gray-200 rounded-lg bg-white shadow-sm ring-1 ring-gray-200',
                        previewItemClass: 'relative px-2.5 py-2 text-center text-xs font-medium text-gray-900 underline decoration-indigo-500 decoration-2 underline-offset-8',
                        previewMutedClass: 'px-2.5 py-2 text-center text-xs font-medium text-gray-500',
                    },
                    {
                        key: 'simple',
                        label: 'Simple',
                        className: 'simple tabs',
                        description: 'Text-first tabs with a quiet bottom rule.',
                        previewClass: 'border-b border-gray-200 py-2',
                        previewItemClass: 'px-1 text-xs font-semibold text-indigo-600',
                        previewMutedClass: 'px-1 text-xs font-semibold text-gray-500',
                    },
                ],
                typographyPanelOpen: false,
                typographyStorageVersion: 'v6',
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
                leadInteractionChannelMenuOpen: false,
                selectedLeadInteractionChannels: ['Call', 'Email', 'SMS', 'WhatsApp'],
                leadInteractionFeedbackRating: '',
                leadInteractionFeedbackText: '',
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
                progressBarStyle: 'bulletlist',
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
                channelsAdvancedOpen: false,
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
                demoAnalyticsBar: 'No Decision',
                activeAnalyticsCampaign: 'All Campaigns',
                activeAnalyticsOutcomeMetric: 'Orders Saved',
                activeAnalyticsOutcomeMenuOpen: false,
                activeAnalyticsRange: 'Last 7 Days',
                analyticsCustomRangeStart: '2026-05-01',
                analyticsCustomRangeEnd: '2026-05-28',
                activeReplyTimingRegion: 'us-east',
                activeReplyTimingHour: '09:00',
                highlightedConversationMetrics: [],
                demoAnalyticsTimelineView: 'area',
                demoAnalyticsApexChart: null,
                demoAnalyticsApexRenderFrame: null,
                demoAnalyticsApexRenderToken: 0,
                demoAnalyticsApexResizeObserver: null,
                activeAnalyticsTimelineMetric: 'Engaged',
                activeAnalyticsTimelineMetrics: ['Campaign Runs', 'Engaged', 'Successful Outcomes'],
                activeAnalyticsTimelineMetricMenuOpen: false,
                showAnalyticsPreviousPeriod: false,
                analyticsHeadingMenuOpen: false,
                demoAnalyticsChartMenuOpen: false,
                topNavHeaderVisible: true,
                topNavLastScrollTop: 0,
                analyticsStickyControlsVisible: false,
                selectedEngagementChannels: ['Emails', 'SMS', 'WhatsApp', 'Calls'],
                engagementTimelineView: 'area',
                engagementChartMenuOpen: false,
                engagementApexCharts: {},
                engagementApexRenderFrames: {},
                engagementApexRenderTokens: {},
                engagementApexResizeObservers: {},
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
                    { label: 'Dashboard', icon: 'dashboard' },
                    { label: 'Campaigns', icon: 'format_list_bulleted' },
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
                        id: 'example-saas',
                        name: 'Example SaaS',
                        website: 'example.com',
                        industry: 'SaaS',
                        description: 'AI outreach platform for campaign setup, lead conversations, and automated follow-up.',
                        problem: 'Teams need faster outreach setup without losing context or personalization.',
                        differentiators: 'AI-guided setup, reusable company context, custom fields, and multi-channel campaign orchestration.',
                        icp: 'Growth teams, agencies, and sales-led SaaS companies running outbound or lifecycle campaigns.',
                        faqs: 'Q: Can AI book meetings?\nA: Yes, when booking is enabled and a calendar link is provided.\n\nQ: Can it use merge tags?\nA: Yes, connected lead sources can provide custom fields.',
                        supportEmail: 'support@example.com',
                        termsUrl: 'https://example.com/terms-of-service',
                        privacyUrl: 'https://example.com/privacy-policy',
                        certifications: 'SOC2',
                        compliance: 'GDPR, CCPA',
                    },
                    {
                        id: 'example-wellness',
                        name: 'Example Wellness',
                        website: 'example.com',
                        industry: 'Ecommerce',
                        description: 'Wellness device brand helping customers manage stress, sleep, and relaxation routines.',
                        problem: 'Customers need clear guidance before choosing a wellness device and may need help after checkout.',
                        differentiators: 'Portable device, approachable education, fast customer support, and practical wellness routines.',
                        icp: 'Health-conscious consumers, busy professionals, and customers researching stress or sleep support.',
                        faqs: 'Q: Is the product easy to use?\nA: Yes, setup is designed to be simple.\n\nQ: Can customers get support?\nA: Yes, support can help with product and delivery questions.',
                        supportEmail: 'support@example.com',
                        termsUrl: 'https://example.com/terms-of-service',
                        privacyUrl: 'https://example.com/privacy-policy',
                        certifications: '',
                        compliance: 'GDPR',
                    },
                    {
                        id: 'example-commerce',
                        name: 'Example Commerce',
                        website: 'example.com',
                        industry: 'Ecommerce',
                        description: 'Retail brand selling curated home, lifestyle, and seasonal product bundles.',
                        problem: 'Shoppers abandon carts when they need timing, delivery, or product-fit reassurance.',
                        differentiators: 'Curated bundles, fast delivery, seasonal offers, and practical post-purchase support.',
                        icp: 'Online shoppers who browse product bundles, abandon checkout, or respond to seasonal offers.',
                        faqs: 'Q: Do you offer discounts?\nA: Campaign-specific discounts may be available.\n\nQ: Can shoppers recover their cart?\nA: Yes, abandoned cart links can be sent when enabled.',
                        supportEmail: 'support@example.com',
                        termsUrl: 'https://example.com/terms-of-service',
                        privacyUrl: 'https://example.com/privacy-policy',
                        certifications: '',
                        compliance: 'GDPR, CCPA',
                    },
                ],
                companySetupSteps: [
                    { label: 'Create or Choose Company', description: 'Select an existing profile or start fresh.', icon: 'apartment' },
                    { label: 'Add Basic Company Details', description: 'Brand name, website, and pronunciation.', icon: 'fingerprint' },
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
		                    { id: 'followups', label: 'Follow-Up Sequence', description: 'Response-based follow-up sequences.', group: 'Outreach' },
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
	                    languageAccordionOpen: 'US',
	                    languageBatchModalOpen: false,
	                    languageBatchSelection: [],
                    languageSearch: '',
                    languages: [{ code: 'US', label: 'US', name: 'English', flagCode: 'us' }],
                    agentName: 'Bridget',
                    voice: 'Bridget (Ultra-realistic)',
                    emailSignature: "Best,\nBridget from Example",
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
	                    cartLinkStructure: '@{{cart_url}}?utm_source=example&utm_medium=email&utm_campaign=cart-recovery',
	                    customizeCartLink: false,
                    cartPath: '/checkout',
                    utmSource: 'example',
                    utmMedium: 'email',
                    utmCampaign: 'cart-recovery',
                    dynamicParameterName: 'affid',
                    dynamicParameterValue: '',
                    shortenLinks: false,
	                    shortLinkBrand: 'example',
	                    offerInfo: 'Mention that the deliverability checklist takes Less Than 10 minutes to review.',
			                    scheduleMode: 'business',
			                    allDay: false,
	                    outreachDays: ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'],
	                    outreachStartHour: '09:00',
	                    outreachEndHour: '17:00',
	                    calendarService: '',
	                    calendarConnectionStatus: '',
	                    bookingCallLink: 'https://example.com/book-demo',
	                    bookingEmailLink: '',
	                    bookingSmsLink: '',
	                    whatsappConnectionStatus: '',
	                    physicalAddressModalOpen: false,
	                    physicalAddressFormOpen: false,
	                    physicalAddressForm: {
	                        provider: 'Twilio',
	                        businessLocation: 'United States',
	                        representativeFirstName: '',
	                        representativeLastName: '',
	                        businessPhone: '',
	                        businessName: '',
	                        addressLine1: '',
	                        addressLine2: '',
	                        city: '',
	                        state: '',
	                        postalCode: '',
	                    },
	                    physicalAddresses: [
	                        {
	                            id: 1,
	                            provider: 'Twilio',
	                            companyName: 'Example Company, Inc.',
	                            representativeFirstName: 'Paulius',
	                            representativeLastName: 'Slivinskas',
	                            businessPhone: '+12025550123',
	                            companyLocation: 'United States',
	                            addressLine1: '228 Park Ave S',
	                            addressLine2: '',
	                            city: 'New York',
	                            state: 'NY',
	                            zipCode: '10003',
	                        },
	                    ],
	                    phoneNumberModalOpen: false,
	                    phoneNumberForm: {
	                        provider: 'Twilio',
	                        country: 'United States',
	                        state: 'Select an option',
	                    },
	                    phoneNumbers: [
	                        { number: '+13608605385', campaign: 'Example Campaign', country: 'US', state: 'Washington', status: 'Active' },
	                        { number: '+15187596963', campaign: 'Example Campaign', country: 'US', state: 'New York', status: 'Active' },
	                    ],
		                    smsTriggers: ['Positive Response'],
		                    callGuidelines: '',
		                    smsGuidelines: 'Keep it under 1 sentence, add a full URL to the product: https://example.com/product, and attach a discount code.',
	                    emailGuidelines: '',
	                    whatsappGuidelines: '',
	                    mailboxModalOpen: false,
	                    mailboxProvider: 'Microsoft 365 or Outlook',
	                    mailboxEmail: '',
	                    mailboxes: [
	                        { email: 'sales@example.com', provider: 'Microsoft 365', status: 'Connected', connectedAgo: '4 months ago', connectedAt: 'Connected on January 24, 2026 at 10:15 AM' },
	                        { email: 'support@example.com', provider: 'Google Workspace', status: 'Connected', connectedAgo: '2 weeks ago', connectedAt: 'Connected on May 12, 2026 at 2:40 PM' },
	                    ],
	                    handoff: false,
	                    followupsEnabled: false,
	                    followupPositive: false,
	                    followupEngaged: false,
	                    followupNegative: false,
	                    activeFollowupSequence: 'positive',
	                    followupLayoutOption: 'option2',
	                    followupOptionMenuOpen: false,
	                    followupActionOpen: '',
	                    followupEditingSequence: null,
	                    followupEditingIndex: null,
	                    followupForm: {
	                        type: 'Initial Email',
	                    },
	                    followupSequences: {
	                        positive: [
	                            { id: 'positive-followup-1', channel: 'Email', label: 'initial_email', delay: '1 day', delayAmount: 1, delayUnit: 'Days', step: 'Check in after the positive response and confirm the next best step.' },
	                            { id: 'positive-followup-2', channel: 'SMS', label: 'ping_sms', delay: '3 days', delayAmount: 3, delayUnit: 'Days', step: 'Send a short reminder if the lead has not completed the next step.' },
	                            { id: 'positive-followup-3', channel: 'None', label: 'campaign_end', delay: '5 days', delayAmount: 5, delayUnit: 'Days', step: 'End the follow-up sequence if no further action is needed.' },
	                        ],
	                        engaged: [
	                            { id: 'engaged-followup-1', channel: 'Call', label: 'ping_call', delay: '4 hours', delayAmount: 4, delayUnit: 'Hours', step: 'Call to answer remaining questions and help the lead reach a decision.' },
	                            { id: 'engaged-followup-2', channel: 'Email', label: 'ping_email', delay: '1 day', delayAmount: 1, delayUnit: 'Days', step: 'Share supporting information based on the lead’s objections or interests.' },
	                            { id: 'engaged-followup-3', channel: 'SMS', label: 'ping_sms', delay: '2 days', delayAmount: 2, delayUnit: 'Days', step: 'Send a concise prompt asking whether they want to continue.' },
	                        ],
	                        negative: [
	                            { id: 'negative-followup-1', channel: 'Email', label: 'breakup_email', delay: '2 days', delayAmount: 2, delayUnit: 'Days', step: 'Send a helpful response that addresses the stated objection without pressure.' },
	                            { id: 'negative-followup-2', channel: 'None', label: 'campaign_end', delay: '5 days', delayAmount: 5, delayUnit: 'Days', step: 'End the sequence if the lead does not re-engage.' },
	                        ],
	                    },
	                    handoffPositive: false,
	                    handoffRequested: false,
	                    handoffScenario: '',
	                    handoffChannel: '',
	                    handoffNotificationEmail: 'support@example.com',
	                    knowledgePublished: false,
                    evaluationFormat: 'Text Summary',
                    sequenceModalOpen: false,
                    sequenceActionOpen: '',
                    sequenceEditingIndex: null,
                    sequenceForm: {
                        type: 'Initial Call',
                        delay: '-',
                    },
                    delayModalOpen: false,
                    delayEditingScope: '',
                    delayEditingSequence: '',
                    delayEditingIndex: null,
                    delayForm: {
                        delayAmount: 0,
                        delayUnit: 'Immediately',
                    },
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
	                        context: 'Send customers a helpful update after they interact with an example resource, confirm interest, and offer the next best step.',
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
	                        manualPricing: 'Example Plan - 251 EUR special offer.\nExample Lite - 233 EUR special offer.',
	                        canNegotiatePrice: false,
	                        priceNegotiationPercent: '10',
	                        neverAskFor: 'Credit card information\nBanking details\nPasswords or account credentials',
	                        neverPromise: 'Specific discounts\nRefunds\nDelivery dates\nGuaranteed results',
	                        neverDiscuss: 'Unrelated topics\nDetailed competitor breakdowns\nRefund approvals',
	                        importantRules: '- Do not promise pricing, delivery, or legal terms unless available in source data.\n- Keep questions short and ask one thing at a time.',
	                        shortConversationInstructions: {
	                            introduction: 'Greet warmly, say your name and the reason why you are calling. Be short.',
	                            engagement: 'Ask if it’s a good time to talk. If yes: continue. If no: ensure it will be super quick and ask naturally just 30 seconds you will let them go. Wait for answer. If again no: ask if there is a good time to call back.',
	                            qualification: 'Identify needs, challenges, or context with qualification questions (ask questions one at a time).',
	                            solutionAlignment: 'Share one relevant benefit per answer. Keep it short.',
	                            nextSteps: 'Suggest @{{call_goal}} as the next step, confidently.',
	                            closing: 'Thank them warmly, wish them well. Wait for their closing phrase before saying goodbye.',
	                        },
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
                    { id: 'sequence-step-1', channel: 'Call', label: 'initial_call', delay: '0 minutes', delayAmount: 0, delayUnit: 'Immediately', step: 'Initial outbound call to a lead introducing the company/product and the campaign offer' },
                    { id: 'sequence-step-2', channel: 'Call', label: 'initial_call', delay: '4 hours', delayAmount: 4, delayUnit: 'Hours', step: 'Initial outbound call to a lead introducing the company/product and the campaign offer' },
                    { id: 'sequence-step-3', channel: 'SMS', label: 'initial_sms', delay: '1 day', delayAmount: 1, delayUnit: 'Days', step: 'Initial outbound SMS to the lead regarding the campaign' },
                    { id: 'sequence-step-4', channel: 'Call', label: 'initial_call', delay: '1 day', delayAmount: 1, delayUnit: 'Days', step: 'Initial outbound call to a lead introducing the company/product and the campaign offer' },
                    { id: 'sequence-step-5', channel: 'Call', label: 'initial_call', delay: '2 days', delayAmount: 2, delayUnit: 'Days', step: 'Initial outbound call to a lead introducing the company/product and the campaign offer' },
                    { id: 'sequence-step-6', channel: 'Call', label: 'initial_call', delay: '4 days', delayAmount: 4, delayUnit: 'Days', step: 'Initial outbound call to a lead introducing the company/product and the campaign offer' },
                    { id: 'sequence-step-7', channel: 'None', label: 'campaign_end', delay: '2 days', delayAmount: 2, delayUnit: 'Days', step: 'Indicates the end of a campaign flow. No further actions will be taken for this lead in the current campaign.' },
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
                    { label: 'Conversation Intelligence', icon: 'psychology' },
                ],
                engagementChannels: [
                    { label: 'Emails', icon: 'mail' },
                    { label: 'SMS', icon: 'sms' },
                    { label: 'WhatsApp', icon: 'message_circle' },
                    { label: 'Calls', icon: 'call' },
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
                            { kind: 'ai', speaker: 'AI', text: 'For sleep and stress, the standard example plan should be enough. If you want bulk pricing, I can help route that to the team.' },
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
                        summary: 'User called to clarify a special deal for Example Company, confirmed understanding of the two product models, asked about shipping and bulk discounts, and indicated readiness to place an order.',
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
                            { kind: 'ai', speaker: 'AI', text: 'Hey Billie, this is Casey calling from Example Company. I wanted to check in and help you finish setting up your device.' },
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
                                text: 'Billie, your Example Company cart is still open. Use code PLUS10 for an extra 10 off plus a 30-day money-back guarantee: https://example.com/checkout?... Example Team',
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
                        this.tabsPanelOpen = false;
                        this.typographyPanelOpen = false;
                        this.shadowPanelOpen = false;
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
                        this.tabsPanelOpen = false;
                        this.typographyPanelOpen = false;
                        this.shadowPanelOpen = false;
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
                        this.tabsPanelOpen = false;
                        this.typographyPanelOpen = false;
                        this.shadowPanelOpen = false;
                    }
                },
                initializeTabsTheme() {
                    const storedStyle = this.storedTopNavTabStyle();
                    const storedTopNavTabIcons = this.storedTopNavTabIconsEnabled();

                    if (storedStyle && this.topNavTabStyleOptions.some((option) => option.key === storedStyle)) {
                        this.topNavTabStyle = storedStyle;
                    }

                    if (storedTopNavTabIcons !== null) {
                        this.topNavTabIconsEnabled = storedTopNavTabIcons === 'true';
                    }
                },
                handleTabsShortcut(event) {
                    const tagName = String(event.target?.tagName || '').toLowerCase();
                    const isTyping = event.target?.isContentEditable || ['input', 'textarea', 'select'].includes(tagName);

                    if (isTyping || event.metaKey || event.ctrlKey || event.altKey || event.shiftKey) {
                        return;
                    }

                    if (String(event.key || '').toLowerCase() !== 'y') {
                        return;
                    }

                    event.preventDefault();
                    this.tabsPanelOpen = ! this.tabsPanelOpen;

                    if (this.tabsPanelOpen) {
                        this.primaryThemePanelOpen = false;
                        this.radiusPanelOpen = false;
                        this.iconStrokePanelOpen = false;
                        this.typographyPanelOpen = false;
                        this.shadowPanelOpen = false;
                    }
                },
                initializeShadowTheme() {
                    const storedCardBorder = this.storedCardBorderEnabled();

                    ['card', 'field', 'button', 'dropdown', 'panel'].forEach((type) => {
                        const storedShadow = this.storedShadowTheme(type);
                        const property = `${type}Shadow`;

                        if (storedShadow && property in this && this.shadowOptions.some((shadow) => shadow.key === storedShadow)) {
                            this[property] = storedShadow;
                        }
                    });

                    if (storedCardBorder !== null) {
                        this.cardBorderEnabled = storedCardBorder === 'true';
                    }

                    this.applyShadowTheme();
                },
                handleShadowShortcut(event) {
                    const tagName = String(event.target?.tagName || '').toLowerCase();
                    const isTyping = event.target?.isContentEditable || ['input', 'textarea', 'select'].includes(tagName);

                    if (isTyping || event.metaKey || event.ctrlKey || event.altKey || event.shiftKey) {
                        return;
                    }

                    if (String(event.key || '').toLowerCase() !== 's') {
                        return;
                    }

                    event.preventDefault();
                    this.shadowPanelOpen = ! this.shadowPanelOpen;

                    if (this.shadowPanelOpen) {
                        this.primaryThemePanelOpen = false;
                        this.radiusPanelOpen = false;
                        this.iconStrokePanelOpen = false;
                        this.tabsPanelOpen = false;
                        this.typographyPanelOpen = false;
                    }
                },
                initializeProgressBarStyle() {
                    this.progressBarStyle = 'bulletlist';
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
                        return window.localStorage.getItem(`outcraft-radius-${this.radiusStorageVersion}-${type}`);
                    } catch (error) {
                        return null;
                    }
                },
                persistRadiusTheme(type, key) {
                    try {
                        window.localStorage.setItem(`outcraft-radius-${this.radiusStorageVersion}-${type}`, key);
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
                storedShadowTheme(type) {
                    try {
                        return window.localStorage.getItem(`outcraft-shadow-${this.shadowStorageVersion}-${type}`);
                    } catch (error) {
                        return null;
                    }
                },
                persistShadowTheme(type, key) {
                    try {
                        window.localStorage.setItem(`outcraft-shadow-${this.shadowStorageVersion}-${type}`, key);
                    } catch (error) {
                        // Shadow preview still works for the current session if storage is unavailable.
                    }
                },
                storedCardBorderEnabled() {
                    try {
                        return window.localStorage.getItem(`outcraft-shadow-${this.shadowStorageVersion}-card-border-enabled`);
                    } catch (error) {
                        return null;
                    }
                },
                persistCardBorderEnabled() {
                    try {
                        window.localStorage.setItem(`outcraft-shadow-${this.shadowStorageVersion}-card-border-enabled`, String(this.cardBorderEnabled));
                    } catch (error) {
                        // Border preview still works for the current session if storage is unavailable.
                    }
                },
                toggleCardBorder() {
                    this.cardBorderEnabled = ! this.cardBorderEnabled;
                    this.persistCardBorderEnabled();
                    this.applyShadowTheme();
                },
                setShadowTheme(type, key) {
                    if (! this.shadowOptions.some((shadow) => shadow.key === key)) {
                        return;
                    }

                    const property = `${type}Shadow`;

                    if (! (property in this)) {
                        return;
                    }

                    this[property] = key;
                    this.persistShadowTheme(type, key);
                    this.applyShadowTheme();
                },
                shadowOption(key) {
                    return this.shadowOptions.find((shadow) => shadow.key === key)
                        || this.shadowOptions.find((shadow) => shadow.key === 'sm')
                        || this.shadowOptions[0];
                },
                selectedShadowLabel(key) {
                    return this.shadowOption(key)?.className || 'shadow-sm';
                },
                applyShadowTheme() {
                    if (! this.$root) {
                        return;
                    }

                    this.$root.style.setProperty('--oc-card-shadow', this.shadowOption(this.cardShadow).value);
                    this.$root.style.setProperty('--oc-field-shadow', this.shadowOption(this.fieldShadow).value);
                    this.$root.style.setProperty('--oc-button-shadow', this.shadowOption(this.buttonShadow).value);
                    this.$root.style.setProperty('--oc-dropdown-shadow', this.shadowOption(this.dropdownShadow).value);
                    this.$root.style.setProperty('--oc-panel-shadow', this.shadowOption(this.panelShadow).value);
                    this.$root.dataset.cardShadow = this.cardShadow;
                    this.$root.dataset.cardBorder = this.cardBorderEnabled ? 'true' : 'false';
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
                storedTopNavTabIconsEnabled() {
                    try {
                        return window.localStorage.getItem('outcraft-top-nav-tab-icons-enabled');
                    } catch (error) {
                        return null;
                    }
                },
                persistTopNavTabIconsEnabled() {
                    try {
                        window.localStorage.setItem('outcraft-top-nav-tab-icons-enabled', String(this.topNavTabIconsEnabled));
                    } catch (error) {
                        // The toggle still works for the current session if storage is unavailable.
                    }
                },
                toggleTopNavTabIcons() {
                    this.topNavTabIconsEnabled = ! this.topNavTabIconsEnabled;
                    this.persistTopNavTabIconsEnabled();
                    this.$nextTick(() => renderOutcraftIcons(this.$root));
                },
                storedTopNavTabStyle() {
                    try {
                        return window.localStorage.getItem('outcraft-top-nav-tab-style');
                    } catch (error) {
                        return null;
                    }
                },
                persistTopNavTabStyle() {
                    try {
                        window.localStorage.setItem('outcraft-top-nav-tab-style', this.topNavTabStyle);
                    } catch (error) {
                        // Tab style preview still works for the current session if storage is unavailable.
                    }
                },
                setTopNavTabStyle(key) {
                    if (! this.topNavTabStyleOptions.some((option) => option.key === key)) {
                        return;
                    }

                    this.topNavTabStyle = key;
                    this.persistTopNavTabStyle();
                    this.$nextTick(() => renderOutcraftIcons(this.$root));
                },
                topNavTabStyleOption(key) {
                    return this.topNavTabStyleOptions.find((option) => option.key === key)
                        || this.topNavTabStyleOptions.find((option) => option.key === 'underline')
                        || this.topNavTabStyleOptions[0];
                },
                topNavTabShellClass() {
                    if (this.topNavTabStyle === 'pills' || this.topNavTabStyle === 'bar') {
                        return 'px-0 py-3';
                    }

                    if (this.topNavTabStyle === 'pills-gray') {
                        return 'bg-gray-50 px-0 py-3';
                    }

                    return '';
                },
                topNavTabListClass() {
                    if (this.topNavTabStyle === 'full-width') {
                        return '-mb-px flex';
                    }

                    if (this.topNavTabStyle === 'pills') {
                        return 'flex space-x-4';
                    }

                    if (this.topNavTabStyle === 'pills-gray') {
                        return 'inline-flex space-x-1 rounded-lg bg-gray-100 p-1';
                    }

                    if (this.topNavTabStyle === 'bar') {
                        return 'isolate flex divide-x divide-gray-200 rounded-lg bg-white shadow-sm ring-1 ring-gray-200';
                    }

                    if (this.topNavTabStyle === 'simple') {
                        return 'flex min-w-full flex-none gap-x-8 px-2 py-4 text-sm font-semibold';
                    }

                    return '-mb-px flex space-x-8';
                },
                topNavTabButtonClass(isActive, index = 0, count = 1) {
                    if (this.topNavTabStyle === 'full-width') {
                        return [
                            'group inline-flex flex-1 items-center justify-center border-b-2 px-1 py-4 text-center text-sm font-medium transition',
                            isActive ? 'oc-primary-border oc-primary-text' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700',
                        ].join(' ');
                    }

                    if (this.topNavTabStyle === 'pills') {
                        return [
                            'group inline-flex items-center rounded-md px-3 py-2 text-sm font-medium transition',
                            isActive ? 'bg-gray-100 text-gray-700' : 'text-gray-500 hover:text-gray-700',
                        ].join(' ');
                    }

                    if (this.topNavTabStyle === 'pills-gray') {
                        return [
                            'group inline-flex items-center rounded-md px-3 py-2 text-sm font-medium transition',
                            isActive ? 'bg-white text-gray-800 shadow-sm' : 'text-gray-600 hover:text-gray-800',
                        ].join(' ');
                    }

                    if (this.topNavTabStyle === 'bar') {
                        const rounded = index === 0 ? 'rounded-l-lg' : (index === count - 1 ? 'rounded-r-lg' : '');

                        return [
                            'group relative inline-flex min-w-0 flex-1 items-center justify-center overflow-hidden px-4 py-4 text-center text-sm font-medium transition focus:z-10',
                            rounded,
                            isActive ? 'border-b-2 oc-primary-border text-gray-900' : 'border-b-2 border-transparent text-gray-500 hover:bg-gray-50 hover:text-gray-700',
                        ].join(' ');
                    }

                    if (this.topNavTabStyle === 'simple') {
                        return [
                            'group inline-flex items-center px-1 text-sm font-semibold transition',
                            isActive ? 'oc-primary-text' : 'text-gray-500 hover:text-gray-700',
                        ].join(' ');
                    }

                    return [
                        'group inline-flex items-center border-b-2 px-1 py-4 text-sm font-medium transition',
                        isActive ? 'oc-primary-border oc-primary-text' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700',
                    ].join(' ');
                },
                topNavMenuButtonClass() {
                    if (this.topNavTabStyle === 'full-width') {
                        return 'outcraft-tab-menu-button inline-flex w-14 flex-none items-center justify-center border-b-2 border-transparent py-4 text-gray-500 transition hover:border-gray-300 hover:text-gray-700';
                    }

                    if (this.topNavTabStyle === 'pills') {
                        return 'outcraft-tab-menu-button inline-flex items-center justify-center rounded-md px-3 py-2 text-gray-500 transition hover:bg-gray-100 hover:text-gray-700';
                    }

                    if (this.topNavTabStyle === 'pills-gray') {
                        return 'outcraft-tab-menu-button inline-flex items-center justify-center rounded-md px-3 py-2 text-gray-600 transition hover:bg-white hover:text-gray-800';
                    }

                    if (this.topNavTabStyle === 'bar') {
                        return 'outcraft-tab-menu-button relative inline-flex w-14 flex-none items-center justify-center rounded-l-lg border-b-2 border-transparent px-4 py-4 text-gray-500 transition hover:bg-gray-50 hover:text-gray-700 focus:z-10';
                    }

                    if (this.topNavTabStyle === 'simple') {
                        return 'outcraft-tab-menu-button inline-flex items-center justify-center px-1 text-gray-500 transition hover:text-gray-700';
                    }

                    return 'outcraft-tab-menu-button inline-flex items-center justify-center border-b-2 border-transparent px-1 py-4 text-gray-500 transition hover:border-gray-300 hover:text-gray-700';
                },
                topNavTabIconClass(isActive) {
                    return [
                        'mr-2 -ml-0.5',
                        isActive ? 'oc-primary-text' : 'text-gray-400 group-hover:text-gray-500',
                    ].join(' ');
                },
                topNavHeaderClass() {
                    return this.topNavHeaderVisible ? 'translate-y-0' : '-translate-y-full';
                },
                topNavSectionActive() {
                    return this.activeNav === 'Campaigns'
                        || this.activeNav === 'Analytics'
                        || (this.activeNav === 'Leads' && ! this.leadDetailOpen);
                },
                handleTopNavWheel(event) {
                    const header = event?.currentTarget;
                    const scroller = header?.querySelector('.outcraft-tab-scroll')
                        || header?.querySelector(':scope > div');

                    if (! scroller || scroller.scrollWidth <= scroller.clientWidth) {
                        return;
                    }

                    const delta = Math.abs(event.deltaX) > Math.abs(event.deltaY)
                        ? event.deltaX
                        : event.deltaY;

                    if (! delta) {
                        return;
                    }

                    event.preventDefault();
                    scroller.scrollLeft += delta;
                },
                updateAnalyticsStickyControlsVisibility(scrollTop = null) {
                    const currentScrollTop = scrollTop ?? Math.max(0, Number(this.$refs.workspaceMain?.scrollTop || 0));
                    const inlineControls = this.$refs.analyticsInlineControls;

                    if (this.activeNav !== 'Analytics' || ! inlineControls) {
                        this.analyticsStickyControlsVisible = false;
                        return;
                    }

                    const controlsBottom = Number(inlineControls.offsetTop || 0) + Number(inlineControls.offsetHeight || 0);
                    this.analyticsStickyControlsVisible = currentScrollTop > controlsBottom;
                },
                resetTopNavHeaderScroll() {
                    const scrollTop = Math.max(0, Number(this.$refs.workspaceMain?.scrollTop || 0));

                    this.topNavLastScrollTop = scrollTop;
                    this.topNavHeaderVisible = true;
                    this.updateAnalyticsStickyControlsVisibility(scrollTop);
                },
                handleWorkspaceScroll(event) {
                    const scrollTop = Math.max(0, Number(event?.target?.scrollTop || 0));
                    const delta = scrollTop - this.topNavLastScrollTop;
                    this.updateAnalyticsStickyControlsVisibility(scrollTop);

                    if (scrollTop <= 4) {
                        this.topNavHeaderVisible = true;
                        this.topNavLastScrollTop = scrollTop;
                        return;
                    }

                    if (Math.abs(delta) < 6) {
                        return;
                    }

                    this.topNavHeaderVisible = delta < 0;
                    this.topNavLastScrollTop = scrollTop;
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
                        this.tabsPanelOpen = false;
                        this.shadowPanelOpen = false;
                    }
                },
                storedTypographyTheme(type) {
                    try {
                        return window.localStorage.getItem(`outcraft-typography-${this.typographyStorageVersion}-${type}`);
                    } catch (error) {
                        return null;
                    }
                },
                persistTypographyTheme(type, key) {
                    try {
                        window.localStorage.setItem(`outcraft-typography-${this.typographyStorageVersion}-${type}`, key);
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
                insightsTabFromParam(value) {
                    const normalized = String(value || '').toLowerCase();

                    return this.insightsTabs.find((item) => item.label.toLowerCase() === normalized)?.label || 'Overview';
                },
	                applyUrlState() {
	                    const params = new URLSearchParams(window.location.search);
	                    const nav = this.navFromParam(params.get('nav'));
	                    const tab = this.tabFromParam(params.get('tab'));
	                    const insightsTab = this.insightsTabFromParam(params.get('tab'));
	                    const leadId = Number(params.get('lead'));
	                    const builder = String(params.get('builder') || '');
	                    const builderStep = Number(params.get('builderStep'));
	                    const setupMode = String(params.get('setupMode') || '');
	                    const setupStep = String(params.get('setupStep') || '');

	                    this.activeNav = nav;
	                    this.activeTab = nav === 'Leads' ? tab : this.activeTab;
	                    this.activeInsightsTab = nav === 'Analytics' ? insightsTab : this.activeInsightsTab;
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

                    if (this.activeNav === 'Analytics') {
                        url.searchParams.set('tab', this.activeInsightsTab);
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
                openSidebarMenu() {
                    this.mobileNavOpen = true;
                    this.expandSidebar();
                },
		                setActiveNav(section, updateUrl = true) {
		                    this.showLoader();
		                    this.activeNav = section;
                    this.resetTopNavHeaderScroll();
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
                    this.resetTopNavHeaderScroll();
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
                    return 'Continue';
                },
                campaignBuilderNextLabel() {
                    if (this.campaignBuilderStep < this.companySetupFinalStepIndex()) {
                        return this.companySetupSteps[this.campaignBuilderStep + 1]?.label || 'Next Step';
                    }

                    if (this.campaignBuilderStep === this.companySetupFinalStepIndex()) {
                        return 'Campaign Setup';
                    }

                    return '';
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
                campaignBuilderMobileProgressStepLabel() {
                    if (this.campaignBuilderStep < this.companySetupStartStep()) {
                        const total = Math.max(1, this.companySetupSteps.length);
                        const current = Math.min(total, this.campaignBuilderStep + 1);

                        return `Step ${current} of ${total}`;
                    }

                    const total = Math.max(1, this.campaignSetupStepsForMode().length);
                    const current = Math.min(total, this.campaignSetupStepIndex() + 1);

                    return `Step ${current} of ${total}`;
                },
                campaignBuilderMobileProgressPercent() {
                    if (this.campaignBuilderStep < this.companySetupStartStep()) {
                        const total = Math.max(1, this.companySetupSteps.length);

                        return Math.round((Math.min(total, this.campaignBuilderStep + 1) / total) * 100);
                    }

                    const total = Math.max(1, this.campaignSetupStepsForMode().length);

                    return Math.round((Math.min(total, this.campaignSetupStepIndex() + 1) / total) * 100);
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

                    return 'Continue';
                },
                campaignSetupNextLabel() {
                    const steps = this.campaignSetupStepsForMode();
                    const currentIndex = this.campaignSetupStepIndex();

                    if (currentIndex >= steps.length - 1) {
                        return '';
                    }

                    return steps[currentIndex + 1]?.label || 'Next Step';
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
                        followups: 'Follow-Up Sequence',
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
                        sequence: 'Set actions the AI will run and the delay time between them. You can edit the sequence, but we recommend keeping the template defaults unless you have a specific reason to change them.',
                        followups: 'When a lead responds to the first outreach, the agent can continue with a matching follow-up sequence. Enable sequences separately for Positive, Undecided, or Negative responses.',
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
                toggleWhatsAppConnection() {
                    this.campaignSetup.whatsappConnectionStatus = this.campaignSetup.whatsappConnectionStatus === 'Connected'
                        ? ''
                        : 'Connected';
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
                        { type: 'short_conversation_instructions', group: 'Campaign Instructions', title: 'Conversation Flow', description: 'Guide how the AI structures each stage of a short call conversation.', icon: 'forum' },
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
		                        return 'Example: @{{cart_url}}?utm_source=example&utm_medium=email&utm_campaign=cart-recovery';
		                    }

		                    return 'Example: https://example.com/cart?utm_source=example&utm_medium=email&utm_campaign=cart-recovery';
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

                    if (type === 'short_conversation_instructions') {
                        return { ...baseItem, shortConversationOpen: ['introduction'] };
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

                    return this.whatsappIconSvg();
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
                    this.campaignSetup.languageAccordionOpen = code;
                },
                toggleCampaignSetupLanguageAccordion(code) {
                    this.campaignSetup.activeLanguage = code;
                    this.campaignSetup.languageAccordionOpen = this.campaignSetup.languageAccordionOpen === code ? '' : code;
                },
                setCampaignSetupDefaultLanguage(code) {
                    if (! this.campaignSetup.languages.some((language) => language.code === code)) {
                        return;
                    }

                    this.campaignSetup.defaultLanguage = code;
                },
                removeCampaignSetupLanguage(code) {
                    if (this.campaignSetup.languages.length <= 1) {
                        return;
                    }

                    this.campaignSetup.languages = this.campaignSetup.languages.filter((language) => language.code !== code);

                    const fallbackLanguage = this.campaignSetup.languages[0] || { code: 'US' };

                    if (this.campaignSetup.defaultLanguage === code) {
                        this.campaignSetup.defaultLanguage = fallbackLanguage.code;
                    }

                    if (this.campaignSetup.activeLanguage === code) {
                        this.campaignSetup.activeLanguage = fallbackLanguage.code;
                    }

                    if (this.campaignSetup.languageAccordionOpen === code) {
                        this.campaignSetup.languageAccordionOpen = fallbackLanguage.code;
                    }

                    this.scheduleCampaignBuilderLayoutUpdate();
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
                    const name = this.campaignSetupLanguageDisplay(language);

                    return `${name || 'Language'} AI Agent`;
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
                whatsappIconSvg() {
                    return '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640" fill="currentColor" aria-hidden="true"><path d="M476.9 161.1C435 119.1 379.2 96 319.9 96C197.5 96 97.9 195.6 97.9 318C97.9 357.1 108.1 395.3 127.5 429L96 544L213.7 513.1C246.1 530.8 282.6 540.1 319.8 540.1L319.9 540.1C442.2 540.1 544 440.5 544 318.1C544 258.8 518.8 203.1 476.9 161.1zM319.9 502.7C286.7 502.7 254.2 493.8 225.9 477L219.2 473L149.4 491.3L168 423.2L163.6 416.2C145.1 386.8 135.4 352.9 135.4 318C135.4 216.3 218.2 133.5 320 133.5C369.3 133.5 415.6 152.7 450.4 187.6C485.2 222.5 506.6 268.8 506.5 318.1C506.5 419.9 421.6 502.7 319.9 502.7zM421.1 364.5C415.6 361.7 388.3 348.3 383.2 346.5C378.1 344.6 374.4 343.7 370.7 349.3C367 354.9 356.4 367.3 353.1 371.1C349.9 374.8 346.6 375.3 341.1 372.5C308.5 356.2 287.1 343.4 265.6 306.5C259.9 296.7 271.3 297.4 281.9 276.2C283.7 272.5 282.8 269.3 281.4 266.5C280 263.7 268.9 236.4 264.3 225.3C259.8 214.5 255.2 216 251.8 215.8C248.6 215.6 244.9 215.6 241.2 215.6C237.5 215.6 231.5 217 226.4 222.5C221.3 228.1 207 241.5 207 268.8C207 296.1 226.9 322.5 229.6 326.2C232.4 329.9 268.7 385.9 324.4 410C359.6 425.2 373.4 426.5 391 423.9C401.7 422.3 423.8 410.5 428.4 397.5C433 384.5 433 373.4 431.6 371.1C430.3 368.6 426.6 367.2 421.1 364.5z"/></svg>';
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
                    this.campaignSetup.languageAccordionOpen = nextLanguage.code;
                    this.campaignSetup.languageSearch = '';
                    this.scheduleCampaignBuilderLayoutUpdate();
                },
                openCampaignSetupLanguageBatchModal() {
                    this.campaignSetup.languageSearch = '';
                    this.campaignSetup.languageBatchSelection = [];
                    this.campaignSetup.languageBatchModalOpen = true;
                },
                campaignSetupLanguageSelectedForBatch(code) {
                    return this.campaignSetup.languageBatchSelection.includes(code);
                },
                toggleCampaignSetupLanguageSelection(code) {
                    if (this.campaignSetupLanguageSelectedForBatch(code)) {
                        this.campaignSetup.languageBatchSelection = this.campaignSetup.languageBatchSelection.filter((item) => item !== code);
                        return;
                    }

                    this.campaignSetup.languageBatchSelection.push(code);
                },
                addSelectedCampaignSetupLanguages() {
                    const selectedCodes = new Set(this.campaignSetup.languageBatchSelection);
                    const selectedLanguages = this.campaignSetupLanguageOptions.filter((language) => selectedCodes.has(language.code));

                    selectedLanguages.forEach((language) => {
                        if (! this.campaignSetup.languages.some((item) => item.code === language.code)) {
                            this.campaignSetup.languages.push({ ...language });
                        }
                    });

                    if (selectedLanguages.length > 0) {
                        const firstLanguage = this.campaignSetup.languages[0];
                        this.campaignSetup.activeLanguage = firstLanguage?.code || selectedLanguages[0].code;
                        this.campaignSetup.languageAccordionOpen = firstLanguage?.code || selectedLanguages[0].code;
                    }

                    this.campaignSetup.languageBatchSelection = [];
                    this.campaignSetup.languageSearch = '';
                    this.campaignSetup.languageBatchModalOpen = false;
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
	                shortConversationInstructionStages() {
	                    return [
	                        {
	                            key: 'introduction',
	                            fieldKey: 'shortConversationIntroduction',
	                            title: 'Introduction',
	                            description: 'Control how the AI opens the conversation, introduces itself, and sets context.',
	                            placeholder: 'Greet warmly, say your name and the reason why you are calling. Be short.',
	                            defaultValue: 'Greet warmly, say your name and the reason why you are calling. Be short.',
	                        },
	                        {
	                            key: 'engagement',
	                            fieldKey: 'shortConversationEngagement',
	                            title: 'Engagement',
	                            description: 'Guide how the AI builds rapport, confirms the lead situation, and invites a response.',
	                            placeholder: 'Ask if it’s a good time to talk. If yes: continue. If no: ensure it will be super quick and ask naturally just 30 seconds you will let them go. Wait for answer. If again no: ask if there is a good time to call back.',
	                            defaultValue: 'Ask if it’s a good time to talk. If yes: continue. If no: ensure it will be super quick and ask naturally just 30 seconds you will let them go. Wait for answer. If again no: ask if there is a good time to call back.',
	                        },
	                        {
	                            key: 'qualification',
	                            fieldKey: 'shortConversationQualification',
	                            title: 'Qualification',
	                            description: 'Define what the AI should quickly check before recommending the next step.',
	                            placeholder: 'Identify needs, challenges, or context with qualification questions (ask questions one at a time).',
	                            defaultValue: 'Identify needs, challenges, or context with qualification questions (ask questions one at a time).',
	                        },
	                        {
	                            key: 'solutionAlignment',
	                            fieldKey: 'shortConversationSolutionAlignment',
	                            title: 'Solution Alignment',
	                            description: 'Explain how the AI should connect the lead need to the product, offer, or service.',
	                            placeholder: 'Share one relevant benefit per answer. Keep it short.',
	                            defaultValue: 'Share one relevant benefit per answer. Keep it short.',
	                        },
	                        {
	                            key: 'nextSteps',
	                            fieldKey: 'shortConversationNextSteps',
	                            title: 'Next Steps',
	                            description: 'Control how the AI guides the lead toward booking, replying, buying, or another desired action.',
	                            placeholder: 'Suggest @{{call_goal}} as the next step, confidently.',
	                            defaultValue: 'Suggest @{{call_goal}} as the next step, confidently.',
	                        },
	                        {
	                            key: 'closing',
	                            fieldKey: 'shortConversationClosing',
	                            title: 'Closing',
	                            description: 'Set how the AI wraps up politely when the lead is not ready or the conversation ends.',
	                            placeholder: 'Thank them warmly, wish them well. Wait for their closing phrase before saying goodbye.',
	                            defaultValue: 'Thank them warmly, wish them well. Wait for their closing phrase before saying goodbye.',
	                        },
	                    ];
	                },
	                resetShortConversationInstruction(stage) {
	                    this.campaignSetup.brief.shortConversationInstructions[stage.key] = stage.defaultValue || '';
	                },
	                toggleShortConversationInstructionStage(item, key) {
	                    if (! item || ! key) {
	                        return;
	                    }

	                    item.shortConversationOpen = Array.isArray(item.shortConversationOpen)
	                        ? (item.shortConversationOpen.includes(key)
	                            ? item.shortConversationOpen.filter((openKey) => openKey !== key)
	                            : [...item.shortConversationOpen, key])
	                        : [key];

	                    this.$nextTick(() => this.scheduleCampaignBuilderLayoutUpdate());
	                },
	                expandShortConversationInstructions(item) {
	                    if (! item) {
	                        return;
	                    }

	                    item.shortConversationOpen = this.shortConversationInstructionStages()
	                        .map((stage) => stage.key);

	                    this.$nextTick(() => this.scheduleCampaignBuilderLayoutUpdate());
	                },
	                collapseShortConversationInstructions(item) {
	                    if (! item) {
	                        return;
	                    }

	                    item.shortConversationOpen = [];

	                    this.$nextTick(() => this.scheduleCampaignBuilderLayoutUpdate());
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
                    this.campaignSetup.delayModalOpen = false;
                    this.campaignSetup.delayEditingScope = '';
                    this.campaignSetup.delayEditingSequence = '';
                    this.campaignSetup.delayEditingIndex = null;
                    this.campaignSetup.followupModalOpen = false;
                    this.campaignSetup.followupActionOpen = '';
                    this.campaignSetup.followupEditingSequence = null;
                    this.campaignSetup.followupEditingIndex = null;
                    this.campaignSetup.mailboxModalOpen = false;
                    this.campaignSetup.phoneNumberModalOpen = false;
                    this.campaignSetup.physicalAddressModalOpen = false;
                    this.campaignSetup.physicalAddressFormOpen = false;
                    this.campaignSetup.discountCodeModalOpen = false;
	                    this.campaignSetup.integrationSkipModalOpen = false;
	                    this.campaignSetup.briefBuilderItemModalOpen = false;
	                    this.campaignSetup.briefBuilderItemActionOpen = '';
	                    this.campaignSetup.overrideModalOpen = false;
	                    this.campaignSetup.languageBatchModalOpen = false;
	                    this.campaignSetup.evaluationDrawerOpen = false;
	                    this.campaignSetup.evaluationActionOpen = '';
	                    this.campaignSetup.dispatchDrawerOpen = false;
	                    this.campaignSetup.newDiscountCode = '';
	                    this.campaignSetup.briefBuilderItemSearch = '';
	                    this.campaignSetup.languageBatchSelection = [];
	                    this.campaignSetup.languageSearch = '';
	                },
                addMailboxConnection() {
                    const email = String(this.campaignSetup.mailboxEmail || '').trim();

                    if (email) {
                        this.campaignSetup.mailboxes.push({
                            email,
                            provider: this.campaignSetup.mailboxProvider || 'IMAP',
                            status: 'Connected',
                            connectedAgo: 'Just now',
                            connectedAt: 'Connected just now',
                        });
                    }

                    this.campaignSetup.mailboxEmail = '';
                    this.closeCampaignSetupOverlays();
                    this.scheduleCampaignBuilderLayoutUpdate();
                },
                removeMailbox(email) {
                    this.campaignSetup.mailboxes = this.campaignSetup.mailboxes.filter((mailbox) => mailbox.email !== email);
                    this.scheduleCampaignBuilderLayoutUpdate();
                },
                removePhoneNumber(number) {
                    this.campaignSetup.phoneNumbers = this.campaignSetup.phoneNumbers.filter((phone) => phone.number !== number);
                    this.scheduleCampaignBuilderLayoutUpdate();
                },
                addPhysicalAddress() {
                    const form = this.campaignSetup.physicalAddressForm;

                    this.campaignSetup.physicalAddresses.push({
                        id: Date.now(),
                        provider: form.provider || 'Twilio',
                        companyName: form.businessName || 'Company not set',
                        representativeFirstName: form.representativeFirstName || '',
                        representativeLastName: form.representativeLastName || '',
                        businessPhone: form.businessPhone || '',
                        companyLocation: form.businessLocation || 'United States',
                        addressLine1: form.addressLine1 || '',
                        addressLine2: form.addressLine2 || '',
                        city: form.city || '',
                        state: form.state || '',
                        zipCode: form.postalCode || 'Zip not set',
                    });

                    this.campaignSetup.physicalAddressFormOpen = false;
                    this.scheduleCampaignBuilderLayoutUpdate();
                },
                removePhysicalAddress(id) {
                    this.campaignSetup.physicalAddresses = this.campaignSetup.physicalAddresses.filter((address) => address.id !== id);
                    this.scheduleCampaignBuilderLayoutUpdate();
                },
                addPhoneNumber() {
                    const state = this.campaignSetup.phoneNumberForm.state;

                    this.campaignSetup.phoneNumbers.push({
                        number: '+12025550' + String(this.campaignSetup.phoneNumbers.length + 11).padStart(3, '0'),
                        campaign: 'Example Campaign',
                        country: this.campaignSetup.phoneNumberForm.country === 'United States' ? 'US' : this.campaignSetup.phoneNumberForm.country,
                        state: state === 'Select an option' ? 'Unassigned state' : state,
                        status: 'Active',
                    });

                    this.closeCampaignSetupOverlays();
                    this.scheduleCampaignBuilderLayoutUpdate();
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
                sequenceStepTypeGroups() {
                    return [
                        {
                            group: 'Call',
                            icon: 'call',
                            options: [
                                { type: 'Initial Call', channel: 'Call', label: 'initial_call', delayAmount: 4, delayUnit: 'Hours', step: 'Initial outbound call to a lead introducing the company/product and the campaign offer' },
                                { type: 'Ping Call', channel: 'Call', label: 'ping_call', delayAmount: 4, delayUnit: 'Hours', step: 'Short follow-up call to re-engage the lead and prompt the next best action' },
                            ],
                        },
                        {
                            group: 'Email',
                            icon: 'mail',
                            options: [
                                { type: 'Initial Email', channel: 'Email', label: 'initial_email', delayAmount: 4, delayUnit: 'Hours', step: 'Initial outbound email introducing the campaign and next best action' },
                                { type: 'Ping Email', channel: 'Email', label: 'ping_email', delayAmount: 4, delayUnit: 'Hours', step: 'Short follow-up email reminding the lead about the campaign offer' },
                                { type: 'Breakup Email', channel: 'Email', label: 'breakup_email', delayAmount: 2, delayUnit: 'Days', step: 'Final email that politely closes the outreach loop if the lead does not engage' },
                            ],
                        },
                        {
                            group: 'SMS',
                            icon: 'sms',
                            options: [
                                { type: 'Initial SMS', channel: 'SMS', label: 'initial_sms', delayAmount: 4, delayUnit: 'Hours', step: 'Initial outbound SMS to the lead regarding the campaign' },
                                { type: 'Ping SMS', channel: 'SMS', label: 'ping_sms', delayAmount: 4, delayUnit: 'Hours', step: 'Short follow-up SMS nudging the lead toward the next best action' },
                            ],
                        },
                        {
                            group: 'Campaign',
                            icon: 'flag',
                            options: [
                                { type: 'Close Campaign Run', channel: 'None', label: 'campaign_end', delayAmount: 2, delayUnit: 'Days', step: 'Indicates the end of a campaign flow. No further actions will be taken for this lead in the current campaign.' },
                            ],
                        },
                    ];
                },
                sequenceStepTypeOptions() {
                    return this.sequenceStepTypeGroups().flatMap((group) => group.options);
                },
                sequenceStepType(type) {
                    return this.sequenceStepTypeOptions().find((option) => option.type === type)
                        || this.sequenceStepTypeOptions()[0];
                },
                sequenceRowType(row) {
                    return this.sequenceStepTypeOptions().find((option) => option.label === row?.label)?.type
                        || this.sequenceStepTypeOptions().find((option) => option.channel === row?.channel && option.step === row?.step)?.type
                        || (row?.channel === 'None' ? 'Close Campaign Run' : 'Initial Call');
                },
                sequenceStepTitle(row) {
                    return this.sequenceRowType(row);
                },
                isSequenceEndRow(row) {
                    return this.sequenceRowType(row) === 'Close Campaign Run'
                        || row?.label === 'campaign_end'
                        || row?.channel === 'None'
                        || row?.channel === 'Close Campaign Run';
                },
                sequenceTimelineRows() {
                    return this.sequenceRows.filter((row) => ! this.isSequenceEndRow(row));
                },
                followupTimelineVisibleRows(sequence = 'positive') {
                    return this.followupTimelineRows(sequence).filter((row) => ! this.isSequenceEndRow(row));
                },
                openSequenceStepModal(index = null) {
                    const row = Number.isInteger(index) ? this.sequenceRows[index] : null;

                    this.campaignSetup.sequenceEditingIndex = Number.isInteger(index) ? index : null;
                    this.campaignSetup.sequenceActionOpen = '';
                    this.campaignSetup.sequenceForm = {
                        type: row ? this.sequenceRowType(row) : 'Initial Call',
                    };
                    this.campaignSetup.sequenceModalOpen = true;
                },
                sequenceDelayUnitOptions() {
                    return [
                        { value: 'Immediately', label: 'Immediately' },
                        { value: '__divider', label: '---', disabled: true },
                        'Minutes',
                        'Hours',
                        'Days',
                    ];
                },
                composeSequenceDelay(amount, unit) {
                    if (unit === 'Immediately') {
                        return '0 minutes';
                    }

                    const value = Math.max(0, Number.parseInt(amount, 10) || 0);
                    const normalizedUnit = ['Minutes', 'Hours', 'Days'].includes(unit) ? unit : 'Hours';
                    const singular = normalizedUnit.slice(0, -1).toLowerCase();
                    const plural = normalizedUnit.toLowerCase();

                    return `${value} ${value === 1 ? singular : plural}`;
                },
                updateSequenceRowDelay(row) {
                    if (row.delayUnit === 'Immediately') {
                        row.delayAmount = 0;
                        row.delay = this.composeSequenceDelay(row.delayAmount, row.delayUnit);
                        this.scheduleCampaignBuilderLayoutUpdate();

                        return;
                    }

                    row.delayAmount = Math.max(0, Number.parseInt(row.delayAmount, 10) || 0);
                    row.delayUnit = ['Minutes', 'Hours', 'Days'].includes(row.delayUnit) ? row.delayUnit : 'Hours';
                    row.delay = this.composeSequenceDelay(row.delayAmount, row.delayUnit);
                    this.scheduleCampaignBuilderLayoutUpdate();
                },
                openSequenceDelayModal(index) {
                    const row = this.sequenceRows[index];

                    if (! row) {
                        return;
                    }

                    this.campaignSetup.delayEditingScope = 'sequence';
                    this.campaignSetup.delayEditingSequence = '';
                    this.campaignSetup.delayEditingIndex = index;
                    this.campaignSetup.delayForm = {
                        delayAmount: row.delayAmount ?? 0,
                        delayUnit: row.delayUnit || 'Hours',
                    };
                    this.campaignSetup.delayModalOpen = true;
                },
                openFollowupDelayModal(sequence, index) {
                    const row = this.followupTimelineRows(sequence)[index];

                    if (! row) {
                        return;
                    }

                    this.campaignSetup.delayEditingScope = 'followup';
                    this.campaignSetup.delayEditingSequence = sequence;
                    this.campaignSetup.delayEditingIndex = index;
                    this.campaignSetup.delayForm = {
                        delayAmount: row.delayAmount ?? 0,
                        delayUnit: row.delayUnit || 'Hours',
                    };
                    this.campaignSetup.delayModalOpen = true;
                },
                saveDelayModal() {
                    const form = this.campaignSetup.delayForm;
                    const scope = this.campaignSetup.delayEditingScope;
                    const index = this.campaignSetup.delayEditingIndex;
                    const rows = scope === 'followup'
                        ? this.followupTimelineRows(this.campaignSetup.delayEditingSequence)
                        : this.sequenceRows;
                    const row = rows[index];

                    if (! row) {
                        this.closeCampaignSetupOverlays();
                        return;
                    }

                    row.delayUnit = form.delayUnit || 'Hours';
                    row.delayAmount = form.delayUnit === 'Immediately'
                        ? 0
                        : Math.max(0, Number.parseInt(form.delayAmount, 10) || 0);
                    this.updateSequenceRowDelay(row);
                    this.closeCampaignSetupOverlays();
                },
                delayModalTitle() {
                    return this.campaignSetup.delayEditingScope === 'followup'
                        ? 'Edit Follow-Up Delay'
                        : 'Edit Outreach Delay';
                },
                delayModalDescription() {
                    return this.campaignSetup.delayEditingScope === 'followup'
                        ? 'Set how long the agent should wait before running next follow-up step.'
                        : 'Set how long the agent should wait before running next outreach step.';
                },
                selectSequenceStepType(type) {
                    const selectedType = this.sequenceStepType(type);
                    const payload = {
                        channel: selectedType.channel,
                        label: selectedType.label,
                        delayAmount: selectedType.delayAmount ?? 4,
                        delayUnit: selectedType.delayUnit || 'Hours',
                        delay: this.composeSequenceDelay(selectedType.delayAmount ?? 4, selectedType.delayUnit || 'Hours'),
                        step: selectedType.step,
                    };

                    if (this.campaignSetup.sequenceEditingIndex === null) {
                        this.sequenceRows.push({
                            id: `sequence-step-${Date.now()}`,
                            ...payload,
                        });
                    } else if (this.sequenceRows[this.campaignSetup.sequenceEditingIndex]) {
                        this.sequenceRows[this.campaignSetup.sequenceEditingIndex] = {
                            ...this.sequenceRows[this.campaignSetup.sequenceEditingIndex],
                            ...payload,
                        };
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
                        Call: 'bg-teal-50 text-teal-600 ring-teal-200',
                        SMS: 'bg-amber-50 text-amber-600 ring-amber-200',
                        Email: 'bg-cyan-50 text-cyan-600 ring-cyan-200',
                        WhatsApp: 'bg-lime-50 text-lime-600 ring-lime-200',
                        None: 'bg-white text-gray-400 ring-gray-200',
                        'Close Campaign Run': 'bg-white text-gray-400 ring-gray-200',
                    }[channel] || 'bg-indigo-50 text-indigo-600 ring-indigo-200';
                },
                interactionTimelineIconTileClass(interaction) {
                    const channel = interaction?.channel;

                    if (channel === 'Call') {
                        return interaction?.status === 'No Response (Voicemail/Busy)'
                            ? 'bg-red-50 text-red-600 ring-red-200'
                            : 'bg-teal-50 text-teal-600 ring-teal-200';
                    }

                    return {
                        SMS: 'bg-amber-50 text-amber-600 ring-amber-200',
                        Email: 'bg-cyan-50 text-cyan-600 ring-cyan-200',
                        WhatsApp: 'bg-lime-50 text-lime-600 ring-lime-200',
                    }[channel] || 'bg-white text-gray-400 ring-gray-200';
                },
                sequenceChannelLabel(channel) {
                    return channel === 'None' ? 'Close Campaign Run' : channel;
                },
                sequenceDelayLabel(delay) {
                    return delay === '-' || delay === '0 minutes' ? 'Immediately' : `After ${delay}`;
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
                    this.openSequenceStepModal(index);
                },
                deleteSequenceRow(index) {
                    this.sequenceRows.splice(index, 1);
                    this.campaignSetup.sequenceActionOpen = '';
                    this.scheduleCampaignBuilderLayoutUpdate();
                },
                followupSequenceTabs() {
                    return [
                        { id: 'positive', label: 'Positive Response', enabled: this.campaignSetup.followupPositive },
                        { id: 'engaged', label: 'Engaged But Undecided', enabled: this.campaignSetup.followupEngaged },
                        { id: 'negative', label: 'Negative Response', enabled: this.campaignSetup.followupNegative },
                    ].filter((tab) => tab.enabled);
                },
                followupSequenceAllTabs() {
                    return [
                        { id: 'positive', label: 'Positive' },
                        { id: 'engaged', label: 'Undecided' },
                        { id: 'negative', label: 'Negative' },
                    ];
                },
                followupSequenceContent(sequence = this.campaignSetup.activeFollowupSequence) {
                    return {
                        positive: {
                            field: 'followupPositive',
                            title: 'After a Positive Response',
                            description: 'Use this sequence when the lead shows interest or gives a positive response. Follow up to confirm the next step, share details, or answer any remaining questions.',
                        },
                        engaged: {
                            field: 'followupEngaged',
                            title: 'When a Lead Is Engaged but Undecided',
                            description: 'Use this sequence when the lead has engaged into conversation, but has not clearly said yes or no. Follow up to clarify interest, handle objections, and guide them toward a decision.',
                        },
                        negative: {
                            field: 'followupNegative',
                            title: 'After a Negative Response',
                            description: 'Use this sequence when the lead declines or shows they are not interested. Follow up politely, close the loop, or leave the door open for later.',
                        },
                    }[sequence] || {
                        field: 'followupPositive',
                        title: 'After a Positive Response',
                        description: 'Use this sequence when the lead shows interest or gives a positive response. Follow up to confirm the next step, share details, or answer any remaining questions.',
                    };
                },
                followupSequenceEnabled(sequence = this.campaignSetup.activeFollowupSequence) {
                    return Boolean(this.campaignSetup[this.followupSequenceContent(sequence).field]);
                },
                toggleActiveFollowupSequence() {
                    const sequence = this.campaignSetup.activeFollowupSequence;
                    const content = this.followupSequenceContent(sequence);

                    this.campaignSetup[content.field] = ! this.campaignSetup[content.field];
                    this.scheduleCampaignBuilderLayoutUpdate();
                },
                followupLayoutOptionLabel() {
                    return this.campaignSetup.followupLayoutOption === 'option2' ? 'Option 2' : 'Option 1 · Historical';
                },
                setFollowupLayoutOption(option) {
                    this.campaignSetup.followupLayoutOption = option === 'option2' ? 'option2' : 'option1';
                    this.campaignSetup.followupOptionMenuOpen = false;
                    this.scheduleCampaignBuilderLayoutUpdate();
                },
                followupTimelineRows(sequence = 'positive') {
                    return this.campaignSetup.followupSequences?.[sequence] || this.campaignSetup.followupSequences.positive;
                },
                updateFollowupRowDelay(row) {
                    this.updateSequenceRowDelay(row);
                },
                followupStepTitle(row) {
                    return this.sequenceStepTitle(row);
                },
                openFollowupStepModal(sequence = this.campaignSetup.activeFollowupSequence, index = null) {
                    const rows = this.followupTimelineRows(sequence);
                    const row = Number.isInteger(index) ? rows[index] : null;

                    this.campaignSetup.followupEditingSequence = sequence;
                    this.campaignSetup.followupEditingIndex = Number.isInteger(index) ? index : null;
                    this.campaignSetup.followupActionOpen = '';
                    this.campaignSetup.followupForm = {
                        type: row ? this.sequenceRowType(row) : 'Initial Email',
                    };
                    this.campaignSetup.followupModalOpen = true;
                },
                selectFollowupStepType(type) {
                    const selectedType = this.sequenceStepType(type);
                    const sequence = this.campaignSetup.followupEditingSequence || this.campaignSetup.activeFollowupSequence;
                    const rows = this.followupTimelineRows(sequence);
                    const payload = {
                        channel: selectedType.channel,
                        label: selectedType.label,
                        delayAmount: selectedType.delayAmount ?? 4,
                        delayUnit: selectedType.delayUnit || 'Hours',
                        delay: this.composeSequenceDelay(selectedType.delayAmount ?? 4, selectedType.delayUnit || 'Hours'),
                        step: selectedType.step,
                    };

                    if (this.campaignSetup.followupEditingIndex === null) {
                        rows.push({
                            id: `${sequence}-followup-${Date.now()}`,
                            ...payload,
                        });
                    } else if (rows[this.campaignSetup.followupEditingIndex]) {
                        rows[this.campaignSetup.followupEditingIndex] = {
                            ...rows[this.campaignSetup.followupEditingIndex],
                            ...payload,
                        };
                    }

                    this.closeCampaignSetupOverlays();
                    this.scheduleCampaignBuilderLayoutUpdate();
                },
                moveFollowupRow(sequence, index, direction) {
                    const rows = this.followupTimelineRows(sequence);
                    const nextIndex = index + direction;

                    if (nextIndex < 0 || nextIndex >= rows.length) {
                        return;
                    }

                    [rows[index], rows[nextIndex]] = [rows[nextIndex], rows[index]];
                    this.campaignSetup.followupActionOpen = '';
                    this.scheduleCampaignBuilderLayoutUpdate();
                },
                editFollowupRow(sequence, index) {
                    this.openFollowupStepModal(sequence, index);
                },
                deleteFollowupRow(sequence, index) {
                    this.followupTimelineRows(sequence).splice(index, 1);
                    this.campaignSetup.followupActionOpen = '';
                    this.scheduleCampaignBuilderLayoutUpdate();
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
                        { label: 'Company', summary: this.companyForm.name || 'Example Company', status: 'Done' },
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
                    this.resetTopNavHeaderScroll();
                    this.syncUrl();
                },
                analyticsRanges() {
                    return ['Last 24 Hours', 'Last 7 Days', 'Last 14 Days', 'Last 30 Days', 'All Time', 'Custom range'];
                },
                analyticsCampaignOptions() {
                    const campaignTypes = this.campaignTypeGroups.flatMap((group) => group.items.map((item) => item.name));

                    return ['All Campaigns', ...campaignTypes];
                },
                setAnalyticsCampaign(campaign) {
                    this.activeAnalyticsCampaign = campaign;
                    this.activeAnalyticsOutcomeMetric = this.analyticsOutcomeMetricOptions()[0] || 'Orders Saved';
                    this.activeAnalyticsTimelineMetric = 'Engaged';
                    this.activeAnalyticsTimelineMetrics = this.demoAnalyticsDefaultTimelineMetrics();
                    this.activeAnalyticsTimelineMetricMenuOpen = false;
                    this.activeAnalyticsOutcomeMenuOpen = false;
                    this.showLoader(500);
                },
                analyticsOutcomeMetricOptions() {
                    return {
                        'Book Appointment': ['Meetings Booked', 'Qualified Meetings'],
                        'Qualify Lead': ['Qualified Leads', 'Disqualified Leads'],
                        'Recover Abandoned Checkout': ['Carts Recovered', 'Coupon Codes Used'],
                        'Client Reactivation': ['Reactivated Clients', 'Churn Reason Captured'],
                        'Upsell Post-Purchase': ['Upsells Accepted', 'Repeat Buyers'],
                        'Post-Delivery Follow-Up': ['Support Resolved', 'Repeat Purchases'],
                        'Inbound Refund Request': ['Orders Saved', 'Refund Requests Handled'],
                        'Send Information': ['Links Clicked', 'Follow-up Requests'],
                        'Provide Support': ['Issues Resolved', 'Human Handoffs'],
                    }[this.activeAnalyticsCampaign] || [];
                },
                setAnalyticsOutcomeMetric(metric) {
                    this.activeAnalyticsOutcomeMetric = metric;
                    this.activeAnalyticsTimelineMetric = 'Engaged';
                    this.activeAnalyticsTimelineMetrics = this.demoAnalyticsDefaultTimelineMetrics();
                    this.activeAnalyticsTimelineMetricMenuOpen = false;
                    this.activeAnalyticsOutcomeMenuOpen = false;
                    this.showLoader(350);
                },
                setAnalyticsRange(range) {
                    this.activeAnalyticsRange = range;
                    this.showLoader(500);
                },
                analyticsCampaignConfig() {
                    const selectedOutcome = (outcomes, fallback) => outcomes[this.activeAnalyticsOutcomeMetric] || outcomes[fallback] || Object.values(outcomes)[0];
                    const refundOutcomeMetric = this.activeAnalyticsOutcomeMetric === 'Refund Requests Handled'
                        ? { label: 'Refund Requests Handled', value: '318', note: 'Refund requests completed with policy-safe resolution tracking.', icon: 'receipt_text', rateLabel: 'Resolution Rate', convertedMultiplier: 0.86 }
                        : { label: 'Orders Saved', value: '68', note: 'Requests resolved with replacement, credit, or support instead of refund.', icon: 'task_alt', rateLabel: 'Save Rate', convertedMultiplier: 0.36 };
                    const appointmentOutcomeMetric = selectedOutcome({
                        'Meetings Booked': { label: 'Meetings Booked', value: '146', note: 'Confirmed consultations attributed to Outcraft.', icon: 'calendar_check', rateLabel: 'Booking Rate', convertedMultiplier: 0.72 },
                        'Qualified Meetings': { label: 'Qualified Meetings', value: '92', note: 'Booked meetings that matched ICP or routing rules.', icon: 'verified', rateLabel: 'Qualified Booking Rate', convertedMultiplier: 0.48 },
                    }, 'Meetings Booked');
                    const qualifyOutcomeMetric = selectedOutcome({
                        'Qualified Leads': { label: 'Qualified Leads', value: '284', note: 'Leads meeting fit, need, and timing criteria.', icon: 'verified', rateLabel: 'Qualification Rate', convertedMultiplier: 0.64 },
                        'Disqualified Leads': { label: 'Disqualified Leads', value: '326', note: 'Leads marked as not a fit after qualification prompts.', icon: 'block', rateLabel: 'Disqualification Rate', convertedMultiplier: 0.72 },
                    }, 'Qualified Leads');
                    const cartOutcomeMetric = selectedOutcome({
                        'Carts Recovered': { label: 'Carts Recovered', value: '250', note: 'Orders completed after Outcraft engagement.', icon: 'shopping_bag', rateLabel: 'Conversion Rate', convertedMultiplier: 1.18 },
                        'Coupon Codes Used': { label: 'Coupon Codes Used', value: '188', note: 'Coupon redemptions attributed inside the selected window.', icon: 'confirmation_number', rateLabel: 'Coupon Usage Rate', convertedMultiplier: 0.88 },
                    }, 'Carts Recovered');
                    const cartRevenueMetric = cartOutcomeMetric.label === 'Coupon Codes Used'
                        ? { label: 'Revenue from Coupon Codes', value: '$38.4k', note: 'Revenue tied to attributed coupon code redemptions.', icon: 'payments' }
                        : { label: 'Revenue Recovered', value: '$54.8k', note: 'Revenue attributed within the selected attribution window.', icon: 'payments' };
                    const reactivationOutcomeMetric = selectedOutcome({
                        'Reactivated Clients': { label: 'Reactivated Clients', value: '121', note: 'Clients who restarted usage, plan activity, or buying motion.', icon: 'task_alt', rateLabel: 'Reactivation Rate', convertedMultiplier: 0.58 },
                        'Churn Reason Captured': { label: 'Churn Reason Captured', value: '214', note: 'Inactive customers who shared a churn reason during reactivation outreach.', icon: 'list_checks', rateLabel: 'Churn Insight Rate', convertedMultiplier: 0.74 },
                    }, 'Reactivated Clients');
                    const upsellOutcomeMetric = selectedOutcome({
                        'Upsells Accepted': { label: 'Upsells Accepted', value: '156', note: 'Customers who accepted a related offer.', icon: 'shopping_bag', rateLabel: 'Conversion Rate', convertedMultiplier: 0.7 },
                        'Repeat Buyers': { label: 'Repeat Buyers', value: '118', note: 'Customers who purchased again after post-purchase outreach.', icon: 'repeat', rateLabel: 'Repeat Buyer Rate', convertedMultiplier: 0.54 },
                    }, 'Upsells Accepted');
                    const deliveryOutcomeMetric = selectedOutcome({
                        'Support Resolved': { label: 'Support Resolved', value: '118', note: 'Support questions handled without escalation.', icon: 'headphones', rateLabel: 'Resolution Rate', convertedMultiplier: 0.44 },
                        'Repeat Purchases': { label: 'Repeat Purchases', value: '74', note: 'Follow-up influenced repeat purchase actions.', icon: 'shopping_bag', rateLabel: 'Repeat Purchase Rate', convertedMultiplier: 0.28 },
                    }, 'Support Resolved');
                    const informationOutcomeMetric = selectedOutcome({
                        'Links Clicked': { label: 'Links Clicked', value: '312', note: 'Tracked resource link clicks across email and SMS.', icon: 'ads_click', rateLabel: 'Click-through Rate', convertedMultiplier: 0.52 },
                        'Follow-up Requests': { label: 'Follow-up Requests', value: '104', note: 'Leads who asked for next steps after receiving information.', icon: 'reply', rateLabel: 'Follow-up Request Rate', convertedMultiplier: 0.24 },
                    }, 'Links Clicked');
                    const supportOutcomeMetric = selectedOutcome({
                        'Issues Resolved': { label: 'Issues Resolved', value: '432', note: 'Support issues resolved by AI or guided flows.', icon: 'task_alt', rateLabel: 'Resolution Rate', convertedMultiplier: 0.76 },
                        'Human Handoffs': { label: 'Human Handoffs', value: '86', note: 'Cases routed to a human with enough context.', icon: 'waving_hand', rateLabel: 'Handoff Rate', convertedMultiplier: 0.18 },
                    }, 'Issues Resolved');
                    const configs = {
                        'All Campaigns': {
                            title: 'Campaigns Performance Timeline',
                            description: 'Started campaigns, engaged leads, coupon usage, and attributable conversions',
                            successLabel: 'Converted / coupon used',
                            rateLabel: 'Outcome Rate',
                            engagedLabel: 'Engaged',
                            engagedMultiplier: 1,
                            convertedMultiplier: 1,
                            metrics: [
                                { label: 'Started Campaigns', value: '1,000', note: 'All active outreach entering the attribution window.', icon: 'rocket_launch' },
                                { label: 'Engaged', value: '500', note: 'Calls >5s, replies, clicks, or other meaningful interaction.', icon: 'forum' },
                                { label: 'Successful Outcomes', value: '250', note: 'Bookings, recovered carts, reactivations, or qualified leads.', icon: 'target' },
                            ],
                        },
                        'Book Appointment': {
                            title: 'Appointment Booking Timeline',
                            description: 'Started appointment campaigns, engaged leads, and meetings booked',
                            successLabel: appointmentOutcomeMetric.label,
                            rateLabel: appointmentOutcomeMetric.rateLabel,
                            engagedLabel: 'Engaged leads',
                            engagedMultiplier: 0.92,
                            convertedMultiplier: appointmentOutcomeMetric.convertedMultiplier,
                            metrics: [
                                { label: 'Started Campaigns', value: '820', note: 'Prospects entering booking-focused outreach.', icon: 'rocket_launch' },
                                { label: 'Engaged', value: '418', note: 'Answered calls, replies, or calendar link clicks.', icon: 'forum' },
                                appointmentOutcomeMetric,
                                { label: 'Meetings Attended', value: '74', note: 'Booked prospects who actually showed up to the meeting.', icon: 'event_available' },
                            ],
                        },
                        'Qualify Lead': {
                            title: 'Lead Qualification Timeline',
                            description: 'Qualification starts, engagement, and sales-ready lead outcomes',
                            successLabel: qualifyOutcomeMetric.label,
                            rateLabel: qualifyOutcomeMetric.rateLabel,
                            engagedLabel: 'Engaged leads',
                            engagedMultiplier: 1.05,
                            convertedMultiplier: qualifyOutcomeMetric.convertedMultiplier,
                            metrics: [
                                { label: 'Started Leads', value: '1,120', note: 'Leads entering qualification questions.', icon: 'rocket_launch' },
                                { label: 'Engaged', value: '610', note: 'Leads who answered at least one qualifying prompt.', icon: 'forum' },
                                qualifyOutcomeMetric,
                            ],
                        },
                        'Recover Abandoned Checkout': {
                            title: 'Abandoned Cart Recovery Timeline',
                            description: 'Recovered carts, coupon usage, and revenue-adjacent attribution',
                            successLabel: cartOutcomeMetric.label,
                            rateLabel: cartOutcomeMetric.rateLabel,
                            engagedLabel: 'Engaged carts',
                            engagedMultiplier: 1.12,
                            convertedMultiplier: cartOutcomeMetric.convertedMultiplier,
                            metrics: [
                                { label: 'Started Carts', value: '1,000', note: 'Abandoned carts entering the recovery window.', icon: 'rocket_launch' },
                                { label: 'Engaged', value: '500', note: 'Replies, clicks, callbacks, or checkout return visits.', icon: 'forum' },
                                cartOutcomeMetric,
                                cartRevenueMetric,
                            ],
                        },
                        'Client Reactivation': {
                            title: 'Client Reactivation Timeline',
                            description: 'Inactive customers reached, re-engaged, and reactivated',
                            successLabel: reactivationOutcomeMetric.label,
                            rateLabel: reactivationOutcomeMetric.rateLabel,
                            engagedLabel: 'Re-engaged clients',
                            engagedMultiplier: 0.86,
                            convertedMultiplier: reactivationOutcomeMetric.convertedMultiplier,
                            metrics: [
                                { label: 'Clients Reached', value: '760', note: 'Inactive or churn-risk clients contacted.', icon: 'rocket_launch' },
                                { label: 'Re-engaged', value: '338', note: 'Customers who replied, clicked, or answered calls.', icon: 'forum' },
                                reactivationOutcomeMetric,
                                ...(reactivationOutcomeMetric.label === 'Churn Reason Captured' ? [] : [
                                    { label: 'Revenue Recovered', value: '$31.2k', note: 'Revenue associated with reactivation outcomes.', icon: 'payments' },
                                ]),
                            ],
                        },
                        'Upsell Post-Purchase': {
                            title: 'Post-Purchase Upsell Timeline',
                            description: 'Post-purchase engagement, accepted upsells, and influenced revenue',
                            successLabel: upsellOutcomeMetric.label,
                            rateLabel: upsellOutcomeMetric.rateLabel,
                            engagedLabel: 'Engaged customers',
                            engagedMultiplier: 0.9,
                            convertedMultiplier: upsellOutcomeMetric.convertedMultiplier,
                            metrics: [
                                { label: 'Customers Reached', value: '940', note: 'Recent buyers eligible for relevant upsell offers.', icon: 'rocket_launch' },
                                { label: 'Engaged', value: '402', note: 'Replies, clicks, or offer-page visits.', icon: 'forum' },
                                upsellOutcomeMetric,
                                { label: 'Revenue Influenced', value: '$42.6k', note: 'Incremental revenue from post-purchase offers.', icon: 'payments' },
                            ],
                        },
                        'Post-Delivery Follow-Up': {
                            title: 'Post-Delivery Follow-Up Timeline',
                            description: 'Delivery confirmations, support needs, and repeat purchase signals',
                            successLabel: deliveryOutcomeMetric.label,
                            rateLabel: deliveryOutcomeMetric.rateLabel,
                            engagedLabel: 'Confirmed deliveries',
                            engagedMultiplier: 0.8,
                            convertedMultiplier: deliveryOutcomeMetric.convertedMultiplier,
                            metrics: [
                                { label: 'Customers Reached', value: '680', note: 'Delivered orders entering follow-up outreach.', icon: 'rocket_launch' },
                                { label: 'Confirmed Delivered', value: '512', note: 'Customers who confirmed receipt or successful delivery.', icon: 'task_alt' },
                                deliveryOutcomeMetric,
                                { label: 'Repeat Purchases', value: '74', note: 'Follow-up influenced repeat purchase actions.', icon: 'shopping_bag' },
                            ],
                        },
                        'Inbound Refund Request': {
                            title: 'Refund Request Handling Timeline',
                            description: 'Refund requests handled, saved orders, and escalations',
                            successLabel: refundOutcomeMetric.label,
                            rateLabel: refundOutcomeMetric.rateLabel,
                            engagedLabel: 'Refund conversations',
                            engagedMultiplier: 0.74,
                            convertedMultiplier: refundOutcomeMetric.convertedMultiplier,
                            metrics: [
                                { label: 'Refund Requests', value: '420', note: 'Inbound refund or return requests handled by Outcraft.', icon: 'rocket_launch' },
                                { label: 'Engaged', value: '384', note: 'Customers who completed refund triage.', icon: 'forum' },
                                refundOutcomeMetric,
                                { label: 'Escalated', value: '42', note: 'Cases routed to human support for policy or edge cases.', icon: 'headphones' },
                            ],
                        },
                        'Send Information': {
                            title: 'Information Send Timeline',
                            description: 'Resources sent, link clicks, and follow-up requests',
                            successLabel: informationOutcomeMetric.label,
                            rateLabel: informationOutcomeMetric.rateLabel,
                            engagedLabel: 'Resource engagement',
                            engagedMultiplier: 1.08,
                            convertedMultiplier: informationOutcomeMetric.convertedMultiplier,
                            metrics: [
                                { label: 'Resources Sent', value: '1,340', note: 'Guides, links, or updates delivered to leads.', icon: 'rocket_launch' },
                                { label: 'Engaged', value: '586', note: 'Leads who clicked, replied, or requested more information.', icon: 'forum' },
                                informationOutcomeMetric,
                                { label: 'Follow-up Requests', value: '104', note: 'Leads who asked for next steps after receiving information.', icon: 'reply' },
                            ],
                        },
                        'Provide Support': {
                            title: 'Support Conversation Timeline',
                            description: 'Support conversations, resolutions, and handoff quality',
                            successLabel: supportOutcomeMetric.label,
                            rateLabel: supportOutcomeMetric.rateLabel,
                            engagedLabel: 'Support conversations',
                            engagedMultiplier: 0.98,
                            convertedMultiplier: supportOutcomeMetric.convertedMultiplier,
                            metrics: [
                                { label: 'Conversations Started', value: '920', note: 'Support conversations opened across channels.', icon: 'rocket_launch' },
                                { label: 'Engaged', value: '714', note: 'Customers who completed troubleshooting or support triage.', icon: 'forum' },
                                supportOutcomeMetric,
                                { label: 'Handoffs', value: '86', note: 'Cases routed to a human with enough context.', icon: 'waving_hand' },
                            ],
                        },
                    };

                    return configs[this.activeAnalyticsCampaign] || configs['All Campaigns'];
                },
                analyticsCustomRangeLabel() {
                    const start = this.analyticsCustomRangeStart || 'Start date';
                    const end = this.analyticsCustomRangeEnd || 'End date';

                    return `${start} - ${end}`;
                },
                analyticsDateLabel(date) {
                    return new Intl.DateTimeFormat('en-US', { month: 'short', day: 'numeric' }).format(date);
                },
                analyticsDateAtLocalNoon(value = null) {
                    const date = value ? new Date(value) : new Date();

                    if (Number.isNaN(date.getTime())) {
                        return null;
                    }

                    date.setHours(12, 0, 0, 0);

                    return date;
                },
                analyticsDateLabelsForLastDays(days) {
                    const end = this.analyticsDateAtLocalNoon();
                    const labels = [];

                    if (! end) {
                        return labels;
                    }

                    for (let index = days - 1; index >= 0; index -= 1) {
                        const date = new Date(end);
                        date.setDate(end.getDate() - index);
                        labels.push(this.analyticsDateLabel(date));
                    }

                    return labels;
                },
                analyticsDateLabelsForCustomRange() {
                    const start = this.analyticsDateAtLocalNoon(this.analyticsCustomRangeStart);
                    const end = this.analyticsDateAtLocalNoon(this.analyticsCustomRangeEnd);

                    if (! start || ! end || start > end) {
                        return this.analyticsDateLabelsForLastDays(14);
                    }

                    const labels = [];
                    const cursor = new Date(start);

                    while (cursor <= end && labels.length < 90) {
                        labels.push(this.analyticsDateLabel(cursor));
                        cursor.setDate(cursor.getDate() + 1);
                    }

                    return labels;
                },
                analyticsTimelineDateLabels() {
                    return {
                        'Last 7 Days': this.analyticsDateLabelsForLastDays(7),
                        'Last 14 Days': this.analyticsDateLabelsForLastDays(14),
                        'Last 30 Days': this.analyticsDateLabelsForLastDays(30),
                        'Custom range': this.analyticsDateLabelsForCustomRange(),
                    }[this.activeAnalyticsRange] || null;
                },
                demoAnalyticsRangeDescription() {
                    const description = this.analyticsCampaignConfig().description;

                    return {
                        'Last 24 Hours': `${description} across the last 24 hours.`,
                        'Last 7 Days': `${description} across a 7 day window.`,
                        'Last 14 Days': `${description} across the last 14 days.`,
                        'Last 30 Days': `${description} across a 30 day attribution review.`,
                        'All Time': `${description} month over month.`,
                        'Custom range': `${description} for ${this.analyticsCustomRangeLabel()}.`,
                    }[this.activeAnalyticsRange] || `${description}.`;
                },
                demoAnalyticsRangeBadge() {
                    return {
                        'Last 24 Hours': 'hourly view',
                        'Last 7 Days': '7 day attribution',
                        'Last 14 Days': '14 day view',
                        'Last 30 Days': '30 day view',
                        'All Time': 'month over month',
                        'Custom range': this.analyticsCustomRangeLabel(),
                    }[this.activeAnalyticsRange] || '7 day attribution';
                },
                demoAnalyticsTimelineViews() {
                    return [
                        { key: 'column', label: 'Basic column', icon: 'chart-column' },
                        { key: 'area', label: 'Area spline', icon: 'chart-spline' },
                    ];
                },
                engagementTimelineViews() {
                    return [
                        { key: 'area', label: 'Area spline', icon: 'chart-spline' },
                        { key: 'column', label: 'Basic column', icon: 'chart-column' },
                    ];
                },
                setDemoAnalyticsTimelineView(view) {
                    this.demoAnalyticsTimelineView = view;
                    this.demoAnalyticsChartMenuOpen = false;

                    if (['column', 'area'].includes(view)) {
                        this.$nextTick(() => this.scheduleDemoAnalyticsApexChartRender());
                    } else {
                        this.destroyDemoAnalyticsApexChart();
                    }
                },
                setEngagementTimelineView(view) {
                    this.engagementTimelineView = view;
                    this.engagementChartMenuOpen = false;

                    if (['column', 'area'].includes(view)) {
                        this.$nextTick(() => this.scheduleEngagementApexChartRender('volume'));
                    } else {
                        this.destroyEngagementApexChart('volume');
                    }
                },
                demoAnalyticsDefaultTimelineMetrics() {
                    return this.demoAnalyticsPrimaryMetrics().slice(0, 3).map((metric) => metric.label);
                },
                demoAnalyticsTimelineMetricOptions() {
                    return this.demoAnalyticsPrimaryMetrics().map((metric) => metric.label);
                },
                setDemoAnalyticsTimelineMetric(metric) {
                    this.activeAnalyticsTimelineMetric = metric;
                    this.activeAnalyticsTimelineMetrics = [metric];
                    this.showLoader(350);
                },
                toggleDemoAnalyticsTimelineMetric(metric) {
                    const options = this.demoAnalyticsTimelineMetricOptions();
                    const current = this.demoAnalyticsTimelineSelectedLabels();

                    if (! options.includes(metric)) {
                        return;
                    }

                    if (current.includes(metric)) {
                        this.activeAnalyticsTimelineMetrics = current.length > 1
                            ? current.filter((item) => item !== metric)
                            : current;
                    } else {
                        this.activeAnalyticsTimelineMetrics = [...current, metric];
                    }

                    this.activeAnalyticsTimelineMetric = this.activeAnalyticsTimelineMetrics[0] || options[0] || 'Engaged';
                    this.showLoader(250);
                },
                toggleDemoAnalyticsPreviousPeriod() {
                    this.showAnalyticsPreviousPeriod = ! this.showAnalyticsPreviousPeriod;
                    this.showLoader(250);
                },
                demoAnalyticsTimelineSelectedLabels() {
                    const options = this.demoAnalyticsTimelineMetricOptions();
                    const selected = this.activeAnalyticsTimelineMetrics.filter((metric) => options.includes(metric));

                    return selected.length > 0 ? selected : this.demoAnalyticsDefaultTimelineMetrics();
                },
                demoAnalyticsTimelineMetricButtonLabel() {
                    const selected = this.demoAnalyticsTimelineSelectedLabels();

                    if (selected.length === 1) {
                        return selected[0];
                    }

                    return `${selected.length} metrics selected`;
                },
                demoAnalyticsTimelineMetricKey(metricLabel) {
                    const metrics = this.demoAnalyticsPrimaryMetrics();
                    const index = metrics.findIndex((metric) => metric.label === metricLabel);

                    if (index === 0) {
                        return 'runs';
                    }

                    if (index === 1) {
                        return 'engaged';
                    }

                    if (index === 2) {
                        return 'converted';
                    }

                    return 'final';
                },
                analyticsStepStyle(index, total = 4) {
                    const styles = {
                        dark: {
                            panelClass: 'bg-gray-950 text-white',
                            iconShellClass: 'bg-gray-800 text-gray-100',
                            titleTextClass: 'text-white',
                            labelTextClass: 'text-gray-300',
                            valueTextClass: 'text-white',
                            bodyTextClass: 'text-gray-300',
                            comparisonTextClass: 'text-gray-400',
                            trendUpTextClass: 'text-emerald-300',
                            trendDownTextClass: 'text-rose-300',
                            borderClass: 'border-white/10',
                            colorClass: 'bg-gray-900',
                            hoverClass: 'group-hover:bg-gray-800',
                            dotClass: 'bg-gray-900',
                            stroke: '#111827',
                        },
                        primaryDark: {
                            panelClass: 'oc-primary-bg-dark text-white',
                            iconShellClass: 'bg-white/15 text-indigo-100',
                            titleTextClass: 'text-white',
                            labelTextClass: 'text-indigo-100',
                            valueTextClass: 'text-white',
                            bodyTextClass: 'text-white/75',
                            comparisonTextClass: 'text-white/60',
                            trendUpTextClass: 'text-emerald-200',
                            trendDownTextClass: 'text-rose-200',
                            borderClass: 'border-white/15',
                            colorClass: 'oc-primary-bg-dark',
                            hoverClass: 'group-hover:oc-primary-bg-dark',
                            dotClass: 'oc-primary-bg-dark',
                            stroke: 'rgb(var(--oc-primary-800-rgb))',
                        },
                        primary: {
                            panelClass: 'oc-primary-bg text-white',
                            iconShellClass: 'bg-white/15 text-white',
                            titleTextClass: 'text-white',
                            labelTextClass: 'text-indigo-100',
                            valueTextClass: 'text-white',
                            bodyTextClass: 'text-white/75',
                            comparisonTextClass: 'text-white/60',
                            trendUpTextClass: 'text-emerald-200',
                            trendDownTextClass: 'text-rose-200',
                            borderClass: 'border-white/15',
                            colorClass: 'oc-primary-bg',
                            hoverClass: 'group-hover:oc-primary-bg',
                            dotClass: 'oc-primary-bg',
                            stroke: 'rgb(var(--oc-primary-600-rgb))',
                        },
                        primarySoft: {
                            panelClass: 'oc-primary-bg-soft text-gray-950',
                            iconShellClass: 'bg-white/50 text-indigo-700',
                            titleTextClass: 'text-gray-950',
                            labelTextClass: 'text-gray-700',
                            valueTextClass: 'text-gray-950',
                            bodyTextClass: 'text-gray-700',
                            comparisonTextClass: 'text-gray-600',
                            trendUpTextClass: 'text-emerald-700',
                            trendDownTextClass: 'text-rose-600',
                            borderClass: 'border-indigo-200/70',
                            colorClass: 'oc-primary-bg-soft',
                            hoverClass: 'group-hover:oc-primary-bg-soft-strong',
                            dotClass: 'oc-primary-bg-soft',
                            stroke: '#c7d2fe',
                        },
                    };
                    const palette = total <= 3
                        ? [styles.dark, styles.primaryDark, styles.primarySoft]
                        : [styles.dark, styles.primaryDark, styles.primary, styles.primarySoft];
                    const safeIndex = Math.max(0, Math.min(Number(index) || 0, palette.length - 1));

                    return palette[safeIndex];
                },
                demoAnalyticsTimelineSeriesMeta() {
                    const labels = this.demoAnalyticsTimelineSelectedLabels();

                    return labels.map((label, index) => {
                        const key = this.demoAnalyticsTimelineMetricKey(label);

                        return {
                            label,
                            key,
                            ...this.analyticsStepStyle(index, labels.length),
                        };
                    });
                },
                demoAnalyticsLinePoints(metric) {
                    const key = this.demoAnalyticsTimelineMetricKey(metric);
                    const values = this.demoAnalyticsTimeline().map((item) => Number(item[key]) || 0);
                    const max = Math.max(...values, 100);

                    return values.map((value, index) => {
                        const x = values.length === 1 ? 50 : (index / (values.length - 1)) * 100;
                        const y = 100 - ((value / max) * 86);

                        return `${x},${y}`;
                    }).join(' ');
                },
                demoAnalyticsLinePointsByIndex(index) {
                    const series = this.demoAnalyticsTimelineSeriesMeta()[index];

                    return series ? this.demoAnalyticsLinePoints(series.label) : '';
                },
                demoAnalyticsApexColor(stroke) {
                    if (stroke.startsWith('rgb(var(')) {
                        const variable = stroke.match(/--[^)]+/)?.[0];
                        const value = variable ? getComputedStyle(document.documentElement).getPropertyValue(variable).trim() : '';

                        return value ? `rgb(${value})` : '#4f46e5';
                    }

                    return stroke;
                },
                demoAnalyticsApexColorAlpha(stroke, alpha = 0.5) {
                    const color = this.demoAnalyticsApexColor(stroke);
                    const rgb = color.match(/^rgb\\(([^)]+)\\)$/i);

                    if (rgb) {
                        return `rgba(${rgb[1]}, ${alpha})`;
                    }

                    const hex = color.match(/^#([0-9a-f]{6})$/i);

                    if (hex) {
                        const value = hex[1];
                        const red = parseInt(value.slice(0, 2), 16);
                        const green = parseInt(value.slice(2, 4), 16);
                        const blue = parseInt(value.slice(4, 6), 16);

                        return `rgba(${red}, ${green}, ${blue}, ${alpha})`;
                    }

                    return color;
                },
                analyticsChartWidth(element, minimum = 280, inset = 8) {
                    if (! element) {
                        return 0;
                    }

                    const widths = [
                        element.getBoundingClientRect().width,
                        element.parentElement?.getBoundingClientRect().width,
                    ].filter((width) => Number(width) > 0);

                    if (widths.length === 0) {
                        return 0;
                    }

                    return Math.max(minimum, Math.floor(Math.min(...widths)) - inset);
                },
                updateDemoAnalyticsApexChartWidth() {
                    const width = this.analyticsChartWidth(this.$refs.demoAnalyticsApexChart);

                    if (! width || ! this.demoAnalyticsApexChart) {
                        return;
                    }

                    this.demoAnalyticsApexChart.updateOptions({
                        chart: { width },
                    }, false, true);
                },
                observeDemoAnalyticsApexChart() {
                    const element = this.$refs.demoAnalyticsApexChart;

                    if (! element || ! window.ResizeObserver || this.demoAnalyticsApexResizeObserver) {
                        return;
                    }

                    this.demoAnalyticsApexResizeObserver = new ResizeObserver(() => {
                        requestAnimationFrame(() => this.updateDemoAnalyticsApexChartWidth());
                    });
                    this.demoAnalyticsApexResizeObserver.observe(element);
                    element.parentElement && this.demoAnalyticsApexResizeObserver.observe(element.parentElement);
                },
                destroyDemoAnalyticsApexChart() {
                    if (this.demoAnalyticsApexRenderFrame) {
                        cancelAnimationFrame(this.demoAnalyticsApexRenderFrame);
                        this.demoAnalyticsApexRenderFrame = null;
                    }

                    if (this.demoAnalyticsApexChart) {
                        this.demoAnalyticsApexChart.destroy();
                        this.demoAnalyticsApexChart = null;
                    }
                },
                scheduleDemoAnalyticsApexChartRender() {
                    if (! ['column', 'area'].includes(this.demoAnalyticsTimelineView)) {
                        this.destroyDemoAnalyticsApexChart();

                        return;
                    }

                    if (this.demoAnalyticsApexRenderFrame) {
                        cancelAnimationFrame(this.demoAnalyticsApexRenderFrame);
                    }

                    const token = this.demoAnalyticsApexRenderToken + 1;
                    this.demoAnalyticsApexRenderToken = token;
                    this.demoAnalyticsApexRenderFrame = requestAnimationFrame(() => {
                        this.demoAnalyticsApexRenderFrame = requestAnimationFrame(() => {
                            this.demoAnalyticsApexRenderFrame = null;

                            if (this.demoAnalyticsApexRenderToken === token) {
                                this.renderDemoAnalyticsApexChart();
                            }
                        });
                    });
                },
                renderDemoAnalyticsApexChart() {
                    const element = this.$refs.demoAnalyticsApexChart;

                    if (! element) {
                        return;
                    }

                    if (! window.ApexCharts) {
                        this.scheduleDemoAnalyticsApexChartRender();

                        return;
                    }

                    this.observeDemoAnalyticsApexChart();
                    this.destroyDemoAnalyticsApexChart();
                    element.innerHTML = '';

                    const timeline = this.demoAnalyticsTimeline();
                    const seriesMeta = this.demoAnalyticsTimelineSeriesMeta();
                    const isColumn = this.demoAnalyticsTimelineView === 'column';
                    const currentSeries = seriesMeta.map((metric) => ({
                        name: metric.label,
                        data: timeline.map((item) => Number(item[metric.key]) || 0),
                    }));
                    const previousTimeline = this.showAnalyticsPreviousPeriod && ! isColumn
                        ? this.demoAnalyticsPreviousTimeline()
                        : [];
                    const previousSeries = previousTimeline.length > 0
                        ? seriesMeta.map((metric) => ({
                            name: `${metric.label} previous`,
                            data: previousTimeline.map((item) => Number(item[metric.key]) || 0),
                        }))
                        : [];
                    const series = [...currentSeries, ...previousSeries];
                    const currentColors = seriesMeta.map((metric) => this.demoAnalyticsApexColor(metric.stroke));
                    const colors = [
                        ...currentColors,
                        ...previousSeries.map((_, index) => this.demoAnalyticsApexColorAlpha(seriesMeta[index]?.stroke || currentColors[index] || '#64748b', 0.5)),
                    ];
                    const currentSeriesCount = currentSeries.length;

                    const chartWidth = this.analyticsChartWidth(element);

                    if (! chartWidth) {
                        this.scheduleDemoAnalyticsApexChartRender();

                        return;
                    }

                    const chartOptions = {
                        chart: {
                            type: isColumn ? 'bar' : 'area',
                            height: 280,
                            width: chartWidth,
                            parentHeightOffset: 0,
                            toolbar: { show: false },
                            zoom: { enabled: false },
                            redrawOnParentResize: true,
                            redrawOnWindowResize: true,
                            animations: { enabled: true, easing: 'easeinout', speed: 350 },
                            fontFamily: 'Inter Variable, Inter, ui-sans-serif, system-ui, sans-serif',
                        },
                        series,
                        colors,
                        dataLabels: { enabled: false },
                        grid: {
                            borderColor: '#e5e7eb',
                            strokeDashArray: 0,
                            xaxis: { lines: { show: false } },
                            yaxis: { lines: { show: false } },
                            padding: { top: 8, right: 32, bottom: 0, left: 4 },
                        },
                        xaxis: {
                            categories: timeline.map((item) => item.label),
                            tickAmount: ['Last 7 Days', 'Last 14 Days', 'Last 30 Days', 'Custom range'].includes(this.activeAnalyticsRange) && timeline.length <= 30 ? Math.max(1, timeline.length - 1) : undefined,
                            axisBorder: { show: false },
                            axisTicks: { show: false },
                            labels: {
                                rotate: ['Last 7 Days', 'Last 14 Days', 'Last 30 Days', 'Custom range'].includes(this.activeAnalyticsRange) ? -45 : 0,
                                trim: false,
                                hideOverlappingLabels: false,
                                style: { colors: '#6b7280', fontSize: '12px', fontWeight: 500 },
                            },
                            tooltip: { enabled: false },
                        },
                        yaxis: {
                            min: 0,
                            max: 100,
                            tickAmount: 4,
                            labels: {
                                formatter: (value) => this.demoAnalyticsFormatCompact(value),
                                style: { colors: '#9ca3af', fontSize: '11px', fontWeight: 500 },
                            },
                        },
                        legend: {
                            show: false,
                        },
                        tooltip: {
                            shared: true,
                            intersect: false,
                            y: {
                                formatter: (value) => this.demoAnalyticsFormatCompact(value),
                            },
                        },
                    };

                    if (isColumn) {
                        chartOptions.plotOptions = {
                            bar: {
                                horizontal: false,
                                columnWidth: '58%',
                                borderRadius: 4,
                                borderRadiusApplication: 'end',
                            },
                        };
                        chartOptions.stroke = { show: true, width: 0 };
                        chartOptions.fill = { opacity: 1 };
                    } else {
                        chartOptions.stroke = {
                            curve: 'smooth',
                            width: series.map((_, index) => index < currentSeriesCount ? 2.5 : 2),
                            lineCap: 'round',
                            dashArray: series.map((_, index) => index < currentSeriesCount ? 0 : 6),
                        };
                        chartOptions.fill = {
                            type: 'gradient',
                            gradient: {
                                shadeIntensity: 0,
                                opacityFrom: series.map((_, index) => index < currentSeriesCount ? 0.28 : 0),
                                opacityTo: series.map((_, index) => index < currentSeriesCount ? 0.04 : 0),
                                stops: [0, 92, 100],
                            },
                        };
                        chartOptions.markers = {
                            size: 0,
                            strokeWidth: 0,
                            hover: { size: 4 },
                        };
                    }

                    this.demoAnalyticsApexChart = new window.ApexCharts(element, chartOptions);

                    const renderToken = this.demoAnalyticsApexRenderToken;
                    this.demoAnalyticsApexRenderFrame = requestAnimationFrame(() => {
                        if (this.demoAnalyticsApexChart) {
                            this.demoAnalyticsApexChart.render().then(() => {
                                if (this.demoAnalyticsApexRenderToken !== renderToken) {
                                    return;
                                }

                                this.updateDemoAnalyticsApexChartWidth();
                            }).catch(() => {});
                        }

                        this.demoAnalyticsApexRenderFrame = null;
                    });
                },
                demoAnalyticsYAxisTicks() {
                    return [100, 75, 50, 25, 0];
                },
                demoAnalyticsFormatCompact(value) {
                    const number = Number(value) || 0;

                    if (Math.abs(number) >= 1000000) {
                        return `${Math.round(number / 100000) / 10}M`;
                    }

                    if (Math.abs(number) >= 1000) {
                        return `${Math.round(number / 100) / 10}k`;
                    }

                    return String(Math.round(number));
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
                conversationMetricSummaryCards() {
                    return [
                        { label: 'Custom metrics tracked', value: '13', description: 'User-defined fields scored from AI conversation analysis.', icon: 'psychology' },
                        { label: 'Average responses', value: '2,329', description: 'Responses available per configured metric in this range.', icon: 'database' },
                        { label: 'Metric types', value: '3', description: 'Classified, Yes / No, and Score metrics shown. Text summaries are excluded.', icon: 'category' },
                    ];
                },
                conversationMetricTypeClass(type) {
                    return {
                        Classified: 'bg-indigo-50 text-indigo-700 ring-indigo-600/20',
                        'Yes / No': 'bg-emerald-50 text-emerald-700 ring-emerald-600/20',
                        Score: 'bg-gray-950 text-white ring-gray-950',
                    }[type] || 'bg-gray-50 text-gray-600 ring-gray-500/10';
                },
                isConversationMetricHighlighted(title) {
                    return this.highlightedConversationMetrics.includes(title);
                },
                toggleConversationMetricHighlight(title) {
                    this.highlightedConversationMetrics = this.isConversationMetricHighlighted(title)
                        ? this.highlightedConversationMetrics.filter((metricTitle) => metricTitle !== title)
                        : [...this.highlightedConversationMetrics, title];
                },
                conversationCustomMetrics() {
                    const classified = (title, sampleLabel, total, options) => ({
                        type: 'Classified',
                        title,
                        sampleLabel,
                        primaryValue: total.toLocaleString(),
                        primaryLabel: 'responses',
                        options: options.slice().sort((a, b) => b.value - a.value).slice(0, 6),
                    });
                    const score = (title, sampleLabel, average, total, min = 1, max = 10) => ({
                        type: 'Score',
                        title,
                        sampleLabel,
                        primaryValue: String(average),
                        primaryLabel: `Average from ${total.toLocaleString()} responses`,
                        scaleLabel: `${min}-${max} scale`,
                        scoreProgress: Math.max(0, Math.min(100, Math.round(((average - min) / (max - min)) * 100))),
                    });
                    const yesNo = (title, sampleLabel, trueRate, trueCount, total) => {
                        const falseRate = Math.round((100 - trueRate) * 100) / 100;

                        return {
                            type: 'Yes / No',
                            title,
                            sampleLabel,
                            primaryValue: `${trueRate}%`,
                            primaryLabel: `${trueCount.toLocaleString()} true out of ${total.toLocaleString()}`,
                            trueRate,
                            falseRate,
                            trueLabel: `${trueCount.toLocaleString()} true`,
                            falseLabel: `${(total - trueCount).toLocaleString()} false`,
                        };
                    };

                    const metrics = [
                        classified('Conversion result', 'Won / Lost / Follow-up', 2331, [
                            { label: 'No Decision', value: 82.58, color: 'bg-gray-900' },
                            { label: 'Negative', value: 10.85, color: 'bg-rose-500' },
                            { label: 'Positive', value: 6.56, color: 'bg-emerald-500' },
                        ]),
                        classified('Deal stage reached', 'Conversation stage classifier', 2331, [
                            { label: 'Introduction', value: 42.56, color: 'bg-indigo-600' },
                            { label: 'Qualification', value: 19.95, color: 'bg-sky-500' },
                            { label: 'Engagement', value: 16.52, color: 'bg-violet-500' },
                            { label: 'Conversation end', value: 10.73, color: 'bg-gray-500' },
                            { label: 'Solution alignment', value: 10.25, color: 'bg-emerald-500' },
                        ]),
                        score('Estimated intent level', 'AI-estimated lead intent', 3.71, 2330),
                        classified('Key turning point moment in the call', '6-7 moment classifier', 2329, [
                            { label: 'Critical discovery', value: 47.92, color: 'bg-indigo-600' },
                            { label: 'Commitment transition', value: 30.23, color: 'bg-emerald-500' },
                            { label: 'Value realization', value: 18.16, color: 'bg-sky-500' },
                            { label: 'Sentiment de-escalation', value: 2.79, color: 'bg-amber-500' },
                            { label: 'Objection overcome', value: 0.9, color: 'bg-violet-500' },
                        ]),
                        classified('Core pain points', 'Explicit and implicit pain points', 2329, [
                            { label: 'Checkout friction', value: 36.8, color: 'bg-indigo-600' },
                            { label: 'Other', value: 33.75, color: 'bg-gray-900' },
                            { label: 'Price concern', value: 17.56, color: 'bg-rose-500' },
                            { label: 'Not sure how it works', value: 4.25, color: 'bg-sky-500' },
                            { label: 'Ongoing subscription concern', value: 2.49, color: 'bg-amber-500' },
                            { label: 'Comparing other options', value: 1.93, color: 'bg-violet-500' },
                        ]),
                        classified('Desired outcomes / jobs-to-be-done', 'Outcome intent classifier', 2329, [
                            { label: 'Answer questions / remove confusion', value: 40.45, color: 'bg-indigo-600' },
                            { label: 'Create urgency', value: 29.67, color: 'bg-amber-500' },
                            { label: 'Other', value: 23.01, color: 'bg-gray-900' },
                            { label: 'Reduce risk', value: 5.54, color: 'bg-emerald-500' },
                            { label: 'Provide a discounted price', value: 0.86, color: 'bg-rose-500' },
                            { label: 'Qualify the prospect', value: 0.3, color: 'bg-sky-500' },
                        ]),
                        classified('Emotional drivers', 'Fear, urgency, status, cost sensitivity', 2329, [
                            { label: 'Cost sensitivity', value: 54.19, color: 'bg-rose-500' },
                            { label: 'Urgency', value: 43.41, color: 'bg-amber-500' },
                            { label: 'Fear', value: 1.5, color: 'bg-violet-500' },
                            { label: 'Status', value: 0.9, color: 'bg-sky-500' },
                        ]),
                        classified('Objection category', 'Price, trust, timing, need, competition', 2329, [
                            { label: 'None', value: 70.63, color: 'bg-gray-900' },
                            { label: 'Price', value: 14.26, color: 'bg-rose-500' },
                            { label: 'Need', value: 8.59, color: 'bg-indigo-600' },
                            { label: 'Trust', value: 3.52, color: 'bg-amber-500' },
                            { label: 'Timing', value: 2.36, color: 'bg-sky-500' },
                            { label: 'Competition', value: 0.64, color: 'bg-violet-500' },
                        ]),
                        classified('Objection resolved successfully?', 'Resolution outcome classifier', 2329, [
                            { label: 'No', value: 66.77, color: 'bg-rose-500' },
                            { label: 'Yes', value: 25.76, color: 'bg-emerald-500' },
                            { label: 'Partially', value: 7.47, color: 'bg-amber-500' },
                        ]),
                        yesNo('Checkout friction moments reported', 'Detected yes/no from conversation evidence', 8.76, 204, 2329),
                        classified('Interest triggers', 'Offers, features, or benefits that triggered interest', 2329, [
                            { label: '30-day money-back guarantee', value: 45.51, color: 'bg-emerald-500' },
                            { label: 'Other', value: 34.22, color: 'bg-gray-900' },
                            { label: 'Discount', value: 20.14, color: 'bg-indigo-600' },
                            { label: 'Free app', value: 0.09, color: 'bg-sky-500' },
                            { label: 'Limited offers', value: 0.04, color: 'bg-amber-500' },
                        ]),
                        score('AI Agent performance score', 'Client-defined agent quality score', 5.94, 2329),
                        classified('Pricing perception insights', 'Price acceptance and hesitation classifier', 2329, [
                            { label: 'Mild hesitation', value: 53.8, color: 'bg-amber-500' },
                            { label: 'Value uncertainty', value: 25.29, color: 'bg-indigo-600' },
                            { label: 'Positive price acceptance', value: 9.4, color: 'bg-emerald-500' },
                            { label: 'Delayed decision', value: 4.42, color: 'bg-gray-500' },
                            { label: 'Price shock', value: 3.26, color: 'bg-rose-500' },
                            { label: 'Budget constraint', value: 1.93, color: 'bg-violet-500' },
                        ]),
                    ];

                    if (this.highlightedConversationMetrics.length === 0) {
                        return metrics;
                    }

                    return metrics.slice().sort((a, b) => {
                        const aIndex = this.highlightedConversationMetrics.indexOf(a.title);
                        const bIndex = this.highlightedConversationMetrics.indexOf(b.title);
                        const aPinned = aIndex !== -1;
                        const bPinned = bIndex !== -1;

                        if (aPinned && bPinned) {
                            return aIndex - bIndex;
                        }

                        if (aPinned) {
                            return -1;
                        }

                        if (bPinned) {
                            return 1;
                        }

                        return 0;
                    });
                },
                engagementRangeScale() {
                    return {
                        'Last 24 Hours': 0.16,
                        'Last 7 Days': 1,
                        'Last 14 Days': 1.92,
                        'Last 30 Days': 4.35,
                        'All Time': 19.5,
                        'Custom range': 3.4,
                    }[this.activeAnalyticsRange] || 1;
                },
                engagementTimelineLabels() {
                    const dateLabels = this.analyticsTimelineDateLabels();

                    if (dateLabels?.length) {
                        return dateLabels;
                    }

                    return {
                        'Last 24 Hours': ['00', '03', '06', '09', '12', '15', '18', '21'],
                        'All Time': ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                    }[this.activeAnalyticsRange] || ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];
                },
                engagementTimelineData() {
                    const labels = this.engagementTimelineLabels();
                    const scale = this.engagementRangeScale();
                    const base = {
                        calls: [3180, 3340, 3270, 3560, 3710, 3920, 3840, 4140, 4380, 4210, 4560, 4720],
                        emails: [2510, 2580, 2540, 2420, 2380, 2810, 2760, 2880, 2930, 2860, 2980, 3070],
                        sms: [2310, 2380, 2340, 2680, 2720, 2610, 2560, 2680, 2730, 2660, 2780, 2870],
                        whatsapp: [1320, 1370, 1450, 1490, 1580, 1650, 1690, 1760, 1820, 1870, 1950, 2010],
                    };

                    return labels.map((label, index) => {
                        const factor = labels.length > 8 ? 0.42 : 1;

                        return {
                            label,
                            emails: Math.round(base.emails[index % base.emails.length] * scale * factor),
                            sms: Math.round(base.sms[index % base.sms.length] * scale * factor),
                            whatsapp: Math.round(base.whatsapp[index % base.whatsapp.length] * scale * factor),
                            calls: Math.round(base.calls[index % base.calls.length] * scale * factor),
                        };
                    });
                },
                engagementChannelDefinitions() {
                    return [
                        { label: 'Calls', cardLabel: 'Calls Made', key: 'calls', icon: 'phone', color: '#111827', tileClass: 'bg-indigo-50 text-indigo-600' },
                        { label: 'Emails', cardLabel: 'Emails Sent', key: 'emails', icon: 'mail', color: '#64748b', tileClass: 'bg-indigo-50 text-indigo-600' },
                        { label: 'SMS', cardLabel: 'SMS Sent', key: 'sms', icon: 'message_square', color: 'rgb(var(--oc-primary-600-rgb))', tileClass: 'bg-indigo-50 text-indigo-600' },
                        { label: 'WhatsApp', cardLabel: 'WhatsApp Sent', key: 'whatsapp', icon: 'message_circle', color: '#c7d2fe', tileClass: 'bg-indigo-50 text-indigo-600' },
                    ];
                },
                engagementComparisonLabel() {
                    return {
                        'Last 24 Hours': 'vs previous 24 hours',
                        'Last 7 Days': 'vs last week',
                        'Last 14 Days': 'vs previous 14 days',
                        'Last 30 Days': 'vs last month',
                    }[this.activeAnalyticsRange] || 'vs previous period';
                },
                engagementShouldShowTrend() {
                    return ! ['All Time', 'Custom range'].includes(this.activeAnalyticsRange);
                },
                engagementTrend(index) {
                    const rangeTrends = {
                        'Last 24 Hours': ['+3.1%', '+2.4%', '+1.7%', '+4.8%', '+2.8%', '+1.1%', '+3.6%', '-0.9%', '+2.2%', '+4.1%', '+1.6%', '+3.3%', '+2.5%', '+1.9%', '-1.2%', '+2.7%', '+3.8%', '+1.4%', '+2.1%', '-0.6%'],
                        'Last 7 Days': ['+5.8%', '+4.2%', '+6.7%', '+3.9%', '+2.5%', '+1.8%', '+4.4%', '-1.3%', '+3.6%', '+5.2%', '+2.7%', '+4.8%', '+3.1%', '+2.2%', '-0.8%', '+3.9%', '+4.6%', '+2.4%', '+3.5%', '-1.1%'],
                        'Last 14 Days': ['+4.6%', '+3.5%', '+5.1%', '+2.7%', '+3.4%', '+2.1%', '+3.8%', '-0.7%', '+2.9%', '+4.5%', '+2.3%', '+3.7%', '+2.6%', '+1.8%', '-1.5%', '+3.2%', '+4.1%', '+2.0%', '+2.8%', '-0.4%'],
                        'Last 30 Days': ['+8.9%', '+6.3%', '+9.4%', '+5.7%', '+4.8%', '+3.6%', '+6.1%', '-2.2%', '+5.3%', '+7.8%', '+4.2%', '+6.5%', '+4.9%', '+3.1%', '-1.9%', '+5.6%', '+7.2%', '+3.8%', '+4.4%', '-1.6%'],
                    };
                    const trend = (rangeTrends[this.activeAnalyticsRange] || rangeTrends['Last 7 Days'])[index % 20];

                    return {
                        trend,
                        trendDirection: trend.startsWith('-') ? 'down' : 'up',
                        comparisonLabel: this.engagementComparisonLabel(),
                        shouldShowTrend: this.engagementShouldShowTrend(),
                    };
                },
                engagementChannelActivityCards() {
                    const timeline = this.engagementTimelineData();
                    const definitions = this.engagementChannelDefinitions();
                    const totals = definitions.map((channel) => ({
                        ...channel,
                        total: timeline.reduce((sum, point) => sum + point[channel.key], 0),
                        trend: timeline.map((point) => point[channel.key]),
                    }));
                    const outreachTotal = totals.reduce((sum, channel) => sum + channel.total, 0);

                    return totals.map((channel, index) => ({
                        ...channel,
                        label: channel.cardLabel,
                        value: this.demoAnalyticsFormatCompact(channel.total),
                        shareLabel: `${Math.round((channel.total / Math.max(outreachTotal, 1)) * 100)}% of total outreach volume`,
                        ...this.engagementTrend(index),
                    }));
                },
                engagementOverviewMetrics() {
                    const scale = this.engagementRangeScale();
                    const started = Math.round(19129 * scale);
                    const outreachPositive = Math.round(1450 * scale);
                    const followUp = Math.round(620 * scale);
                    const outreachNoDecision = Math.round(5200 * scale);
                    const outreachNegative = Math.round(860 * scale);
                    const outreachUnreachable = Math.round(338 * scale);
                    const outreachNoResponse = Math.max(0, started - outreachPositive - outreachNegative - outreachNoDecision - outreachUnreachable);
                    const followUpNoDecision = Math.round(2200 * scale);
                    const followUpNegative = Math.round(360 * scale);
                    const followUpUnreachable = Math.round(210 * scale);
                    const followUpNoResponse = Math.round(520 * scale);
                    const barSet = (positive, noDecision, negative, unreachable, noResponse, total) => {
                        const denominator = Math.max(total, 1);
                        const progress = (value) => Math.max(1, Math.round((value / denominator) * 100));
                        return [
                            { label: 'Positive', value: positive.toLocaleString(), progress: progress(positive), color: 'bg-indigo-600' },
                            { label: 'Negative', value: negative.toLocaleString(), progress: progress(negative), color: 'bg-red-500' },
                            { label: 'No Decision', value: noDecision.toLocaleString(), progress: progress(noDecision), color: 'bg-gray-950' },
                            { label: 'Unreachable', value: unreachable.toLocaleString(), progress: progress(unreachable), color: 'bg-slate-500' },
                            { label: 'No Response', value: noResponse.toLocaleString(), progress: progress(noResponse), color: 'bg-gray-300' },
                        ];
                    };

                    return [
                        {
                            key: 'overview-outreach-positive',
                            label: 'Outreach Positive Answers',
                            icon: 'forum',
                            value: `${Math.round((outreachPositive / Math.max(started, 1)) * 1000) / 10}%`,
                            subtext: `${outreachPositive.toLocaleString()} positive answers out of ${started.toLocaleString()} started`,
                            details: [
                                { label: 'No Decision', value: outreachNoDecision.toLocaleString() },
                                { label: 'Negative', value: outreachNegative.toLocaleString() },
                            ],
                            bars: barSet(outreachPositive, outreachNoDecision, outreachNegative, outreachUnreachable, outreachNoResponse, started),
                            ...this.engagementTrend(4),
                        },
                        {
                            key: 'overview-followup-positive',
                            label: 'Follow-Up Positive Answers',
                            icon: 'reply',
                            value: `${Math.round((followUp / Math.max(started, 1)) * 1000) / 10}%`,
                            subtext: `${followUp.toLocaleString()} after follow-ups out of ${started.toLocaleString()} started`,
                            details: [
                                { label: 'No Decision', value: followUpNoDecision.toLocaleString() },
                                { label: 'Negative', value: followUpNegative.toLocaleString() },
                            ],
                            bars: barSet(followUp, followUpNoDecision, followUpNegative, followUpUnreachable, followUpNoResponse, started),
                            ...this.engagementTrend(5),
                        },
                    ];
                },
                engagementMetricValue(rate) {
                    return `${Math.round(rate * 10) / 10}%`;
                },
                engagementPerformanceGridStyle(group) {
                    return group?.metrics?.length === 2
                        ? 'grid-template-columns: minmax(0, 1fr) repeat(2, minmax(0, 1.5fr))'
                        : 'grid-template-columns: repeat(4, minmax(0, 1fr))';
                },
                analyticsChannelHeaderStyle(channelKey) {
                    return {
                        panelClass: 'oc-primary-bg-soft text-gray-950',
                        iconShellClass: 'bg-white/45 oc-primary-text',
                        titleTextClass: 'text-gray-950',
                        bodyTextClass: 'text-gray-700',
                    };
                },
                analyticsChannelMetricStyle() {
                    return {
                        panelClass: 'bg-white text-gray-950',
                        labelTextClass: 'text-gray-600',
                        valueTextClass: 'text-gray-950',
                        bodyTextClass: 'text-gray-600',
                        comparisonTextClass: 'text-gray-500',
                        trendUpTextClass: 'text-emerald-700',
                        trendDownTextClass: 'text-rose-600',
                        borderClass: 'border-gray-200',
                    };
                },
                engagementPerformanceGroups() {
                    const scale = this.engagementRangeScale();
                    const contacted = Math.round(963 * scale);
                    const smsContacted = Math.round(812 * scale);
                    const whatsappContacted = Math.round(426 * scale);
                    const callLeads = Math.round(318 * scale);
                    const count = (base) => Math.max(1, Math.round(base * scale));
                    const withTrend = (metric, trendIndex) => ({
                        ...metric,
                        ...this.engagementTrend(trendIndex),
                    });
                    const withPerformanceStyles = (group) => {
                        return {
                            ...group,
                            ...this.analyticsChannelHeaderStyle(group.channelKey),
                            metrics: group.metrics.map((metric) => ({
                                ...metric,
                                ...this.analyticsChannelMetricStyle(),
                            })),
                        };
                    };

                    return [
                        {
                            channelKey: 'calls',
                            title: 'Call Performance',
                            description: 'Answer, positive outcome, and duration quality for calls.',
                            icon: 'phone',
                            tileClass: 'bg-indigo-50 text-indigo-600',
                            showFlowArrows: true,
                            metrics: [
                                withTrend({ label: 'Call Answer Rate', value: this.engagementMetricValue(42.8), subtext: `${count(136).toLocaleString()} out of ${callLeads.toLocaleString()} leads answered at least one call` }, 16),
                                withTrend({ label: 'Positive Call Outcome Rate', value: this.engagementMetricValue(18.9), subtext: `${count(60).toLocaleString()} out of ${callLeads.toLocaleString()} called leads had a positive outcome` }, 18),
                                { label: 'Average Call Duration', value: '2m 14s', subtext: 'Average connected call duration in the selected date range' },
                            ],
                        },
                        {
                            channelKey: 'emails',
                            title: 'Email Performance',
                            description: 'Open and link click quality for lead email outreach.',
                            icon: 'mail',
                            tileClass: 'bg-indigo-50 text-indigo-600',
                            showFlowArrows: true,
                            metrics: [
                                withTrend({ label: 'Email Open Rate', value: this.engagementMetricValue(56.5), subtext: `${count(544).toLocaleString()} out of ${contacted.toLocaleString()} contacted leads opened at least one email` }, 7),
                                withTrend({ label: 'Email Link Click Rate', value: this.engagementMetricValue(7.7), subtext: `${count(74).toLocaleString()} out of ${contacted.toLocaleString()} contacted leads clicked a link in an email` }, 8),
                            ],
                        },
                        {
                            channelKey: 'sms',
                            title: 'SMS Performance',
                            description: 'Delivery, link click, and reply movement for SMS outreach.',
                            icon: 'message_square',
                            tileClass: 'bg-indigo-50 text-indigo-600',
                            showFlowArrows: true,
                            metrics: [
                                withTrend({ label: 'SMS Delivery Rate', value: this.engagementMetricValue(93.1), subtext: `${count(756).toLocaleString()} out of ${smsContacted.toLocaleString()} contacted leads received at least one SMS` }, 9),
                                withTrend({ label: 'SMS Link Click Rate', value: this.engagementMetricValue(9.2), subtext: `${count(75).toLocaleString()} out of ${smsContacted.toLocaleString()} contacted leads clicked a link in an SMS` }, 10),
                            ],
                        },
                        {
                            channelKey: 'whatsapp',
                            title: 'WhatsApp Performance',
                            description: 'Delivery, read, click, and reply tracking for WhatsApp outreach.',
                            icon: 'message_circle',
                            tileClass: 'bg-indigo-50 text-indigo-600',
                            showFlowArrows: true,
                            metrics: [
                                withTrend({ label: 'WhatsApp Delivery Rate', value: this.engagementMetricValue(91.5), subtext: `${count(390).toLocaleString()} out of ${whatsappContacted.toLocaleString()} contacted leads received a WhatsApp message` }, 12),
                                withTrend({ label: 'WhatsApp Read Rate', value: this.engagementMetricValue(68.3), subtext: `${count(291).toLocaleString()} out of ${whatsappContacted.toLocaleString()} contacted leads read a WhatsApp message` }, 13),
                                withTrend({ label: 'WhatsApp Link Click Rate', value: this.engagementMetricValue(11.5), subtext: `${count(49).toLocaleString()} out of ${whatsappContacted.toLocaleString()} contacted leads clicked a WhatsApp link` }, 14),
                            ],
                        },
                    ].map(withPerformanceStyles);
                },
                engagementReplyStepDistribution() {
                    const scale = this.engagementRangeScale();

                    return [
                        ['Step 1', 420],
                        ['Step 2', 318],
                        ['Step 3', 264],
                        ['Step 4', 192],
                        ['Step 5-6', 156],
                        ['Step 7-8', 118],
                        ['Step 9-10', 82],
                        ['Step 11-12', 54],
                        ['Step 13+', 31],
                    ].map(([label, value]) => ({ label, value: Math.round(value * scale) }));
                },
                engagementOutcomeDistribution() {
                    const scale = this.engagementRangeScale();

                    return [
                        ['Positive', 875],
                        ['Negative', 860],
                        ['No Decision', 3000],
                        ['Unreachable', 338],
                        ['No Response', 14056],
                    ].map(([label, value]) => ({ label, value: Math.round(value * scale) }));
                },
                engagementGoalAchievedByChannel() {
                    const scale = this.engagementRangeScale();
                    const values = {
                        Calls: 620,
                        Emails: 470,
                        SMS: 390,
                        WhatsApp: 210,
                    };
                    const colors = {
                        Calls: 'rgb(var(--oc-primary-600-rgb))',
                        Emails: 'rgb(var(--oc-primary-200-rgb))',
                        SMS: '#64748b',
                        WhatsApp: '#c7d2fe',
                    };

                    return this.engagementChannelDefinitions().map((channel) => ({
                        label: channel.label,
                        value: Math.round((values[channel.label] || 0) * scale),
                        color: colors[channel.label] || channel.color,
                    }));
                },
                overviewLeadIntakeTimeline() {
                    const timeline = this.demoAnalyticsTimeline();
                    const rangeScale = {
                        'Last 24 Hours': 18,
                        'Last 7 Days': 34,
                        'Last 14 Days': 30,
                        'Last 30 Days': 24,
                        'All Time': 46,
                        'Custom range': 32,
                    }[this.activeAnalyticsRange] || 34;

                    return timeline.map((point, index) => ({
                        label: point.label,
                        value: Math.round((point.runs + (index % 4) * 3) * rangeScale),
                    }));
                },
                overviewLeadIntakePreviousTimeline() {
                    return this.overviewLeadIntakeTimeline().map((point, index) => {
                        const variation = [0.78, 0.82, 0.76, 0.88, 0.81, 0.74, 0.86, 0.8][index % 8];

                        return {
                            label: point.label,
                            value: Math.max(0, Math.round(point.value * variation)),
                        };
                    });
                },
                overviewLeadIntakeSummary() {
                    const current = this.overviewLeadIntakeTimeline();
                    const previous = this.overviewLeadIntakePreviousTimeline();
                    const currentTotal = current.reduce((sum, point) => sum + point.value, 0);
                    const previousTotal = previous.reduce((sum, point) => sum + point.value, 0);
                    const change = previousTotal > 0
                        ? Math.round(((currentTotal - previousTotal) / previousTotal) * 1000) / 10
                        : 0;
                    const comparisonLabel = {
                        'Last 24 Hours': 'vs previous 24 hours',
                        'Last 7 Days': 'vs last week',
                        'Last 14 Days': 'vs previous 14 days',
                        'Last 30 Days': 'vs last month',
                        'All Time': 'vs last year',
                        'Custom range': 'vs previous range',
                    }[this.activeAnalyticsRange] || 'vs previous period';

                    return {
                        total: this.demoAnalyticsFormatCompact(currentTotal),
                        trend: `${change >= 0 ? '+' : ''}${change}%`,
                        trendDirection: change >= 0 ? 'up' : 'down',
                        shouldShowTrend: ! ['All Time', 'Custom range'].includes(this.activeAnalyticsRange),
                        comparisonLabel,
                    };
                },
                destroyEngagementApexChart(key) {
                    if (this.engagementApexRenderFrames[key]) {
                        cancelAnimationFrame(this.engagementApexRenderFrames[key]);
                        this.engagementApexRenderFrames[key] = null;
                    }

                    if (this.engagementApexCharts[key]) {
                        this.engagementApexCharts[key].destroy();
                        delete this.engagementApexCharts[key];
                    }
                },
                scheduleEngagementApexChartRender(key) {
                    if (this.engagementApexRenderFrames[key]) {
                        cancelAnimationFrame(this.engagementApexRenderFrames[key]);
                    }

                    const token = (this.engagementApexRenderTokens[key] || 0) + 1;
                    this.engagementApexRenderTokens[key] = token;
                    this.engagementApexRenderFrames[key] = requestAnimationFrame(() => {
                        this.engagementApexRenderFrames[key] = requestAnimationFrame(() => {
                            this.engagementApexRenderFrames[key] = null;

                            if (this.engagementApexRenderTokens[key] === token) {
                                this.renderEngagementApexChart(key);
                            }
                        });
                    });
                },
                engagementApexChartElement(key) {
                    return {
                        volume: this.$refs.engagementVolumeChart,
                        replyTiming: this.$refs.engagementReplyTimingChart,
                        leadIntake: this.$refs.overviewLeadIntakeChart,
                        goalByChannel: this.$refs.engagementGoalByChannelChart,
                        replySteps: this.$refs.engagementReplyStepsChart,
                        outcomes: this.$refs.engagementOutcomesChart,
                    }[key];
                },
                updateEngagementApexChartWidth(key) {
                    const width = this.analyticsChartWidth(this.engagementApexChartElement(key));

                    if (! width || ! this.engagementApexCharts[key]) {
                        return;
                    }

                    this.engagementApexCharts[key].updateOptions({
                        chart: { width },
                    }, false, true);
                },
                observeEngagementApexChart(key) {
                    const element = this.engagementApexChartElement(key);

                    if (! element || ! window.ResizeObserver || this.engagementApexResizeObservers[key]) {
                        return;
                    }

                    this.engagementApexResizeObservers[key] = new ResizeObserver(() => {
                        requestAnimationFrame(() => this.updateEngagementApexChartWidth(key));
                    });
                    this.engagementApexResizeObservers[key].observe(element);
                    element.parentElement && this.engagementApexResizeObservers[key].observe(element.parentElement);
                },
                renderEngagementApexChart(key) {
                    const element = this.engagementApexChartElement(key);

                    if (! element || ! window.ApexCharts) {
                        return;
                    }

                    this.observeEngagementApexChart(key);
                    this.destroyEngagementApexChart(key);
                    element.innerHTML = '';

                    const width = this.analyticsChartWidth(element);

                    if (! width) {
                        this.engagementApexRenderFrames[key] = requestAnimationFrame(() => this.renderEngagementApexChart(key));

                        return;
                    }

                    const baseOptions = {
                        chart: {
                            height: key === 'volume' ? 320 : (key === 'leadIntake' ? 360 : 280),
                            width,
                            toolbar: { show: false },
                            zoom: { enabled: false },
                            redrawOnParentResize: true,
                            redrawOnWindowResize: true,
                            animations: { enabled: true, easing: 'easeinout', speed: 300 },
                            fontFamily: 'Inter Variable, Inter, ui-sans-serif, system-ui, sans-serif',
                        },
                        dataLabels: { enabled: false },
                        grid: {
                            borderColor: '#e5e7eb',
                            xaxis: { lines: { show: false } },
                            yaxis: { lines: { show: false } },
                            padding: { top: 8, right: 12, bottom: 0, left: 4 },
                        },
                        legend: {
                            position: 'bottom',
                            horizontalAlign: 'left',
                            fontSize: '12px',
                            labels: { colors: '#6b7280' },
                            markers: { size: 7 },
                        },
                        tooltip: {
                            shared: true,
                            intersect: false,
                            y: { formatter: (value) => this.demoAnalyticsFormatCompact(value) },
                        },
                    };
                    let options = {};

                    if (key === 'leadIntake') {
                        const timeline = this.overviewLeadIntakeTimeline();
                        const previousTimeline = this.overviewLeadIntakePreviousTimeline();

                        options = {
                            ...baseOptions,
                            chart: { ...baseOptions.chart, type: 'area' },
                            series: [
                                {
                                    name: 'Lead intake',
                                    data: timeline.map((point) => point.value),
                                },
                                {
                                    name: 'Previous period',
                                    data: previousTimeline.map((point) => point.value),
                                },
                            ],
                            colors: [
                                this.demoAnalyticsApexColor('rgb(var(--oc-primary-600-rgb))'),
                                this.demoAnalyticsApexColorAlpha('#64748b', 0.5),
                            ],
                            stroke: { curve: 'smooth', width: [3, 2], lineCap: 'round', dashArray: [0, 6] },
                            fill: {
                                type: 'gradient',
                                gradient: {
                                    shade: 'light',
                                    shadeIntensity: 0,
                                    opacityFrom: [0.3, 0],
                                    opacityTo: [0.04, 0],
                                    stops: [0, 92, 100],
                                },
                            },
                            markers: {
                                size: 0,
                                strokeWidth: 0,
                                hover: { size: 4 },
                            },
                            xaxis: {
                                categories: timeline.map((point) => point.label),
                                tickAmount: ['Last 7 Days', 'Last 14 Days', 'Last 30 Days', 'Custom range'].includes(this.activeAnalyticsRange) && timeline.length <= 30 ? Math.max(1, timeline.length - 1) : 12,
                                axisBorder: { show: false },
                                axisTicks: { show: false },
                                labels: {
                                    rotate: -45,
                                    trim: false,
                                    hideOverlappingLabels: false,
                                    style: { colors: '#6b7280', fontSize: '12px', fontWeight: 500 },
                                },
                            },
                            yaxis: {
                                min: 0,
                                labels: {
                                    formatter: (value) => this.demoAnalyticsFormatCompact(value),
                                    style: { colors: '#6b7280', fontSize: '12px', fontWeight: 500 },
                                },
                            },
                            legend: {
                                show: true,
                                position: 'bottom',
                                horizontalAlign: 'left',
                                fontSize: '13px',
                                labels: { colors: '#6b7280' },
                                markers: { size: 7 },
                            },
                        };
                    } else if (key === 'replyTiming') {
                        const hours = this.replyTimingHourlyData();
                        const region = this.replyTimingActiveRegion();
                        const primaryColor = region.color || '#10b981';

                        options = {
                            ...baseOptions,
                            chart: {
                                ...baseOptions.chart,
                                type: 'area',
                                height: 320,
                                events: {
                                    markerClick: (_event, _chartContext, details) => {
                                        const hour = hours[details?.dataPointIndex];
                                        if (hour) {
                                            this.activeReplyTimingHour = hour.label;
                                        }
                                    },
                                    dataPointSelection: (_event, _chartContext, details) => {
                                        const hour = hours[details?.dataPointIndex];
                                        if (hour) {
                                            this.activeReplyTimingHour = hour.label;
                                        }
                                    },
                                },
                            },
                            series: [
                                {
                                    name: 'Reply rate',
                                    data: hours.map((hour) => hour.replyRateValue),
                                },
                                {
                                    name: 'Positive reply rate',
                                    data: hours.map((hour) => hour.positiveRateValue),
                                },
                            ],
                            colors: [
                                this.demoAnalyticsApexColor(primaryColor),
                                this.demoAnalyticsApexColorAlpha('#64748b', 0.72),
                            ],
                            stroke: { curve: 'smooth', width: [3, 2], lineCap: 'round', dashArray: [0, 5] },
                            fill: {
                                type: 'gradient',
                                gradient: {
                                    shade: 'light',
                                    shadeIntensity: 0,
                                    opacityFrom: [0.34, 0.08],
                                    opacityTo: [0.05, 0.01],
                                    stops: [0, 80, 100],
                                },
                            },
                            markers: {
                                size: hours.map((hour) => hour.label === this.activeReplyTimingHour ? 5 : 0),
                                strokeWidth: 2,
                                strokeColors: '#ffffff',
                                hover: { size: 5 },
                            },
                            xaxis: {
                                categories: hours.map((hour) => hour.label),
                                tickAmount: 7,
                                axisBorder: { show: false },
                                axisTicks: { show: false },
                                labels: {
                                    rotate: 0,
                                    style: { colors: '#6b7280', fontSize: '12px', fontWeight: 500 },
                                    formatter: (value) => String(value || '').replace(':00', ''),
                                },
                            },
                            yaxis: {
                                min: 0,
                                max: Math.max(24, Math.ceil(Math.max(...hours.map((hour) => hour.replyRateValue)) + 4)),
                                labels: {
                                    formatter: (value) => `${Math.round(value)}%`,
                                    style: { colors: '#9ca3af', fontSize: '11px', fontWeight: 500 },
                                },
                            },
                            tooltip: {
                                shared: true,
                                intersect: false,
                                y: { formatter: (value) => `${Math.round((Number(value) || 0) * 10) / 10}%` },
                            },
                        };
                    } else if (key === 'volume') {
                        const timeline = this.engagementTimelineData();
                        const selected = this.selectedEngagementChannels.length > 0 ? this.selectedEngagementChannels : ['Emails'];
                        const channels = this.engagementChannelDefinitions().filter((channel) => selected.includes(channel.label));
                        const isColumn = this.engagementTimelineView === 'column';

                        options = {
                            ...baseOptions,
                            chart: { ...baseOptions.chart, type: isColumn ? 'bar' : 'area' },
                            series: channels.map((channel) => ({
                                name: channel.cardLabel,
                                data: timeline.map((point) => point[channel.key]),
                            })),
                            colors: channels.map((channel) => this.demoAnalyticsApexColor(channel.color)),
                            xaxis: {
                                categories: timeline.map((point) => point.label),
                                tickAmount: ['Last 7 Days', 'Last 14 Days', 'Last 30 Days', 'Custom range'].includes(this.activeAnalyticsRange) && timeline.length <= 30 ? Math.max(1, timeline.length - 1) : undefined,
                                axisBorder: { show: false },
                                axisTicks: { show: false },
                                labels: {
                                    rotate: ['Last 7 Days', 'Last 14 Days', 'Last 30 Days', 'Custom range'].includes(this.activeAnalyticsRange) ? -45 : 0,
                                    trim: false,
                                    hideOverlappingLabels: false,
                                    style: { colors: '#6b7280', fontSize: '12px', fontWeight: 500 },
                                },
                            },
                            yaxis: {
                                labels: {
                                    formatter: (value) => this.demoAnalyticsFormatCompact(value),
                                    style: { colors: '#9ca3af', fontSize: '11px', fontWeight: 500 },
                                },
                            },
                        };

                        if (isColumn) {
                            options.plotOptions = {
                                bar: {
                                    horizontal: false,
                                    columnWidth: '58%',
                                    borderRadius: 4,
                                    borderRadiusApplication: 'end',
                                },
                            };
                            options.stroke = { show: true, width: 0 };
                            options.fill = { opacity: 1 };
                        } else {
                            options.stroke = { curve: 'smooth', width: 2.5, lineCap: 'round' };
                            options.fill = {
                                type: 'gradient',
                                gradient: {
                                    shade: 'light',
                                    shadeIntensity: 0,
                                    opacityFrom: 0.34,
                                    opacityTo: 0.06,
                                    stops: [0, 70, 100],
                                },
                            };
                            options.markers = {
                                size: 0,
                                strokeWidth: 0,
                                hover: { size: 4 },
                            };
                        }
                    } else {
                        const data = key === 'replySteps'
                            ? this.engagementReplyStepDistribution()
                            : (key === 'goalByChannel' ? this.engagementGoalAchievedByChannel() : this.engagementOutcomeDistribution());
                        const isGoalByChannel = key === 'goalByChannel';

                        options = {
                            ...baseOptions,
                            chart: { ...baseOptions.chart, type: 'bar' },
                            series: [{ name: key === 'replySteps' ? 'Replies' : (isGoalByChannel ? 'Goals achieved' : 'Outcomes'), data: data.map((item) => item.value) }],
                            colors: isGoalByChannel ? data.map((item) => this.demoAnalyticsApexColor(item.color)) : [key === 'replySteps' ? '#64748b' : 'rgb(var(--oc-primary-500-rgb))'],
                            grid: {
                                ...baseOptions.grid,
                                borderColor: isGoalByChannel ? '#1f2937' : baseOptions.grid.borderColor,
                            },
                            plotOptions: {
                                bar: {
                                    horizontal: false,
                                    columnWidth: '52%',
                                    borderRadius: 4,
                                    borderRadiusApplication: 'end',
                                    distributed: isGoalByChannel,
                                },
                            },
                            stroke: { width: 0 },
                            xaxis: {
                                categories: data.map((item) => item.label),
                                axisBorder: { show: false },
                                axisTicks: { show: false },
                                labels: { rotate: -25, style: { colors: isGoalByChannel ? '#d1d5db' : '#6b7280', fontSize: '12px', fontWeight: 500 } },
                            },
                            yaxis: {
                                labels: {
                                    formatter: (value) => this.demoAnalyticsFormatCompact(value),
                                    style: { colors: isGoalByChannel ? '#9ca3af' : '#9ca3af', fontSize: '11px', fontWeight: 500 },
                                },
                            },
                            legend: { show: false },
                            tooltip: {
                                ...baseOptions.tooltip,
                                theme: isGoalByChannel ? 'dark' : 'light',
                            },
                        };
                    }

                    this.engagementApexCharts[key] = new window.ApexCharts(element, options);
                    const renderToken = this.engagementApexRenderTokens[key] || 0;
                    this.engagementApexRenderFrames[key] = requestAnimationFrame(() => {
                        this.engagementApexCharts[key]?.render().then(() => {
                            if ((this.engagementApexRenderTokens[key] || 0) !== renderToken) {
                                return;
                            }

                            this.updateEngagementApexChartWidth(key);
                        });
                        this.engagementApexRenderFrames[key] = null;
                    });
                },
                demoAnalyticsRangeScale() {
                    return {
                        'Last 24 Hours': 0.18,
                        'Last 7 Days': 1,
                        'Last 14 Days': 2,
                        'Last 30 Days': 4,
                        'All Time': 48,
                        'Custom range': 5.2,
                    }[this.activeAnalyticsRange] || 1;
                },
                demoAnalyticsMetricNumber(value) {
                    const stringValue = String(value || '').toLowerCase();
                    const parsed = Number(stringValue.replace(/[^0-9.-]/g, '')) || 0;
                    const multiplier = stringValue.includes('m') ? 1000000 : (stringValue.includes('k') ? 1000 : 1);

                    return parsed * multiplier;
                },
                demoAnalyticsFormatMetricValue(originalValue, value) {
                    const original = String(originalValue || '');
                    const isCurrency = original.includes('$');
                    const number = Math.max(0, Math.round(Number(value) || 0));
                    const compact = this.demoAnalyticsFormatCompact(number);

                    if (isCurrency) {
                        return `$${compact}`;
                    }

                    return number >= 10000 ? compact : number.toLocaleString();
                },
                demoAnalyticsPrimaryMetrics() {
                    const shouldShowTrend = ! ['All Time', 'Custom range'].includes(this.activeAnalyticsRange);
                    const config = this.analyticsCampaignConfig();
                    const comparisonLabel = {
                        'Last 24 Hours': 'vs previous 24 hours',
                        'Last 7 Days': 'vs last week',
                        'Last 14 Days': 'vs previous 14 days',
                        'Last 30 Days': 'vs last month',
                        'All Time': 'vs last year',
                        'Custom range': 'vs previous range',
                    }[this.activeAnalyticsRange] || 'vs last week';
                    const rangeTrends = {
                        'Last 24 Hours': ['+4.4%', '+7.1%', '-2.3%', '+5.8%'],
                        'Last 7 Days': ['+8.2%', '+6.4%', '+11.7%', '-3.1%'],
                        'Last 14 Days': ['+5.6%', '+9.3%', '+7.8%', '+2.4%'],
                        'Last 30 Days': ['+12.5%', '+4.9%', '+15.2%', '-1.8%'],
                        'All Time': ['+22.8%', '+18.1%', '+31.4%', '+9.6%'],
                        'Custom range': ['+6.9%', '-2.7%', '+8.5%', '+3.3%'],
                    };
                    const trends = rangeTrends[this.activeAnalyticsRange] || rangeTrends['Last 7 Days'];
                    const rangeScale = this.demoAnalyticsRangeScale();
                    const scaledMetrics = config.metrics.map((metric) => {
                        const numericValue = this.demoAnalyticsMetricNumber(metric.value);

                        return {
                            ...metric,
                            value: numericValue > 0 ? this.demoAnalyticsFormatMetricValue(metric.value, numericValue * rangeScale) : metric.value,
                        };
                    });
                    const started = this.demoAnalyticsMetricNumber(scaledMetrics[0]?.value);
                    const engaged = this.demoAnalyticsMetricNumber(scaledMetrics[1]?.value);
                    const engagementRate = started > 0 ? `${Math.round((engaged / started) * 1000) / 10}%` : '';

                    return scaledMetrics.map((metric, index) => ({
                        ...metric,
                        label: index === 0 ? 'Campaign Runs' : (index === 1 ? 'Engaged' : metric.label),
                        titleLabel: index === 1 && engagementRate ? `Engaged (${engagementRate})` : '',
                        trend: trends[index],
                        trendDirection: trends[index].startsWith('-') ? 'down' : 'up',
                        comparisonLabel,
                        shouldShowTrend,
                    }));
                },
                demoAnalyticsFunnelGridStyle() {
                    const metricCount = this.demoAnalyticsPrimaryMetrics().length;
                    const columns = Array.from({ length: Math.max(1, metricCount * 2 - 1) }, (_, index) => (
                        index % 2 === 0 ? 'minmax(0, 1fr)' : '48px'
                    ));

                    return `grid-template-columns: ${columns.join(' ')}`;
                },
                demoAnalyticsPreviousTimeline() {
                    const flexByKey = {
                        runs: [0.84, 0.78, 0.88, 0.81, 0.9, 0.76, 0.86, 0.82],
                        engaged: [0.78, 0.86, 0.8, 0.9, 0.75, 0.84, 0.88, 0.79],
                        converted: [0.72, 0.82, 0.77, 0.89, 0.8, 0.74, 0.92, 0.83],
                        final: [0.76, 0.7, 0.84, 0.79, 0.87, 0.73, 0.81, 0.9],
                    };
                    const driftByKey = {
                        runs: [2, -4, 5, -2, 4, -5, 1],
                        engaged: [-3, 4, -2, 5, -5, 2, 3],
                        converted: [1, -3, 4, -4, 3, -2, 5],
                        final: [-2, 3, -4, 2, -1, 4, -3],
                    };

                    return this.demoAnalyticsTimeline().map((point, index) => {
                        const previous = { label: point.label };

                        ['runs', 'engaged', 'converted', 'final'].forEach((key, keyIndex) => {
                            const flex = flexByKey[key][index % flexByKey[key].length];
                            const drift = driftByKey[key][index % driftByKey[key].length];
                            const wave = Math.sin((index + 1) * (0.72 + keyIndex * 0.13)) * (2.5 + keyIndex);
                            const value = Math.round((Number(point[key]) || 0) * flex + drift + wave);

                            previous[key] = Math.max(0, Math.min(100, value));
                        });

                        previous.engaged = Math.min(previous.engaged, Math.max(0, previous.runs - 4));
                        previous.converted = Math.min(previous.converted, Math.max(0, previous.engaged - 6));
                        previous.final = Math.min(previous.final, Math.max(0, previous.converted - 4));

                        return previous;
                    });
                },
                demoAnalyticsTimeline() {
                    const ranges = {
                        'Last 24 Hours': [
                            { label: '00', engaged: 28, converted: 8 },
                            { label: '01', engaged: 24, converted: 7 },
                            { label: '02', engaged: 18, converted: 5 },
                            { label: '03', engaged: 15, converted: 4 },
                            { label: '04', engaged: 17, converted: 4 },
                            { label: '05', engaged: 22, converted: 6 },
                            { label: '06', engaged: 31, converted: 9 },
                            { label: '07', engaged: 38, converted: 13 },
                            { label: '08', engaged: 45, converted: 17 },
                            { label: '09', engaged: 52, converted: 22 },
                            { label: '10', engaged: 61, converted: 28 },
                            { label: '11', engaged: 57, converted: 24 },
                            { label: '12', engaged: 66, converted: 31 },
                            { label: '13', engaged: 72, converted: 35 },
                            { label: '14', engaged: 69, converted: 32 },
                            { label: '15', engaged: 76, converted: 39 },
                            { label: '16', engaged: 82, converted: 44 },
                            { label: '17', engaged: 74, converted: 36 },
                            { label: '18', engaged: 67, converted: 30 },
                            { label: '19', engaged: 59, converted: 25 },
                            { label: '20', engaged: 54, converted: 21 },
                            { label: '21', engaged: 48, converted: 18 },
                            { label: '22', engaged: 42, converted: 15 },
                            { label: '23', engaged: 36, converted: 12 },
                        ],
                        'Last 7 Days': [
                            { label: 'Mon', engaged: 46, converted: 18 },
                            { label: 'Tue', engaged: 58, converted: 24 },
                            { label: 'Wed', engaged: 51, converted: 20 },
                            { label: 'Thu', engaged: 72, converted: 35 },
                            { label: 'Fri', engaged: 68, converted: 31 },
                            { label: 'Sat', engaged: 81, converted: 44 },
                            { label: 'Sun', engaged: 63, converted: 29 },
                        ],
                        'Last 14 Days': [
                            { label: 'D1', engaged: 37, converted: 11 },
                            { label: 'D2', engaged: 42, converted: 14 },
                            { label: 'D3', engaged: 48, converted: 17 },
                            { label: 'D4', engaged: 44, converted: 16 },
                            { label: 'D5', engaged: 55, converted: 21 },
                            { label: 'D6', engaged: 51, converted: 19 },
                            { label: 'D7', engaged: 62, converted: 27 },
                            { label: 'D8', engaged: 58, converted: 24 },
                            { label: 'D9', engaged: 67, converted: 31 },
                            { label: 'D10', engaged: 72, converted: 36 },
                            { label: 'D11', engaged: 64, converted: 29 },
                            { label: 'D12', engaged: 76, converted: 40 },
                            { label: 'D13', engaged: 81, converted: 45 },
                            { label: 'D14', engaged: 74, converted: 37 },
                        ],
                        'Last 30 Days': [
                            { label: '1', engaged: 42, converted: 14 },
                            { label: '2', engaged: 48, converted: 17 },
                            { label: '3', engaged: 51, converted: 19 },
                            { label: '4', engaged: 55, converted: 21 },
                            { label: '5', engaged: 47, converted: 16 },
                            { label: '6', engaged: 53, converted: 20 },
                            { label: '7', engaged: 49, converted: 18 },
                            { label: '8', engaged: 61, converted: 25 },
                            { label: '9', engaged: 64, converted: 29 },
                            { label: '10', engaged: 67, converted: 31 },
                            { label: '11', engaged: 60, converted: 27 },
                            { label: '12', engaged: 56, converted: 23 },
                            { label: '13', engaged: 58, converted: 26 },
                            { label: '14', engaged: 66, converted: 32 },
                            { label: '15', engaged: 71, converted: 36 },
                            { label: '16', engaged: 74, converted: 39 },
                            { label: '17', engaged: 69, converted: 35 },
                            { label: '18', engaged: 65, converted: 31 },
                            { label: '19', engaged: 63, converted: 28 },
                            { label: '20', engaged: 76, converted: 40 },
                            { label: '21', engaged: 79, converted: 43 },
                            { label: '22', engaged: 81, converted: 45 },
                            { label: '23', engaged: 73, converted: 38 },
                            { label: '24', engaged: 70, converted: 34 },
                            { label: '25', engaged: 76, converted: 41 },
                            { label: '26', engaged: 82, converted: 47 },
                            { label: '27', engaged: 78, converted: 43 },
                            { label: '28', engaged: 69, converted: 32 },
                            { label: '29', engaged: 84, converted: 46 },
                            { label: '30', engaged: 88, converted: 48 },
                        ],
                        'All Time': [
                            { label: 'Jan', engaged: 39, converted: 14 },
                            { label: 'Feb', engaged: 44, converted: 17 },
                            { label: 'Mar', engaged: 52, converted: 22 },
                            { label: 'Apr', engaged: 48, converted: 20 },
                            { label: 'May', engaged: 61, converted: 29 },
                            { label: 'Jun', engaged: 68, converted: 34 },
                            { label: 'Jul', engaged: 73, converted: 39 },
                            { label: 'Aug', engaged: 69, converted: 36 },
                            { label: 'Sep', engaged: 77, converted: 42 },
                            { label: 'Oct', engaged: 83, converted: 47 },
                            { label: 'Nov', engaged: 79, converted: 43 },
                            { label: 'Dec', engaged: 90, converted: 52 },
                        ],
                        'Custom range': [
                            { label: 'May 1', engaged: 35, converted: 12 },
                            { label: 'May 3', engaged: 48, converted: 18 },
                            { label: 'May 5', engaged: 44, converted: 16 },
                            { label: 'May 7', engaged: 59, converted: 24 },
                            { label: 'May 9', engaged: 63, converted: 30 },
                            { label: 'May 11', engaged: 57, converted: 25 },
                            { label: 'May 13', engaged: 72, converted: 38 },
                            { label: 'May 15', engaged: 68, converted: 33 },
                            { label: 'May 17', engaged: 83, converted: 46 },
                            { label: 'May 19', engaged: 76, converted: 40 },
                            { label: 'May 21', engaged: 91, converted: 55 },
                            { label: 'May 23', engaged: 80, converted: 43 },
                            { label: 'May 25', engaged: 86, converted: 50 },
                            { label: 'May 27', engaged: 74, converted: 37 },
                        ],
                    };

                    const config = this.analyticsCampaignConfig();
                    const range = ranges[this.activeAnalyticsRange] || ranges['Last 7 Days'];
                    const dateLabels = this.analyticsTimelineDateLabels();
                    const timelineItems = dateLabels?.length
                        ? dateLabels.map((label, index) => ({ ...(range[index % range.length] || range[0]), label }))
                        : range;
                    const seriesMeta = this.demoAnalyticsTimelineSeriesMeta();

                    return timelineItems.map((item) => {
                        const engaged = Math.min(96, Math.round(item.engaged * config.engagedMultiplier));
                        const converted = Math.min(92, Math.round(item.converted * config.convertedMultiplier));
                        const final = Math.min(88, Math.round(converted * 0.68));
                        const runs = Math.min(100, Math.max(engaged + 8, Math.round(item.engaged * 1.18)));
                        const values = { runs, engaged, converted, final };
                        const series = seriesMeta.map((metric) => ({
                            ...metric,
                            value: values[metric.key] || 0,
                        }));

                        return {
                            ...item,
                            runs,
                            engaged,
                            converted,
                            final,
                            selected: series[0]?.value || engaged,
                            series,
                        };
                    });
                },
                demoAnalyticsAttributionRules() {
                    return [
                        { title: 'Call based attribution', description: 'If a lead spoke longer than 45 seconds and converted within 7 days, attribute conversion to Outcraft.', icon: 'call' },
                        { title: 'Click based attribution', description: 'If a lead clicked an email/SMS link and converted within 7 days, attribute conversion to Outcraft.', icon: 'ads_click' },
                        { title: 'Coupon based proof', description: 'Track coupon code usage count as the primary demo-safe revenue proxy.', icon: 'confirmation_number' },
                    ];
                },
                demoAnalyticsOutcomes() {
                    return [
                        { label: 'No Decision', count: 174, progress: 70, color: 'bg-gray-900' },
                        { label: 'Positive', count: 250, progress: 100, color: 'bg-green-600' },
                        { label: 'Negative', count: 76, progress: 30, color: 'bg-red-500' },
                    ];
                },
                demoAnalyticsCallFlow() {
                    return [
                        { label: 'Reached 5s threshold', value: '620 leads', progress: 62 },
                        { label: 'Reached 30s threshold', value: '408 leads', progress: 41 },
                        { label: 'Reached CTA stage', value: '286 leads', progress: 29 },
                        { label: 'Converted after CTA', value: '250 leads', progress: 25 },
                    ];
                },
                replyTimingRegionOptions() {
                    return [
                        { key: 'us-east', label: 'US East', color: '#10b981', replyShift: 0, volumeShift: 0, positiveShift: 0, responseShift: 0 },
                        { key: 'uk-ireland', label: 'UK & Ireland', color: '#0ea5e9', replyShift: 0.7, volumeShift: -1, positiveShift: 2, responseShift: -8 },
                        { key: 'dach', label: 'DACH', color: '#6366f1', replyShift: -1.5, volumeShift: -2, positiveShift: -1, responseShift: 18 },
                        { key: 'baltics', label: 'Baltics', color: '#14b8a6', replyShift: -0.5, volumeShift: -5, positiveShift: 1, responseShift: 10 },
                        { key: 'india', label: 'India', color: '#f59e0b', replyShift: -1.2, volumeShift: 4, positiveShift: -2, responseShift: 24 },
                        { key: 'apac', label: 'APAC', color: '#ec4899', replyShift: 0.2, volumeShift: -3, positiveShift: 3, responseShift: -14 },
                    ];
                },
                replyTimingActiveRegion() {
                    return this.replyTimingRegionOptions().find((region) => region.key === this.activeReplyTimingRegion) || this.replyTimingRegionOptions()[0];
                },
                setReplyTimingRegion(region) {
                    this.activeReplyTimingRegion = region;
                    this.activeReplyTimingHour = this.replyTimingBestWindow().focusHour;
                    this.$nextTick(() => this.scheduleEngagementApexChartRender('replyTiming'));
                },
                replyTimingHourlyData() {
                    const scale = this.demoAnalyticsRangeScale();
                    const region = this.replyTimingActiveRegion();
                    const rangeBoost = Math.min(1.8, Math.max(0.72, Math.sqrt(scale)));
                    const base = [
                        { hour: 0, replies: 10, replyRate: 2.8, positiveRate: 18, responseMinutes: 410 },
                        { hour: 1, replies: 7, replyRate: 2.1, positiveRate: 16, responseMinutes: 455 },
                        { hour: 2, replies: 5, replyRate: 1.6, positiveRate: 14, responseMinutes: 520 },
                        { hour: 3, replies: 4, replyRate: 1.2, positiveRate: 13, responseMinutes: 560 },
                        { hour: 4, replies: 6, replyRate: 1.8, positiveRate: 15, responseMinutes: 500 },
                        { hour: 5, replies: 11, replyRate: 3.2, positiveRate: 20, responseMinutes: 380 },
                        { hour: 6, replies: 24, replyRate: 6.4, positiveRate: 25, responseMinutes: 230 },
                        { hour: 7, replies: 44, replyRate: 10.9, positiveRate: 31, responseMinutes: 150 },
                        { hour: 8, replies: 72, replyRate: 16.1, positiveRate: 38, responseMinutes: 82 },
                        { hour: 9, replies: 96, replyRate: 21.4, positiveRate: 44, responseMinutes: 54 },
                        { hour: 10, replies: 88, replyRate: 19.7, positiveRate: 41, responseMinutes: 61 },
                        { hour: 11, replies: 63, replyRate: 14.8, positiveRate: 36, responseMinutes: 93 },
                        { hour: 12, replies: 42, replyRate: 9.6, positiveRate: 29, responseMinutes: 170 },
                        { hour: 13, replies: 51, replyRate: 11.8, positiveRate: 32, responseMinutes: 142 },
                        { hour: 14, replies: 67, replyRate: 15.5, positiveRate: 37, responseMinutes: 98 },
                        { hour: 15, replies: 84, replyRate: 18.9, positiveRate: 40, responseMinutes: 72 },
                        { hour: 16, replies: 79, replyRate: 17.4, positiveRate: 39, responseMinutes: 86 },
                        { hour: 17, replies: 58, replyRate: 12.7, positiveRate: 33, responseMinutes: 128 },
                        { hour: 18, replies: 34, replyRate: 7.9, positiveRate: 26, responseMinutes: 210 },
                        { hour: 19, replies: 26, replyRate: 6.1, positiveRate: 23, responseMinutes: 250 },
                        { hour: 20, replies: 21, replyRate: 5.2, positiveRate: 21, responseMinutes: 285 },
                        { hour: 21, replies: 18, replyRate: 4.4, positiveRate: 20, responseMinutes: 320 },
                        { hour: 22, replies: 15, replyRate: 3.8, positiveRate: 19, responseMinutes: 350 },
                        { hour: 23, replies: 12, replyRate: 3.1, positiveRate: 18, responseMinutes: 390 },
                    ];
                    const maxReplies = Math.max(...base.map((hour) => hour.replies));

                    return base.map((hour) => {
                        const workingHoursLift = hour.hour >= 8 && hour.hour <= 16 ? 1 : 0;
                        const lateLift = ['india', 'apac'].includes(region.key) && hour.hour >= 14 && hour.hour <= 18 ? 1.5 : 0;
                        const replies = Math.max(1, Math.round((hour.replies + region.volumeShift + lateLift * 4) * rangeBoost));
                        const replyRateValue = Math.max(0.6, Math.round((hour.replyRate + region.replyShift + workingHoursLift * Math.max(0, region.replyShift) + lateLift + (rangeBoost - 1) * 0.8) * 10) / 10);
                        const positiveRateValue = Math.max(8, Math.round(Math.min(62, hour.positiveRate + region.positiveShift + (rangeBoost - 1) * 4)));
                        const label = `${String(hour.hour).padStart(2, '0')}:00`;
                        const adjustedResponseMinutes = Math.max(32, hour.responseMinutes + region.responseShift - (replyRateValue >= 15 ? 12 : 0));
                        const responseHours = Math.floor(adjustedResponseMinutes / 60);
                        const responseMinutes = adjustedResponseMinutes % 60;

                        return {
                            ...hour,
                            label,
                            replies,
                            replyRateValue,
                            replyRate: `${replyRateValue}%`,
                            positiveRateValue,
                            positiveRate: `${positiveRateValue}%`,
                            responseTime: responseHours > 0 ? `${responseHours}h ${responseMinutes}m` : `${responseMinutes}m`,
                            height: Math.max(5, Math.round((hour.replies / maxReplies) * 100)),
                            tone: replyRateValue >= 15 ? 'high' : (replyRateValue <= 4 ? 'low' : 'medium'),
                            spike: replyRateValue >= 15,
                            stats: [
                                { label: 'Replies', value: replies.toLocaleString() },
                                { label: 'Reply rate', value: `${replyRateValue}%` },
                                { label: 'Avg response', value: responseHours > 0 ? `${responseHours}h ${responseMinutes}m` : `${responseMinutes}m` },
                            ],
                        };
                    });
                },
                replyTimingSelectedHour() {
                    const hours = this.replyTimingHourlyData();

                    return hours.find((hour) => hour.label === this.activeReplyTimingHour) || hours[9] || hours[0];
                },
                replyTimingBestWindow() {
                    return this.replyTimingBestWindows()[0];
                },
                replyTimingBestWindows() {
                    const windows = {
                        'us-east': [
                            { range: '08:00-10:30', focusHour: '09:00', replyRate: '21.4%', copy: 'Primary send window', insight: 'Leads reply fastest after morning inbox triage. Schedule first touches here and put high-value follow-ups near the same window.' },
                            { range: '14:30-16:30', focusHour: '15:00', replyRate: '18.9%', copy: 'Strong afternoon follow-up window', insight: 'Afternoon replies are strong enough for reminders and second touches.' },
                            { range: '10:30-11:30', focusHour: '10:00', replyRate: '19.7%', copy: 'Good for second-touch reminders', insight: 'Late morning keeps momentum after the first spike.' },
                        ],
                        'uk-ireland': [
                            { range: '09:00-11:00', focusHour: '09:00', replyRate: '22.1%', copy: 'Best reply spike', insight: 'UK and Ireland leads cluster around the first focused inbox block, especially midweek.' },
                            { range: '15:00-16:30', focusHour: '15:00', replyRate: '19.6%', copy: 'Good follow-up window', insight: 'Late afternoon works well for short follow-ups.' },
                            { range: '10:00-11:30', focusHour: '10:00', replyRate: '20.4%', copy: 'Strong backup window', insight: 'Use this when morning send volume is already high.' },
                        ],
                        dach: [
                            { range: '10:00-12:00', focusHour: '10:00', replyRate: '18.2%', copy: 'Primary DACH window', insight: 'DACH replies arrive after inbox triage. Keep the CTA precise and operational.' },
                            { range: '14:00-16:00', focusHour: '15:00', replyRate: '17.4%', copy: 'Afternoon follow-up window', insight: 'Follow-ups perform better than new first touches in this window.' },
                            { range: '08:30-09:30', focusHour: '09:00', replyRate: '16.0%', copy: 'Early backup', insight: 'Useful for highly qualified accounts only.' },
                        ],
                        baltics: [
                            { range: '08:00-10:00', focusHour: '09:00', replyRate: '20.7%', copy: 'Best local window', insight: 'Baltics leads reply early. Avoid waiting until lunch for first touches.' },
                            { range: '14:30-16:00', focusHour: '15:00', replyRate: '18.4%', copy: 'Follow-up spike', insight: 'Works best for already engaged leads.' },
                            { range: '10:00-11:00', focusHour: '10:00', replyRate: '18.9%', copy: 'Backup morning slot', insight: 'Good when the first spike is saturated.' },
                        ],
                        india: [
                            { range: '11:00-13:00', focusHour: '11:00', replyRate: '17.8%', copy: 'Primary India window', insight: 'India replies peak later in the workday. Put calendar-first CTAs here.' },
                            { range: '15:00-17:30', focusHour: '16:00', replyRate: '19.1%', copy: 'Late workday spike', insight: 'Decision-maker replies often come after internal meetings.' },
                            { range: '09:30-10:30', focusHour: '10:00', replyRate: '16.2%', copy: 'Morning backup', insight: 'Good for follow-ups, weaker for first touches.' },
                        ],
                        apac: [
                            { range: '09:30-11:30', focusHour: '10:00', replyRate: '20.1%', copy: 'Fastest response window', insight: 'APAC responds quickly in the morning. Keep follow-ups tight.' },
                            { range: '14:00-16:30', focusHour: '15:00', replyRate: '20.3%', copy: 'Second spike', insight: 'Afternoon spike is almost as strong as the morning window.' },
                            { range: '16:00-17:30', focusHour: '16:00', replyRate: '18.7%', copy: 'Late backup', insight: 'Useful for senior leads who reply near day end.' },
                        ],
                    };

                    return windows[this.activeReplyTimingRegion] || windows['us-east'];
                },
                replyTimingQuietWindows() {
                    const lateQuiet = ['india', 'apac'].includes(this.activeReplyTimingRegion)
                        ? { range: '00:00-05:30', focusHour: '03:00', replyRate: '1.5%', copy: 'Avoid new sends' }
                        : { range: '01:00-04:30', focusHour: '03:00', replyRate: '1.2%', copy: 'Avoid new sends' };

                    return [
                        lateQuiet,
                        { range: '20:00-23:30', focusHour: '22:00', replyRate: '3.8%', copy: 'Low intent and slower response' },
                        { range: '12:00-13:30', focusHour: '12:00', replyRate: '9.6%', copy: 'Lunch dip, use only for reminders' },
                    ];
                },
                demoAnalyticsRateSplit() {
                    const config = this.analyticsCampaignConfig();
                    const metrics = this.demoAnalyticsPrimaryMetrics();
                    const runs = this.demoAnalyticsMetricNumber(metrics[0]?.value);
                    const engaged = this.demoAnalyticsMetricNumber(metrics[1]?.value);
                    const outcome = this.demoAnalyticsMetricNumber(metrics[2]?.value);
                    const percent = (numerator, denominator) => denominator > 0 ? `${Math.round((numerator / denominator) * 1000) / 10}%` : '0%';
                    const label = config.rateLabel || 'Outcome Rate';
                    const shortLabel = label.replace(' Rate', '');
                    const outcomeLabel = String(metrics[2]?.label || 'outcomes').toLowerCase();

                    return {
                        label,
                        shortLabel,
                        description: `Show ${label.toLowerCase()} from all campaign runs and from engaged leads.`,
                        engagedRate: percent(outcome, engaged),
                        allRate: percent(outcome, runs),
                        engagedCopy: `${engaged.toLocaleString()} engaged leads -> ${outcome.toLocaleString()} ${outcomeLabel}`,
                        allCopy: `${runs.toLocaleString()} campaign runs -> ${outcome.toLocaleString()} ${outcomeLabel}`,
                    };
                },
                demoAnalyticsChannels() {
                    return [
                        { label: 'Calls', value: '740', icon: 'call' },
                        { label: 'Callbacks', value: '118', icon: 'phone_callback' },
                        { label: 'Email clicked', value: '184', icon: 'mail' },
                        { label: 'SMS clicked', value: '96', icon: 'sms' },
                    ];
                },
                demoAnalyticsB2BNotes() {
                    return [
                        'For non-commerce campaigns, replace coupon usage with booked meetings.',
                        'Show booking source by channel: call, email, SMS, form, calendar link.',
                        'Add email reply rate, SMS reply rate, and call connect rate.',
                        'Keep Lead Quality visible across campaign overview and channel splits.',
                    ];
                },
                demoAnalyticsSupportNotes() {
                    return [
                        'Benchmarked candidates from Zendesk, Intercom, and HubSpot support analytics.',
                        'Track first reply/response time, resolution time/rate, CSAT, and ticket or conversation volume.',
                        'Add one-touch/FCR, escalation rate, assignment-to-first-response, and reopen/repeat-contact signals.',
                        'For AI support, add deflection rate and handoff quality as Outcraft-specific layers.',
                        'Support analytics should still expose Lead Quality or customer quality where relevant.',
                    ];
                },
                setActiveTab(tab, updateUrl = true) {
                    this.showLoader();
                    this.activeTab = tab;
                    this.resetTopNavHeaderScroll();
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
                leadInteractionChannels() {
                    return ['Call', 'Email', 'SMS', 'WhatsApp'];
                },
                leadInteractionChannelMeta(channel) {
                    return {
                        Email: { icon: 'mail', tileClass: 'bg-cyan-50 text-cyan-600 ring-cyan-200' },
                        Call: { icon: 'call', tileClass: 'bg-teal-50 text-teal-600 ring-teal-200' },
                        SMS: { icon: 'sms', tileClass: 'bg-amber-50 text-amber-600 ring-amber-200' },
                        WhatsApp: { icon: 'chat', tileClass: 'bg-lime-50 text-lime-600 ring-lime-200' },
                    }[channel] || { icon: 'timeline', tileClass: 'bg-white text-gray-400 ring-gray-200' };
                },
                leadInteractionChannelOptions() {
                    const interactions = this.resolvedLeadInteractions();

                    return this.leadInteractionChannels().map((label) => ({
                        label,
                        count: interactions.filter((interaction) => interaction.channel === label).length,
                        ...this.leadInteractionChannelMeta(label),
                    }));
                },
                leadInteractionChannelFilterLabel() {
                    const channels = this.leadInteractionChannels();
                    const selected = this.selectedLeadInteractionChannels.filter((item) => channels.includes(item));

                    if (selected.length === 0 || selected.length === channels.length) {
                        return 'All channels';
                    }

                    if (selected.length === 1) {
                        return selected[0];
                    }

                    return `${selected.length} channels`;
                },
                isLeadInteractionChannelSelected(channel) {
                    return this.selectedLeadInteractionChannels.includes(channel);
                },
                resetLeadInteractionChannelFilters() {
                    this.selectedLeadInteractionChannels = this.leadInteractionChannels();
                },
                toggleLeadInteractionChannel(channel) {
                    const channels = this.leadInteractionChannels();
                    const selected = this.selectedLeadInteractionChannels.filter((item) => channels.includes(item));

                    if (selected.length === channels.length) {
                        this.selectedLeadInteractionChannels = [channel];
                        return;
                    }

                    if (selected.includes(channel)) {
                        const next = selected.filter((item) => item !== channel);
                        this.selectedLeadInteractionChannels = next.length > 0 ? next : channels;
                        return;
                    }

                    this.selectedLeadInteractionChannels = [...selected, channel];
                },
                filteredLeadInteractions() {
                    const selected = new Set(this.selectedLeadInteractionChannels);

                    return this.resolvedLeadInteractions().filter((interaction) => selected.has(interaction.channel));
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
