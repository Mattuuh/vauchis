<?php

// use App\Http\Controllers\Controller;

namespace App\Http\Controllers;
use Illuminate\Http\Request;

class VoucherController extends Controller
{
    public function create()
    {
        // Idealmente traer datos reales de DB
        return view('vouchers.create', [
            'commerces' => [],
            'categories' => [],
            'influencers' => [],
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required',
            'type' => 'required',
            'fixed_amount' => 'required|numeric',
            'promo_price' => 'required|numeric',
            'currency' => 'required',
            'start_date' => 'required|date',
        ]);

        // Guardado (ejemplo)
        // Voucher::create($request->all());

        return redirect()->route('vouchers.create')
            ->with('success', 'Voucher creado correctamente');
    }
}