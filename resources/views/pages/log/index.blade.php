<x-app-layout>
    <x-slot name="header_content">
        <h1>{{ __('Data Log') }}</h1>

        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
            <div class="breadcrumb-item"><a href="#">Paket</a></div>
            <div class="breadcrumb-item"><a href="{{ route('admin.log.index') }}">Data Log Aktifitas</a></div>
        </div>
    </x-slot>

    <div>
        <livewire:table.main name="log" :model="$log" />
    </div>
</x-app-layout>
