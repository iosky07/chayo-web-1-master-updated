<x-app-layout>
    <x-slot name="header_content">
        <h1>{{ __('Edit Pelanggan Sales') }}</h1>

        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
            <div class="breadcrumb-item"><a href="#">Pelanggan</a></div>
            <div class="breadcrumb-item"><a href="{{ route('admin.sales.index') }}">Edit Pelanggan Sales</a></div>
        </div>
    </x-slot>

    <div>
        <livewire:sales-form action="update" dataId="{{$id}}"/>
    </div>
</x-app-layout>
