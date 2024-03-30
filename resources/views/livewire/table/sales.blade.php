<div>
    <x-data-table :data="$data" :model="$sale">
{{--        {{ dd($sale) }}--}}
{{--        {{ $unpaid = \App\Models\Invoice::whereCustomerId($s->id)->whereStatus('unpaid')->count() }}--}}
        <x-slot name="head">
            <tr>
                <th><a wire:click.prevent="sortBy('id')" role="button" href="#">
                        ID
                        @include('components.sort-icon', ['field' => 'id'])
                    </a></th>
                <th><a wire:click.prevent="sortBy('name')" role="button" href="#">
                        Nama
                        @include('components.sort-icon', ['field' => 'name'])
                    </a></th>
                <th><a wire:click.prevent="sortBy('created_at')" role="button" href="#">
                        Status
                        @include('components.sort-icon', ['field' => 'created_at'])
                    </a></th>
                <th><a wire:click.prevent="sortBy('address')" role="button" href="#">
                        Alamat
                        @include('components.sort-icon', ['field' => 'address'])
                    </a></th>
                <th><a wire:click.prevent="sortBy('identity_picture')" role="button" href="#">
                        Foto KTP
                        @include('components.sort-icon', ['field' => 'identity_picture'])
                    </a></th>

{{--                <th>Peta</th>--}}

                <th>Action</th>

                <th>Pembayaran</th>
            </tr>
        </x-slot>
        <x-slot name="body">
{{--            {{ dd($sales) }}--}}
            @foreach ($sale as $s)
                <tr x-data="window.__controller.dataTableController({{ $s->id }})">
                    <td>{{ $s->id }}</td>
                    <td>{{ $s->name }}</td>
                    <td>
                        @if($s->status == 'prospect')
                            <div class="badge badge-success">Proses</div>
                        @elseif($s->status == 'decline')
                            <div class="badge badge-danger">Gagal</div>
                        @endif
                    </td>
                    <td>{{ $s->address }}</td>
                    <td>
                        <img src="{{ asset('storage/img/identity_picture/'.$s->identity_picture) }}" alt="" style="width: 200px">
                    <td>
                        <ul class="navbar-nav navbar-right">
                            <li class="dropdown"><a href="#" data-turbolinks="false" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                                    <div class="d-sm-none d-lg-inline-block"><i class="fa fa-16px fa-user"></i></div></a>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <a href="{{ route('admin.customer_detail', $s->id) }}" class="dropdown-item has-icon" target="_blank"><i class="fa fa-16px fa-user"> </i> Detail Pelanggan</a>
                                    <a href="https://wa.me/{{'62'.substr($s->phone_number, 1)}}" class="dropdown-item has-icon" target="_blank"><i class="fa fa-16px fa-phone"> </i> Whatsapp</a>
                                    <a href="https://maps.google.com/?q={{$s->longitude}},{{$s->latitude}}" class="dropdown-item has-icon" target="_blank"><i class="fa fa-16px fa-map-marked"> </i> Lokasi</a>
                                    <a href="{{route('admin.sales.edit', $s->id)}}" class="dropdown-item has-icon"><i class="fa fa-16px fa-pen"></i> Edit</a>
                                    <a x-on:click.prevent="deleteItem" href="#" class="dropdown-item has-icon"><i class="fa fa-16px fa-trash"></i> Hapus</a>
                                    @if($s->status == 'isolate')
                                        <a href="#" class="bg-danger dropdown-item has-icon"><b>{{\Carbon\Carbon::now()->diff(\Carbon\Carbon::parse($s->isolate_date))->format('%m')}} Bulan {{\Carbon\Carbon::now()->diff(\Carbon\Carbon::parse($s->isolate_date))->format('%d')}} Hari {{\Carbon\Carbon::now()->diff(\Carbon\Carbon::parse($s->isolate_date))->format('%h')}} Jam</b></a>
                                    @endif
                                </div>
                            </li>
                        </ul>
                    </td>
                    <td>
                        @if($s->status == 'suspend')
                            <a x-on:click.prevent="salesDecline" class="btn btn-danger trigger--fire-modal-5 disabled" href="#">Tolak</a>
                            <a x-on:click.prevent="salesAccept" class="btn btn-success trigger--fire-modal-5" href="#">Terima</a>
                        @else
                            <a x-on:click.prevent="salesDecline" class="btn btn-danger trigger--fire-modal-5" href="#">Tolak</a>
                            <a x-on:click.prevent="salesAccept" class="btn btn-success trigger--fire-modal-5" href="#">Terima</a>
                        @endif
                    </td>
                </tr>
            @endforeach
        </x-slot>
    </x-data-table>
</div>
