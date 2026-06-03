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
