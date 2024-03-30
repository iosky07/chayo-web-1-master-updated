<div>
    <x-data-table :data="$data" :model="$packetTags">
        <x-slot name="head">
            <tr>
                <th><a wire:click.prevent="sortBy('id')" role="button" href="#">
                    ID
                    @include('components.sort-icon', ['field' => 'id'])
                </a></th>
                <th><a wire:click.prevent="sortBy('title')" role="button" href="#">
                    Jenis Paket
                    @include('components.sort-icon', ['field' => 'title'])
                </a></th>

                <th>Action</th>
            </tr>
        </x-slot>
        <x-slot name="body">
            @foreach ($packetTags as $pt)
                <tr x-data="window.__controller.dataTableController({{ $pt->id }})">
                    <td>{{ $pt->id }}</td>
                    <td>{{ $pt->title }}</td>
                    <td class="whitespace-no-wrap row-action--icon">
                        <a role="button" href="{{route('admin.packet-tag.edit', $pt->id)}}" class="mr-3"><i class="fa fa-16px fa-pen"></i></a>
                        <a role="button" x-on:click.prevent="deleteItem" href="#"><i class="fa fa-16px fa-trash text-red-500"></i></a>
                    </td>
                </tr>
            @endforeach
        </x-slot>
    </x-data-table>
</div>
