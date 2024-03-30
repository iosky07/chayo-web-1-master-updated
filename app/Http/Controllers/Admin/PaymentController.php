<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Invoice;
use App\Models\Payment;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use DateTime;

class PaymentController extends Controller
{
    public $customer;

    public function index()
    {
        return view('pages.payment.index', [
            'pay' => Payment::class
        ]);
    }

    public function payment_index_with_id($id)
    {
        $name = Customer::whereId($id)->value('name');
        return view('pages.payment.index', [
            'pay' => Payment::class
        ], compact('id', 'name'));
    }

    public function payment_create_with_id($id)
    {
        $action = 'create';
        return view('pages.payment.create', compact('id'));
    }

    public function edit($id)
    {
        return view('pages.payment.edit', compact('id'));
    }

    public function generate_payment($paymentId)
    {
        $getUrl = url()->previous();
        $id = intval(substr($getUrl, -12));
        $customer = Customer::findOrFail($id);
        $payment = Payment::findOrFail($paymentId);

        $dateString = $payment['updated_at'];
        $dateTime = new DateTime($dateString);

        $formattedDate = $dateTime->format('F Y');

        $pdf = Pdf::loadView('file_print.pdf', compact('customer', 'id', 'payment', 'formattedDate'));

        return $pdf->stream('receipt-'.strtolower($customer['name']).'-'.str_replace(' ', '-', strtolower($formattedDate)).'.pdf');
    }
}
