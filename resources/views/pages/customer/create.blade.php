<x-app-layout>
    <x-slot name="header_content">
        <h1>{{ __('Tambah Pelanggan Baru') }}</h1>

        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
            <div class="breadcrumb-item"><a href="#">Pelanggan</a></div>
            <div class="breadcrumb-item"><a href="{{ route('admin.customer.index') }}">Tambah Pelanggan Baru</a></div>
        </div>
    </x-slot>

    <div>
        <livewire:customer-form action="create"/>
    </div>
</x-app-layout>
