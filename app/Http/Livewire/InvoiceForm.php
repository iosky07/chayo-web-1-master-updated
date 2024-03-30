<?php

namespace App\Http\Livewire;

use App\Models\Customer;
use App\Models\Invoice;
use App\Models\Log;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class InvoiceForm extends Component
{
    public $invoice;
    public $customer;
    public $dataId;

    public function render()
    {
        return view('livewire.invoice-form');
    }

    protected $rules = [
        'invoice.selected_date' => 'required'
    ];

    protected $messages = [
        'invoice.selected_date.required' => 'Tanggal tidak boleh kosong.'
    ];

    public function mount()
    {
        if ($this->dataId!=''){
            $inv = Invoice::findOrFail($this->dataId);
            $this->invoice=[
                'selected_date'=>$inv->selected_date,
            ];
        }
    }

    public function create()
    {
//        dd($this->invoice);
        if ($this->invoice == NULL) {
            $this->invoice = Carbon::now()->format('Y-m-d H:i:s');
//            dd($this->invoice);
        } else {
            $startDate = Carbon::parse('2024-01-18');
            $endDate = Carbon::parse('2024-03-01');

            $months = CarbonPeriod::create($startDate, $endDate);

            $detail_tanggal = [];
            foreach ($months as $date) {
                if (count($detail_tanggal) == 0) {
                    $detail_tanggal[] = $date->format('Y-m-d H:i:s');
                    $temp_date = $date;
                } elseif ($temp_date->format('m') != $date->format('m')) {
                    $detail_tanggal[] = $date->format('Y-m-d H:i:s');
                    $temp_date = $date;
                }
            }
        }

        $this->validate();
        $getUrl = url()->previous();
        $id = intval(substr($getUrl, -12));

        $this->invoice['customer_id'] = $id;

        if (count($detail_tanggal) == 0) {
            $this->invoice = Carbon::now()->format('Y-m-d H:i:s');
        }

        foreach ($detail_tanggal as $dt) {
//            dd($dt);
            $this->invoice['selected_date'] = $dt;
//            dd($this->invoice);
            Invoice::create($this->invoice);
            $invoice_amount = Invoice::whereCustomerId($id)->whereStatus('unpaid')->count();
            $customer = Customer::findOrFail($id);

            $this->customer['status'] = 'unpaid';
            $this->customer['total_bill'] = $customer['bill'] * $invoice_amount;

            Customer::find($id)->update($this->customer);

            $this->temp = Invoice::whereCustomerId($id)->latest()->first();

            $this->log = [
                'user_id' => Auth::id(),
                'access' => 'create',
                'activity' => 'create Invoice id '.$this->temp['id'].' from Customer id '.$this->temp['customer_id'].' in invoice table'
            ];

            Log::create($this->log);
        }

        return redirect(substr($getUrl, 0, strlen($getUrl) - 19).'index/'.$id);
    }
}
