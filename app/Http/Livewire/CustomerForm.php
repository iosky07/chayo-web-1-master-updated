<?php

namespace App\Http\Livewire;

use App\Models\Customer;
use App\Models\Log;
use App\Models\PacketTag;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;

class CustomerForm extends Component
{
    use WithFileUploads;
    public $action;
    public $dataId;
    public $customer;
    public $name;
    public $address;
    public $phone_number;
    public $identity_number;
    public $longitude;
    public $latitude;
    public $identity_picture;
    public $location_picture;
    public $packet_tag_id;
    public $optionPacketTags;
    public $packetTags;
    public $log;
    public $temp;
    public $item;
    public $editingModal = false;

    protected function rules() {
        if ($this->action == 'create') {
            return [
                'customer.name' => 'required',
                'customer.address' => 'required',
                'customer.phone_number' => 'required',
                'identity_picture' => 'required',
                'location_picture' => 'required',
                'customer.longitude' => 'required',
                'customer.latitude' => 'required',
                'customer.identity_number' => 'required',
                'customer.registration_date' => 'required',
            ];
        } else {
            return [
                'customer.name' => 'required',
                'customer.address' => 'required',
                'customer.phone_number' => 'required',
                'customer.longitude' => 'required',
                'customer.latitude' => 'required',
                'customer.identity_number' => 'required',
                'customer.registration_date' => 'required',
            ];
        }
    }

    protected $messages = [
        'customer.name.required' => 'Nama tidak boleh kosong.',
        'customer.address.required' => 'Alamat tidak boleh kosong.',
        'customer.phone_number.required' => 'Nomor telepon tidak boleh kosong.',
        'identity_picture.required' => 'Foto KTP tidak boleh kosong.',
        'location_picture.required' => 'Foto Rumah tidak boleh kosong.',
        'customer.longitude.required' => 'Longitude tidak boleh kosong.',
        'customer.latitude.required' => 'Latitude tidak boleh kosong.',
        'customer.identity_number.required' => 'NIK tidak boleh kosong.',
        'customer.registration_date.required' => 'Tanggal tidak boleh kosong.',
    ];

    public function mount()
    {
        $this->customer['packet_tag_id'] = 1;
//        $this->customer['registration_date'] = '2023-12-20';
        $this->packetTags = [1];
        $this->optionPacketTags = eloquent_to_options(PacketTag::get(), 'id', 'title');
//        dd($this->optionPacketTags);


        if ($this->dataId!=''){

            $c = Customer::findOrFail($this->dataId);
//            dd($c->registration_date);
            $this->customer=[
                'name'=>$c->name,
                'address'=>$c->address,
                'phone_number'=>$c->phone_number,
                'identity_picture'=>$c->identity_picture,
                'location_picture'=>$c->location_picture,
                'longitude'=>$c->longitude,
                'latitude'=>$c->latitude,
                'identity_number'=>$c->identity_number,
                'packet_tag_id'=>$c->packet_tag_id,
                'registration_date'=>$c->registration_date,
            ];


        }
//        dd($this->customer['registration_date']);
    }

    public function create()
    {
//        dd($this->customer);
        $this->validate();
        $this->customer['id'] = Customer::latest('id')->value('id') + 1;

        $this->customer['identity_picture'] = md5(rand()).'.'.$this->identity_picture->getClientOriginalExtension();
        $this->identity_picture->storeAs('public/img/identity_picture/', $this->customer['identity_picture']);

        $this->customer['location_picture'] = md5(rand()).'.'.$this->location_picture->getClientOriginalExtension();
        $this->location_picture->storeAs('public/img/location_picture/', $this->customer['location_picture']);

        $this->customer['packet_tag_id'] = (int)$this->customer['packet_tag_id'];

        $this->customer['user_id'] = Auth::id();

        Customer::create($this->customer);

        $this->temp = Customer::latest('id')->first();

        $this->log = [
            'user_id' => Auth::id(),
            'access' => 'create',
            'activity' => 'create customer id '.$this->temp['id'].' in Customer table'
        ];

        Log::create($this->log);

        $this->emit('swal:alert', [
            'type'    => 'success',
            'title'   => 'Data berhasil masuk',
            'timeout' => 3000,
            'icon'=>'success'
        ]);
        $this->emit('redirect');
    }

    public function update() {

//        dd($this->customer);
        $this->validate();

        $changed_data = [];

        $model_array = [
            'name', 'address', 'phone_number', 'packet_tag_id', 'registration_date', 'identity_picture', 'location_picture', 'longitude', 'latitude', 'identity_number'
        ];

        #ambil data cust sebelum update
        $model_temp = Customer::find($this->dataId);

        if ($this->customer['identity_picture'] == null) {
            $this->customer['identity_picture'] = md5(rand()).'.'.$this->identity_picture->getClientOriginalExtension();
            $this->identity_picture->storeAs('public/img/identity_picture/', $this->customer['identity_picture']);
        }

        if ($this->customer['location_picture'] == null) {
            $this->customer['location_picture'] = md5(rand()).'.'.$this->location_picture->getClientOriginalExtension();
            $this->location_picture->storeAs('public/img/location_picture/', $this->customer['location_picture']);
        }
        #proses save setelah update
        Customer::find($this->dataId)->update($this->customer);

        #ambil data cust setelah update
        $model_temp_1 = Customer::find($this->dataId);

        #cari data apa saja yang diubah
        foreach ($model_array as $item) {
            if ($model_temp[$item] != $model_temp_1[$item]) {
                $changed_data[] = $item;
            }
        }

        $changed_data = implode(', ', $changed_data);

        if ($changed_data != '') {
            $this->log = [
                'user_id' => Auth::id(),
                'access' => 'update',
                'activity' => 'update customer id '.$model_temp['id'].' from Customer table. ['.$changed_data.']'.' changed'
            ];

            Log::create($this->log);
        }

        $this->emit('swal:alert', [
            'type'    => 'success',
            'title'   => 'Data berhasil update',
            'timeout' => 3000,
            'icon'=>'success'
        ]);
        $this->emit('redirect');
    }

    public function render()
    {
        return view('livewire.customer-form');
    }

    public function editModal()
    {
        dd('tes');
        $this->item = $item;
        $this->editingModal = true;
    }
}
