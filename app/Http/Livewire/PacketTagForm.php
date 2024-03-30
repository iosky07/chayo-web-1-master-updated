<?php

namespace App\Http\Livewire;

use App\Models\Log;
use App\Models\PacketTag;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class PacketTagForm extends Component
{
    public $action;
    public $dataId;
    public $title;
    public $packetTag;

    protected $rules = [
      'packetTag.title' => 'required'
    ];

    protected $messages = [
        'packetTag.title.required' => 'Nama paket tidak boleh kosong.'
    ];

    public function mount()
    {
        if ($this->dataId!=''){
            $pt = PacketTag::findOrFail($this->dataId);
            $this->packetTag=[
                'title'=>$pt->title,
            ];
        }
    }

    public function create()
    {
        $this->validate();
        PacketTag::create($this->packetTag);

        $this->temp = PacketTag::latest('id')->first();

        $this->log = [
            'user_id' => Auth::id(),
            'access' => 'create',
            'activity' => 'create packet_tag id '.$this->temp['id'].' in Packet_Tag table'
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
        $this->validate();

        $changed_data = [];

        $model_array = [
            'name'
        ];

        #ambil data cust sebelum update
        $model_temp = PacketTag::find($this->dataId);

        PacketTag::find($this->dataId)->update($this->packetTag);

        #ambil data packet_tag setelah update
        $model_temp_1 = PacketTag::find($this->dataId);

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
                'activity' => 'update packet_tag id '.$model_temp['id'].' from Packet_Tag table. ['.$changed_data.']'.' changed'
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
        return view('livewire.packet-tag-form');
    }
}
