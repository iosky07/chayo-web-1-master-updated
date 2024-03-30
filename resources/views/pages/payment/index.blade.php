<x-app-layout>
    <x-slot name="header_content">
        @if(isset($name))
            <h1>Data Pembayaran {{ $name }}</h1>
        @else
            <h1>Data Persetujuan Pembayaran</h1>
        @endif
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
            <div class="breadcrumb-item"><a href="#">Pembayaran</a></div>
            @if(isset($id))
                <div class="breadcrumb-item"><a href="{{ route('admin.payment_index_with_id', $id) }}">Data Pembayaran</a></div>
            @else
                <div class="breadcrumb-item"><a href="#">Data Persetujuan Pembayaran</a></div>
            @endif

        </div>
    </x-slot>

    <div>
        <livewire:table.main name="payment" :model="$pay" />
    </div>
</x-app-layout>
