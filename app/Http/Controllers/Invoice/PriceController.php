<?php

namespace App\Http\Controllers\Invoice;

use App\Http\Controllers\Controller;
use App\Models\Price;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class PriceController extends Controller
{
    public function index()
    {
        return Inertia::render('FirstTimePriceTaxData');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'price' => ['required', 'numeric', 'regex:/^\d{1,4}(\.\d{1,2})?$/'],
            'tax' => ['required', 'integer']
        ]);

        $priceTax = new Price($validated);

        $user_id = Auth::user()->id;

        $priceTax->user_id = $user_id;
        $priceTax->save();

        return redirect()->route('invoiceData');
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'price' => ['required', 'numeric', 'regex:/^\d{1,4}(\.\d{1,2})?$/'],
            'tax' => ['required', 'integer']
        ]);

        $request->user()->price->fill($validated);
        $request->user()->price->save();

        return redirect()->back()->with('message', 'Dane poprawnie zaktualizowane.');
    }
}
