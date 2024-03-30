<x-app-layout>
    <x-slot name="header_content">
        <h1>{{ __('Tambah Pelanggan Sales Baru') }}</h1>

        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
            <div class="breadcrumb-item"><a href="#">Pelanggan</a></div>
            <div class="breadcrumb-item"><a href="{{ route('admin.sales.index') }}">Tambah Pelanggan Sales Baru</a></div>
        </div>
    </x-slot>

    <div>
        <livewire:sales-form action="create"/>
    </div>
</x-app-layout>
