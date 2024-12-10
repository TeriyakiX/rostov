<?php

namespace App\Http\Controllers;

use App\Models\OfficeHour;
use Illuminate\Http\Request;

class OfficeHoursController extends Controller
{
    public function index()
    {
        $officeHours = OfficeHour::all();
        return view('layouts._footer', compact('officeHours'));
    }
}
