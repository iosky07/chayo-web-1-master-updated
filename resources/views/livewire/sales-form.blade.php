<div id="form-create" class=" card p-4">
    <form wire:submit.prevent="{{ $action }}">

        <x-input type="text" title="Nama" model="customer.name"/>

        <x-input type="text" title="Alamat" model="customer.address"/>

        <x-input type="text" title="No. HP (Contoh: 081xxxxxxxxx)" model="customer.phone_number"/>

        <x-input type="text" title="NIK" model="customer.identity_number"/>

        <x-select :options="$optionPacketTags" :selected="$packetTags" title="Pilih Paket" model="customer.packet_tag_id"/>

        <x-input type="number" title="Harga Paket" model="customer.bill"/>

        <x-input type="text" title="Longitude" model="customer.longitude"/>

        <x-input type="text" title="Latitude" model="customer.latitude"/>

        <x-input type="file" title="Foto KTP" model="identity_picture"/>
        <div wire:loading wire:target="identity_picture">
            Proses upload, harap tunggu hingga gambar tertampilkan
        </div>
        @if($action=='create')
            @if($identity_picture)
                <img src="{{$identity_picture->temporaryUrl()}}" alt="" style="max-height: 300px; margin-bottom: 20px">
            @endif
        @else
            @if($identity_picture)
                <img src="{{$identity_picture->temporaryUrl()}}" alt="" style="max-height: 300px; margin-bottom: 20px">
            @else
                <img src="{{ asset('storage/img/identity_picture/'.$this->customer['identity_picture']) }}" alt="" style="max-height: 300px; margin-bottom: 20px">
            @endif
        @endif

        <x-input type="file" title="Foto Rumah" model="location_picture"/>
        <div wire:loading wire:target="location_picture">
            Proses upload, harap tunggu hingga gambar tertampilkan
        </div>
        @if($action=='create')
            @if($location_picture)
                <img src="{{$location_picture->temporaryUrl()}}" alt="" style="max-height: 300px; margin-bottom: 20px">
            @endif
        @else
            @if($location_picture)
                <img src="{{$location_picture->temporaryUrl()}}" alt="" style="max-height: 300px; margin-bottom: 20px">
            @else
                <img src="{{ asset('storage/img/location_picture/'.$this->customer['location_picture']) }}" alt="" style="max-height: 300px; margin-bottom: 20px">
            @endif
        @endif

        <div class="form-group col-span-6 sm:col-span-5"></div>
        <button type="submit" id="submit" class="btn btn-primary">Submit</button>

    </form>
</div>

<div>

</div>

<script>
    document.addEventListener('livewire:load', function () {
        window.livewire.on('redirect', () => {
            setTimeout(function () {
                window.location.href = "{{route('admin.sales.index')}}"; //will redirect to your blog page (an ex: blog.html)
            }, 2000); //will call the function after 2 secs.
        });
    });
</script>
