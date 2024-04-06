<x-app-layout>
    <x-slot name="header_content">
        <h1>{{ __('Cek Pelanggan Aktif') }}</h1>

        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
            <div class="breadcrumb-item"><a href="#">Teknisi</a></div>
            <div class="breadcrumb-item"><a href="{{ route('admin.technician.index') }}">Data Pelanggan</a></div>
        </div>
    </x-slot>

    <div>
        <livewire:technician-form action="create"/>
    </div>

    <div>
        <div>
            <div class="bg-gray-100 text-gray-900 tracking-wider leading-normal">
                <div class="p-8 pt-4 mt-2 bg-white" x-data="window.__controller.dataTableMainController()" x-init="setCallback();">
                    <div class="flex pb-4 -ml-3">

                    </div>
                    <div class="row">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped text-sm text-gray-600">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>USERNAME</th>
                                    <th>NOMOR SN</th>
                                    <th>PORT</th>
                                    <th>UPTIME</th>
                                    <th>STATUS</th>
                                    <th>REDAMAN</th>
                                </tr>
                                </thead>
                                @if($status == 'ada')
                                    <tbody>
                                    @foreach($result_secret as $item)
                                        <tr>
                                            <th>ID1234</th>
                                            <th>{{ $item['name'] }}</th>
                                            <th>{{ $item['password'] }}</th>
                                            <th>{{ $item['port'] }}</th>
                                            <th>{{ $item['uptime'] }}</th>
                                            <th>{{ $item['status'] }}</th>
                                            <th>{{ $item['optic-score'] }}</th>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                @else
                                    <tbody>
                                    <tr>
                                        <th class="text-danger">PELANGGAN TIDAK DITEMUKAN</th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                    </tr>
                                    </tbody>
                                @endif
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
