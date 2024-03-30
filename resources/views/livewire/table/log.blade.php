<div>
    <x-data-table :data="$data" :model="$logs">
        <x-slot name="head">
            <tr>
                <th><a wire:click.prevent="sortBy('id')" role="button" href="#">
                    ID
                    @include('components.sort-icon', ['field' => 'id'])
                </a></th>
                <th><a wire:click.prevent="sortBy('created_at')" role="button" href="#">
                    Waktu
                    @include('components.sort-icon', ['field' => 'created_at'])
                </a></th>
                <th><a wire:click.prevent="sortBy('user_id')" role="button" href="#">
                        User
                        @include('components.sort-icon', ['field' => 'user_id'])
                    </a></th>
                <th><a wire:click.prevent="sortBy('access')" role="button" href="#">
                        Akses
                        @include('components.sort-icon', ['field' => 'access'])
                    </a></th>
                <th><a wire:click.prevent="sortBy('activity')" role="button" href="#">
                        Aktifitas
                        @include('components.sort-icon', ['field' => 'activity'])
                    </a></th>
            </tr>
        </x-slot>
        <x-slot name="body">
            @foreach ($logs as $l)
                <tr x-data="window.__controller.dataTableController({{ $l->id }})">
                    <td>{{ $l->id }}</td>
                    <td>{{ \Carbon\Carbon::parse($l->created_at)->setTimezone('Asia/Jakarta')->format('d-m-Y H:i:s') }}</td>
                    <td>{{  \App\Models\User::whereId($l->user_id)->first()->name }}</td>
                    <td>{{ $l->access }}</td>
                    <td>{{ $l->activity }}</td>
                </tr>
            @endforeach
        </x-slot>
    </x-data-table>
</div>
