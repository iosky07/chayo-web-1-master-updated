<?php

namespace App\Http\Livewire;

use App\Models\Log;
use App\Models\RouterosAPI;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class TechnicianForm extends Component
{
    public $action;
    public $dataId;
    public $log;
    public $technician;
    public $result;
    public $search;

    protected $rules = [
        'technician.username' => 'required'
    ];

    protected $messages = [
        'technician.username.required' => 'Nama Pelanggan tidak boleh kosong.'
    ];

    public function create()
    {
        $this->validate();

        $this->log = [
            'user_id' => Auth::id(),
            'access' => 'search',
            'activity' => 'checking secret uptime'
        ];

//        dd($result_act_conn);
        Log::create($this->log);

        $this->emit('swal:alert', [
            'type'    => 'success',
            'title'   => 'Data berhasil ditemukan',
            'timeout' => 3000,
            'icon'=>'success'
        ]);

//        $this->emit('redirect', 'result_act_conn', 'result_info');
//        return view('pages.technician.index', compact('result_act_conn', 'result_info'));
        return redirect('admin/technician'.'/'.$this->technician['username']);
    }

    public function render()
    {
        return view('livewire.technician-form');
    }
}
