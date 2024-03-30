<?php

namespace App\Http\Livewire;

use App\Models\Customer;
use App\Models\Invoice;
use App\Models\Log;
use App\Models\Payment;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;

class PaymentForm extends Component
{
    use WithFileUploads;
    public $payments;
    public $payment;
    public $temp;
    public $log;
    public $payment_picture;
    public $dataId;
    public $action;
    public $optionPayments;

    protected function rules() {
        $this->action = 'create';
        if ($this->action == 'create') {
            return [
                'payment_picture' => 'required',
            ];
        } else {
            return [

            ];
        }
    }

    protected $messages = [
        'payment_picture.required' => 'Bukti Pembayaran tidak boleh kosong.',
        ];

    public function mount()
    {
        $this->payment['payment_method'] = 'cash';
//        $this->payments = [1];
        $this->optionPayments = [
            ['value'=>'cash', 'title'=>'Cash'],
            ['value'=>'transfer','title'=>'Transfer']];

        if ($this->dataId!=''){

            $p = Payment::findOrFail($this->dataId);
            $this->payment=[
                'payment_method'=>$p->payment_method,
                'payment_picture'=>$p->payment_picture,
                'customer_id'=>$p->customer_id,
            ];
        }
    }

    public function create()
    {
        $this->validate();

        $id = intval(substr(url()->previous(), -12));
        $this->payment['payment_picture'] = md5(rand()).'.'.$this->payment_picture->getClientOriginalExtension();
        $this->payment_picture->storeAs('public/img/payment_picture/', $this->payment['payment_picture']);

        $this->payment['customer_id'] = $id;
        $this->payment['status'] = 'pending';
        $this->payment['user_id'] = Auth::id();

        if (empty($this->payment['nominal'])) {
            $bill = Customer::FindOrFail($id);
            $invoice = Invoice::whereCustomerId($id)->whereStatus('unpaid')->count();
            $this->payment['nominal'] = $bill['bill'] * $invoice;
        }
//        dd($this->payment);
        Payment::create($this->payment);

        $this->temp = Payment::latest('id')->first();

        $this->log = [
            'user_id' => Auth::id(),
            'access' => 'create',
            'activity' => 'create payment id '.$this->temp['id'].' in Payment table'
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

    public function render()
    {
        return view('livewire.payment-form');
    }
}
