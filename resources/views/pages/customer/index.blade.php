<x-app-layout>
    <x-slot name="header_content">
        <h1>{{ __('Data Pelanggan') }}</h1>

        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
            <div class="breadcrumb-item"><a href="#">Pelanggan</a></div>
            <div class="breadcrumb-item"><a href="{{ route('admin.customer.index') }}">Data Pelanggan</a></div>
        </div>
    </x-slot>

    <div>
        <livewire:table.main name="customer" :model="$cust" />
    </div>
</x-app-layout>
