<?php

namespace App\Http\Livewire\Table;

use App\Models\Customer;
use App\Models\Invoice;
use App\Models\Log;
use App\Models\Payment;
use App\Models\Sales;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class Main extends Component
{
    use WithPagination;
    use WithFileUploads;

    public $model;
    public $name;
    public $customer;
    public $sales;
    public $payment;
    public $identity_picture;
    public $location_picture;


    public $perPage = 10;
    public $sortField = "id";
    public $sortAsc = false;
    public $search = '';

    protected $listeners = [ "deleteItem" => "delete_item", "addInvoice" => "add_invoice", "addPayment" => "add_payment", "acceptPayment" => "accept_payment", "declinePayment" => "decline_payment", "customerSuspend" => "customer_suspend", "customerIsolate" => "customer_isolate", "salesDecline" => "sales_decline", "salesAccept" => "sales_accept" ];

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortAsc = ! $this->sortAsc;
        } else {
            $this->sortAsc = true;
        }

        $this->sortField = $field;
    }

    public function get_pagination_data ()
    {
        switch ($this->name) {
            case 'user':
                $users = $this->model::search($this->search)
                    ->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc')
                    ->paginate($this->perPage);

                return [
                    "view" => 'livewire.table.user',
                    "users" => $users,
                    "data" => array_to_object([
                        'href' => [
                            'create_new' => route('admin.user.new'),
                            'create_new_text' => 'Buat User Baru',
                            'export' => '#',
                            'export_text' => 'Export'
                        ]
                    ])
                ];
                break;

            case 'member':
                $members = $this->model::search($this->search)
                    ->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc')
                    ->paginate($this->perPage);

                return [
                    "view" => 'livewire.table.member',
                    "members" => $members,
                    "data" => array_to_object([
                        'href' => [
                            'create_new' => route('admin.member.create'),
                            'create_new_text' => 'Buat Member Baru',
                            'export' => '#',
                            'export_text' => 'Export'
                        ]
                    ])
                ];
                break;

            case 'student':
                $students = $this->model::search($this->search)
                    ->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc')
                    ->paginate($this->perPage);

                return [
                    "view" => 'livewire.table.student',
                    "students" => $students,
                    "data" => array_to_object([
                        'href' => [
                            'create_new' => route('admin.student.create'),
                            'create_new_text' => 'Buat Mahasiswa Baru',
                            'export' => '#',
                            'export_text' => 'Export'
                        ]
                    ])
                ];
                break;

            case 'studentDetail':
                $studentDetails = $this->model::search($this->search)
                    ->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc')
                    ->paginate($this->perPage);

                return [
                    "view" => 'livewire.table.student-detail',
                    "studentDetails" => $studentDetails,
                    "data" => array_to_object([
                        'href' => [
                            'create_new' => route('admin.student.create'),
                            'create_new_text' => 'Buat Mahasiswa Baru',
                            'export' => '#',
                            'export_text' => 'Export'
                        ]
                    ])
                ];
                break;

            case 'offense':
                $offenses = $this->model::search($this->search)
                    ->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc')
                    ->paginate($this->perPage);

                return [
                    "view" => 'livewire.table.offense',
                    "offenses" => $offenses,
                    "data" => array_to_object([
                        'href' => [
                            'create_new' => route('admin.offense.create'),
                            'create_new_text' => 'Buat Jenis Pelanggaran',
                            'export' => '#',
                            'export_text' => 'Export'
                        ]
                    ])
                ];
                break;

            case 'addition':
                $additions = $this->model::search($this->search)
                    ->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc')
                    ->paginate($this->perPage);

                return [
                    "view" => 'livewire.table.addition',
                    "additions" => $additions,
                    "data" => array_to_object([
                        'href' => [
                            'create_new' => route('admin.addition.create'),
                            'create_new_text' => 'Buat Jenis Kepatuhan',
                            'export' => '#',
                            'export_text' => 'Export'
                        ]
                    ])
                ];
                break;

            case 'customer':
                $customers = $this->model::search($this->search)
                    ->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc')
                    ->paginate($this->perPage);

                return [
                    "view" => 'livewire.table.customer',
                    "customers" => $customers,
                    "data" => array_to_object([
                        'href' => [
                            'create_new' => route('admin.customer.create'),
                            'create_new_text' => 'Buat Customer Baru',
                            'export' => '#',
                            'export_text' => 'Export'
                        ]
                    ])
                ];
                break;

            case 'packetTag':
                $packetTags = $this->model::search($this->search)
                    ->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc')
                    ->paginate($this->perPage);

                return [
                    "view" => 'livewire.table.packet-tag',
                    "packetTags" => $packetTags,
                    "data" => array_to_object([
                        'href' => [
                            'create_new' => route('admin.packet-tag.create'),
                            'create_new_text' => 'Buat Paket Baru',
                            'export' => '#',
                            'export_text' => 'Export'
                        ]
                    ])
                ];
                break;

            case 'log':
                $logs = $this->model::search($this->search)
                    ->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc')
                    ->paginate($this->perPage);

                return [
                    "view" => 'livewire.table.log',
                    "logs" => $logs,
                    "data" => array_to_object([
                        'href' => [
                            'export' => '#',
                            'export_text' => 'Export'
                        ]
                    ])
                ];
                break;

            case 'invoice':
                $invoices = $this->model::search($this->search)
                    ->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc')
                    ->paginate(100);
//                dd($this->perPage);

                return [
                    "view" => 'livewire.table.invoice',
                    "invoices" => $invoices,
                    "data" => array_to_object([
                        'href' => [
                            'create_new_invoice' => route('admin.create_with_id', intval(substr(url()->current(), -12))),
                            'create_new_text' => 'Buat invoice Baru',
                            'export' => '#',
                            'export_text' => 'Export'
                        ]
                    ])
                ];
                break;

            case 'payment':
                $payments = $this->model::search($this->search)
                    ->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc')
                    ->paginate(100);

                return [
                    "view" => 'livewire.table.payment',
                    "payments" => $payments,
                    "data" => array_to_object([
                        'href' => [
                            'create_new_payment' => route('admin.payment_create_with_id', intval(substr(url()->current(), -12))),
                            'create_new_text' => 'Buat Pembayaran Baru',
                            'export' => '#',
                            'export_text' => 'Export'
                        ]
                    ])
                ];
                break;

            case 'sale':
                $sales = $this->model::search($this->search)
                    ->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc')
                    ->paginate($this->perPage);

//                dd($sales);
                return [
                    "view" => 'livewire.table.sales',
                    "sale" => $sales,
                    "data" => array_to_object([
                        'href' => [
                            'create_new' => route('admin.sales.create'),
                            'create_new_text' => 'Buat Customer Sales Baru',
                            'export' => '#',
                            'export_text' => 'Export'
                        ]
                    ])
                ];
                break;


            default:
                # code...
                break;
        }
    }

    public function delete_item ($id)
    {
        $data = $this->model::find($id);
//        dd($data['customer_id']);

        if (!$data) {
            $this->emit("deleteResult", [
                "status" => false,
                "message" => "Gagal menghapus data " . $this->name
            ]);
            return;
        }

        $data->delete();
        $this->emit("deleteResult", [
            "status" => true,
            "message" => "Data " . $this->name . " berhasil dihapus!"
        ]);

        $this->log = [
            'user_id' => Auth::id(),
            'access' => 'delete',
            'activity' => 'delete id '.$id.' from '.$this->name.' table.'
        ];

        Log::create($this->log);

        if ($this->name == 'invoice') {
            $validation = Invoice::whereCustomerId($data['customer_id'])->whereStatus('unpaid')->count();
            $customer = Customer::findOrFail($data['customer_id']);

            if ($validation == 0) {
                $this->customer['total_bill'] = 0;
                $this->customer['status'] = 'paid';
            } else {
                $this->customer['total_bill'] = $customer['total_bill'] - $customer['bill'];
            }
            Customer::find($data['customer_id'])->update($this->customer);

            sleep(2);
            return redirect(url()->previous());
        } else if ($this->name == 'payment') {
            sleep(2);
            return redirect(url()->previous());
        }

    }

    public function add_invoice ($id)
    {
        $data = $this->model::find($id);

        $pdf = Pdf::loadView('invoices.invoice', compact('data'));

        if (!$data) {
            $this->emit("addInvoiceResult", [
                "status" => false,
                "message" => "Gagal menghapus data " . $this->name
            ]);
            return;
        }

        $this->emit("addInvoiceResult", [
            "status" => true,
            "message" => "Data invoice" . $this->name . " berhasil ditambah!"
        ]);

        $this->log = [
            'user_id' => Auth::id(),
            'access' => 'create',
            'activity' => 'create id '.$id.' from '.$this->name.' table.'
        ];

//        Log::create($this->log);

        return $pdf->stream('invoice-'.$data['name'].'-'.$data['selected_date'].'.pdf');

    }

    public function add_payment ($id)
    {
        $data = $this->model::find($id);

        $this->customer['total_bill'] = 0;
        $this->customer['amount'] = 0;
        $this->customer['status'] = 'paid';
        Customer::find($id)->update($this->customer);

        if (!$data) {
            $this->emit("addPaymentResult", [
                "status" => false,
                "message" => "Gagal menambah data " . $this->name
            ]);
            return;
        }

        $this->emit("addPaymentResult", [
            "status" => true,
            "message" => "Data pembayaran " . $this->name . " berhasil ditambah!"
        ]);

        $this->log = [
            'user_id' => Auth::id(),
            'access' => 'create',
            'activity' => 'create payment for Customer id '.$id.' from '.$this->name.' table.'
        ];

//        Log::create($this->log);

    }
    public function accept_payment ($id)
    {
        $data = $this->model::find($id);
        $this->payment['status'] = 'accept';

        $invoice = Invoice::whereCustomerId($data['customer_id'])->whereStatus('unpaid')->pluck('id')->all();

        $bulanList = Invoice::selectRaw('DISTINCT YEAR(selected_date) as tahun, MONTHNAME(selected_date) as bulan')
            ->orderBy('tahun', 'asc')
            ->orderBy('bulan', 'asc')
            ->get()
            ->map(function ($item) {
                return $item->bulan . ' ' . $item->tahun;
            });

        $bulanList = $bulanList->toArray();
        $hasilAkhir = implode(', ', $bulanList);

        $this->payment['description'] = $hasilAkhir;

//        dd($this->payment);
        Payment::find($id)->update($this->payment);

        $total_bill = Customer::find($data['customer_id']);

        $this->customer['total_bill'] = $total_bill['total_bill'] - $data['nominal'];

        if ($this->customer['total_bill'] <= 0) {
            $this->customer['status'] = 'paid';
            Invoice::whereIn('id', $invoice)->update(['status' => 'paid']);
        }

        Customer::find($data['customer_id'])->update($this->customer);

        if (!$data) {
            $this->emit("acceptPaymentResult", [
                "status" => false,
                "message" => "Gagal menambah data " . $this->name
            ]);
            return;
        }

        $this->emit("acceptPaymentResult", [
            "status" => true,
            "message" => "Data pembayaran " . $this->name . " berhasil diterima!"
        ]);

        $this->log = [
            'user_id' => Auth::id(),
            'access' => 'Accept',
            'activity' => 'Accept payment for Payment id '.$this->id.' from '.$this->name.' table.'
        ];

        Log::create($this->log);

    }

    public function decline_payment ($id)
    {
        $data = $this->model::find($id);
        $this->payment['status'] = 'decline';

        Payment::find($id)->update($this->payment);

        if (!$data) {
            $this->emit("declinePaymentResult", [
                "status" => false,
                "message" => "Gagal menambah data " . $this->name
            ]);
            return;
        }

        $this->emit("declinePaymentResult", [
            "status" => true,
            "message" => "Data pembayaran " . $this->name . " berhasil ditolak!"
        ]);

        $this->log = [
            'user_id' => Auth::id(),
            'access' => 'Decline',
            'activity' => 'Decline payment for Payment id '.$this->id.' from '.$this->name.' table.'
        ];

        Log::create($this->log);

    }

    public function customer_suspend ($id)
    {
        $data = $this->model::find($id);

        if ($data['status'] == 'suspend') {
            $invoice = Invoice::whereCustomerId($data['id'])->whereStatus('unpaid')->count();

            if ($invoice == 0){
                $this->customer['status'] = 'paid';
            } else {
                $this->customer['status'] = 'unpaid';
            }

        } else {
            $this->customer['status'] = 'suspend';
        }

        Customer::find($id)->update($this->customer);

        if (!$data) {
            $this->emit("customerSuspendResult", [
                "status" => false,
                "message" => "Gagal menambah data " . $this->name
            ]);
            return;
        }

        if ($data['status'] == 'suspend') {
            $this->emit("customerSuspendResult", [
                "status" => true,
                "message" => "Pelanggan " . $this->name . " berhasil unsuspend!"
            ]);

            $this->log = [
                'user_id' => Auth::id(),
                'access' => 'Unsuspend',
                'activity' => 'Unsuspend customer id '.$data['id'].' from '.$this->name.' table.'
            ];
        } else {
            $this->emit("customerSuspendResult", [
                "status" => true,
                "message" => "Pelanggan " . $this->name . " berhasil disuspend!"
            ]);

            $this->log = [
                'user_id' => Auth::id(),
                'access' => 'Suspend',
                'activity' => 'Suspend customer id '.$data['id'].' from '.$this->name.' table.'
            ];
        }

        Log::create($this->log);

    }

    public function customer_isolate ($id)
    {
        $data = $this->model::find($id);

        $this->customer['status'] = 'isolated';
        $this->customer['isolate_date'] = Carbon::now();

        Customer::find($id)->update($this->customer);

        if (!$data) {
            $this->emit("customerIsolatedResult", [
                "status" => false,
                "message" => "Gagal menambah data " . $this->name
            ]);
            return;
        }

        $this->emit("customerIsolatedResult", [
            "status" => true,
            "message" => "Pelanggan " . $this->name . " berhasil diisolir!"
        ]);
        $this->log = [
            'user_id' => Auth::id(),
            'access' => 'Isolate',
            'activity' => 'Isolate customer id '.$data['id'].' from '.$this->name.' table.'
        ];
        Log::create($this->log);
    }

    public function sales_decline ($id)
    {
        $data = $this->model::find($id);
        $this->sales['status'] = 'decline';

        Sales::find($id)->update($this->sales);

        if (!$data) {
            $this->emit("salesDeclineResult", [
                "status" => false,
                "message" => "Gagal menambah data " . $this->name
            ]);
            return;
        }

        $this->emit("salesDeclineResult", [
            "status" => true,
            "message" => "Data calon pelanggan " . $this->name . " berhasil ditolak!"
        ]);

        $this->log = [
            'user_id' => Auth::id(),
            'access' => 'Sales Decline',
            'activity' => 'Decline customer for Sales id '.$this->id.' from '.$this->name.' table.'
        ];

        Log::create($this->log);

    }

    public function sales_accept ($id)
    {
        $data = $this->model::find($id);
        $this->customer['id'] = Customer::latest('id')->value('id') + 1;
        $this->customer['name'] = $data['name'];
        $this->customer['address'] = $data['address'];
        $this->customer['phone_number'] = $data['phone_number'];
        $this->customer['packet_tag_id'] = (int)$data['packet_tag_id'];
        $this->customer['identity_picture'] = $data['identity_picture'];
        $this->customer['location_picture'] = $data['location_picture'];
        $this->customer['longitude'] = $data['longitude'];
        $this->customer['latitude'] = $data['latitude'];
        $this->customer['identity_number'] = $data['identity_number'];
        $this->customer['bill'] = $data['bill'];

        $this->customer['user_id'] = Auth::id();

        Customer::create($this->customer);

        #menghapus data
        $data->delete();
        $this->temp = Customer::latest('id')->first();

        $this->log = [
            'user_id' => Auth::id(),
            'access' => 'create',
            'activity' => 'create customer id '.$this->temp['id'].' in Customer table'
        ];

        Log::create($this->log);

        $this->emit("salesAcceptResult", [
            "status" => true,
            "message" => "Data calon pelanggan " . $this->name . " berhasil diterima!"
        ]);
    }

    public function render()
    {
        $data = $this->get_pagination_data();

        return view($data['view'], $data);
    }
}
