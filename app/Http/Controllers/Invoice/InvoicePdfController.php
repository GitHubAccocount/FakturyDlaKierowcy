<?php

namespace App\Http\Controllers\Invoice;

use App\Http\Controllers\Controller;
use App\Http\Requests\InvoicePdfRequest;
use Illuminate\Http\Request;
use Inertia\Inertia;

class InvoicePdfController extends Controller
{
    public function index()
    {
        return Inertia::render('Invoice');
    }

    public function collectData(InvoicePdfRequest $request)
    {
        $request->validated();
        $data = $request->all();

        return Inertia::render('Invoice', [
            'data' => $data,
        ]);
    }
}
