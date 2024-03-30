<x-app-layout>
    <x-slot name="header_content">
        <h1>{{ __('Tambah Invoice Baru') }}</h1>

        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
            <div class="breadcrumb-item"><a href="#">Invoice</a></div>
            <div class="breadcrumb-item"><a href="{{ route('admin.invoice.index') }}">Tambah Invoice Baru</a></div>
        </div>
    </x-slot>

    <div>
        <livewire:invoice-form action="create" cust_id={{$id}}/>
    </div>
</x-app-layout>
