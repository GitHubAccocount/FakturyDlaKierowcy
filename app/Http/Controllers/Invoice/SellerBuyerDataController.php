<?php

namespace App\Http\Controllers\Invoice;

use App\Http\Controllers\Controller;
use Inertia\Inertia;

class SellerBuyerDataController extends Controller
{
    public function index()
    {
        return Inertia::render('InvoiceData');
    }
}
