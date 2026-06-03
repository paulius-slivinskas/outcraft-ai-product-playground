    <div
        x-cloak
        x-show="floatingTooltip.visible"
        class="outcraft-floating-tooltip rounded-lg bg-gray-900 px-3 py-2 text-center text-xs font-medium leading-4 text-white shadow-sm"
        :style="`left: ${floatingTooltip.left}px; top: ${floatingTooltip.top}px; width: ${floatingTooltip.width}px; --outcraft-tooltip-arrow-left: ${floatingTooltip.arrowLeft}px;`"
    >
        <span x-text="floatingTooltip.text"></span>
        <span class="absolute top-full size-2 -translate-x-1/2 -translate-y-1 rotate-45 bg-gray-900" style="left: var(--outcraft-tooltip-arrow-left, 50%);"></span>
    </div>
