<div>
    <x-data-table :data="$data" :model="$customers">
{{--        {{ dd($customers) }}--}}
{{--        {{ $unpaid = \App\Models\Invoice::whereCustomerId($m->id)->whereStatus('unpaid')->count() }}--}}
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
                <th><a wire:click.prevent="sortBy('location_picture')" role="button" href="#">
                        Tagihan
                        @include('components.sort-icon', ['field' => 'location_picture'])
                    </a></th>

{{--                <th>Peta</th>--}}

                <th>Action</th>

                <th>Pembayaran</th>
            </tr>
        </x-slot>
        <x-slot name="body">
            @foreach ($customers as $m)
                <tr x-data="window.__controller.dataTableController({{ $m->id }})">
                    <td>{{ $m->id }}</td>
                    <td>{{ $m->name }}</td>
                    <td>
                        @if($m->status == 'paid')
                            <div class="badge badge-success">Lunas</div>
                        @elseif($m->status == 'unpaid')
                                <div class="badge badge-warning">Belum Lunas</div>
                        @elseif($m->status == 'suspend')
                            <div class="badge badge-dark">Suspended</div>
                        @elseif($m->status == 'isolate')
                            <div class="badge badge-danger">Isolir</div>
                        @endif
                    </td>
                    {{--                    <td>{{ \Carbon\Carbon::parse($m->created_at)->format('d-m-Y') }}</td>--}}
                    {{--                    <td>{{ date_diff(\Carbon\Carbon::now()->toDate(), DateTime::createFromFormat('Y-m-d', $m->registration_date))->format("%a Hari") }}</td>--}}
                    <td>{{ $m->address }}</td>
                    <td>
{{--                        <img src="{{ asset('storage/img/location_picture/'.$m->location_picture) }}" alt=""--}}
{{--                             style="width: 100px"></td>--}}{{--                        {{ dd($m->bill) }}--}}
                        @if($m->total_bill  == 0)
                            -
                        @elseif($m->total_bill > 0)
                            Rp. {{ number_format($m->total_bill, 0, ',', '.') }} ({{ ceil($m->total_bill/$m->bill) }})
                        @endif

                    <td>
                        <ul class="navbar-nav navbar-right">
                            <li class="dropdown"><a href="#" data-turbolinks="false" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                                    <div class="d-sm-none d-lg-inline-block"><i class="fa fa-16px fa-user"></i></div></a>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <a href="{{ route('admin.customer_detail', $m->id) }}" class="dropdown-item has-icon" target="_blank"><i class="fa fa-16px fa-user"> </i> Detail Pelanggan</a>
                                    <a href="https://wa.me/{{'62'.substr($m->phone_number, 1)}}" class="dropdown-item has-icon" target="_blank"><i class="fa fa-16px fa-phone"> </i> Whatsapp</a>
                                    <a href="https://maps.google.com/?q={{$m->longitude}},{{$m->latitude}}" class="dropdown-item has-icon" target="_blank"><i class="fa fa-16px fa-map-marked"> </i> Lokasi</a>
                                    <a href="{{route('admin.customer.edit', $m->id)}}" class="dropdown-item has-icon"><i class="fa fa-16px fa-pen"></i> Edit</a>
                                    <a x-on:click.prevent="deleteItem" href="#" class="dropdown-item has-icon"><i class="fa fa-16px fa-trash"></i> Hapus</a>
                                    @if($m->status == 'isolate')
                                        <a href="#" class="bg-danger dropdown-item has-icon"><b>{{\Carbon\Carbon::now()->diff(\Carbon\Carbon::parse($m->isolate_date))->format('%m')}} Bulan {{\Carbon\Carbon::now()->diff(\Carbon\Carbon::parse($m->isolate_date))->format('%d')}} Hari {{\Carbon\Carbon::now()->diff(\Carbon\Carbon::parse($m->isolate_date))->format('%h')}} Jam</b></a>
                                    @endif
                                </div>
                            </li>
                        </ul>
                    </td>
                    <td>
                        @if($m->status == 'suspend')
                            <a class="btn btn-success trigger--fire-modal-5 disabled" href="{{ route('admin.index_with_id', $m->id) }}">Invoice</a>
                            <a class="btn btn-primary trigger--fire-modal-5 disabled" href="{{ route('admin.payment_index_with_id', $m->id) }}">Bayar</a>
                            <a x-on:click.prevent="customerSuspend" class="btn btn-danger trigger--fire-modal-5 disabled" href="#">Isolir</a>
                            <a x-on:click.prevent="customerSuspend" class="btn btn-dark trigger--fire-modal-5" href="#">Unsuspend</a>
                        @else
                            <a class="btn btn-success trigger--fire-modal-5" href="{{ route('admin.index_with_id', $m->id) }}">Invoice</a>
                            <a class="btn btn-primary trigger--fire-modal-5" href="{{ route('admin.payment_index_with_id', $m->id) }}">Bayar</a>
                            <a x-on:click.prevent="customerSuspend" class="btn btn-danger trigger--fire-modal-5" href="#">Isolir</a>
                            <a x-on:click.prevent="customerSuspend" class="btn btn-outline-dark trigger--fire-modal-5" href="#">Suspend</a>
                        @endif
                    </td>
                </tr>
            @endforeach
        </x-slot>
    </x-data-table>
</div>
