<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Sales;
use Illuminate\Http\Request;

class SalesController extends Controller
{
    public function index()
    {
        return view('pages.sales.index', [
            'sales' => Sales::class
        ]);

    }

    public function create()
    {
        return view('pages.sales.create');
    }

    public function edit($id)
    {
        return view('pages.sales.edit', compact('id'));
    }
}
