<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PacketTag;
use Illuminate\Http\Request;

class PacketTagController extends Controller
{
    public function index()
    {
        return view('pages.packet-tag.index', [
            'pack' => PacketTag::class
        ]);
    }

    public function create()
    {
        return view('pages.packet-tag.create');
    }

    public function edit($id)
    {
        return view('pages.packet-tag.edit', compact('id'));
    }
}
