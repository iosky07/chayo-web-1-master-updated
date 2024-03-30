<div id="form-create" class=" card p-4">
    <form wire:submit.prevent="create">

        <x-input type="number" title="Nominal pembayaran (kosongi bila tidak perlu)" model="payment.nominal"/>

        <x-select :options="$optionPayments" :selected="$payments" title="Pilih Jenis Pembayaran" model="payment.payment_method"/>

        <x-input type="file" title="Upload Bukti Pembayaran" model="payment_picture"/>
        <div wire:loading wire:target="payment_picture">
            Proses upload, harap tunggu hingga gambar tertampilkan
        </div>
        @if(true)
            @if($payment_picture)
                <img src="{{$payment_picture->temporaryUrl()}}" alt="" style="max-height: 300px; margin-bottom: 20px">
            @endif
        @else
            <img src="{{ asset('storage/img/payment_picture/'.$this->payment['payment_picture']) }}" alt="" style="max-height: 300px; margin-bottom: 20px">
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
                window.location.href = "{{route('admin.payment_index_with_id', intval(substr(url()->previous(), -12)))}}"; //will redirect to your blog page (an ex: blog.html)
            }, 2000); //will call the function after 2 secs.
        });
    });
</script>
