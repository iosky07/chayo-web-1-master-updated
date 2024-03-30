<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\DateMonth;
use App\Models\Invoice;
use App\Models\Log;
use App\Models\PacketTag;
use App\Models\RouterosAPI;
use Carbon\Carbon;
use Cassandra\Custom;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerController extends Controller
{
    public $date_month;

    public function index()
    {
        $current_date = Carbon::now();
        $last_month = DateMonth::latest()->first();
        $last_month = Carbon::parse($last_month['save_date_per_month']);
        $daysInLastMonth = $last_month->daysInMonth;
        $firstDayOfMonth = $last_month->firstOfMonth();
        $daysDifference = $current_date->diffInDays($firstDayOfMonth);
//        dd($daysDifference);

        $customers = Customer::all();

        if ($daysDifference > $daysInLastMonth) {
            foreach ($customers as $customer) {
                if ($customer['status'] != 'suspend') {
                    Carbon::setLocale('id');

                    try {
                        $last_invoice_date = Invoice::whereCustomerId($customer['id'])->latest()->first();
                        $last_invoice_date = Carbon::parse($last_invoice_date['selected_date']);
                        $invoice_month = $last_invoice_date->format('m');
                        $invoice_year = $last_invoice_date->format('Y');
                        $data_null = False;
                    } catch (\Exception $e) {
                        $data_null = True;
                    }

                    $current_date = Carbon::now();
                    $current_month = $current_date->format('m');
                    $current_year = $current_date->format('Y');
                    if ($data_null) {

                        $id = $customer['id'];

                        $this->invoice['selected_date'] = $current_date;
                        $this->invoice['customer_id'] = $id;

                        Invoice::create($this->invoice);
                        $invoice_amount = Invoice::whereCustomerId($id)->whereStatus('unpaid')->count();
                        $customer = Customer::findOrFail($id);

                        $this->customer['status'] = 'unpaid';
                        $this->customer['total_bill'] = $customer['bill'] * $invoice_amount;

                        Customer::find($id)->update($this->customer);
                    } else {
                        if ($current_year == $invoice_year) {
                            if ($current_month > $invoice_month) {
//                                dd('tengah'.$customer['id']);

                                $id = $customer['id'];

                                $this->invoice['selected_date'] = $current_date;
                                $this->invoice['customer_id'] = $id;

                                Invoice::create($this->invoice);
                                $invoice_amount = Invoice::whereCustomerId($id)->whereStatus('unpaid')->count();
                                $customer = Customer::findOrFail($id);

                                $this->customer['status'] = 'unpaid';
                                $this->customer['total_bill'] = $customer['bill'] * $invoice_amount;

                                Customer::find($id)->update($this->customer);
                            }
                        } elseif ($current_year > $invoice_year) {
                            $id = $customer['id'];

                            $this->invoice['selected_date'] = $current_date;
                            $this->invoice['customer_id'] = $id;

                            Invoice::create($this->invoice);
                            $invoice_amount = Invoice::whereCustomerId($id)->whereStatus('unpaid')->count();
                            $customer = Customer::findOrFail($id);

                            $this->customer['status'] = 'unpaid';
                            $this->customer['total_bill'] = $customer['bill'] * $invoice_amount;

                            Customer::find($id)->update($this->customer);
                        }
                    }
                }

            }
//            $current_date = Carbon::parse("2024-01-12 00:00:00");
            $this->date_month['save_date_per_month'] = $current_date->firstOfMonth();
            DateMonth::create($this->date_month);
        }

//        $ip = '103.164.192.69';
//        $user = 'Arie';
//        $pass = 'Dafiq190701';
//        $API = new RouterosAPI();
//        $API->debug('false');
//
//        if ($API->connect($ip, $user, $pass)) {
//            $user_on = $API->comm('/ppp/active/print');
//            for ($i=0; $i <= count($user_on); $i++) {
////                dd($i);
//                $API->comm('/ppp/active/remove', array('numbers' => $i));
//            }
//        } else {
//            return 'Koneksi Gagal';
//        }
//        dd($user_on);
//        foreach ($user_on as $item)

        #mengecek bagian isolir
        if ($daysDifference > 20) {
            foreach ($customers as $customer) {
                $id = $customer['id'];
                if ($customer['status'] == 'unpaid') {
                    $this->customer['status'] = 'isolate';
                    $this->customer['isolate_date'] = Carbon::now();

                    //

                    Customer::find($id)->update($this->customer);
                    $this->log = [
                        'user_id' => Auth::id(),
                        'access' => 'Isolate (auto)',
                        'activity' => 'Auto isolate customer id '.$id.' from customer table.'
                    ];
                    Log::create($this->log);
                }
            }
        }

        foreach ($customers as $customer) {
            $id = $customer['id'];
            if($customer['status'] == 'isolate') {
                $days_diff = $current_date->diffInDays($customer['isolate_date']);
                if ($days_diff >= 60) {
                    $this->customer['status'] = 'suspend';
                    $this->customer['isolate_date'] = NULL;

                    Customer::find($id)->update($this->customer);

                    $this->log = [
                        'user_id' => Auth::id(),
                        'access' => 'Suspend (auto)',
                        'activity' => 'Auto suspend customer id '.$id.' from customer table.'
                    ];
                    Log::create($this->log);
                }
            }
        }


        $now = Carbon::now()->toDate();
        return view('pages.customer.index', [
            'cust' => Customer::class
        ], compact('now'));
    }

    public function create()
    {
        return view('pages.customer.create');
    }

    public function edit($id)
    {
        $packet_tags_option = PacketTag::all();
//        $details = PacketTag::whereStudentId($id)->get();
        return view('pages.customer.edit', compact('id', 'packet_tags_option'));
    }

    public function new_month() {
        Carbon::setLocale('id');

        try {
            $last_invoice_date = Invoice::whereCustomerId($id)->latest()->first();
            $last_invoice_date = Carbon::parse($last_invoice_date['selected_date']);
            $invoice_month = $last_invoice_date->format('m');
            $invoice_year = $last_invoice_date->format('Y');
            $data_null = False;
        } catch (\Exception $e) {
            $data_null = True;
        }

        $current_date = Carbon::now();
        $current_month = $current_date->format('m');
        $current_year = $current_date->format('Y');
        if ($data_null) {

            $getUrl = url()->current();
            $id = intval(substr($getUrl, -12));

            $this->invoice['selected_date'] = $current_date;
            $this->invoice['customer_id'] = $id;

            Invoice::create($this->invoice);
            $invoice_amount = Invoice::whereCustomerId($id)->whereStatus('unpaid')->count();
            $customer = Customer::findOrFail($id);

            $this->customer['status'] = 'unpaid';
            $this->customer['total_bill'] = $customer['bill'] * $invoice_amount;

            Customer::find($id)->update($this->customer);
        } else {
            if ($current_year == $invoice_year) {
                if ($current_month > $invoice_month) {
                    $getUrl = url()->previous();
                    $id = intval(substr($getUrl, -12));

                    $this->invoice['selected_date'] = $current_date;
                    $this->invoice['customer_id'] = $id;

                    Invoice::create($this->invoice);
                    $invoice_amount = Invoice::whereCustomerId($id)->whereStatus('unpaid')->count();
                    $customer = Customer::findOrFail($id);

                    $this->customer['status'] = 'unpaid';
                    $this->customer['total_bill'] = $customer['bill'] * $invoice_amount;

                    Customer::find($id)->update($this->customer);
                }
            } elseif ($current_year > $invoice_year) {
                $getUrl = url()->previous();
                $id = intval(substr($getUrl, -12));

                $this->invoice['selected_date'] = $current_date;
                $this->invoice['customer_id'] = $id;

                Invoice::create($this->invoice);
                $invoice_amount = Invoice::whereCustomerId($id)->whereStatus('unpaid')->count();
                $customer = Customer::findOrFail($id);

                $this->customer['status'] = 'unpaid';
                $this->customer['total_bill'] = $customer['bill'] * $invoice_amount;

                Customer::find($id)->update($this->customer);
            }
        }
    }

}
