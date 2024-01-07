<?php

namespace App\Http\Controllers\Invoice;

use App\Http\Controllers\Controller;
use DateTime;
use DateTimeZone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;
use Inertia\Inertia;

class InvoiceDataController extends Controller
{
    public function index()
    {
        $currentMonth = $this->currentMonth();
        $currentYear = $this->currentYear();

        $firstLastDayOfMonth = $this->firstLastDayOfMonth();

        $firstDayOfMonth = $firstLastDayOfMonth['firstDayOfMonth'];
        $lastDayOfMonth = $firstLastDayOfMonth['lastDayOfMonth'];
        $lastDayOfMonthForInput = $firstLastDayOfMonth['lastDayOfMonthForInput'];
        $day10 = $firstLastDayOfMonth['day10'];

        return Inertia::render('Dashboard', compact(
            'currentMonth',
            'currentYear',
            'firstDayOfMonth',
            'lastDayOfMonth',
            'lastDayOfMonthForInput',
            'day10'
        ));
    }

    protected function firstLastDayOfMonth()
    {
        $now = new DateTime('now');

        $firstDayOfMonth = $now->modify('first day of this month')->format('d.m.Y');
        $lastDayOfMonth = $now->modify('last day of this month')->format('d.m.Y');

        // get 10th day of next month
        $nextMonth = new DateTime('now');
        $nextMonth->modify('+1 month')->modify('first day of this month');
        $day10 = $nextMonth->modify('+9 days')->format('Y-m-d');

        // uses different format according to input field requirments
        $lastDayOfMonthForInput = $now->modify('last day of this month')->format('Y-m-d');


        return  [
            'firstDayOfMonth' => $firstDayOfMonth,
            'lastDayOfMonth' => $lastDayOfMonth,
            'lastDayOfMonthForInput' => $lastDayOfMonthForInput,
            'day10' => $day10,
        ];
    }

    protected function currentMonth()
    {
        return (new DateTime('now'))->format('m');
    }

    protected function currentYear()
    {
        return (new DateTime('now'))->format('y');
    }
}
