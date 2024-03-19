<style type="text/css">
    @media print {
        .fi-modal-window {
            visibility: hidden;
        }
        /* a, h1, */
        #printableArea {
            display: block;
            visibility: visible;
            margin: 0 auto;
        }
    }
</style>
<h1>{{ __($type) }}: {{ $name }}</h1>
<div id="printableArea">
    {!! QrCode::size(300)->backgroundColor(255, 90, 0)->generate($route) !!}
</div>
<a onclick="window.print(document.getElementById('printableArea').innerHTML);"
    style="--c-400:var(--primary-400);--c-500:var(--primary-500);--c-600:var(--primary-600);"
    class="noprint fi-btn fi-btn-size-md relative grid-flow-col items-center justify-center font-semibold outline-none transition duration-75 focus:ring-2 disabled:pointer-events-none disabled:opacity-70 rounded-lg fi-btn-color-primary gap-1.5 px-3 py-2 text-sm inline-grid shadow-sm bg-custom-600 text-white hover:bg-custom-500 dark:bg-custom-500 dark:hover:bg-custom-400 focus:ring-custom-500/50 dark:focus:ring-custom-400/50 fi-ac-btn-action"
    href="">
    <span class="fi-btn-label">{{ __('actions.print') }}</span>
</a>