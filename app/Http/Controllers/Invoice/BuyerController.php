<?php

namespace App\Http\Controllers\Invoice;

use App\Http\Controllers\Controller;
use App\Http\Requests\SellerBuyerRequest;
use App\Models\Buyer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class BuyerController extends Controller
{
    public function index()
    {
        return Inertia::render('FirstTimeInvoiceDataBuyer');
    }

    public function store(SellerBuyerRequest $request)
    {
        $validated = $request->validated();

        // get the authenticated user's id
        $user_id = Auth::id();

        // create a new seller instance with the user_id
        $buyer = new Buyer($validated);
        $buyer->user_id = $user_id;

        $buyer->save();

        return redirect()->route('invoiceData');
    }

    public function update(SellerBuyerRequest $request)
    {
        $validated = $request->validated();

        $request->user()->buyer->fill($validated);

        $request->user()->buyer->save();

        return redirect()->back()->with('message', 'Dane poprawnie zaktualizowane.');
    }
}
