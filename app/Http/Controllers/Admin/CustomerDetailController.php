<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Sales;
use Illuminate\Http\Request;

class CustomerDetailController extends Controller
{
    public function customer_detail($id) {
        if ($id > 350902) {
            $customer = Customer::whereId($id)->get();
            $name = Customer::whereId($id)->first()->name;
        } else {
            $customer = Sales::whereId($id)->get();
            $name = Sales::whereId($id)->first()->name;
        }

        return view('pages.customer.detail.index', compact('name', 'customer'));
    }
}
