<div>
    <x-data-table :data="$data" :model="$payments">
        {{ $getId = intval(substr(url()->current(), -12)) }}
        <x-slot name="head">
            <tr>
                <th>Payment ID</th>
                @if($getId == 0)
                    <th>Nama Customer</th>
                @endif
                <th>Bukti Transaksi</th>
                <th>Nominal</th>
                <th>Status</th>
                <th>Diajukan pada</th>
                @if($getId !== 0)
                    <th>Disetujui pada</th>
                @endif

                <th>Action</th>
            </tr>
        </x-slot>
        <x-slot name="body">
            @foreach ($payments as $p)
                @if($getId !== 0)
                    @if($p->customer_id == $getId)
                        <tr x-data="window.__controller.dataTableController({{ $p->id }})">
                            <td>{{ $p->id }}</td>
                            <td>
                                <img src="{{ asset('storage/img/payment_picture/'.$p->payment_picture) }}" alt=""
                                     style="width: 100px">
                            </td>
                            <td>Rp. {{ number_format($p->nominal, 0, ',', '.') }}</td>
                            <td>
                                @if($p->status == 'accept')
                                    <div class="badge badge-success">Diterima</div>
                                @elseif($p->status == 'decline')
                                    <div class="badge badge-danger">Ditolak</div>
                                @elseif($p->status == 'pending')
                                    <div class="badge badge-warning">Menunggu Persetujuan</div>
                                @endif
                            </td>
                            <td>{{ $p->created_at }}</td>
                            <td>
                                {{ $p->updated_at }}
                            </td>
                            @if($p->status == 'pending')
                                <td>
                                    <a disabled="yes" x-on:click.prevent="deleteItem" href="#" class="btn btn-danger"><i class="fa fa-16px fa-trash"></i> Hapus</a>
                                </td>
                            @elseif($p->status == 'accept')
                                <td>
                                    <a role="button" href="{{ route('admin.generate_payment', $p->id) }}" class="btn btn-success" target="_blank"><i class="fa fa-16px fa-print"></i> Cetak</a>
                                </td>
                            @else
                                <td>-</td>
                            @endif

                        </tr>
                    @endif
                @else
                    @if($p->status == 'pending')
                        <tr x-data="window.__controller.dataTableController({{ $p->id }})">
                            <td>{{ $p->id }}</td>
                            <td>{{ \App\Models\Customer::whereId($p->customer_id)->value('name') }}</td>
                            <td>
                                <img src="{{ asset('storage/img/payment_picture/'.$p->payment_picture) }}" alt="" style="width: 100px">
                            </td>
                            <td>Rp. {{ number_format($p->nominal, 0, ',', '.') }}</td>
                            <td>
                                @if($p->status == 'accept')
                                    <div class="badge badge-success">Diterima</div>
                                @elseif($p->status == 'decline')
                                    <div class="badge badge-danger">Ditolak</div>
                                @elseif($p->status == 'pending')
                                    <div class="badge badge-warning">Menunggu Persetujuan</div>
                                @endif
                            </td>
                            <td>{{ $p->created_at }}</td>
                            <td>
                                <a x-on:click.prevent="acceptPayment" href="#" class="btn btn-success"><i class="fa fa-16px fa-thumbs-up"></i> Terima</a>
                                <a x-on:click.prevent="declinePayment" href="#" class="btn btn-danger"><i class="fa fa-16px fa-thumbs-down"></i> Tolak</a>

                            </td>
                        </tr>
                    @endif
                @endif

            @endforeach
        </x-slot>
    </x-data-table>
</div>
