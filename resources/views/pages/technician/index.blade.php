<x-app-layout>
    <x-slot name="header_content">
        <h1>{{ __('Cek Pelanggan') }}</h1>

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
                                    <th>UPTIME</th>
                                </tr>
                                </thead>
                                @if($status == 'ada')
                                    @if(!isset($result_act_conn))
                                        <tbody>
                                            <tr>
                                                <th class="text-danger">PELANGGAN MASIH BELUM ON</th>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                            </tr>
                                        </tbody>
                                    @else
                                        <tbody>
                                        <tr>
                                            <th>ID1234</th>
                                            <th>{{ $result_info[0] }}</th>
                                            <th>{{ $result_info[1] }}</th>
                                            @if($result_act_conn == [])
                                                <th class="text-danger">OFFLINE</th>
                                            @else
                                                <th class="text-success">{{ $result_act_conn[1] }}</th>
                                            @endif
                                        </tr>
                                        </tbody>
                                    @endif
                                @else
                                    <tbody>
                                    <tr>
                                        <th class="text-danger">PELANGGAN TIDAK DITEMUKAN</th>
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
