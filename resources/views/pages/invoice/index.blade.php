<x-app-layout>
    <x-slot name="header_content">
        <h1>Data Invoice {{ $name }}</h1>

        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active">
            </div>
        </div>
    </x-slot>

    <div>
        <livewire:table.main name="invoice" :model="$inv" />
    </div>
</x-app-layout>
