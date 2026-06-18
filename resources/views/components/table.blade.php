<div class="table-shell">
    <div class="overflow-x-auto">
        <table {{ $attributes->merge(['class' => 'min-w-full divide-y table-row-border']) }}>
            {{ $slot }}
        </table>
    </div>
</div>
