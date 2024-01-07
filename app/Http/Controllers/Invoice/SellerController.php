<?php

namespace App\Http\Controllers\Invoice;

use App\Http\Controllers\Controller;
use App\Http\Requests\SellerBuyerRequest;
use App\Models\Seller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class SellerController extends Controller
{
    public function index()
    {
        return Inertia::render('FirstTimeInvoiceDataSeller');
    }

    public function store(SellerBuyerRequest $request)
    {
        $validated = $request->validated();

        // get the authenticated user's id
        $user_id = Auth::id();

        // create a new seller instance with the user_id
        $seller = new Seller($validated);
        $seller->user_id = $user_id;

        $seller->save();

        return redirect()->route('invoiceData');
    }

    public function update(SellerBuyerRequest $request)
    {
        $validated = $request->validated();

        $request->user()->seller->fill($validated);

        $request->user()->seller->save();

        return redirect()->back()->with('message', 'Dane poprawnie zaktualizowane.');
    }
}
