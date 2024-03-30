<x-app-layout>
    <x-slot name="header_content">
        <h1>Detail Pelanggan {{ $name }}</h1>

        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
            <div class="breadcrumb-item"><a href="#">Pelanggan</a></div>
            <div class="breadcrumb-item"><a href="{{ route('admin.customer.index') }}">Data Pelanggan</a></div>
        </div>
    </x-slot>

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

                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    @foreach($customer as $cust)
                                        <td>ID :</td>
                                        <td>{{ $cust->id }}</td>
                                    @endforeach
                                </tr>
                                <tr>
                                    @foreach($customer as $cust)
                                        <td>Nama :</td>
                                        <td>{{ $cust->name }}</td>
                                    @endforeach
                                </tr>
                                <tr>
                                    @foreach($customer as $cust)
                                        <td>Alamat :</td>
                                        <td>{{ $cust->address }}</td>
                                    @endforeach
                                </tr>
                                <tr>
                                    @foreach($customer as $cust)
                                        <td>NIK :</td>
                                        <td>{{ $cust->identity_number }}</td>
                                    @endforeach
                                </tr>
                                <tr>
                                    @foreach($customer as $cust)
                                        <td>Nomor Telepon :</td>
                                        <td>
                                            {{ $cust->phone_number }}
                                            <a href="https://wa.me/{{'62'.substr($cust->phone_number, 1)}}" class="btn btn-success trigger--fire-modal-5" target="_blank"><i class="fa fa-16px fa-phone"> </i> Whatsapp</a>
                                        </td>
                                    @endforeach
                                </tr>
                                <tr>
                                    @foreach($customer as $cust)
                                        <td>Lokasi Rumah :</td>
                                        <td>
                                            <iframe
                                                width="300"
                                                height="170"
                                                src="https://maps.google.com/maps?q={{$cust->longitude}},{{$cust->latitude}}&hl=ina&z=14&amp;output=embed"
                                            >
                                            </iframe>
                                        </td>
                                    @endforeach
                                </tr>
                                <tr>
                                    @foreach($customer as $cust)
                                        <td>Foto KTP :</td>
{{--                                        {{$cust->identity_picture}}--}}
                                        <td><img src="{{ asset('storage/img/identity_picture/'.$cust->identity_picture) }}" alt="" style="width: 300px"></td>
                                    @endforeach
                                </tr>
                                <tr>
                                    @foreach($customer as $cust)
                                        <td>Foto Rumah :</td>
                                        {{--                                        {{$cust->identity_picture}}--}}
                                        <td><img src="{{ asset('storage/img/location_picture/'.$cust->location_picture) }}" alt="" style="width: 300px"></td>
                                    @endforeach
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
